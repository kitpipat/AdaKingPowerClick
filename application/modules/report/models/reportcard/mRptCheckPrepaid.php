<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCheckPrepaid extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 1/11/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
        $tCallStore = "{CALL SP_RPTxCheckPrepaid(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptName'         => $paDataFilter['tRptCode'],
            'ptCrdF'            => $paDataFilter['tRptCardCode'],
            'ptCrdT'            => $paDataFilter['tRptCardCodeTo'],
            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
            'FNResult'          => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
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
    public function FSaMGetDataReport($paDataWhere, $paDataFilter) {

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
                    ROW_NUMBER() OVER(ORDER BY FTTxnPosCode ASC,FDTxnDocDate ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    TMP.FTTxnPosCode                    AS FTTxnPosCode,
                    TMP.FDTxnDocDate                    AS FDTxnDocDate,
                    TMP.FTTxnDocType                    AS FTTxnDocType,
                    TMP.FTCrdCode                       AS FTCrdCode,
                    TMP.FTCrdName                       AS FTCrdName,
                    TMP.FTUsrName                       AS FTUsrName,
                    TMP.FCTxnValue                      AS FCTxnValue,
                    TMP.FTCdtRmk                        AS FTCdtRmk,
                    TMP.FNLngID
                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                ORDER BY
                TMP.FTTxnPosCode ASC,
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
     * Creator: 1/11/2019 Saharat(GolF)
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK)
         WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
        $oQuery         = $this->db->query($tSQL);
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array()[0]["FTComName"];
    }

    //รายงานตรวจสอบการเติมเงิน[12] : ผลรวม
    public function FSaMRPTCRDGetDataRptCheckPrepaidSum($paDataWhere){

        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = "   SELECT 
                        SUM(FCTxnCrdValue) AS FCTxnCrdValue,
                        SUM(FCTxnValue) AS FCTxnValue,
                        SUM(FCTxnValAftTrans) AS FCTxnValAftTrans
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }


}
