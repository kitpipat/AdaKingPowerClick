<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptTransferVendingOut extends CI_Model
{


    //Functionality: Delete Temp Report
    //Parameters:  Function Parameter
    //Creator: 28/12/2020 Sooksanti(Nont)
    //Last Modified :
    //Return : Call Store Proce
    //Return Type: Array
    public function FSnMExecStoreReport($paDataFilter)
    {
        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']);
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{ CALL SP_RPTxDocTwxOutVD(?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tUserSession'],


            'ptBchL'            => $tBchCodeSelect,

            'ptShpL'            => $tShpCodeSelect,

            'ptPosL'            => $tPosCodeSelect,

            //สินค้า
            'ptProductCodeF'    => $paDataFilter['tPdtCodeFrom'],
            'ptProductCodeT'    => $paDataFilter['tPdtCodeTo'],

            //วันที่
            'ptDocDateF'    => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'    => $paDataFilter['tDocDateTo'],

            'FNResult'          => 0,
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

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 28/12/2020 Sooksanti(Nont)
    // Last Modified :
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere)
    {

        $nPage          = $paDataWhere['nPage'];
        // Call Data Pagination 
        $aPagination    = $this->FMaMRPTPagination($paDataWhere);
        $nRowIDStart    = $aPagination["nRowIDStart"];
        $nRowIDEnd      = $aPagination["nRowIDEnd"];
        $nTotalPage     = $aPagination["nTotalPage"];
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tSession       = $paDataWhere['tUsrSessionID'];

        $tSQL   = " SELECT
                        L.*
                    FROM (
                        SELECT DISTINCT
                        ROW_NUMBER() OVER(ORDER BY TAKEOUT.FTBchCode ASC,TAKEOUT.FTShpCode ASC,TAKEOUT.FTXthDocNo ASC,TAKEOUT.FTPdtCode ASC) AS RowID,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTXthDocNo ORDER BY TAKEOUT.FTBchCode ASC,TAKEOUT.FTShpCode ASC,TAKEOUT.FTXthDocNo ASC,TAKEOUT.FTPdtCode ASC) AS FNRowPartID,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode ORDER BY FTBchCode ASC,FTShpCode ASC) AS FNRowShpIDWah,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode ASC) AS FNRowPartIDBch,
                            TAKEOUT.*
                        FROM TRPTTakeoutPdtTmp TAKEOUT WITH(NOLOCK)
                        WHERE 1 = 1
                        AND FTComName       = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tSession'
                    ) L
                    
        ";
        // WHERE เงื่อนไข Page
        $tSQL   .=  "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        // สั่ง Order by ตามข้อมูลหลัก
        $tSQL   .=  "   ORDER BY L.FTBchCode,L.FTShpCode ,L.FTXthDocNo,L.FTPdtCode";

        // echo $tSQL;
        // exit();
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aData  = $oQuery->result_array();
        } else {
            $aData  = NULL;
        }
        $aErrorList =   array(
            "nErrInvalidPage"   =>  ""
        );
        $aResualt = array(
            "aPagination"   =>  $aPagination,
            "aRptData"      =>  $aData,
            "aError"        =>  $aErrorList
        );
        unset($oQuery);
        unset($aData);
        return  $aResualt;
    }

    public function FMaMRPTPagination($paDataWhere)
    {
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           =   "   SELECT
                                    COUNT(STK.FTShpCode) AS rnCountPage
                                FROM TRPTTakeoutPdtTmp STK WITH(NOLOCK)
                                WHERE 1=1
                                AND STK.FTComName    = '$tComName'
                                AND STK.FTRptCode    = '$tRptCode'
                                AND STK.FTUsrSession = '$tUsrSession'
                                
                            ";
        $oQuery         = $this->db->query($tSQL);
        $nRptAllRecord  = $oQuery->row_array()['rnCountPage'];
        $nPage          = $paDataWhere['nPage'];
        $nPerPage       = $paDataWhere['nPerPage'];
        $nPrevPage      = $nPage - 1;
        $nNextPage      = $nPage + 1;
        $nRowIDStart    = (($nPerPage * $nPage) - $nPerPage); //RowId Start
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
            "nTotalRecord"  =>  $nRptAllRecord,
            "nTotalPage"    =>  $nTotalPage,
            "nDisplayPage"  =>  $paDataWhere['nPage'],
            "nRowIDStart"   =>  $nRowIDStart,
            "nRowIDEnd"     =>  $nRowIDEnd,
            "nPrevPage"     =>  $nPrevPage,
            "nNextPage"     =>  $nNextPage
        );
        unset($oQuery);
        return $aRptMemberDet;
    }


    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 28/12/2020 Sooksanti(Nont)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSnMCountDataReportAll($paDataWhere)
    {
        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT 
            TAKEOUT.FTRptCode
            FROM TRPTTakeoutPdtTmp AS TAKEOUT WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
}
