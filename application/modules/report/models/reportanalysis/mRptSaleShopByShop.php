<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleShopByShop extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter = []) {

        $nLngID = $paDataFilter['nLngID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode']; 
        // สาขา
        $tBchCodeFrom = empty($paDataFilter['tBchCodeFrom']) ? '' : $paDataFilter['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataFilter['tBchCodeTo']) ? '' : $paDataFilter['tBchCodeTo']; 
        // ร้านค้า
        $tShpCodeFrom = empty($paDataFilter['tShpCodeFrom']) ? '' : $paDataFilter['tShpCodeFrom']; 
        $tShpCodeTo = empty($paDataFilter['tShpCodeTo']) ? '' : $paDataFilter['tShpCodeTo']; 
        // วันที่
        $tDateFrom = empty($paDataFilter['tDateFrom']) ? '' : $paDataFilter['tDateFrom']; 
        $tDateTo = empty($paDataFilter['tDateTo']) ? '' : $paDataFilter['tDateTo']; 
        
        $tCallStore = "{CALL SP_RPTxSaleShopByShop(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLngID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptCode,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptShpF' => $tShpCodeFrom,
            'ptShpT' => $tShpCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
            'FNResult' => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if (false !== $oQuery) {
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
     * Creator: 29/10/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = []) {

        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "
                LEFT JOIN (
                    SELECT
                        FTRptName AS FTRptName_Footer,
                        SUM(FCTxnSaleVal) AS FCTxnSaleVal_Footer,
                        SUM(FCTxnCancelSaleVal) AS FCTxnCancelSaleVal_Footer,
                        SUM(FCTxnSaleNet) AS FCNetSale_Footer
                    FROM TFCTRptCrdAnalysisTmp WITH(NOLOCK)
                    WHERE FTComName = '$tCompName'
                    AND FtRptName = '$tRptCode'
                    GROUP BY FTRptName
                ) T ON L.FTRptName = T.FTRptName_Footer
            ";
        }else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "
                LEFT JOIN (
                    SELECT
                        ''  AS FTRptName_Footer,
                        0   AS FCTxnSaleVal_Footer,
                        0   AS FCTxnCancelSaleVal_Footer,
                        0   AS FCNetSale_Footer
                ) T ON  L.FTRptName = T.FTRptName_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "
            SELECT
                L.*,
                T.FTRptName_Footer,
                T.FCTxnSaleVal_Footer,
                T.FCTxnCancelSaleVal_Footer,
                T.FCNetSale_Footer
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY A.FTBchCode, A.FTShpCode, A.FNRowPartID, A.FDTxnDocDate DESC) AS RowID,
                    A.FTRptName,
                    A.FNRowPartID,
                    A.FTBchCode,
                    A.FTBchName,
                    A.FTShpCode,
                    A.FTShpName,
                    A.FNLngID,
                    A.FDTxnDocDate,
                    A.FCTxnSaleVal,
                    A.FCTxnCancelSaleVal,
                    A.FCTxnSaleNet,
                    S.FNRptGroupMember,
                    S.FCTxnSaleVal_SubTotal,
                    S.FCTxnCancelSaleVal_SubTotal,
                    S.FCSaleNet_SubTotal
                FROM TFCTRptCrdAnalysisTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTBchCode AS FTBchCode_SUM,
                        FTShpCode AS FTShpCode_SUM,
                        COUNT(FTShpCode) AS FNRptGroupMember,
                        SUM(FCTxnSaleVal) AS FCTxnSaleVal_SubTotal,
                        SUM(FCTxnCancelSaleVal) AS FCTxnCancelSaleVal_SubTotal,
                        SUM(FCTxnSaleNet) AS FCSaleNet_SubTotal
                    FROM TFCTRptCrdAnalysisTmp WITH(NOLOCK)
                    WHERE FTComName = '$tCompName'
                    AND FtRptName = '$tRptCode'
                    GROUP BY FTBchCode, FTShpCode
                ) AS S ON A.FTBchCode = S.FTBchCode_SUM AND A.FTShpCode = S.FTShpCode_SUM
                WHERE A.FTComName = '$tCompName'
                AND A.FtRptName = '$tRptCode'
                /* End Calculate Misures */
            ) AS L
            $tJoinFoooter
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTBchCode, L.FTShpCode, L.FNRowPartID, L.FDTxnDocDate DESC";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $aData = $oQuery->result_array();
        }else{
            $aData = NULL;
        }

        $aErrorList = [
            "nErrInvalidPage" => ""
        ];

        $aResualt= [
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList
        ];
        unset($oQuery); 
        unset($aData);
        return $aResualt;
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 29/10/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paParams = []) {

        $tSessionID = $paParams['tUserSessionID'];
        $tCompName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];

        $tSQL = "
            SELECT
                ROW_NUMBER() OVER(ORDER BY TMP.FTShpCode ASC, TMP.FNRowPartID ASC) AS rtRowID
            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
            WHERE FTComName = '$tCompName' 
            AND FTRptName = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    /**
     * Functionality: Get Pagination
     * Parameters:  Function Parameter
     * Creator: 22/10/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere = []) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT
                COUNT(TMP.FTShpCode) AS rnCountPage
            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
            WHERE TMP.FTComName = '$tComName' 
            AND TMP.FTRptName = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage']; // แสดงต่อหน้า
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage);
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
            "nNextPage" => $nNextPage,
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    /**
     * Functionality: Set Priority Group
     * Parameters:  Function Parameter
     * Creator: 21/10/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere = []) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "
            UPDATE DATAUPD SET
                DATAUPD.FNRowPartID = B.PartID
            FROM TFCTRptCrdAnalysisTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode, FTShpCode ORDER BY FTBchCode, FTShpCode, FDTxnDocDate DESC) AS PartID,
                    FTRptRowSeq
                FROM TFCTRptCrdAnalysisTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName'
                AND TMP.FTRptName = '$tRptCode'
            ) AS B
            ON DATAUPD.FTRptRowSeq = B.FTRptRowSeq
            AND DATAUPD.FTComName = '$tComName'
            AND DATAUPD.FTRptName = '$tRptCode'
        ";
        $this->db->query($tSQL);
    }
}
