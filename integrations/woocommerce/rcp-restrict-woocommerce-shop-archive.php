<?php
/**
 * Plugin Name: Restrict Content Pro - Restrict WooCommerce Shop Archive
 * Description: Restricts access to the WooCommerce shop archive, using the settings specified in the "Restrict this Content" metabox.
 * Version: 1.0
 * Author: Restrict Content Pro team
 * License: GPL2
 */

/**
 * Restricts access to the WooCommerce shop archive according to the settings specified in the metabox.
 * If the current user doesn't have access, they're redirected to the specified redirect URL in Restrict > Settings > Misc.
 *
 * @since 1.0
 * @return void
 */
function ag_rcp_redirect_woocommerce_shop() {
	if ( ! function_exists( 'is_shop' ) || ! is_shop() ) {
		return;
	}

	global $rcp_options;

	$shop_page_id = wc_get_page_id( 'shop' );
	$member       = new RCP_Member( get_current_user_id() );

	if ( $member->can_access( $shop_page_id ) ) {
		return;
	}

	if( isset( $rcp_options['redirect_from_premium'] ) ) {
		$redirect = get_permalink( $rcp_options['redirect_from_premium'] );
	} else {
		$redirect = home_url();
	}

	wp_redirect( $redirect ); exit;
}
add_action( 'template_redirect', 'ag_rcp_redirect_woocommerce_shop', 999 );