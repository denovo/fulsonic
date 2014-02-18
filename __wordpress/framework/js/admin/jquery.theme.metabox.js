/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity,ajaxurl */

jQuery(document).ready(function($) {
	
	var postFormatBox = $("#post-formats-select");
	var postFormatOptions = $(".post-format-options");
	var pageTemplate = $("#page_template");
	var	mboxes = $(".pe_mbox");
	var current;
	var radios = [];
	var pfValues = [];
	var tpValues = [];
	
	function show(selected) {
		var active = ".pe_mbox_active_all";
		if (selected) {
			active += ",.pe_mbox_active_"+selected;
		}
		mboxes.parents(".postbox").hide();
		mboxes.filter(active).parents(".postbox").show();		
	}
	
	function getPfValue(idx,el) {
		pfValues[idx]=$(el).attr("value");
	}
	
	function getTpClass(template) {
		return template.replace("\.php","");
	}
	
	function getTpValue(idx,el) {
		tpValues[idx]=getTpClass($(el).attr("value"));
	}
	
	function pfChange(el) {
		
		var selected = el.target.id.replace("post-format-","");
		if (selected != current) {
			current = selected;
			show(selected);
		}
		postFormatBox.triggerHandler("change");
		
	}
	
	function pfChangeNew(e) {
		var selected = (e ? postFormatOptions.find(e.currentTarget) : postFormatOptions.find("a[data-wp-format].active")).attr("data-wp-format");
		if (selected != current) {
			current = selected;
			show(selected);
		}
	}
	
	function tpChange(el) {
		var selected = getTpClass(pageTemplate.val());
		if (selected != current) {
			current = selected;
			show(selected);
		}
	}
	
	if (postFormatBox.length > 0) {
		postFormatBox
			.find("input[name=post_format]")
			.change(pfChange)
			.each(getPfValue)
			.filter(":checked")
			.triggerHandler("change");
	} else if (postFormatOptions.length > 0) {
		$('.post-format-options').on( 'click', 'a', pfChangeNew);
		pfChangeNew();
		
	} else if (pageTemplate.length > 0) {
		pageTemplate
			.find("option")
			.each(getTpValue)
			.end()
			.change(tpChange)
			.triggerHandler("change");
	} else {
		show();
	}
});
