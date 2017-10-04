"use strict";
(function( $ ) {

    /**
     * Render inline optins ( widget )
     */
    var inc_opt_render_widgets = _.debounce( function(){
        $(".inc_opt_widget_wrap, .inc_opt_shortcode_wrap").each(function () {
            var $this = $(this),
                id = $this.data("id"),
                type = $this.is(".inc_opt_widget_wrap") ? "widget" : "shortcode";

            if( !id ) return;

            var optin = _.find(Optins, function (opt) {
                return id == opt.data.optin_id;
            });


            if (!optin) return;

            $this.data("handle", _.findKey(Optins, optin));
            $this.data("type", type);

            var html = Optin.render_optin( optin );

            Optin.handle_scroll( $this, type, optin );


            $this.html(html);

            // add provider args
            $this.find(".wpoi-provider-args").html( Optin.render_provider_args( optin )  );

            _.delay(function(){
                $(document).trigger("wpoi:display", [type, $this, optin ]);
            }, _.random(0, 300));

        });
    }, 50, true);

    inc_opt_render_widgets();

    $(document).on('upfront-load', function(){
        inc_opt_render_widgets();

        Upfront.Events.on("entity:object:refresh:start entity:object:refresh preview:build:start upfront:preview:build:stop", inc_opt_render_widgets);
    });


}(jQuery));