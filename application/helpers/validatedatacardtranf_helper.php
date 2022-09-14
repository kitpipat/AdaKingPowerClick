<?php

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรเก่ามีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkOldCardFoundInDB($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundOldCard  = language('document/card/docvalidate', 'tErrorNotFoundOldCard');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorNotFoundOldCard . "'
                WHERE FTCvdOldCode
                NOT IN(
                    SELECT  DISTINCT C1.FTCvdOldCode FROM TFNTCrdVoidTmp C1
                    INNER JOIN(
                        SELECT FTCvdOldCode , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdVoidTmp CVT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdOldCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CVT.FTSessionID = '" . $tSessionID . "'
                    ) C2 ON C1.FTCvdOldCode = C2.FTCrdCode
                    " . $tWhereSltSeqNo . "
                ) ";

    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID = '" . $tSessionID . "' ";

    $oQuery  = $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1;   // ไม่พบรหัสบัตรเก่าในระบบ
    } else {
        return 0;   // พบข้อมูลบัตรเก่าในระบบ
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรใหม่มีอยู่ในระบบหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCardFoundInDB($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNotFoundNewCard  = language('document/card/docvalidate', 'tErrorNotFoundNewCard');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorNotFoundNewCard . "'
                WHERE  FTCvdNewCode
                NOT IN (
                    SELECT  DISTINCT C1.FTCvdNewCode FROM TFNTCrdVoidTmp C1
                    INNER JOIN(
                        SELECT FTCvdNewCode , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdVoidTmp CVT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdNewCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND CVT.FTSessionID = '" . $tSessionID . "'
                    ) C2 ON C1.FTCvdNewCode = C2.FTCrdCode
                    " . $tWhereSltSeqNo . "
                ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID = '" . $tSessionID . "' ";

    $oQuery  = $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1;   // ไม่พบรหัสบัตรใหม่ในระบบ
    } else {
        return 0;   // พบข้อมูลบัตรใหม่ในระบบ
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่าบัตรใหม่ในตาราง Temp ซ้ำกันหรือไม่ถ้าซ้ำจะไม่ถูก Process
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCardNotDupTemp($paParams)
{
    $ci = &get_instance();
    $ci->load->database();
    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    //  Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND FNCvdSeqNo = '$tSeqNo'";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '$tSeqNo'";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCrdNewTmpDup = language('document/card/docvalidate', 'tErrorCrdNewTmpDup');  // Add validate for lang (Jame) 08/01/2562
    
    $tSQL = " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '1', FTCvdRmk = ''
        WHERE FTSessionID = '$tSessionID' AND FTCvdStaCrd = '2'
    ";

    $tSQL .= " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '2' , FTCvdRmk = '$tErrorCrdNewTmpDup'
        WHERE FTCvdNewCode
            IN (
                SELECT DISTINCT C1.FTCvdNewCode FROM TFNTCrdVoidTmp C1
                INNER JOIN(
                    SELECT FTCvdNewCode, COUNT(FTCvdNewCode) AS FNCvdNewCodeCount
                    FROM [TFNTCrdVoidTmp]
                    WHERE FTSessionID = '$tSessionID'
                    GROUP BY FTCvdNewCode
                ) C2 ON C1.FTCvdNewCode = C2.FTCvdNewCode
                AND C1.FTSessionID = '$tSessionID'
                AND C2.FNCvdNewCodeCount > 1 
                $tWhereSltSeqNo
            ) 
    ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND (FTCvdStaCrd = '1' AND FTSessionID = '$tSessionID')";

    $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1; // พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    } else {
        return 0; // ไม่พบข้อมูลรหัสบัตรซ้ำในตาราง Temp
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรใหม่มียอดเงินคงเหลือมากกว่า 0
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCardOverBlc($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo = $tSeqNo";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = $tSeqNo";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNewCardOverBlc = language('document/card/docvalidate', 'tErrorNewCardOverBlc');  // Add validate for lang (Jame) 08/01/2562
    $tSQL = " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '2' , FTCvdRmk = '$tErrorNewCardOverBlc'
        WHERE FTCvdNewCode IN (
            SELECT
                CB.FTCvdNewCode
            FROM(
                SELECT
                    CVT.FTCvdNewCode,
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
                    END) Payment,
                    CRDT.FCCtyCreditLimit,
                    CRDT.FTCtyStaPay
                FROM TFNTCrdVoidTmp CVT WITH (NOLOCK)
                INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdNewCode = CRD.FTCrdCode
                LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                WHERE CVT.FTSessionID = '$tSessionID'
                GROUP BY CVT.FTCvdNewCode,CRDT.FCCtyCreditLimit,CRDT.FTCtyStaPay
            ) CB
            WHERE ((CASE CB.FTCtyStapay WHEN '2' THEN CB.FCCtyCreditLimit - ISNULL(dbo.F_GETnCardAmount(CB.FTCvdNewCode),0) ELSE ISNULL(dbo.F_GETnCardAmount(CB.FTCvdNewCode),0) END) > 0)
            $tWhereSltSeqNo
        ) 
    ";
    $tSQL .= $tWhereUpdSeqNo;
    $tSQL .= " AND FTCvdStaCrd = '1' AND FTSessionID =  '$tSessionID'";

    $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1; // ข้อมูลบัตรใหม่ยอดเงินคงเหลือมากกว่า 0 
    } else {
        return 0; // ข้อมูลบัตรใหม่ยอดเงินคงเหลือเท่ากับ 0 
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นเช็คสถานะยกเลิกบัตร
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkStaShiftInCard($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $bStaCardShift  = $paParams['bStaCardShift'];

    /** Where Seq In Table Edit InLine */
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    /** StatusShift = 1: สถานะบัตรยังไม่ถูกเบิก , 2: สถานะบัตรถูกเบิกไปแล้ว */
    $tErrorStaCardShift     = "";
    if (!empty($bStaCardShift)   && $bStaCardShift === TRUE) {
        $tWhereStaCrdShift      = " AND CRD.FTCrdStaShift = 1 ";
        $tErrorStaCardShift     = language('document/card/docvalidate', 'tErrorStaCrdShiftNotWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    } else if (!empty($bStaCardShift) && $bStaCardShift === FALSE) {
        $tWhereStaCrdShift      = " AND CRD.FTCrdStaShift = 2 ";
        $tErrorStaCardShift     = language('document/card/docvalidate', 'tErrorStaCrdShiftWithdrawned');  // Add validate for lang (Jame) 08/01/2562
    } else {
        $tWhereStaCrdShift      = "";
    }

    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorStaCardShift . "'
                WHERE  FTCvdOldCode
                NOT IN (
                    SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM [TFNTCrdVoidTmp] CVT
                    LEFT JOIN TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdOldCode = CRD.FTCrdCode
                    WHERE 1=1 
                    AND CVT.FTSessionID  = '" . $tSessionID . "' ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereStaCrdShift;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '" . $tSessionID . "' ";

    // print_r($tSQL);
    // exit();
    $oQuery = $ci->db->query($tSQL);
    if ($ci->db->affected_rows() > 0) {
        return 1;   // ข้อมูลสถานะการถูกเบิกไม่ตรงตามเงื่อนไข
    } else {
        return 0;   // ข้อมูลสถานะการถูกเบิกตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นเช็คสถานะรหัสบัตรใหม่ Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCrdStaActiveInCard($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo  = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo  = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusActive = 1: Active , 2:InActive ,3:Cancle
    $tErrorStaCrdActive   = "";
    switch ($nCrdStaActive) {
        case '1':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '2':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdInActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '3':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdCancle');  // Add validate for lang (Jame) 08/01/2562
            break;
        default:
            $tWhereCrdStaActive =  "";
    }

    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorStaCrdActive . "'
                WHERE FTCvdNewCode
                NOT IN (
                    SELECT ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                    FROM TFNTCrdVoidTmp CVT
                    LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdNewCode = CRD.FTCrdCode
                    WHERE 1=1 
                    AND CVT.FTSessionID  = '" . $tSessionID . "' ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= $tWhereCrdStaActive;
    $tSQL   .= " ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '" . $tSessionID . "' ";

    $oQuery = $ci->db->query($tSQL);
    if ($ci->db->affected_rows() > 0) {
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    } else {
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นเช็คสถานะรหัสบัตรเก่า Active InActive Cancle
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 03/01/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkOldCrdStaActiveInCard($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID     = $paParams['tSessionID'];
    $tSeqNo         = $paParams['tSeqNo'];
    $nCrdStaActive  = $paParams['nCrdStaActive'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo  = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo  = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    // StatusActive = 1: Active , 2:InActive ,3:Cancle
    $tErrorStaCrdActive   = "";
    switch ($nCrdStaActive) {
        case '1':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 1";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '2':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 2";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdInActive');  // Add validate for lang (Jame) 08/01/2562
            break;
        case '3':
            $tWhereCrdStaActive  = " AND CRD.FTCrdStaActive = 3";
            $tErrorStaCrdActive  = language('document/card/docvalidate', 'tErrorStaCrdCancle');  // Add validate for lang (Jame) 08/01/2562
            break;
        default:
            $tWhereCrdStaActive =  "";
    }

    $tSQL   =   "   UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorStaCrdActive . "'
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
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID =  '" . $tSessionID . "' ";

    $oQuery = $ci->db->query($tSQL);
    if ($ci->db->affected_rows() > 0) {
        return 1;   // ข้อมูลสถานะไม่ตรงตามเงื่อนไข
    } else {
        return 0;   // ข้อมูลสถานะตรงตามเงื่อนไข
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสพนักงานผู้ถือบัตรของบัตรเก่าต้องตรงกับบัตรใหม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 28/12/2018 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCrdHolderID($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorCardHolderMismatch  = language('document/card/docvalidate', 'tErrorCardHolderMismatch');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorCardHolderMismatch . "'
                WHERE FNCvdSeqNo
                NOT IN (
                    SELECT A.FNCvdSeqNo
                    FROM (
                        SELECT CVT.FNCvdSeqNo,CVT.FTCvdNewCode,CRD.FTCrdHolderID
                        FROM TFNTCrdVoidTmp CVT
                        INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CVT.FTCvdNewCode
                        WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " AND CVT.FTSessionID = '" . $tSessionID . "' ) A ";
    $tSQL   .= "INNER JOIN (
                    SELECT CVT.FNCvdSeqNo,CVT.FTCvdNewCode,CVT.FTCvdOldCode,CRD.FTCrdHolderID
                    FROM TFNTCrdVoidTmp CVT
                    INNER JOIN TFNMCard CRD WITH (NOLOCK) ON CRD.FTCrdCode = CVT.FTCvdOldCode
                    WHERE 1=1 ";
    $tSQL   .= $tWhereSltSeqNo;
    $tSQL   .= " AND CVT.FTSessionID = '" . $tSessionID . "') B ";
    $tSQL   .= " ON A.FTCvdNewCode = B.FTCvdNewCode AND A.FTCrdHolderID = B.FTCrdHolderID
                 ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID = '" . $tSessionID . "' ";

    $oQuery = $ci->db->query($tSQL);
    if ($ci->db->affected_rows() > 0) {
        return 1;   // ข้อมูลรหัสพนักงานผู้ถือบัตรของบัตรเก่าต้องไม่ตรงกับบัตรใหม่
    } else {
        return 0;   // ข้อมูลรหัสพนักงานผู้ถือบัตรของบัตรเก่าต้องตรงกับบัตรใหม่
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นเช็ครหัสเหตุผลต้องมีค่าไม่เท่ากับค่าว่าง
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 07/01/2019 Wasin(Yoshi)
 * Last Modified:
 * Return: 
 * Return Type: Numeric
 */
function FSnHCrdTranfChkRsnCodeNotEmpty($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND CVT.FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorReasonNotEmpty  = language('document/card/docvalidate', 'tErrorReasonNotEmpty');  // Add validate for lang (Jame) 08/01/2562
    $tSQL   = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorReasonNotEmpty . "'
                WHERE FTCvdOldCode
                IN (
                    SELECT CVT.FTCvdOldCode
                    FROM TFNTCrdVoidTmp CVT
                    WHERE 1=1
                    AND (CVT.FTRsnCode IS NULL OR CVT.FTRsnCode = '')
                    AND (CVT.FTSessionID = '" . $tSessionID . "')
                    " . $tWhereSltSeqNo . "
                ) ";
    $tSQL  .= $tWhereUpdSeqNo;
    $tSQL  .= " AND (FTCvdStaCrd = 1 AND FTSessionID = '" . $tSessionID . "')";

    $oQuery = $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1;   // รหัสเหตุผลมีค่าเท่ากับว่าง
    } else {
        return 0;   // รหัสเหตุผลมีค่าไม่เท่ากับว่าง
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นเช็ครหัสบัตรใหม่ต้องมีค่าไม่เท่ากับค่าว่าง
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 16/12/2020 Piya
 * Last Modified:
 * Return: status
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCardCodeNotEmpty($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo = "";
    if(isset($paParams['tSeqNo']) && !empty($paParams['tSeqNo'])) {
        $tSeqNo = " AND FNCvdSeqNo = ".$paParams['tSeqNo'];
    }

    $tErrorNewCardNotEmpty  = language('document/card/docvalidate', 'tErrorNewCardNotEmpty');
    $tSQL = " 
        UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorNewCardNotEmpty . "'
        WHERE FTCvdNewCode = '' 
        AND FTSessionID = '$tSessionID'
        $tSeqNo
    ";
    $oQuery = $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1;   // รหัสบัตรใหม่มีค่าเท่ากับว่าง
    } else {
        return 0;   // รหัสบัตรใหม่มีค่าไม่เท่ากับว่าง
    }
}

/**
 * Functionality: (เอกสารเปลี่ยนบัตร) ฟังก์ชั่นตรวจสอบว่ารหัสบัตรใหม่ซ้ำกับบัตรที่ห้ามซ้ำหรือไม่
 * Parameters: Array เงื่อนไขการเช็คค่า [tSessionID]
 * Creator: 16/12/2020 Piya
 * Last Modified:
 * Return: status
 * Return Type: Numeric
 */
function FSnHCrdTranfChkNewCardNotDupInDB($paParams)
{
    $ci = &get_instance();
    $ci->load->database();

    // ============= Parameter =============
    $tSessionID = $paParams['tSessionID'];
    $tSeqNo     = $paParams['tSeqNo'];

    // Where Seq In Table Edit InLine
    if (isset($tSeqNo) && !empty($tSeqNo)) {
        $tWhereSltSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
        $tWhereUpdSeqNo = " AND FNCvdSeqNo = '" . $tSeqNo . "' ";
    } else {
        $tWhereSltSeqNo = "";
        $tWhereUpdSeqNo = "";
    }

    $tErrorNewCardIsDup  = language('document/card/docvalidate', 'tErrorNewCardIsDup');
    $tSQL = " UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = 2 , FTCvdRmk = '" . $tErrorNewCardIsDup . "'
                WHERE  FTCvdNewCode
                IN (
                    SELECT  DISTINCT C1.FTCvdNewCode FROM TFNTCrdVoidTmp C1
                    INNER JOIN(
                        SELECT FTCvdNewCode , ISNULL(CRD.FTCrdCode,CRD.FTCrdCode) AS FTCrdCode
                        FROM TFNTCrdVoidTmp CVT
                        LEFT JOIN  TFNMCard CRD WITH (NOLOCK) ON CVT.FTCvdNewCode = CRD.FTCrdCode
                        AND CRD.FTCrdHolderID <> (SELECT CRD.FTCrdHolderID FROM TFNMCard CRD WHERE CRD.FTCrdCode = CVT.FTCvdOldCode)
                        OR CRD.FTCrdCode = CVT.FTCvdOldCode
                        WHERE 1=1
                        AND CVT.FTSessionID = '" . $tSessionID . "'
                    ) C2 ON C1.FTCvdNewCode = C2.FTCrdCode
                    " . $tWhereSltSeqNo . "
                ) ";
    $tSQL   .= $tWhereUpdSeqNo;
    $tSQL   .= " AND FTCvdStaCrd = 1 AND FTSessionID = '" . $tSessionID . "' ";

    $oQuery  = $ci->db->query($tSQL);

    if ($ci->db->affected_rows() > 0) {
        return 1;   // รหัสบัตรใหม่ซ้ำกับบัตรอื่น หรือซ้ำกับบัตรที่จะเปลี่ยน
    } else {
        return 0;   // ไม่ซ้ำ
    }
}
