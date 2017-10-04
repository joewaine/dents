var Inc_Opt_Router = Backbone.Router.extend({

    routes: {
        "":         "services",
        "services": "services",
        "design":   "design",
        "display(/:optin_type)":  "display"
    },

    route: function(route, name, callback) {
        var router = this;
        if (!callback) callback = this[name];

        var f = function() {
            if( !Optin.step.model  )
                Optin.step.model = new Optin.Model( optin_vars.current.data );

            if( !Optin.step.services  )
                Optin.step.services = new Optin.View.Email_Services_Tab({ model: Optin.step.model, provider_args: new Optin.M( optin_vars.current.provider_args ) });

            if( !Optin.step.design  )
                Optin.step.design =  new  Optin.View.Design_Tab({ model: new Optin.Models.Design_Model( optin_vars.current.design ), optin: Optin.step.model });

            if( !Optin.step.display )
                Optin.step.display = new Optin.View.Display_Tab({ model: new Optin.Models.Settings_Model( optin_vars.current.settings ) });

            callback.apply(router, arguments);
        };


        return Backbone.Router.prototype.route.call(this, route, name, f);
    },
    execute: function(callback, args, name) {
        // Prevent changing tab if current tab does not validate
        var routeIndex = _.keys(this.routes).indexOf(name) - 1;
        if( routeIndex != Optin.step.current ) {
            switch ( Optin.step.current ) {
                case 0:
                    var validate = Optin.step.model.validate_first_step();
                    if ( validate.size() ) {
                        Optin.step.services.validate();
                        // Set the URL back to the original route and dont execute the route callback
                        Optin.router.navigate(_.keys(this.routes)[Optin.step.current +1], false);
                        // Current tab did not validate, don't route
                        return false;
                    }
                    break;
            }
        } else {
            // Set the URL back to the original route and dont execute the route callback
            Optin.router.navigate(_.keys(this.routes)[Optin.step.current +1], false);
            // don't route if same route as before
            return false;
        }

        Optin.Events.trigger("navigate", args, name);
        if (callback) callback.apply(this, args);
    },

    services: function() {
        Optin.step.activate_step( 0 );
    },

    design: function() {


        Optin.step.activate_step( 1 );
    },

    display: function( type ) {

        Optin.step.activate_step( 2 );

        // If optin type set in URL, scroll to it
        type = type || "";
        if( type != "" && jQuery('#wpoi-listing-wrap-' + type).length ) {

            jQuery('#wpoi-listing-wrap-' + type ).find("i.dev-icon:not(.search-icon)").trigger("click");

            //Wait for the elements to render
            /*
            window.setTimeout(function(){
                jQuery('html, body').animate({
                    scrollTop: jQuery('#wpoi-listing-wrap-' + type ).offset().top - 50
                }, 2000);

            }, 500);
            */

        }    
        
    }

});

/**
 * Init the routing if it's optin creation page
 */
if( 'hustle_page_inc_optin' == adminpage  ){
    Optin.router = new Inc_Opt_Router();
    Backbone.history.start();
}