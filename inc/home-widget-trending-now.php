<?php

class HomeWidgetTrendingNow extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Trending-Now',
            __('Xu Hướng', 'iboss'), // Name
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
        <div class="row align-items-center trending-now-wrapper">
            <div class="col-sm-1"><span class="trending-now-title">Tin hot:</span></div>
            <div class="col-sm-10 px-0">
                <div class="owl-carousel owl-theme">
                    <?php
                    while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <h6 class="card-title title-ellipsis mb-0">
                            <a href="<?php the_permalink() ?>" rel="bookmark"
                               title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                        </h6>
                    <?php
                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                    ?>

                </div><!-- /.owl-carousel -->
            </div><!-- /.col-sm-10-->
            <div class="col-sm-1 p-0 next-prev-wrap text-right">
                <a href="#" class="trending-now-nav-left"><i class="fas fa-angle-left"></i></a>
                <a href="#" class="trending-now-nav-right"><i class="fas fa-angle-right"></i></a>
            </div>
        </div> <!-- /.trending-now-wrapper -->
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

function home_trending_now_register_widgets()
{
    register_widget('HomeWidgetTrendingNow');
}

add_action('widgets_init', 'home_trending_now_register_widgets');