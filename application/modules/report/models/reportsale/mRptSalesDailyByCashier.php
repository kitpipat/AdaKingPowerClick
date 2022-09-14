<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalesDailyByCashier extends CI_Model {

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
        $tBchCodeSelect = FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
 
        $tCallStore = "{ CALL SP_RPTxSalDailyByCashierTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'ptComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUserSession' => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],
            'ptUsrL'        => '',
            'ptUsrF'        => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT'        => $paDataFilter['tCashierCodeTo'],
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
    public function FSaMGetDataReport($paDataWhere) {

        $nPage          = $paDataWhere['nPage'];
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tSession       = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

        $tSQL = "   
            SELECT
                L.*
            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FTUsrCode) AS RowID,
                    A.*,
                    S.FNRptGroupMember,
                    S.FCXshNet_SubTotal
                FROM TRPTSalDailyByCashierTmp A WITH(NOLOCK)
                LEFT JOIN (
                    SELECT
                        FTRcvCode AS FTRcvCode_SUM,
                        COUNT(FTRcvCode) AS FNRptGroupMember,
                        SUM(FCXshNet) AS FCXshNet_SubTotal
                    FROM TRPTSalDailyByCashierTmp WITH(NOLOCK)
                    WHERE FTComName     = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tSession'
                    GROUP BY FTRcvCode
                ) AS S ON A.FTRcvCode = S.FTRcvCode_SUM
                WHERE A.FTComName       = '$tComName'
                AND   A.FTRptCode       = '$tRptCode'
                AND   A.FTUsrSession    = '$tSession'
            ) AS L 
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTUsrCode, L.FTTnsType, L.FTRcvCode ASC ";

        // echo  $tSQL; die();
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
            "aPagination"   => $aPagination,
            "aRptData"      => $aData,
            "aError"        => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    public function FMaMRPTPagination($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                A.FNRowPartID
            FROM TRPTSalDailyByCashierTmp A WITH(NOLOCK)
            WHERE A.FTComName   = '$tComName'
            AND A.FTRptCode     = '$tRptCode'
            AND A.FTUsrSession  = '$tUsrSession'
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

        $tSQL = "   UPDATE TRPTSalDailyByCashierTmp SET 
                        FNRowPartID = B.PartID
                    FROM( 
                        SELECT 
                            ROW_NUMBER() OVER(PARTITION BY FTUsrCode ORDER BY FTUsrCode,FTTnsType,FTRcvCode ASC) AS PartID,
                            FNRptRowSeq
                        FROM TRPTSalDailyByCashierTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName		= '$ptComName' 
                        AND TMP.FTRptCode		= '$ptRptCode'
                        AND TMP.FTUsrSession	= '$ptUsrSession' 
                    ) AS B
                    WHERE TRPTSalDailyByCashierTmp.FNRptRowSeq	= B.FNRptRowSeq 
                    AND TRPTSalDailyByCashierTmp.FTComName		= '$ptComName' 
                    AND TRPTSalDailyByCashierTmp.FTRptCode		= '$ptRptCode'
                    AND TRPTSalDailyByCashierTmp.FTUsrSession	= '$ptUsrSession'
        ";

        // echo  $tSQL;
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

        $tUserSession   = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                A.FTUsrSession
            FROM TRPTSalDailyByCashierTmp A WITH(NOLOCK)
            WHERE FTUsrSession  = '$tUserSession'
            AND FTComName       = '$tCompName'
            AND FTRptCode       = '$tRptCode'
         ";
        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }

}


