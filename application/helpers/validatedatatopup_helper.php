<?php

/**
 * Functionality: (เอกสารเติมเงิน) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรมีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified: 07/01/2018 Wasin(ํYoshi)
 * Return: 
 * Return Type: Numeric
*/
function FSnHTopUpChkCrdCodeFoundInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNXsdSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundCardCode   =   language('document/card/docvalidate','tErrorNotFoundCardCode'); // Add validate for lang (golf) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = 2 , FTXsdRmk = '".$tErrorNotFoundCardCode."'
                WHERE FTCrdCode
                NOT IN(
                    SELECT  DISTINCT C1.FTCrdCode FROM TFNTCrdTopUpTmp C1
                    INNER JOIN(
                        SELECT CTT.FTCrdCode AS FTCrdCodeTemp , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdTopUpTmp CTT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CTT.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCrdCode = C2.FTCrdCode
                    ".$tWhereSltSeqNo."
                ) ";

    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTXsdStaCrd = 1 AND FTSessionID = '".$tSessionID."' ";
    
    $oQuery  = $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบรหัสบัตรเก่าในระบบ
    }else{
        return 0;   // พบข้อมูลบัตรเก่าในระบบ
    }
}

/**
 * Functionality: (เอกสารเติมเงิน) ฟังก์ชั่นตรวจสอบว่าบัตรในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHTopUpChkCrdCodeNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];


    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNXsdSeqNo  = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo  = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdTmpDup = language('document/card/docvalidate','tErrorCrdTmpDup'); // Add validate for lang (golf) 08/01/2019
   
    $tSQL = " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '1', FTXsdRmk = ''
        WHERE FTSessionID = '$tSessionID' AND FTXsdStaCrd = '2'
    ";

    $tSQL .= " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '2', FTXsdRmk = '$tErrorCrdTmpDup'
                WHERE FTCrdCode
                IN (
                    SELECT DISTINCT C1.FTCrdCode FROM TFNTCrdTopUpTmp C1
                    INNER JOIN(
                        SELECT FTCrdCode, COUNT(FTCrdCode) AS FNCrdCodeCount
                        FROM TFNTCrdTopUpTmp
                        WHERE FTSessionID = '$tSessionID'
                        GROUP BY FTCrdCode
                    ) C2 ON C1.FTCrdCode = C2.FTCrdCode
                    AND C1.FTSessionID = '$tSessionID'
                    AND C2.FNCrdCodeCount > 1 
                    $tWhereSltSeqNo
                ) 
    ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTXsdStaCrd = '1' AND FTSessionID = '$tSessionID')";

    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0;   // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารเติมเงิน) ฟังก์ชั่นเช็คสถานะการถูกเบิก
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHTopUpChkStaShiftInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();
    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $bStaCardShift  = $paParams['bStaCardShift'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusShift = 1: สถานะบัตรยังไม่ถูกเบิก , 2: สถานะบัตรถูกเบิกไปแล้ว */
        $tErrorStaCardShift = "";
    if(!empty($bStaCardShift) && $bStaCardShift === TRUE){
        $tWhereStaCrdShift  = " AND CRD.FTCrdStaShift = 1 ";
        $tErrorStaCardShift   =   language('document/card/docvalidate','tErrorStaCrdShiftNotWithdrawned'); // Add validate for lang (golf) 09/01/2019
    }else if(!empty($bStaCardShift) && $bStaCardShift === FALSE){
        $tWhereStaCrdShift  = " AND CRD.FTCrdStaShift = 2 ";
        $tErrorStaCardShift   =   language('document/card/docvalidate','tErrorStaCrdShiftWithdrawned'); // Add validate for lang (golf) 09/01/2019
    }else{

        $tWhereStaCrdShift  = "";
    }
    $tSQL   = " UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = 2 , FTXsdRmk = '".$tErrorStaCardShift."'
                WHERE  FTCrdCode 
                NOT IN (
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdTopUpTmp CTT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereStaCrdShift;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTXsdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเติมเงิน) ฟังก์ชั่นเช็คสถานะ Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHTopUpChkStaActiveInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();
    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusActive = 1: Active , 2:InActive ,3:Cancle */
           $tErrorStaCrdActive = "";
    switch($nCrdStaActive){
        case '1':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive   =   language('document/card/docvalidate','tErrorStaCrdActive');  // Add validate for lang (golf) 09/01/2019
        break;
        case '2':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive   =   language('document/card/docvalidate','tErrorStaCrdInActive');  // Add validate for lang (golf) 09/01/2019
        break;
        case '3':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive   =   language('document/card/docvalidate','tErrorStaCrdCancle'); // Add validate for lang (golf) 09/01/2019
        break;
        default:
            $tWhereCrdStaActive =  "";
    }

    $tSQL   = " UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = 2 , FTXsdRmk = '".$tErrorStaCrdActive."'
                WHERE FTCrdCode
                NOT IN (
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdTopUpTmp CTT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;    
    $tSQL   .=  $tWhereCrdStaActive;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTXsdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเติมเงิน) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรต้องไม่หมดอายุ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHTopUpChkCardExpireDate($paParams){
    $ci = &get_instance();
    $ci->load->database();
    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardExpire   =   language('document/card/docvalidate','tErrorCardExpire'); // Add validate for lang (golf) 08/01/2019
    $tSQL   = " UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = 2 , FTXsdRmk = '".$tErrorCardExpire."'
                WHERE FTCrdCode 
                IN(
                    SELECT CTT.FTCrdCode
                    FROM TFNTCrdTopUpTmp CTT
                    INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode =  CTT.FTCrdCode AND  CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE (),121) 
                    WHERE CTT.FTSessionID = '".$tSessionID."' ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTXsdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลรหัสบัตรหมดอายุ
    }else{
        return 0;   // ข้อมูลรหัสบัตรไม่หมดอายุ
    }
}
