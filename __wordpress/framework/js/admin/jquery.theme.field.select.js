(function ($) {
	/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
	/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity */
	
	$.pixelentity = $.pixelentity || {version: '1.0.0'};
	
	$.pixelentity.peFieldSelect = {	
		conf: {
			api: false
		} 
	};
	
	function PeFieldSelect(target, conf) {
		var wrapper = $(target).parent();
		var span = $("<span/>");
		
		// init function
		function start() {
			wrapper.prepend(span);
			target.bind("change",change);
			target.triggerHandler("change");
		}
		
		function change() {
			span.html(target.find("option:selected").text());
		}
		
		$.extend(this, {
			// plublic API
			destroy: function() {
				target.data("peFieldSelect", null);
				target = undefined;
			}
		});
		
		// initialize
		start();
	}
	
	// jQuery plugin implementation
	$.fn.peFieldSelect = function(conf) {
		
		// return existing instance	
		var api = this.data("peFieldSelect");
		
		if (api) { 
			return api; 
		}
		
		conf = $.extend(true, {}, $.pixelentity.peFieldSelect.conf, conf);
		
		// install the plugin for each entry in jQuery object
		this.each(function() {
			var el = $(this);
			api = new PeFieldSelect(el, conf);
			el.data("peFieldSelect", api); 
		});
		
		return conf.api ? api: this;		 
	};
	
}(jQuery));