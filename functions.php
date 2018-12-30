<?php

function convertDateFormat($datetime)
{/*дату вида (yyyy-mm-dd hh:mm:ss) приводим к виду (dd-mm-yyyy hh:mm)*/
    if (isset($datetime) && $datetime) {
        $date = explode(' ', $datetime)[0];
        $time = explode(' ', $datetime)[1];
        $dateY = explode('-', $date)[0];
        $dateM = explode('-', $date)[1];
        switch ($dateM) {
            case '1':
                $dateM = 'янв';
                break;
            case '2':
                $dateM = 'фев';
                break;
            case '3':
                $dateM = 'мар';
                break;
            case '4':
                $dateM = 'апр';
                break;
            case '5':
                $dateM = 'мая';
                break;
            case '6':
                $dateM = 'июн';
                break;
            case '7':
                $dateM = 'июл';
                break;
            case '8':
                $dateM = 'авг';
                break;
            case '9':
                $dateM = 'сен';
                break;
            case '10':
                $dateM = 'окт';
                break;
            case '11':
                $dateM = 'ноя';
                break;
            case '12':
                $dateM = 'дек';
                break;
            default:
                $dateM = '';
                break;
        }

        $dateD = explode('-', $date)[2];
        $timeH = explode(':', $time)[0];
        $timeM = explode(':', $time)[1];
        return $timeH . ':' . $timeM . '<br>' . '<b>' . $dateD . ' ' . $dateM . '</b>' . '<br>' . $dateY;
    }
}

function printFlowersList($str, $is_updateForm = 0)
{/*Вывод списка цветов в ячейке*/
    $str = str_replace('-', ' ', $str);
    $arrayFlowers = explode(',', $str);/*разбиваем список по запятым*/
    $prices = [];
    foreach ($arrayFlowers as $key => $string) {
        $string = explode(' ', $string);/*разбиваем каждую строку на слова*/
        foreach ($string as $item) {/* $item - слово в строке */
            $length = count($string) - 1;/*количество слов в строке*/
            if ($string[$length] == $item && is_numeric(intval($string[$length]))) {/*если последнее слово содержит число*/
                if (!$is_updateForm) {
                    $string[$length] = '<b>' . strval(intval($string[$length])) . '</b>';/*вставляем обратно с тегом <b>*/
                } else {
                    $prices[] = intval(array_pop($string));
                }
            }
        }
        $arrayFlowers[$key] = implode(' ', $string);
    }
    $i = 1;
    echo '<ul>';
    foreach ($arrayFlowers as $key => $item) {
        if(!$is_updateForm){
            echo "<li class='order-list-item-$i order-list-item'><span>$i</span><p>" . trim($item) . "</p></li>";
        }else{
            echo printOrderListItem($i,$item,$prices);
        }
        $i++;
    }
    echo '</ul>';
    echo $is_updateForm ? '<div class="add-item">Добавить растение</div>':'';
}
function printOrderListItem($i,$item='',$prices=0){
    return "<li class='order-list-item'>
                <span>$i</span>
                <textarea class='flowers-list-input-name'>".trim($item)."</textarea>
                <input type='number' class='flowers-list-input-price' value='".$prices[$i-1]."'>
                <div class='delete-item'></div>
            </li>";
}