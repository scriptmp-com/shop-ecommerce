<?php
defined('ABSPATH') or die(); // Exit if accessed directly

/**
 * Add Block header
 */
if (!function_exists('elessi_block_header')):
    function elessi_block_header() {
        global $nasa_opt, $wp_query;
        
        $object = $wp_query->get_queried_object();
        $pageOption = isset($object->post_type) && $object->post_type == 'page' ? true : false;
        $objectId = $pageOption ? $object->ID : 0;

        $custom_header = $objectId ? get_post_meta($objectId, '_nasa_custom_header', true) : '';
        
        if (!isset($nasa_opt['header-block'])) {
            $nasa_opt['header-block'] = 'default';
        }
        
        $header_block = ($custom_header !== '' && $objectId) ? get_post_meta($objectId, '_nasa_header_block', true) : $nasa_opt['header-block'];

        if ($header_block == '-1' || $header_block == 'default') {
            return;
        }
        
        $header_block = $header_block == '' ? ($nasa_opt['header-block'] != 'default' ? $nasa_opt['header-block'] : false) : $header_block;
        $header_block = $header_block ? $header_block : false;
        
        echo $header_block ? elessi_get_block($header_block) : '';
    }
endif;

/**
 * Add action header
 */
add_action('init', 'elessi_add_action_header');
if (!function_exists('elessi_add_action_header')):
    function elessi_add_action_header() {
        /* Header Promotion */
        add_action('nasa_before_header_structure', 'elessi_promotion_recent_post', 1);
        
        /* Header Default */
        add_action('nasa_header_structure', 'elessi_get_header_structure', 10);
        add_action('nasa_header_structure', 'elessi_block_header', 100);
        
        /* Breadcrumb site */
        add_action('nasa_after_header_structure', 'elessi_get_breadcrumb', 999);
        
        /* Add Breadcrumb for Header Elementor-Pro */
        if (function_exists('elementor_pro_load_plugin')) {
            add_action('elementor/theme/after_do_header', 'elessi_open_elm_breadcrumb', 80);
            add_action('elementor/theme/after_do_header', 'elessi_get_breadcrumb', 90);
            add_action('elementor/theme/after_do_header', 'elessi_close_elm_breadcrumb', 100);
        }
        
        /* Topbar */
        add_action('nasa_topbar_header', 'elessi_header_topbar');
        
        /* Topbar Mobile */
        add_action('nasa_topbar_header_mobile', 'elessi_header_topbar_mobile');
        
        /**
         * Deprecated from 4.2.6
         * Header - Responsive
         */
        if (function_exists('elessi_mobile_header')) {
            add_action('nasa_mobile_header', 'elessi_mobile_header');
        }
    }
endif;

/**
 * Remove Breadcrumb - Single Product Page - Mobile Layout - Modern
 */
add_action('template_redirect', 'elessi_single_product_mm_remove_breadcrumb');
if (!function_exists('elessi_single_product_mm_remove_breadcrumb')) :
    function elessi_single_product_mm_remove_breadcrumb() {
        if (!NASA_WOO_ACTIVED || !is_product()) {
            return;
        }
        
        global $nasa_opt;
        
        $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        if ($inMobile && isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] == 'app') {
            /* Remove Breadcrumb site */
            remove_action('nasa_after_header_structure', 'elessi_get_breadcrumb', 999);

            /* Remove Breadcrumb for Header Elementor-Pro */
            if (function_exists('elementor_pro_load_plugin')) {
                remove_action('elementor/theme/after_do_header', 'elessi_open_elm_breadcrumb', 80);
                remove_action('elementor/theme/after_do_header', 'elessi_get_breadcrumb', 90);
                remove_action('elementor/theme/after_do_header', 'elessi_close_elm_breadcrumb', 100);
            }
        }
    }
endif;

/**
 * Get header structure
 */
