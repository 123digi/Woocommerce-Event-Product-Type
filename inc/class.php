<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WC_Product_Event extends WC_Product {

    private $timenow;

    public function __construct( $product ) {
        $this->product_type = 'event';
        parent::__construct( $product );

        $this->timenow  = date( 'Ymd', time() );
        $this->meta     = $this->get_meta();
    }

    public function get_meta() {

        $meta_fields = array(
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

        $meta = new stdClass();

        foreach ( $meta_fields as $field ) {
            $field_name = str_replace( 'wc_ept_', '', $field );
            $meta->{$field_name} = get_post_meta( $this->id, $field, true );
        }

        $meta->event_date               = $this->string_to_ept_datestamp( $meta->event_date );
        $meta->event_starting_time      = $this->get_value_from_global( 'time_select', $meta->event_starting_time );
        $meta->event_ending_time        = $this->get_value_from_global( 'time_select', $meta->event_ending_time );
        $meta->event_timezone           = $this->get_value_from_global( 'time_zone_select', $meta->event_timezone );
        $meta->event_last_sale_date     = $this->string_to_ept_datestamp( $meta->event_last_sale_date );
        $meta->early_bird_sale_starts   = $this->string_to_ept_datestamp( $meta->early_bird_sale_starts );
        $meta->early_bird_sale_ends     = $this->string_to_ept_datestamp( $meta->early_bird_sale_ends );

        if ( $meta->event_date && ! $meta->event_last_sale_date ) {
            $meta->event_last_sale_date = $meta->event_date;
        }

        return $meta;
    }

    public function get_pricing() {

        global $wc_ept;        
        $pricing = array();

        foreach ( $wc_ept['types'] as $type => $title ) {
            
            // Check if last sale date is set, if not set to event date
            if ( ( $type == 'event' || $type == 'bundle' ) && $this->event_sale_has_passed() ) {                
                $pricing[$type] = false;             
                continue;
            }
            
            $key_rp = $type . '_price';
            $key_ep = $type . '_early_bird_price';

            if ( $type == 'recording' && ! $this->meta->{$key_rp} ) {
                $pricing[$type] = false;             
                continue;
            }

            $pricing[$type]['regular'] = $this->meta->{$key_rp};

            // check for early bird sale
            if ( $this->early_bird_sale_is_active() && $this->meta->{$key_ep} ) {
                $pricing[$type]['sale'] = $this->meta->$key_ep;
            } else {
                $pricing[$type]['sale'] = false;
            }

        }

        return $pricing;
        
    }

    public function get_current_price( $type = '' ) {
        $pricing = $this->get_pricing();

        if ( ! empty( $pricing[$type] ) ) {
            if ( ! empty( $pricing[$type]['regular'] ) ) {
                if ( ! empty( $pricing[$type]['sale'] ) ) {
                    return $pricing[$type]['sale'];
                } else {
                    return $pricing[$type]['regular'];
                }
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function event_has_past() {
        return $this->meta->event_date && $this->meta->event_date >= $this->timenow ? false : true;
    }

    public function event_sale_has_passed() {
        return ( $this->meta->event_last_sale_date && $this->meta->event_last_sale_date <= $this->timenow ) ? true : false;
    }    

    public function early_bird_sale_is_active() {
        if ( ! $this->meta->has_early_bird_sale ) return false;
        if ( ! $this->meta->early_bird_sale_ends ) return false;

        $starts = $this->meta->early_bird_sale_starts;
        $ends   = $this->meta->early_bird_sale_ends;
        $now    = $this->timenow;

        if ( ! $starts ) $starts = $now;

        if ( $starts <= $now && $ends >= $now && $ends != $now ) {
            return true;
        } else {
            return false;
        }
    }

    public function get_pricing_html() {

        global $wc_ept;        
        $pricing    = $this->get_pricing();
        $html       = '';
        $first_item = ' checked="checked"';

        foreach ( $wc_ept['types'] as $type => $title ) { 
            $price_html = '';

            if ( ! empty( $pricing[$type]['regular'] ) ) {
                if ( ! empty( $pricing[$type]['sale'] ) ) {
                    $price_html = '<span class="wc_ept_strike" style="text-decoration:line-through">' . woocommerce_price( $pricing[$type]['regular'] ) . '</span> ' . woocommerce_price( $pricing[$type]['sale'] );
                } else {
                    $price_html = woocommerce_price( $pricing[$type]['regular'] );
                }

                $html .= '<li class="wc_ept_radio"><label><input type="radio" name="wc_ept_product_type" value="' . $type . '"' . $first_item . '>' . $title . '</label><span class="wc_ept_price">' . $price_html . '</span></li>';
                $first_item = '';
            }
        }

        if ( $html != '' ) {
            $html = '<ul id="wc_ept_pricing">' . $html . '</ul>';

            if ( $this->early_bird_sale_is_active() ) {
                $html .= '<div id="wc_ept_early_bird_message"><p>Purchase before ' . $this->format_ept_datestamp( $this->meta->early_bird_sale_ends ) . ' to get the early bird price!</p></div>';
            }
        } else {
            $html = '<p>Pricing is not available for this product</p>';
        }

        return $html;
    }

    private function string_to_ept_datestamp( $string = '' ) {
        $stamp = strtotime( $string );
        return $stamp ? date( 'Ymd', $stamp ) : $string;
    }

    public function format_ept_datestamp( $string = '' ) {
        $stamp = strtotime( $string );
        return $stamp ? date( get_option( 'date_format' ), $stamp ) : $string;
    }

    private function get_value_from_global( $key = '', $index = 0 ) {
        global $wc_ept;
        if ( empty( $key ) || $key == '' ) return '';
        return isset( $wc_ept[$key][(int)$index] ) ? $wc_ept[$key][(int)$index] : '';
    }

}

?>