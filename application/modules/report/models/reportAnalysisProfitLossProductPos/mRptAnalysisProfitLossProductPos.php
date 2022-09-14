<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptAnalysisProfitLossProductPos extends CI_Model {
    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPSSalByProfitByLoss(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID, 
            'pnComName'         => $tComName,
            'ptRptCode'         => $tRptCode,
            'ptUsrSession'      => $tUserSession,
            
            'pnFilterType'      => $paDataFilter['tTypeSelect'],
            'ptBchL'            => $tBchCodeSelect,
            'ptBchF'            => $paDataFilter['tBchCodeFrom'],
            'ptBchT'            => $paDataFilter['tBchCodeTo'],
            'ptMerL'            => $tMerCodeSelect,
            'ptMerF'            => $paDataFilter['tRptMerCodeFrom'],
            'ptMerT'            => $paDataFilter['tRptMerCodeTo'],
            'ptShpL'            => $tShpCodeSelect,
            'ptShpF'            => $paDataFilter['tRptShpCodeFrom'],
            'ptShpT'            => $paDataFilter['tRptShpCodeTo'],
            'ptPosL'            => $tPosCodeSelect,
            'ptPosF'            => $paDataFilter['tRptPosCodeFrom'],
            'ptPosT'            => $paDataFilter['tRptPosCodeTo'],

            'ptChainCodeF'      => $paDataFilter['tRptPdtGrpCodeFrom'],
            'ptChainCodeT'      => $paDataFilter['tRptPdtGrpCodeTo'],
            'ptProductCodeF'    => $paDataFilter['tRptPdtCodeFrom'],
            'ptProductCodeT'    => $paDataFilter['tRptPdtCodeTo'],
            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
            'FTResult'          => 0
        );


        // print_r($aDataStore); die();

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];
        $tPosType   = $paParams['aDataFilter']['tPosType'];

        $tSQL = "   
            SELECT
                TSPT.FTRptCode
            FROM TRPTPSTSaleProfitTmp TSPT WITH(NOLOCK)
            WHERE 1=1
            AND TSPT.FTComName = '$tComName'
            AND TSPT.FTRptCode = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'
        ";

        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Sahaart(Golf)
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
        $tPosType       = $paDataWhere['aDataFilter']['tPosType'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check All Type
        $tWhereAppType          = "";
        $tWhereAppTypeFooter    = "";
        if(isset($tPosType) && !empty($tPosType)){
            $tWhereAppType          = " AND DATA.FNAppType = '".$tPosType."'";
            $tWhereAppTypeFooter    = " AND FNAppType = '".$tPosType."'";
        }

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " SELECT
                                    FTUsrSession                        AS FTUsrSession_Footer,
                                    CONVERT(FLOAT,SUM(FCXsdSaleQty))	AS FCXsdSaleQty_Footer,
                                    CONVERT(FLOAT,SUM(FCPdtCost))       AS FCPdtCost_Footer,
                                    CONVERT(FLOAT,SUM(FCXshGrand))		AS FCXshGrand_Footer,
                                    CONVERT(FLOAT,SUM(FCXsdProfit))		AS FCXsdProfit_Footer,
                                    CASE
                                        WHEN CONVERT(FLOAT,SUM(FCPdtCost)) <> 0 THEN ((CONVERT(FLOAT,SUM(FCXsdProfit)) / CONVERT(FLOAT,SUM(FCPdtCost)))*100)
                                        ELSE 0
                                    END AS FCXsdProfitPercent_Footer,
                                    CASE
                                        WHEN CONVERT(FLOAT,SUM(FCXshGrand)) <> 0 THEN ((CONVERT(FLOAT,SUM(FCXsdProfit)) / CONVERT(FLOAT,SUM(FCXshGrand)))*100)
                                        ELSE 0
                                    END AS FCXsdSalePercent_Footer
                                FROM TRPTPSTSaleProfitTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName			= '$tComName'
                                AND FTRptCode			= '$tRptCode'
                                AND FTUsrSession        = '$tUsrSession'
                                ".$tWhereAppTypeFooter."
                                GROUP BY FTUsrSession
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXsdSaleQty_Footer,
                    0 AS FCPdtCost_Footer,
                    0 AS FCXshGrand_Footer,
                    0 AS FCXsdProfit_Footer,
                    0 AS FCXsdProfitPercent_Footer,
                    0 AS FCXsdSalePercent_Footer
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
                                ROW_NUMBER() OVER(ORDER BY DATA.FNAppType,DATA.FTPdtCode) AS RowID,
                                DATA.*,
                                DTSUMGRP.*
                            FROM TRPTPSTSaleProfitTmp DATA WITH(NOLOCK)
                            LEFT JOIN (
                                SELECT
                                    FNAppType AS FNAppType_SUBAPP,
                                    COUNT(FNAppType)									AS FNRptGroupMember_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXsdSaleQty))	AS FCXsdSaleQty_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCPdtCost))			AS FCPdtCost_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXshGrand))		AS FCXshGrand_SUBAPP,
                                    CONVERT(FLOAT,SUM(FCXsdProfit))		AS FCXsdProfit_SUBAPP,
                                    CASE
                                        WHEN CONVERT(FLOAT,SUM(FCPdtCost)) <> 0 THEN ((CONVERT(FLOAT,SUM(FCXsdProfit)) / CONVERT(FLOAT,SUM(FCPdtCost)))*100)
                                        ELSE 0
                                    END AS FCXsdProfitPercent_SUBAPP,
                                    CASE
                                        WHEN CONVERT(FLOAT,SUM(FCXshGrand)) <> 0 THEN ((CONVERT(FLOAT,SUM(FCXsdProfit)) / CONVERT(FLOAT,SUM(FCXshGrand)))*100)
                                        ELSE 0
                                    END AS FCXsdSalePercent_SUBAPP
                                FROM TRPTPSTSaleProfitTmp WITH(NOLOCK)
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
                            ".$tWhereAppType."
                        ) L
                        LEFT JOIN (
                            ".$tRptJoinFooter."
        ";
        // WHERE เงื่อนไข Page
        $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        if(!empty($tPosType)){
            $tSQL .= " AND L.FNAppType = '$tPosType'";
        }

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTPdtCode ASC"; 
         
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
     * Creator: 01/09/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tPosType   = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = "   
            SELECT
                TSPT.FTRptCode
            FROM TRPTPSTSaleProfitTmp TSPT WITH(NOLOCK)
            WHERE TSPT.FTComName = '$tComName'
            AND TSPT.FTRptCode = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'";

        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }
        
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
     * Creator: 01/09/2019 Saharat(Golf)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tPosType = $paDataWhere['aDataFilter']['tPosType'];

        $tSQL = "   
            UPDATE TRPTPSTSaleProfitTmp
                SET TRPTPSTSaleProfitTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSPT.FTPdtCode ORDER BY TSPT.FTPdtCode ASC) AS PartID ,
                        TSPT.FTRptRowSeq
                    FROM TRPTPSTSaleProfitTmp TSPT WITH(NOLOCK)
                    WHERE TSPT.FTComName = '$tComName'
                    AND TSPT.FTRptCode = '$tRptCode'
                    AND TSPT.FTUsrSession = '$tUsrSession'";

                    if(!empty($tPosType)){
                        $tSQL .= " AND FNAppType = '" . $tPosType . "'";
                    }
            $tSQL  .= "
                ) AS B
            WHERE 1=1
            AND TRPTPSTSaleProfitTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTPSTSaleProfitTmp.FTComName = '$tComName' 
            AND TRPTPSTSaleProfitTmp.FTRptCode = '$tRptCode'
            AND TRPTPSTSaleProfitTmp.FTUsrSession = '$tUsrSession' ";

            if(!empty($tPosType)){
                $tSQL .= " AND FNAppType = '" . $tPosType . "'";
            }
        
        $this->db->query($tSQL);
    }

    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 10/10/2019 Napat
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere) {

        // $aRowLen        = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tUsrSessionID = $paDataWhere['tUsrSessionID'];
        $tPosType   = $paDataWhere['aDataFilter']['tPosType'];
        // ISNULL((ISNULL(SUM(FCXsdProfit),0)/ISNULL(SUM(FCPdtCost),0)) * 100,0) AS FCXsdProfitPercentSum,
        // ISNULL((ISNULL(SUM(FCXsdProfit),0)/ISNULL(SUM(FCXshGrand),0)) * 100,0) AS FCXsdSalePercentSum
        $tSQL = "  
            SELECT
                ISNULL(SUM(FCXsdSaleQty),0) AS FCXsdSaleQtySum,
                ISNULL(SUM(FCPdtCost),0) AS FCPdtCostSum,
                ISNULL(SUM(FCXshGrand),0) AS FCXshGrandSum,
                ISNULL(SUM(FCXsdProfit),0) AS FCXsdProfitSum,
                ((NULLIF(SUM(FCXsdProfit),0)  /  NULLIF(SUM(FCPdtCost),0)) * 100)  AS  FCXsdProfitPercentSum,
                ((NULLIF(SUM(FCXsdProfit),0) / NULLIF(SUM(FCXshGrand),0)) * 100) AS FCXsdSalePercentSum
            FROM TRPTPSTSaleProfitTmp
            WHERE FTUsrSession = '$tUsrSessionID'
            AND FTComName = '$tCompName' 
            AND FTRptCode = '$tRptCode'";
            if(!empty($tPosType)){
                $tSQL .= " AND FNAppType = '" . $tPosType . "'";
            }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

}
