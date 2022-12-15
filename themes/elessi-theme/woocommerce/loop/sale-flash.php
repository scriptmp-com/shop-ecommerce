<?php
/**
 * Product loop sale flash
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 1.6.4
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $nasa_opt, $post, $product;

$badges = '';

/**
 * Featured
 */
if (isset($nasa_opt['featured_badge']) && $nasa_opt['featured_badge'] && $product->is_featured()):
    $badges .= '<span class="badge featured-label">' . esc_html__('Featured', 'elessi-theme') . '</span>';
endif;

/**
 * On Sale Badge
 */
if ($product->is_on_sale()) :
    $badges_sale = '';
    
    if ($product->get_type() == 'variable') :
        $badges_sale = '<span class="badge sale-label sale-variable">' . esc_html__('Sale', 'elessi-theme') . '</span>';
    else :
        $maximumper = 0;
        $regular_price = $product->get_regular_price();
        $sale_price = $product->get_sale_price();
        
        if (is_numeric($sale_price)) :
            $percentage = $regular_price ? round(((($regular_price - $sale_price) / $regular_price) * 100), 0) : 0;
            
            if ($percentage > $maximumper) :
                $maximumper = $percentage;
            endif;

            $badges_sale = '<span class="badge sale-label">' . sprintf(esc_html__('&#45;%s&#37;', 'elessi-theme'), $maximumper) . '</span>';
        endif;
    endif;

    /**
     * Hook onsale WooCommerce
     */
    $badges .= apply_filters('woocommerce_sale_flash', $badges_sale, $post, $product);

    /**
     * Style show with Deal product
     */
    $badges .= '<span class="badge deal-label">' . esc_html__('Limited', 'elessi-theme') . '</span>';
endif;

/**
 * Out of stock
 */
if ("outofstock" === $product->get_stock_status()):
    $badges .= elessi_badge_outofstock();
endif;

/**
 * Hook to Badges
 */
$badges_content = apply_filters('nasa_badges', $badges);

if ('' !== $badges_content) :
    echo '<div class="nasa-badges-wrap">' . $badges_content . '</div>';
endif;
