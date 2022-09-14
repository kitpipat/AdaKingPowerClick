<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCompany extends MX_Controller {

	public function __construct() {
		parent::__construct ();
		$this->load->model('company/company/mCompany');
	}
	
	public function index($nCmpBrowseType,$tCmpBrowseOption) {
		$aAlwEventCompany	= FCNaHCheckAlwFunc('company/0/0');
		$vBtnSave			= FCNaHBtnSaveActiveHTML('company/0/0');
		$this->load->view ('company/company/wCompany', array (
			'aAlwEventCompany'	=> $aAlwEventCompany,
			'vBtnSave'			=> $vBtnSave,
			'nCmpBrowseType'	=> $nCmpBrowseType,
			'tCmpBrowseOption'	=> $tCmpBrowseOption,
			'aAlwEventCompany'	=> $aAlwEventCompany
		));
	}
	
	//Functionality : Function CallPage Company
	//Parameters : Ajax
	//Creator : 10/04/2019 pap
	//Last Modified : 04/09/2019 Wasin(Yoshi)
	//Return : String View
	//Return Type : View
	public function FSoCCMPListPage(){
		try{
			$nLangResort    = $this->session->userdata("tLangID");
			$nLangEdit      = $this->session->userdata("tLangEdit");
			
			$aData  = array(
				'FNLngID'       => $nLangEdit,
			);

			$tAPIReq    = "";
			$tMethodReq = "GET";
			$aResList	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aData);


			if($aResList['rtCode'] == '1'){
				$tBchCode   = $aResList['raItems']['rtCmpBchCode'];
				$tCmpCode   = $aResList['raItems']['rtCmpCode'];
			}else{
				$tBchCode   = "";
				$tCmpCode   = "";
			}

			$nCnfAddVersion		= FCNaHAddressFormat('TCNMComp');
			$aCmpAddressData	= [];
			if(isset($tBchCode) && !empty($tBchCode)){
				$aDataAddrWhere  = [
					'FTAddRefCode'  => $tBchCode,
					'FNLngID'       => $nLangEdit,
					'FTAddGrpType'  => 1,
					'FTAddVersion'	=> $nCnfAddVersion
				];
				$aCmpAddressData	= $this->mCompany->FSaMCMPSelectAddressList($aDataAddrWhere);
			}


			$aVatList			= FCNoHCallVatlist();
			$aAlwEventCompany	=  FCNaHCheckAlwFunc('company/0/0');
			$aDataViewConfig	= array(
				'aCompData'     	=> $aResList,
				'aCompAddress'	=> $aCmpAddressData,
				'aVatRate'			=> $aVatList,
				'aAlwEventCompany'	=>$aAlwEventCompany,
				'tImgComp'      	=> $aResList['raItems']['rtCmpImage']
			);

			$tCompanyListView = $this->load->view('company/company/wCompanyList',$aDataViewConfig,true);

			$aReturnData        = array(
                'nStaEvent'			=> 1,
                'tStaMessg'			=> 'Success',
                'tCompanyListView'	=> $tCompanyListView,
            );
		}catch(Exception $Error){
			$aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
		}
		echo json_encode($aReturnData);
	}
    
	//Functionality : Function CallPage Company Edit
	//Parameters : Ajax
	//Creator : 05/04/2018 wasin(yoshi)
	//Last Modified : 04/09/2019 Wasin(Yoshi)
	//Return : String View
	//Return Type : View
	public function FSoCCMPEditPage(){
		try{
			$nLangResort	= $this->session->userdata("tLangID");
            $nLangEdit		= $this->session->userdata("tLangEdit");
			$aData			= array(
				'FNLngID'   => $nLangEdit,
			);

			$tAPIReq		= "";
			$tMethodReq		= "GET";
			$aResList		= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aData);

			if($aResList['rtCode'] == '1'){
				$tBchCode   = $aResList['raItems']['rtCmpBchCode'];
				$tCmpCode   = $aResList['raItems']['rtCmpCode'];
				$tVatCode   = $aResList['raItems']['rtVatCodeUse'];
			}else{
				$tBchCode   = "";
				$tCmpCode   = "";
				$tVatCode   = "";
			}

			$aVatList		= FCNoHCallVatlist();
			$aResultVatList = $this->mCompany->FSoMCMPGetVatRate($tVatCode);

			$aDataViewConfig	= [
				'aCompData'		=> $aResList,
				'aVatRate'		=> $aVatList,
				'aVatList'		=> $aResultVatList,
				'tImgObjAll'	=> $aResList['raItems']['rtCmpImage'],
			];
			$tCompanyForm	= $this->load->view('company/company/wCompanyForm',$aDataViewConfig,true);
			$aReturnData	= array(
                'nStaEvent'			=> 1,
                'tStaMessg'			=> 'Success',
                'tCompanyFormView'	=> $tCompanyForm,
            );
		}catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
		}
		echo json_encode($aReturnData);
	}
	
	//Functionality : Function Add Company
	//Parameters : Ajax
	//Creator : 23/05/2018 wasin
	//Last Modified : -
	//Return :
	//Return Type:
	public function FSoCMPAddEvent(){
		try{
			$this->db->trans_begin();
			$tCompImageOld	= trim($this->input->post('oetImgInputCompanyOld'));
			$tCompImage		= trim($this->input->post('oetImgInputCompany'));
			$aDataMaster	= [
				'FTCmpCode'			=> '00001',
				'FTCmpTel'			=> $this->input->post('oetCmpTel'),
				'FTCmpFax'			=> $this->input->post('oetCmpFax'),
				'FTBchcode'			=> $this->input->post('oetCmpBchCode'),
				'FTCmpWhsInOrEx'	=> $this->input->post('ocmCmpWhsInOrEx'),
				'FTCmpRetInOrEx'	=> $this->input->post('ocmCmpRetInOrEx'),
				'FTCmpEmail'		=> $this->input->post('oetCmpEmail'),
				'FTRteCode'			=> $this->input->post('oetCmpRteCode'),
				'FTVatCode'			=> $this->input->post('oetVatRateCode'),
				'FTCmpName'			=> $this->input->post('oetCmpName'),
				'FTCmpShop'			=> $this->input->post('oetCmpShop'),
				'FTCmpDirector'		=> $this->input->post('oetCmpDirector'),
				'FTLastUpdBy'		=> $this->session->userdata('tSesUsername'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsername'),
				'FNLngID'			=> $this->session->userdata("tLangEdit")
			];

			$this->mCompany->FSaMCMPAddUpdateMaster($aDataMaster);
			$this->mCompany->FSaMCMPAddUpdateLang($aDataMaster);
			// Check Trancetion Event Company
			if($this->db->trans_status() !== FALSE){
				$this->db->trans_commit();
				if($tCompImage != $tCompImageOld){
					$aImageUplode = array(
						'tModuleName'       => 'company',
						'tImgFolder'        => 'company',
						'tImgRefID'         => $aDataMaster['FTCmpCode'],
						'tImgObj'           => $tCompImage,
						'tImgTable'         => 'TCNMComp',
						'tTableInsert'      => 'TCNMImgObj',
						'tImgKey'           => 'main',
						'dDateTimeOn'       => date('Y-m-d H:i:s'),
						'tWhoBy'            => $this->session->userdata('tSesUsername'),
						'nStaDelBeforeEdit' => 1
					);
					$aImgReturn = FCNnHAddImgObj($aImageUplode);
				}
				$aReturnData	= array(
					'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
					'nStaEvent'	    => 1,
					'tStaMessg'		=> 'Success Update Company.'
				);
			}else{
				$this->db->trans_rollback();
                throw new Exception(array(
                    'nCodeReturn'   => 500,
                    'tTextStaMessg' => 'Error Not Add/Update Data Company.',
                )); 
			}
		}catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
		}
		echo json_encode($aReturnData);
	}
	
	// Functionality : Function Edit Company
	// Parameters : Ajax
	// Creator : 07/05/2018 wasin
	// Update : 11/04/2019 pap
	// Return :
	// Return Type:
	public function FSoCMPEditEvent(){
		try{
			$this->db->trans_begin();
			$tCompImageOld	= $this->input->post('oetImgInputCompanyOld');
			$tCompImage		= $this->input->post('oetImgInputCompany');
			$aDataMaster	= [
				'FTCmpCode'			=> $this->input->post('oetCmpCode'),
				'FTCmpTel'			=> $this->input->post('oetCmpTel'),
				'FTCmpFax'			=> $this->input->post('oetCmpFax'),
				'FTBchcode'			=> $this->input->post('oetCmpBchCode'),
				'FTCmpWhsInOrEx'	=> $this->input->post('ocmCmpWhsInOrEx'),
				'FTCmpRetInOrEx'	=> $this->input->post('ocmCmpRetInOrEx'),
				'FTCmpEmail'		=> $this->input->post('oetCmpEmail'),
				'FTRteCode'			=> $this->input->post('oetCmpRteCode'),
				'FTVatCode'			=> $this->input->post('oetVatRateCode'),
				'FTCmpName'			=> $this->input->post('oetCmpName'),
				'FTCmpShop'			=> $this->input->post('oetCmpShop'),
				'FTCmpDirector'		=> $this->input->post('oetCmpDirector'),
				'FTLastUpdBy'		=> $this->session->userdata('tSesUsername'),
				'FTCreateBy'		=> $this->session->userdata('tSesUsername'),
				'FNLngID'			=> $this->session->userdata("tLangEdit")
			];
			$this->mCompany->FSaMCMPAddUpdateMaster($aDataMaster);
			$this->mCompany->FSaMCMPAddUpdateLang($aDataMaster);
			// Check Trancetion Event Company
			if($this->db->trans_status() !== FALSE){
				$this->db->trans_commit();
				if($tCompImage != $tCompImageOld){
					$aImageUplode = array(
						'tModuleName'       => 'company',
						'tImgFolder'        => 'company',
						'tImgRefID'         => $aDataMaster['FTCmpCode'],
						'tImgObj'           => $tCompImage,
						'tImgTable'         => 'TCNMComp',
						'tTableInsert'      => 'TCNMImgObj',
						'tImgKey'           => 'main',
						'dDateTimeOn'       => date('Y-m-d H:i:s'),
						'tWhoBy'            => $this->session->userdata('tSesUsername'),
						'nStaDelBeforeEdit' => 1
					);
					$aImgReturn = FCNnHAddImgObj($aImageUplode);
				}
				$aReturnData	= array(
					'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
					'nStaEvent'	    => 1,
					'tStaMessg'		=> 'Success Update Company.'
				);
			}else{
				$this->db->trans_rollback();
                throw new Exception(array(
                    'nCodeReturn'   => 500,
                    'tTextStaMessg' => 'Error Not Add/Update Data Company.',
                )); 
			}
		}catch(Exception $Error){
			$aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
		}
		echo json_encode($aReturnData);
	}
		

	// Functionality : Function GetName Company
	// Parameters : Ajax
	// Creator : 24/07/2019 saharat(Golf)
	// Return : array
	// Return Type : array
	public function FSvCMPGetName(){
		try{
			$nLangEdit      = $this->session->userdata("tLangEdit");
			$aData  = array(
				'FNLngID'       => $nLangEdit,
			);
			$aResList = $this->mCompany->FSaMCMPGetName($aData);
			echo json_encode($aResList);
		}catch(Exception $Error){
			echo $Error;
		}
	}

	// Functionality : Call Address Company
	// Parameters : Ajax
	// Creator : 
	// Return :
	// Return Type:
	public function FSoCMPCallAddress(){
		try{
			$aDataAddrWhere = [
				'FNLngID'		=> $this->input->post('ptAddLngId'),
				'FTAddGrpType'	=> $this->input->post('ptAddGrpType'),
				'FTAddRefCode'	=> $this->input->post('ptAddRefCode'),
				'FNAddSeqNo'	=> $this->input->post('ptAddSeqNo')
			];
			$aDataConfigView	= [
				'aDataAddress' => $this->mCompany->FSaMGetDataAddress($aDataAddrWhere)
			];

			$tViewModalAddrInfo	= $this->load->view('company/company/address/wCompanyModalAddrInfo',$aDataConfigView,true);
			$tViewModalAddrMap	= $this->load->view('company/company/address/wCompanyModalAddrMap',$aDataConfigView,true);

			$aReturnData    = array(
				'nStaEvent'	=> 1,
				'tStaMessg'	=> 'Success',
				'tViewModalAddrInfo'	=> $tViewModalAddrInfo,
				'tViewModalAddrMap'		=> $tViewModalAddrMap
			);
		}catch(Exception $Error){
			$aReturnData    = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
		}
		echo json_encode($aReturnData);
	}






























}
