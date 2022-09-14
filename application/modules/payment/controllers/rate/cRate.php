<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cRate extends MX_Controller {

	public function __construct() {
        parent::__construct ();
        $this->load->model('payment/rate/mRate');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
    * Functionality : Vate list
    * Parameters : $nBrowseType: 
    * Creator : dd/mm/yyyy {name}
    * Last Modified : -
    * Return : {return}
    * Return Type : {type}
    */
    public function index($nBrowseType, $tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEventRate']     = FCNaHCheckAlwFunc('rate/0/0'); // Control Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('rate/0/0'); // oad Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        
        $this->load->view('payment/rate/wRate',$aData);

    }

    /**
    * Functionality : {description}
    * Parameters : {params}
    * Creator : dd/mm/yyyy {name}
    * Last Modified : -
    * Return : {return}
    * Return Type : {type}
    */
    public function FSxCRTEAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('payment/rate/wRateAdd',$aDataAdd);
    }

    public function FSxCRTEFormSearchList(){
        $this->load->view('payment/rate/wRateFormSearchList');
    }

    //Functionality : Event Add Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Krit)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCRTEAddEvent(){
        try{
            // *** Image Data
            $tRateImage     = trim($this->input->post('oetImgInputRate'));
            $tRateImageOld  = trim($this->input->post('oetImgInputRateOld'));
            // *** Image Data
            $oetRteRate     = $this->input->post('oetRteRate');
            $oetRteFraction = $this->input->post('oetRteFraction');
            $aRtuFac        = $this->input->post('oetRtuFac');
            if(isset($oetRteRate) && !empty($oetRteRate)){
                $cRateRate	= $oetRteRate;
            }else{
                $cRateRate	= 0;
            }
            
            if(isset($oetRteFraction) && !empty($oetRteFraction)){
                $cRteFraction	= $oetRteFraction;
            }else{
                $cRteFraction	= 0;
            }


            if(!empty($this->input->post('ocmRteStaUse'))){  
                    $cmRteStaUse = 1;
            }else{
                    $cmRteStaUse = 2;
            }

            if(!empty($this->input->post('ocmRteStaLocal'))){  
                    $cRteStaLocal = 1;
            }else{
                    $cRteStaLocal = 2;
            }

            $aDataMaster = array(
                'tIsAutoGenCode' => $this->input->post('ocbRateAutoGenCode'),
                'FTRteCode'     => $this->input->post('oetRteCode'),
                'FCRteRate'     => $cRateRate,
                'FCRteFraction' => $cRteFraction,
                'FTRteType'     => $this->input->post('ocmRteType'),
                'FTRteSign'     => $this->input->post('oetRteSign'),
                'FTRteName'     => $this->input->post('oetRteName'),
                'FTRteStaUse'   => $cmRteStaUse ,
                'FTRteStaLocal' => $cRteStaLocal ,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            );




            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Department Code?
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"   => 'TFNMRate',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => "",                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   				= FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTRteCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $aDataUnitFac = [
                'FTRteCode' => $aDataMaster['FTRteCode'],
                'aRtuFac' => $aRtuFac
            ];
            $oCountDup  = $this->mRate->FSnMRTECheckDuplicate($aDataMaster['FTRteCode']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mRate->FSaMRTEAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mRate->FSaMRTEAddUpdateLang($aDataMaster);
                $aStaEventRateUnitFact  = $this->mRate->FSaMRTEAddUpdateRateUnitFact($aDataUnitFac);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    if($tRateImage != $tRateImageOld){
                        $aImageUplode   = array(
                            'tModuleName'       => 'payment',
                            'tImgFolder'        => 'rate',
                            'tImgRefID'         => $aDataMaster['FTRteCode'],
                            'tImgObj'           => $tRateImage,
                            'tImgTable'         => 'TFNMRate',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        $aImgReturn = FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTRteCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Rate
    //Parameters : Ajax jRate()
    //Creator : 02/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : String
    public function FSaCRTEEditEvent(){
        try{
            // *** Image Data
            $tRateImage     = trim($this->input->post('oetImgInputRate'));
            $tRateImageOld  = trim($this->input->post('oetImgInputRateOld'));
            // *** Image Data
            $oetRteRate 	= $this->input->post('oetRteRate');
            $oetRteFraction = $this->input->post('oetRteFraction');
            $aRtuFac        = $this->input->post('oetRtuFac');
            
            if(isset($oetRteRate) && !empty($oetRteRate)){
                $cRateRate	= $oetRteRate;
            }else{
                $cRateRate	= 0;
            }
            if(isset($oetRteFraction) && !empty($oetRteFraction)){
                $cRteFraction	= $oetRteFraction;
            }else{
                $cRteFraction	= 0;
            }

            if(!empty($this->input->post('ocmRteStaUse'))){  
                $cmRteStaUse = 1;
            }else{
                    $cmRteStaUse = 2;
            }

            if(!empty($this->input->post('ocmRteStaLocal'))){  
                    $cRteStaLocal = 1;
            }else{
                    $cRteStaLocal = 2;
            }
            
            $aDataMaster    = [
                'FTRteCode'     => $this->input->post('oetRteCode'),
                'FTImgObj'      => $this->input->post('oetImgInputrate'),
                'FCRteRate'     => $cRateRate,
                'FCRteFraction' => $cRteFraction,
                'FTRteType'     => $this->input->post('ocmRteType'),
                'FTRteSign'     => $this->input->post('oetRteSign'),
                'FTRteName'     => $this->input->post('oetRteName'),
                'FTRteStaUse'   => $cmRteStaUse ,
                'FTRteStaLocal' => $cRteStaLocal ,
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            ];

            $aDataUnitFac = [
                'FTRteCode' => $this->input->post('oetRteCode'),
                'aRtuFac' => $aRtuFac
            ];
            $this->db->trans_begin();
            $aStaEventMaster  = $this->mRate->FSaMRTEAddUpdateMaster($aDataMaster);
            $aStaEventLang    = $this->mRate->FSaMRTEAddUpdateLang($aDataMaster);
            $aStaEventRateUnitFact  = $this->mRate->FSaMRTEAddUpdateRateUnitFact($aDataUnitFac);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                if($tRateImage != $tRateImageOld){
                    $aImageUplode   = array(
                        'tModuleName'       => 'payment',
                        'tImgFolder'        => 'rate',
                        'tImgRefID'         => $aDataMaster['FTRteCode'],
                        'tImgObj'           => $tRateImage,
                        'tImgTable'         => 'TFNMRate',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTRteCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }

    //Functionality : Event Delete Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : 12/08/2019 Saharat(Golf)
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCRTEDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTRteCode' => $tIDCode
        );
        //ลบข้อมูล
        $aResDel  = $this->mRate->FSnMRTEDel($aDataMaster);
        //เช็คแถวข้อมูลถ้า <= 10 ให้เปลี่ยนหน้า
        $nNumRow  = $this->mRate->FSnMRTEGetAllNumRow();
        //ลบรูป
        $aDeleteImage = array(
            'tModuleName'  => 'payment',
            'tImgFolder'   => 'rate',
            'tImgRefID'    => $tIDCode ,
            'tTableDel'    => 'TCNMImgObj',
            'tImgTable'    => 'TFNMRate'
            );
           $nDelectImageInDB =  FSnHDelectImageInDB($aDeleteImage);
           if($nDelectImageInDB == 1 ){
            FSnHDeleteImageFiles($aDeleteImage);
           }
            if($nNumRow!==  false){
                $aReturn    = array(
                    'nStaEvent' => $aResDel['rtCode'],
                    'tStaMessg' => $aResDel['rtDesc'],
                    'nNumRow'   => $nNumRow
                );
                echo json_encode($aReturn);
            }else{
                echo "database error!";
            }
    }


    public function FSvCRTEEditPage(){
		$aAlwEventRate		= FCNaHCheckAlwFunc('rate/0/0'); //Controle Event
		$nOptDecimalShow	= FCNxHGetOptionDecimalShow();
        $tRteCode       	= $this->input->post('tRteCode');
        $nLangResort    	= $this->session->userdata("tLangID");
        $nLangEdit      	= $this->session->userdata("tLangEdit");
        $aData  = array(
            'FTRteCode' => $tRteCode,
            'FNLngID'   => $nLangEdit
        );
        $aResult       = $this->mRate->FSaMRTESearchByID($aData);
        $aRateUnit     = $this->mRate->FSaMRTERateUnit($aData);
     
        $aDataEdit  = array(
			'nOptDecimalShow'	=> $nOptDecimalShow,
			'aResult'           => $aResult,
			'aAlwEventRate'     => $aAlwEventRate,
            'tImgObjAll'        => $aResult['raItems']['rtImgObj'],
            'aRateUnit'         => $aRateUnit
		);
        $this->load->view('payment/rate/wRateAdd',$aDataEdit);
    }


    //Functionality : Function Call DataTables Rate
    //Parameters : Ajax jRate()
    //Creator : 03/07/2018 Krit(Copter)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSxCRTEDataTable(){
        $aAlwEvent = FCNaHCheckAlwFunc('rate/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );
		$nOptDecimalShow	= FCNxHGetOptionDecimalShow();
        $aResList   = $this->mRate->FSaMRTEList($aData);
        $aGenTable  = array(
			'nOptDecimalShow'	=> $nOptDecimalShow,
            'aAlwEvent'     	=> $aAlwEvent,
            'aDataList'     	=> $aResList,
            'nPage'         	=> $nPage,
            'tSearchAll'    	=> $tSearchAll
        );
        $this->load->view('payment/rate/wRateDataTable',$aGenTable);
    }


}