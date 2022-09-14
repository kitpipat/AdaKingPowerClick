<?php
    defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cConSettingGenaral extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('interface/connectionsetting/mConnSetGenaral');
    }
    
    //Functionality : List Data 
    //Parameters : From Ajax File ConSettingHGenaral
    //Creator : 15/05/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxSETMainPage(){
        $tStaApiTxnType = $this->input->post('tStaApiTxnType');
        if($tStaApiTxnType == '' || $tStaApiTxnType == null){$tStaApiTxnType = '1';}

        $aDataMainPage = array(
            'tStaApiTxnType' => $tStaApiTxnType
        );
        $this->load->view('interface/connectsetgennaral/wConSettingGenaralMain',$aDataMainPage);
    }

    //Functionality :  Load Page Edit 
    //Parameters : 
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSETPageEdit(){
        try{
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $nPage          = $this->input->post('nPageCurrent');
            $tSearchApiAuthor = $this->input->post('tSearchAPiAuthor');
            $tApiCode  =  $this->input->post('tApiCode');

            

            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
            if(!$tSearchApiAuthor){$tSearchApiAuthor='';}

            $aData = array(
                'nPage'       => $nPage,
                'nRow'        => 10,
                'FNLngID'     => $nLangEdit,
                'FNApiGrpSeq' => $this->input->post('DataSeq'),
                'tApiCode'     => $tApiCode,
                'tSearchApiAuthor'  =>  $tSearchApiAuthor
            );

            $aResult  = $this->mConnSetGenaral->FSaMSettingGenCheckID($aData);

            $aDataApi = array(
                'tApiCode' =>   @$aResult['raItems']['FTApiCode'],
            );

            $aDataApi = $this->mConnSetGenaral->FSaMSettingGenDataList($aData, $aDataApi);

            $aDataEdit = array(
                'nStaAddOrEdit' => 1,
                'aResult'       => $aResult,
                'aDataApi'      => $aDataApi,
                'nPage'     	=> $nPage,
                'tSearchApiAuthor'  => $tSearchApiAuthor
            );

            $this->load->view('interface/connectsetgennaral/wConSettingGenaralPageEdit', $aDataEdit);

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality :  Load Page Edit ApiAuth
    //Parameters : 
    //Creator : 30/05/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSETPageEditApiAuth(){
        try{
            $tSeq = $this->input->post('tSeq');
            $aResComp  = $this->mConnSetGenaral->FSaMSettingGenCompCode();

            $aData  = array(
                'FNLngID'      => $this->session->userdata("tLangEdit"),
                'tCmpCode'     => $aResComp['raItems']['rtCmpCode'],
                'tAPIApiCode'  => $this->input->post('tApiCode'),
                'tAgnCode'     => $this->input->post('tAgnCode'),
                'tBchCode'     => $this->input->post('tBchCode'),
            );

            $aResultApi  = $this->mConnSetGenaral->FSaMSetGenaralCheckID($aData);

            $aData = array(
                'aResComp'    => $aResComp,
                'aResultApi'  => $aResultApi,
                'tAPIApiCode' => $this->input->post('tApiCode'),
                'tAPIApiSeq'  => $this->input->post('tApiSeq'),
                'tApiUrl'     => $this->input->post('tApiUrl'),
                'tFmtCode'    => $this->input->post('tFmtCode')
            );

            $this->load->view('interface/connectsetgennaral/wConSettingGenaralPageAdd', $aData);

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality :  Load Page Add ApiAuth
    //Parameters : 
    //Creator : 30/05/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSETPageAdd(){
        try{
            $aData  = array(
                'FNLngID'      => $this->session->userdata("tLangEdit"),
                'tAPIApiCode'  => $this->input->post('tApiCode')
            );

            $aResComp  = $this->mConnSetGenaral->FSaMSettingGenCompCode();

            $aData = array(
                'aResComp'      => $aResComp,
                'aResultApi'    => array('rtCode'=>'99'),
                'tAPIApiCode'   => $this->input->post('tApiCode'),
                'tAPIApiSeq'    => $this->input->post('tApiSeq'),
                'tApiUrl'       => $this->input->post('tApiUrl'),
                'tFmtCode'       => $this->input->post('tFmtCode'),
                'tBchCompCode'  => $this->session->userdata("tSesUsrBchCodeDefault"),
                'tBchCompName'  => $this->session->userdata("tSesUsrBchNameDefault")
            );

            $this->load->view('interface/connectsetgennaral/wConSettingGenaralPageAdd', $aData);

        }catch(exception $Error){
            echo $Error;
        }
    }


    //Functionality : List Data 
	//Parameters : From Ajax File ConnsetGen
	//Creator : 15/05/2020 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvSETDataList(){

        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');
        $tSearchApi     = $this->input->post('tSearchApi');
        $tStaApiTxnType = $this->input->post('tStaApiTxnType');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        if(!$tSearchApi){$tSearchApi='';}
        if($tStaApiTxnType == '' || $tStaApiTxnType == null){$tStaApiTxnType = '1';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 100,
            'FNLngID'           => $nLangEdit,
            'tSearchAll'        => $tSearchAll,
            'tSearchApi'        => $tSearchApi,
            'tStaApiTxnType'    => $tStaApiTxnType
        );

        $aResList       = $this->mConnSetGenaral->FSaMConnSetGenDataList($aData);
        $aReslistApi    = $this->mConnSetGenaral->FSaMConnSetGenDataListApi($aData);

        $aGenTable  = array(
            'aDataList' 	    => $aResList,
            'aReslistApi'       => $aReslistApi,
            'nPage'     	    => $nPage,
            'tSearchAll'        => $tSearchAll,
            'FNLngID'           => $nLangEdit,
            'tSearchApi'        => $tSearchApi,
            'tStaApiTxnType'    => $tStaApiTxnType
        );

        //Return Data View
        $this->load->view('interface/connectsetgennaral/wConSettingGenaralDataTable', $aGenTable);

    }


    //Functionality : Function Add Edit 
    //Parameters : From Ajax File
    //Creator : 18/5/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSxSETEventAdd(){
        try{
            // Table TLKMConfig
            $aUsrValue  = $this->input->post('oetStaUsrValue');
            $aCfgCode   = $this->input->post('ohdcfgCode');
            $aCfgApp    = $this->input->post('ohdcfgApp');
            $aCfgKey    = $this->input->post('ohdcfgKey');
            $aCfgSeq    = $this->input->post('ohdcfgSeq');

            // Table TLKMTxnAPI
            $aApiCode   = $this->input->post('ohdApiCode');
            $aSeqGrp    = $this->input->post('oetSeqGrp');
            // $aGrpPrc    = $this->input->post('oetGrpPrc'); 
            $aApiUrl    = $this->input->post('oetApiURL');

            $aApiUsrName = $this->input->post('oetUsrName');
            $aApiPw      = $this->input->post('oetPassword');
            $aApiToKen   = $this->input->post('oetToken');
            $aApiFmtCode = $this->input->post('oetApiFmtCode');

            $tSeqold  = $this->input->post('oetSeqold');

            


            if(FCNnHSizeOf($aUsrValue) >= 1){
                for($i=0; $i<FCNnHSizeOf($aUsrValue); $i++){

                    $aUpdate  = array(
                        'FTCfgStaUsrValue'  => $aUsrValue[$i],
                        'FTCfgCode'         => $aCfgCode[$i],
                        'FTCfgApp'          => $aCfgApp[$i],
                        'FTCfgKey'          => $aCfgKey[$i],
                        'FTCfgSeq'          => $aCfgSeq[$i],
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                    ); 

                    $this->db->trans_begin();
                    //Update TLKMConfig
                    $aResult   = $this->mConnSetGenaral->FSaMCSSUpdate($aUpdate);

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
                }

            }

            if(FCNnHSizeOf($aSeqGrp) >= 1){
                for($j=0;$j<FCNnHSizeOf($aSeqGrp); $j++){
                    $aUpdateApi = array(
                        'FTApiCode'         => $aApiCode[$j],
                        'FNApiGrpSeq'       => $aSeqGrp[$j],
                        // 'FTApiGrpPrc'       => $aGrpPrc[$j],
                        'FTApiURL'          => $aApiUrl[$j],
                        'FTApiLoginUsr'     => $aApiUsrName[$j],
                        'FTApiLoginPwd'     => $aApiPw[$j],
                        'FTApiToken'        => $aApiToKen[$j],
                        'FTApiFmtCode'      => $aApiFmtCode[$j],
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                    ); 


                    if($tSeqold[$j] == $aSeqGrp[$j]){
                        //ไม่มีการเปลี่ยนแปลงค่า
                        $ChkDataDup['rtCode'] = '2';
                    }else{
                        //มีการเปลี่ยน ลำดับ ต้องวิ่งไปเช็ค ว่ามีลำดับซ้ำไหม
                        $ChkDataDup  = $this->mConnSetGenaral->FSaMCheckCodeDup($aUpdateApi); 
                    }

                    if($ChkDataDup['rtCode'] == 1){
                        // ถ้าข้อมูลซ้ำให้ออกลูป
                        $aReturn = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => language('interface/conSettingGenaral/consettinggenaral','tDataDupicate'),
                            'nSeqDup'       => $j
                        );
                        break;
                    }else{
                        //update Tabel TLKMTxnAPI
                        $aReturn    = $this->mConnSetGenaral->FSaMCSSUpdateApi($aUpdateApi);
                    }
                
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
        
    }

    //Functionality : Function AuthorAdd   
    //Parameters : From Ajax File
    //Creator : 18/5/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvSETEventAuthorAdd(){
        try{
            $aDataMaster    = array(
                'FTApiCode'     => $this->input->post('tApiCode'),
                'FTCmpCode'     => $this->input->post('tCmpCode'),
                'FTAgnCode'     => $this->input->post('tAgnCode'),
                'FTBchCode'     => $this->input->post('tBchCode'),
                'FTApiFmtCode'  => $this->input->post('tFmtCode'),
                'FTMerCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTShpCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTPosCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTApiURL'      => $this->input->post('tApiUrl'),
                'FTSpaUsrCode'  => $this->input->post('tApiUserName'),
                'FTSpaUsrPwd'   => $this->input->post('tApiPassword'),
                'FTSpaApiKey'   => $this->input->post('tApiKey'),
                'FTSpaRmk'      => $this->input->post('tApiRemark'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );

            
            $aStaDup = $this->mConnSetGenaral->FSaMCSGSpcCheckDupplicate($aDataMaster);

            if($aStaDup['rtCode']==1){
            $this->db->trans_begin();
            $aStaEventAdd  = $this->mConnSetGenaral->FSaMSetAddUpdateMaster($aDataMaster);

            // Insert TCNMTxnAPI  (FDLastUpdOn) ** ถ้ามีการ update ที่ TCNMTxnSpcAPI ต้อง update ที่ TCNMTxnAPI ด้วย
            $this->mConnSetGenaral->FSaMSetAddUpdateMasterTxnApi($aDataMaster);

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
        }else{
            $aReturn = array(
                'nStaEvent'	    => 2,
                'tStaMessg'		=> 'Data Duplicate'
            );
        }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Function AuthorAdd   
    //Parameters : From Ajax File
    //Creator : 18/5/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvSETEventAuthorEdit(){
        try{

            $aDataMaster    = array(
                'FTApiCode'     => $this->input->post('tApiCode'),
                'FTCmpCode'     => $this->input->post('tCmpCode'),
                'FTAgnCode'     => $this->input->post('tAgnCode'),
                'FTBchCode'     => $this->input->post('tBchCode'),
                'FTApiFmtCode'  => $this->input->post('tFmtCode'),
                'FTMerCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTShpCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTPosCode'     => '', //เก็บเป็นค่าว่าง SKC ไม่ได้ใช้
                'FTApiURL'      => $this->input->post('tApiUrl'),
                'FTSpaUsrCode'  => $this->input->post('tApiUserName'),
                'FTSpaUsrPwd'   => $this->input->post('tApiPassword'),
                'FTSpaApiKey'   => $this->input->post('tApiKey'),
                'FTSpaRmk'      => $this->input->post('tApiRemark'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );

            $this->db->trans_begin();
            $aStaEventAdd  = $this->mConnSetGenaral->FSaMSetAddUpdateMaster($aDataMaster);

            // Insert TCNMTxnAPI  (FDLastUpdOn) ** ถ้ามีการ update ที่ TCNMTxnSpcAPI ต้อง update ที่ TCNMTxnAPI ด้วย
            $this->mConnSetGenaral->FSaMSetAddUpdateMasterTxnApi($aDataMaster);

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

    //Functionality : Event Delete Userlogin
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaSETDeleteEvent(){

        // $tSeq        = $this->input->post('tSeq');
        $tSpaUsrCode = $this->input->post('tSpaUsrCode');

        $aDataMaster   = array(
            'FTApiCode' => $this->input->post('tApiCode'),
            'FTAgnCode' => $this->input->post('tAgnCode'),
            'FTBchCode' => $this->input->post('tBchCode'),
        );

        $aResDel        = $this->mConnSetGenaral->FSnMSetGenaralDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mConnSetGenaral->FSnMLOCGetAllNumRow();

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

}    

