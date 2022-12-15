<?php

/**
 * Displayed when no products are found matching the current query
 *
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 2.0.0
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

?>
<p class="woocommerce-info">
    <img src="<?php echo apply_filters('nasa_no_products_found_src', ELESSI_THEME_URI.'/assets/images/not-found-icon.jpg'); ?>" alt="<?php esc_attr_e('Not Found Products', 'elessi-theme');?>" class="not-found-img" width="100" height="115" />
    <img src="<?php echo apply_filters('nasa_no_products_found_src_dark', ELESSI_THEME_URI.'/assets/images/not-found-dark-icon.png'); ?>" alt="<?php esc_attr_e('Not Found Products', 'elessi-theme');?>" class="not-found-img-dark" width="100" height="115" />
    <?php esc_html_e('No products were found matching your selection.', 'elessi-theme' );?>
</p>
