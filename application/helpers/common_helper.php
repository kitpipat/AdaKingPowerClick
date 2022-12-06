<?php

// Create By : Napat(Jame) 25/11/2022
function FCNoGetCookieVal($ptKey){
    $oReturnCookie = NULL;
    $oCookieData = get_cookie('AdaStoreBackCookies');
    if( $oCookieData !== NULL ){ // เช็คว่ามี AdaStoreBack Cookies อยู่ไหม ?
        $aCookieData = json_decode(base64_decode($oCookieData), TRUE);
        if( isset($aCookieData[$ptKey]) ){ // เช็คว่ามี Cookie Key ที่ต้องการใช้งานไหม ?
            $oReturnCookie = $aCookieData[$ptKey];
        }
    }else{ // ถ้าไม่มี AdaStoreBack Cookies ให้ login ใหม่
        echo "<script type='text/javascript'>$(document).ready(function(){JCNxShowMsgSessionExpired();});</script>";  
    }
    return $oReturnCookie;
}

// Create By : Napat(Jame) 28/11/2022
function FCNxSetCookie($ptName,$ptValue,$pbStaEncode = false){
    if( $pbStaEncode === true ){
        $tValue = base64_encode(json_encode($ptValue));
    }else{
        $tValue = $ptValue;
    }

    // ก่อน set cookie เคลียร์คุกกี้ก่อน
    FCNxDeleteCookie($ptName);

    // กำหนด วัน-เวลา หมดอายุของ cookie จาก options
    // หน่วยเป็น millisecond
    $nExpire = 86400;

    $aCookiePackData = array(
        'name'		=> $ptName,
        'value' 	=> $tValue,
        'expire' 	=> $nExpire,
        'domain'	=> $_SERVER['SERVER_NAME'],
        'path'		=> explode("/",$_SERVER['SCRIPT_NAME'])[1]
    );
    set_cookie($aCookiePackData);
}

// Create By : Napat(Jame) 29/11/2022
function FCNxAddCookie($ptName,$ptValue){
    $aPackData = json_decode(base64_decode(get_cookie('AdaStoreBackCookies')), TRUE);
    array_push($aPackData, array($ptName => $ptValue));
    FCNxSetCookie("AdaStoreBackCookies",$aPackData,true);
}

// Create By : Napat(Jame) 29/11/2022
function FCNxDeleteCookie($ptName){
    delete_cookie($ptName,$_SERVER['SERVER_NAME'],explode("/",$_SERVER['SCRIPT_NAME'])[1]);
}

?>