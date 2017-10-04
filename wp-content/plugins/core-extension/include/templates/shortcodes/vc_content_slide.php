<?php
$output = $title = $tab_id = $css_class = '';

extract(shortcode_atts( array(
	'title'                 => '',
	'tab_id'                => 0
	), $atts));

$css_class          .= $this->getExtraClass($title);

$output             .= 	'<div class="twc_cs_wrapper row-inner '.$title.'">';
$output             .=       '<div class="vc_col-sm-12 wpb_column vc_column_container clearfix">';
$output             .=           "\n\t\t\t" . wpb_js_remove_wpautop( $content );
$output             .=       "</div>";
$output		        .=	'</div>';


//$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_tab ui-tabs-panel wpb_ui-tabs-hide vc_clearfix', $this->settings['base'], $atts );
//$output .= "\n\t\t\t" . '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="'.$css_class.'">';
//$output .= ($content=='' || $content==' ') ? __("Empty tab. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
//$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.wpb_tab');

echo $output;