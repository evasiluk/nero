$(document).ready(function() {
    $("#make-order").on('click', function(e) {
        var message = $("#order-message").val();
        e.preventDefault();
        $.post("/local/ajax/order.php", {message : message}, function(data) {
            console.log(data);
            if (!isNaN(parseFloat(data)) && isFinite(data)) {
                $("#basket-items-list-container").html("<div class='warning-success'><p>Спасибо, Ваш заказ принят!</p><p>Номер заказа - "+data+"</p></div>");
            } else {
                $("#basket-items-list-container").html("<div class='warning-error'><p>При формировании заказа произошла ошибка. </p><p>Приносим свои извинения.</p></div>");
            }

        })
    })

})
