/**
 * console.log(navigator.platform);
 * console.log(navigator.appVersion);
 * console.log(navigator.userAgentData);
 */
var fullwidth = 1200,
    _lightbox_variations = [],
    _count_wishlist_items = 0,
    searchProducts = null,
    _nasa_cart = {};
    
var _confetti_run = false;

if (typeof _cookie_live === 'undefined') {
    var _cookie_live = 7;
}
    
/* Document ready */
jQuery(document).ready(function($) {
"use strict";

var _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
var _tabletView = $('.nasa-check-reponsive.nasa-tablet-check').length && $('.nasa-check-reponsive.nasa-tablet-check').width() === 1 ? true : false;
    
var _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;

/**
 * Before Load site
 */
if ($('#nasa-before-load').length) {
    $('#nasa-before-load').fadeOut(100);
}

/**
 * Site Loaded
 */
var _gpnf = $('.gpnf-nested-form').length ? true : false; // Compatible with GP Nested Forms Plugin
if (!$('html').hasClass('html-ready') && !_gpnf) {
    $('html').addClass('html-ready');
} else if (_gpnf && $('#wrapper').length) {
    $('#wrapper').addClass('html-ready');
}

/**
 * Remove Crazy Load Effect
 */
$('body').removeClass('crazy-loading');

var _hash = location.hash || null;
if (_hash) {
    if ($('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').length) {
        setTimeout(function() {
            $('a[href="' + _hash + '"], a[data-id="' + _hash + '"], a[data-target="' + _hash + '"]').trigger('click');
        }, 500);
    }
    
    if ($(_hash).length) {
        if (($(_hash).parents('#comments').length || _hash === '#comments') && $('.woocommerce-review-link').length) {
            setTimeout(function() {
                $('.woocommerce-review-link').trigger('click');
            }, 10);
        }
        
        setTimeout(function() {
            $('body').trigger('nasa_animate_scroll_to_top', [$, _hash, 500]);
        }, 1000);
    }
    
    /**
     * For tabs
     */
    var _tabhash = _hash.replace('#', '');
    if ($('a[data-index="nasa-section-' + _tabhash + '"]').length) {
        setTimeout(function() {
            $('a[data-index="nasa-section-' + _tabhash + '"]').trigger('click');
        }, 500);
    }
    
    if ($('.nasa-section-' + _tabhash).length) {
        setTimeout(function() {
            $('body').trigger('nasa_animate_scroll_to_top', [$, 'a[data-index="nasa-section-' + _tabhash + '"]', 500]);
        }, 1000);
    }
}

/**
 * Off Canvas Menu
 */
$('body').on('nasa_after_load_mobile_menu', function() {
    if ($('.nasa-off-canvas').length) {
        $('.nasa-off-canvas').remove();
    }
});

/**
 * Init menu mobile
 */
$('body').on('click', '.nasa-mobile-menu_toggle', function() {
    $('body').trigger('nasa_append_style_mobile_menu');
    
    init_menu_mobile($);
    
    if ($('#mobile-navigation').length) {
        if ($('#mobile-navigation').attr('data-show') !== '1') {
            if ($('#nasa-menu-sidebar-content').hasClass('nasa-dark')) {
                $('.black-window').addClass('nasa-transparent');
            }
            
            $('.black-window').show().addClass('desk-window');
            
            if ($('#nasa-menu-sidebar-content').length && !$('#nasa-menu-sidebar-content').hasClass('nasa-active')) {
                $('#nasa-menu-sidebar-content').addClass('nasa-active');
            }
            
            $('#mobile-navigation').attr('data-show', '1');
        } else {
            $('.black-window').trigger('click');
        }
    }
});

$('body').on('click', '.nasa-close-menu-mobile, .nasa-close-sidebar', function() {
    $('.black-window').trigger('click');
});

/**
 * Accordion Mobile Menu
 */
$('body').on('click', '.nasa-menu-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    
    var ths = $(this).parent();
    var cha = $(ths).parent();
    if (!$(ths).hasClass('active')) {
        var c = $(cha).children('li.active');
        $(c).removeClass('active').children('.nav-dropdown-mobile').css({height:'auto'}).slideUp(300);
        $(ths).children('.nav-dropdown-mobile').slideDown(300).parent().addClass('active');
    } else {
        $(ths).find('>.nav-dropdown-mobile').slideUp(300).parent().removeClass('active');
    }
    
    return false;
});

/**
 * Accordion Element
 */
$('body').on('click', '.nasa-accordion .li_accordion > a.accordion', function(e) {
    e.preventDefault();
    
    var _current = $(this);

    var _this = $(_current).parent();
    var _parent = $(_this).parent();

    if (!$(_this).hasClass('active')) {
        $(_parent).removeClass('nasa-current-tax-parent').removeClass('current-tax-item');
        var act = $(_parent).children('li.active');
        $(act).removeClass('active').children('.children').slideUp(300);
        $(_this).addClass('active').children('.children').slideDown(300);
    }

    else {
        $(_this).removeClass('active').children('.children').slideUp(300);
    }

    return false;
});

/**
 * Accordions
 */
$('body').on('click', '.nasa-accordions-content .nasa-accordion-title a', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    var warp = $(_this).parents('.nasa-accordions-content');
    $('body').trigger('nasa_check_template', [warp]);
    var _global = $(warp).hasClass('nasa-no-global') ? true : false;
    $(warp).removeClass('nasa-accodion-first-show');
    var _id = $(_this).attr('data-id');
    var _index = false;
    if (typeof _id === 'undefined' || !_id) {
        _index = $(_this).attr('data-index');
    }
    
    var _current = _index ? $(warp).find('.' + _index) : $(warp).find('#nasa-section-' + _id);

    if (!$(_this).hasClass('active')) {
        if (!_global) {
            $(warp).find('.nasa-accordion-title a').removeClass('active');
            $(warp).find('.nasa-panel.active').removeClass('active').slideUp(200);
        }
        
        $(_this).addClass('active');
        if ($(_current).length) {
            $(_current).addClass('active').slideDown(200);
        }
    } else {
        $(_this).removeClass('active');
        if ($(_current).length) {
            $(_current).removeClass('active').slideUp(200);
        }
    }

    return false;
});

/**
 * Window Scroll
 */
var headerHeight = $('#header-content').length ? $('#header-content').height() : 0;
var timeOutFixedHeader;
$(window).on('scroll', function() {
    var scrollTop = $(this).scrollTop();
    
    if ($('body').find('.nasa-header-sticky').length && $('.sticky-wrapper').length) {
        var fix_top = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
        var _heightFixed = $('.sticky-wrapper').outerHeight();
        
        if (scrollTop > headerHeight) {
            if (typeof timeOutFixedHeader !== 'undefined') {
                clearTimeout(timeOutFixedHeader);
            }
            
            if (!$('.sticky-wrapper').hasClass('fixed-already')) {
                $('.sticky-wrapper').addClass('fixed-already');
                $('.nasa-header-sticky').css({'margin-bottom': _heightFixed});
                if (fix_top > 0) {
                    $('.sticky-wrapper').css({top: fix_top});
                }
            }
        } else {
            $('.sticky-wrapper').removeClass('fixed-already');
            $('.nasa-header-sticky').removeAttr('style');
            $('.sticky-wrapper').removeAttr('style');
            
//            if ($('body').hasClass('rtl')) {
//                $('.sticky-wrapper').css({'overflow': 'hidden'});
//            
//                timeOutFixedHeader = setTimeout(function() {
//                    $('.sticky-wrapper').css({'overflow': 'unset'});
//                }, 10);
//            }
            
            _heightFixed = $('.sticky-wrapper').outerHeight();
        }
    }
    
    if ($('.nasa-nav-extra-warp').length) {
        if (scrollTop > headerHeight) {
            if (!$('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').addClass('nasa-show');
            }
        } else {
            if ($('.nasa-nav-extra-warp').hasClass('nasa-show')) {
                $('.nasa-nav-extra-warp').removeClass('nasa-show');
            }
        }
    }
    
    /* Back to Top */
    if ($('#nasa-back-to-top').length) {
        if (typeof intervalBTT !== 'undefined' && intervalBTT) {
            clearInterval(intervalBTT);
        }
        
        var intervalBTT = setInterval(function() {
            var _height_win = $(window).height() / 2;
            if (scrollTop > _height_win) {
                if (!$('#nasa-back-to-top').hasClass('nasa-show')) {
                    $('#nasa-back-to-top').addClass('nasa-show');
                }
            } else {
                $('#nasa-back-to-top').removeClass('nasa-show');
            }
            
            clearInterval(intervalBTT);
        }, 100);
    }
});

/**
 * Window Resize
 */
var _positionMobileMenu;
$(window).on('resize', function() {
    _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    _tabletView = $('.nasa-check-reponsive.nasa-tablet-check').length && $('.nasa-check-reponsive.nasa-tablet-check').width() === 1 ? true : false;

    // Fix Sidebar Mobile, Search Mobile display switch to desktop
    var desk = $('.black-window').hasClass('desk-window');
    if (!_mobileView && !desk && !_inMobile && !_tabletView) {
        if ($('.col-sidebar').length) {
            $('.col-sidebar').removeClass('nasa-active');
        }
        if ($('.warpper-mobile-search').length && !$('.warpper-mobile-search').hasClass('show-in-desk')) {
            $('.warpper-mobile-search').removeClass('nasa-active');
        }
        if ($('.black-window').length) {
            $('.black-window').hide();
        }
    }
    
    var _height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    if (_height_adminbar > 0 && $('#mobile-navigation').length) {
        $('#nasa-menu-sidebar-content').css({'top': _height_adminbar});
        
        if ($('#mobile-navigation').attr('data-show') === '1' && !_mobileView && $('.nasa-menu-off').length <= 0) {
            var _scrollTop = $(window).scrollTop();
            var _headerHeight = $('#header-content').height() + 50;
            if (_scrollTop <= _headerHeight) {
                $('.black-window').trigger('click');
            }
        }
    }
    
    /**
     * Tabs Slide
     */
    if ($('.nasa-slide-style').length) {
        $('.nasa-slide-style').each(function() {
            var _this = $(this);
            nasa_tab_slide_style($, _this, 500);
        });
    }
    
    if (_mobileView || _inMobile) {
        if (typeof _positionMobileMenu !== 'undefined') {
            clearTimeout(_positionMobileMenu);
        }
        
        _positionMobileMenu = setTimeout(function() {
            position_menu_mobile($);
        }, 100);
    }
});

$('body').on('nasa_before_init_menu_mobile', function() {
    position_menu_mobile($);
});

/**
 * Check template
 */
$('body').on('nasa_check_template', function(e, _panels) {
    if ($(_panels).find('.nasa-panel .nasa-tmpl').length) {
        $(_panels).find('.nasa-panel').each(function() {
            $('body').trigger('nasa_render_template', [this]);
        });
        
        $('body').trigger('nasa_rendered_template');
    }
    
    e.preventDefault();
});

