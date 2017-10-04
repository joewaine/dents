<?php
$id = $heading =
$width = $height_type = $height = $overlay = $overlay_color = $effect =
$output = $el_class = $cont_array = $cont_styles = $css_class
= '';


extract(shortcode_atts(array(
	'id'            => '',
	'heading'       => '',
	'width'         => '600px',
	'height_type'   => '',
	'height'        => '500px',
	'overlay'       => '',
	'overlay_color' => 'rgba(0,0,0,.6)',
	'effect'        => 'fade',
	'el_class' => ''
), $atts));


// Create modal container styles
$width              = 'style="max-width:'.$width.'"';


// If blur effect
$css_class         .= $this->getExtraClass( $effect );
$css_class         .= $this->getExtraClass( $overlay );


// Create overlay styles
if (  $overlay == '' || $overlay == 'color_blur' ) {
	$overlay        = 'data-overlay="'.$overlay_color.'"';
} else { $overlay   = ''; }


// Add custom classes
$el_class           = $this->getExtraClass($el_class);


$output              .= '<div class="twc_modal_window modal fade'.$css_class.'" '.$overlay.' id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="'.$id.'">
							<div class="modal-dialog" '.$width.' role="document">
								<div class="twc_mw_cont modal-content">
									<div class="twc_mw_header modal-header">
										<div class="twc_mw_close" aria-label="Close">
											<div class="line line1"></div>
											<div class="line line2"></div>
										</div>
										<div class="twc_mw_heading">'.$heading.'</div>
									</div>
									<div class="twc_mw_body modal-body">';
$output             .=                  wpb_js_remove_wpautop($content);
$output             .=		        '</div>
								</div>
							</div>
						</div>';
echo $output;