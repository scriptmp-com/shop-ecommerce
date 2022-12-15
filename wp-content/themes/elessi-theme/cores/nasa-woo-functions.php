<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Get product meta value
 */
if (!function_exists('elessi_get_product_meta_value')):
    function elessi_get_product_meta_value($post_id = 0, $field_id = null) {
        if ($post_id && function_exists('nasa_get_product_meta_value')) {
            return nasa_get_product_meta_value($post_id, $field_id);
        }
        
        return null;
    }
endif;

/**
 * Custom shopping cart page when empty
 */
add_filter('wc_empty_cart_message', 'elessi_empty_cart_message');
if (!function_exists('elessi_empty_cart_message')) :
    function elessi_empty_cart_message ($mess) {
        $mess .= '<span class="nasa-extra-empty">' . esc_html__('Before proceed to checkout you must add some products to shopping cart.', 'elessi-theme') . '</span>';
        $mess .= '<span class="nasa-extra-empty">' . esc_html__('You will find a lot of interesting products on our "Shop" page.', 'elessi-theme') . '</span>';

        return $mess;
    }
endif;

/**
 * Link account
 */
if (!function_exists('elessi_link_account')) {
    function elessi_link_account() {
        $links = false;
        
        /* Active woocommerce */
        if (NASA_WOO_ACTIVED) {
            $myaccount_page_id = get_option('woocommerce_myaccount_page_id');
            
            if ($myaccount_page_id) {
                $links = get_permalink($myaccount_page_id);
            }
            
        } else {
            $links = !NASA_CORE_USER_LOGGED ? wp_login_url() : admin_url('profile.php');
        }
        
        return $links ? $links : home_url('/');
    }
}

/**
 * Tiny account
 */
if (!function_exists('elessi_tiny_account')) {
    function elessi_tiny_account($icon = false) {
        global $nasa_opt;
        
        if (isset($nasa_opt['hide_tini_menu_acc']) && $nasa_opt['hide_tini_menu_acc']) {
            return '';
        }
        
        $links = elessi_link_account();

        $result = '<ul class="nasa-menus-account">';
        
        $icon_user = apply_filters('nasa_mini_icon_account', '<i class="pe7-icon pe-7s-user"></i>');
        
        /**
         * Not Logged in
         */
        if (!NASA_CORE_USER_LOGGED) {
            global $nasa_opt;
            
            $login_ajax = (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1) ? '1' : '0';
            $span = $icon ? $icon_user : '';
            
            $result .= '<li class="menu-item"><a class="nasa-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($links) . '" title="' . esc_attr__('Login / Register', 'elessi-theme') . '">' . $span . '<span class="nasa-login-title">' . esc_html__('Login / Register', 'elessi-theme') . '</span></a></li>';
        }
        
        /**
         * Logged in
         */
        else {
            $span1 = $icon ? $icon_user : '';
            $submenu = elessi_sub_account();
            
            $result .= 
                '<li class="menu-item nasa-menu-item-account menu-item-has-children root-item">' .
                    '<a href="' . esc_url($links) . '" title="' . esc_attr__('My Account', 'elessi-theme') . '">' . $span1 . esc_html__('My Account', 'elessi-theme') . '</a>' .
                    $submenu .
                '</li>';
        }
        
        $result .= '</ul>';
        
        return apply_filters('nasa_tiny_account_ajax', $result);
    }
}

/**
 * Submenu Account
 */
if (!function_exists('elessi_sub_account')) :
    function elessi_sub_account() {
        if (!NASA_CORE_USER_LOGGED) {
            return '';
        }
        
        $submenu = '<ul class="sub-menu">';
            
        // Hello Account
        $current_user = wp_get_current_user();
        $submenu .= '<li class="nasa-subitem-acc nasa-hello-acc">' . sprintf(esc_html__('Hello, %s!', 'elessi-theme'), $current_user->display_name) . '</li>';

        $menu_items = NASA_WOO_ACTIVED ? wc_get_account_menu_items() : false;
        if ($menu_items) {
            foreach ($menu_items as $endpoint => $label) {
                $submenu .= '<li class="nasa-subitem-acc ' . wc_get_account_menu_item_classes($endpoint) . '"><a href="' . esc_url(wc_get_account_endpoint_url($endpoint)) . '">' . esc_html($label) . '</a></li>';
            }
        }

        $submenu .= '</ul>';
        
        return $submenu;
    }
endif;

/**
 * icon cart
 */
if (!function_exists('elessi_mini_cart_icon')) :
    function elessi_mini_cart_icon() {
        global $nasa_opt;
        
        $icon_number = isset($nasa_opt['mini-cart-icon']) ? $nasa_opt['mini-cart-icon'] : '1';
        switch ($icon_number) {
            case '2':
                $icon_class = 'icon-nasa-cart-2';
                break;
            case '3':
                $icon_class = 'icon-nasa-cart-4';
                break;
            case '4':
                $icon_class = 'pe-7s-cart';
                break;
            case '5':
                $icon_class = 'fa fa-shopping-cart';
                break;
            case '6':
                $icon_class = 'fa fa-shopping-bag';
                break;
            case '7':
                $icon_class = 'fa fa-shopping-basket';
                break;
            case '1':
            default:
                $icon_class = 'icon-nasa-cart-3';
                break;
        }

        return apply_filters('nasa_mini_icon_cart', $icon_class);
    }
endif;

/**
 * Mini cart icon
 * 
 * @global type $nasa_opt
 * @global type $nasa_mini_cart
 * @param type $recount
 * @return type
 */
