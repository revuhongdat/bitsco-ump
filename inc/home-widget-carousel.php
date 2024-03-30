<?php

class HomeWidgetCarousel extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Trending',
            __('Carousel', 'iboss'), // Name
            array('description' => __('Một widget để hiển thị nội dung đang hot.', 'iboss'),) // Args
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
            <div style="height: 100%; display: flex; justify-content: center; align-items: center;" class="owl-carousel1 owl-carousel owl-theme">
                    <?php
                    while ($wp_query->have_posts()) : $wp_query->the_post(); 
                    ?>
                        <div style="width: 60%; margin: 0 auto; text-align: center; align-items: center; display: flex; flex-direction: column; color: white;" class="card-title title-ellipsis mb-0">
                            <?php
                                // Đường dẫn đến ảnh trực tuyến
                                $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                            ?>
                            <img loading ="lazy" style="width: 600px; height: 300px; margin-bottom: 20px; object-fit: cover" src="<?php echo $image_url; ?>" alt="">
                            <p style="font-size: 14px">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                            <!-- <div> -->
                                <!-- <div>UMP</div> -->
                                <!-- <p>Hoạt động</p> -->
                            <!-- </div> -->
                        </div>
                    <?php
                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                ?>
            </div><!-- /.owl-carousel -->
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

function home_carousel_register_widgets()
{
    register_widget('HomeWidgetCarousel');
}

add_action('widgets_init', 'home_carousel_register_widgets');