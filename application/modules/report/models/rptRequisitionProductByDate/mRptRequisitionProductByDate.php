<?php defined('BASEPATH') or exit('No direct script access allowed');

class mRptRequisitionProductByDate extends CI_Model{

    //Functionality : Call Store
    //Parameters    :  Function Parameter
    //Creator       : 28/12/2020 Supawat
    //Last Modified :
    //Return        : Call Store Proce
    //Return Type   : Array
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

        $tCallStore = "{ CALL SP_RPTxDocTwoPDTOut(?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tUserSession'],
            'ptBchL'            => $tBchCodeSelect,
            'ptShpL'            => $tShpCodeSelect,
            'ptPosL'            => $tPosCodeSelect,
            'ptProductCodeF'    => $paDataFilter['tPdtCodeFrom'],
            'ptProductCodeT'    => $paDataFilter['tPdtCodeTo'],
            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
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

    // Functionality    : Get Data Report
    // Parameters       : Function Parameter
    // Creator          : 28/12/2020 Supawat
    // Last Modified    :
    // Return           : Get Data Rpt Temp
    // Return Type      : Array
    public function FSaMGetDataReport($paDataWhere){

        $nPage          = $paDataWhere['nPage'];
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
                        ROW_NUMBER() OVER(ORDER BY Temp.FTBchCode ASC,Temp.FTShpCode ASC,Temp.FTXthDocNo ASC,Temp.FTPdtCode ASC) AS RowID,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode,FTXthDocNo ORDER BY Temp.FTBchCode ASC,Temp.FTShpCode ASC,Temp.FTXthDocNo ASC,Temp.FTPdtCode ASC) AS FNRowPartID,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode,FTShpCode ORDER BY FTBchCode ASC,FTShpCode ASC) AS FNRowShpIDWah,
                        ROW_NUMBER() OVER(PARTITION BY FTBchCode ORDER BY FTBchCode ASC) AS FNRowPartIDBch,
                            Temp.*,
                            S.*
                        FROM TRPTReqPdtByDateTmp Temp WITH(NOLOCK)
                        LEFT JOIN (
                            SELECT
                                FTBchCode          AS FTBchCode_SUM,
                                COUNT(FTBchCode)   AS FNRptGroupBch,
                                SUM (FCXtdQty)     AS SUMTotal
                            FROM TRPTReqPdtByDateTmp WITH(NOLOCK)
                            WHERE 1=1
                            AND FTComName       = '$tComName'
                            AND FTRptCode       = '$tRptCode'
                            AND FTUsrSession    = '$tSession'
                            GROUP BY FTBchCode
                        ) AS S ON Temp.FTBchCode = S.FTBchCode_SUM
                        WHERE 1 = 1
                        AND FTComName       = '$tComName'
                        AND FTRptCode       = '$tRptCode'
                        AND FTUsrSession    = '$tSession'
                    ) L ";

        $tSQL   .=  "   WHERE L.RowID > $nRowIDStart AND L.RowID <= $nRowIDEnd ";
        $tSQL   .=  "   ORDER BY L.FTBchCode,L.FTShpCode ,L.FTXthDocNo,L.FTPdtCode";
                            
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

    public function FMaMRPTPagination($paDataWhere){
        $tComName       = $paDataWhere['tCompName'];
        $tRptCode       = $paDataWhere['tRptCode'];
        $tUsrSession    = $paDataWhere['tUsrSessionID'];
        $tSQL           =   "   SELECT
                                    COUNT(Temp.FTXthDocNo) AS rnCountPage
                                FROM TRPTReqPdtByDateTmp Temp WITH(NOLOCK)
                                WHERE 1=1
                                AND Temp.FTComName    = '$tComName'
                                AND Temp.FTRptCode    = '$tRptCode'
                                AND Temp.FTUsrSession = '$tUsrSession' ";
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


    // Functionality    : Count Data Report All
    // Parameters       : Function Parameter
    // Creator          : 28/12/2020 Supawat
    // Last Modified    : -
    // Return           : Data Report All
    // ReturnType       : Array
    public function FSnMCountDataReportAll($paDataWhere){
        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   
            SELECT 
                Temp.FTRptCode
            FROM TRPTReqPdtByDateTmp AS Temp WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'  ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }
}
