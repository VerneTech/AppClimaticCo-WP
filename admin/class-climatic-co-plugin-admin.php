<?php

class ClimaticCo_Plugin_Admin {

	private $plugin_name;

	private $version;



	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();

	}



	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-climatic-co-plugin-settings.php';

	}
	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	
	public function enqueue_styles1() {

		
        wp_enqueue_style( 'msg-action', plugin_dir_url( __FILE__ ) . 'admin/css/frontend-box.css', array(), '1.0.1', 'all' );
	}
	
	public function enqueue_styles() {

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( $this->plugin_name.'-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/climatic-co-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {



	wp_enqueue_media();
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/climatic-co-plugin-admin.js', array( 'jquery','wp-color-picker'  ), $this->version, false );

	}



}
