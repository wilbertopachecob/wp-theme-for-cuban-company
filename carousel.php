<link rel="stylesheet" media="all"
      href="<?php echo get_stylesheet_directory_uri(); ?>/css/carousel.css"/><!-- Carousel -->
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/owl.carousel.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/owl.carousel.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/library/owl.carousel.js"></script>
<div id="myCarousel" style="margin-top:50px;" class="carousel slide col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php
    //$args = array('post_type' => 'icimaf_noticias', 'posts_per_page' => $cant);
    //Compruebo si hay 4 noticias destacadas
    $loop = new WP_Query("post_type=icimaf_noticias&meta_key=icimaf_noticias_perm&meta_value=1&posts_per_page=4&order=ASC");
    $i = 0;
    while ($loop->have_posts()) : $loop->the_post();
        if(has_post_thumbnail())
        $imagenes_c[] = '';//get_the_post_thumbnail_url($post, "full");
        $fecha_c[] = get_the_time('d M Y');
        $titulo_c[] = get_the_title();
        $link_c[] = get_the_permalink();
        $i++;
        if ($i == 4)
            break;
    endwhile;
    //Si no hay 4 noticias destacadas muestro solo las noticias nuevas
    if ($i < 4){
        $loop = new WP_Query("post_type=icimaf_noticias&meta_key=icimaf_noticias_perm&meta_value=0&posts_per_page=4&order=ASC");
        while ($loop->have_posts()) : $loop->the_post();
            if(has_post_thumbnail())
            $imagenes_c[] = get_the_post_thumbnail_url($post, "full");
            $fecha_c[] = get_the_time('d M Y');
            $titulo_c[] = get_the_title();
            if(has_post_thumbnail())
            $link_c[] = get_the_permalink();

            $i++;
            if ($i == 4)
                break;
        endwhile;

    }
    //En caso que no existan noticias relleno el carusel con las imagenes por defecto
    if(count($imagenes_c) < 4){
        $rellenar =  4 - count($imagenes_c);
        $slide_counter = 1;
        while($rellenar != 0):
            $imagenes_c[] = get_stylesheet_directory_uri()."/images/carousel/slide".$slide_counter.".jpg";
            $rellenar--;
            $slide_counter++;
            endwhile;
    }
    ?>

    <ol class="carousel-indicators"><!-- Indicators -->
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <!-- <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li> -->
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <div class="container">
                <div class="col-left">
                    <img class="img-responsive"
                         src="<?php echo get_stylesheet_directory_uri(); ?>/images/carousel/banner2_crop.jpg">
                </div>
            </div>
        </div>
        <!-- <div class="item">
            <div class="container">
                <div class="col-left">
                    <img class="img-responsive"
                         src="<?php echo $imagenes_c[0]; ?>">
                    <?php if( isset($fecha_c[0])): ?>
                    <div class="item_info hidden-sm hidden-xs">
                        <div class="carusel_new_fecha" style="color:#68a4bc;"><a href="<?php echo $link_c[0]; ?>"><?php echo $fecha_c[0]; ?></a></div>
                        <div class="carusel_new_titulo"><?php echo $titulo_c[0]; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="col-left">
                    <img class="img-responsive"
                         src="<?php echo $imagenes_c[1]; ?>">
                    <?php if( isset($fecha_c[1])): ?>
                    <div class="item_info hidden-sm hidden-xs">
                        <div class="carusel_new_fecha" style="color:#68a4bc;"><a href="<?php echo $link_c[1]; ?>"><?php echo $fecha_c[1]; ?></a></div>
                        <div class="carusel_new_titulo"><?php echo $titulo_c[1]; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div> -->
        <div class="item">
            <div class="container">
                <div class="col-left">
                    <img class="img-responsive"
                         src="<?php echo $imagenes_c[2]; ?>">
                    <?php if( isset($fecha_c[2])): ?>
                    <div class="item_info hidden-sm hidden-xs">
                        <div class="carusel_new_fecha" style="color:#68a4bc;"><a href="<?php echo $link_c[2]; ?>"><?php echo $fecha_c[2]; ?></a></div>
                        <div class="carusel_new_titulo"><?php echo $titulo_c[2]; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="container">
                <div class="col-left">
                    <img class="img-responsive"
                         src="<?php echo $imagenes_c[3]; ?>">
                    <?php if( isset($fecha_c[3])): ?>
                    <div class="item_info hidden-sm hidden-xs">
                        <div class="carusel_new_fecha" style="color:#68a4bc;"><a href="<?php echo $link_c[3]; ?>"><?php echo $fecha_c[3]; ?></a></div>
                        <div class="carusel_new_titulo"><?php echo $titulo_c[3]; ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!--<a class="left carousel-control" href="#myCarousel" data-slide="prev"><div><i class="fa fa-chevron-left"></i></div></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><div><i class="fa fa-chevron-right"></i></div></a>-->

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev" style="display:none;">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"><i class="fa fa-chevron-left"></i></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next" id="carousel_trigger"
       style="display:none;">
        <span id="span_carusel" class="glyphicon glyphicon-chevron-right" aria-hidden="true"><i id="i_carusel"
                                                                                                class="fa fa-chevron-right"></i></span>
        <span class="sr-only">Pr&oacute;lximo</span>
    </a>
    <!--<div class="carousel-central-img">
        <?php
    $url_img = "logo_icimaf_1bg.png";
    if (is_single()):
        $ID = $wp_query->post->ID;
        if (in_category('Departamentos', $ID)):
            $meta_img = get_post_meta($ID, 'Departamento', true);
            switch ($meta_img):
                case 1:
                    $url_img = "control_bg.png";
                    break;
                case 2:
                    $url_img = "fisica_aplicada_bg.png";
                    break;
                case 3:
                    $url_img = "fisica_teorica_bg.png";
                    break;
                case 4:
                    $url_img = "matematica_bg.png";
                    break;
                case 5:
                    $url_img = "matematica_interdisiplinaria_bg.png";
                    break;
                case 6:
                    $url_img = "redes_bg.png";
                    break;
            endswitch;
        endif;
    endif;
    ?>

        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/<?php echo $url_img; ?>">

    </div>-->
</div>
<div class="clearfix"></div>
<!-- Para disparar el carusel-->
<script type="application/javascript">
    function gatillo() {
        $('#carousel_trigger,#span_carusel,#i_carusel').trigger('click');
    }
    $(document).ready(function () {
        setTimeout(gatillo, 5000);
        //para esconder el carusel en scroll
        window.addEventListener("scroll", function (event) {
        //resolviendo el problema con el sroll descontrolado
            if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                event.preventDefault();
                return false;
   }
            let heightCarousel = $('.carousel-inner').height();
            var top = this.scrollY,
                top = heightCarousel+70 - top;
             
                
            if (this.scrollY !== 0) {
            $('#header').css({'position': 'fixed'});
                $('#super_contenedor').css({
                    'margin-top': '3%',
                    'position': 'absolute',
                    'top': top
                });
                $(".carousel-indicators").hide();
                $("#myCarousel").css({
                    'margin-top': '5em',
                    'position': 'fixed'
                    });
            }
            else{
                $(".carousel-indicators").show();
            }
        }, false);
    });

</script>
