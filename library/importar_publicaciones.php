<?php
add_action( 'admin_footer', 'importar_pub_javascript' ); // Write our JS below here

function importar_pub_javascript() { ?>
    <script type="text/javascript" >
        jQuery(document).ready(function($) {
            var sql = " * FROM bal_reporte INNER JOIN bal_reporte_autores";
            sql += " ON bal_reporte.id = bal_reporte_autores.reporte_id";
            sql += " INNER JOIN worker ON worker.id = bal_reporte_autores.autor_id";
            sql += " ORDER BY bal_reporte.id";

            var data = {
                'action': 'importar_pub',
                'sql' : sql
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.getJSON('http://intranet.icimaf.cu/ws_custom.php', data, function(response) {
                alert('Got this from the server: ' + response);
            });
        });
    </script> <?php
}

add_action('wp_ajax_nopriv_importar_pub', 'importar_pub_callback');
add_action( 'wp_ajax_importar_pub', 'importar_pub_callback' );

function importar_pub_callback() {
    global $wpdb; // this is how you get access to the database
    $wpdb->insert( 'wp_test', array(
        'test' => 'test'
    ) );
    $wpdb->print_error();
    $wpdb->show_error();
    /*

    //$whatever = intval( $_POST['whatever'] );
    $args = array('orderby' => 'display_name');
    $wp_user_query = new WP_User_Query($args);
    $authors = $wp_user_query->get_results();
    if (!empty($authors)) {
        foreach ($authors as $author) {
            $author_info = get_userdata($author->ID);
            $email_usuario = $author_info->user_email;
            echo 'whatever';
            update_usermeta( $author->ID, 'whatever', 'whatever' );
        }
    }
*/

    wp_die(); // this is required to terminate immediately and return a proper response
}