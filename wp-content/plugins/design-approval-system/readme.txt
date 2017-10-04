=== Design Approval System ===
Contributors: slickremix, damon7620, MrFlannagan
Tags: designer email,project management, project, project board, login, user login, client login, password, username, SMTP, sendmail, authenticate, authenticate username, authenticate password, approval, design approval system, posts, Post, admin, image, images, imaging, page, comments, plugin, designers, designs, design, clients, client, slick remix, slick, remix, freelancer, graphic artists, freelancers, graphic designers, graphics, video, flash, show off, organize designs, organize, logo designers, photography,  wordpress plugin, proof, proofing, proofing software, system, wordpress, wordpress code, workflow, online, virtual, configurable, customizable, settings, email confirmation, links, stars, save comments, database, save digital signature, work flow, multi language, woocommerce, shopping cart, woo, commerce, total control
Requires at least: 4.5.0
Tested up to: 4.8.1
Stable tag: 4.3.2
License: GPLv2 or later

A project management system to streamline the process of getting designs, photos, documents, videos, or music approved by clients quickly.

== Description ==
See [Live Example](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v1/) and Approve the design.

Here's a look at how fast you can be setup!
[youtube https://www.youtube.com/watch?v=GSAyozmRHLw]

See [full documentation](http://www.slickremix.com/design-approval-system-docs/). Approved designs get a STAR on the Project Board, and Clients signature is recorded to the database. Check out the [Project Board](http://www.slickremix.com/docs/project-board). Clients, projects, & designs are organized on one page + Clients can login to see there designs!

Here is what you, the clients, and the plugin can do:

= YOU (THE DESIGNER) CAN… =
  * With the click of a button you can send the design’s review link to a client for approval. (An automatic confirmation email will be sent to both parties.)
  * Change the text in all automatic confirmation emails.
  * Display your company logo.
  * Display “Designer” notes for the client to read.
  * Display project start and end date.
  * Display ”Client” notes to assure the client you have completed all the things they have requested.
  * …and more.

 = THE CLIENT CAN… =
  * Approve designs. (An automatic email confirmation will be sent to both parties.)
  * See project start and end date.
  * See “Designer” notes.
  * See “Client” notes to double check the designer has completed all the things they have requested.
  * …and more.

= THE PLUGIN CAN… =
  * Send automatic confirmation emails.
  * Shows a STAR on approved Designs on the Project Board.
  * Adds clients approved signature to the database and can be view in the details area of design on the Project Board.
  * Display a versions menu to show previous versions of a design.
  * Hide notes to show just the design on the design review page. (Especially nice for web designers wanting to show what a design will look like on a page.)
  * Show you a list of all of your clients and projects! (Project Board page)
  * …and more.

= SUPPORT FORUM =
  * Having problems, or possibly looking to extend our plugin to fit your needs? You can find answers to your questions or drop us a line at our [Support Forum](http://www.slickremix.com/support-forum/).

= THEMES AND EXTENSIONS =
  [Click here to view the Premium Extension.](http://www.slickremix.com/downloads/category/design-approval-system/)

  If you would like to contribute in translating please [visit us here](http://glotpress.slickremix.com/projects).

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Change-log ==

= Version 4.3.2 / Thursday August 31st, 2017 =
  * FIXED: Rename a CSS class that was causing some conflicts with some themes.

= Version 4.3.1 / Friday July 14th, 2017 =
 * FIXED: Public/Private Project Board properly shows based on current logged in User Role, eliminating clients being able to see ALL das users projects listed. (issue was only appearing for some people using DAS)
 * NOTE: This update is also safe for any of our custom DAS clients out there.

= Version 4.2.8 - 4.3.0 / Friday June 30th, 2017 =
 * NEW: Added password hash for SMTP password input option so now you can't see the password even if you view the source.
 * NEW: The versions pop up now shows a star for the approved version and a white background for the active state of the current version you are viewing.
 * NEW: Added label around the terms checkbox in the Approve popup box making it easier to check the box.
 * FIXED: When editing a design post on the front end the email would repeat if you re-edited the post on the same page and re-saved.
 * CHANGED: The Create New Client tab and inputs containing the word Client have been changed to the word User instead.
 * NEW PREMIUM: Additional column on the WooCommerce Orders page that shows the Product created from the DAS design. More options on the WooCommerce tab under the Template Settings page of our plugin.
 * NEW PREMIUM: An approved star now appears in the Archived Projects too.
 * [NEW DAS MANAGER EXTENSION](https://www.slickremix.com/downloads/das-manager-extension/): Do you have a manager who needs to sign off on the designers work before it's sent to the client? If so this plugin is for you!

= Version 4.2.7 / Tuesday April 25th, 2017 =
 * ATTENTION: This update will also require you to update the Custom Email Extension too. We fixed an issue where the email was not formatted properly on some servers.
 * NEW: System Info page has been updated to show more relevant information.
 * NEW: Now the Project board is tied together by the Customers Name and not the email. This will let you change the email to something else in each design posts if you needed to.
 * NEW: When you search for something now on the Project Board you will see a Header stating you are viewing Search Results.
 * NEW: Clients name, date approved and message now appear under the Project Comments box on a the front end of a design post. The information will also appear on the project board too. You can choose to turn this option off from the Template settings page under the option called "Approval Name, Date & Message." [View Example](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v3/)
 * NEW: When the client is logged into the project board they will now see a search projects option.
 * NEW: Plugin License page that shows the extensions this plugin offers.
 * EDIT: Adjusted some text to make the options more clear on the Create New Customer tab under the Project Manager.
 * FIXED: No more php warnings for some unset variables.
 * FIXED: Missing registered setting
 * FIXED: Admin/Designer and Client projects now appear in order of newest at the top.

= Version 4.2.6 / Friday March 3rd, 2017 =
 * FIXED: Issue with subject not showing properly when using the Custom Emails extension.

= Version 4.2.5 / Wednesday March 1st, 2017 =
 * NEW: Brand New UI for the Settings and Template Settings page making it easier to navigate all the options.
 * NEW: If a client submits comments when they approve a project those comments will appear on the project board and also under the design post if you edit it.
 * FIXED: Generic tabs class conflict with other plugins/themes. Now we .das-tabs.
 * FIXED: The default emails where missing some text. Now it's easy to see what the default emails look like by pressing the Send Test Email button under each form.
 * FIXED: Design URL's now have an a tag element wrapped around them to help prevent de-linking in email programs.
 * NEW CUSTOM EMAILS EXTENSION: [See details and photos here](https://www.slickremix.com/downloads/das-custom-emails-extension/). This email editing method could not be easier and will make your company look more professional.
 * NEW PREMIUM OPTION: If you use WooCommerce and want to customize the login url on the Project Board page that is now possible.

= Version 4.2.4 / Tuesday February 7th, 2017 =
 * NEW: When setting up your email messages on the Settings page of our plugin you now have a Send Test Email button under each form. Now you don't have to setup a design before hand to test what each of the responses look like to designers or clients.
 * FIXED: Removed an unused add_filter option that was causing other html templates to not be constructed properly.

= Version 4.2.3 / Friday February 3rd, 2017 =
 * NEW: When a client submits comments the designer for that project will get an email with the project details, message from client and a link to view the project. This is for the wp comments not the client changes option.
 * FIXED: Last letter of email name was getting cut off. wp_mail() bug. Corrected by adding an additional space after the name just before the start of the email address.

= Version 4.2.2 / Tuesday February 2nd, 2017 =
 * NEW: All forms now use wp_mail(). Our SMTP will still work with this too but now you can also install any 3rd party SMTP plugins and they should work with our plugin.
 * NEW: All Email forms are HTML formattable on the Settings page now.
 * NEW: Each Email form has a set of Shortcode options available to format the emails to your liking. We will be creating a premium email template plugin in the near future.
 * NEW: Settings page and Template Settings page have a new UI.
 * NEW: ALL CSS and JS files have been minified.

= Version 4.2.1 / Thursday January 26th, 2017 =
 * Revert last update as SMTP is failing. By next week the php mailer file will be removed and we will be using the wp_mail function for all forms.

= Version 4.2.0 / Wednesday January 25th, 2017 =
 * Update php mailer to coincide with latest wp update 4.7.1 security standards.

= Version 4.1.9 / Tuesday January 17th, 2017 =
 * FIX Project Board: Miss-labeled field for Project Name.
 * FIX Approval Template: CSS tweaks.

= Version 4.1.8 / Friday July 22nd, 2016 =
 * FIX Project Board Error when first setting up DAS.

= Version 4.1.7 / Wednesday April 13th, 2016 =
 * FIX FOR WP4.5 UPDATE: Replace calls to get_currentuserinfo() with wp_get_current_user()
	
= Version 4.1.6 / Friday April 1st, 2016 =
 * NEW: CSS adjustments in admin settings pages.
 * NEW PREMIUM: Admins & Designers: Limit the amount of design posts that show for each project on the Project Board. A loadmore option will be availble as well. You can also choose to show the first design last and vise versa all from the Template Settings page of our plugin.
	
= Version 4.1.5 / Monday March 7th, 2016 =
 * FIXED: Project Board functoins did not get uploaded properly.
 * FIXED: Now Designs are sorted by Project id via the Project Board not the design name. This improves errors if you are creating posts on in wp-admin and do not make the design name the same as the project name.
	
= Version 4.1.4 / Sunday March 6th, 2016 =
 * NEW: Create Next icon for Project Manager on the front end.
 * NEW: CSS clean up and style adjustments throughout the Project Manager and the GQ Template.
 * NEW: Project are listed by most recent on the Project Board now.
 * FIXED: Archived projects were not getting pagination option.
 * FIXED: Archived/Unarchived search return with no results had wrong link to return to archive/unarchived page in wp-admin.
 * FIXED: Project Board was loading very slow with more than a 100 projects.
	
= Version 4.1.3 / Sunday February 28th, 2016 =
 * NEW: Design Post and Create New Project from Project Manager: Now you will see a Invoice Link option where you can give the customer a breakdown. Click the Upload Invoice button now provided and upload your PDF or image and a View Invoice link will under the Project Details section of the the design page. You could always put a link to a payment option instead of a pdf or image too. Our next major update will allow you to take paypal payments and a premium option to take paypal credit card payments.
 * NEW: Premium: Many New Options in the [1.0.2 update](http://www.slickremix.com/downloads/das-premium/).
	
= Version 4.1.2 / Saturday February 20nd, 2016 =
 * NEW: Now logged out users will be able to approve designs and the info will record to the database. If you have the premium version now client changes while being logged out will also be recorded to the database.
 * FIXED: Not able to see project board if selecting any other role besides das_designer or das_client from the User Role option on the Settings page of our plugin.
	
= Version 4.1.1 / Tuesday February 2nd, 2016 =
 * FIXED: When using the Client Changes option the media link and client changes notes were not showing on the front of design after submission.

= Version 4.1.0 / Thursday September 3rd, 2015 =
 * ADJUSTED: Default option is now 25 for the Project Board on the front end.
 * FIXED: Problem with custom title names not displaying correctly when premium version active.
	
= Version 4.0.9 / Monday August 24th, 2015 =
 * FIXED: Issue with media button and a few others being hidden when our is plugin active on Multisite Installs.
 * FIXED: Notice on project board for multisite installs.
 * FIXED: Extra space in wp-admin menu when das_clients are logged in.
	
= Version 4.0.8 / June 8th, 2015 =
 * MAJOR CHANGES TO DAS: 4.0.8 is a Major Update so it is important that you read the upgrade notice and changes before upgrading, <a href="http://www.slickremix.com/design-approval-system-major-changes" target="_blank">please click here</a>. All current premium extension owners will be getting a coupon to receive the new DAS Premium Plugin. Here is a link to [Version 4.0.6](http://www.slickremix.com/wp-content/uploads/2015/05/design-approval-system-4.0.61.zip) if your plugin was updated by mistake, version 4.0.7 was just a pre-notification changes to come.

= Version 4.0.7 / Saturday May 9th, 2015 =
 * NOTICE ABOUT MAJOR CHANGES COMING TO DAS: 4.0.8 will be a Major Update so it is important that you read the upgrade notice and changes before you update this plugin again to 4.0.8. To see what changes and improvements we have made <a href="http://www.slickremix.com/design-approval-system-major-changes" target="_blank">please click here</a>. All current premium extension owners will be getting a coupon to receive the new DAS Premium Plugin. We are making this update as a pre-notice of the changes to come. If you do not like the changes we will be providing a backup of DAS 4.0.7 will be available on the changes and improvements link above too.
	
= Version 4.0.6 / Wednesday February 4th, 2015 =
 * FIXED: Edit and Send Email link from showing when Das Client is logged in. Now only admin and Das Designers will be able to see those links. 
 * ADDED: CSS adjustments for design approval template.
 
= Version 4.0.5 / January 20th, 2015 =
 * FIXED: Major php bug for users who did not have magic quotes turned on in a php.ini file. Now templates, project board and forms all work as they should.

= Version 4.0.4 / December 30th, 2014 =
 * FIXED: CSS bug in default template. Now looks proper on mobile and tablet devices. [Example](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v1/)

= Version 4.0.3 / December 20th, 2014 =
 * NEW: DAS Now works with Multisite Installs. IMPORTANT! Do not network active. To make this work you must activate each install you want on each subsite you create for your multisite install.
 * FIXED DEFAULT TEMPLATE: Edit and Send Email links showing when DAS Clients are logged in, they now do not.
 * FIXED: CSS bug on the default template for design notes.
 * Happy Holidays from all of us at SlickRemix!

= Version 4.0.2 / December 12th, 2014 =
 * FIXED: Faster wp-admin loading now

= Version 4.0.1 / December 3rd, 2014 =
 * NEW: Admin menu icon
 * FIXED: Shorthand php tag in das-meta-box.php on line 386
 * REMOVED: Stray testing submit button at the bottom of settings page
 
= Version 4.0.0 / September 11th, 2014 =
 * ADDED: SSL/TLS select option on the settings page. Users with Client Changes plugin will want to upgrade that too in order for the new option to take effect. Visit your My Account page or if you have entered you license key you should get an update notice.
 * ADDED: es_ES Spanish mo and po files added. Translation Courtesy: Andrew Kurtis. [WebHostingHub](http://www.webhostinghub.com/)
 
= Version 3.8.9 / August 25th, 2014 =
 * ADDED BACK: By popular demand clients do not have to login to approve or make changes. You can view these new options on the das settings page. If you have the client changes extension an option for not requiring login will appear as well.
 * ADDED: Additional notes on first tour pointer about using the free duplicate post plugin to make the task of creating version easier for clients.
 * FIXED: Removed general function name from wp pointer that was causing a conflict with another theme using the same function name.
 * EDITS: Admins and Designers can see the Private Project Board on the front end.
 * EDITS: Additional front end Project Board CSS fixes to override themes h1, p, ul tags etc.
 * EDITS: Default template CSS.
 
= Version 3.8.8 / August 13th, 2014 =
 * IMPORTANT: Make sure you have all the most recent updates for your premium plugins before updating. You can find your plugins in the my account area of slickremix.com [http://slickremix.com/my-account](http://slickremix.com/my-account)
 * EDITS: Front end Project Board CSS fixes.
 * EDITS: New custom string for login on the Default Template.
 * EDITS: Only allow Admins to view or restart the tutorial.

= Version 3.8.7 / Saturday August 9th, 2014 =
 * IMPORTANT: Make sure you have all the most recent updates for your premium plugins before updating. You can find your plugins in the my account area of slickremix.com [http://slickremix.com/my-account](http://slickremix.com/my-account)
 * NEW PREMIUM PLUGINS: Today marks the day we launch the GQ Theme/Template for DAS and the Woocommerce for DAS plugins. See our shop at slickremix.com.
 * ADDED: Additional functionality for the new WooCommerce for DAS plugin.
 * FIXED: Register settings options correctly.
 * FIXED: When deactivating or removing the plugin the user roles will be removed.
 * FIXED: Register settings options correctly.
 * EDITS: All php Notices when wp debug mode is on have been corrected.
 * EDITS: CSS tweaks to the Project Board.

= Version 3.8.6 / Wednesday July 30th, 2014 =
 * NEW: Language files for German and Portuguese. Add de_DE for German or pt_BR for Portuguese in your wp-config.php
 * NEW: Brand new walkthrough using wordpress pointers. You can retake the tour at any time by visiting the Help page in our DAS menu.
 * NEW: php5.3 check on the Help page. If you are not at least running php5.3 a notice will warn that you need to update.
 * FIXED: Plugin update notices
 * FIXED: flushrewrite for custom post type and taxonomy. Using proper method on activation now.
 * UPDATED: Removed the news, videos and re-take tour menu items and pages.
 * UPDATED: Project Board is now fully responsive, so it looks and works great on desktops, tablets and mobile devices and with different languages.
 * UPDATED: Previous users of the premium project board will need to update to our new plugin that combines both the public and private project board. Existing users will not have to pay for this upgrade.
 
= Version 3.8.5 / Thursday June 12th, 2014 =
 * FIXED: Single Template override wrong.
 * FIXED: Single Template path fixed.

= Version 3.8.4 / Wednesday June 11th, 2014 =
 * MUST READ: All premium plugin users must de-activate your das extensions before updating to this next version.
 * MUST HAVE: PHP 5.3 or above to run DAS and any extensions.
 * FIXED: Fatal Error on some installs.
 * FIXED: If you have the Premium Client Changes plugin the option for Paid or Not paid is now available under the 'Client Info' tab on a design post.
 * FIXED: wp-admin Project Board will now show all design posts to the DAS Client no matter what the amount of blog posts to be shown is set to in the reading settings wordpress menu. And breath :)
 * FIXED: Get more extensions links.
 * FIXED: CSS overhaul on the default template that fixes many elements to work with bootstrap or other themes using box-border.
 * FIXED: Default Template: we changed the logo db call in the settings page so you will have to resave the DAS settings page for your logo to appear again.
 * THANKS: Big up to Gordon and a few others for brining the fatal error to light and helping us debug for DAS and the Private Project Board premium plugin, which is set for a new update in the next day as well. Check out Gordon's site here. [http://www.webdesignperth.com.au/](http://www.webdesignperth.com.au/)

= Version 3.8.3 / Thursday June 5th, 2014 =
 * FIXED: Project Board update on update 3.8.1

= Version 3.8.2 / Thursday June 5th, 2014 =
 * FIXED: Default template update on update 3.8.1

= Version 3.8.1 / Thursday June 5th, 2014 =
 * REQUIRED: If you update this version of DAS you will also need to update any premium plugins you've purchased as every DAS plugin except the User Roles, Public and Private Project Board plugin have been updated. We will be updatin the Public and Private Project Board shortly after as well.
 * FIXED: Logo upload now uses the latest media frame.
 * FIXED: No Longer will you have to copy our template files into your child theme.
 * FIXED: If you do not enter a date in the 'When the project will start and end' option in a design post the option will not display on the template now. The Clean Theme has also been edited to work this way.
 * NEW: You can now create a folder called das in your theme if you want to customize any of our templates. This way if you do an update to DAS the changes will not effect your custom template. Existing das users template customization will not be effected and will still be used if already in place.
 * NEW: DAS does not require the use of the plugin 'custom post template' anymore. We have finally created our own template selection option in the tabs are of our design edit options.
 * NEW: DAS is now multi-language ready. We are currently working on a German version. If you would like to contribute we are willing to pay for your help. [See more here](http://glotpress.slickremix.com/projects).
 * NEW: The Design Approval System Fields on the design edit pages have been completely re-designed with tabs.
 * NEW: The Default Template is now WooCommerce ready, meaning if you have installed our new 'WooCommerce for the Design Approval System' plugin an option to create this design into a product and price option will be a tab on the design edit area. Then your price and add to cart button will appear next to the main logo. The Clean Theme has been updated with this feature too and the GQ theme also comes with this feature built in.
 * NEW: [Premium QG Theme](http://www.slickremix.com/product/gq-theme-das-extension/). WooComerce ready, uses wordpress comments, and allows for media uploads. A must see!
 * NEW: If you have the ['WooCommerce for Design Approval System'](http://www.slickremix.com/product/woocommerce-for-design-approval-system/) plugin installed and a customer purchases a product an icon will appear next to the approved icon on that design.
 
= Version 3.8 / January 11th, 2014 =
 * UPDATED: UI overhaul for 3.8 wordpress update and all premium extensions. If you don't care about the 3.8 version update then don't worry about updating just yet.
 * FIXED: Replaced depreciated function for WP Max Upload Size on the help/system info page.
 
= Version 3.7 / September 7th, 2013 =
 * Big thanks to all those who have been helping on the forum or sending emails in regards to suggestions and security issues, we could not do it without you all! 
 * FIXED: Security issue with walkthrough in WP admin, leaving it open to XSS attack. Needed to sanatize the step process, all good now. Thanks to [http://www.ibliss.com.br/](http://www.ibliss.com.br/) for pointing this out.
 * FIXED: Issue with posts being limited on the Project Board because of the number of posts set in wp settings page.
 * FIXED: Depreciated call 'caller_get_posts' changed to 'ignore_sticky_posts' on the admin Project Board.
 
= Version 3.6 / August 25th, 2013 =
 * FIXED: Additional security check added to the das-header.php so clients can't view other clients projects. Thanks to JetDingo for bringing this to our attention in our [support fourm](http://www.slickremix.com/support-forum/wordpress-plugins-group3/design-login-extension-forum6/possible-security-issue-login-work-around-public-can-view-all-designs-without-logging-in-thread122.0/#postid-564).
 * FIXED: Additional security check added to das-functions.php to redirect all users that try to access the site url on front end to view active projects coming from the content loop. (*ie. http://www.slickremix.com/testblog/?post_type=designapprovalsystem&page=design-approval-system-projects-page). So anything containing the word ?post_type=designapprovalsystem in the URL will get redirected to the home page. Additional Thanks to JetDingo for pointing this out. If you want to be able to view projects on the front end we do have the Public Project Board available ($5.00). See [more details here](http://www.slickremix.com/product/public-project-board-das-extension/).
 
= Version 3.5 / August 18th, 2013 =
 * FIXED: Possible fatal error on some installs regarding the function st4_columns_head() in our functions.php file. This function has been removed now. Thanks to 'aspirenetwork' for pointing this out. [Link to original post](http://wordpress.org/support/topic/error-in-activatiing-the-plugin?replies=8)
 * REMOVED: Tags from column for the designs list page in the wp-admin.

= Version 3.4 / June 30st, 2013 =
 * FIXED ADMIN: Misc CSS Fixes for Firefox
 * FIXED ADMIN: Enqued scripts only on DAS admin pages
 * NOTE: You must update to DAS 3.4 if you are going to update to the new Clean Theme Version: 2.1 (This version allows you to fully customize the theme to fit your company looks).

= Version 3.3 / June 21st, 2013 =
 * FIXED: Project Board for clients, title correction.
 * FIXED: Firefox CSS fixes on default theme and project board. 
 
= Version 3.2 / June 16th, 2013 =
 * SPECIAL CHANGE & ADDITION: We have updated the menu to a more comprehesive flow. In addition we have added a Special Walk-Through of the menu and a more easy to understand way to work the Design Approval System. We have spent hundreds of hours on this new update between only 2 people. Justin and Spencer Labadie and of course the countless others input to help further this project! Thanks to Everyone who have helped progress this plugin, and to all our premium extension buyers… You help motivate us beyond belief!
 * ADDED: Wordpress header and footer are now in the the default and clean theme, this allows for the Wordpress menu bar to be visible and more. 
 * ADDED: Now when projects are approved the signature is submitted to the database and will show up on the project board details. And once a client submits there signature they will not be able to approve that design again, unless you change the approved select option on the design edit page. You will also see the clients signature on the design edit page too.
 * ADDED: A STAR will appear on the row of the Project Name and the version in that project on the Project Board. FYI. For existing users of the DAS we added a meta field so you can manually approve designs if you want.
 * ADDED: DAS Client and DAS Designer are now default user roles. This means when signing up Clients and Designers you can specify that role and they will only be able to access certain areas when logging in. For instance if you sign up a client as a DAS Client they will only be able to view the project board, change password for themselves and Approve a design on the front end. They will not be able to edit posts or anything else. DAS Designers on the other hand will see the DAS and be able to post designs.
* CHANGES/ADDITIONS: Default Theme, modifications to forms to allow for new forced login to approve designs. And ajax submit on Approval Signature. If you use the Design Login premium extension you will get a login screen before the client see's the design. Plus this keeps the general public from stumbling upon your designs.

= IMPORTANT NOTES FOR OUR PREMIUM EXTENSION USERS, You must update all your purchased DAS premium plugins when upgrading to 3.2 =
 * CHANGES/ADDITIONS:  Client Changes, you'll now notice the client requests on the front end submit to database and automatically update on the page via ajax. We also added TinyMCE to the form so your clients can comment with style.
 * CHANGES/ADDITIONS: Clean Theme, modifications to forms to allow for new forced login to approve designs. And ajax submit on Approval Signature.
 * CHANGES/ADDITIONS: The Design Login now looks for existing wordpress users, and logs them in via ajax. This means you'll need to create a user for your client. Make sure you choose DAS Client as the role when setting them up, so when a DAS Client user logs in they'll only see the project board, and there user info. Required update if you are running DAS 3.2
 * REMOVED FROM DESIGN LOGIN: Custom username and password on post pages. Sorry for the inconvenience, but this new method is much more secure. 
 * CHANGES: Roles extension, misc edits to work with DAS 3.2.  


= Version 3.1 / March 31, 2013 =
 * ADDED: Designers can now add there email address to a design post, or just leave it blank and the settings page email will still receive the email notifications. This was added so larger companies with more than one designer, photographer, video editor, etc. on board can also receive email notifications for a particular design post.
 * ADDED: Newly styled UI for the design post fields area.
 * IMPORTANT: You MUST update your Client Changes premium plugin if you have purchased it. Updated version should be 1.5. The Clean Theme should also be updated if you have purchased that. Updated version should be 1.9

= Version 3.0 / March 23, 2013 =
 * MAJOR FIX! Missing SMTP Files. Please Upgrade to 3.0 and your sendmail and SMTP will work.

= Version 2.9 / March 22, 2013 =
 * MAJOR UPDATE!
 * NEW: Clients can login to view there designs. Simply make a Wordpress user for them. Once they login they will see the DAS menu with Project Board.
 * NEW: SMTP options are now available on the settings page. Hopefully this will solve a lot of email problems on servers that don't like sendmail. We have updated to the newest versions of class.phpmailer.php and jquery.forms.js for more flexibility and security.
 * FIX: Misc. CSS fixes for desktop and mobile on project board and default template.
 * FIX: Clean Theme now shows Version number in subject for the Approval option.
 * IMPORTANT: You MUST update your Client Changes premium plugin as well if you have purchased it. Updated version should be 1.4
 * NOTE: We are still looking into child theme issues and themes that don't follow general theme structures. If you are having problems please reffer to our forum for help. Quite of few people have figured out work arounds.
 
= Version 2.8 / January 22, 2013 =
 * NEW: Project Board Page. Now your design posts are all organized.
 * FIX: Default Template now has the_content instead of get_the_content. Now shortcodes will work.  
 
= Version 2.7 / January 4, 2013 =
 * Settings Page Fix: MESSAGE TO CLIENT (OPTIONAL) text area field has been fixed.
 * NOTE: This also effects the Clean Theme premium extension too, so make sure and update that plugin as well.  
 
= Version 2.6 / January 2, 2013 =
 * Revised: How the subject field of emails are displayed. This was changed to help people be able to search or sort emails more efficiently. This is the new way the subject is displayed, Name of Design First, Design Version 2nd and the Company or Client name 3rd. EXAMPLE. Subject: Redbull Flyer - Version 1 - SlickRemix
 * MUST: You must also update the client changes premium extension and clean theme premium extension for the changes noted above to take effect.
 * NOTE: If you have made custom changes to either the default template or the clean theme template you may want to save a copy of them before updating or those files will be overwritten.
 
= Version 2.5 =
 * Added: New admin DAS logo for left-side menu, with added Retina support.
 * Added: Additional admin CSS improvements.
 
= Version 2.4 =
 * Fixed: Show Design Option. We removed an extra comma causing error when using jQuery 1.8.0+
 
= Version 2.3 =
 * NEW: DAS Videos page to admin menu!
 * NEW: DAS News & Updates page to admin menu!
 * NEW: Help page added to admin menu!
 * Added: Animated links and buttons through-out.
 * Fixed: "Upload Image" jQuery duplication.

= Version 2.2 =
 * Added: Fixed "Upload Image" jQuery confliction with themes.

= Version 2.1 =
 * Added: Additional CSS for default template.
 
= Version 2.0 =
 * Important: Back up any file that you may have customized before doing update.
 * Revised: How DAS Framework works.
 * Added: New Framework
 * Added: Added features for 2 new plugins.
 
= Version 1.9 =
 * Revised: CSS and jQuery for versions drop down menu. Now works in Firefox.
 * Fixed: Select user and email bugs. 
 
= Version 1.8 =
 * Added: Settings Page is now set up for new Roles Extenstion options.
 * Added: Options to DAS Meta Box for new Roles Extenstion switching "Designer Name", "Client Name" to drop downs and "Client email" to auto fill input to email of the client selected.
 * Tested: The DAS Plugin, Themes, and extenstions for any bugs against the new (Beta) version of WordPress 3.5  
 
= Version 1.7 =
 * Fixed: Settings Page is now set up for new theme options.
 * Fixed: jQuery on Settings Page now compatible with new themes.

= Version 1.6 =
 * Fixed: No more auto selection of post template. (We are now offering more themes) [If you purchase one of our themes you may select which theme you would like to use for each individual post.]
 * Added: Size for "Clean Theme" to settings page.

= Version 1.5 =
 * Fixed: Duplicated page in template file.

= Version 1.4 =
 * MAJOR FIX - Fixed: Javascript on design post page NOW working. (ATTENTION EVERYONE - THIS UPDATE is NEEDED for DAS plugin to work PROPERLY! ALL Previous versions have NOT been working!)
 * MAJOR FIX - Fixed: Versions menu to work.
 * Added: "Designer's Name" field back into post backend.
 * Fixed: updated screen shots on settings page to match correct text.

= Version 1.3 =
 * MAJOR FIX - Fixed: Post Paged getting "404 Page Not Found error".  

= Version 1.2 =
 * Fixed: Screen shot #8 (Thank You message)
 * Added: Paypal Donate Button to settings page.
 * Added: Facebook "Like" Button to settings page.
 * Added: A new FAQ.
 
= Version 1.1 =
 * Fixed: Custom Post Type auto selection.
 * Removed: Two fields from DAS post page that were not needed.
 * Fixed: Duplicated jQuery files now using WordPress's included jQuery.
 * Fixed: Relative URLS to have dynamic paths. (For WordPress users who do not have WordPress installed on the root of their server)

= Version 1.0 =
 * Initial Release

== Frequently Asked Questions ==

= My client and I are not getting the emails? =

IMPORTANT: Please be sure to let your clients know that usually the first design email you send will most likely end up in their Spam/Trash! After they find have your client mark it as "not spam".

= Do you offer support? = 

Yes, if you are having problems, or possibly looking to extend our plugin to customize your needs? You can find answers to your questions or drop us a line at our [Support Forum](http://www.slickremix.com/support-forum/).

= Are there Extensions for this plugin? =

Yes. You can view them [here](http://www.slickremix.com/downloads/category/design-approval-system/)

== Screenshots ==

Simple Documentation along with screenshots can be [found here](https://www.slickremix.com/design-approval-system-docs/)

See [Live Demo](http://www.slickremix.com/testblog/designs/idriveeurope-about-page-v1/) and Approve the design.