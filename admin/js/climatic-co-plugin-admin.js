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
	 
		/*var value1 = $('#product_message').val();
		if(value1 != ''){
			$('#prod_alignment').parent().parent().show();
			$('#prod_fontsize').parent().parent().show();
		}else{
			$('#prod_alignment').parent().parent().hide();
			$('#prod_fontsize').parent().parent().hide();		   
		}
		
		var value1 = $('#cart_message').val();
		if(value1 != ''){
			$('#cart_alignment').parent().parent().show();
			$('#cart_fontsize').parent().parent().show();
		}else{
			$('#cart_alignment').parent().parent().hide();
			$('#cart_fontsize').parent().parent().hide();		   
		}
		
		var value1 = $('#checkout_message').val();
		if(value1 != ''){
			$('#checkout_alignment').parent().parent().show();
			$('#checkout_fontsize').parent().parent().show();
		}else{
			$('#checkout_alignment').parent().parent().hide();
			$('#checkout_fontsize').parent().parent().hide();		   
		}
		
		var value1 = $('#thankyou_message').val();
			if(value1 != ''){
			   $('#thankyou_alignment').parent().parent().show();
			   $('#thankyou_fontsize').parent().parent().show();
			}else{
			   $('#thankyou_alignment').parent().parent().hide();
			   $('#thankyou_fontsize').parent().parent().hide();		   
			}*/
		
		/*$('#prod_alignment').parent().parent().hide();
		$('#prod_fontsize').parent().parent().hide();
		$('#product_color').parent().parent().hide();

		$('#cart_alignment').parent().parent().hide();
		$('#cart_fontsize').parent().parent().hide();
		$('#cart_color').parent().parent().hide();
		
		$('#checkout_alignment').parent().parent().hide();
		$('#checkout_fontsize').parent().parent().hide();	
		$('#checkout_color').parent().parent().hide();
		
		$('#thankyou_alignment').parent().parent().hide();
		$('#thankyou_fontsize').parent().parent().hide();
		$('#thankyou_color').parent().parent().hide();	*/
		
		$('#prod_tab').click(function(){
			   $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			   $('#prod_tab_content').toggleClass('openoption');
			
		});
		
		$('#cart_tab').click(function(){
			
			   $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			   $('#cart_tab_content').toggleClass('openoption');
			
		});
		
		$('#checkout_tab').click(function(){
			
			   $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			   $('#checkout_tab_content').toggleClass('openoption');
			
		});
		
		$('#thankyou_tab').click(function(){
			
			   $(this).find('i').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			   $('#thankyou_tab_content').toggleClass('openoption');
			
		});
		
		$('.my-color-field').wpColorPicker();
		
		var custom_uploader;
		$('#upload_image_button').click(function(e) {
			e.preventDefault();
			//If the uploader object has already been created, reopen the dialog
			if (custom_uploader) {
				custom_uploader.open();
				return;
			}
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Image',
				button: { text: 'Choose Image'},
				multiple: false
			});
			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				var attachment = custom_uploader.state().get('selection').first().toJSON();
				$('#upload_image').val(attachment.url);
			});
			//Open the uploader dialog
			custom_uploader.open();
		});
		
		// Get all elements with class="closebtn"
		var close = document.getElementsByClassName("closebtn");
		var i;

		// Loop through all close buttons
		for (i = 0; i < close.length; i++) {
		  // When someone clicks on a close button
		  close[i].onclick = function(){

			// Get the parent of <span class="closebtn"> (<div class="alert">)
			var div = this.parentElement;

			// Set the opacity of div to 0 (transparent)
			div.style.opacity = "0";

			// Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
			setTimeout(function(){ div.style.display = "none"; }, 600);
		  }
		}
	});
	
})( jQuery );
