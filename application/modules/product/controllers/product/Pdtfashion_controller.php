<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pdtfashion_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('company/branch/mBranch');
        $this->load->model('product/product/Pdtfashion_model');
    }

    //Functionality : Function Call Page Main
	//Parameters : From Ajax File PdtFashion
	//Creator : 27/04/2021 Nattakit
	//Last Modified : -
	//Return : String View
	//Return Type : View
    public function FSvCPFHPageFrom(){

        // Get PdtCode
        $tPdtCode = $this->input->post('tPdtCode');

        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");

        //CheckID
        $aData = array(
            'FTPdtCode' => $this->input->post('tPdtCode'),
            'FNLngID'   => $nLangEdit
        );
        // CheckIDPdtCode
        $aMasterPdt  =  $this->Pdtfashion_model->FSaMPFHFGetMaster($aData);

        $aGetDataPdtCode    = array(
            'tPdtCode'       => $tPdtCode,
        );

        $aDataAdd  = array(
            'aMasterPdt'           => $aMasterPdt,
            'aGetDataPdtCode'    => $aGetDataPdtCode,
        );

        $this->load->view('product/product/pdtfashion/wPdtfashionPageFrom',$aDataAdd);
    }

    
    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCPFHAddEditEvent(){
        try{
    
            $nLangEdit      = $this->session->userdata("tLangEdit");
    
            $aDataMaster  = array(
                'FTPdtCode'             => $this->input->post('oetFhnPdtCode'),
                'FTDepCode'             => $this->input->post('oetFhnPdtDepartCode'),
                'FTClsCode'             => $this->input->post('oetFhnPdtClassCode'),
                'FTSclCode'             => $this->input->post('oetFhnPdtSubClassCode'),
                'FTPgpCode'             => $this->input->post('oetFhnPdtGroupCode'),
                'FTCmlCode'             => $this->input->post('oetFhnPdtComLinesCode'),
                'FTFhnModNo'            => $this->input->post('oetFhnPdtModelNo'),
                'FTFhnGender'           => $this->input->post('ocmFhnPdtGender'),
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
            );

            $this->db->trans_begin();
            
            $aResult = $this->Pdtfashion_model->FSaMPFHAddUpdateMaster($aDataMaster);

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

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHDataTable(){

        $tPdtCode = $this->input->post('tPdtCode');
        $tSearchFhnPdtColorSze = $this->input->post('tSearchFhnPdtColorSze');
        $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");

        //CheckID
        $aData = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FTPdtCode' => $this->input->post('tPdtCode'),
            'tSearchFhnPdtColorSze' => $tSearchFhnPdtColorSze,
            'FNLngID'   => $nLangEdit
        );
        
        $aMasterPdtClrPsz  =  $this->Pdtfashion_model->FSaMPFHFGetDataTable($aData);

        $aGetDataPdtCode    = array(
            'tPdtCode'       => $tPdtCode,
        );

        $aDataAdd  = array(
            'aMasterPdtClrPsz'   => $aMasterPdtClrPsz,
            'aGetDataPdtCode'    => $aGetDataPdtCode,
            'nPage'                 => $nPage,
        );

        $this->load->view('product/product/pdtfashion/wPdtfashionDataTable',$aDataAdd);

    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHPageAdd(){


        $tPdtCode = $this->input->post('tPdtCode');

        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");

        //CheckID
        $aData = array(
            'FTPdtCode' => $this->input->post('tPdtCode'),
            'FNLngID'   => $nLangEdit
        );
        // CheckIDPdtCode
        $aMasterPdt  =  $this->Pdtfashion_model->FSaMPFHFGetMaster($aData);


        $aDataAdd  = array(
            'tEvent'   => 'pdtFashionEventAdd',
            'aMasterPdt'    => $aMasterPdt,
            'tPdtCode' => $tPdtCode,
        );

        $this->load->view('product/product/pdtfashion/wPdtfashionPageAdd',$aDataAdd);

    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHPageEdit(){


        $tPdtCode = $this->input->post('tPdtCode');
        $tRefCode = $this->input->post('tRefCode');
        $nFhnSeq    = $this->input->post('nSeq');

        $nLangResort        = $this->session->userdata("tLangID");
        $nLangEdit          = $this->session->userdata("tLangEdit");

        //CheckID
        $aData = array(
            'FTPdtCode'    => $tPdtCode,
            'FTFhnRefCode' => $tRefCode,
            'FNFhnSeq'    => $nFhnSeq,
            'FNLngID'   => $nLangEdit
        );
        // CheckIDPdtCode
        $aMasterPdt  =  $this->Pdtfashion_model->FSaMPFHFGetMaster($aData);
        $aMasterPdtClrSze  =  $this->Pdtfashion_model->FSaMPFHFGetClrSzeById($aData);

        $aDataAdd  = array(
            'tEvent'   => 'pdtFashionEventEdit',
            'aMasterPdt'    => $aMasterPdt,
            'aMasterPdtClrSze' => $aMasterPdtClrSze,
            'tPdtCode' => $tPdtCode,
        );

        $this->load->view('product/product/pdtfashion/wPdtfashionPageAdd',$aDataAdd);

    }

    
    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHClrSzeEventAdd(){
        try{
            $tImgInputPdtFashionOld = $this->input->post('oetImgInputPdtFashionOld');
            $tImgInputPdtFashion    = $this->input->post('oetImgInputPdtFashion');

            $nLangEdit      = $this->session->userdata("tLangEdit");
       
            if($this->input->post('ocbFhnPdtStatus')==1){
                $nFhnPdtStatus = 1;
            }else{
                $nFhnPdtStatus = 2;
            }
            
     



            $aDataMaster  = array(
                'FTPdtCode'             => $this->input->post('oetFhnPdtCode'),
                'FTFhnRefCode'          => $this->input->post('oetFhnPdtRefCode'),
                'FTSeaCode'             => $this->input->post('oetFhnPdtSeasonCode'),
                'FTFabCode'             => $this->input->post('oetFhnPdtFabricCode'),
                'FTClrCode'             => $this->input->post('oetFhnPdtColorCode'),
                'FTPszCode'             => $this->input->post('oetFhnPdtSizeCode'),
                'FDFhnStart'            => $this->input->post('oetFhnPdtStratDate'),
                'FTFhnStaActive'        => $nFhnPdtStatus,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
            );


            $aFhnSeq =  $this->Pdtfashion_model->FSaMPFHGetPdtColorMaxSeq($aDataMaster);
        
            $aDataMaster['FNFhnSeq'] = $aFhnSeq['rnFhnSeq']+1;
        

            // Default BarCode By RefCode
            // $aDataBarCode   = array(
            //     'FTPdtCode'         => $this->input->post('oetFhnPdtCode'),
            //     'FTBarCode'         => $this->input->post('oetFhnPdtRefCode'),
            //     'FTFhnRefCode'      => $this->input->post('oetFhnPdtRefCode'),
            //     'FNBarRefSeq'       => $aDataMaster['FNFhnSeq'],
            //     'FTPlcCode'         => '',
            //     'FTBarStaUse'       => '1',
            //     'FTBarStaAlwSale'   => '1',
            // );

                
            $this->db->trans_begin();
            
            $aResult = $this->Pdtfashion_model->FSvMPFHClrSzeEventAdd($aDataMaster);
            // $aResult = $this->Pdtfashion_model->FSxMPFHInsertDefaultBarCode($aDataBarCode);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Add Data"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputPdtFashion != $tImgInputPdtFashionOld){
                    $aImageUplode = array(
                        'tModuleName'       => 'product',
                        'tImgFolder'        => 'product',
                        'tImgRefID'         => $aDataMaster['FTPdtCode'].$aDataMaster['FTFhnRefCode'].$aDataMaster['FNFhnSeq'] ,
                        'tImgObj'           => $tImgInputPdtFashion,
                        'tImgTable'         => 'TFHMPdtColorSize',
                        'tTableInsert'      => 'TCNMImgPdt',
                        'tImgKey'           => 'master',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Data',
                    'nFhnSeq'      =>  $aDataMaster['FNFhnSeq']
                );
            }


            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }


    }


    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHClrSzeEventEdit(){
        try{
            $tImgInputPdtFashionOld = $this->input->post('oetImgInputPdtFashionOld');
            $tImgInputPdtFashion    = $this->input->post('oetImgInputPdtFashion');
            $nLangEdit      = $this->session->userdata("tLangEdit");
       
            if($this->input->post('ocbFhnPdtStatus')==1){
                $nFhnPdtStatus = 1;
            }else{
                $nFhnPdtStatus = 2;
            }
            
            
            $aDataMaster  = array(
                'FTPdtCode'             => $this->input->post('oetFhnPdtCode'),
                'FTFhnRefCode'          => $this->input->post('oetFhnPdtRefCode'),
                'FTFhnRefCodeOld'       => $this->input->post('oetFhnPdtRefCodeOld'),
                'FNFhnSeq'              => $this->input->post('oetFhnSeq'),
                'FTSeaCode'             => $this->input->post('oetFhnPdtSeasonCode'),
                'FTFabCode'             => $this->input->post('oetFhnPdtFabricCode'),
                'FTClrCode'             => $this->input->post('oetFhnPdtColorCode'),
                'FTPszCode'             => $this->input->post('oetFhnPdtSizeCode'),
                'FDFhnStart'            => $this->input->post('oetFhnPdtStratDate'),
                'FTFhnStaActive'        => $nFhnPdtStatus,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
            );

            $this->db->trans_begin();
            
            $aResult = $this->Pdtfashion_model->FSvMPFHClrSzeEventEdit($aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Update Data"
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputPdtFashion != $tImgInputPdtFashionOld){
                $aImageUplode = array(
                    'tModuleName'       => 'product',
                    'tImgFolder'        => 'product',
                    'tImgRefID'         => $aDataMaster['FTPdtCode'].$aDataMaster['FTFhnRefCode'].$aDataMaster['FNFhnSeq'] ,
                    'tImgObj'           => $tImgInputPdtFashion,
                    'tImgTable'         => 'TFHMPdtColorSize',
                    'tTableInsert'      => 'TCNMImgPdt',
                    'tImgKey'           => 'master',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                );
                $aImgReturn = FCNnHAddImgObj($aImageUplode);
                // echo $this->db->last_query();
                // die();
                }
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Data',
                );
            }

 
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }


    }



    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHClrSzeEventDelete(){
        try {
            $aDataDel = array(
                'FTPdtCode'         => $this->input->post('ptPdtCode'),
                'FTFhnRefCode'      => $this->input->post('ptRefCode'),
                'FNBarRefSeq'          => $this->input->post('pnSeq'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'nLangEdit'         => $this->session->userdata("tLangEdit")
            );
            //ตรวจสอบอัตราส่วนต่อหน่วยก่อนลบ
            // $aReturn = $this->Pdtfashion_model->FSaMPFHCheckPdtUnitFactB4RemoveData($aDataDel);
            $aReturn['rtCode'] = '1';
            if($aReturn['rtCode']=='1'){

                $aDataPdtBarCode      = $this->Pdtfashion_model->FSaMPFHGetDataTableBarCodeByID($aDataDel);
        
                if(!empty($aDataPdtBarCode['raItems'])){
                        foreach($aDataPdtBarCode['raItems'] as $aData){
                            $aPdtBarCode = array(
                                'FTPdtCode'         => $this->input->post('ptPdtCode'),
                                'FTFhnPdtRefCode'   => $this->input->post('ptRefCode'),
                                'FNBarRefSeq'       => $this->input->post('pnSeq'),
                                'FTBarCode'         => $aData['FTBarCode'],
                            );
                            $this->Pdtfashion_model->FSxMPFHDeleteBarCode($aPdtBarCode);
                        }
                }

                $aDataPdtSet = $this->Pdtfashion_model->FSvMPFHClrSzeEventDelete($aDataDel);
                $aDataReturn = array(
                    'nStaEvent' => $aDataPdtSet['tCode'],
                    'tStaMessg' => $aDataPdtSet['tDesc']
                );

            }else{
                $aDataReturn = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => language('product/product/product', 'tFhnPdtValidateFactorB4Remove')
                );
            }

        } catch (Exception $Error) {
            $aDataReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHBarCodeDataTable()
    {
        try {
            $aData = array(
                'FTMttTableKey'     => 'TCNMPdt',
                'FTMttRefKey'       => 'TCNMPdtBar',
                'FTPdtCode'         => $this->input->post('ptPdtCode'),
                'FTFhnRefCode'      => $this->input->post('ptRefCode'),
                'FNBarRefSeq'      => $this->input->post('ptRefSeq'),
                'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
                'nLangEdit'         => $this->session->userdata("tLangEdit")
            );

            $aDataPdtBarCode            = $this->Pdtfashion_model->FSaMPFHGetDataTableBarCodeByID($aData);
            $tPdtBarCodeViewDataTable   = $this->load->view('product/product/pdtfashion/wPdtFashionBarCdoeDataTable', $aDataPdtBarCode);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        // echo json_encode($aReturnData);

    }




    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHBarCodeUpdate()
    {

        
        // print_r($this->input->post());
        // die();
        $aPdtDataBar = array(
            'FTMttTableKey'     => 'TCNMPdt',
            'FTMttRefKey'       => 'TCNMPdtBar',
            'FTPdtCode'         => $this->input->post('FTPdtCode'),
            'FTBarCode'         => $this->input->post('FTBarCode'),
            'tOldBarCode'       => $this->input->post('tOldBarCode'),
            'FTFhnPdtRefCode'   => $this->input->post('FTFhnPdtRefCode'),
            'FNBarRefSeq'       => $this->input->post('FNBarRefSeq'),
            'FTPunCode'         => $this->input->post('FTPunCode'),
            'FTPlcCode'         => $this->input->post('FTPlcCode'),
            'FTPlcName'         => $this->input->post('FTPlcName'),
            'FTSplCode'         => $this->input->post('FTSplCode'),
            'FTSplName'         => $this->input->post('FTSplName'),
            'FTBarStaUse'       => $this->input->post('FTBarStaUse'),
            'FTBarStaAlwSale'   => $this->input->post('FTBarStaAlwSale'),
            'FTSplStaAlwPO'     => $this->input->post('FTSplStaAlwPO'),
            'FTMttSessionID'    => $this->session->userdata("tSesSessionID"),
            'tCheckStatus'      => $this->input->post('StatusAddEdit')
        );
   
        // $cPdtUnitFact = preg_replace( '/,/', '.',$this->input->post('FCPdtUnitFact'));
        // $aPdtDataPackSize = array(
        //     'FTPdtCode'         => $this->input->post('FTPdtCode'),
        //     'FTPunCode'         => $this->input->post('FTPunCode'),
        //     'FCPdtUnitFact'      => $cPdtUnitFact,
        //     'FCPdtWeight'   => 0
        // );
        // //เพิ่ม PackSize ที่ยังไม่ได้มีในสินค้า
        //  $this->Pdtfashion_model->FSaMPFHInsertPackSize($aPdtDataPackSize);

        if ($aPdtDataBar['tCheckStatus'] == "0") {
            $CheckBarCodeByID = $this->Pdtfashion_model->FSaMPFHCheckBarCodeByID($aPdtDataBar);
            if ($CheckBarCodeByID['rtCode']  == "800") { //ยังไม่เคยมี บาโค้ดใน BarRefSeq นี้
                $this->Pdtfashion_model->FSxMPFHAddUpdateBarCodeByID($aPdtDataBar);
                $aReturn = array(
                    'nStaQuery'         => 1,
                    'tStaMessg'         => 'Success',
                );
            } else {
                $aReturn = array(
                    'nStaQuery'         => 99,
                    'tStaMessg'         => language('product/product/product', 'tPDTValidPdtBarCodeDup')
                );
            }
        } else {
            //เช็คข้อมูลบาร์โค้ดว่ามีการแก้ไขหรือไม่
            if ($aPdtDataBar['FTBarCode'] == $aPdtDataBar['tOldBarCode']) {
                $CheckBarOldCodeByID = $this->Pdtfashion_model->FSaMPFHCheckBarOldCodeByID($aPdtDataBar);
                if ($CheckBarOldCodeByID['rtCode']  == '1') { //ถ้ามี บาโค้ดใน BarRefSeq นี้แล้ว
                    $this->Pdtfashion_model->FSxMPFHDeleteBarCode($aPdtDataBar);
                    $this->Pdtfashion_model->FSxMPFHAddUpdateBarCodeByID($aPdtDataBar);
                    $aReturn = array(
                        'nStaQuery'         => 1,
                        'tStaMessg'         => 'Success'
                    );
                } else {
                    $aReturn = array(
                        'nStaQuery'         => 99,
                        'tStaMessg'         => language('product/product/product', 'tPDTValidPdtBarCodeDup')
                    );
                }
            } else {
                $CheckBarOldCodeByID = $this->Pdtfashion_model->FSaMPFHCheckBarOldCodeByID($aPdtDataBar);
                //ถ้ามีการแก้ไขรหัสบาร์โค้ให้เช็ครหัสซ้ำ
                if ($CheckBarOldCodeByID['rtCode']  == "800") { //ไม่มีรายการ bar code เดิม แล้วมัน edit มาได้ยังไง? แปลว่า error
                    $aReturn = array(
                        'nStaQuery'         => 99,
                        'tStaMessg'         => language('product/product/product', 'tPDTValidPdtBarCodeDup')
                    );
                } else {
                    //ตรวจสอบว่า barcode ใหม่ที่จะใช้มันไปซ้ำกับใครไหม
                    $CheckBarCodeByID = $this->Pdtfashion_model->FSaMPFHCheckBarCodeByID($aPdtDataBar);
                    if ($CheckBarCodeByID['rtCode']  == "800") { // bar code ใหม่ ไม่ซ้ำกับใคร
                        $this->Pdtfashion_model->FSxMPFHDeleteBarCode($aPdtDataBar);
                        $this->Pdtfashion_model->FSxMPFHAddUpdateBarCodeByID($aPdtDataBar);
                        $aReturn = array(
                            'nStaQuery'         => 1,
                            'tStaMessg'         => 'Success',
                        );
                    } else {
                        $aReturn = array(
                            'nStaQuery'         => 99,
                            'tStaMessg'         => language('product/product/product', 'tPDTValidPdtBarCodeDup')
                        );
                    }
                }
            }
        }
        
        // $aClearPackSizeNotUse = array(
        //     'FTPdtCode'         => $this->input->post('FTPdtCode'),
        //     'FTFhnRefCode'      => $this->input->post('FTFhnPdtRefCode'),
        // );
        // //ลบ PackSize ที่ไม่มีหน่วยที่ใช้ในตาราง BarCode 
        // $this->Pdtfashion_model->FSaMPFHClearPackSizeNotUse($aClearPackSizeNotUse);

        echo json_encode($aReturn);
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHBarCodeDelte()
    {
        $aPdtBarCode = array(
            'FTPdtCode'         => $this->input->post('FTPdtCode'),
            'FNBarRefSeq'    => $this->input->post('FNBarRefSeq'),
            'FTBarCode'         => $this->input->post('FTBarCode')
        );
        $this->Pdtfashion_model->FSxMPFHDeleteBarCode($aPdtBarCode);
    }

    //Functionality : Function Add PdtFashion
    //Parameters : From Ajax File PdtFashion
    //Creator : 27/04/2021 Nattakit
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSvCPFHCheckModelNo(){

        $tPdtCode =  $this->input->post('tPdtCode');
        $tFhnPdtModelNo =  $this->input->post('tFhnPdtModelNo');
        $aResult = $this->Pdtfashion_model->FSvMPFHCheckModelNo($tFhnPdtModelNo,$tPdtCode);
        echo json_encode($aResult);
    }

}