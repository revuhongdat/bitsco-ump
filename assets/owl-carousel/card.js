jQuery(document).ready(function () {
    jQuery('.owl-carousel').owlCarousel({
        autoplay: true,
        autoplayTimeout: 2000,
        // autoplayHoverPause: false,
        loop: true,
        margin: 10,
        nav: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
});