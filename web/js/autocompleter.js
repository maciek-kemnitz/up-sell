/*global $, window, ADMIN*/

(function() {
    var AUTOCOMPLETER = {
        variables: {
            inputTimer: null,
            blurLag: 200,
            typeExcludedKeys: ADMIN.MAIN.variables.typeExcludedKeys.concat(13)
        },

        blurHandler: function(e) {
            var $input = $(e.target),
                $list = $('#' + $input.data('list-id')),
                self = this,
                persist = $input.is('[data-persist="true"]');

            setTimeout(function() {
                $list.children().filter(':not(.template)').remove();

                if (!persist) {
                    $input.val('');
                }

                self.toggleList.call($list);
            }, this.variables.blurLag);

            return false;
        },

        focusHandler: function(e) {
            var $input = $(e.target),
                $list = $('#' + $input.data('list-id'));

            $list.trigger('update');

            return false;
        },

        keyupHandler: function(e) {
            var $input = $(e.target),
                $list = $('#' + $input.data('list-id')),
                $clear = $input.next('.clear-autocompleter'),
                persist = $input.is('[data-persist="true"]'),
                keyCode = e.keyCode,
                focusIndex = $list.children('.focus').index(),
                event = $.Event('blur', {
                    target: $input
                });

            if (keyCode === 8 && persist && $clear.is(':visible')) {
                $clear.trigger('click');

                return false;
            }

            if (keyCode === 27) {
                this.blurHandler.call(this, event);

                return false;
            }

            if (focusIndex < 0) {
                focusIndex = 0;
            }

            if ($.inArray(keyCode, this.variables.typeExcludedKeys) === -1) {
                clearTimeout(this.variables.inputTimer);

                this.variables.inputTimer = setTimeout(function() {
                    $list.trigger('update');
                }, ADMIN.MAIN.variables.searchInputLag);
            }

            switch (keyCode) {
                case 13: e.preventDefault();
                         this.chooseItem.call($list);

                         break;

                case 38: --focusIndex;

                         $list.children('.focus').removeClass('focus');
                         $list.children().eq(focusIndex).addClass('focus');

                         break;

                case 40: ++focusIndex;

                         $list.children('.focus').removeClass('focus');
                         $list.children().eq(focusIndex).addClass('focus');

                         break;

                default: break;
            }

            return false;
        },

        chooseItem: function() {
            var $list = $(this),
                $input = $('[data-list-id="' + $list.attr('id') + '"]'),
                $item = $list.children('.focus'),
                unique = $input.is('[data-unique="true"]'),
                persist = $input.is('[data-persist="true"]'),
                id = $item.attr('data-id'),
                chosenItems = $list.data('chosen-items'),
                value = $.trim($list.children('.focus').find('.name').text());

            if (typeof(chosenItems) === 'undefined') {
                $list.data('chosen-items', []);

                chosenItems = $list.data('chosen-items');
            }

            if ($item.length) {
                if ((unique && $.inArray(parseInt(id, 10), chosenItems) === -1) || !unique) {
                    $item.addClass('chosen');
                    $list.data('chosen-items', chosenItems.concat($item.data('id')));
                    $list.trigger('item-chosen', $list.children('.focus'));
                    $input.trigger('blur');

                    if (persist) {
                        $input.trigger('set-value', value);
                    }
                }
            }

            return false;
        },

        addChosen: function(e, id) {
            var $list = $(this),
                $input = $('[data-list-id="' + $list.attr('id') + '"]'),
                unique = $input.is('[data-unique="true"]'),
                chosenItems = $list.data('chosen-items'),
                id = parseInt(id, 10);

            if (typeof(chosenItems) === 'undefined') {
                $list.data('chosen-items', []);

                chosenItems = $list.data('chosen-items');
            }

            if (typeof(id) !== 'undefined') {
                if ((unique && $.inArray(id, chosenItems) === -1) || !unique) {
                    $list.data('chosen-items', chosenItems.concat(id));
                }
            }

            return false;
        },

        deleteChosen: function(e, id) {
            var $list = $(this),
                chosenItems = $list.data('chosen-items'),
                id = parseInt(id, 10),
                index = null;

            if (typeof(chosenItems) !== 'undefined' && typeof(id) !== 'undefined') {
                index = chosenItems.indexOf(id);

                if (index !== -1) {
                    chosenItems.splice(index, 1);
                    $list.data('chosen-items', chosenItems);
                }
            }

            return false;
        },

        toggleList: function() {
            var $list = $(this),
                $input = $('[data-list-id="' + $list.attr('id') + '"]'),
                $scroll = $list.parent(),
                $autocompleter = $list.parents('.autocompleter:first');

            if ($list.children().filter(':not(.template)').length) {
                $scroll.removeClass('hide');
                $autocompleter.addClass('show-list');
                $list.renderScroll().slimScroll({
                    scrollTo: 0
                });
            }
            else {
                $input.attr('data-offset', 0);
                $scroll.addClass('hide');
                $autocompleter.removeClass('show-list');
            }

            return false;
        },

        loadMoreHandler: function(e) {
            var $list = $(e.target),
                $input = $('[data-list-id="' + $list.attr('id') + '"]'),
                offset = parseInt($input.attr('data-offset'), 10),
                limit = parseInt($input.attr('data-limit'), 10);

            $input.attr('data-offset', (offset + limit));
            $list.trigger('update', true);

            return false;
        },

        listUpdateHandler: function(e, append) {
            var $list = $(this),
                $input = $('[data-list-id="' + $list.attr('id') + '"]'),
                self = ADMIN.AUTOCOMPLETER,
                unique = $input.is('[data-unique="true"]'),
                that = this,
                ajaxUrl = $input.attr('data-ajax-url'),
                value = $.trim($input.val()),
                offset = parseInt($input.attr('data-offset'), 10),
                limit = parseInt($input.data('limit'), 10),
                chosenItems = $list.data('chosen-items');

            $.ajax({
                dataType: 'json',
                url: ajaxUrl + value,
                context: $input,
                data: {
                    offset: offset,
                    limit: limit
                }
            }).done(function(json) {
                var scrollOffset = 0,
                    items = null;

                $input.attr('data-offset', ++offset);

                if (typeof(append) === 'undefined' || append === false) {
                    $list.children().filter(':not(.template)').remove();
                }

                if (typeof(append) !== 'undefined' && append) {
                    scrollOffset = $list.data('scroll-offset');
                }

                if (typeof (json.products) !== 'undefined') {
                    items = json.products;
                }

                if (typeof (json.categories) !== 'undefined') {
                    items = json.categories;
                }

                if (typeof (json.collections) !== 'undefined') {
                    items = json.collections;
                }

                if (typeof (json.vendors) !== 'undefined') {
                    items = json.vendors;
                }

                if (typeof (json.pages) !== 'undefined') {
                    items = json.pages;
                }

                for (var i = 0; i < items.length; i++) {
                    var $liClone = $list.children().filter('.template').clone().removeClass('template'),
                        product = items[i];

                    /*if (unique) {
                        if ($.inArray(parseInt(product.id, 10), chosenItems) === -1) {
                            $liClone = self.parseTemplate.call($liClone, product);

                            $list.append($liClone);
                        }
                    }
                    else {*/
                        $liClone = self.parseTemplate.call($liClone, product);

                        if ($.inArray(parseInt(product.id, 10), chosenItems) !== -1) {
                            $liClone = $liClone.addClass('chosen');
                        }

                        $list.append($liClone);
                    //}
                }

                //$list.children().filter(':not(.template)').first().addClass('focus');

                self.toggleList.call(that);

                $list.slimScroll({
                    scrollTo: scrollOffset
                });
            });

            return false;
        },

        parseTemplate: function(fields) {
            var template = $('<div>').append($(this).clone()).html();

            for (var key in fields) {
                var regex = new RegExp('{{' + key + '}}', 'g');

                template = template.replace(regex, fields[key]);
            }

            return $(template);
        },

        clickHandler: function(e) {
            var $li = $(e.target),
                $list = null;

            if (!$li.is('li.item')) {
                $li = $li.parents('li.item');
            }

            $list = $li.parent();

            this.chooseItem.call($list);

            return false;
        },

        mouseHandler: function(e) {
            var $li = $(e.target),
                $list = $li.parent();

            if (!$li.is('li.item')) {
                $li = $li.parents('li.item');
            }

            $list.children('.focus').removeClass('focus');

            if (e.type === 'mouseenter') {
                $li.addClass('focus');
            }
            else {
                $li.removeClass('focus');
            }

            return false;
        },

        scrollHandler: function(e, data) {
            var $list = $(e.target),
                liHeight = $list.children(':not(.template)').first().outerHeight(),
                listHeight = $list.outerHeight(),
                listOriginalHeight = $list.children().filter(':not(.template)').length * liHeight,
                loadThreshold = data.offset + listHeight + 10;

            if (loadThreshold >= listOriginalHeight && data.direction === 'down') {
                $list.trigger('load-more');
            }
        },

        setValue: function(e, value) {
            var $input = $(e.target),
                $clear = $input.next('.clear-autocompleter');

            $input.val(value).disable();
            $clear.removeClass('hide');

            return false;
        },

        clearClickHandler: function(e, programmatically) {
            var $button = $(e.target),
                $autocompleter = $button.parents('.autocompleter:first'),
                $input = $autocompleter.find('input[data-autocompleter="true"]');

            $button.addClass('hide');
            $input.val('').enable();

            if (typeof(programmatically) && !programmatically) {
                $input.trigger('focus');
            }

            return false;
        },

        init: function() {
            this.$list = $('.autocompleter-list');

            return false;
        },

        run: function() {
            ADMIN.MAIN.$body.on('blur', 'input[data-autocompleter="true"]', this.blurHandler.bind(this))
                            .on('click', '.autocompleter-list > li', this.clickHandler.bind(this))
                            .on('click', 'input[data-autocompleter="true"] + .clear-autocompleter', this.clearClickHandler.bind(this))
                            .on('focus', 'input[data-autocompleter="true"]', this.focusHandler.bind(this))
                            .on('keyup', 'input[data-autocompleter="true"]', this.keyupHandler.bind(this))
                            .on('mouseenter mouseleave', '.autocompleter-list > li', this.mouseHandler)
                            .on('set-value', 'input[data-autocompleter="true"]', this.setValue.bind(this))
                            .on('update', '.autocompleter-list', this.listUpdateHandler);

            this.$list.on('add-chosen', this.addChosen)
                      .on('delete-chosen', this.deleteChosen)
                      .on('load-more', this.loadMoreHandler)
                      .on('slimscrolling', this.scrollHandler);

            return false;
        }
    };

    ADMIN.registerComponent('AUTOCOMPLETER', AUTOCOMPLETER);
}());