<link rel="stylesheet" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/css/r_sidebar.css" />
<?php  wp_reset_query();$class = ''; if(is_home()): $class = 'r_sidebar_pie';  endif;?>
<div id="r_sidebar" class="<?php echo $class;?>">
    <ul>
        <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

            <li>
                <h3>Posts recientes</h3>
                <ul>
                    <?php get_archives('postbypost', 5); ?>
                </ul>
            </li>

        <?php endif; ?>
    </ul>

</div>
<div class="clearfix"></div>