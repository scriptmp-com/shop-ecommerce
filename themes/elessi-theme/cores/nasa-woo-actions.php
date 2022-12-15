<?php
defined('ABSPATH') or die(); // Exit if accessed directly
/**
 * Disable default Yith Woo wishlist button
 */
if (NASA_WISHLIST_ENABLE && function_exists('YITH_WCWL_Frontend')) {
    remove_action('init', array(YITH_WCWL_Frontend(), 'add_button'));
}

/**
 * Remove action woocommerce
 */
add_action('init', 'elessi_remove_action_woo');
if (!function_exists('elessi_remove_action_woo')) :
    function elessi_remove_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare;
        
        /**
         * UNREGISTRER DEFAULT WOOCOMMERCE HOOKS
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_show_messages', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
        
        remove_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 20);
        // remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        
        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            remove_action('woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30);
            remove_action('woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30);
            remove_action('woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30);
        }
        
        remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
        remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);

        remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
        
        /**
         * Remove compare default
         */
        if ($yith_woocompare) {
            $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
            remove_action('woocommerce_after_shop_loop_item', array($nasa_compare, 'add_compare_link'), 20);
            remove_action('woocommerce_single_product_summary', array($nasa_compare, 'add_compare_link'), 35);
        }
        
        /**
         * For content-product
         */
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail');
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        
        if (NASA_ELEMENTOR_ACTIVE) {
            // Loop Price
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            // Loop Rating
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        }
        
        /**
         * Shop page
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
        
        /**
         * Mini Cart
         */
        remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal', 10);
        
        /**
         * Remove Relate | Up-sell Products
         */
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
        
        /**
         * Remove product Thumbnail Mobile layout Modern
         */
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            if (isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] == 'app') {
                remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
            }
        }
    }
endif;

/**
 * Add action woocommerce
 */
add_action('init', 'elessi_add_action_woo');
if (!function_exists('elessi_add_action_woo')) :
    function elessi_add_action_woo() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $yith_woocompare, $nasa_loadmore_style;
        
        add_action('nasa_child_cat', 'elessi_get_childs_category', 10, 2);
        
        /**
         * Results count in shop page
         */
        $disable_ajax_product = (isset($nasa_opt['disable_ajax_product']) && $nasa_opt['disable_ajax_product']) ? true : false;
        
        $pagination_style = isset($nasa_opt['pagination_style']) ? $nasa_opt['pagination_style'] : 'style-2';
        
        if (isset($_REQUEST['paging-style']) && in_array($_REQUEST['paging-style'], $nasa_loadmore_style)) {
            $pagination_style = $_REQUEST['paging-style'];
        }
        
        if ($disable_ajax_product) {
            $pagination_style = $pagination_style == 'style-2' ? 'style-2' : 'style-1';
        } else {
            add_action('woocommerce_before_main_content', 'elessi_open_woo_main');
            add_action('woocommerce_after_main_content', 'elessi_close_woo_main');
        }
        
        if (in_array($pagination_style, $nasa_loadmore_style)) {
            add_action('nasa_shop_category_count', 'elessi_result_count', 20);
        } else {
            add_action('nasa_shop_category_count', 'woocommerce_result_count', 20);
        }
        
        add_action('woocommerce_archive_description', 'elessi_before_archive_description', 1);
        add_action('woocommerce_archive_description', 'elessi_get_cat_top', 5);
        add_action('woocommerce_archive_description', 'elessi_after_archive_description', 999);
        
        add_action('woocommerce_after_shop_loop', 'elessi_get_cat_bottom', 1000);
        
        add_action('nasa_change_view', 'elessi_nasa_change_view', 10, 1);

        add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');
        // add_action('woocommerce_mini_cart_contents', 'woocommerce_cross_sell_display');
        add_action('popup_woocommerce_after_cart', 'woocommerce_cross_sell_display');
        
        /* if (
            isset($nasa_opt['event-after-add-to-cart']) &&
            $nasa_opt['event-after-add-to-cart'] == 'sidebar' &&
            isset($nasa_opt['mini_cart_crsells']) &&
            $nasa_opt['mini_cart_crsells']
        ) {
            add_action('nasa_mini_cart_cross_sell', 'woocommerce_cross_sell_display');
        } */
        
        add_action('nasa_mini_cart_before_total', 'elessi_ext_mini_cart', 5);
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_loop_rating', 10);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_price', 15);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_excerpt', 20);
        
        /**
         * Deal time for Quickview product
         */
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_lightbox_summary', 'elessi_deal_time_quickview', 29);
            add_filter('woocommerce_available_variation', 'elessi_variation_deal_time');
        }
        
        if (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart']) {
            add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
        
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_meta', 40);
        add_action('woocommerce_single_product_lightbox_summary', 'woocommerce_template_single_sharing', 50);
        
        add_action('nasa_single_product_layout', 'elessi_single_product_layout', 1);
        
        /**
         * Single Product WooCommerce Tabs
         */
        add_action('woocommerce_after_single_product_summary', 'elessi_clearboth', 11);
        add_action('woocommerce_after_single_product_summary', 'elessi_open_wrap_12_cols', 11);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11);
        add_action('woocommerce_after_single_product_summary', 'elessi_close_wrap_12_cols', 11);
        
        // add_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        add_action('woocommerce_single_product_summary', 'elessi_next_prev_single_product', 6);

        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15);
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 20);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 25);
        
        $in_mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        /**
         * For Mobile App
         */
        if ($in_mobile && isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] == 'app') {
            add_action('woocommerce_single_product_summary', 'elessi_begin_wrap', 4);
            add_action('woocommerce_single_product_summary', 'elessi_end_wrap', 21);
            
            add_action('woocommerce_before_add_to_cart_button', 'elessi_begin_wrap', 999);
            add_action('woocommerce_after_add_to_cart_button', 'elessi_end_wrap', 999);
        }
        
        /**
         * Deal time for Single product
         */
        if (!isset($nasa_opt['single-product-deal']) || $nasa_opt['single-product-deal']) {
            add_action('woocommerce_single_product_summary', 'elessi_deal_time_single', 29);
        }
        
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 40);
        
        /**
         * Add Relate | Up-sell Products
         */
        add_action('nasa_single_product_layout', 'woocommerce_upsell_display', 15);
        if (!isset($nasa_opt['relate_product']) || $nasa_opt['relate_product']) {
            add_action('nasa_single_product_layout', 'woocommerce_output_related_products', 20);
        }
        
        /**
         * Remove heading Description tab
         */
        add_filter('woocommerce_product_description_heading', '__return_false');
        
        /**
         * Add compare product
         */
        if ($yith_woocompare) {
            if (get_option('yith_woocompare_compare_button_in_product_page') == 'yes') {
                add_action('nasa_single_buttons', 'elessi_add_compare_in_detail', 20);
            }
            
            if (get_option('yith_woocompare_compare_button_in_products_list') == 'yes') {
                add_action('nasa_show_buttons_loop', 'elessi_add_compare_in_list', 50);
            }
        }
        
        /**
         * Single Product Ajax Call
         */
        add_action('woocommerce_after_single_product', 'elessi_ajax_single_product_tag');
        
        /**
         * Add to Cart in list - Loop
         */
        add_filter('woocommerce_loop_add_to_cart_args', 'elessi_loop_add_to_cart_args', 10, 2);
        
        if (
            (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) &&
            (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart'])
        ) {
            add_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 10);
        }
        
        /**
         * Wishlist in loop
         */
        add_action('nasa_show_buttons_loop', 'elessi_add_wishlist_in_list', 20);
        
        /**
         * Quick view in loop
         */
        if (!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview']) {
            add_action('nasa_show_buttons_loop', 'elessi_quickview_in_list', 40);
        }
        
        /**
         * Notice in Archive Products Page | Single Product Page
         */
        add_action('woocommerce_before_main_content', 'woocommerce_output_all_notices', 10);
        
        /**
         * Nasa ADD BUTTON BUY NOW
         */
        add_action('woocommerce_after_add_to_cart_button', 'elessi_add_buy_now_btn');
        
        /**
         * Nasa Add Custom fields
         */
        add_action('woocommerce_after_add_to_cart_button', 'elessi_add_custom_field_detail_product', 25);
        
        /**
         * Nasa top_sidebar_shop
         */
        add_action('nasa_top_sidebar_shop', 'elessi_top_sidebar_shop', 10, 1);
        add_action('nasa_sidebar_shop', 'elessi_side_sidebar_shop', 10 , 1);
        
        /**
         * For Product content
         */
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_countdown');
        
        /**
         * Custom filters woocommerce_post_class
         */
        add_filter('woocommerce_post_class', 'elessi_custom_woocommerce_post_class', 10, 2);
        
        add_action('nasa_get_content_products', 'elessi_get_content_products', 10, 1);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_btns', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_gift_featured', 15);
        add_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_thumbnail', 20);
        
        add_action('woocommerce_after_shop_loop_item', 'elessi_content_show_in_list');
        
        add_action('woocommerce_shop_loop_item_title', 'elessi_loop_product_cats', 5);
        add_action('woocommerce_shop_loop_item_title', 'elessi_loop_product_content_title', 10);
        add_action('woocommerce_after_shop_loop_item_title', 'elessi_loop_product_description', 15, 1);
        
        if (NASA_ELEMENTOR_ACTIVE) {
            // Loop Price
            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
            // Loop Rating
            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
        }
        
        /**
         * Add to wishlist in Single Product
         */
        add_action('nasa_single_buttons', 'elessi_add_wishlist_in_detail', 15);
        
        /**
         * Hide Uncategorized
         */
        if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
            add_filter('woocommerce_product_subcategories_args', 'elessi_hide_uncategorized');
        }
        
        /**
         * Share icon in Single Product
         */
        add_action('woocommerce_share', 'elessi_before_woocommerce_share', 5);
        add_action('woocommerce_share', 'elessi_woocommerce_share', 10);
        add_action('woocommerce_share', 'elessi_after_woocommerce_share', 15);
        
        /**
         * Mini Cart
         */
        add_action('woocommerce_widget_shopping_cart_total', 'elessi_widget_shopping_cart_subtotal', 10);
        add_action('woocommerce_widget_shopping_cart_total', 'elessi_widget_shopping_cart_ext', 15);
        
        /**
         * Add src image large for variation
         */
        add_filter('woocommerce_available_variation', 'elessi_src_large_image_single_product');
        
        /**
         * Add class Sub Categories
         */
        add_filter('product_cat_class', 'elessi_add_class_sub_categories');
        
        /**
         * Filter redirect checkout buy now
         */
        add_filter('woocommerce_add_to_cart_redirect', 'elessi_buy_now_to_checkout');
        
        /**
         * Filter Single Stock
         */
        if (!isset($nasa_opt['enable_progess_stock']) || $nasa_opt['enable_progess_stock']) {
            add_filter('woocommerce_get_stock_html', 'elessi_single_stock', 10, 2);
        }
        
        /**
         * Disable redirect Search one product to single product
         */
        add_filter('woocommerce_redirect_single_search_result', '__return_false');
        
        /**
         * Custom Tabs in Single product
         */
        add_filter('woocommerce_product_tabs', 'elessi_custom_tabs_single_product');
        
        /**
         * Checkout - Layout
         */
        add_action('nasa_checkout_form_layout', 'elessi_checkout_form_layout', 10, 1);
        
        /**
         * Actions for Checkout Modern
         */
        if (defined('NASA_CHECKOUT_LAYOUT') && NASA_CHECKOUT_LAYOUT == 'modern') {
            add_filter('woocommerce_update_order_review_fragments', 'elessi_update_order_review_fragments');
            add_filter('woocommerce_checkout_fields', 'elessi_checkout_email_first');
            
            add_action('woocommerce_checkout_after_customer_details', 'elessi_step_billing', 15);
            
            add_action('woocommerce_checkout_after_customer_details', 'elessi_checkout_shipping', 20);
            
            remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
            
            add_action('woocommerce_review_order_before_payment', 'elessi_checkout_payment_open', 5);
            add_action('woocommerce_review_order_before_payment', 'elessi_checkout_payment_headling');
            add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 25);
            add_action('woocommerce_review_order_after_payment', 'elessi_checkout_payment_close', 100);
            
            if (function_exists('woocommerce_gzd_template_order_submit')) {
                remove_action('woocommerce_checkout_order_review', 'woocommerce_gzd_template_order_submit', 21);
                add_action('woocommerce_review_order_after_payment', 'woocommerce_gzd_template_order_submit', 95);
            }
            
            /**
             * Case Shipping Address First
             */
            if ('shipping' === get_option('woocommerce_ship_to_destination')) {
                add_action('woocommerce_review_order_before_payment', 'elessi_checkout_modern_billing_detail', 4);
                add_filter('woocommerce_shipping_fields', 'elessi_checkout_add_shipping_phone');
                add_filter('woocommerce_checkout_posted_data', 'elessi_checkout_modern_posted_data');
            }
            
            // remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
            add_action('woocommerce_review_order_after_cart_contents', 'elessi_checkout_coupon_form_clone');
        }
        
        /**
         * woocommerce_form_field_args
         */
        add_filter('woocommerce_form_field_args', 'elessi_wc_form_field_args');
        
        
    }
