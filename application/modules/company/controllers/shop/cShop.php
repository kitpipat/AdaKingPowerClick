<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShop extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
		$this->load->model('company/shop/mShop');
		date_default_timezone_set("Asia/Bangkok");
    }
    
    public function index($nShpBrowseType,$tShpBrowseOption,$tNameMenuGroup){
		$nMsgResp	= array('title' => "Shop");
        $isXHR		= isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ('common/wHeader', $nMsgResp);
            $this->load->view ('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ('common/wMenu', array ('nMsgResp'=>$nMsgResp));
		}

		$tPathCheck 	= 'shop/0/0/' . $tNameMenuGroup;
		$vBtnSave		= FCNaHBtnSaveActiveHTML($tPathCheck );
		$aAlwEventShop	= FCNaHCheckAlwFunc($tPathCheck);
		$this->load->view('company/shop/wShop',array(
			'nMsgResp' 			=> $nMsgResp,								  
			'vBtnSave' 			=> $vBtnSave,
			'nShpBrowseType'	=> $nShpBrowseType,
			'tShpBrowseOption'	=> $tShpBrowseOption,
			'aAlwEventShop'		=> $aAlwEventShop,
			'tNameMenuGroup'	=> $tNameMenuGroup
		));
	}
	
	//Functionality : Function CallPage List Master
	//Parameters : From Ajax File j
	//Creator : 18/06/2018 Krit(Copter)
	//Last Modified : -
	//Return : String View
	//Return Type : View
	public function FSvCSHPListPage(){
		$tNameMenuGroup = $this->input->post('tNameMenuGroup');
		$tPathCheck 	= 'shop/0/0/' . $tNameMenuGroup;
		$aAlwEventShop	= FCNaHCheckAlwFunc($tPathCheck);
		$aNewData		= array('aAlwEventShop' => $aAlwEventShop );
		$this->load->view('company/shop/wShopList',$aNewData);
	}

	//Functionality : Function Call DataTables Shop
    //Parameters : Ajax jBranch()
    //Creator : 18/06/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCSHPDataList(){
        $nPage      	= $this->input->post('nPageCurrent');
		$tSearchAll 	= $this->input->post('tSearchAll');
		$tNameMenuGroup = $this->input->post('tNameMenuGroup');

		if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
		if(!$tSearchAll){$tSearchAll='';}
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData 		 	= array(
			'FTBchCode' 	=> $this->session->userdata("tSesUsrBchCodeMulti"),
			'FTShpCode' 	=> $this->session->userdata("tSesUsrShpCodeMulti"),
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
			'tSearchAll'    => $tSearchAll,
			'tNameMenuGroup'=> $tNameMenuGroup
        );
		$aResList		= $this->mShop->FSaMSHPList($aData);
		$tPathCheck 	= 'shop/0/0/' . $tNameMenuGroup;
		$aAlwEventShop 	= FCNaHCheckAlwFunc($tPathCheck); 
        $aGenTable  	= array(
            'aDataList' 	=> $aResList,
            'nPage'     	=> $nPage,
			'tSearchAll'    => $tSearchAll,
			'aAlwEventShop'	=> $aAlwEventShop,
			'tNameMenuGroup'=> $tNameMenuGroup
        );
		$this->load->view('company/shop/wShopDataTable',$aGenTable);
    }
    
	//Functionality : Function CallPage Shop Add
	//Parameters : Ajax jShop()
	//Creator : 07/05/2018 Krit(Copter)
	//Last Modified : 15/07/2019 Wasin(Yoshi)
	//Return : String View
	//Return Type : View
    public function FSvCSHPAddPage(){
    	$tBchCode				= $this->input->post('tBchCode');
		$tStaPage				= $this->input->post('tStaPage');
		$tNameMenuGroup			= $this->input->post('tNameMenuGroup');
		$nStaShopAddress		= FCNaHAddressFormat('TCNMShop');
    	$aDataEdit 				= array(
			'tBchCode' 				=> $tBchCode,
			'tStaPage' 				=> $tStaPage,
			'nStaShopAddress'		=> $nStaShopAddress,
			'aResList'				=> array('rtCode' => '99'),
			'aGetDataShopAddress'	=> array('rtCode' => '99'),
			'tNameMenuGroup'		=> $tNameMenuGroup,
			'bIsAddPage' => true
    	);
    	$this->load->view('company/shop/wShopAdd',$aDataEdit);
    }
    
    //Functionality : Event Edit
    //Parameters : Ajax jShop()
    //Creator : 07/05/2018 Krit(Copter)
    //Last Modified : 15/07/2019 Wasin(Yoshi)
    //Return : Status ReasonEdit
    //Return Type : array
    public function FSvCSHPEditPage(){
		$tNameMenuGroup		= $this->input->post('tNameMenuGroup');
		$aAlwEventShop		= FCNaHCheckAlwFunc('shop/0/0/'. $tNameMenuGroup);
    	$tBchCode			= $this->input->post('tBchCode');
    	$tShpCode			= $this->input->post('tShpCode');
		$tStaPage			= $this->input->post('tStaPage');
		$nLangEdit			= $this->session->userdata("tLangEdit");
    	$aData	= [
			'FTShpCode' => $tShpCode,
			'FTBchCode' => $tBchCode,
			'FNLngID'   => $nLangEdit,
		];
		$aResList			= $this->mShop->FSaMSHPSearchByID($aData);
		if(isset($aResList['raItem']['rtImgObj']) && !empty($aResList['raItem']['rtImgObj'])){
			$tImgObj		= $aResList['raItem']['rtImgObj'];
			$aImgObj		= explode("application/modules/",$tImgObj);
			$aImgObjName	= explode("/",$tImgObj);
			$tImgObjAll		= $aImgObj[1];
			$tImgName		= end($aImgObjName);
		}else{
			$tImgObjAll		= "";
			$tImgName		= "";
		}
    	$aDataEdit	= [
			'tBchCode'		=> $tBchCode,
			'tStaPage'		=> $tStaPage,
			'tImgObjAll'	=> $tImgObjAll,
			'tImgName'		=> $tImgName,
			'aAlwEventShop'	=> $aAlwEventShop,
			'aResList'		=> $aResList,
			'tNameMenuGroup'=> $tNameMenuGroup,
			'bIsAddPage' => false
		];
    	$this->load->view('company/shop/wShopAdd',$aDataEdit);
	}

	//Functionality : Event Add Shop
    //Parameters : Ajax jShop()
    //Creator : 03/04/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaCSHPAddEvent(){
		try{
			$tImgInputShop		= trim($this->input->post('oetImgInputshop'));
			$tImgInputShopOld	= trim($this->input->post('oetImgInputshopOld'));
			$tIsAutoGenCode		= $this->input->post('ocbShopAutoGenCode');
			$tBchData			= $this->input->post('oetShpBchCode');
			$aBchData			= explode(",", $tBchData);
			$tShpStaShwPrice    = $this->input->post('ocbShpStaShwPrice');
			$tShpType    		= $this->input->post('ocmShpType');
			if($tShpType == "4"){
				if($tShpStaShwPrice == "on" ){$tStaShwPre = "1";}else{$tStaShwPre = "2";}
			}else{
				$tStaShwPre = "";
			}
			// check StaShwPrice เลือกเท่ากับ 1 ไม่เลือกเท่ากับ 2

			// Setup Shop Code
			$tShpCode = "";
			if(isset($tIsAutoGenCode) && $tIsAutoGenCode == 1){
				// Call Auto Gencode Helper
				$aStoreParam = array(
					"tTblName"   => 'TCNMShop',                           
					"tDocType"   => 0,                                          
					"tBchCode"   => trim($aBchData[0]),                                 
					"tShpCode"   => "",                               
					"tPosCode"   => "",                     
					"dDocDate"   => date("Y-m-d")       
				);
				$aAutogen   				= FCNaHAUTGenDocNo($aStoreParam);
				$tShpCode   				= $aAutogen[0]["FTXxhDocNo"];
			}else{
                $tShpCode = $this->input->post('oetShpCode');
			}
			$ImageShop	= $this->input->post('oetImgInputshop');

			//Open DB Trans Begin
			$this->db->trans_begin();
			
			for($i = 0; $i < FCNnHSizeOf($aBchData); $i++){
				$aDataMaster = array(
					'FTBchCodeOld'		=> trim($aBchData[$i]),
					'FTBchCode'     	=> trim($aBchData[$i]),
					'FTShpCode'     	=> $tShpCode,
					'ohdOldWahCode'		=> $this->input->post('ohdOldWahCode'),
					'FTMerCode'     	=> $this->input->post('oetShpMerCode'),
					'FTShpType'     	=> $this->input->post('ocmShpType'),
					'FTShpRegNo'     	=> $this->input->post('oetShpRegNo'),
					'FTShpRefID'     	=> $this->input->post('oetShpRefID'),
					'FDShpStart'     	=> FCNdHConverDate($this->input->post('oetShpStart')),
					'FDShpStop'     	=> FCNdHConverDate($this->input->post('oetShpStop')),
					'FDShpSaleStart'    => FCNdHConverDate($this->input->post('oetShpSaleStart')),
					'FDShpSaleStop'     => FCNdHConverDate($this->input->post('oetShpSaleStop')),
					'FTShpStaActive'    => $this->input->post('ocmShpStaActive'),
					'FTShpStaClose'     => $this->input->post('ocmShpStaClose'),
					'FDCreateOn' 		=> date('Y-m-d H:i:s'),
					'FDLastUpdOn' 		=> date('Y-m-d H:i:s'),
					'FTCreateBy'  		=> $this->session->userdata('tSesUsername'),
					'FTLastUpdBy'  		=> $this->session->userdata('tSesUsername'),
					'FNLngID'   		=> $this->session->userdata("tLangEdit"),
					'FTShpName'     	=> $this->input->post('oetShpName'),
					'FTShpStaShwPrice'  => $tStaShwPre,
					'FTPplCode' 		=> $this->input->post('oetBchPplRetCode')
				);

				$oCountDup	= $this->mShop->FSnMSHPCheckduplicate($aDataMaster['FTBchCode'],$aDataMaster['FTShpCode']);
				$nStaDup	= $oCountDup[0]->counts;

				if($nStaDup == 0){
					$this->mShop->FSaMSHPAddUpdateMaster('ADD',$aDataMaster);
					$this->mShop->FSaMSHPAddUpdateLang($aDataMaster);
				}

				
			}
			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$aReturnData = array(
					'nStaEvent'    => '900',
					'tStaMessg'    => "Unsucess Add Event"
				);
			}else{
				$this->db->trans_commit();
				// Check Image Old Compare Image New
				// if($tImgInputShop != $tImgInputShopOld){
				// 	$aImageUplode = array(
				// 		'tModuleName'       => 'company',
				// 		'tImgFolder'        => 'shop',
				// 		'tImgRefID'         => $tShpCode,
				// 		'tImgObj'           => $tImgInputShop,
				// 		'tImgTable'         => 'TCNMShop',
				// 		'tTableInsert'      => 'TCNMImgObj',
				// 		'tImgKey'           => 'main',
				// 		'dDateTimeOn'       => date('Y-m-d H:i:s'),
				// 		'tWhoBy'            => $this->session->userdata('tSesUsername'),
				// 		'nStaDelBeforeEdit' => 1
				// 	);
				// 	FCNnHAddImgObj($aImageUplode);
				// }
				$aReturnData = array(
					'nStaCallBack'		=> $this->session->userdata('tBtnSaveStaActive'),
					'tBchCodeReturn'	=> $tBchData,
					'tShopCodeReturn'	=> $aDataMaster['FTShpCode'],
					'nStaEvent'	    	=> '1',
					'tStaMessg'			=> 'Success Add Event'
				);
			}
		}catch(Exception $Error){
			$aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => 'Error FN.Add Shop => '.$Error->getMessage()
            );
		}
		echo json_encode($aReturnData);
    }
    
    //Functionality : Event Edit Shop
    //Parameters : Ajax jShop()
    //Creator : 03/04/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add
    //Return Type : array
    public function FSaCSHPEditEvent(){
		try{
			$tImgInputShop		= trim($this->input->post('oetImgInputshop'));
			$tImgInputShopOld	= trim($this->input->post('oetImgInputshopOld'));
			$tBchData			= $this->input->post('oetShpBchCode');
			$aBchData			= explode(",", $tBchData);
			$tShpCode			= $this->input->post('oetShpCode');
			$tShpStaShwPrice    = $this->input->post('ocbShpStaShwPrice');
			$tShpType    		= $this->input->post('ocmShpType');
			if($tShpType == "4"){
				if($tShpStaShwPrice == "on" ){$tStaShwPre = "1";}else{$tStaShwPre = "2";}
			}else{
				$tStaShwPre = "";
			}
			// Open DB Trans Begin
			$this->db->trans_begin();
			// $aDelete  	= $this->mShop->FSaMSHPRemoveB4Insert($tShpCode);
			for($i = 0; $i < FCNnHSizeOf($aBchData); $i++){
				$aDataMaster = array(
					'FTBchCodeOld'		=> $this->input->post('oetShpBchCodeHidden'),
					'FTBchCode'     	=> trim($aBchData[$i]),
					'FTShpCode'     	=> $tShpCode,
					'FTMerCode'     	=> $this->input->post('oetShpMerCode'),
					'FTShpType'     	=> $this->input->post('ocmShpType'),
					'FTShpRegNo'     	=> $this->input->post('oetShpRegNo'),
					'FTShpRefID'     	=> $this->input->post('oetShpRefID'),
					'FDShpStart'     	=> FCNdHConverDate($this->input->post('oetShpStart')),
					'FDShpStop'     	=> FCNdHConverDate($this->input->post('oetShpStop')),
					'FDShpSaleStart'    => FCNdHConverDate($this->input->post('oetShpSaleStart')),
					'FDShpSaleStop'     => FCNdHConverDate($this->input->post('oetShpSaleStop')),
					'FTShpStaActive'    => $this->input->post('ocmShpStaActive'),
					'FTShpStaClose'    => $this->input->post('ocmShpStaClose'),
					'FTImgLogo'     	=> $this->input->post('oetImgInputshop'),
					'FDCreateOn' 		=> date('Y-m-d H:i:s'),
					'FDLastUpdOn' 		=> date('Y-m-d H:i:s'),
					'FTCreateBy'  		=> $this->session->userdata('tSesUsername'),
					'FTLastUpdBy'  		=> $this->session->userdata('tSesUsername'),
					'FNLngID'   		=> $this->session->userdata("tLangEdit"),
					'FTShpName'     	=> $this->input->post('oetShpName'),
					'FTShpStaShwPrice'  => $tStaShwPre,
					'FTPplCode' 		=> $this->input->post('oetBchPplRetCode')
				);
				// print_r($aDataMaster);
				// exit;
				$this->mShop->FSaMSHPAddUpdateMaster('EDIT',$aDataMaster);
				$this->mShop->FSaMSHPAddUpdateLang($aDataMaster);
			}

			if($this->db->trans_status() === false){
				$this->db->trans_rollback();
				$aReturnData = array(
					'nStaEvent'    => '900',
					'tStaMessg'    => "Unsucess Edit Event"
				);
			}else{
				$this->db->trans_commit();
				// Check Image Old Compare Image New
				// if($tImgInputShop != $tImgInputShopOld){
				// 	$aImageUplode = array(
				// 		'tModuleName'       => 'company',
				// 		'tImgFolder'        => 'shop',
				// 		'tImgRefID'         => $tShpCode,
				// 		'tImgObj'           => $tImgInputShop,
				// 		'tImgTable'         => 'TCNMShop',
				// 		'tTableInsert'      => 'TCNMImgObj',
				// 		'tImgKey'           => 'main',
				// 		'dDateTimeOn'       => date('Y-m-d H:i:s'),
				// 		'tWhoBy'            => $this->session->userdata('tSesUsername'),
				// 		'nStaDelBeforeEdit' => 1
				// 	);
				// 	FCNnHAddImgObj($aImageUplode);
				// }
				$aReturnData = array(
					'nStaCallBack'		=> $this->session->userdata('tBtnSaveStaActive'),
					'tBchCodeReturn'	=> $tBchData,
					'tShopCodeReturn'	=> $aDataMaster['FTShpCode'],
					'nStaEvent'	    	=> '1',
					'tStaMessg'			=> 'Success Edit Event'
				);
			}
		}catch(Exception $Error){
			$aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => 'Error FN.Edit Shop => '.$Error->getMessage()
            );
		}
		echo json_encode($aReturnData);
    }
	
	//Functionality : Event Delete Shop
    //Parameters : Ajax jShop()
    //Creator : 07/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Delete
    //Return Type : array
    public function FSaCSHPDeleteEvent(){
		$tIDCode	= $this->input->post('tIDCode');
		$tBchCode	= $this->input->post('tBchCode');
    	$aDataMaster = array(
			'FTShpCode' => $tIDCode,
			'FTBchCode' => $tBchCode
		);

		$aResDel	=	$this->mShop->FSnMSHPDel($aDataMaster);
		if($aResDel['rtCode'] == 1){
			$aDeleteImage = array(
				'tModuleName'	=> 'company',
				'tImgFolder'   	=> 'shop',
				'tImgRefID'    	=> $tIDCode,
				'tTableDel'    	=> 'TCNMImgObj',
				'tImgTable'    	=> 'TCNMShop',
			);
			$nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
			}

			//ต้องลบคลังสินค้าที่ผูกด้วย
			$this->mShop->FSnMDeleteWahouseInShop($aDataMaster);

			//ต้องลบจุดขายที่ผูกกับร้านค้าด้วย
			$this->mShop->FSnMDeletePOSInShop($aDataMaster);
			
			$aReturn    = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Delete Product Success.'
            );
		}else{
			$aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
            );
		}
		echo json_encode($aReturn);
    }
    
	//Functionality : Fuction Chk Type GP In DB
    //Parameters : Ajax jShop()
    //Creator : 25/01/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : Status Delete
	//Return Type : array
	public function FSaCSHPChkTypeGPInDB(){
		try{
			$tBchCode		= $this->input->post('tBchCode');
			$tShpCode		= $this->input->post('tShpCode');
			$aDataMaster	= array(
				'FTBchCode' => $tBchCode,
				'FTShpCode' => $tShpCode
			);
			
			$aDataShopGP	= $this->mShop->FSaMSHPChkTypeGPInDB($aDataMaster);
			if(FCNnHSizeOf($aDataShopGP) == 0){
				$tTypeGP	=	'NULL';
			}else if(!empty($aDataShopGP) && $aDataShopGP['FTPdtCode'] == '*'){
				$tTypeGP	=	'GPSHP';
			}else{
				$tTypeGP	=	'GPPDT';
			}
			echo $tTypeGP;
		}catch(Exception $Error){
			
		}
	}
    
	//Functionality : Function CallPage Data LocType Null
	//Parameters : Ajax jShop()
	//Creator : 03/07/2019 Sarun
	//Return : String View
	//Return Type : View
    public function FSaCSHPCallLocTypeData(){
		$nShpcode      = $this->input->post('nShpCode');
		$aLocTypeData    = $this->mShop->FSnMSHPLocTypeData($nShpcode);
		$aData =array(
			'aData' => $aLocTypeData
		);
    	if($aLocTypeData==false){
			$this->load->view('company/shop/wShopLocTypeDataNull');
		}
		else{
			$this->load->view('company/shop/wShopLocTypeData',$aData);
		}
    }
	
	
	//Functionality : Function CallPage AddEdit Data LocType
	//Parameters : Ajax jShop()
	//Creator : 03/07/2019 Sarun
	//Return : String View
	//Return Type : View
    public function FSaCSHPCallLocTypeAddEdit(){
		$nShpcode      = $this->input->post('nShpCode');
		$aLocTypeData    = $this->mShop->FSnMSHPLocTypeData($nShpcode);
    	if($aLocTypeData==false){
			$aLocTypeData = array(
    			'tStatus' 	=> ""
			);
			$this->load->view('company/shop/wShopLocTypeAddEdit',$aLocTypeData);
		}
		else{
			$aLocTypeData = array(
				'tStatus' 	=> 1,
				'aData'		=> $aLocTypeData
			);
			$this->load->view('company/shop/wShopLocTypeAddEdit',$aLocTypeData);
		}
    }
	
	//Functionality : Function Add Data LocType
	//Parameters : Ajax jShop()
	//Creator : 03/07/2019 Sarun
	//Return : String View
	//Return Type : View
	public function FSaCSHPCallLocTypeEvenAdd(){
		$nShpcode      = $this->input->post('nShpCode');
		$nBrhcode      = $this->input->post('nBrhCode');
		$tShptType 	   = $this->input->post('oetShtType');
		$tShptName 	   = $this->input->post('oetShtName');
		$tShptRemark   = $this->input->post('oetShtRemark');
		$nLangID   		= $this->session->userdata("tLangID");
    	$aDataAdd = array(
				'nShpcode' 	 =>  $nShpcode,
				'nBrhcode'   =>  $nBrhcode,
				'tShptType'  =>  $tShptType,
				'tShptName'  =>  $tShptName,
				'tShptRemark'=>  $tShptRemark,
				'nLangID'	 =>  $nLangID
				
		);
		$aLocTypeData    = $this->mShop->FSnMSHPLocTypeAddData($aDataAdd);
		$aLocTypeData_L    = $this->mShop->FSnMSHPLocTypeAddData_L($aDataAdd);
    	if($aLocTypeData_L == true){
		
			echo "";
		}
		else{
			exit();
		}
    }
    
    //Functionality : Function Edit Data LocType
	//Parameters : Ajax jShop()
	//Creator : 03/07/2019 Sarun
	//Return : String View
	//Return Type : View
	public function FSaCSHPCallLocTypeEvenEdit(){
		$aData = array(
			'FTBchCode'     => $this->input->post('nBrhCode'),
			'FTShpCode'     => $this->input->post('nShpCode'),
			'FTShtType'     => $this->input->post('oetShtType'),
			'FDLastUpdOn'   => date('Y-m-d H:i:s'),
			'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
			
		);
		$aLocTypeData    = $this->mShop->FSnMSHPLocTypeEditData($aData);

		$aDataL = array(
			'FTBchCode'     => $this->input->post('nBrhCode'),
			'FTShpCode'     => $this->input->post('nShpCode'),
			'FTShtType'     => $this->input->post('oetShtType'),
			'FNLngID'		=> $this->session->userdata("tLangID"),	
			'FTShtName'		=> $this->input->post('oetShtName'),
			'FTShtRemark'   => $this->input->post('oetShtRemark')
		);
		$aLocTypeData_L    = $this->mShop->FSnMSHPLocTypeEditDataL($aDataL);

    	if($aLocTypeData_L == true){
		
			echo "";
		}
		else{
			exit();
		}
    }
}