<?php 
/* ================================================================== *\
   ==                                                              ==
   ==                                                              ==
   ==============       Layered Images Shortcode       ============== 
   ==                                                              ==
   ==  															   ==
\* ================================================================== */


if(!class_exists('Kaswara_layeredimages'))
{
	class Kaswara_layeredimages
	{
		function __construct()
		{
			add_action('init',array($this,'kaswara_layeredimages_init'));
			add_shortcode('kswr_layeredimages',array($this,'kaswara_layeredimages_shortcode'));	
			add_shortcode('kswr_layeredimages_singleimage',array($this,'Kaswara_layeredimages_singleimage_shortcode'));		
		}
		
		function kaswara_layeredimages_init(){
			if(function_exists('vc_map')){
				//VC map Layered Image
				vc_map(
					array(
						"name" => esc_html__("Layred Images","kaswara"),
						"base" => "kswr_layeredimages",
				        "description" => esc_html__("Layered Images container.", "kaswara"),         						
        				'as_parent' => array('only' => 'kswr_layeredimages_singleimage'),
 				        'icon' => KASWARA_IMAGES.'small/filterimages.jpg',  
						"class" => "",
      					"category" => "Kaswara",        
						"content_element" => true,
						"show_settings_on_create" => true,						
						"js_view" => 'VcColumnView',
						"params" => array(		
						array(
				                "type" => "textfield",
				                "heading" => esc_html__( "CSS Class", "kaswara" ),
				                "description" => esc_html__( "Add custom CSS classes", "kaswara" ),
				                "param_name" => "lrimctn_classes"
				            ),	
				            array(
								'type' => 'css_editor',							
								'heading' => esc_html__( 'CSS box', 'kaswara' ),
								'param_name' => 'lrimctn_css',
								'group' => 'Design Options'
							),		
							array(
				                'type' => 'dropdown',
				                'heading' => esc_html__( 'Elements Align', 'kaswara' ),
				                'param_name' => 'lrimctn_align',
				                'value' => array(
				                    esc_html__( 'Center','kaswara') => 'center',
				                    esc_html__( 'Left','kaswara') => 'left',
				                    esc_html__( 'Right','kaswara') => 'right',
				                )               
				            ),			
							
						)
					)
				);

				//VC map LayeredImages Section
				vc_map(
					array(
						"name" => esc_html__("Single Layer Image","kaswara"),
						"base" => "kswr_layeredimages_singleimage",
				        "description" => esc_html__("Single image for the layered images container.", "kaswara"),         						        				
						'as_child' => array('only' => 'kswr_layeredimages'),
 				       'icon' => KASWARA_IMAGES.'small/hoverimage.jpg',  
						"class" => "",
      					"category" => "Kaswara",        											
						"params" => array(
							array(
				                "type" => "attach_image",
				                "heading" => esc_html__( "Choose Image", "kaswara" ),
				                "param_name" => "lrsimg_image"
				            ),
							array(
				                "type" => "dropdown",
				                "heading" => esc_html__( 'Animation Type','kaswara'),
				                "param_name" => "lrsimg_type",  
				                'value' => array(
				                    'bounce'=>'bounce','flash'=>'flash','pulse'=>'pulse','rubberBand'=>'rubberBand','shake'=>'shake','swing'=>'swing','tada'=>'tada','wobble'=>'wobble','jello'=>'jello',    
'fadeIn'=>'fadeIn','fadeInDown'=>'fadeInDown','fadeInDownBig'=>'fadeInDownBig','fadeInLeft'=>'fadeInLeft','fadeInLeftBig'=>'fadeInLeftBig','fadeInRight'=>'fadeInRight','fadeInRightBig'=>'fadeInRightBig','fadeInUp'=>'fadeInUp','fadeInUpBig'=>'fadeInUpBig','slideInUp'=>'slideInUp','slideInDown'=>'slideInDown','slideInLeft'=>'slideInLeft','slideInRight'=>'slideInRight','zoomIn'=>'zoomIn','zoomInDown'=>'zoomInDown','zoomInLeft'=>'zoomInLeft','zoomInRight'=>'zoomInRight','zoomInUp'=>'zoomInUp','bounceIn'=>'bounceIn','bounceInDown'=>'bounceInDown','bounceInLeft'=>'bounceInLeft','bounceInRight'=>'bounceInRight','bounceInUp'=>'bounceInUp','rotateIn'=>'rotateIn','rotateInDownLeft'=>'rotateInDownLeft','rotateInDownRight'=>'rotateInDownRight','rotateInUpLeft'=>'rotateInUpLeft','rotateInUpRight'=>'rotateInUpRight','flip'=>'flip','flipInX'=>'flipInX','flipInY'=>'flipInY','flipOutX'=>'flipOutX','flipOutY'=>'flipOutY','hinge'=>'hinge','rollIn'=>'rollIn','rollOut'=>'rollOut',				                   
				                )         
				            ), 
				            array(
				                "type" => "kswr_number",
				                "heading" => esc_html__( "Animation Duration", "kaswara" ),
				                "description" => esc_html__( "This value is in seconds", "kaswara" ),
				                "param_name" => "lrsimg_duration",
				                "value" => 1				               
				            ),
				            array(
				                "type" => "kswr_number",
				                "heading" => esc_html__( "Animation Delay", "kaswara" ),
				                "description" => esc_html__( "This value is in seconds", "kaswara" ),
				                "param_name" => "lrsimg_delay",
				                "value" => 0
				             ),
				            array(
				                "type" => "kswr_switcher",
				                "heading" => esc_html__( "Re-Animate", "kaswara" ),
				                "description" => esc_html__( "Re-animate the block each time is on the viewport", "kaswara" ),
				                "param_name" => "lrsimg_reanimate",
				                'default' => 'false',
				                'on' => array('text' => 'ON','val' => 'true' ),
				                'off'=> array('text' => 'OFF','val' => 'false') 
				            ), 
				            array(
				                'type' => 'dropdown',
				                'heading' => esc_html__( 'Number Of interations', 'kaswara' ),
				                'param_name' => 'lrsimg_iteration',
				                'value' => array(
				                    esc_html__( 'Once','kaswara') => 'once',
				                    esc_html__( 'Custom','kaswara') => 'custom',
				                    esc_html__( 'Infinite','kaswara') => 'infinite',
				                )               
				            ),
				             array(
				                "type" => "kswr_number",
				                "heading" => esc_html__( "How many iterations?", "kaswara" ),
				                "param_name" => "lrsimg_iteration_number",
				                "dependency" => Array("element" => "lrsimg_iteration","value" => array('custom')),            
				                "value" => 2				               
				             ),	

						)
					)
				);

			
				
			}
		}	

		function kaswara_layeredimages_shortcode($atts,$content = null){				
			extract(shortcode_atts(array(		
				'lrimctn_classes'	=> '',
				'lrimctn_css'		=> '',		
				'lrimctn_align'		=> 'center'		
		 	), $atts));
		 	
		 	$outPut = '';
		 	$classes_c = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $lrimctn_classes . vc_shortcode_custom_css_class( $lrimctn_css, ' ' ), $atts );
		 	$outPut = '<div data-align="'.esc_attr($lrimctn_align).'" class="kswr-layeredimages-container '.esc_attr($classes_c).'">'.do_shortcode($content).'</div>';
		 	return $outPut;			
		}

		function Kaswara_layeredimages_singleimage_shortcode($atts,$content = null){
				extract(shortcode_atts(array(	
					'lrsimg_image'				=> '',
					'lrsimg_type'				=> 'bounce',
					'lrsimg_duration'			=> '1',
					'lrsimg_delay'				=> '0',
					'lrsimg_reanimate'			=> 'once',
					'lrsimg_iteration'			=> '2',
					'lrsimg_iteration_number'	=> 'false'										
				), $atts));
				$lrsimg_image_src = wp_get_attachment_image_src($lrsimg_image,'full');
				
				$outPut = $cntStyle = '';
				$cntStyle = 'animation-duration: '.$lrsimg_duration.'s; -webkit-animation-duration: '.$lrsimg_duration.'s; animation-delay:'.$lrsimg_delay.'s; -webkit-animation-delay:'.$lrsimg_delay.'s;';
  				if($lrsimg_iteration == 'custom')
	  				$cntStyle .= 'animation-iteration-count: '.$lrsimg_iteration_number.'; -webkit-animation-iteration-count: '.$lrsimg_iteration_number.';';
	  			if($lrsimg_iteration == 'infinite')
	  				$cntStyle .= 'animation-iteration-count: infinite; -webkit-animation-iteration-count:infinite;';

				$outPut = '<div class="kswr-layeredimages-single kswr-animationblock" data-reanimation="'.esc_attr($lrsimg_reanimate).'" data-animation="'.esc_attr($lrsimg_type).'"  style="'.$cntStyle.'"><div class="blockanimecont"><img src="'.$lrsimg_image_src[0].'"></div></div>';
				return $outPut;
			}

	}
}
if(class_exists('Kaswara_layeredimages')){
	$Kaswara_animation_block = new Kaswara_layeredimages;
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
    class WPBakeryShortCode_kswr_layeredimages extends WPBakeryShortCodesContainer {}    
}



?>