endif;

/**
 * WC_germanized - Compatible
 */
add_action('init', 'elessi_plg3rd_compatible_acts');
if (!function_exists('elessi_plg3rd_compatible_acts')) :
    function elessi_plg3rd_compatible_acts() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        /**
         * Compatible with YITH WooCommerce Product Bundles - Mini Cart
         */
        if (function_exists('yith_wcpb_frontend')) {
            $yith_wcpb_frontend = yith_wcpb_frontend();
            
            if ($yith_wcpb_frontend) {
                add_filter('woocommerce_mini_cart_item_class', array($yith_wcpb_frontend, 'add_cart_item_class_for_bundles'), 10, 3);
            }
        }
        
        /**
         * Yith Woo Product Bundle in Loop
         */
        add_action('nasa_show_buttons_loop', 'elessi_bundle_in_list', 60);
        
        /**
         * Compatible with WC_Vendor plugin
         */
        if (class_exists('WCV_Vendor_Shop')) {
            if (has_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9)) {
                remove_action('woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9);
                add_action('woocommerce_after_shop_loop_item_title', 'elessi_wc_vendor_template_loop_sold_by');
            }
            
            if (has_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'))) {
                remove_action('woocommerce_product_meta_start', array('WCV_Vendor_Cart', 'sold_by_meta'));
                add_action('woocommerce_product_meta_start', 'elessi_wc_vendor_sold_by_meta');
            }
        }
        
        /**
         * Compatible - WOOF - WooCommerce Products Filter
         */
        if (function_exists('woof')) {
            $woof = woof();
            
            $show = isset($woof->settings['show_images_by_attr_show']) ? $woof->settings['show_images_by_attr_show'] : false;
            if ($show) {
                remove_action('woocommerce_before_shop_loop_item_title', 'elessi_loop_product_content_thumbnail', 20);
            }
        }
    
        /**
         * WC_germanized - Compatible
         */
        if (function_exists('WC_germanized')) {
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_gzd_template_loop_shipping_costs_info', 7);
            add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_gzd_template_loop_shipping_costs_info', 99);
        }
    }
endif;

/**
 * Group buttons in content product grid
 */
add_action('template_redirect', 'elessi_before_ct_product_grid_btns', 15);
if (!function_exists('elessi_before_ct_product_grid_btns')) :
    function elessi_before_ct_product_grid_btns() {
        do_action('nasa_ct_product_grid_btns');
    }
endif;

/**
 * Check archive product
 */
add_action('template_redirect', 'elessi_check_shop_page');
if (!function_exists('elessi_check_shop_page')) :
    function elessi_check_shop_page() {
        if (NASA_WOO_ACTIVED && is_shop()) {
            add_action('nasa_after_breadcrumb', 'elessi_shop_after_breadcrumb');
        }
    }
endif;

/**
 * After Breadcrumb for archive
 */
