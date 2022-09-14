<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mPromotionTopup extends CI_Model {
    /**
     * Functionality : HD List
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : HD List
     * Return Type : Array
     */
    public function FSaMPTUHDList($paParams){
        $aRowLen     = FCNaHCallLenData($paParams['nRow'], $paParams['nPage']);
        $tShowStatus = $paParams['tShowStatus'];
        $nLngID      = $paParams['FNLngID'];

        $tSQL1  = " SELECT c.* FROM ( SELECT  ROW_NUMBER() OVER( ORDER BY FDCreateOn DESC ) AS FNRowID,* FROM ( ";
        $tSQLMain = " SELECT DISTINCT
                        HD.*,
                        HDL.FTPmhName,
                        BCHL.FTBchName,
                        USRL.FTUsrName      AS FTCreateByName,
                        USRLAPV.FTUsrName   AS FTXthApvName
                    ";
        $tSQLCount = " SELECT DISTINCT COUNT( HD.FTPmhDocNo ) AS counts ";
        $tSQL2 = "  FROM TFNTCrdPmtHD HD WITH (NOLOCK)
                    LEFT JOIN TFNTCrdPmtHD_L    HDL     WITH (NOLOCK) ON HDL.FTPmhDocNo = HD.FTPmhDocNo     AND HDL.FNLngID     = $nLngID
                    LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK) ON BCHL.FTBchCode = HD.FTBchCode      AND BCHL.FNLngID    = $nLngID
                    LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK) ON USRL.FTUsrCode = HD.FTCreateBy     AND USRL.FNLngID    = $nLngID
                    LEFT JOIN TCNMUser_L        USRLAPV WITH (NOLOCK) ON HD.FTPmhUsrApv = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                    WHERE 1=1
        ";

        if ($this->session->userdata('tSesUsrLevel') != "HQ") { // ไม่ใช่ผู้ใช้ระดับ HQ ดูได้แค่สาขาที่ login
            $tBchCode = $this->session->userdata('tSesUsrBchCodeMulti');
            $tSQL2 .= "
                AND HD.FTBchCode IN ($tBchCode)
            ";
        }

        $aAdvanceSearch = $paParams['aAdvanceSearch'];
        $tSearchList = $aAdvanceSearch['tSearchAll'];
        $tSQLSearchAll = '';
        if ($tSearchList != '') {
            $tSQL2 .= " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
            $tSQLSearchAll = " AND ((HD.FTPmhDocNo COLLATE THAI_BIN LIKE '%$tSearchList%') OR (HDL.FTPmhName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (BCHL.FTBchName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRL.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%') OR (USRLAPV.FTUsrName COLLATE THAI_BIN LIKE '%$tSearchList%'))";
        }

        // จากสาขา - ถึงสาขา
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSQLSearchBch = '';
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL2 .= " AND ((HD.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (HD.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
            $tSQLSearchBch = " AND ((HD.FTBchCode BETWEEN '$tSearchBchCodeFrom' AND '$tSearchBchCodeTo') OR (HD.FTBchCode BETWEEN '$tSearchBchCodeTo' AND '$tSearchBchCodeFrom'))";
        }

        // จากวันที่ - ถึงวันที่
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo = $aAdvanceSearch['tSearchDocDateTo'];
        $tSQLSearchDocDate = '';
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL2 .= " AND ((HD.FDPmhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDPmhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
            $tSQLSearchDocDate = " AND ((HD.FDPmhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (HD.FDPmhDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 00:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 23:59:59')))";
        }

        // สถานะอนุมัติ
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // $tSQLSearchStaApprove = '';
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL2 .= " AND (HD.FTPmhStaApv = '$tSearchStaApprove' OR HD.FTPmhStaApv = '')";
        //         $tSQLSearchStaApprove = " AND (HD.FTPmhStaApv = '$tSearchStaApprove' OR HD.FTPmhStaApv = '')";
        //     } else {
        //         $tSQL2 .= " AND HD.FTPmhStaApv = '$tSearchStaApprove'";
        //         $tSQLSearchStaApprove = " AND HD.FTPmhStaApv = '$tSearchStaApprove'";
        //     }
        // }

        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {

            if ($tSearchStaDoc == 3) {
                $tSQL2 .= " AND HD.FTPmhStaDoc = '$tSearchStaDoc'";
            } elseif ($tSearchStaDoc == 2) {
                $tSQL2 .= " AND ISNULL(HD.FTPmhStaApv,'') = '' AND HD.FTPmhStaDoc != '3'";
            } elseif ($tSearchStaDoc == 1) {
                $tSQL2 .= " AND HD.FTPmhStaApv = '$tSearchStaDoc'";
            }
        }

        // ค้นหาสถานะประมวลผล
        // $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        // if(isset($tSearchStaPrcStk) && !empty($tSearchStaPrcStk)){
        //     if ($tSearchStaPrcStk == 3) {
        //         $tSQL2 .= " AND (HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk' OR ISNULL(HD.FTPmhStaPrcDoc,'') = '') ";
        //     } else {
        //         $tSQL2 .= " AND HD.FTPmhStaPrcDoc = '$tSearchStaPrcStk'";
        //     }
        // }

        // ค้นหาสถานะเคลื่อนไหว
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 1) {
                $tSQL2 .= " AND HD.FNPmhStaDocAct = 1";
            } else {
                $tSQL2 .= " AND HD.FNPmhStaDocAct = 0";
            }
        }


        if( $tShowStatus != "" && $tShowStatus != "ALL" ){
            if( $tShowStatus == "NOTSTART" ){
                $tSQL2 .= " AND CONVERT(VARCHAR(16),GETDATE(),121) < CONVERT(VARCHAR(16), CONVERT(DATETIME, CONVERT(VARCHAR, CONVERT(VARCHAR(10),HD.FDPmhDStart,121)) + ' '+ CONVERT(VARCHAR(5), HD.FTPmhTStart)) ,121) ";
            }else if( $tShowStatus == "EXP" ){
                $tSQL2 .= " AND CONVERT(VARCHAR(16),GETDATE(),121) > CONVERT(VARCHAR(16), CONVERT(DATETIME, CONVERT(VARCHAR, CONVERT(VARCHAR(10),HD.FDPmhDStop,121)) + ' '+ CONVERT(VARCHAR(5), HD.FTPmhTStop)) ,121) ";
            }else{
                $tSQL2 .= " AND HD.FTPmhStaClosed = '$tShowStatus' AND HD.FTPmhStaDoc = '1' ";
                $tSQL2 .= " AND CONVERT(VARCHAR(16),GETDATE(),121) >= CONVERT(VARCHAR(16), CONVERT(DATETIME, CONVERT(VARCHAR, CONVERT(VARCHAR(10),HD.FDPmhDStart,121)) + ' '+ CONVERT(VARCHAR(5), HD.FTPmhTStart)) ,121) ";
                $tSQL2 .= " AND CONVERT(VARCHAR(16),GETDATE(),121) <= CONVERT(VARCHAR(16), CONVERT(DATETIME, CONVERT(VARCHAR, CONVERT(VARCHAR(10),HD.FDPmhDStop,121)) + ' '+ CONVERT(VARCHAR(5), HD.FTPmhTStop)) ,121) ";
            }
        }

        $tSQL3 = " ) Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1] ";

        $tSQLFull  = $tSQL1.$tSQLMain.$tSQL2.$tSQL3;
        $tSQLCount = $tSQLCount.$tSQL2;

        // echo $tSQLFull."<br><br>";
        // echo $tSQLCount."<br>";
        // exit;

        $oQuery         = $this->db->query($tSQLFull);
        $oQueryCount    = $this->db->query($tSQLCount);
        if ( $oQuery->num_rows() > 0 ) {
            $nFoundRow  = $oQueryCount->result_array()[0]['counts']; // $this->FSnMHDListGetPageAll($paParams)
            $nPageAll   = ceil($nFoundRow / $paParams['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oQuery->result(),
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paParams['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paParams['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    /**
     * Functionality : Del Document by DocNo
     * Parameters : function parameters
     * Creator : 18/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    public function FSxMPTUDeleteDoc($paDocNo){
        try {

            $this->db->where_in('FTPmhDocNo', $paDocNo);
            $this->db->delete('TFNTCrdPmtHD');

            $this->db->where_in('FTPmhDocNo', $paDocNo);
            $this->db->delete('TFNTCrdPmtHD_L');

            $this->db->where_in('FTPmhDocNo', $paDocNo);
            $this->db->delete('TFNTCrdPmtDT');

            $this->db->where_in('FTPmhDocNo', $paDocNo);
            $this->db->delete('TFNTCrdPmtCD');

            $this->db->where_in('FTPmhDocNo', $paDocNo);
            $this->db->delete('TFNTCrdPmtHDBch');

        } catch (Exception $Error) {
            return $Error;
        }
    }

    /**
     * Functionality : ล้างข้อมูลในตาราง tmp
     * Parameters : -
     * Creator : 18/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxMPTUClearInTmp($ptUserSessionID){
        $this->db->where('FTSessionID', $ptUserSessionID);
        $this->db->delete('TCNTCrdPmtTmp');
    }

    //Creator : 22/09/2020 Napat(Jame)
    public function FSxMPTUDTList($paParams){
        $nLngID         = $paParams['FNLngID'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   SELECT 
                        TMP.*,
                        CTY_L.FTCtyName
                    FROM TCNTCrdPmtTmp TMP WITH(NOLOCK)
                    INNER JOIN TFNMCardType_L CTY_L ON CTY_L.FTCtyCode = TMP.FTCtyCode AND CTY_L.FNLngID = $nLngID
                    WHERE TMP.FTSessionID   = '$tUserSessionID'
                      AND TMP.FTDocKey      = '$tDocKey'
                    ORDER BY TMP.FNPmdSeq ASC
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ) {
            $aResult = array(
                'nNumRow'      => $oQuery->num_rows(),
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'nNumRow'      => 0,
                'aItems'       => array(),
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    //Creator : 22/09/2020 Napat(Jame)
    public function FSaMPTUStep1AddEditCardType($paParams){

        $tBchCode       = $paParams['tBchCode'];
        $tDocNo         = $paParams['tDocNo'];
        $tCtyCode       = $paParams['tCtyCode'];
        $tStaType       = $paParams['tStaType'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQLUpd = "    UPDATE TCNTCrdPmtTmp
                        SET FTPmdStaType = '$tStaType'
                        WHERE FTBchCode = '$tBchCode'
                          AND FTPmhDocNo = '$tDocNo'
                          AND FTCtyCode = '$tCtyCode'
                          AND FTDocKey  = '$tDocKey'
                          AND FTSessionID = '$tUserSessionID'
                  ";
        $this->db->query($tSQLUpd);
        if( $this->db->affected_rows() == 0 ){
            $tSQLIns = " INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTCtyCode,FTPmdStaType,FTDocKey,FTSessionID)
                         SELECT
                            '$tBchCode'         AS FTBchCode,
                            '$tDocNo'           AS FTPmhDocNo,
                            (SELECT ISNULL(MAX(FNPmdSeq),0) + 1 AS FNPmdSeq FROM TCNTCrdPmtTmp WHERE FTBchCode = '$tBchCode' AND FTPmhDocNo = '$tDocNo' AND FTSessionID = '$tUserSessionID' AND FTDocKey = '$tDocKey') AS FNPmdSeq,
                            '$tCtyCode'         AS FTCtyCode,
                            '$tStaType'         AS FTPmdStaType,
                            '$tDocKey'          AS FTDocKey,
                            '$tUserSessionID'   AS FTSessionID
                       ";
            $this->db->query($tSQLIns);
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tSQL'  => $tSQLIns,
                    'tCode' => '1',
                    'tDesc' => 'Insert Success',
                );
            }else{
                $aResult = array(
                    'tSQL'  => $tSQLIns,
                    'tCode' => '900',
                    'tDesc' => 'Insert Error',
                );
            }
        }else{
            $aResult = array(
                'tSQL'  => $tSQLUpd,
                'tCode' => '1',
                'tDesc' => 'Update Success',
            );
        }
        return $aResult;
    }

    //Creator : 23/09/2020 Napat(Jame)
    public function FSaMPTUEventStepDelete($paParams){
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->where('FTBchCode', $paParams['tBchCode']);
        $this->db->where('FNPmdSeq', $paParams['nSeq']);
        $this->db->where('FTDocKey', $paParams['tDocKey']);
        $this->db->where('FTSessionID', $paParams['tUserSessionID']);
        $this->db->delete('TCNTCrdPmtTmp');

        // echo $this->db->last_query();

        if ( $this->db->trans_status() === FALSE ) {
            $aResult = array(
                'tCode' => '900',
                'tDesc' => $this->db->error(),
            );
        }else{
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tCode' => '1',
                    'tDesc' => 'Delete Success',
                );
            }else{
                $aResult = array(
                    'tCode' => '800',
                    'tDesc' => 'Not found data',
                );
            }
        }
        return $aResult;
    }

    //Creator : 23/09/2020 Napat(Jame)
    public function FSxMPTUCDList($paParams){
        $nLngID         = $paParams['FNLngID'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   SELECT 
                        TMP.*,
                        COP_L.FTCpnName AS FTPmcRefInName
                    FROM TCNTCrdPmtTmp TMP WITH(NOLOCK)
                    LEFT JOIN TFNTCouponHD_L COP_L  ON TMP.FTPmcRefIn = COP_L.FTCphDocNo AND COP_L.FNLngID = $nLngID
                    WHERE TMP.FTSessionID   = '$tUserSessionID'
                      AND TMP.FTDocKey      = '$tDocKey'
                    ORDER BY TMP.FNPmdSeq ASC
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ) {
            $aResult = array(
                'nNumRow'      => $oQuery->num_rows(),
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'nNumRow'      => 0,
                'aItems'       => array(),
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    //Creator : 24/09/2020 Napat(Jame)
    public function FSaMPTUEventStep2AddRow($paParams){
        $tBchCode       = $paParams['tBchCode'];
        $tDocNo         = $paParams['tDocNo'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];
        
        $tSQLIns = " INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FCPmcAmtPay,FCPmcAmtGet,FTDocKey,FTSessionID)
                     SELECT
                        '$tBchCode'         AS FTBchCode,
                        '$tDocNo'           AS FTPmhDocNo,
                        (SELECT ISNULL(MAX(FNPmdSeq),0) + 1 AS FNPmdSeq FROM TCNTCrdPmtTmp WHERE FTBchCode = '$tBchCode' AND FTPmhDocNo = '$tDocNo' AND FTSessionID = '$tUserSessionID' AND FTDocKey = '$tDocKey') AS FNPmdSeq,
                        (SELECT ISNULL(MAX(FCPmcAmtPay),0) + 0.01 AS FNPmdSeq FROM TCNTCrdPmtTmp WHERE FTBchCode = '$tBchCode' AND FTPmhDocNo = '$tDocNo' AND FTSessionID = '$tUserSessionID' AND FTDocKey = '$tDocKey') AS FCPmcAmtPay,
                        0                   AS FCPmcAmtGet,
                        '$tDocKey'          AS FTDocKey,
                        '$tUserSessionID'   AS FTSessionID
                   ";
        $this->db->query($tSQLIns);
        if( $this->db->affected_rows() > 0 ){
            $aResult = array(
                'tSQL'  => $tSQLIns,
                'tCode' => '1',
                'tDesc' => 'Insert Success',
            );
        }else{
            $aResult = array(
                'tSQL'  => $tSQLIns,
                'tCode' => '900',
                'tDesc' => 'Insert Error',
            );
        }
        return $aResult;
    }

    //Creator : 24/09/2020 Napat(Jame)
    public function FSaMPTUEventStep2EditInline($paParams){
        $tBchCode       = $paParams['tBchCode'];
        $tDocNo         = $paParams['tDocNo'];
        $nSeq           = $paParams['nSeq'];
        $tField         = $paParams['tField'];
        $tPrefix        = $paParams['tPrefix'];
        $nVal           = $paParams['nVal'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        if( $tPrefix == 'FC' ){
            $this->db->set($tField, $nVal, FALSE);
        }else{
            if( $nVal == 'NULL' || $nVal == 'null' ){
                $this->db->set($tField, 'NULL', FALSE);
            }else{
                $this->db->set($tField, $nVal);
            }
        }
        $this->db->where('FTPmhDocNo',$tDocNo);
        $this->db->where('FTDocKey',$tDocKey);
        $this->db->where('FNPmdSeq',$nSeq);
        $this->db->where('FTSessionID',$tUserSessionID);
        $this->db->update('TCNTCrdPmtTmp');

        if( $this->db->affected_rows() > 0 ){
            $aResult = array(
                'tCode' => '1',
                'tDesc' => 'Update Success',
            );
        }else{
            $aResult = array(
                'tCode' => '900',
                'tDesc' => 'Update Fail',
            );
        }
        return $aResult;
    }

    //Creator : 25/09/2020 Napat(Jame)
    public function FSaMPTUHDBchList($paParams){
        $nLngID         = $paParams['FNLngID'];
        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   SELECT 
                        TMP.*,
                        AGN_L.FTAgnName,
                        BCH_L.FTBchName,
                        MER_L.FTMerName,
                        SHP_L.FTShpName 
                    FROM TCNTCrdPmtTmp TMP WITH(NOLOCK)
                    LEFT JOIN TCNMAgency_L      AGN_L WITH(NOLOCK) ON TMP.FTPmhAgnTo = AGN_L.FTAgnCode AND AGN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L      BCH_L WITH(NOLOCK) ON TMP.FTPmhBchTo = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                    LEFT JOIN TCNMMerchant_L    MER_L WITH(NOLOCK) ON TMP.FTPmhMerTo = MER_L.FTMerCode AND MER_L.FNLngID = $nLngID
                    LEFT JOIN TCNMShop_L        SHP_L WITH(NOLOCK) ON TMP.FTPmhBchTo = SHP_L.FTBchCode AND TMP.FTPmhShpTo = SHP_L.FTShpCode AND SHP_L.FNLngID = $nLngID
                    WHERE TMP.FTSessionID   = '$tUserSessionID'
                      AND TMP.FTDocKey      = '$tDocKey'
                    ORDER BY TMP.FNPmdSeq ASC
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ) {
            $aResult = array(
                'nNumRow'      => $oQuery->num_rows(),
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'nNumRow'      => 0,
                'aItems'       => array(),
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    //Creator : 25/09/2020 Napat(Jame)
    //Last Update : 21/12/2020 Napat(Jame)
    public function FSaMPTUStep3AddEditHDBch($paParams){
        $tBchCode       = $paParams['tBchCode'];
        $tDocNo         = $paParams['tDocNo'];
        $nSeq           = $paParams['nSeq'];
        
        $tHDAgnCode     = $paParams['tHDAgnCode'];
        $tHDBchCode     = $paParams['tHDBchCode'];
        $tHDMerCode     = $paParams['tHDMerCode'];
        $tHDShpCode     = $paParams['tHDShpCode'];
        $tStaType       = $paParams['tStaType'];

        $tDocKey        = $paParams['tDocKey'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQLUpd = "    UPDATE TCNTCrdPmtTmp
                        SET 
                            FTPmhStaType = '$tStaType',
                            FTPmhAgnTo   = '$tHDAgnCode',
                            FTPmhBchTo   = '$tHDBchCode',
                            FTPmhMerTo   = '$tHDMerCode',
                            FTPmhShpTo   = '$tHDShpCode'
                        WHERE FTBchCode   = '$tBchCode'
                          AND FTPmhDocNo  = '$tDocNo'
                          AND FNPmdSeq    = '$nSeq'
                          AND FTDocKey    = '$tDocKey'
                          AND FTSessionID = '$tUserSessionID'
                  ";
        $this->db->query($tSQLUpd);
        if( $this->db->affected_rows() == 0 ){
            $tSQLIns = " INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTPmhAgnTo,FTPmhBchTo,
                                                    FTPmhMerTo,FTPmhShpTo,FTPmhStaType,FTDocKey,FTSessionID)
                         SELECT
                            '$tBchCode'         AS FTBchCode,
                            '$tDocNo'           AS FTPmhDocNo,
                            (SELECT ISNULL(MAX(FNPmdSeq),0) + 1 AS FNPmdSeq FROM TCNTCrdPmtTmp WHERE FTBchCode = '$tBchCode' AND FTPmhDocNo = '$tDocNo' AND FTSessionID = '$tUserSessionID' AND FTDocKey = '$tDocKey') AS FNPmdSeq,
                            '$tHDAgnCode'       AS FTPmhAgnTo,
                            '$tHDBchCode'       AS FTPmhBchTo,
                            '$tHDMerCode'       AS FTPmhMerTo,
                            '$tHDShpCode'       AS FTPmhShpTo,
                            '$tStaType'         AS FTPmhStaType,
                            '$tDocKey'          AS FTDocKey,
                            '$tUserSessionID'   AS FTSessionID
                       ";
            $this->db->query($tSQLIns);
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tSQL'  => $tSQLIns,
                    'tCode' => '1',
                    'tDesc' => 'Insert Success',
                );
            }else{
                $aResult = array(
                    'tSQL'  => $tSQLIns,
                    'tCode' => '900',
                    'tDesc' => 'Insert Error',
                );
            }
        }else{
            $aResult = array(
                'tSQL'  => $tSQLUpd,
                'tCode' => '1',
                'tDesc' => 'Update Success',
            );
        }
        return $aResult;
    }

    //Creator : 25/09/2020 Napat(Jame)
    //Last Update : 21/12/2020 Napat(Jame) left join เพิ่ม TCNMAgency_L
    public function FSaMPTUStep4CheckAndConfirm($paParams){
        $nLngID         = $paParams['FNLngID'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQL = "   SELECT 
                        TMP.*,
                        AGN_L.FTAgnName,
                        BCH_L.FTBchName,
                        MER_L.FTMerName,
                        SHP_L.FTShpName,
                        COP_L.FTCpnName AS FTPmcRefInName,
                        CTY_L.FTCtyName
                    FROM TCNTCrdPmtTmp TMP WITH(NOLOCK)
                    LEFT JOIN TCNMAgency_L      AGN_L WITH(NOLOCK) ON TMP.FTPmhAgnTo = AGN_L.FTAgnCode  AND AGN_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L      BCH_L WITH(NOLOCK) ON TMP.FTPmhBchTo = BCH_L.FTBchCode  AND BCH_L.FNLngID = $nLngID
                    LEFT JOIN TCNMMerchant_L    MER_L WITH(NOLOCK) ON TMP.FTPmhMerTo = MER_L.FTMerCode  AND MER_L.FNLngID = $nLngID
                    LEFT JOIN TCNMShop_L        SHP_L WITH(NOLOCK) ON TMP.FTPmhBchTo = SHP_L.FTBchCode  AND TMP.FTPmhShpTo = SHP_L.FTShpCode AND SHP_L.FNLngID = $nLngID
                    LEFT JOIN TFNTCouponHD_L    COP_L WITH(NOLOCK) ON TMP.FTPmcRefIn = COP_L.FTCphDocNo AND COP_L.FNLngID = $nLngID
                    LEFT JOIN TFNMCardType_L    CTY_L WITH(NOLOCK) ON TMP.FTCtyCode  = CTY_L.FTCtyCode  AND CTY_L.FNLngID = $nLngID
                    WHERE TMP.FTSessionID = '$tUserSessionID'
                    ORDER BY TMP.FNPmdSeq ASC
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ) {
            $aResult = array(
                'aItems'       => $oQuery->result_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'aItems'       => array(),
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSaMEventAddUpdateHD($paMain,$paParams){

        $this->db->where('FTPmhDocNo', $paMain['FTPmhDocNo']);
        $this->db->update('TFNTCrdPmtHD', $paParams);
        if( $this->db->affected_rows() > 0 ){
            $aResult = array(
                'tCode' => '1',
                'tDesc' => 'Update Success',
            );
        }else{
            $aInsertData  = $paMain + $paParams;
            $this->db->insert('TFNTCrdPmtHD', $aInsertData);
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tCode' => '1',
                    'tDesc' => 'Insert TFNTCrdPmtHD Success',
                );
            }else{
                $aResult = array(
                    'tCode' => '900',
                    'tDesc' => 'Insert TFNTCrdPmtHD Unsuccess',
                );
            }
        }
        return $aResult;
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSaMEventAddUpdateHD_L($paMain,$paParams){
        $nLangEdit = $this->session->userdata("tLangEdit");
        
        $this->db->where('FTPmhDocNo', $paMain['FTPmhDocNo']);
        $this->db->where('FNLngID', $nLangEdit);
        $this->db->update('TFNTCrdPmtHD_L', $paParams);
        if( $this->db->affected_rows() > 0 ){
            $aResult = array(
                'tCode' => '1',
                'tDesc' => 'Update Success',
            );
        }else{
            $aInsertData  = $paMain + $paParams;
            $this->db->insert('TFNTCrdPmtHD_L', $aInsertData);
            if( $this->db->affected_rows() > 0 ){
                $aResult = array(
                    'tCode' => '1',
                    'tDesc' => 'Insert TFNTCrdPmtHD_L Success',
                );
            }else{
                $aResult = array(
                    'tCode' => '900',
                    'tDesc' => 'Insert TFNTCrdPmtHD_L Unsuccess',
                );
            }
        }
        return $aResult;
    }

    //Creator : 28/09/2020 Napat(Jame)
    //Last Update : 21/12/2020 Napat(Jame) เพิ่มฟิวส์ฺ TFNTCrdPmtHDBch.FTPmhAgnTo
    public function FSxMEventMoveTempToMaster($paMain,$paParams,$ptDocType){
        switch($ptDocType){
            case 'TFNTCrdPmtDT':
                $tSQLIns = " INSERT INTO $ptDocType (FTBchCode,FTPmhDocNo,FNPmdSeq,FTCtyCode,FTPmdStaType) ";
                $tSQLSel = " SELECT FTBchCode,'$paMain[FTPmhDocNo]',ROW_NUMBER() OVER(ORDER BY FNPmdSeq ASC),FTCtyCode,FTPmdStaType ";
                break;
            case 'TFNTCrdPmtCD':
                $tSQLIns = " INSERT INTO $ptDocType (FTBchCode,FTPmhDocNo,FNPmcSeq,FTPmcRefIn,FTPmcRefEx,FCPmcAmtPay,FCPmcAmtGet) ";
                $tSQLSel = " SELECT FTBchCode,'$paMain[FTPmhDocNo]',ROW_NUMBER() OVER(ORDER BY FNPmdSeq ASC),FTPmcRefIn,FTPmcRefEx,FCPmcAmtPay,FCPmcAmtGet ";
                break;
            case 'TFNTCrdPmtHDBch':
                $tSQLIns = " INSERT INTO $ptDocType (FTBchCode,FTPmhDocNo,FTPmhAgnTo,FTPmhBchTo,FTPmhMerTo,FTPmhShpTo,FTPmhStaType) ";
                $tSQLSel = " SELECT FTBchCode,'$paMain[FTPmhDocNo]',FTPmhAgnTo,FTPmhBchTo,FTPmhMerTo,FTPmhShpTo,FTPmhStaType ";
                break;
        }

        $tSQLFrm  = "   FROM TCNTCrdPmtTmp WITH(NOLOCK)
                        WHERE FTSessionID   = '$paParams[tUserSessionID]' 
                            AND FTBchCode   = '$paMain[FTBchCode]'
                            AND FTDocKey    = '$ptDocType'
                        ORDER BY FNPmdSeq ASC
                    ";

        $tSQL = $tSQLIns . $tSQLSel . $tSQLFrm;
        $this->db->query($tSQL);
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSaMPTUEventGetHD($paParams){
        $nLngID = $paParams['FNLngID'];
        $tDocNo = $paParams['tDocNo'];

        $tSQL = "   SELECT 
                        HD_L.FTPmhName,
                        HD_L.FTPmhNameSlip,
                        BCH_L.FTBchName,
                        CONVERT(CHAR(5), HD.FDPmhDocDate, 108)  AS FTPmhDocTime,
                        USRAPV.FTUsrName                        AS FTUsrNameApv,
                        USR_L.FTUsrName                         AS FTCreateByName,
                        HD.* 
                    FROM TFNTCrdPmtHD HD WITH(NOLOCK)
                    LEFT JOIN TFNTCrdPmtHD_L    HD_L    WITH(NOLOCK) ON HD.FTPmhDocNo = HD_L.FTPmhDocNo AND HD_L.FNLngID = $nLngID
                    LEFT JOIN TCNMBranch_L      BCH_L   WITH(NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L        USR_L   WITH(NOLOCK) ON HD.FTCreateBy = USR_L.FTUsrCode AND USR_L.FNLngID = $nLngID
                    LEFT JOIN TCNMUser_L        USRAPV  WITH(NOLOCK) ON HD.FTPmhUsrApv = USRAPV.FTUsrCode AND USRAPV.FNLngID = $nLngID
                    WHERE HD.FTPmhDocNo = '$tDocNo'
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 0 ) {
            $aResult = array(
                'aItems'       => $oQuery->row_array(),
                'tCode'        => '1',
                'tDesc'        => 'success',
            );
        } else {
            $aResult = array(
                'aItems'       => array(),
                'tCode'        => '800',
                'tDesc'        => 'data not found',
            );
        }
        return $aResult;
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSxMPTUEventMoveMasterToTmp($paParams){
        $tDocNo         = $paParams['tDocNo'];
        $tUserSessionID = $paParams['tUserSessionID'];

        $tSQLDT = " INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTCtyCode,FTPmdStaType,FTDocKey,FTSessionID)
                    SELECT FTBchCode,FTPmhDocNo,FNPmdSeq,FTCtyCode,FTPmdStaType,'TFNTCrdPmtDT','$tUserSessionID' 
                    FROM TFNTCrdPmtDT WITH(NOLOCK)
                    WHERE FTPmhDocNo = '$tDocNo'
                  ";
        $this->db->query($tSQLDT);

        $tSQLCD = " INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTPmcRefIn,FTPmcRefEx,FCPmcAmtPay,FCPmcAmtGet,FTDocKey,FTSessionID)
                    SELECT FTBchCode,FTPmhDocNo,FNPmcSeq,FTPmcRefIn,FTPmcRefEx,FCPmcAmtPay,FCPmcAmtGet,'TFNTCrdPmtCD','$tUserSessionID' 
                    FROM TFNTCrdPmtCD WITH(NOLOCK)
                    WHERE FTPmhDocNo = '$tDocNo'
                  ";
        $this->db->query($tSQLCD);

        $tSQLHDBch = "  INSERT INTO TCNTCrdPmtTmp (FTBchCode,FTPmhDocNo,FNPmdSeq,FTPmhAgnTo,FTPmhBchTo,FTPmhMerTo,FTPmhShpTo,FTPmhStaType,FTDocKey,FTSessionID)
                        SELECT FTBchCode,FTPmhDocNo,ROW_NUMBER() OVER(ORDER BY FTPmhStaType ASC),FTPmhAgnTo,FTPmhBchTo,FTPmhMerTo,FTPmhShpTo,FTPmhStaType,'TFNTCrdPmtHDBch','$tUserSessionID' 
                        FROM TFNTCrdPmtHDBch WITH(NOLOCK)
                        WHERE FTPmhDocNo = '$tDocNo'
                     ";
        $this->db->query($tSQLHDBch);
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSxMPTUEventClearInMaster($ptDocNo){
        $this->db->where('FTPmhDocNo', $ptDocNo);
        $this->db->delete('TFNTCrdPmtDT');

        $this->db->where('FTPmhDocNo', $ptDocNo);
        $this->db->delete('TFNTCrdPmtCD');

        $this->db->where('FTPmhDocNo', $ptDocNo);
        $this->db->delete('TFNTCrdPmtHDBch');
    }

    //Creator : 29/09/2020 Napat(Jame)
    public function FSaMPTUEventCancelDoc($paParams){
        $this->db->trans_begin();
        $this->db->set('FTPmhStaDoc', $paParams['tStaDoc']);
        $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
        $this->db->update('TFNTCrdPmtHD');
        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Cancel Success',
            );
        } else {
            $this->db->trans_rollback();
            $aStatus = array(
                'tCode' => '903',
                'tDesc' => 'Cancel Fail',
            );
        }
        return $aStatus;
    }

    //Creator : 30/09/2020 Napat(Jame)
    public function FSxMEventUpdateRefEx($paMain,$paParams){
        $this->db->trans_begin();
        $nRefExAutoGen = rand(10000,99999);

        $tSQL = " UPDATE TCNTCrdPmtTmp 
                  SET FTPmcRefEx = '$paMain[FTPmhDocNo]' + CONVERT(varchar,($nRefExAutoGen + FNPmdSeq))
                  WHERE FTSessionID = '$paParams[tUserSessionID]' 
                    AND FTDocKey = 'TFNTCrdPmtCD' 
                    AND ISNULL(FTPmcRefEx,'') = ''
                ";
        $this->db->query($tSQL);

        if ($this->db->affected_rows() > 0) {
            $this->db->trans_commit();
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'update Success',
            );
        } else {
            $this->db->trans_rollback();
            $aStatus = array(
                'tCode' => '903',
                'tDesc' => 'update Fail',
            );
        }
        return $aStatus;
    }

    //Creator : 01/10/2020 Napat(Jame)
    public function FSaMPTUEventDocApprove($paParams){
        try {
            $this->db->set('FTPmhStaApv', '1');
            $this->db->set('FTPmhStaPrcDoc', '1');
            $this->db->set('FTPmhUsrApv', $paParams['tApvCode']);
            $this->db->where('FTPmhDocNo', $paParams['tDocNo']);
            $this->db->update('TFNTCrdPmtHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'tCode' => '1',
                    'tDesc' => 'Approve Success',
                );
            } else {
                $aStatus = array(
                    'tCode' => '903',
                    'tDesc' => 'Approve Fail',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //Creator : 01/10/2020 Napat(Jame)
    public function FSxMEventUpdateDocTypeHD($paMain){
        $tSQL = "   SELECT DISTINCT
                        CASE 
                            WHEN FTPmcRefIn IS NOT NULL AND FCPmcAmtGet > 0 THEN '3'
                            WHEN FTPmcRefIn IS NOT NULL AND FCPmcAmtGet = 0 THEN '2'
                        ELSE '1' END AS FTPmhDocType
                    FROM TFNTCrdPmtCD WITH(NOLOCK)
                    WHERE FTPmhDocNo = '$paMain[FTPmhDocNo]'
                ";
        $oQuery = $this->db->query($tSQL);
        if ( $oQuery->num_rows() > 1 ) {
            $this->db->set('FTPmhDocType', '3');
            $this->db->where('FTPmhDocNo', $paMain['FTPmhDocNo']);
            $this->db->update('TFNTCrdPmtHD');
        } else {
            $this->db->set('FTPmhDocType', $oQuery->row_array()['FTPmhDocType'] );
            $this->db->where('FTPmhDocNo', $paMain['FTPmhDocNo']);
            $this->db->update('TFNTCrdPmtHD');
        }
    }

    //Creator : 30/12/2020 Napat(Jame)
    public function FSxMPTUEventChangeBchInTemp($paData){
        $aChangeBchParams = array(
            'tDocNo'        => 'PTUTEMP',
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
            'tBchCode'      => $this->input->post('tBchCode')
        );
        $this->db->set('FTBchCode', $paData['tBchCode']);
        $this->db->where('FTSessionID', $paData['tSessionID']);
        $this->db->where('FTPmhDocNo', $paData['tDocNo']);
        $this->db->update('TCNTCrdPmtTmp');
    }

}
?>