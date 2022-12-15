/* Document ready */
jQuery(document).ready(function($) {
"use strict";

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var mini_cart_ext_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var mini_cart_ext_block = function($node) {
    $('body').trigger('nasa_publish_coupon_refresh');
    
    if (!mini_cart_ext_is_blocked($node)) {
        var $color = $('body').hasClass('nasa-dark') ? '#000' : '#fff';
        
        $node.addClass('processing').block({
            message: null,
            overlayCSS: {
                background: $color,
                opacity: 0.6
            }
        });
    }
};

/**
 * Unblock a node after processing is complete.
 *
 * @param {JQuery Object} $node
 */
var mini_cart_ext_unblock = function($node) {
    $node.removeClass('processing').unblock();
    
    if ($node.find('.nasa-close-node').length) {
        $node.find('.nasa-close-node').trigger('click');
    }
    
    $('body').trigger('nasa_publish_coupon_refresh');
};

var mini_cart_ext_url = function(endpoint) {
    return ext_mini_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', endpoint);
};

/**
 * Show mess
 * @param {type} mess
 * @returns {undefined}
 */
var _ext_remove_mess;
var mini_cart_ext_mess = function(mess) {
    $('.ext-mini-cart-wrap .mess-wrap').remove();
    $('.ext-mini-cart-wrap').append('<div class="mess-wrap">' + mess + '</div>');
    
    if (_ext_remove_mess) {
        clearTimeout(_ext_remove_mess);
    }
    
    _ext_remove_mess = setTimeout(function() {
        $('.ext-mini-cart-wrap .mess-wrap').remove();
    }, 5000);
};

$('body').on('nasa_opened_cart_sidebar', function() {
    if (!$('body').hasClass('canvas-on')) {
        $('body').addClass('canvas-on');
    }
    
    $('body').trigger('nasa_load_ext_mini_cart');
});

$('body').on('nasa_after_close_fog_window', function() {
    $('body').removeClass('canvas-on');
});

/**
 * Close Node
 */
$('body').on('click', '.nasa-close-node', function() {
    var _cart = $(this).parents('.nasa-static-sidebar');
    var _node = $(this).parents('.ext-node');
    
    if ($(_cart).length) {
        $(_cart).removeClass('ext-loading');
    }
    
    if ($(_node).length) {
        $(_node).removeClass('active');
    }
    
    $(_cart).find('.ext-nodes-wrap .close-nodes').remove();
});

/**
 * Global Close
 */
$('body').on('click', '.ext-nodes-wrap .close-nodes', function() {
    var _nodes = $(this).parents('.ext-nodes-wrap');
    var _close = $(_nodes).find('.ext-node.active .nasa-close-node');
    
    if ($(_close).length) {
        $(_close).trigger('click');
    }
});

/**
 * Open ext mini cart
 */
$('body').on('click', '.ext-mini-cart', function() {
    var _act = $(this).attr('data-act'),
        _cart = $(this).parents('.nasa-static-sidebar');
        
    if ($(_cart).find('.ext-mini-cart-wrap').length && !$(_cart).find('.ext-mini-cart-wrap').hasClass('nasa-disable')) {
        
        if (!$('body').hasClass('canvas-on')) {
            $('body').addClass('canvas-on');
        }

        if (!$(_cart).hasClass('ext-loading')) {
            $(_cart).addClass('ext-loading');
        }

        if ($(_cart).find('.ext-nodes-wrap').length < 1) {
            $(_cart).append('<div class="ext-nodes-wrap"></div>');
        }
        
        if ($(_cart).find('.ext-nodes-wrap .close-nodes').length < 1) {
            $(_cart).find('.ext-nodes-wrap').prepend('<a href="javascript:void(0);" class="close-nodes"></a>');
        }

        $(_cart).find('.ext-nodes-wrap .ext-node').removeClass('active');

        if ($(_cart).find('.ext-nodes-wrap .ext-node.mini-cart-' + _act).length) {
            $(_cart).find('.ext-nodes-wrap .ext-node.mini-cart-' + _act).addClass('active');
        }

        /**
         * Call Template
         */
        else {
            $.ajax({
                url: mini_cart_ext_url('nasa_ext_mini_cart'),
                type: 'post',
                dataType: 'json',
                cache: false,
                data: {
                    act: _act
                },
                success: function (data) {
                    if (typeof data.content !== 'undefined') {
                        $(_cart).find('.ext-nodes-wrap').append(data.content);

                        if (_act === 'shipping') {
                            setTimeout(function() {
                                $(_cart).find('select.country_to_state, input.country_to_state').trigger('change');
                                $(document.body).trigger('country_to_state_changed'); // Trigger select2 to load.
                            }, 100);
                        }

                        setTimeout(function() {
                            if ($(_cart).find('.ext-nodes-wrap .ext-node.mini-cart-' + _act).length) {
                                $(_cart).find('.ext-nodes-wrap .ext-node.mini-cart-' + _act).addClass('active');
                            }
                        }, 300);
                    }
                },
                error: function () {
                    $(_cart).removeClass('ext-loading');
                }
            });
        }
    }
});

/**
 * Open All ext mini cart
 */
$('body').on('nasa_load_ext_mini_cart', function() {
    var _cart = $('#cart-sidebar');
    
    if (!$('body').hasClass('canvas-on')) {
        $('body').addClass('canvas-on');
    }
    
    if ($(_cart).find('.ext-nodes-wrap').length < 1) {
        $(_cart).append('<div class="ext-nodes-wrap"></div>');
    }
    
    if ($(_cart).find('.ext-nodes-wrap .ext-node').length < 1) {
        $.ajax({
            url: mini_cart_ext_url('nasa_all_ext_mini_cart'),
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {},
            beforeSend: function() {
                if ($('.ext-mini-cart-wrap').length) {
                    $('.ext-mini-cart-wrap').addClass('nasa-disable');
                }
            },
            success: function (data) {
                if (typeof data.content !== 'undefined') {
                    $(_cart).find('.ext-nodes-wrap').append(data.content);

                    if ($(_cart).find('select.country_to_state, input.country_to_state').length) {
                        setTimeout(function() {
                            $(_cart).find('select.country_to_state, input.country_to_state').trigger('change');
                            $(document.body).trigger('country_to_state_changed'); // Trigger select2 to load.
                        }, 100);
                    }
                    
                    $('body').trigger('nasa_publish_coupon_refresh');
                }
                
                if ($('.ext-mini-cart-wrap').length) {
                    $('.ext-mini-cart-wrap').removeClass('nasa-disable');
                }
            }
        });
    }
});

/**
 * ext mini cart Note
 */
$('body').on('click', '#mini-cart-save_note', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    if (!$(_this).hasClass('nasa-disable')) {
        $(_this).addClass('nasa-disable');
        
        var _wrap = $(_this).parents('.nasa-static-sidebar');
        if ($(_wrap).length < 1) {
            _wrap = $(_this).parents('.widget_shopping_cart_content');
        }

        var _note = $('.mini-cart-note textarea[name="order_comments"]').val();

        mini_cart_ext_block(_wrap);

        $.ajax({
            url: mini_cart_ext_url('nasa_mini_cart_note'),
            type: 'post',
            dataType: 'json',
            cache: false,
            data: {
                order_comments: _note
            },
            success: function(data) {
                $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();
                $(_this).removeClass('nasa-disable');

                if (data) {
                    if (data.fragments) {
                        $.each(data.fragments, function(key, value) {
                            if ($(key).length) {
                                $(key).replaceWith(value);
                            }
                        });

                        $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, false, false]);
                        $('body').trigger('wc_fragments_refreshed');

                        /**
                         * notification free shipping
                         */
                        $('body').trigger('nasa_init_shipping_free_notification');
                    }

                    /**
                     * mess
                     */
                    if (data.mess) {
                        mini_cart_ext_mess(data.mess);
                    }
                }

                mini_cart_ext_unblock(_wrap);
            },
            complete: function() {
                mini_cart_ext_unblock(_wrap);
            }
        });
    }
});

