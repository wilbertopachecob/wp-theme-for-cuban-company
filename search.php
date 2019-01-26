<?php
get_header();
global $wp_query;
?>
<div class="clearfix"></div>
<div id="super_contenedor">
    <div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <h1 class="search-title"> <?php echo $wp_query->found_posts; ?>
        <?php _e( 'Resultados de búsqueda para', 'locale' ); ?>: "<?php the_search_query(); ?>" </h1>

        <?php if ( have_posts() ) { ?>

            <article>

            <?php while ( have_posts() ) { the_post(); ?>
<div class="col-xs-12 col-sm-12 col-md-5" style="padding-left: 0px;">
<?php  the_post_thumbnail('large', array('class' => 'thumb pull-left img-responsive  img_post')) ?>     
</div>          
<h2 class="titulo_post"><a href="<?php echo get_permalink(); ?>">
                   <?php the_title();  ?>
                 </a></h3>
                 
                 <?php the_excerpt() ?>
                 <div class="h-readmore"> <a class="btn btn-primary" href="<?php the_permalink(); ?>">Leer m&aacute;s</a></div>
<hr/>
            <?php } ?>
            </article>

           <?php paginate_links(); ?>

        <?php } ?>

</div>
</div>
</div>
<?php get_footer(); ?>
</div>