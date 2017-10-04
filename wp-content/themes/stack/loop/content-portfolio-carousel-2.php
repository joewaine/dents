<li class="<?php echo esc_attr(get_option('stack_portfolio_carousel_columns', 'col-sm-6')); ?>">
    <div class="project-thumb hover-element border--round hover--active">
        <a href="<?php the_permalink(); ?>">
        
            <div class="hover-element__initial">
                <div class="background-image-holder">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            </div>
            
            <div class="hover-element__reveal" data-scrim-top="5">
                <div class="project-thumb__title">
                    <?php the_title('<h4>', '</h4><span>'. ebor_the_terms('portfolio_category', ', ', 'name') .'</span>'); ?>
                </div>
            </div>
            
        </a>
    </div>
</li>