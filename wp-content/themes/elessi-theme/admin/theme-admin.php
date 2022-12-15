<?php
defined('ABSPATH') or die();

define('ELESSI_ADMIN_PATH', ELESSI_THEME_PATH . '/admin/');
define('ELESSI_ADMIN_DIR_URI', ELESSI_THEME_URI . '/admin/');

/**
 * List Plugins
 */
function elessi_list_required_plugins() {
    return array(
        array(
            'name' => esc_html__('WPBakery Page Builder', 'elessi-theme'),
            'slug' => 'js_composer',
            'source' => ELESSI_ADMIN_PATH . 'plugins/js_composer.zip',
            'version' => '6.10.0',
            'auto' => true,
            'unchecked' => true
        ),
        
        array(
            'name' => esc_html__('Elementor', 'elessi-theme'),
            'slug' => 'elementor',
            'auto' => true,
            'unchecked' => true
        ),
        
        array(
            'name' => esc_html__('Elementor - Header, Footer & Blocks', 'elessi-theme'),
            'slug' => 'header-footer-elementor',
            'auto' => true,
            'unchecked' => true
        ),
        
        array(
            'name' => esc_html__('YITH WooCommerce Compare', 'elessi-theme'),
            'slug' => 'yith-woocommerce-compare',
            'auto' => true
        ),
        
        array(
            'name' => esc_html__('Contact Form 7', 'elessi-theme'),
            'slug' => 'contact-form-7',
            'auto' => true
        ),
        
        array(
            'name' => esc_html__('Smash Balloon Instagram Feed', 'elessi-theme'),
            'slug' => 'instagram-feed',
            'auto' => true
        ),
        
        array(
            'name' => esc_html__('Revolution Slider', 'elessi-theme'),
            'slug' => 'revslider',
            'source' => ELESSI_ADMIN_PATH . 'plugins/revslider.zip',
            'version' => '6.6.7',
            'auto' => true
        ),
        
        array(
            'name' => esc_html__('WooCommerce', 'elessi-theme'),
            'slug' => 'woocommerce',
            'required' => true,
            'auto' => true
        ),
        
        array(
            'name' => esc_html__('Nasa Core', 'elessi-theme'),
            'slug' => 'nasa-core',
            'source' => ELESSI_ADMIN_PATH . 'plugins/nasa-core_v5.0.0.zip',
            'required' => true,
            'version' => '5.0.0',
            'auto' => true
        ),
    );
}

/**
 * Required Plugins use in theme
 * 
 * In Admin
 */
require_once ELESSI_ADMIN_PATH . 'classes/class-tgm-plugin-activation.php';
add_action('tgmpa_register', 'elessi_register_required_plugins');
function elessi_register_required_plugins() {
    $plugins = elessi_list_required_plugins();
    $config = array(
        'domain' => 'elessi-theme', // Text domain - likely want to be the same as your theme.
        'default_path' => '', // Default absolute path to pre-packaged plugins
        'parent_slug' => 'themes.php', // Default parent menu slug
        'menu' => 'install-required-plugins', // Menu slug
        'has_notices' => true, // Show admin notices or not
        'is_automatic' => false, // Automatically activate plugins after installation or not
        'message' => '', // Message to output right before the plugins table
    );

    tgmpa($plugins, $config);
}

/**
 * Update VC
 */
if (function_exists('vc_set_as_theme')) {
    add_action('vc_before_init', 'elessi_vc_set_as_theme');
    function elessi_vc_set_as_theme() {
        vc_set_as_theme();
    }
}

/*
 * Title	: SMOF
 * Description	: Slightly Modified Options Framework
 * Version	: 1.5.2
 * Author	: Syamil MJ
 * Author URI	: http://aquagraphite.com
 * License	: GPLv3 - http://www.gnu.org/copyleft/gpl.html

 * define( 'SMOF_VERSION', '1.5.2' );
 * Definitions
 *
 * @since 1.4.0
 */
$smof_output = '';
if (function_exists('wp_get_theme')) {
    if (is_child_theme()) {
        $temp_obj = wp_get_theme();
        $theme_obj = wp_get_theme($temp_obj->get('Template'));
    } else {
        $theme_obj = wp_get_theme();
    }

    $theme_name = $theme_obj->get('Name');
} else {
    $theme_data = wp_get_theme(ELESSI_THEME_PATH . '/style.css');
    $theme_name = $theme_data['Name'];
}

define('ELESSI_ADMIN_THEMENAME', $theme_name);
// define('ELESSI_ADMIN_SUPPORT_FORUMS', 'https://elessi.nasatheme.com/documentation/');
define('ELESSI_ADMIN_SUPPORT_FORUMS', 'https://elessi-docs.nasatheme.com');

define('ELESSI_ADMIN_BACKUPS', 'backups');

/**
 * Functions Load
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */
require_once ELESSI_ADMIN_PATH . 'dynamic-style.php';
require_once ELESSI_ADMIN_PATH . 'functions/functions.interface.php';
require_once ELESSI_ADMIN_PATH . 'functions/functions.options.php';
require_once ELESSI_ADMIN_PATH . 'functions/functions.admin.php';

add_action('admin_head', 'optionsframework_admin_message');
add_action('admin_init', 'optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');

/**
 * Required Files
 *
 * @since 1.0.0
 */
require_once ELESSI_ADMIN_PATH . 'classes/class.options_machine.php';

/**
 * AJAX Saving Options
 *
 * @since 1.0.0
 */
add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');

/**
 * Add editor style
 */
// add_editor_style();

/**
 * IMPORTER
 */
if ('imported' !== get_option('nasatheme_imported', '')) {
    require_once ELESSI_ADMIN_PATH . 'importer/nasa-importer.php';
}

/**
 * Images in review product
 */
add_action('add_meta_boxes_comment', 'elessi_admin_review_images_comment', 10, 1);
function elessi_admin_review_images_comment($comment) {
    global $nasa_opt;
    
    if (!isset($nasa_opt['comment_media']) || !$nasa_opt['comment_media']) {
        return;
    }
        
    $attachment_ids = get_comment_meta($comment->comment_ID, 'nasa_review_images', true);
    
    if (!empty($attachment_ids)) : ?>
        <div class="stuffbox">
            <div class="inside">
                <h2><?php echo esc_html__('Review Product By Images'); ?></h2>
                
                <div class="nasa-wrap-review-thumb nasa-flex" id="nasa-wrap-review-<?php echo esc_attr($comment->comment_ID); ?>">

                    <?php foreach ($attachment_ids as $attachment_id) :
                        $image = wp_get_attachment_image($attachment_id, apply_filters('nasa_reivew_product_thumbnail_size', 'thumbnail'), false, array('class' => 'skip-lazy attachment-thumbnail size-thumbnail')); ?>
                        <div class="nasa-item-review-thumb">
                            <?php echo apply_filters('nasa_reivew_product_thumbnail_html', $image, $attachment_id); ?>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
    <?php
    endif;
}

// wp_delete_comment();