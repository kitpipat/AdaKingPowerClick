<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCustomerDebitCard extends MX_Controller {
    public function __construct() {
        parent::__construct ();
        $this->load->model('customer/customerDebitCard/mCustomerDebitCard');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Functionality : List Data 
	//Parameters : From Ajax File CustomerDebitCard
	//Creator : 19/10/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
    //Return Type : View
    public function FSvCCstDebitDataList(){

        $tCstCode       = $this->input->post('tCstCode');
        $tSearchAll     = $this->input->post('tSearchAll');
        $nPage          = $this->input->post('nPageCurrent');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveGpCstDebitCard    = FCNaHBtnSaveActiveHTML('customer/0/0');
        $aAlwEventCstDebitCard     = FCNaHCheckAlwFunc('customer/0/0');

        $aCustomerDebitCard = array(
            'tCstCode' =>  $tCstCode
        );

        $aData = array(
            'FTCrdRefCode' =>  $tCstCode,
            'nPage'        => $nPage,
            'nRow'         => 10,
            'FNLngID'      => $nLangEdit,
            'tSearchAll'   => $tSearchAll,
        );

        $aResList    = $this->mCustomerDebitCard->FSaMCstDebitCardDataList($aData);

        $aGenTable  = array(
            'aDataList'                 => $aResList,
            'nPage'     	            => $nPage,
            'FTCrdRefCode'              => $tCstCode,
            'aAlwEventCstDebitCard'     => $aAlwEventCstDebitCard,
            'vBtnSaveGpCstDebitCard'    => $vBtnSaveGpCstDebitCard,
            'aCustomerDebitCard'        => $aCustomerDebitCard
        );

        //Return Data View
       $this->load->view('customer/customerDebitCard/wCustomerDebitCardDataTable',$aGenTable);

    }

    //Functionality :  Load Page Add CustomerDebitCard 
    //Parameters : 
    //Creator : 19/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCCstDebitPageAdd(){

        $tCstCode  =   $this->input->post('tCstCode');
            
        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveGpCstDebitCard    = FCNaHBtnSaveActiveHTML('customer/0/0');
        $aAlwEventCstDebitCard     = FCNaHCheckAlwFunc('customer/0/0');

        $aCustomerDebitCard     = array(
            'tCstCode' => $tCstCode,
        );

         $aDataAdd   = array(
            'aResult'        => array('rtCode'=>'99'),
            'vBtnSaveGpCstDebitCard'  => $vBtnSaveGpCstDebitCard,
            'aAlwEventCstDebitCard'   => $aAlwEventCstDebitCard,
            'aCustomerDebitCard'      => $aCustomerDebitCard,
            'dGetDataNow'             => $dGetDataNow,
            'dGetDataFuture'          => $dGetDataFuture
        );

        $this->load->view('customer/customerDebitCard/wCustomerDebitCardAdd',$aDataAdd);
    }

    //Functionality :  Load Page Edit CustomerDebitCard 
    //Parameters : 
    //Creator : 12/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCstDebitPageEdit(){

        $tCstCode        = $this->input->post('tCstCode');
        $nLangEdit       = $this->session->userdata("tLangEdit");
        $nLangResort     = $this->session->userdata("tLangID");
        $dGetDataNow     = date('Y-m-d');
        $dGetDataFuture  = date('Y-m-d', strtotime('+1 year'));
        $vBtnSaveGpCstDebitCard    = FCNaHBtnSaveActiveHTML('customer/0/0');
        $aAlwEventCstDebitCard     = FCNaHCheckAlwFunc('customer/0/0');

        $aData   = array(
            'FTCrdRefCode'  => $tCstCode,
            'FNLngID'       => $nLangEdit,
        );

        // TFNMCardMan
        $aResult    = $this->mCustomerDebitCard->FSaMCstDebitCardCheckID($aData);

        $aCustomerDebitCard     = array(
            'tCstCode' => $tCstCode,
        );

        $aDataEdit   = array(
            'aResult'        => array('rtCode'=>'99'),
            'vBtnSaveGpCstDebitCard'  => $vBtnSaveGpCstDebitCard,
            'aAlwEventCstDebitCard'   => $aAlwEventCstDebitCard,
            'aCustomerDebitCard'      => $aCustomerDebitCard,
            'dGetDataNow'             => $dGetDataNow,
            'dGetDataFuture'          => $dGetDataFuture
        );

        $this->load->view('customer/customerDebitCard/wCustomerDebitCardAdd',$aDataEdit);
    }


     //Functionality : Function Add CustomerDebitCard
    //Parameters : From Ajax File CustomerDebitCard
    //Creator : 20/10/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCstDebitAddEvent(){
        try{
          $tCstCode  = $this->input->post('ohdCstCode');
          $aDataAdd  = array(
              'FTCrdRefCode'    => $this->input->post('ohdCstCode'),
              'FTCrdCode'       => $this->input->post('oetCstCrdCode'),
              'FTCrdTable'      => 'TCNMCst'
          );

          $this->db->trans_begin();

          $aChkCrdCode  = $this->mCustomerDebitCard->FSaMCstCheckCrdCode($aDataAdd); 

        if($aChkCrdCode['rtCode'] == 1){
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add Event"
            );
        }else{
            $aResult = $this->mCustomerDebitCard->FSaMCSTAddUpdateMaster($aDataAdd);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'     => '900',
                    'tStaMessg'     => "Unsucess",
                    'aResult'       => $aResult
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success',
                    'aResult'       => $aResult
                );
            }
        }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete CustomerDebitCard
    //Parameters : Ajax jReason()
    //Creator : 18/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCstDebitDeleteEvent(){
        $tCrdCode   = $this->input->post('tCrdCode');
        $tRefCode   = $this->input->post('tRefCode');

        $aDataMaster = array(
            'FTCrdCode'      => $tCrdCode,
            'FTCrdRefCode'   => $tRefCode
        );

        $aResDel        = $this->mCustomerDebitCard->FSnMCstDebitCard($aDataMaster);
        // $nNumRowRsnLoc  = $this->mCustomerDebitCard->FSnMCstDebitCrdGetAllNumRow();


        // if($nNumRowRsnLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'aResult'       => $aResDel,
                // 'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        // }else{
        //     echo "database error";
        // }

    }

   

}