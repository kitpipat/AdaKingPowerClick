<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cAdaSoftContact extends MX_Controller
{


    public function __construct()
    {
        parent::__construct();
       
    }

    public function index()
    {

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');

        $this->load->view('register/Contact/wAdaSoftContactMain');
    }


    //Functionality : Get Page Form And Request Api Customer
    //Parameters : FTRGCstKey Customer Key
    //Creator : 11/01/2021 Nale
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvADCGetPageForm(){

        $tLangEdit = $this->session->userdata("tLangEdit");
        $tUserCode = $this->session->userdata('tSesUserCode');
      

        $this->load->view('register/Contact/wAdaSoftContactPageForm');

    }


}
