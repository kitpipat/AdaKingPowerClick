<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptCompareSaleByPdtType extends CI_Model
{

    /**
     * Functionality: Call Store
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Piya
     * Last Modified : -
     * Return : Status Return Call Stored Procedure
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter)
    {

        $nLangID        = $paDataFilter['nLangID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        $tChkRptGroup  = $paDataFilter['tGroupReport'];

        switch ($tChkRptGroup) {
            case '01': //สาขา
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '02': // ตัวแทนขาย
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '03': // ร้านค้า
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '04': // สินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtCodeTo'];
                break;
            case '05': // ประเภทสินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtTypeCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtTypeCodeTo'];
                break;
            case '06': // กลุ่มสินค้า
                $tPdtCodeFrom = $paDataFilter['tPdtGrpCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtGrpCodeTo'];
                break;
            case '07':  // ยี่ห้อ
                $tPdtCodeFrom = $paDataFilter['tPdtBrandCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtBrandCodeTo'];
                break;
            case '08':   // รุ่น
                $tPdtCodeFrom = $paDataFilter['tPdtModelCodeFrom'];
                $tPdtCodeTo   = $paDataFilter['tPdtModelCodeTo'];
                break;
        }

        $tCallStore     =   "{CALL SP_RPTxPSCompareYTD(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        $aDataStore     =  array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptRptGrp'      => $paDataFilter['tGroupReport'],
            'ptAgnL'        => $paDataFilter['tAgnCodeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptMerL'        => $tMerCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptPosCodeL'    => $tPosCodeSelect,
            'ptCodeF'       => $tPdtCodeFrom,
            'ptCodeT'       => $tPdtCodeTo,
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'FTResult' => 0
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


    public function FSnMExecStoreReport2($paDataFilter, $paDataReport)
    {

        $tComName       = $paDataReport['tCompName'];
        $tRptCode       = $paDataReport['tRptCode'];
        $tUserSession   = $paDataReport['tUsrSessionID'];

        $tSesUsrAgnCode =    $this->session->userdata("tSesUsrAgnCode");


        $tCallStore     =   "{CALL SP_RPTxPSCompareYTD(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        if ($paDataFilter['tFilterAgnCode'] == '' || $paDataFilter['tFilterAgnCode'] ==  "undefined") {
            $tFilterAgnCode =     $tSesUsrAgnCode;
        } else {
            $tFilterAgnCode =  $paDataFilter['tFilterAgnCode'];
        }

        $tChkRptGroup  = $paDataFilter['tFilterGroupReport'];
        $tPdtCodeFrom = '';
        $tPdtCodeTo   = '';

        switch ($tChkRptGroup) {
            case '01': //สาขา
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '02': // ตัวแทนขาย
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '03': // ร้านค้า
                $tPdtCodeFrom = '';
                $tPdtCodeTo   = '';
                break;
            case '04': // สินค้า
                $tPdtCodeFrom = $paDataFilter['tFilterProductFTFromCode'];
                $tPdtCodeTo   = $paDataFilter['tFilterProductFTToCode'];
                break;
            case '05': // ประเภทสินค้า
                $tPdtCodeFrom = $paDataFilter['tFilterTypeProductFTFromCode'];
                $tPdtCodeTo   = $paDataFilter['tFilterTypeProductFTToCode'];
                break;
            case '06': // กลุ่มสินค้า
                $tPdtCodeFrom = $paDataFilter['tFilterGroupProductFTFromCode'];
                $tPdtCodeTo   = $paDataFilter['tFilterGroupProductFTToCode'];
                break;
            case '07':  // ยี่ห้อ
                $tPdtCodeFrom = $paDataFilter['tFilterBrandFTFromCode'];
                $tPdtCodeTo   = $paDataFilter['tFilterBrandFTToCode'];
                break;
            case '08':   // รุ่น
                $tPdtCodeFrom = $paDataFilter['tFilterModelFTFromCode'];
                $tPdtCodeTo   = $paDataFilter['tFilterModelFTToCode'];
                break;
        }




        $aDataStore     =  array(
            'pnLngID'       => $paDataFilter['nLngID'],


            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,


            'pnFilterType'  => 2,
            'ptRptGrp'      => !empty($paDataFilter['tFilterGroupReport']) ? $paDataFilter['tFilterGroupReport'] : '01',
            // 'ptAgnL'        => $paDataFilter['tFilterAgnCode'],
            'ptAgnL'        =>   $tFilterAgnCode,
            'ptBchL'        => $paDataFilter['tFilterBchCode'],
            'ptMerL'        => $paDataFilter['tFilterMerCode'],
            'ptShpL'        => $paDataFilter['tFilterShpCode'],
            'ptPosCodeL'    => $paDataFilter['tFilterPosCode'],
            'ptCodeF'       => $tPdtCodeFrom,
            'ptCodeT'     =>  $tPdtCodeTo,
            'ptDocDateF'    => $paDataFilter['tDateDataForm'],
            'FTResult' => 0
        );

        // print_r($aDataStore); die();




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
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage = $paDataWhere['nPage'];

        // Call Data Pagination
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);


        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($paDataWhere);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tRptJoinFooter = "
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM(
                        ISNULL(FCRptQtyYTD_LY, 0)
                    ) AS FCRptQtyYTD_LY_Footer,
                    SUM(
                        ISNULL(FCRptQtyYTD, 0)
                    ) AS FCRptQtyYTD_Footer,
                    SUM(
                        ISNULL(FCRptQtyCmp, 0)
                    ) AS FCRptQtyCmp_Footer,
                    SUM(
                        ISNULL(FCRptQtyPercenCmp, 0)
                    ) AS FCRptQtyPercenCmp_Footer,

                    SUM(
                        ISNULL(FCRptAmtYTD_LY, 0)
                    ) AS FCRptAmtYTD_LY_Footer,
                    SUM(
                        ISNULL(FCRptAmtYTD, 0)
                    ) AS FCRptAmtYTD_Footer,
                    SUM(
                        ISNULL(FCRptAmtCmp, 0)
                    ) AS FCRptAmtCmp_Footer,
                    SUM(
                        ISNULL(FCRptAmtPercenCmp, 0)
                    ) AS FCRptAmtPercenCmp_Footer
                FROM TRPTPSCompareYTDTmp WITH(NOLOCK)
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
                    0 AS FCRptQtyYTD_LY_Footer,
                    0 AS FCRptQtyYTD_Footer,
                    0 AS FCRptQtyCmp_Footer,
                    0 AS FCRptQtyPercenCmp_Footer,
                    0 AS FCRptAmtYTD_LY_Footer,
                    0 AS FCRptAmtYTD_Footer,
                    0 AS FCRptAmtCmp_Footer,
                    0 AS FCRptAmtPercenCmp_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   = " SELECT
                        L.*,
                        T.FCRptQtyYTD_LY_Footer,
                        T.FCRptQtyYTD_Footer,
                        T.FCRptQtyCmp_Footer,
                        T.FCRptQtyPercenCmp_Footer,
                        T.FCRptAmtYTD_LY_Footer,
                        T.FCRptAmtYTD_Footer,
                        T.FCRptAmtCmp_Footer,
                        T.FCRptAmtPercenCmp_Footer
                    FROM (
                        SELECT
                        ROW_NUMBER() OVER(ORDER BY FTRptGrpCode ASC) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCRptQtyYTD_LY_SubTotal,
                        S.FCRptQtyYTD_SubTotal,
                        S.FCRptQtyCmp_SubTotal,
                        S.FCRptQtyPercenCmp_SubTotal,
                        S.FCRptAmtYTD_LY_SubTotal,
                        S.FCRptAmtYTD_SubTotal,
                        S.FCRptAmtCmp_SubTotal,
                        S.FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareYTDTmp A WITH(NOLOCK)
                    /* Calculate Misures */
                    LEFT JOIN (
                        SELECT
                            FTRptGrpCode            AS FTRptGrpCode_SUM,
                            COUNT(FTRptGrpCode)     AS FNRptGroupMember,
                            SUM(FCRptQtyYTD_LY)     AS FCRptQtyYTD_LY_SubTotal,
                            SUM(FCRptQtyYTD)        AS FCRptQtyYTD_SubTotal,
                            SUM(FCRptQtyCmp)        AS FCRptQtyCmp_SubTotal,
                            SUM(FCRptQtyPercenCmp)  AS FCRptQtyPercenCmp_SubTotal,
                            SUM(FCRptAmtYTD_LY)     AS FCRptAmtYTD_LY_SubTotal,
                            SUM(FCRptAmtYTD)        AS FCRptAmtYTD_SubTotal,
                            SUM(FCRptAmtCmp)        AS FCRptAmtCmp_SubTotal,
                            SUM(FCRptAmtPercenCmp)  AS FCRptAmtPercenCmp_SubTotal
                    FROM TRPTPSCompareYTDTmp WITH(NOLOCK)
                    WHERE 1=1
                    AND FTComName       = '$tComName'
                    AND FTRptCode       = '$tRptCode'
                    AND FTUsrSession    = '$tUsrSession'
                    GROUP BY FTRptGrpCode
                    ) AS S ON A.FTRptGrpCode  = S.FTRptGrpCode_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
                /* End Calculate Misures */
                ) AS L
                    LEFT JOIN (
                        " . $tRptJoinFooter . "
                ";

        // WHERE เงื่อนไข Page
        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTRptGrpCode";

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
     * Functionality: Set PriorityGroup
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : -
     * Return Type: -
     */
    public function FMxMRPTSetPriorityGroup($paDataWhere)
    {
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];

        $tSQL = "
            UPDATE TRPTPSCompareYTDTmp SET
                FNRowPartID = B.PartID
            FROM(
                SELECT
                    ROW_NUMBER() OVER(PARTITION BY FTRptGrpCode ORDER BY FTRptGrpCode ASC) AS PartID,
                    FTRptRowSeq
                FROM TRPTPSCompareYTDTmp TMP WITH(NOLOCK)
                WHERE TMP.FTComName = '$tComName'
                AND TMP.FTRptCode   = '$tRptCode'
                AND TMP.FTUsrSession = '$tUsrSession'";

        $tSQL .= "
                ) AS B
                WHERE TRPTPSCompareYTDTmp.FTRptRowSeq = B.FTRptRowSeq
                AND TRPTPSCompareYTDTmp.FTComName = '$tComName'
                AND TRPTPSCompareYTDTmp.FTRptCode = '$tRptCode'
                AND TRPTPSCompareYTDTmp.FTUsrSession = '$tUsrSession'";

        $this->db->query($tSQL);
    }


    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere)
    {

        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];


        $tSQL = "
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTPSCompareYTDTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'";

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
            $nTotalPage = (int)$nTotalPage;
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
            "nNextPage" => $nNextPage,
            "nPerPage" => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }




    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 18/06/2020 Piya
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport2($paDataWhere)
    {
// print_r($paDataWhere['tCode']);
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tWhere = '';

        if (!empty($paDataWhere['tCode'])) {
            $tWhere = " AND FTRptGrpCode " . $paDataWhere['tCode'] . " ";
        }

        $tSQL = "
            SELECT TOP 10 FTRptGrp,FTRptGrpName,FCRptQtyYTD_LY,FCRptQtyYTD,FCRptAmtYTD_LY,FCRptAmtYTD
            FROM TRPTPSCompareYTDTmp WITH(NOLOCK)
            WHERE 1=1
            AND FTComName = '$tComName'
            AND FTRptCode = '$tRptCode'
            AND FTUsrSession = '$tUsrSession'
            $tWhere
            ORDER BY FTRptGrpCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = [];
        }


        $aResualt = array(
            "aRptData" => $aData,
        );

        return $aResualt;
    }
}
