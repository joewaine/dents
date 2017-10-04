(function( $ ) {

    /**
     * Preview popup in the listing page
     */
    $(document).on("click", ".inc_opt_preview_optin", function(e){
        e.preventDefault();
        var $this = $(this),
            data = $this.data("data"),
            design = $this.data("design"),
            popup_settings = $this.data("popup"),
            layout = design.form_location.toInt();

        if( _.isEmpty( data ) || _.isEmpty( design ) ) return;


        // close all popups
        _.each( wpmUi.popups(), function(popup, index){
            popup.hide();
        } );


        var tpl = Optin.get_tpl( layout ),
            html = tpl(_.extend({}, data, design, design.borders) );

        var popup = wpmUi.popup( '<div><a href="#" class="inc-opt-close-popup" aria-label="Close" >&times;</a>' + html +'</div>'),
            window_width = $(window).width(),
            window_height = $(window).height(),
            width, height;

        switch (layout){
            case 0:
                width = window_width * 0.5;
                break;
            case 1:
                width = window_width * 0.74;
                break;
            case 2:
            case 3:
                width = window_width * 0.6;
                //height = 360;
                break;
        }

        popup.size(width, height)
            .modal( false, false )
            .animate( popup_settings.animation_in , popup_settings.animation_out)
            .set_class("inc_opt_preview_popup inc_opt_popup inc_optin inc_optin_" + data.id)
            .onshow(function(){

            })
            .show();

        $(document).on("submit", ".wpoi-form-wrap", function(e){
            e.preventDefault();
        });
        //popup.$().data("popup", popup);

    });

    $(document).on("click", '.inc-opt-close-popup', function(e){
        e.preventDefault();
        var $this = $(e.target),
            $popup = $this.closest( '.inc_opt_popup');

        _.each( wpmUi.popups(), function(popup, index){
            popup.hide();
        } );
    });


    // Boxes on design tab
    $(document).on("click", ".can-open .box-title span.open i.dev-icon", function(){
        var $this = $(this);
        var classOpen = "dev-icon-caret_up";
        var classClosed = "dev-icon-caret_down";
        var currentClass = $this.hasClass(classOpen) ? classOpen : classClosed;
        var newClass = currentClass == classOpen ? classClosed : classOpen;
        var $section = $this.closest("section");
        $this.switchClass(currentClass, newClass);
        $section.toggleClass("closed", currentClass == classClosed);
        $section.find(".box-content").toggle(newClass == classClosed);

    });

    var set_testmode_visibiliy = function( active_toggle, speed ) {
        if( typeof speed === 'undefined' ) speed = 400;
        var $this = active_toggle,
            data = $this.data() || {};

        var $test_mode_toggle = $('.wpoi-testmode-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').closest(".test-mode");
        if( $this.is( ":checked" ) ){
            $test_mode_toggle.fadeOut( speed );
        } else {
            $test_mode_toggle.fadeIn( speed );
        }

    };

    $(document).on("change", '.optin-type-active-state', function(e){
        var $this = $(this),
            data = $this.data() || {};

        // Set visibility for test mode toggles when the active toggle changes, as specified in indesign
        set_testmode_visibiliy( $this );

        $('.optin-type-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').not(this).prop("checked", $this.is(":checked") ? true : false);

        data.action = "inc_opt_toggle_optin_type_state";
        data._ajax_nonce = data.nonce;

        $this.prop("disabled", true);
        $.post(ajaxurl, data,function(response){
            $this.prop("disabled", false);
        });
    });

    // Set visibility for test mode toggles at view load, with no animation
    $('.optin-type-active-state').each(function(){
        set_testmode_visibiliy( $(this), 0 );
    });

    $(document).on("change", '.wpoi-testmode-active-state', function(e){
        var $this = $(this),
            data = $this.data() || {};
        data.action = "inc_opt_toggle_type_test_mode";
        data._ajax_nonce = data.nonce;

        $('.wpoi-testmode-active-state[data-id="' + data.id + '"][data-type="' + data.type + '"]').not(this).prop("checked", $this.is(":checked") ? true : false);

        $this.prop("disabled", true);
        $.post(ajaxurl, data,function(response){
            $this.prop("disabled", false);
        });
    });

    $(document).on("click", '.wpoi-listing-wrap header.can-open .toggle, .wpoi-listing-wrap header.can-open .toggle-label', function(e){
        e.stopPropagation();
    });

    $(document).on("change", '.optin-active-state', function(e){
        var $this = $(this),
            data = $this.data() || {},
            $overlay = $this.closest(".wpoi-listing-wrap").find(".wpoi-optin-disable-overlay");
        data.action = "inc_opt_toggle_state";
        data._ajax_nonce = data.nonce;

        $this.prop("disabled", true);
        $overlay.toggleClass("hidden");
        $.post(ajaxurl, data,function(response){
            $this.prop("disabled", false);
        });
    });

    $(".accordion header .optin-delete-optin, .accordion header .edit-optin, .wpoi-optin-details tr .button-edit").hide().css({
        transition : 'none'
    });

    $(document).on({
        mouseenter: function () {
            var $this = $(this);
            $this.find(".optin-delete-optin, .edit-optin").stop().fadeIn("fast");
        },
        mouseleave: function () {
            var $this = $(this);
            $this.find(".toggle-checkbox").removeProp("disabled");
            $this.find(".edit-optin").removeProp("disabled");
            $this.removeClass("disabled");
            $this.find(".optin-delete-optin, .edit-optin, .delete-optin-confirmation").stop().fadeOut("fast");
        }
    }, ".accordion header");

    $(document).on({
        mouseenter: function () {
            var $this = $(this);
            $this.find(".button-edit").stop().fadeIn("fast");
        },
        mouseleave: function () {
            var $this = $(this);
            $this.find(".button-edit").stop().fadeOut("fast");
        }
    }, ".wpoi-optin-details tr");

    $(document).on("click", '.optin-delete-optin', function(e){
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this);
        $this.closest("header").addClass("disabled");
        $this.parent().find(".toggle-checkbox").prop("disabled", true);
        $this.parent().find(".edit-optin").prop("disabled", true);
        $this.fadeOut("fast", function(){
            $this.parent().find(".delete-optin-confirmation").fadeIn("fast");
        });
    });

    $(document).on("click", '.optin-delete-optin-cancel', function(e){
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this);
        $this.closest("header").find(".toggle-checkbox").removeProp("disabled");
        $this.closest("header").find(".edit-optin").removeProp("disabled");
        $this.closest("header").removeClass("disabled");
        $this.parent().fadeOut("fast", function(){
            $this.parent().parent().find(".optin-delete-optin").fadeIn("fast");
        });
    });

    $(document).on("click", '.optin-delete-optin-confirm', function(e){
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this),
            data = $this.data() || {};

        data.action = "inc_opt_delete_optin";
        data._ajax_nonce = data.nonce;
        $this.prop("disabled", true);
        $.post(ajaxurl, data,function(response){
            $this.prop("disabled", false);

            if( response.success )
                $this.closest(".wpoi-listing-wrap").slideUp(300, function(){
                    $(this).remove();
                    if( !$(".wpoi-listing-wrap").length ) // if the deleted optin was the last one
                        location.reload(); // reload the page so that proper page is shown

                });



        });
    });

    $(document).on("click", ".wpoi-tabs-menu a", function(event){
        event.preventDefault();
        var tab = $(this).attr("tab");
        Optin.router.navigate(tab, true);
    });

    //$(document).on("click", ".button-edit", function(event){
    //    event.preventDefault();
    //    var optin_id = $(this).data("id");
    //    window.location.href = "admin.php?page=inc_optin&optin=" + optin_id ;
    //});

    $(document).on("click", ".edit-optin", function(event){
        event.stopPropagation();
        event.preventDefault();
        window.location.href = $(this).attr("href");
    });

    $(document).on("click", ".wpoi-type-edit-button", function(event){
        event.preventDefault();
        var optin_id = $(this).data("id");
        var optin_type = $(this).data("type");
        window.location.href = "admin.php?page=inc_optin&optin=" + optin_id + "#display/" + optin_type;
    });

    /**
     * Make "for" attribute work on tags that don't support "for" by default
     *
     */
    $(document).on("click", '*[for]', function(e){
        var $this = $(this),
            _for = $this.attr( 'for'),
            $for = $("#" + _for);

        if( $this.is("label") || !$for.length ) return;

        $for.trigger("change");
        $for.trigger("click");
    });

    $("#wpoi-complete-message").fadeIn();

    $(document).on("click", '#wpoi-complete-message .next-button button', function(e){
        $("#wpoi-complete-message").fadeOut();
    });

    $(document).on("click", ".wpoi-listing-page .wpoi-listing-wrap header.can-open", function(e){
        $(this).find(".open").trigger("click");
    });

    /**
     * On click of arrow of any optin in the listing page
     *
     */
    $(document).on("click", ".wpoi-listing-page .wpoi-listing-wrap .can-open .open", function(e){
        e.stopPropagation();
        var $this = $(this),
            $panel = $this.closest(".wpoi-listing-wrap"),
            $section = $panel.find("section"),
            $others = $(".wpoi-listing-wrap").not( $panel ),
            $other_sections = $(".wpoi-listing-wrap section").not( $section );

        $other_sections.slideUp(300, function(){
            "use strict";
            $other_sections.removeClass("open");
        });
        $others.find(".dev-icon").removeClass("dev-icon-caret_up").addClass("dev-icon-caret_down");

        $section.slideToggle(300, function(){
            $panel.toggleClass("open");
            $panel.find(".dev-icon").toggleClass( "dev-icon-caret_up dev-icon-caret_down" );
        });

    });


    /**
     * Slide toggle condition section and change arrow up or down
     *
     */
    $(document).on("click", ".wpoi-condition-item header", function(e){
        "use strict";
        var $this = $(this),
            $panel = $this.closest(".wpoi-condition-item"),
            $section = $panel.find( "section"),
            $icon = $panel.find(".dashicons-before");

        $section.slideToggle(300, function(){
            $icon.toggleClass("wpoi-arrow-up wpoi-arrow-down");
        });

    });

}( jQuery ));
