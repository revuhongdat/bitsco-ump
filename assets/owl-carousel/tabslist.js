jQuery(document).ready(function(){
    // Biến để theo dõi panel hiện tại đang hiển thị
    var currentPanel = null;

    // SlideDown panel đầu tiên khi trang được tải xong
    jQuery(".panel").first().slideDown("slow");
    currentPanel = jQuery(".panel").first();
    jQuery(".flip").first().addClass("active");

    jQuery(".flip").click(function(){
        var panelId = "#" + jQuery(this).data("panel");

        // Kiểm tra xem panel hiện tại có đang hiển thị hay không
        if (currentPanel === panelId && jQuery(panelId).is(":visible")) {
            // Nếu có, thì chỉ cần slideUp nó
            jQuery(panelId).slideUp("slow");
            currentPanel = null;
        } else {
            // Nếu không, slideUp panel hiện tại (nếu có) và slideDown panel mới
            if (currentPanel) {
                jQuery(currentPanel).slideUp("slow", function(){
                    jQuery(panelId).slideDown("slow");
                    currentPanel = panelId;
                });
            } else {
                // Nếu không có panel hiện tại, chỉ cần slideDown panel mới
                jQuery(panelId).slideDown("slow");
                currentPanel = panelId;
            }
        }
    });
    // Thêm bớt class active khi bấm vào nút button
    jQuery('.container-flip').each(function (i, div) {
        var $div = jQuery(div);
        $div.on('click', '.box-category.flip', function () {
            $div.find('.active').removeClass('active');
            jQuery(this).addClass('active');
        });
    });
    
});


