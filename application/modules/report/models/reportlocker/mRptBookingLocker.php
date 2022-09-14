<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mRptBookingLocker extends CI_Model {

    // Functionality: Call Store
    // Parameters:  Function Parameter
    // Creator: 27/11/2019 Wasin(Mr.JW)
    // Return : Status Call Store
    // Return Type: Numeric
    public function FSnMExecStoreReport($paDataFilter){
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];
        // กลุ่มธุระกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        // ขนาด
        $tPzeCodeSelect = ($paDataFilter['bPzeStaSelectAll']) ? '' : $paDataFilter['tPzeCodeSelect'];

        $tCallStore = "{ CALL SP_RPTxBookingLocker003001010(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'ptComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tCode'],
            'ptUsrSession'  => $paDataFilter['tUsrSessionID'],

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

            'ptPzeF'        => $paDataFilter['tPzeCodeFrom'],
            'ptPzeT'        => $paDataFilter['tPzeCodeTo'],
            'ptDateF'       => $paDataFilter['tDocDateFrom'],
            'ptDateT'       => $paDataFilter['tDocDateTo'],
            'ptStaBK'       => $paDataFilter['tStaBooking'],
            'ptStaPD'       => $paDataFilter['tStaProducer'],
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

    // Functionality: Get Data Report 
    // Parameters:  Function Parameter
    // Creator: 27/11/2019 Wasin(Mr.JW)
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

        $tSQL   = " SELECT RPTBKGDATA.*
                    FROM (
                        SELECT 
                            ROW_NUMBER() OVER(ORDER BY A.FTBkgToBch ASC,A.FTBkgToShp ASC,A.FTBkgToPos ASC,A.FDBkgToStartDate ASC,A.FTBkgToStartTime ASC) AS RowID,
                            A.*,
                            S.FNRptGroupMember
                        FROM TRPTRTBookingTmp A WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBkgToBch,
                                FTBkgToShp,
                                FTBkgToPos,
                                COUNT(FTRptCode) AS FNRptGroupMember
                            FROM TRPTRTBookingTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession	= '$tSession'
                            GROUP BY FTBkgToBch,FTBkgToShp,FTBkgToPos
                        ) AS S ON A.FTBkgToBch = S.FTBkgToBch AND A.FTBkgToShp = S.FTBkgToShp AND A.FTBkgToPos = S.FTBkgToPos
                        WHERE 1=1 
                        AND A.FTComName		= '$tComName'
                        AND A.FTRptCode		= '$tRptCode'
                        AND A.FTUsrSession	= '$tSession'
                    ) RPTBKGDATA 
                    WHERE RPTBKGDATA.RowID > $nRowIDStart AND RPTBKGDATA.RowID <= $nRowIDEnd
                    ORDER BY
                    RPTBKGDATA.FTBkgToBch ASC,
                    RPTBKGDATA.FTBkgToShp ASC,
                    RPTBKGDATA.FTBkgToPos ASC,
                    RPTBKGDATA.FDBkgToStartDate ASC,
                    RPTBKGDATA.FTBkgToStartTime ASC
        ";
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

    // Functionality: Calcurate Pagination
    // Parameters:  Function Parameter
    // Creator: 27/11/2019 Wasin(Mr.JW)
    // Return : Array Data Pagination
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           = " SELECT
                                COUNT(FTRptCode) AS rnCountPage
                            FROM TRPTRTBookingTmp WITH(NOLOCK)
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
        return $aRptMemberDet;
    }
    
    // Functionality: Set Priority Group Sub
    // Parameters:  Function Parameter
    // Creator: 29/11/2019 Wasin(Yoshi)
    // Return : Set Priority Group Sub
    // Return Type: None
    public function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQLUPD        = " UPDATE TRPTRTBookingTmp
                                SET FNRowPartID = B.FNRowPartID
                            FROM (
                                SELECT
                                    ROW_NUMBER() OVER(
                                        PARTITION BY FTBkgToBch,FTBkgToShp,FTBkgToPos
                                        ORDER BY FTBkgToBch ASC,FTBkgToShp ASC,FTBkgToPos ASC,FDBkgToStartDate ASC,FTBkgToStartTime ASC
                                    ) AS FNRowPartID,
                                    FTRptRowSeq
                                FROM TRPTRTBookingTmp TMP WITH(NOLOCK)
                                WHERE 1=1
                                AND TMP.FTComName       = '$tComName' 
                                AND TMP.FTRptCode       = '$tRptCode'
                                AND TMP.FTUsrSession    = '$tUsrSession'
                            ) AS B
                            WHERE TRPTRTBookingTmp.FTRptRowSeq = B.FTRptRowSeq
                            AND TRPTRTBookingTmp.FTComName      = '$tComName'
                            AND TRPTRTBookingTmp.FTRptCode      = '$tRptCode'
                            AND TRPTRTBookingTmp.FTUsrSession   = '$tUsrSession'
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
                                COUNT(TMP.FTRptCode) AS rnCountPage
                            FROM TRPTRTBookingTmp TMP WITH(NOLOCK)
                            WHERE 1=1
                            AND TMP.FTUsrSession    = '$tUserSession'
                            AND TMP.FTComName       = '$tCompName'
                            AND TMP.FTRptCode       = '$tRptCode'
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