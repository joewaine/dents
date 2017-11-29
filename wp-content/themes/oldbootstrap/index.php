<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */

	get_header(); ?>


<div class="row">


<section class="bkgd-light">
      <div class="container">
        <div class="element "><div id="c1022" class="csc-default"><ul class="benefits list-unstyled">
  <li class="piggy-bank">Competitive compensation packages</li>
  <li class="vault">401(k) matching</li>
  <li class="money-bag">Competitive bonus and equity program</li>
 <!-- <li class="dog">Bring your dog to work</li> -->
  <li class="healthcare">Medical, dental, and vision insurance</li>
 <!-- <li class="food">Friday free lunches and happy hours</li>
  <li class="heart">Life and disability insurance</li>
  <li class="credit-card">Credits to purchase domain names</li>-->
  <li class="calendar">
    Vacation, sick and paid holidays<br>

  </li>
 <!-- <li class="school">Professional education reimbursement</li>  -->
</ul></div></div>
      </div>
    </section>

</div>

      <div class="row">



        <div class="col-sm-12">

          <?php get_template_part( 'loop', 'index' ); ?>

        </div><!-- /.blog-main -->

        <?php get_sidebar(); ?>

      </div><!-- /.row -->

	<?php get_footer(); ?>