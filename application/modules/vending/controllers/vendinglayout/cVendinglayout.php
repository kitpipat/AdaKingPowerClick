<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVendinglayout extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('vending/vendinglayout/mVendinglayout');
        date_default_timezone_set("Asia/Bangkok");
    }

    public $aHeight;
    public function index(){
        $nMsgResp               = array('title'=>"Vending Shop Layout");
        $vBtnSave               = FCNaHBtnSaveActiveHTML('vendingshoplayout/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwvendingshoplayout	= FCNaHCheckAlwFunc('vendingshoplayout/0/0');
        $this->load->view('vending/vendinglayout/wVendinglayout', array (
            'nMsgResp'                      => $nMsgResp,
            'vBtnSave'                      => $vBtnSave,
            'aAlwEventvendingshoplayout'    => $aAlwvendingshoplayout,
            'tShpCode'                      => $this->input->post('tShpCode'),
            'tBchCode'                      => $this->input->post('tBchCode')
        ));
    }

    //วิ่งเข้าฟังก์ชั่นแรก
    public function FSvVEDListPage(){
        $aPackData = array(
            'tShpCode'    => $this->input->post('tShpCode'),
            'tBchCode'    => $this->input->post('tBchCode')
        );
        //Stat dose - newUI
        $this->FSvVEDShowViewDiagram($aPackData);
    }

    //เข้าหน้า เซตข้อมูล
    public function FSvVEDShowViewSetting($paPackData){
        $this->load->view('vending/vendinglayout/wVendinglayoutSetting',$paPackData);
    }

    //เอาข้อมูลของ HD Setting ออกมาโชว์
    public function FSvVEDSelectSetting(){
        $tShpCode       = $this->input->post('tShpCode');
        $tBchCode       = $this->input->post('tBchCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');
        $paPackData = array(
            'tShpCode'       => $tShpCode,
            'tBchCode'       => $tBchCode,
            'nSeqCabinet'    => $nSeqCabinet
        );
        $aGetDataHeightFloor    = $this->mVendinglayout->FSaMVEDGetDataHeightFloor($paPackData);
        $aGetDataHeightTemp     = $this->mVendinglayout->FSaMVEDGetDataHeightTemp($paPackData);

        $aReturn = array(
            // 'aGetDataSetting'       => $aGetDataSetting,
            'aGetDataHeightFloor'   => $aGetDataHeightFloor,
            'aGetDataHeightTemp'    => $aGetDataHeightTemp
        );
        
        echo json_encode($aReturn);
    }

    //เข้าหน้า แสดงข้อมูลสินค้า
    public function FSvVEDShowViewDiagram($paPackData){
        $aGetDataCabinet    = $this->mVendinglayout->FSaMVEDGetCabinet($paPackData);
        $aGetWahhouse       = $this->mVendinglayout->FSaMVEDGetWahhouse($paPackData);

        $aData = array(
            'aCabinet'      =>  $aGetDataCabinet,
            'aGetWahhouse'  =>  $aGetWahhouse
        );
        $this->load->view('vending/vendinglayout/wVendinglayoutDiagram',$aData);
    }

    //เพิ่มจำนวนชั้น จำนวนช่อง
    public function FSvVEDInsertSetting(){
        $aPackData = array(
            'tShpCode'          => $this->input->post('tShpCode'),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tVBName'           => $this->input->post('tVBName'),
            'nVBFloor'          => $this->input->post('nVBFloor'),
            'nVBColumn'         => $this->input->post('nVBColumn'),
            'tVBReason'         => $this->input->post('tVBReason'),
            'aHeight'           => $this->input->post('aHeight'),
            'tTypePage'         => $this->input->post('tTypePage'),
            'tDisType'          => $this->input->post('tDisType'),
            'tCabinetSeq'       => $this->input->post('tCabinetSeq'), 
        );

        //เซตความสูงเก็บไว้เป็นตัวแปร global
        $aHeight          = $this->input->post('aHeight');
        $nKeyIndex        = 0;
        
        $this->mVendinglayout->FSaMVEDDeleteHeightToTmp($aPackData);
        for($i=1; $i<=FCNnHSizeOf($aHeight); $i++){
            $this->mVendinglayout->FSaMVEDInsertHeightToTmp($i,$aHeight[$nKeyIndex],$aPackData);
            $nKeyIndex++;
        }
        
        //เพิ่มข้อมูลลงตาราง TVDMShopCabinet (เก็บว่าใช้กี่ชั้น ใช้กี่ช่อง)
        $aFindVendingLayout     = $this->mVendinglayout->FSxMVEDUpdateCabinet($aPackData);
        return $aFindVendingLayout;
    }

    //เพิ่มพวกสินค้าลง ฐานข้อมูล
    public function FSxVEDInsertDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $aPackData      = $this->input->post('aPackData');
        $nColQtyMax     = $this->input->post('nColQtyMax');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        //หาว่า mercode อะไร
        $aDataCondition = array(
            'FTBchCode'         => $tBchCode,
            'FTShpCode'         => $tShopCode,
            'FNCabSeq'          => $nSeqCabinet
        );
        $aReturnMerCode = $this->mVendinglayout->FSaMVslFindMerCode($aDataCondition);

        //ลบสินค้าก่อนทุกครั้ง
        $this->mVendinglayout->FSaMVslDeleteItem($aDataCondition);

        //เพิ่มข้อมูลสินค้าจาก diagram
        for($j=0; $j<FCNnHSizeOf($aPackData); $j++){
            $aColumn = $aPackData[$j];

            $aDataInsert = array(
                'FTBchCode'         => trim($tBchCode),
                'FNCabSeq'          => $nSeqCabinet,
                'FTMerCode'         => $aReturnMerCode['raItems'][0]['FTMerCode'],
                'FTShpCode'         => $tShopCode,
                'FNLayRow'          => $aColumn['nFloor'],
                'FNLayCol'          => $aColumn['nColumn'] - 1,
                'FTPdtCode'         => $aColumn['nPDTCode'],    
                'FCLayColQtyMax'    => $aColumn['nDim'],
                'FCLayDim'          => $aColumn['nDim'],
                'FCLayHigh'         => $this->mVendinglayout->FStMVEDFindHeight(trim($tBchCode),trim($tShopCode),$aColumn['nFloor'],$nSeqCabinet),
                'FCLayWide'         => $aColumn['nUseColumn'],
                'FTLayStaUse'       => 1,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLayStaCtrlXY'    => $aColumn['tStatusSpring'],
                'FTWahCode'         => $aColumn['nWahCode']
            );

            $this->mVendinglayout->FSaMVslInsertPDT($aDataInsert);
        }

        //เรียง Seq ใหม่
        $this->mVendinglayout->FSxMVEDSortSeqrow($aDataCondition);

        //Update STKBal ให้เป็น 0
        $this->mVendinglayout->FSxMVEDDeleteSTKBal($aDataCondition);
    }

    //ไปค้นหาว่ามีข้อมูลไหม ถ้ามี ให้เอามาโชว์
    public function FSxVEDGetPDTShopLayout(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );

        $aGetDataDT     = $this->mVendinglayout->FSaMVEDGetDataDT($paPackData);
        $aData = array(
            'aDT'       => $aGetDataDT,
        );

        echo json_encode($aData);
    }

    //ลบข้อมูลใน diagram เพื่อที่จะต้องการสร้างใหม่
    public function FSxVEDDeleteDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );

        $aDeleteLayout = $this->mVendinglayout->FSaMVEDDeleteDiagram($paPackData);
        echo json_encode($aDeleteLayout);
    }

    //Export
    public function FSxVEDExportDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $nSeqCabinet    = $this->input->post('nSeqCabinet');

        //Check ว่าถ้าไม่เจอสินค้า PDTLayout จะ export ไม่ได้
        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );
        $aCheckPDTLayout = $this->mVendinglayout->FSaMVEDCheckPDTInCabinet($paPackData);
        if($aCheckPDTLayout == 'Notfound'){
            $aReturn = array(
                'tStatusReturn' => '800',
                'tFilename'     => ''
            );
            echo json_encode($aReturn);
            exit;
        }

        //เอารายละเอียดของ layout ส่งออก
        $paPackData = array(
            'tShpCode'          => $tShopCode,
            'tBchCode'          => $tBchCode,
            'nSeqCabinet'       => $nSeqCabinet
        );
        $aPackDataResult = $this->mVendinglayout->FSaMVEDExportDetailDiagram($paPackData);
        $aItem           = $aPackDataResult['raItemsLayout'];
        $aWriteData      = array();
        $tSHP            = '';
        $nKeyIndexImport = 0;
        $nCabSeq         = 999;
        $nType           = '';
        for($i=0; $i<FCNnHSizeOf($aItem); $i++){
            
            //เช็คจาก CABINET
            if($nCabSeq != $aItem[$i]['FNCabSeq']){
                $aParam = [
                    'tTable'        => 'TVDMShopCabinet',
                    'FNCabSeq'      => $aItem[$i]['FNCabSeq'],
                    'FNCabMaxRow'   => $aItem[$i]['FNCabMaxRow'],
                    'FNCabMaxCol'   => $aItem[$i]['FNCabMaxCol'],
                    'FNCabType'     => $aItem[$i]['FNCabType'],
                    'FTShtCode'     => $aItem[$i]['FTShtCode'],
                    'FTCabName'     => $aItem[$i]['FTCabName']
                ]; 
                array_push($aWriteData, $aParam);
            }

            //เช็คจาก CABINET
            if($nCabSeq != $aItem[$i]['FNCabSeq']){
                $aParam = [
                    'tTable'        => 'TVDMShopCabinet_L',
                    'FNCabSeq'      => $aItem[$i]['FNCabSeq'],
                    'FNLngID'       => $aItem[$i]['FNLngID'],
                    'FTCabName'     => $aItem[$i]['FTCabName'],
                    'FTCabRmk'      => $aItem[$i]['FTCabRmk']
                ]; 
                array_push($aWriteData, $aParam);
            }

            //เช็คจาก TYPE
            if($nType != $aItem[$i]['FTShtCode']){
                $aParam = [
                    'tTable'        => 'TVDMShopType',
                    'FTShtCode'     => $aItem[$i]['FTShtCode'],
                    'FTShtType'     => $aItem[$i]['FTShtType'],
                    'FNShtValue'    => $aItem[$i]['FNShtValue'],
                    'FNShtMin'      => $aItem[$i]['FNShtMin'],
                    'FNShtMax'      => $aItem[$i]['FNShtMax']
                ]; 
                array_push($aWriteData, $aParam);
            }

            //เช็คจาก TYPE
            if($nType != $aItem[$i]['FTShtCode']){
                $aParam = [
                    'tTable'        => 'TVDMShopType_L',
                    'FTShtCode'     => $aItem[$i]['FTShtCode'],
                    'FTShtName'     => $aItem[$i]['FTShtName'],
                    'FTShtRemark'   => $aItem[$i]['FTShtRemark']
                ]; 
                array_push($aWriteData, $aParam);
            }

            //เช็คจาก TABLE
            if($tSHP != $aItem[$i]['FTShpCode']){
                $aParam = [
                    'tTable'        => 'TVDMPdtLayout',
                    'tItem'         => array()
                ]; 
                array_push($aWriteData, $aParam);
                $nKeyIndexImport = array_search('TVDMPdtLayout',array_column($aWriteData, 'tTable'));
            }

            $aParam = array(
                    'tTable'           => 'TVDMPdtLayout',
                    'FTMerCode'        => $aItem[$i]['FTMerCode'],
                    'FNCabSeq'         => $aItem[$i]['FNCabSeq'],
                    'FNLayRow'         => $aItem[$i]['FNLayRow'],
                    'FNLayCol'         => $aItem[$i]['FNLayCol'],
                    'FTLayStaCtrlXY'   => $aItem[$i]['FTLayStaCtrlXY'],
                    'FTPdtCode'        => $aItem[$i]['FTPdtCode'],
                    'FTPdtName'        => $aItem[$i]['FTPdtName'],
                    'FCLayColQtyMax'   => $aItem[$i]['FCLayColQtyMax'],
                    'FCLayDim'         => $aItem[$i]['FCLayDim'],
                    'FCLayHigh'        => $aItem[$i]['FCLayHigh'],
                    'FCLayWide'        => $aItem[$i]['FCLayWide'],
                    'FTLayStaUse'      => $aItem[$i]['FTLayStaUse'],
                    'FTWahCode'        => $aItem[$i]['FTWahCode'],
                    'FTWahName'        => $aItem[$i]['FTWahName'],
                    'FTCabName'        => $aItem[$i]['FTCabName'],
                    'FNCabSeq'         => $aItem[$i]['FNCabSeq']
            ); 
            array_push($aWriteData[$nKeyIndexImport]['tItem'], $aParam);

            $tSHP       = $aItem[$i]['FTShpCode'];
            $nType      = $aItem[$i]['FTShtCode'];
            $nCabSeq    = $aItem[$i]['FNCabSeq'];
        }
        $aResultWrite   = json_encode($aWriteData, JSON_PRETTY_PRINT);
        $tFileName      = "ExportDiagram".$this->session->userdata('tSesUsername').date('His');
        $tPATH          = APPPATH . "modules/vending/views/vendinglayout/Export//".$tFileName.".json";
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

    //Import
    public function FSxVEDImportDiagram(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $aPackData      = $this->input->post('aPackData');

        $tFindWAH       = $this->mVendinglayout->FSaMVEDFindWAHAndMER('WAH',$tBchCode,$tShopCode);
        $tFindMER       = $this->mVendinglayout->FSaMVEDFindWAHAndMER('MER',$tBchCode,$tShopCode);

        //เอา Cabinet ไป insert ก่อน
        for($j=0; $j<FCNnHSizeOf($aPackData); $j++){
            switch ($aPackData[$j]['tTable']) {
                case "TVDMPdtLayout":
                    $nCabinet = 0;
                    for($w=0; $w<FCNnHSizeOf($aPackData[$j]['tItem']); $w++){
                        if($nCabinet == $aPackData[$j]['tItem'][$w]['FNCabSeq']){
                            $nCabinetCode = $aPackData[$j]['tItem'][$w]['FNCabSeq'];
                            $this->mVendinglayout->FSaMVEDImportDeleteDiagramByCab($tBchCode,$tShopCode,$nCabinetCode);
                            $nCabinet++;
                        }
                    }

                    //Insert PDTLayout
                    for($k=0; $k<FCNnHSizeOf($aPackData[$j]['tItem']); $k++){
                        $this->mVendinglayout->FSaMVEDImportDetailDiagram($aPackData[$j],$tBchCode,$tShopCode,$aPackData[$j]['tItem'][$k],$k,$tFindWAH,$tFindMER);
                    }
                break;
                default:
                    $this->mVendinglayout->FSaMVEDImportDetailDiagram($aPackData[$j],$tBchCode,$tShopCode,'','','','');
            }
        }   

        $aReturn = array(
            'nROW'          => $aPackData[0]['FNCabMaxRow'],
            'nCOL'          => $aPackData[0]['FNCabMaxCol'],
            'nShopType'     => $aPackData[0]['FNCabType'],
            'tNameCabinet'  => $aPackData[1]['FTCabName'],
            'tCabinet'      => $aPackData[0]['FNCabSeq']
        );
        echo json_encode($aReturn);
    }

    //Check PDT 
    public function FSxVEDImportCheckPDT(){
        $tBchCode       = $this->input->post('tBchCode');
        $tShopCode      = $this->input->post('tShopCode');
        $aItemPDT       = $this->input->post('aItemPDT');
        $tFindMER       = $this->mVendinglayout->FSaMVEDFindWAHAndMER('MER',$tBchCode,$tShopCode);


        $aResultToView  = [];
        for($i=0; $i<FCNnHSizeOf($aItemPDT); $i++){
            $paPackData = array(
                'tShpCode'          => $tShopCode,
                'tBchCode'          => $tBchCode,
                'nPDTCode'          => $aItemPDT[$i]['PDT']
            );
            $aResult = $this->mVendinglayout->FSaMVEDImportCheckPDT($paPackData,$tFindMER);

            $aPackResult = array(
                'nROW'      => $aItemPDT[$i]['ROW'],
                'nCOL'      => $aItemPDT[$i]['COL'],
                'nPDT'      => $aItemPDT[$i]['PDT'],
                'nCABSEQ'   => $aItemPDT[$i]['CABSEQ'],
                'nSTATUS'   => $aResult['rtCode'],
                'tDETAIL'   => $aResult['rtDesc']
            );
            array_push($aResultToView,$aPackResult);
        }

        echo json_encode($aResultToView);
    }

    //Check เอกสารที่เกี่ยวข้อง ว่าอนุมัติหรือยัง
    public function FSxVEDCheckDocumentWhenNotApv(){
        $tBchCode       = $this->input->post('tBchCode');
        $aResult        = $this->mVendinglayout->FSaMVEDFindDocumentWhenNotApv($tBchCode);
        echo json_encode($aResult);
    }

}
