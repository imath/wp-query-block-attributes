<?php
/**
 * General functions.
 *
 * @package   wp-query-block-attributes
 * @subpackage \inc\functions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build the block attribute query WHERE clause.
 *
 * @since 1.0.0
 *
 * @param string   $where The WHERE clause of the query.
 * @param WP_Query $wp_query The WP_Query instance (passed by reference).
 */
function wpqba_block_attribute_query( $where, $wp_query ) {
	global $wpdb;

	if ( isset( $wp_query->query['block_attribute_query'] ) ) {
		$relation     = 'AND';
		$where_clause = array();

		foreach ( $wp_query->query['block_attribute_query'] as $key => $block_attribute_query ) {
			if ( 'relation' === $key && strtoupper( $block_attribute_query ) === 'OR' ) {
				$relation = 'OR';
			} else {
				$block_attributes_query_args = wp_parse_args(
					$block_attribute_query,
					array(
						'block'     => '',
						'attribute' => '',
						'value'     => '',
						'type'      => 'string',
					)
				);

				if ( $block_attributes_query_args['block'] && $block_attributes_query_args['attribute'] && $block_attributes_query_args['value'] ) {
					if ( 'integer' === $block_attributes_query_args['type'] ) {
						$where_clause[] = sprintf(
							'%1$s REGEXP \'<!-- wp:%2$s ({|{.*,)*\\\"%3$s\\\":%4$d(}|,.*\\\"*})* -->\'',
							$wpdb->posts . '.post_content',
							esc_sql( $block_attributes_query_args['block'] ),
							esc_sql( $block_attributes_query_args['attribute'] ),
							esc_sql( $block_attributes_query_args['value'] )
						);
					} else {
						$where_clause[] = sprintf(
							'%1$s REGEXP \'<!-- wp:%2$s ({|{.*,)*\\\"%3$s\\\":\\\"%4$s\\\"(}|,.*\\\"*})* -->\'',
							$wpdb->posts . '.post_content',
							esc_sql( $block_attributes_query_args['block'] ),
							esc_sql( $block_attributes_query_args['attribute'] ),
							esc_sql( $block_attributes_query_args['value'] )
						);
					}
				}
			}
		}

		if ( $where_clause ) {
			$where .= ' AND ' . $wpdb->posts . '.post_content !=\'\' AND (' . implode( ' ' . $relation . ' ', $where_clause ) . ')';
		}
	}

	return $where;
}
add_filter( 'posts_where', 'wpqba_block_attribute_query', 10, 2 );

/**
 * Load plugin text domain.
 *
 * @since 1.0.0
 */
function wpqba_textdomain() {
	$locale = get_user_locale();
	load_textdomain( 'wp-query-block-attributes', wpqba()->lang_path . '/wp-query-block-attributes-' . $locale . '.mo' );
}
add_action( 'plugins_loaded', 'wpqba_textdomain', 11 );
