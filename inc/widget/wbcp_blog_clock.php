<?php

add_action( 'widgets_init', 'wbcp_blog_clock_widget' );


function wbcp_blog_clock_widget() {
    register_widget( 'wbcp_blog_clock_widget' );
}

class wbcp_blog_clock_widget extends WP_Widget {

    function __construct() {

        $widget_ops = array( 'classname' => 'wbcp_blog_clock_widget', 'description' => esc_html__('Display one of the blog clock created', WBCP_PLG_NAME) );

        WP_Widget::__construct( 'wbcp_blog_clock_widget', esc_html__('Blog Clock', WBCP_PLG_NAME), $widget_ops );

    }

    // Display Widget

    function widget( $args, $instance ) {

        extract( $args );

        //Our variables from the widget settings.
        $title = apply_filters('widget_title', empty($instance['title']) ? 'Blog Clock' : $instance['title'], $instance, $this->id_base);
        if ( !empty( $instance['blog_clock'] ) &&  !in_array('-1', $instance['blog_clock']) ) {

            $blog_clock = $instance['blog_clock'];
            echo  '<section class="widget section-sidebar mega-projects-widget">

                        <h3 class="widget-title">'.$title.'</h3>

                        <div class="widget-content">';

            echo do_shortcode('[wbcp_blog_clock id="'.$blog_clock[0].'"]');

            echo        '</div>
                </section>';
        }

        // Restore original Post Data
        wp_reset_postdata();
    }

    // Update the widget

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['blog_clock'] = $new_instance['blog_clock'];


        return $instance;

    }


    function form( $instance ) {

        $title = isset($instance['title']) ? esc_attr($instance['title']) :  esc_html__('Mega Projects', 'juno');
        $blog_clock = isset($instance['blog_clock']) ? $instance['blog_clock'] : array('-1');

        ?>


        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo 'Title:'; ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo $this->get_field_id( 'blog_clock' ); ?>"><?php _e('Select Blog Clock:', 'juno'); ?></label>

            <?php $clocks = get_posts( array('post_type' => 'wbcp-blog-clock') );?>

            <select id="<?php echo $this->get_field_id( 'blog_clock' ); ?>" name="<?php echo $this->get_field_name( 'blog_clock' ).'[]'; ?>" class="widefat">
                <option <?php if ( in_array('-1', $blog_clock) ){echo 'selected="selected"';} ?> value="-1"><?php _e('Select Blog Clock', 'juno');?></option>
                <?php foreach ($clocks as $clock) {  ?>
                    <option <?php if ( $blog_clock && in_array($clock->ID, $blog_clock) ){echo 'selected="selected"';} ?> value="<?php echo $clock->ID; ?>"><?php echo get_the_title($clock->ID); ?></option>
                <?php } ?>
            </select>
        </p>

    <?php
    }
}
