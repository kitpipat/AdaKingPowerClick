<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCardDetail extends CI_Model {

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

        $tCallStore = "{CALL SP_RPTxCardDetail(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $paDataFilter['nLangID'],
            'pnComName'     => $paDataFilter['tCompName'],
            'ptRptName'     => $paDataFilter['tRptCode'],
            'ptUsrSession'  => $paDataFilter['tUserSession'],
            'pnFilterType'  => $paDataFilter['tTypeSelect'],

            'ptAgnCode'     => $paDataFilter['tRptAgnCode'],

            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptCrdTypeF'    => $paDataFilter['tRptCardTypeCodeFrom'],
            'ptCrdTypeT'    => $paDataFilter['tRptCardTypeCodeTo'],

            'ptCrdStaActiveF' => $paDataFilter['ocmRptStaCardFrom'],
            'ptCrdStaActiveT' => $paDataFilter['ocmRptStaCardTo'],

            'ptStartDateF'  => $paDataFilter['tRptDateStartFrom'],
            'ptStartDateT'  => $paDataFilter['tRptDateStartTo'],

            'ptExpDateF'    => $paDataFilter['tRptDateExpireFrom'],
            'ptExpDateT'    => $paDataFilter['tRptDateExpireTo'],

            'ptCrdF'        => $paDataFilter['tRptCardCode'],
            'ptCrdT'        => $paDataFilter['tRptCardCodeTo'],

            'FNResult'      => 0
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

        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FTCrdCode ASC,FDTxnDocDate ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    TMP.FTCrdCode,
                    TMP.FTCrdName,
                    TMP.FTCrdHolderID,
                    TMP.FTCtyName,
                    TMP.FCCrdValue,
                    TMP.FTCrdStaType,
                    TMP.FTCrdStaActive,
                    TMP.FDTxnDocDate,
                    CASE WHEN CONVERT(VARCHAR(10),FDCrdExpireDate,121) < CONVERT(VARCHAR(10),GETDATE(),121) THEN 1 ELSE 2 END AS FNCrdStaExpr,
                    CONVERT(VARCHAR(10),TMP.FDCrdStartDate,121) AS FDCrdStartDate,
                    CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121) AS FDCrdExpireDate,
                    ISNULL(TMP.FNLngID,1)  AS FNLngID
                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                ORDER BY
                TMP.FTCrdCode ASC

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

        try{
            $tCompName  = $paDataWhere['tCompName'];
            $tRptCode   = $paDataWhere['tRptCode'];
            
            $tSQL           = "SELECT COUNT(FTComName) AS FTComName FROM TFCTRptCrdTmp WITH (NOLOCK) WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานข้อมูลบัตร[11] : ผลรวม
    public function FSaMRPTCRDGetDataRptCardDetailSum($paDataWhere){
        
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        
        $tSQL = "   SELECT 
                        SUM(FCCrdValue) AS FCCrdValue
                    FROM TFCTRptCrdTmp WITH (NOLOCK)    
                    WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }






}
