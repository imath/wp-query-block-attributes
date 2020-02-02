<?php
/**
 * Functions about globals.
 *
 * @package   wp-query-block-attributes
 * @subpackage \inc\globals
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers plugin's globals.
 *
 * @since 1.0.0
 */
function wpqba_globals() {
	$wpqba = wpqba();

	$wpqba->version = '1.0.0';

	$wpqba->inc_path  = plugin_dir_path( __FILE__ );
	$wpqba->dist_url  = plugins_url( 'dist/', dirname( __FILE__ ) );
	$wpqba->lang_path = trailingslashit( dirname( $wpqba->inc_path ) ) . 'languages';
}
add_action( 'plugins_loaded', 'wpqba_globals', 10 );
