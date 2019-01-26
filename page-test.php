<?php /* Template Name: Test */ ?>

<?php get_header(); ?>

<script type="text/javascript">
function mostrar_resumen(ob) {
    jQuery(ob).parent().parent().next().find('span').toggle('slow');
}

function updown(ob) {
    if(jQuery(ob).hasClass("fa fa-chevron-up")){
        jQuery(ob).removeClass( "fa fa-chevron-up" );
        jQuery(ob).addClass( "fa fa-chevron-down" );
    }
    else{
        jQuery(ob).removeClass( "fa fa-chevron-down" );
        jQuery(ob).addClass( "fa fa-chevron-up" );
    }
    jQuery(ob).closest('table').find('tbody>tr').toggle();

}
jQuery(document).ready(function ($) {
    var style = '';
    var indexada = 0;
    var no_indexada = 0;

    if ($('#departamento').length > 0) {
        var pdfimg = $('#pdf_imagen').attr('src');
        var depart = 'Control Automático';

        var sql_3 = " DISTINCT bal_publicacion.titulo, bal_publicacion.id, bal_publicacion.nombre_tipo_pub, bal_publicacion.anno, bal_publicacion.DOI, bal_publicacion.indexing, bal_publicacion.tipo_pub FROM bal_publicacion INNER JOIN bal_publicacion_autores";
        sql_3 += " ON bal_publicacion.id = bal_publicacion_autores.publicacion_id INNER JOIN worker";
        sql_3 += " ON bal_publicacion_autores.autor_id = worker.id INNER JOIN entity";
//            sql_3 += " ON entity.id = worker.entity_id WHERE entity.name = '"+depart+"'";
        sql_3 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_3 += " AND bal_publicacion.publicada = 1";
        sql_3 += " AND bal_publicacion.validado = 1 ORDER BY bal_publicacion.anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_3,
            function (data) {
                if (data.consulta.length > 0) {
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
//                            if (indexada > 5) {
                                //style = 'style="display:none"';
 //                           }
                            $('#table-pub-indexadas').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span>, ' + nombre_tipo_pub + '</td><td><a href="' + doi + '" style="padding:5px;"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[n].anno + '</td></tr>');
                            style = '';
                        }
                        else {
                            $('#table-pub-n-indexadas').show();
                            no_indexada++;
                          //  if (no_indexada > 5) {
                                style = 'style="display:none"';
                            //}
                            $('#table-pub-n-indexadas').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span>, ' + nombre_tipo_pub + '</td><td><a href="' + doi + '" style="padding:5px;"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[n].anno + '</td></tr>');
                            style = '';
                        }


                        var sql_6 = " worker.name, bal_publicacion_autores.nombre FROM bal_publicacion_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_publicacion_autores.autor_id";
                        sql_6 += " WHERE bal_publicacion_autores.publicacion_id = " + data.consulta[n].id;
                        sql_6 += " ORDER BY bal_publicacion_autores.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
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
                                });
                            });
                    });
                }
            });

        var sql_1 = " DISTINCT bal_libro.titulo_articulo, bal_libro.id, bal_libro.titulo_libro, bal_libro.anno, bal_libro.DOI, bal_libro.indexing, bal_libro.tipo_pub FROM bal_libro INNER JOIN bal_libro_autores";
        sql_1 += " ON bal_libro.id = bal_libro_autores.libro_id INNER JOIN worker";
        sql_1 += " ON bal_libro_autores.autor_id = worker.id INNER JOIN entity";
