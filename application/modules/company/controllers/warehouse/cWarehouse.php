<?php
defined('BASEPATH') or exit('No direct script access allowed');
class cWarehouse extends MX_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('company/warehouse/mWarehouse');
		date_default_timezone_set("Asia/Bangkok");
	}

	public function index($nBrowseType, $tBrowseOption)
	{
		$aBrowseType = explode("-", $nBrowseType);
		if (isset($aBrowseType[1])) {
			$nBrowseType = $aBrowseType[0];
			$tRouteFromName = $aBrowseType[1];
		} else {
			$nBrowseType = $nBrowseType;
			$tRouteFromName = '';
		}

		$vBtnSave = FCNaHBtnSaveActiveHTML('warehouse/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
		$aAlwEventWarehouse = FCNaHCheckAlwFunc('warehouse/0/0');
		$this->load->view('company/warehouse/wWarehouse', array(
			'vBtnSave' => $vBtnSave,
			'nBrowseType' => $nBrowseType,
			'tRouteFromName' => $tRouteFromName,
			'tBrowseOption'	=> $tBrowseOption,
			'aAlwEventWarehouse' => $aAlwEventWarehouse
		));
	}

	//Functionality : Event Warehouse Edit
	//Parameters : Ajax jWarehouse()
	//Creator : 15/05/2018 Krit(Copter)
	//Last Modified : 05/09/2019 Saharat(Golf)
	//Return : Status ReasonEdit
	//Return Type : array
	public function FSaCWAHEditEvent()
	{
		try {
			$tWahCode = $this->input->post('oetWahCode');
			$tWahName = $this->input->post('oetWahName');
			$tWahStaType =	$this->input->post('ocmWahStaType');
			$tWahStaChkStk = $this->input->post('ocmWahStaChkStk');
			$tWahStaPrcStk = $this->input->post('ocmWahStaPrcStk');
			$tBchCodeCreate = $this->input->post('oetWahBchCodeCreated');
			$tBchCodeRef = $this->input->post('oetWAHBchCode');
			$tSpnCodeRef = $this->input->post('oetWahSpnCode');
			$tPosCodeRef = $this->input->post('oetWahPosCode');
			$FTWahStaAlwCntStk = ($this->input->post('ocbWahCheckCntStk') == "1") ? '1' : '2'; // สถานะอนุญาต ตรวจสอบสต๊อกคงเหลือ(สำหรับขาย) 0: อนุญาติ  1: ไม่อนุญาติ
			$FTWahStaAlwCostAmt = ($this->input->post('ocbWahCheckCostAmt') == "1") ? '1' : '2'; // สถานะอนุญาต คำนวณมูลค่าสินค้า  0: อนุญาติ  1: ไม่อนุญาติ

			// echo $tWahStaType;
			// die();
			$tWahRefCode = "";
			switch ($tWahStaType) {
				case '1':
					$tWahRefCode = $tBchCodeRef;
					break;
				case '2':
					// $tWahRefCode = $tBchCodeRef;
					$tWahRefCode = $tPosCodeRef;
					break;
				/* case '3':
					$tWahRefCode = $this->input->post('oetWAHBchCode');
				break; */
				case '4':
					$tWahRefCode = null;
					break;
				case '5':
					$tWahRefCode = $tSpnCodeRef;
					break;
				case '6':
					$tWahRefCode = $tPosCodeRef;
					break;

				default:
					$tWahRefCode = $this->input->post('oetWahRefCode');
			}

			$aDataMaster = array(
				'FTWahCode' 				=> $tWahCode,
				'FTWahName' 				=> $tWahName,
				'FTWahStaType' 				=> $tWahStaType,
				'FTBchCode' 				=> $tBchCodeCreate,
				'FTBchCodeOld' 				=> $this->input->post('oetWAHBchCodeOld'),
				'FTWahRefCode' 				=> $tWahRefCode,
				'FNLngID' 					=> $this->session->userdata("tLangEdit"),
				'FDLastUpdOn' 				=> date('Y-m-d H:i:s'),
				'FTLastUpdBy' 				=> $this->session->userdata('tSesUsername'),
				'FTWahStaChkStk' 			=> $tWahStaChkStk,
				'FTWahStaPrcStk' 			=> $tWahStaPrcStk,
				'FTWahStaAlwCntStk' 		=> $FTWahStaAlwCntStk,
				'FTWahStaAlwCostAmt' 		=> $FTWahStaAlwCostAmt,
				'FTWahStaAlwPLFrmTBO'     	=> (!empty($this->input->post('ocbWahStaAlwPLFrmTBO'))) ? 1 : 2,
				'FTWahStaAlwPLFrmSale'    	=> (!empty($this->input->post('ocbWahStaAlwPLFrmSale'))) ? 1 : 2,
				'FTWahStaAlwSNPL'    		=> (!empty($this->input->post('ocbWahStaAlwSNPL'))) ? 1 : 2
			);

			$this->db->trans_begin();
			$aResAdd = $this->mWarehouse->FSaMWAHUpdate($aDataMaster);
			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$aReturn = array(
					'nStaEvent' => '900',
					'tStaMessg' => "Unsucess Edit Event"
				);
			} else {
				$this->db->trans_commit();
				$aReturn = array(
					'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
					'tCodeReturn' => $aDataMaster['FTWahCode'],
					'nStaEvent'	=> '1',
					'tStaMessg' => 'Success Edit Event'
				);
			}
		} catch (Exception $Error) {
			$aReturn = array(
				'nStaEvent' => '500',
				'tStaMessg' => "Error 500 Func.Edit Event => " . $Error
			);
		}
		echo json_encode($aReturn);
	}

	//Functionality: Event Warehouse Add
	//Parameters: Ajax jReason()
	//Creator: 15/05/2018 Krit(Copter)
	//Last Modified: 26/03/2019 Wasin(Yoshi)
	//Return: Status Warehouse Add
	//ReturnType: array
	public function FSaCWAHAddEvent()
	{
		try {
			$tIsAutoGenCode	= $this->input->post('ocbWahAutoGenCode');
			$FTWahStaType =	$this->input->post('ocmWahStaType');
			$tWahStaChkStk = $this->input->post('ocmWahStaChkStk');
			$tWahStaPrcStk = $this->input->post('ocmWahStaPrcStk');
			$tBchCodeCreate = $this->input->post('oetWahBchCodeCreated');
			$FTWahStaAlwCntStk = ($this->input->post('ocbWahCheckCntStk') == "1") ? '1' : '2'; // สถานะอนุญาต ตรวจสอบสต๊อกคงเหลือ(สำหรับขาย) 0: อนุญาติ  1: ไม่อนุญาติ
			$FTWahStaAlwCostAmt = ($this->input->post('ocbWahCheckCostAmt') == "1") ? '1' : '2'; // สถานะอนุญาต คำนวณมูลค่าสินค้า  0: อนุญาติ  1: ไม่อนุญาติ
			$tBchCodeRef = $this->input->post('oetWAHBchCode');
			$tSpnCodeRef = $this->input->post('oetWahSpnCode');
			$tPosCodeRef = $this->input->post('oetWahPosCode');

			// Setup Warehouse Code
			$tWahCode = "";
			if ($tIsAutoGenCode == '1') {
				// Call Auto Gencode Helper
				$aStoreParam = array(
					"tTblName" => 'TCNMWaHouse',
					"tDocType" => 0,
					"tBchCode" => $tBchCodeCreate,
					"tShpCode" => "",
					"tPosCode" => "",
					"dDocDate" => date("Y-m-d")
				);
				$aAutogen = FCNaHAUTGenDocNo($aStoreParam);
				$tWahCode = $aAutogen[0]["FTXxhDocNo"];
			} else {
				$tWahCode = $this->input->post('oetWahCode');
			}

			/* if ($tIsAutoGenCode == '1') {
				// Call Auto Gencode Helper
				$aGenCode = FCNaHGenCodeV5('TCNMWaHouse', '0', $tBchCodeCreate);
				if ($aGenCode['rtCode'] == '1') {
					$tWahCode = $aGenCode['rtWahCode'];
				}
			} else {
				$tWahCode = $this->input->post('oetWahCode');
			} */

			$tWahRefCode = "";
			switch ($FTWahStaType) {
				case '1':
					$tWahRefCode = $tBchCodeRef;
					break;
				case '2':
					// $tWahRefCode = $tBchCodeRef;
					$tWahRefCode = $tPosCodeRef;
					break;
					/* case '3':
					$tWahRefCode = $this->input->post('oetWAHBchCode');
				break; */
				case '4':
					$tWahRefCode = null;
					break;
				case '5':
					$tWahRefCode = $tSpnCodeRef;
					break;
				case '6':
					$tWahRefCode = $tPosCodeRef;
					break;

				default:
					$tWahRefCode = $this->input->post('oetWahRefCode');
			}

			/* if($FTWahStaType =='2'){
				$tWahRefCode  = $this->input->post('oetWAHBchCode');
			}else if($FTWahStaType =='4'){
				$tWahRefCode  = null;
			}else{
				$tWahRefCode = $this->input->post('oetWahRefCode');
			} */

			$aDataMaster = array(
				'FTWahCode' 				=> $tWahCode,
				'FTWahStaType' 				=> $FTWahStaType,
				'FTBchCode' 				=> $tBchCodeCreate,
				'FTWahRefCode' 				=> $tWahRefCode,
				'FDLastUpdOn' 				=> date('Y-m-d H:i:s'),
				'FTLastUpdBy' 				=> $this->session->userdata('tSesUsername'),
				'FDCreateOn' 				=> date('Y-m-d H:i:s'),
				'FTCreateBy' 				=> $this->session->userdata('tSesUsername'),
				'FNLngID' 					=> $this->session->userdata("tLangEdit"),
				'FTWahName'					=> $this->input->post('oetWahName'),
				'FTWahStaChkStk' 			=> $tWahStaChkStk,
				'FTWahStaPrcStk' 			=> $tWahStaPrcStk,
				'FTWahStaAlwCntStk' 		=> $FTWahStaAlwCntStk,
				'FTWahStaAlwCostAmt' 		=> $FTWahStaAlwCostAmt,
				'FTWahStaAlwPLFrmTBO'     	=> (!empty($this->input->post('ocbWahStaAlwPLFrmTBO'))) ? 1 : 2,
				'FTWahStaAlwPLFrmSale'    	=> (!empty($this->input->post('ocbWahStaAlwPLFrmSale'))) ? 1 : 2,
				'FTWahStaAlwSNPL'    		=> (!empty($this->input->post('ocbWahStaAlwSNPL'))) ? 1 : 2
			);

			$this->db->trans_begin();

			$this->mWarehouse->FSaMWAHAdd($aDataMaster);

			if ($this->db->trans_status() === false) {
				$this->db->trans_rollback();
				$aReturn = array(
					'nStaEvent' => '900',
					'tStaMessg' => "Unsucess Add Event"
				);
			} else {
				$this->db->trans_commit();
				$aReturn = array(
					'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
					'tCodeReturn' => $aDataMaster['FTWahCode'],
					'nStaEvent'	=> '1',
					'tStaMessg'	=> 'Success Add Event'
				);
			}
		} catch (Exception $Error) {
			$aReturn = array(
				'nStaEvent' => '500',
				'tStaMessg' => "Error 500 Func.Add Event => " . $Error
			);
		}
		echo json_encode($aReturn);
	}

	//Functionality : Function CallPage Branch Edit
	//Parameters : Ajax jReason()
	//Creator : 15/05/2018 Krit(Copter)
	//Last Update : 11/08/2020 Napat(Jame) ปิดคลังมาตรฐาน ในโปรเจค SKC
	//Return : String View
	//Return Type : View
	public function FSvCWAHEditPage($ptWahCode = '', $ptUserLevel = '')
	{

		//ส่ง BchCode มาจาก Function Check Level
		if (@$ptWahCode) {
			$tWahCode = $ptWahCode;
			$tUserLevel = $ptUserLevel; //เก็บ User Level เพื่อใช้ในการ โชว์ปุ่ม Back
		} else {
			$tWahCode = $this->input->post('tWahCode');
			$tBchCode = $this->input->post('tBchCode');
			$tStaType = $this->input->post('tStaType'); /*ประเภทคลัง*/
			$tUserLevel = ''; //ไม่ได้เข้ามาจาก Function Check Level จะมีค่า เป็น ว่าง
		}

		$nStaBrowse = $this->input->post('nStaBrowse');
		$tTypePage = $this->input->post('tTypePage');      // สถานะ page : edit , add


		if ($nStaBrowse == '') {
			$nStaBrowse = '99';
		}

		$aData = array(
			'FTWahCode' => $tWahCode,
			'FTBchCode' => $tBchCode,
			'FNLngID' => $this->session->userdata("tLangEdit"),
		);

		$aResList = $this->mWarehouse->FSaMWAHSearchByID($aData);
		if (is_array($aResList) && $aResList['rtCode'] == '1') {

			if ($aResList['roItem']['rtWahStaType'] == '1' || '2') {

				//<option value="1" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
				$vWahStaType = '<option value="2">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
								<option value="6" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';

				// $vWahStaType = '<option value="4" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
				// 				<option value="5" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
				// 				<option value="6" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';
			} else if ($aResList['roItem']['rtWahStaType'] == '3') {

				// <option value="1" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
				$vWahStaType = '<option value="2" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
								<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';

				// $vWahStaType = '<option value="4" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
				// 				<option value="5" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
				// 				<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';
			} else {
				// <option value="1" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
				$vWahStaType = '<option value="2" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
								<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';

				// $vWahStaType = '<option value="3" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL3') . '</option>
				// 				<option value="4" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
				// 				<option value="5" >' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
				// 				<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';
			}
		} else {
			// <option value="1" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
			$vWahStaType = '<option value="2" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
							<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';

			// $vWahStaType = '<option value="3" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL3') . '</option>
			// 					<option value="4" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
			// 					<option value="5" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
			// 					<option value="6" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';
		}

		//ตรวจสอบ Level ของ User
		$tSesUsrLevel =	$this->session->userdata("tSesUsrLevel");
		if ($tSesUsrLevel == "HQ") {
			$tStaUsrLevel = "HQ";
			$tUsrBchCode  = "";
		} else {
			$tStaUsrLevel = $this->session->userdata("tSesUsrLevel");
			$tUsrBchCode  = $this->session->userdata("tSesUsrBchCode");
		}

		$aDataEdit  = array(
			'nResult' => $aResList,
			'nStaBrowse' => $nStaBrowse,
			'tTypePage' => $tTypePage,
			'tUserLevel' => $tUserLevel,
			'vWahStaType' => $vWahStaType,
			'tStaUsrLevel' => $tStaUsrLevel,
			'tUsrBchCode' => $tUsrBchCode
		);
		$this->load->view('company/warehouse/wWarehouseAdd', $aDataEdit);
	}

	//Functionality : Function CallPage Warehouse Add
	//Parameters : Ajax jReason()
	//Creator : 14/05/2018 Krit(Copter)
	//Last Modified : Napat(Jame) 11/08/2020 ปิดคลังมาตรฐาน ในโปรเจค SKC
	//Return : String View
	//Return Type : View
	public function FSvCWAHAddPage()
	{
		$tTypePage  = $this->input->post('tTypePage');
		// switch ($tTypePage) {

		// 	case 'Add':
		// 		$vWahStaType = '<option value="1" disabled>' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
		// 						<option value="2">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
		// 						<option value="4">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
		// 						<option value="5">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
		// 						<option value="6">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';


		// 		// <option value="3">'. language('company/warehouse/warehouse', 'tWahStaTypeSEL3') .'</option>

		// 		break;

		// 	case 'Edit':
		// 		$vWahStaType = '<option value="1">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
		// 						<option value="2">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
		// 						<option value="4">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
		// 						<option value="5">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>
		// 						<option value="6">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>
		// 						';

		// 		// <option value="3">'. language('company/warehouse/warehouse', 'tWahStaTypeSEL3') .'</option>
		// 		break;

		// 	case 'branch':
		// 		$vWahStaType = '<option value="3">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL3') . '</option>';
		// 		break;

		// 	case 'shop':
		// 		// $vWahStaType = '<option value="6">'. language('company/warehouse/warehouse', 'tWahStaTypeSEL6') .'</option>';
		// 		$vWahStaType = '
		// 						<option value="4">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL4') . '</option>
		// 						';
		// 		break;

		// 	case 'salePerson':
		// 		$vWahStaType = '<option value="5">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL5') . '</option>';
		// 		break;

		// 	case 'salemachine':
		// 		$vWahStaType = '<option value="6">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';
		// 		break;

		// 	default:
		// 		$vWahStaType = '<option value="1">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
		// 					 	<option value="2">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>';
		// }

		// Last Updated By Napat(Jame) 11/08/2020 ปิดคลังมาตรฐาน ในโปรเจค SKC
		// <option value="1">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL1') . '</option>
		$vWahStaType = '<option value="2">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL2') . '</option>
						<option value="6">' . language('company/warehouse/warehouse', 'tWahStaTypeSEL6') . '</option>';

		// ตรวจสอบ Level ของ User
		$tSesUsrLevel =	$this->session->userdata("tSesUsrLevel");
		if ($tSesUsrLevel == "HQ") {
			$tStaUsrLevel = "HQ";
			$tUsrBchCode  = "";
		} else {
			$tStaUsrLevel = $this->session->userdata("tSesUsrLevel");
			$tUsrBchCode  = $this->session->userdata("tSesUsrBchCode");
		}
		$aDataEdit = array(
			'nResult' => array('rtCode' => '99'),
			'vWahStaType' => @$vWahStaType,
			'tStaUsrLevel' => $tStaUsrLevel,
			'tUsrBchCode' => $tUsrBchCode
		);

		$this->load->view('company/warehouse/wWarehouseAdd', $aDataEdit);
	}

	//Functionality : Event Warehouse Delete
	//Parameters : Ajax jReason()
	//Creator : 14/05/2018 Krit(Copter)
	//Last Modified : 20/01/2020 saharat(Golf)
	//Return : Status Warehouse Delete
	//Return Type : array
	public function FSaCWAHDeleteEvent()
	{
		$tIDCode = $this->input->post('tIDCode');
		$tBchCode = $this->input->post('tBchCode');
		if (is_array($tIDCode)) {
			if (!empty($tIDCode)) {
				foreach ($tIDCode as $nKey => $aData) {
					$aDataMaster = array(
						'FTWahCode' => $aData,
						'FTBchCode' => $tBchCode[$nKey]
					);
					$aResultDel = $this->mWarehouse->FSnMWAHDel($aDataMaster);
				}
			}
		} else {

			$aDataMaster = array(
				'FTWahCode' => $tIDCode,
				'FTBchCode' => $tBchCode
			);

			$aResultDel = $this->mWarehouse->FSnMWAHDel($aDataMaster);
		}

		$nNumRowWahLoc = $this->mWarehouse->FSnMLOCGetAllNumRow();
		if ($nNumRowWahLoc !== false) {
			$aReturn = array(
				'nStaEvent' => $aResultDel['rtCode'],
				'tStaMessg' => $aResultDel['rtDesc'],
				'nNumRowWahLoc' => $nNumRowWahLoc
			);
			echo json_encode($aReturn);
		} else {
			echo "database error!";
		}
	}

	public function FSvCWAHCheckUserLevel()
	{
		// Chk เปลี่ยนหน้าตาม Lv. ของผู้ใช้งาน
		$tUserLevel = $this->session->userdata("tSesUserLevel");
		$tUserBchCode = $this->session->userdata("tSesUserBchCode");

		if ($tUserLevel == '1') {
			$this->FSvCWAHListPage();
			// $this->load->view('pos5/branch/wBranchList',$aHTML);
		} else if ($tUserLevel == '2') {
			echo "Edit Page warehouse";
		} else if ($tUserLevel == '3') {
		}
	}

	//Functionality : Function CallPage List
	//Parameters : From Ajax File j
	//Creator : 14/05/2018 Krit(Copter)
	//Last Modified : -
	//Return : String View
	//Return Type : View
	public function FSvCWAHListPage()
	{
		$aAlwEventWarehouse	= FCNaHCheckAlwFunc('warehouse/0/0');
		$aNewData = array('aAlwEventWarehouse' => $aAlwEventWarehouse);
		$this->load->view('company/warehouse/wWarehouseList', $aNewData);
	}

	//Functionality : Function Call DataTables District
	//Parameters : Ajax jReason()
	//Creator : 05/06/2018 Krit
	//Last Modified : -
	//Return : String View
	//Return Type : View
	public function FSvCWAHDataList()
	{
		$nPage = $this->input->post('nPageCurrent');
		$tSearchAll = $this->input->post('tSearchAll');

		if ($nPage == '' || $nPage == null) {
			$nPage = 1;
		} else {
			$nPage = $this->input->post('nPageCurrent');
		}

		// Lang ภาษา
		$nLangResort = $this->session->userdata("tLangID");
		$nLangEdit = $this->session->userdata("tLangEdit");
		// $aLangHave = FCNaHGetAllLangByTable('TCNMWaHouse_L');
		// $nLangHave = FCNnHSizeOf($aLangHave);
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
			'nPage' => $nPage,
			'nRow' => 10,
			'FNLngID' => $nLangEdit,
			'tSearchAll' => $tSearchAll
		);

		$aResList = $this->mWarehouse->FSnMWAHList($aData);
		$aAlwEventWarehouse	= FCNaHCheckAlwFunc('warehouse/0/0');
		$aGenTable  = array(
			'aDataList' => $aResList,
			'nPage' => $nPage,
			'tSearchAll' => $tSearchAll,
			'aAlwEventWarehouse' => $aAlwEventWarehouse
		);
		$this->load->view('company/warehouse/wWarehouseDataTable', $aGenTable);
	}
}
