<?php
/**
 * Header Responsive
 */
?>

<div class="mobile-menu header-responsive">
    <div class="mini-icon-mobile nasa-flex">
        <a href="javascript:void(0);" class="nasa-icon nasa-mobile-menu_toggle mobile_toggle nasa-mobile-menu-icon pe-7s-menu" rel="nofollow"></a>
        <a href="javascript:void(0);" class="nasa-icon icon pe-7s-search mobile-search" rel="nofollow"></a>
    </div>

    <div class="logo-wrapper">
        <?php echo elessi_logo(); ?>
    </div>

    <?php
    echo '<div class="nasa-mobile-icons-wrap mini-icon-mobile">';
    echo elessi_header_icons_mobile();
    echo '</div>';
    ?>
</div>
