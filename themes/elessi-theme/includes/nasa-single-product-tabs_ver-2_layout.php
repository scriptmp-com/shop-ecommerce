<?php
if (!defined('ABSPATH')) :
    exit; // Exit if accessed directly
endif;

foreach ($tabs as $key => $tab) :
    if (!isset($tab['title']) || !isset($tab['callback'])) :
        continue;
    endif;
    ?>
    
    <div class="row">
        <div class="large-12 columns">
            <div class="nasa-content nasa-content-<?php echo esc_attr($key); ?>" id="nasa-scroll-<?php echo esc_attr($key); ?>">
                <h3 class="nasa-title nasa-crazy-box">
                    <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key); ?>
                </h3>

                <?php
                echo '<div class="nasa-content-panel">';
                call_user_func($tab['callback'], $key, $tab);
                echo '</div>';
                ?>
            </div>
        </div>
    </div>

    <?php
endforeach;
