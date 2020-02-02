<?php
/**
 * Admin functions.
 *
 * @package   wp-query-block-attributes
 * @subpackage \inc\functions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display the admin page.
 *
 * @since 1.0.0
 */
function wpqba_admin() {
	$wpqba_value           = '';
	$wpqba_block_attribute = '';
	$posts                 = false;

	if ( isset( $_POST['wpqba_block_attribute'] ) && isset( $_POST['wpqba_value'] ) ) {
		check_admin_referer( 'wp-query-block-attributes' );

		$wpqba_block_attribute = sanitize_text_field( wp_unslash( $_POST['wpqba_block_attribute'] ) );
		$wpqba_value           = sanitize_text_field( wp_unslash( $_POST['wpqba_value'] ) );

		$query_args = array( 'post_type' => 'post' );
		if ( in_array( $wpqba_block_attribute, array( 'wpqbaAttributeOne', 'wpqbaAttributeTwo' ), true ) ) {
			$type = 'string';
			if ( 'wpqbaAttributeTwo' === $wpqba_block_attribute ) {
				$type = 'integer';
			}

			$query_args = array_merge(
				$query_args,
				array(
					'block_attribute_query' => array(
						array(
							'block'     => 'wpqba/block',
							'attribute' => $wpqba_block_attribute,
							'value'     => $wpqba_value,
							'type'      => $type,
						),
					),
				)
			);
		}

		$get_posts = new WP_Query();
		$posts     = $get_posts->query( $query_args );
	}
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Query Block Attributes', 'wp-query-block-attributes' ); ?></h1>

		<hr class="wp-header-end">

		<form method="POST">
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="wpqba_block_attribute"><?php esc_html_e( 'Block attribute', 'wp-query-block-attributes' ); ?></label>
					</th>
					<td>
						<select name="wpqba_block_attribute">
							<option value=""><?php esc_html_e( 'Select a block attribute', 'wp-query-block-attributes' ); ?></option>
							<option value="wpqbaAttributeOne" <?php selected( 'wpqbaAttributeOne', $wpqba_block_attribute ); ?>>wpqbaAttributeOne</option>
							<option value="wpqbaAttributeTwo" <?php selected( 'wpqbaAttributeTwo', $wpqba_block_attribute ); ?>>wpqbaAttributeTwo</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="wpqba_value"><?php esc_html_e( 'Attribute value', 'wp-query-block-attributes' ); ?></label>
					</th>
					<td>
						<input type="text" class="regular-text code" name="wpqba_value" value="<?php echo esc_html( $wpqba_value ); ?>" />
					</td>
				</tr>
			</table>
			<?php wp_nonce_field( 'wp-query-block-attributes' ); ?>
			<?php submit_button( esc_html__( 'Test query', 'wp-query-block-attributes' ), 'primary', 'wpqba_submit' ); ?>
		</form>

		<?php if ( $posts ) : ?>
			<h2><?php echo esc_html( _n( 'Result:', 'Results', count( $posts ), 'wp-query-block-attributes' ) ); ?></h2>
			<table class="widefat">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Post ID', 'wp-query-block-attributes' ); ?></th>
						<th><?php esc_html_e( 'Post Title', 'wp-query-block-attributes' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $posts as $post ) : ?>
						<tr>
							<td><?php echo esc_html( $post->ID ); ?></td>
							<td><?php echo esc_html( $post->post_title ); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Add the menu page.
 *
 * @since 1.0.0
 */
function wpqba_admin_menu() {
	add_menu_page(
		__( 'Query Block Attributes', 'wp-query-block-attributes' ),
		__( 'Query Block Attributes', 'wp-query-block-attributes' ),
		'manage_options',
		'wpqba-admin',
		'wpqba_admin',
		'dashicons-feedback'
	);
}
add_action( 'admin_menu', 'wpqba_admin_menu' );
