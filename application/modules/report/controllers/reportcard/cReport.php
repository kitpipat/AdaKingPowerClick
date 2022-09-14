<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('reportcard/mReportcard');
        $this->load->model('pos5/company/mCompany');
    }

    public function index($nBrowseType,$tBrowseOption) {
        $nLngID     = FCNaHGetLangEdit();
        $nRoleCode  = $this->session->userdata('tSesUsrRoleCode');
        $aDataRPC   = $this->mReportcard->FSaMRPCGetDataReportcardList($nLngID,$nRoleCode);
        $aSltYear   = $this->mReportcard->FSaMRPGetdataYearList();    // Add select box for year 16/01/2019 (bell)

        $aData = array(
            'nBrowseType'   => $nBrowseType,
            'tBrowseOption' => $tBrowseOption,
            'aDataRPC'      => $aDataRPC,
            'aSltYear'     => $aSltYear
        );
        $this->load->view('reportcard/wReportcard',$aData);
    }
}
