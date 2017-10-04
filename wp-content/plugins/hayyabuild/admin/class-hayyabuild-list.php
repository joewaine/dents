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


class HayyaList extends HayyaAdmin {

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
    public function __construct($list = null) {
    	if ( $list === 'templates' ) return $this->TemplateList();
    	else return $this->MainList($list);
    }

    /**
     *
     *
     * @access		protected
     * @since		1.0.0
     * @var			unown
     */
    protected function MainList($list = null) {
    	global $wpdb;
    	$published_count = $wpdb->get_var( 'SELECT COUNT(`id`) FROM `'.$wpdb->prefix . HAYYAB_BASENAME.'` WHERE `status` = "published"' );
    	$draft_count = $wpdb->get_var( 'SELECT COUNT(`id`) FROM `'.$wpdb->prefix . HAYYAB_BASENAME.'` WHERE `status` = "draft"' );
    	$deactivated_count = $wpdb->get_var( 'SELECT COUNT(`id`) FROM `'.$wpdb->prefix . HAYYAB_BASENAME.'` WHERE `status` = "deactivated"' );
    	?>
    	<div id="hayyabuild" class="wrap">
			<div class="hb-main_settings">
				<?php HayyaView::navBar(true);?>
				<div class="row">
					<div class="col s12">
						<?php

						$published_current = $draft_current = $deactivated_current = '';
						if ( HayyaHelper::_get ( 'list' ) == 'draft' ) $draft_current = 'active';
						elseif ( HayyaHelper::_get ( 'list' ) == 'deactivated' ) $deactivated_current = 'active';
						else $published_current = 'active';
						?>
						<ul  class="pagination">
							<li class="<?php echo $published_current;?>">
							    <?php if ( ! HayyaHelper::_get ( 'list' ) ) {?>
							        <?php _e('Published', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $published_count;?>)</span>
							    <?php } else { ?>
					                <a href="admin.php?page=hayyabuild"><?php _e('Published', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $published_count;?>)</span></a>
							    <?php } ?>
							</li>
							<li class="<?php echo $draft_current;?>">
							    <?php if ( HayyaHelper::_get ( 'list' ) == 'draft' ) {?>
					                <?php _e('Draft', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $draft_count;?>)</span>
					            <?php } else { ?>
					    		    <a href="admin.php?page=hayyabuild&amp;list=draft"><?php _e('Draft', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $draft_count;?>)</span></a>
					            <?php } ?>
							</li>
							<li class="<?php echo $deactivated_current;?>">
							    <?php if ( HayyaHelper::_get ( 'list' ) == 'deactivated' ) {?>
					                <?php _e('Deactivated', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $deactivated_count;?>)</span>
					            <?php } else { ?>
					                <a href="admin.php?page=hayyabuild&amp;list=deactivated" ><?php _e('Deactivated', HAYYAB_BASENAME); ?> <span class="count">(<?php echo $deactivated_count;?>)</span></a>
					            <?php } ?>
							</li>
						</ul>
					</div>
				</div>
				<div class="content-tab" >
					<?php if ( is_array($list) && !empty($list)) : ?>
						<div class="hayya-filter-tabs">
							<ul class="tabs">
								<li class="tab"><a class="hayya_filter waves-effect" data-filter="all" href="#"><?php _e('All', HAYYAB_BASENAME); ?></a></li>
								<li class="tab"><a class="hayya_filter waves-effect" data-filter="header" href="#"><?php _e('Headers', HAYYAB_BASENAME); ?></a></li>
								<li class="tab"><a class="hayya_filter waves-effect" data-filter="content" href="#"><?php _e('Pages Content', HAYYAB_BASENAME); ?></a></li>
								<li class="tab"><a class="hayya_filter waves-effect" data-filter="footer" href="#"><?php _e('Footers', HAYYAB_BASENAME); ?></a></li>
							</ul>
						</div>
						<div class="hayya-list-tabs">
							<ul class="tabs">
								<li class="tab"><a class="hayya_list_view" data-view="list" href="#"><i class="fa fa-align-justify"></i></a></li>
								<li class="tab"><a class="hayya_list_view" data-view="grid" href="#"><i class="fa  fa-th-large"></i></a></li>
							</ul>
						</div>
						<?php
						$headers = $contents = $footers = false;
						foreach ($list as $element) :
							if ( $element->type === 'header') $headers = true;
							else if ( $element->type === 'content') $contents = true;
							else if ( $element->type === 'footer') $footers = true;
							$pages = preg_replace_callback(
									'/s:([0-9]+):\"(.*?)\";/',
									function ($matches) { return "s:".strlen($matches[2]).':"'.$matches[2].'";';     },
									$element->pages
									);
							$pages = maybe_unserialize($pages);
							$pages_list = __('Pages List: ', HAYYAB_BASENAME);
							if ($pages) {
								foreach ($pages as $page) {
									if ( $page == 'all') $pages_list .= ' | '. $page;
									else $pages_list .= ' | '. get_the_title( $page );
								}
							}
							$settings = preg_replace_callback(
									'/s:([0-9]+):\"(.*?)\";/',
									function ($matches) { return "s:".strlen($matches[2]).':"'.$matches[2].'";';     },
									$element->settings
									);
							$settings = maybe_unserialize( $settings );
                            $background = '';
							if ( isset($settings['background_type']) ) {
								if ($settings['background_type'] === 'background_image' ) $background = 'background: url('.$settings['background_image'].') no-repeat;background-position:center; background-size: cover;';
								elseif ( $settings['background_type'] === 'background_video' ) $background = 'background: url('.HAYYAB_URL.'admin/assets/images/video_bg.jpg) no-repeat;background-position:center; background-size: cover;';
								elseif ($settings['background_type'] === 'background_color') $background = 'background: '.$settings['background_color'].';';
							} else {
								$background = 'background: url('.HAYYAB_URL.'admin/assets/images/empty_bg.png) repeat;';
							}
							?>
							<div style="<?php echo $background;?>" class="elements-list hayya_filter_items filter_<?php echo $element->type;?>">
								<div class="list-title">
                                    <div class="container">
    				    				<span class="element-link">
    				        				<a href="admin.php?page=hayyabuild&amp;id=<?php echo $element->id; ?>&amp;action=edit" title="Edit”">
    				        					<?php echo $element->name; ?>
    				        				</a>
    				        				<span><?php echo $pages_list;?></span> &nbsp;&nbsp;&nbsp;&nbsp;
    				        				<span><?php _e('Type: ', HAYYAB_BASENAME); echo $element->type;?></span>
                                            <?php if ( empty($pages) && $element->type === 'content' ) : ?>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <span>
                                                    Shortcode:
                                                    <code class="copy-shortcode">[hayyabuild id="<?php echo $element->id; ?>"]</code>
                                                </span>
                                            <?php endif; ?>
    				    				</span>
    				    				<div class="row-action">
    				    					<a title="<?php _e('Edit', HAYYAB_BASENAME); ?>" href="admin.php?page=hayyabuild&amp;id=<?php echo $element->id; ?>&amp;action=edit"><i class="fa fa-edit"></i> <?php _e('Edit', HAYYAB_BASENAME); ?></a>
    				    					<?php if ( ! HayyaHelper::_get ( 'list' )) { ?>
    				    						<a href="admin.php?page=hayyabuild&amp;id=<?php echo $element->id; ?>&amp;action=deactivate" class="submitdelete"><i class="fa fa-close"></i> <?php _e('Deactivate', HAYYAB_BASENAME); ?></a>
    				    					<?php } elseif ( HayyaHelper::_get ( 'list' ) == 'draft' ) { ?>
    				    						<a href="admin.php?page=hayyabuild&amp;list=draft&amp;id=<?php echo $element->id; ?>&amp;action=publishe"><i class="fa fa-save"></i> <?php _e('Publish', HAYYAB_BASENAME); ?></a>
    				    						<a href="admin.php?page=hayyabuild&amp;list=draft&amp;id=<?php echo $element->id; ?>&amp;action=deactivate" class="submitdelete"><i class="fa fa-close"></i> <?php _e('Deactive', HAYYAB_BASENAME); ?></a>
    				    					<?php } elseif ( HayyaHelper::_get ( 'list' ) == 'deactivated' ) { ?>
    				    						<a href="admin.php?page=hayyabuild&amp;list=deactivated&amp;id=<?php echo $element->id; ?>&amp;action=publishe"><i class="fa fa-save"></i> <?php _e('Activate', HAYYAB_BASENAME); ?></a>
    				    						<a href="admin.php?page=hayyabuild&amp;list=deactivated&amp;id=<?php echo $element->id; ?>&amp;action=delete" class="submitdelete"><i class="fa fa-trash"></i> <?php _e('Delete', HAYYAB_BASENAME); ?></a>
    				    					<?php } elseif ( HayyaHelper::_get ( 'list' ) == 'templates' ) { ?>
    				    						<a href="admin.php?page=hayyabuild&amp;id=<?php echo $element->id; ?>&amp;action=delete" class="submitdelete"><i class="fa fa-trash"></i> <?php _e('Delete', HAYYAB_BASENAME); ?></a>
    				    					<?php } ?>
    				    					<a href="admin.php?page=hayyabuild&amp;id=<?php echo $element->id; ?>&amp;export=1"><i class="fa fa-mail-forward"></i> <?php _e('Export', HAYYAB_BASENAME); ?></a>
    				    				</div>
                                    </div>
								</div>
							</div>
						<?php endforeach; ?>
						<?php if (!$headers) { ?>
							<div class="filter_empty_header empty-filter">
								<?php HayyaView::emptyList(true, false) ?>
							</div>
						<?php } ?>
						<?php if (!$contents) { ?>
							<div class="filter_empty_content empty-filter">
								<?php HayyaView::emptyList(true, false) ?>
							</div>
						<?php } ?>
						<?php if (!$footers) { ?>
							<div class="filter_empty_footer empty-filter">
								<?php HayyaView::emptyList(true, false) ?>
							</div>
						<?php } ?>
					<?php else: ?>
							<?php HayyaView::emptyList(true, true) ?>
					<?php endif; ?>
				</div>
		</div>
			<hr/>
			<?php HayyaView::importForm() ?>
		</div> <?php
    }

