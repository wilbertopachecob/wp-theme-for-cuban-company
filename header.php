<?php /** * The Header template for our theme */ ?>
    <!DOCTYPE html>
    <!--[if IE 7]><html class="ie ie7" <?php language_attributes(); ?>><![endif]-->
    <!--[if IE 8]><html class="ie ie8" <?php language_attributes(); ?>><![endif]-->
    <!--[if !(IE 7) & !(IE 8)]><!--><html <?php language_attributes(); ?>><!--<![endif]-->

    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <title><?php is_front_page() ? bloginfo('description') : wp_title( '|', true, 'right' ); ?> <?php bloginfo('name'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendors/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendors/font-awesome.min.css">
        <link rel="stylesheet" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/header.css" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url');?>">
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/jquery.js">	</script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/respond.matchmedia.addListener.min.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/respond.min.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/modernizr-2.6.2.min.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/jquery.customSelect.min.js"></script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/jquery-ui-1.10.js">	</script>
        <script src="<?php echo get_stylesheet_directory_uri(); ?>/vendors/bootstrap.min.js"></script>
        <?php wp_head(); ?>
        <?php mitema_load_custom_styles(); ?>
        <!--[if IE]>
        <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/basico_ie.css" type="text/css">
        <![endif]-->
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {
                //Para abrir la pagina en el tope y evitar problemas con el carrusel
                $(window).scrollTop(0);

                calculateHeight();

                function calculateHeight() {
                    //esto es solo para cuando no es media
                    if ($("#logo").css("display") != "none" ){
                        //-------------------las noticias-------------------
                        $('#noticias_contenido').css('maxWidth', '100%');
                        var lisInRow = 0;//aqui queda cuantos elementos hay por fila
                        $('.noticias_home').each(function() {
                            if($(this).prev().length > 0) {
                                if($(this).position().top != $(this).prev().position().top)
                                    return false;
                                lisInRow++;
                            }
                            else {
                                lisInRow++;
                            }
                        });
                        //se pone el ancho del div segun los que estan en la misma fila
                        var width_element = $('.noticias_home').width();
                        if(lisInRow < 4)
                        {
                            width_element = width_element + 12;//por los padding
                            $('.noticias_home').css('minWidth', width_element+'px');
                            width_div = width_element * lisInRow + 5;
                            $('#noticias_contenido').css('maxWidth', width_div+'px');
                        }
                        //ahora se ponen las alturas de los elementos segun los que estan en la misma fila
                        var maxHeight = 0;
                        $('.noticias_home').css('minHeight', '0');
                        var i = 0;
                        var heights = [];
                        $('.noticias_home' ).each( function( index, element ) {
                            var height = $( element ).height();
                            if(height > maxHeight)
                            {
                                maxHeight = height;
                            }
                            if(i+1 == lisInRow)
                            {
                                heights.push(maxHeight+5);
                                i = 0;
                                maxHeight = 0;
                            }
                            else
                            {
                                i++;
                            }
                        });
                        heights.push(maxHeight+5);
                        var counter = 0;
                        $('.noticias_home' ).each( function( index, element ) {
                            $(element).css('minHeight',heights[Math.floor(counter/lisInRow)]+'px');
                            counter++;
                        });

                        //--------------el encabezado de los eventos-----------
                        $('#eventos_contenido').css('maxWidth', '100%');
                        lisInRow = 0;//aqui queda cuantos elementos hay por fila
                        $('.evento').each(function() {
                            if($(this).prev().length > 0) {
                                if($(this).position().top != $(this).prev().position().top)
                                {
                                    return false;
                                }
                                lisInRow++;
                            }
                            else {
                                lisInRow++;
                            }
                        });

                        //se pone el ancho del div segun los que estan en la misma fila
                        width_element = $('.evento').width();
                        if(lisInRow < 4)
                        {
                            $('.evento').css('minWidth', width_element+'px');
                            width_div = width_element * lisInRow + 5;
                            $('#eventos_contenido').css('maxWidth', width_div+'px');
                        }

                        //ahora se ponen las alturas de los elementos segun los que estan en la misma fila
                        maxHeight = 0;
                        $('.evento_titulo').css('minHeight', '0');
                        i = 0;
                        heights = [];
                        $('.evento_titulo' ).each( function( index, element ) {
                            var height = $( element ).height();
                            if(height > maxHeight)
                            {
                                maxHeight = height;
                            }
                            if(i+1 == lisInRow)
                            {
                                heights.push(maxHeight+10);
                                i = 0;
                                maxHeight = 0;
                            }
                            else
                            {
                                i++;
                            }
                        });
                        heights.push(maxHeight+10);
                        counter = 0;
                        $('.evento_titulo' ).each( function( index, element ) {
                            $(element).css('minHeight',heights[Math.floor(counter/lisInRow)]+'px');
                            counter++;
                        });

                        //-------------los eventos--------------------
                        //lisInRow ya se tiene de arriba

                        //ahora se ponen las alturas de los elementos segun los que estan en la misma fila
                        maxHeight = 0;
                        $('.evento').css('minHeight', '0');
                        i = 0;
                        heights = [];
                        $('.evento' ).each( function( index, element ) {
                            var height = $( element ).height();
                            if(height > maxHeight)
                            {
                                maxHeight = height;
                            }
                            if(i+1 == lisInRow)
                            {
                                heights.push(maxHeight+5);
                                i = 0;
                                maxHeight = 0;
                            }
                            else
                            {
                                i++;
                            }
                        });
                        heights.push(maxHeight+5);
                        counter = 0;
                        $('.evento' ).each( function( index, element ) {
                            $(element).css('minHeight',heights[Math.floor(counter/lisInRow)]+'px');
                            counter++;
                        });
                    }

                    //en los departamentos no importa si es media o no
                    //--------------------los departamentos---------------------
                    maxHeight = 0;
                    $('.departamento').css('minHeight', '0');
                    $('.departamento' ).each( function( index, element ) {
                        var height = $( element ).height();
                        if(height > maxHeight)
                        {
                            maxHeight = height;
                        }
                    });
                    maxHeight = maxHeight + 10;//asi es como funciona, pero ver/////////////
                    $('.departamento').css('minHeight',maxHeight+'px');

                    //y ahora a todos los div de departamentos se les pone el mismo ancho
                    $('#departamentos_home').css('maxWidth', '100%');

                    $('.departamento').css('maxWidth', '100%');
                    $('.departamento').css('minWidth', '0');
                    width_div = $('#departamentos_home').width();
                    var count_departs = $('.departamento').length;
                    var depart_width = 82;
                    if(width_div/count_departs > 82)
                    {
                        depart_width = width_div/count_departs;
                    }
                    $('.departamento').css({
                        'maxWidth': depart_width+'px',
                        'minWidth': depart_width+'px'
                    });

                    //y ahora(que todos los departs tienen el mismo ancho)
                    // se le pone el ancho al div que contiene los departamentos
                    lisInRow = 0;//aqui queda cuantos elementos hay por fila
                    $('.departamento').each(function() {
                        if($(this).prev().length > 0) {
                            if($(this).position().top != $(this).prev().position().top)
                                return false;
                            lisInRow++;
                        }
                        else {
                            lisInRow++;
                        }
                    });
                    //se pone el ancho del div segun los que estan en la misma fila
                    width_div = depart_width * lisInRow;
                    $('#departamentos_home').css('maxWidth', width_div+'px');

                    //en los miembros no importa si es media o no
                    //--------------------los miembros---------------------
                    claculateMarginMiembros('miembros');
                    claculateMarginMiembros('miembros_single');

                    /*********************Media y NO*****************************/
                    //las propiedades que en media se cambiaron por js hay que volverlas a poner como eran
                    if ($("#logo").css("display") != "none" ){
                        $('#menu-cabecera').css('display', 'block');
                        $('#second-menu').css('display', 'none');
                        $('#third-menu').css('display', 'none');
                        $('#second-menu-ul').css('display', 'none');
                        $('#third-menu-ul').css('display', 'none');
                    }
                    //y lo que se cambia en la primera parte de arriba, hay que volver a cambiarlo cuando vuelva para media
                    else
                    {
                        $('#menu-cabecera').css('display', 'none');
                        createMenuAcoordingToPage();
                    }
                }
                $(window).resize(calculateHeight);

                function claculateMarginMiembros(miembro_class)
                {
                    //para centrarlos
                    var lisInRow = 0;//aqui queda cuantos elementos hay en la fila con mas elementos
                    var tmpInRow = 0;
                    $('.'+miembro_class+' ul li').each(function() {
                        if($(this).prev().length > 0) {
                            if($(this).position().top != $(this).prev().position().top)
                            {
                                if(tmpInRow > lisInRow)
                                    lisInRow = tmpInRow;
                                tmpInRow = 0;
                            }
                            else
                            {
                                tmpInRow++;
                            }
                        }
                        else {
                            if(tmpInRow > lisInRow)
                                lisInRow = tmpInRow;
                            tmpInRow = 1;
                        }
                    });
                    if(tmpInRow > lisInRow)
                        lisInRow = tmpInRow;
                    $('.'+miembro_class+' ul').css('margin-left', '0');
                    var m_width = $('.'+miembro_class+' ul').outerWidth();// da el ancho del 1ro, pero todos son iguales
                    var li_width = $('.'+miembro_class+' ul li').outerWidth() + 10;// da el ancho del 1ro, pero todos son iguales (10 del margen)
                    var margin_left = (m_width-(li_width*lisInRow))/2;
                    $('.'+miembro_class+' ul').css('margin-left', margin_left+'px');
                }

                function claculateHeightMiembros(miembro_class)
                {
                    //la altura solo se fija la 1ra vez (pk todos tiene el mismo ancho)
                    //y es igual para todos los del mismo depart/////////////////(igual para todos)
                    //pk al final nunca debe ser mas de 2 lineas
                    $('.'+miembro_class+' ul li').css('minHeight', '0');
                    var maxHeight = 0;
                    $('.'+miembro_class+' ul li').each( function( index, element ) {
                        var height = $( element ).height();
                        if(height > maxHeight)
                        {
                            maxHeight = height;
                        }
                    });
                    maxHeight = maxHeight + 5;
                    $('.'+miembro_class+' ul li').css('minHeight', maxHeight+'px');
                }

                //en los miembros no importa si es media o no
                //--------------------los miembros---------------------
                claculateHeightMiembros('miembros');
                claculateHeightMiembros('miembros_single');


                //para cuando no es media los sub menu se ajustan
                if ($("#logo").css("display") != "none" ){
                    //para ajustar bien la separacion vertical de los elementos del menu desplegable
                    var pos = 0;
                    $('#menu-menu-principal > li > ul:visible > li').each(function(){
                        if($(this).next().length == 0)
                            return false;
                        if($(this).position().left != $(this).next().position().left)
                        {
                            pos = $(this).next().position().left;
                            if(pos < $(this).position().left)
                                pos = $(this).position().left;
                            return false;
                        }
                        return false;
                    });
                    if(pos != 0)
                    {
                        $('#menu-menu-principal > li > ul:visible > li').each(function(){
                            if($(this).position().left == pos)
                            {
                                //ojo, aqui se forma
                                $(this).css('float','right');
                            }
                        });
                    }
                }

                function createUlClone(element, id)
                {
                    var ul_element = $('<ul id="'+id+'"></ul>')
                    $(element).children().each(function(index, element_li){
                        var li_element = $('<li class="second-menu-li"></li>');
                        var a_element = $(element_li).children().first().clone();
                        a_element.appendTo(li_element);
                        li_element.appendTo(ul_element);
                    });
                    return ul_element;
                }

                function createMenuAcoordingToPage()
                {
                    var find = false;
                    var current_href = $(location).attr('href');
                    $('#menu-menu-principal a').each( function( index, element ) {
                        //si la pagina se puede acceder desde el menu
                        if($(element).attr('href') == current_href && !find)
                        {
                            //si es una opcion del menu de 1er nivel
                            if($(element).parent().parent().attr('id') == 'menu-menu-principal')
                            {
                                //si esta opcion tiene sub-opciones
                                if($(element).next().length > 0)
                                {
                                    $('.second-menu-text').text($(element).text());
                                    $('#second-menu').css('display', 'block');
                                    if($('#second-menu-ul').length == 0)
                                        createUlClone($(element).next(), 'second-menu-ul').appendTo('#second-menu');
                                }
                            }
                            //si es una opcion del menu de 2do nivel
                            else if($(element).parent().parent().parent().parent().attr('id') == 'menu-menu-principal')
                            {
                                $('.second-menu-text').text($(element).parent().parent().prev().text());
                                $('#second-menu').css('display', 'block');
                                if($('#second-menu-ul').length == 0)
                                    createUlClone($(element).parent().parent(), 'second-menu-ul').appendTo('#second-menu');
                                //si esta opcion tiene sub-opciones
                                if($(element).next().length > 0)
                                {
                                    $('.third-menu-text').text($(element).text());
                                    $('#third-menu').css('display', 'block');
                                    if($('#third-menu-ul').length == 0)
                                        createUlClone($(element).next(), 'third-menu-ul').appendTo('#third-menu');
                                }
                            }
                            //si es una opcion del menu de 3er nivel
                            else if($(element).parent().parent().parent().parent().parent().parent().attr('id') == 'menu-menu-principal')
                            {
                                $('.second-menu-text').text($(element).parent().parent().parent().parent().prev().text());
                                $('#second-menu').css('display', 'block');
                                if($('#second-menu-ul').length == 0)
                                    createUlClone($(element).parent().parent().parent().parent(), 'second-menu-ul').appendTo('#second-menu');

                                $('.third-menu-text').text($(element).parent().parent().prev().text());
                                    $('#third-menu').css('display', 'block');
                                    if($('#third-menu-ul').length == 0)
                                        createUlClone($(element).parent().parent(), 'third-menu-ul').appendTo('#third-menu');
                            }
                            find = true;
                        }
                    });
                }

                //si es la version movil hay que poner el/los menu(s) correspondiente(s)
                if ($("#logo").css("display") == "none" ){
                    createMenuAcoordingToPage();
                }

            });

            //****************el menu principal en media*************************
            $(document).click(function(e){

                //que al pinchar en cualquier lugar desaparezca si se esta mostrando
                if ($("#logo").css("display") == "none" ){
                    if($('#menu-cabecera').css('display') == 'block')
                    {
                        if(e.target.id != "menu-img-movil" && !$(e.target).closest('#menu-img-movil').length && e.target.id != "menu-cabecera" && !$(e.target).closest('#menu-cabecera').length)
                        {
                            $('#menu-cabecera').css('display', 'none');
                        }
                    }

                    if($('#second-menu-ul').css('display') == 'block')
                    {
                        if(e.target.id != "second-menu" && !$(e.target).closest('#second-menu').length)
                        {
                            $('#second-menu-ul').css('display', 'none');
                        }
                    }

                    if($('#third-menu-ul').css('display') == 'block')
                    {
                        if(e.target.id != "third-menu" && !$(e.target).closest('#third-menu').length)
                        {
                            $('#third-menu-ul').css('display', 'none');
                        }
                    }
                }
            });

            function imgMenuClicked()
            {
                //que al dar click en el icono del menu cambie de estado
                if($('#menu-cabecera').css('display') == 'none')
                    $('#menu-cabecera').css('display', 'block');
                else
                    $('#menu-cabecera').css('display', 'none');
            }

            function imgSecondMenuClicked()
            {
                //que al dar click en el icono del menu cambie de estado
                if($('#second-menu-ul').css('display') == 'none')
                    $('#second-menu-ul').css('display', 'block');
                else
                    $('#second-menu-ul').css('display', 'none');
            }

            function imgThirdMenuClicked()
            {
                //que al dar click en el icono del menu cambie de estado
                if($('#third-menu-ul').css('display') == 'none')
                    $('#third-menu-ul').css('display', 'block');
                else
                    $('#third-menu-ul').css('display', 'none');
            }

        </script>
    </head>
