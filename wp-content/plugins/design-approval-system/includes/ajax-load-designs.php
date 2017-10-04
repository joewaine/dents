<?php

/* @ChrisFlanny file, let's get this wp ajax goin' on" */

add_action( 'admin_footer', 'my_action_javascript' ); // Write our JS below here
add_action( 'wp_footer', 'my_action_javascript' );

function my_action_javascript() { 
	$limit_designs = -1;
	$show_more = 0;
    if ( intval( get_option( 'das-gq-theme-limit-versions-displayed' ) ) > 0 ) {
		$limit_designs = intval(get_option('das-gq-theme-limit-versions-displayed'));
	}
    if ( intval( get_option( 'das-gq-theme-limit-versions-displayed-load-more' ) ) > 0 ) {
        $show_more = intval(get_option('das-gq-theme-limit-versions-displayed-load-more'));
    }
    ?>
    <script type="text/javascript" >
	   var show_more_offset = <?php echo $limit_designs; ?>;
       var show_more_offset_additional = <?php echo $show_more; ?>;
       var show_all = new Array();
       var show_offset = new Array();
       function DASShowMore( tax, pn, limit, all, btn, btn_finish ) {
           (jQuery)(".DASLoadMore_btn_" + pn).prop("disabled", true);
           if (btn_finish == 'All Loaded') {
               (jQuery)("#DASLoadMore_" + pn).css('display', 'none');
           }
           var current_offset =0;;

           if (show_offset[pn] !== undefined) {
               current_offset = show_offset[pn];
           } else {
               current_offset = show_more_offset
           }

           console.log(current_offset);

           if (parseInt((jQuery)("#DASTotalAvailable_" + pn).val()) <= (current_offset+show_more_offset_additional)) {
               (jQuery)("#DASLoadMore_" + pn).css('display', 'none');
               (jQuery)("#DASLoadAll_" + pn).text('All Loaded');
           }
            var data = {
                'action': 'das_load_more',
                'tax': tax,
                'pn': pn,
                'limit': current_offset,
                'all': all
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            if( show_all[pn] == undefined ) {
                btn.innerText = 'Loading ...';
                jQuery.post(ajaxurl, data, function(response) {
                    <?php if( is_admin() ) { ?>
                    (jQuery)(".das-project-list-" + pn).append(response);
                    <?php } else { ?>
                    (jQuery)(response).insertBefore( (jQuery)( ".das-project-list-" + pn + " li" ).last() );
                    <?php } ?>
                    btn.innerText = btn_finish;

                    if( all ) {
                        show_all[pn] = true;
                    } else {
                        if( show_offset[pn] !== undefined ) {
                            show_offset[pn] = parseInt( show_offset[pn] ) + parseInt( show_more_offset_additional );
                        } else {
                            show_offset[pn] = parseInt( show_more_offset ) + parseInt( show_more_offset_additional );
                        }
                        if (parseInt((jQuery)("#DASTotalAvailable_" + pn).val()) > (current_offset+show_more_offset_additional)) {
                            (jQuery)(".DASLoadMore_btn_" + pn).prop("disabled", false);
                        }
                    }
                });
            }
        }
    </script> <?php
}

add_action( 'wp_ajax_das_load_more', 'das_load_more_callback' );

function das_load_more_callback()
{
	$limit_designs = 500;
	if ( intval( get_option( 'das-gq-theme-limit-versions-displayed-load-more' ) ) > 0 && $_REQUEST['all'] == "false" ) {
		$limit_designs = intval( esc_html( get_option( 'das-gq-theme-limit-versions-displayed-load-more' ) ) );
	}
    //loop for displaying posts for Project
    $output = '';
    $post_type = 'designapprovalsystem';
    //Set a design versions display limit for the /project-manager/ display page ** Flannagan **
    $order_designs = '';
    //check if option has been set, if not default to DESC;
    if ( !get_option( 'das-gq-theme-order-versions-displayed' ) ) {
        $order_designs = 'DESC';
    } else {
        $order_designs = get_option( 'das-gq-theme-order-versions-displayed' );
    }
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $limit_designs,
        'post_status' => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby' => 'date',
		'offset' => esc_html( $_REQUEST['limit'] ),
        'order' => $order_designs,
        'tax_query' => array(
            array(
                'taxonomy' => esc_html( $_REQUEST['tax'] ),
                'field' => 'ID',
                'terms' => array( esc_html( $_REQUEST['pn'] ) )
            ),
        ),
    );
    $my_query = new \WP_Query( $args );

    if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post();
        global $post;
        //Design Link creation
        $output .= '<li>';
        $dirDASplugin = plugin_dir_path( __FILE__ );
        include $dirDASplugin . '../includes/das-project-boards.php';
        $output .= '</li>';
        $none_to_display = false;
    endwhile; endif;

    echo $output;
	
	wp_die();
}