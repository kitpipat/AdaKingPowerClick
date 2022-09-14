<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cUnsendEmail extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('register/information/mInformationRegister');
    }

    public function index($tEmail)
    {

        // replace จาก %7C ให้เป็น / เนื่องจาก URL ส่ง Paremeter String ที่มี / ไม่่ได้
        $tEmailreplace =  str_replace("%7C", "/", $tEmail);

        $aDataEmail = array(
            'tEmail' => $tEmailreplace
        );

        $this->load->view('register/UnsendEmail/wUnsendEmailShow', $aDataEmail);
    }
    public function FSvUEMSubmitUnsendEmail()
    {

        $tCstEmail = $this->input->post('tCstEmail');

        $tUrlObject = $this->mInformationRegister->FSaMIMGetObjectUrl('REG', 1);

        $aAPIConfig = $this->mInformationRegister->FSaMIMGetConfigApi();

        $tCstKey = $this->session->userdata('tSesCstKey');

        //   License/Unsubscribe?ptEmail=abc@ada-soft.com

        $aPaRam = array(
            'CstKey' => $tCstKey,
            'Lang' => 1
        );

        if ($aAPIConfig['rtCode'] == '01') {
            $aApiKey = array(
                'tKey' => $aAPIConfig['oResult']['FTSysStaUsrRef'],
                'tValue' => $aAPIConfig['oResult']['FTSysStaUsrValue'],
            );
        } else {
            $aApiKey = array();
        }

        //http://202.44.55.94/AdaPos5StoreBackReg_Dev/API2CNAda/License/Unsubscribe?ptEmail=ponwarut.p@gmail.com   
        $tUrlAPIUnsubmail =    $tUrlObject . '/License/Unsubscribe?ptEmail=' . trim($tCstEmail) . '';


        $oReusltUnsub = FCNaHCallAPIBasic($tUrlAPIUnsubmail, 'GET', $aPaRam, $aApiKey);


        echo  json_encode($oReusltUnsub);
    }
}
