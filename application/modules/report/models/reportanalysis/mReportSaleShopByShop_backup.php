<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mReportSaleShopByShop extends CI_Model {

    /**
     * Functionality: Get Data Report SaleShopByShop
     * Parameters:  Function Parameter
     * Creator: 13/12/2018 Wasin(Yoshi)
     * Last Modified : 21/10/2019 Piya
     * Return : Array Data Report SaleShopByShop
     * Return Type: Array
     */
    public function FSaMRptSaleShopByShop($paFilterReport, $pnStaOverLimit) {
        try {
            // $aRowLen = FCNaHCallLenData($paFilterReport['nRow'], $paFilterReport['nPage']);
            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            if (!empty($pnStaOverLimit)) {
                $tTopLimit = "TOP($pnStaOverLimit)";
            }

            $nPage = $paFilterReport['nPage'];

            // Call Data Pagination
            $aPagination = $this->FMaMRPTPagination($paFilterReport);
            $nRowIDStart = $aPagination["nRowIDStart"];
            $nRowIDEnd = $aPagination["nRowIDEnd"];
            $nTotalPage = $aPagination["nTotalPage"];

            // Set Priority
            $this->FMxMRPTSetPriorityGroup($paFilterReport);

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
                        WHERE FTComName = '$tComName'
                        AND FtRptName = '$tRptName'
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
                SELECT $tTopLimit
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
                        WHERE FTComName = '$tComName'
                        AND FtRptName = '$tRptName'
                        GROUP BY FTBchCode, FTShpCode
                    ) AS S ON A.FTBchCode = S.FTBchCode_SUM AND A.FTShpCode = S.FTShpCode_SUM
                    WHERE A.FTComName = '$tComName'
                    AND A.FtRptName = '$tRptName'
                    /* End Calculate Misures */
                ) AS L
                $tJoinFoooter
            ";

            // WHERE เงื่อนไข Page
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

            // สั่ง Order by ตามข้อมูลหลัก
            $tSQL .= " ORDER BY L.FTBchCode, L.FTShpCode, L.FNRowPartID, L.FDTxnDocDate DESC";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $aDataReturn = $oQuery->result_array();
                $nFoundRow = $this->FSaMRptSaleShopByShopCount($paFilterReport);
                // var_dump($nFoundRow);
                $nPageAll = ceil($nFoundRow / $paFilterReport['nRow']);

                $aReturnData = array(
                    'raItems' => $aDataReturn,
                    'rnAllRow' => $nFoundRow,
                    'rnCurrentPage' => $paFilterReport['nPage'],
                    'rnAllPage' => $nPageAll,
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                $aReturnData = '';
            }
            return $aReturnData;

        } catch (Exception $Error) {
            echo 'Error mReportAnalysis Function(FSaMRptSaleShopByShop) =>' . $Error;
        }
    }

    /**
     * Functionality: Get Pagination
     * Parameters:  Function Parameter
     * Creator: 22/10/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptName = $paDataWhere['tRptName'];

        $tSQL = "
            SELECT
                COUNT(TMP.FTShpCode) AS rnCountPage
            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
            WHERE TMP.FTComName = '$tComName' 
            AND TMP.FTRptName = '$tRptName'
        ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nRow']; // แสดงต่อหน้า
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
     * Functionality: Get Data Report SaleShopByShop Count
     * Parameters:  Function Parameter
     * Creator: 12/12/2018 Wasin(Yoshi)
     * Last Modified : 05/04/2019 Wasin(Yoshi)
     * Return : Array Data Report SaleShopByDate
     * Return Type: Array
     */
    public function FSaMRptSaleShopByShopCount($paFilterReport) {
        try {

            $tComName = $paFilterReport['tCompName'];
            $tRptName = $paFilterReport['tRptName'];

            $tSQL = "
                SELECT
                    ROW_NUMBER() OVER(ORDER BY TMP.FTShpCode ASC, TMP.FNRowPartID ASC) AS rtRowID
                FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
                WHERE FTComName = '$tComName' 
                AND FTRptName = '$tRptName'
            ";

            $oQuery = $this->db->query($tSQL);
            return $oQuery->num_rows();

        } catch (Exception $Error) {
            echo 'Error mReportAnalysis Function(FSaMRptSaleShopByShop) =>' . $Error;
        }
    }

    /**
     * Functionality: Summary Data Report SaleShopByShop
     * Parameters:  Function Parameter
     * Creator: 19/11/2018 Piya
     * Last Modified :
     * Return :
     * Return Type: Array
     */
    public function FSaMRptSaleShopByShopSum($paFilterReport) {
        $tComName = $paFilterReport['tCompName'];
        $tRptName = $paFilterReport['tRptName'];

        $tSQL = "   
            SELECT
                SUM(FCTxnSaleVal) AS rcTxnSaleVal,
                SUM(FCTxnCancelSaleVal) AS rcTxnCancelSaleVal,
                SUM(FCTxnSaleNet) AS rcTotalSale
            FROM TFCTRptCrdAnalysisTmp TMP WITH (NOLOCK)
            WHERE FTComName = '$tComName' 
            AND FTRptName ='$tRptName'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality: Set Priority Group
     * Parameters:  Function Parameter
     * Creator: 21/10/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptName = $paDataWhere['tRptName'];

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
                AND TMP.FTRptName = '$tRptName'
            ) AS B
            ON DATAUPD.FTRptRowSeq = B.FTRptRowSeq
            AND DATAUPD.FTComName = '$tComName'
            AND DATAUPD.FTRptName = '$tRptName'
        ";
        $this->db->query($tSQL);
    }

}
