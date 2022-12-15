<?php
function nasa_wpb_bike() {
    $imgs_1 = elessi_import_upload('/wp-content/uploads/2018/12/bike-banner-1.jpg', '3094', array(
        'post_title' => 'bike-banner-1',
        'post_name' => 'bike-banner-1',
    ));
    
    $imgs_2 = elessi_import_upload('/wp-content/uploads/2018/12/bike-banner-2.jpg', '3117', array(
        'post_title' => 'bike-banner-2',
        'post_name' => 'bike-banner-2',
    ));
    
    $imgs_3 = elessi_import_upload('/wp-content/uploads/2018/12/bike-banner-3.jpg', '3117', array(
        'post_title' => 'bike-banner-3',
        'post_name' => 'bike-banner-3',
    ));
    
    return array(
        'post' => array(
            'post_title' => 'WPB Bike',
            'post_name' => 'wpb-bike',
            'post_content' => '[vc_row fullwidth="1"][vc_column][nasa_rev_slider alias="slider-bike"][/vc_column][/vc_row][vc_row el_class="margin-top-10"][vc_column width="1/2" el_class="desktop-padding-right-5"][nasa_banner align="right" text-align="text-right" effect_text="fadeInLeft" hover="zoom" img_src="' . $imgs_1 . '" el_class="margin-bottom-0"]
    <h4 class="primary-color">The narrowest bike</h4>
    <b style="font-size: 160%; line-height: 1.6; color: #aaa;">Sale Off 50%</b>[/nasa_banner][/vc_column][vc_column width="1/2" el_class="desktop-padding-left-5 mobile-margin-top-10"][nasa_banner effect_text="fadeInDown" hover="zoom" img_src="' . $imgs_2 . '" el_class="margin-bottom-10"]
    <h4>Composants</h4>
    <b style="font-size: 150%; line-height: 1.6; color: #aaa;">Sale Off 30%</b>[/nasa_banner][nasa_banner align="right" valign="middle" text-align="text-right" effect_text="fadeInUp" hover="zoom" img_src="' . $imgs_3 . '"]
    <h4>Bike Equiment
    &amp; Accessories</h4>
    <b style="font-size: 120%; line-height: 1.6;"><a class="primary-color" href="#">Shop now</a></b>[/nasa_banner][/vc_column][/vc_row][vc_row el_class="margin-top-50"][vc_column][nasa_title title_text="Our Products" title_type="h3" font_size="xl" title_align="text-center"][vc_tta_tabs alignment="center"][vc_tta_section hr="1" title="NEW ARRIVALS" tab_id="1509957137879-8aa83829-3ba3"][nasa_products columns_number="4" columns_number_small="2" columns_number_tablet="2"][/vc_tta_section][vc_tta_section hr="1" title="FEATURED" tab_id="1509680382542-1cd79545-bdae"][nasa_products type="featured_product" columns_number="4" columns_number_small="2" columns_number_tablet="2"][/vc_tta_section][vc_tta_section hr="1" title="BEST SELLER" tab_id="1509680382515-609c6f4d-fd0e"][nasa_products type="best_selling" columns_number="4" columns_number_small="2" columns_number_tablet="2"][/vc_tta_section][vc_tta_section hr="1" title="ON SALE" tab_id="1509957049380-e38870ed-5797"][nasa_products type="on_sale" columns_number="4" columns_number_small="2" columns_number_tablet="2"][/vc_tta_section][/vc_tta_tabs][/vc_column][/vc_row][vc_row fullwidth="1" el_class="padding-bottom-40 margin-top-80"][vc_column][nasa_products style="slide_slick" shop_url="0" arrows="0" auto_slide="true" number="4" columns_number="1"][/vc_column][/vc_row][vc_row el_class="margin-top-80"][vc_column][nasa_products title_shortcode="Our Equiment" style="carousel" pos_nav="left" shop_url="0" arrows="1" columns_number="3" columns_number_small="2" columns_number_tablet="2"][/vc_column][/vc_row][vc_row][vc_column][nasa_title title_text="Latest Blogs" title_type="h3" font_size="xl" title_desc="The freshest and most exciting news" title_align="text-center" el_class="margin-top-60 margin-bottom-30"][nasa_post auto_slide="true" arrows="0" posts="5" columns_number="3" columns_number_small="1" columns_number_tablet="2" date_enable="no" author_enable="no" page_blogs="no"][/vc_column][/vc_row][vc_row el_class="margin-bottom-50"][vc_column][nasa_brands images="' . elessi_imp_brands_str() . '" columns_number="6" columns_number_tablet="4" columns_number_small="3" custom_links="#,#,#,#,#,#,#"][/vc_column][/vc_row]'
        ),
        'post_meta' => array(
            '_nasa_pri_color_flag' => 'on',
            '_nasa_pri_color' => '#83b828'
        )
    );
}
