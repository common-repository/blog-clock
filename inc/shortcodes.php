<?php
function wbcp_blog_clock_short( $atts, $content = null ) {

    // CSS Libs
    wp_enqueue_script('wbcp-moment');
    wp_enqueue_script('wbcp-moment-tz');
    wp_enqueue_script('wbcp-clock');
    wp_enqueue_script('wbcp-mainscript');

    wp_enqueue_style( 'wbcp-style' );
    wp_enqueue_style( 'wbcp-analog-1' );


    // WP jQuery
    wp_enqueue_script("jquery");

	// Extract Attributes
	extract( shortcode_atts( array('id' => ''), $atts ));

	// Check Layout
	if ( !$id || 'publish' != get_post_status ( $id ) ) {
    	return __('We are sorry but the Layout you selected does not exixt or isn\'t publish yet', WBCP_PLG_NAME);
	}

	// Layout Options
	$meta = vp_metabox('wbcp_basic_meta', '', $id);

    $wbcp_atts = [
        'id'                 => $id,
        'title'              => get_the_title($id),

        'layout'             => isset($meta->meta['wbcp_layout']) &&
                               !empty($meta->meta['wbcp_layout']) ?
                                      $meta->meta['wbcp_layout']  : '1',

        'alignment'          => isset($meta->meta['wbcp_align']) &&
                                !empty($meta->meta['wbcp_align']) ?
                                $meta->meta['wbcp_align']  : 'center',

        'size'               => isset($meta->meta['wbcp_width']) &&
                                !empty($meta->meta['wbcp_width']) ?
                                $meta->meta['wbcp_width']  : '',

        'timezone'           => isset($meta->meta['wbcp_timezone']) &&
                               !empty($meta->meta['wbcp_timezone']) ?
                                      $meta->meta['wbcp_timezone']  : '',

        'format_time'        => isset($meta->meta['wbcp_format_time']) &&
                               !empty($meta->meta['wbcp_format_time']) ?
                                      $meta->meta['wbcp_format_time']  : '',

        'display_timezone'   => isset($meta->meta['wbcp_display_timezone']) &&
                               !empty($meta->meta['wbcp_display_timezone']) ?
                                      $meta->meta['wbcp_display_timezone']  : '',

        'display_date'       => isset($meta->meta['wbcp_display_date']) &&
                               !empty($meta->meta['wbcp_display_date']) ?
                                      $meta->meta['wbcp_display_date']  : '',

        'format_date'        => isset($meta->meta['wbcp_format_date']) &&
                               !empty($meta->meta['wbcp_format_date']) ?
                                      $meta->meta['wbcp_format_date']  : '',

        'custom_date'        => isset($meta->meta['wbcp_custom_date']) &&
                               !empty($meta->meta['wbcp_custom_date']) ?
                                      $meta->meta['wbcp_custom_date']  : '',

        'font_face'          => isset($meta->meta['wbcp_font_face']) &&
                               !empty($meta->meta['wbcp_font_face']) ?
                                $meta->meta['wbcp_font_face']  : '',
        'font_style'         => isset($meta->meta['wbcp_font_style']) &&
                               !empty($meta->meta['wbcp_font_style']) ?
                                $meta->meta['wbcp_font_style']  : '',
        'font_weight'        => isset($meta->meta['wbcp_font_weight']) &&
                               !empty($meta->meta['wbcp_font_weight']) ?
                                $meta->meta['wbcp_font_weight']  : '',

        'primary_color'       => isset($meta->meta['wbcp_primary_color']) &&
                               !empty($meta->meta['wbcp_primary_color']) ?
                                $meta->meta['wbcp_primary_color']  : '',

        'secondary_color'     => isset($meta->meta['wbcp_secondary_color']) &&
                               !empty($meta->meta['wbcp_secondary_color']) ?
                                $meta->meta['wbcp_secondary_color']  : '',

        'font_color'          => isset($meta->meta['wbcp_font_color']) &&
                               !empty($meta->meta['wbcp_font_color']) ?
                                $meta->meta['wbcp_font_color']  : '',

        'background_color'    => isset($meta->meta['wbcp_background_color']) &&
                               !empty($meta->meta['wbcp_background_color']) ?
                                $meta->meta['wbcp_background_color']  : '',

        'seconds_color'       => isset($meta->meta['wbcp_seconds_color']) &&
                                !empty($meta->meta['wbcp_seconds_color']) ?
                                $meta->meta['wbcp_seconds_color']  : '',

        'minutes_hand'        => isset($meta->meta['wbcp_minutes_hand']) &&
                                !empty($meta->meta['wbcp_minutes_hand']) ?
                                $meta->meta['wbcp_minutes_hand']  : '',

        'hours_hand'          => isset($meta->meta['wbcp_hours_hand']) &&
                                !empty($meta->meta['wbcp_hours_hand']) ?
                                $meta->meta['wbcp_hours_hand']  : '',

        'crown'               => isset($meta->meta['wbcp_crown']) &&
                                !empty($meta->meta['wbcp_crown']) ?
                                $meta->meta['wbcp_crown']  : '',

        'display_numbers'     => isset($meta->meta['wbcp_display_numbers']) &&
                                !empty($meta->meta['wbcp_display_numbers']) ?
                                $meta->meta['wbcp_display_numbers']  : '',

        'display_crown'       => isset($meta->meta['wbcp_display_crown']) &&
                                !empty($meta->meta['wbcp_display_crown']) ?
                                $meta->meta['wbcp_display_crown']  : '',

        'sqared_lines'        => isset($meta->meta['wbcp_sqared_lines']) &&
                                !empty($meta->meta['wbcp_sqared_lines']) ?
                                $meta->meta['wbcp_sqared_lines']  : '',

        'display_shadows'     => isset($meta->meta['wbcp_display_shadows']) &&
                                !empty($meta->meta['wbcp_display_shadows']) ?
                                $meta->meta['wbcp_display_shadows']  : '',


        'custom_css'          => isset($meta->meta['wbcp_custom_css']) &&
                               !empty($meta->meta['wbcp_custom_css']) ?
                                $meta->meta['wbcp_custom_css']  : '',
    ];

    VP_Site_GoogleWebFont::instance()->add($wbcp_atts['font_face'], $wbcp_atts['font_weight'], $wbcp_atts['font_style']);
    VP_Site_GoogleWebFont::instance()->register_and_enqueue();

    $size  = $wbcp_atts['size'] ? $wbcp_atts['size'] . 'px' : '';
    $alignment = $wbcp_atts['alignment'] == 'center' ? 'margin: 0 auto;' : 'float: '.$wbcp_atts['alignment'].';';

    $custom_css = "
                .wbcp-layout-2 #wbcp-clock-{$id}{
                    {$alignment}
                    width: {$size}
                }

                #wbcp-clock-{$id}.wbcp-digital-1 {
                    text-align: {$wbcp_atts['alignment']};
                    width: {$size};
                    background-color: {$wbcp_atts['background_color']};
                    padding: 20px;
                    font-size: 20px;
                    color: {$wbcp_atts['font_color']};
                    border: 4px solid {$wbcp_atts['primary_color']};
                    border-radius: 10px;
                    font-family: '{$wbcp_atts['font_face']}'
                }

                #wbcp-clock-{$id}.wbcp-digital-1 hr{
                    color: {$wbcp_atts['secondary_color']}
                }

                #wbcp-clock-{$id}.wbcp-digital-1 .time{
                    font-size: 140%
                }

                #wbcp-clock-{$id}.wbcp-digital-1 .date{
                    font-size: 100%
                }

                #wbcp-clock-{$id}.wbcp-digital-1 .tz{
                    font-size: 70%
                }

                #wbcp-clock-{$id} a{
                    color: {$wbcp_atts['font_color']};
                }";

    wp_add_inline_style( 'wbcp-style', $custom_css );
    wp_add_inline_style( 'wbcp-style', $wbcp_atts['custom_css'] );

    $html = '';
    require(WBCP_DIR.'inc/views/wbcp-blog-clock-'.$wbcp_atts['layout'].'.php');

	// Return HTML
	return $html;
}

add_shortcode( 'wbcp_blog_clock', 'wbcp_blog_clock_short' );
