<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );


require_once(APPPATH.'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH.'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cInterfaceExport extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('interface/interfaceexport/mInterfaceExport');
        // $this->load->model('interface/interfaceimport/mInterfaceImport');
    }

    public function index($nBrowseType,$tBrowseOption){

        $tUserCode = $this->session->userdata('tSesUserCode');
        $tLangEdit = $this->session->userdata("tLangEdit");
        $aParams = [
            'prefixQueueName' => 'LK_RPTransferResponseSAP',
            'ptUsrCode' => $tUserCode
        ];
        $this->FSxCIFXRabbitMQDeleteQName($aParams);
        $this->FSxCIFXRabbitMQDeclareQName($aParams);
        $aPackData = array(
            'nBrowseType'                   => $nBrowseType,
            'tBrowseOption'                 => $tBrowseOption,
            'aAlwEventInterfaceExport'      => FCNaHCheckAlwFunc('interfaceexport/0/0'), //Controle Event
            'vBtnSave'                      => FCNaHBtnSaveActiveHTML('interfaceexport/0/0'), //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'aDataMasterImport'             => $this->mInterfaceExport->FSaMIFXGetHD($tLangEdit)
        );

        $this->load->view('interface/interfaceexport/wInterfaceExport',$aPackData);

    }

    public function FSxCIFXRabbitMQDeclareQName($paParams){

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;

        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSxCIFXRabbitMQDeleteQName($paParams) {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;
        // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_delete($tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSxCIFXCallRabitMQ(){
        $tTypeEvent = $this->input->post('ptTypeEvent');
        $nReqpairExport = $this->input->post('ocbReqpairExport');

        if($tTypeEvent == 'getpassword'){
            $aResult = $this->mInterfaceExport->FSaMINMGetDataConfig();
            $aConnect = array(
                'tHost'      => $aResult[1]['FTCfgStaUsrValue'],
                'tPort'      => $aResult[2]['FTCfgStaUsrValue'],
                'tPassword'  => $aResult[3]['FTCfgStaUsrValue'],
                'tUser'      => $aResult[5]['FTCfgStaUsrValue'],
                'tVHost'     => $aResult[6]['FTCfgStaUsrValue']
            );
            echo json_encode($aConnect);
        }else{
            if( $nReqpairExport != 1 ){
                $aIFXExport     = $this->input->post('ocmIFXExport');
                // $aIFXExportCode = $this->input->post('ocmIFXExportName');
                $tPassword      = $this->input->post('tPassword');

                // echo "<pre>";
                // print_r($aIFXExport)."\n";
                // print_r($aIFXExportCode)."\n";
                // echo $tPassword;
                // echo "</pre>";

                if( !empty($aIFXExport) ){
                    $aPackData = array(
                        // Sale
                        'tBchCodeSale'          => $this->input->post('oetIFXBchCodeSale'),
                        'dDateFromSale'         => $this->input->post('oetITFXDateFromSale'),
                        'tDocNoFrom'            => $this->input->post('oetITFXXshDocNoFrom'),
                        'tDocNoTo'              => $this->input->post('oetITFXXshDocNoTo'),
                        'tPosCodeSale'          => $this->input->post('oetIFXPosCodeSale'),
                        'tShiftCode'            => $this->input->post('oetIFXShiftCodeSale'),
                        // Fin
                        'tBchCodeFin'           => $this->input->post('oetIFXBchCodeFin'),
                        'dDateFromFinanceFin'   => $this->input->post('oetITFXDateFromFinanceFin'),
                        'dDateToFinanceFin'     => $this->input->post('oetITFXDateToFinanceFin'),
                        'tDocNoFromFin'         => $this->input->post('oetITFXXshDocNoFromFin'),
                        'tDocNoToFin'           => $this->input->post('oetITFXXshDocNoToFin'),
                        'tPosCodeFin'           => $this->input->post('oetIFXPosCodeFin'),
                        'tWahCodeFin'           => $this->input->post('oetIFXWahCodeFin'),
                        'tDocType'              => $this->input->post('ocmITFXXshType'),
                        // Export Tax
                        'tBchCodeTax'           => $this->input->post('oetIFXBchCode00018'),
                        'tWahCodeTax'           => $this->input->post('oetIFXWahCode00018'),
                        'tPosCodeTax'           => $this->input->post('oetIFXPosCode00018'),
                        'dDateFromTax'          => $this->input->post('oetITFXDateFrom00018'),
                        'dDateToTax'            => $this->input->post('oetITFXDateTo00018'),
                        'tDocTypeTax'           => $this->input->post('ocmITFXTaxType00018'),
                        'tDocNoFromTax'         => $this->input->post('oetITFXFromTax00018'),
                        'tDocNoToTax'           => $this->input->post('oetITFXToTax00018'),
                        //ใบเบิกออก - คลังสินค้า
                        'tTwoAgnCode'           => '',
                        'tTwoBchCode'           =>$this->input->post('oetIFXBchCode00037'),
                        'tTwoWahCode'           =>$this->input->post('oetIFXWahCode00037'),
                        'tTwoPosCode'           =>$this->input->post('oetIFXPosCode00037'),
                        'nTwoDeliveryRound'     =>$this->input->post('oetDeliveryRound00037'),
                        'dTwoDateFrom'          =>$this->input->post('oetITFXDateFrom00037'),
                        'dTwoDateTo'            =>$this->input->post('oetITFXDateTo00037'),
                        'tTwoDocCodeFrom'      =>$this->input->post('oetITFXFromDocCode00037'),
                        'tTwoDocCodeTo'         =>$this->input->post('oetITFXToDocCode00037'),
                        //ใบรับเข้า - คลังสินค้า
                        'tTxoAgnCode'           => '',
                        'tTxoBchCode'           =>$this->input->post('oetIFXBchCode00038'),
                        'tTxoWahCode'           =>$this->input->post('oetIFXWahCode00038'),
                        'tTxoPosCode'           =>$this->input->post('oetIFXPosCode00038'),
                        'nTxoDeliveryRound'     =>$this->input->post('oetDeliveryRound00038'),
                        'dTxoDateFrom'          =>$this->input->post('oetITFXDateFrom00038'),
                        'dTxoDateTo'            =>$this->input->post('oetITFXDateTo00038'),
                        'tTxoDocCodeFrom'      =>$this->input->post('oetITFXFromDocCode00038'),
                        'tTxoDocCodeTo'         =>$this->input->post('oetITFXToDocCode00038'),
                        //ใบรับโอน
                        'tTwiAgnCode'           => '',
                        'tTwiBchCode'           =>$this->input->post('oetIFXBchCode00036'),
                        'tTwiWahCode'           =>$this->input->post('oetIFXWahCode00036'),
                        'tTwiPosCode'           =>$this->input->post('oetIFXPosCode00036'),
                        'nTwiDeliveryRound'     =>$this->input->post('oetDeliveryRound00036'),
                        'dTwiDateFrom'          =>$this->input->post('oetITFXDateFrom00036'),
                        'dTwiDateTo'            =>$this->input->post('oetITFXDateTo00036'),
                        'tTwiDocCodeFrom'      =>$this->input->post('oetITFXFromDocCode00036'),
                        'tTwiDocCodeTo'         =>$this->input->post('oetITFXToDocCode00036'),
                        //ใบโอนสินค้าระหว่างคลัง
                        'tTFWAgnCode'           => '',
                        'tTFWBchCode'           =>$this->input->post('oetIFXBchCode00039'),
                        'tTFWWahCode'           =>$this->input->post('oetIFXWahCode00039'),
                        'tTFWPosCode'           =>$this->input->post('oetIFXPosCode00039'),
                        'nTFWDeliveryRound'     =>$this->input->post('oetDeliveryRound00039'),
                        'dTFWDateFrom'          =>$this->input->post('oetITFXDateFrom00039'),
                        'dTFWDateTo'            =>$this->input->post('oetITFXDateTo00039'),
                        'tTFWDocCodeFrom'       =>$this->input->post('oetITFXFromDocCode00039'),
                        'tTFWDocCodeTo'         =>$this->input->post('oetITFXToDocCode00039'),
                        //Status การรับของ (ลูกค้า)
                        'tDOAgnCode'           => '',
                        'tDOBchCode'           =>$this->input->post('oetIFXBchCode00033'),
                        'tDOWahCode'           =>$this->input->post('oetIFXWahCode00033'),
                        'tDOPosCode'           =>$this->input->post('oetIFXPosCode00033'),
                        'nDODeliveryRound'     =>$this->input->post('oetDeliveryRound00033'),
                        'dDODateFrom'          =>$this->input->post('oetITFXDateFrom00033'),
                        'dDODateTo'            =>$this->input->post('oetITFXDateTo00033'),
                        'tDODocCodeFrom'      =>$this->input->post('oetITFXFromDocCode00033'),
                        'tDODocCodeTo'         =>$this->input->post('oetITFXToDocCode00033'),
                        //ส่งออก Status จัดสินค้า
                        'tPdtPickAgnCode'           => '',
                        'tPdtPickBchCode'           =>$this->input->post('oetIFXBchCode00035'),
                        'tPdtPickWahCode'           =>$this->input->post('oetIFXWahCode00035'),
                        'tPdtPickPosCode'           =>$this->input->post('oetIFXPosCode00035'),
                        'nPdtPickDeliveryRound'     =>$this->input->post('oetDeliveryRound00035'),
                        'dPdtPickDateFrom'          =>$this->input->post('oetITFXDateFrom00035'),
                        'dPdtPickDateTo'            =>$this->input->post('oetITFXDateTo00035'),
                        'tPdtPickDocCodeFrom'       =>$this->input->post('oetITFXFromDocCode00035'),
                        'tPdtPickDocCodeTo'         =>$this->input->post('oetITFXToDocCode00035'),
                        //ส่งออก Payin Slip
                        'tDepositAgnCode'           => '',
                        'tDepositBchCode'           =>$this->input->post('oetIFXBchCode00034'),
                        'tDepositWahCode'           =>$this->input->post('oetIFXWahCode00034'),
                        'tDepositPosCode'           =>$this->input->post('oetIFXPosCode00034'),
                        'nDepositDeliveryRound'     =>$this->input->post('oetDeliveryRound00034'),
                        'dDepositDateFrom'          =>$this->input->post('oetITFXDateFrom00034'),
                        'dDepositDateTo'            =>$this->input->post('oetITFXDateTo00034'),
                        'tDepositDocCodeFrom'       =>$this->input->post('oetITFXFromDocCode00034'),
                        'tDepositDocCodeTo'         =>$this->input->post('oetITFXToDocCode00034'),
                        //ส่งออก Member - Earn/Burn Point(Sale)
                        'tEBMAgnCode'           => '',
                        'tEBMBchCode'           =>$this->input->post('oetIFXBchCode00040'),
                        'tEBMWahCode'           =>$this->input->post('oetIFXWahCode00040'),
                        'tEBMPosCode'           =>$this->input->post('oetIFXPosCode00040'),
                        'nEBMDeliveryRound'     =>$this->input->post('oetDeliveryRound00040'),
                        'dEBMDateFrom'          =>$this->input->post('oetITFXDateFrom00040'),
                        'dEBMDateTo'            =>$this->input->post('oetITFXDateTo00040'),
                        'tEBMDocCodeFrom'       =>$this->input->post('oetITFXFromDocCode00040'),
                        'tEBMDocCodeTo'         =>$this->input->post('oetITFXToDocCode00040'),
                        //	ส่งออก Earn/Burn Point(Return)
                        'tEBPAgnCode'           => '',
                        'tEBPBchCode'           =>$this->input->post('oetIFXBchCode00041'),
                        'tEBPWahCode'           =>$this->input->post('oetIFXWahCode00041'),
                        'tEBPPosCode'           =>$this->input->post('oetIFXPosCode00041'),
                        'nEBPDeliveryRound'     =>$this->input->post('oetDeliveryRound00041'),
                        'dEBPDateFrom'          =>$this->input->post('oetITFXDateFrom00041'),
                        'dEBPDateTo'            =>$this->input->post('oetITFXDateTo00041'),
                        'tEBPDocCodeFrom'       =>$this->input->post('oetITFXFromDocCode00041'),
                        'tEBPDocCodeTo'         =>$this->input->post('oetITFXToDocCode00041'),
                        // ส่งออกรายการขาย (ตู้สุ่ม)
                        'tSALVDBchCode'           => $this->input->post('oetIFXBchCode00042'),
                        'tSALVDWahCode'           => $this->input->post('oetIFXWahCode00042'),
                        'tSALVDPosCode'           => $this->input->post('oetIFXPosCode00042'),
                        'dSALVDDateFrom'          => $this->input->post('oetITFXDateFrom00042'),
                        'dSALVDDateTo'            => $this->input->post('oetITFXDateTo00042'),
                        'tSALVDDocCodeFrom'       => $this->input->post('oetITFXFromDocCode00042'),
                        'tSALVDDocCodeTo'         => $this->input->post('oetITFXToDocCode00042'),
                        // ส่งออกรายการขาย (E-Tax)
                        // 'tBchCode00044'           => $this->input->post('oetIFXBchCode00044'),
                        // 'tWahCode00044'           => $this->input->post('oetIFXWahCode00044'),
                        // 'tPosCode00044'           => $this->input->post('oetIFXPosCode00044'),
                        // 'dDateFrom00044'          => $this->input->post('oetITFXDateFrom00044'),
                        // 'dDateTo00044'            => $this->input->post('oetITFXDateTo00044'),
                        // 'tCodeFrom00044'          => $this->input->post('oetIFXCodeFrom00044'),
                        // 'tCodeTo00044'            => $this->input->post('oetIFXCodeTo00044'),

                        //รหัส MQ
                        'tPasswordMQ'           => $tPassword
                    );

                    foreach($aIFXExport as $nKey => $nValue){
                        $this->FSaCIFXGetFormatParam($nValue,$aPackData);
                    }
                }
                return;
            }else{
                $this->FSxCINFCallPreapairExport($this->input->post('tPassword'));
            }
        }
    }

    public function FCNxCallRabbitMQSale($paParams,$pbStaUse = true,$ptPasswordMQ) {

        $aVal = $this->mInterfaceExport->FSaMINMGetDataConfig();
        $tHost = $aVal[1]['FTCfgStaUsrValue'];
        $tPort = $aVal[2]['FTCfgStaUsrValue'];
        $tPassword = $aVal[3]['FTCfgStaUsrValue'];
        // $tQueueName = $aVal[4]['FTCfgStaUsrValue'];
        $tUser = $aVal[5]['FTCfgStaUsrValue'];
        $tVHost = $aVal[6]['FTCfgStaUsrValue'];


        $tQueueName             = $paParams['queueName'];
        $aParams                = $paParams['params'];
        if($pbStaUse == true){
            $aParams['ptConnStr']   = DB_CONNECT;
        }
        $tExchange              = EXCHANGE; // This use default exchange


        $oConnection = new AMQPStreamConnection($tHost, $tPort,  $tUser, $ptPasswordMQ, $tVHost);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();
        return 1; /** Success */
    }

    public function FSaCIFXGetFormatParam($pnFormat,$paPackData){

        switch($pnFormat){
            case '00012':
                $aMQParams = [
                    "queueName"     => "EX_TxnSaleVender",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePos",//ชื่อ Function
                        "ptSource"      =>  "AdaTaskLink", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptFilter"     => $paPackData['tBchCodeFin'],
                            "ptWaHouse"    => $paPackData['tWahCodeFin'],
                            "ptPosCode"    => $paPackData['tPosCodeFin'],
                            "ptRound"      => "1",
                            "ptDateFrm"    => $paPackData['dDateFromFinanceFin'],
                            "ptDateTo"     => $paPackData['dDateToFinanceFin'],
                            "ptDocNoFrm"   => $paPackData['tDocNoFromFin'],
                            "ptDocNoTo"    => $paPackData['tDocNoToFin'],
                            "pnDocType"    => $paPackData['tDocType'],
                        ])
                    ]
                ];
                break;
            case '00018':
                $aMQParams = [
                    "queueName"     => "EX_TxnSaleVender",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePos",//ชื่อ Function
                        "ptSource"      =>  "AdaTaskLink", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptFilter"     => $paPackData['tBchCodeTax'],
                            "ptWaHouse"    => $paPackData['tWahCodeTax'],
                            "ptPosCode"    => $paPackData['tPosCodeTax'],
                            "ptRound"      => "1",
                            "ptDateFrm"    => $paPackData['dDateFromTax'],
                            "ptDateTo"     => $paPackData['dDateToTax'],
                            "ptDocNoFrm"   => $paPackData['tDocNoFromTax'],
                            "ptDocNoTo"    => $paPackData['tDocNoToTax'],
                            "pnDocType"    => $paPackData['tDocTypeTax'],
                        ])
                    ]
                ];
                break;
            case '00014':
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnCloseShf",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendCloseShift",//ชื่อ Function
                        "ptSource"      =>  "AdaTaskLink", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "pnRound"      => "1",
                            "ptBchCode"    => $paPackData['tBchCodeSale'],
                            "ptPosCode"    => $paPackData['tPosCodeSale'],
                            "ptShfCode"    => $paPackData['tShiftCode'],
                            "pdSaleDate"   => $paPackData['dDateFromSale'],
                            "ptTaskRef"    => "",
                            "pnDocType"    => 0
                        ])
                    ]
                ];
                break;

            case '00037':
                if ($paPackData['tTwoDocCodeTo'] == '') {
                    $paPackData['tTwoDocCodeTo'] = $paPackData['tTwoDocCodeFrom'];
                }else{
                    $paPackData['tTwoDocCodeTo'] = $paPackData['tTwoDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnDocTnf",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendGI",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'         => $paPackData['tTwoAgnCode'],
                            'ptFilter'          => $paPackData['tTwoBchCode'],
                            'ptWaHouse'         => $paPackData['tTwoWahCode'],
                            'ptPosCode'         => $paPackData['tTwoPosCode'],
                            'ptRound'           => $paPackData['nTwoDeliveryRound'],
                            'ptDateFrm'         => $paPackData['dTwoDateFrom'],
                            'ptDateTo'          => $paPackData['dTwoDateTo'],
                            'ptDocNoFrm'        => $paPackData['tTwoDocCodeFrom'],
                            'ptDocNoTo'         => $paPackData['tTwoDocCodeTo'],
                            'pnDocType'         => 2
                        ])
                    ]
                ];
                break;

            case '00038':
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnDocTnf",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendGR",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'         => $paPackData['tTxoAgnCode'],
                            'ptFilter'          => $paPackData['tTxoBchCode'],
                            'ptWaHouse'         => $paPackData['tTxoWahCode'],
                            'ptPosCode'         => $paPackData['tTxoPosCode'],
                            'ptRound'           => "1",
                            'ptDateFrm'         => $paPackData['dTxoDateFrom'],
                            'ptDateTo'          => $paPackData['dTxoDateTo'],
                            'ptDocNoFrm'        => $paPackData['tTxoDocCodeFrom'],
                            'ptDocNoTo'         => $paPackData['tTxoDocCodeTo'],
                            'pnDocType'         => 1
                        ])
                    ]
                ];
                break;

            case '00036':
                if ($paPackData['tTwiDocCodeTo'] == '') {
                    $paPackData['tTwiDocCodeTo'] = $paPackData['tTwiDocCodeFrom'];
                }else{
                    $paPackData['tTwiDocCodeTo'] = $paPackData['tTwiDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnDocTnf",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendTR",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             => $paPackData['tTwiAgnCode'],
                            'ptFilter'              => $paPackData['tTwiBchCode'],
                            'ptWaHouse'             => $paPackData['tTwiWahCode'],
                            'ptPosCode'             => $paPackData['tTwiPosCode'],
                            'ptRound'               => "1",
                            'ptDateFrm'             => $paPackData['dTwiDateFrom'],
                            'ptDateTo'              => $paPackData['dTwiDateTo'],
                            'ptDocNoFrm'            => $paPackData['tTwiDocCodeFrom'],
                            'ptDocNoTo'             => $paPackData['tTwiDocCodeTo'],
                            'pnDocType'             => 0
                        ])
                    ]
                ];
                break;

            case '00039':
                if ($paPackData['tTFWDocCodeTo'] == '') {
                    $paPackData['tTFWDocCodeTo'] = $paPackData['tTFWDocCodeFrom'];
                }else{
                    $paPackData['tTFWDocCodeTo'] = $paPackData['tTFWDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnDocTnf",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendWah2Wah",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             =>$paPackData['tTFWAgnCode'],
                            'ptFilter'              =>$paPackData['tTFWBchCode'],
                            'ptWaHouse'             =>$paPackData['tTFWWahCode'],
                            'ptPosCode'             =>$paPackData['tTFWPosCode'],
                            'ptRound'               =>"1",
                            'ptDateFrm'             =>$paPackData['dTFWDateFrom'],
                            'ptDateTo'              =>$paPackData['dTFWDateTo'],
                            'ptDocNoFrm'            =>$paPackData['tTFWDocCodeFrom'],
                            'ptDocNoTo'             =>$paPackData['tTFWDocCodeTo'],
                            'pnDocType'             => 0
                        ])
                    ]
                ];
                break;

            case '00033':
                if ($paPackData['tDODocCodeTo'] == '') {
                    $paPackData['tDODocCodeTo'] = $paPackData['tDODocCodeFrom'];
                }else{
                    $paPackData['tDODocCodeTo'] = $paPackData['tDODocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_UpdStaAfCstRcv",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendUpdStaCstRcv",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             => $paPackData['tDOAgnCode'],
                            'ptFilter'              => $paPackData['tDOBchCode'],
                            'ptWaHouse'             => $paPackData['tDOWahCode'],
                            'ptPosCode'             => $paPackData['tDOPosCode'],
                            'ptRound'               => "1",
                            'ptDateFrm'             => $paPackData['dDODateFrom'],
                            'ptDateTo'              => $paPackData['dDODateTo'],
                            'ptDocNoFrm'            => $paPackData['tDODocCodeFrom'],
                            'ptDocNoTo'             => $paPackData['tDODocCodeTo'],
                            'pnDocType'             => 4
                        ])
                    ]
                ];
                break;

            case '00035':
                if ($paPackData['tPdtPickDocCodeTo'] == '') {
                    $paPackData['tPdtPickDocCodeTo'] = $paPackData['tPdtPickDocCodeFrom'];
                }else{
                    $paPackData['tPdtPickDocCodeTo'] = $paPackData['tPdtPickDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SAPStatusPacked",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendStatusPacked",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             =>$paPackData['tPdtPickAgnCode'],
                            'ptFilter'              =>$paPackData['tPdtPickBchCode'],
                            'ptWaHouse'             =>$paPackData['tPdtPickWahCode'],
                            'ptPosCode'             =>$paPackData['tPdtPickPosCode'],
                            'ptRound'               =>"1",
                            'ptDateFrm'             =>$paPackData['dPdtPickDateFrom'],
                            'ptDateTo'              =>$paPackData['dPdtPickDateTo'],
                            'ptDocNoFrm'            =>$paPackData['tPdtPickDocCodeFrom'],
                            'ptDocNoTo'             =>$paPackData['tPdtPickDocCodeTo'],
                            'pnDocType'             => 2
                        ])
                    ]
                ];
                break;

            case '00034':
                if ($paPackData['tDepositDocCodeTo'] == '') {
                    $paPackData['tDepositDocCodeTo'] = $paPackData['tDepositDocCodeFrom'];
                }else{
                    $paPackData['tDepositDocCodeTo'] = $paPackData['tDepositDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SAPTxnPaySlip",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SendPayIn",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             =>$paPackData['tDepositAgnCode'],
                            'ptFilter'              =>$paPackData['tDepositBchCode'],
                            'ptWaHouse'             =>$paPackData['tDepositWahCode'],
                            'ptPosCode'             =>$paPackData['tDepositPosCode'],
                            'ptRound'               =>"1",
                            'ptDateFrm'             =>$paPackData['dDepositDateFrom'],
                            'ptDateTo'              =>$paPackData['dDepositDateTo'],
                            'ptDocNoFrm'            =>$paPackData['tDepositDocCodeFrom'],
                            'ptDocNoTo'             =>$paPackData['tDepositDocCodeTo'],
                            'pnDocType'             => 0
                        ])
                    ]
                ];
                break;
                
            case '00040':
                if ($paPackData['tEBMDocCodeTo'] == '') {
                    $paPackData['tEBMDocCodeTo'] = $paPackData['tEBMDocCodeFrom'];
                }else{
                    $paPackData['tEBMDocCodeTo'] = $paPackData['tEBMDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_SalePnt2KPC",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePoint",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             => $paPackData['tEBMAgnCode'],
                            'ptFilter'              => $paPackData['tEBMBchCode'],
                            'ptWaHouse'             => $paPackData['tEBMWahCode'],
                            'ptPosCode'             => $paPackData['tEBMPosCode'],
                            'ptRound'               => "1",
                            'ptDateFrm'             => $paPackData['dEBMDateFrom'],
                            'ptDateTo'              => $paPackData['dEBMDateTo'],
                            'ptDocNoFrm'            => $paPackData['tEBMDocCodeFrom'],
                            'ptDocNoTo'             => $paPackData['tEBMDocCodeTo'],
                            'pnDocType'             => 1
                        ])
                    ]
                ];
                break;

            case '00041':
                if ($paPackData['tEBPDocCodeTo'] == '') {
                    $paPackData['tEBPDocCodeTo'] = $paPackData['tEBPDocCodeFrom'];
                }else{
                    $paPackData['tEBPDocCodeTo'] = $paPackData['tEBPDocCodeTo'];
                }
                $aMQParams = [
                    "queueName"     => "EX_ReturnPnt2KPC",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "ReturnPoint",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptAgnCode'             => $paPackData['tEBPAgnCode'],
                            'ptFilter'              => $paPackData['tEBPBchCode'],
                            'ptWaHouse'             => $paPackData['tEBPWahCode'],
                            'ptPosCode'             => $paPackData['tEBPPosCode'],
                            'ptRound'               => "1",
                            'ptDateFrm'             => $paPackData['dEBPDateFrom'],
                            'ptDateTo'              => $paPackData['dEBPDateTo'],
                            'ptDocNoFrm'            => $paPackData['tEBPDocCodeFrom'],
                            'ptDocNoTo'             => $paPackData['tEBPDocCodeTo'],
                            'pnDocType'             => 9
                        ])
                    ]
                ];
                break;
            case '00042':
                $paPackData['tSALVDDocCodeTo']      = ($paPackData['tSALVDDocCodeTo'] == '' ? $paPackData['tSALVDDocCodeFrom'] : $paPackData['tSALVDDocCodeTo']);
                $paPackData['tSALVDDocCodeFrom']    = ($paPackData['tSALVDDocCodeFrom'] == '' ? $paPackData['tSALVDDocCodeTo'] : $paPackData['tSALVDDocCodeFrom']);
                $paPackData['dSALVDDateFrom']       = ($paPackData['dSALVDDateFrom'] == '' ? $paPackData['dSALVDDateTo'] : $paPackData['dSALVDDateFrom']);
                $paPackData['dSALVDDateTo']         = ($paPackData['dSALVDDateTo'] == '' ? $paPackData['dSALVDDateFrom'] : $paPackData['dSALVDDateTo']);

                $aMQParams = [
                    "queueName"     => "EX_TxnSaleVD",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePosVD",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            'ptFilter'              => $paPackData['tSALVDBchCode'],
                            'ptWaHouse'             => $paPackData['tSALVDWahCode'],
                            'ptPosCode'             => $paPackData['tSALVDPosCode'],
                            'ptRound'               => "1",
                            'ptDateFrm'             => $paPackData['dSALVDDateFrom'],
                            'ptDateTo'              => $paPackData['dSALVDDateTo'],
                            'ptDocNoFrm'            => $paPackData['tSALVDDocCodeFrom'],
                            'ptDocNoTo'             => $paPackData['tSALVDDocCodeTo'],
                            "pnDocType"             => 1
                        ])
                    ]
                ];
                break;
            // case '00044':

            //     $aMQParams = [
            //         "queueName"     => "EX_TxnSaleETax",
            //         "exchangname"   => "",
            //         "params"        => [
            //             "ptFunction"    =>  "SaleRef",//ชื่อ Function
            //             "ptSource"      =>  "AdaStoreBack", //ต้นทาง
            //             "ptDest"        =>  "MQAdaLink",  //ปลายทาง
            //             "ptData"        =>  json_encode([
            //                 'ptBchCode'         => $paPackData['tBchCode00044'],
            //                 'ptProvider'        => '1',
            //                 'ptUserCode'        => $paPackData['tSALVDPosCode'],
            //                 'ptPosCode'         => $paPackData['tPosCode00044'],
            //                 'ptDocType'         => '1',
            //                 'ptDocNo'           => $paPackData['dSALVDDateTo'],
            //                 'ptRefDocType'      => $paPackData['tSALVDDocCodeFrom'],
            //                 'ptDocRef'          => $paPackData['tSALVDDocCodeTo'],


            //                 "ptBchCode":"xxxxx"               // รหัสสาขา          
            //                 ,"ptProvider":"1"                                        // FIX 1= iNET (provider ที่ระบบใช้งาน)
            //                 ,"ptUserCode":""                                        // รหัสพนักงาน        
            //                 ,"ptPosCode":""                                        //รหัส POS
            //                 ,"ptDocType":"1"                                  // 1=ABB 2=FULL TAX 3=CN-ABB 4=CN-FULL 5=DN 6=ใบแจ้งหนี้  7=CLN ใบยกเลิก
            //         ,"ptDocNo":"CL0000100003190000007" // เลขที่เอกสาร          
            //                 ,"ptRefDocType":"1"                                // ประเภทเอกสาร  1=ABB 2=FULL TAX 3=CN-ABB 4=CN-FULL 5=DN 6=ใบแจ้งหนี้  (ใช้กรณียกเลิกเอกสาร)
            //                 ,"ptDocRef":"S0000100003190000007"        //เอกสารอ้างอิง

            //             ])
            //         ]
            //     ];
            //     break;
        }
        // echo "<pre>";
        // print_r($aMQParams);
        // echo "</pre>";

        $this->FCNxCallRabbitMQSale($aMQParams,false,$paPackData['tPasswordMQ']);
    }


