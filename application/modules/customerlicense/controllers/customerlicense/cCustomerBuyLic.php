<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cCustomerBuyLic extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('customerlicense/customerlicense/mCustomerBuyLic');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
        $this->load->model('register/information/mInformationRegister');
        date_default_timezone_set("Asia/Bangkok");
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCBLListPage(){
        $this->load->view('customerlicense/customerlicense/tab/customerBuyLic/wCstTabBuyLicList');
    }

    /**
     * Functionality : Function Call DataTables Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCBLDataList(){

        $tCstCode = $this->input->post('tCstCode');
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'tCstCode'      => $tCstCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $aResList = $this->mCustomerBuyLic->FSaMCBLList($aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customerlicense/customerlicense/tab/customerBuyLic/wCstTabBuyLicDataTable', $aGenTable);
    }
    



     /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCBLEditPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aParam = array(
            'FNLngID' => $nLangEdit,
            'FTCstCode' => $this->input->post('rtCstCode'),
            'FTCbrRefBch' => $this->input->post('rtCbrRefBch'),
            'FNLicUUIDSeq' => $this->input->post('rnLicUUIDSeq'),
            'FTLicPdtCode' => $this->input->post('rtLicPdtCode'),
        );
        $aResult        = $this->mCustomerBuyLic->FSaMCBLSearchByID($aParam);
        $aInfoCstServer = $this->mCustomerBuyLic->FSaMCLNGetInfoServerByCstKey($aParam['FTCstCode']);
        $aAPIConfig     = $this->mInformationRegister->FSaMIMGetConfigApi();

        if($aInfoCstServer['rtCode']=='1'){
            $tSrvRefAPIMaste = $aInfoCstServer['raItems']['FTSrvRefAPIMaste'];
            if($aAPIConfig['rtCode']=='01'){
                $aApiKey = array(
                    'tKey'   => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                    'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
                );
            }else{
                $aApiKey = array();
            }
  
            $tUrlApiCalCstProFile = $tSrvRefAPIMaste.'/Branch?ptLang=1&ptCstKey='.trim($aParam['FTCstCode']);
            $oReusltBranch = FCNaHCallAPIBasic($tUrlApiCalCstProFile,'GET',null,$aApiKey);


        }else{
            $oReusltBranch = array();
        }



        $aDataAdd = array(
            'aResult'   => $aResult,
            'FNLngID'   => $nLangEdit,
            'oReusltBranch' => $oReusltBranch,
         
        );

        //  var_dump($oReusltBranch);
      
        $this->load->view('customerlicense/customerlicense/tab/customerBuyLic/wCstTabBuyLicPageForm',$aDataAdd);
    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCBLEditEvent(){
        try{

            $tCstCode = $this->input->post('rtCstCode');
            $tCbrRefBch = $this->input->post('rtCbrRefBch');
            $nLicUUIDSeq = $this->input->post('rnLicUUIDSeq');
            $tLicPdtCode = $this->input->post('rtLicPdtCode');
            $dLicStart = $this->input->post('rdLicStart');
            $dLicFinish = $this->input->post('rdLicFinish');
            $tLicRefUUID = $this->input->post('rtLicRefUUID');
            $nLicStaUse = $this->input->post('rnLicStaUse');
            $tCbrRefBchEdit = $this->input->post('rtCbrRefBchEdit');

            $aDataCstBchWhere = array(
                'FTCstCode' => $tCstCode,
                'FTCbrRefBch' => $tCbrRefBch,
                'FNLicUUIDSeq' => $nLicUUIDSeq,
                'FTLicPdtCode' => $tLicPdtCode,
            ); 
            $aDataCstBch = array(
                'FTCstCode' => $tCstCode,
                'FTCbrRefBch' => $tCbrRefBchEdit,
                'FNLicUUIDSeq' => $nLicUUIDSeq,
                'FTLicPdtCode' => $tLicPdtCode,
                'FDLicStart' => $dLicStart,
                'FDLicFinish' => $dLicFinish,
                'FTLicRefUUID' => $tLicRefUUID,
                'FTLicStaUse' => $nLicStaUse
            );

            $this->db->trans_begin();
            $this->mCustomerBuyLic->FSaMCBLInsertUpdateCstBuyLic($aDataCstBch,$aDataCstBchWhere);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'    => '01',
                    'tStaMessg'    => "Sucess Add Event"
                );

            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    
    


        /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCBLEventExportJson(){
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $tCstCode = $this->input->post('tCstCode');
        $aOjcChcked = $this->input->post('aOjcChcked');
        $aRegCstData = $this->mCustomerBuyLic->FSaMCLNGetDataExport($tCstCode);

        $aRegCstDataLicense = array();
        if(!empty($aOjcChcked)){
                foreach($aOjcChcked as $aDataChecked){
                            $aParamFindLicense = array(
                                    'FTCstCode' => $aDataChecked['tCstCode'],
                                    'FTCbrRefBch' => $aDataChecked['tRefBch'],
                                    'FNLicUUIDSeq' => $aDataChecked['nUidseq'],
                                    'FTLicPdtCode' => $aDataChecked['tLicense'],
                            );
                     $aRegCstDataLicense[] = $this->mCustomerBuyLic->FSaMCLNGetDataLicenseExport($aParamFindLicense,0);
                }

        }else{
                    $aParamFindLicense = array(
                        'FTCstCode' => $tCstCode,
                        'FTCbrRefBch' => '',
                        'FNLicUUIDSeq' => '',
                        'FTLicPdtCode' => '',
                    );

                      $aRegCstDataLicense = $this->mCustomerBuyLic->FSaMCLNGetDataLicenseExport($aParamFindLicense,1);
        }

         if(!empty($aRegCstData)){

                    $aPdtData = array(
                            'ptCstKey' => $tCstCode,
                            'ptSrvStaCenter' => $aRegCstData['raItems']['FTSrvStaCenter'],
                            'paoPdt' => $aRegCstDataLicense
                    );

                    $aParamExport = array(
                            'ptFunction' => 'RG_UpdateLicense',
                            'ptSource' => 'AdaStoreBack',
                            'ptDest' => 'API2PSMaster',
                            'ptFilter' => "",
                            'ptConnStr' => "",
                            'ptData' => json_encode($aPdtData)
                    );
                }else{
                    $aParamExport = array();
         }
 
            echo json_encode($aParamExport);

           exit();

    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSoCBLEventActivatePos(){
        try{

            $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);

            $tUrlApi = $tUrlObject.'/License/RG_ActivateDevide';

            $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
           
            if($aAPIConfig['rtCode']=='01'){
                $aApiKey = array(
                    'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                    'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
                );
            }else{
                $aApiKey = array();
            }
            
            $aParamAvicate = array(
                    'ptCstKey' => $this->input->post('rtCstCode'),
                    'ptUUID' => $this->input->post('rtLicRefUUID'),
                    'pnUUIDSeq' => $this->input->post('rnLicUUIDSeq'),
                    'ptCbrRefBch' => $this->input->post('rtCbrRefBch')
            );

             $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParamAvicate,$aApiKey);
    
             echo json_encode($oReuslt);

        }catch(Exception $Error){
            echo $Error;
        }

    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSoCBLEventSyncLicense(){
        try{

            $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG',1);

            $tUrlApi = $tUrlObject.'/License/RG_LicApprove';

            $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();
           
            if($aAPIConfig['rtCode']=='01'){
                $aApiKey = array(
                    'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                    'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
                );
            }else{
                $aApiKey = array();
            }
            
            $aParamAvicate = array(
                'ptFunctions' => "RG_LicApprove",
                'ptFilter' => "",
                'ptData' => json_encode(array(
                                'ptDocNo' => '',
                                'ptCstKey' => $this->input->post('rtCstCode')
                             ))
                 );

             $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParamAvicate,$aApiKey);
    
             echo json_encode($oReuslt);

        }catch(Exception $Error){
            echo $Error;
        }

    }


}
