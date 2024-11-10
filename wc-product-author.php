<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nitin247.com/
 * @since             1.0.0
 * @package           Wc_Product_Author
 *
 * @wordpress-plugin
 * Plugin Name:       WC Product Author
 * Plugin URI:        https://nitin247.com/plugin/wc-product-author/
 * Description:       WC Product Author enables author functionality for Woocommerce Products, Author can be assigned to Woocommerce Product using this plugin.
 * Version:           1.0.1
 * Author:            Nitin Prakash
 * Author URI:        https://nitin247.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-product-author
 * Domain Path:       /languages
 */

// Exit if accessed directly

if ( ! function_exists( 'wcpa_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wcpa_fs() {
        global $wcpa_fs;

        if ( ! isset( $wcpa_fs ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $wcpa_fs = fs_dynamic_init( array(
                'id'                  => '4032',
                'slug'                => 'wc-product-author',
                'type'                => 'plugin',
                'public_key'          => 'pk_e7499d637a3698cec8a6594707be7',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'first-path'     => 'plugins.php',
                    'account'        => false,
                ),
            ) );
        }

        return $wcpa_fs;
    }

    // Init Freemius.
    wcpa_fs();
    // Signal that SDK was initiated.
    do_action( 'wcpa_fs_loaded' );
}


defined( 'ABSPATH' ) || die( 'Wordpress Error! Opening plugin file directly' );

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
    add_action( 'admin_notices', 'wc_product_author_install_admin_notice' );
    
}else{

	add_action('init', 'wc_product_author_add_author_woocommerce', 999 );

}


/* Admin notice if WooCommerce is not installed or active */

function wc_product_author_install_admin_notice(){
    echo '<div class="notice notice-error">';
    echo     '<p>'. _e( 'WC Product Author requires active WooCommerce Installation!', 'wc-product-author' ).'</p>';
    echo '</div>';
}

function wc_product_author_add_author_woocommerce() {
  add_post_type_support( 'product', 'author' );        
}

function wc_product_author_action_links( $links ) {
	$links = array_merge( array(
		'<a href="' . esc_url( 'https://nitin247.com/buy-me-a-coffe' ) . '">' . __( 'Donate', 'wc_product_author' ) . '</a>'
	), $links );
	return $links;
}

add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_product_author_action_links' );


