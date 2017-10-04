<?php
/**
 * Pixel8es Header info
 *
 * Header info Template
 *
 * @author 		Theme Innwit
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$prefix = composer_get_prefix();

$id = get_the_ID();

${$prefix.'top_section_style'} = composer_get_meta_value( $id, '_amz_top_section_style', 'default', 'top_section_style', 'light' ); // id, meta_key, meta_default, themeoption_key, themeoption_default

$top_class = ( 'dark' === ${$prefix.'top_section_style'} ) ? ' top-sec-dark ' : '';

$top_header_mobile = composer_get_option_value( 'top_header_mobile', 'show' );

$top_class .= ( 'hide' === $top_header_mobile ) ? ' top-header-mobile-hide ' : '';
?>


<div class="pageTopCon<?php echo esc_attr( $top_class ); ?>">
	<div class="container">
		<div class="pageTop row">
			<div class="pull-left">
				<div class="header-center">
					<?php
						$grey_header_sorter = array( 
							"left" => array (
								"placebo" 		=> "placebo", //REQUIRED!
								"email"		=> "Email",
								"tel"		=> "Telephone",
							),
							"right" => array (
								"placebo" 		=> "placebo", //REQUIRED!
								"sicons"	=> "Social Icons",
							),
						);

						$grey_header_sorter_left = composer_get_option_array_value('grey_header_sorter','left', $grey_header_sorter['left'] );

						foreach ( $grey_header_sorter_left as $key => $value ) {
							composer_display_header_elements( $key, 'lang-list-wrap', 'page-top-left' );
						}
					 
					?>
				</div>
			</div>
			<div class="pull-right">
				<div class="header-center">
					<?php 
						$grey_header_sorter_right = composer_get_option_array_value('grey_header_sorter','right', $grey_header_sorter['right'] );

						foreach ( $grey_header_sorter_right as $key => $value ) {
							composer_display_header_elements( $key, 'lang-list-wrap', 'page-top-left' );
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>