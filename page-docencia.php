<?php /* Template Name: Docencia */ ?>
<?php get_header(); ?>
<style>
    .table {
        margin-bottom: 0px;
    }

    .nav-tabs.nav-justified > li.activado > a {
        background-color: #296D80;
        color: white;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        //Funcion para las pestanas de navegacion
        $(".nav-tabla>li").click(function () {
            if (!$(this).hasClass("activado")) {
                $(".nav-tabla>li").removeClass("activado");
                $(this).addClass("activado")
                var num = $(this).attr("num-show");
                $("div.navegacion").hide('slow');
                $("div.navegacion.num-" + num).show('slow');
            }
        });

        var style = '';

        var sql_11 = " DISTINCT worker.name, bal_tutoria.id, bal_tutoria.estudiante,";
        sql_11 += " bal_tutoria.vista_publica, bal_tutoria.otros_datos, titulo, bal_tutoria.tipo, anno FROM";
        sql_11 += " bal_tutoria";
        sql_11 += " INNER JOIN worker ON bal_tutoria.worker_id = worker.id WHERE bal_tutoria.validado = 1 AND bal_tutoria.vista_publica = 1";
        sql_11 += " ORDER BY anno DESC";

        $('#loading').show();
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_11,
            function (data) {

                if (data.consulta.length > 0) {
                    //$('#table-tutorias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Tutor&iacute;as<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                            cadena = '<tr><td style="width: 80%;"><span class="t-autor">' + data.consulta[j].name + '</span><span id="tutoria_' +
                                data.consulta[j].id + '"></span>. ';

                            if (data.consulta[j].tipo != 'undefined' || data.consulta[j].tipo != '')
                                cadena += '<span> Tipo de Tesis: ' + data.consulta[j].tipo + '</span>';

                            if (data.consulta[j].otros_datos != "")
                                cadena += ', ' + data.consulta[j].otros_datos;

                            if (data.consulta[j].titulo != 'undefined' || data.consulta[j].titulo != '')
                                cadena += '. <span class="pub_titulo"> ' + data.consulta[j].titulo + '</span> </td>';
                            cadena += '<td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>';
                            //$('#table-tutorias').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="tutoria_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo + '</span> , '+ data.consulta[j].otros_datos + ', <span class="pub_titulo"> ' + data.consulta[j].titulo +'</span> </td><td style="">'+data.consulta[j].anno+'</td></tr>');
                            if (data.consulta[j].tipo == "Pregrado")
                                $('#table-tutorias-pre').append(cadena);
                            if (data.consulta[j].tipo == "Doctorado")
                                $('#table-tutorias-doc').append(cadena);
                            if (data.consulta[j].tipo == "Maestría")
                                $('#table-tutorias-maes').append(cadena);
                    });
                }
                $('#loading').hide();
            });
        //
        var sql_12 = " DISTINCT worker.name, bal_oponencia_tribunal.id, bal_oponencia_tribunal.estudiante,";
        sql_12 += " bal_oponencia_tribunal.vista_publica, bal_oponencia_tribunal.otros_datos, titulo, tipo_tesis, anno FROM";
        sql_12 += " bal_oponencia_tribunal";
        sql_12 += " INNER JOIN worker ON bal_oponencia_tribunal.worker_id = worker.id WHERE bal_oponencia_tribunal.validado = 1 AND bal_oponencia_tribunal.vista_publica = 1";
        sql_12 += " ORDER BY anno DESC";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_12,
            function (data) {
                if (data.consulta.length > 0) {
                    //$('#table-oponencias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Oponencias en Tribunales<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                            console.log(data.consulta[j].tipo_tesis);
                            if (data.consulta[j].tipo_tesis == "Pregrado")
                                $('#table-tutorias-pre').append('<tr><td style="width: 80%;"><span class="t-autor">' + data.consulta[j].name + '</span><span id="oponencias_' + data.consulta[j].id + '"></span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo_tesis + '</span> , ' + data.consulta[j].otros_datos + ', <span class="t-publicacion pub_titulo"> ' + data.consulta[j].titulo + '</span> </td><td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                            if (data.consulta[j].tipo_tesis == "Doctorado")
                                $('#table-tutorias-doc').append('<tr><td style="width: 80%;"><span class="t-autor">' + data.consulta[j].name + '</span><span id="oponencias_' + data.consulta[j].id + '"></span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo_tesis + '</span> , ' + data.consulta[j].otros_datos + ', <span class="t-publicacion pub_titulo"> ' + data.consulta[j].titulo + '</span> </td><td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                            if (data.consulta[j].tipo_tesis == "Maestría")
                                $('#table-tutorias-maes').append('<tr><td style="width: 80%;"><span class="t-autor">' + data.consulta[j].name + '</span><span id="oponencias_' + data.consulta[j].id + '"></span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo_tesis + '</span> , ' + data.consulta[j].otros_datos + ', <span class="t-publicacion pub_titulo"> ' + data.consulta[j].titulo + '</span> </td><td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                    });
                }
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
                //if(is_super_admin()):
                ?>
                <div class="container" align="center">
                    <form class="form-inline">
                        <div class="form-group">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="publicacion"
                                   placeholder="Publicaci&oacute;n">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" id="anno" placeholder="Año">
                        </div>
                    </form>
                </div>
                <script>
                    $(function () {
//Buscar por nombre de persona
                        $('#nombre').on('change', function () {
                            $(".table.table-hover tbody tr").each(function () {
//console.log($(this).text());
                                var filter = $('#nombre').val().toUpperCase();
//console.log(filter);
                                var span_autor = $(this).find("td:eq(0)").find('span.t-autor');
//console.log(td.text().toUpperCase());
                                if (span_autor.text().toUpperCase().indexOf(filter) > -1) {
                                    $(this).show();
                                    console.log(span_autor.text());
                                }
                                else {
                                    $(this).hide();
                                }
                            });
                        });

//Buscar por nombre de publicacion
                        $('#publicacion').on('change', function () {
                            $(".table.table-hover tbody tr").each(function () {
//console.log($(this).text());
                                var filter = $('#publicacion').val().toUpperCase();
//console.log(filter);
                                var span_publicacion = $(this).find("td:eq(0)").find('span.t-publicacion');
//console.log(td.text().toUpperCase());
                                if (span_publicacion.text().toUpperCase().indexOf(filter) > -1) {
                                    $(this).show();
                                    console.log(span_publicacion.text());
                                }
                                else {
                                    $(this).hide();
                                }
                            });
                        });

//Buscar por anno de publicacion
                        $('#anno').on('change', function () {
                            $(".table.table-hover tbody tr").each(function () {
//console.log($(this).text());
                                var filter = $('#anno').val().toUpperCase();
//console.log(filter);
                                var span_anno = $(this).find("td:eq(2)").find('span.t-anno');
//console.log(td.text().toUpperCase());
                                if (span_anno.text().toUpperCase().indexOf(filter) > -1) {
                                    $(this).show();
                                    console.log(span_anno.text());
                                }
                                else {
                                    $(this).hide();
                                }
                            });
                        });
                    });
                </script>
                <?php //endif; ?>

                <ul class="nav nav-tabs nav-justified nav-tabla" style="margin-top: 30px;">
                    <li num-show="1" role="presentation" class="activado"><a>PREGRADO</a></li>
                    <li num-show="2" role="presentation"><a>DOCTORADO</a></li>
                    <li num-show="3" role="presentation"><a>MAESTRIA</a></li>

                </ul>

                <div id="loading" style="display: none; margin: 0 auto; width: 17px;">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.gif">
                </div>
                <div class="navegacion num-1">
                    <table class="table table-hover num-1" id="table-tutorias-pre">

                    </table>
                </div>
                <div class="navegacion num-2" style="display: none;">
                    <table class="table table-hover num-2" id="table-tutorias-doc">

                    </table>
                </div>
                <div class="navegacion num-3" style="display: none;">
                    <table class="table table-hover num-3" id="table-tutorias-maes">

                    </table>
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