    /**
     *
     *
     * @access		protected
     * @since		1.0.0
     * @var			unown
     */
    protected function TemplateList() {
    	require_once HAYYAB_PATH . 'includes/class-hayyabuild-templates.php';
    	$tpl = new HayyaTemplates(HAYYAB_BASENAME, HAYYAB_VERSION);
    	$templates  = $tpl->templates;
    	?>
    	<div id="hayyabuild" class="wrap">
    		<div class="hb-main_settings">
	    	    <?php HayyaView::navBar(); ?>
	    	    <?php if ( ! HayyaHelper::_get( 'tpl' ) ) { ?>
	    	    <div style="padding: 10px;">
		    	    <h4><?php _e( 'Templates List', HAYYAB_BASENAME );?></h4>
	    	    </div>
	    	     <div class="row content-tab hayya_template" id="hayy_templates" >
					<div class="hayya-filter-tabs">
						<ul class="tabs">
							<li class="tab"><a class="hayya_filter waves-effect" data-filter="all" href="#"><?php _e('All', HAYYAB_BASENAME); ?></a></li>
							<li class="tab"><a class="hayya_filter waves-effect" data-filter="header" href="#"><?php _e('Headers', HAYYAB_BASENAME); ?></a></li>
							<li class="tab"><a class="hayya_filter waves-effect" data-filter="content" href="#"><?php _e('Pages Content', HAYYAB_BASENAME); ?></a></li>
							<li class="tab"><a class="hayya_filter waves-effect" data-filter="footer" href="#"><?php _e('Footers', HAYYAB_BASENAME); ?></a></li>
						</ul>
					</div>
	    		    <?php foreach( $templates as $key => $value ) : ?>
    		       	<div class="col s6 hayya_filter_items filter_<?php echo $value['type'];?>" style="padding: 20px;">
                        <?php
                        $image = '';
                        if( file_exists(HAYYAB_PATH.'includes/data/'.$key.'.jpg') ) {
                            $image = HAYYAB_URL.'includes/data/'.$key.'.jpg?v='.HAYYAB_VERSION;
                        } else if ( file_exists(HAYYAB_PATH.'includes/data/'.$key.'.png') ) {
                            $image = HAYYAB_URL.'includes/data/'.$key.'.png?v='.HAYYAB_VERSION;
                        }
                        ?>
                            <div class="hoverable">
                            <div class="card z-depth-0">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator" src="<?php echo $image; ?>">
                                </div>
                                <div class="card-content">
                                  <span class="card-title activator grey-text text-darken-4">
                                      <?php echo $value['name']; ?><i class="fa  fa-ellipsis-v right"></i>
                                  </span>
                                  <p>
                                      <?php _e('Type: ', HAYYAB_BASENAME); echo $value['type']; ?>
                                  </p>
                                </div>
                                <div class="card-reveal" style="opacity: 0.8;padding:20px;">
                                    <span class="card-title grey-text text-darken-4">
                                        <?php echo $value['name']; ?><i class="fa fa-close right"></i><hr/>
                                    </span>
                                    <div>
                                        <?php echo $value['description']; ?>
                                        <div style="position:absolute;bottom:15px;left:0;right:0;margin-left: auto;margin-right:auto;width:100%;text-align:center;">
                                            <a href="admin.php?page=hayyabuild&amp;section=templates&amp;tpl=<?php echo $key; ?>" class="waves-effect waves-light hayya_btn" style="margin-top: 20px;">
                                                <?php _e( 'Create', HAYYAB_BASENAME );?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
	    				</div>
	    	        <?php endforeach; ?>
	    	        </div>
	    		<?php
	    		} else {
	    	        $tpl        = HayyaHelper::_get( 'tpl' );
	    	        $template   = $templates[$tpl];
	    	        $type       = $template['type'];
                    $url        = HAYYAB_URL.'includes/data/';
                    $path       = HAYYAB_PATH.'includes/data/';
                    $image      = '';

                    if ( file_exists($path.$tpl.'.jpg') ) {
                        $image = '<img class="activator" src="'.$url.$tpl.'.jpg?v='.HAYYAB_VERSION.'">';
                    } else if ( file_exists($path.$tpl.'.png') ) {
                        $image = '<img class="activator" src="'.$url.$tpl.'.png?v='.HAYYAB_VERSION.'">';
                    }
	    	        if ( is_array($template) ) {
	    	            ?>
	    	            <div style="padding: 10px;">
	    	            	<h4> <?php _e( 'Create from template', HAYYAB_BASENAME );?> </h4>
	    	            </div>
	    	            <div class="row">
	    	                <div class="col s5">
	    	                    <div class="card">
	    	                        <div class="card-image waves-effect waves-block waves-light">
	    	                          <?php echo $image; ?>
	    	                        </div>
	    	                        <div class="card-content">
	    	                          <span class="card-title activator grey-text text-darken-4">
	    	                              <?php echo $template['name']; ?><i class="fa  fa-ellipsis-v right"></i>
	    	                          </span>
	    	                          <p>
	    	                              <?php _e('Type: ', HAYYAB_BASENAME); echo $template['type']; ?>
	    	                          </p>
	    	                        </div>
	    	                        <div class="card-reveal">
	    	                          <span class="card-title grey-text text-darken-4">
	    	                              <?php echo $template['name']; ?><i class="fa fa-close right"></i>
	    	                          </span>
	    	                          <p>
	    	                              <?php echo $template['description']; ?>
	    	                          </p>
	    	                        </div>
	    	                    </div>
	    	                </div>
	    	                <div class="col s7 input-field">
	    	                    <form method="post" action="" class="form-inline" role="form" >
	    	                        <input type="hidden" id="tpl" value="<?php echo $tpl;?>" name="tpl">
	    	                        <div class="row">
	    	                            <div class="col s4 input-field">
	    	                                <?php _e( ucfirst($type).' Name', HAYYAB_BASENAME );?>
	    	                            </div>
	    	                            <div class="col s8">
	    	                                <input name="name" id="name" size="30" value="<?php echo $template['name']; ?>" type="text" class="validate">
	    	                            </div>
	    	                        </div>
	    	                        <div class="row">
	    	                            <div class="col s4 input-field">
	    	                                <?php _e( 'Pages', HAYYAB_BASENAME ); ?>
	    	                            </div>
	    	                            <div class="col s8">
	    	                                <select id="pages" name="pages[]" data-placeholder="Select Pages" class="chosen-select" multiple>
	    	                                        <?php
	    	                                        $pages = get_pages();
                                                    $all_selected = ' selected';
                                                    $error_selected = '';
                                                    if ( HayyaHelper::_get( 'tpl' ) === '404_error' ) {
                                                        $all_selected = '';
                                                        $error_selected = ' selected';
                                                    }
	    	                                        echo '<option value="all"'.$all_selected.'>'.__( 'All pages', HAYYAB_BASENAME ).'</option>';?>
	    	                                        <optgroup label="<?php _e( 'Pages list', HAYYAB_BASENAME )?>">
	    	                                        <?php foreach ( $pages as $page ) {
	    	                                            echo '<option value="' .$page->ID. '">'.$page->post_title .'</option>';
	    	                                        }
	    	                                        ?>
                                                    <optgroup label="<?php _e( 'Other Pages', HAYYAB_BASENAME )?>">
                    				                    <?php
                    				                    $selected = '';
                    				                    if ( isset($pages_list) && is_array($pages_list) ) $selected = ( $pages_list && in_array( '404page', $pages_list ) ) ? ' selected' : '';
                                                        echo '<option value="404page"'.$error_selected.'>'.__( '404 Error Page', HAYYAB_BASENAME ).'</option>';?>
                    				                    ?>
                                                    </optgroup>
	    	                                    </optgroup>
	    	                                </select>
	    	                            </div>
	    	                        </div>
	    	                        <hr/>
	    	                        <div style="padding-top: 50px;">
	    	                            <button class="waves-effect waves-darck hayya_btn right" type="submit" name="publish" value="publish">
	    	                                <?php  _e('Create', HAYYAB_BASENAME  ); ?>
	    	                            </button>
	    	                        </div>
	    	                    </form>
	    	                </div>
	    	            </div>
	    	            <?php
	    	            }
	    	        }
	    	    ?>
	    	</div>
    	</div>
    	<?php
    }

} // End Class
