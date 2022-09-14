<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cBranch extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('eticket/branch/mBranch', 'oBranch');
        $this->load->library("session");
    }

    public function index($nBrowseType,$tBrowseOption){

		$aBrowseType = explode("-",$nBrowseType);
		if(isset($aBrowseType[1])){
			$nBrowseType = $aBrowseType[0];
			$tRouteFromName = $aBrowseType[1];
		}else{
			$nBrowseType = $nBrowseType;
			$tRouteFromName = '';
		}
		
		//Controle Event
		$aAlwEventBranch 	= FCNaHCheckAlwFunc('branch/0/0');
		$aAlwEventShop 		= FCNaHCheckAlwFunc('shop/0/0');
		//Controle Event
		$vBtnSaveBranch 	= FCNaHBtnSaveActiveHTML('branch/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
		$vBtnSaveShop		= FCNaHBtnSaveActiveHTML('shop/0/0'); 
		$this->load->view ('company/branch/wBranch',array(
            'aAlwEventBranch'   => $aAlwEventBranch,
            'aAlwEventShop'		=> $aAlwEventShop,
            'vBtnSaveBranch'    => $vBtnSaveBranch,
            'vBtnSaveShop' 		=> $vBtnSaveShop,
            'nBrowseType'       =>$nBrowseType,
            'tBrowseOption'		=>$tBrowseOption,
            'tRouteFromName'    =>$tRouteFromName
		));
	}

   	//Functionality : Function CallPage Branch Add
	//Parameters : Ajax jReason()
	//Creator : 03/04/2018 Krit(Copter)
	//Last Modified : -
	//Return : String View
	//Return Type : View
	public function FSvCBCHAddPage(){
		$aCnfAddPanal 		= $this->FSvCBCHGenViewAddress();
		$aAlwEvent 			= FCNaHCheckAlwFunc('branch/0/0');
		
		$aCnfAddVersion  = FCNaHAddressFormat('TCNMBranch');
		$nSysStaDefValue = $aCnfAddVersion;
		$nSysStaUsrValue = $aCnfAddVersion;
		
		if($nSysStaUsrValue != ''){
			$nCnfAddVersion = $nSysStaUsrValue; //ถ้า Sys User มีค่าจะใช้ค่าของ UserValue
		}else{
			$nCnfAddVersion = $nSysStaDefValue; //ถ้า Sys User ไม่มีค่าจะใช้ค่าของ DefValue
		}
		
		$aDataEdit = array(
				'aResult' 			=> array('rtCode' => '99'),
				'aCnfAddPanal' 		=> $aCnfAddPanal,
				'nCnfAddVersion' 	=> $nCnfAddVersion,
				'aAlwEventBranch' 	=> $aAlwEvent
		);
		$this->load->view('company/branch/wBranchAdd',$aDataEdit);

	}
    
	//Functionality : Function Call DataTables Branch
    //Parameters : Ajax jBranch()
    //Creator : 05/06/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCBCHDataList(){

		$aAlwEvent  = FCNaHCheckAlwFunc('branch/0/0'); //Controle Event
		
        $nPage      = $this->input->post('nPageCurrent');
		$tSearchAll = $this->input->post('tSearchAll');
		
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    $aLangHave      = FCNaHGetAllLangByTable('TCNMBranch_L');
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
			'FTBchCode'		=> $this->session->userdata("tSesUsrBchCodeOld"),
            'nPage'         => $nPage,
            'nRow'          => 5,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

		$aResList = $this->mBranch->FSnMBCHList($aData);
	
        $aGenTable  = array(
			'aAlwEventBranch' 	=> $aAlwEvent,
            'aDataList' 		=> $aResList,
            'nPage'    			=> $nPage,
            'tSearchAll'    	=> $tSearchAll
        );
        $this->load->view('company/branch/wBranchDataTable',$aGenTable);
    }

    // นับจำนวนสาขา
    public function FStCPRKAjaxSearch() {
        $tFTPmoName = $this->input->post('tFTPmoName');
        $oParkCntSh = $this->oBranch->FSaMPRKSearchFCNnHSizeOf($tFTPmoName);
        $tParkCount = $oParkCntSh [0]->counts;
        echo $tParkCount;
    }

    /**
     * FS เพิ่มสาขา
     */
    public function FSxCPRKAdd() {
        $oArea = $this->oBranch->FSxMPRKArea();
        $oProvince = $this->oBranch->FSxMPRKProvince();
        $oDistrict = $this->oBranch->FSxMPRKDistrict();
        $this->load->view('eticket/branch/wAdd', array(
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict
        ));
    }

    public function FSxCPRKAddAjax() {
        $tPmoNameOth = $this->input->post('oetPmoNameOth');
        $tParkName = $this->input->post('oetParkName');
        $aData = array(
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s'),
            'FTWhoUpd' => $this->session->userdata("username"),
            'FTWhoIns' => $this->session->userdata("username"),
            'FDDateIns' => date('Y-m-d'),
            'FTTimeIns' => date('h:i:s')
        );
        $aName = array(
            'FTPmoName' => $tParkName,
            'FTPmoNameOth' => $tPmoNameOth
        );
        $nBranchID = $this->oBranch->FSxMPRKSave($aData);
        $nLocID = $this->oBranch->FSxMPRKSaveLoc($aName);
        $this->oBranch->FSxMPRKSaveModelL($aName);
        if ($this->input->post('ohdModelImg')) {
            $tImg = $this->input->post('ohdModelImg');
            FSaHAddImgObj($nBranchID, 1, 'TTKMImgPdt', 1, 'main', $tImg, 'eticket/branch');
            FSaHAddImgObj($nLocID, 1, 'TTKMImgObj', 2, 'main', $tImg, 'eticket/location');
        }
        if ($this->input->post('ohdFNAreID')) {
            $tFNAreID = $this->input->post('ohdFNAreID');
            $tFNPvnID = $this->input->post('ohdFNPvnID');
            $tFNDstID = $this->input->post('ohdFNDstID');
            foreach ($tFNAreID as $key => $tValue) {
                $aData = array(
                    'FTAreCode' => $tFNAreID [$key],
                    'FTPvnCode' => $tFNPvnID [$key],
                    'FTDstCode' => $tFNDstID [$key]
                );
                $this->oBranch->FSxMPRKAddAre($aData);
            }
        }
        echo $nBranchID;
    }

    public function FSxCPRKEdit($nID) {
        $oArea = $this->oBranch->FSxMPRKArea();
        $oProvince = $this->oBranch->FSxMPRKProvince();
        $oDistrict = $this->oBranch->FSxMPRKDistrict();
        $oCPRKEdit = $this->oBranch->FSxMPRKEdits($nID);
        // $oCPRKLocL = $this->oPark->FSxMPRKLocL($tName);
        $this->load->view('eticket/branch/wEdit', array(
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict,
            'oCPRKEdit' => $oCPRKEdit
        ));
        // 'oCPRKLocL' => $oCPRKLocL,
    }

    /**
     * FS แก้ไขสาขา
     */
    public function FSxCPRKEditAjax() {
        $tParkID = $this->input->post('ohdFNPmoID');
        $tParkName = $this->input->post('oetFTPmoName');
        $tFTPmoNameOth = $this->input->post('oetFTPmoNameOth');
        //$tFNLocID = $this->input->post('ohdFNLocID');
        $aData = array(
            'FNPmoID' => $tParkID,
            // 'FNLocID' => $tFNLocID,
            'FTPmoName' => $tParkName,
            'FTPmoNameOth' => $tFTPmoNameOth,
            'FDDateUpd' => date('Y-m-d'),
            'FTTimeUpd' => date('h:i:s'),
            'FTWhoUpd' => $this->session->userdata("username")
        );

        $this->oBranch->FSxMPRKEdit($aData);
        $this->oBranch->FSxMPRKEditModelL($aData);
        if ($this->input->post('ohdModelImg')) {
            $tImg = $this->input->post('ohdModelImg');
            FSaHUpdateImgObj($tParkID, 'TTKMImgPdt', 1, 'main', $tImg, 'branch');
        }
        /*
         * if ($this->input->post('ohdFNAreID')) {
         * $tFNAreID = $this->input->post('ohdFNAreID');
         * $tFNPvnID = $this->input->post('ohdFNPvnID');
         * $tFNDstID = $this->input->post('ohdFNDstID');
         * foreach ($tFNAreID as $key => $tValue) {
         * $aData = array(
         * 'FTAreCode' => $tFNAreID[$key],
         * 'FTPvnCode' => $tFNPvnID[$key],
         * 'FTDstCode' => $tFNDstID[$key],
         * 'FNLocID' => $tFNLocID,
         * );
         * $this->oPark->FSxMPRKAddAre2($aData);
         * }
         * }
         */
    }

    /**
     * FS ลบสาขา
     */
    public function FSxCPRKDelete() {
        if ($this->input->post('tParkId')) {
            $tParkID = $this->input->post('tParkId');
            $oLoc = $this->oBranch->FSxMPRKLocGetID($tParkID);
            $o = $this->oBranch->FSxMPRKDelete($tParkID);
            $aJson = array(
                'tParkId' => $tParkID,
                'count' => $o,
                'msg' => language('ticket/center/center', 'CheckDel')
            );
            if ($o == 0) {
                FSaDelImg($tParkID, 'TTKMImgPdt', 1, 'main', 'branch');
                FSaDelImg($oLoc[0]->FNLocID, 'TTKMImgObj', 2, 'main', 'location');
            }
            echo json_encode($aJson);
        }
    }

    /**
     * แสดงรายละเอียดสาขา
     */
    public function FSxCPRKDetail() {
        $aData = array(
            'tParkImg' => $this->input->post('tParkImg'),
            'tParkName' => $this->input->post('tParkName'),
            'tParkId' => $this->input->post('tParkId')
        );
        $oDetail = $this->oBranch->FSxMPRKDetail($aData);
        $oModel = $this->oBranch->FSxMPRKModel();

        $oArea = $this->oBranch->FSxMPRKArea();
        $oProvince = $this->oBranch->FSxMPRKProvince();
        $oDistrict = $this->oBranch->FSxMPRKDistrict();

        $oLoc = $this->oBranch->FSxMPRKLoc($aData);
        $this->load->view('eticket/branch/wParkDetail', array(
            'tDetail' => $oDetail,
            'tParkImg' => $this->input->post('tParkImg'),
            'tParkName' => $this->input->post('tParkName'),
            'tParkId' => $this->input->post('tParkId'),
            'oModel' => $oModel,
            'oLoc' => $oLoc,
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict
        ));
    }

    public function FSxCPRKDistrict() {
        if ($this->input->post('ocmFNPvnID')) {
            $tFNPvnID = $this->input->post('ocmFNPvnID');
            $oDistrict = $this->oBranch->FSxMPRKDistrictAjax($tFNPvnID);
            foreach ($oDistrict as $tValue) {
                echo '<option value="' . $tValue->FTDstCode . '">' . $tValue->FTDstName . '</option>';
            }
        }
    }

    public function FSxCPRKProvince() {
        if ($this->input->post('ocmFNAreID')) {
            $tFNAreID = $this->input->post('ocmFNAreID');
            $oProvince = $this->oBranch->FSxMPRKProvinceAjax($tFNAreID);
            if (@$oProvince[0]->FTPvnCode != '') {
                foreach ($oProvince as $key => $oValue) {
                    echo '<option value="' . $oValue->FTPvnCode . '"' . ($key == 0 ? " selected" : "") . '>' . $oValue->FTPvnName . '</option>';
                }
            }
        }
    }

    public function FSxCPRKDelImgPrk() {
        if ($this->input->post('tImgID')) {
            $ptNameImg = $this->input->post('tNameImg');
            $ptImgID = $this->input->post('tImgID');
            $ptImgType = $this->input->post('tImgType');
            FSaHDelImgObj($ptImgID, 'TTKMImgPdt', $ptNameImg);
        }
    }

    public function FSxCPRKCheck() {
        if ($this->input->post('oetParkName')) {
            $tData = array(
                'FTPmoName' => $this->input->post('oetParkName')
            );
            $tCheck = $this->oBranch->FSxMPRKCheck($tData);

            if (@$tCheck [0]->counts > 0) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
    }

    public function FSaCBCHImportDataTable(){
        $aDataReturn = $this->mBranch->FSaMBCHGetTempData();
        $aDataImport = array(
            'aDataResult'   => $aDataReturn['aResult']
        );
        $this->load->view('company/branch/wBranchImportDataTable',$aDataImport);
    }

}

