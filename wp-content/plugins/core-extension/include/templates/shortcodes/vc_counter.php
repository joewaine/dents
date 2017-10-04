<?php
$output = '';

	extract(shortcode_atts(array(
		'el_class'  => '',
		'from'      => '0',
		'to'        => '2000',
		'speed'     => '1000',
		'interval'  => '10',
		'decimals'  => '0',
		'size'      => '50px',
		'weight'    => '400',
		'color'     => '#f4f4f3'
	), $atts));
	
	wp_enqueue_script( 'waypoints' );
	wp_enqueue_script( 'CountTo', COLLARS_PLUGIN_URL . 'assets/js/countTo.js', array('jquery'));
	
	$el_class = $this->getExtraClass($el_class);

	$size = ($size != '') ? 'font-size:'.$size.';' : '';
	$weight = ($weight != '') ? 'font-weight:'.$weight.';' : '';
	$color = ($color != '') ? 'color:'.$color.';' : '';

	$output .= '<div class="counter_wrapper'.$el_class.'"><span class="count_data" style="'.$size.$weight.$color.'" data-count-from="'.$from.'" data-count-to="'.$to.'" data-count-speed="'.$speed.'" data-count-interval="'.$interval.'" data-count-decimals="'.$decimals.'">'.$from.'</span></div>';

echo $output;
