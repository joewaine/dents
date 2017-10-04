"use strict";
var Optin = Optin || {};
Optin.View = {};
Optin.Models = {};
Optin.Events = {};
if( typeof Backbone !== "undefined")
    _.extend(Optin.Events, Backbone.Events);
(function( $ ) {

    Optin.COOKIE_PREFIX = "inc_optin_long_hidden-";
    Optin.POPUP_COOKIE_PREFIX = "inc_optin_popup_long_hidden-";
    Optin.SLIDE_IN_COOKIE_PREFIX = "inc_optin_slide_in_long_hidden-";
    Optin.SLIDE_IN_COOKIE_HIDE_ALL = "inc_optin_slide_in_hide_all";

    _.mixin({
        toBool: function(val){
            if( _.isBoolean(val) )
                return val;

            if( _.isString( val ) && ["true", "false", "1"].indexOf( val.toLowerCase() ) !== -1 ){
                return val.toLowerCase() === "true" || val.toLowerCase() === "1" ? true : false;
            }

            if( _.isNumber( val ) )
                return !!val;

            if(_.isUndefined( val ) || _.isNull(val) || _.isNaN( val )  )
                return false;

            return val;
        },
        isTrue: function(val) {
            if( _.isUndefined( val ) || _.isNull( val ) || _.isNaN( val ) )
                return false;

            if( _.isNumber( val ) )
                return val !== 0;

            val = val.toString().toLowerCase();
            return ['1', "true"].indexOf( val ) !== -1;
        },
        control_base: function(checked, current, attribute){
            attribute = _.isUndefined( attribute ) ? "checked" : attribute;
            checked  = _.toBool(checked);
            current = _.isBoolean( checked ) ? _.isTrue( current ) : current;

            if(_.isEqual(checked, current )){
                return  attribute + '="' + attribute +'"';
            }
            return "";
        },
        /**
         * Returns checked=check if checked variable is equal to current state
         *
         *
         * @param checked checked state
         * @param current current state
         * @returns {*}
         */
        checked: function(checked, current){
            return _.control_base( checked, current, "checked" );
        },
        selected: function(selected, current){
            return _.control_base( selected, current, "selected" );
        },
        disabled: function( disabled, current ){
            return _.control_base( disabled, current, "disabled" );
        }
    });

    if( !_.findKey ) {
        _.mixin({
            findKey: function(obj, predicate, context) {
                predicate = cb(predicate, context);
                var keys = _.keys(obj), key;
                for (var i = 0, length = keys.length; i < length; i++) {
                    key = keys[i];
                    if (predicate(obj[key], key, obj)) return key;
                }
            }
        });
    }
    /**
     * Recursive toJSON
     *
     * @returns {*}
     */
        //Backbone.Model.prototype.toJSON = function() {
        //    var json = _.clone(this.attributes);
        //    for(var attr in json) {
        //        if((json[attr] instanceof Backbone.Model) || (json[attr] instanceof Backbone.Collection)) {
        //            json[attr] = json[attr].toJSON();
        //        }
        //    }
        //    return json;
        //};


    Array.prototype.has = function(element){
        return this.indexOf(element) !== -1;
    };

    String.prototype.toInt = function(){
        return parseInt(this, 10);
    };
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };

    Optin.template = _.memoize(function ( id ) {
        var compiled,

            options = {
                evaluate:    /<#([\s\S]+?)#>/g,
                interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
                escape:      /\{\{([^\}]+?)\}\}(?!\})/g
            };

        return function ( data ) {
            compiled = compiled || _.template( $( '#' + id ).html(), null, options );
            return compiled( data );
        };
    });

    Optin.cookie = {
        // Get a cookie value.
        get: function (name) {
            var i, c, cookie_name, value,
                ca = document.cookie.split(';');


            cookie_name = name + "=";

            for (i = 0; i < ca.length; i += 1) {
                c = ca[i];
                while (c.charAt(0) === ' ') {
                    c = c.substring(1, c.length);
                }
                if (c.indexOf(cookie_name) === 0) {
                    var _val = c.substring(cookie_name.length, c.length);
                    return !_val ? _val : JSON.parse(_val);
                }
            }
            return null;
        },

        // Saves the value into a cookie.
        set: function (name, value, days) {
            var date, expires;

            value = $.isArray(value) || $.isPlainObject(value) ? JSON.stringify(value) : value;

            if (!isNaN(days)) {
                date = new Date();
                date.setTime(date.getTime() + ( days * 24 * 60 * 60 * 1000 ));
                expires = "; expires=" + date.toGMTString();
            } else {
                expires = "";
            }

            document.cookie = name + "=" + value + expires + "; path=/";
        }
    };

    $(document).on('blur', 'input, textarea, select', function(){
	    var $this = $(this);
	    if($this.is(':input[type=button], :input[type=submit], :input[type=reset]')) return;
	    if( $this.val().trim() !== '' ) {
		    $this.parent().addClass('wpoi-filled');
		} else{
            $this.parent().removeClass('wpoi-filled');
        }
    });

    Optin.Mixins = {
        _mixins: {},
        _services_mixins: {},
        _desing_mixins: {},
        _display_mixins: {},
        add: function(id, obj){
            this._mixins[id] = obj;
        },
        get_mixins: function(){
            return this._mixins;
        },
        add_services_mixin: function( id, obj ){
            this._services_mixins[id] = obj;
        },
        get_services_mixins: function(){
            return this._services_mixins;
        }
    };

    $(document).on('blur', 'input, textarea, select', function(){
	    var $this = $(this);
	    if($this.is(':input[type=button], :input[type=submit], :input[type=reset]')) return;
	    if( $this.val().trim() !== '' ) {
		    $this.parent().addClass('wpoi-filled');
		} else{
            $this.parent().removeClass('wpoi-filled');
        }
    });

})( jQuery );
