<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


include APPPATH .'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

class deliveryorder_controller extends MX_Controller {

    public $tRouteMenu  = 'monDO/0/0';

    // $aAlwEvent = FCNaHCheckAlwFunc($this->tRouteMenu);
    // public $aAlwEvent = array(
    //     'tAutStaFull' => 1,
    //     'tAutStaRead' => 1,
    //     'tAutStaAdd' => 1,
    //     'tAutStaEdit' => 1,
    //     'tAutStaDelete' => 1,
    //     'tAutStaCancel' => 1,
    //     'tAutStaAppv' => 1,
    //     'tAutStaPrint' => 1,
    //     'tAutStaPrintMore' => 1,
    //     'tAutStaFavorite' => 1
    // );

    public function __construct(){
        parent::__construct ();
        $this->FSxCDOInitParams();
        $this->load->model('monitor/deliveryorder/deliveryorder_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    private function FSxCDOInitParams(){
        $this->aAlwEvent = FCNaHCheckAlwFunc($this->tRouteMenu);
    }

    public function index($nDOBrowseType, $tDOBrowseOption){
        $aDataConfigView    = array(
            'nDOBrowseType'     => $nDOBrowseType,
            'tDOBrowseOption'   => $tDOBrowseOption,
            'aAlwEvent'         => $this->aAlwEvent,
            'vBtnSave'          => FCNaHBtnSaveActiveHTML($this->tRouteMenu)
        );
        $this->load->view('monitor/deliveryorder/wDeliveryOrder', $aDataConfigView); 
    }

    public function FSvCDODataTable(){
        $aAdvanceSearch = $this->input->post('oAdvanceSearch');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $nDecimal       = FCNxHGetOptionDecimalShow();
        $nPage          = $aAdvanceSearch['nPageCurrent'];
        
        // Data Conditon Get Data Document
        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FNLngID'           => $nLangEdit,
            'aAdvanceSearch'    => $aAdvanceSearch
        );
        $aDataList      = $this->deliveryorder_model->FSoMMONGetData($aData);
        $aGenTable      = array(
            'aDODataList'       => $aDataList,
            'nPage'             => $nPage,
            'nDecimal'          => $nDecimal,
            'FNLngID'           => $nLangEdit
        );
        $this->load->view('monitor/deliveryorder/wDeliveryOrderDataList',$aGenTable);
    }

