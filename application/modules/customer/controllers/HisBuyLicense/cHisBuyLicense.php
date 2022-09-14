<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cHisBuyLicense extends MX_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('customer/HisBuyLicense/mHisBuyLicense');
        $this->load->model('company/company/mCompany');
        $this->load->model('payment/rate/mRate');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index(){
        $aDataConfigView    = [
            'aAlwEvent'             => FCNaHCheckAlwFunc('HisBuyLicense'),
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('HisBuyLicense'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('customer/HisBuyLicense/wHisBuyLicense', $aDataConfigView);
    }

    //Main page
    public function FSvCHISBuyLicenseMainPage(){
        $aDataConfigView    = [
            'aAlwEvent'     => FCNaHCheckAlwFunc('HisBuyLicense')
        ];
        $this->load->view('customer/HisBuyLicense/wHisBuyLicenseList', $aDataConfigView);
    }

    //DataTable 
    public function FSvCHISBuyLicenseDataTable(){
        try {
            $tSearchAll         = $this->input->post('tSearchAll');
            $nPage              = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent'); 
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $tAdvanceSearchData = $this->input->post('oAdvanceSearch');

            $aData  = array(
                'nPage'             => $nPage,
                'nRow'              => 10,
                'FNLngID'           => $nLangEdit,
                'tSearchAll'        => $tSearchAll,
                'aAdvanceSearch'    => $tAdvanceSearchData
            );

            $aAlwEvent              = FCNaHCheckAlwFunc('HisBuyLicense');
            $aGenTable  = array(
                'aDataList'         => $this->mHisBuyLicense->FSaMBuyLicenseList($aData),
                'aDataSumFooter'    => $this->mHisBuyLicense->FSaMBuyLicenseListSumFooter($aData),
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEvent'         => $aAlwEvent
            );
            $this->load->view('customer/HisBuyLicense/wHisBuyLicenseDataTable', $aGenTable);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Page Preview
    public function FSvCHISBuyLicensePagePreview(){
        $aData  = array(
            'FNLngID'            => $this->session->userdata("tLangEdit"),
            'tDocumentNumber'    => $this->input->post('ptDocumentNumber')
        );

        $aData  = array(
            'nDecimalShow'      => FCNxHGetOptionDecimalShow(),
            'aResultPdtDT'      => $this->mHisBuyLicense->FSaMBuyLicenseDatabyID($aData),
            'aSumFooter'        => $this->mHisBuyLicense->FSxMBUYSelectSumFooterTemp($aData)
        );
        $this->load->view('customer/HisBuyLicense/wHisBuyLicensePreview', $aData);
    }
}
