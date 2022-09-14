<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleByPaymentDetail extends CI_Model {
 
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
        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTRTSalRCTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
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
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTRTSalRCTmp
                SET TRPTRTSalRCTmp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TMP.FTXshDocNo ORDER BY TMP.FTXshDocNo DESC) AS PartID ,
                        TMP.FTRptRowSeq
                    FROM TRPTRTSalRCTmp TMP WITH(NOLOCK)
                    WHERE TMP.FTComName = '$tComName'
                    AND TMP.FTRptCode = '$tRptCode'
                    AND TMP.FTUsrSession = '$tUsrSession'
                ) AS B
            WHERE TRPTRTSalRCTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTRTSalRCTmp.FTComName = '$tComName' 
            AND TRPTRTSalRCTmp.FTRptCode = '$tRptCode'
            AND TRPTRTSalRCTmp.FTUsrSession = '$tUsrSession'
        ";
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
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        CASE 
                            WHEN FTRcvCode = 001 THEN ISNULL(FCXrcNet, 0)
                            ELSE 0 
                        END
                    ) AS rcSumFootCash,
                    SUM( 
                        CASE 
                            WHEN FTRcvCode = 002 THEN ISNULL(FCXrcNet, 0)
                            ELSE 0 
                        END
                    ) AS rcSumFootCredit,
                    SUM(
                        CASE 
                            WHEN FNRowPartID = 1 THEN ISNULL(FCXrcNet, 0)
                            ELSE 0 
                        END
                    ) AS rcSumFootTotal
                FROM TRPTRTSalRCTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    '0' AS rcSumFootCash,
                    '0' AS rcSumFootCredit,
                    '0' AS rcSumFootTotal
                ) T ON L.FTUsrSession  = T.FTUsrSession_Footer
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
                    ROW_NUMBER() OVER(ORDER BY FTPosCode) AS RowID,
                    A.*,
                    S.FNRptGroupMember,
                    S.rcCash,
                    S.rcCredit
                FROM TRPTRTSalRCTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTXshDocNo AS FTXshDocNo_SUM,
                        SUM( 
                            CASE 
                                WHEN FTRcvCode = 001 THEN ISNULL(FCXrcNet, 0)
                                ELSE 0 
                            END
                        ) AS rcCash,
                        SUM( 
                            CASE 
                                WHEN FTRcvCode = 002 THEN ISNULL(FCXrcNet, 0)
                                ELSE 0 
                            END
                        ) AS rcCredit,
                        COUNT(FDXrcRefDate) AS FNRptGroupMember
                    FROM TRPTRTSalRCTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTXshDocNo
                ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SUM
                WHERE A.FTComName = '$tComName'
                AND   A.FTRptCode = '$tRptCode'
                AND   A.FTUsrSession = '$tUsrSession'
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTXshDocNo ASC, L.FTXrcRefNo1 ASC ";
        
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
    public function FSnMExecStoreReport($paParams){

        $nLangID = $paParams['nLangID'];
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tCode'];
        $tUserSession = $paParams['tUsrSessionID'];
        
        // สาขา
        $tBchCodeFrom = empty($paParams['tBchCodeFrom']) ? '' : $paParams['tBchCodeFrom']; 
        $tBchCodeTo = empty($paParams['tBchCodeTo']) ? '' : $paParams['tBchCodeTo']; 
        // ร้านค้า
        $tShpCodeFrom = empty($paParams['tShpCodeFrom']) ? '' : $paParams['tShpCodeFrom']; 
        $tShpCodeTo = empty($paParams['tShpCodeTo']) ? '' : $paParams['tShpCodeTo']; 
        // เครื่องจุดขาย
        $tPosCodeFrom = empty($paParams['tPosCodeFrom']) ? '' : $paParams['tPosCodeFrom']; 
        $tPosCodeTo = empty($paParams['tPosCodeTo']) ? '' : $paParams['tPosCodeTo']; 
        // ประเภทชำระเงิน(Payment)
        $tReciveTypeCodeFrom = empty($paParams['tRcvCodeFrom']) ? '' : $paParams['tRcvCodeFrom']; 
        $tReciveTypeCodeTo = empty($paParams['tRcvCodeTo']) ? '' : $paParams['tRcvCodeTo']; 
        // วันที่
        $tDateFrom = empty($paParams['tDocDateFrom']) ? '' : $paParams['tDocDateFrom']; 
        $tDateTo = empty($paParams['tDocDateTo']) ? '' : $paParams['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxSaleShopByDate]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxRentalPayment3001006(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID , 
            'pnComName' => $tComName,
            'ptRptCode' => $tRptCode,
            'ptUsrSession' => $tUserSession,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptShpF' => $tShpCodeFrom,
            'ptShpT' => $tShpCodeTo,
            'ptPosCodeF' => $tPosCodeFrom,
            'ptPosCodeT' => $tPosCodeTo,
            'ptReciveTypeF' => $tReciveTypeCodeFrom,
            'ptReciveTypeT' => $tReciveTypeCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
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
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUsrSessionID'];
        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTRTSalRCTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }

}




