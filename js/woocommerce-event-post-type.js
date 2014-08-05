jQuery(document).ready( function($) {
    if ( $('#wc_ept_fields').length ) {
        $('#wc_ept_fields').find('input.date').datepicker();
        $('.inventory_options, ._manage_stock_field, label[for="_downloadable"]').addClass('show_if_event');
    }
});