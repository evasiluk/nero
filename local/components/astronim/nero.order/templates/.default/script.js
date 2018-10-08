$(document).ready(function() {
	jsChekout();

    $("#delivery_type input[type=radio]").on('change', function() {
        var price = $(this).attr("data-price");
        var title = $(this).attr("data-title");



        $("#result_delivery_name").text(title);

        if(isNaN(price)) {
            $("#result_delivery_price").text(price);
            $("#result_delivery_valute").hide();
        } else {
            if(price == 0) {
                $("#result_delivery_price").text("бесплатно");
                $("#result_delivery_valute").hide();
            } else {
                $("#result_delivery_price").text(price);
                $("#result_delivery_valute").show();
            }
        }
        calc_final_price();
    });


    $("#payment_type input[type=radio]").on('change', function() {

        var title = $(this).attr("data-title");

        $("#result_payment_name").text(title);
    })

    function calc_final_price() {
        var items_price = $("#items_price").text();
        var discount = $("#discount").text();
        var delivery_price = $("#result_delivery_price").text();

        var result = items_price;
        if(!isNaN(discount)) {
            result = +result - +discount;
        }

        if(!isNaN(delivery_price)) {
            result = +result + +delivery_price;
        }

        $("#final_price").text(result.toFixed(2));
    }
});

function jsChekout() {

	var $wrap    = $('.form-wrap'),
		$loading = $wrap.find('.js-form-loading'),
		$form    = $wrap.find('.js-checkout'),
		$success = $wrap.find('.js-form-success'),
		$error   = $wrap.find('.js-form-error');

	var $checkoutSection = $('.form-checkout-section');

	var $section = $('.form-step'),
		$submitButton = $form.find('input[type="submit"]');

	var offset = $('.l-header').height() + 80;

	$form.find('input').parsley({
		trigger: 'keypress',
		errorClass: 'input--error',
		successClass: 'input--success',
		errorsWrapper: '<span class="input-note-error"></span>',
		errorTemplate: '<span></span>'
	});

	$.each($checkoutSection, function(index, val) {
		checkoutSectionGroupToggle(val);
	});

	function checkoutSectionGroupToggle(val) {
		var $box = $(val);
		var $radioBlock = $box.find('.js-delivery');
		var $detailsAll = $radioBlock.find('.js-delivery-details');

		$.each($radioBlock, function(index, val) {
			var $radioBlock = $(val);
			var $radio = $radioBlock.find('.js-delivery-radio');
			var $details = $radioBlock.find('.js-delivery-details');

			$radio.on('input', function(event) {
				event.preventDefault();
				$detailsAll.slideUp();
				$details.slideDown();
			});
		});
	}

	$section.addClass('current').slideDown('300');

	$submitButton.on('click', function(event) {
		event.preventDefault();

		$form.parsley().validate();

		var $error = $('.input-note-error.filled:visible');

		var isValid = ($error.length === 0);

		if (isValid) {
			$form.trigger('submit');
		} else {
			$.scrollTo($error, 500, {offset: -offset});
		}
	});

	$form.ajaxForm({
		beforeSubmit: function (formData, jqForm, options) {
			console.log(formData);
			return true;
		},
		success: function (responseText, statusText, xhr, $_form) {
            console.log(responseText);
            var data = $.parseJSON(responseText);

            if(data.status == "ok" && !isNaN(data.order_id)) {
                $("#res").find("h3").text("Ваш заказ №" + data.order_id + " успешно оформлен");
                $("#res").show();
                $(".form-step").remove();
                $('html, body').animate({scrollTop: 0},500);
            }



//			if (stateIsSuccess) {
//				$form.slideUp('300');
//				$success.slideDown('300');
//			} else {
//				$error.slideDown('300');
//			}
		}
	});

	$success.hide();
	$error.hide();
	$loading.hide();
	$form.show();
}