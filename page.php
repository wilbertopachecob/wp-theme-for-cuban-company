<?php get_header();?>

<div class="clearfix"></div>
<div id="super_contenedor">
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

        <?php //query_posts( 'posts_per_page=4&paged='.$paged ); ?>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <!-- Start: Post -->
                <div <?php post_class(); ?>>
                    <?php
                    //the_post_thumbnail('thumbnail');
                    the_content();
                    if(is_home()):
                        ?>
                        <p class="more"><a href="<?php the_permalink() ?>"><?php _e( 'Seguir leyendo', 'mitema' );?></a></p>
                    <?php endif;?>
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