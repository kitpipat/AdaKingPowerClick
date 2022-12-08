<?php defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

// Last Update : Napat(Jame) 25/11/2022 เพิ่มการ Set Cookies AdaStoreBackCookies บางส่วนเพื่อใช้กับหน้าจอ ปริ้นราคา ก่อน

class cLogin extends MX_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library( "session" );
		// if(@$_SESSION['tSesUsername'] == true) {
		// 	redirect( '', 'refresh' );
		// 	exit();
		// }

		if( get_cookie('AdaStoreBackCookies') !== NULL ){ // ถ้า cookie มีข้อมูลอยู่ให้ รีโหลดหน้าจอเพื่อไปหน้าแรก
            redirect('', 'refresh');
            exit();
        }
	}

	public function index() {
		$this->load->view('authen/login/wLogin');
	}
    
	//Functionality: ตรวจสอบการเข้าใช้งานระบบ
	//Parameters:  รับค่าจากฟอร์ม type POST
	//Creator: 23/03/2018 Phisan(Arm)
	//Last Modified : 
	//Return : Error Code 
	//Return Type: Redirect
	public function FSaCLOGChkLogin(){
		try {
			$tUsername	= $this->input->post('oetUsername'); //ชื่อผู้ใช้
			$tPassword	= $this->input->post('oetPasswordhidden'); //รหัสผ่าน
			$tUsrCode	= $this->input->post('tUsrCode');
			$tUsrLogType	= $this->input->post('tUsrLogType'); //UsrLogType 1:รหัสผ่าน,2:PIN

			$this->load->model('authen/login/mLogin');
			$this->load->model('authen/user/mUser');
			$aDataUsr = $this->mLogin->FSaMLOGChkLogin($tUsername,$tPassword);
			if(!empty($aDataUsr[0]) && $aDataUsr[0]['FTStaError'] == '0' ){

				$this->session->set_userdata("tSesUserLogin", $tUsername);
				if($aDataUsr[0]['FTUsrStaActive'] == '3'){
					$aReturn = array(
						'nStaReturn'		=> 3,
						'tMsgReturn'		=> 'Reset Password',
						'tUsrLogType'		=> $aDataUsr[0]['FTUsrLogType']
					);
				}else{
					// Create By : Napat(Jame) 12/05/2020
					$aDataUsrGroup = $this->mLogin->FSaMLOGGetDataUserLoginGroup($aDataUsr[0]['FTUsrCode']);
					$aDataUsrRole  = $this->mLogin->FSaMLOGGetUserRole($aDataUsr[0]['FTUsrCode']);
					if( empty($aDataUsrGroup[0]['FTAgnCode']) && empty($aDataUsrGroup[0]['FTMerCode']) && empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){
						$aDataComp 			= $this->mLogin->FSaMLOGGetBch();

						$tUsrAgnCodeDefult  = '';
						$tUsrAgnNameDefult  = '';

						$tUsrMerCodeDefult  = '';
						$tUsrMerNameDefult  = '';

						$tUsrBchCodeDefult  = $aDataComp[0]['FTBchCode'];
						$tUsrBchNameDefult  = $aDataComp[0]['FTBchName'];
						$tUsrBchCodeMulti	= "'".$aDataComp[0]['FTBchCode']."'";
						$tUsrBchNameMulti	= "'".$aDataComp[0]['FTBchName']."'";
						$nUsrBchCount		= 0;

						$tUsrShpCodeDefult  = $aDataComp[0]['FTShpCode'];
						$tUsrShpNameDefult  = $aDataComp[0]['FTShpName'];
						$tUsrShpCodeMulti 	= "'".$aDataComp[0]['FTShpCode']."'";
						$tUsrShpNameMulti 	= "'".$aDataComp[0]['FTShpName']."'";
						$nUsrShpCount		= 0;

						$tUsrWahCodeDefult  = $aDataComp[0]['FTWahCode'];
						$tUsrWahNameDefult  = $aDataComp[0]['FTWahName'];
					}else{
						$tUsrAgnCodeDefult  = $aDataUsrGroup[0]['FTAgnCode'];
						$tUsrAgnNameDefult  = $aDataUsrGroup[0]['FTAgnName'];
						
						$tUsrMerCodeDefult  = $aDataUsrGroup[0]['FTMerCode'];
						$tUsrMerNameDefult  = $aDataUsrGroup[0]['FTMerName'];

						$tUsrBchCodeDefult  = $aDataUsrGroup[0]['FTBchCode'];
						$tUsrBchNameDefult  = $aDataUsrGroup[0]['FTBchName'];
						$tUsrBchCodeMulti 	= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchCode','value');
						$tUsrBchNameMulti 	= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchName','value');
						$nUsrBchCount		= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTBchCode','counts');

						$tUsrShpCodeDefult  = $aDataUsrGroup[0]['FTShpCode'];
						$tUsrShpNameDefult  = $aDataUsrGroup[0]['FTShpName'];
						$tUsrShpCodeMulti 	= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpCode','value');
						$tUsrShpNameMulti 	= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpName','value');
						$nUsrShpCount		= $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup,'FTShpCode','counts');

						$tUsrWahCodeDefult  = $aDataUsrGroup[0]['FTWahCode'];
						$tUsrWahNameDefult  = $aDataUsrGroup[0]['FTWahName'];
					}
					$tUsrRoleMulti = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRole,'FTRolCode','value');
					$nUsrRoleLevel  = $this->mLogin->FSaMLOGGetUserRoleLevel($tUsrRoleMulti);

					//Set Cookie Pin
                    if ($tUsrLogType == 2) {
						$aCookieUsername = array(
							'name'    => 'FTUsrLogin',
							'value'   => base64_encode($tUsername),
							'expire'  => 31556926,
						);
						$this->input->set_cookie($aCookieUsername);

						$aCookieUsrCode = array(
							'name'    => 'FTUsrCode',
							'value'   => base64_encode($tUsrCode),
							'expire'  => 31556926,
						);
						$this->input->set_cookie($aCookieUsrCode);
                    }

					// User Role
					$this->session->set_userdata("tSesUsrRoleCodeMulti", $tUsrRoleMulti);
					$this->session->set_userdata("nSesUsrRoleLevel", $nUsrRoleLevel);

					// Agency
					$this->session->set_userdata("tSesUsrAgnCode", $tUsrAgnCodeDefult);
					$this->session->set_userdata("tSesUsrAgnName", $tUsrAgnNameDefult);

					// Merchant
					$this->session->set_userdata("tSesUsrMerCode", $tUsrMerCodeDefult);
					$this->session->set_userdata("tSesUsrMerName", $tUsrMerNameDefult);

					// Branch
					$this->session->set_userdata("tSesUsrBchCodeDefault", $tUsrBchCodeDefult);
					$this->session->set_userdata("tSesUsrBchNameDefault", $tUsrBchNameDefult);
					$this->session->set_userdata("tSesUsrBchCodeMulti", $tUsrBchCodeMulti);
					$this->session->set_userdata("tSesUsrBchNameMulti", $tUsrBchNameMulti);
					$this->session->set_userdata("nSesUsrBchCount", $nUsrBchCount);

					// Shop
					$this->session->set_userdata("tSesUsrShpCodeDefault", $tUsrShpCodeDefult);
					$this->session->set_userdata("tSesUsrShpNameDefault", $tUsrShpNameDefult);
					$this->session->set_userdata("tSesUsrShpCodeMulti", $tUsrShpCodeMulti);
					$this->session->set_userdata("tSesUsrShpNameMulti", $tUsrShpNameMulti);
					$this->session->set_userdata("nSesUsrShpCount", $nUsrShpCount);

					// WaHouse
					$this->session->set_userdata("tSesUsrWahCode", $tUsrWahCodeDefult);
					$this->session->set_userdata("tSesUsrWahName", $tUsrWahNameDefult);

					// Login Level
					$this->session->set_userdata("tSesUsrLoginLevel", $aDataUsrGroup[0]['FTLoginLevel']);

					// Login Status Agency
					$this->session->set_userdata("tSesUsrLoginAgency", $aDataUsrGroup[0]['FTStaLoginAgn']);

					$this->session->set_userdata('bSesLogIn',TRUE);
					$this->session->set_userdata("tSesUserCode", $aDataUsr[0]['FTUsrCode']);
					$this->session->set_userdata("tSesUsername", $aDataUsr[0]['FTUsrCode']);			
					$this->session->set_userdata("tSesUsrDptName", $aDataUsr[0]['FTDptName']);
					$this->session->set_userdata("tSesUsrDptCode", $aDataUsr[0]['FTDptCode']);
					$this->session->set_userdata("tSesUsrUsername", $aDataUsr[0]['FTUsrName']);

					$this->session->set_userdata("tSesUsrImagePerson", $aDataUsr[0]['FTImgObj']);
					
					$this->session->set_userdata("tSesUsrInfo", $aDataUsr[0]);
					$this->session->set_userdata("tSesUsrGroup", $aDataUsrGroup);

					$tDateNow = date('Y-m-d H:i:s');
					$tSessionID = $aDataUsr[0]['FTUsrCode'].date('YmdHis', strtotime($tDateNow)); 
					$this->session->set_userdata("tSesSessionID", $tSessionID);
					$this->session->set_userdata("tSesSessionDate", $tDateNow);

					$nLangEdit = $this->session->userdata("tLangEdit");
					if($nLangEdit == ''){
						$this->session->set_userdata( "tLangEdit", $this->session->userdata("tLangID") );
					}

					// User Have Agen
					$bIsHaveAgn = false;
					if(!empty($aDataUsrGroup[0]['FTAgnCode'])){
						$this->session->set_userdata("bIsHaveAgn", true);
						$bIsHaveAgn = true;
					}else{
						$this->session->set_userdata("bIsHaveAgn", false);
						$bIsHaveAgn = false;
					}

					// User level
					$tSesUsrLevel = "";
					$this->session->set_userdata("tSesUsrLevel", "");
					if( empty($aDataUsrGroup[0]['FTAgnCode']) && empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){ // HQ level
						$this->session->set_userdata("tSesUsrLevel", "HQ");
						$tSesUsrLevel = "HQ";
					}
					if(!empty($aDataUsrGroup[0]['FTBchCode']) && empty($aDataUsrGroup[0]['FTShpCode'])){ // BCH level
						$this->session->set_userdata("tSesUsrLevel", "BCH");
						$tSesUsrLevel = "BCH";
					}
					if(!empty($aDataUsrGroup[0]['FTBchCode']) && !empty($aDataUsrGroup[0]['FTShpCode'])){ // SHP level
						$this->session->set_userdata("tSesUsrLevel", "SHP");
						$tSesUsrLevel = "SHP";
					}
                    if(!empty($aDataUsrGroup[0]['FTBchCode']) && !empty($aDataUsrGroup[0]['FTMerCode'])){ // MER & SHP level
						$this->session->set_userdata("tSesUsrLevel", "SHP");
						$tSesUsrLevel = "SHP";
					}

					// $aTest = array(
					// 	'tUsrCode'	=> $aDataUsr[0]['FTUsrCode'],
					// 	'tSesUsrLevel'	=> $this->session->userdata("tSesUsrLevel"),
					// 	'nSesUsrRoleLevel'	=> $this->session->userdata("nSesUsrRoleLevel"),
					// 	'tSesUsrRoleCodeMulti' => $this->session->userdata("tSesUsrRoleCodeMulti"),

					// 	'tSesUsrAgnCode' => $this->session->userdata("tSesUsrAgnCode"),
					// 	'tSesUsrAgnName' => $this->session->userdata("tSesUsrAgnName"),

					// 	'tSesUsrMerCodeDefault' => $this->session->userdata("tSesUsrMerCode"),
					// 	'tSesUsrMerNameDefault' => $this->session->userdata("tSesUsrMerName"),
						
					// 	'tSesUsrBchCodeDefault' => $this->session->userdata("tSesUsrBchCodeDefault"),
					// 	'tSesUsrBchNameDefault' => $this->session->userdata("tSesUsrBchNameDefault"),
					// 	'tSesUsrBchCodeMulti' => $this->session->userdata("tSesUsrBchCodeMulti"),
					// 	'tSesUsrBchNameMulti' => $this->session->userdata("tSesUsrBchNameMulti"),
					// 	'nSesUsrBchCount' => $this->session->userdata("nSesUsrBchCount"),

					// 	'tSesUsrShpCodeDefault' => $this->session->userdata("tSesUsrShpCodeDefault"),
					// 	'tSesUsrShpNameDefault' => $this->session->userdata("tSesUsrShpNameDefault"),
					// 	'tSesUsrShpCodeMulti' => $this->session->userdata("tSesUsrShpCodeMulti"),
					// 	'tSesUsrShpNameMulti' => $this->session->userdata("tSesUsrShpNameMulti"),
					// 	'nSesUsrShpCount' => $this->session->userdata("nSesUsrShpCount"),

					// 	'tSesUsrWahCode'	=> $this->session->userdata("tSesUsrWahCode"),
					// 	'tSesUsrWahName'	=> $this->session->userdata("tSesUsrWahName"),
					// );
					// echo "<pre>";
					// print_r($aTest);
					// exit;
					
					// $tSesUsrRoleCodeMulti 	= $this->session->userdata('tSesUsrRoleCodeMulti');
					// $tBchCodeUsr			 = '';
					// $aDataUsrRole 			 = $this->mUser->FStUSERGetRoleSpcWhereBrows($tBchCodeUsr);
					// $tRoleMulti 			 = '';
			   
					// if(!empty($aDataUsrRole)){
					// 	$tRoleMulti = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRole['aItems'],'FTRolCode','value');
					// }
					
					// if(!empty($tRoleMulti)){
					// 	$tSesUsrRoleCodeMulti .= ','.$tRoleMulti;
					// }

					$tSesUsrRoleCodeMultiSpc 	= "";
					$aDataWhereChain = array(
						'tUsrRoleMulti'	=> $tUsrRoleMulti,
						'tLoginLevel' 	=> $aDataUsrGroup[0]['FTLoginLevel'],
						'tAgnCode'		=> $tUsrAgnCodeDefult,
						'tBchCodeMulti'	=> $tUsrBchCodeMulti
					);
					$aDataUsrRoleChain  		= $this->mLogin->FSaMLOGGetUserRoleChain($aDataWhereChain);

					if( $aDataUsrRoleChain['tCode'] == '1' ){
						$tSesUsrRoleCodeMultiSpc = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrRoleChain['aItems'],'FTRolCode','value');
					}

					$this->session->set_userdata("tSesUsrRoleSpcCodeMulti", $tSesUsrRoleCodeMultiSpc);

					// Clear Old Cookie
					delete_cookie("AdaStoreBackCookies");

					// tSesUsrBchCom
					// tBtnSaveStaActive

					// Create By : Napat(Jame) 25/11/2022
					// Register Cookies
					$aValueSetCookies = array(

						"tLangID"					=> $this->session->userdata("tLangEdit"),
						"tLangEdit" 				=> $this->session->userdata("tLangEdit"),
						"tSesUsrLevel"				=> $tSesUsrLevel,
						"tSesSessionID"				=> $tSessionID,
						"tSesSessionDate"			=> $tDateNow,

						"tSesUserLogin" 			=> $tUsername,
						"tSesUsrLoginLevel" 		=> $aDataUsrGroup[0]['FTLoginLevel'],
						"tSesUsrLoginAgency" 		=> $aDataUsrGroup[0]['FTStaLoginAgn'],
						"bSesLogIn" 				=> TRUE,
						"tSesUserCode" 				=> $aDataUsr[0]['FTUsrCode'],
						"tSesUsername" 				=> $aDataUsr[0]['FTUsrCode'],
						"tSesUsrDptName" 			=> $aDataUsr[0]['FTDptName'],
						"tSesUsrDptCode" 			=> $aDataUsr[0]['FTDptCode'],
						"tSesUsrUsername" 			=> $aDataUsr[0]['FTUsrName'],
						"tSesUsrImagePerson" 		=> $aDataUsr[0]['FTImgObj'],
						// "tSesUsrInfo" 				=> $aDataUsr[0],

						"tSesUsrRoleCodeMulti" 		=> $tUsrRoleMulti,
						"nSesUsrRoleLevel" 			=> $nUsrRoleLevel,

						"bIsHaveAgn"				=> $bIsHaveAgn,
						"tSesUsrAgnCode" 			=> $tUsrAgnCodeDefult,
						"tSesUsrAgnName" 			=> $tUsrAgnNameDefult,

						"tSesUsrMerCode" 			=> $tUsrMerCodeDefult,
						"tSesUsrMerName" 			=> $tUsrMerNameDefult,

						"tSesUsrBchCodeDefault" 	=> $tUsrBchCodeDefult,
						"tSesUsrBchNameDefault" 	=> $tUsrBchNameDefult,
						"tSesUsrBchCodeMulti" 		=> $tUsrBchCodeMulti,
						"tSesUsrBchNameMulti" 		=> $tUsrBchNameMulti,
						"nSesUsrBchCount" 			=> $nUsrBchCount,

						"tSesUsrShpCodeDefault" 	=> $tUsrShpCodeDefult,
						"tSesUsrShpNameDefault" 	=> $tUsrShpNameDefult,
						"tSesUsrShpCodeMulti" 		=> $tUsrShpCodeMulti,
						"tSesUsrShpNameMulti" 		=> $tUsrShpNameMulti,
						"nSesUsrShpCount" 			=> $nUsrShpCount,
						
						"tSesUsrWahCode" 			=> $tUsrWahCodeDefult,
						"tSesUsrWahName" 			=> $tUsrWahNameDefult,
						
					);

					// $aCookiePackData = array(
					// 	'name'		=> 'AdaStoreBackCookies',
					// 	'value' 	=> base64_encode(json_encode($aValueSetCookies)),
					// 	'expire' 	=> 86400,
					// 	'domain'	=> $_SERVER['SERVER_NAME'],
					// 	'path'		=> explode("/",$_SERVER['SCRIPT_NAME'])[1]
					// );
					// set_cookie($aCookiePackData);
					FCNxSetCookie("AdaStoreBackCookies",$aValueSetCookies,true);

					// Web Browser						Maximum cookies					Maximum size per cookie
					// Google Chrome						180									4096 bytes
					// Firefox								150									4097 bytes
					// Opera								180									4096 bytes
					// Android								50									4096 bytes

					// Set สิทธิในการมองเห็นร้านค้า
					FCNbLoadConfigIsShpEnabled();

					// Set สิทธิในการมองเห็นตัวแทนขาย
					FCNbLoadConfigIsAgnEnabled();

					// Set สิทธิในการมองเห็น Locker
					FCNbLoadConfigIsLockerEnabled();

					// Set สิทธิในการมองเห็น สินค้าแฟชั่น
					FCNbLoadPdtFasionEnabled();

					// Set สิทธิในการมองเห็น หมวดหมู่สินค้า
					FCNxLoadConfigIsCategoryEnabled();

					// Delete Doc Temp
					$this->load->helper('document');
					FCNoHDOCDeleteDocTmp();

					// Clear Report Temp
					$this->load->helper('report');
					FCNoHDOCClearRptTmp();
					
					// Delete Temp Card
					$this->load->helper('card');
					FCNoCARDataListDeleteAllTable();

					// ลบรูปภาพใน Temp Server ตาม User
					$aGetFile = glob("application/modules/common/assets/system/systemimage/".$this->session->userdata('tSesUserCode')."/*"); // get all file names
					foreach($aGetFile as $tPathFile){ // iterate files
						if( is_file($tPathFile) ){
							unlink($tPathFile); // delete file
						}
					}
					
					$aReturn = array(
						'aItems'		=> $aDataUsr,
						'nStaReturn'	=> 1,
						'tMsgReturn'	=> 'Found Data'
					);

				}

			}else{
				$aReturn = array(
					'aItems'		=> $aDataUsr,
					'nStaReturn'	=> 99,
					'tMsgReturn'	=> 'Not Fround Data'
				);
			}
			// }

		}catch(Exception $e) {
			$aReturn = array(
				'aItems'		=> array(),
				'nStaReturn'	=> 500,
				'tMsgReturn'	=> $e
			);
		}

		echo json_encode($aReturn);
	}

	//Functionality: รันสคริปท์ temp
	//Parameters:  -
	//Creator: 29/07/2020 Napat(Jame)
	//Last Modified : 05/08/2020 Napat(Jame) ปรับให้เป็นการรันแบบ แมนนวล
	//Return : - 
	//Return Type: -
	public function FSaCLOGSetUpAdaStoreBack(){
		try {
			// Settings
			$this->load->model('authen/login/mLogin');
			$tDirScript     = "application/modules/authen/assets/SQLScript/*.sql";
			$nTotalScript   = count(glob($tDirScript));
			$nCount         = 0;
			$nSuccess       = 0;
			$nError         = 0;

			$tTimeStart = round(microtime(true) * 1000);
			echo "<div style='overflow-y:auto;height:70%;padding:15px;background-color:#efefef;border-radius:5px;'>";
			echo "<table>";
			if($nTotalScript > 0){
				$db_debug = $this->db->db_debug;
				$this->db->db_debug = FALSE;
				foreach (glob($tDirScript) as $tPathFile){
					echo "<tr>";
					$nCount++;
					$tFileName 			= basename($tPathFile,".sql");
					$tStatement  		= file_get_contents($tPathFile);
					$tTimeLoopStart 	= round(microtime(true) * 1000);
					$aStaExecute  		= $this->mLogin->FSaMLOGExecuteScript($tStatement);
					$tTimeLoopFinish 	= round(microtime(true) * 1000);
					$nDiffTimeProcess 	= $tTimeLoopFinish - $tTimeLoopStart;

					if( $aStaExecute['nStaQuery'] == 1 ){
						if( isset($aStaExecute['tStaMessage']) && $aStaExecute['tStaMessage']['code'] != '0000' ) {
							echo "<td>".$nCount.".</td>";
							echo "<td>".$tFileName."</td>";
							echo "<td><img src='application/modules/common/assets/images/icons/Not-Approve.png' width='18'></td>";
							echo "<td><span>$nDiffTimeProcess ms.</span> <span style='color:red;'>".$aStaExecute['tStaMessage']['message']."</span></td>";
							$nError++;
						}else{
							echo "<td>".$nCount.".</td>";
							echo "<td>".$tFileName."</td>";
							echo "<td><img src='application/modules/common/assets/images/icons/OK-Approve.png' width='18'></td>";
							echo "<td><span>$nDiffTimeProcess ms.</span></td>";
							$nSuccess++;
						}
					}else{
						print_r($aStaExecute['tStaMessage']);
					}
					echo "</tr>";
				}
				$this->db->db_debug = $db_debug;
			}else{
				echo "<tr><td align='center'>ไม่พบไฟล์สคริปท์ (".$tDirScript.")</td></tr>";
			}
			$tTimeFinish = round(microtime(true) * 1000);

			echo "</table>";
			echo "</div>";

			echo "<br>จำนวนทั้งหมด ".count(glob($tDirScript))." สคริปท์ <br>";
			echo "สำเร็จ ".$nSuccess." สคริปท์ <br>";
			echo "ล้มเหลว ".$nError." สคริปท์ <br>";

			$nDiffTimeProcess = ($tTimeFinish - $tTimeStart) / 1000;
			echo "<br>ใช้เวลา ".$nDiffTimeProcess." วินาที<br>";

		}catch(Exception $e) {
			print_r($e);
		}
	}

	public function FSaCLOGBrowseUserName(){
		try {
			$this->load->model('authen/login/mLogin');
			$tTextFilter	= $this->input->post('tTextFilter');

			$aData = $this->mLogin->FSaMLOGGetUserName($tTextFilter);
			foreach ($aData as $aDataList){
				$tDataList 	= '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">';
				$tDataList .= '<div class="wf-box1">';
				$tDataList .= '<div style="padding: 14px;" class="thumbnail">';
				$tDataList .= '<div class="form-group text-center xCNThumbnail">';
				$tDataList .= '<input type="hidden" id="oetUsrname'.$aDataList['FTUsrCode'].'" class="form-control" value="'.$aDataList['FTUsrName'].'">';
				$tDataList .= '<input type="hidden" id="oetUsrCodePin'.$aDataList['FTUsrCode'].'" class="form-control" value="'.$aDataList['FTUsrCode'].'">';
				if($aDataList['FTImgObj'] != ''){
					// $tImage = $aDataList['FTImgObj']; 
					// $tImage = explode("application/modules",$tImage);
					// $tPatchImg = base_url('application/modules/').$tImage[1];
					$tPatchImg = $aDataList['FTImgObj'];

					$tDataList .= '<input type="hidden" id="oetUsrimg'.$aDataList['FTUsrCode'].'" class="form-control" value="'.$tPatchImg.'">';
					$tDataList .= "<img src='".$tPatchImg."'>";
				}else{
					$tDataList .= '<input type="hidden" id="oetUsrimg'.$aDataList['FTUsrCode'].'" class="form-control" value="'.base_url('application/modules/common/assets/images/NoPhoto.png').'">';
					$tDataList .= "<img src=".base_url('application/modules/common/assets/images/NoPhoto.png').">";
				}
				$tDataList .= '<label style="font-weight: bold !important;; font-size: 20px !important;" class="xCNLabelFrm">'.$aDataList["FTUsrName"].'</label>';
				$tDataList .= '</div>';
				$tDataList .= '<div class="row text-center">';
				$tDataList .= '<div class="col-xs-12 col-md-12" align="center">';
				$tDataList .= '<button id="xCNIMGChooseImg"';
				$tDataList .= "";
				$tDataList .= 'class="btn xCNBTNPrimery" style="width:100%" onclick="JSxLOGSelectUsr('. "'" . $aDataList['FTUsrCode'] . "'" . ')">เลือก</button>';
				$tDataList .= '</div>';
				$tDataList .= '</div>';
				$tDataList .= '</div>';
				$tDataList .= '</div>';
				$tDataList .= '</div>';
				echo $tDataList;
			}
		}catch(Exception $e) {
			print_r($e);
		}
	}

	public function FSaCLOGGetUsrLoginPin(){
		try{
			$tUsrCode	= $this->input->post('oetUsrCode'); //ชื่อผู้ใช้
			$tPassword	= $this->input->post('oetPasswordhidden'); //รหัสผ่าน		
			$this->load->model('authen/login/mLogin');
			$aData 		= $this->mLogin->FSaMLOGGetUsrLogin($tUsrCode,$tPassword);
			if($aData['rtCode'] == 1){
				$aReturn = array(
					'aItems'		=> $aData,
					'nStaReturn'	=> 1,
					'tMsgReturn'	=> 'Found Data'
				);
			}else{
				$aReturn = array(
					'aItems'		=> $aData,
					'nStaReturn'	=> 99,
					'tMsgReturn'	=> 'Not Fround Data'
				);
			}
		}catch(Exception $e) {
			$aReturn = array(
				'aItems'		=> array(),
				'nStaReturn'	=> 500,
				'tMsgReturn'	=> $e
			);
		}

		echo json_encode($aReturn);
	}


	public function FSaCLOGGetUsrNameAndImg(){
		try{
			$tUsrCode	= $this->input->post('tUsrCode'); //ชื่อผู้ใช้
			$this->load->model('authen/login/mLogin');
			$aData 		= $this->mLogin->FSaMLOGGetUsrNameAndImg($tUsrCode);
			if($aData['rtCode'] == 1){
				$aReturn = array(
					'aItems'		=> $aData,
					'nStaReturn'	=> 1,
					'tMsgReturn'	=> 'Found Data'
				);
			}else{
				$aReturn = array(
					'aItems'		=> $aData,
					'nStaReturn'	=> 99,
					'tMsgReturn'	=> 'Not Fround Data'
				);
			}
		}catch(Exception $e) {
			$aReturn = array(
				'aItems'		=> array(),
				'nStaReturn'	=> 500,
				'tMsgReturn'	=> $e
			);
		}

		echo json_encode($aReturn);
	}

}








