<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mTransferwarehouseout extends CI_Model
{

    //Data List
    public function FSaMTWOList($paData)
    {

        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $nDocType   = $paData['nTWODocType'];


        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC, FTXthDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                TWO.FTBchCode,
                                BCHL.FTBchName,
                                TWO.FTXthDocNo,
                                CONVERT(CHAR(10),TWO.FDXthDocDate,103)   AS FDXthDocDate,
                                TWO.FTXthStaDoc,
                                TWO.FTXthStaApv,
                                TWO.FTXthStaPrcStk,
                                TWO.FTCreateBy,
                                TWO.FDCreateOn,
                                USRL.FTUsrName AS FTCreateByName,
                                TWO.FTXthApvCode,
                                USRLAPV.FTUsrName AS FTXthApvName,
                                CASE WHEN ISNULL(HD_DocRef.FTXthDocNo,'') = '' THEN '1' ELSE '2' END AS FTRefAlwDel
                            FROM [TCNTPdtTwoHD] TWO WITH (NOLOCK)
                            LEFT JOIN (SELECT DISTINCT FTXthDocNo FROM TCNTPdtTwoHDDocRef WITH (NOLOCK) WHERE FTXthRefType = '2') HD_DocRef ON HD_DocRef.FTXthDocNo = TWO.FTXthDocNo 
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON TWO.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON TWO.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON TWO.FTXthApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID 
                            WHERE TWO.FNXthDocType='$nDocType' ";

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if (@$tSearchList != '') {
            $tSQL .= " AND ((TWO.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TWO.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }
        if ($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP') {
            $tBCH = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND  TWO.FTBchCode IN ($tBCH) ";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        // if(!empty($this->session->userdata ("tSesUsrBchCodeDefault"))){
        //     $tBchCode = $this->session->userdata ("tSesUsrBchCodeDefault");
        //      $tSQL .=" AND (TWO.FTBchCode ='$tBchCode')";
        //  }


        // if(!empty($this->session->userdata ("tSesUsrShpCode"))){
        //    $tShpCode = $this->session->userdata ("tSesUsrShpCode");
        //     $tSQL .=" AND (TWO.FTXthShopFrm ='$tShpCode')";
        // }
        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((TWO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        // $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        // if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
        //     if($tSearchStaDoc == 2){
        //         $tSQL .= " AND TWO.FTXthStaDoc = '$tSearchStaDoc' OR TWO.FTXthStaDoc = ''";
        //     }else{
        //         $tSQL .= " AND TWO.FTXthStaDoc = '$tSearchStaDoc'";
        //     }
        // }
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND TWO.FTXthStaDoc = '$tSearchStaDoc'";
            } else if ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(TWO.FTXthStaApv,'') = '' AND TWO.FTXthStaDoc != '3'";
            } else if ($tSearchStaDoc == 1) {
                $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
        //     if($tSearchStaApprove == 2){
        //         $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaApprove' OR TWO.FTXthStaApv = '' ";
        //     }else{
        //         $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaApprove'";
        //     }
        // }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {

            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (TWO.FTXthStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(TWO.FTXthStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND TWO.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        /*สถานะความคลื่อนไหว*/
        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 2) {
                $tSQL .= " AND TWO.FNXthStaDocAct <> '1' OR TWO.FNXthStaDocAct = NULL";
            } else if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND TWO.FNXthStaDocAct = '$tSearchStaDocAct'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";


        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSnMTWOGetPageAll($paData);
            // print_r($aFoundRow);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        } else {
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Count Page
    public function FSnMTWOGetPageAll($paData)
    {
        $nDocType   = $paData['nTWODocType'];
        $nLngID     = $paData['FNLngID'];
        $tSQL   = "SELECT COUNT (TWO.FTXthDocNo) AS counts
                    FROM [TCNTPdtTwoHD] TWO WITH (NOLOCK) 
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON TWO.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                    WHERE 1=1  AND  TWO.FNXthDocType='$nDocType' ";

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if (@$tSearchList != '') {
            $tSQL .= " AND ((TWO.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (TWO.FDXthDocDate LIKE '%$tSearchList%'))";
        }

        // /*จากสาขา - ถึงสาขา*/
        // $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        // $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        // if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
        //     $tSQL .= " AND ((TWO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        // }

        // if(!empty($this->session->userdata ("tSesUsrBchCode"))){
        //     $tBchCode = $this->session->userdata ("tSesUsrBchCode");
        //      $tSQL .=" AND (TWO.FTBchCode ='$tBchCode')";
        //  }

        if ($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP') {
            $tBCH = $this->session->userdata("tSesUsrBchCodeMulti");
            $tSQL .= " AND  TWO.FTBchCode IN ($tBCH) ";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if (!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)) {
            $tSQL .= " AND ((TWO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TWO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }


        // if(!empty($this->session->userdata ("tSesUsrShpCode"))){
        //    $tShpCode = $this->session->userdata ("tSesUsrShpCode");
        //     $tSQL .=" AND (TWO.FTXthShopFrm ='$tShpCode')";
        // }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if (!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)) {
            $tSQL .= " AND ((TWO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TWO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        // $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        // if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
        //     $tSQL .= " AND TWO.FTXthStaDoc = '$tSearchStaDoc'";
        // }
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if (!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")) {
            if ($tSearchStaDoc == 3) {
                $tSQL .= " AND TWO.FTXthStaDoc = '$tSearchStaDoc'";
            } else if ($tSearchStaDoc == 2) {
                $tSQL .= " AND ISNULL(TWO.FTXthStaApv,'') = '' AND TWO.FTXthStaDoc != '3'";
            } else if ($tSearchStaDoc == 1) {
                $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        // $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        // if (!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")) {
        //     if ($tSearchStaApprove == 2) {
        //         $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaApprove' OR TWO.FTXthStaApv = '' ";
        //     } else {
        //         $tSQL .= " AND TWO.FTXthStaApv = '$tSearchStaApprove'";
        //     }
        // }

        /*สถานะประมวลผล*/
        $tSearchStaPrcStk = $aAdvanceSearch['tSearchStaPrcStk'];
        if (!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")) {
            if ($tSearchStaPrcStk == 3) {
                $tSQL .= " AND (TWO.FTXthStaPrcStk = '$tSearchStaPrcStk' OR ISNULL(TWO.FTXthStaPrcStk,'') = '') ";
            } else {
                $tSQL .= " AND TWO.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSearchStaDocAct = $aAdvanceSearch['tSearchStaDocAct'];
        if (!empty($tSearchStaDocAct) && ($tSearchStaDocAct != "0")) {
            if ($tSearchStaDocAct == 2) {
                $tSQL .= " AND TWO.FNXthStaDocAct <> '1' OR TWO.FNXthStaDocAct = NULL";
            } else if ($tSearchStaDocAct == 1) {
                $tSQL .= " AND TWO.FNXthStaDocAct = '$tSearchStaDocAct'";
            }
        }

        // print_r($tSQL);

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            //No Data
            return false;
        }
    }

    //Clear Tmp
    public function FSxMTWOClearPdtInTmp($ptTblSelectData)
    {
        $tXthDocKey     = $ptTblSelectData;
        $tSessionID     = $this->session->userdata('tSesSessionID');
        $this->db->where_in('FTXthDocKey', $tXthDocKey);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTTmp');

        $this->db->where_in('FTXthDocKey', $tXthDocKey);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocDTFhnTmp');

        $this->db->where_in('FTXthDocKey', $tXthDocKey);
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocHDRefTmp');
    }

    //Get Shop Code From User Login
    public function FSaMASTGetShpCodeForUsrLogin($paDataShp)
    {
        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];
        $tSQL       = " SELECT
                            UGP.FTBchCode,
                            BCHL.FTBchName,
                            MCHL.FTMerCode,
                            MCHL.FTMerName,
                            UGP.FTShpCode,
                            SHPL.FTShpName,
                            SHP.FTShpType,
                            SHP.FTWahCode   AS FTWahCode,
                            WAHL.FTWahName  AS FTWahName
                        FROM TCNTUsrGroup UGP           WITH (NOLOCK)
                        LEFT JOIN TCNMBranch BCH        WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
                        LEFT JOIN TCNMBranch_L BCHL     WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop SHP          WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
                        LEFT JOIN TCNMShop_L  SHPL      WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant_L MCHL   WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L WAHL    WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode
                        WHERE FTUsrCode ='$tUsrLogin' ";


        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = $oQuery->row_array();
        } else {
            $aResult    = "";
        }
        unset($oQuery);
        return $aResult;
    }

    //Get Data In Doc DT Temp
    public function FSaMTWOGetDocDTTempListPage($paDataWhere)
    {
        $tTWODocNo           = $paDataWhere['FTXthDocNo'];
        $tTWODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable  = $paDataWhere['tSearchPdtAdvTable'];
        $tTWOSesSessionID    = $this->session->userdata('tSesSessionID');

        $aRowLen    = FCNaHCallLenData($paDataWhere['nRow'], $paDataWhere['nPage']);
        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM (
                                SELECT
                                    DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    DOCTMP.FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTPdtCode,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FCXtdFactor,
                                    DOCTMP.FCXtdQty,
                                    DOCTMP.FCXtdSetPrice,
                                    DOCTMP.FCXtdAmtB4DisChg,
                                    DOCTMP.FTXtdDisChgTxt,
                                    DOCTMP.FCXtdNet,
                                    DOCTMP.FCXtdNetAfHD,
                                    DOCTMP.FTXtdStaAlwDis,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy,
                                    DOCTMP.FCXtdAmt,
                                    DOCTMP.FTTmpStatus
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1
                                AND DOCTMP.FTXthDocNo  = '$tTWODocNo'
                                AND DOCTMP.FTXthDocKey = '$tTWODocKey'
                                AND DOCTMP.FTSessionID = '$tTWOSesSessionID'
                                AND DOCTMP.FTCabNameForTWXVD IS NULL ";

        if (isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)) {
            $tSQL   .=  "   AND (
                                DOCTMP.FTPdtCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdPdtName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTXtdBarCode COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%'
                                OR DOCTMP.FTPunName COLLATE THAI_BIN LIKE '%$tSearchPdtAdvTable%' )
                        ";
        }
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMTWOGetDocDTTempListPageAll($paDataWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1') ? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow / $paDataWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }

    //Count All Documeny DT Temp
    public function FSaMTWOGetDocDTTempListPageAll($paDataWhere)
    {
        $tTWODocNo           = $paDataWhere['FTXthDocNo'];
        $tTWODocKey          = $paDataWhere['FTXthDocKey'];
        $tSearchPdtAdvTable = $paDataWhere['tSearchPdtAdvTable'];
        $tTWOSesSessionID    = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP
                    WHERE 1 = 1 ";

        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTWODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTWODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTWOSesSessionID' ";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";

        if (isset($tSearchPdtAdvTable) && !empty($tSearchPdtAdvTable)) {
            $tSQL   .= " AND ( DOCTMP.FTPdtCode LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTXtdPdtName LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTPunName    LIKE '%$tSearchPdtAdvTable%' ";
            $tSQL   .= " OR DOCTMP.FTXtdBarCode LIKE '%$tSearchPdtAdvTable%' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        } else {
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    //Sum Amount DT Temp
    public function FSaMTWOSumDocDTTemp($paDataWhere)
    {
        $tTWODocNo           = $paDataWhere['FTXthDocNo'];
        $tTWODocKey          = $paDataWhere['FTXthDocKey'];
        $tTWOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL               = " SELECT
                                    SUM(FCXtdNetAfHD)       AS FCXtdSumNetAfHD,
                                    SUM(FCXtdAmtB4DisChg)   AS FCXtdSumAmtB4DisChg
                                FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                                WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTWODocNo' ";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTWODocKey' ";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTWOSesSessionID' ";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = $oQuery->row_array();
            $aDataReturn    =  array(
                'raDataSum' => $aResult,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Sum Empty',
            );
        }
        unset($oQuery);
        unset($aResult);
        return $aDataReturn;
    }

    //หาราคา Price จากสินค้า
    public function FSaMTWOGetPriceBYPDT($ptCode)
    {
        $tSQL           = "SELECT TOP 1 FTCmpWhsInOrEx FROM TCNMComp";
        $oQuery         = $this->db->query($tSQL);
        $oList          = $oQuery->result_array();
        $nVat           = $oList[0]['FTCmpWhsInOrEx'];

        $FNLngID        = $this->session->userdata("tLangEdit");
        $FTPdtCode      = $ptCode;
        $tVatInorEx     = $nVat;

        $tSQL =  "SELECT P.*,PUNL.FTPunName,";
        if ($tVatInorEx == 1) {
            $tSQL .= " ISNULL(CAVG.FCPdtCostEx    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
        } else if ($tVatInorEx == 2) {
            $tSQL .= " ISNULL(CAVG.FCPdtCostIn    * ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostAvgInorEX ,";
        }
        $tSQL .= " ISNULL(PSPL.FCSplLastPrice * ISNULL(P.FCPdtUnitFact,1),NULL) as PDTCostLastPrice,
                ISNULL(PCFF.FCPdtCostEx       *	ISNULL(P.FCPdtUnitFact,1),NULL)	as PDTCostFiFo			
                FROM(
                SELECT 
                        PDT.FTPdtCode,	
                        PBCH.FTShpCode,
                        PDT_L.FTPdtName,
                        PBCH.FTBchCode,			
                        BAR.FTBarCode,
                        BAR.FTPunCode,
                        PPS.FCPdtUnitFact,
                        PDT.FCPdtCostStd *  ISNULL(PPS.FCPdtUnitFact,1)	as PDTCostSTD,
                        PDTIMG.FTImgObj,
                        LOGSEQ.FTPlcCode
                            
                FROM TCNMPdt PDT
                LEFT JOIN TCNMPdtSpcBch PBCH  ON PDT.FTPdtCode = PBCH.FTPdtCode  
                LEFT JOIN TCNMPdtBar BAR ON BAR.FTPdtCode = PDT.FTPdtCode
                LEFT JOIN  TCNTPdtLocSeq  LOGSEQ  ON BAR.FTBarCode   = LOGSEQ.FTBarCode
                LEFT JOIN TCNMPdt_L PDT_L ON PDT.FTPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = '$FNLngID'
                INNER JOIN TCNMPdtPackSize PPS ON PDT.FTPdtCode = PPS.FTPdtCode AND BAR.FTPunCode = PPS.FTPunCode 
                LEFT JOIN TCNMImgPdt PDTIMG ON PDT.FTPdtCode = PDTIMG.FTImgRefID AND PDTIMG.FTImgTable = 'TCNMPdt' AND PDTIMG.FTImgKey = 'master' AND PDTIMG.FNImgSeq = '1'
                WHERE PDT.FTPdtCode = '$FTPdtCode'
                ) P
                LEFT JOIN TCNMPdtUnit_L PUNL ON P.FTPunCode = PUNL.FTPunCode  AND PUNL.FNLngID = '$FNLngID'
                LEFT JOIN  TCNMPdtCostAvg CAVG	ON CAVG.FTPdtCode = P.FTPdtCode
                LEFT JOIN  TCNMPdtSpl PSPL	ON PSPL.FTPdtCode = P.FTPdtCode AND PSPL.FTBarCode = P.FTBarCode
                LEFT JOIN  TCNMPdtCostFiFo PCFF	ON PCFF.FTPdtCode = P.FTPdtCode";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    //หา Max Seq From Doc DT Temp
    public function FSaMTWOGetMaxSeqDocDTTemp($paDataWhere)
    {
        $tSOBchCode         = $paDataWhere['FTBchCode'];
        $tSODocNo           = $paDataWhere['FTXthDocNo'];
        $tSODocKey          = $paDataWhere['FTXthDocKey'];
        $tSOSesSessionID    = $this->session->userdata('tSesSessionID');
        $tSQL   =   "   SELECT 
                            MAX(DOCTMP.FNXtdSeqNo) AS rnMaxSeqNo
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";
        $tSQL   .= " AND DOCTMP.FTBchCode   = '$tSOBchCode'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tSODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tSODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSOSesSessionID'";
        $tSQL   .= " AND DOCTMP.FTCabNameForTWXVD IS NULL ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail    = $oQuery->row_array();
            $nResult    = $aDetail['rnMaxSeqNo'];
        } else {
            $nResult    = 0;
        }
        return empty($nResult) ? 0 : $nResult;
    }

    //หาข้อมูล PDT
    public function FSaMTWOGetDataPdt($paDataPdtParams)
    {
        $tPdtCode   = $paDataPdtParams['tPdtCode'];
        $FTPunCode  = $paDataPdtParams['tPunCode'];
        $FTBarCode  = $paDataPdtParams['tBarCode'];
        $nLngID     = $paDataPdtParams['nLngID'];
        $tSQL       = " SELECT
                            PDT.FTPdtCode,
                            PDT.FTPdtStkControl,
                            PDT.FTPdtGrpControl,
                            PDT.FTPdtForSystem,
                            PDT.FCPdtQtyOrdBuy,
                            PDT.FCPdtCostDef,
                            PDT.FCPdtCostOth,
                            PDT.FCPdtCostStd,
                            PDT.FCPdtMin,
                            PDT.FCPdtMax,
                            PDT.FTPdtPoint,
                            PDT.FCPdtPointTime,
                            PDT.FTPdtType,
                            PDT.FTPdtSaleType,
                            ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FTPdtSalePrice,
                            PDT.FTPdtSetOrSN,
                            PDT.FTPdtStaSetPri,
                            PDT.FTPdtStaSetShwDT,
                            PDT.FTPdtStaAlwDis,
                            PDT.FTPdtStaAlwReturn,
                            PDT.FTPdtStaVatBuy,
                            PDT.FTPdtStaVat,
                            PDT.FTPdtStaActive,
                            PDT.FTPdtStaAlwReCalOpt,
                            PDT.FTPdtStaCsm,
                            PDT.FTTcgCode,
                            PDT.FTPtyCode,
                            PDT.FTPbnCode,
                            PDT.FTPmoCode,
                            PDT.FTVatCode,
                            PDT.FDPdtSaleStart,
                            PDT.FDPdtSaleStop,
                            PDTL.FTPdtName,
                            PDTL.FTPdtNameOth,
                            PDTL.FTPdtNameABB,
                            PDTL.FTPdtRmk,
                            PKS.FTPunCode,
                            PKS.FCPdtUnitFact,
                            VAT.FCVatRate,
                            UNTL.FTPunName,
                            BAR.FTBarCode,
                            BAR.FTPlcCode,
                            PDTLOCL.FTPlcName,
                            PDTSRL.FTSrnCode,
                            PDT.FCPdtCostStd,
                            CAVG.FCPdtCostEx,
                            CAVG.FCPdtCostIn,
                            SPL.FCSplLastPrice
                        FROM TCNMPdt PDT WITH (NOLOCK)
                        LEFT JOIN TCNMPdt_L PDTL        WITH (NOLOCK)   ON PDT.FTPdtCode      = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtPackSize  PKS  WITH (NOLOCK)   ON PDT.FTPdtCode      = PKS.FTPdtCode     AND PKS.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtUnit_L UNTL    WITH (NOLOCK)   ON UNTL.FTPunCode     = '$FTPunCode'      AND UNTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtBar BAR        WITH (NOLOCK)   ON PKS.FTPdtCode      = BAR.FTPdtCode     AND BAR.FTPunCode   = '$FTPunCode'
                        LEFT JOIN TCNMPdtLoc_L PDTLOCL  WITH (NOLOCK)   ON PDTLOCL.FTPlcCode  = BAR.FTPlcCode     AND PDTLOCL.FNLngID = $nLngID
                        LEFT JOIN (
                            SELECT DISTINCT
                                FTVatCode,
                                FCVatRate,
                                FDVatStart
                            FROM TCNMVatRate WITH (NOLOCK)
                            WHERE CONVERT(VARCHAR(19),GETDATE(),121) > FDVatStart ) VAT
                        ON PDT.FTVatCode = VAT.FTVatCode
                        LEFT JOIN TCNTPdtSerial PDTSRL  WITH (NOLOCK)   ON PDT.FTPdtCode    = PDTSRL.FTPdtCode
                        LEFT JOIN TCNMPdtSpl SPL        WITH (NOLOCK)   ON PDT.FTPdtCode    = SPL.FTPdtCode AND BAR.FTBarCode = SPL.FTBarCode
                        LEFT JOIN TCNMPdtCostAvg CAVG   WITH (NOLOCK)   ON PDT.FTPdtCode    = CAVG.FTPdtCode
                        LEFT JOIN (
                            SELECT DISTINCT
                                P4PDT.FTPdtCode,
                                P4PDT.FTPunCode,
                                P4PDT.FDPghDStart,
                                P4PDT.FTPghTStart,
                                P4PDT.FCPgdPriceRet
                                -- P4PDT.FCPgdPriceWhs,
                                -- P4PDT.FCPgdPriceNet
                            FROM TCNTPdtPrice4PDT P4PDT WITH (NOLOCK)
                            WHERE 1=1
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121))
                            AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121))
                        ) AS PRI4PDT
                        ON PDT.FTPdtCode = PRI4PDT.FTPdtCode AND PRI4PDT.FTPunCode = PKS.FTPunCode
                        WHERE 1 = 1 ";

        if (isset($tPdtCode) && !empty($tPdtCode)) {
            $tSQL   .= " AND PDT.FTPdtCode   = '$tPdtCode'";
        }

        if (isset($FTBarCode) && !empty($FTBarCode)) {
            $tSQL   .= " AND BAR.FTBarCode = '$FTBarCode'";
        }

        $tSQL   .= " ORDER BY FDVatStart DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItem'    => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aResult;
    }

    //เพิ่มสินค้าลง Tmp
    public function FSaMTWOInsertPDTToTemp($paDataPdtMaster, $paDataPdtParams)
    {
        $paPIDataPdt    = $paDataPdtMaster['raItem'];

        // นำสินค้าเพิ่มจำนวนในแถวแรก
        $tSQL   =   "   SELECT
                            FNXtdSeqNo, 
                            FCXtdQty
                        FROM TCNTDocDTTmp
                        WHERE 1=1 
                        AND FTXthDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                        AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                        AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                        AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                        AND FTPdtCode       = '" . $paPIDataPdt["FTPdtCode"] . "'
                        AND FTXtdBarCode    = '" . $paPIDataPdt["FTBarCode"] . "'
                        ORDER BY FNXtdSeqNo";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            // เพิ่มจำนวนให้รายการที่มีอยู่แล้ว
            $aResult    = $oQuery->row_array();
            $tSQL       =   "   UPDATE TCNTDocDTTmp
                                SET FCXtdQty = '" . ($aResult["FCXtdQty"] + 1) . "' ,
                                FTCabNameForTWXVD = null
                                WHERE 1=1
                                AND FTBchCode       = '" . $paDataPdtParams['tBchCode'] . "'
                                AND FTXthDocNo      = '" . $paDataPdtParams['tDocNo'] . "'
                                AND FNXtdSeqNo      = '" . $aResult["FNXtdSeqNo"] . "'
                                AND FTXthDocKey     = '" . $paDataPdtParams['tDocKey'] . "'
                                AND FTSessionID     = '" . $paDataPdtParams['tSessionID'] . "'
                                AND FTPdtCode       = '" . $paPIDataPdt["FTPdtCode"] . "'
                                AND FTXtdBarCode    = '" . $paPIDataPdt["FTBarCode"] . "' ";
            $this->db->query($tSQL);
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Add Success.',
            );
        } else {
            // เพิ่มรายการใหม่
            $aDataInsert    = array(
                'FTBchCode'         => $paDataPdtParams['tBchCode'],
                'FTXthDocNo'        => $paDataPdtParams['tDocNo'],
                'FNXtdSeqNo'        => $paDataPdtParams['nMaxSeqNo'],
                'FTXthDocKey'       => $paDataPdtParams['tDocKey'],
                'FTPdtCode'         => $paPIDataPdt['FTPdtCode'],
                'FTXtdPdtName'      => $paPIDataPdt['FTPdtName'],
                'FCXtdFactor'       => $paPIDataPdt['FCPdtUnitFact'],
                'FTPunCode'         => $paPIDataPdt['FTPunCode'],
                'FTPunName'         => $paPIDataPdt['FTPunName'],
                'FTXtdBarCode'      => $paDataPdtParams['tBarCode'],
                'FTXtdVatType'      => $paPIDataPdt['FTPdtStaVatBuy'],
                'FTVatCode'         => $paPIDataPdt['FTVatCode'],
                'FCXtdVatRate'      => $paPIDataPdt['FCVatRate'],
                'FTXtdStaAlwDis'    => $paPIDataPdt['FTPdtStaAlwDis'],
                'FTXtdSaleType'     => $paPIDataPdt['FTPdtSaleType'],
                'FCXtdSalePrice'    => $paPIDataPdt['FTPdtSalePrice'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => 1 * $paPIDataPdt['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataPdtParams['cPrice'] * 1,

                'FTSessionID'       => $paDataPdtParams['tSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTTmpStatus'       => $paPIDataPdt['FTPdtForSystem'],
            );
            $this->db->insert('TCNTDocDTTmp', $aDataInsert);

            $this->db->last_query();
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode'    => '1',
                    'rtDesc'    => 'Add Success.',
                );
            } else {
                $aStatus = array(
                    'rtCode'    => '905',
                    'rtDesc'    => 'Error Cannot Add.',
                );
            }
        }
        return $aStatus;
    }

    //ลบเอกสาร HD - ตัวเดียว
    public function FSnMTWODelDocument($paDataDoc)
    {
        $tTWODocNo  = $paDataDoc['tTWODocNo'];

        $this->db->trans_begin();

        //กลับไปอัพเดทสินค้าใน CN
        $aPackData = array('FTXthDocNo' => $tTWODocNo);
        // $this->FSvMCheckDocumentInCN('CANCEL',$aPackData);

        // Document HD 
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->delete('TCNTPdtTwoHD');

        // Document DT
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->delete('TCNTPdtTwoDT');

        // Document DT
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->delete('TCNTPdtTwoDTFhn');

        // Document Ref
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->delete('TCNTPdtTwoHDRef');

        // Document Temp
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->where_in('FTXthDocKey', 'TCNTPdtTwoHD');
        $this->db->delete('TCNTDocDTTmp');

        // Document Temp
        $this->db->where_in('FTXthDocNo', $tTWODocNo);
        $this->db->where_in('FTXthDocKey', 'TCNTPdtTwoHD');
        $this->db->delete('TCNTDocDTFhnTmp');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStaDeleteDoc  = array(
                'rtCode'    => '905',
                'rtDesc'    => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStaDeleteDoc  = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Delete Complete.',
            );
        }
        return $aStaDeleteDoc;
    }

    //ลบสินค้า DTTmp - ตัวเดียว
    public function FSnMTWODelPdtInDTTmp($paDataWhere)
    {
        // Delete Doc DT Temp
        // $this->db->where_in('FTSessionID',$paDataWhere['tSessionID']);
        // $this->db->where_in('FTPdtCode',$paDataWhere['tPdtCode']);
        // $this->db->where_in('FNXtdSeqNo',$paDataWhere['nSeqNo']);
        // $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        // $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        // $this->db->delete('TCNTDocDTTmp');

        $this->db->set('FTCabNameForTWXVD', 'DELETE_TEMP');
        $this->db->where_in('FTSessionID', $paDataWhere['tSessionID']);
        $this->db->where_in('FTPdtCode', $paDataWhere['tPdtCode']);
        $this->db->where_in('FNXtdSeqNo', $paDataWhere['nSeqNo']);
        $this->db->where_in('FTXthDocNo', $paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode', $paDataWhere['tBchCode']);
        $this->db->update('TCNTDocDTTmp');
        return;
    }

    //ลบสินค้า DTTmp - หลายตัว
    public function FSnMTWODelMultiPdtInDTTmp($paDataWhere)
    {
        $tSessionID = $this->session->userdata('tSesSessionID');

        // Delete Doc DT Temp
        // $this->db->where_in('FTSessionID',$tSessionID);
        // $this->db->where_in('FNXtdSeqNo',$paDataWhere['aDataSeqNo']);
        // $this->db->where_in('FTPunCode',$paDataWhere['aDataPunCode']);
        // $this->db->where_in('FTPdtCode',$paDataWhere['aDataPdtCode']);
        // $this->db->where_in('FTXthDocNo',$paDataWhere['tDocNo']);
        // $this->db->where_in('FTBchCode',$paDataWhere['tBchCode']);
        // $this->db->delete('TCNTDocDTTmp');

        $this->db->set('FTCabNameForTWXVD', 'DELETE_TEMP');
        $this->db->where_in('FTSessionID', $tSessionID);
        $this->db->where_in('FTPunCode', $paDataWhere['aDataPunCode']);
        $this->db->where_in('FTPdtCode', $paDataWhere['aDataPdtCode']);
        $this->db->where_in('FNXtdSeqNo', $paDataWhere['aDataSeqNo']);
        $this->db->where_in('FTXthDocNo', $paDataWhere['tDocNo']);
        $this->db->where_in('FTBchCode', $paDataWhere['tBchCode']);
        $this->db->update('TCNTDocDTTmp');
        return;
    }

    //คำนวณค่า
    public function FSaMTWOCalInDTTemp($paParams)
    {
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        $tSQL       = " SELECT
                            /* ยอดรวม ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdNet, 0)) AS FCXphTotal,

                            /* ยอดรวมสินค้าไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNV,

                            /* ยอดรวมสินค้าห้ามลด ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 2 THEN ISNULL(DTTMP.FCXtdNet, 0) ELSE 0 END) AS FCXphTotalNoDis,

                            /* ยอมรวมสินค้าลดได้ และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXphTotalB4DisChgV,

                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                            SUM(CASE WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0) ELSE 0 END) AS FCXphTotalB4DisChgNV,

                            /* ยอดรวมหลังลด และมีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgV,

                            /* ยอดรวมหลังลด และไม่มีภาษี ==============================================================*/
                            SUM(CASE WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0) ELSE 0 END) AS FCXphTotalAfDisChgNV,

                            /* ยอดรวมเฉพาะภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวม */
                                    SUM(DTTMP.FCXtdNet)
                                    - 
                                    /* ยอดรวมสินค้าไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                                -
                                (
                                    /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                    -
                                    /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                            ) AS FCXphAmtV,

                            /* ยอดรวมเฉพาะไม่มีภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมสินค้าไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                                -
                                (
                                    /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                            ELSE 0
                                        END
                                    )
                                    -
                                    /* ยอดรวมหลังลด และไม่มีภาษี */
                                    SUM(
                                        CASE
                                            WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                            ELSE 0
                                        END
                                    )
                                )
                            ) AS FCXphAmtNV,

                            /* ยอดภาษี ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdVat, 0)) AS FCXphVat,

                            /* ยอดแยกภาษี ==============================================================*/
                            (
                                (
                                    /* ยอดรวมเฉพาะภาษี */
                                    (
                                        (
                                            /* ยอดรวม */
                                            SUM(DTTMP.FCXtdNet)
                                            - 
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และมีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 1 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                    -
                                    /* ยอดภาษี */
                                    SUM(ISNULL(DTTMP.FCXtdVat, 0))	
                                )
                                +
                                (
                                    /* ยอดรวมเฉพาะไม่มีภาษี */
                                    (
                                        (
                                            /* ยอดรวมสินค้าไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNet, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                        -
                                        (
                                            /* ยอมรวมสินค้าลดได้ และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdStaAlwDis = 1 AND DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdAmtB4DisChg, 0)
                                                    ELSE 0
                                                END
                                            )
                                            -
                                            /* ยอดรวมหลังลด และไม่มีภาษี */
                                            SUM(
                                                CASE
                                                    WHEN DTTMP.FTXtdVatType = 2 THEN ISNULL(DTTMP.FCXtdNetAfHD, 0)
                                                    ELSE 0
                                                END
                                            )
                                        )
                                    )
                                )
                            ) AS FCXphVatable,

                            /* รหัสอัตราภาษี ณ ที่จ่าย ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdWhtCode
                                FROM TCNTDocDTTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode = '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo = '$tDocNo'
                                AND DOCCONCAT.FTSessionID = '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphWpCode,

                            /* ภาษีหัก ณ ที่จ่าย ==============================================================*/
                            SUM(ISNULL(DTTMP.FCXtdWhtAmt, 0)) AS FCXphWpTax

                        FROM TCNTDocDTTmp DTTMP
                        WHERE DTTMP.FTXthDocNo  = '$tDocNo' 
                        AND DTTMP.FTXthDocKey   = '$tDocKey' 
                        AND DTTMP.FTSessionID   = '$tSessionID'
                        AND DTTMP.FTBchCode     = '$tBchCode'
                        GROUP BY DTTMP.FTSessionID ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = $oQuery->result_array();
        } else {
            $aResult    = [];
        }
        return $aResult;
    }

    //Get Cal From HDDis Temp
    public function FSaMTWOCalInHDDisTemp($paParams)
    {
        $tDocNo     = $paParams['tDocNo'];
        $tDocKey    = $paParams['tDocKey'];
        $tBchCode   = $paParams['tBchCode'];
        $tSessionID = $paParams['tSessionID'];
        $tSQL       = " SELECT
                            /* ข้อความมูลค่าลดชาร์จ ==============================================================*/
                            STUFF((
                                SELECT  ',' + DOCCONCAT.FTXtdDisChgTxt
                                FROM TCNTDocHDDisTmp DOCCONCAT
                                WHERE  1=1 
                                AND DOCCONCAT.FTBchCode 		= '$tBchCode'
                                AND DOCCONCAT.FTXthDocNo		= '$tDocNo'
                                AND DOCCONCAT.FTSessionID		= '$tSessionID'
                            FOR XML PATH('')), 1, 1, '') AS FTXphDisChgTxt,
                            /* มูลค่ารวมส่วนลด ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 1 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 2 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphDis,
                            /* มูลค่ารวมส่วนชาร์จ ==============================================================*/
                            SUM( 
                                CASE 
                                    WHEN HDDISTMP.FTXtdDisChgType = 3 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    WHEN HDDISTMP.FTXtdDisChgType = 4 THEN ISNULL(HDDISTMP.FCXtdAmt, 0)
                                    ELSE 0 
                                END
                            ) AS FCXphChg
                        FROM TCNTDocHDDisTmp HDDISTMP
                        WHERE 1=1 
                        AND HDDISTMP.FTXthDocNo     = '$tDocNo' 
                        AND HDDISTMP.FTSessionID    = '$tSessionID'
                        AND HDDISTMP.FTBchCode      = '$tBchCode'
                        GROUP BY HDDISTMP.FTSessionID ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = $oQuery->row_array();
        } else {
            $aResult    = [];
        }
        return $aResult;
    }

    //บันทึกลง HD
    public function FSxMTWOAddUpdateHD($paDataMaster, $paDataWhere, $paTableAddUpdate)
    {
        $aDataGetDataHD     =   $this->FSaMTWOGetDataDocHD(array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FNLngID'       => $this->session->userdata("tLangEdit")
        ));

        $aDataAddUpdateHD   = array();
        if (isset($aDataGetDataHD['rtCode']) && $aDataGetDataHD['rtCode'] == 1) {
            $aDataHDOld         = $aDataGetDataHD['raItems'];
            $aDataAddUpdateHD   = array_merge($paDataMaster, array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
                'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy'],
                'FDCreateOn'    => $aDataHDOld['FDCreateOn'],
                'FTCreateBy'    => $aDataHDOld['FTCreateBy']
            ));
        } else {
            $aDataAddUpdateHD   = array_merge($paDataMaster, array(
                'FTBchCode'     => $paDataWhere['FTBchCode'],
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
        }

        // Delete HD
        $this->db->where_in('FTBchCode', $aDataAddUpdateHD['FTBchCode']);
        $this->db->where_in('FTXthDocNo', $aDataAddUpdateHD['FTXthDocNo']);
        $this->db->delete($paTableAddUpdate['tTableHD']);

        // Insert HD
        $this->db->insert($paTableAddUpdate['tTableHD'], $aDataAddUpdateHD);
        return;
    }

    //เอาข้อมูล HD
    public function FSaMTWOGetDataDocHD($paDataWhere)
    {
        $tTWODocNo   = $paDataWhere['FTXthDocNo'];
        $nLngID      = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT
                            BCHL.FTBchName,
                            SHP.FTMerCode,
                            MERL.FTMerName,
                            SHP.FTShpType,
                            SHP.FTShpCode,
                            SHPL.FTShpName,
                            SHPL_T.FTShpName AS ShpNameTo,
                            POS.FTWahRefCode,
                            POSL.FTPosComName,
                            WAHL.FTWahName,
                            WAHL_T.FTWahName AS WahNameTo,
                            DPTL.FTDptName,
                            USRL.FTUsrName,
                            USRAPV.FTUsrName AS FTXphApvName,
                            SPLL.FTSplName,
                            DOCHD.FTBchCode,
                            DOCHD.FTXthDocNo,
                            DOCHD.FNXthDocType,
                            DOCHD.FTXthRsnType,
                            DOCHD.FDXthDocDate,
                            DOCHD.FTXthVATInOrEx,
                            DOCHD.FTDptCode,
                            DOCHD.FTXthMerCode,
                            DOCHD.FTXthShopFrm,
                            DOCHD.FTXthShopTo,
                            DOCHD.FTXthWhFrm,
                            DOCHD.FTXthWhTo,
                            DOCHD.FTXthPosFrm,
                            DOCHD.FTXthPosTo,
                            DOCHD.FTSplCode,
                            DOCHD.FTXthOther,
                            DOCHD.FTUsrCode,
                            DOCHD.FTSpnCode,
                            DOCHD.FTXthApvCode,
                            DOCHD.FTXthRefExt,
                            DOCHD.FDXthRefExtDate,
                            DOCHD.FTXthRefInt,
                            DOCHD.FDXthRefIntDate,
                            DOCHD.FNXthDocPrint,
                            DOCHD.FCXthTotal,
                            DOCHD.FCXthVat,
                            DOCHD.FCXthVatable,
                            DOCHD.FTXthRmk,
                            DOCHD.FTXthStaDoc,
                            DOCHD.FTXthStaApv,
                            DOCHD.FTXthStaPrcStk,
                            DOCHD.FTXthStaDelMQ,
                            DOCHD.FNXthStaDocAct,
                            DOCHD.FNXthStaRef,
                            DOCHD.FTRsnCode,
                            DOCHD.FDLastUpdOn,
                            DOCHD.FTLastUpdBy,
                            DOCHD.FDCreateOn,
                            DOCHD.FTCreateBy,
                            REA.FTRsnName
                        FROM TCNTPdtTwoHD DOCHD WITH (NOLOCK)
                        LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK)   ON DOCHD.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMShop          SHP     WITH (NOLOCK)   ON DOCHD.FTXthShopFrm   = SHP.FTShpCode
                        LEFT JOIN TCNMShop_L        SHPL    WITH (NOLOCK)   ON DOCHD.FTXthShopFrm   = SHPL.FTShpCode	AND SHPL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMShop_L        SHPL_T  WITH (NOLOCK)   ON DOCHD.FTXthShopTo    = SHPL_T.FTShpCode	AND SHPL_T.FNLngID	    = $nLngID
                        LEFT JOIN TCNMMerchant_L    MERL    WITH (NOLOCK)   ON SHP.FTMerCode        = MERL.FTMerCode	AND MERL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL    WITH (NOLOCK)   ON DOCHD.FTXthWhFrm     = WAHL.FTWahCode    AND BCHL.FTBchCode      = WAHL.FTBchCode   AND WAHL.FNLngID	    = $nLngID
                        LEFT JOIN TCNMWaHouse_L     WAHL_T  WITH (NOLOCK)   ON DOCHD.FTXthWhTo      = WAHL_T.FTWahCode	AND BCHL.FTBchCode      = WAHL_T.FTBchCode AND WAHL_T.FNLngID	    = $nLngID
                        LEFT JOIN TCNMRsn_L         REA     WITH (NOLOCK)   ON DOCHD.FTRsnCode      = REA.FTRsnCode	    AND REA.FNLngID	        = $nLngID
                        LEFT JOIN TCNMWaHouse       POS     WITH (NOLOCK)   ON DOCHD.FTXthWhTo      = POS.FTWahCode		AND BCHL.FTBchCode      = POS.FTBchCode    AND POS.FTWahStaType    = '6'
                        LEFT JOIN TCNMPosLastNo		POSL    WITH (NOLOCK)   ON POS.FTWahRefCode     = POSL.FTPosCode
                        LEFT JOIN TCNMUsrDepart_L	DPTL    WITH (NOLOCK)   ON DOCHD.FTDptCode      = DPTL.FTDptCode	AND DPTL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK)   ON DOCHD.FTUsrCode      = USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMUser_L        USRAPV	WITH (NOLOCK)   ON DOCHD.FTXthApvCode	= USRL.FTUsrCode	AND USRL.FNLngID	= $nLngID
                        LEFT JOIN TCNMSpl_L         SPLL    WITH (NOLOCK)   ON DOCHD.FTSplCode		= SPLL.FTSplCode	AND SPLL.FNLngID	= $nLngID
                        WHERE 1=1 AND DOCHD.FTXthDocNo = '$tTWODocNo' ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    //เอาข้อมูล HD
    public function FSaMTWOGetDataDocHDRef($paDataWhere, $paDataWhereAddress)
    {

        $tTWODocNo    = $paDataWhere['FTXthDocNo'];
        $nLngID       = $paDataWhere['FNLngID'];
        $nAddGrpType  = $paDataWhereAddress['FTAddGrpType'];
        $tAddRefCode  = $paDataWhereAddress['FTAddRefCode'];

        $tSQL = "SELECT
                    DOCHDR.FNXthShipAdd,
                    ADSL.FTAddName,
                    ADSL.FTAddTaxNo,
                    ADSL.FTAddRmk,
                    ADSL.FTAddCountry,
                    ADSL.FTAddVersion,
                    ADSL.FTAddV1No,
                    ADSL.FTAddV1Soi,
                    ADSL.FTAddV1Village,
                    ADSL.FTAddV1Road,
                    ADSL.FTAddV1SubDist,
                    ADSL.FTAddV1DstCode,
                    ADSL.FTAddV1PvnCode,
                    ADSL.FTAddV1PostCode,
                    ADSL.FTAddV2Desc1,
                    ADSL.FTAddV2Desc2,
                    ADSL.FTAddWebsite,
                    ADSL.FTAddLongitude,
                    ADSL.FTAddLatitude,
                    DOCHDR.FTXthCtrName,
                    DOCHDR.FTXthRefTnfID,
                    DOCHDR.FDXthTnfDate,
                    DOCHDR.FTXthRefVehID,
                    DOCHDR.FTXthQtyAndTypeUnit,
                    DOCHDR.FTViaCode,
                    PRVL.FTPvnName,
                    DSTL.FTDstName,
                    SDSTL.FTSudName
                    FROM
                    TCNTPdtTwoHDRef AS DOCHDR WITH (NOLOCK)
                    LEFT OUTER JOIN TCNMAddress_L ADSL WITH (NOLOCK) ON DOCHDR.FNXthShipAdd = ADSL.FNAddSeqNo AND ADSL.FTAddGrpType='$nAddGrpType' AND ADSL.FTAddRefCode = '$tAddRefCode' AND ADSL.FNLngID = '$nLngID'
                    LEFT OUTER JOIN TCNMProvince_L PRVL WITH (NOLOCK) ON ADSL.FTAddV1PvnCode = PRVL.FTPvnCode AND PRVL.FNLngID = '$nLngID'
                    LEFT OUTER JOIN TCNMDistrict_L DSTL WITH (NOLOCK) ON ADSL.FTAddV1DstCode = DSTL.FTDstCode AND DSTL.FNLngID = '$nLngID'
                    LEFT OUTER JOIN TCNMSubDistrict_L SDSTL WITH (NOLOCK) ON ADSL.FTAddV1SubDist = SDSTL.FTSudCode AND SDSTL.FNLngID = '$nLngID'
                    WHERE  DOCHDR.FTXthDocNo='$tTWODocNo'
            ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    //เอาข้อมูล HD
    public function FSaMTWOGetDataDocHDDocRef($paDataWhere)
    {

        $tTWODocNo    = $paDataWhere['FTXthDocNo'];

        $tSQL = "SELECT
                    DOCREF.FTXthRefType,
                    DOCREF.FTXthRefDocNo,
                    DOCREF.FDXthRefDocDate,
                    DOCREF.FTXthRefKey
                    FROM TCNTPdtTwoHDDocRef AS DOCREF WITH (NOLOCK)
                    WHERE  DOCREF.FTXthDocNo='$tTWODocNo' AND DOCREF.FTXthRefKey = 'TWO'
            ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->result();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    //Update DocNo In Doc Temp
    public function FSxMTWOAddUpdateDocNoToTemp($paDataWhere, $paTableAddUpdate)
    {
        // Update DocNo Into DTTemp
        $this->db->where('FTXthDocNo', '');
        $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey', $paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp', array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into DTTemp
        $this->db->where('FTXshDocNo', '');
        $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey', $paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTFhnTmp', array(
            'FTXshDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into HDDisTemp
        $this->db->where('FTXthDocNo', '');
        $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocHDDisTmp', array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));

        // Update DocNo Into HDRefTmp
        $this->db->where('FTXthDocNo', '');
        $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->update('TCNTDocHDRefTmp', array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
        ));
        return;
    }

    //ย้ายข้อมูลจาก DTTmp To DT
    public function FSaMTWOMoveDtTmpToDt($paDataWhere, $paTableAddUpdate)
    {
        $tTWOBchCode     = $paDataWhere['FTBchCode'];
        $tTWODocNo       = $paDataWhere['FTXthDocNo'];
        $tTWODocKey      = $paTableAddUpdate['tTableHD'];
        $tTWOSessionID   = $this->session->userdata('tSesSessionID');

        if (isset($tTWODocNo) && !empty($tTWODocNo)) {
            $this->db->where_in('FTXthDocNo', $tTWODocNo);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO " . $paTableAddUpdate['tTableDT'] . " (
                    FTBchCode , FTXthDocNo , FNXtdSeqNo , FTPdtCode , FTXtdPdtName ,
                    FTPunCode , FTPunName , FCXtdFactor , FTXtdBarCode , FTXtdVatType ,
                    FTVatCode , FCXtdVatRate , FCXtdQty , FCXtdQtyAll , FCXtdSetPrice ,
                    FCXtdAmt , FCXtdVat , FCXtdVatable , FCXtdNet , FCXtdCostIn ,
                    FCXtdCostEx , FTXtdStaPrcStk , FNXtdPdtLevel , FTXtdPdtParent ,FCXtdQtySet ,
                    FTXtdPdtStaSet , FTXtdRmk   , FDLastUpdOn ,
                    FTLastUpdBy ,FDCreateOn , FTCreateBy ) ";
        $tSQL   .=  "   SELECT
                            DOCTMP.FTBchCode,
                            DOCTMP.FTXthDocNo,
                            -- ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            DOCTMP.FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTXtdVatType,
                            DOCTMP.FTVatCode,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmt,
                            DOCTMP.FCXtdVat,
                            DOCTMP.FCXtdVatable,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdCostIn,
                            DOCTMP.FCXtdCostEx,
                            DOCTMP.FTXtdStaPrcStk,
                            DOCTMP.FNXtdPdtLevel,
                            DOCTMP.FTXtdPdtParent,
                            DOCTMP.FCXtdQtySet,
                            DOCTMP.FTXtdPdtStaSet,
                            DOCTMP.FTXtdRmk,
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1
                        AND DOCTMP.FTBchCode    = '$tTWOBchCode'
                        AND DOCTMP.FTXthDocNo   = '$tTWODocNo'
                        AND DOCTMP.FTXthDocKey  = '$tTWODocKey'
                        AND DOCTMP.FTSessionID  = '$tTWOSessionID'
                        AND DOCTMP.FTCabNameForTWXVD IS NULL
                        ORDER BY DOCTMP.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);



        return;
    }


    public function FSxMTWOAddUpdateHDRef($paTableAddUpdate, $paDataWhere)
    {

        $tTWODocNo       = $paDataWhere['FTXthDocNo'];
        $tBchCode       = $paDataWhere['FTBchCode'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo', $tTWODocNo);
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->delete('TCNTPdtTwoHDRef');

        $aDataInsert = array(
            'FTBchCode'            => $tBchCode,
            'FTXthDocNo'           => $tTWODocNo,
            'FTXthCtrName'         => $paTableAddUpdate['FTXthCtrName'],
            'FDXthTnfDate'         => $paTableAddUpdate['FDXthTnfDate'],
            'FTXthRefTnfID'        => $paTableAddUpdate['FTXthRefTnfID'],
            'FTXthRefVehID'        => $paTableAddUpdate['FTXthRefVehID'],
            'FTXthQtyAndTypeUnit'  => $paTableAddUpdate['FTXthQtyAndTypeUnit'],
            'FNXthShipAdd'         => $paTableAddUpdate['FNXthShipAdd'],
            // 'FTViaCode'            => $paTableAddUpdate['FTViaCode'],
        );
        $this->db->insert('TCNTPdtTwoHDRef', $aDataInsert);
        return;
    }

    public function FSxMTWOAddUpdateHDDocRef($paTableAddUpdate, $paDataWhere)
    {
        $tTWODocNo       = $paDataWhere['FTXthDocNo'];
        $tBchCode       = $paDataWhere['FTBchCode'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTXthDocNo', $tTWODocNo);
        $this->db->where('FTXthRefType', $paTableAddUpdate['FTXthRefType']);
        $this->db->where('FTXthRefKey', $paTableAddUpdate['FTXthRefKey']);
        $this->db->delete('TCNTPdtTwoHDDocRef');

        $aDataInsert = array(
            'FTAgnCode'        => "",
            'FTBchCode'        => $paTableAddUpdate['FTBchCode'],
            'FTXthDocNo'       => $tTWODocNo,
            'FTXthRefType'     => $paTableAddUpdate['FTXthRefType'],
            'FTXthRefDocNo'    => $paTableAddUpdate['FTXthRefDocNo'],
            'FTXthRefKey'      => $paTableAddUpdate['FTXthRefKey'],
            'FDXthRefDocDate'  => $paTableAddUpdate['FDXthRefDocDate'],
        );
        $this->db->insert('TCNTPdtTwoHDDocRef', $aDataInsert);
        return;
    }

    //ย้ายข้อมูลจาก DT To DTTmp
    public function FSxMTWOMoveDTToDTTemp($paDataWhere)
    {
        $tTWODocNo       = $paDataWhere['FTXthDocNo'];
        $tTWODocKey      = $paDataWhere['FTXthDocKey'];

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocNo', $tTWODocNo);
        $this->db->delete('TCNTDocDTTmp');

        $tSQL   = " INSERT INTO TCNTDocDTTmp (
                        FTBchCode, FTXthDocNo, FNXtdSeqNo , FTXthDocKey , FTPdtCode, 
                        FTXtdPdtName, FTPunCode, FTPunName, FCXtdFactor,
                        FTXtdBarCode, FTXtdVatType, FTVatCode, FCXtdVatRate,
                        FCXtdQty, FCXtdQtyAll, FCXtdSetPrice, FCXtdAmt,
                        FCXtdVat, FCXtdVatable, FCXtdNet, FCXtdCostIn,
                        FCXtdCostEx, FTXtdStaPrcStk, FNXtdPdtLevel, FTXtdPdtParent,
                        FCXtdQtySet, FTXtdPdtStaSet, FTXtdRmk,FTTmpStatus,
                        FTSessionID , FDLastUpdOn, FDCreateOn , FTLastUpdBy , FTCreateBy )
                    SELECT
                        DT.FTBchCode , 
                        DT.FTXthDocNo , 
                        DT.FNXtdSeqNo , 
                        CONVERT(VARCHAR,'" . $tTWODocKey . "') AS FTXthDocKey,
                        DT.FTPdtCode , 
                        DT.FTXtdPdtName ,
                        DT.FTPunCode , 
                        DT.FTPunName , 
                        DT.FCXtdFactor , 
                        DT.FTXtdBarCode , 
                        DT.FTXtdVatType ,
                        DT.FTVatCode , 
                        DT.FCXtdVatRate , 
                        DT.FCXtdQty , 
                        DT.FCXtdQtyAll , 
                        DT.FCXtdSetPrice ,
                        DT.FCXtdAmt , 
                        DT.FCXtdVat , 
                        DT.FCXtdVatable , 
                        DT.FCXtdNet , 
                        DT.FCXtdCostIn ,
                        DT.FCXtdCostEx , 
                        DT.FTXtdStaPrcStk , 
                        DT.FNXtdPdtLevel , 
                        DT.FTXtdPdtParent , 
                        DT.FCXtdQtySet ,
                        DT.FTXtdPdtStaSet , 
                        DT.FTXtdRmk , 
                        PDT.FTPdtForSystem,
                        CONVERT(VARCHAR,'" . $this->session->userdata('tSesSessionID') . "') AS FTSessionID ,
                        CONVERT(DATETIME,'" . date('Y-m-d H:i:s') . "') AS FDLastUpdOn ,
                        CONVERT(DATETIME,'" . date('Y-m-d H:i:s') . "') AS FDCreateOn ,
                        CONVERT(VARCHAR,'" . $this->session->userdata('tSesUsername') . "') AS FTLastUpdBy ,
                        CONVERT(VARCHAR,'" . $this->session->userdata('tSesUsername') . "') AS FTCreateBy
                    FROM TCNTPdtTwoDT AS DT WITH (NOLOCK)
                    LEFT JOIN TCNMPdt PDT WITH(NOLOCK) ON DT.FTPdtCode = PDT.FTPdtCode
                    WHERE 1=1 AND DT.FTXthDocNo = '$tTWODocNo'
                    ORDER BY DT.FNXtdSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        return;
    }

    //ยกเลิกเอกสาร
    public function FSvMTWOCancel($paDataUpdate)
    {
        try {
            $this->db->set('FTXthStaDoc', 3);
            $this->db->where('FTXthDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTwoHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }

    //อัพเดทข้อมูลรายเเถว
    public function FSaMTWOUpdateInlineDTTemp($paDataUpdateDT, $paDataWhere)
    {
        $this->db->set($paDataUpdateDT['tTWOFieldName'], $paDataUpdateDT['tTWOValue']);
        $this->db->where('FTSessionID', $paDataWhere['tTWOSessionID']);
        $this->db->where('FTXthDocKey', $paDataWhere['tDocKey']);
        $this->db->where('FNXtdSeqNo', $paDataWhere['nTWOSeqNo']);
        $this->db->where('FTXthDocNo', $paDataWhere['tTWODocNo']);
        $this->db->where('FTBchCode', $paDataWhere['tTWOBchCode']);
        $this->db->update('TCNTDocDTTmp');
        if ($this->db->affected_rows() > 0) {
            $aStatus = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Success',
            );
        } else {
            $aStatus = array(
                'rtCode'    => '903',
                'rtDesc'    => 'Update Fail',
            );
        }
        return $aStatus;
    }

    //ไปเอาสินค้า จากตาราง CN ใบสั้งจ่าย
    public function FSaMTWOGetPDTInCN($paDataWhere)
    {
        $tBCHCode       = $paDataWhere['tBCHCode'];
        $tSHPCode       = $paDataWhere['tSHPCode'];
        $tWAHCode       = $paDataWhere['tWAHCode'];
        $nLngID         = $paDataWhere['FNLngID'];

        $tSQL       = " SELECT 
                            row_number() over (order by CN.FTXshDocNo) as rtRowID,
                            CN.FTXshDocNo , 
                            CN.FNXsdSeqNo , 
                            CN.FTStaPrcStk ,
                            HD.FTBchCode ,
                            BACL.FTBchName ,
                            HD.FTShpCode ,
                            SHPL.FTShpName ,
                            HD.FTWahCode ,
                            WAHL.FTWahName , 
                            DT.FTPdtCode ,
                            DT.FTXsdPdtName ,
                            DT.FTPunCode ,
                            DT.FTPunName , 
                            BAR.FTBarCode
                        FROM TVDTDTCN CN 
                        LEFT JOIN TARTSoHD HD			ON HD.FTXshDocNo = CN.FTXshDocNo
                        LEFT JOIN TARTSoDT DT			ON HD.FTXshDocNo = DT.FTXshDocNo AND DT.FNXsdSeqNo = CN.FNXsdSeqNo
                        LEFT JOIN TCNMBranch_L BACL		ON HD.FTBchCode = BACL.FTBchCode AND BACL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop_L SHPL		ON HD.FTShpCode = SHPL.FTShpCode AND HD.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMWahouse_L WAHL	ON HD.FTWahCode = WAHL.FTWahCode AND HD.FTBchCode = WAHL.FTBchCode AND WAHL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtBar BAR		ON BAR.FTPdtCode = DT.FTPdtCode AND DT.FTPunCode = BAR.FTPunCode 
                        WHERE CN.FTStaPrcStk IS NULL";

        if ($tBCHCode != null || $tBCHCode != '') {
            $tSQL .= " AND HD.FTBchCode = '$tBCHCode' ";
        }

        if ($tSHPCode != null || $tSHPCode != '') {
            $tSQL .= " AND HD.FTShpCode = '$tSHPCode' ";
        }

        if ($tWAHCode != null || $tWAHCode != '') {
            $tSQL .= " AND HD.FTWahCode = '$tWAHCode' ";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }


    //อัพเดทอนุมัติ
    public function FSvMTWOApprove($paDataUpdate)
    {
        try {
            $dLastUpdOn = date('Y-m-d H:i:s');
            $tLastUpdBy = $this->session->userdata('tSesUsername');
            $this->db->set('FDLastUpdOn', $dLastUpdOn);
            $this->db->set('FTLastUpdBy', $tLastUpdBy);
            $this->db->set('FTXthStaPrcStk', 2);
            $this->db->set('FTXthStaApv', 1);
            $this->db->set('FTXthApvCode', $paDataUpdate['FTXthApvCode']);
            $this->db->where('FTXthDocNo', $paDataUpdate['FTXthDocNo']);
            $this->db->update('TCNTPdtTwoHD');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'OK',
                );
            } else {
                $aStatus = array(
                    'rtCode' => '903',
                    'rtDesc' => 'Not Approve',
                );
            }
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    // แท็บ อ้างอิงเอกสาร - โหลด
    public function FSaMTWOGetDataHDRefTmp($paData)
    {

        $tTableTmpHDRef = $paData['tTableTmpHDRef'];
        $FTXthDocNo     = $paData['FTXthDocNo'];
        $FTXthDocKey    = $paData['FTXthDocKey'];
        $FTSessionID    = $paData['FTSessionID'];

        $tSQL = "   SELECT TMP.FTXthDocNo, TMP.FTXthRefDocNo, TMP.FTXthRefType, TMP.FTXthRefKey, TMP.FDXthRefDocDate
                    FROM $tTableTmpHDRef TMP WITH(NOLOCK)
                    WHERE TMP.FTXthDocNo  = '$FTXthDocNo'
                      AND TMP.FTXthDocKey = '$FTXthDocKey'
                      AND TMP.FTSessionID = '$FTSessionID'
                    ORDER BY TMP.FDCreateOn DESC
                 ";

        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ($oQuery->num_rows() > 0) {
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        } else {
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // แท็บค่าอ้างอิงเอกสาร - เพิ่ม
    public function FSaMTWOAddEditHDRefTmp($paDataWhere, $paDataAddEdit)
    {

        $tRefDocNo = (empty($paDataWhere['tRefDocNoOld']) ? $paDataAddEdit['FTXthRefDocNo'] : $paDataWhere['tRefDocNoOld']);

        if ($paDataAddEdit['FTXthRefType'] == '1') {
            $this->db->where('FTXthRefType', '1');
            $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey', $paDataWhere['FTXthDocKey']);
            $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
            $this->db->delete('TCNTDocHDRefTmp');
        }

        $tSQL = " SELECT FTXthRefDocNo FROM TCNTDocHDRefTmp
                  WHERE FTXthDocNo    = '" . $paDataWhere['FTXthDocNo'] . "'
                    AND FTXthDocKey   = '" . $paDataWhere['FTXthDocKey'] . "'
                    AND FTSessionID   = '" . $paDataWhere['FTSessionID'] . "'
                    AND FTXthRefDocNo = '" . $tRefDocNo . "' ";
        $oQuery = $this->db->query($tSQL);
        $this->db->trans_begin();
        if ($oQuery->num_rows() > 0) {
            $this->db->where('FTXthRefDocNo', $tRefDocNo);
            $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
            $this->db->where('FTXthDocKey', $paDataWhere['FTXthDocKey']);
            $this->db->where('FTSessionID', $paDataWhere['FTSessionID']);
            $this->db->update('TCNTDocHDRefTmp', $paDataAddEdit);
        } else {
            $aDataAdd = array_merge($paDataAddEdit, array(
                'FTXthDocNo'  => $paDataWhere['FTXthDocNo'],
                'FTXthDocKey' => $paDataWhere['FTXthDocKey'],
                'FTSessionID' => $paDataWhere['FTSessionID'],
                'FDCreateOn'  => $paDataWhere['FDCreateOn'],
            ));
            $this->db->insert('TCNTDocHDRefTmp', $aDataAdd);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Add/Edit HDDocRef Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Add/Edit HDDocRef Success'
            );
        }
        return $aResult;
    }

    // แท็บ อ้างอิงเอกสาร - ลบ
    public function FSaMTWOEventDelHDDocRef($paData)
    {
        $tDocNo       = $paData['FTXthDocNo'];
        $tRefDocNo    = $paData['FTXthRefDocNo'];
        $tDocKey      = $paData['FTXthDocKey'];
        $tSessionID   = $paData['FTSessionID'];

        $this->db->where('FTSessionID', $tSessionID);
        $this->db->where('FTXthDocKey', $tDocKey);
        $this->db->where('FTXthRefDocNo', $tRefDocNo);
        $this->db->where('FTXthDocNo', $tDocNo);
        $this->db->delete('TCNTDocHDRefTmp');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => 'Delete HD Doc Ref Error'
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Delete HD Doc Ref Success'
            );
        }
        return $aResult;
    }

    //ย้ายข้อมูลจาก TempHDDocRef => ตารางจริง
    public function FSxMTWOMoveHDRefTmpToHDRef($paDataWhere)
    {
        $tBchCode     = $paDataWhere['FTBchCode'];
        $tDocNo       = $paDataWhere['FTXthDocNo'];
        $tSessionID   = $this->session->userdata('tSesSessionID');

        if (isset($tDocNo) && !empty($tDocNo)) {
            $this->db->where('FTBchCode', $tBchCode);
            $this->db->where('FTXthDocNo', $tDocNo);
            $this->db->delete('TCNTPdtTwoHDDocRef');
        }

        $tSQL   =   "   INSERT INTO TCNTPdtTwoHDDocRef (FTAgnCode, FTBchCode, FTXthDocNo, FTXthRefType, FTXthRefDocNo, FTXthRefKey, FDXthRefDocDate) ";
        $tSQL   .=  "   SELECT
                            ''          AS FTAgnCode,
                            '$tBchCode' AS FTBchCode,
                            FTXthDocNo,
                            FTXthRefType,
                            FTXthRefDocNo,
                            FTXthRefKey,
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = 'TCNTPdtTwoHD'
                          AND FTSessionID = '$tSessionID' ";
        $this->db->query($tSQL);

        // Insert ตารางใบขอโอน - สาขา
        $this->db->where('FTBchCode', $tBchCode);
        $this->db->where('FTXthRefDocNo', $tDocNo);
        $this->db->delete('TCNTPdtReqBchHDDocRef');
        // echo $this->db->last_query();
        // echo "<br>";

        $tSQL   =   "   INSERT INTO TCNTPdtReqBchHDDocRef (FTAgnCode, FTBchCode, FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate) ";
        $tSQL   .=  "   SELECT
                            ''              AS FTAgnCode,
                            '$tBchCode'     AS FTBchCode,
                            FTXthRefDocNo   AS FTXthDocNo,
                            FTXthDocNo      AS FTXthRefDocNo,
                            2               AS FTXthRefType,
                            'TWO'           AS FTXthRefKey,
                            FDXthRefDocDate
                        FROM TCNTDocHDRefTmp WITH (NOLOCK)
                        WHERE FTXthDocNo  = '$tDocNo'
                          AND FTXthDocKey = 'TCNTPdtTwoHD'
                          AND FTSessionID = '$tSessionID'
                          AND FTXthRefKey = 'TRB' ";
        $this->db->query($tSQL);
        // echo $this->db->last_query();
        // echo "<br>";

    }

    //ข้อมูล HDDocRef
    public function FSxMTWOMoveHDRefToHDRefTemp($paData)
    {

        $tDocNo         = $paData['tDocNo'];
        $tSessionID     = $this->session->userdata('tSesSessionID');

        // Delect Document DTTemp By Doc No
        $this->db->where('FTXthDocKey', 'TCNTPdtTwoHD');
        $this->db->where('FTSessionID', $tSessionID);
        $this->db->delete('TCNTDocHDRefTmp');

        $tSQL = "   INSERT INTO TCNTDocHDRefTmp (FTXthDocNo, FTXthRefDocNo, FTXthRefType, FTXthRefKey, FDXthRefDocDate, FTXthDocKey, FTSessionID , FDCreateOn)";
        $tSQL .= "  SELECT
                        FTXthDocNo,
                        FTXthRefDocNo,
                        FTXthRefType,
                        FTXthRefKey,
                        FDXthRefDocDate,
                        'TCNTPdtTwoHD' AS FTXthDocKey,
                        '$tSessionID'  AS FTSessionID,
                        CONVERT(DATETIME,'" . date('Y-m-d H:i:s') . "') AS FDCreateOn
                    FROM TCNTPdtTwoHDDocRef WITH(NOLOCK)
                    WHERE FTXthDocNo = '$tDocNo' ";
        $this->db->query($tSQL);
    }


    // ตรวจสอบ จำนวนจัดสินค้าไม่เท่ากับจำนวนสั่งสินค้า 
    public function FSaMTWOChkQtyOnPack($ptDocNo)
    {
        $tSQL = "   SELECT 
                        A.FTPdtCode 
                    FROM (
                        SELECT 
                        TWODT.FTPdtCode						AS FTPdtCode
                            ,SUM(ISNULL(ORDDT.FCXtdQtyOrd,0))	AS FCXtdQtyOrd
                            ,SUM(ISNULL(PICK.FCXtdQty,0))		AS FCXtdQtyPick
                        FROM TCNTPdtTwoHDDocRef TWO WITH(NOLOCK)
                        INNER JOIN TCNTPdtTwoDT TWODT WITH(NOLOCK) ON TWO.FTXthDocNo = TWODT.FTXthDocNo
                        LEFT JOIN (
                            SELECT PICKHD.FTXthDocNo, PICKDT.FTPdtCode, SUM(ISNULL(PICKDT.FCXtdQty,0)) AS FCXtdQty 
                            FROM TCNTPdtPickHD PICKHD WITH(NOLOCK)
                            LEFT JOIN TCNTPdtPickDT PICKDT WITH(NOLOCK) ON PICKHD.FTXthDocNo = PICKDT.FTXthDocNo
                            WHERE PICKHD.FTXthStaApv = '1'
                            GROUP BY PICKHD.FTXthDocNo, PICKDT.FTPdtCode
                        ) PICK ON TWO.FTXthRefDocNo = PICK.FTXthDocNo AND TWODT.FTPdtCode = PICK.FTPdtCode
                        LEFT JOIN (
                            SELECT FTXthDocNo,FTPdtCode, SUM(ISNULL(FCXtdQtyOrd,0)) AS FCXtdQtyOrd 
                            FROM TCNTPdtPickDT WITH(NOLOCK)
                            GROUP BY FTXthDocNo, FTPdtCode
                        ) ORDDT ON TWO.FTXthRefDocNo = ORDDT.FTXthDocNo AND TWODT.FTPdtCode = ORDDT.FTPdtCode
                        WHERE TWO.FTXthDocNo	= '$ptDocNo'
                          AND TWO.FTXthRefType	= '2'
                          AND TWO.FTXthRefKey	= 'PdtPick'
                        GROUP BY TWODT.FTPdtCode
                    ) A
                    WHERE A.FCXtdQtyOrd <> A.FCXtdQtyPick
                 ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = array(
                'tCode'    => '1',
                'tDesc'    => 'found data',
            );
        } else {
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 12/01/2022
    // ดึง Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMTWOGetConfigGenDocPack()
    {
        $tSQL = "   SELECT 
                        FTSysSeq,
                        CASE WHEN ISNULL(FTSysStaUsrValue,'') = '' THEN FTSysStaDefValue ELSE FTSysStaUsrValue END AS FTValue
                    FROM TSysConfig WITH(NOLOCK)
                    WHERE FTSysCode = 'bCN_CondSplitDoc' 
                      AND FTSysApp = 'CN' 
                      AND FTSysKey = 'TCNTPdtPickHD' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult    = array(
                'aItems'   => $oQuery->result_array(),
                'tCode'    => '1',
                'tDesc'    => 'found config',
            );
        } else {
            $aResult    = array(
                'tCode'    => '800',
                'tDesc'    => 'config not found.',
            );
        }
        return $aResult;
    }

    // Create By : Napat(Jame) 12/01/2022
    // บันทึก Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSaMTWOSaveConfigGenDocPack($ptCondWhereIn)
    {
        $this->db->trans_begin();
        if (!empty($ptCondWhereIn)) {
            // อัพเดท 1 ตัวที่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '1'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' 
                          AND FTSysSeq  IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);

            // อัพเดท 2 ตัวที่ไม่เลือกบนหน้าจอ
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' 
                          AND FTSysSeq  NOT IN ($ptCondWhereIn) ";
            $this->db->query($tSQL);
        } else {
            // กรณีไม่เลือกบนหน้าจอ ทุกรายการ ให้อัพเดท 2 ทั้งหมด
            $tSQL = "   UPDATE TSysConfig
                        SET FTSysStaUsrValue = '2'
                        WHERE FTSysCode = 'bCN_CondSplitDoc' 
                          AND FTSysApp  = 'CN' 
                          AND FTSysKey  = 'TCNTPdtPickHD' ";
            $this->db->query($tSQL);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aResult = array(
                'nStaEvent' => '800',
                'tStaMessg' => $this->db->error()['message']
            );
        } else {
            $this->db->trans_commit();
            $aResult = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Update Config Success'
            );
        }
        return $aResult;
    }
}
