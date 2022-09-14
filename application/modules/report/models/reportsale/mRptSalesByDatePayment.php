<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalesByDatePayment extends CI_Model {


    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
    */
    public function FSnMExecStoreReport($paDataFilter){
        // // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        $tCallStore = "{ CALL SP_RPTxVDSumPayByDate(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";

        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],
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

            'ptRcvF'       => $paDataFilter['tRcvCodeFrom'],
            'ptRcvT'       => $paDataFilter['tRcvCodeTo'],

            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            'FNResult'      => 0,

        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo  $this->db->last_query();
        // die();
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
     * Creator:  03/10/2020 Witsarut
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {

        $nPage    = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];


        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM ( ISNULL(FCXrcNet, 0 ) ) AS FCXrcNet_Footer
                FROM TRPTVDSumPayByDateTmp WITH(NOLOCK)
                WHERE FTComName  = '$tComName'
                AND FTRptCode    = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
            SELECT
                '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXrcNet_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   " 
                SELECT
                    L.*,
                    T.*
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(ORDER BY FDXrcRefDate ASC) AS RowID,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCXrcNet_Sup
                    FROM TRPTVDSumPayByDateTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                        FDXrcRefDate AS FDXrcRefDate_SUM,
                            COUNT(FDXrcRefDate) AS FNRptGroupMember,
                            SUM ( ISNULL(FCXrcNet, 0 ) ) AS FCXrcNet_Sup
                        FROM TRPTVDSumPayByDateTmp WITH(NOLOCK)
                        WHERE 1=1
                        AND FTComName = '$tComName'
                        AND FTRptCode = '$tRptCode'
                        AND FTUsrSession = '$tUsrSession'
                        GROUP BY FDXrcRefDate
                    ) AS S ON A.FDXrcRefDate = S.FDXrcRefDate_SUM
                    WHERE A.FTComName  = '$tComName'
                    AND A.FTRptCode    = '$tRptCode'
                    AND A.FTUsrSession = '$tUsrSession'
                    /* End Calculate Misures */
                ) AS L
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .=  " ORDER BY L.FDXrcRefDate ASC";

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
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList
        ];
        unset($oQuery); 
        unset($aData);
        return $aResualt;
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 03/10/2020 Witsarut
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTVDSumPayByDateTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];

        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage-1;
        $nNextPage = $nPage+1;
        $nRowIDStart = (($nPerPage*$nPage)-$nPerPage); //RowId Start

        if($nRptAllRecord<=$nPerPage){
            $nTotalPage = 1;
        }else if(($nRptAllRecord % $nPerPage)==0){
            $nTotalPage = ($nRptAllRecord/$nPerPage) ;
        }else{
            $nTotalPage = ($nRptAllRecord/$nPerPage)+1;
            $nTotalPage = (int)$nTotalPage;
        }

        // get rowid end
        $nRowIDEnd = $nPerPage * $nPage;
        if($nRowIDEnd > $nRptAllRecord){
            $nRowIDEnd = $nRptAllRecord;
        }

        $aRptMemberDet = array(
            "nTotalRecord" => $nRptAllRecord,
            "nTotalPage" => $nTotalPage,
            "nDisplayPage" => $paDataWhere['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage,
            "nPerPage" => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;

    }


      /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 18/11/2019 Saharat(GolF)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];

        $tSQL = "   
            UPDATE TRPTVDSumPayByDateTmp SET
                TRPTVDSumPayByDateTmp.FNRowPartID = B.PartID
                FROM(
                    SELECT  
                    ROW_NUMBER() OVER(PARTITION BY TMP.FDXrcRefDate ORDER BY TMP.FDXrcRefDate ASC) AS PartID ,
                        TMP.FTRptRowSeq
                        FROM TRPTVDSumPayByDateTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName  = '$tComName'
                        AND TMP.FTRptCode    = '$tRptCode'
                        AND TMP.FTUsrSession = '$tUsrSession'
                ) AS B
            WHERE TRPTVDSumPayByDateTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTVDSumPayByDateTmp.FTComName = '$tComName' 
            AND TRPTVDSumPayByDateTmp.FTRptCode = '$tRptCode'
            AND TRPTVDSumPayByDateTmp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);
    }


    
}

