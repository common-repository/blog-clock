jQuery(document).ready(function ($) {
    $("#clockWidth").change(function () {
        var width = $("#clockWidth").val(),
            align = $("#clockAlign").val(),
            title = !$('input[name="show-title"]').prop('checked') ? 'title="' + $('input[name="title"]').val() + '" ' : '';

        $("#shorrtcode_generated").html('[wbcp_blog_clock width="' + width + '%" ' + title + 'timezone="' + $("#shorrtcode_generated").attr('data-timezone') + '" align="' + align + '"]')
    });
    $("#clockAlign").change(function () {
        var width = $("#clockWidth").val(),
            align = $("#clockAlign").val(),
            title = !$('input[name="show-title"]').prop('checked') ? 'title="' + $('input[name="title"]').val() + '" ' : '';

        $("#shorrtcode_generated").html('[wbcp_blog_clock width="' + width + '%" ' + title + 'timezone="' + $("#shorrtcode_generated").attr('data-timezone') + '" align="' + align + '"]')
    });

    $('input[name="title"]').on('keyup', function () {
        var width = $("#clockWidth").val(),
            align = $("#clockAlign").val(),
            title = !$('input[name="show-title"]').prop('checked') ? 'title="' + $('input[name="title"]').val() + '" ' : '';

        $("#shorrtcode_generated").html('[wbcp_blog_clock width="' + width + '%" ' + title + 'timezone="' + $("#shorrtcode_generated").attr('data-timezone') + '" align="' + align + '"]')
    });

    //  Google auto complite
    function google_autocomplete_init() {
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('wscp_google_autocomplete'), {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            // get data and save in new_point
            var place = autocomplete.getPlace();
            new_point = {
                point: place.name,
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };

            jQuery.ajax({
                url: "https://maps.googleapis.com/maps/api/timezone/json?location=" + new_point.lat + "," + new_point.lng + "&timestamp=" + (Math.round((new Date().getTime()) / 1000)).toString() + "&sensor=false",
            }).done(function (response) {
                if (response.timeZoneId != null) {
                    var hour = (response.rawOffset) / 60 / 60;
                    jQuery('#tmz').text(hour);
                    jQuery('#timezone').val(hour);

                    $("#shorrtcode_generated").attr('data-timezone', hour);
                    $("#shorrtcode_generated").html('[wbcp_blog_clock width="' + $("#clockWidth").val() + '%" timezone="' + hour + '" align="' + $("#clockAlign").val() + '"]')
                }
            });
        });
    }

    if ($('#wscp_google_autocomplete').length) {
        google.maps.event.addDomListener(window, 'load', google_autocomplete_init);
    }


    $('.cs-list .remove-item').on('click', function () {
        var $btn = $(this);

        $.get(ajaxurl + '?action=remove_shortcode&id=' + $btn.attr('data-id'), function (respond) {
            $btn.closest('tr').remove();
        });
    });

    function timer(sec, min, hou, writeClock) {
        sec++;

        var format = (writeClock.attr('data-format') == 'true') ? 24 : 12;

        if (sec >= 60) {
            min++;
            sec = 0;
        }
        if (min >= 60) {
            hou++;
            min = 0;
        }
        if (hou >= format) {
            hou = 0
        }

        //var showSec = (sec < 10) ? '0' + sec: sec;
        var showMin = (min < 10) ? '0' + min : min;
        var showHou = (hou < 10) ? '0' + hou : hou;

        writeClock.find('span:eq(2)').text(showMin);
        writeClock.find('span:eq(0)').text(showHou);

        setTimeout(function () {
            timer(sec, min, hou, writeClock);
        }, 1000);
    }

    $('.blog-clock-time').each(function () {
        var writeClock = $(this),
            sec = 30,
            min = parseInt(writeClock.find('span:eq(2)').text(), 10),
            hou = parseInt(writeClock.find('span:eq(0)').text(), 10);

        timer(sec, min, hou, writeClock);
    });

    // Widget timezone field

    function onFormUpdate(event, widget) {
        var $el = widget.find('.timezone-picker');
        google_widget_init($el[0], $el);

        initColorPicker(widget);
    }

    $(document).on('widget-added widget-updated', onFormUpdate);

    $(window).load(function () {
        $('.timezone-picker').each(function () {
            google_widget_init(this, $(this));
        });
    });

    function google_widget_init(widget_field, $el) {
        var autocomplete = new google.maps.places.Autocomplete(widget_field, {types: ['geocode']});
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            // get data and save in new_point
            var place = autocomplete.getPlace();
            var new_point = {
                point: place.name,
                lat: place.geometry.location.lat(),
                lng: place.geometry.location.lng()
            };

            $.ajax({
                url: "https://maps.googleapis.com/maps/api/timezone/json?location=" + new_point.lat + "," + new_point.lng + "&timestamp=" + (Math.round((new Date().getTime()) / 1000)).toString() + "&sensor=false",
            }).done(function (response) {
                if (response.timeZoneId != null) {
                    var hour = (response.rawOffset) / 60 / 60;
                    $el.closest('p').find('.timezone-input').val(hour);
                    $el.closest('p').find('.timezone').text('Timezone ' + hour + ' hours');
                }
            });
        });
    }


    function initColorPicker(widget) {
        widget.find('.color-picker').wpColorPicker({
            change: _.throttle(function () { // For Customizer
                $(this).trigger('change');
            }, 3000)
        });
    }

    $(document).ready(function () {
        $('#widgets-right .widget:has(.color-picker)').each(function () {
            initColorPicker($(this));
        });
    });

    // Edit shortcode
    $('.edit-item').on('click', function () {
        var $btn = $(this),
            data = JSON.parse($btn.closest('tr').attr('data-options'));

        // console.log($btn.closest('tr').attr('data-options'));
        $('.success-db').remove();

        $('#edit-item').val($btn.attr('data-id'));
        $('#edit-shortcode').val('yes');
        $('#clockWidth').val(data.width);
        $('#clockAlign').val(data.align);
        if (data.title.length) {
            $('input[name="show-title"]').prop('checked', false);
        }
        $('input[name="title"]').val(data.title);
        $('input[type="submit"]').val('update');

        $('#shorrtcode_generated').text($btn.closest('tr').find('.cs-code').text());
        $('input[name="cs-title"]').val(data.name);

        $('body,html').animate({
            scrollTop: 0
        }, 300);
    });
});