<?php
?>


<form action="order-add.php" method="POST" name="order-add" id="order-add">
    <table>
        <tr class="name">
            <td><label for="name">Фамилия, имя клиента</label></td>
            <td>
                <input name="name" id="name" autocomplete="off" type="text" required>
                <div class="names" style="display: none;">
                </div>
            </td>
        </tr>
        <tr class="address">
            <td><label for="address">Адрес доставки</label></td>
            <td><textarea name="address" id="address" autocomplete="off" type="text" required></textarea></td>
        </tr>
        <tr class="phone">
            <td><label for="phone">Телефон</label></td>
            <td><input name="phone" id="phone" autocomplete="off" type="text"></td>
        </tr>
        <tr class="list_flowers">
            <td><label for="list_flowers">Содержимое заказа</label></td>
            <td><textarea name="list_flowers" id="list_flowers" required></textarea></td>
        </tr>
        <tr class="price_bank">
            <td><label for="price_bank">Способ оплаты</label></td>
            <td>
                <div class="bank-logo bank-tinkoff">
                    <label>
                        <input name="price_bank" class="radio-bank" value="tinkoff" id="price_bank_tinkoff" type="radio">
                        <img src="assets/img/icons/bank/tinkoff.png" alt="Tinkoff">
                    </label>
                </div>
                <div class="bank-logo bank-rncb">
                    <label>
                        <input name="price_bank" class="radio-bank" value="rncb" id="price_bank_rncb" type="radio">
                        <img src="assets/img/icons/bank/rncb.jpg" alt="RNCB">
                    </label>
                </div>
                <div class="bank-logo bank-sberbank checked">
                    <label>
                        <input name="price_bank" class="radio-bank" value="sberbank" id="price_bank_sberbank"
                               type="radio">
                        <img src="assets/img/icons/bank/sberbank.png" alt="Sberbank">
                    </label>
                </div>
            </td>
        </tr>
        <tr class="price_flowers">
            <td><label for="price_flowers">Стоимость заказа</label></td>
            <td><input name="price_flowers" id="price_flowers" type="number"></td>
        </tr>
        <tr class="price_delivery">
            <td><label for="price_delivery">Стоимость доставки</label></td>
            <td><input name="price_delivery" id="price_delivery" type="number" value="350">
                <div class="tooltip inline-block">
                    <label class="bus-icon">
                        <span class="tooltiptext">Отправка автобусом</span>
                        <input name="bus_delivery" id="bus_delivery" type="checkbox">
                        <img src="assets/img/icons/bus_no.png" alt="bus">
                    </label>
                </div>
            </td>
        </tr>
        <tr class="price_summary">
            <td><label for="price_summary">Итого </label></td>
            <td><input name="price_summary" id="price_summary" type="number"></td>
        </tr>
        <tr class="payment">
            <td><label for="payment">Оплачен</label></td>
            <td><input name="payment" id="payment" type="checkbox"></td>
        </tr>
        <tr class="date_payment" style="display: none;">
            <td><label for="date_payment">Дата оплаты </label></td>
            <td><input name="date_payment" id="date_payment" type="datetime-local"></td>
        </tr>
        <tr class="departure">
            <td><label for="departure">Отправлен</label></td>
            <td><input name="departure" id="departure" type="checkbox"></td>
        </tr>
        <tr class="date_departure" style="display: none;">
            <td><label for="date_departure">Дата отправки</label></td>
            <td><input name="date_departure" id="date_departure" type="datetime-local" value=""></td>
        </tr>
        <tr class="tracking_number" style="display: none;">
            <td><label for="tracking_number">Код посылки</label></td>
            <td><input type="text" name="tracking_number" id="tracking_number" value=""></td>
        </tr>
    </table>
    <button>Добавить заказ</button>
</form>
<div class="order-add-list">
    <table>
        <thead>
            <tr>
                <th>Наименование</th>
                <th>Стоимость</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


