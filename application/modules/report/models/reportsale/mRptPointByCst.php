<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptPointByCst extends CI_Model {


   /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 30/07/2020 Witsarut (Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
        $tCallStore = "{ CALL SP_RPTxPointByCst(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";

        $aDataStore  = array(
            'pnLngID'      => $nLangID,
            'pnComName'    => $tComName,
            'ptRptCode'    => $tRptCode,
            'ptUsrSession' => $tUserSession,

            'pnFilterType' => $paDataFilter['tTypeSelect'],

            'ptBchL'       => $tBchCodeSelect,
            'ptBchF'       => $paDataFilter['tBchCodeFrom'],
            'ptBchT'       => $paDataFilter['tBchCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptCstCodeF'   => $paDataFilter['tCstCodeFrom'],
            'ptCstCodeT'   => $paDataFilter['tCstCodeTo'],

            'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'   => $paDataFilter['tDocDateTo'],

            'FNResult'     => 0,
        );

     
        $oQuery = $this->db->query($tCallStore, $aDataStore);


        // echo $this->db->last_query($oQuery);
        // die;

        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }

    }


    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 22/07/2020 Witsarut(Bell)
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){


        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];


        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);


        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " SELECT 
                                    FTUsrSession          AS FTUsrSession_Footer,
                                    CONVERT(FLOAT,SUM(FCTxnPntGet))	    AS FCTxnPntGet_Footer,
                                    CONVERT(FLOAT,SUM(FCTxnPntUsed))	AS FCTxnPntUsed_Footer,
                                    CONVERT(FLOAT,SUM(FCTxnPntBal))	    AS FCTxnPntBal_Footer
                                FROM TRPTPointByCstTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName			= '$tComName'
                                AND FTRptCode			= '$tRptCode'
                                AND FTUsrSession        = '$tUsrSession'
                                GROUP BY FTUsrSession
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                        '$tUsrSession' AS FTUsrSession_Footer,
                        0 AS FCTxnPntGet_Footer,
                        0 AS FCTxnPntUsed_Footer,
                        0 AS FCTxnPntBal_Footer
                    ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
                ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   SELECT
                            L.*,
                            T.*  
                        FROM (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY DATA.FNAppType,DATA.FTMemCode) AS RowID,
                                DATA.*,
                                CONVERT(VARCHAR(10), DATA.FDCstApply, 103) AS rdFDCstApply,
                                CONVERT(VARCHAR(10), DATA.FDCstCrdExpire, 103) AS rdFDCstCrdExpire,
                                DTSUMGRP.*
                            FROM TRPTPointByCstTmp DATA WITH(NOLOCK)
                            LEFT JOIN (
                                SELECT
                                    FNAppType AS FNAppType_SUBAPP,
                                    COUNT(FNAppType)	    AS FNRptGroupMember_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCTxnPntGet))	    AS FCTxnPntGet_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCTxnPntUsed))	AS FCTxnPntUsed_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCTxnPntBal))	    AS FCTxnPntBal_SUBAPP
                                FROM TRPTPointByCstTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName			= '$tComName'
                                AND FTRptCode			= '$tRptCode'
                                AND FTUsrSession        = '$tUsrSession'
                                GROUP BY FNAppType
                                ) DTSUMGRP ON DATA.FNAppType = DTSUMGRP.FNAppType_SUBAPP
                            WHERE 1=1
                            AND DATA.FTComName 			= '$tComName'
                            AND DATA.FTRptCode			= '$tRptCode'
                            AND DATA.FTUsrSession		= '$tUsrSession'
                        ) L
                        LEFT JOIN (
                            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTMemCode ASC"; 

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
     * Creator: 22/07/2020 witsarut(Bell)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = " SELECT
                    TSPT.FTRptCode
            FROM TRPTPointByCstTmp TSPT WITH(NOLOCK)
            WHERE TSPT.FTComName  = '$tComName'
            AND TSPT.FTRptCode    = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();

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
     * Creator: 01/09/2019 witsarut(Bell)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere){
      
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];


        $tSQL = " UPDATE TRPTPointByCstTmp 
                    SET TRPTPointByCstTmp.FNRowPartID = B.PartID
                FROM ( SELECT
                    ROW_NUMBER() OVER(PARTITION BY TSPT.FTMemCode ORDER BY TSPT.FTMemCode ASC) AS PartID ,
                    TSPT.FTRptRowSeq
                    FROM TRPTPointByCstTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";

                    $tSQL  .= "
                        ) AS B
                        WHERE 1=1
                        AND TRPTPointByCstTmp.FTRptRowSeq = B.FTRptRowSeq
                        AND TRPTPointByCstTmp.FTComName = '$tComName' 
                        AND TRPTPointByCstTmp.FTRptCode = '$tRptCode'
                        AND TRPTPointByCstTmp.FTUsrSession = '$tUsrSession' ";

        $this->db->query($tSQL);
    }







}