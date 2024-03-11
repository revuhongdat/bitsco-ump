<?php

class HomeWidget3ColumnCategories extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'Home-Widget-3-Column-Categories',
            __('Chuyên Mục Kèm Bài Viết', 'iboss'), // Tên hiển thị của widget khi kéo thả
            array('description' => __('Widget hiển thị danh sách chuyên mục kèm bài viết', 'iboss'),) // Args
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
        <div class="box-category widget-article bg-green-100 p-3">
            <div class="title-box-category">
                <h4 class="title-underline" style="min-height: 72px;">
                    <a href="<?php echo $category_link; ?>" rel="boomark"
                       title="<?php echo $title; ?>"><?php echo $title; ?></a>
                </h4>
            </div>
            <div class="row">
                <?php
                $dem = 0;
                $lastElement = false;
                while ($wp_query->have_posts()) :
                $wp_query->the_post();
                if ($wp_query->current_post + 1 === $wp_query->post_count) {
                    // Đây là phần tử cuối cùng
                    $lastElement = true;
                }
                $dem++;
                if ($dem == 1) {
                ?>
                <div class="col-xs-12 col-sm-12">
                    <div class="small-article card bg-transparent mb-3 border-top-0 border-left-0 border-right-0 border-bottom rounded-0">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('large', array('class' => 'card-img-top')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="card-body p-0 pt-2 pb-2">
                            <h3 class="card-title title-ellipsis-3-line font-weight-bold article-title">
                                <a href="<?php the_permalink() ?>" rel="bookmark"
                                   title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                            </h3>
                            <p class="card-text article-excerpt title-ellipsis-2-line"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12">
                    <?php
                    }
                    else {
                        ?>

                        <div class="media <?php echo ($lastElement) ? '' : 'border-bottom'; ?> pb-2 mb-2">
                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'article-thumb align-self-center mr-2')); ?>
                                </a>
                            <?php endif; ?>
                            <div class="media-body">
                                <h3 class="article-title title-ellipsis-3-line">
                                    <a href="<?php the_permalink() ?>" rel="bookmark"
                                       title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                                </h3>
                            </div>
                        </div>
                        <?php
                    }

                    ?>


                    <?php
                    endwhile;
                    wp_reset_query();
                    wp_reset_postdata();
                    ?>
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
                       name="<?php echo $this->get_field_name('count'); ?>" type="text"
                       size="3" value="<?php echo $count; ?>"/>
            </label>
        </p>
        <?php
    }
}

function home_3_column_categories_register_widgets()
{
    register_widget('HomeWidget3ColumnCategories');
}

add_action('widgets_init', 'home_3_column_categories_register_widgets');