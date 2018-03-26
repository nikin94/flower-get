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

$('#order-add table tr td #payment, #order-add table tr td #departure').click(function () {/*открытие текущей даты оплаты заказа и скрытие по значению чекбокса*/
    var date = new Date();
    var dateVaules = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + 'T' + date.getHours() + ':' + date.getMinutes();
    var _this = $(this);
    if (this.checked) {
        _this.closest('tr').next().find('input').val(dateVaules);
        _this.closest('tr').next().fadeIn(400);

    } else {
        _this.closest('tr').next().find('input').val('');
        _this.closest('tr').next().fadeOut(400);
    }
});

$('#order-add input#price_flowers, #order-add input#price_delivery, #order-add input#price_summary').keyup(function () {/*суммируем стоимость в форме*/
    var price_flowers = $('#order-add input#price_flowers');
    var price_delivery = $('#order-add input#price_delivery');
    var price_summary = $('#order-add input#price_summary');
    if($(this).attr('id') == 'price_flowers' || $(this).attr('id') == 'price_delivery'){
        price_summary.val(+price_flowers.val() + +price_delivery.val());
    }else {
        if(price_summary.val() - price_delivery.val() > 0){
            price_flowers.val(+price_summary.val() - +price_delivery.val());
        }else{
            price_flowers.val(0);
        }
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
            _this.html('<div class="tooltip"><img class="payment-img payment-img-yes" src="assets/img/icons/yes.png"><span class="tooltiptext">'+dateValuesNormal+'</span></div>');
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
            console.log(result);
            _this.parent().html('<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>');
        });
    }
});

$('body').on('click', 'td.edit-order .img-edit', function () {
    var _this = $(this).closest('td');
    var thisID = _this.closest('tr').find('td:first-child').text();
    if(_this.hasClass('edit')) _this.addClass('edit-current');
    $('#order-list td.edit-order').each(function () {
        $(this).removeClass('edit');
        $(this).find('img[src*="edit"]').addClass('monochrome');
    });
    if (_this.hasClass('edit-current')){
        $.post('order-update-form.php',{
            'id': +thisID
        }).done(function (result) {
            _this.closest('tr').replaceWith(result);
        });
    }
});

$('body').on('click', 'td.edit-order .img-save', function () {
    var this_td = $(this).closest('td');
    var this_tr = $(this).closest('tr');
    var thisID = this_tr.find('td:first-child').text();
    $.post('order-update.php', {
        'id': thisID,
        'name': this_tr.find('td.td-name input#name').val(),
        'address': this_tr.find('td.td-address input#address').val(),
        'phone': this_tr.find('td.td-address input#phone').val(),
        'list_flowers': this_tr.find('td.td-list_flowers textarea#list_flowers').val(),
        'price_flowers': +this_tr.find('td.td-price_flowers input#price_flowers').val(),
        'price_delivery': +this_tr.find('td.td-price_delivery input#price_delivery').val(),
        'price_summary': +this_tr.find('td.td-price_summary input#price_summary').val()
    }).done(function (result) {

    });
});