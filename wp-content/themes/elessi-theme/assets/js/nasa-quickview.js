/**
 * global nasa_params_quickview
 */
if (typeof _single_variations === 'undefined') {
    var _single_variations = [];
}

var _quicked_gallery = true,
    _nasa_calling_gallery = 0,
    // _nasa_calling_countdown = 0,
    _lightbox_variations,
    _qv_img_loaded,
    nasa_quick_viewimg = false,
    quickview_html = [],
    setMaxHeightQVPU;

/**
 * Document Ready !!!
 */
jQuery(document).ready(function($) {
    "use strict";
    
    var _nasa_in_mobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    /**
     * Open Quickview Popup
     */
    $('body').on('quickview_popup_open', function(e, _wrap) {
        e.preventDefault();
        
        var _src_check = $('.product-lightbox .nasa-product-gallery-lightbox').attr('data-o_href');
                                
        if (typeof _qv_img_loaded !== 'undefined') {
            clearInterval(_qv_img_loaded);
        }

        _qv_img_loaded = setInterval(function() {
            var _img_check = new Image();
            _img_check.src = _src_check;

            if (
                _img_check.complete &&
                typeof _img_check.naturalWidth !== "undefined" &&
                _img_check.naturalWidth !== 0
            ) {
                $.magnificPopup.open({
                    mainClass: 'my-mfp-zoom-in',
                    items: {
                        src: '#nasa-quickview-popup',
                        type: 'inline'
                    },
                    closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
                    callbacks: {
                        beforeClose: function() {
                            this.st.removalDelay = 350;
                        },
                        afterClose: function() {
                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }
                    }
                });
                
                if ($(_wrap).length) {
                    $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                }
                
                $('body').trigger('nasa_after_quickview_timeout');
                
                clearInterval(_qv_img_loaded);
            }
        }, 10);
    });
    
    /**
     * Quick view
     */
    $('body').on('click', '.quick-view', function(e) {
        $.magnificPopup.close();
        
        nasa_quick_viewimg = true;
        
        if ($('.nasa-close-notice').length) {
            $('.nasa-close-notice').trigger('click');
        }
        
        /**
         * Append stylesheet Off Canvas
         */
        $('body').trigger('nasa_append_style_off_canvas');

        if (
            typeof nasa_params_quickview !== 'undefined' &&
            typeof nasa_params_quickview.wc_ajax_url !== 'undefined'
        ) {
            var _urlAjax = nasa_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quick_view');
            var _this = $(this);
            var _product_type = $(_this).attr('data-product_type');

            if (_product_type === 'woosb' && typeof $(_this).attr('data-href') !== 'undefined') {
                window.location.href = $(_this).attr('data-href');
            }

            else {
                var _wrap = $(_this).parents('.product-item'),
                    product_id = $(_this).attr('data-prod'),
                    _wishlist = ($(_this).attr('data-from_wishlist') === '1') ? '1' : '0';

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.item-product-widget');
                }

                if ($(_wrap).length <= 0) {
                    _wrap = $(_this).parents('.wishlist-item-warper');
                }

                if ($(_wrap).length) {
                    $(_wrap).append('<div class="nasa-light-fog"></div><div class="nasa-loader"></div>');
                }

                var _data = {
                    product: product_id,
                    nasa_wishlist: _wishlist
                };

                if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
                    $('.nasa-value-gets').find('input').each(function() {
                        var _key = $(this).attr('name');
                        var _val = $(this).val();
                        _data[_key] = _val;
                    });
                }

                var sidebar_holder = $('#nasa-quickview-sidebar').length === 1 ? true : false;
                
                if (sidebar_holder && $('#nasa-quickview-sidebar').hasClass('nasa-crazy-load')) {
                    if (!$('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                        $('#nasa-quickview-sidebar').addClass('qv-loading');
                    }
                }

                _data.quickview = sidebar_holder ? 'sidebar' : 'popup';

                var _callAjax = true;

                if (typeof quickview_html[product_id] !== 'undefined') {
                    _callAjax = false;
                }

                if (_callAjax) {
                    $.ajax({
                        url : _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        data: _data,
                        cache: false,
                        beforeSend: function() {
                            if (sidebar_holder) {
                                $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html(
                                    '<div class="nasa-loader"></div>'
                                );
                                $('.black-window').fadeIn(200).addClass('desk-window');
                                $('#nasa-viewed-sidebar').removeClass('nasa-active');

                                if ($('#nasa-quickview-sidebar').length && !$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                                    $('#nasa-quickview-sidebar').addClass('nasa-active');
                                }
                            }

                            if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                                $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                            }

                            if (typeof setMaxHeightQVPU !== 'undefined') {
                                clearInterval(setMaxHeightQVPU);
                            }
                        },
                        success: function(response) {
                            quickview_html[product_id] = response;

                            // Sidebar hoder
                            if (sidebar_holder) {
                                $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox">' + response.content + '</div>');

                                setTimeout(function() {
                                    $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').addClass('nasa-loaded');
                                    $('body').trigger('nasa_after_quickview_timeout');
                                }, 200);
                                
                                setTimeout(function() {
                                    if ($('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                                        $('#nasa-quickview-sidebar').removeClass('qv-loading');
                                    }
                                }, 700);
                                
                                if ($(_wrap).length) {
                                    $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                                }
                            }

                            // Popup classical
                            else {
                                if ($('#nasa-quickview-popup').length < 1) {
                                    $('body').append('<div id="nasa-quickview-popup" class="product-lightbox"></div>');
                                }

                                $('#nasa-quickview-popup').html(response.content);

                                $('.black-window').trigger('quickview_popup_open', [_wrap]);

                                $('.black-window').trigger('click');
                            }

                            /**
                             * Init Gallery image
                             */
                            $('body').trigger('nasa_init_product_gallery_lightbox');

                            if ($(_this).hasClass('nasa-view-from-wishlist')) {
                                $('.wishlist-item').animate({opacity: 1}, 500);
                                
                                if (!sidebar_holder) {
                                    $('.wishlist-close a').trigger('click');
                                }
                            }
                            
                            $('body').trigger('before_init_variations_form');

                            var formLightBox = $('.product-lightbox').find('.variations_form');
                            
                            if ($(formLightBox).length) {
                                $(formLightBox).find('.single_variation_wrap').hide();
                                
                                $(formLightBox).each(function () {
                                    var _form_var = $(this);
                                    $('body').trigger('init_quickview_variations_form', [_form_var]);
                                    
                                    $(_form_var).find('select').trigger('change');
                                
                                    if ($(_form_var).find('.variations select option[selected="selected"]').length) {
                                        $(_form_var).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                                    }
                                });
                            }

                            var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                            if ($(groupLightBox).length) {
                                $(groupLightBox).removeAttr('style');
                                $(groupLightBox).removeClass('wow');
                            }

                            if (!sidebar_holder) {
                                setMaxHeightQVPU = setInterval(function() {
                                    var _h_l = $('.product-lightbox .product-img').outerHeight();

                                    $('.product-lightbox .product-quickview-info').css({
                                        'max-height': _h_l,
                                        'overflow-y': 'auto'
                                    });

                                    if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                        $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                                    }

                                    if (_nasa_in_mobile) {
                                        clearInterval(setMaxHeightQVPU);
                                    }
                                }, 1000);
                            }

                            $('body').trigger('nasa_after_quickview');
                        }
                    });
                } else {
                    var quicview_obj = quickview_html[product_id];

                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html(
                            '<div class="nasa-loader"></div>'
                        );
                        $('.black-window').fadeIn(200).addClass('desk-window');
                        $('#nasa-viewed-sidebar').removeClass('nasa-active');

                        if ($('#nasa-quickview-sidebar').length && !$('#nasa-quickview-sidebar').hasClass('nasa-active')) {
                            $('#nasa-quickview-sidebar').addClass('nasa-active');
                        }
                    }

                    if ($('.nasa-static-wrap-cart-wishlist').length && $('.nasa-static-wrap-cart-wishlist').hasClass('nasa-active')) {
                        $('.nasa-static-wrap-cart-wishlist').removeClass('nasa-active');
                    }

                    if (typeof setMaxHeightQVPU !== 'undefined') {
                        clearInterval(setMaxHeightQVPU);
                    }

                    // Sidebar hoder
                    if (sidebar_holder) {
                        $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content').html('<div class="product-lightbox hidden-tag">' + quicview_obj.content + '</div>');

                        setTimeout(function() {
                            $('#nasa-quickview-sidebar #nasa-quickview-sidebar-content .product-lightbox').show();
                            $('body').trigger('nasa_after_quickview_timeout');
                        }, 200);
                        
                        setTimeout(function() {
                            if ($('#nasa-quickview-sidebar').hasClass('qv-loading')) {
                                $('#nasa-quickview-sidebar').removeClass('qv-loading');
                            }
                        }, 700);
                        
                        if ($(_wrap).length) {
                            $(_wrap).find('.nasa-loader, .color-overlay, .nasa-dark-fog, .nasa-light-fog').remove();
                        }
                    }

                    // Popup classical
                    else {
                        if ($('#nasa-quickview-popup').length < 1) {
                            $('body').append('<div id="nasa-quickview-popup" class="product-lightbox"></div>');
                        }

                        $('#nasa-quickview-popup').html(quicview_obj.content);

                        $('.black-window').trigger('quickview_popup_open', [_wrap]);

                        $('.black-window').trigger('click');
                    }

                    /**
                     * Init Gallery image
                     */
                    $('body').trigger('nasa_init_product_gallery_lightbox');

                    if ($(_this).hasClass('nasa-view-from-wishlist')) {
                        $('.wishlist-item').animate({opacity: 1}, 500);
                        if (!sidebar_holder) {
                            $('.wishlist-close a').trigger('click');
                        }
                    }
                    
                    $('body').trigger('before_init_variations_form');

                    var formLightBox = $('.product-lightbox').find('.variations_form');

                    if ($(formLightBox).length) {
                        $(formLightBox).find('.single_variation_wrap').hide();

                        $(formLightBox).each(function () {
                            var _form_var = $(this);
                            $('body').trigger('init_quickview_variations_form', [_form_var]);

                            $(_form_var).find('select').trigger('change');

                            if ($(_form_var).find('.variations select option[selected="selected"]').length) {
                                $(_form_var).find('.variations .reset_variations').css({'visibility': 'visible'}).show();
                            }
                        });
                    }

                    var groupLightBox = $('.product-lightbox').find('.woocommerce-grouped-product-list-item');
                    if ($(groupLightBox).length) {
                        $(groupLightBox).removeAttr('style');
                        $(groupLightBox).removeClass('wow');
                    }

                    if (!sidebar_holder) {
                        setMaxHeightQVPU = setInterval(function() {
                            var _h_l = $('.product-lightbox .product-img').outerHeight();

                            $('.product-lightbox .product-quickview-info').css({
                                'max-height': _h_l,
                                'overflow-y': 'auto'
                            });

                            if (!$('.product-lightbox .product-quickview-info').hasClass('nasa-active')) {
                                $('.product-lightbox .product-quickview-info').addClass('nasa-active');
                            }

                            if (_nasa_in_mobile) {
                                clearInterval(setMaxHeightQVPU);
                            }
                        }, 1000);
                    }

                    $('body').trigger('nasa_after_quickview');
                }
            }
        }

        e.preventDefault();
    });
    
    $('body').on('init_quickview_variations_form', function(e, formLightBox) {
        e.preventDefault();
        
        if ($(formLightBox).length) {
        
            $(formLightBox).wc_variation_form();
            $(formLightBox).nasa_quickview_variation_form();

            $('body').trigger('nasa_init_ux_variation_form');
        }
    });
    
    $.fn.nasa_quickview_variation_form = function() {
        return this.each(function() {
            var _form = $(this);
            
            $(_form).on('found_variation', function(e, variation) {
                e.preventDefault();
                var _this_form = $(this);
                
                // SKU
                var _sku = $(_this_form).parents('.product-info').find('.product_meta .sku');
                if ($(_sku).length) {
                    if (variation.sku) {
                        set_sku_content($, _sku, variation.sku);
                    } else {
                        reset_sku_content($, _sku);
                    }
                }
                
                if (!$(_this_form).hasClass('variations_form-3rd')) {
                    if ($(_this_form).find('.nasa-gallery-variation-supported').length) {
                        change_gallery_variable_quickview($, _this_form, variation);
                    } else {
                        setTimeout(function() {
                            change_image_variable_quickview($, _this_form, variation);
                        }, 10);
                    }
                }
            }).on('reset_data', function(e) {
                e.preventDefault();
                var _this_form = $(this);
                
                // SKU
                var _sku = $(_this_form).parents('.product-info').find('.product_meta .sku');
                if ($(_sku).length) {
                    reset_sku_content($, _sku);
                }
                
                if (!$(_this_form).hasClass('variations_form-3rd')) {
                    if ($(_this_form).find('.nasa-gallery-variation-supported').length) {
                        change_gallery_variable_quickview($, _this_form, null);
                    } else {
                        setTimeout(function() {
                            change_image_variable_quickview($, _this_form, null);
                        }, 10);
                    }
                }
            });
        });
    };

    /**
     * Change gallery for variation - Quick view
     */
    $('body').on('nasa_changed_gallery_variable_quickview', function() {
        $('body').trigger('nasa_load_slick_slider');
    });
    
    /**
     * Init gallery lightbox
     */
    $('body').on('nasa_init_product_gallery_lightbox', function() {
        if ($('.product-lightbox').find('.nasa-product-gallery-lightbox').length) {
            _lightbox_variations[0] = {
                'quickview_gallery': $('.product-lightbox').find('.nasa-product-gallery-lightbox').html()
            };
        }
    });
    
    /**
     * After Close Fog Window
     */
    $('body').on('nasa_after_close_fog_window', function() {
        if ($('#nasa-quickview-popup.product-lightbox').length < 1) {
            nasa_quick_viewimg = false;
        }
    });
    
    /**
     * Btn add to cart select option to quick view
     */
    $('body').on('click', '.ajax_add_to_cart_variable', function(){
        if ($(this).parent().find('.quick-view').length) {
            $(this).parent().find('.quick-view').trigger('click');
            
            return false;
        } else {
            return;
        }
    });
    
    /**
     * Support for YITH Booking and Appointment for WooCommerce Premium
     */
    $('body').on('nasa_after_quickview', function() {
        $('body').trigger('yith-wcbk-init-booking-form');
        $('body').trigger('yith-wcbk-init-fields:selector');
        $('body').trigger('yith-wcbk-init-fields:help-tip');
        $('body').trigger('yith-wcbk-init-fields:select-list');
    });
});

