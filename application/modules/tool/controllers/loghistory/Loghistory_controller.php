<?php 
defined('BASEPATH') or exit('No direct script access allowed');
class Loghistory_controller extends MX_Controller {
    public function __construct() {
        $this->load->model('tool/loghistory/Loghistory_model');
        parent::__construct();
    }

    public function index(){
        $this->load->view('tool/loghistory/wLogHistory');
    }

    public function FSvCCFSPageList(){
        $this->load->view('tool/loghistory/wLogHistoryList');
    }

    public function FSvCCFSPageDataTable(){
        $aAdvanceSearch = $this->input->post('oAdvanceSearch');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $nDecimal       = FCNxHGetOptionDecimalShow();
        $nPage          = $aAdvanceSearch['nPageCurrent'];
        
        // Data Conditon Get Data Document
        $aSearchData  = array(
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FNLngID'           => $nLangEdit,
            'aAdvanceSearch'    => $aAdvanceSearch
        );
        $aPackData = array(
            'nPage'             => $nPage,
            'aLGHDataList'      => $this->Loghistory_model->FSaMLGHGetDataList($aSearchData)
        );
        $this->load->view('tool/loghistory/wLogHistoryDataTable', $aPackData);
    }

    public function FSaCCFSEventRequestFile(){
        $aMQParams = [
            "queueName"     => "CN_QTask",
            "tVhostType"    => "M",
            "params"        => [
                'ptFunction'    => "UPLOADLOGFILE",
                'ptSource'      => 'AdaTask',
                'ptDest'        => 'AdaPos',
                'ptFilter'      => "",
                'ptData'        => json_encode([
                    "ptAgnCode"     => "",
                    "ptBchCode"     => $this->input->post('oetLGHReqBchCode'),
                    "ptPosCode"     => $this->input->post('oetLGHReqPosCode'),
                    "ptLogType"     => $this->input->post('ocmLGHReqType'),
                    "ptReqDate"     => date('Y-m-d H:i:s'),
                    "ptFileDate"    => $this->input->post('oetLGHReqDateFile')
                ]),
            ]
        ];
        $tMQReturn = FCNxCallRabbitMQ($aMQParams);

        if( $tMQReturn == '1' ){
            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'ส่งข้อมูลการขอไฟล์สำเร็จ'
                // ,'aMQParams' => $aMQParams
            );
        }else{
            $aReturnData = array(
                'nStaEvent' => '800',
                'tStaMessg' => $tMQReturn
                // ,'aMQParams' => $aMQParams
            );
        }
        echo json_encode($aReturnData);
    }
}
?>