<?php
/**
 * Introduce a new WP_Query parameter to run block attributes queries.
 *
 * @package   wp-query-block-attributes
 * @author    imath
 * @license   GPL-2.0+
 * @link      https://imathi.eu
 *
 * @wordpress-plugin
 * Plugin Name:       WP Query Block Attributes
 * Plugin URI:        https://github.com/imath/wp-query-block-attributes
 * Description:       Introduce a new WP_Query parameter to run block attributes queries.
 * Version:           1.0.0
 * Author:            imath
 * Author URI:        https://imathi.eu
 * Text Domain:       wp-query-block-attributes
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Query_Block_Attributes' ) ) :
	/**
	 * Main Class
	 *
	 * @since 1.0.0
	 */
	class WP_Query_Block_Attributes {
		/**
		 * Instance of this class.
		 *
		 * @since 1.0.0
		 *
		 * @var object $instance The plugin main instance.
		 */
		protected static $instance = null;

		/**
		 * Initialize the plugin
		 *
		 * @since 1.0.0
		 */
		private function __construct() {
			$this->inc();
		}

		/**
		 * Return an instance of this class.
		 *
		 * @since 1.0.0
		 */
		public static function start() {

			// If the single instance hasn't been set, set it now.
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Load needed files.
		 *
		 * @since 1.0.0
		 */
		private function inc() {
			$inc_path = plugin_dir_path( __FILE__ ) . 'inc/';

			require $inc_path . 'globals.php';
			require $inc_path . 'functions.php';
			require $inc_path . 'registers.php';

			if ( is_admin() ) {
				require $inc_path . 'admin.php';
			}
		}
	}

endif;

/**
 * Start plugin.
 *
 * @since 1.0.0
 *
 * @return WP_Query_Block_Attributes The main instance of the plugin.
 */
function wpqba() {
	return WP_Query_Block_Attributes::start();
}
add_action( 'plugins_loaded', 'wpqba', 9 );
