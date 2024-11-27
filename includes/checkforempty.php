<?php

function check_empty_values ($required_fields){

    $all_filled = true;

    foreach($required_fields as $check_fields){
        if(empty($check_fields)){
            $all_filled = false;
            break;
        }

    }

    return $all_filled;

}