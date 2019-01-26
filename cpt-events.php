<?php
add_action('admin_init', 'tf_functions_css');

function tf_functions_css() {
	wp_enqueue_style('tf-functions-css', get_bloginfo('template_directory') . '/css/tf-functions.css');
}

// 1. Custom Post Type Registration (Events)

add_action( 'init', 'create_event_postype' );

function create_event_postype() {

$labels = array(
    'name' => _x('Eventos', 'post type general name'),
    'singular_name' => _x('Evento', 'post type singular name'),
    'add_new' => _x('Crear nuevo', 'events'),
    'add_new_item' => __('Crear nuevo Evento'),
    'edit_item' => __('Editar Evento'),
    'new_item' => __('Nuevo Evento'),
    'view_item' => __('Ver Evento'),
    'search_items' => __('Buscar Eventos'),
    'not_found' =>  __('No se encontraron eventos'),
    'not_found_in_trash' => __('No se encontraron eventos en la Papelera'),
    'parent_item_colon' => '',
);

$args = array(
    'label' => __('Eventos'),
    'labels' => $labels,
    'public' => true,
    'can_export' => true,
    'show_ui' => true,
    '_builtin' => false,
    '_edit_link' => 'post.php?post=%d', // ?
    'capability_type' => 'post',
    //'menu_icon' => get_bloginfo('template_url').'/images/event_16.png',
    'hierarchical' => false,
    'rewrite' => array( "slug" => "events" ),
    'supports'=> array('title', 'thumbnail', 'editor') ,
    'show_in_nav_menus' => true,
    'taxonomies' => array( 'tf_eventcategory', 'post_tag')
);

register_post_type( 'tf_events', $args);

}

// 2. Custom Taxonomy Registration (Event Types)

