<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptInventoriesByBch extends CI_Model
{


    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 26/01/2021 Worakorn
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
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // คลังสินค้า
        $tWahCodeSelect = ($paDataFilter['bWahStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tWahCodeSelect']);


        $tAgnCodeSelect  = FCNtAddSingleQuote($paDataFilter['tAgnCodeSelect']);

        $tCallStore = "{CALL SP_RPTxPdtBalByBch(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";


        $aDataStore = array(
            'pnLngID'       => $nLangID,
            'pnComName'     => $tComName,
            'ptRptCode'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'],
            'ptAgnL'        => $tAgnCodeSelect,
            'ptBchL'        => $tBchCodeSelect,
            'ptMerL'        => $tMerCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptWahCodeL'        => $tWahCodeSelect,
            'ptPdtF'        => $paDataFilter['tPdtCodeFrom'],
            'ptPdtT'        => $paDataFilter['tPdtCodeTo'],
            'ptPgpF'        => $paDataFilter['tRptPdtGrpCodeFrom'],
            'ptPgpT'        => $paDataFilter['tRptPdtGrpCodeTo'],
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

    /**
     * Functionality: Get Data Advance Table
     * Parameters:  Function Parameter
     * Creator: 26/01/2021 Worakorn
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
                    SUM(FCStkQty)           AS FCStkQty_Footer,
                    SUM(FCStkAmount)        AS FCStkAmount_Footer
                FROM TRPTPdtBalByBchTmp WITH(NOLOCK)
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
                        '0' AS FCStkAmount_Footer
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
                    T.FCStkAmount_Footer
                FROM (
                    SELECT 
                        ROW_NUMBER() OVER(ORDER BY FTPdtCode) AS RowID ,
                        ROW_NUMBER() OVER(PARTITION BY FTPdtCode ORDER BY FTPdtCode DESC) AS PartIDPdt , 
                        A.*,
                        FCStkAmount_SubTotal,
                        FCStkQty_SubTotal
                    FROM TRPTPdtBalByBchTmp A WITH(NOLOCK)
                    LEFT JOIN (
                        SELECT 
                        FTPdtCode          AS FTPdtCode_SUM,
                        COUNT(FTPdtCode)   AS FNRptGroupMember,
                        SUM(FCStkQty)       AS FCStkQty_SubTotal,
                        SUM(FCStkAmount)       AS FCStkAmount_SubTotal
                        FROM TRPTPdtBalByBchTmp WITH(NOLOCK)
                        WHERE FTComName       = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tUsrSession'
                        GROUP BY FTPdtCode
                    ) AS S ON A.FTPdtCode = S.FTPdtCode_SUM
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
        $tSQL .= " ORDER BY L.FTPdtCode ASC";

        // print_r($tSQL); die();

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
     * Creator: 26/01/2021 Worakorn
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
            FROM TRPTPdtBalByBchTmp TMP WITH(NOLOCK)
            WHERE TMP.FTComName = '$tComName'
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
        $tSQL   = " UPDATE TRPTPdtBalByBchTmp 
                    SET FNRowPartID = B.PartID
                    FROM(
                        SELECT
                            ROW_NUMBER() OVER(PARTITION BY FTPdtCode ORDER BY FTPdtCode DESC) AS PartID , 
                            FTRptRowSeq
                        FROM TRPTPdtBalByBchTmp TMP WITH(NOLOCK)
                        WHERE TMP.FTComName  = '$ptComName' 
                        AND TMP.FTRptCode     = '$ptRptCode'
                        AND TMP.FTUsrSession  = '$ptUsrSession'
                    ) B
                    WHERE 1=1
                    AND TRPTPdtBalByBchTmp.FTRptRowSeq  = B.FTRptRowSeq 
                    AND TRPTPdtBalByBchTmp.FTComName    = '$ptComName' 
                    AND TRPTPdtBalByBchTmp.FTRptCode    = '$ptRptCode'
                    AND TRPTPdtBalByBchTmp.FTUsrSession = '$ptUsrSession'
                ";
        $this->db->query($tSQL);
    }
}