//            sql_1 += " ON entity.id = worker.entity_id WHERE entity.name = '"+depart+"'";
        sql_1 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_1 += " AND bal_libro.publicada = 1";
        sql_1 += " AND bal_libro.validado = 1 ORDER BY bal_libro.anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_1,
            function (data) {
                if (data.consulta.length > 0) {
                    $(data.consulta).each(function (l) {
                        if (typeof data.consulta[l].titulo_articulo === 'undefined' || data.consulta[l].titulo_articulo == '')
                            var titulo_articulo = '';
                        else
                            var titulo_articulo = data.consulta[l].titulo_articulo;
                        if (typeof data.consulta[l].titulo_libro === 'undefined' || data.consulta[l].titulo_libro == '')
                            var titulo_libro = '';
                        else
                            var titulo_libro = ', ' + data.consulta[l].titulo_libro;
                        if (typeof data.consulta[l].DOI === 'undefined' || data.consulta[l].DOI == '')
                            var doi = '#';
                        else
                            var doi = data.consulta[l].DOI;

                        if (data.consulta[l].tipo_pub == 'Indexada') {
                            $('#table-pub-indexadas').show();
                            indexada++;
                         //   if (indexada > 5) {
                                style = 'style="display:none"';
                         //   }
                            $('#table-pub-indexadas').append('<tr ' + style + '><td class="pub_number" > - </td><td style="width: 80%;"><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a href="' + doi + '" style="padding:5px;"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[l].anno + '</td></tr>');
                            style = '';
                        }
                        else {
                            $('#table-pub-n-indexadas').show();
                            no_indexada++;
                          //  if (no_indexada > 5) {
                                style = 'style="display:none"';
                           // }
                            $('#table-pub-n-indexadas').append('<tr ' + style + '><td class="pub_number" > - </td><td style="width: 80%;"><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a href="' + doi + '" style="padding:5px;"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[l].anno + '</td></tr>');
                            style = '';
                        }

                        //$('#table-publicaciones').append('<tr><td class="pub_number" >'+(l+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="libro_'+data.consulta[l].id+'">'+titulo_articulo+'</span>'+titulo_libro+'</td><td><a href="'+doi+'" style="padding:5px;"><img src="'+pdfimg+'" /></a></td><td style="width: 20%;">&nbsp;&nbsp;'+data.consulta[l].anno+'</td></tr>');

                        var sql_5 = " worker.name, bal_libro_autores.nombre FROM bal_libro_autores LEFT JOIN worker ";
                        sql_5 += " ON worker.id = bal_libro_autores.autor_id";
                        sql_5 += " WHERE bal_libro_autores.libro_id = " + data.consulta[l].id;
                        sql_5 += " ORDER BY bal_libro_autores.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_5,
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
                                    //$('#table-publicaciones').find('#libro_'+data.consulta[l].id).before(data_5.consulta[m].name+', ');
                                });
                            });
                    });
                }
            });

        var sql_2 = " DISTINCT bal_reporte.id, bal_reporte.resumen, bal_reporte.anno, bal_reporte.titulo, bal_reporte.fichero_server_name, bal_reporte.vista_publica FROM bal_reporte INNER JOIN bal_reporte_autores";
        sql_2 += " ON bal_reporte.id = bal_reporte_autores.reporte_id INNER JOIN worker";
        sql_2 += " ON bal_reporte_autores.autor_id = worker.id INNER JOIN entity";