/**
 * Support for Quick-view
 */
var _timeout_quickviewGallery;
var _prev_qv_image_id = 0;
function change_gallery_variable_quickview($, _form, variation) {
    var _crazy = true;
    if (_prev_qv_image_id && variation && variation.image_id) {
        _crazy = _prev_qv_image_id === variation.image_id ? false : true;
    }
    
    /**
     * Change galleries images
     */
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            _quicked_gallery = false;
            
            if (typeof _lightbox_variations[variation.variation_id] === 'undefined') {
                if (
                    typeof nasa_params_quickview !== 'undefined' &&
                    typeof nasa_params_quickview.wc_ajax_url !== 'undefined'
                ) {
                    var _urlAjax = nasa_params_quickview.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quickview_gallery_variation');
                    
                    _nasa_calling_gallery = 1;

                    var _data = {
                        'variation_id': variation.variation_id,
                        'is_purchasable': variation.is_purchasable,
                        'is_in_stock': variation.is_in_stock,
                        'main_id': typeof variation.image_id !== 'undefined' ? variation.image_id : 0,
                        'gallery': typeof variation.nasa_gallery_variation !== 'undefined' ?
                            variation.nasa_gallery_variation : [],
                        'show_images': $('.product-lightbox').find('.main-image-slider').attr('data-items')
                    };

                    $.ajax({
                        url: _urlAjax,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        data: {
                            data: _data
                        },
                        beforeSend: function () {
                            if (!$(_form).hasClass('nasa-processing')) {
                                $(_form).addClass('nasa-processing');
                            }

                            // $('.nasa-quickview-product-deal-countdown').html('');
                            // $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');

                            if (_crazy) {
                                if ($('#nasa-quickview-sidebar.nasa-crazy-load').length) {
                                    if (!$('.nasa-product-gallery-lightbox').hasClass('crazy-loading')) {
                                        $('.nasa-product-gallery-lightbox').addClass('crazy-loading');
                                    }
                                } else {
                                    if ($('.nasa-product-gallery-lightbox').find('.nasa-loading').length <= 0) {
                                        $('.nasa-product-gallery-lightbox').append('<div class="nasa-loading"></div>');
                                    }

                                    if ($('.nasa-product-gallery-lightbox').find('.nasa-loader').length <= 0) {
                                        $('.nasa-product-gallery-lightbox').append('<div class="nasa-loader" style="top:45%"></div>');
                                    }
                                }
                            }

                            $('.nasa-product-gallery-lightbox').css({'min-height': $('.nasa-product-gallery-lightbox').outerHeight()});
                        },
                        success: function (result) {
                            _nasa_calling_gallery = 0;

                            $(_form).removeClass('nasa-processing');

                            _lightbox_variations[variation.variation_id] = result;

                            /**
                             * Main image
                             */
                            if (typeof result.quickview_gallery !== 'undefined') {
                                $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                            }

                            if (typeof _timeout_quickviewGallery !== 'undefined') {
                                clearTimeout(_timeout_quickviewGallery);
                            }

                            _timeout_quickviewGallery = setTimeout(function (){
                                $('.nasa-product-gallery-lightbox').find('.nasa-loading, .nasa-loader').remove();
                                $('.nasa-product-gallery-lightbox').css({'min-height': 'auto'});
                                $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                            }, 200);

                            /**
                             * Trigger after changed gallery
                             */
                            $('body').trigger('nasa_changed_gallery_variable_quickview');
                        },
                        error: function() {
                            _nasa_calling_gallery = 0;
                            $(_form).removeClass('nasa-processing');
                            $('.nasa-product-gallery-lightbox').find('.nasa-loading, .nasa-loader').remove();
                            $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                        }
                    });
                }
            } else {
                var result = _lightbox_variations[variation.variation_id];

                /**
                 * Main image
                 */
                if (typeof result.quickview_gallery !== 'undefined') {
                    if (_crazy) {
                        if ($('#nasa-quickview-sidebar.nasa-crazy-load').length) {
                            if (!$('.nasa-product-gallery-lightbox').hasClass('crazy-loading')) {
                                $('.nasa-product-gallery-lightbox').addClass('crazy-loading');
                            }
                        } else {
                            if ($('.nasa-product-gallery-lightbox').find('.nasa-loading').length <= 0) {
                                $('.nasa-product-gallery-lightbox').append('<div class="nasa-loading"></div>');
                            }

                            if ($('.nasa-product-gallery-lightbox').find('.nasa-loader').length <= 0) {
                                $('.nasa-product-gallery-lightbox').append('<div class="nasa-loader" style="top:45%"></div>');
                            }
                        }
                    }

                    $('.nasa-product-gallery-lightbox').css({'min-height': $('.nasa-product-gallery-lightbox').height()});

                    $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
                    if (typeof _timeout_quickviewGallery !== 'undefined') {
                        clearTimeout(_timeout_quickviewGallery);
                    }

                    _timeout_quickviewGallery = setTimeout(function() {
                        $('.nasa-product-gallery-lightbox').find('.nasa-loader, .nasa-loading').remove();
                        $('.nasa-product-gallery-lightbox').removeClass('crazy-loading');
                        $('.nasa-product-gallery-lightbox').css({'min-height': 'auto'});
                    }, 100);
                }

                _nasa_calling_gallery = 0;

                /**
                 * Trigger after changed gallery
                 */
                $('body').trigger('nasa_changed_gallery_variable_quickview');
            }
        }
    }
    
    /**
     * Default
     */
    else {
        if(!_quicked_gallery && typeof _lightbox_variations[0] !== 'undefined') {
            _quicked_gallery = true;
            var result = _lightbox_variations[0];

            /**
             * Main image
             */
            if(typeof result.quickview_gallery !== 'undefined') {
                $('.nasa-product-gallery-lightbox').find('.main-image-slider').replaceWith(result.quickview_gallery);
            }
            
            /**
             * Trigger after changed gallery
             */
            $('body').trigger('nasa_changed_gallery_variable_quickview');
        }
    }
    
    _prev_qv_image_id = variation && variation.image_id ? variation.image_id : null;
    
    /**
     * deal time
     */
    if ($('.nasa-quickview-product-deal-countdown').length) {
        $('.nasa-quickview-product-deal-countdown').html('');
        $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                            
        if (variation && variation.variation_id && variation.is_in_stock && variation.is_purchasable) {
            var now = Date.now();
            
            if (typeof variation.deal_time !== 'undefined' && variation.deal_time && variation.deal_time.html && variation.deal_time.to > now) {
                $('.nasa-quickview-product-deal-countdown').html(variation.deal_time.html);
                $('body').trigger('nasa_load_countdown');
                if(!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                    $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                }
            }
        }
    }
}

