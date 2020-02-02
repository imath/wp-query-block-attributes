<?php
/**
 * Registers functions.
 *
 * @package   wp-query-block-attributes
 * @subpackage \inc\registers
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the example block used by the plugin.
 *
 * @since 1.0.0
 */
function wpqba_registers() {
	$wpqba = wpqba();

	// Example block JavaScript.
	wp_register_script(
		'wpqba-block',
		$wpqba->dist_url . 'index.js',
		array(
			'wp-element',
			'wp-blocks',
			'wp-components',
			'wp-i18n',
		),
		$wpqba->version,
		true
	);

	// Register the Example block.
	register_block_type(
		'wpqba/block',
		array(
			'editor_script' => 'wpqba-block',
		)
	);
	wp_set_script_translations( 'wpqba-block', 'wp-query-block-attributes', $wpqba->lang_path );
}
add_action( 'init', 'wpqba_registers' );
