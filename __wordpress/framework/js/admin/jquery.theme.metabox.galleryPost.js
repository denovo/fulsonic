(function ($) {
	/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
	/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity */
	
	$.pixelentity = $.pixelentity || {version: '1.0.0'};
	
	$.pixelentity.peMetaboxGalleryPost = {	
		conf: {
			api: true,
			tag: "video"
		} 
	};
	
	function PeMetaboxGalleryPost(target, conf) {
		
		var id= conf.id ? conf.id : target.parents(".postbox").attr("id")+"_";
		var type=target.find("#%0_type_".format(id));
		var title=target.find("#%0_title__buttonset".format(id)).parents("div.option");
		var titleField=target.find("#%0_title__0, #%0_title__1, #%0_title__2".format(id));
		var custom=target.find("#%0_custom_".format(id)).closest("div.option");
		var lbType=target.find("#%0_lbType_".format(id)).closest("div.option");
		var link=target.find("#%0_link_".format(id)).closest("div.option");
		var thumbnails=target.find("#%0_maxThumbs_".format(id)).closest("div.option");
		var lbScale=target.find("#%0_lbScale_".format(id)).closest("div.option");
		var delay=target.find("#%0_delay_".format(id)).closest("div.option");
		var bw=target.find("#%0_bw__0".format(id)).closest("div.option");
		var slideType = target.find("#%0_plugin_".format(id)).data("peFieldSelectSlider");
		
		function change() {
			var tval = type.val();
			switch (tval) {
			case "images":
			case "thumbnails":
			case "fullscreen":
				if (tval === "fullscreen" || tval === "images") {
					thumbnails.hide();
					title.show();
					link.show();
					titleCheck();
				} else {
					thumbnails.show();
					title.hide();
					custom.hide();
					link.hide();
				} 
				delay.hide();
				lbType.show();
				var ltval = lbType.find("select").val();
				if (ltval == "default" || (!ltval && tval == "thumbnails")) {
					lbScale.show();
					bw.hide();
				} else {
					lbScale.hide();
					bw.show();
				}
				if (slideType) { slideType.hide(); }
				break;
			case "slider":
				link.hide();
				thumbnails.hide();
				custom.hide();
				title.hide();
				delay.show();
				lbType.hide();
				lbScale.hide();
				bw.hide();
				if (slideType) { slideType.show(); }
				break;
			default:
				thumbnails.hide();
				custom.hide();
				title.hide();
				delay.hide();
				lbType.hide();
				lbScale.hide();
				link.hide();
				bw.hide();
				if (slideType) { slideType.hide(); }
				break;
			}
		}
		
		function titleCheck() {
			custom[titleField.filter(":checked").val() == "custom" ? "show" : "hide"]();
		}

				
		// init function
		function start() {
			type.change(change).triggerHandler("change");
			titleCheck();
			lbType.find("select").change(change).triggerHandler("change");
			titleField.click(titleCheck);
		}
		
		function shortcode() {
			return '[%0 type]'.format(conf.tag);
		}

		
		$.extend(this, {
			// plublic API
			//shortcode:shortcode,
			destroy: function() {
				target.data("peMetaboxGalleryPost", null);
				target = undefined;
			}
		});
		
		// initialize
		$(start);
	}
	
	// jQuery plugin implementation
	$.fn.peMetaboxGalleryPost = function(conf) {
		
		// return existing instance	
		var api = this.data("peMetaboxGalleryPost");
		
		if (api) { 
			return api; 
		}
		
		conf = $.extend(true, {}, $.pixelentity.peMetaboxGalleryPost.conf, conf);
		
		// install the plugin for each entry in jQuery object
		this.each(function() {
			var el = $(this);
			api = new PeMetaboxGalleryPost(el, conf);
			el.data("peMetaboxGalleryPost", api); 
		});
		
		return conf.api ? api: this;		 
	};
	
}(jQuery));

jQuery(document).ready(function($) {
	$(".pe_mbox_galleryPost").peMetaboxGalleryPost();
});

