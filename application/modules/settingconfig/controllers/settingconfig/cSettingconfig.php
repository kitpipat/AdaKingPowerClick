<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSettingconfig extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('settingconfig/settingconfig/mSettingconfig');
    }
    
    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('settingconfig/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('settingconfig/0/0'); 
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave(); 
        $this->load->view('settingconfig/settingconfig/wSettingconfig', $aData);
    }

    //Get Page List (Tab : ตั้งค่าระบบ , รหัสอัตโนมัติ)
    public function FSvSETGetPageList(){
        $this->load->view('settingconfig/settingconfig/wSettingconfigList');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บตั้งค่าระบบ

    //Get Page List (Content : แท็บตั้งค่าระบบ)
    public function FSvSETGetPageListSearch(){
        $aOption = $this->mSettingconfig->FSaMSETGetAppTpye();
        $aReturn = array(
            'aOption'   => $aOption,
            'tTypePage' => $this->input->post('ptTypePage')
        );
        $this->load->view('settingconfig/settingconfig/Config/wConfigList',$aReturn);
    }

    //Get Table (แท็บตั้งค่าระบบ)
    public function FSvSETSettingGetTable(){
        $aAlwEvent      = FCNaHCheckAlwFunc('settingconfig/0/0'); 
        $tAppType       = $this->input->post('tAppType');
        $tSearch        = $this->input->post('tSearch');
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearch,
            'tAppType'      => $tAppType,
            'tTypePage'     => $this->input->post("ptTypePage"),
            'FTAgnCode'     => $this->input->post("ptAgnCode")
        );

        $aResListCheckbox       = $this->mSettingconfig->FSaMSETConfigDataTableByType($aData,'checkbox');
        $aResListInputText      = $this->mSettingconfig->FSaMSETConfigDataTableByType($aData,'input');
        $aGenTable  = array(
            'aAlwEvent'             => $aAlwEvent,
            'aResListCheckbox'      => $aResListCheckbox,
            'aResListInputText'     => $aResListInputText
        );

        $this->load->view('settingconfig/settingconfig/Config/wConfigDatatable',$aGenTable);
    }

    //Event Save (แท็บตั้งค่าระบบ)
    public function FSxSETSettingEventSave(){
        $aMergeArray = $this->input->post('aMergeArray');
        $tTypePage   = $this->input->post('ptTypePage');
        $tAgnCode    = $this->input->post('ptAgnCode');
        if(FCNnHSizeOf($aMergeArray) >= 1){
            for($i=0; $i<FCNnHSizeOf($aMergeArray); $i++){

                //Type
                if($aMergeArray[$i]['tType'] == 'checkbox'){
                    $nType = 4;
                }else{
                    $nType = $aMergeArray[$i]['tType'];
                }

                //Packdata
                $aUpdate = array(
                    'FTSysCode'             =>  $aMergeArray[$i]['tSyscode'],
                    'FTSysApp'              =>  $aMergeArray[$i]['tSysapp'],
                    'FTSysKey'              =>  $aMergeArray[$i]['tSyskey'],
                    'FTSysSeq'              =>  $aMergeArray[$i]['tSysseq'],
                    'FTSysStaDataType'      =>  $nType,
                    'nValue'                =>  $aMergeArray[$i]['nValue'],
                    'tKind'                 =>  $aMergeArray[$i]['tKind'],
                    'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                    'tTypePage'             => $tTypePage,
                    'FTAgnCode'             => $tAgnCode
                );

                //Update
                $aResList   = $this->mSettingconfig->FSaMSETUpdate($aUpdate);
            }
        }
    }

    //Event Use Default value ใช้แม่แบบ (แท็บตั้งค่าระบบ)
    public function FSxSETSettingUseDefaultValue(){
        $aReturn = $this->mSettingconfig->FSaMSETUseValueDefult();
        echo $aReturn;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////// แท็บรหัสอัตโนมัติ

    //Get Page List (Content : แท็บรหัสอัตโนมัติ)
    public function FSvSETAutonumberGetPageListSearch(){
        $aOption = $this->mSettingconfig->FSaMSETGetAppTpye();
        $aReturn = array(
            'aOption' => $aOption
        );
        $this->load->view('settingconfig/settingconfig/Autonumber/wAutonumberList',$aReturn);
    }

    //Get Table (แท็บรหัสอัตโนมัติ)
    public function FSvSETAutonumberSettingGetTable(){
        $aAlwEvent      = FCNaHCheckAlwFunc('settingconfig/0/0'); 
        $tAppType       = $this->input->post('tAppType');
        $tSearch        = $this->input->post('tSearch');
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $tAgnCode       = $this->input->post("tAgnCode");

        if($tAgnCode == '' || $tAgnCode == null){
            $tAgnCode = '';
        }else{
            $tAgnCode = $tAgnCode;
        }

        $aData  = array(
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearch,
            'tAppType'      => $tAppType,
            'tAgnCode'      => $tAgnCode
        );

        $aItemRecord    = $this->mSettingconfig->FSaMSETConfigDataTableAutoNumber($aData);
        $aGenTable      = array(
            'aAlwEvent'        => $aAlwEvent,
            'aItemRecord'      => $aItemRecord
        );

        $this->load->view('settingconfig/settingconfig/Autonumber/wAutonumberDatatable',$aGenTable);
    }

    //Load Page Edit
    public function FSvSETAutonumberPageEdit(){
        $aAlwEvent   = FCNaHCheckAlwFunc('settingconfig/0/0'); 
        $tTable      = $this->input->post('ptTable');
        $nSeq        = $this->input->post('pnSeq');
        $tAgnCode    = $this->input->post("tAgnCode");

        $aWhere      = array(
            'FTSatTblName'      => $tTable,
            'FTSatStaDocType'   => $nSeq,
            'tAgnCode'          => $tAgnCode
        );
        $aAllowItem  = $this->mSettingconfig->FSaMSETConfigGetAllowDataAutoNumber($aWhere);
        
        $aGenTable   = array(
            'aAlwEvent'         => $aAlwEvent,
            'aAllowItem'        => $aAllowItem,
            'nMaxFiledSizeBCH'  => $this->mSettingconfig->FSaMSETGetMaxLength('TCNMBranch'),
            'nMaxFiledSizePOS'  => $this->mSettingconfig->FSaMSETGetMaxLength('TCNMPos')
        );
        $this->load->view('settingconfig/settingconfig/Autonumber/wAutonumberPageAdd',$aGenTable);
    }

    //บันทึก
    public function FSvSETAutonumberEventSave(){
        $tTypedefault   = $this->input->post('tTypedefault');
        $aPackData      = $this->input->post('aPackData');
        $tAgnCode       = $this->input->post('tAgnCode');

        if($tAgnCode == '' || $tAgnCode == null){
            $tAgnCode = '';
        }else{
            $tAgnCode = $tAgnCode;
        }

        if($tTypedefault == 'default'){
            $aDelete = array(
                'FTAhmTblName'      => $aPackData[0],
                'FTAhmFedCode'      => $aPackData[1],
                'FTSatStaDocType'	=> $aPackData[2],
                'FTAgnCode'         => $tAgnCode
            );
            $this->mSettingconfig->FSaMSETAutoNumberDelete($aDelete);
        }else{
            $aIns = array(
                'FTAhmTblName'      => $aPackData[0],
                'FTAhmFedCode'      => $aPackData[1],
                'FTSatStaDocType'   => $aPackData[2],
                'FTAhmFmtAll'       => $aPackData[3]['FTAhmFmtAll'],
                'FTAhmFmtPst'       => $aPackData[3]['FTAhmFmtPst'], 
                'FNAhmFedSize'      => $aPackData[3]['FNAhmFedSize'],
                'FTAhmFmtChar'      => $aPackData[3]['FTAhmFmtChar'],
                'FTAhmStaBch'       => $aPackData[3]['FTAhmStaBch'],
                'FTAhmFmtYear'      => $aPackData[3]['FTAhmFmtYear'],
                'FTAhmFmtMonth'     => $aPackData[3]['FTAhmFmtMonth'],
                'FTAhmFmtDay'       => $aPackData[3]['FTAhmFmtDay'],
                'FTSatStaAlwSep'    => $aPackData[3]['FTSatStaAlwSep'],
                'FNAhmLastNum'      => $aPackData[3]['FNAhmLastNum'],
                'FNAhmNumSize'      => $aPackData[3]['FNAhmNumSize'],
                'FTAhmStaReset'     => $aPackData[3]['FTAhmStaReset'],
                'FTAhmFmtReset'     => $aPackData[3]['FTAhmFmtReset'],
                'FTAhmLastRun'      => $aPackData[3]['FTAhmLastRun'],
                'FTSatUsrNum'       => $aPackData[3]['FTSatUsrNum'],
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTAgnCode'         => $tAgnCode
            );

            //Delete ก่อน
            // $this->mSettingconfig->FSaMSETAutoNumberDelete($aIns);

            //Insert
            $this->mSettingconfig->FSaMSETAutoNumberInsert($aIns);
        }
    }

    //Function InsertData Config
    //Create By Sooksanti(Non) 05-11-2020
    public function FSxSETSettingConfigExport(){
        
        $tfile_pointer = 'application/modules/settingconfig/views/settingconfig/Config/Export';
        if (!file_exists($tfile_pointer)) {
            mkdir($tfile_pointer);
        }
        //GetData Tsysconfig
        $aPackDataTsysconfig  = $this->mSettingconfig->FSaMSETExportDetailTsysconfig();

        //Get Data Tsysconfig_L
        $aPackDataTsysconfig_L = $this->mSettingconfig->FSaMSETExportDetailTSysConfig_L();

        $aItemTsysconfig       = $aPackDataTsysconfig['raItems'];
        $aItemTsysconfig_L     = $aPackDataTsysconfig_L['raItems'];

        $aWriteData      = array();
        $nKeyIndexImport = 0;
        $nCntModCode     = 999;
        
        $aDataArrayTsysconfig  = array(
            'tTable'  => 'TSysConfig',
            'tItem'    => array(),
        );    

        for($i=0; $i<FCNnHSizeOf($aItemTsysconfig); $i++){
                $aParam = [
                    'tTable'            => 'TSysConfig',
                    'FTSysCode'         => $aItemTsysconfig[$i]['FTSysCode'],
                    'FTSysApp'          => $aItemTsysconfig[$i]['FTSysApp'],
                    'FTSysKey'          => $aItemTsysconfig[$i]['FTSysKey'],
                    'FTSysSeq'          => $aItemTsysconfig[$i]['FTSysSeq'],
                    'FTGmnCode'         => $aItemTsysconfig[$i]['FTGmnCode'],
                    'FTSysStaAlwEdit'   => $aItemTsysconfig[$i]['FTSysStaAlwEdit'],
                    'FTSysStaDataType'  => $aItemTsysconfig[$i]['FTSysStaDataType'],
                    'FNSysMaxLength'    => $aItemTsysconfig[$i]['FNSysMaxLength'],
                    'FTSysStaDefValue'  => $aItemTsysconfig[$i]['FTSysStaDefValue'],
                    'FTSysStaDefRef'    => $aItemTsysconfig[$i]['FTSysStaDefRef'],
                    'FTSysStaUsrValue'  => $aItemTsysconfig[$i]['FTSysStaUsrValue'],
                    'FTSysStaUsrRef'    => $aItemTsysconfig[$i]['FTSysStaUsrRef'],
                    'FDLastUpdOn'       => $aItemTsysconfig[$i]['FDLastUpdOn'],
                    'FTLastUpdBy'       => $aItemTsysconfig[$i]['FTLastUpdBy'],
                    'FDCreateOn'        => $aItemTsysconfig[$i]['FDCreateOn'],
                    'FTCreateBy'        => $aItemTsysconfig[$i]['FTCreateBy'],

                ];

            array_push($aDataArrayTsysconfig['tItem'], $aParam);
        }

        $aDataArrayTsysconfig_L = array(
            'tTable'  => 'TSysConfig_L',
            'tItem'    => array(),
        );    

        for($j=0; $j<FCNnHSizeOf($aItemTsysconfig_L); $j++){
            $aParam = [
                'tTable'            => 'TSysConfig_L',
                'FTSysCode'         => $aItemTsysconfig_L[$j]['FTSysCode'],
                'FTSysApp'          => $aItemTsysconfig_L[$j]['FTSysApp'],
                'FTSysKey'          => $aItemTsysconfig_L[$j]['FTSysKey'],
                'FTSysSeq'          => $aItemTsysconfig_L[$j]['FTSysSeq'],
                'FNLngID'           => $aItemTsysconfig_L[$j]['FNLngID'],
                'FTSysName'         => $aItemTsysconfig_L[$j]['FTSysName'],
                'FTSysDesc'         => $aItemTsysconfig_L[$j]['FTSysDesc'],
                'FTSysRmk'          => $aItemTsysconfig_L[$j]['FTSysRmk']
            ];

            array_push($aDataArrayTsysconfig_L['tItem'], $aParam);
        }

        array_push($aWriteData,$aDataArrayTsysconfig,$aDataArrayTsysconfig_L);

        $aResultWrite   = json_encode($aWriteData, JSON_PRETTY_PRINT);
        $tFileName      = "ExportConfig".$this->session->userdata('tSesUsername').date('His');
        
        $tPATH          = APPPATH . "modules/settingconfig/views/settingconfig/Config/Export//".$tFileName.".json";

        $handle         = fopen($tPATH, 'w+');

        if($handle){
            if(!fwrite($handle, $aResultWrite))  die("couldn't write to file."); 
        }

        //ส่งชื่อไฟล์ออกไป
        $aReturn = array(
            'tStatusReturn' => '1',
            'tFilename'     => $tFileName
        );
        echo json_encode($aReturn);

    }


    //Function InsertData Config
    //Create By Sooksanti(Non) 05-11-2020
    function FSxSETConfigInsertData()
    {
        try {
            $tDataJSon = $this->input->post('aData');

            $this->db->trans_begin();

            //Insert ตาราง TSysConfig
            if (!empty($tDataJSon[0]['tItem'])) {
                $aDataDeleteTSysConfigTmp = $this->mSettingconfig->FSaMSETDeleteTSysConfigTmp();
                $aDataInsToTmpTSysConfig = $this->mSettingconfig->FSaMSETInsertToTmpTSysConfig();
                $aDataDeleteTSysConfig = $this->mSettingconfig->FSaMSETDeleteTSysConfig();
                foreach ($tDataJSon[0]['tItem'] as $key => $aValue) {
                    $aDataInsTSysConfig = array(
                        'FTSysCode'         => $aValue['FTSysCode'],
                        'FTSysApp'          => $aValue['FTSysApp'],
                        'FTSysKey'          => $aValue['FTSysKey'],
                        'FTSysSeq'          => $aValue['FTSysSeq'],
                        'FTGmnCode'         => $aValue['FTGmnCode'],
                        'FTSysStaAlwEdit'   => $aValue['FTSysStaAlwEdit'],
                        'FTSysStaDataType'  => $aValue['FTSysStaDataType'],
                        'FNSysMaxLength'    => $aValue['FNSysMaxLength'],
                        'FTSysStaDefValue'  => $aValue['FTSysStaDefValue'],
                        'FTSysStaDefRef'    => $aValue['FTSysStaDefRef'],
                        'FTSysStaUsrValue'  => $aValue['FTSysStaUsrValue'],
                        'FTSysStaUsrRef'    => $aValue['FTSysStaUsrRef'],
                        'FDLastUpdOn'       => $aValue['FDLastUpdOn'],
                        'FTLastUpdBy'       => $aValue['FTLastUpdBy'],
                        'FDCreateOn'        => $aValue['FDCreateOn'],
                        'FTCreateBy'        => $aValue['FTCreateBy'],
                    );

                    $aDataInsTSysConfig = $this->mSettingconfig->FSaMSETInsertTSysConfig($aDataInsTSysConfig);
                    }
                }

                if (!empty($tDataJSon[1]['tItem'])) {
                    $aDataDeleteTSysConfig_LTmp = $this->mSettingconfig->FSaMSETDeleteTSysConfig_LTmp();
                    $aDataInsToTmpTSysConfig_L = $this->mSettingconfig->FSaMSETInsertToTmpTSysConfig_L();
                    $aDataDeleteTSysConfig_LTmp = $this->mSettingconfig->FSaMSETDeleteTSysConfig_L();
                    foreach ($tDataJSon[1]['tItem'] as $key => $aValue) {
                        $aDataInsTSysConfig_L = array(
                            'FTSysCode'         => $aValue['FTSysCode'],
                            'FTSysApp'          => $aValue['FTSysApp'],
                            'FTSysKey'          => $aValue['FTSysKey'],
                            'FTSysSeq'          => $aValue['FTSysSeq'],
                            'FNLngID'           => $aValue['FNLngID'],
                            'FTSysName'         => $aValue['FTSysName'],
                            'FTSysDesc'         => $aValue['FTSysDesc'],
                            'FTSysRmk'          => $aValue['FTSysRmk']
                        );

                        $aDataInsTSysConfig_L = $this->mSettingconfig->FSaMSETInsertTSysConfig_L($aDataInsTSysConfig_L);
                    }
                }
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess Import",
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Import'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    
}