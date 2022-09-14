<?php

/**
 * Functionality: (เอกสารเปลี่ยนสถานะบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรมีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified: 07/01/2018 Wasin(ํYoshi)
 * Return: 
 * Return Type: Numeric
*/
function FSnHCrdChangeChkCrdCodeFoundInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();    

    // ============= Parameter =============    
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCvdSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundCardCode  = language('document/card/docvalidate','tErrorNotFoundCardCode');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '".$tErrorNotFoundCardCode."'
                WHERE FTCvdOldCode
                NOT IN(
                    SELECT  DISTINCT C1.FTCvdOldCode FROM TFNTCrdVoidTmp C1
                    INNER JOIN(
                        SELECT CVT.FTCvdOldCode AS FTCrdCodeTemp , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdVoidTmp CVT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdOldCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CVT.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCvdOldCode = C2.FTCrdCode
                    ".$tWhereSltSeqNo."
                ) ";
    
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID = '".$tSessionID."' ";

    $oQuery  = $ci->db->query($tSQL);
    
    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบรหัสบัตรในระบบ
    }else{
        return 0;   // พบข้อมูลบัตรในระบบ
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนสถานะบัตร) ฟังก์ชั่นตรวจสอบว่าบัตรใหม่ในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHCrdChangeChkNewCardNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();
    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCvdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdOldTmpDup  = language('document/card/docvalidate','tErrorCrdTmpDup'); // Add validate for lang (Jame) 08/01/2562

    $tSQL = " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 1, FTCvdRmk = ''
        WHERE FTSessionID = '$tSessionID' AND FTCvdStaCrd = '2'
    ";

    $tSQL .= " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '$tErrorCrdOldTmpDup'
            WHERE  FTCvdOldCode
            IN (
                SELECT DISTINCT C1.FTCvdOldCode FROM TFNTCrdVoidTmp C1
                INNER JOIN(
                    SELECT FTCvdOldCode , COUNT(FTCvdOldCode)  AS FNCvdOldCodeCount
                    FROM [TFNTCrdVoidTmp]
                    WHERE FTSessionID = '$tSessionID'
                    GROUP BY FTCvdOldCode
                ) C2 ON C1.FTCvdOldCode = C2.FTCvdOldCode
                AND C1.FTSessionID = '$tSessionID'
                AND C2.FNCvdOldCodeCount > 1 
                $tWhereSltSeqNo
            ) 
    ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND (FTCvdStaCrd = 1 AND FTSessionID = '".$tSessionID."')";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0;   // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนสถานะบัตร) ฟังก์ชั่นเช็คสถานะยกเลิกบัตร
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdChangeChkStaShiftInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $bStaCardShift  = $paParams['bStaCardShift'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusShift = 1: สถานะบัตรยังไม่ถูกเบิก , 2: สถานะบัตรถูกเบิกไปแล้ว */
        $tErrorStaCardShift     = "";
    if(!empty($bStaCardShift)   && $bStaCardShift === TRUE){
        $tWhereStaCrdShift      = " AND CRD.FTCrdStaShift = 1 ";
        $tErrorStaCardShift     = language('document/card/docvalidate','tErrorStaCrdShiftNotWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    }else if(!empty($bStaCardShift) && $bStaCardShift === FALSE){
        $tWhereStaCrdShift      = " AND CRD.FTCrdStaShift = 2 ";
        $tErrorStaCardShift     = language('document/card/docvalidate','tErrorStaCrdShiftWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    }else{
        $tWhereStaCrdShift      = "";
    }

    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '".$tErrorStaCardShift."'
                WHERE  FTCvdOldCode
                NOT IN (
                    SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM [TFNTCrdVoidTmp] CVT
                    LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdOldCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereStaCrdShift;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนสถานะบัตร) ฟังก์ชั่นเช็คสถานะรหัสบัตร Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 03/01/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHCrdChangeChkCrdStaActiveInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusActive = 1: Active , 2:InActive ,3:Cancle
           $tErrorStaCrdActive   = "";
    switch($nCrdStaActive){
        case '1':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdActive');  // Add validate for lang (Jame) 08/01/2562
        break;
        case '2':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdInActive');  // Add validate for lang (Jame) 08/01/2562
        break;
        case '3':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdCancle');  // Add validate for lang (Jame) 08/01/2562
        break;
        default:
            $tWhereCrdStaActive =  "";
    }

    $tSQL   =   "   UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '".$tErrorStaCrdActive."'
                    WHERE FTCvdOldCode
                    NOT IN (
                        SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdVoidTmp CVT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdOldCode = CRD.FTCrdCode
                        WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereCrdStaActive;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนสถานะบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรต้องไม่หมดอายุ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHCrdChangeChkCardExpireDate($paParams){
    $ci = &get_instance();
    $ci->load->database();
    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }
    
    $tErrorCardExpire  = language('document/card/docvalidate','tErrorCardExpire');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '".$tErrorCardExpire."'
                WHERE FTCvdOldCode
                IN(
                    SELECT CVT.FTCvdOldCode
                    FROM TFNTCrdVoidTmp CVT
                    INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode =  CVT.FTCvdOldCode AND  CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE (),121)
                    WHERE CTT.FTSessionID = '".$tSessionID."' ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";
    
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลรหัสบัตรหมดอายุ
    }else{
        return 0;   // ข้อมูลรหัสบัตรไม่หมดอายุ
    }
}
