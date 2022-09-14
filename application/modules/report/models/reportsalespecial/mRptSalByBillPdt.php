<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalByBillPdt extends CI_Model
{
    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 05/10/2020 Sooksanti
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paData)
    {

        // สาขา
        $tBchCodeSelect = ($paData['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paData['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tShpCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paData['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tPosCodeSelect']);


        $tCallStore = "{ CALL SP_RPTxDailySaleByBillPdt1003013(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paData['nLangID'],
            'pnComName' => $paData['tCompName'],
            'ptRptCode' => $paData['tRptCode'],
            'ptUsrSession' => $paData['tUserSession'],
            'pnFilterType' => $paData['tTypeSelect'],

            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paData['tBchCodeFrom'],
            'ptBchT' => $paData['tBchCodeTo'],

            'ptShpL' => $tShpCodeSelect,
            'ptShpF' => $paData['tShpCodeFrom'],
            'ptShpT' => $paData['tShpCodeTo'],

            'ptPosL' => $tPosCodeSelect,
            'ptPosF' => $paData['tPosCodeFrom'],
            'ptPosT' => $paData['tPosCodeTo'],

            'ptPdtCodeF' => $paData['tRptPdtCodeFrom'],
            'ptPdtCodeT' => $paData['tRptPdtCodeTo'],

            'ptDocDateF' => $paData['tDocDateFrom'],
            'ptDocDateT' => $paData['tDocDateTo'],

            'FNResult' => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery !== false) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }

    // Functionality    : Get Data Report In Table Temp
    // Parameters       : Function Parameter
    // Creator          : 05/10/2020 Sooksanti
    // Last Modified    : -
    // Return           : Array Data report
    // Return Type      : Array
    public function FSaMGetDataReport($paDataWhere)
    {
        $nPage = $paDataWhere['nPage'];
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "
                SELECT
                    FTUsrSession            AS FTUsrSession_Footer,
                    SUM(ISNULL(FCXsdQty,0))	        AS FCXsdQty_Footer,
                    SUM(ISNULL(FCXsdNet,0))	        AS FCXsdNet_Footer,
                    SUM(ISNULL(FCXsdDis,0))         AS FCXsdDis_Footer
                FROM TRPTSalByBillPdtTmp WITH(NOLOCK)
                WHERE 1=1
                AND FTComName       = '$tComName'
                AND FTRptCode       = '$tRptCode'
                AND FTUsrSession    = '$tUsrSession'
                GROUP BY FTUsrSession ) T ON L.FTUsrSession = T.FTUsrSession_Footer";
        } else {
            $tJoinFoooter = "
                SELECT
                    '$tUsrSession' AS FTUsrSession_Footer,
                    0 AS FCXsdNet_Footer,
                    0 AS FCXsdQty_Footer,
                    0 AS FCXsdDis_Footer
                ) T ON L.FTUsrSession = T.FTUsrSession_Footer";
        }

        $tSQL = "
            SELECT
                L.*,
                T.*
            FROM (
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTRptRowSeq) AS RowID ,
                    A.*
                FROM TRPTSalByBillPdtTmp A WITH(NOLOCK)
                WHERE A.FTComName       = '$tComName'
                AND   A.FTRptCode       = '$tRptCode'
                AND   A.FTUsrSession    = '$tUsrSession'
            ) AS L
            LEFT JOIN (
                " . $tJoinFoooter . "
            ";

        $tSQL .= " WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // $tSQL .= " ORDER BY L.FDXshDocDate ";

        // echo $tSQL;
        // die();
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData = $oQuery->result_array();
        } else {
            $aData = null;
        }

        $aErrorList = array(
            "nErrInvalidPage" => "",
        );

        $aResualt = array(
            "aPagination" => $aPagination,
            "aRptData" => $aData,
            "aError" => $aErrorList,
        );
        unset($oQuery);
        unset($aData);
        return $aResualt;
    }

    /**
     * Functionality: Calurate Pagination
     * Parameters:  Function Parameter
     * Creator: 05/10/2020 Sooksanti
     * Return : Pagination
     * Return Type: Array
     */
    private function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tSQL = "
            SELECT
                COUNT(TSB.FTRptCode) AS rnCountPage
            FROM TRPTSalByBillPdtTmp TSB WITH(NOLOCK)
            WHERE 1=1
            AND TSB.FTComName    = '$tComName'
            AND TSB.FTRptCode    = '$tRptCode'
            AND TSB.FTUsrSession = '$tUsrSession'
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
            "nNextPage" => $nNextPage,
            "nPerPage" => $nPerPage,
        );
        unset($oQuery);
        return $aRptMemberDet;
    }
}