//            sql_2 += " ON entity.id = worker.entity_id WHERE entity.name = '"+depart+"'";
        sql_2 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_2 += " AND bal_reporte.validado = 1";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_2,
            function (data) {
                if (data.consulta.length > 0) {
                    $('#table-publicaciones').append('<thead style="display: none;"><tr><td colspan="4" class="pub_number" style="cursor: pointer;width: 100%;">Reportes de Investigaci&oacute;n del ICIMAF<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {

                        if (typeof data.consulta[j].fichero_server_name === 'undefined' || data.consulta[j].fichero_server_name == '')
                            var fichero_server_name = '#';
                        else
                            var fichero_server_name = data.consulta[j].fichero_server_name;
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
                            $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td><a href="http://ws.icimaf.cu/ws_file.php?file=' + data.consulta[j].fichero_server_name + '" style="padding:5px;"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr>');
                        }
                        else {
                            if (resumen != '')
                            {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td><a style="padding:5px;" onclick="mostrar_resumen(this);"><img src="' + pdfimg + '" /></a></td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr><tr><td></td><td><span style="display:none;"><h5>Resumen</h5>' + resumen + '<br/><br/></span></td><td></td><tr/>');
                            }

                            else
                            {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, </td><td>&nbsp;</td><td style="width: 20%;">&nbsp;&nbsp;' + data.consulta[j].anno + '</td></tr>');
                            }

                        }

                        //$('#table-publicaciones').append('<tr><td class="pub_number">'+(j+1)+'.</td><td style="width: 80%;"><span class="pub_titulo" id="reporte_'+data.consulta[j].id+'">'+data.consulta[j].titulo+'</span>, </td><td><a href="'+fichero_server_name+'" style="padding:5px;"><img src="'+pdfimg+'" /></a></td><td style="width: 20%;">&nbsp;&nbsp;'+data.consulta[j].anno+'</td></tr>');

                        var sql_4 = " worker.name, bal_reporte_autores.nombre FROM bal_reporte_autores LEFT JOIN worker ";
                        sql_4 += " ON worker.id = bal_reporte_autores.autor_id";
                        sql_4 += " WHERE bal_reporte_autores.reporte_id = " + data.consulta[j].id;
                        sql_4 += " ORDER BY bal_reporte_autores.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_4,
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
//Aqui va lo nuevo de produccion cientifica

        var sql_7 = " DISTINCT bal_ponencia.id, bal_ponencia.titulo,bal_evento.nombre, bal_ponencia.vista_publica, tipo_ponencia, YEAR(fecha_creacion) AS fecha FROM";
        sql_7 += " bal_ponencia INNER JOIN bal_ponencia_autores ON bal_ponencia.id = bal_ponencia_autores.ponencia_id";
        sql_7 += " INNER JOIN worker ON bal_ponencia_autores.autor_id = worker.id INNER JOIN entity";
        sql_7 += " ON entity.id = worker.entity2 INNER JOIN bal_evento ON bal_ponencia.evento_id = bal_evento.id WHERE entity.name = '" + depart + "' AND bal_ponencia.validado = 1";
        sql_7 += " ORDER BY fecha_creacion";

        $.getJSON("http:/ws.icimaf.cu/ws_custom.php?sql=" + sql_7,
            function (data) {
                if (data.consulta.length > 0) {
                    $('#table-ponencias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Ponencias<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {

                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                        //if (j > 5) {
                            style = 'style="display:none"';
                        //}
                        if (vista_publica == 1) {
                            $('#table-ponencias thead').show()
                            $('#table-ponencias').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="ponencia_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, <span>' + data.consulta[j].nombre + ', Tipo de Ponencia: '+ data.consulta[j].tipo_ponencia +  '</span></td><td></td><td style="width: 20%;">'+data.consulta[j].fecha+'</td></tr>');
                        }

                        var sql_6 = " worker.name, bal_ponencia_autores.nombre FROM bal_ponencia_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_ponencia_autores.autor_id";
                        sql_6 += " WHERE bal_ponencia_autores.ponencia_id = " + data.consulta[j].id;
                        sql_6 += " ORDER BY bal_ponencia_autores.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-ponencias').find('#ponencia_' + data.consulta[j].id).before(autor + ', ');
                                });
                            });
                    });
                }
            });

        //
        var sql_7 = " DISTINCT bal_premio.id, bal_premio.titulo_premio, bal_premio.vista_publica, bal_premio.trabajo_premio, anno FROM";
        sql_7 += " bal_premio INNER JOIN bal_premio_autores ON bal_premio.id = bal_premio_autores.premio_id";
        sql_7 += " INNER JOIN worker ON bal_premio_autores.autor_id = worker.id INNER JOIN entity";
        //sql_7 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_premio.validado = 1";
        sql_7 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_premio.validado = 1";
        sql_7 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_7,
            function (data) {

                if (data.consulta.length > 0) {
                    $('#table-premios').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Premios<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {

                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                       // if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-premios').show();
                            $('#table-premios').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="premios_' + data.consulta[j].id + '">' + data.consulta[j].titulo_premio + '</span>, <span class="pub_titulo"> ' + data.consulta[j].trabajo_premio + '</span></td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                        }

                        var sql_6 = " worker.name, bal_premio_autores.nombre FROM bal_premio_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_premio_autores.autor_id";
                        sql_6 += " WHERE bal_premio_autores.premio_id = " + data.consulta[j].id;
                        sql_6 += " ORDER BY bal_premio_autores.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-premios').find('#premios_' + data.consulta[j].id).before(autor + ', ');
                                });
                            });
                    });
                }
            });

        //

        var sql_8 = " DISTINCT worker.name, bal_acc_divulgacion.id, bal_acc_divulgacion.accion,";
        sql_8 += " bal_acc_divulgacion.vista_publica, bal_acc_divulgacion.otros_datos, fecha, YEAR(fecha) AS anno FROM";
        sql_8 += " bal_acc_divulgacion INNER JOIN worker ON bal_acc_divulgacion.worker_id = worker.id INNER JOIN entity";
        sql_8 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_acc_divulgacion.validado = 1";
        sql_8 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_8,
            function (data) {

                if (data.consulta.length > 0) {
                    $('#table-a-divulgacion').append('<thead style="display: none"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Acciones de Divulgaci&oacute;n<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                       // if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-a-divulgacion').show();
                            $('#table-a-divulgacion').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="accion_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>, <span class="pub_titulo"> <b>Acci&oacute;n: </b> ' + data.consulta[j].accion + ', '+ data.consulta[j].otros_datos +'</span></td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                        }

                    });
                }
            });
        //
        var sql_9 = " DISTINCT worker.name, bal_arbitraje.id, bal_arbitraje.nombre_trabajo,";
        sql_9 += " bal_arbitraje.vista_publica, bal_arbitraje.otros_datos, tipo_trabajo, anno FROM";
        sql_9 += " bal_arbitraje INNER JOIN worker ON bal_arbitraje.arbitro_id = worker.id INNER JOIN entity";
        sql_9 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_arbitraje.validado = 1";
        sql_9 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_9,
            function (data) {
                if (data.consulta.length > 0) {
                    $('#table-arbitraje').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Arbitrajes<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                       // if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-arbitraje').show();
                            $('#table-arbitraje').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="arbitraje_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>. <span class="pub_titulo"> ' + data.consulta[j].nombre_trabajo + '</span> , '+ data.consulta[j].otros_datos + '</td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                        }

                    });
                }
            });
        //
        var sql_10 = " DISTINCT bal_part_grupos_exp_soc_cient.id, bal_part_grupos_exp_soc_cient.nombre,";
        sql_10 += " bal_part_grupos_exp_soc_cient.vista_publica, bal_part_grupos_exp_soc_cient.otros_datos, tipo, anno FROM";
        sql_10 += " bal_part_grupos_exp_soc_cient INNER JOIN bal_part_grupos_exp_soc_cient_miembros";
        sql_10 += " ON bal_part_grupos_exp_soc_cient.id = bal_part_grupos_exp_soc_cient_miembros.grupo_soc_id";
        sql_10 += " INNER JOIN worker ON bal_part_grupos_exp_soc_cient_miembros.miembro_id = worker.id INNER JOIN entity";
        sql_10 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_part_grupos_exp_soc_cient.validado = 1";
        sql_10 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_10,
            function (data) {
                if (data.consulta.length > 0) {
                    $('#table-gys').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Grupos de Expertos y Sociedades Científicas<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                       // if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-gys thead').show();
                            $('#table-gys').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span class="pub_titulo" id="gys_' + data.consulta[j].id + '">' + data.consulta[j].nombre + '</span>. <span> Tipo: ' + data.consulta[j].tipo + '</span> , '+ data.consulta[j].otros_datos + '</td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                        }

                        var sql = " worker.name FROM bal_part_grupos_exp_soc_cient_miembros LEFT JOIN worker ";
                        sql += " ON worker.id = bal_part_grupos_exp_soc_cient_miembros.miembro_id";
                        sql += " WHERE bal_part_grupos_exp_soc_cient_miembros.grupo_soc_id = " + data.consulta[j].id;
                        sql += " ORDER BY bal_part_grupos_exp_soc_cient_miembros.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-gys').find('#gys_' + data.consulta[j].id).before(autor + ', ');
                                });
                            });

                    });
                }
            });
        //
        var sql_11 = " DISTINCT worker.name, bal_tutoria.id, bal_tutoria.estudiante,";
        sql_11 += " bal_tutoria.vista_publica, bal_tutoria.otros_datos, titulo, bal_tutoria.tipo, anno FROM";
        sql_11 += " bal_tutoria";
        sql_11 += " INNER JOIN worker ON bal_tutoria.worker_id = worker.id INNER JOIN entity";
        sql_11 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_tutoria.validado = 1";
        sql_11 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_11,
            function (data) {

                if (data.consulta.length > 0) {
                    $('#table-tutorias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Tutor&iacute;as<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                        //if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-tutorias thead').show();
                            cadena = '<tr ' + style + '><td class="pub_number"> - ' +
                                '</td><td style="width: 80%;"><span id="tutoria_' +
                                data.consulta[j].id + '">' +
                                data.consulta[j].name + '</span>. ';

                            if(data.consulta[j].tipo != 'undefined' || data.consulta[j].tipo != '' )
                                cadena += '<span> Tipo de Tesis: ' + data.consulta[j].tipo + '</span>';

                            if(data.consulta[j].otros_datos != "")
                                cadena += ', '+ data.consulta[j].otros_datos;

                            if(data.consulta[j].titulo != 'undefined' || data.consulta[j].titulo != '' )
                                cadena += '. <span class="pub_titulo"> ' +data.consulta[j].titulo +'</span> </td>';
                                cadena += '<td style="width: 20%;">' +data.consulta[j].anno+'</td></tr>';
                            //$('#table-tutorias').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="tutoria_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo + '</span> , '+ data.consulta[j].otros_datos + ', <span class="pub_titulo"> ' + data.consulta[j].titulo +'</span> </td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                            $('#table-tutorias').append(cadena);
                        }
                    });
                }
            });
        //
        var sql_12 = " DISTINCT worker.name, bal_oponencia_tribunal.id, bal_oponencia_tribunal.estudiante,";
        sql_12 += " bal_oponencia_tribunal.vista_publica, bal_oponencia_tribunal.otros_datos, titulo, tipo_tesis, anno FROM";
        sql_12 += " bal_oponencia_tribunal";
        sql_12 += " INNER JOIN worker ON bal_oponencia_tribunal.worker_id = worker.id INNER JOIN entity";
        sql_12 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_oponencia_tribunal.validado = 1";
        sql_12 += " ORDER BY anno";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_12,
            function (data) {
                if (data.consulta.length > 0) {
                    $('#table-oponencias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Oponencias en Tribunales<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (typeof data.consulta[j].vista_publica === 'undefined' || data.consulta[j].vista_publica == '')
                            var vista_publica = '';
                        else
                            var vista_publica = data.consulta[j].vista_publica;

                      //  if (j > 5) {
                            style = 'style="display:none"';
                       // }
                        if (vista_publica == 1) {
                            $('#table-oponencias thead').show();
                            $('#table-oponencias').append('<tr '+ style +'><td class="pub_number"> - </td><td style="width: 80%;"><span id="oponencias_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo_tesis + '</span> , '+ data.consulta[j].otros_datos + ', <span class="pub_titulo"> ' + data.consulta[j].titulo +'</span> </td><td style="width: 20%;">'+data.consulta[j].anno+'</td></tr>');
                        }
                    });
                }
            });
        //

    }

});
</script>
<div class="clearfix"></div>
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <img style="display:none;" id="pdf_imagen"
                 src="<?php echo get_stylesheet_directory_uri(); ?>/images/pdf_img.png" style="margin-left:3px;"/>

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php

                    /////Mostrando los Departamentos
                    $dep = get_post_meta(get_the_ID(), 'Departamento', true);
                    $departamentos = array('', 'Control Automático', 'Física Aplicada', 'Física Teórica', 'Matemática', 'Matemática Interdisciplinaria', 'Redes');

                    echo '<input id="departamento" type="hidden" value="' . $departamentos[$dep] . '"/>';


                    //si no es un articulo normal Ej: Noticia
                    if (1):

                        /* global $wpdb;
                         //echo var_dump($wpdb);
                         $data = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->users"));
                         foreach ( $data as $usuario ) {
                             echo '<p>' .$usuario->user_email. '</p>';
                         }
                         $usuarios = $wpdb->get_results( $wpdb->prepare( "SELECT user_pub FROM $wpdb->wp_usermeta WHERE user_departamento=$dep" ) );
                         foreach ( $usuarios as $usuario ) {
                             echo '<p>' .$usuario->user_pub. '</p>';
                         }*/
                        $user_query = new WP_User_Query(array('meta_key' => 'user_departamento', 'meta_value' => $dep));
                        ?>
                        <h1 class="dep_titulo_principal"><?php echo $departamentos[$dep]; ?></h1>
                        <div class="depart_content"> <?php the_content(); ?> </div>
                        <h3 class="titulo_general text-center">PUBLICACIONES</h3>
                        <table id="table-pub-indexadas">
                            <thead>
                            <tr id="articulos_indexados">
                                <td colspan="4" class="pub_number" style="cursor: pointer;width: 100%;">Art&iacute;culos indexados <i class="fa fa-chevron-up" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td>
                            </tr>
                            </thead>
                        </table>
                        <table id="table-pub-n-indexadas" style="display:none;">
                            <thead>
                            <tr id="articulos_n_indexados">
                                <td colspan="4" class="pub_number" style="cursor: pointer;width: 100%;">Art&iacute;culos no indexados<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td>
                            </tr>
                            </thead>
                        </table>
                        <table id="table-publicaciones">

                        </table>
                        <table id="table-ponencias">

                        </table>
                        <table id="table-premios">

                        </table>
                        <table id="table-a-divulgacion">

                        </table>
                        <table id="table-arbitraje">

                        </table>
                        <table id="table-gys">

                        </table>
                        <table id="table-tutorias">

                        </table>
                        <table id="table-oponencias">

                        </table>
                        <?php
                        //echo '<div class="mas_pub" style="cursor:pointer; display: none">Ver m&aacute;s<img src="' . get_stylesheet_directory_uri() . '/images/flecha_2.png" style="margin-left:3px;" /></div>';
