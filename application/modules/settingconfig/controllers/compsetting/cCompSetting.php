<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCompSetting extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        // $this->load->model('settingconfig/compsetting/mCompSetting');
    }
    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('CompSettingCon/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('CompSettingCon/0/0'); 
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave(); 
        $this->load->view('settingconfig/compsetting/wCompSetting', $aData);

    }

    //Get Page List (Tab : ตั้งค่าการเชื่อมต่อ API)
    public function FSvSETCompGetPageList(){
        $this->load->view('settingconfig/compsetting/wCompSettingList');
    }

    //Get Page List (Content : แท็บตั้งค่าการเชื่อมต่อ API)
    public function FSvSETCompGetPageListSearch(){

        $this->load->view('settingconfig/compsetting/wCompConfigList');
    }

}
