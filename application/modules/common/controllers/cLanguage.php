<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cLanguage extends MX_Controller {
    
    public function __construct() {
		parent::__construct ();
		$this->load->library ( "session" );
    }
    
    public function index($tType, $nID) {
		$this->session->set_userdata ( "lang", $tType );
		$this->session->set_userdata ( "tLangID", $nID );
		$this->session->set_userdata ( "tLangEdit", $nID );
		redirect('login');
	}
	
	//Function : ใช้ในการเปลี่ยน Session ของภาษาที่ใช้ในการ Add, Edit 
	//Krit(Copter)
	public function FSxChangeLangEdit() {
		$nLang = $this->input->post('nLang');
		$this->session->set_userdata ( "tLangEdit", $nLang );
		echo $nLang;
	}
	
	//Function : ใช้ในการเปลี่ยน Action การทำงานของปุ่มบันทึก
	//17-05-2018 Krit(Copter)
	public function FSxChangeBtnSaveAction() {
		$nStaActive = $this->input->post('nStaActive');
		$this->session->set_userdata ( "tBtnSaveStaActive", $nStaActive );
		echo $nStaActive;
	}

	//เลือกภาษาในการเพิ่มข้อมูล 
	public function FSxSwitchLang() {
		$this->load->model('common/mSwitchLang');
		$tTableMaster 	= $this->input->post('ptTableMaster');
		$aGetFiled  	= $this->mSwitchLang->FSaMGetFiledName($tTableMaster);
		$aGetSysLang  	= $this->mSwitchLang->FSaMGetSystemLang();
		$aData 	= array( 
			'nLangLogin'	=> $this->session->userdata("tLangEdit"),
			'aGetSysLang' 	=> $aGetSysLang,
			'aPackFiled' 	=> $aGetFiled,
			'Table_L'		=> $tTableMaster
		);
		$this->load->view('common/wSwitchLang', $aData);
	}

	//เพิ่มข้อมูลภาษาเพิ่มเติม
	public function FSxEventInsertSwitchLang(){
		$this->load->model('common/mSwitchLang');
		$aPackDataLang 	= $this->input->post('aPackDataLang');
		$tPK 			= $this->input->post('tPK');
		$aSomeArray 	= json_decode($aPackDataLang, true);
		if(FCNnHSizeOf($aSomeArray) != 0 || FCNnHSizeOf($aSomeArray) != null){

			$nLangOld = 0;
			for($i=0; $i<FCNnHSizeOf($aSomeArray); $i++){
				$nLang 		= $aSomeArray[$i]['LANG'];
				$tTable 	= $aSomeArray[$i]['TABLE'];
				$tFiled 	= $aSomeArray[$i]['ID'];
				$tValue 	= $aSomeArray[$i]['VALUE'];
				$tFiledPK 	= $aSomeArray[$i]['FiledPK'];

				if($nLang == $nLangOld){
					$aPackData = array(
						'FiledPK'	=> $tFiledPK,
						'PK'		=> $tPK,
						'nLang' 	=> $nLang,
						'tTable' 	=> $tTable,
						$tFiled 	=> $tFiled,
						'tValue' 	=> $tValue
					);
					array_push($aPackData,$tFiled);
				}

				print_r($aPackData);
				$nLangOld++;
				// $this->mSwitchLang->FSaMInsertLang($aPackData);
			}
		}
		 
	}



}