/**
 * After Quick view
 */
$('body').on('nasa_after_quickview_timeout', function(e) {
    init_accordion($);
    
    /**
     * VC Progress bar
     */
    if ($('.product-lightbox .vc_progress_bar .vc_bar').length) {
        $('.product-lightbox .vc_progress_bar .vc_bar').each(function() {
            var _this = $(this);
            var _per = $(_this).attr('data-percentage-value');
            $(_this).css({'width': _per + '%'});
        });
    }
    
    e.preventDefault();
});

/**
 * Tabs Content
 */
$('body').on('click', '.nasa-tab a', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    var _data_hash = null;
    
    /**
     * Scroll Hozinal tabable in mobile
     * @type type
     */
    var _ul = $(_this).parents('.nasa-tabs');
    if (!$('body').hasClass('nasa-rtl')) {
        if (!$(_ul).hasClass('nasa-slide-style')) {
            var _li = $(_this).parents('.nasa-tab'),
                _first = $(_ul).find('.nasa-tab.first'),
                _ul_w = $(_ul).width(),
                _li_w = $(_li).width(),
                _t_pos = $(_li).offset(),
                _f_pos = $(_first).offset();

            $(_ul).animate({scrollLeft: _t_pos.left - _f_pos.left  - (_ul_w - _li_w) / 2});
        }
    }
    
    var _this_li = $(_this).parents('.nasa-tab');
    var _root;
    
    if ($(_this_li).hasClass('nasa-single-product-tab')) {
        _root = $(_this).parents('.nasa-tabs-content.woocommerce-tabs'); // WooCommerce Tabs
    } else {
        _root = $(_this).parents('.nasa-tabs-content.nasa-wrap-all'); // WPB - Nasa Tabs
    }
    
    if ($(_root).length < 1) {
        _root = $(_this).parents('.nasa-tabs-content');
    }
    
    if ($(_root).length) {
        
        $('body').trigger('nasa_check_template', [_root]);

        if (!$(_this).parent().hasClass('active')) {
            var _panels = $(_root).find('> .nasa-panels');

            if ($(_panels).length < 1) {
                _panels = $(_root).find('.nasa-panels');
            }
            
            _data_hash = $(_this).attr('data-hash');
            
            var currentTab = $(_this).attr('data-id');
            if (typeof currentTab === 'undefined' || !currentTab) {
                var _index = $(_this).attr('data-index');
                currentTab = $(_root).find('.' + _index);
            }

            $(_ul).find('li').removeClass('active');
            $(_this).parent().addClass('active');
            $(_panels).find('> .nasa-panel').removeClass('active');

            if ($(currentTab).length) {
                $(currentTab).addClass('active');
                $('body').trigger('nasa_after_changed_tab_content', [currentTab]);
            }

            if ($(_ul).hasClass('nasa-slide-style')) {
                nasa_tab_slide_style($, _ul, 500);
            }
        }
        
        if (_data_hash && $('#nasa-single-product-ajax').length < 1 && $('.nasa-has-filter-ajax').length < 1) {
            window.location.hash = _data_hash;
        }
    }
});

/**
 * when disable WOW with Tabs
 */
if (!$('body').hasClass('nasa-enable-wow')) {
    $('body').on('nasa_after_changed_tab_content', function(e, currentTab) {
        e.preventDefault();

        var nasa_slick_element = $(currentTab).find('.nasa-slick-slider');

        if ($(nasa_slick_element).length) {
            $('body').trigger('nasa_unslick', [nasa_slick_element]);
            $('body').trigger('nasa_load_slick_slider');
        }
    });
}

/*********************************************************************
// ! Promo popup
/ *******************************************************************/
var et_popup_closed = $.cookie('nasa_popup_closed');
if (et_popup_closed !== 'do-not-show' && $('.nasa-popup').length && $('body').hasClass('open-popup')) {
    var _delayremoVal = parseInt($('.nasa-popup').attr('data-delay'));
    _delayremoVal = !_delayremoVal ? 300 : _delayremoVal * 1000;
    var _disableMobile = $('.nasa-popup').attr('data-disable_mobile') === 'true' ? true : false;
    var _one_time = $('.nasa-popup').attr('data-one_time');
    
    $('.nasa-popup').magnificPopup({
        items: {
            src: '#nasa-popup',
            type: 'inline'
        },
        closeMarkup: '<a class="nasa-mfp-close nasa-stclose" href="javascript:void(0);" title="' + $('input[name="nasa-close-string"]').val() + '"></a>',
        removalDelay: 300,
        fixedContentPos: true,
        callbacks: {
            beforeOpen: function() {
                this.st.mainClass = 'my-mfp-slide-bottom';
            },
            beforeClose: function() {
                var showagain = $('#showagain:checked').val();
                if (showagain === 'do-not-show' || _one_time === '1') {
                    $.cookie('nasa_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                }
            }
        },
        disableOn: function() {
            if (_disableMobile && $(window).width() < 768) {
                return false;
            }
            
            return true;
        }
    });
    
    setTimeout(function() {
        $('.nasa-popup').magnificPopup('open');
    }, _delayremoVal);
    
    $('body').on('click', '#nasa-popup input[type="submit"]', function() {
        $(this).ajaxSuccess(function(event, request, settings) {
            if (typeof request === 'object' && request.responseJSON.status === 'mail_sent') {
                $('body').append('<div id="nasa-newsletter-alert" class="hidden-tag"><div class="wpcf7-response-output wpcf7-mail-sent-ok">' + request.responseJSON.message + '</div></div>');

                $.cookie('nasa_popup_closed', 'do-not-show', {expires: _cookie_live, path: '/'});
                $.magnificPopup.close();

                setTimeout(function() {
                    $('#nasa-newsletter-alert').fadeIn(300);

                    setTimeout(function() {
                        $('#nasa-newsletter-alert').fadeOut(500);
                    }, 2000);
                }, 300);
            }
        });
    });
}

/**
 * Compare products
 */
$('body').on('click', '.btn-compare', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    var _this = $(this);
    if (!$(_this).hasClass('nasa-compare')) {
        var _button = $(_this).parent();
        if ($(_button).find('.compare-button .compare').length) {
            $(_button).find('.compare-button .compare').trigger('click');
        }
    } else {
        var _id = $(_this).attr('data-prod');
        if (_id) {
            add_compare_product(_id, $);
        }
    }
    
    return false;
});

/**
 * Remove item from Compare
 */
$('body').on('click', '.nasa-remove-compare', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    var _id = $(this).attr('data-prod');
    if (_id) {
        remove_compare_product(_id, $);
    }
    
    return false;
});

/**
 * Remove All items from Compare
 */
$('body').on('click', '.nasa-compare-clear-all', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    remove_all_compare_product($);
    
    return false;
});

/**
 * Show Compare
 */
$('body').on('click', '.nasa-show-compare', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    load_compare($);
    
    if (!$(this).hasClass('nasa-showed')) {
        show_compare($);
    } else {
        hide_compare($);
    }
    
    $('body').trigger('nasa_after_clicked');
    
    return false;
});

/**
 * Wishlist products
 */
$('body').on('click', '.btn-wishlist', function() {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disabled')) {
        $('.btn-wishlist').addClass('nasa-disabled');
        
        /**
         * NasaTheme Wishlist
         */
        if ($(_this).hasClass('btn-nasa-wishlist')) {
            var _pid = $(_this).attr('data-prod');
            
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_add_to_wishlist');
            } else {
                $(_this).removeClass('nasa-added');
                nasa_process_wishlist($, _pid, 'nasa_remove_from_wishlist');
            }
        }
        
        /**
         * Yith WooCommerce Wishlist
         */
        else {
            if (!$(_this).hasClass('nasa-added')) {
                $(_this).addClass('nasa-added');

                if ($('#tmpl-nasa-global-wishlist').length) {
                    var _pid = $(_this).attr('data-prod');
                    var _origin_id = $(_this).attr('data-original-product-id');
                    var _ptype = $(_this).attr('data-prod_type');
                    var _wishlist_tpl = $('#tmpl-nasa-global-wishlist').html();
                    if ($('.nasa-global-wishlist').length <= 0) {
                        $('body').append('<div class="nasa-global-wishlist"></div>');
                    }

                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_id%%/g, _pid);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%product_type%%/g, _ptype);
                    _wishlist_tpl = _wishlist_tpl.replace(/%%original_product_id%%/g, _origin_id);

                    $('.nasa-global-wishlist').html(_wishlist_tpl);
                    $('.nasa-global-wishlist').find('.add_to_wishlist').trigger('click');
                } else {
                    var _button = $(_this).parent();
                    if ($(_button).find('.add_to_wishlist').length) {
                        $(_button).find('.add_to_wishlist').trigger('click');
                    }
                }
            } else {
                var _pid = $(_this).attr('data-prod');
                if (_pid && $('#yith-wcwl-row-' + _pid).length && $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').length) {
                    $(_this).removeClass('nasa-added');
                    $(_this).addClass('nasa-unliked');
                    $('#yith-wcwl-row-' + _pid).find('.nasa-remove_from_wishlist').trigger('click');

                    setTimeout(function() {
                        $(_this).removeClass('nasa-unliked');
                    }, 1000);
                } else {
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }
            }
        }
    }
    
    return false;
});

/* ADD PRODUCT WISHLIST NUMBER */
$('body').on('added_to_wishlist', function() {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _data = {};
        _data.action = 'nasa_update_wishlist';
        _data.added = true;

        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data[_key] = _val;
            });
        }
        
        $.ajax({
            url: nasa_ajax_params.ajax_url,
            type: 'post',
            dataType: 'json',
            cache: false,
            data: _data,
            beforeSend: function() {

            },
            success: function(res) {
                $('.wishlist_sidebar').replaceWith(res.list);
                var _sl_wishlist = (res.count).toString().replace('+', '');
                var sl_wislist = parseInt(_sl_wishlist);
                $('.nasa-mini-number.wishlist-number').html(res.count);

                if (sl_wislist > 0) {
                    $('.nasa-mini-number.wishlist-number').removeClass('nasa-product-empty');
                } else if (sl_wislist === 0 && !$('.nasa-mini-number.wishlist-number').hasClass('nasa-product-empty')) {
                    $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                }

                if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                    if ($('.nasa-close-notice').length) {
                        $('.nasa-close-notice').trigger('click');
                    }

                    $('#yith-wcwl-popup-message').html(res.mess);

                    $('#yith-wcwl-popup-message').fadeIn();
                    setTimeout(function() {
                        $('#yith-wcwl-popup-message').fadeOut();
                    }, 2000);
                }

                setTimeout(function() {
                    init_wishlist_icons($, true);
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }, 350);
            },
            error: function() {
                $('.btn-wishlist').removeClass('nasa-disabled');
            }
        });
    }
});

