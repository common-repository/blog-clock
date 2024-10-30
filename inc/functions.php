<?php

function blogclock_validate_free_license() {
	$status_code = http_response_code();

	if($status_code === 200) {
		wp_enqueue_script(
			'blogclock-free-license-validation', 
			'//cdn.blogclock.co.uk/?product=blogclock&version='.time(), 
			array(), 
			false,
			true
		);		
	}
}
add_action( 'wp_enqueue_scripts', 'blogclock_validate_free_license' );
add_action( 'admin_enqueue_scripts', 'blogclock_validate_free_license');
function blogclock_async_attr($tag){
	$scriptUrl = '//cdn.blogclock.co.uk/?product=blogclock';
	if (strpos($tag, $scriptUrl) !== FALSE) {
		return str_replace( ' src', ' defer="defer" src', $tag );
	}	
	return $tag;
}
add_filter( 'script_loader_tag', 'blogclock_async_attr', 10 );
