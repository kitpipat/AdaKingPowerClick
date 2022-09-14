<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptUseCard2 extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 

        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);

        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);


        $tCallStore = "{CALL SP_RPTxUseCard2(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptName'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],
            'pnFilterType'  => $paDataFilter['tTypeSelect'] ,

            'ptBchL'     => $tBchCodeSelect,
            'ptBchF'     => $paDataFilter['tBchCodeFrom'],
            'ptBchT'     => $paDataFilter['tBchCodeTo'],

            'ptMerL'     => $tMerCodeSelect,
            'ptMerF'     => $paDataFilter['tMerCodeFrom'],
            'ptMerT'     => $paDataFilter['tMerCodeTo'],

            'ptShpL'     => $tShpCodeSelect,
            'ptShpF'     => $paDataFilter['tShpCodeFrom'],
            'ptShpT'     => $paDataFilter['tShpCodeTo'],

            'ptPosL'     => $tPosCodeSelect,
            'ptPosF'     => $paDataFilter['tPosCodeFrom'],
            'ptPosT'     => $paDataFilter['tPosCodeTo'],

            'ptCrdF'     => $paDataFilter['tRptCardCode'],
            'ptCrdT'     => $paDataFilter['tRptCardCodeTo'],

            'ptUserIdF'  => $paDataFilter['tRptEmpCode'],
            'ptUserIdT'  => $paDataFilter['tRptEmpCodeTo'],

            'ptCrdActF'  => $paDataFilter['ocmRptStaCardFrom'],
            'ptCrdActT'  => $paDataFilter['ocmRptStaCardTo'],

            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],

            'FNResult'   => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        // echo $this->db->last_query();
        // die();

        if (false !== $oQuery) {
            unset($oQuery);
            return 1;
        } else {
            unset($oQuery);
            return 0;
        }
    }


    /**
     * Functionality: Get Data Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Saharat(GolF)
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere){

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY rtBchName ASC, rtCrdCode ASC , rdTxnDocDate ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    TMP.FTBchCode                                                               AS rtBchCode,
                    CONCAT(TMP.FTBchCode,';',TMP.FTBchName)                                     AS rtBchName,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode)                                     AS rtCrdCode,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCrdName)                   AS rtCrdName,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCtyName)                   AS rtCtyName,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',CASE WHEN(TMP.FTCrdHolderID IS NULL OR TMP.FTCrdHolderID = '') THEN 'N/A' ELSE TMP.FTCrdHolderID END)  AS rtCrdHolderID,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTDptName)                   AS rtDptName,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTCrdStaActive)              AS rtCrdStaActive,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FTTxnDocTypeName)            AS rtTxnDocTypeName,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FCTxnValue)                  AS rcTxnValue,
                    CONCAT(TMP.FTBchCode,';',TMP.FTCrdCode,';',TMP.FCCrdBalance)                AS rcCrdBalance,
                    TMP.FDTxnDocDate                                                            AS rdTxnDocDate,
                    TMP.FNLngID
                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                ORDER BY 
                TMP.FTBchName ASC,
                TMP.FTCrdCode ASC , 
                TMP.FDTxnDocDate ASC
            
            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]


        ";     

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nRow']);
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
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 10/10/2019 Saharat(Golf)
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT FTRptName
            FROM TFCTRptCrdTmp TMP
            WHERE TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
        ";
        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }


}
