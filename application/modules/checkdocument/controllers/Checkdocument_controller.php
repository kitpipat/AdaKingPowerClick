<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Checkdocument_controller extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkdocument/Checkdocument_model');


    }

    public function index($nType)
    {

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');
        $aData = array(
            'tLangEdit' => $tLangEdit,
            'tUserCode' => $tUserCode,
            'nType' => $nType,
        );
        $this->load->view('checkdocument/wCheckdocument',$aData);
    }


    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCMNTGetPageForm(){

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');
        $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
        
        $tMNTTypePage = $this->input->post('tMNTTypePage');
        $aDataParamCall =  array(
            'tLangEdit' => $tLangEdit,
            'tSesUsrRoleCodeMulti' => $tSesUsrRoleCodeMulti
        );
        $aDocType = $this->Checkdocument_model->FSaMMNTGetDocType($aDataParamCall);
        $aDataParam = array(
            'tMNTTypePage' => $tMNTTypePage,
            'aDocType'    => $aDocType
        );

        $this->load->view('checkdocument/wCheckdocumentPageForm',$aDataParam);

    }


    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCMNTGetPageSumary(){
        $tMNTTypePage = $this->input->post('tMNTTypePage');
        $tLangEdit = $this->session->userdata("tLangEdit");
        $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
        $aDataNotiDoc = $this->session->userdata("aDataNotiDoc");
     
        $dMNTDocDateFrom = $this->input->post('tMNTDocDateFrom');
        $dMNTDocDateTo = $this->input->post('tMNTDocDateTo');
        $tMNTDocType = $this->input->post('tMNTDocType');
        $tMNTBchCode = $this->input->post('tMNTBchCode');
        
        $aDataNumByNotCode = array();
        $aDataNumByNotName = array();
        if(!empty($aDataNotiDoc)){
        foreach($aDataNotiDoc as $nKey => $aData){
     
                    if(!empty($tMNTBchCode)){
                        if($tMNTBchCode!=$aData['FTNotBchRef']){
                            continue;
                        }
                    }

                    if(!empty($dMNTDocDateFrom)){
                        if($dMNTDocDateFrom>date('Y-m-d',strtotime($aData['FDNotDate']))){
                            continue;
                        }
                    }

                    if(!empty($dMNTDocDateTo)){
                        if($dMNTDocDateTo<date('Y-m-d',strtotime($aData['FDNotDate']))){
                            continue;
                        }
                    }

                    if(!empty($tMNTDocType)){
                            if($tMNTDocType!=$aData['FTNotCode']){
                                continue;
                            }
                    }

                    if($aData['FTStaRead']!='2'){
                        continue;
                    }
                    // if($tMNTDocType ==''){
                        @$aDataNumByNotCode[$aData['FTNotCode']]++;
                        @$aDataNumByNotName[$aData['FTNotCode']] = $aData['FTNotTypeName'];
                    // }else{
                    //     @$aDataNumByNotCode[$tMNTDocType]++;
                    //     @$aDataNumByNotName[$tMNTDocType] = $aData['FTNotTypeName'];
                    // }

             }
         }
        //  echo '<pre>';   
        //  print_r($aDataNumByNotCode);
        //  print_r($aDataNumByNotName);
        //  echo '</pre>';
        $aDataParamCall =  array(
            'tLangEdit' => $tLangEdit,
            'tSesUsrRoleCodeMulti' => $tSesUsrRoleCodeMulti
        );
        $aDocType = $this->Checkdocument_model->FSaMMNTGetDocType($aDataParamCall);
        $aDataParam = array(
            'tMNTTypePage' => $tMNTTypePage,
            'aDocType'    => $aDocType,
            'aDataNumByNotCode' => $aDataNumByNotCode,
            'aDataNumByNotName' => $aDataNumByNotName,
        );
        $this->load->view('checkdocument/wCheckdocumentSumary',$aDataParam);
    }


    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCMNTGetPageDataTable(){
        $tMNTTypePage = $this->input->post('tMNTTypePage');
        $tLangEdit = $this->session->userdata("tLangEdit");
        $tSesUsrRoleCodeMulti = $this->session->userdata('tSesUsrRoleCodeMulti');
        $aDataNotiDoc = $this->session->userdata("aDataNotiDoc");
        // echo '<pre>';   
        // print_r($aDataNotiDoc);
        // echo '</pre>';

        $dMNTDocDateFrom = $this->input->post('tMNTDocDateFrom');
        $dMNTDocDateTo = $this->input->post('tMNTDocDateTo');
        $tMNTDocType = $this->input->post('tMNTDocType');
        $tMNTBchCode = $this->input->post('tMNTBchCode');
        $aDatTableNoti = array();
        if(!empty($aDataNotiDoc)){
        foreach($aDataNotiDoc as $nKey => $aData){
     
                    if(!empty($tMNTBchCode)){
                        if($tMNTBchCode!=$aData['FTNotBchRef']){
                            continue;
                        }
                    }

                    if(!empty($dMNTDocDateFrom)){
                            if($dMNTDocDateFrom>date('Y-m-d',strtotime($aData['FDNotDate']))){
                                continue;
                            }
                    }

                    if(!empty($dMNTDocDateTo)){
                        if($dMNTDocDateTo<date('Y-m-d',strtotime($aData['FDNotDate']))){
                            continue;
                        }
                    }

                    if(!empty($tMNTDocType)){
                            if($tMNTDocType!=$aData['FTNotCode']){
                                continue;
                            }
                    }
                    
                    $aDatTableNoti[]=$aData;

             }
         }


        $aDataParamCall =  array(
            'tLangEdit' => $tLangEdit,
            'tSesUsrRoleCodeMulti' => $tSesUsrRoleCodeMulti,
        );
        $aDocType = $this->Checkdocument_model->FSaMMNTGetDocType($aDataParamCall);
        $aDataParam = array(
            'tMNTTypePage' => $tMNTTypePage,
            'aDocType'    => $aDocType,
            'aDataNotiDoc'    => $aDatTableNoti,
        );
        $this->load->view('checkdocument/wCheckdocumentDataTable',$aDataParam);
    }
    
    //Functionality : Function Call Add Page Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCMNTAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),

        );
        $this->load->view('checkdocument/wCheckdocumentAdd',$aDataAdd);
    }



    //Functionality : Event Add Reason
    //Parameters : Ajax jReason()
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCMNTAddEvent(){
        try{
            // echo '<pre>';
            $tMNTAgnCode   = $this->input->post('oetMNTAgnCode');
            $tMNTAgnName   = $this->input->post('oetMNTAgnName');
            $tMntInBcnCode = $this->input->post('oetMntInBcnCode');
            $tMntInBcnName = $this->input->post('oetMntInBcnName');
            $tMNTDesc1     = $this->input->post('oetMNTDesc1');
            $tMNTDesc2     = $this->input->post('oetMNTDesc2');
            $tMNTUsrRef    = $this->input->post('oetMNTUsrRef');

            $aMntConditionChkDocAgnCode  = $this->input->post('ohdMntConditionChkDocAgnCode');
            $aMntConditionChkDocBchCode  = $this->input->post('ohdMntConditionChkDocBchCode');
            $aMntBchModalType            = $this->input->post('ohdMntBchModalType');

        
            if($tMNTUsrRef!=''){
                $nNoaUrlType = 2;
            }else{
                $nNoaUrlType = 3;
            }

            $oaTCNTNotiSpc[] =  array(
                                    "FNNotID"      => '',
                                    "FTNotType"    => '1',
                                    "FTNotStaType" => '1',
                                    "FTAgnCode"    => $tMNTAgnCode,
                                    "FTBchCode"    => $tMntInBcnCode,
                                );
            if(!empty($aMntBchModalType)){    
                foreach($aMntBchModalType as $nKey => $tNotStaType){
                $oaTCNTNotiSpc[] =  array(
                                        "FNNotID"      => '',
                                        "FTNotType"    => '2',
                                        "FTNotStaType" => $tNotStaType,
                                        "FTAgnCode"    => $aMntConditionChkDocAgnCode[$nKey],
                                        "FTBchCode"    => $aMntConditionChkDocBchCode[$nKey],
                );
                }
            }
            $aMQParamsNoti = [
                "queueName" => "CN_SendToNoti",
                "tVhostType" => "NOT",
                "params"    => [
                                 "oaTCNTNoti" => array(
                                                 "FNNotID"       => '',
                                                 "FTNotCode"     => '00000',
                                                 "FTNotKey"      => 'NEWS',
                                                 "FTNotBchRef"   => '',
                                                 "FTNotDocRef"   => '',
                                 ),
                                 "oaTCNTNoti_L" => array(
                                                    0 => array(
                                                        "FNNotID"       => '',
                                                        "FNLngID"       => 1,
                                                        "FTNotDesc1"    => $tMNTDesc1,
                                                        "FTNotDesc2"    => $tMNTDesc2,
                                                    ),
                                                    1 => array(
                                                        "FNNotID"       => '',
                                                        "FNLngID"       => 2,
                                                        "FTNotDesc1"    => $tMNTDesc1,
                                                        "FTNotDesc2"    => $tMNTDesc2,
                                                    )
                                ),
                                 "oaTCNTNotiAct" => array(
                                                     0 => array( 
                                                            "FNNotID"         => '',
                                                            "FDNoaDateInsert" => date('Y-m-d H:i:s'),
                                                            "FTNoaDesc"       => $tMNTDesc2,
                                                            "FTNoaDocRef"     => '',
                                                            "FNNoaUrlType"    => $nNoaUrlType,
                                                            "FTNoaUrlRef"     => $tMNTUsrRef,
                                                            ),
                                     ), 
                                 "oaTCNTNotiSpc" => $oaTCNTNotiSpc,
                    "ptUser"        => $this->session->userdata('tSesUsername'),
                ]
            ];
            // echo '<pre>';
            // print_r($aMQParamsNoti);
            // echo '</pre>';
            // die();
            FCNxCallRabbitMQ($aMQParamsNoti);


            die();
        }catch(Exception $Error){
            echo $Error;
        }
    }
}
