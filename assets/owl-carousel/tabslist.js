jQuery(document).ready(function(){
    // Biến để theo dõi panel hiện tại đang hiển thị
    var currentPanel = null;

    // SlideDown panel1 khi trang được tải xong
    jQuery("#panel16").slideDown("slow");
    currentPanel = "#panel16";

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
});