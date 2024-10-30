<?php
//***********************//
// VISUAL COMPOSER SETUP //
//***********************//

// After VC Init
add_action( 'vc_after_init', 'wbcp_vc_after_init_actions' );

function wbcp_vc_after_init_actions() {


    //**********************//
    // Include new Elements //
    //**********************//

    require_once( WBCP_DIR.'vc/wbcp-block-clock.php' );

}

//***********************//
// LAYOUT DWORPDOWN DATA //
//***********************//

// Layouts Data
function wbcp_vc_converters_dropdown_data() {

    $data = array();

    $blog_clocks = get_posts(
        array(
            'post_type' => 'wbcp-blog-clock',
        )
    );

    if ( is_array( $blog_clocks ) && ! empty( $blog_clocks ) ) {

        foreach ( $blog_clocks as $c ) {
            $data[$c->post_title] = $c->ID;
        }

    }

    return $data;

}