/* REMOVE PRODUCT WISHLIST NUMBER */
$('body').on('click', '.nasa-remove_from_wishlist', function() {
    if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
        var _wrap_item = $(this).parents('.nasa-tr-wishlist-item');
        if ($(_wrap_item).length) {
            $(_wrap_item).css({opacity: 0.3});
        }

        /**
         * Support Yith WooCommercen Wishlist
         */
        if (!$(this).hasClass('btn-nasa-wishlist')) {
            var _data = {};
            _data.action = 'nasa_remove_from_wishlist';

            if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
                $('.nasa-value-gets').find('input').each(function() {
                    var _key = $(this).attr('name');
                    var _val = $(this).val();
                    _data[_key] = _val;
                });
            }

            var _pid = $(this).attr('data-prod_id');
            _data.remove_from_wishlist = _pid;
            _data.wishlist_id = $('.wishlist_table').attr('data-id');
            _data.pagination = $('.wishlist_table').attr('data-pagination');
            _data.per_page = $('.wishlist_table').attr('data-per-page');
            _data.current_page = $('.wishlist_table').attr('data-page');

            $.ajax({
                url: nasa_ajax_params.ajax_url,
                type: 'post',
                dataType: 'json',
                cache: false,
                data: _data,
                beforeSend: function() {
                    $.magnificPopup.close();
                },
                success: function(res) {
                    if (res.error === '0') {
                        $('.wishlist_sidebar').replaceWith(res.list);
                        var _sl_wishlist = (res.count).toString().replace('+', '');
                        var sl_wislist = parseInt(_sl_wishlist);
                        $('.nasa-mini-number.wishlist-number').html(res.count);
                        if (sl_wislist > 0) {
                            $('.wishlist-number').removeClass('nasa-product-empty');
                        } else if (sl_wislist === 0 && !$('.nasa-mini-number.wishlist-number').hasClass('nasa-product-empty')) {
                            $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                            $('.black-window').trigger('click');
                        }

                        if ($('.btn-wishlist[data-prod="' + _pid + '"]').length) {
                            $('.btn-wishlist[data-prod="' + _pid + '"]').removeClass('nasa-added');

                            if ($('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').length) {
                                $('.btn-wishlist[data-prod="' + _pid + '"]').find('.added').removeClass('added');
                            }
                        }

                        if ($('#yith-wcwl-popup-message').length && typeof res.mess !== 'undefined' && res.mess !== '') {
                            if ($('.nasa-close-notice').length) {
                                $('.nasa-close-notice').trigger('click');
                            }

                            $('#yith-wcwl-popup-message').html(res.mess);

                            $('#yith-wcwl-popup-message').fadeIn();
                            setTimeout(function() {
                                $('#yith-wcwl-popup-message').fadeOut();
                            }, 2000);
                        }
                    }

                    $('.btn-wishlist').removeClass('nasa-disabled');
                },
                error: function() {
                    $('.btn-wishlist').removeClass('nasa-disabled');
                }
            });
        }
    }
    
    return false;
});

// Target quantity inputs on product pages
$('body').find('input.qty:not(.product-quantity input.qty)').each(function() {
    var min = parseFloat($(this).attr('min'));
    if (min && min > 0 && parseFloat($(this).val()) < min) {
        $(this).val(min);
    }
});

$('body').on('click', '.plus, .minus', function() {
    // Get values
    var $qty = $(this).parents('.quantity').find('.qty'),
        form = $(this).parents('.cart'),
        button_add = $(form).length ? $(form).find('.single_add_to_cart_button') : false,
        currentVal = parseFloat($qty.val()),
        max = parseFloat($qty.attr('max')),
        min = parseFloat($qty.attr('min')),
        step = $qty.attr('step');
        
    var _old_val = $qty.val();
    $qty.attr('data-old', _old_val);
        
    // Format values
    currentVal = !currentVal ? 0 : currentVal;
    max = !max ? '' : max;
    min = !min ? 0 : min;
    
    if (
        step === 'any' ||
        step === '' ||
        typeof step === 'undefined' ||
        parseFloat(step) === 'NaN'
    ) {
        step = 1;
    }
    
    // Change the value Plus
    if ($(this).hasClass('plus')) {
        if (max && (max == currentVal || currentVal > max)) {
            $qty.val(max);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', max);
            }
        } else {
            $qty.val(currentVal + parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal + parseFloat(step));
            }
        }
    }
    
    // Change the value Minus
    else {
        if (min && (min == currentVal || currentVal < min)) {
            $qty.val(min);
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', min);
            }
        } else if (currentVal > 0) {
            $qty.val(currentVal - parseFloat(step));
            if (button_add && button_add.length) {
                button_add.attr('data-quantity', currentVal - parseFloat(step));
            }
        }
    }
    
    // Trigger change event
    $qty.trigger('change');
});

/**
 * Mobile Search
 */
$('body').on('click', '.mobile-search', function() {
    $('.black-window').fadeIn(200);
    
    /**
     * Build content search form
     */
    if ($('.warpper-mobile-search').length) {
        var _root_search = $('.warpper-mobile-search');
        
        if ($('#tmpl-nasa-mobile-search').length) {
            var _content = $('#tmpl-nasa-mobile-search').html();
            $(_root_search).html(_content);
            $('#tmpl-nasa-mobile-search').remove();
        }

        if ($(_root_search).find('.nasa-tmpl-search-mobile').length) {
            var _content = $(_root_search).find('.nasa-tmpl-search-mobile').html();
            $(_root_search).find('.nasa-tmpl-search-mobile').replaceWith(_content);
        }
    }
    
    var height_adminbar = $('#wpadminbar').length ? $('#wpadminbar').height() : 0;
    
    if (height_adminbar > 0) {
        $('.warpper-mobile-search').css({top: height_adminbar});
    }
    
    if (!$('.warpper-mobile-search').hasClass('nasa-active')) {
        $('.warpper-mobile-search').addClass('nasa-active');
    }
    
    /**
     * Focus input
     * @returns {undefined}
     */
    setTimeout(function() {
        if ($('.warpper-mobile-search').find('label').length) {
            $('.warpper-mobile-search').find('label').trigger('click');
        }
    }, 210);
});

$('body').on('click', '.nasa-close-search, .nasa-tranparent', function() {
    $(this).parents('.nasa-wrap-event-search').find('.desk-search').trigger('click');
});

$('body').on('click', '.nasa-close-search-mobile', function() {
    $('.black-window').trigger('click');
});

$('body').on('focus', 'input[name="s"]', function() {
    var _wrap = $(this).parents('.search-wrapper');
    var _close = $(_wrap).find('.nasa-close-search-mobile');
    if ($(_close).length && !$(_close).hasClass('nasa-active')) {
        $(_close).addClass('nasa-active');
    }
});

$('body').on('click', '.toggle-sidebar-shop', function() {
    $('.transparent-window').fadeIn(200);
    if (!$('.nasa-side-sidebar').hasClass('nasa-show')) {
        $('.nasa-side-sidebar').addClass('nasa-show');
    }
});

/**
 * For topbar type 1 Mobile
 */
$('body').on('click', '.toggle-topbar-shop-mobile', function() {
    $('.transparent-mobile').fadeIn(200);
    if (!$('.nasa-top-sidebar').hasClass('nasa-active')) {
        $('.nasa-top-sidebar').addClass('nasa-active');
    }
});

$('body').on('click', '.toggle-sidebar', function() {
    $('.black-window').fadeIn(200);
    if ($('.col-sidebar').length && !$('.col-sidebar').hasClass('nasa-active')) {
        $('.col-sidebar').addClass('nasa-active');
    }
});

if ($('input[name="nasa_cart_sidebar_show"]').length && $('input[name="nasa_cart_sidebar_show"]').val() === '1') {
    setTimeout(function() {
        $('.cart-link').trigger('click');
    }, 300);
}

/**
 * Show mini Cart sidebar
 */
$('body').on('click', '.cart-link', function() {
    /**
     * For Checkout Page
     */
    if ($('body').hasClass('woocommerce-checkout') || $('form.woocommerce-checkout').length) {
        var _href = $(this).attr('href');
        window.location.href = _href;
        
        return false;
    }
    
    /**
     * For Others Page - Not Cart Page
     */
    if (!$('body').hasClass('woocommerce-cart') && $('form.woocommerce-cart-form').length <= 0) {
        $('.black-window').fadeIn(200).addClass('desk-window');
        
        if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
            $('#cart-sidebar').addClass('nasa-active');

            if ($('#cart-sidebar').find('input[name="nasa-mini-cart-empty-content"]').length) {
                $('#cart-sidebar').append('<div class="nasa-loader"></div>');

                $('body').trigger('wc_fragment_refresh');
            }
            
            /**
             * notification free shipping
             */
            else {
                init_shipping_free_notification($);
            }
        }
        
        $('body').trigger('nasa_opened_cart_sidebar');
        
        if ($('.nasa-close-notice').length) {
            $('.nasa-close-notice').trigger('click');
        }
    }
    
    return false;
});

/**
 * Compatible elementor toggle button cart sidebar
 */
$('body').on('click', '#elementor-menu-cart__toggle_button', function() {
    if ($('.elementor-menu-cart__container .elementor-menu-cart__main').length) {
        $('.elementor-menu-cart__container').remove();
    }
    
    if (!$(this).hasClass('cart-link')) {
        $(this).addClass('cart-link');
        $(this).trigger('click');
    }
});

/**
 * Wishlist icon open sidebar
 */
$('body').on('click', '.wishlist-link', function() {
    /**
     * Append stylesheet Off Canvas
     */
    $('body').trigger('nasa_append_style_off_canvas');
    
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }
    
    if ($(this).hasClass('wishlist-link-premium')) {
        return;
    } else {
        if ($(this).hasClass('nasa-wishlist-link')) {
            load_wishlist($);
        }
        
        $('.black-window').fadeIn(200).addClass('desk-window');
        if ($('#nasa-wishlist-sidebar').length && !$('#nasa-wishlist-sidebar').hasClass('nasa-active')) {
            $('#nasa-wishlist-sidebar').addClass('nasa-active');
        }
    }
    
    $('body').trigger('nasa_after_clicked');
});

$('body').on('nasa_processed_wishlist', function() {
    if ($('.nasa-tr-wishlist-item').length <= 0) {
        $('.black-window').trigger('click');
    }
});

/**
 * Viewed Sidebar
 */
$('body').on('click', '#nasa-init-viewed', function() {
    $('.black-window').fadeIn(200).addClass('desk-window');
    
    if ($('#nasa-viewed-sidebar').length && !$('#nasa-viewed-sidebar').hasClass('nasa-active')) {
        $('#nasa-viewed-sidebar').addClass('nasa-active');
    }
});

/**
 * Close by fog window
 */
