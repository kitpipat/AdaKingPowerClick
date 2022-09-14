<?php

/**
 * Functionality : Insert Helper Center
 * Parameters : $ptDocType, $ptDataSetType, $paDataExcel, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Status
 * Return Type : array
 */
function FCNaCARDInsertDataToTemp($ptDocType, $ptDataSetType, $paDataExcel, $paDataSet)
{

    // echo $ci->session->userdata("tSesSessionID");
    // ptDocType     = ชื่อหน้า
    // ptDataSetType = ชื่อ sheet 
    // paDataExcel   = data array excel
    // paDataSet     = xxx

    require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php');
    require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php');
    require_once(APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php');

    switch ($ptDataSetType) {
        case 'Excel': { // Excel - เหตุผล - option - มูลค่าที่เติม 
                FSaCCARTypeExcel($ptDocType, $ptDataSetType, $paDataExcel);
                break;
            }
        case 'CreateCard': { // New Card - รหัสบัตร - ประเภทบัตร - หน่วยงาน
                FSxInsertNewCardByCardCode($ptDataSetType, $paDataSet);
                break;
            }
        case 'CreateCardBetween': { // New Card Between - การ์ดโค๊ด - prefix - เลขเริ่มต้น - จำนวนที่ต้องการสร้างบัตร - ประเภทบัตร - หน่วยงาน
                FSxInsertNewCardByBetween($ptDataSetType, $paDataSet);
                break;
            }
        case 'Between': { // Between - มูลค่าที่เติม - ประเภทบัตรแบบช่วง - การ์ดรหัสแบบช่วง
                FSxInsertByBetween($ptDocType, $ptDataSetType, $paDataSet);
                break;
            }
        case 'ChooseCard': { // Chooset Card - รหัสบัตร - มูลค่า - รหัสบัตรใหม่(อาจเป็นค่าว่าง) 
                FSxInsertByChoose($ptDocType, $ptDataSetType, $paDataSet);
                break;
            }
    }
}

/**
 * Functionality : Insert new card by card code
 * Parameters : $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertNewCardByCardCode($ptDataSetType, $paDataSet)
{
    $ci = &get_instance();
    $ci->load->database();

    $tBchCode = $paDataSet["tBchCode"];
    $tDocNo = $paDataSet["tDocNo"];
    $tNewCardCode = $paDataSet["tNewCardCode"];
    $tCardTypeCode = $paDataSet["tCardTypeCode"];
    $tDptCode = $paDataSet['tDptCode'];
    $tDptName = $paDataSet['tDptName'];
    $tCreateOn = date("Y-m-d H:i:s");
    $tCreateBy = $paDataSet["tCreateBy"];
    $tSessionID = $ci->session->userdata("tSesSessionID");

    $tSQL = "
        INSERT INTO TFNTCrdImpTmp(
            FTBchCode, 
            FTCihDocNo, 
            FNCidSeqNo, 
            FTCidCrdCode, 
            FCCvdOldBal, 
            FTCidCrdRef, 
            FTCtyCode, 
            FTCidCrdName, 
            FTCidCrdHolderID, 
            FTCidCrdDepart, 
            FTCidStaCrd, 
            FTCidStaPrc, 
            FTCidRmk, 
            FDCreateOn, 
            FTCreateBy, 
            FTSessionID)
        VALUES (
            '$tBchCode', 
            '$tDocNo',
            (SELECT ISNULL(MAX(FNCidSeqNo), 0) FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID') + 1,
            '$tNewCardCode',
            null,
            null,
            '$tCardTypeCode',
            null,
            null,
            '$tDptName',
            '1',
            null,
            null,
            '$tCreateOn',
            '$tCreateBy',
            '$tSessionID'
        )
    ";

    $ci->db->query($tSQL);
}

/**
 * Functionality : Insert new card by between
 * Parameters : $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertNewCardByBetween($ptDataSetType, $paDataSet)
{
    $ci = &get_instance();
    $ci->load->database();

    $tBchCode = $paDataSet["tBchCode"];
    $tDocNo = $paDataSet["tDocNo"];
    $tPrefixCode = $paDataSet["tPrefixCode"];
    $tBeginCode = $paDataSet["tBeginCode"];
    $nCardLoop = $paDataSet["nCardLoop"];
    $tCardTypeCode = $paDataSet["tCardTypeCode"];
    $tDptCode = $paDataSet['tDptCode'];
    $tDptName = $paDataSet['tDptName'];
    $tCreateOn = date("Y-m-d H:i:s");
    $tCreateBy = $paDataSet["tCreateBy"];
    $tSessionID = $ci->session->userdata("tSesSessionID");

    $nBeginNumber = $tBeginCode;
    $nBeginNumberLength = strlen($tBeginCode);

    $tSQL = "
        INSERT INTO TFNTCrdImpTmp(
            FTBchCode, 
            FTCihDocNo, 
            FNCidSeqNo, 
            FTCidCrdCode, 
            FCCvdOldBal, 
            FTCidCrdRef, 
            FTCtyCode, 
            FTCidCrdName, 
            FTCidCrdHolderID, 
            FTCidCrdDepart, 
            FTCidStaCrd, 
            FTCidStaPrc, 
            FTCidRmk, 
            FDCreateOn, 
            FTCreateBy, 
            FTSessionID
        ) 
        VALUES 
    ";

    $tPrefix = $tPrefixCode;
    $tComma = ",";

    for ($nLoop = 0; $nLoop < $nCardLoop; $nLoop++) {

        $nPreZero = str_pad($nBeginNumber, $nBeginNumberLength, "0", STR_PAD_LEFT);
        $tNewCardCode = $tPrefix . $nPreZero;

        $nBeginNumber++;
        if (($nLoop + 1) == $nCardLoop) {
            $tComma = "";
        } // Last loop check

        $tSQL .= "(
                '$tBchCode', 
                '$tDocNo',
                ($nLoop + 1) + (SELECT ISNULL(MAX(FNCidSeqNo), 0) FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID'),
                '$tNewCardCode',
                null,
                null,
                '$tCardTypeCode',
                null,
                null,
                '$tDptName',
                '1',
                null,
                null,
                '$tCreateOn',
                '$tCreateBy',
                '$tSessionID'
            )$tComma ";
    }
    // $tSQL .= " WHERE FTCidCrdCode NOT EXISTS ( SELECT FTCidCrdCode FROM TFNTCrdImpTmp WHERE FTSessionID = '$tSessionID' ) ";
    $ci->db->query($tSQL);
}

/**
 * Functionality : Insert card to temp by between
 * Parameters : $ptDocType, $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertByBetween($ptDocType, $ptDataSetType, $paDataSet)
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");

    switch ($ptDocType) {
        case 'cardShiftOut': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tWhereCardCode = "";
                $tWhereCardType = "";

                if (!empty($paDataSet["aCardCode"])) {
                    $tCardCodeFrom = $paDataSet["aCardCode"][0];
                    $tCardCodeTo = $paDataSet["aCardCode"][1];
                    $tWhereCardCode = " AND ((CRD.FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (CRD.FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
                }
                if (!empty($paDataSet["aCardType"])) {
                    $tCardTypeFrom = $paDataSet["aCardType"][0];
                    $tCardTypeTo = $paDataSet["aCardType"][1];
                    $tWhereCardType = " AND ((CRD.FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (CRD.FTCrdCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode,
                        ((CRD.CashIn + CRD.Promotion) - CRD.Payment ) AS FCXsdCardBal,
                        /*((CRD.CashIn + Promotion) - CRD.DepositCrd - CRD.Payment) AS TotalUse, 
                        CRD.DepositCrd AS TotalDepositCrd,*/
                        '1' AS FTXsdStaCrd,
                        null AS FTXsdStaPrc,
                        null AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                        WHERE 1=1 
                        AND ( ( (CRDT.FTCtyStaShift = '1') AND (CRD.FTCrdStaShift = '1') ) AND (CRD.FTCrdStaActive = '1') AND (CONVERT(datetime, CRD.FDCrdExpireDate) > CONVERT(datetime, GETDATE())) )
                        AND ( CRD.FTCrdCode NOT IN (SELECT TMP.FTCrdCode FROM TFNTCrdShiftTmp TMP WITH(NOLOCK) WHERE TMP.FTSessionID = '$tSessionID') )
                        $tWhereCardCode 
                        $tWhereCardType
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftReturn': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tWhereCardCode = "";
                $tWhereCardType = "";

                if (!empty($paDataSet["aCardCode"])) {
                    $tCardCodeFrom = $paDataSet["aCardCode"][0];
                    $tCardCodeTo = $paDataSet["aCardCode"][1];
                    $tWhereCardCode = " AND ((CRD.FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (CRD.FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
                }
                if (!empty($paDataSet["aCardType"])) {
                    $tCardTypeFrom = $paDataSet["aCardType"][0];
                    $tCardTypeTo = $paDataSet["aCardType"][1];
                    $tWhereCardType = " AND ((CRD.FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (CRD.FTCtyCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        ((CRD.CashIn + CRD.Promotion ) - CRD.Payment ) AS FCXsdCardBal,
                        /*((CRD.CashIn + Promotion ) - CRD.DepositCrd - CRD.Payment  ) AS TotalUse, 
                        CRD.DepositCrd AS TotalDepositCrd,*/
                        '1' AS FTXsdStaCrd,
                        null AS FTXsdStaPrc,
                        null AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                            FROM TFNMCard CRD WITH (NOLOCK) 
                            LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                            LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                            WHERE 1=1 
                            AND ( ((CRDT.FTCtyStaShift = '1') AND (CRD.FTCrdStaShift = '2')) )
                            AND ( CRD.FTCrdCode NOT IN (SELECT TMP.FTCrdCode FROM TFNTCrdShiftTmp TMP WITH(NOLOCK) WHERE TMP.FTSessionID = '$tSessionID') )
                            $tWhereCardCode 
                            $tWhereCardType
                            GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftTopUp': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCtdCrdTP = $paDataSet["tCtdCrdTP"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tWhereCardCode = "";
                $tWhereCardType = "";

                if (!empty($paDataSet["aCardCode"])) {
                    $tCardCodeFrom = $paDataSet["aCardCode"][0];
                    $tCardCodeTo = $paDataSet["aCardCode"][1];
                    $tWhereCardCode = " AND ((CRD.FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (CRD.FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom'))";
                }
                if (!empty($paDataSet["aCardType"])) {
                    $tCardTypeFrom = $paDataSet["aCardType"][0];
                    $tCardTypeTo = $paDataSet["aCardType"][1];
                    $tWhereCardType = " AND ((CRD.FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (CRD.FTCtyCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom'))";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY  CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode,
                        CONVERT(DECIMAL(18,4),REPLACE(ISNULL('$tCtdCrdTP', 0), ',', '')) AS FCXsdAmt,
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardType CRDT ON CRDT.FTCtyCode = CRD.FTCtyCode
                        --LEFT JOIN
                        WHERE 1=1 
                        AND ( CRD.FTCrdStaActive = 1 AND ((CRD.FTCrdStaShift = 2 AND CRDT.FTCtyStaShift = 1) OR CRDT.FTCtyStaShift = 2 ) AND ( CONVERT(datetime, CRD.FDCrdExpireDate) > CONVERT(datetime, GETDATE()) ) )
                        AND ( CRD.FTCrdCode NOT IN (SELECT TMP.FTCrdCode FROM TFNTCrdTopUpTmp TMP WITH(NOLOCK) WHERE FTSessionID = '$tSessionID') )
                        $tWhereCardCode 
                        $tWhereCardType
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftRefund': {
                $tBchCode       = $paDataSet["tBchCode"];
                $tCreateOn      = date("Y-m-d H:i:s");
                $tCreateBy      = $paDataSet["tCreateBy"];
                $tDocNo         = $paDataSet["tDocNo"];

                $tAgnCode       = $_SESSION["tSesUsrAgnCode"];
                $tSesUsrLevel   = $_SESSION["tSesUsrLevel"];

                $tWhereCardCode = "";
                $tWhereCardType = "";

                if( $tSesUsrLevel != "HQ" && $tAgnCode != "" ){
                    $tWhereCardCode .= " AND CRD.FTAgnCode = '".$tAgnCode."' ";
                }

                if (!empty($paDataSet["aCardCode"])) {
                    $tCardCodeFrom = $paDataSet["aCardCode"][0];
                    $tCardCodeTo = $paDataSet["aCardCode"][1];
                    $tWhereCardCode .= " AND ((CRD.FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (CRD.FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom'))";
                }
                if (!empty($paDataSet["aCardType"])) {
                    $tCardTypeFrom = $paDataSet["aCardType"][0];
                    $tCardTypeTo = $paDataSet["aCardType"][1];
                    $tWhereCardType .= " AND ((CRD.FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (CRD.FTCtyCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom'))";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        ISNULL(dbo.F_GETnCardCheckout(CRD.FTCrdCode),0) AS FCXsdAmt,
                        /*CASE
                            WHEN CRD.FTCtyStaPay = '2'
                            THEN 
                                CASE /* Post Paid */
                                    WHEN CRD.NotReturn > CRD.Payment
                                    THEN (CRD.NotReturn - CRD.Payment) + CRD.Payment - CRD.Promotion
                                    ELSE CRD.Payment - CRD.Promotion
                                END
                            ELSE 
                                CASE /* Pre Paid */
                                    WHEN CRD.NotReturn > CRD.Payment
                                    THEN CRD.CashIn + CRD.Promotion - (CRD.NotReturn - CRD.Payment) + CRD.Payment
                                    ELSE CRD.CashIn + CRD.Promotion - CRD.Payment
                                END
                        END AS FCXsdAmt,*/
                        /*(CASE 
                            WHEN ((CRD.CashIn + CRD.Promotion) - (CRD.Payment + CRD.NotReturn)) < 0 THEN 0
                            ELSE ((CRD.CashIn + CRD.Promotion) - (CRD.Payment + CRD.NotReturn))
                        END) AS FCXsdAmt,*/
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            CRDT.FTCtyStaPay,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        LEFT JOIN TFNMCardType CRDT WITH(NOLOCK) ON CRDT.FTCtyCode = CRD.FTCtyCode
                        WHERE 1=1 
                        AND ( 
                            (CRD.FTCrdStaActive = '1') AND (CRD.FTCrdStaShift = '2')
                            AND (CRD.FTCrdCode NOT IN (SELECT FTCrdCode FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID')) 
                        )
                        AND CONVERT(VARCHAR,CRD.FDCrdExpireDate, 111) >= CONVERT(VARCHAR,GETDATE(), 111)
                        $tWhereCardCode 
                        $tWhereCardType
                        GROUP BY CRD.FTCrdCode,CRDT.FTCtyStaPay
                    ) CRD
                    WHERE 1=1
                    --AND (/*Bal-->*/((CRD.CashIn + CRD.Promotion) - (CRD.Payment + CRD.NotReturn) )/*<--Bal*/ > 0 AND /*Bal-->*/((CashIn + Promotion) - (CRD.Payment + CRD.NotReturn) )/*<--Bal*/ IS NOT NULL)
                ";
                // echo $tSQL;
                // exit();
                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftStatus': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tWhereCardCode = "";
                $tWhereCardType = "";

                if (!empty($paDataSet["aCardCode"])) {
                    $tCardCodeFrom = $paDataSet["aCardCode"][0];
                    $tCardCodeTo = $paDataSet["aCardCode"][1];
                    $tWhereCardCode = " AND ((CRD.FTCrdCode BETWEEN '$tCardCodeFrom' AND '$tCardCodeTo') OR (CRD.FTCrdCode BETWEEN '$tCardCodeTo' AND '$tCardCodeFrom')) ";
                }
                if (!empty($paDataSet["aCardType"])) {
                    $tCardTypeFrom = $paDataSet["aCardType"][0];
                    $tCardTypeTo = $paDataSet["aCardType"][1];
                    $tWhereCardType = " AND ((CRD.FTCtyCode BETWEEN '$tCardTypeFrom' AND '$tCardTypeTo') OR (CRD.FTCtyCode BETWEEN '$tCardTypeTo' AND '$tCardTypeFrom')) ";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTCvhDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                        CRD.FTCrdCode AS FTCvdOldCode,
                        ((CRD.CashIn + CRD.Promotion) - CRD.Payment ) AS FCCvdOldBal,
                        NULL AS FTCvdNewCode,
                        '1' AS FTCvdStaCrd,
                        NULL AS FTCvdStaPrc,
                        NULL AS FTCvdRmk,
                        NULL AS FTRsnCode,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE 1=1
                        AND ( CRD.FTCrdCode NOT IN (SELECT TMP.FTCvdOldCode FROM TFNTCrdVoidTmp TMP WITH (NOLOCK) WHERE FTSessionID = '$tSessionID') )
                        $tWhereCardCode 
                        $tWhereCardType
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftChange': {
                $aCardNewAndOld = $paDataSet["aCardNewAndOld"];
                $tBchCode = $paDataSet["tBchCode"];
                $tCvdOldCode = implode(",", $paDataSet["aOldCardCode"]);
                $tCvdNewCode = implode(",", $paDataSet["aNewCardCode"]);
                $tRsnCode = $paDataSet["tReasonCode"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];
                $tSessionID = $ci->session->userdata("tSesSessionID");

                $tSQL = "";
                foreach($aCardNewAndOld as $aItem){
                    $tCardOldCode = $aItem['old'];
                    $tCardNewCodeWhereIn = $aItem['new'];
                    $tCardNewCode = str_replace("'","",$aItem['new']);

                    $tSQL .= "
                        INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)

                        SELECT 
                            '$tBchCode' AS FTBchCode,
                            '$tDocNo' AS FTCvhDocNo,
                            ROW_NUMBER() OVER(ORDER BY OLDCRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                            OLDCRD.FTCrdCode AS FTCvdOldCode,
                            OLDCRD.FCCrdValue AS FCCvdOldBal,
                            (
                                CASE
                                    WHEN (NEWCRD.FTCrdCode IS NULL) OR (NEWCRD.FTCrdCode = '') THEN '$tCardNewCode'
                                    ELSE NEWCRD.FTCrdCode
                                END
                            ) AS FTCvdNewCode,
                            /*NEWCRD.FTCrdCode AS FTCvdNewCode,*/
                            '1' AS FTCvdStaCrd,
                            NULL AS FTCvdStaPrc,
                            NULL AS FTCvdRmk,
                            '$tRsnCode' AS FTRsnCode,
                            '$tCreateOn' AS FDLastUpdOn,
                            '$tCreateBy' AS FTLastUpdBy,
                            '$tCreateOn' AS FDCreateOn,
                            '$tCreateBy' AS FTCreateBy,
                            '$tSessionID' AS FTSessionID
                        FROM(
                            SELECT
                                CRD.FTCrdCode,
                                CRD.FTCrdHolderID,
                                /*Bal-->*/((CRD.CashIn + CRD.Promotion) - CRD.Payment )/*<--Bal*/ AS FCCrdValue
                            FROM(
                                SELECT
                                    CRD.FTCrdCode,
                                    CRD.FTCrdHolderID,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) CashIn ,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) Promotion ,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) DepositCrd ,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) DepositPdt ,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) NotReturn ,
                                    SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                                    THEN ISNULL(CRDB.FCCrdValue,0)
                                    ELSE 0
                                    END) Payment
                                FROM TFNMCard CRD WITH (NOLOCK) 
                                LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                                WHERE CRD.FTCrdCode IN ($tCardOldCode)
                                GROUP BY CRD.FTCrdCode, CRD.FTCrdHolderID
                            ) CRD
                        ) OLDCRD
                        LEFT JOIN (
                            SELECT 
                                FTCrdCode, 
                                FTCrdHolderID 
                            FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCardNewCodeWhereIn)
                        ) NEWCRD
                        ON OLDCRD.FTCrdHolderID = NEWCRD.FTCrdHolderID 
                    ";
                }

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
    }
}