//                    echo '<div class="mas_pub" style="cursor:pointer; ">Ver m&aacute;s<img src="'.get_stylesheet_directory_uri().'/images/flecha_2.png" style="margin-left:3px;" /></div>';
                        ?>
                        <script type="text/javascript">
                            $ = jQuery;
                            $(document).ready(function () {
                                $('.mas_pub').click(function () {
                                    var cont = 0;
                                    /*var cantidad = $('#table-publicaciones').find('tr').length;
                                     var cantidad_i = $('#table-pub-indexadas').find('tr').length;
                                     var cantidad_n_i = $('#table-pub-n-indexadas').find('tr').length;*/

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
                        <hr/>

                        <h3 class="titulo_general text-center">MIEMBROS</h3>
                        <div class="miembros_single">

                        <ul>
                        <?php
                        foreach ($user_query->results as $usuario):
                            ?>
                            <li>
                                <div><img class="img-circle"
                                          src="<?php echo get_wp_user_avatar_src($usuario->ID, 'thumbnail'); ?>"/></div>
                                <div>
                                    <a href="<?php echo get_author_posts_url($usuario->ID); ?>"><?php echo $usuario->first_name . ' ' . $usuario->last_name; ?></a>
                                </div>
                            </li>
                        <?php endforeach;
                    else:
                        ?>
                        <div class="my_post col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <h2 class="titulo_post"><?php the_title(); ?></h2>

                            <h2 class="traduccion"><?php echo get_post_meta($post->ID, 'tf_events_trad_ti', true); ?></h2>

                            <div class="img_post"><?php the_post_thumbnail('thumbnail'); ?></div>
                            <div class="contenido_post"><?php the_content(); ?></div>
                            <div
                                class="contenido_post traduccion"><?php echo get_post_meta($post->ID, 'tf_events_meta_traduccion', true); ?></div>
                            <?php
                            //update_post_meta(get_the_ID(), 'Allow Comments', true);
                            /*if(!comments_open()){
                                $post_id=  get_the_ID();
                                $_post = get_post($post_id);

                                $open = $_post->comment_status;
                                update_post_meta($post_id, 'comment_status', 'open', 'closed');
                                echo $open;
                                echo $_post->comment_status;
                                $comments_args = array(
                                    // change the title of send button
                                    'label_submit'=>'Send',
                                    // change the title of the reply section
                                    'title_reply'=>'Write a Reply or Comment',
                                    // remove "Text or HTML to be displayed after the set of comment fields"
                                    'comment_notes_after' => '',
                                    // redefine your own textarea (the comment body)
                                    'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
                                );

                                comment_form($comments_args, get_the_ID());
                            }*/
                            comments_template(); ?>
                        </div>
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <?php
                            get_sidebar('rigth');
                            ?>
                        </div>
                    <?php
                    endif;
                    ?>
                    </ul>
                    </div>

                <?php

                endwhile;
                ?>

            <?php else : ?>

                <h3 class="center"><?php _e('No se encuentra la informacion.', 'icimaf'); ?></h3>
                <p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'icimaf'); ?></p>
                <?php get_search_form(); ?>

            <?php endif; ?>

        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>
<?php get_footer(); ?>