if (!function_exists('elessi_shop_after_breadcrumb')) :
    function elessi_shop_after_breadcrumb() {
        global $nasa_opt;
        
        if (isset($nasa_opt['shop_brdc_blk']) && $nasa_opt['shop_brdc_blk']) {
            $do_content = elessi_get_block($nasa_opt['shop_brdc_blk']);
            
            if (trim($do_content) != '') {
                echo '<div class="nasa-archive-after-breadcrumb large-12 columns">';
                echo $do_content;
                echo '</div>';
            }
        }
    }
endif;

/**
 * Custom actions loop buttons in product card style - Grid
 */
add_action('nasa_ct_product_grid_btns', 'elessi_ct_product_grid_btns');
if (!function_exists('elessi_ct_product_grid_btns')) :
    function elessi_ct_product_grid_btns() {
        global $nasa_opt;

        if (isset($nasa_opt['loop_layout_buttons'])) {
            /**
             * Product Card Styles - [style 3 | modern-1]  [style 5 | modern-3]
             */
            if (in_array($nasa_opt['loop_layout_buttons'], array('modern-1', 'modern-5'))) {
            
                /**
                 * Wishlist in loop - Yith Wishlist
                 */
                remove_action('nasa_show_buttons_loop', 'elessi_add_wishlist_in_list', 20);
                add_action('nasa_before_show_buttons_loop', 'elessi_add_wishlist_in_list');

                /**
                 * Wishlist in loop - Nasa Wishlist
                 */
                $nasa_wl = function_exists('elessi_woo_wishlist') ? elessi_woo_wishlist() : null;
                if ($nasa_wl) {
                    remove_action('nasa_show_buttons_loop', array($nasa_wl, 'btn_in_list'), 20);
                    add_action('nasa_before_show_buttons_loop', array($nasa_wl, 'btn_in_list'));
                }
            }
            
            /**
             * Product Card Styles - style 4 | modern-2
             */
            if ($nasa_opt['loop_layout_buttons'] == 'modern-2') {
                remove_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 10);
                
                if (
                    (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) &&
                    (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart'])
                ) {
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 100);
                    add_action('nasa_after_special_deal_simple_action', 'woocommerce_template_loop_add_to_cart', 100);
                }
            }
            
            /**
             * Product Card Styles - style 5 | modern-3
             */
            if ($nasa_opt['loop_layout_buttons'] == 'modern-3') {
                remove_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 10);
                
                if (
                    (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) &&
                    (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart'])
                ) {
                    add_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 50);
                }
            }
            
            /**
             * Product Card Styles - style 6 | modern-4
             */
            if ($nasa_opt['loop_layout_buttons'] == 'modern-4') {
                remove_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 10);
                
                if (
                    (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) &&
                    (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart'])
                ) {
                    add_action('nasa_after_show_buttons_loop', 'woocommerce_template_loop_add_to_cart');
                }
            }
            
            /**
             * Product Card Styles - style 8 | modern-6
             */
            if ($nasa_opt['loop_layout_buttons'] == 'modern-6') {
                remove_action('nasa_show_buttons_loop', 'woocommerce_template_loop_add_to_cart', 10);
                
                if (
                    (!isset($nasa_opt['loop_add_to_cart']) || $nasa_opt['loop_add_to_cart']) &&
                    (!isset($nasa_opt['disable-cart']) || !$nasa_opt['disable-cart'])
                ) {
                    add_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 100);
                    add_action('nasa_after_special_deal_simple_action', 'woocommerce_template_loop_add_to_cart', 100);
                }
            }
        }
    }
endif;

/**
 * Add Deal time for variation
 */
if (!function_exists('elessi_variation_deal_time')) :
    function elessi_variation_deal_time($variation) {
        if (!isset($variation['deal_time'])) {
            $time_from = get_post_meta($variation['variation_id'], '_sale_price_dates_from', true);
            $time_to = get_post_meta($variation['variation_id'], '_sale_price_dates_to', true);
            
            $arrayTime = array();
            if ($time_to) {
                $arrayTime['to'] = $time_to * 1000;
                $arrayTime['html'] = elessi_time_sale($time_to);
            }
            
            if ($time_from) {
                $arrayTime['from'] = $time_from * 1000;
            }
            
            $variation['deal_time'] = $arrayTime ? $arrayTime : false;
        }

        return $variation;
    }
endif;

/**
 * Custom Content show in list view archive page
 */
