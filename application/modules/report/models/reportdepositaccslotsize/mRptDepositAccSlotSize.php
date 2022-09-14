<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptDepositAccSlotSize extends CI_Model {

    /**
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 03/12/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
      
        //สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect'];
        //กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        //ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        //เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];

        //22
        $tCallStore = "{ CALL SP_RPTxDepositAccordingSlotSize003001006(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'ptComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShopCodeFrom'],
            'ptShpT'        => $paDataFilter['tShopCodeTo'],
            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptPzeF'        => $paDataFilter['tPzeCodeFrom'],
            'ptPzeT'        => $paDataFilter['tPzeCodeTo'],
            'ptDateF'       => $paDataFilter['tDocDateFrom'],
            'ptDateT'       => $paDataFilter['tDocDateTo'],
            'FNResult'      => 0
        );

        $oQuery =  $this->db->query($tCallStore,$aDataStore);

        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }


    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 15/07/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Data Report
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage          = $paDataWhere['nPage'];
        $nPerPage       = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        //Set PriorityGroup
        $this->FMxMRPTSetPriorityGroup($paDataWhere);
       
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FNXshQTYBill, 0)
                    ) AS FNXshQTYBill_Footer,
                    SUM( 
                        ISNULL(FCXshGrand, 0)
                    ) AS FCXshGrand_Footer
                FROM TRPTRTDepositAccordingSlotSizeTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    '0' AS FNXshQTYBill_Footer,
                    '0' AS FCXshGrand_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   
            SELECT
                L.*,
                SUMBCH.*,
                SUMSHP.*,
                T.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTBchCode ASC,  FTShpCode ASC, FTPosCode ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTRTDepositAccordingSlotSizeTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTBchCode AS FTBchCode_SUM,
                        COUNT(FTBchCode) AS FNRptGroupMember
                    FROM TRPTRTDepositAccordingSlotSizeTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTBchCode  
                ) AS S ON A.FTBchCode = S.FTBchCode_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUsrSession'
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
                SELECT
            FTUsrSession                    AS FTUsrSession_SUMBCH,
            FTBchCode                       AS FTBchCode_SUMBCH,
            SUM(ISNULL(FNXshQTYBill, 0))    AS FNXshQTYBill_SUMBCH,
            SUM(ISNULL(FCXshGrand, 0))      AS FCXshGrand_SUMBCH,
            SUM(ISNULL(FTXshDepositTime,0))     AS FTXshDepositTime_SUMBCH
                FROM TRPTRTDepositAccordingSlotSizeTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName   = '$tComName'
                AND FTRptCode   = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession,FTBchCode
            ) SUMBCH ON L.FTUsrSession = SUMBCH.FTUsrSession_SUMBCH AND L.FTBchCode = SUMBCH.FTBchCode_SUMBCH
            LEFT JOIN (
                SELECT
                    FTUsrSession                    AS FTUsrSession_SUMSHP,
                    FTShpCode                       AS FTShpCode_SUMSHP,
                    SUM(ISNULL(FNXshQTYBill, 0))    AS FNXshQTYBill_SUMSHP,
                    SUM(ISNULL(FCXshGrand, 0))      AS FCXshGrand_SUMSHP,
                    SUM(ISNULL(FTXshDepositTime,0))     AS FTXshDepositTime_SUMSHP
                FROM TRPTRTDepositAccordingSlotSizeTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName   = '$tComName'
                AND FTRptCode   = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession,FTShpCode
            ) SUMSHP ON L.FTUsrSession = SUMSHP.FTUsrSession_SUMSHP AND L.FTShpCode = SUMSHP.FTShpCode_SUMSHP

            LEFT JOIN (
            ".$tRptJoinFooter."
        ";
        // WHERE เงื่อนไข Page
        $tSQL .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd  ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .=  " ORDER BY L.FTBchCode ASC, L.FTShpCode ,L.FTPosCode ASC ";
        
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
     * Functionality: Get Data Page
     * Parameters:  Function Parameter
     * Creator: 3/12/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL  = "  SELECT 
                     COUNT(DPTMP.FTRptCode) AS rnCountPage  
                    FROM TRPTRTDepositAccordingSlotSizeTmp AS DPTMP WITH(NOLOCK)
                    WHERE 1=1
                    AND DPTMP.FTComName    = '$tComName'
                    AND DPTMP.FTRptCode    = '$tRptCode'
                    AND DPTMP.FTUsrSession = '$tUsrSession'";
                
                $oQuery = $this->db->query($tSQL);
                $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
                $nPage = $paDataWhere['nPage'];
                $nPerPage = $paDataWhere['nPerPage'];
                $nPrevPage = $nPage - 1;
                $nNextPage = $nPage + 1;
                $nRowIDStart = (($nPerPage * $nPage) - $nPerPage);
                if ($nRptAllRecord <= $nPerPage) {
                    $nTotalPage = 1;
                } else if (($nRptAllRecord % $nPerPage) == 0) {
                    $nTotalPage = ($nRptAllRecord / $nPerPage);
                } else {
                    $nTotalPage = ($nRptAllRecord / $nPerPage) + 1;
                    $nTotalPage = (int) $nTotalPage;
                }
        
                // Get Rowid end
                $nRowIDEnd = $nPerPage * $nPage;
                if ($nRowIDEnd > $nRptAllRecord) {
                    $nRowIDEnd = $nRptAllRecord;
                }
        
                $aRptMemberDet = array(
                    "nTotalRecord" => $nRptAllRecord,
                    "nTotalPage" => $nTotalPage,
                    "nDisplayPage" => $paDataWhere['nPage'],
                    "nRowIDStart" => $nRowIDStart,
                    "nRowIDEnd" => $nRowIDEnd,
                    "nPrevPage" => $nPrevPage,
                    "nNextPage" => $nNextPage
                );
                unset($oQuery);
                return $aRptMemberDet;
    }


    // Functionality: Get Data Page Col
    // Parameters:  Function Parameter
    // Creator: 3/12/2019 Witsarut(Bell)
    // Last Modified : -
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMxMRPTSetPriorityGroup($paDataWhere){

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = " UPDATE TRPTRTDepositAccordingSlotSizeTmp 
        SET FNRowPartID = B.FNRowPartID
            FROM(
                SELECT   
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTPosCode ORDER BY FTBchCode ASC,FTShpCode ASC,FTPosCode ASC) AS FNRowPartID,
                    TMP.FTRptRowSeq
                FROM TRPTRTDepositAccordingSlotSizeTmp TMP WITH(NOLOCK)
                WHERE 1=1
                AND TMP.FTComName = '$tComName'
                AND TMP.FTRptCode = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'
        ) AS B
            WHERE TRPTRTDepositAccordingSlotSizeTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTRTDepositAccordingSlotSizeTmp.FTComName  = '$tComName' 
            AND TRPTRTDepositAccordingSlotSizeTmp.FTRptCode  = '$tRptCode'
            AND TRPTRTDepositAccordingSlotSizeTmp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);

    }


      /**
     * Functionality: Count Data Rows All In DB Temp
     * Parameters: function parameters
     * Creator:  6/12/2019 Witsarut R (Bell)
     * Last Modified: -
     * Return: Count Data All Temp
     * Return Type: Numeric
     */
    public function FSnMCountRowInTemp($paParams){

        $tComName       = $paParams['tCompName'];
        $tRptCode       = $paParams['tRptCode'];
        $tUsrSession    = $paParams['tUserSession'];

        $tSQL =  "
            SELECT 
                COUNT(TDPT.FTRptCode) AS rnCountPage
            FROM TRPTRTDepositAccordingSlotSizeTmp TDPT WITH(NOLOCK)
            WHERE 1=1
            AND TDPT.FTComName = '$tComName'
            AND TDPT.FTRptCode = '$tRptCode'
            AND TDPT.FTUsrSession = '$tUsrSession'
        ";
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }




}






