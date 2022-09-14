<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptTaxSaleLocker extends CI_Model {

    /**
     * Functionality: Call Store Report
     * Parameters: function parameters
     * Creator:  02/08/2019 Wasin(Yoshi)
     * Last Modified: 03/10/2019 Piya
     * Return: Numeric Status Run Stored Procedure
     * Return Type: Numeric
     */
    public function FSnMExecStoreCReport($paParams) {
        $tCallStore = "{ CALL SP_RPTxLKVat3001003(?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paParams['nLangID'],
            'pnComName' => $paParams['tCompName'],
            'ptRptCode' => $paParams['tRptCode'],
            'ptUsrSession' => $paParams['tUserSession'],
            
            'ptMerF' => $paParams['tMerchantCode'],
            'ptShpF' => $paParams['tShpCodeFrom'],
            'ptShpT' => $paParams['tShpCodeTo'],
            'ptDocDateF' => $paParams['tDocDateFrom'],
            'ptDocDateT' => $paParams['tDocDateTo'],
            'FNResult' => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        if ($oQuery !== FALSE) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }
    
    /**
     * Functionality: Count Data Rows All In DB Temp
     * Parameters: function parameters
     * Creator:  05/08/2019 Wasin(Yoshi)
     * Last Modified: 03/10/2019 Piya
     * Return: Count Data All Temp
     * Return Type: Numeric
     */
    public function FSnMCountRowInTemp($paParams) {

        $tComName = $paParams['tCompName'];
        $tRptCode = $paParams['tRptCode'];
        $tUsrSession = $paParams['tUserSession'];
        
        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTRTTaxHDTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName       = '$tComName'
            AND TMP.FTRptCode       = '$tRptCode'
            AND TMP.FTUsrSession    = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        return $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
    }

    /**
     * Functionality: Data Address Merchant
     * Parameters: function parameters
     * Creator:  22/07/2019 Wasin(Yoshi)
     * Last Modified: 03/10/2019 Piya
     * Return: Data Array
     * Return Type: Array
     */
    public function FSaMGetDataMerChant($paDataWhereMerChant) {
        $tMerchantCode = $paDataWhereMerChant['tMerChantCode'];
        $nLngID = $paDataWhereMerChant['nLngID'];

        $tSQL = "   
            SELECT DISTINCT
                MER.FTMerCode AS FTCompCode,
                MER_L.FTMerName AS FTCompName,
                ADDL_MER.FTAddVersion,
                ADDL_MER.FTAddV1No,
                ADDL_MER.FTAddV1Soi,
                ADDL_MER.FTAddV1Village,
                ADDL_MER.FTAddV1Road,
                ADDL_MER.FTAddV1SubDist,
                SUBDIS_L.FTSudName,
                ADDL_MER.FTAddV1DstCode,
                DST_L.FTDstName,
                ADDL_MER.FTAddV1PvnCode,
                PVN_L.FTPvnName,
                ADDL_MER.FTAddV1PostCode,
                ADDL_MER.FTAddV2Desc1,
                ADDL_MER.FTAddV2Desc2,
                MER.FTMerEmail AS FTCompEmail,
                MER.FTMerTel AS FTCompTel,
                MER.FTMerFax AS FTCompFax,
                MER.FTMerMo AS FTCompMobile
            FROM TCNMMerchant MER WITH(NOLOCK)
            LEFT JOIN TCNMMerchant_L MER_L WITH(NOLOCK) ON MER.FTMerCode = MER_L.FTMerCode AND MER_L.FNLngID = $nLngID
            LEFT JOIN TCNMAddress_L ADDL_MER WITH(NOLOCK) ON MER.FTMerCode = ADDL_MER.FTAddRefCode AND ADDL_MER.FTAddGrpType = 7 AND ADDL_MER.FNLngID = $nLngID
            LEFT JOIN TCNMSubDistrict SUBDIS WITH(NOLOCK) ON ADDL_MER.FTAddV1SubDist = SUBDIS.FTSudCode
            LEFT JOIN TCNMSubDistrict_L SUBDIS_L WITH(NOLOCK) ON SUBDIS.FTSudCode = SUBDIS_L.FTSudCode AND SUBDIS_L.FNLngID = $nLngID
            LEFT JOIN TCNMDistrict DST WITH(NOLOCK) ON ADDL_MER.FTAddV1DstCode = DST.FTDstCode
            LEFT JOIN TCNMDistrict_L DST_L WITH(NOLOCK) ON DST.FTDstCode = DST_L.FTDstCode AND DST_L.FNLngID = $nLngID
            LEFT JOIN TCNMProvince PVN WITH(NOLOCK) ON ADDL_MER.FTAddV1PvnCode = PVN.FTPvnCode
            LEFT JOIN TCNMProvince_L PVN_L WITH(NOLOCK) ON PVN.FTPvnCode = PVN_L.FTPvnCode AND PVN_L.FNLngID = $nLngID
            WHERE 1=1 AND MER.FTMerCode = '$tMerchantCode'
        ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * Last Modified : 03/10/2019 Piya 
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere) {
        
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        
        $tSQL = "   
            SELECT
                COUNT(RPTTaxSaleLK_Tmp.FTRptCode) AS rnCountPage
            FROM TRPTRTTaxHDTmp RPTTaxSaleLK_Tmp WITH(NOLOCK)
            WHERE 1=1
            AND RPTTaxSaleLK_Tmp.FTComName      = '$tComName'
            AND RPTTaxSaleLK_Tmp.FTRptCode      = '$tRptCode'
            AND RPTTaxSaleLK_Tmp.FTUsrSession   = '$tUsrSession'
        ";
        
        $oQuery = $this->db->query($tSQL);
        
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
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

    /**
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * Last Modified : 03/10/2019 Piya 
     * Return : Array Data Page Nation
     * Return Type: Array
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere) {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            UPDATE TRPTRTTaxHDTmp SET 
                FNRowPartID = B.PartID
            FROM(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTPosCode ORDER BY FTPosCode ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTRTTaxHDTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName' 
                AND TMP.FTRptCode = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'
            ) AS B
            WHERE TRPTRTTaxHDTmp.FTRptRowSeq = B.FTRptRowSeq
            AND TRPTRTTaxHDTmp.FTComName = '$tComName' 
            AND TRPTRTTaxHDTmp.FTRptCode = '$tRptCode'
            AND TRPTRTTaxHDTmp.FTUsrSession = '$tUsrSession'
        ";
        
        $this->db->query($tSQL);
    }
 
    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * Last Modified : 03/10/2019 Piya 
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {
        $nPage = $paDataWhere['nPage'];
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
        if ($nPage == $nTotalPage) {
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(FCXshAmt) AS FCXshAmt_Footer,
                    SUM(FCXshAmtV) AS FCXshAmtV_Footer,
                    SUM(FCXshAmtNV) AS FCXshAmtNV_Footer,
                    SUM(FCXshGrandTotal) AS FCXshGrandTotal_Footer
                FROM TRPTRTTaxHDTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            $tRptJoinFooter = " 
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXshAmt_Footer,
                    0 AS FCXshAmtV_Footer,
                    0 AS FCXshAmtNV_Footer,
                    0 AS FCXshGrandTotal_Footer
                ) T ON  L.FTUsrSession  = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   
            SELECT
                L.*,
                T.FCXshAmt_Footer,
                T.FCXshAmtV_Footer,
                T.FCXshAmtNV_Footer,
                T.FCXshGrandTotal_Footer
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTPosCode) AS RowID,
                    A.*,
                    S.FNRptGroupMember,
                    S.FCXshAmt_SubTotal,
                    S.FCXshAmtV_SubTotal,
                    S.FCXshAmtNV_SubTotal,
                    S.FCXshGrandTotal_SubTotal
                FROM TRPTRTTaxHDTmp A WITH(NOLOCK)
                /* Calculate Misures */
                LEFT JOIN (
                    SELECT
                        FTPosCode AS FTPosCode_SUM,
                        COUNT(FTPosCode) AS FNRptGroupMember,
                        SUM(FCXshAmt) AS FCXshAmt_SubTotal,
                        SUM(FCXshAmtV) AS FCXshAmtV_SubTotal,
                        SUM(FCXshAmtNV) AS FCXshAmtNV_SubTotal,
                        SUM(FCXshGrandTotal)AS FCXshGrandTotal_SubTotal
                    FROM TRPTRTTaxHDTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName = '$tComName'
                    AND FTRptCode = '$tRptCode'
                    AND FTUsrSession = '$tUsrSession'
                    GROUP BY FTPosCode
                ) AS S ON A.FTPosCode = S.FTPosCode_SUM
                WHERE A.FTComName = '$tComName'
                AND A.FTRptCode = '$tRptCode'
                AND A.FTUsrSession = '$tUsrSession'
                /* End Calculate Misures */
            ) AS L
            LEFT JOIN (
                " . $tRptJoinFooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTPosCode ASC ";

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
}























