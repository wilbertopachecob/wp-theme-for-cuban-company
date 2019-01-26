<?php get_header();?>

<div class="clearfix"></div>
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

            <?php //query_posts( 'posts_per_page=5&paged='.$paged ); ?>

            <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <?php if($post->post_content != "") : ?>

                    <!-- Start: Post -->

                    <div <?php post_class(); ?>>

                        <h3>

                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>

                        </h3>

                        <p class="post-meta">

                            <span ><?php the_time('l d/m/Y') ?></span>

                        </p>

                        <?php

                        if(!is_single()):

                            the_post_thumbnail('thumbnail');

                            the_excerpt();

                        else:

                            the_content();

                        endif; ?>


                        <?php /*if(has_tag()): ?><p class="tags"><span><?php the_tags(" ",""); ?></span></p><?php endif;*/ ?>


                    </div>


                    <!-- End: Post -->

                    <?php endif; ?>


                <?php endwhile; ?>

            <p style="clear: both">


            </p><?php comments_template(); ?>


            <?php wp_pagenavi(); ?>	<?php else : ?>


            <h2 class="center"><?php _e( 'Not found', 'orange_and_black' ); ?></h2>


            <p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'orange_and_black' ); ?></p>


            <?php get_search_form(); ?>	<?php endif; ?>

        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>

<?php get_footer(); ?>