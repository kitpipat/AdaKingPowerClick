<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtLocation extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtlocation/mPdtLocation');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nLocBrowseType,$tLocBrowseOption){
        $nMsgResp   = array('title'=>"Product Location");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave                   = FCNaHBtnSaveActiveHTML('pdtlocation/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtLocation	    = FCNaHCheckAlwFunc('pdtlocation/0/0');
        $this->load->view('product/pdtlocation/wPdtLocation', array (
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nLocBrowseType'        => $nLocBrowseType,
            'tLocBrowseOption'      => $tLocBrowseOption,
            'aAlwEventPdtLocation'  => $aAlwEventPdtLocation
        ));
    }

    //Functionality : Function Call Product Location Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 01/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCListPage(){ 
        $aAlwEventPdtLocation	    = FCNaHCheckAlwFunc('pdtlocation/0/0'); 
        $this->load->view('product/pdtlocation/wPdtLocationList', array(
            'aAlwEventPdtLocation'  => $aAlwEventPdtLocation
        ));
    }

    
    //Functionality : Function Call DataTables Product Location
    //Parameters : Ajax Call View DataTable
    //Creator : 01/02/2019 Napat (Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCDataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aLocDataList               = $this->mPdtLocation->FSaMLOCList($aData); 
            $aAlwEventPdtLocation	    = FCNaHCheckAlwFunc('pdtlocation/0/0');
            $aGenTable  = array(
                'aLocDataList'          => $aLocDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtLocation'  => $aAlwEventPdtLocation
            );
            $this->load->view('product/pdtlocation/wPdtLocationDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function Call DataTables Location Seq
    //Parameters : Ajax Call View DataTable
    //Creator : 01/02/2019 Napat (Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCSeqDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $FTPlcCode      = $this->input->post('FTPlcCode');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'FTPlcCode'     => $FTPlcCode
            );

            $aLocDataList   = $this->mPdtLocation->FSaMLOCGetDataLocSeqByID($aData);
            $aGenTable  = array(
                'aLocSeqData'           => $aLocDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'FTPlcCode'             => $FTPlcCode
            );
            $this->load->view('product/pdtlocation/wPdtLocationSeqDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Location Add
    //Parameters : Ajax Call View Add
    //Creator : 01/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCAddPage(){
        try{
            $aDataPdtLocation = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('product/pdtlocation/wPdtLocationAdd',$aDataPdtLocation);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Location Edits
    //Parameters : Ajax Call View Add
    //Creator : 01/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCEditPage(){  
        try{
            $tPlcCode       = $this->input->post('tPlcCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPlcCode' => $tPlcCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aLocData       = $this->mPdtLocation->FSaMLOCGetDataByID($aData);
            $aDataPdtLoc   = array(
                'nStaAddOrEdit' => 1,
                'aLocData'      => $aLocData
            );
            $this->load->view('product/pdtlocation/wPdtLocationAdd',$aDataPdtLoc);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Location Manage
    //Parameters : Ajax Call View Add
    //Creator : 06/02/2019 Napat(Jame)
    //Return : String View
    //Return Type : View
    public function FSvCLOCManagePage(){  
        try{
            $tPlcCode       = $this->input->post('tPlcCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtLoc_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPlcCode' => $tPlcCode,
                'FNLngID'   => $nLangEdit
            );
            
            $aLocData       = $this->mPdtLocation->FSaMLOCGetDataByID($aData);
            $aDataLocSeq  = array(
                'nPage'         => 1,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => "",
                'FTPlcCode'     => $tPlcCode
            );
            $aLocSeqData    = $this->mPdtLocation->FSaMLOCGetDataLocSeqByID($aDataLocSeq);
            if($aLocSeqData['rtCode']=='1' && $aLocSeqData['raItems'][0]['rtLastUpdBy']==""){
                $aLocSeqDel = $this->mPdtLocation->FSaMLOCSeqDeleteDataAllByID($aLocSeqData['raItems'][0]['rtPlcCode']);
            }

            $aDataPdtLoc    = array(
                'nStaAddOrEdit'     => 1,
                'aLocData'          => $aLocData
                // 'aLocSeqData'       => $aLocSeqData
            );
            $this->load->view('product/pdtlocation/wPdtLocationManage',$aDataPdtLoc);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Location
    //Parameters : Ajax Event
    //Creator : 01/02/2019 Napat(Jame)
    //Update : 26/03/2019 pap
    //Return : Status Add Event
    //Return Type : String
    public function FSoCLOCAddEvent(){  
        try{
            $aDataPdtLoc   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbPlcAutoGenCode'),
                'FTPlcCode'     => $this->input->post('oetPlcCode'),
                'FTPlcName'     => $this->input->post('oetPlcName'),
                'FTPlcRmk'      => $this->input->post('otaPlcRmk'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPlcAgnCode')
            );
            // Setup Reason Code
            if($aDataPdtLoc['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode = FCNaHGenCodeV5('TCNMPdtLoc');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtLoc['FTPlcCode'] = $aGenCode['rtPlcCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtLoc',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtLoc['FTPlcCode']    = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->mPdtLocation->FSnMLOCCheckDuplicate($aDataPdtLoc['FTPlcCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaLocMaster  = $this->mPdtLocation->FSaMLOCAddUpdateMaster($aDataPdtLoc);
                $aStaLocLang    = $this->mPdtLocation->FSaMLOCAddUpdateLang($aDataPdtLoc);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Location"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPdtLoc['FTPlcCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Location'
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


    //Functionality : Event Edit Product Size
    //Parameters : Ajax Event
    //Creator : 04/02/2019 Napat(Jame)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCLOCEditEvent(){  
        try{
            $this->db->trans_begin();
            $aDataPdtLoc   = array(
                'FTPlcCode'     => $this->input->post('oetPlcCode'),
                'FTPlcName'     => $this->input->post('oetPlcName'),
                'FTPlcRmk'      => $this->input->post('otaPlcRmk'),
                // 'FDCreateOn'    => date('Y-m-d'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                // 'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPlcAgnCode')
            );
            $aStaLocMaster  = $this->mPdtLocation->FSaMLOCAddUpdateMaster($aDataPdtLoc);
            $aStaLocLang    = $this->mPdtLocation->FSaMLOCAddUpdateLang($aDataPdtLoc);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Location"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtLoc['FTPlcCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Location'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Location
    //Parameters : Ajax jReason()
    //Creator : 01/02/2019 Napat(Jame)
    //Update : 01/04/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCLOCDeleteEvent(){ 
        $tPlcCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPlcCode' => $tPlcCode,
        );
        $aResDel    = $this->mPdtLocation->FSaMLOCDelAll($aDataMaster);
        $nStaLocSeq = $this->mPdtLocation->FSaMLOCSeqDeleteDataAllByID($tPlcCode);
        $nNumRowPdtLoc = $this->mPdtLocation->FSnMLOCGetAllNumRow();
        if($nNumRowPdtLoc!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtLoc' => $nNumRowPdtLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
        
    }

    //Functionality : Event Get Data Product Group
    //Parameters : Ajax
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSvCLOCGetDataPdtGrp(){
        try{
            $tIDCode        = $this->input->post('tIDCode');
            $FTPlcCode      = $this->input->post('FTPlcCode');
            $FNPldSeq       = $this->input->post('FNPldSeq');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'FTPgpCode'     => $tIDCode,
                'FTPlcCode'     => $FTPlcCode,
                'FNPldSeq'      => $FNPldSeq,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit
            );

            $aPgpData   = $this->mPdtLocation->FSaMLOCGetDataPdtGrpByID($aData);
            $nSta       = $this->FSoCLOCManageAddEvent($aPgpData);
            if($nSta == 1){
                $aGenTable  = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $FTPlcCode,
                    'rtCode'        => $nSta,
                    'rtDesc'        => 'Add Location Seq Success',
                );
            }else{
                $aGenTable  = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Location Seq',
                );
            }
            echo json_encode($aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Event Get Data Product Type
    //Parameters : Ajax
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSvCLOCGetDataPdtTyp(){
        try{
            $tIDCode        = $this->input->post('tIDCode');
            $FTPlcCode      = $this->input->post('FTPlcCode');
            $FNPldSeq       = $this->input->post('FNPldSeq');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPtyCode'     => $tIDCode,
                'FTPlcCode'     => $FTPlcCode,
                'FNPldSeq'      => $FNPldSeq,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit
            );

            $aPtyData   = $this->mPdtLocation->FSaMLOCGetDataPdtTypByID($aData);
            $nSta       = $this->FSoCLOCManageAddEvent($aPtyData);
            if($nSta == 1){
                $aGenTable  = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $FTPlcCode,
                    'rtCode'        => $nSta,
                    'rtDesc'        => 'Add Location Seq Success',
                );
            }else{
                $aGenTable  = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Location Seq',
                );
            }
            echo json_encode($aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    //Functionality : Event Add Temp Loc Seq
    //Parameters : Ajax
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCLOCManageAddEvent($paData){
        if($paData['rtCode']=="1"){
            $nCount = FCNnHSizeOf($paData['raItems']);
            $nTrCount = $paData['FNPldSeq'];
            $tSta = 1;
    
            for($i=0;$i<$nCount;$i++){
                $nTrCount++;
                $aData = array(
                    'rtPlcCode'         => $paData['FTPlcCode'],
                    'rtBarCode'         => $paData['raItems'][$i]['rtBarCode'],
                    'rtPldSeq'          => $nTrCount,
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                );
                $oCountDup  = $this->mPdtLocation->FSnMLOCSeqCheckDuplicate($aData);
                $nStaDup    = $oCountDup['counts'];
                if($oCountDup !== FALSE && $nStaDup == 0){
                    $nData = $this->mPdtLocation->FSaMLOCLocSeqAddData($aData);
                    if($nData['rtCode']=='905'){ $tSta = 2; }
                }
                
            }
        }else{
            $tSta = 2;
        }
        return $tSta;
        
    }

    //Functionality : Event Delete Data Temp Loc Seq
    //Parameters : Ajax
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCLOCManageEditEvent(){
        try{
            $FTPlcCode      = $this->input->post('oetPlcCode');
            $aGrpPdt        = $this->input->post('ohdGrpPdt');
            $nNumProduct    = FCNnHSizeOf($aGrpPdt);

            for($i=0;$i<$nNumProduct;$i++){

                $aProductExploded = explode(",",$aGrpPdt[$i]);

                $nRow = $i + 1;

                $aData = array(
                    'FTPlcCode'             => $aProductExploded[0],
                    'FTBarCode'             => $aProductExploded[1],
                    'FNPldSeq'              => $nRow,
                    'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'            => date('Y-m-d H:i:s'),
                    'FDLastUpdOn'           => date('Y-m-d H:i:s')
                );

                $aLocSeqData = $this->mPdtLocation->FSaMLOCEditDataLocSeq($aData);
                
            }
            
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Location Seq"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $FTPlcCode,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Location Seq'
                );
            }
                
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Location Seq
    //Parameters : Ajax jReason()
    //Creator : 11/02/2019 Napat(Jame)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCLOCSeqDeleteEvent(){ 
        $tBarCode   = $this->input->post('tBarCode');
        $tPlcCode   = $this->input->post('tPlcCode');

        $aDataMaster = array(
            'FTBarCode' => $tBarCode,
            'FTPlcCode' => $tPlcCode
        );
        $aResDel    = $this->mPdtLocation->FSaMLOCSeqDelAll($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

}