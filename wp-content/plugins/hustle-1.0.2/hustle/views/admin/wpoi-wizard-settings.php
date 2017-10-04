<?php
/**
 * @var Opt_In_Admin $this
 * @var Opt_In_Model $optin
 * @var bool $is_edit if it's in edit mode
 */
?>
<script id="wpoi-wizard-settings_widget_template" type="text/template">
	<p><?php printf( __('Set up how and where you would like this opt-in message to be shown. opt-in is also available as a <a target="_blank" href="%s">Widget</a>.', Opt_In::TEXT_DOMAIN), $widgets_page_url ); ?></p>

	<p><?php printf( __('To embed this opt-in inside your content, please use this shortcode: <span id="wpoi_shortcode_is">[%s id="{{shortcode_id}}"]</span>', Opt_In::TEXT_DOMAIN ), Opt_In_Front::SHORTCODE );?></p>
</script>
<script id="wpoi-wizard-settings_template" type="text/template">

	<div class="row">

		<div class="wpoi-message" id="wpoi-wizard-settings-widget-message"></div>

	</div>

	<div class="row dev-box-gem">

		<ul class="accordion">

			<li>

				<div class="wpoi-listing-wrap" id="wpoi-listing-wrap-after_content">

					<header class="can-open display-settings-icon">

						<h2 class="tl icon after-c after_content">
							<?php _e('AFTER CONTENT', Opt_In::TEXT_DOMAIN); ?>

							<span class="tooltip-left wpoi-tooltip" tooltip="<?php _e('Will look for the_content of post/page and place the Opt-In afterwards', Opt_In::TEXT_DOMAIN) ?>"><span class="dashicons dashicons-editor-help  wpoi-icon-info" ></span></span>

						</h2>

						<div class="wpoi-toggle-mask">

							<div class="wpoi-toggle-mask-element">

								<div class="wpoi-toggle-block<# if( !_.isTrue(after_content.enabled) ){ #> inactive <# } #>">

									<p><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></p>

									<span class="toggle">

										<input id="wpoi-after-content-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-after-content-state-toggle" data-attribute="after_content.enabled" data-type="after-content" {{_.checked(after_content.enabled, true)}}>

										<label class="toggle-label" for="wpoi-after-content-state-toggle"></label>

									</span>

								</div>

							</div>

							<div class="wpoi-toggle-mask-element">

								<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>

							</div>

						</div>

					</header>

					<section>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Categories", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block after_content_show_on_all_cats_block">
												<input type="radio" id="optin-afterc-categories-all"  name="optin-afterc-categories" data-attribute="after_content.show_on_all_cats" {{_.checked( after_content.show_on_all_cats, true ) }} value="true" >
												<label for="optin-afterc-categories-all">
													<?php _e("Show for <strong>all categories</strong> except <span>(leave blank for all categories)</span>", Opt_In::TEXT_DOMAIN); ?>
												</label>

											</div>
											<#  if( _.isTrue( after_content.show_on_all_cats ) ) { #>
												<span class="wpoi-element-block-seletable-tags after_content_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="after_content_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<#  } #>
											<div class="wpoi-element-block after_content_show_on_all_cats_block">

												<input type="radio" id="optin-afterc-categories-selected" data-attribute="after_content.show_on_all_cats" name="optin-afterc-categories"  {{_.checked( after_content.show_on_all_cats, false ) }} value="false" >
												<label for="optin-afterc-categories-selected"><?php _e("Show for selected categories only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<#  if( !_.isTrue( after_content.show_on_all_cats ) ) { #>
												<span class="wpoi-element-block-seletable-tags after_content_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="after_content_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<#  } #>
										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Tags", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block after_content_show_on_all_tags_block">

												<input type="radio" id="optin-afterc-tags-all" name="optin-afterc-tags" data-attribute="after_content.show_on_all_tags" {{_.checked( after_content.show_on_all_tags, true ) }} value="true">
												<label for="optin-afterc-tags-all">
													<?php _e("Show for <strong>all tags</strong> except <span>(leave blank for all tags)</span>:", Opt_In::TEXT_DOMAIN); ?>
												</label>

											</div>
											<#  if( _.isTrue( after_content.show_on_all_tags ) ) { #>
												<span class="wpoi-element-block-seletable-tags after_content_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="after_content_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<#  } #>
											<div class="wpoi-element-block after_content_show_on_all_tags_block">

												<input type="radio" id="optin-afterc-tags-selected" name="optin-afterc-tags" data-attribute="after_content.show_on_all_tags"  {{_.checked( after_content.show_on_all_tags, false ) }} value="false">
												<label for="optin-afterc-tags-selected"><?php _e("Show for selected tags only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<#  if( !_.isTrue( after_content.show_on_all_tags ) ) { #>
												<span class="wpoi-element-block-seletable-tags after_content_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="after_content_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<#  } #>
										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Posts", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="after_content_selected_post_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select post exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu"  id="after_content_selected_post" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only posts that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Pages", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="after_content_selected_pages_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select page exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="after_content_selected_pages" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only pages that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("After Content Opt-In Animation", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<input type="radio" id="optin-afterc-animation-off" name="optin-afterc-animation" data-attribute="after_content.animate" {{_.checked( after_content.animate, false )}} value="false" >
												<label for="optin-afterc-animation-off"><?php _e("No animation, opt-in is always visible", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<div class="wpoi-element-block">

												<input type="radio" id="optin-afterc-animation-on" name="optin-afterc-animation" data-attribute="after_content.animate" {{_.checked( after_content.animate, true )}} value="true" >

												<label for="optin-afterc-animation-on"><?php _e("Play this animation when user reaches opt-in area:", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

										</div>

										<div class="wpoi-element-block <# if( !_.isTrue( after_content.animate )) { #> hidden <# } #>" id="optin-afterc-animation-block" >
											<select name="optin-afterc-animation" id="optin-afterc-animation" data-attribute="after_content.animation"  >

												<?php foreach( $animations->in as $key => $group ): ?>

													<optgroup label="<?php echo $key ?>">

														<?php foreach( $group as $animate_key => $animation ): ?>

																<option {{_.selected( after_content.animation, '<?php echo $animate_key; ?>' )}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
															<?php endforeach; ?>

													</optgroup>

												<?php endforeach; ?>

											</select>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half"></div>

						</div>

					</section>

				</div>

			</li><!-- End After Content Settings -->

			<li>

				<div class="wpoi-listing-wrap" id="wpoi-listing-wrap-popup">

					<header class="can-open display-settings-icon">

						<h2 class="tl icon popup"><?php _e('Pop Up', Opt_In::TEXT_DOMAIN); ?></h2>

						<div class="wpoi-toggle-mask">

							<div class="wpoi-toggle-mask-element">

								<div class="wpoi-toggle-block <# if( !_.isTrue(popup.enabled) ){ #> inactive <# } #>">

									<p><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></p>

									<span class="toggle">

										<input id="wpoi-popup-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-popup-state-toggle" data-attribute="popup.enabled" data-type="popup"  {{_.checked(popup.enabled, true)}} >

										<label class="toggle-label" for="wpoi-popup-state-toggle"></label>

									</span>

								</div>

							</div>

							<div class="wpoi-toggle-mask-element">

								<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>

							</div>

						</div>

					</header>

					<section>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Categories", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block popup_show_on_all_cats_block">

												<input type="radio" id="optin-popup-categories-all" name="optin-popup-categories" data-attribute="popup.show_on_all_cats" {{_.checked( popup.show_on_all_cats, true ) }} value="true">
												<label for="optin-popup-categories-all"><?php _e("Show for <strong>all categories</strong> except <span>(leave blank for all categories)</span>:", Opt_In::TEXT_DOMAIN); ?></label>

											</div>
											<#  if( _.isTrue( popup.show_on_all_cats ) ) { #>
												<span class="wpoi-element-block-seletable-tags popup_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="popup_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
											<div class="wpoi-element-block popup_show_on_all_cats_block">

												<input type="radio" id="optin-popup-categories-selected" name="optin-popup-categories" data-attribute="popup.show_on_all_cats" {{_.checked( popup.show_on_all_cats, false ) }} value="false">
												<label for="optin-popup-categories-selected"><?php _e("Show for selected categories only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<#  if( !_.isTrue( popup.show_on_all_cats ) ) { #>
												<span class="wpoi-element-block-seletable-tags popup_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="popup_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Tags", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block popup_show_on_all_tags_block">

												<input type="radio" id="optin-popup-tags-all" name="optin-popup-tags" data-attribute="popup.show_on_all_tags" {{_.checked( popup.show_on_all_tags, true ) }} value="true">
												<label for="optin-popup-tags-all"><?php _e("Show for <strong>all tags</strong> except <span>(leave blank for all tags)</span>:", Opt_In::TEXT_DOMAIN); ?></label>

											</div>
											<#  if( _.isTrue( popup.show_on_all_tags ) ) { #>
												<span class="wpoi-element-block-seletable-tags popup_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="popup_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
											<div class="wpoi-element-block popup_show_on_all_tags_block">

												<input type="radio" id="optin-popup-tags-selected" name="optin-popup-tags" data-attribute="popup.show_on_all_tags" {{_.checked( popup.show_on_all_tags, false ) }} value="false">
												<label for="optin-popup-tags-selected"><?php _e("Show for selected tags only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<#  if( !_.isTrue( popup.show_on_all_tags ) ) { #>
												<span class="wpoi-element-block-seletable-tags popup_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="popup_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Posts", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="popup_selected_post_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select post exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="popup_selected_post" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only posts that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Pages", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="popup_selected_pages_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select page exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="popup_selected_pages" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only pages that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="accordion-block">

								<header>

									<h6 class="tl"><?php _e("Popup Opt-In Animation", Opt_In::TEXT_DOMAIN); ?></h6>

								</header>

								<section>

									<div class="row">

										<div class="col-half">

											<div class="wpoi-wrapper">

												<label><?php _e("Show Popup Animation:", Opt_In::TEXT_DOMAIN); ?></label>

												<select data-attribute="popup.animation_in">
													<?php foreach( $animations->in as $key => $group ): ?>
														<optgroup label="<?php echo $key ?>">
															<?php foreach( $group as $animate_key => $animation ): ?>
																<option {{_.selected(popup.animation_in, "<?php echo $animate_key; ?>")}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
															<?php endforeach; ?>
														</optgroup>

													<?php endforeach; ?>
												</select>

											</div>

										</div>

										<div class="col-half">

											<div class="wpoi-wrapper">

												<label><?php _e("Hide Popup Animation:", Opt_In::TEXT_DOMAIN); ?></label>


												<select data-attribute="popup.animation_out" >
													<?php foreach( $animations->out as $key => $group ): ?>
														<optgroup label="<?php echo $key ?>">
															<?php foreach( $group as $animate_key => $animation ): ?>
																<option {{_.selected(popup.animation_out, "<?php echo $animate_key; ?>")}} value="<?php echo $animate_key ?>"><?php echo $animation ?></option>
															<?php endforeach; ?>
														</optgroup>

													<?php endforeach; ?>

												</select>


											</div>

										</div>

									</div>

								</section>

							</div>

						</div>

						<div class="row white w-border">

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl">
											<?php _e("Popup trigger conditions", Opt_In::TEXT_DOMAIN); ?>
										</h6>
										<p class=""><?php _e("Popup can be triggered after a certain amount of <strong>Time</strong>, when user <strong>Scrolls</strong> pass an element, on <strong>Click</strong>, if user tries to <strong>Leave</strong> or if we detect <strong>AdBlock</strong>
", Opt_In::TEXT_DOMAIN); ?></p>

									</header>

									<section class="triggers-section triggers-section-popup" id="triggers-section-popup"></section>

								</div>

							</div>

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Never see this message again settings", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block one-line">

												<input type="checkbox" id="popup_add_never_see_this_message" name=""  {{_.checked(popup.add_never_see_this_message, true)}} data-attribute="popup.add_never_see_this_message">

												<label for="popup_add_never_see_this_message"><?php _e("Add 'Never see this message again' link", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<div class="wpoi-element-block one-line">

												<input type="checkbox" id="popup_close_button_acts_as_never_see_again" name="" value="true" {{_.checked(popup.close_button_acts_as_never_see_again, true)}} data-attribute="popup.close_button_acts_as_never_see_again">

												<label for="popup_close_button_acts_as_never_see_again"><?php _e("Close button acts as 'Never see this message again' link", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<div class="wpoi-element-block one-line">

												<label><?php _e("Expiry time", Opt_In::TEXT_DOMAIN); ?></label>

												<input type="number" min="0" value="{{popup.never_see_expiry}}" data-attribute="popup.never_see_expiry">

												<label><?php _e("days (upon expiry, user will see the Pop Up again)", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="accordion-block">

								<header>

									<h6 class="tl"><?php _e("Displaying Conditions", Opt_In::TEXT_DOMAIN); ?></h6>

								</header>

								<section>

									<div class="wpoi-conditions-wrap" id="wpoi-conditions-wrap-popup">

										<div class="wpoi-conditions-block wpoi-conditions-available">

											<label><?php _e("Available Conditions", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-conditions-list-handles"></div>


										</div>

										<div class="wpoi-conditions-block wpoi-conditions-met">

											<label><?php _e("Show this Pop Up if the following conditions are met:", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-condition-items"></div>

										</div>

									</div>

								</section>

							</div>

						</div>

					</section>

				</div>

			</li><!-- End Pop Up Settings -->

			<li>

				<div class="wpoi-listing-wrap" id="wpoi-listing-wrap-slide_in">

					<header class="can-open display-settings-icon">

						<h2 class="tl icon slidein slide_in"><?php _e('Slide In', Opt_In::TEXT_DOMAIN); ?></h2>

						<div class="wpoi-toggle-mask">

							<div class="wpoi-toggle-mask-element">

								<div class="wpoi-toggle-block <# if( !_.isTrue(slide_in.enabled) ){ #> inactive <# } #>">

									<p><?php _e('Inactive', Opt_In::TEXT_DOMAIN); ?></p>

									<span class="toggle">

										<input id="wpoi-slide-in-state-toggle" class="toggle-checkbox" type="checkbox" name="wpoi-slide-in-state-toggle" data-attribute="slide_in.enabled" data-type="slidein"  {{_.checked(slide_in.enabled, true)}}>

										<label class="toggle-label" for="wpoi-slide-in-state-toggle"></label>

									</span>

								</div>

							</div>

							<div class="wpoi-toggle-mask-element">

								<span class="open"><i class="dev-icon dev-icon-caret_down"></i></span>

							</div>

						</div>

					</header>

					<section>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Categories", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block slide_in_show_on_all_cats_block">

												<input type="radio" id="optin-slidein-categories-all" name="optin-slidein-categories" data-attribute="slide_in.show_on_all_cats" {{_.checked( slide_in.show_on_all_cats, true ) }} value="true" >
												<label for="optin-slidein-categories-all">
													<?php _e("Show for <strong>all categories</strong> except <span>(leave blank for all categories)</span>:", Opt_In::TEXT_DOMAIN); ?>
												</label>

											</div>
											<#  if( _.isTrue( slide_in.show_on_all_cats) ) { #>
												<span class="wpoi-element-block-seletable-tags slide_in_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="slide_in_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
											<div class="wpoi-element-block slide_in_show_on_all_cats_block">

												<input type="radio" id="optin-slidein-categories-selected" name="optin-slidein-categories" data-attribute="slide_in.show_on_all_cats" {{_.checked( slide_in.show_on_all_cats, false ) }} value="false">
												<label for="optin-slidein-categories-selected"><?php _e("Show for selected categories only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<#  if( !_.isTrue( slide_in.show_on_all_cats) ) { #>
												<span class="wpoi-element-block-seletable-tags slide_in_show_on_all_cats_block_select_wrap">
													<select class="none-wpmu" id="slide_in_selected_cats" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select categories", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Tags", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block slide_in_show_on_all_tags_block">

												<input type="radio" id="optin-slidein-tags-all" name="optin-slidein-tags"  data-attribute="slide_in.show_on_all_tags" {{_.checked( slide_in.show_on_all_tags, true ) }} value="true">
												<label for="optin-slidein-tags-all"><?php _e("Show for <strong>all tags</strong> except <span>(leave blank for all tags)</span>:", Opt_In::TEXT_DOMAIN); ?></label>

											</div>
											<#  if( _.isTrue( slide_in.show_on_all_tags) ) { #>
												<span class="wpoi-element-block-seletable-tags slide_in_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="slide_in_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>
											<div class="wpoi-element-block slide_in_show_on_all_tags_block">

												<input type="radio" id="optin-slidein-tags-selected" name="optin-slidein-tags" data-attribute="slide_in.show_on_all_tags" {{_.checked( slide_in.show_on_all_tags, false ) }} value="false">
												<label for="optin-slidein-tags-selected"><?php _e("Show for selected tags only", Opt_In::TEXT_DOMAIN); ?></label>

											</div>
											<#  if( !_.isTrue( slide_in.show_on_all_tags) ) { #>
												<span class="wpoi-element-block-seletable-tags slide_in_show_on_all_tags_block_select_wrap">
													<select class="none-wpmu" id="slide_in_selected_tags" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select tags", Opt_In::TEXT_DOMAIN); ?>"></select>
												</span>
											<# } #>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row w-border">

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Posts", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="slide_in_selected_post_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select post exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these posts", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="slide_in_selected_post" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only posts that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half w-border">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Pages", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Do not show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="slide_in_selected_pages_exceptions" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select page exceptions that won't have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

											<div class="wpoi-element-block">

												<label><?php _e("<strong>Show</strong> for these pages", Opt_In::TEXT_DOMAIN); ?></label>
												<select class="none-wpmu" id="slide_in_selected_pages" multiple="multiple"  data-placeholder="<?php esc_attr_e("Select the only pages that will have Opt-In", Opt_In::TEXT_DOMAIN); ?>"></select>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Slide In Trigger Conditions", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section class="triggers-section triggers-section-slide_in" id="triggers-section-slide_in"></section>

								</div>

							</div>

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("After user closes Slide In", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block one-line">

												<input type="radio" id="wpoi-slidein-keep-showing" name="wpoi-slidein-close" value="keep_showing" data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'keep_showing') }} >

												<label for="wpoi-slidein-keep-showing"><?php _e("Keep showing this message to user", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<div class="wpoi-element-block one-line">

												<input type="radio" id="wpoi-slidein-noshow" name="wpoi-slidein-close" value="no_show" data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'no_show') }} >

												<label for="wpoi-slidein-noshow"><?php _e("No longer show message on this post / page", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

											<div class="wpoi-element-block one-line">

												<input type="radio" id="wpoi-slidein-hide" name="wpoi-slidein-close"  value="hide_all"  data-attribute="slide_in.after_close" {{ _.checked(slide_in.after_close, 'hide_all') }} >

												<label for="wpoi-slidein-hide"><?php _e("Hide all slide in messages for user", Opt_In::TEXT_DOMAIN); ?></label>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Message Position", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section id="wpoi-slidein-position">

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block one-line">

												<label id="wpoi-slide_in-position-label">{{slide_in.position_label}}</label>

												<div class="wpoi-position-block">

													<div class="wpoi-position-block-header">

														<span class="wpoi-pb-header-button"></span>

														<span class="wpoi-pb-header-button"></span>

														<span class="wpoi-pb-header-button"></span>

													</div>

													<div class="wpoi-position-block-section">

														<input class="wpoi-pb-top-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_left" {{_.checked( slide_in.position, 'top_left' )}} >

														<input class="wpoi-pb-top-center" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_center" {{_.checked( slide_in.position, 'top_center' )}} >

														<input class="wpoi-pb-top-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="top_right" {{_.checked( slide_in.position, 'top_right' )}} >

														<input class="wpoi-pb-center-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="center_right" {{_.checked( slide_in.position, 'center_right' )}}  >

														<input class="wpoi-pb-bottom-right" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_right" {{_.checked( slide_in.position, 'bottom_right' )}} >

														<input class="wpoi-pb-bottom-center" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_center" {{_.checked( slide_in.position, 'bottom_center' )}} >

														<input class="wpoi-pb-bottom-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="bottom_left" {{_.checked( slide_in.position, 'bottom_left' )}} >

														<input class="wpoi-pb-center-left" type="radio" name="wpoi-slide_in-position" data-attribute="slide_in.position" value="center_left" {{_.checked( slide_in.position, 'center_left' ) }}  >

													</div>

												</div>

											</div>

										</div>

									</section>

								</div>

							</div>

							<div class="col-half">

								<div class="accordion-block">

									<header>

										<h6 class="tl"><?php _e("Message Auto Hide", Opt_In::TEXT_DOMAIN); ?></h6>

									</header>

									<section>

										<div class="wpoi-wrapper">

											<div class="wpoi-element-block one-line">

												<input type="checkbox" {{ _.checked(slide_in.hide_after, true) }} data-attribute="slide_in.hide_after" value="true">

												<label><?php _e("Automatically hide message after", Opt_In::TEXT_DOMAIN); ?></label>

												<input min="0" type="number" value="{{slide_in.hide_after_val}}" data-attribute="slide_in.hide_after_val">

												<select data-attribute="slide_in.hide_after_unit">
													<option value="seconds" {{ _.selected( slide_in.hide_after_unit, 'seconds' ) }}  ><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
													<option value="minutes" {{ _.selected( slide_in.hide_after_unit, 'minutes' ) }} ><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
													<option value="hours" {{ _.selected( slide_in.hide_after_unit, 'hours' ) }} ><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
												</select>

											</div>

										</div>

									</section>

								</div>

							</div>

						</div>

						<div class="row white w-border">

							<div class="accordion-block">

								<header>

									<h6 class="tl"><?php _e("Displaying Conditions", Opt_In::TEXT_DOMAIN); ?></h6>

								</header>

								<section>

									<div class="wpoi-conditions-wrap" id="wpoi-conditions-wrap-slide_in">

										<div class="wpoi-conditions-block wpoi-conditions-available">

											<label><?php _e("Available Conditions", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-conditions-list-handles"></div>


										</div>

										<div class="wpoi-conditions-block wpoi-conditions-met">

											<label><?php _e("Show this Slide In if the following conditions are met:", Opt_In::TEXT_DOMAIN); ?></label>

											<div class="wpoi-conditions-list wpoi-condition-items"></div>

										</div>

									</div>

								</section>

							</div>

						</div>
					</section>

				</div>

			</li><!-- End Slide In Settings -->

		</ul>

	</div>

	<div class="row">

		<p class="next-button"><a class="button button-dark-blue previous" href=""><?php _e('PREVIOUS', Opt_In::TEXT_DOMAIN); ?></a> <a  data-nonce="<?php echo wp_create_nonce('inc_opt_save'); ?>" class="button button-dark-blue next" href="#" data-id="<?php echo isset( $_GET['optin'] ) ? (int) $_GET['optin'] : -1; ?>" ><?php _e('NEXT', Opt_In::TEXT_DOMAIN); ?></a></p>

	</div>

</script>

<script id="wpoi-wizard-settings-triggers-template" type="text/template">
	<div class="wpoi-wrapper">

		<ul class="wpoi-triggers-tabs">
			<li class="<# if( appear_after === 'time' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-time" for="wpoi-{{type}}-appear_after_time">
					<input type="radio" class="wpoi-display-trigger-radio" name="wpoi-{{type}}-appear_after" id="wpoi-{{type}}-appear_after_time" data-attribute="{{type}}.appear_after" value="time" {{_.checked(appear_after, "time" )}} >
					<?php _e("Time", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'scrolled' ){ #>current<# } #>" >
				<label href="#wpoi-triggers-{{type}}-scroll" for="wpoi-{{type}}-appear_after_scrolled">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" id="wpoi-{{type}}-appear_after_scrolled"  data-attribute="{{type}}.appear_after" value="scrolled" {{_.checked(appear_after, "scrolled" )}} >
					<?php _e("Scroll", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'click' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-click" for="wpoi-{{type}}-appear_after_click">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" id="wpoi-{{type}}-appear_after_click" data-attribute="{{type}}.appear_after" value="click" {{_.checked(appear_after, "click" )}} >
					<?php _e("Click", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>

			<li class="<# if( appear_after === 'exit_intent' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-exit_intent" for="wpoi-{{type}}-appear_after_exit_intent">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" data-attribute="{{type}}.appear_after" id="wpoi-{{type}}-appear_after_exit_intent" value="exit_intent" {{_.checked(appear_after, "exit_intent" )}} >
					<?php _e("Exit Intent", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>
			<li class="<# if( appear_after === 'adblock' ){ #>current<# } #>">
				<label href="#wpoi-triggers-{{type}}-adblock" for="wpoi-{{type}}-appear_after_adblock">
					<input type="radio" name="wpoi-{{type}}-appear_after" class="wpoi-display-trigger-radio" data-attribute="{{type}}.appear_after" id="wpoi-{{type}}-appear_after_adblock" value="adblock" {{_.checked(appear_after, "adblock" )}} >
					<?php _e("AdBlock Use", Opt_In::TEXT_DOMAIN) ?>
				</label>
			</li>

		</ul>
		<div class="wpoi-triggers-tab-contents">

			<!-- Time -->
			<div id="wpoi-triggers-{{type}}-time" class="wpoi-triggers-tab-content<# if( appear_after === 'time' ){ #> current<# } #>">
				<div class="wpoi-element-block one-line">
					<input type="radio" id="wpoi-{{type}}-trigger_on_time_immediately" value="immediately" name="wpoi-{{type}}-trigger_on_time" data-attribute="{{type}}.trigger_on_time" {{_.checked(trigger_on_time, "immediately" )}}>
					<label for="wpoi-{{type}}-trigger_on_time_immediately"><?php _e("Trigger immediately", Opt_In::TEXT_DOMAIN); ?></label>
				</div>

				<div class="wpoi-element-block one-line">
					<input type="radio" id="wpoi-{{type}}-trigger_on_time_time" value="time" name="wpoi-{{type}}-trigger_on_time" data-attribute="{{type}}.trigger_on_time" {{_.checked(trigger_on_time, "time" )}}>
					<label for="wpoi-{{type}}-trigger_on_time_time"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<input min="0" type="number" name="" value="{{appear_after_time_val}}"  data-attribute="{{type}}.appear_after_time_val">
					<select data-attribute="{{type}}.appear_after_time_unit">
						<option {{_.selected(appear_after_time_unit, "seconds")}} value="seconds"><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
						<option {{_.selected(appear_after_time_unit, "minutes")}} value="minutes"><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(appear_after_time_unit, "hours")}}  value="hours"><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
					</select>
				</div>

			</div>

			<!-- Scroll -->
			<div id="wpoi-triggers-{{type}}-scroll" class="wpoi-triggers-tab-content<# if( appear_after === 'scrolled' ){ #> current<# } #>">
				<div class="wpoi-element-block one-line">
					<input type="radio" id="wpoi-{{type}}-appear-scrolled" value="scrolled" name="wpoi-{{type}}-appear" data-attribute="{{type}}.appear_after_scroll" {{_.checked(appear_after_scroll, "scrolled")}}>

					<label for="wpoi-{{type}}-appear-scrolled"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<input min="0" type="number" max="100" name="" value="{{appear_after_page_portion_val}}"  data-attribute="{{type}}.appear_after_page_portion_val">

					<label for="wpoi-{{type}}-appear-scrolled"><?php _e("% of the page has been scrolled", Opt_In::TEXT_DOMAIN); ?></label>
				</div>
				<div class="wpoi-element-block">

					<div class="row">

						<input type="radio" id="wpoi-{{type}}-appear-selector" name="wpoi-{{type}}-appear" value="selector" data-attribute="{{type}}.appear_after_scroll" {{_.checked(appear_after_scroll, "selector")}}>

						<label for="wpoi-{{type}}-appear-selector"><?php _e("Appear after user scrolled past a CSS selector", Opt_In::TEXT_DOMAIN); ?></label>

					</div>

					<input type="text" value="{{appear_after_element_val}}" data-attribute="{{type}}.appear_after_element_val">

				</div>
			</div>

			<!-- Click -->
			<div id="wpoi-triggers-{{type}}-click" class="wpoi-triggers-tab-content<# if( appear_after === 'click' ){ #> current<# } #>"">
				<p>
					<?php _e("Use shortcode to render clickable button"); ?>
				</p>
				<div class="wpoi-element-block">
					<div id="wpoi_clickable_shortcode">[wd_hustle id={{shortcode_id}} type={{type}}]<?php _e("Click here", Opt_In::TEXT_DOMAIN) ?>[/wd_hustle]</div>
				</div>

				<div class="wpoi-element-block">

					<p>
						<label for="wpoi-{{type}}-click-selector"><?php _e("Trigger after user clicks on existing element with this ID or Class", Opt_In::TEXT_DOMAIN); ?></label>
					</p>

					<input type="text" id="wpoi-{{type}}-click-selector" value="{{trigger_on_element_click}}" data-attribute="{{type}}.trigger_on_element_click" placeholder="<?php esc_attr_e('only use .class or #ID selector', Opt_In::TEXT_DOMAIN); ?>">

				</div>
			</div>

			<!-- Exit -->
			<div id="wpoi-triggers-{{type}}-exit_intent" class="wpoi-triggers-tab-content<# if( appear_after === 'exit_intent' ){ #> current<# } #>"">
				<div class="wpoi-element-block one-line">
					<label class="" for="wpoi-{{type}}-trigger-exit"><?php _e("Trigger when exit intent is detected", Opt_In::TEXT_DOMAIN); ?></label>
					<span class="toggle">
						<input id="wpoi-{{type}}-trigger-exit" class="toggle-checkbox" type="checkbox" data-attribute="{{type}}.trigger_on_exit"  {{_.checked(trigger_on_exit, true)}}  >
						<label class="toggle-label" for="wpoi-{{type}}-trigger-exit"></label>
					</span>
				</div>
			</div>

			<!-- AdBlock -->
			<div id="wpoi-triggers-{{type}}-adblock" class="wpoi-triggers-tab-content<# if( appear_after === 'adblock' ){ #> adblock<# } #>"">
				<div class="wpoi-element-block one-line">
					<label class="" for="wpoi-{{type}}-trigger-on-adblock"><?php _e("Trigger when AdBlock is detected", Opt_In::TEXT_DOMAIN); ?></label>
					<span class="toggle">
						<input id="wpoi-{{type}}-trigger-on-adblock" class="toggle-checkbox" type="checkbox" data-attribute="{{type}}.trigger_on_adblock"  {{_.checked(trigger_on_adblock, true)}}  >
						<label class="toggle-label" for="wpoi-{{type}}-trigger-on-adblock"></label>
					</span>
				</div>

				<div class="wpoi-element-block one-line wpoi-popup-trigger-on-adblock-option">
					<input type="radio" id="wpoi-{{type}}-trigger-on-adblock-immediately" value="false" name="wpoi-{{type}}-trigger-on-adblock-timed" data-attribute="{{type}}.trigger_on_adblock_timed" {{_.checked(trigger_on_adblock_timed, false )}}>
					<label for="wpoi-{{type}}-trigger-on-adblock-immediately"><?php _e("Trigger immediately", Opt_In::TEXT_DOMAIN); ?></label>

				</div>

				<div class="wpoi-element-block one-line wpoi-popup-trigger-on-adblock-option">
					<input type="radio" id="wpoi-{{type}}-trigger-on-adblock-timed" value="true" name="wpoi-{{type}}-trigger-on-adblock-timed" data-attribute="{{type}}.trigger_on_adblock_timed" {{_.checked(trigger_on_adblock_timed, true )}}>

					<label for="wpoi-{{type}}-trigger-on-adblock-timed"><?php _e("Trigger after", Opt_In::TEXT_DOMAIN); ?></label>
					<input min="0" type="number" name="" class="wpoi_trigger_on_adblock_timed_val" value="{{trigger_on_adblock_timed_val}}"  data-attribute="{{type}}.trigger_on_adblock_timed_val">
					<select data-attribute="{{type}}.trigger_on_adblock_timed_unit" class="wpoi_trigger_on_adblock_timed_unit">
						<option {{_.selected(trigger_on_adblock_timed_unit, "seconds")}} value="seconds"><?php _e("Seconds", Opt_In::TEXT_DOMAIN); ?></option>
						<option {{_.selected(trigger_on_adblock_timed_unit, "minutes")}} value="minutes"><?php _e("Minutes", Opt_In::TEXT_DOMAIN) ?></option>
						<option {{_.selected(trigger_on_adblock_timed_unit, "hours")}}  value="hours"><?php _e("Hours", Opt_In::TEXT_DOMAIN); ?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
</script>