if (!function_exists('elessi_get_header_structure')):
    function elessi_get_header_structure() {
        global $nasa_opt;
        
        $has_vertical = array('4', '6');
        $not_search_icon = array('3', '4', '5', '6', '7');
        $transparent = array('1', '2', '3', '5', '7');

        $header_type = isset($nasa_opt['header-type']) ? $nasa_opt['header-type'] : '1';
        
        /**
         * Apply to override header structure
         */
        $hstructure = apply_filters('nasa_header_structure_type', $header_type);
        
        /**
         * Header builder
         */
        if ($hstructure == 'nasa-custom') {
            remove_action('nasa_header_structure', 'elessi_block_header', 100);
            
            $header_slug = isset($nasa_opt['header-custom']) && $nasa_opt['header-custom'] != 'default' ?
                $nasa_opt['header-custom'] : false;
            
            if ($header_slug) {
                elessi_header_builder($header_slug);
            }
            
            return;
        }
        
        /**
         * Apply to fixed header
         */
        $fixed_nav_header = (!isset($nasa_opt['fixed_nav']) || $nasa_opt['fixed_nav']);
        $fixed_nav = apply_filters('nasa_header_sticky', $fixed_nav_header);
        
        $header_classes = array();
        
        /**
         * Transparent header
         */
        $header_transparent = in_array($header_type, $transparent) && isset($nasa_opt['header_transparent']) && $nasa_opt['header_transparent'] ? true : false;
        if ($header_transparent) {
            $header_classes[] = 'nasa-header-transparent';
        }
        
        /**
         * Mobile Detect
         */
        if (isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile']) {
            $header_classes[] = 'nasa-header-mobile-layout';
            if ($fixed_nav) {
                $header_classes[] = 'nasa-header-sticky';
            }
            
            $vertical = in_array($hstructure, $has_vertical) ? true : false;
            $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
            $header_classes = apply_filters('nasa_header_classes', $header_classes);
            
            defined('NASA_TOP_FILTER_CATS') or define('NASA_TOP_FILTER_CATS', apply_filters('nasa_top_filter_cats_state', true));
            
            /**
             * Mobile Layout
             */
            $file_name = 'header-mobile';
            if (isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] !== 'df') {
                $file_name .= '-' . $nasa_opt['mobile_layout'];
            }
            
            $file = ELESSI_CHILD_PATH . '/headers/' . $file_name . '.php'; // File exist in child-theme
            
            if (!is_file($file)) {
                $file = ELESSI_THEME_PATH . '/headers/' . $file_name . '.php'; // File exist in main-theme
            }
            
            if (is_file($file)) {
                include $file;
            }
            
            return;
        }
        
        /**
         * Init vars
         */
        $menu_warp_class = array();
        $header_classes[] = 'header-wrapper header-type-' . $hstructure;
        
        /**
         * Extra class name
         */
        $el_class_header = isset($nasa_opt['el_class_header']) ? $nasa_opt['el_class_header'] : '';
        if ($el_class_header != '') {
            $header_classes[] = $el_class_header;
        }
        
        /**
         * Main menu style
         */
        $menu_warp_class[] = 'nasa-nav-style-1';
        $data_padding_y = apply_filters('nasa_responsive_y_menu', 15);
        $data_padding_x = apply_filters('nasa_responsive_x_menu', 35);
        
        $menu_warp_class = !empty($menu_warp_class) ? ' ' . implode(' ', $menu_warp_class) : '';
        
        /**
         * Full width main menu
         */
        $fullwidth_main_menu = isset($nasa_opt['fullwidth_main_menu']) && $nasa_opt['fullwidth_main_menu'] ? true : false;
        
        /**
         * Top filter cats
         */
        $show_icon_cat_top = isset($nasa_opt['show_icon_cat_top']) ? $nasa_opt['show_icon_cat_top'] : 'show-in-shop';
        switch ($show_icon_cat_top) :
            case 'show-all-site':
                $show_cat_top_filter = true;
                break;

            case 'not-show':
                $show_cat_top_filter = false;
                break;

            case 'show-in-shop':
            default:
                $show_cat_top_filter = NASA_WOO_ACTIVED && (is_product_taxonomy() || is_shop()) ? true : false;
                break;
        endswitch;
        
        defined('NASA_TOP_FILTER_CATS') or define('NASA_TOP_FILTER_CATS', apply_filters('nasa_top_filter_cats_state', $show_cat_top_filter));
        
        $show_product_cat = true;
        $show_cart = true;
        $show_compare = $hstructure != '7' ? true : false;
        $show_wishlist = $hstructure != '7' ? true : false;
        $icon_search = in_array($hstructure, $not_search_icon) ? false : true;
        $show_search = apply_filters('nasa_search_icon_header', $icon_search);
        
        if ($hstructure == '6') {
            add_filter('nasa_header_icons_text', 'elessi_header_icons_text');
        }
        
        $nasa_header_icons = elessi_header_icons($show_product_cat, $show_cart, $show_compare, $show_wishlist, $show_search);
        
        /**
         * Sticky header
         */
        if ($fixed_nav) {
            $header_classes[] = 'nasa-header-sticky';
        }
        
        /**
         * $header_classes to string
         */
        $header_classes = !empty($header_classes) ? implode(' ', $header_classes) : '';
        $header_classes = apply_filters('nasa_header_classes', $header_classes);
        
        /**
         * Main header include
         */
        $file = ELESSI_CHILD_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
        if (is_file($file)) {
            include $file;
        } else {
            $file = ELESSI_THEME_PATH . '/headers/header-structure-' . ((int) $hstructure) . '.php';
            include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/header-structure-1.php';
        }
    }