/**
 * Functionality : Insert card to temp by choose
 * Parameters : $ptDocType, $ptDataSetType, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxInsertByChoose($ptDocType, $ptDataSetType, $paDataSet)
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");

    switch ($ptDocType) {
        case 'cardShiftOut': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCrdCode = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        ((CRD.CashIn + CRD.Promotion ) - CRD.Payment ) AS FCXsdCardBal,
                        /*((CRD.CashIn + Promotion ) - CRD.DepositCrd - CRD.Payment  ) AS TotalUse, 
                        CRD.DepositCrd AS TotalDepositCrd,*/
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment

                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode IN ($tCrdCode)
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftReturn': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCrdCode = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdShiftTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        ((CRD.CashIn + CRD.Promotion ) - CRD.Payment ) AS FCXsdCardBal,
                        /*((CRD.CashIn + Promotion ) - CRD.DepositCrd - CRD.Payment  ) AS TotalUse, 
                        CRD.DepositCrd AS TotalDepositCrd,*/
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode IN ($tCrdCode)
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftTopUp': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCtdCrdTP = $paDataSet["tCtdCrdTP"];
                $tCrdCode = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FCXsdAmtPmt, FTPmhDocNo, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNXsdSeqNo), 0) FROM TFNTCrdTopUpTmp WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode AS FTCrdCode,
                        CONVERT(DECIMAL(18,4),REPLACE(ISNULL('$tCtdCrdTP', 0), ',', '')) AS FCXsdAmt,
                        0 AS FCXsdAmtPmt,
                        '' AS FTPmhDocNo,
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            FTCrdCode
                        FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCrdCode)
                        --LEFT JOIN 
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftRefund': {
                $tBchCode           = $paDataSet["tBchCode"];
                $tCrdCode           = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn          = date("Y-m-d H:i:s");
                $tCreateBy          = $paDataSet["tCreateBy"];
                $tDocNo             = $paDataSet["tDocNo"];

                $tAgnCode           = $_SESSION["tSesUsrAgnCode"];
                $tSesUsrLevel       = $_SESSION["tSesUsrLevel"];
                $tWhereCondition    = "";

                $tWhereCondition .= " AND CRD.FTCrdCode IN ($tCrdCode) ";

                if( $tSesUsrLevel != "HQ" && $tAgnCode != "" ){
                    $tWhereCondition .= " AND CRD.FTAgnCode = '".$tAgnCode."' ";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp(FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTXshDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(TMP.FNXsdSeqNo), 0) FROM TFNTCrdTopUpTmp TMP WITH (NOLOCK) WHERE FTSessionID = '$tSessionID') AS FNXsdSeqNo,
                        CRD.FTCrdCode,
                        ISNULL(dbo.F_GETnCardCheckout(CRD.FTCrdCode), 0) AS FCXsdAmt,
                        /*(CASE 
                            WHEN ((CRD.CashIn + CRD.Promotion) - (CRD.Payment + CRD.NotReturn)) < 0 THEN 0
                            ELSE ((CRD.CashIn + CRD.Promotion) - (CRD.Payment + CRD.NotReturn))
                        END) AS FCXsdAmt,*/
                        '1' AS FTXsdStaCrd,
                        NULL AS FTXsdStaPrc,
                        NULL AS FTXsdRmk,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE 1=1
                        $tWhereCondition
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";
                // echo $tSQL;
                // exit();
                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftStatus': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCvdOldCode = implode(",", $paDataSet["aCardCode"]);
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tSQL = "
                    INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTCvhDocNo,
                        ROW_NUMBER() OVER(ORDER BY CRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                        CRD.FTCrdCode AS FTCvdOldCode,
                        ((CRD.CashIn + CRD.Promotion) - CRD.Payment ) AS FCCvdOldBal,
                        NULL AS FTCvdNewCode,
                        '1' AS FTCvdStaCrd,
                        NULL AS FTCvdStaPrc,
                        NULL AS FTCvdRmk,
                        NULL AS FTRsnCode,
                        '$tCreateOn' AS FDLastUpdOn,
                        '$tCreateBy' AS FTLastUpdBy,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode IN ($tCvdOldCode)
                        GROUP BY CRD.FTCrdCode
                    ) CRD
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftChange': {
                $tBchCode = $paDataSet["tBchCode"];
                $tCvdOldCode = implode(",", $paDataSet["aOldCardCode"]);
                $tCvdNewCode = implode(",", $paDataSet["aNewCardCode"]);
                $tRsnCode = $paDataSet["tReasonCode"];
                $tCreateOn = date("Y-m-d H:i:s");
                $tCreateBy = $paDataSet["tCreateBy"];
                $tDocNo = $paDataSet["tDocNo"];

                $tSQL = "
                    INSERT INTO TFNTCrdVoidTmp(FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        '$tBchCode' AS FTBchCode,
                        '$tDocNo' AS FTCvhDocNo,
                        ROW_NUMBER() OVER(ORDER BY OLDCRD.FTCrdCode ASC) + (SELECT ISNULL(MAX(FNCvdSeqNo), 0) FROM TFNTCrdVoidTmp WHERE FTSessionID = '$tSessionID') AS FNCvdSeqNo,
                        OLDCRD.FTCrdCode AS FTCvdOldCode,
                        OLDCRD.FCCrdValue AS FCCvdOldBal,
                        NEWCRD.FTCrdCode AS FTCvdNewCode,
                        '1' AS FTCvdStaCrd,
                        NULL AS FTCvdStaPrc,
                        NULL AS FTCvdRmk,
                        '$tRsnCode' AS FTRsnCode,
                        '$tCreateOn' AS FDCreateOn,
                        '$tCreateBy' AS FTCreateBy,
                        '$tSessionID' AS FTSessionID
                    FROM(
                        SELECT
                            CRD.FTCrdCode,
                            CRD.FTCrdHolderID,
                            /*Bal-->*/((CRD.CashIn + CRD.Promotion) - CRD.Payment )/*<--Bal*/ AS FCCrdValue
                        FROM(
                            SELECT
                                CRD.FTCrdCode,
                                CRD.FTCrdHolderID,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) CashIn ,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) Promotion ,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) DepositCrd ,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) DepositPdt ,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) NotReturn ,
                                SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                                THEN ISNULL(CRDB.FCCrdValue,0)
                                ELSE 0
                                END) Payment
                            FROM TFNMCard CRD WITH (NOLOCK) 
                            LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                            WHERE CRD.FTCrdCode IN ($tCvdOldCode)
                            GROUP BY CRD.FTCrdCode, CRD.FTCrdHolderID
                        ) CRD
                    ) OLDCRD
                    LEFT JOIN (
                        SELECT 
                            FTCrdCode, 
                            FTCrdHolderID 
                        FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode IN ($tCvdNewCode)
                    ) NEWCRD
                    ON OLDCRD.FTCrdHolderID = NEWCRD.FTCrdHolderID
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
    }
}

