<?php
?>

<form action="" name="order-add" id="order-add">
    <label>Фамилия, имя клиента<input type="text" required></label>
    <label>Адрес доставки<input type="text" required></label>
    <label>Телефон<input type="text"></label>
    <label>Содержимое заказа<textarea required></textarea></label>
    <label>Стоимость заказа<input type="number"></label>
    <label>Стоимость доставки<input type="number" value="350"></label>
    <label>Итого<input type="number"></label>
    <label>Оплата<input type="checkbox"></label>
    <label>Дата оплаты<input type="date" value="<?php echo date('Y-m-d'); ?>"></label>
    <label>Дата отправки<input type="date" value=""></label>
    <button>Добавить заказ</button>
</form>
