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
$('#order-add input#price_summary').keyup(function () {
    var price_flowers = $('#order-add input#price_flowers');
    var price_delivery = $('#order-add input#price_delivery');
    var price_summary = $('#order-add input#price_summary');
    if(price_summary.val() - price_delivery.val() > 0){
        price_flowers.val(+price_summary.val() - +price_delivery.val());
    }else{
        price_flowers.val(0);
    }
});

$('body').on('click', '#order-list img.payment-img', function () {/*КНОПКА ОПЛАТЫ*/
    var _this = $(this).closest('td.td-payment');
    var thisID = _this.closest('tr').find('td:first-child').text();
    var date = new Date();
    var hours = date.getHours() < 10 ? '0'+date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds();
    var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + hours + ':' + minutes + ':' + seconds;
    var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
    if (_this.find('img.payment-img').hasClass('payment-img-no')) {
        $.post('order-update.php', {
            'id': thisID,
            'payment': 1,
            'date_payment': dateValuesSQL
        }).done(function () {
            _this.html('<div class="tooltip"><img class="payment-img payment-img-yes" src="assets/img/yes.png"><span class="tooltiptext">'+dateValuesNormal+'</span></div>');
        });
    } else if (_this.find('img.payment-img').hasClass('payment-img-yes') && confirm('Отметить заказ, как НЕ оплаченный?')) {
        $.post('order-update.php', {
            'id': thisID,
            'payment': 0,
            'date_payment': null
        }).done(function (result) {
            _this.html('<img class="payment-img payment-img-no" src="assets/img/no.png">');
        });
    }
});

$('body').on('click', '#order-list .td-date_departure .send-YES, #order-list .td-date_departure .send-NO', function () {/*КНОПКА ОТПРАВКИ*/
    var _this = $(this);
    var thisID = _this.closest('tr').find('td:first-child').text();
    var date = new Date();
    var hours = date.getHours() < 10 ? '0'+date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? '0'+date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? '0'+date.getSeconds() : date.getSeconds();
    var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + hours + ':' + minutes + ':' + seconds;
    var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + hours + ':' + minutes;
    if(_this.hasClass('send-NO')){
        $.post('order-update.php',{
            'id': thisID,
            'date_departure': dateValuesSQL
        }).done(function (result) {
            _this.parent().html('<div class="send-YES tooltip"><span class="send-text">Отправлен</span><img class="send-img" src="assets/img/icons/send_success.png"><span class="tooltiptext">'+dateValuesNormal+'</span></div>');
        });
    }else if(_this.hasClass('send-YES') && confirm('Отметить заказ, как НЕ отправленный?')){
        $.post('order-update.php',{
            'id': thisID,
            'date_departure': '0000-00-00 00:00:00'
        }).done(function (result) {
            _this.parent().html('<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>');
        });
    }
});

$('td.edit-order img').on('click', function () {
    var _this = $(this).closest('td');
    var thisID = _this.closest('tr').find('td:first-child').text();
    $.post('order-update-form.php',{
        'id': +thisID,
        'name': _this.closest('tr').find('td.td-name').text()
    }).done(function (result) {
        _this.parent().html('<td>'+thisID+'</td>'+'<td>'+result+'</td>');
    });
});