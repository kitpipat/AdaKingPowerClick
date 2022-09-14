<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cImpproduct extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/product/mImpproduct');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Import
    public function FSaCPDTImportDataTable(){
        $this->load->view('product/product/import/wProductImportDataTable');
    }

    public function FSaCPDTGetDataImport(){
        $aDataSearch = array(
            'tType'	        => $this->input->post('tType'),
			'nPageNumber'	=> ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
			'nLangEdit'		=> $this->session->userdata("tLangEdit"),
			'tTableKey'		=> $this->input->post('tType'),
			'tSessionID'	=> $this->session->userdata("tSesSessionID"),
			'tTextSearch'	=> $this->input->post('tSearch') 
		);
		$aGetData 					= $this->mImpproduct->FSaMUSRGetTempData($aDataSearch);
        $data['draw'] 				= ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $data['recordsTotal'] 		= $aGetData['numrow'];
        $data['recordsFiltered'] 	= $aGetData['numrow'];
        $data['data'] 				= $aGetData;
		$data['error'] 				= array();
		$this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    //Delete ข้อมูลใน
	public function FSaCPDTImportDelete(){
		$aDataMaster = array(
			'tTableName' 	=> $this->input->post('tTableName'),
			'FNTmpSeq' 		=> $this->input->post('FNTmpSeq'),
			'tTableKey'		=> $this->input->post('tTableName'),
			'tSessionID'	=> $this->session->userdata("tSesSessionID")
		);
		$aResDel            = $this->mImpproduct->FSaMPDTImportDelete($aDataMaster);

		//validate ข้อมูลซ้ำในตาราง Tmp
		switch ($this->input->post('tTableName')) {
            case "TCNMPDT":
                $tFiledPK = 'FTPdtCode';
			break;
			case "TCNMPdtUnit":
                $tFiledPK = 'FTPunCode';
			break;
			case "TCNMPdtBrand":
                $tFiledPK = 'FTPbnCode';
			break;
			case "TCNMPdtTouchGrp":
				$tFiledPK = 'FTTcgCode';
			break;
			case "TCNMPdtSpcBch":
				$tFiledPK = 'FTPdtCode';
			break;
			case "TCNMPdtType":
				$tFiledPK = 'FTPtyCode';
			break;
			case "TCNMPdtModel":
				$tFiledPK = 'FTPmoCode';
			break;
			case "TCNMPdtGrp":
				$tFiledPK = 'FTPgpChain';
			break;
		}

		$tPkCode          = $this->input->post('tPkCode');
		if(is_array($tPkCode)){
			foreach($tPkCode as $tValue){
				$aValidateData = array(
					'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
					'tFieldName'        => $tFiledPK,
					'tFieldValue'		=> $tValue
				);
				FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
			}
		}else{
			$aValidateData = array(
				'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
				'tFieldName'        => $tFiledPK,
				'tFieldValue'		=> $tPkCode,
				'tTabkePK'			=> $this->input->post('tTableName')
			);
			FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
        }
		
		//Reset TabProduct อีกรอบให้มัน check ใหม่
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID")
		);
		FCNnMasTmpResetStatus($aValidateData);

		//validate มีข้อมูลอยู่เเล้วในตารางห้ามซ้ำกับ AD อื่น
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPdtCode',
			'tTableCheck'       => 'TCNMPdt'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check รหัสหน่วยย่อยซ้ำ Temp ก่อนเเล้วค่อยเช็คจาก master (เพิ่มมาใหม่)
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPdtCode',
			'tTableCheck'       => 'TCNMPdtPackSize'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check บาร์โค๊ดก่อนว่าซ้ำไหม Temp ก่อนเเล้วค่อยเช็คจาก master (เพิ่มมาใหม่)
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPdtCode',
			'tTableCheck'       => 'TCNMPdtBar'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		//Check หน่วยสินค้าจาก Temp ก่อนเเล้วค่อยเช็คจาก master (เช็คว่าหน่วยนิมีจริงไหม)
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPunCode',
			'tTableCheck'       => 'TCNMPdtUnit'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check รหัสกลุ่มสินค้าด่วน Temp ก่อนเเล้วค่อยเช็คจาก master
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTTcgCode',
			'tTableCheck'       => 'TCNMPdtTouchGrp'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check TCNMPdtType
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPtyCode',
			'tTableCheck'       => 'TCNMPdtType'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check TCNMPdtModel
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPmoCode',
			'tTableCheck'       => 'TCNMPdtModel'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		// Check TCNMPdtGrp
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPgpChain',
			'tTableCheck'       => 'TCNMPdtGrp'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		//Check รหัสยี่ห้อ Temp ก่อนเเล้วค่อยเช็คจาก master
		$aValidateData = array(
			'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
			'tFieldName'        => 'FTPgpChain',
			'tTableCheck'       => 'TCNMPdtBrand'
		);
		FCNnMasTmpChkCodeDupInDBSpecial($aValidateData);

		echo json_encode($aResDel);
	}

	// ย้ายรายการจาก Temp ไปยัง Master
	public function FSaCPDTImportMove2Master(){
		$aDataMaster = array(
			'nLangEdit'				=> $this->session->userdata("tLangEdit"),
			'tSessionID'			=> $this->session->userdata("tSesSessionID"),
			'dDateOn'				=> date('Y-m-d H:i:s'),
			'dDateStart'			=> date('Y-m-d'),
			'dDateStop'				=> date('Y-m-d', strtotime('+30 year')),
			'tUserBy'				=> $this->session->userdata("tSesUsername"),
			'tTypeCaseDuplicate' 	=> $this->input->post('tTypeCaseDuplicate')
		);

		$this->db->trans_begin();
		$this->mImpproduct->FSaMPDTImportMove2MasterNew($aDataMaster);
        // $this->mImpproduct->FSaMPDTImportMove2Master($aDataMaster);
        $this->mImpproduct->FSaMPDTImportMove2MasterAndReplaceOrInsert($aDataMaster);
        $this->mImpproduct->FSaMPDTImportMove2MasterDeleteTemp($aDataMaster);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$aReturnToHTML = array(
				'tCode'     => '99',
				'tDesc'     => 'Error'
			);
		}else{
			$this->db->trans_commit();
            $aReturnToHTML = array(
                'tCode'     => '1',
                'tDesc'     => 'success'
            );
		}

		echo json_encode($aReturnToHTML);
	}

	//หาจำนวนทั้งหมด
	public function FSaCPDTImportGetItemAll(){
		$aResult  = $this->mImpproduct->FSaMPDTGetTempDataAtAll($this->input->post('tTabName'));
		echo json_encode($aResult);
	}

}