<?php
defined('ABSPATH') || exit;

$attachment_ids = get_comment_meta($comment->comment_ID, 'nasa_review_images', true);

if (!empty($attachment_ids)) : ?>
    <div class="nasa-wrap-review-thumb nasa-flex" id="nasa-wrap-review-<?php echo esc_attr($comment->comment_ID); ?>">
        
        <?php foreach ($attachment_ids as $attachment_id) :
            $image = wp_get_attachment_image($attachment_id, apply_filters('nasa_reivew_product_thumbnail_size', 'thumbnail'), false, array('class' => 'skip-lazy attachment-thumbnail size-thumbnail'));
            $url = wp_get_attachment_image_url($attachment_id, 'full');
            ?>
            <a title="<?php echo esc_attr__('Review Product by Images', 'elessi-theme'); ?>" class="nasa-item-review-thumb" href="<?php echo esc_url($url); ?>">
                <?php echo apply_filters('nasa_reivew_product_thumbnail_html', $image, $attachment_id); ?>
            </a>
        <?php endforeach; ?>

    </div>
<?php
endif;
