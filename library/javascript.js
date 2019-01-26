$ = jQuery;
$(document).ready(function() {
    $('#xtext').hide();
    $('#xemail').hide();

    $('input[name="date-308"]').prop('placeholder','Seleccionar');

    $('#footer-menu .sub-menu').hide();

    $('#xtext').click(function(){
        $('.your-name > input').prop('value',' ');
        $(this).hide();
    });
    $('#xemail').click(function(){
        $('.your-email > input').prop('value',' ');
        $(this).hide();
    });

    $('#xphone').click(function(){
        //var x = $(".tel-582 input").clone().append('<span id="mphone"> dele </span>');
        $("#more-phone").css('display','block');
        $("p > .tel-582").clone(true).append('<span class="mphone">-</span>').appendTo("#more-phone");
       // x.appendTo("#more-phone");
    });

    $('.wp-pagenavi .previouspostslink').html('<i class="fa fa-angle-left"></i>');
    $('.wp-pagenavi .nextpostslink').html('<i class="fa fa-angle-right"></i>');

    $('.overlay').click(function(){
        $('#mega-menu-wrap-max_mega_menu_1').css('z-index','1');
        $('#mega-menu-max_mega_menu_1').css('z-index','1');
    });

    $('#galerias_select').customSelect();


    /*$('input[name="date-308"]').datepicker({
        minDate: "+0D",
        maxDate: "+1Y",//M=mes D=dia Y=anno
        //showMonthAfterYear: false,
       // yearRange: "<?php echo date("Y");?>:<?php echo date("Y");?>",
        changeMonth: true,
        numberOfMonths: 1,
        showButtonPanel: true,
        dateFormat: "dd-mm-yy",//formato dd-mm-aaaa
        dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],//dias de la semana
        dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],//dias de la semana corto
        duration: "slow",
        //showAnim: "fold",
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembrr", "Octubre", "Noviembre", "Deciembre" ],
        prevText: "Anterior",
        nextText: "Sigiuente",
        currentText: "Hoy",
        closeText: "Cerrar"
    });*/
});

$(document).on("click",".mphone",function(){
    var parent = $(this).parent();
    $(parent).remove();
});

$(document).on("keyup",".your-name",function(){
    if($('#xtext').attr('value') == ' ')
        $('#xtext').hide();
    else
        $('#xtext').show();
});

$(document).on("keyup",".your-email",function(){
    if($('#xemail').attr('value') == ' ')
        $('#xemail').hide();
    else
        $('#xemail').show();
});

imagen = '';
$(document).on("mouseover",".servicios-item img",function(){
    imagen = $(this).attr('src');
    var text = $(this).attr('alt');
    var url = '../wp-content/themes/imagenart/images/'+text+'-active.jpg';
    $(this).prop('src',url);
});
$(document).on("mouseleave",".servicios-item img",function(){
    $(this).prop('src',imagen);
});

$(document).on("mouseover",".owl-item img",function(){
    imagen = $(this).attr('src');
    var text = $(this).attr('alt');
    var url = 'wp-content/themes/imagenart/images/'+text+'-active.jpg';
    $(this).prop('src',url);
});
$(document).on("mouseleave",".owl-item img",function(){
    $(this).prop('src',imagen);
});