if (!function_exists('elessi_content_show_in_list')) :
    function elessi_content_show_in_list($show_in_list) {
        global $product, $nasa_opt;
        
        if ($show_in_list && (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'])) {
            $availability = $product->get_availability();
            
            if (!empty($availability['availability'])) {
                $stock_class = $availability['class'];
                $stock_label = $availability['availability'];
                ?>
                <!-- Clone Group btns for layout List -->
                <div class="hidden-tag nasa-list-stock-wrap">
                    <p class="nasa-list-stock-status <?php echo esc_attr($stock_class); ?>">
                        <?php echo $stock_label; ?>
                    </p>
                </div>
                <?php
            }
        }
    }
endif;

/**
 * Custom woocommerce_post_class
 */
if (!function_exists('elessi_custom_woocommerce_post_class')) :
    function elessi_custom_woocommerce_post_class($classes, $product) {
        global $nasa_opt, $nasa_time_sale;
        
        $product_id = $product->get_id();
        
        $classes[] = 'product-item grid';
        
        /**
         * Animate class
         */
        if (isset($nasa_opt['transition_load']) && $nasa_opt['transition_load'] == 'wow') {
            if (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile']) {
                $classes[] = 'wow fadeInUp';
            }
        }
        
        /**
         * Hover effect products in grid
         */
        if (isset($nasa_opt['animated_products']) && $nasa_opt['animated_products']) {
            $classes[] = $nasa_opt['animated_products'];
        }
        
        /**
         * Out of Stock
         */
        if ("outofstock" == $product->get_stock_status()) {
            $classes[] = 'out-of-stock';
        }
        
        /**
         * Deal class
         */
        if (!isset($nasa_time_sale[$product_id])) {
            $nasa_time_sale[$product_id] = false;
            
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $nasa_time_sale[$product_id] = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['nasa_time_sale'] = $nasa_time_sale;
        }
        
        if ($nasa_time_sale[$product_id]) {
            $classes[] = 'product-deals';
        }
        
        return $classes;
    }
endif;

/**
 * Deal time for loop
 */
if (!function_exists('elessi_loop_countdown')) :
    function elessi_loop_countdown() {
        global $product, $nasa_time_sale;
        
        $product_id = $product->get_id();
        
        /**
         * Deal class
         */
        if (!isset($nasa_time_sale[$product_id])) {
            $nasa_time_sale[$product_id] = false;
            
            if ($product->is_on_sale() && $product->get_type() != 'variable') {
                $time_from = get_post_meta($product_id, '_sale_price_dates_from', true);
                $time_to = get_post_meta($product_id, '_sale_price_dates_to', true);
                $nasa_time_sale[$product_id] = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
            }
            
            $GLOBALS['nasa_time_sale'] = $nasa_time_sale;
        }
        
        echo $nasa_time_sale[$product_id] ? elessi_time_sale($nasa_time_sale[$product_id]) : '<div class="nasa-sc-pdeal-countdown hidden-tag"></div>';
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * sold-by in loop
 */
if (!function_exists('elessi_wc_vendor_template_loop_sold_by')) :
    function elessi_wc_vendor_template_loop_sold_by() {
        global $product;
        
        if (!class_exists('WCV_Vendor_Shop') || !$product) {
            return;
        }
        
        WCV_Vendor_Shop::template_loop_sold_by($product->get_id());
    }
endif;

/**
 * Compatible with WC_Vendor plugin
 * 
 * Meta in single product
 */
if (!function_exists('elessi_wc_vendor_sold_by_meta')) :
    function elessi_wc_vendor_sold_by_meta() {
        if (!class_exists('WCV_Vendor_Cart')) {
            return;
        }
        
        echo '<span class="nasa-wc-vendor-single-meta">';
        WCV_Vendor_Cart::sold_by_meta();
        echo '</span>';
    }
endif;

/**
 * Single Product stock Progress bar
 */
if (!function_exists('elessi_single_stock')) :
    function elessi_single_stock($html, $product) {
        if ($html == '' || !$product) {
            return $html;
        }
        
        $product_id = $product->get_id();
        $stock = get_post_meta($product_id, '_stock', true);
        
        if (!$stock) {
            return $html;
        }
        
        $total_sales = get_post_meta($product_id, 'total_sales', true);
        $stock_sold = $total_sales ? round($total_sales) : 0;
        $stock_available = $stock ? round($stock) : 0;
        $percentage = $stock_available > 0 ? round($stock_available/($stock_available + $stock_sold) * 100) : 0;
        
        $new_html = '<div class="stock nasa-single-product-stock">';
        $new_html .= '<span class="stock-sold">';
        $new_html .= sprintf(esc_html__('Only %s item(s) left in stock.', 'elessi-theme'), '<b class="primary-color">' . $stock_available . '</b>');
        $new_html .= '</span>';
        $new_html .= '<div class="nasa-product-stock-progress">';
        $new_html .= '<span class="nasa-product-stock-progress-bar primary-bg" style="width:' . $percentage . '%"></span>';
        $new_html .= '</div>';
        $new_html .= '</div>';
        
        return $new_html;
    }
endif;

/**
 * Buy Now button
 */
if (!function_exists('elessi_add_buy_now_btn')) :
    function elessi_add_buy_now_btn() {
        global $nasa_opt, $product;
        
        if (
            (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) ||
            (isset($nasa_opt['enable_buy_now']) && !$nasa_opt['enable_buy_now']) ||
            'external' == $product->get_type() // Disable with External Product
        ) {
            return;
        }
        
        $class = 'nasa-buy-now';
        if (isset($nasa_opt['enable_fixed_buy_now_desktop']) && $nasa_opt['enable_fixed_buy_now_desktop']) {
            $class .= ' has-sticky-in-desktop';
        }
        
        echo '<input type="hidden" name="nasa_buy_now" value="0" />';
        echo '<button class="' . $class . '">' . esc_html__('BUY NOW', 'elessi-theme') . '</button>';
    }
endif;

/**
 * Redirect to Checkout page after click buy now
 */
if (!function_exists('elessi_buy_now_to_checkout')) :
    function elessi_buy_now_to_checkout($redirect_url) {
        if (isset($_REQUEST['nasa_buy_now']) && $_REQUEST['nasa_buy_now'] === '1') {
            $redirect_url = wc_get_checkout_url();
        }

        return $redirect_url;
    }
endif;

/**
 * Add class Sub Categories
 */
if (!function_exists('elessi_add_class_sub_categories')) :
    function elessi_add_class_sub_categories($classes) {
        $classes[] = 'product-warp-item';
        
        return $classes;
    }
endif;

/**
 * Deal time in Single product page
 */
if (!function_exists('elessi_deal_time_single')) :
    function elessi_deal_time_single() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="countdown-label nasa-detail-product-deal-countdown-label nasa-crazy-inline hidden-tag">' .
                '<i class="nasa-icon pe-7s-alarm pe7-icon"></i>&nbsp;&nbsp;' .
                esc_html__('Hurry up! Sale end in:', 'elessi-theme') .
            '</div>';
            
            echo '<div class="nasa-detail-product-deal-countdown nasa-product-variation-countdown"></div>';
            
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        echo '<div class="countdown-label nasa-crazy-inline">' .
            '<i class="nasa-icon pe-7s-alarm pe7-icon"></i>&nbsp;&nbsp;' .
            esc_html__('Hurry up! Sale end in:', 'elessi-theme') .
        '</div>';
        
        echo '<div class="nasa-detail-product-deal-countdown">';
        echo elessi_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Deal time in Quick view product
 */
if (!function_exists('elessi_deal_time_quickview')) :
    function elessi_deal_time_quickview() {
        global $product;
        
        if ($product->get_stock_status() == 'outofstock') {
            return;
        }
        
        $product_type = $product->get_type();
        
        // For variation of Variation product
        if ($product_type == 'variable') {
            echo '<div class="nasa-quickview-product-deal-countdown nasa-product-variation-countdown"></div>';
            return;
        }
        
        if ($product_type != 'simple') {
            return;
        }
        
        $productId = $product->get_id();

        $time_from = get_post_meta($productId, '_sale_price_dates_from', true);
        $time_to = get_post_meta($productId, '_sale_price_dates_to', true);
        $time_sale = ((int) $time_to < NASA_TIME_NOW || (int) $time_from > NASA_TIME_NOW) ? false : (int) $time_to;
        if (!$time_sale) {
            return;
        }
        
        echo '<div class="nasa-quickview-product-deal-countdown">';
        echo elessi_time_sale($time_sale);
        echo '</div>';
    }
endif;

/**
 * Main Image of Variation
 */
if (!function_exists('elessi_src_large_image_single_product')) :
    function elessi_src_large_image_single_product($variation) {
        if (!isset($variation['image_single_page'])) {
            $image = wp_get_attachment_image_src($variation['image_id'], 'woocommerce_single_image_width');
            $variation['image_single_page'] = isset($image[0]) ? $image[0] : '';
        }
        
        return $variation;
    }
endif;

/**
 * Results count in archive page in top
 */
if (!function_exists('elessi_result_count')) :
    function elessi_result_count() {
        if (! wc_get_loop_prop('is_paginated') || !woocommerce_products_will_display()) {
            return;
        }
        
        $total = wc_get_loop_prop('total');
        $per_page = wc_get_loop_prop('per_page');
        
        echo '<p class="woocommerce-result-count">';
        
        if ( $total <= $per_page || -1 === $per_page ) {
            printf(_n('1 result', '%d results', $total, 'elessi-theme'), $total);
	} else {
            $current = wc_get_loop_prop('current_page');
            $showed = $per_page * $current;
            
            if ($showed > $total) {
                $showed = $total;
            }
            
            printf(_n('1 result', '%d results', $total, 'elessi-theme'), $showed);
	}
        
        echo '</p>';
    }
endif;

/**
 * Get Top Content category products page
 */
if (!function_exists('elessi_get_cat_top')):
    function elessi_get_cat_top() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }
        
        $content = '<div class="nasa-cat-header">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_header', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = elessi_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_header_content']) && $nasa_opt['cat_header_content'] != '') {
                $do_content = elessi_get_block($nasa_opt['cat_header_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Get Bottom Content category products page
 */
if (!function_exists('elessi_get_cat_bottom')):
    function elessi_get_cat_bottom() {
        global $wp_query, $nasa_opt;
        
        $catId = null;
        $nasa_cat_obj = $wp_query->get_queried_object();
        if (isset($nasa_cat_obj->term_id) && isset($nasa_cat_obj->taxonomy)) {
            $catId = (int) $nasa_cat_obj->term_id;
        }
        
        $content = '<div class="nasa-cat-footer padding-top-20 padding-bottom-50">';
        $do_content = '';
        
        if ((int) $catId > 0) {
            $block = get_term_meta($catId, 'cat_footer_content', true);
            
            if ($block === '-1') {
                return;
            }
            
            if ($block) {
                $do_content = elessi_get_block($block);
            }
        }

        if (trim($do_content) === '') {
            if (isset($nasa_opt['cat_footer_content']) && $nasa_opt['cat_footer_content'] != '') {
                $do_content = elessi_get_block($nasa_opt['cat_footer_content']);
            }
        }

        if (trim($do_content) === '') {
            return;
        }

        $content .= $do_content . '</div>';

        echo $content;
    }
endif;

/**
 * Nasa childs category in Shop Top bar
 */
if (!function_exists('elessi_get_childs_category')):
    function elessi_get_childs_category($term = null, $instance = array()) {
        $content = '';
        
        if (NASA_WOO_ACTIVED){
            global $wp_query;
            
            $term = $term == null ? $wp_query->get_queried_object() : $term;
            $parent_id = is_numeric($term) ? $term : (isset($term->term_id) ? $term->term_id : 0);
            
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => $parent_id,
                'hierarchical' => true,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if (!$nasa_terms) {
                $term_root = get_ancestors($parent_id, 'product_cat');
                $term_parent = isset($term_root[0]) ? $term_root[0] : 0;
                $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                    'taxonomy' => 'product_cat',
                    'parent' => $term_parent,
                    'hierarchical' => true,
                    'hide_empty' => false,
                    'orderby' => 'name'
                )));
            }
            
            if ($nasa_terms) {
                $show = isset($instance['show_items']) ? (int) $instance['show_items'] : 0;
                $content .= '<ul class="nasa-children-cat product-categories nasa-product-child-cat-top-sidebar">';
                $items = 0;
                
                foreach ($nasa_terms as $v) {
                    $class_active = $parent_id == $v->term_id ? ' nasa-active' : '';
                    $class_li = ($show && $items >= $show) ? ' nasa-show-less' : '';
                    
                    $icon = '';
                    if (isset($instance['cat_' . $v->slug]) && trim($instance['cat_' . $v->slug]) != '') {
                        $icon = '<i class="' . $instance['cat_' . $v->slug] . '"></i>';
                        $icon .= '&nbsp;&nbsp;';
                    }
                    
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item' . $class_li . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="nasa-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">';
                    $content .= '<div class="nasa-cat-warp">';
                    $content .= '<h5 class="nasa-cat-title">';
                    $content .= $icon . esc_attr($v->name);
                    $content .= '</h5>';
                    $content .= '</div>';
                    $content .= '</a>';
                    $content .= '</li>';
                    $items++;
                }
                
                if ($show && ($items > $show)) {
                    $content .= '<li class="nasa_show_manual"><a data-show="1" class="nasa-show" href="javascript:void(0);" data-text="' . esc_attr__('- Show less', 'elessi-theme') . '" rel="nofollow">' . esc_html__('+ Show more', 'elessi-theme') . '</a></li>';
                }
                
                $content .= '</ul>';
            }
        }
        
        echo $content;
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_checkout_form_layout')) :
    function elessi_checkout_form_layout($checkout) {
        $name = defined('NASA_CHECKOUT_LAYOUT') ? NASA_CHECKOUT_LAYOUT : 'default';
        $layout = 'nasa-checkout-' . $name;
        
        $file = ELESSI_CHILD_PATH . '/includes/' . $layout . '.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/' . $layout . '.php';
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_checkout_coupon_form_clone')) :
    function elessi_checkout_coupon_form_clone() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-checkout-coupon-modern.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-checkout-coupon-modern.php';
    }
endif;

/**
 * Add action elessi_step_billing.
 */
if (!function_exists('elessi_step_billing')) :
    function elessi_step_billing() {
    
        // $need_shipping = 'no' === get_option('woocommerce_enable_shipping_calc') || !WC()->cart->needs_shipping() ? false : true;
        
        echo '<div id="nasa-step_billing">';
        echo '<div class="nasa-checkout-step">';
        echo '<a href="' . esc_url(wc_get_cart_url()) . '" class="nasa-back-to-cart nasa-back-step" title="' . esc_attr__('Return to Cart', 'elessi-theme') . '">' . esc_html__('RETURN TO CART', 'elessi-theme') . '</a>';
        /* echo $need_shipping ? 
            '<a href="javascript:void(0);" rel="nofollow" class="button nasa-shipping-step nasa-switch-step">' . esc_html__('Continue To Shipping', 'elessi-theme') . '</a>' :
            '<a href="javascript:void(0);" rel="nofollow" class="button nasa-payment-step nasa-switch-step">' . esc_html__('Continue To Payment', 'elessi-theme') . '</a>'; */
        
        echo '<a href="javascript:void(0);" rel="nofollow" class="button nasa-shipping-step nasa-switch-step">' . esc_html__('Continue To Shipping', 'elessi-theme') . '</a>';
        
        echo '</div>';
        echo '<p class="nasa-require-notice hidden-tag">' . esc_html__('This field is required.', 'elessi-theme') . '</p>';
        echo '<p class="nasa-email-notice hidden-tag">' . esc_html__('Email incorrect format.', 'elessi-theme') . '</p>';
        echo '<p class="nasa-phone-notice hidden-tag">' . esc_html__('Phone incorrect format.', 'elessi-theme') . '</p>';
        echo '</div>';
    }
endif;

/**
 * Add action Checkout shipping.
 */
if (!function_exists('elessi_checkout_shipping')) :
    function elessi_checkout_shipping() {
        echo '<div id="nasa-billing-info">';
        
        echo '<div class="customer-info-wrap">';
        
        /**
         * Email Contact
         */
        echo '<div class="customer-info customer-info-email">';
        echo '<span class="customer-info-left">' . esc_html__('Contact', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-billing-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';
        
        /**
         * Shipping
         */
        echo '<div class="customer-info customer-info-addr">';
        echo '<span class="customer-info-left">' . esc_html__('Ship to', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"><p class="nasa-ct-info-addr"></p></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-billing-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';

        echo '<div class="customer-info customer-info-method hidden-tag">';
        echo '<span class="customer-info-left">' . esc_html__('Method', 'elessi-theme') . '</span>';
        echo '<span class="customer-info-right"></span>';
        echo '<a href="javascript:void(0);" class="customer-info-change nasa-shipping-step rtl-text-left">' . esc_html__('Change', 'elessi-theme') . '</a>';
        echo '</div>';
        
        echo '</div>';
        
        echo '</div>';
        
        /**
         * Shipping Methods
         */
        echo '<div id="nasa-shipping-methods" class="hidden-tag">';
        echo '<h3 class="nasa-box-heading">';
        echo esc_html__('Shipping Methods', 'elessi-theme');
        echo '</h3>';
        echo '<div class="shipping-wrap-modern"></div>';
        echo '</div>';
        
        /**
         * Payments
         */
        echo '<div id="nasa-step_payment">';
        echo '<div class="nasa-checkout-step">';
        echo '<a href="javascript:void(0);" rel="nofollow" class="nasa-billing-step nasa-back-step">' . esc_html__('RETURN TO INFORMATION', 'elessi-theme') . '</a>';
        echo '<a href="javascript:void(0);" rel="nofollow" class="button nasa-payment-step nasa-switch-step">' . esc_html__('Continue To Payment', 'elessi-theme') . '</a>';
        echo '</div>';
        echo '</div>';
    }
endif;

/**
 * Modern Shipping html
 */
if (!function_exists('elessi_modern_shipping_html')) :
    function elessi_modern_shipping_html() {
        ob_start();
        wc_cart_totals_shipping_html();
        $shipping = ob_get_clean();
        
        return $shipping;
    }
endif;

/**
 * Add action Payments Headling.
 */
if (!function_exists('elessi_checkout_payment_headling')) :
    function elessi_checkout_payment_headling() {
        echo '<h3 class="nasa-box-heading payment-method-step">';
        echo esc_html__('Payment Methods', 'elessi-theme');
        echo '</h3>';
        echo '<p class="nasa-box-desc payment-method-step">' . esc_html__('All transactions are secure and encrypted.', 'elessi-theme') . '</p>';
    }
endif;

/**
 * Add Filter 'woocommerce_checkout_fields'.
 */
if (!function_exists('elessi_checkout_email_first')) :
    function elessi_checkout_email_first($checkout_fields) {
        $checkout_fields['billing']['billing_email']['priority'] = 5;
        
        return $checkout_fields;
    }
endif;

/**
 * Add Filter 'woocommerce_update_order_review_fragments'.
 */
if (!function_exists('elessi_update_order_review_fragments')) :
    function elessi_update_order_review_fragments($fragments) {
        $packages = WC()->shipping->get_packages();
        
        if (isset($packages[0]) && $packages[0]['destination']) {
            $fragments['.nasa-ct-info-addr'] = '<p class="nasa-ct-info-addr">' . WC()->countries->get_formatted_address($packages[0]['destination'], ', ') . '</p>';
        }
        
        /**
         * Total price
         */
        ob_start();
        wc_cart_totals_order_total_html();
        $total = ob_get_clean();
        $fragments['.your-order-price'] = '<span class="your-order-price">' . $total . '</span>';
        
        /**
         * Shipping Method
         */
        ob_start();
        wc_cart_totals_shipping_html();
        $shipping = ob_get_clean();
        $fragments['.shipping-wrap-modern'] = $shipping;
        
        return $fragments;
    }
endif;

/**
 * Add action before Payments.
 */
if (!function_exists('elessi_checkout_payment_open')) :
    function elessi_checkout_payment_open() {
        echo '<div id="nasa-payment-wrap">';
    }
endif;

/**
 * Add action after Payments.
 */
if (!function_exists('elessi_checkout_payment_close')) :
    function elessi_checkout_payment_close() {
        echo '</div>';
    }
endif;

/**
 * Add action after Payments.
 */
if (!function_exists('elessi_checkout_modern_billing_detail')) :
    function elessi_checkout_modern_billing_detail() {
        if (true !== WC()->cart->needs_shipping_address() || 'shipping' !== get_option('woocommerce_ship_to_destination')) {
            return;
        }
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-checkout-modern-billing-detail.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-checkout-modern-billing-detail.php';
    }
endif;

/**
 * Add Checkout Shipping Phone
 */
if (!function_exists('elessi_checkout_add_shipping_phone')) :
    function elessi_checkout_add_shipping_phone($fields) {
        if (true !== WC()->cart->needs_shipping_address() || 'shipping' !== get_option('woocommerce_ship_to_destination')) {
            return $fields;
        }
        
        $phone_require = get_option('woocommerce_checkout_phone_field', 'required');
        
        if ('hidden' !== $phone_require) {
            $fields['shipping_phone'] = array(
                'label'        => esc_html__('Phone', 'elessi-theme'),
                'required'     => 'required' === $phone_require,
                'type'         => 'tel',
                'class'        => array('form-row-wide'),
                'validate'     => array('phone'),
                'autocomplete' => 'tel',
                'priority'     => 100,
            );
        }
        
        return $fields;
    }
endif;

/**
 * Hook Checkout Modern Process
 */
if (!function_exists('elessi_checkout_modern_posted_data')) :
    function elessi_checkout_modern_posted_data($data) {
        if (true !== WC()->cart->needs_shipping_address() || 'shipping' !== get_option('woocommerce_ship_to_destination')) {
            return $data;
        }
    
        if (isset($_POST['ns-billing-select']) && $_POST['ns-billing-select'] === 'same') {
            foreach ($data as $key => $value) {
                if ($key !== 'billing_email' && 0 === strpos($key, 'billing_')) {
                    unset($data[$key]);
                }
                
                if (0 === strpos($key, 'shipping_')) {
                    $data['billing_' . substr($key, 9)] = $value;
                }
            }
            
            /**
             * Unrequired with Billing Form
             */
            $checkout = WC()->checkout();
            
            $fields = $checkout->get_checkout_fields();
            
            foreach ($fields['billing'] as $key => $field) {
                $fields['billing'][$key]['required'] = false;
            }
            
            $checkout->checkout_fields = $fields;
        }
        
        return $data;
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_bc_checkout_modern')) :
    function elessi_bc_checkout_modern() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-get-content-products.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-get-content-products.php';
    }
endif;

/**
 * Add action archive-product get content product.
 */
if (!function_exists('elessi_get_content_products')) :
    function elessi_get_content_products($nasa_sidebar = 'top') {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-get-content-products.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-get-content-products.php';
    }
endif;

/**
 * Next - Prev Single Product
 */
if (!function_exists('elessi_next_prev_single_product')) :
    function elessi_next_prev_single_product() {
        global $nasa_opt;
        
        if (isset($nasa_opt['next_prev_product']) && !$nasa_opt['next_prev_product']) {
            return;
        }
        
        echo '<div class="products-arrow">';
        do_action('next_prev_product');
        echo '</div>';
    }
endif;

/*
 * Wishlist in list
 */
if (!function_exists('elessi_add_wishlist_in_list')) :
    function elessi_add_wishlist_in_list() {
        if (NASA_WISHLIST_IN_LIST) {
            elessi_add_wishlist_button('left');
        }
    }
endif;

/*
 * Wishlist in single
 */
if (!function_exists('elessi_add_wishlist_in_detail')) :
    function elessi_add_wishlist_in_detail() {
        elessi_add_wishlist_button('right');
    }
endif;

/**
 * Quick view in list
 */
if (!function_exists('elessi_quickview_in_list')) :
    function elessi_quickview_in_list() {
        global $product;
        
        $type = $product->get_type();
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_quickview', '<i class="nasa-icon pe-7s-look"></i>');
        
        $quickview = '<a ' .
            'href="javascript:void(0);" ' .
            'class="quick-view btn-link quick-view-icon nasa-tip nasa-tip-left" ' .
            'data-prod="' . absint($product->get_id()) . '" ' .
            'data-icon-text="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme')) . '" ' .
            'title="' . ($type !== 'woosb' ? esc_attr__('Quick View', 'elessi-theme') : esc_attr__('View', 'elessi-theme')) . '" ' .
            'data-product_type="' . esc_attr($type) . '" ' .
            'data-href="' . esc_url($product->get_permalink()) . '" rel="nofollow">' .
            $icon .
        '</a>';
        
        echo $quickview;
    }
endif;

/**
 * Gift icon in list
 * Yith Bundle plugin
 */
if (!function_exists('elessi_bundle_in_list')) :
    function elessi_bundle_in_list() {
        global $product;
        if (!defined('YITH_WCPB') || $product->get_type() != NASA_COMBO_TYPE) {
            return;
        }
        ?>
        <a href="javascript:void(0);" class="btn-combo-link btn-link gift-icon nasa-tip nasa-tip-left" data-prod="<?php echo (int) $product->get_id(); ?>" data-tip="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" title="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" data-icon-text="<?php esc_attr_e('Promotion Gifts', 'elessi-theme'); ?>" rel="nofollow">
            <i class="nasa-icon pe-7s-gift"></i>
        </a>
        <?php
    }
endif;

/**
 * Gift icon Featured
 * Yith Bundle plugin
 */
if (!function_exists('elessi_gift_featured')) :
    function elessi_gift_featured() {
        global $product, $nasa_opt;
        
        if (isset($nasa_opt['enable_gift_featured']) && !$nasa_opt['enable_gift_featured']) {
            return;
        }
        
        $product_type = $product->get_type();
        if (!defined('YITH_WCPB') || $product_type != NASA_COMBO_TYPE) {
            return;
        }
        
        echo 
        '<div class="nasa-gift-featured-wrap">' .
            '<div class="nasa-gift-featured">' .
                '<div class="gift-icon">' .
                    '<a href="javascript:void(0);" class="nasa-gift-featured-event nasa-transition" title="' . esc_attr__('View the promotion gifts', 'elessi-theme') . '" rel="nofollow">' .
                        '<span class="pe-icon pe-7s-gift"></span>' .
                        '<span class="hidden-tag nasa-icon-text">' . 
                            esc_html__('Promotion Gifts', 'elessi-theme') . 
                        '</span>' .
                    '</a>' .
                '</div>' .
            '</div>' .
        '</div>';
    }
endif;

/**
 * Add compare in list
 */
if (!function_exists('elessi_add_compare_in_list')) :
    function elessi_add_compare_in_list() {
        global $product, $nasa_opt;
        
        $productId = $product->get_id();
        
        $nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon nasa-tip nasa-tip-left';
        $class_btn .= $nasa_compare ? ' nasa-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_compare', '<i class="nasa-icon icon-nasa-refresh"></i>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-icon-text="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" title="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
        </a>
        
        <?php if (!$nasa_compare && shortcode_exists('yith_compare_button')) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif;
    }
endif;

/**
 * Add compare in single
 */
if (!function_exists('elessi_add_compare_in_detail')) :
    function elessi_add_compare_in_detail() {
        global $product, $nasa_opt;
        
        $productId = $product->get_id();
        
        $nasa_compare = (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) ? true : false;
        
        $class_btn = 'btn-compare btn-link compare-icon nasa-tip nasa-tip-right';
        $class_btn .= $nasa_compare ? ' nasa-compare' : '';
        
        /**
         * Apply Filters Icon
         */
        $icon = apply_filters('nasa_icon_compare_in_detail', '<span class="nasa-icon icon-nasa-compare-2"></span>');
        ?>
        <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-tip="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" title="<?php esc_attr_e('Compare', 'elessi-theme'); ?>" rel="nofollow">
            <?php echo $icon; ?>
            <span class="nasa-icon-text"><?php esc_html_e('Add to Compare', 'elessi-theme'); ?></span>
        </a>

        <?php if (!$nasa_compare && shortcode_exists('yith_compare_button')) : ?>
            <div class="add-to-link woocommerce-compare-button hidden-tag">
                <?php echo do_shortcode('[yith_compare_button]'); ?>
            </div>
        <?php endif; ?>
    <?php
    }
endif;

/**
 * custom fields single product
 */
if (!function_exists('elessi_add_custom_field_detail_product')) :
    function elessi_add_custom_field_detail_product() {
        global $product, $product_lightbox;
        
        if ($product_lightbox) {
            $product = $product_lightbox;
        }
        
        $product_type = $product->get_type();
        // 'woosb' Bundle product
        if (!in_array($product_type, array('simple', 'variable', 'variation'))) {
            return;
        }
        
        global $nasa_opt;

        $nasa_btn_ajax_value = '0';
        if (
            'yes' !== get_option('woocommerce_cart_redirect_after_add') &&
            'yes' === get_option('woocommerce_enable_ajax_add_to_cart') &&
            (!isset($nasa_opt['enable_ajax_addtocart']) || $nasa_opt['enable_ajax_addtocart'] == '1')
        ) {
            $nasa_btn_ajax_value = '1';
        }
        
        echo '<div class="nasa-custom-fields hidden-tag">';
        echo '<input type="hidden" name="nasa-enable-addtocart-ajax" value="' . $nasa_btn_ajax_value . '" />';
        echo '<input type="hidden" name="data-product_id" value="' . esc_attr($product->get_id()) . '" />';
        echo '<input type="hidden" name="data-type" value="' . esc_attr($product_type) . '" />';
        
        if (NASA_WISHLIST_ENABLE) {
            $nasa_has_wishlist = (isset($_REQUEST['nasa_wishlist']) && $_REQUEST['nasa_wishlist'] == '1') ? '1' : '0';
            echo '<input type="hidden" name="data-from_wishlist" value="' . esc_attr($nasa_has_wishlist) . '" />';
        }
        
        echo '</div>';
    }
endif;

/**
 * Images in content product
 */
if (!function_exists('elessi_loop_product_content_thumbnail')) :
    function elessi_loop_product_content_thumbnail() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-loop-product-thumbnail.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-loop-product-thumbnail.php';
    }
