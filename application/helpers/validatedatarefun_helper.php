<?php

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรมีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified: 07/01/2018 Wasin(ํYoshi)
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkCrdCodeFoundInDB($paParams){
    $ci = &get_instance();
    $ci->load->database();    

    // ============= Parameter =============    
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundCardCode = language('document/card/docvalidate','tErrorNotFoundCardCode'); // Add validate for lang (golf) 08/01/2019

    $tSQL = " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = 2 , FTXsdRmk = '$tErrorNotFoundCardCode'
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
            ) 
    ";

    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTXsdStaCrd = '1' AND FTSessionID = '$tSessionID'";
    
    $ci->db->query($tSQL);
    
    if($ci->db->affected_rows() > 0){
        return 1; // ไม่พบรหัสบัตรในระบบ
    }else{
        return 0; // พบข้อมูลบัตรในระบบ
    }
}

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นตรวจสอบว่าบัตรในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkCrdCodeNotDupTemp($paParams){
    $ci = &get_instance();
    $ci->load->database();

    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
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
        return 1; // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }else{
        return 0; // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นเช็คสถานะการถูกเบิก
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkStaShiftInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();
    // Paramiter
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];
    $bStaCardShift = $paParams['bStaCardShift'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusShift = 1: สถานะบัตรยังไม่ถูกเบิก , 2: สถานะบัตรถูกเบิกไปแล้ว
        $tRmkError = "";
    if(!empty($bStaCardShift) && $bStaCardShift === TRUE){
        $tRmkError = language('document/card/docvalidate', 'tErrorStaCrdShiftNotWithdrawned'); // Add validate for lang (jame) 08/01/2019
        $tWhereStaCrdShift = " AND CRD.FTCrdStaShift = '1'";
    }else if(!empty($bStaCardShift) && $bStaCardShift === FALSE){
        $tRmkError = language('document/card/docvalidate', 'tErrorStaCrdShiftWithdrawned'); // Add validate for lang (jame) 08/01/2019
        $tWhereStaCrdShift = " AND CRD.FTCrdStaShift = '2'";
    }else{
        $tRmkError = ''; // Add validate for lang (Copter) 08/01/2019
        $tWhereStaCrdShift = "";
    }
    
    $tSQL = " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '2', FTXsdRmk = '$tRmkError'
            WHERE FTCrdCode 
            NOT IN (
                SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                FROM TFNTCrdTopUpTmp CTT
                LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                WHERE 1=1 
    ";
    $tSQL .= $tWhereSltSeqNo;
    $tSQL .= $tWhereStaCrdShift;
    $tSQL .= " ) ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTXsdStaCrd = '1' AND FTSessionID = '$tSessionID'";

    $oQuery = $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1; // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    }else{
        return 0; // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นเช็คสถานะ Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkStaActiveInCard($paParams){
    $ci = &get_instance();
    $ci->load->database();
    // Paramiter
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];
    $nCrdStaActive = $paParams['nCrdStaActive'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }


    // StatusActive = 1: Active , 2:InActive ,3:Cancle
           $tRmkError = "";
    switch($nCrdStaActive){
        case '1':
            $tRmkError = language('document/card/docvalidate', 'tErrorStaCrdActive'); // Add validate for lang (jame) 08/01/2019
            $tWhereCrdStaActive = " AND CRD.FTCrdStaActive = '1'";
        break;
        case '2':
            $tRmkError = language('document/card/docvalidate', 'tErrorStaCrdInActive'); // Add validate for lang (jame) 08/01/2019
            $tWhereCrdStaActive = " AND CRD.FTCrdStaActive = '2'";
        break;
        case '3':
            $tRmkError = language('document/card/docvalidate', 'tErrorStaCrdCancle'); // Add validate for lang (jame) 08/01/2019
            $tWhereCrdStaActive = " AND CRD.FTCrdStaActive = '3'";
        break;
        default:
            $tWhereCrdStaActive = "";
    }

    $tSQL = " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '2', FTXsdRmk = '$tRmkError'
            WHERE FTCrdCode
            NOT IN (
                SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                FROM TFNTCrdTopUpTmp CTT
                LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                WHERE 1=1 
    ";
    $tSQL .= $tWhereSltSeqNo;    
    $tSQL .=  $tWhereCrdStaActive;
    $tSQL .= " ) ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTXsdStaCrd = '1' AND FTSessionID =  '$tSessionID'";

    $ci->db->query($tSQL);

    if($ci->db->affected_rows() > 0){
        return 1; // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    }else{
        return 0; // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรต้องไม่หมดอายุ
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkCardExpireDate($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // Paramiter
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardExpire = language('document/card/docvalidate', 'tErrorCardExpire'); // Add validate for lang (golf) 08/01/2019

    $tSQL = " 
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '2', FTXsdRmk = '$tErrorCardExpire'
            WHERE FTCrdCode 
            IN(
                SELECT CTT.FTCrdCode
                FROM TFNTCrdTopUpTmp CTT WITH (NOLOCK)
                INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CTT.FTCrdCode AND CONVERT(VARCHAR(10),CRD.FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE (),121) 
                WHERE CTT.FTSessionID = '$tSessionID' 
    ";
    $tSQL .= $tWhereSltSeqNo;
    $tSQL .= " )";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTXsdStaCrd = '1' AND FTSessionID =  '$tSessionID'";

    $ci->db->query($tSQL);
    
    if($ci->db->affected_rows() > 0){
        return 1; // ข้อมูลรหัสบัตรหมดอายุ
    }else{
        return 0; // ข้อมูลรหัสบัตรไม่หมดอายุ
    }
}

/**
 * Functionality: (เอกสารคืนเงิน) ฟังก์ชั่นตรวจสอบว่าจำนวนเงินที่คืนถูกต้องหรือไม่(จำนวนเงินคืนต้อง น้อยกว่าหรือเท่ากับ ยอดเงินคงเหลือ)
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 29/01/2019 Piya
 * Last Modified:
 * Return: 
 * Return Type: Numeric
*/
function FSnHRefunChkCardBal($paParams){
    $ci = &get_instance();
    $ci->load->database();

    // Paramiter
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if(isset($tSeqNo) && !empty($tSeqNo)){
        $tWhereSltSeqNo = " AND CTT.FNXsdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNXsdSeqNo = '$tSeqNo'";
    }else{
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardBal = language('document/card/docvalidate', 'tErrorCardOverBal');
    
    $tSQL = "
        UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '2', FTXsdRmk = '$tErrorCardBal'
            WHERE FTCrdCode 
                IN(
                    SELECT
                        CB.FTCrdCode
                    FROM(
                        SELECT
                            CTT.FTCrdCode,
                            CTT.FCXsdAmt,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNTCrdTopUpTmp CTT WITH (NOLOCK)
                        INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CTT.FTCrdCode = CRD.FTCrdCode
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CTT.FTSessionID = '$tSessionID'
                        GROUP BY CTT.FTCrdCode, CTT.FCXsdAmt
                    ) CB
                    WHERE ISNULL(dbo.F_GETnCardCheckout(CB.FTCrdCode), 0) < ISNULL(CB.FCXsdAmt, 0)
    ";
    $tSQL .= $tWhereSltSeqNo;
    $tSQL .= " ) ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTXsdStaCrd = '1' AND FTSessionID = '$tSessionID'";

    $ci->db->query($tSQL);
    
    if($ci->db->affected_rows() > 0){
        return 1; // ยอดเงินคืนมากกว่ายอดเงินคงเหลือในบัตร
    }else{
        return 0; // ยอดเงินคืนถูกต้อง
    }
}
