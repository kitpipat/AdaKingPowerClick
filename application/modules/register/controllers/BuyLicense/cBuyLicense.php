<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBuyLicense extends MX_Controller {

    public $tCustomerKey;
    public $tPublicAPI;
    public $tKeyAPI          = 'X-API-KEY'; //Key ของ API บน 94
    public $tValueAPI        = '12345678-1111-1111-1111-123456789410'; //Value ของ API บน 94

    public function __construct(){
        parent::__construct ();
        $this->load->model('register/BuyLicense/mBuyLicense');
        $this->tCustomerKey = $this->session->userdata('tSesCstKey');

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

        // $this->session->set_userdata( "tSesHQBchCode", '00001');
        // ถ้า session เป็นค่าว่าง
        if($this->session->userdata("tSesHQBchCode") == '' || $this->session->userdata("tSesHQBchCode") == null){
            $this->session->set_userdata( "tSesHQBchCode", '00001');
        }
    }

    public function index($ptType){
        // $ptType = 1 ลงทะเบียนใช้งาน
        // $ptType = 0 ซื้อ License
        // $ptType = 2 ต่ออายุ
        // $ptType = 3 หน้า Add-On

        $aView = array(
            'tTypepage' => $ptType
        );
        $this->load->view('register/BuyLicense/wBuyLicense',$aView);

        //clear session
        // unset($_SESSION["nVatCalculate"]);
        // unset($_SESSION["nVatRate"]);
    }

    //หน้าจอลิสต์ Package [step1]
    public function FSvCBUYCallViewlist(){

        if($this->input->post('tTypepage') == 2 || $this->input->post('tTypepage') == 3){
            $aReturnData = array(
                'tTypeExtendOrBuy' => 'extend_license'
            );
            echo json_encode($aReturnData);
            exit;
        }

        //ล้างค่าใน Temp ไว้โชว์ ก่อน
        $aClear = array(
            'tSessionID'        =>  $this->session->userdata('tSesSessionID'),
            'ptKeyClear'        => 'Featues,Pos,Package',
            'ptTypeClear'       => '1'
        );
        $this->mBuyLicense->FSxMBUYClearTemp($aClear);

        //ล้างค่าใน Temp - HD DT RC DTDis HDDis
        $aClear = array(
            'tSessionID'        =>  $this->session->userdata('tSesSessionID'),
            'ptTypeClear'       => '1'
        );
        $this->mBuyLicense->FSxMBUYClearTempData($aClear);

        //API Business Type
        $tUrlApiBusiness = $this->tPublicAPI.'/Master/Business?ptLang=1';
        $aAPIKey    = array(
            'tKey'      => $this->tKeyAPI,
            'tValue'    => $this->tValueAPI
        );
        $aParamBusiness     = array(
            'ptLang'        => $this->session->userdata("tLangEdit")
        );
        $oResultBusiness  = FCNaHCallAPIBasic($tUrlApiBusiness,'GET',$aParamBusiness,$aAPIKey);
       
        //API CstPrivacy
        $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstPrivacy';
        $aParam     = array(
            'ptLang'        => $this->session->userdata("tLangEdit"),
            'ptCstKey'      => '',
            'ptStaExcept'   => 1
        );
        $oResultCstPrivacy  = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

        $aView = array(
            'aDetailCustomer'   => '',
            'aItemLicKey'       => '',
            'aPackage'          => '',
            'aBusiness'         => $oResultBusiness,
            'aCstPrivacy'       => $oResultCstPrivacy,
            'tTypepage'         => $this->input->post('tTypepage')
        );
        $this->load->view('register/BuyLicense/wBuyLicenseList',$aView);
    }

    //หน้าจอตาราง package [step1]
    public function FSwCBuyLoadTablePackage(){

        //ฟิลเตอร์พิเศษ
        $tFilterPackageSPC = $this->input->post('tFilterPackageSPC');
        $tFilterPackageSPC = trim($tFilterPackageSPC);
   
        //ถ้ามีข้อมูลแล้วจะวิ่ง API
        if($this->input->post('tTypepage') == 0){ //ซื้อ
            //ข้อมูลลูกค้า
            $tCstKey    = $this->tCustomerKey;
            $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstProfile?ptLang=1&ptCstKey='.$tCstKey;
            $aAPIKey    = array(
                'tKey'      => $this->tKeyAPI,
                'tValue'    => $this->tValueAPI
            );
            $aParam     = array(
                'ptLang'    => $this->session->userdata("tLangEdit"),
                'ptCstKey'  => $this->tCustomerKey
            );
            $oReuslt            = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
            $aDetailCustomer    = $oReuslt;

            if($this->session->userdata("tSessionCstPackageCode") == '' || $this->session->userdata("tSessionCstPackageCode") == null){
                //ยังไม่เคยซื้อ แพ็คเกจ
                if($this->session->userdata("tSessionRegLicType") == 1){ //ถ้าเป็น ทดลองใช้จะโชว์หมด
                    $tUrlApi        = $this->tPublicAPI.'/Product/RG_PdtListPackage';
                    $aParam         = array(
                        'ptLang'        => $this->session->userdata("tLangEdit"),
                        'ptCstKey'      => '',
                        'ptStaExcept'   => 1,
                        'ptProjectCode' => trim($tFilterPackageSPC)
                    );
                    $oResultPackage     = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
                    $aItemLicKey        = array();
                }else{ //ถ้าเป็นเปิดร้านค้าจริง จะไม่โชว์ Demo
                    $tUrlApi    = $this->tPublicAPI.'/Product/RG_PdtListPackage?ptCstKey='.$tCstKey.'&ptStaExcept=1'.'&ptProjectCode='.$tFilterPackageSPC;
                    $aParam     = array(
                        'ptLang'        => $this->session->userdata("tLangEdit"),
                        'ptCstKey'      => $this->tCustomerKey,
                        'ptStaExcept'   => 1
                    );
                    $oReusltLicKey    = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
                    $oResultPackage   = $oReusltLicKey;
                    $aItemLicKey      = $oReusltLicKey['roItem'];
                }
            }else{
                //ข้อมูล licensen ที่ลูกค้าซื้อ
                $tUrlApi    = $this->tPublicAPI.'/Product/RG_PdtListPackage?ptCstKey='.$tCstKey.'&ptStaExcept=1'.'&ptProjectCode='.$tFilterPackageSPC;
                $aParam     = array(
                    'ptLang'        => $this->session->userdata("tLangEdit"),
                    'ptCstKey'      => $this->tCustomerKey,
                    'ptStaExcept'   => 1
                );
                $oReusltLicKey    = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
                $oResultPackage   = $oReusltLicKey;
                $aItemLicKey      = $oReusltLicKey['roItem'];
            }
        }else{ //ลงทะเบียนใหม่
            $aDetailCustomer  = array();
            $aItemLicKey      = array();

            //API Package
            $tUrlApi    = $this->tPublicAPI.'/Product/RG_PdtListPackage'.'?ptProjectCode='.$tFilterPackageSPC;
            $aAPIKey    = array(
                'tKey'      => $this->tKeyAPI,
                'tValue'    => $this->tValueAPI
            );
            $aParam     = array(
                'ptLang'        => $this->session->userdata("tLangEdit"),
                'ptCstKey'      => '',
                'ptStaExcept'   => 1,
                'ptProjectCode' => $tFilterPackageSPC
            );
            $oResultPackage  = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
        }

        $aView = array(
            'aDetailCustomer'   => $aDetailCustomer,
            'aItemLicKey'       => $aItemLicKey,
            'aPackage'          => $oResultPackage,
            'tFilterPackageSPC' => $tFilterPackageSPC,
            'tTypepage'         => $this->input->post('tTypepage')
        );
        $this->load->view('register/BuyLicense/wBuyLicenseDatatable',$aView);
    }
  
    //หน้าจอ AddOn [step2]
    public function FSvCBUYCallViewAddOn(){
        $tType = $this->input->post('tTypepage');

        if($tType == 1){ //ลงทะเบียนใช้งาน
            $aNotInFeature  = array();
            $tName          = $this->input->post('ptName');
            $tEmail         = $this->input->post('ptEmail');
            $tTel           = $this->input->post('ptTel');
            $tTypeLicense   = $this->input->post('ptTypeLicense');
            $nCountbch      = ($tTypeLicense == '1') ? 1 : $this->input->post('pnCountbch');
            $nValueType     = $this->input->post('pnValueType');
            $tValueOther    = '-';
            $nValuePackage  = $this->input->post('pnValuePackage');

            //API Register
            $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstRegister';
            $aAPIKey    = array(
                'tKey'   => $this->tKeyAPI,
                'tValue' => $this->tValueAPI
            );
            $aParam     = array(
                "ptFunction"    => "",
                "ptSource"      => "",
                "ptDest"        => "",
                "ptFilter"      => "",
                "ptData"        => json_encode(array(
                    "ptRegBusName"  => $tName,
                    "pnRegQtyBch"   => $nCountbch,
                    "ptRegLicType"  => $tTypeLicense,
                    "ptRegBusType"  => '',
                    "ptRegBusOth"   => $nValueType,
                    "ptCstMail"     => $tEmail,
                    "ptCstTel"      => $tTel
                ))
            );
            $oResultRegister = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

            if($oResultRegister['rtCode'] == 001){
                $tStatus       = 'pass';
                $aItemCustomer = $oResultRegister['roItem'];
            }else if($oResultRegister['rtCode'] == 801){
                $tStatus       = 'fail';
                $aReturn       = array(
                    'tStatus'       => $tStatus,
                    'tCodeError'    => 801
                );
                echo json_encode($aReturn);
                exit;
            }else{
                $tStatus       = 'fail';
                $aItemCustomer = '';
                $aReturn       = array(
                    'tStatus'       => $tStatus,
                    'tCodeError'    => 100
                );
                echo json_encode($aReturn);
                exit;
            }
        }else{ //ซื้ออย่างเดียว
            $tCstKey    = $this->tCustomerKey; //'ed303442f742'; 
            $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstProfile?ptLang=1&ptCstKey='.$tCstKey;
            $aAPIKey    = array(
                'tKey'   => $this->tKeyAPI,
                'tValue' => $this->tValueAPI
            );
            $aParam     = array(
                'ptLang'    => $this->session->userdata("tLangEdit"),
                'ptCstKey'  => $tCstKey
            );
            $oReuslt            = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
            $tStatus            = 'pass';
            $aItemCustomer      = $oReuslt['roItem'];

            //API Feature - ที่ Cst ใช้งาน
            $tUrlApiFeature    = $this->tPublicAPI.'/Product/RG_PdtListFeature?ptCstkey='.$tCstKey.'&ptStaExcept=2';
            $aParamFeature     = array(
                'ptLang'        => $this->session->userdata("tLangEdit"),
                'ptCstKey'      => $tCstKey,
                'ptStaExcept'   => 2
            );
            $oResultFeatureUse = FCNaHCallAPIBasic($tUrlApiFeature,'GET',$aParamFeature,$aAPIKey);
            $aNotInFeature = array();
            if(!empty($oResultFeatureUse['roItem']['raoDataFeature'])){
                for($i=0; $i<FCNnHSizeOf($oResultFeatureUse['roItem']['raoDataFeature']); $i++){
                    $aItem = $oResultFeatureUse['roItem']['raoDataFeature'][$i];
                    array_push($aNotInFeature,$aItem['rtPdtCode']);
                }
            }
        }

        // เปิดเมื่อต้องการทดสอบ
        // $aNotInFeature = array();
        // $tStatus       = 'pass';
        // $aItemCustomer = array(
        //     'rnRegID'       => '10',
        //     'rtCstKey'      => '38e6d163e820',
        //     'rtRegBusName'  => 'วัฒน์ทดสอบ',
        //     'rnRegQtyBch'   => '1',
        //     'rtRegLicType'  => '2', 
        //     'rtRegBusType'  => '', 
        //     'rtRegBusOth'   => 'รูปแบบร้านค้าโชว์ห่วย', 
        //     'rtCstMail'     => 'wat_demo', 
        //     'rtCstTel'      => '0832415989'
        // );

        //Loop ลงตาราง Temp : Package
        $tCstKey        = $this->tCustomerKey;
        $nNumber        = 1;
        $aPackage       = $this->input->post('aPackage');
        if(FCNnHSizeOf($aPackage) != 0){ //ถ้าไม่ได้เลือก package กำหนดค่าให้ VAT + VATType ให้กับเอกสาร
            $this->session->set_userdata( "nVatCalculate", $aPackage[0]['aDetailPDT']['rtVATInOrEx'] );
            $this->session->set_userdata( "nVatRate", $aPackage[0]['aDetailPDT']['rcVatRate'] );
            $tNotInFeatureInpackage = $aPackage[0]['tPDTSetPdtCode'];
        }else{
            $tNotInFeatureInpackage = $this->session->userdata("tSessionCstPackageCode");
        }

        $nVatCalculate  = $this->session->userdata("nVatCalculate");
        $nVatRate       = $this->session->userdata("nVatRate");
        for($i=0; $i<FCNnHSizeOf($aPackage); $i++){

            $nPrice     = preg_replace('/\,/', '', $aPackage[$i]['nPrice']);
            $nVatRate   = $aPackage[0]['aDetailPDT']['rcVatRate'];
            $nVat       = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;

            //Insert Feature 
            $aInsertShowTemp    = array( //ส่วนของโชว์
                'tKey'              => 'Package',
                'tBchCode'          => $this->session->userdata("tSesHQBchCode"),
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
                'nSeq'              => $nNumber,
                'tTextPackage'      => $aPackage[$i]['tTitlePackage'],
                'tTextDetail'       => $aPackage[$i]['tTextFeatuesList'],
                'tTextMonth'        => $aPackage[$i]['tMonth'],
                'tTextPrice'        => preg_replace('/\,/', '', $aPackage[$i]['nPrice']),
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('Package' , $aInsertShowTemp);

            //Insert Feature To SetDT
            $aInsertSetDT    = array(
                'FTBchCode'             => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'            => '',
                'FNXsdSeqNo'            => 1,
                'FNPstSeqNo'            => $nNumber,
                'FTPdtCode'             => $aPackage[$i]['aDetailFeatues']['rtFeaCode'],
                'FTXsdPdtName'          => $aPackage[$i]['tTextFeatuesList'],
                'FTPunCode'             => $aPackage[$i]['tUnitPDTSet'],
                'FCXsdQtySet'           => 1,
                'FCXsdSalePrice'        => 0,
                'FTSessionID'           => $this->session->userdata('tSesSessionID')
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTSetTmp' , $aInsertSetDT);

            //Insert Package To DT
            if($i == 0){
                $aInsertDT = array( //ส่วนของเก็บเอาไว้เพื่อส่ง
                    'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                    'FTXshDocNo'        => '',
                    'FNXsdSeqNo'        => $nNumber,
                    'FTPdtCode'         => $aPackage[0]['aDetailPDT']['rtPdtCode'],
                    'FTXsdPdtName'      => $aPackage[0]['aDetailPDT']['rtPdtName'],
                    'FTPunCode'         => $aPackage[$i]['tPDTSetPunCode'],
                    'FTPunName'         => $aPackage[$i]['tPDTSetPunName'],
                    'FCXsdFactor'       => $aPackage[$i]['tUnitFact'],
                    'FTXsdBarCode'      => $aPackage[0]['aDetailPDT']['rtPdtCode'],
                    'FTSrnCode'         => '0', //Fix 0
                    'FTXsdVatType'      => $aPackage[0]['aDetailPDT']['rtStaVat'],
                    'FTVatCode'         => $aPackage[0]['aDetailPDT']['rtVatCode'],
                    'FTPplCode'         => '',
                    'FCXsdVatRate'      => $aPackage[0]['aDetailPDT']['rcVatRate'],
                    'FTXsdSaleType'     => '1',  
                    'FCXsdSalePrice'    => $nPrice,
                    'FCXsdQty'          => '1',
                    'FCXsdQtyAll'       => '1' * $aPackage[$i]['tUnitFact'],
                    'FCXsdSetPrice'     => $nPrice,
                    'FCXsdAmtB4DisChg'  => $nPrice,
                    'FTXsdDisChgTxt'    => '',
                    'FCXsdDis'          => '0', 
                    'FCXsdChg'          => '0',
                    'FCXsdNet'          => $nPrice,
                    'FCXsdNetAfHD'      => $nPrice, 
                    'FCXsdVat'          => $nVat,
                    'FCXsdVatable'      => $nPrice - $nVat ,
                    'FCXsdWhtAmt'       => '0',
                    'FTXsdWhtCode'      => '0',
                    'FCXsdWhtRate'      => '0',
                    'FCXsdCostIn'       => $nVat + ($nPrice - $nVat),
                    'FCXsdCostEx'       => $nPrice - $nVat,
                    'FTXsdStaPdt'       => '1',
                    'FCXsdQtyLef'       => '1',
                    'FCXsdQtyRfn'       => '0',
                    'FTXsdStaPrcStk'    => '1',
                    'FTXsdStaAlwDis'    => $aPackage[0]['aDetailPDT']['rtStaAlwDis'],
                    'FNXsdPdtLevel'     => '0',
                    'FTXsdPdtParent'    => '',
                    'FCXsdQtySet'       => '1',
                    'FTPdtStaSet'       => $aPackage[0]['aDetailPDT']['rtStaSet'],
                    'FTXsdRmk'          => '',
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => '-',
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $aItemCustomer['rtCstKey'],
                    'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                );
                $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);
            }

            $nNumber++;
        }

        //API Feature - ของทั้งหมด
        $tUrlApi    = $this->tPublicAPI.'/Product/RG_PdtListFeature?ptCstkey='.$tCstKey.'&ptStaExcept=1&ptPkgCode='.$tNotInFeatureInpackage.' ';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptLang'        => $this->session->userdata("tLangEdit"),
            'ptCstkey'      => $this->tCustomerKey,
            'ptStaExcept'   => 1,
            'ptPkgCode'     => $tNotInFeatureInpackage
        );
        $oResultFeature = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);

        //API POS
        $tUrlApi    = $this->tPublicAPI.'/Product/RG_PdtListClient';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptLang'        => $this->session->userdata("tLangEdit"),
            'ptCstKey'      => '',
            'ptStaExcept'   => 1
        );
        $oResultPOS = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);

        $aView = array(
            'aItemCustomer' => $aItemCustomer,
            'aPackageList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Package'),
            'aNotInFeature' => $aNotInFeature,
            'aFeature'      => $oResultFeature,
            'aPOS'          => $oResultPOS,
            'tTypepage'     => $tType
        );

        $tViewHtml   = $this->load->view('register/BuyLicense/wBuyLicenseAddOn',$aView, true);
        $aReturnData = array(
            'tViewHtml'                 => $tViewHtml,
            'tStatus'                   => $tStatus,
            'tCodeError'                => ''
        );
        echo json_encode($aReturnData);
    }

    //หน้าจอ AddOn - extend [step2]
    public function FSvCBUYCallViewAddOnExtend(){
       
    }

    //หน้าจอ Recheck [step3] แบบซื้อทั่วไป
    public function FSvCBUYCallViewRecheckDetail(){
        //ล้างค่าใน Temp ก่อน
        $aClear = array(
            'tSessionID'        => $this->session->userdata('tSesSessionID'),
            'ptKeyClear'        => 'Featues,Pos',
            'ptTypeClear'       => '2'
        );
        $this->mBuyLicense->FSxMBUYClearTemp($aClear);

        //ล้างค่าใน Temp - HD DT RC DTDis HDDis
        $aClear = array(
            'tSessionID'        =>  $this->session->userdata('tSesSessionID'),
            'ptTypeClear'       => '2'
        );
        $this->mBuyLicense->FSxMBUYClearTempData($aClear);

        //ข้อมูลลูกค้า
        $aItemCustomer          = $this->input->post('aItemCustomer');
        $aItemCustomerConvert   = json_decode($aItemCustomer);

        //Loop ลงตาราง Temp : Featues
        $nNumber        = 1;
        $nNumberAddOn   = 2;
        $aFeatues       = $this->input->post('aFeatues');

        if(FCNnHSizeOf($aFeatues) != 0){
            $this->session->set_userdata( "nVatCalculate", $aFeatues[0]['oDetailFeatues']['rtVATInOrEx'] );
            $this->session->set_userdata( "nVatRate", $aFeatues[0]['oDetailFeatues']['rcVatRate'] );
        }

        for($i=0; $i<FCNnHSizeOf($aFeatues); $i++){
            //สินค้าฟิเจอร์ เอาไว้โชว์
            $aInsert = array(
                'tKey'          => 'Featues',
                'tBchCode'      => $this->session->userdata("tSesHQBchCode"),
                'tSessionID'    => $this->session->userdata('tSesSessionID'),
                'nSeq'          => $nNumber++,
                'tTextFeatues'  => $aFeatues[$i]['tTextFeatues'],
                'tTextDetail'   => $aFeatues[$i]['tTextDetail'],
                'tTextQty'      => $aFeatues[$i]['tTextQty'],
                'tTextPrice'    => preg_replace('/\,/', '', $aFeatues[$i]['tTextPrice'])
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('Featues' , $aInsert);

            //สินค้าฟิเจอร์
            $nVatCalculate  = $this->session->userdata("nVatCalculate");
            $nVatRate       = $this->session->userdata("nVatRate");
            $nPrice         = preg_replace('/\,/', '', $aFeatues[$i]['tTextPrice']);
            $nVatRate       = $aFeatues[0]['oDetailFeatues']['rcVatRate'];
            $nVat           = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;
            $aInsertDT      = array(
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => 'FEATUES',
                'FNXsdSeqNo'        => $nNumberAddOn,
                'FTPdtCode'         => $aFeatues[$i]['oDetailFeatues']['rtPdtCode'],
                'FTXsdPdtName'      => $aFeatues[$i]['tTextFeatues'],
                'FTPunCode'         => $aFeatues[$i]['tUnitCode'],
                'FTPunName'         => $aFeatues[$i]['tTextQty'],
                'FCXsdFactor'       => $aFeatues[$i]['nFactor'],
                'FTXsdBarCode'      => $aFeatues[$i]['oDetailFeatues']['rtPdtCode'],
                'FTSrnCode'         => 0,
                'FTXsdVatType'      => $aFeatues[$i]['oDetailFeatues']['rtStaVat'],
                'FTVatCode'         => $aFeatues[$i]['oDetailFeatues']['rtVatCode'],
                'FTPplCode'         => '',
                'FCXsdVatRate'      => $aFeatues[$i]['oDetailFeatues']['rcVatRate'],
                'FTXsdSaleType'     => '1',
                'FCXsdSalePrice'    => $nPrice,
                'FCXsdQty'          => '1',
                'FCXsdQtyAll'       => '1' * $aFeatues[$i]['nFactor'],
                'FCXsdSetPrice'     => $nPrice,
                'FCXsdAmtB4DisChg'  => $nPrice,
                'FTXsdDisChgTxt'    => '',
                'FCXsdDis'          => '0',
                'FCXsdChg'          => '0',
                'FCXsdNet'          => $nPrice,
                'FCXsdNetAfHD'      => $nPrice,
                'FCXsdVat'          => $nVat,
                'FCXsdVatable'      => $nPrice - $nVat ,
                'FCXsdWhtAmt'       => '0',
                'FTXsdWhtCode'      => '0',
                'FCXsdWhtRate'      => '0',
                'FCXsdCostIn'       => $nVat + ($nPrice - $nVat),
                'FCXsdCostEx'       => $nPrice - $nVat,
                'FTXsdStaPdt'       => '1',
                'FCXsdQtyLef'       => '1',
                'FCXsdQtyRfn'       => '0',
                'FTXsdStaPrcStk'    => '1',
                'FTXsdStaAlwDis'    => $aFeatues[$i]['oDetailFeatues']['rtStaAlwDis'],
                'FNXsdPdtLevel'     => '0',
                'FTXsdPdtParent'    => '',
                'FCXsdQtySet'       => '1',
                'FTPdtStaSet'       => $aFeatues[$i]['oDetailFeatues']['rtStaSet'],
                'FTXsdRmk'          => '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $aItemCustomerConvert->rtCstKey,
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);
            $nNumberAddOn++;
        }

        //Loop ลงตาราง Temp : Pos
        $nNumberPos = 1;
        $nNumber    = 1;
        $aPos       = $this->input->post('aPos');
        if($aPos[0]['tTextPos'] != null){
            $this->session->set_userdata( "nVatCalculate", $aPos[0]['tVATInOrEx'] );
            $this->session->set_userdata( "nVatRate", $aPos[0]['cVatRate'] );
        }

        for($i=0; $i<FCNnHSizeOf($aPos); $i++){
            if($aPos[$i]['tTextPos'] != '' || $aPos[$i]['tTextPos'] != null){

                //สินค้าจุดขาย
                $aInsert = array(
                    'tKey'          => 'Pos',
                    'tBchCode'      => $this->session->userdata("tSesHQBchCode"),
                    'tSessionID'    => $this->session->userdata('tSesSessionID'),
                    'nSeq'          => $nNumber++,
                    'tTextPos'      => $aPos[$i]['tTextPos'],
                    'tTextPosQty'   => $aPos[$i]['tTextPosQty'],
                    'tTextPosPrice' => preg_replace('/\,/', '', $aPos[$i]['tTextPosPrice'])
                );
                $this->mBuyLicense->FSxMBUYInsertToTemp('Pos' , $aInsert);

                //สินค้าจุดขาย
                $nVatCalculate  = $this->session->userdata("nVatCalculate");
                $nVatRate       = $this->session->userdata("nVatRate");
                $nPrice         = preg_replace('/\,/', '', $aPos[$i]['tTextPosPrice']);
                $nVatRate       = $aPos[$i]['cVatRate'];
                $nVat           = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;
                $aInsertDT      = array( 
                    'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                    'FTXshDocNo'        => 'POS',
                    'FNXsdSeqNo'        => $nNumberAddOn++,
                    'FTPdtCode'         => $aPos[$i]['tPdtCode'],
                    'FTXsdPdtName'      => $aPos[$i]['tTextPos'],
                    'FTPunCode'         => $aPos[$i]['tUnitcode'],
                    'FTPunName'         => $aPos[$i]['tTextPosQty'],
                    'FCXsdFactor'       => $aPos[$i]['nFactor'],
                    'FTXsdBarCode'      => $aPos[$i]['tPdtCode'],
                    'FTSrnCode'         => 0, //รันตาม pos (ถ้าเป็นขาแก้ไข เอา seq เดิมมาใช้)
                    'FTXsdVatType'      => $aPos[$i]['tStaVat'],
                    'FTVatCode'         => $aPos[$i]['tVatCode'],
                    'FTPplCode'         => '',
                    'FCXsdVatRate'      => $aPos[$i]['cVatRate'],
                    'FTXsdSaleType'     => '1',
                    'FCXsdSalePrice'    => $nPrice,
                    'FCXsdQty'          => '1',
                    'FCXsdQtyAll'       => '1' * $aPos[$i]['nFactor'],
                    'FCXsdSetPrice'     => $nPrice,
                    'FCXsdAmtB4DisChg'  => $nPrice,
                    'FTXsdDisChgTxt'    => '',
                    'FCXsdDis'          => '0',
                    'FCXsdChg'          => '0',
                    'FCXsdNet'          => $nPrice,
                    'FCXsdNetAfHD'      => $nPrice,
                    'FCXsdVat'          => $nVat,
                    'FCXsdVatable'      => $nPrice - $nVat ,
                    'FCXsdWhtAmt'       => '0',
                    'FTXsdWhtCode'      => '0',
                    'FCXsdWhtRate'      => '0',
                    'FCXsdCostIn'       => $nVat + ($nPrice - $nVat),
                    'FCXsdCostEx'       => $nPrice - $nVat,
                    'FTXsdStaPdt'       => '1',
                    'FCXsdQtyLef'       => '1',
                    'FCXsdQtyRfn'       => '0',
                    'FTXsdStaPrcStk'    => '1',
                    'FTXsdStaAlwDis'    => $aPos[$i]['tStaAlwDis'],
                    'FNXsdPdtLevel'     => '',
                    'FTXsdPdtParent'    => '',
                    'FCXsdQtySet'       => 0,
                    'FTPdtStaSet'       => '',
                    'FTXsdRmk'          => '',
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => '-',
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $aItemCustomerConvert->rtCstKey,
                    'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                );
                $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);
                $nNumberPos++;
            }
        }

        $aView = array(
            'aItemCustomer' => $aItemCustomer,
            'nVatCalculate' => $this->session->userdata("nVatCalculate"),
            'nVatRate'      => $this->session->userdata("nVatRate"),
            'aPackageList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Package'),
            'aFeatuesList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Featues'),
            'aPosList'      => $this->mBuyLicense->FSxMBUYSelectTemp('Pos'),
            'aSumFooter'    => $this->mBuyLicense->FSxMBUYSelectSumFooterTemp(),
            'tTypepage'     => $this->input->post('tTypepage')
        );
        $this->load->view('register/BuyLicense/wBuyLicenseRecheck',$aView);
    }

    //หน้าจอ Recheck - extend [step3] แบบต่ออายุ
    public function FSxCBuyLicenseRecheckDetailExtend(){
        $tCstKey    = $this->tCustomerKey;
        $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstProfile?ptLang=1&ptCstKey='.$tCstKey;
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptLang'    => $this->session->userdata("tLangEdit"),
            'ptCstKey'  => $tCstKey
        );
        $oReuslt            = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
        $aItemCustomer      = json_encode($oReuslt['roItem']);

        $aView = array(
            'aItemCustomer' => $aItemCustomer,
            'nVatCalculate' => $this->session->userdata("nVatCalculate"),
            'nVatRate'      => $this->session->userdata("nVatRate"),
            'aPackageList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Package'),
            'aFeatuesList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Featues'),
            'aPosList'      => $this->mBuyLicense->FSxMBUYSelectTemp('Pos'),
            'aSumFooter'    => $this->mBuyLicense->FSxMBUYSelectSumFooterTemp(),
            'tTypepage'     => $this->input->post('tTypepage')
        );
        $this->load->view('register/BuyLicense/wBuyLicenseRecheck',$aView);
    }

    //หน้าจอ Payment [step4]
    public function FSvCBUYCallViewPayment(){
        //Insert And Get Number
        $tItem          = json_decode($this->input->post('aItemCustomer'));
        $aItemGenCode   = array(
            'tBchCode'  => $this->session->userdata("tSesHQBchCode"),
            'tCstKey'   => $tItem->rtCstKey,
            'YY'        => date("y")
        );
        $aInsertAndGetNumber    = $this->mBuyLicense->FSxMBUYInsertAndGetNumber($aItemGenCode);
        $tNewDocument           = 'S' . date("y") . $tItem->rtCstKey . '-' . $aInsertAndGetNumber['nDummyDocument'];

        //API RCV
        $tUrlApi    = $this->tPublicAPI.'/Master/Payment';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptAppCode'    => 'SB',
            'pnLang'       => 1
        );
        $oResultRCV = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

        $aView = array(
            'tDocument'     => $tNewDocument,
            'oResultRCV'    => $oResultRCV,
            'nVatCalculate' => $this->session->userdata("nVatCalculate"),
            'nVatRate'      => $this->session->userdata("nVatRate"),
            'aItemCustomer' => $this->input->post('aItemCustomer'),
            'tTypepage'     => $this->input->post('tTypepage'),
            'aSumFooter'    => $this->mBuyLicense->FSxMBUYSelectSumFooterTemp(),
            'aHDDis'        => $this->mBuyLicense->FSxMBUYSelectHDDisTemp()
        );
        $this->load->view('register/BuyLicense/wBuyLicensePayment',$aView);
    }

    //ข้อมูลเพิ่มเติมแสดงใน pop-up
    public function FSvCBUYCallViewRecheckDetailMore(){
        $aView = array(
            'aPackageList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Package'),
            'aFeatuesList'  => $this->mBuyLicense->FSxMBUYSelectTemp('Featues'),
            'aPosList'      => $this->mBuyLicense->FSxMBUYSelectTemp('Pos')
        );
        $this->load->view('register/BuyLicense/wBuyLicensePopupRecheck',$aView);
    }

    //Call API PromptPay
    public function FSvCBUYCallAPIPromptPay(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tRCVCode           = $this->input->post('tRCVCode');
        $nPriceGrand        = preg_replace('/\,/', '', $this->input->post('nPriceGrand'));

        //API RCV
        $tUrlApi    = $this->tPublicAPI.'/Master/Payment';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptAppCode'    => 'SB',
            'pnLang'       => 1
        );
        $oResultRCV = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
        if($oResultRCV['raItems'][0]['rtRcvCode'] == $tRCVCode){
            $nCount = $oResultRCV['raItems'][0]['raoRcvConfig'];
            $aItem  = $oResultRCV['raItems'][0]['raoRcvConfig'];
            for($i=0; $i<FCNnHSizeOf($nCount); $i++){
                $tType  = $aItem[$i]['rtSysKey'];
                switch ($tType) {
                    case "URLGenQR":
                        $tURLGenQR      = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "X-Key":
                        $tXKey          = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "MerchantID":
                        $tMerchantID    = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "BillerID":
                        $tBillerID      = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Prefix":
                        $tPrefix        = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Suffix":
                        $tSuffix        = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Mode":
                        $tMode          = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "MerchantRef":
                        $tMerchantRef   = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    default:
                }
            }
        }

        $tUrlApi    = $tURLGenQR;
        $aAPIKey    = array(
            'tKey'   => 'X-Key',
            'tValue' => $tXKey
        );
        $aParam     = array(
            "QRMode"        => $tMode,
            "PromptPayID"   => $tBillerID,
            "REF2"          => "",
            "QR_Width"      => 400,
            "QR_Height"     => 400,
            "Resp_Lang"     => "1",
            "MerchantID"    => $tMerchantID,
            "MerchantRef"   => $tMerchantRef,
            "InvoiceID"     => $tDocumentNumber,
            "InvoiceDate"   => date('YmdHis'),
            "InvoiceAmt"    => $nPriceGrand,
            "TerminalID"    => "00005",
            "BranchID"      => "00001",
            "StoreID"       => "00001",
            "Prefix"        => $tPrefix,
            "Suffix"        => $tSuffix
        );
        $oResultPromptPay = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

        $aReturnData = array(
            'oResultPromptPay' => $oResultPromptPay
        );
        echo json_encode($aReturnData);
    }

    //Call API Check PromptPay
    public function FSvCBUYCallAPICheckPromptPay(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tRCVCode           = $this->input->post('tRCVCode');
        $nPriceGrand        = preg_replace('/\,/', '', $this->input->post('nPriceGrand'));

        //API RCV
        $tUrlApi    = $this->tPublicAPI.'/Master/Payment';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptAppCode'    => 'SB',
            'pnLang'       => 1
        );
        $oResultRCV = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
        if($oResultRCV['raItems'][0]['rtRcvCode'] == $tRCVCode){
            $nCount = $oResultRCV['raItems'][0]['raoRcvConfig'];
            $aItem  = $oResultRCV['raItems'][0]['raoRcvConfig'];
            for($i=0; $i<FCNnHSizeOf($nCount); $i++){
                $tType  = $aItem[$i]['rtSysKey'];
                switch ($tType) {
                    case "URL":
                        $tURL           = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "X-Key":
                        $tXKey          = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "MerchantID":
                        $tMerchantID    = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "BillerID":
                        $tBillerID      = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Prefix":
                        $tPrefix        = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Suffix":
                        $tSuffix        = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "Mode":
                        $tMode          = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "MerchantRef":
                        $tMerchantRef   = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    case "URLGenQR":
                        $tURLReceive     = $aItem[$i]['rtSysStaUsrValue'];
                        break;
                    default:
                }
            }
        }

        $tUrlApi    = $tURL;
        $aAPIKey    = array(
            'tKey'   => 'X-Key',
            'tValue' => $tXKey
        );
        $aParam     = array(
            "Resp_Lang"     => "1",
            "MerchantID"    => $tMerchantID,
            "MerchantRef"   => $tMerchantRef,
            "InvoiceID"     => $tDocumentNumber,
            "InvoiceDate"   => date('YmdHis'),
            "InvoiceAmt"    => $nPriceGrand,
            "TerminalID"    => "00005",
            "BranchID"      => "00001",
            "StoreID"       => "00001",
            "Prefix"        => $tPrefix,
            "Suffix"        => $tSuffix
        );
        $oResultPromptPay = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

        $aReturnData = array(
            'oResultPromptPay' => $oResultPromptPay
        );
        echo json_encode($aReturnData);
    }

    //Call API Insert
    public function FSvCBUYCallAPIInsert(){
        $nVatCalculate      = $this->session->userdata("nVatCalculate");
        $nVatRate           = $this->session->userdata("nVatRate");
        $nTypePayment       = $this->input->post('nTypePayment');
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $nPrice             = preg_replace('/\,/', '', $this->input->post('nPriceGrand'));
        $tCustomerID        = $this->input->post('tCustomerID');
        $tRCVCode           = $this->input->post('tRCVCode');

        //API RCV
        $tUrlApi    = $this->tPublicAPI.'/Master/Payment';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptAppCode'    => 'SB',
            'pnLang'       => 1
        );
        $oResultRCV = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);        
        for($i=0; $i<FCNnHSizeOf($oResultRCV['raItems']); $i++){
            $aItem = $oResultRCV['raItems'][$i];
            if($aItem['rtRcvCode'] == $tRCVCode){ //โอนเงิน
                $rtRcvCode  = $aItem['rtRcvCode'];
                $rtRcvName  = $aItem['rtRcvName'];
                $rtFmtRef   = $aItem['rtFmtRef'];
                $rtFmtCode  = $aItem['rtFmtCode'];
                break;
            }else if($aItem['rtFmtCode'] == '007'){ //เคลียร์หนี้
                $rtRcvCode  = $aItem['rtRcvCode'];
                $rtRcvName  = $aItem['rtRcvName'];
                $rtFmtRef   = $aItem['rtFmtRef'];
                $rtFmtCode  = $aItem['rtFmtCode'];
                break;
            }
        }

        if($rtFmtCode == '013'){//พร้อมเพย์
            $tStaPaid               = 3;
            $FCXshLeft              = 0;
            //TRGTSalRCTmp
            $aInsertRC  = array( 
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => '',
                'FNXrcSeqNo'        => 1,
                'FTRcvCode'         => $rtRcvCode,
                'FTRcvName'         => $rtRcvName,
                'FTXrcRefNo1'       => $tCustomerID,
                'FTXrcRefNo2'       => $tDocumentNumber,
                'FDXrcRefDate'      => date('Y-m-d H:i:s'),
                'FTXrcRefDesc'      => $rtFmtRef,
                'FTBnkCode'         => '',
                'FTRteCode'         => 'THB',   
                'FCXrcRteFac'       => 1,       
                'FCXrcFrmLeftAmt'   => $nPrice,
                'FCXrcUsrPayAmt'    => $nPrice,
                'FCXrcDep'          => 0,
                'FCXrcNet'          => $nPrice,
                'FCXrcChg'          => 0,
                'FTXrcRmk'          => 'พร้อมเพย์จากการซื้อผ่านเว็บ',
                'FTPhwCode'         => '',
                'FTXrcRetDocRef'    => '',
                'FTXrcStaPayOffline'=> '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $tCustomerID,
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalRCTmp' , $aInsertRC);
        }else if($rtFmtCode == '005'){//โอนเงิน
            $tStaPaid               = 1;
            $FCXshLeft              = $nPrice;
            //TRGTSalRCTmp
            $aInsertRC  = array( 
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => '',
                'FNXrcSeqNo'        => 1,
                'FTRcvCode'         => $rtRcvCode,
                'FTRcvName'         => $rtRcvName,
                'FTXrcRefNo1'       => $tCustomerID,
                'FTXrcRefNo2'       => $tDocumentNumber,
                'FDXrcRefDate'      => date('Y-m-d H:i:s'),
                'FTXrcRefDesc'      => $rtFmtRef,
                'FTBnkCode'         => '',
                'FTRteCode'         => 'THB',    
                'FCXrcRteFac'       => 1,       
                'FCXrcFrmLeftAmt'   => $nPrice,
                'FCXrcUsrPayAmt'    => $nPrice,
                'FCXrcDep'          => 0,
                'FCXrcNet'          => $nPrice,
                'FCXrcChg'          => 0,
                'FTXrcRmk'          => 'โอนเงินจากการซื้อผ่านเว็บ',
                'FTPhwCode'         => '',
                'FTXrcRetDocRef'    => '',
                'FTXrcStaPayOffline'=> '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $tCustomerID,
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalRCTmp' , $aInsertRC);
        }else{ //บิลราคาเป็น 0 จบได้เลย

            $aItemGenCode   = array(
                'tBchCode'  => $this->session->userdata("tSesHQBchCode"),
                'tCstKey'   => $tCustomerID ,
                'YY'        => date("y")
            );
            $aInsertAndGetNumber    = $this->mBuyLicense->FSxMBUYInsertAndGetNumber($aItemGenCode);
            $tNewDocument           = 'S' . date("y") . $tCustomerID . '-' . $aInsertAndGetNumber['nDummyDocument'];

            $tStaPaid               = 3;
            $FCXshLeft              = 0.00;
            //TRGTSalRCTmp
            $aInsertRC  = array( 
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => '',
                'FNXrcSeqNo'        => 1,
                'FTRcvCode'         => $rtRcvCode,
                'FTRcvName'         => $rtRcvName,
                'FTXrcRefNo1'       => $tCustomerID,
                'FTXrcRefNo2'       => $tNewDocument,
                'FDXrcRefDate'      => date('Y-m-d H:i:s'),
                'FTXrcRefDesc'      => $rtFmtRef,
                'FTBnkCode'         => '',
                'FTRteCode'         => 'THB',    
                'FCXrcRteFac'       => 1,       
                'FCXrcFrmLeftAmt'   => $nPrice,
                'FCXrcUsrPayAmt'    => $nPrice,
                'FCXrcDep'          => 0,
                'FCXrcNet'          => $nPrice,
                'FCXrcChg'          => 0,
                'FTXrcRmk'          => 'เคลียร์หนี้ ยอดชำระเป็นศูนย์',
                'FTPhwCode'         => '',
                'FTXrcRetDocRef'    => '',
                'FTXrcStaPayOffline'=> '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $tCustomerID,
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalRCTmp' , $aInsertRC);
        }

        //อัพเดทพวกฟิวส์ FC
        $aSelectPrice  = array( 
            'tBchcode'              => $this->session->userdata("tSesHQBchCode"),
            'tSessionID'            => $this->session->userdata('tSesSessionID')
        );
        $aResultPrice = $this->mBuyLicense->FSxMBUYSelectPrice($aSelectPrice);

        if(!empty($aResultPrice)){
            $nTotal             = $aResultPrice[0]['FCXshTotal'];
            $nTotalNV           = $aResultPrice[0]['FCXshTotalNV'];
            $TotalNoDis         = $aResultPrice[0]['FCXshTotalNoDis'];
            $TotalB4DisChgV     = $aResultPrice[0]['FCXshTotalB4DisChgV'];
            $TotalB4DisChgNV    = $aResultPrice[0]['FCXshTotalB4DisChgNV'];
            $nTotalAfDisChgV    = $aResultPrice[0]['FCXshTotalAfDisChgV'];
            $nTotalAfDisChgNV   = $aResultPrice[0]['FCXshTotalAfDisChgNV'];
            $nAmtV              = $aResultPrice[0]['FCXshAmtV'];
            $nAmtNV             = $aResultPrice[0]['FCXshAmtNV'];
            $nVat               = $aResultPrice[0]['FCXshVat'];
            $nVatable           = $aResultPrice[0]['FCXshVatable']; 
        }else{
            $nTotal             = 0;
            $nTotalNV           = 0;
            $TotalNoDis         = 0;
            $TotalB4DisChgV     = 0;
            $TotalB4DisChgNV    = 0;
            $nTotalAfDisChgV    = 0;
            $nTotalAfDisChgNV   = 0;
            $nAmtV              = 0;
            $nAmtNV             = 0;
            $nVat               = 0;
            $nVatable           = 0;
        }

        //Insert HD
        $aInsertHD  = array( 
            'FTBchCode'             => $this->session->userdata("tSesHQBchCode"),
            'FTXshDocNo'            => '',
            'FTShpCode'             => '00001',      
            'FNXshDocType'          => '1',
            'FDXshDocDate'          => date('Y-m-d H:i:s'),
            'FTXshCshOrCrd'         => '1',
            'FTXshVATInOrEx'        => $nVatCalculate,
            'FTDptCode'             => '', 
            'FTWahCode'             => '',
            'FTPosCode'             => '00001',
            'FTShfCode'             => date('Y-m-d'),
            'FNSdtSeqNo'            => '1',
            'FTUsrCode'             => 'ONLINE',
            'FTSpnCode'             => 'ONLINE',
            'FTXshApvCode'          => '',
            'FTCstCode'             => $tCustomerID,
            'FTXshDocVatFull'       => '',
            'FTXshRefExt'           => '',
            'FDXshRefExtDate'       => '',
            'FTXshRefInt'           => '',
            'FDXshRefIntDate'       => '',
            'FTXshRefAE'            => '',
            'FNXshDocPrint'         => '1',
            'FTRteCode'             => 'THB',               
            'FCXshRteFac'           => '1',                 
            'FCXshTotal'            => $nTotal,
            'FCXshTotalNV'          => $nTotalNV,            //ไป SUM ฟิวส์ FCXtdNet จาก DT FTXsdVatType = 2      
            'FCXshTotalNoDis'       => $TotalNoDis,          //ไป SUM ฟิวส์ FCXtdNet จาก DT FTXtdStaAlwDis = 2         
            'FCXshTotalB4DisChgV'   => $TotalB4DisChgV,      //ไป SUM ฟิวส์ FCXtdAmtB4DisChg จาก DT ฟิวส์ FTXtdStaAlwDis = 1 AND FTXtdVatType = 1  
            'FCXshTotalB4DisChgNV'  => $TotalB4DisChgNV,     //ไป SUM ฟิวส์ FCXtdAmtB4DisChg จาก DT ฟิวส์ FTXtdStaAlwDis = 1 AND FTXtdVatType = 2  
            'FTXshDisChgTxt'        => '',                   //ไปเอา HDDis ฟิวส์ DisChgTxt
            'FCXshDis'              => 0,                    //ไป SUM จากฟิวส์ HDDis (ดูสูตรจาก acc)
            'FCXshChg'              => 0,                    //ไป SUM จากฟิวส์ HDDis (ดูสูตรจาก acc)
            'FCXshTotalAfDisChgV'   => $nTotalAfDisChgV,     //ไป SUM ฟิวส์ FCXtdNetAfHD จาก DT ฟิวส์ FTXtdVatType = 1
            'FCXshTotalAfDisChgNV'  => $nTotalAfDisChgNV,    //ไป SUM ฟิวส์ FCXtdNetAfHD จาก DT ฟิวส์ FTXtdVatType = 2
            'FCXshRefAEAmt'         => 0,
            'FCXshAmtV'             => $nAmtV,   
            'FCXshAmtNV'            => $nAmtNV,
            'FCXshVat'              => $nVat,
            'FCXshVatable'          => $nVatable,
            'FTXshWpCode'           => '',
            'FCXshWpTax'            => 0,
            'FCXshGrand'            => $nAmtV + $nAmtNV, 
            'FCXshRnd'              => 0,
            'FTXshGndText'          => FCNtNumberToTextBaht(number_format($nAmtV + $nAmtNV, 2)),  
            'FCXshPaid'             => $nAmtV + $nAmtNV,        
            'FCXshLeft'             => $FCXshLeft,
            'FTXshRmk'              => '',
            'FTXshStaRefund'        => '',
            'FTXshStaDoc'           => '1',
            'FTXshStaApv'           => '',
            'FTXshStaPrcStk'        => '',
            'FTXshStaPaid'          => $tStaPaid , //โอนเงิน หรือ พร้อมเพย์
            'FNXshStaDocAct'        => '1',
            'FNXshStaRef'           => '0',
            'FTRsnCode'             => '',
            'FTXshAppVer'           => '',
            'FDLastUpdOn'           => date('Y-m-d H:i:s'),
            'FTLastUpdBy'           => '-',
            'FDCreateOn'            => date('Y-m-d H:i:s'),
            'FTCreateBy'            => $tCustomerID,
            'FTSessionID'           => $this->session->userdata('tSesSessionID')
        );
        $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalHDTmp' , $aInsertHD);

        //เอาส่วนลดไป อัพเดทที่ HD
        $aCalDTTempParams = [
            'tDocNo'        => '',
            'tBchCode'      => $this->session->userdata("tSesHQBchCode"),
            'tSessionID'    => $this->session->userdata('tSesSessionID')
        ];
        $aCalInHDDisTemp    = $this->mBuyLicense->FSaMBUYCalInHDDisTemp($aCalDTTempParams);

        $aUpdateHD = array(
            'FTXshDisChgTxt'    => isset($aCalInHDDisTemp['FTXhdDisChgTxt']) ? $aCalInHDDisTemp['FTXhdDisChgTxt'] : '',
            'FCXshDis'          => isset($aCalInHDDisTemp['FCXshDis']) ? $aCalInHDDisTemp['FCXshDis'] : NULL,
            'FCXshChg'          => isset($aCalInHDDisTemp['FCXshChg']) ? $aCalInHDDisTemp['FCXshChg'] : NULL,
            'tSessionID'        => $this->session->userdata('tSesSessionID')
        );
        $this->mBuyLicense->FSaMBUYCalInHDTemp($aUpdateHD);

        //อัพเดทเลขที่เอกสารทั้งหมดลงตาราง HD DT DTSet HDDis DTDis
        $aUpdateDocNo  = array( 
            'tDocument'             => preg_replace('/\-/', '',$tDocumentNumber),
            'tSession'              => $this->session->userdata('tSesSessionID')
        );
        $this->mBuyLicense->FSxMBUYUpdateDocumentToTemp($aUpdateDocNo);
        
        //ส่งหา API 
        $tNewDoc        = preg_replace('/\-/', '',$tDocumentNumber);
        $tResult        = $this->FSxBUYSendData($tNewDoc);
        $aReturnData    = array(
            'aReturn'   => $tResult,
            'rtFmtCode' => $rtFmtCode
        );
        echo json_encode($aReturnData);

        // เมื่อส่งเข้า API เเล้ว remove ใน Temp
        $this->FSxBUYClearTempAll();

        // เปิดเมื่อต้องการทดสอบ
        // $aReturnData    = array(
        //     'aReturn' => array(
        //         'rtCode' => '001',
        //         'rtFmtCode' => '005'
        //     )
        // );
        // echo json_encode($aReturnData);
    }

    //ส่งข้อมูล
    public function FSxBUYSendData($ptNewDoc){
        $tUrlApi    = $this->tPublicAPI.'/License/RG_BuyLicense';
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        ); 
        $aParam     = array(
            "ptFunction"    => "",
            "ptSource"      => "",
            "ptDest"        => "",
            "ptFilter"      => "",
            "ptData"        => json_encode(array(
                "aoTPSTSalDTDisTmp"     => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalDTDisTmp',$ptNewDoc),
                "aoTPSTSalDTSetTmp"     => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalDTSetTmp',$ptNewDoc),
                "aoTPSTSalDTTmp"        => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalDTTmp',$ptNewDoc),
                "aoTPSTSalHDDisTmp"     => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalHDDisTmp',$ptNewDoc),
                "aoTPSTSalHDTmp"        => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalHDTmp',$ptNewDoc),
                "aoTPSTSalRCTmp"        => $this->mBuyLicense->FSxMBUYSeletedTemp('TRGTSalRCTmp',$ptNewDoc)
            ))
        );
        $oReuslt            = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);
        return $oReuslt;
    }

    //Call API Find Coupon
    public function FSvCBUYCallAPIFindCoupon(){
        // $tUrlApi    = 'http://202.44.55.94/Pos5StoreBackOfficeDev/API2Wallet/V5/Coupon/CheckCouponHD';
        // $aAPIKey    = array(
        //     'tKey'   => $this->tKeyAPI,
        //     'tValue' => $this->tValueAPI
        // );
        // $aParam     = array(
        //     'pnLangID'      => $this->session->userdata("tLangEdit"),
        //     "ptCouponType"  => "sample string 1",
        //     "ptCpnDocNo"    => "sample string 2",
        //     "ptBarCpn"      => "sample string 3",
        //     "ptCstCode"     => $this->input->post('tCustomerID'),
        // );
        // $oResultCoupon = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);

        //
        $tCustomerID    = $this->input->post('tCustomerID');
        $tCouponCode    = $this->input->post('tCouponCode');
        $nPriceTotal    = preg_replace('/\,/', '',$this->input->post('nPriceTotal'));
        $nDiscount      = $this->input->post('tCouponCode');

        //Clear HDDis + DTDis ทุกครั้งที่กดคูปอง
        $this->FSxClearHDDisAndDTDis();

        $aInsertHD      = array(
            'FTBchCode'             => $this->session->userdata("tSesHQBchCode"),
            'FTXshDocNo'            => '',
            'FDXhdDateIns'          => date('Y-m-d H:i:s'),
            'FTXhdRefCode'          => 'COUPONSCODE',
            'FTXhdDisChgTxt'        => $nDiscount,
            'FTXhdDisChgType'       => 1,
            'FCXhdTotalAfDisChg'    => $nPriceTotal,
            'FCXhdDisChg'           => $nDiscount,
            'FCXhdAmt'              => $nDiscount,
            'FTDisCode'             => '',
            'FTRsnCode'             => '',
            'FTSessionID'           => $this->session->userdata('tSesSessionID')
        );
        $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalHDDisTmp' , $aInsertHD);

        // Prorate HD
        $this->mBuyLicense->FSxCCalculateProrate('TRGTSalHDDisTmp', '');

        // Recal DT ใหม่
        $this->mBuyLicense->FSxRecalUpdateDocDTTemp();

        $aReturnData    = array(
            'tStatus'   => '100',
            'nDiscount' => $nDiscount
        );
        echo json_encode($aReturnData);
    }

    //clear HDDis + DTDis
    public function FSxClearHDDisAndDTDis(){
        //ล้างค่าใน Temp - DTDis HDDis
        $aClear = array(
            'tSessionID'        =>  $this->session->userdata('tSesSessionID')
        );
        $this->mBuyLicense->FSxMBUYClearTempDataDiscount($aClear);
    }

    //Clear Coupon
    public function FSxCBUYClearCoupon(){
        //Clear HDDis + DTDis ทุกครั้งที่กดคูปอง
        $this->FSxClearHDDisAndDTDis();
    }

    //Clear Temp All
    public function FSxBUYClearTempAll(){
        //ล้างค่าใน Temp - DTDis HDDis
        $aClear = array(
            'tSessionID'        =>  $this->session->userdata('tSesSessionID'),
            'ptTypeClear'       => '1'
        );
        $this->mBuyLicense->FSxMBUYClearTempData($aClear);
    }

    //Check ว่าถ้าเปลี่ยน package
    public function FSxCBuyLicenseCreditRefund(){

        //Clear HDDis + DTDis
        $this->FSxClearHDDisAndDTDis();

        $tCstKey    = $this->tCustomerKey;
        $tUrlApi    = $this->tPublicAPI.'/Customer/RG_CstLicAll?ptCstKey='.$tCstKey;
        $aAPIKey    = array(
            'tKey'   => $this->tKeyAPI,
            'tValue' => $this->tValueAPI
        );
        $aParam     = array(
            'ptLang'    => $this->session->userdata("tLangEdit"),
            'ptCstKey'  => $tCstKey
        );
        $oReuslt    = FCNaHCallAPIBasic($tUrlApi,'GET',$aParam,$aAPIKey);
        $aPackage   = array();
        $aFeature   = array();

        if(!empty($oReuslt['roItem']['raoCstLic'])){ 
            foreach($oReuslt['roItem']['raoCstLic'] as $aData){
                if($aData['rtPtyCode'] == '00001'){ //Package
                    $aPackage[] = $aData;
                }else if($aData['rtPtyCode'] == '00002'){ //Feature
                    $tCheckFeatureInPackage = $this->mBuyLicense->FSxMBUYCheckDTSetInPackage($aData['rtPdtCode']);
                    if($tCheckFeatureInPackage['rtCode'] == 1){
                        $aFeature[] = $aData;
                    }
                }
            }
        }   

        //หาส่วนต่างของ Package
        $tDatePackageEnd        = date_create(substr($aPackage[0]['rtLicFinish'],0,10));
        $tDateCurrent           = date_create(date('Y-m-d'));
        $tDiff                  = date_diff($tDatePackageEnd,$tDateCurrent);
        $tDateCredit            = $tDiff->format("%a");
        $tDatePackageAvgM       = str_replace(',','',$aPackage[0]['raoPrice'][0]['rcPgdPriceRet'])/30;
        $nDiscount              = str_replace(',','',number_format($tDateCredit * $tDatePackageAvgM,2));

        //PACKAGE
        // print_r($oReuslt);    
        // echo 'DATE BETWEEN : ' . $tDateCredit;
        // echo 'PRICE / MOUNT : ' . $tDatePackageAvgM;
        // echo 'DISCOUNT : ' . $nDiscount;

        //หาส่วนต่างของ Feature
        $nCountFeature          = FCNnHSizeOf($aFeature);
        $nPriceFeature          = 0;
        $tDateCreditFeature     = 0;
        for($i=0; $i<$nCountFeature; $i++){
            $tDateFeatureEnd        = date_create(substr($aFeature[$i]['rtLicFinish'],0,10));
            $tDiffFeature           = date_diff($tDateFeatureEnd,$tDateCurrent);
            $tDateCreditFeature     = $tDiffFeature->format("%a");
            $nPrice                 = ($aFeature[$i]['raoPrice'][0]['rcPgdPriceRet'] / 30) * $tDateCreditFeature;
            $nPriceFeature          = $nPriceFeature + str_replace(',','',$nPrice);
        }

        //PACKAGE
        // print_r($aFeature);    
        // echo 'DATE BETWEEN : ' . $tDateCreditFeature;
        // echo 'DISCOUNT : ' . $nPriceFeature;

        //ราคาส่วนลดทั้งหมด
        $nTotdalDiscount        = str_replace(',','',number_format($nDiscount + $nPriceFeature,2));

        //SumFooter
        $aSumFooter             = $this->mBuyLicense->FSxMBUYSelectSumFooterTemp();

        //ยอดหลังลด
        $nB4Price               = str_replace(',','',number_format($aSumFooter['raItems'][0]['SumPrice'] - $nTotdalDiscount,2));

        //InsertHD
        $aInsertDT              = array(
            'FTBchCode'          => $this->session->userdata("tSesHQBchCode"),
            'FTXshDocNo'         => '',
            'FDXhdDateIns'       => date('Y-m-d H:i:s'),
            'FTXhdRefCode'       => '',
            'FTXhdDisChgTxt'     => $nTotdalDiscount,
            'FTXhdDisChgType'    => 1,  
            'FCXhdTotalAfDisChg' => $nB4Price,
            'FCXhdDisChg'        => $nTotdalDiscount,
            'FCXhdAmt'           => $nTotdalDiscount,
            'FTDisCode'          => '',
            'FTRsnCode'          => '',   
            'FTSessionID'        => $this->session->userdata('tSesSessionID'),
        );
        $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalHDDisTmp' , $aInsertDT);

        // Prorate HD
        $this->mBuyLicense->FSxCCalculateProrate('TRGTSalHDDisTmp', '');

        // Recal DT ใหม่
        $this->mBuyLicense->FSxRecalUpdateDocDTTemp();

        if($nTotdalDiscount < 0){ //ยอดลดรวมกันเเล้วน้อยกว่า 0
            $nVat               = "0.00";
            $nAFDiscount        = "0.00";
        }else{
            $nVatCalculate      = $this->session->userdata("nVatCalculate");
            $nVatRate           = $this->session->userdata("nVatRate");
            if($nVatCalculate == 1){ //ภาษีรวมใน
                $nVat           = $nB4Price-($nB4Price*100)/(100+$nVatRate);
                $nAFDiscount    = number_format($nB4Price,2);
            }else{ //ภาษีแยกนอก
                $nVat           = $nB4Price*(100+$nVatRate)/100-$nB4Price;
                $nAFDiscount    = number_format($nB4Price + $nVat,2);
            }
        }

        $aReturnData    = array(
            'nDiscount'     => $nTotdalDiscount,
            'nVat'          => ($nVat < 0 ) ? "0.00" : number_format($nVat,2),
            'nAFDiscount'   => ($nAFDiscount < 0) ? "0.00" : $nAFDiscount
        );
        echo json_encode($aReturnData);
    }
}