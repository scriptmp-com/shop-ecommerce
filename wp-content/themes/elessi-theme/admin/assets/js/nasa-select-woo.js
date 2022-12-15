jQuery(document).ready(function($){
    "use strict";
    
    $('body').on('nasa_admin_init_select_woo', function() {
        if ($('select.nasa-ad-select-woo:not(.nasa-inited)').length) {
            $('select.nasa-ad-select-woo:not(.nasa-inited)').each(function() {
                $(this).addClass('nasa-inited');
                $(this).selectWoo();
            });
        }
    });
    
    if ($('select.nasa-ad-select-woo:not(.nasa-inited)').length) {
        $('body').trigger('nasa_admin_init_select_woo');
    }
    
    /* =============== End document ready !!! ================== */
});
