<?php
/**
 * Template for displaying the footer
 *
 * Contains the closing of the id=main div and all content
 * after. Calls sidebar-footer.php for bottom widgets.
 *
 * @package Bootstrap Canvas WP
 * @since Bootstrap Canvas WP 1.0
 */
?>
    </div><!-- /.container -->
</div>
<!-- <end row> -->



<!-- end of parralax boundary -->
</div>
<!-- end of parralax boundary -->


<footer id="siteFooter">

<div class="container">



<!-- footerlinks -->



        <?php  if( have_rows('footer_links', 'option') ): ?>
          <div class="row">
          <?php

          // loop through rows (parent repeater)
          while( have_rows('footer_links', 'option') ): the_row(); ?>
        <div class="col-md-2 col-sm-3 col-xs-6">
              <h4>
<a href="">
                <?php the_sub_field('link_group_title'); ?></a></h4>
              <?php

              // check for rows (sub repeater)
              if( have_rows('footer_link_links') ): ?>

                <ul class="nav-directory hidden-xs">
                <?php

                // loop through rows (sub repeater)
                while( have_rows('footer_link_links') ): the_row();

                  // display each item as a list - with a class of completed ( if completed )
                  ?>
                  <li>
                    <a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('link_title'); ?></a>
                            </li>


                <?php endwhile; ?>
                </ul>
              </div>
              <?php endif;  ?>


          <?php endwhile;  ?>
          </div>
        <?php endif;  ?>





<!-- footerlinks -->







<!-- locations -->

<?php if( have_rows('locations', 'option') ): ?>
<div class="row">
    <div class="col-md-12">
      <div class="element">
        <h4 class="locations">Locations</h4>
        <div class="row">
<?php while ( have_rows('locations', 'option') ) : the_row(); ?>
<div class="col-md-2 col-sm-6 col-xs-6">
    <p>
<?php
        // display a sub field value
        the_sub_field('address');
?>
</p>
</div>
<?php
    endwhile;
?>


<div class="col-md-2 col-sm-2 col-xs-3">
    <p><img src="<?php echo get_site_url() . '/wp-content/uploads/2017/10/donuts-color-logo.png'; ?>"></p>
  </div>


</div></div></div></div>
<?php
else :
endif;
?>

<!-- locations -->

<!-- policy links -->

<?php if( get_field('policy_links', 'option') ): ?>
<div class="row">
<div class="col-xs-12 policy-links">
<br>
<?php the_field('policy_links', 'option'); ?>
<br>
</div>
</div>
<?php endif; ?>

<!-- policy links -->



<?php if( get_field('footer_text', 'option') ): ?>

<p class="footer-disclosure">
<?php the_field('footer_text', 'option'); ?>
</p>

<?php endif; ?>

    </div>
</footer>
    <?php
	  /*
	   * Always have wp_footer() just before the closing </body>
	   * tag of your theme, or you will break many plugins, which
	   * generally use this hook to reference JavaScript files.
	   */
	  wp_footer();
	?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="<?php echo get_site_url() . '/wp-content/themes/bootstrap/js/rellax.min.js'?>"></script>

<script src="<?php echo get_site_url() . '/wp-content/themes/bootstrap/js/owl.carousel.min.js'?>"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<script>

  $( function() {
    $( ".accordion" ).accordion({

 active: false,
    collapsible: true

    });
  } );


    $( function() {
    $( ".mobile-accordion" ).accordion({

 active: false,
    collapsible: true,
    header: "li.menu-item"

    });
  } );





</script>

<script>
  // Accepts any class name
  // var rellax = new Rellax('.rellax');
</script>

<script>



//$('.secondary-menu').show();

  $('.nav-menu .menu-item').hover(function(){

      $('.secondary-menu').hide();
      var indexItem = $(this).index();
      $('.secondary-menu:eq('+ indexItem +')').show();

  });





  $('.revert-second-menu').hover(function(){
$('.secondary-menu').fadeOut();


  });


$(window).on('scroll', function() {
    var y_scroll_pos = window.pageYOffset;
    var scroll_pos_test = 150;             // set to whatever you want it to be

    if(y_scroll_pos > scroll_pos_test) {
        //do stuff


$('.main-navigation').addClass('darker-header');

    }else{
      $('.main-navigation').removeClass('darker-header');
    }
});





$(document).ready(function(){
  $('.owl-carousel').owlCarousel({
      loop:true,
      margin:10,
      nav:true,
      dots: false,
      smartSpeed: 500,
      responsive:{
          0:{
              items:1
          },
          600:{
              items:1
          },
          1000:{
              items:1
          }
      }
  });
});


</script>


<!-- staff page script -->
<script>

$(window).resize(function(){

  // $('.member-info-data').remove();
  // $('.triangle').remove();

});


$('.staff-member').click(function(){


$('.member-info-data').remove();




$('.staff-member').removeClass('halfOpacity');

  $(this).addClass('halfOpacity');



var memberWidth = parseInt($('.staff-member').css('width'));
var rowWidth = parseInt($('.staff-groupings').css('width'));
var amountPerRow = parseInt(rowWidth/memberWidth);

// console.log('amount per row: ' + amountPerRow);
  var staffMembers = [];
$('.staff-member').each(function(){
  staffMembers.push($(this).index());
});

  var amountofMembers = 0;

  $('.staff-member').each(function(){
    amountofMembers++;
  });

  var amountOfRows = amountofMembers/amountPerRow;
  var item = $(this).index() + 1;

var rowArrays = [];
var i,j,temparray,chunk = amountPerRow;
for (i=0,j=staffMembers.length; i<j; i+=chunk) {
    temparray = staffMembers.slice(i,i+chunk);
    rowArrays.push(temparray);
}

var result;
for( var i = 0, len = rowArrays.length; i < len; i++ ) {
  for(t=0;t<amountPerRow;t++){
    if( rowArrays[i][t] === $(this).index() ) {
        result = rowArrays[i];
        // console.log('result');
        // console.log(result);
        var appender = result[result.length - 1];



var paragraphcontent = '';

$(this).find('span.employee-description p').each(function(){



var paragraphpiece = '<p class="avenir-light">' + $(this).text() +  '</p>';


paragraphcontent = paragraphcontent + paragraphpiece;


});


          var contentItem = '<div class="container"><div class="row"><div class="col-md-5" style="display:none;"><img class="gray-border usrImage" src="'+ $(this).find('img').attr('src') +'" style="display:none;"></div><div class="col-sm-7"><h2 class="staff-member-modal">'+ $(this).find('.staff-member-name').text() +'</h2><p class="gray-text gray-border">'+ $(this).find('.top-text').text() +'</p>' + paragraphcontent + '</div></div></div>';

        $('.staff-member:eq('+ appender +')').after('<div class="member-info-data" style="display:none;">' + contentItem + '</div>');
        $('.staff-member:eq('+ appender +')').next(".member-info-data").slideDown();






$('.member-info-data').addClass('appear').addClass('giveHeight');
$(".member-info-data .container").addClass('slide-down');

setTimeout(function (){


$('.usrImage').fadeIn(1000);
$('.col-md-5').slideDown(500);
// $('.col-sm-7').slideDown('slow');

}, 100);



   result = null;
        break;
    }
}

}



});


$('body').on('click', '.collapse-bar', function() {
  $(this).parent().remove();

    $('.triangle').remove();
});







</script>
<!-- staff page script -->

<script>


$('.menu-icon').click(function(){


$('.mobile-menu').addClass('expanded-menu');



});

$('.retract-menu').click(function(){


$('.mobile-menu').removeClass('expanded-menu');



});




</script>



  </body>
</html>