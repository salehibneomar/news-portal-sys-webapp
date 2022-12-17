<?php

function elapsedTime($startDateTime){

    $currentDateTime = date('Y-m-d H:i:s', time());
    $difference      = date_diff(date_create($currentDateTime), date_create($startDateTime));

    $elaspedArray    = array(
             'year'     => $difference->format('%y'),
             'month'    => $difference->format('%m'),
             'day'      => $difference->format('%d'),
             'hour'     => $difference->format('%h'),
             'minute'   => $difference->format('%i'),
             'second'   => $difference->format('%s')
    );

    $elasped = "Just now";

    foreach($elaspedArray as $key=> $out){
        if($out>=1){
            $elasped= ($out>1)? $out." ".$key."s ago" : $out." ".$key." ago";
        break;
        }
    }

    return $elasped;
}


?>