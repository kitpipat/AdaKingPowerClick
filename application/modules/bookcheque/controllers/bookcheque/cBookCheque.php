<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBookCheque extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('bookcheque/bookcheque/mBookCheque');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEventBookCheque']   = FCNaHCheckAlwFunc('BookCheque/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('BookCheque/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        
        $this->load->view('bookcheque/bookcheque/wBookCheque',$aData);
    }

    public function FSxCBCQFormSearchList(){
           $this->load->view('bookcheque/bookcheque/wBookChequeFormSearchList');
    }

    
    //Functionality : Event Add 
    //Parameters : 
    //Creator : 23/3/2020 nonpawich (petch)
    //Last Modified : 09/04/2019 surawat
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBCQAddEvent(){

        $nCheck        = $this->input->post('ocbChqtcheck');
        if($nCheck == ''){ $nCheck = 2; }

        try{
            $aDataMaster = array(
               
                'FTChqCode' => $this->input->post('oetChqCode'),
                'FTChqName' => $this->input->post('oetChqName'),
                'FTBbkCode' => $this->input->post('oetBbkCode'),
                'FTBchCode' => $this->input->post('oetBchCode'),
                'FNChqMin' => $this->input->post('onbChqMin'),
                'FNChqMax' => $this->input->post('onbChqMax'),
                'FTChqStaPrcDoc' => $this->input->post('oetChqStaPrcDoc'),
                'FTChqRmk' => $this->input->post('otaChqRmk'),
                'FTChqStaAct'   => $nCheck,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
            // นำเอา Branch Code มาใช้ในการตรวจสอบCheque ซ้ำด้วย 09/04/2020 surawat
            $bChqIsDup  = $this->mBookCheque->FSoMBCQCheckDuplicate($aDataMaster['FTBchCode'], $aDataMaster['FTChqCode']);
            // end นำเอา Branch Code มาใช้ในการตรวจสอบCheque ซ้ำด้วย 09/04/2020 surawat
            if(!$bChqIsDup){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBookCheque->FSaMBCQAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBookCheque->FSaMBCQAddUpdateLang($aDataMaster);
              
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event 1"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTChqCode'],
                        'tBchCodeReturn'	=> $aDataMaster['FTBchCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }



    //Functionality : Event Edit BookCheque
    //Parameters : 
    //Creator : 23/3/2020 nonpawich (petch)
    //Last Modified : 09/04/2019 surawat
    //Return : Status Add Event
    //Return Type : String
    public function FSaCBCQEditEvent(){

        $nCheck        = $this->input->post('ocbChqtcheck');
        if($nCheck == ''){ $nCheck = 2; }

        try{
            $aDataMaster = array(
                'tOldBchCode' => $this->input->post('ohdOldBchCode'), // Branch code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat
                'tOldChqCode' => $this->input->post('ohdOldChqCode'), // Cheque code เดิมที่กำลังจะแก้ไข ไว้อ้างอิงในคำสั่ง sql. 08/04/2020 surawat
                'FTChqCode' => $this->input->post('oetChqCode'),
                'FTChqName' => $this->input->post('oetChqName'),
                'FTBbkCode' => $this->input->post('oetBbkCode'),
                'FTBchCode' => $this->input->post('oetBchCode'),
                'FNChqMin' => $this->input->post('onbChqMin'),
                'FNChqMax' => $this->input->post('onbChqMax'),
                'FTChqStaPrcDoc' => $this->input->post('oetChqStaPrcDoc'),
                'FTChqRmk' => $this->input->post('otaChqRmk'),
                'FTChqStaAct'   => $nCheck,
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FNLngID'               => $this->session->userdata("tLangEdit")
            );
            // ดูว่า Branch code, Cheque code เหมือนเดิมไหม ถ้าใช่ถือเป็นการแก้ไข cheque เดิม จึงไม่ต้องเช็คว่า duplicate หรือไม่
            // แต่ถ้าแก้เลข Branch code หรือ Cheque code เปลี่ยนต้องมานั่งเช็คว่ามันไปซ้ำกับ cheque เก่าๆไหม 09/04/2020 surawat
            $bChqIsDup = false;
            if( $aDataMaster['tOldBchCode'] != $aDataMaster['FTBchCode'] ||
                $aDataMaster['tOldChqCode'] != $aDataMaster['FTChqCode'] ){
                $bChqIsDup  = $this->mBookCheque->FSoMBCQCheckDuplicate($aDataMaster['FTBchCode'], $aDataMaster['FTChqCode']);
            }
            // end ดูว่า Branch code, Cheque code เหมือนเดิมไหม 09/04/2020 surawat
            if(!$bChqIsDup){
                $this->db->trans_begin();
                $aStaEventMaster  = $this->mBookCheque->FSaMBCQAddUpdateMaster($aDataMaster);
                $aStaEventLang    = $this->mBookCheque->FSaMBCQAddUpdateLang($aDataMaster);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTChqCode'],
                        'tBchCodeReturn'	=> $aDataMaster['FTBchCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }


    //Functionality : Event Delete BookCheque
    //Parameters : 
    //Creator : 23/3/2020 nonpawich (petch)
    //Last Modified : 09/04/2020 surawat 
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCBCQDeleteEvent(){
        $aDataMaster = [];
        //กรณีกดติ๊กเลือกรายการเชคและทำการเลือกเมนูลบทั้งหมด 
        //รายการที่จะลบจะถูกเก็บใน aChqDataToDelete เป็น array ของ ข้อมูลเชคซึ่งประกอบด้วย
        // tIDCode = รหัสเชค
        // tฺBchCode = รหัสสาขา 
        if($aChqDataToDelete = $this->input->post('aChqDataToDelete')){
            foreach($aChqDataToDelete as $aChqRow){
                $aDataMaster[] =    array(
                                        'FTChqCode' => $aChqRow['tIDCode'],
                                        'FTBchCode' => $aChqRow['tBchCode']
                                    );
            }
        } else {
            //กรณีกดที่ปุ่มถึงขยะท้ายรายการเชคเป็นการลบรายการเดียว จะมีการส่งรหัสเชคและรหัสสาขามาผ่านตัวแปร tIDCode, tBchCode โดย
            // tIDCode = รหัสเชค
            // tฺBchCode = รหัสสาขา
            $tIDCode = $this->input->post('tIDCode');
            $tBchCode = $this->input->post('tBchCode');
            $aDataMaster[] = array(
                                        'FTChqCode' => $tIDCode,
                                        'FTBchCode' => $tBchCode
                                    );
        }
        
        $aResDel        = $this->mBookCheque->FSnMBCQDel($aDataMaster);

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    public function FSvCBCQEditPage(){

		$aAlwEventBookCheque	= FCNaHCheckAlwFunc('BookCheque/0/0'); //Controle Event

        $tChqCode       = $this->input->post('tChqCode');
        $tBchCode       = $this->input->post('tBchCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
     
        $aData  = array(
            'FTChqCode' => $tChqCode,
            'FTBchCode' => $tBchCode,
            'FNLngID'   => $nLangEdit
        );

        $aDstData       = $this->mBookCheque->FSaMBCQSearchByID($aData);
        $aDataEdit      = array('aResult'       => $aDstData,
                                'aAlwEventBookCheque' => $aAlwEventBookCheque
                            );
        $this->load->view('bookcheque/bookcheque/wBookChequeAdd',$aDataEdit);

    }


       // Functionality : โหลด View Lsit 
    // Parameters : 
    // Creator :  23/3/2020 nonpawich (petch)
    // Last Modified : -
    // Return : view
    // Return Type : view
    public function FSvCBCQList(){

 
        $aAlwEventBookCheque	= FCNaHCheckAlwFunc('BookCheque/0/0');
        $aNewData  			= array( 'aAlwEventBookCheque' => $aAlwEventBookCheque);
        $this->load->view('bookCheque/bookCheque/wBookChequelist',$aNewData);
    
    }



     //Functionality : Function Call DataTables 
    //Parameters : 
    //Creator : nonpawich
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCBCQGetDataTable(){

        $aAlwEventBookCheque = FCNaHCheckAlwFunc('BookCheque/0/0'); //Controle Event
        $nPage = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
           
            
        );
        
        
        $aDataList   = $this->mBookCheque->FSaMBCQList($aData);
        // print_r( $aDataList);
        // exit;
        $aGenTable  = array(

            'aAlwEventBookCheque' => $aAlwEventBookCheque,
           
            'aDataList' => $aDataList,
            'nPage'     => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        $this->load->view('bookcheque/bookcheque/wBookChequedatatable',$aGenTable);
    }


      

   
    public function FSvCBCQAddPage(){

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave = FCNaHGetAllLangByTable('TFNMBookCheque_L');

        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );

        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99')
        );

        $this->load->view('bookcheque/bookcheque/wBookChequeAdd',$aDataAdd);
    }
}    
?>

