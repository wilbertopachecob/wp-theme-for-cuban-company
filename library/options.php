<?php
//Variables para agilizar el proceso
$mitema_opciones = array();
$mitema_abreviacion = 'mit';

function mitema_opciones(){
    global $mitema_abreviacion, $mitema_opciones;

    // Create array to store the Categories to be used in the drop-down select box
    $categories_obj = get_categories('hide_empty=0');
    $categories = array();
    foreach ($categories_obj as $cat){
        $categories[$cat->cat_ID] = $cat->cat_name;
    }

    $mitema_opciones = array(
        array(
            "name" => "Logo",
            "desc" => __('<div class="alert alert-warning">Elige una imagen para el logo del sitio. <a href="#" class="alert-link">(Dimensiones recomendadas 250x100)</a></div>','mitema'),
            "id" => "mitema_upload_image",
            "std" => get_bloginfo( 'stylesheet_directory' ).'/images/logotipo.png',
            "type" => "text"
            ),
        array(
            "name" => "Search",
            "desc" => __('<div class="alert alert-warning">Elige una imagen para el buscar del sitio. <a href="#" class="alert-link">(Dimensiones recomendadas 50x50)</a></div>','mitema'),
            "id" => "mitema_search_image",
            "std" => get_bloginfo( 'stylesheet_directory' ).'/images/buscar.png',
            "type" => "text"
        ),
        array("name" => "Favicon",
            "desc" => __('<div class="alert alert-warning">Elige una imagen de favicon.</div>','mitema'),
            "id" => "mitema_upload_favicon",
            "std" => get_bloginfo( 'stylesheet_directory' ).'/images/favicon.ico',
            "type" => "text"
            ),
        array(
            "name" => "Newsletter",
            "desc" => __('<div class="alert alert-warning">Elige el archivo de newsletter.</div>','mitema'),
            "id" => "mitema_upload_newsletter",
            "type" => "text"
            ),
        array(
            "name" => __('Facebook','mitema'),
            "id" => "mitema_link_facebook",
            "std" => 'http://www.facebook.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Twitter','mitema'),
            "id" => "mitema_link_twitter",
            "std" => 'http://www.twitter.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Google+','mitema'),
            "id" => "mitema_link_google",
            "std" => 'http://www.googleplus.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Instagram','mitema'),
            "id" => "mitema_link_instagram",
            "std" => 'http://www.instagram.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Pinterest','mitema'),
            "id" => "mitema_link_pinterest",
            "std" => 'http://www.pinterest.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Youtube','mitema'),
            "id" => "mitema_link_youtube",
            "std" => 'http://www.youtube.com/',
            "type" => "text"
            ),
        array(
            "name" => __('Description','mitema'),
            "desc" => __('<div class="alert alert-warning">Escribe una breve descripci&oacute;n de tu sitio.</div>','mitema'),
            "id" => "mitema_meta_description",
            "std" => '',
            "type" => "textarea"
            ),
        array(
            "name" => __('Keywords','mitema'),
            "desc" => __('<div class="alert alert-warning">Escribe las palabras claves de tu sitio.</div>','mitema'),
            "id" => "mitema_meta_keywords",
            "std" => '',
            "type" => "textarea"
            ),
        array(
            "name" => __('Código en Header','mitema'),
            "desc" => __('<div class="alert alert-warning">Esto es &uacute;til cuando quieres adicionar c&oacute;digo <a href="#" class="alert-link">CSS</a> o <a href="#" class="alert-link">JavaScript</a> a tu sitio.</div>','mitema'),
            "id" => "mitema_cod_header",
            "std" => '',
            "type" => "textarea"
            ),
        array(
            "name" => __('Código en Body','mitema'),
            "desc" => __('<div class="alert alert-warning">Esto es &uacute;til cuando quieres adicionar c&oacute;digo como el de <a href="#" class="alert-link">google analitics</a> despu&eacute;s del t&iacute;tulo de la entrada.</div>','mitema'),
            "id" => "mitema_cod_body",
            "std" => '',
            "type" => "textarea"
            ),
        array(
            "name" => __('Código en Entrada','mitema'),
            "desc" => __('<div class="alert alert-warning">Adiciona c&oacute;digo antes de los comentarios de una entrada. Esto es &uacute;til cuando quieres adicionar c&oacute;digo como las <a href="#" class="alert-link">opciones de compartir de las redes sociales</a>.</div>','mitema'),
            "id" => "mitema_cod_post",
            "std" => '',
            "type" => "textarea"
            ),
        array(
            "name" => __('Código CSS','mitema'),
            "desc" => __('<div class="alert alert-warning">Crea nuevas reglas de estilo que gustes para modificar el codigo. <a href="#" class="alert-link">No incluyas las etiquetas style.</a></div>','mitema'),
            "id" => "mitema_cod_css",
            "std" => '',
            "type" => "textarea"
            )
        );
    }
    add_action('init', 'mitema_opciones');

    // Make a theme options page
    function mitema_add_admin(){
        global $mitema_abreviacion, $mitema_opciones;
        if ( $_GET['page'] == basename(__FILE__) ){
            if ( 'save' == $_REQUEST['action'] ){
                // protect against request forgery
                check_admin_referer('mitema-save');
                // save the options
                foreach ($mitema_opciones as $value){
                    if( isset( $_REQUEST[ $value['id'] ] ) ){
                        update_option( $value['id'], $_REQUEST[ $value['id'] ] );
                    }
                    else    {
                        delete_option( $value['id'] );
                    }
                }
                header("Location: themes.php?page=options.php&saved=true");
                die;
            }
            else if ( 'reset' == $_REQUEST['action'] ){
                // protect against request forgery
                check_admin_referer('mitema-reset');
                // delete the options
                foreach ($mitema_opciones as $value){
                    delete_option( $value['id'] );
                }
                header("Location: themes.php?page=options.php&reset=true");
                die;
            }
        }
        add_theme_page("ICIMAF Opciones", "ICIMAF Opciones",'edit_themes', basename(__FILE__), 'mitema_admin');
    }

    add_action('admin_menu' , 'mitema_add_admin');

    function my_admin_scripts(){
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        //wp_enqueue_script('iris');
        wp_register_script('my-upload', get_bloginfo( 'stylesheet_directory' ) . '/library/my-script.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('my-upload');
    }

    function my_admin_styles(){
        wp_enqueue_style('thickbox');
        wp_register_style('mitema-admin', get_bloginfo( 'stylesheet_directory' ) . '/library/mitema-admin.css', '', '', 'all');
        wp_register_style('mitema-admin-boot', get_bloginfo( 'stylesheet_directory' ) . '/vendors/bootstrap.min.css', '', '', 'all');
        wp_enqueue_style('mitema-admin');
        wp_enqueue_style('mitema-admin-boot');
    }

    if (isset($_GET['page']) && $_GET['page'] == 'options.php'){
        add_action('admin_print_scripts', 'my_admin_scripts');
        add_action('admin_print_styles', 'my_admin_styles');
    }

    function mitema_admin(){
        global $mitema_abreviacion, $mitema_opciones;
        // Saved or Updated message
        if ( $_REQUEST['saved'] ):
            ?>
            <div class="clearfix" style="margin-top: 25px"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Los cambios se han guardado con <strong>&eacute;xito</strong>
                </div>
            </div>
        <?php
        endif;
        if ( $_REQUEST['reset'] ):
            ?>
            <div class="clearfix" style="margin-top: 25px"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    Las opciones han sido <strong>reseteadas</strong>
                </div>
            </div>
            <?php
        endif;
        ?>
        <div class="clearfix" style="margin-top: 25px"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right powerby">Creado por <a href="http://www.readycode.net/">Readycode</a></div>
        <div class="clearfix"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <ul class="nav nav-tabs">
                <li id="nav1" class="active"><a href="#">General</a></li>
                <li id="nav2"><a href="#">SEO</a></li>
                <li id="nav3"><a href="#">C&oacute;digo Extra</a></li>
            </ul>
        </div>
        <div class="contenedor">
            <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('mitema-save'); ?>
            <div id="div-nav1" class="active col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                foreach ($mitema_opciones as $value){
                    switch ( $value['id'] ){
                        //UPLOAD LOGOTIPO
                        case 'mitema_upload_image':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-1 col-md-1 col-lg-1 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        />
                                </div>
                                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                    <input id="upload_image_button_1"
                                           class="upload_button btn btn-primary"
                                           type="button"
                                           value="<?php echo __("Subir Imagen", "mitema"); ?>"
                                        />
                                </div>
                                <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //UPLOAD FAVICON
                        case 'mitema_upload_favicon':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-1 col-md-1 col-lg-1 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                    <input id="upload_image_button_2"
                                           class="upload_button btn btn-primary"
                                           type="button"
                                           value="<?php echo __("Subir Favicon", "mitema"); ?>"
                                        />
                                </div>
                                <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //UPLOAD NEWSLETTER
                        case 'mitema_upload_newsletter':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-1 col-md-1 col-lg-1 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2">
                                    <input id="upload_image_button"
                                           class="upload_button btn btn-primary"
                                           type="button"
                                           value="<?php echo __("Subir Newsletter", "mitema"); ?>"
                                        />
                                </div>
                                <div class="col-xs-2 col-sm-4 col-md-4 col-lg-4">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        default:
                            break;
                    }//switch
                }//foreach
                ?>
            </div>
            <div id="div-nav2" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="alert alert-success">Enlaces a redes sociales.</div>
                <?php
                foreach ($mitema_opciones as $value){
                    switch ( $value['id'] ){
                        //FACEBOOK
                        case 'mitema_link_facebook':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        //TWITTER
                        case 'mitema_link_twitter':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        //GOOGLE
                        case 'mitema_link_google':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        //INSTAGRAM
                        case 'mitema_link_instagram':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        //PRINTEREST
                        case 'mitema_link_pinterest':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        //YOUTUBE
                        case 'mitema_link_youtube':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-3 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10">
                                    <input name="<?php echo $value['id']; ?>"
                                           type="<?php echo $value['type']; ?>"
                                           class="form-control"
                                           id="<?php echo $value['id']; ?>"
                                           value="<?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>"
                                        >
                                </div>
                            </div>
                            <?php
                            break;
                        default:
                            break;
                    }//switch
                }//foreach
                ?>
                <div class="alert alert-success">Metadatos.</div>
                <?php
                foreach ($mitema_opciones as $value){
                    switch ( $value['id'] ){
                        //DESCRIPTION
                        case 'mitema_meta_description':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //KEYWORDS
                        case 'mitema_meta_keywords':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //HEADER
                        case 'mitema_cod_header':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //BODY
                        case 'mitema_cod_body':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        //ENTRADA
                        case 'mitema_cod_post':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        default:
                            break;
                    }//switch
                }//foreach
                ?>
            </div>
            <div id="div-nav3" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                foreach ($mitema_opciones as $value){
                    switch ( $value['id'] ){
                        case 'mitema_cod_css':
                            ?>
                            <div class="form-group">
                                <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label"><?php echo $value['name']; ?></label>
                                <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
                                    <textarea name="<?php echo $value['id']; ?>"
                                              class="form-control"
                                              id="<?php echo $value['id']; ?>"
                                              rows="5"
                                        >
                                        <?php echo stripslashes(get_option( $value['id'], $value['std'] )); ?>
                                    </textarea>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                    <?php echo $value['desc']; ?>
                                </div>
                            </div>
                            <?php
                            break;
                        default:
                            break;
                    }
                }//foreach
                ?>
            </div>

            <div class="clearfix visible"></div>
            <div class="visible botones col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right alert alert-info">
                <input name="save" type="submit" value="Guardar cambios" class="btn btn-success" />
                <input type="hidden" name="action" value="save" />
            </div>
            </form>
            <div class="clearfix visible"></div>
            <form class="form-horizontal reset" role="form" method="post">
                <div class="visible col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <?php wp_nonce_field('mitema-reset'); ?>
                    <input class="btn btn-danger" name="reset" type="submit" value="Opciones por defecto" />
                    <input type="hidden" name="action" value="reset" />
                </div>
            </form>
            <div class="clearfix visible"></div>
        </div>
    <?php
    }


