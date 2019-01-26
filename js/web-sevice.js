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
//Funcion para el ver mas
    $(".ver_mas").click(function () {
        if ($(this).hasClass('n_expand')) {
            $(this).prev().find("tbody tr").each(function () {
                if ($(this).css("display") == "none") {
                    $(this).show('slow');
                }
            });
            $(this).removeClass('n_expand');
            $(this).html('Ocultar <i class="fa fa-caret-up"></i>').addClass('expand');
        }
        else {
            $(this).prev().find("tbody tr").each(function (n) {
                if (n > 2) {
                    $(this).hide('slow');
                }
            });
            $(this).removeClass('expand');
            $(this).html('Ver m&aacute;s <i class="fa fa-caret-down"></i>').addClass('n_expand');
        }
    });

    var style = '';

    if ($('#departamento').length > 0) {
        var depart = $('#departamento').val();

        var sql_3 = " DISTINCT bal_publicacion.titulo, bal_publicacion.id, bal_publicacion.nombre_tipo_pub, bal_publicacion.anno, bal_publicacion.DOI, bal_publicacion.indexing, bal_publicacion.tipo_pub FROM bal_publicacion INNER JOIN bal_publicacion_autores";
        sql_3 += " ON bal_publicacion.id = bal_publicacion_autores.publicacion_id INNER JOIN worker";
        sql_3 += " ON bal_publicacion_autores.autor_id = worker.id INNER JOIN entity";
        sql_3 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_3 += " AND bal_publicacion.publicada = 1";
        sql_3 += " AND bal_publicacion.validado = 1 ORDER BY bal_publicacion.anno DESC";

        $('#loading').show();
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_3,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='1']").show();
                    cant_index = 0;
                    cant_no_index = 0;
                    i = 0;
                    $(data.consulta).each(function (n) {

                        if (typeof data.consulta[n].DOI === 'undefined' || data.consulta[n].DOI == '')
                            var doi = '#';
                        else
                            var doi = data.consulta[n].DOI;
                        if (typeof data.consulta[n].nombre_tipo_pub === 'undefined')
                            var nombre_tipo_pub = '';
                        else
                            var nombre_tipo_pub = ' ' + data.consulta[n].nombre_tipo_pub;

                        //si hay mas de 3 publicaciones Indexadas escondo el resto
                        if (cant_index > 2) {
                            var style_index = 'style="display:none"';
                        }
                        else {
                            var style_index = '';
                        }

                        if (cant_no_index > 2) {
                            var style_no_index = 'style="display:none"';
                        }
                        else {
                            var style_no_index = '';
                        }

                        if (data.consulta[n].tipo_pub == 'Indexada') {
                            cant_index++;
                            $('#table-pub-indexadas thead').show();
                            if($("#carousel-example-generic .item.hasContent").length > 0){
                                //$("#carousel-example-generic .item.hasContent a:eq("+i+")").text(data.consulta[n].titulo).parent().parent().removeClass("hasContent");
                                $("#carousel-example-generic .item.hasContent a:first")
                                    .text(data.consulta[n].titulo)
                                    .attr("href",doi)
                                    .parent().parent().removeClass("hasContent");
                            }
                            $('#table-pub-indexadas').append('<tr ' + style_index + ' ><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span><span class="pub_datos"> ' + nombre_tipo_pub + '</span><br/><span class="t-autor pub_titulo"></span></td><td class="text-center"><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[n].anno + '</span></td></tr>');
                        }
                        else {
                            cant_no_index++;
                            $('#table-pub-n-indexadas thead').show();
                            /*if(i < 3){
                                $("#carousel-example-generic .item a:eq("+i+")").text(data.consulta[n].titulo).parent().parent().removeClass("hasContent");;
                                i++;
                            }*/
							if($("#carousel-example-generic .item.hasContent").length > 0){
                                //$("#carousel-example-generic .item.hasContent a:eq("+i+")").text(data.consulta[n].titulo).parent().parent().removeClass("hasContent");
                                $("#carousel-example-generic .item.hasContent a:first")
                                    .text(data.consulta[n].titulo)
                                    .attr("href",doi)
                                    .parent().parent().removeClass("hasContent");
                            }
                            $('#table-pub-n-indexadas').append('<tr ' + style_no_index + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="publicacion_' + data.consulta[n].id + '">' + data.consulta[n].titulo + '</span>, ' + nombre_tipo_pub + '<br/><span class="t-autor pub_titulo"></span></td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[n].anno + '</span></td></tr>');
                        }


                        var sql_6 = " worker.name, bal_publicacion_autores.nombre FROM bal_publicacion_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_publicacion_autores.autor_id";
                        sql_6 += " WHERE bal_publicacion_autores.publicacion_id = " + data.consulta[n].id;
                        sql_6 += " ORDER BY bal_publicacion_autores.id";

                        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_6,
                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
                            function (data_6) {
                                $(data_6.consulta).each(function (o) {
                                    var autor = data_6.consulta[o].name;
                                    if (autor == '') {
                                        autor = data_6.consulta[o].nombre;
                                    }
                                    if (data.consulta[n].tipo_pub == 'Indexada') {
                                        //$('#table-pub-indexadas').find('#publicacion_' + data.consulta[n].id).before(autor + '</span>, ');
                                        $('#table-pub-indexadas').find('#publicacion_' + data.consulta[n].id).parent().find(".t-autor").append(autor + ', ');
                                    }
                                    else {
                                        $('#table-pub-n-indexadas').find('#publicacion_' + data.consulta[n].id).parent().find(".t-autor").append(autor + ', ');
                                    }
                                });
                            });
                    });
                    if (cant_index == 0) {
                        $('#table-pub-indexadas').next().hide();
                    }
                    if (cant_no_index == 0) {
                        $('#table-pub-n-indexadas').next().hide();
                    }
                    //console.log(cant_index);
                }
                $('#loading').hide();
                console.log(cant_index);
               /* $("#carousel-example-generic .item a").each(function(){
                    .text();
                })*/
            });

        //Libros

        var sql_1 = " DISTINCT bal_libro.titulo_articulo, bal_libro.id, bal_libro.titulo_libro, bal_libro.anno, bal_libro.DOI, bal_libro.indexing, bal_libro.tipo_pub FROM bal_libro INNER JOIN bal_libro_autores";
        sql_1 += " ON bal_libro.id = bal_libro_autores.libro_id INNER JOIN worker";
        sql_1 += " ON bal_libro_autores.autor_id = worker.id INNER JOIN entity";
        sql_1 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_1 += " AND bal_libro.publicada = 1 AND art_o_libro = 'Libro'";
        sql_1 += " AND bal_libro.validado = 1 ORDER BY bal_libro.anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_1,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_1,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='1']").show();
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

                        /*if (data.consulta[l].tipo_pub == 'Indexada') {
                         $('#table-pub-indexadas').append('<tr ><td style="width: 80%;"><span class="t-autor"></span><span class="t-publicacion pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');
                         }
                         else {
                         $('#table-pub-n-indexadas').show();
                         $('#table-pub-n-indexadas').append('<tr><td style="width: 80%;"><span class="t-autor"></span><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><tdclass="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');
                         }*/
                        if (l > 2) {
                            style = 'style="display:none"';
                        }
                        else {
                            style = '';
                        }
                        $('#table-libros thead').show();
						if($("#carousel-example-generic .item.hasContent").length > 0){
                             $("#carousel-example-generic .item.hasContent a:first")
                                 .text(data.consulta[n].titulo)
                                 .attr("href",doi)
                                 .parent().parent().removeClass("hasContent");
                            }
                        $('#table-libros').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '<br/><span class="t-autor pub_titulo"></span></td><td class="text-center"><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');

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
                                    /*if (data.consulta[l].tipo_pub == 'Indexada') {
                                     $('#table-pub-indexadas').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                     }
                                     else {
                                     $('#table-pub-n-indexadas').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                     }*/
                                    $('#table-libros').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-libros').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-libros').next().hide();
                }
            });

        //Articulos
        var sql_20 = " DISTINCT bal_libro.titulo_articulo, bal_libro.id, bal_libro.titulo_libro, bal_libro.anno, bal_libro.DOI, bal_libro.indexing, bal_libro.tipo_pub FROM bal_libro INNER JOIN bal_libro_autores";
        sql_20 += " ON bal_libro.id = bal_libro_autores.libro_id INNER JOIN worker";
        sql_20 += " ON bal_libro_autores.autor_id = worker.id INNER JOIN entity";
        sql_20 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_20 += " AND bal_libro.publicada = 1 AND art_o_libro = 'Artículo'";
        sql_20 += " AND bal_libro.validado = 1 ORDER BY bal_libro.anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_1,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_20,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='1']").show();
                    $(data.consulta).each(function (l) {
                        style = '';
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

                        /*if (data.consulta[l].tipo_pub == 'Indexada') {
                         $('#table-pub-indexadas').append('<tr ><td style="width: 80%;"><span class="t-autor"></span><span class="t-publicacion pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');
                         }
                         else {
                         $('#table-pub-n-indexadas').show();
                         $('#table-pub-n-indexadas').append('<tr><td style="width: 80%;"><span class="t-autor"></span><span class="pub_titulo" id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span>' + titulo_libro + '</td><td><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><tdclass="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');
                         }*/
                        if (l > 2) {
                            style = 'style="display:none"';
                        }
                        else {
                            style = '';
                        }
                        $('#table-libros-art thead').show();
                        if($("#carousel-example-generic .item.hasContent").length > 0){
                            $("#carousel-example-generic .item.hasContent a:first")
                                .text(data.consulta[n].titulo)
                                .attr("href",doi)
                                .parent().parent().removeClass("hasContent");
                        }
                        $('#table-libros-art').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="libro_' + data.consulta[l].id + '">' + titulo_articulo + '</span><span class="pub_datos">' + titulo_libro + '</span><br/><span class="t-autor pub_titulo"></span></td><td class="text-center"><a title="Enlace a la publicaci&oacute;n" href="' + doi + '" style="padding:5px;"><i class="fa fa-link"></i></a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[l].anno + '</span></td></tr>');

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
                                    /*if (data.consulta[l].tipo_pub == 'Indexada') {
                                     $('#table-pub-indexadas').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                     }
                                     else {
                                     $('#table-pub-n-indexadas').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                     }*/
                                    $('#table-libros-art').find('#libro_' + data.consulta[l].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-libros-art').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-libros-art').next().hide();
                }
            });

        var sql_2 = " DISTINCT bal_reporte.id, bal_reporte.resumen, bal_reporte.anno, bal_reporte.titulo, bal_reporte.fichero_server_name, bal_reporte.vista_publica FROM bal_reporte INNER JOIN bal_reporte_autores";
        sql_2 += " ON bal_reporte.id = bal_reporte_autores.reporte_id INNER JOIN worker";
        sql_2 += " ON bal_reporte_autores.autor_id = worker.id INNER JOIN entity";
