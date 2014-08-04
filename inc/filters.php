<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wc_wpt_product_type_selector( $types ){
    $types['event'] = __( 'Event' );
    return $types;
}
add_filter( 'product_type_selector', 'wc_wpt_product_type_selector' );

// Get the price HTML and edit it
function wc_wpt_get_price_html( $price, $product ) {

    if ( $product->product_type == 'event' ) {

        if ( is_admin() ) {
            return 'Variable';
        }

        if ( is_single() ) {
            return wc_ept_get_template('add-to-cart');
        }

        return 'See Pricing Options';
    } else {
        return $price;
    }
}
add_filter( 'woocommerce_get_price_html', 'wc_wpt_get_price_html', 100, 2 );

// Load cart data per page load
function get_cart_item_from_session( $cart_item, $values ) {    
    
    if ( ! empty( $values['wc_ept_product_type'] ) ) {
        $cart_item['wc_ept_product_type'] = $values['wc_ept_product_type'];
        // $cart_item = add_cart_item($cart_item);
    }

    // wp_debug( $cart_item, 'filter:woocommerce_get_cart_item_from_session:cart_item' );
    // wp_debug( $values, 'filter:woocommerce_get_cart_item_from_session:values' );
    
    return $cart_item;
}
add_filter( 'woocommerce_get_cart_item_from_session', 'get_cart_item_from_session', 20, 2 );

function wc_wpt_add_cart_item( $cart_item ) {

    // Adjust price if data is set
    if ( isset( $cart_item['data']->product_type ) && $cart_item['data']->product_type == 'event' && ! empty( $cart_item['wc_ept_product_type'] ) ) {

        // Set data
        $cart_item['data']->wc_ept_product_type = $cart_item['wc_ept_product_type'];

        // Get price
        $get_price = $cart_item['data']->get_current_price( $cart_item['wc_ept_product_type'] );

        if ( $get_price ) {
            $cart_item['data']->price = $get_price;
        }
    }

    // wp_debug( $cart_item, 'filter:woocommerce_add_cart_item' );
    
    return $cart_item;
}
add_filter( 'woocommerce_add_cart_item', 'wc_wpt_add_cart_item', 20, 1 );

// Add product type data to the cart item
function wc_wpt_add_cart_item_data( $cart_item, $product_id ) { 

    if ( ! empty( $_POST['wc_ept_product_type'] ) ) {
        $cart_item['wc_ept_product_type'] = $_POST['wc_ept_product_type'];
    }

    // wp_debug( $cart_item, 'filter:woocommerce_add_cart_item_data' );   
    
    return $cart_item;
}
add_filter( 'woocommerce_add_cart_item_data', 'wc_wpt_add_cart_item_data', 10, 2 );

// Get item data to display
function get_item_data( $other_data, $cart_item ) {

    if ( isset( $cart_item['wc_ept_product_type'] ) ) {
        global $wc_ept;

        // wp_debug( $wc_ept['types'] );

        $selection_title = isset( $wc_ept['types'][$cart_item['wc_ept_product_type']] ) ? $wc_ept['types'][$cart_item['wc_ept_product_type']] : $cart_item['wc_ept_product_type'];

        $other_data[] = array(
            'name'    => 'Selection',
            'value'   => $selection_title
        );
    }

    return $other_data;
}
add_filter( 'woocommerce_get_item_data', 'get_item_data', 10, 2 );

?>