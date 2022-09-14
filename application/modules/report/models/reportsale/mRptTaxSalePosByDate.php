<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptTaxSalePosByDate extends CI_Model {
   
    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
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
            FROM TRPTPSTaxHDDateTmp TMP WITH(NOLOCK)
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
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tPosType = $paDataWhere['aRptFilter']['tPosType'];

        $tSQL = "   
            UPDATE TRPTPSTaxHDDateTmp SET 
                FNRowPartID = B.PartID
            FROM( 
                SELECT  
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode ASC, FTPosCode ASC, FDXshDocDate ASC) AS PartID,
                    FTRptRowSeq  
                FROM TRPTPSTaxHDDateTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName' 
                AND TMP.FTRptCode = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'";

        if(!empty($tPosType)){
            $tSQL .= " AND TMP.FNAppType = '$tPosType'";
        }

        $tSQL .= "
        ) AS B
        WHERE TRPTPSTaxHDDateTmp.FTRptRowSeq = B.FTRptRowSeq 
        AND TRPTPSTaxHDDateTmp.FTComName = '$tComName' 
        AND TRPTPSTaxHDDateTmp.FTRptCode = '$tRptCode'
        AND TRPTPSTaxHDDateTmp.FTUsrSession = '$tUsrSession'";
        if(!empty($tPosType)){
            $tSQL .= " AND TRPTPSTaxHDDateTmp.FNAppType = '$tPosType'";
        }
        $this->db->query($tSQL);
    }

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){
        $nPage = $paDataWhere['nPage'];
        $nPerPage = $paDataWhere['nPerPage'];
        
        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];

        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tPosType = $paDataWhere['aRptFilter']['tPosType'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);
    
        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCXshAmt, 0)
                    ) AS FCXshAmt_Footer,
                    SUM( 
                        ISNULL(FCXshVat, 0)
                    ) AS FCXshVat_Footer,
                    SUM( 
                        ISNULL(FCXshAmtNV, 0)
                    ) AS FCXshAmtNV_Footer,
                    SUM( 
                        ISNULL(FCXshGrandTotal, 0)
                    ) AS FCXshGrandTotal_Footer
                FROM TRPTPSTaxHDDateTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'";

            if(!empty($tPosType)){
                $tRptJoinFooter .= " AND FNAppType = '$tPosType'";
            }
            
            $tRptJoinFooter .= " 
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    '0' AS FCXshAmt_Footer,
                    '0' AS FCXshVat_Footer,
                    '0' AS FCXshAmtNV_Footer,
                    '0' AS FCXshGrandTotal_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   
            SELECT
                L.*,
                T.*,
                P.*,
                B.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTBchCode ASC, FTPosCode ASC , FTPosCode ASC, FDXshDocDate ASC, FNRowPartID ASC) AS RowID,
                    ROW_NUMBER() OVER(PARTITION BY FTBchCode, FTPosCode ORDER BY FTBchCode ASC, FTPosCode ASC ,FDXshDocDate ASC, FNRowPartID ASC) AS RowIDPos,
                    A.*
                FROM TRPTPSTaxHDDateTmp A WITH(NOLOCK)
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tUsrSession'";
        if(!empty($tPosType)){
            $tSQL .= " AND A.FNAppType = '$tPosType'";
        }
        $tSQL .= "
            ) AS L
            LEFT JOIN ( SELECT 
                    COUNT(FTPosCode)                    AS FNPosCounts,
                    FTUsrSession                        AS FTUsrSession_SumPos, 
                    FTBchCode                           AS FTBchCode_SumPos,
					FTPosCode                           AS FTPosCode_SumPos,
					SUM( ISNULL(FCXshAmt, 0) )          AS FCXshAmt_SumPos, 
					SUM( ISNULL(FCXshVat, 0) )          AS FCXshVat_SumPos, 
					SUM( ISNULL(FCXshAmtNV, 0) )        AS FCXshAmtNV_SumPos, 
					SUM( ISNULL(FCXshGrandTotal, 0) )   AS FCXshGrandTotal_SumPos
				FROM TRPTPSTaxHDDateTmp WITH(NOLOCK) 
				WHERE 1=1 
				AND FTComName       = '$tComName'
				AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'";
        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '$tPosType'";
        }
        $tSQL .= "
				GROUP BY FTUsrSession, FTPosCode, FTBchCode
            ) P ON L.FTUsrSession = P.FTUsrSession_SumPos AND L.FTBchCode = P.FTBchCode_SumPos AND L.FTPosCode = P.FTPosCode_SumPos
            LEFT JOIN ( SELECT 
                    COUNT(FTBchCode) AS FNBchCount,
					FTUsrSession AS FTUsrSession_SumBch, 
					FTBchCode AS FTBchCode_SumBch,
					SUM( ISNULL(FCXshAmt, 0) ) AS FCXshAmt_SumBch, 
					SUM( ISNULL(FCXshVat, 0) ) AS FCXshVat_SumBch, 
					SUM( ISNULL(FCXshAmtNV, 0) ) AS FCXshAmtNV_SumBch, 
					SUM( ISNULL(FCXshGrandTotal, 0) ) AS FCXshGrandTotal_SumBch
				FROM TRPTPSTaxHDDateTmp WITH(NOLOCK) 
				WHERE 1=1 
				AND FTComName       = '$tComName' 
				AND FTRptCode       = '$tRptCode' 
                AND FTUsrSession    = '$tUsrSession'";
            if(!empty($tPosType)){
                $tSQL .= " AND FNAppType = '$tPosType'";
            }
            $tSQL .= "
				GROUP BY FTUsrSession ,FTBchCode
	        ) B ON L.FTUsrSession = B.FTUsrSession_SumBch AND L.FTBchCode = B.FTBchCode_SumBch
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        if(!empty($tPosType)){
            $tSQL .= " AND L.FNAppType = '$tPosType'";
        }

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTBchCode ASC, L.FNRowPartID ASC, L.RowIDPos ASC, L.FTPosCode ASC, L.FDXshDocDate ASC";

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
            "aPagination"   =>  $aPagination,
            "aRptData"      =>  $aData,
            "aError"        =>  $aErrorList
        ];
        unset($oQuery); 
        unset($aData);
        return $aResualt;
    }
    
    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter){
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
        // เครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPSSVatByDate1001007(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLangID, 
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,

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
            'FTResult'      => 0
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
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        
        $tComName       = $paParams['tCompName'];
        $tRptCode       = $paParams['tRptCode'];
        $tUsrSession    = $paParams['tUsrSessionID'];
        $tPosType       = $paParams['aRptFilter']['tPosType'];

        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTPSTaxHDDateTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'";

        if(!empty($tPosType)){
            $tSQL .= " AND TMP.FNAppType = '$tPosType'";
        }
        
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
        
}




















