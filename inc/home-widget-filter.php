<?php

class HomeWidgetFilter extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Filter',
            __('Filter', 'iboss'), // Name
            array('description' => __('Một widget để hiển thị nội dung đang hot.', 'iboss'),) // Args
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

        echo '<div class="filter-block mt-5">';
        echo '<div>';
        echo '<h4 class="text-center">CÁC HOẠT ĐỘNG CHÍNH</h4>';
        echo '</div>';
        echo '<div id="filters" class="button-group d-flex justify-content-center align-items-center">';
        echo '<button class="button is-checked" data-filter="*">TẤT CẢ</button>';
        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
            if ($category) {
                $category_slug = $category->slug;
                $category_name = $category->name;
                echo '<button class="button" data-filter=".' .$category_slug. '">' .$category_name. '</button>';
            }
        }

        $array_post = array(); // Khởi tạo mảng để lưu trữ bài viết

        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
            if ($category) {
                // Lấy danh sách bài viết trong mỗi danh mục
                $args = array(
                    'cat' => $category_id, // ID của danh mục
                    'posts_per_page' => -1, // Lấy tất cả bài viết trong danh mục
                );
        
                $posts = get_posts($args); // Lấy danh sách bài viết
        
                // Kiểm tra xem có bài viết nào trong danh mục không
                if ($posts) {
                    foreach ($posts as $post) {
                        // Kiểm tra xem bài viết đã được thêm vào mảng chưa
                        if (!isset($array_post[$post->ID])) {
                            // Nếu chưa, thêm bài viết vào mảng với ID của bài viết làm khóa
                            $array_post[$post->ID] = $post;
                        }
                    }
                }
            }
        }

        echo '</div>';
        echo '<div class="grid row">';

        foreach ($array_post as $post) {
            // Lấy danh sách category của bài viết
            $categories = get_the_category($post);
        
            // Khởi tạo một chuỗi để lưu trữ các slug của các danh mục
            $category_slugs = '';
        
            // Kiểm tra xem danh sách category có tồn tại không
            if ($categories) {
                foreach ($categories as $category) {
                    // Lấy slug của category
                    $category_slug = $category->slug;
        
                    // Thêm slug của category vào chuỗi và thêm khoảng trắng nếu chuỗi không rỗng
                    $category_slugs .= $category_slug . ' ';
                }
            }
        
            // In ra phần HTML cho mỗi bài viết với danh sách slug của các danh mục trong data-category
            echo '<div class="mb-4 col-4 element-item ' . trim($category_slugs) . '" data-category="' . trim($category_slugs) . '">';
            echo '<div class="item-container mmmm">';
            if (has_post_thumbnail($post)) {
                // Nếu bài viết có ảnh đại diện, hiển thị nó
                echo get_the_post_thumbnail($post, 'thumbnail', ['class' => 'item-img', 'alt' => get_the_title($post)]);
            }
            echo '</div>';
            echo '<div class="item-footer text-center">';
            echo '<a class="my-symbol text-decoration-none card-title title-ellipsis-three" href="' . get_permalink($post) . '">' . get_the_title($post) . '</a>';
            echo '</div>';
            echo '</div>';
        }
        
        // Đặt lại truy vấn và dữ liệu bài viết
        wp_reset_query();
        wp_reset_postdata();
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

function home_filter_register_widgets()
{
    register_widget('HomeWidgetFilter');
}

add_action('widgets_init', 'home_filter_register_widgets');