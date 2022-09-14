<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSettingConnection extends MX_Controller {
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/settingconnection/mSettingConnection');
        date_default_timezone_set("Asia/Bangkok");
    }


    //Functionality : Function Call Page Main
	//Parameters : From Ajax File BCHSettingConnection
	//Creator : 10/09/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
    //Return Type : View
    public function FSvCUolConnectionMainPage(){

        $vBtnSaveGpBchSettingCon    = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');
        $aAlwEventBchSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        // Get data BchCode
        $tBchCode   = $this->input->post('tBchCode');

        $aBchCodeSetConnect = array(
            'tBchCode'  => $tBchCode
        );

        $this->load->view('company/settingconnection/wSettingConnectionMain',array(
            'vBtnSaveGpBchSettingCon'   => $vBtnSaveGpBchSettingCon,
            'aAlwEventBchSettingCon'    => $aAlwEventBchSettingCon,
            'aBchCodeSetConnect'        => $aBchCodeSetConnect
        ));
    }

    //Functionality : List Data 
	//Parameters : From Ajax File SettingConnection
	//Creator : 10/09/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
    //Return Type : View
    public function FSvCUolConnectionDataList(){

        $tBchCode       = $this->input->post('tBchCode');
        $tSearchAll     = $this->input->post('tSearchAll');
        $nPage          = $this->input->post('nPageCurrent');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธ
        $aAlwEventBchSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        $aData   = array(
            'FTUrlRefID'   => $tBchCode,
            'nPage'        => $nPage,
            'nRow'         => 10,
            'FNLngID'      => $nLangEdit,
            'tSearchAll'   => $tSearchAll,
        );


        $aResList   = $this->mSettingConnection->FSaMSetConnectLDataList($aData);


        $aGenTable  = array(
            'aDataList' 	            => $aResList,
            'nPage'     	            => $nPage,
            'aAlwEventBchSettingCon'    => $aAlwEventBchSettingCon,
            'FTUrlRefID'                => $tBchCode,
        );

        //Return Data View
        $this->load->view('company/settingconnection/wSettingConnectionDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add SettingConnection 
    //Parameters : 
    //Creator : 11/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCUolConnectionPageAdd(){

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveBchSettingCon   = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');

        $aAlwEventBchSettingCon  = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        // BchCode
        $tBchCode   = $this->input->post('tBchCode');

        $aBchCodeSetAuthen = array(
            'tBchCode' => $tBchCode,
        );

        $aDataAdd   = array(
            'aResult'                   => array('rtCode'=>'99'),
            'vBtnSaveBchSettingCon'     => $vBtnSaveBchSettingCon,
            'aAlwEventBchSettingCon'    => $aAlwEventBchSettingCon,
            'dGetDataNow'               => $dGetDataNow,
            'dGetDataFuture'            => $dGetDataFuture,
            'aBchCodeSetAuthen'         => $aBchCodeSetAuthen
        );

        $this->load->view('company/settingconnection/wSettingConnectionAdd',$aDataAdd);

    }

    //Functionality :  Load Page Edit SettingConnection 
    //Parameters : 
    //Creator : 12/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCUolConnectionPageEdit(){

        $dGetDataNow                = date('Y-m-d');
        $dGetDataFuture             = date('Y-m-d', strtotime('+1 year'));
        $nLangEdit                  = $this->session->userdata("tLangEdit");
        $aAlwEventBchSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');
        $nLangResort                = $this->session->userdata("tLangID");
        $tBchCode                   = $this->input->post('tBchCode');
        $tUrlId                     = $this->input->post('tUrlID');
        $vBtnSaveBchSettingCon      = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');

        $aData   = array(
            'FTUrlRefID'    => $tBchCode,
            'FNUrlID'       => $tUrlId,
            'FNLngID'       => $nLangEdit,
        );

        // TCNTUrlObject
        $aResult    = $this->mSettingConnection->FSaMGetConCheckID($aData);

        if(isset($aResult['raItems']['rtSetConImage']) && !empty($aResult['raItems']['rtSetConImage'])){
            $tImgObj        = $aResult['raItems']['rtSetConImage'];
            $aImgObj        = explode("application/modules/",$tImgObj);
            $aImgObjName    = explode("/",$tImgObj);
            $tImgObjAll		= $aImgObj[1];
            $tImgName		= end($aImgObjName);

        }else{
            $tImgObjAll     = "";
            $tImgName       = "";
        }

        $aBchCodeSetAuthen = array(
            'tBchCode' => $tBchCode,
        );

        $aDataEdit  = array(
            'aResult'                => $aResult,
            'vBtnSaveBchSettingCon'  => $vBtnSaveBchSettingCon,
            'aAlwEventBchSettingCon' => $aAlwEventBchSettingCon,
            'dGetDataNow'            => $dGetDataNow,
            'dGetDataFuture'         => $dGetDataFuture,
            'aBchCodeSetAuthen'      => $aBchCodeSetAuthen,
            'tImgObjAll'             => $tImgObjAll,
            'tImgName'               => $tImgName
        );

        $this->load->view('company/settingconnection/wSettingConnectionAdd',$aDataEdit);
    }

    //Functionality : Function Add BchSettingConnection
    //Parameters : From Ajax File BchSettingConnection
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCUolConnectionAddEvent(){
        try{

            $tRefIDSeq              = $this->input->post('oetSettingBchCode');


            //imput Imge
            $tBchSettingConOld     = trim($this->input->post('oetImgInputBchSetConOld'));
            $tBchSettingCon        = trim($this->input->post('oetImgInputBchSetCon')); 

            $nCountSeq   = $this->mSettingConnection->FSnMCountSeq();
            $nCountSeq   = $nCountSeq +1;

            $nUrlType    = $this->input->post('ocmUrlConnecttype');

            //MqMain
            $tUolVhostMq        = $this->input->post('oetBchMQMainVulHost');
            $tUolUserMq         = $this->input->post('oetBchMQMainUsrAccount');  
            
            //MqDoc
            $tUolVhostMqDoc     = $this->input->post('oetBchMQDocVulHost');
            $tUolUserMqDoc      = $this->input->post('oetBchMQDocUsrAccount');  

            //MqSale
            $tUolVhostMqSale    = $this->input->post('oetBchMQSaleVulHost');
            $tUolUserMqSale     = $this->input->post('oetBchMQSaleUsrAccount'); 
            
            //MqReport
            $tUolVhostMqReport  = $this->input->post('oetBchMQReportVulHost'); 
            $tUolUserMqReport   = $this->input->post('oetBchMQReportUsrAccount');  

             //  ********************** Check ว่า Vhost กับ User ซ้ำกันหรือป่าว **********************

            switch($nUrlType){
                case '1': // URL
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '2': // URL + Authorized
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                 
                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array( 
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchVulHost'),
                        'FTUolUser'     => $this->input->post('oetBchUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetBchPassword'),
                        'FTUolKey'      => $this->input->post('oetBchloginKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbStaUse')))? '1':'2',
                    );

                break;
                case '3': // URL + MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
         
                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQMainVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQMainUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQMainPassword'),
                        'FTUolKey'      => 'MQMain',
                        'FTUolgRmk'     => $this->input->post('oetBchMQMainRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQMainStaUse')))? '1':'2',
                    );
            
                    // Data MQDocument
                    $aDataMQDoc = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQDocVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQDocUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQDocPassword'),
                        'FTUolKey'      => 'MQDocument',
                        'FTUolgRmk'     => $this->input->post('oetBchMQDocRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQDocStaUse')))? '1':'2',
                    );

                    //Data MQSale
                    $aDataMQSale = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQSaleVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQSaleUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQSalePassword'),
                        'FTUolKey'      => 'MQSale',
                        'FTUolgRmk'     => $this->input->post('oetBchMQSaleRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQSaleStaUse')))? '1':'2',
                    );
                    
                    //Data MReport
                    $aDataMQReport = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQReportVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQReportUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQReportPassword'),
                        'FTUolKey'      => 'MQReport',
                        'FTUolgRmk'     => $this->input->post('oetBchMQReportRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQWalletStaUse')))? '1':'2',
                    );

                break;
                case '4' : // API2PSMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '5' : // API2PSSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '6' : // API2RTMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '7' : // API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '8' : // API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;

                case '12' : // Type 12 tBchURLAPI2API2ARDoc​
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;

                case '13' : // Type 13 tBchURLAPI2MQMember
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUolVhost'    => $this->input->post('oetBchMQMainVulHost'),  
                        'FTUolVhostOld'  => $this->input->post('oetBchMQMainVulHostOld'),  
                        'FTUolUser'     => $this->input->post('oetBchMQMainUsrAccount'),   
                        'FTUolUserOld'     => $this->input->post('oetBchMQMainUsrAccountOld'),  
                        'FTUolPassword' => $this->input->Post('oetBchMQMainPassword'),
                        'FTUolKey'      => 'MQMember',
                        'FTUolgRmk'     => $this->input->post('oetBchMQMainRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQMainStaUse')))? '1':'2',
                    );

                break;
                case '16': // MQAI
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                 
                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array( 
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchVulHost'),
                        'FTUolUser'     => $this->input->post('oetBchUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetBchPassword'),
                        'FTUolKey'      => 'MQAI',
                        'FTUolgRmk'     => $this->input->post('oetBchRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbStaUse')))? '1':'2',
                    );

                break;
                default : 
                    // ลงตาราง TCNTUrlObject
                    $aDataMasterUrlObj    = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputBchSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
            }

            $this->db->trans_begin();

            //For Check Address
            $aChkAddress  = $this->mSettingConnection->FSaMBchSetConCheckUrlAddress($aDataUrlObj); 

            //For Check UrlType
            $aChkUrlType  = $this->mSettingConnection->FSaMBchSetConCheckUrlType($aDataUrlObj);

                    if($aChkAddress['rtCode'] == 1){
                        // ถ้าข้อมูลซ้ำให้ออกลูป
                        $aReturn = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsucess Add Event"
                        );
                    }else{
                        switch($nUrlType){
                            case '1':  // Type 1 URL
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '2' : // Type 2 Url + AUthor
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlAuthor($aDataUrlObj,$aDataUrlObjlogin);
                            break;
                            case '3' :  // Type 3 url + MQ
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlMQ($aDataUrlObj,$aDataMQMain,$aDataMQDoc,$aDataMQSale,$aDataMQReport);
                            break;
                            case '4' : // Type 4 API2PSMaster
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '5' : // Type 5 API2PSSale
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '6' : // Type 6 API2RTMaster
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '7' : // Type 7 API2RTSale
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '8' : // Type 8 API2FNWallet
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '12' : // Type 8 tBchURLAPI2API2ARDoc​
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                            break;
                            case '13' : // Type 8 tBchURLAPI2MQMember
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddMasterUrlMQMember($aDataUrlObj,$aDataMQMain); 
                            break;
                            case '16' : // MQAI
                                $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlAuthor($aDataUrlObj,$aDataUrlObjlogin);
                            break;
                        }
                        //อัพเดท FDLastUpdOn ใน branch ด้วย
                        $aLastUpdate = array(
                            'FTBchCode'     => $this->input->post('oetSettingBchCode'),
                            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        );
                        $this->mSettingConnection->FSxMBchSetConSetLastUpdateOnBranch($aLastUpdate);

                        if($this->db->trans_status() === false){
                            $this->db->trans_rollback();
                            $aReturn = array(
                                'nStaEvent'    => '900',
                                'tStaMessg'    => "Unsucess Add Event"
                            );
                        }else{
                            $this->db->trans_commit();
                            if($tBchSettingCon != $tBchSettingConOld){
                                $aImageData = [
                                    'tModuleName'   => 'company', 
                                    'tImgFolder'    => 'BchSetCon',
                                    'tImgRefID'     => '0000'.$nCountSeq, 
                                    'tImgObj'       => $tBchSettingCon,
                                    'tImgTable'     => 'TCNTUrlObject',
                                    'tTableInsert'  => 'TCNMImgObj',
                                    'tImgKey'       => 'main',
                                    'dDateTimeOn'   => date('Y-m-d H:i:s'),
                                    'tWhoBy'        => $this->session->userdata('tSesUsername'),
                                    'nStaDelBeforeEdit' => 1
                                ]; 
                                FCNnHAddImgObj($aImageData);
                            }

                            //update Seq
                            $this->mSettingConnection->FSaMBchSetConUpdateSeqNumber();
                            
                            // Update Img Parth โดยดึงจาก ImageObj                  
                            $this->mSettingConnection->FSaMBchSetConAddUpdatePathUrl($aDataUrlObj);

                            $aReturn = array(
                                'nStaEvent'	    => '1',
                                'tStaMessg'		=> 'Success Add Event'
                            );
                        }
                    }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Edit SettingConnect
    //Parameters : From Ajax File Userlogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCUolConnectionEditEvent(){
        
        //imput Imge
        $tBchSettingConOld     = trim($this->input->post('oetImgInputSetConOld'));
        $tBchSettingCon        = trim($this->input->post('oetImgInputSetCon')); 

        $nUrlType       = $this->input->post('ocmUrlConnecttype');
        $tOldKeyUrl     = $this->input->post('ohdKeyUrl');
        $tNewKeyUrl     = $this->input->post('oetBchServerip');
        $toldUrltype    = $this->input->post('ohdurltype');


        $nCountSeq   = $this->mSettingConnection->FSnMCountSeq();


        if($toldUrltype !=  $nUrlType){
            //วิ่งไปลบข้อมูลก่อนเพราะ เปลี่ยน type เดียวมันจะวิ่งไปที่ขา insert เอง
            $this->mSettingConnection->FSaMRemoveDataBecauseChangeType($tOldKeyUrl); 
            $aReturn = array(
                'nStaEvent'    => '800',
                'tStaMessg'    => "Unsucess Add Event"
            );
            echo json_encode($aReturn);
        }
        else{
            if($tOldKeyUrl == $tNewKeyUrl){
                //รหัสเก่า รหัสใหม่ ไม่ถูกเปลี่ยน
                $bChkAddress = false;
            }else{
                //รหัสใหม่ถูกเปลี่ยน
                $bChkAddress = true;

            }

            switch($nUrlType){
                case '1': // Type 1 URL
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                break;
                case '2': // Type 2 URL + Authorized"
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                
                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array( 
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchVulHost'),
                        'FTUolUser'     => $this->input->post('oetBchUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetBchPassword'),
                        'FTUolKey'      => $this->input->post('oetBchloginKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbStaUse')))? '1':'2',
                    );
                break;
                case '3': // Type 3 URL + MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
        
                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'),  // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQMainVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQMainUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQMainPassword'),
                        'FTUolKey'      => $this->input->post('oetBchMQMainKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchMQMainRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQMainStaUse')))? '1':'2',
                    );
            
                    // Data MQDocument
                    $aDataMQDoc = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQDocVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQDocUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQDocPassword'),
                        'FTUolKey'      => $this->input->post('oetBchMQDocKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchMQDocRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQDocStaUse')))? '1':'2',
                    );

                    //Data MQSale
                    $aDataMQSale = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQSaleVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQSaleUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQSalePassword'),
                        'FTUolKey'      => $this->input->post('oetBchMQSaleKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchMQSaleRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQSaleStaUse')))? '1':'2',
                    );
                    
                    //Data MReport
                    $aDataMQReport = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchMQReportVulHost'),  
                        'FTUolUser'     => $this->input->post('oetBchMQReportUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQReportPassword'),
                        'FTUolKey'      => $this->input->post('oetBchMQReportKey'),
                        'FTUolgRmk'     => $this->input->post('oetBchMQReportRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQWalletStaUse')))? '1':'2',
                    );

                break;
                case '4': // Type 4 API2PSMaster 
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '5' : // Type 5 API2PSSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '6' : // Type 6 API2RTMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '7' : // Type 7 API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;
                case '8' : // Type 8 API2FNWallet
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;

                case '12' : // Type 12 tBchURLAPI2API2ARDoc​
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                break;

                case '13' : // Type 13 tBchURLAPI2MQMember
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), 
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUolVhostOld'    => $this->input->post('oetBchMQMainVulHostOld'),  
                        'FTUolVhost'    => $this->input->post('oetBchMQMainVulHost'), 
                        'FTUolUserOld'     => $this->input->post('oetBchMQMainUsrAccountOld'),  
                        'FTUolUser'     => $this->input->post('oetBchMQMainUsrAccount'),   
                        'FTUolPassword' => $this->input->Post('oetBchMQMainPassword'),
                        'FTUolKey'      => 'MQMember',
                        'FTUolgRmk'     => $this->input->post('oetBchMQMainRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbMQMainStaUse')))? '1':'2',
                    );

                break;
                case '16': // MQAI
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq, 
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                
                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array( 
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetBchVulHost'),
                        'FTUolUser'     => $this->input->post('oetBchUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetBchPassword'),
                        'FTUolKey'      => 'MQAI',
                        'FTUolgRmk'     => $this->input->post('oetBchRemark'),
                        'FTUolStaActive'=> (!empty($this->input->post('ocbStaUse')))? '1':'2',
                        'tWhereCondition'=> $this->input->post('ohdWhere'),
                    );
                break;

                default : 
                    // ลงตาราง TCNTUrlObject
                    $aDataMasterUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => $this->input->post('oetSettingBchCode'), // Where BranchCode
                        'FNUrlSeq'      => '0000'.$nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMBranch',
                        'FTUrlKey'      => $this->input->post('oetBchUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetBchServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetBchServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetBchPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
            }
            
            if($bChkAddress == true){
                $aChkAddress  = $this->mSettingConnection->FSaMBchSetConCheckUrlAddress($aDataUrlObj); 
                if( $aChkAddress['rtCode'] == 1 && $bChkAddress == true){
                    // ถ้าซ้ำให้ออกลูป
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                    $tPass  = false;
                }else{
                    $tPass  = true;    
                }
            }else{
            // ถ้า tPass =  true มันก็จะ วิ่งไปที่ update normal  
                $tPass  = true;
            }

            
            // Update data normal
            if($tPass  ==  true){
                switch($nUrlType){
                    case '1':  // Type 1 URL
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;
                    case '2' : //Type 2 Url + AUthor
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj,$aDataUrlObjlogin,$tOldKeyUrl);
                    break;
                    case '3' :  // Type 3 url + MQ
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlMQUpdate($aDataUrlObj,$aDataMQMain,$aDataMQDoc,$aDataMQSale,$aDataMQReport,$tOldKeyUrl);
                    break;
                    case '4':  // Type 4 API2PSMaster
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;
                    case '5' : // Type 5 API2PSSale
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;
                    case '6' : // Type 6 API2RTMaster
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;

                    case '7' : // Type 7 API2RTSale
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;
                    
                    case '8' : // Type 8  API2FNWallet
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlUpdate($aDataUrlObj,$tOldKeyUrl); 
                    break;
                    case '12' : // Type 8 tBchURLAPI2API2ARDoc​
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrl($aDataUrlObj); 
                    break;
                    case '13' : // Type 8 tBchURLAPI2MQMember
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddMasterUrlMQMember($aDataUrlObj,$aDataMQMain); 
                    break;
                    case '16' : //MQAI
                        $aStaMaster  = $this->mSettingConnection->FSaMBchSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj,$aDataUrlObjlogin,$tOldKeyUrl);
                    break;
                }
                        //อัพเดท FDLastUpdOn ใน branch ด้วย
                        $aLastUpdate = array(
                            'FTBchCode'     => $this->input->post('oetSettingBchCode'),
                            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        );
                        $this->mSettingConnection->FSxMBchSetConSetLastUpdateOnBranch($aLastUpdate);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tBchSettingCon != $tBchSettingConOld){
                        $aImageData = [
                            'tModuleName'   => 'company', 
                            'tImgFolder'    => 'BchSetCon',
                            'tImgRefID'     => '0000'.$nCountSeq, 
                            'tImgObj'       => $tBchSettingCon,
                            'tImgTable'     => 'TCNTUrlObject',
                            'tTableInsert'  => 'TCNMImgObj',
                            'tImgKey'       => 'main',
                            'dDateTimeOn'   => date('Y-m-d H:i:s'),
                            'tWhoBy'        => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        ]; 
                        FCNnHAddImgObj($aImageData);
                    }

                   //update Seq                    
                   $this->mSettingConnection->FSaMBchSetConUpdateSeqNumber();        
                                
                   // Update Img Parth โดยดึงจาก ImageObj
                   $this->mSettingConnection->FSaMBchSetConAddUpdatePathUrl($aDataUrlObj);

                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        }
    }


    //Functionality : Event Delete BchSettingConnection
    //Parameters : Ajax jReason()
    //Creator : 18/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCUolConnectionDeleteEvent(){

        $tUrlID       =  $this->input->post('tUrlID');
        $tUrlAddress  =  $this->input->post('tUrlAddress');
        $tUrlType     =  $this->input->post('tUrlType');
        $tUrlRefID    = $this->input->post('tBchCode');
        
        $aDataMaster = array(
            'FNUrlID'      => $tUrlID,
            'FNUrlType'    => $tUrlType,
            'FTUrlAddress' => $tUrlAddress,
            'FTUrlRefID'    => $tUrlRefID
        );

        $aResDel        = $this->mSettingConnection->FSnMSettingConLDel($aDataMaster);
        //Update Seqent number
        $this->mSettingConnection->FSaMBchSetConUpdateSeqNumber();
        $nNumRowRsnLoc  = $this->mSettingConnection->FSnMSettingConGetAllNumRow();
        
     

        if($nNumRowRsnLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }
    }


    //Functionality : Event Delete Multi BchSettingConnection
    //Parameters : Ajax jReason()
    //Creator : 18/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCUolConnectionDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $tUrlID       =  $this->input->post('tUrlID');
            $tUrlAddress  =  $this->input->post('tAddress');

            $aDataDeleteMuti = array(
               'FNUrlID'       => $tUrlID,
               'FTUrlAddress'  => $tUrlAddress
            );

            $tResult    = $this->mSettingConnection->FSaMSetingConnDeleteMultiple($aDataDeleteMuti);
            
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Delete Data Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Multiple'
                );
            }
        }catch(Exception $Error){
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }
}