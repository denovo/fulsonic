/*jslint undef: false, browser: true, devel: false, eqeqeq: false, bitwise: false, white: false, plusplus: false, regexp: false, nomen: false */ 
/*global jQuery,setTimeout,location,setInterval,YT,clearInterval,clearTimeout,pixelentity,ajaxurl */



jQuery(document).ready(function($) {
	
	function toObj(s) {
		var r = {};
		var match;
		var pl = /\+/g;  // Regex for replacing addition symbol with a space
		var search = /([^&=]+)=?([^&]*)/g;
		
		function decode(s) { 
			return decodeURIComponent(s.replace(pl, " ")); 
		}

		while ((match = search.exec(s))) {
			r[decode(match[1])] = decode(match[2]);			
		}
		
		return r;
	}

	
	function reloadWidget(e, xhr, settings) {
		
		var req = settings.data;
		
		if (req.search('action=save-widget') != -1 && req.search('delete_widget=1') === -1 && req.search('id_base=pethemewidget') != -1 && req.search('add_new=multi') != -1 ) {
			var wdata = toObj(settings.data);
			$("#widget-"+wdata["widget-id"]+"-savewidget").click();			
		}
	}
	
	jQuery(document).ajaxSuccess(reloadWidget);

});

