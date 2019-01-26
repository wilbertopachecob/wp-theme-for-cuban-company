<?php /* Template Name: Blog */ ?>
<?php get_header();?>

<div class="clearfix"></div>
<div id="super_contenedor">
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

            <?php
            //categorias que no se deben mostrar en Blog
            /*$d_i = get_cat_ID('destacado');
            $p_i = get_cat_ID('personal');
            $t_i = get_cat_ID('testimonios');
            $s_i = get_cat_ID('servicios');
            $q_i = "cat=-$t_i,-$d_i,-$p_i,-$s_i";*/


            query_posts( "category_name=blog&posts_per_page=3&paged=" . $paged ); ?>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <!-- Start: Post -->
                    <div <?php post_class(); ?>>
                        <h3>
                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h3>
                        <p class="post-meta">
                            <span ><?php the_time('l d/m/Y') ?></span>
                        </p>
                            <?php
                                the_post_thumbnail('large');
                                the_excerpt();
                            ?>
                        </p>

                    </div>
                    <!-- End: Post -->
                <?php endwhile; ?>

               <!--  <p class="pagination">
                    <span class="prev"><?php next_posts_link(__('Anterior', 'mitema')) ?></span>
                    <span class="next"><?php previous_posts_link(__('Siguiente', 'mitema')) ?></span>
                </p> -->
                <?php wp_pagenavi(); ?>
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