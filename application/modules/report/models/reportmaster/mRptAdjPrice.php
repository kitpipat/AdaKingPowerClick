<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptAdjPrice extends CI_Model {
    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID = $paDataFilter['nLangID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);

        $tCallStore = "{CALL SP_RPTxAdjPrice(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID, 
            'pnComName' => $tComName,
            'ptRptCode' => $tRptCode,
            'ptUsrSession' => $tUserSession,
            
            'pnFilterType' => $paDataFilter['tTypeSelect'],
            'ptBchL' => $tBchCodeSelect,
            // 'ptBchF' => $paDataFilter['tBchCodeFrom'],
            // 'ptBchT' => $paDataFilter['tBchCodeTo'],

            'ptProductCodeF' => $paDataFilter['tRptPdtCodeFrom'],
            'ptProductCodeT' => $paDataFilter['tRptPdtCodeTo'],

            'ptPdtUnitF' => $paDataFilter['tRptPdtUnitCodeFrom'],
            'ptPdtUnitT' => $paDataFilter['tRptPdtUnitCodeTo'],

            'ptEffectivePriceGroupF' => $paDataFilter['tRptEffectivePriceGroupCodeFrom'],
            'ptEffectivePriceGroupT' => $paDataFilter['tRptEffectivePriceGroupCodeTo'],

            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],

            'ptEffectiveDateF' => $paDataFilter['tEffectiveDateFrom'],
            'ptEffectiveDateT' => $paDataFilter['tEffectiveDateTo'],
            
            'FTResult' => 0
        );

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
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];

        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTAdjPriceTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
        $nPage = $paDataWhere['nPage'];
        
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    CONVERT(FLOAT,SUM(FCXpdPriceRet)) AS FCXpdPriceRet_Footer
                FROM TRPTAdjPriceTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXpdPriceRet_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        $tRptJoinFooter = "";

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*
                --T.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY DATA.FTPdtCode ASC, DATA.FTPunCode ASC, DATA.FTBarCode ASC, DATA.FDXphDocDate DESC) AS RowID,
                    DATA.*,
                    DTSUMGRP.FTRptCode_COUNT
                FROM TRPTAdjPriceTmp DATA WITH(NOLOCK)
                LEFT JOIN (
                    SELECT
                        COUNT(FTRptCode) AS FTRptCode_COUNT,
                        FTPdtCode AS FTPdtCode_SUB,
                        FTPunCode AS FTPunCode_SUB
                    FROM TRPTAdjPriceTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTPdtCode, FTPunCode
                ) DTSUMGRP ON DATA.FTPdtCode = DTSUMGRP.FTPdtCode_SUB AND DATA.FTPunCode = DTSUMGRP.FTPunCode_SUB
                WHERE 1=1
                AND DATA.FTComName = '$tComName'
                AND DATA.FTRptCode = '$tRptCode'
                AND DATA.FTUsrSession = '$tUsrSession'
            ) L
            --LEFT JOIN (
            $tRptJoinFooter
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTPdtCode ASC"; 
            
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
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                TSPT.FTRptCode
            FROM TRPTAdjPriceTmp TSPT WITH(NOLOCK)
            WHERE TSPT.FTComName = '$tComName'
            AND TSPT.FTRptCode = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'
        ";
        
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
     * Creator: 15/09/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTAdjPriceTmp
                SET TRPTAdjPriceTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TMP.FTPdtCode, TMP.FTPunCode ORDER BY TMP.FTPdtCode DESC, TMP.FTPunCode DESC, TMP.FTBarCode DESC, TMP.FDXphDocDate DESC) AS PartID ,
                        TMP.FTRptRowSeq
                    FROM TRPTAdjPriceTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName = '$tComName'
                    AND TMP.FTRptCode = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $tSQL .= "
            ) AS B
            WHERE 1=1
            AND TRPTAdjPriceTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTAdjPriceTmp.FTComName = '$tComName' 
            AND TRPTAdjPriceTmp.FTRptCode = '$tRptCode'
            AND TRPTAdjPriceTmp.FTUsrSession = '$tUsrSession' 
        ";
        
        $this->db->query($tSQL);
    }

    /**
     * Functionality: To Get data SumFootReport
     * Parameters: Function Parameter
     * Creator: 15/09/2020 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMGetDataSumFootReport($paDataWhere) {
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSessionID = $paDataWhere['tUsrSessionID'];

        $tSQL = "  
            SELECT
                ISNULL(SUM(FCXsdSaleQty),0) AS FCXsdSaleQtySum,
                ISNULL(SUM(FCPdtCost),0) AS FCPdtCostSum,
                ISNULL(SUM(FCXshGrand),0) AS FCXshGrandSum,
                ISNULL(SUM(FCXsdProfit),0) AS FCXsdProfitSum,
                ISNULL((ISNULL(SUM(FCXsdProfit),0)/ISNULL(SUM(FCPdtCost),0)) * 100,0) AS FCXsdProfitPercentSum,
                ISNULL((ISNULL(SUM(FCXsdProfit),0)/ISNULL(SUM(FCXshGrand),0)) * 100,0) AS FCXsdSalePercentSum
            FROM TRPTAdjPriceTmp
            WHERE FTUsrSession = '$tUsrSessionID'
            AND FTComName = '$tCompName' 
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }
}
