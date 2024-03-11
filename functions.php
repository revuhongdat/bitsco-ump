<?php
/**
 * apave functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package apave
 */

//add redux theme option
if (!class_exists('ReduxFramewrk')) {
    require_once(dirname(__FILE__) . '/ReduxCore/framework.php');
}
if (!isset($redux_demo)) {
    require_once(dirname(__FILE__) . '/ReduxCore/config.php');
}

if (!function_exists('iboss_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function iboss_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on apave, use a find and replace
         * to change 'iboss' to the name of your theme in all the template files.
         */
        load_theme_textdomain('iboss', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'iboss'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('iboss_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));
    }
endif;
add_action('after_setup_theme', 'iboss_setup');

//function enqueue_slick_scripts() {
//    wp_enqueue_style('slick-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
//    wp_enqueue_style('slick-theme-css', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css');
//    wp_enqueue_script('slick-js', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), null, true);
//}
//
//add_action('wp_enqueue_scripts', 'enqueue_slick_scripts');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function iboss_content_width()
{
    $GLOBALS['content_width'] = apply_filters('iboss_content_width', 640);
}

add_action('after_setup_theme', 'iboss_content_width', 0);


/**
 * Load trending-now.
 */
require get_template_directory() . '/inc/home-widget-trending-now.php';
/**
 * Load Tin Nổi Bật.
 */
require get_template_directory() . '/inc/home-widget-featured-articles.php';
/**
 * Load Thông Báo Mới Nhất.
 */
require get_template_directory() . '/inc/home-widget-latest-announcements.php';
/**
 * Load Chuyên Mục Nổi Bật.
 */
require get_template_directory() . '/inc/home-widget-featured-category.php';
/**
 * Load 3 Cột Chuyên Mục.
 */
require get_template_directory() . '/inc/home-widget-3-column-categories.php';
/**
 * Load 3 Cột Chuyên Mục.
 */
require get_template_directory() . '/inc/home-widget-grid-categories.php';
/**
 * Load Home Event.
 */
require get_template_directory() . '/inc/home-widget-event.php';
/**
 * Load Home Video.
 */
require get_template_directory() . '/inc/home-widget-video.php';
register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', 'iboss' ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', 'iboss' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
) );
register_sidebar(array(
    'name' => esc_html__('Tin hot', 'iboss'),
    'id' => 'trending-now-widget',
    'description' => esc_html__('Add widgets here.', 'iboss'),
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '',
    'after_title' => '',
));


/**
 * Share Social Network.
 */

function iboss_social()
{
    ?>
    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.7&appId=1561705274130123";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

    <div class="fb-like" data-href="<?php the_permalink() ?>" data-layout="button_count" data-action="like"
         data-size="small" data-show-faces="false" data-share="true"></div>
    <?php
}

/**
 * Page navi.
 */
if (!function_exists('iboss_pagination')) {
    function iboss_pagination()
    {
        global $wp_query;
        $big = 999999999;
        echo '<div class="page_nav">';
        echo paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages
        ));
        echo '</div>';
    }
}


/**
 * Thiết lập hàm hiển thị logo @ iboss_logo().
 */
if (!function_exists('iboss_logo')) {
    function iboss_logo()
    {
        global $tp_options;
        if ($tp_options['logo-on'] == 1) : ?>
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img src="<?php echo $tp_options['logo-image']['url']; ?>" alt="<?php wp_title(''); ?>"
                     width="500px" height="auto" class="logo img-fluid">
            </a>
        <?php else : ?>

            <div class="logo">
                <div class="site-name">
                    <?php if (is_home()) {
                        printf('<h1><a href="%1$s" title="%2$s">%3$s</a></h1>',
                            get_bloginfo('url'),
                            get_bloginfo('description'),
                            get_bloginfo('sitename')
                        );
                    } else {
                        printf('<a href="%1$s" title="%2$s">%3$s</a>',
                            get_bloginfo('url'),
                            get_bloginfo('description'),
                            get_bloginfo('sitename')
                        );
                    } // endif ?>
                </div>
            </div>

        <?php endif;
    }
}

/**
 * Thiết lập hàm hiển thị Breadcrumbs.
 */

