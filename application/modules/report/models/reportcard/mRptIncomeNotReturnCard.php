<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptIncomeNotReturnCard extends CI_Model
{

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 25/02/2020  Nonpawich 
     * Last Modified :
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter)
    {

        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];
        // echo "<pre>";
        // print_r( FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']) );
        // echo "<br>";
        // echo $paDataFilter['bBchStaSelectAll'];

        // สาขา
        $tBchCodeSelect = FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); /*($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);*/

        // กลุ่มธุรกิจ
        $tMerCodeSelect = FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']); /*($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);*/
        // ร้านค้า
        $tShpCodeSelect = FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']); /*($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);*/

        // จุดขาย
        $tPosCodeSelect = $paDataFilter['tPosCodeSelect']; /*($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];*/

        $tCallStore = "{ CALL SP_RPTxIncomeNotReturnCardTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";

        $aDataStore = array(

            'pnLngID'       => $nLangID,
            'ptComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $paDataFilter['nFilterType'],

            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],

            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            'FNResult'      => 0
        );
        // print_r($aDataStore);

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();exit;
        if ($oQuery != FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage = $paDataWhere['nPage'];
        $aPagination = $this->FMaMRPTPagination($paDataWhere);


        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName   = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSession   = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $aData = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);


        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {

            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(FCTxnCrdValue) AS FCTxnCrdValue_Footer
                FROM TRPTIncomeNotReturnCardTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'";

            $tJoinFoooter .= "GROUP BY FTUsrSession ) T 
                ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tSession' AS FTUsrSession_Footer,
                    '0' AS FCTxnCrdValue_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = " 
            SELECT
                L.*,
                T.FCTxnCrdValue_Footer

            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FTPosCode ASC) AS RowID ,
                    A.*,
                    S.FNRptGroupMember,
                    S.FNRowPartID_MaxSeq,
                    S.FCTxnCrdValue_SubTotal
                FROM TRPTIncomeNotReturnCardTmp A WITH(NOLOCK)
                /* Calculate Misures */

                LEFT JOIN (
                    SELECT
                        FTPosCode AS FTPosCode_SUM,
                        COUNT(FTPosCode)   AS FNRptGroupMember,
                        MAX(FNRowPartID) AS FNRowPartID_MaxSeq,
                        SUM(FCTxnCrdValue) AS FCTxnCrdValue_SubTotal
                    FROM TRPTIncomeNotReturnCardTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tSession'";

        $tSQL .= "  GROUP BY FTPosCode
                 ) AS S ON  A.FTPosCode = S.FTPosCode_SUM
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

        $tSQL .= " ORDER BY FTPosCode";

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
            "aRptData" => $aData,
            "aError" => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    public function FMaMRPTPagination($paDataWhere)
    {

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
            Tmp.FTPosCode
            FROM TRPTIncomeNotReturnCardTmp Tmp WITH(NOLOCK)
            WHERE Tmp.FTComName = '$tComName'
            AND Tmp.FTRptCode = '$tRptCode'
            AND Tmp.FTUsrSession = '$tUsrSession'
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


    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession)
    {

        $tSQL = "
            UPDATE TRPTIncomeNotReturnCardTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTPosCode ORDER BY FTPosCode ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTIncomeNotReturnCardTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession' 
            ) AS B
            WHERE TRPTIncomeNotReturnCardTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTIncomeNotReturnCardTmp.FTComName = '$ptComName' 
            AND TRPTIncomeNotReturnCardTmp.FTRptCode = '$ptRptCode'
            AND TRPTIncomeNotReturnCardTmp.FTUsrSession = '$ptUsrSession'
        ";
        $this->db->query($tSQL);
    }
}
