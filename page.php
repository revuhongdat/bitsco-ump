<?php get_header(); ?>

    <div id="content" class="site-content">
        <?php if (is_front_page()) { ?>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; endif; ?>
        <?php } else { ?>
            <div class="container">
                <div class="row mb-2">
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="news-detail">
                            <div class="title-underline mb-2">
                                <h1><?php the_title(); ?></h1>
                            </div>
                            <div class="archive-items">
                                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                    <?php the_content(); ?>
                                <?php endwhile; endif; ?>
                            </div>
                        </div>
                    </div><!-- .site-content-left -->
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="sticky-top" style="top: 80px;">
                            <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-1')) :
                            else : ?>
                            <?php endif; ?>
                        </div>
                    </div><!-- .site-content-right -->
                </div>
            </div>
        <?php } ?>
    </div><!-- .site-content -->

<?php get_footer();