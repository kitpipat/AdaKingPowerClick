<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptAdjStockVending extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 15/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter) {
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];

        $tCallStore = "{ CALL SP_RPTxStockChecking2002002(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tSessionID'],

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],
            
            'ptWahF'        => $paDataFilter['tWahCodeFrom'],
            'ptWahT'        => $paDataFilter['tWahCodeTo'],
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 18/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere) {
        
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(ADJSTK_TMP.FTAjhDocNo) AS rnCountPage
            FROM TRPTPdtAdjStkTmp ADJSTK_TMP WITH(NOLOCK)
            WHERE ADJSTK_TMP.FTComName  = '$tComName'
            AND ADJSTK_TMP.FTRptCode    = '$tRptCode'
            AND ADJSTK_TMP.FTUsrSession = '$tUsrSession'
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
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 18/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere) {
        
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL   = " UPDATE TRPTPdtAdjStkTmp
                        SET FNRowPartID = B.PartID
                    FROM(
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTAjhDocNo ORDER BY FTAjhDocNo DESC) AS PartID,
                            FTRptRowSeq
                        FROM TRPTPdtAdjStkTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName     = '$tComName' 
                        AND TMP.FTRptCode       = '$tRptCode'
                        AND TMP.FTUsrSession    = '$tUsrSession'
                    ) AS B
                    WHERE TRPTPdtAdjStkTmp.FTRptRowSeq = B.FTRptRowSeq
                    AND TRPTPdtAdjStkTmp.FTComName      = '$tComName'
                    AND TRPTPdtAdjStkTmp.FTRptCode      = '$tRptCode'
                    AND TRPTPdtAdjStkTmp.FTUsrSession   = '$tUsrSession'
        ";
        
        $this->db->query($tSQL);
    }

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 18/07/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere) {
        
        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $aPagination    = $this->FMaMRPTPagination($paDataWhere);
            $nRowIDStart    = $aPagination["nRowIDStart"];
            $nRowIDEnd      = $aPagination["nRowIDEnd"];
            $nTotalPage     = $aPagination["nTotalPage"];
        }else{
            $aPagination  = array();
            $nTotalPage   = 1;
        }

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT
                    FTUsrSession            AS FTUsrSession_Footer,
                    SUM(FCAjdWahB4Adj)      AS FCAjdWahB4Adj_Footer,
                    SUM(FCAjdUnitQty)       AS FCAjdUnitQty_Footer,
                    SUM(FCAjdQtyAllDiff)    AS FCAjdQtyAllDiff_Footer
                FROM TRPTPdtAdjStkTmp WITH(NOLOCK)
                WHERE FTComName     = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   
                SELECT
                    '$tUsrSession'  AS FTUsrSession_Footer,
                    '0'             AS FCAjdWahB4Adj_Footer,
                    '0'             AS FCAjdUnitQty_Footer,
                    '0'             AS FCAjdQtyAllDiff_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCAjdWahB4Adj_Footer,
                        T.FCAjdUnitQty_Footer,
                        T.FCAjdQtyAllDiff_Footer
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FTAjhDocNo ASC) AS RowID ,
                            A.*,
                            S.FNRptGroupMember,
                            S.FCAjdWahB4Adj_SubTotal,
                            S.FCAjdUnitQty_SubTotal,
                            S.FCAjdQtyAllDiff_SubTotal
                        FROM TRPTPdtAdjStkTmp A WITH(NOLOCK)
                        /* Calculate Misures */
                        LEFT JOIN (
                            SELECT
                                FTAjhDocNo              AS FTAjhDocNo_SUM,
                                COUNT(FTAjhDocNo)       AS FNRptGroupMember,
                                SUM(FCAjdWahB4Adj)      AS FCAjdWahB4Adj_SubTotal,
                                SUM(FCAjdUnitQty)       AS FCAjdUnitQty_SubTotal,
                                SUM(FCAjdQtyAllDiff)    AS FCAjdQtyAllDiff_SubTotal
                            FROM TRPTPdtAdjStkTmp WITH(NOLOCK)
                            WHERE FTComName     = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUsrSession'
                            GROUP BY FTAjhDocNo
                        ) AS S ON A.FTAjhDocNo = S.FTAjhDocNo_SUM
                        WHERE A.FTComName       = '$tComName'
                        AND   A.FTRptCode       = '$tRptCode'
                        AND   A.FTUsrSession    = '$tUsrSession'
                        /* End Calculate Misures */
                    ) AS L
                    LEFT JOIN (
                    " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        }
        
        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTAjhDocNo";

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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere) {
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   
            SELECT 
                COUNT(DTTMP.FTRptCode) AS rnCountPage
            FROM TRPTPdtAdjStkTmp AS DTTMP WITH(NOLOCK)
            WHERE 1 = 1
            AND FTUsrSession    = '$tSessionID'
            AND FTComName       = '$tCompName'
            AND FTRptCode       = '$tRptCode'
        ";
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

}














