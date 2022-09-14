<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptSaleShopByDate extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        $nLngID         = $paDataFilter['nLngID'];
        $tComName       = $paDataFilter['tCompName'];
        $tRptCode       = $paDataFilter['tRptCode']; 
        $tUserSession   = $paDataFilter['tUserSession'];

        //AGN
        $tAgnCode       = empty($paDataFilter['tAgnCode']) ? '' : $paDataFilter['tAgnCode']; 

        // สาขา
        $tBchCodeFrom   = empty($paDataFilter['tBchCodeFrom']) ? '' : $paDataFilter['tBchCodeFrom']; 
        $tBchCodeTo     = empty($paDataFilter['tBchCodeTo']) ? '' : $paDataFilter['tBchCodeTo']; 
        $tBchCodeSelect = empty($paDataFilter['tBchCodeSelect']) ? '' : $paDataFilter['tBchCodeSelect'];

        // ร้านค้า
        $tShpCodeFrom   = empty($paDataFilter['tShpCodeFrom']) ? '' : $paDataFilter['tShpCodeFrom']; 
        $tShpCodeTo     = empty($paDataFilter['tShpCodeTo']) ? '' : $paDataFilter['tShpCodeTo']; 
        $tShpCodeSelect = empty($paDataFilter['tShpCodeSelect']) ? '' : $paDataFilter['tShpCodeSelect'];

        // วันที่เอกสาร
        $tDateFrom      = empty($paDataFilter['tDocDateFrom']) ? '' : $paDataFilter['tDocDateFrom']; 
        $tDateTo        = empty($paDataFilter['tDocDateTo']) ? '' : $paDataFilter['tDocDateTo']; 
        
        $tCallStore = "{CALL SP_RPTxSaleShopByDate(?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'       => $nLngID,
            'pnComName'     => $tComName,
            'ptRptName'     => $tRptCode,
            'ptUsrSession'  => $tUserSession,
            'pnFilterType'  => 2,
            'ptAgnL'        => $tAgnCode,
            'ptBchL'        => $tBchCodeSelect,
            'ptShpL'        => $tShpCodeSelect,
            'ptDocDateF'    => $tDateFrom,
            'ptDocDateT'    => $tDateTo,
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
     * Creator: 29/10/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere, $paDataFilter) {

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
                    ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID,
                    CONVERT(VARCHAR(10), TMP.FDTxnDocDate, 121) AS rtTxnDocDate,
                    ISNULL(TMP.FTBchCode, '-') AS rtBchCode,
                    ISNULL(TMP.FTBchName, '-') AS rtBchName,
                    ISNULL(TMP.FTShpCode, '-') AS rtShpCode,
                    ISNULL(TMP.FTShpName, '-') AS rtShpName,
                    TMP.FTTxnDocType AS rtTxnDocType,
                    SUM (FCTxnSale) AS rcFCTxnSale,
                    SUM (FCTxnRefund) AS rcFCTxnRefund,
                    SUM (FCTxnValue) AS rcFCTxnValue
                    /*SUM(CASE WHEN TMP.FTTxnDocType = 3 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnSaleVal,*/
                    /*SUM(CASE WHEN TMP.FTTxnDocType = 4 THEN TMP.FCTxnValue ELSE  0 END) AS rcTxnCancelSaleVal*/
                FROM TFCTRptCrdAnalyzeTmp TMP WITH (NOLOCK)
                WHERE TMP.FTComName = '$tCompName' AND TMP.FTRptCode = '$tRptCode'
                GROUP BY 
                    FTBchCode , 
                    CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)  , 
                    FTShpCode , 
                    FTBchName , 
                    FTShpName , 
                    FTTxnDocType  
            ) AS RPT 
        ";

        $tSQL .= "  WHERE 1=1 AND RPT.rtRowID > $aRowLen[0] AND RPT.rtRowID <= $aRowLen[1]";
        $tSQL .= "  ORDER BY RPT.rtBchCode ASC, CONVERT(VARCHAR(10),RPT.rtTxnDocDate,121) ASC, RPT.rtShpCode ASC";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataRpt = $oQuery->result_array();

            $oCountRowRpt = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow = $oCountRowRpt;
            $nPageAll = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData = array(
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
     * Creator: 29/10/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tSessionID = $paDataWhere['tUserSessionID'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL = "   
            SELECT
                ROW_NUMBER() OVER(ORDER BY TMP.FTBchCode ASC, CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121) ASC, TMP.FTShpCode ASC) AS rtRowID
            FROM TFCTRptCrdAnalyzeTmp TMP WITH (NOLOCK)
            WHERE FTComName = '$tCompName' AND FTRptCode = '$tRptCode'
            GROUP BY 
                TMP.FTBchCode,
                TMP.FTBchName,
                TMP.FTShpCode,
                TMP.FTShpName,
                CONVERT(VARCHAR(10),TMP.FDTxnDocDate,121)";
        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    /**
     * Functionality: Summary Data Report SaleShopByDate
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 Piya
     * Last Modified :
     * Return : 
     * Return Type: Array
     */
    public function FSaMRptAnsRptSaleShopByDateSum($paFilterReport){
		$tCompName  = $paFilterReport['tCompName'];
        $tRptCode   = $paFilterReport['tRptCode'];
        $tSQL = "   
            SELECT 
                SUM(FCTxnSale)      AS rcFCTxnSale,
                SUM(FCTxnRefund)    AS rcFCTxnRefund,
                SUM(FCTxnValue)     AS rcFCTxnValue
            FROM TFCTRptCrdAnalyzeTmp TMP WITH (NOLOCK)  
            WHERE FTComName = '$tCompName' AND FTRptCode = '$tRptCode' ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->result_array();
    }
}
