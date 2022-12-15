<?php
add_action('init', 'elessi_product_detail_heading');
if (!function_exists('elessi_product_detail_heading')) {
    function elessi_product_detail_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Page", 'elessi-theme'),
            "target" => 'product-detail',
            "type" => "heading",
        );
        
        $of_options[] = array(
            "name" => esc_html__("Ajax Load", 'elessi-theme'),
            "id" => "single_product_ajax",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Product Sidebar Position", 'elessi-theme'),
            "id" => "product_sidebar",
            "std" => "left",
            "type" => "select",
            "options" => array(
                "left" => esc_html__("Left Sidebar", 'elessi-theme'),
                "right" => esc_html__("Right Sidebar", 'elessi-theme'),
                "no" => esc_html__("No Sidebar", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Single Product Layout", 'elessi-theme'),
            "id" => "product_detail_layout",
            "std" => "new",
            "type" => "images",
            "options" => array(
                'classic'   => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-classic.jpg',
                'new'       => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-new.jpg',
                'new-2'     => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-new-2.jpg',
                'full'      => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-fullwidth.jpg',
                'modern-1'  => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-modern-1.jpg',
                'modern-2'  => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-modern-2.jpg',
                'modern-3'  => ELESSI_ADMIN_DIR_URI . 'assets/images/single-product-modern-3.jpg',
            ),
            'class' => 'nasa-theme-option-parent flex-row flex-wrap flex-start img-max-height-100'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Color", 'elessi-theme'),
            "id" => "sp_bgl",
            "std" => "",
            "type" => "color",
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-modern-2 nasa-product_detail_layout-modern-3'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images Columns", 'elessi-theme'),
            "id" => "product_image_layout",
            "std" => "double",
            "type" => "select",
            "options" => array(
                "double" => esc_html__("2 Columns", 'elessi-theme'),
                "single" => esc_html__("1 Column", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-new'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Images Style", 'elessi-theme'),
            "id" => "product_image_style",
            "std" => "slide",
            "type" => "select",
            "options" => array(
                "slide" => esc_html__("Slide Images", 'elessi-theme'),
                "scroll" => esc_html__("Scroll Images", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-new'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Thumbnail Layout", 'elessi-theme'),
            "id" => "product_thumbs_style",
            "std" => "ver",
            "type" => "select",
            "options" => array(
                "ver" => esc_html__("Vertical", 'elessi-theme'),
                "hoz" => esc_html__("Horizontal", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-classic'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Overflows: + 0.5 items", 'elessi-theme'),
            "id" => "half_full_slide",
            "std" => "0",
            "type" => "switch",
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-full',
            'desc' => '<span class="red-color">' . esc_html__('Note: The Hover Zoom Image Will be Turned Off!!!', 'elessi-theme') . '</span>'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Infomations Columns", 'elessi-theme'),
            "id" => "full_info_col",
            "std" => "1",
            "type" => "select",
            "options" => array(
                "1" => esc_html__("1 Column", 'elessi-theme'),
                "2" => esc_html__("2 Columns", 'elessi-theme')
            ),
            'override_numberic' => true,
            'class' => 'nasa-theme-option-child nasa-product_detail_layout nasa-product_detail_layout-full'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Dots for Main Slide", 'elessi-theme'),
            "id" => "product_slide_dot",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Arrows for Main Slide", 'elessi-theme'),
            "id" => "product_slide_arrows",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hover Zoom Image", 'elessi-theme'),
            "id" => "product-zoom",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Lightbox Image When click", 'elessi-theme'),
            "id" => "product-image-lightbox",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Focus Main Image", 'elessi-theme'),
            "id" => "enable_focus_main_image",
            "desc" => esc_html__("Focus main image after active variation product", 'elessi-theme'),
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Deal Time in Single or Quickview", 'elessi-theme'),
            "id" => "single-product-deal",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now", 'elessi-theme'),
            "id" => "enable_buy_now",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color", 'elessi-theme'),
            "id" => "buy_now_bg_color",
            "std" => "",
            "type" => "color"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Buy Now Background Color Hover", 'elessi-theme'),
            "id" => "buy_now_bg_color_hover",
            "std" => "",
            "type" => "color"
        );
        
        // next_prev_product
        $of_options[] = array(
            "name" => esc_html__("Next - Previous Product", 'elessi-theme'),
            "id" => "next_prev_product",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart", 'elessi-theme'),
            "id" => "enable_fixed_add_to_cart",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Buy Now - Desktop", 'elessi-theme'),
            "id" => "enable_fixed_buy_now_desktop",
            "std" => "0",
            "type" => "switch"
        );
        
        $options = array(
            "no" => esc_html__("Not Show", 'elessi-theme'),
            "ext" => esc_html__("Extends Desktop", 'elessi-theme')
        );
        
        if (class_exists('Nasa_Mobile_Detect')) {
            $options['btn'] = esc_html__("Only Show Buttons", 'elessi-theme');
        }
        
        $of_options[] = array(
            "name" => esc_html__("Sticky Add To Cart In Mobile", 'elessi-theme'),
            "id" => "mobile_fixed_add_to_cart",
            "std" => "no",
            "type" => "select",
            "options" => $options
        );
        
        $of_options[] = array(
            "name" => esc_html__("Stock Progress Bar", 'elessi-theme'),
            "id" => "enable_progess_stock",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs Layouts", 'elessi-theme'),
            "id" => "tab_style_info",
            "std" => "2d-no-border",
            "type" => "images",
            "options" => array(
                '2d-no-border'      => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-2d-noborder.jpg',
                '2d-radius'         => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-2d-radius.jpg',
                '2d-radius-dashed'  => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-2d-radius-dash.jpg',
                '2d'                => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-2d.jpg',
                '3d'                => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-3d.jpg',
                'slide'             => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-slide.jpg',
                'accordion'         => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-accordion.jpg',
                'accordion-2'       => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-accordion-2.jpg',
                'small-accordion'   => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-small-accordion.jpg',
                'scroll-down'       => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-scroll-down.jpg',
                'ver-1'             => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-vertical-1.jpg',
                'ver-2'             => ELESSI_ADMIN_DIR_URI . 'assets/images/single-tab-vertical-2.jpg',
            ),
            'class' => 'nasa-theme-option-parent flex-row flex-wrap flex-start img-width-50'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Tabs Align", 'elessi-theme'),
            "id" => "tab_align_info",
            "std" => "center",
            "type" => "select",
            "options" => array(
                "center" => esc_html__("Center", 'elessi-theme'),
                "left" => esc_html__("Left", 'elessi-theme'),
                "right" => esc_html__("Right", 'elessi-theme')
            ),
            'class' => 'nasa-tab_style_info nasa-tab_style_info-2d-no-border nasa-tab_style_info-2d-radius nasa-tab_style_info-2d-radius nasa-tab_style_info-2d-radius-dashed nasa-tab_style_info-2d nasa-tab_style_info-3d nasa-tab_style_info-slide nasa-tab_style_info-scroll-down nasa-tab_style_info-scroll-down nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__('WooCommerce Tabs Off - Canvas in Mobile', 'elessi-theme'),
            "id" => "woo_tabs_off_canvas",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__('Product Description Wrapper - Apply with Tabs Classic', 'elessi-theme'),
            "id" => "desc_product_wrap",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Hide Additional Information Tab", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "hide_additional_tab",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $static_blocks = elessi_admin_get_static_blocks();
        
        $of_options[] = array(
            "name" => esc_html__("Tab Global", 'elessi-theme'),
            "desc" => esc_html__("Please Create Static Block to use.", 'elessi-theme'),
            "id" => "tab_glb",
            "type" => "select",
            "options" => $static_blocks
        );
        
        $of_options[] = array(
            "name" => esc_html__("Allow Comments Images upload", 'elessi-theme'),
            "id" => "comment_media",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max files Comments Images upload", 'elessi-theme'),
            "id" => "maxfiles_comment_media",
            "std" => "3",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Max Size Comments Images upload (kb)", 'elessi-theme'),
            "id" => "maxsize_comment_media",
            "std" => "1024",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__('Relate Products', 'elessi-theme'),
            "id" => "relate_product",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Number for relate products", 'elessi-theme'),
            "id" => "relate_product_number",
            "std" => "12",
            "type" => "text"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Up-sells Products", 'elessi-theme'),
            "id" => "relate_columns_desk",
            "std" => "5-cols",
            "type" => "select",
            "options" => array(
                "6-cols" => esc_html__("6 columns", 'elessi-theme'),
                "5-cols" => esc_html__("5 columns", 'elessi-theme'),
                "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Up-sells Products for Tablet", 'elessi-theme'),
            "id" => "relate_columns_tablet",
            "std" => "3-cols",
            "type" => "select",
            "options" => array(
                "4-cols" => esc_html__("4 columns", 'elessi-theme'),
                "3-cols" => esc_html__("3 columns", 'elessi-theme'),
                "2-cols" => esc_html__("2 columns", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Columns Relate | Up-sells Products for Mobile", 'elessi-theme'),
            "id" => "relate_columns_small",
            "std" => "2-cols",
            "type" => "select",
            "options" => array(
                "2-cols" => esc_html__("2 columns", 'elessi-theme'),
                "1.5-cols" => esc_html__("1,5 column", 'elessi-theme'),
                "1-col" => esc_html__("1 column", 'elessi-theme')
            )
        );
        
        // Enable AJAX add to cart buttons on Detail OR Quickview
        $of_options[] = array(
            "name" => esc_html__("AJAX add to cart button on Single And Quickview", 'elessi-theme'),
            "id" => "enable_ajax_addtocart",
            "std" => "1",
            "type" => "switch",
            "desc" => '<span class="nasa-warning red-color">' . esc_html__('Note: Consider disabling this feature if you are using a third-party plugin developed for the Add to Cart feature in the Single Product Page!', 'elessi-theme') . '</span>'
        );
        
        $of_options[] = array(
            "name" => esc_html__('Mobile Layout', 'elessi-theme'),
            "desc" => esc_html__('Note: Mobile layout for single product pages will hide all widgets and sidebar to increase performance.', 'elessi-theme'),
            "id" => "single_product_mobile",
            "std" => 0,
            "type" => "switch"
        );
    }
}
