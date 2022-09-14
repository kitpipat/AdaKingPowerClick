<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCstlogin extends MX_Controller {
    public function __construct() {
        parent::__construct ();
        $this->load->model('customer/customerlogin/mCstlogin');
        $this->load->model('customer/customer/mCustomer');
    }


    //Functionality : Function Call Page Main
	//Parameters : From Ajax File Userlogin
	//Creator : 15/19/2020 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
    //Return Type : View
    public function FSvCCSTloginMainPage(){

        $vBtnSaveGpCstlogin    = FCNaHBtnSaveActiveHTML('customer/0/0');
        $aAlwEventCstlogin     = FCNaHCheckAlwFunc('customer/0/0');
        
        $tCstCode   = $this->input->post('tCstCode');
        
        $this->load->view('customer/customer/tab/customerlogin/wCstloginMain',array(
            'vBtnSaveGpCstlogin' => $vBtnSaveGpCstlogin,
            'aAlwEventCstlogin'  => $aAlwEventCstlogin,
            'tCstCode'           => $tCstCode
        ));

    }

    //Functionality : List Data 
	//Parameters : From Ajax File Cardlogin
	//Creator : 25/11/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCCSTloginDataList(){
        $tCstlogCode    = $this->input->post('tCstlogCode');
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventCstlogin   = FCNaHCheckAlwFunc('customer/0/0');

        $aData = array(
            'FTCstCode'     => $tCstlogCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );

        $aResList    = $this->mCstlogin->FSaMCSTLOGDataList($aData);

        $aGenTable      = array(
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'FTCstCode'         =>  $tCstlogCode,
            'aAlwEventCstlogin' =>  $aAlwEventCstlogin,
        );

        //Return Data View
        $this->load->view('customer/customer/tab/customerlogin/wCstloginDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add Cstlogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCCSTlogPageAdd(){

        $dGetDataNow     = date('Y-m-d');
        $dGetDataFuture  = date('Y-m-d', strtotime('+1 year'));

        $nLangResort     = $this->session->userdata("tLangID");
        $nLangEdit       = $this->session->userdata("tLangEdit");

        $vBtnSaveGpCstlogin    = FCNaHBtnSaveActiveHTML('customer/0/0');
        $aAlwEventCstlogin     = FCNaHCheckAlwFunc('customer/0/0');

        $tCstlogCode =   $this->input->post('tCstlogCode');

        $aCstCode   = array(
            'tCstlogCode'   => $tCstlogCode
        );

        $aDataAdd  = array(
            'aResult'   => array('rtCode'=>'99'),
            'vBtnSaveGpCstlogin' => $vBtnSaveGpCstlogin,
            'aAlwEventCstlogin'  => $aAlwEventCstlogin,
            'dGetDataNow'		 => $dGetDataNow,
            'dGetDataFuture'	 => $dGetDataFuture,
            'aCstCode'           => $aCstCode
        );

        $this->load->view('customer/customer/tab/customerlogin/wCstloginAdd',$aDataAdd);
    }


    //Functionality :  Load Page Edit Customerlogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCSTlogPageEdit(){

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aAlwEventCstlogin  = FCNaHCheckAlwFunc('customer/0/0');


        $aData  = array(
            'FTCstCode'     =>  $this->input->post('tCstlogCode'),
            'FTCstLogin'    =>  $this->input->post('tCstLogin'),
            'FDCstPwdStart' => $this->input->post('tCstPwdStart'),
            'FNLngID'       =>  $nLangEdit
        );

        $aResult    = $this->mCstlogin->FSaMCSTLCheckID($aData);

        $aCstCode   = array(
            'tCstlogCode'   => $this->input->post('tCstlogCode'),
        );

        $aDataEdit = array(
            'aResult'           => $aResult,  
            'aAlwEventCstlogin' => $aAlwEventCstlogin,
            'dGetDataNow'       => $dGetDataNow,
            'dGetDataFuture'    => $dGetDataFuture,
            'aCstCode'          => $aCstCode
        );

        $this->load->view('customer/customer/tab/customerlogin/wCstloginAdd',$aDataEdit);

    }

    //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCSTlogAddEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");

            $tCstLogin      = "";
            $tCstLoginPwd   = "";

            // Type : 0 ไม่ตรวจสอบ
            if($this->input->post('ocmlogintype') == 0){
                $tCstLogin  = $this->input->post('oetCardCode');
                $tCstRmk    = language('customer/customer/customer', 'tCstTypeCardCode');
            }else if($this->input->post('ocmlogintype') == 5){
                $tCstLogin  = $this->input->post('oetFaceCode');
                $tCstRmk    = $this->input->post('oetCstlogRemark');
            }else{
                $tCstLogin  = $this->input->post('oetidCstlogin');
                $tCstRmk    = $this->input->post('oetCstlogRemark');
            }

            $tCstLoginPwd   =  $this->input->post('oetCstloginPasswordOld');

            $aDataMaster      = array(
                'FTCstCode'         => $this->input->post('ohdCstLogCode'),
                'FTCstLogType'      => $this->input->post('ocmlogintype'), 
                'FDCstPwdStartOld'  => $this->input->post('oetCstlogStartOld')." ".date('H:i:s'),
                'FDCstPwdStart'     => $this->input->post('oetCstlogStart')." ".date('H:i:s'),
                'FDCstPwdExpired'   => $this->input->post('oetCstlogStop')." ".date('H:i:s'),
                'FTCstLogin'        => $tCstLogin,
                'FTCstLoginPwd'     => $tCstLoginPwd,
                'FTCstRmk'          => $tCstRmk,
                'FTCstStaActive'    => $this->input->post('ocmCstlogStaUse'),  //(!empty($this->input->post('ocbCstlogStaUse')))? '1':'2',
            );

            // ไป update ที่ตาราง TCNMUser
            $aDataUpdateLastUp = array(
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            );

            $oCountDup  = $this->mCstlogin->FSoMCSTLCheckDuplicate($aDataMaster['FTCstLogin'], $aDataMaster['FTCstLogType'], $aDataMaster['FTCstCode'], $aDataMaster['FDCstPwdStart']);


            if($oCountDup==false){
                $this->db->trans_begin();
                $aStaMaster  = $this->mCstlogin->FSaMCSTLAddUpdateMaster($aDataMaster);

                //ไป update ที่ตาราง MCard
                $this->mCstlogin->FSaMCSTLAddUpdateLastUp($aDataUpdateLastUp, $aDataMaster);

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTCstLogin'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaCCSTlogEditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $tCstLogin     = "";
            $tCstLoginPwd  = "";
            $tCstLogType   = "";
            
            $tCstTimeStart      = $this->input->post('oetCsttimestart');
            $tCstTimeExpire     = $this->input->post('oetCsttimeExpire');
            $tTimeStartOld      =  $this->input->post('oetCsttimestartOld');



            if($tCstTimeStart == "" || $tCstTimeStart == null ){
                $tCatTimeStart = date('H:i:s');
                $tTimeStartOld = date('H:i:s');
            }else{
                $tCstTimeStart = $tCstTimeStart;
                $tTimeStartOld = $tTimeStartOld;
            }

            if($this->input->post('ohdTypeAddloginType')==0){
                $tCstLogType = $this->input->post('ocmlogintypeEdit');
            }else{
                $tCstLogType = $this->input->post('ohdTypeAddloginTypeVal');
            }


            $tCstLogin      = $this->input->post('oetidCstlogin');
            $tCstLoginPwd   = $this->input->post('oetCstloginPasswordOld');

            $aDataMaster  = array(
                'FTCstCode'         => $this->input->post('ohdCstLogCode'),
                'FTCstLogType'      => $tCstLogType, 
                'FDCstPwdStart'     => $this->input->post('oetCstlogStart')." ".$tCstTimeStart,
                'FDCstPwdExpired'   => $this->input->post('oetCstlogStop')." ".$tCstTimeStart,
                'FDCstPwdStartOld'  => $this->input->post('oetCstlogStartOld')." ".$tTimeStartOld,
                'FTCstLogin'        => $tCstLogin,
                'FTCstLoginPwd'     => $tCstLoginPwd,
                'FTCstRmk'          => $this->input->post('oetCstlogRemark'),
                'FTCstStaActive'    => $this->input->post('ocmCstlogStaUse'),  //(!empty($this->input->post('ocbCstlogStaUse')))? '1':'2',
            );

            // ไป update ที่ตาราง TCNMUser
            $aDataUpdateLastUp = array(
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            );
    
            $this->db->trans_begin();
            $aStaMaster  = $this->mCstlogin->FSaMCSTLAddUpdateMaster($aDataMaster);

           //ไป update ที่ตาราง MCard
           $this->mCstlogin->FSaMCSTLAddUpdateLastUp($aDataUpdateLastUp, $aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCstLogin'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            $Error;
        }
    }

    //Functionality : Event Delete Cardlogin
    //Parameters : Ajax jReason()
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCSTlogDeleteEvent(){

        $tCstCode   =  $this->input->post('tCstCode');
        $tPwdStart  =  $this->input->post('tPwdStart') ;
        $tCstloginCode  = $this->input->post('tCstloginCode');
     
        $aDataMaster = array(
            'FTCstLogin' => $tCstloginCode,
            'FTCstCode'  => $tCstCode,
            'FDCstPwdStart' => $tPwdStart
        );


        $aResDel     = $this->mCstlogin->FSnMCSTLDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mCstlogin->FSnMLOCGetAllNumRow();

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


    //Functionality : Delete Cardlogin Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 26/11/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCCSTlogDelMultipleEvent(){
        try{

            $aDataDelete    = array(
                'aDataCstCode'  => $this->input->post('paDataCstCode'),
                'aDataLogType'  => $this->input->post('paDataLogType'),
                'aDataPwStart'  => $this->input->post('paDataPwStart'),
            );

            $tResult    = $this->mCstlogin->FSaMCSTLDeleteMultiple($aDataDelete);

    
            if($this->db->trans_status() == FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Multiple'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete  Multiple'
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


