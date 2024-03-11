<?php

class HomeWidgetGridCategories extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Grid-Categories',
            __('Chuyên Mục Kèm Bài Viết (Lưới ngang)', 'iboss'), // Tên hiển thị của widget khi kéo thả
            array('description' => __('Widget này trình bày 3 bài viết từ một chuyên mục cụ thể dưới dạng lưới', 'iboss'),) // Args
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

        //Load Wiget HOT1
        $wp_query = new WP_Query(array(
            'cat' => $category,
            'posts_per_page' => $count,
        ));
        ?>
        <div class="box-category widget-article">
            <div class="title-box-category">
                <h4 class="title-underline">
                    <a href="<?php echo $category_link; ?>" rel="boomark"
                       title="<?php echo $title; ?>"><?php echo $title; ?></a>
                </h4>
            </div>
            <div class="row">
                <?php
                while ($wp_query->have_posts()) : $wp_query->the_post();
                    ?>
                    <div class="col-xs-12 col-sm-4">
                        <div class="card mb-3 border-0 rounded-0">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('large', array('class' => 'card-img-top')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-body p-0 pt-2 pb-2">
                                <h5 class="card-title title-ellipsis-2-line font-weight-bold">
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                                </h5>
                                <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                            </div>
                        </div>
                    </div><!-- /.col-sm-4 -->
                <?php
                endwhile;
                wp_reset_query();
                wp_reset_postdata();
                ?>
            </div><!-- /.row -->
        </div><!-- /.widget-featured-category -->
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
                       name="<?php echo $this->get_field_name('count'); ?>" type="text"
                       size="3" value="<?php echo $count; ?>"/>
            </label>
        </p>
        <?php
    }
}

function home_grid_categories_register_widgets()
{
    register_widget('HomeWidgetGridCategories');
}

add_action('widgets_init', 'home_grid_categories_register_widgets');