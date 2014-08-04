<?php
/*
Plugin Name: Woocommerce Event+ Product Type
Plugin URI: http://www.ideamktg.com
Description: 
Author: Idea Marketing Group
Version: 1.0.0
Author URI: http://www.ideamktg.com
Text Domain: woocommerce-event-product-type
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Globalize the main plugin variable
global $wc_ept;

function wp_ept_init() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

        // define global variables
        define( 'WC_EPT_ACTIVE', true );
        define( 'WC_EPT_VERSION', '1.0.0' );
        define( 'WC_EPT_PLUGIN', 'wc-event-product-type' );
        define( 'WC_EPT_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'WC_EPT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

        // load the required files        
        require WC_EPT_PLUGIN_DIR . '/inc/globals.php';
        require WC_EPT_PLUGIN_DIR . '/inc/functions.php';
        require WC_EPT_PLUGIN_DIR . '/inc/class.php';
        require WC_EPT_PLUGIN_DIR . '/inc/actions.php';
        require WC_EPT_PLUGIN_DIR . '/inc/filters.php';

    } else {
        function wp_ept_admin_notice() {
            echo '<div class="error"><p>' . __( 'Woocommerce must be installed and active to use the Event product type!' ) . '</p></div>';
        }
        add_action( 'admin_notices', 'wp_ept_admin_notice' );
    }
}
add_action( 'plugins_loaded', 'wp_ept_init' );

?>