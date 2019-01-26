$ = jQuery;
$(document).ready(function(){

    $('.contenedor > form > div').hide();
    $('.contenedor > form > .active').fadeIn();
    $('.contenedor > form > .visible').fadeIn();

    $('.nav-tabs > li').click(function(){
        var item = 'div-' + $(this).attr('id');
        $('.nav-tabs > li').removeClass('active');
        $(this).addClass('active');
        $('.contenedor > form > div').fadeOut(300,function(){
           $('#' + item).fadeIn();
        });
        $('.visible').fadeIn();
    });

    $('.close').click(function(){
        $('.alert-dismissable').fadeOut();
    });

    var mitema_upload;
    $('.upload_button').click(function(){
        mitema_upload = $(this).parent().prev().find('input');
        //mitema_upload = $('#imagen_a');
        formfield = mitema_upload.attr('name');
        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });

    window.send_to_editor = function(html){
        //imgurl = $('img',html).attr('src');
        //var aaa = html.getElementsByTagName("IMG")[0].getAttribute('src');
        inicio = html.indexOf("src=\"")+5;
        fin = html.indexOf(" alt=")-1;
        imgurl = html.substring(inicio,fin);
        if(typeof(imgurl) == 'undefined')
            imgurl = $(html).attr('href');
        mitema_upload.val(imgurl);
        tb_remove();
    }

});//document
jQuery = $;

//Añadir nuevo colaboraqdor
function new_colaborador(){
    $('#aqui_col').find("table:hidden:eq(0)").show('slow');
}
//Eliminar colaborador
function del_colaborador(event, del_co){
    event.stopPropagation();
    $(del_co).parent().next().remove();
    $(del_co).parent().remove();
}

//Añadir nuevo estudiante
function new_estudiante(){
    $('#aqui_est').find("table:hidden:eq(0)").show('slow');
}
