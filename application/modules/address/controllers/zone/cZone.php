<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cZone extends MX_Controller {
    
    public function __construct() {
        parent::__construct ();
		$this->load->model('address/zone/mZone');
		date_default_timezone_set("Asia/Bangkok");
    }
    
    public function index($nZneBrowseType,$tZneBrowseOption){
        $nMsgResp = array('title'=>"Zone");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ('common/wHeader', $nMsgResp);
            $this->load->view ('common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        
		$vBtnSave 		= FCNaHBtnSaveActiveHTML('zone/0/0');
		$aAlwEventZone 	= FCNaHCheckAlwFunc('zone/0/0'); 
        $this->load->view ( 'address/zone/wZone', array (
			'nMsgResp' 			=> $nMsgResp,								  
			'vBtnSave' 			=> $vBtnSave,
			'nZneBrowseType'	=> $nZneBrowseType,
			'tZneBrowseOption'	=> $tZneBrowseOption,
			'aAlwEventZone'		=> $aAlwEventZone
		));
        
        
    }
    
	//Functionality : Event Zone Edit
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Zone Edit
    //Return Type : array
    public function FSaCZNEEditEvent(){
    	date_default_timezone_set("Asia/Bangkok");
    	$nSelectRoot = $this->input->post('ocbSelectRoot');

    	if($nSelectRoot == 'on'){
    		$nZneLevel 				= 1;
    		$tZneParent 			= '';
    		$tZneChain 				= $this->input->post('oetZneCode');
    		$tZneChainName 			= $this->input->post('oetZneNameTab1');
    	}else{
    		$tZneCodeSelet 			= $this->input->post('oetZneParent');
    		$aDataZoneSelect 		= $this->mZone->FSaMZNEGetZneLevelANDZneChain($tZneCodeSelet); /* Get Level และ ZneChain*/ 
    		$nZneLevelSelect 		= $aDataZoneSelect[0]->FNZneLevel;
    		$tZneChainSelect 		= $aDataZoneSelect[0]->FTZneChain;
    		$nZneLevel 				= $nZneLevelSelect+1;
    		$tZneParent			 	= $tZneCodeSelet;
    		$tZneChain 				= $tZneChainSelect.$this->input->post('oetZneCode');
			$tZneChainName 			= $this->input->post('oetZneParentName').">".$this->input->post('oetZneNameTab1');
		}
    	$aDataMaster = array(
    			'FTZneCode'     		=> $this->input->post('oetZneCode'),
    			'oetZneChainOld'     	=> $this->input->post('oetZneChainOld'),
				'oetZneChainCurrent'    => $tZneChain,
    			'nLenChainCurrent'		=> strlen($tZneChain),
    			'oetZneParentNameOld'	=> $this->input->post('oetZneParentNameOld'),
    			'oetZneParentName'		=> $this->input->post('oetZneParentName'),
				'oetZneNameOld'			=> $this->input->post('oetZneNameOldTab1'),
				'FTZneName'				=> $this->input->post('oetZneNameTab1'),
				'FTZneRmk'				=> $this->input->post('oetZneRemark'),
				'nLenChain'				=> strlen($tZneChain),
				'oetZneParent'			=> $this->input->post('oetZneParent'),
				'FTZneChainName'		=> $tZneChainName,
				'FTAreCode'				=> $this->input->post('oetAreCode'),	
				'FDLastUpdOn'   => date('Y-m-d H:i:s'),
				'FDCreateOn'    => date('Y-m-d H:i:s'),
				'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
				'FTCreateBy'    => $this->session->userdata('tSesUsername'),
    			'FNLngID'      		 	=> $this->session->userdata("tLangEdit"),
		);

		$aDataArea = array(
			'FTZneCode'     		=> $this->input->post('oetZneCode'),
			'FTAreCode'				=> $this->input->post('oetAreCode'),
		);

		$this->db->trans_begin();
		$aCheckLangAdded = $this->mZone->FSaMZNECheckLangAdded($this->input->post('oetZneCode'),$this->session->userdata("tLangEdit"));
		$nCheckLangAdded = $aCheckLangAdded[0]->counts;

		if($nCheckLangAdded > 0){
			$aResAdd3 = $this->mZone->FSaMZNEUpdateZneNameAndFTZneChainNameMaster($aDataMaster);
		}else{
			$aResAddLang = $this->mZone->FSnMZNEAddLang($aDataMaster); /* Add ภาษา ที่ยังไม่มีในตาราง L */
		}

		$aResUpdateArea = $this->mZone->FSaMZNEUpdateArea($aDataArea);

		
    	// $aResAdd3 = $this->mZone->FSaMZNEUpdateZneNameAndFTZneChainNameMaster($aDataMaster);
    	 
		// echo $aResAdd3;
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$aReturnData    = array(
				'nStaEvent'     => '900',
				'tStaMessg'     => "Error Unsucess Add Document."
			);
		}else{
			$this->db->trans_commit();
			$aReturnData    = array(
				'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
				'tCodeReturn'   => $aDataMaster['FTZneCode'],
				'nStaEvent'		=> '1',
				'tStaMessg'		=> 'Success Add Document.'
			);
		}
    	echo json_encode($aReturnData);
    }
    
        
    //Functionality : Event Zone Add
    //Parameters : Ajax jReason()
    //Creator : 15/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Zone Add
    //Return Type : array
    public function FSaCZNEAddEvent(){
		$nSelectRoot 		  = $this->input->post('ocbSelectRoot');
		$tZoneAutoGenCode     = $this->input->post('ocbZoneAutoGenCode');	

		if($tZoneAutoGenCode == '1'){ // Check Auto Gen Brach Code?
			// Auto Gen Brach Code
			$aStoreParam = array(
				"tTblName"    => 'TCNMZone',                           
				"tDocType"    => 0,                                          
				"tBchCode"    => "",                                 
				"tShpCode"    => "",                               
				"tPosCode"    => "",                     
				"dDocDate"    => date("Y-m-d")       
			);
			$aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
			$tZneCode   = $aAutogen[0]["FTXxhDocNo"];

			// $aGenCode = FCNaHGenCodeV5('TCNMZone','0');
			// if($aGenCode['rtCode'] == '1'){
			// 	$tZneCode	= $aGenCode['rtZneCode'];
			// }
		}else{
			$tZneCode = $this->input->post('oetZneCode');
		}
		
    	if($nSelectRoot == 'on'){
    		$nZneLevel 		= 1;
    		$tZneParent 	= '';
    		$tZneChain		= $tZneCode;
			$tZneChainName 	= $this->input->post('oetZneNameTab1');
			
    	}else{
    		$tZneCodeSelect = $this->input->post('oetZneParent');
    		$aDataZoneSelect = $this->mZone->FSaMZNEGetZneLevelANDZneChain($tZneCodeSelect);
    		$nZneLevelSelect = $aDataZoneSelect[0]->FNZneLevel;
    		$tZneChainSelect = $aDataZoneSelect[0]->FTZneChain;
    		
    		$aDataZneChainNameSelect = $this->mZone->FSaMZNEGetZneSelectZneChainName($tZneCodeSelect);
    		$tZneChainNameSelect = $aDataZneChainNameSelect[0]->FTZneChainName;
    		$tZneChainName = $tZneChainNameSelect.">".$this->input->post('oetZneName');
    		
    		$nZneLevel = $nZneLevelSelect+1;
    		$tZneParent = $tZneCodeSelect;
			$tZneChain = $tZneChainSelect.$tZneCode;
			$tZneChainName = $this->input->post('oetZneParentName').">".$this->input->post('oetZneNameTab1');
			
    	}
		
		
    	$aDataMaster = array(
				'tIsAutoGenCode'	=> $this->input->post('ocbZoneAutoGenCode'),
    			'FTZneCode'     	=> $tZneCode,
    			'FTZneName'     	=> $this->input->post('oetZneNameTab1'),
    			'FNZneLevel'     	=> $nZneLevel,
    			'FTZneParent'		=> $tZneParent,
    			'FTZneChain'		=> $tZneChain,
    			'FTAreCode'			=> $this->input->post('oetAreCode'),
				'FTZneChainName' 	=> $tZneChainName,
				'FTZneRmk'			=> $this->input->post('oetZneRemark'),
				'FDCreateOn'     	=> date('Y-m-d H:i:s'),
				'FDLastUpdOn'   	=> date('Y-m-d H:i:s'),
				'FTLastUpdBy'       => $this->session->userdata("tSesUsername"),
    			'FTCreateBy'      	=> $this->session->userdata("tSesUsername"),
    			'FNLngID'       	=> $this->session->userdata("tLangEdit"),
    	);    
	
		$oCountDup  = $this->mZone->FSnMZENCheckDuplicate($aDataMaster['FTZneCode']);
		$nStaDup    = $oCountDup[0]->counts;
		if($nStaDup == 0){
			$this->db->trans_begin();
				$aResAdd     = $this->mZone->FSaMZNEAdd($aDataMaster);
				$aResAddLang = $this->mZone->FSnMZNEAddLang($aDataMaster); /* Add ภาษา ที่ยังไม่มีในตาราง L */
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$aReturnData    = array(
					'nStaEvent'     => '900',
					'tStaMessg'     => "Error Unsucess Add Document."
				);
			}else{
				$this->db->trans_commit();
				$aReturnData    = array(
					'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
					'tCodeReturn'   => $aDataMaster['FTZneCode'],
					'nStaEvent'		=> '1',
					'tStaMessg'		=> 'Success Add Document.'
				);
			}
		}else{
			$aReturnData = array(
				'nStaEvent'    => '801',
				'tStaMessg'    => "Data Code Duplicate"
			);
		}
		echo json_encode($aReturnData);
    }
        
        
    //Functionality : Function CallPage Zone Edit
    //Parameters : Ajax jZone()
    //Creator : 15/05/2018 Krit(Copter)
    //Return : String View
    //Return Type : View
    public function FSvCZNEEditPage($ptZneCode = '',$ptUserLevel = ''){
    
    	//ส่ง BchCode มาจาก Function Check Level
    	if(@$ptZneCode){
    		$tZneCode = $ptZneCode;
    		$tUserLevel = $ptUserLevel; //เก็บ User Level เพื่อใช้ในการ โชว์ปุ่ม Back
    	}else{
    		$tZneCode = $this->input->post('tZneCode');
    		$tUserLevel = ''; //ไม่ได้เข้ามาจาก Function Check Level จะมีค่า เป็น ว่าง
    	}
    	
    	$nStaBrowse     = $this->input->post('nStaBrowse');
    	$tTypePage      = $this->input->post('tTypePage');      // สถานะ page : edit , add
    	
    
    	if($nStaBrowse == ''){
    		$nStaBrowse = '99';
    	}
    
    	$aData = array(
    			'FTZneCode' => $tZneCode,
    			'FNLngID'   => $this->session->userdata("tLangEdit"),
    	);
    	
		$aResList  = $this->mZone->FSaMZNESearchByID($aData);
		// $aSltRefer = $this->mZone->FSaMZNEGetdataZneobj();

  	       	
    	$aDataEdit  = array(
    			'nResult'       => $aResList,
    			'nStaBrowse'    => $nStaBrowse,
    			'tTypePage'     => $tTypePage,
				'tUserLevel'	=> $tUserLevel
				// 'aSltRefer'		=> $aSltRefer
    	);
    	
    	$this->load->view('address/zone/wZoneAdd',$aDataEdit);
    }
    
    
    //Functionality : Function CallPage Zone Add
    //Parameters : Ajax jReason()
    //Creator : 14/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCZNEAddPage(){
    
    	$aDataEdit = array(
    			'nResult' => array('rtCode' => '99'),
    	);
    	
    	
    	$this->load->view('address/zone/wZoneAdd',$aDataEdit);
    
    }
    
    
    public function FSvCZNECheckUserLevel(){
    
    	//Chk เปลี่ยนหน้าตาม Lv. ของผู้ใช้งาน
    	$tUserLevel = $this->session->userdata("tSesUserLevel");
    	$tUserBchCode = $this->session->userdata("tSesUserBchCode");
    
    	if($tUserLevel == '1'){
    		$this->FSvCZNEListPage();
//     		$this->load->view('address/branch/wBranchList',$aHTML);
    	}else if($tUserLevel == '2'){
    		echo "Edit Page Znee";
    	}else if($tUserLevel == '3'){
    		
    	}
    
    }
    
    
    
    //Functionality : Function CallPage List
    //Parameters : From Ajax File j
    //Creator : 16/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCZNEListPage(){
		$aAlwEventZone	= FCNaHCheckAlwFunc('zone/0/0');
		$aNewData  			= array( 'aAlwEventZone' => $aAlwEventZone );
    	$this->load->view('address/zone/wZoneList',$aNewData);
    
	}
	

	//Functionality : Function Call DataTables District
    //Parameters : Ajax jReason()
    //Creator : 05/06/2018 Krit
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCZNEDataList(){

        $nPage      = $this->input->post('nPageCurrent');
		$tSearchAll = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

		$aResList   	= $this->mZone->FSnMZNEList($aData);
		$aAlwEventZone 	= FCNaHCheckAlwFunc('zone/0/0'); 
        $aGenTable  = array(
            'aDataList' 	=> $aResList,
            'nPage'     	=> $nPage,
			'tSearchAll'    => $tSearchAll,
			'aAlwEventZone'	=> $aAlwEventZone
		);
        $this->load->view('address/zone/wZoneDataTable',$aGenTable);
	}




  //Functionality : Event Zone Delete
    //Parameters : Ajax jReason()
    //Creator : 14/05/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Zone Delete
    //Return Type : array
    public function FSaCZNEDeleteEvent(){
    
    	$tIDCode = $this->input->post('tIDCode');
    	$aDataMaster = array(
    			'FTZneCode' => $tIDCode
    	);

		$aResDel 	= $this->mZone->FSnMZNEDel($aDataMaster);
		$nNumRowZneLoc  = $this->mZone->FSnMLOCGetAllNumRow();
		$aReturn    = array(
			'nStaEvent'     => $aResDel['rtCode'],
			'tStaMessg'     => $aResDel['rtDesc'],
			'nNumRowZneLoc' => $nNumRowZneLoc
		);
		echo json_encode($aReturn);
    }
	
	//Functionality : Event ZoneRefer Add
    //Parameters : Ajax jReason()
    //Creator : 14/06/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status ZoneRefer Add
    //Return Type : array
    public function FSvCZNEAddRefer(){
		//Set DateTime Bangkok
		$tZneBchCode   = $this->input->post('oetZneBchCode');
		$tZneUSerCode  = $this->input->post('oetZneUSerCode');
		$tZneSpnCode   = $this->input->post('oetZneSpnCode');
		$tZneShopCode  = $this->input->post('oetZneShopCode');
		$tZnePosCode   = $this->input->post('oetZnePosCode');
		$tZneCodeTab2  = $this->input->post('oetZneCodeTab2');
		$tZneChainOld  = $this->input->post('oetZneChainOldTab2');
		$tTypeRefer    = $this->input->post('ocmTypeRefer');
		$tZneChain     = $this->input->post('oetZneChain');

			if(isset($tZneBchCode) && !empty($tZneBchCode)){
				$tZneCode = $this->input->post('oetZneBchCode');
				$tZneName = $this->input->post('oetZneBchName');
			}
			if(isset($tZneUSerCode) && !empty($tZneUSerCode) ){
				$tZneCode = $this->input->post('oetZneUSerCode');
				$tZneName = $this->input->post('oetZneUSerName');
			}
			if(isset($tZneSpnCode) && !empty($tZneSpnCode) ){
				$tZneCode = $this->input->post('oetZneSpnCode');
				$tZneName = $this->input->post('oetZneSpnName');
			}
			if(isset($tZneShopCode) && !empty($tZneShopCode) ){
				$tZneCode = $this->input->post('oetZneShopCode');
				$tZneName = $this->input->post('oetZneShopName');
			}
			if(isset($tZnePosCode) && !empty($tZnePosCode) ){
				$tZneCode = $this->input->post('oetZnePosCode');
				$tZneName = $this->input->post('oetZnePosName');
			}


		try {
			$aDataMaster = array(
				'FTZneTable'  	=> $tTypeRefer,
				'FTZneChain' 	=> $tZneChain,
				'FTZneRefCode'	=> $tZneCode,
				'FTZneKey'    	=> $this->input->post('oetKeyReferName'),
				'FTCreateBy'    => $this->session->userdata("tSesUsername"),
				'FDCreateOn'	=> date('Y-m-d H:i:s'),
				'FTLastUpdBy'	=> date('Y-m-d H:i:s'),
				'FDLastUpdOn'   => date('Y-m-d H:i:s')
			);

			$this->db->trans_begin();
			if(isset($tZneCode) && !empty($tZneCode)){
				$aResAdd    = $this->mZone->FSaMZNEAddUpdateMaster($aDataMaster);
			}
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$aReturnData    = array(
					'nStaEvent'     => '900',
					'tStaMessg'     => "Error Unsucess Add Document."
				);
			}else{
				$this->db->trans_commit();
				$aReturnData    = array(
					'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
					'tCodeReturn'   => $aDataMaster['FTZneRefCode'],
					'nStaEvent'		=> '1',
					'tStaMessg'		=> 'Success Add Document.'
				);
			}
		echo json_encode($aReturnData);
		}catch(Exception $Error){
            echo $Error;
		}
		
	}

	//Functionality : Function Call DataTables ZoneObj
    //Parameters : Ajax jReason()
    //Creator : 17/06/2019 Saharat(Golf)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCZNEObjDataList(){

        $nPage      = $this->input->post('nPageCurrent');
		$tSearchAll = $this->input->post('tSearchAll');
		$nZenCode   = $this->input->post('nZneCode');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
			'tSearchAll'    => $tSearchAll,
			'nZenCode'      => $nZenCode			
        );

		$aResList   	= $this->mZone->FSnMZNEObjList($aData);
		$aAlwEventZoneObj 	= FCNaHCheckAlwFunc('zone/0/0'); 
        $aGenTable  = array(
            'aDataList' 	=> $aResList,
            'nPage'     	=> $nPage,
			'tSearchAll'    => $tSearchAll,
			'aAlwEventZoneObj'	=> $aAlwEventZoneObj
		);
        $this->load->view('address/zone/zonerefer/wZoneReferDataTable',$aGenTable);
	}
	

	//Functionality : Event Delete Coupon
    //Parameters : Ajax jReason()
    //Creator : 11/06/2019 saharat(Golf)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCAGNDeleteEvent(){
		$tIDCode   = $this->input->post('tIDCode');
		$tTable    = $this->input->post('tTable');
		$tZneChain = $this->input->post('tZneChain');
        $aDataMaster = array(
			'FTZneRefCode' => $tIDCode,
			'FTZneTable'   => $tTable,
			'tZneChain'    => $tZneChain
        );
        $aResDel    = $this->mZone->FSnMZENOJBDel($aDataMaster);
		$nNumRowZen = $this->mZone->FSnMZENOGetAllNumRow($aDataMaster);
		$aReturn    = array(
			'nStaEvent'  => $aResDel['rtCode'],
			'tStaMessg'  => $aResDel['rtDesc'],
			'nNumRowzen' => $nNumRowZen
		);
		echo json_encode($aReturn);
	}
	
	//Functionality : Event ZoneRefer edit
    //Parameters : Ajax jReason()
    //Creator : 14/06/2019 Saharat(Golf)
    //Last Modified : -
    //Return : Status ZoneRefer Edit
    //Return Type : array
    public function FSvCZNEEditRefer(){
		//Set DateTime Bangkok
		date_default_timezone_set("Asia/Bangkok");
		$tZneCode     = $this->input->post('tZneCode');
		$tZneKey  	  = $this->input->post('tZneKey');
		$tTypeRefer   = $this->input->post('tTypeRefer');
		$tZneID       = $this->input->post('tZneID');
		try {
			$aDataMaster = array(
				'FTZneTable'  	=> $tTypeRefer,
				'FTZneRefCode'	=> $tZneCode,
				'FTZneKey'    	=> $tZneKey,
				'FNZneID'       => $tZneID,
				'FTCreateBy'    => $this->session->userdata("tSesUsername"),
				'FDCreateOn'	=> date('Y-m-d H:i:s'),
				'FTLastUpdBy'	=> date('Y-m-d H:i:s'),
				'FDLastUpdOn'   => date('Y-m-d H:i:s')
			);
			$this->db->trans_begin();
			$aResAdd    = $this->mZone->FSaMZNEReferUpdateMaster($aDataMaster);
			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$aReturnData    = array(
					'nStaEvent'     => '900',
					'tStaMessg'     => "Error Cannot Update Master."
				);
			}else{
				$this->db->trans_commit();
				$aReturnData    = array(
					'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
					'tCodeReturn'   => $aDataMaster['FTZneRefCode'],
					'nStaEvent'		=> '1',
					'tStaMessg'		=> 'Update Master Success'
				);
			}

		echo json_encode($aReturnData);
		}catch(Exception $Error){
            echo $Error;
		}
	}
}	