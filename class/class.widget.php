<?php

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WBCP_TextWidget extends WP_Widget
{
    function __construct()
    {
        parent::__construct(
            'wpb_widget',
            __('Blog Clock', 'wpb_widget_domain'),
            ['description' => __('Blog clock widget', 'wpb_widget_domain'),]
        );
    }

    public function update($new_instance, $old_instance)
    {
        $instance = [];

        $instance['title']            = strip_tags($new_instance['title']);
        $instance['clockWidth']       = strip_tags($new_instance['clockWidth']);
        $instance['float']            = strip_tags($new_instance['float']);
        $instance['time_format']      = strip_tags($new_instance['time_format']);
        $instance['timezone']         = strip_tags($new_instance['timezone']);
        $instance['address']          = strip_tags($new_instance['address']);
        $instance['text-color']       = strip_tags($new_instance['text-color']);
        $instance['background-color'] = strip_tags($new_instance['background-color']);
        $instance['hide_title']       = strip_tags($new_instance['hide_title']);

        return $instance;
    }

    public function form($instance)
    {
        $title        = isset($instance['title']) ? $instance['title'] : 'My Time';
        $hide_title   = ! empty($instance['hide_title']) && $instance['hide_title'] == 'hide' ? 'checked' : '';
        $clockWidth   = ! empty($instance['clockWidth']) ? $instance['clockWidth'] : 100;
        $float        = ! empty($instance['float']) ? $instance['float'] : 'left';
        $time_format  = ! empty($instance['time_format']) ? $instance['time_format'] : '24';
        $timezone_txt = ! empty($instance['timezone']) ? 'Timezone ' . $instance['timezone'] . ' hours' : '';
        $timezone_val = ! empty($instance['timezone']) ? $instance['timezone'] : '';
        $address      = ! empty($instance['address']) ? $instance['address'] : '';
        $bg_color     = ! empty($instance['background-color']) ? $instance['background-color'] : '#eee';
        $txt_color    = ! empty($instance['text-color']) ? $instance['text-color'] : '#333';

        ?>
        <p>
            <?= __('Make other changes on the widget settings page located in the tools menu.'); ?>
        </p>
        <p>
            <?php
            $titleId   = $this->get_field_id('title');
            $titleName = $this->get_field_name('title');
            ?>
            <label for="<?= $titleId ?>">Title:</label>
            <input class="widefat" id="<?= $titleId ?>" name="<?= $titleName ?>" type="text" value="<?= $title; ?>"/>
        </p>
        <p>
            <?php
            $hideTitleId   = $this->get_field_id('hide_title');
            $hideTitleName = $this->get_field_name('hide_title');
            ?>
            <label for="<?= $hideTitleId ?>">Hide title</label>
            <input type="checkbox" class="checkbox" value="hide" id="<?= $hideTitleId ?>"
                   name="<?= $hideTitleName ?>" <?= $hide_title; ?>/>
        </p>
        <p>
            <?php
            $clockWidthId   = $this->get_field_id('clockWidth');
            $clockWidthName = $this->get_field_name('clockWidth');
            ?>
            <label for="<?= $clockWidthId ?>">Clock Width:</label>
            <select id="<?= $clockWidthId ?>" name="<?= $clockWidthName ?>">
                <option <?php selected($clockWidth, '100'); ?> value="100">100%</option>
                <option <?php selected($clockWidth, '90'); ?> value="90">90%</option>
                <option <?php selected($clockWidth, '80'); ?> value="80">80%</option>
                <option <?php selected($clockWidth, '70'); ?> value="70">70%</option>
                <option <?php selected($clockWidth, '60'); ?> value="60">60%</option>
                <option <?php selected($clockWidth, '50'); ?> value="50">50%</option>
                <option <?php selected($clockWidth, '40'); ?> value="40">40%</option>
                <option <?php selected($clockWidth, '30'); ?> value="30">30%</option>
                <option <?php selected($clockWidth, '20'); ?> value="20">20%</option>
            </select>
        </p>
        <p>
            <?php
            $floatId   = $this->get_field_id('float');
            $floatName = $this->get_field_name('float');
            ?>
            <label for="<?= $floatId ?>">Alignment:</label>
            <select id="<?= $floatId ?>" name="<?= $floatName ?>">
                <option <?php selected($float, 'left'); ?> value="left">Left</option>
                <option <?php selected($float, 'center'); ?> value="center">Center</option>
                <option <?php selected($float, 'right'); ?> value="right">Right</option>
            </select>
        </p>
        <p>
            <?php
            $timezoneId   = $this->get_field_id('timezone');
            $timezoneName = $this->get_field_name('timezone');
            ?>
            <label for="<?= $timezoneId ?>">Timezone:</label>
            <input class="widefat timezone-picker" id="<?= $timezoneId ?>" value="<?= $address; ?>" type="text"
                   placeholder="Enter a city"/>
            <input type="hidden" class="timezone-input" name="<?= $timezoneName ?>" value="<?= $timezone_val; ?>"/>
            <span class="timezone"><?= $timezone_txt; ?></span>
        </p>
        <p>
            <?php
            $timeFormatId   = $this->get_field_id('time_format');
            $timeFormatName = $this->get_field_name('time_format');
            ?>
            <label for="<?= $timeFormatId ?>">Format:</label>
            <select id="<?= $timeFormatId ?>" name="<?= $timeFormatName ?>">
                <option <?php selected($time_format, '12'); ?> value="12">12 hours</option>
                <option <?php selected($time_format, '24'); ?> value="24">24 hours</option>
            </select>
        </p>
        <p>
            <?php
            $backgroundColorId   = $this->get_field_id('background-color');
            $backgroundColorName = $this->get_field_name('background-color');
            ?>
        <div>
            <label for="<?= $backgroundColorId ?>"><?php esc_html_e('Background color:'); ?></label>
        </div>
        <input class="widefat color-picker" id="<?= $backgroundColorId ?>" name="<?= $backgroundColorName ?>"
               type="text" value="<?= $bg_color; ?>"/>
        </p>
        <p>
            <?php
            $textColorId   = $this->get_field_id('text-color');
            $textColorName = $this->get_field_name('text-color');
            ?>
        <div>
            <label for="<?= $textColorId ?>"><?php esc_html_e('Text color:'); ?></label>
        </div>
        <input class="widefat color-picker" id="<?= $textColorId ?>" name="<?= $textColorName ?>" type="text"
               value="<?= $txt_color; ?>"/>
        </p>


    <?php }

    public function widget($args, $instance)
    {
        $title       = ! empty($instance['title']) ? $instance['title'] : '';
        $hide_title  = ! empty($instance['hide_title']) ? $instance['hide_title'] : '';
        $clockWidth  = ! empty($instance['clockWidth']) ? $instance['clockWidth'] : 100;
        $float       = ! empty($instance['float']) ? $instance['float'] : 'left';
        $time_format = ! empty($instance['time_format']) ? $instance['time_format'] : '24';
        $timezone    = ! empty($instance['timezone']) ? $instance['timezone'] : '0';
        $bg_color    = ! empty($instance['background-color']) ? $instance['background-color'] : '#eee';
        $txt_color   = ! empty($instance['text-color']) ? $instance['text-color'] : '#333';

        $obj = WBCP_Clock::wbcp_get_clock();

        date_default_timezone_set("Europe/London");
        $hour      = ($time_format == '24') ?
            date('H', strtotime($timezone . 'hours')) :
            date('h', strtotime($timezone . 'hours'));
        $min       = date('i');
        $shortTime = ($time_format != '24') ? date('a') : '';

        $time           = "<span>$hour</span><span>:</span><span>$min</span><span class=\"blog-clock-zone\">$shortTime</span>";
        $containerStyle = "background-color: $bg_color; color: $txt_color;";
        $link           = "http://www.blogclock.co.uk";

        print $args['before_widget'];
        ?>
        <div style="width:<?= $clockWidth; ?>%" class="clock-<?= $float; ?>">
            <div class="blog-clock-container" style="<?= $containerStyle ?>">
                <?php if ($hide_title !== 'hide') : ?>
                    <h2 class="blog-clock-title" style="color: <?= $txt_color; ?>">
                        <a href="<?= $link ?>" target="_blank" style="color: <?= $txt_color ?>"><?= $title ?></a>
                    </h2>
                <?php endif; ?>

                <h1 class="blog-clock-time" data-format="<?= $obj->format; ?>" style="color: <?= $txt_color; ?>">
                    <?php if ($hide_title === 'hide'): ?>
                        <a href="<?= $link ?>" target="_blank" style="color: <?= $obj->color ?>"><?= $time ?></a>
                    <?php else: ?>
                        <?= $time ?>
                    <?php endif; ?>
                </h1>
            </div>
        </div>
        <div class="clear"></div>
        <?php
        print $args['after_widget'];
    }
}
