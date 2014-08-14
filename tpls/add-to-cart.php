<?php global $product; ?>
<?php if ( $product->is_purchasable() ) : ?>
    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>    
    <form id="ept-form" method="post" enctype='multipart/form-data'>

    <?php if ( $product->has_event() ) : ?>

        <?php if ( $product->timenow == $product->meta->event_date ) : ?>
        <p class="ept-note today">This event is happening today. Tickets are no longer available for sale.</p>
        <?php endif; ?>

        <?php if ( $product->event_has_past() ) : ?>
        <p class="ept-note ended">This event has already ended. Tickets are no longer available for sale.</p>
        <?php endif; ?>

        <?php if ( ! $product->event_has_past() && $product->event_sale_has_passed() && $product->timenow != $product->meta->event_date ) : ?>
        <p class="ept-note ended">Tickets are no longer being sold for this event.</p>
        <?php endif; ?>

        <?php if ( ! $product->event_has_past() && ! $product->event_sale_has_passed() ) : ?>
        <p class="ept-note notice">Purchase your ticket before <strong><?php echo $product->format_ept_datestamp( $product->meta->event_last_sale_date ); ?></strong> to reserve your seat!</p>
        <?php endif; ?>

    <?php endif; ?>

        <dl id="ept-info">
            <?php if ( $product->has_event() ) : ?>
            <dt>Event Date</dt><dd><?php echo $product->get_event_date(); ?></dd>
            <dt>Event Time</dt><dd><?php echo $product->get_event_time(); ?></dd>
            <?php endif; ?>
        </dl>
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <?php if ( $product->can_add_to_cart() ) : ?>
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
        <?php endif; ?>
        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </form>
    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php else : ?>
    <p>Sorry, this item is no longer available.</p>
<?php endif; ?>