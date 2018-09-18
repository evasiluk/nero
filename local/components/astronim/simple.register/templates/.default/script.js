$(document).ready(function() {
    $("#simple_register").ajaxForm({
        beforeSubmit: function (formData, jqForm, options) {
        },
        success: function (responseText, statusText, xhr, $_form) {

            if (responseText) {
                var $response = $(responseText);

                var headerHeight = 0 - parseInt($('.l-header').height()) - 20;

                if (($response.find('.js-form-error-template').length > 0) && ($response.find('.js-form-error-template').text().trim().length > 0)) {

                    $("#ajax_result").html($response.find('.js-form-error-template').html().trim()).show();

                    $.scrollTo($("#ajax_result"), 700, {
                        easing: 'easeInOutCubic',
                        offset: headerHeight
                    });

                } else{
                    window.location.reload();
                }
                if('function' === typeof grecaptcha.reset) grecaptcha.reset();

            }
        }
    });




    function scrollToAlt($element) {
        if ($element.length > 0)
            $('html, body').animate({
                scrollTop: ($element.offset().top - $('.header').height())
            }, 500);
    }
})