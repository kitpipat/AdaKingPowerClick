<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cUserlogin extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('authen/user/mUser');
        $this->load->model('authen/userlogin/mUserlogin');
   
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File Userlogin
	//Creator : 18/08/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCUserloginMainPage(){

        $vBtnSaveGpUsrlogin    = FCNaHBtnSaveActiveHTML('user/0/0');
        $aAlwEventUsrlogin     = FCNaHCheckAlwFunc('user/0/0');

        // Get UsrCode
        $tUsrCode = $this->input->post('tUsrCode');

        $aUsrCodeSetAuthen = array(
            'tUsrCode'  =>  $tUsrCode
        );

        $this->load->view('authen/userlogin/wUserloginMain',array(
            'vBtnSaveGpUsrlogin'     => $vBtnSaveGpUsrlogin,
            'aAlwEventUsrlogin'      => $aAlwEventUsrlogin,
            'aUsrCodeSetAuthen'      => $aUsrCodeSetAuthen
        ));
    }

    //Functionality : List Data 
	//Parameters : From Ajax File Userlogin
	//Creator : 04/07/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCUserLogDataList(){
        $tUsrLogCode            = $this->input->post('tUsrLogCode');
        $nPage                  = $this->input->post('nPageCurrent');
        $tSearchAll             = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventUsrlogin   = FCNaHCheckAlwFunc('userlogin/0/0');

        $aData  = array(
            'FTUsrCode'     => $tUsrLogCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );

        $aResList   = $this->mUserlogin->FSaMUSRLDataList($aData);

        $aGenTable  = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventUsrlogin' => $aAlwEventUsrlogin,
            'FTUsrCode'         => $tUsrLogCode,
        );

        
        //Return Data View
        $this->load->view('authen/userlogin/wUserloginDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add Userlogin 
    //Parameters : 
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function  FSvCUserlogPageAdd(){

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
        
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $vBtnSaveUsrlogin   = FCNaHBtnSaveActiveHTML('userlogin/0/0');
        $aAlwEventUsrlogin      = FCNaHCheckAlwFunc('userlogin/0/0');

        //รหัสผู้ใช้
        $tUsrCode = $this->input->post('tUsrCode');

        $aUsrCodeSetAuthen = array(
            'tUsrCode' => $tUsrCode,
        );

        $aDataAdd = array(
            'aResult'            => array('rtCode'=>'99'),
            'vBtnSaveUsrlogin'   => $vBtnSaveUsrlogin,
            'aAlwEventUsrlogin'  => $aAlwEventUsrlogin,
            'dGetDataNow'		 => $dGetDataNow,
            'dGetDataFuture'	 => $dGetDataFuture,
            'aUsrCodeSetAuthen'  => $aUsrCodeSetAuthen
        );

        $this->load->view('authen/userlogin/wUserloginAdd',$aDataAdd);
    }


    //Functionality :  Load Page Edit Courierlogin 
    //Parameters : 
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCUserlogPageEdit(){

        $dGetDataNow    = date('Y-m-d');
        $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aAlwEventUSRL  = FCNaHCheckAlwFunc('userlogin/0/0');

        $aData  = array(
           'FTUsrCode'     => $this->input->post('tUsrLogCode'),
           'FTUsrLogin'    => $this->input->post('tUsrLogin'),
           'FNLngID'       => $nLangEdit
        );

        $aResult    = $this->mUserlogin->FSaMUSRLCheckID($aData);

        $aUsrCodeSetAuthen = array(
            'tUsrCode'    => $this->input->post('tUsrLogCode'),
        );
      
        $aDataEdit = array(
            'aResult'           => $aResult,
            'aAlwEventUSRL'     => $aAlwEventUSRL,
            'dGetDataNow'       => $dGetDataNow,
            'dGetDataFuture'    => $dGetDataFuture,
            'aUsrCodeSetAuthen' => $aUsrCodeSetAuthen
        );

        $this->load->view('authen/userlogin/wUserloginAdd',$aDataEdit);

    }
   

    //Functionality : Function Add Userlogin
    //Parameters : From Ajax File Userlogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaCUserlogAddEvent(){
        try{    
            date_default_timezone_set("Asia/Bangkok");
            $tUsrLogin     = "";
            $tUsrLoginPwd  = "";

            $tUsrLogin      = $this->input->post('oetidUsrlogin');
            $tUsrLoginPwd   = $this->input->post('oetUsrloginPasswordOld');
            
            $aDataMaster    = array(
                'FTUsrCode'         => $this->input->post('ohdUsrLogCode'),
                'FTUsrLogType'      => $this->input->post('ocmlogintype'), 
                'FDUsrPwdStartOld'  => $this->input->post('oetUsrlogStartOld')." ".date('H:i:s'),
                'FDUsrPwdStart'     => $this->input->post('oetUsrlogStart')." ".date('H:i:s'),
                'FDUsrPwdExpired'   => $this->input->post('oetUsrlogStop')." ".date('H:i:s'),
                'FTUsrLogin'        => $tUsrLogin,
                'FTUsrLoginPwd'     => $tUsrLoginPwd,
                'FTUsrRmk'          => $this->input->post('oetUsrlogRemark'),
                'FTUsrStaActive'    => $this->input->post('ocmUsrlogStaUse'), //(!empty($this->input->post('ocbUsrlogStaUse')))? '1':'2'
            );

            // ไป update ที่ตาราง TCNMUser
            $aDataUpdateLastUp = array(
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            );

            $oCountDup  = $this->mUserlogin->FSoMUSRLCheckDuplicate($aDataMaster['FTUsrLogin'],$this->input->post('ocmlogintype'));

            if($oCountDup==false){
                $this->db->trans_begin();
                $this->mUserlogin->FSaMUSRLAddUpdateMaster($aDataMaster,'ADD');

                // ไป update ที่ตาราง TCNMUser
                $this->mUserlogin->FSaMUSRLAddUpdateLastUp($aDataUpdateLastUp, $aDataMaster);
           
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
                        'tCodeReturn'	=> $aDataMaster['FTUsrLogin'],
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

    
    //Functionality : Function Add Userlogin
    //Parameters : From Ajax File Userlogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCUserlogEditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $tUsrLogin      = "";
            $tUsrLoginPwd   = "";
            $tLogType       = "";
            $oetidUsrlogPw  = $this->input->post('oetidUsrlogPw');
            $tTimeStart     = $this->input->post('oetUsrtimestart');
            $tTimeExpire    = $this->input->post('oetUsrtimeExpire');
            $tTimeStartOld  = $this->input->post('oetUsrtimestartOld');

            if($tTimeStart == "" || $tTimeStart == null ){
                $tTimeStart     = date('H:i:s');
                $tTimeStartOld  = date('H:i:s');
            }else{
                $tTimeStart = $tTimeStart;
                $tTimeStartOld = $tTimeStartOld;
            }
            
            if($this->input->post('ohdTypeAddloginType')==0){
                $tLogType = $this->input->post('ocmlogintype');
            }else{
                $tLogType = $this->input->post('ohdTypeAddloginTypeVal');
            }

            $tUsrLogin      = $this->input->post('oetidUsrlogin');
            $tUsrLoginPwd   = $this->input->post('oetUsrloginPasswordOld');

            $aDataMaster    = array(
                'FTUsrCode'         => $this->input->post('ohdUsrLogCode'),
                'FTUsrLogType'      => $tLogType, 
                'FDUsrPwdStart'     => $this->input->post('oetUsrlogStart')." ".$tTimeStart,
                'FDUsrPwdStartOld'  => $this->input->post('oetUsrlogStartOld')." ".$tTimeStartOld,
                'FDUsrPwdExpired'   => $this->input->post('oetUsrlogStop')." ".$tTimeStart,
                'FTUsrLogin'        => $tUsrLogin,
                'FTUsrLoginPwd'     => $tUsrLoginPwd,
                'FTUsrRmk'          => $this->input->post('oetUsrlogRemark'),
                'FTUsrStaActive'    => $this->input->post('ocmUsrlogStaUse'), //(!empty($this->input->post('ocbUsrlogStaUse')))? '1':'2'
            );

            // ไป update ที่ตาราง TCNMUser
            $aDataUpdateLastUp = array(
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            );
    
            $this->db->trans_begin();
            $this->mUserlogin->FSaMUSRLAddUpdateMaster($aDataMaster,'EDIT');
            $this->mUserlogin->FSaMUSRLAddUpdateLastUp($aDataUpdateLastUp, $aDataMaster);

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
                    'tCodeReturn'	=> $aDataMaster['FTUsrLogin'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Event Delete Userlogin
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCUserlogDeleteEvent(){

        $tIDCode        = $this->input->post('tUsrloginCode');
        $tTypeUsrLogin  = $this->input->post('tTypeUsrLogin');

        $aDataMaster = array(
            'FTUsrLogin'    => $tIDCode,
            'FTUsrLogType'  => $tTypeUsrLogin
        );

        $aResDel        = $this->mUserlogin->FSnMUSRLDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mUserlogin->FSnMLOCGetAllNumRow();

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

    //Functionality : Delete Userlogin Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCUserlogDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelete    = array(
                'aDataUsrLogin' => $this->input->post('paDataUsrLogin'),
                'aDataUsrCode'  => $this->input->post('paDataUsrCode'),
                'aDataLogType'  => $this->input->post('paDataLogType'),
                'aDataPwStart'  => $this->input->post('paDataPwStart'),
            );

            $this->mUserlogin->FSaMUSRLDeleteMultiple($aDataDelete);

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