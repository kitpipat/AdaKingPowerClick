<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptInventoryPdtGrp extends CI_Model {
          //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 04/04/2019 Wasin(Yoshi)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreCReport($paDataFilter) {

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        
        $tCallStore = "{ CALL SP_RPTxPdtBalByPdtGrp(?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'ptComName'     => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            // 'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            // 'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptMerL'        => $tMerCodeSelect,
            // 'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            // 'ptMerT'        => $paDataFilter['tMerCodeTo'],

            'ptShpL'        => $tShpCodeSelect,
            // 'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            // 'ptShpT'        => $paDataFilter['tShpCodeTo'],

            'ptPdtGrpF'     => $paDataFilter['tPdtGrpCodeFrom'],
            'ptPdtGrpT'     => $paDataFilter['tPdtGrpCodeTo'],
        
            'FTResult'      => 0,
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
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 18/07/2019 Wasin(Yoshi)
     * Last Modified : 24/09/2019 Piya
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination 
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $aPagination  = $this->FMaMRPTPagination($paDataWhere);
            $nRowIDStart  = $aPagination["nRowIDStart"];
            $nRowIDEnd    = $aPagination["nRowIDEnd"];
            $nTotalPage   = $aPagination["nTotalPage"];
        }else{
            $aPagination  = array();
            $nTotalPage   = 1;
        }

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID']; 

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tUsrSession);

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   
                SELECT 
                    FTUsrSession        AS FTUsrSession_Footer,
                    SUM(FCStkQty)       AS FCStkQty_Footer,
                    SUM(FCPdtCostAmt)  AS FCPdtCostTotal_Footer
                FROM TRPTPdtBalByPdtGrpTmp WITH(NOLOCK)
                WHERE FTComName     = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum 
            $tJoinFoooter = "   
                SELECT
                    '$tUsrSession'  AS FTUsrSession_Footer,
                    0               AS FCStkQty_Footer,
                    0               AS FCPdtCostTotal_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
                SELECT
                    L.*,
                    D.*,
                    T.FCPdtCostTotal_Footer,
                    T.FCStkQty_Footer,
                    T.FCPdtCostTotal_Footer
                FROM (
                    SELECT  
                        ROW_NUMBER() OVER(ORDER BY A.FTPgpChainName ASC , FTPdtCode ASC , FTWahCode ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCStkQty_SubTotal
                    FROM TRPTPdtBalByPdtGrpTmp A WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT
                            FTWahCode          AS FTWahCode_SUM,
                            COUNT(FTWahCode)   AS FNRptGroupMember,
                            SUM(FCStkQty)      AS FCStkQty_SubTotal
                        FROM TRPTPdtBalByPdtGrpTmp WITH(NOLOCK)
                        WHERE FTComName     = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tUsrSession'
                        GROUP BY FTWahCode
                    ) AS S ON A.FTWahCode = S.FTWahCode_SUM
                    LEFT JOIN (
                        SELECT
                            FTPgpChainName          AS FTPgpChainName,
                            COUNT(FTPgpChainName)   AS FTPgpChainName_SUM
                        FROM TRPTPdtBalByPdtGrpTmp WITH(NOLOCK)
                        WHERE FTComName     = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tUsrSession'
                        GROUP BY FTPgpChainName
                    ) AS C ON C.FTPgpChainName = A.FTPgpChainName 
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                ) AS L 
                LEFT JOIN (
                    SELECT
                        FTPgpChainName        AS FTPgpChainName_NEW ,
                        FTPdtCode             AS FTPdtCode_SUM,
                        SUM(FCStkQty)         AS FCStkQty_SUM,
                        SUM(FCPdtCostEX)   AS FCPdtCostEX_SUM,
                        SUM(FCPdtCostAmt)   AS FCPdtCostAmt_SUM
                    FROM TRPTPdtBalByPdtGrpTmp WITH(NOLOCK)
                    WHERE FTComName     = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTPdtCode , FTPgpChainName
                ) AS D ON L.FTPdtCode = D.FTPdtCode_SUM 
                LEFT JOIN (
                " . $tJoinFoooter . "
            ";

        // WHERE เงื่อนไข Page
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $tSQL .= "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        }

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= "   ORDER BY L.FTPgpChainName ASC , L.FTPdtCode ASC , len(L.FTWahCode) ASC";

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
        $tSQL = "
            UPDATE TRPTPdtBalByPdtGrpTmp 
                SET FNRowPartID = B.PartID
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(PARTITION BY FTPgpChainName , FTPdtCode ORDER BY FTPgpChainName ASC , FTPdtCode ASC , FTWahCode ASC) AS PartID, 
                    FTRptRowSeq  
                FROM TRPTPdtBalByPdtGrpTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$ptComName' 
                AND TMP.FTRptCode = '$ptRptCode'
                AND TMP.FTUsrSession = '$ptUsrSession'
            ) B
            WHERE TRPTPdtBalByPdtGrpTmp.FTRptRowSeq = B.FTRptRowSeq 
            AND TRPTPdtBalByPdtGrpTmp.FTComName     = '$ptComName' 
            AND TRPTPdtBalByPdtGrpTmp.FTRptCode     = '$ptRptCode'
            AND TRPTPdtBalByPdtGrpTmp.FTUsrSession  = '$ptUsrSession' 
        ";

        $this->db->query($tSQL);
    }


    /**
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 18/07/2019 Wasin(Yoshi)
     * Last Modified : 24/09/2019 Piya
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere){

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                TT_TMP.FTWahCode
            FROM TRPTPdtBalByPdtGrpTmp TT_TMP WITH(NOLOCK)
            WHERE TT_TMP.FTComName = '$tComName'
            AND TT_TMP.FTRptCode = '$tRptCode'
            AND TT_TMP.FTUsrSession = '$tUsrSession'
        ";

        // echo '<pre>'.$tSQL; exit();s
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
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
  
}














