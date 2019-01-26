<?php /* Template Name: Organizacion */ ?>

<?php get_header(); ?>
<style>
    .divider{
        width: 2px;
        height: 60px;
        background-color: #68A4BC;
        margin: auto;
    }
</style>
<div class="clearfix"></div>
<div id="super_contenedor" style="width: 100%;">
<div id="wrapper" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-left: 0px; padding-right: 0px;">
    <div style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/images/autor_fondo.jpg'); height: 60px; margin-top: 20px;"></div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    <div id="container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
        <div id="second-container" class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
            <div class="clearfix"></div>

            <?php
            $args = array(
                'meta_key'     => 'user_cargo',
                'meta_value'   => 1,
            );
            $director = get_users($args);
            foreach ($director as $user) { ?>
            <div class="row" style="margin-top: 10%;">
                <div class="col-xs-4 col-lg-4">
                    <h3 class="titulo_general text-center">Director</h3>
                </div>
                <div class="col-xs-4 col-lg-4">
                    <div>
                    <img style="margin: 0 auto;" class="img-circle img-responsive center-block" width="96" height="96" src="<?php echo get_wp_user_avatar_src($user->ID, 50); ?>"/>
                        </div>
                </div>
                <div class="col-xs-4 col-lg-4">
                    <div style="margin-top: 10%;">
                    <span><?php echo $user->first_name . ' ' . $user->last_name; ?></span><br><a id="mail_usuario" href="mailto:<?php echo  esc_html($user->user_email); ?>"><?php echo esc_html($user->user_email); ?></a>
                        </div>
                </div>

            </div>
                <?php
            }
                ?>
            <div class="divider">

            </div>

            <?php

            $args = array(
                'meta_key'     => 'user_cargo',
                'meta_value'   => 2,
            );
            $subdirector = get_users($args);
            foreach ($subdirector as $user) { ?>

            <div class="row">
                <div class="col-xs-4 col-lg-4">
                    <h3 class="titulo_general text-center">Subdirector</h3>
                </div>
                <div class="col-xs-4 col-lg-4">
                    <div>
                    <img style="margin: 0 auto;" class="img-circle img-responsive center-block" width="96" height="96" src="<?php echo get_wp_user_avatar_src($user->ID, 50); ?>"/>
                        </div>
                </div>
                <div class="col-xs-4 col-lg-4">
                    <div style="margin-top: 10%;">
                    <span><?php echo $user->first_name . ' ' . $user->last_name; ?></span><br/><a id="mail_usuario" href="mailto:<?php echo  esc_html($user->user_email); ?>"><?php echo esc_html($user->user_email); ?></a>
                        </div>
        </div>

    </div>
            <?php
            }
?>
            <div class="divider">

            </div>
            <h3 class="titulo_general text-center" style="border-top: 2px solid #68A4BC; padding-top: 30px;margin-top: 0px;">Consejo Cient&iacute;fico</h3>
            <ul>
            <?php

            $args = array(
                'meta_key'     => 'user_consejo_dir',
                'meta_value'   => 1,
            );
            $consejo_dir = get_users($args);
            foreach ($consejo_dir as $user) {
                echo '<li style="float: left;margin-right: 15px;width:130px;margin-top:20px;">';
                echo '<div class="text-center"><img class="img-circle" width="96" height="96" src="'.get_wp_user_avatar_src($user->ID, 50).'"/>';
                echo '<br/><br/><span>'. $user->first_name . ' ' . $user->last_name.'</span><br/><a id="mail_usuario" href="mailto:' . esc_html($user->user_email) . '">' . esc_html($user->user_email) . '</a></div>';
                echo '</li>';
            }

            ?>
</ul>
        </div>
        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
    </div>
    <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></div>
</div>

<?php get_footer(); ?>
</div>

