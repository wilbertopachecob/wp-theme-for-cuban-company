<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 16/12/15
 * Time: 13:42
 */

get_header();?>

<script type="text/javascript">
function mostrar_resumen(ob) {
    jQuery(ob).parent().parent().next().find('span').toggle('slow');
}
jQuery(document).ready(function ($) {

    var correo = $('#mail_usuario').text();
    var indexada = 0;
    var no_indexada = 0;

    var sql_3 = " bal_publicacion.id, bal_publicacion.titulo, bal_publicacion.DOI, bal_publicacion.indexing, nombre_tipo_pub, bal_publicacion.anno, bal_publicacion.tipo_pub FROM bal_publicacion INNER JOIN bal_publicacion_autores";
    sql_3 += " ON bal_publicacion.id = bal_publicacion_autores.publicacion_id";
    sql_3 += " INNER JOIN worker ON worker.id = bal_publicacion_autores.autor_id";
    sql_3 += " WHERE email='" + correo + "' AND bal_publicacion.validado = 1 AND bal_publicacion.publicada = 1 ";
    sql_3 += " ORDER BY bal_publicacion.anno";

    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_3,
        function (data) {
            if (data.consulta.length > 0) {
                $('.mas_pub').css("display", "inline");

                //$('.publicaciones').append('<tr><td colspan="3" class="pub_number">Publicaciones</td></tr>');
                $(data.consulta).each(function (n) {

                    if (typeof data.consulta[n].DOI === 'undefined' || data.consulta[n].DOI == '')
                        var doi = '#';
                    else
                        var doi = data.consulta[n].DOI;
                    if (typeof data.consulta[n].nombre_tipo_pub === 'undefined' || data.consulta[n].nombre_tipo_pub == '')
                        var nombre_tipo_pub = '';
                    else
                        var nombre_tipo_pub = ' ' + data.consulta[n].nombre_tipo_pub;

                    if (data.consulta[n].tipo_pub == 'Indexada') {
                        $('#table-pub-indexadas').show();
                        indexada++;
                        if (indexada > 5) {
                            style = 'style="display:none"';
                        }
                        $('#table-pub-indexadas').append('<tr><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span> ' + nombre_tipo_pub + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[n].anno + '</td></tr>');
                        style = '';
                    }
                    else {
                        $('#table-pub-n-indexadas').show();
                        no_indexada++;
                        if (no_indexada > 5) {
                            style = 'style="display:none"';
                        }
                        $('#table-pub-n-indexadas').append('<tr><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span> ' + nombre_tipo_pub + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[n].anno + '</td></tr>');
                        style = '';
                    }

                    //$('.publicaciones').append('<tr><td class="pub_number">'+(n+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="publicacion_'+data.consulta[n].id+'">'+data.consulta[n].titulo+'</span>, '+nombre_tipo_pub+'</td><td><a href="'+doi+'" style="padding:5px;"><i class="fa fa-link"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;'+data.consulta[n].anno+'</td></tr>');

                    var sql_6 = " worker.name, nombre FROM bal_publicacion_autores LEFT JOIN worker ";
                    sql_6 += " ON worker.id = bal_publicacion_autores.autor_id";
                    sql_6 += " WHERE bal_publicacion_autores.publicacion_id = " + data.consulta[n].id;
                    sql_6 += " ORDER BY bal_publicacion_autores.id";

                    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_6,
                        function (data_6) {
                            $(data_6.consulta).each(function (o) {
                                var autor = data_6.consulta[o].name;
                                if (autor == '') {
                                    autor = data_6.consulta[o].nombre;
                                }
                                if (data.consulta[n].tipo_pub == 'Indexada') {
                                    $('#table-pub-indexadas').find('#publicacion_' + data.consulta[n].id).before(autor + ', ');
                                }
                                else {
                                    $('#table-pub-n-indexadas').find('#publicacion_' + data.consulta[n].id).before(autor + ', ');
                                }
                                //$('.publicaciones').find('#publicacion_'+data.consulta[n].id).before(data_6.consulta[o].name+', ');
                            });
                        });
                });
                //Aqui iria el ordenamiento por anno
            }
        });

    var sql_1 = " bal_reporte.id, bal_reporte.resumen, bal_reporte.titulo, bal_reporte.fichero_server_name, anno, vista_publica FROM bal_reporte INNER JOIN bal_reporte_autores";
    sql_1 += " ON bal_reporte.id = bal_reporte_autores.reporte_id";
    sql_1 += " INNER JOIN worker ON worker.id = bal_reporte_autores.autor_id";
    sql_1 += " WHERE email='" + correo + "' AND bal_reporte.validado = 1 ";
    sql_1 += " ORDER BY bal_reporte.anno";

    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_1,
        function (data) {
            if (data.consulta.length > 0) {
                $('.mas_pub').css("display", "inline");

                $('#table-publicaciones').append('<tr><td colspan="3" class="pub_number">Reportes de Investigaci&oacute;n del ICIMAF</td></tr>');
                $(data.consulta).each(function (j) {
					var icono = '';
                    if (typeof data.consulta[j].fichero_server_name === 'undefined' || data.consulta[j].fichero_server_name == '')
                        var fichero_server_name = '#';
                    else{
						var fichero_server_name = data.consulta[j].fichero_server_name;
						var ext = fichero_server_name.split('.').pop();
						if(ext == 'pdf')
							{icono = '<i class="fa fa-file-pdf-o"></i>';}
						if(ext == 'doc' || ext == 'docx')
							{icono = '<i class="fa fa-file-word-o"></i>';}
					}
                        
                    if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                        var vista_publica = '';
                    else
                        var vista_publica = data.consulta[j].vista_publica;
                    if (typeof data.consulta[j].resumen === 'undefined' || data.consulta[j].resumen == '')
                        var resumen = '';
                    else
                        var resumen = data.consulta[j].resumen;
                    if (j > 5) {
                        style = 'style="display:none"';
                    }
                    if (vista_publica == 1) {
                        $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span> </td><td><a href="http://intranet.icimaf.cu/ws_file.php?file=' + data.consulta[j].fichero_server_name + '" style="padding:5px;">' + icono + '</a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr>');
                    }
                    else {
                        if (resumen != '')
                            $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span> </td><td><a title="Mostrar resumen" style="padding:5px;cursor:pointer;" onclick="mostrar_resumen(this);"><i class="fa fa-eye"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr><tr><td colspan="4" style="border-top:0px;"><span style="display:none;"><h5><strong>Resumen</strong></h5>' + resumen + '<br/><br/></span></td><tr/>');
                        else
                            $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span> </td><td>&nbsp;</td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr>');
                    }

                    //$('.publicaciones').append('<tr><td class="pub_number">'+(j+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="reporte_'+data.consulta[j].id+'">'+data.consulta[j].titulo+'</span>, </td><td><a href="http://intranet.icimaf.cu/ws_file.php?file='+data.consulta[j].fichero_server_name+'" style="padding:5px;"><img src="'+pdfimg+'" /></a></td><td style="width: 20%;">&nbsp;&nbsp;'+data.consulta[j].anno+'</td></tr>');

                    var sql_4 = " worker.name, nombre FROM bal_reporte_autores LEFT JOIN worker ";
                    sql_4 += " ON worker.id = bal_reporte_autores.autor_id";
                    sql_4 += " WHERE bal_reporte_autores.reporte_id = " + data.consulta[j].id;
                    sql_4 += " ORDER BY bal_reporte_autores.id";

                    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_4,
                        function (data_4) {
                            $(data_4.consulta).each(function (k) {
                                var autor = data_4.consulta[k].name;
                                if (autor == '') {
                                    autor = data_4.consulta[k].nombre;
                                }
                                $('#table-publicaciones').find('#reporte_' + data.consulta[j].id).before(autor + ', ');
                            });
                        });
                });
            }
        });

    var sql_2 = " bal_libro.id, titulo_articulo, titulo_libro, DOI, indexing, anno, bal_libro.tipo_pub FROM bal_libro INNER JOIN bal_libro_autores";
    sql_2 += " ON bal_libro.id = bal_libro_autores.libro_id";
    sql_2 += " INNER JOIN worker ON worker.id = bal_libro_autores.autor_id";
    sql_2 += " WHERE email='" + correo + "' AND bal_libro.validado = 1 AND bal_libro.publicada = 1 ";
    sql_2 += " ORDER BY bal_libro.anno";

    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_2,
        function (data) {
            if (data.consulta.length > 0) {
                $('.mas_pub').css("display", "inline");

                //$('.publicaciones').append('<tr><td colspan="3" class="pub_number">Libros</td></tr>');
                $(data.consulta).each(function (l) {

                    if (typeof data.consulta[l].titulo_articulo === 'undefined' || data.consulta[l].titulo_articulo == '')
                        var titulo_articulo = '';
                    else
                        var titulo_articulo = data.consulta[l].titulo_articulo;
                    if (typeof data.consulta[l].titulo_libro === 'undefined' || data.consulta[l].titulo_libro == '')
                        var titulo_libro = '';
                    else
                        var titulo_libro = ' ' + data.consulta[l].titulo_libro;
                    if (typeof data.consulta[l].DOI === 'undefined' || data.consulta[l].DOI == '')
                        var doi = '#';
                    else
                        var doi = data.consulta[l].DOI;

                    if (data.consulta[l].tipo_pub == 'Indexada') {
                        $('#table-pub-indexadas').show();
                        indexada++;
                        if (indexada > 5) {
                            style = 'style="display:none"';
                        }
                        $('#table-pub-indexadas').append('<tr><td class="pub_number" > - </td><td style="width: 80%;"><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[l].anno + '</td></tr>');
                        style = '';
                    }
                    else {
                        $('#table-pub-n-indexadas').show();
                        no_indexada++;
                        if (no_indexada > 5) {
                            style = 'style="display:none"';
                        }
                        $('#table-pub-n-indexadas').append('<tr><td class="pub_number" > - </td><td style="width: 80%;"><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[l].anno + '</td></tr>');
                        style = '';
                    }

                    //$('.publicaciones').append('<tr><td class="pub_number" >'+(l+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="libro_'+data.consulta[l].id+'">'+titulo_articulo+'</span>'+titulo_libro+'</td><td><a href="'+doi+'" style="padding:5px;"><img src="'+pdfimg+'" /></a></td><td style="width: 20%;">&nbsp;&nbsp;'+data.consulta[l].anno+'</td></tr>');

                    var sql_5 = " worker.name, nombre FROM bal_libro_autores LEFT JOIN  worker";
                    sql_5 += " ON worker.id = bal_libro_autores.autor_id";
                    sql_5 += " WHERE bal_libro_autores.libro_id = " + data.consulta[l].id;
                    sql_5 += " ORDER BY bal_libro_autores.id";

                    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_5,
                        function (data_5) {
                            $(data_5.consulta).each(function (m) {
                                var autor = data_5.consulta[m].name;
                                if (autor == '') {
                                    autor = data_5.consulta[m].nombre;
                                }
                                if (data.consulta[l].tipo_pub == 'Indexada') {
                                    $('#table-pub-indexadas').find('#libro_' + data.consulta[l].id).before(autor + ', ');
                                }
                                else {
                                    $('#table-pub-n-indexadas').find('#libro_' + data.consulta[l].id).before(autor + ', ');
                                }
                                //$('.publicaciones').find('#libro_'+data.consulta[l].id).before(data_5.consulta[m].name+', ');
                            });
                        });
                });
            }
        });

});
</script>
<div class="clearfix"></div>
<?php
if (isset($_GET['author_name'])) :
    $currentAuthor = get_userdatabylogin($author_name);