<body>

<?php mitema_codigo_body(); ?>
    <div id="header" class="col-xs-12" style="padding-left: 0px; padding-right: 0px; ">
        <!--<div id="offset_cabcera" class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>-->
        <div id="cabecera" class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
            <div id="menu-img-movil" class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <img style="cursor: pointer;" onclick="imgMenuClicked();" src="<?php echo get_stylesheet_directory_uri(); ?>/images/menu_img.png">
            </div>

            <div id="logo-movil" class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                <a href="<?php bloginfo('url'); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logotipo.png">
                    <?php //mitema_logo(); ?>
                </a>
            </div>

            <div id="logo" class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <a href="<?php bloginfo('url'); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logotipo.png">
                    <?php //mitema_logo(); ?>
                </a>
            </div>
            <div id="menu-cabecera" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <?php //wp_nav_menu( array( 'theme_location' => 'max_mega_menu_1' ) ); ?>
                <?php wp_nav_menu(); ?>
            </div>
<script type="text/javascript">
$(document).ready(function(){
$("#menu-menu-principal").find('li:eq(1)').find('a:eq(0)').attr('target','_blank');
$("#menu-menu-principal").find('li:eq(13)').find('a:eq(0)').attr('target','_blank');
$("#menu-menu-principal").find('li:eq(14)').find('a:eq(0)').attr('target','_blank');
});
</script>
            <!--<div style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/mail_boton_3.png');" class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mail_boton_3.png" style="width: 100%; height: auto;">
                <i class="fa fa-envelope" aria-hidden="true" style="color: #ffffff;font-size: 2em;position: absolute;
        bottom: 0;
        left: 0;margin-left: 40px;"></i>
                Correo
            </div>-->
            <div id="email-link" style="
                padding-bottom: 5px;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/mail_boton_3.png');"
                class="col-xs-1 col-sm-1 col-md-1 col-lg-1 d-sm-none" align="center">
                <a href="https://correo.icimaf.cu/mail/" target="_blank" style="text-decoration: none;">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mail_big_blanco.png" style="width: 50%;margin: 15px auto 0px;">
                    <span style="color: #ffffff; font-size: 1.1em;margin: 0px auto 10px;">Correo</span>
                </a>
            </div>
            <div id="search_rs_idioma" class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div id="search" class="col-xs-5 col-sm-5 col-md-5 col-lg-5">

                    <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">

                            <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>

                            <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />

                            <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
                    </form>


                </div>
                <div id="cabecera_enlaces_sociales" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <ul>
                        <?php echo mitema_redes_sociales(); ?>
                    </ul>
                </div>
                <div id="idioma" class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <!--
					<?php
                    if(is_single()):
                        $id_post_traduccion = $wp_query->post->ID;
                        $tiene_traduccion = get_post_meta( $id_post_traduccion, 'tf_events_meta_traduccion', true );
                        if(isset($tiene_traduccion) AND $tiene_traduccion != ''): ?>
                    <a class="flag_idioma_icimaf" title="Spanish">esp</a>
                    <font> | </font>
                        <a class="flag_idioma_icimaf" title="English">eng</a>
                            <script type="text/javascript">
                                $ = jQuery;
                                $(document).ready(function(){
                                    $('.flag_idioma_icimaf').click(function(){
                                        if($(this).attr('title') == 'English'){
                                            $('.contenido_post, .titulo_post').hide();
                                            $('.traduccion').show();
                                        }
                                        else{
                                            $('.contenido_post, .titulo_post').show();
                                            $('.traduccion').hide();
                                        }
                                    });
                                });//document
                                jQuery = $;
                            </script>
                    <?php
                        else:
                            echo do_shortcode('[glt language="Spanish" label="esp"]'); ?> | <?php echo do_shortcode('[glt language="English" label="eng"]');
                        endif;
                    else:
                        echo do_shortcode('[glt language="Spanish" label="esp"]'); ?> | <?php echo do_shortcode('[glt language="English" label="eng"]');
                    endif;
                    ?>
					-->
                </div>
            </div>
        </div>

        <!-- Aqui iria el carrusel-->
        <?php if(!is_author() AND !is_page(362) AND !is_page(356))    {        ?>
            <?php include_once('carousel.php');  ?>
        <?php    }
        ?>


    </div>

    <div class="clearfix"></div>

<div id="second-menu">
    <div class="second-menu-img">
        <img style="cursor: pointer;" onclick="imgSecondMenuClicked();" src="<?php echo get_stylesheet_directory_uri(); ?>/images/menu1_img.png">
    </div>
    <div class="second-menu-text"></div>
</div>
<div id="third-menu">
    <div class="third-menu-img">
        <img style="cursor: pointer;" onclick="imgThirdMenuClicked();" src="<?php echo get_stylesheet_directory_uri(); ?>/images/menu1_img.png">
    </div>
    <div class="third-menu-text"></div>
</div>