$('body').on('nasa_publish_coupon_refresh', function() {
    if ($('.mini-cart-coupon .publish-coupon').length) {
        $('.mini-cart-coupon .publish-coupon').each(function() {
            var _this = $(this);
            var _code = $(_this).attr('data-code');
            
            $(_this).removeClass('nasa-actived');
            
            if ($('.coupon-wrap[data-code="' + _code + '"]').length) {
                $(_this).addClass('nasa-actived');
            }
        });
    }
});

/**
 * From Publish Coupon
 */
$('body').on('click', '.mini-cart-coupon .publish-coupon:not(.nasa-actived)', function() {
    var _this = (this);
    var _code = $(_this).attr('data-code');
    
    if ($('#mini-cart-add-coupon_code').length) {
        $('#mini-cart-add-coupon_code').val(_code).trigger('change');
        
        if ($('#mini-cart-apply_coupon').length) {
            $('#mini-cart-apply_coupon').trigger('click');
        }
    }
});

/**
 * Apply Coupon
 */
$('body').on('click', '#mini-cart-apply_coupon', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    var _nonce = $('.mini-cart-ajax-nonce input[name=apply_coupon_nonce]').length ? $('.mini-cart-ajax-nonce input[name=apply_coupon_nonce]').val() : null;
    
    if (_nonce && !$(_this).hasClass('nasa-disable')) {
        $(_this).addClass('nasa-disable');
        
        var _wrap = $(_this).parents('.nasa-static-sidebar');
        if ($(_wrap).length < 1) {
            _wrap = $(_this).parents('.widget_shopping_cart_content');
        }

        var coupon = $('input#mini-cart-add-coupon_code').val();

        if (coupon) {
            mini_cart_ext_block(_wrap);

            var _data = {
                security: _nonce,
                coupon_code: coupon
            };

            $.ajax({
                type: 'POST',
                url: mini_cart_ext_url('nasa_mini_cart_apply_coupon'),
                data: _data,
                dataType: 'json',
                success: function(data) {
                    $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();
                    $(_this).removeClass('nasa-disable');

                    if (data) {
                        if (data.fragments) {
                            $.each(data.fragments, function(key, value) {
                                if ($(key).length) {
                                    $(key).replaceWith(value);
                                }
                            });

                            $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, _this, false]);
                            $('body').trigger('wc_fragments_refreshed');

                            /**
                             * notification free shipping
                             */
                            $('body').trigger('nasa_init_shipping_free_notification');
                        }

                        /**
                         * mess
                         */
                        if (data.mess) {
                            mini_cart_ext_mess(data.mess);
                        }

                        $('input#mini-cart-add-coupon_code').val('').trigger('change');
                    }

                    mini_cart_ext_unblock(_wrap);
                },
                complete: function() {
                    mini_cart_ext_unblock(_wrap);
                }
            });
        }
        else {
            $(_this).removeClass('nasa-disable');
        }
    }
});

