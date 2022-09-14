<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleByCashierAndPos extends CI_Model {
   
    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tPosType = $paDataWhere['aRptFilter']['tPosType'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTSalByCashierAndPosTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'";

        if(!empty($tPosType)){
            $tSQL .= " AND TMP.FNAppType = '$tPosType'";
        }
        
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
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTSalByCashierAndPosTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT  
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTPosCode ORDER BY FTPosCode ASC, FTBchCode ASC, FTUsrCode ASC) AS PartID,
                    FNRptRowSeq  
                FROM TRPTSalByCashierAndPosTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName' 
                AND TMP.FTRptCode = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'";
        $tSQL .= "
            ) AS B
            WHERE TRPTSalByCashierAndPosTmp.FNRptRowSeq = B.FNRptRowSeq 
            AND TRPTSalByCashierAndPosTmp.FTComName = '$tComName' 
            AND TRPTSalByCashierAndPosTmp.FTRptCode = '$tRptCode'
            AND TRPTSalByCashierAndPosTmp.FTUsrSession = '$tUsrSession'";
        
        $this->db->query($tSQL);
    }

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
        $nPage = $paDataWhere['nPage'];
        
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // $tPosType = $paDataWhere['aRptFilter']['tPosType'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);
    
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FNXshBillQty, 0)
                    ) AS FNXshBillQty_Footer,
                    SUM( 
                        ISNULL(FCXshNet, 0)
                    ) AS FCXshNet_Footer,
                    SUM( 
                        ISNULL(FCXshReturn, 0)
                    ) AS FCXshReturn_Footer,
                    SUM( 
                        ISNULL(FCXshRnd, 0)
                    ) AS FCXshRnd_Footer,
                    SUM( 
                        ISNULL(FCXshDis, 0)
                    ) AS FCXshDis_Footer,
                    SUM( 
                        ISNULL(FCXshGrand, 0)
                    ) AS FCXshGrand_Footer,
                    SUM( 
                        ISNULL(FCXrcCash, 0)
                    ) AS FCXrcCash_Footer,
                    SUM( 
                        ISNULL(FCXrcCredit, 0)
                    ) AS FCXrcCredit_Footer,
                    SUM( 
                        ISNULL(FCXrcCheque, 0)
                    ) AS FCXrcCheque_Footer,
                    SUM( 
                        ISNULL(FCXrcCashCpn, 0)
                    ) AS FCXrcCashCpn_Footer,
                    SUM( 
                        ISNULL(FCXrcVoucher, 0)
                    ) AS FCXrcVoucher_Footer,
                    SUM( 
                        ISNULL(FCXrcCashCrd, 0)
                    ) AS FCXrcCashCrd_Footer,
                    SUM( 
                        ISNULL(FCXrcOther, 0)
                    ) AS FCXrcOther_Footer,
                    SUM( 
                        ISNULL(FCXrcTotal, 0)
                    ) AS FCXrcTotal_Footer
                FROM TRPTSalByCashierAndPosTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'";

            /* if(!empty($tPosType)){
                $tRptJoinFooter .= " AND FNAppType = '$tPosType'";
            } */
            
            $tRptJoinFooter .= " 
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FNXshBillQty_Footer,
                    0 AS FCXshNet_Footer,
                    0 AS FCXshReturn_Footer,
                    0 AS FCXshRnd_Footer,
                    0 AS FCXshDis_Footer,
                    0 AS FCXshGrand_Footer,
                    0 AS FCXrcCash_Footer,
                    0 AS FCXrcCredit_Footer,
                    0 AS FCXrcCheque_Footer,
                    0 AS FCXrcCashCpn_Footer,
                    0 AS FCXrcVoucher_Footer,
                    0 AS FCXrcCashCrd_Footer,
                    0 AS FCXrcOther_Footer,
                    0 AS FCXrcTotal_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.*,
                P.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTBchCode ASC, FTPosCode ASC, FTUsrCode ASC) AS RowID,
                    A.*
                FROM TRPTSalByCashierAndPosTmp A WITH(NOLOCK)
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tUsrSession'";
        $tSQL .= "
            ) AS L
            LEFT JOIN ( 
                SELECT 
                    FTBchCode,
                    COUNT(FTPosCode) AS FNPosCounts,
                    FTUsrSession AS FTUsrSession_SumPos, 
					FTPosCode AS FTPosCode_SumPos,
					SUM( ISNULL(FNXshBillQty, 0) ) AS FNXshBillQty_SumPos, 
					SUM( ISNULL(FCXshNet, 0) ) AS FCXshNet_SumPos, 
					SUM( ISNULL(FCXshReturn, 0) ) AS FCXshReturn_SumPos, 
                    SUM( ISNULL(FCXshRnd, 0) ) AS FCXshRnd_SumPos,
                    SUM( ISNULL(FCXshDis, 0) ) AS FCXshDis_SumPos,
                    SUM( ISNULL(FCXshGrand, 0) ) AS FCXshGrand_SumPos,
                    SUM( ISNULL(FCXrcCash, 0) ) AS FCXrcCash_SumPos,
                    SUM( ISNULL(FCXrcCredit, 0) ) AS FCXrcCredit_SumPos,
                    SUM( ISNULL(FCXrcCheque, 0) ) AS FCXrcCheque_SumPos,
                    SUM( ISNULL(FCXrcCashCpn, 0) ) AS FCXrcCashCpn_SumPos,
                    SUM( ISNULL(FCXrcVoucher, 0) ) AS FCXrcVoucher_SumPos,
                    SUM( ISNULL(FCXrcCashCrd, 0) ) AS FCXrcCashCrd_SumPos,
                    SUM( ISNULL(FCXrcOther, 0) ) AS FCXrcOther_SumPos,
                    SUM( ISNULL(FCXrcTotal, 0) ) AS FCXrcTotal_SumPos
				FROM TRPTSalByCashierAndPosTmp WITH(NOLOCK) 
				WHERE 1=1 
				AND FTComName       = '$tComName'
				AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'";
        $tSQL .= "
				GROUP BY FTUsrSession, FTBchCode, FTPosCode
            ) P ON L.FTUsrSession = P.FTUsrSession_SumPos AND L.FTBchCode = P.FTBchCode  AND L.FTPosCode = P.FTPosCode_SumPos
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTBchCode ASC, L.FTPosCode ASC, L.FTUsrCode ASC";

        // print_r($tSQL);
        // exit;

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
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
        $nLangID = $paDataFilter['nLangID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPSSaleByCashierAndPos001001022(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID, 
            'pnComName' => $tComName,
            'ptRptCode' => $tRptCode,
            'ptUsrSession' => $tUserSession,

            'pnFilterType' => $paDataFilter['tTypeSelect'],
            
            // สาขา
            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paDataFilter['tBchCodeFrom'],
            'ptBchT' => $paDataFilter['tBchCodeTo'],
            // กลุ่มธุรกิจ
            'ptMerL' => $tMerCodeSelect,
            'ptMerF' => $paDataFilter['tMerCodeFrom'],
            'ptMerT' => $paDataFilter['tMerCodeTo'],
            // ร้านค้า
            'ptShpL' => $tShpCodeSelect,
            'ptShpF' => $paDataFilter['tShpCodeFrom'],
            'ptShpT' => $paDataFilter['tShpCodeTo'],
            // จุดขาย
            'ptPosL' => $tPosCodeSelect,
            'ptPosF' => $paDataFilter['tPosCodeFrom'],
            'ptPosT' => $paDataFilter['tPosCodeTo'],
            // แคชเชียร์
            'ptUsrF' => $paDataFilter['tCashierCodeFrom'],
            'ptUsrT' => $paDataFilter['tCashierCodeTo'],
            // วันที่เอกสาร
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FTResult' => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }
    
    /**
     * Functionality: Count Row in Temp
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUsrSessionID'];
        // $tPosType = $paParams['aRptFilter']['tPosType'];

        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTSalByCashierAndPosTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'";

        /* if(!empty($tPosType)){
            $tSQL .= " AND TMP.FNAppType = '$tPosType'";
        } */
        
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
        
}




















