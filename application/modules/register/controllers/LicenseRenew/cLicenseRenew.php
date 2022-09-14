<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cLicenseRenew extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('register/information/mInformationRegister');
        $this->load->model('register/BuyLicense/mBuyLicense');
    }

    public function index()
    {

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');

        $this->load->view('register/LicenseRenew/wLicenseRenewMain');
     
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



        if(!empty($this->input->post('tCstKey'))){
            $tCstKey = $this->input->post('tCstKey');
            $tStaUpdAcc = 2;
         }else{
            $tCstKey = $this->session->userdata('tSesCstKey'); //กรณีเข้าระบบแล้วมี  licencse แล้ว
            $tStaUpdAcc = 1;
         }

          $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);
        
          $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();

          $tCstKey=$this->session->userdata('tSesCstKey');
          
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

            $tUrlApiGetPackage = $tUrlObject.'/Product/RG_PdtListPackage?ptCstkey='.trim($tCstKey).'&ptStaExcept=2';
            $oReusltPakage = FCNaHCallAPIBasic($tUrlApiGetPackage,'GET',$aPaRam,$aApiKey);
            $aUnitPdtPackge = array();
            if(!empty($oReusltPakage['roItem']['raoDataPackage'][0]['raoPrice'])){
                 $aUnitPdtPackge = $oReusltPakage['roItem']['raoDataPackage'][0]['raoPrice'];
            }

            $aLicensePackageAddOn = array();
            $aLicenseClientPos = array();

            if(!empty($oReusltLicense['roItem']['raoCstLic'])){ 
                foreach($oReusltLicense['roItem']['raoCstLic'] as $aData){
                    
                         if($aData['rtPtyCode']!='00003'){
                        // if($aData['rtLicRefUUID']==''){
                                $aLicensePackageAddOn[] = $aData;
                        }else{
                            if($aData['rtRefSaleDoc']==''){
                                continue;
                            }
                               $aLicenseClientPos[] = $aData;
                        }
                
                }
            }

        $aDataParam = array(
            'aLicensePackageAddOn' => $aLicensePackageAddOn,
            'aLicenseClientPos' => $aLicenseClientPos,
            'aUnitPdtPackge' => $aUnitPdtPackge
        );
        $this->load->view('register/LicenseRenew/wLicenseRenewPageForm',$aDataParam);

    }

    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvIMRInsertDTToTemp(){

        $aInputPostLicCode = $this->input->post();

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
        // echo '<pre>';
        // print_r($aInputPostLicCode);
        // echo '</pre>';
            $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
            // $tCstKey = $this->session->userdata('tSesCstKey'); //กรณีเข้าระบบแล้วมี  licencse แล้ว
            $tCstKey = $this->session->userdata('tSesCstKey');
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

            $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);

            $tUrlApiGetPackage = $tUrlObject.'/Product/RG_PdtListPackage?ptCstkey='.trim($tCstKey).'&ptStaExcept=2';
            $oReusltPakage = FCNaHCallAPIBasic($tUrlApiGetPackage,'GET',$aPaRam,$aApiKey);
            if(!empty($aInputPostLicCode['oPackageLicCode'])){
             $oPackageItems = $oReusltPakage['roItem']['raoDataPackage'][0];
             if(!empty($oReusltPakage['roItem']['raoDataPackage'][0]['raoPrice'])){
                 foreach($oReusltPakage['roItem']['raoDataPackage'][0]['raoPrice'] as $aData){
                     if($aData['rtPdtCode']==$aInputPostLicCode['oPackageLicCode'][0] &&  $aData['rtPunCode']==$aInputPostLicCode['nRenewmonth']){
                        $oPackageItems['raoPrice'] = $aData;
                     }
                 }
             }

             $aDataFeabyPkgItems = array();
             if(!empty($oReusltPakage['roItem']['raoDataFeabyPkg'])){
                        foreach($oReusltPakage['roItem']['raoDataFeabyPkg'] as $aData){
                                if($aData['raoAlwPackage'][0]['rtStaAlwUse']=='1'){
                                        $aDataFeabyPkgItems[] = $aData;
                                }
                        }
             }

             $this->FSaIMRInsertPackageDTToTemp($oPackageItems,$aDataFeabyPkgItems);
                $nSeqDT = 2;
            }else{
                $nSeqDT = 1;
            }

            if(!empty($aInputPostLicCode['oFeatureLicCode'])){
            $tUrlApiGetFeature = $tUrlObject.'/Product/RG_PdtListFeature?ptCstkey='.trim($tCstKey).'&ptStaExcept=2';
            $oReusltFeature= FCNaHCallAPIBasic($tUrlApiGetFeature,'GET',$aPaRam,$aApiKey);

            $aFeatureDataItems = array();
            if(!empty($aInputPostLicCode['oFeatureLicCode'])){
                    foreach($aInputPostLicCode['oFeatureLicCode'] as $tFeatureCode){

                            if(!empty($oReusltFeature['roItem']['raoDataFeature'])){
                                foreach($oReusltFeature['roItem']['raoDataFeature'] as $aFeatureData){

                                    if($aFeatureData['rtPdtCode']==$tFeatureCode){

                                            if(!empty($aFeatureData['raoPrice'])){
                                                foreach($aFeatureData['raoPrice'] as $aFeatureDataPrice){

                                                        if($aFeatureDataPrice['rtPdtCode']==$tFeatureCode && $aFeatureDataPrice['rtPunCode']==$aInputPostLicCode['nRenewmonth']){
                                                            $aFeatureData['raoPrice'] = $aFeatureDataPrice ;
                                                            $aFeatureDataItems[] =  $aFeatureData;
                                                        }

                                                }
                                            }

                                    }

                                }
                            }

                    }   
               
            }
            //  echo '<pre>';
            //  print_r($aFeatureDataItems);
            //  echo '</pre>';
            $nSeqDT =  $this->FSnIMRInsertFeatureDTToTemp($aFeatureDataItems,$nSeqDT);
        }else{
            $nSeqDT = $nSeqDT;
        }

        if(!empty($aInputPostLicCode['oClientLicCode'])){
            $tUrlApiGetClient = $tUrlObject.'/Product/RG_PdtListClient?ptCstkey='.trim($tCstKey).'&ptStaExcept=2';
            $oReusltClient= FCNaHCallAPIBasic($tUrlApiGetClient,'GET',$aPaRam,$aApiKey);

            $aClientDataItems = array();
            if(!empty($aInputPostLicCode['oClientLicCode'])){
                    foreach($aInputPostLicCode['oClientLicCode'] as $aClientLicData){

                            if(!empty($oReusltClient['roItem']['raoDataClientPos'])){
                                foreach($oReusltClient['roItem']['raoDataClientPos'] as $aClientPosData){

                                    if($aClientPosData['rtPdtCode']==$aClientLicData['tPosCode']){
                              
                                            if(!empty($aClientPosData['raoPrice'])){
                                                foreach($aClientPosData['raoPrice'] as $aClientPosDataPrice){

                                                        if($aClientPosDataPrice['rtPdtCode']==$aClientLicData['tPosCode'] && $aClientPosDataPrice['rtPunCode']==$aInputPostLicCode['nRenewmonth']){
                                                            $aClientPosData['raoPrice'] = $aClientPosDataPrice ;
                                                            $aClientPosData['FTSrnCode'] = $aClientLicData['nSeqUUid'];
                                                            $aClientDataItems[] =  $aClientPosData;
                                                          
                                                        }

                                                }
                                            }

                                    }

                                }
                            }

                    }   
            }

            //  echo '<pre>';
            //  print_r($aClientDataItems);
            //  echo '</pre>';
            $this->FSaIMRInsertClientDTToTemp($aClientDataItems,$nSeqDT);
        }

        // echo $this->session->userdata('tSesSessionID');
        // sleep(10);

    }



    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaIMRInsertPackageDTToTemp($paPackageItems,$paDataFeabyPkgItems){
            $tCstKey = $this->session->userdata('tSesCstKey');

            //กำหนดค่าให้ VAT + VATType ให้กับเอกสาร
            $this->session->set_userdata( "nVatCalculate", $paPackageItems['rtVATInOrEx'] );
            $this->session->set_userdata( "nVatRate", $paPackageItems['rcVatRate'] );

            $nNumber = 1;
            $nVatCalculate  = $this->session->userdata("nVatCalculate");
            $nVatRate       = $this->session->userdata("nVatRate");

            $nPrice     = preg_replace('/\,/', '', $paPackageItems['raoPrice']['rcPgdPriceRet']);
            $nVatRate   = $paPackageItems['rcVatRate'];
            $nVat       = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;

            //Insert Feature 
            $aInsertShowTemp    = array( //ส่วนของโชว์
                'tKey'              => 'Package',
                'tBchCode'          => $this->session->userdata("tSesHQBchCode"),
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
                'nSeq'              => $nNumber,
                'tTextPackage'      => $paPackageItems['rtPdtName'],
                'tTextDetail'       => $paPackageItems['rtPdtNameOth'],
                'tTextMonth'        => $paPackageItems['raoPrice']['rtPunName'],
                'tTextPrice'        => preg_replace('/\,/', '', $paPackageItems['raoPrice']['rcPgdPriceRet']),
            );

            //  echo '<pre>';
            //  print_r($aInsertShowTemp);
            //  echo '</pre>';
            $this->mBuyLicense->FSxMBUYInsertToTemp('Package' , $aInsertShowTemp);




            $aInsertDT = array( //ส่วนของเก็บเอาไว้เพื่อส่ง
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => '',
                'FNXsdSeqNo'        => $nNumber,
                'FTPdtCode'         => $paPackageItems['rtPdtCode'],
                'FTXsdPdtName'      => $paPackageItems['rtPdtName'],
                'FTPunCode'         => $paPackageItems['raoPrice']['rtPunCode'],
                'FTPunName'         => $paPackageItems['raoPrice']['rtPunName'],
                'FCXsdFactor'       => $paPackageItems['raoPrice']['rcUnitFact'],
                'FTXsdBarCode'      => $paPackageItems['rtPdtCode'],
                'FTSrnCode'         => '0', //Fix 0
                'FTXsdVatType'      => $paPackageItems['rtStaVat'],
                'FTVatCode'         => $paPackageItems['rtVatCode'],
                'FTPplCode'         => '',
                'FCXsdVatRate'      => $paPackageItems['rcVatRate'],
                'FTXsdSaleType'     => '1',  
                'FCXsdSalePrice'    => $nPrice,
                'FCXsdQty'          => '1',
                'FCXsdQtyAll'       => '1' * $paPackageItems['raoPrice']['rcUnitFact'],
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
                'FTXsdStaAlwDis'    => $paPackageItems['rtStaAlwDis'],
                'FNXsdPdtLevel'     => '0',
                'FTXsdPdtParent'    => '',
                'FCXsdQtySet'       => '1',
                'FTPdtStaSet'       => $paPackageItems['rtStaSet'],
                'FTXsdRmk'          => '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $tCstKey,
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);



        foreach($paDataFeabyPkgItems as $nK => $aDataItem){
            $nNumber++;

            //Insert Feature 
            $aInsertShowTemp    = array( //ส่วนของโชว์
                'tKey'              => 'Package',
                'tBchCode'          => $this->session->userdata("tSesHQBchCode"),
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
                'nSeq'              => ($nNumber),
                'tTextPackage'      => $aDataItem['rtPdtName'],
                'tTextDetail'       => $aDataItem['rtPdtNameOth'],
                'tTextMonth'        => $paPackageItems['raoPrice']['rtPunName'],
                'tTextPrice'        => preg_replace('/\,/', '', $paPackageItems['raoPrice']['rcPgdPriceRet']),
            );

            //  echo '<pre>';
            //  print_r($aInsertShowTemp);
            //  echo '</pre>';
            $this->mBuyLicense->FSxMBUYInsertToTemp('Package' , $aInsertShowTemp);
            //Insert Feature To SetDT
            $aInsertSetDT    = array(
                'FTBchCode'             => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'            => '',
                'FNXsdSeqNo'            => 1,
                'FNPstSeqNo'            => ($nNumber),
                'FTPdtCode'             => $aDataItem['rtPdtCode'],
                'FTXsdPdtName'          => $aDataItem['rtPdtName'],
                'FTPunCode'             => $paPackageItems['raoPrice']['rtPunCode'],
                'FCXsdQtySet'           => 1,
                'FCXsdSalePrice'        => 0,
                'FTSessionID'           => $this->session->userdata('tSesSessionID')
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTSetTmp' , $aInsertSetDT);

           
        }

    }

    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSnIMRInsertFeatureDTToTemp($paFeatues,$pnSeqDT){
        $tCstKey = $this->session->userdata('tSesCstKey');
        //Loop ลงตาราง Temp : Featues
        $nNumber        = 1;
        $nNumberAddOn   = $pnSeqDT;
        for($i=0; $i<FCNnHSizeOf($paFeatues); $i++){
        //สินค้าฟิเจอร์ เอาไว้โชว์
            $aInsert = array(
                'tKey'          => 'Featues',
                'tBchCode'      => $this->session->userdata("tSesHQBchCode"),
                'tSessionID'    => $this->session->userdata('tSesSessionID'),
                'nSeq'          => $nNumber++,
                'tTextFeatues'  => $paFeatues[$i]['rtPdtName'],
                'tTextDetail'   => $paFeatues[$i]['rtPdtNameOth'],
                'tTextQty'      => $paFeatues[$i]['raoPrice']['rtPunName'],
                'tTextPrice'    => preg_replace('/\,/', '', $paFeatues[$i]['raoPrice']['rcPgdPriceRet'])
            );
            //  echo '<pre>';
            //  print_r($aInsert);
            //  echo '</pre>';
            $this->mBuyLicense->FSxMBUYInsertToTemp('Featues' , $aInsert);

            //สินค้าฟิเจอร์
            $nVatCalculate  = $this->session->userdata("nVatCalculate");
            $nVatRate       = $this->session->userdata("nVatRate");
            $nPrice         = preg_replace('/\,/', '', $paFeatues[$i]['raoPrice']['rcPgdPriceRet']);
            $nVatRate       = $paFeatues[$i]['rcVatRate'];
            $nVat           = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;
            $aInsertDT      = array(
                'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                'FTXshDocNo'        => 'FEATUES',
                'FNXsdSeqNo'        => $nNumberAddOn,
                'FTPdtCode'         => $paFeatues[$i]['rtPdtCode'],
                'FTXsdPdtName'      => $paFeatues[$i]['rtPdtName'],
                'FTPunCode'         => $paFeatues[$i]['raoPrice']['rtPunCode'],
                'FTPunName'         => $paFeatues[$i]['raoPrice']['rtPunName'],
                'FCXsdFactor'       => $paFeatues[$i]['raoPrice']['rcUnitFact'],
                'FTXsdBarCode'      => $paFeatues[$i]['rtPdtCode'],
                'FTSrnCode'         => 0,
                'FTXsdVatType'      => $paFeatues[$i]['rtStaVat'],
                'FTVatCode'         => $paFeatues[$i]['rtVatCode'],
                'FTPplCode'         => '',
                'FCXsdVatRate'      => $paFeatues[$i]['rcVatRate'],
                'FTXsdSaleType'     => '1',
                'FCXsdSalePrice'    => $nPrice,
                'FCXsdQty'          => '1',
                'FCXsdQtyAll'       => '1' * $paFeatues[$i]['raoPrice']['rcUnitFact'],
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
                'FTXsdStaAlwDis'    => $paFeatues[$i]['rtStaAlwDis'],
                'FNXsdPdtLevel'     => '0',
                'FTXsdPdtParent'    => '',
                'FCXsdQtySet'       => '1',
                'FTPdtStaSet'       => $paFeatues[$i]['rtStaSet'],
                'FTXsdRmk'          => '',
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => '-',
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $tCstKey,
                'FTSessionID'       => $this->session->userdata('tSesSessionID'),
            );
            $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);
            $nNumberAddOn++;

        }

        return $nNumberAddOn;
    }

    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaIMRInsertClientDTToTemp($aPos,$nNumberAddOn){
        $tCstKey = $this->session->userdata('tSesCstKey');

        //Loop ลงตาราง Temp : Pos
        $nNumberPos = 1;
        $nNumber    = 1;
        for($i=0; $i<FCNnHSizeOf($aPos); $i++){
            if($aPos[$i]['rtPdtName'] != '' || $aPos[$i]['rtPdtName'] != null){

                //สินค้าจุดขาย
                $aInsert = array(
                    'tKey'          => 'Pos',
                    'tBchCode'      => $this->session->userdata("tSesHQBchCode"),
                    'tSessionID'    => $this->session->userdata('tSesSessionID'),
                    'nSeq'          => $nNumber++,
                    'tTextPos'      => $aPos[$i]['rtPdtName'],
                    'tTextPosQty'   => $aPos[$i]['raoPrice']['rtPunName'],
                    'tTextPosPrice' => preg_replace('/\,/', '', $aPos[$i]['raoPrice']['rcPgdPriceRet'])
                );
                $this->mBuyLicense->FSxMBUYInsertToTemp('Pos' , $aInsert);

                //สินค้าจุดขาย
                $nVatCalculate  = $this->session->userdata("nVatCalculate");
                $nVatRate       = $this->session->userdata("nVatRate");
                $nPrice         = preg_replace('/\,/', '', $aPos[$i]['raoPrice']['rcPgdPriceRet']);
                $nVatRate       = $aPos[$i]['rcVatRate'];
                $nVat           = ($nVatCalculate == 1) ? $nPrice -(($nPrice*100)/(100+$nVatRate)) : (($nPrice*(100+$nVatRate))/100)-$nPrice;
                $aInsertDT      = array( 
                    'FTBchCode'         => $this->session->userdata("tSesHQBchCode"),
                    'FTXshDocNo'        => 'POS',
                    'FNXsdSeqNo'        => $nNumberAddOn++,
                    'FTPdtCode'         => $aPos[$i]['rtPdtCode'],
                    'FTXsdPdtName'      => $aPos[$i]['rtPdtName'],
                    'FTPunCode'         => $aPos[$i]['raoPrice']['rtPunCode'],
                    'FTPunName'         => $aPos[$i]['raoPrice']['rtPunName'],
                    'FCXsdFactor'       => $aPos[$i]['raoPrice']['rcUnitFact'],
                    'FTXsdBarCode'      => $aPos[$i]['rtPdtCode'],
                    'FTSrnCode'         => $aPos[$i]['FTSrnCode'], //รันตาม pos (ถ้าเป็นขาแก้ไข เอา seq เดิมมาใช้)
                    'FTXsdVatType'      => $aPos[$i]['rtStaVat'],
                    'FTVatCode'         => $aPos[$i]['rtVatCode'],
                    'FTPplCode'         => '',
                    'FCXsdVatRate'      => $aPos[$i]['rcVatRate'],
                    'FTXsdSaleType'     => '1',
                    'FCXsdSalePrice'    => $nPrice,
                    'FCXsdQty'          => '1',
                    'FCXsdQtyAll'       => '1' * $aPos[$i]['raoPrice']['rcUnitFact'],
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
                    'FTXsdStaAlwDis'    => $aPos[$i]['rtStaAlwDis'],
                    'FNXsdPdtLevel'     => '',
                    'FTXsdPdtParent'    => '',
                    'FCXsdQtySet'       => 0,
                    'FTPdtStaSet'       => $aPos[$i]['rtStaSet'],
                    'FTXsdRmk'          => '',
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => '-',
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $tCstKey,
                    'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                );
                $this->mBuyLicense->FSxMBUYInsertToTemp('TRGTSalDTTmp' , $aInsertDT);
                $nNumberPos++;
            }
        }

        
    }

}
