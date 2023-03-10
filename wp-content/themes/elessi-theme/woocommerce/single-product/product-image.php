<?php
/**
 * Custom Product image
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.5.1
 */
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $product, $nasa_opt;

$productId = $product->get_id();
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$data_rel = '';
$thumbNailId = get_post_thumbnail_id();

$image_size = apply_filters('woocommerce_gallery_image_size', 'woocommerce_single');
$full_size = apply_filters('woocommerce_gallery_full_size', apply_filters('woocommerce_product_thumbnails_large_size', 'full'));

$image_title = esc_attr(get_the_title($thumbNailId));
$image_full = wp_get_attachment_image_src($thumbNailId, $full_size);
$image_link = isset($image_full[0]) ? $image_full[0] : wp_get_attachment_url($thumbNailId);
$image_large = wp_get_attachment_image_src($thumbNailId, $image_size);
$src_large = isset($image_large[0]) ? $image_large[0] : $image_link;
$image = get_the_post_thumbnail($productId, $image_size, array('alt' => $image_title, 'class' => 'skip-lazy attachment-shop_single size-shop_single'));
$attachment_count = count($attachment_ids);

$slideHoz = false;
if (isset($nasa_opt['product_detail_layout']) && $nasa_opt['product_detail_layout'] === 'classic' && isset($nasa_opt['product_thumbs_style']) && $nasa_opt['product_thumbs_style'] === 'hoz') {
    $slideHoz = true; 
}

if (in_array($nasa_opt['product_detail_layout'], array('modern-1'))) {
    $slideHoz = true;
}

$imageMobilePadding = 'mobile-padding-left-5 mobile-padding-right-5';
if (isset($nasa_opt['product_detail_layout']) && $nasa_opt['product_detail_layout'] == 'new' && isset($nasa_opt['product_image_style']) && $nasa_opt['product_image_style'] == 'scroll') {
    $imageMobilePadding = 'mobile-padding-left-0 mobile-padding-right-0 nasa-flex align-start';
}

$class_main_imgs = 'main-images nasa-single-product-main-image nasa-main-image-default';

$class_wrapimg = 'row nasa-mobile-row woocommerce-product-gallery__wrapper';
$show_thumbnail = true;
if (isset($nasa_opt['product_detail_layout']) && in_array($nasa_opt['product_detail_layout'], array('full'))) :
    $show_thumbnail = false;
    $class_wrapimg = 'nasa-row nasa-mobile-row woocommerce-product-gallery__wrapper nasa-columns-padding-0';
    $imageMobilePadding = 'mobile-padding-left-0 mobile-padding-right-0';
    
    if (isset($nasa_opt['half_full_slide']) && $nasa_opt['half_full_slide']) :
        $class_main_imgs .= ' no-easyzoom';
    endif;
endif;

$sliders_arrow = isset($nasa_opt['product_slide_arrows']) && $nasa_opt['product_slide_arrows'] && $nasa_opt['product_image_style'] === 'slide' ? true : false;
?>

<div class="images woocommerce-product-gallery">
    <div class="<?php echo $class_wrapimg; ?>">
        <div class="large-12 columns <?php echo $imageMobilePadding; ?>">
            <?php if ($show_thumbnail && !$slideHoz && (!isset($nasa_opt['nasa_in_mobile']) || !$nasa_opt['nasa_in_mobile'])) : ?>
                <div class="nasa-thumb-wrap rtl-right">
                    <?php do_action('woocommerce_product_thumbnails'); ?>
                </div>
            <?php endif; ?>
            
            <div class="nasa-main-wrap rtl-left<?php echo $slideHoz ? ' nasa-thumbnail-hoz' : ''; ?>">
                <div class="product-images-slider images-popups-gallery">
                    <div class="nasa-main-image-default-wrap">
                        
                        <?php if ($sliders_arrow) : ?>
                            <div class="nasa-single-slider-arrows">
                                <a class="nasa-single-arrow nasa-disabled" data-action="prev" href="javascript:void(0);" rel="nofollow"></a>
                                <a class="nasa-single-arrow" data-action="next" href="javascript:void(0);" rel="nofollow"></a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="<?php echo esc_attr($class_main_imgs); ?>">
                            <div class="item-wrap first">
                                <div class="nasa-item-main-image-wrap" id="nasa-main-image-0" data-key="0">
                                    <?php if ($post_thumbnail_id) : ?>
                                        <div class="easyzoom first">
                                            <?php echo apply_filters(
                                                'woocommerce_single_product_image_thumbnail_html',
                                                sprintf(
                                                    '<a href="%s" class="woocommerce-main-image product-image woocommerce-product-gallery__image" data-o_href="%s" data-full_href="%s" title="%s">%s</a>',
                                                    $image_link,
                                                    $src_large,
                                                    $image_link,
                                                    $image_title,
                                                    $image
                                                ),
                                                $post_thumbnail_id
                                            ); ?>
                                        </div>
                                    <?php else :
                                        $noimage = wc_placeholder_img_src();
                                        ?>
                                        <div class="easyzoom">
                                            <?php echo apply_filters(
                                                'woocommerce_single_product_image_thumbnail_html',
                                                sprintf(
                                                    '<a href="%s" class="woocommerce-main-image product-image woocommerce-product-gallery__image" data-o_href="%s"><img src="%s" /></a>',
                                                        $noimage,
                                                        $noimage,
                                                        $noimage
                                                    ),
                                                $post_thumbnail_id
                                            ); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                            $_i = 0;
                            if ($attachment_count > 0) :
                                foreach ($attachment_ids as $id) :
                                    $_i++;
                                    ?>
                                    <div class="item-wrap">
                                        <div class="nasa-item-main-image-wrap" id="nasa-main-image-<?php echo (int) $_i; ?>" data-key="<?php echo (int) $_i; ?>">
                                            <div class="easyzoom">
                                                <?php
                                                $image_title = esc_attr(get_the_title($id));
                                                
                                                $image_full = wp_get_attachment_image_src($id, $full_size);
                                                $image_link = isset($image_full[0]) ?
                                                    $image_full[0] : wp_get_attachment_url($id);
                                                
                                                $image = wp_get_attachment_image($id, $image_size, false, array('alt' => $image_title, 'class' => 'skip-lazy attachment-shop_single size-shop_single'));
                                                $image = $image ? $image : wc_placeholder_img();
                                                echo sprintf(
                                                    '<a href="%s" class="woocommerce-additional-image product-image" title="%s">%s</a>',
                                                    $image_link,
                                                    $image_title,
                                                    $image
                                                );
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="product-image-btn">
                        <?php do_action('nasa_single_buttons'); ?>
                    </div>
                </div>
                
                <div class="nasa-end-scroll"></div>
            </div>
            
            <?php if ($show_thumbnail && $slideHoz) : ?>
                <div class="nasa-thumb-wrap nasa-thumbnail-hoz">
                    <?php do_action('woocommerce_product_thumbnails'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