//            sql_2 += " ON entity.id = worker.entity_id WHERE entity.name = '"+depart+"'";
        sql_2 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "'";
        sql_2 += " AND bal_reporte.validado = 1 ORDER BY bal_reporte.anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_2,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_2,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='1']").show();
                    //$('#table-publicaciones').append('<thead style="display: none;"><tr><td colspan="4" class="pub_number" style="cursor: pointer;width: 100%;">Reportes de Investigaci&oacute;n del ICIMAF<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {


                        if (typeof data.consulta[j].fichero_server_name === 'undefined' || data.consulta[j].fichero_server_name == '')
                            var fichero_server_name = '#';
                        else {
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

                        if (j > 2) {
                            style = 'style="display:none"';
                        }
                        else {
                            style = '';
                        }

                        if($("#carousel-example-generic .item.hasContent").length > 0){
                            $("#carousel-example-generic .item.hasContent a:first")
                                .text(data.consulta[n].titulo)
                                .attr("href","http://intranet.icimaf.cu/ws_file.php?file=" + data.consulta[j].fichero_server_name)
                                .parent().parent().removeClass("hasContent");
                        }

                        if (vista_publica == 1) {
                            $('#table-publicaciones thead').show();
                            $('#table-publicaciones').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span><br/> <span class="t-autor pub_titulo"></span></td><td class="text-center"><a href="http://intranet.icimaf.cu/ws_file.php?file=' + data.consulta[j].fichero_server_name + '" style="padding:5px;">' + icono + '</a></td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                        }
                        else {
                            if (resumen != '') {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span><br/> <span class="t-autor pub_titulo"></span></td><td class="text-center"><a title="Mostrar resumen" style="padding:5px;cursor:pointer;" onclick="mostrar_resumen(this);"><i class="fa fa-eye"></i></a></td><td class="text-right" style="">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[j].anno + '</span></td></tr><tr><td style="border-top:0px; text-align: justify;" colspan="4"><span style="display:none;"><h5><strong>Resumen</strong></h5>' + resumen + '<br/><br/></span></td><tr/>');
                            }

                            else {
                                $('#table-publicaciones thead').show();
                                $('#table-publicaciones').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="reporte_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span><br/> <span class="t-autor pub_titulo"></span></td><td>&nbsp;</td><td class="text-right">&nbsp;&nbsp;<span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
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
                                    $('#table-publicaciones').find('#reporte_' + data.consulta[j].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-publicaciones').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-publicaciones').next().hide();
                }
            });
