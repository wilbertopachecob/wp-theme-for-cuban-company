<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 27/11/15
 * Time: 10:07
 */
add_action( 'init', 'crear_ievento' );

function crear_ievento() {
$args = array(
    'label' => __('Eventos'),
    'singular_label' => __('Evento'),
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'rewrite' => true,
    'query_var' => 'ieventos',
    'supports' => array('title', 'thumbnail', 'editor','comments')
);
register_post_type( 'ievento' , $args );
}

// 4. Show Meta-Box

add_action( 'admin_init', 'ievento_create' );

function ievento_create() {
    add_meta_box('ievento_meta', 'Evento', 'ievento_meta', 'ievento');
}

function ievento_meta () {

    // - grab data -

    global $post;
    $custom = get_post_custom($post->ID);
    $meta_sd = $custom["ievento_startdate"][0];
    $meta_ed = $custom["ievento_enddate"][0];
    $meta_st = $meta_sd;
    $meta_et = $meta_ed;

    // - grab wp time format -

    $date_format = get_option('date_format'); // Not required in my code
    $time_format = get_option('time_format');

    // - populate today if empty, 00:00 for time -

    if ($meta_sd == null) { $meta_sd = time(); $meta_ed = $meta_sd; $meta_st = 0; $meta_et = 0;}

    // - convert to pretty formats -

    $clean_sd = date("D, M d, Y", $meta_sd);
    $clean_ed = date("D, M d, Y", $meta_ed);
    $clean_st = date($time_format, $meta_st);
    $clean_et = date($time_format, $meta_et);

    // - security -

    echo '<input type="hidden" name="ievento-nonce" id="ievento-nonce" value="' .
        wp_create_nonce( 'ievento-nonce' ) . '" />';

    // - output -

    ?>
    <div class="ie-meta">
        <ul>
            <li><label>Fecha de Inicio</label><input name="ievento_startdate" class="iedate" value="<?php echo $clean_sd; ?>" /></li>
            <li><label>Hora de Inicio</label><input name="ievento_starttime" value="<?php echo $clean_st; ?>" /><em>Usa el formato de 24h (7pm = 19:00)</em></li>
            <li><label>Fecha Final</label><input name="ievento_enddate" class="iedate" value="<?php echo $clean_ed; ?>" /></li>
            <li><label>Tiempo Final</label><input name="ievento_endtime" value="<?php echo $clean_et; ?>" /><em>Usa el formato de 24h (7pm = 19:00)</em></li>
        </ul>
    </div>
<?php
}

// 5. Save Data

add_action ('save_post', 'save_ievento');

function save_ievento(){

    global $post;

    // - still require nonce

    if ( !wp_verify_nonce( $_POST['ievento-nonce'], 'ievento-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - convert back to unix & update post

    if(!isset($_POST["ievento_startdate"])):
        return $post;
    endif;
    $updatestartd = strtotime ( $_POST["ievento_startdate"] . $_POST["ievento_starttime"] );
    update_post_meta($post->ID, "ievento_startdate", $updatestartd );

    if(!isset($_POST["ievento_enddate"])):
        return $post;
    endif;
    $updateendd = strtotime ( $_POST["ievento_enddate"] . $_POST["ievento_endtime"]);
    update_post_meta($post->ID, "ievento_enddate", $updateendd );

}

// 7. JS Datepicker UI

function ievento_styles() {
    global $post_type;
    if( 'ievento' != $post_type )
        return;
    wp_enqueue_style('jquery-ui', get_bloginfo('template_url') . '/css/jquery-ui.css');
}

function ievento_scripts() {
    global $post_type;
    if( 'ievento' != $post_type )
        return;
    wp_enqueue_script('jquery', get_bloginfo('template_url') . '/js/jquery.js', array('jquery'));
    wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/js/jquery-ui.js', array('jquery'));
    wp_enqueue_script('custom_script', get_bloginfo('template_url').'/js/custom-ievento.js', array('jquery'));
}

add_action( 'admin_print_styles-post.php', 'ievento_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'ievento_styles', 1000 );

add_action( 'admin_print_scripts-post.php', 'ievento_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'ievento_scripts', 1000 );


