<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptRedeemReturnCard extends CI_Model {
    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
    */
    public function FSnMExecStoreCReport($paDataFilter){

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 

        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];

        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];

        $tCallStore = "{ CALL SP_RPTxRedeemReturnCardTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        
        $aDataStore = array(

            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
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
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],
           
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            'FNResult' => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();
        // exit;
        if ($oQuery != FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }


    /**
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        //Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tUsrSession);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession         AS FTUsrSession_Footer,
                    SUM(FCTxnCrdValue)   AS FCTxnCrdValue_Footer,
                    SUM(FCTxnValNotRet)  AS FCTxnValNotRet_Footer,
                    SUM(FCTxnValRet)     AS FCTxnValRet_Footer
                FROM TRPTRedeemReturnCardTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
             // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
             $tJoinFoooter = "   
             SELECT
                 '$tUsrSession' AS FTUsrSession_Footer,
                 0 AS FCTxnCrdValue_Footer,
                 0 AS FCTxnValNotRet_Footer,
                 0 AS FCTxnValRet_Footer
             ) T ON L.FTUsrSession = T.FTUsrSession_Footer
         ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = " 
        SELECT
            L.*,
            T.FCTxnCrdValue_Footer,
            T.FCTxnValNotRet_Footer,
            T.FCTxnValRet_Footer
        FROM (
            SELECT
                ROW_NUMBER() OVER(ORDER BY FTBchCode,FTShpCode,FDTxnDocDate,FTTxnDocNoRef ASC) AS RowID ,
                A.*,
                S.FNRptGroupMember,
                FCTxnCrdValue_SubTotal,
                FCTxnValNotRet_SubTotal,
                FCTxnValRet_SubTotal,
                FCTxnCrdValue_SubByBill,
                FCTxnValNotRet_SubByBill,
                FCTxnValRet_SubByBill,
                FNRowPartIDDocRef_MaxSeq
            FROM TRPTRedeemReturnCardTmp A WITH(NOLOCK)
            LEFT JOIN (
                SELECT
                    FTBchCode          AS FTBchCode_SUM,
                    COUNT(FTBchCode)   AS FNRptGroupMember,
                    SUM(FCTxnCrdValue)  AS FCTxnCrdValue_SubTotal,
                    SUM(FCTxnValNotRet) AS FCTxnValNotRet_SubTotal,
                    SUM(FCTxnValRet)    AS FCTxnValRet_SubTotal
                FROM TRPTRedeemReturnCardTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTBchCode
                ) AS S ON A.FTBchCode = S.FTBchCode_SUM

                LEFT JOIN (
                    SELECT
                        FTBchCode          AS FTBchCode_SUM,
                        FTTxnDocNoRef      AS FTTxnDocNoRef_SUM,
                        COUNT(FTBchCode)   AS FNRptGroupMember,
                        SUM(FCTxnCrdValue)  AS FCTxnCrdValue_SubByBill,
                        SUM(FCTxnValNotRet) AS FCTxnValNotRet_SubByBill,
                        SUM(FCTxnValRet)    AS FCTxnValRet_SubByBill,
                        MAX(FNRowPartIDDocRef) AS FNRowPartIDDocRef_MaxSeq

                    FROM TRPTRedeemReturnCardTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTBchCode,FTTxnDocNoRef
                    ) AS D ON A.FTBchCode = D.FTBchCode_SUM AND  A.FTTxnDocNoRef = D.FTTxnDocNoRef_SUM

                WHERE A.FTComName       = '$tComName'
                AND   A.FTRptCode       = '$tRptCode'
                AND   A.FTUsrSession    = '$tUsrSession'
            ) AS L 
            LEFT JOIN (
                " . $tJoinFoooter . "
            ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTTxnDocNoRef ASC   ";

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



    //Set Group ของ รายงาน
    // Create By Witsarut 21/09/2020
    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession){
        $tSQL   = " UPDATE TRPTRedeemReturnCardTmp 
        SET 
            FNRowPartID     = B.PartID,
            FNRowPartIDBch  = B.PartIDBch,
            FNRowPartIDShp  = B.PartIDShp,
            FNRowPartIDDocRef  = B.PartIDDoc
        FROM(
            SELECT
                ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode ORDER BY FTBchCode ASC, FTTxnDocNoRef ASC,FTShpCode ASC,FTRptRowSeq ASC) AS PartID,
                ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode ASC) AS PartIDBch,
                ROW_NUMBER() OVER(PARTITION BY FTShpCode ORDER BY FTBchCode ASC) AS PartIDShp,
                ROW_NUMBER() OVER(PARTITION BY FTTxnDocNoRef ORDER BY FTBchCode ASC) AS PartIDDoc,
                FTRptRowSeq,
                FTBchCode,
                FTShpCode,
                FTTxnDocNoRef,
                FTComName,
                FTRptCode,
                FTUsrSession
            FROM TRPTRedeemReturnCardTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName  = '$ptComName' 
            AND TMP.FTRptCode     = '$ptRptCode'
            AND TMP.FTUsrSession  = '$ptUsrSession'";
        $tSQL  .= "
            ) AS B
            WHERE 1=1
            AND TRPTRedeemReturnCardTmp.FTRptRowSeq = B.FTRptRowSeq
            /*AND TRPTRedeemReturnCardTmp.FTBchCode  = B.FTBchCode
            AND TRPTRedeemReturnCardTmp.FTShpCode  = B.FTShpCode
            AND TRPTRedeemReturnCardTmp.FTTxnDocNoRef  = B.FTTxnDocNoRef*/
            AND TRPTRedeemReturnCardTmp.FTComName = '$ptComName' 
            AND TRPTRedeemReturnCardTmp.FTRptCode = '$ptRptCode'
            AND TRPTRedeemReturnCardTmp.FTUsrSession = '$ptUsrSession' ";
        
            $this->db->query($tSQL);
            // echo $tSQL;
            // exit;

    }



    //นับจำนวน หน้า Page
    // Create By Witsarut 21/09/2020
    public function FMaMRPTPagination($paDataWhere){
        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(DTTMP.FTBchCode) AS rnCountPage
            FROM TRPTRedeemReturnCardTmp DTTMP WITH(NOLOCK)
            WHERE 1=1
            AND DTTMP.FTComName    = '$tComName'
            AND DTTMP.FTRptCode    = '$tRptCode'
            AND DTTMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); //RowId Start

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


    /**
     * Functionality: Count Data Report All
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMCountDataReportAll($paDataWhere){
        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];


        $tSQL = "
                SELECT  COUNT(DTTMP.FTRptCode) AS rnCountPage
            FROM TRPTRedeemReturnCardTmp AS DTTMP WITH(NOLOCK)
            WHERE 1 = 1
            AND FTUsrSession = '$tSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }







  
}
