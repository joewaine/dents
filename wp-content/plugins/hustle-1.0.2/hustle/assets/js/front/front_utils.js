var Optin = Optin || {};
(function( $, doc ) {
    "use strict";
    $.each(['show', 'hide'], function (i, ev) {
        var el = $.fn[ev];
        $.fn[ev] = function () {
            this.trigger(ev);
            return el.apply(this, arguments);
        };
    });


    /**
     * Set optin id from the html template
     */

    Optin.get_tpl = function( layout_id ){
        var templates = ["optin-layout-one", "optin-layout-two", "optin-layout-three", "optin-layout-four"];
        return Optin.template( templates[ layout_id ] );
    };



    Optin.popup = {
        shown:[],
        hidden:[],
        long_hidden: [],
        is_already_shown: function( popup_id ){
            return -1 !== this.shown.indexOf( popup_id );
        },
        is_long_hidden: function(optin_obj){
            return !!Optin.cookie.get( Optin.POPUP_COOKIE_PREFIX + optin_obj.id );
        },
        show: function( optin_obj ){

            if( this.is_long_hidden( optin_obj ) )
                return false;

            if( !this.is_already_shown( optin_obj.id )   )
                return optin_obj.show();

        }
    };

    // posts/pages bounce in animation
    var $animation_elements = $('.inc_opt_inline_wrap');
    var $window = $(window);

    function check_if_in_view() {
        var window_height = $window.height();
        var window_top_position = $window.scrollTop();
        var window_bottom_position = (window_top_position + window_height);

        $.each($animation_elements, function() {
            var $element = $(this);
            var element_height = $element.outerHeight();
            var element_top_position = $element.offset().top;
            var element_bottom_position = (element_top_position + element_height);

            //check to see if this current container is within viewport
            if ((element_bottom_position >= window_top_position) &&
                (element_top_position <= window_bottom_position)) {
                $element.addClass('in-view');
            } else {
                $element.removeClass('in-view');
            }
        });
    }

    function add_proper_classes(e, type, $popup, data){

        if(e.type === "wpoi:display" && type === "popup" ){
            (function (){
                var $parent = type === "popup" ? $(window) : $(this),
                    $this = $popup.find(".wpoi-hustle");
                if ( $parent.width() <= 405){
                    $this.find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ( $parent.width() <= 585) && ($parent.width() > 405) ){
                    $this.find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-medium");
                }
            }());
        }else{
            $(".wpoi-hustle").each(function(){
                var $parent = type === "popup" ? $(window) : $(this),
                    $this = $(this);
                if ( $parent.width() <= 405){
                    $this.find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ( $parent.width() <= 585) && ($parent.width() > 405) ){
                    $this.find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $this.find(".wpoi-optin").removeClass("wpoi-medium");
                }
            });
        }

        $(".wpoi-mcg-select").each(function(){
	        $(this).parent(".wpoi-provider-args > .wpoi-container > .wpoi-element:nth-child(2) > .wpoi-container > .wpoi-element").css({"padding":"0","background":"transparent"});
        });
        
        // Layout #3
        // Set height of image container same to parent div
        // This to avoid Safari conflicts with [ height: 100% ]
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .nocontent:not(.noimage)").each(function(){
	        var $this = $(this),
	        	$parent = $this.find(".wpoi-aside-x").prev(".wpoi-element"),
	        	$child = $this.find(".wpoi-aside-x").prev(".wpoi-element").find(".wpoi-container.wpoi-col");
	        $child.css("height", $parent.height());
        });
        
        // Layout #3
        // Vertical align content
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-x"),
	        	$div = $this.find(".wpoi-image").next(".wpoi-element"),
	        	$element = $aside.prev(".wpoi-element"),
	        	$content = $this.find(".wpoi-content"),
	        	$col = $element.find(".wpoi-col"),
	        	$form = $this.find("form");
	        
	        if ( $form.height() > $content.height() ){
		        $col.css("height", $aside.height() + 'px' );
		        $div.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
	        if ( $form.height() < $content.height() ){
		        $aside.css("height", $element.height() + 'px');
		        $aside.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
        });
        $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$sidebar = $this.find(".wpoi-aside-x"),
	        	$element = $sidebar.prev(".wpoi-element"),
	        	$form = $this.find("form");
	        
	        if ( $form.height() < $element.height() ){
		        $sidebar.css("height", $element.height());
		        $sidebar.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
        });
        
        // Layout #4
        // Vertical align content
        $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container.noimage:not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-xl"),
	        	$col = $this.find(".wpoi-aside-xl > .wpoi-container"),
	        	$parent = $aside.find(".wpoi-form"),
	        	$form = $aside.find("form"),
	        	$element = $aside.next(".wpoi-element"),
	        	$content = $element.find(".wpoi-content");
	        
	        if ( $content.height() > $form.height() ){
		        $col.css("height", $aside.height() + 'px');
		        $parent.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
	        if ( $content.height() < $form.height() ) {
		        $element.css("height", $col.height() + 'px');
		        $element.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
        });
        $(".wpoi-layout-four .wpoi-optin:not(.wpoi-small) > .wpoi-container:not(.noimage):not(.nocontent)").each(function(){
	        var $this = $(this),
	        	$aside = $this.find(".wpoi-aside-xl"),
	        	$col = $this.find(".wpoi-aside-xl > .wpoi-container"),
	        	$image = $this.find(".wpoi-image"),
	        	$parent = $aside.find(".wpoi-form"),
	        	$form = $aside.find("form"),
	        	$element = $aside.next(".wpoi-element"),
	        	$content = $this.find(".wpoi-content");
	        
	        if ( $content.height() > $col.height() ){
		        $col.css("height", $aside.height() + 'px');
		        $parent.css("height", $col.height() - $image.height() );
		        $parent.addClass("wpoi-align");
		        $form.addClass("wpoi-align-element");
	        }
	        if ( $content.height() < $col.height() ) {
		        $element.css("height", $aside.height() + 'px');
		        $element.addClass("wpoi-align");
		        $content.addClass("wpoi-align-element");
	        }
        });
    }

    $(doc).on("wpoi:display", _.debounce(add_proper_classes, 50, false));
    $(window).on("resize", _.debounce( add_proper_classes, 50, false ) );

    $window.on('scroll resize', _.debounce( check_if_in_view, 50, false ) );
    $window.trigger('scroll');
    
    $(document).on('blur', 'input, textarea, select', function(){
	    var $this = $(this);
	    if($this.is(':input[type=button], :input[type=submit], :input[type=reset]')) return;
	    if($this.val().trim() !== '') {
		    $this.parent().addClass('wpoi-filled');
		} else{
            $this.parent().removeClass('wpoi-filled');
        }
    });

    $(document).on('focus', '.wpoi-optin input.required', function(){
        $(this).next('label').find('i.wpoi-icon').removeClass('i-error');
    });

    /**
     * Renders provider args and returns html
     *
     *
     * @since 1.0.1
     *
     * @param optin_data
     * @return html
     */
    Optin.render_provider_args = function( optin_data ){
        if( _.isEmpty( optin_data.provider_args ) ) return "";

        var provider_args_tpl = Optin.template( "optin-" + optin_data.data.optin_provider + "-args"  );
        return provider_args_tpl( optin_data.provider_args )
    };

    /**
     * Renders optin front layout based on give optin_data
     *
     * @param optin_data
     */
    Optin.render_optin = function( optin_data ){
        var layout = optin_data.design.form_location.toInt(),
            tpl = Optin.get_tpl( layout ),
            _show_args = function(){
                if( "mailchimp" === optin_data.data.optin_provider
                    && optin_data.provider_args
                    && optin_data.provider_args.group
                    && "hidden" !== optin_data.provider_args.group.form_field
                )
                return true;

                return false;
            },
            html = tpl(_.extend({
                image_style: ""
            }, optin_data.design, optin_data.design.borders, optin_data.data, {
                has_args: _show_args()
            }) );

        $(doc).trigger("wpoi:layout:rendered");
        return html;
    };

    var listening_to_exit_intent = false;
    Optin.listen_to_exit_intend = function(){

        if( listening_to_exit_intent ) return;

        $(doc).on("mouseleave", _.debounce( function(e){
            if( e.pageY <= 0 )
                $(doc).trigger("wpoi:exit_intended", e);
            }, 50, true
            )
        );

        listening_to_exit_intent = true;
    };

    var checking_adblock = false;
    Optin.is_adblock_enabled = function(){
        if( checking_adblock ) return;
        //
        //var $script = $('<script src="{url}" type="text/javascript"></script>'.replace("{url}", inc_opt.adblock_detector_js) );
        //$script.appendTo( "body" );

        if( $("#hustle_optin_adBlock_detector").length ){
            return false;
        }else{
            return true;
        }

        checking_adblock = true;
    }

}(jQuery, document));
