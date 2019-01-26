<?php /* Template Name: Departamentos */ ?>

<?php get_header(); ?>

<div class="clearfix"></div>
<div id="super_contenedor">
    <div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <div class="clearfix"></div>
                <h2 class="cabecera_depart cabeceras">DEPARTAMENTOS</h2>
                <?php query_posts('category_name=departamentos'); ?>
                <?php if (have_posts()) : ?>
                    <div class="clearfix"></div>
                    <div id="departamentos_home"
                         style="border-bottom: 1px solid #68A4BC; margin-top: 15px;padding-bottom: 15px;">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="departamento">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php
                                    the_post_thumbnail('thumbnail');
                                    ?>
                                    <br/>
                                    <div style="margin-top: 10px;"><?php the_title(); ?></div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                        <div style="clear: both"></div>
                    </div>
                <?php endif; ?>

                <?php query_posts('category_name=departamentos'); ?>
                <?php if (have_posts()) : ?>
                <div class="clearfix"></div>
                <div id="departamentos">
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="row row-eq-height" style="margin-top: 20px; display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
  flex-wrap: wrap;">
                            <?php
                            $titulo = get_the_title();
                            switch ($titulo) {
                                case 'Redes':
                                    $img = 'redes';
                                    break;
                                case 'Control Automático':
                                    $img = 'control';
                                    break;
                                case 'Física Aplicada':
                                    $img = 'fisica_aplicada';
                                    break;
                                case 'Física Teórica':
                                    $img = 'fisica_teorica';
                                    break;
                                case 'Matemática':
                                    $img = 'matematica';
                                    break;
                                case 'Matemática Interdisciplinaria':
                                    $img = 'matematica_interdisciplinaria';
                                    break;
                            }

                            ?>
                            <div class="col-xs-2" style="display: flex;
  flex-direction: column;">
                                <img style="display:block;margin: auto;"
                                     src="<?php echo get_stylesheet_directory_uri(); ?>/images/departamentos_img/<?php echo $img; ?>.png"/>
                            </div>
                            <div class="col-xs-10" style="display: flex;
  flex-direction: column;">
                                <h3 class="dep_titulo_principal" style="text-align: left; font-size: 20px;">
                                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title();
                                        ?>
                                    </a></h3>

                                <div>
                                    <?php the_content(); ?>
                                </div>
                            </div>

                        </div>
                        <!-- <hr style="color: #68A4BC;background-color: #68A4BC;"/> -->
                    <?php endwhile; ?>
                    <?php endif; ?>

                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>

    <?php get_footer(); ?>
</div>
