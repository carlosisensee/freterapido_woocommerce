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

define('WOO_FR_PATH', plugin_dir_path(__FILE__));
define('FR_API_URL', 'https://freterapido.com/api/external/');
//define( 'FR_API_URL', 'https://freterapido.com/sandbox/api/external/embarcador/v1/' );


if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

if (!class_exists('WC_Freterapido_Main')) :

	/**
	 * Frete Rápido main class.
	 */
	class WC_Freterapido_Main
	{
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
		private function __construct()
		{

			if (!class_exists('Extra_Checkout_Fields_For_Brazil')) {
				$this->array_plugins[] = 'WooCommerce Extra Checkout Fields for Brazil';
			}

			if (!class_exists('WooCommerce')) {
				$this->array_plugins[] = 'WooCommerce';
			}

			if (empty($this->array_plugins)) {

				add_action('init', array($this, 'load_plugin_textdomain'), -1);
				add_action('wp_ajax_ajax_simulator', array('WC_Freterapido_Shipping_Simulator', 'ajax_simulator'));
				add_action('wp_ajax_nopriv_ajax_simulator', array('WC_Freterapido_Shipping_Simulator', 'ajax_simulator'));

				// Checks with WooCommerce is installed.
				if (class_exists('WC_Integration')) {
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-orders.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-http.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-helpers.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-shipping.php';
					include_once WOO_FR_PATH . 'includes/class-wc-freterapido-hire-shipping.php';

					add_filter('woocommerce_shipping_methods', array($this, 'wcfreterapido_add_method'));

					add_action('admin_enqueue_scripts', array($this, 'wcfreterapido_rapido_awaiting_shipment_admin_style'));

					include_once 'includes/freterapido-functions.php';
				} else {
					add_action('admin_notices', array($this, 'wcfreterapido_woocommerce_fallback_notice'));
				}

				if (!class_exists('SimpleXmlElement')) {
					add_action('admin_notices', 'wcfreterapido_extensions_missing_notice');
				}
			} else {
				add_action('admin_notices', array($this, 'wcfreterapido_fallback_notice'));
			}
		}

		/**
		 * Return an instance of this class.
		 *
		 * @return object A single instance of this class.
		 */
		public static function get_instance()
		{
			// If the single instance hasn't been set, set it now.
			if (null === self::$instance) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Load the plugin text domain for translation.
		 */
		public function load_plugin_textdomain()
		{
			load_plugin_textdomain('freterapido', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}

		/**
		 * Get main file.
		 *
		 * @return string
		 */
		public static function get_main_file()
		{
			return __FILE__;
		}

		/**
		 * Get plugin path.
		 *
		 * @return string
		 */
		public static function get_plugin_path()
		{
			return plugin_dir_path(__FILE__);
		}

		/**
		 * Get templates path.
		 *
		 * @return string
		 */
		public static function get_templates_path()
		{
			return self::get_plugin_path() . 'templates/';
		}

		/**
		 * Add the Frete Rápido to shipping methods.
		 *
		 * @param array $methods
		 *
		 * @return array
		 */
		function wcfreterapido_add_method($methods)
		{
			$methods['freterapido'] = 'WC_Freterapido';

			return $methods;
		}

		/**
		 * Add the admin style to show the awayiting shipment icon on edit page
		 * @param string $hook current page
		 */
		public function wcfreterapido_rapido_awaiting_shipment_admin_style($hook)
		{
			if ('edit.php' != $hook) {
				return;
			}
			wp_enqueue_style('shipment_admin_style', plugins_url('includes/css/shipment_admin_style.css', __FILE__));
		}

		public function wcfreterapido_fallback_notice()
		{
			echo '<div class="error"><p>';
			echo '<strong>' . __('Frete Rápido needs the following(s) plugin(s) to work:', 'freterapido') . '</strong>';
			echo '<ul>';
			foreach ($this->array_plugins as $plugin) {
				echo '<li>' . $plugin . '<li>';
			}
			echo '<ul></p></div>';
		}
	}

	global $fr_db_version;
	$fr_db_version = '1.0';

	function fr_install()
	{
		global $fr_db_version;

		// create a new taxonomy
		register_taxonomy(
			'fr_category',
			'product',
			array(
				'label'        => __('FR Category'),
				'hierarchical' => false,
				'show_ui'      => false,
			)
		);

		$fr_categories = [
			['name' => 'Abrasivos', 'code' => 1],
			['name' => 'Acessórios de Airsoft / Paintball', 'code' => 69],
			['name' => 'Acessórios de Arquearia', 'code' => 73],
			['name' => 'Acessórios de Pesca', 'code' => 70],
			['name' => 'Acessórios para celular', 'code' => 90],
			['name' => 'Adubos / Fertilizantes', 'code' => 2],
			['name' => 'Alimentos não perecíveis', 'code' => 74],
			['name' => 'Alimentos perecíveis', 'code' => 3],
			['name' => 'Arquearia', 'code' => 72],
			['name' => 'Artesanatos', 'code' => 93],
			['name' => 'Artigos para Camping', 'code' => 82],
			['name' => 'Artigos para Pesca', 'code' => 4],
			['name' => 'Auto Peças', 'code' => 5],
			['name' => 'Bebidas / Destilados', 'code' => 6],
			['name' => 'Bijuteria', 'code' => 99],
			['name' => 'Brindes', 'code' => 7],
			['name' => 'Brinquedos', 'code' => 8],
			['name' => 'Caixa de embalagem', 'code' => 75],
			['name' => 'Calçados', 'code' => 9],
			['name' => 'Cargas refrigeradas/congeladas', 'code' => 62],
			['name' => 'CD / DVD / Blu-Ray', 'code' => 10],
			['name' => 'Cocção Industrial', 'code' => 102],
			['name' => 'Colchão', 'code' => 66],
			['name' => 'Combustíveis / Óleos', 'code' => 11],
			['name' => 'Confecção', 'code' => 12],
			['name' => 'Cosméticos', 'code' => 13],
			['name' => 'Couro', 'code' => 14],
			['name' => 'Derivados Petróleo', 'code' => 15],
			['name' => 'Descartáveis', 'code' => 16],
			['name' => 'Editorial', 'code' => 17],
			['name' => 'Eletrodomésticos', 'code' => 19],
			['name' => 'Eletrônicos', 'code' => 18],
			['name' => 'Embalagens', 'code' => 20],
			['name' => 'Equipamentos de cozinha industrial', 'code' => 107],
			['name' => 'Equipamentos de Segurança / API', 'code' => 88],
			['name' => 'Estiletes / Materiais Cortantes', 'code' => 84],
			['name' => 'Estufa térmica', 'code' => 106],
			['name' => 'Explosivos / Pirotécnicos', 'code' => 21],
			['name' => 'Extintores', 'code' => 87],
			['name' => 'Ferragens', 'code' => 23],
			['name' => 'Ferramentas', 'code' => 24],
			['name' => 'Fibras Ópticas', 'code' => 25],
			['name' => 'Fonográfico', 'code' => 26],
			['name' => 'Fotográfico', 'code' => 27],
			['name' => 'Fraldas / Geriátricas', 'code' => 28],
			['name' => 'Higiene', 'code' => 29],
			['name' => 'Impressos', 'code' => 30],
			['name' => 'Informática / Computadores', 'code' => 31],
			['name' => 'Instrumento Musical', 'code' => 32],
			['name' => 'Joia', 'code' => 100],
			['name' => 'Limpeza', 'code' => 86],
			['name' => 'Linha Branca', 'code' => 77],
			['name' => 'Livro(s)', 'code' => 33],
			['name' => 'Malas / Mochilas', 'code' => 79],
			['name' => 'Maquina de algodão doce', 'code' => 104],
			['name' => 'Maquina de chocolate', 'code' => 105],
			['name' => 'Materiais Escolares', 'code' => 34],
			['name' => 'Materiais Esportivos', 'code' => 35],
			['name' => 'Materiais Frágeis', 'code' => 36],
			['name' => 'Materiais hidráulicos', 'code' => 97],
			['name' => 'Material de Construção', 'code' => 37],
			['name' => 'Material de Irrigação', 'code' => 38],
			['name' => 'Material Elétrico / Lâmpada(s)', 'code' => 39],
			['name' => 'Material Gráfico', 'code' => 40],
			['name' => 'Material Hospitalar', 'code' => 41],
			['name' => 'Material Odontológico', 'code' => 42],
			['name' => 'Material Pet Shop', 'code' => 43],
			['name' => 'Material Plástico', 'code' => 50],
			['name' => 'Material Veterinário', 'code' => 44],
			['name' => 'Medicamentos', 'code' => 22],
			['name' => 'Moto Peças', 'code' => 46],
			['name' => 'Mudas / Plantas', 'code' => 47],
			['name' => 'Máquina / Equipamentos', 'code' => 80],
			['name' => 'Móveis com peças de vidro', 'code' => 68],
			['name' => 'Móveis desmontados', 'code' => 64],
			['name' => 'Móveis montados', 'code' => 45],
			['name' => 'Outros', 'code' => 999],
			['name' => 'Papelaria / Documentos', 'code' => 48],
			['name' => 'Papelão', 'code' => 63],
			['name' => 'Perfumaria', 'code' => 49],
			['name' => 'Pia / Vasos', 'code' => 98],
			['name' => 'Pilhas / Baterias', 'code' => 83],
			['name' => 'Pisos (cerâmica) / Revestimentos', 'code' => 92],
			['name' => 'Placa de Energia Solar', 'code' => 96],
			['name' => 'Pneus e Borracharia', 'code' => 51],
			['name' => 'Porta / Janelas', 'code' => 95],
			['name' => 'Produto Químico classificado', 'code' => 85],
			['name' => 'Produtos Cerâmicos', 'code' => 52],
			['name' => 'Produtos Químicos Não Classificados', 'code' => 53],
			['name' => 'Produtos Veterinários', 'code' => 54],
			['name' => 'Quadros / Molduras', 'code' => 94],
			['name' => 'Rações / Alimento para Animal', 'code' => 81],
			['name' => 'Refrigeração Industrial', 'code' => 101],
			['name' => 'Revistas', 'code' => 55],
			['name' => 'Sementes', 'code' => 56],
			['name' => 'Simulacro de Arma / Airsoft', 'code' => 71],
			['name' => 'Sofá', 'code' => 65],
			['name' => 'Suprimentos Agrícolas / Rurais', 'code' => 57],
			['name' => 'Tapeçaria / Cortinas / Persianas', 'code' => 108],
			['name' => 'Toldos', 'code' => 91],
			['name' => 'Travesseiro', 'code' => 67],
			['name' => 'TV / Monitores', 'code' => 76],
			['name' => 'Têxtil', 'code' => 58],
			['name' => 'Utensílios industriais', 'code' => 103],
			['name' => 'Utilidades domésticas', 'code' => 89],
			['name' => 'Vacinas', 'code' => 59],
			['name' => 'Vestuário', 'code' => 60],
			['name' => 'Vidros / Frágil', 'code' => 61],
			['name' => 'Vitaminas / Suplementos nutricionais', 'code' => 78]
		];

		foreach ($fr_categories as $fr_category) {
			wp_insert_term($fr_category['name'], 'fr_category', ['description' => $fr_category['code']]);
		}

		add_option('fr_db_version', $fr_db_version);
	}

	register_activation_hook(__FILE__, 'fr_install');

	add_action('plugins_loaded', array('WC_Freterapido_Main', 'get_instance'));

endif;
