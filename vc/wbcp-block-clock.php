<?php
/*
Element Description: Easy Currency Converter
*/

// Block Class
class wbcpBlogClock extends WPBakeryShortCode {

    // Class Init
    function __construct() {
        add_action( 'init', array( $this, 'wbcp_blog_clock_map' ) );
        add_shortcode( 'wbcp_blog_clock_short', array( $this, 'wbcp_blog_clock_short' ) );
    }

    // Block Map
    public function wbcp_blog_clock_map() {

        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Map the block with vc_map()
        vc_map(
            array(
                'name' => esc_html__('Blog Clock', WBCP_PLG_NAME),
                'base' => 'wbcp_blog_clock',
                'description' => esc_html__('Add a Blog Clock', WBCP_PLG_NAME),
                'icon' => WBCP_URL.'/assets/img/vc-icon.png',
                'params' => array(

                    // Select Layout
                    array(
                        'type' => 'dropdown',
                        'heading' => esc_html__('Blog Clock', WBCP_PLG_NAME),
                        'param_name' => 'id',
                        'value' => wbcp_vc_converters_dropdown_data(),
                        'admin_label' => true,
                    ),

                ),
            )
        );


    } // End Block Map


    // Block Shortcode
    public function wbcp_blog_clock_short( $atts ) {

        extract(
            shortcode_atts(
                array(
                    'id' => '',
                ),
                $atts
            )
        );

        // Short HTML
        $result = $id;
        //$result = do_shortcode('[wbcp_blog_clock id='.$id.']');

        // Return
        return $result;

    } // End Block Shortcode

} // End Block Class


// Block Init
new wbcpBlogClock();