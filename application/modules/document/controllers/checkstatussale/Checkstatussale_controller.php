<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Checkstatussale_controller extends MX_Controller {

    public $aPermission = [];

    public function __construct(){
        parent::__construct();
        $this->load->model('document/checkstatussale/Checkstatussale_model');
    }

    // Create By: Napat(Jame) 02/07/2021
    public function index($nBrowseType, $tBrowseOption){
        $aDataConfigView = array(
            'nBrowseType'       => $nBrowseType,
            'tBrowseOption'     => $tBrowseOption,
            'aPermission'       => FCNaHCheckAlwFunc('docCSS/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docCSS/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/checkstatussale/wCheckStatusSale', $aDataConfigView);
    }

    // เรียกหน้า List
    // Create By: Napat(Jame) 02/07/2021
    public function FSvCCSSPageList(){
        $aAlwChnShw = $this->Checkstatussale_model->FSaMCSSAlwChnShw();
        $this->load->view('document/checkstatussale/wCheckStatusSaleList',array(
            'aGetChnDelivery' => $aAlwChnShw
        ));
    }
    
    // เรียกหน้า DataTable
    // Create By: Napat(Jame) 02/07/2021
    public function FSvCCSSPageDataTable(){
        $nPage              = $this->input->post('pnPageCurrent');
        $aSearchList        = $this->input->post('paSearchList');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $nLangEdit          = $this->session->userdata("tLangEdit");

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        }

        $aDataSearch = array(
            'aSearchList'   => $aSearchList,
            'FNLngID'       => $nLangEdit,
            'nPage'         => $nPage,
            'nRow'          => 10
        );

        $aResList = $this->Checkstatussale_model->FSaMCSSDataList($aDataSearch);
        $aGenTable = array(
            'aAlwEvent'         => FCNaHCheckAlwFunc('docCSS/0/0'),
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );
        $this->load->view('document/checkstatussale/wCheckStatusSaleDataTable', $aGenTable);
        // $aReturnData = array(
        //     'tViewDataTable'    => $this->load->view('document/transferreceiptOut/wTransferreceiptOutDataTable', $aGenTable, true),
        //     'nStaEvent'         => '1',
        //     'tStaMessg'         => 'Success'
        // );
        // echo json_encode($aReturnData);
    }

    // เรียกหน้า Edit/View
    // Create By: Napat(Jame) 05/07/2021
    public function FSvCCSSPageEdit(){
        try {
            $tDocNo = $this->input->post('ptDocNo');

            // Clear Data In Doc DT Temp
            $aWhereTemp = [
                'tDocKey'       => 'TPSTSalHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->Checkstatussale_model->FSaMCSSEventClearPdtSNTmp($aWhereTemp);

            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Array Data Where Get
            $aDataWhere = array(
                'tDocNo'        => $tDocNo,
                'nLngID'       => $nLangEdit
            );

            // Get Data Document HD
            $aDataDocHD = $this->Checkstatussale_model->FSaMCSSEventGetDataDocHD($aDataWhere);
            if( $aDataDocHD['tCode'] == '1' ){
                // $aDataDocRC     = $this->Checkstatussale_model->FSaMCSSEventGetDataDocRC($aDataWhere); // Get Data RC
                $aDataDocDT     = $this->Checkstatussale_model->FSaMCSSEventGetDocDT($aDataWhere);
                $aDataDocDTDis  = $this->Checkstatussale_model->FSaMCSSEventGetDocDTDis($aDataWhere);

                $aDataDTDisTmp = [];
                if( $aDataDocDTDis['tCode'] == '1' ){
                    foreach ($aDataDocDTDis['aItems'] as $value) {
                        $nXsdSeqNo = $value['FNXsdSeqNo'];
                        $cXddValue = number_format($value['FCXddValue'],$nOptDecimalShow);
                        if( empty($aDataDTDisTmp[$nXsdSeqNo]) ){
                            $aDataDTDisTmp[$nXsdSeqNo] = $cXddValue;
                        }else{
                            $aDataDTDisTmp[$nXsdSeqNo] = $aDataDTDisTmp[$nXsdSeqNo].",".$cXddValue;
                        }
                    }
                }

                if( $aDataDocDT['tCode'] == '1' ){
                    $aDataDTTmp = [];
                    foreach($aDataDocDT['aItems'] as $aValue){

                        if( $aDataDocDTDis['tCode'] == '1' ){
                            $XtdSeqNo = $aValue['FNXtdSeqNo'];
                            if( array_key_exists($XtdSeqNo,$aDataDTDisTmp) ){
                                $aValue['FTXtdDisChgTxt'] = $aDataDTDisTmp[$XtdSeqNo];
                            }
                        }
                        
                        if( $aValue['FCXtdQty'] > 1 ){
                            for( $i = 0; $i < intval($aValue['FCXtdQty']); $i++){
                                $tSeqQty = $i + 1;                            
                                $aValue['FTXtdPdtParent'] = strval($tSeqQty);
                                array_push($aDataDTTmp,$aValue);
                            }
                        }else{
                            array_push($aDataDTTmp,$aValue);
                        }
                    }
                }else{
                    $aDataDTTmp = $aDataDocDT['aItems'];
                }

                $this->Checkstatussale_model->FSaMCSSEventInsertToTmp($aDataDTTmp);
                $this->Checkstatussale_model->FSaMCSSEventUpdPdtSNTmp($aDataWhere,$aWhereTemp);

                // print_r($aDataDocHD['aItems']['FTChnCode']);exit;
                // $tChnCode = $aDataDocHD['aItems']['FNMapSeqNo'];
                // $aChannel = FCNaGetChnDelivery($tChnCode);
                // if( $aChannel['tCode'] == '1' ){
                //     $tChnMapSeqNo = $aChannel['aItems'][0]['FNMapSeqNo'];
                //     // 0	Online (DC จัดส่ง)
                //     // 1	Online(รับที่ Store)
                //     // 3	Offline(Store จัดส่ง)
                // }else{
                //     $tChnMapSeqNo = 0;
                // }

                // $aDataWhere['tDocType']  =  $aDataDocHD['aItems']['FNXshDocType'];
                // $aDataWhere['tRefInt']   =  $aDataDocHD['aItems']['FTXshRefInt'];
                // $aDataWhere['tCstCode']  =  $aDataDocHD['aItems']['FTCstCode'];
                // $aDataWhere['tDocDate']  =  $aDataDocHD['aItems']['FDTxnDocDate'];

                $aPackData = array(
                    // 'aDataPoints'       => $this->Checkstatussale_model->FSaMCSSEventGetDataPoints($aDataWhere), // Get Data Points
                    'aDataDocHD'        => $aDataDocHD['aItems'],
                    // 'aDataDocRC'        => $aDataDocRC,
                    'nOptDecimalShow'   => $nOptDecimalShow,
                    'tChnMapSeqNo'      => $aDataDocHD['aItems']['FNMapSeqNo'], //$tChnMapSeqNo
                );
                
                $aReturnData = array(
                    'tViewPageAdd'   => $this->load->view('document/checkstatussale/wCheckStatusSalePageAdd', $aPackData, true),
                    'nXshDocType'    => $aDataDocHD['aItems']['FNXshDocType'],

                    // ABB
                    'tXshStaPrcDoc'  => $aDataDocHD['aItems']['FTXshStaPrcDoc'],
                    'tXshRefTax'     => $aDataDocHD['aItems']['FTXshRefTax'],
                    'tXshStaETax'    => $aDataDocHD['aItems']['FTXshStaETax'], 
                    'tXshETaxStatus' => $aDataDocHD['aItems']['FTXshETaxStatus'],

                    // Full Tax
                    'tXshDocVatFull'        => $aDataDocHD['aItems']['FTXshDocVatFull'],
                    'tXshRefTaxFullTax'     => $aDataDocHD['aItems']['FTXshRefTaxFullTax'],
                    'tXshStaETaxFullTax'    => $aDataDocHD['aItems']['FTXshStaETaxFullTax'], 
                    'tXshETaxStatusFullTax' => $aDataDocHD['aItems']['FTXshETaxStatusFullTax'],

                    'nStaEvent'      => '1',
                    'tStaMessg'      => 'Success'
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => $aDataDocHD['tDesc']
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

    // เรียกหน้าแสดงรายการสินค้า
    // Create By: Napat(Jame) 05/07/2021
    public function FSvCCSSPageProductDataTable(){
        try {
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            $tChnCode           = $this->input->post('ptChnCode');
            $aDataWhere = array(
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tSearch'       => $this->input->post('ptSearch'),
                'nLngID'        => $this->session->userdata("tLangEdit"),
            );
            
            $aDataDocDT         = $this->Checkstatussale_model->FSaMCSSEventGetDataDocDTTmp($aDataWhere); // Get Data Document DT Tmp
            $aDataDisPro        = $this->Checkstatussale_model->FSaMCSSEventGetDataDisPromotions($aDataWhere); // Get Data Discount Promotions
            $aDataEndBill       = $this->Checkstatussale_model->FSaMCSSEventGetDataEndBill($aDataWhere); // Get Data End Bill
            $aDataEndBillVat    = $this->Checkstatussale_model->FSaMCSSEventGetDataEndBillVat($aDataWhere); // Get Data End Bill Vat
            $nCountSerial       = $this->Checkstatussale_model->FSnMCSSEventCountSerial($aDataWhere);
            $aControlButton     = $this->Checkstatussale_model->FSaMCSSEventControlButton($aDataWhere);

            // Call Footer Document
            $aEndOfBill = array(
                'aDataDocRC'    => $this->Checkstatussale_model->FSaMCSSEventGetDataDocRC($aDataWhere), // Get Data RC
                'aDataPoints'   => $this->Checkstatussale_model->FSaMCSSEventGetDataPoints($aDataWhere), // Get Data Points
                'aDataDisPro'   => $aDataDisPro,
                'aEndOfBillCal' => array(
                    'cCalFCXphGrand'        => number_format($aDataEndBill['aItems']['FCXshGrand'],$nOptDecimalShow),
                    'cSumFCXtdAmt'          => number_format($aDataEndBill['aItems']['FCXshDis'],$nOptDecimalShow),
                    'cSumFCXtdNet'          => number_format($aDataEndBill['aItems']['FCXshTotal'],$nOptDecimalShow),
                    'cSumFCXtdNetAfHD'      => number_format($aDataEndBill['aItems']['FCXshNetAfHD'],$nOptDecimalShow),
                    'cSumFCXtdVat'          => number_format($aDataEndBill['aItems']['FCXshVat'],$nOptDecimalShow),
                    'tDisChgTxt'            => $aDataEndBill['aItems']['FTXshDisChgTxt'],
                    'cXshRnd'               => number_format($aDataEndBill['aItems']['FCXshRnd'],$nOptDecimalShow),
                ),
                'aEndOfBillVat' => array(
                    'aItems'  => $aDataEndBillVat['aItems'],
                    'cVatSum' => number_format($aDataEndBill['aItems']['FCXshVat'],$nOptDecimalShow)
                ),
                'tTextBath' => $aDataEndBill['aItems']['FTXshGndText']
            );

            $aPackData = array(
                'aDataDocDTTemp'    => $aDataDocDT,
                'nOptDecimalShow'   => $nOptDecimalShow
            );
            $aReturnData = array(
                'tViewPdtDataTable' => $this->load->view('document/checkstatussale/wCheckStatusSalePdtDataTable', $aPackData, true),
                'aControlButton'    => $aControlButton,
                'nCountSerial'      => $nCountSerial,
                'aEndOfBill'        => $aEndOfBill,
                'nStaEvent'         => 1,
                'tStaMessg'         => "Render View Pdt DataTable"
            );

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // ดึงข้อมูลสินค้าที่ต้องระบุหมายเลขซีเรียล
    // Create By: Napat(Jame) 07/07/2021
    public function FSaCCSSEventGetDataPdtSN(){
        try {
            $aDataWhere = array(
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tScanBarCode'  => $this->input->post('ptScanBarCode'),
                'nLngID'        => $this->session->userdata("tLangEdit")
            );
            $aDataPdtSN = $this->Checkstatussale_model->FSaMCSSEventGetDataPdtSN($aDataWhere);
            $aReturnData = array(
                'aDataPdtSN' => $aDataPdtSN,
                'nStaEvent'  => $aDataPdtSN['tCode'],
                'tStaMessg'  => $aDataPdtSN['tDesc']
            );

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // อัพเดทหมายเลขซีเรียล
    // Create By: Napat(Jame) 07/07/2021
    public function FSaCCSSEventUpdatePdtSNTmp(){
        $aWhereTemp = [
            'tDocNo'        => $this->input->post('ptDocNo'),
            'nSeqNo'        => $this->input->post('pnSeqNo'),
            'tPdtCode'      => $this->input->post('ptPdtCode'),
            'tSerialNo'     => $this->input->post('ptSerialNo'),
            'tStaAction'    => $this->input->post('ptStaAction'),
            'tOldPdtSN'     => $this->input->post('ptOldPdtSN'),

            'tDocKey'       => 'TPSTSalHD',
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        ];
        $aChkDupPdtSN = $this->Checkstatussale_model->FSaMCSSEventChkDupPdtSN($aWhereTemp);
        if( $aChkDupPdtSN['tCode'] == '1' ){
            echo json_encode($this->Checkstatussale_model->FSaMCSSEventUpdatePdtSNTmp($aWhereTemp));
        }else{
            echo json_encode($aChkDupPdtSN);
        }
    }

    // ย้ายจาก Temp ไปตารางจริง
    // Create By: Napat(Jame) 07/07/2021
    public function FSaCCSSEventMoveTmpToDT(){
        try {
            $aWhere = [
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tDocVatFull'   => $this->input->post('ptDocVatFull'),
                'tDocKey'       => 'TPSTSalHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];

            // ตรวจสอบสถานะบิลขายก่อนว่าเป็น ลูกค้าแจ้งยกเลิก หรือไม่ ?
            $tStaPrcDoc = $this->Checkstatussale_model->FStMCSSEventChkStaPrcDoc($aWhere);
            if( $tStaPrcDoc != "6" ){
                $this->db->trans_begin();
                $aMoveTmpToDT = $this->Checkstatussale_model->FSaMCSSEventMoveTmpToDT($aWhere);
                $this->Checkstatussale_model->FSaMCSSEventClearPdtSNTmp($aWhere);
                if ( $this->db->trans_status() === FALSE ) {
                    $this->db->trans_rollback();
                    $aReturnData  = array(
                        'nStaEvent'    => '905',
                        'tStaMessg'    => 'Query Error',
                    );
                } else {
                    if( $aMoveTmpToDT['tCode'] == '1' ){
                        $this->db->trans_commit();
                        $aReturnData  = array(
                            'nStaEvent'    => '1',
                            'tStaMessg'    => 'Success',
                        );
                    }else{
                        $this->db->trans_rollback();
                        $aReturnData  = array(
                            'nStaEvent'    => $aMoveTmpToDT['tCode'],
                            'tStaMessg'    => $aMoveTmpToDT['tDesc']
                        );
                    }
                    
                }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '600',
                    'tStaMessg' => 'เอกสารบิลขายนี้ ลูกค้าแจ้งยกเลิก ไม่สามารถบันทึกข้อมูลได้'
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

    // อนุมัติเอกสารใบขาย
    // Create By: Napat(Jame) 12/07/2021
    public function FSaCCSSEventApproved(){
        try {
            $aWhere = [
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tStaPrcDoc'    => $this->input->post('ptStaPrcDoc'),
                'tChnMapSeqNo'  => $this->input->post('ptChnMapSeqNo'),
                'tSesUserCode'  => $this->session->userdata("tSesUserCode"),
                'dLastUpdOn'    => date('Y-m-d h:i:s'),
                'nLngID'        => $this->session->userdata("tLangEdit")
            ];
            // ตรวจสอบสถานะบิลขายก่อนว่าเป็น ลูกค้าแจ้งยกเลิก หรือไม่ ?
            // $tStaPrcDoc = $aWhere['tStaPrcDoc'];
            // $tStaPrcDoc = $this->Checkstatussale_model->FStMCSSEventChkStaPrcDoc($aWhere);
            if( $aWhere['tStaPrcDoc'] != "6" ){
                $this->db->trans_begin();
                $aGetDocHD = $this->Checkstatussale_model->FSaMCSSEventGetDataDocHD($aWhere);
                if( $aGetDocHD['aItems']['FTXshStaETax'] == '1' ){                                  // ตรวจสอบว่าบิลนี้เป็น e-Tax หรือไม่ ?

                    // Approve Event
                    $this->Checkstatussale_model->FSaMCSSEventApproved($aWhere,'ETax');

                    $aChkFullTax = $this->Checkstatussale_model->FSaMCSSEventChkFullTax($aWhere);   // ค้นหา FullTax ที่ส่งให้ iNet ไม่สมบูรณ์
                    if( $aChkFullTax['tCode'] == '1' ){
                        $tDocVatFull = $aChkFullTax['tDocVatFull'];
                    }else{
                        $tDocVatFull = "";
                    }

                    if( $aGetDocHD['aItems']['FNXshDocType'] == '1' ){  // เอกสารขาย 1
                        $tABBDocType        = "1"; // ABB
                        $tFullTaxDocType    = "2"; // FullTax
                    }else{                                              // เอกสารคืน 9
                        $tABBDocType        = "3"; // CN
                        $tFullTaxDocType    = "4"; // CN-FullTax
                    }

                    // เคส Online(รับที่ Store) + Fast Delivery
                    if( $aWhere['tChnMapSeqNo'] == '1' || $aWhere['tChnMapSeqNo'] == '4' ){   

                        $this->Checkstatussale_model->FSxMCSSEventMoveDTSNFromPackToSale($aWhere);

                        $aMQParamsStaPacked = [
                            "queueName" => "EX_SAPStatusPacked",
                            "params" => [
                                "ptFunction"    => "SendStatusPacked",
                                "ptSource"      => "AdaStoreBack",
                                "ptDest"        => "MQAdaLink",
                                "ptData"        => json_encode([
                                    "ptAgnCode"     => "",                                      //รหัสตัวแทน
                                    "ptFilter"      => $aGetDocHD['aItems']['FTBchCode'],       //รหัสสาขา
                                    "ptWaHouse"     => $aGetDocHD['aItems']['FTWahCode'],       //รหัสคลัง
                                    "ptPosCode"     => $aGetDocHD['aItems']['FTPosCode'],       //รหัสจุดขาย
                                    "ptRound"       => '1',                                     //รอบการส่ง Default 1
                                    "ptDateFrm"     => $aGetDocHD['aItems']['FDXshDocDate'],    //ช่วงวันที่เริ่มต้น
                                    "ptDateTo"      => $aGetDocHD['aItems']['FDXshDocDate'],    //ช่วงวันที่สิ้นสุด
                                    "ptDocNoFrm"    => $aGetDocHD['aItems']['FTXshDocNo'],      //ช่วงเอกสารเริ่มต้น
                                    "ptDocNoTo"     => $aGetDocHD['aItems']['FTXshDocNo']       //ช่วงเอกสารสิ้นสุด
                                ])
                            ]
                        ];
                        FCNaRabbitMQInterface($aMQParamsStaPacked);
                    }

                    // Send MQ ABB
                    $aMQParams = [
                        "queueName" => "EX_TxnSaleETax",
                        "params" => [
                            "ptFunction"    => "SaleRef",
                            "ptSource"      => "AdaStoreBack",
                            "ptDest"        => "MQAdaLink",
                            "ptData"        => json_encode([
                                "ptProvider"    => "1",
                                "ptUserCode"    => $this->session->userdata("tSesUserCode"), // User Login
                                "ptBchCode"     => $aGetDocHD['aItems']['FTBchCode'],
                                "ptPosCode"     => $aGetDocHD['aItems']['FTPosCode'],
                                "ptDocType"     => $tABBDocType,
                                "ptDocNo"       => $aWhere['tDocNo'],
                                "ptRefDocType"  => "",
                                "ptDocRef"      => ""
                            ])
                        ]
                    ];
                    $aRabbitMQ = FCNaRabbitMQInterface($aMQParams);

                    if( !empty($tDocVatFull) ){
                        // Send MQ FULL TAX
                        $aMQParamsFullTax = [
                            "queueName" => "EX_TxnSaleETax",
                            "params" => [
                                "ptFunction"    => "SaleRef",
                                "ptSource"      => "AdaStoreBack",
                                "ptDest"        => "MQAdaLink",
                                "ptData"        => json_encode([
                                    "ptProvider"    => "1",
                                    "ptUserCode"    => $this->session->userdata("tSesUserCode"), // User Login
                                    "ptBchCode"     => $aGetDocHD['aItems']['FTBchCode'],
                                    "ptPosCode"     => $aGetDocHD['aItems']['FTPosCode'],
                                    "ptDocType"     => $tFullTaxDocType,
                                    "ptDocNo"       => $tDocVatFull,
                                    "ptRefDocType"  => "",
                                    "ptDocRef"      => ""
                                ])
                            ]
                        ];
                        FCNaRabbitMQInterface($aMQParamsFullTax);
                    }

                    if( $aRabbitMQ['nStaEvent'] != '1' ){
                        echo json_encode($aRabbitMQ);
                        return;
                    }
                }else{
                    $this->Checkstatussale_model->FSaMCSSEventApproved($aWhere,'');
                }

                if ( $this->db->trans_status() === FALSE ) {
                    $this->db->trans_rollback();
                    $aReturnData  = array(
                        'nStaEvent'    => '905',
                        'tStaMessg'    => 'Query Error',
                    );
                } else {
                    $this->db->trans_commit();
                    $aReturnData  = array(
                        'tStaETax'      => $aGetDocHD['aItems']['FTXshStaETax'],
                        'nStaEvent'     => '1',
                        'tStaMessg'     => 'Success',
                    );
                }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '600',
                    'tStaMessg' => 'เอกสารบิลขายนี้ ลูกค้าแจ้งยกเลิก ไม่สามารถบันทึกข้อมูลได้'
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

    // Call MQ
    // Create By: Napat(Jame) 12/07/2021
    // public function FCNaCallRabbitMQInterface($paParams){
    //     $aConfigMQ      = $this->Checkstatussale_model->FSaMCSSEventGetConfigMQ();
    //     if( $aConfigMQ['tCode'] == '1' ){
    //         $tHost          = $aConfigMQ['aItems'][1]['FTCfgStaUsrValue'];
    //         $tPort          = $aConfigMQ['aItems'][2]['FTCfgStaUsrValue'];
    //         $tPassword      = FCNtHAES128Decrypt($aConfigMQ['aItems'][3]['FTCfgStaUsrValue']);
    //         $tQueueName     = $paParams['queueName']/*$aConfigMQ['aItems'][4]['FTCfgStaUsrValue']*/;
    //         $tUser          = $aConfigMQ['aItems'][5]['FTCfgStaUsrValue'];
    //         $tVHost         = $aConfigMQ['aItems'][6]['FTCfgStaUsrValue'];
    //         $aParams        = $paParams['params'];

    //         // echo FCNtHAES128Decrypt($aConfigMQ['aItems'][3]['FTCfgStaUsrValue']);
    //         // exit;

    //         $oConnection = new AMQPStreamConnection($tHost, $tPort, $tUser, $tPassword, $tVHost);
    //         $oChannel = $oConnection->channel();
    //         $oChannel->queue_declare($tQueueName, false, true, false, false);
    //         $oMessage = new AMQPMessage(json_encode($aParams));
    //         $oChannel->basic_publish($oMessage, "", $tQueueName);

    //         $oChannel->close();
    //         $oConnection->close();

    //         $aReturnData  = array(
    //             'nStaEvent'     => '1',
    //             'tStaMessg'     => 'Success',
    //         );

    //     }else{
    //         $aReturnData  = array(
    //             'nStaEvent'     => '800',
    //             'tStaMessg'     => 'ไม่พบการตั้งค่า MQ กรุณาติดต่อผู้ดูแลระบบ',
    //         );
    //     }
    //     return $aReturnData;
    // }

    // Create By: Napat(Jame) 27/07/2021
    public function FSaCCSSPagePdtSN(){
        $aDataSearch = array(
            'tTaxDocNo' => $this->input->post('ptTaxDocNo'),
            'nSeqNo'    => $this->input->post('pnSeqNo')
        );
        $aResList = $this->Checkstatussale_model->FSaMCSSGetDataSNByPdt($aDataSearch);
        $this->load->view('document/checkstatussale/wCheckStatusSaleViewPdtSN', $aResList);
    }

    
    // Create By : Napat(Jame) 13/01/2022
    // ดึง Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSoCCSSEventGetConfigGenDocPack(){
        try {           
            $aConfGenDocPack = $this->Checkstatussale_model->FSaMCSSGetConfigGenDocPack();
            if( $aConfGenDocPack['tCode'] == '1' ){
                $aReturnData = array(
                    'aDataList' => $aConfGenDocPack['aItems'],
                    'nStaEvent' => '1',
                    'tStaMessg' => 'พบ Config'
                );
            }else{
                $aReturnData = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => 'ไม่พบ Config'
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
    
    // Create By : Napat(Jame) 13/01/2022
    // บันทึก Config เงื่อนไขการสร้างใบจัดสินค้า
    public function FSoCCSSEventSaveConfigGenDocPack(){
        try {          
            $aCondition     = ( !empty($this->input->post('paCondition')) ? $this->input->post('paCondition') : array() );
            $tCondWhereIn   = "";

            // ถ้า checkbox ให้ loop ใส่ where in
            if( FCNnHSizeOf($aCondition) > 0 ){
                $tCondWhereIn .= "'";
                foreach($aCondition as $nKey => $aValue){
                    if( $nKey != 0 ){
                        $tCondWhereIn .= "','";
                    }
                    $tCondWhereIn .= $aValue['ptSplit']; 
                }
                $tCondWhereIn .= "'";
            }

            $aReturnData = $this->Checkstatussale_model->FSaMCSSSaveConfigGenDocPack($tCondWhereIn);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By : Napat(Jame) 13/01/2022
    // Gen เอกสารใบจัดสินค้า
    public function FSoCCSSEventGenDocPacking(){
        try {
            $aMQParams = [
                "queueName" => "CN_QReqGenDoc",
                "params"        => [
                    "ptFunction"    =>  "TCNTPdtPickHD",    //ชื่อ Function
                    "ptSource"      =>  "AdaStoreBack",     //ต้นทาง
                    "ptDest"        =>  "MQReceivePrc",     //ปลายทาง
                    "ptData"        =>  json_encode([
                        "ptBchCode"     => $this->input->post('ptBchCode'),
                        "ptDocNo"       => $this->input->post('ptDocNo'),
                        "ptUserCode"    => $this->session->userdata("tSesUserCode"),
                        "paCondition"   => array(),
                        "ptPickType"    => '2' // 1 : สำหรับการจ่ายโอน , 2 : สำหรับการขาย
                    ])
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $aReturnData = array(
                'nStaEvent' => 1,
                'tStaMessg' => 'Send MQ Success.'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By : Napat(Jame) 14/01/2022
    // Gen เอกสารใบส่งของ
    public function FSoCCSSEventGenDocDelivery(){
        try {
            $aMQParams = [
                "queueName" => "CN_QReqGenDoc",
                "params"        => [
                    "ptFunction"    =>  "TARTDoHD",         //ชื่อ Function
                    "ptSource"      =>  "AdaStoreBack",     //ต้นทาง
                    "ptDest"        =>  "MQReceivePrc",     //ปลายทาง
                    "ptData"        =>  json_encode([
                        "ptBchCode"     => $this->input->post('ptBchCode'),
                        "ptDocNo"       => $this->input->post('ptDocNo'),
                        "ptUserCode"    => $this->session->userdata("tSesUserCode")
                    ])
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $aReturnData = array(
                'nStaEvent' => 1,
                'tStaMessg' => 'Send MQ Success.'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    

}
