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
        echo '<h4 class="text-center">Programs and Initiatives</h4>';
        echo '<p class="text-center">Welcome to the City of Dream</p>';
        echo '</div>';
        echo '<div id="filters" class="button-group d-flex justify-content-center align-items-center">';
        echo '<button class="button is-checked" data-filter="*">All Categories</button>';
        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
            if ($category) {
                $category_slug = $category->slug;
                $category_name = $category->name;
                echo '<button class="button" data-filter=".' .$category_slug. '">' .$category_name. '</button>';
            }
        }
        echo '</div>';
        echo '<div class="grid row">';
        foreach ($selected_categories as $category_id) {
            $category = get_category($category_id);
            if ($category) {
                $category_slug = $category->slug;
                $category_name = $category->name;
                // Tạo một truy vấn WordPress để lấy bài viết từ chuyên mục hiện tại
                $wp_query = new WP_Query(array(
                    'cat' => $category_id,
                    'posts_per_page' => $count,
                ));
                // Lặp qua các bài viết trong truy vấn và hiển thị tiêu đề và ảnh của mỗi bài viết
                while ($wp_query->have_posts()) : $wp_query->the_post();
                    echo '<div class="col-4 element-item programs ' .$category_slug. '" data-category="' .$category_slug. '">';
                    echo '<div class="item-container">';
                    if (has_post_thumbnail()) {
                        // Nếu bài viết có ảnh đại diện, hiển thị nó
                        the_post_thumbnail('thumbnail', ['class' => 'item-img', 'alt' => get_the_title()]);
                    }
                    echo '</div>';
                    echo '<div class="item-footer text-center">';
                    echo '<a class="my-symbol text-decoration-none" href="' . get_permalink() . '" class="card-title">' . get_the_title() . '</a>';
                    echo '<div class="my-category">Thuộc ' .$category_name. '</div>';
                    echo '</div>';
                    echo '</div>';
                endwhile;
                // Đặt lại truy vấn và dữ liệu bài viết
                wp_reset_query();
                wp_reset_postdata();      
            }
        }
        echo '</div>';
        echo '</div>';
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