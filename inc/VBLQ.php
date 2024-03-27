<?php

class VBLQ extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'VBLQ',
            __('Văn bản liên quan', 'iboss'), // Name
            array('description' => __('Văn bản liên quan.', 'iboss'),) // Args
        );
    }

    function widget($args, $instance)
{
    extract($args);

    $title = apply_filters('title', isset($instance['title']) ? esc_attr($instance['title']) : '');
    $category = apply_filters('category', isset($instance['category']) ? esc_attr($instance['category']) : '');
    $count = apply_filters('count', isset($instance['count']) && is_numeric($instance['count']) ? esc_attr($instance['count']) : '');

    $category_link = get_category_link($category);

    echo $before_widget;

    $wp_query = new WP_Query(array(
        'cat' => $category,
        'posts_per_page' => $count,
    ));
    ?>
        <div class="container">
        <div class="row">
            <?php if (function_exists('iboss_breadcrumbs')) iboss_breadcrumbs(); ?>
        </div>
        </div>
        <div id="content" class="site-content">
        <div class="container">
            <div class="row mb-2">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="title-underline mb-2">
                        <h1><?php echo get_the_title(); ?></h1>
                    </div>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%" scope="col">Số ký hiệu</th>
                                <th style="width: 50%" scope="col">Trích yếu</th>
                                <th style="width: 10%" scope="col">Ngày ban hành</th>
                                <th style="width: 30%" scope="col">Tài liệu đính kèm</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            while ($wp_query->have_posts()) : $wp_query->the_post(); 
                                $post_id = get_the_ID();
                                // Lấy giá trị của các trường tùy chỉnh
                                $so_ky_hieu = get_post_meta($post_id, 'so_ky_hieu', true);
                                $trich_yeu = get_post_meta($post_id, 'trich_yeu', true);
                                $ngay_ban_hanh = get_post_meta($post_id, 'ngay_ban_hanh', true);
                                $tai_lieu_dinh_kem = get_post_meta($post_id, 'tai_lieu_dinh_kem', true);
                                // Chuyển chuỗi URL thành mảng
                                $file_urls = explode(',', $tai_lieu_dinh_kem);


                                echo '<tr>';
                                echo '<td>' . $so_ky_hieu . '</td>';
                                echo '<td>' . $trich_yeu . '</td>';
                                echo '<td>' . $ngay_ban_hanh . '</td>';

                                // Kiểm tra xem tài liệu đính kèm có tồn tại không
                                if (!empty($tai_lieu_dinh_kem)) {
                                    // Tạo liên kết để tải xuống tài liệu
                                    $file_url = wp_get_attachment_url($tai_lieu_dinh_kem);
                                    echo '<td>';
                                    // Hiển thị danh sách các file
                                    echo '<ol>';
                                    foreach ($file_urls as $url) {
                                        $url = trim($url); // Loại bỏ khoảng trắng thừa
                                        $file_name = basename($url);
                                        echo '<li><a href="' . esc_url($url) . '" download="' . esc_attr($file_name) . '">' . esc_html($file_name) . '</a></li>';
                                    }
                                    echo '</ol>';
                                    echo '</td>';
                                } else {
                                    echo '<td></td>'; // Nếu không có tài liệu đính kèm, hiển thị một cột trống
                                }

                                echo '</tr>';
                            endwhile;
                            wp_reset_query();
                            wp_reset_postdata();
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>    
    <?php
    echo $after_widget;
}


    function update($new_instance, $old_instance)
    {
        // Save widget options
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['category'] = strip_tags($new_instance['category']);
        $instance['count'] = strip_tags($new_instance['count']);


        return $instance;
    }

    function form($instance)
    {

        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $category = isset($instance['category']) ? esc_attr($instance['category']) : '';
        $count = isset($instance['count']) && is_numeric($instance['count']) ? (int)$instance['count'] : 4;
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Tiêu đề:', 'iboss'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo $title; ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">
                <?php _e('Chuyên mục:', 'iboss'); ?>
                <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                        name="<?php echo $this->get_field_name('category'); ?>">
                    <?php echo '<option value="0" ' . ('0' == $category ? 'selected="selected"' : '') . '>' . __('Tất cả') . '</option>';
                    $cats = get_categories(array('hide_empty' => 0, 'taxonomy' => 'category', 'hierarchical' => 1));
                    foreach ($cats as $cat) {
                        echo '<option value="' . $cat->term_id . '" ' . ($cat->term_id == $category ? 'selected="selected"' : '') . '>' . $cat->name . '</option>';
                    }
                    ?>
                </select>
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>">
                <?php _e('Số bài viết (tối đa 4):', 'iboss'); ?>
                <input id="<?php echo $this->get_field_id('count'); ?>"
                       name="<?php echo $this->get_field_name('count'); ?>" type="number"
                       min="1" max="4" value="<?php echo $count; ?>"/>
            </label>
        </p>
        <?php
    }
}

function VBLQ_register_widgets()
{
    register_widget('VBLQ');
}

add_action('widgets_init', 'VBLQ_register_widgets');