/**
 * Functionality : Update card in temp by sequence
 * Parameters : $ptDocType, $pnSeq, $paDataSet
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function FSxUpdateTempBySeq($ptDocType, $pnSeq, $paDataSet)
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $tUpdateOn = date("Y-m-d H:i:s");

    switch ($ptDocType) {
        case 'cardShiftNewCard': {
                $tCrdCode = $paDataSet["tNewCardCode"];
                $tCrdHolderID = $paDataSet["tHolderID"];
                $tCrdName = $paDataSet["tNewCardName"];
                $tCrdTypeCode = $paDataSet["tCardTypeCode"];
                $tDptCode = $paDataSet["tDptCode"];
                $tDptName = $paDataSet["tDptName"];
                $tCrdShiftNewRmk = $paDataSet["tCrdShiftNewRmk"];

                $tSQL = "
                    UPDATE TFNTCrdImpTmp SET FTCidStaCrd = '1', FTCidCrdCode = '$tCrdCode', FTCidRmk = '$tCrdShiftNewRmk', FTCidCrdName = '$tCrdName', FTCidCrdHolderID = '$tCrdHolderID', FTCtyCode = '$tCrdTypeCode', FTCidCrdDepart = '$tDptName', FDCreateOn = '$tUpdateOn' 
                    WHERE FNCidSeqNo = $pnSeq AND FTSessionID = '$tSessionID'
                ";

                $oQuery = $ci->db->query($tSQL);

                break;
            }
        case 'cardShiftClearCard': {
                $tCrdCode = $paDataSet["tNewCardCode"];

                $tSQL = "
                    UPDATE TFNTCrdImpTmp SET FTCidStaCrd = '1', FTCidCrdCode = '$tCrdCode' , FTCidRmk = null, FDCreateOn = '$tUpdateOn' 
                    WHERE FNCidSeqNo = $pnSeq AND FTSessionID = '$tSessionID'
                ";

                $oQuery = $ci->db->query($tSQL);

                break;
            }
        case 'cardShiftOut': {
                $tCrdCode = $paDataSet["tCardCode"];
                $tRmk = $paDataSet['tRmk'];

                $tSQL = "
                    UPDATE TFNTCrdShiftTmp SET FTXsdStaCrd = '1', FTCrdCode = '$tCrdCode', FTXsdRmk = '$tRmk', FCXsdCardBal = ISNULL(((CRD.CashIn + CRD.Promotion ) - CRD.Payment), 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (
                        SELECT 
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment 
                        FROM TFNMCard CRD WITH (NOLOCK)
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode = '$tCrdCode'
                        GROUP BY CRD.FTCrdCode
                    ) AS CRD 
                    WHERE FNXsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'
                ";

                $oQuery = $ci->db->query($tSQL);

                break;
            }
        case 'cardShiftReturn': {
                $tCrdCode = $paDataSet["tCardCode"];
                $tRmk = $paDataSet['tRmk'];

                $tSQL = "
                    UPDATE TFNTCrdShiftTmp SET FTXsdStaCrd = '1', FTCrdCode = '$tCrdCode', FTXsdRmk = '$tRmk', FCXsdCardBal = ISNULL(((CRD.CashIn + CRD.Promotion ) - CRD.Payment), 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (
                        SELECT 
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode = '$tCrdCode'
                        GROUP BY CRD.FTCrdCode
                    ) AS CRD 
                    WHERE FNXsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";

                $oQuery = $ci->db->query($tSQL);

                break;
            }
        case 'cardShiftTopUp': {
                $tCrdCode = $paDataSet["tCardCode"];
                $nValue = empty($paDataSet["nValue"]) ? 0.00 : $paDataSet["nValue"];
                $tRmk = $paDataSet['tRmk'];

                $tSQL = "
                    UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '1', FTCrdCode = '$tCrdCode', FTXsdRmk = '$tRmk', FCXsdAmt = CONVERT(DECIMAL(18,4),REPLACE('$nValue', ',', '')), FDLastUpdOn = '$tUpdateOn'
                    WHERE FNXsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'
                ";

                $ci->db->query($tSQL);

                $tSQL = "
                    SELECT 
                        FTBchCode,
                        FTXshDocNo,
                        SUM(ISNULL(FCXsdAmt,0)) AS FCXshTotal
                    FROM TFNTCrdTopUpTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tSessionID'
                    GROUP BY FTBchCode, FTXshDocNo, FTSessionID
                ";

                $oQuery = $ci->db->query($tSQL);

                return $oQuery->result_array();

                break;
            }
        case 'cardShiftRefund': {
                $tCrdCode = $paDataSet["tCardCode"];
                $tCrdValue = empty($paDataSet["tCardValue"]) ? 0.00 : $paDataSet["tCardValue"];
                $tRmk = $paDataSet['tRmk'];

                /*$tSQL = "UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '1', FTCrdCode = '$tCrdCode', FTXsdRmk = null, FCXsdAmt = ISNULL($tCrdValue, 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (SELECT FCCrdValue FROM TFNMCard WITH (NOLOCK) WHERE FTCrdCode = '$tCrdCode') AS CRD 
                    WHERE FNXsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";*/

                $tSQL = "
                    UPDATE TFNTCrdTopUpTmp SET FTXsdStaCrd = '1', FTCrdCode = '$tCrdCode', FTXsdRmk = '$tRmk', FCXsdAmt = CONVERT(DECIMAL(18,4),REPLACE('$tCrdValue', ',', '')), FDLastUpdOn = '$tUpdateOn'
                    WHERE FNXsdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftStatus': {
                $tCvdCode = $paDataSet["tCardCode"];
                $tRmk =  $paDataSet['tRmk'];

                $tSQL = "
                    UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '1', FTCvdOldCode = '$tCvdCode', FTCvdRmk = '$tRmk', FCCvdOldBal = ISNULL(((CRD.CashIn + CRD.Promotion) - CRD.Payment), 0), FDLastUpdOn = '$tUpdateOn'
                    FROM (
                        SELECT 
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment 
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode = '$tCvdCode'
                        GROUP BY CRD.FTCrdCode
                    ) AS CRD 
                    WHERE FNCvdSeqNo = $pnSeq 
                    AND FTSessionID = '$tSessionID'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftChange': {
                $tCvdOldCode = $paDataSet["tOldCardCode"];
                $tCvdNewCode = $paDataSet["tNewCardCode"];
                $tRsnCode = $paDataSet["tReasonCode"];
                $tRmk =  $paDataSet['tRmk'];

                $tSQL = "
                    UPDATE TFNTCrdVoidTmp SET FTCvdStaCrd = '1', FTCvdOldCode = '$tCvdOldCode', FTCvdRmk = '$tRmk', FTCvdNewCode = '$tCvdNewCode', FTRsnCode = '$tRsnCode', FCCvdOldBal = ISNULL(((CRD.CashIn + CRD.Promotion) - CRD.Payment), 0), FDLastUpdOn = '$tUpdateOn'
                    
                    FROM (
                        SELECT 
                            CRD.FTCrdCode,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='001'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) CashIn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='002'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Promotion ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='003'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositCrd ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='004'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) DepositPdt ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='005'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) NotReturn ,
                            SUM(CASE WHEN CRDB.FTCrdTxnCode='006'
                            THEN ISNULL(CRDB.FCCrdValue,0)
                            ELSE 0
                            END) Payment 
                        FROM TFNMCard CRD WITH (NOLOCK) 
                        LEFT JOIN TFNMCardBal CRDB WITH(NOLOCK) ON CRDB.FTCrdCode = CRD.FTCrdCode
                        WHERE CRD.FTCrdCode = '$tCvdOldCode'
                        GROUP BY CRD.FTCrdCode
                    ) CRD 
                    WHERE FNCvdSeqNo = $pnSeq AND FTSessionID = '$tSessionID'";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
    }
}

