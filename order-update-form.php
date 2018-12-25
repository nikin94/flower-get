<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
require_once('functions.php');
$id = $_POST['id'];
$sql = "select * from orders WHERE id = $id";
$tmp = $dbClass->querySELECT($sql);
$arrayData = $tmp[0];
?>


<tr id="order-update-form">
    <td class="td-id"><?= $id ?></td>
    <td class="td-date_create"><?= convertDateFormat(htmlentities($arrayData['date_create'])) ?></td>
    <td class="td-name"><input id="name" autocomplete="off" value="<?= $arrayData['name'] ?>"></td>
    <td class="td-address"><label>Адрес<textarea id="address" autocomplete="off"
                                              ><?= htmlentities($arrayData['address']) ?></textarea></label><br><?= "<label>Телефон<input id='phone' value='" . ($arrayData['phone'] != 0 && $arrayData['phone'] != -1 ? htmlentities($arrayData['phone']) : '') . "'></label>";
        ?></td>
    <td class="td-list_flowers"><textarea id="list_flowers"><?= htmlentities($arrayData['list_flowers']) ?></textarea>
    </td>
    <td class="td-price_bank">
        <div class="bank-logo <?= $arrayData['price_bank'] == 'tinkoff' ? 'checked' : '' ?>">
            <label><img src="assets/img/icons/bank/tinkoff.png" alt="tinkoff"><input type="radio" name="price_bank"
                                                                                     value="tinkoff" <?= $arrayData['price_bank'] == 'tinkoff' ? 'checked="checked"' : '' ?>></label><br/>
        </div>
        <div class="bank-logo <?= $arrayData['price_bank'] == 'rncb' ? 'checked' : '' ?>">
            <label><img src="assets/img/icons/bank/rncb.jpg" alt="rncb"><input type="radio" name="price_bank"
                                                                               value="rncb" <?= $arrayData['price_bank'] == 'rncb' ? 'checked="checked"' : '' ?>></label><br/>
        </div>
        <div class="bank-logo <?= $arrayData['price_bank'] == 'sberbank' ? 'checked' : '' ?>">
            <label><img src="assets/img/icons/bank/sberbank.png" alt="sberbank"><input type="radio" name="price_bank"
                                                                                       value="sberbank" <?= $arrayData['price_bank'] == 'sberbank' ? 'checked="checked"' : '' ?>></label>
        </div>
    </td>
    <td class="td-price_flowers"><input id="price_flowers" type="number"
                                        value="<?= htmlentities($arrayData['price_flowers']) ?>"></td>
    <td class="td-price_delivery">
        <input id="price_delivery" type="number"
               value="<?= htmlentities($arrayData['price_delivery']) ?>" <?= $arrayData['bus_delivery'] ? 'disabled' : '' ?>><br/><br/>
        <label class="bus-icon">
            <input id="bus_delivery" type="checkbox" <?= $arrayData['bus_delivery'] ? 'checked="checked"' : '' ?>>
            <img src="assets/img/icons/bus<?= $arrayData['bus_delivery'] ? '' : '_no' ?>.png" alt="">
        </label>
    </td>
    <td class="td-price_summary"><input id="price_summary" type="number"
                                        value="<?= htmlentities($arrayData['price_summary']) ?>"></td>
    <td class="td-payment"><?php
        if (htmlentities($arrayData['payment_part'])) {
            echo '<img class="payment-img payment-img-part" src="assets/img/icons/part.png">';
        } elseif (!htmlentities($arrayData['payment'])) {
            echo '<img class="payment-img payment-img-no" src="assets/img/icons/no.png">';
        } else {
            echo '<div class="tooltip"><img class="payment-img payment-img-yes" src="assets/img/icons/yes.png"><span class="tooltiptext">' . convertDateFormat(htmlentities($arrayData['date_payment'])) . '</span></div>';
        } ?>
        <?= !$arrayData['payment_part'] ? '<label class="payment_part"><input id="payment_part" type="checkbox"><img
                    src="assets/img/icons/part.png" alt=""></label>' : '' ?>
    </td>
    <td class="td-date_departure"><?php
        if (isset($arrayData['date_departure']) && $arrayData['date_departure'] !== '0000-00-00 00:00:00') {
            echo '<div class="send-YES tooltip"><span class="send-text">Отправлен</span><img class="send-img" src="assets/img/icons/send_success.png"><span class="tooltiptext">' . convertDateFormat(htmlentities($arrayData['date_departure'])) . '</span></div>';
        } else {
            echo '<div class="send-NO"><span class="send-text">Не отправлен</span><img class="send-img" src="assets/img/icons/send.png"></div>';
        }
        ?>
        <div class="tracking">
            <input type="number" id="tracking_number" value="<?php echo $arrayData['tracking_number']?>">
        </div>
    </td>
    <td class="edit-order"><img class="img-save" src="assets/img/icons/save.png" alt="Редактировать"></td>
    <td class="remove-order"><img src="assets/img/icons/remove-order_.png" alt="Удалить"></td>
</tr>

