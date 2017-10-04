(function($) {
	"use strict";

	var Shortcodes = vc.shortcodes;
    window.VcRowView = vc.shortcode_view.extend({
        change_columns_layout:false,
		events: {
			'click > .vc_controls [data-vc-control="delete"]': "deleteShortcode",
			"click > .vc_controls .set_columns": "setColumns",
			'click > .vc_controls [data-vc-control="add"]': "addElement",
			'click > .vc_controls [data-vc-control="edit"]': "editElement",
			'click > .vc_controls [data-vc-control="clone"]': "clone",
			'click > .vc_controls [data-vc-control="move"]': "moveElement",
			'click > .vc_controls [data-vc-control="toggle"]': "toggleElement",
			"click > .wpb_element_wrapper .vc_controls": "openClosedRow"
		},
		convertRowColumns: function ( layout ) {
			var layout_split = layout.toString().split( /_/ ),
				columns = Shortcodes.where( { parent_id: this.model.id } ),
				new_columns = [],
				new_layout = [],
				new_width = '';
			_.each( layout_split, function ( value, i ) {
				var column_data = _.map( value.toString().split( '' ), function ( v, i ) {
						return parseInt( v, 10 );
					} ),
					new_column_params, new_column;
				if ( 3 < column_data.length ) {
					new_width = column_data[ 0 ] + '' + column_data[ 1 ] + '/' + column_data[ 2 ] + '' + column_data[ 3 ];
				} else if ( 2 < column_data.length ) {
					new_width = column_data[ 0 ] + '/' + column_data[ 1 ] + '' + column_data[ 2 ];
				} else {
					new_width = column_data[ 0 ] + '/' + column_data[ 1 ];
				}
				new_layout.push( new_width );
				new_column_params = _.extend( ! _.isUndefined( columns[ i ] ) ? columns[ i ].get( 'params' ) : {},
					{ width: new_width } ),
					vc.storage.lock();
				new_column = Shortcodes.create( {
					shortcode: this.getChildTag(),
					params: new_column_params,
					parent_id: this.model.id
				} );
				if ( _.isObject( columns[ i ] ) ) {
					_.each( Shortcodes.where( { parent_id: columns[ i ].id } ), function ( shortcode ) {
						vc.storage.lock();
						shortcode.save( { parent_id: new_column.id } );
						vc.storage.lock();
						shortcode.trigger( 'change_parent_id' );
					} );
				}
				new_columns.push( new_column );
			}, this );
			if ( layout_split.length < columns.length ) {
				_.each( columns.slice( layout_split.length ), function ( column ) {
					_.each( Shortcodes.where( { parent_id: column.id } ), function ( shortcode ) {
						vc.storage.lock();
						shortcode.save( { 'parent_id': _.last( new_columns ).id } );
						vc.storage.lock();
						shortcode.trigger( 'change_parent_id' );
					} );
				} );
			}
			_.each( columns, function ( shortcode ) {
				vc.storage.lock();
				shortcode.destroy();
			}, this );
			this.model.save();
			this.setActiveLayoutButton( '' + layout );
			return new_layout;
		},
        changeShortcodeParams:function (model) {
          //window.VcRowView.__super__.changeShortcodeParams.call(this, model);
			window.VcRowView.__super__.changeShortcodeParams.call(this, model), this.buildDesignHelpers(), this.setRowClasses()
        },
		setRowClasses: function() {
			var disable = this.model.getParam("disable_element"),
				disableClass = "vc_hidden-xs vc_hidden-sm  vc_hidden-md vc_hidden-lg";
			this.disable_element_class && this.$el.removeClass(this.disable_element_class), _.isEmpty(disable) || (this.$el.addClass(disableClass), this.disable_element_class = disableClass)
		},
        buildDesignHelpers: function() {

		  var image = this.model.getParam('bg_image'),
		  color = this.model.getParam('bg_color'),
		  $column_toggle = this.$el.find('> .vc_controls .column_toggle');

          this.$el.find('> .controls .vc_row_color').remove();
          //this.$el.find('> .controls .vc_row_image').remove();

		  // "Hide on screens sizes" preview
          this.$el.find('> .vc_controls .vc_row_screens').remove();
		  var row_show_on = this.model.getParam('row_show_on');
		  if(row_show_on) {
		    var hide_on_screen = ' '+ row_show_on.replace(/,/gi, ' ');
		  } else {
		    var hide_on_screen = '';
		  }
          $('<span class="vc_row_screens'+ hide_on_screen +'"><i class="device-icon device-screen"></i><i class="device-icon device-tablet2"></i><i class="device-icon device-tablet"></i><i class="device-icon device-mobile2"></i><i class="device-icon device-mobile"></i></span>').insertAfter($column_toggle);
		  // End preview


          if(color) {
            $('<span class="vc_row_color" style="background-color: ' + color + '" title="' + i18nLocale.row_background_color + '"></span>')
              .insertAfter($column_toggle);
          }
        },
		addElement: function ( e ) {
			e && e.preventDefault();
			Shortcodes.create( { shortcode: this.getChildTag(), params: {}, parent_id: this.model.id } );
			this.setActiveLayoutButton();
			this.$el.removeClass( 'vc_collapsed-row' );
		},
		getChildTag: function () {
			return 'vc_row_inner' === this.model.get( 'shortcode' ) ? 'vc_column_inner' : 'vc_column';
		},
		sortingSelector: "> [data-element_type=vc_column], > [data-element_type=vc_column_inner]",
		setSorting: function () {
			var that = this;
			if ( 1 < this.$content.find( this.sortingSelector ).length ) {
				this.$content.removeClass( 'wpb-not-sortable' ).sortable( {
					forcePlaceholderSize: true,
					placeholder: "widgets-placeholder-column",
					tolerance: "pointer",
					// cursorAt: { left: 10, top : 20 },
					cursor: "move",
					//handle: '.controls',
					items: this.sortingSelector, //wpb_sortablee
					distance: 0.5,
					start: function ( event, ui ) {
						$( '#visual_composer_content' ).addClass( 'vc_sorting-started' );
						ui.placeholder.width( ui.item.width() );
					},
					stop: function ( event, ui ) {
						$( '#visual_composer_content' ).removeClass( 'vc_sorting-started' );
					},
					update: function () {
						var $columns = $( that.sortingSelector, that.$content );
						$columns.each( function () {
							var model = $( this ).data( 'model' ),
								index = $( this ).index();
							model.set( 'order', index );
							if ( $columns.length - 1 > index ) {
								vc.storage.lock();
							}
							model.save();
						} );
					},
					over: function ( event, ui ) {
						ui.placeholder.css( { maxWidth: ui.placeholder.parent().width() } );
						ui.placeholder.removeClass( 'vc_hidden-placeholder' );
					},
					beforeStop: function ( event, ui ) {
					}
				} );
			} else {
				if ( this.$content.hasClass( 'ui-sortable' ) ) {
					this.$content.sortable( 'destroy' );
				}
				this.$content.addClass( 'wpb-not-sortable' );
			}
		},
		validateCellsList: function ( cells ) {
			var return_cells = [],
				split = cells.replace( /\s/g, '' ).split( '+' ),
				b;
			var sum = _.reduce( _.map( split, function ( c ) {
				if ( c.match( /^(vc_)?span\d?$/ ) ) {
					var converted_c = vc_convert_column_span_size( c );
					if ( false === converted_c ) {
						return 1000;
					}
					b = converted_c.split( /\// );
					return_cells.push( b[ 0 ] + '' + b[ 1 ] );
					return 12 * parseInt( b[ 0 ], 10 ) / parseInt( b[ 1 ], 10 );
				} else if ( c.match( /^[1-9]|1[0-2]\/[1-9]|1[0-2]$/ ) ) {
					b = c.split( /\// );
					return_cells.push( b[ 0 ] + '' + b[ 1 ] );
					return 12 * parseInt( b[ 0 ], 10 ) / parseInt( b[ 1 ], 10 );
				}
				return 10000;

			} ), function ( num, memo ) {
				memo = memo + num;
				return memo;
			}, 0 );
			if ( 12 !== sum ) {
				return false;
			}
			return return_cells.join( '_' );
		},
		setActiveLayoutButton: function ( column_layout ) {
			if ( ! column_layout ) {
				column_layout = _.map( vc.shortcodes.where( { parent_id: this.model.get( 'id' ) } ),
					function ( model ) {
						var width = model.getParam( 'width' );
						return ! width ? '11' : width.replace( /\//, '' );
					} ).join( '_' );
			}
			this.$el.find( '> .vc_controls .vc_active' ).removeClass( 'vc_active' );
			var $button = this.$el.find( '> .controls [data-cells-mask="' + vc_get_column_mask( column_layout ) + '"] [data-cells="' + column_layout + '"]'
			+ ', > .vc_controls [data-cells-mask="' + vc_get_column_mask( column_layout ) + '"][data-cells="' + column_layout + '"]' );
			if ( $button.length ) {
				$button.addClass( 'vc_active' );
			} else {
				this.$el.find( '> .controls [data-cells-mask=custom]' ).addClass( 'vc_active' );
			}
		},
		layoutEditor: function () {
			if ( _.isUndefined( vc.row_layout_editor ) ) {
				// vc.row_layout_editor = new vc.RowLayoutEditorPanelViewBackend( { el: $( '#vc_row-layout-panel' ) } );
				vc.row_layout_editor = new vc.RowLayoutUIPanelBackendEditor( { el: $( '#vc_ui-panel-row-layout' ) } );
			}
			return vc.row_layout_editor;
		},
		setColumns: function ( e ) {
			if ( _.isObject( e ) ) {
				e.preventDefault();
			}
			var $button = $( e.currentTarget );
			if ( 'custom' === $button.data( 'cells' ) ) {
				this.layoutEditor().render( this.model ).show();
			} else {
				if ( vc.is_mobile ) {
					var $parent = $button.parent();
					if ( ! $parent.hasClass( 'vc_visible' ) ) {
						$parent.addClass( 'vc_visible' );
						$( document ).bind( 'click.vcRowColumnsControl', function ( e ) {
							$parent.removeClass( 'vc_visible' );
							$( document ).unbind( 'click.vcRowColumnsControl' );
						} );
					}
				}
				if ( ! $button.is( '.vc_active' ) ) {
					this.change_columns_layout = true;
					_.defer( function ( view, cells ) {
						view.convertRowColumns( cells );
					}, this, $button.data( 'cells' ) );
				}
			}
			this.$el.removeClass( 'vc_collapsed-row' );
		},
		sizeRows: function () {
			var max_height = 45;
			$( '> .wpb_vc_column, > .wpb_vc_column_inner', this.$content ).each( function () {
				var content_height = $( this ).find( '> .wpb_element_wrapper > .wpb_column_container' ).css( { minHeight: 0 } ).height();
				if ( content_height > max_height ) {
					max_height = content_height;
				}
			} ).each( function () {
				$( this ).find( '> .wpb_element_wrapper > .wpb_column_container' ).css( { minHeight: max_height } );
			} );
		},
		ready: function ( e ) {
			window.VcRowView.__super__.ready.call( this, e );
			return this;
		},
		checkIsEmpty: function () {
			window.VcRowView.__super__.checkIsEmpty.call( this );
			this.setSorting();
		},
		changedContent: function ( view ) {
			if ( this.change_columns_layout ) {
				return this;
			}
			this.setActiveLayoutButton();
		},
		moveElement: function ( e ) {
			e.preventDefault();
		},
		toggleElement: function ( e ) {
			e && e.preventDefault();
			this.$el.toggleClass( 'vc_collapsed-row' );
		},
		openClosedRow: function ( e ) {
			this.$el.removeClass( 'vc_collapsed-row' );
		}
    });

	
	window.VcIconView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
		 var params = model.get('params');
		 window.VcIconView.__super__.changeShortcodeParams.call(this, model);
		 if (_.isObject(params) && _.isString(params.name)) {
			if(_.isString(params.icon_color)){
					var icon_style = ' color:'+ params.icon_color;
			} else {
					var icon_style = '';
			}
			
			this.$el.find('.wpb_element_wrapper').html('<h4 class="wpb_element_title"><span class="vc_element-icon icon-wpb-vc_icons"></span></h4><i style="font-size:32px;'+ icon_style +'" class="fa ' + params.name + '"></i>');
		 }
	   }
	});	
	
	window.VcCustomServiceView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
		var params = model.get('params');
		window.VcCustomServiceView.__super__.changeShortcodeParams.call(this, model);
		if (_.isObject(params) && _.isString(params.type)) {
			if(_.isString(params.icon_color)){
					var icon_style = ' style="color:'+ params.icon_color + ';"';
			} else {
					var icon_style = '';
			}

			this.$el.find('.wpb_element_wrapper .admin_label_type').after('<div class="icon_name"><i'+ icon_style +' class="service-icon ' + params['icon_' + params.type] + '"></i></div>');
		 }
	   }
	});	

    window.VcButtonView = vc.shortcode_view.extend({events:function () {
        return _.extend({'click button':'buttonClick'
        }, window.VcToggleView.__super__.events);
    },
        buttonClick:function (e) {
            e.preventDefault();
        },
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcButtonView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params)) {

	            var style = '';
	            if ( params.button_style != '' ) {
		            style = ' wpb_btn-minimal';
	            }
                var el_class = 'wpb_' + params.color + ' ' + params.size + style;
                this.$el.find('.wpb_element_wrapper').removeClass(el_class);
                this.$el.find('button.title').attr({ "class":"title textfield wpb_button " + el_class });
				
				if (params.type) {
                    this.$el.find('button.title').append('<i class="' + params['icon_' + params.type] + '"></i>');
                } else {
                    this.$el.find('button.title i').remove();
                }

            }
        }
    });
	
	window.VcTeamView = vc.shortcode_view.extend({
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcTeamView.__super__.changeShortcodeParams.call(this, model);
			if (params.img_url) {
				this.$el.find('.wpb_element_wrapper .img_url').show();
			 } else {
				this.$el.find('.wpb_element_wrapper .img_url').hide();
			 }
        }
    });
	
	window.VcTestimonialSliderView = vc.shortcode_view.extend({
        adding_new_tab:false,
        events:{
            'click .add_tab':'addTab',
            'click > .controls .column_delete':'deleteShortcode',
            'click > .controls .column_edit':'editElement',
            'click > .controls .column_clone':'clone'
        },
        render:function () {
            window.VcTestimonialSliderView.__super__.render.call(this);
            this.$content.sortable({
                axis:"y",
                handle:"h3",
                stop:function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.prev().triggerHandler("focusout");
                    $(this).find('> .wpb_sortable').each(function () {
                        var shortcode = $(this).data('model');
                        shortcode.save({'order':$(this).index()}); // Optimize
                    });
                }
            });
            return this;
        },
        addTab:function (e) {
            this.adding_new_tab = true;
            e.preventDefault();
            vc.shortcodes.create({shortcode:'vc_testimonial', params:{title:window.i18nLocale.section}, parent_id:this.model.id});
        },
        _loadDefaults:function () {
            window.VcTestimonialSliderView.__super__._loadDefaults.call(this);
        }
    });
	   
	window.VcTestimonialView = vc.shortcode_view.extend({
        changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcTestimonialView.__super__.changeShortcodeParams.call(this, model);
            if (!_.isString(params.name)) {
                this.$el.find('h3.name').text('Testimonial');
            }			
        }
    });
	
	window.VcListItemView = vc.shortcode_view.extend({
	   changeShortcodeParams:function (model) {
			var params = model.get('params');
			window.VcListItemView.__super__.changeShortcodeParams.call(this, model);
			if (_.isObject(params) && _.isString(params.icon_name)) {
				if(_.isString(params.icon_color)){
					var icon_style = ' style="color:'+ params.icon_color +'"';
				} else {
					var icon_style = '';
				}
				
				this.$el.find('.icon_name').html('<i class="fa ' + params.icon_name + '"'+ icon_style +'></i>');
			} else {
				this.$el.find('.icon_name').html('<i class="fa fa-check"></i>');
			}
		}
	});	
	
	window.VcTestimonialSliderView = vc.shortcode_view.extend({
        adding_new_tab:false,
        events:{
            'click .add_tab':'addTab',
            'click > .vc_controls .column_delete, > .vc_controls .vc_control-btn-delete':'deleteShortcode',
            'click > .vc_controls .column_edit, > .vc_controls .vc_control-btn-edit':'editElement',
            'click > .vc_controls .column_clone,> .vc_controls .vc_control-btn-clone':'clone'
        },
        render:function () {
            window.VcTestimonialSliderView.__super__.render.call(this);
            this.$content.sortable({
                axis:"y",
                handle:"h3",
                stop:function (event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.prev().triggerHandler("focusout");
                    $(this).find('> .wpb_sortable').each(function () {
                        var shortcode = $(this).data('model');
                        shortcode.save({'order':$(this).index()}); // Optimize
                    });
                }
            });
            return this;
        },
        changeShortcodeParams:function (model) {
            window.VcTestimonialSliderView.__super__.changeShortcodeParams.call(this, model);
            var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
            if (this.$content.hasClass('ui-accordion')) {
                this.$content.accordion("option", "collapsible", collapsible);
            }
        },
        changedContent:function (view) {
            if (this.$content.hasClass('ui-accordion')) this.$content.accordion('destroy');
            var collapsible = _.isString(this.model.get('params').collapsible) && this.model.get('params').collapsible === 'yes' ? true : false;
            this.$content.accordion({
                header:"h3",
                navigation:false,
                autoHeight:true,
                heightStyle: "content",
                collapsible:collapsible,
                active:this.adding_new_tab === false && view.model.get('cloned') !== true ? 0 : view.$el.index()
            });
            this.adding_new_tab = false;
        },
        addTab:function (e) {
            this.adding_new_tab = true;
            e.preventDefault();
            vc.shortcodes.create({shortcode:'vc_testimonial', params:{title:window.i18nLocale.section}, parent_id:this.model.id});
        },
        _loadDefaults:function () {
            window.VcTestimonialSliderView.__super__._loadDefaults.call(this);
        }
    });
	
	
	window.VcPricingView = window.VcColumnView.extend({
        events:{
          'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
          'click > .vc_controls .vc_control-btn-prepend':'addElement',
          'click > .vc_controls .vc_control-btn-edit':'editElement',
          'click > .vc_controls .vc_control-btn-clone':'clone',
          'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
        },
		changeShortcodeParams:function (model) {
            var params = model.get('params');
            window.VcPricingView.__super__.changeShortcodeParams.call(this, model);
            if (_.isObject(params)) {
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'h4.title' ) );
				this.$el.find( '.wpb_column_container' ).before( this.$el.find( 'span.wpb_vc_param_value' ) );
            }			
        }
    });
	
	window.VcTooltipView = window.VcColumnView.extend({
        events:{
          'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
          'click > .vc_controls .vc_control-btn-prepend':'addElement',
          'click > .vc_controls .vc_control-btn-edit':'editElement',
          'click > .vc_controls .vc_control-btn-clone':'clone',
          'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
        }
    });

	window.VcModalView = window.VcColumnView.extend({
		events:{
			'click > .vc_controls .vc_control-btn-delete':'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend':'addElement',
			'click > .vc_controls .vc_control-btn-edit':'editElement',
			'click > .vc_controls .vc_control-btn-clone':'clone',
			'click > .wpb_element_wrapper > .vc_empty-container':'addToEmpty'
		}
	});

	window.VcContentSliderView = vc.shortcode_view.extend( {
		new_tab_adding: false,
		events: {
			'click .add_tab': 'addTab',
			'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
			'click > .vc_controls .vc_control-btn-edit': 'editElement',
			'click > .vc_controls .vc_control-btn-clone': 'clone'
		},
		initialize: function ( params ) {
			window.VcContentSliderView.__super__.initialize.call( this, params );
			_.bindAll( this, 'stopSorting' );
		},
		render: function () {
			window.VcContentSliderView.__super__.render.call( this );
			this.$tabs = this.$el.find( '.wpb_tabs_holder' );
			this.createAddTabButton();
			return this;
		},
		ready: function ( e ) {
			window.VcContentSliderView.__super__.ready.call( this, e );
		},
		createAddTabButton: function () {
			var new_tab_button_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
			this.$tabs.append( '<div id="new-tab-' + new_tab_button_id + '" class="new_element_button"></div>' );
			this.$add_button = $( '<li class="add_tab_block"><a href="#new-tab-' + new_tab_button_id + '" class="add_tab" title="' + window.i18nLocale.add_tab + '"></a></li>' ).appendTo( this.$tabs.find( ".tabs_controls" ) );
		},
		addTab: function ( e ) {
			e.preventDefault();
			// check user role to add controls
			if ( ! this.hasUserAccess() ) {
				return false;
			}
			this.new_tab_adding = true;
			var tab_title = 'Slide',
				tabs_count = this.$tabs.find( '[data-element_type=vc_content_slide]' ).length,
				tab_id = (+ new Date() + '-' + tabs_count + '-' + Math.floor( Math.random() * 11 ));
			vc.shortcodes.create( {
				shortcode: 'vc_content_slide',
				params: { title: tab_title, tab_id: tab_id },
				parent_id: this.model.id
			} );
			return false;
		},
		stopSorting: function ( event, ui ) {
			var shortcode;
			this.$tabs.find( 'ul.tabs_controls li:not(.add_tab_block)' ).each( function ( index ) {
				var href = $( this ).find( 'a' ).attr( 'href' ).replace( "#", "" );
				// $('#' + href).appendTo(this.$tabs);
				shortcode = vc.shortcodes.get( $( '[id=' + $( this ).attr( 'aria-controls' ) + ']' ).data( 'model-id' ) );
				vc.storage.lock();
				shortcode.save( { 'order': $( this ).index() } ); // Optimize
			} );
			shortcode && shortcode.save();
		},
		changedContent: function ( view ) {
			var params = view.model.get( 'params' );
			if ( ! this.$tabs.hasClass( 'ui-tabs' ) ) {
				this.$tabs.tabs( {
					select: function ( event, ui ) {
						return ! $( ui.tab ).hasClass( 'add_tab' );
					}
				} );
				this.$tabs.find( ".ui-tabs-nav" ).prependTo( this.$tabs );
				// check user role to add controls
				if ( this.hasUserAccess() ) {
					this.$tabs.find( ".ui-tabs-nav" ).sortable( {
						axis: (this.$tabs.closest( '[data-element_type]' ).data( 'element_type' ) == 'vc_tour' ? 'y' : 'x'),
						update: this.stopSorting,
						items: "> li:not(.add_tab_block)"
					} );
				}
			}
			if ( view.model.get( 'cloned' ) === true ) {
				var cloned_from = view.model.get( 'cloned_from' ),
					$tab_controls = $( '.tabs_controls > .add_tab_block', this.$content ),
					$new_tab = $( "<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>" ).insertBefore( $tab_controls );
				this.$tabs.tabs( 'refresh' );
				this.$tabs.tabs( "option", 'active', $new_tab.index() );
			} else {
				$( "<li><a href='#tab-" + params.tab_id + "'>" + params.title + "</a></li>" )
					.insertBefore( this.$add_button );
				this.$tabs.tabs( 'refresh' );
				this.$tabs.tabs( "option",
					"active",
					this.new_tab_adding ? $( '.ui-tabs-nav li', this.$content ).length - 2 : 0 );

			}
			this.new_tab_adding = false;
		},
		cloneModel: function ( model, parent_id, save_order ) {
			var new_order,
				model_clone,
				params,
				tag;

			new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
			params = _.extend( {}, model.get( 'params' ) );
			tag = model.get( 'shortcode' );

			if ( tag === 'vc_content_slider' ) {
				_.extend( params,
					{ tab_id: + new Date() + '-' + this.$tabs.find( '[data-element-type=vc_content_slider]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
			}

			model_clone = Shortcodes.create( {
				shortcode: tag,
				id: vc_guid(),
				parent_id: parent_id,
				order: new_order,
				cloned: (tag !== 'vc_content_slider'), // todo review this by @say2me
				cloned_from: model.toJSON(),
				params: params
			} );

			_.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
				this.cloneModel( shortcode, model_clone.get( 'id' ), true );
			}, this );
			return model_clone;
		}
	} );

	window.VcContentSlideView = window.VcColumnView.extend( {
		events: {
			'click > .vc_controls .vc_control-btn-delete': 'deleteShortcode',
			'click > .vc_controls .vc_control-btn-prepend': 'addElement',
			'click > .vc_controls .vc_control-btn-edit': 'editElement',
			'click > .vc_controls .vc_control-btn-clone': 'clone',
			'click > .wpb_element_wrapper > .vc_empty-container': 'addToEmpty'
		},
		render: function () {
			var params = this.model.get( 'params' );
			window.VcContentSlideView.__super__.render.call( this );
			/**
			 * @deprecated 4.4.3
			 * @see composer-atts.js vc.atts.tab_id.addShortcode
			 */
			if ( ! params.tab_id/* || params.tab_id.indexOf('def') != -1*/ ) {
				params.tab_id = (+ new Date() + '-' + Math.floor( Math.random() * 11 ));
				this.model.save( 'params', params );
			}
			this.id = 'tab-' + params.tab_id;
			this.$el.attr( 'id', this.id );
			return this;
		},
		ready: function ( e ) {
			window.VcContentSlideView.__super__.ready.call( this, e );
			this.$tabs = this.$el.closest( '.wpb_tabs_holder' );
			var params = this.model.get( 'params' );
			return this;
		},
		changeShortcodeParams: function ( model ) {
			var params;

			window.VcContentSlideView.__super__.changeShortcodeParams.call( this, model );
			params = model.get( 'params' );
			if ( _.isObject( params ) && _.isString( params.title ) && _.isString( params.tab_id ) ) {
				$( '.ui-tabs-nav [href="#tab-' + params.tab_id + '"]' ).text( params.title );
			}
		},
		deleteShortcode: function ( e ) {
			_.isObject( e ) && e.preventDefault();
			var answer = confirm( window.i18nLocale.press_ok_to_delete_section ),
				parent_id = this.model.get( 'parent_id' );
			if ( answer !== true ) {
				return false;
			}
			this.model.destroy();
			if ( ! vc.shortcodes.where( { parent_id: parent_id } ).length ) {
				var parent = vc.shortcodes.get( parent_id );
				parent.destroy();
				return false;
			}
			var params = this.model.get( 'params' ),
				current_tab_index = $( '[href=#tab-' + params.tab_id + ']', this.$tabs ).parent().index();
			$( '[href=#tab-' + params.tab_id + ']' ).parent().remove();
			var tab_length = this.$tabs.find( '.ui-tabs-nav li:not(.add_tab_block)' ).length;
			if ( tab_length > 0 ) {
				this.$tabs.tabs( 'refresh' );
			}
			if ( current_tab_index < tab_length ) {
				this.$tabs.tabs( "option", "active", current_tab_index );
			} else if ( tab_length > 0 ) {
				this.$tabs.tabs( "option", "active", tab_length - 1 );
			}

		},
		cloneModel: function ( model, parent_id, save_order ) {
			var new_order,
				model_clone,
				params,
				tag;

			new_order = _.isBoolean( save_order ) && save_order === true ? model.get( 'order' ) : parseFloat( model.get( 'order' ) ) + vc.clone_index;
			params = _.extend( {}, model.get( 'params' ) );
			tag = model.get( 'shortcode' );

			if ( tag === 'vc_content_slide' ) {
				_.extend( params,
					{ tab_id: + new Date() + '-' + this.$tabs.find( '[data-element_type=vc_content_slide]' ).length + '-' + Math.floor( Math.random() * 11 ) } );
			}

			model_clone = Shortcodes.create( {
				shortcode: tag,
				parent_id: parent_id,
				order: new_order,
				cloned: true,
				cloned_from: model.toJSON(),
				params: params
			} );

			_.each( Shortcodes.where( { parent_id: model.id } ), function ( shortcode ) {
				this.cloneModel( shortcode, model_clone.get( 'id' ), true );
			}, this );
			return model_clone;
		}
	} );


})(window.jQuery);