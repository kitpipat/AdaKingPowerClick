<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cServer extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('register/server/mServer');
        $this->load->model('register/information/mInformationRegister');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nSrvBrowseType,$tSrvBrowseOption){
        $nMsgResp   = array('title'=>"Server Data");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('Server/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventServer	    = FCNaHCheckAlwFunc('Server/0/0');

        $this->load->view('register/Server/wServer', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nSrvBrowseType'    => $nSrvBrowseType,
            'tSrvBrowseOption'  => $tSrvBrowseOption,
            'aAlwEventServer'  => $aAlwEventServer
        ));
    }

    //Functionality : Function Call Server Data Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/01/2021 Nale
    //Return : String View
    //Return Type : View
    public function FSvCSrvListPage(){
        $aAlwEventServer	    = FCNaHCheckAlwFunc('Server/0/0');
        $this->load->view('register/Server/wServerList',array(
            'aAlwEventServer'  =>  $aAlwEventServer
        ));
    }

    //Functionality : Function Call DataTables Server Data
    //Parameters : Ajax Call View DataTable
    //Creator : 21/01/2021 Nale
    //Return : String View
    //Return Type : View
    public function FSvCSrvDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );
            $aSrvDataList           = $this->mServer->FSaMSrvList($aData);
            $aAlwEventServer	    = FCNaHCheckAlwFunc('Server/0/0');
            $aGenTable  = array(
                'aSrvDataList'          => $aSrvDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventServer'      => $aAlwEventServer
            );
            $this->load->view('register/Server/wServerDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Server Data Add
    //Parameters : Ajax Call View Add
    //Creator : 21/01/2021 Nale
    //Return : String View
    //Return Type : View
    public function FSvCSrvAddPage(){
        try{
            $aDataServer = array(
                'nStaAddOrEdit'  => 99,
                'tSesAgnCode'    => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'    => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('register/Server/wServerAdd',$aDataServer);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Server Data Edit
    //Parameters : Ajax Call View Edit
    //Creator : 21/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCSrvEditPage(){
        try{
            $tSrvCode       = $this->input->post('tSrvCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTSrvCode' => $tSrvCode,
                'FNLngID'   => $nLangEdit
            );

            $aSrvData       = $this->mServer->FSaMSrvGetDataByID($aData);
            $aDataServer      = array(
                'nStaAddOrEdit' => 1,
                'aSrvData'      => $aSrvData
            );
            $this->load->view('register/Server/wServerAdd',$aDataServer);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Server Data
    //Parameters : Ajax Event
    //Creator : 21/01/2021 Nale
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSrvAddEvent(){
        try{
            $aDataServer   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbSrvAutoGenCode'),
                'FTSrvCode'     => $this->input->post('oetSrvCode'),
                'FTSrvName'     => $this->input->post('oetSrvName'),
                'FTSrvNameOth'  => $this->input->post('oetSrvNameOth'),
                'FTSrvRefAPIMaste' => $this->input->post('oetSrvRefAPIMaste'),
                'FTSrvRefSBUrl' => $this->input->post('oetSrvRefSBUrl'),
                'FTSrvStaCenter' => $this->input->post('ocmSrvStaCenter'),
                'FTSrvDBName' => $this->input->post('oetSrvDBName'),
                'FTSrvGroup' => $this->input->post('ocmSrvGroup'),
                'FTSrvRmk' => $this->input->post('otaSrvRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetSrvAgnCode'),
            );
            // Setup Reason Code
            if($aDataServer['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
    
                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TRGMPosSrv',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataServer['FTSrvCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->mServer->FSnMSrvCheckDuplicate($aDataServer['FTSrvCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->mServer->FSaMSrvAddUpdateMaster($aDataServer);
                $aStaDptLang    = $this->mServer->FSaMSrvAddUpdateLang($aDataServer);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Server Data"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataServer['FTSrvCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Server Data'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Server Data
    //Parameters : Ajax Event
    //Creator : 21/01/2021 Nale
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCSrvEditEvent(){
        try{
            $aDataServer   = array(
                'FTSrvCode' => $this->input->post('oetSrvCode'),
                'FTSrvName' => $this->input->post('oetSrvName'),
                'FTSrvNameOth'  => $this->input->post('oetSrvNameOth'),
                'FTSrvRefAPIMaste' => $this->input->post('oetSrvRefAPIMaste'),
                'FTSrvRefSBUrl' => $this->input->post('oetSrvRefSBUrl'),
                'FTSrvStaCenter' => $this->input->post('ocmSrvStaCenter'),
                'FTSrvDBName' => $this->input->post('oetSrvDBName'),
                'FTSrvGroup' => $this->input->post('ocmSrvGroup'),
                'FTSrvRmk' => $this->input->post('otaSrvRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetSrvAgnCode'),
            );
            $this->db->trans_begin();
            $aStaSrvMaster  = $this->mServer->FSaMSrvAddUpdateMaster($aDataServer);
            $aStaSrvLang    = $this->mServer->FSaMSrvAddUpdateLang($aDataServer);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Server Data"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataServer['FTSrvCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Server Data'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Server Data
    //Parameters : Ajax jReason()
    //Creator : 21/01/2021 Nale
    //Update : 1/4/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSrvDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSrvCode' => $tIDCode
        );
        $aResDel        = $this->mServer->FSaMSrvDelAll($aDataMaster);
        $nNumRowPdtSrv = $this->mServer->FSnMSrvGetAllNumRow();
        if($nNumRowPdtSrv!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtSrv' => $nNumRowPdtSrv
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }



    //Functionality : Event Delete Server Data
    //Parameters : Ajax jReason()
    //Creator : 02/02/2021 Nale
    //Return : 
    //Return Type : String
    public function FSoCSrvSyncEvent(){
    try{
        $aOjcChcked = $this->input->post('aOjcChcked');
        $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);
        $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
        $tUrlApiSyncDataMaster = $tUrlObject.'/Master/Download';
        if($aAPIConfig['rtCode']=='01'){
            $aApiKey = array(
                'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
            );
        }else{
            $aApiKey = array();
        }
        
        if(!empty($aOjcChcked)){
                foreach($aOjcChcked as $aData){

                        $aPaRam = array(
                            'ptSyncLast' => $aData['ptSyncLast'] ,
                            'ptUrlServer' => $aData['ptUrlServer'] 
                        );

                        $oReusltLicense = FCNaHCallAPIBasic($tUrlApiSyncDataMaster,'POST',$aPaRam,$aApiKey);

                }
                $aRetun = array(
                    'rtCode' => '1',
                    'rtDest' => 'Success'
                );
        }else{

            $aPaRam = array(
                'ptSyncLast' => '' ,
                'ptUrlServer' => ''
            );

            $oReusltLicense = FCNaHCallAPIBasic($tUrlApiSyncDataMaster,'POST',$aPaRam,$aApiKey);
        }

        echo  json_encode($oReusltLicense);
    }catch(Exception $Error){
        echo $Error;
    }


    }
    





































































}  