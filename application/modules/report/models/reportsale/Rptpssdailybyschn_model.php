
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Rptpssdailybyschn_model extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter) {
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        //AGN
        $tAgnCode       = empty($paDataFilter['tAgnCodeSelect']) ? '' : $paDataFilter['tAgnCodeSelect'];

        // สาขา
        $tBchCodeFrom   = empty($paDataFilter['tBchCodeFrom']) ? '' : $paDataFilter['tBchCodeFrom'];
        $tBchCodeTo     = empty($paDataFilter['tBchCodeTo']) ? '' : $paDataFilter['tBchCodeTo'];
        $tBchCodeSelect = empty($paDataFilter['tBchCodeSelect']) ? '' : $paDataFilter['tBchCodeSelect'];

        // ร้านค้า
        $tShpCodeFrom   = empty($paDataFilter['tShpCodeFrom']) ? '' : $paDataFilter['tShpCodeFrom'];
        $tShpCodeTo     = empty($paDataFilter['tShpCodeTo']) ? '' : $paDataFilter['tShpCodeTo'];
        $tShpCodeSelect = empty($paDataFilter['tShpCodeSelect']) ? '' : $paDataFilter['tShpCodeSelect'];

        // วันที่เอกสาร
        $tDateFrom      = empty($paDataFilter['tDocDateFrom']) ? '' : $paDataFilter['tDocDateFrom'];
        $tDateTo        = empty($paDataFilter['tDocDateTo']) ? '' : $paDataFilter['tDocDateTo'];

        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxPSSDailyBySChn(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";


        $aDataStore = array(
            'pnLngID'      => $nLangID,
            'pnComName'    => $tComName,
            'ptRptCode'    => $tRptCode,
            'ptUsrSession' => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptAgnL'        => $tAgnCode,
            'ptBchL'        => $tBchCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptPosL'        => $tPosCodeSelect,
            'ptChnF'        => $paDataFilter['tChnCodeFrom'],
            'ptChnT'        => $paDataFilter['tChnCodeTo'],
            'ptCstCodeF'   => $paDataFilter['tCstCodeFrom'],
            'ptCstCodeT'   => $paDataFilter['tCstCodeTo'],
            'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'   => $paDataFilter['tDocDateTo'],
            'FNResult'     => 0,
        );

        // $aDataStore = array(
        //     'pnLngID'      => 1,
        //     'pnComName'    => 'kubernetes.docker.internal',
        //     'ptRptCode'    => '001001039',
        //     'ptUsrSession' => '0000420210716101130',
        //     'pnFilterType'  => 2,
        //     'ptAgnL'        => '00001',
        //     'ptBchL'        => '00001',
        //     'ptShpL'        => '',
        //     'ptPosL'        => '',
        //     'ptChnF'        => '00001',
        //     'ptChnT'        => '00003',
        //     'ptCstCodeF'   => '001',
        //     'ptCstCodeT'   => '001',
        //     'ptDocDateF'   => '2021-06-01',
        //     'ptDocDateT'   => '2021-06-30',
        //     'FNResult'     => 0,
        // );



        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }


    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut (Bell)
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){

        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        $tSQL = "
                SELECT
                    L.*
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY FTBchCode) AS RowID,
                        A.*
                    FROM TRPTPSSDailyBySChnTmp A WITH(NOLOCK)
                    WHERE A.FTComName = '$tComName'
                    AND A.FTRptCode = '$tRptCode'
                    AND A.FTUsrSession = '$tUsrSession'
                ) AS L";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        $tSQL .= " ORDER BY FTBchCode , FTPosCode ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $aData = $oQuery->result_array();

        }else{
            $aData = NULL;
        }

        $aErrorList = [
            "nErrInvalidPage" => ""
        ];

        $aResualt= [
            "aPagination"   => $aPagination,
            "aRptData"      => $aData,
            "aError"        => $aErrorList
        ];
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "
                SELECT
                    SPCTMP.FTRptCode
                FROM TRPTPSSDailyBySChnTmp SPCTMP WITH(NOLOCK)
                WHERE SPCTMP.FTComName  = '$tComName'
                AND SPCTMP.FTRptCode    = '$tRptCode'
                AND SPCTMP.FTUsrSession = '$tUsrSession'";

        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->num_rows();
        $nPage          = $paDataWhere['nPage'];
        $nPerPage       = $paDataWhere['nPerPage'];
        $nPrevPage      = $nPage-1;
        $nNextPage      = $nPage+1;

        $nRowIDStart = (($nPerPage*$nPage)-$nPerPage);
        if($nRptAllRecord<=$nPerPage){
            $nTotalPage = 1;
        }else if(($nRptAllRecord % $nPerPage)==0){
            $nTotalPage = ($nRptAllRecord/$nPerPage) ;
        }else{
            $nTotalPage = ($nRptAllRecord/$nPerPage)+1;
            $nTotalPage = (int)$nTotalPage;
        }

        $nRowIDEnd = $nPerPage * $nPage;
        if($nRowIDEnd > $nRptAllRecord){
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage,
            "nPerPage"      => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }


    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "
            UPDATE TRPTPSSDailyBySChnTmp
                SET TRPTPSSDailyBySChnTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FTBchCode ORDER BY TSPT.FTBchCode ASC) AS PartID ,
                        --ROW_NUMBER() OVER(PARTITION BY TSPT.FTBchCode , TSPT.FTRcvCode ORDER BY TSPT.FTBchCode , TSPT.FTRcvCode ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTPSSDailyBySChnTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode  = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";

        $tSQL  .= "
            ) AS B
                WHERE 1=1
                AND TRPTPSSDailyBySChnTmp.FTRptRowSeq = B.FTRptRowSeq
                AND TRPTPSSDailyBySChnTmp.FTComName = '$tComName'
                AND TRPTPSSDailyBySChnTmp.FTRptCode = '$tRptCode'
                AND TRPTPSSDailyBySChnTmp.FTUsrSession = '$tUsrSession' ";

        $this->db->query($tSQL);
    }


    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Saharat(Golf)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountRowInTemp($paDataWhere) {

        $tUserSession   = $paDataWhere['tUsrSessionID'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "   SELECT
                             COUNT(TTDT.FTRptCode) AS rnCountPage
                         FROM TRPTPSSDailyBySChnTmp AS TTDT WITH(NOLOCK)
                         WHERE 1 = 1
                         AND FTUsrSession    = '$tUserSession'
                         AND FTComName       = '$tCompName'
                         AND FTRptCode       = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

}
