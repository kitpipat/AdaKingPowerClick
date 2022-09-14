<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSettingconperiod extends MX_Controller {
    
    public function __construct(){
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('settingconfig/settingconperiod/mSettingconperiod');
    }


    public function index($nLimBrowseType, $tLimBrowseOption){

        $nMsgResp   = array('title' => "Settingconperid");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';

        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }

        $vBtnSave       = FCNaHBtnSaveActiveHTML('settingconperiod/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventSettconpreiod  = FCNaHCheckAlwFunc('settingconperiod/0/0');

        $this->load->view('settingconfig/settingconperiod/wSettingconperiod', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nLimBrowseType'    => $nLimBrowseType,
            'tLimBrowseOption'  => $tLimBrowseOption,
            'aAlwEventSettconpreiod' => $aAlwEventSettconpreiod
        ));
    }

    //Functionality : Function Call Page SettingConperiod List
    //Parameters : Ajax and Function Parameter
    //Creator : 07-10-2020 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCLIMListPage(){
        $aAlwEventSettconpreiod  = FCNaHCheckAlwFunc('settingconperiod/0/0');
        $aNewData     = array('aAlwEventSettconpreiod' => $aAlwEventSettconpreiod);

        $this->load->view('settingconfig/settingconperiod/wSettingconperiodList', $aNewData);
    }


    //Functionality : Function Call View Data SettingConperiod
    //Parameters : Ajax Call View DataTable
    //Creator : 07-10-2020 witsarut 
    //Return : String View
    //Return Type : View
    public function FSvCLIMDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangEdit  = $this->session->userdata("tLangEdit");

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aLimDataList = $this->mSettingconperiod->FSaMLIMList($aData);
            $aAlwEventSettconpreiod = FCNaHCheckAlwFunc('settingconperiod/0/0'); //Controle Event


            $aGenTable = array(
                'aLimDataList'  => $aLimDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll,
                'aAlwEventSettconpreiod' => $aAlwEventSettconpreiod
              
            );

            $this->load->view('settingconfig/settingconperiod/wSettingconperiodDataTable', $aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SettingConperiod Add
    //Parameters : Ajax Call View Add
    //Creator : 10/10/2018 witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCLIMAddPage(){

        $nLangEdit          = $this->session->userdata("tLangEdit");
        $vBtnSaveUsrlogin   = FCNaHBtnSaveActiveHTML('settingconperiod/0/0');
        $aAlwEventSettconpreiod  = FCNaHCheckAlwFunc('settingconperiod/0/0');

        $aDataAdd = array(
            'nStaAddOrEdit'         => 0,
            'aResult'                => array('rtCode'=>'99'),
            'vBtnSaveUsrlogin'       => $vBtnSaveUsrlogin,
            'aAlwEventSettconpreiod' => $aAlwEventSettconpreiod,
        );

        $this->load->view('settingconfig/settingconperiod/wSettingconperiodAdd', $aDataAdd);
    }

    //Functionality : Function CallPage SettingConditionperion Edit
    //Parameters : Ajax Call View Add
    //Creator : 11/10/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCLIMEditPage(){
        $aDataEdit = array(
            'FTLhdCode'  => $this->input->post('tLhdCode'),
            'FTRolCode'  => $this->input->post('tRolCode'),
            'FNLimSeq'   => $this->input->post('tSeq'),
            'FNLngID'    => $this->session->userdata("tLangEdit"),
        ); 

        $aLimDataEdit   = $this->mSettingconperiod->FSaMLIMGetDataByID($aDataEdit);
        $aLimDataChk    = $this->mSettingconperiod->FSaMLIMCheckRolCode($aDataEdit);

        //Check StaAlwSeq ถ้าเป็น 1 ให้เพิ่มได้ แต่ถ้าเป็น 2 เพิ่มไม่ได้
        $aResultChkAlwSeq  = $this->mSettingconperiod->FSaMLIMCheckStaAlwSeq($aDataEdit);

        $aData  = array(
            'nStaAddOrEdit' => 1,
            'aLimDataEdit'  => $aLimDataEdit,
            'aLimDataChk'   => $aLimDataChk,
            'aResultChkAlwSeq'  => $aResultChkAlwSeq
        );

        $this->load->view('settingconfig/settingconperiod/wSettingconperiodChkRole', $aData);

    }


    // function Check Role
    public function FSvCLIMChkRole(){
        $nLangEdit               = $this->session->userdata("tLangEdit");
        $aAlwEventSettconpreiod  = FCNaHCheckAlwFunc('settingconperiod/0/0');
        $aData  = array(
            'aResult'       => array('rtCode'=>'99'),
            'FTLhdCode'     => $this->input->post('nLhdCode'),
            'FTRolCode'     => $this->input->post('nGrpRolCode'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
        );

        $aLimDataChk        = $this->mSettingconperiod->FSaMLIMCheckRolCode($aData);
        //Check StaAlwSeq ถ้าเป็น 1 ให้เพิ่มได้ แต่ถ้าเป็น 2 เพิ่มไม่ได้
        $aResultChkAlwSeq   = $this->mSettingconperiod->FSaMLIMCheckStaAlwSeq($aData);

        $aDataAdd = array(
            'aLimDataChk'               => $aLimDataChk,
            'aResultChkAlwSeq'          => $aResultChkAlwSeq,
            'aAlwEventSettconpreiod'    => $aAlwEventSettconpreiod
        );

        $tPagehtml  = $this->load->view('settingconfig/settingconperiod/wSettingconperiodChkRole', $aDataAdd,true);
        $aReturn    = array(
            'nStaEvent' => $aLimDataChk['rtCode'],
            'tStaMessg' => $aLimDataChk['rtDesc'],
            'tPagehtml' => $tPagehtml
        );
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Card
    //Parameters : Ajax jReason()
    //Creator : 09/10/2020 Witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCLIMDeleteEvent(){
        try{
            $aDataDel = array(
               'FTLhdCode' => $this->input->post('ptLhdCode'),
               'FTRolCode' => $this->input->post('ptRolCode')
            );
            $aResDel       = $this->mSettingconperiod->FSnMSettingConDel($aDataDel);
            $nNumRowLimLoc  = $this->mSettingconperiod->FSnMSettingConGetAllNumRow();

            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowLimLoc' => $nNumRowLimLoc
            );
        
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Delete SettingConditionperiod Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSaCLIMDeleteMultiEvent(){
        try{
            $this->db->trans_begin();
            $aDataDelete    = array(
                'aDataLhdCode'  => $this->input->post('paDataLhdCode'),
                'aDataRolCode'  => $this->input->post('paDataRolCode'),
            );

            $tResult    = $this->mSettingconperiod->FSaMLIMDeleteMultiple($aDataDelete);
            $nNumRowLimLoc  = $this->mSettingconperiod->FSnMSettingConGetAllNumRow();

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
                    'tStaMessg' => 'Success Delete Pos Ads Multiple',
                    'nNumRowLimLoc' => $nNumRowLimLoc
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

    //Functionality : Event Add SettingCondition
    //Parameters : Ajax Event
    //Creator : 12/10/2020 Witsarut
    //Return : Status Add Event
    //Return Type : String
    public function FSaCLIMAddEvent(){
        try{

            $tSeq = 1;
            $aFTLhdCode      = $this->input->post('oetLhdCode');
            $aFTRolCode      = $this->input->post('oetGrpRolCode');
            $aFNLimSeq       = $tSeq;
            $tFTLimStaWarn   = $this->input->post('ocmLimStaWarn');
            $tFTLimMsgSpc    = $this->input->post('oetSpcValue');
            $tMinMaxValue    = $this->input->post('oetMinMaxValue');

            if($tMinMaxValue == 1){
                $tFCLimMin       = $this->input->post('oetMinValue');
                $tFCLimMax       = 0.00;

                $tFCLimMin = str_replace(",","",$tFCLimMin);
                $tFCLimMax = str_replace(",","",$tFCLimMax);
            }elseif($tMinMaxValue == 2){
                $tFCLimMin       = 0.00;
                $tFCLimMax       = $this->input->post('oetMaxValue');

                $tFCLimMin = str_replace(",","",$tFCLimMin);
                $tFCLimMax = str_replace(",","",$tFCLimMax);
            }else{
                $tFCLimMin       = $this->input->post('oetMinValue');
                $tFCLimMax       = $this->input->post('oetMaxValue'); 

                $tFCLimMin = str_replace(",","",$tFCLimMin);
                $tFCLimMax = str_replace(",","",$tFCLimMax);
            }

            $aDataDel = array(
                'aFTLhdCode'     => $this->input->post('oetLhdCode'),
                'aFTRolCode'     => $this->input->post('oetGrpRolCode'),
            );

            //Delete And Update Insert
            $this->mSettingconperiod->FSaMLIMDeleteFrist($aDataDel);


            if($tMinMaxValue == 1){
                for($i=0; $i<FCNnHSizeOf($tFCLimMin); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin[$i],
                        'FCLimMax'      => $tFCLimMax,
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tReturnLhdCode'  => $aUpdate['FTLhdCode'],
                            'tReturnRolCode'  => $aUpdate['FTRolCode']

                        );
                    }
                }
            }else if($tMinMaxValue == 2){

                for($i=0; $i<FCNnHSizeOf($tFCLimMax); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin,
                        'FCLimMax'      => $tFCLimMax[$i],
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tReturnLhdCode'  => $aUpdate['FTLhdCode'],
                            'tReturnRolCode'  => $aUpdate['FTRolCode']
                        );
                    }
                }
            }else{
                for($i=0; $i<FCNnHSizeOf($tFCLimMin); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin[$i],
                        'FCLimMax'      => $tFCLimMax[$i],
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tReturnLhdCode'  => $aUpdate['FTLhdCode'],
                            'tReturnRolCode'  => $aUpdate['FTRolCode']
                        );
                    }
                }
            }

            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit SettingCondition
    //Parameters : Ajax Event
    //Creator : 12/10/2020 Witsarut
    //Return : Status Add Event
    //Return Type : String
    public function FSaCLIMEditEvent(){
        try{
            $tSeq = 1;
     
            $aFTLhdCode      = $this->input->post('oetLhdCodeEdit');
            $aFTRolCode      = $this->input->post('oetGrpRolCodeEdit');
            $aFNLimSeq       = $tSeq;
            $tFTLimStaWarn   = $this->input->post('ocmLimStaWarn');
            $tFTLimMsgSpc    = $this->input->post('oetSpcValue');

            $tFCLimMin       = $this->input->post('oetMinValue');
            $tFCLimMax       = $this->input->post('oetMaxValue'); 


            $aDataDel = array(
                'aFTLhdCode'     => $this->input->post('oetLhdCodeEdit'),
                'aFTRolCode'     => $this->input->post('oetGrpRolCodeEdit'),
            );


            $tMinMaxValue    = $this->input->post('oetMinMaxValue');

            if($tMinMaxValue == 1){
                $tFCLimMin       = $this->input->post('oetMinValue');
                $tFCLimMax       = 0.0;

            }elseif($tMinMaxValue == 2){
                $tFCLimMin       = 0.00;
                $tFCLimMax       = $this->input->post('oetMaxValue');

            }else{
                $tFCLimMin       = $this->input->post('oetMinValue');
                $tFCLimMax       = $this->input->post('oetMaxValue'); 
            
            }

            $tFCLimMin = str_replace(",","",$tFCLimMin);
            $tFCLimMax = str_replace(",","",$tFCLimMax);

            //Delete And Update Insert
            $this->mSettingconperiod->FSaMLIMDeleteFrist($aDataDel);

            if($tMinMaxValue == 1){
                for($i=0; $i<FCNnHSizeOf($tFCLimMin); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin[$i],
                        'FCLimMax'      => $tFCLimMax,
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive')
                        );
                    }
                }
            }else if($tMinMaxValue == 2){
                for($i=0; $i<FCNnHSizeOf($tFCLimMax); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin,
                        'FCLimMax'      => $tFCLimMax[$i],
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive')
                        );
                    }
                }
            }else{
                for($i=0; $i<FCNnHSizeOf($tFCLimMin); $i++){
                    $aUpdate = array(
                        'FTLhdCode'     => $aFTLhdCode,
                        'FTRolCode'     => $aFTRolCode,
                        'FTAgnCode'     => ($this->input->post('oetConperiodAgncode') == '') ? NULL : $this->input->post('oetConperiodAgncode'),
                        'FNLimSeq'      => $i+1,
                        'FCLimMin'      => $tFCLimMin[$i],
                        'FCLimMax'      => $tFCLimMax[$i],
                        'FTLimStaWarn'  => $tFTLimStaWarn[$i],
                        'FTLimMsgSpc'   => $tFTLimMsgSpc[$i],
                        'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                        'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                        'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                    );

                    //inSert INto TCNMLimitRole
                    $this->mSettingconperiod->FSaMLIMUpdate($aUpdate);
                    
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
                            'tStaMessg'		=> 'Success Add Event',
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive')
                        );
                    }
                }

            }

            echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
    }




}
