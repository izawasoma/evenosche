<?php
function is_date($num){
    if(!is_numeric($num)){
        return false;
    }
    if(!(strlen($num) == 8)){
        return false;
    }
    $year = substr($num,0,4);
    $month = substr($num,4,2);
    $day = substr($num,6,2);
    if(!checkdate($month,$day,$year)){
        return false;
    }
    return true;
}

function is_time($num){
    if(!is_numeric($num)){
        return false;
    }
    if(!(strlen($num) == 4) && (!$num == 0)){
        return false;
    }
    $hour = substr($num,0,2);
    $min = substr($num,2,2);
    if(!(0 <= $hour && $hour <= 23)){
        return false;
    }
    elseif(!(0 <= $min && $min <= 59)){
        return false;
    }
    return [$hour.":".$min,true];
}

?>