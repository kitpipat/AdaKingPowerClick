<?php

/**
 * Functionality: (เอกสารล้างบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรมีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified: 07/01/2018 Wasin(ํYoshi)
 * Return: 
 * Return Type: Numeric
*/
function FSnHClrCrdChkCrdCodeFoundInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();    

    // ============= Parameter =============    
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundCardCode  = language('document/card/docvalidate','tErrorNotFoundCardCode');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorNotFoundCardCode."'
                WHERE FTCidCrdCode
                NOT IN(
                    SELECT  DISTINCT C1.FTCidCrdCode FROM TFNTCrdImpTmp C1
                    INNER JOIN(
                        SELECT CIT.FTCidCrdCode AS FTCrdCodeTemp , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdImpTmp CIT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CIT.FTCidCrdCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CIT.FTSessionID = '".$tSessionID."'
                    ) C2 ON C1.FTCidCrdCode = C2.FTCrdCode
                    ".$tWhereSltSeqNo."
                ) ";

    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCidStaCrd = 1 AND FTSessionID = '".$tSessionID."' ";

    $oQuery  = $ci->db->query($tSQL);
    
    if($ci->db->affected_rows() > 0){
        return 1;   // ไม่พบรหัสบัตรในระบบ
    }else{
        return 0;   // พบข้อมูลบัตรในระบบ
    }
}

/**
 * Functionality: (เอกสารล้างบัตร) ฟังก์ชั่นตรวจสอบว่าบัตรในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHClrCrdChkCrdCodeNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdTmpDup  = language('document/card/docvalidate','tErrorCrdTmpDup');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorCrdTmpDup."'
                WHERE  FTCidCrdCode 
                IN(
                    SELECT DISTINCT C1.FTCidCrdCode FROM TFNTCrdImpTmp C1
                    INNER JOIN(
                        SELECT FTCidCrdCode , COUNT(FTCidCrdCode)  AS FNCidCrdCount
                        FROM TFNTCrdImpTmp
                        WHERE FTSessionID = '".$tSessionID."'
                        GROUP BY FTCidCrdCode
                    ) C2 ON C1.FTCidCrdCode = C2.FTCidCrdCode
                    AND C1.FTSessionID = '".$tSessionID."'
                    AND C2.FNCidCrdCount > 1
                    ".$tWhereSltSeqNo."
                ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND (FTCidStaCrd = 1 AND FTSessionID = '".$tSessionID."')";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0;   // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารล้างบัตร) ฟังก์ชั่นเช็คสถานะการถูกเบิก
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHClrCrdChkStaShiftInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();

    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $bStaCardShift  = $paParams['bStaCardShift'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CIT.FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusShift = 1: สถานะบัตรยังไม่ถูกเบิก , 2: สถานะบัตรถูกเบิกไปแล้ว */
        $tErrorStaCardShift     = "";
    if(!empty($bStaCardShift)   && $bStaCardShift === TRUE){
        $tWhereStaCrdShift      = " AND CRD.FTCrdStaShift = 1";
        $tErrorStaCardShift     = language('document/card/docvalidate','tErrorStaCrdShiftNotWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    }else if(!empty($bStaCardShift) && $bStaCardShift === FALSE){
        $tWhereStaCrdShift      = " AND CTD.FTCrdStaShift = 2";
        $tErrorStaCardShift     = language('document/card/docvalidate','tErrorStaCrdShiftWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    }else{
        $tWhereStaCrdShift      = "";
    }

    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorStaCardShift."'
                WHERE  FTCidCrdCode 
                NOT IN (
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdImpTmp CIT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CIT.FTCidCrdCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereStaCrdShift;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";

    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารล้างบัตร) ฟังก์ชั่นเช็คสถานะ Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 27/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHClrCrdChkStaActiveInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();

    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CIT.FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusActive = 1: Active , 2:InActive ,3:Cancle */
            $tErrorStaCrdActive  = "";
    switch ($nCrdStaActive) {
        case '1':
            //Status Active
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '2':
            //Status InActives
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdInActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '3':
            //Status Cancle
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive  = language('document/card/docvalidate','tErrorStaCrdCancle');  // Add validate for lang (Jame) 08/01/2562
            break;
        default:
            $tWhereCrdStaActive =  "";
    }

    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorStaCrdActive."'
                WHERE  FTCidCrdCode 
                NOT IN (
                    SELECT  ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdImpTmp CIT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CIT.FTCidCrdCode = CRD.FTCrdCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereCrdStaActive;
    $tSQL   .= " ) ";  
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";
    
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    }else{
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารล้างบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรต้องไม่หมดอายุ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHClrCrdChkCardExpireDate($paParams){
    $ci = &get_instance();
    $ci->load->database();

    /** Paramiter */
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];

    /** Where Seq In Table Edit InLine */
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CIT.FNCidSeqNo  = '".$tSeqNo."' ";
        $tWhereUpdSeqNo = " AND FNCidSeqNo  = '".$tSeqNo."' ";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardExpire  = language('document/card/docvalidate','tErrorCardExpire');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdImpTmp SET FTCidStaCrd = 2 , FTCidRmk = '".$tErrorCardExpire."'
                WHERE FTCidCrdCode
                IN(
                    SELECT CIT.FTCidCrdCode
                    FROM TFNTCrdImpTmp CIT
                    INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode =  CIT.FTCidCrdCode AND  CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE (),121) 
                    WHERE 1=1 AND CIT.FTSessionID = '".$tSessionID."' ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCidStaCrd = 1 AND FTSessionID =  '".$tSessionID."' ";
    
    $oQuery = $ci->db->query($tSQL);
    if($ci->db->affected_rows() > 0){
        return 1;   // ข้อมูลรหัสบัตรหมดอายุ
    }else{
        return 0;   // ข้อมูลรหัสบัตรไม่หมดอายุ
    }
}


?>
