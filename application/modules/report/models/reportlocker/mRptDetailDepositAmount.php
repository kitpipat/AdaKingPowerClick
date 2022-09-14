<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


class mRptDetailDepositAmount extends CI_Model {

    /**
     * Functionality: Call Store Procedure
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Piya
     * Last Modified : - 
     * Return : Call Store Proce
     * Return Type: Number
     */
    public function FSnMExecStoreCReport($paDataFilter = []){

        // สาขา
        $tBchCodeSelect     = ($paDataFilter['bBchStaSelectAll']) ? '' : $paDataFilter['tBchCodeSelect']; 
        // ร้านค้า
        $tShpCodeSelect     = ($paDataFilter['bShpStaSelectAll']) ? '' : $paDataFilter['tShpCodeSelect'];
        // กลุ่มธุระกิจ
        $tMerCodeSelect     = ($paDataFilter['bMerStaSelectAll']) ? '' : $paDataFilter['tMerCodeSelect'];      
        //ตู้ Locker
        $tLockerCodeSelect  = ($paDataFilter['bLockerStaSelectAll']) ? '' : $paDataFilter['tLockerCodeSelect'];
        
        //22
        $tCallStore = "{ CALL SP_RPTxLocker_DetailDepositAmount_003001011(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
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
            'ptPosL'        => $tLockerCodeSelect,
            'ptPosF'        => $paDataFilter['tLockerCodeFrom'],
            'ptPosT'        => $paDataFilter['tLockerCodeTo'],

            // ช่อง
            'ptLayNoF' => $paDataFilter['tLockerChanelFrom'],
            'ptLayNoT' => $paDataFilter['tLockerChanelTo'],

            // วันที่เอกสาร
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FNResult' => 0,
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
     * Creator: 02/12/2019 Piya
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
                    SUM(FCXshGrand) AS FCXshGrand_Footer
                FROM TRPTLockerDetailDepositAmountTmp WITH(NOLOCK)
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
                    0   AS FCXshGrand_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary

        $tSQL = "   
            SELECT
                L.*,
                T.FCXshGrand_Footer,
                SUMBCH.FTXshSpendTime_SUMBCH,
                SUMBCH.FCXshGrand_SUMBCH,
                SUMSHP.FTXshSpendTime_SUMSHP,
                SUMSHP.FCXshGrand_SUMSHP
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTBchCode ASC, FTShpCode ASC, FDXshDocDate ASC, FTXshDocNo ASC) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTLockerDetailDepositAmountTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTBchCode AS FTBchCode_SUM,
                        COUNT(FTBchCode) AS FNRptGroupMember
                    FROM TRPTLockerDetailDepositAmountTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUserSession'
                    GROUP BY FTBchCode
                ) AS S ON A.FTBchCode = S.FTBchCode_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUserSession'
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
                SELECT
                    FTUsrSession AS FTUsrSession_SUMBCH,
                    FTBchCode AS FTBchCode_SUMBCH,
                    SUM(ISNULL(CAST(FTXshSpendTime AS NUMERIC(18, 2)), 0)) AS FTXshSpendTime_SUMBCH,
                    SUM(ISNULL(FCXshGrand, 0)) AS FCXshGrand_SUMBCH
                FROM TRPTLockerDetailDepositAmountTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUserSession'
                GROUP BY FTUsrSession,FTBchCode
            ) SUMBCH ON L.FTUsrSession = SUMBCH.FTUsrSession_SUMBCH AND L.FTBchCode = SUMBCH.FTBchCode_SUMBCH
            LEFT JOIN (
                SELECT
                    FTUsrSession AS FTUsrSession_SUMSHP,
                    FTShpCode AS FTShpCode_SUMSHP,
                    SUM(ISNULL(CAST(FTXshSpendTime AS NUMERIC(18, 2)), 0)) AS FTXshSpendTime_SUMSHP,
                    SUM(ISNULL(FCXshGrand, 0)) AS FCXshGrand_SUMSHP
                FROM TRPTLockerDetailDepositAmountTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUserSession'
                GROUP BY FTUsrSession,FTShpCode
            ) SUMSHP ON L.FTUsrSession = SUMSHP.FTUsrSession_SUMSHP AND L.FTShpCode = SUMSHP.FTShpCode_SUMSHP
        ";

        $tSQL .= " LEFT JOIN ( $tJoinFoooter ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";                  
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTBchCode ASC, L.FTShpCode ASC, L.FDXshDocDate ASC, L.FTXshDocNo ASC";
                   
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
     * Creator: 02/12/2019 Piya
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
            FROM TRPTLockerDetailDepositAmountTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode, FTShpCode ORDER BY FTBchCode ASC, FTShpCode ASC, FDXshDocDate ASC, FTXshDocNo ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTLockerDetailDepositAmountTmp WITH(NOLOCK)
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
     * Creator: 02/12/2019 Piya
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
            FROM TRPTLockerDetailDepositAmountTmp TMP WITH(NOLOCK)
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
     * Creator: 02/12/2019 Piya
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
            FROM TRPTLockerDetailDepositAmountTmp AS TMP WITH(NOLOCK)
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


