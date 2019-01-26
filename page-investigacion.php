<?php /* Template Name: Investigacion */ ?>
<?php get_header(); ?>
<style>
    .table {
        margin-bottom: 0px;
    }
</style>
<script type="text/javascript">
    function mostrar_resumen(ob) {
        jQuery(ob).parent().parent().next().find('span').toggle('slow');
    }
    jQuery(document).ready(function ($) {
        var style = '';

        var sql_2 = " DISTINCT bal_reporte.id, bal_reporte.resumen, bal_reporte.anno, bal_reporte.titulo, bal_reporte.fichero_server_name, bal_reporte.vista_publica FROM bal_reporte INNER JOIN bal_reporte_autores";
        sql_2 += " ON bal_reporte.id = bal_reporte_autores.reporte_id INNER JOIN worker";
        sql_2 += " ON bal_reporte_autores.autor_id = worker.id WHERE";
        sql_2 += " bal_reporte.validado = 1 ORDER BY bal_reporte.anno DESC";

        $('#loading').show();
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_2,
            function (data) {
                if (data.consulta.length > 0) {
                    //$('#table-publicaciones').append('<thead style="display: none;"><tr><td colspan="4" class="pub_number" style="cursor: pointer;width: 100%;">Reportes de Investigaci&oacute;n del ICIMAF<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {

                        if (typeof data.consulta[j].fichero_server_name === 'undefined' || data.consulta[j].fichero_server_name == '')
                            var fichero_server_name = '#';
                        else{
                            var fichero_server_name = data.consulta[j].fichero_server_name;
                            var ext = fichero_server_name.split('.').pop();
                            if (ext == 'pdf') {
                                icono = '<i class="fa fa-file-pdf-o"></i>';
                            }
                            if (ext == 'doc' || ext == 'docx') {
                                icono = '<i class="fa fa-file-word-o"></i>';
                            }
                        }

                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;
                        if (typeof data.consulta[j].resumen === 'undefined' || data.consulta[j].resumen == '')
                            var resumen = '';
                        else
                            var resumen = data.consulta[j].resumen;

                        // if (j > 5) {
                        style = 'style="display:none"';
                        //}
                        if (vista_publica == 1) {
                            $('#table-publicaciones').show();
                            $('#table-publicaciones').append('<tr><td style="width: 80%;"><span class="t-autor"></span><span class="t-publicacion pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td class="text-center"><a href="http://intranet.icimaf.cu/ws_file.php?file=' + data.consulta[j].fichero_server_name + '" style="padding:5px;">'+icono+'</i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                        }
                        else {
                            if (resumen != '') {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr><td style="width: 80%;"><span class="t-autor"></span><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td class="text-center"><a title="Mostrar resumen" style="padding:5px;cursor:pointer;" onclick="mostrar_resumen(this);"><i class="fa fa-eye"></i></a></td><td class="text-right" style="">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr><tr><td style="border-top:0px;" colspan="4"><span style="display:none; text-align: justify;"><h5><strong>Resumen</strong></h5>' + resumen + '<br/><br/></span></td><tr/>');
                            }

                            else {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr><td style="width: 80%;"><span class="t-autor"></span><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td>&nbsp;</td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                            }

                        }

                        //$('#table-publicaciones').append('<tr><td class="pub_number">'+(j+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="reporte_'+data.consulta[j].id+'">'+data.consulta[j].titulo+'</span>, </td><td><a href="'+fichero_server_name+'" style="padding:5px;"><i class="icomoon icon-file-pdf"></i></a></td><td style="">&nbsp;&nbsp;'+data.consulta[j].anno+'</td></tr>');

                        var sql_4 = " worker.name, bal_reporte_autores.nombre FROM bal_reporte_autores LEFT JOIN worker ";
                        sql_4 += " ON worker.id = bal_reporte_autores.autor_id";
                        sql_4 += " WHERE bal_reporte_autores.reporte_id = " + data.consulta[j].id;
                        sql_4 += " ORDER BY bal_reporte_autores.id";

                        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_4,
                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_4,
                            function (data_4) {
                                $(data_4.consulta).each(function (k) {
                                    var autor = data_4.consulta[k].name;
                                    if (autor == '') {
                                        autor = data_4.consulta[k].nombre;
                                    }
                                    $('#table-publicaciones').find('#reporte_' + data.consulta[j].id).prev().append(autor + ', ');
                                });
                            });
                    });
                }
                $('#loading').hide();
            });
    //

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
                            $("#table-pub-indexadas tbody tr,#table-pub-n-indexadas tbody tr,#table-publicaciones tbody tr,#table-ponencias tbody tr,#table-premios tbody tr,#table-a-divulgacion tbody tr,#table-arbitraje tbody tr,#table-gys tbody tr,#table-tutorias tbody tr,#table-oponencias tbody tr").each(function () {
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
                            $("#table-pub-indexadas tbody tr,#table-pub-n-indexadas tbody tr,#table-publicaciones tbody tr,#table-ponencias tbody tr,#table-premios tbody tr,#table-a-divulgacion tbody tr,#table-arbitraje tbody tr,#table-gys tbody tr,#table-tutorias tbody tr,#table-oponencias tbody tr").each(function () {
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
                            $("#table-pub-indexadas tbody tr,#table-pub-n-indexadas tbody tr,#table-publicaciones tbody tr,#table-ponencias tbody tr,#table-premios tbody tr,#table-a-divulgacion tbody tr,#table-arbitraje tbody tr,#table-gys tbody tr,#table-tutorias tbody tr,#table-oponencias tbody tr").each(function () {
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

                <div id="loading" style="display: none; margin: 0 auto; width: 17px;">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/loading.gif">
                </div>

                <table class="table table-hover num-5" id="table-publicaciones" style="margin-top: 20px;">

                </table>
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
                endif; ?>

            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <?php get_footer(); ?>
    </div>
</div>