function mitema_redes_sociales(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    ?>
    <li><a target="_blank" href="<?php echo $mitema_link_facebook; ?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
    <li><a target="_blank" href="<?php echo $mitema_link_twitter; ?>" title="Twitter"><i class="fa fa-twitter"></i></a></li>
    <li><a target="_blank" href="<?php echo $mitema_link_google; ?>" title="Google+"><i class="fa fa-google"></i></a></li>
    <li><a href="<?php echo site_url(); ?>/wp-content/uploads/apk/icimaf.apk" title="App ICIMAF"><i class="fa fa-android"></i></a></li>

    <!--<li><a href="<?php //echo $mitema_link_pinterest; ?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
    <li><a href="<?php //echo $mitema_link_youtube; ?>" title="YouTube"><i class="fa fa-youtube"></i></a></li>
    <li><a href="<?php //echo $mitema_link_instagram; ?>" title="Instagram"><i class="fa fa-instagram"></i></a></li>-->
    <?php
}

function mitema_logo(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    ?>
    <img class="img-responsive" src="<?php echo $mitema_upload_image; ?>" />
    <?php
}

function mitema_search(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    ?>
    <img src="<?php echo $mitema_search_image; ?>" />
<?php
}

function mitema_favicon(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    if($mitema_upload_favicon != '')
        echo '<link rel="shortcut icon" href="'.$mitema_upload_favicon.'" />';
}
add_action('wp_head', 'mitema_favicon');

