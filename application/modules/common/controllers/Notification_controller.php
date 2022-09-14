<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Notification_controller extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper('url');
        $this->load->library ( "session" );

        $bStaWindowsLogin = ( $this->input->get('oParams') != '' ? true : false );
        if( !$bStaWindowsLogin ){
            if(@$_SESSION['tSesUsername'] == false) {
                redirect ( 'login', 'refresh' );
                exit ();
            }
        }

        $this->load->model('common/mNotification');
    }

    public function index(){
        // $aDataNotification['1'] = array(
        //     'FTNotID'       => '1',
        //     'FTNotCode' => '00002',
        //     'FTNotTypeName' => 'ใบสั่งสินค้าจากสาขา',
        //     'FNNotUrlType'  => 1,
        //     'FTNotUrlRef'   => 'docPrs/2/0',
        //     'FTAgnCode'     => '',
        //     'FTNotBchRef'     => '00003',
        //     'FTNotDocRef'   => 'PRS0000321000001',
        //     'FDNotDate'     => date('d/m/Y H:i'),
        //     'FTNotDesc1'    => 'เอกสารใบขอซื้อ #PRS0000321000001',
        //     'FTNotDesc2'    => 'สาขารหัส 00003 ทำการอนุัมติเอกสาร',
        //     'aBchCodeFrm'   => array('00001'),
        //     'aBchCodeTo'   => array('00002','00003'),
        //     'FTStaRead'     => '2',
        //     'oNotiAction'  => array(
        //                         0 => array(
        //                             'FDNoaDateInsert' => date('d/m/Y H:i'),
        //                             'FTNoaDesc' => 'สาขาบันทึกเอกสาร',
        //                             'FNNoaUrlType' => '',
        //                             'FTNoaUrlRef' => '',
        //                         ),
        //                         1 => array(
        //                             'FDNoaDateInsert' => date('d/m/Y H:i'),
        //                             'FTNoaDesc' => 'สาขาอนุัมติเอกสาร',
        //                             'FNNoaUrlType' => '',
        //                             'FTNoaUrlRef' => '',
        //                         ),
        //                         2 => array(
        //                             'FDNoaDateInsert' => date('d/m/Y H:i'),
        //                             'FTNoaDesc' => 'HQ อนุัมติเอกสาร',
        //                             'FNNoaUrlType' => '',
        //                             'FTNoaUrlRef' => '',
        //                         )
        //     )
        // );
   

        $aGetNotCode =  $this->mNotification->FSoMNTFGetUsrNotCode();
        $aGetLastNoti =  $this->mNotification->FSoMNTFGetUsrLastNoti();
        if($aGetNotCode['rtCode']=='1'){
                foreach($aGetNotCode['raItems'] as $aData){
                        $aNotCode[] = $aData['FTRptCode'];
                }
        }else{
                        $aNotCode = array();
        }

        if($aGetLastNoti['rtCode']=='1'){
                $dNotLast = $aGetLastNoti['raItems']['FDUsrLastNoti'];
        }else{
                $dNotLast = '';
        }

        $aMQParamsNoti = [
            "queueName" => "CN_ReqToNoti",
            "tVhostType" => "NOT",
            "params"    => [
                "ptUsrCode" => $this->session->userdata('tSesUserCode'),
                "ptAgnCode" => $this->session->userdata('tSesUsrAgnCode'),
                "ptBchCode" => $this->session->userdata('tSesUsrBchCodeMulti'),
                "ptPosCode" => '',
                "paNotCode" => $aNotCode,
                "pdUsrLastNoti" => $dNotLast,
                "pnLngID" => $this->session->userdata("tLangEdit"),
                "ptUser"    => $this->session->userdata('tSesUsername'),
                ]
         ];
        // echo '<pre>';
        // print_r($aMQParamsNoti);
        // echo '</pre>';
        // die();
        FCNxCallRabbitMQ($aMQParamsNoti);
        $this->mNotification->FSoMNTFUpdateLastDate();

        
    }


      public function FSxNFTSubMassage(){

        
        $aParamQ['tQname']  = 'CN_GetToNoti_'.$this->session->userdata('tSesUserCode');
        $aParamQ['tVhostType']  = 'NOT';

        $tTaxJsonString = 'false';
        while($tTaxJsonString=='false') {
            $tTaxJsonString     = FCNxRabbitMQGetLastQueueMassage($aParamQ);
            $oNotifocation = '';
            $aDataNotiDoc=array();
            $aDataNotiNews=array();
            if(!empty($tTaxJsonString)){
                   $oNotifocation = json_decode($tTaxJsonString, true);
                   foreach($oNotifocation['oReqNoti'] as $nKey => $aData){
                        if($aData['FTNotCode']=='00000'){
                            $aDataNotiNews[]=$aData;
                        }else{
                            $aDataNotiDoc[]=$aData;
                        }
                   }
                   $this->session->set_userdata("aDataNotiDoc",$aDataNotiDoc);
                   $this->session->set_userdata("aDataNotiNews",$aDataNotiNews);
                   FCNxHNotiNumRows();
            }
            echo $tTaxJsonString;
        }

      }

    public function FSxNFTGetData(){

        $aDataNotiDoc = $this->session->userdata("aDataNotiDoc");
        $aDataNotiDoc4Read = $this->session->userdata("aDataNotiDoc4Read");
        $aParamData = array(
            'aDataNotification' => $aDataNotiDoc,
            'nNotiType' => 1,
        );
        $tHTMLNotiDoc = $this->load->view('common/notification/wNotification.php',$aParamData, true);
        $nSizeOffNotiDoc = FCNnHSizeOf($aDataNotiDoc4Read);


        $aDataNotiNews = $this->session->userdata("aDataNotiNews");
        $aDataNotiNews4Read = $this->session->userdata("aDataNotiNews4Read");
        $aParamData = array(
            'aDataNotification' => $aDataNotiNews,
            'nNotiType' => 2,
        );
        $tHTMLNotiNews = $this->load->view('common/notification/wNotification.php',$aParamData, true);
        $nSizeOffNotiNews = FCNnHSizeOf($aDataNotiNews4Read);
        
        $aDataEndcode = array(
            'tHTMLNotiDoc' => $tHTMLNotiDoc,
            'nSizeOffNotiDoc' => $nSizeOffNotiDoc,
            'tHTMLNotiNews' => $tHTMLNotiNews,
            'nSizeOffNotiNews' => $nSizeOffNotiNews,
        );

        echo json_encode($aDataEndcode);
    }
     


    public function FSxNFTReadData(){

       $tNTFNotID = $this->input->post('tNTFNotID');
       $pnNotiType = $this->input->post('pnNotiType');
       if($pnNotiType==1){
            $aDataNotiDoc = $this->session->userdata("aDataNotiDoc");
            $aDataNotiDoc4Read = $this->session->userdata("aDataNotiDoc4Read");
            unset($aDataNotiDoc4Read[$tNTFNotID]);
            foreach($aDataNotiDoc as $nKey => $aData){
                    if($aData['FTNotID']==$tNTFNotID){
                    $aDataNotiDoc[$nKey]['FTStaRead'] = '1';
                    }
                }
            $this->session->set_userdata("aDataNotiDoc",$aDataNotiDoc);
            $this->session->set_userdata("aDataNotiDoc4Read",$aDataNotiDoc4Read);
        }else{
            $aDataNotiNews = $this->session->userdata("aDataNotiNews");
            $aDataNotiNews4Read = $this->session->userdata("aDataNotiNews4Read");
            unset($aDataNotiNews4Read[$tNTFNotID]);
            foreach($aDataNotiNews as $nKey => $aData){
                    if($aData['FTNotID']==$tNTFNotID){
                    $aDataNotiNews[$nKey]['FTStaRead'] = '1';
                    }
                }
            $this->session->set_userdata("aDataNotiNews",$aDataNotiNews);
            $this->session->set_userdata("aDataNotiNews4Read",$aDataNotiNews4Read);
        }

       $aMQParamsNoti = [
        "queueName" => "CN_ReadToNoti",
        "tVhostType" => "NOT",
        "params"    => [
            "oaTCNTNotiRead" => array(
                "FTUsrCode" => $this->session->userdata('tSesUserCode'),
                "FNNotID"   => $tNTFNotID,
                "FDNotRead" => date('Y-m-d H:i:s')
            ),
            "ptUser"    => $this->session->userdata('tSesUsername'),
            ]
        ];
        // echo '<pre>';
        // print_r($aMQParamsNoti);
        // echo '</pre>';
        // die();
        FCNxCallRabbitMQ($aMQParamsNoti);
       
    }
}

