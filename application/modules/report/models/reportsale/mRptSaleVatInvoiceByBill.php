<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mRptSaleVatInvoiceByBill extends CI_Model {
    
    // Functionality: Delete Temp Report and Execute StoredProcedure
    // Parameters:  Function Parameter
    // Creator: 23/04/2019 Wasin(Yoshi)
    // Last Modified :
    // Return : Call Store Proce
    // Return Type: Array
    public function FSnMExecStoreReport($paDataFilter){
        $tCallStore = "{ CALL STP_RPTxVat(?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'ptUserCode'    => $paDataFilter['tUserCode'],
            'ptBchFrm'      => $paDataFilter['tBchCodeFrom'],
            'ptBchTo'       => $paDataFilter['tBchCodeTo'],
            'ptCompName'    => $paDataFilter['tCompName'],
            'ptRptCode'     => $paDataFilter['tCode'],
            'ptDateFrm'     => $paDataFilter['tDocDateFrom'],
            'ptDateTo'      => $paDataFilter['tDocDateTo'],
            'pnLngID'       => $paDataFilter['nLangID'],
            'tSql'          => '',
            'FNResult'      => '',
            'tErr'          => '',
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
    // Creator: 23/04/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Get Data Rpt Temp
    // Return Type: Array
    public function FSaMGetDataReport($paDataWhere){
        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'],$paDataWhere['nPage']);

        $tUserCode  = $paDataWhere['tUserCode'];
        $tCompName  = $paDataWhere['tCompName'];
        $tRptCode   = $paDataWhere['tRptCode'];
        $tSQL       = " SELECT c.* FROM(
                            SELECT ROW_NUMBER() OVER(ORDER BY FTXshDocNo ASC ) AS rtRowID,* FROM (
                                SELECT
                                    TTSALHD.FTRptUserCode,
                                    TTSALHD.FTRptCompName,
                                    TTSALHD.FTRptCode,
                                    TTSALHD.FTBchCode,
                                    TTSALHD.FTBchName,
                                    TTSALHD.FTPosCode,
                                    CONCAT(TTSALHD.FTBchCode,';',CONVERT(VARCHAR(10),TTSALHD.FDXshDocDate,121)) AS FDXshDocDate,
                                    TTSALHD.FTXshDocVatFull,
                                    TTSALHD.FTXshDocNo,
                                    TTSALHD.FTCstName,
                                    TTSALHD.FTCstTaxNo,
                                    TTSALHD.FTCstBusiness,
                                    ISNULL(TTSALHD.FCXshVat,0)                 AS FCXshVat,
                                    ISNULL(TTSALHD.FCXshTotalAfDisChgNV,0)     AS FCXshTotalAfDisChgNV,
                                    ISNULL(TTSALHD.FCXshGrand,0)               AS FCXshGrand
                                FROM TTmpTPSTSalHD TTSALHD
                                WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                                AND TTSALHD.FNXshDocType = 1
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
    // Creator: 23/04/2019 Wasin(Yoshi)
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
                            TTSALHD.FTPosCode,
                            CONCAT(TTSALHD.FTBchCode,';',CONVERT(VARCHAR(10),TTSALHD.FDXshDocDate,121)) AS FDXshDocDate,
                            TTSALHD.FTXshDocVatFull,
                            TTSALHD.FTXshDocNo,
                            TTSALHD.FTCstName,
                            TTSALHD.FTCstTaxNo,
                            TTSALHD.FTCstBusiness,
                            ISNULL(TTSALHD.FCXshVat,0)                 AS FCXshVat,
                            ISNULL(TTSALHD.FCXshTotalAfDisChgNV,0)     AS FCXshTotalAfDisChgNV,
                            ISNULL(TTSALHD.FCXshGrand,0)               AS FCXshGrand
                        FROM TTmpTPSTSalHD TTSALHD
                        WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                        AND TTSALHD.FNXshDocType = 1 ";
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
                            ISNULL((TTmpSumValue.FCXshSumGrand + TTmpSumValue.FCXshSumTotalAfDisChgNV - TTmpSumValue.FCXshSumVat),0) AS FCXshSumValue,
                            TTmpSumValue.*
                        FROM (  SELECT 
                                    ISNULL(SUM(TTSALHD.FCXshVat),0)             AS FCXshSumVat,
                                    ISNULL(SUM(TTSALHD.FCXshTotalAfDisChgNV),0) AS FCXshSumTotalAfDisChgNV,
                                    ISNULL(SUM(TTSALHD.FCXshGrand),0)           AS FCXshSumGrand
                                FROM TTmpTPSTSalHD TTSALHD
                                WHERE 1 = 1 AND TTSALHD.FTRptUserCode = '$tUserCode' AND TTSALHD.FTRptCompName = '$tCompName' AND TTSALHD.FTRptCode = '$tRptCode'
                                AND TTSALHD.FNXshDocType = 1 ) AS TTmpSumValue ";
        $oQuery         = $this->db->query($tSQL);
        $aDataSumRpt    = $oQuery->row_array();
        unset($oQuery);
        return $aDataSumRpt;
    }

}