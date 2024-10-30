<?php

$html .= '
    <div class="wbcp wbcp-layout-2"
            data-timezone="'.$wbcp_atts['timezone'].'"
            data-format="'.$wbcp_atts['format_time'].'"
            data-width="'.$wbcp_atts['size'].'"
            data-display-tz="'.$wbcp_atts['display_timezone'].'"
            data-display-date="'.$wbcp_atts['display_date'].'"
            data-format-date="'.$wbcp_atts['format_date'].'"
            data-custom-date="'.$wbcp_atts['custom_date'].'"
            data-locale="'.get_locale().'"
            data-id="'.$id.'"
            data-font_face="'.$wbcp_atts['font_face'].'"
            data-font_color="'.$wbcp_atts['font_color'].'"
            data-background_color="'.$wbcp_atts['background_color'].'"
            data-seconds_color="'.$wbcp_atts['seconds_color'].'"
            data-minutes_hand="'.$wbcp_atts['minutes_hand'].'"
            data-hours_hand="'.$wbcp_atts['hours_hand'].'"
            data-crown="'.$wbcp_atts['crown'].'"
            data-display_numbers="'.$wbcp_atts['display_numbers'].'"
            data-display_crown="'.$wbcp_atts['display_crown'].'"
            data-sqared_lines="'.$wbcp_atts['sqared_lines'].'"
            data-display_shadows="'.$wbcp_atts['display_shadows'].'"
            >
        <div id="wbcp-clock-'.$id.'"></div>
    </div><div class="clear"></div>';
