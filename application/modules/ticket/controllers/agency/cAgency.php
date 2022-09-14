<?php
defined('BASEPATH') or exit('No direct script access allowed');
// ตัวแทนขาย
class cAgency extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/agency/mAgency');
        $this->load->model('company/branch/mBranch');
        $this->load->model('pos/salemachine/mSaleMachine');
        $this->load->library('password/PasswordStorage');
        $this->load->model('company/company/mCompany');
        date_default_timezone_set("Asia/Bangkok");
    }

    // Functionality : โหลด View หลัก และแสดงข้อมูลตัวแทนขาย
    // Parameters :  route
    // Creator : 07/06/2019 saharat(Golf)
    // Last Modified : -
    // Return : view
    // Return Type : view
    public function index($nBrowseType,$tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
	    $aData['aAlwEventAgency']   = FCNaHCheckAlwFunc('agency/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('agency/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('ticket/agency/wAgency',$aData);
    }

    // Functionality : โหลด View Lsit 
    // Parameters :  route
    // Creator : 07/06/2019 saharat(Golf)
    // Last Modified : -
    // Return : view
    // Return Type : view
    public function FStCAGNList(){
        $this->load->view('ticket/agency/wAgencyList');
    }

    //Functionality : Function Call DataTables Agency
    //Parameters : Ajax jBranch()
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCANGDataTable(){

        $aAlwEvent = FCNaHCheckAlwFunc('agency/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangEdit");
        

        $tStaUsrLevel    = $this->session->userdata("tSesUsrLevel");
        $tUsrBchCode     = $this->session->userdata("tSesUsrBchCodeMulti"); 

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'tStaUsrLevel'  => $tStaUsrLevel,
            'tUsrBchCode'   => $tUsrBchCode,
        );
        $aResList   = $this->mAgency->FSaMAGNList($aData);
        $aGenTable  = array(

            'aAlwEvent' => $aAlwEvent,
            'aDataList' => $aResList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('ticket/agency/wAgencyTable',$aGenTable);
    }

    //Functionality :  Load Page Add Agency 
    //Parameters : 
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCAGNAddPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $this->load->view('ticket/agency/wAgencyAdd',$aDataAdd);
    }

    //Functionality :  Load Page Edit Agency 
    //Parameters : 
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCAGNEditPage(){
		$aAlwEventAgency	= FCNaHCheckAlwFunc('agency/0/0'); //Controle Event
        $tAgnCode           = $this->input->post('tAgnCode');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTAgnCode' => $tAgnCode,
            'FNLngID'   => $nLangEdit
        );
        $aResult        = $this->mAgency->FSaMAGNSearchByID($aData);

        // if(isset($aResult['raItems']['FTImgObj']) && !empty($aResult['raItems']['FTImgObj'])){
        //     $tImgObj        = $aResult['raItems']['FTImgObj'];
        // }else{
        //     $tImgObj        = "";
        // }

        if($aResult['rtCode'] == '1'){

            $tVatCode   = $aResult['raItems']['FTVatCode'];
        }else{
     
            $tVatCode   = "";
        }

        $aResultVatList = $this->mCompany->FSoMCMPGetVatRate($tVatCode);


        $aResult['raItems']['FTVatCode'] = $aResultVatList[0]['rtVatCode'];
        $aResult['raItems']['FTVatRate'] = $aResultVatList[0]['rtVatRate'];

        $aDataEdit  = [
            // 'tImgName'          => $tImgName,
            'tImgObjAll'        => $aResult['raItems']['FTImgObj'],
            'aResult'           => $aResult,
            'aAlwEventAgency'   => $aAlwEventAgency
        ];
        $this->load->view('ticket/agency/wAgencyAdd',$aDataEdit);
    }

    //Functionality : Event Add Agency
    //Parameters : Ajax jReason()
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCAGNAddEvent(){
        $tAgnPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwAgnPwd'))));
        try{
            $tImgInputAgencyOld = $this->input->post('oetImgInputAgencyOld');
            $tImgInputAgency    = $this->input->post('oetImgInputAgency');
            
            $aDataMaster        = [
                'tIsAutoGenCode'    => $this->input->post('ocbAgencyAutoGenCode'),
                'FTAgnCode'         => $this->input->post('oetAgnCode'),
                'FTPplCode'         => $this->input->post('oetAGNPplRetCode'),
                'FTAgnName'         => $this->input->post('oetAgnName'),
                'FTAgnEmail'        => $this->input->post('oetAgnEmail'),
                'FTAgnPwd'          => $tAgnPwd[1],
                'FTAgnTel'          => $this->input->post('oetAgnTel'),
                'FTAgnFax'          => $this->input->post('oetAgnFax'),
                'FTAgnMo'           => $this->input->post('oetAgnMo'),
                'FTAgnStaApv'       => $this->input->post('ocmAgnStaApv'),
                'FTAgnStaActive'    => $this->input->post('ocmAgnStaActive'),
                'FTAgnRefCode'      => $this->input->post('oetAggRefCode'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTBchCode'         => $this->input->post('oetAgnBchCode'),
                'FTChnCode'         => $this->input->post('oetAgnChanelCode')
            ];

            
            // Create By Witsarut 14/08/2020 
            if($aDataMaster['tIsAutoGenCode'] == '1'){   // Check Auto Gen Department Code?
                $aStoreParam = array(
                    "tTblName"   => 'TCNMAgency',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );

                $aAutogen   	= FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTAgnCode']   = $aAutogen[0]["FTXxhDocNo"];

            }

            // if($aDataMaster['tIsAutoGenCode'] == '1'){ 
            //     $aGenCode = FCNaHGenCodeV5('TCNMAgency','0');
            //     if($aGenCode['rtCode'] == '1'){
            //         $aDataMaster['FTAgnCode'] = $aGenCode['rtAgnCode'];
            //     }
            // }

            $aDataMasterSpc = array(
                'FTAgnCode'         => $aDataMaster['FTAgnCode'],
                'FTCmpVatInOrEx'    => $this->input->post('ocmCmpRetInOrEx'),
                'FTVatCode'         => $this->input->post('oetVatRateCode'),
                'FTRteCode'         => $this->input->post('oetAgnRteCode'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            );



            $oCountDup  = $this->mAgency->FSnMAGNCheckDuplicate ($aDataMaster['FTAgnCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mAgency->FSaMAGNAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mAgency->FSaMAGNAddUpdateLang($aDataMaster);
                $aStaEventSpc     = $this->mAgency->FSaMAGNAddUpdateSpc($aDataMasterSpc);
                //--------------- เพิ่มสาขา,จุดขายและคลังอัตโนมัติ-- 7-12-2020  เนลว์--------------------------// 
                 $aBranchData =  $this->FSaCAGNCreateBranchDefault($aDataMaster);
                 $aPosData    =  $this->FSaCAGNCreatePosDefault($aDataMaster,$aBranchData);
                //-----------------------------------------------------------------------------------------//

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tImgInputAgency != $tImgInputAgencyOld){
                        $aImageUplode = array(
                            'tModuleName'       => 'ticket',
                            'tImgFolder'        => 'ticketagency',
                            'tImgRefID'         => $aDataMaster['FTAgnCode'] ,
                            'tImgObj'           => $tImgInputAgency,
                            'tImgTable'         => 'TCNMAgency',
                            'tTableInsert'      => 'TCNMImgPerson',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        $aImgReturn = FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTAgnCode'],
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


    //Functionality : Event Edit Agency
    //Parameters : Ajax jReason()
    //Creator : 10/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCAGNEditEvent(){
        $tAgnPwd = explode('6:', PasswordStorage::create_hash(trim($this->input->post('opwAgnPwd'))));
        try{
            $tImgInputAgencyOld = $this->input->post('oetImgInputAgencyOld');
            $tImgInputAgency    = $this->input->post('oetImgInputAgency');
            $aDataMaster        = [
                'FTAgnCode'         => $this->input->post('oetAgnCode'),
                'FTPplCode'         => $this->input->post('oetAGNPplRetCode'),
                'FTAgnName'         => $this->input->post('oetAgnName'),
                'FTAgnEmail'        => $this->input->post('oetAgnEmail'),
                'FTAgnPwd'          => $tAgnPwd[1],
                'FTAgnTel'          => $this->input->post('oetAgnTel'),
                'FTAgnFax'          => $this->input->post('oetAgnFax'),
                'FTAgnRefCode'      => $this->input->post('oetAggRefCode'),
                'FTAgnMo'           => $this->input->post('oetAgnMo'),
                'FTAgnStaApv'       => $this->input->post('ocmAgnStaApv'),
                'FTAgnStaActive'    => $this->input->post('ocmAgnStaActive'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTBchCode'         => $this->input->post('oetAgnBchCode'),
                'FTChnCode'         => $this->input->post('oetAgnChanelCode')
            ];

            $aDataMasterSpc = array(
                'FTAgnCode'       => $aDataMaster['FTAgnCode'],
                'FTCmpVatInOrEx'  => $this->input->post('ocmCmpRetInOrEx'),
                'FTVatCode'       => $this->input->post('oetVatRateCode'),
                'FTRteCode'       => $this->input->post('oetAgnRteCode'),
                'FDLastUpdOn'     => date('Y-m-d H:i:s'),
                'FTLastUpdBy'     => $this->session->userdata('tSesUsername'),
            );

            $this->db->trans_begin();
            $aStaEventMaster  = $this->mAgency->FSaMAGNAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mAgency->FSaMAGNAddUpdateLang($aDataMaster);
            $aStaEventSpc     = $this->mAgency->FSaMAGNAddUpdateSpc($aDataMasterSpc);
            // if ($this->input->post('ohdAgcImg')) {
            //     $tImg = $this->input->post('ohdAgcImg');
            //     $aImageUplode = array(
            //         'tModuleName'       => 'ticket',
            //         'tImgFolder'        => 'ticketagency',
            //         'tImgRefID'         => $aDataMaster['FTAgnCode'] ,
            //         'tImgObj'           => $tImg,
            //         'tImgTable'         => 'TCNMAgency',
            //         'tTableInsert'      => 'TCNMImgPerson',
            //         'tImgKey'           => 'main',
            //         'dDateTimeOn'       => date('Y-m-d H:i:s'),
            //         'tWhoBy'            => $this->session->userdata('tSesUsername'),
            //         'nStaDelBeforeEdit' => 1
            //     );
            //     $aResAddImgObj = FCNnHAddImgObj($aImageUplode);
            // }

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputAgency != $tImgInputAgencyOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'ticket',
                        'tImgFolder'        => 'ticketagency',
                        'tImgRefID'         => $aDataMaster['FTAgnCode'] ,
                        'tImgObj'           => $tImgInputAgency,
                        'tImgTable'         => 'TCNMAgency',
                        'tTableInsert'      => 'TCNMImgPerson',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn	= FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAgnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );


            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }

    //Functionality : Event Delete Agency
    //Parameters : Ajax jReason()
    //Creator : 11/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCAGNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAgnCode' => $tIDCode
        );
        
        $aResDel        = $this->mAgency->FSnMAGNDel($aDataMaster);
        $nNumRowAgn     = $this->mAgency->FSnMAGNGetAllNumRow();
        $aDeleteImage = array(
            'tModuleName'  => 'ticket',
            'tImgFolder'   => 'ticketagency',
            'tImgRefID'    => $tIDCode ,
            'tTableDel'    => 'TCNMImgPerson',
            'tImgTable'    => 'TCNMAgency'
        );
        //ลบข้อมูลในตาราง         
        $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
        if($nStaDelImgInDB == 1){
            //ลบรูปในโฟลเดอ
            FSnHDeleteImageFiles($aDeleteImage);
        }

        if($nNumRowAgn !== false){
            $aReturn    = array(
                'nStaEvent'  => $aResDel['rtCode'],
                'tStaMessg'  => $aResDel['rtDesc'],
                'nNumRowAgn' => $nNumRowAgn
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }



    
    //Functionality : Event Add Agency Auto Add Branch
    //Parameters : Call Controllers
    //Creator : 07/12/2020 nattakit (nale)
    //Last Modified : -
    //Return : -
    //Return Type : -
    public function FSaCAGNCreateBranchDefault($paDataMaster){


                //Set DateTime Bangkok
                $aDataBranchMaster = array(
                    'tIsAutoGenCode'    => 1,
                    'FTAgnCode'			=> $paDataMaster['FTAgnCode'],
                    'FTPplCode'         => '',
                    'FTBchType'     	=> '4',
                    'FTWahCode'     	=> '00001',
                    'FTBchPriority'     => '1',
                    'FTBchRegNo'     	=> '-',
                    'FTBchRefID'     	=> '',
                    'FNBchDefLang'		=> 1,
                    'FDBchStart'     	=> FCNdHConverDate(date('Y-m-d')),
                    'FDBchStop'     	=> FCNdHConverDate(date('Y-m-d', strtotime('+1 years'))), 
                    'FDBchSaleStart'    => FCNdHConverDate(date('Y-m-d')),  
                    'FDBchSaleStop'     => FCNdHConverDate(date('Y-m-d', strtotime('+1 years'))),
                    'FTBchStaActive'    => '1',
                    'FTBchStaHQ'		=> '1',
                    'FDLastUpdOn' 		=> date('Y-m-d H:i:s'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $this->session->userdata("tSesUsername"),
                    'FTLastUpdBy' 		=> $this->session->userdata('tSesUsername'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTBchName'         => $paDataMaster['FTAgnName'].' (HQ)',
                    'FTBchRmk'          => '',
                );
                
                        // Setup Branch Code
                if($aDataBranchMaster['tIsAutoGenCode'] == '1'){ 
                    $aStoreParamBranch = array(
                        "tTblName"   => 'TCNMBranch',                           
                        "tDocType"   => 0,                                          
                        "tBchCode"   => "",                                 
                        "tShpCode"   => "",                               
                        "tPosCode"   => "",                     
                        "dDocDate"   => date("Y-m-d")       
                    );
                    $aAutogen   				= FCNaHAUTGenDocNo($aStoreParamBranch);
                    $aDataBranchMaster['FTBchCode']   = $aAutogen[0]["FTXxhDocNo"];
                }

            $this->mBranch->FSaMBCHAdd($aDataBranchMaster);
            $this->mBranch->FSaMBCHWahDefaultInsert($aDataBranchMaster);
            $this->mBranch->FSaMBCHWahDefaultInsert_L($aDataBranchMaster);

            return $aDataBranchMaster;


    }



    //Functionality : Event Add Agency Auto Add Pos
    //Parameters : Call Controllers
    //Creator : 07/12/2020 nattakit (nale)
    //Last Modified : -
    //Return : -
    //Return Type : -
    public function FSaCAGNCreatePosDefault($paDataMaster,$paBranchData){


        //Set DateTime Bangkok
        $aDataPosMaster   = array(
            'tIsAutoGenCode'                => '1',
            'oetPosCode'                    => '00001',
            'FTBchCode'                     => $paBranchData['FTBchCode'],
            'FTPosStaShift'                 => '1',
            'ocmPosType'                    => '1',
            // 'oetBchWahCode'              => $this->input->post("oetBchWahCode"),
            'oetPosSmgCode'                 => '',
            'oetPosRegNo'                   => '-',
            'oetSmgCode'                    => '',  // Get data SlipMessage By Witsarut
            'ocbPOSStaPrnEJ'                => '1',
            'ocbPosStaVatSend'              => '1',
            'ocbPosStaUse'                  => '1',
            'oetPosName'                    => $paDataMaster['FTAgnName'].' (POS)',
            'ocbPOSStaSumProductBySacn'     => '1', 
            'ocbPOSStaSumProductByPrint'    => '1',
            'FTPosStaDate'                  =>  '1', //สถานะวันที่เปิดรอบเครื่องจุดขาย supawat
            'ocmPosShwRow'                  =>  '1',
            'ocmPosShwCol'                  =>  '1',
            'FTChnCode'                     =>  $paDataMaster['FTChnCode']
        );
        
        if($aDataPosMaster['tIsAutoGenCode'] == '1'){ 
            // Auto Gen Reason Code
            // Update new gencode
            // 15/05/2020 Napat(Jame)
            $aStoreParam = array(
                "tTblName"    => 'TCNMPos',                           
                "tDocType"    => 0,                                          
                "tBchCode"    => $paBranchData['FTBchCode'],                                 
                "tShpCode"    => "",                               
                "tPosCode"    => "",                     
                "dDocDate"    => date("Y-m-d")       
            );
            $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
            $aDataPosMaster['oetPosCode']      = $aAutogen[0]["FTXxhDocNo"];

        }

        $this->mSaleMachine->FSxMPOSInsertPos($aDataPosMaster);
        return $aDataPosMaster;

}

}
?>