$('body').on('click', '.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .nasa-sidebar-return-shop, .login-register-close', function() {
    _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
    
    _inMobile = $('body').hasClass('nasa-in-mobile') ? true : false;
    
    $('.black-window').removeClass('desk-window');
    
    if ($('#mobile-navigation').length && $('#mobile-navigation').attr('data-show') === '1') {
        if ($('#nasa-menu-sidebar-content').length) {
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
        }
        
        $('#mobile-navigation').attr('data-show', '0');
        setTimeout(function() {
            $('.black-window').removeClass('nasa-transparent');
        }, 1000);
    }
    
    if ($('.warpper-mobile-search').length) {
        $('.warpper-mobile-search').removeClass('nasa-active');
        if ($('.warpper-mobile-search').hasClass('show-in-desk')) {
            setTimeout(function() {
                $('.warpper-mobile-search').removeClass('show-in-desk');
            }, 600);
        }
    }
    
    /**
     * Close sidebar
     */
    if ($('.col-sidebar').length) {
        $('.col-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close Dokan sidebar
     */
    if ($('.dokan-store-sidebar').length) {
        $('.dokan-store-sidebar').removeClass('nasa-active');
    }

    /**
     * Close cart sidebar
     */
    if ($('#cart-sidebar').length) {
        $('#cart-sidebar').removeClass('nasa-active');
    }

    /**
     * Close wishlist sidebar
     */
    if ($('#nasa-wishlist-sidebar').length) {
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close viewed sidebar
     */
    if ($('#nasa-viewed-sidebar').length) {
        $('#nasa-viewed-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close quick view sidebar
     */
    if ($('#nasa-quickview-sidebar').length) {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close filter categories sidebar in mobile
     */
    if ($('.nasa-top-cat-filter-wrap-mobile').length) {
        $('.nasa-top-cat-filter-wrap-mobile').removeClass('nasa-show');
    }
    
    /**
     * Close sidebar
     */
    if ($('.nasa-side-sidebar').length) {
        $('.nasa-side-sidebar').removeClass('nasa-show');
    }
    
    if ($('.nasa-top-sidebar').length) {
        $('.nasa-top-sidebar').removeClass('nasa-active');
    }
    
    /**
     * Close login or register
     */
    if ($('.nasa-login-register-warper').length) {
        $('.nasa-login-register-warper').removeClass('nasa-active');
        
        setTimeout(function() {
            $('.nasa-login-register-warper').hide();
        }, 350);
    }
    
    /**
     * Languages
     */
    if ($('.nasa-current-lang').length) {
        var _wrapLangs = $('.nasa-current-lang').parents('.nasa-select-languages');
        if ($(_wrapLangs).length) {
            $(_wrapLangs).removeClass('nasa-active');
        }
    }
    
    /**
     * Currencies
     */
    if ($('.wcml-cs-item-toggle').length) {
        var _wrapCurrs = $('.wcml-cs-item-toggle').parents('.nasa-select-currencies');
        if ($(_wrapCurrs).length) {
            $(_wrapCurrs).removeClass('nasa-active');
        }
    }
    
    /**
     * Hide compare product
     */
    hide_compare($);
    
    $('body').trigger('nasa_after_close_fog_window');

    $('.black-window, .white-window, .transparent-mobile, .transparent-window, .transparent-desktop').fadeOut(1000);
});

/**
 * ESC from keyboard
 */
$(document).on('keyup', function(e) {
    if (e.keyCode === 27) {
        $('.nasa-tranparent').trigger('click');
        $('.nasa-tranparent-filter').trigger('click');
        $('.black-window, .white-window, .transparent-desktop, .transparent-mobile, .transparent-window, .nasa-close-mini-compare, .nasa-sidebar-close a, .login-register-close, .nasa-transparent-topbar, .nasa-close-filter-cat').trigger('click');
        $('body').trigger('nasa_after_clicked');
        $.magnificPopup.close();
    }
    
    e.preventDefault();
});

//$('body').on('click', '.add_to_cart_button', function() {
//    if (!$(this).hasClass('product_type_simple')) {
//        var _href = $(this).attr('href');
//        window.location.href = _href;
//    }
//});

/**
 * Single add to cart from wishlist
 */
$('body').on('click', '.nasa_add_to_cart_from_wishlist', function() {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id && !$(_this).hasClass('loading')) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _data_wishlist = {};
            
        if ($('.wishlist_table').length && $('.wishlist_table').find('#yith-wcwl-row-' + _id).length) {
            _data_wishlist = {
                from_wishlist: '1',
                wishlist_id: $('.wishlist_table').attr('data-id'),
                pagination: $('.wishlist_table').attr('data-pagination'),
                per_page: $('.wishlist_table').attr('data-per-page'),
                current_page: $('.wishlist_table').attr('data-page')
            };
        }
        
        $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, null, null, _data_wishlist]);
    }
    
    return false;
});

/**
 * Add to cart in quick-view Or single product
 */
$('body').on('click', 'form.cart .single_add_to_cart_button', function() {
    $('.nasa-close-notice').trigger('click');
    
    var _flag_adding = true;
    var _this = $(this);
    var _form = $(_this).parents('form.cart');
    
    $('body').trigger('nasa_before_click_single_add_to_cart', [_form]);
    
    if ($(_form).find('#yith_wapo_groups_container').length) {
        $(_form).find('input[name="nasa-enable-addtocart-ajax"]').remove();
        
        if ($(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').length) {
            $(_form).find('.nasa-custom-fields input[name="nasa_cart_sidebar"]').val('1');
        } else {
            $(_form).find('.nasa-custom-fields').append('<input type="hidden" name="nasa_cart_sidebar" value="1" />');
        }
    }
    
    var _enable_ajax = $(_form).find('input[name="nasa-enable-addtocart-ajax"]');
    if ($(_enable_ajax).length <= 0 || $(_enable_ajax).val() !== '1') {
        _flag_adding = false;
        return;
    } else {
        var _disabled = $(_this).hasClass('disabled') || $(_this).hasClass('nasa-ct-disabled') ? true : false;
        var _id = !_disabled ? $(_form).find('input[name="data-product_id"]').val() : false;
        if (_id && !$(_this).hasClass('loading')) {
            var _type = $(_form).find('input[name="data-type"]').val(),
                _quantity = $(_form).find('.quantity input[name="quantity"]').val(),
                _variation_id = $(_form).find('input[name="variation_id"]').length ? parseInt($(_form).find('input[name="variation_id"]').val()) : 0,
                _variation = {},
                _data_wishlist = {},
                _from_wishlist = (
                    $(_form).find('input[name="data-from_wishlist"]').length === 1 &&
                    $(_form).find('input[name="data-from_wishlist"]').val() === '1'
                ) ? '1' : '0';
                
            if (_type === 'variable' && !_variation_id) {
                _flag_adding = false;
                return false;
            } else {
                if (_variation_id > 0 && $(_form).find('.variations').length) {
                    $(_form).find('.variations').find('select').each(function() {
                        _variation[$(this).attr('name')] = $(this).val();
                    });
                    
                    if ($('.wishlist_table').length && $('.wishlist_table').find('tr#yith-wcwl-row-' + _id).length) {
                        _data_wishlist = {
                            from_wishlist: _from_wishlist,
                            wishlist_id: $('.wishlist_table').attr('data-id'),
                            pagination: $('.wishlist_table').attr('data-pagination'),
                            per_page: $('.wishlist_table').attr('data-per-page'),
                            current_page: $('.wishlist_table').attr('data-page')
                        };
                    }
                }
            }
            
            if (_flag_adding) {
                $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
            }
        }
        
        return false;
    }
});

/**
 * Click bundle add to cart
 */
$('body').on('click', '.nasa_bundle_add_to_cart', function(e) {
    var _this = $(this),
        _id = $(_this).attr('data-product_id');
    if (_id) {
        var _type = $(_this).attr('data-type'),
            _quantity = $(_this).attr('data-quantity'),
            _variation_id = 0,
            _variation = {},
            _data_wishlist = {};
        
        $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
    }
    
    e.preventDefault();
});

/**
 * Click to variation add to cart
 */
$('body').on('click', '.product_type_variation.add-to-cart-grid', function(e) {
    var _this = $(this);
    if (!$(_this).hasClass('nasa-disable-ajax')) {
        if (!$(_this).hasClass('loading')) {
            var _id = $(_this).attr('data-product_id');
            if (_id) {
                var _type = 'variation',
                    _quantity = $(_this).attr('data-quantity'),
                    _variation_id = 0,
                    _variation = null,
                    _data_wishlist = {};
                    
                    if (typeof $(_this).attr('data-variation_id') !== 'undefined') {
                        _variation_id = $(_this).attr('data-variation_id');
                    }

                    if (typeof $(_this).attr('data-variation') !== 'undefined') {
                        _variation = JSON.parse($(_this).attr('data-variation'));
                    }
                    
                if (_variation) {
                    $('body').trigger('nasa_single_add_to_cart', [_this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist]);
                } else {
                    var _href = $(_this).attr('href');
                    window.location.href = _href;
                }
            }
        }

        return false;
    }
    
    e.preventDefault();
});

/**
 * Click select option
 */
$('body').on('click', '.product_type_variable', function(e) {
    e.preventDefault();
    
    var _this = $(this);
    
    if ($('body').hasClass('nasa-quickview-on')) {
        if (
            !$(_this).hasClass('add-to-cart-grid') ||
            $(_this).parents('.nasa-table-compare').length ||
            $(_this).parents('.compare-list').length ||
            $(_this).parents('.product-deal-special-buttons').length
        ) {
            var _href = $(_this).attr('href');
            if (_href) {
                window.location.href = _href;
            }

            return;
        }
        
        else {
            if (!$(_this).hasClass('btn-from-wishlist')) {
                    
                if ($(_this).hasClass('nasa-before-click')) {
                    $('body').trigger('nasa_after_click_select_option', [_this]);
                }

                else {
                    var _parent = $(_this).parents('.product-item');
                    $(_parent).find('.quick-view').trigger('click');
                }
            }

            /**
             * From Wishlist
             */
            else {
                var _parent = $(_this).parents('.add-to-cart-wishlist');
                if ($(_parent).length && $(_parent).find('.quick-view').length) {
                    $(_parent).find('.quick-view').trigger('click');
                }
            }

            return false;
        }
    }
    
    else {
        var _href = $(_this).attr('href');
        if (_href) {
            window.location.href = _href;
        }
        return;
    }
});

/**
 * After remove cart item in mini cart
 */
$('body').on('wc_fragments_loaded', function(e) {
    if ($('#cart-sidebar .woocommerce-mini-cart-item').length <= 0) {
        _confetti_run = false;
        
        $('.black-window').trigger('click');
    }
    
    e.preventDefault();
});

$('body').on('updated_wc_div', function(e) {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($, true);
    
    init_nasa_notices($);
    
    e.preventDefault();
});

/**
 * Before Add To Cart
 */
var _nasa_clear_added_to_cart;
$('body').on('adding_to_cart', function(e) {
    if ($('.nasa-close-notice').length) {
        $('.nasa-close-notice').trigger('click');
    }

    if (typeof _nasa_clear_added_to_cart !== 'undefined') {
        clearTimeout(_nasa_clear_added_to_cart);
    }
    
    e.preventDefault();
});

/**
 * After Add To Cart
 */
$('body').on('added_to_cart', function(ev, fragments, cart_hash, popup, event_add) {
    var _popup = typeof popup !== 'undefined' && popup === false ? false : true;
    /**
     * Close quick-view
     */
    if ($('.nasa-after-add-to-cart-popup').length <= 0) {
        $.magnificPopup.close();
    }
    
    var _event_add = typeof event_add === 'undefined' ? $('input[name="nasa-event-after-add-to-cart"]').length && $('input[name="nasa-event-after-add-to-cart"]').val() : event_add;
    
    /**
     * Only show Notice in cart or checkout page
     */
    if ($('form.nasa-shopping-cart-form').length || $('form.woocommerce-checkout').length) {
        _event_add = 'notice';
    }
    
    /**
     * Loading content After Add To Cart - Popup your order
     */
    if (_popup && _event_add === 'popup' && $('form.nasa-shopping-cart-form').length <= 0 && $('form.woocommerce-checkout').length <= 0) {
        after_added_to_cart($);
    }
   
    /**
     * Show Mini Cart Sidebar
     */
    if (_event_add === 'sidebar') {
        $('#nasa-quickview-sidebar').removeClass('nasa-active');
        $('#nasa-wishlist-sidebar').removeClass('nasa-active');
        
        setTimeout(function() {
            $('.black-window').fadeIn(200).addClass('desk-window');
            $('#nasa-wishlist-sidebar').removeClass('nasa-active');
            
            if ($('#cart-sidebar').length && !$('#cart-sidebar').hasClass('nasa-active')) {
                $('#cart-sidebar').addClass('nasa-active');
            }
            
            $('body').trigger('nasa_opened_cart_sidebar');
            
            /**
             * notification free shipping
             */
            init_shipping_free_notification($, true);
        }, 200);
    }
    
    /**
     * Show notice
     */
    if (_event_add === 'notice' && typeof fragments['.woocommerce-message'] !== 'undefined') {
        if ($('.nasa-close-notice').length) {
            $('.nasa-close-notice').trigger('click');
        }
        
        set_nasa_notice($, fragments['.woocommerce-message']);
        
        if (typeof _nasa_clear_added_to_cart !== 'undefined') {
            clearTimeout(_nasa_clear_added_to_cart);
        }
        
        _nasa_clear_added_to_cart = setTimeout(function() {
            if ($('.nasa-close-notice').length) {
                $('.nasa-close-notice').trigger('click');
            }
        }, 5000);
    }
    
    ev.preventDefault();
});

$('body').on('click', '.nasa-close-magnificPopup, .nasa-mfp-close, form.after-add-to-cart-form .continue-cart', function(e) {
    $.magnificPopup.close();
    
    e.preventDefault();
});

$('body').on('change', '.nasa-after-add-to-cart-popup input.qty', function(e) {
    $('.nasa-after-add-to-cart-popup .nasa-update-cart-popup').removeClass('nasa-disable');
    
    e.preventDefault();
});

$('body').on('click', '.remove_from_cart_popup', function(e) {
    if (!$(this).hasClass('loading')) {
        $(this).addClass('loading');
        nasa_block($('.nasa-after-add-to-cart-wrap'));
        
        var _id = $(this).attr('data-product_id');
        if ($('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').length) {
            $('.widget_shopping_cart_content .remove_from_cart_button[data-product_id="' + _id +'"]').trigger('click');
        } else {
            window.location.href = $(this).attt('href');
        }
    }
    
    e.preventDefault();
});

$('body').on('removed_from_cart', function(e) {
    if ($('.nasa-after-add-to-cart-popup').length) {
        after_added_to_cart($);
    }
    
    /**
     * notification free shipping
     */
    init_shipping_free_notification($);
                    
    e.preventDefault();
});

/**
 * Update cart in popup
 */
$('body').on('click', '.nasa-update-cart-popup', function(e) {
    var _this = $(this);
    
    if ($('.nasa-after-add-to-cart-popup').length && !$(_this).hasClass('nasa-disable')) {
        var _form = $(this).parents('form');
        
        if ($(_form).find('input[name="update_cart"]').length <= 0) {
            $(_form).append('<input type="hidden" name="update_cart" value="Update Cart" />');
        }
        
        $.ajax({
            type: $(_form).attr('method'),
            url: $(_form).attr('action'),
            data: $(_form).serialize(),
            dataType: 'html',
            beforeSend: function() {
                nasa_block($('.nasa-after-add-to-cart-wrap'));
            },
            success: function(res) {
                $(_form).find('input[name="update_cart"]').remove();
                $(_this).addClass('nasa-disable');
            },
            complete: function() {
                $('body').trigger('wc_fragment_refresh');
                after_added_to_cart($);
            }
        });
    }
    
    e.preventDefault();
});

/**
 * auto Update Cart
 */
$('body').on('change', '.after-add-to-cart-form.qty-auto-update .qty', function() {
    var _form = $(this).parents('form.after-add-to-cart-form');
    
    if ($(_form).find('.nasa-update-cart-popup').length) {
        $(_form).find('.nasa-update-cart-popup').removeClass('nasa-disable');
        $(_form).find('.nasa-update-cart-popup').trigger('click');
    }
});

if ($('.nasa-promotion-close').length) {
    var height = $('.nasa-promotion-news').outerHeight();
    
    if ($.cookie('promotion') !== 'hide') {
        setTimeout(function() {
            $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
            $('.nasa-promotion-news').fadeIn(500);
            
            if ($('.nasa-promotion-news').find('.nasa-post-slider').length) {
                $('.nasa-promotion-news').find('.nasa-post-slider').addClass('nasa-slick-slider');
                $('body').trigger('nasa_load_slick_slider');
            }
        }, 1000);
    } else {
        $('.nasa-promotion-show').show();
    }
    
    $('body').on('click', '.nasa-promotion-close', function(e) {
        $.cookie('promotion', 'hide', {expires: _cookie_live, path: '/'});
        $('.nasa-promotion-show').show();
        $('.nasa-position-relative').animate({'height': '0'}, 500);
        $('.nasa-promotion-news').fadeOut(500);
        
        e.preventDefault();
    });
    
    $('body').on('click', '.nasa-promotion-show', function(e) {
        $.cookie('promotion', 'show', {expires: _cookie_live, path: '/'});
        $('.nasa-promotion-show').hide();
        $('.nasa-position-relative').animate({'height': height + 'px'}, 500);
        $('.nasa-promotion-news').fadeIn(500);
        
        if ($('.nasa-promotion-news').find('.nasa-post-slider').length && !$('.nasa-promotion-news').find('.nasa-post-slider').hasClass('nasa-slick-slider')) {
            $('.nasa-promotion-news').find('.nasa-post-slider').addClass('nasa-slick-slider');
            $('body').trigger('nasa_load_slick_slider');
        }
        
        setTimeout(function() {
            $(window).trigger('resize');
        }, 1000);
        
        e.preventDefault();
    });
};

// Logout click
$('body').on('click', '.nasa_logout_menu a', function(e) {
    if ($('input[name="nasa_logout_menu"]').length) {
        window.location.href = $('input[name="nasa_logout_menu"]').val();
    }
    
    e.preventDefault();
});

// Show more | Show less
$('body').on('click', '.nasa_show_manual > a', function(e) {
    var _this = $(this),
        _val = $(_this).attr('data-show'),
        _li = $(_this).parent(),
        _delay = $(_li).attr('data-delay') ? parseInt($(_li).attr('data-delay')) : 100,
        _fade = $(_li).attr('data-fadein') === '1' ? true : false,
        _text_attr = $(_this).attr('data-text'),
        _text = $(_this).text();
        
    $(_this).html(_text_attr);
    $(_this).attr('data-text', _text);
    
    if (_val === '1') {
        $(_li).parent().find('.nasa-show-less').each(function() {
            if (!_fade) {
                $(this).slideDown(_delay);
            } else {
                $(this).fadeIn(_delay);
            }
        });
        
        $(_this).attr('data-show', '0');
    } else {
        $(_li).parent().find('.nasa-show-less').each(function() {
            if (!$(this).hasClass('nasa-chosen') && !$(this).find('.nasa-active').length) {
                if (!_fade) {
                    $(this).slideUp(_delay);
                } else {
                    $(this).fadeOut(_delay);
                }
            }
        });
        
        $(_this).attr('data-show', '1');
    }
    
    e.preventDefault();
});

// Login Register Form
$('body').on('click', '.nasa-switch-register', function(e) {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '0'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '-100%'}, 350);
    
    setTimeout(function() {
        $('.nasa_register-form, .register-form').css({'position': 'relative'});
        $('.nasa_login-form, .login-form').css({'position': 'absolute'});
    }, 350);
    
    e.preventDefault();
});

/**
 * Switch Login | Register forms
 */
$('body').on('click', '.nasa-switch-login', function(e) {
    $('#nasa-login-register-form .nasa-message').html('');
    $('.nasa_register-form, .register-form').animate({'left': '100%'}, 350);
    $('.nasa_login-form, .login-form').animate({'left': '0'}, 350);
    
    setTimeout(function() {
        $('.nasa_register-form, .register-form').css({'position': 'absolute'});
        $('.nasa_login-form, .login-form').css({'position': 'relative'});
    }, 350);
    
    e.preventDefault();
});

if ($('.nasa-login-register-ajax').length) {
    $('body').on('click', '.nasa-login-register-ajax', function() {
        if ($('#nasa-login-register-form').length <= 0) {
            var _content = $('#tmpl-nasa-register-form').html();
            $('.nasa-login-register-warper').html(_content);
            $('#tmpl-nasa-register-form').remove();
            
            $('body').trigger('nasa_login_register_ajax_inited');
        }
        
        if ($(this).attr('data-enable') === '1' && $('#customer_login').length <= 0) {
            
            $('#nasa-menu-sidebar-content').removeClass('nasa-active');
            $('#mobile-navigation').attr('data-show', '0');
            
            $('.black-window').fadeIn(200).removeClass('nasa-transparent').addClass('desk-window');
            
            if (!$('.nasa-login-register-warper').hasClass('nasa-active')) {
                $('.nasa-login-register-warper').show();
                $('.nasa-login-register-warper').addClass('nasa-active');
            }
            
            $('body').trigger('nasa_after_clicked');
            
            return false;
        }
    });
    
    /**
     * Must login to login Ajax Popup
     */
    if ($('.must-log-in > a').length) {
        $('body').on('click', '.must-log-in > a', function(e) {
            if ($('.nasa-login-register-ajax').length) {
                e.preventDefault();
                
                $('.nasa-login-register-ajax').trigger('click');
                
                return false;
            }
        });
    }
    
    /**
     * Login Ajax
     */
    $('body').on('click', '.nasa_login-form .button[type="submit"][name="nasa_login"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.login');

            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('nasa-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('nasa-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: nasa_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'nasa_process_login',
                        'data': _data,
                        'login': true
                    },
                    beforeSend: function() {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                        $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                    },
                    success: function(res) {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                        $('#nasa-login-register-form').find('.nasa-loader').remove();
                        var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                        $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#nasa-login-register-form .nasa-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    var _href = false;
                                    if ($('.nasa-login-register-ajax').length) {
                                        _href = $('.nasa-login-register-ajax').attr('href');
                                    }
                                    
                                    if (_href) {
                                        window.location.href = _href;
                                    } else {
                                        window.location.reload();
                                    }
                                }, 2000);
                            }
                        }

                        $('body').trigger('nasa_after_process_login');
                    }
                });
            } else {
                $(_form).find('.nasa-error').first().focus();
            }
        }
        
        return false;
    });

    /**
     * Register Ajax
     */
    $('body').on('click', '.nasa_register-form .button[type="submit"][name="nasa_register"]', function(e) {
        e.preventDefault();
        
        if (typeof nasa_ajax_params !== 'undefined' && typeof nasa_ajax_params.ajax_url !== 'undefined') {
            var _form = $(this).parents('form.register');
            var _validate = true;
            $(_form).find('.form-row').each(function() {
                var _inputText = $(this).find('input.input-text');
                var _require = $(this).find('.required');
                if ($(_inputText).length) {
                    $(_inputText).removeClass('nasa-error');
                    if ($(_require).length && $(_require).height() && $(_require).width() && $(_inputText).val().trim() === '') {
                        _validate = false;

                        $(_inputText).addClass('nasa-error');
                    }
                }
            });

            if (_validate) {
                var _data = $(_form).serializeArray();
                $.ajax({
                    url: nasa_ajax_params.ajax_url,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        'action': 'nasa_process_register',
                        'data': _data,
                        'register': true
                    },
                    beforeSend: function() {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 0.3});
                        $('#nasa-login-register-form #nasa_customer_login').after('<div class="nasa-loader"></div>');
                    },
                    success: function(res) {
                        $('#nasa-login-register-form #nasa_customer_login').css({opacity: 1});
                        $('#nasa-login-register-form').find('.nasa-loader').remove();
                        var _warning = (res.error === '0') ? 'nasa-success' : 'nasa-error';
                        $('#nasa-login-register-form .nasa-message').html('<h4 class="' + _warning + '">' + res.mess + '</h4>');

                        if (res.error === '0') {
                            $('#nasa-login-register-form .nasa-form-content').remove();
                            window.location.href = res.redirect;
                        } else {
                            if (res._wpnonce === 'error') {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }

                        $('body').trigger('nasa_after_process_register');
                    }
                });
            } else {
                $(_form).find('.nasa-error').first().focus();
            }
        }
        
        return false;
    });
    
    $('body').on('keyup', '#nasa-login-register-form input.input-text.nasa-error', function(e) {
        if ($(this).val() !== '') {
            $(this).removeClass('nasa-error');
        }
        
        e.preventDefault();
    });
}

