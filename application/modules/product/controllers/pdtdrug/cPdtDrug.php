<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtDrug extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('product/pdtdrug/mPdtDrug');
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File PdtDrug
	//Creator : 17/01/2019 Witsarut (Bell)
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCDrugPageAdd($nDrugBrowseType,$tDrugBrowseOption){

        // Get PdtCode
        $tPdtCode = $this->input->post('tPdtCode');

        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");

        $vBtnSavePdtDrug    = FCNaHBtnSaveActiveHTML('product/0/0');
        $aAlwEventPdtDrug   = FCNaHCheckAlwFunc('product/0/0');

        //CheckID
        $aData = array(
            'FTPdtCode' => $this->input->post('tPdtCode'),
            'FNLngID'   => $nLangEdit
        );

        // CheckIDPdtCode
        $aCheckID  =  $this->mPdtDrug->FSaMDrugCheckID($aData);

        $aGetDataPdtCode    = array(
            'tPdtCode'       => $tPdtCode,
        );

        $aDataAdd  = array(
            'aResult'            => array('rtCode'=>'99'),
            'aCheckID'           => $aCheckID,
            'vBtnSavePdtDrug'    => $vBtnSavePdtDrug,
            'aAlwEventPdtDrug'   => $aAlwEventPdtDrug,
            'aGetDataPdtCode'    => $aGetDataPdtCode,
            'nDrugBrowseType'    => $nDrugBrowseType,
            'tDrugBrowseOption'  => $tDrugBrowseOption
        );

        $this->load->view('product/pdtdrug/wDrugAdd',$aDataAdd);
    }

    
    //Functionality : Function Add PdtDrug
    //Parameters : From Ajax File PdtDrug
    //Creator : 19/01/2020 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCDrugAddEvent(){
        try{

            date_default_timezone_set("Asia/Bangkok");
        
            $dGetDataNow    = date('Y-m-d');
            $dGetDataFuture = date('Y-m-d', strtotime('+1 year'));
    
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
    
            $aDataMaster  = array(
                'FTPdtCode'             => $this->input->post('ohdPdtCode'),
                'FCPdgAge'              => $this->input->post('oetDrugExpirePeriod'),
                'FDPdgCreate'           => $this->input->post('oetPdtDrugStartDate'),
                'FDPdgExpired'          => $this->input->post('oetDrugExpire'),
                'FTPdgHowtoUse'         => $this->input->post('otaHowtouse'),
                'FTPdgActIngredient'    => $this->input->post('otaIngredient'),
                'FTPdgProperties'       => $this->input->post('otaProperties'),
                'FTPdgCtd'              => $this->input->post('otaContraindications'),
                'FTPdgWarn'             => $this->input->post('otaCautionAdvice'),
                'FTPdgStopUse'          => $this->input->post('otaPdtStopUse'),
                'FCPdgDoseSchedule'     => $this->input->post('oetDoseMaximum'),
                'FCPdgMaxIntake'        => $this->input->post('oetMaxintake'),
                'FTPdgBrandName'        => $this->input->post('oetDrugBrand'),
                'FTPdgGenericName'      => $this->input->post('oetGenericName'),
                'FTPdgCategory'         => $this->input->post('oetDrugType'),
                'FTPdgType'             => $this->input->post('ocmPdtDrugType1'),
                'FTPdgRegNo'            => $this->input->post('oetDrugRegis'),
                'FTPdgStorage'          => $this->input->post('otaHowtoPreserve'),
                'FTPdgVolume'           => $this->input->post('oetPdtVolumName'),
                'FTPdgForm'             => $this->input->post('ocmPdtDosage'),
                // 'FTPdgCtrlRole'         => $this->input->post('oetConditionControlCode'),
                'FTPdgManufacturer'     => $this->input->post('otaProductBy'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
            );


            $this->db->trans_begin();
            
            $aResult = $this->mPdtDrug->FSaMDrugAddUpdateMaster($aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Add Data"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Data',
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

   


}