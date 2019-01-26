<?php get_header(); ?>
<link rel="stylesheet" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/owl.carousel.css"/>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/owl.carousel.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/library/owl.carousel.js"></script>
<div class="clearfix"></div>
<div id="super_contenedor">
    <div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <h2 class="cabeceras"><img style="width: 200px; margin-top: 15px;"
                                           src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_icimaf_5.png">
                </h2>

                <p style="font-size: 9px; text-align: center">INSTITUTO DE CIBERNÉTICA, MATEMÁTICA Y FÍSICA</p>
                <hr>

                <!--<p> <h2 class="cabeceras">VISIÓN</h2>

                    Somos un centro de investigación de ciencias en matemática,
                    física y cibernética con una consolidada presencia nacional e
                    internacional y reconocido prestigio de su colectivo científico por
                    los resultados  obtenidos en las investigaciones y servicios científicos
                    y tecnológicos de alto valor agregado.

                    <h2 class="cabeceras">MISIÓN</h2>

                    Gestionar y ejecutar proyectos de investigación, desarrollo e
                    innovación en matemática, física y cibernética con personal
                    motivado y de competencia reconocida. Realizar actividades de
                    formación posgraduada, asesorías y servicios científicos y
                    tecnológicos que brinden soluciones de alto valor agregado.

                </p>-->

                <p>
                    Somos un centro de investigación de ciencias en matemática,
                    física y cibernética con una consolidada presencia nacional e
                    internacional y reconocido prestigio de su colectivo científico por
                    los resultados obtenidos en las investigaciones y servicios científicos
                    y tecnológicos de alto valor agregado.
                </p>

                <p>
                    Nuestra misi&oacute;n es gestionar y ejecutar proyectos de investigación, desarrollo e
                    innovación en matemática, física y cibernética con personal
                    motivado y de competencia reconocida. Realizar actividades de
                    formación posgraduada, asesorías y servicios científicos y
                    tecnológicos que brinden soluciones de alto valor agregado.
                </p>

                <div class="noticias">
                    <h2 class="cabeceras">NOTICIAS</h2>

                    <div class="clearfix"></div>
                    <style>
                        .crop_img_not > img {
                            height: 100px;
                            width: 100%;
                        }

                        .crop_img_not {
                        }
                    </style>
                    <div class="container-fluid">
                    <div class="row">
                        <?php
                        $myquery = new WP_Query("post_type=icimaf_noticias&meta_key=icimaf_noticias_perm&meta_value=1&posts_per_page=4&order=ASC");
                        //$args = array( 'post_type' => 'icimaf_noticias', 'posts_per_page' => 4 );
                        //$loop = new WP_Query( $args );
                        $cont = 0;
                        while ($myquery->have_posts()) :
                            $cont++;
                            if ($cont % 2 == 0) {

                            }
                            $myquery->the_post();
                            ?>
                            <div class="col-sm-6 col-md-5 col-lg-6">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="crop_img_not" >
                                        <?php
                                        // echo get_the_post_thumbnail_url($post,"full");
                                        // the_post_thumbnail('full');
                                        ?>
                                        <img src="<?=get_the_post_thumbnail_url($post,"full")?>" class="img-fluid" style="min-height: 300px !important;"/>
                                    </div>
                                <?php endif; ?>
                                <div class="news_date" style="margin-top: 5px;"><a href="<?php the_permalink(); ?>"
                                                          rel="bookmark"><?php echo the_time('d M Y'); ?></a></div>

                                <div class="news_title"><?php the_title() ?></div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                        </div>
                </div>
                <div style="clear: both;"></div>
                <?php mostrar_eventos(4); ?>
                <div style="clear: both;"></div>

                <hr style="color: #2A6D80; border: 1px solid #2A6D80;">
                <h2 class="cabecera_depart cabeceras"><a href="<?php echo site_url(); ?>/index.php/departamentos/">DEPARTAMENTOS</a>
                </h2>
                <?php query_posts('category_name=departamentos'); ?>
                <?php if (have_posts()) : ?>
                    <div class="clearfix"></div>
                    <div id="departamentos_home">
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="departamento">
                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                    <?php
                                    the_post_thumbnail('thumbnail');
                                    ?>
                                    <div><?php the_title(); ?></div>
                                </a>
                            </div>
                        <?php endwhile; ?>
                        <div style="clear: both"></div>
                    </div>
                <?php endif; ?>

                <div id="contenedor_mapa" class="row" style="margin: 50px 0px 70px 0px;">
                    <div id="ubicacion" class="col-xs-12 col-md-5">
                        <h3>UBICACI&Oacute;N</h3>
                        ICIMAF<br/>
                        Calle 15 #551 entre C y D, Vedado<br/>
                        Mcpio. Plaza de la Revolución<br/>
                        CP 10400, La Habana, Cuba
                    </div>
                    <div id="mapa" class="col-xs-12 col-md-5">
                        <?php //echo do_shortcode('[mappress mapid="1" width="425" height="350"]'); ?>
                        <a href="https://www.google.com.cu/maps/place/Instituto+de+Cibern%C3%A9tica,+Matem%C3%A1tica+y+F%C3%ADsica/@23.137016,-82.3964152,17z/data=!3m1!4b1!4m5!3m4!1s0x88cd7764833b0bf9:0x4912fb5d3e8d4df8!8m2!3d23.137016!4d-82.3942212?hl=es">
                            <?php echo '<img src="' . get_bloginfo('stylesheet_directory') . '/images/mapa.gif" />'; ?>
                        </a>
                    </div>
                    <div style="clear: both"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <?php get_footer(); ?>
</div>