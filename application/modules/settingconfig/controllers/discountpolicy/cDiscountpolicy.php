<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cDiscountpolicy extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('settingconfig/discountpolicy/mDiscountpolicy');
        date_default_timezone_set("Asia/Bangkok");
    }


    public function index($nDispocilyBrowseType, $tDispocilyBrowseOption){

        $aDataConfigView = [
            'nDispocilyBrowseType'      => $nDispocilyBrowseType,
            'tDispocilyBrowseOption'    => $tDispocilyBrowseOption,
            'aAlwEvent'                 => FCNaHCheckAlwFunc('discountpolicy/0/0'),
            'vBtnSave'                  => FCNaHBtnSaveActiveHTML('discountpolicy/0/0'),
            'nOptDecimalShow'           => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'           => FCNxHGetOptionDecimalSave()
        ];

        $this->load->view('settingconfig/discountpolicy/wDiscountpolicy', $aDataConfigView);
    }

    //Functionality : Function Call DisCountPolicy Page List
    // Create By WItsarut 17/07/2020
    public function FSvDPCDisPageList(){

        $aDataAlwEvent = array(
            'aAlwEvent'   => FCNaHCheckAlwFunc('discountpolicy/0/0'),
        );

        $this->load->view('settingconfig/discountpolicy/wDiscountpolicyList', $aDataAlwEvent);
    }

    //Functionality : Function Call DataTables DisCountPolicy
    // Create By Witsarut 17/07/2020
    public function FSvDPCDisGetdataTable(){
        try{
            $tSearchAll  = $this->input->post('tSearchAll');
            $nLngID      = $this->session->userdata("tLangEdit");
            $aAlwEvent   = FCNaHCheckAlwFunc('discountpolicy/0/0');

            $aData = array(
               'tSearchAll' => $tSearchAll,
                'FNLngID'   => $nLngID,
            );

            // เอาไว้ Auto สร้าง config เข้ามายังตาราง TPSTDiscPolicy
            $this->mDiscountpolicy->FSaMPRGDataAutoConfig(); 


            // Check Data Status ว่าถ้าเป็น 2 ให้ Delete ออก
            $aGetDataStaUse   = $this->mDiscountpolicy->FSaMPRGDataStaDelUse($aData); 
            $aNewArratMerge = array();
            for($i=0; $i<FCNnHSizeOf($aGetDataStaUse['raItems']); $i++){
                $aItem = array();
                $aItem['X'] = $aGetDataStaUse['raItems'][$i]['FTDisCode'];
                for($j=0; $j<FCNnHSizeOf($aGetDataStaUse['raItems']); $j++){
                    $aItem['Y'] = $aGetDataStaUse['raItems'][$j]['FTDisCode'];
                    if( $aItem['X'] == $aGetDataStaUse['raItems'][$i]['FTDisCode'] &&  $aGetDataStaUse['raItems'][$i]['FTDisStaUse'] == 1  && $aItem['Y'] == $aGetDataStaUse['raItems'][$j]['FTDisCode'] && $aGetDataStaUse['raItems'][$j]['FTDisStaUse'] == 1 ){
                        $aItem['USE'] = 'USE';
                    }else{
                        $aItem['USE'] = 'NONE';
                    }
                    array_push($aNewArratMerge,$aItem);
                }
            }

            // echo '<pre>';
            // print_r($aNewArratMerge);
            // echo '</pre>';

            //Check StatusUse 1.ใช้งาน 2.ไม่ใช้งาน
            for($k=0; $k<FCNnHSizeOf($aNewArratMerge); $k++){
                if($aNewArratMerge[$k]['USE'] == 'NONE'){
                    $tDpcDisCodeX   = $aNewArratMerge[$k]['X'];
                    $tDpcDisCodeY   = $aNewArratMerge[$k]['Y'];

                    $this->mDiscountpolicy->FSaMPRGDeleteCodeXY($tDpcDisCodeX, $tDpcDisCodeY);
                }
            }


            // 1. Get ข้อมูลจาก ตาราง TPSTDiscPolicy distinct FTDpcDisCodeX 
            $aResultData  = $this->mDiscountpolicy->FSaMPRGDataComma();

            //Get data Table Header
            $aDatatableHeader   = $this->mDiscountpolicy->FSaMPRGDataTableHeader($aData); 

            $rs_array = [];
            if($aResultData['rtCode'] == 1){
                foreach($aResultData['raItems'] AS $key=>$aValue){
                    for($i = 1; $i <= $aValue['FTDpcDisCodeY']; $i++){
                        $rs_array[] = 'FTDpcDisCodeY' . $i.',' . 'FTDpcStaAlw'.$i . ',' . 'Column_YN'.$i . ',' . 'Column_B'.$i ;
                    }
                }
            }

            $tDataImplode = implode(',', $rs_array);
            $tYColumnShow = 'FTDpcDisCodeX'.','.$tDataImplode;

            $aDatatable   = $this->mDiscountpolicy->FSaMPRGDataTable($aData, $tDataImplode, $tYColumnShow);

            $aGenTable  = array(
                'tSearchAll'        => $tSearchAll,
                'aAlwEventDpcDis'   => $aAlwEvent,
                'aDatatableHeader'  => $aDatatableHeader,
                'aDatatable'        => $aDatatable 
            );

            $this->load->view('settingconfig/discountpolicy/wDiscountpolicyDataTable',$aGenTable);

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //faunction SaveData
    // Create By Witsarut 20/07/2020
    public function FSvDPCDisSaveData(){
        try{
            $aDataStaAlw = $this->input->post('data');

            for($i=0; $i<FCNnHSizeOf($aDataStaAlw); $i++){
                $tDisCodeX = $aDataStaAlw[$i][0];
                $tDisCodeY = $aDataStaAlw[$i][1];
                $tStaAlw   = $aDataStaAlw[$i][2];

                $aDataUpdate = array(
                    'tDisCodeX'     => $tDisCodeX,
                    'tDisCodeY'     => $tDisCodeY,
                    'tStaAlw'       => $tStaAlw,
                    'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'    => date('Y-m-d H:i:s'), //วันที่ปรับปรุงรายการล่าสุด
                    'FTCreateBy'    => $this->session->userdata('tSesUsername') //ผู้สร้างรายการ
                );

                $aDatatable   = $this->mDiscountpolicy->FSaMPRGUpdateMasterDataTable($aDataUpdate);
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }
}