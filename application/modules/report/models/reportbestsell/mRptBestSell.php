<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mRptBestSell extends CI_Model {
    
    /**
     * Functionality: Delete Temp Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : 23/09/2019 Piya
     * Return : Call Store Proce
     * Return Type: Array
     */
    public function FSnMExecStoreReport($paDataFilter) {
        $nLangID      = $paDataFilter['nLangID'];
        $tComName     = $paDataFilter['tCompName'];
        $tRptCode     = $paDataFilter['tRptCode'];
        $tUserSession = $paDataFilter['tUserSession'];

         // สาขา
         $tBchCodeSelect = ($paDataFilter['bBchStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tBchCodeSelect']); 
         // ร้านค้า
         $tShpCodeSelect = ($paDataFilter['bShpStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tShpCodeSelect']);
         // กลุ่มธุรกิจ
         $tMerCodeSelect = ($paDataFilter['bMerStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tMerCodeSelect']);
         // ประเภทเครื่องจุดขาย
         $tPosCodeSelect = ($paDataFilter['bPosStaSelectAll']) ? '' : FCNtAddSingleQuote($paDataFilter['tPosCodeSelect']);

        // $tCallStore = "{ CALL SP_RPTxDailyByPdtBstQty1001004(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        // $aDataStore = array(
        //     'pnLngID'      => $nLangID,
        //     'pnComName'    => $tComName,
        //     'ptRptCode'    => $tRptCode,
        //     'ptUsrSession' => $tUserSession,
        //     'pnTop'        => $paDataFilter['tTopPdt'],
        //     'ptBchF'       => $paDataFilter['tBchCodeFrom'],
        //     'ptBchT'       => $paDataFilter['tBchCodeTo'],
        //     'ptShpF'       => $paDataFilter['tShpCodeFrom'],
        //     'ptShpT'       => $paDataFilter['tShpCodeTo'],
        //     'ptPdtCodeF'   => $paDataFilter['tPdtCodeFrom'],
        //     'ptPdtCodeT'   => $paDataFilter['tPdtCodeTo'],
        //     'ptPdtChanF'   => $paDataFilter['tPdtGrpCodeFrom'],
        //     'ptPdtChanT'   => $paDataFilter['tPdtGrpCodeTo'],
        //     'ptPdtTypeF'   => $paDataFilter['tPdtTypeCodeFrom'],
        //     'ptPdtTypeT'   => $paDataFilter['tPdtTypeCodeTo'],
        //     'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
        //     'ptDocDateT'   => $paDataFilter['tDocDateTo'],
        //     'FNResult'     => 0,
        // );
        $tCallStore = "{ CALL SP_RPTxDailyByPdtBstQty1001004(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) }";
        $aDataStore = array(
            'pnLngID'      => $nLangID,
            'pnComName'    => $tComName,
            'ptRptCode'    => $tRptCode,
            'ptUsrSession' => $tUserSession,

            'pnFilterType'  => $paDataFilter['tTypeSelect'],
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

            'pnTop'        => $paDataFilter['tTopPdt'],
            'ptPdtCodeF'   => $paDataFilter['tPdtCodeFrom'],
            'ptPdtCodeT'   => $paDataFilter['tPdtCodeTo'],
            'ptPdtChanF'   => $paDataFilter['tPdtGrpCodeFrom'],
            'ptPdtChanT'   => $paDataFilter['tPdtGrpCodeTo'],
            'ptPdtTypeF'   => $paDataFilter['tPdtTypeCodeFrom'],
            'ptPdtTypeT'   => $paDataFilter['tPdtTypeCodeTo'],
            'ptDocDateF'   => $paDataFilter['tDocDateFrom'],
            'ptDocDateT'   => $paDataFilter['tDocDateTo'],
            'FNResult'     => 0,
        );

        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if ($oQuery !== FALSE) {
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
     * Creator: 04/04/2019 Wasin(Yoshi)
     * Last Modified : 12/11/2019 Piya
     * Return : Get Data Rpt Temp
     * Return Type: Array
     */
    public function FSaMGetDataReport($paDataWhere) {

        $aRowLen = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        if(!empty($paDataWhere['aDataFilter']['tPosType'])){
            $tPosType = $paDataWhere['aDataFilter']['tPosType'];
        }else{
            $tPosType = "";
        }
        $tSQL = "
            SELECT C.*
                FROM (
                    SELECT 
                        ROW_NUMBER() OVER(ORDER BY DATAGRP.FCXsdQty DESC,DATAGRP.FTPdtCode ASC) AS rtRowID,
                        DATAGRP.*
                    FROM(
                        SELECT
                            FTPdtCode,
                            FTXsdPdtName,
                            FTPgpChainName,
                            FTPunName,
                            FCXsdSetPrice,
                            SUM(FCXsdQty) AS FCXsdQty,
                            SUM(FCXsdAmtB4DisChg) AS FCXsdDigChg,
                            SUM(FCXsdDis) AS FCXsdDis,
                            SUM(FCXsdNetAfHD) AS FCXsdNetAfHD
                        FROM TRPTSalDTTmp
                        WHERE 1=1
                        AND FTComName = '" . $tCompName . "'
                        AND FTRptCode = '" . $tRptCode . "'
                        AND FTUsrSession = '" . $tUserSession . "'
                ";
        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }
        $tSQL .= "
                        GROUP BY FTPdtCode,FTXsdPdtName,FTPgpChainName,FTPunName,FCXsdSetPrice
                    ) AS DATAGRP 
                ) AS C
                WHERE C.rtRowID > $aRowLen[0] AND C.rtRowID <= $aRowLen[1]
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
        // echo '<pre>';print_r($aReturnData); exit();
        return $aReturnData;

    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 11/04/2019 Wasin(Yoshi)
     * Last Modified: 12/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMCountDataReportAll($paDataWhere) {

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];

        if(!empty($paDataWhere['aDataFilter']['tPosType'])){
            $tPosType = $paDataWhere['aDataFilter']['tPosType'];
        }else{
            $tPosType = "";
        }

        $tSQL = "
            SELECT
                FTPdtCode,
                FTXsdPdtName,
                FTPgpChainName,
                FTPunName,
                FCXsdSetPrice,
                SUM(FCXsdQty) AS FCXsdQty,
                SUM(FCXsdAmtB4DisChg) AS FCXsdDigChg,
                SUM(FCXsdDis) AS FCXsdDis,
                SUM(FCXsdNetAfHD) AS FCXsdNetAfHD
            FROM TRPTSalDTTmp
            WHERE FTComName = '" . $tCompName . "'
            AND FTRptCode = '" . $tRptCode . "'
            AND FTUsrSession = '" . $tUserSession . "'
        ";
        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }
        $tSQL .= "
            GROUP BY FTPdtCode, FTXsdPdtName, FTPgpChainName,FTPunName,FCXsdSetPrice
        ";

        $oQuery = $this->db->query($tSQL);
        $nCountData = $oQuery->num_rows();
        unset($oQuery);
        return $nCountData;
    }
    
    /**
     * Functionality: To Get data SumFootReport
     * Parameters: Function Parameter
     * Creator: 12/08/2019 Sarun
     * Last Modified: 12/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSaMGetDataSumFootReport($paDataWhere) {

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tPosType = $paDataWhere['aDataFilter']['tPosType'];

    
        $tSQL = "  
            SELECT
                ISNULL(SUM(FCXsdQty),0)         AS FCXsdSumQty,
                ISNULL(SUM(FCXsdAmtB4DisChg),0) AS FCXsdSumDigChg,
                ISNULL(SUM(FCXsdDis),0)	        AS FCXsdSumDis,
                ISNULL(SUM(FCXsdNetAfHD),0)     AS FCSumFooter
            FROM TRPTSalDTTmp
            WHERE FTUsrSession = '$tUserSession' AND FTComName = '$tCompName' AND FTRptCode = '$tRptCode'";
        if(!empty($tPosType)){
            $tSQL .= " AND FNAppType = '" . $tPosType . "'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array();
        } else {
            return array();
        }
    }

    /**
     * Functionality: Count Data Report All
     * Parameters: Function Parameter
     * Creator: 11/04/2019 Witsarut(Bell)
     * Last Modified: 12/11/2019 Piya
     * Return: Data Report All
     * ReturnType: Array
     */
    public function FSnMCountDataReportAll($paDataWhere) {
     

        $tUserSession = $paDataWhere['tUserSession'];
        $tCompName = $paDataWhere['tCompName'];
        $tRptCode = $paDataWhere['tRptCode'];
        $tSQL = "   
            SELECT 
                DTTMP.FTRptCode
            FROM TRPTSalDTTmp AS DTTMP WITH(NOLOCK)
            WHERE FTUsrSession = '$tUserSession'
            AND FTComName = '$tCompName'
            AND FTRptCode = '$tRptCode'
         ";
    
        $oQuery = $this->db->query($tSQL);
        $nRptAllRecord = $oQuery->num_rows();
        unset($oQuery);
        return $nRptAllRecord;
    }

}

