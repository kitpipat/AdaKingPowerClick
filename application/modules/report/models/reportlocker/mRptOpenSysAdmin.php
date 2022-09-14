<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptOpenSysAdmin extends CI_Model {
    
    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 03/12/2019 Wasin(Yoshi)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tCode'];
        $tUserSession = $paDataFilter['tUsrSessionID'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];
     
        $tCallStore = "{ CALL SP_RPTxOpenLockerHisAdmin003001002(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
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

            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );
        // print_r($aDataStore);
        // exit;

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        // $tTextRunStore  =   "   EXEC SP_RPTxOpenLockerHisAdmin003001002
        //                         ".$paDataFilter['nLangID'].",
        //                         '".$paDataFilter['tCompName']."',
        //                         '".$paDataFilter['tCode']."',
        //                         '".$paDataFilter['tUsrSessionID']."',
        //                         '".$paDataFilter['tBchCodeFrom']."',
        //                         '".$paDataFilter['tBchCodeTo']."',
        //                         '".$paDataFilter['tShpCodeFrom']."',
        //                         '".$paDataFilter['tShpCodeTo']."',
        //                         '".$paDataFilter['tPosCodeFrom']."',
        //                         '".$paDataFilter['tPosCodeTo']."',
        //                         '".$paDataFilter['tDocDateFrom']."',
        //                         '".$paDataFilter['tDocDateTo']."',
        //                         0
        //                     ";
        // $this->db->query($tTextRunStore);
        return;
    }

    // Functionality: Get Data Report 
    // Parameters:  Function Parameter
    // Creator: 04/12/2019 Wasin(Mr.JW)
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

        $tSQL   = " SELECT RPTDATA.*
                    FROM (
                        SELECT
                            ROW_NUMBER() OVER(ORDER BY FTRptRowSeq ASC) AS RowID,
                            A.*,
                            S.FNRptGroupMember
                        FROM TRPTRTOpenLockerHisAdminTmp A WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTBchCode,
                                FTShpCode,
                                FTPosCode,
                                COUNT(FTRptCode) AS FNRptGroupMember
                            FROM TRPTRTOpenLockerHisAdminTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession	= '$tSession'
                            GROUP BY FTBchCode,FTShpCode,FTPosCode
                        ) AS S ON A.FTBchCode = S.FTBchCode AND A.FTShpCode = S.FTShpCode AND A.FTPosCode = S.FTPosCode
                        WHERE 1=1 
                        AND A.FTComName		= '$tComName'
                        AND A.FTRptCode		= '$tRptCode'
                        AND A.FTUsrSession	= '$tSession'
                    ) RPTDATA 
                    WHERE RPTDATA.RowID > $nRowIDStart AND RPTDATA.RowID <= $nRowIDEnd
                    ORDER BY FTRptRowSeq ASC
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
    // Creator: 04/12/2019 Wasin(Mr.JW)
    // Return : Array Data Pagination
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           = " SELECT
                                COUNT(FTRptCode) AS rnCountPage
                            FROM TRPTRTOpenLockerHisAdminTmp WITH(NOLOCK)
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
        $tSQLUPD        = " UPDATE TRPTRTOpenLockerHisAdminTmp
                                SET FNRowPartID = B.FNRowPartID
                            FROM (
                                SELECT
                                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTPosCode ORDER BY FTBchCode ASC,FTShpCode ASC,FTPosCode ASC) AS FNRowPartID,
                                    FTRptRowSeq
                                FROM TRPTRTOpenLockerHisAdminTmp TMP WITH(NOLOCK)
                                WHERE 1=1
                                AND TMP.FTComName       = '$tComName' 
                                AND TMP.FTRptCode       = '$tRptCode'
                                AND TMP.FTUsrSession    = '$tUsrSession'
                            ) AS B
                            WHERE TRPTRTOpenLockerHisAdminTmp.FTRptRowSeq   = B.FTRptRowSeq
                            AND TRPTRTOpenLockerHisAdminTmp.FTComName       = '$tComName'
                            AND TRPTRTOpenLockerHisAdminTmp.FTRptCode       = '$tRptCode'
                            AND TRPTRTOpenLockerHisAdminTmp.FTUsrSession    = '$tUsrSession'
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
                            FROM TRPTRTOpenLockerHisAdminTmp TMP WITH(NOLOCK)
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
