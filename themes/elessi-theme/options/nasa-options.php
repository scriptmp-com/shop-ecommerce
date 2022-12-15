<?php
defined('ABSPATH') || exit;

/* RTL Mode */
define('NASA_RTL', apply_filters('nasa_rtl_mode', (function_exists('is_rtl') && is_rtl())));

/* Check if WooCommerce active */
defined('NASA_WOO_ACTIVED') or define('NASA_WOO_ACTIVED', (bool) function_exists('WC'));

/* Check if Elementor active */
defined('NASA_ELEMENTOR_ACTIVE') or define('NASA_ELEMENTOR_ACTIVE', defined('ELEMENTOR_PATH') && ELEMENTOR_PATH);

/**
 * Check Header, Footers Builder support
 */
defined('NASA_HF_BUILDER') or define('NASA_HF_BUILDER', NASA_ELEMENTOR_ACTIVE && function_exists('hfe_init'));

/* Check if DOKAN active */
defined('NASA_DOKAN_ACTIVED') or define('NASA_DOKAN_ACTIVED', (bool) function_exists('dokan'));

defined('NASA_WISHLIST_ENABLE') or define('NASA_WISHLIST_ENABLE', (bool) defined('YITH_WCWL'));

$wishlist_loop = NASA_WISHLIST_ENABLE ? true : false;
$wishlist_new = false;
if (NASA_WISHLIST_ENABLE && defined('YITH_WCWL_VERSION')) {
    if (version_compare(YITH_WCWL_VERSION, '3.0', ">=")) {
        $wishlist_loop = get_option('yith_wcwl_show_on_loop') !== 'yes' ? false : true;
        $wishlist_new = true;
    }
}
define('NASA_WISHLIST_NEW_VER', $wishlist_new);
define('NASA_WISHLIST_IN_LIST', $wishlist_loop);

/* Check if nasa-core is active */
defined('NASA_CORE_ACTIVED') or define('NASA_CORE_ACTIVED', function_exists('nasa_setup'));
defined('NASA_CORE_IN_ADMIN') or define('NASA_CORE_IN_ADMIN', is_admin());

/* user info */
defined('NASA_CORE_USER_LOGGED') or define('NASA_CORE_USER_LOGGED', is_user_logged_in());

/* bundle type product */
defined('NASA_COMBO_TYPE') or define('NASA_COMBO_TYPE', 'yith_bundle');

/* Nasa theme prefix use for nasa-core */
defined('NASA_THEME_PREFIX') or define('NASA_THEME_PREFIX', 'elessi');

/* Time now */
defined('NASA_TIME_NOW') or define('NASA_TIME_NOW', time());

/**
 * $nasa_loadmore_style 
 */
$GLOBALS['nasa_loadmore_style'] = array('infinite', 'load-more');

/**
 * Cache plugin support
 */
function elessi_plugins_cache_support() {
    /**
     * Check WP Super Cache
     */
    global $super_cache_enabled;
    $super_cache_enabled = isset($super_cache_enabled) ? $super_cache_enabled : false;
    
    $plugin_cache_support = (
        /**
         * Check WP_ROCKET
         */
        (defined('WP_ROCKET_SLUG') && WP_ROCKET_SLUG) ||
        
        /**
         * Check W3 Total Cache
         */
        (defined('W3TC') && W3TC) ||
            
        /**
         * Check WP Fastest Cache
         */
        class_exists('WpFastestCache') ||
            
        /**
         * Check WP Super Cache
         */
        (defined('WP_CACHE') && WP_CACHE && $super_cache_enabled) ||
        
        /**
         * Check SG_CachePress
         */
        class_exists('SG_CachePress') ||
        
        /**
         * Check LiteSpeed Cache
         */
        class_exists('LiteSpeed_Cache') ||
            
        /**
         * Check WP Optimize Cache
         */
        class_exists('WP_Optimize') ||

        /**
         * Check AutoptimizeCache
         */
        class_exists('autoptimizeCache')
    );
    
    return apply_filters('elessi_plugins_cache_support', $plugin_cache_support);
}

/**
 * init Theme Options - $nasa_opt
 */
