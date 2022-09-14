<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cConnectionSetting extends MX_Controller {


    public function __construct(){
        parent::__construct ();
        $this->load->model('interface/connectionsetting/mConnectionSetting');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType,$tBrowseOption){
        $aDataSetting = array(
            'nBrowseType'                   => $nBrowseType,
            'tBrowseOption'                 => $tBrowseOption,
            'aAlwEventConnectionSetting'    => FCNaHCheckAlwFunc('ConnectionSetting/0/0'), //Controle Event
            'vBtnSave'                      => FCNaHBtnSaveActiveHTML('ConnectionSetting/0/0'), //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        );
        $this->load->view('interface/connectionsetting/wConnectionsetting',$aDataSetting);

    }

    // Call page list
    // Create WItsarut 28052020
     public function FSvCCCSDataList(){

        $tSearchAllNotSet  = $this->input->post('tSearchAllNotSet');
        $tSearchAllSetUp   = $this->input->post('tSearchAllSetUp');

        $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
        $tUsrBchCode     = $this->session->userdata("tSesUsrBchCodeMulti");


        $aData = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'nPageCurrent'      => $this->input->post('nPageCurrent'),
            'tSearchAllNotSet'  => $tSearchAllNotSet,
            'tSearchAllSetUp'   => $tSearchAllSetUp,
            'tStaUsrLevel'      => $tStaUsrLevel,
            'tUsrBchCode'       => $tUsrBchCode,
        );

        $aWaHouseListup      = $this->mConnectionSetting->FSaMCCSListDataUP($aData);
        $aWaHouseListdown    = $this->mConnectionSetting->FSaMCCSListDataDown($aData);
        $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');

        $aDataResult  = [
            'aWaHouseListup'     => $aWaHouseListup,
            'aWaHouseListdown'   => $aWaHouseListdown,
            'aAlwEvent'          => $aAlwEventConnectionSetting,
            'tSearchAllNotSet'   => $tSearchAllNotSet,
            'tSearchAllSetUp'    => $tSearchAllSetUp
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingWahouse',$aDataResult);

     }

    //Functionality :  Load Page Add settingWahouse
    //Parameters :
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSPageWahouse(){

        $this->load->view('interface/connectionsetting/wConnectionsettingWahouse');
    }


    //Functionality :  Load Page Customer
    //Parameters :
    //Creator : 02/08/2021 Amontep (Mos)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSPageCustomer(){
        $this->load->view('interface/connectionsetting/wConnectionsettingCustomer');
    }

    public function FSvCCCSCustomerDataList(){
       $aData = array(
            'tKeyword'          => trim($this->input->post('tKeyword')),
            'FNLngID'           => $this->session->userdata("tLangEdit"),
       );

       $aCustomerLis                = $this->mConnectionSetting->FSaMCCSListDataCustomer($aData);
       $aAlwEventConnectionSetting  = FCNaHCheckAlwFunc('ConnectionSetting/0/0');

       $aDataResult  = [
           'aCustomerLis'       => $aCustomerLis,
           'aAlwEvent'          => $aAlwEventConnectionSetting
       ];

       $this->load->view('interface/connectionsetting/wConnectionsettingCustomerTable',$aDataResult);
    }
    // public function FSvCCCSCustomerDataListSearch()
    // {
    //   $aData = array(
    //       'FNLngID'           => $this->session->userdata("tLangEdit"),
    //       'tKeyword'          => $this->input->post('tKeyword')
    //   );

    //   $aCustomerLis      = $this->mConnectionSetting->FSaMCCSListDataCustomerSheach($aData);
    //   $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');

    //   $aDataResult  = [
    //       'aCustomerLis'     => $aCustomerLis,
    //       'aAlwEvent'     => $aAlwEventConnectionSetting
    //   ];

    //   $this->load->view('interface/connectionsetting/wConnectionsettingCustomerTable',$aDataResult);
    // }

    //Functionality :  Load Page Add Wahouse
    //Parameters :
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSPageAddWahouse(){
        $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');
        $aDataAdd = [
            'aResult'       => array('rtCode'=>'99'),
            'aAlwEvent'     => $aAlwEventConnectionSetting,
            'tBchCompCode'  => $this->session->userdata("tSesUsrBchCodeDefault"),
            'tBchCompName'  => $this->session->userdata("tSesUsrBchNameDefault"),
            'tShpCompCode'  => '',
            'tShpCompName'  => '',
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingAdd',$aDataAdd);

    }

    public function FSxCCCSPageAddCustomer(){
        $aAlwEventConnectionSetting = FCNaHCheckAlwFunc('ConnectionSetting/0/0');
        // $tBchCode = $this->input->post('tBchCode');
        // $tCbrSoldTo = $this->input->post('tCbrSoldTo');
        $aData = [
            'FNLngID'        => $this->session->userdata("tLangEdit"),
            'tBchCode'       => $this->input->post('tBchCode'),
            'tCbrSoldTo'     => $this->input->post('tCbrSoldTo'),
            'tChnCode'       => $this->input->post('tChnCode')
        ];
        $aCustomerLis      = $this->mConnectionSetting->FSaMCCSListDataCustomerByid($aData);

        $aDataAdd = [
            'aCustomerLis'  => $aCustomerLis,
            'aResult'       => array('rtCode'=>'99'),
            'aAlwEvent'     => $aAlwEventConnectionSetting
        ];

        $this->load->view('interface/connectionsetting/wCustomersettingAdd',$aDataAdd);

    }

    //Functionality : Event Add settingWahouse
    //Parameters : Ajax jConnectionSetting()
    //Creator : 15/05/202020 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSxCCCSWahouseEventAdd(){
        try{
            if ($this->input->post('ocbStatusPdtOnline')=="on") {
              $tStatusPdtOnline = "1";
            }else {
              $tStatusPdtOnline = NULL;
            }
            $aDataMaster        = [
                'FTAgnCode'         => $this->input->post('oetCssAgnCode'),
                'FTBchCode'         => $this->input->post('oetCssBchCode'),
                'FTShpCode'         => $this->input->post('oetCssShpCode'),
                'FTWahCode'         => $this->input->post('oetCssWahCode'),
                'FTWahRefNo'        => $this->input->post('oetCssWahRefNo'),
                'FTWahStaOnline'    => $tStatusPdtOnline,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ];

                $this->db->trans_begin();
                $aStaEventMaster  = $this->mConnectionSetting->FSaMCSSAddUpdateMaster($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }

            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSxCCCSCustomerEventAdd(){
        try{
            $this->db->trans_begin();
            $aDataMaster        = [
                'FTCbrSoldTo'         => $this->input->post('oetCssCustomer'),
                'FTBchCode'           => $this->input->post('oetCssBchCode'),
                'FTChnCode'           => $this->input->post('oetCssChnCode'),
            ];
            $aStaEventMaster  = $this->mConnectionSetting->FSaMCUSAddUpdateMaster($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    //Functionality :  Load Page settingWahouse
    //Parameters :
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCCCSWahousePageEdit(){
        $aData  = [
            'FTAgnCode' => $this->input->post('tMerCode'),
            'FTBchCode' => $this->input->post('tBchCode'),
            'FTShpCode' => $this->input->post('tShpCode'),
            'FTWahCode' => $this->input->post('tWahCode'),
            'FNLngID'   => $this->session->userdata("tLangEdit")
        ];

        $aResult        = $this->mConnectionSetting->FSaMCCGetDataDown($aData);
        $aDataEdit  = [
            'aResult'    => $aResult,
            'aAlwEvent'  => FCNaHCheckAlwFunc('ConnectionSetting/0/0')
        ];

        $this->load->view('interface/connectionsetting/wConnectionsettingAdd',$aDataEdit);

    }


    //Functionality : Event Edit settingWahouse
    //Parameters : Ajax jConnectionSetting()
    //Creator : 15/05/2020 saharat(Golf)
    //Last Modified : -
    //Return : Status Edit Event
    //Return Type : View
    public function FSxCCCSWahouseEventEdit(){
        try{
            if ($this->input->post('ocbStatusPdtOnline')=="on") {
              $tStatusPdtOnline = "1";
            }else {
              $tStatusPdtOnline = NULL;
            }
            $aDataMaster        = [
                'FTAgnCode'         => $this->input->post('oetCssAgnCode'),
                'FTBchCode'         => $this->input->post('oetCssBchCode'),
                'FTShpCode'         => $this->input->post('oetCssShpCode'),
                'FTWahCode'         => $this->input->post('oetCssWahCode'),
                'FTWahRefNo'        => $this->input->post('oetCssWahRefNo'),
                'FTWahStaOnline'    => $tStatusPdtOnline,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ];

                $this->db->trans_begin();
                $aStaEventMaster  = $this->mConnectionSetting->FSaMCSSAddUpdateMaster($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }

            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Delete Siggle
	//Parameters : From Ajax File Userlogin
	//Creator : 04/07/2020 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSaCCCSDeleteEvent(){

       $tAgnCode  = $this->input->post('tAgnCode');
       $tBchCode  = $this->input->post('tBchCode');
       $tShpCode  = $this->input->post('tShpCode');
       $tWahCode  = $this->input->post('tWahCode');


        $aDataDel  = array(
            'FTAgnCode'   => $tAgnCode,
            'FTBchCode'   => $tBchCode,
            'FTShpCode'   => $tShpCode,
            'FTWahCode'   => $tWahCode
        );

         $aResult       =  $this->mConnectionSetting->FSnMConnSetDel($aDataDel);
         $nNumRowRsnLoc  = $this->mConnectionSetting->FSnMLOCGetAllNumRow();

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


    public function FSaCCCSCusDeleteEvent(){


       $tBchCode  = $this->input->post('tBchCode');
       $tCbrSoldTo  = $this->input->post('tCbrSoldTo');

        $aDataDel  = array(
            'FTCbrSoldTo'   => $tCbrSoldTo,
            'FTBchCode'   => $tBchCode,
        );

         $aResult       =  $this->mConnectionSetting->FSnMCusSetDel($aDataDel);

         if($nNumRowRsnLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }

    }
    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaCCCSDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelete    = array(
                'aDataAgnCode'  => $this->input->post('paDataAgnCode'),
                'aDataBchCode'  => $this->input->post('paDataBchCode'),
                'aDataShphCode'  => $this->input->post('paDataShphCode'),
                'aDataWahCode'  => $this->input->post('paDataWahCode'),
            );

            $tResult    = $this->mConnectionSetting->FSaMConnDeleteMultiple($aDataDelete);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Pos Ads Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Pos Ads Multiple'
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

    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaCCCSCusDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelete    = array(
                'aDataCusCode'  => $this->input->post('paDataCusCode'),
                'aDataBchCode'  => $this->input->post('paDataBchCode')
            );

            $tResult    = $this->mConnectionSetting->FSaMCusDeleteMultiple($aDataDelete);

            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Pos Ads Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Pos Ads Multiple'
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
?>
