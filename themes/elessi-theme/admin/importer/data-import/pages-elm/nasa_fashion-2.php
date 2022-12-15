<?php
function nasa_elm_fashion_2() {
    $imgs_1 = elessi_import_upload('/wp-content/uploads/2018/03/h1-banner1.jpg', '3094', array(
        'post_title' => 'h1-banner1',
        'post_name' => 'h1-banner1',
    ));
    
    $imgs_2 = elessi_import_upload('/wp-content/uploads/2018/05/h2-banner-white.jpg', '3095', array(
        'post_title' => 'h2-banner-white',
        'post_name' => 'h2-banner-white',
    ));
    
    $imgs_3 = elessi_import_upload('/wp-content/uploads/2018/03/h1-banner2.jpg', '3095', array(
        'post_title' => 'h1-banner2',
        'post_name' => 'h1-banner2',
    ));
    
    $imgs_4 = elessi_import_upload('/wp-content/uploads/2018/03/h1-banner3.jpg', '3096', array(
        'post_title' => 'h1-banner3',
        'post_name' => 'h1-banner3',
    ));
    
    $imgs_5 = elessi_import_upload('/wp-content/uploads/2018/03/h1-deal-bg.jpg', '0', array(
        'post_title' => 'h1-deal-bg',
        'post_name' => 'h1-deal-bg',
    ));
    $imgs_5_src = $imgs_5 ? wp_get_attachment_image_url($imgs_5, 'full') : 'https://via.placeholder.com/1920x853?text=1920x853';
    
    $brand_1 = elessi_import_upload('/wp-content/uploads/2017/09/brand-1.jpg', '3074', array(
        'post_title' => 'Brand IMG 1',
        'post_name' => 'brand-1',
    ));
    $brand_2 = elessi_import_upload('/wp-content/uploads/2017/09/brand-2.jpg', '3074', array(
        'post_title' => 'Brand IMG 2',
        'post_name' => 'brand-2',
    ));
    $brand_3 = elessi_import_upload('/wp-content/uploads/2017/09/brand-3.jpg', '3074', array(
        'post_title' => 'Brand IMG 3',
        'post_name' => 'brand-3',
    ));
    $brand_4 = elessi_import_upload('/wp-content/uploads/2017/09/brand-4.jpg', '3074', array(
        'post_title' => 'Brand IMG 4',
        'post_name' => 'brand-4',
    ));
    $brand_5 = elessi_import_upload('/wp-content/uploads/2017/09/brand-5.jpg', '3074', array(
        'post_title' => 'Brand IMG 5',
        'post_name' => 'brand-5',
    ));
    $brand_6 = elessi_import_upload('/wp-content/uploads/2017/09/brand-6.jpg', '3074', array(
        'post_title' => 'Brand IMG 6',
        'post_name' => 'brand-6',
    ));
    
    return array(
        'post' => array(
            'post_title' => 'ELM Fashion V2',
            'post_name' => 'elm-fashion-v2'
        ),
        
        'post_meta' => array(
            '_elementor_data' => '[{"id":"37b50d6d","elType":"section","settings":{"layout":"full_width","gap":"no"},"elements":[{"id":"1c9fa255","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"779fca2","elType":"widget","settings":{"revslidertitle":"Slider 02-1","shortcode":"[rev_slider alias=\"slider-02-1\" slidertitle=\"Slider 02-1\"][\/rev_slider]"},"elements":[],"widgetType":"slider_revolution"}],"isInner":false}],"isInner":false},{"id":"37655f1d","elType":"section","settings":{"structure":"20","stretch_section":"section-stretched"},"elements":[{"id":"1a68d163","elType":"column","settings":{"_column_size":50,"_inline_size":50,"padding":{"unit":"px","top":"10","right":"5","bottom":"10","left":"10","isLinked":false},"padding_mobile":{"unit":"px","top":"10","right":"10","bottom":"10","left":"10","isLinked":true}},"elements":[{"id":"77ea4cfd","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_1 . '","height":"531px","width":"","link":"#","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"<h3 style=\"color: #333;font-weight: 800\">Bag Collection<\/h3>\r\n<h5 style=\"color: #999\">Sale off 50%<\/h5>","effect_text":"fadeInLeft","data_delay":"300ms","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":false},{"id":"134799de","elType":"column","settings":{"_column_size":50,"_inline_size":50,"html_tag":"section","padding":{"unit":"px","top":"0","right":"5","bottom":"0","left":"0","isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"10","bottom":"10","left":"10","isLinked":false}},"elements":[{"id":"3d7621d4","elType":"section","settings":{"structure":"20"},"elements":[{"id":"7304b653","elType":"column","settings":{"_column_size":50,"_inline_size":null,"padding":{"unit":"px","top":"10","right":"5","bottom":"5","left":"5","isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}},"elements":[{"id":"4cdd33f1","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_2 . '","height":"260px","width":"","link":"#","content-width":"","align":"center","move_x":"","valign":"middle","text-align":"text-center","banner_responsive":"yes","content":"<h6 style=\"font-weight: bold !important;letter-spacing: 10px;color: #9c9c9c\">ELESSI<\/h6>\r\n<h3 style=\"font-weight: 800\">Summer\r\nLookbook<\/h3>","effect_text":"fadeIn","data_delay":"","hover":"zoom","border_inner":"no","border_outner":"yes","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true},{"id":"70551a04","elType":"column","settings":{"_column_size":50,"_inline_size":null,"padding":{"unit":"px","top":"10","right":"5","bottom":"5","left":"5","isLinked":false},"padding_mobile":{"unit":"px","top":"10","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"1fe60ee","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_3 . '","height":"260px","width":"","link":"#","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":"margin-bottom-0"}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true}],"isInner":true},{"id":"1705cec8","elType":"section","settings":[],"elements":[{"id":"777b0ab3","elType":"column","settings":{"_column_size":100,"_inline_size":null,"padding":{"unit":"px","top":"5","right":"5","bottom":"10","left":"5","isLinked":false},"padding_mobile":{"unit":"px","top":"10","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"36b94c13","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_4 . '","height":"268","width":"590","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"<h4 style=\"color: #333;font-weight: 800\">Mini backpack<\/h4>\r\n<h5 style=\"color: #999\">Bags &amp; Accessories<\/h5>","effect_text":"flipInX","data_delay":"","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true}],"isInner":true}],"isInner":false}],"isInner":false},{"id":"620c502d","elType":"section","settings":[],"elements":[{"id":"17e9e4bf","elType":"column","settings":{"_column_size":100,"_inline_size":null,"css_classes":"margin-top-60 mobile-margin-top-30"},"elements":[{"id":"24df0c7a","elType":"widget","settings":{"title":"Trendy item","size":"large","header_size":"h3","align":"center","title_color":"#000000","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"margin-bottom-10"},"elements":[],"widgetType":"heading"},{"id":"28f3532e","elType":"widget","settings":{"wp":{"title":"","desc":"","alignment":"center","style":"2d-no-border","tabs":{"1602751895938":{"tab_title":"ALL","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602751981881":{"tab_title":"WOMAN","type":"recent_product","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752233078":{"tab_title":"MAN","type":"recent_product","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752236154":{"tab_title":"ON SALE","type":"on_sale","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752238627":{"tab_title":"NEW","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""}},"el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_products_tabs_sc"}],"isInner":false}],"isInner":false},{"id":"7faf0a56","elType":"section","settings":{"background_overlay_background":"classic","background_overlay_image":{"id":3328,"url":' . json_encode($imgs_5_src) . '},"padding":{"unit":"px","top":"0","right":"0","bottom":"170","left":"0","isLinked":false}},"elements":[{"id":"56665756","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"7da9f5eb","elType":"widget","settings":{"wp":{"limit":"4","cat":"","style":"multi","title":"","desc_shortcode":"","date_sc":"","columns_number":"4","columns_number_small":"2","columns_number_tablet":"3","statistic":"1","arrows":"1","auto_slide":"true","el_class":"nasa-relative top-100"}},"elements":[],"widgetType":"wp-widget-nasa_products_special_deal_sc"}],"isInner":false}],"isInner":false},{"id":"c638e56","elType":"section","settings":{"css_classes":"margin-top-80 margin-bottom-30"},"elements":[{"id":"1b022286","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"1b10d69e","elType":"widget","settings":{"title":"Latest blog","size":"large","header_size":"h3","align":"center","title_color":"#000000","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"margin-bottom-20"},"elements":[],"widgetType":"heading"},{"id":"2dffb3c","elType":"widget","settings":{"wp":{"title":"","show_type":"slide","auto_slide":"false","arrows":"0","dots":"false","posts":"4","columns_number":"3","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"2","category":"","cats_enable":"yes","date_enable":"yes","author_enable":"yes","readmore":"yes","date_author":"bot","des_enable":"no","page_blogs":"yes","info_align":"left","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_post_sc"}],"isInner":false}],"isInner":false},{"id":"7ecf9e91","elType":"section","settings":{"layout":"full_width","gap":"no"},"elements":[{"id":"1e3a6064","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"4d6014a6","elType":"widget","settings":{"title":"Follow us on Instagram","size":"large","header_size":"h3","align":"center","title_color":"#000000","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800"},"elements":[],"widgetType":"heading"},{"id":"806ca88","elType":"widget","settings":{"wp":{"username_show":"Store Style","instagram_link":"#","img_size":"full","disp_type":"default","auto_slide":"false","limit_items":"6","columns_number":"6","columns_number_tablet":"3","columns_number_small":"3","el_class_img":"","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_instagram_feed_sc"}],"isInner":false}],"isInner":false},{"id":"b53b6f5","elType":"section","settings":{"css_classes":"margin-top-30 margin-bottom-50"},"elements":[{"id":"1dd07c5","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"1d64396","elType":"widget","settings":{"wp":{"title":"","align":"center","sliders":{"1605886645649":{"img_src":"' . $brand_1 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886663901":{"img_src":"' . $brand_2 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886673562":{"img_src":"' . $brand_3 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886691185":{"img_src":"' . $brand_4 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886702478":{"img_src":"' . $brand_5 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886713208":{"img_src":"' . $brand_6 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""}},"bullets":"false","bullets_pos":"","bullets_align":"center","navigation":"true","column_number":"6","column_number_small":"3","column_number_tablet":"4","padding_item":"","padding_item_small":"","padding_item_medium":"","autoplay":"false","paginationspeed":"300","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_sliders_sc"}],"isInner":false}],"isInner":false}]',
            '_elementor_controls_usage' => 'a:10:{s:27:"wp-widget-rev-slider-widget";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:6:"column";a:3:{s:5:"count";i:11;s:15:"control_percent";i:0;s:8:"controls";a:2:{s:6:"layout";a:1:{s:6:"layout";a:2:{s:12:"_inline_size";i:11;s:8:"html_tag";i:1;}}s:8:"advanced";a:1:{s:16:"section_advanced";a:3:{s:7:"padding";i:5;s:14:"padding_mobile";i:5;s:11:"css_classes";i:1;}}}}s:7:"section";a:3:{s:5:"count";i:9;s:15:"control_percent";i:0;s:8:"controls";a:3:{s:6:"layout";a:2:{s:14:"section_layout";a:3:{s:6:"layout";i:2;s:3:"gap";i:2;s:15:"stretch_section";i:1;}s:17:"section_structure";a:1:{s:9:"structure";i:2;}}s:5:"style";a:1:{s:26:"section_background_overlay";a:2:{s:29:"background_overlay_background";i:1;s:24:"background_overlay_image";i:1;}}s:8:"advanced";a:1:{s:16:"section_advanced";a:2:{s:7:"padding";i:1;s:11:"css_classes";i:2;}}}}s:24:"wp-widget-nasa_banner_sc";a:3:{s:5:"count";i:4;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:7:"heading";a:3:{s:5:"count";i:3;s:15:"control_percent";i:4;s:8:"controls";a:3:{s:7:"content";a:1:{s:13:"section_title";a:4:{s:5:"title";i:3;s:4:"size";i:3;s:11:"header_size";i:3;s:5:"align";i:3;}}s:5:"style";a:1:{s:19:"section_title_style";a:4:{s:11:"title_color";i:3;s:21:"typography_typography";i:3;s:22:"typography_font_family";i:3;s:22:"typography_font_weight";i:3;}}s:8:"advanced";a:1:{s:14:"_section_style";a:1:{s:12:"_css_classes";i:2;}}}}s:31:"wp-widget-nasa_products_tabs_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:39:"wp-widget-nasa_products_special_deal_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:22:"wp-widget-nasa_post_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:32:"wp-widget-nasa_instagram_feed_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:25:"wp-widget-nasa_sliders_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}}',
            '_elementor_css' => 'a:6:{s:4:"time";i:1639649467;s:5:"fonts";a:1:{i:0;s:4:"Jost";}s:5:"icons";a:0:{}s:20:"dynamic_elements_ids";a:0:{}s:6:"status";s:4:"file";i:0;s:0:"";}',
            '_nasa_custom_header' => '1',
            '_nasa_header_transparent' => '1',
            '_nasa_topbar_default_show' => '2',
            '_nasa_topbar_toggle' => '1',
        ),

        'css' => '.elementor-[inserted_id] .elementor-element.elementor-element-1a68d163 > .elementor-element-populated{padding:10px 5px 10px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-134799de > .elementor-element-populated{padding:0px 5px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-7304b653 > .elementor-element-populated{padding:10px 5px 5px 5px;}.elementor-[inserted_id] .elementor-element.elementor-element-70551a04 > .elementor-element-populated{padding:10px 5px 5px 5px;}.elementor-[inserted_id] .elementor-element.elementor-element-777b0ab3 > .elementor-element-populated{padding:5px 5px 10px 5px;}.elementor-[inserted_id] .elementor-element.elementor-element-24df0c7a{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-24df0c7a .elementor-heading-title{color:#000000;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-7faf0a56 > .elementor-background-overlay{background-image:url("' . $imgs_5_src . '");opacity:0.5;}.elementor-[inserted_id] .elementor-element.elementor-element-7faf0a56{padding:0px 0px 170px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-1b10d69e{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-1b10d69e .elementor-heading-title{color:#000000;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-4d6014a6{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-4d6014a6 .elementor-heading-title{color:#000000;font-family:"Jost", Sans-serif;font-weight:800;}@media(max-width:767px){.elementor-[inserted_id] .elementor-element.elementor-element-1a68d163 > .elementor-element-populated{padding:10px 10px 10px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-134799de > .elementor-element-populated{padding:0px 10px 10px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-7304b653 > .elementor-element-populated{padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-70551a04 > .elementor-element-populated{padding:10px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-777b0ab3 > .elementor-element-populated{padding:10px 0px 0px 0px;}}@media(min-width:768px){.elementor-[inserted_id] .elementor-element.elementor-element-1a68d163{width:50%;}.elementor-[inserted_id] .elementor-element.elementor-element-134799de{width:50%;}}'
    );
}
