<?php
/**
 * Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title(); ?></title>

<!-- font awesome -->
<link rel="stylesheet" href="<?php echo get_site_url() . '/wp-content/themes/bootstrap/css/font-awesome.css'?>">
<!-- font awesome -->

<script src="https://use.fontawesome.com/810305e344.js"></script>
	<?php
	  /*
	   * We add some JavaScript to pages with the comment form
	   * to support sites with threaded comments (when in use).
	   */
	  if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	  /*
	   * Always have wp_head() just before the closing </head>
	   * tag of your theme, or you will break many plugins, which
	   * generally use this hook to add elements to <head> such
	   * as styles, scripts, and meta tags.
	   */
	  wp_head();
    ?>





<script src="<?php echo get_site_url() . '/wp-content/themes/bootstrap/js/rellax.min.js'?>"></script>

<link rel="stylesheet" href="<?php echo get_site_url() . '/wp-content/themes/bootstrap/css/owl.carousel.min.css'?>">
<link rel="stylesheet" href="<?php echo get_site_url() . '/wp-content/themes/bootstrap/css/owl.theme.default.min.css'?>">





  </head>
  <body <?php body_class(); ?>>

<header id="siteHeader">

    <nav id="site-navigation" class="navigation main-navigation" role="navigation">
      <div class="container">

        <h1>
        <a href="<?php echo get_site_url(); ?>">
        <img class="logo" src="<?php echo get_site_url() . '/wp-content/uploads/2017/10/rightsideLogo.png'; ?>">
        </a>
        </h1>

   <!-- primary menu -->

    <div class="nav-menu">



      <?php  if( have_rows('menu_items', 'option') ): ?>

            <ul id="primary-menu">

          <?php

          // loop through rows (parent repeater)
          while( have_rows('menu_items', 'option') ): the_row(); ?>
        <li class="menu-item">
              <a href="">
                <?php the_sub_field('menu_section_name'); ?></a>
              </li>
          <?php endwhile;  ?>
          </ul>

        <?php endif;  ?>
        </div>
   <!-- primary menu    -->
<!-- social -->

        <?php if( have_rows('social_links', 'option') ): ?>
        <ul id="socialSearch">
        <?php while ( have_rows('social_links', 'option') ) : the_row(); ?>
        <li>
            <a href="<?php the_sub_field('link'); ?>" target="_blank">
        <i class="fa fa-<?php the_sub_field('name'); ?>"></i>
        <!-- <?php the_sub_field('name'); ?> -->
        </a>
        </li>
        <?php
            endwhile;
        ?>
        </ul>
        <?php
        else :
        endif;
        ?>

<!-- social -->

      </div>
      <ul id="openmenu" class="nav-menu">
        <!-- header menu -->
        <?php  if( have_rows('menu_items', 'option') ): ?>
          <div class="secondary-menus">
          <?php

          // loop through rows (parent repeater)
          while( have_rows('menu_items', 'option') ): the_row(); ?>
            <div class="secondary-menu"><div class="container">
              <?php

              // check for rows (sub repeater)
              if( have_rows('sub_menu_items') ): ?>

                <ul class="nav-directory hidden-xs">
                <?php

                // loop through rows (sub repeater)
                while( have_rows('sub_menu_items') ): the_row();

                  // display each item as a list - with a class of completed ( if completed )
                  ?>
                  <li class="title">
                    <a href="<?php the_sub_field('link'); ?>">
                      <h4>
                      <?php the_sub_field('name'); ?>
                      </h4>
                <div class="sub-menu-description">
                      <?php the_sub_field('description'); ?></a>
                      </div>
                </li>

                <?php endwhile; ?>
                </ul>
              </div></div>
              <?php endif;  ?>
          <?php endwhile;  ?>
          </div>
        <?php endif;  ?>


<!-- header menu -->
      </ul>

<div class="secondary-menus">


<div class="secondary-menu"><div class="container">first</div></div>
<div class="secondary-menu"><div class="container">second</div></div>
<div class="secondary-menu"><div class="container">third</div></div>
<div class="secondary-menu"><div class="container">fourth</div></div>
<div class="secondary-menu"><div class="container">fifth</div></div>
<div class="secondary-menu"><div class="container">six</div></div>
</div>




<div class="menu-icon">
<i class="fa fa-bars" aria-hidden="true"></i>
</div>
    </nav><!-- #site-navigation -->

