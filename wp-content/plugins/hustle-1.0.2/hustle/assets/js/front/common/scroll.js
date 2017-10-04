(function( $ ) {
    Optin = Optin || {};
    Optin.handle_scroll = function( $el, type, optin ){
        var $win =  $(window),
            $doc = $(document);

        $win.on('scroll', _.debounce( function (evt) {

            var el = $el[0];

            var rect = el.getBoundingClientRect();

            if (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
            ) {
                $win.off(evt);
                $el.addClass("wpoi-show");
                $doc.trigger("wpoi:display", [type, $el, optin ]);
            }

        }, 5, true) );

    }

}(jQuery));