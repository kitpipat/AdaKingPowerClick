<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCardHistory extends MX_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('payment/cardhistory/mCardHistory');
    }


    public function  index($nCrdHisBrowseType, $tCrdHisBrowseOption){
        $nMsgResp   = array('title' => "CardHistory");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }

        $vBtnSave            = FCNaHBtnSaveActiveHTML('cardhistory/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCardHis    = FCNaHCheckAlwFunc('cardhistory/0/0');

        $this->load->view('payment/cardhistory/wCardHistory', array(
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nCrdHisBrowseType'     => $nCrdHisBrowseType,
            'tCrdHisBrowseOption'   => $tCrdHisBrowseOption,
            'aAlwEventCardHis'      => $aAlwEventCardHis
        ));
    }   


    //Functionality : Function Call Page Card List
    //Parameters : Ajax and Function Parameter
    //Creator : 10/10/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCCRDHISListPage(){
        $aAlwEventCardHis        = FCNaHCheckAlwFunc('cardhistory/0/0');
        $aNewData             = array('aAlwEventCardHis' => $aAlwEventCardHis);
        $this->load->view('payment/cardhistory/wCardHistoryList', $aNewData);
    }

    //Functionality Call View DataTable
    // Create By Witsarut
    public function FSvCCRDHISDataList(){
        try{
           
            $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");

            $aData = array(
                'nPage'     => $nPage,
                'nRow'      => 10,
                'FNLngID'   => $nLangEdit,
            );

            $aAlwEventCardHis = FCNaHCheckAlwFunc('cardhistory/0/0'); //Controle Event

            $aGenTable  = array(
                'nPage'             => $nPage,
                'aAlwEventCardHis'  => $aAlwEventCardHis
            );
            $this->load->view('payment/cardhistory/wCardHistoryDataTable', $aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }


       /**
     * Functionality : Get Card History Table
     * Parameters : -
     * Creator : 05/01/2021 Witsarut
     * Last Modified : -
     * Return : View
     * Return Type : View
     */
    public function FSvCCRDGetHisDataTable(){
        try{

            $tBchCode    = $this->input->post('tBchCode');
            $tHisDate    = $this->input->post('tHisDate');
            $tCrdHisCode = $this->input->post('tCrdHisCode');
            $tCrdTypeHis = $this->input->post('tCrdTypeHis');
            $nLangEdit   = $this->session->userdata("tLangEdit");

            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            $aAlwEvent = FCNaHCheckAlwFunc('cardhistory/0/0');

            $aGetHisDataTableParams = [
                'tBchCode'    => $tBchCode,
                'tHisDate'    => $tHisDate,
                'tCrdHisCode' => $tCrdHisCode,
                'tCrdTypeHis' => $tCrdTypeHis,
                'nLngID'      => $nLangEdit
            ];

            $aCrdHisData = $this->mCardHistory->FSaMCRDGetHisDataTable($aGetHisDataTableParams);
            $aCrdHisTableParams = [
                'aDataList'       => $aCrdHisData,
                'aAlwEvent'       => $aAlwEvent,
                'nOptDecimalShow' => $nOptDecimalShow
            ];


            $this->load->view('payment/cardhistory/wCardHistoryDataTable', $aCrdHisTableParams);

        }catch(Exception $Error){
            echo $Error;
        }
    }
   
}
