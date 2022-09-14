<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSmartlockerCheckstatus extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/smartlockerCheckstatus/mSmartlockerCheckstatus');
        $this->load->model('company/shopgpbypdt/mShopGpByPdt');
    }

    //Main page
    public function FSvCPSHCheckStatusMainPage(){
        $tShpCode       = $this->input->post('tShpCode');
        $tMerCode       = $this->input->post('tMerCode');
        $tSesUserLevel  = $this->session->userdata("tSesUsrLevel"); 
        $tBchCode       = $this->input->post('tBchCode');
        $tSaleMac       = $this->input->post('tSaleMac');
        

        if($tSesUserLevel == 'HQ'){ 
            //เช้ามาแบบสำนักงานใหญ่
            $tBchCode = $this->input->post('tBchCode');
            $tNameBch = '';
        }else{ 
            //เข้ามาแบบสาขาหรือช็อป
            if (strpos($tBchCode, ',') !== false) {
                //มีหลายสาขา
                $tBchCode = $this->session->userdata("tSesUsrBchCode"); 
                $tNameBch = '';
            }else{
                //มีสาขาเดียว
                $tBchCode   = $this->input->post('tBchCode');
                $aDataChk   = array(
                    'FTBchCode' => $tBchCode,
                    'FTShpCode' => ''
                );
                $tNameBch   = $this->mShopGpByPdt->FSaMShopGpBySelectDataDT($aDataChk,'branch');
            }
        }

        $aData          = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode
        );
        
        $tNameBch       = $this->mShopGpByPdt->FSaMShopGpBySelectDataDT($aData,'branch');
        $aResultRack    = $this->mSmartlockerCheckstatus->FSaMPSHCheckStatusGetRack($tBchCode,$tShpCode);

        $this->load->view('company/smartlockerCheckstatus/wSmartlockerCheckstatusMain',array(
            'tNameBch'      => $tNameBch,
            'aResultRack'   => $aResultRack,
            'tBchCode'      => $tBchCode,
            'tSaleMac'      => $tSaleMac 
        ));
    }

    //Data Table
    public function FSvCPSHCheckStatusDataTable(){
        $tShpCode       = $this->input->post('tShpCode');
        $tBchCode       = $this->input->post('tBchCode');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tRack          = $this->input->post('tRack');
        $tSaleMac       = $this->input->post('tSaleMac');
        $nWidth         = $this->input->post('nWidth');

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => $tShpCode,
            'FNLngID'       => $nLangEdit,
            'FTRakCode'     => $tRack,
            'tSaleMac'      => $tSaleMac
        );
        $aResultData = $this->mSmartlockerCheckstatus->FSaMPSHCheckStatusGetDetail($aData);
        // echo '<pre>';
        // print_r($aResultData);
        // exit;
        $aGenTable          = array(
            'aDataList' 	    => $aResultData,
            'tSaleMac'          => $tSaleMac,
            'nWidth'            => $nWidth 
        );
        //Return Data View
        $this->load->view('company/smartlockerCheckstatus/wSmartlockerCheckstatusDataTable',$aGenTable);
    }

    //Insert Locker
    public function FSvCPSHCheckStatusInsertLocker(){
        $tBCH           = $this->input->post('tBCH');
        $tSHP           = $this->input->post('tSHP');
        $tPOS           = $this->input->post('tPOS');
        $nLayno         = $this->input->post('nLayno');
        $nTelphone      = $this->input->post('nTelphone');
        $nReasonCode    = $this->input->post('nReasonCode');
        $aData = array(
            'FTBchCode'         => $tBCH,
            'FTShpCode'         => $tSHP,
            'FTPosCode'         => $tPOS,
            'FDHisDateTime'     => date('Y-m-d H:i:s'),
            'FNHisLayNo'        => $nLayno,
            'FTHisUsrCode'      => $this->session->userdata('tSesUsername'),
            'FTHisCstTel'       => $nTelphone,
            'FTHisRsnCode'      => $nReasonCode,
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            'FTHisType'         => 1
        );
        // Get Data Shop Pos LayOut  
        $aDataShopPosLayOut =   $this->mSmartlockerCheckstatus->FSaMPSHGetDataShopLayOut($aData);
        if(isset($aDataShopPosLayOut) && !empty($aDataShopPosLayOut)){
            $tLockerBoardNo     = $aDataShopPosLayOut['FNLayBoardNo'];
            $tLockerLayBoxNo    = $aDataShopPosLayOut['FTLayBoxNo'];
            if($tLockerBoardNo !== "" && $tLockerLayBoxNo !== ""){
                // Insert Admin History Locker
                $this->mSmartlockerCheckstatus->FSaMPSHInsertOpenLocker($aData);
                // Parameter Rabbit MQ RT_QDownload00001

                $tExchangeName  = "RT_XDownload".$aDataShopPosLayOut['FTPosCode'];
                $tQueuesName    = "RT_QDownload".$aDataShopPosLayOut['FTPosCode'];
                $dJobTime       = date("Y-m-d H:i:s");
                $tParaLocker    = $aDataShopPosLayOut['FTPosCode'].','.$aDataShopPosLayOut['FTLayBoxNo'];
                try{
                    // Set Array Data Rebit MQ
                    $aMQParams = [
                        "exchangname"   => $tExchangeName,
                        "queuesname"    => $tQueuesName,
                        "params"        => [
                            'rtAppName' => 'Locker',
                            'rtJobName' => 'Open_Locker',
                            'rtJobTime' => $dJobTime,
                            'rtPara'    => $tParaLocker,
                            'rtBchCode' => $aDataShopPosLayOut['FTBchCode'],
                            'rtShpCode' => $aDataShopPosLayOut['FTShpCode'],
                            'rtBoardNo' => $aDataShopPosLayOut['FNLayBoardNo']
                        ]
                    ];
                    FCNxRentalCallRabbitMQ($aMQParams);
                    $aDataReturn    = array(
                        'nStaReturn'        => 1,
                        'tStaTextReturn'    => 'Success Send Open Locker Rabbit MQ'
                    );
                }catch(ErrorException $err){
                    $aDataReturn    = array(
                        'nStaReturn'        => 500,
                        'tStaTextReturn'    => $err
                    );
                }
            }else{
                $aDataReturn    = array(
                    'nStaReturn'        => 800,
                    'tStaTextReturn'    => 'ไม่พบข้อมูลการตั้งค่าเลเอาท์'
                );
            }
        }else{
            $aDataReturn    = array(
                'nStaReturn'        => 800,
                'tStaTextReturn'    => 'ไม่พบข้อมูลการตั้งค่าเลเอาท์'
            );
        }
        echo json_encode($aDataReturn);
    }




}