endif;

/**
 * Ajax Single Product Page
 */
if (!function_exists('elessi_ajax_single_product_tag')) :
    function elessi_ajax_single_product_tag() {
        // global $nasa_opt;
        echo defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? '<div id="nasa-single-product-ajax" class="hidden-tag"></div>' : '';
    }
endif;

/**
 * Buttons in content product
 */
if (!function_exists('elessi_loop_product_content_btns')) :
    function elessi_loop_product_content_btns() {
        echo elessi_product_group_button();
    }
endif;

/**
 * Categories in content product
 */
if (!function_exists('elessi_loop_product_cats')) :
    function elessi_loop_product_cats() {
        global $nasa_opt;
        
        if (!isset($nasa_opt['loop_categories']) || !$nasa_opt['loop_categories']) {
            return;
        }
        
        global $product;
        
        $categories = wc_get_product_category_list($product->get_id(), ', ');
        
        if ($categories) {
            echo '<div class="nasa-list-category nasa-show-one-line">';
            echo $categories;
            echo '</div>';
        }
    }
endif;

/**
 * Title in content product
 */
if (!function_exists('elessi_loop_product_content_title')) :
    function elessi_loop_product_content_title() {
        global $product, $nasa_opt;
        
        $class_title = 'name woocommerce-loop-product__title';
        $class_title .= (!isset($nasa_opt['cutting_product_name']) || $nasa_opt['cutting_product_name']) ? ' nasa-show-one-line' : '';
        $class_title .= defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
        ?>
        
        <a class="<?php echo esc_attr(apply_filters('woocommerce_product_loop_title_classes', $class_title)); ?>" href="<?php echo esc_url($product->get_permalink()); ?>" title="<?php echo esc_attr($product->get_name()); ?>">
            <?php echo get_the_title(); ?>
        </a>
    <?php
    }
