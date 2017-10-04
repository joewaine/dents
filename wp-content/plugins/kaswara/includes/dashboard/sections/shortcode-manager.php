<?php 
	$shortCodes = kswr_get_enabled_shortcodes();
	$shortCodesArray = explode(',',$shortCodes);
?>
<div class="kswr-customset-top">
	<div style="width: 100%; float:left; box-sizing: border-box;">
		<div class="kswr-fonts-search">			
			<input type="hidden" id="active_shortcodes" value="<?php echo esc_attr($shortCodes); ?>">
			<input type="text" placeholder="<?php echo esc_html__('Search Shortcode Name','kaswara'); ?>" onkeyup="kswr_search_shortcode_name(this);">
		</div>
		<div class="kswr-customset-top-actions">
			<!--<span class="kswr-customset-top-msg"><?php echo esc_html__('Choose the shortcodes that will be included in Visual Composer!','kaswara'); ?></span>-->
			<div class="kswr-library-fonts-button btn-submit-blue" onclick="kswr_save_shortcodes();"><?php echo esc_html__('Save Changes','kaswara'); ?></div>			
			<div class="kswr-library-fonts-button btn-submit-blue" onclick="kswr_enable_disable_shortcodes('enable');" style="background: #009688; border-color: #009688;"><?php echo esc_html__('Enable All','kaswara'); ?></div>
			<div class="kswr-library-fonts-button btn-submit-blue" onclick="kswr_enable_disable_shortcodes('disable');" style="background: #b53232; border-color: #b53232;"><?php echo esc_html__('Disable All','kaswara'); ?></div>
		</div>		
	</div>