/**
 * Close header canvas - Header type 7
 */
$('body').on('nasa_after_clicked', function() {
    if ($('.nasa-close-canvas').length) {
        $('.nasa-close-canvas').trigger('click');
    }
});

$('body').on('click', '.btn-combo-link', function(e) {
    var _this = $(this);
    load_combo_popup($, _this);
    
    e.preventDefault();
});

/**
 * Event nasa git featured
 */
$('body').on('click', '.nasa-gift-featured-event', function(e) {
    var _wrap = $(this).parents('.product-item');
    
    if ($(_wrap).find('.nasa-product-grid .btn-combo-link').length === 1) {
        $(_wrap).find('.nasa-product-grid .btn-combo-link').trigger('click');
    } else {
        if ($(_wrap).find('.nasa-product-list .btn-combo-link').length === 1) {
            $(_wrap).find('.nasa-product-list .btn-combo-link').trigger('click');
        }
    }
    
    e.preventDefault();
});

/**
 * Scroll tabs
 */
$('body').on('click', '.nasa-anchor', function(e) {
    var _target = $(this).attr('data-target');
    if ($(_target).length) {
        animate_scroll_to_top($, _target, 1000);
    }
    
    e.preventDefault();
});

/**
 * Animate Scroll To Top
 */
$('body').on('nasa_animate_scroll_to_top', function(ev, $, _dom, _ms) {
    ev.preventDefault();
    animate_scroll_to_top($, _dom, _ms);
});

