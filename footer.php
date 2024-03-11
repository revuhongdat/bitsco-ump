<footer id="colophon" class="site-footer">
    <div class="site-footer-info">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="py-4">
                        <?php global $tp_options; ?>
                        <strong class="font-weight-bold"><?php echo $tp_options['copyright']; ?></strong>
                        <div><?php echo $tp_options['address']; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-info py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">Bản quyền của Cục Quản lý môi trường Y tế</p>
                </div>
                <div class="col-md-6 text-right">
                    <p class="mb-0">Ghi rõ nguồn 'https://vihema.gov.vn/' khi sử dụng lại thông tin từ các
                        website này.</p>
                </div>
            </div>
        </div>
    </div>

</footer><!-- .site-footer -->
</div><!-- .site-inner -->
<a href="#" id="go-to-top" title="Go to Top">
    <i class="fas fa-arrow-up"></i>
</a>
<script src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<!--<script src="--><?php //bloginfo('template_url'); ?><!--/js/popper.min.js"></script>-->
<!--<script src="--><?php //bloginfo('template_url'); ?><!--/js/bootstrap.min.js"></script>-->
<!--<script src="--><?php //bloginfo('template_url'); ?><!--/js/mdb.min.js"></script>-->
<!--<script src="--><?php //bloginfo('template_url'); ?><!--/js/perfect-scrollbar.min.js"></script>-->
<script src="<?php bloginfo('template_url'); ?>/js/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
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
        $('.next-prev-wrap .trending-now-nav-left').click(function () {
            $('.owl-carousel').trigger('prev.owl.carousel');
        });
        $('.next-prev-wrap .trending-now-nav-right').click(function () {
            $('.owl-carousel').trigger('next.owl.carousel');
        });
    });
    jQuery(document).ready(function ($) {
        var offset = 300;
        var duration = 500;

        $(window).scroll(function () {
            if ($(this).scrollTop() > offset) {
                $('#go-to-top').fadeIn(duration);
            } else {
                $('#go-to-top').fadeOut(duration);
            }
        });

        $('#go-to-top').click(function (event) {
            event.preventDefault();
            $('html, body').animate({scrollTop: 0}, duration);
            return false;
        });
    });
</script>
<script>
    function changeFontSize(action) {
        var contentElement = document.querySelector('.content-to-adjust-font');
        var currentFontSize = window.getComputedStyle(contentElement, null).getPropertyValue('font-size');
        currentFontSize = parseFloat(currentFontSize);

        if (action === 'increase') {
            contentElement.style.fontSize = (currentFontSize + 2) + 'px';
        } else if (action === 'decrease') {
            contentElement.style.fontSize = (currentFontSize - 2) + 'px';
        }
    }
    function copyToClipboard(text) {
        var input = document.createElement('textarea');
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Đã sao chép link: ' + text);
    }
</script>
<?php wp_footer(); ?>
</body>
</html>