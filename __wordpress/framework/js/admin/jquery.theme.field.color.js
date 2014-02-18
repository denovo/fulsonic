(function ($) {
	/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
	/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity */
	
	$.pixelentity = $.pixelentity || {version: '1.0.0'};
	
	$.pixelentity.peFieldColor = {	
		conf: {
			api: false
		} 
	};
	
	function PeFieldColor(target, conf) {
		var div=$('#cp_'+target.attr('id')).find("div");
		var instance;
		
		function setColor(hex) {
			div.css({'backgroundColor':'#'+hex, 'backgroundImage': 'none', 'borderColor':'#'+hex});			
		}
		
		function onSubmit(hsb, hex, rgb) {
			target.val('#'+hex);
		}
		
		function onBeforeShow(e) {
			target.ColorPickerSetColor(this.value);
			setColor(instance.val());
			return false;			
		}
		
		function onChange(hsb, hex, rgb) {
			setColor(hex);
			target.val('#'+hex);			
		}
		
		function restore() {
			var color = target.attr("data-default");
			target.val(color);
			setColor(color.replace(/#/,""));
			return false;
		}
		
		function change() {
			setColor(target.val().replace(/#/,""));
		}

		
		// init function
		function start() {
			target
				.ColorPicker({
					"onSubmit": onSubmit,
					"onBeforeShow": onBeforeShow, 
					"onChange": onChange
				})
				.bind('keyup',onBeforeShow)
				.bind("change",change);
			
			$('#restore_'+target.attr('id')).click(restore);
			instance = $("#"+target.data('colorpickerId')).find(".colorpicker_hex input");
		}
		
		$.extend(this, {
			// plublic API
			destroy: function() {
				target.data("peFieldColor", null);
				target = undefined;
			}
		});
		
		// initialize
		start();
	}
	
	// jQuery plugin implementation
	$.fn.peFieldColor = function(conf) {
		
		// return existing instance	
		var api = this.data("peFieldColor");
		
		if (api) { 
			return api; 
		}
		
		conf = $.extend(true, {}, $.pixelentity.peFieldColor.conf, conf);
		
		// install the plugin for each entry in jQuery object
		this.each(function() {
			var el = $(this);
			api = new PeFieldColor(el, conf);
			el.data("peFieldColor", api); 
		});
		
		return conf.api ? api: this;		 
	};
	
}(jQuery));