if (!function_exists('elessi_mini_cart')) {
    function elessi_mini_cart($recount = false) {
        global $nasa_opt, $nasa_mini_cart;
        
        if (!NASA_WOO_ACTIVED || (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart'])) {
            return '';
        }
        
        if (!$nasa_mini_cart) {
            $count = $recount ? WC()->cart->get_cart_contents_count() : 0;
            $class = $count ? '' : ' hidden-tag nasa-product-empty';
            
            if ($count && (!isset($nasa_opt['compact_number']) || $nasa_opt['compact_number'])) {
                $count = $count > 9 ? '9+' : $count;
            }
            
            $icon_class = elessi_mini_cart_icon();
            
            $nasa_mini_cart = 
            '<a href="' . esc_url(wc_get_cart_url()) . '" class="cart-link mini-cart cart-inner inline-block" title="' . esc_attr__('Cart', 'elessi-theme') . '" rel="nofollow">' .
                '<span class="icon-wrap">' .
                    '<i class="nasa-icon cart-icon ' . $icon_class . '"></i>' .
                    '<span class="nasa-cart-count nasa-mini-number cart-number' . $class . '">' .
                        apply_filters('nasa_mini_cart_total_items', $count) .
                    '</span>' .
                '</span>' .
                '<span class="icon-text hidden-tag">' . esc_html__('Cart', 'elessi-theme') . '</span>' .
            '</a>';
            
            $nasa_mini_cart = apply_filters('nasa_mini_cart', $nasa_mini_cart);
            
            $GLOBALS['nasa_mini_cart'] = $nasa_mini_cart;
        }
        
        return $nasa_mini_cart;
    }
}

/**
 * Add to cart dropdown - Refresh mini cart content.
 */
add_filter('woocommerce_add_to_cart_fragments', 'elessi_add_to_cart_refresh');
if (!function_exists('elessi_add_to_cart_refresh')) :
    function elessi_add_to_cart_refresh($fragments) {
        $fragments['.cart-inner'] = elessi_mini_cart(true);
        
        if (isset($_REQUEST['product_id'])) {
            $fragments['.woocommerce-message'] = sprintf(
                '<div class="woocommerce-message text-center" role="alert">%s</div>',
                esc_html__('Product added to cart successfully!', 'elessi-theme')
            );
        }

        return $fragments;
    }
endif;

/**
 * Open Cart Sidebar - With disable AJAX Add To Cart - Quickview | Single Product Page
 */
add_action('wp_head', 'elessi_added_cart_event_sidebar');
if (!function_exists('elessi_added_cart_event_sidebar')) :
    function elessi_added_cart_event_sidebar() {
        global $nasa_opt;

        if (!isset($nasa_opt['enable_ajax_addtocart']) || $nasa_opt['enable_ajax_addtocart'] == '1' || (isset($nasa_opt['event-after-add-to-cart']) && $nasa_opt['event-after-add-to-cart'] !== 'sidebar')) {
            return;
        }

        if (isset($_POST['add-to-cart']) && $_POST['add-to-cart']) {
            wc_clear_notices();

            add_filter('nasa_cart_sidebar_show', function() {
                return true;
            });
        }
    }
endif;

/**
 * Mini wishlist sidebar
 */
if (!function_exists('elessi_mini_wishlist_sidebar')) {
    function elessi_mini_wishlist_sidebar($return = false) {
        if (!NASA_WOO_ACTIVED){
            return '';
        }
        
        global $nasa_opt;
        
        if (!NASA_WISHLIST_ENABLE && isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) :
            return '';
        endif;
        
        if ($return) :
            ob_start();
        endif;
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-sidebar-wishlist.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-sidebar-wishlist.php';
        
        if ($return) :
            $content = ob_get_clean();
            return $content;
        endif;
    }
}

/**
 * Add to cart button from wishlist
 */
if (!function_exists('elessi_add_to_cart_in_wishlist')) :
    function elessi_add_to_cart_in_wishlist() {
        global $product, $nasa_opt;

        if (isset($nasa_opt['disable-cart']) && $nasa_opt['disable-cart']) {
            return '';
        }

        $title = $product->add_to_cart_text();
        $product_type = $product->get_type();
        $product_id = $product->get_id();
        $enable_button_ajax = false;
        
        if ($product->is_in_stock() && $product->is_purchasable()) {
            if ($product_type == 'simple' || ($product_type == NASA_COMBO_TYPE && 'instock' === $product->get_bundled_items_stock_status())) {
                $enable_button_ajax = 'yes' === get_option('woocommerce_enable_ajax_add_to_cart') ? true : false;
                $url = $enable_button_ajax ? 'javascript:void(0);' : esc_url($product->add_to_cart_url());
            }
            
            else {
                
                /**
                 * Bundle product
                 */
                if ($product_type == 'woosb') {
                    $url = '?add-to-cart=' . $product_id;
                    
                    if (get_option('yith_wcwl_remove_after_add_to_cart') == 'yes') {
                        $url .= '&remove_from_wishlist_after_add_to_cart=' . $product_id;
                    }
                }
                
                /**
                 * Normal product
                 */
                else {
                    $url = esc_url($product->add_to_cart_url());
                }
            }
        }
        
        else {
            return '';
        }

        $add_to_cart = apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" rel="nofollow" data-quantity="1" data-product_id="%s" data-product_sku="%s" class="button-in-wishlist small btn-from-wishlist %s product_type_%s add-to-cart-grid wishlist-fragment" data-type="%s" title="%s">%s</a>',
                $url, //link
                $product_id, //product id
                esc_attr($product->get_sku()), //product sku
                $enable_button_ajax ? 'nasa_add_to_cart_from_wishlist' : '', //class name
                esc_attr($product_type),
                esc_attr($product_type), //product type
                $title,
                $title
            ),
            $product
        );
        
        if ($product_type === 'variable') {
            $add_to_cart .= sprintf('<a href="javascript:void(0);" class="quick-view nasa-view-from-wishlist hidden-tag" data-prod="%s" data-from_wishlist="1" rel="nofollow">%s</a>', $product_id, esc_html__('Quick View', 'elessi-theme'));
        }
        
        return $add_to_cart;
    }
endif;

/**
 * ARGS add to cart loop
 */
if (!function_exists('elessi_loop_add_to_cart_args')):
    function elessi_loop_add_to_cart_args($args, $product) {
        global $nasa_opt;
        
        /**
         * Custom Attributes
         */
        if (!isset($args['attributes'])) {
            $args['attributes'] = array();
        }
        
        $args['attributes']['title'] = $product->add_to_cart_text();
        
        /**
         * Custom Class
         */
        if (!isset($args['class'])) {
            $args['class'] = '';
        }
        
        $args['class'] .= ' add-to-cart-grid btn-link nasa-tip';
        
        $ajax_sp = get_option('woocommerce_enable_ajax_add_to_cart');
        
        if (!$ajax_sp) {
            $args['class'] .= ' nasa-disable-ajax';
        }
        
        if ($product->is_purchasable() && $product->is_in_stock()) {
            $product_type = $product->get_type();
            
            /**
             * Variation product
             */
            if ($product_type == 'variation') {
                $args['attributes']['data-variation_id'] = $product->get_id();
                $args['attributes']['data-variation'] = json_encode($product->get_variation_attributes());
            }
            
            /**
             * Yith Bundle product
             */
            if ($product_type == NASA_COMBO_TYPE) {
                $args['class'] .= 'yes' === $ajax_sp ? ' nasa_bundle_add_to_cart' : '';
                $args['attributes']['data-type'] = $product_type;
            }
        }
        
        /**
         * Custom Icon
         */
        $icon_class = 'cart-icon ';
        $icon_number = isset($nasa_opt['cart-icon-grid']) ? $nasa_opt['cart-icon-grid'] : '1';
        switch ($icon_number) {
            case '2':
                $icon_class .= 'icon-nasa-cart-3';
                break;
            case '3':
                $icon_class .= 'icon-nasa-cart-2';
                break;
            case '4':
                $icon_class .= 'icon-nasa-cart-4';
                break;
            case '5':
                $icon_class .= 'pe-7s-cart';
                break;
            case '6':
                $icon_class .= 'fa fa-shopping-cart';
                break;
            case '7':
                $icon_class .= 'fa fa-shopping-bag';
                break;
            case '8':
                $icon_class .= 'fa fa-shopping-basket';
                break;
            case '1':
            default:
                $icon_class .= 'nasa-df-plus';
                break;
        }
    
        $args['icon_class'] = $icon_class;
        
        $args['class'] = apply_filters('nasa_filter_add_to_cart_class', $args['class']);
        
        return $args;
    }
endif;

/**
 * Product group buttons
 */
if (!function_exists('elessi_product_group_button')):
    function elessi_product_group_button() {
        ob_start();
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-product-buttons.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-product-buttons.php';

        return ob_get_clean();
    }
endif;

/**
 * Wishlist link
 */
if (!function_exists('elessi_tini_wishlist')):
    function elessi_tini_wishlist($icon = false) {
        if (!NASA_WOO_ACTIVED || !NASA_WISHLIST_ENABLE) {
            return;
        }

        $tini_wishlist = '';
        
        $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
        if (function_exists('icl_object_id')) {
            $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
        }
        
        $wishlist_page = get_permalink($wishlist_page_id);

        $span = $icon ? '<span class="icon-nasa-like"></span>' : '';
        
        $tini_wishlist .= '<a href="' . esc_url($wishlist_page) . '" title="' . esc_attr__('Wishlist', 'elessi-theme') . '">' . $span . esc_html__('Wishlist', 'elessi-theme') . '</a>';

        return $tini_wishlist;
    }
endif;

/**
 * Wishlist icons
 */
if (!function_exists('elessi_icon_wishlist')):
    function elessi_icon_wishlist() {
        if (!NASA_WOO_ACTIVED) {
            return '';
        }

        global $nasa_icon_wishlist;
        
        if (!isset($nasa_icon_wishlist)) {
            $show = defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE ? false : true;
            $count = elessi_get_count_wishlist($show);
            
            /**
             * Yith WooCommerce Wishlist
             */
            if (NASA_WISHLIST_ENABLE) {
                $href = '';
                $class = 'wishlist-link inline-block';
                
                if (defined('YITH_WCWL_PREMIUM')) {
                    $class .= ' wishlist-link-premium';
                    $wishlist_page_id = get_option('yith_wcwl_wishlist_page_id');
                    
                    if (function_exists('icl_object_id') && $wishlist_page_id) {
                        $wishlist_page_id = icl_object_id($wishlist_page_id, 'page', true);
                    }

                    $href = $wishlist_page_id ? get_permalink($wishlist_page_id) : home_url('/');
                }
                
                $icon = apply_filters('nasa_mini_icon_wishlist', '<i class="nasa-icon wishlist-icon icon-nasa-like"></i>');

                $nasa_icon_wishlist = 
                '<a class="' . $class . '" href="' . ($href != '' ? esc_url($href) : 'javascript:void(0);') . '" title="' . esc_attr__('Wishlist', 'elessi-theme') . '">' .
                    '<span class="icon-wrap">' .
                        $icon .
                        $count .
                    '</span>' .
                    '<span class="icon-text hidden-tag">' . esc_html__('Wishlist', 'elessi-theme') . '</span>' .
                '</a>';
            }
            
            /**
             * NasaTheme Wishlist
             */
            else {
                global $nasa_opt;

                if (isset($nasa_opt['enable_nasa_wishlist']) && !$nasa_opt['enable_nasa_wishlist']) {
                    return;
                }
                
                $class = 'wishlist-link nasa-wishlist-link inline-block';
                
                $icon = apply_filters('nasa_mini_icon_wishlist', '<i class="nasa-icon wishlist-icon icon-nasa-like"></i>');
                
                $nasa_icon_wishlist = 
                '<a class="' . $class . '" href="javascript:void(0);" title="' . esc_attr__('Wishlist', 'elessi-theme') . '" rel="nofollow">' .
                    '<span class="icon-wrap">' .
                        $icon .
                        $count .
                    '</span>' .
                    '<span class="icon-text hidden-tag">' . esc_html__('Wishlist', 'elessi-theme') . '</span>' .
                '</a>';
            }
            
            $GLOBALS['nasa_icon_wishlist'] = $nasa_icon_wishlist;
        }

        return isset($nasa_icon_wishlist) && $nasa_icon_wishlist ? apply_filters('nasa_mini_wishlist', $nasa_icon_wishlist) : '';
    }
