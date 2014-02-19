(function($){

// function to check window size & assign body classes
function checkWindowSize() {
	var width = $(window).width();
	var new_class = width > 959 ? 'gLarge' :
		width > 600 ? 'gMedium' :
		width < 600 ? 'gSmall' : '';

	$(document.body).removeClass('gLarge gMedium gSmall').addClass(new_class);
}


function show_bg_video() {

		var BV = new $.BigVideo();
        BV.init();
        BV.show('/assets/video/honda_civic.mp4');
        BV.getPlayer().volume(0); // set to muted at start
        $('#btn-vol-mute').addClass('muted'); // add muted class to btn
        
        function handleVideoPlayPause() {
			$('#btn-vol-mute').click(function(){
	        	var _this = $(this);
	        	if (_this.hasClass('volume-off')) {
	        	 	BV.getPlayer().volume(1); 
	        		_this.removeClass('volume-off').addClass('volume-up');
	        	}
	        	else {
	        		BV.getPlayer().volume(0);
	        		_this.removeClass('volume-up').addClass('volume-off');
	        	}
	        });

	        // handle if background video is clicked
	        $('#big-video-vid').click(function(){

	        	// update play / pause icon state
	        	playIcon.toggle();
	        	
	        	if ($('#btn-play-pause').hasClass('pause')) {
	        	 	BV.getPlayer().pause(); 
	        		$('#btn-play-pause').removeClass('pause').addClass('play');
	        	}
	        	else {
	        		BV.getPlayer().play();
	        		$('#btn-play-pause').removeClass('play').addClass('pause');
	        	}
	        });

	        // play / pause btn click handler
	        $('#btn-play-pause').click(function(){
	        	var _this = $(this); 

	        	if (_this.hasClass('pause')) {
	        	 	BV.getPlayer().pause(); 
	        		_this.removeClass('pause').addClass('play');

	        	}
	        	else {
	        		BV.getPlayer().play();
	        		_this.removeClass('play').addClass('pause');
	        	}
	        });

			// pause video once user scrolls #slate-2 into view
	        $('#slate-2').waypoint(function() {
	        	BV.getPlayer().pause();
	        	playIcon.setToggle(true);
	        	playIcon.toggle(); // reset back to play
	        	console.log("tried to set play button to true");
	        	$('#btn-play-pause').removeClass('pause').addClass('play');
			});
		}

		handleVideoPlayPause();
    
}

$(document).ready(function () {

	var vp_width = $(window).width();
	var vp_height = $(window).height();
	var isTouch = Modernizr.touch;
	// set all sections with to full height of the viewport
	$('.full-height').height(vp_height);

  	checkWindowSize();


  	// if on homepage & modern browser, then initialise the BG video, else
  	// show static background image
  	if ($('html').hasClass('video')){
  		// only show bg_video if not mobile / touch devices 
  		showVideo = (isTouch === false) ? show_bg_video() : $('.player-controls').hide();
    }

});

})(jQuery)