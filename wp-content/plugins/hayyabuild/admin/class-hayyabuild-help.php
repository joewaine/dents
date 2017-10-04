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


class HayyaHelp extends HayyaAdmin {

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
    	return $this->Help();
    }

	/**
	 *
     * @access		public
     * @since		1.0.0
     * @var			unown
	 */
    protected function Help() { ?>
    	<div id="hayyabuild" class="wrap">
    	<!-- <div class="">
    	<?php // wp_editor( 'Hi,its content' , 'desired_id_of_textarea', '' ); ?>
    	    </div> -->
    	    <div class="view_title">
    	        <h1 style="color: #000000;"><?php _e( HAYYAB_NAME , HAYYAB_BASENAME );?> - <?php echo __('Version') . ' ' .HAYYAB_VERSION; ?></h1>
    	    </div>
    	    <hr>
    	    <ul class="collapsible" data-collapsible="accordion">
    	        <li>
    	            <div class="collapsible-header active"><i class="fa fa-send"></i><?php _e( 'Contact Us', HAYYAB_BASENAME);?></div>
    	            <div class="collapsible-body valign-wrapper " style="padding-top: 10px;">
    	                <div class="row valign">
    	                    <div class="col s8">
    	                        <section id="top">
    	                            <div>
    	                                <b>First of all, thank you for using HayyaBuild.<br/>
                                        If we can be of further assistance please contact us at </b>
                                        <a target="_blank" href="http://codecanyon.net/item/hayyabuild-responsive-header-and-footer-builder/15315666/comments">CodeCanyon</a><br />
                                        <b>If you like it, Please don't forget to write a good review.</b>
                                        <a target="_blank" class="" href="http://codecanyon.net/downloads" style="color: #FFC800;text-decoration: none;">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i style="color: blue;">Click here to write your reivew.</i>
                                        </a>.
    	                            </div>
    	                            <div>
    	                                <div style="padding-top:120px;">
    	                                    Need help ? You want to report a bug ?<br />
    	                                    You can find us on:<br>
    	                                </div>
    	                            </div>
    	                        </section>
    	                    </div>
    	                    <div class="col s4 right-align">
    	                        <img src="<?php echo site_url().'/wp-content/plugins/'.HAYYAB_BASENAME.'/admin/assets/images/logo.png?v='.HAYYAB_VERSION; ?>" />
    	                    </div>
    	                </div>
    	                <div align="center" style="padding-bottom: 10px;">
    	                    <a target="_blank" class="waves-effect waves-darck hayya_btn" href="http://codecanyon.net/item/hayyabuild-responsive-header-and-footer-builder/15315666">Plugin Page</a>
    	                    <a target="_blank" class="waves-effect waves-darck hayya_btn" href="http://hayyabuild.zintathemes.com">Plugin Website</a>
    	                </div>
    	            </div>
    	        </li>
    	        <li>
    	            <div class="collapsible-header"><i class="fa fa-exclamation-circle"></i><?php _e('Help');?></div>
    	            <div class="collapsible-body valign-wrapper" style="padding-top: 10px;">
    	                <div class="row valign hayyabuild_help" style="color: #555555;">
    	                    <div class="col s12">
    	                        <section>
    	                            <h3>Setup Your Template</h3>
    	                            <div>
    	                                You still have one setp to get HayyaBuild worked
    	                                <ul>
    	                                    <li>Make a backup from you tempalate, Copy your template directory to another place.</li>
    	                                    <li>
    	                                        Now open your header.php and footer.php file which is located in the Appearance >> Editor
    	                                    </li>
    	                                    <li>
    	                                        From template files list <i>"on the right"</i> choose Theme Header (header.php)
    	                                    </li>
    	                                    <li>
    	                                        Now replace the header tag <br />
    	                                        <code>&lt;header&gt; .... &lt;/header&gt; <b>OR</b> &lt;div id="header"&gt; .... &lt;/div&gt; <b>or anything else</b></code><br />
    	                                        with this code<br />
    	                                        <code>&lt;?php hayya_run('header');?&gt;</code><br />
    	                                        and click on Update
    	                                    </li>
    	                                    <li>
    	                                        From Editor and template files list <i>"on the right"</i> choose Theme Footer (footer.php)
    	                                    </li>
    	                                    <li>
    	                                        Replace the footer tag<br />
    	                                        <code>&lt;footer&gt; .... &lt;/footer&gt; <b>OR</b> &lt;div id="footer"&gt; .... &lt;/div&gt; <b>or anything else</b></code><br />
    	                                        With this code<br />
    	                                        <code>&lt;?php hayya_run('footer');?&gt;</code><br />
    	                                    </li>
    	                                </ul>
    	                                <blockquote>
    	                                   You can edit header.php and footer.php with any text editor from your disktop.
    	                                </blockquote>
    	                            </div>
    	                        </section>
    	                        <hr />
    	                        <section id="changes">
    	                            <h3>UPDATES</h3>

                                    <h4>HayyaBuild Version 3.1</h4>
                                    <blockquote>
                                        <ul>
                                            <li><strong>New Module</strong>: Card Module, Cards are a convenient means of displaying content composed of different types of objects</li>
                                            <li><strong>New Module</strong>: Testimonial Module, The testimonials module lets you to add kudos from your customers and clients and display them on your site.</li>
                                            <li><strong>New Feature</strong>: now with HayyaBuild you can build 404 error page.</li>
                                            <li><strong>New Feature</strong>: Adding new scroll effects to all module.</li>
                                            <li><strong>Other Changes</strong>: New pre-made template (404 error page template).</li>
                                            <li><strong>Other Changes</strong>: Back-end interface improvements.</li>
                                            <li><strong>Other Changes</strong>: Front-end improvements in CSS and JavaScript.</li>
                                            <li><strong>Fixed bug</strong>: Fix Parse Error, issue with parsing HTML output.</li>
                                            <li>Other features, improvements and bugs fixes.</li>
                                        </ul>
                                        <cite>09 June 2017</cite>
                                    </blockquote>
                                    <hr/>
                                    
                                    <h4>HayyaBuild Version 3.0</h4>
                                    <blockquote>
                                        <ul>
                                            <li><strong>New Module</strong>: Adding Conditional Box, You can use this box to display content under a specific conditions.</li>
                                            <li><strong>New Feature</strong>: Adding pages content builder, Now with HayyaBuild you can build your pages content from one place without the needs for editing all pages separately.</li>
                                            <li><strong>New Feature</strong>: Adding scroll effects to all module "<i>Scale Out, Scale In, Slide Left, Slide Right, Slide UP, Slide DOWN, Left Rotation, Right Rotation, Fade IN, Fade OUT, Parallax Background (UP), Parallax Background (DOWN)</i>".</li>
                                            <li><strong>New Feature</strong>: Adding visibility Options to all module "<i>Visible on extra small devices, Visible on small devices, Visible on medium devices, Visible on large devices, Hidden on extra small devices, Hidden on small devices, Hidden on medium devices, Hidden on large devices</i>".</li>
                                            <li><strong>New Feature</strong>: Adding module ID text box <i>to add an ID for modules</i>.</li>
                                            <li><strong>New Feature</strong>: Adding popover dialog to display module info "<i> like Module name, ID, class and style</i>".</li>
                                            <li><strong>New Feature</strong>: Adding date shortcode to display current date.</li>
                                            <li><strong>Fixed bug</strong>: .</li>
                                            <li><strong>Fixed bug</strong>: Menu module - improvements in CSS and mobile screen size.</li>
                                            <li><strong>Other Changes</strong>: Menu module - centering problem.</li>
                                            <li><strong>Other Changes</strong>: PHP, CSS, HTML and JavaScrit Code improvements.</li>
                                            <li><strong>Other Changes</strong>: Update all pre-made templates.</li>
                                            <li><strong>Other Changes</strong>: Update Documentation.</li>
                                            <li><strong>Other Changes</strong>: Update Demo theme.</li>
                                            <li><strong>Other Changes</strong>: Update .po file for translation.</li>
                                            <li>Other features, improvements and bugs fixes.</li>
                                        </ul>
                                        <cite>22 May 2017</cite>
                                    </blockquote>
                                    <hr/>
    					            <h4>HayyaBuild Version 2.3</h4>
    					            <blockquote>
    					                <ul>
    					                    <li><strong>Fixed bug</strong>: all links inside header of footer don't accepted <i>tel</i> and <i>callto</i>.</li>
    					                    <li><strong>Fixed bug</strong>: Menu element - hover problem at right alignment.</li>
    					                    <li><strong>Other Changes</strong>: Update Documentation.</li>
    					                    <li>Other features, improvements and bugs fixes.</li>
    					                </ul>
    					                <cite>20 November 2016</cite>
    					            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 2.2</h4>
    	                            <blockquote>
    					                <ul>
    					                    <li><strong>New Feature</strong>: CSS Editor for header or footer, Now you can add CSS style rules to just one header or footer.</li>
    					                    <li><strong>New Feature</strong>: Add more than 10 new Pre-made template.</li>
    					                    <li><strong>Improvements</strong>: Re-adjust colors and CSS style rules for the backend</li>
    					                    <li><strong>Improvements</strong>: Improves drag and drop functionality. works better now.</li>
    					                    <li><strong>New Feature</strong>: Sorting elements side by side.</li>
    					                    <li><strong>New Feature</strong>: Adding some important shortcodes ( page title, site title, blog title, blog description, site URL, home URL ).</li>
    					                    <li><strong>Fixed bug</strong>: Fixing YouTube Video background problem.</li>
    					                    <li><strong>Fixed bug</strong>:  some of spelling mistakes.</li>
    					                    <li><strong>Fixed bug</strong>: Elements background removed by HTMLPurifier.</li>
    					                    <li><strong>Fixed bug</strong>: open links to new window.</li>
    					                    <li><strong>Fixed bug</strong>: updated message not working whene user click the update button.</li>
    					                    <li><strong>Other Changes</strong>: Update Documentation "add HowTo's section".</li>
    					                    <li><strong>Other Changes</strong>: Prompt confirm before Leaving edited header or footer.</li>
    					                    <li><strong>Other Changes</strong>: .po file updated.</li>
    					                    <li>Other features, improvements and bugs fixes.</li>
    					                </ul>
    					                <cite>10 October 2016</cite>
    					            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 2.1</h4>
    	                            <blockquote>
    	                                <ul>
    	                                    <li><strong>New Element</strong>: Bootstrap Panels.</li>
    	                                    <li><strong>New Feature</strong>: Now you can active and deactivate any element.</li>
    	                                    <li><strong>New Feature</strong>: CSS Editor, to insert CSS code to WordPress pages.</li>
    	                                    <li><strong>Improvements</strong>: Include HTMLPurifier library, HTML filter that guards against XSS and ensures standards-compliant output.</li>
    	                                    <li><strong>Improvements</strong>: Re-adjust colors and CSS code in the backend</li>
    	                                    <li><strong>Improvements</strong>: Separation of headers and footers in backend to avoid confusion when the list is long</li>
    	                                    <li><strong>Improvements</strong>: Remove unwanted HTML attributes from frontend with HTMLPurifier to make website more faster.</li>
    	                                    <li><strong>Improvements</strong>: Minify some of CSS and JS files to make website more faster by decreasing the file size.</li>
    	                                    <li><strong>Fixed bug</strong>: In Responsive embed element "the embed code not rendered in frontend".</li>
    	                                    <li><strong>Fixed bug</strong>: In Bootstrap Progress bar element "Progress bar not rendered in backend".</li>
    	                                    <li><strong>Fixed bug</strong>: In Google Map element "Javascript error in map when content is more than one line".</li>
    	                                    <li><strong>Fixed bug</strong>: fixing some of spelling mistakes.</li>
    	                                    <li><strong>Fixed bug</strong>: Video background not work.</li>
    	                                    <li>Other features, improvements and bugs fixes.</li>
    	                                </ul>
    	                                <cite>12 September 2016</cite>
    	                            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 2.0</h4>
    	                            <blockquote>
    	                                <ul>
    	                                    <li><strong>New Element</strong>: Facebook like and recommend button.</li>
    	                                    <li><strong>New Element</strong>: Facebook timeline box.</li>
    	                                    <li><strong>New Element</strong>: Twitter button.</li>
    	                                    <li><strong>New Element</strong>: Twitter timeline box ( list template and grid template).</li>
    	                                    <li><strong>New Element</strong>: Google Map.</li>
    	                                    <li><strong>New Element</strong>: Contact Form 7 ( for Contactform7 plugin ).</li>
    	                                    <li><strong>New Element</strong>: Revolution Slider ( for Revolution Slider plugin ).</li>
    	                                    <li><strong>New Element</strong>: Layer Slider ( for Layer Slider plugin ).</li>
    	                                    <li><strong>New Feature</strong>: Display background image for headers and footers in list page.</li>
    	                                    <li><strong>New Feature</strong>: More than 10 pre-made templates to get started from them.</li>
    	                                    <li><strong>New Feature</strong>: You can disable any libraries if you are alrady use it in your theme.</li>
    	                                    <li><strong>Fixed bug</strong>: Footer scroll effects problem ( pin It ).</li>
    	                                    <li>Update CSS code for admin theme</li>
    	                                    <li>Other features, improvements and bugs fixes.</li>
    	                                </ul>
    	                                <cite>27 June 2016</cite>
    	                            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 1.2</h4>
    	                            <blockquote>
    	                                <ul>
    	                                    <li>Migrate from skrollr to Scrollmagic ( for scrolling effects ).</li>
    	                                    <li><strong>New Scroll Effects</strong> Fixed effect, Parallax effect, opatity effect, scale in, scale out.</li>
    	                                    <li><strong>Fixed bug</strong> mobile Scrolling problem when Parallax effect is activated </li>
    	                                    <li>Change Demo theme.</li>
    	                                    <li>Change HayyaBuild Demo content.</li>
    	                                    <li>Other features and bugs fixes.</li>
    	                                </ul>
    	                                <cite>12 April 2016</cite>
    	                            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 1.1</h4>
    	                            <blockquote>
    	                                <ul>
    	                                    <li><strong>New Element</strong>: Wordpress menu.</li>
    	                                    <li><strong>New Element</strong>: Simple Wordpress menu.</li>
    	                                    <li><strong>New Element</strong>: Heading text.</li>
    	                                    <li><strong>New Element</strong>: Wordpress Breadcrumb menu.</li>
    	                                    <li><strong>New Features</strong>: Adding a new features to must of elements.</li>
    	                                    <li><strong>New Features</strong>: Adding some classes.</li>
    	                                    <li><strong>New Features</strong>: Now you can change text align from the Division element</li>
    	                                    <li>Change Demo them.</li>
    	                                    <li>Change HayyaBuild Demo content.</li>
    	                                    <li>Other features and bugs fixes.</li>
    	                                </ul>
    	                                <cite>31 March 2016</cite>
    	                            </blockquote>
                                    <hr/>
    	                            <h4>HayyaBuild Version 1</h4>
    	                            <blockquote>
    	                                <ul>
    	                                    <li>First release!</li>
    	                                </ul>
    	                                <cite>10 March 2016</cite>
    	                            </blockquote>
    	                        </section>
    	                    </div>
    	                </div>
    	            </div>
    	        </li>
    	    </ul>
    	</div><?php
    }

} // End Class
