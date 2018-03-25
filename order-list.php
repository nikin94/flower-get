<?php
error_reporting(E_ALL);
$arrayListOrders = $dbClass->querySELECT("select * from orders ORDER BY id DESC");
?>

<table id="order-list">
    <thead>
        <tr>
            <th class="th-id tooltip"><img class="th-icon" src="assets/img/icons/id.png"><span class="tooltiptext">Номер заказа</span></th>
            <th class="th-name tooltip"><img class="th-icon" src="assets/img/icons/name.png"><span class="tooltiptext">Имя заказчика</span></th>
            <th class="th-address tooltip"><img class="th-icon" src="assets/img/icons/address.png"><span class="tooltiptext">Адрес</span></th>
            <!--<th class="th-phone tooltip"><img class="th-icon" src="assets/img/icons/phone.png"><span class="tooltiptext">Телефон</span></th>-->
            <th class="th-list_flowers tooltip"><img class="th-icon" src="assets/img/icons/list_flowers.png"><span class="tooltiptext">Список растений</span></th>
            <th class="th-price_flowers tooltip"><img class="th-icon" src="assets/img/icons/price_flowers.png"><span class="tooltiptext">Цена растений</span></th>
            <th class="th-price_delivery tooltip"><img class="th-icon" src="assets/img/icons/price_delivery.png"><span class="tooltiptext">Стоимость доставки</span></th>
            <th class="th-price_summary tooltip"><img class="th-icon" src="assets/img/icons/price_summary.png"><span class="tooltiptext">Итоговая стоимость</span></th>
            <th class="th-date_create tooltip"><img class="th-icon" src="assets/img/icons/date_create.png"><span class="tooltiptext">Дата создания заказа</span></th>
            <th class="th-payment tooltip"><img class="th-icon" src="assets/img/icons/payment.png"><span class="tooltiptext">Статус оплаты</span></th>
            <!--<th class="th-date_payment tooltip"><img class="th-icon" src="assets/img/icons/date_payment.png"><span class="tooltiptext">Дата оплаты</span></th>-->
            <th class="th-date_departure tooltip"><img class="th-icon" src="assets/img/icons/date_departure.png"><span class="tooltiptext">Дата отправки посылки</span></th>
            <th class="th-edit-order tooltip"><img class="th-icon" src="assets/img/icons/edit.png"><span class="tooltiptext">Редактировать заказ</span></th>
            <th class="th-remove-order tooltip"><img class="th-icon" src="assets/img/icons/remove-order.png"><span class="tooltiptext">Удалить заказ</span></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($arrayListOrders as $item):?>
        <tr>
            <td class="td-id"><?=htmlentities($item['id'])?></td>
            <td class="td-name"><?=htmlentities($item['name'])?></td>
            <td class="td-address"><?=htmlentities($item['address']).(isset($item['phone']) ? ",<br>".htmlentities($item['phone']) : '')?></td>
            <td class="td-list_flowers"><?=printFlowersList(htmlentities($item['list_flowers']))?></td>
            <td class="td-price_flowers"><?=htmlentities($item['price_flowers'])?></td>
            <td class="td-price_delivery"><?=htmlentities($item['price_delivery'])?></td>
            <td class="td-price_summary"><?=htmlentities($item['price_summary'])?></td>
            <td class="td-date_create"><?=convertDateFormat(htmlentities($item['date_create']))?></td>
            <td class="td-payment"><?php
                if(!htmlentities($item['payment'])){
                    echo '<img class="payment-img payment-img-no" src="assets/img/icons/no.png">';
                }else{
                    echo '<div class="tooltip"><img class="payment-img payment-img-yes" src="assets/img/icons/yes.png"><span class="tooltiptext">'.convertDateFormat(htmlentities($item['date_payment'])).'</span></div>';
                }
                ?></td>
            <td class="td-date_departure"><?php
                if(isset($item['date_departure']) && $item['date_departure']!== '0000-00-00 00:00:00'){
                    echo '<div class="send-YES tooltip"><span class="send-text">Отправлен</span><img class="send-img" src="assets/img/icons/send_success.png"><span class="tooltiptext">'.convertDateFormat(htmlentities($item['date_departure'])).'</span></div>';
                }else{
                    echo '<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>';
                }
                ?></td>
            <td class="edit-order"><img class="img-edit" src="assets/img/icons/edit_.png" alt="Редактировать"></td>
            <td class="remove-order"><img src="assets/img/icons/remove-order_.png" alt="Удалить"></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
