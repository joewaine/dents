<?php
/**
 * Template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

	get_header(); ?>




<?php

// check if the flexible content field has rows of data
if( have_rows('modules') ):

     // loop through the rows of data
    while ( have_rows('modules') ) : the_row();


// content module
// content module

        if( get_row_layout() == 'tld_example_module' ):
?>

<section class="bkgd-dark top-border">
<div class="container">


    <h2 class="text-center">
<?php the_sub_field('tld_intro_text'); ?>
</h2>

                                  <?php if( have_rows('tld_item_repeater') ): ?>
                                  <div class="tldIcons container text-center">
                                  <?php while ( have_rows('tld_item_repeater') ) : the_row(); ?>

                                  <div class="col-tld-icon">
                                  <a href="<?php the_sub_field('link') ?>">
                                  <span class="icon-circle">
                                    <?php if(get_sub_field('image')){ ?>
                                   <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('name'); ?>">
                                   <?php } ?>

                                  </span></a></div>

                                  <?php  endwhile; ?>

                                  <div class="col-tld-icon last">

                                  <a class="icon-circle" href="/what-we-do/top-level-domains/">
                                  See all TLDs &gt; <span><i class="icon-caret-right"></i></span>
                                  </a>
                                  </div>


                                  </div>
                                  <?php endif; ?>
                              </div>
                    </section>

<!-- // content module -->
<!-- // content module -->

<!-- content module two -->
<!-- content module two -->



<?php
  elseif( get_row_layout() == 'text_body' ):
?>
<section class="text-module">
  <div class="container">

  <?php the_sub_field('body_text'); ?>

</div>
</section>

<?php ?>





<!-- content module two -->
<!-- content module two -->



<!-- content module three -->
<!-- content module three -->







<?php
  elseif( get_row_layout() == 'all_tlds_list' ):

?>
<section class="dark-bg-text-module">



<div class="container">
<div class="row text-center">
<h3 class="high-top-margin">All TLDs</h3>
</div>
<!-- repeater -->
<!-- repeater -->

     <?php if( have_rows('industries') ): ?>

                                  <?php while ( have_rows('industries') ) : the_row(); ?>


<div class="all-tlds-list">

                    <h4>
                   <?php the_sub_field('industry_name'); ?>
                  </h4>
                                    <!-- subdomains repeater -->
                                          <?php if( have_rows('industry_domains') ): ?>
                                          <ul>
                                              <?php while ( have_rows('industry_domains') ) : the_row(); ?>
                                                  <li>
                                                     <?php the_sub_field('tl_domain'); ?>
                                                  </li>
                                               <?php  endwhile; ?>
                                           </ul>
                                           <?php endif; ?>
                                    <!-- subdomains repeater -->

</div>


                                  <?php  endwhile; ?>



                                  <?php endif; ?>

<!-- repeater -->
<!-- repeater -->

</div></section>




<!-- content module three -->
<!-- content module three -->


<!-- content module four -->
<!-- content module four -->

<?php elseif( get_row_layout() == 'tld_feature_info_carousel' ): ?>

<section class="feature-info-carousel" style="background-image:url(<?php the_sub_field('background_image'); ?>)">





<!-- repeater -->
<!-- repeater -->

     <?php if( have_rows('slide') ): ?>
     <div class="owl-carousel owl-theme">
                                  <?php while ( have_rows('slide') ) : the_row(); ?>
                                    <div class="item bkgd-white-transparent">
                                        <div class="container text-center">
                    <h2>
<?php if(get_sub_field('slide_text_line_2')){ ?>

     <?php the_sub_field('slide_text'); ?><br><br>
     <?php the_sub_field('slide_text_line_2'); ?>

  <?php }else{?>

     <?php the_sub_field('slide_text'); ?><br><br>

<?php }?>



                  </h2>



                  <p class="fancyButton">
                            <a href="<?php the_sub_field('slide_link'); ?>"><?php the_sub_field('slide_cta'); ?></a>
                  </p>

                                      </div>

                                  </div>
                                  <?php  endwhile; ?>
                </div>
                                  <?php endif; ?>
<!-- repeater -->
<!-- repeater -->

</section>

<!-- content module four -->
<!-- content module four -->



<!--customers module  -->
<!--customers module  -->
<?php elseif( get_row_layout() == 'customer_list' ): ?>
    <section class="">
      <div class="container">
          <!-- title and content -->
            <?php the_sub_field('customer_list_intro_text'); ?>
          <!-- title and content -->

          <!-- repeater -->
          <!-- repeater -->
            <div class="table-responsive accredited-registrar-table">

             <?php if( have_rows('customers_repeater') ): ?>

                <div class="row">
                  <?php while ( have_rows('customers_repeater') ) : the_row(); ?>

                     <div class="col-sm-3">
                        <a href="<?php the_sub_field('customer_link'); ?>" target="_blank"><?php the_sub_field('customer_name'); ?></a>
                    </div>
                  <?php  endwhile; ?>
                  </div>
                <?php endif; ?>
              </div>

            <!-- repeater -->
              <!-- repeater -->

<br><br>
            <?php the_sub_field('customer_list_bottom_text'); ?>

          </div>
      </section>
<!--customers module  -->
<!-- customers module -->


<!-- dark background text module -->
<!-- dark background text module -->
<?php elseif( get_row_layout() == 'dark_background_text_callout_module' ): ?>

   <section class="dark-bg-text-module">
      <div class="container">


<!-- body text -->
        <?php the_sub_field('text_body'); ?>
<!-- body text -->



      </div>
    </section>


<!-- end dark background text module -->
<!-- end dark background text module -->



<!-- employee benefits module -->
<!-- employee benefits module -->

<?php elseif( get_row_layout() == 'employee_benefits_module' ): ?>

   <section class="bkgd-light">
      <div class="container">

        <?php if( have_rows('benefits_repeater') ): ?>
      <div class="">
                      <?php while ( have_rows('benefits_repeater') ) : the_row(); ?>
                    <div class="col-sm-6 benefit" style="background-image: url(<?php the_sub_field('benefit_icon'); ?>)">
                        <?php the_sub_field('benefit_text'); ?>
                    </div>
                  <?php  endwhile; ?>
    </div>
                <?php endif; ?>

    </div>
    </section>

<!-- employee benefits module -->
<!-- employee benefits module -->



<!-- Featured TLDs - images -->
<!-- Featured TLDs - images -->



<?php elseif( get_row_layout() == 'featured_tlds' ): ?>

   <section class="">
      <div class="container text-center">

<h3 class="featured-tlds"><?php the_sub_field('header'); ?></h3>
<div class="featured-tlds">
        <?php if( have_rows('featured_tlds_repeater') ): ?>
          <?php while ( have_rows('featured_tlds_repeater') ) : the_row(); ?>
                <a href="<?php echo get_site_url() ?>/<?php the_sub_field('link'); ?>" alt="<?php the_sub_field('name'); ?>">
                    <?php if( get_sub_field('image') ): ?>
                      <img class="solutions" src="<?php the_sub_field('image'); ?>" />
                    <?php endif; ?>
                  </a>
                  <?php  endwhile; ?>
                <?php endif; ?>
</div>
    </div>
    </section>


<!-- Featured TLDs - images -->
<!-- Featured TLDs - images -->




<!-- accordion module -->
<!-- accordion module -->


<?php elseif( get_row_layout() == 'accordion_module' ): ?>

   <section class="">

<div class="container text-center">
  <?php if( get_sub_field('accordion_title') ){ ?>
<h2 class="mb-40"><?php the_sub_field('accordion_title'); ?></h2>
<?php } ?>

</div>

      <div class="container">



        <?php if( have_rows('item') ): ?>

         <div class="accordion">

          <?php while ( have_rows('item') ) : the_row(); ?>

       <!-- repeat this -->


            <h3><i class="fa fa-plus"></i><span><?php the_sub_field('item_title'); ?></span></h3>
            <div>
                <?php the_sub_field('item_text'); ?>
            </div>

          <!-- repeat this -->
                  <?php  endwhile; ?>
              </div>
                <?php endif; ?>
</div>
</section>
<!-- accordion module -->
<!-- accordion module -->


<!-- staff module -->
<!-- staff module -->

<?php elseif( get_row_layout() == 'staff_module' ): ?>




<section class="">
  <div class="container staff-title">
  <h2>Meet Our People</h2>
  </div>
<div class="container staff-groupings">

        <?php if( have_rows('staff_members') ): ?>
          <?php while ( have_rows('staff_members') ) : the_row(); ?>
<!-- repeat this -->
    <!-- <div class="staff-member" style="background-image: url('<?php the_sub_field('image'); ?>');"> -->
    <div class="staff-member">


<img src="<?php the_sub_field('image'); ?>" alt="">
<div class="info">


                        <h1 class="white staff-member-name gray-border">
                        <?php the_sub_field('name'); ?>                       </h1>

                         <span class="top-text white"><?php the_sub_field('title'); ?></span>


                        <span class="employee-description"><p>
                      <?php the_sub_field('description'); ?></p>
                        </span>

</div>


                      </div>









<!-- repeat this -->
                  <?php  endwhile; ?>
               <?php endif; ?>
      </div>
</section>


<!-- staff module -->
<!-- staff module -->





<!-- investors module -->
<!-- investors module -->


<?php elseif( get_row_layout() == 'investors_module' ): ?>


   <section class="">
      <div class="container investors">
<h2>
 <?php the_sub_field('title'); ?>
</h2>
</div>
      <div class="container">
        <?php if( have_rows('investor_list') ): ?>

         <div class="row">
<div class="container">
  <div class="container">
          <?php while ( have_rows('investor_list') ) : the_row(); ?>
              <div class="col-sm-6 text-center investor">
       <!-- repeat this -->

<a href="<?php the_sub_field('link'); ?>" target="_blank">
<img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('name'); ?>">
</a>

              </div>
          <!-- repeat this -->
                  <?php  endwhile; ?>
              </div></div></div>
                <?php endif; ?>
              </div>

</section>

<!-- investors module -->
<!-- investors module -->


<!-- policies module -->
<!-- policies module -->

<?php elseif( get_row_layout() == 'policies_module' ): ?>


<section class="policies">
  <div class="container">

   <?php the_sub_field('intro_text'); ?>
   <br>
  <!-- repeat here -->
          <?php if( have_rows('policy_list') ): ?>

<ul>
    <?php while ( have_rows('policy_list') ) : the_row(); ?>
<li class="policies-list">
<a href="<?php the_sub_field('link'); ?>" target="blank">
  <?php the_sub_field('policy_title'); ?>
</a>
</li>



            <!-- repeat this -->
                    <?php  endwhile; ?>

</ul>

                  <?php endif; ?>
  <!-- repeat here -->

  </div>
</section>

<!-- policies module -->
<!-- policies module -->










<!-- contacts module -->
<!-- contacts module -->

<?php elseif( get_row_layout() == 'contact_module' ): ?>
<section class="contacts">
  <div class="container">
<h2>
   <?php the_sub_field('title'); ?>
 </h2>
 <br>

  <!-- repeat here -->
          <?php if( have_rows('contact_list') ): ?>
          <div class="row">
    <?php while ( have_rows('contact_list') ) : the_row(); ?>

<div class="col-sm-6">

    <?php the_sub_field('contact_type'); ?>
    <a href="mailto:<?php the_sub_field('contact_email'); ?>">
      <?php the_sub_field('contact_email'); ?>
    </a>

</div>
            <!-- repeat this -->
                    <?php  endwhile; ?>
                  </div>
                  <?php endif; ?>
  <!-- repeat here -->

  </div>
</section>





<!-- contacts module -->
<!-- contacts module -->






<!-- locations module -->
<!-- locations module -->

<?php elseif( get_row_layout() == 'locations_module' ): ?>
<section class="">
  <div class="container investors">
<h2>
   <?php the_sub_field('title'); ?>
 </h2>
 <br>

  <!-- repeat here -->
          <?php if( have_rows('location_list') ): ?>
          <div class="row">
    <?php while ( have_rows('location_list') ) : the_row(); ?>

<div class="col-sm-4">

      <?php the_sub_field('location_text'); ?>


</div>
            <!-- repeat this -->
                    <?php  endwhile; ?>
                  </div>
                  <?php endif; ?>
  <!-- repeat here -->

  </div>
</section>


<!-- locations module -->
<!-- locations module -->



<!-- search bar module -->
<!-- search bar module -->

<?php elseif( get_row_layout() == 'search_domains' ): ?>
<section class="text-module">


 <div class="container search-domains">
   <?php the_sub_field('intro_text'); ?>
 </div>
  <div class="container search-domains">

<br>
<iframe src="https://great.domains/searchbar/donutsdomains/" width="800" height="430" frameborder="0" scrolling="no"></iframe>


</div>
</section>


<!-- search bar module -->
<!-- search bar module -->
















<!-- ends the conditional for the different layouts -->
<?php endif; ?>
<!-- ends the conditional for the different layouts -->

<?php
    endwhile;
endif; ?>

<div class="row" style="display:none;">
<!-- <div class="row rellax" data-rellax-speed="4"> -->
    <div class="container" style="display:none;">
      <div class="row">
        <div class="col-sm-12">
            <?php get_template_part( 'loop', 'page' ); ?>
          </div><!-- /.blog-main -->
      </div><!-- /.row -->
	<?php get_footer(); ?>