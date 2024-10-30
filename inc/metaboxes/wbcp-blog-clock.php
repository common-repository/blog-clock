<?php
// FUNCTIONS

VP_Security::instance()->whitelist_function('wbcp_is_analog');

function wbcp_is_analog($value)
{
    if($value === '2')
        return true;
    return false;
}

VP_Security::instance()->whitelist_function('wbcp_is_digital');

function wbcp_is_digital($value)
{
    if($value === '1')
        return true;
    return false;
}

VP_Security::instance()->whitelist_function('wbcp_display_date');

function wbcp_display_date($value)
{
    if($value === '1')
        return true;
    return false;
}

VP_Security::instance()->whitelist_function('wbcp_get_timezone_list');

function wbcp_get_timezone_list()
{
    $tz_list = file_get_contents(WBCP_URL . 'assets/tz.php');
    $tz_list = json_decode($tz_list);
    $new_list = [];
    foreach($tz_list as $key => $value){
        $new_list[]= array(
            'value' => $key,
            'label' => $value
        );
    }
    return $new_list;
}

VP_Security::instance()->whitelist_function('wbcp_sep');

function wbcp_sep()
{

    return '<hr><h2 style="text-align: center">STYLING OPTIONS</h2><hr>';
}


// TEMPLATES

// Project Basic Setup
$wbcp_blog_clock =
array(
	'id'          => 'wbcp_basic_meta',
	'types'       => array('wbcp-blog-clock'),
	'title'       => __('Blog Clock Settings', WBCP_PLG_NAME),
	'priority'    => 'high',
	'template'    => array(

		// Type
		array(
			'type' => 'radioimage',
			'name' => 'wbcp_layout',
			'label' => __('Block Clock Layout', WBCP_PLG_NAME),
			'description' => __('Choose a layout type for your Block Clock', WBCP_PLG_NAME),
			'item_max_height' => '70',
			'item_max_width' => '70',
            'default' => array(
                        '1',
                    ),
			'items' => array(
				array(
					'value' => '1',
					'label' => __('Layout 1', WBCP_PLG_NAME),
					'img' => WBCP_URL.'assets/img/type_1.jpg',
				),
				array(
					'value' => '2',
					'label' => __('Layout 2', WBCP_PLG_NAME),
					'img' => WBCP_URL.'assets/img/type_2.jpg',
				),
			),

		),

        array(
            'type' => 'select',
            'name' => 'wbcp_align',
            'label' => __('Select Clock Alignment', WBCP_PLG_NAME),
            'items' => array(
                array(
                    'value' => 'center',
                    'label' => 'Center'
                ),
                array(
                    'value' => 'right',
                    'label' => 'Right'
                ),
                array(
                    'value' => 'left',
                    'label' => 'Left'
                ),
            ),
        ),

        array(
            'type' => 'textbox',
            'name' => 'wbcp_width',
            'label' => __('Select Clock Width', WBCP_PLG_NAME),
            'description' => __('Select a width in pixels (only numbers). Leave blank to fit to container', WBCP_PLG_NAME),
            'validation' => 'numeric'
        ),

        // Set Timezone
        array(
            'type' => 'select',
            'name' => 'wbcp_timezone',
            'label' => __('Select the clock timezone', WBCP_PLG_NAME),
            'items' => array(
                'data' => array(
                    array(
                        'source' => 'function',
                        'value' => 'wbcp_get_timezone_list',
                    ),
                ),
            ),
        ),

        // Set Time Format
        array(
            'type' => 'select',
            'name' => 'wbcp_format_time',
            'label' => __('Select the time format', WBCP_PLG_NAME),
            'items' => array(
                array(
                    'value' => 'LT',
                    'label' => 'Local time (based on client local settings)'
                ),
                array(
                    'value' => 'LTS',
                    'label' => 'Local time with seconds (based on client local settings)'
                ),
                array(
                    'value' => 'hh:mm:ss:SS a',
                    'label' => '12h hh:mm:ss:ms am/pm'
                ),
                array(
                    'value' => 'hh:mm:ss a',
                    'label' => '12h hh:mm:ss am/pm'
                ),
                array(
                    'value' => 'hh:mm a',
                    'label' => '12h hh:mm am/pm'
                ),
                array(
                    'value' => 'HH:mm:ss:SS',
                    'label' => '24h hh:mm:ss:ms'
                ),
                array(
                    'value' => 'HH:mm:ss',
                    'label' => '24h hh:mm:ss'
                ),
                array(
                    'value' => 'HH:mm',
                    'label' => '24h hh:mm'
                ),
                array(
                    'value' => 'X',
                    'label' => 'Timestamp (Seconds since 01.01.1970)'
                ),
                array(
                    'value' => 'x',
                    'label' => 'Timestamp (Milliseconds since 01.01.1970)'
                ),
            ),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_digital',
            ),
        ),

        // Display Timezone Name
        array(
            'type' => 'toggle',
            'name' => 'wbcp_display_timezone',
            'label' => __('Display Timezone', WBCP_PLG_NAME),
            'description' => __('Show/Hide timezone name', WBCP_PLG_NAME),
            'default' => '0',
        ),

        // Display Date
        array(
            'type' => 'toggle',
            'name' => 'wbcp_display_date',
            'label' => __('Display Date', WBCP_PLG_NAME),
            'description' => __('Show/Hide the Date', WBCP_PLG_NAME),
            'default' => '0',
        ),

        // Set Date Format
        array(
            'type' => 'select',
            'name' => 'wbcp_format_date',
            'label' => __('Select the date format', WBCP_PLG_NAME),
            'items' => array(
                array(
                    'value' => 'L',
                    'label' => 'Local date (based on client local settings) - 09/04/1986'
                ),
                array(
                    'value' => 'LL',
                    'label' => 'Local date with month name (based on client local settings) September 4, 1986'
                ),
                array(
                    'value' => 'MM/DD/YY',
                    'label' => 'MM/DD/YY'
                ),
                array(
                    'value' => 'DD/MM/YY',
                    'label' => 'DD/MM/YY'
                ),
                array(
                    'value' => 'MM/DD/YYYY',
                    'label' => 'MM/DD/YYYY'
                ),
                array(
                    'value' => 'DD/MM/YYYY',
                    'label' => 'DD/MM/YYYY'
                ),
                array(
                    'value' => 'ddd MM/DD/YY',
                    'label' => 'Mon..Sun DD/MM/YY'
                ),
                array(
                    'value' => 'dddd DD/MM',
                    'label' => 'Monday..Sunday DD/MM'
                ),
                array(
                    'value' => 'dddd DD MMMM',
                    'label' => 'Monday..Sunday DD January'
                ),
                array(
                    'value' => 'dddd MMMM, Do',
                    'label' => 'Monday..Sunday January, 1st'
                ),
            ),
            'dependency' => array(
                'field' => 'wbcp_display_date',
                'function' => 'wbcp_display_date',
            ),
        ),

        //Custom Date Format
        array(
            'type' => 'textbox',
            'name' => 'wbcp_custom_date',
            'description' => __('You can override the date format and write your custom role here. For reference check <a href="https://momentjs.com/docs/#/displaying/" target="_blank">here</a>', WBCP_PLG_NAME),
            'label' => __('Custom Date Format', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_display_date',
                'function' => 'wbcp_display_date',
            ),
        ),

        // STYLING
        array(
            'type' => 'html',
            'name' => 'sep',
            'binding' => array(
                'function' => 'wbcp_sep',
                'field' => 'wbcp_primary_color'
            ),
        ),

        array(
            'type' => 'color',
            'name' => 'wbcp_primary_color',
            'label' => __('Primary Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_digital',
            ),
        ),
        array(
            'type' => 'color',
            'name' => 'wbcp_secondary_color',
            'label' => __('Secondary Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_digital',
            ),
        ),

        array(
            'type' => 'color',
            'name' => 'wbcp_background_color',
            'label' => __('Box Background Color, leave empty for default', WBCP_PLG_NAME),
        ),

        array(
            'type' => 'color',
            'name' => 'wbcp_seconds_color',
            'label' => __('Seconds Hand Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_analog',
            ),
        ),
        array(
            'type' => 'color',
            'name' => 'wbcp_minutes_hand',
            'label' => __('Minutes Hand Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_analog',
            ),
        ),
        array(
            'type' => 'color',
            'name' => 'wbcp_hours_hand',
            'label' => __('Hours Hand Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_analog',
            ),
        ),
        array(
            'type' => 'color',
            'name' => 'wbcp_crown',
            'label' => __('Crown Color, leave empty for default', WBCP_PLG_NAME),
            'dependency' => array(
                'field' => 'wbcp_layout',
                'function' => 'wbcp_is_analog',
            ),
        ),

        array(
            'type' => 'toggle',
            'name' => 'wbcp_display_numbers',
            'label' => __('Display Numbers', WBCP_PLG_NAME),
            'description' => __('Show/Hide the Numbers', WBCP_PLG_NAME),
            'default' => '1',
        ),

        array(
            'type' => 'toggle',
            'name' => 'wbcp_display_crown',
            'label' => __('Display Crown', WBCP_PLG_NAME),
            'description' => __('Show/Hide the Crown', WBCP_PLG_NAME),
            'default' => '0',
        ),

        array(
            'type' => 'toggle',
            'name' => 'wbcp_sqared_lines',
            'label' => __('Display Squared Lines for crown and hands', WBCP_PLG_NAME),
            'description' => __('Squared/Rounded Lines (default rounded)', WBCP_PLG_NAME),
            'default' => '0',
        ),
        array(
            'type' => 'toggle',
            'name' => 'wbcp_display_shadows',
            'label' => __('Display Shadows effects', WBCP_PLG_NAME),
            'description' => __('Show/Hide shadows effects in the clock', WBCP_PLG_NAME),
            'default' => '0',
        ),


        array(
            'type' => 'color',
            'name' => 'wbcp_font_color',
            'label' => __('Font Color, leave empty for default', WBCP_PLG_NAME),
        ),

        array(
            'type' => 'select',
            'name' => 'wbcp_font_face',
            'label' => __('Font Family', WBCP_PLG_NAME),
            'description' => __('Select Font', WBCP_PLG_NAME),
            'items' => array(
                'data' => array(
                    array(
                        'source' => 'function',
                        'value' => 'vp_get_gwf_family',
                    ),
                ),
            ),
        ),

        array(
            'type' => 'radiobutton',
            'name' => 'wbcp_font_style',
            'label' => __('Font Style', WBCP_PLG_NAME),
            'description' => __('Select Font Style', WBCP_PLG_NAME),
            'items' => array(
                'data' => array(
                    array(
                        'source' => 'binding',
                        'field' => 'wbcp_font_face',
                        'value' => 'vp_get_gwf_style',
                    ),
                ),
            ),
            'default' => array(
                '{{first}}',
            ),
        ),
        array(
            'type' => 'radiobutton',
            'name' => 'wbcp_font_weight',
            'label' => __('Font Weight', WBCP_PLG_NAME),
            'description' => __('Select Font Weight', WBCP_PLG_NAME),
            'items' => array(
                'data' => array(
                    array(
                        'source' => 'binding',
                        'field' => 'wbcp_font_face',
                        'value' => 'vp_get_gwf_weight',
                    ),
                ),
            ),
        ),

        array(
            'type' => 'codeeditor',
            'name' => 'wbcp_custom_css',
            'label' => __('Custom CSS', WBCP_PLG_NAME),
            'description' => __('Write your custom css here.', WBCP_PLG_NAME),
            'theme' => 'github',
            'mode' => 'css',
        ),

    ),
);

new VP_Metabox($wbcp_blog_clock);
