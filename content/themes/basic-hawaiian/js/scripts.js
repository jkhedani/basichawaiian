/**
 * jQuery Global Scripts
 *
 */

jQuery(document).ready(function($){

  /**
	 *	Coverflow
	 *	By Justin Hedani
	 */
	$.fn.coverflow = function ( options ) {

		// INIT & SETTINGS
		var coverflow = this;
		// Prevent horizontal scrolling on page.
		$('html, body').css('overflow-x','hidden');
		// $('html, body').css('overflow-y','hidden');
		// Find the width and margins of all items in the coverflow
		var flowwidth = 0;
		var flowslidemargin = 0; // Allows us define "true" position for use laster
		coverflow.find('li').each( function(){
			var flowitemwidth = $(this).width();
			var flowitemmargin = parseInt($(this).css('marginLeft'));
			flowslidemargin = flowitemmargin;
			flowwidth = flowwidth + flowitemwidth + flowitemmargin + 40;
		});

		// FUNCTIONS
		// Apply total width to list wrapper
		coverflow.find('ul').width( flowwidth );


		// Scroll to active
		var activeSlidePosition = coverflow.find('ul li.active').position();
		var activeSlideTruePosition = activeSlidePosition.left + flowslidemargin; // Don't forget to compensate for margins
		function scrolltoactive( scrollLocation ) {
			coverflow.find('ul').animate({
				marginLeft: -scrollLocation,
			}, 500);
		}
		scrolltoactive( activeSlideTruePosition );

		// EVENTS
		$(document).on('click', '.coverflow-controls a', function() {
			// Determine direction in which to flow to
			var flowdirection = $(this).data('slide-to');

			if ( flowdirection == 'next' ) {

				var nextitemposition = $(this).parents('.coverflow').find('ul li.active').next().position();
				var nextitemmargin = parseInt( $(this).parents('.coverflow').find('ul li.active').next().css('marginLeft') );
				var nextscrollposition = nextitemposition.left + nextitemmargin;

				// Remove active class from current slide
				coverflow.find('ul li.active').removeClass('active').next().addClass('active');
				// Remove active class from current counter
				coverflow.find('.coverflow-counter-container div.active').removeClass('active').next().addClass('active');

				// Find the width and margin of the 'next' slide and translate list left by this amount
				scrolltoactive( nextscrollposition );

			} else if ( flowdirection == 'prev' ) {

				var previtemposition = $(this).parents('.coverflow').find('ul li.active').prev().position();
				var previtemmargin = parseInt( $(this).parents('.coverflow').find('ul li.active').prev().css('marginLeft') );
				var prevscrollposition = previtemposition.left + previtemmargin;

				// Remove active class from current slide
				coverflow.find('ul li.active').removeClass('active').prev().addClass('active');
				// Remove active class from current counter
				coverflow.find('.coverflow-counter-container div.active').removeClass('active').prev().addClass('active');

				// Find the width and margin of the 'next' slide and translate list left by this amount
				scrolltoactive( prevscrollposition );

			}
			event.preventDefault();
		});
	}

	// Add coverflow to logged-in home
	if ( $('body').hasClass('home') && $('body').hasClass('logged-in') ) {
		$('.coverflow').coverflow();
	}
	// Add coverflow to logged-in units
	if ( $('body').hasClass('single-units') && $('body').hasClass('logged-in') ) {
		$('.coverflow').coverflow();
	}

}); //document.ready
