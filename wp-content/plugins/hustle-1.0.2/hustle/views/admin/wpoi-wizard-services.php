<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-services_template" type="text/template" xmlns="http://www.w3.org/1999/html">

	<div class="row dev-box-gem">

		<div class="col-half">

			<div class="wpoi-card">

				<div class="wpoi-card-block">

					<h3><?php _e('NAME & TEST MODE', Opt_In::TEXT_DOMAIN); ?></h3>

				</div>

				<div class="wpoi-card-block wpoi-error-input">

					<label><?php _e('Opt-In Name:', Opt_In::TEXT_DOMAIN); ?></label>

					<input type="text" id="optin_new_name" name="optin_new_name" value="<?php echo $is_edit ? esc_attr( $optin->optin_name ) : ''; ?>" placeholder="<?php esc_attr_e("eg. Weekly Newsletter", Opt_In::TEXT_DOMAIN) ?>">

				</div>

				<div class="wpoi-card-block">

					<span class="toggle float-l">

						<input id="wpoi-test-mode-setup" class="toggle-checkbox" type="checkbox" name="test_mode"  {{_.checked(test_mode, 1)}}>

						<label class="toggle-label" for="wpoi-test-mode-setup"></label>

					</span>

					<div class="toggle-content toggle-content-r">

						<h6 for="wpoi-test-mode-setup"><?php _e('Set up in <strong>Test Mode</strong>', Opt_In::TEXT_DOMAIN); ?></h6>

						<p><small><?php _e('Setting up your opt-in in test mode allows you to preview how it looks before linking it to your email service provider account.', Opt_In::TEXT_DOMAIN); ?></small></p>

					</div>

				</div>

			</div>

		</div>

		<div class="col-half">

			<div class="wpoi-card" id="wpoi-service-details">

				<div class="wpoi-card-block wpoi-card-block-invisible">

					<h3><?php _e('SERVICE DETAILS', Opt_In::TEXT_DOMAIN); ?></h3>
					<h3 id="wpoi-service-details-disabled-notice"><?php _e('Disable Test Mode to add a provider', Opt_In::TEXT_DOMAIN); ?></h3>

				</div>

				<form action="" method="post" id="hustle_service_details_form">
					<?php wp_nonce_field( "refresh_provider_details" ); ?>
					<div class="wpoi-card-block wpoi-card-block-invisible wpoi-error-select">

						<label><?php _e("Choose email provider:", Opt_In::TEXT_DOMAIN); ?></label>

							<select id="optin_new_provider_name" name="optin_new_provider_name" data-nonce="<?php echo wp_create_nonce('change_provider_name') ?>">

								<option value=""><?php _e("Select provider", Opt_In::TEXT_DOMAIN); ?></option>

								<?php foreach( $providers as $provider ): ?>

									<option  <?php if( $is_edit && !$code )  selected( $optin->optin_provider, $provider['id'] ); elseif( $code ) selected( 'constantcontact', $provider['id'] ); ?>  value="<?php echo $provider['id']  ?>"><?php echo $provider['name']; ?> </option>

								<?php endforeach; ?>

							</select>

					</div><!-- End Email Provider -->

					<?php if ( $is_edit ): ?>

						<div class="wpoi-card-block wpoi-card-block-invisible">



							<div id="optin_new_provider_account_details" class="optwiz-field_set">

								<?php $provider = $this->get_provider_by_id( $optin->optin_provider );

								if( $provider ){

									$options = Opt_In::provider_instance( $provider )->get_account_options( $optin->id );


									foreach( $options as $key =>  $option ){

										if( $option['type'] === 'wrapper'  ){
											$option['apikey'] = $optin->api_key;
										}

										$option = apply_filters("wpoi_optin_filter_optin_options", $option, $optin );
										$this->render("general/option", array_merge( $option, array( "key" => $key ) ));

									}

								} ?>

							</div>
							<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_options">
								<?php if($optin->test_mode != 1 && apply_filters("wpoi_optin_show_selected_list", true, $optin ) ): ?>
									<?php echo __('Selected list (campaign):', Opt_In::TEXT_DOMAIN ); ?>  <?php echo $optin->optin_mail_list . __(' (Press the GET LISTS button to update value)', Opt_In::TEXT_DOMAIN ); ?>
								<?php endif; ?>
							</div>

							<?php  if( $optin->provider_args ) : ?>
							<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_provider_args">
									<?php $this->render("admin/provider/" . $optin->optin_provider . '/args', array(
											"optin" => $optin,
											"args" => $optin->provider_args,
											"this" => $this
									)); ?>
							</div>
							<?php endif; ?>
						</div><!-- End API Key -->

					<?php else: ?>

						<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_details"></div>

						<div class="wpoi-card-block wpoi-card-block-invisible" id="optin_new_provider_account_options"></div>

					<?php endif; ?>

				</form>

			</div><!-- End Account -->

		</div>

	</div>

	<div class="row">

		<p class="next-button"><a class="button button-dark-blue" href=""><?php _e('NEXT', Opt_In::TEXT_DOMAIN); ?></a></p>

	</div>

	<div id="wpoi_loading_indicator" style="display: none;">

		<div class="wpoi-loading-wrapper">

			<div class="wpoi-loading"></div>

			<p><?php _e('Wait a bit, content is being loaded...', Opt_In::TEXT_DOMAIN); ?></p>

		</div>

	</div>

</script>
