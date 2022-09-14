<?php

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

require_once(APPPATH . 'libraries/async/vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Spatie\Async\Pool;


class Tools extends MX_Controller {

    public function __construct() {

        $this->load->helper('report');
        $this->load->library('zip');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptSaleByPaymentDetail');
        parent::__construct();
    }

    public function mqListener() {

        $aSubQ = array();
        for($i = 0; $i<5;$i++){

            $aSubQ[$i] = new SubscribeMQ($i);
            $aSubQ[$i]->start();
        }
       
    }

    public function reciev($quename){
        $connection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $channel = $connection->channel();
        $channel->queue_declare($quename, false, true, false, false);
        
        echo " [*] Waiting for messages. To exit press CTRL+C\n\n\n";

        $callback = function ($msg) {
            echo ' [/] Received ', $msg->body, "\n";
            sleep(substr_count($msg->body, '.'));
            echo " [/] Done\n";
            
            if($msg->body == 'ok'){
                $paParams = [
                    'tBody' => $msg->body
                ];
                
                $this->precess($paParams);
                
                echo "=========== END ============", "\r\n";
    }
        };

        $channel->basic_qos(null, 1, null);
        $channel->basic_consume($quename, '', false, true, false, false, $callback);

        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
    
    public function precess($paParams = []){
        echo " [/] Process";
        for($i=0; $i<10; $i++){
            sleep(1);
            echo ".";
        }
        echo "\n";
        $this->zip('newfile');
    }
    
    public function mqPublish($paParams = []) {
        $tQueueName = 'RPTB_'; // $paParams['queueName'];
        $aParams = '{"rptCode":"021215", "progress": 30}'; // $paParams['params'];

        $oConnection = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, false, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);
        $oChannel->close();
        $oConnection->close();
        
        echo ' [/] Send Progress.' , "\n";
    }
    
    public function zip($ptName) {
        $name1 = 'mydata11.txt';
        $data1 = 'A Data String!';

        $name2 = 'mydata12.txt';
        $data2 = 'A Data String!';

        $this->zip->add_data($name1, $data1);
        $this->zip->add_data($name2, $data2);

        // Write the zip file to a folder on your server. Name it "my_backup.zip"
        $this->zip->archive(APPPATH . "cache/$ptName.zip");

        // Download the file to your desktop. Name it "my_backup.zip"
        // $this->zip->download('my_backup.zip');
        echo ' [/] Zip Success.' , "\n";
    }

}


class SubscribeMQ extends Thread {

    private $SubQName;

    function __construct($QName){
          $this->SubQName = $QName;
    }

    public function run(){
        
        echo "run ".$this->SubQName."\n";
        while(true){
         
           echo '#'.$this->SubQName;
           sleep(1);
        } 
    }
}