endif;

/**
 * filter text for header icons
 */
if (!function_exists('elessi_header_icons_text')) :
    function elessi_header_icons_text($icon_text) {
        return true;
    }
endif;

/**
 * Group header icons
 */
if (!function_exists('elessi_header_icons')) :
    function elessi_header_icons($product_cat = true, $cart = true, $compare = true, $wishlist = true, $search = true) {
        global $nasa_opt;
        
        $icons = '';
        $first = false;
        $icon_text = apply_filters('nasa_header_icons_text', false);
        
        /**
         * Hide menu in header
         */
        if (isset($nasa_opt['hide_tini_menu_acc']) && $nasa_opt['hide_tini_menu_acc']) {
            $account_icon = false;
        }
        
        else {
            /**
             * Add Account icon
             */
            $account_icon = (isset($nasa_opt['acc_pos']) && $nasa_opt['acc_pos'] == 'group') ? true : false;

            if (
                !$account_icon &&
                isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] &&
                (!isset($nasa_opt['main_screen_acc_mobile']) || $nasa_opt['main_screen_acc_mobile'])
            ) {
                $account_icon = true;
            }
        }
        
        $account_icon = apply_filters('nasa_account_sp', $account_icon);
        
        if ($account_icon) {
            $title_acc = !NASA_CORE_USER_LOGGED ? esc_attr__('Login / Register', 'elessi-theme') : esc_attr__('My Account', 'elessi-theme');

            $login_ajax = !NASA_CORE_USER_LOGGED && (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1) ? '1' : '0';
            
            $links = elessi_link_account();
            $subacc = elessi_sub_account();
            
            $icon = apply_filters('nasa_mini_icon_account', '<i class="nasa-icon pe7-icon pe-7s-user"></i>');
            
            $icon .= $icon_text ? '<span class="icon-text">' . esc_html__('Account', 'elessi-theme') . '</span>' : '';

            $nasa_icon_account = 
            '<a class="nasa-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($links) . '" title="' . $title_acc . '">' .
                $icon .
            '</a>';
            
            $nasa_icon_account .= $subacc;

            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-account-mobile menus-account">' . $nasa_icon_account . '</li>';
        }
        
        /**
         * List Product Categories icons
         */
        if (NASA_WOO_ACTIVED && $product_cat) {
            $show_icon_cat_top = isset($nasa_opt['show_icon_cat_top']) ? $nasa_opt['show_icon_cat_top'] : 'show-in-shop';
            
            switch ($show_icon_cat_top) {
                case 'show-all-site':
                    $show_icon = true;
                    break;
                
                case 'not-show':
                    $show_icon = false;
                    break;
                
                case 'show-in-shop':
                default:
                    $show_icon = (!is_post_type_archive('product') && !is_tax(get_object_taxonomies('product'))) ? false : true;
                    break;
            }
            
            if ($show_icon) {
                $icon = apply_filters('nasa_mini_icon_filter_cats', '<i class="nasa-icon pe-7s-keypad"></i>');
                $icon .= $icon_text ? '<span class="icon-text">' . esc_html__('Categories', 'elessi-theme') . '</span>' : '';
                
                $nasa_icon_cat = 
                    '<a class="filter-cat-icon inline-block nasa-hide-for-mobile" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'elessi-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>' .
                    '<a class="filter-cat-icon-mobile inline-block" href="javascript:void(0);" title="' . esc_attr__('Product Categories', 'elessi-theme') . '" rel="nofollow">' .
                        $icon .
                    '</a>';
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-filter-cat">' . $nasa_icon_cat . '</li>';
            }
        }
        
        if ($cart) {
            $nasa_mini_cart = elessi_mini_cart();
            if ($nasa_mini_cart) {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-mini-cart">' . $nasa_mini_cart . '</li>';
            }
        }
        
        if ($wishlist) {
            $nasa_icon_wishlist = elessi_icon_wishlist();
            if ($nasa_icon_wishlist != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-wishlist">' . $nasa_icon_wishlist . '</li>';
            }
        }
        
        if ($compare && (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare'])) {
            $nasa_icon_compare = elessi_icon_compare();
            if ($nasa_icon_compare != '') {
                $class = !$first ? 'first ' : '';
                $first = true;
                $icons .= '<li class="' . $class . 'nasa-icon-compare">' . $nasa_icon_compare . '</li>';
            }
        }
        
        if ($search) {
            $icon = apply_filters('nasa_mini_icon_search', '<i class="nasa-icon nasa-search icon-nasa-search"></i>');
            
            $search_icon = 
            '<a class="search-icon desk-search inline-block" href="javascript:void(0);" data-open="0" title="' . esc_attr__('Search', 'elessi-theme') . '" rel="nofollow">' .
                $icon .
            '</a>';
            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-search nasa-hide-for-mobile">' . $search_icon . '</li>';
        }
        
        $icons .= apply_filters('nasa_header_custom_icons', '');
        
        $icons_wrap = ($icons != '') ? '<div class="nasa-header-icons-wrap"><ul class="header-icons">' . $icons . '</ul></div>' : '';
        
        return apply_filters('nasa_header_icons', $icons_wrap);
    }