endif;

/**
 * Description in content product
 */
if (!function_exists('elessi_loop_product_description')) :
    function elessi_loop_product_description($desc_info = true) {
        if (!$desc_info) {
            return;
        }
        
        global $post;
        
        $short_desc = apply_filters('woocommerce_short_description', $post->post_excerpt);
        
        echo $short_desc ? '<div class="info_main product-des-wrap product-des">' . $short_desc . '</div>' : '';
    }
endif;

/**
 * Top side bar shop
 */
if (!function_exists('elessi_top_sidebar_shop')) :
    function elessi_top_sidebar_shop($type = '') {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-sidebar-shop-top.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-sidebar-shop-top.php';
    }
endif;

/**
 * Side bar shop
 */
if (!function_exists('elessi_side_sidebar_shop')) :
    function elessi_side_sidebar_shop($nasa_sidebar = 'left') {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-sidebar-shop-side.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-sidebar-shop-side.php';
    }
endif;

/**
 * Out of Stock badge
 */
if (!function_exists('elessi_badge_outofstock')) :
    function elessi_badge_outofstock() {
        return apply_filters('nasa_badge_outofstock', '<span class="badge out-of-stock-label">' . esc_html__('Sold Out', 'elessi-theme') . '</span>');
    }
endif;

/**
 * Change View
 */
