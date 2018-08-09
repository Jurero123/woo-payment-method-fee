<?php

/**
 * Add fee to COD payments.
 */
function jr_woocommerce_custom_fee() {

	if ( ( is_admin() && ! defined( 'DOING_AJAX' ) ) || ! is_checkout() ) {
		return;
	}

	$chosen_gateway = WC()->session->chosen_payment_method;

	$fee = 1.99;

	if ( $chosen_gateway == 'cod' ) {
		WC()->cart->add_fee( __( 'Shiiping option fee', 'storefront' ), $fee, false, '' );
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'jr_woocommerce_custom_fee' );



/**
 * Update cart on payment method change.
 */
function jr_cart_update_script() {
	if ( is_checkout() ) : ?>
		<script>
            jQuery(function ($) {

                // woocommerce_params is required to continue, ensure the object exists
                if (typeof woocommerce_params === 'undefined') {
                    return false;
                }

                $checkout_form = $('form.checkout');

                $checkout_form.on('change', 'input[name="payment_method"]', function () {
                    $checkout_form.trigger('update');
                });


            });
		</script>
	<?php endif;
}
add_action( 'wp_footer', 'jr_cart_update_script', 999 );
