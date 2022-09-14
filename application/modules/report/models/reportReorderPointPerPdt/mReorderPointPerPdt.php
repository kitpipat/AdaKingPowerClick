<?php defined('BASEPATH') or exit('No direct script access allowed');

class mReorderPointPerPdt extends CI_Model
{


    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 19/11/2020 Witsarut
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter)
    {

        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

        // สาขา
        $tBchCodeSelect = FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPdtPointPdt(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";

        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptBchL'        => $tBchCodeSelect,
            'ptMerL'        => $tMerCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptWahF'        => $paDataFilter['tWahCodeFrom'],
            'ptWahT'        => $paDataFilter['tWahCodeTo'],
            'ptPgpF'        => $paDataFilter['tPdtGrpCodeFrom'],
            'ptPgpT'        => $paDataFilter['tPdtGrpCodeTo'],
            'ptPdtF'        => $paDataFilter['tPdtCodeFrom'],
            'ptPdtT'        => $paDataFilter['tPdtCodeTo'],

            'FTResult' => 0

            // 'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            // 'ptBchT'        => $paDataFilter['tBchCodeTo'],
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
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 23/07/2019 Witsarut
     * Last Modified : -
     * Return : status
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        // Call Data Pagination 
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $aPagination = $this->FMaMRPTPagination($paDataWhere);
            $nRowIDStart = $aPagination["nRowIDStart"];
            $nRowIDEnd   = $aPagination["nRowIDEnd"];
            $nTotalPage  = $aPagination["nTotalPage"];
        }else{
            $aPagination  = array();
            $nTotalPage   = 1;
        }

        $tComName    = $paDataWhere['tCompName'];
        $tRptCode    = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Set Priority
        $this->FMxMRPTSetPriorityGroup($tComName, $tRptCode, $tUsrSession);

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา 
        if ($nPage == $nTotalPage) {
            $tRptJoinFooter = " 
                SELECT
                    FTUsrSession AS FTUsrSession_Footer,
                    SUM( 
                        ISNULL(FCStkQty, 0)
                    ) AS FCStkQty_Footer, 
                    SUM(
                        ISNULL(FCSpwQtyMin, 0)
                    ) AS FCSpwQtyMin_Footer,
                    SUM( 
                        ISNULL(FCQtySuggest, 0)
                    ) AS FCQtySuggest_Footer
                FROM TRPTPdtPointPdtTmp WITH(NOLOCK)
                WHERE FTComName = '$tComName'
                AND FTRptCode = '$tRptCode'
                AND FTUsrSession = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer
            ";
        } else {
            $tRptJoinFooter = " 
                SELECT
                        '$tUsrSession' AS FTUsrSession_Footer,
                        '0' AS FCStkQty_Footer,
                        '0' AS FCSpwQtyMin_Footer,
                        '0' AS FCQtySuggest_Footer
                ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL   =   "   
                SELECT
                    L.*,
                    T.FCStkQty_Footer,
                    T.FCSpwQtyMin_Footer,
                    T.FCQtySuggest_Footer
                FROM (
                    SELECT 
                        ROW_NUMBER() OVER(ORDER BY FTWahCode) AS RowID ,
                        A.*,
                        S.FNRptGroupMember,
                        S.FCStkQty_SubTotal,
                        S.FCSpwQtyMin_SubTotal,
                        S.FCQtySuggest_SubTotal
                    FROM TRPTPdtPointPdtTmp A WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT 
                            FTWahCode          AS FTWahCode_SUM,
                            COUNT(FTWahCode)   AS FNRptGroupMember,
                            SUM(FCStkQty)      AS FCStkQty_SubTotal,
                            SUM(FCSpwQtyMin)   AS FCSpwQtyMin_SubTotal,
                            SUM(FCQtySuggest)  AS FCQtySuggest_SubTotal
                        FROM TRPTPdtPointPdtTmp WITH(NOLOCK)
                        WHERE FTComName     = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tUsrSession'
                        GROUP BY FTWahCode
                    ) AS S ON A.FTWahCode = S.FTWahCode_SUM
                    WHERE A.FTComName       = '$tComName'
                    AND   A.FTRptCode       = '$tRptCode'
                    AND   A.FTUsrSession    = '$tUsrSession'
            ) AS L 
            LEFT JOIN (
            " . $tRptJoinFooter . "
        ";

        // WHERE เงื่อนไข Page
        if( $paDataWhere['nPerPage'] <> 999999999999 ){
            $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        }

        //สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= " ORDER BY L.FTBchCode ";

        // print_r($tSQL);

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
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 19/11/2020 Witsarut
     * Last Modified : -
     * Return : Pagination
     * Return Type: Array
     */
    public function FMaMRPTPagination($paDataWhere)
    {

        $tComName     = $paDataWhere['tCompName'];
        $tRptCode     = $paDataWhere['tRptCode'];
        $tUsrSession  = $paDataWhere['tUsrSessionID'];

        $tSQL = "   
            SELECT
                COUNT(TMP.FTRptCode) AS rnCountPage
            FROM TRPTPdtPointPdtTmp TMP WITH(NOLOCK)
            WHERE 1=1
            AND TMP.FTComName = '$tComName'
            AND TMP.FTRptCode = '$tRptCode'
            AND TMP.FTUsrSession = '$tUsrSession'
        ";

        $oQuery =  $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];

        $nPage      = $paDataWhere['nPage'];
        $nPerPage   = $paDataWhere['nPerPage'];

        $nPrevPage      = $nPage - 1;
        $nNextPage      = $nPage + 1;
        $nRowIDStart    = (($nPerPage * $nPage) - $nPerPage); //RowId Start

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
            "nTotalRecord"  => $nRptAllRecord,
            "nTotalPage"    => $nTotalPage,
            "nDisplayPage"  => $paDataWhere['nPage'],
            "nRowIDStart"   => $nRowIDStart,
            "nRowIDEnd"     => $nRowIDEnd,
            "nPrevPage"     => $nPrevPage,
            "nNextPage"     => $nNextPage,
            "nPerPage"      => $nPerPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }


    public function FMxMRPTSetPriorityGroup($ptComName, $ptRptCode, $ptUsrSession)
    {
        $tSQL   = " UPDATE TRPTPdtPointPdtTmp 
                    SET FNRowPartID = B.PartID
                    FROM(
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTWahCode ORDER BY FTWahCode DESC) AS PartID , 
                            FTRptRowSeq
                        FROM TRPTPdtPointPdtTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName  = '$ptComName' 
                        AND TMP.FTRptCode     = '$ptRptCode'
                        AND TMP.FTUsrSession  = '$ptUsrSession'
                    ) B
                    WHERE 1=1
                    AND TRPTPdtPointPdtTmp.FTRptRowSeq  = B.FTRptRowSeq 
                    AND TRPTPdtPointPdtTmp.FTComName    = '$ptComName' 
                    AND TRPTPdtPointPdtTmp.FTRptCode    = '$ptRptCode'
                    AND TRPTPdtPointPdtTmp.FTUsrSession = '$ptUsrSession'
                ";

                // print_r($tSQL);
        $this->db->query($tSQL);
    }
}
