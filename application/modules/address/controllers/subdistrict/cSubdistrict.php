<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSubdistrict extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('address/subdistrict/mSubdistrict');
    }

    public function index($nSdtBrowseType,$tSdtBrowseOption){
        $nMsgResp = array('title'=>"SubDistrict");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('subdistrict/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventSubdistrict	= FCNaHCheckAlwFunc('subdistrict/0/0');
        $this->load->view ( 'address/subdistrict/wSubdistrict', array (
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nSdtBrowseType'        => $nSdtBrowseType,
            'tSdtBrowseOption'      =>  $tSdtBrowseOption,
            'aAlwEventSubdistrict'  => $aAlwEventSubdistrict
        ));
    }

    //Functionality : Function Call Subdistrict Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSDTListPage(){
        $aAlwEventSubdistrict	= FCNaHCheckAlwFunc('subdistrict/0/0');
		$aNewData  			= array( 'aAlwEventSubdistrict' => $aAlwEventSubdistrict );
        $this->load->view('address/subdistrict/wSubdistrictList',$aNewData);
    }

    //Functionality : Function Call DataTables Subdistrict List
    //Parameters : Ajax jProvince()
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSDTDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMSubDistrict_L');
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
        $aDataList  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
        $aResList   = $this->mSubdistrict->FSaMSDTList($aDataList);

        $aAlwEvent = FCNaHCheckAlwFunc('subdistrict/0/0'); //Controle Event

        $aGenTable  = array(
            'aAlwEventSubdistrict' 	=> $aAlwEvent,
            'aDataList'             => $aResList,
            'nPage'                 => $nPage,
            'tSearchAll'            => $tSearchAll
        );
        $this->load->view('address/subdistrict/wSubdistrictDataTable',$aGenTable);
    }

    //Functionality : Function CallPage Subdistrict Add
    //Parameters : Ajax Call Page Function
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSDTAddPage(){
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );
        $this->load->view('address/subdistrict/wSubdistrictAdd',$aDataAdd);
    }

    //Functionality : Function CallPage Subdistrict Edit
    //Parameters : Ajax Call Page Function
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvSDTEditPage(){
        $tSdtCode       = $this->input->post('tSdtCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMSubDistrict_L');
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
            'FTSudCode' => $tSdtCode,
            'FNLngID'   => $nLangEdit
        );
        $aResList       = $this->mSubdistrict->FSaMSDTSearchByID($aData);
        $aDataEdit      = array('aResult' => $aResList);
        $this->load->view('address/subdistrict/wSubdistrictAdd',$aDataEdit);
    }

    //Functionality : Function Event Add Subdistrict
    //Parameters : Ajax Function Add User
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Add And Status Call Back Event
    //Return Type : object
    Public function FSoSDTAddEvent(){
        try{

            $tIsAutoGenCode =   $this->input->post('ocbSubdistrictAutoGenCode');
            // Setup Reason Code

            $tSdtCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){

                $aStoreParam = array(
                    "tTblName"    => 'TCNMSubDistrict',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );

                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tSdtCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMSubDistrict');
                // if($aGenCode['rtCode'] == '1'){
                //    $tSdtCode = $aGenCode['rtSudCode'];
                // }
            }else{
                $tSdtCode = $this->input->post('oetSdtCode');
            }

            $aDataMaster = array(            
                'FTSudCode'         => $tSdtCode,
                'FTDstCode'         => $this->input->post('oetSdtDstcode'),
                'FTSudLatitude'     => $this->input->post('oetSdtMapLat'),
                'FTSudLongitude'    => $this->input->post('oetSdtMapLong'),
                'FTSudName'         => $this->input->post('oetSdtName'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );


            $oCountDup  = $this->mSubdistrict->FSnMSDTCheckDuplicate($aDataMaster['FTSudCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaSdtMaster  = $this->mSubdistrict->FSaMSDTAddUpdateMaster($aDataMaster);
                $aStaSdtLang    = $this->mSubdistrict->FSaMSDTAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTSudCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add'
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

    //Functionality : Function Event Edit Subdistrict
    //Parameters : Ajax Function Edit User
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Edit And Status Call Back Event
    //Return Type : object
    public function FSoSDTEditEvent(){
        try{
            $aDataMaster = array(
                'FTSudCode'         => $this->input->post('oetSdtCode'),
                'FTDstCode'         => $this->input->post('oetSdtDstcode'),
                'FTSudLatitude'     => $this->input->post('oetSdtMapLat'),
                'FTSudLongitude'    => $this->input->post('oetSdtMapLong'),
                'FTSudName'         => $this->input->post('oetSdtName'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $this->db->trans_begin();
            $aStaSdtMaster  = $this->mSubdistrict->FSaMSDTAddUpdateMaster($aDataMaster);
            $aStaSdtLang    = $this->mSubdistrict->FSaMSDTAddUpdateLang($aDataMaster);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'tStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Subdistrict"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTSudCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Event Delete Subdistrict
    //Parameters : Ajax Function Delete Subdistrict
    //Creator : 12/06/2018 wasin
    //Last Modified : -
    //Return : Status Event Delete And Status Call Back Event
    //Return Type : object
    public function FSoSDTDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTSudCode' => $tIDCode
        );
        $aResDel        = $this->mSubdistrict->FSaMSDTDel($aDataMaster);
        $nNumRowSudLoc  = $this->mSubdistrict->FSnMLOCGetAllNumRow();

        if($nNumRowSudLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowSudLoc' => $nNumRowSudLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "Error database";
        }
    }
}