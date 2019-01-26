$ = jQuery;
$(document).ready(function(){

    //clonar elemento
    $('.clonar').click(function(){
        var clon = $(this).prev().clone();
        clon.val('');
        $('input[type=text], input[type=number]',clon).val('');
        $(this).parent().append(clon).append('<br/>');
    });

    $('.clonar_2').click(function(){
        var clon = $(this).parent().clone();
        clon.val('');
        clon.find(".eliminar_button").show();
        clon.find(".clonar_2").remove();
        $('input[type=text], input[type=number]',clon).val('');
        $(this).parent().parent().append(clon);
    });

    $('#your-profile').on('click', '.upload_button', function () {
            var mitema_upload;
            mitema_upload = $(this).prev('input');
            formfield = mitema_upload.attr('name');
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
            //return false;

        window.send_to_editor = function(html){
            imgurl = $('img',html).attr('src');
            if(typeof(imgurl) == 'undefined')
                imgurl = $(html).attr('href');
            mitema_upload.val(imgurl);
            tb_remove();
        }
    });


    //Trabajando con Ajax
/*
    var objeto = {where: {email: $('#email').val()}, fields: {1: 'id'}, table :'worker'};
    var cadena = JSON.stringify(objeto);

    var sql = " id FROM worker WHERE worker.email = '"+$('#email').val()+"'";

    //var codificado = encodeURIComponent(sql);

    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?sql="+sql,
        function(data){
         if(data.consulta.length > 0){
            $('#pub_importadas').append('<tr><td> <input type="text" name="id_intranet" value="'+data.consulta[0].id+'" /></td></tr>');
         }
        });*/
/*
    $.getJSON("http://intranet.icimaf.cu/ws_custom.php?cadena="+cadena,
        function(data){
            console.log(data.worker[0].id);
            var id = data.worker[0].id;

//segunda consulta
           var objeto = {where: {id: '2'}, table :'bal_publicacion'};
            var cadena = JSON.stringify(objeto);

            $.getJSON("http://intranet.icimaf.cu/ws_custom.php?cadena="+cadena,
                function(data){
                    console.log(data.bal_publicacion[0].titulo);

                });



        });
*/



});//fin document
jQuery = $;
