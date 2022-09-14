<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptLicClosetExpir extends CI_Model {

     // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/01/2021 
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter) {

        
        // สาขา
        $tBchCodeSelect =   FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 


        $tCallStore     = "{ CALL SP_RPTLicClosetExpirTmp(?,?,?,?,?,?,?,?,?,?) }";
        
        $aDataStore = array(
            'pnLngID'         => $paDataFilter['nLangID'],
            'pnComName'       => $paDataFilter['tCompName'],
            'ptRptCode'       => $paDataFilter['tRptCode'],
            'ptUsrSession'    => $paDataFilter['tSessionID'],

            'ptExp'          => $paDataFilter['tExpMonth'],

            'ptPdtCodeF' => $paDataFilter['tPdtCodeFrom'],
            'ptPdtCodeT' => $paDataFilter['tPdtCodeTo'],

            'ptCstCodeF'   => $paDataFilter['tCstCodeFrom'],
            'ptCstCodeT'   => $paDataFilter['tCstCodeTo'],

            'FNResult'        => 0
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


    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/08/2021 Witsarut(Bell)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){

        $nPage  =  $paDataWhere['nPage'];


        // Call Data Pagination
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL   = " SELECT M.*
                    FROM
                    (
                        SELECT ROW_NUMBER() OVER(
                                ORDER BY FTCstCode, 
                                        FDLicFinish ASC) AS RowID, 
                                A.*, 
                                S.FNRptGroupMember
                        FROM TRPTLicClosetExpirTmp A
                            LEFT JOIN
                        (
                            SELECT FTCstCode AS FTCstCode_SUM, 
                                    COUNT(FTCstCode) AS FNRptGroupMember
                            FROM TRPTLicClosetExpirTmp WITH(NOLOCK)
                            WHERE 1 = 1
                                AND FTComName = '$tComName'
                                AND FTRptCode = '$tRptCode'
                                AND FTUsrSession = '$tUsrSession'
                            GROUP BY FTCstCode
                        ) AS S ON A.FTCstCode = S.FTCstCode_SUM
                    )AS M
                ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE M.RowID > $nRowIDStart AND M.RowID <= $nRowIDEnd "; 

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY M.FTCstCode,M.FDLicFinish";

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



    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 19/01/2021 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTLicPdtCode) AS rnCountPage
            FROM TRPTLicClosetExpirTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName    = '$tComName'
            AND TMP.FTRptCode    = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
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

        unset($oQuery);
        return $aRptMemberDet;
    }



        
}



