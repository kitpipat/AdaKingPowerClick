<?php

// Create By : Napat(Jame) 11/02/2021
// เนื่องจากอัพเดทเวอชั่น php => 7.3 ฟังค์ชั่น count() ไม่รองรับ ถ้าใส่ข้อมูลที่ไม่ใช่ array || object มันจะ error
// จึงสร้างฟังค์ชั่นนี้มาเพื่อ replace all file in project
function FCNnHSizeOf($poParams){
    try{
        $nCount = 0;
        if( !empty($poParams) && ( is_array($poParams) || is_object($poParams) ) ){
            $nCount = count($poParams);
        }
    }catch(Exception $Error){
        $nCount = 0;
    }
    return $nCount;
}

// Create By: Nattakit(Nale)
function FCNUtf8StrLen($ptString) {
    $nC = strlen($ptString); $nL = 0;
    for ($nI = 0; $nI < $nC; ++$nI) if ((ord($ptString[$nI]) & 0xC0) != 0x80) ++$nL;
    return $nL;
}