//SEMINARIOS
        var sql_13 = " DISTINCT bal_curso_impartido.id, bal_curso_impartido.titulo,";
        sql_13 += " bal_curso_impartido.vista_publica, bal_curso_impartido.lugar, otros_datos, nivel, anno, worker.name FROM";
        sql_13 += " bal_curso_impartido";
        sql_13 += " INNER JOIN worker ON bal_curso_impartido.worker_id = worker.id INNER JOIN entity";
        sql_13 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_curso_impartido.validado = 1";
        sql_13 += " AND bal_curso_impartido.vista_publica = 1 AND bal_curso_impartido.tipo = 'Seminario' ORDER BY anno DESC";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_13,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='2']").show();
                    $(data.consulta).each(function (j) {
                        if (j > 2)
                            var style = 'style="display:none"';
                        else
                            var style = '';
                        $('#table-seminario-imp thead').show();
                        $('#table-seminario-imp').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="seminario_' + data.consulta[j].id + '"> ' + data.consulta[j].titulo + '</span>. <span> <strong>Lugar: </strong>' + data.consulta[j].lugar + '</span><span class="pub_datos"> ' + data.consulta[j].otros_datos + ' </span><br/><strong>Impartido por</strong> <span class="t-autor pub_titulo">' + data.consulta[j].name + ' </span></td><td></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');

                    });
                }
                else {
                    $('#table-seminario-imp').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-seminario-imp').next().hide();
                }
            });
        //
        var sql_14 = " DISTINCT bal_curso_recibido.id, bal_curso_recibido.titulo,";
        sql_14 += " bal_curso_recibido.lugar, otros_datos, nivel, anno FROM";
        sql_14 += " bal_curso_recibido INNER JOIN bal_curso_recibido_participantes ON bal_curso_recibido.id = bal_curso_recibido_participantes.curso_recibido_id";
        sql_14 += " INNER JOIN worker ON bal_curso_recibido_participantes.participante_id = worker.id INNER JOIN entity";
        sql_14 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_curso_recibido.validado = 1";
        sql_14 += " AND bal_curso_recibido.vista_publica = 1 AND bal_curso_recibido.tipo = 'Seminario' ORDER BY anno DESC";

        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_14,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='2']").show();
                    $(data.consulta).each(function (j) {
                        if (j > 2)
                            var style = 'style="display:none"';
                        else
                            var style = '';
                        $('#table-seminario-rec thead').show();
                        $('#table-seminario-rec').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="seminario_recibido_' + data.consulta[j].id + '"> ' + data.consulta[j].titulo + '</span>. <span> <strong>Lugar: </strong>' + data.consulta[j].lugar + '</span> , ' + data.consulta[j].otros_datos + '<br/> <strong>Recibido por</strong> <span class="t-autor pub_titulo"></span></td><td></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');

                        var sql_4 = " worker.name FROM bal_curso_recibido_participantes LEFT JOIN worker ";
                        sql_4 += " ON worker.id = bal_curso_recibido_participantes.participante_id";
                        sql_4 += " WHERE bal_curso_recibido_participantes.curso_recibido_id = " + data.consulta[j].id;
                        sql_4 += " ORDER BY bal_curso_recibido_participantes.id";

                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_4,
                            function (data_4) {
                                $(data_4.consulta).each(function (k) {
                                    var autor = data_4.consulta[k].name;
                                    $('#table-seminario-rec').find('#seminario_recibido_' + data.consulta[j].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-seminario-rec').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-seminario-rec').next().hide();
                }
            });

//Aqui va lo nuevo de produccion cientifica

        var sql_7 = " DISTINCT bal_ponencia.id, bal_ponencia.titulo,bal_evento.nombre, bal_ponencia.vista_publica, tipo_ponencia, YEAR(fecha_creacion) AS fecha FROM";
        sql_7 += " bal_ponencia INNER JOIN bal_ponencia_autores ON bal_ponencia.id = bal_ponencia_autores.ponencia_id";
        sql_7 += " INNER JOIN worker ON bal_ponencia_autores.autor_id = worker.id INNER JOIN entity";
        sql_7 += " ON entity.id = worker.entity2 INNER JOIN bal_evento ON bal_ponencia.evento_id = bal_evento.id WHERE entity.name = '" + depart + "' AND bal_ponencia.validado = 1";
        sql_7 += " AND bal_ponencia.vista_publica = 1 ORDER BY fecha_creacion DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_7,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_7,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='3']").show();
                    //$('#table-ponencias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Ponencias<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2)
                            var style = 'style="display:none"';
                        else
                            var style = '';

                        $('#table-ponencias thead').show();
                        $('#table-ponencias').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="ponencia_' + data.consulta[j].id + '">' + data.consulta[j].titulo + '</span>, <span>' + data.consulta[j].nombre + ', Tipo de Ponencia: ' + data.consulta[j].tipo_ponencia + '</span><br/><span class="t-autor pub_titulo"></span></td><td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].fecha + '</span></td></tr>');

                        var sql_6 = " worker.name, bal_ponencia_autores.nombre FROM bal_ponencia_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_ponencia_autores.autor_id";
                        sql_6 += " WHERE bal_ponencia_autores.ponencia_id = " + data.consulta[j].id;
                        sql_6 += " ORDER BY bal_ponencia_autores.id";

                        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_6,
                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-ponencias').find('#ponencia_' + data.consulta[j].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-ponencias').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-ponencias').next().hide();
                }
            });

        //
        var sql_7 = " DISTINCT bal_premio.id, bal_premio.titulo_premio, bal_premio.vista_publica, bal_premio.trabajo_premio, anno FROM";
        sql_7 += " bal_premio INNER JOIN bal_premio_autores ON bal_premio.id = bal_premio_autores.premio_id";
        sql_7 += " INNER JOIN worker ON bal_premio_autores.autor_id = worker.id INNER JOIN entity";
        //sql_7 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_premio.validado = 1";
        sql_7 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_premio.validado = 1 AND bal_premio.vista_publica = 1";
        sql_7 += " ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_7,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_7,
            function (data) {

                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='4']").show();
                    //$('#table-premios').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Premios<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2)
                            var style = 'style="display:none"';
                        else
                            var style = '';
                        $('#table-premios thead').show();
                        $('#table-premios').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion pub_datos"> ' + data.consulta[j].trabajo_premio + '</span><br/><span id="premios_' + data.consulta[j].id + '">' + data.consulta[j].titulo_premio + '</span> <br/><span class="t-autor pub_titulo"></span></td><td class="text-center"></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');

                        var sql_6 = " worker.name, bal_premio_autores.nombre FROM bal_premio_autores LEFT JOIN worker ";
                        sql_6 += " ON worker.id = bal_premio_autores.autor_id";
                        sql_6 += " WHERE bal_premio_autores.premio_id = " + data.consulta[j].id;
                        sql_6 += " ORDER BY bal_premio_autores.id";

                        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_6,
                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_6,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-premios').find('#premios_' + data.consulta[j].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });
                    });
                }
                else {
                    $('#table-premios').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-premios').next().hide();
                }
            });

        //

        var sql_8 = " DISTINCT worker.name, bal_acc_divulgacion.id, bal_acc_divulgacion.accion,";
        sql_8 += " bal_acc_divulgacion.vista_publica, bal_acc_divulgacion.otros_datos, fecha, YEAR(fecha) AS anno FROM";
        sql_8 += " bal_acc_divulgacion INNER JOIN worker ON bal_acc_divulgacion.worker_id = worker.id INNER JOIN entity";
        sql_8 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_acc_divulgacion.validado = 1 AND bal_acc_divulgacion.vista_publica = 1";
        sql_8 += " ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_8,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_8,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='4']").show();
                    //$('#table-a-divulgacion').append('<thead style="display: none"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Acciones de Divulgaci&oacute;n<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2) {
                            var style = 'style="display:none"';
                        }
                        else {
                            var style = '';
                        }
                        $('#table-a-divulgacion thead').show();
                        $('#table-a-divulgacion').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="accion_' + data.consulta[j].id + '"> <b>Acci&oacute;n: </b> ' + data.consulta[j].accion + ', ' + data.consulta[j].otros_datos + '</span><br/><span class="t-autor pub_titulo">' + data.consulta[j].name + '</span></td><td class="text-center"></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                    });
                }
                else {
                    $('#table-a-divulgacion').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-a-divulgacion').next().hide();
                }

            });
        //
        var sql_9 = " DISTINCT worker.name, bal_arbitraje.id, bal_arbitraje.nombre_trabajo,";
        sql_9 += " bal_arbitraje.vista_publica, bal_arbitraje.otros_datos, tipo_trabajo, anno FROM";
        sql_9 += " bal_arbitraje INNER JOIN worker ON bal_arbitraje.arbitro_id = worker.id INNER JOIN entity";
        sql_9 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_arbitraje.validado = 1 AND bal_arbitraje.vista_publica = 1";
        sql_9 += " ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_9,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_9,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='4']").show();
                    //$('#table-arbitraje').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Arbitrajes<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2) {
                            var style = 'style="display:none"';
                        }
                        else {
                            var style = '';
                        }
                        $('#table-arbitraje thead').show();
                        $('#table-arbitraje').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="arbitraje_' + data.consulta[j].id + '"></span> <span class="t-publicacion"> ' + data.consulta[j].nombre_trabajo + '</span> , ' + data.consulta[j].otros_datos + '<br/><span class="t-autor pub_titulo">' + data.consulta[j].name + '</span></td><td class="text-center"></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                    });
                }
                else {
                    $('#table-arbitraje').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-arbitraje').next().hide();
                }

            });
        //
        var sql_10 = " DISTINCT bal_part_grupos_exp_soc_cient.id, bal_part_grupos_exp_soc_cient.nombre,";
        sql_10 += " bal_part_grupos_exp_soc_cient.vista_publica, bal_part_grupos_exp_soc_cient.otros_datos, tipo, anno FROM";
        sql_10 += " bal_part_grupos_exp_soc_cient INNER JOIN bal_part_grupos_exp_soc_cient_miembros";
        sql_10 += " ON bal_part_grupos_exp_soc_cient.id = bal_part_grupos_exp_soc_cient_miembros.grupo_soc_id";
        sql_10 += " INNER JOIN worker ON bal_part_grupos_exp_soc_cient_miembros.miembro_id = worker.id INNER JOIN entity";
        sql_10 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_part_grupos_exp_soc_cient.validado = 1 AND bal_part_grupos_exp_soc_cient.vista_publica = 1";
        sql_10 += " ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_10,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_10,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='4']").show();
                    //$('#table-gys').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Grupos de Expertos y Sociedades Científicas<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2) {
                            var style = 'style="display:none"';
                        }
                        else {
                            var style = '';
                        }
                        $('#table-gys thead').show();
                        $('#table-gys').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span class="t-publicacion" id="gys_' + data.consulta[j].id + '">' + data.consulta[j].nombre + '</span>. <span> Tipo: ' + data.consulta[j].tipo + '</span> , ' + data.consulta[j].otros_datos + '<br/><span class="t-autor pub_titulo"></span></td><td class="text-center"></td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');

                        var sql = " worker.name FROM bal_part_grupos_exp_soc_cient_miembros LEFT JOIN worker ";
                        sql += " ON worker.id = bal_part_grupos_exp_soc_cient_miembros.miembro_id";
                        sql += " WHERE bal_part_grupos_exp_soc_cient_miembros.grupo_soc_id = " + data.consulta[j].id;
                        sql += " ORDER BY bal_part_grupos_exp_soc_cient_miembros.id";

                        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql,
                        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql,
                            function (data_7) {
                                $(data_7.consulta).each(function (k) {
                                    var autor = data_7.consulta[k].name;
                                    $('#table-gys').find('#gys_' + data.consulta[j].id).parent().find(".t-autor").append(autor + ', ');
                                });
                            });

                    });
                }
                else {
                    $('#table-gys').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-gys').next().hide();
                }

            });
        //
        var sql_11 = " DISTINCT worker.name, bal_tutoria.id, bal_tutoria.estudiante,";
        sql_11 += " bal_tutoria.vista_publica, bal_tutoria.otros_datos, titulo, bal_tutoria.tipo, anno FROM";
        sql_11 += " bal_tutoria";
        sql_11 += " INNER JOIN worker ON bal_tutoria.worker_id = worker.id INNER JOIN entity";
        sql_11 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_tutoria.validado = 1";
        sql_11 += " AND bal_tutoria.vista_publica = 1 ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_11,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_11,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='5']").show();
                    //$('#table-tutorias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Tutor&iacute;as<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2) {
                            var style = 'style="display:none"';
                        }
                        else {
                            var style = '';
                        }
                        cadena = '<tr ' + style + '>' +
                            '<td style="width: 80%;padding-left: 20px;"><span id="tutoria_' +
                            data.consulta[j].id + '"></span> ';

                        if (data.consulta[j].otros_datos != "")
                            cadena += '' + data.consulta[j].otros_datos;

                        if (data.consulta[j].titulo != 'undefined' || data.consulta[j].titulo != '')
                            cadena += ' <span> ' + data.consulta[j].titulo + '</span>';
                        cadena += ' <br/><span class="t-autor pub_titulo">' + data.consulta[j].name + '</span>';
                        if (data.consulta[j].tipo != 'undefined' || data.consulta[j].tipo != '')
                            cadena += '<br/><span class="pub_datos"> ' + data.consulta[j].tipo + '</span>';
                        cadena += '</td>';
                        cadena += '<td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>';
                        //$('#table-tutorias').append('<tr ' + style + '><td class="pub_number"> - </td><td style="width: 80%;"><span id="tutoria_' + data.consulta[j].id + '">' + data.consulta[j].name + '</span>. <span> Tipo de Tesis: ' + data.consulta[j].tipo + '</span> , '+ data.consulta[j].otros_datos + ', <span class="pub_titulo"> ' + data.consulta[j].titulo +'</span> </td><td style="">'+data.consulta[j].anno+'</td></tr>');
                        $('#table-tutorias thead').show();
                        $('#table-tutorias').append(cadena);
                    });
                }
                else {
                    $('#table-tutorias').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-tutorias').next().hide();
                }

            });
        //
        var sql_12 = " DISTINCT worker.name, bal_oponencia_tribunal.id, bal_oponencia_tribunal.estudiante,";
        sql_12 += " bal_oponencia_tribunal.vista_publica, bal_oponencia_tribunal.otros_datos, titulo, tipo_tesis, anno FROM";
        sql_12 += " bal_oponencia_tribunal";
        sql_12 += " INNER JOIN worker ON bal_oponencia_tribunal.worker_id = worker.id INNER JOIN entity";
        sql_12 += " ON entity.id = worker.entity2 WHERE entity.name = '" + depart + "' AND bal_oponencia_tribunal.validado = 1 AND bal_oponencia_tribunal.vista_publica = 1";
        sql_12 += " ORDER BY anno DESC";

        //$.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql=" + sql_12,
        $.getJSON("http://ws.icimaf.cu/ws_custom.php?sql=" + sql_12,
            function (data) {
                if (data.consulta.length > 0) {
                    $(".nav-tabla>li[num-show='5']").show();
                    //$('#table-oponencias').append('<thead style="display: none;"><tr><td colspan="3" class="pub_number" style="cursor: pointer;width: 100%;">Oponencias en Tribunales<i class="fa fa-chevron-down" style="background-color:#C5C5C5;color:white;margin-left: 5px;border-radius: 50%;padding: 3px;" aria-hidden="true" onclick="updown(this);"></i></td></tr></thead>');
                    $(data.consulta).each(function (j) {
                        if (j > 2) {
                            var style = 'style="display:none"';
                        }
                        else {
                            var style = '';
                        }
                        $('#table-oponencias thead').show();
                        $('#table-oponencias').append('<tr ' + style + '><td style="width: 80%;padding-left: 20px;"><span id="oponencias_' + data.consulta[j].id + '"></span>' + data.consulta[j].otros_datos + ' <span class="t-publicacion"> ' + data.consulta[j].titulo + '</span> <br/><span class="t-autor pub_titulo">' + data.consulta[j].name + '</span><br/><span class="pub_datos">' + data.consulta[j].tipo_tesis + '</span></td><td>&nbsp;</td><td class="text-right"><span class="t-anno">' + data.consulta[j].anno + '</span></td></tr>');
                    });
                }
                else {
                    $('#table-oponencias').next().hide();
                }
                if (data.consulta.length < 4) {
                    $('#table-oponencias').next().hide();
                }

            });
        //

    }

});