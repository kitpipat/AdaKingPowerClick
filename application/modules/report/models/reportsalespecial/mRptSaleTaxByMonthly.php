<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleTaxByMonthly extends CI_Model {

    // Functionality: Call Store
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return : Status Call Store
    // Return Type: Numeric
    public function FSnMExecStoreReport($paDataFilter){
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxPSSMonthlyVat07(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";  
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tCode'],
            'ptUsrSession'  => $paDataFilter['tUsrSessionID'],
            'pnFilterType'  => $paDataFilter['nTypeDataCondition'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosCodeL'    => $tPosCodeSelect,
            'ptPosCodeF'    => $paDataFilter['tPosCodeFrom'],
            'ptPosCodeT'    => $paDataFilter['tPosCodeTo'],
            'ptPayF'        => $paDataFilter['tRcvCodeFrom'],
            'ptPayT'        => $paDataFilter['tRcvCodeTo'],
            // 'ptMonth'       => $paDataFilter['tMonth'],
            // 'ptYear'        => $paDataFilter['tYear'],
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );
        $oQuery = $this->db->query($tCallStore,$aDataStore);
        if ($oQuery != FALSE) {
            return 1;
        } else {
            return 0;
        }
    }

    // Functionality: Get Data Report 
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return : Array Data Report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){
        $nPage          = $paDataWhere['nPage'];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tSession       = $paDataWhere['tUsrSessionID'];
        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        
        // Update Priority Group Ping Sub
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if($nPage == $nTotalPage) {
            $tJoinFoooter   = " SELECT
                                    FTUsrSession        AS FTUsrSession_Footer,
                                    COUNT(FTRptCode)    AS FNDataAll_Footer,
                                    SUM(FCXsdVatable)   AS FCXsdVatable_Footer,
                                    SUM(FCXsdVat)       AS FCXsdVat_Footer
                                FROM TRPTPSTaxMonthlyTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName       = '$tComName'
                                AND FTRptCode       = '$tRptCode'
                                AND FTUsrSession    = '$tSession'
                                GROUP BY FTUsrSession
                                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tJoinFoooter   = " SELECT
                                    '$tSession'         AS FTUsrSession_Footer,
                                    COUNT(FTRptCode)    AS FNDataAll_Footer,
                                    0   AS FCXsdVatable_Footer,
                                    0   AS FCXsdVat_Footer
                                FROM TRPTPSTaxMonthlyTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName       = '$tComName'
                                AND FTRptCode       = '$tRptCode'
                                AND FTUsrSession    = '$tSession'
                                GROUP BY FTUsrSession
                                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        $tSQL   = " SELECT
                        L.*,
                        T.*
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER( ORDER BY A.FTRcvCode ASC,A.FTPosCode ASC,A.FDXshDocDate ASC ) AS FNRowID,
                            A.*,
                            S.FNRptGroupMember,
                            S.FCXsdVatable_SubTotal,
                            S.FCXsdVat_SubTotal
                        FROM TRPTPSTaxMonthlyTmp A WITH(NOLOCK)
                        INNER JOIN (
                            SELECT DISTINCT
                                FTRcvCode,
                                COUNT(FTRptCode)	AS FNRptGroupMember,
                                SUM(FCXsdVatable)	AS FCXsdVatable_SubTotal,
                                SUM(FCXsdVat)		AS FCXsdVat_SubTotal
                            FROM TRPTPSTaxMonthlyTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession	= '$tSession'
                            GROUP BY FTRcvCode
                        ) AS S ON A.FTRcvCode = S.FTRcvCode
                        WHERE 1=1
                        AND A.FTComName     = '$tComName'
                        AND A.FTRptCode     = '$tRptCode'
                        AND A.FTUsrSession  = '$tSession'
                    ) AS L
                    LEFT JOIN (
                        $tJoinFoooter
                    WHERE L.FNRowID > $nRowIDStart AND L.FNRowID <= $nRowIDEnd
                    ORDER BY L.FTRcvCode ASC,L.FTPosCode ASC,L.FDXshDocDate ASC";



        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData  = $oQuery->result_array();
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
        unset($nPage);
        unset($tComName);
        unset($tRptCode);
        unset($tSession);
        unset($aPagination);
        unset($nRowIDStart);
        unset($nRowIDEnd);
        unset($nTotalPage);
        // unset($tSQL);
        // unset($oQuery);
        unset($aData);
        unset($aErrorList);
        return $aResualt;
    }

    // Functionality: Calcurate Pagination
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return : Array Data Pagination
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           = " SELECT
                                COUNT(FTRptCode) AS rnCountPage
                            FROM TRPTPSTaxMonthlyTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUsrSession'
        ";
        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];
        $nPage          = $paDataWhere['nPage'];
        $nPerPage       = $paDataWhere['nPerPage'];
        $nPrevPage      = $nPage - 1;
        $nNextPage      = $nPage + 1;
        $nRowIDStart    = (($nPerPage * $nPage) - $nPerPage); //RowId Start
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
        unset($tComName);
        unset($tRptCode);
        unset($tUsrSession);
        unset($tSQL);
        unset($nRptAllRecord);
        unset($nRowIDStart);
        unset($nRowIDEnd);
        unset($nTotalPage);
        return $aRptMemberDet;
    }

    // Functionality: Set Priority Group Sub
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return : Set Priority Group Sub
    // Return Type: None
    public function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQLUPD        = " UPDATE TRPTPSTaxMonthlyTmp
                            SET FNRowPartID = B.FNRowPartID
                            FROM (
                                SELECT
                                    ROW_NUMBER() OVER (
                                        PARTITION BY TMP.FTRcvCode
                                        ORDER BY TMP.FTRcvCode ASC,TMP.FTPosCode ASC,TMP.FDXshDocDate ASC
                                    ) AS FNRowPartID,
                                    TMP.FTRptRowSeq
                                FROM TRPTPSTaxMonthlyTmp TMP WITH(NOLOCK)
                                WHERE 1=1
                                AND TMP.FTComName       = '$tComName' 
                                AND TMP.FTRptCode       = '$tRptCode'
                                AND TMP.FTUsrSession    = '$tUsrSession'
                            ) AS B
                            WHERE TRPTPSTaxMonthlyTmp.FTRptRowSeq   = B.FTRptRowSeq
                            AND TRPTPSTaxMonthlyTmp.FTComName       = '$tComName'
                            AND TRPTPSTaxMonthlyTmp.FTRptCode       = '$tRptCode'
                            AND TRPTPSTaxMonthlyTmp.FTUsrSession    = '$tUsrSession'
        ";
        $this->db->query($tSQLUPD);
        return;
    }

    // Functionality: Count Data In Table Temp
    // Parameters:  Function Parameter
    // Creator: 02/12/2019 Wasin(Yoshi)
    // Return : Numeric Data All In Temp
    // Return Type: None
    public function FSnMCountDataReportAll($paDataWhere){
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUserSession   = $paDataWhere['tUserSession'];
        $tSQL           = " SELECT
                                COUNT(FTRptCode) AS rnCountPage
                            FROM TRPTPSTaxMonthlyTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tCompName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tUserSession'
        ";
        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];
        unset($tCompName);
        unset($tRptCode);
        unset($tUserSession);
        unset($tSQL);
        unset($oQuery);
        return $nRptAllRecord;
    }

}