endif;

/**
 * Group header icons - mobile
 */
if (!function_exists('elessi_header_icons_mobile')) :
    function elessi_header_icons_mobile() {
        global $nasa_opt;
        
        $icons = '';
        $first = false;
        
        /**
         * Login Register
         */
        if (!isset($nasa_opt['hide_tini_menu_acc']) || !$nasa_opt['hide_tini_menu_acc']) {
            $title_acc = !NASA_CORE_USER_LOGGED ? esc_attr__('Login / Register', 'elessi-theme') : esc_attr__('My Account', 'elessi-theme');

            $login_ajax = !NASA_CORE_USER_LOGGED && (!isset($nasa_opt['login_ajax']) || $nasa_opt['login_ajax'] == 1) ? '1' : '0';

            $links = elessi_link_account();

            $icon = apply_filters('nasa_mini_icon_account', '<i class="nasa-icon pe7-icon pe-7s-user"></i>');

            $nasa_icon_account = 
            '<a class="nasa-login-register-ajax inline-block" data-enable="' . $login_ajax . '" href="' . esc_url($links) . '" title="' . $title_acc . '">' .
                $icon .
            '</a>';

            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-account-mobile">' . $nasa_icon_account . '</li>';
        }
        
        /**
         * Cart Icon
         */
        $nasa_mini_cart = elessi_mini_cart();
        if ($nasa_mini_cart != '') {
            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="' . $class . 'nasa-icon-mini-cart">' . $nasa_mini_cart . '</li>';
        }
        
        $icons_wrap = $icons != '' ? '<ul class="header-icons">' . $icons . '</ul>' : '';
        
        return apply_filters('nasa_header_icons_mobile', $icons_wrap);
    }
endif;

/**
 * Group header icons - mobile
 */
if (!function_exists('elessi_header_icons_mobile_app')) :
    function elessi_header_icons_mobile_app() {
        $icons = '';
        $first = false;
        
        /**
         * Cart Icon
         */
        $nasa_mini_cart = elessi_mini_cart();
        if ($nasa_mini_cart != '') {
            $class = !$first ? 'first ' : '';
            $first = true;
            $icons .= '<li class="first nasa-icon-mini-cart">' . $nasa_mini_cart . '</li>';
        }
        
        /**
         * Search in mobile layout modern
         */
        $class = !$first ? 'first ' : '';
        $icons .= '<li class="' . $class . 'nasa-icon-search"><a class="nasa-icon icon icon-nasa-if-search mobile-search" href="javascript:void(0);" rel="nofollow"></a></li>';
        
        $icons_wrap = $icons != '' ? '<ul class="header-icons">' . $icons . '</ul>' : '';
        
        return apply_filters('nasa_header_icons_mobile_app', $icons_wrap);
    }
endif;

/**
 * Get header builder custom
 */
if (!function_exists('elessi_header_builder')) :
    function elessi_header_builder($header_slug) {
        if (!function_exists('nasa_get_header')) {
            return;
        }

        $header_builder = nasa_get_header($header_slug);
        
        $file = ELESSI_CHILD_PATH . '/headers/header-builder.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/header-builder.php';
    }
endif;

/**
 * Topbar
 */
