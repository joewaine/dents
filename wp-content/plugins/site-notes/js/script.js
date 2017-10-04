// Front end note meta box in admin bar
jQuery(document).ready(function($) { 

    $('#toggle-note').click(function(){
        $(".note-box").slideToggle('slow', 'linear');
        sn_resize()
    });

    // Make note box draggable and textarea resizable
    $( ".note-box" ).draggable();    
    $( ".note-box textarea" ).resizable(); 

    // Save note box page note with ajax
    $("#submit2").click(function(e) {
        $('.refresh-busy').fadeIn();
        e.preventDefault();
        var note = $('#note2').val();
        var ajax_loc = $('#sn_ajax_loc').val();
        var ID = $('#sn_post_id').val();
        $.ajax({
            type: "POST",
            url: ajax_loc+"ajax-calls.php",
            data: { function_call: "note", param2: ID, param4: note }
        }).done(function( msg ) {
            //alert( "Data Saved: " + msg );
            $("#sn_status").html( "Note saved!" ).fadeIn(function() {
                $('.refresh-busy').fadeOut();
                $("#sn_status").delay(2500).fadeOut();
            });
        });
    });

    // Make note lock open/close save with ajax call
    $('#lock_notes_on').change(function(){
        if(this.checked) { 
            var message = "Lock open on!";
            var lock = "lock";
        } else {
            var message = "Lock open off!";
            var lock = "";
        }
        var ajax_loc = $('#sn_ajax_loc').val();
        var ID = $('#sn_post_id').val();
        $.ajax({
            type: "POST",
            url: ajax_loc+"ajax-calls.php",
            data: { function_call: "lock", param2: ID, param3: lock }
        }).done(function( msg ) {
            //alert( "Data Saved: " + msg );
            $("#sn_status").html( message ).fadeIn(function() {
                $('.refresh-busy').fadeOut();
                $("#sn_status").delay(2500).fadeOut();
            });
        });
    });   
 
    // Save note box position with ajax
    $(".note-box").mouseup(function() {
        if($(".note-box").hasClass("ui-draggable-dragging")) {
            var top_style = $('.note-box').css("top");
            var left_style = $('.note-box').css("left");
            var style = ' top:'+top_style+'; left:'+left_style+';';
            var ajax_loc = $('#sn_ajax_loc').val();
            var ID = $('#sn_post_id').val();
            $.ajax({
                type: "POST",
                url: ajax_loc+"ajax-calls.php",
                data: { function_call: "move", param: style, param2: ID }
            }).done(function( msg ) {
                //alert( "Data Saved: " + msg );
                $("#sn_status").html( "Box position saved!" ).fadeIn(function() {
                    $("#sn_status").delay(1500).fadeOut();
                });
            });
        };
    });

    // Save note box textarea size with ajax
    $(".ui-resizable-handle").mouseup(function() {
        var height_style = $('.note-box textarea').css("height");
        var width_style = $('.note-box textarea').css("width");
        var style = ' height:'+height_style+'; width:'+width_style+';';
        var ajax_loc = $('#sn_ajax_loc').val();
        var ID = $('#sn_post_id').val();
        $.ajax({
            type: "POST",
            url: ajax_loc+"ajax-calls.php",
            data: { function_call: "resize", param: style, param2: ID }
        }).done(function( msg ) {
            //alert( "Data Saved: " + msg );
            $("#sn_status").html( "Box dimensions saved!" ).fadeIn(function() {
                $("#sn_status").delay(1500).fadeOut();
            });
        });
    });

    // Automatically increase the height of the textarea as you type 
    // http://stackoverflow.com/questions/7745741/auto-expanding-textarea#answer-7745840
    var textarea = document.getElementById("note2");  
    if (textarea !== null) {
        sn_resize()
        textarea.oninput = function() {
            sn_resize();
        };
    }
    function sn_resize() {
        textarea.style.height = Math.min(textarea.scrollHeight) + "px";
        $(".ui-wrapper").css( "height", textarea.scrollHeight + 12 );
    }

});