<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalesOrder extends CI_Model {


          /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreCReport($paDataFilter) {

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];
        
        $tCallStore = "{ CALL SP_RPTxSalSoTmp_StatDose(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSessionID'],
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
            'ptHN_IDF'      => $paDataFilter['tHNCodeFrom'],  //รหัสผู้ป่วย
            'ptHN_IDT'      => $paDataFilter['tHNCodeTo'],   //รหัสผู้ป่วย
            'ptCardIDF'     => $paDataFilter['tHNNameFrom'], //รหัสบัตรประชาชน
            'ptCardIDT'     => $paDataFilter['tHNNameTo'],   //รหัสบัตรประชาชน
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],
            'FNResult' => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery != FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
        
    }


   /**
     * Functionality: Get Data Report All
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
        
        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart  = $aPagination["nRowIDStart"];
        $nRowIDEnd    = $aPagination["nRowIDEnd"];
        $nTotalPage   = $aPagination["nTotalPage"];

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        //Set Priority
        $aDta = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tUsrSession);
           // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
           if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession        AS FTUsrSession_Footer,  
                    SUM(FCXsdQty)       AS FCXsdQty_Footer,
                    SUM(FCXsdDiscount)  AS FCXsdDiscount_Footer,
                    SUM(FCXsdNet)       AS FCXsdNet_Footer,
                    SUM(FCXshDiscount)  AS FCXshDiscount_Footer,
                    SUM(FCXhdVatable)   AS FCXhdVatable_Footer,
                    SUM(FCXshVat)       AS FCXshVat_Footer,
                    SUM(FCXshAmtNV)     AS FCXshAmtNV_Footer,
                    SUM(FCXshGrand)     AS FCXshGrand_Footer
 
                FROM TRPTSalSoTmp_StatDose WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXsdQty_Footer,
                    0 AS FCXsdDiscount_Footer,
                    0 AS FCXsdNet_Footer,
                    0 AS FCXshDiscount_Footer,
                    0 AS FCXhdVatable_Footer,
                    0 AS FCXshVat_Footer,
                    0 AS FCXshAmtNV_Footer,
                    0 AS FCXshGrand_Footer
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
                SELECT
                    L.*, T.FCXsdQty_Footer,
                    T.FCXsdDiscount_Footer,
                    T.FCXsdNet_Footer,
                    T.FCXshDiscount_Footer,
                    T.FCXhdVatable_Footer,
                    T.FCXshVat_Footer,
                    T.FCXshAmtNV_Footer,
                    T.FCXshGrand_Footer
                FROM
                    (
                    SELECT
                        ROW_NUMBER () OVER (ORDER BY FTXshDocNo) AS RowID,
                        A.*, S.FNRptGroupMember,
                        S.FCXsdQty_SubTotal,
                        S.FCXsdDiscount_SubTotal,
                        S.FCXsdNet_SubTotal,
                        S.FCXshDiscount_SubTotal,
                        S.FCXhdVatable_SubTotal,
                        S.FCXshVat_SubTotal,
                        S.FCXshAmtNV_SubTotal,
                        S.FCXshGrand_SubTotal
                FROM TRPTSalSoTmp_StatDose A WITH (NOLOCK)
                    LEFT JOIN (
                        SELECT
                            FTXshDocNo AS FTXshDocNo_SUM,
                            COUNT(FTXshDocNo) AS FNRptGroupMember,
                            SUM(FCXsdQty) AS FCXsdQty_SubTotal,
                            SUM(FCXsdDiscount) AS FCXsdDiscount_SubTotal,
                            SUM(FCXsdNet) AS FCXsdNet_SubTotal,
                            SUM(FCXshDiscount) AS FCXshDiscount_SubTotal,
                            SUM(FCXhdVatable) AS FCXhdVatable_SubTotal,
                            SUM(FCXshVat) AS FCXshVat_SubTotal,
                            SUM(FCXshAmtNV) AS FCXshAmtNV_SubTotal,
                            SUM(FCXshGrand) AS FCXshGrand_SubTotal
                FROM TRPTSalSoTmp_StatDose WITH (NOLOCK)
                    WHERE 1 = 1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTXshDocNo
                    ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SUM
                    WHERE A.FTComName = '$tComName'
                    AND A.FTRptCode = '$tRptCode'
                    AND A.FTUsrSession = '$tUsrSession' 
                    /* End Calculate Misures */
                        ) AS L
                LEFT JOIN (
                " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTXshDocNo,L.FTPdtCode ";

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


    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession){
            $tSQL  = " UPDATE TRPTSalSoTmp_StatDose
                        SET FNRowPartID = B.PartID
                        FROM(
                            SELECT 
                                ROW_NUMBER() OVER(PARTITION BY FTXshDocNo ORDER BY FTXshDocNo ASC) AS PartID ,
                                FTRptRowSeq 
                            FROM TRPTSalSoTmp_StatDose TMP WITH(NOLOCK)
                            WHERE TMP.FTComName  = '$ptComName' 
                            AND TMP.FTRptCode     = '$ptRptCode'
                            AND TMP.FTUsrSession  = '$ptUsrSession'
                        ) B
                        WHERE 1 = 1
                        AND TRPTSalSoTmp_StatDose.FTRptRowSeq  = B.FTRptRowSeq 
                        AND TRPTSalSoTmp_StatDose.FTComName    = '$ptComName' 
                        AND TRPTSalSoTmp_StatDose.FTRptCode    = '$ptRptCode'
                        AND TRPTSalSoTmp_StatDose.FTUsrSession = '$ptUsrSession'
            ";
            $this->db->query($tSQL);
    }


    public function FMaMRPTPagination($paDataWhere){
        
        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];
        
        $tSQL = "   
            SELECT
                COUNT(TTVD_TMP.FTPdtCode) AS rnCountPage
            FROM TRPTSalSoTmp_StatDose TTVD_TMP WITH(NOLOCK)
            WHERE 1=1
            AND TTVD_TMP.FTComName    = '$tComName'
            AND TTVD_TMP.FTRptCode    = '$tRptCode'
            AND TTVD_TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery  = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        $nPage       = $paDataWhere['nPage'];
        $nPerPage    = $paDataWhere['nPerPage'];
        $nPrevPage   = $nPage - 1;
        $nNextPage   = $nPage + 1;
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
     * Creator: 04/04/2019 Witsarut(Bell)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    
     public function FSnMCountDataReportAll($paDataWhere){

        $tSessionID     = $paDataWhere['tSessionID'];
        $tCompName      = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];

        $tSQL = " SELECT 
                    COUNT(DTTMP.FTRptCode) AS rnCountPage
                FROM TRPTSalSoTmp_StatDose AS DTTMP WITH(NOLOCK)
                WHERE 1=1
                AND FTUsrSession = '$tSessionID'
                AND FTComName = '$tCompName'
                AND FTRptCode = '$tRptCode'
            ";
        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
        unset($oQuery);
        return $nRptAllRecord;
    }

     /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        $tComName    = $paParams['tCompName'];
        $tRptCode    = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];

        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTSalSoTmp_StatDose TMP WITH(NOLOCK)
            WHERE TMP.FTComName  = '$tComName'
            AND TMP.FTRptCode    = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }
        

}