/**
 * Remove Coupon
 */
$('body').on('click', '.widget_shopping_cart_content .woocommerce-remove-coupon', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    var _nonce = $('.mini-cart-ajax-nonce input[name=remove_coupon_nonce]').length ? $('.mini-cart-ajax-nonce input[name=remove_coupon_nonce]').val() : null;
    
    if (_nonce && !$(_this).hasClass('nasa-disable')) {
        $(_this).addClass('nasa-disable');
        
        var _wrap = $(_this).parents('.nasa-static-sidebar');
        if ($(_wrap).length < 1) {
            _wrap = $(_this).parents('.widget_shopping_cart_content');
        }

        mini_cart_ext_block(_wrap);

        var coupon  = $(_this).attr('data-coupon');

        var _data = {
            security: _nonce,
            coupon: coupon
        };

        $.ajax({
            type: 'POST',
            url: mini_cart_ext_url('nasa_mini_cart_remove_coupon'),
            data: _data,
            dataType: 'json',
            success: function(data) {
                $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();
                $(_this).removeClass('nasa-disable');
                
                if (data) {
                    if (data.fragments) {
                        $.each(data.fragments, function(key, value) {
                            if ($(key).length) {
                                $(key).replaceWith(value);
                            }
                        });

                        $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, false, false]);
                        $('body').trigger('wc_fragments_refreshed');

                        /**
                         * notification free shipping
                         */
                        $('body').trigger('nasa_init_shipping_free_notification');
                    }

                    /**
                     * mess
                     */
                    if (data.mess) {
                        mini_cart_ext_mess(data.mess);
                    }
                }

                mini_cart_ext_unblock(_wrap);
            },
            complete: function() {
                mini_cart_ext_unblock(_wrap);
            }
        });
    }
});

/**
 * Calculate Shipping Rate
 */
$('body').on('click', '.mini-cart-shipping [name="calc_shipping"]', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    if (!$(_this).hasClass('nasa-disable')) {
        $(_this).addClass('nasa-disable');
    
        var _wrap = $(_this).parents('.ext-node');
        var $form = $(_this).parents('form');

        mini_cart_ext_block(_wrap);

        $('<input />').attr('type', 'hidden')
            .attr('name', 'calc_shipping')
            .attr('value', 'x')
            .appendTo($form);

        var _data = $form.serialize();

        $.ajax({
            type: 'POST',
            url: mini_cart_ext_url('nasa_mini_cart_calculate_shipping'),
            data: _data,
            dataType: 'json',
            success: function(data) {
                $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();
                $(_this).removeClass('nasa-disable');

                if (data) {
                    if (data.fragments) {
                        $.each(data.fragments, function(key, value) {
                            if ($(key).length) {
                                $(key).replaceWith(value);
                            }
                        });

                        $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, _this, false]);
                        $('body').trigger('wc_fragments_refreshed');

                        /**
                         * notification free shipping
                         */
                        $('body').trigger('nasa_init_shipping_free_notification');
                    }

                    /**
                     * mess
                     */
                    if (data.mess) {
                        mini_cart_ext_mess(data.mess);
                    }
                }

                mini_cart_ext_unblock(_wrap);
            },
            complete: function() {
                mini_cart_ext_unblock(_wrap);
            }
        });
    }
});

});
/* End Document Ready */
