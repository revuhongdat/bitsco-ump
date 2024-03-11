jQuery(document).ready(function () {
    jQuery('.owl-carousel1').owlCarousel({
        loop: true,
        items: 1,
        margin: 0,
        stagePadding: 0,
        smartSpeed: 450,
        nav: false,
        dots: false,
        // animateOut: 'fadeOutLeft',
        // animateIn: 'fadeInRight',
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: false
    });
    // Thêm sự kiện cho nút "prev" và "next"
    jQuery('.next-prev-wrap .trending-now-nav-left').click(function () {
        jQuery('.owl-carousel1').trigger('prev.owl.carousel');
    });
    jQuery('.next-prev-wrap .trending-now-nav-right').click(function () {
        jQuery('.owl-carousel1').trigger('next.owl.carousel');
    });
});
jQuery(document).ready(function ($) {
    var offset = 300;
    var duration = 500;

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery('#go-to-top').fadeIn(duration);
        } else {
            jQuery('#go-to-top').fadeOut(duration);
        }
    });

    jQuery('#go-to-top').click(function (event) {
        event.preventDefault();
        jQuery('html, body').animate({ scrollTop: 0 }, duration);
        return false;
    });
});



// external js: isotope.pkgd.js

// init Isotope
var $grid = jQuery('.grid').isotope({
    itemSelector: '.element-item',
    layoutMode: 'fitRows'
});

// filter functions
var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function () {
        var number = jQuery(this).find('.number').text();
        return parseInt(number, 10) > 50;
    },
    // show if name ends with -ium
    ium: function () {
        var name = jQuery(this).find('.name').text();
        return name.match(/ium$/);
    }
};

// bind filter button click
jQuery('#filters').on('click', 'button', function () {
    var filterValue = jQuery(this).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[filterValue] || filterValue;
    $grid.isotope({ filter: filterValue });
});

// change is-checked class on buttons
jQuery('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = jQuery(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        jQuery(this).addClass('is-checked');
    });
});

// change is-checked class on buttons
jQuery('.container-flip').each(function (i, buttonGroup) {
    var $buttonGroup = jQuery(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        jQuery(this).addClass('is-checked');
    });
});

