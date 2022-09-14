<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptCollectExpireCard extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 5/11/2019 Saharat(Golf)
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
        
        $tCallStore = "{CALL SP_RPTxCollectExpireCard(?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnComName'         => $paDataFilter['tCompName'],
            'ptRptName'         => $paDataFilter['tRptCode'],
            'ptUsrSession'      => $paDataFilter['tUserSession'],
            'pnFilterType'      => $paDataFilter['tTypeSelect'],

            'ptAgnCode'         => $paDataFilter['tRptAgnCode'],

            'ptBchL' => $tBchCodeSelect,
            'ptBchF' => $paDataFilter['tBchCodeFrom'],
            'ptBchT' => $paDataFilter['tBchCodeTo'],

            'ptDocDateF'        => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'        => $paDataFilter['tDocDateTo'],
            'FNResult'          => 0
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        // echo $this->db->last_query();exit;
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
     * Creator: 5/11/2019 Saharat(GolF)
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
                    ROW_NUMBER() OVER(ORDER BY  CONVERT(VARCHAR(10),rtCrdExpireDate,121) ASC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                    CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121)	AS rtCrdExpireDate,
                    COUNT(TMP.FTCrdCode)                            AS rtCrdCodeExpQty,
                    SUM(ISNULL(TMP.FCCrdValue,0))                   AS rtCrdValue
                    FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode'
                GROUP BY 
                CONVERT(VARCHAR(10),TMP.FDCrdExpireDate,121)

            ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]
        ";    
    
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow      = $oCountRowRpt;
            $nPageAll       = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData    = array(
                'raItems'       => $aDataRpt,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aReturnData = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
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
     * Creator: 10/10/2019 Saharat(GolF)
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere){
        try{
            $tCompName  = $paDataWhere['tCompName'];
            $tRptCode   = $paDataWhere['tRptCode'];
            
            $tSQL       = "SELECT COUNT(A.FTCrdCode) AS FTComName  FROM (

                                SELECT COUNT(FTCrdCode) AS FTCrdCode  
                                FROM TFCTRptCrdTmp WITH (NOLOCK)
                                WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode' AND FTCrdStaActive != '3' 
                                GROUP BY CONVERT(VARCHAR(10),FDCrdExpireDate,121)
                            
                            ) A ";
            $oQuery         = $this->db->query($tSQL);
            $oQuery = $this->db->query($tSQL);
            return $oQuery->result_array()[0]["FTComName"];
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //รายงานยอดสะสมบัตรหมดอายุ[9] : ผลรวม 
    public function FSaMRPTCRDGetDataRptCollectExpireCardSum($paDataWhere){
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        
        $tSQL = "   SELECT 
                        COUNT(FTCrdCode) AS FTCrdCode,
                        SUM(FCCrdValue) AS FCCrdValue 
                    FROM TFCTRptCrdTmp WITH (NOLOCK)   
                    WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }



}
