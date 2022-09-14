
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleDailyByPos extends CI_Model {

    // Functionality: Call Stored Procedure
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Status Return Call Stored Procedure
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID        = $paDataFilter['nLangID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSession'];
        $tFilterType    = $paDataFilter['nFilterType'];

        // สาขา
        $tBchCodeSelect = FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
        // /แคชเชีย
        $tCstCodeSelect = FCNtAddSingleQuote($paDataFilter['tCashierCodeSelect']);

        $tCallStore = "{CALL SP_RPTxSalDailyByPosTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $tFilterType,

            //สาขา
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            //shop
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],

             //pos
            'ptPosCodeL'    => $tPosCodeSelect,
            'ptPosCodeF'    => $paDataFilter['tRptPosCodeFrom'],
            'ptPosCodeT'    => $paDataFilter['tRptPosCodeTo'],

            //cashier
            'ptUsrL'        => $tCstCodeSelect,
            'ptUsrF'        => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT'        => $paDataFilter['tCashierCodeTo'],

            //date
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();
        // exit;

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
                    FROM TRPTSalDailyByPosTmp A WITH(NOLOCK)
                    WHERE A.FTComName = '$tComName'
                    AND A.FTRptCode = '$tRptCode'
                    AND A.FTUsrSession = '$tUsrSession'
                ) AS L";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        $tSQL .= " ORDER BY FTBchCode , FTPosCode , FTTnsType";
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
                FROM TRPTSalDailyByPosTmp SPCTMP WITH(NOLOCK)
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
            UPDATE TRPTSalDailyByPosTmp
                SET TRPTSalDailyByPosTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FTBchCode ORDER BY TSPT.FTBchCode ASC) AS PartID ,
                        --ROW_NUMBER() OVER(PARTITION BY TSPT.FTBchCode , TSPT.FTRcvCode ORDER BY TSPT.FTBchCode , TSPT.FTRcvCode ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTSalDailyByPosTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode  = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";

        $tSQL  .= "
            ) AS B
                WHERE 1=1
                AND TRPTSalDailyByPosTmp.FTRptRowSeq = B.FTRptRowSeq
                AND TRPTSalDailyByPosTmp.FTComName = '$tComName'
                AND TRPTSalDailyByPosTmp.FTRptCode = '$tRptCode'
                AND TRPTSalDailyByPosTmp.FTUsrSession = '$tUsrSession' ";

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
                         FROM TRPTSalDailyByPosTmp AS TTDT WITH(NOLOCK)
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
