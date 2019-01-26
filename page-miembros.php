<?php /* Template Name: Miembros */ ?>

<?php get_header();?>

<div class="clearfix"></div>
<div id="super_contenedor" style="width: 100%;">
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

        <?php
        $departamentos = array('Control Automatico','Fisica Aplicada','Fisica Teorica','Matematica','Matematica Interdisciplinaria','Redes');
        ?>
        <div class="miembros">
        <?php for($i=0;$i<count($departamentos);$i++):?>
            <h3 class="dep_titulo text-center"><?php echo strtoupper($departamentos[$i]) ?></h3>

            <ul>
            <?php
            $usuarios = new WP_User_Query( array( 'meta_key' => 'user_departamento', 'meta_value' => ($i+1) ) );
            foreach ( $usuarios->results as $usuario ):
            ?>
                <li>
                    <a href="<?php echo get_author_posts_url($usuario->ID); ?>"><div><img class="img-circle" src="<?php
                    //echo get_wp_user_avatar_src($usuario->ID, 'thumbnail');
                    echo get_wp_user_avatar_src($usuario->ID, 96);?>"/></div>
                    <div><?php echo $usuario->first_name . ' ' . $usuario->last_name; ?></div></a>
                </li>
            <?php endforeach; ?>
            </ul>
            <div class="clearfix"></div>
            <hr>
        <?php endfor; ?>
        </div>

        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>

<?php get_footer(); ?>
</div>