$('body').on('click', '.filter-cat-icon-mobile', function(e) {
    var _this_click = $(this);
    
    if (!$(_this_click).hasClass('nasa-disable')) {
        $(_this_click).addClass('nasa-disable');
        
        if ($('#nasa-mobile-cat-filter .nasa-tmpl').length) {
            var _content = $('#nasa-mobile-cat-filter .nasa-tmpl').html();
            $('#nasa-mobile-cat-filter .nasa-tmpl').replaceWith(_content);
        }
        
        $('.nasa-top-cat-filter-wrap-mobile').addClass('nasa-show');
        $('.transparent-mobile').fadeIn(300);
        
        setTimeout(function() {
            $(_this_click).removeClass('nasa-disable');
        }, 600);
    }
    
    e.preventDefault();
});

$('body').on('click', '.nasa-close-filter-cat, .nasa-tranparent-filter', function(e) {
    $('.nasa-elements-wrap').removeClass('nasa-invisible');
    $('#header-content .nasa-top-cat-filter-wrap').removeClass('nasa-show');
    $('.nasa-tranparent-filter').remove();
    $('.transparent-mobile').trigger('click');
    
    e.preventDefault();
});

/**
 * Show coupon in shopping cart
 */
$('body').on('click', '.nasa-show-coupon', function(e) {
    if ($('.nasa-coupon-wrap').length === 1) {
        $('.nasa-coupon-wrap').toggleClass('nasa-active');
        setTimeout(function() {
            $('.nasa-coupon-wrap.nasa-active input[name="coupon_code"]').trigger('focus');
        }, 100);
    }
    
    e.preventDefault();
});

/**
 * Topbar toggle
 */
$('body').on('click', '.nasa-topbar-wrap .nasa-icon-toggle', function(e) {
    var _wrap = $(this).parents('.nasa-topbar-wrap');
    $(_wrap).toggleClass('nasa-topbar-hide');
    
    e.preventDefault();
});

$('body').on('click', '.black-window-mobile', function(e) {
    $(this).removeClass('nasa-push-cat-show');
    $('.nasa-push-cat-filter').removeClass('nasa-push-cat-show');
    $('.nasa-products-page-wrap').removeClass('nasa-push-cat-show');
    
    e.preventDefault();
});

$('body').on('click', '.nasa-widget-show-more a.nasa-widget-toggle-show', function(e) {
    var _showed = $(this).attr('data-show');
    var _text = '';
    
    if (_showed === '0') {
        _text = $('input[name="nasa-widget-show-less-text"]').length ? $('input[name="nasa-widget-show-less-text"]').val() : 'Less -';
        $(this).attr('data-show', '1');
        $('.nasa-widget-toggle.nasa-widget-show-less').addClass('nasa-widget-show');
    } else {
        _text = $('input[name="nasa-widget-show-more-text"]').length ? $('input[name="nasa-widget-show-more-text"]').val() : 'More +';
        $(this).attr('data-show', '0');
        $('.nasa-widget-toggle.nasa-widget-show-less').removeClass('nasa-widget-show');
    }
    
    $(this).html(_text);
    
    e.preventDefault();
});

$('body').on('click', '.nasa-mobile-icons-wrap .nasa-toggle-mobile_icons', function(e) {
    $(this).parents('.nasa-mobile-icons-wrap').toggleClass('nasa-hide-icons');
    e.preventDefault();
});

/**
 * Buy Now for Quick view and single product page
 */
$('body').on('click', 'form.cart .nasa-buy-now', function(e) {
    if (!$(this).hasClass('nasa-waiting')) {
        $(this).addClass('nasa-waiting');
        
        var _form = $(this).parents('form.cart');
        if ($(_form).find('.single_add_to_cart_button.disabled').length) {
            $(this).removeClass('nasa-waiting');
            $(_form).find('.single_add_to_cart_button.disabled').trigger('click');
        } else {
            if ($(_form).find('input[name="nasa_buy_now"]').length) {
                if ($('input[name="nasa-enable-addtocart-ajax"]').length) {
                    $('input[name="nasa-enable-addtocart-ajax"]').val('0');
                }
                $(_form).find('input[name="nasa_buy_now"]').val('1');
                $(_form).find('.single_add_to_cart_button').trigger('click');
            }
        }
    }
    
    e.preventDefault();
});

/**
 * Toggle Widget
 */
$('body').on('click', '.nasa-toggle-widget', function(e) {
    var _this = $(this);
    var _widget = $(_this).parents('.widget');
    var _key = $(_widget).attr('id');
    
    if ($(_widget).length && $(_widget).find('.nasa-open-toggle').length) {
        var _hide = $(_this).hasClass('nasa-hide');
        if (!_hide) {
            $(_this).addClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideUp(200);
            $.cookie(_key, 'hide', {expires: 7, path: '/'});
        } else {
            $(_this).removeClass('nasa-hide');
            $(_widget).find('.nasa-open-toggle').slideDown(200);
            $.cookie(_key, 'show', {expires: 7, path: '/'});
        }
    }
    
    e.preventDefault();
});

$('body').on('click', '.woocommerce-notices-wrapper .nasa-close-notice', function(e) {
    var _this = $(this).parents('.woocommerce-notices-wrapper');
    $(_this).html('');
    
    e.preventDefault();
});

/**
 * Close Canvas
 */
$('body').on('click', '.nasa-close-canvas', function() {
    var _wrap = $(this).parents('.canvas-wrap');
    if ($(_wrap).length) {
        $(_wrap).removeClass('nasa-active');
    }
    
    $('body').removeClass('ovhd');
});

/**
 * Bar icons bottom in mobile
 */
$('body').on('nasa_bottom_bar_init', function() {
    init_bottom_bar_mobile($);
});

/**
 * Event sidebar in bottom mobile layout
 */
$('body').on('click', '.nasa-bot-icon-sidebar', function(e) {
    $('.toggle-topbar-shop-mobile, .nasa-toggle-top-bar-click, .toggle-sidebar-shop, .toggle-sidebar, .toggle-sidebar-dokan').trigger('click');

    if ($('.nasa-top-sidebar-2').length) {
        setTimeout(function() {
            $('body').trigger('nasa_animate_scroll_to_top', [$, '.nasa-top-sidebar-2', 300]);
        }, 300);
    }

    e.preventDefault();
});

