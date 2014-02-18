/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity,ajaxurl,tinymce,JSON,QTags */

(function($) {
	
	
	var w = 940;
	var h = 300;
	var radio;
	var richedit;
	var preview,iframe;
	var img;
	
	var mainTab, editTab;
	var activeTab;
	var jwin = $(window);
	var origWPSetThumbnailID;
	var selected;
	var items;
	var autoSave = false;
	var captions;
	var needUpdate = false;
	var timer = 0;
	var focused = false;
	var mbox;
	
	function layout() {
		if (radio.filter(":checked").val() != "normal") {
			richedit.hide();
			mbox.show();
		} else {
			richedit.show();
			mbox.hide();
		}
	}
	
	function evHandler(e) {
		switch (e.type) {
		case "click":
			if (e.shiftKey) {
				pos(e.pageX,e.pageY,true);
				return false;
			}
			break;
		case "keydown":
			if (!focused) {
				return true;
			}
			switch (e.keyCode) {
			case 37:
				// left
				pos(e.shiftKey ? -10 : -1,false);
				return false;
			case 38:
				// up
				pos(false,e.shiftKey ? -10 : -1);
				return false;
			case 39:
				// right
				pos(e.shiftKey ? +10 : +1,false);
				return false;
			case 40:
				// down
				pos(false,e.shiftKey ? +10 : +1);
				return false;
			}
		}
	}
	
	function focusHandler(e) {
		focused = (e.type === "mouseenter");
	}

	
	function pos(x,y,absolute) {
		if (selected) {
			var xf = selected.find('input[data-name="x"]');
			var yf = selected.find('input[data-name="y"]');
			if (absolute) {
				xf.val(x);
				yf.val(y);
			} else if (y === false) {
				xf.val(parseInt(xf.val(),10)+x);
			} else if (x === false) {
				yf.val(parseInt(yf.val(),10)+y);
			}
			previewCaptions();
		}
	}
	
	function itemsHandler(e,data) {
		switch (e.type) {
		case "add":
			edit(data.el);
			previewCaptions();
			break;
		case "delete":
			if (selected && (data.el.attr("data-id") == selected.attr("data-id"))) {
				selected = false;
				edit(items.find(".pe_fields_item_item:first-child"));
			} else {
				edit(selected);
			}
			if (!selected) {
				showTab("main");
			}

		}
		return false;
	}
		
	function refreshImage(data) {
		var url = false;
		try {
			url = data.resized[0]; 
		} catch (x) {}
		if (url) {
			img.attr("src",url);			
		}
	}

	
	function previewImage(url,isID) {
		if (url) {
			if (!img) {
				img = $('<img class="pe_layer_builder_background"/>');
				preview.append(img);
			}
			
			jQuery.post(
				ajaxurl,
				{
					action : "pe_theme_image_resize",
					w:w,
					h:h,
					isID: isID,
					img : url
				},
				refreshImage
			);
			//img.attr("src",url);
		}
	}
	
	function previewCaptions() {
		needUpdate = true;
		clearTimeout(timer);
		timer = setTimeout(renderCaptions,50);
	}
	
	function renderCaptions() {
		if (!needUpdate) {
			return;
		}
		needUpdate = false;
		var i,f,field,fields,caption,captions_data = items.find(".pe_fields_item_item");
		var output = preview.find("div.pe_layer_builder_preview_captions");
		var template = '<div class="caption %0" style="position:absolute;width:auto;left:%1px;top:%2px">%3</div>';
		if (output.length === 0) {
			output = $('<div class="pe_layer_builder_preview_captions"></div>');
			output.css({
				"overflow" : "hidden",
				"position" : "absolute",
				"top": 0,
				"left": 0
			});
			output.width(w).height(h);
			preview.append(output);
		}
		output.empty();
		captions = [];
		
		for (i=0;i<captions_data.length;i++) {
			fields = items.find(captions_data[i]);
			caption = {id: fields.attr("data-id")};
			fields = fields.find("input,textarea,select");
			for (f=0;f<fields.length;f++) {
				field = items.find(fields[f]);
				caption[field.attr("data-name")] = field.val();
			}
			captions.push(caption);
			output.append(template.format(caption.transition,caption.x,caption.y,caption.content));
		}
	}
	
	
	function applyStyles(data) {
		iframe.contents().find("head").append($(data).filter("link, style"));
		preview.width(w).height(h);
		preview.css({
			background: "white",
			overflow: "hidden"
		});
		
		iframe.contents().find("body").css({margin: 0,padding: 0}).append(preview);
		
		previewImage(iframe.attr("data-img"));
		preview.bind("click",evHandler);
		$(document).bind("keydown",evHandler);
	}

	function showTab(which) {
		activeTab = which;
		switchTab();
		//setTimeout(switchTab,100);
	}
	
	function switchTab(noscroll) {
		
		if (activeTab === "edit") {
			mainTab.width(540);
			editTab.css("min-height",mainTab.find(".pe_field_items").height()-73);
			editTab.removeClass("ui-tabs-hide");
			//mainTab.addClass("ui-tabs-hide");
		} else {
			editTab.addClass("ui-tabs-hide");
			mainTab.width(w);
			mainTab.removeClass("ui-tabs-hide");
		}
		if (noscroll === false) {
			return;
		}
		
	}
	
	function findRow(el) {
		return mainTab.find(el).closest(".pe_fields_item_item");
	}

	function editItem(el) {
		autoSave = false;
		var i,editField,field,fields = el.find("input,select,textarea");
		for (i=0;i<fields.length;i++) {
			field = el.find(fields[i]);
			editField = editTab.find('[data-name="%0"]'.format(field.attr("data-name")));
			if (editField.length > 0) {
				editField.val(field.val()).triggerHandler("change");
			}
		}
		autoSave = true;
	}
	
	function saveItem(el) {
		autoSave = false;
		var i,editField,field,fields = editTab.find("input,select,textarea");
		for (i=0;i<fields.length;i++) {
			editField = editTab.find(fields[i]);
			field = el.find('[data-name="%0"]'.format(editField.attr("data-name")));
			if (field.length > 0) {
				field.val(editField.val()).triggerHandler("change");
			}
		}
		autoSave = true;
	}
	
	function edit(el) {
		if (!el || el.length === 0) {
			return false;
		}
		mainTab.find(".pe_fields_item_item").removeClass("pe_item_active");
		if (selected) {
			saveItem(selected);
		}
		selected = findRow(el).addClass("pe_item_active");
		editItem(selected);
		
		showTab("edit");
		return false;
	}
	
	function editHandler(e) {
		edit(e.currentTarget);
		return false;
	}
	
	function saveHandler(e) {
		if (!autoSave || !selected) {
			return;
		}
		save();
		previewCaptions();
	}
	
	function save() {
		saveItem(selected);
		return false;
	}
	
	function WPSetThumbnailID(id) {
		origWPSetThumbnailID(id);
		previewImage(id,true);
	}
	
	function featuredImage() {
		$("#set-post-thumbnail").trigger("click");
		return false;
	}

	
	function init() {
		$('label[for="post-format-gallery"]').text("Layers");
		richedit = $("#postdivrich");
		mbox = $("#pe_theme_meta_layers");
		radio = $("#pe_theme_meta_format input");
		iframe = $("#pe_layer_builder_iframe").css("overflow","hidden");
		w = parseInt(iframe.attr("data-w"),10);
		h = parseInt(iframe.attr("data-h"),10);
		iframe.width(w).height(h);
		iframe.css("border","1px dotted gray");
		
		iframe.parent().find("input.ob_button").click(featuredImage);
		
		preview = $("<div class=\"pe_layer_builder_preview\"/>");
		$.get(iframe.attr("data-home"),applyStyles);
		//$("#post-formats-select").change(layout).triggerHandler("change");
		radio.change(layout).triggerHandler("change");
		
		$("#pe_theme_meta_layers__tab_preview").addClass("ui-tabs-panel");
		mainTab = $("#pe_theme_meta_layers__tab_main");
		editTab = $("#pe_theme_meta_layers__tab_edit");
		
		$("#pe_theme_meta_layers__tab_preview").css({"padding-bottom": 0});
		
		mainTab.css({"padding-top": 0,"width": w}).addClass("ui-tabs-panel");
		editTab.css({"padding-top": 0,"width": w}).addClass("ui-tabs-panel");
		mainTab.delegate("a.edit-inline","click",editHandler);
		
		$("#pe_theme_meta_layers__saveCaption_").click(save);
		
		origWPSetThumbnailID = window.WPSetThumbnailID;
		window.WPSetThumbnailID = WPSetThumbnailID;
		
		showTab("main");	
		
		items = $("#pe_theme_meta_layers__captions_").bind("add.pixelentity delete.pixelentity",itemsHandler);
		items.bind("sorted.pixelentity",previewCaptions);
		edit(items.find(".pe_fields_item_item:first-child"));
		editTab.find("input,select,textarea").bind("change focusout keydown",saveHandler);
		mainTab.find("input,select,textarea").bind("change focusout keydown",previewCaptions);
		editTab.closest(".postbox").bind("mouseenter mouseleave",focusHandler);
		previewCaptions();
		
		
	}
	
	
	
	$(init);

}(jQuery));


