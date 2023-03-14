(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
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
	$(function() {
		
		// Get all elements with class="closebtn"
		var closediv = document.getElementById("crossitem_added");
		//var crossitem = document.getElementById("crossitem");
		var i;
		
		//crossitem.onclick = function(){
		//	setTimeout(function(){ closediv.style.display = "none"; }, 100);
		//}

		// Loop through all close buttons
		/*for (i = 0; i < close.length; i++) {
		  // When someone clicks on a close button
		  close[i].onclick = function(){

			// Get the parent of <span class="closebtn"> (<div class="alert">)
			var div = this.parentElement;

			// Set the opacity of div to 0 (transparent)
			div.style.opacity = "0";

			// Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
			setTimeout(function(){ div.style.display = "none"; }, 600);
		  }
		}*/
		
	});
	
})( jQuery );