endif;

/**
 * Count mini wishlist icon
 */
if (!function_exists('elessi_get_count_wishlist')) :
    function elessi_get_count_wishlist($show = true, $init_count = true) {
        if (!NASA_WOO_ACTIVED) {
            return '';
        }
        
        global $nasa_opt;
        
        $count = 0;
        if (NASA_WISHLIST_ENABLE) {
            $count = $init_count ? yith_wcwl_count_products() : 0;
        } else {
            $show = true;
        }
        
        $hasEmpty = (int) $count == 0 ? ' nasa-product-empty' : '';
        $sl = $show ? '' : ' hidden-tag';
        $class_wrap = 'nasa-wishlist-count nasa-mini-number wishlist-number' . $sl . $hasEmpty;
        
        if (!isset($nasa_opt['compact_number']) || $nasa_opt['compact_number']) {
            $count = $count > 9 ? '9+' : (int) $count;
        }
        
        return 
            '<span class="' . $class_wrap . '">' .
                apply_filters('nasa_mini_wishlist_total_items', $count) .
            '</span>';
    }
endif;

/**
 * Compare link
 */
if (!function_exists('elessi_icon_compare')):
    function elessi_icon_compare() {
        if (!NASA_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return;
        }

        global $nasa_icon_compare, $nasa_opt;
        
        if (!$nasa_icon_compare) {
            global $yith_woocompare;
            
            if (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare']) {
                $view_href = isset($nasa_opt['nasa-page-view-compage']) && (int) $nasa_opt['nasa-page-view-compage'] ? get_permalink((int) $nasa_opt['nasa-page-view-compage']) : home_url('/');
                $class = 'nasa-show-compare inline-block';
                $wrap = false;
            } else {
                $view_href = add_query_arg(array('iframe' => 'true'), $yith_woocompare->obj->view_table_url());
                $class = 'compare';
                $wrap = true;
            }
            
            $icon = apply_filters('nasa_mini_icon_compare', '<i class="nasa-icon compare-icon icon-nasa-refresh"></i>');
            
            $GLOBALS['nasa_icon_compare'] = 
            ($wrap ? '<span class="yith-woocompare-widget">' : '') .
                '<a href="' . esc_url($view_href) . '" title="' . esc_attr__('Compare', 'elessi-theme') . '" class="' . esc_attr($class) . '">' .
                    '<span class="icon-wrap">' .
                        $icon .
                        '<span class="nasa-compare-count nasa-mini-number compare-number nasa-product-empty">0</span>' .
                    '</span>' .
                    '<span class="icon-text hidden-tag">' . esc_html__('Compare', 'elessi-theme') . '</span>' .
                '</a>' .
            ($wrap ? '</span>' : '');
        }
        
        return $nasa_icon_compare ? apply_filters('nasa_mini_compare', $nasa_icon_compare) : '';
    }
endif;

/**
 * Count mini Compare icon
 */
if (!function_exists('elessi_get_count_compare')):
    function elessi_get_count_compare($show = true) {
        if (!NASA_WOO_ACTIVED || !defined('YITH_WOOCOMPARE')) {
            return '';
        }
        
        global $nasa_opt, $yith_woocompare;
        
        $count = count($yith_woocompare->obj->products_list);
        $hasEmpty = (int) $count == 0 ? ' nasa-product-empty' : '';
        
        $sl = $show ? '' : ' hidden-tag';
        $class_wrap = 'nasa-compare-count nasa-mini-number compare-number' . $sl . $hasEmpty;
        
        if (!isset($nasa_opt['compact_number']) || $nasa_opt['compact_number']) {
            $count = $count > 9 ? '9+' : (int) $count;
        }
        
        return
        '<span class="' . $class_wrap . '">' .
            apply_filters('nasa_mini_compare_total_items', $count) .
        '</span>';
    }
endif;

/**
 * Nasa root categories in Shop Top bar
 */
if (!function_exists('elessi_get_root_categories')):
    function elessi_get_root_categories() {
        global $nasa_opt;
        
        $content = '';
        
        if (isset($nasa_opt['top_filter_rootcat']) && !$nasa_opt['top_filter_rootcat']) {
            echo ($content);
            return;
        }
        
        if (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) {
            echo ($content);
            return;
        }
        
        if (NASA_WOO_ACTIVED){
            $nasa_terms = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => 0,
                'hide_empty' => false,
                'orderby' => 'name'
            )));
            
            if ($nasa_terms) {
                $slug = get_query_var('product_cat');
                $nasa_catActive = $slug ? $slug : '';
                $content .= '<div class="nasa-transparent-topbar"></div>';
                $content .= '<div class="nasa-root-cat-topbar-warp hidden-tag"><ul class="nasa-root-cat product-categories">';
                $content .= '<li class="nasa_odd"><span class="nasa-root-cat-header">' . esc_html__('CATEGORIES', 'elessi-theme'). '</span></li>';
                $li_class = 'nasa_even';
                
                foreach ($nasa_terms as $v) {
                    $class_active = $nasa_catActive == $v->slug ? ' nasa-active' : '';
                    $content .= '<li class="cat-item cat-item-' . esc_attr($v->term_id) . ' cat-item-accessories root-item ' . $li_class . '">';
                    $content .= '<a href="' . esc_url(get_term_link($v)) . '" data-id="' . esc_attr($v->term_id) . '" class="nasa-filter-by-cat' . $class_active . '" title="' . esc_attr($v->name) . '" data-taxonomy="product_cat">' . esc_attr($v->name) . '</a>';
                    $content .= '</li>';
                    $li_class = $li_class == 'nasa_even' ? 'nasa_odd' : 'nasa_even';
                }
                
                $content .= '</ul></div>';
            }
        }
        
        $icon = $content != '' ? '<div class="nasa-icon-cat-topbar"><a href="javascript:void(0);" rel="nofollow"><i class="pe-7s-menu"></i><span class="inline-block">' . esc_html__('BROWSE', 'elessi-theme') . '</span></a></div>' : '';
        $content = $icon . $content;
        
        echo $content;
    }
endif;

/**
 * Categories thumbnail
 */
if (!function_exists('elessi_category_thumbnail')) :
    function elessi_category_thumbnail($category = null, $type = 'thumbnail') {
        if (!$category) {
            return '';
        }
    
        $img_str = '';
        $small_thumbnail_size = apply_filters('single_product_small_thumbnail_size', $type);
        $thumbnail_id = function_exists('get_term_meta') ? get_term_meta($category->term_id, 'thumbnail_id', true) : get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);

        $image_src = '';
        if ($thumbnail_id) {
            $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
            $image_src = $image[0];
            $image_width = $image[1];
            $image_height = $image[2];
        } else {
            $image_src = wc_placeholder_img_src();
            $image_width = 100;
            $image_height = 100;
        }

        if ($image_src) {
            $image_src = str_replace(' ', '%20', $image_src);
            $img_str = '<img src="' . esc_url($image_src) . '" alt="' . esc_attr($category->name) . '" width="' . $image_width . '" height="' . $image_height . '" />';
        }

        return $img_str;
    }
endif;

/**
 * Login Or Register Form
 */
add_action('nasa_login_register_form', 'elessi_login_register_form', 10, 1);
if (!function_exists('elessi_login_register_form')) :
    function elessi_login_register_form($prefix = false) {
        global $nasa_opt;
        
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        if ($prefix) {
            remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
        }
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-login-register-form.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-login-register-form.php';
    }
endif;

/**
 * Number post_per_page shop/archive_product
 */
