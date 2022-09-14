<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptTopUp extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Saharat(Golf)
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
        $tCallStore = "{CALL SP_RPTxTopUp(?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $paDataFilter['nLangID'],
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptName'         => $paDataFilter['tRptCode'],
            'ptCrdF'            => $paDataFilter['tRptCardCode'],
            'ptCrdT'            => $paDataFilter['tRptCardCodeTo'],
            'ptUserIdF'         => $paDataFilter['tRptEmpCode'],
            'ptUserIdT'         => $paDataFilter['tRptEmpCodeTo'],
            'ptCrdStaActiveF'   => $paDataFilter['ocmRptStaCardFrom'],
            'ptCrdStaActiveT'   => $paDataFilter['ocmRptStaCardTo'],
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
                    TMP.FTTxnPosCode,
                    TMP.FDTxnDocDate,
                    TMP.FTTxnDocType,
                    TMP.FTTxnDocNoRef,
                    TMP.FTCrdCode,
                    TMP.FDCrdExpireDate,
                    TMP.FCTxnValue,
                    TMP.FTCdtRmk,
                    TMP.FTCrdName,
                    TMP.FTCrdStaActive,
                    TMP.FTUsrName,
                    TMP.FCTxnCrdValue,
                    TMP.FCTxnValAftTrans,
                    TMP.FNLngID,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCrdHolderID) AS FTCrdHolderID,
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCtyName) AS FTCtyName, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTDptName) AS FTDptName
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


    //รายงานการเติมเงิน[14] : count
    public function FSaMRPTCRDGetDataRptTopUpCount($paFilterReport){
        try{
            $tComName     = $paFilterReport['tCompName'];
            $tRptName     = $paFilterReport['tRptName'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tComName' AND FTRptName = '$tRptName'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานการเติมเงิน[14] : ผลรวม
    public function FSaMRPTCRDGetDataRptTopUpSum($paFilterReport){
		$tComName = $paFilterReport['tCompName'];
        $tRptCode = $paFilterReport['tRptCode'];
        
        $tSQL = "   SELECT 
                        SUM(FCTxnCrdValue)    AS FCTxnCrdValue,
                        SUM(FCTxnValue)       AS FCTxnValue,
                        SUM(FCTxnValAftTrans) AS FCTxnValAftTrans
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tComName' AND FTRptName = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 10/10/2019 Saharat(GolF)
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {
    
        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT  
                TMP.FTRptName
            FROM TFCTRptCrdTmp TMP
            WHERE 1=1
            AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
    
        unset($oQuery);
        return $nCountData;
    }


}
