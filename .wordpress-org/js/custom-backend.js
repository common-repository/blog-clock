jQuery(document).ready(function ($) {


$( "#clockWidth" ).change(function() {
	width=$("#clockWidth").val();
	align=$("#clockAlign").val();
	$( "#shorrtcode_generated" ).html('[wbcp_blog_clock width="'+width+'%" align="'+align+'"]')
	

	
});

$( "#clockAlign" ).change(function() {
	width=$("#clockWidth").val();
	align=$("#clockAlign").val();
	$( "#shorrtcode_generated" ).html('[wbcp_blog_clock width="'+width+'%" align="'+align+'"]')
	

	
});


    //  Google auto complite


    function google_autocomplete_init() {


        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('wscp_google_autocomplete'), { types: [ 'geocode' ] });


        google.maps.event.addListener(autocomplete, 'place_changed', function () {


            // get data and save in new_point


            var place = autocomplete.getPlace();


            new_point = {


                point: place.name,


                lat: place.geometry.location.lat(),


                lng: place.geometry.location.lng()


            };





            jQuery.ajax({


                url:"https://maps.googleapis.com/maps/api/timezone/json?location="+ new_point.lat +","+ new_point.lng +"&timestamp="+(Math.round((new Date().getTime())/1000)).toString()+"&sensor=false",


            }).done(function(response){


                if(response.timeZoneId != null){


                    var hour = (response.rawOffset)/60/60;


                    jQuery('#tmz').text(hour);


                    jQuery('#timezone').val(hour);


                }


            });


        });


    }





    google.maps.event.addDomListener(window, 'load', google_autocomplete_init);





    var sec, min, hou,


        clock = jQuery(jQuery('.blog-clock-time')[0]),


        writeClock = jQuery('.blog-clock-time'),


        timeFormat = writeClock.attr('data-format');





    //  Clock


    (function () {


            sec = 30;


            min = parseInt(clock.find('span:eq(2)').text(), 10);


            hou = parseInt(clock.find('span:eq(0)').text(), 10);





        if (clock.length > 0) timer();


    })();





    //  Timer


    function timer () {


        sec++;





        var format = (timeFormat == 'true') ? 24: 12;





        if (sec >= 60) { min++; sec = 0; }


        if (min >= 60) { hou++; min = 0; }


        if (hou >= format) { hou = 0}




        //var showSec = (sec < 10) ? '0' + sec: sec;


        var showMin = (min < 10) ? '0' + min: min;


        var showHou = (hou < 10) ? '0' + hou: hou;





        writeClock.find('span:eq(2)').text(showMin);


        writeClock.find('span:eq(0)').text(showHou);





        setTimeout(timer, 1000);


    };






});