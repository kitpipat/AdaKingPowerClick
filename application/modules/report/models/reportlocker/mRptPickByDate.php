<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptPickByDate extends CI_Model {

    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * Last Modified : -
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {

        $tCallStore = "{ CALL SP_RPTxRTPickByDateTemp3001011(?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID' => $paDataFilter['nLangID'],
            'pnComName' => $paDataFilter['tCompName'],
            'ptRptCode' => $paDataFilter['tRptCode'],
            'ptUsrSession' => $paDataFilter['tUserSession'],
            'ptBchF' => $paDataFilter['tBchCodeFrom'],
            'ptBchT' => $paDataFilter['tBchCodeTo'],
            'ptShpF' => $paDataFilter['tShopCodeFrom'],
            'ptShpT' => $paDataFilter['tShopCodeTo'],
            'ptPosF' => $paDataFilter['tPosCodeFrom'],
            'ptPosT' => $paDataFilter['tPosCodeTo'],
            'ptDocDateF' => $paDataFilter['tDocDateFrom'],
            'ptDocDateT' => $paDataFilter['tDocDateTo'],
            'FNResult' => 0,
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
     * Creator: 10/10/2019 Piya
     * Last Modified : -
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere, $paDataFilter) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);

        $tUserCode = $paDataWhere['tUserCode'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSessionID = $paDataWhere['tUserSession'];

        $tSQL = "
            SELECT
                c.*
            FROM(
                SELECT
                    ROW_NUMBER() OVER(ORDER BY FDXshDocDate DESC) AS rtRowID, *
                FROM(
                    SELECT TOP 100 PERCENT
                        TMP.FDXshDocDate,
                        TMP.FTBchCode,
                        TMP.FTBchName,
                        TMP.FTXshDocNo,
                        TMP.FTXshRefExt,
                        TMP.FTXshFrmLogin,
                        TMP.FTXshToLogin,
                        TMP.FDXshDatePick,
                        TMP.FTPosCode,
                        TMP.FTPzeName,
                        TMP.FTRthCode,
                        TMP.FTXsdTimeFinish,
                        TMP.FCXsdNetAfHD,
                        CASE
                            WHEN TMP.FDXshDatePick IS NULL THEN '" . language('report/report/report', 'tRptNotReceived') . "'
                            ELSE '" . language('report/report/report', 'tRptReceived') . "' 
                        END AS FTStatus,
                        TMP.FTUsrSession,
                        TMP.FTComName,
                        TMP.FTRptCode
                    FROM TRPTRTPickByDateTemp TMP
                    WHERE TMP.FTUsrSession = '$tSessionID' AND TMP.FTComName = '$tCompName' AND TMP.FTRptCode = '$tRptCode'
                    ORDER BY
                    TMP.FDXshDocDate DESC,
                    TMP.FTBchCode ASC

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
     * Creator: 10/10/2019 Piya
     * Last Modified: -
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tSessionID = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        $tSQL = "
            SELECT TOP 100 PERCENT
                TMP.FDXshDocDate,
                TMP.FTBchCode,
                TMP.FTXshDocNo,
                TMP.FTXshRefExt,
                TMP.FTXshFrmLogin,
                TMP.FTXshToLogin,
                TMP.FDXshDatePick,
                TMP.FTPosCode,
                TMP.FTPzeName,
                TMP.FTRthCode,
                TMP.FTXsdTimeFinish,
                TMP.FCXsdNetAfHD,
                TMP.FTUsrSession AS rtUsrSession,
                TMP.FTComName AS rtComname,
                TMP.FTRptCode AS rtRptCode
            FROM TRPTRTPickByDateTemp TMP
            WHERE TMP.FTUsrSession = '$tSessionID' AND TMP.FTComName = '$tCompName' AND TMP.FTRptCode = '$tRptCode'
            ORDER BY
            TMP.FDXshDocDate DESC,
            TMP.FTBchCode ASC
        ";

        $oQuery = $this->db->query($tSQL);

        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }
}
