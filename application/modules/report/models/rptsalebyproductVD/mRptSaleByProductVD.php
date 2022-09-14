<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleByProductVD extends CI_Model {
        /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paData){

        $tCallStore = "{CALL SP_RPTxVDDailySaleByInvByPdt2001007(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'      => $paData['nLangID'],
            'pnComName'    => $paData['tCompName'],
            'ptRptCode'    => $paData['tRptCode'],
            'ptUsrSession' => $paData['tUserSession'],
            'ptBchF'       => $paData['tBchCodeFrom'],
            'ptBchT'       => $paData['tBchCodeTo'],
            'ptShpF'       => $paData['tRptShpCodeFrom'],
            'ptShpT'       => $paData['tRptShpCodeTo'],
            'ptMerF'       => $paData['tRptMerCodeFrom'],
            'ptMerT'       => $paData['tRptMerCodeTo'],
            'ptPosF'       => $paData['tRptPosCodeFrom'],
            'ptPosT'       => $paData['tRptPosCodeTo'],
            'ptPdtCodeF'   => $paData['tRptPdtCodeFrom'],
            'ptPdtCodeT'   => $paData['tRptPdtCodeTo'],
            'ptPdtChanF'   => $paData['tRptPdtGrpCodeFrom'],
            'ptPdtChanT'   => $paData['tRptPdtGrpCodeTo'],
            'ptPdtTypeF'   => $paData['tRptPdtTypeCodeFrom'],
            'ptPdtTypeT'   => $paData['tRptPdtTypeCodeTo'],
            'ptDocDateF'   => $paData['tDocDateFrom'],
            'ptDocDateT'   => $paData['tDocDateTo'],
            'FNResult'     => 0
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
     * Creator: 01/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Count row
     * Return Type: Number
     */
    public function FSnMCountRowInTemp($paParams){
        $tComName    = $paParams['tCompName'];
        $tRptCode    = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];
        $tSQL = "   
            SELECT
                COUNT(TSPT.FTRptCode) AS rnCountPage
            FROM TRPTVDTSaleByProductTemp
            TSPT WITH(NOLOCK)
            WHERE 1=1
            AND TSPT.FTComName    = '$tComName'
            AND TSPT.FTRptCode    = '$tRptCode'
            AND TSPT.FTUsrSession = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }

        /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 09/10/2019 Sahaart(Golf)
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
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if($nPage == $nTotalPage){
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( ISNULL( FCXsdQty, 0 ) )         AS FCXsdQty_Footer,
                    SUM( ISNULL( FCXsdAmtB4DisChg, 0 ) ) AS FCXsdAmtB4DisChg_Footer,
                    SUM( ISNULL( FCXsdDis, 0 ) )         AS FCXsdDis_Footer,
                    SUM( ISNULL( FCXsdNetAfHD, 0 ) )     AS FCXsdNetAfHD_Footer,
                    SUM( ISNULL( FCXsdVat, 0 ) )         AS FCXsdVat_Footer
            
                FROM TRPTVDTSaleByProductTemp   WITH(NOLOCK)
                WHERE 1=1
                AND FTComName    = '$tComName'
                AND FTRptCode    = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }else{
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXsdQty_Footer,
                    0 AS FCXsdSetPrice_Footer,
                    0 AS FCXsdAmtB4DisChg_Footer,
                    0 AS FCXsdDis_Footer,
                    0 AS FCXsdNetAfHD_Footer,
                    0 AS FCXsdVat_Footer

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
                    ROW_NUMBER() OVER(ORDER BY FTPdtCode) AS RowID,
                    A.*,
                    S.FNRptGroupMember,
                   	S.FCXsdQty_SUM,
                    S.FCXsdDis_SUM,
                    S.FCXsdAmtB4DisChg_SUM,
                    S.FCXsdNetAfHD_SUM,
                    S.FCXsdVat_SUM

                FROM TRPTVDTSaleByProductTemp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT

                        FTXshDocNo                            AS FTXshDocNo_SUM,
                        COUNT ( FTXshDocNo )                 AS FNRptGroupMember,
                        SUM( ISNULL( FCXsdQty, 0 ) )         AS FCXsdQty_SUM,
                        SUM( ISNULL( FCXsdDis, 0 ) ) 	     AS FCXsdDis_SUM,
                        SUM( ISNULL( FCXsdAmtB4DisChg, 0 ) ) AS FCXsdAmtB4DisChg_SUM,
                        SUM( ISNULL( FCXsdNetAfHD, 0 ) )     AS FCXsdNetAfHD_SUM,
                        SUM( ISNULL( FCXsdVat, 0 ) )         AS FCXsdVat_SUM

                    FROM TRPTVDTSaleByProductTemp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName    = '$tComName'
                    AND FTRptCode    = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTXshDocNo
                ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SUM
                WHERE A.FTComName    = '$tComName'
                AND   A.FTRptCode    = '$tRptCode'
                AND   A.FTUsrSession = '$tUsrSession'
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
            ".$tRptJoinFooter."
        ";

        // WHERE เงื่อนไข Page
        $tSQL   .=  " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  " ORDER BY L.FTXshDocNo ASC ";
      
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
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 01/09/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere){
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tSQL = "   
            SELECT
                COUNT(TSBP.FTRptCode) AS rnCountPage
            FROM TRPTVDTSaleByProductTemp TSBP WITH(NOLOCK)
            WHERE 1=1
            AND TSBP.FTComName = '$tComName'
            AND TSBP.FTRptCode = '$tRptCode'
            AND TSBP.FTUsrSession = '$tUsrSession'
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
     * Creator: 01/09/2019 Saharat(Golf)
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    private function FMxMRPTSetPriorityGroup($paDataWhere){
        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "UPDATE TRPTVDTSaleByProductTemp
                SET TRPTVDTSaleByProductTemp.FNRowPartID = B.PartID
                FROM (
                    SELECT
                        ROW_NUMBER() OVER(PARTITION BY TSBP.FTXshDocNo ORDER BY TSBP.FTXshDocNo ASC) AS PartID ,
                        TSBP.FTRptRowSeq
                    FROM TRPTVDTSaleByProductTemp TSBP WITH(NOLOCK)
                    WHERE 1=1
                    AND TSBP.FTComName  = '$tComName'
                    AND TSBP.FTRptCode    = '$tRptCode'
                    AND TSBP.FTUsrSession = '$tUsrSession'
                ) AS B
            WHERE 1=1
            AND TRPTVDTSaleByProductTemp.FTRptRowSeq  = B.FTRptRowSeq
            AND TRPTVDTSaleByProductTemp.FTComName    = '$tComName' 
            AND TRPTVDTSaleByProductTemp.FTRptCode    = '$tRptCode'
            AND TRPTVDTSaleByProductTemp.FTUsrSession = '$tUsrSession'
        ";
        $this->db->query($tSQL);
    }








}




