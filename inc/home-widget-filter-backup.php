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
        $category = apply_filters('category', isset($instance['category']) ? esc_attr($instance['category']) : '');
        $count = apply_filters('count', isset($instance['count']) && is_numeric($instance['count']) ? esc_attr($instance['count']) : '');

        $category_link = get_category_link($category);

        echo $before_widget;

        $wp_query = new WP_Query(array(
            'cat' => $category,
            'posts_per_page' => $count,
        ));
        ?>
            
    <div class="filter-block mt-5">
        <div>
            <h4 class="text-center">Programs and Initiatives</h4>
            <p class="text-center">Welcome to the City of Dream</p>
        </div>

        <div id="filters" class="button-group d-flex justify-content-center align-items-center">  
            <button class="button is-checked" data-filter="*">All Categories</button>
            <button class="button" data-filter=".eco">Eco</button>
            <button class="button" data-filter=".programs">Programs</button>
            <button class="button" data-filter=".social-life, .programs">Social life</button>
            <button class="button" data-filter=":not(.programs)">Sport</button>
            <button class="button" data-filter=".eco:not(.programs), .technology">Technology</button>
            <!-- <button class="button" data-filter="numberGreaterThan50">number > 50</button>
            <button class="button" data-filter="ium">name ends with &ndash;ium</button> -->
        </div>

        <div class="grid row">
            <div class="col-4 element-item programs eco " data-category="eco">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/5253789_l-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Consumer Protection</div>
                    <div class="my-category">in Programs, Technology</div>
                </div>
            </div>

            <div class="col-4 element-item sport eco " data-category="sport">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/baseball-player-pitcher-ball-163487-large-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Sport Life</div>
                    <div class="my-category">in Programs, Sport</div>
                </div> 
            </div>

            <div class="col-4 element-item social-life technology eco" data-category="social-life">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/Depositphotos_46326837_original-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Education</div>
                    <div class="my-category">in Programs, Social life</div>
                </div>
            </div>

            <div class="col-4 element-item technology sport" data-category="technology">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/Depositphotos_69019339_original-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Grants</div>
                    <div class="my-category">in Programs, Social life</div>
                </div>
            </div>

            <div class="col-4 element-item programs technology" data-category="programs">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/Depositphotos_23729097_original-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Environment</div>
                    <div class="my-category">in Programs, Social life</div>
                </div>
            </div>

            <div class="col-4 element-item technology " data-category="technology">
                <div class="item-container">
                    <img class="item-img" src="https://dream-city.cmsmasters.net/wp-content/uploads/2015/01/Depositphotos_88884488_original-s.jpg" alt="">
                </div>
                <div class="item-footer">
                    <div class="my-symbol">Technology</div>
                    <div class="my-category">in Programs</div>
                </div>
            </div>
        </div>
    </div>

            <?php
                wp_reset_query();
                wp_reset_postdata();
            ?>
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

function home_filter_register_widgets()
{
    register_widget('HomeWidgetFilter');
}

add_action('widgets_init', 'home_filter_register_widgets');