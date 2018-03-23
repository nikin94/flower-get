$('td.td-date_departure, td.date_payment').each(function () {
    if ($(this).text() === '00-00-0000 00:00') {
        $(this).text('');
    }
});


$('#order-list td.remove-order').on('click', function () {/*confirm и удаление заказа*/
    var thisTR = $(this).parent();
    var thisID = thisTR.find("td:first-child").text();
    var delete_result = confirm("Удалить заказ?");
    if (delete_result) {
        $.ajax({
            url: 'order-remove.php?id=' + thisID,
            success: function () {
                thisTR.fadeOut(700);
            }
        });
    }
});

$('#order-add table tr td #payment').click(function () {/*открытие текущей даты оплаты заказа и скрытие по значению чекбокса*/
    if (this.checked) {
        var date = new Date();
        var dateVaules = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + 'T' + date.getHours() + ':' + date.getMinutes();
        $('#order-add table tr.date_payment input#date_payment').val(dateVaules);
        $('#order-add table tr.date_payment').fadeIn(400);

    } else {
        $('#order-add table tr.date_payment').fadeOut(400);
    }
});

$('#order-add input#price_flowers, #order-add input#price_delivery').keyup(function () {/*суммируем стоимость в форме*/
    var price_flowers = $('#order-add input#price_flowers').val();
    var price_delivery = $('#order-add input#price_delivery').val();
    $('#order-add input#price_summary').val(+price_flowers + (+price_delivery));
});

$('#order-list img.payment-img').on('click', function () {/*Оплата заказа - замена картинки по клику, отправка времени оплаты, замена значения в ячейке*/
    var _this = $(this);
    var thisID = _this.parent().parent().find('td:first-child').text();
    var date = new Date();
    var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + date.getHours() + ':' + date.getMinutes() + ':' + date.getSeconds();
    var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
    if ($(this).hasClass('payment-img-no')) {
        $.post('order-update.php', {
            'id': thisID,
            'payment': 1,
            'date_payment': dateValuesSQL
        }).done(function () {
            _this.removeClass('payment-img-no').addClass('payment-img-yes').attr('src', "assets/img/yes.png");
            _this.parent().next().html(dateValuesNormal);
        });
    } else if ($(this).hasClass('payment-img-yes') && confirm('Отметить заказ, как НЕоплаченный?')) {
        $.post('order-update.php', {
            'id': thisID,
            'payment': 0,
            'date_payment': null
        }).done(function (result) {
            _this.removeClass('payment-img-yes').addClass('payment-img-no').attr('src', "assets/img/no.png");
            _this.parent().next().html('');
        });
    }
});

$('#order-list img.send-img, #order-list span.send-text').on('click', function () {/*Добавляем время отправки заказа вместо кнопки*/
    var _this = $(this);
    var thisID = _this.parent().parent().find('td:first-child').text();
    var date = new Date();
    var hours = date.getHours() < 10 ? '0'+date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes();
    var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + hours + ':' + minutes + ':' + date.getSeconds();
    var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + hours + ':' + minutes;
    $.post('order-update.php',{
        'id': thisID,
        'date_departure': dateValuesSQL
    }).done(function (result) {
        _this.parent().html(dateValuesNormal);
    });
});