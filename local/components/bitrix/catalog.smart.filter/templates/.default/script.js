$(document).ready(function() {

    filterConfig();

});


function filterConfig() {

    if ($('#config-head').length > 0) {
        configBounds();
    }

    var toggle = $('.js-filter-toggle'),
        body   = $('body'),
        head   = $('#config-head'),
        page   = $('.page-wrap'),
        footer = $('.l-footer'),
        filter = $('.js-filter'),
        reset  = $('.js-filter-reset'),
        filterFull = $('.js-filter-full'),
        filterVisible = false;

    var categRoot = false;
    var tempRoot = false;

    var imba = ($('#without_types_filter').length > 0);

    var filterViewType = $('.js-filter-view-type');

    var $sort_link = $('.filter-sort .submenu a');
    var $sort_name  = $('#sort_name');
    var $sort_order = $('#sort_order');

    var $ajaxContainer = $('.js-ajax-content');
    var isTypeSelected = false;

    var $errorTemplate = '<div class="catalog-error"><h4>По вашему запросу ничего не найдено.</h4></div>';

    var isStuck = filter.hasClass('.js-is-stuck');

    var hideFilter = function() {
        body
            .removeClass('filter-is-visible')
            .removeAttr('style');

        page.removeAttr('style');

        footer.removeAttr('style');

        filterFull.hide(0);

        toggle.removeClass('active');

        filterVisible = false;
    }

    if (document.querySelector('[data-select-type]') !== null) {
        var selectType = new Choices('[data-select-type]', {
            placeholder: false,
            placeholderValue: null,
            searchPlaceholderValue: null,
            searchEnabled: false,
            shouldSort: false,
            shouldSortItems: false,
            itemSelectText: '',

            callbackOnInit: function(event) {
                isTypeSelected = (this.getValue(true) === 'all')? false : true;
                categRoot = isTypeSelected;
            }
        });

        selectType.passedElement.addEventListener('change', function(event) {
            if (event.detail.value === 'all') {
                isTypeSelected = false;
            } else {
                isTypeSelected = true;
                setFilterView(event.detail.value);
            }

            filterReset(false);

        }, false);
    }

    function setToggleVisibility(visible) {
        if (visible) {
            toggle.removeAttr('disabled');
        } else {
            toggle.attr('disabled', 'disabled');
            hideFilterView();
        }
    }

    if (imba) {
        setToggleVisibility(imba);
    } else {
        setToggleVisibility(isTypeSelected);
    }

    

    function setFilterView(type) {
        $('.js-filter-view-type[data-for="'+ type +'"]').show().siblings().hide();
    }

    function hideFilterView() {
        filterViewType.hide();
        hideFilter();
    }

    if (document.querySelector('[data-select-line]') !== null) {
        var selectLine = new Choices('[data-select-line]', {
            placeholder: false,
            placeholderValue: null,
            searchPlaceholderValue: null,
            searchEnabled: false,
            shouldSort: false,
            shouldSortItems: false,
            itemSelectText: '',

            callbackOnInit: function() {
            }
        });
    }

    if (document.querySelector('[data-filter-full-select]') !== null) {
        var filterChoices = new Choices('[data-filter-full-select]', {
            placeholder: false,
            placeholderValue: null,
            searchPlaceholderValue: null,
            searchEnabled: false,
            shouldSort: false,
            shouldSortItems: false,
            itemSelectText: '',

            callbackOnInit: function() {
                console.log('data-filter-full-select');
            }
        });
    }

    toggle.on('click', function(event){
        event.preventDefault();

        if (!filterVisible) {

            body
                .addClass('filter-is-visible')
                .css({
                    'overflow': 'hidden!important',
                    'height': 'calc(100vh + ' + scrolltop + 'px)'
                });

            page.css({
                'padding-right':  scrollWidth + 'px'
            });

            footer.css({
                'padding-right':  scrollWidth + 'px'
            });

            filterFull.show(0);

            if (!isStuck) {
                $.scrollTo(filter, 700);
            }

            configBounds();

            toggle.addClass('active');

            filterVisible = true;

        } else {
            hideFilter();
        }
    });

    function setHtmlContent(data) {
        $ajaxContainer.html(data);
    }

    filter.on("change", function() {
        var query = "?set_filter=Y";
        var newContent = '.js-ajax-content';
        var sort_name  = $sort_name.val();
        var sort_order = $sort_order.val();

        var checkboxes = $(this).find("input[type=checkbox]:checked");
        var selects = $(this).find('select :selected');

        console.log(typeof isTypeSelected);

        setToggleVisibility(isTypeSelected);

        if(checkboxes) {
            for(var i = 0; i < checkboxes.length; i++) {
                query += "&"+checkboxes.eq(i).val()+"=Y";
            }
        }

        if(selects) {
            for(var i = 0; i < selects.length; i++) {
                if(selects.eq(i).val() != "all") {
                    query += "&"+selects.eq(i).val()+"=Y";
                }
            }
        }

        if (sort_name && sort_order) {
            query += "&sort=" + sort_name + "&order=" + sort_order;
        }

        $.post(query, {}, function(data) {
            if(data) {
                var $response = $(data).find(newContent).html();
                if ($response.length > 10) {
                    setHtmlContent($response);
                    producsList();
                } else {
                    setHtmlContent($errorTemplate);
                }
            } else {
                setHtmlContent($errorTemplate);
            }
        });
    });

    $sort_link.on('click', function(event) {
        event.preventDefault();
        filterSort(this);
    });

    reset.on('click', function(event) {
        event.preventDefault();
        filterReset(true);
    });

    function filterSort(el) {
        var $el = $(el);
        $sort_name.val($el.data('sort'));
        $sort_order.val($el.data('order'));
        filter.trigger('change');
    }

    function filterReset(forced) {
        $('.js-filter').trigger('reset');
        if (forced && categRoot()) selectType.setValueByChoice('all');
        if (selectLine) selectLine.setValueByChoice('all');
        if (filterChoices) filterChoices.setValueByChoice('all');
        filter.trigger('change');
    }

    function configBounds() {

        var head = document.getElementById('config-head'),
            main = document.getElementById('config-main'),
            foot = document.getElementById('config-foot');

        var delta = parseInt(head.offsetHeight + foot.offsetHeight);

        main.style.maxHeight = 'calc(100vh - ' + delta + 'px)';

        if (filterVisible) {
            $.scrollTo($('.js-filter'), 0);
        }
    }

    function configResizeHandler() {
        configBounds();
    }

    $(window).resize(function() {
        configBounds();
    });

    if (desktop === false) {
        window.addEventListener('orientationchange', function() {
            configBounds();
        });
    }

}
