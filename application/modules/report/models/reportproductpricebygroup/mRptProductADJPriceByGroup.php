<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptProductADJPriceByGroup extends CI_Model
{

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreCReport($paDataFilter)
    {   
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        $tCallStore = "{ CALL SP_RPTxPdtAdjPriGrp(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paDataFilter['nLangID'], 
            'pnComName' => $paDataFilter['tCompName'],
            'ptRptCode' => $paDataFilter['tRptCode'],
            'ptUsrSession' => $paDataFilter['tUserSession'],
            'pnFilterType' => $paDataFilter['tTypeSelect'],
            'ptBchL' => $tBchCodeSelect,
            'ptProductCodeF' => $paDataFilter['tRptPdtCodeFrom'],
            'ptProductCodeT' => $paDataFilter['tRptPdtCodeTo'],
            'ptPdtUnitF' => $paDataFilter['tRptPdtUnitCodeFrom'],
            'ptPdtUnitT' => $paDataFilter['tRptPdtUnitCodeTo'],
            'ptEffectivePriceGroupF' => $paDataFilter['tRptEffectivePriceGroupCodeFrom'],
            'ptEffectivePriceGroupT' => $paDataFilter['tRptEffectivePriceGroupCodeTo'],
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'ptEffectiveDateF' => $paDataFilter['tEffectiveDateFrom'],
            'ptEffectiveDateT' => $paDataFilter['tEffectiveDateTo'],
            'FTResult' => 0
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

    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession)
    {
        $tSQL   = " UPDATE TRPTPdtAdjPriGrpTmp 
                    SET 
                        
                        FTPartFTPplCode     = B.PartFTPplCode,
                        FTPartFTPdtCode     = B.PartFTPdtCode,
                        FTPartFTPdtName     = B.PartFTPdtName,
                        FTPartFTPunCode     = B.PartFTPunCode
                    FROM(
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTPplCode ORDER BY FTPplCode ASC) AS PartFTPplCode,
                            ROW_NUMBER() OVER(PARTITION BY FTPdtCode,FTPplCode ORDER BY FTPdtCode ASC) AS PartFTPdtCode,
                            ROW_NUMBER() OVER(PARTITION BY FTPdtName,FTPplCode  ORDER BY FTPdtName ASC) AS PartFTPdtName,
                            ROW_NUMBER() OVER(PARTITION BY FTPunCode,FTPdtName,FTPplCode  ORDER BY FTPunCode ASC) AS PartFTPunCode, 
                            FTRptRowSeq,
                            FTXphDocNo,
                            FTComName,
                            FTRptCode,
                            FTUsrSession
                        FROM TRPTPdtAdjPriGrpTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName  = '$ptComName' 
                        AND TMP.FTRptCode     = '$ptRptCode'
                        AND TMP.FTUsrSession  = '$ptUsrSession'";
        $tSQL  .= "
                        ) AS B
                        WHERE 1=1
                        AND TRPTPdtAdjPriGrpTmp.FTRptRowSeq = B.FTRptRowSeq
                        AND TRPTPdtAdjPriGrpTmp.FTXphDocNo  = B.FTXphDocNo
                        AND TRPTPdtAdjPriGrpTmp.FTComName = '$ptComName' 
                        AND TRPTPdtAdjPriGrpTmp.FTRptCode = '$ptRptCode'
                        AND TRPTPdtAdjPriGrpTmp.FTUsrSession = '$ptUsrSession' ";
        $this->db->query($tSQL);
    }

    public function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTPdtCode) AS rnCountPage
            FROM TRPTPdtAdjPriGrpTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName    = '$tComName'
            AND TMP.FTRptCode    = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
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
     * Functionality: Get Data address
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSaMCMPAddress($paData)
    {

        try {
            $tRefCode = $paData['tAddRef'];
            $nLngID = $paData['nLangID'];
            $tSQL = "
                SELECT
                    ADDL.FTAddRefCode       AS rtAddRefCode,
                    ADDL.FTAddTaxNo         AS rtAddTaxNo,
                    ADDL.FTAddVersion       AS rtAddVersion,
                    ADDL.FTAddV1No          AS rtAddV1No,
                    ADDL.FTAddV1Soi         AS rtAddV1Soi,
                    ADDL.FTAddV1Village     AS rtAddV1Village,
                    ADDL.FTAddV1Road        AS rtAddV1Road,
                    ADDL.FTAddV1SubDist     AS rtAddV1SubDist,
                    SUBDSTL.FTSudName       AS rtAddV1SudName,
                    ADDL.FTAddV1DstCode     AS rtAddV1DstCode,
                    DSTL.FTDstName          AS rtAddV1DstName,
                    ADDL.FTAddV1PvnCode     AS rtAddV1PvnCode,
                    PVNL.FTPvnName          AS rtAddV1PvnName,
                    ADDL.FTAddCountry       AS rtAddV1CntName,
                    ADDL.FTAddV1PostCode    AS rtAddV1PostCode,
                    ADDL.FTAddV2Desc1       AS rtAddV2Desc1,
                    ADDL.FTAddV2Desc2       AS rtAddV2Desc2,
                    ADDL.FTAddWebsite       AS rtAddWebsite,
                    ADDL.FTAddLongitude     AS rtAddLongitude,
                    ADDL.FTAddLatitude      AS rtAddLatitude

                FROM [TCNMAddress_L] ADDL
                LEFT JOIN [TCNMSubDistrict_L] SUBDSTL ON ADDL.FTAddV1SubDist = SUBDSTL.FTSudCode AND SUBDSTL.FNLngID = $nLngID
                LEFT JOIN [TCNMDistrict_L] DSTL ON ADDL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = $nLngID
                LEFT JOIN [TCNMProvince_L] PVNL ON ADDL.FTAddV1PvnCode = PVNL.FTPvnCode AND PVNL.FNLngID = $nLngID
                WHERE 1=1  AND ADDL.FNLngID = $nLngID AND ADDL.FTAddRefCode = '$tRefCode' 
            ";

            $oQuery = $this->db->query($tSQL);

            if ($oQuery->num_rows() > 0) {
                $oList = $oQuery->result();
                $aResult = array(
                    'raItems' => $oList[0],
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                );
            } else {
                //No Data
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'data not found'
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality: Call Stored Procedure
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        $aPagination = $this->FMaMRPTPagination($paDataWhere);

        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd   = $aPagination["nRowIDEnd"];
        $nTotalPage  = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        //Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tUsrSession);

        $tSQL = "   
            SELECT
                L.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY DATA.FTPplCode DESC) AS RowID,
                    DATA.*
                FROM TRPTPdtAdjPriGrpTmp DATA WITH(NOLOCK)
                WHERE 1=1
                AND DATA.FTComName = '$tComName'
                AND DATA.FTRptCode = '$tRptCode'
                AND DATA.FTUsrSession = '$tUsrSession'
            ) L
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd";
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
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 witsarut(Bell)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMCountDataReportAll($paDataWhere)
    {

        $tSessionID = $paDataWhere['tSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
                COUNT(DTTMP.FTRptCode) AS rnCountPage
            FROM TRPTVDPdtTwxTmp_StatDose AS DTTMP WITH(NOLOCK)
            WHERE 1 = 1
            AND FTUsrSession = '$tSessionID'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";

        $oQuery = $this->db->query($tSQL);

        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
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
    public function FSnMCountRowInTemp($paParams)
    {
        $tComName    = $paParams['tCompName'];
        $tRptCode    = $paParams['tRptCode'];
        $tUsrSession = $paParams['tSessionID'];
        $tSQL = "   
            SELECT
                TMP.FTRptCode
            FROM TRPTVDPdtTwxTmp_StatDose TMP WITH(NOLOCK)
            WHERE TMP.FTComName  = '$tComName'
            AND TMP.FTRptCode    = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery = $this->db->query($tSQL);
        return $nRptAllRecord = $oQuery->num_rows();
    }
}