function iboss_breadcrumbs()
{

    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    //$delimiter = '<span class="divider">/</li>'; // delimiter between crumbs
    $delimiter = ''; // delimiter between crumbs
    $home = 'Trang chủ'; // text for the 'Home' link
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<li class="breadcrumb-item active">'; // tag before the current crumb
    $after = '</li>'; // tag after the current crumb

    global $post;
    $homeLink = get_bloginfo('url');

    if (is_home() || is_front_page()) {

        if ($showOnHome == 1) echo '<nav aria-label="breadcrumb bg-transparent"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="' . $homeLink . '">' . $home . '</a></li></ol></nav>';

    } else {

        echo '<nav aria-label="breadcrumb"><ol class="breadcrumb bg-transparent"><li class="breadcrumb-item"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . '</li> ';

        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) echo '<li class="breadcrumb-item">' . get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ') . '</li>';
            echo $before . '' . single_cat_title('', false) . '' . $after;

        } elseif (is_search()) {
            echo $before . 'Kết quả tìm kiếm từ khóa "' . get_search_query() . '"' . $after;

        } elseif (is_day()) {
            echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
            echo '<li class="breadcrumb-item"><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . '</li> ';
            echo $before . get_the_time('d') . $after;

        } elseif (is_month()) {
            echo '<li class="breadcrumb-item"><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . '</li> ';
            echo $before . get_the_time('F') . $after;

        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;

        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<li class="breadcrumb-item"><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . '</li> ');
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                echo '<li class="breadcrumb-item">' . $cats . '</li>';
                if ($showCurrent == 1) echo $before . get_the_title() . $after;
            }

        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . '</li> ');
            echo '<li class="breadcrumb-item"><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;

        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) echo $before . get_the_title() . $after;

        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1) echo ' ' . $delimiter . '</li> ';
            }
            if ($showCurrent == 1) echo ' ' . $delimiter . '</li> ' . $before . get_the_title() . $after;

        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;

        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }

        echo '</ol></nav>';

    }
} // end dimox_breadcrumbs() 

/**
 * Thiết lập hàm hiển thị TAGS.
 */

if (!function_exists('iboss_entry_tag')) {
    function iboss_entry_tag()
    {
        if (has_tag()) :
            echo '<div class="tag_post mt tag_width">';
            printf(__('<span class="glyphicon glyphicon-bookmark" aria-hidden="true"> TAGS :</span> %1$s', 'iboss'), get_the_tag_list(' ', ' '));
            echo '</div>';
        endif;
    }

    /**
     * Thiết lập hàm hiển thị ngày tháng hiện tại.
     */
    if (!function_exists('current_day')) {
        function current_day()
        {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $weekday = date("l");
            $weekday = strtolower($weekday);
            switch ($weekday) {
                case 'monday':
                    $weekday = 'Thứ hai';
                    break;
                case 'tuesday':
                    $weekday = 'Thứ ba';
                    break;
                case 'wednesday':
                    $weekday = 'Thứ tư';
                    break;
                case 'thursday':
                    $weekday = 'Thứ năm';
                    break;
                case 'friday':
                    $weekday = 'Thứ sáu';
                    break;
                case 'saturday':
                    $weekday = 'Thứ bảy';
                    break;
                default:
                    $weekday = 'Chủ nhật';
                    break;
            }
            return $weekday . ', ' . date('d/m/Y H:i:s');
        }
    }
}  

/* Add bootstrap support to the Wordpress theme*/

function theme_add_bootstrap() {
	wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/assets/my-assets/bootstrap.min.css' );
	wp_enqueue_style( 'carousel-css', get_template_directory_uri() . '/assets/my-assets/owl.carousel.min.css' );
	wp_enqueue_style( 'default-css', get_template_directory_uri() . '/assets/my-assets/owl.theme.default.min.css' );
	wp_enqueue_style( 'style-css', get_template_directory_uri() . '/assets/my-assets/style.css' );
	wp_enqueue_script( 'carousel-js', get_template_directory_uri() . '/assets/my-assets/owl.carousel.min.js', array(), '3.0.0', true );
	wp_enqueue_script( 'isotope-pkgd-js', get_template_directory_uri() . '/assets/my-assets/isotope.pkgd.min.js', array(), null, true );
	wp_enqueue_script( 'main-js', get_template_directory_uri() . '/assets/my-assets/main.js', array(), '3.0.0', true );
	}
	
	add_action( 'wp_enqueue_scripts', 'theme_add_bootstrap' );

/**
 * Load trending-now.
 */
// require get_template_directory() . '/inc/home-widget-trending-now.php';

/**
 * Load carousel.
 */
require get_template_directory() . '/inc/home-widget-carousel.php';

/**
 * Load filter.
 */
require get_template_directory() . '/inc/home-widget-filter.php';

/**
 * Load tabslist.
 */
require get_template_directory() . '/inc/tabslist.php';

function add_tablist() {
    wp_enqueue_style( 'owl-carousel-css', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.css' );
	wp_enqueue_style( 'owl-theme-default-min-css', get_template_directory_uri() . '/assets/owl-carousel/owl.theme.default.min.css' );
    wp_enqueue_script( 'jquery-min-js', get_template_directory_uri() . '/assets/owl-carousel/jquery-3.7.1.min.js', array(), '3.1.1', true );
    wp_enqueue_script( 'owl-carousel-min-js', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array(), '1.0.0', true );
    wp_enqueue_style( 'bootstrap-min-css', get_template_directory_uri() . '/assets/owl-carousel/bootstrap.min.css' );
	wp_enqueue_style( 'tabslist-css', get_template_directory_uri() . '/assets/owl-carousel/tabslist.css' );
	wp_enqueue_style( 'main-css', get_template_directory_uri() . '/assets/owl-carousel/main.css' );
	wp_enqueue_script( 'tabslist-js', get_template_directory_uri() . '/assets/owl-carousel/tabslist.js', array(), '1.0.0', true );
    wp_enqueue_script( 'card-js', get_template_directory_uri() . '/assets/owl-carousel/card.js', array(), '3.0.0', true );
	}	
	add_action( 'wp_enqueue_scripts', 'add_tablist' );