else :
    $currentAuthor = get_userdata(intval($author));
endif;
?>

<div class="author" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/autor_fondo.jpg'); height: 200px;">
    <br/>
    <br/>
    <br/>
    <div>
        <img id="author-img" style="margin-top: 0px; margin-bottom: 0px;" class="img-circle"
             src="<?php echo get_wp_user_avatar_src($currentAuthor->ID, 'thumbnail'); //get_the_author_meta( "wp_user_avatar",$currentAuthor->ID ); ?>"/>
    </div>
</div>
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div id="autores_libros">

            </div>
            <div style="margin-top: 20px;">
                <?php if (isset($currentAuthor->first_name) AND $currentAuthor->first_name != ''): ?>
                    <div id="author-name" style="font-size: 20px;">
                        <?php echo $currentAuthor->first_name . ' ' . $currentAuthor->last_name; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($currentAuthor->user_grado_cient) AND $currentAuthor->user_grado_cient != ''): ?>
                    <div id="grado-cientifico">
                        <?php
                        $grados = array('', 'Doctor en Ciencias', 'Doctor', 'Master', 'Ingeniero', 'Licenciado');
                        echo $grados[$currentAuthor->user_grado_cient]; ?>
                    </div>
                <?php endif; ?>
                <hr/>
            </div>
            <div class="author-description">
                <?php
                $id_d = get_the_author_meta("user_departamento", $currentAuthor->ID);
                if (isset($id_d) AND $id_d != ''):
                    ?>
                    <div class="name">Departamento:</div>
                    <div class="description">
                        <?php
                        $departamentos = array('', 'Control Automático', 'Física Aplicada', 'Física Teórica', 'Matemática', 'Matemática Interdisciplinaria', 'Redes');
                        echo $departamentos[$id_d];
                        ?>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php if (isset($currentAuthor->user_url) AND $currentAuthor->user_url = ''): ?>
                    <div class="name">Web Personal:</div>
                    <div class="description"><a
                            href="<?php echo $currentAuthor->user_url; ?>"><?php echo $currentAuthor->user_url; ?></a>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php if (isset($currentAuthor->user_description) AND $currentAuthor->user_description != ''): ?>
                    <div class="name">Descripci&oacute;n personal:</div>
                    <div class="description"><?php echo $currentAuthor->user_description; ?></div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php if (isset($currentAuthor->user_email) AND $currentAuthor->user_email != ''): ?>
                    <div class="name">Email:</div>
                    <div class="description"><a id="mail_usuario"
                                                href="mailto:<?php echo $currentAuthor->user_email; ?>"><?php echo $currentAuthor->user_email; ?></a>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php
                $fc = get_the_author_meta("user_fc", $currentAuthor->ID);
                $tw = get_the_author_meta("user_tw", $currentAuthor->ID);
                $g = get_the_author_meta("user_g", $currentAuthor->ID);
                $link = get_the_author_meta("user_link", $currentAuthor->ID);
                $re = get_the_author_meta("user_re", $currentAuthor->ID);
                if ((isset($fc) AND $fc != '') OR (isset($link) AND $link != '') OR (isset($g) AND $g != '') OR (isset($re) AND $re != '') OR (isset($tw) AND $tw != '')):
                    ?>
                    <div class="name">Redes sociales:</div>
                    <div class="description">
                        <?php
                        if (isset($fc) AND $fc != '') {
                            echo '<a style="margin-right: 10px;" href="' . get_the_author_meta("user_fc", $currentAuthor->ID) . '"><i class="fa fa-facebook" style="margin-right: 3px;"></i>Facebook</a>';
                        }
                        if (isset($tw) AND $tw != '') {
                            echo '<a style="margin-right: 10px;" href="' . get_the_author_meta("user_tw", $currentAuthor->ID) . '"><i class="fa fa-twitter" style="margin-right: 3px;"></i>Twitter</a>';
                        }
                        if (isset($g) AND $g != '') {
                            echo '<a style="margin-right: 10px;" href="' . get_the_author_meta("user_g", $currentAuthor->ID) . '"><i class="fa fa-google" style="margin-right: 3px;"></i>Google+</a>';
                        }
                        if (isset($link) AND $link != '') {
                            echo '<a style="margin-right: 10px;" href="' . get_the_author_meta("user_link", $currentAuthor->ID) . '"><i class="fa fa-linkedin" style="margin-right: 3px;"></i>LinkedIn</a>';
                        }
                        if (isset($re) AND $re != '') {
                            echo '<a style="margin-right: 10px;" href="' . get_the_author_meta("user_re", $currentAuthor->ID) . '"><i class="fa fa-researchgate" style="margin-right: 3px;"></i>Research Gate</a>';
                        }
                        ?>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php if (isset($currentAuthor->user_curriculo) AND $currentAuthor->user_curriculo != ''): ?>
                    <div class="name">Curr&iacute;culo:</div>
                    <div class="description">
                        <?php echo get_the_author_meta("user_curriculo", $currentAuthor->ID); ?>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php
                $col_string = get_the_author_meta("user_colaboraciones", $currentAuthor->ID);
                if (isset($col_string) AND $col_string != ''): ?>
                    <div class="name">Colaboraciones:</div>
                    <div class="description">
                        <?php
                        $arr_col = explode(';', $col_string);
                        for ($i = 0; $i < count($arr_col); $i++) {
                            echo $arr_col[$i] . '<br/>';
                        }
                        ?>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <?php
                $col_correos = get_the_author_meta("user_correos", $currentAuthor->ID);
                if (isset($col_correos) AND $col_correos != ''):
                    ?>
                    <div class="name">Otros emails:</div>
                    <div class="description">
                        <?php
                        for ($i = 0; $i < count($col_correos); $i++) {
                            echo '<a href="mailto:' . $col_correos[$i] . '">' . $col_correos[$i] . '</a><br/>';
                        }
                        ?>
                    </div>
                    <div style="clear: both"></div>
                <?php endif; ?>
                <div class="name">Publicaciones:</div>
                <div class="description">
                    <table class="table table-hover" id="table-pub-indexadas" style="display:none;">
                        <thead>
                        <tr id="articulos_indexados">
                            <td
                            <td colspan="3" class="pub_number">Art&iacute;culos indexados</td>
                        </tr>
                        </thead>
                    </table>
                    <table class="table table-hover" id="table-pub-n-indexadas" style="display:none;">
                        <thead>
                        <tr id="articulos_n_indexados">
                            <td colspan="3" class="pub_number">Art&iacute;culos no indexados</td>
                        </tr>
                        </thead>
                    </table>
                    <table class="table table-hover" style="width: 100%" id="table-publicaciones">

                    </table>
                    <div class="mas_pub" style="cursor:pointer; display: none; ">
                        Ver m&aacute;s
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/flecha_2.png"
                             style="margin-left:3px;"/>
                    </div>

                    <script type="text/javascript">
                        $ = jQuery;
                        $(document).ready(function () {
                            $('.mas_pub').click(function () {
                                var cont = 0;

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
                        jQuery = $;
                    </script>
                </div>

            </div>
            <!--
        <h2>Posted by <?php echo $currentAuthor->nickname; ?>:</h2>
        <ul>
            <!– The Loop –>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <li>
                    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
                        <?php the_title(); ?></a>,
                    <?php the_time('d M Y'); ?> in <?php the_category(', '); ?>
                </li>
            <?php endwhile;
            else: ?>
                <p><?php _e('No post written by this author'); ?></p>
            <?php endif; ?>
            <!– End Loop –>
        </ul>
-->
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>
<?php get_footer(); ?>
