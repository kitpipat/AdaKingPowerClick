<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVendingshoptype extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('vending/vendingshoptype/mVendingshoptype');
    }

    public function index($nVstBrowseType,$tVstBrowseOption){
        $aBrowseType = explode("-",$nVstBrowseType);
		if(isset($aBrowseType[1])){
			$nVstBrowseType = $aBrowseType[0];
			$tRouteFromName = $aBrowseType[1];
		}else{
			$nVstBrowseType = $nVstBrowseType;
			$tRouteFromName = '';
        }
        $aDataConfigView = array(
            'tRouteFromName'    => $tRouteFromName,
            'nVstBrowseType'    => $nVstBrowseType,
            'tVstBrowseOption'  => $tVstBrowseOption
        );
        $this->load->view('vending/vendingshoptype/wVendingshoptype',$aDataConfigView);
    }

    //Functionality : Function Call Page Vending List
    //Parameters : Ajax jVendingshoptype()
    //Creator : 06/02/2019 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVSTListPage(){
        /*$aAlwVendingshoptype	= FCNaHCheckAlwFunc('vendingshoptype/0/0');
        $aNewData  		= array( 'aAlwEventVendingShopType' => $aAlwVendingshoptype);
        $this->load->view('vending/vendingshoptype/wVendingshoptypeList',$aNewData);*/
    }

    //Functionality : Function Call DataTables Vending shop list List
    //Parameters : Ajax jVendingshoptype()
    //Creator : 06/02/2019 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVSTDataList(){
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    // $aLangHave      = FCNaHGetAllLangByTable('TVDMShopType_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);

        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
	    // }
        
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mVendingshoptype->FSaMVstList($tAPIReq,$tMethodReq,$aData);
        $aAlwEvent  = FCNaHCheckAlwFunc('vendingshoptype/0/0'); //Controle Event

        $aGenTable  = array(
            'aAlwEventVendingShoptype'  => $aAlwEvent,
            'aDataList'                 => $aResList,
            'nPage'                     => $nPage,
            'tSearchAll'                => $tSearchAll
        );
        $this->load->view('vending/vendingshoptype/wVendingshoptypeDataTable',$aGenTable);
    }

    //Functionality : Function Call Add Page Vending
    //Parameters : Ajax jVendingshoptype()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVSTAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TVDMShopType_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
	        if($nLangEdit != ''){
	            $nLangEdit = $nLangEdit;
	        }else{
	            $nLangEdit = $nLangResort;
	        }
	    }else{
	        if(@$aLangHave[0]->nLangList == ''){
	            $nLangEdit = '1';
	        }else{
	            $nLangEdit = $aLangHave[0]->nLangList;
	        }
        }

        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $this->load->view('vending/vendingshoptype/wVendingshoptypeAdd',$aDataAdd);
    }

    //Functionality : Function Call Edit Page Vending
    //Parameters : Ajax jVendingshoptype()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVSTEditPage(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShpCode       = $this->input->post('tShpCode');

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TVDMShopType_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        $aData  = array(
            'FTBchCode' => $tBchCode,
            'FTShpCode' => $tShpCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aPackData      = $this->mVendingshoptype->FSaMVstSearchByID($tAPIReq,$tMethodReq,$aData);
        $aDataEdit = array(
            'tFTBchCode'    => $tBchCode,
            'tFTShpCode'    => $tShpCode,
            'aResult'       => $aPackData
        );
        $this->load->view('vending/vendingshoptype/wVendingshoptypeAdd',$aDataEdit);
    }

    //Functionality : Function Create Selected
    //Parameters : Function Parameter
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaVSTDropdown($ptRntID,$ptIDname,$poData){
        //Parameters : $ptRntID = ข้อมูลที่ใช้เช็คทำ Selected(EDIT)
        //$ptIDname = ชื่อ ID กับ Name
        //$poData = ข้อมูลที่ใช้ทำ Dropdown
        $tDropdown  = "<select required class='selection-2 selectpicker form-control' id='".$ptIDname."' name='".$ptIDname."' >
        <option value=''>".language('common/main/main', 'tCMNBlank-NA')."</option>";
        if($poData['rtCode']=='1'){
            foreach($poData['raItems'] AS $key=>$aValue){
                $selected = ($ptRntID!='' && $ptRntID == $aValue['rtRsgCode'])? 'selected':'';
                $tDropdown .= "<option value='".$aValue['rtRsgCode']."' ".$selected.">".$aValue['rtRsgName']."</option>";
            }
        }
        $tDropdown  .= "</select>";
        return $tDropdown;
    }

    //Functionality : Event Add Vending
    //Parameters : Ajax jVendingshoptype()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaVSTAddEvent(){
        try{
            $tTypepage      = $this->input->post("ohdTypepage");
            if($tTypepage == 'Add'){
                $aStoreParam = array(
                    "tTblName"    => 'TVDMShopType',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $nMasterCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TVDMShopType','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $nMasterCode = $aGenCode['rtShtCode'];
                // }

                $aDataMaster    = array(
                    'FTShtCode'     => $nMasterCode,
                    'FTShtType'     => $this->input->post('ocmSelectSrcType'),
                    'FNShtValue'    => $this->input->post('oetVstTempAgg'),    
                    'FNShtMin'      => $this->input->post('oetVstTempMin'),
                    'FNShtMax'      => $this->input->post('oetVstTempMax'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'     => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'FTShtName'     => $this->input->post('oetVstName'),
                    'FTShtRemark'   => $this->input->post('oetVstRemark')
                );

                $oCountDup  = $this->mVendingshoptype->FSoMVstCheckDuplicate($aDataMaster['FTShtCode']);
                $nStaDup    = $oCountDup[0]->counts;

                if(trim($nStaDup) == 0){
                    $this->db->trans_begin();
                    $aStaVstMaster  = $this->mVendingshoptype->FSaMVstAddUpdateMaster($aDataMaster,$tTypepage);
                    $aStaVstLang    = $this->mVendingshoptype->FSaMVstAddUpdateLang($aDataMaster,$tTypepage);
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
                            'tTypeVending'  => $aDataMaster['FTShtType'],
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
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Vending
    //Parameters : Ajax jVendingshoptype()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaVSTEditEvent(){
        //try{
            // $tTypepage      = $this->input->post("ohdTypepage");
            // echo  'Function : FSaVSTEditEvent '.$tTypepage;
            // $aDataMaster    = array(
            //     'FTBchCode'     => $this->input->post("oetBranchCode"),
            //     'FTShpCode'     => $this->input->post('oetShopCode'),
            //     'FTShtType'     => $this->input->post('ocmSelectSrcType'),
            //     'FNShtValue'    => $this->input->post('oetVstTempAgg'),    
            //     'FNShtMin'      => $this->input->post('oetVstTempMin'),
            //     'FNShtMax'      => $this->input->post('oetVstTempMax'),
            //     'FNLngID'       => $this->session->userdata("tLangEdit"),
            //     'FTShtName'     => $this->input->post('oetVstName'),
            //     'FTShtRemark'   => $this->input->post('oetVstRemark')
            // );
            
            // $this->db->trans_begin();
            // $aStaVstMaster  = $this->mVendingshoptype->FSaMVstAddUpdateMaster($aDataMaster,$tTypepage);
            // $aStaVstLang    = $this->mVendingshoptype->FSaMVstAddUpdateLang($aDataMaster,$tTypepage);

            // if($this->db->trans_status() === false){
            //     $this->db->trans_rollback();
            //     $aReturn = array(
            //         'nStaEvent'    => '900',
            //         'tStaMessg'    => "Unsucess Edit Event"
            //     );
            // }else{
            //     $this->db->trans_commit();
            //     $aReturn = array(
            //         'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
            //         'tCodeReturn'	=> $aDataMaster['FTShpCode'],
            //         'tTypeVending'  => $aDataMaster['FTShtType'],
            //         'nStaEvent'	    => '1',
            //         'tStaMessg'		=> 'Success Add Event'
            //     );
            // }
            // echo json_encode($aReturn);
        // }catch(Exception $Error){
        //     echo $Error;
        // }
    }

    //Functionality : Event Delete Vending
    //Parameters : Ajax jVendingshoptype()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaVSTDeleteEvent(){
        // $aDataMaster = array(
        //     'FTShpCode' => $this->input->post('tIDCode'),
        //     'FTBchCode' => $this->session->userdata("tSesUsrBchCode"),
        // );
        // $tAPIReq        = 'API/mVendingshoptype/Delete';
        // $tMethodReq     = 'POST';
        // $aResDel        = $this->mVendingshoptype->FSnMVstDel($tAPIReq,$tMethodReq,$aDataMaster);
        // $aReturn    = array(
        //     'nStaEvent' => $aResDel['rtCode'],
        //     'tStaMessg' => $aResDel['rtDesc']
        // );
        // echo json_encode($aReturn);
    }

}