/**
 * Change image variable Single product
 * 
 * @param {type} $
 * @param {type} _form
 * @param {type} variation
 * @returns {undefined}
 */
function change_image_variable_quickview($, _form, variation) {
    /**
     * Change gallery for single product variation
     */
    if (variation && variation.image && variation.image.src && variation.image.src.length > 1) {
        var _countSelect = $(_form).find('.variations .value select').length;
        var _selected = 0;
        if (_countSelect) {
            $(_form).find('.variations .value select').each(function() {
                if ($(this).val() !== '') {
                    _selected++;
                }
            });
        }

        if (_countSelect && _selected === _countSelect) {
            var src_thumb = false;

            /**
             * Support Bundle product
             */
            if ($('.product-lightbox .woosb-product').length) {
                if (variation.image.thumb_src !== 'undefined' || variation.image.gallery_thumbnail_src !== 'undefined') {
                    src_thumb = variation.image.gallery_thumbnail_src ? variation.image.gallery_thumbnail_src :  variation.image.thumb_src;
                }

                if (src_thumb) {
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').html('<img src="' + src_thumb + '" />');
                    $(_form).parents('.woosb-product').find('.woosb-thumb-ori').hide();
                    $(_form).parents('.woosb-product').find('.woosb-thumb-new').show();
                }
            }

            else {
                var _src_large = typeof variation.image_single_page !== 'undefined' ?
                    variation.image_single_page : variation.image.url;

                $('.main-image-slider img.nasa-first').attr('src', _src_large).removeAttr('srcset');
            }
        }

    } else {
        /**
         * Support Bundle product
         */
        if ($('.product-lightbox .woosb-product').length) {
            $(_form).parents('.woosb-product').find('.woosb-thumb-ori').show();
            $(_form).parents('.woosb-product').find('.woosb-thumb-new').hide();
        } else {
            var image_large = $('.nasa-product-gallery-lightbox').attr('data-o_href');
            $('.main-image-slider img.nasa-first').attr('src', image_large).removeAttr('srcset');
        }
    }
    
    if ($('body').hasClass('nasa-focus-main-image')) {
        var _main_slide = $('.main-image-slider');
        $('body').trigger('slick_go_to_0', [_main_slide]);
    }

    /**
     * deal time
     */
    if ($('.nasa-quickview-product-deal-countdown').length) {
        
        $('.nasa-quickview-product-deal-countdown').html('');
        $('.nasa-quickview-product-deal-countdown').removeClass('nasa-show');
                            
        if (variation && variation.variation_id && variation.is_in_stock && variation.is_purchasable) {
            var now = Date.now();
            
            if (typeof variation.deal_time !== 'undefined' && variation.deal_time && variation.deal_time.html && variation.deal_time.to > now) {
                $('.nasa-quickview-product-deal-countdown').html(variation.deal_time.html);
                $('body').trigger('nasa_load_countdown');
                if(!$('.nasa-quickview-product-deal-countdown').hasClass('nasa-show')) {
                    $('.nasa-quickview-product-deal-countdown').addClass('nasa-show');
                }
            }
        }
    }
}

/**
 * Set Content Sku
 * 
 * @param {type} $
 * @param {type} _sku
 * @param {type} _content
 * @returns {undefined}
 */
function set_sku_content($, _sku, _content) {
    var _ogc = $(_sku).attr('data-o_content');
    if (typeof _ogc === 'undefined') {
        $(_sku).attr('data-o_content', $(_sku).text());
    }
    
    $(_sku).text(_content);
}

/**
 * Reset Content Sku
 * 
 * @param {type} $
 * @param {type} _sku
 * @returns {undefined}
 */
function reset_sku_content($, _sku) {
    var _ogc = $(_sku).attr('data-o_content');
    if (typeof _ogc !== 'undefined') {
        $(_sku).text(_ogc);
    }
}
