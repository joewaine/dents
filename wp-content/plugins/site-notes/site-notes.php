<?php
/*
Plugin Name: Site Notes
Plugin URI:  https://wordpress.org/plugins/site-notes/
Description: A plugin that adds a note box to  your posts and pages which can be viewed in the admin bar
Version:     1.6.0
Author:      KC Computing
Author URI:  https://profiles.wordpress.org/ktc_88
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: site-notes
*/



/**
 *  On activation create table to save notes
 */
function sn_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . "notes"; 
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      note text NOT NULL,
      note_date text NOT NULL,
      UNIQUE KEY id (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'sn_install' );



/**
 * Enqueue scripts and styles to front end.
 */
function sn_front_end_scripts() {
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
    wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css' );
    wp_enqueue_script('jQuery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js', array( 'jquery' ) );
    wp_enqueue_style('sn_styles', plugin_dir_url( __FILE__ ) . 'css/style.css'); 
    wp_enqueue_script('sn_scripts', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), true );
}
add_action( 'wp_enqueue_scripts', 'sn_front_end_scripts' );



/*--------------------------------------------------------------
    Add note meta box to post/page/cpt
--------------------------------------------------------------*/
function sn_note_init() {
    $post_types = array ( 'post', 'page'); // Create an array to display metabox in both posts and pages
    foreach( $post_types as $post_type )
    {
        add_meta_box(
            "note_textarea",  // id 
            "Page Notes",     // title
            "sn_page_notes", // call back
            $post_type, 
            "side",           // context 
            "high"            // priority
        );
    }    
}
add_action("admin_init", "sn_note_init");



function sn_page_notes() {
    global $post;
    $custom = get_post_custom($post->ID);
    $page_options = $custom["note"][0];
    $note_value = get_post_meta($post->ID, 'note', true);
    ?>
    <textarea name="note" style="width: 100%; <?php if($note_value){echo 'background-color: #FFEE00;';} ?>"><?php echo $note_value; ?></textarea>
    <?php
}




function sn_save_note(){
    global $post;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post->ID;
    }
    update_post_meta($post->ID, "note", $_POST["note"]);
}
add_action('save_post', 'sn_save_note'); // Save Meta Details



/*--------------------------------------------------------------
    Add note meta box to admin bar on front end
--------------------------------------------------------------*/
function sn_form_in_admin_bar() {
    $admin_bar_notes = get_option('admin_bar_notes');
    if (!is_admin() && (is_page() || is_single()) && $admin_bar_notes != "off" ) {
        global $wp_admin_bar, $post;
        $note_value     = get_post_meta($post->ID, 'note', true);
        $lock_notes_on  = get_post_meta($post->ID, 'lock_notes_on', true);
        $notes_style    = get_post_meta($post->ID, 'notes-position', true);
        $textarea_style = get_post_meta($post->ID, 'textarea-size', true);
        if($note_value) {
            $note_alert = ' <i class="fa fa-info-circle"></i>';
            $have_note  = ' class="have-note"';
        } else {
            $note_alert = '';
            $have_note  = ' class="no-note"';
        }
        $lock_notes_on ? $style = 'display:block; ' : $style = '';
        $wp_admin_bar->add_menu( array(
            'id'        => 'notes',
            'parent'    => 'top-secondary',
            'title'     => '<button id="toggle-note"'.$have_note.'>Notes'.$note_alert.'</button>
                        <div class="note-box" style="'.$style.$notes_style.'">
                            <form method="post" action="">
                                <textarea name="note2" id="note2" style="'.$textarea_style.'">'.$note_value.'</textarea><br />
                                <input type="submit" name="submit2" id="submit2" value="Save Note" /> 
                                <label><input type="checkbox" id="lock_notes_on" name="lock_notes_on"'.checked( $lock_notes_on, 'lock', false ).' value="lock"> Lock Open</label>
                                <br /><span id="sn_status" style="display:none;"></span>
                                <i class="refresh-busy fa fa-spinner fa-pulse" style="display:none;"></i>
                                <input type="hidden" id="sn_ajax_loc" value="'.plugin_dir_url( __FILE__ ).'" />
                                <input type="hidden" id="sn_post_id" value="'.$post->ID.'" />
                            </form>
                        </div>'
        ) );
    }
}
add_action( 'admin_bar_menu', 'sn_form_in_admin_bar' );





/*--------------------------------------------------------------
    WP NOTES DASHBOARD WIDGET
--------------------------------------------------------------*/
function sn_display_notes_dashboard() {
    wp_add_dashboard_widget(
        "sn_notes",             // Widget slug.
        "Dashboard Notes",      // Title.
        "sn_display_notes",      // Display function.
        "sn_display_notes_form" // Add "configure" option to widget
    );
}
add_action("wp_dashboard_setup", "sn_display_notes_dashboard");

