<?php

class ClimaticCo_Plugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		//wppb_demo_display_options
		//wppb_demo_authentication_options
		delete_option( 'wppb_demo_display_options' );
		delete_option( 'wppb_demo_authentication_options' );
		
	}

}
