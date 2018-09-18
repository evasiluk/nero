$(document).ready(function() {
    $("#simple_register").ajaxForm({
        beforeSubmit: function (formData, jqForm, options) {
        },
        success: function (responseText, statusText, xhr, $_form) {

            if (responseText) {
                var $response = $(responseText);

                if (($response.find('.errors').length > 0) && ($response.find('.errors').text().trim().length > 0)) {

                    $("#ajax_result").html($response.find('.errors').text().trim());
                    scrollToAlt($("#ajax_result"));
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
                scrollTop: ($element.offset().top - $('header').height())
            }, 2000);
    }
})