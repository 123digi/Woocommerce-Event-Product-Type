<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wc_ept_get_template( $file = '' ) {

    $file = rtrim( ltrim( $file, '/' ), '.php' );
    $file_path = WC_EPT_PLUGIN_DIR .'/tpls/' . $file . '.php';

    if ( ! file_exists( $file_path ) ) return '';

    ob_start();
    include $file_path;
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

?>