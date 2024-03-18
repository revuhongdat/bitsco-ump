<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <?php if (function_exists('iboss_breadcrumbs')) iboss_breadcrumbs(); ?>
        </div>
    </div>
    <div id="content" class="site-content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12"> 
                    <div class="news-detail" id="content-to-print">
                        <div class="title_post">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <div class="d-flex justify-content-between border-bottom py-2 mb-2">
                            <div class="text-muted">
                                <i class="far fa-clock"></i> <?php echo the_time('d/m/Y g:i:s'); ?>
                                <a style="color: #757575;" href="#!" role="button" class="increase-font" onclick="changeFontSize('increase')"><i class="fas fa-search-plus"></i></a>
                                <a style="color: #757575;" href="#!" role="button" class="decrease-font" onclick="changeFontSize('decrease')"><i class="fas fa-search-minus"></i></a>
                            </div>
                            <div class="share-buttons text-right">
                                Chia sẻ
                                <a class="btn btn-sm text-white" data-mdb-ripple-init style="background-color: #3b5998;" title="Chia sẻ bài viết lên facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" role="button"><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-sm text-white" data-mdb-ripple-init style="background-color: #55acee;" title="Chia sẻ bài viết lên twitter" href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" rel="noopener noreferrer" role="button"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-sm text-white" data-mdb-ripple-init style="background-color: #c61118;" title="Mail" href="mailto:?subject=<?php the_title(); ?>&body=<?php echo urlencode(get_permalink()); ?>" role="button"><i class="fas fa-envelope"></i></a>
                                <a class="btn btn-sm text-white" data-mdb-ripple-init style="background-color: #4c75a3;" title="Sao chép liên kết" href="#" onclick="copyToClipboard('<?php echo esc_url(get_permalink()); ?>')" role="button"><i class="fas fa-link"></i></a>
                            </div>
                        </div>
                        <div class="content-to-adjust-font">
                        <p class="font-weight-bold">
                            <?php echo get_the_excerpt(); ?>
                        </p>
                        <?php $orig_post = $post; // Load tin lien quan theo TAGS
                        global $post;
                        $tags = wp_get_post_tags($post->ID);
                        if ($tags) {
                            $tag_ids = array();
                            foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
                            $args = array(
                                'tag__in' => $tag_ids,
                                'post__not_in' => array($post->ID),
                                'posts_per_page' => 5, // Number of related posts that will be shown.
                                'ignore_sticky_posts' => 1
                            );
                            $my_query = new wp_query($args);
                            if ($my_query->have_posts()) {
                                echo '<div class="morenews" id="relatednews"><h4> <i class="fa fa-bookmark-o"></i>Tin liên quan</h4><ul>';
                                while ($my_query->have_posts()) {
                                    $my_query->the_post(); ?>
                                    <h2>
                                        <li><a href="<?php the_permalink() ?>" rel="bookmark"
                                               title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                                    </h2>
                                    <?php
                                }
                                echo '</ul></div>';
                            }
                        }
                        $post = $orig_post;
                        wp_reset_query(); ?>
                        <?php
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile; // End of the loop.
                        ?>
                        </div>
                        <?php iboss_entry_tag(); ?>
                        <?php $categories = get_the_category($post->ID);
                        if ($categories) {
                            $category_ids = array();
                            foreach ($categories as $individual_category) $category_ids[] = $individual_category->term_id;

                            $args = array(
                                'category__in' => $category_ids,
                                'post__not_in' => array($post->ID),
                                'showposts' => 5, // Số bài viết bạn muốn hiển thị.
                                'ignore_sticky_posts' => 1
                            );
                            $my_query = new wp_query($args);
                            if ($my_query->have_posts()) {
                                echo '
                                    <div class="related-posts mb-2">
                                       <div class="related-posts-title">
                                          <span class="h4">Tin liên quan</span>
                                       </div>
                                      <ul class="list-unstyled">';
                                while ($my_query->have_posts()) {
                                    $my_query->the_post();
                                    ?>
                                    <li>
                                        <a href="<?php the_permalink() ?>"
                                           title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                        <span class="text-muted"><?php echo get_the_date(); ?></span>
                                    </li>
                                    <?php
                                }
                                echo '</ul></div>';
                            }
                        }
                        ?>
                    </div><!--.news-detail-->
                </div><!-- .site-content-left -->
                
                <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="sticky-top" style="top: 80px;">
                    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-1')) :
                    else : ?>
                    <?php endif; ?>
                    </div>
                </div>.site-content-right -->
            </div>
        </div>
    </div><!-- .site-content -->

<?php get_footer();
