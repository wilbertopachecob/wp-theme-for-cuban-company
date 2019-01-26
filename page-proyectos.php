<?php /* Template Name: Proyectos */ ?>
<?php get_header(); ?>
<style>
    .table {
        margin-bottom: 0px;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        var style = '';

        var sql_11 = " worker.email, worker.name, bal_proyecto.id, bal_proyecto.nombre";
        sql_11 += " FROM bal_proyecto";
        sql_11 += " INNER JOIN worker ON bal_proyecto.jefe_id = worker.id WHERE bal_proyecto.validado = 1";

        $('#loading').show();
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_11,
            function (data) {

                if (data.consulta.length > 0) {
                    //$('#table-tutorias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Tutor&iacute;as<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        var imagen_clonada = '';
                        $("#contenedor_img>img").each(function(k)
                        {
                           if($(this).attr("data-email") == data.consulta[j].email)
                           {
                               imagen_clonada = $(this).prop('outerHTML');
                               return false;
                           }
                           else{
                               imagen_clonada = '<img class="img-circle" src="http://www.icimaf.cu/wp-content/uploads/2016/09/grey_man.jpg">';
                           }

                        });
                        cadena = '<div class="row" style="margin-top: 10px; border-bottom: 1px solid #ddd;padding-bottom: 5px;">' +
                            '<div class="col-xs-4" align="center">' +
                            imagen_clonada +
                            '<br><br>'+data.consulta[j].name+
                            '<br>'+data.consulta[j].email+
                            '</div>' +
                            '<div class="col-xs-8">' +
                            data.consulta[j].nombre +
                            '</div>' +
                            '</div>';
                        $('#contenedor_proy').append(cadena);
                    });
                }
                $('#loading').hide();
            });
    });
</script>
<div class="clearfix"></div>
<div id="super_contenedor" style="width:100%;">
    <div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <?php if (have_posts()) : ?>

                <?php while (have_posts()) :
                the_post(); ?>

                <h1 class="dep_titulo_principal"><?php the_title(); ?></h1>

                <div class="depart_content"> <?php the_content(); ?> </div>


            </div>
        </div>
        <?php
        endwhile;
        ?>

        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="margin-top: 30px;">


                <?php
                $user_query_e = new WP_User_Query(array ( 'order' => 'ASC' ));
                if (count($user_query_e->results) > 0):
                    ?>
                    <div id="contenedor_img" style="display: none;">
                    <?php

                    foreach ($user_query_e->results as $usuario):
                        ?>
                        <img class="img-circle" data-email="<?php echo $usuario->user_email; ?>"
                                     src="<?php echo get_wp_user_avatar_src($usuario->ID, 96); ?>"/>
                <?php
                endforeach;
                    ?>
                        </div>
                        <?php
                    endif;
                ?>


                <div id="loading" style="display: none; margin: 0 auto; width: 17px;">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.gif">
                </div>

                <div id="contenedor_proy">
<div class="row">
    <div class="col-xs-4" align="center">
       <h3 style="color: #1F414F;"><strong> L&iacute;der</strong></h3>
    </div>
    <div class="col-xs-8">
        <h3 style="color: #1F414F;"><strong>Nombre del proyecto</strong></h3>
    </div>
    </div>
                </div>

                <?php
                // echo '<div class="mas_pub" style="cursor:pointer; display: none">Ver m&aacute;s<img src="' . get_stylesheet_directory_uri() . '/images/flecha_2.png" style="margin-left:3px;" /></div>';
                //                    echo '<div class="mas_pub" style="cursor:pointer; ">Ver m&aacute;s<img src="'.get_stylesheet_directory_uri().'/images/flecha_2.png" style="margin-left:3px;" /></div>';
                ?>
                <script type="text/javascript">
                    /*$ = jQuery;
                     $(document).ready(function () {
                     $('.mas_pub').click(function () {
                     var cont = 0;
                     //var cantidad = $('#table-publicaciones').find('tr').length;
                     //var cantidad_i = $('#table-pub-indexadas').find('tr').length;
                     //var cantidad_n_i = $('#table-pub-n-indexadas').find('tr').length;

                     $('#table-publicaciones, #table-pub-indexadas, #table-pub-n-indexadas').find('tr').each(function () {
                     if ($(this).css('display') == 'none') {
                     $(this).show();
                     cont++;
                     }
                     if (cont == 5) {
                     cont = 0;
                     return false;
                     }
                     })
                     });

                     });//document
                     jQuery = $;*/
                </script>
                <hr style="color: #2A6D80; border: 1px solid #2A6D80;"/>
                <?php else : ?>

                    <h3 class="center"><?php _e('No se encuentra la informacion.', 'icimaf'); ?></h3>
                    <p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'icimaf'); ?></p>
                    <?php get_search_form(); ?>

                <?php
                endif;
                ?>

            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <?php get_footer(); ?>
    </div>
</div>
