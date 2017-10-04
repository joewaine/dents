Optin.M = Backbone.Model.extend({
    toJSON: function(){

        var json = _.clone(this.attributes);
        for(var attr in json) {
            if((json[attr] instanceof Backbone.Model) || (json[attr] instanceof Backbone.Collection)) {
                json[attr] = json[attr].toJSON();
            }
        }
        return json;
    },
    set: function(key, val, options){

        if( typeof key === "string" &&  key.indexOf(".") !== -1 ){
            var parent = key.split(".")[0],
                child = key.split(".")[1],
                parent_model = this.get(parent);

            if( parent_model && parent_model instanceof Backbone.Model ){
                parent_model.set(child, val, options);
                this.trigger("change:" + key, key, val, options);
            }

        }else{
            Backbone.Model.prototype.set.call(this, key, val, options);
        }
    },
    get: function(key){
        if( typeof key === "string" &&  key.indexOf(".") !== -1 ){
            var parent = key.split(".")[0],
                child = key.split(".")[1];
            return this.get(parent).get(child);
        }else{
            return Backbone.Model.prototype.get.call(this, key);
        }
    }
});

Optin.Model  = Optin.M.extend({
    defaults: {
        optin_name: optin_vars.messages.model.defaults.optin_name,
        optin_title: optin_vars.messages.model.defaults.optin_title,
        optin_message: optin_vars.messages.model.defaults.optin_message,
        optin_provider: "",
        api_key: "",
        mail_list: "",
        active: 1,
        test_mode: 0
    },

    validate_first_step: function (attrs) {
        var errors = [];

        attrs = attrs || this.attributes;

        if ( !attrs.optin_name || attrs.optin_name.isEmpty() ) {
            errors.push({name: 'name', message: optin_vars.messages.model.errors.name });
        }

        if ( attrs.test_mode != 1 ) {
            if ( !attrs.optin_provider || attrs.optin_provider.isEmpty() ) {
                errors.push({name: 'provider', message: optin_vars.messages.model.errors.provider });
            }

            if ( !attrs.api_key || attrs.api_key.isEmpty() ) {
                errors.push({name: 'api_key', message: optin_vars.messages.model.errors.api_key  });
            }

            if ( !attrs.optin_mail_list || attrs.optin_mail_list.isEmpty() ) {
                errors.push({name: 'mail_list', message: optin_vars.messages.model.errors.mail_list  });
            }
        }

        return _( errors );
    }
});

Optin.Models.Color_Palette = Optin.M.extend({
    defaults:{
        _id: '',
        label: '',
        main_background: '',
        form_background: '',
        button_background: '',
        button_label_color: '',
        title_color: '',
        content_color: '',
        fields_background: '',
        fields_color: ''
    }
});

Optin.Models.Color_Palette_Collection = Backbone.Collection.extend({
    model: Optin.Models.Color_Palette
});

var Palettes = new Optin.Models.Color_Palette_Collection();

_.each(optin_vars.palettes, function(item, index){
    item._id = index.replace(new RegExp(" ", 'g'), "_").toLowerCase();
    item.label = index;
    var m = new Optin.Models.Color_Palette(item);
    Palettes.add(m);
});

Optin.Models.Colors_Model = Optin.M.extend({
    defaults: _.extend({
        customize: false,
        palette: Palettes.at(0).get("_id"),
        main_background: '',
        form_background: '',
        button_background: '',
        button_label: '',
        title_color: '',
        content_color: '',
        fields_background: '',
        fields_color: ''
    }, Palettes.at(0).toJSON())
});



Optin.Models.Borders_Model = Backbone.Model.extend({
    defaults:{
        rounded_corners: true,
        corners_radius: 0,
        fields_corners_radius: 0,
        button_corners_radius: 0,
        drop_shadow: false,
        dropshadow_value: 0,
        shadow_color: '#000',
        fields_style: 'joined', // alternative can be separated
        rounded_form_fields: true,
        rounded_form_button: true
    }
});

Optin.Models.Design_Model = Optin.M.extend({

    defaults:{
        success_message: optin_vars.messages.model.defaults.success_message,
        form_location: 0,
        elements: ['image'],
        image_location: "left",
        image_style: "cover",
        image_src: optin_vars.preview_image,
        colors: new Optin.Models.Colors_Model(),
        borders: new Optin.Models.Borders_Model(),
        opening_animation: "",
        closing_animation: "",
        css: "",
        input_icons: "animated_icon" // possible values no_icon|none_animated_icon|animated_icon
    },
    initialize: function(data){
        _.extend( this, data );
        if( ! ( this.get('colors') instanceof Backbone.Model ) ){
            this.set( 'colors', new Optin.Models.Colors_Model( this.colors ) );
        }

        if( ! ( this.get('borders') instanceof Backbone.Model ) ){
            this.set( 'borders', new Optin.Models.Borders_Model( this.borders ) );
        }
    }
});


