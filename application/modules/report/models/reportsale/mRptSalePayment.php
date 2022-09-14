<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalePayment extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : 23/09/2019 Piya
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
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

        $tCallStore = "{ CALL SP_RPTxPaymentSum1001003(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'      => $nLangID,
            'pnComName'    => $tComName,
            'ptRptCode'    => $tRptCode,
            'ptUsrSession' => $tUserSession,
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
            'ptRcvF'       => $paDataFilter['tRcvCodeFrom'],
            'ptRcvT'       => $paDataFilter['tRcvCodeTo'],
            'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'   => $paDataFilter['tDocDateTo'],
            'FNResult'     => 0,
        );
        // $tCallStore = "{ CALL SP_RPTxPaymentSum1001003(?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        // $aDataStore = array(
        //     'pnLngID'      => $nLangID,
        //     'pnComName'    => $tComName,
        //     'ptRptCode'    => $tRptCode,
        //     'ptUsrSession' => $tUserSession,
        //     'ptRcvF'       => $paDataFilter['tRcvCodeFrom'],
        //     'ptRcvT'       => $paDataFilter['tRcvCodeTo'],
        //     'ptBchF'       => $paDataFilter['tBchCodeFrom'],
        //     'ptBchT'       => $paDataFilter['tBchCodeTo'],
        //     'ptShpF'       => $paDataFilter['tShpCodeFrom'],
        //     'ptShpT'       => $paDataFilter['tShpCodeTo'],
        //     'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
        //     'ptDocDateT'   => $paDataFilter['tDocDateTo'],
        //     'FNResult'     => 0,
        // );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery !== FALSE) {
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
     * Creator:  23/09/2019 Piya
     * Last Modified : 18/11/2019 Saharat(Golf)
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {
        $tAppType = $paDataWhere['aRptFilter']['tPosType'];
        if ($tAppType != '') {
            $tAppTypePos = "AND FNAppType = '$tAppType' ";
        }else{
            $tAppTypePos = '';
        }
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
                    SUM ( ISNULL(FCXrcNet, 0 ) ) AS NET_Footer
                FROM TRPTSalRCTmp WITH(NOLOCK)
                WHERE FTComName  = '$tComName'
                AND FTRptCode    = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                $tAppTypePos
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS NET_Footer
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
                    ROW_NUMBER() OVER(ORDER BY FTRcvCode ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember,
                    S.FCXrcNet_Sup
                
                FROM TRPTSalRCTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTRcvCode AS FTRcvCode_SUM,
                        COUNT(FTRcvCode) AS FNRptGroupMember,
                        SUM ( ISNULL(FCXrcNet, 0 ) ) AS FCXrcNet_Sup
       
                    FROM TRPTSalRCTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    $tAppTypePos
                    GROUP BY FTRcvCode
                ) AS S ON A.FTRcvCode = S.FTRcvCode_SUM
                WHERE A.FTComName  = '$tComName'
                AND A.FTRptCode    = '$tRptCode'
                AND A.FTUsrSession = '$tUsrSession'
                $tAppTypePos
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .=  " ORDER BY L.FTRcvCode ASC";
   
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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 11/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMCountDataReportAll($paDataWhere) {
        $tUserCode = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "SELECT *
                        FROM TRPTSalRCTmp
                        WHERE 1 = 1
                        AND FTRptCode = '$tRptCode' AND FTComName = '$tCompName' AND  FTUsrSession = '$tUserCode' ";
        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    // Functionality: Sum All Value Data Report All
    // Parameters: Function Parameter
    // Creator: 24/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMSumDataReportAll($paDataWhere) {
        $tUserCode = $paDataWhere['tUserCode'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
    }

    public function FSaMCMPAddress($paData) {

        try {
            $tRefCode = $paData['tAddRef'];
            $nLngID = $paData['nLangID'];
            $tSQL = "SELECT
                        ADDL.FTAddRefCode       AS rtAddRefCode,
                        ADDL.FTAddTaxNo         AS rtAddTaxNo,
                        ADDL.FTAddVersion       AS rtAddVersion,
                        ADDL.FTAddV1No          AS rtAddV1No,
                        ADDL.FTAddV1Soi         AS rtAddV1Soi,
                        ADDL.FTAddV1Village     AS rtAddV1Village,
                        ADDL.FTAddV1Road        AS rtAddV1Road,
                        ADDL.FTAddV1SubDist     AS rtAddV1SubDist,
                        SUBDSTL.FTSudName       AS rtAddV1SudName,
                        ADDL.FTAddV1DstCode     AS rtAddV1DstCode,
                        DSTL.FTDstName          AS rtAddV1DstName,
                        ADDL.FTAddV1PvnCode     AS rtAddV1PvnCode,
                        PVNL.FTPvnName          AS rtAddV1PvnName,
                        ADDL.FTAddCountry       AS rtAddV1CntName,
                        ADDL.FTAddV1PostCode    AS rtAddV1PostCode,
                        ADDL.FTAddV2Desc1       AS rtAddV2Desc1,
                        ADDL.FTAddV2Desc2       AS rtAddV2Desc2,
                        ADDL.FTAddWebsite       AS rtAddWebsite,
                        ADDL.FTAddLongitude     AS rtAddLongitude,
                        ADDL.FTAddLatitude      AS rtAddLatitude

                    FROM [TCNMAddress_L] ADDL
                    LEFT JOIN [TCNMSubDistrict_L] SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                    LEFT JOIN [TCNMDistrict_L] DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                    LEFT JOIN [TCNMProvince_L] PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                    WHERE 1=1  AND ADDL.FNLngID = $nLngID AND ADDL.FTAddRefCode = '$tRefCode' 
                    ";
            // ZNEL.FTZneCode          AS rtAddZneCode,
            // ZNEL.FTZneName          AS rtAddZneName,
            // AREL.FTAreCode          AS rtAddAreCode,--
            // AREL.FTAreName          AS rtAddAreName,--
            // LEFT JOIN [TCNMArea_L] AREL ON ADDL.FTAreCode = AREL.FTAreCode AND AREL.FNLngID = $nLngID
            // LEFT JOIN [TCNMZone] ZNE ON ADDL.FTZneCode = ZNE.FTZneCode 
            // LEFT JOIN [TCNMZone_L] ZNEL ON ZNE.FTZneChain = ZNEL.FTZneChain AND ZNEL.FNLngID = $nLngID
            // print_r($tSQL);
            // exit;
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems' => $oList[0],
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                //No Data
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found'
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    // Functionality: To Get data SumFootReport
    // Parameters: Function Parameter
    // Creator: 12/08/2019 Sarun
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMGetDataSumFootReport($paDataWhere, $paDataFilter) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "  SELECT
                        ISNULL(SUM(FCXrcNet),0)   AS FCSumFooter
                    FROM TRPTSalRCTmp
                    WHERE 1 = 1 
                    AND FTUsrSession = '$tUserSession' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 18/11/2019 Saharat(Golf)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere) {
        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   SELECT 
                             COUNT(DTTMP.FTRptCode) AS rnCountPage
                         FROM TRPTSalRCTmp AS DTTMP WITH(NOLOCK)
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


    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 18/11/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tAppType = $paDataWhere['aRptFilter']['tPosType'];
        if ($tAppType != '') {
            $tAppTypePos = "AND FNAppType = '$tAppType' ";
        }else{
            $tAppTypePos = '';
        }
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];
        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTSalRCTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
            $tAppTypePos 
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
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUserSession'];
        $tAppType = $paDataWhere['aRptFilter']['tPosType'];
        if ($tAppType != '') {
            $tAppTypePos = "AND FNAppType = '$tAppType' ";
        }else{
            $tAppTypePos = '';
        }

        $tSQL = "   
            UPDATE TRPTSalRCTmp SET 
                TRPTSalRCTmp.FNRowPartID = B.PartID
                FROM(
                    SELECT   
                    ROW_NUMBER() OVER(PARTITION BY TMP.FTRcvCode ORDER BY TMP.FTRcvCode ASC) AS PartID ,
                        TMP.FTRptRowSeq
                    FROM TRPTSalRCTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName  = '$tComName'
                    AND TMP.FTRptCode    = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
                    $tAppTypePos
                ) AS B
            WHERE TRPTSalRCTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTSalRCTmp.FTComName = '$tComName' 
            AND TRPTSalRCTmp.FTRptCode = '$tRptCode'
            AND TRPTSalRCTmp.FTUsrSession = '$tUsrSession'
            $tAppTypePos
        ";
        $this->db->query($tSQL);
    }





}

