<?php


class ClimaticCo_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		

	}

	/**
	 * This function introduces the theme options into the 'Appearance' menu and into a top-level
	 * 'WPPB Demo' menu.
	 */
	public function setup_plugin_options_menu() {
		//Add the menu to the Plugins set of menu items
		add_menu_page(
			'ClimaticCo', 											// The title to be displayed in the browser window for this page.
			'ClimaticCo',											// The text to be displayed for this menu item
			'manage_options',										// Which type of users can see this menu item
			'climatic-co-options',									// The unique ID - that is, the slug - for this menu item
			array( $this, 'render_settings_page_content'),			// The name of the function to call when rendering this menu's page
			'https://appv2.climaticco.com/assets/img/logo-wp.png'
		);

	}

	/**
	 * Provides default values for the Display Options.
	 *
	 * @return array
	 */
	public function default_display_options() {
		
		$lang = detect_lang();
		
		$page = 'product';
		$all_options1 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		$id_product_message = (!empty($all_options1)) ? $all_options1[0]["MessageId"] : '' ; 
		
		
		$page = 'cart';
		$all_options2 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		$id_cart_message = (!empty($all_options2)) ? $all_options2[0]["MessageId"] : '' ;
		
		$page = 'check-out';
		$all_options3 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		$id_checkout_message = (!empty($all_options3)) ? $all_options3[0]["MessageId"] : '' ;
			
		$page = 'thank-you';
		$all_options4 = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		$id_thankyou_message = (!empty($all_options4)) ? $all_options4[0]["MessageId"] : '' ;

		$defaults = array (
			'display_none' => '',
			'prod_under_h1' => '',
			'cart_under_h1' => '',
			'checkout_under_h1' => '',
			'product_message' => $id_product_message,
			'prod_alignment' => 'left',
			'prod_fontsize' => '1',
			'product_color' => '',
			'cart_message' => $id_cart_message,
			'cart_alignment' => 'left',
			'cart_fontsize' => '1',
			'cart_color' => '',
			'checkout_message' => $id_checkout_message,
			'checkout_alignment' => 'left',
			'checkout_fontsize' => '1',
			'checkout_color' => '',
			'thankyou_message' => $id_thankyou_message,
			'thankyou_alignment' => 'left',
			'thankyou_fontsize' => '1.2',
			'thankyou_color' => '',
			'stump_position' => 'center',
		  );

		return $defaults;

	}

	/**
	 * Provide default values for the Social Options.
	 * default messages
	 *
	 * @return array
	 */
	 
	public function default_social_options($apikey = null) {

		$defaults = array(
			'product_message'		=>	''
		);
		if ($apikey != null) {
			$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/spa/product', $apikey);
			//var_dump($all_options);
			$defaults = array(
				'product_message'		=>	$all_options[0]['MessageId']
			);
		}else{
			$options = get_option('wppb_demo_authentication_options');
			//var_dump($options);
			

			if ($options['apikey'] != '') {
				//var_dump("SE INICIALIZA");
				$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/spa/product');
				//var_dump($all_options);
				$defaults = array(
					'product_message'		=>	$all_options[0]['MessageId']
				);

			}
		}

		

	
		return  $defaults;

	}
	
	public function default_cart_options() {

		$options = get_option('wppb_demo_authentication_options');
		//var_dump($options);
		$defaults = array(
			'cart_message'		=>	''
		);

		if ($options['apikey'] != '') {
			//var_dump("SE INICIALIZA");
			$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/spa/cart');
			//var_dump($all_options);
			$defaults = array(
				'cart_message'		=>	$all_options[0]['MessageId']
			);
			
		}

	
		return  $defaults;

	}
	
	public function default_checkout_options() {

		$options = get_option('wppb_demo_authentication_options');
		//var_dump($options);
		$defaults = array(
			'checkout_message'		=>	''
		);

		if ($options['apikey'] != '') {
			//var_dump("SE INICIALIZA");
			$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/spa/check-out');
			//var_dump($all_options);
			$defaults = array(
				'checkout_message'		=>	$all_options[0]['MessageId']
			);
			
		}

	
		return  $defaults;

	}
	
	public function default_thankyou_options() {

		$options = get_option('wppb_demo_authentication_options');
		//var_dump($options);
		$defaults = array(
			'thankyou_message'		=>	''
		);

		if ($options['apikey'] != '') {
			//var_dump("SE INICIALIZA");
			$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/spa/thank-you');
			//var_dump($all_options);
			$defaults = array(
				'thankyou_message'		=>	$all_options[0]['MessageId']
			);
			
		}

	
		return  $defaults;

	}

	/**
	 * Provides default values for the Input Options.
	 *
	 * @return array
	 */
	public function default_input_options() {

		$defaults = array(
			'input_example'		=>	'default input example',
			'textarea_example'	=>	'',
			'checkbox_example'	=>	'',
			'radio_example'		=>	'2',
			'time_options'		=>	'default'
		);

		return $defaults;

	}

	/**
	 * Renders a simple page to display for the theme menu defined above.
	 */
	public function render_settings_page_content( $active_tab = '' ) {

		
		?>
		<!-- Create a header in the default WordPress 'wrap' container -->
		<div class="wrap">

			<h2><?php _e( 'Configuración ClimaticCo', 'wppb-demo-plugin' ); ?> <?php get_option('wppb_demo_authentication_options') ?></h2>
			<?php settings_errors(); ?>

			<?php if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET[ 'tab' ];
			} else if( $active_tab == 'social_options' ) {
				$active_tab = 'product_options';
			} else if( $active_tab == 'product_options' ) {
				$active_tab = 'cart_options';
			} else if( $active_tab == 'cart_options' ) {
				$active_tab = 'cart_options';
			} else if( $active_tab == 'checkout_options' ) {
				$active_tab = 'checkout_options';
			}  else if( $active_tab == 'thankyou_options' ) {
				$active_tab = 'thankyou_options';
			}  else {
				$active_tab = 'common_options';
			}  // end if/else 

			$option = get_option('wppb_demo_authentication_options');

			if ($option['apikey'] == '') {
				$active_tab = 'authentication';
			}

			?>

			<h2 class="nav-tab-wrapper">
				<a href="?page=climatic-co-options&tab=common_options" class="nav-tab <?php echo $active_tab == 'common_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Configuración', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=climatic-co-options&tab=authentication" class="nav-tab <?php echo $active_tab == 'authentication' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Usuario', 'wppb-demo-plugin' ); ?></a>
				<!--<a href="?page=climatic-co-options&tab=product_options" class="nav-tab <?php echo $active_tab == 'product_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Product Page Advance', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=climatic-co-options&tab=cart_options" class="nav-tab <?php echo $active_tab == 'cart_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Cart Page Advance', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=climatic-co-options&tab=checkout_options" class="nav-tab <?php echo $active_tab == 'checkout_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Checkout Page Advance', 'wppb-demo-plugin' ); ?></a>
				<a href="?page=climatic-co-options&tab=thankyou_options" class="nav-tab <?php echo $active_tab == 'thankyou_options' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Thank You Page Advance', 'wppb-demo-plugin' ); ?></a>-->
			</h2>

			<form method="post" action="options.php" class="optionsitems">
			
				<?php

				if( $active_tab == 'common_options' ) {

					settings_fields( 'wppb_demo_display_options' );
					do_settings_sections( 'wppb_demo_display_options' );

				} elseif( $active_tab == 'authentication' ) {

					settings_fields( 'wppb_demo_authentication_options' );
					do_settings_sections( 'wppb_demo_authentication_options' );

				} elseif( $active_tab == 'product_options' ) {

					settings_fields( 'wppb_demo_social_options' );
					do_settings_sections( 'wppb_demo_social_options' );

				}  elseif( $active_tab == 'cart_options' ) {

					settings_fields( 'wppb_demo_cart_options' );
					do_settings_sections( 'wppb_demo_cart_options' );

				} elseif( $active_tab == 'checkout_options' ) {

					settings_fields( 'wppb_demo_checkout_options' );
					do_settings_sections( 'wppb_demo_checkout_options' );

				} elseif( $active_tab == 'thankyou_options' ) {

					settings_fields( 'wppb_demo_thankyou_options' );
					do_settings_sections( 'wppb_demo_thankyou_options' );

				}// end if/else

				submit_button();

				?>
			</form>

		</div><!-- /.wrap -->
	<?php
	}
	


	public function general_options_callback() {
		$options = get_option('wppb_demo_display_options');
		//var_dump($options);
		echo '<div class="tooltip_wrap help-link"><div class="tooltip_new"><span class="button_text"><a href="https://www.climaticco.com/ayuda/plugin-config/" target="_blank">Ayuda</a></span></div></div>';
	} // end general_options_callback
	
	


	public function social_options_callback() {
		$options = get_option('wppb_demo_social_options');
		//var_dump($options);
		echo '<p>' . __( 'Configuración general', 'wppb-demo-plugin' ) . '</p>';
	} // end general_options_callback
	


	public function authentication_options_callback() {
		$options = get_option('wppb_demo_authentication_options');
		//var_dump($options);
		echo '<p><b style="font-size:16px;margin-top: 30px;display: block;">' . __( 'Introduce el código que te hemos facilitado', 'wppb-demo-plugin' ) . '</b></p>';
	} // end general_options_callback
	


	public function cart_options_callback() {
		$options = get_option('wppb_demo_cart_options');
		//var_dump($options);
		echo '<p>' . __( 'Configuración general', 'wppb-demo-plugin' ) . '</p>';
	} // end general_options_callback


	public function checkout_options_callback() {
		$options = get_option('wppb_demo_checkout_options');
		//var_dump($options);
		echo '<p>' . __( 'Configuración general', 'wppb-demo-plugin' ) . '</p>';
	} // end general_options_callback


	public function thankyou_options_callback() {
		$options = get_option('wppb_demo_thankyou_options');
		//var_dump($options);
		echo '<p>' . __( 'Configuración general', 'wppb-demo-plugin' ) . '</p>';
	} // end general_options_callback

	
	
	public function input_examples_callback() {
		$options = get_option('wppb_demo_input_examples');
		//var_dump($options);
		echo '<p>' . __( 'Configuración general', 'wppb-demo-plugin' ) . '</p>';
	} // end general_options_callback


	/**
	 * Initializes the theme's display options page by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_display_options() {

		// If the theme options don't exist, create them.
		if( false == get_option( 'wppb_demo_display_options' ) ) {
			$default_array = $this->default_display_options();
			update_option( 'wppb_demo_display_options', $default_array );
		}


		add_settings_section(
			'general_settings_section',			            // ID used to identify this section and with which to register options
			__( '', 'wppb-demo-plugin' ),		        // Title to be displayed on the administration page
			array( $this, 'general_options_callback'),	    // Callback used to render the description of the section
			'wppb_demo_display_options'		                // Page on which to add this section of options
		);
		
		//add_settings_field('logo','Message Logo',array( $this, 'logo_display'), 'wppb_demo_display_options','general_settings_section');
		
		/*add_settings_field(
			'Synchronization Off',
			__( 'Synchronization Off', 'wppb-demo-plugin' ),
			array( $this, 'checkbox_element_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);*/
		
		
		add_settings_field(
			'Mensaje producto',
			__( 'Mensaje producto', 'wppb-demo-plugin' ),
			array( $this, 'select_element_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);
		
		
		
		/*add_settings_field(
			'Product tooltip message',
			'Product Tooltip Message',
			array( $this, 'product_frontend_tooltip'),
			'wppb_demo_display_options',
			'general_settings_section'
		);*/
		
		add_settings_field(
			'Mensaje carrito',
			__( 'Mensaje carrito', 'wppb-demo-plugin' ),
			array( $this, 'select_cart_element_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);	
		
		
		/*add_settings_field(
			'Cart tooltip message',
			'Cart Tooltip Message',
			array( $this, 'cart_frontend_tooltip'),
			'wppb_demo_display_options',
			'general_settings_section'
		);*/

		add_settings_field(
			'Mensaje checkout',
			__( 'Mensaje checkout', 'wppb-demo-plugin' ),
			array( $this, 'select_checkout_element_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);
		
				
		/*add_settings_field(
			'Checkout tooltip message',
			'Checkout Tooltip Message',
			array( $this, 'checkout_frontend_tooltip'),
			'wppb_demo_display_options',
			'general_settings_section'
		);*/
		
		
		add_settings_field(
			'Mensaje thank you',
			__( 'Mensaje thank you', 'wppb-demo-plugin' ),
			array( $this, 'select_thankyou_element_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);	
		
	
		/*add_settings_field(
			'Thankyou tooltip message',
			'Thankyou Tooltip Message',
			array( $this, 'thankyou_frontend_tooltip'),
			'wppb_demo_display_options',
			'general_settings_section'
		);*/
		

		add_settings_field(
			'Posición del sello',
			__( 'Posición del sello', 'wppb-demo-plugin' ),
			array( $this, 'select_element_stump_position_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);

		add_settings_field(
			'Sello para fondos oscuros',
			__( 'Sello para fondos oscuros', 'wppb-demo-plugin' ),
			array( $this, 'checkbox_black_background_callback'),
			'wppb_demo_display_options',
			'general_settings_section'
		);

		// Finally, we register the fields with WordPress
		register_setting(
			'wppb_demo_display_options',
			'wppb_demo_display_options',
			array( $this, 'sanitize_amain_options')
		);

	} // end wppb-demo_initialize_theme_options
	
	
	/**
	 * Initializes the theme's social options by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_authentication_options() {
		
		//delete_option('wppb_demo_social_options');

		if( false == get_option( 'wppb_demo_authentication_options' ) ) {
			$default_array = $this->default_social_options();
			update_option( 'wppb_demo_authentication_options', $default_array );
		}// end if

		add_settings_section(
			'authentication_settings_section',			// ID used to identify this section and with which to register options
			__( '', 'wppb-demo-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'authentication_options_callback'),	// Callback used to render the description of the section
			'wppb_demo_authentication_options'		// Page on which to add this section of options
		);		

		add_settings_field(
			'apikey',
			'Api Key',
			array( $this, 'apikey_callback'),
			'wppb_demo_authentication_options',
			'authentication_settings_section'
		);

		register_setting(
			'wppb_demo_authentication_options',
			'wppb_demo_authentication_options',
			array( $this, 'sanitize_authentication_options')
		);

		//register_setting('wppb_demo_authentication_options', 'wppb_demo_authentication_options', array($this, 'default_message_settings'));

		

	}

	/**
	 * Initializes the theme's social options by registering the Sections,
	 * Fields, and Settings.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_social_options() {
		
		//delete_option('wppb_demo_social_options');
		if( false == get_option( 'wppb_demo_social_options' ) ) {
			$default_array = $this->default_social_options();
			update_option( 'wppb_demo_social_options', $default_array );
		} // end if

		add_settings_section(
			'social_settings_section',			// ID used to identify this section and with which to register options
			__( 'Product Advance', 'wppb-demo-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'social_options_callback'),	// Callback used to render the description of the section
			'wppb_demo_social_options'		// Page on which to add this section of options
		);		

		/*add_settings_field(
			'Select Message',
			__( 'Select Message', 'wppb-demo-plugin' ),
			array( $this, 'select_element_callback'),
			'wppb_demo_social_options',
			'social_settings_section'
		);*/

		register_setting(
			'wppb_demo_social_options',
			'wppb_demo_social_options',
			array( $this, 'sanitize_social_options')
		);

	}
	
	
	public function initialize_cart_options() {
		
		//delete_option('wppb_demo_cart_options');
		if( false == get_option( 'wppb_demo_cart_options' ) ) {
			$default_array = $this->default_cart_options();
			update_option( 'wppb_demo_cart_options', $default_array );
		} // end if

		add_settings_section(
			'cart_settings_section',			// ID used to identify this section and with which to register options
			__( 'Cart Advance', 'wppb-demo-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'cart_options_callback'),	// Callback used to render the description of the section
			'wppb_demo_cart_options'		// Page on which to add this section of options
		);		

		/*add_settings_field(
			'Select Message',
			__( 'Select Message', 'wppb-demo-plugin' ),
			array( $this, 'select_cart_element_callback'),
			'wppb_demo_cart_options',
			'cart_settings_section'
		);*/

		register_setting(
			'wppb_demo_cart_options',
			'wppb_demo_cart_options',
			array( $this, 'sanitize_cart_options')
		);

	}
	
	
	public function initialize_checkout_options() {
		
		//delete_option('wppb_demo_checkout_options');
		if( false == get_option( 'wppb_demo_checkout_options' ) ) {
			$default_array = $this->default_checkout_options();
			update_option( 'wppb_demo_checkout_options', $default_array );
		} // end if

		add_settings_section(
			'checkout_settings_section',			// ID used to identify this section and with which to register options
			__( 'Checkout Advance', 'wppb-demo-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'checkout_options_callback'),	// Callback used to render the description of the section
			'wppb_demo_checkout_options'		// Page on which to add this section of options
		);		

		/*add_settings_field(
			'Select Message',
			__( 'Select Message', 'wppb-demo-plugin' ),
			array( $this, 'select_checkout_element_callback'),
			'wppb_demo_checkout_options',
			'checkout_settings_section'
		);*/

		register_setting(
			'wppb_demo_checkout_options',
			'wppb_demo_checkout_options',
			array( $this, 'sanitize_checkout_options')
		);

	}
	
	
	public function initialize_thankyou_options() {
		
		//delete_option('wppb_demo_thankyou_options');
		if( false == get_option( 'wppb_demo_thankyou_options' ) ) {
			$default_array = $this->default_thankyou_options();
			update_option( 'wppb_demo_thankyou_options', $default_array );
		} // end if

		add_settings_section(
			'thankyou_settings_section',			// ID used to identify this section and with which to register options
			__( 'Thankyou Advance', 'wppb-demo-plugin' ),		// Title to be displayed on the administration page
			array( $this, 'thankyou_options_callback'),	// Callback used to render the description of the section
			'wppb_demo_thankyou_options'		// Page on which to add this section of options
		);		

		/*add_settings_field(
			'Select Message',
			__( 'Select Message', 'wppb-demo-plugin' ),
			array( $this, 'select_thankyou_element_callback'),
			'wppb_demo_thankyou_options',
			'thankyou_settings_section'
		);*/

		register_setting(
			'wppb_demo_thankyou_options',
			'wppb_demo_thankyou_options',
			array( $this, 'sanitize_thankyou_options')
		);

	}


	/**
	 * Initializes the theme's input example by registering the Sections,
	 * Fields, and Settings. This particular group of options is used to demonstration
	 * validation and sanitization.
	 *
	 * This function is registered with the 'admin_init' hook.
	 */
	public function initialize_input_examples() {
		//delete_option('wppb_demo_input_examples');
		if( false == get_option( 'wppb_demo_input_examples' ) ) {
			$default_array = $this->default_input_options();
			update_option( 'wppb_demo_input_examples', $default_array );
		} // end if

		

		register_setting(
			'wppb_demo_input_examples',
			'wppb_demo_input_examples',
			array( $this, 'validate_input_examples')
		);

	}

	function frontend_tooltip() {

		$options = get_option( 'wppb_demo_display_options' );

		$frontend_tooltip = '';
		if( isset( $options['frontend_tooltip'] ) ) {
			$frontend_tooltip = $options['frontend_tooltip'];
		} // end if

		// Render the output
		echo '<textarea id="frontend_tooltip" name="wppb_demo_display_options[frontend_tooltip]" style="width: 360px;max-width: 100%;" />' . $frontend_tooltip . '</textarea>';

	}
	
	
	function logo_display(){
		$options = get_option( 'wppb_demo_display_options' ); ?>
		<input id="upload_image" type="text" size="36" name="wppb_demo_display_options[ad_image]" value="<?php echo $options['ad_image']; ?>" /> 
		<input id="upload_image_button" class="button" type="button" value="Upload Image" />
	<?php }
	
	public function checkbox_black_background_callback() {		

		$options = get_option( 'wppb_demo_display_options' );

		$html = '<input type="checkbox" id="checkbox_example" name="wppb_demo_display_options[black_background]" value="1"' . checked( 1, $options['black_background'], false ) . '/>';

		echo $html;
	}

	public function checkbox_element_callback() {

		$options = get_option( 'wppb_demo_display_options' );

		$html = '<input type="checkbox" id="checkbox_example" name="wppb_demo_display_options[synchronization_off]" value="1"' . checked( 1, $options['synchronization_off'], false ) . '/>';

		echo $html;

	} 
	

	public function apikey_callback() {

		$options = get_option( 'wppb_demo_authentication_options' );

		$apikey = '';
		if( isset( $options['apikey'] ) ) {
			$apikey = $options['apikey'];
		} // end if

		// Render the output
		echo '<input type="text" id="apikey" name="wppb_demo_authentication_options[apikey]" value="' . $apikey . '" style="width: 360px;max-width: 100%;" />';

	} // end googleplus_callback
	
	public function select_element_stump_position_callback(){		
		$options = get_option( 'wppb_demo_display_options' );
		/*
		if( isset( $options['display_none'] ) ) {
			$display_none = $options['display_none'];
		}else{
			$display_none = '';
		} // end if*/
		$html = '<div class="group-configuration">';
		$html .= '<select id="stump_position" name="wppb_demo_display_options[stump_position]" style="width: 360px;max-width: 100%;">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['stump_position'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['stump_position'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['stump_position'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';
		$html .= '<div class="tooltip_wrap"><div class="tooltip_new"><span class="button_text_q tooltip tooltip-simple">?<span class="tooltiptext tooltip-left">Elige la configuración del sello que hemos incluido en tu footer para que todos sepan que tu eCommerce realiza envíos neutros en carbono</span></span></div></div>';
		$html .= '</div>';
		echo $html;
		
	}

	public function select_element_callback() {

		$options = get_option( 'wppb_demo_display_options' );
		
		//print_r($options);
		
		$lang = detect_lang();
		$page = 'product';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);
		$html = '<div class="group-configuration">';
		$html .= '<select class="message-selection" id="product_message" name="wppb_demo_display_options[product_message]">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['product_message'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['content'], 'wppb-demo-plugin' ) . '</option>';
			}
		}
		
		$html .= '</select>';

		$html .= '<div class="tooltip_wrap"><div class="tooltip_new"><span class="button_text_q tooltip tooltip-simple">?<span class="tooltiptext tooltip-left">Utiliza el desplegable para elegir el mensaje en las fichas de producto</span></span></div></div>';

		$html .= '</div>';
		
		$html .= '<div class="tab_title" id="prod_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';
		
		$html .= '<div class="tab_title_content" id="prod_tab_content">';
		$display_none = 'display:block;';
		if($options['product_message'] !=''){			
			$display_none = 'display:block;';
		}

		$html .= '<div class="under_h1">
		 <label><input type="checkbox" name="wppb_demo_display_options[prod_under_h1]" value="1"' . checked( 1, $options['prod_under_h1'], false ) . '/> Mostrar bajo H1</lable>
		</div>';
		
		$html .= '<select id="prod_alignment" name="wppb_demo_display_options[prod_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['prod_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['prod_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['prod_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';
		
		$display_none = 'display:block;';
		if($options['product_message'] !=''){			
			$display_none = 'display:block;';
		}
		//var_dump($display_none);
		$html .= '<select id="prod_fontsize" name="wppb_demo_display_options[prod_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="0.5" ' . selected( $options['prod_fontsize'] , 0.5, false) . '>0.5em</option>';
		$html .= '<option value="0.6" ' . selected( $options['prod_fontsize'] , 0.6, false) . '>0.6em</option>';
		$html .= '<option value="0.7" ' . selected( $options['prod_fontsize'] , 0.7, false) . '>0.7em</option>';
		$html .= '<option value="0.8" ' . selected( $options['prod_fontsize'] , 0.8, false) . '>0.8em</option>';
		$html .= '<option value="0.9" ' . selected( $options['prod_fontsize'] , 0.9, false) . '>0.9em</option>';
		$html .= '<option value="1" ' . selected( $options['prod_fontsize'] , 1, false) . '>1em</option>';
		$html .= '<option value="1.1" ' . selected( $options['prod_fontsize'] , 1.1, false) . '>1.1em</option>';
		$html .= '<option value="1.2" ' . selected( $options['prod_fontsize'] , 1.2, false) . '>1.2em</option>';
		$html .= '<option value="1.3" ' . selected( $options['prod_fontsize'] , 1.3, false) . '>1.3em</option>';
		$html .= '<option value="1.4" ' . selected( $options['prod_fontsize'] , 1.4, false) . '>1.4em</option>';	
		$html .= '<option value="1.5" ' . selected( $options['prod_fontsize'] , 1.5, false) . '>1.5em</option>';
		$html .= '<option value="1.6" ' . selected( $options['prod_fontsize'] , 1.6, false) . '>1.6em</option>';
		$html .= '<option value="1.7" ' . selected( $options['prod_fontsize'] , 1.7, false) . '>1.7em</option>';
		$html .= '<option value="1.8" ' . selected( $options['prod_fontsize'] , 1.8, false) . '>1.8em</option>';
		$html .= '<option value="1.9" ' . selected( $options['prod_fontsize'] , 1.9, false) . '>1.9em</option>';	
		$html .= '<option value="2" ' . selected( $options['prod_fontsize'] , 2, false) . '>2em</option>';
		$html .= '<option value="2.1" ' . selected( $options['prod_fontsize'] , 2.1, false) . '>2.1em</option>';
		$html .= '<option value="2.2" ' . selected( $options['prod_fontsize'] , 2.2, false) . '>2.2em</option>';
		$html .= '<option value="2.3" ' . selected( $options['prod_fontsize'] , 2.3, false) . '>2.3em</option>';
		$html .= '<option value="2.4" ' . selected( $options['prod_fontsize'] , 2.4, false) . '>2.4em</option>';	
		$html .= '<option value="2.5" ' . selected( $options['prod_fontsize'] , 2.5, false) . '>2.5em</option>';
		$html .= '<option value="2.6" ' . selected( $options['prod_fontsize'] , 2.6, false) . '>2.6em</option>';
		$html .= '<option value="2.7" ' . selected( $options['prod_fontsize'] , 2.7, false) . '>2.7em</option>';
		$html .= '<option value="2.8" ' . selected( $options['prod_fontsize'] , 2.8, false) . '>2.8em</option>';
		$html .= '<option value="2.9" ' . selected( $options['prod_fontsize'] , 2.9, false) . '>2.9em</option>';	
		$html .= '<option value="3" ' . selected( $options['prod_fontsize'] , 3, false) . '>3em</option>';	
		$html .= '<option value="3.5" ' . selected( $options['prod_fontsize'] , 3.5, false) . '>3.5em</option>';	
		$html .= '<option value="4" ' . selected( $options['prod_fontsize'] , 4, false) . '>4em</option>';	
		$html .= '<option value="4.5" ' . selected( $options['prod_fontsize'] , 4.5, false) . '>4.5em</option>';	
		$html .= '<option value="5" ' . selected( $options['prod_fontsize'] , 5, false) . '>5em</option>';		
		$html .= '</select>';

		$url = '';
		if( isset( $options['product_color'] ) ) {
			$url = $options['product_color'];
		} 
		
		$html .='<div class="color-picker-container"><span>Color de fondo</span> <input type="text" id="product_color" class="my-color-field" name="wppb_demo_display_options[product_color]" value="' . $url . '" /> </div>';	
		
		$html .= '</div>';

		echo $html;

	} // end select_element_callback
	
	

	public function select_cart_element_callback() {

		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'cart';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);
		$html = '<div class="group-configuration">';
		$html .= '<select class="message-selection" id="cart_message" name="wppb_demo_display_options[cart_message]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['cart_message'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['content'], 'wppb-demo-plugin' ) . '</option>';
			}
		}
		
		$html .= '</select>';
		$html .= '<div class="tooltip_wrap"><div class="tooltip_new"><span class="button_text_q tooltip tooltip-simple">?<span class="tooltiptext tooltip-left">Selecciona el mensaje que prefieres que aparezca en el carrito</span></span></div></div>';
		$html .= '</div>';
		$html .= '<div class="tab_title" id="cart_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';
		$html .= '<div class="tab_title_content" id="cart_tab_content">';
		$display_none = 'display:block;';
		if($options['cart_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<div class="under_h1">
		 <label><input type="checkbox" name="wppb_demo_display_options[cart_under_h1]" value="1"' . checked( 1, $options['cart_under_h1'], false ) . '/> Mostrar bajo H1</lable>
		</div>';
		$html .= '<select id="cart_alignment" name="wppb_demo_display_options[cart_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['cart_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['cart_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['cart_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';
		$display_none = 'display:block;';
		if($options['cart_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<select id="cart_fontsize" name="wppb_demo_display_options[cart_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="0.5" ' . selected( $options['cart_fontsize'] , 0.5, false) . '>0.5em</option>';
		$html .= '<option value="0.6" ' . selected( $options['cart_fontsize'] , 0.6, false) . '>0.6em</option>';
		$html .= '<option value="0.7" ' . selected( $options['cart_fontsize'] , 0.7, false) . '>0.7em</option>';
		$html .= '<option value="0.8" ' . selected( $options['cart_fontsize'] , 0.8, false) . '>0.8em</option>';
		$html .= '<option value="0.9" ' . selected( $options['cart_fontsize'] , 0.9, false) . '>0.9em</option>';
		$html .= '<option value="1" ' . selected( $options['cart_fontsize'] , 1, false) . '>1em</option>';
		$html .= '<option value="1.1" ' . selected( $options['cart_fontsize'] , 1.1, false) . '>1.1em</option>';
		$html .= '<option value="1.2" ' . selected( $options['cart_fontsize'] , 1.2, false) . '>1.2em</option>';
		$html .= '<option value="1.3" ' . selected( $options['cart_fontsize'] , 1.3, false) . '>1.3em</option>';
		$html .= '<option value="1.4" ' . selected( $options['cart_fontsize'] , 1.4, false) . '>1.4em</option>';	
		$html .= '<option value="1.5" ' . selected( $options['cart_fontsize'] , 1.5, false) . '>1.5em</option>';
		$html .= '<option value="1.6" ' . selected( $options['cart_fontsize'] , 1.6, false) . '>1.6em</option>';
		$html .= '<option value="1.7" ' . selected( $options['cart_fontsize'] , 1.7, false) . '>1.7em</option>';
		$html .= '<option value="1.8" ' . selected( $options['cart_fontsize'] , 1.8, false) . '>1.8em</option>';
		$html .= '<option value="1.9" ' . selected( $options['cart_fontsize'] , 1.9, false) . '>1.9em</option>';	
		$html .= '<option value="2" ' . selected( $options['cart_fontsize'] , 2, false) . '>2em</option>';
		$html .= '<option value="2.1" ' . selected( $options['cart_fontsize'] , 2.1, false) . '>2.1em</option>';
		$html .= '<option value="2.2" ' . selected( $options['cart_fontsize'] , 2.2, false) . '>2.2em</option>';
		$html .= '<option value="2.3" ' . selected( $options['cart_fontsize'] , 2.3, false) . '>2.3em</option>';
		$html .= '<option value="2.4" ' . selected( $options['cart_fontsize'] , 2.4, false) . '>2.4em</option>';	
		$html .= '<option value="2.5" ' . selected( $options['cart_fontsize'] , 2.5, false) . '>2.5em</option>';
		$html .= '<option value="2.6" ' . selected( $options['cart_fontsize'] , 2.6, false) . '>2.6em</option>';
		$html .= '<option value="2.7" ' . selected( $options['cart_fontsize'] , 2.7, false) . '>2.7em</option>';
		$html .= '<option value="2.8" ' . selected( $options['cart_fontsize'] , 2.8, false) . '>2.8em</option>';
		$html .= '<option value="2.9" ' . selected( $options['cart_fontsize'] , 2.9, false) . '>2.9em</option>';	
		$html .= '<option value="3" ' . selected( $options['cart_fontsize'] , 3, false) . '>3em</option>';	
		$html .= '<option value="3.5" ' . selected( $options['cart_fontsize'] , 3.5, false) . '>3.5em</option>';	
		$html .= '<option value="4" ' . selected( $options['cart_fontsize'] , 4, false) . '>4em</option>';	
		$html .= '<option value="4.5" ' . selected( $options['cart_fontsize'] , 4.5, false) . '>4.5em</option>';	
		$html .= '<option value="5" ' . selected( $options['cart_fontsize'] , 5, false) . '>5em</option>';
		$html .= '</select>';		

		$url = '';
		if( isset( $options['cart_color'] ) ) {
			$url = $options['cart_color'];
		} 		
		
		$html .= '<div class="color-picker-container"> <span>Color de fondo</span><input type="text" id="cart_color" class="my-color-field" name="wppb_demo_display_options[cart_color]" value="' . $url . '" /> </div>';
		$html .= '</div>';

		echo $html;

	} // end select_element_callback
	
	public function select_checkout_element_callback() {

		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'check-out';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);

		$html = '<div class="group-configuration">';
		$html .= '<select class="message-selection" id="checkout_message" name="wppb_demo_display_options[checkout_message]" style="width:100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['checkout_message'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['content'], 'wppb-demo-plugin' ) . '</option>';
			}
		}
		
		$html .= '</select>';
		$html .= '<div class="tooltip_wrap"><div class="tooltip_new"><span class="button_text_q tooltip tooltip-simple">?<span class="tooltiptext tooltip-left">Con este selector podrás elegir el mensaje que acompañará al botón de compra</span></span></div></div>';
		$html .= '</div>';
		$html .= '<div class="tab_title" id="checkout_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';
		$html .= '<div class="tab_title_content" id="checkout_tab_content">';
		$display_none = 'display:block;';
		if($options['checkout_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<div class="under_h1">
		 <label><input type="checkbox" name="wppb_demo_display_options[checkout_under_h1]" value="1"' . checked( 1, $options['checkout_under_h1'], false ) . '/> Mostrar bajo H1</lable>
		</div>';
		
		$html .= '<select id="checkout_alignment" name="wppb_demo_display_options[checkout_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['checkout_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['checkout_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['checkout_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';
		$display_none = 'display:block;';
		if($options['checkout_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<select id="checkout_fontsize" name="wppb_demo_display_options[checkout_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="0.5" ' . selected( $options['checkout_fontsize'] , 0.5, false) . '>0.5em</option>';
		$html .= '<option value="0.6" ' . selected( $options['checkout_fontsize'] , 0.6, false) . '>0.6em</option>';
		$html .= '<option value="0.7" ' . selected( $options['checkout_fontsize'] , 0.7, false) . '>0.7em</option>';
		$html .= '<option value="0.8" ' . selected( $options['checkout_fontsize'] , 0.8, false) . '>0.8em</option>';
		$html .= '<option value="0.9" ' . selected( $options['checkout_fontsize'] , 0.9, false) . '>0.9em</option>';
		$html .= '<option value="1" ' . selected( $options['checkout_fontsize'] , 1, false) . '>1em</option>';
		$html .= '<option value="1.1" ' . selected( $options['checkout_fontsize'] , 1.1, false) . '>1.1em</option>';
		$html .= '<option value="1.2" ' . selected( $options['checkout_fontsize'] , 1.2, false) . '>1.2em</option>';
		$html .= '<option value="1.3" ' . selected( $options['checkout_fontsize'] , 1.3, false) . '>1.3em</option>';
		$html .= '<option value="1.4" ' . selected( $options['checkout_fontsize'] , 1.4, false) . '>1.4em</option>';	
		$html .= '<option value="1.5" ' . selected( $options['checkout_fontsize'] , 1.5, false) . '>1.5em</option>';
		$html .= '<option value="1.6" ' . selected( $options['checkout_fontsize'] , 1.6, false) . '>1.6em</option>';
		$html .= '<option value="1.7" ' . selected( $options['checkout_fontsize'] , 1.7, false) . '>1.7em</option>';
		$html .= '<option value="1.8" ' . selected( $options['checkout_fontsize'] , 1.8, false) . '>1.8em</option>';
		$html .= '<option value="1.9" ' . selected( $options['checkout_fontsize'] , 1.9, false) . '>1.9em</option>';	
		$html .= '<option value="2" ' . selected( $options['checkout_fontsize'] , 2, false) . '>2em</option>';
		$html .= '<option value="2.1" ' . selected( $options['checkout_fontsize'] , 2.1, false) . '>2.1em</option>';
		$html .= '<option value="2.2" ' . selected( $options['checkout_fontsize'] , 2.2, false) . '>2.2em</option>';
		$html .= '<option value="2.3" ' . selected( $options['checkout_fontsize'] , 2.3, false) . '>2.3em</option>';
		$html .= '<option value="2.4" ' . selected( $options['checkout_fontsize'] , 2.4, false) . '>2.4em</option>';	
		$html .= '<option value="2.5" ' . selected( $options['checkout_fontsize'] , 2.5, false) . '>2.5em</option>';
		$html .= '<option value="2.6" ' . selected( $options['checkout_fontsize'] , 2.6, false) . '>2.6em</option>';
		$html .= '<option value="2.7" ' . selected( $options['checkout_fontsize'] , 2.7, false) . '>2.7em</option>';
		$html .= '<option value="2.8" ' . selected( $options['checkout_fontsize'] , 2.8, false) . '>2.8em</option>';
		$html .= '<option value="2.9" ' . selected( $options['checkout_fontsize'] , 2.9, false) . '>2.9em</option>';	
		$html .= '<option value="3" ' . selected( $options['checkout_fontsize'] , 3, false) . '>3em</option>';	
		$html .= '<option value="3.5" ' . selected( $options['checkout_fontsize'] , 3.5, false) . '>3.5em</option>';	
		$html .= '<option value="4" ' . selected( $options['checkout_fontsize'] , 4, false) . '>4em</option>';	
		$html .= '<option value="4.5" ' . selected( $options['checkout_fontsize'] , 4.5, false) . '>4.5em</option>';	
		$html .= '<option value="5" ' . selected( $options['checkout_fontsize'] , 5, false) . '>5em</option>';	
		$html .= '</select>';

		$url = '';
		if( isset( $options['checkout_color'] ) ) {
			$url = $options['checkout_color'];
		} 		
		
		$html .= '<div class="color-picker-container"><span>Color de fondo</span><input type="text" id="cart_color" class="my-color-field" name="wppb_demo_display_options[checkout_color]" value="' . $url . '" /> </div>';
		$html .= '</div>';

		echo $html;

	} // end select_element_callback
	

	public function select_thankyou_element_callback() {

		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'thank-you';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);

		$html = '<div class="group-configuration">';
		$html .= '<select class="message-selection" id="thankyou_message" name="wppb_demo_display_options[thankyou_message]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $key => $all_option){	
				if (is_numeric($key)) {
					$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['thankyou_message'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['content'], 'wppb-demo-plugin' ) . '</option>';
				}			
			}
		}
		
		$html .= '</select>';
		$html .= '<div class="tooltip_wrap"><div class="tooltip_new"><span class="button_text_q tooltip tooltip-simple">?<span class="tooltiptext tooltip-left">Selecciona el mensaje que leerán tus clientes en la página de gracias</span></span></div></div>';
		$html .= '</div>';
		$html .= '<div class="tab_title" id="thankyou_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';
		$html .= '<div class="tab_title_content" id="thankyou_tab_content">';
		$display_none = 'display:block;';
		if($options['thankyou_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<select id="thankyou_alignment" name="wppb_demo_display_options[thankyou_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['thankyou_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['thankyou_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['thankyou_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';
		$display_none = 'display:block;';
		if($options['thankyou_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html .= '<select id="thankyou_fontsize" name="wppb_demo_display_options[thankyou_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="0.5" ' . selected( $options['thankyou_fontsize'] , 0.5, false) . '>0.5em</option>';
		$html .= '<option value="0.6" ' . selected( $options['thankyou_fontsize'] , 0.6, false) . '>0.6em</option>';
		$html .= '<option value="0.7" ' . selected( $options['thankyou_fontsize'] , 0.7, false) . '>0.7em</option>';
		$html .= '<option value="0.8" ' . selected( $options['thankyou_fontsize'] , 0.8, false) . '>0.8em</option>';
		$html .= '<option value="0.9" ' . selected( $options['thankyou_fontsize'] , 0.9, false) . '>0.9em</option>';
		$html .= '<option value="1" ' . selected( $options['thankyou_fontsize'] , 1, false) . '>1em</option>';
		$html .= '<option value="1.1" ' . selected( $options['thankyou_fontsize'] , 1.1, false) . '>1.1em</option>';
		$html .= '<option value="1.2" ' . selected( $options['thankyou_fontsize'] , 1.2, false) . '>1.2em</option>';
		$html .= '<option value="1.3" ' . selected( $options['thankyou_fontsize'] , 1.3, false) . '>1.3em</option>';
		$html .= '<option value="1.4" ' . selected( $options['thankyou_fontsize'] , 1.4, false) . '>1.4em</option>';	
		$html .= '<option value="1.5" ' . selected( $options['thankyou_fontsize'] , 1.5, false) . '>1.5em</option>';
		$html .= '<option value="1.6" ' . selected( $options['thankyou_fontsize'] , 1.6, false) . '>1.6em</option>';
		$html .= '<option value="1.7" ' . selected( $options['thankyou_fontsize'] , 1.7, false) . '>1.7em</option>';
		$html .= '<option value="1.8" ' . selected( $options['thankyou_fontsize'] , 1.8, false) . '>1.8em</option>';
		$html .= '<option value="1.9" ' . selected( $options['thankyou_fontsize'] , 1.9, false) . '>1.9em</option>';	
		$html .= '<option value="2" ' . selected( $options['thankyou_fontsize'] , 2, false) . '>2em</option>';
		$html .= '<option value="2.1" ' . selected( $options['thankyou_fontsize'] , 2.1, false) . '>2.1em</option>';
		$html .= '<option value="2.2" ' . selected( $options['thankyou_fontsize'] , 2.2, false) . '>2.2em</option>';
		$html .= '<option value="2.3" ' . selected( $options['thankyou_fontsize'] , 2.3, false) . '>2.3em</option>';
		$html .= '<option value="2.4" ' . selected( $options['thankyou_fontsize'] , 2.4, false) . '>2.4em</option>';	
		$html .= '<option value="2.5" ' . selected( $options['thankyou_fontsize'] , 2.5, false) . '>2.5em</option>';
		$html .= '<option value="2.6" ' . selected( $options['thankyou_fontsize'] , 2.6, false) . '>2.6em</option>';
		$html .= '<option value="2.7" ' . selected( $options['thankyou_fontsize'] , 2.7, false) . '>2.7em</option>';
		$html .= '<option value="2.8" ' . selected( $options['thankyou_fontsize'] , 2.8, false) . '>2.8em</option>';
		$html .= '<option value="2.9" ' . selected( $options['thankyou_fontsize'] , 2.9, false) . '>2.9em</option>';	
		$html .= '<option value="3" ' . selected( $options['thankyou_fontsize'] , 3, false) . '>3em</option>';	
		$html .= '<option value="3.5" ' . selected( $options['thankyou_fontsize'] , 3.5, false) . '>3.5em</option>';	
		$html .= '<option value="4" ' . selected( $options['thankyou_fontsize'] , 4, false) . '>4em</option>';	
		$html .= '<option value="4.5" ' . selected( $options['thankyou_fontsize'] , 4.5, false) . '>4.5em</option>';	
		$html .= '<option value="5" ' . selected( $options['thankyou_fontsize'] , 5, false) . '>5em</option>';		
		$html .= '</select>';

		$url = '';
		if( isset( $options['thankyou_color'] ) ) {
			$url = $options['thankyou_color'];
		} 		
		
		$html .= '<div class="color-picker-container"><span>Color de fondo</span><input type="text" id="cart_color" class="my-color-field" name="wppb_demo_display_options[thankyou_color]" value="' . $url . '" /> </div>';
		$html .= '</div>';

		echo $html;

	} 
	
	public function product_frontend_tooltip(){
		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'product';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);

		$html = '<select id="product_tooltip" class="tooltip_select" name="wppb_demo_display_options[product_tooltip]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['product_tooltip'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['tooltip'], 'wppb-demo-plugin' ) . '</option>';
			}
		}		
		$html .= '</select>';
		
		echo $html;
	}
	
	public function cart_frontend_tooltip(){
		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'cart';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		
		//print_r($all_options);

		$html = '<select id="cart_tooltip" class="tooltip_select" name="wppb_demo_display_options[cart_tooltip]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['cart_tooltip'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['tooltip'], 'wppb-demo-plugin' ) . '</option>';
			}
		}		
		$html .= '</select>';
		echo $html;
	}
	
	
	public function checkout_frontend_tooltip(){
		$options = get_option( 'wppb_demo_display_options' );
		$lang = detect_lang();
		$page = 'check-out';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		
		//print_r($all_options);

		$html = '<select id="checkout_tooltip" class="tooltip_select" name="wppb_demo_display_options[checkout_tooltip]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['checkout_tooltip'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['tooltip'], 'wppb-demo-plugin' ) . '</option>';
			}
		}		
		$html .= '</select>';
		echo $html;
	}
	
	
	public function thankyou_frontend_tooltip(){
		$options = get_option( 'wppb_demo_display_options' );
		
		$lang = detect_lang();
		$page = 'thank-you';
		$all_options = api_callback('https://appv2.climaticco.com/api/v1/messages/ecommerce/'.$lang.'/'.$page);
		//print_r($all_options);

		$html = '<select id="thankyou_tooltip" class="tooltip_select" name="wppb_demo_display_options[thankyou_tooltip]" style="width: 100%;height: 38px;background-color: #ccc; max-width: 100%;">';
		
		if(!empty($all_options)){
			foreach($all_options as $all_option){				
				$html .= '<option value="'.$all_option['MessageId'].'"' . selected( $options['thankyou_tooltip'] , $all_option['MessageId'], false) . '>' . __( $all_option['translations'][0]['tooltip'], 'wppb-demo-plugin' ) . '</option>';
			}
		}		
		$html .= '</select>';
		echo $html;
	}  
	
	// end select_element_callback
	
	/*function select_element_callback_prod_tab(){
		
		$html = '<div class="tab_title" id="prod_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i>
</div>';

		echo $html;
	}
	
	function select_element_callback_cart_tab(){
		
		$html = '<div class="tab_title" id="cart_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';

		echo $html;
	}
	
	
	
	function select_element_callback_checkout_tab(){
		
		$html = '<div class="tab_title" id="checkout_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';

		echo $html;
	}
	
	
	
	function select_element_callback_thankyou_tab(){
		
		$html = '<div class="tab_title" id="thankyou_tab">Configuración avanzada <i class="fa fa-chevron-down" aria-hidden="true"></i></div>';

		echo $html;
	}
	
	function select_element_callback_prod_1(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['product_message'] !=''){			
			$display_none = 'display:block;';
		}
		
		$html = '<select id="prod_alignment" name="wppb_demo_display_options[prod_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['prod_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['prod_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['prod_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_cart_1(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['cart_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="cart_alignment" name="wppb_demo_display_options[cart_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['cart_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['cart_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['cart_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_checkout_1(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['checkout_message'] !=''){			
			$display_none = 'display:block;';
		}
		
		$html = '<select id="checkout_alignment" name="wppb_demo_display_options[checkout_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['checkout_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['checkout_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['checkout_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_thankyou_1(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['thankyou_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="thankyou_alignment" name="wppb_demo_display_options[thankyou_alignment]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar alineado', 'wppb-demo-plugin' ) . '</option>';
		$html .= '<option value="left" ' . selected( $options['thankyou_alignment'] , 'left', false) . '>Alineado a la izquierda</option>';
		$html .= '<option value="center" ' . selected( $options['thankyou_alignment'] , 'center', false) . '>Alineado al centro</option>';
		$html .= '<option value="right" ' . selected( $options['thankyou_alignment'] , 'right', false) . '>Alineado a la derecha</option>';		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_prod_2(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['product_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="prod_fontsize" name="wppb_demo_display_options[prod_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		for ($x = 10; $x <= 60; $x++) {			
			$html .= '<option value="'.$x.'" ' . selected( $options['prod_fontsize'] , $x, false) . '>'.$x.'px</option>';
		}		
		$html .= '</select>';

		echo $html;
	}
	
	
	function select_element_callback_cart_2(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['cart_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="cart_fontsize" name="wppb_demo_display_options[cart_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		for ($x = 10; $x <= 60; $x++) {			
			$html .= '<option value="'.$x.'" ' . selected( $options['cart_fontsize'] , $x, false) . '>'.$x.'px</option>';
		}	
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_checkout_2(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['checkout_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="checkout_fontsize" name="wppb_demo_display_options[checkout_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		for ($x = 10; $x <= 60; $x++) {			
			$html .= '<option value="'.$x.'" ' . selected( $options['checkout_fontsize'] , $x, false) . '>'.$x.'px</option>';
		}		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_thankyou_2(){

		$options = get_option( 'wppb_demo_display_options' );
		
		$display_none = 'display:none1;';
		if($options['thankyou_message'] !=''){			
			$display_none = 'display:block;';
		}
		$html = '<select id="thankyou_fontsize" name="wppb_demo_display_options[thankyou_fontsize]" style="width: 360px;max-width: 100%;'.$display_none.'">';
		$html .= '<option value="">' . __( 'Seleccionar tamaño de fuente', 'wppb-demo-plugin' ) . '</option>';
		for ($x = 10; $x <= 60; $x++) {			
			$html .= '<option value="'.$x.'" ' . selected( $options['thankyou_fontsize'] , $x, false) . '>'.$x.'px</option>';
		}		
		$html .= '</select>';

		echo $html;
	}
	
	function select_element_callback_prod_3(){
		$options = get_option( 'wppb_demo_display_options' );
		
		$url = '';
		if( isset( $options['product_color'] ) ) {
			$url = $options['product_color'];
		} 
		
		echo '<input type="text" id="product_color" class="my-color-field" name="wppb_demo_display_options[product_color]" value="' . $url . '" /> <span>Color de fondo</span>';
	}

	function select_element_callback_cart_3(){
		$options = get_option( 'wppb_demo_display_options' );
		
		$url = '';
		if( isset( $options['cart_color'] ) ) {
			$url = $options['cart_color'];
		} 
		
		echo '<input type="text" id="cart_color" class="my-color-field" name="wppb_demo_display_options[cart_color]" value="' . $url . '" /> <span>Color de fondo</span>';
	}
	
	function select_element_callback_checkout_3(){
		$options = get_option( 'wppb_demo_display_options' );
		
		$url = '';
		if( isset( $options['checkout_color'] ) ) {
			$url = $options['checkout_color'];
		} 
		
		echo '<input type="text" id="checkout_color" class="my-color-field" name="wppb_demo_display_options[checkout_color]" value="' . $url . '" /> <span>Color de fondo</span>';
	}
	
	function select_element_callback_thankyou_3(){
		$options = get_option( 'wppb_demo_display_options' );
		
		$url = '';
		if( isset( $options['thankyou_color'] ) ) {
			$url = $options['thankyou_color'];
		} 
		
		echo '<input type="text" id="thankyou_color" class="my-color-field" name="wppb_demo_display_options[thankyou_color]" value="' . $url . '" /> <span>Color de fondo</span>';
	}*/
	
	/**
	 * Sanitization callback for the social options. Since each of the social options are text inputs,
	 * this function loops through the incoming option and strips all tags and slashes from the value
	 * before serializing it.
	 *
	 * @params	$input	The unsanitized collection of options.
	 *
	 * @returns			The collection of sanitized values.
	 */
	public function sanitize_social_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] =strip_tags( stripslashes( $input[$key] ) ) ;
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_social_options', $output, $input );

	} // end sanitize_social_options
	
	
	public function sanitize_amain_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] =strip_tags( stripslashes( $input[$key] ) ) ;
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_amain_options', $output, $input );

	}
	
	
	public function sanitize_authentication_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] =strip_tags( stripslashes( $input[$key] ) ) ;
			} // end if

		} // end foreach
		/* if (!function_exists('write_log')) {

			function write_log($log) {
				if (true === WP_DEBUG) {
					if (is_array($log) || is_object($log)) {
						error_log(print_r($log, true));
					} else {
						error_log($log);
					}
				}
			}
		
		}

		write_log('VALIDATED DEFAULT SETTINGS');
		//write_log($output);

		$product_message = $this->default_social_options($output['apikey']);
		update_option('wppb_demo_social_options', $product_message[0]);

		$cart_message = $this->default_cart_options();
		update_option('wppb_demo_cart_options', $cart_message);

		$checkout_message = $this->default_checkout_options();
		update_option('wppb_demo_checkout_options', $checkout_message);

		$thankyou_message = $this->default_thankyou_options();
		update_option('wppb_demo_thankyou_options', $thankyou_message);

		createsession(); */

		/* if (get_option('wppb_demo_social_options')['product_message'] == '') {
			$product_message = $this->default_social_options();
			update_option('wppb_demo_social_options', $product_message);
		}

		if (get_option('wppb_demo_cart_options')['cart_message'] == '') {
			$cart_message = $this->default_cart_options();
			update_option('wppb_demo_cart_options', $cart_message);
		}

		if (get_option('wppb_demo_checkout_options')['checkout_message'] == '') {
			$checkout_message = $this->default_checkout_options();
			update_option('wppb_demo_checkout_options', $checkout_message);
		}

		if (get_option('wppb_demo_thankyou_options')['thankyou_message'] == '') {
			$thankyou_message = $this->default_thankyou_options();
			update_option('wppb_demo_thankyou_options', $thankyou_message);
		} */

		// Return the new collection
		return apply_filters( 'sanitize_authentication_options', $output, $input );

	} // end sanitize_social_options
	
	
	
	
	public function sanitize_cart_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[$key] ) ) ;
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_cart_options', $output, $input );

	} // end sanitize_social_options
	
	public function sanitize_checkout_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[$key] ) ) ;
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_checkout_options', $output, $input );

	} // end sanitize_social_options
	
	public function sanitize_thankyou_options( $input ) {

		// Define the array for the updated options
		$output = array();

		// Loop through each of the options sanitizing the data
		foreach( $input as $key => $val ) {

			if( isset ( $input[$key] ) ) {
				$output[$key] = strip_tags( stripslashes( $input[$key] ) );
			} // end if

		} // end foreach

		// Return the new collection
		return apply_filters( 'sanitize_thankyou_options', $output, $input );

	} // end sanitize_social_options
	

	public function validate_input_examples( $input ) {

		// Create our array for storing the validated options
		$output = array();

		// Loop through each of the incoming options
		foreach( $input as $key => $value ) {

			// Check to see if the current option has a value. If so, process it.
			if( isset( $input[$key] ) ) {

				// Strip all HTML and PHP tags and properly handle quoted strings
				$output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

			} // end if

		} // end foreach

		// Return the array processing any additional functions filtered by this action
		return apply_filters( 'validate_input_examples', $output, $input );

	} // end validate_input_examples




}