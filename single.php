<?php get_header(); ?>
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
        <?php

        /////Mostrando los Departamentos
        $dep = get_post_meta(get_the_ID(), 'Departamento', true);
        $departamentos = array('', 'Control Automático', 'Física Aplicada', 'Física Teórica', 'Matemática', 'Matemática Interdisciplinaria', 'Redes');

        echo '<input id="departamento" type="hidden" value="' . $departamentos[$dep] . '"/>';


        //si no es un articulo normal Ej: Noticia
        if ($dep != ''):

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


    </div>
</div>

<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="margin-top: 30px;">
<hr style="color: #2A6D80; border: 1px solid #2A6D80;"/>

<h3 class="titulo_general text-center">MIEMBROS</h3>

<div class="miembros_single">

    <ul>
        <?php
        foreach ($user_query->results as $usuario):
            ?>
            <li>
                <div>
                    <a href="<?php echo get_author_posts_url($usuario->ID); ?>">
                        <img class="img-circle"
                             src="<?php echo get_wp_user_avatar_src($usuario->ID, 96); ?>"/>
                    </a>
                </div>
                <div style="margin-top: 10px;">
                    <a href="<?php echo get_author_posts_url($usuario->ID); ?>"><?php echo $usuario->first_name . ' ' . $usuario->last_name; ?></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
    /*$user_query_c = new WP_User_Query(
        array('meta_key' => 'user_departamento', 'meta_value' => $dep),
        array('meta_key' => 'flag_c', 'meta_value' => 1)
    );*/
    $user_query_c = new WP_User_Query(array('meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'user_departamento',
                'value' => $dep
            ),
            array(
                'key' => 'flag_c',
                'value' => 1
            )
        ))
    );
    if (count($user_query_c->results) > 0):
        ?>
        <div style="clear: both"></div>
        <hr style="color: #2A6D80; border: 1px solid #2A6D80;"/>
        <h3 class="titulo_general text-center" style="margin-top: 10px;">COLABORADORES</h3>
        <ul>
            <?php
            foreach ($user_query_c->results as $usuario_c):
                $user_c_n = get_the_author_meta('nombre_c', $usuario_c->ID);
                $user_c_e = get_the_author_meta('email_c', $usuario_c->ID);
                $user_c_f = get_the_author_meta('foto_c', $usuario_c->ID);
                for ($i = 0; $i < count($user_c_n); $i++):
                    ?>
                    <li>
                        <div>
                            <a href="<?php echo site_url() . '/index.php/colaboradores-y-estudiantes/?col_email=' . $user_c_e[$i]; ?>">
                                <img class="img-circle"
                                     src="<?php echo (isset($user_c_f[$i]) AND $user_c_f[$i] != '') ? $user_c_f[$i] : site_url() . '/wp-content/uploads/2016/09/grey_man.jpg'; ?>"/>
                            </a>
                        </div>
                        <div style="margin-top: 10px;">
                            <a href="<?php echo site_url() . '/index.php/colaboradores-y-estudiantes/?col_email=' . $user_c_e[$i]; ?>"><?php echo $user_c_n[$i]; ?></a>
                        </div>
                    </li>
                <?php
                endfor;
            endforeach;
            ?>
        </ul>
    <?php
    endif;
    $user_query_e = new WP_User_Query(array('meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'user_departamento',
                'value' => $dep
            ),
            array(
                'key' => 'flag_e',
                'value' => 1
            )
        ))
    );
    if (count($user_query_e->results) > 0):
        ?>
        <div style="clear: both"></div>
        <hr style="color: #2A6D80; border: 1px solid #2A6D80;"/>
        <h3 class="titulo_general text-center" style="margin-top: 10px;">ESTUDIANTES</h3>
        <ul>
            <?php
            foreach ($user_query_e->results as $usuario_e):
                $user_e_n = get_the_author_meta('nombre_e', $usuario_e->ID);
                $user_e_e = get_the_author_meta('email_e', $usuario_e->ID);
                $user_e_f = get_the_author_meta('foto_e', $usuario_e->ID);
                for ($i = 0; $i < count($user_e_n); $i++):
                    ?>
                    <li>
                        <div>
                            <a href="<?php echo site_url() . '/index.php/colaboradores-y-estudiantes/?est_email=' . $user_e_e[$i]; ?>">
                                <img class="img-circle"
                                     src="<?php echo (isset($user_e_f[$i]) AND $user_e_f[$i] != '') ? $user_e_f[$i] : site_url() . '/wp-content/uploads/2016/09/grey_man.jpg'; ?>"/>
                            </a>
                        </div>
                        <div style="margin-top: 10px;">
                            <a href="<?php echo site_url() . '/index.php/colaboradores-y-estudiantes/?est_email=' . $user_e_e[$i]; ?>"><?php echo $user_e_n[$i]; ?></a>
                        </div>
                    </li>
                <?php
                endfor;
            endforeach;
            ?>
        </ul>
    <?php
    endif;
    else:
        ?>
        <div class="my_post col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <h2 class="titulo_post"><?php the_title(); ?></h2>

            <h2 class="traduccion"><?php echo get_post_meta($post->ID, 'tf_events_trad_ti', true); ?></h2>

            <div class="img_post"><?php //the_post_thumbnail('thumbnail'); ?></div>
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
            //comments_template();
            ?>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <style>
                #searchform div label.screen-reader-text{
                    display: none;
                }
                #searchform div #s{
                   width: 80%;
                }
            </style>
            <?php
            get_sidebar('rigth');
            ?>
        </div>
    <?php
    endif;
    ?>
</div>

<?php

endwhile;
?>

<?php else : ?>

    <h3 class="center"><?php _e('No se encuentra la informacion.', 'icimaf'); ?></h3>
    <p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.', 'icimaf'); ?></p>
    <?php get_search_form(); ?>

<?php
endif;
?>

</div>
<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>
<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
<?php get_footer(); ?>
</div>
</div>
