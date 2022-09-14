<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptDayEndSales extends CI_Model {
  
    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 30/04/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){

        $nLangID        = $paDataFilter['nLangID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSession'];
        
         // สาขา
         $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
         // ร้านค้า
         $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
         // กลุ่มธุรกิจ
         $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore     = "{ CALL SP_RPTxSalDaily(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";

        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'],

            //ส่ง parameter เข้าใน Store  0 = ทั้งหมด / 1 = ขายปลีก / 2 = ตู้ขายสินค้า
            'ptAppType'     => $paDataFilter['tPosType'],

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
            'FNResult'      => 0,

          
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

     
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 1;
        }
    }

    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator:  30/04/2020 Witsarut (Bell)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination    =  $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUserSession'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM ( ISNULL(FCXshGrand, 0 ) ) AS FCXshGrand_Footer
                FROM TRPTSalDailyTmp WITH(NOLOCK)
                WHERE FTComName  = '$tComName'
                AND FTRptCode    = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXshGrand_Footer
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
                        ROW_NUMBER() OVER(ORDER BY FTXihValType ASC) AS RowID,
                        A.*,
                        S.FNRptGroupMember
                    FROM TRPTSalDailyTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                            FTXihValType AS FTXihValType_SUM,
                            COUNT(FTXihValType) AS FNRptGroupMember
                        FROM TRPTSalDailyTmp WITH(NOLOCK)
                        WHERE 1=1
                        AND FTComName = '$tComName'
                        AND FTRptCode = '$tRptCode'
                        AND FTUsrSession = '$tUsrSession'
                        GROUP BY FTXihValType
                    ) AS S ON A.FTXihValType = S.FTXihValType_SUM
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
            $tSQL .=  " ORDER BY L.FTXihValType ASC";

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
                "aRptData"    => $aData,
                "aError"      => $aErrorList
            ];
            unset($oQuery); 
            unset($aData);
            return $aResualt;
    }


    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 30/04/2020 Witsarut(Bell)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUserSession'];
      
        $tSQL = "   
            UPDATE TRPTSalDailyTmp SET 
                TRPTSalDailyTmp.FNRowPartID = B.PartID
                FROM(
                    SELECT   
                    ROW_NUMBER() OVER(PARTITION BY TMP.FTXihValType ORDER BY TMP.FTXihValType ASC) AS PartID ,
                        TMP.FTRptRowSeq
                    FROM TRPTSalDailyTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName  = '$tComName'
                    AND TMP.FTRptCode    = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
                ) AS B
            WHERE TRPTSalDailyTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTSalDailyTmp.FTComName = '$tComName' 
            AND TRPTSalDailyTmp.FTRptCode = '$tRptCode'
            AND TRPTSalDailyTmp.FTUsrSession = '$tUsrSession'
        ";

    }


    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 30/04/2020 Witsarut (Bell)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

    

        $tComName      = $paDataWhere['tCompName'];
        $tRptCode      = $paDataWhere['tRptCode'];
        $tUsrSession   = $paDataWhere['tUserSession'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTSalDailyTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery  =  $this->db->query($tSQL);

        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        $nPrevPage  = $nPage-1;
        $nNextPage  = $nPage+1;

        $nRowIDStart    = (($nPerPage*$nPage)-$nPerPage); //RowId Start

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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 30/04/2019 Witsarut(Bell)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere){

        $tUserSession   = $paDataWhere['tUserSession'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = "   SELECT 
                        COUNT(DTTMP.FTRptCode) AS rnCountPage
                    FROM TRPTSalDailyTmp AS DTTMP WITH(NOLOCK)
                    WHERE 1 = 1
                    AND FTUsrSession    = '$tUserSession'
                    AND FTComName       = '$tCompName'
                    AND FTRptCode       = '$tRptCode'
        ";
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
            }


}

