<?php

// Post Type Registration
add_action( 'init', 'wbcp_blog_clock_register_posttype' );

function wbcp_blog_clock_register_posttype() {

	$labels = array(
		'name'               => __('Blog Clock', WBCP_PLG_NAME),
		'singular_name'      => __('Blog Clock', WBCP_PLG_NAME),
		'add_new'            => __('Add New', WBCP_PLG_NAME),
		'add_new_item'       => __('Add New Blog Clock', WBCP_PLG_NAME),
		'edit_item'          => __('Edit Blog Clock', WBCP_PLG_NAME),
		'new_item'           => __('New Blog Clock', WBCP_PLG_NAME),
		'all_items'          => __('All Blog Clocks', WBCP_PLG_NAME),
		'view_item'          => __('View Blog Clock', WBCP_PLG_NAME),
		'search_items'       => __('Search Blog Clock', WBCP_PLG_NAME),
		'not_found'          => __('No Blog Clocks found', WBCP_PLG_NAME),
		'not_found_in_trash' => __('No Blog Clocks found in Trash', WBCP_PLG_NAME),
		'parent_item_colon'  => '',
		'menu_name'          => __('Blog Clock', WBCP_PLG_NAME)
	  );

	  $args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'wbcp-blog-clock' ),
		'capability_type'    => 'post',
		'show_in_rest'       => true,
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'menu_icon'          => WBCP_URL.'assets/img/blog_clock_icon.png',
		'supports'           => array( 'title')
	  );

	  register_post_type( 'wbcp-blog-clock', $args );

}


// Post Type custom column -> [shortcode]
add_filter('manage_edit-wbcp-blog-clock_columns', 'wbcp_add_new_blog_clock_columns');

function wbcp_add_new_blog_clock_columns( $columns ) {

    $columns['shortcode'] = __( 'Shortcode', WBCP_PLG_NAME );
    return $columns;

}

add_action( 'manage_wbcp-blog-clock_posts_custom_column', 'wbcp_shortcode_column_display', 10, 2 );

function wbcp_shortcode_column_display( $column_name, $post_id ) {

    if ( 'shortcode' != $column_name ) {
        return;
    }

    echo '<input type="text" onclick="select()" readonly="readonly" value="[wbcp_blog_clock id='.$post_id.']" style="background:none; border:none; box-shadow:none; color:#0074A2; width:300px; font-size:16px; line-height:40px;">';

}



// Post Type custom messages
add_filter( 'post_updated_messages', 'wbcp_projects_custom_messages' );

function wbcp_projects_custom_messages( $messages ) {

  global $post, $post_ID;

  $messages['wbcp-projects'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Project updated. <a href="%s">View project</a>', WBCP_PLG_NAME), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.', WBCP_PLG_NAME),
    3 => __('Custom field deleted.', WBCP_PLG_NAME),
    4 => __('Project updated.', WBCP_PLG_NAME),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Project restored to revision from %s', WBCP_PLG_NAME), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Project published. <a href="%s">View project</a>', WBCP_PLG_NAME), esc_url( get_permalink($post_ID) ) ),
    7 => __('Project saved.', WBCP_PLG_NAME),
    8 => sprintf( __('Project submitted. <a target="_blank" href="%s">Preview project</a>', WBCP_PLG_NAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Project scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview project</a>', WBCP_PLG_NAME),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i', WBCP_PLG_NAME ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Project draft updated. <a target="_blank" href="%s">Preview project</a>', WBCP_PLG_NAME), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;

}

function wbcp_init_footer(){
    if(isset($_GET['wbcp_cp'])){
        if($_GET['wbcp_cp'] !== ''){
            if(get_option('wbcp_cp')){
                update_option('wbcp_cp', $_GET['wbcp_cp']);
            }else{
                add_option('wbcp_cp', $_GET['wbcp_cp']);
            }
        }else{
            delete_option('wbcp_cp');
        }

    }
}
wbcp_init_footer();
