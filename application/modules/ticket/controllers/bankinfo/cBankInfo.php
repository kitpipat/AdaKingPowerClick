<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cBankInfo extends MX_Controller {
	public function __construct() {
		parent::__construct ();
		$this->load->model ( 'ticket/bankinfo/mBankInfo', 'mBankInfo' );
		$this->load->library ( "session" );
	}
	public function FSxCBIFMaster() {
		$oAuthen = FCNaHCheckAlwFunc('EticketBankInfo');
		$this->load->view ( 'ticket/bankinfo/wBankInfo', array (
			'oAuthen' => $oAuthen, 
		) );
	}
	public function FSxCBIFList() {
		$tFTBifName = $this->input->post ( 'tFTBifName' );
		$nPageNo = $this->input->post ( 'nPageNo' );
		$nPageActive = $nPageNo;
		$oBifList = $this->mBankInfo->FSxMBIFList ( $tFTBifName, $nPageActive );
		$oAuthen = FCNaHCheckAlwFunc('EticketBankInfo');
		$this->load->view ( 'ticket/bankinfo/wBackList', array (
			'oAuthen'  => $oAuthen,
			'oBifList' => $oBifList,
			'nPageNo'  => $nPageNo
		) );
	}
	public function FSxCBIFCount() {
		$tFTBifName = $this->input->post ( 'tFTBifName' );
		$oBIFCntSh = $this->mBankInfo->FStMBIFCount ( $tFTBifName);
		$tBIFCount = $oBIFCntSh [0]->counts;
		echo $tBIFCount;
	}
	public function FSxCBIFAdd() {
		$oBnkMs = $this->mBankInfo->FSxCBIFBnkMaster();
		$this->load->view ( 'ticket/bankinfo/wAdd', array (
			'oBnkMs' => $oBnkMs,
		) );
	}
	public function FSxCBIFAddAjax() {
		if ($this->input->post ( 'oetFTBbkName' )) {
			$nCodeID = FsxCodeID('FTBbkCode', 'TFNMBookBank', 3);
			$aData = array (
				'FTBbkCode' => $nCodeID,
				'FTBnkCode' => $this->input->post ( 'ocmFTBnkCode' ),
				'FTBbkName' => $this->input->post ( 'oetFTBbkName' ),
				'FTBbkBranch' => $this->input->post ( 'oetFTBbkBranch' ),
				'FTBbkAccNo' => $this->input->post ( 'oetFTBbkAccNo' ),
				'FDBbkOpen' => $this->input->post('oetFDBbkOpen'),
				'FCBbkBalance' => ($this->input->post ( 'oetFCBbkBalance' ) == "" ? 0 : $this->input->post ( 'oetFCBbkBalance' )),
				// 'FTBbkType' => $this->input->post ( 'ocmFTBbkType' ),
				'FTBbkType' => $this->input->post ( 'ocmFTBbkType' ),	
				'FTBbkStaActive' => ($this->input->post ( 'ocbFTBbkStaActive' ) == "" ? "2" : "1"),
				'FTBbkRmk' => $this->input->post ( 'otaFTBbkRmk' )
			);
			$this->mBankInfo->FSxMBIFAdd ($aData);

			if ($this->input->post('ohdBBKImg')) {
				$tImg = $this->input->post('ohdBBKImg');
				$aImageUplode = array
					(
						'tModuleName'       => 'ticket',
						'tImgFolder'        => 'ticketbankinfo',
						'tImgRefID'         => $nCodeID,
						'tImgObj'           => $tImg,
						'tImgTable'         => 'TFNMBookBank',
						'tTableInsert'      => 'TCNMImgObj',
						'tImgKey'           => 'main',
						'dDateTimeOn'       => date('Y-m-d H:i:s'),
						'tWhoBy'            => $this->session->userdata('tSesUsername'),
						'nStaDelBeforeEdit' => 1
					);
				$aResAddImgObj = FCNnHAddImgObj($aImageUplode);
			}
			echo $nCodeID;
		}
	}
	public function FSxCBIFEdit($nID) {
		$oBnkMs = $this->mBankInfo->FSxCBIFBnkMaster();
		$oBbk = $this->mBankInfo->FSxCBIFView ( $nID );
		$this->load->view ( 'ticket/bankinfo/wEdit', array (
			'oBbk' => $oBbk,
			'oBnkMs' => $oBnkMs,
		) );
	}
	public function FSxCBIFEditAjax() {
		if ($this->input->post ( 'oetFTBbkName' )) {
			$nCodeID = $this->input->post ( 'ohdFTBbkCode' );
			$aData = array (
				'FTBbkCode' => $nCodeID,
				'FTBnkCode' => $this->input->post ( 'ocmFTBnkCode' ),
				'FTBbkName' => $this->input->post ( 'oetFTBbkName' ),
				// 'FTBbkName' => $this->input->post ( 'oetFTBbkName' ),
				'FTBbkBranch' => $this->input->post ( 'oetFTBbkBranch' ),
				'FTBbkAccNo' => $this->input->post ( 'oetFTBbkAccNo' ),
				'FDBbkOpen' => $this->input->post('oetFDBbkOpen'),
				'FCBbkBalance' => ($this->input->post ( 'oetFCBbkBalance' ) == "" ? 0 : $this->input->post ( 'oetFCBbkBalance' )),
				'FTBbkType' => $this->input->post ( 'ocmFTBbkType' ),
				// 'FTBbkType' => $this->input->post ( 'ocmFTBbkType' ),	
				'FTBbkStaActive' => ($this->input->post ( 'ocbFTBbkStaActive' ) == "" ? "2" : "1"),
				'FTBbkRmk' => $this->input->post ( 'otaFTBbkRmk' )
			);

			$this->mBankInfo->FSxMBIFEdit ( $aData );
			   
			if ($this->input->post('ohdBBKImg')) {
				$tImg = $this->input->post('ohdBBKImg');
				$aImageUplode = array(
					'tModuleName'       => 'ticket',
					'tImgFolder'        => 'ticketbankinfo',
					'tImgRefID'         => $nCodeID,
					'tImgObj'           => $tImg,
					'tImgTable'         => 'TFNMBookBank',
					'tTableInsert'      => 'TCNMImgObj',
					'tImgKey'           => 'main',
					'dDateTimeOn'       => date('Y-m-d H:i:s'),
					'tWhoBy'            => $this->session->userdata('tSesUsername'),
					'nStaDelBeforeEdit' => 1
				);
				$aResAddImgObj = FCNnHAddImgObj($aImageUplode);
			}
		}
	}
	public function FSxCBIFDel() {
		if ($this->input->post('ptBifId')) {
			$ocbListItem = $this->input->post('ptBifId');
			$aCode = explode(',', $ocbListItem);
			foreach ($aCode as $key => $oValue) {
				$nBifId = $oValue;
				$o = $this->mBankInfo->FSxMBIFDel($nBifId);
				$aData = array(
					'status' => $o,
				);
				if ($o != 0) {
					$aDeleteImage = array(
						'tModuleName'  => 'ticket',
						'tImgFolder'   => 'ticketbankinfo',
						'tImgRefID'    => $ocbListItem ,
						'tTableDel'    => 'TCNMImgObj',
						'tImgTable'    => 'TFNMBookBank'
					);
					FSnHDeleteImageFiles($aDeleteImage);
				} 
				echo json_encode($aData);
			}
		}
	}
	public function FSxCBIFDelCheckBox() {
		if ($this->input->post ( 'nFTBbkCode' )) {
			$ocbListItem = $this->input->post ( 'nFTBbkCode' );
			
			$aCode = explode(',', $ocbListItem);
			foreach ($aCode as $key => $oValue) {
				$nBifId = $oValue;
				$o = $this->mBankInfo->FSxMBIFDel($nBifId);
				if ($o != 0) {
					$aDeleteImage = array(
						'tModuleName'  => 'ticket',
						'tImgFolder'   => 'ticketbankinfo',
						'tImgRefID'    => $nBifId ,
						'tTableDel'    => 'TCNMImgObj',
						'tImgTable'    => 'TFNMBookBank'
					);
					FSnHDeleteImageFiles($aDeleteImage);
				} 
			}
		}
	}
	public function FSxCBIFDelImg() {
        if ($this->input->post('tImgID')) {
            $ptImgID = $this->input->post('tImgID');
            $ptNameImg = $this->input->post('tNameImg');
            $aDeleteImage = array(
				'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketbankinfo',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TFNMBookBank'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }      
	}
	
}
	