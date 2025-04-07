<?php

function formattedDate($inputDate){
    $date = DateTime::createFromFormat('m/d/Y', $inputDate);
    $formattedDate = $date->format('Y-m-d');
    return $formattedDate;
}
?>