add_filter('loop_shop_per_page', 'elessi_loop_shop_per_page', 20);
if (!function_exists('elessi_loop_shop_per_page')) :
    function elessi_loop_shop_per_page($post_per_page) {
        global $nasa_opt;
        
        return (isset($nasa_opt['products_pr_page']) && (int) $nasa_opt['products_pr_page']) ? (int) $nasa_opt['products_pr_page'] : get_option('posts_per_page');
    }
endif;

/**
 * Number relate products
 */
add_filter('woocommerce_output_related_products_args', 'elessi_output_related_products_args');
if (!function_exists('elessi_output_related_products_args')) :
    function elessi_output_related_products_args($args) {
        global $nasa_opt;
        
        $args['posts_per_page'] = (isset($nasa_opt['relate_product_number']) && (int) $nasa_opt['relate_product_number']) ? (int) $nasa_opt['relate_product_number'] : 12;
        
        return $args;
    }
endif;

/**
 * Compare list in bot site
 */
add_action('nasa_show_mini_compare', 'elessi_show_mini_compare');
if (!function_exists('elessi_show_mini_compare')) :
    function elessi_show_mini_compare() {
        global $nasa_opt, $yith_woocompare;
        
        if (isset($nasa_opt['nasa-product-compare']) && !$nasa_opt['nasa-product-compare']) {
            echo '';
            return;
        }
        
        $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$nasa_compare) {
            echo '';
            return;
        }
        
        if (!isset($nasa_opt['nasa-page-view-compage']) || !(int) $nasa_opt['nasa-page-view-compage']) {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'page-view-compare.php'
            ));
            
            if ($pages) {
                foreach ($pages as $page) {
                    $nasa_opt['nasa-page-view-compage'] = (int) $page->ID;
                    break;
                }
            }
        }
        
        $view_href = isset($nasa_opt['nasa-page-view-compage']) && (int) $nasa_opt['nasa-page-view-compage'] ? get_permalink((int) $nasa_opt['nasa-page-view-compage']) : home_url('/');
        
        $nasa_compare_list = $nasa_compare->get_products_list();
        $max_compare = isset($nasa_opt['max_compare']) ? (int) $nasa_opt['max_compare'] : 4;
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mini-compare.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mini-compare.php';
    }
endif;

/**
 * Default page compare
 */
if (!function_exists('elessi_products_compare_content')) :
    function elessi_products_compare_content($echo = false) {
        global $nasa_opt, $yith_woocompare;
        
        if (isset($nasa_opt['nasa-product-compare']) && !$nasa_opt['nasa-product-compare']) {
            return '';
        }
        
        $nasa_compare = isset($yith_woocompare->obj) ? $yith_woocompare->obj : $yith_woocompare;
        if (!$nasa_compare) {
            return '';
        }
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-view-compare.php';
        if (!$echo) {
            ob_start();
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-view-compare.php';

            return ob_get_clean();
        } else {
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-view-compare.php';
        }
    }
endif;

/**
 * NEXT NAV ON SINGLE PRODUCT
 */
