<?php /* Template Name: Colaborador y Estudiante */ ?>
<?php get_header(); ?>

<div class="clearfix"></div>
            <?php
            if (isset($_GET['est_email'])) :
            $email = $_GET['est_email'];
            $user_query = new WP_User_Query(array('meta_key' => 'flag_e', 'meta_value' => 1));
            if (count($user_query->results) > 0):
            foreach ($user_query->results as $usuario_e):
            $user_e_e = get_the_author_meta('email_e', $usuario_e->ID);
            $user_e_n = get_the_author_meta('nombre_e', $usuario_e->ID);
            $user_e_f = get_the_author_meta('foto_e', $usuario_e->ID);
            $user_e_d = get_the_author_meta('des_e', $usuario_e->ID);
            $user_e_u = get_the_author_meta('url_e', $usuario_e->ID);
            $user_e_a = get_the_author_meta('afiliacion_e', $usuario_e->ID);
            for ($i = 0;
            $i < count($user_e_n);
            $i++):
            if ($user_e_e[$i] == $email):
            ?>
            <div class="author" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/autor_fondo.jpg'); height: 200px;">
                <br/>
                <br/>
                <br/>
                <div>
                    <img style="margin-top: 0px; margin-bottom: 0px;" id="author-img" class="img-circle"
                         src="<?php echo (isset($user_e_f[$i]) AND $user_e_f[$i] != '') ? $user_e_f[$i] : site_url() . '/wp-content/uploads/2016/09/grey_man.jpg'; ?>"/>
                </div>
            </div>
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div id="author-name" style="margin-top: 20px;">
                <?php echo $user_e_n[$i]; ?>
            </div>
            <hr/>
            <div class="author-description">
                <div class="name">Web Personal:</div>
                <div class="description"><a
                        href="<?php echo $user_e_u[$i]; ?>"><?php echo $user_e_u[$i]; ?></a>
                </div>
                <div style="clear: both"></div>
                <div class="name">Email:</div>
                <div class="description">
                    <a id="mail_usuario" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                </div>
                <div style="clear: both"></div>
                <div class="name">Afiliaci&oacute;n:</div>
                <div class="description"><a
                        href="<?php echo $user_e_a[$i]; ?>"><?php echo $user_e_a[$i]; ?></a>
                </div>
                <div style="clear: both"></div>
                <div class="name">Descripci&oacute;n:</div>
                <div class="description">
                    <?php echo $user_e_d[$i]; ?>
                </div>
                <div style="clear: both"></div>
                <?php
                break;
                endif;
                endfor;
                endforeach;
                ?>
                <?php
                endif;
                elseif (isset($_GET['col_email'])):
                $email = $_GET['col_email'];
                $user_query = new WP_User_Query(array('meta_key' => 'flag_c', 'meta_value' => 1));
                if (count($user_query->results) > 0):
                foreach ($user_query->results as $usuario_c):
                $user_c_n = get_the_author_meta('nombre_c', $usuario_c->ID);
                $user_c_e = get_the_author_meta('email_c', $usuario_c->ID);
                $user_c_f = get_the_author_meta('foto_c', $usuario_c->ID);
                $user_c_d = get_the_author_meta('des_c', $usuario_c->ID);
                $user_c_u = get_the_author_meta('url_c', $usuario_c->ID);
                $user_c_a = get_the_author_meta('afiliacion_c', $usuario_c->ID);
                for ($i = 0;
                $i < count($user_c_n);
                $i++):
                if($user_c_e[$i] == $email):
                ?>
                <div class="author" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/autor_fondo.jpg'); height: 200px;">
                    <br/>
                    <br/>
                    <br/>
                    <div>
                        <img style="margin-top: 0px; margin-bottom: 0px;" id="author-img" class="img-circle"
                             src="<?php echo (isset($user_c_f[$i]) AND $user_c_f[$i] != '') ? $user_c_f[$i] : site_url() . '/wp-content/uploads/2016/09/grey_man.jpg'; ?>"/>
                    </div>
                </div>
                <div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
                        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <div id="author-name" style="margin-top: 20px;">
                    <?php echo $user_c_n[$i]; ?>
                </div>
                <hr/>
                <div class="author-description">
                    <div class="name">Web Personal:</div>
                    <div class="description"><a
                            href="<?php echo $user_c_u[$i]; ?>"><?php echo $user_c_u[$i]; ?></a>
                    </div>
                    <div style="clear: both"></div>
                    <div class="name">Email:</div>
                    <div class="description"><a id="mail_usuario"
                                                href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                    </div>
                    <div style="clear: both"></div>
                    <div class="name">Afiliaci&oacute;n:</div>
                    <div class="description"><a
                            href="<?php echo $user_c_a[$i]; ?>"><?php echo $user_c_a[$i]; ?></a>
                    </div>
                    <div style="clear: both"></div>
                    <div class="name">Descripci&oacute;n:</div>
                    <div class="description">
                        <?php echo $user_c_d[$i]; ?>
                    </div>
                    <div style="clear: both"></div>
                    <?php
                    break;
                    endif;
                    endfor;
                    endforeach;
                    endif;
                    endif;

                    ?>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        </div>
        <?php get_footer(); ?>
