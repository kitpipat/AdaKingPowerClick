<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleVatInvoiceByDate extends CI_Model {

    // Functionality: Delete Temp Report
    // Parameters:  Function Parameter
    // Creator: 19/04/2019 Wasin(Yoshi)
    // Last Modified :
    // Return : Call Store Proce
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $tCallStore = "{ CALL STP_RPTxVatByDate(?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'ptUserCode'        => $paDataFilter['tUserCode'],
            'ptCompName'        => $paDataFilter['tCompName'],
            'ptRptCode'         => $paDataFilter['tCode'],
            'ptBchCodeFrom'     => $paDataFilter['tBchCodeFrom'],
            'ptBchCodeTo'       => $paDataFilter['tBchCodeTo'],
            'ptXshDocDateFrom'  => $paDataFilter['tDocDateFrom'],
            'ptXshDocDateTo'    => $paDataFilter['tDocDateTo'],
            'pnLngID'           => $paDataFilter['nLangID'],
            'FNResult'          => 0,
            'tErr'              => 0,
        );
        $oQuery = $this->db->query($tCallStore,$aDataStore);
        if($oQuery !== FALSE){
            unset($oQuery);
            return 1;
        }else{
            unset($oQuery);
            return 0;
        }
    }

    // Functionality: Get Data Report
    // Parameters:  Function Parameter
    // Creator: 19/04/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){
        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL       = " SELECT c.* FROM(
                            SELECT ROW_NUMBER() OVER(ORDER BY FDXshDocDate ASC,FNXshDocType ASC ) AS rtRowID,* FROM (
                                SELECT
                                    TTSALHD.FTRptUserCode,
                                    TTSALHD.FTRptCompName,
                                    TTSALHD.FTRptCode,
                                    TTSALHD.FTBchCode,
                                    TTSALHD.FTBchName,
                                    TTSALHD.FNXshDocType,
                                    CONCAT(TTSALHD.FTBchCode,';',CONVERT(VARCHAR(10),TTSALHD.FDXshDocDate,121)) AS FDXshDocDate,
                                    ISNULL(SUM(TTSALHD.FCXshVat),0)                 AS FCXshVat,
                                    ISNULL(SUM(TTSALHD.FCXshTotalAfDisChgNV),0)     AS FCXshTotalAfDisChgNV,
                                    ISNULL(SUM(TTSALHD.FCXshGrand),0)               AS FCXshGrand,
                                    CONCAT(
                                    (   SELECT TOP 1
                                            TTmpTPSTSalHD.FTXshDocNo
                                        FROM TTmpTPSTSalHD
                                        WHERE 1=1
                                        AND TTmpTPSTSalHD.FTBchCode     = TTSALHD.FTBchCode
                                        AND TTmpTPSTSalHD.FNXshDocType 	= TTSALHD.FNXshDocType
                                        AND TTmpTPSTSalHD.FDXshDocDate 	= TTSALHD.FDXshDocDate
                                        ORDER BY TTmpTPSTSalHD.FTXshDocNo ASC 
                                    ),' - ',
                                    (	SELECT TOP
                                            1 TTmpTPSTSalHD.FTXshDocNo
                                        FROM TTmpTPSTSalHD
                                        WHERE 1=1
                                        AND TTmpTPSTSalHD.FTBchCode     = TTSALHD.FTBchCode
                                        AND TTmpTPSTSalHD.FNXshDocType 	= TTSALHD.FNXshDocType
                                        AND TTmpTPSTSalHD.FDXshDocDate 	= TTSALHD.FDXshDocDate
                                        ORDER BY TTmpTPSTSalHD.FTXshDocNo DESC ))   AS FTXshFirstLastDocNo
                                FROM TTmpTPSTSalHD TTSALHD 
                                WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                                GROUP BY TTSALHD.FTBchCode,TTSALHD.FTBchName,TTSALHD.FNXshDocType,TTSALHD.FDXshDocDate,TTSALHD.FTRptUserCode,TTSALHD.FTRptCompName,TTSALHD.FTRptCode
                        ) Base ) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1] ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataRpt       = $oQuery->result_array();
            $oCountRowRpt   = $this->FSaMCountDataReportAll($paDataWhere);
            $nFoundRow      = $oCountRowRpt;
            $nPageAll       = ceil($nFoundRow / $paDataWhere['nRow']);
            $aReturnData    = array(
                'raItems'       => $aDataRpt,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1 ',
                'rtDesc'        => 'success',
            );
        }else{
            $aReturnData    = array(
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

    // Functionality: Count Data Report All
    // Parameters: Function Parameter
    // Creator: 22/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array    
    public function FSaMCountDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT
                            TTSALHD.FTRptUserCode,
                            TTSALHD.FTRptCompName,
                            TTSALHD.FTRptCode,
                            TTSALHD.FTBchCode,
                            TTSALHD.FTBchName,
                            TTSALHD.FNXshDocType,
                            CONCAT(TTSALHD.FTBchCode,';',CONVERT(VARCHAR(10),TTSALHD.FDXshDocDate,121)) AS FDXshDocDate,
                            ISNULL(SUM(TTSALHD.FCXshVat),0)                 AS FCXshVat,
                            ISNULL(SUM(TTSALHD.FCXshTotalAfDisChgNV),0)     AS FCXshTotalAfDisChgNV,
                            ISNULL(SUM(TTSALHD.FCXshGrand),0)               AS FCXshGrand,
                            CONCAT(
                            (   SELECT TOP 1
                                    TTmpTPSTSalHD.FTXshDocNo
                                FROM TTmpTPSTSalHD
                                WHERE 1=1
                                AND TTmpTPSTSalHD.FTBchCode     = TTSALHD.FTBchCode
		                        AND TTmpTPSTSalHD.FNXshDocType 	= TTSALHD.FNXshDocType
		                        AND TTmpTPSTSalHD.FDXshDocDate 	= TTSALHD.FDXshDocDate
                                ORDER BY TTmpTPSTSalHD.FTXshDocNo ASC 
                            ),' - ',
                            (	SELECT TOP
                                    1 TTmpTPSTSalHD.FTXshDocNo
                                FROM TTmpTPSTSalHD
                                WHERE 1=1
                                AND TTmpTPSTSalHD.FTBchCode     = TTSALHD.FTBchCode
                                AND TTmpTPSTSalHD.FNXshDocType 	= TTSALHD.FNXshDocType
		                        AND TTmpTPSTSalHD.FDXshDocDate 	= TTSALHD.FDXshDocDate
                                ORDER BY TTmpTPSTSalHD.FTXshDocNo DESC ))   AS FTXshFirstLastDocNo
                        FROM TTmpTPSTSalHD TTSALHD 
                        WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                        GROUP BY TTSALHD.FTBchCode,TTSALHD.FTBchName,TTSALHD.FNXshDocType,TTSALHD.FDXshDocDate,TTSALHD.FTRptUserCode,TTSALHD.FTRptCompName,TTSALHD.FTRptCode ";
        $oQuery     = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }

    // Functionality: Sum All Value Data Report All
    // Parameters: Function Parameter
    // Creator: 24/04/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Report All
    // ReturnType: Array
    public function FSaMSumDataReportAll($paDataWhere){
        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];

        $tSQL       = " SELECT
                            (ISNULL(SUM(TTmpSumValue.FCXshSumGrand),0) + ISNULL(SUM(TTmpSumValue.FCXshSumTotalAfDisChgNV),0)- ISNULL(SUM(TTmpSumValue.FCXshSumVat),0)) AS FCXshSumTotalAllValue,
                            ISNULL(SUM(TTmpSumValue.FCXshSumVat),0) AS FCXshSumTotalAllVat,
                            ISNULL(SUM(TTmpSumValue.FCXshSumTotalAfDisChgNV),0) AS FCXshSumTotalAllAfDisChgNV,
                            ISNULL(SUM(TTmpSumValue.FCXshSumGrand),0) AS FCXshSumTotalAllGrand
                        FROM (  SELECT
                                    ISNULL(SUM(TTSALHD.FCXshVat),0)             AS FCXshSumVat,
                                    ISNULL(SUM(TTSALHD.FCXshTotalAfDisChgNV),0) AS FCXshSumTotalAfDisChgNV,
                                    ISNULL(SUM(TTSALHD.FCXshGrand),0)           AS FCXshSumGrand
                                FROM TTmpTPSTSalHD TTSALHD
                                WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                                GROUP BY TTSALHD.FTBchCode,TTSALHD.FTBchName,TTSALHD.FNXshDocType,TTSALHD.FDXshDocDate,TTSALHD.FTRptUserCode,TTSALHD.FTRptCompName,TTSALHD.FTRptCode
                        ) AS TTmpSumValue ";
        $oQuery         = $this->db->query($tSQL);
        $aDataSumRpt    = $oQuery->row_array();
        unset($oQuery);
        return $aDataSumRpt;
    }



}