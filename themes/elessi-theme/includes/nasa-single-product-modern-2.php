<?php
if (!isset($nasa_opt)) :
    global $nasa_opt;
endif;

global $product;

$dots = isset($nasa_opt['product_slide_dot']) && $nasa_opt['product_slide_dot'] ? 'true' : 'false';

$style_focus = isset($nasa_opt['sp_bgl']) && $nasa_opt['sp_bgl'] ? ' style="background-color: ' . esc_attr($nasa_opt['sp_bgl']) . '"' : '';

?>

<div id="product-<?php echo (int) $product->get_id(); ?>" <?php post_class(); ?>>
    <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
        <div class="nasa-toggle-layout-side-sidebar nasa-sidebar-single-product <?php echo esc_attr($nasa_sidebar); ?>">
            <div class="li-toggle-sidebar">
                <a class="toggle-sidebar-shop nasa-tip" data-tip="<?php echo esc_attr__('Filters', 'elessi-theme'); ?>" href="javascript:void(0);" rel="nofollow">
                    <i class="nasa-icon pe7-icon pe-7s-menu"></i>
                </a>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="nasa-row nasa-product-details-page modern nasa-layout-modern-2">
        <div class="<?php echo esc_attr($main_class); ?>" data-num_main="1" data-num_thumb="4" data-speed="300" data-dots="<?php echo $dots; ?>">
            <div class="focus-info"<?php echo $style_focus; ?>>
                <div class="row">
                    <div class="large-7 small-12 columns product-gallery rtl-right padding-right-50 mobile-padding-right-10 rtl-padding-right-10 rtl-padding-left-50 rtl-mobile-padding-left-10"> 
                        <?php do_action('woocommerce_before_single_product_summary'); ?>
                    </div>

                    <div class="large-5 small-12 columns product-info text-center summary entry-summary rtl-left">
                        <div class="nasa-product-info-wrap">
                            <?php do_action('woocommerce_single_product_summary'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php do_action('woocommerce_after_single_product_summary'); ?>

        </div>

        <?php if ($nasa_actsidebar && $nasa_sidebar != 'no') : ?>
            <div class="<?php echo esc_attr($bar_class); ?>">
                <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
                    <?php echo esc_html__('Close', 'elessi-theme'); ?>
                </a>
                
                <div class="nasa-sidebar-off-canvas">
                    <?php dynamic_sidebar('product-sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
