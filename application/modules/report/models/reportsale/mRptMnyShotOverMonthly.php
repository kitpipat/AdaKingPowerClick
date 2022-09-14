
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptMnyShotOverMonthly extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 10/07/2019 Saharat(Golf)
     * Last Modified :
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
        
         // /แคชเชีย
         $tCstCodeSelect = ($paDataFilter['bCashierStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tCashierCodeSelect']);
         
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
 
        
         $tCallStore = "{ CALL SP_RPTxMnyShotOverMonthlyTmp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
            $aDataStore = array(
            
                'pnLngID'       => $nLangID,
                'ptComName'     => $tComName,
                'ptRptCode'     => $tRptCode,
                'ptUsrSession'  => $tUserSession,
                'pnFilterType'  => intval($paDataFilter['nFilterType']),

                //สาขา
                'ptBchL'        => $tBchCodeSelect,
                'ptBchF'        => $paDataFilter['tBchCodeFrom'],
                'ptBchT'        => $paDataFilter['tBchCodeTo'],
        
                //pos
                'ptPosL'    => $tPosCodeSelect,
                'ptPosF'    => $paDataFilter['tRptPosCodeFrom'],
                'ptPosT'    => $paDataFilter['tRptPosCodeTo'],

                //แคชเชีย
                'ptUsrL'   => $tCstCodeSelect,
                'ptUsrF'   => $paDataFilter['tCashierCodeFrom'],
                'ptUsrT'   => $paDataFilter['tCashierCodeTo'],
            
                'ptYear'    => $paDataFilter['tYear'],
                'ptMonth'    => $paDataFilter['tMonth'],
        
                'FNResult'      => 0    
            );

        
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        //  echo $this->db->last_query();
        //  die();

        if ($oQuery != FALSE) {
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
     * Creator: 10/07/2019 Saharat(Golf)
     * Last Modified : 13/11/2019 Piya
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */

     //TRPTMnyShotOverMonthlyTmp
    public function FSaMGetDataReport($paDataWhere) {

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName   = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSession   = $paDataWhere['tUsrSessionID'];
        
        // Set Priority
        $aData = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

      
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {

            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(FTDayD1) AS FTDayD1_Footer,
                    SUM(FTDayD2) AS FTDayD2_Footer,
                    SUM(FTDayD3) AS FTDayD3_Footer,
                    SUM(FTDayD4) AS FTDayD4_Footer,
                    SUM(FTDayD5) AS FTDayD5_Footer,
                    SUM(FTDayD6) AS FTDayD6_Footer,
                    SUM(FTDayD7) AS FTDayD7_Footer,
                    SUM(FTDayD8) AS FTDayD8_Footer,
                    SUM(FTDayD9) AS FTDayD9_Footer,
                    SUM(FTDayD10) AS FTDayD10_Footer,
                    SUM(FTDayD11) AS FTDayD11_Footer,
                    SUM(FTDayD12) AS FTDayD12_Footer,
                    SUM(FTDayD13) AS FTDayD13_Footer,
                    SUM(FTDayD14) AS FTDayD14_Footer,
                    SUM(FTDayD15) AS FTDayD15_Footer,
                    SUM(FTDayD16) AS FTDayD16_Footer,
                    SUM(FTDayD17) AS FTDayD17_Footer,
                    SUM(FTDayD18) AS FTDayD18_Footer,
                    SUM(FTDayD19) AS FTDayD19_Footer,
                    SUM(FTDayD20) AS FTDayD20_Footer,
                    SUM(FTDayD21) AS FTDayD21_Footer,
                    SUM(FTDayD22) AS FTDayD22_Footer,
                    SUM(FTDayD23) AS FTDayD23_Footer,
                    SUM(FTDayD24) AS FTDayD24_Footer,
                    SUM(FTDayD25) AS FTDayD25_Footer,
                    SUM(FTDayD26) AS FTDayD26_Footer,
                    SUM(FTDayD27) AS FTDayD27_Footer,
                    SUM(FTDayD28) AS FTDayD28_Footer,
                    SUM(FTDayD29) AS FTDayD29_Footer,
                    SUM(FTDayD30) AS FTDayD30_Footer,
                    SUM(FTDayD31) AS FTDayD31_Footer,
                    SUM(FCShotOver) AS FCShotOver_Footer,
                    SUM(FCMnyShot) AS FCMnyShot_Footer,
                    SUM(FCMnyOver) AS FCMnyOver_Footer,
                    SUM(FCSvnCashIn) AS FCSvnCashIn_Footer,
                    SUM(FCSvnCashOut) AS FCSvnCashOut_Footer
                FROM TRPTMnyShotOverMonthlyTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'";
                $tJoinFoooter .= "GROUP BY FTUsrSession ) T 
                ON L.FTUsrSession = T.FTUsrSession_Footer
            ";

        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tSession' AS FTUsrSession_Footer,
                    '0' AS FTDayD1_Footer,
                    '0' AS FTDayD2_Footer,
                    '0' AS FTDayD3_Footer,
                    '0' AS FTDayD4_Footer,
                    '0' AS FTDayD5_Footer,
                    '0' AS FTDayD6_Footer,
                    '0' AS FTDayD7_Footer,
                    '0' AS FTDayD8_Footer,
                    '0' AS FTDayD9_Footer,
                    '0' AS FTDayD10_Footer,
                    '0' AS FTDayD11_Footer,
                    '0' AS FTDayD12_Footer,
                    '0' AS FTDayD13_Footer,
                    '0' AS FTDayD14_Footer,
                    '0' AS FTDayD15_Footer,
                    '0' AS FTDayD16_Footer,
                    '0' AS FTDayD17_Footer,
                    '0' AS FTDayD18_Footer,
                    '0' AS FTDayD19_Footer,
                    '0' AS FTDayD20_Footer,
                    '0' AS FTDayD21_Footer,
                    '0' AS FTDayD22_Footer,
                    '0' AS FTDayD23_Footer,
                    '0' AS FTDayD24_Footer,
                    '0' AS FTDayD25_Footer,
                    '0' AS FTDayD26_Footer,
                    '0' AS FTDayD27_Footer,
                    '0' AS FTDayD28_Footer,
                    '0' AS FTDayD29_Footer,
                    '0' AS FTDayD30_Footer,
                    '0' AS FTDayD31_Footer,
                    '0' AS FCShotOver_Footer,
                    '0' AS FCMnyShot_Footer,
                    '0' AS FCMnyOver_Footer,
                    '0' AS FCSvnCashIn_Footer,
                    '0' AS FCSvnCashOut_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.*
            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FTUsrCode) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTMnyShotOverMonthlyTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTUsrCode AS FCMnyOver_SUM,
                        COUNT(FTUsrCode) AS FNRptGroupMember
                    FROM TRPTMnyShotOverMonthlyTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tSession' 
                    GROUP BY FTUsrCode
                ) AS S ON A.FTUsrCode = S.FCMnyOver_SUM
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tSession'";
             $tSQL .= " /* End Calculate Misures */
            ) AS L 
            LEFT JOIN (
                " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // AND FNAppType=1
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY FTUsrCode ASC ";

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
            "aRptData"    => $aData,
            "aError"      => $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }
   
    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 22/04/2019 Wasin(Yoshi)
     * Last Modified: 13/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tUserSession = $paDataWhere['tUserSession'];

        $tSQL = " 
            SELECT 
               *
            FROM TRPTMnyShotOverMonthlyTmp  
            WHERE FTUsrSession = '$tUserSession' 
            AND FTComName = '$tCompName' 
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    public function FMaMRPTPagination($paDataWhere) {

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
            SAL.FTUsrCode
            FROM TRPTMnyShotOverMonthlyTmp SAL WITH(NOLOCK)
            WHERE SAL.FTComName = '$tComName'
            AND SAL.FTRptCode = '$tRptCode'
            AND SAL.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();

        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        $nPrevPage = $nPage - 1;
        $nNextPage = $nPage + 1;
        $nRowIDStart = (($nPerPage * $nPage) - $nPerPage); // RowId Start
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

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession) {

        $tSQL = "
            UPDATE TRPTMnyShotOverMonthlyTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTUsrCode ORDER BY FTUsrCode ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTMnyShotOverMonthlyTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession' 
            ) AS B
            WHERE TRPTMnyShotOverMonthlyTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTMnyShotOverMonthlyTmp.FTComName = '$ptComName' 
            AND TRPTMnyShotOverMonthlyTmp.FTRptCode = '$ptRptCode'
            AND TRPTMnyShotOverMonthlyTmp.FTUsrSession = '$ptUsrSession'
        ";
        $this->db->query($tSQL);
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 21/08/2019 Saharat(Golf)
     * Last Modified: 13/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere) {

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                DTTMP.FTRptCode
            FROM TRPTMnyShotOverMonthlyTmp AS DTTMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->num_rows();
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
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUserSession'];
        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTMnyShotOverMonthlyTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }
        
}




