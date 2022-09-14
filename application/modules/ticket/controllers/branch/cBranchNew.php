<?php
defined('BASEPATH') or exit('No direct script access allowed');
class cBranchNew extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ticket/branch/mBranchNew', 'oBranch');
        $this->load->library("session");
    }

    public function Coptertest(){
        echo "<script src='http://172.30.102.178:80/WaterParkBackoffice/application/assets/vendor/jquery/jquery.js' type='text/javascript'></script>";
        echo "<script>";
        echo "$(document).ajaxStop(function(){
                setTimeout(window.location = 'otherpage.html',100);
                });  window.location('login')";
        echo "</script>";
    }


    // โหลดหน้าจอหลัก และข้อมูลสาขาทั้งหมด
    public function index() {
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $oParkCnt = $this->oBranch->FSaMPRKCount();
        $this->load->view('ticket/branch/wBranchNew', array(
            'aPark' => $oParkCnt,
            'oAuthen' => $oAuthen
        ));
    }

    // โหลดรายการสาขา Ajax
    public function FSxCPRKList() {
        $oAuthen = FCNaHCheckAlwFunc('EticketBranch');
        $tFTPmoName = $this->input->post('tFTPmoName');
        $nPageNo = $this->input->post('nPageNo');
        $nPageActive = $nPageNo;
		$oPrkList = $this->oBranch->FSaMPRKList($tFTPmoName, $nPageActive);
        $this->load->view('ticket/branch/wBranchListNew', array(
            'oPrkList' => $oPrkList,
            'oAuthen'  => $oAuthen,
            'oPageNo'  => $nPageActive
        ));
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
        $this->load->view('ticket/branch/wAdd', array(
            'aArea' => $oArea,
            'aProvince' => $oProvince,
            'aDistrict' => $oDistrict
        ));
    }

    public function FSxCPRKAddAjax() {

        $aDataMaster = array(
            'tIsAutoGenCode'    => $this->input->post('ocbBchAutoGenCode'),
            'FTBchCode'     	=> $this->input->post('oetBchCode'),
            'FTImgLogo'     	=> $this->input->post('oetImgInputbranch'),
            'FTBchType'     	=> $this->input->post('ocmBchType'),
            'FTBchPriority'     => $this->input->post('ocmBchPriority'),
            'FTBchRegNo'     	=> $this->input->post('oetBchRegNo'),
            'FTBchRefID'     	=> $this->input->post('oetBchRefID'),
            'FDBchStart'     	=> FCNdHConverDate($this->input->post('oetBchStart')),
            'FDBchStop'     	=> FCNdHConverDate($this->input->post('oetBchStop')), 
            'FDBchSaleStart'    => FCNdHConverDate($this->input->post('oetBchSaleStart')),  
            'FDBchSaleStop'     => FCNdHConverDate($this->input->post('oetBchSaleStop')),
            'FTBchStaActive'    => $this->input->post('ocmBchStaActive'),

            'FDCreateOn'        => date('Y-m-d h:i:s'),
            'FTCreateBy'        => $this->session->userdata("tSesUsername"),
            'FNLngID'           => $this->session->userdata("tLangEdit"),

            'FTBchName'         => $this->input->post('oetBchName'),
            'FTBchRmk'          => $this->input->post('oetBchRmk'),

        );
            // Setup User Code
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen User Code?
    
				// Auto Gen User Code
				$aStoreParam = array(
                    "tTblName"    => 'TCNMBranch',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTBchCode']   = $aAutogen[0]["FTXxhDocNo"];



                // $aGenCode = FCNaHGenCodeV5('TCNMBranch');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTBchCode'] = $aGenCode['rtBchCode'];
                // }
            }
    
            $aDataAddress = array(
		
				'FTAddV1No'        => $this->input->post('oetAddV1No'),
				'FTAddV1Soi'       => $this->input->post('oetAddV1Soi'),
				'FTAddV1Village'   => $this->input->post('oetAddV1Village'),
				'FTAddV1Road'      => $this->input->post('oetAddV1Road'),
				'FTAddV1SubDist'   => $this->input->post('oetAddV1SubDistCode'),
				'FTAddV1DstCode'   => $this->input->post('oetAddV1DstCode'),
				'FTAddV1PvnCode'   => $this->input->post('oetAddV1PvnCode'),
				'FTAddV1PostCode'  => $this->input->post('oetAddV1PostCode'),
				'FTAddV2Desc1'     => $this->input->post('oetAddV2Desc1'),
				'FTAddV2Desc2'     => $this->input->post('oetAddV2Desc2'),
				'FTAddRefCode'     => $aDataMaster['FTBchCode'],
				'FTAddGrpType'     => '1',
				'FTAddVersion'     => $this->input->post('ohdAddVersion'),
				'FNLngID'          => $this->session->userdata("tLangEdit"),

        );

		$tAPIReq    = 'API/Province/Add';
		$tMethodReq = 'POST';
		$aResAdd    = $this->oBranch->FSaMBCHAdd($tAPIReq,$tMethodReq,$aDataMaster);
		if($aResAdd['rtCode'] == '1'){
			$aResAddAdd = $this->oBranch->FSaMBCHUpdateAddress($aDataAddress);
			if($aResAddAdd['rtCode'] == '1'){
				if ($this->input->post('ohdModelImg')) {
                    $timg = $this->input->post('ohdModelImg');
					$aImageUplode = array(
						'tModuleName'       => 'ticket',
						'tImgFolder'        => 'ticketbranch',
						'tImgRefID'         => $aDataMaster['FTBchCode'],
						'tImgObj'           => $timg,
						'tImgTable'         => 'TCNMBranch',
						'tTableInsert'      => 'TCNMImgObj',
						'tImgKey'           => 'main',
						'dDateTimeOn'       => date('Y-m-d H:i:s'),
						'tWhoBy'            => $this->session->userdata('tSesUsername'),
						'nStaDelBeforeEdit' => 1
					);
					$aResAddImgObj = FCNnHAddImgObj($aImageUplode);
				}
				
				$nStatus = $aResAddAdd['rtCode'];
			}else{
				$nStatus = $aResAddAdd['rtCode'];
			}
			$nStatus = $aResAdd['rtCode'];
		}else{
			$nStatus = $aResAdd['rtCode'];
		}
	    echo $aDataMaster['FTBchCode'];
	}


    
    //Functionality : Function CallPage Branch Edit
	//Parameters : Ajax jReason()
	//Creator : 30/03/2018 Krit(Copter)
	//Last Modified : 02/04/2018 Krit(Copter)
	//Return : String View
	//Return Type : View
	public function FSxCPRKEdit($ptBchCode = ''){
		//ส่ง BchCode มาจาก Function Check Level
		$aAlwEvent = FCNaHCheckAlwFunc('EticketBranch'); 
		if(@$ptBchCode){
			$tBchCode = $ptBchCode;
		}else{
			$tBchCode = $this->input->post('tBchCode');
		}

		$aData = array(
				'FTBchCode' => $tBchCode,
				'FNLngID'   => $this->session->userdata("tLangEdit"),
        );
        
        $aResList       = $this->oBranch->FSaMBchSearchByID($aData);
       

		$aCnfAddVersion  = FCNaHAddressFormat('TCNMBranch');
    
		$nSysStaDefValue = $aCnfAddVersion;
		$nSysStaUsrValue = $aCnfAddVersion;
		
		if($nSysStaUsrValue != ''){
			$nCnfAddVersion = $nSysStaUsrValue; //ถ้า Sys User มีค่าจะใช้ค่าของ UserValue
		}else{
			$nCnfAddVersion = $nSysStaDefValue; //ถ้า Sys User ไม่มีค่าจะใช้ค่าของ DefValue
		}
		

		$aCnfAddPanal = $this->FSvCBCHGenViewAddress($aResList,$nCnfAddVersion);

		$aDataEdit  = array(
				'aResult'       	=> $aResList,
				'aCnfAddPanal' 		=> $aCnfAddPanal,
				'nCnfAddVersion' 	=> $nCnfAddVersion,
				'aAlwEventBranch' 	=> $aAlwEvent
        );
	 $this->load->view('ticket/branch/wEdit',$aDataEdit);

    }
    
    //Functionality : Event Reason Edit
	//Parameters : Ajax jReason()
	//Creator : 27/03/2018 wasin(yoshi)
	//Last Modified : -
	//Return : Status ReasonEdit
	//Return Type : array
	public function FSxCPRKEditAjax(){
		$aDataMaster = array(
				'FTBchCode'     	=> $this->input->post('oetBchCode'),
				'FTImgLogo'     	=> $this->input->post('oetImgInputbranch'),
				'FTBchType'     	=> $this->input->post('ocmBchType'),
				'FTBchPriority'     => $this->input->post('ocmBchPriority'),
				'FTBchRegNo'     	=> $this->input->post('oetBchRegNo'),
				'FTBchRefID'     	=> $this->input->post('oetBchRefID'),
				'FDBchStart'     	=> FCNdHConverDate($this->input->post('oetBchStart')),
				'FDBchStop'     	=> FCNdHConverDate($this->input->post('oetBchStop')), 
				'FDBchSaleStart'    => FCNdHConverDate($this->input->post('oetBchSaleStart')),  
				'FDBchSaleStop'     => FCNdHConverDate($this->input->post('oetBchSaleStop')),
				'FTBchStaActive'    => $this->input->post('ocmBchStaActive'),
					
				'FDLastUpdOn'      => date('Y-m-d h:i:s'),
				'FTLastUpdBy'      => $this->session->userdata("tSesUsername"),
				'FNLngID'          => $this->session->userdata("tLangEdit"),
					
				'FTBchName'     => $this->input->post('oetBchName'),
				'FTBchRmk'      => $this->input->post('oetBchRmk'),

		);
		//Array Data ของ Branch  Address
		$aDataAddress = array(
					
				'FTAddV1No'        => $this->input->post('oetAddV1No'),
				'FTAddV1Soi'       => $this->input->post('oetAddV1Soi'),
				'FTAddV1Village'   => $this->input->post('oetAddV1Village'),
				'FTAddV1Road'      => $this->input->post('oetAddV1Road'),
				'FTAddV1SubDist'   => $this->input->post('oetAddV1SubDistCode'),
				'FTAddV1DstCode'   => $this->input->post('oetAddV1DstCode'),
				'FTAddV1PvnCode'   => $this->input->post('oetAddV1PvnCode'),
				'FTAddV1PostCode'  => $this->input->post('oetAddV1PostCode'),
				'FTAddV2Desc1'     => $this->input->post('oetAddV2Desc1'),
				'FTAddV2Desc2'     => $this->input->post('oetAddV2Desc2'),
				'FTAreCode'        => $this->input->post('oetBchAreCode'),
				'FTZneCode'        => $this->input->post('oetBchZneCode'),
					
				'FTAddRefCode'     => $this->input->post('oetBchCode'),
				'FTAddGrpType'     => '1',
				'FTAddVersion'     => $this->input->post('ohdAddVersion'),
				'FNLngID'          => $this->session->userdata("tLangEdit"),
					
		);
		// print_r($aDataAddress);
		// exit;
		$aResAdd = $this->oBranch->FSaMBCHUpdate($aDataMaster);
		if($aResAdd['rtCode'] == '1'){
            $aResAddAdd = $this->oBranch->FSaMBCHUpdateAddress($aDataAddress);
			if($aResAddAdd['rtCode'] == '1'){
				if($this->input->post('oetImgInputbranch') != ''){
		
					$aImageUplode = array(

						'tModuleName'       => 'ticket',
						'tImgFolder'        => 'ticketbranch',
						'tImgRefID'         => $aDataMaster['FTBchCode'],
						'tImgObj'           => $aDataMaster['FTImgLogo'],
						'tImgTable'         => 'TCNMBranch',
						'tTableInsert'      => 'TCNMImgObj',
						'tImgKey'           => 'main',
						'dDateTimeOn'       => date('Y-m-d H:i:s'),
						'tWhoBy'            => $this->session->userdata('tSesUsername'),
						'nStaDelBeforeEdit' => 1
						
					);
				
					$aResAddImgObj = FCNnHAddImgObj($aImageUplode);
				}
				$nStatus = $aResAddAdd['rtCode'];
			}else{
				$nStatus = $aResAddAdd['rtCode'];
			}

			$nStatus = $aResAdd['rtCode'];
		}else{
			$nStatus = $aResAdd['rtCode'];
		}
		echo $nStatus.",".$aResAdd['rtDesc'];
	}

    /**
     * FS ลบสาขา
    //  */

    public function FSxCPRKDelete(){
				if ($this->input->post('tParkId')) {
					$ocbListItem = $this->input->post('tParkId');
					$aCode = explode(',', $ocbListItem);
					foreach ($aCode as $key => $oValue) {
					$tIDCode = $oValue;
					$o = $this->oBranch->FSnMBCHDel($tIDCode);
						$aData = array(
							'count' => $o,
							'msg' => language('ticket/center/center', 'CheckDel')
						);
					if ($o != 0) {
						$aDeleteImage = array(
							'tModuleName'  => 'ticket',
							'tImgFolder'   => 'ticketbranch',
							'tImgRefID'    => $tIDCode ,
							'tTableDel'    => 'TCNMImgObj',
							'tImgTable'    => 'TCNMBranch'
						);
							FSnHDeleteImageFiles($aDeleteImage);
						} 
						echo json_encode($aData);

					}
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
        $this->load->view('ticket/branch/wParkDetail', array(
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
			// print_r($ptNameImg);
			// FSaHDelImgObj($ptImgID, 'TTKMImgObj', $ptNameImg);
			$aDeleteImage = array(
                'tModuleName'  => 'ticket',
                'tImgFolder'   => 'ticketbranch',
                'tImgRefID'    => $ptImgID,
                'tTableDel'    => 'TTKMImgObj',
                'tImgTable'    => 'TCNMBranch'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
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

    //call branch edit
	public function FSvCBCHGenViewAddress($paResList = '',$nCnfAddVersion = ''){

		$nLangResort = $this->session->userdata("tLangID");
		$nLangEdit	 = $this->session->userdata("tLangEdit");
		
		$aLangHave = FCNaHGetAllLangByTable('TCNMBranch_L');
		$nLangHave = FCNnHSizeOf($aLangHave);
		
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
		
		if(isset($paResList['roItem']['rtBchCode'])){
			
			$tBchCode = $paResList['roItem']['rtBchCode'];
			
			$aData = array(
				'FNLngID' 			=> $nLangEdit,
				'FTAddGrpType' 		=> '1',
				'FTAddVersion' 		=> $nCnfAddVersion,
				'FTAddRefCode' 		=> $tBchCode,
			);
			
			$aCnfAddEdit    = $this->oBranch->FSvMBCHGetAddress($aData);
			
		}else{
			$tBchCode = '';
			$aCnfAddEdit = '';
		}
		
		return $aCnfAddEdit;

	}

}
