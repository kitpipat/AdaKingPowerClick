<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAudit extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('Audit/Audit/mAudit');
        date_default_timezone_set("Asia/Bangkok");
    }
    public function index()
    {
      $tSearchAll     = $this->input->post('tSearchAll');
      $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
      $nLangResort    = $this->session->userdata("tLangID");
      $nLangEdit      = $this->session->userdata("tLangEdit");

      $aData  = array(
          'nPage'         => $nPage,
          'nRow'          => 10,
          'FNLngID'       => $nLangEdit,
          'tSearchAll'    => $tSearchAll
      );
      $aDataList = $this->mAudit->FSoMAUDGetData($aData);
      $aGenTable  = array(
          'aAudDataList'      => $aDataList,
          'nPage'             => $nPage,
          'tSearchAll'        => $tSearchAll,
      );
      $this->load->view('Audit/wAudit',$aGenTable);
    }

    //Functionality : ดึงข้อมูลการ mat
    //Parameters : function parameters
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : view
    public function FSvADIDataList()
    {
      $tSearchAll     = $this->input->post('tSearchAll');
      $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
      $nLangResort    = $this->session->userdata("tLangID");
      $nLangEdit      = $this->session->userdata("tLangEdit");

      $aData  = array(
          'nPage'         => $nPage,
          'nRow'          => 10,
          'FNLngID'       => $nLangEdit,
          'tSearchAll'    => $tSearchAll
      );
      $aDataList = $this->mAudit->FSoMAUDGetData($aData);
      $aGenTable  = array(
          'aAudDataList'      => $aDataList,
          'nPage'             => $nPage,
          'tSearchAll'        => $tSearchAll,
      );
      $this->load->view('Audit/wAuditDataList',$aGenTable);
    }

    //Functionality : ดึงฟอร์มเพิ่มข้อมูล
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : view
    public function FSvCAUDCallPageAdd()
    {
      if ($this->input->post('tFTAgnTo')=="1") {
        $aDataList['aData'] =array();
      }else{
        $aDataList['aData'] = $this->mAudit->FSaMAUDGetDataEdit($this->input->post('tFTAgnFrm'));
        if ($this->session->userdata('tSesUsrLevel') != "HQ" && !isset($aDataList['aData'][0]['FTAgnTo'])) {
          $aDataList['aData'] = $this->mAudit->FSaMAUDGetDataSteting($this->input->post('tFTAgnFrm'));
        }
      }
      $this->load->view('Audit/wAuditPageAdd',$aDataList);
    }


    //Functionality : ดึงฟอร์มเพิ่มข้อมูลโอนข้อมูล
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : view
    public function FSvADIPageMovedataDoc()
    {
      $aData = $this->mAudit->FSaMAUDGetDataEdit($this->session->userdata('tSesUsrAgnCode'));
      $aData['aDataBranchF'] = $this->mAudit->FSaMAUDGetDataBch($this->session->userdata('tSesUsrAgnCode'),$this->session->userdata("tLangID"));
      if (isset($aData[0]['FTAgnTo'])) {
        $aData['aDataBranchT'] = $this->mAudit->FSaMAUDGetDataBch($aData[0]['FTAgnTo'],$this->session->userdata("tLangID"));
        $aData['tFTAgnFrm'] = $this->session->userdata('tSesUsrAgnCode');
        $aData['tFTAgnTo'] = $aData[0]['FTAgnTo'];
        if ($this->session->userdata('tSesUsrLevel') =='HQ') {
          $this->load->view('Audit/wAuditnewpageNodata',$aData);
        }else {
          $this->load->view('Audit/wAuditnewpage',$aData);
        }
      }else {
        $this->load->view('Audit/wAuditnewpageNodata',$aData);
      }


    }

    public function FSvADIDeleteData()
    {
      $tFTAgnFrm = $this->input->post('tFTAgnFrm');
      $tFTAgnTo = $this->input->post('tFTAgnTo');
      $aDataMaster = array(
        'FTAgnFrm'=> $tFTAgnFrm,
        'FTAgnTo'=> $tFTAgnTo
      );
      $aResDel    = $this->mAudit->FSaMAUDDel($aDataMaster);
      echo json_encode($aResDel);
    }

    //Functionality : ดึงฟอร์มเพิ่มข้อมูลโอนข้อมูล
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : view
    public function FSvADIPageMovedata()
    {
      $aData = $this->mAudit->FSaMAUDGetDataEdit($this->session->userdata('tSesUsrAgnCode'));
      $aDataBch = $this->mAudit->FSaMAUDGetDataBch($this->session->userdata('tSesUsrAgnCode'),$this->session->userdata("tLangID"));
      if (count($aData)>0) {
        $aStatus['tStatus'] = true;
        $aStatus['aData'] = $aData;
        $aStatus['aDataBch'] = $aDataBch;
      }else {
        $aStatus['tStatus'] = false;
      }
      if ($this->session->userdata('tSesUsrLevel')=='HQ') {
        $aStatus['tStatus'] = true;
        $aStatus['aData'] = $aData;
        $aStatus['aDataBch'] =array();
      }
      $this->load->view('Audit/wAuditMoveData',$aStatus);
    }



    //Functionality : เพิ่มข้อมูลการจอย 2 บริษัท
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : array
    public function FSaCAUDAddEvent()
    {
      try{
          $aDataMaster = array(
               'FTAgnFrm' => $this->input->post('tAudCode'),
               'FTAgnTo' => $this->input->post('tAudCodeT'),
               'FTMapTable' => 'TCNMAgency',
               'FTMapCodeFrm' => $this->input->post('tAudCode'),
               'FTMapCodeTo' => $this->input->post('tAudCodeT')
          );
          $this->db->trans_begin();
          $aStaEventMaster  = $this->mAudit->FSaMAUDAddUpdateMaster($aDataMaster);
          if($this->db->trans_status() === false){
              $this->db->trans_rollback();
              $aReturn = array(
                  'nStaEvent'    => '900',
                  'tStaMessg'    => "Unsucess Add Event 1"
              );
          }else{
              $this->db->trans_commit();
              $aReturn = $aStaEventMaster;
          }
          echo json_encode($aReturn);
      }catch(Exception $Error){
          echo $Error;
      }

    }


    //Functionality : ค้าหาบริษัท B
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : array
    public function FSaCAUDSearchComB()
    {
      $aDataList['aData'] = $this->mAudit->FSaMAUDGetDataEdit($this->input->post('tFTAgnTo'));
      echo json_encode($aDataList);
    }


    //Functionality : ค้าหารายการที่จะโอน
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : array
    public function FSaCAUDGetTranferMaster()
    {
      $aDataList['aTranferMaster'] = $this->mAudit->FSoMAUDTranferMaster($this->input->post('tFTAgnTo'));
      echo json_encode($aDataList);
    }

    public function FSaCAUDGetBch()
    {
      $aDataList['aDataBchCode'] = $this->mAudit->FSaMAUDGetDataBch($this->input->post('tAgnCode'),$this->session->userdata("tLangID"));
      echo json_encode($aDataList);
    }

    //Functionality : ค้าหารายการที่จะสร้างเอกสารใหม่
    //Parameters :
    //Creator :  18/03/2021 Mos
    //Return : data
    //Return Type : array
    public function FSaCAUDGetListDoc()
    {
      $aSearchData = array(
        'tDocDateA'=> $this->input->post('tDocDateA'),
        'tDocDateB'=> $this->input->post('tDocDateB'),
        'tAUDDocType'=> $this->input->post('tAUDDocType'),
        'tBchF'=> $this->input->post('tDocBchF'),
        'tLangID'=> $this->session->userdata("tLangID")
      );
      $aDataList['aData'] = $this->mAudit->FSoMAUDGetListDoc($aSearchData);
      echo json_encode($aDataList);
    }

    public function FSaCAUDMoverMaster()
    {
      $aData =$this->input->post('aData');
      $aMQParams = [
          "queueName" => "CN_QAudit",
          "tVhostType" => "A",
          "params" => [
              'ptFunction' => "DOWNLOAD",
              'ptSource' => 'AdaStoreBack',
              'ptDest' =>'MQReceivePrc',
              'ptFilter' => $this->session->userdata('tSesSessionID'),
              'ptData'=>json_encode($aData)
          ]
      ];
      //print_r($aMQParams);
      FCNxCallRabbitMQ($aMQParams);
    }

    public function FSaCAUDGetNewDoc()
    {


       $aPoCondPdt = $this->input->post('paPoCondPdt');
       $aPoCondDoc = $this->input->post('paPoCondDoc');
       $aResultDocIn = $this->input->post('paResultDocIn');
       $aResultDocNotIn = $this->input->post('paResultDocNotIn');

      $aData['poCondPdt'] = $aPoCondPdt;
      $aData['poCondDoc']['pdDateFrom'] = $aPoCondDoc['pdDateFrom'];
      $aData['poCondDoc']['pdDateTo'] = $aPoCondDoc['pdDateTo'];
      $aData['poCondDoc']['ptListDocIn'] = $aResultDocIn;
      $aData['poCondDoc']['ptListDocNotIn'] = $aResultDocNotIn;
      $aData['poCondDoc']['pnLngID'] = $this->session->userdata("tLangID");
      $aData['poCondDoc']['ptAgnCodeFrm'] = $aPoCondDoc['ptAgnCodeFrm'];
      $aData['poCondDoc']['ptAgnCodeTo'] = $aPoCondDoc['ptAgnCodeTo'];
      $aData['poCondDoc']['ptBchCodeFrm'] = $aPoCondDoc['ptBchCodeFrm'];
      $aData['poCondDoc']['ptBchCodeTo'] = $aPoCondDoc['ptBchCodeTo'];

      $aMQParams = [
          "queueName" => "CN_QAudit",
          "tVhostType" => "A",
          "params" => [
              'ptFunction' => "AUDIT",
              'ptSource' => 'AdaStoreBack',
              'ptDest' =>'MQReceivePrc',
              'ptFilter' => $this->session->userdata('tSesSessionID'),
              'ptData'=>json_encode($aData)
          ]
      ];
      FCNxCallRabbitMQ($aMQParams);
    }
}


?>
