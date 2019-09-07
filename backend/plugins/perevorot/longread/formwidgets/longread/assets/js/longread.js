/*
 * Field longread plugin
 *
 * Data attributes:
 * - data-control="fieldlongread" - enables the plugin on an element
 * - data-option="value" - an option with a value
 *
 * JavaScript API:
 * $('a#someElement').fieldlongread({ option: 'value' })
 *
 * Dependences:
 * - Some other plugin (filename.js)
 */

+function ($) { "use strict";

    // FIELD longread CLASS DEFINITION
    // ============================

    var longread = function(element, options) {
        this.options   = options
        this.$el       = $(element)
        this.inited    = false
        this.iframe    = this.$el.closest('.form-group').find('.editor-preview iframe')
        this.editor    = this.$el.closest('.form-group').find('.editor-write');

        // Init
        this.init()
    }

    longread.DEFAULTS = {
        option: 'default'
    }

    longread.prototype.init = function() {
        this.bindSorting()

        if(this.options.publicUrl){
            this.liveUpdate();
            this.editor.trigger('keyup');
        }

        this.inited=true;
    }

    longread.prototype.bindSorting = function() {

        var sortableOptions = {
            // useAnimation: true,
            handle: '.longread-item-handle',
            nested: false
        }

        $('ul.field-longread-items', this.$el).sortable(sortableOptions)

        $('ul.field-longread-items .move-up', this.$el).click(function(e){
            e.preventDefault();

            var current=$(this).closest('.field-longread-item');

            if(current.index()!=0){
                current.insertBefore(current.prev());
            }
        });

        $('ul.field-longread-items .move-down', this.$el).click(function(e){
            e.preventDefault();

            var current=$(this).closest('.field-longread-item');

            if(current.index()<$('ul.field-longread-items .move-down', this.$el).length-1){
                current.insertAfter(current.next());
            }
        });
    }

    longread.prototype.liveUpdate = function() {
        var timeout,
            self=this;

        $('.editor-write').on('keyup mouseup', function(e){
            clearTimeout(timeout);
            var inp = String.fromCharCode(e.keyCode);

            //if (e.type!='keyup' || /[a-zA-Z0-9-_ ]/.test(inp)) {
                timeout=setTimeout(function(){
                    if(self.$el.is(':visible') && self.inited){
                        self.$el.request(self.options.refreshHandler, {
                            success: function(data) {
                                self.iframe.attr('src', self.options.publicUrl);
                            }
                        }).done(function() {

                        })
                    }
                }, 300);
            //}
        });
    }

    longread.prototype.unbind = function() {
        this.$el.find('ul.field-longread-items').sortable('destroy')
        this.$el.removeData('oc.longread')
    }

    // FIELD longread PLUGIN DEFINITION
    // ============================

    var old = $.fn.fieldlongread

    $.fn.fieldlongread = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this   = $(this)
            var data    = $this.data('oc.longread')
            var options = $.extend({}, longread.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('oc.longread', (data = new longread(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.fieldlongread.Constructor = longread

    // FIELD longread NO CONFLICT
    // =================

    $.fn.fieldlongread.noConflict = function () {
        $.fn.fieldlongread = old
        return this
    }

    // FIELD longread DATA-API
    // ===============

    $(document).render(function() {
        $('[data-control="fieldlongread"]').fieldlongread()
    });

    $(document).ready(function() {
        var field=$('[data-field-name="longread"]');

        field.closest('.tab-pane').removeClass('padded-pane');
        field.find('.form-tabless-fields').removeClass('form-tabless-fields');

        var switcher=$('[toggle-top-panel]');

        switcher.click(function(){
            $('#Form-outsideTabs').toggle();

            switcher.find('i').toggleClass('icon-chevron-down');
            switcher.find('i').toggleClass('icon-chevron-up');
        });

        $("[longread-nav]").sticky({
            topSpacing: 0,
            zIndex: 1000,
            getWidthFrom: '#Form'
        });
    });


}(window.jQuery);
