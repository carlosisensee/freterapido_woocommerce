<?php
/**
 * Plugin Name: WooCommerce Frete Rápido
 * Plugin URI: https://github.com/...
 * Description: Frete Rápido para WooCommerce
 * Author: Frete Rápido
 * Author URI: http://www.freterapido.com
 * Version: 2.1.0
 * License: GPLv2 or later
 * Text Domain: freterapido
 * Domain Path: languages/
 */

define( 'WOO_FR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FR_API_URL', 'https://freterapido.com/api/external/' );
//define( 'FR_API_URL', 'https://freterapido.com/sandbox/api/external/embarcador/v1/' );


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Freterapido_Main' ) ) :

	/**
	 * Frete Rápido main class.
	 */
	class WC_Freterapido_Main {
		/**
		 * Plugin version.
		 *
		 * @var string
		 */
		const VERSION = '1.0.0';

		/**
		 * Instance of this class.
		 *
		 * @var object
		 */
		protected static $instance = null;


		/**
		 * Arrays with the plugins we need to use this plugin
		 */
		private $array_plugins;

		/**
		 * Initialize the plugin
		 */
		private function __construct() {

			if ( !class_exists( 'Extra_Checkout_Fields_For_Brazil' ) ) {
				$this->array_plugins[] = 'WooCommerce Extra Checkout Fields for Brazil';
			}

			if ( !class_exists( 'WooCommerce' ) ) {
				$this->array_plugins[] = 'WooCommerce';
			}

			if( empty( $this->array_plugins ) ) {

				add_action( 'init', array( $this, 'load_plugin_textdomain' ), -1 );
				add_action( 'wp_ajax_ajax_simulator', array( 'WC_Freterapido_Shipping_Simulator', 'ajax_simulator' ) );
				add_action( 'wp_ajax_nopriv_ajax_simulator', array( 'WC_Freterapido_Shipping_Simulator', 'ajax_simulator' ) );

				// Checks with WooCommerce is installed.
				if ( class_exists( 'WC_Integration' ) ) {
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-orders.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-http.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-helpers.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-shipping.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-hire-shipping.php';

					add_filter( 'woocommerce_shipping_methods', array( $this, 'wcfreterapido_add_method' ) );

					add_action( 'admin_enqueue_scripts', array( $this, 'wcfreterapido_rapido_awaiting_shipment_admin_style' ) );

					include_once 'includes/freterapido-functions.php';

				} else {
					add_action( 'admin_notices', array( $this, 'wcfreterapido_woocommerce_fallback_notice' ) );
				}

				if ( ! class_exists( 'SimpleXmlElement' ) ) {
					add_action( 'admin_notices', 'wcfreterapido_extensions_missing_notice' );
				}
			} else {
				add_action( 'admin_notices', array( $this, 'wcfreterapido_fallback_notice' ) );
			}
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'freterapido', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get main file.
		 *
		 * @return string
		 */
		public static function get_main_file() {
			return __FILE__;
		}

		/**
		 * Get plugin path.
		 *
		 * @return string
		 */
		public static function get_plugin_path() {
			return plugin_dir_path( __FILE__ );
		}

		/**
		 * Get templates path.
		 *
		 * @return string
		 */
		public static function get_templates_path() {
			return self::get_plugin_path() . 'templates/';
		}

		/**
		 * Add the Frete Rápido to shipping methods.
		 *
		 * @param array $methods
		 *
		 * @return array
		 */
		function wcfreterapido_add_method( $methods ) {
			$methods['freterapido'] = 'WC_Freterapido';

			return $methods;
		}

		/**
		 * Add the admin style to show the awayiting shipment icon on edit page
		 * @param string $hook current page
		 */
		public function wcfreterapido_rapido_awaiting_shipment_admin_style( $hook ) {
			if ( 'edit.php' != $hook ) {
				return;
			}
			wp_enqueue_style( 'shipment_admin_style', plugins_url( 'includes/css/shipment_admin_style.css', __FILE__ ) );
		}

		public function wcfreterapido_fallback_notice(){
			echo '<div class="error"><p>';
			echo '<strong>' . __( 'Frete Rápido needs the following(s) plugin(s) to work:', 'freterapido' ) . '</strong>';
			echo '<ul>';
			foreach ( $this->array_plugins as $plugin ) {
				echo '<li>' . $plugin . '<li>';
			}
			echo '<ul></p></div>';
		}


	}

add_action( 'plugins_loaded', array( 'WC_Freterapido_Main', 'get_instance' ) );

endif;
