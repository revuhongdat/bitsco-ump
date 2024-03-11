<?php

class HomeWidgetVideo extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Video',
            __('Home Video', 'iboss'), // Name
            array('description' => __('Show video', 'iboss'),) // Args
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

        $dem = 0;
        while ($wp_query->have_posts()) : $wp_query->the_post();
            $dem++;
            if ($dem == 1) {
                ?>
            <div class="box-category widget-video">
                <div class="title-box-category">
                    <h4 class="title-underline">
                        <a href="<?php echo $category_link; ?>" rel="boomark"
                           title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    </h4>
                </div>
                <div class="row">
                <div class="col-xs-12 col-sm-7 widget-video-featured">
                    <div class="card border-0 bg-transparent">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('large', array('class' => 'main-image card-img-top')); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-5 widget-video-other">
                    <div class="row">
                    <?php } else { ?>
                        <div class="col-xs-12 col-sm-6">
                            <div class="card border-0 bg-transparent">
                                <?php if (has_post_thumbnail()) : ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail('large', array('class' => 'small-image card-img-top')); ?>
                                    </a>
                                <?php endif; ?>
                                <div class="card-body p-0 pt-2">
                                    <h5 class="card-title title-ellipsis-2-line font-weight-bold">
                                        <a class="text-white" href="<?php the_permalink() ?>" rel="bookmark"
                                           title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
        <?php
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        ?>
                    </div><!-- /.row -->
                </div><!-- .widget-video-other -->
            </div><!-- /.row -->
        </div><!-- /.widget-video -->
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
                <?php _e('Title:', 'iboss'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text"
                       value="<?php echo $title; ?>"/>
            </label>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>">
                <?php _e('Category:', 'iboss'); ?>
                <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>"
                        name="<?php echo $this->get_field_name('category'); ?>">
                    <?php echo '<option value="0" ' . ('0' == $category ? 'selected="selected"' : '') . '>' . __('All categories', $this->localization_domain) . '</option>';
                    $cats = get_categories(array('hide_empty' => 0, 'taxonomy' => 'category', 'hierarchical' => 1));
                    foreach ($cats as $cat) {
                        echo '<option value="' . $cat->term_id . '" ' . ($cat->term_id == $category ? 'selected="selected"' : '') . '>' . $cat->name . '</option>';
                    }
                    ?>
                </select>
            </label>
        </p>

        <p>
            <label>Number of post</label>
            <input id="<?php echo $this->get_field_id('count'); ?>"
                   name="<?php echo $this->get_field_name('count'); ?>" type="text"
                   size="3" value="<?php echo $count; ?>"/>
            </label>
        </p>


        <?php
    }
}

function homevideo_register_widgets()
{
    register_widget('HomeWidgetVideo');
}

add_action('widgets_init', 'homevideo_register_widgets');