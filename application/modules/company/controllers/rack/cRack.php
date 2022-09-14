<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cRack extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/rack/mRack');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nRacBrowseType,$tRacBrowseOption){
        $nMsgResp = array('title'=>"Reason");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave       = FCNaHBtnSaveActiveHTML('rack/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventRack	= FCNaHCheckAlwFunc('rack/0/0');
        $this->load->view ( 'company/rack/wRack', array (
            'nMsgResp'          =>$nMsgResp,
            'vBtnSave'          =>$vBtnSave,
            'nRacBrowseType'    =>$nRacBrowseType,
            'tRacBrowseOption'  =>$tRacBrowseOption,
            'aAlwEventRack'     =>$aAlwEventRack
        ));
    }

    //Functionality : Function Call Page Rack List
    //Parameters : Ajax jRack()
    //Creator : 28/09/2019 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCRckListPage(){
        $aAlwEventRack	= FCNaHCheckAlwFunc('rack/0/0');
        $aNewData  		= array( 'aAlwEventRack' => $aAlwEventRack);
        $this->load->view('company/rack/wRackList',$aNewData);
    }

    //Functionality : Function Call DataTables Rack List
    //Parameters : Ajax jRack()
    //Creator : 29/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCRckDataList(){
        $nPage  = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mRack->FSaMRckList($tAPIReq,$tMethodReq,$aData);
        //Controle Event
        $aAlwEvent  = FCNaHCheckAlwFunc('rack/0/0'); 
        $aGenTable  = array(
            'aAlwEventRack' => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('company/rack/wRackDataTable',$aGenTable);
    }

    //Functionality : Function Call Add Page Reason
    //Parameters : Ajax jRack()
    //Creator : 28/05/2018 wasin
    //Last Modified : 29/08/2019 Saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvRackAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $this->load->view('company/rack/wRackAdd',$aDataAdd);
    }

    //Functionality : Function Call Edit Page Reason
    //Parameters : Ajax jRack()
    //Creator : 29/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCRackEditPage(){
        $tRckCode       = $this->input->post('tRckCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        //Controle Event
        $aAlwEventRack  = FCNaHCheckAlwFunc('agency/0/0'); 
        $aData  = array(
            'FTRckCode' => $tRckCode,
            'FNLngID'   => $nLangEdit
        );
        $aRckData       = $this->mRack->FSaMRCKSearchByID($aData);
        if(isset($aRckData['raItems']['rtImgObj']) && !empty($aRckData['raItems']['rtImgObj'])){
            $tImgObj        = $aRckData['raItems']['rtImgObj'];
            $aImgObj        = explode("application/modules/",$tImgObj);
            $aImgObjName    = explode("/",$tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName		= end($aImgObjName);
        }else{
            $tImgObjAll     = "";
            $tImgName       = "";
        }
        $aDataEdit = array(
            'aResult'       => $aRckData,
            'aAlwEventRack' => $aAlwEventRack,
            'tImgObjAll'    => $tImgObjAll,
            'tImgName'      => $tImgName
        );
        $this->load->view('company/rack/wRackAdd',$aDataEdit);
    }

    //Functionality : Function Create Selected
    //Parameters : Function Parameter
    //Creator : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaRSNDropdown($ptRntID,$ptIDname,$poData){
        //Parameters : $ptRntID = ข้อมูลที่ใช้เช็คทำ Selected(EDIT)
        //$ptIDname = ชื่อ ID กับ Name
        //$poData = ข้อมูลที่ใช้ทำ Dropdown
        $tDropdown  = "<select required class='selection-2 selectpicker form-control' id='".$ptIDname."' name='".$ptIDname."' >";
        if($poData['rtCode']=='1'){
            foreach($poData['raItems'] AS $key=>$aValue){
                $selected = ($ptRntID!='' && $ptRntID == $aValue['rtRsgCode'])? 'selected':'';
                $tDropdown .= "<option value='".$aValue['rtRsgCode']."' ".$selected.">".$aValue['rtRsgName']."</option>";
            }
        }
        $tDropdown  .= "</select>";
        return $tDropdown;
    }

    //Functionality : Event Add Reason
    //Parameters : Ajax jRack()
    //Creator : 15/10/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaRacAddEvent(){
        try{
            $tRackImageOld  = trim($this->input->post('oetImgInputRackOld'));
			$tRackImage		= trim($this->input->post('oetImgInputRack'));
            $aDataMaster    = array(
                'tIsAutoGenCode'        => $this->input->post('ocbRacAutoGenCode'),
                'FTRacCode'             => $this->input->post('oetRacCode'),
                'FTRacName'             => $this->input->post('oetRacName'),
                'FTRacRmk'              => $this->input->post('oetRacRemark'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'               => $this->session->userdata("tLangEdit")
            );
        
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"    => 'TRTMShopRack',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );

                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTRacCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TRTMShopRack','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTRacCode'] = $aGenCode['rtRakCode'];
                // }
            }
            $oCountDup  = $this->mRack->FSoMRacCheckDuplicate($aDataMaster['FTRacCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaRacMaster  = $this->mRack->FSaMRacAddUpdateMaster($aDataMaster);
                $aStaRacLang    = $this->mRack->FSaMRacAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tRackImage  !=  $tRackImageOld){
                        $aImageUplode = array(
                            'tModuleName'       => 'company',
                            'tImgFolder'        => 'Rack',
                            'tImgRefID'         => $aDataMaster['FTRacCode'] ,
                            'tImgObj'           => $tRackImage,
                            'tImgTable'         => 'TRTMShopRack',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        $aRckAddImgObj  = FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTRacCode'],
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

    //Functionality : Event Edit Rack
    //Parameters : Ajax jRack()
    //Creator : 29/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCRCKEditEvent(){
        try{
            $tRackImageOld  = trim($this->input->post('oetImgInputRackOld'));
			$tRackImage		= trim($this->input->post('oetImgInputRack'));
            $aDataMaster    = array(
                'FTRacCode'     => $this->input->post('oetRacCode'),
                'FTRacName'     => $this->input->post('oetRacName'),
                'FTRacRmk'      => $this->input->post('oetRacRemark'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $this->db->trans_begin();
            $aStaRacMaster  = $this->mRack->FSaMRacAddUpdateMaster($aDataMaster);
            $aStaRacLang    = $this->mRack->FSaMRacAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Event"
                );
            }else{
                $this->db->trans_commit();
                if($tRackImage  !=  $tRackImageOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'company',
                        'tImgFolder'        => 'Rack',
                        'tImgRefID'         => $aDataMaster['FTRacCode'] ,
                        'tImgObj'           => $tRackImage,
                        'tImgTable'         => 'TRTMShopRack',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aRckAddImgObj  = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTRacCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
        
    }

    //Functionality : Event Delete Rack
    //Parameters : Ajax jRack()
    //Creator : 29/08/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCRCKDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTRakCode' => $tIDCode
        );
        $aRckDel        = $this->mRack->FSnMRCKDel($aDataMaster);
        $aDeleteImage = array(
            'tModuleName'  => 'product',
            'tImgFolder'   => 'Rack',
            'tImgRefID'    => $tIDCode ,
            'tImgTable'    => 'TRTMShopRack',
            'tTableDel'    => 'TCNMImgObj'
            );
        //ลบข้อมูลในตาราง         
        $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
        if($nStaDelImgInDB == 1){
            //ลบรูปในโฟลเดอ
            FSnHDeleteImageFiles($aDeleteImage);
        }
        $nNumRowRck     = $this->mRack->FSnMLOCGetAllNumRow();
        $aReturn            =  [
            'nStaEvent'     => $aRckDel['rtCode'],
            'tStaMessg'     => $aRckDel['rtDesc'],
            'nNumRowRck'    => $nNumRowRck
        ];
        echo json_encode($aReturn);
    }

    //Functionality : Function Call Page Main Tab Rack
    //Parameters : From Ajax File jShopAdd
    //Creator : 15/10/2019 Saharat(Golf)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCSMSmartlockerRackMainPage(){
        $nPageShpCallBack       = $this->input->post('nPageShpCallBack');
        $vBtnSaveRack          = FCNaHBtnSaveActiveHTML('rack/0/0');
        $aAlwEventRack   = FCNaHCheckAlwFunc('rack/0/0');
     
        $this->load->view('company/rack/tabrack/wSmartlockerRackMain',array(
            'nPageShpCallBack'       => $nPageShpCallBack,
            'vBtnSaveRack'           => $vBtnSaveRack,
            'aAlwEventRack'          => $aAlwEventRack
        ));
    }

    //Functionality : List Data TabRack  
	//Parameters : From Ajax File jSmartlockerSizeMain
	//Creator : 04/07/2019 Saharat(Golf)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCSmartlockerRackListPage(){
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventRack   = FCNaHCheckAlwFunc('rack/0/0');
        $aData  = array(

            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList           = $this->mRack->FSaMRckList($tAPIReq,$tMethodReq,$aData);
        $aGenTable          = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'aAlwEventRack'      => $aAlwEventRack
        );

        //Return Data View
        $this->load->view('company/rack/tabrack/wSmartlockerRackDataTable',$aGenTable);
    }

    //Functionality :  Load Page Add Tab Rack 
    //Parameters : 
    //Creator : 15/10/2019 saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCSMSPageAdd(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $nPageShpCallBack                = $this->input->post('nPageShpCallBack');
        $vBtnSaveSmartlockerRack         = FCNaHBtnSaveActiveHTML('rack/0/0');
        $aAlwEventSmartlockerRack        = FCNaHCheckAlwFunc('rack/0/0');

    
        $aDataAdd = array(
            'aResult'                     => array('rtCode'=>'99'),
            'nPageShpCallBack'            => $nPageShpCallBack,
            'vBtnSaveSmartlockerRack'     => $vBtnSaveSmartlockerRack,
            'aAlwEventSmartlockerRack'    => $aAlwEventSmartlockerRack,

        );

        $this->load->view('company/rack/tabrack/wSmartlockerRackAdd',$aDataAdd);
    }

    //Functionality : Function Call Edit Page Tab Rack
    //Parameters : Ajax jRack()
    //Creator : 15/10/2019 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCTabRackEditPage(){
        $tRckCode       = $this->input->post('tRckCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        //Controle Event
        $aAlwEventRack  = FCNaHCheckAlwFunc('rack/0/0'); 
        $aData  = array(
            'FTRckCode' => $tRckCode,
            'FNLngID'   => $nLangEdit
        );
        $aRckData       = $this->mRack->FSaMRCKSearchByID($aData);
        if(isset($aRckData['raItems']['rtImgObj']) && !empty($aRckData['raItems']['rtImgObj'])){
            $tImgObj        = $aRckData['raItems']['rtImgObj'];
            $aImgObj        = explode("application/modules/",$tImgObj);
            $aImgObjName    = explode("/",$tImgObj);
            $tImgObjAll     = $aImgObj[1];
            $tImgName		= end($aImgObjName);
        }else{
            $tImgObjAll     = "";
            $tImgName       = "";
        }
        $aDataEdit = array(
            'aResult'       => $aRckData,
            'aAlwEventSmartlockerRack' => $aAlwEventRack,
            'tImgObjAll'    => $tImgObjAll,
            'tImgName'      => $tImgName
        );
        $this->load->view('company/rack/tabrack/wSmartlockerRackAdd',$aDataEdit);
    }


}
