<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap">
    <!-- Bootstrap -->
    <link href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link href="--><?php //bloginfo('template_url'); ?><!--/css/mdb.min.css" rel="stylesheet">-->
    <!--    <link href="--><?php //bloginfo('template_url'); ?><!--/css/perfect-scrollbar.css" rel="stylesheet">-->
    <!-- Thêm file CSS của Owl Carousel -->
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/assets/owl.theme.default.min.css">
    <link href="<?php bloginfo('template_url'); ?>/style.css?v=1.0" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico"/>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site-inner">
    <header id="masthead" class="site-header py-2" role="banner">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="search-container">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-box">
                        <input type="search" name="s" id="searchleft" value="<?php the_search_query(); ?>" class="search" placeholder="Nhập từ khóa" aria-label="Search">
                        <label class="search-icon searchbutton" for="searchleft">
                            <i class="fas fa-search"></i>
                        </label>
                    </form>
                </div>
                <div class="flex-grow-1 text-center">
                    <?php iboss_logo(); ?>
                </div>
            </div>
        </div>
    </header><!-- .site-header -->
    <?php if (function_exists('max_mega_menu_is_enabled') && max_mega_menu_is_enabled('primary')) : ?>
        <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
    <?php endif; ?>
    <div class="container">
        <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('trending-now-widget')) :
        else : ?>
        <?php endif; ?>
    </div>
