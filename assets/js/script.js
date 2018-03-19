$('td.remove-order').on('click', function () {
    // event.preventDefault();
    var thisTR = $(this).parent();
    var thisID = thisTR.find("td:first-child").text();
    var delete_result = confirm("Удалить заказ?");
    if(delete_result){
        $.ajax({
            url: 'remove-order.php?id='+thisID,
            success: function () {
                thisTR.fadeOut(500);
            }
        });
    }
});