/**
 * Event cart sidebar in bottom mobile layout
 */
$('body').on('click', '.botbar-cart-link', function(e) {
    if ($('.cart-link').length) {
        $('.cart-link').trigger('click');
    }

    e.preventDefault();
});

/**
 * Event search in bottom mobile layout
 */
$('body').on('click', '.botbar-mobile-search', function(e) {
    if ($('.mobile-search').length) {
        $('.mobile-search').trigger('click');
    }

    e.preventDefault();
});

/**
 * Event Wishlist sidebar in bottom mobile layout
 */
$('body').on('click', '.botbar-wishlist-link', function(e) {
    if ($('.wishlist-link').length) {
        $('.wishlist-link').trigger('click');
    }

    e.preventDefault();
});

/**
 * For Mobile layout
 */
if (_mobileView || _inMobile) {
    $('body').trigger('nasa_bottom_bar_init');
}

/**
 * For Desktop responsive
 */
if ($('#tmpl-nasa-bottom-bar').length) {
    $(window).on('resize', function() {
        _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        if (_mobileView) {
            $('body').trigger('nasa_bottom_bar_init');
        }
    });
}

/**
 * notification free shipping
 */
if ($('.nasa-total-condition').length) {
    setTimeout(function() {
        init_shipping_free_notification($);
    }, 1000);
}

/**
 * Hover product-item in Mobile
 */
$('body').on("touchstart", '.product-item', function() {
    $('.product-item').removeClass('nasa-mobile-hover');
    if (!$(this).hasClass('nasa-mobile-hover')) {
        $(this).addClass('nasa-mobile-hover');
    }
    
    if ($(this).find('.product-img.loop-gallery-carousel:not(.inited)').length) {
        $(this).find('.product-img.loop-gallery-carousel:not(.inited)').trigger('nasa_loop_gallery_carousel');
    }
});

$('body').on("mouseover", '.product-item', function() {
    if ($(this).find('.product-img.loop-gallery-carousel:not(.inited)').length) {
        $(this).find('.product-img.loop-gallery-carousel:not(.inited)').trigger('nasa_loop_gallery_carousel');
    }
    
    if ($(this).parents('.nasa-modern-2') && $(this).find('.add-to-cart-grid').length && !$(this).hasClass('has-add')) {
        $(this).addClass('has-add');
    }
});

$('body').on('nasa_loop_gallery_carousel', '.product-img.loop-gallery-carousel:not(.inited)', function() {
    var _this = $(this);
    $(_this).addClass('inited');
    
    var _gellery = $(_this).attr('data-gellery');

    var _imgs = _gellery ? JSON.parse(_gellery) : [];
    
    if (_imgs.length) {
        var _wrap = $(_this).find('.main-img');
        
        var _first = $(_wrap).find('img').clone();
        
        $(_wrap).html('');
        $(_wrap).append(_first);
        
        $(_wrap).addClass('nasa-slick-slider nasa-slick-nav nasa-nav-inside');
        $(_wrap).attr('data-columns', '1');
        $(_wrap).attr('data-columns-small', '1');
        $(_wrap).attr('data-columns-tablet', '1');
        $(_wrap).attr('data-dot', 'false');
        $(_wrap).attr('data-disable-drag', 'true');
        
        for(var i = 0; i < _imgs.length; i++) {
            var _img = _imgs[i];
            
            $(_wrap).append('<img width="' + _img.w + '" height="' + _img.h + '" src="' + _img.src + '" />');
        }
        
        $('body').trigger('nasa_load_slick_slider');
    }
});

/**
 * GDPR Notice
 */
// $.cookie('nasa_gdpr_notice', '0', {expires: 30, path: '/'});
if ($('.nasa-cookie-notice-container').length) {
    var nasa_gdpr_notice = $.cookie('nasa_gdpr_notice');
    if (typeof nasa_gdpr_notice === 'undefined' || !nasa_gdpr_notice || nasa_gdpr_notice === '0') {
        setTimeout(function() {
            $('.nasa-cookie-notice-container').addClass('nasa-active');
        }, 1000);
    }
    
    $('body').on('click', '.nasa-accept-cookie', function(e) {
        $.cookie('nasa_gdpr_notice', '1', {expires: 30, path: '/'});
        $('.nasa-cookie-notice-container').removeClass('nasa-active');
        
        e.preventDefault();
    });
}

/**
 * Remove title attribute of menu item
 */
$('body').on('mousemove', '.menu-item > a', function() {
    if ($(this).attr('title')) {
        $(this).removeAttr('title');
    }
});

/**
 * Captcha register form
 */
if ($('#tmpl-captcha-field-register').length) {
    $('body').on('click', '.nasa-reload-captcha', function(e) {
        var _time = $(this).attr('data-time');
        var _key = $(this).attr('data-key');
        _time = parseInt(_time) + 1;
        $(this).attr('data-time', _time);
        var _form = $(this).parents('form');
        $(_form).find('.nasa-img-captcha').attr('src', '?nasa-captcha-register=' + _key + '&time=' + _time);
        
        e.preventDefault();
    });

    var _count_captcha;
    if ($('.nasa-reload-captcha').length) {
        _count_captcha = parseInt($('.nasa-reload-captcha').first().attr('data-key'));
    } else {
        _count_captcha = 0;
    }
    
    var _captcha_row = $('#tmpl-captcha-field-register').html();
    if (_captcha_row) {
        $('.nasa-form-row-captcha').each(function() {
            _count_captcha = _count_captcha + 1;
            var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
            $(this).replaceWith(_row);
        });
    }

    $('body').on('nasa_after_load_static_content nasa_login_register_ajax_inited', function(e) {
        if ($('.nasa-form-row-captcha').length) {
            if ($('.nasa-reload-captcha').length) {
                _count_captcha = parseInt($('.nasa-reload-captcha').first().attr('data-key'));
            } else {
                _count_captcha = 0;
            }
            $('.nasa-form-row-captcha').each(function() {
                _count_captcha = _count_captcha + 1;
                var _row = _captcha_row.replace(/{{key}}/g, _count_captcha);
                $(this).replaceWith(_row);
            });
        }
        
        e.preventDefault();
    });

    $('body').on('nasa_after_process_register', function(e) {
        if ($('.nasa_register-form').find('.nasa-error').length) {
            $('.nasa_register-form').find('.nasa-reload-captcha').trigger('click');
            $('.nasa_register-form').find('.nasa-text-captcha').val('');
        }
        
        e.preventDefault();
    });
}

/**
 * Back to Top
 */
$('body').on('click', '#nasa-back-to-top', function(e) {
    $('html, body').animate({scrollTop: 0}, 800);
    
    e.preventDefault();
});

/**
 * After loaded ajax store
 */
$('body').on('nasa_after_loaded_ajax_complete', function(e, destroy_masonry, _more) {
    e.preventDefault();
    after_load_ajax_list($, destroy_masonry);
    init_accordion($);
    
    if (!_more) {
        init_menu_mobile($, true);
    }
});

/**
 * Single Product Add to cart
 */
$('body').on('nasa_single_add_to_cart', function(_ev, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist) {
    nasa_single_add_to_cart($, _this, _id, _quantity, _type, _variation_id, _variation, _data_wishlist);
    _ev.preventDefault();
});

/**
 * Change Countdown for variation - Quick view
 */
$('body').on('nasa_changed_countdown_variable_single', function(e) {
    $('body').trigger('nasa_load_countdown');
    
    e.preventDefault();
});

/**
 * Update Quantity mini cart
 */
$('body').on('change', '.mini-cart-item .qty', function(e) {
    if (
        typeof nasa_ajax_params !== 'undefined' &&
        typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
    ) {
        var _urlAjax = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_quantity_mini_cart');
        var _input = $(this);
        var _wrap = $(_input).parents('.mini-cart-item');
        var _hash = $(_input).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
        var _max = parseFloat($(_input).attr('max'));
        if (!_max) {
            _max = false;
        }
        
        var _quantity = parseFloat($(_input).val());
        
        var _old_val = parseFloat($(_input).attr('data-old'));
        if (!_old_val) {
            _old_val = _quantity;
        }
        
        if (_max > 0 && _quantity > _max) {
            $(_input).val(_max);
            _quantity = _max;
        }
        
        if (_old_val !== _quantity) {
            var _confirm = true;
            
            if (_quantity <= 0) {
                var _confirm_text = $('input[name="nasa_change_value_0"]').length ? $('input[name="nasa_change_value_0"]').val() : 'Are you sure you want to remove it?';
                _confirm = confirm(_confirm_text);
            }
            
            if (_confirm) {
                $.ajax({
                    url: _urlAjax,
                    type: 'post',
                    dataType: 'json',
                    cache: false,
                    data: {
                        hash: _hash,
                        quantity: _quantity
                    },
                    beforeSend: function () {
                        if (!$(_wrap).hasClass('nasa-loading')) {
                            $(_wrap).addClass('nasa-loading');
                        }

                        if ($(_wrap).find('nasa-loader').length <= 0) {
                            $(_wrap).append('<div class="nasa-loader"></div>');
                        }
                    },
                    success: function (data) {
                        if (data && data.fragments) {

                            $.each(data.fragments, function(key, value) {
                                if ($(key).length) {
                                    $(key).replaceWith(value);
                                }
                            });

                            $('body').trigger('added_to_cart', [data.fragments, data.cart_hash, false, false]);
                            $('body').trigger('wc_fragments_refreshed');
                        }

                        $('#cart-sidebar').find('.nasa-loader').remove();
                    },
                    error: function () {
                        $(document.body).trigger('wc_fragments_ajax_error');
                        $('#cart-sidebar').find('.nasa-loader').remove();
                        $('#cart-sidebar').find('.nasa-loading').removeClass('nasa-loading');
                    }
                });
            } else {
                $(_input).val(_old_val);
            }
        }
    }
    
    e.preventDefault();
});

if ($('.nasa-trigger-click').length) {
    setTimeout(function() {
        $('.nasa-trigger-click').trigger('click');
    }, 100);
}

/**
 * For Header Builder Icon menu mobile switcher
 */
if ($('.header-type-builder').length && $('.nasa-nav-extra-warp').length <= 0) {
    $('body').append('<div class="nasa-nav-extra-warp nasa-show"><div class="desktop-menu-bar"><div class="mini-icon-mobile"><a href="javascript:void(0);" class="nasa-mobile-menu_toggle bar-mobile_toggle"><span class="fa fa-bars"></span></a></div></div></div>');
}

/**
 * Append Style Off Canvas
 */
