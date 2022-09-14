
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptMnyShotOverDaily extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 10/07/2019 Saharat(Golf)
     * Last Modified :
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

         // สาขา
         $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        
         // /แคชเชีย
         $tCstCodeSelect = ($paDataFilter['bCashierStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tCashierCodeSelect']);

         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
 
        
         $tCallStore = "{ CALL SP_RPTxMnyShotOverDailyDTTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $aDataStore = array(
        
                'pnLngID'       => $nLangID,
                'ptComName'     => $tComName,
                'ptRptCode'     => $tRptCode,
                'ptUsrSession'  => $tUserSession,
                'pnFilterType'  => intval($paDataFilter['nFilterType']),

                //สาขา
                'ptBchL'   => $tBchCodeSelect,
                'ptBchF'   => $paDataFilter['tBchCodeFrom'],
                'ptBchT'   => $paDataFilter['tBchCodeTo'],
        
                //pos
                'ptPosL'   => $tPosCodeSelect,
                'ptPosF'   => $paDataFilter['tRptPosCodeFrom'],
                'ptPosT'   => $paDataFilter['tRptPosCodeTo'],

                //แคชเชีย
                'ptUsrL'   => $tCstCodeSelect,
                'ptUsrF'   => $paDataFilter['tCashierCodeFrom'],
                'ptUsrT'   => $paDataFilter['tCashierCodeTo'],

                'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
                'ptDocDateT'    => $paDataFilter['tDocDateTo'],
                'FNResult'      => 0    
            );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery != FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 10/07/2019 Saharat(Golf)
     * Last Modified : 13/11/2019 Piya
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */

     //TRPTMnyShotOverDailyDTTmp
    public function FSaMGetDataReport($paDataWhere) {

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSession = $paDataWhere['tUsrSessionID'];
        
        // Set Priority
        $aData = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

      
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {

            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( ISNULL(FCMnyOver, 0) ) AS FCMnyOver_Footer,
                    SUM( ISNULL(FCMnyShot, 0) ) AS FCMnyShot_Footer,
                    SUM( ISNULL(FCKbnAmtCash, 0) ) AS FCKbnAmtCash_Footer,
                    SUM( ISNULL(FCRcvPayCash, 0) ) AS FCRcvPayCash_Footer,
                    SUM( ISNULL(FCKbnAmtCredit, 0) ) AS FCKbnAmtCredit_Footer,
                    SUM( ISNULL(FCRcvPayCredit, 0) ) AS FCRcvPayCredit_Footer,
                    SUM( ISNULL(FCKbnAmtVouchers, 0) ) AS FCKbnAmtVouchers_Footer,
                    SUM( ISNULL(FCRcvPayVouchers, 0) ) AS FCRcvPayVouchers_Footer,
                    SUM( ISNULL(FCKbnAmtCoupon, 0) ) AS FCKbnAmtCoupon_Footer,
                    SUM( ISNULL(FCRcvPayCoupon, 0) ) AS FCRcvPayCoupon_Footer,
                    SUM( ISNULL(FCKbnAmtChque, 0) ) AS FCKbnAmtChque_Footer,
                    SUM( ISNULL(FCRcvPayChque, 0) ) AS FCRcvPayChque_Footer,
                    SUM( ISNULL(FCKbnAmtPromptpay, 0) ) AS FCKbnAmtPromptpay_Footer,
                    SUM( ISNULL(FCRcvPayPromptpay, 0) ) AS FCRcvPayPromptpay_Footer,
                    SUM( ISNULL(FCKbnAmtOther, 0) ) AS FCKbnAmtOther_Footer,
                    SUM( ISNULL(FCRcvPayOther, 0) ) AS FCRcvPayOther_Footer,
                    SUM( ISNULL(FCAmtShipClose, 0) ) AS FCAmtShipClose_Footer,
                    SUM( ISNULL(FCAmtSystem, 0) ) AS FCAmtSystem_Footer,
                    SUM( ISNULL(FCSvnCashIn, 0) ) AS FCSvnCashIn_Footer,
                    SUM( ISNULL(FCSvnCashOut, 0) ) AS FCSvnCashOut_Footer
                FROM TRPTMnyShotOverDailyDTTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'
                GROUP BY FTUsrSession ) T 
                ON L.FTUsrSession = T.FTUsrSession_Footer
            ";

        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tSession' AS FTUsrSession_Footer,
                    '0' AS FCMnyOver_Footer,
                    '0' AS FCMnyShot_Footer,
                    '0' AS FCKbnAmtCash_Footer,
                    '0' AS FCRcvPayCash_Footer,
                    '0' AS FCKbnAmtCredit_Footer,
                    '0' AS FCRcvPayCredit_Footer,
                    '0' AS FCKbnAmtVouchers_Footer,
                    '0' AS FCRcvPayVouchers_Footer,
                    '0' AS FCKbnAmtCoupon_Footer,
                    '0' AS FCRcvPayCoupon_Footer,
                    '0' AS FCKbnAmtChque_Footer,
                    '0' AS FCRcvPayChque_Footer,
                    '0' AS FCKbnAmtPromptpay_Footer,
                    '0' AS FCRcvPayPromptpay_Footer,
                    '0' AS FCKbnAmtOther_Footer,
                    '0' AS FCRcvPayOther_Footer,
                    '0' AS FCAmtShipClose_Footer,
                    '0' AS FCAmtSystem_Footer,
                    '0' AS FCSvnCashIn_Footer,
                    '0' AS FCSvnCashOut_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.*
            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FTBchCode ASC , FTPosCode ASC , FTUsrCode ASC , FDShdSaleDate ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTMnyShotOverDailyDTTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                    FTUsrCode AS FCMnyOver_SUM,
                        COUNT(FTUsrCode) AS FNRptGroupMember
                    FROM TRPTMnyShotOverDailyDTTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tSession' 
                    GROUP BY FTUsrCode
                ) AS S ON A.FTUsrCode = S.FCMnyOver_SUM
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tSession'";
             $tSQL .= " /* End Calculate Misures */
            ) AS L 
            LEFT JOIN (
            " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // AND FNAppType=1
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY FTBchCode ASC , FTPosCode ASC , FTUsrCode ASC , FDShdSaleDate ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = NULL;
        }

        $aErrorList = array(
            "nErrInvalidPage" => ""
        );

        $aResualt = array(
            "aPagination" => $aPagination,
            "aRptData"    => $aData,
            "aError"      => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }
   
    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 22/04/2019 Wasin(Yoshi)
     * Last Modified: 13/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {
        $tUserCode      = $paDataWhere['tUserCode'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUserSession   = $paDataWhere['tUserSession'];

        $tSQL = " 
            SELECT 
                FTRcvName  AS rtRcvName,
                FTXshDocNo AS rtRcvDocNo,
                FDCreateOn AS rtRcvCreateOn,
                FCXrcNet   AS rtRcvrcNet 
            FROM TRPTSalRCTmp  
            WHERE FTUsrSession = '$tUserSession' 
            AND FTComName   = '$tCompName' 
            AND FTRptCode   = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    public function FMaMRPTPagination($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
            SAL.FTUsrCode
            FROM TRPTMnyShotOverDailyDTTmp SAL WITH(NOLOCK)
            WHERE SAL.FTComName     = '$tComName'
            AND SAL.FTRptCode       = '$tRptCode'
            AND SAL.FTUsrSession    = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();

        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); // RowId Start
        if ($nRptAllRecord <= $nPerPage) {
            $nTotalPage = 1;
        } else if (($nRptAllRecord % $nPerPage) == 0) {
            $nTotalPage = ($nRptAllRecord / $nPerPage);
        } else {
            $nTotalPage = ($nRptAllRecord / $nPerPage) + 1;
            $nTotalPage = (int) $nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if ($nRowIDEnd > $nRptAllRecord) {
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession) {

        $tSQL = "
            UPDATE TRPTMnyShotOverDailyDTTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTUsrCode ORDER BY FTUsrCode ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTMnyShotOverDailyDTTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession' 
            ) AS B
            WHERE TRPTMnyShotOverDailyDTTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTMnyShotOverDailyDTTmp.FTComName = '$ptComName' 
            AND TRPTMnyShotOverDailyDTTmp.FTRptCode = '$ptRptCode'
            AND TRPTMnyShotOverDailyDTTmp.FTUsrSession = '$ptUsrSession'
        ";
        $this->db->query($tSQL);
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 21/08/2019 Saharat(Golf)
     * Last Modified: 13/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere) {

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                DTTMP.FTRptCode
            FROM TRPTMnyShotOverDailyDTTmp AS DTTMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }

      /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUserSession'];
        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTMnyShotOverDailyDTTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }
        
}




