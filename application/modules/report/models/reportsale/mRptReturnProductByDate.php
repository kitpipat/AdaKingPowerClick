<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptReturnProductByDate extends CI_Model
{

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 3/20/2020 nonpawich (petch)
     * Last Modified :
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter)
    {
        $nLangID = $paDataFilter['nLangID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxSalPdtRetTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID, 
            'pnComName' => $tComName,
            'ptRptCode' => $tRptCode,
            'ptUsrSession' => $tUserSession,

            'pnFilterType' => $paDataFilter['nFilterType'],
            
            // สาขา
            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paDataFilter['tBchCodeFrom'],
            'ptBchT' => $paDataFilter['tBchCodeTo'],
            // ร้านค้า
            'ptShpL' => $tShpCodeSelect,
            'ptShpF' => $paDataFilter['tShpCodeFrom'],
            'ptShpT' => $paDataFilter['tShpCodeTo'],
            // จุดขาย
            'ptPosL' => $tPosCodeSelect,
            'ptPosF' => $paDataFilter['tRptPosCodeFrom'],
            'ptPosT' => $paDataFilter['tRptPosCodeTo'],
            // แคชเชียร์
            'ptUsrF' => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT' => $paDataFilter['tCashierCodeTo'],
            // วันที่เอกสาร
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FTResult' => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    /** 
    * Functionality: Get Data Report
    * Parameters:  Function Parameter
    * Creator: 3/20/2020 nonpawich (petch)
    * Last 
    * Return : Get Data Rpt Temp
    * Return Type: Array
    */
    public function FSaMGetDataReport($paDataWhere)
    {
        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Set Priority
        // $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCXshRnd, 0)
                    ) AS FCXshRnd_Footer,
                    SUM( 
                        ISNULL(FCXtdAmount, 0)
                    ) AS FCXtdAmount_Footer
                FROM TRPTSalPdtRetTmp   WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                AND FTXthTnsType = '1'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXshRnd_Footer,
                    0 AS FCXtdAmount_Footer
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
                    ROW_NUMBER() OVER(ORDER BY FDXihDocDate ASC, FTXihDocNo ASC, FNRowPartID ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTSalPdtRetTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTXihDocNo AS FTXihDocNo_SUM,
                        COUNT(FTXihDocNo) AS FNRptGroupMember
                    FROM TRPTSalPdtRetTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTXihDocNo
                ) AS S ON A.FTXihDocNo = S.FTXihDocNo_SUM
                WHERE A.FTComName  = '$tComName'
                AND A.FTRptCode    = '$tRptCode'
                AND A.FTUsrSession = '$tUsrSession'
            
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
            $tRptJoinFooter
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FDXihDocDate ASC, L.FTXihDocNo , L.FNRowPartID ASC";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = NULL;
        }

        $aErrorList = [
            "nErrInvalidPage" => ""
        ];

        $aResualt = [
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList
        ];
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TSBP.FTRptCode) AS rnCountPage
            FROM TRPTSalPdtRetTmp TSBP WITH(NOLOCK)
            WHERE 1=1
            AND TSBP.FTComName = '$tComName'
            AND TSBP.FTRptCode = '$tRptCode'
            AND TSBP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];

        $nPerPage = $paDataWhere['nPerPage'];

        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); //RowId Start
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
            "nPerPage" => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "
            UPDATE TRPTSalPdtRetTmp
                SET TRPTSalPdtRetTmp.FNRowPartID = B.PartID
            FROM (
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY TSBP.FTXihDocNo ORDER BY TSBP.FDXihDocDate ASC, TSBP.FTXihDocNo , TSBP.FTPdtCode ASC, TSBP.FTXthTnsType ASC) AS PartID,
                    TSBP.FTRptRowSeq
                FROM TRPTSalPdtRetTmp TSBP WITH(NOLOCK)
                WHERE 1=1
                AND TSBP.FTComName = '$tComName'
                AND TSBP.FTRptCode = '$tRptCode'
                AND TSBP.FTUsrSession = '$tUsrSession'
            ) AS B
            WHERE 1=1
            AND TRPTSalPdtRetTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTSalPdtRetTmp.FTComName = '$tComName' 
            AND TRPTSalPdtRetTmp.FTRptCode = '$tRptCode'
            AND TRPTSalPdtRetTmp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);
    }

    /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams)
    {
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUserSession = $paParams['tUserSession'];
        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTSalPdtRetTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSession'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
}
