(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function() {
		console.log('am getting here bish');
		var track_shipment_btn = $("button#sendbox_track_btn");


		track_shipment_btn.on("submit click", function(e) {
			
			e.preventDefault();
			var sendbox_tracking_code = $("input[name='sendbox_track']").val();
			var data = {
			  code: sendbox_tracking_code
			}; 
               console.log('am getting here');
			   $.post(
				sendbox_fa_ajax_object.sendbox_fa_ajax_url,
				{
				  action: "track_sendbox_shipment",
				  data: data
				},
				function(response) {
				   
				}
			  );
		  });
	  
		
	});
})( jQuery );
