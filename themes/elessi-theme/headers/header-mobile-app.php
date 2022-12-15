<?php
defined('ABSPATH') or die(); // Exit if accessed directly
$single_product = NASA_WOO_ACTIVED && is_product() ? true : false;
$class_sticky = $single_product ? 'product-header' : 'sticky-wrapper';
?>

<div class="<?php echo esc_attr($header_classes); ?> style-app">
    <?php
    /**
     * Hook - top bar header
     * Not use with this
     * 
     * do_action('nasa_topbar_header_mobile');
     */
    ?>
    <div class="<?php echo esc_attr($class_sticky); ?>">
        <div id="masthead" class="site-header">
            
            <!-- Icons Left -->
            <div class="mini-icon-mobile left-icons elements-wrapper rtl-text-right nasa-flex">
                <?php echo elessi_back_history(); ?>
                
                <?php if (!$single_product) : ?>
                    <a href="javascript:void(0);" class="nasa-icon nasa-mobile-menu_toggle mobile_toggle nasa-mobile-menu-icon pe-7s-menu fs-30" rel="nofollow"></a>
                <?php endif; ?>
            </div>
            
            <!-- Logo -->
            <div class="logo-wrapper elements-wrapper text-center nasa-min-height">
                <?php echo !$single_product ? elessi_logo() : ''; ?>
            </div>

            <!-- Icons Right -->
            <div class="right-icons elements-wrapper text-right rtl-text-left">
                <?php
                /**
                 * Cart | Login - Register
                 */
                echo elessi_header_icons_mobile_app(); ?>
            </div>
        </div>
    </div>
</div>

<?php if (!$single_product) : ?>
    <!-- Menu site -->
    <div class="hidden-tag">
        <?php
        elessi_get_main_menu();
        if ($vertical) :
            elessi_get_vertical_menu();
        endif;
        ?>
    </div>
<?php
endif;