if (!function_exists('elessi_nasa_change_view')) :
    function elessi_nasa_change_view($nasa_sidebar = 'no') {
        global $nasa_opt;
        
        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        if ($inMobile) {
            return;
        }
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-change-view.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-change-view.php';
    }
endif;

/**
 * Single Product Layout
 */
if (!function_exists('elessi_single_product_layout')) :
    function elessi_single_product_layout() {
        global $nasa_opt;
        
        $in_mobile = false;
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] && isset($nasa_opt['single_product_mobile']) && $nasa_opt['single_product_mobile']) {
            $nasa_actsidebar = false;
            $in_mobile = true;
        } else {
            $nasa_actsidebar = is_active_sidebar('product-sidebar');
        }
        
        $nasa_sidebar = isset($nasa_opt['product_sidebar']) ? $nasa_opt['product_sidebar'] : 'no';
        
        if (!isset($nasa_opt['product_detail_layout'])) {
            $nasa_opt['product_detail_layout'] = 'new';
        }

        // Class
        switch ($nasa_sidebar) :
            case 'right' :
                if ($nasa_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns left';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-left-20 product-sidebar-right right';
                } else {
                    $main_class = '';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-right';
                }

                break;

            case 'no' :
                $main_class = $nasa_opt['product_detail_layout'] == 'classic' ? 'large-12 columns' : '';
                $bar_class = '';
                break;

            default:
            case 'left' :
                if ($nasa_opt['product_detail_layout'] == 'classic') {
                    $main_class = 'large-9 columns right';
                    $bar_class = 'large-3 columns col-sidebar desktop-padding-right-20 product-sidebar-left left';
                } 
                else {
                    $main_class = '';
                    $bar_class = 'nasa-side-sidebar nasa-sidebar-left';
                }

                break;

        endswitch;
        
        $main_class .= $main_class != '' ? ' ' : '';
        $main_class .= 'nasa-single-product-' . $nasa_opt['product_image_style'];
        $main_class .= $nasa_opt['product_image_style'] == 'scroll' && $nasa_opt['product_image_layout'] == 'double' ? ' nasa-single-product-2-columns': '';
        
        $main_class .= $in_mobile ? ' nasa-single-product-in-mobile' : '';
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-single-product-' . $nasa_opt['product_detail_layout'] . '.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-single-product-' . $nasa_opt['product_detail_layout'] . '.php';
    }
endif;

/**
 * Custom Tabs
 */
if (!function_exists('elessi_custom_tabs_single_product')) :
    function elessi_custom_tabs_single_product($tabs) {
        global $nasa_opt;

        /**
         * Remove Additional tab
         */
        if (
            isset($tabs['additional_information']) &&
            isset($nasa_opt['hide_additional_tab']) &&
            $nasa_opt['hide_additional_tab']
        ) {
            unset($tabs['additional_information']);
        }

        return $tabs;
    }
endif;