    public function FSvCDOApvDocMulti(){
        if( !empty($this->input->post('tDocNoMulti')) ){
            $tDocNoMulti    = $this->input->post('tDocNoMulti');
            $tBchCodeMulti  = $this->input->post('tBchCodeMulti');
            $tSesUserCode   = $this->session->userdata("tSesUserCode");
            if( !empty($this->input->post('dDateTranfer')) ){
                $dDateTranfer   = date_format(date_create($this->input->post('dDateTranfer')),"Y-m-d");
            }else{
                $dDateTranfer   = date('Y-m-d');
            }

            $this->db->trans_begin();
            $aPackData      = array(
                'dDateTranfer'  => $dDateTranfer,
                'tDocNoWhere'   => "'".str_replace(",","','",trim($tDocNoMulti))."'",
                'tBchCodeWhere' => "'".str_replace(",","','",trim($tBchCodeMulti))."'"
            );
            
            $this->deliveryorder_model->FSxMDOUpdTnfDate($aPackData); // อัพเดทวันที่ส่งของ
            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $this->db->error()['message']
                );
            }else{
                $this->db->trans_commit();

                $aDocNoMulti    = explode(",",$tDocNoMulti);
                $aBchCodeMulti  = explode(",",$tBchCodeMulti);
                $aDebugSendMQ   = array();
                for($i=0;$i<FCNnHSizeOf($aDocNoMulti);$i++){
                    // echo "FTXshDocNo: ".$aDocNoMulti[$i]." , FTBchCode: ".$aBchCodeMulti[$i]."<br>";
                    $aMQParams = [
                        "queueName" => "CN_QDocApprove",
                        "params" => [
                            "ptFunction"    => "APPOVEDDO",        //ชื่อ Function
                            "ptSource"      => "AdaStoreBack",     //ต้นทาง
                            "ptDest"        => "MQReceivePrc",     //ปลายทาง
                            "ptFilter"      => trim($aBchCodeMulti[$i]),
                            "ptData"        =>  json_encode([
                                "ptBchCode"     => trim($aBchCodeMulti[$i]),
                                "ptDocNo"       => trim($aDocNoMulti[$i]),
                                "ptDocType"     => '4',
                                "ptUser"        => $tSesUserCode,
                                "ptConnStr"     => DB_CONNECT
                            ])
                        ]
                    ];
                    array_push($aDebugSendMQ,$aMQParams);
                    FCNxCallRabbitMQ($aMQParams);
                }

                $aReturnData = array(
                    'aDebugSendMQ'      => $aDebugSendMQ,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }
        }else{
            $aReturnData = array(
                'nStaEvent'         => '400',
                'tStaMessg'         => 'ไม่พบเลขที่เอกสาร'
            );
        }
        echo json_encode($aReturnData);
    }


    // หน้าจอ แก้ไข ใบสั่งของ
    public function FSvCDOEditPage(){
        try {
            $ptDocumentNumber   = $this->input->post('ptDocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp    = [
                'FTXthDockey'   => 'TARTDoHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->deliveryorder_model->FSnMDODelALLTmp($aWhereClearTemp);

            // Array Data Where Get
            $aDataWhere = array(
                'FTXthDocNo'    => $ptDocumentNumber,
                'FTXthDocKey'   => 'TARTDoHD',
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'nRow'          => 90000,
                'nPage'         => 1,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );

            // Get Autentication Route
            // $aAlwEvent         = FCNaHCheckAlwFunc($this->tRouteMenu); // Controle Event
            $vBtnSave          = FCNaHBtnSaveActiveHTML($this->tRouteMenu);
            $nOptDecimalShow   = FCNxHGetOptionDecimalShow();

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->deliveryorder_model->FSaMDOGetDataDocHD($aDataWhere);
            
            // Move Data DT TO DTTemp
            $this->deliveryorder_model->FSxMDOMoveDTToDTTemp($aDataWhere);

            // Move Data HDDocRef TO HDRefTemp
            $this->deliveryorder_model->FSxMDOMoveHDRefToHDRefTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
                
            } else {
                $this->db->trans_commit();

                // $aWhere = array(
                //     'FTUfrGrpRef'   => '068',
                //     'FTUfrRef'      => 'KB038' //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                // );
                // $bAlwQtyPickNotEqQtyOrd = FCNbGetUsrFuncRpt($aWhere);

                $aDataConfigViewEdit = array(
                    'aAlwEvent'                 => $this->aAlwEvent,
                    'vBtnSave'                  => $vBtnSave,
                    'nOptDecimalShow'           => $nOptDecimalShow,
                    'aDataDocHD'                => $aDataDocHD,
                    // 'bAlwQtyPickNotEqQtyOrd'    => $bAlwQtyPickNotEqQtyOrd
                );
                $tViewPageEdit = $this->load->view('monitor/deliveryorder/wDeliveryOrderPageAdd',$aDataConfigViewEdit,true);
                $aReturnData = array(
                    'tViewPageEdit'      => $tViewPageEdit,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // แสดง Form Search ข้อมูลในตารางหน้า List
    public function FSvCDOFormSearchList() {
        $aDataConfigView = array(
            'aAlwEvent'          => $this->aAlwEvent,
        );
        $this->load->view('monitor/deliveryorder/wDeliveryOrderFormSearchList', $aDataConfigView);
    }

    // แสดงผลลัพธ์การค้นหาขั้นสูง
    public function FSoCDOPdtAdvTblLoadData() {
        try {
            $bStaSession    =   $this->session->userdata('bSesLogIn');
            if(isset($bStaSession) && $bStaSession === TRUE){
                //ยังมี Session อยู่
            }else{
                $aReturnData = array(
                    'checksession' => 'expire'
                );
                echo json_encode($aReturnData);
            }

            $tDODocNo           = $this->input->post('ptDODocNo');
            $tDOStaApv          = $this->input->post('ptDOStaApv');
            $tDOStaDoc          = $this->input->post('ptDOStaDoc');
            // $tDOVATInOrEx       = $this->input->post('ptDOVATInOrEx');
            $nDOPageCurrent     = $this->input->post('pnDOPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            $tDOPdtCode         = $this->input->post('ptDOPdtCode');
            $tDOPunCode         = $this->input->post('ptDOPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            // $tTableGetColumeShow    = 'TCNTPdtPickDT';
            // $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tDODocNo,
                'FTXthDocKey'           => 'TARTDoHD',
                'nPage'                 => $nDOPageCurrent,
                'nRow'                  => 90000,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
                'FNXthDocType'          => $this->input->post('ptDODocType')
            );
            // FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->deliveryorder_model->FSaMDOGetDocDTTempListPage($aDataWhere);

            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tDOStaApv'         => $tDOStaApv,
                'tDOStaDoc'         => $tDOStaDoc,
                'tDOPdtCode'        => $tDOPdtCode,
                'tDOPunCode'        => $tDOPunCode,
                'nPage'             => $nDOPageCurrent,
                'aColumnShow'       => array(),
                'aDataDocDTTemp'    => $aDataDocDTTemp
            );
            $tDOPdtAdvTableHtml = $this->load->view('monitor/deliveryorder/wDeliveryOrderPdtAdvTableData', $aDataView, true);

            $aReturnData = array(
                'tDOPdtAdvTableHtml' => $tDOPdtAdvTableHtml,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSoCDOPageHDDocRefList(){
        try{
            $tDocNo = ( !empty($this->input->post('ptDocNo')) ? $this->input->post('ptDocNo') : '');

            $aDataWhere = [
                'tTableHDDocRef'    => 'TARTDoHDDocRef',
                'tTableTmpHDRef'    => 'TCNTDocHDRefTmp',
                'FTXthDocNo'        => $tDocNo,
                'FTXthDocKey'       => 'TARTDoHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];

            $aDataDocHDRef = $this->deliveryorder_model->FSaMDOGetDataHDRefTmp($aDataWhere);
            $aDataConfig = array(
                'aDataDocHDRef' => $aDataDocHDRef,
                'tStaApv'       => $this->input->post('ptStaApv')
            );
            $tViewPageHDRef = $this->load->view('monitor/deliveryorder/refintdocument/wDeliveryOrderRefDocList', $aDataConfig, true);
            $aReturnData = array(
                'tViewPageHDRef'    => $tViewPageHDRef,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    
    // Function: Check Product Have In Temp For Document DT
    public function FSoCDOChkHavePdtForDocDTTemp() {
        try {
            $tDODocNo       = $this->input->post("ptDODocNo");
            $tDOSessionID   = $this->input->post('tDOSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo'    => $tDODocNo,
                'FTXthDocKey'   => 'TARTDoHD',
                'FTSessionID'   => $tDOSessionID
            );
            $nCountPdtInDocDTTemp = $this->deliveryorder_model->FSnMDOChkPdtInDocDTTemp($aDataWhere);
            
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn'    => '800',
                    'tStaMessg'     => 'ไม่พบสินค้า'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Add Document 
    public function FSoCDOEditEventDoc() {
        try {
            $aDataDocument     = $this->input->post();
            $tDOAutoGenCode    = (isset($aDataDocument['ocbDOStaAutoGenCode'])) ? 1 : 0;
            $tDODocNo          = (isset($aDataDocument['oetDODocNo'])) ? $aDataDocument['oetDODocNo'] : '';
            $tDODocDate        = $aDataDocument['oetDODocDate'] . " " . $aDataDocument['oetDODocTime'];
            $tDOStaDocAct      = (isset($aDataDocument['ocbDOFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tDOSessionID      = $this->input->post('ohdSesSessionID');
            $tDOStaApv         = $aDataDocument['ohdDOStaApv'];

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'          => 'TARTDoHD',
                'tTableHDCst'       => 'TARTDoHDCst',
                'tTableDT'          => 'TARTDoDT'
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode'     => $aDataDocument['ohdDOBchCode'],
                'FTXthDocNo'    => $tDODocNo,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->input->post('ohdDOUsrCode'),
                'FTLastUpdBy'   => $this->input->post('ohdDOUsrCode'),
                'FTSessionID'   => $this->input->post('ohdSesSessionID')
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTXshRmk'       => $aDataDocument['otaDOFrmInfoOthRmk'],
                'FNXshStaDocAct' => $tDOStaDocAct
            );

            $this->db->trans_begin();

            // Add Update Document HD
            $this->deliveryorder_model->FSxMDOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            if( $tDOStaApv != "1" ){

                // Array Data HD Master
                $aDataHDCst = array(
                    'FNXshAddrShip'         => $aDataDocument['ohdDOShipAdd'],
                    'FDXshTnfDate'          => $aDataDocument['oetDODateSent'],
                );

                // Add Update Document HDCst
                $this->deliveryorder_model->FSxMDOAddUpdateHDCst($aDataHDCst, $aDataWhere, $aTableAddUpdate);

                // [Update] DocNo -> Temp
                $this->deliveryorder_model->FSxMDOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

                // Move Doc DTTemp To DT
                $this->deliveryorder_model->FSxMDOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);
            }

            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Edit Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTXthDocNo'],
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Success Edit Document.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //อนุมัติเอกสาร
    public function FSoCDOApproveEvent(){
        try{
            $aDataUpdate = array(
                'FTBchCode'         => $this->input->post('tBchCode'),
                'FTXshDocNo'        => $this->input->post('tDocNo'),
                'FTXshStaApv'       => '2',
                'FTXshApvCode'      => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            );
            
            $this->db->trans_begin();
            $this->deliveryorder_model->FSxMDOApproveDocument($aDataUpdate);
            
            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aReturnData     = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => $this->db->error()['message'],
                );
            }else{
                $this->db->trans_commit();

                // "{
                //     ""ptFunction"":""APPOVEDDO"",   //ฟังก์ชั่น
                //     ""ptSource"":""AdaStoreBack"",  //ต้นทาง
                //     ""ptDest"":""MQReceivePrc"",    //ปลายทาง
                //     ""ptFilter"":"""",
                //     ""ptData"":""{
                //                 ""ptBchCode"": ""00000"",   //รหัสสาขา
                //                 ""ptDocNo"": ""DO0000000000120001"",  //รหัสเอกสารใบ Do
                //                 ""ptDocType"": ""1"", //ประเภทเอกสาร
                //                 ""ptUser"": ""009"",  //รหัสพนักงาน
                //                 ""ptConnStr"": """"   //connection string
                //               }"",
                //     ""ptConnStr"":"""" //connection string
                //   }"

                $aMQParams = [
                    "queueName" => "CN_QDocApprove",
                    "params" => [
                        "ptFunction"    => "APPOVEDDO",        //ชื่อ Function
                        "ptSource"      => "AdaStoreBack",     //ต้นทาง
                        "ptDest"        => "MQReceivePrc",     //ปลายทาง
                        "ptFilter"      => $aDataUpdate['FTBchCode'],
                        "ptData"        =>  json_encode([
                            "ptBchCode"     => $aDataUpdate['FTBchCode'],
                            "ptDocNo"       => $aDataUpdate['FTXshDocNo'],
                            "ptDocType"     => '4',
                            "ptUser"        => $aDataUpdate['FTXshApvCode'],
                            "ptConnStr"     => DB_CONNECT
                        ])
                    ]
                ];
                FCNxCallRabbitMQ($aMQParams);

                $aReturnData     = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'Approve Success.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Cancel Status Document
    public function FSoCDOCancelDocument() {
        try {
            $this->db->trans_begin();

            $aDataUpdate = array(
                'tDocNo'        => $this->input->post('ptDODocNo'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );
            
            // ตรวจสอบว่ามีอ้างอิงใบขายไหม ?
            // ถ้าใบส่งของ สร้างมาจากใบขาย ปรับสถานะเอกสารใบขาย เป็น StaPrcDoc=7 (รอสร้างใบส่งของ)
            $this->deliveryorder_model->FSxMDOUpdSaleOnCancelOrDelete($aDataUpdate);
            
            // ปรับสถานะใบส่งของ = ยกเลิก , ลบ HDDocRef 
            $this->deliveryorder_model->FSxMDOCancelDocument($aDataUpdate);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Cannot Update Status Cancel Document."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Update Status Document Cancel Success."
                );
            }
            
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


}
?>
