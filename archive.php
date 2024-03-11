<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <?php if (function_exists('iboss_breadcrumbs')) iboss_breadcrumbs(); ?>
        </div>
    </div>
    <div id="content" class="site-content">
        <div class="container">
            <div class="row mb-2">
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="title-underline mb-2">
                        <h1><?php echo single_cat_title('', false); ?></h1>
                    </div>

                    <?php while (have_posts()) :
                    the_post(); ?>
                    <div class="media border-bottom pb-3 mb-3">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail('medium', array('class' => 'article-thumb align-self-center mr-2')); ?>
                            </a>
                        <?php endif; ?>
                        <div class="media-body">
                            <h3 class="article-title title-ellipsis-3-line">
                                <a href="<?php the_permalink() ?>"
                                   rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a>
                            </h3>
                            <p class="card-text article-excerpt"><time><?php echo the_time('d/m/Y \-\ g:i:s A'); ?></time>
                                <?php echo wp_trim_words(get_the_excerpt(), 45); ?></p>
                        </div>
                    </div>
                        <?php endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                        ?>
                    <div class="pagination">
                        <?php iboss_pagination(); ?>
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
    </div><!-- .site-content -->


<?php get_footer();
