<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSaleMachineDevice extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/salemachinedevice/mSaleMachineDevice');
    }

    public function index($nPhwBrowseType,$tPhwBrowseOption){
        $tPosCode   = $this->input->get('tPosCode'); // รับรหัส Pos Code
        $tPosbch   = $this->input->get('trtBchCode');
        $nMsgResp   = array('title'=>"SaleMachineDevice");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('salemachine/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('pos/salemachine/salemachinedevice/wSaleMachineDevice', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'tPosCode'          => $tPosCode,
            'tPosbch'          => $tPosbch,
            'nPhwBrowseType'    => $nPhwBrowseType,
            'tPhwBrowseOption'  => $tPhwBrowseOption
        ));
    }

    //Functionality : Function Call SaleMachine Device Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 05/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCPHWListPage(){
        $this->load->view('pos/salemachine/salemachinedevice/wSaleMachineDeviceList');
    }

    //Functionality : Function Call DataTables SaleMachine Device
    //Parameters : Ajax Call View DataTable
    //Creator : 05/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCPHWDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nPosCode       = $this->input->post('nPosCode');
            $tBchCode       = $this->input->post('tBchCode');

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'tSearchAll'    => $tSearchAll,
                'nPosCode'      => $nPosCode,
                'tBchCode'      => $tBchCode
            );
            $aPhwDataList   = $this->mSaleMachineDevice->FSaMPHWList($aData);
            $aGenTable  = array(
                'aPhwDataList'  => $aPhwDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('pos/salemachine/salemachinedevice/wSaleMachineDeviceDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SaleMachine Add
    //Parameters : Ajax Call View Add
    //Creator : 05/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCPHWAddPage(){
        try{
            $tPosCode           = $this->input->post('tPosCode');
            $tBchCode           = $this->input->post('tBchCode');
            //$tBchCode           = $this->mSaleMachineDevice->FSaMGetBch($tPosCode); // รหัสจุดขาย
            $aSysPosHw          = $this->mSaleMachineDevice->FSaMGetSysPosHW();
            $aSysPrinter        = $this->mSaleMachineDevice->FSaMGetSysPrinter();

            $aDataSaleMachineDevice = array(
                'aDataSysPosHw'     => $aSysPosHw,
                'aDataSysPrinter'   => $aSysPrinter,
                'tPosCode'          => $tPosCode,
                'tBchCode'          => $tBchCode,
                'nStaAddOrEdit'     => 99
            );
            // echo "<pre>";
            // print_r( $aDataSaleMachineDevice);
            // exit;
            $this->load->view('pos/salemachine/salemachinedevice/wSaleMachineDeviceAdd',$aDataSaleMachineDevice);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage SaleMachine Edits
    //Parameters : Ajax Call View Add
    //Creator : 05/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCPHWEditPage(){
        try{
            $tBchCode   = $this->input->post('ptBchCode');
            $tPosCode   = $this->input->post('tPosCode'); // รหัสจุดขาย
            $tPhwCode   = $this->input->post('tPhwCode');

            $aData  = array(
                'FTPosCode' => $tPosCode,
                'tPhwCode'  => $tPhwCode,
                'FTBchCode' => $tBchCode
            );
            //$tBchCode           = $this->mSaleMachineDevice->FSaMGetBch($tPosCode); // รหัสจุดขาย
            $aPhwData       = $this->mSaleMachineDevice->FSaMPHWGetDataByID($aData);
            // echo "<pre>"; print_r($aPhwData); echo "</pre>"; exit;
            $aDataSaleMachineDevice   = array(
                'nStaAddOrEdit' => 1,
                'tPosCode'      => $tPosCode,
                'aPhwData'      => $aPhwData,
                // 'tBchCode'      => $tBchCode
            );
            $this->load->view('pos/salemachine/salemachinedevice/wSaleMachineDeviceAdd',$aDataSaleMachineDevice);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add SaleMachine Device
    //Parameters : Ajax Event
    //Creator : 05/11/2018 Witsarut
    //Update : 19/02/2020 nonpawich
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPHWAddEvent(){
        $tPhwCode   = $this->input->post('oetPhwCode');
        $tPosbch   = $this->input->post("ohdSMDBchCode");
        $tPosCode   = $this->input->post('ohdPosCode');
        $tShwCode   = $this->input->post('oetShwCode');
        $tIsAutoGenCode = $this->input->post('ocbPhwAutoGenCode');

        if($tIsAutoGenCode == '1'){ // Check Auto Gen Reason Code?
            // Auto Gen Reason Code
            // $aGenCode = FCNaHGenCodeV5('TCNMPosHW','0',$tPosbch);
            // if($aGenCode['rtCode'] == '1'){
            //     $tPhwCode = $aGenCode['rtPhwCode'];
            // }

            // Update new gencode
            // 15/05/2020 Napat(Jame)
            $aStoreParam = array(
                "tTblName"    => 'TCNMPosHW',
                "tDocType"    => 0,
                "tBchCode"    => $tPosbch,
                "tShpCode"    => "",
                "tPosCode"    => "",
                "dDocDate"    => date("Y-m-d")
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $tPhwCode   = $aAutogen[0]["FTXxhDocNo"];
        }
        $nTypePrinter = $this->input->post('ocmShwPrinter');
        // if($nTypePrinter == 2 || $nTypePrinter == 3 || $nTypePrinter == 5){
        //     //จอแสดงภาพราคา + ลิ้นชัก + เเถบเเม่เหล็ก
        //     $tFTPhwCodeRef  = '-';
        //     $tFTPhwConnType = $this->input->post('ocmShwPrinter');
        //     $tFTPhwConnRef  = '-';
        //     $tFTPhwCustom   = '-';

        // }else{
            if($nTypePrinter == 6){ //RFID
                $tFTPhwConnType = $this->input->post('ocmPhwConnType');
                $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
                $tFTPhwConnRef  = '-';
                $tFTPhwCustom   = $this->input->post('oetBaudRate');

            }else{ //เครื่องพิมพ์ + บัตรเครดิต
                $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
                //$tFTPhwConnType = $this->input->post('ocmShwPrinter');
                $tFTPhwConnType = $this->input->post('ocmPhwConnType');


                //1:Printer 2:Com Port 3: TCP 4: BT
                //FTPhwConnRef
                if($tFTPhwConnType == '2' || $tFTPhwConnType == 2){
                    $tFTPhwConnRef  = $this->input->post('ocmComport');
                }else if($tFTPhwConnType == '3' || $tFTPhwConnType == 3){
                    $tFTPhwConnRef  = $this->input->post('oetPhwConRef');
                }else if($tFTPhwConnType == '4' || $tFTPhwConnType == 4){
                    $tFTPhwConnRef  = $this->input->post('oetBluetooth');
                }else if($this->input->post('ocmShwPrinter') == '9' || $this->input->post('ocmShwPrinter') == 9){
                    $tFTPhwConnType ='9';
                    $tFTPhwConnRef  = '-';
                    $tFTPhwCodeRef  = $this->input->post('oetCodePos');
                }else{
                    $tFTPhwConnRef  = '-';
                }
                if($nTypePrinter == 1 || $nTypePrinter == 9){ //เครื่องพิมพ์ หรือ VD
                    $tFTPhwCustom = $this->input->post('oetHiddenPrnType');
                }else{
                    $tFTPhwCustom = '-';
                }
            }

        // }
        $nLastSeq   = $this->mSaleMachineDevice->FSaMLastSeqByShwCode($tPosCode);
        $nLastSeq   = $nLastSeq+1;
        $aDataSaleMachineDevice   = array(
                'FTPhwCode'        => $tPhwCode,
                'FTPosCode'        => $tPosCode,
                'FTBchCode'        => $tPosbch,
                'FNPhwSeq'         => $nLastSeq,
                'FTPhwName'        => $this->input->post('oetPhwName'),
                'FTShwCode'        => '00'.$this->input->post('ocmShwPrinter'),
                'FTPhwConnType'    => $tFTPhwConnType,
                'FTPhwCodeRef'     => $tFTPhwCodeRef,
                'FTPhwConnRef'     => $tFTPhwConnRef,
                'FTPhwCustom'      => $tFTPhwCustom,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
        );
        // print_r($aDataSaleMachineDevice);
        // exit();
       $nDupPli =  $this->mSaleMachineDevice->FSnMPHWCheckDuplicate($aDataSaleMachineDevice['FTPhwCode'],$aDataSaleMachineDevice['FTPosCode'],$aDataSaleMachineDevice['FTBchCode']);
    if($nDupPli==0){
        $this->db->trans_begin();
        $this->mSaleMachineDevice->FSaMPHWAddUpdateMaster($aDataSaleMachineDevice);
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add SaleMachine Device Group"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aDataSaleMachineDevice['FTPhwCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add SaleMachine Device Group',
                'tPosCode'      => $tPosCode
            );
        }
    }else{
        $aReturn = array(
            'nStaEvent'    => '900',
            'tStaMessg'    => "Unsucess Add Data Duplicate"
        );
    }
        echo json_encode($aReturn);

    }


    //Functionality : Event Edit SaleMachine Device
    //Parameters : Ajax Event
    //Creator : 05/11/2018 Witsarut
   //Update : 19/02/2020 nonpawich
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPHWEditEvent(){


        $tPhwCode   = $this->input->post('oetPhwCode');
        $tPosbch   = $this->input->post("ohdSMDBchCode");
        $tPosCode   = $this->input->post('ohdPosCode');
        $tShwCode   = $this->input->post('oetShwCode');
        $tIsAutoGenCode = $this->input->post('ocbPhwAutoGenCode');
        $nTypePrinter = $this->input->post('ocmShwPrinter');


        // if($tFTPhwConnType == 1){

        // }

            if($nTypePrinter == 6){ //RFID
                $tFTPhwConnType = $this->input->post('ocmShwPrinter');
                $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
                $tFTPhwConnRef  = '-';
                $tFTPhwCustom   = $this->input->post('oetBaudRate');
            }else{ //เครื่องพิมพ์ + บัตรเครดิต
                $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
                // $tFTPhwConnType = $this->input->post('ocmShwPrinter');
                $tFTPhwConnType = $this->input->post('ocmPhwConnType');

                //1:Printer 2:Com Port 3: TCP 4: BT
                //FTPhwConnRef

                if($tFTPhwConnType == '2' || $tFTPhwConnType == 2){
                    $tFTPhwConnRef  = $this->input->post('ocmComport');
                }else if($tFTPhwConnType == '3' || $tFTPhwConnType == 3){
                    $tFTPhwConnRef  = $this->input->post('oetPhwConRef');
                }else if($tFTPhwConnType == '4' || $tFTPhwConnType == 4){
                    $tFTPhwConnRef  = $this->input->post('oetBluetooth');
                }else if($this->input->post('ocmShwPrinter') == '9' || $this->input->post('ocmShwPrinter') == 9){
                    $tFTPhwConnType ='9';
                    $tFTPhwConnRef  = '-';
                    $tFTPhwCodeRef  = $this->input->post('oetCodePos');
                }else{
                    $tFTPhwConnRef  = '-';
                }

                if($nTypePrinter == 1 || $nTypePrinter == 9){ //เครื่องพิมพ์ หรือ VD
                    $tFTPhwCustom = $this->input->post('oetHiddenPrnType');
                }else{
                    $tFTPhwCustom = '-';
                }
            }


        $aDataSaleMachineDevice   = array(
                'FTPhwCode'        => $tPhwCode,
                'FTPosCode'        => $tPosCode,
                'FTBchCode'        => $tPosbch,
                // 'FNPhwSeq'         => $this->input->post('ocmPhwConnType'),
                'FTPhwName'        => $this->input->post('oetPhwName'),
                'FTShwCode'        => '00'.$this->input->post('ocmShwPrinter'),
                'FTPhwConnType'    => $tFTPhwConnType  ,
                'FTPhwCodeRef'     => $tFTPhwCodeRef,
                'FTPhwConnRef'     => $tFTPhwConnRef,
                'FTPhwCustom'      => $tFTPhwCustom,
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
        );

        // print_r($aDataSaleMachineDevice);
        // exit;
        $this->db->trans_begin();
        $this->mSaleMachineDevice->FSaMPHWAddUpdateMaster($aDataSaleMachineDevice);
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add SaleMachine Device Group"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aDataSaleMachineDevice['FTPhwCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add SaleMachine Device Group',
                'tPosCode'      => $tPosCode
            );
        }
        echo json_encode($aReturn);
        // try{
        //     $tPhwCode   = $this->input->post('oetPhwCode');
        //     $tPosCode   = $this->input->post('oetPosCode');
        //     $tShwCode   = $this->input->post('oetShwCode');
        //     $aLastSeq   = $this->mSaleMachineDevice->FSaMLastSeqByShwCode($tPhwCode,$tPosCode,$tShwCode);
        //     $nLastSeq   = $aLastSeq['rtPhwSeq']+1;

        //     $this->db->trans_begin();

        //     $nTypePrinter = $this->input->post('ocmShwPrinter');
        //     if($nTypePrinter == 2 || $nTypePrinter == 3 || $nTypePrinter == 5){
        //         //จอแสดงภาพราคา + ลิ้นชัก + เเถบเเม่เหล็ก
        //         $tFTPhwCodeRef  = '-';
        //         $tFTPhwConnType = '-';
        //         $tFTPhwConnRef  = '-';
        //         $tFTPhwCustom   = '-';
        //     }else{

        //         if($nTypePrinter == 6){ //RFID
        //             $tFTPhwConnType = '-';
        //             $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
        //             $tFTPhwConnRef  = '-';
        //             $tFTPhwCustom   = $this->input->post('oetBaudRate');
        //         }else{ //เครื่องพิมพ์ + บัตรเครดิต
        //             $tFTPhwCodeRef  = $this->input->post('oetCodePrinter');
        //             $tFTPhwConnType = $this->input->post('ocmPhwConnType');

        //             //1:Printer 2:Com Port 3: TCP 4: BT
        //             //FTPhwConnRef
        //             if($tFTPhwConnType == '2' || $tFTPhwConnType == 2){
        //                 $tFTPhwConnRef  = $this->input->post('ocmComport');
        //             }else if($tFTPhwConnType == '3' || $tFTPhwConnType == 3){
        //                 $tFTPhwConnRef  = $this->input->post('oetPhwConRef');
        //             }else if($tFTPhwConnType == '4' || $tFTPhwConnType == 4){
        //                 $tFTPhwConnRef  = $this->input->post('oetBluetooth');
        //             }else{
        //                 $tFTPhwConnRef  = '-';
        //             }

        //             if($nTypePrinter == 1){ //เครื่องพิมพ์
        //                 $tFTPhwCustom = $this->input->post('oetHiddenPrnType');
        //             }else{
        //                 $tFTPhwCustom = '-';
        //             }
        //         }
        //     }

        //     $aDataSaleMachineDevice   = array(
        //         'FNPhwSeq'        => $nLastSeq,
        //         'FTPhwCode'       => $this->input->post('oetPhwCode'),
        //         'FTPosCode'       => $this->input->post('oetPosCode'),
        //         'FTPhwName'        => $this->input->post('oetPhwName'),
        //         'FTShwCode'        => '00'.$this->input->post('ocmShwPrinter'),
        //         'FTPhwCodeRef'     => $tFTPhwCodeRef,
        //         'FTPhwConnType'    => $tFTPhwConnType,
        //         'FTPhwConnRef'     => $tFTPhwConnRef,
        //         'FTPhwCustom'      => $tFTPhwCustom
        //     );

        //     $aStaPhwMaster  = $this->mSaleMachineDevice->FSaMPHWAddUpdateMaster($aDataSaleMachineDevice);
        //     $aStaPhwLang    = $this->mSaleMachineDevice->FSaMPHWAddUpdateLang($aDataSaleMachineDevice);
        //     if($this->db->trans_status() === false){
        //         $this->db->trans_rollback();
        //         $aReturn = array(
        //             'nStaEvent'    => '900',
        //             'tStaMessg'    => "Unsucess Edit SaleMachine Device"
        //         );
        //     }else{
        //         $this->db->trans_commit();
        //         $aReturn = array(
        //             'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
        //             'tCodeReturn'	=> $aDataSaleMachineDevice['FTPhwCode'],
        //             'nStaEvent'	    => '1',
        //             'tStaMessg'		=> 'Success Edit SaleMachine Device'
        //         );
        //     }
        //     echo json_encode($aReturn);
        // }catch(Exception $Error){
        //     echo $Error;
        // }
    }

    //Functionality : Event Delete SaleMachine Device
    //Parameters : Ajax jReason()
    //Creator : 05/11/2018 Witsarut
    //Update : 03/04/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPHWDeleteEvent(){
        $tBchCode   = $this->input->post('ptBchCode');
        $tIDCode    = $this->input->post('tIDCode');
        $tPosCode   = $this->input->post('tPosCode');
        $aDataMaster = array(
            'FTPhwCode' => $tIDCode,
            'FTPosCode' => $tPosCode,
            'FTBchCode' => $tBchCode
        );

        $aResDel    = $this->mSaleMachineDevice->FSaMPHWDelAll($aDataMaster);
        $nNumRowPhw = $this->mSaleMachineDevice->FSnMPHWGetAllNumRow($tPosCode);
        if($nNumRowPhw!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPhw' => $nNumRowPhw
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    //Functionality : -
    //Parameters : Ajax jSaleMachineDevice()
    //Creator : 26/09/2019 Saharat(Golf)
    //Update : -
    //Return :
    //Return :
    public function FSoCPHWCheckInputGenCode(){
        $aDataGenCode    = array(
            'tPosCode'   => $this->input->post('tPosCode'),
            'tPhwCode'   => $this->input->post('tPhwCode')
        );

        $tCheck = $this->mSaleMachineDevice->FSaMCheckInputGenCode($aDataGenCode);
        $nNum = $tCheck[0]->nNum;
        if ($nNum != '0') {
            $nStatus = '1';
            $tDesc = 'มี id นี้แล้วในระบบ';
        } else {
            $nStatus = '2';
            $tDesc = 'รหัสผ่านจะถูก Gen ใหม่';
        }

        $raChkCode = array(
            'rtCode' => $nStatus,
            'rtDesc' => $tDesc,
        );
        print_r(json_encode($raChkCode));
    }









}
