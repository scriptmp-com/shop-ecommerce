<?php
/**
 * Checkout Form: Layout - Modern
 */
if (!defined('ABSPATH')) {
    exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) :
    /**
     * Hook Login form
     */
    do_action('woocommerce_before_checkout_form', $checkout);
    
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', esc_html__('You must be logged in to checkout.', 'elessi-theme'));
    
    return;
endif;

// $need_shipping = true === WC()->cart->needs_shipping_address() ? true : false;
?>

<!-- Checkout BG -->
<div class="checkout-modern-bg hide-for-mobile">
    <div class="checkout-modern-bg-left"></div>
    <div class="checkout-modern-bg-right"></div>
</div>

<div class="row">
    
    <!-- Checkout Wrap -->
    <div class="checkout-modern-wrap large-12 columns">
        
        <!-- Checkout Left -->
        <div class="checkout-modern-left-wrap">
            <!-- Checkout Logo -->
            <div class="mobile-text-center">
                <?php echo elessi_logo(); ?>
            </div>
            
            <!-- Checkout Mobile Your Order -->
            <a href="javascript:void(0);" class="hidden-tag your-order-mobile" rel="nofollow">
                <span class="your-order-title">
                    <i class="nasa-icon icon-nasa-cart-3 margin-right-10 rtl-margin-right-0 rtl-margin-left-10"></i><?php echo esc_html__('Your Order', 'elessi-theme'); ?><i class="nasa-icon icon-nasa-icons-10 margin-left-10 rtl-margin-left-0 rtl-margin-right-10"></i>
                </span>
                <span class="your-order-price"></span>
            </a>
            
            <!-- Checkout Breadcrumb -->
            <nav class="nasa-bc-modern">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php echo esc_attr__('CART', 'elessi-theme'); ?>"><?php echo esc_html__('CART', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                
                <a href="javascript:void(0);" title="<?php echo esc_attr__('INFORMATION', 'elessi-theme'); ?>" rel="nofollow" class="nasa-billing-step active"><?php echo esc_html__('INFORMATION', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                
                <?php // if ($need_shipping) : ?>
                <a href="javascript:void(0);" title="<?php echo esc_attr__('SHIPPING', 'elessi-theme'); ?>" rel="nofollow" class="nasa-shipping-step"><?php echo esc_html__('SHIPPING', 'elessi-theme'); ?></a>
                <i class="nasa-bc-modern-sp"></i>
                <?php // endif; ?>
                
                <a href="javascript:void(0);" title="<?php echo esc_attr__('PAYMENT', 'elessi-theme'); ?>" rel="nofollow" class="nasa-payment-step"><?php echo esc_html__('PAYMENT', 'elessi-theme'); ?></a>
            </nav>

            <?php do_action('woocommerce_before_checkout_form', $checkout); ?>
            
            <!-- Checkout Form -->
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                <?php
                $fields = $checkout->get_checkout_fields();
                if ($fields) :
                    
                    do_action('woocommerce_checkout_before_customer_details');
                    
                    $billing_fields = isset($fields['billing']) ? $fields['billing'] : null;
                    $email_fields = isset($billing_fields['billing_email']) ? $billing_fields['billing_email'] : null;
                    
                    if ($email_fields || (!is_user_logged_in() && $checkout->is_registration_enabled())) : ?> 
                        <!-- Custom Contact Information -->
                        <div class="checkout-group checkout-contact margin-bottom-10 clearfix" id="ns-checkout-contact">
                            <h3>
                                <?php echo esc_html__('Contact information', 'elessi-theme'); ?>
                            </h3>
                            <div class="form-row-wrap">
                                <p class="form-row form-row-wide nasa-email-field">
                                    <label for=""><?php echo esc_html__('Email address', 'elessi-theme'); ?>&nbsp;</label>
                                    <span class="woocommerce-input-wrapper">
                                        <input type="email" class="input-text" placeholder="Email address" value="" disabled />
                                    </span>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="checkout-group woo-billing clearfix">
                        <div id="customer_details">
                            <?php if (true === WC()->cart->needs_shipping_address() && 'shipping' === get_option('woocommerce_ship_to_destination')) : ?>
                                <div class="ns-shipping-first">
                                    <h3>
                                        <?php echo esc_html__('Shipping address', 'elessi-theme'); ?>
                                    </h3>
                                    <?php do_action('woocommerce_checkout_shipping'); ?>
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>
                            <?php else : ?>
                                <?php do_action('woocommerce_checkout_billing'); ?>
                                <?php do_action('woocommerce_checkout_shipping'); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                <?php endif; ?>
            </form>

            <?php do_action('woocommerce_after_checkout_form', $checkout); ?>
        </div>

        <!-- Checkout Right -->
        <div class="checkout-modern-right-wrap">
            <a href="javascript:void(0);" class="hidden-tag close-your-order-mobile nasa-stclose" rel="nofollow"></a>
            
            <?php
            /**
             * Custom action
             */
            do_action('nasa_checkout_before_order_review');
            ?>

            <div class="order-review order-review-modern">
                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <h3 id="order_review_heading" class="order_review-heading">
                    <?php esc_html_e('Your order', 'elessi-theme'); ?>
                </h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>

            <?php
            /**
             * Custom action
             */
            do_action('nasa_checkout_after_order_review');
            ?>
        </div>
    </div>
</div>
