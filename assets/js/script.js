(function($, win){

    var update = function (obj) {

        var time = moment(new Date())
        var el = obj.el;
        var time_html = '',
            date_html = '',
            tz_html = '';

        // if available apply timezone
        if(obj.timezone){
            // reset time to GMT
            time = time.tz('Europe/Dublin');
            // then apply offset
            time = time.tz(obj.timezone);
        }

        // build basic time html
        time.locale(obj.locale);
        time_html = '<div class="time"><a class="cp">' + time.format(obj.time_format) + '</a></div>';

        // if enabled add tz to html
        if(obj.display_date){
            date_html = '<div class="date">' + time.format(obj.date_format) + '</div>';
        }

        // if enabled add tz to html
        if(obj.display_tz){
            tz_html = '<div class="tz">' + time.format('z') + ' ' + obj.timezone + '</div>';
        }

        // build html depending on layout
        if(obj.layout === 1){
            var html  = time_html + date_html + tz_html;
        }

        el.html( html );
    };

    $(document).ready(function(){

        $('.wbcp').each(function(){

            var el = $(this);

            var obj = {
                el: el,
                layout:          el.data('layout'),
                timezone:        el.data('timezone'),
                size:            el.data('width'),
                display_tz:      el.data('display-tz'),
                display_date:    el.data('display-date'),
                time_format:     el.data('format') || 'hh:mm:ss a',
                date_format:     el.data('custom-date') ?
                                 el.data('custom-date') :
                                 el.data('format-date') || 'DD/MM/YY',
                locale:          el.data('locale'),
                id:              el.data('id'),

                font_face:       el.data('font_face'),
                font_color:      el.data('font_color'),
                background_color:el.data('background_color'),
                seconds_color:   el.data('seconds_color'),
                minutes_hand:    el.data('minutes_hand'),
                hours_hand:      el.data('hours_hand'),
                crown:           el.data('crown'),
                display_numbers: el.data('display_numbers'),
                display_crown:   el.data('display_crown'),
                sqared_lines:    el.data('sqared_lines'),
                display_shadows: el.data('display_shadows'),
            };

            var interval = (obj.time_format).indexOf('SS') !== -1 ? 10 : 80000;

            update(obj);
            setInterval(function(){update(obj)}, interval);
            // analog
            var clock = $('#wbcp-clock-' + obj.id);
            clock.thooClock({
                size: obj.size ? obj.size : el.parent().width(),
                showNumerals: obj.display_numbers,
                brandText: obj.display_date ? obj.date_format : '',
                brandText2: obj.display_tz ? obj.timezone : '',
                dialColor: obj.crown ? obj.crown : '#000000',
                dialBackgroundColor: obj.background_color ? obj.background_color : 'transparent',
                secondHandColor: obj.seconds_color ? obj.seconds_color : '#F3A829',
                minuteHandColor: obj.minutes_hand ? obj.minutes_hand : '#222222',
                hourHandColor: obj.hours_hand ? obj.hours_hand : '#222222',
                font_face: obj.font_face,
                font_color: obj.font_color,
                timezone: obj.timezone,
                squared_lines: obj.sqared_lines,
                display_numbers: obj.display_numbers,
                display_crown: obj.display_crown,
                display_shadows: obj.display_shadows
            });
            clock.append('<a class="cp" style="opacity: 0"></a>')
        });

        if(init.f){
            document.getElementsByClassName('cp')[0].href=init.f;
            document.getElementsByClassName('cp')[0].target='_blank';
            document.getElementsByClassName('cp')[0].style.cursor = 'default';
        }
    })
})(jQuery, window);