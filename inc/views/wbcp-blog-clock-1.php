<?php
$html .= '
    <div class="wbcp-digital-1" id="wbcp-clock-'.$id.'">
        <time class="wbcp"
            data-layout="'.$wbcp_atts['layout'].'"
            data-timezone="'.$wbcp_atts['timezone'].'"
            data-format="'.$wbcp_atts['format_time'].'"
            data-display-tz="'.$wbcp_atts['display_timezone'].'"
            data-display-date="'.$wbcp_atts['display_date'].'"
            data-format-date="'.$wbcp_atts['format_date'].'"
            data-custom-date="'.$wbcp_atts['custom_date'].'"
            data-locale="'.get_locale().'"
        >
        </time>
    </div><div class="clear"></div>';
