<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptLockerPayment extends CI_Model {

    // Functionality: Excute Sql Store
    // Parameters:  Function Parameter
    // Creator: 09/12/2019 Wasin(Yoshi)
    // Return : Call Store Proce
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tCode'];
        $tUserSession = $paDataFilter['tUsrSessionID'];
        
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
        
        //22 //13
        $tCallStore = "{ CALL SP_RPTxLocker_Payment_003001016(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            
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

            'ptCstF'        => $paDataFilter['tCstCodeFrom'],
            'ptCstT'        => $paDataFilter['tCstCodeTo'],
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        // $tTextRunStore  =   "   EXEC SP_RPTxLocker_Payment_003001016
        //                         ".$paDataFilter['nLangID'].",
        //                         '".$paDataFilter['tCompName']."',
        //                         '".$paDataFilter['tCode']."',
        //                         '".$paDataFilter['tUsrSessionID']."',
        //                         '".$paDataFilter['tBchCodeFrom']."',
        //                         '".$paDataFilter['tBchCodeTo']."',
        //                         '".$paDataFilter['tCstNameFrom']."',
        //                         '".$paDataFilter['tCstNameTo']."',
        //                         '".$paDataFilter['tDocDateFrom']."',
        //                         '".$paDataFilter['tDocDateTo']."',
        //                         0
        // ";
        // print_r($tTextRunStore);
        // exit();
        // $this->db->query($tTextRunStore);
        return;
    }

    // Functionality: Get Data Report 
    // Parameters:  Function Parameter
    // Creator: 09/12/2019 Wasin(Yoshi)
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
        if($nPage == $nTotalPage){
            $tJoinFoooter   = " SELECT
                                    FTUsrSession	    AS FTUsrSession_Footer,
                                    COUNT(FTRptCode)    AS FNCountAll_Footer,
                                    SUM(FCXrcNet)	    AS FCXrcNet_Footer,
                                    SUM(FCXrcDis)	    AS FCXrcDis_Footer,
                                    SUM(FCXrcGrand)	    AS FCXrcGrand_Footer
                                FROM TRPTRTLockerPaymentTmp WITH(NOLOCK)
                                WHERE 1 = 1
                                AND FTComName       = '$tComName'
                                AND FTRptCode       = '$tRptCode'
                                AND FTUsrSession	= '$tSession'
                                GROUP BY FTUsrSession
            ";
        }else{
            $tJoinFoooter   = " SELECT 1 AS FTXshDocType_Footer,'$tSession' AS FTUsrSession_Footer, 0 AS FCXrcNet_Footer, 0 AS FCXrcDis_Footer, 0 AS FCXrcGrand_Footer ";
        }

        $tSQL   = " SELECT
                        RPTDATA.*,
                        RPTDATAFOOT.*
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FTRptCode ASC) AS RowID,
                            A.*,
                            S.FNRptGroupMember
                        FROM TRPTRTLockerPaymentTmp A WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBchCode,
                                FTXrcDocNo,
                                COUNT(FTRptCode) AS FNRptGroupMember
                            FROM TRPTRTLockerPaymentTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession	= '$tSession'
                            GROUP BY FTBchCode,FTXrcDocNo
                        ) AS S ON A.FTBchCode = S.FTBchCode AND A.FTXrcDocNo = S.FTXrcDocNo
                        WHERE 1 = 1
                        AND A.FTComName		= '$tComName'
                        AND A.FTRptCode		= '$tRptCode'
                        AND A.FTUsrSession	= '$tSession'
                    ) RPTDATA 
                    LEFT JOIN (
                        ".$tJoinFoooter."
                    ) AS RPTDATAFOOT ON RPTDATA.FTUsrSession = RPTDATAFOOT.FTUsrSession_Footer
                    WHERE RPTDATA.RowID > $nRowIDStart AND RPTDATA.RowID <= $nRowIDEnd
                    ORDER BY RPTDATA.FTBchCode ASC, RPTDATA.FTXrcDocNo ASC, RPTDATA.FTXshDocType ASC, RPTDATA.FDXrcDocDate ASC
        ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aData  = $oQuery->result_array();
        }else{
            $aData  = NULL;
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
        unset($tSQL);
        unset($oQuery);
        unset($aData);
        unset($aErrorList);
        return $aResualt;
    }

    // Functionality: Calcurate Pagination
    // Parameters:  Function Parameter
    // Creator: 09/12/2019 Wasin(Yoshi)
    // Return : Array Data Pagination
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           = " SELECT
                                COUNT(FTRptCode) AS rnCountPage
                            FROM TRPTRTLockerPaymentTmp WITH(NOLOCK)
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
        $aRptMemberDet  = array(
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
    // Creator: 09/12/2019 Wasin(Yoshi)
    // Return : Set Priority Group Sub
    // Return Type: None
    public function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQLUPD        = " UPDATE TRPTRTLockerPaymentTmp
                            SET FNRowPartID = B.FNRowPartID
                            FROM (
                                SELECT
                                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTXrcDocNo ORDER BY FTBchCode ASC,FTXshDocType ASC,FDXrcDocDate ASC) AS FNRowPartID,
                                    FTRptRowSeq
                                FROM TRPTRTLockerPaymentTmp TMP WITH(NOLOCK)
                                WHERE 1=1
                                AND TMP.FTComName       = '$tComName' 
                                AND TMP.FTRptCode       = '$tRptCode'
                                AND TMP.FTUsrSession    = '$tUsrSession'
                            ) AS B
                            WHERE TRPTRTLockerPaymentTmp.FTRptRowSeq    = B.FTRptRowSeq
                            AND TRPTRTLockerPaymentTmp.FTComName        = '$tComName'
                            AND TRPTRTLockerPaymentTmp.FTRptCode        = '$tRptCode'
                            AND TRPTRTLockerPaymentTmp.FTUsrSession     = '$tUsrSession'
        ";
        $this->db->query($tSQLUPD);
        return;
    }

    // Functionality: Count Data In Table Temp
    // Parameters:  Function Parameter
    // Creator: 09/12/2019 Wasin(Yoshi)
    // Return : Numeric Data All In Temp
    // Return Type: None
    public function FSnMCountDataReportAll($paDataWhere){
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUserSession   = $paDataWhere['tUserSession'];
        $tSQL           = " SELECT
                                COUNT(TMP.FTRptCode) AS rnCountPage
                            FROM TRPTRTLockerPaymentTmp TMP WITH(NOLOCK)
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