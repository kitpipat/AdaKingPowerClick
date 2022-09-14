<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptUseCard1 extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter = []) {


        $nLngID         = $paDataFilter['nLngID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode'];
        $tUserSession   = $paDataFilter['tUserSessionID'];

        // รหัสเลขหลังบัตร
        $tCardCodeFrom  = empty($paDataFilter['tCardCodeFrom']) ? '' : $paDataFilter['tCardCodeFrom']; 
        $tCardCodeTo    = empty($paDataFilter['tCardCodeTo']) ? '' : $paDataFilter['tCardCodeTo'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom   = empty($paDataFilter['tDocDateFrom']) ? '' : $paDataFilter['tDocDateFrom'];
        $tDocDateTo     = empty($paDataFilter['tDocDateTo']) ? '' : $paDataFilter['tDocDateTo'];

        // สาขา
        $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
        
        // ร้านค้า
        $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);

        // กลุ่มธุรกิจ
        $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);

        // ประเภทเครื่องจุดขาย
        $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        $tCallStore = "{CALL SP_RPTxUseCard1(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLngID,
            'pnComName'     => $tComName,
            'ptRptName'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => $paDataFilter['tTypeSelect'] ,

            'ptBchL'        => $tBchCodeSelect,
            'ptBchF'        => $paDataFilter['tBchCodeFrom'],
            'ptBchT'        => $paDataFilter['tBchCodeTo'],

            'ptMerL'        => $tMerCodeSelect,
            'ptMerF'        => $paDataFilter['tMerCodeFrom'],
            'ptMerT'        => $paDataFilter['tMerCodeTo'],

            'ptShpL'        => $tShpCodeSelect,
            'ptShpF'        => $paDataFilter['tShpCodeFrom'],
            'ptShpT'        => $paDataFilter['tShpCodeTo'],

            'ptPosL'        => $tPosCodeSelect,
            'ptPosF'        => $paDataFilter['tPosCodeFrom'],
            'ptPosT'        => $paDataFilter['tPosCodeTo'],

            'ptCrdF'        => $tCardCodeFrom,
            'ptCrdT'        => $tCardCodeTo,
            'ptDocDateF'    => $tDocDateFrom,
            'ptDocDateT'    => $tDocDateTo,

            'FNResult'   => 0
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
     * Creator: 01/11/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere = [], $paDataFilter = []) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode = $paDataWhere['tUserCode'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSessionID'];

        $tSQL = "   
            SELECT
                RPT.* 
            FROM( 
                SELECT 
                    ROW_NUMBER() OVER(ORDER BY TMP.FTCrdCode ASC, TMP.FTCrdName ASC, TMP.FDTxnDocDate ASC) AS rtRowID,
                    TMP.FTTxndocType, 
                    TMP.FTCrdCode AS rtCrdCode, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTCrdName) AS rtCrdName, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTShpCode) AS rtShpCode, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTShpName) AS rtShpName, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTTxnPosCode) AS rtTxnPosCode, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTPosType) AS rtTxnPosType, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocRefNo) AS rtTxnDocNoRef, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocNoRef) AS rtTxnDocNo, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTTxnDocTypeName) AS rtTxnDocTypeName, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FTDocCreateBy) AS rtTxnDocCreateBy, 
                    TMP.FDTxnDocDate AS rtTxnDocDate, 
                    CONCAT(TMP.FTCrdCode,';',TMP.FCCrdBalance) AS rtCrdBalance,
                    TMP.FNLngID, 
                        CASE
                            WHEN TMP.FTTxnDocType = 1 THEN TMP.FCTxnValue 
                            WHEN TMP.FTTxnDocType = 2 THEN (TMP.FCTxnValue * -1) 
                            WHEN TMP.FTTxnDocType = 3 THEN (TMP.FCTxnValue * -1) 
                            WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue 
                            WHEN TMP.FTTxnDocType = 5 THEN (TMP.FCTxnValue * -1) 
                            WHEN TMP.FTTxnDocType = 8 THEN (TMP.FCTxnValue * -1) 
                            WHEN TMP.FTTxnDocType = 9 THEN TMP.FCTxnValue 
                            WHEN TMP.FTTxnDocType = 10 THEN (TMP.FCTxnValue * -1) 
                        ELSE '0' 
                    END AS rtTxnValue 
                FROM TFCTRptCrdTmp TMP WITH (NOLOCK)
                WHERE 1=1 AND TMP.FTComName = '$tCompName' AND TMP.FTRptName = '$tRptCode' 	
            ) AS RPT 
        ";
        $tSQL .= " WHERE RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
        $tSQL .= " ORDER BY RPT.rtCrdCode ASC, RPT.rtCrdName ASC, RPT.rtTxnDocDate ASC";
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
     * Creator: 01/11/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere = []) {

        $tSessionID = $paDataWhere['tUserSessionID'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT 
                FTComName 
            FROM TFCTRptCrdTmp WITH (NOLOCK) 
            WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'
        ";

        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    /**
     * Functionality: Summary Data Report รายงานข้อมูลการใช้บัตร/1
     * Parameters:  Function Parameter
     * Creator: 01/11/2019 Piya
     * Last Modified : -
     * Return : Sum Query
     * Return Type: Array
     */
    public function FSaMRPTCRDGetDataRptUseCard1Sum($paFilterReport = []){
        
		$tCompName = $paFilterReport['tCompName'];
        $tRptCode = $paFilterReport['tRptCode'];

        $tSQL = "   
            SELECT 
                SUM( 
                    CASE 
                        WHEN FTTxnDocType = 1 THEN FCTxnValue 
                        WHEN FTTxnDocType = 2 THEN (FCTxnValue * -1) 
                        WHEN FTTxnDocType = 3 THEN (FCTxnValue * -1) 
                        WHEN FTTxnDocType = 4 THEN FCTxnValue 
                        WHEN FTTxnDocType = 5 THEN (FCTxnValue * -1) 
                        WHEN FTTxnDocType = 8 THEN (FCTxnValue * -1) 
                        WHEN FTTxnDocType = 9 THEN FCTxnValue 
                        WHEN FTTxnDocType = 10 THEN (FCTxnValue * -1) 
                        ELSE '0' 
                    END
                ) AS FCTxnValueSum
            FROM TFCTRptCrdTmp WITH (NOLOCK)   
            WHERE FTComName = '$tCompName' AND FTRptName = '$tRptCode'";
       
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
}
