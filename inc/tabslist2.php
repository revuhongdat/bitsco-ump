<?php

class TabsList2 extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'TabsList2',
            __('Tabs List2', 'iboss'), // Name
            array('description' => __('Tabs List2.', 'iboss'),) // Args
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
        <div class="owl-carousel owl-carousel2 owl-theme">
        <?php
        while ($wp_query->have_posts()) : $wp_query->the_post();
        ?>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <?php
                    // Đường dẫn đến ảnh trực tuyến
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                    ?>
                    <div class="hover-effect">
                        <img class="card-img-top" src="<?php echo $image_url; ?>" alt="img-post-title">
                    </div>
                    <div class="card-body">
                        <a href="<?php echo get_permalink(); ?>" class="card-title title-ellipsis-three"><?php echo get_the_title(); ?></a>
                        <p class="card-text title-ellipsis-three"><?php echo get_the_excerpt(); ?></p>
                        <a href="<?php echo get_permalink(); ?>" class="card-read-more">Xem thêm ></a>
                    </div>
                </div>
            </div>
        <?php
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        ?>
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

function tabslist2_register_widgets()
{
    register_widget('TabsList2');
}

add_action('widgets_init', 'tabslist2_register_widgets');