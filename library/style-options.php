<?php
function mitema_load_custom_styles() {
    // load the custom options
    global $mitema_opciones;
    foreach ($mitema_opciones as $value) {
    $$value['id'] = get_option($value['id'], $value['std']);
}
// output a style sheet with the options
?>
<style type="text/css">
/* <![CDATA[ */
/* Color Options */
/*

#footer{
background-color: <?php $mitema_color_footer; ?>;
}
#header{
background-color: <?php $mitema_color_header; ?>;
}
#menu-cabecera, #header #menu-cabecera li, #header #menu-cabecera li a {
    background-color: <?php $mitema_color_menu; ?>;
}
body{
background-color: <?php $mitema_color_body; ?>;
}
a, a:link, a:visited
/*color: <?php $mitema_color_link; ?>;*/
}
<?php $mitema_cod_css; ?>

*/
/* ]]> */
</style>
<?php
} // end function

//add_action('wp_head', 'mitema_load_custom_styles');
add_action('wp_print_styles', 'mitema_load_custom_styles');
