<?php
/** @var $this WPBakeryShortCode_VC_Icon */
$icon = $color = $size = $align = $el_class = $custom_color = $link = $background_style = $background_color =
$type = $icon_fontawesome = $icon_openiconic = $icon_typicons = $icon_entypoicons = $icon_linecons =
$icon_simplelineicons = $custom_bg_color = $display = $margin_left = $margin_right =
$icon_animation = $css_animation = $css_animation_delay = $a_href = $a_title = '';

$defaults = array(
	'type'                  => 'fontawesome',
	'icon_fontawesome'      => 'fa fa-adjust',
	'icon_openiconic'       => '',
	'icon_typicons'         => '',
	'icon_entypoicons'      => '',
	'icon_linecons'         => '',
	'icon_entypo'           => '',
	'icon_simplelineicons'  => '',
	'color'                 => 'icon_themecolor',
	'custom_color'          => '',
	'background_style'      => '',
	'background_color'      => 'icon_bg_themecolor',
	'custom_bg_color'       => '',
	'size'                  => 'md',
	'display'               => 'block',
	'align'                 => 'left',
	'margin_left'           => '0px',
	'margin_right'          => '0px',
	'el_class'              => '',
	'link'                  => '',
	'icon_animation'        => '',
	'css_animation'         => '',
	'css_animation_delay'   => ''
);
/** @var array $atts - shortcode attributes */
$atts = vc_shortcode_attribute_parse( $defaults, $atts );
extract( $atts );

$class = $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );
$css_class .= $this->getCSSAnimation( $css_animation );
($css_animation != '' && $css_animation_delay != '') ? $css_class .= $this->getExtraClass($css_animation_delay) : '';

// Enqueue needed icon font.
vc_icon_element_fonts_enqueue( $type );

$link = ($link=='||') ? '' : $link;
$link = vc_build_link($link);
$a_href = $link['url'];
$a_title = $link['title'];
($link['target'] != '') ? $a_target = $link['target'] : $a_target = '_self';
$rel = $link['rel'] !== '' ? ' rel="'.$link['rel'].'"' : '';

$has_style = false;
if ( strlen( $background_style ) > 0 ) {
	$has_style = true;
	if ( strpos( $background_style, 'outline' ) !== false ) {
		$background_style .= ' vc_icon_element-outline'; // if we use outline style it is border in css
	} else {
		$background_style .= ' vc_icon_element-background';
	}
}
$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';
?><div
	class="vc_icon_element vc_icon_element-outer<?php echo esc_attr( $css_class ); ?>  vc_icon_element-align-<?php if( $display == 'block' ): echo esc_attr( $align ); else: echo 'none'; endif; ?> <?php if( $has_style ): echo 'vc_icon_element-have-style'; endif; ?>" <?php if ( $display === 'inline-block' ) { $margin_left = ( $margin_left != '' ) ? 'margin-left:'.$margin_left.'; ' : ''; $margin_right = ( $margin_right != '' ) ? 'margin-right:'.$margin_right.';' : ''; if ( $margin_left != '' || $margin_right != '' ) {echo 'style="'.$margin_left.$margin_right.'"';} } ?>><div
		class="vc_icon_element-inner <?php echo esc_attr( $icon_animation ); ?> <?php if( $color != 'custom' ): echo esc_attr( $color ); endif; ?> <?php if( $has_style ): echo 'vc_icon_element-have-style-inner'; endif; ?> vc_icon_element-size-<?php echo esc_attr( $size ); ?>  vc_icon_element-style-<?php echo esc_attr( $background_style ); ?> <?php echo esc_attr( $background_color ); ?>" <?php if ( $has_style ) : echo( $background_color === 'bg_custom' ? 'style="background-color:' . esc_attr( $custom_bg_color ) . '; border-color:' . esc_attr( $custom_bg_color ) . ';"' : '' ); endif; ?>><span
			class="vc_icon_element-icon <?php echo $iconClass; ?>" <?php echo( $color === 'custom' ? 'style="color:' . esc_attr( $custom_color ) . ' !important"' : '' ); ?>></span><?php
		if ( strlen( $link['url'] ) > 0 ) {
			echo '<a class="vc_icon_element-link" href="' . esc_attr( $a_href ) . '" title="' . esc_attr( $a_title ) . '" target="' . esc_attr( $a_target ) . '"'.$rel.'></a>';
		}
		?></div></div><?php echo $this->endBlockComment( '.vc_icon_element' ); ?>
