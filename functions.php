<?php

//include importar publicaciones para perfil de usuarios
//include('library/importar_publicaciones.php');

// include theme options

include('library/options.php');
require_once('library/widget-noticias.php');
require_once('library/widget-eventos.php');

// include style options

include('library/style-options.php');
include('library/opciones_usuario.php');

add_editor_style();

add_theme_support('post-thumbnails');

set_post_thumbnail_size(540, 300, true);

add_image_size('homepage-thumbnail', 300, 200, true);


if (function_exists('register_sidebars'))
    register_sidebars(1);

register_nav_menus(array(
    'menu_cabecera' => 'Menu de Cabecera'
));

include('cpt-events.php');
/*
function coneccion_externa(){
		$mydb = new wpdb('root','root','intranet','localhost');
		$rows = $mydb->get_results("SELECT email FROM worker");
		$cadena = "<tr><td><ul>";
		foreach ($rows as $obj) :
		   $cadena += "<li>".$obj->email."</li>";
		endforeach;
		$cadena += "</ul></td></tr>";
		return $cadena;
} 
*/
function mostrar_eventos($cant)
{
    $args = array('post_type' => 'tf_events', 'posts_per_page' => $cant);
    $loop = new WP_Query($args);
    $meses = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Agos", "Sep", "Oct", "Nov", "Dic");
    ?>
    <div class="contenedor_evento">
        <h2 class="cabeceras"><a href="http://eventos.icimaf.cu/">EVENTOS</a></h2>

        <div class="clearfix"></div>
        <div id="eventos_contenido">
            <?php
            while ($loop->have_posts()) : $loop->the_post();

                $custom = get_post_custom(get_the_ID());
                $sd = $custom["tf_events_startdate"][0];
                $ed = intval($custom["tf_events_enddate"][0]);


                $gmts = date('Y-m-d H:i:s', $sd);
                $gmts = get_gmt_from_date($gmts); // this function requires Y-m-d H:i:s, hence the back & forth.
                $gmts = strtotime($gmts);


                $gmte = date('Y-m-d H:i:s', $ed);
                $gmte = get_gmt_from_date($gmte); // this function requires Y-m-d H:i:s, hence the back & forth.
                $gmte = strtotime($gmte);

                //comparando fechas final y actual

                $fecha_actual = strtotime(date("Y-m-d H:i:00", time()));
                //echo $gmts.'-'.$fecha_actual.'-'.$gmte;
                if ($fecha_actual > $gmts AND $fecha_actual > $gmte) {
                    $clase = 'pasado';
                }
                if ($gmts <= $fecha_actual AND $fecha_actual <= $gmte) {
                    $clase = 'actual';
                }
                if ($gmts > $fecha_actual AND $fecha_actual < $gmte) {
                    $clase = 'proximo';
                }


                //$short_title = substr(get_the_title(), 0, 17);
                $short_title = get_the_title();

                ?>

                <div class="evento <?php echo $clase; ?>">
                    <div class="evento_titulo"><a href="<?php the_permalink(); ?>" style="color: #ffffff;"
                                                  rel="bookmark"><?php echo $short_title; ?></a></div>
                    <div class="evento_fecha evento_fecha_inicio"><label class="articulo_fecha">del</label> <span
                            class="evento_dia"> <?php echo date('d', $gmts); ?> </span> <?php echo $meses[date('n', $gmts) - 1] . date(' Y', $gmts); ?>
                    </div>
                    <hr/>
                    <div class="evento_fecha evento_fecha_fin"><label class="articulo_fecha">al</label> <span
                            class="evento_dia"> <?php echo date('d', $gmte); ?> </span> <?php echo $meses[date('n', $gmte) - 1] . date(' Y', $gmte); ?>
                    </div>
                    <?php if (get_post_thumbnail_id()) {
                        ?>
                        <div class="crop_img"><a href="<?php the_permalink(); ?>"
                                                 rel="bookmark"> <?php the_post_thumbnail(); ?> </a></div> <?php
                    }
                    ?>
                    <div class="evento_contenido" style="margin-top:5px;"> <?php the_excerpt(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php
}

/*
add_filter('image_send_to_editor', 'my_image_send_to_editor', 10, 2);
function my_image_send_to_editor($html, $id)
{
    $description = str_replace("\r\n",' ', $description);
}
*/
add_action('admin_menu', 'cyb_remove_meta_boxes');
function cyb_remove_meta_boxes()
{

    remove_meta_box('commentstatusdiv', 'post-type-here', 'normal');

}

// para habilitar los comentarios en los eventos que dio problemas
/*function enable_comments_for_all()
{
    global $wpdb;
    $wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET comment_status = 'open'")); // Enable comments
    $wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET ping_status = 'open'")); // Enable trackbacks
}

enable_comments_for_all();
*/
//esconder opciones de menu Eventos

function hide_menus()
{
    global $current_user, $menu;
    /* Set list of disallowed user roles. */
    $disallowed_roles = array('subscriber');
    $disallowed = false;
    /* Check current user role against all disallowed roles. */
    foreach ($disallowed_roles as $disallowed_role) {
        /* Current user role must not be disallowed. */
        if (in_array($disallowed_role, $current_user->roles)) {
            $disallowed = true; // User role disallowed.
            break;
        }
    }
    /* User passed the check. Bail before hiding the menu. */
    if ($disallowed === false) {
        return;
    }
    /* Set list of disallowed dashboard administration menus. */
    $restricted = array(
        __('Eventos') // Text as it appears in the admin menu.
    );
    /* Attempt to hide admin menus. */
    foreach ($menu as $index => $menu_data) {
        if (in_array($menu_data[0], $restricted)) {
            unset($menu[$index]);
        }
    }
}

//add_action('admin_menu', array($this, 'hide_menus'), 101);
add_action('admin_menu', 'hide_menus', 101);

//Creando el Post Type de Noticias

add_action('init', 'create_post_type_not');

function create_post_type_not()
{
    register_post_type('icimaf_noticias',
        array(
            'labels' => array(
                'name' => __('Noticias'),
                'singular_name' => __('Noticias')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'custom-fields'),
        )
    );
}

add_action('admin_init', 'icimaf_noticias_perm');

function icimaf_noticias_perm()
{
    add_meta_box('icimaf_noticias_perm', 'Noticia fija en portada', 'icimaf_noticias_perm_funct', 'icimaf_noticias');
}

function icimaf_noticias_perm_funct()
{
    global $post;
    ?>
    <div class="checkbox">
        <label>
            <?php
            if (get_post_meta($post->ID, 'icimaf_noticias_perm', true) == 1):
                $checked = "checked";
            endif;
            ?>
            <input type="checkbox" name="n_perm" <?php echo $checked; ?> /> Marque si desea que la noticia se mantenga
            de forma permanente en la portada.
        </label>
    </div>
    <div>

    </div>
<?php
}

// 5. Save Data

add_action('save_post', 'save_icimaf_noticias');

function save_icimaf_noticias()
{

    global $post;

    if (!current_user_can('edit_post', $post->ID))
        return $post->ID;

    // - Guardando si es permanente o no

    if (isset($_POST["n_perm"])):
        update_post_meta($post->ID, "icimaf_noticias_perm", 1);
    else:
        update_post_meta($post->ID, "icimaf_noticias_perm", 0);
    endif;
}

?>