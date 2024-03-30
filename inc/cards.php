<?php

class Cards extends WP_Widget
{

    function __construct()
    {
        parent::__construct(
            'Cards',
            __('Cards', 'iboss'), // Name
            array('Cards' => __('Hiển thị danh sách bài viết dạng lưới .', 'iboss'),) // Args
        );
    }

    function widget($args, $instance)
    {
        extract($args);
    
        $title = apply_filters('title', isset($instance['title']) ? esc_attr($instance['title']) : '');
        $category = apply_filters('category', isset($instance['category']) ? esc_attr($instance['category']) : '');
        $count = apply_filters('count', isset($instance['count']) && is_numeric($instance['count']) ? esc_attr($instance['count']) : 12);
    
        $category_link = get_category_link($category);
    
        echo $before_widget;
    
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; // Lấy trang hiện tại
        $wp_query = new WP_Query(array(
            'cat' => $category, 
            'posts_per_page' => $count,
            'paged' => $paged, // Truyền trang hiện tại vào truy vấn
        ));
        ?>
        <div class="row">
            <?php if (function_exists('iboss_breadcrumbs')) iboss_breadcrumbs(); ?>
        </div>
        <div class="row row-cols-1 row-cols-md-4">
            <?php
            while ($wp_query->have_posts()) : $wp_query->the_post(); 
                ?>
                <div class="col mb-4">
                    <div class="card h-100">
                        <?php
                        // Đường dẫn đến ảnh
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        ?>
                        <img class="card-img-top" src="<?php echo $image_url; ?>" alt="Card image">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <a 
                                href="<?php echo get_permalink(); ?>"
                                class="card-title"><?php echo get_the_title(); ?>
                            </a>
                            <a 
                                href="<?php echo get_permalink(); ?>" 
                                class="card-read-more">Xem thêm >
                            </a>
                        </div>
                    </div>
                </div>
    
            <?php
            endwhile;
            wp_reset_query();
            wp_reset_postdata();
            ?>
        </div>
        <?php
        // Hiển thị phân trang
        echo '<ul class="pagination d-flex justify-content-center">';
        $big = 999999999;
        echo paginate_links( array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages
        ) );
        echo '</ul>';
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
                       value="<?php echo $count; ?>"/>
            </label>
        </p>
        <?php
    }
}

function cards_register_widgets()
{
    register_widget('Cards');
}

add_action('widgets_init', 'cards_register_widgets');