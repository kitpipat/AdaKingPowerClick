<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCourier extends MX_Controller {

	public function __construct() {
        parent::__construct ();
		$this->load->model('courier/courier/mCourier');
		date_default_timezone_set("Asia/Bangkok");
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
		$aAlwEventCourier 	= FCNaHCheckAlwFunc('courier/0/0');
        $vBtnSaveCourier 	= FCNaHBtnSaveActiveHTML('courier/0/0');

		$this->load->view ('courier/courier/wCourier', array (
            'aAlwEventCourier'	    => $aAlwEventCourier,
			'vBtnSaveCourier' 		=> $vBtnSaveCourier,
			'nBrowseType'			=> $nBrowseType,
			'tBrowseOption'		    => $tBrowseOption,
			'tRouteFromName'		=> $tRouteFromName
		));
    }

    //Functionality : Function CallPage List
	//Parameters : From Ajax File
	//Creator : 09/07/2019
	//Last Modified : -
	//Return : String View
	//Return Type : View
	public function FSvCCRYListPage(){
		$aAlwEventCourier   = FCNaHCheckAlwFunc('courier/0/0');
		$aNewData  		    = array( 'aAlwEventCourier' => $aAlwEventCourier );
		$this->load->view('courier/courier/wCourierMain',$aNewData);
    }

    //Functionality : Function Call DataTables Courier
    //Parameters : Ajax
    //Creator : 09/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCRYDataList(){
		$aAlwEventCourier  = FCNaHCheckAlwFunc('courier/0/0');
        $nPage      = $this->input->post('nPageCurrent');
		$tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourier_L');
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

		$nRow = 10;
        $aDatalist  = array(
            'nPage'         => $nPage,
            'nRow'          => $nRow,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
		$aGetDataList = $this->mCourier->FSaMCRYDataList($aDatalist);

		//กรณีลบข้อมูลหน้า 2 record สุดท้าย และให้ย้อนกลับไปหน้าก่อนหน้า เพื่อไม่ให้ error
		if($aGetDataList['nCurrentPage'] > 1 && $aGetDataList['tCode'] == "800"){
			$aDatalist  = array(
				'nPage'         => $nPage - 1,
				'nRow'          => $nRow,
				'FNLngID'       => $nLangEdit,
				'tSearchAll'    => $tSearchAll
			);
			$aGetDataList = $this->mCourier->FSaMCRYDataList($aDatalist);
		}

        $aGenTable  = array(
			'aAlwEventCourier' 	=> $aAlwEventCourier,
            'aDataList' 		=> $aGetDataList,
			'nPage'    		    => $aDatalist['nPage']
		);
        $this->load->view('courier/courier/wCourierDataTable',$aGenTable);
    }

    //Functionality : Function CallPage Add
    //Parameters : Ajax
    //Creator : 09/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCCRYAddPage(){
        $aDataAdd = array(
            'aResult'         => array( 'tCode' => '99' ),
            'nStaAddOrEdit'   => 99
        );
        $this->load->view('courier/courier/wCourierAdd',$aDataAdd);
	}

	//Functionality : Function CallPage Edit
    //Parameters : Ajax
    //Creator : 10/07/2019 Napat(Jame)
    //Last Modified : -
    //Return : String View
    //Return Type : View
	public function FSvCCRYEditPage(){
		$tCryCode 		= $this->input->post('ptCryCode');
		$nLangEdit		= $this->session->userdata("tLangEdit");
		$aDataCourier	= [
			'FTCryCode'		=> $tCryCode,
			'FNLngID'		=> $nLangEdit,
			'FTImgTable'	=> 'TCNMCourier'
		];
		$aGetDataList = $this->mCourier->FSaMCRYGetDataByID($aDataCourier);
		$aGetImage    = $this->mCourier->FSaMCRYGetImageByID($aDataCourier);

		if($aGetDataList['tCode'] == '1'){
			if ($aGetImage['tCode'] == '1') {
				$aDataConfigView	= [
					'tImgObjAll'	=> $aGetImage['aItems']['FTImgObj'],
					'aResult'		=> $aGetDataList,
					'aImageData'	=> $aGetImage
				];
			}else {
				$aDataConfigView	= [
					'tImgObjAll'	=> '',
					'aResult'		=> $aGetDataList,
					'aImageData'	=>array()
				];
			}

			$tCryPageAdd 			= $this->load->view('courier/courier/wCourierAdd',$aDataConfigView,true);
			$aDataReturn = array(
				'nStaEvent'		=> 1,
				'tCryPageAdd'	=> $tCryPageAdd,
				'tStaMessg'		=> $aGetDataList['tCode']
			);
		}else{
			$aDataReturn = array(
				'nStaEvent'		=> 800,
				'tStaMessg'		=> $aGetDataList['tDesc']
			);
		}
		echo json_encode($aDataReturn);

	}

	//Functionality : Event Add Courier
    //Parameters : Ajax Event
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCRYAddEvent(){
		// ****** Input Data Image
			$tImgInputCourier		= $this->input->post('oetImgInputCourier');
			$tImgInputCourierOld	= $this->input->post('oetImgInputCourierOld');
		// ****** Input Data Image
		//Check Auto gen Code
		$nStaAutoGenCode = $this->input->post('ocbCryStaAutoGenCode');
		if($nStaAutoGenCode == 'on'){
			$aStoreParam = array(
				"tTblName"    => 'TCNMCourier',
				"tDocType"    => 0,
				"tBchCode"    => "",
				"tShpCode"    => "",
				"tPosCode"    => "",
				"dDocDate"    => date("Y-m-d")
			);
			$aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
			$tCryCode   = $aAutogen[0]["FTXxhDocNo"];

			// $aCryCode   = FCNaHGenCodeV5('TCNMCourier');
			// if($aCryCode['rtCode'] == 1){
			// 	$tCryCode = $aCryCode['rtCryCode'];
			// }else{
			// 	$tCryCode = '';
			// }
		}else{
			$tCryCode  = $this->input->post('oetCryCode');
		}

		if($tCryCode != ""){
			$nLangEdit		= $this->session->userdata("tLangEdit");
			$aDataCourier   = array(
				'FTCryCode'					=> $tCryCode,
				'FTCryCardID'				=> $this->input->post('oetCryCardID'),
				'FTCryTaxNo'				=> $this->input->post('oetCryTaxNo'),
				'FTCryTel'					=> $this->input->post('oetCryTel'),
				'FTCryFax'					=> $this->input->post('oetCryFax'),
				'FTCryEmail'				=> $this->input->post('oetCryEmail'),
				'FTCrySex'					=> $this->input->post('oetCrySex'),
				'FDCryDob'					=> ($this->input->post('oetCryDob') == '') ? NULL : $this->input->post('oetCryDob'),
				'FTCgpCode'					=> $this->input->post('oetCryCgpCode'),
				'FTCtyCode'					=> $this->input->post('oetCtyCode'),
				'FTCryBusiness'				=> $this->input->post('ocmCryBusiness'),
				'FTCryBchHQ'				=> $this->input->post('ocmCryBchHQ'),
				'FTCryBchCode'				=> $this->input->post('oetCryBchCode'),
				'FTCryDelimeterQR'			=> $this->input->post('oetCryDelimeterQR'),
				'FTCryStaActive'			=> $this->input->post('ocbCryStaActive'),
				'FTCryLoginType'			=> $this->input->post('ocmCryLoginType'),
				'FNCryCrTerm'				=> ($this->input->post('oetCryCrTerm') == '') ? 0 : $this->input->post('oetCryCrTerm'),
				'FCCryCrLimit'				=> ($this->input->post('oetCryCrLimit') == '') ? 0 : $this->input->post('oetCryCrLimit'),
				'FDLastUpdOn'       		=> date('Y-m-d H:i:s'),
				'FTLastUpdBy'				=> date('Y-m-d H:i:s'),
				'FDCreateOn'				=> $this->session->userdata('tSesUsername'),
				'FTCreateBy'				=> $this->session->userdata('tSesUsername')
			);

			$aDataCourierLang = array(
				'FTCryCode'					=> $tCryCode,
				'FTCryName'					=> $this->input->post('oetCryName'),
				'FTCryNameOth'				=> $this->input->post('oetCryNameOth'),
				'FTCryRmk'					=> $this->input->post('otaCryRmk'),
				'FNLngID'					=> $nLangEdit
			);

			$aCountDup = $this->mCourier->FSaMCRYCheckDuplicate($aDataCourier['FTCryCode']);
			if($aCountDup !== FALSE && $aCountDup['counts'] == 0){

				$aStaCryMaster  = $this->mCourier->FSaMCRYUpdateMaster($aDataCourier);
				$aStaCryLang  	= $this->mCourier->FSaMCRYUpdateLang($aDataCourierLang);
				//When Insert/Update Success Then Upload Image
				if($aStaCryMaster['tCode'] == '1' && $aStaCryLang['tCode'] == '1'){
					if($tImgInputCourier != $tImgInputCourierOld){
						$aImageUplode	= [
							'tModuleName'       => 'courier',
							'tImgFolder'        => 'courier',
							'tImgRefID'         => $aDataCourier['FTCryCode'],
							'tImgObj'           => $tImgInputCourier,
							'tImgTable'         => 'TCNMCourier',
							'tTableInsert'      => 'TCNMImgObj',
							'tImgKey'           => 'master',
							'dDateTimeOn'       => date('Y-m-d H:i:s'),
							'tWhoBy'            => $this->session->userdata('tSesUsername'),
							'nStaDelBeforeEdit' => 1
						];
						$aImgReturn = FCNnHAddImgObj($aImageUplode);
					}
					$aReturn = array(
						'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
						'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
						'tCodeReturn'	=> $aDataCourier['FTCryCode'],
						'nStaEvent'	    => 1,
						'tStaMessg'		=> $aStaCryMaster['tDesc']
					);
				}else{
					$aReturn = array(
						'nStaEvent'    => 801,
						'tStaMessg'    => $aStaCryMaster['tDesc']
					);
				}
			}else{
				$aReturn = array(
					'nStaEvent'    => 801,
					'tStaMessg'    => "Data Code Duplicate"
				);
			}
		}else{
			$aReturn = array(
				'nStaEvent'    => 801,
				'tStaMessg'    => language('common/main/main', 'tCanNotAutoGenCode')
			);
		}
		echo json_encode($aReturn);
	}

	//Functionality : Event Edit Courier
    //Parameters : Ajax Event
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCRYEditEvent(){
		// ****** Input Data Image
			$tImgInputCourier		= $this->input->post('oetImgInputCourier');
			$tImgInputCourierOld	= $this->input->post('oetImgInputCourierOld');
		// ****** Input Data Image
		$nLangEdit			= $this->session->userdata("tLangEdit");
		$aDataCourier		= [
			'FTCryCode'					=> $this->input->post('oetCryCode'),
			'FTCryCardID'				=> $this->input->post('oetCryCardID'),
			'FTCryTaxNo'				=> $this->input->post('oetCryTaxNo'),
			'FTCryTel'					=> $this->input->post('oetCryTel'),
			'FTCryFax'					=> $this->input->post('oetCryFax'),
			'FTCryEmail'				=> $this->input->post('oetCryEmail'),
			'FTCrySex'					=> $this->input->post('oetCrySex'),
			'FDCryDob'					=> ($this->input->post('oetCryDob') == '') ? NULL : $this->input->post('oetCryDob'),
			'FTCgpCode'					=> $this->input->post('oetCryCgpCode'),
			'FTCtyCode'					=> $this->input->post('oetCtyCode'),
			'FTCryBusiness'				=> $this->input->post('ocmCryBusiness'),
			'FTCryBchHQ'				=> $this->input->post('ocmCryBchHQ'),
			'FTCryBchCode'				=> $this->input->post('oetCryBchCode'),
			'FTCryDelimeterQR'			=> $this->input->post('oetCryDelimeterQR'),
			'FTCryStaActive'			=> $this->input->post('ocbCryStaActive'),
			'FTCryLoginType'			=> $this->input->post('ocmCryLoginType'),
			'FNCryCrTerm'				=> ($this->input->post('oetCryCrTerm') == '') ? 0 : $this->input->post('oetCryCrTerm'),
			'FCCryCrLimit'				=> ($this->input->post('oetCryCrLimit') == '') ? 0 : $this->input->post('oetCryCrLimit'),
			'FDLastUpdOn'       		=> date('Y-m-d H:i:s'),
			'FTLastUpdBy'				=> date('Y-m-d H:i:s'),
			'FDCreateOn'				=> $this->session->userdata('tSesUsername'),
			'FTCreateBy'				=> $this->session->userdata('tSesUsername')
		];
		$aDataCourierLang	= [
			'FTCryCode'					=> $this->input->post('oetCryCode'),
			'FTCryName'					=> $this->input->post('oetCryName'),
			'FTCryNameOth'				=> $this->input->post('oetCryNameOth'),
			'FTCryRmk'					=> $this->input->post('otaCryRmk'),
			'FNLngID'					=> $nLangEdit
		];

		$aStaCryMaster  = $this->mCourier->FSaMCRYUpdateMaster($aDataCourier);
		$aStaCryLang  	= $this->mCourier->FSaMCRYUpdateLang($aDataCourierLang);
		//When Insert/Update Success Then Upload Image
		if($aStaCryMaster['tCode'] == '1' && $aStaCryLang['tCode'] == '1'){
			if($tImgInputCourier != $tImgInputCourierOld){
				$aImageUplode	= [
					'tModuleName'       => 'courier',
					'tImgFolder'        => 'courier',
					'tImgRefID'         => $aDataCourier['FTCryCode'],
					'tImgObj'           => $tImgInputCourier,
					'tImgTable'         => 'TCNMCourier',
					'tTableInsert'      => 'TCNMImgObj',
					'tImgKey'           => 'master',
					'dDateTimeOn'       => date('Y-m-d H:i:s'),
					'tWhoBy'            => $this->session->userdata('tSesUsername'),
					'nStaDelBeforeEdit' => 1
				];
				$aImgReturn = FCNnHAddImgObj($aImageUplode);
			}
			$aReturn = array(
				'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
				'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
				'tCodeReturn'	=> $aDataCourier['FTCryCode'],
				'nStaEvent'	    => 1,
				'tStaMessg'		=> $aStaCryMaster['tDesc']
			);
		}else{
			$aReturn = array(
				'nStaEvent'    => 801,
				'tStaMessg'    => $aStaCryMaster['tDesc']
			);
		}

		echo json_encode($aReturn);
	}

	//Functionality : Event Delete Courier
    //Parameters : Ajax
    //Creator : 10/07/2562 Napat(Jame)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCRYDeleteEvent(){
        $aDataMaster = array(
            'FTCryCode' => $this->input->post('tIDCode')
        );
        $aResDel    	= $this->mCourier->FSaMCRYDelAll($aDataMaster);

		$aReturn    = array(
			'nStaEvent'     => $aResDel['tCode'],
			'tStaMessg'     => $aResDel['tDesc']
		);
		echo json_encode($aReturn);
	}

}
