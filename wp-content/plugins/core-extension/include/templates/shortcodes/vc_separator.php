<?php
$output = '';
	extract(shortcode_atts(array(
		'style'     => 'simple',
		'color'     => '#ededed',
		'width'     => '100%',
		'thickness' => '1px',
		'size'      => 'small',
		'align'     => 'left',
		'css_animation'         => '',
		'css_animation_delay'   => ''
	), $atts));

$css_class = $this->getCSSAnimation($css_animation);
($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';



if($style == 'simple'){
	$output .= '<div class="separator_wrapper clearfix' .$css_class.'">
					<div class="separator_line align-'.$align.'" style="background-color:'.$color.'; width:' .$width. '; height:' .$thickness.'"></div>
				</div>';

} elseif ($style == 'line-to-top') {
	$output .= '<div class="separator_wrapper'. ' ' .$css_class.'">
					<div class="separator_container">
						<div class="sep_line_cont"><div class="sep_line" style="background-color:'.$color.'; height:' .$thickness.'"></div></div>
						<a href="#top" style="color:'.$color.'; border-color:'.$color.'">Back to top<i class="fa fa-chevron-up"></i></a>
					</div>
				</div>';

} elseif ($style == 'tilt') {
	$output .= '<div class="separator_wrapper_tilt'. ' ' .$css_class.'">
					<div class="separator_tilt ' .$size. '">
						<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
						    <path fill="'.$color.'" d="M5 0 L53 0 L48 55 L0 55"></path>
						    <path fill="'.$color.'" d="M53 45 L100 45 L95 100 L48 100"></path>
						</svg>
					</div>
				</div>';
}


'<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
    <path d="M5 0 L54 0 L49 10 L0 10"></path>
    <path d="M56 5 L100 5 L95 15 L51 15"></path>
</svg>';

echo $output;