<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mPurchaseorder extends CI_Model {

    //Data List
    public function FSaMDPOList($paData){

        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXphDocNo DESC) AS FNRowID,* FROM
                            (SELECT DISTINCT
                                PO.FTBchCode,
                                BCHL.FTBchName,
                                PO.FTXphDocNo,
                                CONVERT(CHAR(10), PO.FDXphDocDate,103) + ' '  + convert(VARCHAR(8), PO.FDXphDocDate, 14) AS FDXphDocDate,
                                PO.FTXphStaDoc,
                                PO.FTXphStaApv,
                                PO.FTCreateBy,
                                USRL.FTUsrName AS FTCreateByName,
                                PO.FTXphApvCode,
                                USRLAPV.FTUsrName AS FTXphApvName
                            FROM TAPTPoHD PO WITH (NOLOCK)
                            LEFT JOIN TCNMBranch_L  BCHL WITH (NOLOCK) ON PO.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRL WITH (NOLOCK) ON PO.FTCreateBy = USRL.FTUsrCode AND USRL.FNLngID = $nLngID 
                            LEFT JOIN TCNMUser_L    USRLAPV WITH (NOLOCK) ON PO.FTXphApvCode = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID 
                            WHERE 1=1 ";

        if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
            $tBCH = $this->session->userdata("tSesUsrBchCom");
            $tSQL .= " AND  PO.FTBchCode = '$tBCH' ";
        }

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((PO.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),PO.FDXphDocDate,103) LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((PO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (PO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((PO.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (PO.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND PO.FTXphStaDoc = '$tSearchStaDoc' OR PO.FTXphStaDoc = ''";
            }else{
                $tSQL .= " AND PO.FTXphStaDoc = '$tSearchStaDoc'";
            }
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND PO.FTXphStaApv = '$tSearchStaApprove' OR PO.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND PO.FTXphStaApv = '$tSearchStaApprove'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList      = $oQuery->result();
            $aFoundRow  = $this->FSaMDPOGetPageAll($paData);
            $nFoundRow  = $aFoundRow[0]->counts;
            $nPageAll   = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult    = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
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
    public function FSaMDPOGetPageAll($paData){

        $nLngID = $paData['FNLngID'];
        $tSQL   = "SELECT COUNT (PO.FTXphDocNo) AS counts
                    FROM TAPTPoHD PO WITH (NOLOCK) 
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON PO.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID 
                    WHERE 1=1 ";

        if($this->session->userdata("tSesUsrLevel") == 'BCH' || $this->session->userdata("tSesUsrLevel") == 'SHP'){
            $tBCH = $this->session->userdata("tSesUsrBchCom");
            $tSQL .= " AND  PO.FTBchCode = '$tBCH' ";
        }

        $aAdvanceSearch = $paData['aAdvanceSearch'];
        @$tSearchList   = $aAdvanceSearch['tSearchAll'];
        if(@$tSearchList != ''){
            $tSQL .= " AND ((PO.FTXphDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (PO.FDXphDocDate LIKE '%$tSearchList%'))";
        }

        /*จากสาขา - ถึงสาขา*/
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeFrom)){
            $tSQL .= " AND ((PO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (PO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /*จากวันที่ - ถึงวันที่*/
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((PO.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (PO.FDXphDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /*สถานะเอกสาร*/
        $tSearchStaDoc = $aAdvanceSearch['tSearchStaDoc'];
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            $tSQL .= " AND PO.FTXphStaDoc = '$tSearchStaDoc'";
        }

        /*สถานะอนุมัติ*/
        $tSearchStaApprove = $aAdvanceSearch['tSearchStaApprove'];
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND PO.FTXphStaApv = '$tSearchStaApprove' OR PO.FTXphStaApv = '' ";
            }else{
                $tSQL .= " AND PO.FTXphStaApv = '$tSearchStaApprove'";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }
}