//ส่งคิวตามรายการบิล เฉพาะการติ๊กว่า ส่งไม่สำเร็จ
 public function FSxCINFCallPreapairExport($ptPasswordMQ){
     $aDocNoPrepair= $this->mInterfaceExport->FSaMINMGetLogHisError();

        if(!empty($aDocNoPrepair)){
            foreach($aDocNoPrepair as $aValue){
                $aMQParams = [
                    "queueName"     => "LK_QSale2Vender",
                    "exchangname"   => "",
                    "params"        => [
                        "ptFunction"    =>  "SalePos",//ชื่อ Function
                        "ptSource"      =>  "AdaStoreBack", //ต้นทาง
                        "ptDest"        =>  "MQAdaLink",  //ปลายทาง
                        "ptData"        =>  json_encode([
                            "ptFilter"      => $aValue['FTBchCode'],
                            "ptDateFrm"     => '',
                            "ptDateTo"      => '',
                            "ptDocNoFrm"    => $aValue['FTLogTaskRef'],
                            "ptDocNoTo"     => $aValue['FTLogTaskRef'],
                            "ptWaHouse"     => '',
                            "ptPosCode"     => '',
                            "ptRound"       => '1'
                        ])
                    ]
                ];


                $this->FCNxCallRabbitMQSale($aMQParams,false,$ptPasswordMQ);
            }
        }

 }


    public function FSnCIFXFillterBill(){

            $aDataParam = [
                'tFXBchCodeSale' => $this->input->post('oetIFXBchCodeSale'),
                'tFXDateFromSale' => $this->input->post('oetITFXDateFromSale'),
                'tFXDateToSale' => $this->input->post('oetITFXDateToSale'),
            ];
            $this->mInterfaceExport->FSxMIFXFillterBill($aDataParam);
           return 1;

    }

}
?>
