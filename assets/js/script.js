function getUrlParameter(sParam) {/*Вернёт значение из get-запроса по переданному параметру - ключу*/
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'), sParameterName, i;
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function calcPriceSummary() {/*Ставим итоговую стоимость*/
    $('input#price_summary').val(+$('input#price_flowers').val() + +$('input#price_delivery').val());
}

if (getUrlParameter('list') !== true) {/*Отмечаем затухающим зеленым цветом отредактированную строку и сносим _GET в url*/
    $('#order-list .td-id').each(function () {
        if ($(this).text() == getUrlParameter("list")) {
            //console.log($(this).css());
            $(this).closest('tr').css({backgroundColor: '#82ff7b'});
            $(this).closest('tr').stop().animate({backgroundColor: 'transparent'}, 3000, function () {
                window.history.pushState({}, "Hide", "/flowers/?list");
            });
        }
    });
}

$('td.td-date_departure, td.date_payment').each(function () {/*Если даты нет - не выводим*/
    if ($(this).text() === '00-00-0000 00:00') {
        $(this).text('');
    }
});


$('#order-list td.remove-order').on('click', function () {/*confirm и удаление заказа*/
    var thisTR = $(this).parent();
    var thisID = thisTR.find("td:first-child").text();
    var delete_result = confirm("Удалить заказ?");
    if (delete_result) {
        $.get('order-remove.php?id=' + thisID).done(function () {
            thisTR.fadeOut(1000);
        });
    }
});

$('body').on('click', '.bank-logo, .bank-logo-update', function () {/*Выбор банка*/
    $('.bank-logo').removeClass('checked');
    $('.bank-logo-update').removeClass('checked');
    $(this).addClass('checked');
});

$('body').on('click', 'input#bus_delivery', function (){/*Отправка автобусом*/
    var price_delivery = $('input#price_delivery');
    if(this.checked){
        price_delivery.attr('disabled', true);
        price_delivery.val(0);
        $('input#price_summary').val(+$('input#price_flowers').val());
        $(this).next().attr('src','assets/img/icons/bus.png');
    }else {
        price_delivery.attr('disabled', false);
        price_delivery.val(350);
        $('input#price_summary').val(+$('input#price_flowers').val()+350);
        $(this).next().attr('src','assets/img/icons/bus_no.png');
    }
});

$('#order-add table tr td #payment, #order-add table tr td #departure').click(function () {/*открытие текущей даты оплаты заказа и скрытие по значению чекбокса*/
    var date = new Date();
    var dateVaules = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + 'T' + date.getHours() + ':' + date.getMinutes();
    var _this = $(this);
    if (this.checked) {
        _this.closest('tr').next().find('input').val(dateVaules);
        _this.closest('tr').next().fadeIn(400);

    } else {
        _this.closest('tr').next().fadeOut(400, function () {
            _this.closest('tr').next().find('input').val('');
        });
    }
});

$('body').on('focusout', '#list_flowers', function () {/*Суммируем стоимости цветов из списка и выводим их в таблице*/
    var current_values = ($('#list_flowers').val()).split(/,|;/);
    var prices = [];
    $('.order-add-list tbody tr').each(function () {
        $(this).remove();
    });
    for (i in current_values) {
        if(current_values[i]){
            var _this = current_values[i];
            _this = ($.trim(_this)).split(' ');
            var last = parseInt(_this.pop());
            if(isNaN(last)){
                last = parseInt(_this.pop());
            }
            prices.push(last);
            _this = _this.join(' ');
            var newTR = '<tr><td>'+_this+'</td><td>'+last+'</td></tr>';
            $('.order-add-list tbody').append(newTR);
        }
    }
    var summ = prices.reduce(function(a, b){
        return +a + +b;
    }, 0);
    if(summ){
        $('.order-add-list').fadeIn(300);
    }else {
        $('.order-add-list').fadeOut(300);
    }
    $('.order-add-list tbody').append('<tr class="total"><td>Стоимость цветов:</td><td class="summ">'+summ+'</td></tr>');
    $('#price_flowers').val(summ);
    calcPriceSummary();
});

$('body').on('focusin keyup','input#name', function () {
    var nameValue = $(this).val();
    $.post('find-client.php', {
        'nameValue': nameValue
    }).done(function (result) {
        console.log(result);
    });
});

$('body').on('keyup', 'input#price_flowers, input#price_delivery', calcPriceSummary);

$('body').on('click', '#order-list img.payment-img', function () {/*КНОПКА ОПЛАТЫ*/
    var _this = $(this).closest('td.td-payment');
    if(!$('#payment_part').hasClass('checked')) {
        var thisID = _this.closest('tr').find('td:first-child').text();
        var date = new Date();
        var hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
        var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
        var seconds = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
        var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + hours + ':' + minutes + ':' + seconds;
        var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + hours + ':' + minutes;
        if (_this.find('img.payment-img').hasClass('payment-img-no') || _this.find('img.payment-img').hasClass('payment-img-part')) {
            $.post('order-update.php', {
                'id': thisID,
                'payment': 1,
                'payment_part': 0,
                'date_payment': dateValuesSQL
            }).done(function () {
                _this.html('<div class="tooltip"><img class="payment-img payment-img-yes" src="assets/img/icons/yes.png"><span class="tooltiptext">' + dateValuesNormal + '</span></div>');
            });
        } else if (_this.find('img.payment-img').hasClass('payment-img-yes') && confirm('Отметить заказ, как НЕ оплаченный?')) {
            $.post('order-update.php', {
                'id': thisID,
                'payment': 0,
                'date_payment': null
            }).done(function (result) {
                _this.html('<img class="payment-img payment-img-no" src="assets/img/icons/no.png">');
            });
        }
    }
});
$('body').on('click', '#order-list .payment_part', function () {/*ЧАСТИЧНАЯ ОПЛАТА*/
    if (!$(this).find('input').hasClass('checked') && !$(this).find('input').prop('checked') && confirm('Заказ частично оплачен?')) {
        var _this = $(this);
        _this.closest('td').find('span.tooltiptext').remove();
        _this.find('input').addClass('checked');
        _this.find('img').css({
            webkitFilter: 'grayscale(0%)',
            filter: 'grayscale(0%)'
        });
        _this.closest('.td-payment').find('.payment-img').css({
            webkitFilter: 'grayscale(100%)',
            filter: 'grayscale(100%)'
        });
    }
});

$('body').on('click', '#order-list .td-date_departure .send-YES, #order-list .td-date_departure .send-NO', function () {/*КНОПКА ОТПРАВКИ*/
    var _this = $(this);
    var thisID = _this.closest('tr').find('td:first-child').text();
    var date = new Date();
    var hours = date.getHours() < 10 ? '0' + date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes();
    var seconds = date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds();
    var dateValuesSQL = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + ' ' + hours + ':' + minutes + ':' + seconds;
    var dateValuesNormal = ("0" + date.getDate()).slice(-2) + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear() + ' ' + hours + ':' + minutes;
    if (_this.hasClass('send-NO')) {
        $.post('order-update.php', {
            'id': thisID,
            'departure': 1,
            'date_departure': dateValuesSQL
        }).done(function (result) {
            _this.parent().html('<div class="send-YES tooltip"><span class="send-text">Отправлен</span><img class="send-img" src="assets/img/icons/send_success.png"><span class="tooltiptext">' + dateValuesNormal + '</span></div>');
        });
    } else if (_this.hasClass('send-YES') && confirm('Отметить заказ, как НЕ отправленный?')) {
        $.post('order-update.php', {
            'id': thisID,
            'departure': 0,
            'date_departure': '0000-00-00 00:00:00'
        }).done(function (result) {
            _this.parent().html('<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>');
        });
    }
});

$('body').on('click', 'td.edit-order .img-edit', function () {/*КНОПКА РЕДАКТИРОВАНИЯ*/
    var _this = $(this).closest('td');
    var thisID = _this.closest('tr').find('td:first-child').text();
    if (_this.hasClass('edit')) _this.addClass('edit-current');
    $('#order-list td.edit-order').each(function () {
        $(this).removeClass('edit');
        $(this).find('img[src*="edit"]').addClass('monochrome');
    });
    if (_this.hasClass('edit-current')) {
        $.post('order-update-form.php', {
            'id': +thisID
        }).done(function (result) {
            _this.closest('tr').replaceWith(result);
        });
    }
});

$('body').on('click', 'td.edit-order .img-save', function () {/*КНОПКА "СОХРАНИТЬ"*/
    var this_td = $(this).closest('td');
    var this_tr = $(this).closest('tr');
    var thisID = this_tr.find('td:first-child').text();
    var payment_part = (this_tr.find('.td-payment img').hasClass('payment-img-part') ? 1 : 0) || (this_tr.find('#payment_part').hasClass('checked') ? 1 : 0);
    $.post('order-update.php', {
        'id': thisID,
        'name': this_tr.find('td.td-name input#name').val(),
        'address': this_tr.find('td.td-address input#address').val(),
        'phone': this_tr.find('td.td-address input#phone').val(),
        'list_flowers': this_tr.find('td.td-list_flowers textarea#list_flowers').val(),
        'price_bank': this_tr.find('td.td-price_bank input[name="price_bank"]:checked').val(),
        'price_flowers': +this_tr.find('td.td-price_flowers input#price_flowers').val(),
        'price_delivery': +this_tr.find('td.td-price_delivery input#price_delivery').val(),
        'bus_delivery': this_tr.find('td.td-price_delivery input#bus_delivery').is(':checked') ? 1 : 0,
        'payment_part': payment_part,
        'price_summary': +this_tr.find('td.td-price_summary input#price_summary').val()
    }).done(function (result) {
        window.location.replace("/flowers/?list=" + thisID);
    });
});
