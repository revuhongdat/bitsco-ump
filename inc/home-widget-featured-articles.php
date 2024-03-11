<?php

class HomeWidgetFeaturedArticles extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-Featured-Articles',
            __('Tin Nổi Bật', 'iboss'), // Name
            array('description' => __('Hiển thị 4 Bài Viết Nổi Bật', 'iboss'),) // Args
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
        <div class="box-category featured-articles">
            <?php
            $dem = 0;
            while ($wp_query->have_posts()) :
            $wp_query->the_post();
            $dem++;
            if ($dem == 1) {
            ?>
            <div class="row mb-2">
                <div class="col-xs-12 col-sm-12">
                    <div class="card border-0 featured-article">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('large', array('class' => 'main-image card-img-top')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body p-0 pt-2">
                            <h3 class="article-title card-title font-weight-bold">
                                <a href="<?php the_permalink() ?>" rel="bookmark"
                                   title="<?php the_title_attribute() ?>">
                                    <?php the_title() ?></a>
                            </h3>
                            <p class="card-text article-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 45); ?></p>
                        </div>
                    </div><!-- /.card -->
                </div>
            </div>

            <div class="row">
                <?php
                } else {
                    ?>
                    <div class="col-xs-12 col-sm-4">
                        <div class="card border-0 small-article">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('medium', array('class' => 'small-image card-img-top')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="card-body p-0 pt-2">
                                <h3 class="article-title card-title title-ellipsis-3-line font-weight-bold">
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                                </h3>
                            </div>
                        </div>
                    </div><!-- /.col-sm-4 -->
                    <?php
                }

                ?>
                <?php
                endwhile;
                wp_reset_query();
                wp_reset_postdata();
                ?>
            </div><!-- /.row -->
        </div> <!-- /.widget -->
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

function home_featured_articles_register_widgets()
{
    register_widget('HomeWidgetFeaturedArticles');
}

add_action('widgets_init', 'home_featured_articles_register_widgets');