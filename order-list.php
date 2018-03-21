<?php
error_reporting(E_ALL);
$arrayListOrders = $dbClass->querySELECT("select * from orders");
?>

<table id="order-list">
    <thead>
        <tr>

            <th class="th-id"><img class="th-icon" src="assets/img/icons/id.png"><span class="tooltiptext">Номер заказа</span></th>
            <th class="th-name"><img class="th-icon" src="assets/img/icons/name.png"><span class="tooltiptext">Имя заказчика</span></th>
            <th class="th-address"><img class="th-icon" src="assets/img/icons/address.png"><span class="tooltiptext">Адрес</span></th>
            <th class="th-phone"><img class="th-icon" src="assets/img/icons/phone.png"><span class="tooltiptext">Телефон</span></th>
            <th class="th-list_flowers"><img class="th-icon" src="assets/img/icons/list_flowers.png"><span class="tooltiptext">Список растений</span></th>
            <th class="th-price_flowers"><img class="th-icon" src="assets/img/icons/price_flowers.png"><span class="tooltiptext">Цена растений</span></th>
            <th class="th-price_delivery"><img class="th-icon" src="assets/img/icons/price_delivery.png"><span class="tooltiptext">Стоимость доставки</span></th>
            <th class="th-price_summary"><img class="th-icon" src="assets/img/icons/price_summary.png"><span class="tooltiptext">Итоговая стоимость</span></th>
            <th class="th-date_create"><img class="th-icon" src="assets/img/icons/date_create.png"><span class="tooltiptext">Дата создания заказа</span></th>
            <th class="th-payment"><img class="th-icon" src="assets/img/icons/payment.png"><span class="tooltiptext">Статус оплаты</span></th>
            <th class="th-date_payment"><img class="th-icon" src="assets/img/icons/date_payment.png"><span class="tooltiptext">Дата оплаты</span></th>
            <th class="th-date_departure"><img class="th-icon" src="assets/img/icons/date_departure.png"><span class="tooltiptext">Дата отправки посылки</span></th>
            <th class="th-edit-order"><img class="th-icon" src="assets/img/icons/edit.png"><span class="tooltiptext">Редактировать заказ</span></th>
            <th class="th-remove-order"><img class="th-icon" src="assets/img/icons/remove-order.png"><span class="tooltiptext">Удалить заказ</span></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($arrayListOrders as $item):?>
        <tr>
            <td class="td-"><?=htmlentities($item['id'])?></td>
            <td class="td-"><?=htmlentities($item['name'])?></td>
            <td class="td-"><?=htmlentities($item['address'])?></td>
            <td class="td-"><?=htmlentities($item['phone'])?></td>
            <td class="td-"><?=printFlowersList(htmlentities($item['list_flowers']))?></td>
            <td class="td-"><?=htmlentities($item['price_flowers'])?></td>
            <td class="td-"><?=htmlentities($item['price_delivery'])?></td>
            <td class="td-price_summary"><?=htmlentities($item['price_summary'])?></td>
            <td class="td-"><?=convertDateFormat(htmlentities($item['date_create']))?></td>
            <td><?php
                if(!htmlentities($item['payment'])){
                    echo '<img class="payment-img payment-img-no" src="assets/img/no.png">';
                }else{
                    echo '<img class="payment-img payment-img-yes" src="assets/img/yes.png">';
                }
                ?></td>
            <td class="td-date_payment"><?=convertDateFormat(htmlentities($item['date_payment']))?></td>
            <td class="td-date_departure"><?=convertDateFormat(htmlentities($item['date_departure']))?></td>
            <td class="edit-order"><a href=""><img src="assets/img/icons/edit_.png" alt="Редактировать"></a></td>
            <td class="remove-order"><img src="assets/img/icons/remove-order_.png" alt="Удалить"></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
