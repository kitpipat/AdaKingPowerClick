<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


class mRptPaymentByBill extends CI_Model {

    /**
     * Functionality: Call Store Procedure
     * Parameters:  Function Parameter
     * Creator: 04/12/2019 Piya
     * Last Modified : - 
     * Return : Call Store Proce
     * Return Type: Number
     */
    public function FSnMExecStoreCReport($paDataFilter = []){
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // กลุ่มธุระกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : $paDataFilter['tPosCodeSelect'];
        
        $tCallStore = "{ CALL SP_RPTxLocker_PaymentByBill_003001012(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paDataFilter['nLangID'],
            'pnComName' => $paDataFilter['tCompName'],
            'ptRptCode' => $paDataFilter['tRptCode'],
            'ptUsrSession' => $paDataFilter['tUserSessionID'],
            
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

            // ลูกค้า
            'ptCstF'    => $paDataFilter['tCstCodeFrom'],
            'ptCstT'    => $paDataFilter['tCstCodeTo'],
            // วันที่เอกสาร
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FNResult'   => 0,
        );

        // $tCallStore = "{ CALL SP_RPTxLocker_PaymentByBill_003001012(?,?,?,?,?,?,?,?,?,?,?) }";
        // $aDataStore = array(
        //     'pnLngID' => $paDataFilter['nLangID'],
        //     'pnComName' => $paDataFilter['tCompName'],
        //     'ptRptCode' => $paDataFilter['tRptCode'],
        //     'ptUsrSession' => $paDataFilter['tUserSessionID'],
        //     // สาขา
        //     'ptBchF'    => $paDataFilter['tBchCodeFrom'],
        //     'ptBchT'    => $paDataFilter['tBchCodeTo'],
        //     // ลูกค้า
        //     'ptCstF'    => $paDataFilter['tCstCodeFrom'],
        //     'ptCstT'    => $paDataFilter['tCstCodeTo'],
        //     // วันที่เอกสาร
        //     'ptDocDateF' => $paDataFilter['tDocDateFrom'],
        //     'ptDocDateT' => $paDataFilter['tDocDateTo'],
        //     'FNResult'   => 0,
        // );
        // print_r($aDataStore);
        // exit;
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if($oQuery !== FALSE){
            unset($oQuery);
            return 1 ;                
        }else{
            unset($oQuery);
            return 0;
        }   
    }

    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 04/12/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = [], $paDataFilter = []){

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSession = $paDataWhere['tUserSessionID'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(ISNULL(FCXdtPay,0)) AS FCXdtPay_Footer,
                    SUM(ISNULL(FCXshGrand,0)) AS FCXshGrand_Footer,
                    SUM(ISNULL(FCXshLeft,0)) AS FCXshLeft_Footer
                FROM TRPTLockerPaymentByBillTmp WITH(NOLOCK)
                WHERE FTXshDocType = '1'
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUserSession'
                GROUP BY FTUsrSession
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   
                SELECT
                    '$tUserSession' AS FTUsrSession_Footer,
                    0   AS FCXdtPay_Footer,
                    0   AS FCXshGrand_Footer,
                    0   AS FCXshLeft_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary

        $tSQL = "   
            SELECT
                L.*,
                T.FCXdtPay_Footer,
                T.FCXshGrand_Footer,
                T.FCXshLeft_Footer
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTXshDocNo ASC, FTXrcDocNo ASC, FTXshDocType ASC, FDXshDocDate ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTLockerPaymentByBillTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTXshDocNo AS FTXshDocNo_SUM,
                        COUNT(FTXshDocNo) AS FNRptGroupMember
                    FROM TRPTLockerPaymentByBillTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUserSession'
                    GROUP BY FTXshDocNo
                ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUserSession'
                /* End Calculate Misures */
            ) AS L
        ";

        $tSQL .= " LEFT JOIN ( $tJoinFoooter ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";                  
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTXshDocNo ASC, L.FTXrcDocNo ASC, L.FTXshDocType ASC, L.FDXshDocDate ASC";
                   
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();
            // echo $nAllNet;exit();
            $oCountRowRpt = $this->FSnMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nPerPage']);
            $aReturnData = array(
                'raItems' => $aDataRpt,
                'rnAllRow' => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage' => $nPageAll,
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            $aReturnData = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage" => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        unset($oQuery);
        unset($oCountRowRpt);
        unset($nFoundRow);
        unset($nPageAll);
        return $aReturnData;
    }

    /**
     * Functionality: Set Priority Group
     * Parameters:  Function Parameter
     * Creator: 04/12/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere = []) {
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];

        $tSQL = " 
            UPDATE DATAUPD SET 
                DATAUPD.FNRowPartID = B.PartID
            FROM TRPTLockerPaymentByBillTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTXshDocNo ORDER BY FTXshDocNo ASC, FTXrcDocNo ASC, FTXshDocType ASC, FDXshDocDate ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTLockerPaymentByBillTmp WITH(NOLOCK)
                WHERE FTComName = '$tCompName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUserSessionID'
            ) AS B
            ON DATAUPD.FTRptRowSeq = B.FTRptRowSeq
            AND DATAUPD.FTComName = '$tCompName'
            AND DATAUPD.FTRptCode = '$tRptCode'
            AND DATAUPD.FTUsrSession = '$tUserSessionID'
        ";

        $this->db->query($tSQL);
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 04/12/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere = []){

        $tUserSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

       $tSQL = "   
            SELECT 
                TMP.FTRptCode
            FROM TRPTLockerPaymentByBillTmp TMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }

    /**
     * Functionality: Get Data Page
     * Parameters:  Function Parameter
     * Creator: 04/12/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere = []) {

        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];

        $tSQL = " 
            SELECT
                TMP.FTRptCode
            FROM TRPTLockerPaymentByBillTmp AS TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tCompName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
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
}


