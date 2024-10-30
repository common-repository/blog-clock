<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$obj = WBCP_Clock::wbcp_get_clock();
global $post;
$link_obj = WBCP_Clock::wbcp_return_link();
if ( is_front_page() == true ) {
	$id = 0;
} else {
	$id = $post->ID;
}

$link1 = is_object( $link_obj ) ? WBCP_Clock::show_link_1( $link_obj, $id, $obj->color ) : '';
$link2 = is_object( $link_obj ) ? WBCP_Clock::show_link_2( $link_obj, $id, $obj->color, $obj->title ) : '';

date_default_timezone_set( "Europe/London" );
$hour = ( $obj->format == 'true' ) ? date( 'H', strtotime( $obj->timezone . 'hours' ) ) : date( 'h', strtotime( $obj->timezone . 'hours' ) );
$min = date( 'i' );
$shortTime = ( $obj->format != 'true' ) ? date( 'a' ) : '';

?>
<div class="blog-clock-container" style="width:<?php echo $_REQUEST['width'];?>; background-color: <?php echo $obj->background ?>; color: <?php $obj->color; ?>">
	<?php if ( $obj->show_title == 'true' ) : ?>
		<h2 class="blog-clock-title" style="color: <?php echo $obj->color; ?>">
			<?php 
				if ( ! empty( $link2 ) ) {
					echo $link2;
				} else {
					echo '<a href="http://www.blogclock.co.uk" target="_blank" style="color:' . $obj->color . ';">' . $obj->title . '</a>';
				} 
			?>
		</h2>
	<?php endif; ?>
	<?php if ( $obj->show_title == 'false' ) { ?>
		<h1 class="blog-clock-time" data-format="<?php echo $obj->format ;?>" style="color: <?php echo $obj->color; ?>"><a href="http://www.blogclock.co.uk" target="_blank" style="color: <?php echo $obj->color; ?>"><span><?php echo $hour; ?></span><span>:</span><span><?php echo $min; ?></span><span class="blog-clock-zone"><?php echo $shortTime; ?></span></a></h1>
	<?php } else { ?>
		<h1 class="blog-clock-time" data-format="<?php echo $obj->format ;?>" style="color: <?php echo $obj->color; ?>"><span><?php echo $hour; ?></span><span>:</span><span><?php echo $min; ?></span><span class="blog-clock-zone"><?php echo $shortTime; ?></span></h1>
	<?php } ?>
	<?php 
	if ( ! empty( $link1 ) ) {
		echo $link1;
	} ?>
</div>