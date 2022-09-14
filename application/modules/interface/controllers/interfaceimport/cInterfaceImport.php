<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cInterfaceimport extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('interface/interfaceimport/mInterfaceImport');
    }

    public function index($nBrowseType, $tBrowseOption)
    {

        $aData['nBrowseType']                   = $nBrowseType;
        $aData['tBrowseOption']                 = $tBrowseOption;
        $aData['aAlwEventInterfaceImport']      = FCNaHCheckAlwFunc('interfaceimport/0/0'); //Controle Event
        $aData['vBtnSave']                      = FCNaHBtnSaveActiveHTML('interfaceimport/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $tLangEdit                              = $this->session->userdata("tLangEdit");

        $aData['aDataMasterImport'] = $this->mInterfaceImport->FSaMINMGetHD($tLangEdit);


        // $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);

        // echo '<pre>';
        // print_r($aData['aDataMasterImport']);
        // echo '</pre>';

        $tUserCode = $this->session->userdata('tSesUserCode');

        $aParams = [
            'prefixQueueName' => 'LK_RPTransferResponseSAP',
            'ptUsrCode' => $tUserCode
        ];

        $this->FSxCINMRabbitMQDeleteQName($aParams);
        $this->FSxCINMRabbitMQDeclareQName($aParams);
        $this->load->view('interface/interfaceimport/wInterfaceImport', $aData);
    }


    public function FSxCINMCallRabitMQ()
    {
        $tLangEdit  = $this->session->userdata("tLangEdit");
        $tTypeEvent = $this->input->post('ptTypeEvent');
        if ($tTypeEvent == 'getpassword') {
            $aResult = $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);
            $aConnect = array(
                'tHost'      => $aResult[1]['FTCfgStaUsrValue'],
                'tPort'      => $aResult[2]['FTCfgStaUsrValue'],
                'tPassword'  => $aResult[3]['FTCfgStaUsrValue'],
                'tUser'      => $aResult[5]['FTCfgStaUsrValue'],
                'tVHost'     => $aResult[6]['FTCfgStaUsrValue']
            );
            echo json_encode($aConnect);
        } else {
            $tPassword      = $this->input->post('tPassword');
            $aINMImport = $this->input->post('ocmINMImport');
            $aDataCheck = array();
            $aApiGrpPrc = array(
              "00001" => "Pdt",
              "00002" => "PdtHrc",
              "00003" => "PdtPrc"
            );
            foreach ($aINMImport as $tKey => $tValue) {
              $aDataCheck[]  = $tValue;
            }
            if(!empty($aINMImport)){
                foreach($aINMImport as $tApiCode => $tApiGrpPrc){
                    if (in_array($tApiGrpPrc, $aDataCheck)){
                        $aMQParams = [
                            "queueName" => "IM_SAPMProduct",
                            "exchangname" => "",
                            "params" => [
                                "ptFunction"    => $aApiGrpPrc[$tApiGrpPrc],
                                "ptSource"      => "Interface",
                                "ptDest"        => "MQAdaLink",
                                "ptFilter"      => $this->session->userdata('tSesUsrAgnCode'),
                                "ptData"        => ""
                            ]
                        ];
                    }else {
                        $aMQParams = [
                            "queueName" => "IM_SAPMProduct",
                            "exchangname" => "",
                            "params" => [
                                "ptFunction"    => $tApiGrpPrc,
                                "ptSource"      => "Interface",
                                "ptDest"        => "MQAdaLink",
                                "ptFilter"      => $this->session->userdata('tSesUsrAgnCode'),
                                "ptData"        => ""
                            ]
                        ];
                    }
                    $this->FCNxCallRabbitMQMaster($aMQParams, false, $tPassword);
                }
            }
        }
    }

    function FSxCINMRabbitMQDeclareQName($paParams)
    {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;

        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oChannel->close();
        $oConnection->close();
        return 1;
        /** Success */
    }


    function FSxCINMRabbitMQDeleteQName($paParams)
    {

        $tPrefixQueueName = $paParams['prefixQueueName'];
        $tQueueName = $tPrefixQueueName;
        // $oConnection = new AMQPStreamConnection('172.16.30.28', '5672', 'admin', '1234', 'Pandora_PPT1');
        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_delete($tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1;
        /** Success */
    }


    function FCNxCallRabbitMQMaster($paParams, $pbStaUse = true, $ptPasswordMQ)
    {

        $tLangEdit  = $this->session->userdata("tLangEdit");
        $aVal       = $this->mInterfaceImport->FSaMINMGetDataConfig($tLangEdit);
        $tHost      = $aVal[1]['FTCfgStaUsrValue'];
        $tPort      = $aVal[2]['FTCfgStaUsrValue'];
        $tPassword  = $aVal[3]['FTCfgStaUsrValue'];
        // $tQueueName = $aVal[4]['FTCfgStaUsrValue'];
        $tUser      = $aVal[5]['FTCfgStaUsrValue'];
        $tVHost     = $aVal[6]['FTCfgStaUsrValue'];

        // if($tQueueName==''){
            $tQueueName = $paParams['queueName'];
        // }
        $aParams    = $paParams['params'];
        if ($pbStaUse == true) {
            $aParams['ptConnStr']   = DB_CONNECT;
        }
        $tExchange              = EXCHANGE; // This use default exchange

        $oConnection = new AMQPStreamConnection($tHost, $tPort, $tUser, $ptPasswordMQ, $tVHost);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);

        $oChannel->close();
        $oConnection->close();

        return 1;
        /** Success */
    }



}
