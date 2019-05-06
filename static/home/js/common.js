"use strict";

if (top.location !== self.location) {
    top.location.href = document.location.href;
}

//Slide
$(function ($) {
    var slide = $('#slide'),
        slideWidth = slide.width(),
        items = slide.find('.slide-item'),
        duration = 600,
        index = 0;

    if (items.length < 2) {
        return;
    }

    var paging = $(new Array(items.length + 1).join('<span></span>')).appendTo(slide.find('.slide-paging'));
    paging.eq(index).addClass('current');
    items.css('left', slideWidth).eq(index).css('left', 0);

    function toNext(nextIndex) {
        paging.eq(nextIndex).addClass('current').end().eq(index).removeClass('current');
        items.eq(nextIndex).css("left", slideWidth).finish().animate({left: 0}, duration, 'swing');
        items.eq(index).finish().animate({left: -slideWidth}, duration, 'swing');
        index = nextIndex;
    }

    function onNext() {
        var nextIndex = index + 1;
        if (nextIndex >= items.length) {
            nextIndex = 0;
        }
        toNext(nextIndex);
    }

    function toPrev(prevIndex) {
        paging.eq(prevIndex).addClass('current').end().eq(index).removeClass('current');
        items.eq(prevIndex).css("left", -slideWidth).finish().animate({left: 0}, duration, 'swing');
        items.eq(index).finish().animate({left: slideWidth}, duration, 'swing');
        index = prevIndex;
    }

    function onPrev() {
        var prevIndex = index - 1;
        if (prevIndex < 0) {
            prevIndex = items.length - 1;
        }
        toPrev(prevIndex);
    }

    slide.find('.slide-next').show().on('click', onNext);
    slide.find('.slide-prev').show().on('click', onPrev);

    paging.on('click', function () {
        var currentIndex = $(this).index();
        if (currentIndex === index) {
            return;
        }
        (currentIndex > index) ? toNext(currentIndex) : toPrev(currentIndex);
    });

    var timerId = null;

    function setAutoPay() {
        clearInterval(timerId);
        timerId = setInterval(function () {
            onNext();
        }, 6000);
    }

    setAutoPay();

    slide.on('mouseenter', function () {
        clearInterval(timerId);
        timerId = null;
    }).on('mouseleave', function () {
        setAutoPay();
    });
});

// Sticky
$(function ($) {
    var win = $(window),
        side = $('#side');
    if (!side.length) {
        return;
    }

    var sideHeight = side.outerHeight(true),
        wrap = side.parent(),
        wrapHeight = wrap.height(),
        start = side.offset().top,
        end = start + (wrapHeight - sideHeight);

    if (wrapHeight <= sideHeight) {
        return;
    }

    wrap.find('img').on('load', function () {
        end = start + (wrap.height() - sideHeight);
    });

    win.on('scroll.sticky', function () {
        var wst = win.scrollTop();
        if (wst > start) {
            side.addClass('fixed').css('top', Math.min(0, end - wst));
        } else {
            side.removeClass('fixed').css('top', '');
        }
    }).trigger('scroll.sticky');

});

//左右同高
$(function ($) {
    var main = $('#main'),
        item = main.find('.height-auto');

    if (item.length) {
        var sideHeight = $('#side').height();
        if (sideHeight > main.height()) {
            item.css('min-height', sideHeight - 63);
        }
    }
});

//返回顶部
$(function ($) {
    var win = $(window),
        htmlBody = $('html, body'),
        backTop = $('#backTop');

    backTop.on('click', function () {
        htmlBody.animate({scrollTop: 0}, 300);
    });

    win.on('scroll.back', function () {
        (win.scrollTop() > 300) ? backTop.addClass('show') : backTop.removeClass('show');
    }).trigger('scroll.back');
});