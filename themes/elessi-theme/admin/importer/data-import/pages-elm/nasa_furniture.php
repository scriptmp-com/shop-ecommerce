<?php
function nasa_elm_furniture() {
    $imgs_1 = elessi_import_upload('/wp-content/uploads/2019/02/furniture-sofa-banner.jpg', '3117', array(
        'post_title' => 'furniture-sofa-banner',
        'post_name' => 'furniture-sofa-banner',
    ));
    
    $imgs_2 = elessi_import_upload('/wp-content/uploads/2019/02/furniture-lightning-banner.jpg', '3115', array(
        'post_title' => 'furniture-lightning-banner',
        'post_name' => 'furniture-lightning-banner',
    ));
    
    $imgs_3 = elessi_import_upload('/wp-content/uploads/2019/02/furniture-clock-banner.jpg', '3115', array(
        'post_title' => 'furniture-clock-banner',
        'post_name' => 'furniture-clock-banner',
    ));
    
    $imgs_4 = elessi_import_upload('/wp-content/uploads/2019/02/cat-banner5.jpg', '3094', array(
        'post_title' => 'cat-banner5',
        'post_name' => 'cat-banner5',
    ));
    
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
            'post_title' => 'ELM Furniture',
            'post_name' => 'elm-furniture'
        ),
        
        'post_meta' => array(
            '_elementor_data' => '[{"id":"3564cb12","elType":"section","settings":{"layout":"full_width","gap":"no","margin":{"unit":"px","top":"0","right":0,"bottom":"60","left":0,"isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"45","left":0,"isLinked":false}},"elements":[{"id":"367cec8f","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"49e72e9b","elType":"widget","settings":{"wp":{"pin_slug":"pin-products-home-furniture","marker_style":"price","full_price_icon":"no","show_img":"no","show_price":"no","pin_effect":"default","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_pin_products_banner_sc"}],"isInner":false}],"isInner":false},{"id":"19dd2c5f","elType":"section","settings":{"layout":"full_width","gap":"no","margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":true},"padding":{"unit":"px","top":"0","right":"0","bottom":"15","left":"0","isLinked":false}},"elements":[{"id":"58694b9f","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"5bc7997c","elType":"widget","settings":{"title":"Featured Categories","size":"large","align":"center","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"margin-bottom-10","header_size":"h3"},"elements":[],"widgetType":"heading"},{"id":"2ff92b04","elType":"widget","settings":{"html":"<p class=\"nasa-title-desc text-center margin-bottom-0\">The freshest and most exciting news<\/p>"},"elements":[],"widgetType":"html"}],"isInner":false}],"isInner":false},{"id":"68acebbb","elType":"section","settings":{"structure":"20","stretch_section":"section-stretched","padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"35","left":0,"isLinked":false},"margin":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false}},"elements":[{"id":"463a8fe3","elType":"column","settings":{"_column_size":50,"_inline_size":null,"html_tag":"section","padding":{"unit":"px","top":"10","right":"10","bottom":"0","left":"10","isLinked":false}},"elements":[{"id":"20780ed2","elType":"section","settings":{"margin_mobile":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":true}},"elements":[{"id":"12bc4776","elType":"column","settings":{"_column_size":100,"_inline_size":null,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"69d67f40","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_1 . '","height":"258px","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"bottom","text-align":"text-left","banner_responsive":"no","content":"<div><a style=\"background-color: #fff;font-size: 120%;padding: 10px 40px\" title=\"Sofas\" href=\"#\"><strong>Sofas<\/strong><\/a><\/div>","effect_text":"fadeIn","data_delay":"","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true}],"isInner":true},{"id":"56f21968","elType":"section","settings":{"structure":"20","padding":{"unit":"px","top":"20","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"6705f304","elType":"column","settings":{"_column_size":50,"_inline_size":null,"padding":{"unit":"px","top":"0","right":"10","bottom":"0","left":"0","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"20","left":"0","isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"31a80796","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_2 . '","height":"280px","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"bottom","text-align":"text-left","banner_responsive":"yes","content":"<div><a style=\"background-color: #fff;font-size: 120%;padding: 10px 40px\" title=\"Lighting\" href=\"#\"><strong>Lighting<\/strong><\/a><\/div>","effect_text":"fadeIn","data_delay":"","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true},{"id":"38bba2cd","elType":"column","settings":{"_column_size":50,"_inline_size":null,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"10","isLinked":false},"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"padding_mobile":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false}},"elements":[{"id":"1cc48559","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_3 . '","height":"280px","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"bottom","text-align":"text-left","banner_responsive":"yes","content":"<div><a style=\"background-color: #fff;font-size: 120%;padding: 10px 40px\" title=\"Sofas\" href=\"#\"><strong>Sofas<\/strong><\/a><\/div>","effect_text":"fadeIn","data_delay":"","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true}],"isInner":true}],"isInner":false},{"id":"2109f9fe","elType":"column","settings":{"_column_size":50,"_inline_size":null,"padding":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":false},"margin":{"unit":"px","top":"0","right":"0","bottom":"0","left":"0","isLinked":true}},"elements":[{"id":"2ee1c8cc","elType":"section","settings":[],"elements":[{"id":"4891ec","elType":"column","settings":{"_column_size":100,"_inline_size":null,"padding":{"unit":"px","top":"10","right":"10","bottom":"0","left":"10","isLinked":false}},"elements":[{"id":"5c3b7e95","elType":"widget","settings":{"wp":{"img_src":"' . $imgs_4 . '","height":"532","width":"","link":"#","content-width":"","align":"left","move_x":"","valign":"bottom","text-align":"text-left","banner_responsive":"no","content":"<div><a style=\"background-color: #fff;font-size: 120%;padding: 10px 40px\" title=\"Chair\" href=\"#\"><strong>Chair<\/strong><\/a><\/div>","effect_text":"fadeInLeft","data_delay":"300ms","hover":"zoom","border_inner":"no","border_outner":"no","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_banner_sc"}],"isInner":true}],"isInner":true}],"isInner":false}],"isInner":false},{"id":"5fdb4d6b","elType":"section","settings":[],"elements":[{"id":"79f537bc","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"1d420d8c","elType":"widget","settings":{"title":"Best Seller","size":"large","align":"center","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","header_size":"h3"},"elements":[],"widgetType":"heading"},{"id":"504f991a","elType":"widget","settings":{"wp":{"title":"","desc":"","alignment":"center","style":"2d","tabs":{"1602751895938":{"tab_title":"All","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602751981881":{"tab_title":"Best Seller","type":"recent_product","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752233078":{"tab_title":"Featured","type":"recent_product","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752236154":{"tab_title":"On Sale","type":"recent_product","style":"carousel","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"10","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""},"1602752238627":{"tab_title":"Deal","type":"recent_product","style":"grid","style_viewmore":"1","style_row":"2","pos_nav":"top","title_align":"left","shop_url":"1","arrows":"0","dots":"false","auto_slide":"false","number":"8","auto_delay_time":"6","columns_number":"4","columns_number_small":"2","columns_number_small_slider":"2","columns_number_tablet":"3","cat":"","not_in":"","el_class":""}},"el_class":""},"_css_classes":"nasa-tab-primary-color"},"elements":[],"widgetType":"wp-widget-nasa_products_tabs_sc"}],"isInner":false}],"isInner":false},{"id":"74c61567","elType":"section","settings":{"background_background":"classic","background_color":"#6BAD0D","margin":{"unit":"px","top":"20","right":0,"bottom":"60","left":0,"isLinked":false},"padding":{"unit":"px","top":"10","right":"0","bottom":"10","left":"0","isLinked":false}},"elements":[{"id":"7f4e6a8f","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"177752a8","elType":"widget","settings":{"wp":{"title":"","text":"<p class=\"text-center\" style=\"color: #fff; margin-bottom: 0;\"><strong>UP TO 70% OFF THE ENTRIRE STORE! - MADE WITH LOVE by <span class=\"nasa-underline\">Nasa studio<\/span><\/strong><\/p>","filter":"on","visual":"on"}},"elements":[],"widgetType":"wp-widget-text"}],"isInner":false}],"isInner":false},{"id":"466dcd59","elType":"section","settings":{"structure":"20","margin":{"unit":"px","top":"0","right":0,"bottom":"50","left":0,"isLinked":false}},"elements":[{"id":"55ef810d","elType":"column","settings":{"_column_size":50,"_inline_size":null,"margin_mobile":{"unit":"px","top":"0","right":"0","bottom":"30","left":"0","isLinked":false}},"elements":[{"id":"259c5736","elType":"widget","settings":{"youtube_url":"https:\/\/www.youtube.com\/watch?v=DmFtQrnBSe0","vimeo_url":"https:\/\/vimeo.com\/235215203","dailymotion_url":"https:\/\/www.dailymotion.com\/video\/x6tqhqb","image_overlay":{"id":"3632","url":"https:\/\/via.placeholder.com\/1200x800"}},"elements":[],"widgetType":"video"}],"isInner":false},{"id":"1894c943","elType":"column","settings":{"_column_size":50,"_inline_size":null,"css_classes":"desktop-padding-left-40 rtl-right rtl-desktop-padding-left-0 rtl-desktop-padding-right-40"},"elements":[{"id":"5607418d","elType":"widget","settings":{"title":"About Us","size":"large","align":"left","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","text_shadow_text_shadow_type":"yes","text_shadow_text_shadow":{"horizontal":0,"vertical":0,"blur":0,"color":"rgba(0,0,0,0.3)"},"header_size":"h3"},"elements":[],"widgetType":"heading"},{"id":"7c8dca8c","elType":"widget","settings":{"wp":{"title":"","text":"Our mission is to bring together a diverse, curated collection of beautiful furniture and homewares from around the world. I was popularised in the 1960s with the release.","filter":"on","visual":"on"}},"elements":[],"widgetType":"wp-widget-text"},{"id":"17270f07","elType":"section","settings":{"structure":"20"},"elements":[{"id":"30548416","elType":"column","settings":{"_column_size":50,"_inline_size":null},"elements":[{"id":"357b6e5b","elType":"widget","settings":{"wp":{"alt":"","link_text":"","link_target":"","image":"2914","align":"left","el_class":"left rtl-right margin-right-20 rtl-margin-left-20 rtl-margin-right-0 margin-top-5"},"_element_width":"initial","_element_custom_width":{"unit":"%","size":30,"sizes":[]}},"elements":[],"widgetType":"wp-widget-nasa_image"},{"id":"5e4ec831","elType":"widget","settings":{"title":"We work in Global\n<h6 class=\"nasa-title-desc\">Lorem ipsum<\/h6>","header_size":"h5","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"nasa-clear-none padding-top-10","_element_width":"initial","_element_custom_width":{"unit":"%","size":70,"sizes":[]}},"elements":[],"widgetType":"heading"}],"isInner":true},{"id":"5eb56fdd","elType":"column","settings":{"_column_size":50,"_inline_size":null,"css_classes":"nasa-block"},"elements":[{"id":"46a2ba33","elType":"widget","settings":{"wp":{"alt":"","link_text":"","link_target":"","image":"2915","align":"left","el_class":"left rtl-right margin-right-20 rtl-margin-left-20 rtl-margin-right-0 margin-top-5"},"_element_width":"initial","_element_custom_width":{"unit":"%","size":30,"sizes":[]}},"elements":[],"widgetType":"wp-widget-nasa_image"},{"id":"2ec14a93","elType":"widget","settings":{"title":"Our guarantee\n<h6 class=\"nasa-title-desc\">From 2 - 5 years<\/h6>","header_size":"h5","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"nasa-clear-none padding-top-10","_element_width":"initial","_element_custom_width":{"unit":"%","size":70,"sizes":[]}},"elements":[],"widgetType":"heading"}],"isInner":true}],"isInner":true},{"id":"2461e537","elType":"section","settings":{"structure":"20","css_classes":"nasa-block"},"elements":[{"id":"1eda39c7","elType":"column","settings":{"_column_size":50,"_inline_size":null,"css_classes":"nasa-block"},"elements":[{"id":"25ed6379","elType":"widget","settings":{"wp":{"alt":"","link_text":"","link_target":"","image":"2916","align":"left","el_class":"left rtl-right margin-right-20 rtl-margin-left-20 rtl-margin-right-0 margin-top-5"},"_element_width":"initial","_element_custom_width":{"unit":"%","size":30,"sizes":[]}},"elements":[],"widgetType":"wp-widget-nasa_image"},{"id":"2c0e7633","elType":"widget","settings":{"title":"On the market\n<h6 class=\"nasa-title-desc\">12 years<\/h6>","header_size":"h5","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"nasa-clear-none padding-top-10","_element_width":"initial","_element_custom_width":{"unit":"%","size":70,"sizes":[]}},"elements":[],"widgetType":"heading"}],"isInner":true},{"id":"68a0e7f3","elType":"column","settings":{"_column_size":50,"_inline_size":null,"css_classes":"nasa-block"},"elements":[{"id":"48b63504","elType":"widget","settings":{"wp":{"alt":"","link_text":"","link_target":"","image":"2917","align":"left","el_class":"left rtl-right margin-right-20 rtl-margin-left-20 rtl-margin-right-0 margin-top-5"},"_element_width":"initial","_element_custom_width":{"unit":"%","size":30,"sizes":[]}},"elements":[],"widgetType":"wp-widget-nasa_image"},{"id":"5c48a325","elType":"widget","settings":{"title":"Best quality\n<h6 class=\"nasa-title-desc\">Lorem ipsum<\/h6>","header_size":"h5","title_color":"#333333","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"nasa-clear-none padding-top-10","_element_width":"initial","_element_custom_width":{"unit":"%","size":70,"sizes":[]}},"elements":[],"widgetType":"heading"}],"isInner":true}],"isInner":true}],"isInner":false}],"isInner":false},{"id":"5c9d9b5d","elType":"section","settings":{"margin":{"unit":"px","top":"0","right":0,"bottom":"0","left":0,"isLinked":false}},"elements":[{"id":"e8bb281","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"1a43c203","elType":"widget","settings":{"title":"Latest blog","size":"large","header_size":"h3","align":"center","title_color":"#000000","typography_typography":"custom","typography_font_family":"Jost","typography_font_weight":"800","_css_classes":"margin-bottom-10"},"elements":[],"widgetType":"heading"},{"id":"3e36811e","elType":"widget","settings":{"html":"<p class=\"nasa-title-desc text-center margin-bottom-0\">The freshest and most exciting news<\/p>"},"elements":[],"widgetType":"html"},{"id":"744f3ab6","elType":"widget","settings":{"wp":{"title":"","show_type":"slide","auto_slide":"false","arrows":"0","dots":"false","posts":"4","columns_number":"3","columns_number_small":"1","columns_number_small_slider":"1","columns_number_tablet":"3","category":"","cats_enable":"yes","date_enable":"yes","author_enable":"no","readmore":"yes","date_author":"bot","des_enable":"no","page_blogs":"no","info_align":"left","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_post_sc"}],"isInner":false}],"isInner":false},{"id":"f4625e7","elType":"section","settings":{"css_classes":"margin-top-30 margin-bottom-50"},"elements":[{"id":"02fe6a5","elType":"column","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"8eb926f","elType":"widget","settings":{"wp":{"title":"","align":"center","sliders":{"1605886645649":{"img_src":"' . $brand_1 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886663901":{"img_src":"' . $brand_2 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886673562":{"img_src":"' . $brand_3 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886691185":{"img_src":"' . $brand_4 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886702478":{"img_src":"' . $brand_5 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""},"1605886713208":{"img_src":"' . $brand_6 . '","height":"","width":"","link":"","content-width":"","align":"left","move_x":"","valign":"top","text-align":"text-left","banner_responsive":"yes","content":"","effect_text":"none","data_delay":"","hover":"","border_inner":"no","border_outner":"no","el_class":""}},"bullets":"false","bullets_pos":"","bullets_align":"center","navigation":"true","column_number":"6","column_number_small":"3","column_number_tablet":"4","padding_item":"","padding_item_small":"","padding_item_medium":"","autoplay":"false","paginationspeed":"300","el_class":""}},"elements":[],"widgetType":"wp-widget-nasa_sliders_sc"}],"isInner":false}],"isInner":false}]',
            '_elementor_controls_usage' => 'a:12:{s:37:"wp-widget-nasa_pin_products_banner_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:6:"column";a:3:{s:5:"count";i:18;s:15:"control_percent";i:0;s:8:"controls";a:2:{s:6:"layout";a:1:{s:6:"layout";a:2:{s:12:"_inline_size";i:18;s:8:"html_tag";i:1;}}s:8:"advanced";a:1:{s:16:"section_advanced";a:5:{s:7:"padding";i:6;s:13:"margin_mobile";i:4;s:14:"padding_mobile";i:2;s:6:"margin";i:1;s:11:"css_classes";i:4;}}}}s:7:"section";a:3:{s:5:"count";i:13;s:15:"control_percent";i:0;s:8:"controls";a:3:{s:6:"layout";a:2:{s:14:"section_layout";a:3:{s:6:"layout";i:2;s:3:"gap";i:2;s:15:"stretch_section";i:1;}s:17:"section_structure";a:1:{s:9:"structure";i:5;}}s:8:"advanced";a:1:{s:16:"section_advanced";a:4:{s:6:"margin";i:5;s:13:"margin_mobile";i:4;s:7:"padding";i:4;s:11:"css_classes";i:2;}}s:5:"style";a:1:{s:18:"section_background";a:2:{s:21:"background_background";i:1;s:16:"background_color";i:1;}}}}s:7:"heading";a:3:{s:5:"count";i:8;s:15:"control_percent";i:4;s:8:"controls";a:3:{s:7:"content";a:1:{s:13:"section_title";a:4:{s:5:"title";i:8;s:4:"size";i:4;s:5:"align";i:4;s:11:"header_size";i:8;}}s:5:"style";a:1:{s:19:"section_title_style";a:6:{s:11:"title_color";i:8;s:21:"typography_typography";i:8;s:22:"typography_font_family";i:8;s:22:"typography_font_weight";i:8;s:28:"text_shadow_text_shadow_type";i:1;s:23:"text_shadow_text_shadow";i:1;}}s:8:"advanced";a:2:{s:14:"_section_style";a:1:{s:12:"_css_classes";i:6;}s:17:"_section_position";a:2:{s:14:"_element_width";i:4;s:21:"_element_custom_width";i:4;}}}}s:4:"html";a:3:{s:5:"count";i:2;s:15:"control_percent";i:1;s:8:"controls";a:1:{s:7:"content";a:1:{s:13:"section_title";a:1:{s:4:"html";i:2;}}}}s:24:"wp-widget-nasa_banner_sc";a:3:{s:5:"count";i:4;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:31:"wp-widget-nasa_products_tabs_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:1;s:8:"controls";a:1:{s:8:"advanced";a:1:{s:14:"_section_style";a:1:{s:12:"_css_classes";i:1;}}}}s:14:"wp-widget-text";a:3:{s:5:"count";i:2;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:5:"video";a:3:{s:5:"count";i:1;s:15:"control_percent";i:1;s:8:"controls";a:1:{s:7:"content";a:2:{s:13:"section_video";a:1:{s:11:"youtube_url";i:1;}s:21:"section_image_overlay";a:1:{s:13:"image_overlay";i:1;}}}}s:20:"wp-widget-nasa_image";a:3:{s:5:"count";i:4;s:15:"control_percent";i:1;s:8:"controls";a:1:{s:8:"advanced";a:1:{s:17:"_section_position";a:2:{s:14:"_element_width";i:4;s:21:"_element_custom_width";i:4;}}}}s:22:"wp-widget-nasa_post_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}s:25:"wp-widget-nasa_sliders_sc";a:3:{s:5:"count";i:1;s:15:"control_percent";i:0;s:8:"controls";a:0:{}}}',
            '_elementor_css' => 'a:6:{s:4:"time";i:1606463892;s:5:"fonts";a:1:{i:0;s:4:"Jost";}s:5:"icons";a:0:{}s:20:"dynamic_elements_ids";a:0:{}s:6:"status";s:4:"file";i:0;s:0:"";}',
            '_nasa_pri_color_flag' => 'on',
            '_nasa_pri_color' => '#87b66e',
        ),

        'css' => '.elementor-[inserted_id] .elementor-element.elementor-element-3564cb12{margin-top:0px;margin-bottom:60px;}.elementor-[inserted_id] .elementor-element.elementor-element-19dd2c5f{padding:0px 0px 15px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-5bc7997c{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-5bc7997c .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-68acebbb{margin-top:0px;margin-bottom:50px;padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-463a8fe3 > .elementor-element-populated{padding:10px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-12bc4776 > .elementor-element-populated{padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-56f21968{padding:20px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-6705f304 > .elementor-element-populated{padding:0px 10px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-38bba2cd > .elementor-element-populated{padding:0px 0px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-2109f9fe > .elementor-element-populated{margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-4891ec > .elementor-element-populated{padding:10px 10px 0px 10px;}.elementor-[inserted_id] .elementor-element.elementor-element-1d420d8c{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-1d420d8c .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-74c61567:not(.elementor-motion-effects-element-type-background), .elementor-[inserted_id] .elementor-element.elementor-element-74c61567 > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-color:#6BAD0D;}.elementor-[inserted_id] .elementor-element.elementor-element-74c61567{transition:background 0.3s, border 0.3s, border-radius 0.3s, box-shadow 0.3s;margin-top:20px;margin-bottom:60px;padding:10px 0px 10px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-74c61567 > .elementor-background-overlay{transition:background 0.3s, border-radius 0.3s, opacity 0.3s;}.elementor-[inserted_id] .elementor-element.elementor-element-466dcd59{margin-top:0px;margin-bottom:50px;}.elementor-[inserted_id] .elementor-element.elementor-element-5607418d{text-align:left;}.elementor-[inserted_id] .elementor-element.elementor-element-5607418d .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;text-shadow:0px 0px 0px rgba(0,0,0,0.3);}.elementor-[inserted_id] .elementor-element.elementor-element-357b6e5b{width:30%;max-width:30%;}.elementor-[inserted_id] .elementor-element.elementor-element-5e4ec831 .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-5e4ec831{width:70%;max-width:70%;}.elementor-[inserted_id] .elementor-element.elementor-element-46a2ba33{width:30%;max-width:30%;}.elementor-[inserted_id] .elementor-element.elementor-element-2ec14a93 .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-2ec14a93{width:70%;max-width:70%;}.elementor-[inserted_id] .elementor-element.elementor-element-25ed6379{width:30%;max-width:30%;}.elementor-[inserted_id] .elementor-element.elementor-element-2c0e7633 .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-2c0e7633{width:70%;max-width:70%;}.elementor-[inserted_id] .elementor-element.elementor-element-48b63504{width:30%;max-width:30%;}.elementor-[inserted_id] .elementor-element.elementor-element-5c48a325 .elementor-heading-title{color:#333333;font-family:"Jost", Sans-serif;font-weight:800;}.elementor-[inserted_id] .elementor-element.elementor-element-5c48a325{width:70%;max-width:70%;}.elementor-[inserted_id] .elementor-element.elementor-element-5c9d9b5d{margin-top:0px;margin-bottom:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-1a43c203{text-align:center;}.elementor-[inserted_id] .elementor-element.elementor-element-1a43c203 .elementor-heading-title{color:#000000;font-family:"Jost", Sans-serif;font-weight:800;}@media(max-width:767px){.elementor-[inserted_id] .elementor-element.elementor-element-3564cb12{margin-top:0px;margin-bottom:45px;}.elementor-[inserted_id] .elementor-element.elementor-element-19dd2c5f{margin-top:0px;margin-bottom:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-68acebbb{margin-top:0px;margin-bottom:35px;}.elementor-[inserted_id] .elementor-element.elementor-element-20780ed2{margin-top:0px;margin-bottom:0px;}.elementor-[inserted_id] .elementor-element.elementor-element-12bc4776 > .elementor-element-populated{margin:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-6705f304 > .elementor-element-populated{margin:0px 0px 20px 0px;padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-38bba2cd > .elementor-element-populated{margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;}.elementor-[inserted_id] .elementor-element.elementor-element-55ef810d > .elementor-element-populated{margin:0px 0px 30px 0px;}}'
    );
}