function sn_display_notes() { 
    $sn_timezone = get_option('timezone_string');
    date_default_timezone_set($sn_timezone); ?>

    <style>
    .note_msg {
        display: block;
        width: 100%;
        position: absolute;
        top: 30%;
        left: 0;
        padding: 20px 0;
        background-color: rgba(16, 255, 0, 0.6);
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        color: #FFFFFF;
    }
    </style>
    <script>
    jQuery(document).ready(function($) {
        $("textarea").each(function () {
            this.style.height = (this.scrollHeight+10)+'px';
        });
        $('#add-note').click(function() {
            $('#notes_table tr:last-child').after( '<tr><td><input type="text" name="sn_notes_date" value="'+ "<?php echo date("F j, Y, g:i a"); ?>"  +'" readonly style="width: 210px;"><br />\
                <textarea name="sn_notes_value" style="width: 100%;" rows="4"></textarea></td></tr>'
            );
        });
        $('.fa-times').click(function() {
            $(this).closest('tr').remove();
        });
    });
    </script>

    <?php echo '<div style="border: 1px solid #ccc; padding: 5px;">'.get_option('display_dash_notes').'</div>';  // Pull notes from the widget form ?>

    <form action="" name="dash_notes" id="dash_notes" method="post">
        <table class="sn-dashboard-notes-table" id="notes_table" style="width: 100%;">
            <tr><td></td></tr>
            <?php global $wpdb;
            $table_name = $wpdb->prefix . 'notes';
            $get_notes  = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($get_notes as $note) {
                $note_id    = $note->id;
                $note_value = $note->note;
                $note_date  = $note->note_date;
                echo '<tr>
                        <td>
                            <a href="?sn_delete='.$note_id.'"><i class="fa fa-times"></i></a> '. $note_date .'<br />
                            <textarea style="width: 100%;" name="sn_notes_value">'.  $note_value .'</textarea>
                        </td>
                     </tr>';
            }
            ?>
        </table>
        <br />
        <div class="button-secondary" id="add-note" name="add-note"><i class="fa fa-plus-square"></i> ADD NOTE</div>
        <input type="submit" class="button-primary" name="save_note" value="Save Note" />
    </form>
    <?php
    if(isset($_POST['save_note'])) {
        echo '<div class="note_msg">Saving...</div>';
        $wpdb->insert( 
            $table_name, 
            array( 
                'note'      => $_POST['sn_notes_value'],
                'note_date' => $_POST['sn_notes_date']
            ) 
        ); // End of DB insert
        echo '<script>window.location.href = "'.home_url().'/wp-admin";</script>';
    } // END OF IF submit clicked

    if(isset($_GET['sn_delete'])) {
        echo '<div class="note_msg">Deleting...</div>';
        $deleteID = $_GET['sn_delete'];
        $wpdb->delete( $table_name, array( 'id' => $deleteID ) );
        echo '<script>window.location.href = "'.home_url().'/wp-admin";</script>';
    }
} // End of dashboard notes widget



// This callback is fired during display of form inside widget and also during form submission.
function sn_display_notes_form() {
    //if form is submitted 
    if(isset($_POST["dash_notes"])) {
        update_option("display_dash_notes", $_POST["dash_notes"]);
    }
    //form tag and submit button is automatically displayed by the dashboard API 
    $note = get_option('display_dash_notes'); 
    wp_editor( $note, 'dash_notes' ); 
}



/**
 * Register Settings
 */
function sn_register_notes_settings() {
    register_setting('sn_dashboard_options','admin_bar_notes');
}
add_action('admin_init', 'sn_register_notes_settings');



/*--------------------------------------------------------------
    WP NOTES DASHBOARD WIDGET SAVED PAGE/POST NOTES
--------------------------------------------------------------*/
function sn_display_page_notes_dashboard() {
    wp_add_dashboard_widget(
        "sn_notes2",                // Widget slug.
        "Saved Page/Post Notes",    // Title.
        "sn_display_notes2"         // Display function.
    );
}
add_action("wp_dashboard_setup", "sn_display_page_notes_dashboard");

function sn_display_notes2() {   
    $get_page_notes = new WP_Query(array(
        'post_type'     => array( 'post', 'page' ),
        'post_status'   => 'publish',
        'meta_key'      => 'note', 
        'meta_value'    => ' ',
        'meta_compare'  => '!=',
        //'orderby'     => '',
        'order'         => 'ASC',  //DESC
    ));

    // The Loop
    echo '<ul>';
    while ( $get_page_notes->have_posts() ) : $get_page_notes->the_post();
        echo '<li>'; ?>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank"><?php the_title(); ?></a><br />
        <?php
        echo '"'.get_post_meta(get_the_ID(), 'note', true).'"'; 
        echo '</li>';
    endwhile;
    echo '</ul>';
    settings_fields('mpn_settings_page_tab1');
    ?>
    <hr />
    <table>
        <tr>
            <td><label for="admin_bar_notes">Hide Notes from Admin Bar:</label></td>
            <td class="grey-box">
                <?php $admin_bar_notes = get_option('admin_bar_notes');
                $admin_bar_notes_checked = ($admin_bar_notes == "off") ? 'checked="checked"' : ''; ?>
                <input type="checkbox" id="admin_bar_notes" name="admin_bar_notes" value="off" <?php echo $admin_bar_notes_checked; ?>" />
                <i class="refresh-busy fa fa-spinner fa-pulse" style="display:none;"></i>
                <span id="sn_status" style="display:none;"></span>
            </td>
        </tr>
    </table>
    <script>
    // Use Ajax to save the toggle notes in admin bar checkbox
    jQuery(document).ready(function($) {
        $('#admin_bar_notes').change(function(){
            //$('.refresh-busy').fadeIn();
            if(this.checked) {
                var message = "Notes in admin bar off";
                var ID = "off";
            } else {
                var message = "Notes in admin bar on";
                var ID = "on";
            }
            $.ajax({
                type: "POST",
                url: "<?php echo plugin_dir_url( __FILE__ ); ?>ajax-calls.php",
                data: { function_call: "toggle_notes_in_admin_bar", param2: ID}
            }).done(function( msg ) {
                //alert( "Data Saved: " + msg );
                $("#sn_status").html( message ).fadeIn(function() {
                    //$('.refresh-busy').fadeOut();
                    $("#sn_status").delay(2500).fadeOut();
                });
            });
        });
    });
    </script>
    <?php
}