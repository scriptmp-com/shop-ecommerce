<?php
add_action('init', 'elessi_general_heading');
if (!function_exists('elessi_general_heading')) {
    function elessi_general_heading() {
        // Set the Options Array
        global $of_options;
        if (empty($of_options)) {
            $of_options = array();
        }
        
        $of_options[] = array(
            "name" => esc_html__("General", 'elessi-theme'),
            "target" => 'general',
            "type" => "heading"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Layout", 'elessi-theme'),
            "id" => "site_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                "wide" => esc_html__("Wide", 'elessi-theme'),
                "boxed" => esc_html__("Boxed", 'elessi-theme')
            ),
            'class' => 'nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Add more width site (px)", 'elessi-theme'),
            "desc" => esc_html__("The max-width of your site will be INPUT + 1200 (pixel).", 'elessi-theme'),
            "id" => "plus_wide_width",
            "std" => "",
            "type" => "text"
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Color - Boxed Layout", 'elessi-theme'),
            "id" => "site_bg_color",
            "std" => "#eee",
            "type" => "color",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );

        $of_options[] = array(
            "name" => esc_html__("Site Background Image - Boxed Layout", 'elessi-theme'),
            "id" => "site_bg_image",
            "std" => ELESSI_THEME_URI . "/assets/images/bkgd1.jpg",
            "type" => "media",
            'class' => 'nasa-site_layout nasa-site_layout-boxed nasa-theme-option-child'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Background Mode", 'elessi-theme'),
            "id" => "site_bg_dark",
            "std" => "",
            "type" => "select",
            "options" => array(
                "" => esc_html__("Light Mode", 'elessi-theme'),
                "1" => esc_html__("Dark Mode", 'elessi-theme'),
                "2" => esc_html__("Gray Mode", 'elessi-theme')
            ),
            'override_numberic' => true
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Login/Register Menu in Topbar", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "hide_tini_menu_acc",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Login/Register by Ajax form", 'elessi-theme'),
            "id" => "login_ajax",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Position Account Icon", 'elessi-theme'),
            "id" => "acc_pos",
            "std" => "top",
            "type" => "select",
            "options" => array(
                "top" => esc_html__("In Topbar - Header", 'elessi-theme'),
                "group" => esc_html__("In Group Icons - Header", 'elessi-theme')
            )
        );
        
        $of_options[] = array(
            "name" => esc_html__("Account On Main Screen - Mobile Layout", 'elessi-theme'),
            "id" => "main_screen_acc_mobile",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Captcha For Register Form", 'elessi-theme'),
            "id" => "register_captcha",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Mobile Menu Layout", 'elessi-theme'),
            "id" => "mobile_menu_layout",
            "std" => "light",
            "type" => "select",
            "options" => array(
                "light" => esc_html__("Light", 'elessi-theme'),
                // "light" => esc_html__("Light - 2", 'elessi-theme'),
                "dark" => esc_html__("Dark", 'elessi-theme')
            ),
        );
        
        $of_options[] = array(
            "name" => esc_html__("Transition Loading", 'elessi-theme'),
            "id" => "transition_load",
            "std" => "wow",
            "type" => "select",
            "options" => array(
                "wow" => esc_html__("Animation Effect", 'elessi-theme'),
                "crazy" => esc_html__("Gray Effect", 'elessi-theme'),
                "none" => esc_html__("None", 'elessi-theme')
            ),
            'class' => 'nasa-transition_load nasa-theme-option-parent'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Delay Overlay (ms)", 'elessi-theme'),
            "id" => "delay_overlay",
            "std" => "100",
            "type" => "text",
            'class' => 'hidden-tag nasa-theme-option-child nasa-transition_load nasa-transition_load-wow nasa-delay_overlay'
        );
        
        $of_options[] = array(
            "name" => esc_html__("Effect Before Load Site", 'elessi-theme'),
            "id" => "effect_before_load",
            "std" => 1,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Toggle Widget Content", 'elessi-theme'),
            "id" => "toggle_widgets",
            "std" => "1",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Wrapper Widget - Sidebar Classic", 'elessi-theme'),
            "id" => "wrapper_widgets",
            "std" => "0",
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include Theme Version when call css files", 'elessi-theme'),
            "id" => "css_theme_version",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Include Theme Version when call js files", 'elessi-theme'),
            "id" => "js_theme_version",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Disable Refill - Contact Form 7", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "disable_wpcf7_refill",
            "std" => 0,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Support Upload SVG medias", 'elessi-theme'),
            "desc" => esc_html__("Yes, Please!", 'elessi-theme'),
            "id" => "sp_upload_svg",
            "std" => 1,
            "type" => "checkbox"
        );
        
        $of_options[] = array(
            "name" => esc_html__("Back to Top", 'elessi-theme'),
            "id" => "back_to_top",
            "std" => 1,
            "type" => "switch"
        );
        
        // The block editor from managing widgets
        global $wp_version;
        if (isset($wp_version) && version_compare($wp_version, '5.8', ">=")) {
            $of_options[] = array(
                "name" => esc_html__("The block editor from managing widgets", 'elessi-theme'),
                "id" => "block_editor_widgets",
                "std" => 0,
                "type" => "switch"
            );
        }
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Options", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("GDPR Options", 'elessi-theme') . "</h4>",
            "type" => "info"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Notice", 'elessi-theme'),
            "id" => "nasa_gdpr_notice",
            "std" => 0,
            "type" => "switch"
        );
        
        $of_options[] = array(
            "name" => esc_html__("GDPR Policies Link", 'elessi-theme'),
            "id" => "nasa_gdpr_policies",
            "std" => "https://policies.google.com",
            "type" => "text"
        );
        
        $list_css = elessi_get_list_css_files_call();
        if (!empty($list_css)) {
            $of_options[] = array(
                "name" => esc_html__("Skip Load - Files CSS", 'elessi-theme'),
                "std" => "<h4>" . esc_html__("CSS Files can be Skip", 'elessi-theme') . "</h4>",
                "type" => "info"
            );

            $of_options[] = array(
                "name" => esc_html__("Skip Load - Files CSS - Checkin it if you don't want your site call", 'elessi-theme'),
                "id" => "css_files",
                "std" => array(),
                "type" => "multicheck",
                "options" => $list_css,
                'class' => 'fullwidth'
            );
        }
        
        $list_js = elessi_get_list_js_files_delay();
        
        $of_options[] = array(
            "name" => esc_html__("Delay JavaScript Execution", 'elessi-theme'),
            "std" => "<h4>" . esc_html__("Delay JavaScript Execution", 'elessi-theme') . "</h4>",
            "type" => "info"
        );

        $of_options[] = array(
            "name" => esc_html__("List Files JS Delay", 'elessi-theme'),
            "id" => "js_files",
            "std" => array(),
            "type" => "multicheck",
            "options" => $list_js,
            'class' => 'fullwidth'
        );
    }
}
