<?php

class TabsList extends WP_Widget
{

    function __construct()
    {
        // Instantiate the parent object
        parent::__construct(
            'TabsList',
            __('Tabs List', 'iboss'), // Name
            array('description' => __('Tabs List.', 'iboss'),) // Args
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
    <div class="container-flip d-flex justify-content-center">
        <button class="flip mr-3 ml-3 is-checked" data-panel="panel1">Community</button>
        <button class="flip mr-3 ml-3" data-panel="panel2">Relax</button>
        <button class="flip mr-3 ml-3" data-panel="panel3">Government</button>
        <button class="flip mr-3 ml-3" data-panel="panel4">Residents</button>
        <button class="flip mr-3 ml-3" data-panel="panel5">Business</button>
    </div>
    <div class="panel" id="panel1">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_102982556_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Service Request</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88662986_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Family Parents</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88886058_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Care Donation</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Animal Control</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Buildings</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="panel" id="panel2">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_102982556_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Service Request</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88662986_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Family Parents</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88886058_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Care Donation</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Animal Control</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="card" style="width: 100%;">
                        <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="#" class="card-title">Buildings</a>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="card-read-more">Read more ></a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="panel" id="panel3">
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_102982556_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Service Request</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88662986_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Family Parents</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88886058_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Care Donation</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Animal Control</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Buildings</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel" id="panel4">
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_102982556_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Service Request</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88662986_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Family Parents</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88886058_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Care Donation</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Animal Control</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Buildings</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel" id="panel5">
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_102982556_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Service Request</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88662986_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Family Parents</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_88886058_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Care Donation</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Animal Control</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card" style="width: 100%;">
                    <img src="https://dream-city.cmsmasters.net/wp-content/uploads/2016/11/Depositphotos_21832931_original-s.jpg"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="card-title">Buildings</a>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk
                            of the card's content.</p>
                        <a href="#" class="card-read-more">Read more ></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
                    wp_reset_query();
                    wp_reset_postdata();
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

function tabslist_register_widgets()
{
    register_widget('TabsList');
}

add_action('widgets_init', 'tabslist_register_widgets');