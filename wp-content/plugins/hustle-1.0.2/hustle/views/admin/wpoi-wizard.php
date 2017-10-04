<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>

<div class="wpmud">

	<div id="container" class="wrap">

		<header id="header">

			<h1 class="main-title-alternative"><?php $is_edit ? _e('EDIT OPT-IN', Opt_In::TEXT_DOMAIN) : _e('NEW OPT-IN WIZARD', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section id="wpoi-wizard">

			<div class="wpoi-tabbed-area">

				<ul class="wpoi-tabs-menu">

					<li class="active"><a tab="services"><?php _e('NAME & EMAIL SERVICE', Opt_In::TEXT_DOMAIN); ?></a></li>

					<li><a tab="design"><?php _e('CONTENT & DESIGN', Opt_In::TEXT_DOMAIN); ?></a></li>

					<li><a tab="display"><?php _e('DISPLAY SETTINGS', Opt_In::TEXT_DOMAIN); ?></a></li>

				</ul>

				<div class="wpoi-tabs-wrap">

					<div id="wpoi-wizard-services">

						<?php $this->render("admin/wpoi-wizard-services", array(
								"is_edit" => $is_edit,
								'providers' => $providers,
								'optin' => $optin,
								'animations' => $animations,
								'code' => $code
						)); ?>

					</div>

					<div id="wpoi-wizard-design">

						<?php $this->render("admin/wpoi-wizard-design", array(
								"is_edit" => $is_edit,
								'providers' => $providers,
								'optin' => $optin,
								'animations' => $animations
						)); ?>

					</div>

					<div id="wpoi-wizard-settings"></div>
					<?php $this->render("admin/wpoi-wizard-settings",  array(
							"is_edit" => $is_edit,
							'providers' => $providers,
							'optin' => $optin,
							'animations' => $animations,
							"widgets_page_url" => $widgets_page_url
					)); ?>
				</div>

			</div>

		</section>

	</div>

</div>

<!-- ================================
	 ======= The Color Picker =======
	 ================================ -->

<script id="optin-color-pickers" type="text/template">

	<hgroup class="wpoi-palette-title">

		<h5><?php _e("Opt-in Basics", Opt_In::TEXT_DOMAIN ); ?></h5>

	</hgroup>

	<div class="row">

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "Main Background", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_main_background"  value="{{colors.main_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Title Color", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_title_color"  value="{{colors.title_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Link Color", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_link_color"  value="{{colors.link_color}}" class="optin_color_picker"/>

		    </div>

		</div>

		<div class="col-half">

			<div class="wpoi-wrap cf" style="height: 36px;"></div>

			<div class="wpoi-wrap cf">

		        <label><?php _e( "Content Color", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_content_color"  value="{{colors.content_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Link Color (Hover)", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_link_hover_color"  value="{{colors.link_hover_color}}" class="optin_color_picker"/>

		    </div>

		</div>

	</div>

	<hgroup class="wpoi-palette-title">

		<h5><?php _e("Opt-in Form", Opt_In::TEXT_DOMAIN ); ?></h5>

	</hgroup>

	<div class="row">

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label><?php _e( "Form Background", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_form_background"  value="{{colors.form_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Input Background", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_fields_background"  value="{{colors.fields_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Label Color", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_label_color"  value="{{colors.label_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Mailchimp Groups Title", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_mcg_title_color"  value="{{colors.mcg_title_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Checkbox", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_checkbox_background"  value="{{colors.checkbox_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Radio Button", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_radio_background"  value="{{colors.radio_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Button Background", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_button_background"  value="{{colors.button_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Button Label", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_button_label"  value="{{colors.button_label}}" class="optin_color_picker"/>

		    </div>

		</div>

		<div class="col-half">

			<div class="wpoi-wrap cf" style="height: 36px;"></div>

			<div class="wpoi-wrap cf">

		        <label><?php _e( "Input Color", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_fields_color"  value="{{colors.fields_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "Error Label", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_error_color"  value="{{colors.error_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Mailchimp Groups Labels", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_mcg_label_color"  value="{{colors.mcg_label_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Checkbox (Checked)", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_checkbox_checked_color"  value="{{colors.checkbox_checked_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Radio Button (Checked)", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_radio_checked_background"  value="{{colors.radio_checked_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Button Background (Hover)", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_button_hover_background"  value="{{colors.button_hover_background}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Button Label (Hover)", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_button_hover_label"  value="{{colors.button_hover_label}}" class="optin_color_picker"/>

		    </div>

		</div>

	</div>

	<hgroup class="wpoi-palette-title">

		<h5><?php _e("Success Message", Opt_In::TEXT_DOMAIN ); ?></h5>

	</hgroup>

	<div class="row">

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label><?php _e( "Checkmark Icon", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_checkmark_color"  value="{{colors.checkmark_color}}" class="optin_color_picker"/>

		    </div>

		</div>

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "Content Color", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_success_color"  value="{{colors.success_color}}" class="optin_color_picker"/>

		    </div>

		</div>

	</div>

	<hgroup class="wpoi-palette-title">

		<h5><?php _e("Extra Styles", Opt_In::TEXT_DOMAIN ); ?></h5>

	</hgroup>

	<div class="row">

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "\"X\" Icon Color", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_close_color"  value="{{colors.close_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "Never Seen Again", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_nsa_color"  value="{{colors.nsa_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label><?php _e( "Overlay Mask", Opt_In::TEXT_DOMAIN ); ?></label>
		        <input type="text" id="optin_overlay_background"  value="{{colors.overlay_background}}" class="optin_color_picker"/>

		    </div>

		</div>

		<div class="col-half">

			<div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "\"X\" Icon Color (Hover)", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_close_hover_color"  value="{{colors.close_hover_color}}" class="optin_color_picker"/>

		    </div>

		    <div class="wpoi-wrap cf">

		        <label class="wpoi-label_thin"><?php _e( "Never Seen Again (Hover)", Opt_In::TEXT_DOMAIN ); ?></label>
				<input type="text" id="optin_nsa_hover_color"  value="{{colors.nsa_hover_color}}" class="optin_color_picker"/>

		    </div>

		</div>

	</div>

</script>

<script id="optin-palette-option-dropdown" type="text/template">
    <div class="optin_palette_option" id="{{id}}">
        <span class="main_background" style="background: {{main_background}}"></span>
        <span class="title_color" style="background: {{title_color}}"></span>
        <span class="link_color" style="background: {{link_color}}"></span>
        <span class="content_color" style="background: {{content_color}}"></span>
        <span class="link_hover_color" style="background: {{link_hover_color}}"></span>
        <span class="form_background" style="background: {{form_background}}"></span>
        <span class="fields_background" style="background: {{fields_background}}"></span>
        <span class="label_color" style="background: {{label_color}}"></span>
        <span class="button_background" style="background: {{button_background}}"></span>
        <span class="button_label" style="background: {{button_label}}"></span>
        <span class="fields_color" style="background: {{fields_color}}"></span>
        <span class="error_color" style="background: {{error_color}}"></span>
        <span class="button_hover_background" style="background: {{button_hover_background}}"></span>
        <span class="button_hover_label" style="background: {{button_hover_label}}"></span>
        <span class="checkmark_color" style="background: {{checkmark_color}}"></span>
        <span class="success_color" style="background: {{success_color}}"></span>
        <span class="close_color" style="background: {{close_color}}"></span>
        <span class="nsa_color" style="background: {{nsa_color}}"></span>
        <span class="overlay_background" style="background: {{overlay_background}}"></span>
        <span class="close_hover_color" style="background: {{close_hover_color}}"></span>
        <span class="nsa_hover_color" style="background: {{nsa_hover_color}}"></span>
        <span class="radio_background" style="background: {{radio_background}}"></span>
        <span class="radio_checked_background" style="background: {{radio_checked_background}}"></span>
        <span class="checkbox_background" style="background: {{checkbox_background}}"></span>
        <span class="checkbox_checked_background" style="background: {{checkbox_checked_background}}"></span>
        <span class="mcg_title_color" style="background: {{mcg_title_color}}"></span>
        <span class="mcg_label_color" style="background: {{mcg_label_color}}"></span>
        <span class="palette_name">{{text}}</span>
    </div>
</script>

<script id="wpoi-wizard-popup-conditions-handle" type="text/template">
	<div class="wpoi-condition-item {{active_class}}" id="{{cid}}" data-id="{{id}}">
		{{label}}<span class="dashicons-before {{icon_class}}"></span>
	</div>
</script>

<script id="wpoi-wizard-popup-conditions-item" type="text/template">
	<header>
		<h6>{{title}}<span class="dashicons-before wpoi-arrow-up"></span></h6>
	</header>

	<section>{{{ body }}}</section>
</script>

<script id="wpoi-condition-shown_less_than" type="text/template">
	<div class="rule-description">
		<em><?php _e("Shows the {{type_name}} if the user has only seen it less than a specific number of times.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="shown_less_than_value"><?php _e("Display {{type_name}} this often:", Opt_In::TEXT_DOMAIN); ?></label>
		<input type="number" id="shown_less_than_value" class="inp-small" name="" data-attribute="less_than" min="1" max="999" maxlength="3" placeholder="10" value="{{less_than}}">
	</div>
</script>

<script id="wpoi-condition-from_specific_ref" type="text/template">
	<div class="rule-description">
			<em><?php _e("Shows the Pop Up if the user arrived via a specific referrer.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="from_specific_ref_refs">
			<?php _e('Referrers. Can be full URL or a pattern like ".example.com" (one per line):', Opt_In::TEXT_DOMAIN); ?>
		</label>
		<textarea name="" id="from_specific_ref_refs" data-attribute="refs" class="block">{{{refs}}}</textarea>
	</div>
</script>

<script id="wpoi-condition-not_from_specific_ref" type="text/template">
	<div class="rule-description">
		<em><?php _e("Hides the Pop Up if the user arrived via a specific referrer.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="from_specific_ref_refs">
			<?php _e('Referrers. Can be full URL or a pattern like ".example.com" (one per line):', Opt_In::TEXT_DOMAIN); ?>
		</label>
		<textarea name="" id="from_specific_ref_refs" data-attribute="refs" class="block">{{{refs}}}</textarea>
	</div>
</script>

<script id="wpoi-condition-on_specific_url" type="text/template">
	<div class="rule-description">
			<em><?php _e("Shows the {{type_name}} if the user is on a certain URL.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="on_specific_url_urls">
			<?php _e("Show on these URLs (one per line):", Opt_In::TEXT_DOMAIN); ?>
		</label>
		<textarea name="" id="on_specific_url_urls" class="block" data-attribute="urls" >{{{ urls }}}</textarea>
		<em><?php _e('URLs should not include "http://" or "https://"', Opt_In::TEXT_DOMAIN); ?></em>
	</div>
</script>

<script id="wpoi-condition-not_on_specific_url" type="text/template">
	<div class="rule-description">
		<em><?php _e("Shows the {{type_name}} if the user is not on a certain URL.", Opt_In::TEXT_DOMAIN) ?></em>
	</div>
	<div class="rule-form">
		<label for="not_on_specific_url_urls"><?php _e("Not on these URLs (one per line):", Opt_In::TEXT_DOMAIN); ?></label>
		<textarea name="" id="not_on_specific_url_urls_urls" data-attribute="urls" class="block">{{{ urls }}}</textarea>
		<em><?php _e('URLs should not include "http://" or "https://"', Opt_In::TEXT_DOMAIN); ?></em>
	</div>
</script>

<script id="wpoi-condition-in_a_country" type="text/template">
	<div class="rule-description">
		<em><?php _e("Shows the {{type_name}} if the user is in a certain country.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="in_a_country_countries"><?php _e("Included countries:", Opt_In::TEXT_DOMAIN); ?>

		<select name="" class="js-wpoi-select none-wpmu" id="in_a_country_countries" data-val="countries" multiple="multiple" data-attribute="countries" placeholder="<?php esc_attr_e( 'Click here to select a country', Opt_In::TEXT_DOMAIN ); ?>" >
			<?php foreach ( $countries as $code => $name ) : ?>
				<option value="<?php echo esc_attr( $code ); ?>" > <?php echo esc_attr( $name ); ?> </option>
			<?php endforeach; ?>
		</select>
	</div>
</script>

<script id="wpoi-condition-not_in_a_country" type="text/template">
	<div class="rule-description">
		<em><?php _e("Shows the {{type_name}} if the user is not in a certain country.", Opt_In::TEXT_DOMAIN); ?></em>
	</div>
	<div class="rule-form">
		<label for="not_in_a_country_countries"><?php _e("Excluded countries:", Opt_In::TEXT_DOMAIN); ?>

			<select name="" class="js-wpoi-select none-wpmu" id="not_in_a_country_countries" data-val="countries" multiple="multiple" data-attribute="countries" placeholder="<?php esc_attr_e( 'Click here to select a country', Opt_In::TEXT_DOMAIN ); ?>" >
				<?php foreach ( $countries as $code => $name ) : ?>
					<option value="<?php echo esc_attr( $code ); ?>" > <?php echo esc_attr( $name ); ?> </option>
				<?php endforeach; ?>
			</select>
	</div>
</script>