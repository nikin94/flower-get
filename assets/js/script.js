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

function calcAllprices() {/*Перерасчет общей стоимости при изменении цены цветка*/
  var summ = 0;
  $('.flowers-list-input-price').each(function () {
    summ += +$(this).val();
  });
  $('#price_flowers').val(summ);
  calcPriceSummary();
}

function calcPriceSummary() {/*Ставим итоговую стоимость */
  $('#price_summary').val(+$('#price_flowers').val() + +$('#price_delivery').val());
}

function rewriteIndexes() {/* Пересчитываем индексы */
  $('#order-update-form .order-list-item span').each(function (index) {
    $(this).html(+index + 1);
  });
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
$('#order-list .td-list_flowers ul').each(function () {
  if($(this).height() < 200 ){
    if($(this).hasClass('packed')){
      $(this).removeClass('packed');
    }
  }else {
    $(this).parent().prepend('<div class="pack" title="Развернуть"></div>');
  }
});

$('body').on('click', '.pack', function () {
  if($(this).next().hasClass('packed')){
    $(this).next().removeClass('packed');
    $(this).attr('title','Свернуть');
  }else{
    $(this).next().addClass('packed');
    $(this).attr('title','Развернуть');
  }
});

$('td.td-date_departure, td.date_payment').each(function () {/*Если даты нет - не выводим*/
  if ($(this).text() === '00-00-0000 00:00') {
    $(this).text('');
  }
});

$('#order-list td.remove-order').on('click', function () {/*confirm и удаление заказа*/
  var thisTR = $(this).parent();
  var thisID = thisTR.find("td:first-child").text();
  if (confirm("Удалить заказ?")) {
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

$('body').on('click', 'input#bus_delivery', function () {/*Отправка автобусом*/
  var price_delivery = $('#price_delivery');
  if (this.checked) {
    price_delivery.attr('disabled', true);
    price_delivery.val(0);
    $('#price_summary').val(+$('#price_flowers').val());
    $(this).next().attr('src', 'assets/img/icons/bus.png');
  } else {
    price_delivery.attr('disabled', false);
    price_delivery.val(350);
    $('#price_summary').val(+$('#price_flowers').val() + 350);
    $(this).next().attr('src', 'assets/img/icons/bus_no.png');
  }
});

$('#order-add table tr td #payment, #order-add table tr td #departure').click(function () {/*открытие текущей даты оплаты заказа и скрытие по значению чекбокса*/
  var date = new Date();
  var dateVaules = date.getFullYear() + '-' + ("0" + (date.getMonth() + 1)).slice(-2) + '-' + ("0" + date.getDate()).slice(-2) + 'T' + date.getHours() + ':' + date.getMinutes();
  var _this = $(this);
  var list = $(this).closest('tbody');
  if (this.checked) {
    if ($(this).closest('tr').hasClass('payment')) {
      list.find('.date_payment input').val(dateVaules);
      list.find('.date_payment').fadeIn(400);
    } else if ($(this).closest('tr').hasClass('departure')) {
      list.find('.date_departure input').val(dateVaules);
      list.find('.date_departure').fadeIn(400);
      list.find('.tracking_number input').val('295000');
      list.find('.tracking_number').fadeIn(400);
    }
  } else {
    if ($(this).closest('tr').hasClass('payment')) {
      list.find('.date_payment').fadeOut(400, function () {
        list.find('.date_payment input').val('');
      });
    } else if ($(this).closest('tr').hasClass('departure')) {
      list.find('.date_departure').fadeOut(400, function () {
        list.find('.date_departure input').val('');
      });
      list.find('.tracking_number').fadeOut(400, function () {
        list.find('.tracking_number input').val('');
      });
    }
  }
});
$('body').on('input', '.flowers-list-input-price', calcAllprices);

$('body').on('click', '.delete-item', function () {/*Удаление элемента из списка update-формы*/
  var _this = $(this).closest('li');
  var number = _this.find('span').html();
  var name = _this.find('textarea');
  var price = _this.find('input');
  if (confirm('Удалить пункт №' + number + ' - \'' + name.val() + '\', стоимостью ' + price.val() + '?')) {
    _this.fadeOut(300, function () {
      name.val('');
      price.val('');
      $(this).remove();
      calcAllprices();
      rewriteIndexes();
    });
  }
});

$('body').on('click', '#order-update-form .add-item', function () {/*ДОБАВИТЬ РАСТЕНИЕ*/
  $(this).closest('td').children('ul').append("<li class='order-list-item'>" +
    "<span></span>" +
    "<textarea class='flowers-list-input-name'></textarea>" +
    "<input type='number' class='flowers-list-input-price'>" +
    "<div class='delete-item'></div>" +
    "</li>");
  rewriteIndexes();
});
$('body').on('focusout keyup', '#list_flowers', function () {/*Суммируем стоимости цветов из списка и выводим их в таблице*/
  var current_values = ($('#list_flowers').val()).replace(/-|;/g, ' ').split(/,/);
  /*замена дефисов и ; на пробелы и разделение по , */
  var prices = [];
  $('.order-add-list tbody tr').each(function () {
    $(this).remove();
  });
  for (i in current_values) {
    if (current_values[i]) {
      var _this = current_values[i];
      _this = ($.trim(_this)).split(' ');
      var last = parseInt(_this.pop());
      if (isNaN(last)) {
        last = parseInt(_this.pop());
      }
      _this = _this.join(' ');
      var newTR = '<tr><td>' + _this + '</td><td>' + last + '</td></tr>';
      if (!isNaN(last)) {
        prices.push(last);
        $('.order-add-list tbody').append(newTR);
      }
    }
  }
  var summ = prices.reduce(function (a, b) {
    return +a + +b;
  }, 0);
  if (summ) {
    $('.order-add-list').fadeIn(300).css("display", "inline-block");
  } else {
    $('.order-add-list').fadeOut(300);
  }
  $('.order-add-list tbody').append('<tr class="total"><td>Стоимость цветов:</td><td class="summ">' + summ + '</td></tr>');
  $('#price_flowers').val(summ);
  calcPriceSummary();
});

$('body').on('input', '#name', function () {/*ВЫВОДИМ ИМЕНА КЛИЕНТОВ ПО СОВПАДЕНИЮ В БАЗЕ*/
  var _this = $(this);
  var nameValue = _this.val().toLowerCase();
  $('.names').html('');
  $.post('get-clients-list.php', {
    'getNames': nameValue
  }).done(function (namesArray) {
    if (namesArray) {
      namesArray = namesArray.split('/');
      !namesArray[namesArray.length - 1] ? namesArray.pop() : false;
      var outputArray = [];
      $.each(namesArray, function (i, el) {/*удаление дублей*/
        if ($.inArray(el, outputArray) === -1) outputArray.push(el);
      });
      for (var i in outputArray) {
        var current_element = '<div class="names-item">' + outputArray[i] + '</div>';
        if (outputArray[i].toLowerCase().indexOf(nameValue) >= 0 && $('.names').length < 6) {
          $('.names').append(current_element);
        }
      }
      if ($('.names').is(':empty')) {
        $('.names').slideUp(300);
      } else {
        $('.names').slideDown(300);
      }
    } else {
      $('.names').slideUp(300);
    }
  });
});

$('body').on('mousedown', '.names-item', function () {/*АВТОЗАПОЛНЕНИЕ ПОЛЕЙ ПО КЛИКУ НА КЛИЕНТА*/
  var currentName = $(this).html();
  $.post('get-clients-list.php', {
    currentName: currentName
  }).done(function (result) {
    result = JSON.parse(result);
    $('#name').val(currentName);
    $('#address').val(result['address']);
    $('#phone').val(result['phone']);
  });
});

$('body').on('focusout', '#name', function () {
  $('.names').slideUp(300, function () {
    $(this).html('');
  });
});

$('body').on('keyup', '#price_flowers, #price_delivery', calcPriceSummary);

$('body').on('click', '#order-list img.payment-img', function () {/*КНОПКА ОПЛАТЫ*/
  var _this = $(this).closest('td.td-payment');
  if (!$('#payment_part').hasClass('checked')) {
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
        'date_payment': 0
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

$('body').on('click', '#order-list .td-date_departure .send-text, #order-list .td-date_departure .send-img', function () {/*КНОПКА ОТПРАВКИ*/
  var _this = $(this).closest('div');
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
      _this.parent().html(
        '<div class="send-YES tooltip">' +
        '<span class="send-text">Отправлен</span>' +
        '<img class="send-img" src="assets/img/icons/send_success.png">' +
        '<span class="tooltiptext">' + dateValuesNormal + '</span>' +
        '</div>' +
        '<div class="tracking">' +
        '<input type="number" id="tracking_number" value="295000">' +
        '<button class="save">Сохранить</button>' +
        '</div>'
      );
    });
  } else if (_this.hasClass('send-YES') && confirm('Отметить заказ, как НЕ отправленный и удалить ТРЕК-номер?')) {
    $.post('order-update.php', {
      'id': thisID,
      'departure': 0,
      'date_departure': 0,
      'tracking_number': 0
    }).done(function (result) {
      _this.parent().html('<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>');
    });
  }
});

$('body').on('input', '#tracking_number', function () {/*СОХРАНЯЕМ ТРЕК В БАЗУ ПОСЛЕ ВВОДА КАЖДОГО СИМВОЛА*/
  var _this = $(this).closest('td');
  var thisID = _this.closest('tr').find('td:first-child').text();
  $.post('order-update.php', {
    'id': thisID,
    'tracking_number': +$(this).val()
  }).done(function (result) {
    // console.log(result);
  });
});
$('body').on('click', '.tracking button.save', function () {/*ЗАМЕНА ИНПУТА С ТРЕКОМ НА КНОПКУ С ТЕКСТОМ*/
  var _this = $(this).closest('div.tracking');
  var thisID = _this.closest('tr').find('td:first-child').text();
  $.post('get-tracking-number.php', {
    'id': +thisID
  }).done(function (result) {
    _this.html('<button class="tracking_number">' + result + '</button>');
  });
});
$('body').on('click', '#order-list .tracking_number', function () {/*КОПИРОВАНИЕ ТРЕКА ПО КЛИКУ*/
  var _this = $(this);
  $(this).after('<input type="text" id="temp_input" value="' + _this.html() + '">');
  var copyText = document.getElementById("temp_input");
  copyText.select();
  document.execCommand("copy");
  $('#temp_input').remove();
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
$('body').on('click', '#order-update-form .remove-order', function () {
  var thisTR = $(this).parent();
  var thisID = thisTR.find("td:first-child").text();
  if (confirm("Удалить заказ?")) {
    $.get('order-remove.php?id=' + thisID).done(function () {
      thisTR.fadeOut(1000);
      $('#order-list td.edit-order').each(function () {
        $(this).addClass('edit');
        $(this).find('img[src*="edit"]').removeClass('monochrome');
      });
    });
  }
});

$('body').on('click', 'td.edit-order .img-save', function () {/*КНОПКА "СОХРАНИТЬ"*/
  var this_td = $(this).closest('td');
  var this_tr = $(this).closest('tr');
  var thisID = this_tr.find('td:first-child').text();
  var payment_part = (this_tr.find('.td-payment img').hasClass('payment-img-part') ? 1 : 0) || (this_tr.find('#payment_part').hasClass('checked') ? 1 : 0);
  var list_inputs_names = $('#order-update-form .order-list-item .flowers-list-input-name').toArray();
  var list_inputs_prices = $('#order-update-form .order-list-item .flowers-list-input-price').toArray();
  var list_flowers = '';
  var length = list_inputs_names.length === list_inputs_prices.length ? list_inputs_names.length : 0;
  for (var i=0; i < length; i++) {
    if ($(list_inputs_names[i]).val() && $(list_inputs_prices[i]).val()) {
      list_flowers += ' '+$(list_inputs_names[i]).val()+ ' ' + $(list_inputs_prices[i]).val()+",";
    }
  }
  if(list_flowers.length > 1) list_flowers = list_flowers.slice(0, -1);
  calcAllprices();
  $.post('order-update.php', {
    'id': thisID,
    'name': this_tr.find('td.td-name #name').val(),
    'address': this_tr.find('td.td-address #address').val(),
    'phone': this_tr.find('td.td-address #phone').val(),
    'list_flowers': list_flowers,
    'price_bank': this_tr.find('td.td-price_bank input[name="price_bank"]:checked').val(),
    'price_flowers': +this_tr.find('td.td-price_flowers #price_flowers').val(),
    'price_delivery': +this_tr.find('td.td-price_delivery #price_delivery').val(),
    'bus_delivery': this_tr.find('td.td-price_delivery #bus_delivery').is(':checked') ? 1 : 0,
    'payment_part': payment_part,
    'price_summary': +this_tr.find('td.td-price_summary #price_summary').val()
  }).done(function (result) {
    // console.log(result);
    window.location.replace("/flowers/?list=" + thisID);
  });
});
