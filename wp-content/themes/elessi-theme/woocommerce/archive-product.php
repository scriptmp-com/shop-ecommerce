<?php
/**
 * Archive Products Page
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 3.4.0
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

/**
 * Before setup shop
 */
do_action('nasa_before_render_shop');

global $nasa_opt;

$nasa_ajax_product = isset($nasa_opt['disable_ajax_product']) && $nasa_opt['disable_ajax_product'] ? false : true;
defined('NASA_AJAX_SHOP') or define('NASA_AJAX_SHOP', $nasa_ajax_product);

$nasa_opt['products_per_row'] = isset($nasa_opt['products_per_row']) && (int) $nasa_opt['products_per_row'] ?
    (int) $nasa_opt['products_per_row'] : 4;
$nasa_opt['products_per_row'] = $nasa_opt['products_per_row'] > 6 || $nasa_opt['products_per_row'] < 2 ? 4 : $nasa_opt['products_per_row'];

$nasa_change_view = !isset($nasa_opt['enable_change_view']) || $nasa_opt['enable_change_view'] ? true : false;

$nasa_sidebar = isset($nasa_opt['category_sidebar']) ? $nasa_opt['category_sidebar'] : 'left-classic';

$hasSidebar = true;
$topSidebar = false;
$topSidebar2 = false;
$topbarWrap_class = 'row filters-container nasa-filter-wrap';
$attr = 'nasa-products-page-wrap ';
$class_wrap_archive = 'row fullwidth category-page nasa-store-page';
switch ($nasa_sidebar):
    case 'right':
    case 'left':
        $attr .= 'large-12 columns has-sidebar';
        break;
    
    case 'right-classic':
        $attr .= 'large-9 medium-12 columns left has-sidebar';
        $class_wrap_archive .= ' nasa-with-sidebar-classic right-classic';
        break;
    
    case 'no':
        $hasSidebar = false;
        $attr .= 'large-12 columns no-sidebar';
        break;
    
    case 'top':
        $hasSidebar = false;
        $topSidebar = true;
        $topbarWrap_class .= ' top-bar-wrap-type-1';
        $attr .= 'large-12 columns no-sidebar top-sidebar';
        $class_wrap_archive .= ' nasa-top-sidebar-style';
        break;
    
    case 'top-2':
        $hasSidebar = false;
        $topSidebar2 = true;
        $topbarWrap_class .= ' top-bar-wrap-type-2';
        $attr .= 'large-12 columns no-sidebar top-sidebar-2';
        break;
    
    case 'left-classic':
    default :
        $attr .= 'large-9 medium-12 columns right has-sidebar';
        $class_wrap_archive .= ' nasa-with-sidebar-classic';
        break;
endswitch;

$nasa_recom_pos = isset($nasa_opt['recommend_product_position']) ? $nasa_opt['recommend_product_position'] : 'bot';

$layout_style = '';
if (isset($nasa_opt['products_layout_style']) && $nasa_opt['products_layout_style'] == 'masonry-isotope') :
    $layout_style = ' nasa-products-masonry-isotope';
    $layout_style .= isset($nasa_opt['products_masonry_mode']) ? ' nasa-mode-' . $nasa_opt['products_masonry_mode'] : '';
endif;

/**
 * Header Shop
 */
get_header('shop');

/**
 * Hook Before Main content
 */
