<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCrSaleMonth extends CI_Model {

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
         // ร้านค้า
         $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
         // กลุ่มธุรกิจ
         $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);
 
        // echo $tPosCodeSelect;
        // die();
         $tCallStore = "{ CALL SP_RPTxPSSaleMonthlyTmp11(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'ptComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => intval($paDataFilter['nFilterType']),
            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],
            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],
            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],
            'ptPosL'    => $tPosCodeSelect,
            'ptPosF'    => $paDataFilter['tPosCodeFrom'],
            'ptPosT'    => $paDataFilter['tPosCodeTo'],
            'ptMonth'    => $paDataFilter['tMonth'],
            'ptMonthT'    => $paDataFilter['tMonthT'],
            'ptYear'    => $paDataFilter['tYear'],
            'FNResult'      => 0
            );

        
        $oQuery = $this->db->query($tCallStore, $aDataStore);


        // print_r($oQuery);
        // die();
        // echo $this->db->last_query();
        // die();
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

     //TRPTPTTSpcPSSaleMonthlyTmp
    public function FSaMGetDataReport($paDataWhere) {

        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSession = $paDataWhere['tUsrSessionID'];
        /// ค่า Apptype
        $nApptype = $paDataWhere['paDataFilter']['nPosType'];
        
        // Set Priority
        $aData = $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tSession);

      
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {

            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(FNcshCountBill) AS FNcshCountBill_Footer,
                    SUM(FCXsdGrandTotal) AS FCXsdGrandTotal_Footer,
                    SUM(FCXshCashCoupon) AS FCXshCashCoupon_Footer,
                    SUM(FCXshAmtAFDisc) AS FCXshAmtAFDisc_Footer,
                    SUM(FCXsdVatable)   AS FCXsdVatable_Footer,
                    SUM(FCXsdVat)   AS FCXsdVat_Footer,
                    SUM(FCXshAllInOne)   AS FCXshAllInOne_Footer,
                    SUM(FCXshElocker)   AS FCXshElocker_Footer,
                    SUM(FCXshDoctor)   AS FCXshDoctor_Footer,
                    SUM(FCXshTelemedi)   AS FCXshTelemedi_Footer
                FROM TRPTPTTSpcPSSaleMonthlyTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tSession'";
                if(!empty($nApptype)){
                 $tJoinFoooter .= " AND FNAppType='".$nApptype."' ";
                   }
                $tJoinFoooter .= "GROUP BY FTUsrSession ) T 
                ON L.FTUsrSession = T.FTUsrSession_Footer
            ";

        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tSession' AS FTUsrSession_Footer,
                    0   AS FNcshCountBill_Footer,
                    0   AS FCXsdGrandTotal_Footer,
                    0   AS FCXshCashCoupon_Footer,
                    0   AS FCXshAmtAFDisc_Footer,
                    0   AS FCXsdVatable_Footer,
                    0   AS FCXsdVat_Footer,
                    0   AS FCXshAllInOne_Footer,
                    0   AS FCXshElocker_Footer,
                    0   AS FCXshDoctor_Footer,
                    0   AS FCXshTelemedi_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
            if(!empty($nApptype)){
                $tJoinFoooter .= " WHERE FNAppType='".$nApptype."' ";
                  }
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.FNcshCountBill_Footer,	
                T.FCXsdGrandTotal_Footer,
                T.FCXshCashCoupon_Footer,
                T.FCXshAmtAFDisc_Footer,
                T.FCXsdVatable_Footer,	
                T.FCXsdVat_Footer,
                T.FCXshAllInOne_Footer,
                T.FCXshElocker_Footer,
                T.FCXshDoctor_Footer,
                T.FCXshTelemedi_Footer
            FROM (
                SELECT  
                    ROW_NUMBER() OVER(ORDER BY FNSaleMonthly) AS RowID,
                    A.*,
                    S.FNRptGroupMember
                FROM TRPTPTTSpcPSSaleMonthlyTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                    FNSaleMonthly AS FNSaleMonthly_SUM,
                        COUNT(FNSaleMonthly) AS FNRptGroupMember
                    FROM TRPTPTTSpcPSSaleMonthlyTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tSession' 
                    GROUP BY FNSaleMonthly
                ) AS S ON A.FNSaleMonthly = S.FNSaleMonthly_SUM
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tSession'";
                if(!empty($nApptype)){
                    $tSQL .= " AND A.FNAppType='".$nApptype."' ";
                   }
             $tSQL .= " /* End Calculate Misures */
            ) AS L 
            LEFT JOIN (
                " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // AND FNAppType=1
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY FNSaleMonthly ASC ";

        // echo $tSQL;
        // die();
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
   
    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 22/04/2019 Wasin(Yoshi)
     * Last Modified: 13/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {
        $tUserCode = $paDataWhere['tUserCode'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUserSession = $paDataWhere['tUserSession'];

        $tSQL = " 
            SELECT 
                FTRcvName  AS rtRcvName,
                FTXshDocNo AS rtRcvDocNo,
                FDCreateOn AS rtRcvCreateOn,
                FCXrcNet   AS rtRcvrcNet 
            FROM TRPTSalRCTmp  
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
            SAL.FNSaleMonthly
            FROM TRPTPTTSpcPSSaleMonthlyTmp SAL WITH(NOLOCK)
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
            UPDATE TRPTPTTSpcPSSaleMonthlyTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FNSaleMonthly ORDER BY FNSaleMonthly ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTPTTSpcPSSaleMonthlyTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession' 
            ) AS B
            WHERE TRPTPTTSpcPSSaleMonthlyTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTPTTSpcPSSaleMonthlyTmp.FTComName = '$ptComName' 
            AND TRPTPTTSpcPSSaleMonthlyTmp.FTRptCode = '$ptRptCode'
            AND TRPTPTTSpcPSSaleMonthlyTmp.FTUsrSession = '$ptUsrSession'
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
            FROM TRPTPTTSpcPSSaleMonthlyTmp AS DTTMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }

}


