<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wc_ept_custom_settings() {
    global $woocommerce, $post, $wc_ept;

    // Create #wc_ept_fields container
    ?> <div id="wc_ept_fields" class="show_if_event hide_if_grouped hide_if_simple hide_if_external hide_if_variable" style="display:none;"> <?php

    // Options group for event settings
    ?> <div class="options_group"> <?php
    ?> <h4 class="wc-ept-admin-hdr">Event Information</h4> <?php

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_event_date',
            'class'             => 'short date',
            'label'             => __( 'Event Date', 'woocommerce' ),
            'placeholder'       => 'MM/DD/YYYY',
            'desc_tip'          => 'true',
            'description'       => __( 'This is the actual date when this event is taking place', 'woocommerce' ),
            'type'              => 'text'
        )        
    );

    woocommerce_wp_select(
        array(
            'id'                => 'wc_ept_event_starting_time',
            'class'             => 'short',
            'label'             => __( 'Starting Time', 'woocommerce' ),
            'options'           => $wc_ept['time_select']
        )        
    );

    woocommerce_wp_select(
        array(
            'id'                => 'wc_ept_event_ending_time',
            'class'             => 'short',
            'label'             => __( 'Ending Time', 'woocommerce' ),
            'options'           => $wc_ept['time_select']
        )        
    );

    woocommerce_wp_select(
        array(
            'id'                => 'wc_ept_event_timezone',
            'class'             => 'short',
            'label'             => __( 'Timezone', 'woocommerce' ),
            'options'           => $wc_ept['time_zone_select']
        )        
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_event_last_sale_date',
            'class'             => 'short date',
            'label'             => __( 'Ticket Sale End Date', 'woocommerce' ),
            'placeholder'       => 'MM/DD/YYYY',
            'desc_tip'          => 'true',
            'description'       => __( 'This is the last day that tickets will be sold', 'woocommerce' ),
            'type'              => 'text'
        )
    );

    // Closing for event settings
    ?> </div> <?php

    // Options group for event pricing
    ?> <div class="options_group"> <?php
    ?> <h4 class="wc-ept-admin-hdr">Event Pricing</h4> <?php

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_event_price',
            'label'             => __( 'Event Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Price when event ticket is purchased alone', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_recording_price',
            'label'             => __( 'Recording Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Price when recording is purchased alone', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_bundle_price',
            'label'             => __( 'Bundle Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Price when event and recording are purchased together', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    // Closing for event pricing
    ?> </div> <?php

    // Options group for early bird pricing
    ?> <div class="options_group"> <?php
    ?> <h4 class="wc-ept-admin-hdr">Early Bird Sale</h4> <?php

    woocommerce_wp_checkbox(
        array(
            'id'                => 'wc_ept_has_early_bird_sale',
            'label'             => __( 'Enabled', 'woocommerce' )
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_early_bird_sale_starts',
            'class'             => 'short date',
            'label'             => __( 'Sale Starts', 'woocommerce' ),
            'placeholder'       => 'MM/DD/YYYY',
            'desc_tip'          => 'true',
            'description'       => __( 'This is the day that the early bird sale will be start. Leave blank to start anytime', 'woocommerce' ),
            'type'              => 'text'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_early_bird_sale_ends',
            'class'             => 'short date',
            'label'             => __( 'Sale Ends', 'woocommerce' ),
            'placeholder'       => 'MM/DD/YYYY',
            'desc_tip'          => 'true',
            'description'       => __( 'This is the day that the early bird sale will be good until. This must be set', 'woocommerce' ),
            'type'              => 'text'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_event_early_bird_price',
            'label'             => __( 'Event Sale Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Sale price when event ticket is purchased alone', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_recording_early_bird_price',
            'label'             => __( 'Recording Sale Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Sale price when recording is purchased alone', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    woocommerce_wp_text_input(
        array(
            'id'                => 'wc_ept_bundle_early_bird_price',
            'label'             => __( 'Bundle Sale Price (' . get_woocommerce_currency_symbol() . ')', 'woocommerce' ),
            'desc_tip'          => 'true',
            'description'       => __( 'Sale price when event and recording are purchased together', 'woocommerce' ),
            'type'              => 'text',
            'data_type'         => 'price'
        )
    );

    // Closing for early bird pricing
    ?> </div> <?php

    // Closing for #wc_ept_fields container
    ?> </div> <?php
}
add_action( 'woocommerce_product_options_general_product_data', 'wc_ept_custom_settings' );

// Save meta fields when creating or editing product
function wp_ept_save_meta_fields( $post_id ) {

    if ( isset( $_POST['product-type'] ) && $_POST['product-type'] != 'event' ) {
        return false;
    }

    $wc_ept_fields = array(
        'wc_ept_event_date',
        'wc_ept_event_starting_time',
        'wc_ept_event_ending_time',
        'wc_ept_event_timezone',
        'wc_ept_event_last_sale_date',
        'wc_ept_event_price',
        'wc_ept_recording_price',
        'wc_ept_bundle_price',
        'wc_ept_has_early_bird_sale',
        'wc_ept_early_bird_sale_starts',
        'wc_ept_early_bird_sale_ends',
        'wc_ept_event_early_bird_price',
        'wc_ept_recording_early_bird_price',
        'wc_ept_bundle_early_bird_price'
    );

    foreach ( $wc_ept_fields as $field ) {
        if ( ! empty( $_POST[$field] ) ) {
            update_post_meta( $post_id, $field, esc_attr( $_POST[$field] ) );
        } else {
            update_post_meta( $post_id, $field, '' );
        }
    }

    // Check if early bird sale is checked
    $early_bird_sale = isset( $_POST['wc_ept_has_early_bird_sale'] ) ? 'yes' : '';
    update_post_meta( $post_id, 'wc_ept_has_early_bird_sale', $early_bird_sale );

    $_POST['_regular_price'] = $_POST['wc_ept_event_price'];
    update_post_meta( $post_id, '_regular_price', $_POST['_regular_price'] );

    wc_delete_product_transients( $product_id );
    
}
add_action( 'woocommerce_process_product_meta', 'wp_ept_save_meta_fields' );

// Enqueue scripts and stylesheets in admin
function wc_ept_enqueue_scripts() {
    wp_enqueue_style( 'wc_ept_admin_style', WC_EPT_PLUGIN_URL . '/css/wc-ept-admin.css' );
    wp_enqueue_script( 'wc_event_post_type', WC_EPT_PLUGIN_URL . '/js/woocommerce-event-post-type.js' );
}
add_action( 'admin_enqueue_scripts', 'wc_ept_enqueue_scripts' );

// Add the event pricing to the product page
function wc_ept_add_pricing_to_product() {
    global $product;

    if ( $product->product_type == 'event' ) {
        echo $product->get_pricing_html();
    }
}
add_action( 'woocommerce_before_add_to_cart_button', 'wc_ept_add_pricing_to_product' );

function wc_ept_add_cart_item_meta( $id, $item ) {
    // wp_debug( $item, 'action:woocommerce_add_order_item_meta' );

    if ( empty( $item['wc_ept_product_type'] ) ) return false;
    woocommerce_add_order_item_meta( $id, 'wc_ept_product_type', $item['wc_ept_product_type'], true );
}
add_action( 'woocommerce_add_order_item_meta', 'wc_ept_add_cart_item_meta', 10, 2 );

function wc_ept_set_custom_pricing( $cart_object ) {
    foreach ( $cart_object->cart_contents as $key => $item ) {

        if ( isset( $item['data']->product_type ) && $item['data']->product_type == 'event' && ! empty( $item['wc_ept_product_type'] ) ) {
            $get_price = $item['data']->get_current_price( $item['wc_ept_product_type'] );

            if ( $get_price ) {
                $item['data']->price = $get_price;
            }
        }

        // wp_debug( $item, 'action:woocommerce_before_calculate_totals' );
    }
}
add_action( 'woocommerce_before_calculate_totals', 'wc_ept_set_custom_pricing' );

?>