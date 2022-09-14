<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCompSettingConnection extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/compsettingconnection/mCompSettingConnection');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Functionality : Function Call Page Main
    //Parameters : From Ajax File CompSettingConnect
    //Creator : 19/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCompConnectMainPage()
    {

        $vBtnSaveGpCompSettingCon    = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');
        $aAlwEventCompSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        //Get data CompCode
        $tCompCode  =    $this->input->post('tCompCode');

        $aCompCodeSetConnect = array(
            'tCompCode' =>  $tCompCode
        );

        $this->load->view('company/compsettingconnection/wCompSettingConnectMain', array(
            'vBtnSaveGpCompSettingCon'   => $vBtnSaveGpCompSettingCon,
            'aAlwEventCompSettingCon'    => $aAlwEventCompSettingCon,
            'aCompCodeSetConnect'       => $aCompCodeSetConnect
        ));
    }

    //Functionality : List Data 
    //Parameters : From Ajax File CompSettingConnection
    //Creator : 19/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCompConnectDataList()
    {

        $tCompCode      = $this->input->post('tCompCode');
        $tSearchAll     = $this->input->post('tSearchAll');
        $nPage          = $this->input->post('nPageCurrent');
        $tUrlType       = $this->input->post('');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage  = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธ
        $aAlwEventCompSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        $aData = array(
            'FTUrlRefID'    => $tCompCode,
            'nPage'        => $nPage,
            'nRow'         => 10,
            'FNLngID'      => $nLangEdit,
            'tSearchAll'   => $tSearchAll,
        );

        $aResList    = $this->mCompSettingConnection->FSaMCompSetConnectDataList($aData);

        // Check URL Type
        $aCheckUrlType = $this->mCompSettingConnection->FSaMCompSetConCheckUrlType($aData);

        $aGenTable  = array(
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'FTUrlRefID'        => $tCompCode,
            'aCheckUrlType'     => $aCheckUrlType,
            'aAlwEventCompSettingCon' => $aAlwEventCompSettingCon,
        );

        //Return Data View
        $this->load->view('company/compsettingconnection/wCompSettingConnectDataTable', $aGenTable);
    }


    //Functionality :  Load Page Add CompSettingConnection 
    //Parameters : 
    //Creator : 19/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCCompConnectPageAdd()
    {

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveGpCompSettingCon    = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');
        $aAlwEventCompSettingCon     = FCNaHCheckAlwFunc('CompSettingCon/0/0');

        // Get CompCode
        $tCompCode =  $this->input->post('tCompCode');

        $aCompCodeSetAuthen     = array(
            'tCompCode' => $tCompCode,
        );

        $aDataAdd   = array(
            'aResult'       => array('rtCode' => '99'),
            'vBtnSaveGpCompSettingCon'  => $vBtnSaveGpCompSettingCon,
            'aAlwEventCompSettingCon'   => $aAlwEventCompSettingCon,
            'aCompCodeSetAuthen'        => $aCompCodeSetAuthen,
            'dGetDataNow'               => $dGetDataNow,
            'dGetDataFuture'            => $dGetDataFuture
        );

        $this->load->view('company/compsettingconnection/wCompSettingConnectAdd', $aDataAdd);
    }

    //Functionality :  Load Page Edit CompSettingConnection 
    //Parameters : 
    //Creator : 12/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCompConnectPageEdit()
    {

        $dGetDataNow                = date('Y-m-d');
        $dGetDataFuture             = date('Y-m-d', strtotime('+1 year'));
        $nLangEdit                  = $this->session->userdata("tLangEdit");
        $vBtnSaveGpCompSettingCon   = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0');
        $aAlwEventCompSettingCon    = FCNaHCheckAlwFunc('CompSettingCon/0/0');
        $nLangResort                = $this->session->userdata("tLangID");
        $tCompCode                  = $this->input->post('tCompCode');
        $tUrlID                     = $this->input->post('tUrlID');

        $aData   = array(
            'FTUrlRefID'    => $tCompCode,
            'FNUrlID'       => $tUrlID,
            'FNLngID'       => $nLangEdit,
        );

        // TCNTUrlObject
        $aResult    = $this->mCompSettingConnection->FSaMCompGetConCheckID($aData);


        if (isset($aResult['raItems']['rtSetConImage']) && !empty($aResult['raItems']['rtSetConImage'])) {
            $tImgObj        = $aResult['raItems']['rtSetConImage'];
            $aImgObj        = explode("application/modules/", $tImgObj);
            $aImgObjName    = explode("/", $tImgObj);
            $tImgObjAll        = $aImgObj[1];
            $tImgName        = end($aImgObjName);
        } else {
            $tImgObjAll     = "";
            $tImgName       = "";
        }

        $aCompCodeSetAuthen    = array(
            'tCompCode'     => $tCompCode
        );

        $aDataEdit      = array(
            'aResult'           => $aResult,
            'dGetDataNow'       => $dGetDataNow,
            'dGetDataFuture'    => $dGetDataFuture,
            'tImgObjAll'        => $tImgObjAll,
            'tImgName'          => $tImgName,
            'aCompCodeSetAuthen'        => $aCompCodeSetAuthen,
            'vBtnSaveGpCompSettingCon'  => $vBtnSaveGpCompSettingCon,
            'aAlwEventCompSettingCon'   => $aAlwEventCompSettingCon
        );

        $this->load->view('company/compsettingconnection/wCompSettingConnectAdd', $aDataEdit);
    }

    //Functionality : Function Add CompSettingConnection
    //Parameters : From Ajax File CompSettingConnection
    //Creator : 20/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCompConnectAddEvent()
    {
        try {
            $tRefIDSeq       =  $this->input->post('ohdCompCode');

            //imput Imge
            $tCompSettingConOld     = trim($this->input->post('oetImgInputCompSetConOld'));
            $tCompSettingCon        = trim($this->input->post('oetImgInputCompSetCon'));

            $nCountSeq   = $this->mCompSettingConnection->FSnMCompCountSeq();
            $nCountSeq   = $nCountSeq + 1;


            $nUrlType    = $this->input->post('ocmUrlConnecttype');

            //MqMain
            $tUolVhostMq        = $this->input->post('oetCompMQMainVulHost');
            $tUolUserMq         = $this->input->post('oetCompMQMainUsrAccount');

            //MqDoc
            $tUolVhostMqDoc     = $this->input->post('oetCompMQDocVulHost');
            $tUolUserMqDoc      = $this->input->post('oetCompMQDocUsrAccount');

            //MqSale
            $tUolVhostMqSale    = $this->input->post('oetCompMQSaleVulHost');
            $tUolUserMqSale     = $this->input->post('oetCompMQSaleUsrAccount');

            //MqWallet
            $tUolVhostMqWallet  = $this->input->post('oetCompMQWalletVulHost');
            $tUolUserMqReport   = $this->input->post('oetCompMQWalletUsrAccount');

            switch ($nUrlType) {
                case '1': // URL
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );
                    break;
                case '2': // URL + Authorized
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'     => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'      => $this->input->post('oetCompVulHost'),
                        'FTUolUser'       => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword'   => $this->input->post('oetCompPassword'),
                        'FTUolKey'        => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'       => $this->input->post('oetCompRemark'),
                        'FTUolStaActive'  => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                    );
                    break;
                case '3': // URL + MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQMainVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQMainUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQMainPassword'),
                        'FTUolKey'      => 'MQMain',
                        'FTUolgRmk'     => $this->input->post('oetCompMQMainRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQMainStaUse'))) ? '1' : '2',
                    );

                    // Data MQDocument
                    $aDataMQDoc = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQDocVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQDocUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQDocPassword'),
                        'FTUolKey'      => 'MQDocument',
                        'FTUolgRmk'     => $this->input->post('oetCompMQDocRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQDocStaUse'))) ? '1' : '2',
                    );

                    //Data MQSale
                    $aDataMQSale = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQSaleVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQSaleUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQSalePassword'),
                        'FTUolKey'      => 'MQSale',
                        'FTUolgRmk'     => $this->input->post('oetCompMQSaleRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQSaleStaUse'))) ? '1' : '2',
                    );

                    //Data MQWallet
                    $aDataMQWallet = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQWalletVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQWalletUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQWalletPassword'),
                        'FTUolKey'      => 'MQWallet',
                        'FTUolgRmk'     => $this->input->post('oetCompMQWalletRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQWalletStaUse'))) ? '1' : '2',
                    );

                    break;
                case '4': // API2PSMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '5': // API2PSSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '6': // API2RTMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '7': // API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '8': // API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '9':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );
                    break;
                case '10':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );
                    break;
                case '11':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'     => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );
                    break;

                case '12': // Type 12 tCompURLAPI2API2ARDoc​
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '13': // Type 13 tCompURLAPI2MQMember
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUolVhost'    => $this->input->post('oetCompMQMainVulHost'),
                        'FTUolVhostOld'  => $this->input->post('oetCompMQMainVulHostOld'),
                        'FTUolUser'     => $this->input->post('oetCompMQMainUsrAccount'),
                        'FTUolUserOld'     => $this->input->post('oetCompMQMainUsrAccountOld'),
                        'FTUolPassword' => $this->input->Post('oetCompMQMainPassword'),
                        'FTUolKey'      => 'MQMember',
                        'FTUolgRmk'     => $this->input->post('oetCompMQMainRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQMainStaUse'))) ? '1' : '2',
                    );

                    break;

                case '14': // URL + Authorized
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'      => $this->input->post('oetCompVulHost'),
                        'FTUolUser'       => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword'   => $this->input->post('oetCompPassword'),
                        'FTUolKey'        => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'       => $this->input->post('oetCompRemark'),
                        'FTUolStaActive'  => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                    );
                    break;

                case '15': // URL + Authorized
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'      => $this->input->post('oetCompVulHost'),
                        'FTUolUser'       => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword'   => $this->input->post('oetCompPassword'),
                        'FTUolKey'        => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'       => $this->input->post('oetCompRemark'),
                        'FTUolStaActive'  => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                    );
                    break;

                case '16': // MQAI
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'      => $this->input->post('oetCompVulHost'),
                        'FTUolUser'       => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword'   => $this->input->post('oetCompPassword'),
                        'FTUolKey'        => 'MQAI',
                        'FTUolgRmk'       => $this->input->post('oetCompRemark'),
                        'FTUolStaActive'  => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                    );
                    break;

                case '17': // MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FNUrlSeq'        => $nCountSeq,
                        'FNUrlType'       => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'      => 'TCNMComp',
                        'FTUrlKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'       => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'       => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                        'FTCreateBy'      => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'      => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'      => 'CENTER',
                        'FTUrlAddress'    => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'      => $this->input->post('oetCompVulHost'),
                        'FTUolUser'       => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword'   => $this->input->post('oetCompPassword'),
                        'FTUolKey'        => $this->input->post('oetCompUrlKey'),
                        'FTUolgRmk'       => $this->input->post('oetCompRemark'),
                        'FTUolStaActive'  => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                    );
                    break;

                default:
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
            }

            $this->db->trans_begin();

            $aChkAddress  = $this->mCompSettingConnection->FSaMCompSetConCheckUrlAddress($aDataUrlObj);

            if ($aChkAddress['rtCode'] == 1) {
                // ถ้าข้อมูลซ้ำให้ออกลูป
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                switch ($nUrlType) {
                    case '1':  // Type 1 URL
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '2': // Type 2 Url + AUthor
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthor($aDataUrlObj, $aDataUrlObjlogin);
                        break;
                    case '3':  // Type 3 url + MQ
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlMQ($aDataUrlObj, $aDataMQMain, $aDataMQDoc, $aDataMQSale, $aDataMQWallet);
                        break;
                    case '4': // Type 4 API2PSMaster
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '5': // Type 5 API2PSSale
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '6': // Type 6 API2RTMaster
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '7': // Type 7 API2RTSale
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '8': // Type 8 API2FNWallet
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '9':  // Type 9 
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '10':  // Type 10
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '11':  // Type 11
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '12': // Type 8 tCompURLAPI2API2ARDoc​
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '13': // Type 8 tCompURLAPI2MQMember
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddMasterUrlMQMember($aDataUrlObj, $aDataMQMain);
                        break;
                    case '14': // Type 2 Url + AUthor
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthor($aDataUrlObj, $aDataUrlObjlogin);
                        break;
                    case '15': // Type 2 Url + AUthor
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthor($aDataUrlObj, $aDataUrlObjlogin);
                        break;
                    case '16': // Type 2 MQAI
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthor($aDataUrlObj, $aDataUrlObjlogin);
                        break;
                    case '17': // Type 2 MQ
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthor($aDataUrlObj, $aDataUrlObjlogin);
                        break;
                }

                //อัพเดท FDLastUpdOn ใน branch ด้วย
                $aLastUpdate = array(
                    'FTCmpCode'     => $this->input->post('ohdCompCode'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                );
                $this->mCompSettingConnection->FSxMCompSetConSetLastUpdateOnBranch($aLastUpdate);


                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    if ($tCompSettingCon != $tCompSettingConOld) {
                        $aImageData = [
                            'tModuleName'   => 'company',
                            'tImgFolder'    => 'CompSetCon',
                            'tImgRefID'     =>  '0000' . $nCountSeq,
                            'tImgObj'       => $tCompSettingCon,
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
                    $this->mCompSettingConnection->FSaMCompSetConUpdateSeqNumber();

                    // Update Img Parth โดยดึงจาก ImageObj
                    $this->mCompSettingConnection->FSaMCompSetConAddUpdatePathUrl($aDataUrlObj);


                    $aReturn = array(
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function Edit SettingConnect
    //Parameters : From Ajax File Userlogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCompConnectEditEvent()
    {

        //imput Imge
        $tCompSettingConOld     = trim($this->input->post('oetImgInputCompSetConOld'));
        $tCompSettingCon        = trim($this->input->post('oetImgInputCompSetCon'));

        $nUrlType       = $this->input->post('ocmUrlConnecttype');
        $tOldKeyUrl     = $this->input->post('ohdKeyUrl');
        $tNewKeyUrl     = $this->input->post('oetCompServerip');
        $toldUrltype    = $this->input->post('ohdurltype');

        $nCountSeq      = $this->mCompSettingConnection->FSnMCompCountSeq();


        if ($toldUrltype !=  $nUrlType) {
            //วิ่งไปลบข้อมูลก่อนเพราะ เปลี่ยน type เดียวมันจะวิ่งไปที่ขา insert เอง
            $this->mCompSettingConnection->FSaMCompRemoveDataBecauseChangeType($tOldKeyUrl);
            $aReturn = array(
                'nStaEvent'    => '800',
                'tStaMessg'    => "Unsucess Add Event"
            );
            echo json_encode($aReturn);
        } else {
            if ($tOldKeyUrl == $tNewKeyUrl) {
                //รหัสเก่า รหัสใหม่ ไม่ถูกเปลี่ยน
                $bChkAddress = false;
            } else {
                //รหัสใหม่ถูกเปลี่ยน
                $bChkAddress = true;
            }
            switch ($nUrlType) {
                case '1': // Type 1 URL
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
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
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetCompPassword'),
                        'FTUolKey'      => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                        'tWhereCondition' => $this->input->post('ohdWhere'),
                    );

                    break;
                case '3': // Type 3 URL + MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQMainVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQMainUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQMainPassword'),
                        'FTUolKey'      => $this->input->post('oetCompMQMainKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompMQMainRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQMainStaUse'))) ? '1' : '2',
                    );

                    // Data MQDocument
                    $aDataMQDoc = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQDocVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQDocUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQDocPassword'),
                        'FTUolKey'      => $this->input->post('oetCompMQDocKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompMQDocRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQDocStaUse'))) ? '1' : '2',
                    );

                    //Data MQSale
                    $aDataMQSale = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQSaleVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQSaleUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQSalePassword'),
                        'FTUolKey'      => $this->input->post('oetCompMQSaleKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompMQSaleRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQSaleStaUse'))) ? '1' : '2',
                    );

                    //Data MQWallet
                    $aDataMQWallet = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQWalletVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompMQWalletUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQWalletPassword'),
                        'FTUolKey'      => $this->input->post('oetCompMQReportKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompMQWalletRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQWalletStaUse'))) ? '1' : '2',
                    );

                    break;

                case '4': // Type 4 API2PSMaster 
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '5': // Type 5 API2PSSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '6': // Type 6 API2RTMaster
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '7': // Type 7 API2RTSale
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '8': // Type 8 API2FNWallet
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '9':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '10':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;
                case '11':
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;

                case '12': // Type 12 tCompURLAPI2API2ARDoc​
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
                    break;

                case '13': // Type 13 tCompURLAPI2MQMember
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    // Data MQMain
                    $aDataMQMain = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUolVhostOld'    => $this->input->post('oetCompMQMainVulHostOld'),
                        'FTUolVhost'    => $this->input->post('oetCompMQMainVulHost'),
                        'FTUolUserOld'     => $this->input->post('oetCompMQMainUsrAccountOld'),
                        'FTUolUser'     => $this->input->post('oetCompMQMainUsrAccount'),
                        'FTUolPassword' => $this->input->Post('oetCompMQMainPassword'),
                        'FTUolKey'      => 'MQMember',
                        'FTUolgRmk'     => $this->input->post('oetCompMQMainRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbMQMainStaUse'))) ? '1' : '2',
                    );

                    break;

                case '14': // Type 2 URL + Authorized"
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetCompPassword'),
                        'FTUolKey'      => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                        'tWhereCondition' => $this->input->post('ohdWhere'),
                    );
                    break;

                case '15': // Type 2 URL + Authorized"
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetCompPassword'),
                        'FTUolKey'      => $this->input->post('oetComploginKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                        'tWhereCondition' => $this->input->post('ohdWhere'),
                    );
                    break;

                case '16': // MQAI
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetCompPassword'),
                        'FTUolKey'      => 'MQAI',
                        'FTUolgRmk'     => $this->input->post('oetCompRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                        'tWhereCondition' => $this->input->post('ohdWhere'),
                    );
                    break;

                case '17': // MQ
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FNUrlID'       => $this->input->post('ohdUrlId'),
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    // TCNTUrlObjectLogin
                    $aDataUrlObjlogin = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlAddressOld' => $this->input->post('oetCompServeripOld'),
                        'FTUolVhost'    => $this->input->post('oetCompVulHost'),
                        'FTUolUser'     => $this->input->post('oetCompUsrAccount'),
                        'FTUolPassword' => $this->input->post('oetCompPassword'),
                        'FTUolKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUolgRmk'     => $this->input->post('oetCompRemark'),
                        'FTUolStaActive' => (!empty($this->input->post('ocbStaUse'))) ? '1' : '2',
                        'tWhereCondition' => $this->input->post('ohdWhere'),
                    );
                    break;

                default:
                    // ลงตาราง TCNTUrlObject
                    $aDataUrlObj    = array(
                        'FTUrlRefID'    => 'CENTER',
                        'FNUrlSeq'      => '0000' . $nCountSeq,
                        'FNUrlType'     => $this->input->post('ocmUrlConnecttype'),
                        'FTUrlTable'    => 'TCNMComp',
                        'FTUrlKey'      => $this->input->post('oetCompUrlKey'),
                        'FTUrlAddress'  => $this->input->post('oetCompServerip'),
                        'FTUrlPort'     => $this->input->post('oetCompPortConnect'),
                        'FTUrlLogo'     => $this->input->post('oetImgInputCompSetCon'),
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );
            }
            if ($bChkAddress == true) {
                $aChkAddress  = $this->mCompSettingConnection->FSaMCompSetConCheckUrlAddressUpdate($aDataUrlObj);

                if ($aChkAddress['rtCode'] == 1 && $bChkAddress == true) {
                    // ถ้าซ้ำให้ออกลูป
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                    $tPass  = false;
                } else {
                    $tPass  = true;
                }
            } else {
                // ถ้า tPass =  true มันก็จะ วิ่งไปที่ update normal  
                $tPass  = true;
            }


            // Update data normal
            if ($tPass  ==  true) {
                switch ($nUrlType) {
                    case '1':  // Type 1 URL
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;

                    case '2': //Type 2 Url + AUthor
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj, $aDataUrlObjlogin, $tOldKeyUrl);
                        break;
                    case '3':  // Type 3 url + MQ
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlMQUpdate($aDataUrlObj, $aDataMQMain, $aDataMQDoc, $aDataMQSale, $aDataMQWallet, $tOldKeyUrl);
                        break;
                    case '4':  // Type 4 API2PSMaster
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '5': // Type 5 API2PSSale
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '6': // Type 6 API2RTMaster
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;

                    case '7': // Type 7 API2RTSale
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;

                    case '8': // Type 8  API2FNWallet
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '9':  // Type 9
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '10': //Type 10
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '11':  // Type 11
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlUpdate($aDataUrlObj, $tOldKeyUrl);
                        break;
                    case '12': // Type 8 tBchURLAPI2API2ARDoc​
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrl($aDataUrlObj);
                        break;
                    case '13': // Type 8 tBchURLAPI2MQMember
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddMasterUrlMQMember($aDataUrlObj, $aDataMQMain);
                        break;
                    case '14': // Type 8 tBchURLAPI2MQMember
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj, $aDataUrlObjlogin, $tOldKeyUrl);
                        break;
                    case '15': // Type 8 tBchURLAPI2MQMember
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj, $aDataUrlObjlogin, $tOldKeyUrl);
                        break;
                    case '16': // MQAI
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj, $aDataUrlObjlogin, $tOldKeyUrl);
                        break;
                    case '17': // MQ
                        $aStaMaster  = $this->mCompSettingConnection->FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($aDataUrlObj, $aDataUrlObjlogin, $tOldKeyUrl);
                        break;
                }

                //อัพเดท FDLastUpdOn ใน Comp ด้วย
                $aLastUpdate = array(
                    'FTCmpCode'     => $this->input->post('ohdCompCode'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                );

                $this->mCompSettingConnection->FSxMCompSetConSetLastUpdateOnBranch($aLastUpdate);


                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                } else {
                    $this->db->trans_commit();
                    if ($tCompSettingCon != $tCompSettingConOld) {
                        $aImageData = [
                            'tModuleName'   => 'company',
                            'tImgFolder'    => 'CompSetCon',
                            'tImgRefID'     => '0000' . $nCountSeq,
                            'tImgObj'       => $tCompSettingCon,
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
                    $this->mCompSettingConnection->FSaMCompSetConUpdateSeqNumber();

                    // Update Img Parth โดยดึงจาก ImageObj
                    $this->mCompSettingConnection->FSaMCompSetConAddUpdatePathUrl($aDataUrlObj);

                    $aReturn = array(
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        }
    }


    //Functionality : Event Delete CompSettingConnection
    //Parameters : Ajax jReason()
    //Creator : 18/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCompConnectDeleteEvent()
    {
        $tUrlID       =  $this->input->post('tUrlID');
        $tUrlAddress  =  $this->input->post('tUrlAddress');
        $tUrlType     =  $this->input->post('tUrlType');
        $tUrlRefID    = $this->input->post('tUrlRefID');

        $aDataMaster = array(
            'FNUrlID'      => $tUrlID,
            'FNUrlType'    => $tUrlType,
            'FTUrlAddress' => $tUrlAddress
        );

        $aResDel       = $this->mCompSettingConnection->FSnMCompSettingConDel($aDataMaster);

        //Update Seqent number
        $this->mCompSettingConnection->FSaMCompSetConUpdateSeqNumber();
        $nNumRowRsnLoc  = $this->mCompSettingConnection->FSnMCompSettingConGetAllNumRow();

        if ($nNumRowRsnLoc) {
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        } else {
            echo "database error";
        }
    }

    //Functionality : Event Delete Multi CompSettingConnection
    //Parameters : Ajax ()
    //Creator : 18/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function  FSoCCompConnectDelMultipleEvent()
    {
        try {
            $this->db->trans_begin();

            $tUrlID       =  $this->input->post('tUrlID');
            $tUrlAddress  =  $this->input->post('tAddress');

            $aDataDeleteMuti = array(
                'FNUrlID'       => $tUrlID,
                'FTUrlAddress'  => $tUrlAddress
            );

            $tResult    = $this->mCompSettingConnection->FSaMCompSetingConnDeleteMultiple($aDataDeleteMuti);

            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Delete Data Multiple'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Multiple'
                );
            }
        } catch (Exception $Error) {
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }
}
