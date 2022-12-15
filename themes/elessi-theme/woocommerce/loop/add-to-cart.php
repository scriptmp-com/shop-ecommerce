<?php

/**
 * Loop Add to Cart
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.3.0
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $product;

echo apply_filters(
    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
    sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s>' .
            '<span class="add_to_cart_text">%s</span>' .
            '<i class="%s"></i>' .
        '</a>',
        esc_url($product->add_to_cart_url()),
        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
        esc_attr(isset($args['class']) ? $args['class'] : 'add-to-cart-grid btn-link nasa-tip'),
        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
        esc_html($product->add_to_cart_text()),
        esc_attr(isset($args['icon_class']) && $args['icon_class'] ? esc_attr($args['icon_class']) : 'nasa-df-plus')
    ),
    $product,
    $args
);
