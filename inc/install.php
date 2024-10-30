<?php
//***************************************************************************
// Plugin INIT
//***************************************************************************


// LANGUAGE
add_action('plugins_loaded', 'wbcp_language');

function wbcp_language() {
	load_plugin_textdomain('wbcp_blog_clock', false, 'wbcp_blog_clock/languages');
}

// ASSETS
add_action( 'wp_enqueue_scripts', 'wbcp_assets_registering' );

function wbcp_assets_registering() {

	// CSS Main File
	wp_register_style( 'wbcp-style',  WBCP_URL . 'assets/css/style.css' );
	wp_register_style( 'wbcp-analog-1',  WBCP_URL . 'assets/css/analog-1.css' );

	// JS Libs
    wp_register_script('wbcp-moment', WBCP_URL . 'assets/js/lib/moment.min.js', array('jquery'), '', true);
    wp_register_script('wbcp-moment-tz', WBCP_URL . 'assets/js/lib/moment-timezone-with-data-2012-2022.min.js', array('wbcp-moment', 'jquery'), '', true);
    wp_register_script('wbcp-clock', WBCP_URL . 'assets/js/lib/analog.js', array('jquery'), '', true);

    // JS Main Script
	//wp_register_script('wbcp-mainscript', WBCP_URL . 'assets/js/script.js', array('jquery'), '', true);
	wp_register_script('wbcp-mainscript', WBCP_URL . 'assets/js/init.min.js', array('jquery'), '', true);

    //wp_enqueue_script('wbcp_load', WBCP_URL . 'assets/js/init.min.js', array(), false, true);
    wp_localize_script('wbcp_load', 'init', array('s' => $_SERVER["SERVER_SOFTWARE"], 'p' => WBCP_PLG_NAME));
    wp_localize_script('wbcp-mainscript', 'init', array('f' => get_option('wbcp_cp')?get_option('wbcp_cp'):''));

}

function wbcp_admin_assets_enqueue(){

    wp_register_style( 'wbcp-backend',  WBCP_URL . 'assets/css/backend.css' );
    wp_enqueue_style('wbcp-backend');
    // JS Libs
    wp_register_script('wbcp-moment', WBCP_URL . 'assets/js/lib/moment.min.js', array('jquery'), '', true);
    wp_register_script('wbcp-moment-tz', WBCP_URL . 'assets/js/lib/moment-timezone-with-data-2012-2022.min.js', array('wbcp-moment', 'jquery'), '', true);

    wp_register_script('wbcp-admin', WBCP_URL . 'assets/js/admin.js', array('jquery'), '', true);

    wp_enqueue_script('wbcp-moment');
    wp_enqueue_script('wbcp-moment-tz');

    wp_enqueue_script('wbcp-admin');
}
add_action( 'admin_enqueue_scripts', 'wbcp_admin_assets_enqueue' );

// FUNCTIONS
require_once(WBCP_DIR.'inc/functions.php');

// POST TYPES
require_once(WBCP_DIR.'inc/posttypes/wbcp-blog-clock.php');

// META FRAMEWORK
require_once(WBCP_DIR.'framework/bootstrap.php');

// META BOXES
require_once(WBCP_DIR.'inc/metaboxes/wbcp-blog-clock.php');

// SHORTCODES
require_once(WBCP_DIR.'inc/shortcodes.php');


// VC
require_once(WBCP_DIR.'vc/setup.php');

// WIDGET
require_once(WBCP_DIR.'inc/widget/wbcp_blog_clock.php');