add_action('nasa_set_options', 'elessi_get_options');
function elessi_get_options() {
    $options = get_theme_mods();
    
    if (!empty($options)) {
        foreach ($options as $key => $value) {
            if (is_string($value)) {
                $options[$key] = str_replace(
                    array(
                        '[site_url]', 
                        '[site_url_secure]',
                    ),
                    array(
                        site_url('', 'http'),
                        site_url('', 'https'),
                    ),
                    $value
                );
            }
        }
    }
    
    /**
     * Check Mobile Detect
     */
    $options['nasa_in_mobile'] = false;
    if (defined('NASA_IS_PHONE') && NASA_IS_PHONE && (!isset($options['enable_nasa_mobile']) || $options['enable_nasa_mobile'])) {
        /**
         * Option detect Mobile device
         */
        $options['nasa_in_mobile'] = true;
        
        /**
         * Force Disable Showing info top
         */
        $options['showing_info_top'] = false;
        
        /**
         * Force Disable Changeview
         */
        $options['enable_change_view'] = false;
        
        /**
         * Force breadcrumb single row
         */
        $options['breadcrumb_row'] = 'single';
        
        /**
         * Single Product Page
         */
        if (isset($options['mobile_layout']) && $options['mobile_layout'] == 'app') {
            $options['product_detail_layout'] = 'classic';
            $options['tab_style_info'] = 'small-accordion';
            $options['product_slide_arrows'] = 1;
            $options['product_slide_dot'] = 0;
            $options['mobile_fixed_add_to_cart'] = 'no';
        }
    }
    
    /**
     * Not support Optimize html when de-active Nasa Core
     */
    if (!NASA_CORE_ACTIVED) {
        $options['tmpl_html'] = false;
    }
    
    /**
     * Compatible AliDropship Woo
     */
    if (defined('ADSW_URL')) {
        $options['enable_nasa_variations_ux'] = apply_filters('nasa_use_adsw_attrs_ux', false); // Use swatches of AliDropship Woo
    }
    
    /**
     * Check Cache plugin active
     */
    if (!defined('NASA_PLG_CACHE_ACTIVE') && elessi_plugins_cache_support()) {
        define('NASA_PLG_CACHE_ACTIVE', true);
    }
    
    if (defined('NASA_PLG_CACHE_ACTIVE') && NASA_PLG_CACHE_ACTIVE) {
        /**
         * Disable optimized speed
         */
        $options['enable_optimized_speed'] = '0';
    }
    
    $GLOBALS['nasa_opt'] = apply_filters('nasa_theme_options', $options);
}

/**
 * Define NASA_CHECKOUT_LAYOUT ['modern', 'default']
 */
add_action('nasa_set_options', 'elessi_checkout_layout_conts');
function elessi_checkout_layout_conts() {
    global $nasa_opt;
    
    if (!defined('NASA_CHECKOUT_LAYOUT')) {
        $checkout_layout = isset($nasa_opt['checkout_layout']) && $nasa_opt['checkout_layout'] ?
        $nasa_opt['checkout_layout'] : 'default';

        define('NASA_CHECKOUT_LAYOUT', $checkout_layout);
    }
}

/**
 * @param $str
 * @return mixed
 */
function elessi_remove_protocol($str = null) {
    return $str ? apply_filters('nasa_remove_protocol', str_replace(array('https://', 'http://'), '//', $str)) : $str;
}

/**
 * Prefix theme name
 */
function elessi_prefix_theme() {
    global $nasa_prefix_theme;
    
    if (!isset($nasa_prefix_theme)) {
        global $nasa_opt;
        
        $prefix = 'elessi';

        if (isset($nasa_opt['white_lbl']) && $nasa_opt['white_lbl']) {
            $prefix = isset($nasa_opt['white_lbl_name']) && $nasa_opt['white_lbl_name'] ? strtolower(str_replace(' ', '-', $nasa_opt['white_lbl_name'])) : 'theme';
        }

        $nasa_prefix_theme = apply_filters('nasa_prefix_theme', $prefix);
        
        $GLOBALS['nasa_prefix_theme'] = $nasa_prefix_theme;
    }
    
    return $nasa_prefix_theme;
}

/**
 * Convert css content
 * 
 * @param type $css
 * @return type
 */
function elessi_convert_css($css) {
    $css = strip_tags($css);
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
    $css = str_replace(': ', ':', $css);
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

    return $css;
}
/**
 * Darken - Lighten color hex
 * 
 * @param type $hex
 * @param type $percent
 * @return type
 */
function elessi_pattern_color($hex, $percent) {
    $hash = '';
    
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    
    // HEX TO RGB
    $rgb = array(
        hexdec(substr($hex, 0, 2)),
        hexdec(substr($hex, 2, 2)),
        hexdec(substr($hex, 4, 2))
    );
    
    // CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // Lighter
        if ($percent > 0) {
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        }
        
        // Darker
        else {
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * (1 - $positivePercent));
        }
        
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    
    // RBG to Hex
    $hex_new = '';
    
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        
        // Append to the hex string
        $hex_new .= $hexDigit;
    }
    
    return $hash . $hex_new;
}

/**
 * wp-admin loading
 */
if (NASA_CORE_IN_ADMIN){
    /**
     *
     * @global type $GLOBALS['nasa_opt']
     * @name $nasa_opt 
     */
    if (!did_action('nasa_set_options')) {
        do_action('nasa_set_options');
    }
    
    require ELESSI_THEME_PATH . '/admin/theme-admin.php';
}

/**
 * Main Style and RTL Style
 */
