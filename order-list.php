<?php
error_reporting(E_ALL);
$arrayListOrders = $dbClass->querySELECT("select * from orders");
?>

<table>
    <thead>
        <tr>

            <th>Номер заказа</th>
            <th>Имя</th>
            <th>Адрес</th>
            <th>Телефон</th>
            <th>Заказ</th>
            <th>Стоимость заказа</th>
            <th>Стоимость доставки</th>
            <th>Итого</th>
            <th>Дата создания</th>
            <th>Оплата</th>
            <th>Дата оплаты</th>
            <th>Дата отправки</th>
            <th>Редактировать</th>
            <th>Удалить</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($arrayListOrders as $item):?>
        <tr>
            <td><?=htmlentities($item['id'])?></td>
            <td><?=htmlentities($item['name'])?></td>
            <td><?=htmlentities($item['address'])?></td>
            <td><?=htmlentities($item['phone'])?></td>
            <td><?=printFlowersList(htmlentities($item['list_flowers']))?></td>
            <td><?=htmlentities($item['price_flowers'])?></td>
            <td><?=htmlentities($item['price_delivery'])?></td>
            <td><?=htmlentities($item['price_summary'])?></td>
            <td><?=convertDateFormat(htmlentities($item['date_create']))?></td>
            <td><?php
                if(!htmlentities($item['payment'])){
                    echo 'Не оплачен';
                }
                ?></td>
            <td><?=convertDateFormat(htmlentities($item['date_payment']))?></td>
            <td><?=convertDateFormat(htmlentities($item['date_departure']))?></td>
            <td class="edit-order">edit</td>
            <td class="remove-order">×</td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
