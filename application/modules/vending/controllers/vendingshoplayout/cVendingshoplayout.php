<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVendingshoplayout extends MX_Controller {


    
    public function __construct() {
        parent::__construct ();
        $this->load->model('vending/vendingshoplayout/mVendingshoplayout');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nVslBrowseType,$tVslBrowseOption){
        $nMsgResp = array('title'=>"Vending Shop Layout");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu'  , array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('vendingshoplayout/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwvendingshoplayout	= FCNaHCheckAlwFunc('vendingshoplayout/0/0');
        $this->load->view ( 'vending/vendingshoplayout/wVendingshoplayout', array (
            'nMsgResp'              =>$nMsgResp,
            'vBtnSave'              =>$vBtnSave,
            'nVslBrowseType'        =>$nVslBrowseType,
            'tVslBrowseOption'      =>$tVslBrowseOption,
            'aAlwEventvendingshoplayout'   =>$aAlwvendingshoplayout
        ));
    }

    //Functionality : Function Call Page Vending List
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 06/02/2019 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVslListPage(){
        $aAlwvendingshoplayout	= FCNaHCheckAlwFunc('vendingshoplayout/0/0');
        $aNewData  		= array( 'aAlwEventvendingshoplayout' => $aAlwvendingshoplayout);
        $this->load->view('vending/vendingshoplayout/wVendingshoplayoutList',$aNewData);
    }

    //Functionality : Function Call DataTables Vending shop list List
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 06/02/2019 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVslDataList(){
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TVDMShopSize_L');
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
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'nSessionBCH'   => $this->session->userdata("tSesUsrBchCode"),
            'nSessionSHP'   => $this->session->userdata("tSesUsrShpCode")
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList   = $this->mVendingshoplayout->FSaMVslList($tAPIReq,$tMethodReq,$aData);
        $aAlwEvent  = FCNaHCheckAlwFunc('vendingshoplayout/0/0'); //Controle Event

        $aGenTable  = array(
            'aAlwEventvendingshoplayout'  => $aAlwEvent,
            'aDataList'                 => $aResList,
            'nPage'                     => $nPage,
            'tSearchAll'                => $tSearchAll
        );
        $this->load->view('vending/vendingshoplayout/wVendingshoplayoutDataTable',$aGenTable);
    }

    //Functionality : Function Call Add Page Vending
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVslAddPage(){
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TVDMShopSize_L');
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

        $tBchCode       = $this->input->post('tBchCode');
        $tShpCode       = $this->input->post('tShpCode');

        $aData  = array(
            'FTShpCode' => $tShpCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aVslData       = $this->mVendingshoplayout->FSaMVslSearchByID($tAPIReq,$tMethodReq,$aData);

        if($aVslData['rtCode'] == 800){
            $aVslData = '';
        }

        $aDataAdd = array(
            'aResult'   => $aVslData,
            'FTBchCode' => $tBchCode,
            'FTShpCode' => $tShpCode
        );
        
        // echo '<pre>';
        // echo print_r($aVslData['rtCode']);
        // echo '</pre>';
        $this->load->view('vending/vendingshoplayout/wVendingshoplayoutAdd',$aDataAdd);
    }

    //Functionality : Function Call Edit Page Vending
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvVslEditPage(){
        $tVslCode       = $this->input->post('tVslCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TVDMShopSize_L');
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
            'FTShpCode' => $tVslCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aVslData       = $this->mVendingshoplayout->FSaMVslSearchByID($tAPIReq,$tMethodReq,$aData);
        $aDataEdit = array(
            'aResult'   => $aVslData,
        );
        $this->load->view('vending/vendingshoplayout/wVendingshoplayoutAdd',$aDataEdit);
    }

    //Functionality : Function Create Selected
    //Parameters : Function Parameter
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaVslDropdown($ptRntID,$ptIDname,$poData){
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
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaVslAddEvent(){
        try{

            $nCountBranch   = $this->input->post("oetCountBranchVSL");
            $tBranchCode    = $this->input->post("oetBranchCodeVSL");
            $tTypepage      = $this->input->post("ohdTypepageVSL");

            if($tTypepage == 'Add'){
                if($nCountBranch >= 1){
                    $aBranchCode = explode(",",$tBranchCode);

                    for($i=0; $i<$nCountBranch; $i++){

                        $aDataMaster    = array(
                            'FTBchCode'     => trim($aBranchCode[$i]),
                            'FTShpCode'     => $this->input->post('oetShopCodeVSL'),
                            'FCLayRowQty'   => $this->input->post('oetVstRowQty'),
                            'FCLayColQty'   => $this->input->post('oetVstColQty'),
                            'FTLayStaUse'   => 1,
                            'FDCreateOn'    => date('Y-m-d H:i:s'),
                            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                            'FNLngID'       => $this->session->userdata("tLangEdit"),
                            'FTLayName'     => $this->input->post('oetLayName'),
                            'FTLayRemark'   => $this->input->post('oetLayRemark') 
                        );
        
                        $oCountDup  = $this->mVendingshoplayout->FSoMVslCheckDuplicate($aDataMaster['FTShpCode'],$aDataMaster['FTBchCode']);
                        $nStaDup    = $oCountDup[0]->counts;
        
                        if($nStaDup == 0){
                            $this->db->trans_begin();
                            $aStaVslMaster  = $this->mVendingshoplayout->FSaMVslAddUpdateMaster($aDataMaster);
                            $aStaVslLang    = $this->mVendingshoplayout->FSaMVslAddUpdateLang($aDataMaster);
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
                                    'tCodeReturn'	=> $aDataMaster['FTShpCode'],
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
                }
            }else if($tTypepage == 'Edit'){
                $aDataMaster    = array(
                    'FTShpCode'     => $this->input->post('oetShopCodeVSL'),
                    'FCLayRowQty'   => $this->input->post('oetVstRowQty'),
                    'FCLayColQty'   => $this->input->post('oetVstColQty'),
                    'FTLayStaUse'   => 1,
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'FTLayName'     => $this->input->post('oetLayName'),
                    'FTLayRemark'   => $this->input->post('oetLayRemark')
                );

                //จำนวนชั้นเก่า
                $nOldRow = $this->input->post('ohdOldRowQty');
                //จำนวนชั้นใหม่
                $nNewRow = $this->input->post('oetVstRowQty');
                if($nNewRow < $nOldRow){
                    $this->mVendingshoplayout->FSaMVslDeleteProduct($aDataMaster,'ROW');
                }

                $this->db->trans_begin();
                $aStaVslMaster  = $this->mVendingshoplayout->FSaMVslAddUpdateMaster($aDataMaster);
                $aStaVslLang    = $this->mVendingshoplayout->FSaMVslAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTShpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Vending
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 19/09/2019 Supawat
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaVslEditEvent(){

        $tTypepage      = $this->input->post("ohdTypepageVSL");

        try{
            if($tTypepage == 'Edit'){
                $aDataMaster    = array(
                    'FTBchCode'     => $this->input->post('oetBranchCodeVSL'),
                    'FTShpCode'     => $this->input->post('oetShopCodeVSL'),
                    'FCLayRowQty'   => $this->input->post('oetVstRowQty'),
                    'FCLayColQty'   => $this->input->post('oetVstColQty'),
                    'FTLayStaUse'   => 1,
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'FTLayName'     => $this->input->post('oetLayName'),
                    'FTLayRemark'   => $this->input->post('oetLayRemark')
                );

                //จำนวนชั้นเก่า
                $nOldRow = $this->input->post('ohdOldRowQty');
                //จำนวนชั้นใหม่
                $nNewRow = $this->input->post('oetVstRowQty');
                if($nNewRow < $nOldRow){
                    $this->mVendingshoplayout->FSaMVslDeleteProduct($aDataMaster,'ROW');
                }

                $this->db->trans_begin();
                $aStaVslMaster  = $this->mVendingshoplayout->FSaMVslAddUpdateMaster($aDataMaster);
                $aStaVslLang    = $this->mVendingshoplayout->FSaMVslAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTShpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //กดปุ่มยืนยัน case ที่ช่องน้อยกว่าเดิม delete product
    public function FSaVSLEditEventandDeleteCol(){
        $tTypepage      = $this->input->post("ohdTypepageVSL");

        try{
            if($tTypepage == 'Edit'){
                $aDataMaster    = array(
                    'FTBchCode'     => $this->input->post('oetBranchCodeVSL'),
                    'FTShpCode'     => $this->input->post('oetShopCodeVSL'),
                    'FCLayRowQty'   => $this->input->post('oetVstRowQty'),
                    'FCLayColQty'   => $this->input->post('oetVstColQty'),
                    'FTLayStaUse'   => 1,
                    'FDCreateOn'    => date('Y-m-d H:i:s'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FNLngID'       => $this->session->userdata("tLangEdit"),
                    'FTLayName'     => $this->input->post('oetLayName'),
                    'FTLayRemark'   => $this->input->post('oetLayRemark')
                );

                $this->db->trans_begin();
                $this->mVendingshoplayout->FSaMVslDeleteProduct($aDataMaster,'ALL');
                $aStaVslMaster  = $this->mVendingshoplayout->FSaMVslAddUpdateMaster($aDataMaster);
                $aStaVslLang    = $this->mVendingshoplayout->FSaMVslAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Edit Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTShpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Vending
    //Parameters : Ajax jvendingshoplayout()
    //Creator : 28/05/2018 Supawat
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaVslDeleteEvent(){

        $tType = $this->input->post('tType');
        if($tType == 'Multidelete'){
            $aPackdata = $this->input->post('tIDCode');
            $nPackdata = FCNnHSizeOf($aPackdata);
            for($i=0; $i<$nPackdata; $i++){
                $aDataDelete = explode("&&",$aPackdata[$i]);
                $aDataMaster = array(
                    'FTShpCode' => $aDataDelete[0],
                    'FTBchCode' => $aDataDelete[1]
                );
                $tAPIReq        = 'API/mVendingshoplayout/Delete';
                $tMethodReq     = 'POST';
                $aResDel        = $this->mVendingshoplayout->FSnMVslDel($tAPIReq,$tMethodReq,$aDataMaster);
            }
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }else if($tType == 'Singledelete'){
            $aDataMaster = array(
                'FTShpCode' => $this->input->post('tIDCode'),
                'FTBchCode' => $this->input->post('ptBch')
            );
            $tAPIReq        = 'API/mVendingshoplayout/Delete';
            $tMethodReq     = 'POST';
            $aResDel        = $this->mVendingshoplayout->FSnMVslDel($tAPIReq,$tMethodReq,$aDataMaster);
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }
    }

}
