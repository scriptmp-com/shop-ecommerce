<div
    class="main-image-slider nasa-slick-slider nasa-slick-nav"
    data-columns="<?php echo esc_attr($show_images); ?>"
    data-columns-small="<?php echo esc_attr($show_images); ?>"
    data-columns-tablet="<?php echo esc_attr($show_images); ?>"
    data-items="<?php echo esc_attr($show_images); ?>"
    data-autoplay="false"
    data-delay="6000"
    data-height-auto="false"
    data-dot="false">
    <?php
    /**
     * Main image
     */
    echo $imageMain;
    
    /**
     * Gallry Images
     */
    if (count($attachment_ids)) :
        foreach ($attachment_ids as $attachment_id) :
            echo wp_get_attachment_image($attachment_id, apply_filters('woocommerce_gallery_image_size', 'woocommerce_single'));
        endforeach;
    endif;
    ?>
</div>
