<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 22/12/15
 * Time: 11:22
 */
/**
 * Eventos_R Class
 */
class Eventos_R extends WP_Widget {
    /** constructor */
    function Eventos_R() {
        parent::WP_Widget(false, $name = 'Eventos Relacionados');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $num_eventos = apply_filters('widget_num_eventos', $instance['num_eventos']);
        ?>
        <?php echo $before_widget; ?>
        <?php if ( $title )
            echo $before_title . $title . $after_title;

        $orig_post = $post;
        global $post;
        $tags = wp_get_post_tags($post->ID);
        if ($tags) {
            $tag_ids = array();
            foreach($tags as $individual_tag)
            {
                $tag_ids[] = $individual_tag->term_id;
            }

            $args = array(
                'tag__in' => $tag_ids,
                'post_type' => 'tf_events',
                'posts_per_page' => $num_eventos,
                'post__not_in' => array($post->ID),
                'caller_get_posts'=>1,
                'orderby'=>'rand' // Randomize the posts
            );
            $my_query = new wp_query( $args );
            if( $my_query->have_posts() ):
                while( $my_query->have_posts() ):
                    $my_query->the_post();
                    the_post_thumbnail(array(70,70));
                    ?>
                    <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                <?php endwhile;
            endif;
        }
        $post = $orig_post;
        wp_reset_query();

        //$my_query = new WP_Query('category_name=noticias&posts_per_page='.$num_noticias);
        //echo var_dump($my_query); ?>

        <?php //while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <?php //the_post_thumbnail(array(70,70)); ?>
        <a href="<?php //the_permalink(); ?>" rel="bookmark"><?php ///the_title(); ?></a>

        <?php //endwhile; ?>
        <?php echo $after_widget; ?>
    <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num_eventos'] = strip_tags($new_instance['num_eventos']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $num_eventos = esc_attr($instance['num_eventos']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label><br/><br/>
            <label for="<?php echo $this->get_field_id('num_eventos'); ?>"><?php _e('Cantidad de eventos a mostrar:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('num_eventos'); ?>" name="<?php echo $this->get_field_name('num_eventos'); ?>" type="number" value="<?php echo $num_eventos; ?>" />

            </label>
        </p>
    <?php
    }

} // clase Eventos_R

// registrar el widget Eventos_R
add_action('widgets_init', create_function('', 'return register_widget("Eventos_R");'));
