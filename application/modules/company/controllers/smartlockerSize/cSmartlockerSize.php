<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSmartlockerSize extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/shop/mShop');
        $this->load->model('company/smartlockerSize/mSmartlockerSize');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File jSmartlockerSizeMain
	//Creator : 04/07/2019 Saharat(Golf)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCSMSmartlockerSizeMainPage(){
        $nPageShpCallBack       = $this->input->post('nPageShpCallBack');
        $vBtnSaveGpShp          = FCNaHBtnSaveActiveHTML('shop/0/0/LOCKER');
        $aAlwEventShopGpByShp   = FCNaHCheckAlwFunc('shop/0/0/LOCKER');
     
        $this->load->view('company/smartlockerSize/wSmartlockerSizeMain',array(
            'nPageShpCallBack'      => $nPageShpCallBack,
            'vBtnSaveGpShp'         => $vBtnSaveGpShp,
            'aAlwEventSMS'          => $aAlwEventShopGpByShp
        ));
    }

    //Functionality : List Data 
	//Parameters : From Ajax File jSmartlockerSizeMain
	//Creator : 04/07/2019 Saharat(Golf)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCMSDataList(){
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventSMS   = FCNaHCheckAlwFunc('shop/0/0/LOCKER');
        $aData  = array(

            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $aResList           = $this->mSmartlockerSize->FSaMSMSDataList($aData);
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventSMS'      => $aAlwEventSMS
        );

        //Return Data View
        $this->load->view('company/smartlockerSize/wSmartlockerSizeDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add ShopSize 
    //Parameters : 
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCSMSPageAdd(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TRTMShopSize_L');

        $nPageShpCallBack                = $this->input->post('nPageShpCallBack');
        $vBtnSaveSmartlockerSize         = FCNaHBtnSaveActiveHTML('shop/0/0/LOCKER');
        $aAlwEventSmartlockerSize        = FCNaHCheckAlwFunc('shop/0/0/LOCKER');

    
        $aDataAdd = array(
            'aResult'                      => array('rtCode'=>'99'),
            'nPageShpCallBack'            => $nPageShpCallBack,
            'vBtnSaveSmartlockerSize'     => $vBtnSaveSmartlockerSize,
            'aAlwEventSmartlockerSize'    => $aAlwEventSmartlockerSize,

        );

        $this->load->view('company/smartlockerSize/wSmartlockerSizeAdd',$aDataAdd);
    }

    //Functionality :  Load Page Edit ShopSize 
    //Parameters : 
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCSMSPageEdit(){
        $nLangEdit  = $this->session->userdata("tLangEdit");
        $aAlwEventSmartlockerSize   = FCNaHCheckAlwFunc('shop/0/0/LOCKER');
        $aData = array( 
            'FTPzeCode' => $this->input->post('tPzeCode'),
            'FNLngID' => $nLangEdit
        );
        $aResult        = $this->mSmartlockerSize->FSaMSMSCheckID($aData);
        if(isset($aResult['raItems']['FTImgObj']) && !empty($aResult['raItems']['FTImgObj'])){
            $tImgObj        = $aResult['raItems']['FTImgObj'];
            $aImgObj        = explode("application/modules/",$tImgObj);
            $aImgObjName    = explode("/",$tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName		= end($aImgObjName);
        }else{
            $tImgObjAll     = "";
            $tImgName		= "";
        }
        $aDataEdit = array(
            'tImgObjAll'    => $tImgObjAll,
            'tImgName'      => $tImgName,
            'aResult'       => $aResult,
            'aAlwEventSmartlockerSize'  => $aAlwEventSmartlockerSize,
        );
        $this->load->view('company/smartlockerSize/wSmartlockerSizeAdd',$aDataEdit);
    }

    //Functionality : Function Add ShopSize
    //Parameters : From Ajax File jSmartlockerSizeMain
    //Creator : 04/07/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCSMSAddEvent(){
        try{
            // **** Input Image Data
            $tImgInputSmartLockerSize       = $this->input->post('oetImgInputSmartLockerSize');
            $tImgInputSmartLockerSizeOld    = $this->input->post('oetImgInputSmartLockerSizeOld');
            // **** Input Image Data

            //Set DateTime Bangkok
		    date_default_timezone_set("Asia/Bangkok");
            $aDataMaster    = array(
                'tIsAutoGenCode' => $this->input->post('ocbShopSizeAutoGenCode'),
                'FTImgObj'       => $this->input->post('oetImgInputMain'),
                'FTPzeCode'      => $this->input->post('oetPzeCode'),
                'FTSizName'      => $this->input->post('oetSizName'),
                'FCPzeDim'       => $this->input->post('oetPzeDim'),
                'FCPzeHigh'      => $this->input->post('oetPzeHigh'),
                'FCPzeWide'      => $this->input->post('oetPzeWide'),
                'FTSizRemark'    => $this->input->post('oetSizRemark'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );
            // Check Auto Gen ShopSize Code?
            if($aDataMaster['tIsAutoGenCode'] == '1'){ 
                // Auto Gen ShopSize Code
                $aStoreParam = array(
                    "tTblName"    => 'TRTMShopSize',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTPzeCode']   = $aAutogen[0]["FTXxhDocNo"];
                
                // $aGenCode = FCNaHGenCodeV5('TRTMShopSize','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTPzeCode'] = $aGenCode['rtPzeCode'];
                // }
            }
            $oCountDup  = $this->mSmartlockerSize->FSoMSMSCheckDuplicate($aDataMaster['FTPzeCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                    $aStaSmsMaster  = $this->mSmartlockerSize->FSaMSMSAddUpdateMaster($aDataMaster);
                    $aStaSmsLang    = $this->mSmartlockerSize->FSaMSMSAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Insert"
                    );
                }else{
                    $this->db->trans_commit();
                    // Check Image New Compare Image Old
                    if($tImgInputSmartLockerSize != $tImgInputSmartLockerSizeOld){
                        $aImageData = [
                            'tModuleName'       => 'company',
                            'tImgFolder'        => 'smartlockerSize',
                            'tImgRefID'         => $aDataMaster['FTPzeCode'],
                            'tImgObj'           => $tImgInputSmartLockerSize,
                            'tImgTable'         => 'TRTMShopSize',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        ];
                        FCNnHAddImgObj($aImageData);
                    }
                    $aReturn = array(
                        'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTPzeCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Update'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Status Dup"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Add ShopSize
    //Parameters : From Ajax File jSmartlockerSizeMain
    //Creator : 04/07/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCSMSEditEvent(){
        try{
            // **** Input Image Data
            $tImgInputSmartLockerSize       = $this->input->post('oetImgInputSmartLockerSize');
            $tImgInputSmartLockerSizeOld    = $this->input->post('oetImgInputSmartLockerSizeOld');
            // **** Input Image Data

            //Set DateTime Bangkok
		    date_default_timezone_set("Asia/Bangkok");
            $aDataMaster    = array(
                'FTImgObj'       => $this->input->post('oetImgInputMain'),
                'FTPzeCode'      => $this->input->post('oetPzeCode'),
                'FTSizName'      => $this->input->post('oetSizName'),
                'FCPzeDim'       => $this->input->post('oetPzeDim'),
                'FCPzeHigh'      => $this->input->post('oetPzeHigh'),
                'FCPzeWide'      => $this->input->post('oetPzeWide'),
                'FTSizRemark'    => $this->input->post('oetSizRemark'),
                'FDLastUpdOn'    => date('Y-m-d H:i:s'),
                'FDCreateOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'    => $this->session->userdata('tSesUsername'),
                'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                'FNLngID'        => $this->session->userdata("tLangEdit")
            );
                $this->db->trans_begin();
                    $aStaSmsMaster  = $this->mSmartlockerSize->FSaMSMSAddUpdateMaster($aDataMaster);
                    $aStaSmsLang    = $this->mSmartlockerSize->FSaMSMSAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Insert"
                    );
                }else{
                    $this->db->trans_commit();
                    // Check Image New Compare Image Old
                    if($tImgInputSmartLockerSize != $tImgInputSmartLockerSizeOld){
                        $aImageData = [
                            'tModuleName'       => 'company',
                            'tImgFolder'        => 'smartlockerSize',
                            'tImgRefID'         => $aDataMaster['FTPzeCode'],
                            'tImgObj'           => $tImgInputSmartLockerSize,
                            'tImgTable'         => 'TRTMShopSize',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        ];
                        FCNnHAddImgObj($aImageData);
                    }
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTPzeCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Update'
                    );
                }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete ShopSize
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCSMSDeleteEvent(){
        $tIDCode = $this->input->post('tPzeCode');
        $aDataMaster = array(
            'FTPzeCode' => $tIDCode
        );
        $aResDel        = $this->mSmartlockerSize->FSnMSMSDel($aDataMaster);
        $nNumRowSMSPUN  = $this->mSmartlockerSize->FSnMSMSGetAllNumRow();
        $aDeleteImage = array(
                'tModuleName'  => 'company',
                'tImgFolder'   => 'smartlockerSize',
                'tImgRefID'    => $tIDCode,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TRTMShopSize'
                );
        $nDelectImageInDB =  FSnHDelectImageInDB($aDeleteImage);
        if($nDelectImageInDB == 1 ){
            FSnHDeleteImageFiles($aDeleteImage);
        }
        if($nNumRowSMSPUN!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowSMSPUN' => $nNumRowSMSPUN
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

    
}