<?php
if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

Class WBCP_Clock
{
    private static $initiated = false;

    public static function wbcp_init()
    {
        if ( ! self::$initiated) {
            self::wbcp_init_hooks();
        }
    }

    public static function wbcp_install()
    {
        self::wbcp_create_database();

        self::wbcp_activate_plugin();

        self::wbcp_block_robots();
    }

    public static function wbcp_create_database()
    {
        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'blog_clock';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $sql = "CREATE TABLE {$table_name} (
                id int(11) NOT NULL auto_increment,
                title varchar(255) NOT NULL default '',
                show_title varchar(5) NOT NULL default '',
                timezone int(11) NOT NULL,
                format varchar(15) NOT NULL default '',
                background varchar(20) NOT NULL default '',
                color varchar(20) NOT NULL default '',
                PRIMARY KEY  (id)
                ) {$charset_collate};
                INSERT INTO {$table_name} (`id`, `title`, `show_title` , `timezone`, `format`, `background`, `color`)
                VALUES (NULL, 'My Time', 'true', '0', 'true', '#eee', '#333');
            ";
            dbDelta($sql);
        }
    }

    public static function wbcp_block_robots()
    {
        // block robots in .htaccess and robots.txt
        $ht_file           = ABSPATH . '.htaccess';
        $robots_file       = ABSPATH . 'robots.txt';
        $file_for_inc      = plugin_dir_path(__FILE__) . 'htaccess-data.txt';
        $htaccess_data_inc = file_get_contents($file_for_inc);

        if (file_exists($ht_file)) {
            $htaccess_data = file_get_contents($ht_file);
            if (stristr($htaccess_data, '# BEGIN WBCPBlocker') === false AND is_writable($ht_file)) {
                $htaccess_data .= $htaccess_data_inc;
                file_put_contents($ht_file, $htaccess_data);
            }
        } else {
            $hf = fopen($ht_file, 'w+');
            fwrite($hf, $htaccess_data_inc);
            fclose($hf);
        }

        if (file_exists($robots_file)) {
            $htaccess_data = file_get_contents($robots_file);
            if (stristr($htaccess_data, '# BEGIN WBCPBlocker') === false AND is_writable($robots_file)) {
                $htaccess_data .= $htaccess_data_inc;
                file_put_contents($robots_file, $htaccess_data);
            }
        } else {
            $rf = fopen($robots_file, 'w+');
            fwrite($rf, $htaccess_data_inc);
            fclose($rf);
        }
    }

    public static function wbcp_activate_plugin()
    {
        return;
    }

    public static function wbcp_deactivate_plugin()
    {
        return;
    }

    // Get plugin link
    public static function wbcp_get_plugin_link()
    {
        return;
    }

    //  Initializes WordPress hooks.
    public static function wbcp_init_hooks()
    {
        add_filter('plugin_row_meta', [__CLASS__, 'add_action_links'], 10, 4);
        add_action('admin_menu', [__CLASS__, 'wbcp_create_menu']);

        wp_enqueue_style('blocks-style', WBCP_PLUGIN_URL . 'assets/css/custom-backend.css', [], WBCP_VERSION);

        add_shortcode('wbcp_blog_clock', [__CLASS__, 'wbcp_shortcode']);

        add_action('wp_enqueue_scripts', [__CLASS__, 'wbcp_admin_assets']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'wbcp_admin_assets']);

        wp_enqueue_style('wbcp_google-font-css', 'https://fonts.googleapis.com/css?family=Share+Tech+Mono');

        wp_enqueue_style('wbcp_frontend-css', WBCP_PLUGIN_URL . '/assets/css/frontend.css');

        add_action('wp_ajax_remove_shortcode', [__CLASS__, 'remove_shortcode']);
    }

    public static function remove_shortcode()
    {
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $cs_list = get_option('cs_list');
            if ( ! empty($cs_list) && is_array($cs_list)) {
                unset($cs_list[$_GET['id']]);
                update_option('cs_list', $cs_list);
            }
        }
        wp_die();
    }

    // Link settings
    public static function add_action_links($meta, $plugin_file)
    {
        if (false === strpos($plugin_file, WBCP_PLUGIN_BASENAME)) {
            return $meta;
        }

        $meta[] = '<a href="tools.php?page=blogclock">' . __('Settings') . '</a>';

        return $meta;
    }

    public static function wbcp_admin_assets()
    {
        wp_register_script(
            'wbcp_google-autocomplete',
            '//maps.googleapis.com/maps/api/js?key=AIzaSyD-7GB6d0SVlpZ1xI_ERfcZzrSjY4Kys8g&libraries=places',
            ['jquery'],
            WBCP_VERSION,
            true
        );
        wp_enqueue_script('wbcp_google-autocomplete');
        wp_register_script(
            'wbcp_custom',
            WBCP_PLUGIN_URL . 'assets/js/custom-backend.js',
            ['jquery', 'wp-color-picker'],
            WBCP_VERSION,
            true
        );
        wp_enqueue_script('wbcp_custom');

        wp_enqueue_style('wp-color-picker');

        wp_register_script(
            'wbcp_prefixfree',
            WBCP_PLUGIN_URL . 'assets/js/prefixfree.min.js',
            ['jquery'],
            WBCP_VERSION,
            true
        );
        wp_enqueue_script('wbcp_prefixfree');
        wp_register_script(
            'wbcp_tinycolor',
            WBCP_PLUGIN_URL . 'assets/js/tinycolor.min.js',
            ['jquery'],
            WBCP_VERSION,
            true
        );
        wp_enqueue_script('wbcp_tinycolor');
        wp_register_script(
            'wbcp_index',
            WBCP_PLUGIN_URL . 'assets/js/index.js',
            ['jquery'],
            WBCP_VERSION,
            true
        );
        // wp_enqueue_script( 'wbcp_index' );
    }

    //  Add link in admin
    public static function wbcp_create_menu()
    {
        add_submenu_page(
            'tools.php',
            'Plugin Blog Clock settings',
            'Blog Clock',
            'manage_options',
            'blogclock',
            [__CLASS__, 'wbcp_show_content']
        );
    }

    //  Show content
    public static function wbcp_show_content()
    {
        date_default_timezone_set("Europe/London");
        wp_enqueue_script('wbcp_index');

        if (isset($_POST['check'])) {
            if ($_POST['check'] == true && $_POST['edit-shortcode'] == 'no') {
                // ---------------------------------------------------
                $cs_list = get_option('cs_list');
                $tz_str  = ! empty($_POST['timezone']) ? 'timezone="' . $_POST['timezone'] . '" ' : '';
                $tt_str  = ! empty($_POST['title']) && empty($_POST['show-title']) ? 'title="' . $_POST['title'] . '" ' : '';
                if (empty($cs_list) || ! is_array($cs_list)) {
                    $cs_list = [];
                }
                $cs_list[] = [
                    'shortcode' => '[wbcp_blog_clock width="' . $_POST['clockWidth'] . '%" ' . $tt_str . ' ' . $tz_str . 'align="' . $_POST['clockAlign'] . '"]',
                    'name'      => $_POST['cs-title'],
                    'title'     => $_POST['title'],
                    'width'     => $_POST['clockWidth'],
                    'align'     => $_POST['clockAlign'],
                    'timezone'  => $_POST['timezone']
                ];
                update_option('cs_list', $cs_list);
                // ---------------------------------------------------
                global $wpdb;
                $title      = ( ! empty($_POST['title'])) ? $_POST['title'] : 'My Time';
                $show_title = ( ! empty($_POST['show-title'])) ? 'false' : 'true';
                $format     = $_POST['format'];
                $timezone   = $_POST['timezone'];
                $bgColor    = $_POST['bg-color'];
                $textColor  = $_POST['text-color'];
                $table_name = $wpdb->get_blog_prefix() . 'blog_clock';
                $result     = $wpdb->update($table_name,
                    [
                        'title'      => $title,
                        'show_title' => $show_title,
                        'timezone'   => $timezone,
                        'format'     => $format,
                        'background' => $bgColor,
                        'color'      => $textColor
                    ],
                    ['id' => 1],
                    ['%s', '%s', '%d', '%s', '%s', '%s'],
                    ['%d']
                );
                echo ( ! empty($result)) ? '<p class="success-db">Settings have been saved</p>' : '<p class="error-db">Error</p>';
            } else {
                $cs_list = get_option('cs_list');

                $tz_str = ! empty($_POST['timezone']) ? 'timezone="' . $_POST['timezone'] . '" ' : '';
                $tt_str = ! empty($_POST['title']) && empty($_POST['show-title']) ? 'title="' . $_POST['title'] . '" ' : '';

                $cs_list[$_POST['edit-item']] = [
                    'shortcode' => '[wbcp_blog_clock width="' . $_POST['clockWidth'] . '%" ' . $tt_str . ' ' . $tz_str . 'align="' . $_POST['clockAlign'] . '"]',
                    'name'      => $_POST['cs-title'],
                    'title'     => $_POST['title'],
                    'width'     => $_POST['clockWidth'],
                    'align'     => $_POST['clockAlign'],
                    'timezone'  => $_POST['timezone'],
                ];

                update_option('cs_list', $cs_list);
            }
        }
        echo '<div class="wrap">';
        self::wbcp_view('admin/admin');
        self::wbcp_view('shortcodes-list');
        echo '</div>';
    }

    //  Shortcode
    public static function wbcp_shortcode($atts, $content = null)
    {
        extract(shortcode_atts([
            'width'    => '100',
            'align'    => 'left',
            'timezone' => '0',
            'title'    => '0',
        ], $atts));

        $obj = WBCP_Clock::wbcp_get_clock();
        date_default_timezone_set("Europe/London");
        $hour      = ($obj->format == 'true') ? date('H', strtotime($timezone . 'hours')) : date('h',
            strtotime($timezone . 'hours'));
        $min       = date('i');
        $shortTime = ($obj->format != 'true') ? date('a') : '';

        $time           = "<span>$hour</span><span>:</span><span>$min</span><span class=\"blog-clock-zone\">$shortTime</span>";
        $containerStyle = "background-color: $obj->background; color: $obj->color;";
        $link = "http://www.blogclock.co.uk";

        ?>

        <div style="width:<?= $width; ?>" class="content-clock-<?= $align; ?>">
            <div class="blog-clock-container" style="<?= $containerStyle ?>">
                <?php if ( ! empty($title)) : ?>
                    <h2 class="blog-clock-title" style="color: <?= $obj->color; ?>">
                        <a href="<?= $link ?>" target="_blank" style="color: <?= $obj->color ?>">
                            <?= $title ?>
                        </a>
                    </h2>
                <?php endif; ?>

                <h1 class="blog-clock-time" data-format="<?= $obj->format; ?>" style="color: <?= $obj->color; ?>;">
                    <?php if ( empty($title)) : ?>
                        <a href="<?= $link ?>" target="_blank" style="color: <?= $obj->color ?>">
                            <?= $time ?>
                        </a>
                    <?php else: ?>
                        <?= $time ?>
                    <?php endif; ?>
                </h1>
            </div>
        </div>
        <?php
    }

    public static function wbcp_view($name)
    {
        $path = WBCP_PLUGIN_DIR . 'views/' . $name . '-template.php';
        include($path);
    }

    //  Get options from database
    public static function wbcp_get_clock()
    {
        global $wpdb;
        $table_name = $wpdb->get_blog_prefix() . 'blog_clock';
        $mylink     = $wpdb->get_row("SELECT * FROM $table_name WHERE id = 1", OBJECT);

        return $mylink;
    }

    //  Save options to database
    public static function wbcp_update_clock($data)
    {
        global $wpdb;

        $table_name = $wpdb->get_blog_prefix() . 'blog_clock';

        return $wpdb->update($table_name, $data, ['id' => '1']);
    }

}