/**
 * Hide Uncategorized
 */
if (!function_exists('elessi_hide_uncategorized')) :
    function elessi_hide_uncategorized($args) {
        $args['exclude'] = get_option('default_product_cat');
        return $args;
    }
endif;

/**
 * Before Share WooCommerce
 */
if (!function_exists('elessi_before_woocommerce_share')) :
    function elessi_before_woocommerce_share() {
        echo '<hr class="nasa-single-hr" /><div class="nasa-single-share">';
    }
endif;

/**
 * Custom Share WooCommerce
 */
if (!function_exists('elessi_woocommerce_share')) :
    function elessi_woocommerce_share() {
        echo shortcode_exists('nasa_share') ? do_shortcode('[nasa_share label="1"]') : '';
    }
endif;

/**
 * After Share WooCommerce
 */
if (!function_exists('elessi_after_woocommerce_share')) :
    function elessi_after_woocommerce_share() {
        echo '</div>';
    }
endif;

/**
 * Before desc of Archive
 */
if (!function_exists('elessi_before_archive_description')) :
    function elessi_before_archive_description() {
        echo '<div class="nasa_shop_description page-description padding-top-20">';
    }
endif;

/**
 * After desc of Archive
 */
if (!function_exists('elessi_after_archive_description')) :
    function elessi_after_archive_description() {
        echo '</div>';
    }
endif;

/**
 * Open wrap 12 columns
 */
if (!function_exists('elessi_open_wrap_12_cols')) :
    function elessi_open_wrap_12_cols() {
        echo '<div class="row"><div class="large-12 columns">';
    }
endif;

/**
 * Close wrap 12 columns
 */
if (!function_exists('elessi_close_wrap_12_cols')) :
    function elessi_close_wrap_12_cols() {
        echo '</div></div>';
    }
endif;

/**
 * Begin wrap in Mobile App
 */
if (!function_exists('elessi_begin_wrap')) :
    function elessi_begin_wrap() {
        echo '<div class="ns-begin-wrap">';
    }
endif;

/**
 * End wrap in Mobile App
 */
if (!function_exists('elessi_end_wrap')) :
    function elessi_end_wrap() {
        echo '</div>';
    }
endif;

/**
 * shopping cart subtotal
 */
if (!function_exists('elessi_widget_shopping_cart_subtotal')) :
    function elessi_widget_shopping_cart_subtotal() {
        echo '<span class="total-price-label">' . esc_html__('Subtotal', 'elessi-theme') . '</span>';
        echo '<span class="total-price right">' . WC()->cart->get_cart_subtotal() . '</span>';
    }
endif;

/**
 * shopping cart ext
 */
if (!function_exists('elessi_widget_shopping_cart_ext')) :
    function elessi_widget_shopping_cart_ext() {
        global $nasa_opt;
        
        $coupon_enable = $shipping_enable = false;
        
        if ((isset($nasa_opt['mini_cart_coupon']) && $nasa_opt['mini_cart_coupon']) && wc_coupons_enabled()) {
            $coupon_enable = true;
        }
        
        if (isset($nasa_opt['mini_cart_shipping']) && $nasa_opt['mini_cart_shipping']) {
            $shipping_enable = 'no' === get_option('woocommerce_enable_shipping_calc') || !WC()->cart->needs_shipping() ? false : true;
        }
        
        $total_enable = $coupon_enable || $shipping_enable ? true : false;
        if (!$total_enable) {
            return;
        }
        
        /**
         * Coupon
         */
        if ($coupon_enable) {
            $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-cart-coupons.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-cart-coupons.php';
        }
        
        /**
         * Shipping
         */
        if ($shipping_enable) {
            $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-cart-shipping.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-cart-shipping.php';
        }
        
        /**
         * Fees
         */
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-cart-fees.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-cart-fees.php';

        /**
         * Tax
         */
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-cart-taxs.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-cart-taxs.php';

        /**
         * Total
         */
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-cart-total.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-cart-total.php';
    }
endif;

/**
 * Extend Mini Cart From Cart
 */
if (!function_exists('elessi_ext_mini_cart')) :
    function elessi_ext_mini_cart() {
        global $nasa_opt;
        
        $ext_content = '';
        
        /**
         * Add Note
         */
        if (isset($nasa_opt['mini_cart_note']) && $nasa_opt['mini_cart_note'] && apply_filters('woocommerce_enable_order_notes_field', 'yes' === get_option('woocommerce_enable_order_comments', 'yes'))) {
            $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-note nasa-bold" data-act="note" rel="nofollow"><i class="pe-7s-note"></i>' . esc_html__('Note', 'elessi-theme') . '</a>';
        }
        
        /**
         * Add Shipping
         */
        if (
            isset($nasa_opt['mini_cart_shipping']) &&
            $nasa_opt['mini_cart_shipping']
        ) {
            $shipping_enable = 'no' === get_option('woocommerce_enable_shipping_calc') || ! WC()->cart->needs_shipping() ? false : true;
            if ($shipping_enable) {
                $ext_content .= '<span class="nssp"></span>';
                $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-shipping nasa-bold" data-act="shipping" rel="nofollow"><i class="icon-nasa-car-2"></i>' . esc_html__('Shipping', 'elessi-theme') . '</a>';
            }
        }
        
        /**
         * Add Coupon
         */
        if (isset($nasa_opt['mini_cart_coupon']) && $nasa_opt['mini_cart_coupon'] && wc_coupons_enabled()) {
            $ext_content .= '<span class="nssp"></span>';
            $ext_content .= '<a href="javascript:void(0);" class="ext-mini-cart mini-cart-coupon nasa-bold" data-act="coupon" rel="nofollow"><i class="icon-nasa-sale"></i>' . esc_html__('Coupon', 'elessi-theme') . '</a>';
        }
        
        /**
         * Output
         */
        if ($ext_content) {
            echo '<div class="nasa-flex flex-wrap jse ext-mini-cart-wrap">' . $ext_content . '</div>';
        }
    }
endif;

/**
 * Get orders_comments from session
 */
add_filter('default_checkout_order_comments', 'elessi_order_comments_session');
if (!function_exists('elessi_order_comments_session')) :
    function elessi_order_comments_session($value) {
        $note = WC()->session->get('nasa_order_comments');
        return $note ? $note : $value;
    }
endif;

/**
 * Clear session nasa_order_comments
 */
add_action('woocommerce_thankyou', 'elessi_order_comments_session_clear');
if (!function_exists('elessi_order_comments_session_clear')) :
    function elessi_order_comments_session_clear() {
        WC()->session->set('nasa_order_comments', null);
    }
endif;

/**
 * elessi_wc_form_field_args
 */
if (!function_exists('elessi_wc_form_field_args')) :
    function elessi_wc_form_field_args($args) {
        if (isset($args['label']) && (!isset($args['placeholder']) || $args['placeholder'] == '')) {
            $args['placeholder'] = $args['label'];
        }
    
        return $args;
    }
endif;

/**
 * Hook woocommerce_before_main_content
 */
if (!function_exists('elessi_open_woo_main')) :
    function elessi_open_woo_main() {
        global $nasa_opt;

        $class = 'nasa-ajax-store-content';
        
        if (isset($nasa_opt['transition_load']) && $nasa_opt['transition_load'] == 'crazy') :
            $class .= ' nasa-crazy-load crazy-loading';
        endif;

        echo '<!-- Begin Ajax Store Wrap --><div class="nasa-ajax-store-wrapper"><div id="nasa-ajax-store" class="' . $class . '">';
        
        if (!isset($nasa_opt['disable_ajax_product_progress_bar']) || $nasa_opt['disable_ajax_product_progress_bar'] != 1) :
            echo '<div class="nasa-progress-bar-load-shop"><div class="nasa-progress-per"></div></div>';
        endif;
        
        /**
         * For Ajax in Single Product Page
         */
        if (defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT) :
            wp_enqueue_script('wc-add-to-cart-variation');
        endif;
    }
endif;

/**
 * Hook woocommerce_after_main_content
 */
if (!function_exists('elessi_close_woo_main')) :
    function elessi_close_woo_main() {
        echo '</div></div><!-- End Ajax Store Wrap -->';
    }
endif;
