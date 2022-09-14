<?php

//Functionality: Request API
//Parameters:  Function Parameter
//Creator: 19/02/2018 Kitpipat(พี่รันต์)
//Last Modified :19/02/2018: 17:00 Phisan(อาม)
//19/02/2018 : 18:46 Kitpipat(รันต์)              
//Return : API Respornse
//Return Type: Array
function FCNaHCallAPI($ptAPIReq = "", $ptMethodReq = "GET", $poParam = "") {
    try {
        $oData = json_encode($poParam);
        $CI = & get_instance();

        $tURLAPI = $CI->config->item('URLAPI');
        $tURLReq = $tURLAPI . "/" . $ptAPIReq;
        //echo $tURLReq;
        $tAuthKey = $CI->config->item('APIAuthKey');
        //echo $tAuthKey;
        $aHeader = array(
            'Content-Type: application/json',
            'X-API-KEY : ' . $tAuthKey,
            'Content-Length: ' . strlen($oData)
        );
        $tCurlEx = curl_init($tURLReq); // เปิดการทำงาน + url 
        curl_setopt($tCurlEx, CURLOPT_CUSTOMREQUEST, $ptMethodReq); // method
        curl_setopt($tCurlEx, CURLOPT_POSTFIELDS, $oData); // data หรือ parameter ที่จะส่ง 
        curl_setopt($tCurlEx, CURLOPT_RETURNTRANSFER, true); //  return ค่ากลับมาในรูป string
        curl_setopt($tCurlEx, CURLOPT_HTTPHEADER, $aHeader); //  ค่าของ HEADER
        curl_setopt($tCurlEx, CURLOPT_TIMEOUT, 60); //  กำหนดเวลาสูงสุดที่คำขอจะได้รับอนุญาตให้ใช้ curl
        curl_setopt($tCurlEx, CURLOPT_CONNECTTIMEOUT, 60); //  กำหนดเวลาสูงสุดที่คำขอจะได้รับอนุญาตให้เชื่อมต่อ

        $oResult = curl_exec($tCurlEx); //  สั่งให้ curl ทำงาน
        if ($oResult === FALSE) {
            $tError = curl_error($tCurlEx);
            return array('error' => $tError);
        } else {
            $aResponse = json_decode($oResult, true);
            return $aResponse;
        }
        curl_close($tCurlEx); //  การสั่งปิดการทำงาน
    } catch (Exception $e) {
        return array('error' => $e);
    }
}





//Functionality: Request API Basic
//Parameters:  Function Parameter
//Creator: 08/01/21 Nale
//Return : API Respornse
//Return Type: Array
function FCNaHCallAPIBasic($ptAPIReq = "", $ptMethodReq = "GET", $poParam = "" ,$paAuthKey = NULL,$ptConType = "json") {
    try {
        $tURLReq = $ptAPIReq;
        if( $ptConType == "json" ){
            $oData      = json_encode($poParam);
            $aHeader    = array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($oData)
            );
        }else{
            $oData      = $poParam;
            $aHeader    = array();
        }

        if(!empty($paAuthKey)){
            if( !empty($paAuthKey['tKey']) && !empty($paAuthKey['tValue']) ){
                array_push($aHeader,$paAuthKey['tKey'].': '.$paAuthKey['tValue']);
            }else{
                foreach( $paAuthKey as $tKey => $tValue ){
                    array_push($aHeader,$tKey.': '.$tValue);
                }
            }
        }

        $tCurlEx = curl_init($tURLReq); // เปิดการทำงาน + url 
        curl_setopt($tCurlEx, CURLOPT_CUSTOMREQUEST, $ptMethodReq); // method
        curl_setopt($tCurlEx, CURLOPT_POSTFIELDS, $oData); // data หรือ parameter ที่จะส่ง 
        curl_setopt($tCurlEx, CURLOPT_RETURNTRANSFER, true); //  return ค่ากลับมาในรูป string
        curl_setopt($tCurlEx, CURLOPT_HTTPHEADER, $aHeader); //  ค่าของ HEADER
        curl_setopt($tCurlEx, CURLOPT_TIMEOUT, 60); //  กำหนดเวลาสูงสุดที่คำขอจะได้รับอนุญาตให้ใช้ curl
        curl_setopt($tCurlEx, CURLOPT_CONNECTTIMEOUT, 60); //  กำหนดเวลาสูงสุดที่คำขอจะได้รับอนุญาตให้เชื่อมต่อ
        curl_setopt($tCurlEx, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($tCurlEx, CURLOPT_SSL_VERIFYPEER, false);

        $oResult = curl_exec($tCurlEx); //  สั่งให้ curl ทำงาน
        if ($oResult === FALSE) {
            throw new Exception(curl_error($tCurlEx), curl_errno($tCurlEx));
            // $aResponse = array(
            //     "rtData"    => array(),
            //     "rtCode"    => "99",
            //     "rtDesc"    => 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์ กรุณาลองอัพโหลดใหม่อีกครั้ง (408 Request Timeout)'/*curl_error($tCurlEx)*/
            // );
        } else {
            $aResponse = json_decode($oResult, true);
        }
        curl_close($tCurlEx); //  การสั่งปิดการทำงาน
        return $aResponse;
        
    } catch (Exception $e) {
        return array(
            'rtCode'    => curl_errno($tCurlEx),
            'rtDesc'    => curl_error($tCurlEx)
        );
        // trigger_error(sprintf(
        //     'Curl failed with error #%d: %s',
        //     $e->getCode(), $e->getMessage()),
        //     E_USER_ERROR);
    }
}
?>