<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Abbsalerefund_controller extends MX_Controller {

    public $aPermission = [];

    public function __construct(){
        parent::__construct();
        $this->load->model('document/abbsalerefund/Abbsalerefund_model');
    }

    // Create By: Napat(Jame) 02/07/2021
    public function index($nBrowseType, $tBrowseOption){
        $aDataConfigView = array(
            'nBrowseType'       => $nBrowseType,
            'tBrowseOption'     => $tBrowseOption,
            'aPermission'       => FCNaHCheckAlwFunc('docABB/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docABB/0/0'),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/abbsalerefund/wABBSaleRefund', $aDataConfigView);
    }

    // เรียกหน้า List
    // Create By: Napat(Jame) 02/07/2021
    public function FSvCABBPageList(){
        $aAlwChnShw = $this->Abbsalerefund_model->FSaMABBAlwChnShw();
        $this->load->view('document/abbsalerefund/wABBSaleRefundList',array(
            'aGetChnDelivery' => $aAlwChnShw
        ));
    }
    
    // เรียกหน้า DataTable
    // Create By: Napat(Jame) 02/07/2021
    public function FSvCABBPageDataTable(){
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

        $aResList = $this->Abbsalerefund_model->FSaMABBDataList($aDataSearch);
        $aGenTable = array(
            'aAlwEvent'         => FCNaHCheckAlwFunc('docABB/0/0'),
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );
        $this->load->view('document/abbsalerefund/wABBSaleRefundDataTable', $aGenTable);
        // $aReturnData = array(
        //     'tViewDataTable'    => $this->load->view('document/transferreceiptOut/wTransferreceiptOutDataTable', $aGenTable, true),
        //     'nStaEvent'         => '1',
        //     'tStaMessg'         => 'Success'
        // );
        // echo json_encode($aReturnData);
    }

    // เรียกหน้า Edit/View
    // Create By: Napat(Jame) 05/07/2021
    public function FSvCABBPageEdit(){
        try {
            $tDocNo = $this->input->post('ptDocNo');

            // Clear Data In Doc DT Temp
            $aWhereTemp = [
                'tDocKey'       => 'TPSTSalHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->Abbsalerefund_model->FSaMABBEventClearPdtSNTmp($aWhereTemp);

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
            $aDataDocHD = $this->Abbsalerefund_model->FSaMABBEventGetDataDocHD($aDataWhere);
            if( $aDataDocHD['tCode'] == '1' ){
                // $aDataDocRC     = $this->Abbsalerefund_model->FSaMABBEventGetDataDocRC($aDataWhere); // Get Data RC
                $aDataDocDT     = $this->Abbsalerefund_model->FSaMABBEventGetDocDT($aDataWhere);
                $aDataDocDTDis  = $this->Abbsalerefund_model->FSaMABBEventGetDocDTDis($aDataWhere);

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

                $this->Abbsalerefund_model->FSaMABBEventInsertToTmp($aDataDTTmp);
                $this->Abbsalerefund_model->FSaMABBEventUpdPdtSNTmp($aDataWhere,$aWhereTemp);

                // $aDataWhere['tDocType']  =  $aDataDocHD['aItems']['FNXshDocType'];
                // $aDataWhere['tRefInt']   =  $aDataDocHD['aItems']['FTXshRefInt'];
                // $aDataWhere['tCstCode']  =  $aDataDocHD['aItems']['FTCstCode'];
                // $aDataWhere['tDocDate']  =  $aDataDocHD['aItems']['FDTxnDocDate'];
                // echo "<pre>"; print_r($aDataDocHD['aItems']); echo "</pre>"; exit;

                $aPackData = array(
                    // 'aDataPoints'       => $this->Abbsalerefund_model->FSaMABBEventGetDataPoints($aDataWhere), // Get Data Points
                    'aDataDocHD'        => $aDataDocHD['aItems'],
                    // 'aDataDocRC'        => $aDataDocRC,
                    'nOptDecimalShow'   => $nOptDecimalShow,
                );
                // echo "<pre>"; print_r($aPackData['aDataPoints']); echo "</pre>"; exit;
                
                $aReturnData = array(
                    'tViewPageAdd'   => $this->load->view('document/abbsalerefund/wABBSaleRefundPageAdd', $aPackData, true),
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
    public function FSvCABBPageProductDataTable(){
        try {
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            $aDataWhere = array(
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tSearch'       => $this->input->post('ptSearch'),
                'nLngID'        => $this->session->userdata("tLangEdit"),
            );

            
            $aDataDocDT         = $this->Abbsalerefund_model->FSaMABBEventGetDataDocDTTmp($aDataWhere); // Get Data Document DT
            $aDataDisPro        = $this->Abbsalerefund_model->FSaMABBEventGetDataDisPromotions($aDataWhere); // Get Data Discount Promotions
            $aDataEndBill       = $this->Abbsalerefund_model->FSaMABBEventGetDataEndBill($aDataWhere); // Get Data End Bill
            $aDataEndBillVat    = $this->Abbsalerefund_model->FSaMABBEventGetDataEndBillVat($aDataWhere); // Get Data End Bill Vat
            $nCountSerial       = $this->Abbsalerefund_model->FSnMABBEventCountSerial($aDataWhere);
            

            // Call Footer Document
            $aEndOfBill = array(
                'aDataDocRC'    => $this->Abbsalerefund_model->FSaMABBEventGetDataDocRC($aDataWhere), // Get Data RC
                'aDataPoints'   => $this->Abbsalerefund_model->FSaMABBEventGetDataPoints($aDataWhere), // Get Data Points
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
                    'aItems'                => $aDataEndBillVat['aItems'],
                    'cVatSum'               => number_format($aDataEndBill['aItems']['FCXshVat'],$nOptDecimalShow)
                ),
                'tTextBath'                 => $aDataEndBill['aItems']['FTXshGndText']
            );
            // echo "<pre>"; print_r($aEndOfBill); echo "</pre>";exit;

            $aPackData = array(
                'aDataDocDTTemp'    => $aDataDocDT,
                'nOptDecimalShow'   => $nOptDecimalShow
            );
            $aReturnData = array(
                'tViewPdtDataTable' => $this->load->view('document/abbsalerefund/wABBSaleRefundPdtDataTable', $aPackData, true),
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
    public function FSaCABBEventGetDataPdtSN(){
        try {
            $aDataWhere = array(
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tScanBarCode'  => $this->input->post('ptScanBarCode'),
                'nLngID'        => $this->session->userdata("tLangEdit")
            );
            $aDataPdtSN = $this->Abbsalerefund_model->FSaMABBEventGetDataPdtSN($aDataWhere);
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
    public function FSaCABBEventUpdatePdtSNTmp(){
        $aWhereTemp = [
            'tDocNo'        => $this->input->post('ptDocNo'),
            'tPdtCode'      => $this->input->post('ptPdtCode'),
            'tSerialNo'     => $this->input->post('ptSerialNo'),
            'tDocKey'       => 'TPSTSalHD',
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        ];
        $this->Abbsalerefund_model->FSaMABBEventUpdatePdtSNTmp($aWhereTemp);
    }

    // ย้ายจาก Temp ไปตารางจริง
    // Create By: Napat(Jame) 07/07/2021
    public function FSaCABBEventMoveTmpToDT(){
        try {
            $aWhere = [
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tDocVatFull'   => $this->input->post('ptDocVatFull'),
                'tDocKey'       => 'TPSTSalHD',
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->db->trans_begin();
            $aMoveTmpToDT = $this->Abbsalerefund_model->FSaMABBEventMoveTmpToDT($aWhere);
            $this->Abbsalerefund_model->FSaMABBEventClearPdtSNTmp($aWhere);
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
    public function FSaCABBEventApproved(){
        try {
            $aWhere = [
                'tDocNo'        => $this->input->post('ptDocNo'),
            ];
            $this->db->trans_begin();
            $aChkFormatAPI = $this->Abbsalerefund_model->FSaMABBEventChkFormatAPI(); //ตรวจสอบ Config TSysFormatAPI_L มี '00006' หรือไม่ ?
            if( $aChkFormatAPI['tCode'] == '1' ){
                $aChkFullTax = $this->Abbsalerefund_model->FSaMABBEventChkFullTax($aWhere); //ตรวจสอบว่า บิลขายมี FullTax ไหม
                if( $aChkFullTax['tCode'] == '1' ){
                    $tDocVatFull = $aChkFullTax['tDocVatFull'];
                }else{
                    $tDocVatFull = "";
                }

                $aMQParams = [
                    "queueName" => "EX_TxnSaleETax",
                    "exchangname" => "",
                    "params" => [
                        "ptFunction"    => "SaleRef",
                        "ptSource"      => "MQ.RcvProcess",
                        "ptDest"        => "MQ.AdaLink",
                        "ptData" => [
                            "ptABBDocNo"    => $aWhere['tDocNo'],
                            "ptTaxDocNoTo"  => $tDocVatFull
                        ]
                    ]
                ];
                $this->FCNxCallRabbitMQInterface($aMQParams);
            }
            
            $this->Abbsalerefund_model->FSaMABBEventApproved($aWhere);
            if ( $this->db->trans_status() === FALSE ) {
                $this->db->trans_rollback();
                $aReturnData  = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => 'Query Error',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData  = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'Success',
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
    public function FCNxCallRabbitMQInterface($paParams){
        $aConfigMQ      = $this->Abbsalerefund_model->FSaMABBEventGetConfigMQ();
        $tHost          = $aConfigMQ['aItems'][1]['FTCfgStaUsrValue'];
        $tPort          = '5672'/*$aConfigMQ['aItems'][2]['FTCfgStaUsrValue']*/;
        $tPassword      = 'Admin'/*$aConfigMQ['aItems'][3]['FTCfgStaUsrValue']*/;
        $tQueueName     = $paParams['queueName']/*$aConfigMQ['aItems'][4]['FTCfgStaUsrValue']*/;
        $tUser          = $aConfigMQ['aItems'][5]['FTCfgStaUsrValue'];
        $tVHost         = $aConfigMQ['aItems'][6]['FTCfgStaUsrValue'];
        $aParams        = $paParams['params'];

        $oConnection = new AMQPStreamConnection($tHost, $tPort, $tUser, $tPassword, $tVHost);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();
    }

    // Create By: Napat(Jame) 27/07/2021
    public function FSaCABBPagePdtSN(){
        $aDataSearch = array(
            'tTaxDocNo' => $this->input->post('ptTaxDocNo'),
            'nSeqNo'    => $this->input->post('pnSeqNo')
        );
        $aResList = $this->Abbsalerefund_model->FSaMABBGetDataSNByPdt($aDataSearch);
        $this->load->view('document/abbsalerefund/wABBSaleRefundViewPdtSN', $aResList);
    }

}
