<?php get_header();?>

<div class="clearfix"></div>
<div id="super_contenedor">
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

            <?php //query_posts( 'posts_per_page=4&paged='.$paged ); ?>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <!-- Start: Post -->
                    <div <?php post_class(); ?>>
                        <h2 class="post-title-container">
                            <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" class="post-title-link"><?php the_title(); ?></a>
                            <?php //edit_post_link(__('Edit this entry'),'',''); ?></h2>
                        <p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <span class="author"><?php the_author() ?></span> <span class="cats">
                                <?php the_category(", "); ?></span><?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span> <?php endif; ?></p>
                        <?php //the_post_thumbnail();
                        //if(has_post_thumbnail)
                        //echo 'thumnial';
                        //the_content('Read more', false);
                        //get_bloginfo('url');
                        the_post_thumbnail('thumbnail');
                        the_content();
                        if(is_home()):
                            ?>

                            <p class="more"><a href="<?php the_permalink() ?>"><?php _e( 'Seguir leyendo', 'mitema' );?></a></p>
                        <?php endif;?>
                        <?php if(has_tag()): ?><p class="tags"><span><?php the_tags(" ",""); ?></span></p><?php endif; ?>
                        <?php comments_template(); ?>
                    </div>
                    <!-- End: Post -->
                <?php endwhile; ?>

                <p class="pagination">
                    <span class="prev"><?php next_posts_link(__('Anterior', 'mitema')) ?></span>
                    <span class="next"><?php previous_posts_link(__('Siguiente', 'mitema')) ?></span>
                </p>
            <?php else : ?>
                <h2 class="center"><?php _e( 'Not found', 'orange_and_black' ); ?></h2>
                <p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'orange_and_black' ); ?></p>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>
<?php get_footer(); ?>
</div>