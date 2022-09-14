<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


class mRptTaxByProduct extends CI_Model {
    
    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Witsarut(Bell)
     * Last Modified : - 
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreCReport($paDataFilter){
        $nLangID = $paDataFilter['nLangID'];
        $tComName = $paDataFilter['tCompName'];
        $tRptCode = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSessionID'];

        $tBchCodeFrom = empty($paDataFilter['tBchCodeFrom']) ? '' : $paDataFilter['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataFilter['tBchCodeTo']) ? '' : $paDataFilter['tBchCodeTo']; 

        $tShpCodeFrom = empty($paDataFilter['tShpCodeFrom']) ? '' : $paDataFilter['tShpCodeFrom']; 
        $tShpCodeTo = empty($paDataFilter['tShpCodeTo']) ? '' : $paDataFilter['tShpCodeTo'];

        $tCstCodeFrom = empty($paDataFilter['tCstCodeFrom']) ? '' : $paDataFilter['tCstCodeFrom']; 
        $tCstCodeTo = empty($paDataFilter['tCstCodeTo']) ? '' : $paDataFilter['tCstCodeTo'];

        $tDateFrom = empty($paDataFilter['tDocDateFrom']) ? '' : $paDataFilter['tDocDateFrom']; 
        $tDateTo = empty($paDataFilter['tDocDateTo']) ? '' : $paDataFilter['tDocDateTo']; 

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        // exit;
        $tCallStore = "{ CALL SP_RPTxTaxByProduct(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
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

            // ลูกค้า
            'ptCstF'        => $tCstCodeFrom,
            'ptCstT'        => $tCstCodeTo,
            // ่ วันที่
            'ptDocDateF'    => $tDateFrom,
            'ptDocDateT'    => $tDateTo,
            'FNResult'      => 0
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
     * Creator: 04/04/2019 Witsarut(Bell)
     * Last Modified : 15/11/2019 Piya
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = [], $paDataFilter = []){

        $nPage        = $paDataWhere['nPage'];
        $tPosType     = $paDataWhere['tPosType'];
        // Call Data Pagination
        $aPagination  = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart  = $aPagination["nRowIDStart"];
        $nRowIDEnd    = $aPagination["nRowIDEnd"];
        $nTotalPage   = $aPagination["nTotalPage"];
        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUserSession = $paDataWhere['tUserSessionID'];
        
        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);
      
        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = "   
            SELECT
                L.*
                /*T.FCXsdQty_Footer,
                T.FCXsdAmtB4DisChg_Footer,
                T.FCXsdDis_Footer,
                T.FCXsdVat_Footer,
                T.FCXsdNetAfHD_Footer*/
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FNXshDocType ASC, FDXshDocDate ASC, FTXshDocNo ASC, FNType ASC) AS RowID ,
                    A.*,
                    S.FNRptGroupMember,
                    S.FCXsdAmt_SubTotal,
                    S.FCXsdDis_SubTotal,
                    S.FCXsdNet_SubTotal,
                    S.FNCount_DT,
                    S.FNCount_RC
                FROM TRPTTaxByProductTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTXshDocNo AS FTXshDocNo_SUM,
                        COUNT(FTXshDocNo) AS FNRptGroupMember,
                        COUNT(
                            CASE
                                WHEN FNType = 2 THEN FTXshDocNo
                            END     
                        ) AS FNCount_DT,
                        COUNT(
                            CASE
                                WHEN FNType = 3 THEN FTXshDocNo
                            END     
                        ) AS FNCount_RC,
                        SUM(
                            CASE
                                WHEN FNType = 2 THEN FCXsdAmt
                            END
                        ) AS FCXsdAmt_SubTotal,
                        SUM(
                            CASE
                                WHEN FNType = 2 THEN FCXsdDis
                            END
                        ) AS FCXsdDis_SubTotal,
                        SUM(
                            CASE
                                WHEN FNType = 2 THEN FCXsdNet
                            END
                        ) AS FCXsdNet_SubTotal
                    FROM TRPTTaxByProductTmp WITH(NOLOCK)
                    WHERE FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUserSession'
                    $tWhereAppType
                    GROUP BY FTXshDocNo
                ) AS S ON A.FTXshDocNo = S.FTXshDocNo_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUserSession'
                $tWhereAppType
                /* End Calculate Misures */
            ) AS L
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";                  
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FNXshDocType ASC, L.FDXshDocDate ASC, L.FTXshDocNo ASC, L.FNType ASC";
                   
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
     * Functionality: Get Data Page Co
     * Parameters:  Function Parameter
     * Creator: 15/11/2019 Piya
     * Last Modified : -
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere = []) {

        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tUserSessionID = $paDataWhere['tUserSessionID'];

        $tPosType = $paDataWhere['tPosType'];
        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = " 
            SELECT
                TMP.FTRptCode
            FROM TRPTTaxByProductTmp AS TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tCompName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSessionID'
            $tWhereAppType
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
        $tPosType = $paDataWhere['tPosType'];

        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = " 
            UPDATE DATAUPD SET 
                DATAUPD.FNRowPartID = B.PartID
            FROM TRPTTaxByProductTmp AS DATAUPD WITH(NOLOCK)
            INNER JOIN(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTXshDocNo ORDER BY FNXshDocType ASC, FDXshDocDate ASC, FTXshDocNo ASC, FNType ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTTaxByProductTmp WITH(NOLOCK)
                WHERE FTComName = '$tCompName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUserSessionID'
                $tWhereAppType
            ) AS B
            ON DATAUPD.FTRptRowSeq = B.FTRptRowSeq
            AND DATAUPD.FTComName = '$tCompName'
            AND DATAUPD.FTRptCode = '$tRptCode'
            AND DATAUPD.FTUsrSession = '$tUserSessionID'
            $tWhereAppType
        ";

        $this->db->query($tSQL);
    }

    

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 11/04/2019 Witsarut(Bell)
     * Last Modified: 15/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere = []){

        $tUserSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tPosType = $paDataWhere['tPosType'];

        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

       $tSQL = "   
            SELECT 
                TMP.FTRptCode
            FROM TRPTTaxByProductTmp TMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
            $tWhereAppType
        ";

        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }
    


       /**
     * Functionality: Get Data HD By DocNo
     * Parameters:  Function Parameter
     * Creator: 15/11/2019 Piya
     * Last Modified : -
     * Return : Array Data HD
     * Return Type: Array
     */
    public function FMaMRPTGetHDByDocNo($paParams = []) {

        $tDocNo = $paParams['tDocNo'];
        $tCompName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tPosType = $paParams['tPosType'];

        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = "
            SELECT
                FCXshVatable,
                FCXshVat,
                FCXshDis,
                FCXshRnd,
                FCXshGrand
            FROM TRPTTaxByProductTmp TMP WITH(NOLOCK)    
            WHERE TMP.FTXshDocNo = '$tDocNo'
            AND TMP.FTComName = '$tCompName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSessionID'
            AND TMP.FNType = 1
            $tWhereAppType
        ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array()[0];
        }else{
            return [
                'FCXshVatable' => 0,
                'FCXshVat' => 0,
                'FCXshDis' => 0,
                'FCXshRnd' => 0,
                'FCXshGrand' => 0
            ];
        }
    }


      /**
     * Functionality: Sum Footer All
     * Parameters:  Function Parameter
     * Creator: 15/11/2019 Piya
     * Last Modified : -
     * Return : Sum Footer All Data
     * Return Type: Array
     */
    public function FMaMRPTSumFooterAll($paParams = []) {

        $tDocNo = $paParams['tDocNo'];
        $tCompName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tPosType = $paParams['tPosType'];

        $tWhereAppType = empty($tPosType)? "" : " AND FNAppType = $tPosType";

        $tSQL = "
            SELECT
                SUM(
                    CASE
                        WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdAmt, 0)
                    END
                ) AS FCXsdAmt_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdDis, 0)
                    END
                ) AS FFCXsdDis_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXsdNet, 0)
                    END
                ) AS FCXsdNet_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXshVatable, 0)
                    END
                ) AS FCXshVatable_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 2 THEN ISNULL(TMP.FCXshVat, 0)
                    END
                ) AS FCXshVat_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshDis, 0)
                    END
                ) AS FCXshDis_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshRnd, 0)
                    END
                ) AS FCXshRnd_SumFooter,
                SUM(
                    CASE
                        WHEN TMP.FNType = 1 THEN ISNULL(TMP.FCXshGrand, 0)
                    END
                ) AS FCXshGrand_SumFooter
            FROM TRPTTaxByProductTmp TMP WITH(NOLOCK)    
            WHERE TMP.FTComName = '$tCompName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUserSessionID'
            $tWhereAppType
            GROUP BY FTRptCode
        ";
                   
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            return $oQuery->result_array()[0];
        }else{
            return [
                'FCXsdAmt_SumFooter' => 0,
                'FFCXsdDis_SumFooter' => 0,
                'FCXsdNet_SumFooter' => 0,
                'FCXshVatable_SumFooter' => 0,
                'FCXshVat_SumFooter' => 0,
                'FCXshDis_SumFooter' => 0,
                'FCXshRnd_SumFooter' => 0,
                'FCXshGrand_SumFooter' => 0
            ];
        }
    }




  
}