do_action('woocommerce_before_main_content');
?>
<div class="<?php echo esc_attr($class_wrap_archive); ?>">
    <div class="nasa_shop_description-wrap large-12 columns">
        <?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
            <h1 class="woocommerce-products-header__title page-title text-center margin-top-20 margin-bottom-0">
                <?php woocommerce_page_title(); ?>
            </h1>
	<?php endif; ?>
        
        <?php
        /**
         * Hook: woocommerce_archive_description.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action('woocommerce_archive_description');
        ?>
    </div>
    
    <?php
    /**
     * Hook: nasa_before_archive_products.
     */
    do_action('nasa_before_archive_products');
    ?>
    
    <div class="large-12 columns">
        <div class="<?php echo esc_attr($topbarWrap_class); ?>">
            <?php
            /**
             * Top Side bar Type 1
             */
            if ($topSidebar) :
                $topSidebar_wrap = $nasa_change_view ? 'large-10 medium-12 ' : 'large-12 ';

                if (!isset($nasa_opt['showing_info_top']) || $nasa_opt['showing_info_top']) :
                    echo '<div class="showing_info_top hidden-tag">';
                    do_action('nasa_shop_category_count');
                    echo '</div>';
                endif;
                ?>

                <div class="large-12 columns nasa-topbar-filter-wrap">
                    <div class="nasa-flex jbw nasa-topbar-all">
                        <div class="nasa-filter-action nasa-min-height">
                            <div class="nasa-labels-filter-top">
                                <input name="nasa-labels-filter-text" type="hidden" value="<?php echo esc_attr__('Filter by:', 'elessi-theme'); ?>" />
                                <input name="nasa-widget-show-more-text" type="hidden" value="<?php echo esc_attr__('More +', 'elessi-theme'); ?>" />
                                <input name="nasa-widget-show-less-text" type="hidden" value="<?php echo esc_attr__('Less -', 'elessi-theme'); ?>" />
                                <input name="nasa-limit-widgets-show-more" type="hidden" value="<?php echo (!isset($nasa_opt['limit_widgets_show_more']) || (int) $nasa_opt['limit_widgets_show_more'] < 0) ? '2' : (int) $nasa_opt['limit_widgets_show_more']; ?>" />
                                <a class="toggle-topbar-shop-mobile hidden-tag" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i><?php echo esc_attr__('&nbsp;Filters', 'elessi-theme'); ?>
                                </a>
                                <span class="nasa-labels-filter-accordion nasa-flex"></span>
                            </div>
                        </div>
                        
                        <div class="nasa-sort-by-action">
                            <ul class="sort-bar nasa-flex margin-top-0">
                                <li class="nasa-filter-order filter-order">
                                    <?php woocommerce_catalog_ordering(); ?>
                                </li>
                            </ul>
                        </div>
                        
                        <?php if ($nasa_change_view) : ?>
                            <div class="nasa-topbar-change-view-wrap nasa-flex hide-for-medium hide-for-small">
                                <?php
                                /**
                                 * Change view ICONS
                                 */
                                $type_sidebar = (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar') ? 'top-push-cat' : 'no';
                                do_action('nasa_change_view', $type_sidebar); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php
                /**
                 * Sidebar TOP
                 */
                do_action('nasa_top_sidebar_shop');
                
            /**
             * Top Side bar type 2
             */
            elseif ($topSidebar2) :
                ?>
                <div class="large-4 medium-6 small-6 columns nasa-toggle-top-bar rtl-right">
                    <a class="nasa-toggle-top-bar-click" href="javascript:void(0);" rel="nofollow">
                        <?php esc_html_e('Filters', 'elessi-theme'); ?>
                    </a>
                </div>

                <div class="large-4 columns hide-for-medium hide-for-small nasa-change-view-wrap nasa-min-height text-center rtl-right">
                    <?php if ($nasa_change_view) : ?>
                        <?php
                        /**
                         * Change view ICONS
                         */
                        do_action('nasa_change_view'); ?>
                    <?php endif; ?>
                </div>

                <div class="large-4 medium-6 small-6 columns nasa-sort-by-action nasa-clear-none nasa-min-height text-right rtl-right rtl-text-left">
                    <ul class="sort-bar nasa-float-none margin-top-0">
                        <li class="nasa-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
                
                <div class="large-12 columns nasa-top-bar-2-content mobile-padding-top-5 mobile-margin-bottom-20 hidden-tag">
                    <?php do_action('nasa_top_sidebar_shop', '2'); ?>
                </div>
            
            <?php
            /**
             * TOGGLE Side bar in side (Off-Canvas)
             */
            elseif ($hasSidebar && in_array($nasa_sidebar, array('left', 'right'))) : ?>
                <div class="large-4 medium-6 small-6 columns nasa-toggle-layout-side-sidebar">
                    <div class="li-toggle-sidebar">
                        <a class="toggle-sidebar-shop" href="javascript:void(0);" rel="nofollow">
                            <i class="pe-7s-filter"></i><?php esc_html_e('&nbsp;Filters', 'elessi-theme'); ?>
                        </a>
                    </div>
                </div>
                
                <div class="large-4 columns hide-for-medium hide-for-small nasa-change-view-layout-side-sidebar nasa-min-height">
                    <?php
                    if ($nasa_change_view) :
                        /**
                         * Change view ICONS
                         */
                        do_action('nasa_change_view');
                    endif;
                    ?>
                </div>
            
                <div class="large-4 medium-6 small-6 columns nasa-sort-bar-layout-side-sidebar nasa-clear-none nasa-min-height">
                    <ul class="sort-bar nasa-flex je rtl-jst">
                        <li class="nasa-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            
            <?php
            
            /**
             * No | left-classic | right-classic side bar
             */
            else :
                $toggle_sidebar = $hasSidebar && (!isset($nasa_opt['toggle_sidebar_classic']) || $nasa_opt['toggle_sidebar_classic']) ? true : false;
                $first_col = '';
                if (!$toggle_sidebar) :
                    if (!isset($nasa_opt['showing_info_top']) || $nasa_opt['showing_info_top']) :
                        $first_col .= '<div class="showing_info_top">';
                    
                        ob_start();
                        do_action('nasa_shop_category_count');
                        $first_col .= ob_get_clean();
                        
                        $first_col .= '</div>';
                    endif;
                else :
                    $first_col .= '<a href="javascript:void(0);" class="nasa-toogle-sidebar-classic nasa-hide-in-mobile rtl-text-right" rel="nofollow">' . esc_html__('Filters', 'elessi-theme') . '</a>';
                endif;
                
                $second_cl = 'hide-for-medium hide-for-small nasa-change-view-layout-side-sidebar nasa-min-height columns';
                $third_cl = 'nasa-clear-none nasa-sort-bar-layout-side-sidebar columns medium-12 small-12';
                
                $second_cl .= $first_col ? ' large-4' : ' large-6 text-left';
                $third_cl .= $first_col ? ' large-4' : ' large-6';
                
                $sortbarclass = 'sort-bar nasa-flex je rtl-jst';
                $col_class = '';
                if ($nasa_sidebar == 'right-classic') :
                    $sortbarclass = 'sort-bar nasa-flex rtl-je jst';
                    $col_class = ' right';
                    $second_cl .= ' right';
                    $third_cl .= ' right';
                endif;
                ?>
            
                <?php if ($first_col) : ?>
                    <div class="large-4 columns hide-for-medium hide-for-small text-left<?php echo esc_attr($col_class); ?>">
                        <?php echo $first_col; ?>
                    </div>
                <?php endif; ?>
                
                <div class="<?php echo esc_attr($second_cl); ?>">
                    <?php
                    if ($nasa_change_view) :
                        /**
                         * Change view ICONS
                         */
                        do_action('nasa_change_view', $nasa_sidebar);
                    endif;
                    ?>
                </div>
            
                <div class="<?php echo esc_attr($third_cl); ?>">
                    <ul class="<?php echo esc_attr($sortbarclass); ?>">
                        <?php if ($hasSidebar): ?>
                            <li class="li-toggle-sidebar">
                                <a class="toggle-sidebar" href="javascript:void(0);" rel="nofollow">
                                    <i class="pe-7s-filter"></i> <?php esc_html_e('Filters', 'elessi-theme'); ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nasa-filter-order filter-order">
                            <?php woocommerce_catalog_ordering(); ?>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="nasa-archive-product-content nasa-after-clear margin-bottom-40">
        <?php
        if ($topSidebar && (!isset($nasa_opt['top_bar_cat_pos']) || $nasa_opt['top_bar_cat_pos'] == 'left-bar')) :
            $attr .= ' nasa-has-push-cat';
            $class_cat_top = 'nasa-push-cat-filter';
        ?>
            
            <div class="<?php echo esc_attr($class_cat_top); ?>"></div>
        <?php endif; ?>
        
        <div class="<?php echo esc_attr($attr); ?>">

            <?php if ($nasa_recom_pos !== 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) : ?>
                <?php do_action('nasa_recommend_product'); ?>
            <?php endif; ?>

            <div class="nasa-archive-product-warp<?php echo esc_attr($layout_style); ?>">
                <?php
                if (woocommerce_product_loop()) :
                    /**
                     * Before Shop Loop
                     */
                    do_action('woocommerce_before_shop_loop');
                    
                    /**
                     * Content products in shop
                     */
                    if (NASA_WOO_ACTIVED && version_compare(WC()->version, '3.3.0', "<")) :
                        do_action('nasa_archive_get_sub_categories');
                    endif;
                    
                    woocommerce_product_loop_start();
                    do_action('nasa_get_content_products', $nasa_sidebar);
                    woocommerce_product_loop_end();
                    
                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                else :
                    echo '<div class="row"><div class="large-12 columns nasa-archive-no-result">';
                    do_action('woocommerce_no_products_found');
                    echo '</div></div>';
                endif;
                ?>
            </div>
        </div>

        <?php
        /**
         * Sidebar LEFT | RIGHT
         */
        if ($hasSidebar && !$topSidebar && !$topSidebar2) :
            do_action('nasa_sidebar_shop', $nasa_sidebar);
        endif;
        
        ?>
    </div>
    
    <?php if ($nasa_recom_pos == 'bot' && defined('NASA_CORE_ACTIVED') && NASA_CORE_ACTIVED) :?>
        <?php do_action('nasa_recommend_product'); ?>
    <?php endif; ?>
    
    <?php
    /**
     * Ajax enable
     */
    if ($nasa_ajax_product) :
        ?>
        <div class="nasa-has-filter-ajax hidden-tag">
            <?php
            
            /**
             * Base URL
             */
            echo '<input type="hidden" name="nasa_base-url" id="nasa_base-url" value="' . esc_url(home_url('/')) . '" />';
            
            /**
             * Current URL
             */
            echo '<input type="hidden" name="nasa_current-slug" id="nasa_current-slug" value="' . esc_url(elessi_get_origin_url(array('page', 'paged', 'post_type', 'orderby', 'product_cat', 'product_tag'))) . '" />';

            /**
             * Default Sorting
             */
            $default_sort = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', 'menu_order'));
            echo '<input type="hidden" name="nasa_default_sort" id="nasa_default_sort" value="' . esc_attr($default_sort) . '" />';

            /**
             * Render GET to inputs
             */
            if (!empty($_GET)) :
                echo '<div class="hidden-tag nasa-value-gets">';
                foreach ($_GET as $key => $value) :
                    if (!in_array($key, array('add-to-cart'))) :
                        echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr($value) . '" />';
                    endif;
                endforeach;
                echo '</div>';
            endif;
            ?>
        </div>
        <?php
    endif;
    ?>
</div>

<?php
/**
 * Hook After Main content
 */
do_action('woocommerce_after_main_content');

/**
 * Footer Shop
 */
get_footer('shop');
