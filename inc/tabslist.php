<?php

class TabsList extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'TabsList',
            __('Tabs List', 'iboss'), // Name
            array('description' => __('Tabs List.', 'iboss'),) // Args
        );
    }

    function widget($args, $instance)
    {
        extract($args);
    
        $title = apply_filters('title', isset($instance['title']) ? esc_attr($instance['title']) : '');
        $selected_categories = isset($instance['category']) ? $instance['category'] : array();
        $count = apply_filters('count', isset($instance['count']) && is_numeric($instance['count']) ? esc_attr($instance['count']) : '');
    
        // Hiển thị phần trước widget
        echo $before_widget;
    
        // Hiển thị các nút "flip" với tiêu đề của từng chuyên mục
        echo '<div class="container-flip d-flex justify-content-center">';
        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
            if ($category) {
                echo '<button class="flip mr-3 ml-3" data-panel="panel' . $category_id . '">' . esc_html($category->name) . '</button>';
            }
        }
        echo '</div>';
    
        // Lặp qua từng chuyên mục được chọn
        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
    
            // Kiểm tra xem chuyên mục có tồn tại không
            if ($category) {
                echo '<div class="panel" id="panel' . $category_id . '">';
                echo '<div class="owl-carousel owl-carousel3 owl-theme">';
        
                // Tạo một truy vấn WordPress để lấy bài viết từ chuyên mục hiện tại
                $wp_query = new WP_Query(array(
                    'cat' => $category_id,
                    'posts_per_page' => $count,
                ));
        
                // Lặp qua các bài viết trong truy vấn và hiển thị tiêu đề và ảnh của mỗi bài viết
                while ($wp_query->have_posts()) : $wp_query->the_post();
                    echo '<div class="item">';
                    echo '<div class="card" style="width: 100%;">';
                    if (has_post_thumbnail()) {
                        // Nếu bài viết có ảnh đại diện, hiển thị nó
                        echo '<div class="hover-effect">';
                        the_post_thumbnail('thumbnail', ['class' => 'card-img-top', 'alt' => get_the_title()]);
                        echo '</div>';
                    }
                    
                    echo '<div class="card-body">';
                    echo '<a href="' . get_permalink() . '" class="card-title title-ellipsis-three">' . get_the_title() . '</a>';
                    echo '<p class="card-text title-ellipsis-three">' . get_the_excerpt() . '</p>';
                    echo '<a href="' . get_permalink() . '" class="card-read-more">' . __('Xem thêm >', 'textdomain') . '</a>';
                    echo '</div>'; // /.card-body
                    echo '</div>'; // /.card
                    echo '</div>'; // /.item';
                endwhile;
        
                echo '</div>'; // /.owl-carousel
                echo '</div>'; // /.panel
        
                // Đặt lại truy vấn và dữ liệu bài viết
                wp_reset_query();
                wp_reset_postdata();
            }
        }
    
        // Hiển thị phần sau widget
        echo $after_widget;
    }
    
    
    
    function update($new_instance, $old_instance)
    {
        // Lưu các tùy chọn mới từ form
        $instance = $old_instance;
        // $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = isset($new_instance['category']) ? $new_instance['category'] : array();
        // $instance['count'] = strip_tags($new_instance['count']);
    
        return $instance;
    }
    

    function form($instance)
    {

        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $category = isset($instance['category']) ? esc_attr($instance['category']) : '';
        $count = isset($instance['count']) && is_numeric($instance['count']) ? (int)$instance['count'] : 4;
        // Lấy tất cả các chuyên mục
        $all_categories = get_categories(array('hide_empty' => 0, 'taxonomy' => 'category', 'hierarchical' => 1));
    ?>
    <!-- Form hiển thị trên UI -->
    <!-- Select option category -->
    <p>
    <label for="<?php echo $this->get_field_id('category'); ?>">
    <?php _e('Chuyên mục:', 'iboss'); ?>
    <!-- Bắt đầu nhãn cho các checkbox, liên kết với id của trường -->

    <?php
    $cats = get_categories(array('hide_empty' => 0, 'taxonomy' => 'category', 'hierarchical' => 1));
    // Lấy danh sách tất cả các chuyên mục

    foreach ($cats as $cat) {
        // Bắt đầu vòng lặp qua từng chuyên mục
        $checked = in_array($cat->term_id, (array)$category) ? 'checked="checked"' : '';
        // Kiểm tra xem chuyên mục có được chọn hay không

        echo '<p>';
        echo '<input type="checkbox" id="' . esc_attr($this->get_field_id('category') . '_' . $cat->term_id) . '" name="' . esc_attr($this->get_field_name('category')) . '[]" value="' . esc_attr($cat->term_id) . '" ' . $checked . '>';
        echo '<label for="' . esc_attr($this->get_field_id('category') . '_' . $cat->term_id) . '">' . esc_html($cat->name) . '</label>';
        echo '</p>';
        // Tạo checkbox và nhãn tương ứng cho từng chuyên mục
    }
    ?>

</label>
        </p>
    <?php
    }
}

function tabslist_register_widgets()
{
    register_widget('TabsList');
}

add_action('widgets_init', 'tabslist_register_widgets');