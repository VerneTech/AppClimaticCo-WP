(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	 $(document).scroll(function(){
		//console.log( Math.floor($(this).scrollTop() + $(window).height()) + " >= " + Math.floor($(document).height()-5) );
		if (Math.floor($(this).scrollTop() + $(window).height()) >= Math.floor($(document).height()-5)) {
			$('body .stumpwrap').css({
				'opacity': '1'
			})
		}else{
			$('body .stumpwrap').css({
				'opacity': '0'
			})
		}
	});

})( jQuery );
