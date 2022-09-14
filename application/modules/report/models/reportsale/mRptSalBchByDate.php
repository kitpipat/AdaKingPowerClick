<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptSalBchByDate extends CI_Model
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
        // // ร้านค้า
        // $tShpCodeSelect = ($paData['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tShpCodeSelect']);
        // // ประเภทเครื่องจุดขาย
        // $tPosCodeSelect = ($paData['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paData['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxSalBchByDate001001014(?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paData['nLangID'],
            'pnComName' => $paData['tCompName'],
            'ptRptCode' => $paData['tRptCode'],
            'ptUsrSession' => $paData['tUserSession'],
            'pnFilterType' => $paData['tTypeSelect'],

            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paData['tBchCodeFrom'],
            'ptBchT' => $paData['tBchCodeTo'],

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

    // Functionality: Get Data Page Co
    // Parameters:  Function Parameter
    // Creator: 16/10/2020 Sooksanti(Non)
    // Return : Array Data Page Nation
    // Return Type: Array
    public function FMaMRPTPagination($paDataWhere)
    {
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];
        $tSQL = "   SELECT
                        COUNT(SAL.FTRptCode) AS rnCountPage
                    FROM TRPTSalBchByDateTmp AS SAL WITH(NOLOCK)
                    WHERE 1=1
                    AND SAL.FTComName    = '$tComName'
                    AND SAL.FTRptCode    = '$tRptCode'
                    AND SAL.FTUsrSession = '$tUsrSession'";
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->row_array()['rnCountPage'];
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
            "nNextPage" => $nNextPage,
        );
        unset($oQuery);
        return $aRptMemberDet;
    }

    // Functionality: Get Data Report In Table Temp
    // Parameters:  Function Parameter
    // Creator: 16/10/2020 Sooksanti(Nont)
    // Last Modified : -
    // Return : Array Data report
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere)
    {
        $nPage = $paDataWhere['nPage'];
        // Call Data Pagination
        $aPagination = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart = $aPagination["nRowIDStart"];
        $nRowIDEnd = $aPagination["nRowIDEnd"];
        $nTotalPage = $aPagination["nTotalPage"];
        $tComName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tUsrSession = $paDataWhere['tUsrSessionID'];

        // Check ว่าเป็นหน้าสุดท้ายหรือไม่ ถ้าเป็นหน้าสุดท้ายให้ไป Sum footer ข้อมูลมา
        if ($nPage == $nTotalPage) {
            $tJoinFoooter = "   SELECT
                                        FTUsrSession            AS FTUsrSession_Footer,
                                        SUM(FCXshGrand)         AS FCXshGrand_Footer
                                    FROM TRPTSalBchByDateTmp WITH(NOLOCK)
                                    WHERE 1=1
                                    AND FTComName       = '$tComName'
                                    AND FTRptCode       = '$tRptCode'
                                    AND FTUsrSession    = '$tUsrSession'";
            $tJoinFoooter .= "
                                    GROUP BY FTUsrSession
                                    ) T ON L.FTUsrSession = T.FTUsrSession_Footer";
        } else {
            // ถ้าไม่ใช่ให้ Select 0 เพื่อให้ Join ได้แต่จะไม่มีการ Sum
            $tJoinFoooter = "   SELECT
                                        '$tUsrSession'  AS FTUsrSession_Footer,
                                        0   AS FCXshGrand_Footer,
                                    ) T ON  L.FTUsrSession = T.FTUsrSession_Footer
            ";
        }

        // L = List ข้อมูลทั้งหมด
        // A = SaleDT
        // S = Misures Summary
        $tSQL = "   SELECT
                            L.*,
                            T.*
                        FROM (
                            SELECT
                                ROW_NUMBER() OVER(ORDER BY FTBchCode ASC) AS RowID ,
                                ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode DESC)AS FNRowPartID,
                                A.*,
                                S.FNRptGroupMember,
                                S.FCXshGrand_SubTotal
                            FROM TRPTSalBchByDateTmp A WITH(NOLOCK)
                            /* Calculate Misures */
                            LEFT JOIN (
                                SELECT
                                    FTBchCode               AS FTBchCode_SUM,
                                    COUNT(FTBchCode)        AS FNRptGroupMember,
                                    SUM(FCXshGrand)         AS FCXshGrand_SubTotal
                                FROM TRPTSalBchByDateTmp WITH(NOLOCK)
                                WHERE 1=1
                                AND FTComName       = '$tComName'
                                AND FTRptCode       = '$tRptCode'
                                AND FTUsrSession    = '$tUsrSession'
                ";
        $tSQL .= "
                                GROUP BY FTBchCode
                            ) AS S ON A.FTBchCode = S.FTBchCode_SUM
                            WHERE 1=1
                            AND A.FTComName     = '$tComName'
                            AND A.FTRptCode     = '$tRptCode'
                            AND A.FTUsrSession  = '$tUsrSession'";
        /* End Calculate Misures */
        $tSQL .= "      ) AS L
                        LEFT JOIN (
                            " . $tJoinFoooter . "
        ";

        // WHERE เงื่อนไข Page
        $tSQL .= "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";

        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL .= "   ORDER BY L.FTBchCode ASC";

        // echo $tSQL;
        // exit;

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

}
