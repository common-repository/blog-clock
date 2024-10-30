<?php

require_once __DIR__ . '/class/class.clock.php';

if ( ! defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

WBCP_Clock::wbcp_deactivate_plugin();

$table_name = $wpdb->get_blog_prefix() . 'blog_clock';
$sql        = "DROP TABLE IF EXISTS $table_name;";
$wpdb->query($sql);
