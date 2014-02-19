(function() {
	var triggerBttn = document.getElementById( 'main-nav-toggle' ),
		overlay = document.querySelector( 'div.menu-overlay' ),
		closeBttn = overlay.querySelector( 'button.menu-overlay-close' ),
		// navLinks = document.querySelectorAll( '.main-nav-link');
		transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd',
			'msTransition': 'MSTransitionEnd',
			'transition': 'transitionend'
		},
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		support = { transitions : Modernizr.csstransitions };

	function toggleOverlay() {
		console.log("toggle menu overlay");
		if( classie.has( overlay, 'open' ) ) {
			classie.remove( overlay, 'open' );
			classie.add( overlay, 'close' );
			var onEndTransitionFn = function( ev ) {
				if( support.transitions ) {
					if( ev.propertyName !== 'visibility' ) return;
					this.removeEventListener( transEndEventName, onEndTransitionFn );
				}
				classie.remove( overlay, 'close' );
			};
			if( support.transitions ) {
				overlay.addEventListener( transEndEventName, onEndTransitionFn );
			}
			else {
				onEndTransitionFn();
			}
		}
		else if( !classie.has( overlay, 'close' ) ) {
			classie.add( overlay, 'open' );
		}
	}

	triggerBttn.addEventListener( 'click', toggleOverlay );

	// for each main-nav menu link, add a click event to close menu when clicked
	[].forEach.call(
		document.querySelectorAll('.main-nav-link'),
		function(el){
			el.addEventListener( 'click', toggleOverlay );
		}
	);

	// closeBttn.addEventListener( 'click', toggleOverlay );

})();