if (!function_exists('elessi_header_topbar')) :
    function elessi_header_topbar($mobile = false) {
        global $wp_query, $nasa_opt;
        
        $queryObjId = $wp_query->get_queried_object_id();
        
        /**
         * Topbar On | Off
         */
        $topbar_on = !isset($nasa_opt['topbar_on']) || $nasa_opt['topbar_on'] ? true : false;
        if (!$topbar_on) {
            return;
        }
        
        /**
         * Top bar Toggle
         */
        $topbar_toggle = get_post_meta($queryObjId, '_nasa_topbar_toggle', true);
        $topbar_df_show = $topbar_toggle == 1 ? get_post_meta($queryObjId, '_nasa_topbar_default_show', true) : '';

        $topbar_toggle_val = $topbar_toggle == '' ? (isset($nasa_opt['topbar_toggle']) && $nasa_opt['topbar_toggle'] ? true : false) : ($topbar_toggle == 1 ? true : false);
        $topbar_df_show_val = $topbar_df_show == '' ? (!isset($nasa_opt['topbar_default_show']) || $nasa_opt['topbar_default_show'] ? true : false) : ($topbar_df_show == 1 ? true : false);

        $class_topbar = $topbar_toggle_val ? ' nasa-topbar-toggle' : '';
        $class_topbar .= $topbar_df_show_val ? '' : ' nasa-topbar-hide';
        
        /**
         * Top bar content
         */
        $topbar_left = '';
        if (isset($nasa_opt['topbar_content']) && $nasa_opt['topbar_content']) {
            $topbar_left = elessi_get_block($nasa_opt['topbar_content']);
        }
        
        /**
         * Old data
         */
        elseif (isset($nasa_opt['topbar_left']) && $nasa_opt['topbar_left'] != '') {
            $topbar_left = do_shortcode($nasa_opt['topbar_left']);
        }
        
        $file = ELESSI_CHILD_PATH . '/headers/top-bar.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/headers/top-bar.php';
    }
endif;

/**
 * Topbar header Type 7
 */
add_action('nasa_topbar_header_7', 'elessi_topbar_t7_header_icon');
if (!function_exists('elessi_topbar_t7_header_icon')) :
    function elessi_topbar_t7_header_icon() {
        $html = '';
        
        /**
         * Support Account icon
         */
        add_filter('nasa_account_sp', 'elessi_sp_account_true');
    
        /**
         * $product_cat = false,
         * $cart = false,
         * $compare = true,
         * $wishlist = true,
         * $search = false
         */
        $html .= elessi_header_icons(false, false, true, true, false);
        
        /**
         * Remove Support Account icon
         */
        remove_filter('nasa_account_sp', 'elessi_sp_account_true');
        
        /**
         * Follow
         */
        if (shortcode_exists('nasa_follow')) :
            $html .= do_shortcode('[nasa_follow tip="right"]');
        endif;
        
        echo $html;
    }
endif;

/**
 * Support account icon
 */
if (!function_exists('elessi_sp_account_true')) :
    function elessi_sp_account_true($acc_sp) {
        return true;
    }
endif;

/**
 * Topbar mobile
 */
if (!function_exists('elessi_header_topbar_mobile')) :
    function elessi_header_topbar_mobile() {
        elessi_header_topbar(true);
    }
endif;

/**
 * Topbar menu
 */
add_action('nasa_topbar_menu', 'elessi_topbar_menu', 15);
add_action('nasa_mobile_topbar_menu', 'elessi_topbar_menu', 15);
if (!function_exists('elessi_topbar_menu')) :
    function elessi_topbar_menu() {
        elessi_get_menu('topbar-menu', 'nasa-topbar-menu', 1);
    }
endif;

/**
 * Topbar Account
 */
add_action('nasa_topbar_menu', 'elessi_topbar_account', 20);
if (!function_exists('elessi_topbar_account')) :
    function elessi_topbar_account() {
        global $nasa_opt;
        
        echo (!isset($nasa_opt['acc_pos']) || $nasa_opt['acc_pos'] == 'top') ?
            elessi_tiny_account(true) : '';
    }
endif;

/**
 * Mobile account menu
 */
if (!function_exists('elessi_mobile_account')) :
    function elessi_mobile_account() {
        $file = ELESSI_CHILD_PATH . '/includes/nasa-mobile-account.php';
        include is_file($file) ? $file : ELESSI_THEME_PATH . '/includes/nasa-mobile-account.php';
    }
endif;

/**
 * Shortcode group icons header
 */
add_shortcode('nasa_sc_icons', 'elessi_header_icons_sc');
if (!function_exists('elessi_header_icons_sc')) :
    function elessi_header_icons_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'show_mini_cart' => 'yes',
            'show_mini_compare' => 'yes',
            'show_mini_wishlist' => 'yes',
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));

        $cart = $show_mini_cart == 'yes' ? true : false;
        $compare = $show_mini_compare == 'yes' ? true : false;
        $wishlist = $show_mini_wishlist == 'yes' ? true : false;
        
        $class = 'nasa-header-icons-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            elessi_header_icons(false, $cart, $compare, $wishlist, false) .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Short code header search
 */
