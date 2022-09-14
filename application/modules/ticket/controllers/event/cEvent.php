<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cEvent extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/event/mEvent', 'mEvent');
        $this->load->library("session");
    }

    public function FSxCEVT() {
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/event/wEvent', array(
            'oAuthen' => $oAuthen,
        ));
    }

    public function FSxCEVTList() {
        $tFTEvnName = $this->input->post('tFTEvnName');
        $tFDEvnStart = $this->input->post('tFDEvnStart');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
        $oEVTList = $this->mEvent->FSxMEVT($tFTEvnName, $tFDEvnStart, $nPageActive);
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/event/wEventList', array(
            'oAuthen'   => $oAuthen,
            'oEvtList'  => $oEVTList,
            'nPageNo'   => $nPageNo
        ));
    }

    public function FSxCEVTCount() {
        $tFTEvnName = $this->input->post('tFTEvnName');
        $tFDEvnStart = $this->input->post('tFDEvnStart');
        $oEventCntSh = $this->mEvent->FSxMEVTCount($tFTEvnName, $tFDEvnStart);
        $tEventCount = $oEventCntSh [0]->counts;
        echo $tEventCount;
    }

    public function FSxCEVTAdd() {
        $oTcg = $this->mEvent->FSxMEVTTcg();
        $this->load->view('ticket/event/wAdd', array(
            'oTcg' => $oTcg
        ));
    }

    public function FSxCEVTAddAjax() {
        if ($this->input->post('oetFTEvnName')) {
            $aData = array(
                'FTEvnName' => $this->input->post('oetFTEvnName'),
                'FDEvnStart' => FsxDateTime($this->input->post('oetFDEvnStart')),
                'FDEvnFinish' => FsxDateTime($this->input->post('oetFDEvnFinish')),
                'FDEvnStartSale' => FsxDateTime($this->input->post('oetFDEvnStartSale')),
                'FDEvnStopSale' => FsxDateTime($this->input->post('oetFDEvnStopSale')),
                'FTEvnDesc1' => $this->input->post('otaFTEvnDesc1'),
                'FTEvnDesc2' => $this->input->post('otaFTEvnDesc2'),
                'FTEvnDesc3' => $this->input->post('otaFTEvnDesc3'),
                'FTEvnDesc4' => $this->input->post('otaFTEvnDesc4'),
                'FTEvnDesc5' => $this->input->post('otaFTEvnDesc5'),
                'FTEvnStaUse' => ($this->input->post('ocbFTEvnStaUse') == "" ? "2" : "1"),
                'FTEvnStaSuggest' => ($this->input->post('ocbFTEvnStaSuggest') == "" ? "2" : "1"),
                'FTEvnStaExpire' => ($this->input->post('ocmFTEvnStaExpire') == "" ? "2" : "1"),
                'FDEvnSuggBegin' => FsxDateTime($this->input->post('oetFDEvnSuggBegin')),
                'FDEvnSuggEnd' => FsxDateTime($this->input->post('oetFDEvnSuggEnd')),
                'FNTcgID' => $this->input->post('ocmFNTcgID'),
                'FTEvnRemark' => $this->input->post('otaFTEvnRemark')
            );
            $nEventID = $this->mEvent->FSxMEVTAddAjax($aData);
            $aEventImg = $this->input->post('ohdEventImg');
            foreach ($aEventImg as $key => $oEventImg) {
                $nSeq = (int) $key + 1;
                if ($key == 0) {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $nEventID,
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                } elseif ($key == 1) {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       =>'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $nEventID,
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'banner',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                } else {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       =>'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $nEventID,
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'sub',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                }
                $aResAddImgObj = FCNnHAddImgObj($aImageUplode);

            }
            echo $nEventID;
        }
    }

    public function FSxCEVTEdit($nEvnID) {
        $oShow = $this->mEvent->FSxMEVTShowEdit($nEvnID);
        $oImgSub = $this->mEvent->FSxMEVTShowImgSub($nEvnID);
        $oImgBanner = $this->mEvent->FSxMEVTShowImgBanner($nEvnID);
        $oTcg = $this->mEvent->FSxMEVTTcg();
        $oAuthen = FCNaHCheckAlwFunc('EticketEvent');
        $this->load->view('ticket/event/wEdit', array(
            'oAuthen' => $oAuthen,
            'oTcg' => $oTcg,
            'oImgSub' => $oImgSub,
            'oImgBanner' => $oImgBanner,
            'oShow' => $oShow
        ));
    }

    public function FSxCEVTEditAjax() {
        if ($this->input->post('ohdFNEvnID')) {
            if ((int) $this->input->post('ohdnStaAppv') == 1) {
                $aData = array(
                    'FNEvnID' => $this->input->post('ohdFNEvnID'),
                    'FDEvnSuggBegin' => FsxDateTime($this->input->post('oetFDEvnSuggBegin')),
                    'FDEvnSuggEnd' => FsxDateTime($this->input->post('oetFDEvnSuggEnd')),
                    'FTEvnStaSuggest' => ($this->input->post('ocbFTEvnStaSuggest') == "" ? "2" : "1"),
                    'FTEvnStaUse' => ($this->input->post('ocbFTEvnStaUse') == "" ? "2" : "1"),
                );
                $this->mEvent->FSxMEVTEditAjax2($aData);
            } else {
                $aData = array(
                    'FNEvnID' => $this->input->post('ohdFNEvnID'),
                    'FTEvnName' => $this->input->post('oetFTEvnName'),
                    'FDEvnStart' => FsxDateTime($this->input->post('oetFDEvnStart')),
                    'FDEvnFinish' => FsxDateTime($this->input->post('oetFDEvnFinish')),
                    'FDEvnStartSale' => FsxDateTime($this->input->post('oetFDEvnStartSale')),
                    'FDEvnStopSale' => FsxDateTime($this->input->post('oetFDEvnStopSale')),
                    'FTEvnDesc1' => $this->input->post('otaFTEvnDesc1'),
                    'FTEvnDesc2' => $this->input->post('otaFTEvnDesc2'),
                    'FTEvnDesc3' => $this->input->post('otaFTEvnDesc3'),
                    'FTEvnDesc4' => $this->input->post('otaFTEvnDesc4'),
                    'FTEvnDesc5' => $this->input->post('otaFTEvnDesc5'),
                    'FTEvnStaUse' => ($this->input->post('ocbFTEvnStaUse') == "" ? "2" : "1"),
                    'FTEvnStaSuggest' => ($this->input->post('ocbFTEvnStaSuggest') == "" ? "2" : "1"),
                    'FTEvnStaExpire' => ($this->input->post('ocmFTEvnStaExpire') == "" ? "2" : "1"),
                    'FDEvnSuggBegin' => FsxDateTime($this->input->post('oetFDEvnSuggBegin')),
                    'FDEvnSuggEnd' => FsxDateTime($this->input->post('oetFDEvnSuggEnd')),
                    'FNTcgID' => $this->input->post('ocmFNTcgID'),
                    'FTEvnRemark' => $this->input->post('otaFTEvnRemark')
                );
                $this->mEvent->FSxMEVTEditAjax($aData);
            }

            $aEventImg = $this->input->post('ohdEventImg');
            foreach ($aEventImg as $key => $oEventImg) {
                $nSeq = (int) $key + 1;
                if ($key == 0) {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $aData['FNEvnID'],
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                } elseif ($key == 1) {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $aData['FNEvnID'],
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'banner',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                } else {
                    if ($aEventImg[$key] != '') {
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketevent',
                            'tImgRefID'         => $aData['FNEvnID'],
                            'tImgObj'           => $aEventImg[$key],
                            'tImgTable'         => 'TTKMEvent',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'sub',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                    }
                }
            }
                $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
        }
    }

    public function FSxCEVTDel() {
        if ($this->input->post('nEvtID')) {
            $ocbListItem = $this->input->post('nEvtID');
            $aCode = explode(',', $ocbListItem);
            foreach ($aCode as $key => $oValue) {
                $aData = array(
                    'FNEvnID' => $oValue
                );
                $this->mEvent->FSxMEVTDel($aData);
                $aDeleteImage = array(
                    'tModuleName'  => 'ticket',
                    'tImgFolder'   => 'ticketevent',
                    'tImgRefID'    => $oValue,
                    'tTableDel'    => 'TCNMImgObj',
                    'tImgTable'    => 'TTKMEvent'
                );
                $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                if($nStaDelImgInDB == 1){
                    FSnHDeleteImageFiles($aDeleteImage);
                }
            }
        }
    }

    public function FSxCEVTDelImg() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');
            $aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketevent',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TTKMEvent'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }
    }

    public function FSxCEVTApv() {
        if ($this->input->post('nFNEvnID')) {
            $aData = array(
                'FNEvnID' => $this->input->post('nFNEvnID')
            );
            $aCheck = $this->mEvent->FSxMEVTCheckShowTime($aData);
            if (@$aCheck[0]->FNEvnID == '') {
                echo 1;
            } else {
                $this->mEvent->FSxMEVTApv($aData);
            }
        }
    }

}
