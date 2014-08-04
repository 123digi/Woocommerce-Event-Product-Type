<?php global $product; ?>
<?php if ( $product->is_in_stock() && $product->is_purchasable() ) : ?>
    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
    <form class="cart" method="post" enctype='multipart/form-data'>
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </form>
    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
<?php endif; ?>