<?php
error_reporting(E_ALL);
$arrayListOrders = $dbClass->querySELECT("select * from orders ORDER BY departure, date_departure DESC, payment DESC, payment_part, id DESC");

?>
<?php foreach ($arrayListOrders as $item):?>
    <tr class="<?='id-'.htmlentities($item['id'])?>">
        <td class="td-id"><?=htmlentities($item['id'])?></td>
        <td class="td-date_create"><?=convertDateFormat(htmlentities($item['date_create']))?></td>
        <td class="td-name"><?=htmlentities($item['name'])?></td>
        <td class="td-address"><?=htmlentities($item['address']).(isset($item['phone']) && $item['phone'] != -1 ? ",<br>".htmlentities($item['phone']) : '')?></td>
        <td class="td-list_flowers"><?=printFlowersList(htmlentities($item['list_flowers']))?></td>
        <td class="td-price_bank"><?php
            switch ($item['price_bank']) {
                case 'tinkoff':
                    echo "<img src=\"assets/img/icons/bank/tinkoff.png\" alt=\"Tinkoff\">";
                    break;
                case 'rncb':
                    echo "<img src=\"assets/img/icons/bank/rncb.jpg\" alt=\"RNCB\">";
                    break;
                case 'sberbank':
                    echo "<img src=\"assets/img/icons/bank/sberbank.png\" alt=\"Sberbank\">";
                    break;
            }
        ?></td>
        <td class="td-price_flowers"><?=htmlentities($item['price_flowers'])?></td>
        <td class="td-price_delivery"><?php
            if(!(htmlentities($item['price_delivery']) == 0 && $item['bus_delivery'])){
                echo htmlentities($item['price_delivery']);
            }else{
                echo '<img class="bus-img" src="assets/img/icons/bus.png">';
            }
            ?></td>
        <td class="td-price_summary"><?=htmlentities($item['price_summary'])?></td>
        <td class="td-payment "><?php
            if(htmlentities($item['payment_part'])){
                echo '<img class="payment-img payment-img-part" src="assets/img/icons/part.png">';
            }elseif(!htmlentities($item['payment'])){
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
        <td class="edit-order edit"><img class="img-edit" src="assets/img/icons/edit_.png" alt="Редактировать"></td>
        <td class="remove-order"><img src="assets/img/icons/remove-order_.png" alt="Удалить"></td>
    </tr>
<?php endforeach;?>
