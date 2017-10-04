(function( $ ) {
    "use strict";
    var Conditions = Backbone.View.extend({
        template: Optin.template("wpoi-wizard-popup-conditions-handle"),
        events: {
          'click .wpoi-conditions-list-handles .wpoi-condition-item:not(.disabled)': 'toggle_condition',
          'click .wpoi-conditions-list-handles .wpoi-condition-item:not(.disabled) span': 'toggle_condition',
        },
        initialize: function(opts){
            this.type = opts.type;
            this.active_conditions = {};
            this.render();
        },
        render: function(){
           var conditions = this.model.get( this.type ).get( "conditions" );

            _.each( Optin.View.Conditions, function(condition, id){
                var handle = this.template({
                    label: this.get_label( id ),
                    id: id,
                    cid: this.get_condition_cid( id ),
                    active_class: conditions[ id ] ? "added" : '',
                    icon_class: conditions[ id ] ? "wpoi-remove" : "wpoi-add"
                });

                // add handle
                this.$('.wpoi-conditions-list-handles').append( handle  );

            }, this);

            _.each( conditions, function(condition, id){
                this.add_condition_panel(id);
            }, this);
        },
        get_condition_cid: function(id){
            return this.type + "_" + id;
        },
        get_label: function(id){
             var type_name = optin_vars.messages.settings[ this.type ] ? optin_vars.messages.settings[ this.type ] : this.type;
             return optin_vars.messages.conditions[ id ] ? optin_vars.messages.conditions[ id].replace("{type_name}", type_name) : id;
        },
        take_care_of_connecte_conditions: function(this_condition){
            /**
             * Disable those conditions which can't go with this condition
             */
            if( this_condition.disable && this_condition.disable.length ){
                _.each( this_condition.disable, function(disable_id, index){
                    var $disable_handle = this.$( "#" + this.get_condition_cid( disable_id ) );
                    $disable_handle.toggleClass("disabled");
                }, this) ;
            }
        },
        /**
         * Adds condition to optin type
         *
         * @param id
         * @param this_condition
         * @returns {*|{}}
         */
        add_condition: function (id, $handle) {
            var this_condition = this.add_condition_panel(id);
            /**
             * Add condition element
             */
            $handle.addClass("added");
            $handle.find("span").addClass("wpoi-remove");
            $handle.find("span").removeClass("wpoi-add");

            var conditions = this.model.get(this.type + ".conditions") || {};
            conditions[id] = this_condition.get_configs();
            this.model.get(this.type).set("conditions", conditions);
            return conditions;
        },
        /**
         * Removes conditon from optin type
         * @param id
         */
        remove_condition: function (id, this_condition, $handle) {
            this.take_care_of_connecte_conditions( this_condition );

            this_condition.remove();
            delete this.active_conditions[ id ];
            $handle.removeClass("added");
            $handle.find("span").removeClass("wpoi-remove");
            $handle.find("span").addClass("wpoi-add");

            var conditions = this.model.get(this.type + ".conditions") || {};
            delete conditions[id];
            this.model.get(this.type).set("conditions", conditions, {silent: true});
        },
        /**
         * Add condition pannel
         * 
         * @param id
         * @returns {*}
         */
        add_condition_panel: function ( id ) {
            var this_condition = this.active_conditions[id] = new Optin.View.Conditions[id]({
                model: this.model.get( this.type ),
                type: this.type
            });


            this.take_care_of_connecte_conditions( this_condition );

            /**
             * Append condition panel
             */
            this.$('.wpoi-condition-items').append(this_condition.$el);
            return this_condition;
        }, /**
         * Toggles each of the conditions
         *
         * @param e
         */
        toggle_condition: function(e){
            e.stopPropagation();
            var id = this.$(e.target.id).data("id") || this.$(e.target).closest(".wpoi-condition-item").data("id"),
                $handle = this.$('#' + this.get_condition_cid( id ) ),
                this_condition = this.active_conditions[ id ];

            if( this_condition ){
                this.remove_condition(id, this_condition, $handle );
            }else{
                this.add_condition(id, $handle);
            }


        }
    });

    Optin.View.Display_Tab = Backbone.View.extend($.extend(true, {}, Optin.View.Template_Mixin, {
        template: Optin.template("wpoi-wizard-settings_template"),
        widget_message_tpl: Optin.template("wpoi-wizard-settings_widget_template"),
        el: "#wpoi-wizard-settings",
        events: {
            "click .next-button a.next": "submit_and_save",
            "click .next-button a.previous": "go_to_design",
            "click .can-open.display-settings-icon span.open i.dev-icon": "toggle_boxes",
            "change #wpoi-after-content-state-toggle": "optin_type_toggle",
            "change #wpoi-popup-state-toggle": "optin_type_toggle",
            "change #wpoi-slide-in-state-toggle": "optin_type_toggle"
        },
        initialize: function(){
            this.listenTo( this.model, "change:after_content.animate", this.toggle_after_content_animation_select );
            this.listenTo( this.model, "change:slide_in.position", this.update_slide_in_position_label );
            this.listenTo( this.model, "change:shortcode_id", _.bind(this.render_widget_message, this) );
            this.listenTo( this.model, "change:after_content.show_on_all_cats", this.move_selects_under_selected_radio);
            this.listenTo( this.model, "change:after_content.show_on_all_tags", this.move_selects_under_selected_radio);
            this.listenTo( this.model, "change:popup.show_on_all_cats", this.move_selects_under_selected_radio);
            this.listenTo( this.model, "change:popup.show_on_all_tags", this.move_selects_under_selected_radio);
            this.listenTo( this.model, "change:slide_in.show_on_all_cats", this.move_selects_under_selected_radio);
            this.listenTo( this.model, "change:slide_in.show_on_all_tags", this.move_selects_under_selected_radio);

            return this.render();
        },
        move_selects_under_selected_radio: function( key, val, options ){
            var value =  this.model.get( key ),
                block_class = "." + key.replace(".", "_") + "_block",
                select_wrap = block_class + '_select_wrap',
                $second_radio = this.$( block_class ).eq(1),
                $tags_select = this.$( select_wrap );

            if( !$second_radio.length || !$tags_select.length ) return;

            if( _.isTrue( value ) )
                $second_radio.insertAfter( $tags_select );
            else
                $second_radio.insertBefore( $tags_select );
        },
        /**
         * Renders widget message
         */
        render_widget_message: function (){
            var html = this.widget_message_tpl( this.model.toJSON() );
            this.$("#wpoi-wizard-settings-widget-message").html( html );
        },
        render: function(){
            var self = this,
                either_all_or_others = function(e){
                    var val = ["all"];
                    if( e.params && e.params.data && e.params.data.id && "all" === e.params.data.id ){

                    }else{
                        val = $(this).val();
                        if( -1 !== val.indexOf( "all" ) )
                            val.splice( val.indexOf( "all" ), 1 );
                    }

                    $(this).val(val).trigger("change");
                };
            this.model.set('slide_in.position_label', optin_vars.messages.positions[this.model.get('slide_in.position')], { silent:true } );

            $.fn.wpmuiSelect.defaults.set("createTag", function(){ return false; });

            this.$el.html( this.template( this.model.toJSON() ) );
            this.render_widget_message();

            new Optin.View.Conditions.View({
                model: this.model,
                el: "#wpoi-conditions-wrap-popup",
                type: "popup"
            });

            new Optin.View.Conditions.View({
                model: this.model,
                el: "#wpoi-conditions-wrap-slide_in",
                type: "slide_in"
            });

            new Optin.View.Display_Triggers({
                model: this.model,
                el: "#triggers-section-popup",
                type: "popup"
            });

            new Optin.View.Display_Triggers({
                model: this.model,
                el: "#triggers-section-slide_in",
                type: "slide_in"
            });

            this.$el.find(".can-open.display-settings-icon span.open i.dev-icon").trigger("click");

            // After content
            this.$("#after_content_selected_cats").wpmuiSelect({
                data: optin_vars.cats,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("after_content.show_on_these_cats", $(this).val());
            }).val( this.model.get("after_content.show_on_these_cats") ).trigger("change");

            this.$("#after_content_selected_tags").wpmuiSelect({
                data: optin_vars.tags,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("after_content.show_on_these_tags", $(this).val());
            }).val( this.model.get("after_content.show_on_these_tags") ).trigger("change");

            this.$("#after_content_selected_post_exceptions").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                if( $(this).val() != null ) $("#after_content_selected_post").val( null ).trigger('change');
                self.model.set("after_content.excluded_posts", $(this).val());
            })
            .val( this.model.get("after_content.excluded_posts") ).trigger("change");

            this.$("#after_content_selected_post").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#after_content_selected_post_exceptions").val( null ).trigger('change');
                self.model.set("after_content.selected_posts", $(this).val());
            })
            .val( this.model.get("after_content.selected_posts") ).trigger("change");

            this.$("#after_content_selected_pages_exceptions").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
            })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#after_content_selected_pages").val( null ).trigger('change');
                self.model.set("after_content.excluded_pages", $(this).val());
            })
            .val( this.model.get("after_content.excluded_pages") ).trigger("change");

            this.$("#after_content_selected_pages").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
             })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#after_content_selected_pages_exceptions").val( null ).trigger('change');
                self.model.set("after_content.selected_pages", $(this).val());
            })
            .val( this.model.get("after_content.selected_pages") ).trigger("change");


            // PopUp
            this.$("#popup_selected_cats").wpmuiSelect({
                data: optin_vars.cats,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("popup.show_on_these_cats", $(this).val());
            }).val( this.model.get("popup.show_on_these_cats") ).trigger("change");

            this.$("#popup_selected_tags").wpmuiSelect({
                data: optin_vars.tags,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("popup.show_on_these_tags", $(this).val());
            }).val( this.model.get("popup.show_on_these_tags") ).trigger("change");

            this.$("#popup_selected_post_exceptions").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#popup_selected_post").val( null ).trigger('change');
                self.model.set("popup.excluded_posts", $(this).val());
            })
            .val( this.model.get("popup.excluded_posts") ).trigger("change");

            this.$("#popup_selected_post").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#popup_selected_post_exceptions").val( null ).trigger('change');
                self.model.set("popup.selected_posts", $(this).val());
            })
            .val( this.model.get("popup.selected_posts") ).trigger("change");

            this.$("#popup_selected_pages_exceptions").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
            })
            .on("select2:select", either_all_or_others)
            .on("change", function(){
                if( $(this).val() != null ) $("#popup_selected_pages").val( null ).trigger('change');
                self.model.set("popup.excluded_pages", $(this).val());
            })
            .val( this.model.get("popup.excluded_pages") ).trigger("change");

            this.$("#popup_selected_pages").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                var val = $(this).val();
                if( val != null ) $("#popup_selected_pages_exceptions").val( null ).trigger('change');
                self.model.set("popup.selected_pages", val );
            })
            .val( this.model.get("popup.selected_pages") ).trigger("change");

            // slide_in
            this.$("#slide_in_selected_cats").wpmuiSelect({
                data: optin_vars.cats,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("slide_in.show_on_these_cats", $(this).val());
            }).val( this.model.get("slide_in.show_on_these_cats") ).trigger("change");

            this.$("#slide_in_selected_tags").wpmuiSelect({
                data: optin_vars.tags,
                tags: "true",
                width : "100%"
            }).on("change", function(){
                self.model.set("slide_in.show_on_these_tags", $(this).val());
            }).val( this.model.get("slide_in.show_on_these_tags") ).trigger("change");

            this.$("#slide_in_selected_post_exceptions").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                if( $(this).val() != null ) $("#slide_in_selected_post").val( null ).trigger('change');
                self.model.set("slide_in.excluded_posts", $(this).val());
            })
            .val( this.model.get("slide_in.excluded_posts") ).trigger("change");

            this.$("#slide_in_selected_post").wpmuiSelect({
                data: optin_vars.posts,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                if( $(this).val() != null ) $("#slide_in_selected_post_exceptions").val( null ).trigger('change');
                self.model.set("slide_in.selected_posts", $(this).val());
            })
            .val( this.model.get("slide_in.selected_posts") || ["all"] ).trigger("change");

            this.$("#slide_in_selected_pages_exceptions").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                if( $(this).val() != null ) $("#slide_in_selected_pages").val( null ).trigger('change');
                self.model.set("slide_in.excluded_pages", $(this).val());
            })
            .val( this.model.get("slide_in.excluded_pages") ).trigger("change");

            this.$("#slide_in_selected_pages").wpmuiSelect({
                data: optin_vars.pages,
                tags: "true",
                width : "100%"
            })
            .on('select2:select', either_all_or_others )
            .on("change", function(){
                if( $(this).val() != null ) $("#slide_in_selected_pages_exceptions").val( null ).trigger('change');
                self.model.set("slide_in.selected_pages", $(this).val());
            })
            .val( this.model.get("slide_in.selected_pages") ).trigger("change");

            $(".wpoi-toggle-block").each(function(){
                var p = $(this).find("p");
                var check = $(this).find(".toggle-checkbox");
                if( check.is(":checked") ) p.hide();
            })
        },
        optin_type_toggle: function(e){
            var $this = $(e.target),
                $block = $this.closest(".wpoi-toggle-block"),
                $p = $block.find("p").first(),
                $section = $this.closest(".wpoi-listing-wrap").find("section");

            if( $this.is(":checked") ) {
                $p.fadeOut();
                $block.removeClass("inactive");

            } else {
                $p.fadeIn();
                $block.addClass("inactive");
            }

            if( $section.is(".closed") && $this.is(":checked") )
                $this.closest(".wpoi-toggle-mask").find("span.open i.dev-icon").trigger("click");
        },
        toggle_boxes: function(e){
            var $this = $(e.target);
            var classOpen = "dev-icon-caret_up";
            var classClosed = "dev-icon-caret_down";
            var currentClass = $this.hasClass(classOpen) ? classOpen : classClosed;
            var newClass = currentClass == classOpen ? classClosed : classOpen;
            var $section = $this.closest(".wpoi-listing-wrap").find("section");
            //if($section.hasClass("closed") && !$this.closest(".wpoi-toggle-mask").find(".toggle-checkbox").is(":checked") ) return;
            $this.switchClass(currentClass, newClass);
            $section.toggleClass("closed", currentClass == classClosed);
            $section.toggle(newClass == classClosed);
        },
        go_to_design: function(e){
            e.preventDefault();
            Optin.router.navigate("design", true);
        },
        submit_and_save: function(e){
            e.preventDefault();
            var errors = [],
                $this = $(e.target),
                nonce = $this.data("nonce"),
                new_optin = parseInt($this.data("id")) == -1 ? true: false;
            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: 'inc_opt_save_new',
                    id: $this.data("id"),
                    _ajax_nonce: nonce,
                    optin: Optin.step.services.model.toJSON(),
                    design: Optin.step.design.model.toJSON(),
                    settings: Optin.step.display.model.toJSON(),
                    provider_args: Optin.step.services.provider_args.toJSON()
                },
                success: function(res){
                    window.onbeforeunload = null;
                    var url = "?page=inc_optins";
                    if(new_optin) {
                        url += "&optin=" + res.data;
                    }else{
                        url += "&optin_updated=" + res.data;
                    }
                    window.location.search = url;
                }
            });


        },
        /**
         * Toggles after content animation dropdowns if "No Animation, Optin is always visible" is selected or deselected
         *
         *
         */
        toggle_after_content_animation_select: function(){
            if( _.isTrue( this.model.get("after_content.animate") ) ) {
                this.$("#optin-afterc-animation-block").show(function () {
                    $(this).removeClass("hidden");
                });
            }else{
                this.$("#optin-afterc-animation-block").hide( function(){
                    $(this).addClass("hidden");
                } );
            }
        },
        update_slide_in_position_label: function(e){
          this.$("#wpoi-slide_in-position-label").text( optin_vars.messages.positions[this.model.get('slide_in.position')] );
        }
    }));
})( jQuery );
