<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cCommon extends MX_Controller {

    public $tPublicAPI;

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('common/mCommon');
        $this->load->model('register/BuyLicense/mBuyLicense');
    }

    public function FCNtCCMMErrorRoute() {
        $this->load->view('common/wErrorPage');
    }

    public function FCNtCCMMGenCode() {

        $tTableName = $this->input->post('tTableName');
        $tGencode = FCNaHGencode($tTableName);

        echo json_encode($tGencode);
    }

    public function FCNtCCMMGenCodeV5() {

        $tTableName = $this->input->post('tTableName');
        $tStaDoc = $this->input->post('tStaDoc');
        // $tGencode	= FCNaHGencode($tTableName);
        $tGencode = FCNaHGenCodeV5($tTableName, $tStaDoc);

        echo json_encode($tGencode);
    }

    public function FCNtCCMMCheckInputGenCode() {

        $tTableName     = $this->input->post('tTableName');
        $ptFieldName    = $this->input->post('tFieldName');
        $tCode          = $this->input->post('tCode');

        //supawat 13-04-2020 เพิ่มไว้ เพราะมันต้องเช็คที่สาขาด้วย
        $tFiledBch      = $this->input->post('tFiledBch');
        if($tFiledBch == '' || $tFiledBch == null){
            $tFiledBch = '';
        }else{
            $tFiledBch = $tFiledBch;
        }

        $tCheck = FCNaHCheckInputGenCode($tTableName, $ptFieldName, $tCode , $tFiledBch);

        $nNum = $tCheck[0]->nNum;

        if ($nNum != '0') {
            $nStatus = '1';
            $tDesc = 'มี id นี้แล้วในระบบ';
        } else {
            $nStatus = '2';
            $tDesc = 'รหัสผ่านจะถูก Gen ใหม่';
        }

        $raChkCode = array(
            'rtCode' => $nStatus,
            'rtDesc' => $tDesc,
        );
        print_r(json_encode($raChkCode));
    }

    public function FCNtCCMMChangeLangList() {

        $tTableName = $this->input->post('tTableName');

        $aResLangList = FCNaHGetAllLangByTable($tTableName);
        $nLang = FCNnHSizeOf($aResLangList);
        $oDrpdwnLangEdit = '';
        $nSesLangEdit = $this->session->userdata("tLangEdit");
        if ($nLang > 1) {
            $oDrpdwnLangEdit .= "<div class='form-group'>";
            $oDrpdwnLangEdit .= "<div class='dropup' style='float: right;'>";
            $oDrpdwnLangEdit .= "<a href='javascript:void(0)' class='dropdown-toggle' data-toggle='dropdown' aria-expanded='true'><img class='xWLogoEditLang' src='" . base_url('application/modules/common/assets/images/use/' . $_SESSION['tLangEdit'] . ".png") . "' >  " . language('common/main/main', 'tLanguageType' . $_SESSION['tLangEdit']) . "<b class='caret'></b></a>";
            $oDrpdwnLangEdit .= "<ul class='dropdown-menu xWdropdown-menu'>";
            foreach ($aResLangList AS $aKey => $nValue) {
                $active = '';
                if ($nValue->nLangList == $nSesLangEdit) {
                    $active = "class='active'";
                }
                $oDrpdwnLangEdit .= "<li $active $nValue->nLangList><a onclick=JSvChangLangEdit('$nValue->nLangList')>";
                $oDrpdwnLangEdit .= "<img src='" . base_url() . "application/modules/common/assets/images/use/$nValue->nLangList.png'>  " . language('common/main/main', 'tLanguageType' . $nValue->nLangList) . "</a></li>";
            }
            $oDrpdwnLangEdit .= "</ul>";
            $oDrpdwnLangEdit .= "</div>";
            $oDrpdwnLangEdit .= "</div>";
        }

        echo $oDrpdwnLangEdit;
    }

    function FCNtCCMMGetLangSystem() {

        $tFSName = $this->input->post('tFSName');
        if ($tFSName == '') {
            $tFSName = 'null';
        }
        $tCode = $this->input->post('tCode');

        $aResLangList = FCNaHGetAllLangInSystem();
        $oDrpdwnLangEdit = '';

        if ($aResLangList[0]->FNLngID != '') {
            $oDrpdwnLangEdit .= "<div class='form-group'>";
            $oDrpdwnLangEdit .= "<div class='dropup' style='float: right;'>";
            $oDrpdwnLangEdit .= "<a href='javascript:void(0)' class='dropdown-toggle' data-toggle='dropdown' aria-expanded='true'><img class='xWLogoEditLang' src='" . base_url('application/modules/common/assets/images/use/' . $_SESSION['tLangEdit'] . ".png") . "' >  " . language('common/main/main', 'tLanguageType' . $_SESSION['tLangEdit']) . "<b class='caret'></b></a>";
            $oDrpdwnLangEdit .= "<ul class='dropdown-menu xWdropdown-menu'>";
            foreach ($aResLangList AS $aKey => $nValue) {

                $oDrpdwnLangEdit .= "<li><a onclick=JSvChangLangPageAddEdit('$nValue->FNLngID','$tFSName',$tFSName,'$tCode')>";
                $oDrpdwnLangEdit .= "<img src='" . base_url() . "application/modules/common/assets/images/use/$nValue->FNLngID.png'>  " . language('common/main/main', 'tLanguageType' . $nValue->FNLngID) . "</a></li>";
            }
            $oDrpdwnLangEdit .= "</ul>";
            $oDrpdwnLangEdit .= "</div>";
            $oDrpdwnLangEdit .= "</div>";
        }

        echo $oDrpdwnLangEdit;
    }
    
    function FStGetVateActiveByVatCode(){
        $tVatCode = $this->input->post('tVatCode');
        $oVatActive = FCNoHVatActiveList($tVatCode);
        
        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($oVatActive));
    }

    //Functionality : Function Update Password User Login
    //Parameters    : Ajax input type post
    //Creator       : 13/05/2020 Napat(Jame)
    //Last Update   : 16/11/2020 Napat(Jame) เพิ่มการดึง username จาก input
    //Return        : array Return Status Update
    //Return Type   : array
    public function FCNaCCMMChangePassword(){
        try{
            $aPackData = array(
                'nChkUsrSta'    => $this->input->post('pnChkUsrSta'),
                'tPasswordOld'  => $this->input->post('ptPasswordOld'),
                'tPasswordNew'  => $this->input->post('ptPasswordNew'),
                'FTUsrLogin'    => $this->input->post('ptUsrLogin'),                 //$this->session->userdata("tSesUserLogin")
                'tStaLogType'   => $this->input->post('ptStaLogType')
            );
            $aDataReturn = $this->mCommon->FCNaMCMMChangePassword($aPackData);
        }catch(Exception $Error){
            $aDataReturn     = array(
                'nCode' => 500,
                'tDesc' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }

    //Functionality : Function Get Massage RabbitMQ
    //Parameters    : Ajax input type post
    //Creator       : 5/11/2020 (Nale)
    //Return        : text
    //Return Type   : srting
    public function FCNtCCMMGetMassageProgress(){
        $aParam['tQname'] = $this->input->post('tQName');
        $aDocConfig = json_decode($this->input->post('tDocConfig'), true);
        $aParam['tVhostType'] = isset($aDocConfig['tVhostType'])?$aDocConfig['tVhostType']:"D";
        $tProgress = FCNxRabbitMQGetMassage($aParam);
        echo $tProgress;
    }

    //Functionality : Function Get Massage RabbitMQ MutiDocument
    //Parameters    : Ajax input type post
    //Creator       : 20/11/2020 (Nale)
    //Return        : text
    //Return Type   : srting
    public function FCNtCCMMGetMassageProgressMutiDocument(){
        $aParam['tQname']  = $this->input->post('tQName');
        $tProgress =  FCNxRabbitMQGetLastQueueMassage($aParam);
        echo $tProgress;
    }

    public function FSoCCOMGetPrivacy(){
		$aConfig = $this->mBuyLicense->FSxMBUYGetConfigAPI();
        if($aConfig['rtCode'] == '800'){
            $aReturnData = array(
                'tTitle' => 'APIFAIL'
            );
            echo '<script>FSvCMNSetMsgErrorDialog("เกิดข้อผิดพลาด ไม่พบ API ในการเชื่อมต่อ")</script>';
            exit;
        }else{
            $this->tPublicAPI = $aConfig['raItems'][0]['FTUrlAddress'];
        }

		//API CstPrivacy
        $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstPrivacy';
		$aAPIKey    = array(
			'tKey'      => 'X-API-KEY',
			'tValue'    => '12345678-1111-1111-1111-123456789410'
		);
        $aParam     = array(
            'ptLang'        => $this->session->userdata("tLangEdit"),
            'ptCstKey'      => '',
            'ptStaExcept'   => 1
        );
        $oResultCstPrivacy  = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
		echo json_encode($oResultCstPrivacy);
		// echo '555';
	}

    // Create By : Napat(Jame) 21/07/2021
    public function FCNaCallApiETAX(){

        $tTaxDocNo = $this->input->post('ptTaxDocNo');
        $tTaxType  = $this->input->post('ptTaxType');

        $tRefTax     = FCNtGetRefTax($tTaxDocNo,$tTaxType);
        $aConfigETAX = FCNaGetConfigApiETAX();
        $tAuth       = $aConfigETAX[0]['FTApiToken'];

        // echo $tTaxType;
        if( $tTaxType == "ABB" ){
            $tTableHD = "TPSTSalHD";
            $aHeader    = array(
                'Authorization'      => 'Bearer '.$tAuth,
                'Content-Type'       => 'application/json'
            );
            $tUrlApi    = $aConfigETAX[2]['FTApiURL'];
            $aParam     = json_encode([
                'SellerTaxId'            => FCNtGetBranchTaxNo()['FTAddTaxNo'],
                'TransactionCode'        => $tRefTax
            ]);
        }else{
            $tTableHD = "TPSTTaxHD";
            $aHeader    = array(
                'Authorization'      => 'Bearer '.$tAuth,
                'Content-Type'       => 'multipart/form-data'
            );
            $tUrlApi    = $aConfigETAX[4]['FTApiURL'];
            $aParam     = array(
                'SellerTaxId'           => FCNtGetBranchTaxNo()['FTAddTaxNo'],
                'SellerBranchId'        => FCNtGetBranchTaxNo()['FTBchRegNo'],
                'UserCode'              => $aConfigETAX[3]['FTApiLoginUsr'],
                'AccessKey'             => FCNtHAES128Decrypt($aConfigETAX[3]['FTApiLoginPwd']),
                'APIKey'                => $aConfigETAX[3]['FTApiToken'],
                'ServiceCode'           => '06',
                'TransactionCode'       => $tRefTax
            );
        }
        $aReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aHeader,'');

        $aDebugConfig = array(
            'tUrlApi'   => $tUrlApi,
            'aHeader'   => $aHeader,
            'aParam'    => $aParam
        );

        $aDataUpdHD = array(
            'tDocNo'    => $tTaxDocNo,
            'tTableHD'  => $tTableHD
        );

        if( isset($aReuslt['status']) ){
            if( $aReuslt['status'] == 'OK' ){
                $nUpdStatus = "1";
                $aReturn = array(
                    'tReturnData'   => $aReuslt,
                    'tReturnCode'   => '1',
                    'tReturnMsg'    => 'Success',
                    'aDebugConfig'  => $aDebugConfig
                );
            }else{
                $nUpdStatus = "3";
                $aReturn = array(
                    'tReturnData'   => $aReuslt,
                    'tReturnCode'   => $aReuslt['errorCode'],
                    'tReturnMsg'    => $aReuslt['errorMessage'],
                    'aDebugConfig'  => $aDebugConfig
                );
            }
            FCNxHUpdateETaxStatus($aDataUpdHD,$nUpdStatus);
        }else{
            $aReturn = array(
                'tReturnCode'   => $aReuslt['errorCode'],
                'tReturnMsg'    => $aReuslt['errorMessage'],
                'aDebugConfig'  => $aDebugConfig
            );
        }
        echo json_encode($aReturn);
    }

    // Create By : Napat(Jame) 22/06/2022
    public function FCNaCChkStkB4ApvDoc(){
        $aParams = $this->input->post('paParams');
        $aWahChkStk     = $this->mCommon->FCNaMWahChkStk($aParams);
        if( $aWahChkStk['nCode'] == 1 ){
            $aDataDocApv        = $this->mCommon->FCNaMGetDocInvPendingApv($aParams);
            $aDataNotEnoughQty  = $this->mCommon->FCNaMGetNotEnoughQty($aParams);

            if( $aDataDocApv['nCode'] == 1 || $aDataNotEnoughQty['nCode'] == 1 ){

                $tTextMsg = "";
                if( $aDataDocApv['nCode'] == 1 ){
                    $tTextMsg .= "มีเอกสารค้างอนุมัติ ";
                }else{
                    $tTextMsg .= "ไม่มีเอกสารค้างอนุมัติ ";
                }

                if( $aDataNotEnoughQty['nCode'] == 1 ){
                    $tTextMsg .= "สินค้าในคลังไม่เพียงพอในการทำเอกสาร";
                }else{
                    $tTextMsg .= "สินค้าในคลังเพียงพอในการทำเอกสาร";
                }

                $aReturn = array(
                    'aSection1' => array(
                        'tHtmlRender'   => $this->load->view('common/chkstkb4apvdoc/wDataTableSection1', $aDataDocApv, true),
                        'nStaEvent'     => $aDataDocApv['nCode'],
                        'tStaMessg'     => $aDataDocApv['tDesc']
                    ),
                    'aSection2' => array(
                        'tHtmlRender'   => $this->load->view('common/chkstkb4apvdoc/wDataTableSection2', $aDataNotEnoughQty, true),
                        'nStaEvent'     => $aDataNotEnoughQty['nCode'],
                        'tStaMessg'     => $aDataNotEnoughQty['tDesc']
                    ),
                    'nStaEvent'     => 1,
                    'tStaMessg'     => 'คลังตัดสต๊อก '.$tTextMsg
                );
            }else{
                $aReturn = array(
                    'nStaEvent'     => 200,
                    'tStaMessg'     => 'คลังตัดสต๊อก ไม่มีเอกสารค้างอนุมัติ สินค้าในคลังเพียงพอในการทำเอกสาร'
                );
            }
        }else{
            $aReturn = array(
                'nStaEvent'     => 300,
                'tStaMessg'     => 'คลังไม่เช็คสต๊อก'
            );
        }
        echo json_encode($aReturn);
    }


}

