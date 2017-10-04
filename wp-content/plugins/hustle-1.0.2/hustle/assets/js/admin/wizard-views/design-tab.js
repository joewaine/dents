(function( $ ) {
    Optin.View.Design_Tab = Backbone.View.extend({
        template: Optin.template("wpoi-wizard-design_template"),
        el: "#wpoi-wizard-design",
        defaults: {
            optin_input_icons: "",
        },
        layouts: [
            Optin.template("optin-layout-one"),
            Optin.template("optin-layout-two"),
            Optin.template("optin-layout-three"),
            Optin.template("optin-layout-four")
        ],
        events: {
            "keyup #optin_title": "update_optin_title",
            "click #wpoi-swap-image-button": "specify_image",
            "click #wpoi-delete-image-button": "delete_image",
            "click .wpoi-select-media .button-ghost": "specify_image",
            "click .wpoi-media-options .button-white": "toggle_image_menu",
            "click .wpoi-media-options-wrap-list .dev-icon-cross": "toggle_image_menu",
            "change input[name='optin-image-location']": 'update_image_location',
            "change input[name='optin-image-style']": 'update_image_style',
            "change #optin_form_location input[type='radio']": 'update_location',
            "change input[name='optin_input_icons']": 'update_input_icons',
            "change #optin_optional_elements input": 'update_optional_elements',
            "change #optin_color_palettes": "update_color_palette",
            "change #optin_customize_color_palette": 'update_customize_color_palette',
            "change [name='optin_fields_style']": 'update_fields_style',
            "change #optin_dropshadow_value": 'update_dropshadow_value',
            "change #optin_rounded_corners_radious": 'update_optin_rounded_corners_radious',
            "change #fields_rounded_corners_radious": 'update_fields_rounded_corners_radious',
            "change #button_rounded_corners_radious": 'update_button_rounded_corners_radious',
            "click .next-button .next": "go_to_display_settings",
            "click .next-button .previous": "go_to_services",
            "submit form.wpoi-form-wrap": "cancel_dummy_optin_submit",

            "click #optin_apply_custom_css": 'apply_custom_css',
            "mouseenter .wpoi-stylable-element": "highlight_stylable_element",
            "mouseleave .wpoi-stylable-element": "highlight_stylable_element",
            "click .wpoi-stylable-element": "insert_stylable_element",

            "click #wpoi-preview-optin-button": "preview_show_optin",
            "change input.wysiwyg-tab": "preview_toggle",
            "click #wpoi-preview-success-button": "preview_show_success",
            "click .wpoi-subscribe-send": "preview_show_success"
        },
        stylables: {
            ".wpoi-container ": "Opt-in Container",
            ".wpoi-form-title ": "Title",
            ".wpoi-form-message, .wpoi-form-message p ": "Content",
            ".wpoi-form-fields ": "Form Container",
            ".wpoi-form-fields .wpoi-subscribe-fname ": "First Name",
            ".wpoi-form-fields .wpoi-subscribe-lname ": "Last Name",
            ".wpoi-form-fields .wpoi-subscribe-email ": "Email",
            ".wpoi-form-fields .wpoi-subscribe-send ": "Form Button"
        },
        preview_template: "",
        color_pickers_tpl: Optin.template("optin-color-pickers"),
        initialize: function( options ){
            this.optin = options.optin;
            this.listenTo(this.model, "change", function(){
                this.render_preview();
            }, this);

            this.listenTo(this.optin, "change", function(){
                this.render_preview();
            }, this);

            this.preview_template = this.layouts[ this.model.get("form_location") ];

            Optin.router.on("route", _.bind( this.render_preview, this ));

            this.preview_success_message = false;


            this.preview_success_message = false;


            return this.render();
        },
        render: function(){
            this.$el.html( this.template( _.extend({}, { palettes: Palettes.toJSON() }, {stylables: this.stylables}, this.optin.toJSON(), this.model.toJSON() ) ) );
            $(".wpoi-image-preview").css('background-image', 'url(' + this.model.attributes.image_src + ')');
            $(".wpoi-media-options-wrap-list").hide();
            if( this.model.attributes.image_src == "" ){
                $(".wpoi-media-options").hide();
            }else{
                $(".wpoi-select-media .button-ghost").hide();
            }
            this.$preview = this.$("#optin-preview-wrapper");

            //$("input[name='optin-image-location']:checked").trigger("change");
            this.create_editors();
            this.render_color_pickers();
            this.render_preview();

            $("input[id='optin-image-location-"+this.model.attributes.image_location+"']").prop('checked', true);
            
            $("input[id='optin-image-style-"+this.model.attributes.image_style+"']").prop('checked', true);

            window.setTimeout(function(){
                $('.wp-picker-input-wrap').each(function(){
                    var $this = $(this);
                    $this.add($this.next()).wrapAll('<div class="wp-picker-absolute"></div>');
                });
                $("#optin_customize_color_palette").trigger("change");
            },400);

            window.setTimeout(function(){
                $("#optin_customize_color_palette").trigger("change");
            },1500);

            _.delay(_.bind(this.apply_custom_css, this), 100); // Lets apply custom css if any

            if(this.model.elements && this.model.elements instanceof Array && this.model.elements.has("first_name")){
                $("#optin_fname").prop('checked', true);
            }
            if(this.model.elements && this.model.elements instanceof Array && this.model.elements.has("last_name")){
                $("#optin_lname").prop('checked', true);
            }

            $('input[name=location]:checked').trigger("change");

        },
        cancel_dummy_optin_submit: function(e){
            e.preventDefault();
        },
        go_to_display_settings: function(e){
            e.preventDefault();
            Optin.router.navigate("display", true);
        },
        go_to_services: function(e){
            e.preventDefault();
            Optin.router.navigate("services", true);
        },
        update_color_palette: function(e){
            var palette = Palettes.findWhere({ "_id": e.target.value }),
                prev_val = this.model.get("colors").toJSON();
            this.model.set("colors", new Optin.M( _.extend({}, palette.toJSON(), {palette: e.target.value } ) ) );
            this.reset_color_pickers();
            this.$("#optin_customize_color_palette").prop("checked", false);
        },
        reset_color_pickers: function(){
            var self = this;
            this.$('#optwiz-custom_color .optin_color_picker').each(function(){
                var $this = $(this),
                    id = this.id,
                    field_name = id.replace("optin_", ""),
                    colors = self.model.get("colors");

                if($this.data("wpColorPicker") || $this.data("wpWpColorPicker") )
                    $this.wpColorPicker("color", colors.get(field_name));

            });
        },
        render_color_pickers: function(){
            this.$('#optwiz-custom_color').html( this.color_pickers_tpl( this.model.toJSON() ) );
            _.delay($.proxy(this._create_color_pickers, this), 100);
        },
        render_preview: function(){
            Optin.Events.trigger("design:preview:render:start");
            this.preview_template = this.layouts[ this.model.get("form_location") ];
            this.$preview.html( this.preview_template(_.extend({}, this.model.toJSON(), this.model.get("borders").toJSON(), this.optin.toJSON(), {
                has_args: this._show_args()
            } ) ) );
            this.update_styles();
            this.update_borders_style();


            //this.apply_custom_css();

            if(typeof this.$preview_optin_button == 'undefined'){
                this.$preview_optin_button = this.$("#wpoi-preview-optin-button");
                this.$preview_success_button = this.$("#wpoi-preview-success-button");
            }

            if(this.preview_success_message){
                this.$(".wpoi-success-message").addClass("wpoi-show-message");
                this.$preview_success_button.addClass("active");
            }else{
                this.$preview_optin_button.addClass("active");
            }
            this.$(".wpoi-layout-three .wpoi-optin .wpoi-form").each(function(){
                if ($(this).height() > 168) {
                    $(this).addClass("wpoi-align");
                    $(this).find("form").addClass("wpoi-align-element");
                } else {
                    $(this).removeClass("wpoi-align");
                    $(this).find("form").removeClass("wpoi-align-element");
                }
            });

            Optin.Events.trigger("design:preview:render:finish", this.$preview);

            var self = this;
            window.setTimeout(function(){
                self.apply_proper_preview_classes();
            },10);

            this._fix_layout_3_sizes();
        },
        // Layout #3
        // Set height of image container same to parent div
        // This to avoid Safari conflicts with [ height: 100% ]
        _fix_layout_3_sizes: function(){
            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .nocontent:not(.noimage)").each(function(){
                var $this = $(this),
                    $parent = $this.find(".wpoi-aside-x").prev(".wpoi-element"),
                    $child = $this.find(".wpoi-aside-x").prev(".wpoi-element").find(".wpoi-container.wpoi-col");
                $child.css("height", $parent.height());
            });

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
        },
        preview_toggle: function(e){
            if( e.target.id == 'wpoi-om' ){
                this.preview_show_optin();
            }else{
                this.preview_show_success(e);
            }
        },
        preview_show_optin: function(){
            this.preview_success_message = false;
            this.$preview_optin_button.addClass("active");
            this.$preview_success_button.removeClass("active");
            this.$(".wpoi-success-message").removeClass("wpoi-show-message");
        },
        preview_show_success: function(e){
            if( $(e.target).hasClass("wpoi-subscribe-send") ){
                e.preventDefault();
                this.$(".wpoi-success-message").addClass("wpoi-show-message");
                var scope = this;
                window.setTimeout(function(){
                    scope.$(".wpoi-success-message").removeClass("wpoi-show-message");
                },1500);
            } else {
                this.$preview_success_button.addClass("active");
                this.$preview_optin_button.removeClass("active");
                this.preview_success_message = true;
                this.$(".wpoi-success-message").addClass("wpoi-show-message");
            }
        },
        update_customize_color_palette: function(e){
            this.model.set("colors.customize", $(e.target).is(":checked") );
            if( $(e.target).is(":checked") ){
                this.$("#optin_color_palettes").closest(".select-container").find("select").prop("disabled", true);
                this.$("#optin_color_palettes").closest(".select-container").css("opacity", 0.3);
                this.$("#optin_color_palettes").closest(".select-container").css("cursor", "default");
                this.$("#optwiz-custom_color").fadeIn();
            }else{
                this.$("#optin_color_palettes").closest(".select-container").find("select").prop("disabled", false);
                this.$("#optin_color_palettes").closest(".select-container").css("opacity", 1);
                this.$("#optin_color_palettes").closest(".select-container").css("cursor", "pointer");
                this.$("#optwiz-custom_color").fadeOut();
            }
        },
        update_optin_title: function(e, ui){
            this.optin.set("optin_title", $(e.target).val() );
        },
        update_main_background: function(e, ui){
            this.model.set("colors.main_background", ui.color.toCSS() );
        },
        update_title_color: function(e, ui){
            this.model.set("colors.title_color", ui.color.toCSS() );
        },
        update_link_color: function(e, ui){
            this.model.set("colors.link_color", ui.color.toCSS() );
        },
        update_content_color: function(e, ui){
            this.model.set("colors.content_color", ui.color.toCSS() );
        },
        update_link_hover_color: function(e, ui){
            this.model.set("colors.link_hover_color", ui.color.toCSS() );
        },
        update_form_background: function(e, ui){
            this.model.set("colors.form_background", ui.color.toCSS() );
        },
        update_fields_background: function(e, ui){
            this.model.set("colors.fields_background", ui.color.toCSS() );
        },
        update_label_color: function(e, ui){
            this.model.set("colors.label_color", ui.color.toCSS() );
        },
        update_button_background: function(e, ui){
            this.model.set("colors.button_background", ui.color.toCSS() );
        },
        update_button_label: function(e, ui){
            this.model.set("colors.button_label", ui.color.toCSS() );
        },
        update_fields_color: function(e, ui){
            this.model.set("colors.fields_color", ui.color.toCSS() );
        },
        update_error_color: function(e, ui){
            this.model.set("colors.error_color", ui.color.toCSS() );
        },
        update_button_hover_background: function(e, ui){
            this.model.set("colors.button_hover_background", ui.color.toCSS() );
        },
        update_button_hover_label: function(e, ui){
            this.model.set("colors.button_hover_label", ui.color.toCSS() );
        },
        update_checkmark_color: function(e, ui){
            this.model.set("colors.checkmark_color", ui.color.toCSS() );
        },
        update_success_color: function(e, ui){
            this.model.set("colors.success_color", ui.color.toCSS() );
        },
        update_close_color: function(e, ui){
            this.model.set("colors.close_color", ui.color.toCSS() );
        },
        update_nsa_color: function(e, ui){
            this.model.set("colors.nsa_color", ui.color.toCSS() );
        },
        update_overlay_background: function(e, ui){
            this.model.set("colors.overlay_background", ui.color.toCSS() );
        },
        update_close_hover_color: function(e, ui){
            this.model.set("colors.close_hover_color", ui.color.toCSS() );
        },
        update_nsa_hover_color: function(e, ui){
            this.model.set("colors.nsa_hover_color", ui.color.toCSS() );
        },
        update_radio_background: function(e, ui){
            this.model.set("colors.radio_background", ui.color.toCSS() );
        },
        update_radio_checked_background: function(e, ui){
            this.model.set("colors.radio_checked_background", ui.color.toCSS() );
        },
        update_checkbox_background: function(e, ui){
            this.model.set("colors.checkbox_background", ui.color.toCSS() );
        },
        update_checkbox_checked_color: function(e, ui){
            this.model.set("colors.checkbox_checked_color", ui.color.toCSS() );
        },
        update_mcg_title_color: function(e, ui){
            this.model.set("colors.mcg_title_color", ui.color.toCSS() );
        },
        update_mcg_label_color: function(e, ui){
            this.model.set("colors.mcg_label_color", ui.color.toCSS() );
        },
        create_editors: function(){
            this._bind_to_message_editor();
            this._create_css_editor();
        },
        update_fields_style: function(e){
            this.model.set("borders.fields_style", $(e.target).val() );
            if(  'joined' === $(e.target).val() ){
                this.$("#fields_rounded_corners_radious").attr("disabled", true);
                this.$("#button_rounded_corners_radious").attr("disabled", true);
            }else{
                this.$("#fields_rounded_corners_radious").attr("disabled", false);
                this.$("#button_rounded_corners_radious").attr("disabled", false);
            }

            this.render_preview();
        },
        highlight_stylable_element: function(e){
            var $el = $(e.target),
                $stylable = $( $el.data("stylable") );

            $stylable.toggleClass("optin_hovered_stylable_element");
        },
        insert_stylable_element: function(e){
            e.preventDefault();
            var $el = $(e.target),
                stylable = $el.data("stylable") + "{}";

            this.css_editor.navigateFileEnd();
            this.css_editor.insert(stylable);
            this.css_editor.navigateLeft(1);
            this.css_editor.focus();

        },
        apply_proper_preview_classes: function(){
            $(".wpoi-hustle").each(function(){
                if ($(this).width() <= 405){
                    $(this).find(".wpoi-optin").addClass("wpoi-small");
                } else {
                    $(this).find(".wpoi-optin").removeClass("wpoi-small");
                }

                if ( ($(this).width() <= 585) && ($(this).width() > 405) ){
                    $(this).find(".wpoi-optin").addClass("wpoi-medium");
                } else {
                    $(this).find(".wpoi-optin").removeClass("wpoi-medium");
                }
            });

            $(".wpoi-layout-three .wpoi-optin:not(.wpoi-small) .wpoi-form").each(function(){
                if ($(this).height() > 168){
                    $(this).addClass("wpoi-align");
                    $(this).next("form").addClass("wpoi-align-element");
                } else {
                    $(this).removeClass("wpoi-align");
                    $(this).next("form").removeClass("wpoi-align-element");
                }
            });

            $(".wpoi-mcg-select").each(function(){
                $(this).parent(".wpoi-provider-args > .wpoi-container > .wpoi-element:nth-child(2) > .wpoi-container > .wpoi-element").css({"padding":"0","background":"transparent"});
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
        },
        _bind_to_message_editor: function(){
            var self = this;

            var waitForTinyMCE = setInterval(function() {
                if ( typeof tinymce === "object"  ){
                    clearInterval(waitForTinyMCE);


                    tinymce.on("AddEditor", function(args){
                        if( 'optin_message' === args.editor.getParam("id") )
                            self.message_editor = args.editor;

                        if( 'success_message' === args.editor.getParam("id") )
                            self.success_editor = args.editor;

                            args.editor.on("loadContent", function(e){ // set max width of body element inside iframe to 100%
                            this.dom.setStyle("tinymce", "maxWidth", "100%");
                        });
                        Optin.Events.off("navigate", self.refresh_editor, self );
                        Optin.Events.on("navigate", self.refresh_editor, self );
                        args.editor.on('change AddUndo keyup', function(e) {
                            if( 'optin_message' === args.editor.getParam("id") )
                                self.optin.set("optin_message", this.getContent() );

                            if( 'success_message' === args.editor.getParam("id") )
                                self.model.set("success_message", this.getContent() );

                            self.apply_proper_preview_classes();

                        });

                        self.apply_proper_preview_classes();
                        
                    });
                }

            }, 50);

        },
        refresh_editor: function(args, name){
            if( 'design' !== name || !_.isObject( this.message_editor )  ) return;
            this.message_editor.remove();
            tinymce.init(this.message_editor.settings);
            $(this.message_editor.settings.selector + "_ifr").height(240);

            this.success_editor.remove();
            tinymce.init(this.success_editor.settings);
            $(this.success_editor.settings.selector + "_ifr").height(240);

        },
        _create_css_editor: function(){
            this.css_editor = ace.edit("optin_custom_css");

            this.css_editor.getSession().setMode("ace/mode/css");
            this.css_editor.setTheme("ace/theme/solarized_light");
            this.css_editor.getSession().setUseWrapMode(true);
            this.css_editor.getSession().setUseWorker(false);
            this.css_editor.setShowPrintMargin(false);
            this.css_editor.renderer.setShowGutter(true);
            this.css_editor.setHighlightActiveLine(true);
            //this.css_editor.on("change", $.proxy(this.update_custom_css, this));
            this.css_editor.on("blur", $.proxy(this.update_custom_css, this));

        },
        _create_color_pickers: function(){
            var self = this;
            this.$(".optin_color_picker").wpColorPicker({
                change: function(event, ui){
                    var method_name = "update_" + this.id.replace("optin_", "");
                    if( typeof self[method_name] === "function"){
                        self[method_name](event, ui);
                        self.render_preview();
                    }else{
                        console.warn("Method ", method_name, " not found");
                    }
                }
            });
            this.$(".ui-draggable-handle").click(function(e){e.preventDefault();});

            /*$("#optin_color_palettes").select2({
             width: "150px",
             templateSelection: this.palette_dropdown_template,
             templateResult:this.palette_dropdown_template
             }).on("change", $.proxy(self.update_color_palette, this));*/

        },
        update_custom_css: function(){
            this.model.set("css", this.css_editor.getValue() );
        },
        apply_custom_css: function(e){
            if( e ) {
                e.preventDefault();
                $(e.target).prop("disabled", true);
            }
            this.update_custom_css();
            var $styles_el = $("#optin-custom-styles").length ? $("#optin-custom-styles") : $('<style id="optin-custom-styles">').appendTo("body"),
                css_string = this.css_editor.getValue();

            $.ajax({
                type: "POST",
                url: ajaxurl,
                dataType: "json",
                data: {
                    action: 'inc_opt_prepare_custom_css',
                    css: css_string,
                    _ajax_nonce: $("#optin_apply_custom_css").data("nonce"),
                    optin_id: optin_vars.current.data.optin_id
                },
                success: function(res){
                    if( res && res.success ){
                        $styles_el.html( res.data  );
                    }

                    if( e ) $(e.target).prop("disabled", false);
                },
                error: function() {
                    if( e ) $(e.target).prop("disabled", false);
                },
                dataType: "json"
            });
        },
        get_layout_colors: function(){
            if( !_.isTrue( this.model.get("colors.customize") ) )
                return Palettes.findWhere({_id: this.model.get("colors.palette")}).toJSON();
            else
                return this.model.toJSON().colors;
        },
        get_stylable_elements: function(){
            return {
                main_background: '.wpoi-hustle .wpoi-optin',
                title_color: '.wpoi-hustle h2.wpoi-title',
                link_color: '.wpoi-hustle .wpoi-message p a',
                content_color: '.wpoi-hustle .wpoi-message, .wpoi-hustle .wpoi-message p',
                link_hover_color: '.wpoi-hustle .wpoi-message p a:hover',
                form_background: '.wpoi-hustle .wpoi-form',
                fields_background: '.wpoi-hustle form .wpoi-element',
                label_color: '.wpoi-hustle form label, .wpoi-hustle form label span, .wpoi-hustle form wpoi-icon',
                button_background: '.wpoi-hustle form button',
                button_label: '.wpoi-hustle form button',
                fields_color: '.wpoi-hustle form > .wpoi-element input',
                error_color: '.wpoi-hustle form .i-error, .wpoi-hustle form .i-error + span',
                button_hover_background: '.wpoi-hustle form button:hover:not(:focus):not(:active), .wpoi-hustle form button:active, .wpoi-hustle form button:focus',
                button_hover_label: '.wpoi-hustle form button:hover:not(:focus):not(:active)',
                checkmark_color: '.wpoi-hustle .wpoi-success-message .wpoi-icon',
                success_color: '.wpoi-hustle .wpoi-success-message .wpoi-content, .wpoi-hustle .wpoi-success-message .wpoi-content p',
                close_color: 'a.inc-opt-close-popup',
                nsa_color: '.wpoi-nsa > a, .wpoi-nsa > a.inc_opt_never_see_again',
                overlay_background: '.wpoi-popup-overlay',
                close_hover_color: 'a.inc-opt-close-popup:hover, a.inc-opt-close-popup:active, a.inc-opt-close-popup:focus',
                nsa_hover_color: '.wpoi-nsa > a:hover, .wpoi-nsa > a.inc_opt_never_see_again:hover',
                radio_background: '.wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label:before',
                radio_checked_background: '.wpoi-hustle form .wpoi-mcg-option input[type="radio"]:checked + label:after',
                checkbox_background: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label:before',
                checkbox_checked_color: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"]:checked + label:before',
                mcg_title_color: '.wpoi-hustle form .wpoi-mcg-list-name, .wpoi-hustle .wpoi-submit-failure',
                mcg_label_color: '.wpoi-hustle form .wpoi-mcg-option input[type="checkbox"] + label, .wpoi-hustle form .wpoi-mcg-option input[type="radio"] + label'
            };
        },
        update_styles: function(){
            var colors = this.get_layout_colors(),
                styles = "",
                $styles_el = $("#optin-preview-styles").length ? $("#optin-preview-styles") : $('<style id="optin-preview-styles">').appendTo("body");

            _.each(this.get_stylable_elements(), function(el, index){
                var color_type = index.indexOf("background") !== -1 ? 'background' : 'color',
                    color = colors[index];
                styles += ( el + "{ " + color_type + ": " + color +";} " );
            });

            $styles_el.html( styles );
        },
        update_borders_style: function(){
            var borders = this.model.toJSON().borders,
                elements = this.get_stylable_elements(),
                styles = "",
                $styles_el = $("#optin-preview-styles-borders").length ? $("#optin-preview-styles-borders") : $('<style id="optin-preview-styles-borders">').appendTo("body");

            //main container border
            styles += ( elements.main_background + "{border-radius:" + borders.corners_radius + "px;}"  );

            if( 'joined' ===  this.model.get("borders").get('fields_style') ){ // set border to 0 if input and button are joined
                styles += ( elements.fields_background + "{border-radius: 0px;}"  );
                styles += ( elements.button_background + "{border-radius: 0px;}"  );
            }else{
                styles += ( elements.fields_background + "{border-radius:" + borders.fields_corners_radius + "px;}"  );
                styles += ( elements.button_background + "{border-radius:" + borders.button_corners_radius + "px;}"  );
            }

            // main container dropshadow
            if(_.isTrue( borders.drop_shadow ) )
                styles += ( elements.main_background + "{box-shadow: 0 0 " + borders.dropshadow_value +"px " + borders.shadow_color + "}"  );



            // Form Fields:
            /*if(_.isTrue( borders.rounded_form_button ))
                styles += ( elements.button_label + "{border-radius:"  +  "36px !important;}"  );
            if(_.isTrue( borders.rounded_form_fields ) )
                styles += ( elements.fields_background + "{border-radius:"  + "5px;}"  );*/

            $styles_el.html( styles );
        },
        update_optin_rounded_corners_radious: function(e){
            this.model.set("borders.corners_radius", $(e.target).val() );
            this.render_preview();
        },
        update_fields_rounded_corners_radious: function(e){
            this.model.set("borders.fields_corners_radius", $(e.target).val() );
            this.render_preview();
        },
        update_button_rounded_corners_radious: function(e){
            this.model.set("borders.button_corners_radius", $(e.target).val() );
            this.render_preview();
        },
        toggle_image_menu: function(e){
            $(".wpoi-media-options-wrap-list").toggle();
        },
        delete_image: function(e){
            e.preventDefault();
            this.model.set("image_src", "");
            $(".wpoi-image-preview").css('background-image', 'url()');
            $(".wpoi-media-options").hide();
            $(".wpoi-select-media .button-ghost").show();
            $(".wpoi-media-options-wrap-list").hide();
        },
        specify_image: function(e){
            e.preventDefault();
            var self = this;
            /**
             * Sets image from attachment
             *
             * @param props
             * @param attachment
             */
            wp.media.editor.send.attachment = function(props, attachment)
            {
                self.model.set("image_src", attachment.url);
                $(".wpoi-image-preview").css('background-image', 'url(' + attachment.url + ')');
                $(".wpoi-media-options").show();
                $(".wpoi-select-media .button-ghost").hide();
                $(".wpoi-media-options-wrap-list").hide();
            };



            /**
             * Sets image from Url
             *
             * @param props
             * @param attachment
             * @returns {*}
             */
            wp.media.string.props = function(props, attachment){
                self.model.set("image_src", props.url);
                $(".wpoi-image-preview").css('background-image', 'url(' + props.url + ')');
                $(".wpoi-media-options").show();
                $(".wpoi-select-media .button-ghost").hide();
                $(".wpoi-media-options-wrap-list").hide();
                return props;
            };


            /**
             * Opens media browser
             */
            wp.media.editor.open("optin_specify_image", {
                multiple: false
            });
        },
        update_shadow_color: function(event, ui){
            this.model.set("borders.shadow_color", ui.color.toCSS() );
            this.model.trigger("change");
        },
        update_dropshadow: function(e){
            this.model.set("borders.drop_shadow", $(e.target).is(":checked") );
            this.render_preview();
        },
        update_dropshadow_value: function(e){
            if( $(e.target).val() == "" || parseInt($(e.target).val()) == 0 ) {
                this.model.set("borders.drop_shadow", false );
            } else {
                this.model.set("borders.drop_shadow", true );
            }
            this.model.set("borders.dropshadow_value", $(e.target).val() );
            this.render_preview();
        },
        update_image_location: function(e){
            this.model.set("image_location", e.target.value);
        },
        update_image_style: function(e){
            this.model.set("image_style", e.target.value);
        },
        update_location: function(e){
            var val = parseInt( e.target.value, 10 );
            this.model.set("form_location", val);

            /**
             * If layout other than 0 is selected  hide image location 'above' and 'below'
             * and set image_location to 'left'
             */
            if( val != 0){
                $("#optin-image-location-above, [for='optin-image-location-above']").addClass("wpoi-hidden").hide();
                $("#optin-image-location-bellow, [for='optin-image-location-bellow']").addClass("wpoi-hidden").hide();

                if( this.model.attributes.image_location != "left" && this.model.attributes.image_location != "right") {
                    this.model.set("image_location", 'left');
                    $("[name='optin-image-location'][value='left']").prop("checked", true);
                }
            }else{
                $("#optin-image-location-above, [for='optin-image-location-above']").removeClass("wpoi-hidden").show();
                $("#optin-image-location-bellow, [for='optin-image-location-bellow']").removeClass("wpoi-hidden").show();
            }
        },
        update_input_icons: function(e){
            this.model.set("input_icons", e.target.value);
        },
        update_optional_elements: function(e){
            var vals = this.model.get("elements");
            if( e.target.checked ){
                vals.push( e.target.value );
                this.model.set("elements", vals) ;
                this.model.trigger("change"); // explicitly trigger change since the value is array
            }else{
                this.model.set("elements", _.without( vals, e.target.name ) );
            }
        },
        _show_args: function(){
            if( "mailchimp" === Optin.step.services.model.get("optin_provider")
                && !Optin.step.services.provider_args.isEmpty()
                && "hidden" !== Optin.step.services.provider_args.get("group").form_field
            )
            return true;

            return false;
        }
    });
})( jQuery );
