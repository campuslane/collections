<?php 


function stringifyArray($array)
{
    $output = '[';

    foreach($array as $key => $value) {
        if(is_integer($key)) {
            $output .= "'" . $value . "', ";
        } else {
            $output .= "'".$key."'=>'" . $value . "', ";
        }
    }

    $output = trim($output, ', ');

    $output .= ']';

    return $output;
}