<div class="mobile-menu">

  <div class="mobile-menu-container">
<div class="container">



<div class="retract-menu">

<i class="fa fa-times" aria-hidden="true"></i>
</div>

</div>

<div class="container">

<div class="row">
      <div class="nav-menu">

      <?php  if( have_rows('menu_items', 'option') ): ?>

            <ul id="primary-menu" class="mobile-accordion">

          <?php

          // loop through rows (parent repeater)
          while( have_rows('menu_items', 'option') ): the_row(); ?>
        <li class="menu-item">
              <a href="">
                <?php the_sub_field('menu_section_name'); ?></a>






              </li>

<li>

<!-- sub list -->
<!-- sub list -->
<!-- sub list -->

      <?php
              // check for rows (sub repeater)
              if( have_rows('sub_menu_items') ): ?>

                <ul class="mobile-sub-list">
                <?php

                // loop through rows (sub repeater)
                while( have_rows('sub_menu_items') ): the_row();

                  // display each item as a list - with a class of completed ( if completed )
                  ?>
                  <li class="">
                    <a href="<?php the_sub_field('link'); ?>">
                     <span style="color: #000;"> <?php the_sub_field('name'); ?></span>
                </a></li>

                <?php endwhile; ?>
                </ul>

              <?php endif;  ?>

<!-- sub list -->
<!-- sub list -->
<!-- sub list -->

</li>


          <?php endwhile;  ?>
          </ul>

        <?php endif;  ?>
        </div>







</div>

</div>



</div>
</div>




</header>







<!--     <?php $header_image = get_header_image(); ?>
    <div class="blog-header" <?php if ( get_header_image() ) : ?>style="background-image: url( '<?php echo esc_url( $header_image ); ?>'); background-size: cover; background-repeat: no-repeat; background-position: top left; margin-bottom: 30px; width: 100%; height: 100%; min-height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; position: relative;"<?php endif; ?>>
      <div class="container main-panel" <?php if ( get_header_image() ) : ?>style="height: auto; min-height: <?php echo HEADER_IMAGE_HEIGHT; ?>px; position: relative;"<?php endif; ?>>
        <?php if ( display_header_text() ) : ?>
        <?php $header_text_color = get_header_textcolor(); ?>
	<?php if ( function_exists( 'the_custom_logo' ) ) :
	  the_custom_logo();
	endif; ?>
        <h1 class="blog-title" style="color: #<?php echo $header_text_color ?>;"><?php bloginfo( 'name' ); ?></h1>
        <p class="lead blog-description" style="color: #<?php echo $header_text_color ?>"><?php bloginfo( 'description' ); ?></p>
        <?php else : ?>
        <h1 class="blog-title" style="visibility: hidden; margin: 0; padding: 0; font-size: 0;"><?php bloginfo( 'name' ); ?></h1>
        <p class="lead blog-description" style="visibility: hidden; margin: 0; padding: 0; font-size: 0;"><?php bloginfo( 'description' ); ?></p>
        <?php endif; ?>
      </div>
    </div> -->




<?php

// check if the flexible content field has rows of data
if( have_rows('modules') ):

     // loop through the rows of data
    while ( have_rows('modules') ) : the_row();


// content module
// content module

        if( get_row_layout() == 'page_header' ):
?>

<header class="revert-second-menu" id="pageHeader" style="background-image: url(http://i.imgur.com/PfU99Uo.jpg);-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
  <img src="http://i.imgur.com/PfU99Uo.jpg" width="1200" height="386" alt="" style="margin-top: 0px; margin-bottom: 0px;display: none;">
  <div id="pageHeaderContent">
    <div class="container">
      <div class="row col-md-7">
        <h1>


<?php the_sub_field('title') ?>

        </h1>




      </div>
    </div>
  </div>
</header>




<?php elseif( get_row_layout() == 'video_header' ): ?>


    <div class="fullscreen-bg">
    <video loop muted autoplay poster="img/videoframe.jpg" class="fullscreen-bg__video">
        <source src="<?php echo get_site_url() . '/wp-content/uploads/2017/10/donuts_home_v5.mp4'?>" type="video/mp4">
    </video>
</div>






<?php endif; ?>
<?php endwhile; ?>
<?php endif; ?>

<!-- end header modules -->
<!-- end header modules -->



<!-- beginning of parralax boundary -->
<div class="revert-second-menu rellax" data-rellax-speed="4">
<!-- beginning of parralax boundary -->







