<?php
/*
Plugin Name: Blog Clock
Plugin URI: http://www.blogclock.co.uk
Description: Blog Clock Plugin
Author URI: http://www.blogclock.co.uk
Tested up to:5.5
License: http://www.gnu.org/licenses/gpl-2.0.html
Author: Blog Clock Team
Version: 2.8
*/

// Basic plugin definitions
define ('WBCP_PLG_NAME', 'wbcp_blog_clock');
define( 'WBCP_PLG_VERSION', '2.4' );
define( 'WBCP_URL', WP_PLUGIN_URL . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));
define( 'WBCP_DIR', WP_PLUGIN_DIR . '/' . str_replace( basename(__FILE__), '', plugin_basename(__FILE__) ));


// Plugin INIT
require_once(WBCP_DIR.'inc/install.php');
