<!-- footerlinks -->



        <?php  if( have_rows('menu_items', 'option') ): ?>
          <div class="row">
          <?php

          // loop through rows (parent repeater)
          while( have_rows('menu_items', 'option') ): the_row(); ?>
        <div class="col-md-2 col-sm-3 col-xs-6">
              <h4>
<a href="">
                <?php the_sub_field('menu_section_name'); ?></a></h4>
              <?php

              // check for rows (sub repeater)
              if( have_rows('sub_menu_items') ): ?>

                <ul class="nav-directory hidden-xs">
                <?php

                // loop through rows (sub repeater)
                while( have_rows('sub_menu_items') ): the_row();

                  // display each item as a list - with a class of completed ( if completed )
                  ?>
                  <li>
                    <a href="<?php the_sub_field('link'); ?>"><?php the_sub_field('name'); ?></a>


<?php the_sub_field('description'); ?>

                            </li>


                <?php endwhile; ?>
                </ul>
              </div>
              <?php endif;  ?>


          <?php endwhile;  ?>
          </div>
        <?php endif;  ?>





<!-- footerlinks -->