<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 21/12/15
 * Time: 13:43
 */
/**
 * Noticias_R Class
 */
class Noticias_R extends WP_Widget {
    /** constructor */
    function Noticias_R() {
        parent::WP_Widget(false, $name = 'Noticias Relacionadas');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $num_noticias = apply_filters('widget_num_noticias', $instance['num_noticias']);
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
                'post__not_in' => array($post->ID),
                'caller_get_posts'=>1,
                'posts_per_page' => $num_noticias,
                'category_name'=>'noticias',
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
        ?>
        <?php echo $after_widget; ?>
    <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num_noticias'] = strip_tags($new_instance['num_noticias']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
        $title = esc_attr($instance['title']);
        $num_noticias = esc_attr($instance['num_noticias']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label><br/><br/>
            <label for="<?php echo $this->get_field_id('num_noticias'); ?>"><?php _e('Cantidad de noticias a mostrar:'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('num_noticias'); ?>" name="<?php echo $this->get_field_name('num_noticias'); ?>" type="number" value="<?php echo $num_noticias; ?>" />

            </label>
        </p>
    <?php
    }

} // clase Noticias_R

// registrar el widget Noticias_R
add_action('widgets_init', create_function('', 'return register_widget("Noticias_R");'));