/**
 * Functionality : Select all data in document temp by session id
 * Parameters : $ptDocType
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSaSelectAllBySessionID($ptDocType)
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");

    switch ($ptDocType) {
        case 'cardShiftNewCard': {
                $tSQL = "
                    SELECT 
                        CRD.FTCidCrdCode,
                        CRD.FNCidSeqNo,
                        CRD.FTCtyCode,
                        CRD.FTCidCrdName,
                        CRD.FTCidCrdDepart
                    FROM TFNTCrdImpTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftOut': {
                $tSQL = "
                    SELECT 
                        CRD.FTCrdCode,
                        CRD.FNXsdSeqNo,
                        CRD.FTXsdStaCrd,
                        CRD.FTXsdStaPrc
                    FROM TFNTCrdShiftTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftReturn': {
                $tSQL = "
                    SELECT 
                        CRD.FTCrdCode,
                        CRD.FNXsdSeqNo,
                        CRD.FTXsdStaCrd,
                        CRD.FTXsdStaPrc
                    FROM TFNTCrdShiftTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftTopUp': {
                $tSQL = "
                    SELECT 
                        CRD.FTCrdCode,
                        CRD.FNXsdSeqNo
                    FROM TFNTCrdTopUpTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftRefund': {
                $tSQL = "
                    SELECT 
                        CRD.FTCrdCode,
                        CRD.FNXsdSeqNo
                    FROM TFNTCrdTopUpTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftStatus': {
                $tSQL = "
                    SELECT CRD.FTCvdOldCode,
                        CRD.FNCvdSeqNo,
                        CRD.FTCvdStaCrd,
                        CRD.FTCvdStaPrc,
                        CRD.FTCvdRmk
                    FROM TFNTCrdVoidTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
        case 'cardShiftChange': {
                $tSQL = "
                    SELECT CRD.FTCvdOldCode,
                        CRD.FTCvdNewCode,
                        CRD.FNCvdSeqNo,
                        CRD.FCCvdOldBal,
                        CRD.FTRsnCode,
                        CRD.FTCvdStaCrd,
                        CRD.FTCvdStaPrc,
                        CRD.FTCvdRmk
                    FROM TFNTCrdVoidTmp CRD
                    WHERE CRD.FTSessionID = '$tSessionID' 
                    AND 1 = 1
                ";

                $oQuery = $ci->db->query($tSQL);
                break;
            }
    }

    if ($oQuery->num_rows() > 0) {
        $aList = $oQuery->result();

        $aResult = array(
            'raItems' => $aList,
            'rnAllRow' => $oQuery->num_rows(),
            'rtCode' => '1',
            'rtDesc' => 'success'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
    } else {
        //No Data
        $aResult = array(
            'raItems' => [],
            'rnAllRow' => 0,
            'rtCode' => '800',
            'rtDesc' => 'data not found'
        );
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
    }
    return $aResult;
}

/**
 * Functionality : Copy card data in temp to DT
 * Parameters : $ptDocType
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSxDocHelperTempToDT($ptDocType, $paParams = [])
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $nLngID = $ci->session->userdata("tLangEdit");

    $bIsImport = isset($paParams['isImport'])?$paParams['isImport']:false;

    switch ($ptDocType) {
        case 'cardShiftNewCard': {

                $tSQL = "
                    INSERT INTO TFNTCrdImpDT (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        IMPT.FTBchCode, 
                        IMPT.FTCihDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  IMPT.FNCidSeqNo ASC) AS FNCidSeqNo, 
                        IMPT.FTCidCrdCode, 
                        IMPT.FCCvdOldBal, 
                        IMPT.FTCidCrdRef, 
                        IMPT.FTCtyCode, 
                        IMPT.FTCidCrdName, 
                        IMPT.FTCidCrdHolderID, 
                        DPTL.FTDptCode AS FTCidCrdDepart, 
                        IMPT.FTCidStaCrd, 
                        IMPT.FTCidStaPrc, 
                        IMPT.FTCidRmk, 
                        IMPT.FDCreateOn, 
                        IMPT.FTCreateBy
                    FROM TFNTCrdImpTmp IMPT WITH (NOLOCK)
                    LEFT JOIN TCNMUsrDepart_L DPTL WITH (NOLOCK) ON DPTL.FTDptName = IMPT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID                   
                    WHERE IMPT.FTSessionID = '$tSessionID'
                    AND IMPT.FTCidStaCrd = '1'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftClearCard': {

                $tSQL = "
                    INSERT INTO TFNTCrdImpDT (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        IMPT.FTBchCode, 
                        IMPT.FTCihDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  IMPT.FNCidSeqNo ASC) AS FNCidSeqNo, 
                        IMPT.FTCidCrdCode, 
                        IMPT.FCCvdOldBal, 
                        IMPT.FTCidCrdRef, 
                        IMPT.FTCtyCode, 
                        IMPT.FTCidCrdName, 
                        IMPT.FTCidCrdHolderID, 
                        IMPT.FTCidCrdDepart, 
                        IMPT.FTCidStaCrd, 
                        IMPT.FTCidStaPrc, 
                        IMPT.FTCidRmk, 
                        IMPT.FDCreateOn, 
                        IMPT.FTCreateBy
                    FROM TFNTCrdImpTmp IMPT WITH (NOLOCK)
                    WHERE IMPT.FTSessionID = '$tSessionID'
                    AND IMPT.FTCidStaCrd = '1'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftOut': {
                $tSQL = "
                    INSERT INTO TFNTCrdShiftDT (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdCardBal, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy
                    FROM TFNTCrdShiftTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tSessionID'
                    AND FTXsdStaCrd = '1'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftReturn': {
                $tSQL = "
                    INSERT INTO TFNTCrdShiftDT (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdCardBal, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy
                    FROM TFNTCrdShiftTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tSessionID'
                    AND FTXsdStaCrd = '1'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftTopUp': {
                $tSQL = "
                    INSERT INTO TFNTCrdTopUpDT (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdAmt,
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy
                    FROM TFNTCrdTopUpTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tSessionID'
                    AND FTXsdStaCrd = '1'

                    UPDATE TFNTCrdTopUpHD SET FCXshTotal = TMP.FCXshTotal
                    FROM(
                        SELECT 
                            FTBchCode,
                            FTXshDocNo,
                            SUM(ISNULL(FCXsdAmt,0)) AS FCXshTotal
                        FROM TFNTCrdTopUpTmp WITH (NOLOCK)
                        WHERE FTSessionID = '$tSessionID'
                        AND FTXsdStaCrd = '1'
                        GROUP BY FTBchCode, FTXshDocNo, FTSessionID
                    ) TMP
                    WHERE TFNTCrdTopUpHD.FTBchCode = TMP.FTBchCode 
                    AND TFNTCrdTopUpHD.FTXshDocNo = TMP.FTXshDocNo
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftRefund': {
                $tSQL = "
                    INSERT INTO TFNTCrdTopUpDT (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)

                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdAmt, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy
                    FROM TFNTCrdTopUpTmp WITH (NOLOCK)
                    WHERE FTSessionID = '$tSessionID'
                    AND FTXsdStaCrd = '1'

                    UPDATE TFNTCrdTopUpHD SET FCXshTotal = TMP.FCXshTotal
                    FROM(
                        SELECT 
                            FTBchCode,
                            FTXshDocNo,
                            SUM(ISNULL(FCXsdAmt,0)) AS FCXshTotal
                        FROM TFNTCrdTopUpTmp WITH (NOLOCK)
                        WHERE FTSessionID = '$tSessionID'
                        AND FTXsdStaCrd = '1'
                        GROUP BY FTBchCode, FTXshDocNo, FTSessionID
                    ) TMP
                    WHERE TFNTCrdTopUpHD.FTBchCode = TMP.FTBchCode 
                    AND TFNTCrdTopUpHD.FTXshDocNo = TMP.FTXshDocNo
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftStatus': {
                $tSQL = "
                    INSERT INTO TFNTCrdVoidDT (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        FTBchCode, 
                        FTCvhDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, 
                        FTCvdOldCode, 
                        FCCvdOldBal, 
                        FTCvdNewCode, 
                        FTCvdStaCrd, 
                        FTCvdStaPrc, 
                        FTCvdRmk, 
                        FTRsnCode, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy
                    FROM TFNTCrdVoidTmp
                    WHERE FTSessionID = '$tSessionID'
                    AND FTCvdStaCrd = '1'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftChange': {

                $tWhereStaCrd = " AND FTCvdStaCrd = '1'";
                if($bIsImport){
                    $tWhereStaCrd = "";
                }

                $tSQL = "
                    INSERT INTO TFNTCrdVoidDT (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy)
                    
                    SELECT 
                        FTBchCode, 
                        FTCvhDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, 
                        FTCvdOldCode, 
                        FCCvdOldBal, 
                        FTCvdNewCode, 
                        FTCvdStaCrd, 
                        FTCvdStaPrc, 
                        FTCvdRmk, 
                        FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy
                    FROM TFNTCrdVoidTmp
                    WHERE FTSessionID = '$tSessionID'
                    $tWhereStaCrd
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
    }
}

/**
 * Functionality : Copy card data in DT to temp
 * Parameters : $ptDocType, $ptDocNo
 * Creator : 3/1/2019 piya
 * Last Modified : -
 * Return : Data in document temp by session id
 * Return Type : array
 */
