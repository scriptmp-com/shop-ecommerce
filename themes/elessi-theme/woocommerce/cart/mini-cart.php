<?php
/**
 * Mini-cart
 * 
 * @author  NasaTheme
 * @package Elessi-theme/WooCommerce
 * @version 5.2.0
 */

if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

global $nasa_opt;

do_action('woocommerce_before_mini_cart');

if (!WC()->cart->is_empty()) :
    $cart_items = WC()->cart->get_cart();
    ?>
    <div class="nasa-minicart-items">
        <div class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
            <?php
            do_action('woocommerce_before_mini_cart_contents');

            foreach ($cart_items as $cart_item_key => $cart_item) :
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) :
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    
                    <div class="nasa-flex align-start mini-cart-item woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>">
                        <div class="nasa-image-cart-item">
                            <?php echo $thumbnail; ?>
                        </div>

                        <div class="nasa-info-cart-item padding-left-15 rtl-padding-left-0 rtl-padding-right-15">
                            <div class="mini-cart-info">
                                <div class="nasa-flex jbw align-start">
                                    <?php if (empty($product_permalink)) : ?>
                                        <span class="product-name nasa-bold"><?php echo wp_kses_post($product_name); ?></span>
                                    <?php else : ?>
                                        <a class="product-name nasa-bold" href="<?php echo esc_url($product_permalink); ?>" title="<?php echo esc_attr($product_name); ?>">
                                            <?php echo wp_kses_post($product_name); ?>
                                        </a>
                                    <?php endif; ?>

                                    <span class="product-remove">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove remove_from_cart_button item-in-cart nasa-stclose small" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s" title="%s">%s</a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                esc_attr__('Remove', 'elessi-theme'),
                                                esc_attr($product_id),
                                                esc_attr($cart_item_key),
                                                esc_attr($_product->get_sku()),
                                                esc_html__('Remove', 'elessi-theme'),
                                                esc_attr__('Remove', 'elessi-theme')
                                            ), $cart_item_key);
                                        ?>
                                    </span>
                                </div>

                                <?php echo wc_get_formatted_cart_item_data($cart_item); ?>
                                
                                <?php
                                if ($product_price) :
                                    echo '<div class="nasa-flex jbw align-start mini-cart-item-price margin-top-5">';
                                
                                    $wrap = false;
                                    $quantily_show = true;
                                    
                                    if ((!isset($nasa_opt['mini_cart_qty']) || $nasa_opt['mini_cart_qty'])) :
                                        $quantily_show = false;
                                        
                                        if ($_product->is_sold_individually()) :
                                            $product_quantity = sprintf('<input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                        else :
                                            $wrap = true;
                                            $product_quantity = woocommerce_quantity_input(
                                                array(
                                                    'input_name'   => 'cart[' . $cart_item_key . '][qty]',
                                                    'input_value'  => $cart_item['quantity'],
                                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                                    'min_value'    => '0',
                                                    'product_name' => wp_kses_post($product_name)
                                                ),
                                                $_product,
                                                false
                                            );
                                        endif;
                                        
                                        echo $wrap ? '<div class="quantity-wrap nasa-flex flex-wrap">' : '';
                                        
                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                    endif;

                                    echo apply_filters('woocommerce_widget_cart_item_quantity', '<div class="cart_list_product_quantity">' . ($quantily_show ? sprintf('%s &times; %s', $cart_item['quantity'], $product_price) : sprintf('&times; %s', $product_price)) . '</div>', $cart_item, $cart_item_key);

                                    echo $wrap ? '</div>' : '';
                                    
                                    /**
                                     * Sub Total
                                     */
                                    if ((!isset($nasa_opt['mini_cart_subtotal']) || $nasa_opt['mini_cart_subtotal'])) :
                                        echo '<div class="mini-cart-item-subtotal nasa-bold margin-left-10 rtl-margin-left-0 rtl-margin-right-10">';
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                        echo '</div>';
                                    endif;
                                    
                                    echo '</div>';
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                endif;
            endforeach;

            do_action('woocommerce_mini_cart_contents');
            ?>
        </div>
    </div>
    
    <div class="nasa-minicart-footer">
        <?php do_action('nasa_mini_cart_before_total'); ?>
        
        <div class="minicart_total_checkout woocommerce-mini-cart__total total">
            <?php
            /**
             * Woocommerce_widget_shopping_cart_total hook.
             *
             * @removed woocommerce_widget_shopping_cart_subtotal - 10
             * @hooked elessi_widget_shopping_cart_subtotal - 10
             * @hooked elessi_subtotal_free_shipping - 20
             */
            do_action('woocommerce_widget_shopping_cart_total');
            ?>
        </div>
        <div class="btn-mini-cart inline-lists text-center">
            <?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

            <p class="woocommerce-mini-cart__buttons buttons">
                <?php do_action('woocommerce_widget_shopping_cart_buttons'); ?>
            </p>

            <?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
        </div>
    </div>
<?php
/**
 * Empty cart
 */
else :
    $icon_class = elessi_mini_cart_icon();
    $target_shop = apply_filters('nasa_target_return_shop', 'javascript:void(0);');
    echo '<p class="empty woocommerce-mini-cart__empty-message"><i class="nasa-empty-icon ' . $icon_class . '"></i>' . esc_html__('No products in the cart.', 'elessi-theme') . '<a href="' . esc_attr($target_shop) . '" class="button nasa-sidebar-return-shop" rel="nofollow">' . esc_html__('RETURN TO SHOP', 'elessi-theme') . '</a></p>';
endif;

do_action('woocommerce_after_mini_cart');
