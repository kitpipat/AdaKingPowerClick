<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCourierlogin extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('courier/courierman/mCourierMan');
        $this->load->model('courier/courierlogin/mCourierlogin');
   
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File CourierLogin
	//Creator : 04/07/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCCourierloginMainPage(){

        $nPageShpCallBack   = $this->input->post('nPageShpCallBack');
        $vBtnSaveGpShp      = FCNaHBtnSaveActiveHTML('courierMan/0/0');
        $aAlwEventCURL      = FCNaHCheckAlwFunc('courierMan/0/0');
        
        // Get CryCode
        $tCryCode = $this->input->post('tCryCode');
        // Get CryManCode
        $tCryManCardID = $this->input->post('tCryManCardID');
        
        $aCryManSetAuthen = array('tCryCode'=>$tCryCode,
                                  'tCryManCardID'=>$tCryManCardID);
     
        $this->load->view('courier/courierlogin/wCourierloginMain',array(
            'nPageShpCallBack'      => $nPageShpCallBack,
            'vBtnSaveGpShp'         => $vBtnSaveGpShp,
            'aAlwEventCURL'         => $aAlwEventCURL,
            'aCryManSetAuthen'      => $aCryManSetAuthen
        ));
    }

    //Functionality : List Data 
	//Parameters : From Ajax File CourierLogin
	//Creator : 04/07/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCCURLogDataList(){
        $tCryLogCode            = $this->input->post('tCryLogCode');
        $tCryLogCryManCardID    = $this->input->post('tCryLogCryManCardID');
        $nPage                  = $this->input->post('nPageCurrent');
        $tSearchAll             = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventCURL   = FCNaHCheckAlwFunc('shop/0/0');

        $aData  = array(
            'FTCryCode'     => $tCryLogCode,
            'FTManCardID'   => $tCryLogCryManCardID,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );


        $aResList   = $this->mCourierlogin->FSaMCURLDataList($aData);
        $aGenTable  = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventCURL'     => $aAlwEventCURL,
            'FTCryCode'         => $tCryLogCode,
            'FTManCardID'       => $tCryLogCryManCardID,
        );

        //Return Data View
        $this->load->view('courier/courierlogin/wCourierloginDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add Courierlogin 
    //Parameters : 
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCCURlogPageAdd(){
        
        $dGetDataNow    = date('Y-m-d');
		$dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $nPageShpCallBack               = $this->input->post('nPageShpCallBack');
        $vBtnSaveCourierManlogin        = FCNaHBtnSaveActiveHTML('courierMan/0/0');
        $aAlwEventCURL                  = FCNaHCheckAlwFunc('courierMan/0/0');

        // รหัสบริษัทส่งของ
        $tCryCode = $this->input->get('tCryCode');

        // รหัสพนักงานส่งของ
        $tCryManCardID = $this->input->get('tCryManCardID');
        
        $aCryManInfo = array(
            'tCryCode' => $tCryCode,
            'tCryManCardID' => $tCryManCardID
        );

    
        $aDataAdd = array(
            'aResult'                     => array('rtCode'=>'99'),
            'nPageShpCallBack'            => $nPageShpCallBack,
            'vBtnSaveCourierManlogin'     => $vBtnSaveCourierManlogin,
            'aAlwEventCURL'               => $aAlwEventCURL,
            'dGetDataNow'		          => $dGetDataNow,
            'dGetDataFuture'	          => $dGetDataFuture,
            'aCryManInfo'                 => $aCryManInfo
        );

        $this->load->view('courier/courierlogin/wCourierloginAdd',$aDataAdd);
    }

    //Functionality :  Load Page Edit Courierlogin 
    //Parameters : 
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCURlogPageEdit(){

        $dGetDataNow    = date('Y-m-d');
		$dGetDataFuture = date('Y-m-d', strtotime('+1 year'));

        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aAlwEventCURL        = FCNaHCheckAlwFunc('shop/0/0');
        
        $aData = array( 
            'FTCryCode'     => $this->input->post('tCryCode'),
            'FTManCardID'   => $this->input->post('tCryManCardID'),  
            'FTManLogin'    => $this->input->post('tManlogin'),
            'FNLngID'       => $nLangEdit
        );


        $aResult        = $this->mCourierlogin->FSaMCURLCheckID($aData);

        // รหัสบริษัทส่งของ
        $tCryCode = $this->input->post('tCryCode');
        // รหัสพนักงานส่งของ
        $tCryManCardID = $this->input->post('tCryManCardID');
    
        $aCryManInfo = array(
            'tCryCode'      => $tCryCode,
            'tCryManCardID' => $tCryManCardID
        );

        $aDataEdit = array(
            'aResult'           => $aResult,
            'aAlwEventCURL'     => $aAlwEventCURL,
            'dGetDataNow'		=> $dGetDataNow,
            'dGetDataFuture'	=> $dGetDataFuture,
            'aCryManInfo'       => $aCryManInfo
        );

        $this->load->view('courier/courierlogin/wCourierloginAdd',$aDataEdit);
    }

    //Functionality : Function Add Courierlogin
    //Parameters : From Ajax File CourierLogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCURlogAddEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $tFTManLogin    = "";
            $tPassWord      = "";
           
            $tFTManLogin    = $this->input->post('oetidCurlogin');
            $tPassWord      = $this->input->post('oetCurloginPasswordOld');

    
            $aDataMaster    = array(
                'FTCryCode'         => $this->input->post('ohdCryLogCode'),
                'FTManCardID'       => $this->input->post('ohdCryLogCryManCardID'), 
                'FTManLogType'      => $this->input->post('ocmlogintype'),
                'FDManPwdStart'     => $this->input->post('oetCurlogStart')." ".date('H:i:s'),
                'FDManPwdExpired'   => $this->input->post('oetCurlogStop')." ".date('H:i:s'), 
                'FTManLogin'        => $tFTManLogin, 
                'FTManLoginPwd'     => $tPassWord, 
                'FTManRmk'          => $this->input->post('oetCurlogRemark'),
                'FTManStaActive'    => (!empty($this->input->post('ocbCurlogStaUse')))? '1':'2',
            );

            $oCountDup  = $this->mCourierlogin->FSoMCURLCheckDuplicate($aDataMaster['FTManLogin']);
            
            if($oCountDup==false){
                $this->db->trans_begin();
                $aStaRsnMaster  = $this->mCourierlogin->FSaMCURLAddUpdateMaster($aDataMaster);
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
                        'tCodeReturn'	=> $aDataMaster['FTManLogin'],
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

    //Functionality : Function Add Courierlogin
    //Parameters : From Ajax File CourierLogin
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCCURlogEditEvent(){
        try{
            date_default_timezone_set("Asia/Bangkok");
            $tFTManLogin    = "";
            $tPassWord      = "";
            $tLogType       = "";


            $tTimeStart     = $this->input->post('oetCurtimestart');
            $tTimeExpire     = $this->input->post('oetCurtimeexpire');

            if($this->input->post('ohdTypeAddloginType')==0){
                $tLogType   = $this->input->post('ocmlogintype');
            }else{
                $tLogType   = $this->input->post('ohdTypeAddloginTypeVal');
            }
            
            $tFTManLogin  = $this->input->post('oetidCurlogin');
            $tPassWord    = $this->input->post('oetCurloginPasswordOld');
           
            $aDataMaster    = array(
                'FTCryCode'         => $this->input->post('ohdCryLogCode'),
                'FTManCardID'       => $this->input->post('ohdCryLogCryManCardID'), 
                'FTManLogType'      => $tLogType,
                'FDManPwdStart'     => $this->input->post('oetCurlogStart')." ".$tTimeStart,
                'FDManPwdExpired'   => $this->input->post('oetCurlogStop')." ".$tTimeExpire,  
                'FTManLogin'        => $tFTManLogin, 
                'FTManLoginPwd'     => $tPassWord, 
                'FTManRmk'          => $this->input->post('oetCurlogRemark'),
                'FTManStaActive'    => (!empty($this->input->post('ocbCurlogStaUse')))? '1':'2',
            );

            $this->db->trans_begin();
            $aStaRsnMaster  = $this->mCourierlogin->FSaMCURLAddUpdateMaster($aDataMaster);
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
                    'tCodeReturn'	=> $aDataMaster['FTManLogin'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Courierlogin
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCCURlogDeleteEvent(){

        $tIDCode = $this->input->post('tManloginCode');
        $aDataMaster = array(
            'FTManLogin' => $tIDCode
        );

        $aResDel        = $this->mCourierlogin->FSnMCURLDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mCourierlogin->FSnMLOCGetAllNumRow();
        
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


    //Functionality : Delete Pos Ads Multiple
    //Parameters : Ajax jReason()
    //Creator : 26/07/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCCURLogDelMultipleEvent(){
        try{
            $this->db->trans_begin();
            
            $aDataDelete    = array(
                'aDataCryCode'  => $this->input->post('paDataCryCode'),
                'aDataCardId'   => $this->input->post('paDataCardId'),
                'aDataLogType'  => $this->input->post('paDataLogType'),
                'aDataPwStart'  => $this->input->post('paDataPwStart')
            );
            
            $tResult = $this->mCourierlogin->FSaMCURLDeleteMultiple($aDataDelete);
               
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aDataReturn     = array(
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


    //Functionality : CheckDuplicate
    //Parameters : Ajax jCourierloginMain()
    //Creator : 28/09/2019 Saharat(Golf)
    //Return : -
    //Return Type :- 
    function FSaMCURCheckDuplicate(){
        $tLoginCode = $this->input->post('ptloginCode'); 
        $aData = [
            'FTManLogin'   => $tLoginCode
        ];
        $aResult  = $this->mCourierlogin->FSoMCURLCheckDuplicateTel($aData);
        echo json_encode($aResult);
    }
    
}