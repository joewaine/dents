<div class="wpmud">

	<div id="container" class="wrap">

		<header id="header">

			<h1 class="main-title-alternative"><?php _e('HUSTLE DASHBOARD', Opt_In::TEXT_DOMAIN); ?></h1>

		</header>

		<section>

			<div class="row">

				<section id="wpoi-box-dashboard-welcome" class="dev-box can-close content-box">

					<div class="box-title">

						<h3 class="title-alternative"><?php _e('Welcome', Opt_In::TEXT_DOMAIN); ?></h3>

						<span class="close"></span>

					</div>

					<div class="box-content wpoi-content-box">

						<div class="wpoi-float wpoi-float-left wpoi-float-left-image-bottom">

							<img class="wpoi-superhero" src="<?php echo Opt_In::$plugin_url ?>assets/img/superhero.png" width="324" height="446" />

						</div>

						<div class="wpoi-float wpoi-float-left">

							<div class="wpoi-entry-content wpoi-entry-content-left">

								<h2><?php _e('LET’S HUSTLE UP SOME SUBSCRIBERS', Opt_In::TEXT_DOMAIN); ?></h2>

								<p>
									<?php printf( __('Congratulations, %s! You’ve just installed Hustle, hands-down the easiest to use email opt-in plugin for WordPress. With Hustle you can choose from dozens of design options and layouts – and create slick-looking opt-ins that are so irresistible your visitors will be throwing their emails at you.', Opt_In::TEXT_DOMAIN), $user_name); ?>
								</p>

								<p>
									<?php _e('Let’s get down to business.', Opt_In::TEXT_DOMAIN); ?>
								</p>
							</div>

						</div>

					</div>

				</section>

			</div>

			<div class="row">

				<section class="col-half">

					<div id="wpoi-box-dashboard-optins" class="dev-box content-box">

						<div class="box-title">

							<h3 class="title-alternative"><?php _e('Active Opt-Ins', Opt_In::TEXT_DOMAIN); ?></h3>

						</div>

						<div class="box-content">

							<div class="wpoi-entry-content wpoi-entry-content-center">

								<p><?php _e('You don\'t have any active Opt-Ins so why not create one right now?', Opt_In::TEXT_DOMAIN); ?></p>

								<p><a class="button button-dark-blue" href="admin.php?page=inc_optin"><?php _e('Create Your First Opt-In', Opt_In::TEXT_DOMAIN); ?></a></p>

							</div>

						</div>

					</div>

				</section>

				<section class="col-half">

					<div id="wpoi-box-dashboard-optins" class="dev-box content-box">

						<div class="box-title">

							<h3 class="title-alternative"><?php _e('Conversion Data', Opt_In::TEXT_DOMAIN); ?></h3>

						</div>

						<div class="box-content">

							<div class="wpoi-entry-content wpoi-entry-content-center">

								<p><?php _e('No data available yet. <br/> You need to create and activate at least one Opt-In to begin collecting conversion data.', Opt_In::TEXT_DOMAIN); ?></p>

							</div>

						</div>

					</div>

				</section>

			</div>

		</section>

	</div>

</div>