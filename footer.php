<link rel="stylesheet" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/footer.css" />

    <script type="text/javascript">
        jQuery(document).ready(function($)
        {
            menuFooterMargin();

            function menuFooterMargin()
            {
                //$('#menu-menu-principal-1').css('margin-left', '0');
                $('#menu-menu-principal-1 > li:first-child').css('margin-left', '0');
                var menu_width = $('#menu-menu-principal-1').width();
                var li_sum_width = 0;
                $('#menu-menu-principal-1 > li').each(function(){
                    li_sum_width += $(this).outerWidth();
                });
                var margin_left = (menu_width-li_sum_width)/2;
                //$('#menu-menu-principal-1').css('margin-left', margin_left+'px');
                $('#menu-menu-principal-1 > li:first-child').css('margin-left', margin_left+'px');
            }

            $(window).resize(menuFooterMargin);
        });
    </script>

<div class="clearfix"></div>
<div id="footer" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="triangle-up">
    </div>
    <img class="img-responsive footer-central-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/flecha.png" />
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div class="col-xs-10" style="margin-top: 10px;">
        <style>
            #footer-menu > div > ul > li > ul > li > a{
                color:#68a4bc;
            }
            </style>
        <div id="footer-menu">
            <?php wp_nav_menu(); ?>
        </div>
 <div id="contact_info" style="float: right; color: #ffffff;">
     <div style="font-size:18px;margin-bottom: 10px;">
         <a style="text-decoration:none;" href="https://correo.icimaf.cu/mail/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/correo-icimaf.png" > Correo ICIMAF</a>
     </div>
            <div style="font-size:18px; margin: 10px 0px;">
                Informaci&oacute;n de contacto
            </div>
            <div>
                <i class="fa fa-phone" aria-hidden="true" style="padding:5px; margin-right: 10px; color: #192A30; background-color: white; border-radius: 50%;"></i> <label> (53) 78327764 </label> <br/>
                <i class="fa fa-envelope" aria-hidden="true" style="padding:5px; margin-right: 10px; margin-top: 10px; color: #192A30;background-color: white; border-radius: 50%;"></i><a href="mailto:icimaf@icimaf.cu">icimaf@icimaf.cu</a>
            </div>
 <div style="font-size:18px;margin: 10px 0px;">
Nuestra Aplicaci&oacute;n
            </div>
            <div>
               <i class="fa fa-android" aria-hidden="true" style="padding:5px; margin-right: 10px; color: #192A30;background-color: white; border-radius: 50%;"></i><a href="<?php echo site_url(); ?>/wp-content/uploads/apk/icimaf.apk">Descargar</a>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="footer-logo">
        <a href="<?php bloginfo('url'); ?>">
            <img class="img-responsive" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_icimaf_4.png" />
        </a>
    </div>
    <div id="footer_cabecera_enlaces_sociales">
        <ul>
            <?php echo mitema_redes_sociales(); ?>
        </ul>
    </div>
    <!--<div class="powerby col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        Dise&ntilde;ado y Desarrollado por <a href=" https://www.icimaf.cu/" target="_blank"><strong id="ido">ICIMAF</strong></a>
    </div>

    <div class="toplink">
    <a href="#">Top</a>
    </div>-->
    <?php wp_footer(); ?>
</div>
</body></html>