Optin.Models.Settings_After_Content = Optin.M.extend({
    defaults:{
        enabled: false,

        show_on_all_posts: true,
        excluded_posts: [],
        selected_posts: [],
        show_on_all_pages: true,
        excluded_pages: [],
        selected_pages: [],

        show_on_all_cats: true,
        show_on_these_cats: [],
        show_on_all_tags: true,
        show_on_these_tags: [],

        animate: false,
        animation: ""
    }

});

Optin.Models.Settings_Popup_Model = Backbone.Model.extend({
    defaults:{
        enabled: false,
        animation_in: "",
        animation_out: "",
        appear_after: "time", // scrolled | time | click | exit_intent | adblock
        appear_after_scroll: "scrolled", // scrolled | selector
        appear_after_time_val: 5,
        appear_after_time_unit: "seconds",
        appear_after_page_portion_val: 20,
        appear_after_page_portion_unit: "%",
        appear_after_element_val:"",
        add_never_see_this_message: false,
        close_button_acts_as_never_see_again: false,
        never_see_expiry: 2,

        show_on_all_posts: true,
        excluded_posts: [],
        selected_posts: [],
        show_on_all_pages: true,
        excluded_pages: [],
        selected_pages: [],

        show_on_all_cats: true,
        show_on_these_cats: [],
        show_on_all_tags: true,
        show_on_these_tags: [],

        conditions: {},

        trigger_on_time: "immediately", // immediately|time
        trigger_on_element_click:"",
        trigger_on_exit: false,
        trigger_on_adblock: false,
        trigger_on_adblock_timed: false,
        trigger_on_adblock_timed_val: 180,
        trigger_on_adblock_timed_unit: "seconds"
    }
});




Optin.Models.Settings_Slide_In_Model = Backbone.Model.extend({
    defaults:{
        enabled: false,
        appear_after: "time", // scrolled | time | click | exit_intent | adblock
        appear_after_scroll: "scrolled", // scrolled | selector
        appear_after_time_val: 5,
        appear_after_time_unit: "seconds",
        appear_after_page_portion_val: 30,
        appear_after_page_portion_unit: "%",
        appear_after_element_val:"",
        hide_after: true,
        hide_after_val: 10,
        hide_after_unit: "seconds",
        position: "bottom_center",
        after_close: "keep_showing",

        show_on_all_posts: true,
        excluded_posts: [],
        selected_posts: [],
        show_on_all_pages: true,
        excluded_pages: [],
        selected_pages: [],

        show_on_all_cats: true,
        show_on_these_cats: [],
        show_on_all_tags: true,
        show_on_these_tags: [],

        conditions: {},

        trigger_on_time: "immediately", // immediately|time
        trigger_on_element_click:"",
        trigger_on_exit: false,
        trigger_on_adblock: false,
        trigger_on_adblock_timed: false,
        trigger_on_adblock_timed_val: 180,
        trigger_on_adblock_timed_unit: "seconds"
    }
});


Optin.Models.Settings_Model = Optin.M.extend({
    defaults:{
        shortcode_id: "",

        // This will no longer needed as all individual optin types will have its own display settings
        //show_on_all_cats: true,
        //show_on_these_cats: [],
        //show_on_all_tags: true,
        //show_on_these_tags: [],

        after_content: new Optin.Models.Settings_After_Content(),
        popup: new Optin.Models.Settings_Popup_Model(),
        slide_in: new Optin.Models.Settings_Slide_In_Model()
    },
    initialize: function( data ){
        _.extend( this, data );
        if( ! ( this.get('after_content') instanceof Backbone.Model ) ){
            this.set( 'after_content', new Optin.Models.Settings_After_Content( this.after_content ) );
        }

        if( ! ( this.get('popup') instanceof Backbone.Model ) ){
            this.set( 'popup', new Optin.Models.Settings_Popup_Model( this.popup ) );
        }

        if( ! ( this.get('slide_in') instanceof Backbone.Model ) ){
            this.set( 'slide_in', new Optin.Models.Settings_Slide_In_Model( this.slide_in ) );
        }
    }

});



