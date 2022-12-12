<?php

function _response($response){
    header("Access-Control-Allow-Origin: * ");
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($response);
    exit();
}

function remove_dash_first_upperletter($value){
    $string = str_replace("-"," ",$value);
    return ucwords($string);
}

function curl($url, $postData){
    $ch = curl_init();
    $curlConfig = array(
        CURLOPT_URL            => $url,
        CURLOPT_POST           => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS     => $postData
    );
    curl_setopt_array($ch, $curlConfig);
    $result = curl_exec($ch);
    curl_close($ch);
}

function upload_document($file,$destination) {
    $file_name = time().uniqid().".".$file->getClientOriginalExtension();
    $destinationPath = Config::get('app.storage_path').$destination;
    $file->move($destinationPath,$file_name);
    return $destination."/".$file_name;
}