function FSxDocHelperDTToTemp($ptDocType, $ptDocNo)
{
    $ci = &get_instance();
    $ci->load->database();
    $tSessionID = $ci->session->userdata("tSesSessionID");
    $nLngID = $ci->session->userdata("tLangEdit");

    switch ($ptDocType) {
        case 'cardShiftNewCard': {
                $tSQL = "
                    INSERT INTO TFNTCrdImpTmp (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, FTSessionID)
                    
                    SELECT 
                        FTBchCode, 
                        FTCihDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, 
                        FTCidCrdCode, 
                        FCCvdOldBal, 
                        FTCidCrdRef, 
                        FTCtyCode, 
                        FTCidCrdName, 
                        FTCidCrdHolderID, 
                        DPTL.FTDptName AS FTCidCrdDepart, 
                        FTCidStaCrd, 
                        FTCidStaPrc, 
                        FTCidRmk, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdImpDT IMPDT
                    LEFT JOIN TCNMUsrDepart_L DPTL ON DPTL.FTDptCode = IMPDT.FTCidCrdDepart AND DPTL.FNLngID = $nLngID                    
                    WHERE FTCihDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftClearCard': {
                $tSQL = "
                    INSERT INTO TFNTCrdImpTmp (FTBchCode, FTCihDocNo, FNCidSeqNo, FTCidCrdCode, FCCvdOldBal, FTCidCrdRef, FTCtyCode, FTCidCrdName, FTCidCrdHolderID, FTCidCrdDepart, FTCidStaCrd, FTCidStaPrc, FTCidRmk, FDCreateOn, FTCreateBy, FTSessionID)
                    
                    SELECT 
                        FTBchCode, 
                        FTCihDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCidSeqNo ASC) AS FNCidSeqNo, 
                        FTCidCrdCode, 
                        FCCvdOldBal, 
                        FTCidCrdRef, 
                        FTCtyCode, 
                        FTCidCrdName, 
                        FTCidCrdHolderID, 
                        FTCidCrdDepart, 
                        FTCidStaCrd, 
                        FTCidStaPrc, 
                        FTCidRmk, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdImpDT
                    WHERE FTCihDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftOut': {
                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdCardBal, 
                        '1' AS FTXsdStaCrd, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdShiftDT WITH (NOLOCK)
                    WHERE FTXshDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftReturn': {
                $tSQL = "
                    INSERT INTO TFNTCrdShiftTmp (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdCardBal, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdCardBal, 
                        '1' AS FTXsdStaCrd, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdShiftDT WITH (NOLOCK)
                    WHERE FTXshDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftTopUp': {

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FCXsdAmtPmt,FNXpdQty, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    SELECT 
                        TFNTCrdTopUpDT.FTBchCode, 
                        TFNTCrdTopUpDT.FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  TFNTCrdTopUpDT.FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        TFNTCrdTopUpDT.FTCrdCode, 
                        TFNTCrdTopUpDT.FCXsdAmt, 
                        TFNTCrdTopUpPD.FCXpdAmtGet AS FCXsdAmtPmt,
                        TFNTCrdTopUpPD.FNXpdQty,
                        '1' AS FTXsdStaCrd, 
                        TFNTCrdTopUpDT.FTXsdStaPrc, 
                        TFNTCrdTopUpDT.FTXsdRmk, 
                        TFNTCrdTopUpDT.FDLastUpdOn, 
                        TFNTCrdTopUpDT.FTLastUpdBy, 
                        TFNTCrdTopUpDT.FDCreateOn, 
                        TFNTCrdTopUpDT.FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdTopUpDT
                    LEFT JOIN TFNTCrdTopUpPD ON TFNTCrdTopUpPD.FTXshDocNo = TFNTCrdTopUpDT.FTXshDocNo AND TFNTCrdTopUpPD.FTBchCode = TFNTCrdTopUpDT.FTBchCode AND TFNTCrdTopUpPD.FTCrdCode = TFNTCrdTopUpDT.FTCrdCode
                    WHERE TFNTCrdTopUpDT.FTXshDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftRefund': {

                $tSQL = "
                    INSERT INTO TFNTCrdTopUpTmp (FTBchCode, FTXshDocNo, FNXsdSeqNo, FTCrdCode, FCXsdAmt, FTXsdStaCrd, FTXsdStaPrc, FTXsdRmk, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)

                    SELECT 
                        FTBchCode, 
                        FTXshDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNXsdSeqNo ASC) AS FNXsdSeqNo, 
                        FTCrdCode, 
                        FCXsdAmt, 
                        '1' AS FTXsdStaCrd, 
                        FTXsdStaPrc, 
                        FTXsdRmk, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdTopUpDT
                    WHERE FTXshDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftStatus': {
                $tSQL = "
                    INSERT INTO TFNTCrdVoidTmp (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    
                    SELECT 
                        FTBchCode, 
                        FTCvhDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, 
                        FTCvdOldCode, 
                        FCCvdOldBal, 
                        FTCvdNewCode, 
                        FTCvdStaCrd, 
                        FTCvdStaPrc, 
                        FTCvdRmk, 
                        FTRsnCode, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdVoidDT
                    WHERE FTCvhDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
        case 'cardShiftChange': {
                $tSQL = "
                    INSERT INTO TFNTCrdVoidTmp (FTBchCode, FTCvhDocNo, FNCvdSeqNo, FTCvdOldCode, FCCvdOldBal, FTCvdNewCode, FTCvdStaCrd, FTCvdStaPrc, FTCvdRmk, FTRsnCode, FDLastUpdOn, FTLastUpdBy, FDCreateOn, FTCreateBy, FTSessionID)
                    
                    SELECT 
                        FTBchCode, 
                        FTCvhDocNo, 
                        ROW_NUMBER() OVER(ORDER BY  FNCvdSeqNo ASC) AS FNCvdSeqNo, 
                        FTCvdOldCode, 
                        FCCvdOldBal, 
                        FTCvdNewCode, 
                        FTCvdStaCrd, 
                        FTCvdStaPrc, 
                        FTCvdRmk, 
                        FTRsnCode, 
                        FDLastUpdOn, 
                        FTLastUpdBy, 
                        FDCreateOn, 
                        FTCreateBy, 
                        '$tSessionID' AS FTSessionID
                    FROM TFNTCrdVoidDT
                    WHERE FTCvhDocNo = '$ptDocNo'
                ";

                $oQuery = $ci->db->query($tSQL);

                if ($oQuery) {
                    // echo "Insert Success";
                } else {
                    // echo "Inser Fail";
                }
                break;
            }
    }
}
