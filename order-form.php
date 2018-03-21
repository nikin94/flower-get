<?php
?>


<form action="order-add.php" method="POST" name="order-add" id="order-add">
    <table>
        <tr class="name">
            <td><label for="name">Фамилия, имя клиента</label></td>
            <td><input name="name" id="name" type="text" required></td>
        </tr>
        <tr class="address">
            <td><label for="address">Адрес доставки</label></td>
            <td><input name="address" id="address" type="text" required></td>
        </tr>
        <tr class="phone">
            <td> <label for="phone">Телефон</label></td>
            <td> <input name="phone" id="phone" type="text"></td>
        </tr>
        <tr class="list_flowers">
            <td> <label for="list_flowers">Содержимое заказа</label></td>
            <td> <textarea name="list_flowers" id="list_flowers" required></textarea></td>
        </tr>
        <tr class="price_flowers">
            <td> <label for="price_flowers">Стоимость заказа</label></td>
            <td> <input name="price_flowers" id="price_flowers" type="number"></td>
        </tr>
        <tr class="price_delivery">
            <td><label for="price_delivery">Стоимость доставки</label></td>
            <td> <input name="price_delivery" id="price_delivery" type="number" value="350"></td>
        </tr>
        <tr class="price_summary">
            <td><label for="price_summary">Итого </label></td>
            <td> <input name="price_summary" id="price_summary" type="number" disabled></td>
        </tr>
        <tr class="payment">
            <td><label for="payment">Оплачен</label></td>
            <td><input name="payment" id="payment" type="checkbox"></td>
        </tr>
        <tr class="date_payment" style="display: none;">
            <td> <label for="date_payment">Дата оплаты </label></td>
            <td> <input name="date_payment" id="date_payment" type="date"></td>
        </tr>
        <tr class="date_departure">
            <td> <label for="date_departure">Дата отправки</label></td>
            <td> <input name="date_departure" id="date_departure" type="date" value=""></td>
        </tr>
    </table>

    <button>Добавить заказ</button>
</form>


