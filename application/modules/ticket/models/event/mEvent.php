<?php

defined('BASEPATH') or exit('No direct script access allowed');

class mEvent extends CI_Model {

    public $nEvtID;

    private function FCNaMEVTCallLenData($pnPerPage, $pnPage) {
        $nPerPage = $pnPerPage;
        if (isset($pnPage)) {
            $nPage = $pnPage;
        } else {
            $nPage = 1;
        }

        $nRowStart = (($nPerPage * $nPage) - $nPerPage);

        $nRowEnd = $nPerPage * $nPage;

        $aLenData = array(
            $nRowStart,
            $nRowEnd
        );
        return $aLenData;
    }

    public function FSxMEVT($tFTEvnName, $tFDEvnStart, $nPageNo = 1) {
        $aRowLen = $this->FCNaMEVTCallLenData(5, $nPageNo); // หาจำนวนช่วงของข้อมูลแต่ละหน้า
        $tSQL = "SELECT c.* FROM(		
		SELECT ROW_NUMBER() OVER(ORDER BY EVT.FNEvnID DESC) AS RowID,
		EVT.*,				
		EVTL.FTEvnName,
		EVTL.FTEvnDesc1,
		EVTL.FTEvnDesc2,
		EVTL.FTEvnDesc3,
		EVTL.FTEvnDesc4,
		EVTL.FTEvnDesc5,
		EVTL.FTEvnRemark,
		OBJ.FTImgObj,
		OBJ.FTImgKey
		FROM TTKMEvent AS EVT
		LEFT JOIN TTKMEvent_L AS EVTL ON EVTL.FNEvnID = EVT.FNEvnID AND EVTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = EVT.FNEvnID AND OBJ.FTImgTable = 'TTKMEvent' AND OBJ.FTImgKey = 'main'
		WHERE 1 = 1";
        if ($tFTEvnName != '') {
            $tSQL .= " AND EVTL.FTEvnName LIKE '%$tFTEvnName%'";
        }

        if ($tFDEvnStart != '') {
            $tSQL .= " AND CONVERT(CHAR(16),EVT.FDEvnStart,126) LIKE '%" . date("Y-m-d", strtotime($tFDEvnStart)) . "%'";
        }
        $tSQL .= ") AS c WHERE c.RowID > $aRowLen[0] AND c.RowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTCount($tFTEvnName, $tFDEvnStart) {
        $tSQL = "SELECT COUNT(EVT.FNEvnID) AS counts
		FROM TTKMEvent AS EVT
		LEFT JOIN TTKMEvent_L AS EVTL ON EVTL.FNEvnID = EVT.FNEvnID AND EVTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		WHERE 1 = 1";

        if ($tFTEvnName != '') {
            $tSQL .= " AND EVTL.FTEvnName LIKE '%$tFTEvnName%'";
        }

        if ($tFDEvnStart != '') {
            $tSQL .= " AND EVT.FDEvnStart LIKE '%$tFDEvnStart%'";
        }

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTAddAjax($aData) {
        $this->db->insert('TTKMEvent', array(
            'FDEvnStart' => $aData ['FDEvnStart'],
            'FDEvnFinish' => $aData ['FDEvnFinish'],
            'FTEvnStaUse' => $aData ['FTEvnStaUse'],
            'FTEvnStaSuggest' => $aData ['FTEvnStaSuggest'],
            'FDEvnSuggBegin' => $aData ['FDEvnSuggBegin'],
            'FDEvnSuggEnd' => $aData ['FDEvnSuggEnd'],
            'FTEvnStaExpire' => $aData ['FTEvnStaExpire'],
            'FDEvnStartSale' => $aData ['FDEvnStartSale'],
            'FDEvnStopSale' => $aData ['FDEvnStopSale'],
            'FNTcgID' => $aData ['FNTcgID'],
            'FTWhoIns' => $this->session->userdata("tSesUsername"),
            'FDDateIns' => date('Y-m-d'),
            'FTTimeIns' => date('h:i:s')
        ));
        $this->nEvtID = $this->db->insert_id();
        $this->db->insert('TTKMEvent_L', array(
            'FNEvnID' => $this->nEvtID,
            'FTEvnName' => $aData ['FTEvnName'],
            'FTEvnDesc1' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc1']),
            'FTEvnDesc2' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc2']),
            'FTEvnDesc3' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc3']),
            'FTEvnDesc4' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc4']),
            'FTEvnDesc5' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc5']),
            'FTEvnRemark' => $aData ['FTEvnRemark'],
            'FNLngID' => $this->session->userdata("tLangEdit")
        ));
        return $this->nEvtID;
    }

    public function FSxCEVTAddImg($aData) {
        $this->db->insert('TTKMImgObj', array(
            'FNImgRefID' => $this->nEvtID,
            'FTImgType' => '8',
            'FNImgSeq' => '1',
            'FTImgObj' => $aData ['FTImgObj']
        ));
    }

    public function FSxMEVTEditAjax($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->update('TTKMEvent', array(
            'FDEvnStart' => $aData ['FDEvnStart'],
            'FDEvnFinish' => $aData ['FDEvnFinish'],
            'FTEvnStaUse' => $aData ['FTEvnStaUse'],
            'FTEvnStaSuggest' => $aData ['FTEvnStaSuggest'],
            'FDEvnSuggBegin' => $aData ['FDEvnSuggBegin'],
            'FTEvnStaExpire' => $aData ['FTEvnStaExpire'],
            'FDEvnSuggEnd' => $aData ['FDEvnSuggEnd'],
            'FDEvnStartSale' => $aData ['FDEvnStartSale'],
            'FDEvnStopSale' => $aData ['FDEvnStopSale'],
            'FNTcgID' => $aData ['FNTcgID'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));

        $nChk = FSnCheckUpdateLang('TTKMEvent_L', 'FNEvnID', $aData ['FNEvnID']);
        if ($nChk [0]->counts == 0) {
            $this->db->insert('TTKMEvent_L', array(
                'FNEvnID' => $aData ['FNEvnID'],
                'FTEvnName' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnName']),
                'FTEvnDesc1' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc1']),
                'FTEvnDesc2' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc2']),
                'FTEvnDesc3' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc3']),
                'FTEvnDesc4' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc4']),
                'FTEvnDesc5' => preg_replace('/^\s+|\n|\r|\s+$/m', '', $aData ['FTEvnDesc5']),
                'FTEvnRemark' => $aData ['FTEvnRemark'],
                'FNLngID' => $this->session->userdata("tLangEdit")
            ));
        } else {
            $this->db->where('FNEvnID', $aData ['FNEvnID']);
            $this->db->where('FNLngID', $this->session->userdata("tLangEdit"));
            $this->db->update('TTKMEvent_L', array(
                'FTEvnName' => $aData ['FTEvnName'],
                'FTEvnDesc1' => $aData ['FTEvnDesc1'],
                'FTEvnDesc2' => $aData ['FTEvnDesc2'],
                'FTEvnDesc3' => $aData ['FTEvnDesc3'],
                'FTEvnDesc4' => $aData ['FTEvnDesc4'],
                'FTEvnDesc5' => $aData ['FTEvnDesc5'],
                'FTEvnRemark' => $aData ['FTEvnRemark']
            ));
        }
    }

    public function FSxMEVTEditAjax2($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->update('TTKMEvent', array(
            'FDEvnSuggBegin' => $aData ['FDEvnSuggBegin'],
            'FDEvnSuggEnd' => $aData ['FDEvnSuggEnd'],
            'FTEvnStaSuggest' => $aData ['FTEvnStaSuggest'],
            'FTEvnStaUse' => $aData ['FTEvnStaUse'],
            'FTWhoUpd' => $this->session->userdata("tSesUsername"),
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s')
        ));
    }

    public function FSxMEVTEditImg($aData) {
        $oImg = FSnCheckImg('TTKMImgObj', 'FNImgRefID', $aData ['FNImgRefID'], '8');
        if ($oImg [0]->counts == 0) {
            $aImg = array(
                'FNImgRefID' => $aData ['FNImgRefID'],
                'FTImgType' => '8',
                'FNImgSeq' => '1',
                'FTImgObj' => $aData ['FTImgObj']
            );
            $this->db->insert('TTKMImgObj', $aImg);
        } else {
            $this->db->where('FNImgRefID', $aData ['FNImgRefID']);
            $this->db->where('FNImgSeq', '1');
            $this->db->where('FTImgType', '8');
            $this->db->update('TTKMImgObj', array(
                'FTImgObj' => $aData ['FTImgObj']
            ));
        }
    }

    public function FSxMEVTDel($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->delete('TTKMEvent');

        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->delete('TTKMEvent_L');

        $this->db->where('FNImgRefID', $aData ['FNEvnID']);
        $this->db->delete('TTKMImgObj');

        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->delete('TTKTShowTime');

        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->delete('TTKTShowTimeDOW');

        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->delete('TTKTShowTimeHoliday');

        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->update('TTKTPkgList', array(
            'FNEvnID' => NULL
        ));
    }

    public function FSxMEVTShowEdit($nEvnID) {
        $tSQL = "SELECT EVT.*,				
		EVTL.FTEvnName,
		EVTL.FTEvnDesc1,
		EVTL.FTEvnDesc2,
		EVTL.FTEvnDesc3,
		EVTL.FTEvnDesc4,
		EVTL.FTEvnDesc5,
		EVTL.FTEvnRemark,
		OBJ.FTImgObj,
		OBJ.FNImgID,
		OBJ.FTImgKey
		FROM TTKMEvent AS EVT
		LEFT JOIN TTKMEvent_L AS EVTL ON EVTL.FNEvnID = EVT.FNEvnID AND EVTL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		LEFT JOIN TTKMImgObj AS OBJ ON OBJ.FTImgRefID = EVT.FNEvnID AND OBJ.FTImgTable = 'TTKMEvent' AND OBJ.FTImgKey = 'main'
		WHERE EVT.FNEvnID = '$nEvnID'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTShowImgSub($nEvnID) {
        $tSQL = "SELECT * FROM TTKMImgObj WHERE FTImgRefID = '$nEvnID' AND FTImgTable = 'TTKMEvent' AND FTImgKey = 'sub'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTShowImgBanner($nEvnID) {
        $tSQL = "SELECT * FROM TTKMImgObj WHERE FTImgRefID = '$nEvnID' AND FTImgTable = 'TTKMEvent' AND FTImgKey = 'banner'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTTcg() {
        $tSQL = "SELECT TCH.*, TCHL.FTTcgName, MODL.FTPmoName
		FROM TTKMTchGroup AS TCH
		LEFT JOIN TTKMTchGroup_L AS TCHL ON TCHL.FNTcgID = TCH.FNTcgID AND TCHL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		LEFT JOIN TTKMPdtModel_L AS MODL ON MODL.FNPmoID = TCH.FNPmoID AND MODL.FNLngID = '" . $this->session->userdata("tLangEdit") . "'
		";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTAuthen() {
        $tSQL = "SELECT FTGadStaAlwR, FTGadStaAlwW, FTGadStaAlwDel, FTGadStaAlwApv FROM TTKMGrpAlwDT WHERE FTGadType = '1' AND FNGadRefID = '9' AND FNGahID = '" . $this->session->userdata("FNGahID") . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

    public function FSxMEVTApv($aData) {
        $this->db->where('FNEvnID', $aData ['FNEvnID']);
        $this->db->update('TTKMEvent', array(
            'FTEvnStaPrcDoc' => '1',
            'FNEvnUsrApv' => $this->session->userdata("tSesUsername")
        ));
    }

    public function FSxMEVTCheckShowTime($aData) {
        $tSQL = "SELECT FNEvnID FROM TTKTShowTime WHERE FNEvnID = '" . $aData ['FNEvnID'] . "'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        } else {
            return false;
        }
    }

}

?>