add_shortcode('nasa_sc_search_form', 'elessi_header_search_sc');
if (!function_exists('elessi_header_search_sc')) :
    function elessi_header_search_sc($atts = array(), $content = null) {
        $dfAttr = array(
            'el_class' => ''
        );
        extract(shortcode_atts($dfAttr, $atts));
        
        $class = 'nasa-header-search-wrap';
        $class .= $el_class != '' ? ' ' . $el_class : '';
        
        $content = '<div class="' . esc_attr($class) . '">' .
            elessi_search('full') .
        '</div>';
        
        return $content;
    }
endif;

/**
 * Get breadcrumb
 */
if (!function_exists('elessi_get_breadcrumb')) :
    function elessi_get_breadcrumb() {
        if (!NASA_WOO_ACTIVED) {
            return;
        }

        global $post, $nasa_opt;
        
        $enable = isset($nasa_opt['breadcrumb_show']) && !$nasa_opt['breadcrumb_show'] ? false : true;
        
        $row = isset($nasa_opt['breadcrumb_row']) && $nasa_opt['breadcrumb_row'] == 'single' ? 'single' : 'multi';
        
        $is_product = is_product();
        $is_product_cat = is_product_category();
        $is_product_taxonomy = is_product_taxonomy();
        $is_shop = is_shop();
        
        $mobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
        
        $override = false;

        // Theme option
        $has_bg = isset($nasa_opt['breadcrumb_type']) && $nasa_opt['breadcrumb_type'] == 'has-background' ?
            true : false;
        
        $bg_key = $mobile ? 'breadcrumb_bg_m' : 'breadcrumb_bg';

        $bg = isset($nasa_opt[$bg_key]) && trim($nasa_opt[$bg_key]) != '' ?
            $nasa_opt[$bg_key] : false;

        $bg_cl = isset($nasa_opt['breadcrumb_bg_color']) && $nasa_opt['breadcrumb_bg_color'] ?
            $nasa_opt['breadcrumb_bg_color'] : false;
        
        $txt_color = isset($nasa_opt['breadcrumb_color']) && $nasa_opt['breadcrumb_color'] ?
            $nasa_opt['breadcrumb_color'] : false;
        
        $bread_align = !isset($nasa_opt['breadcrumb_align']) ? 'text-center' : $nasa_opt['breadcrumb_align'];

        $h_key = $mobile ? 'breadcrumb_height_m' : 'breadcrumb_height';
        $h_bg = isset($nasa_opt[$h_key]) && (int) $nasa_opt[$h_key] ?
            (int) $nasa_opt[$h_key] : false;
        
        $bg_lax = isset($nasa_opt['breadcrumb_bg_lax']) && $nasa_opt['breadcrumb_bg_lax'] ?
            true : false;

        /**
         * Override breadcrumb
         */
        if ($is_shop || $is_product_cat || $is_product_taxonomy || $is_product) {
            $pageShop = wc_get_page_id('shop');
            $root_cat_id = elessi_get_root_term_id();

            /**
             * Check Root Category
             */
            if ($root_cat_id) {
                // cat_breadcrumb_allow
                $enable_override = get_term_meta($root_cat_id, 'cat_breadcrumb_allow', true);
                
                /**
                 * Not show breadcrumb
                 */
                if ($enable_override == -1) {
                    return;
                }
                
                if ($enable_override == 1) {
                    $enable = true;
                }
                
                /**
                 * Not show breadcrumb
                 */
                if (!$enable) {
                    return;
                }
                
                /**
                 * Bg image
                 */
                $bg_cat_enable = get_term_meta($root_cat_id, 'cat_breadcrumb', true);
                
                if ($bg_cat_enable == -1) {
                    $has_bg = false;
                }

                elseif ($bg_cat_enable) {
                    $bg_key = $mobile ? 'cat_breadcrumb_bg_m' : 'cat_breadcrumb_bg';
                    $bg_id = get_term_meta($root_cat_id, $bg_key, true);
                    if ($bg_id) {
                        $bg = wp_get_attachment_image_url($bg_id, 'full');
                        $has_bg = true;
                    }
                }
                
                $row_override = get_term_meta($root_cat_id, 'cat_breadcrumb_layout', true);
                
                $bg_cl_override = get_term_meta($root_cat_id, 'cat_breadcrumb_bg_color', true);
                $color_override = get_term_meta($root_cat_id, 'cat_breadcrumb_text_color', true);
                
                $align_override = get_term_meta($root_cat_id, 'cat_breadcrumb_align', true);
                
                $h_key = $mobile ? 'cat_breadcrumb_height_m' : 'cat_breadcrumb_height';
                $h_override = get_term_meta($root_cat_id, $h_key, true);
                
                $row = $row_override ? $row_override : $row;

                $bg_cl = $bg_cl_override ? $bg_cl_override : $bg_cl;
                $txt_color = $color_override ? $color_override : $txt_color;
                $h_bg = (int) $h_override ? (int) $h_override : $h_bg;

                $bread_align = $align_override ? $align_override : $bread_align;
            }

            /**
             * Breadcrumb shop page
             */
            elseif ($is_shop && $pageShop > 0) {
                $show_breadcrumb = get_post_meta($pageShop, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                
                if (!$enable) {
                    return;
                }
                
                $queryObj = $pageShop;
                $override = true;
            }
        }

        else {
            $pageBlog = get_option('page_for_posts');
            
            /**
             * Check page
             */
            if (isset($post->ID) && $post->post_type == 'page') {
                $queryObj = $post->ID;
                $show_breadcrumb = get_post_meta($queryObj, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $override = true;
            }

            /**
             * Check Blog | archive post | single post
             */
            elseif ($pageBlog && isset($post->post_type) && $post->post_type == 'post' && (is_category() || is_tag() || is_date() || is_home() || is_single())) {
                $show_breadcrumb = get_post_meta($pageBlog, '_nasa_show_breadcrumb', true);
                $enable = ($show_breadcrumb != 'on') ? false : true;
                $queryObj = $pageBlog;
                $override = true;
            }

            if (!$enable) {
                return;
            }
        }
        
        // Override
        if ($override) {

            $row_override = get_post_meta($queryObj, '_nasa_layout_breadcrumb', true);
            
            $type_bg = get_post_meta($queryObj, '_nasa_type_breadcrumb', true);

            $bg_key = $mobile ? '_nasa_bg_breadcrumb_m' : '_nasa_bg_breadcrumb';
            $bg_override = get_post_meta($queryObj, $bg_key, true);

            $bg_cl_override = get_post_meta($queryObj, '_nasa_bg_color_breadcrumb', true);
            $color_override = get_post_meta($queryObj, '_nasa_color_breadcrumb', true);
            
            $align_override = get_post_meta($queryObj, '_nasa_align_breadcrumb', true);

            $h_key = $mobile ? '_nasa_height_breadcrumb_m' : '_nasa_height_breadcrumb';
            $h_override = get_post_meta($queryObj, $h_key, true);

            if ($type_bg == '-1') {
                $bg = false;
            }

            if ($type_bg == '1') {
                $bg = $bg_override ? $bg_override : $bg;
            }
            
            $row = $row_override ? $row_override : $row;

            $bg_cl = $bg_cl_override ? $bg_cl_override : $bg_cl;
            $txt_color = $color_override ? $color_override : $txt_color;
            $h_bg = (int) $h_override ? (int) $h_override : $h_bg;
            
            $bread_align = $align_override ? $align_override : $bread_align;
        }

        // set style by option breadcrumb
        $style_custom = '';
        if ($has_bg && $bg) {
            $style_custom .= 'background:url(' . esc_url($bg) . ')';
            $style_custom .= $bg_lax ? ' center center repeat-y;' : ';background-size:cover;';
        }

        $style_custom .= $bg_cl ? 'background-color:' . $bg_cl . ';' : '';
        $style_custom .= $txt_color ? 'color:' . $txt_color . ';' : '';
        $style_height = $h_bg ? 'height:' . $h_bg . 'px;' : 'height:auto;';
        
        $parallax = ($has_bg && $bg && $bg_lax) ? true : false;
        
        $class_all = array('bread nasa-breadcrumb style-' . $row);
        $attr_all = array('id="nasa-breadcrumb-site"');
        
        if ($has_bg) {
            $class_all[] = 'nasa-breadcrumb-has-bg';
        }
        
        if ($parallax) {
            $class_all[] = 'nasa-parallax nasa-parallax-stellar';
            $attr_all[] = 'data-stellar-background-ratio="0.6"';
            
            // jquery-migrate
            wp_enqueue_script('jquery-migrate', ELESSI_THEME_URI . '/assets/js/min/jquery-migrate.min.js', array('jquery'), null);
            
            // Parallax - js
            wp_enqueue_script('jquery-stellar', ELESSI_THEME_URI . '/assets/js/min/jquery.stellar.min.js', array('jquery'), null, true);
        }
        
        if ($style_custom) {
            $attr_all[] = 'style="' . esc_attr($style_custom) . '"';
        }
        
        $class_all_string = !empty($class_all) ? implode(' ', $class_all) : '';
        if ($class_all_string) {
            $attr_all[] = 'class="' . esc_attr($class_all_string) . '"';
        }
        
        $attr_all_string = !empty($attr_all) ? ' ' . implode(' ', $attr_all) : '';
        
        $defaults = apply_filters('nasa_breadcrumb_args', array(
            'delimiter' => '<span class="fa fa-angle-right"></span>',
            'wrap_before' => '<span class="breadcrumb">',
            'wrap_after' => '</span>',
            'before' => '',
            'after' => '',
            'home' => esc_html__('Home', 'elessi-theme'),
            'row' => $row
        ));
        
        $args = apply_filters('woocommerce_breadcrumb_defaults', $defaults);
        
        $wc_breadcrumbs = new WC_Breadcrumb();

        if (!empty($args['home'])) {
            $wc_breadcrumbs->add_crumb(
                $args['home'],
                apply_filters('woocommerce_breadcrumb_home_url', home_url('/'))
            );
        }
        
        $args['breadcrumb'] = $wc_breadcrumbs->generate();
        
        do_action('woocommerce_breadcrumb', $wc_breadcrumbs, $args);
        
        if (empty($args['breadcrumb'])) {
            return;
        }
        
        ?>
        
        <div<?php echo $attr_all_string; ?>>
            <div class="row">
                <div class="large-12 columns nasa-display-table breadcrumb-wrap <?php echo esc_attr($bread_align); ?>">
                    <nav class="breadcrumb-row"<?php echo $style_height ? ' style="' . esc_attr($style_height).'"' : ''; ?>>
                        <?php wc_get_template('global/breadcrumb.php', $args); ?>
                    </nav>
                </div>
                
                <?php do_action('nasa_after_breadcrumb'); ?>
            </div>
        </div>

        <?php
    }
endif;

/**
 * Build breadcrumb Portfolio
 */
if (!function_exists('elessi_rebuilt_breadcrumb_portfolio')) :
    function elessi_rebuilt_breadcrumb_portfolio($orgBreadcrumb = array(), $single = true) {
        global $nasa_opt, $post;
        
        $breadcrumb = isset($orgBreadcrumb[0]) ? array($orgBreadcrumb[0]) : array();
        
        $portfolio = null;
        if (isset($nasa_opt['nasa-page-view-portfolio']) && (int) $nasa_opt['nasa-page-view-portfolio']) {
            $portfolio = get_post((int) $nasa_opt['nasa-page-view-portfolio']);
        } else {
            $pages = get_pages(array(
                'meta_key' => '_wp_page_template',
                'meta_value' => 'portfolio.php'
            ));

            if ($pages) {
                foreach ($pages as $page) {
                    $portfolio = get_post((int) $page->ID);
                    break;
                }
            }
        }

        if ($portfolio) {
            $breadcrumb[] = array(
                0 => $portfolio->post_title,
                1 => get_permalink($portfolio)
            );
        }

        $terms = wp_get_post_terms(
            $post->ID,
            'portfolio_category',
            array(
                'orderby' => 'parent',
                'order' => 'DESC'
            )
        );

        if ($terms) {
            $main_term = $terms[0];
            $ancestors = get_ancestors($main_term->term_id, 'portfolio_category');
            $ancestors = array_reverse($ancestors);
            if (count($ancestors)) {
                foreach ($ancestors as $ancestor) {
                    $ancestor = get_term($ancestor, 'portfolio_category');

                    if ($ancestor) {
                        $breadcrumb[] = array(
                            0 => $ancestor->name,
                            1 => get_term_link($ancestor, 'portfolio_category')
                        );
                    }
                }
            }

            if ($single) {
                $breadcrumb[] = array(
                    0 => $main_term->name,
                    1 => get_term_link($main_term, 'portfolio_category')
                );
            }
        }

        return $breadcrumb;
    }
endif;

/**
 * Open wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('elessi_open_elm_breadcrumb')) :
    function elessi_open_elm_breadcrumb() {
        echo '<!-- Begin Breadcrumb for Elementor Pro - Header Builder --><div class="nasa-breadcrumb-wrap">';
    }
endif;

/**
 * Close wrap Breadcrumb for Elementor Pro - Header Builder
 */
if (!function_exists('elessi_close_elm_breadcrumb')) :
    function elessi_close_elm_breadcrumb() {
        echo '</div><!-- End Breadcrumb for Elementor Pro - Header Builder -->';
    }
endif;