add_action('next_prev_product', 'elessi_next_product');
if (!function_exists('elessi_next_product')) :
    function elessi_next_product() {
        $next_post = get_next_post(true, '', 'product_cat');
        
        if (is_a($next_post, 'WP_Post')) {
            global $nasa_opt;
            
            $in_mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
            
            $next_product = wc_get_product($next_post->ID);
            $title = $next_product->get_name();
            $link = $next_product->get_permalink();
            $class_ajax = defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
            ?>
            <div class="next-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="next" class="icon-next-prev pe-7s-angle-right next<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>"></a>
                
                <?php if (!$in_mobile) { ?>
                    <a class="dropdown-wrap<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                        <?php echo $next_product->get_image('thumbnail'); ?>
                        <div class="next-prev-info padding-left-10 rtl-padding-left-0 rtl-padding-right-10">
                            <p class="product-name"><?php echo $title; ?></p>
                            <span class="price"><?php echo $next_product->get_price_html(); ?></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <?php
        }
    }
endif;

/**
 * PRVE NAV ON SINGLE PRODUCT PAGE
 */
add_action('next_prev_product', 'elessi_prev_product');
if (!function_exists('elessi_prev_product')) :
    function elessi_prev_product() {
        $prev_post = get_previous_post(true, '', 'product_cat');
        
        if (is_a($prev_post, 'WP_Post')) {
            global $nasa_opt;
            
            $in_mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
            
            $prev_product = wc_get_product($prev_post->ID);
            $title = $prev_product->get_name();
            $link = $prev_product->get_permalink();
            $class_ajax = defined('NASA_AJAX_PRODUCT') && NASA_AJAX_PRODUCT ? ' nasa-ajax-call' : '';
            ?>
            <div class="prev-product next-prev-buttons">
                <a href="<?php echo esc_url($link); ?>" rel="prev" class="icon-next-prev pe-7s-angle-left prev<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>"></a>
                
                <?php if (!$in_mobile) { ?>
                    <a class="dropdown-wrap<?php echo $class_ajax; ?>" title="<?php echo esc_attr($title); ?>" href="<?php echo esc_url($link); ?>">
                        <?php echo $prev_product->get_image('thumbnail'); ?>
                        <div class="next-prev-info padding-left-10 rtl-padding-left-0 rtl-padding-right-10">
                            <p class="product-name"><?php echo $title; ?></p>
                            <span class="price"><?php echo $prev_product->get_price_html(); ?></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <?php
        }
    }
endif;

/**
 * ADD LIGHTBOX IMAGES BUTTON ON PRODUCT DETAIL PAGE
 */
add_action('nasa_single_buttons', 'elessi_product_single_lightbox_btn');
if (!function_exists('elessi_product_single_lightbox_btn')) {
    function elessi_product_single_lightbox_btn() {
        echo '<a class="product-lightbox-btn hidden-tag" href="javascript:void(0);" rel="nofollow"></a>';
    }
}

/**
 * ADD VIDEO PLAY BUTTON ON PRODUCT DETAIL PAGE
 */
add_action('nasa_single_buttons', 'elessi_product_video_btn', 9);
if (!function_exists('elessi_product_video_btn')) {
    function elessi_product_video_btn() {
        global $product;
        
        $id = $product->get_id();
        $video_link = elessi_get_product_meta_value($id, '_product_video_link');
 
        if ($video_link) {
            ?>
            <a class="product-video-popup nasa-tip nasa-tip-right" data-tip="<?php esc_attr_e('Play Video', 'elessi-theme'); ?>" href="<?php echo esc_url($video_link); ?>" title="<?php esc_attr_e('Play Video', 'elessi-theme'); ?>">
                <span class="nasa-icon fa fa-play"></span>
            </a>

            <?php
            $height = '800';
            $width = '800';
            $iframe_scale = '100%';
            
            $custom_size = elessi_get_product_meta_value($id, '_product_video_size');
            
            if ($custom_size) {
                $split = explode("x", $custom_size);
                $height = isset($split[0]) ? $split[0] : '800';
                $width = isset($split[1]) ? $split[1] : '800';
                $iframe_scale = $width && $height ? ($width / $height * 100) . '%' : '100%';
            }
            
            $style = '.has-product-video .mfp-iframe-holder .mfp-content{max-width: ' . $width . 'px;}';
            $style .= '.has-product-video .mfp-iframe-scaler{padding-top: ' . $iframe_scale . ';}';
            wp_add_inline_style('product_detail_css_custom', $style);
        }
    }
}

/**
 * Wishlist Button ext Yith Wishlist
 */
if (!function_exists('elessi_add_wishlist_button')) :
    function elessi_add_wishlist_button($tip = 'left') {
        if (NASA_WISHLIST_ENABLE) {
            global $product, $yith_wcwl, $nasa_opt;
            
            if (!$yith_wcwl) {
                return;
            }
            
            $variation = false;
            $productId = $product->get_id();
            $productType = $product->get_type();
            
            if ($productType == 'variation') {
                $variation_product = $product;
                $productId = wp_get_post_parent_id($productId);
                $parentProduct = wc_get_product($productId);
                $productType = $parentProduct->get_type();
                
                $GLOBALS['product'] = $parentProduct;
                $variation = true;
            }

            $class_btn = 'btn-wishlist btn-link wishlist-icon nasa-tip';
            $class_btn .= ' nasa-tip-' . $tip;
            
            /**
             * Apply Filters Icon
             */
            $icon = apply_filters('nasa_icon_wishlist', '<i class="nasa-icon icon-nasa-like"></i>');
            ?>
            <a href="javascript:void(0);" class="<?php echo esc_attr($class_btn); ?>" data-prod="<?php echo (int) $productId; ?>" data-prod_type="<?php echo esc_attr($productType); ?>" data-original-product-id="<?php echo (int) $productId; ?>" data-icon-text="<?php esc_attr_e('Wishlist', 'elessi-theme'); ?>" title="<?php esc_attr_e('Wishlist', 'elessi-theme'); ?>" rel="nofollow">
                <?php echo $icon; ?>
            </a>

            <?php if (isset($nasa_opt['optimize_wishlist_html']) && !$nasa_opt['optimize_wishlist_html']) : ?>
                <div class="add-to-link hidden-tag">
                    <?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
                </div>
            <?php endif; ?>

            <?php
            if ($variation) {
                $GLOBALS['product'] = $variation_product;
            }
        }
    }
endif;

/**
 * progress bar stock quantity
 */
if (!function_exists('elessi_single_availability')) :
    function elessi_single_availability() {
        global $product;
        
        // Availability
        $availability = $product->get_availability();

        if ($availability['availability']) {
            echo apply_filters('woocommerce_stock_html', '<p class="stock ' . esc_attr($availability['class']) . '">' . wp_kses(__('<span>Availability:</span> ', 'elessi-theme'), array('span' => array())) . esc_html($availability['availability']) . '</p>', $availability['availability']);
        }
    }
endif;

/**
 * Toggle coupon
 */
if (!function_exists('elessi_wrap_coupon_toggle')) :
    function elessi_wrap_coupon_toggle($content) {
        return '<div class="nasa-toggle-coupon-checkout">' . $content . '</div>';
    }
endif;

/**
 * Tab Combo Yith Bundle product
 */
if (!function_exists('elessi_combo_tab')) :
    function elessi_combo_tab($nasa_viewmore = true) {
        global $woocommerce, $nasa_opt, $product;

        if (!$woocommerce || !$product || $product->get_type() != NASA_COMBO_TYPE || !$combo = $product->get_bundled_items()) {
            return false;
        }

        $file = ELESSI_CHILD_PATH . '/includes/nasa-combo-products-in-detail.php';
        $file = is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-combo-products-in-detail.php';
        
        ob_start();
        include $file;

        return ob_get_clean();
    }
endif;

/**
 * Get All categories product filter in top
 */
if (!function_exists('elessi_get_all_categories')) :
    function elessi_get_all_categories($only_show_child = false, $main = false, $hierarchical = true, $order = 'order') {
        if (!NASA_WOO_ACTIVED) {
            return;
        }
        
        global $nasa_opt, $wp_query, $post;

        $current_cat = false;
        $cat_ancestors = array();

        $root_id = 0;

        /**
         * post type page
         */
        if (
            isset($nasa_opt['disable_top_level_cat']) &&
            $nasa_opt['disable_top_level_cat'] &&
            isset($post->ID) &&
            $post->post_type == 'page'
        ) {
            $current_slug = get_post_meta($post->ID, '_nasa_root_category', true);

            if ($current_slug) {
                $current_cat = get_term_by('slug', $current_slug, 'product_cat');

                if ($current_cat && isset($current_cat->term_id)) {
                    $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
                }
            }
        }

        /**
         * Archive product category
         */
        elseif (is_tax('product_cat')) {
            $current_cat = $wp_query->queried_object;
            $cat_ancestors = get_ancestors($current_cat->term_id, 'product_cat');
        }

        /**
         * Single product page
         */
        elseif (is_singular('product')) {
            $productId = isset($wp_query->queried_object->ID) ? $wp_query->queried_object->ID : $post->ID;

            $product_category = wc_get_product_terms($productId, 'product_cat', array(
                'orderby' => 'parent',
                'order'   => 'DESC'
            ));

            if ($product_category) {
                $main_term = apply_filters('woocommerce_product_categories_widget_main_term', $product_category[0], $product_category);
                $current_cat = $main_term;
                $cat_ancestors = get_ancestors($main_term->term_id, 'product_cat');
            }
        }

        if ($only_show_child && $current_cat && $current_cat->term_id) {
            $terms_chilren = get_terms(apply_filters('woocommerce_product_attribute_terms', array(
                'taxonomy' => 'product_cat',
                'parent' => $current_cat->term_id,
                'hierarchical' => $hierarchical,
                'hide_empty' => false
            )));

            if (!$terms_chilren) {
                $term_root = get_ancestors($current_cat->term_id, 'product_cat');
                $root_id = isset($term_root[0]) ? $term_root[0] : $root_id;
            } else {
                $root_id = $current_cat->term_id;
            }
        }

        elseif ((isset($nasa_opt['disable_top_level_cat']) && $nasa_opt['disable_top_level_cat'])) {
            $root_id = $cat_ancestors ? end($cat_ancestors) : ($current_cat ? $current_cat->term_id : $root_id);
        }

        $hide_empty = (isset($nasa_opt['hide_empty_cat_top']) && $nasa_opt['hide_empty_cat_top']) ? true : false;
        $args = array(
            'taxonomy' => 'product_cat',
            'show_count' => 0,
            'hierarchical' => 1,
            'hide_empty' => apply_filters('nasa_top_filter_cats_hide_empty', $hide_empty)
        );

        /**
         * Max depth = 0 ~ all
         */
        $max_depth = !isset($nasa_opt['depth_cat_top']) ? 0 : (int) $nasa_opt['depth_cat_top']; 
        $args['depth'] = apply_filters('nasa_max_depth_top_filter_cats', $max_depth);

        $args['menu_order'] = false;
        if ($order == 'order') {
            $args['menu_order'] = 'asc';
        } else {
            $args['orderby'] = 'title';
        }

        $args['walker'] = new Elessi_Product_Cat_List_Walker($args['depth']);
        $args['title_li'] = '';
        $args['pad_counts'] = 1;
        $args['show_option_none'] = esc_html__('No product categories exist.', 'elessi-theme');
        $args['current_category'] = $current_cat ? $current_cat->term_id : '';
        $args['current_category_ancestors'] = $cat_ancestors;
        $args['child_of'] = apply_filters('nasa_root_id_top_filter_cats', $root_id);
        $args['echo'] = false;

        if (!isset($nasa_opt['show_uncategorized']) || !$nasa_opt['show_uncategorized']) {
            $uncategorized = get_option('default_product_cat');

            if ($uncategorized) {
                $args['exclude'] = $uncategorized;
            }
        }

        $nasa_top_filter = '<ul class="nasa-top-cat-filter product-categories nasa-accordion">';
        $nasa_top_filter .= wp_list_categories(apply_filters('woocommerce_product_categories_widget_args', $args));
        $nasa_top_filter .= '<li class="nasa-current-note"></li>';
        $nasa_top_filter .= '</ul>';
        
        $tmpl = isset($nasa_opt['tmpl_html']) && $nasa_opt['tmpl_html'] ? true : false;
        
        $result = $main ? '<div id="nasa-main-cat-filter">' : '<div id="nasa-mobile-cat-filter">';
        $result .= $tmpl ? '<template class="nasa-tmpl">' : '';
        $result .= $nasa_top_filter;
        $result .= $tmpl ? '</template>' : '';
        $result .= '</div>';
        
        return $result;
    }
endif;

/**
 * nasa_archive_get_sub_categories
 */
add_action('nasa_archive_get_sub_categories', 'elessi_archive_get_sub_categories');
if (!function_exists('elessi_archive_get_sub_categories')) :
    function elessi_archive_get_sub_categories() {
        $GLOBALS['nasa_cat_loop_delay'] = 0;
        
        echo '<div class="nasa-archive-sub-categories-wrap">';
        
        woocommerce_product_subcategories(array(
            'before' => '<div class="row"><div class="large-12 columns"><h3>' . esc_html__('Subcategories: ', 'elessi-theme') . '</h3></div></div><div class="row">',
            'after' => '</div><div class="row"><div class="large-12 columns margin-bottom-20 margin-top-20 text-center"><hr class="margin-left-20 margin-right-20" /></div></div>'
        ));
        
        echo '</div>';
    }
endif;

/**
 * Filter Paginate Links
 * 
 * Since 4.6.3
 */
add_filter('paginate_links', 'elessi_paginate_links');
if (!function_exists('elessi_paginate_links')) :
    function elessi_paginate_links($link) {
        if (!defined('NASA_AJAX_SHOP') || !NASA_AJAX_SHOP) {
            return $link;
        }
    
        return str_replace('/page/1/', '/', $link);
    }
endif;

/**
 * Filter Pagination args
 * 
 * Since 4.6.3
 */
add_filter('woocommerce_pagination_args', 'elessi_pagination_args');
if (!function_exists('elessi_pagination_args')) :
    function elessi_pagination_args($args) {
        if (empty($args)) {
            $args = array();
        }
        
        $args['prev_text'] = '<span class="pe7-icon pe-7s-angle-left"></span>';
        $args['next_text'] = '<span class="pe7-icon pe-7s-angle-right"></span>';
        $args['type'] = 'list';
        $args['end_size'] = 1;
        $args['mid_size'] = 1;
    
        return $args;
    }
endif;

/**
 * No paging url
 */
if (!function_exists('elessi_nopaging_url')) :
    function elessi_nopaging_url() {
        global $wp;

        if (!$wp->request) {
            return false;
        }

        $current_url = home_url($wp->request);
        $pattern = '/page(\/)*([0-9\/])*/i';
        $nopaging_url = preg_replace($pattern, '', $current_url);

        return trailingslashit($nopaging_url);
    }
endif;

/**
 * Compatible WooCommerce_Advanced_Free_Shipping
 * Only with one Rule "subtotal >= Rule"
 */
add_action('nasa_subtotal_free_shipping', 'elessi_subtotal_free_shipping');
add_action('woocommerce_widget_shopping_cart_total', 'elessi_subtotal_free_shipping', 20);
if (!function_exists('elessi_subtotal_free_shipping')) :
    function elessi_subtotal_free_shipping($return = false) {
        $content = '';
        
        /**
         * Check active plug-in WooCommerce || WooCommerce_Advanced_Free_Shipping
         */
        if (!NASA_WOO_ACTIVED || !class_exists('WooCommerce_Advanced_Free_Shipping') || !function_exists('WAFS')) {
            return $content;
        }

        /**
         * Check setting plug-in
         */
        $wafs = WAFS();
        if (!isset($wafs->was_method)) {
            $wafs->wafs_free_shipping();
        }
        
        $wafs_method = isset($wafs->was_method) ? $wafs->was_method : null;
        if (!$wafs_method || $wafs_method->enabled === 'no') {
            return $content;
        }

        /**
         * Check has
         */
        $wafs_posts = get_posts(array(
            // 'posts_per_page'    => 2,
            'post_status'       => 'publish',
            'post_type'         => 'wafs'
        ));
        
        if (!$wafs_posts || count($wafs_posts) < 1) {
            return $content;
        }
        
        $value = 0;

        /**
         * Check and Rules
         */
        foreach ($wafs_posts as $wafs_post) {
            $condition_groups = get_post_meta($wafs_post->ID, '_wafs_shipping_method_conditions', true);
            if (!$condition_groups || count($condition_groups) !== 1) {
                continue;
            }
            
            $condition_group = reset($condition_groups);
            if (!$condition_group || count($condition_group) !== 1) {
                continue;
            }
            
            /**
             * Check rule is subtotal
             */
            foreach ($condition_group as $condition) {
                if ($condition['condition'] !== 'subtotal' || $condition['operator'] !== '>=' || !$condition['value']) {
                    continue;
                }

                if (!$value || $value > $condition['value']) {
                    $value = $condition['value'];
                }
            }
        }

        $subtotalCart = WC()->cart->subtotal;
        $spend = 0;
        
        $content_cond = '';
        $content_desc = '';
        
        /**
         * Check free shipping
         */
        if ($subtotalCart < $value) {
            $spend = $value - $subtotalCart;
            $per = intval(($subtotalCart/$value)*100);
            
            $allowed_html = array(
                'strong' => array(),
                'a' => array(
                    'class' => array(),
                    'href' => array(),
                    'title' => array()
                ),
                'span' => array(
                    'class' => array()
                ),
                'br' => array()
            );
            
            $content_desc .= '<div class="nasa-total-condition-desc text-center">' .
            sprintf(
                wp_kses(__('Spend %s more to reach <strong>FREE SHIPPING!</strong> <a class="continue-cart hide-in-cart-sidebar" href="%s" title="Continue Shopping">Continue Shopping</a>', 'elessi-theme'), $allowed_html),
                wc_price($spend),
                esc_url(get_permalink(wc_get_page_id('shop')))
            ) . 
            '</div>';
        }
        /**
         * Congratulations! You've got free shipping!
         */
        else {
            $per = 100;
            $content_desc .= '<div class="nasa-total-condition-desc text-center">';
            $content_desc .= '<i class="pe-icon pe-7s-check text-success fs-20 margin-right-5 rtl-margin-right-0 rtl-margin-left-5"></i>';
            $content_desc .= esc_html__("Congratulations! You've got free shipping.", 'elessi-theme');
            $content_desc .= '</div>';
        }
        
        $class_cond = 'nasa-total-condition-wrap';
        
        $content_cond .= '<div class="nasa-total-condition" data-per="' . $per . '">' .
            '<div class="nasa-subtotal-condition primary-bg nasa-relative">' .
                '<span class="nasa-total-number primary-border text-center nasa-flex jc">' . $per . '%</span>' .
            '</div>' .
        '</div>';
        
        $content .= '<div class="' . $class_cond . '">';
        $content .= $content_cond;
        $content .= '</div>';
        $content .= $content_desc;
        
        if (!$return) {
            echo $content;
            
            return;
        }
        
        return $content;
    }
endif;

/**
 * Add Free_Shipping to Cart page
 */
add_action('woocommerce_cart_contents', 'elessi_subtotal_free_shipping_in_cart');
if (!function_exists('elessi_subtotal_free_shipping_in_cart')) :
    function elessi_subtotal_free_shipping_in_cart() {
        $content = elessi_subtotal_free_shipping(true);
        
        if ($content !== '') {
            echo '<tr class="nasa-no-border"><td colspan="6" class="nasa-subtotal_free_shipping">' . $content . '</td></tr>';
        }
    }
endif;

/**
 * Before account Navigation
 */
add_action('woocommerce_before_account_navigation', 'elessi_before_account_nav');
if (!function_exists('elessi_before_account_nav')) :
    function elessi_before_account_nav() {
        global $nasa_opt;
        
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED || (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'])) {
            return;
        }
        
        $current_user = wp_get_current_user();
        $logout_url = wp_logout_url(home_url('/'));
        ?>
        <div class="account-nav-wrap vertical-tabs">
            <div class="account-nav account-user hide-for-small">
                <?php echo get_avatar($current_user->ID, 60); ?>
                <span class="user-name">
                    <?php echo esc_attr($current_user->display_name); ?>
                </span>
                <span class="logout-link">
                    <a href="<?php echo esc_url($logout_url); ?>" title="<?php esc_attr_e('Logout', 'elessi-theme'); ?>">
                        <?php esc_html_e('Logout', 'elessi-theme'); ?>
                    </a>
                </span>
            </div>
    <?php
    }
endif;

/**
 * After account Navigation
 */
add_action('woocommerce_after_account_navigation', 'elessi_after_account_nav');
if (!function_exists('elessi_after_account_nav')) :
    function elessi_after_account_nav() {
        global $nasa_opt;
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED || (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'])) {
            return;
        }
        
        echo '</div>';
    }
endif;

/**
 * Account Dashboard Square
 */
add_action('woocommerce_account_dashboard', 'elessi_account_dashboard_nav');
if (!function_exists('elessi_account_dashboard_nav')) :
    function elessi_account_dashboard_nav() {
        if (!NASA_WOO_ACTIVED || !NASA_CORE_USER_LOGGED) {
            return;
        }
        
        $menu_items = wc_get_account_menu_items();
        if (empty($menu_items)) {
            return;
        }
        ?>
        <nav class="woocommerce-MyAccount-navigation nasa-MyAccount-navigation">
            <ul>
                <?php foreach ($menu_items as $endpoint => $label) : ?>
                    <li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    <?php
    }
endif;

/**
 * Custom class Single product Price
 */
add_filter('woocommerce_product_price_class', 'elessi_product_price_class');
if (!function_exists('elessi_product_price_class')) :
    function elessi_product_price_class($class) {
        $class .= ' nasa-single-product-price';
        
        return $class;
    }
endif;

/**
 * Custom class Single product tabs
 */
add_filter('nasa_single_product_tabs_style', 'elessi_single_product_tabs_class');
if (!function_exists('elessi_single_product_tabs_class')) :
    function elessi_single_product_tabs_class($class) {
        global $nasa_opt;
        
        $classes = isset($nasa_opt['tab_style_info']) ? $nasa_opt['tab_style_info'] : $class;
        
        return $classes;
    }
endif;

/**
 * Override woocommerce_catalog_orderby
 */
add_filter('woocommerce_catalog_orderby', 'elessi_wc_catalog_orderby');
if (!function_exists('elessi_wc_catalog_orderby')) :
    function elessi_wc_catalog_orderby($catalogs) {
        return array(
            'menu_order' => __('Default sorting', 'elessi-theme'),
            'popularity' => __('Popularity', 'elessi-theme'),
            'rating'     => __('Average rating', 'elessi-theme'),
            'date'       => __('Latest', 'elessi-theme'),
            'price'      => __('Price: Ascending', 'elessi-theme'),
            'price-desc' => __('Price: Decrease', 'elessi-theme'),
        );
    }
endif;

/**
 * Get Root term_id
 */
if (!function_exists('elessi_get_root_term_id')) :
    function elessi_get_root_term_id() {
        return function_exists('nasa_root_term_id') ? nasa_root_term_id() : false;
    }
endif;

/**
 * Hook Before render shop
 */
add_action('nasa_before_render_shop', 'elessi_override_options_shop');
if (!function_exists('elessi_override_options_shop')) :
    function elessi_override_options_shop() {
        global $nasa_opt;
        
        /**
         * Override for Root Category
         */
        $root_cat_id = elessi_get_root_term_id();

        if ($root_cat_id) {

            /* Override cat side-bar layout */
            $cat_sidebar_style = get_term_meta($root_cat_id, 'cat_sidebar_layout', true);
            if ($cat_sidebar_style != '') {
                $nasa_opt['category_sidebar'] = $cat_sidebar_style;
            }
            
            /**
             * Product Type view
             */
            $cat_type_view = get_term_meta($root_cat_id, 'cat_type_view', true);
            if ($cat_type_view != '') {
                $nasa_opt['products_type_view'] = $cat_type_view;
            }

            /**
             * Product Change View mode
             */
            $cat_change_view = get_term_meta($root_cat_id, 'cat_change_view', true);
            if ($cat_change_view != '') {
                $nasa_opt['enable_change_view'] = $cat_change_view == -1 ? false : '1';
            }
            
            /**
             * Product Per row
             */
            $cat_per_row = get_term_meta($root_cat_id, 'cat_per_row', true);
            if ($cat_per_row != '') {
                $nasa_opt['products_per_row'] = $cat_per_row;
            }

            /**
             * Product Per row Medium
             */
            $cat_per_row_medium = get_term_meta($root_cat_id, 'cat_per_row_medium', true);
            if ($cat_per_row_medium != '') {
                $nasa_opt['products_per_row_tablet'] = $cat_per_row_medium;
            }
            
            /**
             * Product Per row Small
             */
            $cat_per_row_small = get_term_meta($root_cat_id, 'cat_per_row_small', true);
            if ($cat_per_row_small != '') {
                $nasa_opt['products_per_row_small'] = $cat_per_row_small;
            }
            
            /**
             * Products layout_style
             */
            $cat_layout_style = get_term_meta($root_cat_id, 'cat_layout_style', true);
            if ($cat_layout_style != '') {
                $nasa_opt['products_layout_style'] = $cat_layout_style;
            }
            
            /**
             * Products masonry_mode
             */
            $cat_masonry_mode = get_term_meta($root_cat_id, 'cat_masonry_mode', true);
            if ($cat_masonry_mode != '') {
                $nasa_opt['products_masonry_mode'] = $cat_masonry_mode;
            }
            
            /**
             * Products Recommend Columns
             */
            $cat_recommend_columns = get_term_meta($root_cat_id, 'cat_recommend_columns', true);
            if ($cat_recommend_columns != '') {
                $nasa_opt['recommend_columns_desk'] = $cat_recommend_columns;
            }
            
            /**
             * Products Recommend Columns Medium
             */
            $cat_recommend_columns_medium = get_term_meta($root_cat_id, 'cat_recommend_columns_medium', true);
            if ($cat_recommend_columns_medium != '') {
                $nasa_opt['recommend_columns_tablet'] = $cat_recommend_columns_medium;
            }
            
            /**
             * Products Recommend Columns Small
             */
            $cat_recommend_columns_small = get_term_meta($root_cat_id, 'cat_recommend_columns_small', true);
            if ($cat_recommend_columns_small != '') {
                $nasa_opt['recommend_columns_small'] = $cat_recommend_columns_small;
            }
        }
        
        if (isset($nasa_opt['products_per_row']) && $nasa_opt['products_per_row'] == '6-cols') {
            $nasa_opt['option_6_cols'] = 1;
        }
        
        if (isset($nasa_opt['products_per_row']) && $nasa_opt['products_per_row'] == '2-cols') {
            $nasa_opt['option_2_cols'] = 1;
        }
        
        $GLOBALS['nasa_opt'] = $nasa_opt;
    }
endif;

/**
 * Hook Before render shop
 */
add_action('nasa_before_render_single_product', 'elessi_override_options_single_product');
if (!function_exists('elessi_override_options_single_product')) :
    function elessi_override_options_single_product() {
        global $nasa_opt;
        
        /**
         * Override for Root Category
         */
        $root_cat_id = elessi_get_root_term_id();

        if ($root_cat_id) {
            /**
             * Products Relate Columns
             */
            $cat_relate_columns = get_term_meta($root_cat_id, 'cat_relate_columns', true);
            if ($cat_relate_columns != '') {
                $nasa_opt['relate_columns_desk'] = $cat_relate_columns;
            }
            
            /**
             * Products Relate Columns Medium
             */
            $cat_relate_columns_medium = get_term_meta($root_cat_id, 'cat_relate_columns_medium', true);
            if ($cat_relate_columns_medium != '') {
                $nasa_opt['relate_columns_tablet'] = $cat_relate_columns_medium;
            }
            
            /**
             * Products Relate Columns Small
             */
            $cat_relate_columns_small = get_term_meta($root_cat_id, 'cat_relate_columns_small', true);
            if ($cat_relate_columns_small != '') {
                $nasa_opt['relate_columns_small'] = $cat_relate_columns_small;
            }
        }
        
        $GLOBALS['nasa_opt'] = $nasa_opt;
    }
endif;

/**
 * Add sku to product search
 */
add_action('pre_get_posts', 'elessi_pre_get_posts_sku');
if (!function_exists('elessi_pre_get_posts_sku')) :
    function elessi_pre_get_posts_sku($query) {
        global $nasa_opt;

        // conditions - change the post type clause if you're not searching woocommerce or 'product' post type
        if (
            NASA_CORE_IN_ADMIN ||
            !isset($nasa_opt['sp_search_sku']) ||
            !$nasa_opt['sp_search_sku'] ||
            !$query->is_main_query() ||
            !$query->is_search() ||
            'product' != get_query_var('post_type')
        ){
           return;
        }

        add_filter('posts_join', 'elessi_sku_search_join');
        add_filter('posts_where', 'elessi_sku_search_where');
        add_filter('posts_groupby', 'elessi_sku_search_groupby');
    }
endif;

/**
 * Filter JOIN with _sku
 */
if (!function_exists('elessi_sku_search_join')) :
    function elessi_sku_search_join($join) {
       global $wpdb;

       // change to your meta key if not woo
       $join .= ' LEFT JOIN ' . $wpdb->postmeta . ' nspm ON (' . $wpdb->posts . '.ID = nspm.post_id AND nspm.meta_key="_sku")';

       return $join;
    }
endif;

/**
 * Filter WHERE with _sku
 */
if (!function_exists('elessi_sku_search_where')) :
    function elessi_sku_search_where($where) {
        global $wpdb;

        return preg_replace(
            "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            '(' . $wpdb->posts . '.post_title LIKE $1) OR (nspm.meta_value LIKE $1)',
            $where
        );
    }
endif;

/**
 * Filter GROUP BY id with _sku
 */
if (!function_exists('elessi_sku_search_groupby')) :
    function elessi_sku_search_groupby($groupby) {
        global $wpdb;

        $nsgroupby = $wpdb->posts . '.ID';

        if (preg_match("/$nsgroupby/", $groupby)) {
            // grouping we need is already there
            return $groupby;
        }

        if (!strlen(trim($groupby))) {
            // groupby was empty, use ours
            return $nsgroupby;
        }

        // wasn't empty, append ours
        return $groupby . ', ' . $nsgroupby;
    }
endif;

/**
 * Cart Total Coupons - Label
 */
add_filter('woocommerce_cart_totals_coupon_label', 'elessi_cart_totals_coupon_label');
if (!function_exists('elessi_cart_totals_coupon_label')) :
    function elessi_cart_totals_coupon_label($label) {
        return esc_html__('Coupon', 'elessi-theme');
    }
endif;

/**
 * Cart Total Coupons - HTML
 */
add_filter('woocommerce_cart_totals_coupon_html', 'elessi_cart_totals_coupon_html', 10, 3);
if (!function_exists('elessi_cart_totals_coupon_html')) :
    function elessi_cart_totals_coupon_html($coupon_html, $coupon, $discount_amount_html) {
        $code = $coupon->get_code();
        
        $coupon_html = '<a href="' . esc_url(add_query_arg('remove_coupon', rawurlencode($code), defined('WOOCOMMERCE_CHECKOUT') ? wc_get_checkout_url() : wc_get_cart_url())) . '" class="woocommerce-remove-coupon nasa-tip nasa-flex je" data-coupon="' . esc_attr($code) . '" title="' . esc_attr__('Remove', 'elessi-theme') . '"><span class="cp-code nasa-bold text-center margin-right-5 rtl-margin-right-0 rtl-margin-left-5">' . $code . '</span>' . $discount_amount_html . '</a>';
        
        return $coupon_html;
    }
endif;

/**
 * get List Coupons - Publish
 */
if (!function_exists('elessi_wc_publish_coupons')) :
    function elessi_wc_publish_coupons() {
        global $nasa_opt;
        
        $coupons = array();
        
        if (isset($nasa_opt['mini_cart_p_coupon']) && $nasa_opt['mini_cart_p_coupon']) {
            $coupons_fetch = explode("\n", $nasa_opt['mini_cart_p_coupon']);
            
            if (!empty($coupons_fetch)) {
                foreach ($coupons_fetch as $coupon) {
                    $code = trim($coupon);
                    
                    $coupon_obj = new WC_Coupon($code);
                    
                    if ($coupon_obj instanceof WC_Coupon && $coupon_obj->get_id()) {
                        $coupons[] = $coupon_obj;
                    }
                }
            }
        }
        
        return $coupons;
    }
endif;

/**
 * Comment media Template
 */
add_filter('woocommerce_product_review_comment_form_args', 'elessi_comment_media_upload');
if (!function_exists('elessi_comment_media_upload')) :
    function elessi_comment_media_upload($comment_form) {
        global $nasa_opt;
        
        if (!isset($nasa_opt['comment_media']) || !$nasa_opt['comment_media'] || !isset($comment_form['comment_field'])) {
            return $comment_form;
        }
        
        $max_size = isset($nasa_opt['maxsize_comment_media']) && (int) $nasa_opt['maxsize_comment_media'] ? (int) $nasa_opt['maxsize_comment_media'] : 1024;
        $max_files = isset($nasa_opt['maxfiles_comment_media']) && (int) $nasa_opt['maxfiles_comment_media'] ? (int) $nasa_opt['maxfiles_comment_media'] : 3;
        
        $label = sprintf(esc_html__('Pictures (max size: %s kB, max files: %s)', 'elessi-theme'), $max_size, $max_files);
        
        $comment_form['comment_field'] .= '<p class="nasa-form-media"><label for="nasa-comment-media">' . $label . '&nbsp;</label><input type="file" name="ns_image_upload[]" id="nasa-comment-media" class="ns_image_upload" multiple="" accept=".jpg, .jpeg, .png, .bmp, .gif" /></p>';
    
        return $comment_form;
    }
endif;

/**
 * Process comment media
 */
add_filter('preprocess_comment', 'elessi_preprocess_review_images', 10);
if (!function_exists('elessi_preprocess_review_images')) :
    function elessi_preprocess_review_images($commentdata) {
        global $nasa_opt;
        
        if (!isset($nasa_opt['comment_media']) || !$nasa_opt['comment_media']) {
            return $commentdata;
        }
        
        $files = isset($_FILES['ns_image_upload']) && !empty($_FILES['ns_image_upload']) ? $_FILES['ns_image_upload'] : array();
        
        if (empty($files)) {
            return $commentdata;
        }
        
        $max_size = isset($nasa_opt['maxsize_comment_media']) && (int) $nasa_opt['maxsize_comment_media'] ? (int) $nasa_opt['maxsize_comment_media'] : 1024;
        $max_files = isset($nasa_opt['maxfiles_comment_media']) && (int) $nasa_opt['maxfiles_comment_media'] ? (int) $nasa_opt['maxfiles_comment_media'] : 3;
        
        /**
         * Allow maxfiles upload
         */
        if (isset($files['name']) && count($files['name']) > $max_files) {
            $mess = sprintf(esc_html__('Maximum number of files allowed is: %s file(s)', 'elessi-theme'), $max_files);
            wp_die($mess);
        }
        
        /**
         * Allow maxsize upload
         */
        if (isset($files['size']) && !empty($files['size'])) {
            foreach ($files['size'] as $k => $size) {
                if (!$size) {
                    if (isset($files['name'][$k])) {
                        unset($files['name'][$k]);
                    }
                    
                    if (isset($files['type'][$k])) {
                        unset($files['type'][$k]);
                    }
                    
                    if (isset($files['size'][$k])) {
                        unset($files['size'][$k]);
                    }
                    
                    continue;
                }
                
                if ($size > ($max_size * 1024)) {
                    $mess = sprintf(esc_html__('Max size allowed: %s kB', 'elessi-theme'), $max_size);
                    wp_die($mess);
                }
            }
        }
        
        /**
         * Allow Types upload
         */
        if (isset($files['type']) && !empty($files['type'])) {
            foreach ($files['type'] as $type) {
                $type_file = strtolower($type);
                
                if (!in_array($type_file, array("image/jpg", "image/jpeg", "image/bmp", "image/png", "image/gif"))) {
                    wp_die(esc_html__('Only format accepted: JPG, JPEG, BMP, PNG or GIF', 'elessi-theme'));
                }
            }
        }
        
        /**
         * Allow upload images
         */
        add_action('comment_post', 'elessi_add_review_images', 10, 1);
        
        return $commentdata;
    }
endif;

/**
 * Add Review images
 */
if (!function_exists('elessi_add_review_images')) :
    function elessi_add_review_images($comment_id) {
        $comment = get_comment($comment_id);
        
        $post_id = isset($comment->comment_post_ID) ? $comment->comment_post_ID : null;
        
        $files  = $_FILES["ns_image_upload"];
        $img_id = array();
        
        if (!empty($files['name'])) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';
            
            add_filter('intermediate_image_sizes_advanced', 'elessi_comment_img_sizes');
            add_filter('big_image_size_threshold', '__return_false');
            
            foreach ($files['name'] as $key => $value) {
                if ($files['size'][$key]) {
                    $file = array(
                        'name'     => apply_filters('nasa_photo_reviews_image_file_name', $value, $comment_id, $post_id),
                        'type'     => $files['type'][$key],
                        'tmp_name' => $files['tmp_name'][$key],
                        'error'    => $files['error'][$key],
                        'size'     => $files['size'][$key]
                    );

                    $_FILES["upload_file"] = $file;
                    $attachment_id         = media_handle_upload("upload_file", $post_id);

                    if (is_wp_error($attachment_id)) {
                        wp_die($attachment_id->get_error_message());
                    } else {
                        $img_id[] = $attachment_id;
                    }
                }
            }
            
            remove_filter('intermediate_image_sizes_advanced', 'elessi_comment_img_sizes');
        }

        if (!empty($img_id)) {
            update_comment_meta($comment_id, 'nasa_review_images', $img_id);
        }
    }
endif;

/**
 * Image size upload for Images review product
 */
if (!function_exists('elessi_comment_img_sizes')) :
    function elessi_comment_img_sizes($sizes) {
        if (isset($sizes['thumbnail'])) {
            return array('thumbnail' => $sizes['thumbnail']);
        }

        return $sizes;
    }
endif;

/**
 * Show Review images
 */
add_action('woocommerce_review_after_comment_text', 'elessi_review_images', 10, 1);
if (!function_exists('elessi_review_images')) :
    function elessi_review_images($comment) {
        global $nasa_opt;
        
        if (!isset($nasa_opt['comment_media']) || !$nasa_opt['comment_media']) {
            return;
        }
        
        $file = ELESSI_CHILD_PATH . '/includes/nasa-review-images.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-review-images.php';
    }
endif;