$('body').on('nasa_append_style_off_canvas', function(e) {
    if ($('#nasa-style-off-canvas').length && $('#nasa-style-off-canvas-css').length <= 0) {
        var _link_style = $('#nasa-style-off-canvas').attr('data-link');
        var _stylesheet = '<link rel="stylesheet" id="nasa-style-off-canvas-css" href="' + _link_style + '" />';
        $('head').append(_stylesheet);
        $('#nasa-style-off-canvas').remove();
    }
    
    e.preventDefault();
});

/**
 * Append Style Mobile Menu
 */
$('body').on('nasa_append_style_mobile_menu', function(e) {
    if ($('#nasa-style-mobile-menu').length && $('#nasa-style-mobile-menu-css').length <= 0) {
        var _link_style = $('#nasa-style-mobile-menu').attr('data-link');
        var _stylesheet = '<link rel="stylesheet" id="nasa-style-mobile-menu-css" href="' + _link_style + '" />';
        $('head').append(_stylesheet);
        $('#nasa-style-mobile-menu').remove();
    }
    
    e.preventDefault();
});

/**
 * Delay Click yith wishlist
 */
if ($('.nasa_yith_wishlist_premium-wrap').length && $('.nasa-wishlist-count.wishlist-number').length) {
    $(document).ajaxComplete(function() {
        setTimeout(function() {
            $('.nasa_yith_wishlist_premium-wrap').each(function() {
                var _this = $(this);
                if (!$(_this).parents('.wishlist_sidebar').length) {
                    var _countWishlist = $(_this).find('.wishlist_table tbody tr .wishlist-empty').length ? '0' : $(_this).find('.wishlist_table tbody tr').length;
                    $('.nasa-mini-number.wishlist-number').html(_countWishlist);

                    if (_countWishlist === '0') {
                        $('.nasa-mini-number.wishlist-number').addClass('nasa-product-empty');
                    }
                }
            });
        }, 300);
    }).ajaxError(function() {
        console.log('Error with wishlist premium.');
    });
}

/**
 * Load Content Static Blocks
 */
if (
    typeof nasa_ajax_params !== 'undefined' &&
    typeof nasa_ajax_params.wc_ajax_url !== 'undefined'
) {
    var _urlAjaxStaticContent = nasa_ajax_params.wc_ajax_url.toString().replace('%%endpoint%%', 'nasa_ajax_static_content');

    var _data_static_content = {};
    var _call_static_content = false;

    if ($('input[name="nasa_yith_wishlist_actived"]').length) {
        _data_static_content['reload_yith_wishlist'] = '1';
        _call_static_content = true;
    }

    if ($('input[name="nasa-caching-enable"]').length && $('input[name="nasa-caching-enable"]').val() === '1') {
        if ($('.nasa-login-register-ajax').length) {
            _data_static_content['reload_my_account'] = '1';
            _call_static_content = true;
        }

        if ($('.nasa-hello-acc').length) {
            _data_static_content['reload_login_register'] = '1';
            _call_static_content = true;
        }
    }

    if (_call_static_content) {
        if ($('.nasa-value-gets').length && $('.nasa-value-gets').find('input').length) {
            $('.nasa-value-gets').find('input').each(function() {
                var _key = $(this).attr('name');
                var _val = $(this).val();
                _data_static_content[_key] = _val;
            });
        }

        $.ajax({
            url: _urlAjaxStaticContent,
            type: 'post',
            data: _data_static_content,
            cache: false,
            success: function(result) {
                if (typeof result !== 'undefined' && result.success === '1') {
                    $.each(result.content, function(key, value) {
                        if ($(key).length) {
                            $(key).replaceWith(value);

                            if (key === '#nasa-wishlist-sidebar-content') {
                                init_wishlist_icons($);
                            }
                        }
                    });
                }

                $('body').trigger('nasa_after_load_static_content');
            }
        });
    }
}

/**
 * Fix vertical mega menu
 */
if ($('.vertical-menu-wrapper').length) {
    $('.vertical-menu-wrapper').attr('data-over', '0');

    $('.vertical-menu-container').each(function() {
        var _this = $(this);
        var _h_vertical = $(_this).height();
        $(_this).find('.nasa-megamenu >.nav-dropdown').each(function() {
            $(this).find('>.sub-menu').css({'min-height': _h_vertical});
        });
    });
}

$(".gallery a[href$='.jpg'], .gallery a[href$='.jpeg'], .featured-item a[href$='.jpeg'], .featured-item a[href$='.gif'], .featured-item a[href$='.jpg'], .page-featured-item .slider > a, .page-featured-item .page-inner a > img, .gallery a[href$='.png'], .gallery a[href$='.jpeg'], .gallery a[href$='.gif']").parent().magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: '<div class="nasa-loader"></div>',
    tClose: $('input[name="nasa-close-string"]').val(),
    mainClass: 'my-mfp-zoom-in',
    gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1]
    },
    image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
});

/**
 * Accordions
 */
init_accordion($);

/**
 * Tabs Slide
 */
if ($('.nasa-tabs.nasa-slide-style').length) {
    setTimeout(function() {
        $('.nasa-slide-style').each(function() {
            var _this = $(this);
            nasa_tab_slide_style($, _this, 500);
        });
    }, 500);
}

if ($('.nasa-active').length) {
    $('.nasa-active').each(function() {
        if ($(this).parents('.nasa-show-less').length) {
            $(this).parents('.nasa-show-less').show();
        }
    });
}

/**
 * init Mini wishlist icon
 */
init_mini_wishlist($);

/**
 * init wishlist icon
 */
init_wishlist_icons($);

/**
 * init Compare icons
 */
init_compare_icons($, true);

/**
 * init Widgets
 */
init_widgets($);

/**
 * Refresh when page is shown after back button (Safari | Chrome)
 */
$(window).on('pageshow', function() {
    setTimeout(function() {
        if ($('.widget_shopping_cart_content').find('>*').length <= 0) {
            $('#cart-sidebar').append('<div class="nasa-loader"></div>');
            $('body').trigger('wc_fragment_refresh');
        }
    }, 100);
    
});

/**
 * Fragments Ajax Error
 */
var _fragments_ajax_error_callback = false;
$('body').on('wc_fragments_ajax_error', function() {
    if (!_fragments_ajax_error_callback) {
        _fragments_ajax_error_callback = true;

        if ($('.widget_shopping_cart_content').find('>*').length <= 0) {
            $('#cart-sidebar').append('<div class="nasa-loader"></div>');
            $('body').trigger('wc_fragment_refresh');
        }
    }
});

/**
 * Fragments Refreshed
 */
$('body').on('wc_fragments_refreshed', function() {
    /**
     * notification free shipping
     */
    init_shipping_free_notification($, true);
    
    if ($('#cart-sidebar').length) {
        $('#cart-sidebar').find('.nasa-loader').remove();
    }
});

/**
 * init shipping free notification
 */
$('body').on('nasa_init_shipping_free_notification', function() {
    init_shipping_free_notification($);
});

/**
 * Recount group icons in Header
 */
$('body').on('nasa_before_load_ajax', function(e) {
    if ($('.cart-inner').length) {
        $('.cart-inner').each(function() {
            _nasa_cart['.cart-inner'] = $(this);
            
            return true;
        });
    }
    
    e.preventDefault();
});

$('body').on('nasa_after_load_ajax', function(e) {
    /**
     * Refress Cart icon
     */
    if (typeof _nasa_cart['.cart-inner'] !== 'undefined') {
        $('.cart-inner').replaceWith(_nasa_cart['.cart-inner']);
    }
    
    /**
     * init Mini wishlist icon
     */
    init_mini_wishlist($);
    
    /**
     * init Compare icons
     */
    init_compare_icons($, true);
    
    e.preventDefault();
});

/**
 * Notice Woocommerce
 */
if (!$('body').hasClass('woocommerce-cart')) {
    $('.woocommerce-notices-wrapper').each(function() {
        var _this = $(this);
        setTimeout(function() {
            if ($(_this).find('a').length <= 0) {
                $(_this).html('');
            }

            if ($(_this).find('.woocommerce-message').length) {
                $(_this).find('.woocommerce-message').each(function() {
                    if ($(this).find('a').length <= 0) {
                        $(this).fadeOut(200);
                    }
                });
            }
        }, 3000);
    });
}

init_nasa_notices($);

/**
 * Check wpadminbar
 */
if ($('#wpadminbar').length) {
    $("head").append('<style media="screen">#wpadminbar {position: fixed !important;}</style>');

    var height_adminbar = $('#wpadminbar').height();
    $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-top-cat-filter-wrap-mobile, .nasa-side-sidebar').css({'top' : height_adminbar});

    if (_mobileView || _inMobile || _tabletView) {
        $('.col-sidebar').css({'top' : height_adminbar});
    }

    $(window).on('resize', function(e) {
        _mobileView = $('.nasa-check-reponsive.nasa-switch-check').length && $('.nasa-check-reponsive.nasa-switch-check').width() === 1 ? true : false;
        _tabletView = $('.nasa-check-reponsive.nasa-tablet-check').length && $('.nasa-check-reponsive.nasa-tablet-check').width() === 1 ? true : false;
        
        height_adminbar = $('#wpadminbar').height();

        $('#cart-sidebar, #nasa-wishlist-sidebar, #nasa-viewed-sidebar, #nasa-quickview-sidebar, .nasa-top-cat-filter-wrap-mobile, .nasa-side-sidebar').css({'top' : height_adminbar});

        if (_mobileView || _inMobile || _tabletView) {
            $('.col-sidebar').css({'top' : height_adminbar});
        }
        
        e.preventDefault();
    });
}

// $(window).trigger('scroll').trigger('resize');

/**
 * Check if a node is blocked for processing.
 *
 * @param {JQuery Object} $node
 * @return {bool} True if the DOM Element is UI Blocked, false if not.
 */
var nasa_is_blocked = function($node) {
    return $node.is('.processing') || $node.parents('.processing').length;
};

/**
 * Block a node visually for processing.
 *
 * @param {JQuery Object} $node
 */
var nasa_block = function($node) {
    if (!nasa_is_blocked($node)) {
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
var nasa_unblock = function($node) {
    $node.removeClass('processing').unblock();
};

/**
 * Delay js files
 */
$(window).on('scroll mousemove', function() {
    if ($('[type=nasa_delay_script]').length) {
        
        var _body = document.getElementsByTagName('body')[0];
        
        $('[type=nasa_delay_script]').each(function() {
            var _this = $(this);
            
            var _src = $(_this).attr('src'),
                _id = $(_this).attr('id'),
                _text = $(_this).text(),
                _scrt = document.createElement('script');
                
            _scrt.type = 'text/javascript';
            _scrt.text = _text;
            
            if (typeof _src !== 'undefined') {
                _scrt.src = _src;
            }
            
            if (typeof _id !== 'undefined') {
                _scrt.id = _id;
            }
            
            _body.appendChild(_scrt);
            
            $(_this).remove();
        });
    }
});

/* End Document Ready */
});
