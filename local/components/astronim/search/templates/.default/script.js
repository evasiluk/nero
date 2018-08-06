$(document).ready(function () {
    $.getScript("https://malsup.github.io/min/jquery.form.min.js", function () {
        var form = '.js-search-form',
            input = '.js-search-form__input',
            counter = '.js-search-results__count',
            results_list = '.js-search-results__list';

        $(form).ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
                $(input).prop('disabled', true);
            },
            success: function (responseText, statusText, xhr, $_form) {
                $(input).prop('disabled', false);

                if (responseText) {
                    var $response = $(responseText);
                    $(counter).html($($response.find(counter).html()));
                    $(results_list).html($($response.find(results_list).html()));
                }
            }
        });

        var timeout_id = false;
        $(input).on('input', function (e) {
            e.preventDefault();
            var $this = $(this);

            if(timeout_id)
                clearTimeout(timeout_id);

            timeout_id = setTimeout(function () {
                if ($this.val().length > 2) {
                    $this.closest(form).submit();
                }
            }, '1000');
        })
    });
});