function mitema_metas(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    if($mitema_meta_description != '')
        echo '<meta content="'.$mitema_meta_description.'" name="description">';
    if($mitema_meta_description != '')
        echo '<meta content="'.$mitema_meta_keywords.'" name="keywords">';
}
add_action('wp_head', 'mitema_metas');

function mitema_codigo_body(){
    global $mitema_opciones;
    foreach ($mitema_opciones as $value){
        $$value['id'] = get_option($value['id'], $value['std']);
    }
    if($mitema_cod_body != '')
        echo $mitema_cod_body;
}

function enviar_newsletter(){
    if(isset($_POST['send_newsletter']) && $_POST['email_newsletter'] != ''){
        global $mitema_opciones;
        foreach ($mitema_opciones as $value){
            $$value['id'] = get_option($value['id'], $value['std']);
        }
        if($mitema_upload_newsletter != ''){
            $cadena = substr($mitema_upload_newsletter,strrpos($mitema_upload_newsletter,'/uploads/'),strlen($mitema_upload_newsletter));
            $attachments = array( WP_CONTENT_DIR . $cadena);
            $admin_email = get_option( 'admin_email' );
            $headers = 'From: Imagen Art ' .strip_tags($admin_email). "\r\n";
            $headers .= "Reply-To: ". strip_tags($admin_email) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $subject = "Newsletter de Imagen Art";
            $message = "Este es el Newsletter de Imagen Art, para m&aacute;s informaci&oacute;n visita nuestro sitio web <a href=".get_site_url()."> Imagen Art</a>";
            wp_mail( strip_tags($_POST['email_newsletter']), $subject, $message, $headers, $attachments );
        }
    }
}
add_action( 'init', 'enviar_newsletter' );