<?php
/**
 * @var $this Opt_In_Admin
 * @var $optin Opt_In_Model
 * @var $new_optin Opt_In_Model
 */
?>
<div class="wpmud">

	<div id="container" class="wrap wpoi-listing-page">

		<header id="header">

			<h1 class="main-title-alternative">
				<?php _e("Manage Your Opt-Ins", Opt_In::TEXT_DOMAIN); ?>
				<a class="button button-add-new" href="<?php echo esc_url( $add_new_url ); ?>"><?php _e("Add New"); ?></a>
			</h1>

		</header>

		<section>

			<ul class="accordion">

				<?php
				$first_index = true;
				foreach( $optins as $key => $optin  ):
					$first_index = $first_index && $optin->active;
					?>

					<li>

						<div class="wpoi-listing-wrap<?php echo  ( $first_index && (!$new_optin && !$updated_optin) ) || ( $new_optin && $optin->id === $new_optin->id ) || ( $updated_optin && $optin->id === $updated_optin->id )     ? ' open' : ''; ?>">

							<header class="can-open">

								<h2 class="tl">

									<span class="toggle float-l">

										<input data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_state') ?>" id="optin-active-state-<?php echo esc_attr($optin->id);   ?>" class="toggle-checkbox optin-active-state" type="checkbox" data-id="<?php echo esc_attr($optin->id);  ?>" <?php checked( $optin->active, 1 ); ?>  >

										<label class="toggle-label" for="optin-active-state-<?php  echo esc_attr($optin->id);  ?>"></label>

									</span>
									<span class="wpoi-optin-name"><?php echo esc_html( $optin->optin_name );  ?></span>
									<span class="wpoi-optin-provider-name <?php echo (int) $optin->test_mode  ? 'wpoi-optin-no-privider' : '' ?>"><?php echo esc_html( $optin->decorated->mail_service_label );  ?></span>

									<button class="button button-edit edit-optin" href="<?php echo $optin->decorated->get_edit_url( "design" ); ?>" ><?php _e("EDIT", Opt_In::TEXT_DOMAIN); ?></button>

									<span class="delete-optin-confirmation" style="display:none;">
										<span><?php _e("Are you sure?", Opt_In::TEXT_DOMAIN); ?></span>
										<button class="button button-delete optin-delete-optin-confirm" data-nonce="<?php echo wp_create_nonce('inc_opt_delete_optin'); ?>" data-id="<?php echo esc_attr( $optin->id ); ?>"><?php _e("YES", Opt_In::TEXT_DOMAIN); ?></button>
										<button class="button button-edit optin-delete-optin-cancel"><?php _e("NO", Opt_In::TEXT_DOMAIN); ?></button>
									</span>

									<button class="button button-delete optin-delete-optin" ><?php _e("DELETE", Opt_In::TEXT_DOMAIN); ?></button>

								</h2>

								<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>

							</header>

							<section>
								<div class="wpoi-optin-disable-overlay<?php echo $optin->active ? ' hidden' : ''; ?>">
									<div><?php _e("Please activate this opt-in to configure it's settings.", Opt_In::TEXT_DOMAIN); ?></div>
								</div>
								<table class="wpoi-optin-details">

									<thead>

										<tr>

											<th><?php _e("Opt-In Type", Opt_In::TEXT_DOMAIN); ?></th>

											<th><?php _e("Display Environments", Opt_In::TEXT_DOMAIN); ?></th>

											<th class="tc"><?php _e("Views", Opt_In::TEXT_DOMAIN); ?></th>

											<th class="tc"><?php _e("Conversions", Opt_In::TEXT_DOMAIN); ?></th>

											<th class="tc"><?php _e("Conversion Rate", Opt_In::TEXT_DOMAIN); ?></th>

											<th class="tc">
												<?php _e("Admin Test", Opt_In::TEXT_DOMAIN); ?>
												<span class="wpoi-tooltip tooltip-right" tooltip="<?php esc_attr_e('Allows logged-in Admins to test the appearance & functionality of the Opt-In before Activating it.', Opt_In::TEXT_DOMAIN) ?>">
													<span class="dashicons dashicons-editor-help wpoi-icon-info"></span>
												</span>

											</th>

											<th class="tc"><?php _e("Active", Opt_In::TEXT_DOMAIN); ?></th>

										</tr>

									</thead>

									<tbody>

										<?php foreach( $types as $type_key => $type ):  ?>

											<tr>

												<td class="display-settings-icon">
													<span class="success-settings-list icon <?php echo $type_key ?>">
														<?php echo $type; ?>
													</span>
													<?php
													if( !( "shortcode" === $type_key || "widget" === $type_key ) ): ?>
														<a class="button button-edit"  href="<?php echo $optin->decorated->get_edit_url( 'display/' . $type_key ) ?>">
															<?php _e("EDIT", Opt_In::TEXT_DOMAIN); ?>
														</a>
													<?php endif; ?>
												</td>

												<td class="display-environments"><?php echo $optin->decorated->display_environments($type_key); ?></td>

												<td class="tc"><?php echo $optin->{$type_key}->views_count; ?></td>

												<td class="tc"><?php echo $optin->{$type_key}->conversions_count ?></td>

												<td class="tc"><?php echo $optin->{$type_key}->conversion_rate ?>%</td>

												<td class="tc">

													<span class="toggle test-mode">

														<input id="optin-testmode-active-state-<?php echo esc_attr($type_key) ."-". esc_attr( $optin->id );  ?>" data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_type_test_mode'); ?>" class="toggle-checkbox wpoi-testmode-active-state" type="checkbox" data-type="<?php echo esc_attr($type_key); ?>" data-id="<?php echo esc_attr($optin->id);  ?>" <?php checked( (bool) $optin->is_test_type_active( $type_key ), true ); ?>  >

														<label class="toggle-label" for="optin-testmode-active-state-<?php echo esc_attr($type_key) ."-". esc_attr( $optin->id );  ?>"></label>

													</span>

												</td>

												<td class="tc">

													<span class="toggle">

														<input id="optin-<?php echo esc_attr($type_key); ?>-active-state-<?php echo esc_attr($optin->id);  ?>" class="toggle-checkbox wpoi-<?php  echo esc_attr($type_key); ?>-active-state optin-type-active-state" data-nonce="<?php echo wp_create_nonce('inc_opt_toggle_optin_type_state'); ?>"  data-type="<?php echo esc_attr($type_key); ?>" data-id="<?php echo esc_attr($optin->id);?>" type="checkbox"  <?php checked( $optin->settings->{$type_key}->enabled, true ); ?> >

														<label class="toggle-label" for="optin-<?php echo $type_key ?>-active-state-<?php echo $optin->id;  ?>"></label>

													</span>

												</td>

											</tr>

										<?php endforeach; ?>

									</tbody>

								</table>

							</section>

						</div>

					</li>

				<?php
				$first_index = !$first_index;
				endforeach; ?>

			</ul>

		</section>

	</div>

	<?php if( ! is_null( $new_optin ) ) $this->render("admin/new-optin_success", array( 'new_optin' => $new_optin, 'types' => $types )); ?>

</div>