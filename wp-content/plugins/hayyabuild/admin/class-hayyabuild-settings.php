<?php
/**
 *
 * The admin-list functionality of the plugin.
 *
 * @since      	1.0.0
 * @package    	hayyabuild
 * @subpackage 	hayyabuild/admin
 * @author     	zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }


class HayyaSettings extends HayyaAdmin {

	/**
	 *
	 * @var array
	 */
	private static $elements_list = array();

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
    public function __construct() {
    	add_action('admin_init', array('HayyaHelper', '__notices'));

    	$hayya_elements = new HayyaModules( 'showall' );
    	self::$elements_list =  $hayya_elements->elements_list();
    	if ( HayyaHelper::_post('options') ) $this->save_settings();
    	$this->Settings();
    	// HayyaBuild::get_loader()->add_action('admin_init', $this, 'Settings');
    }

    /**
     *
     */
    private function save_settings() {
    	$post_libraries	= HayyaHelper::_post('libraries') ;
    	$post_elements	= HayyaHelper::_post('elements') ;
    	$post_csseditor		= HayyaHelper::_post('csseditor');
    	foreach (self::$elements_list as $path => $elements_list) {
	    	foreach ( $elements_list as $module ) {
	    		$moduleBase = $module['base'];
	    		if ( $post_elements && !array_key_exists($moduleBase, $post_elements) ) $post_elements[$moduleBase] = 'off';
	    	}
    	}
    	$settings = array(
    			'libraries' => $post_libraries,
    			'elements' 	=> $post_elements,
    			'csseditor'	=> $post_csseditor
    	);
    	if ( update_option('hayyabuild_settings', $settings) )
    		HayyaHelper::__notices( __('The database has been successfully updated', HAYYAB_BASENAME), 'success' );
    	else
    		HayyaHelper::__notices( __('EROR08: Someting happen, Can’t update database.', HAYYAB_BASENAME), 'error' );
    }

    /**
     *
     * @param unknown $list
     */
    public static function Settings($list = null) {
    	if ( function_exists('get_option') ) {
    		$setting = get_option('hayyabuild_settings');
    		if ( isset( $setting ) && is_array( $setting )) {
    			foreach( $setting as $key => $value ) $$key = $value;
    		}
    	}

    	$csseditor = stripslashes($csseditor);
    	?>
    	<div id="hayyabuild" class="wrap">
			<form method="post" action="" class="form-inline" role="form" id="settings_form">
    			<div class="hb-main_settings">
					<?php HayyaView::navBar($main = false); ?>
				    <hr>
			        <?php
			        settings_fields( 'hayyabuild-settings-group' );
			        do_settings_sections( 'hayyabuild-settings-group' );
			        ?>
			        <ul class="collapsible" data-collapsible="accordion">
			            <li>
			                <div class="active collapsible-header">
			                    <i class="fa fa-cogs"></i><?php _e( 'Include libraries', HAYYAB_BASENAME);?>
			                </div>
			                <div class="collapsible-body valign-wrapper" style="padding-top: 10px;">
			                    <div class="row">
			                        <div class="col s12">
			                            <blockquote style="font-size: 12px;">
			                                <?php _e( '<strong>Please Don’t deactivate anything that you don’t know</strong>.<br/>You can disable one of these libraries if you are alrady use it in your theme.', HAYYAB_BASENAME);?>
			                            </blockquote>
			                        </div>
			                    </div>
			                    <hr/>
			                    <div class="row">
			                        <div class="col s12">
			                            <label><?php _e( 'CSS libraries', HAYYAB_BASENAME);?></label>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <div class="col s3 input-field" style="text-align: right; border-right: 1px solid #00808E;padding: 5px;">
			                            <?php _e( 'Include Bootstrap library', HAYYAB_BASENAME ); ?>
			                        </div>
			                        <div class="col s3">
			                            <?php $checked = ( isset($libraries['bootstrap']) ) ? ' checked' : '';?>
			                            <div class="switch">
			                                <label>
			                                  Off <input type="checkbox" name="libraries[bootstrap]" <?php echo $checked; ?>/><span class="lever"></span> On
			                                </label>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <div class="col s3 input-field" style="text-align: right; border-right: 1px solid #00808E;padding: 5px;">
			                            <?php _e( 'Include Font Awesome', HAYYAB_BASENAME ); ?>
			                        </div>
			                        <div class="col s3">
			                            <?php $checked = ( isset($libraries['fontawesome']) ) ? ' checked' : '';?>
			                            <div class="switch">
			                                <label>
			                                  Off <input type="checkbox" name="libraries[fontawesome]" <?php echo $checked; ?>/><span class="lever"></span> On
			                                </label>
			                            </div>
			                        </div>
			                    </div>

			                    <hr/>
			                    <div class="row">
			                        <div class="col s12">
			                            <label><?php _e( 'JavaScript libraries', HAYYAB_BASENAME ); ?></label>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <div class="col s3 input-field" style="text-align: right; border-right: 1px solid #00808E;padding: 5px;">
			                            <?php _e( 'Include ScrollMagic', HAYYAB_BASENAME ); ?>
			                        </div>
			                        <div class="col s3">
			                            <?php $checked = ( isset($libraries['scrollmagic']) ) ? ' checked' : '';?>
			                            <div class="switch">
			                                <label>
			                                  Off <input type="checkbox" name="libraries[scrollmagic]" <?php echo $checked; ?>/><span class="lever"></span> On
			                                </label>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="row">
			                        <div class="col s3 input-field" style="text-align: right; border-right: 1px solid #00808E;padding: 5px;">
			                            <?php _e( 'Include NiceScroll', HAYYAB_BASENAME ); ?>
			                        </div>
			                        <div class="col s3">
			                            <?php $checked = ( isset($libraries['nicescroll']) ) ? ' checked' : '';?>
			                            <div class="switch">
			                                <label>
			                                  Off <input type="checkbox" name="libraries[nicescroll]" <?php echo $checked; ?>/><span class="lever"></span> On
			                                </label>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </li>
			            <!-- </ul>

			            <ul class="collapsible" data-collapsible="accordion"> -->
			            <li>
			                <div class="collapsible-header">
			                    <i class="fa fa-adjust"></i><?php _e( 'Active/Deactivate Modules', HAYYAB_BASENAME);?>
			                </div>
			                <div class="collapsible-body valign-wrapper" style="padding-top: 10px;">
			                    <div class="row">
			                        <div class="col s12">
			                            <blockquote style="font-size: 12px;">
			                                <?php _e( '<strong>Please Don’t deactivate anything that you don’t know</strong>.<br/>You can disable one of these modules if you have a problem in builder page.', HAYYAB_BASENAME);?>
			                            </blockquote>
			                        </div>
			                    </div>
			                    <hr/>
			                    <div class="row">
		                    		<div class="col s3" style="border: 1px solid #fff;"></div>
			                    	<div class="col s6">
		                    			<div class="row" style="border-bottom: 2px solid #efefef;padding-bottom: 10px;">
					                        <div class="col s6 input-field" style="text-align: right; border-right: 1px solid #00808E;padding: 5px;">
					                            <?php _e( 'All Modules', HAYYAB_BASENAME ); ?>
					                        </div>
					                        <div class="col s6" style="text-align: left;">
					                            <div class="switch">
					                                <label>
					                                  Off <input type="checkbox" id="settings_all_modules" name="all_modules" <?php echo $checked; ?>/><span class="lever"></span> On
					                                </label>
					                            </div>
					                        </div>
		                    			</div>
			                    	</div>
		                    		<div class="col s3"></div>
			                        <div style="clear: both;"></div>
				                    <?php foreach ( self::$elements_list as $path => $element ) : ?>
				                    	<?php foreach ( $element as $key => $val ) : ?>
				                        <div class="col s3" style="color:#00808E;text-align: right;height: 40px !important;border-right: 1px solid #00808E;margin-bottom: 5px;">
				                            <?php _e( $val['name'], HAYYAB_BASENAME ); ?>
				                            <i class="<?php echo $val['icon']?>" style="font-size: 25px;display: inline-block;width: 40px;text-align: center;background: #2CD0E1;border-radius: 2px;color: #00808E;margin-left: 5px;margin-top: 2px;"></i>
				                        </div>
				                        <div class="col s3" style="margin-top: 5px;height: 40px !important;">
				                            <?php $checked = ( isset($val['base']) && isset($elements[$val['base']]) && $elements[$val['base']] == 'on' ) ? ' checked' : '';?>
				                            <div class="switch" style="margin-top: 5px;">
				                                <label>
				                                  Off <input class="setting_modules_list" type="checkbox" name="elements[<?php echo $val['base'];?>]" <?php echo $checked; ?>/><span class="lever"></span> On
				                                </label>
				                            </div>
				                        </div>
				                        <?php endforeach;?>
				                    <?php endforeach; ?>
			                    </div>
			                </div>
			            </li>
			            <!-- </ul>

			            <ul class="collapsible" data-collapsible="accordion"> -->
			            <li>
			                <div class="collapsible-header">
			                    <i class="fa fa-file-text"></i><?php _e( 'CSS Editor', HAYYAB_BASENAME);?>
			                </div>
			                <div class="collapsible-body valign-wrapper" style="padding-top: 10px;">
			                    <div class="row">
			                        <div class="col s12">
			                            <blockquote style="font-size: 12px;">
			                                <?php _e( 'This CSS code will appear in all pages.', HAYYAB_BASENAME);?>
			                            </blockquote>
			                        </div>
			                    </div>
			                    <hr/>
			                    <div class="row">
			                        <div class="col s12">
			                        	<input type="hidden" name="csseditorval" id="csseditorval" value="<?php echo $csseditor;?>">
			                            <textarea rows="" id="csseditor" name="csseditor" cols="" style="width: 100%;"><?php echo $csseditor;?></textarea>
			                            <div id="csseditordiv"></div>
			                        </div>
			                    </div>
			                </div>
			            </li>
			        </ul>


			        <input type="hidden" id="options" value="options" name="options">
				</div>

				<div style="margin: 20px 0px" class="hb_buttons">
					<div class="row">
						<div class="col s10">
							<button class="waves-effect waves-darck hayya_btn" type="submit" name="save" value="save">
								<i class="fa fa-save"></i>
								<?php _e('Save', HAYYAB_BASENAME  ); ?>
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
    	<?php
    }

} // End Class
