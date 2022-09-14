
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptDailySalesPosSv extends CI_Model {

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
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPSSaleDailyTmp09(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $tFilterType,
            
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
            
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
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

    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 23/12/2019 Witsarut (Bell)
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
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

        if($nPage == $nTotalPage){
            $tRptJoinFooter = " SELECT
                                    FTUsrSession    AS FTUsrSession_Footer,
                                    CONVERT(FLOAT,SUM(FNcshCountBill))	 AS FNcshCountBill_Footer,    
                                    CONVERT(FLOAT,SUM(FCXsdGrandTotal))  AS FCXsdGrandTotal_Footer,   
                                    CONVERT(FLOAT,SUM(FCXshCashCoupon))	 AS FCXshCashCoupon_Footer,  
                                    CONVERT(FLOAT,SUM(FCXshAmtAFDisc))	 AS FCXshAmtAFDisc_Footer,   
                                    CONVERT(FLOAT,SUM(FCXsdVatable))	 AS FCXsdVatable_Footer,   
                                    CONVERT(FLOAT,SUM(FCXsdVat))	     AS FCXsdVat_Footer,    
                                    CONVERT(FLOAT,SUM(FCXshAllInOne))	 AS FCXshAllInOne_Footer,  
                                    CONVERT(FLOAT,SUM(FCXshElocker))	 AS FCXshElocker_Footer, 
                                    CONVERT(FLOAT,SUM(FCXshDoctor))	     AS FCXshDoctor_Footer, 
                                    CONVERT(FLOAT,SUM(FCXshTelemedi))	 AS FCXshTelemedi_Footer 
                                FROM TRPTPTTSpcPSSaleDailyTmp WITH(NOLOCK)
                                WHERE 1=1
                                    AND FTComName       = '$tComName'
                                    AND FTRptCode		= '$tRptCode'
                                    AND FTUsrSession    = '$tUsrSession'
                                    GROUP BY FTUsrSession
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                        0 AS FNcshCountBill_Footer,
                        0 AS FCXsdGrandTotal_Footer,
                        0 AS FCXshCashCoupon_Footer,
                        0 AS FCXshAmtAFDisc_Footer,
                        0 AS FCXsdVatable_Footer,
                        0 AS FCXsdVat_Footer,
                        0 AS FCXshAllInOne_Footer,
                        0 AS FCXshElocker_Footer,
                        0 AS FCXshDoctor_Footer,
                        0 AS FCXshTelemedi_Footer
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
                                ROW_NUMBER() OVER(ORDER BY DATA.FDXshDocDate) AS RowID,
                                DATA.*,
                                DTSUMGRP.*
                        FROM TRPTPTTSpcPSSaleDailyTmp DATA WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT
                                CONVERT(FLOAT,SUM(FNcshCountBill))	 AS FNcshCountBill_SUBFooter,    
                                CONVERT(FLOAT,SUM(FCXsdGrandTotal))  AS FCXsdGrandTotal_SUBFooter, 
                                CONVERT(FLOAT,SUM(FCXshCashCoupon))	 AS FCXshCashCoupon_SUBFooter,     
                                CONVERT(FLOAT,SUM(FCXshAmtAFDisc))	 AS FCXshAmtAFDisc_SUBFooter,   
                                CONVERT(FLOAT,SUM(FCXsdVatable))	 AS FCXsdVatable_SUBFooter,  
                                CONVERT(FLOAT,SUM(FCXsdVat))	     AS FCXsdVat_SUBFooter,    
                                CONVERT(FLOAT,SUM(FCXshAllInOne))	 AS FCXshAllInOne_SUBFooter,  
                                CONVERT(FLOAT,SUM(FCXshElocker))	 AS FCXshElocker_SUBFooter, 
                                CONVERT(FLOAT,SUM(FCXshDoctor))	     AS FCXshDoctor_SUBFooter, 
                                CONVERT(FLOAT,SUM(FCXshTelemedi))	 AS FCXshTelemedi_SUBFooter 
                            FROM TRPTPTTSpcPSSaleDailyTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName			= '$tComName'
                            AND FTRptCode			= '$tRptCode'
                            AND FTUsrSession        = '$tUsrSession'
                            GROUP BY FCXshCashCoupon
                        ) DTSUMGRP ON DATA.FCXshCashCoupon = DTSUMGRP.FCXshCashCoupon_SUBFooter
                        WHERE 1=1
                        AND DATA.FTComName 			= '$tComName'
                        AND DATA.FTRptCode			= '$tRptCode'
                        AND DATA.FTUsrSession		= '$tUsrSession'
                    ) L
                    LEFT JOIN (
                        ".$tRptJoinFooter."
            ";
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
            FROM TRPTPTTSpcPSSaleDailyTmp SPCTMP WITH(NOLOCK)
            WHERE SPCTMP.FTComName  = '$tComName'
            AND SPCTMP.FTRptCode    = '$tRptCode'
            AND SPCTMP.FTUsrSession = '$tUsrSession'";

        $oQuery     = $this->db->query($tSQL);
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
            UPDATE TRPTPTTSpcPSSaleDailyTmp
                SET TRPTPTTSpcPSSaleDailyTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FDXshDocDate ORDER BY TSPT.FDXshDocDate ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTPTTSpcPSSaleDailyTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode  = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";
              

            $tSQL  .= "
                ) AS B
                    WHERE 1=1
                    AND TRPTPTTSpcPSSaleDailyTmp.FTRptRowSeq = B.FTRptRowSeq
                    AND TRPTPTTSpcPSSaleDailyTmp.FTComName = '$tComName' 
                    AND TRPTPTTSpcPSSaleDailyTmp.FTRptCode = '$tRptCode'
                    AND TRPTPTTSpcPSSaleDailyTmp.FTUsrSession = '$tUsrSession' ";

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
                         FROM TRPTPTTSpcPSSaleDailyTmp AS TTDT WITH(NOLOCK)
                         WHERE 1 = 1
                         AND FTUsrSession    = '$tUserSession'
                         AND FTComName       = '$tCompName'
                         AND FTRptCode       = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }


    
    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 23/12/2019 Witsarut
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere){
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSessionID  = $paDataWhere['tUsrSessionID'];

        $tSQL = "  
            SELECT
                    ISNULL(SUM(FNcshCountBill),0) AS FNcshCountBill_Sum,
                    ISNULL(SUM(FCXsdGrandTotal),0) AS FCXsdGrandTotal_Sum,
                    ISNULL(SUM(FCXshCashCoupon),0) AS FCXshCashCoupon_Sum,
                    ISNULL(SUM(FCXshAmtAFDisc),0) AS FCXshAmtAFDisc_Sum,
                    ISNULL(SUM(FCXsdVatable),0) AS FCXsdVatable_Sum,
                    ISNULL(SUM(FCXsdVat),0) AS FCXsdVat_Sum,
                    ISNULL(SUM(FCXshAllInOne),0) AS FCXshAllInOne_Sum,
                    ISNULL(SUM(FCXshElocker),0) AS FCXshElocker_Sum,
                    ISNULL(SUM(FCXshDoctor),0) AS FCXshDoctor_Sum,
                    ISNULL(SUM(FCXshTelemedi),0) AS FCXshTelemedi_Sum
            FROM TRPTPTTSpcPSSaleDailyTmp
            WHERE FTUsrSession = '$tUsrSessionID'
            AND FTComName = '$tCompName' 
            AND FTRptCode = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
       
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

   
}


