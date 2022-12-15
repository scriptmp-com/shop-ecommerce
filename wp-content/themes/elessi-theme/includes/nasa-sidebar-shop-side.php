<?php
/**
 * Sidebar Shop - Side
 * Archive Products page
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

$sidebar_run = 'shop-sidebar';
        
if (is_tax('product_cat')) {
    global $wp_query;
    
    $query_obj = $wp_query->get_queried_object();
    $sidebar_cats = get_option('nasa_sidebars_cats');

    if (isset($sidebar_cats[$query_obj->slug])) {
        $sidebar_run = $query_obj->slug;
    }

    else {
        $nasa_root_term_id = elessi_get_root_term_id();

        if ($nasa_root_term_id) {
            $rootTerm = get_term_by('term_id', $nasa_root_term_id, 'product_cat');
            
            if ($rootTerm && isset($sidebar_cats[$rootTerm->slug])) {
                $sidebar_run = $rootTerm->slug;
            }
        }
    }
}

if (is_active_sidebar($sidebar_run)) :

    switch ($nasa_sidebar) :
        case 'right' :
            $class = 'nasa-side-sidebar nasa-sidebar-right';
            break;

        case 'left-classic' :
            $class = 'large-3 left columns col-sidebar';
            break;

        case 'right-classic' :
            $class = 'large-3 right columns col-sidebar';
            break;

        case 'left' :
        default:
            $class = 'nasa-side-sidebar nasa-sidebar-left';
            break;
    endswitch;
    ?>

    <div class="<?php echo esc_attr($class); ?>">
        <a href="javascript:void(0);" title="<?php echo esc_attr__('Close', 'elessi-theme'); ?>" class="hidden-tag nasa-close-sidebar" rel="nofollow">
            <?php echo esc_html__('Close', 'elessi-theme'); ?>
        </a>
        <div class="nasa-sidebar-off-canvas">
            <?php dynamic_sidebar($sidebar_run); ?>
        </div>
    </div>

<?php
endif;
