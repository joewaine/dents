<?php
/**
 *
 * The admin-view functionality of the plugin.
 *
 * @since      	1.0.0
 * @package    	hayyabuild
 * @subpackage 	hayyabuild/admin
 * @author     	zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }


class HayyaView {

    /**
     * Define the view for forntend.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @access		public
     * @since		1.0.0
     * @var			unown
     */
    public function __construct() {}


    /**
     *
     * @param unknown $message
     */
    public static function helpTip ($message = NULL) {
    	if ( !empty($message) ) {
    		echo '<span class="help-tip" style="margin-top: 15px;"><i class="hb_helper">'.__($message, HAYYAB_BASENAME).'</i></span>';
    	} else return false;
    }

    /**
     *
     * Show empty list message
     *
     * @param unknown $showButtns
     * @param unknown $mainList
     */
    public static function emptyList ( $showButtns = NULL, $mainList = NULL ) { ?>
    	<div class="hayya_card-panel">
			<span>
				<?php
				_e('This list is empty!',HAYYAB_BASENAME );
				if ( $mainList ) {
					echo '<br/>';
					_e('Your Headers and Footers will appear here',HAYYAB_BASENAME );
				}
				if ( $showButtns) :?>
					<br/>
					<a href="admin.php?page=hayyabuild_addh" class="waves-effect waves-light hayya_btn"><i class="fa fa-plus"></i> New Header</a>
					<a href="admin.php?page=hayyabuild_addc" class="waves-effect waves-light hayya_btn"><i class="fa fa-plus"></i> New Content</a>
					<a href="admin.php?page=hayyabuild_addf" class="waves-effect waves-light hayya_btn"><i class="fa fa-plus"></i> New Footer</a>
					<a href="admin.php?page=hayyabuild&amp;section=templates" class="waves-effect waves-light hayya_btn"><i class="fa fa-th-large"></i> templates</a>
				<?php endif;?>
			</span>
		</div> <?php
    }

    /**
     *
     * Show NavBar
     *
     */
    public static function navBar ( $main = NULL ) { ?>
		<div class="row">
			<div class="col s12">

			    <div class="main_conf" style="padding-bottom: 20px;">
			          <img src="<?php echo HAYYAB_URL.'admin/assets/images/main_logo.png?v='.HAYYAB_VERSION;?>" style="width: 250px;height: auto;" />
	            	<?php if ($main) : ?>
	                <a class="right top dropdown-button cyan-text text-darken-2 hayya_btn-flat" href="#" data-activates="dropdown1" style="padding-bottom: 2px;border: nonea">
	                	<?php _e('Add New', HAYYAB_BASENAME); ?> <i class="fa fa-angle-down right"></i>
	                </a>
	                <?php else : ?>
	                <a href="admin.php?page=hayyabuild" class="right top dropdown-button cyan-text text-darken-2 hayya_btn-flat"  style="padding-bottom: 2px;border: none;">
	                    <i class="fa fa-angle-left left"></i> <?php _e('Back', HAYYAB_BASENAME); ?>
	                </a>
	                <?php endif; ?>
			   </div>
			    <?php if ( $main ) :?>
			    <ul id="dropdown1" class="dropdown-content">
			        <li class="active">
			            <a href="admin.php?page=hayyabuild_addh">
			                <?php _e('New Header', HAYYAB_BASENAME); ?>
			            </a>
			        </li>
			        <li class="active">
			            <a href="admin.php?page=hayyabuild_addc">
			                <?php _e('New Content', HAYYAB_BASENAME); ?>
			            </a>
			        </li>
			        <li class="active">
			            <a href="admin.php?page=hayyabuild_addf">
			                <?php _e('New Footer', HAYYAB_BASENAME); ?>
			            </a>
			        </li>
			        <li class="active">
			            <a href="admin.php?page=hayyabuild&amp;section=templates">
			            	<?php _e('New from Template', HAYYAB_BASENAME); ?>
			            </a>
			        </li>
			    </ul>
			    <?php endif;?>
			</div>
		</div><?php
    }

    /**
     *
     * Show emprt form
     *
     */
    public static function importForm () { ?>
		<ul class="collapsible" data-collapsible="accordion">
		    <li>
				<div class="collapsible-header">
					<i class="fa fa-mail-forward"></i>
					<?php _e( 'Import HayyaBuild Content', HAYYAB_BASENAME);?>
				</div>
				<div class="collapsible-body" style="padding: 5px 15px;">
					<form method="post" action="" enctype="multipart/form-data">
						<div class="file-field input-field">
							<button class="waves-effect waves-light hayya_btn" type="submit" name="import_btn" value="import_btn" style="margin-right: 10px;margin-top: 5px;">
								<?php _e('Import', HAYYAB_BASENAME); ?>
						  	</button>
							<span class="hayya_btn" style="margin-top: 5px;">
								<span><?php _e('File', HAYYAB_BASENAME); ?></span>
								<input type="file" name="import" class="form-control" accept=".json" multiple>
							</span>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" style="font-size: 15px;">
							</div>
						</div>
						<div class="switch">
						    <span style="padding: 15px 15px 15px 0px;display: inline-block;"><?php _e('Include pages list', HAYYAB_BASENAME); ?></span>
	                        <label>
	                          <?php _e('No', HAYYAB_BASENAME); ?>
	                          <input type="checkbox" name="pages" value="pages" checked="checked">
	                          <span class="lever"></span>
	                          <?php _e('Yes', HAYYAB_BASENAME); ?>
	                        </label>
	                        <?php self::helpTip('Don\'t Check this if you want to import data from anther wordpress site.<br/>You can change pages list at any time from builder page.'); ?>
	                    </div>
					</form>
				</div>
			</li>
		</ul>
    	<?php
	}

    /**
     * editor modal for builder page
     *
     * @param unknown
     */
    public static function addModal($elements_group = NULL) {
    	if ($elements_group && is_array($elements_group)) :
    	?>
    	<script type="text/html" id="hb_elements-modal">
    		<div id="hb_modal" class="modal fade hb_modal" role="dialog">
    		    <div class="modal-dialog modal-lg">
    				<div class="modal-content">
	    				<div class="modal-header">
    						<a href="#" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-angle-up"></i></a>
    						<h4 class="modal-title"><?php _e( 'Modules list', HAYYAB_BASENAME ); ?></h4>
							<ul class="nav nav-tabs">
								<li class="active"><a href="#hb_elements-tab-all" data-toggle="tab">All</a></li>
								<?php foreach ( $elements_group as $key => $value ) : ?>
								<li><a href="#hb_elements-tab-<?php echo $key;?>" data-toggle="tab"><?php echo $key;?></a></li>
								<?php endforeach;?>
							</ul>
	    				</div>

    					<div class="modal-body" style="overflow-y: scroll;">
    						<div id="hb_elements-tabs">
    							<div class="tab-content" style="padding: 10px;">
	    							<div id="hb_elements-tab-all" class="tab-pane clearfix active">
    									<?php foreach ( $elements_group as $key => $value ) : ?>
    									<?php foreach ( $value as $element ) : ?>
    									<div class="well text-center text-overflow" data-hb_element="<?php echo $element['base'];?>">
											<div class="well-content">
    											<i class="<?php echo $element['icon'];?>"></i>
    											<div class="name"><?php echo $element['name'];?></div>
    											<div class="text-muted small"><?php echo $element['description'];?></div>
											</div>
    									</div>
	    								<?php endforeach;?>
    									<?php endforeach;?>
    									<!-- <div style="clear: both;"></div>-->
    									<?php $key = $value = $element = null;?>
    								</div>
    								<?php foreach ( $elements_group as $key => $value ) : ?>
   	 								<div id="hb_elements-tab-<?php echo $key;?>" class="tab-pane clearfix">
   	 									<?php foreach ( $value as $element ) : ?>
   	 									<div class="well text-center text-overflow" data-hb_element="<?php echo $element['base'];?>">
											<div class="well-content">
    											<i class="<?php echo $element['icon'];?>"></i>
    											<div class="name"><?php echo $element['name'];?></div>
    											<div class="text-muted small"><?php echo $element['description'];?></div>
											</div>
    									</div>
    									<?php endforeach;?>
    								</div>
    								<?php endforeach;?>
    							</div>
    						</div>
    					</div>
    				</div>
	    	    </div>
    		</div>
	    </script>
    	<?php
    	endif;
    }

    /**
     * editor modal for builder page
     *
     * @param unknown
     */
    public static function editorModal() {
    	?>
    	<script type="text/html" id="hb_edit_modal">
    		<div id="hb_modal" class="modal fade hb_modal" role="dialog">
    			<div class="modal-dialog modal-lg">
	    			<div class="modal-content">
    					<div class="modal-header">
    						<a href="#" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-angle-up"></i></a>
	    					<h4 class="modal-title"><%= hb.elementName %></h4>
							<ul class="nav nav-tabs">
							    <%= hb.tab_menu %>
							</ul>
    					</div>
	    				<div class="modal-body" style="overflow-y: scroll;">
    						<div id="hb_elements-tabs">
    							<div class="tab-content" style="padding: 10px;">
									<div id="hb_editor_tabs"></div>
								</div>
							</div>
    					</div>
	    				<div class="modal-footer">
    						<button type="button" class="hayya_btn btn-default" data-dismiss="modal">Close</button>
    						<button type="button" class="save hayya_btn btn-primary">Save changes</button>
	    				</div>
    				</div>
	    		</div>
    		</div>
	    </script>
    	<?php
    }


    /**
     * editor modal for builder page
     *
     * @param unknown
     */
    public static function classesModal() {
    	?>
    	<script type="text/html" id="hb_classes">
			<div id="classesslist" class="classeslist">
				<fieldset>
    				<legend><i class="fa fa-search-plus"></i> <?php _e( 'visibility Options', HAYYAB_BASENAME ); ?></legend>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="visible-xs-block" class="hayyaClassesList" value="visible-xs-block" name="visible-xs-block" <%= classes.Value['visible-xs-block'] %>/>
    						<label for="visible-xs-block"><?php _e( 'Visible on extra small devices, phones < 768px', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="visible-md-block" class="hayyaClassesList" value="visible-md-block" name="visible-md-block" <%= classes.Value['visible-md-block'] %>/>
    						<label for="visible-md-block"><?php _e( 'Visible on medium devices, desktops ≥ 992px', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="visible-sm-block" class="hayyaClassesList" value="visible-sm-block" name="visible-sm-block" <%= classes.Value['visible-sm-block'] %>/>
    						<label for="visible-sm-block"><?php _e( 'Visible on small devices, tablets ≥ 768px ', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="visible-lg-block" class="hayyaClassesList" value="visible-lg-block" name="visible-lg-block" <%= classes.Value['visible-lg-block'] %>/>
    						<label for="visible-lg-block"><?php _e( 'Visible on large devices, desktops ≥ 1200px', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hidden-xs" class="hayyaClassesList" value="hidden-xs" name="hidden-xs" <%= classes.Value['hidden-xs'] %>/>
    						<label for="hidden-xs"><?php _e( 'Hidden on extra small devices, phones < 768px', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hidden-md" class="hayyaClassesList" value="hidden-md" name="hidden-md" <%= classes.Value['hidden-md'] %>/>
    						<label for="hidden-md"><?php _e( 'Hidden on medium devices, desktops ≥ 992px', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hidden-sm" class="hayyaClassesList" value="hidden-sm" name="hidden-sm" <%= classes.Value['hidden-sm'] %>/>
    						<label for="hidden-sm"><?php _e( 'Hidden on small devices, tablets ≥ 768px', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hidden-lg" class="hayyaClassesList" value="hidden-lg" name="hidden-lg" <%= classes.Value['hidden-lg'] %>/>
    						<label for="hidden-lg"><?php _e( 'Hidden on large devices, desktops ≥ 1200px', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    		</fieldset>
    			<fieldset>
	    			<legend><i class="fa fa-angle-double-down"></i> <?php _e( 'Scroll Effects', HAYYAB_BASENAME ); ?></legend>
		   			<diV class="row" style="padding:0;margin:0;">
		   				<div class="col s3" style="padding-top:5px;">
				    		<?php _e( 'Select Effects Duration', HAYYAB_BASENAME ); ?>
			    		</div>
						<div class="col s4">
							<span class="range-field">
						   		<input class="hayyaClassesList" type="range" id="hb_duration" min="0" max="10" name="hb_duration" value="<%= classes.Value['hb_duration'] %>"/>
							</span>
						</div>
                        <div class="col s4">
                            <input type="checkbox" id="hb_unreverse_scroll" data-scrollefect="1" class="hayyaClassesList" value="hb_unreverse_scroll" name="hb_unreverse_scroll" <%= classes.Value['hb_unreverse_scroll'] %>/>
    						<label for="hb_unreverse_scroll"><?php _e( 'Unreverse Effects', HAYYAB_BASENAME ); ?></label>
						</div>
					</div>
                    <hr/>
                    <div class="row" style="padding:0;margin:0;">
                        <div class="col s3" style="padding-top:10px;">
                            <?php _e( 'Select Effects Easing', HAYYAB_BASENAME ); ?>
                        </div>
                        <div class="col s5">
                            <select id="hb_scroll_easing" name="hb_scroll_easing" class="hayyaClassesList select_modal select_material" data-value="<%= classes.Value['hb_scroll_easing'] %>">
                                <option value=""><?php _e( 'Select Easing', HAYYAB_BASENAME ); ?></option>
                                <option value="easeIn"><?php _e( 'EaseIn', HAYYAB_BASENAME ); ?></option>
                                <option value="easeInOut"><?php _e( 'EaseInOut', HAYYAB_BASENAME ); ?></option>
                                <option value="easeOut"><?php _e( 'EaseOut', HAYYAB_BASENAME ); ?></option>
                            </select>
                        </div>
                        <div class="col s4">
                            <select id="hb_scroll_ease_effect" name="hb_scroll_ease_effect" class="hayyaClassesList select_modal select_material" data-value="<%= classes.Value['hb_scroll_ease_effect'] %>">
                                <option value=""><?php _e( 'Select Mode', HAYYAB_BASENAME ); ?></option>
                                <option value="Power0"><?php _e( 'Power 0', HAYYAB_BASENAME ); ?></option>
                                <option value="Power1"><?php _e( 'Power 1', HAYYAB_BASENAME ); ?></option>
                                <option value="Power2"><?php _e( 'Power 2', HAYYAB_BASENAME ); ?></option>
                                <option value="Power3"><?php _e( 'Power 3', HAYYAB_BASENAME ); ?></option>
                                <option value="Power4"><?php _e( 'Power 4', HAYYAB_BASENAME ); ?></option>
                                <option value="Back"><?php _e( 'Back ', HAYYAB_BASENAME ); ?></option>
                                <option value="Elastic"><?php _e( 'Elastic', HAYYAB_BASENAME ); ?></option>
                                <option value="Bounce"><?php _e( 'Bounce', HAYYAB_BASENAME ); ?></option>
                                <option value="SlowMo"><?php _e( 'SlowMo', HAYYAB_BASENAME ); ?></option>
                                <option value="Stepped"><?php _e( 'Stepped', HAYYAB_BASENAME ); ?></option>
                                <option value="Circ"><?php _e( 'Circ', HAYYAB_BASENAME ); ?></option>
                                <option value="Expo"><?php _e( 'Expo', HAYYAB_BASENAME ); ?></option>
                                <option value="Sine"><?php _e( 'Sine', HAYYAB_BASENAME ); ?></option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col s4" style="padding:10px;">
                            <?php _e( 'Select Effects', HAYYAB_BASENAME ); ?>
                        </div>
                    </div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_scale_out" data-scrollefect="1" class="hayyaClassesList" value="hb_scale_out" name="hb_scale_out" <%= classes.Value['hb_scale_out'] %>/>
    						<label for="hb_scale_out"><?php _e( 'Scale Out', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_scale_in" data-scrollefect="1" class="hayyaClassesList" value="hb_scale_in" name="hb_scale_in" <%= classes.Value['hb_scale_in'] %>/>
    						<label for="hb_scale_in"><?php _e( 'Scale In', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_slide_left" data-scrollefect="1" class="hayyaClassesList" value="hb_slide_left" name="hb_slide_left" <%= classes.Value['hb_slide_left'] %>/>
    						<label for="hb_slide_left"><?php _e( 'Slide Left', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_slide_right" data-scrollefect="1" class="hayyaClassesList" value="hb_slide_right" name="hb_slide_right" <%= classes.Value['hb_slide_right'] %>/>
    						<label for="hb_slide_right"><?php _e( 'Slide Right', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_slide_up" data-scrollefect="1" class="hayyaClassesList" value="hb_slide_up" name="hb_slide_up" <%= classes.Value['hb_slide_up'] %>/>
    						<label for="hb_slide_up"><?php _e( 'Slide UP', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_slide_down" data-scrollefect="1" class="hayyaClassesList" value="hb_slide_down" name="hb_slide_down" <%= classes.Value['hb_slide_down'] %>/>
    						<label for="hb_slide_down"><?php _e( 'Slide DOWN', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_rotation_left" data-scrollefect="1" class="hayyaClassesList" value="hb_rotation_left" name="hb_rotation_left" <%= classes.Value['hb_rotation_left'] %>/>
    						<label for="hb_rotation_left"><?php _e( 'Left Rotation', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_rotation_right" data-scrollefect="1" class="hayyaClassesList" value="hb_rotation_right" name="hb_rotation_right" <%= classes.Value['hb_rotation_right'] %>/>
    						<label for="hb_rotation_right"><?php _e( 'Right Rotation', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_fade_in" data-scrollefect="1" class="hayyaClassesList" value="hb_fade_in" name="hb_fade_in" <%= classes.Value['hb_fade_in'] %>/>
    						<label for="hb_fade_in"><?php _e( 'Fade IN', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_fade_out" data-scrollefect="1" class="hayyaClassesList" value="hb_fade_out" name="hb_fade_out" <%= classes.Value['hb_fade_out'] %>/>
    						<label for="hb_fade_out"><?php _e( 'Fade OUT', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    			<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="hb_parallax_up" data-scrollefect="1" class="hayyaClassesList" value="hb_parallax_up" name="hb_parallax_up" <%= classes.Value['hb_parallax_up'] %>/>
    						<label for="hb_parallax_up"><?php _e( 'Parallax Background (UP)', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="hb_parallax_down" data-scrollefect="1" class="hayyaClassesList" value="hb_parallax_down" name="hb_parallax_down" <%= classes.Value['hb_parallax_down'] %>/>
    						<label for="hb_parallax_down"><?php _e( 'Parallax Background (DOWN)', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    		</fieldset>
    			<fieldset>
    				<legend><i class="fa fa-gears"></i> <?php _e( 'Other Options', HAYYAB_BASENAME ); ?></legend>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="bg-primary" class="hayyaClassesList" value="bg-primary" name="bg-primary" <%= classes.Value['bg-primary'] %>/>
    						<label for="bg-primary"><?php _e( 'Background primary style', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="text-primary" class="hayyaClassesList" value="text-primary" name="text-primary" <%= classes.Value['text-primary'] %>/>
    						<label for="text-primary"><?php _e( 'Text primary style', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="bg-success" class="hayyaClassesList" value="bg-success" name="bg-success" <%= classes.Value['bg-success'] %>/>
    						<label for="bg-success"><?php _e( 'Background success style', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="text-success" class="hayyaClassesList" value="text-success" name="text-success" <%= classes.Value['text-success'] %>/>
    						<label for="text-success"><?php _e( 'Text success style', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="bg-default" class="hayyaClassesList" value="bg-default" name="bg-default" <%= classes.Value['bg-default'] %>/>
    						<label for="bg-default"><?php _e( 'Background default style', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="text-default" class="hayyaClassesList" value="text-default" name="text-default" <%= classes.Value['text-default'] %>/>
    						<label for="text-default"><?php _e( 'Text default style', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="text-muted" class="hayyaClassesList" value="text-muted" name="text-muted" <%= classes.Value['text-muted'] %>/>
    						<label for="text-muted"><?php _e( 'Text muted style', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="small" class="hayyaClassesList" value="small" name="small" <%= classes.Value['small'] %>/>
    						<label for="small"><?php _e( 'Text small style', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="text-left" class="hayyaClassesList" value="text-left" name="text-left" <%= classes.Value['text-left'] %>/>
    						<label for="text-left"><?php _e( 'Text align left', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="text-right" class="hayyaClassesList" value="text-right" name="text-right" <%= classes.Value['text-right'] %>/>
    						<label for="text-right"><?php _e( 'Text align right', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="text-center" class="hayyaClassesList" value="text-center" name="text-center" <%= classes.Value['text-center'] %>/>
    						<label for="text-center"><?php _e( 'Text align center', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="text-justify" class="hayyaClassesList" value="text-justify" name="text-justify" <%= classes.Value['text-justify'] %>/>
    						<label for="text-justify"><?php _e( 'Text align justify', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
    				<div class="row">
    					<div class="col s6">
							<input type="checkbox" id="pull-left" class="hayyaClassesList" value="pull-left" name="pull-left" <%= classes.Value['pull-left'] %>/>
    						<label for="pull-left"><?php _e( 'Pull left', HAYYAB_BASENAME ); ?></label>
    					</div>
    					<div class="col s6">
							<input type="checkbox" id="pull-right" class="hayyaClassesList" value="pull-right" name="pull-right" <%= classes.Value['pull-right'] %>/>
    						<label for="pull-right"><?php _e( 'Pull right', HAYYAB_BASENAME ); ?></label>
    					</div>
    				</div>
	    		</fieldset>
	    		<fieldset>
	    			<legend><i class="fa  fa-plus"></i> <?php _e( 'Extra classes', HAYYAB_BASENAME ); ?></legend>
	    			<input type="text" class="hayyaClassesList" name="classes" value="<%= classes.classes %>">
	    		</fieldset>
			</div>
    	</script>
    	<?php
    }


} // End Class