add_action('wp_enqueue_scripts', 'elessi_enqueue_style', 998);
function elessi_enqueue_style() {
    global $nasa_opt;
    
    $prefix = elessi_prefix_theme();
    
    $themeVersion = isset($nasa_opt['css_theme_version']) && $nasa_opt['css_theme_version'] ? NASA_VERSION : null;
    
    $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    
    /**
     * MAIN CSS
     */
    wp_enqueue_style($prefix . '-style', get_stylesheet_uri());
    
    /**
     * CSS ELEMENTOR
     */
    if (NASA_ELEMENTOR_ACTIVE) {
        
        /**
         * Disable Animate - Elementor
         */
        wp_deregister_style('e-animations');
        wp_dequeue_style('e-animations');
        
        wp_enqueue_style($prefix . '-style-elementor', ELESSI_THEME_URI . '/style-elementor.css', array(), $themeVersion);
        
        if ((isset($_REQUEST['elementor-preview']) && $_REQUEST['elementor-preview']) || (isset($_REQUEST['preview_id']) && $_REQUEST['preview_id'])) {
            if ($inMobile) {
                wp_enqueue_style($prefix . '-style-large', ELESSI_THEME_URI . '/assets/css/style-large.css', array(), $themeVersion);
            }
            
            wp_enqueue_style($prefix . '-style-elementor-preview', ELESSI_THEME_URI . '/assets/css/style-elementor-preview.css', array(), $themeVersion);
        }
    }
    
    if (!isset($nasa_opt['transition_load']) || $nasa_opt['transition_load'] == 'wow') {
        /**
         * CSS Animate
         */
        wp_enqueue_style('e-animations', ELESSI_THEME_URI . '/assets/css/animate.min.css', array(), $themeVersion);
    }
    
    if (isset($nasa_opt['transition_load']) && $nasa_opt['transition_load'] == 'crazy') {
        /**
         * CSS Crazy Load
         */
        wp_enqueue_style($prefix . '-style-crazy', ELESSI_THEME_URI . '/assets/css/style-crazy-load.css', array(), $themeVersion);
    }
    
    /**
     * Style Large
     */
    if (!$inMobile) {
        wp_enqueue_style($prefix . '-style-large', ELESSI_THEME_URI . '/assets/css/style-large.css', array(), $themeVersion);
    }
    
    /**
     * Style Mobile
     */
    else {
        wp_enqueue_style($prefix . '-style-mobile', ELESSI_THEME_URI . '/assets/css/style-mobile.css', array(), $themeVersion);
    }
    
    /**
     * RTL CSS
     */
    if (NASA_RTL) {
        wp_enqueue_style($prefix . '-style-rtl', ELESSI_THEME_URI . '/style-rtl.css', array(), $themeVersion);
    }
    
    /**
     * WPBakery Frontend Editor
     */
    if (isset($_REQUEST['vc_editable']) && 'true' == $_REQUEST['vc_editable']) {
        wp_enqueue_style($prefix . '-wpbakery-frontend-editor', ELESSI_THEME_URI . '/wpbakery-frontend-editor.css', array(), $themeVersion);
    }
    
    /**
     * Compatible with Yith WC Product Bundle plugin
     */
    if (defined('YITH_WCPB')) {
        wp_enqueue_style($prefix . '-style-yith_bundle', ELESSI_THEME_URI . '/assets/plgs3rd/style-yith_bundle.css', array(), $themeVersion);
    }
    
    /**
     * Compatible with Yith WC Product Add Ons
     */
    if (defined('YITH_WAPO')) {
        wp_enqueue_style($prefix . '-style-yith-wc-add-ons', ELESSI_THEME_URI . '/assets/plgs3rd/style-yith-wc-add-ons.css', array(), $themeVersion);
    }
    
    /**
     * Posts
     */
    if (elessi_check_blog_page()) {
        wp_enqueue_style($prefix . '-style-posts', ELESSI_THEME_URI . '/assets/css/style-posts.css', array(), $themeVersion);
    }
    
    /**
     * Store page and not mobile
     */
    if (NASA_WOO_ACTIVED) {
        
        /**
         * Loop Product layout
         */
        if (
            isset($nasa_opt['loop_layout_buttons']) &&
            $nasa_opt['loop_layout_buttons'] != 'ver-buttons'
        ) {
            wp_enqueue_style($prefix . '-loop-product', ELESSI_THEME_URI . '/assets/css/style-loop-product-' . $nasa_opt['loop_layout_buttons'] . '.css', array(), $themeVersion);
        }
        
        /**
         * Dokan
         */
        if (NASA_DOKAN_ACTIVED) {
            wp_enqueue_style($prefix . '-style-dokan-store', ELESSI_THEME_URI . '/assets/css/style-dokan-store.css', array(), $themeVersion);
        }
        
        /**
         * Enqueue store CSS
         */
        if (is_shop() || is_product_taxonomy()) {
            if (!$inMobile) {
                wp_enqueue_style($prefix . '-style-products-list', ELESSI_THEME_URI . '/assets/css/style-products-list.css', array(), $themeVersion);
            }
            
            wp_enqueue_style($prefix . '-style-archive-products', ELESSI_THEME_URI . '/assets/css/style-archive-products.css', array(), $themeVersion);
        }
        
        /**
         * Enqueue Single Product CSS
         */
        if (is_product()) {
            wp_enqueue_style($prefix . '-style-signle-product', ELESSI_THEME_URI . '/assets/css/style-single-product.css', array(), $themeVersion);
            
            /**
             * Mobile Layout
             */
            if ($inMobile && isset($nasa_opt['mobile_layout']) && $nasa_opt['mobile_layout'] == 'app') {
                wp_enqueue_style($prefix . '-style-mobile-app', ELESSI_THEME_URI . '/assets/css/style-mobile-app.css', array(), $themeVersion);
            }
        }
        
        /**
         * Add Css variation ux of AliDropship Woo Plugin
         */
        else {
            if (defined('ADSW_URL') && defined('ADSW_ASSETS_PATH')) {
                if (defined('ADSW_PATH') && is_file(ADSW_PATH . ADSW_ASSETS_PATH . 'css/front/adsw-style.min.css')) {
                    wp_enqueue_style($prefix . '-adsw-vaiation-style', ADSW_URL . ADSW_ASSETS_PATH . 'css/front/adsw-style.min.css', array(), $themeVersion);
                }
            }
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (NASA_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_style($prefix . '-style-woo-pages', ELESSI_THEME_URI . '/assets/css/style-woo-pages.css', array(), $themeVersion);
        }
        
        /**
         * Css Off Canvas
         */
        if (isset($nasa_opt['css_canvas']) && $nasa_opt['css_canvas'] == 'sync') {
            wp_enqueue_style($prefix . '-style-off-canvas', ELESSI_THEME_URI . '/assets/css/style-off-canvas.css', array(), $themeVersion);
        }
        
        /**
         * Compatible with WooCommerce Product Bundle
         */
        if (function_exists('WC_PB')) {
            wp_enqueue_style($prefix . '-style-wc-pb', ELESSI_THEME_URI . '/assets/plgs3rd/wc-product-bundles.css', array(), $themeVersion);
        }
    }
    
    /**
     * Max Font-weight
     */
    if (
        isset($nasa_opt['max_font_weight']) &&
        in_array($nasa_opt['max_font_weight'], array('800', '700', '600' , '500')) &&
        is_file(ELESSI_THEME_PATH . '/assets/css/style-font-weight-' . $nasa_opt['max_font_weight'] . '.css')) {
        wp_enqueue_style($prefix . '-style-font-weight', ELESSI_THEME_URI . '/assets/css/style-font-weight-' . $nasa_opt['max_font_weight'] . '.css', array(), $themeVersion);
    }
}

/**
 * Preload Fonts Icons
 */
add_action('wp_head', 'elessi_preload_fonts_icon', 2);
function elessi_preload_fonts_icon() {
    global $nasa_opt;
    
    if (isset($nasa_opt['preload_font_icons']) && !$nasa_opt['preload_font_icons']) {
        return;
    }
    
    $href = elessi_remove_protocol(ELESSI_THEME_URI . '/assets');
    if (!isset($nasa_opt['minify_font_icons']) || $nasa_opt['minify_font_icons']) {
        $href .= '/minify-font-icons';
    }
    
    echo '<link rel="preload" href="' . $href . '/font-nasa-icons/nasa-font.woff" as="font" type="font/woff" crossorigin />';
    echo '<link rel="preload" href="' . $href . '/font-pe-icon-7-stroke/Pe-icon-7-stroke.woff" as="font" type="font/woff" crossorigin />';
    echo '<link rel="preload" href="' . $href . '/font-awesome-4.7.0/fontawesome-webfont.woff2" as="font" type="font/woff2" crossorigin />';
    echo '<link rel="preload" href="' . $href . '/font-awesome-4.7.0/fontawesome-webfont.woff" as="font" type="font/woff" crossorigin />';
}

/**
 * Font Nasa Icons
 * Font Awesome
 * Font Pe-icon-7-stroke
 */
add_action('wp_enqueue_scripts', 'elessi_add_fonts_style');
function elessi_add_fonts_style() {
    global $nasa_opt;
    
    $prefix = elessi_prefix_theme();
    
    /**
     * Minify
     * Include: Font Nasa Icons, Font Awesome, Font Pe-icon-7-stroke
     */
    if (!isset($nasa_opt['minify_font_icons']) || $nasa_opt['minify_font_icons']) {
        wp_enqueue_style($prefix . '-fonts-icons', ELESSI_THEME_URI . '/assets/minify-font-icons/fonts.min.css');
    }
    
    /**
     * No Minify
     */
    else {
        /**
         * Add Nasa Font
         */
        wp_enqueue_style($prefix . '-fonts-icons', ELESSI_THEME_URI . '/assets/font-nasa/nasa-font.css');

        /**
         * Add FontAwesome 4.7.0
         */
        wp_enqueue_style($prefix . '-font-awesome', ELESSI_THEME_URI . '/assets/font-awesome-4.7.0/css/font-awesome.min.css');

        /**
         * Add Font Pe7s
         */
        wp_enqueue_style($prefix . '-font-pe7s', ELESSI_THEME_URI . '/assets/font-pe-icon-7-stroke/css/pe-icon-7-stroke.css');
    }

    /**
     * Add Font Awesome 5.15.4
     */
    if ((isset($nasa_opt['include_font_awesome_new']) && $nasa_opt['include_font_awesome_new']) || function_exists('dokan')) {
        wp_enqueue_style($prefix . '-font-awesome-5-free', ELESSI_THEME_URI . '/assets/font-awesome-5.15.4/font-awesome.min.css');
    }
}

/**
 * Params variations
 */
function elessi_params_variations() {
    return array(
        'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
        'i18n_no_matching_variations_text' => esc_attr__('Sorry, no products matched your selection. Please choose a different combination.', 'elessi-theme'),
        'i18n_make_a_selection_text' => esc_attr__('Please select some product options before adding this product to your cart.', 'elessi-theme'),
        'i18n_unavailable_text' => esc_attr__('Sorry, this product is unavailable. Please choose a different combination.', 'elessi-theme')
    );
}

/**
 * enqueue scripts
 */
add_action('wp_enqueue_scripts', 'elessi_enqueue_scripts', 998);
function elessi_enqueue_scripts() {
    global $nasa_opt;
    
    $prefix = elessi_prefix_theme();
    
    $themeVersion = isset($nasa_opt['js_theme_version']) && $nasa_opt['js_theme_version'] ? NASA_VERSION : null;
    
    $inMobile = isset($nasa_opt['nasa_in_mobile']) && $nasa_opt['nasa_in_mobile'] ? true : false;
    
    wp_enqueue_script('jquery-cookie', ELESSI_THEME_URI . '/assets/js/min/jquery.cookie.min.js', array('jquery'), $themeVersion, true);
    
    /**
     * magnific popup
     */
    if (!wp_script_is('jquery-magnific-popup')) {
        wp_enqueue_script('jquery-magnific-popup', ELESSI_THEME_URI . '/assets/js/min/jquery.magnific-popup.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Wow js
     */
    if (!isset($nasa_opt['transition_load']) || $nasa_opt['transition_load'] == 'wow') {
        wp_enqueue_script('wow', ELESSI_THEME_URI . '/assets/js/min/wow.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Live search Products
     */
    $enable_live_search = isset($nasa_opt['enable_live_search']) ? $nasa_opt['enable_live_search'] : true;
    if ($enable_live_search && NASA_WOO_ACTIVED) {
        wp_enqueue_script('nasa-typeahead', ELESSI_THEME_URI . '/assets/js/min/typeahead.bundle.min.js', array('jquery'), $themeVersion, true);
        wp_enqueue_script('nasa-handlebars', ELESSI_THEME_URI . '/assets/js/min/handlebars.min.js', array('jquery'), $themeVersion, true);
        
        $search_options = array(
            'template' =>
                '<div class="item-search">' .
                    '<a href="{{url}}" class="nasa-link-item-search" title="{{title}}">' .
                        '{{{image}}}' .
                        '<div class="nasa-item-title-search rtl-right rtl-text-right">' .
                            '<p class="nasa-title-item">{{title}}</p>' .
                            '<div class="price text-left rtl-text-right">{{{price}}}</div>' .
                        '</div>' .
                    '</a>' .
                '</div>',
            
            'view_all' => '<div class="hidden-tag nasa-search-all-wrap"><a href="javascript:void(0);" class="nasa-search-all button">' . esc_html__('View All', 'elessi-theme') . '</a></div>',
            
            'empty_result' => esc_html__('Sorry. No results match your search.', 'elessi-theme'),
            
            'limit' => (isset($nasa_opt['limit_results_search']) && (int) $nasa_opt['limit_results_search'] > 0) ? (int) $nasa_opt['limit_results_search'] : 5,
            
            'url' => apply_filters('nasa_live_search_url', WC_AJAX::get_endpoint('nasa_search_products'))
        );

        $search_js_inline = 'var search_options=' . json_encode($search_options) . ';';
        wp_add_inline_script('nasa-typeahead', $search_js_inline, 'before');
    }
    
    /**
     * Theme js
     */
    wp_enqueue_script($prefix . '-functions-js', ELESSI_THEME_URI . '/assets/js/min/functions.min.js', array('jquery'), $themeVersion, true);
    wp_enqueue_script($prefix . '-js', ELESSI_THEME_URI . '/assets/js/min/main.min.js', array('jquery'), $themeVersion, true);
    
    if (!$inMobile) {
        wp_enqueue_script($prefix . '-js-large', ELESSI_THEME_URI . '/assets/js/min/js-large.min.js', array('jquery'), $themeVersion, true);
    }
    
    /**
     * Define ajax options
     */
    if (!defined('NASA_AJAX_OPTIONS')) {
        define('NASA_AJAX_OPTIONS', true);
        
        $ajax_params_options = array(
            'ajax_url' => esc_url(admin_url('admin-ajax.php'))
        );

        if (NASA_WOO_ACTIVED) {
            $ajax_params_options['wc_ajax_url'] = WC_AJAX::get_endpoint('%%endpoint%%');
        }
        
        $ajax_params = 'var nasa_ajax_params=' . json_encode($ajax_params_options) . ';';
        wp_add_inline_script($prefix . '-functions-js', $ajax_params, 'before');
    }
    
    /**
     * Enqueue store ajax, single product js, quickview
     */
    if (NASA_WOO_ACTIVED) {
        /**
         * For Quick view Product
         */
        if ((!isset($nasa_opt['disable-quickview']) || !$nasa_opt['disable-quickview'])) {
            
            wp_enqueue_script('wc-add-to-cart-variation');
            
            wp_enqueue_script('nasa-quickview', ELESSI_THEME_URI . '/assets/js/min/nasa-quickview.min.js', array('jquery'), $themeVersion, true);

            wp_add_inline_script('nasa-quickview', 'var nasa_params_quickview=' . json_encode(elessi_params_variations()) . ';', 'before');
            
            if (defined('ADSW_URL')) {
                wp_enqueue_script('nasa-quickview-sp-adsw', ELESSI_THEME_URI . '/assets/js/min/nasa-quickview-sp-adsw.min.js', array('jquery'), $themeVersion, true);
            }
        }
        
        /**
         * Shopping Cart - Checkout - Thank you pages
         */
        if (is_checkout() || is_cart() || (NASA_CORE_USER_LOGGED && is_account_page())) {
            wp_enqueue_script('nasa-woo-pages', ELESSI_THEME_URI . '/assets/js/min/woo-pages.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue store ajax js
         */
        if (is_shop() || is_product_taxonomy()) {
            wp_enqueue_script($prefix . '-store-ajax', ELESSI_THEME_URI . '/assets/js/min/store-ajax.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue Easy zoom js - single product js
         */
        if (is_product()) {
            if (!$inMobile) {
                wp_enqueue_script('jquery-easyzoom', ELESSI_THEME_URI . '/assets/js/min/jquery.easyzoom.min.js', array('jquery'), $themeVersion, true);
            }
            
            wp_enqueue_script($prefix . '-single-product', ELESSI_THEME_URI . '/assets/js/min/single-product.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue confetti js - for cart sidebar for advance free shipping js
         */
        if (class_exists('WooCommerce_Advanced_Free_Shipping') && isset($nasa_opt['free_shipping_effect']) && $nasa_opt['free_shipping_effect']) {
            wp_enqueue_script('jquery-confetti', ELESSI_THEME_URI . '/assets/js/min/jquery.confetti.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Enqueue sp multi currencies js
         * 
         * Plugin: WOOCS - WooCommerce Currency Switcher
         * Plugin: CURCY - Multi Currency for WooCommerce
         */
        if (
            (isset($nasa_opt['switch_currency']) && $nasa_opt['switch_currency']) &&
            (class_exists('WOOCS') || class_exists('WOOMULTI_CURRENCY_F'))
        ) {
            wp_enqueue_script($prefix . '-sp-multi-currencies', ELESSI_THEME_URI . '/assets/js/min/sp-multi-currencies.min.js', array('jquery'), $themeVersion, true);
        }
        
        /**
         * Extra Mini Cart
         */
        $mini_cart_note = isset($nasa_opt['mini_cart_note']) && $nasa_opt['mini_cart_note'] ? true : false;
        $mini_cart_shipping = isset($nasa_opt['mini_cart_shipping']) && $nasa_opt['mini_cart_shipping'] ? true : false;
        $mini_cart_coupon = isset($nasa_opt['mini_cart_coupon']) && $nasa_opt['mini_cart_coupon'] ? true : false;
        if ($mini_cart_note || $mini_cart_shipping || $mini_cart_coupon) {
            wp_enqueue_style('select2');
            wp_enqueue_script('selectWoo');
            wp_enqueue_script('wc-country-select');

            wp_enqueue_script($prefix . '-ext-mini-cart', ELESSI_THEME_URI . '/assets/js/min/ext-mini-cart.min.js', array('jquery'), $themeVersion, true);

            $ext_minicart_params = array(
                'ajax_url' => esc_url(admin_url('admin-ajax.php')),
                'wc_ajax_url' => WC_AJAX::get_endpoint('%%endpoint%%'),
                // 'update_shipping_method_nonce' => wp_create_nonce('update-shipping-method'),
                // 'apply_coupon_nonce' => wp_create_nonce('apply-coupon'),
                // 'remove_coupon_nonce' => wp_create_nonce('remove-coupon')
            );

            $ajax_params = 'var ext_mini_cart_params=' . json_encode($ext_minicart_params) . ';';
            wp_add_inline_script($prefix . '-ext-mini-cart', $ajax_params, 'before');
        }
    }
    
    /**
     * Add css comment reply
     */
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    
    /**
     * Dokan
     */
    if (NASA_DOKAN_ACTIVED) {
        if (!NASA_CORE_USER_LOGGED) {
            dokan()->scripts->load_form_validate_script();
            wp_enqueue_script('dokan-form-validate');
        }
        
        wp_enqueue_script($prefix . '-dokan-store', ELESSI_THEME_URI . '/assets/js/min/dokan-store.min.js', array('jquery'), $themeVersion, true);
    }
}

/**
 * Dequeue scripts and styles
 */
add_action('wp_enqueue_scripts', 'elessi_dequeue_scripts', 9999);
function elessi_dequeue_scripts() {
    global $nasa_opt;
    
    /**
     * Dequeue vc_woocommerce-add-to-cart
     */
    if (class_exists('Vc_Manager')) {
        wp_deregister_script('vc_woocommerce-add-to-cart-js');
        wp_dequeue_script('vc_woocommerce-add-to-cart-js');
    }
    
    /**
     * Dequeue contact-form-7 css
     */
    if (function_exists('wpcf7_style_is') && wpcf7_style_is()) {
        wp_dequeue_style('contact-form-7');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Compare colorbox css
     */
    if (class_exists('YITH_Woocompare_Frontend') && (!isset($nasa_opt['nasa-product-compare']) || $nasa_opt['nasa-product-compare'])) {
        wp_dequeue_style('jquery-colorbox');
        wp_dequeue_script('jquery-colorbox');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Wishlist css
     */
    if (NASA_WISHLIST_ENABLE && !defined('YITH_WCWL_PREMIUM')) {
        wp_deregister_style('jquery-selectBox');
        wp_deregister_style('yith-wcwl-font-awesome');
        wp_deregister_style('yith-wcwl-font-awesome-ie7');
        wp_deregister_style('yith-wcwl-main');
    }
    
    /**
     * Dequeue YITH WooCommerce Product Bundles css
     */
    if (defined('YITH_WCPB')) {
        wp_deregister_style('yith_wcpb_bundle_frontend_style');
    }
    
    /**
     * WPC Product Bundles for WooCommerce Plugin
     */
    if (function_exists('WPCleverWoosb') && NASA_WOO_ACTIVED && !is_product()) {
        wp_deregister_style('woosb-frontend');
        wp_deregister_script('woosb-frontend');
    }
    
    /**
     * Dokan fontawesome
     */
    if (function_exists('dokan')) {
        wp_deregister_style('dokan-fontawesome');
        wp_dequeue_style('dokan-fontawesome');
    }
    
    /**
     * Dequeue Css files from NasaTheme Options
     */
    if (!NASA_CORE_IN_ADMIN && !empty($nasa_opt['css_files'])) {
        foreach ($nasa_opt['css_files'] as $handle => $val) {
            if ($val != 1) {
                continue;
            }
            
            if (in_array($handle, array('nasa-e-fontawesome'))) {
                continue;
            }
            
            /**
             * Continue if Css Preview Elementor
             */
            if (
                isset($_REQUEST['elementor-preview']) &&
                $_REQUEST['elementor-preview'] &&
                in_array($handle, array('elementor-icons'))
            ) {
                continue;
            }
            
            /**
             * Continue if Css Preview WPBakery
             */
            if (
                isset($_REQUEST['vc_editable']) &&
                $_REQUEST['vc_editable'] == 'true' &&
                in_array($handle, array('js_composer_front', 'vc_animate-css'))
            ) {
                continue;
            }
            
            /**
             * Deregister and Dequeue CSS file
             */
            wp_deregister_style($handle);
            wp_dequeue_style($handle);
        }
    }
}

/**
 * Remove Default WooCommerce Styles
 */
if (NASA_WOO_ACTIVED && !NASA_CORE_IN_ADMIN) {
    add_filter('woocommerce_enqueue_styles', 'elessi_remove_default_woo_styles');
    function elessi_remove_default_woo_styles($styles) {
        return array();
    }
}


/**
 * List CSS files Call
 * @return type
 */
function elessi_get_list_css_files_call() {
    /**
     * Default
     */
    $list_css = array(
        'wp-block-library' => '/wp-includes/css/dist/block-library/style.min.css'
    );

    /**
     * WooCommerce - Plugin
     */
    if (NASA_WOO_ACTIVED) {
        $list_css['wc-blocks-vendors-style'] = '/wp-content/plugins/woocommerce/packages/woocommerce-blocks/build/wc-blocks-vendors-style.css';
        $list_css['wc-blocks-style'] = '/wp-content/plugins/woocommerce/packages/woocommerce-blocks/build/wc-blocks-style.css';
    }

    /**
     * Elementor - Plugin
     */
    if (NASA_ELEMENTOR_ACTIVE) {
        $list_css['e-animations'] = '/wp-content/plugins/elementor/assets/lib/animations/animations.min.css';
        $list_css['elementor-icons'] = '/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css';
        $list_css['nasa-e-fontawesome'] = '/wp-content/plugins/elementor/assets/lib/font-awesome/css/...css - Elementor FontAwesome';
    }

    /**
     * WPBakery - Plugin
     */
    if (class_exists('Vc_Manager')) {
        $list_css['js_composer_front'] = '/wp-content/plugins/js_composer/assets/css/js_composer.min.css';
        $list_css['vc_animate-css'] = '/wp-content/plugins/js_composer/assets/lib/bower/animate-css/animate.min.css';
    }

    /**
     * Back In Stock Notifier for WooCommerce - Plugin
     */
    if (class_exists('CWG_Instock_Notifier')) {
        $list_css['cwginstock_frontend_css'] = '/wp-content/plugins/back-in-stock-notifier-for-woocommerce/assets/css/frontend.min.css';
        $list_css['cwginstock_bootstrap'] = '/wp-content/plugins/back-in-stock-notifier-for-woocommerce/assets/css/bootstrap.min.css';
    }
    
    return apply_filters('nasa_list_files_css_called', $list_css);
}

/**
 * List JS files Delay
 * @return type
 */
function elessi_get_list_js_files_delay() {
    $list_js = array(
        'wow' => '/wp-content/themes/../assets/js/min/wow.min.js',
        'nasa-quickview' => '/wp-content/themes/../assets/js/min/nasa-quickview.min.js',
        'nasa-typeahead' => '/wp-content/themes/../assets/js/min/typeahead.bundle.min.js',
        'nasa-handlebars' => '/wp-content/themes/../assets/js/min/handlebars.min.js'
    );

    /**
     * Back In Stock Notifier for WooCommerce - Plugin
     */
    if (class_exists('CWG_Instock_Notifier')) {
        $list_js['cwginstock_js'] = '/wp-content/plugins/back-in-stock-notifier-for-woocommerce/assets/js/frontend-dev.min.js';
        $list_js['sweetalert2'] = '/wp-content/plugins/back-in-stock-notifier-for-woocommerce/assets/js/sweetalert2.min.js';
        $list_js['cwginstock_popup'] = '/wp-content/plugins/back-in-stock-notifier-for-woocommerce/assets/js/cwg-popup.js';
    }
    
    /**
     * WPC Product Bundles for WooCommerce - Plugin
     */
    if (function_exists('yith_woocompare_constructor')) {
        $list_js['yith-woocompare-main'] = '/wp-content/plugins/yith-woocommerce-compare/assets/js/woocompare.min.js';
    }
    
    return apply_filters('nasa_list_files_js_delay', $list_js);
}

/**
 * Disable Fontawsome - Elementor
 */
if (NASA_ELEMENTOR_ACTIVE) {
    add_action('elementor/frontend/after_register_styles', function() {
        global $nasa_opt;
        
        if (isset($nasa_opt['css_files']) && isset($nasa_opt['css_files']['nasa-e-fontawesome']) && $nasa_opt['css_files']['nasa-e-fontawesome'] == 1) {
            foreach (array('solid', 'regular', 'brands') as $style) {
                wp_deregister_style('elementor-icons-fa-' . $style);
            }
        }
    }, 20);
}

/**
 * Default Widgets Area
 */
add_action('widgets_init', 'elessi_widgets_sidebars_init');
function elessi_widgets_sidebars_init() {
    global $nasa_opt;
    
    // Sidebar - Blog
    register_sidebar(array(
        'name' => esc_html__('Blog Sidebar', 'elessi-theme'),
        'id' => 'blog-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar - Shop
    register_sidebar(array(
        'name' => esc_html__('Shop Sidebar', 'elessi-theme'),
        'id' => 'shop-sidebar',
        'before_widget' => '<div id="%1$s" class="widget nasa-widget-store %2$s">',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
        'after_widget'  => '</div>'
    ));
    
    // Sidebar Single Product
    register_sidebar(array(
        'name' => esc_html__('Product Sidebar', 'elessi-theme'),
        'id' => 'product-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'before_title'  => '<span class="widget-title">',
        'after_title'   => '</span>',
        'after_widget'  => '</div>'
    ));
    
    /**
     * Footer Widgets for Elementor
     */
    if (NASA_ELEMENTOR_ACTIVE && (!isset($nasa_opt['f_buildin']) || $nasa_opt['f_buildin'])) {
        // Footer Light 1
        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.1 )', 'elessi-theme'),
            'id' => 'footer-light-1-1',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.2 )', 'elessi-theme'),
            'id' => 'footer-light-1-2',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.3 )', 'elessi-theme'),
            'id' => 'footer-light-1-3',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.4 )', 'elessi-theme'),
            'id' => 'footer-light-1-4',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.5 )', 'elessi-theme'),
            'id' => 'footer-light-1-5',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 1 ( No.6 )', 'elessi-theme'),
            'id' => 'footer-light-1-6',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        // Footer Light 2
        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.1 )', 'elessi-theme'),
            'id' => 'footer-light-2-1',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.2 )', 'elessi-theme'),
            'id' => 'footer-light-2-2',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.3 )', 'elessi-theme'),
            'id' => 'footer-light-2-3',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.4 )', 'elessi-theme'),
            'id' => 'footer-light-2-4',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.5 )', 'elessi-theme'),
            'id' => 'footer-light-2-5',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.6 )', 'elessi-theme'),
            'id' => 'footer-light-2-6',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 2 ( No.7 )', 'elessi-theme'),
            'id' => 'footer-light-2-7',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        // Footer Light 3
        register_sidebar(array(
            'name' => esc_html__('Footer Light 3 ( No.1 )', 'elessi-theme'),
            'id' => 'footer-light-3-1',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Light 3 ( No.2 )', 'elessi-theme'),
            'id' => 'footer-light-3-2',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        // Footer Dark
        register_sidebar(array(
            'name' => esc_html__('Footer Dark ( No.1 )', 'elessi-theme'),
            'id' => 'footer-dark-1-1',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        register_sidebar(array(
            'name' => esc_html__('Footer Dark ( No.2 )', 'elessi-theme'),
            'id' => 'footer-dark-1-2',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));

        // Footer Mobile
        register_sidebar(array(
            'name' => esc_html__('Footer Mobile', 'elessi-theme'),
            'id' => 'footer-mobile',
            'before_widget' => '',
            'before_title'  => '',
            'after_title'   => '',
            'after_widget'  => ''
        ));
    }
}

/**
 * Compatible with Cartflows Plugin
 */
if (class_exists('Cartflows_Loader')) {
    add_filter('cartflows_is_compatibility_theme', function() {
        return true;
    });
}