</div>
<div class="kswr-shortcode-styling-chooser">
<?php 


	$customSettings = array(	
		array('img'=> KASWARA_IMAGES.'progressbar.jpg', 'name' => 'Skill Bar', 'id' => 'skillbar')	,
		array('img'=> KASWARA_IMAGES.'radial.jpg', 'name' => 'Radial Progress', 'id' => 'radialprogress'),
		array('img'=> KASWARA_IMAGES.'findus.jpg', 'name' => 'Social Share', 'id' => 'socialshare'),
		array('img'=> KASWARA_IMAGES.'findus.jpg', 'name' => 'Find Us', 'id' => 'findus'),
		array('img'=> KASWARA_IMAGES.'video.jpg', 'name' => 'Video Modal', 'id' => 'videomodal'),
		array('img'=> KASWARA_IMAGES.'modal.jpg', 'name' => 'Modal Window', 'id' => 'modalwindow'),
		array('img'=> KASWARA_IMAGES.'button.jpg', 'name' => 'Button', 'id' => 'button'),
		array('img'=> KASWARA_IMAGES.'alert.jpg', 'name' => 'Alert Box', 'id' => 'alertbox'),
		array('img'=> KASWARA_IMAGES.'beforeafterimage.jpg', 'name' => 'Before/After Image', 'id' => 'bfimage'),
		array('img'=> KASWARA_IMAGES.'teammate.jpg', 'name' => 'Teammate', 'id' => 'teammate'),
		array('img'=> KASWARA_IMAGES.'linesep.jpg', 'name' => 'Line Separator', 'id' => 'lineseparator'),
		array('img'=> KASWARA_IMAGES.'iconseparat.jpg', 'name' => 'icon separator', 'id' => 'iconseparator'),
		array('img'=> KASWARA_IMAGES.'interactiveiconbox.jpg', 'name' => 'iconbox action', 'id' => 'iconboxaction'),
		array('img'=> KASWARA_IMAGES.'interactiveiconbox.jpg', 'name' => 'interactive iconbox', 'id' => 'interactiveiconbox'),
		array('img'=> KASWARA_IMAGES.'postgrid.jpg', 'name' => 'post grid', 'id' => 'postgrid'),
		array('img'=> KASWARA_IMAGES.'hoverimage.jpg', 'name' => 'hover image', 'id' => 'hoverimage'),
		array('img'=> KASWARA_IMAGES.'sidebyside.jpg', 'name' => 'side by side', 'id' => 'sidebyside'),
		array('img'=> KASWARA_IMAGES.'filterimages.jpg', 'name' => 'filter images', 'id' => 'filterimages'),
		array('img'=> KASWARA_IMAGES.'twohoverpic.jpg', 'name' => 'two pichover', 'id' => 'twopichover'),
		array('img'=> KASWARA_IMAGES.'drop-caps.jpg', 'name' => 'drop caps', 'id' => 'dropcaps'),
		array('img'=> KASWARA_IMAGES.'heading.jpg', 'name' => 'heading', 'id' => 'heading'),
		array('img'=> KASWARA_IMAGES.'icon.jpg', 'name' => 'single icon', 'id' => 'singleicon'),
		array('img'=> KASWARA_IMAGES.'iconbundle.jpg', 'name' => 'icon bundle', 'id' => 'iconbundle'),
		array('img'=> KASWARA_IMAGES.'infobox.jpg', 'name' => 'iconbox info', 'id' => 'iconboxinfo'),
		array('img'=> KASWARA_IMAGES.'infolist.jpg', 'name' => 'info list', 'id' => 'infolist'),
		array('img'=> KASWARA_IMAGES.'counter.jpg', 'name' => 'counter', 'id' => 'counter'),
		array('img'=> KASWARA_IMAGES.'modernpricebox.jpg', 'name' => 'pricing plan', 'id' => 'pricingplan'),
		array('img'=> KASWARA_IMAGES.'cardflip.jpg', 'name' => 'card flip', 'id' => 'cardflip'),
		array('img'=> KASWARA_IMAGES.'flip.jpg', 'name' => '3D card flip', 'id' => '3dcardflip'),
		array('img'=> KASWARA_IMAGES.'verticalprogress.jpg', 'name' => 'vertical skillbar', 'id' => 'verticalskillbar'),
		array('img'=> KASWARA_IMAGES.'flip.jpg', 'name' => 'modern flipbox', 'id' => 'modernflipbox'),
		array('img'=> KASWARA_IMAGES.'imagebanner.jpg', 'name' => 'image banner', 'id' => 'imagebanner'),
		array('img'=> KASWARA_IMAGES.'hover.jpg', 'name' => 'hover infobox', 'id' => 'hoverinfobox'),
		array('img'=> KASWARA_IMAGES.'spacer.jpg', 'name' => 'spacer', 'id' => 'spacer'),
		array('img'=> KASWARA_IMAGES.'fancy-text.jpg', 'name' => 'fancy text', 'id' => 'fancytext'),
		array('img'=> KASWARA_IMAGES.'quotes.jpg', 'name' => 'testimonial', 'id' => 'testimonial'),
		array('img'=> KASWARA_IMAGES.'animation.jpg', 'name' => 'animation block', 'id' => 'animationblock'),
		array('img'=> KASWARA_IMAGES.'modal-any.jpg', 'name' => 'modal anything', 'id' => 'modalanything'),
		array('img'=> KASWARA_IMAGES.'cards.jpg', 'name' => 'card slider', 'id' => 'cardslider'),
		array('img'=> KASWARA_IMAGES.'pricebox.jpg', 'name' => 'price box', 'id' => 'pricebox'),
		array('img'=> KASWARA_IMAGES.'carousel.jpg', 'name' => 'carousel', 'id' => 'carousel'),
		array('img'=> KASWARA_IMAGES.'filterimages.jpg', 'name' => 'layered images', 'id' => 'layeredimages'),
		array('img'=> KASWARA_IMAGES.'countdown.jpg', 'name' => 'countdown', 'id' => 'countdown'),
		array('img'=> KASWARA_IMAGES.'gmap.jpg', 'name' => 'google maps', 'id' => 'googlemaps'),
		array('img'=> KASWARA_IMAGES.'piling.jpg', 'name' => 'piling section', 'id' => 'pilingsection'),
		array('img'=> KASWARA_IMAGES.'replica-section.jpg', 'name' => 'Replica Section', 'id' => 'replicasection'),
		array('img'=> KASWARA_IMAGES.'row.jpg', 'name' => 'Kaswara VC Rows', 'id' => 'kswr_rows_columns'),
	);
	if(is_plugin_active('contact-form-7/wp-contact-form-7.php')){
		array_push($customSettings,array('img'=> KASWARA_IMAGES.'cf7.jpg', 'name' => 'Contact Form Designer', 'id' => 'cf7'));
	}
			
	foreach ($customSettings as $elem) {
		$sit = 'off';
		if(in_array($elem['id'],$shortCodesArray)) 	$sit = 'on';

	?>
		<div class="kswr-customset-item" data-id="<?php echo esc_attr($elem['id']); ?>" data-name="<?php echo esc_attr(strtolower($elem['name'])); ?>">
			<div class="kswr-customset-img"><img src="<?php echo esc_url($elem['img']); ?>"></div>
			<div class="kswr-customset-title">
				<span class="kswr-customset-name"><?php echo $elem['name']; ?></span>
				<div class="kswr-customset-switcher-ct">
					<div class="sy-sw-controler sy-sw-controler_<?php echo $sit; ?>" data-id="<?php echo esc_attr($elem['id']); ?>" onclick="kswr_setting_chooser(this);"  data-situation="<?php echo esc_attr($sit); ?>" >							
						<div class="sy-sw-cursor"></div>
						<div class="sy-sw-label sy-sw-label_on">ON</div>
						<div class="sy-sw-label sy-sw-label_off">OFF</div>
					</div>
				</div>
			</div>
		</div>	
	<?php } ?>
</div>