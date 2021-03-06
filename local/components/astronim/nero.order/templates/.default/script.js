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

    var $locSelWrap = $('.js-loc-sel-wrap');

    $(".js-loc-edit").on('click', function() {
    	event.preventDefault();
    	$locSelWrap.slideDown();
    });

    $(".js-loc-save").on('click', function(event) {
    	event.preventDefault();
        var loc = $("input[name=LOCATION]").val();
        window.location = '?setLocation=' + loc;
    });
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

	var $phoneInput = $form.find('input[type="tel"]');

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

	(function maskPhone() {
		if (!$phoneInput || !Inputmask || !Portal.region) return false;

		var region = Portal.region;

		switch(region) {
			case 'by':
				mask = {'mask': '+375 (99) 999-99-99'};
				break;

			case 'ru':
				mask = {'mask': '+7 (999) 999-99-99'};
				break;

			case 'ua':
				mask = {'mask': '+380 (99) 999-99-99'};
				break;

			default:
				mask = 'remove';
		}

		$phoneInput.inputmask(mask);
	})();

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





                var dealer = $("#isdeal").val();

//                if(dealer == "Y") {
                // сказали уведомлять менеджеров для всех пользователей
                if(true) {
                    var pcode = $("#pcode").val();
                    var delivery_name = $("#result_delivery_name").text();

                    var delivery_price = $("#result_delivery_price").text();
                    if(delivery_price != "бесплатно") {
                        delivery_price += " " + $("#result_delivery_valute").text();
                    }

                    console.log(delivery_price);


                    $.post("/local/ajax/managerNotify.php", {order : data.order_id, pcode : pcode, delivery_price : delivery_price, delivery_name : delivery_name}, function(data) {
                        console.log(data);
                    });
                }

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