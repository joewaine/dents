"use strict";
(function( $ ) {
    Optin.View.Email_Services_Tab = _.extend( Backbone.View.extend({
        template: Optin.template("wpoi-wizard-services_template"),
        el: "#wpoi-wizard-services",
        events: {
            "input input": "update_model",
            "change #wpoi-test-mode-setup": "update_model",
            "change select": "update_model",
            "keyup input": "update_model",
            "click .next-button a": "validate",
            'change #optin_new_provider_name': 'provider_change',
            'click .optin_refresh_provider_details': 'refresh_provider_details'
        },
        initialize: function(opts){
            this.render();
            this.provider_args = opts.provider_args;
            this.$details_placeholder =  $("#optin_new_provider_account_details");
            this.$options_placeholder =  $("#optin_new_provider_account_options");
            this.params = this.get_params();
            if( typeof this.params.code != 'undefined' ){
                window.setTimeout(function(){
                    $('#optin_new_provider_name').trigger('change');
                }, 750);

            }

            _.each( Optin.Mixins.get_services_mixins(), function(mix, id){
                if( mix && typeof mix === "function")
                    this[id] = mix( this );

            }, this );
            
            return this;
        },
        render: function(){
            this.$el.html( this.template( this.model.toJSON() ) );
            this.fields = {
                name:  "#optin_new_name",
                provider:  "#optin_new_provider_name",
                api_key: "#optin_api_key",
                mail_list:  "#optin_email_list",
                test_mode: '#wpoi-test-mode-setup'
            };
            $("#wpoi-test-mode-setup").trigger("change");
            return this;
        },
        update_model: function(e){
            if( e )
                e.preventDefault();
            
            var $container = $('.optwiz-container'),
                self = this;

            Optin.step.model = Optin.step.model || new Optin.Model( optin_vars.current.data );

            Optin.step.model.set("optin_name", this.$( this.fields.name ).val() );

            // Update shortcode_id based on name
            _.delay(function(){
                Optin.step.display.model.set("shortcode_id", self.get_shortcode_id() );
            }, 50);

            Optin.step.model.set("optin_provider", this.$( this.fields.provider ).val() ) ;
            if( this.$(this.fields.api_key) )
                Optin.step.model.set("api_key", this.$(this.fields.api_key).val() );
            if( this.$( this.fields.mail_list).length )
                Optin.step.model.set("optin_mail_list", this.$( this.fields.mail_list ).val() ) ;
            Optin.step.model.set("test_mode", this.$( this.fields.test_mode ).is(":checked") ? 1 : 0 ) ;
            // disable the "service details" card when test mode is on
            this.$("#wpoi-service-details").toggleClass("disabled", this.$( this.fields.test_mode ).is(":checked") );
            this.$("#wpoi-service-details-disabled-notice").toggleClass("disabled", !this.$( this.fields.test_mode ).is(":checked") );

            this.$("#optin_new_provider_name").prop("disabled", this.$( this.fields.test_mode ).is(":checked") );
            this.$(".optin_refresh_provider_details").prop("disabled", this.$( this.fields.test_mode ).is(":checked") );

            /**
             * Disable all inputs, buttons and textarea on service details if in test mode
             */
            this.$("#wpoi-service-details input, #wpoi-service-details button, #wpoi-service-details textarea").prop("disabled", this.$( this.fields.test_mode ).is(":checked") );

        },
        get_shortcode_id: function(){
            return _.isEmpty( Optin.step.model.get("optin_name") ) ? "" : Optin.step.model.get("optin_name").toString().toLowerCase().trim().replace(/\s+/g, "-");
        },
        validate: function(e){
            if( e !== undefined ) e.preventDefault();

            Optin.Events.trigger("services:validate:before");

            this.update_model();
            var validation = Optin.step.model.validate_first_step();

            var provider_name = this.$("#optin_new_provider_name").val();
            if( provider_name && this[ provider_name ] && typeof this[ provider_name].validate === "function" ){
                var provider_validation = this[ provider_name].validate.call(this);
                validation = _( validation._wrapped.concat( provider_validation._wrapped ) );

            }

            if( !validation.size() ||  ( this.$( this.fields.test_mode ).is(":checked") &&  !_.isEmpty( this.$(this.fields.name).val() ) ) ){
                // Only perform navigation if a tab was actually clicked. The validate() function may also be called from somewhere else
                if( e !== undefined ) {
                    Optin.router.navigate("design", true);
                }
            }else{
                var _this = this;
                this.$el.find( "span.dashicons-warning" ).remove();
                validation.each(function(error, index){
                    var $icon = $('<span class="dashicons dashicons-warning"></span>'),
                        $field = _this.$( _this.fields[error.name] );
                    $icon.attr("title", error.message);

                    if( $field.hasClass('wdev-styled') )
                        $field.closest('.select-container').addClass( "wpoi-error" );
                    else
                        $field.addClass( "wpoi-error" );

                    if( $field.closest(".select-container").length )
                        $field.closest(".select-container").before( $icon );
                    else
                        $field.after( $icon );

                });
            }

            Optin.Events.trigger("services:validate:after");
        },
        get_params: function( ) {
            var url = location.search;
            var ampersand = "&";
            return _.chain(url.slice(1).split( ampersand ))
                .map(function (item) { if (item) { return item.split('='); } })
                .compact()
                .object()
                .value();
        },
        provider_change: function(e){
            if( !e.target.value ) return;
            var self = this;
            this.$details_placeholder.html("");
            this.$options_placeholder.html("");



            this.remove_prev_provider_args();

            $.get(ajaxurl, { action: "render_provider_account_options", id: e.target.value, _ajax_nonce: $(e.target).data("nonce"), optin: self.model.attributes.optin_id }, function( response ){
                if( response.success === true ){

                    self.$details_placeholder.html( response.data );
                    //self.$details_placeholder.find("input").not("label").wrapAll("<div class='wpoi-get-lists' />");
                    if( e.target.value == 'constantcontact' && typeof self.params.code != 'undefined' ) {
                        $('#optin_api_key').val(self.params.code);
                        $('.optin_refresh_provider_details').trigger('click');
                    }
                    self.delegateEvents();

                }else{
                    var html = "";
                    if( response.data && _.isArray( response.data ) )
                        html = response.data.join(", ");

                    self.$details_placeholder.html( html );
                }

            });
        },
        /**
         * Gets provider account option details, eg api key and etc and update #optin_new_provider_account_options content
         */
        refresh_provider_details: function(e){
            var self = this,
                $this = this.$(e.target),
                $form = $this.closest("form"),
                $box = this.$(".wpoi-box"),
                data = $form.serialize(),
                $input = $this.closest("#wpoi-get-lists").find("input"),
                $placeholder = this.$("#optin_new_provider_account_options");

            if(_.isEmpty( $input.val() ) ){
                return e.preventDefault();
            }

            this.remove_prev_provider_args();

            $placeholder.html( this.$( "#wpoi_loading_indicator" ).html() );

            data += "&action=refresh_provider_account_details";
            if( typeof self.model.attributes.optin_id !== 'undefined') data += "&optin=" + self.model.attributes.optin_id;

            $box.find("*").attr("disabled", true);

            /**
             * Silently clear the args untill they are filled again
             */
            Optin.step.services.provider_args.clear({silent: true});
            $.post(ajaxurl, data, function( response ){

                $box.find("*").attr("disabled", false);

                if( response.success === true ){

                    if( response.data.redirect_to ){
                        window.location.href = response.data.redirect_to;
                    }else {
                        $placeholder.html( response.data );
                        $form.find("select").each(function(){
                            WDP.wpmuSelect(this);
                        });
                    }
                }else{
                    $placeholder.html( response.data  );
                }

            }).fail(function( response ) {
                $placeholder.html( optin_vars.messages.something_went_wrong );
            });
        },
        remove_prev_provider_args: function(){
            var $prev_provider_args = $("#wpoi-mailchimp-prev-group-args");
            $prev_provider_args.empty();
        }
    }));
})( jQuery );