function create_eventcategory_taxonomy() {

    $labels = array(
        'name' => _x( 'Categorías', 'taxonomy general name' ),
        'singular_name' => _x( 'Categoría', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'popular_items' => __( 'Popular Categories' ),
        'all_items' => __( 'All Categories' ),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Category' ),
        'update_item' => __( 'Update Category' ),
        'add_new_item' => __( 'Add New Category' ),
        'new_item_name' => __( 'New Category Name' ),
        'separate_items_with_commas' => __( 'Separate categories with commas' ),
        'add_or_remove_items' => __( 'Add or remove categories' ),
        'choose_from_most_used' => __( 'Choose from the most used categories' ),
    );

    register_taxonomy('tf_eventcategory','tf_events', array(
        'label' => __('Event Category'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event-category' ),
    ));

}

add_action( 'init', 'create_eventcategory_taxonomy', 0 );

// 3. Show Columns
/*
add_filter ("manage_edit-tf_events_columns", "tf_events_edit_columns");
add_action ("manage_posts_custom_column", "tf_events_custom_columns");

function tf_events_edit_columns($columns) {

    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "tf_col_ev_cat" => "Category",
        "tf_col_ev_date" => "Dates",
        "tf_col_ev_times" => "Times",
        "tf_col_ev_thumb" => "Thumbnail",
        "title" => "Event",
        "tf_col_ev_desc" => "Description",
        );

    return $columns;

}

function tf_events_custom_columns($column) {

    global $post;
    $custom = get_post_custom();
    switch ($column)

        {
            case "tf_col_ev_cat":
                // - show taxonomy terms -
                $eventcats = get_the_terms($post->ID, "tf_eventcategory");
                $eventcats_html = array();
                if ($eventcats) {
                    foreach ($eventcats as $eventcat)
                    array_push($eventcats_html, $eventcat->name);
                    echo implode($eventcats_html, ", ");
                } else {
                _e('None', 'themeforce');;
                }
            break;
            case "tf_col_ev_date":
                // - show dates -
                $startd = $custom["tf_events_startdate"][0];
                $endd = $custom["tf_events_enddate"][0];
                $startdate = date("F j, Y", $startd);
                $enddate = date("F j, Y", $endd);
                echo $startdate . '<br /><em>' . $enddate . '</em>';
            break;
            case "tf_col_ev_times":
                // - show times -
                $startt = $custom["tf_events_startdate"][0];
                $endt = $custom["tf_events_enddate"][0];
                $time_format = get_option('time_format');
                $starttime = date($time_format, $startt);
                $endtime = date($time_format, $endt);
                echo $starttime . ' - ' .$endtime;
            break;
            case "tf_col_ev_thumb":
                // - show thumb -
                $post_image_id = get_post_thumbnail_id(get_the_ID());
                if ($post_image_id) {
                    $thumbnail = wp_get_attachment_image_src( $post_image_id, 'post-thumbnail', false);
                    if ($thumbnail) (string)$thumbnail = $thumbnail[0];
                    echo '<img src="';
                    echo bloginfo('template_url');
                    echo '/timthumb/timthumb.php?src=';
                    echo $thumbnail;
                    echo '&h=60&w=60&zc=1" alt="" />';
                }
            break;
            case "tf_col_ev_desc";
                the_excerpt();
            break;

        }
}
*/

// 4. Show Meta-Box

add_action( 'admin_init', 'tf_events_jumbo' );

function tf_events_jumbo() {
    add_meta_box('tf_events_jumbo', 'Advertencia!!!', 'tf_events_meta_jumbo', 'tf_events');
}
function tf_events_meta_jumbo(){
    ?>
    <div class="jumbotron">
        <p style="font-size: 20px;">Las im&aacute;genes destacadas de los eventos deben tener unas dimensiones de <strong>1920x450 px</strong> para que se muestren correctamente en el carrusel frontal.</p>
    </div>
<?php
}


add_action( 'admin_init', 'tf_events_create' );

function tf_events_create() {
    add_meta_box('tf_events_meta', 'Duración del Evento', 'tf_events_meta', 'tf_events');
}

function tf_events_meta () {

    // - grab data -

    global $post;
    $custom = get_post_custom($post->ID);
    $meta_sd = intval($custom["tf_events_startdate"][0]);
    $meta_ed = intval($custom["tf_events_enddate"][0]);
    $meta_st = intval($meta_sd);
    $meta_et = intval($meta_ed);

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

    echo '<input type="hidden" name="tf-events-nonce" id="tf-events-nonce" value="' .
    wp_create_nonce( 'tf-events-nonce' ) . '" />';

    // - output -

    ?>
    <div class="tf-meta">
        <ul>
            <li><label><?php echo __('Fecha de inicio').$_POST["tf_events_enddate"]; ?></label><input name="tf_events_startdate" class="tfdate" value="<?php echo $clean_sd; ?>" /></li>
            <li><label><?php echo __('Hora de inicio'); ?></label><input name="tf_events_starttime" value="<?php echo $clean_st; ?>" /><em>Usa el formato de 24h(7pm = 19:00)</em></li>
            <li><label><?php echo __('Fecha de finalización'); ?></label><input name="tf_events_enddate" class="tfdate" value="<?php echo $clean_ed; ?>" /></li>
            <li><label><?php echo __('Hora de finalización'); ?></label><input name="tf_events_endtime" value="<?php echo $clean_et; ?>" /><em>Usa el formato de 24h (7pm = 19:00)</em></li>
        </ul>
    </div>
    <br/>
    <h1 style="margin-top: 10px; margin-bottom: 10px; margin-left: 0px;">Traducci&oacute;n personalizada:</h1>
    <hr/>
    <label><?php echo __('Título Traducido'); ?>: &nbsp;</label>
    <input type="text" size="60" name="tf_events_trad_ti" id="tf_events_trad_ti" value="<?php echo get_post_meta($post->ID, 'tf_events_trad_ti', true); ?>"/>
    <br />
    <br />
    <?php
    $mi_traduccion_var = get_post_meta($post->ID, 'tf_events_meta_traduccion', true);
    wp_editor($mi_traduccion_var,"tf_events_traduccion", array('textarea_rows'=>12, 'editor_class'=>'mytext_class'));
}

// 5. Save Data

add_action ('save_post', 'save_tf_events');

function save_tf_events(){

    global $post;

    // - still require nonce

    if ( !wp_verify_nonce( $_POST['tf-events-nonce'], 'tf-events-nonce' )) {
        return $post->ID;
    }

    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    // - convert back to unix & update post

    if(!isset($_POST["tf_events_startdate"])):
        return $post;
        endif;
        $updatestartd = strtotime ( $_POST["tf_events_startdate"] . $_POST["tf_events_starttime"] );
        update_post_meta($post->ID, "tf_events_startdate", $updatestartd );

    if(!isset($_POST["tf_events_enddate"])):
        return $post;
        endif;
        $updateendd = strtotime ( $_POST["tf_events_enddate"] . $_POST["tf_events_endtime"]);
        update_post_meta($post->ID, "tf_events_enddate", $updateendd );

    //salvando las opciones de traduccion
    if(isset($_POST["tf_events_traduccion"])):
        update_post_meta($post->ID, "tf_events_meta_traduccion", $_POST["tf_events_traduccion"] );
        endif;
    if(isset($_POST["tf_events_trad_ti"])):
        update_post_meta($post->ID, "tf_events_trad_ti", $_POST["tf_events_trad_ti"] );
    endif;




}

// 6. Customize Update Messages

add_filter('post_updated_messages', 'events_updated_messages');

function events_updated_messages( $messages ) {

  global $post, $post_ID;

  $messages['tf_events'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Evento actualizado. <a href="%s">Ver item</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Event actualizado.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Event restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Event publicado. <a href="%s">Ver evento</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Event saved.'),
    8 => sprintf( __('Evento enviado. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Evento programado para: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Event draft updated. <a target="_blank" href="%s">Preview event</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

// 7. JS Datepicker UI

function events_styles() {
    global $post_type;
    if( 'tf_events' != $post_type )
        return;
    wp_enqueue_style('jquery-ui', get_bloginfo('template_url') . '/css/jquery-ui.css');
}

function events_scripts() {
    global $post_type;
    if( 'tf_events' != $post_type )
    return;
    wp_enqueue_script('jquery', get_bloginfo('template_url') . '/js/jquery.js', array('jquery'));
    wp_enqueue_script('jquery-ui', get_bloginfo('template_url') . '/js/jquery-ui.js', array('jquery'));
    wp_enqueue_script('custom_script', get_bloginfo('template_url').'/js/pubforce-admin.js', array('jquery'));
}

add_action( 'admin_print_styles-post.php', 'events_styles', 1000 );
add_action( 'admin_print_styles-post-new.php', 'events_styles', 1000 );

add_action( 'admin_print_scripts-post.php', 'events_scripts', 1000 );
add_action( 'admin_print_scripts-post-new.php', 'events_scripts', 1000 );

?>