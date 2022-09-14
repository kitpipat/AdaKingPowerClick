<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Nation_controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('other/nation/Nation_model');
        $this->load->model('register/information/mInformationRegister');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nRsnBrowseType, $tRsnBrowseOption)
    {
        $nMsgResp = array('title' => "Nation");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('masNation/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventNation    = FCNaHCheckAlwFunc('masNation/0/0');
        $this->load->view('other/nation/wNation', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nRsnBrowseType'    => $nRsnBrowseType,
            'tRsnBrowseOption'  => $tRsnBrowseOption,
            'aAlwEventNation'   => $aAlwEventNation
        ));
    }

    //Functionality : Function Call Page Nation List
    //Parameters : Ajax jNation()
    //Creator : 25/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCNATListPage()
    {
        $aAlwEventNation    = FCNaHCheckAlwFunc('masNation/0/0');
        $aNewData              = array('aAlwEventNation' => $aAlwEventNation);
        $this->load->view('other/nation/wNationList', $aNewData);
    }

    // LastUpdate By : Napat(Jame) 15/03/2022
    public function FSvCNATDataList()
    {
        $nPage  = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        //Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => trim($tSearchAll)
        );

        $aResList   = $this->Nation_model->FSaMNATList($aData);
        $aAlwEvent = FCNaHCheckAlwFunc('masNation/0/0'); //Controle Event
        // echo "<pre>"; print_r($aResList); echo "</pre>";

        if( $aResList['rnCurrentPage'] > $aResList['rnAllPage'] ){
            $aData['nPage'] = 1;
            $aResList       = $this->Nation_model->FSaMNATList($aData);
        }
        // echo "<pre>"; print_r($aResList); echo "</pre>";

        $aGenTable  = array(
            'aAlwEventNation' => $aAlwEvent,
            'aDataList'       => $aResList,
            'nPage'           => $aData['nPage']
        );
        $this->load->view('other/nation/wNationDataTable', $aGenTable);
    }


    public function FSvCNATDataListAPINation()
    {

        $tCstEmail = $this->input->post('tCstEmail');

        $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('', 4);

        $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();

        $tCstKey = $this->session->userdata('tSesCstKey');

        //   License/Unsubscribe?ptEmail=abc@ada-soft.com

        $aPaRam = array(
            'CstKey' => $tCstKey,
            'Lang' => 1
        );

        if ($aAPIConfig['rtCode'] == '01') {
            $aApiKey = array(
                'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
            );
        } else {
            $aApiKey = array();
        }

        //http://202.44.55.94/AdaPos5StoreBackReg_Dev/API2PSMaster/v5/Nation/GetUpdate
        $tUrlAPINation =    $tUrlObject . '/Nation/GetUpdate';

     

        $oReusltNation = FCNaHCallAPIBasic($tUrlAPINation, 'POST', $aPaRam, $aApiKey);

        // print_r($oReusltNation); die();


        echo  json_encode($oReusltNation);
    }

}
