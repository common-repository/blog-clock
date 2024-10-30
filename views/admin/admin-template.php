<?php

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$obj         = WBCP_Clock::wbcp_get_clock();
$checked     = ($obj->show_title != 'true') ? 'checked' : 'fasle';
$firstRadio  = ($obj->format == 'true') ? 'checked' : 'false';
$secondRadio = ($obj->format == 'false') ? 'checked' : 'false';
$cs_timezone = 'timezone="' . $obj->timezone . '"';
$cs_title    = $checked != 'checked' ? 'title="' . $obj->title . '" ' : '';
?>

    <form class="clock-container" method="POST">
        <input type="hidden" name="check" value="true">
        <input type="hidden" name="timezone" id="timezone" value="<?= $obj->timezone; ?>">
        <input type="hidden" name="bg-color" id="bg-color" value="<?= $obj->background; ?>">
        <input type="hidden" name="edit-shortcode" id="edit-shortcode" value="no">
        <input type="hidden" name="edit-item" id="edit-item" value="">
        <input type="hidden" name="text-color" id="text-color" value="<?= $obj->color; ?>">
        <div class="title-cont">
            <h2>Blog Clock</h2>
        </div>
        <div>
            <label for="title">Widget title - frontend</label>
            <input type="text" name="title" value="<?= $obj->title ?>"
                   placeholder="Title">
            <input type="checkbox" name="show-title" <?= $checked; ?>>
            <span>Hidden</span>
        </div>
        <div>
            <input type="text" id="wscp_google_autocomplete" placeholder="Enter a city">
            <h4>Timezone <span id="tmz"><?= $obj->timezone; ?></span> hours</h4>
        </div>
        <div>
            <input type="radio" name="format" value="true" <?= $firstRadio; ?>>
            <span>24</span>
            <input type="radio" name="format" value="false" <?= $secondRadio; ?>>
            <span>12</span>
        </div>
        <div>
            <div class="bg-color" id="back">
                <div class="color" id="back-title" style="background-color: <?= $obj->background; ?>"></div>
                <div class="title">Background color</div>
            </div>
        </div>
        <div>
            <div class="bg-color" id="text">
                <div class="color" id="text-title" style="background-color: <?= $obj->color; ?>"></div>
                <div class="title">Text color</div>
            </div>
        </div>
        <div>
            <label for="title"><strong>Generate Shortcode:</strong></label>
            <label for="clockWidth">Clock Width:</label>
            <select id="clockWidth" name="clockWidth">
                <option value="100">100%</option>
                <option value="90">90%</option>
                <option value="80">80%</option>
                <option value="70">70%</option>
                <option value="60">60%</option>
                <option value="50">50%</option>
                <option value="40">40%</option>
                <option value="30">30%</option>
                <option value="20">20%</option>
            </select>
            <label for="clockAlign">Alignment:</label>
            <select id="clockAlign" name="clockAlign">
                <option value="center">Center</option>
                <option value="left">Left</option>
                <option value="right">Right</option>
            </select>
            <div id="shorrtcode_generated" data-timezone="<?= $obj->timezone; ?>">[wbcp_blog_clock
                width="100%" <?= $cs_title; ?><?= $cs_timezone; ?> align="center"]
            </div>
        </div>
        <div>
            <label for="title">Backend title</label>
            <input type="text" name="cs-title" value="">
        </div>

        <div class="displays">
            <h2>The different ways to display the blog clock: </h2>
            <ol>
                <li>Use the shortcode generator to get your custom shortcode.</li>
                <li>Go to the widget page and drag the blog clock widget to any widget area.</li>
            </ol>
        </div>
        <div class="submit-container">
            <input type="submit" value="save">
        </div>
    </form>
<?php WBCP_Clock::wbcp_view('tinycolor'); ?>