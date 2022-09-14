<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptProductSaleOfWeek extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 20/12/2019 Piya
     * Last Modified : - 
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreCReport($paParams){
        $nLangID = $paParams['nLangID'];
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUserSession = $paParams['tUserSessionID'];
        // Filter Type
        $tTypeDataCondition = empty($paParams['tTypeDataCondition']) ? '' : $paParams['tTypeDataCondition']; 
        // สาขา
        $tBchCodeSelect = ($paParams['bBchStaSelectAll']) ? '' : FCNtAddDoubleSingleQuote($paParams['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paParams['bShpStaSelectAll']) ? '' : FCNtAddDoubleSingleQuote($paParams['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paParams['bMerStaSelectAll']) ? '' : FCNtAddDoubleSingleQuote($paParams['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paParams['bPosStaSelectAll']) ? '' : FCNtAddDoubleSingleQuote($paParams['tPosCodeSelect']);
        
        $tCallStore = "{CALL SP_RPTxPSVDWeeklySale(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptCode' => $tRptCode,
            'ptUsrSession' => $tUserSession,
            'pnFilterType' => $tTypeDataCondition,
            'ptBchF' => $paParams['tBchCodeFrom'],
            'ptBchT' => $paParams['tBchCodeTo'],
            'ptMerF' => $paParams['tMerCodeFrom'],
            'ptMerT' => $paParams['tMerCodeTo'],
            'ptShpF' => $paParams['tShpCodeFrom'],
            'ptShpT' => $paParams['tShpCodeTo'],
            'ptPosCodeF' => $paParams['tPosCodeFrom'],
            'ptPosCodeT' => $paParams['tPosCodeTo'],
            'ptBchL' => $tBchCodeSelect,
            'ptMerL' => $tMerCodeSelect,
            'ptShpL' => $tShpCodeSelect,
            'ptPosCodeL' => $tPosCodeSelect,
            'pdMonthSale' => $paParams['tMonth'],
            'pdYearSale' => $paParams['tYear'],
            'FNResult' => 0
        );
        
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
     * Creator: 20/12/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = [], $paDataFilter = []){

        $nPage = $paDataWhere['nPage'];
        // $tPosType = $paDataWhere['tPosType'];
        // Call Data Pagination
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSession = $paDataWhere['tUserSessionID'];
        
        // $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(ISNULL(FNXshTotalBill,0)) AS FNXshTotalBill_Footer,
                    SUM(ISNULL(FCXshGrand,0)) AS FCXshGrand_Footer,
                    SUM(ISNULL(FCXrcNetVDQR,0)) AS FCXrcNetVDQR_Footer,
                    SUM(ISNULL(FCXrcNetPosCash,0)) AS FCXrcNetPosCash_Footer,
                    SUM(ISNULL(FCXrcNetPosQR,0)) AS FCXrcNetPosQR_Footer,
                    SUM(ISNULL(FCXrcNetPosEDC,0)) AS FCXrcNetPosEDC_Footer
                FROM TRPTPTTSpcPSVDWeeklySaleTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
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
                    0 AS FNXshTotalBill_Footer,
                    0 AS FCXshGrand_Footer,
                    0 AS FCXrcNetVDQR_Footer,
                    0 AS FCXrcNetPosCash_Footer,
                    0 AS FCXrcNetPosQR_Footer,
                    0 AS FCXrcNetPosEDC_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary

        
        $tSQL = "   
            SELECT
                L.*,
                T.FNXshTotalBill_Footer,
                T.FCXshGrand_Footer,
                T.FCXrcNetVDQR_Footer,
                T.FCXrcNetPosCash_Footer,
                T.FCXrcNetPosQR_Footer,
                T.FCXrcNetPosEDC_Footer
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FDXshDocWeek ASC) AS RowID ,
                    A.*
                FROM TRPTPTTSpcPSVDWeeklySaleTmp A WITH(NOLOCK)
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUserSession'
            ) AS L
        ";

        $tSQL .= "LEFT JOIN ( $tJoinFoooter ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";                  
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FDXshDocWeek ASC";
                  
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
     * Creator: 15/11/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere = []) {
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];
        // $tPosType = $paDataWhere['tPosType'];

        // $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = " 
            UPDATE DATAUPD SET 
                DATAUPD.FNRowPartID = B.PartID
            FROM TRPTPTTSpcPSVDWeeklySaleTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FDXshDocWeek ORDER BY FDXshDocWeek ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTPTTSpcPSVDWeeklySaleTmp WITH(NOLOCK)
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
     * Creator: 20/12/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere = []){

        $tUserSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        // $tPosType = $paDataWhere['tPosType'];

        // $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

       $tSQL = "   
            SELECT 
                TMP.FTRptCode
            FROM TRPTPTTSpcPSVDWeeklySaleTmp TMP WITH(NOLOCK)
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
     * Functionality: Get Data Page Co
     * Parameters:  Function Parameter
     * Creator: 20/12/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paParams = []) {

        $tCompName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUserSessionID = $paParams['tUserSessionID'];

        // $tPosType = $paParams['tPosType'];

        // $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = " 
            SELECT
                TMP.FTRptCode
            FROM TRPTPTTSpcPSVDWeeklySaleTmp AS TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tCompName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSessionID'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        $nPage = $paParams['nPage'];
        $nPerPage = $paParams['nPerPage'];
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
            "nDisplayPage" => $paParams['nPage'],
            "nRowIDStart" => $nRowIDStart,
            "nRowIDEnd" => $nRowIDEnd,
            "nPrevPage" => $nPrevPage,
            "nNextPage" => $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }
}


