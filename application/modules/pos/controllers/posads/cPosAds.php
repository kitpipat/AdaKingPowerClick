<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPosAds extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/posads/mPosAds');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nAdsBrowseType,$tAdsBrowseOption){
        $nMsgResp   = array('title'=>"PosAds");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('salemachine/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPosAds	= FCNaHCheckAlwFunc('salemachine/0/0');

        // อ้างอิงรหัสจาก SaleMachineAddd
        $aDataCode = array(
            'tBchCode'  => $this->input->post('tBchCode'),
            'tShpCode'  => $this->input->post('tPosCode'),
            'tPosCode'  => $this->input->post('tPosCode')
        );
     
        $this->load->view('pos/posads/wPosAds', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nAdsBrowseType'    => $nAdsBrowseType,
            'tAdsBrowseOption'  => $tAdsBrowseOption,
            'aAlwEventPosAds'   => $aAlwEventPosAds,
            'aDataCode'         => $aDataCode
        ));
    }

    //Functionality : Function Call PosAds Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCADSListPage(){ 
        $aInfor = $this->mPosAds->FSxMGetPosInfor($this->input->post("tPosCode"));
        $data = array(
            "aInfor" => $aInfor
        );
        $this->load->view('pos/posads/wPosAdsList',$data);
    }

    /**
     * Functionality : Call DataTables PosAds
     * Parameters : Ajax Call View DataTable
     * Creator : 05/10/2018 Witsarut (Bell)
     * Last Modified : 11/1/2019 Piya 
     * Last Update : 11/08/2020 Napat(Jame) เพิ่มการ where FTBchCode
     * Return : view
     * Return Type : view
     */
    public function FSvCADSDataList(){
        try{
            $tPosCode       = $this->input->post('tPosCode');
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'tSearchAll'    => $tSearchAll,
                'tPosCode'      => $tPosCode,
                'tBchCode'      => $this->input->post('ptBchCode'),
                'tShpCode'      => $this->input->post('ptShpCode')
            );
            $aAdsDataList   = $this->mPosAds->FSaMADSList($aData);
            $aGenTable  = array(
                'aAdsDataList'  => $aAdsDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('pos/posads/wPosAdsDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage PosAds Add
    //Parameters : Ajax Call View Add
    //Creator : 05/10/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCADSAddPage(){
        try{
            $aData = array(
                'nStaAddOrEdit'   => 99,
                'tPosCodeMaster'  => $this->input->post('tPosCode'),    
                'tBchCodeMaster'  => $this->input->post('tBchCode'),    
                'tShpCodeMaster'  => $this->input->post('tShpCode')
            );
            $this->load->view('pos/posads/wPosAdsAdd',$aData);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage PosAds Edit
    //Parameters : Ajax Call View Edit
    //Creator : 16/09/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCADSEditPage(){
        try{
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData = array(
                'ptPosCode'        => $this->input->post('tPosCode'),    
                'ptBchCode'        => $this->input->post('tBchCode'),    
                'ptShpCode'        => $this->input->post('tShpCode'),
                'ptPsdSeq'         => $this->input->post('tPsdSeq'),
                'nLangEdit'        => $nLangEdit 
            );
            $aResultData          = $this->mPosAds->FSaMADSGetDataByIDEdit($aData);
            //Controle Event
            $aAlwEventSalemachine = FCNaHCheckAlwFunc('salemachine/0/0'); 
            $aDataEdit  = array (
                'nStaAddOrEdit'          => 1,
                'aResult'                => $aResultData,
                'aAlwEventSalemachine'   => $aAlwEventSalemachine,
            );
            $this->load->view('pos/posads/wPosAdsAdd',$aDataEdit);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add PosAds
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut (Bell)
    //update : 17/09/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCADSAddEvent(){ 
        try{
            $this->db->trans_begin();

            $aDataSearchSeq = array(
                'tBchCode'  => $this->input->post('ohdBchCodeAds'),
                'tShpCode'  => $this->input->post('ohdAdsShpCodeAds'),
                'tPosCode'  => $this->input->post('ohdAdsPosCodeAds')
            );
            $nCountSeq   = $this->mPosAds->FSnMCountSeq($aDataSearchSeq);
            $nCountSeq   = $nCountSeq +1;
            
            $dDateStarAds   =   $this->input->post('ohdAdsStart');
            $dDateStopAds   =   $this->input->post('ohdAdsStop');

            if($dDateStarAds != "" && $dDateStopAds !="" ){
                $dDateStar = $this->input->post('ohdAdsStart');
                $dDateStop = $this->input->post('ohdAdsStop');
            }else{
                $dDateStar = date('Y-m-d H:i:s');
                $dDateStop = date('Y-m-d H:i:s', strtotime('+1 year'));
            }

            $aData   = array(
                'FTBchCode'     => $aDataSearchSeq['tBchCode'],
                'FTShpCode'     => $aDataSearchSeq['tShpCode'],
                'FTPosCode'     => $aDataSearchSeq['tPosCode'],
                'FNPsdSeq'      => $nCountSeq,
                'FTAdvCode'     => $this->input->post('oetPosAdvertiseCode'),
                'FTPsdPosition' => $this->input->post('ocmPosition'),
                'FNPsdWide'     => $this->input->post('ocmPosWidth'),
                'FNPsdHigh'     => $this->input->post('ocmPosHeigh'),
                'FDPsdStart'    => $dDateStar,
                'FDPsdStop'     => $dDateStop,
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );

            $aStaAdsMaster  = $this->mPosAds->FSaMADSAddUpdateMaster($aData);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add PosAds"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aData['FTAdvCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add PosAds'
                );
            }
 
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit PosAds
    //Parameters : Ajax Event
    //Creator : 05/10/2018 Witsarut(Bell)
    //update : 17/09/2019 Saharat(Golf)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCADSEditEvent(){ 

        $dDateStarAds   =   $this->input->post('ohdAdsStart');
        $dDateStopAds   =   $this->input->post('ohdAdsStop');

        if($dDateStarAds != "" && $dDateStopAds !="" ){
            $dDateStar = $this->input->post('ohdAdsStart');
            $dDateStop = $this->input->post('ohdAdsStop');
        }else{
            $dDateStar = date('Y-m-d H:i:s');
            $dDateStop = date('Y-m-d H:i:s', strtotime('+1 year'));
        }
        try{
            $aData   = array(
                'FTBchCode'     => $this->input->post('ohdBchCodeAds'),
                'FTShpCode'     => $this->input->post('ohdAdsShpCodeAds'),
                'FTPosCode'     => $this->input->post('ohdAdsPosCodeAds'),
                'FNPsdSeq'      => $this->input->post('ohdAdsPsdSeq'),
                'FTAdvCode'     => $this->input->post('oetPosAdvertiseCode'),
                'FTPsdPosition' => $this->input->post('ocmPosition'),
                'FNPsdWide'     => $this->input->post('ocmPosWidth'),
                'FNPsdHigh'     => $this->input->post('ocmPosHeigh'),
                'FDPsdStart'    => $dDateStar,
                'FDPsdStop'     => $dDateStop,
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $this->db->trans_begin();
            $aStaAdsMaster  = $this->mPosAds->FSaMADSAddUpdateMaster($aData);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit PosAds"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aData['FTAdvCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit PosAds'
                );
            }
            echo json_encode($aReturn);
            
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete PosAds
    //Parameters : Ajax jPosAds()
    //Creator : 05/10/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCADSDeleteEvent(){
        try{
            $tIDCode    = $this->input->post('tSeqNo');
            $tBchCode   = $this->input->post('tBchCode');
            $tShpCode   = $this->input->post('tShpCode');
            $tPosCode   = $this->input->post('tPosCode');
            $aDataMaster = array(
                'FNPsdSeq'  => $tIDCode,
                'FTBchCode' => $tBchCode,
                'FTShpCode' => $tShpCode,
                'FTPosCode' => $tPosCode
            );

            $aResDel     = $this->mPosAds->FSaMADSDelAll($aDataMaster);
            // $this->mPosAds->FSaMPosAdsUpdateSeqNumber();

            if($aResDel['rtCode'] == 1){
                $aDeleteImage = array(
                    'tImgTable'    => 'TCNMPosAds'
                );
            }
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event ShowMedeiaobj 
    //Parameters : Ajax jPosAds()
    //Creator : 15/02/2019 Bell
    //Return : Status ShowMedeiaobj Event
    //Return Type : String
    public function FSoCADSViewMedia(){
        try{
            $tPosAdsVDCode  = $this->input->post('tPosAdsVDCode');
            $tTypemedia     = $this->input->post('tTypemedia');

            // Get data from Media Type 1 Sound Type 2 VDO
            $aDataPosAdsVD  = $this->mPosAds->FSaMADSGetMediaRefID($tPosAdsVDCode);
            // Get data From AdvMsg 
            $aDataPosMsg    = $this->mPosAds->FSaMADSGetAdsMsg($tPosAdsVDCode);

            // Get Data From MediaObj
            $aDataImgObj    = $this->mPosAds->FSaMADSGetImageobj($tPosAdsVDCode);
            

            if(!isset($aDataPosAdsVD) || $aDataPosAdsVD['rtCode'] != '1'){
                $aDataPosAdsVD = false;
            }
            if(!isset($aDataPosMsg) || $aDataPosMsg['rtCode'] != '1'){
                $aDataPosMsg = false;
            }
            if(!isset($aDataImgObj) || $aDataImgObj['rtCode'] != '1'){
                $aDataImgObj = false;
            }
            $tViewPosAdsMedia   = $this->load->view('pos/posads/wPosAdsViewMedia',array(
                'aDataPosAdsVD' => $aDataPosAdsVD,
                'aDataPosMsg' => $aDataPosMsg,
                'aDataImgObj' => $aDataImgObj,
                'tTypemedia' => $tTypemedia
            ),true);

            $aReturnData    = array(
                'tViewPosAdsMedia'  => $tViewPosAdsMedia,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );

        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality : Event ShowPosition 
    //Parameters : Ajax jPosAds()
    //Creator : 15/02/2019 Bell
    //Return : Status ShowPosition Event
    //Return Type : String
    public function FSoCADSViewPosition(){
        $tPosAdsPosition    = $this->input->post('tPosAdsPositionSlt'); 

        $this->load->view('pos/posads/wPosAdsViewPosition',array(
            'tPosAdsPosition'   => $tPosAdsPosition,
        ));
    }
    

    //Functionality : Delete Pos Ads Multiple
    //Parameters : Ajax jPosAds()
    //Creator : 17/09/2019 Saharat(Golf)
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCADSDeleteMultipleEvent(){
        try{
            $aData           = array(
                'FTBchCode'  => $this->input->post('aBchCode'),
                'FTShpCode'  => $this->input->post('aShpCode'),
                'FTPosCode'  => $this->input->post('tPosCode'),
                'FNPsdSeq'   => $this->input->post('tSeq'),
             );
            $tResult    = $this->mPosAds->FSaMPosAdsDeleteMultiple($aData);
            $nNumRow    = $this->mPosAds->FSnMPosGetAllNumRow($aData);
            if($nNumRow!==false){
                $aReturn    = array(
                    'nStaEvent'  => $tResult['rtCode'],
                    'tStaMessg'  => $tResult['rtDesc'],
                    'nNumRow' => $nNumRow
                );
                echo json_encode($aReturn);
            }else{
                echo "database error!";
            } 
        }catch(Exception $Error){
            $aDataReturn    = array(
                'nStaEvent'     => 500,
                'tStaMessg'     => $Error
            );
        } 
}












}
