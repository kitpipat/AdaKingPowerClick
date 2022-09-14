<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cInformationRegister extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('register/information/mInformationRegister');
        $this->load->model('register/BuyLicense/mBuyLicense');
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
    }

    public function index()
    {

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');

        $this->load->view('register/information/wInformationRegisterMain');
    }


    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvIMRGetPageForm(){

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');
        $aRegBusTypeName = array(
            1 => 'Grocery Store',
            2 => 'Mini-mart',
            3 => 'ร้านอาหาร & เครื่องดื่ม',
            4 => 'Specialty Store',
            5 => 'Other (Department Store ,Supermarket,Hypermarket,Shopping Mall,Convenience Store)',
        );


        if(!empty($this->input->post('tCstKey'))){
            $tCstKey = $this->input->post('tCstKey');
            $tStaUpdAcc = 2;
         }else{
            $tCstKey = $this->session->userdata('tSesCstKey'); //กรณีเข้าระบบแล้วมี  licencse แล้ว
            $tStaUpdAcc = 1;
         }
         
          $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);
            //manual update account online กรณีมี Customer Key แล้ว กรอก แล้วกด Refresh
            // ระบบจะดึงของมูล จาก API2CNAda.RG_CstProfile
            //  TCNMCst
            // TRGMCstBch
            // Call API2PSMaster.RG_UpdateAccount
          $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();

          $tUrlApiCalCstProFile = $tUrlObject.'/Customer/RG_CstProfile?ptLang=1&ptCstKey='.trim($tCstKey).'&ptStaUpdAcc='.$tStaUpdAcc;
			
          $tUrlApiCstGetLicense = $tUrlObject.'/Customer/RG_CstLicAll?ptCstKey='.trim($tCstKey);

           $aPaRam = array(
              'CstKey' => $tCstKey ,
                'Lang' => 1
             );

            if($aAPIConfig['rtCode']=='01'){
                $aApiKey = array(
                    'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                    'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
                );
            }else{
                $aApiKey = array();
            }
        
            $oReuslt = FCNaHCallAPIBasic($tUrlApiCalCstProFile,'GET',$aPaRam,$aApiKey);

            $oReusltLicense = FCNaHCallAPIBasic($tUrlApiCstGetLicense,'GET',$aPaRam,$aApiKey);

            if($oReuslt['rtCode']=='001'){

                $tImgObjAll= $oReuslt['roItem']['rtCstImg'];

                if(isset($tImgObjAll) && !empty($tImgObjAll)){
                    $tPatchImgHtml = "<img class='img-responsive xCNImgCenter' style='width: 100%;' src='data:image/png;base64, ".$tImgObjAll."'  />";
                }else{
                    $tPatchImgHtml = "<img class='img-responsive xCNImgCenter' style='width: 100%;' src='".base_url()."application/modules/common/assets/images/200x200.png'>";
                }
               
             
                $tIMRCstKey = $tCstKey;

                $tCstName = $oReuslt['roItem']['rtCstName'];
                $tRegBusName = $oReuslt['roItem']['rtRegBusName'];
                $tRegBusOth = $oReuslt['roItem']['rtRegBusOth'];
                $tRegBusType = $tRegBusOth;
                $tCstTel = $oReuslt['roItem']['rtCstTel'];
                $tCstEmail = $oReuslt['roItem']['rtCstMail'];

                $oCstBch = $oReuslt['roItem']['raoCstBch'];

                $tRegLicType = $oReuslt['roItem']['rtRegLicType'];

                $this->session->set_userdata('tSessionRegLicType',$tRegLicType); 
            
                $nStaMassage = 0;
            }else{
                //กรณี Call API แล้วยังไม่มี License Key
                $tPatchImgHtml = "<img class='img-responsive xCNImgCenter' style='width: 100%;' src='".base_url()."application/modules/common/assets/images/200x200.png'>";
                $tIMRCstKey = $tCstKey;

                $tCstName = 'N/A';
                $tRegBusName = 'N/A';
                $tRegBusOth = 'N/A';
                $tRegBusType = 'N/A';
                $tCstTel = 'N/A';
                $tCstEmail = 'N/A';
                $this->session->set_userdata('tSessionRegLicType',0); 
                $oCstBch = array();
                $nStaMassage = 1;
            }
        


 
            $aLicensePackageAddOn = array();
            $aLicenseClientPos = array();

            if(!empty($oReusltLicense['roItem']['raoCstLic'])){ 
                foreach($oReusltLicense['roItem']['raoCstLic'] as $aData){
                    
                         if($aData['rtPtyCode']!='00003'){

                             if($aData['rtPtyCode']=='00001'){
                                    $this->session->set_userdata('tSessionCstPackageCode',$aData['rtPdtCode']); 
                             }
                        // if($aData['rtLicRefUUID']==''){
                                $aLicensePackageAddOn[] = $aData;
                        }else{
                            
                               $aLicenseClientPos[] = $aData;
                        }
                
                }
            }

            
            // echo '<pre>';

            // // print_r($aLicensePackageAddOn);
            // print_r($oReuslt);
            // echo '</pre>';

        $aDataParam = array(
            'tPatchImg' => $tPatchImgHtml,
            'tIMRCstKey' => $tIMRCstKey,
            'tCstName' => $tCstName,
            'tRegBusName' => $tRegBusName,
            'tRegBusOth' => $tRegBusOth,
            'tRegBusType' => $tRegBusType,
            'tCstTel' => $tCstTel,
            'tCstEmail' => $tCstEmail,
            'oCstBch' => $oCstBch,
            'nStaMassage' => $nStaMassage,
            'aLicensePackageAddOn' => $aLicensePackageAddOn,
            'aLicenseClientPos' => $aLicenseClientPos
        );
        $this->load->view('register/information/wInformationRegisterPageForm',$aDataParam);

    }



    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvIMREventImportAccount(){

        $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('',4);
        $oefIMRCallApiImportAccount = $_FILES['oefIMRCallApiImportAccount'];
        $oStringFile = file_get_contents($oefIMRCallApiImportAccount['tmp_name']);
        $aFile = json_decode($oStringFile, true);

        $tUrlApi = $tUrlObject.'/License/Update/Account';
     
        $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
       
        if($aAPIConfig['rtCode']=='01'){
            $aApiKey = array(
                'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
            );
        }else{
            $aApiKey = array();
        }

         $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aFile,$aApiKey);

         echo json_encode($oReuslt);
    }



        //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvIMREventImportLicense(){

        $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('',4);
        $oefIMRCallApiImportLicense = $_FILES['oefIMRCallApiImportLicense'];
        $oStringFile = file_get_contents($oefIMRCallApiImportLicense['tmp_name']);
        $aFile = json_decode($oStringFile, true);

        $tUrlApi = $tUrlObject.'/License/Update/License';

        $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
       
        if($aAPIConfig['rtCode']=='01'){
            $aApiKey = array(
                'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
            );
        }else{
            $aApiKey = array();
        }

        $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aFile,$aApiKey);

         echo json_encode($oReuslt);
    }



    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvIMRGetPageFormRenew(){

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');



        if(!empty($this->input->post('tCstKey'))){
            $tCstKey = $this->input->post('tCstKey');
            $tStaUpdAcc = 2;
         }else{
            $tCstKey = $this->session->userdata('tSesCstKey'); //กรณีเข้าระบบแล้วมี  licencse แล้ว
            $tStaUpdAcc = 1;
         }
         
          $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);
          $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();

			
          $tUrlApiCstGetLicense = $tUrlObject.'/Customer/RG_CstLicAll?ptCstKey='.trim($tCstKey);

           $aPaRam = array(
              'CstKey' => $tCstKey ,
                'Lang' => 1
             );

            if($aAPIConfig['rtCode']=='01'){
                $aApiKey = array(
                    'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                    'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
                );
            }else{
                $aApiKey = array();
            }
        

            $oReusltLicense = FCNaHCallAPIBasic($tUrlApiCstGetLicense,'GET',$aPaRam,$aApiKey);


            $aLicensePackageAddOn = array();
            $aLicenseClientPos = array();

            if(!empty($oReusltLicense['roItem']['raoCstLic'])){ 
                foreach($oReusltLicense['roItem']['raoCstLic'] as $aData){
                    
                         if($aData['rtPtyCode']!='00003'){
                        // if($aData['rtLicRefUUID']==''){
                                $aLicensePackageAddOn[] = $aData;
                        }else{
                               $aLicenseClientPos[] = $aData;
                        }
                
                }
            }

        $aDataParam = array(
            'aLicensePackageAddOn' => $aLicensePackageAddOn,
            'aLicenseClientPos' => $aLicenseClientPos
        );
        $this->load->view('register/information/wInformationRegisterPageFormReNew',$aDataParam);

    }



}
