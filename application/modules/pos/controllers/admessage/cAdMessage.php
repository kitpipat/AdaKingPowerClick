<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cAdMessage extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/admessage/mAdMessage');
        $this->load->library('upload');
        date_default_timezone_set("Asia/Bangkok");
        // ini_set('upload_max_filesize', '100M');
        // ini_set('post_max_size', '100M');
    }
    
    /**
     * Functionality : Main page for ad message
     * Parameters : $nAdvBrowseType, $tAdvBrowseOption
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nAdvBrowseType, $tAdvBrowseOption){
        $nAdvResp = array('title'=>"Province");
        $aAlwEvent = FCNaHCheckAlwFunc('adMessage/0/0'); //Controle Event
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nAdvResp);
            $this->load->view ( 'common/wTopBar', array ('nAdvResp'=>$nAdvResp));
            $this->load->view ( 'common/wMenu', array ('nAdvResp'=>$nAdvResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('adMessage/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view ( 'pos/admessage/wAdMessage', array (
            'nAdvResp'              =>$nAdvResp,
            'vBtnSave'              => $vBtnSave,
            'nAdvBrowseType'        =>$nAdvBrowseType,
            'tAdvBrowseOption'      =>$tAdvBrowseOption,
            'aAlwEventAdMessage'    => $aAlwEvent
        ));
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvADVListPage(){
        $this->load->view('pos/admessage/wAdMessageList');
    }

    /**
     * Functionality : Function Call DataTables Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvADVDataList(){
        $aAlwEventAdMessage         = FCNaHCheckAlwFunc('adMessage/0/0'); //Controle Event
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
	    // $aLangHave      = FCNaHGetAllLangByTable('TCNMAdMsg_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mAdMessage->FSaMADVList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList'             => $aResList,
            'nPage'                 => $nPage,
            'tSearchAll'            => $tSearchAll,
            'aAlwEventAdMessage'    => $aAlwEventAdMessage,
        );
        $this->load->view('pos/admessage/wAdMessageDataTable', $aGenTable);
    }

    /**
     * Functionality : Function CallPage Slip Message Add
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvADVAddPage(){
        date_default_timezone_set("Asia/Bangkok");
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TCNMAdMsg_L');
        $dGetDataNow    = date('Y-m-d');
		$dGetDataFuture = date('Y-m-d', strtotime('+1 year'));


        // $nLangHave      = FCNnHSizeOf($aLangHave);
        
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        
        $aData  = array(
            'FNLngID'   => $nLangEdit,
        );
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aDataAdd = array(
            'aResult'        => array('rtCode'=>'99'),
            'dGetDataNow'    => $dGetDataNow,
            'dGetDataFuture' => $dGetDataFuture,
            'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
            
        );

        $this->load->view('pos/admessage/wAdMessageAdd',$aDataAdd);
    }
    
    /**
     * Functionality : Function CallPage Slip Message Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvADVEditPage(){
        
        $tAdvCode                   = $this->input->post('tAdvCode');
        $nLangResort                = $this->session->userdata("tLangID");
        $nLangEdit                  = $this->session->userdata("tLangEdit");
        $aAlwEventAdMessage         = FCNaHCheckAlwFunc('adMessage/0/0'); //Controle Event
        // $aLangHave                  = FCNaHGetAllLangByTable('TCNMAdMsg_L');
        // $nLangHave                  = FCNnHSizeOf($aLangHave);
        
        // if($nLangHave > 1){
	    //     if($nLangEdit != ''){
	    //         $nLangEdit = $nLangEdit;
	    //     }else{
	    //         $nLangEdit = $nLangResort;
	    //     }
	    // }else{
	    //     if(@$aLangHave[0]->nLangList == ''){
	    //         $nLangEdit = '1';
	    //     }else{
	    //         $nLangEdit = $aLangHave[0]->nLangList;
	    //     }
        // }
        
        $aData  = array(
            'FTAdvCode' => $tAdvCode,
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aAdvData       = $this->mAdMessage->FSaMADVSearchByID($tAPIReq, $tMethodReq, $aData);


        $aDataEdit      = array(
            'aResult'               => $aAdvData,
            'aAlwEventAdMessage'    => $aAlwEventAdMessage
        );
        $this->load->view('pos/admessage/wAdMessageAdd', $aDataEdit);
    }
    
    /**
     * Functionality : Event Add Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */

    // $dStartDate = $this->input->post('oetAdvStart')." ".$this->input->post('oetEvnTStart');

   

    public function FSaADVAddEvent(){
        try {
            $tIsAutoGenCode = $this->input->post('ocbAdvAutoGenCode');

            // Setup Reason Code
            $tAdvCode = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName"   => 'TCNMAdMsg',                           
                    "tDocType"   => 0,                                          
                    "tBchCode"   => $this->session->userdata("tSesUsrBchCodeDefault"),                                 
                    "tShpCode"   => "",                               
                    "tPosCode"   => "",                     
                    "dDocDate"   => date("Y-m-d")       
                );
                $aAutogen   				= FCNaHAUTGenDocNo($aStoreParam);
                $tAdvCode                   = $aAutogen[0]["FTXxhDocNo"];

            }else{
                $tAdvCode = $this->input->post('oetAdvCode');
            }


            $aDataMaster = array(
                'FTAdvCode'         => $tAdvCode,
                'FTAdvName'         => $this->input->post('oetAdvName'),
                'FTAdvMsg'          => $this->input->post('oetAdvMsg'),
                'FTAdvType'         => $this->input->post('adTypeId'),
                'FTAdvStaUse'       => $this->input->post('ocmAdvStatus'), //orbAdvStatus
                'FDAdvStart'        => $this->input->post('oetAdvStart'), //." ".$this->input->post('oetEvnTStart')
                'FDAdvStop'         => $this->input->post('oetAdvFinish'), //." ".$this->input->post('oetEvnTFinish')
                'FTAdvRmk'          => $this->input->post('otaAdvRemark'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTMedTable'        => 'TCNMAdMsg',
                'FTAgnCode'         => $this->input->post('oetAdvAgnCode')
            );

            $oCountDup  = $this->mAdMessage->FSoMADVCheckDuplicate($aDataMaster['FTAdvCode']);

            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                
                // Add or update ad message
                $Res = $this->mAdMessage->FSaMADVAddUpdateMaster($aDataMaster);
                // print_r($Res);
                $this->mAdMessage->FSaMADVAddUpdateLang($aDataMaster);
                
                // Add or update media
                if($this->FCNbIsMediaType('all', $aDataMaster['FTAdvType'])){ // 3: video, 5: sound

                    if($this->FCNbIsMediaType('video', $aDataMaster['FTAdvType'])){ // 3: video
                        $nMedType = 2;// video type
                    }
                    if($this->FCNbIsMediaType('sound', $aDataMaster['FTAdvType'])){ // 5: sound
                        $nMedType = 1;// sound type
                    }

                    if(!(FCNnHSizeOf($_FILES) <= 0)){
                        
                        $nIndex = 1;
                        $aMedKey = array();
                        foreach ($_FILES as $tKey => $aFile){
                            array_push($aMedKey,$this->input->post('oetAdvMediaKey'.$nIndex));
                            $nIndex++;
                        }

                        $aMediaUplode = array(
                            'tMediaFolder'          => 'admessage',
                            'tMediaRefID'           => $aDataMaster['FTAdvCode'],
                            'tMediaType'            => $nMedType,
                            'oMediaObj'             => $_FILES,
                            'tMediaTable'           => 'TCNMAdMsg',
                            'tTableInsert'          => 'TCNMMediaObj',
                            'aMediaKey'             => $aMedKey,
                            'dDateTimeOn'           => date('Y-m-d H:i:s'),
                            'tWhoBy'                => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit'     => 1
                        );
                        //print_r($aMediaUplode);exit;
                        // die(print_r($aMediaUplode));
                        $aUploadMedia = FCNaHUploadMedia($aMediaUplode);
                        if( $aUploadMedia['nStaEvent'] != 1 ){
                            $this->db->trans_rollback();
                            $aReturn = array(
                                'nStaEvent'    => $aUploadMedia['nStaEvent'],
                                'tStaMessg'    => $aUploadMedia['tStaMessg']
                            );
                            echo json_encode($aReturn);
                            return false;
                        }

                    }
                }

                if($aDataMaster['FTAdvType'] == 6){
                    $aPdtImg = $this->input->post('aPdtImg');
                    // $aPdtImg = explode(",",$tPdtImg);

                    if(isset($aPdtImg) && !empty($aPdtImg) && is_array($aPdtImg) ){
                        // foreach($aPdtImg as $tValueImgObj){
                        $aImageUplode = array(
                            'tModuleName'       => 'pos',
                            'tImgFolder'        => 'admessage',
                            'tImgRefID'         => $aDataMaster['FTAdvCode'],
                            'tImgObj'           => $aPdtImg,
                            'tImgTable'         => 'TCNMAdMsg',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'master',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1,
                            'nStaImageMulti'    => 1
                        );
                        // print_r($aImageUplode);exit;
                        $aImgReturn = FCNnHAddImgObj($aImageUplode);
                        if( $aImgReturn['nStaEvent'] != 1 ){
                            $this->db->trans_rollback();
                            $aReturn = array(
                                'nStaEvent'    => $aImgReturn['nStaEvent'],
                                'tStaMessg'    => $aImgReturn['tStaMessg']
                            );
                            echo json_encode($aReturn);
                            return false;
                        }
                        // }
                    }
                }
                
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Event"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTAdvCode'],
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
        } catch (ErrorException $Error) {
            $aReturn = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Event Edit Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaADVEditEvent(){

            $aDataMaster = array(
                'FTAdvCode'         => $this->input->post('oetAdvCode'),
                'FTAdvName'         => $this->input->post('oetAdvName'),
                'FTAdvMsg'          => $this->input->post('oetAdvMsg'),
                'FTAdvType'         => $this->input->post('adTypeId'),
                'FTAdvStaUse'       => $this->input->post('ocmAdvStatus'),
                'FNAdvSeqNo'        => '1',  
                'FDAdvStart'        => $this->input->post('oetAdvStart')." ".$this->input->post('oetEvnTStart'),
                'FDAdvStop'         => $this->input->post('oetAdvFinish')." ".$this->input->post('oetEvnTFinish'),
                'FTAdvRmk'          => $this->input->post('otaAdvRemark'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'         => $this->input->post('oetAdvAgnCode')
            );
            
            $this->db->trans_begin();

            // Add or update ad message
            $this->mAdMessage->FSaMADVAddUpdateMaster($aDataMaster);
            $this->mAdMessage->FSaMADVAddUpdateLang($aDataMaster);

            // Add or update media
            if($this->FCNbIsMediaType('all', $aDataMaster['FTAdvType'])){ // 3: video, 5: sound
                
                $aSeqChange     = json_decode($this->input->post('mediaSeqChange'));        // ถ้ามีรายการ เพิ่มใหม่ [0] => 1,[1] => 3,[2] => 4
                $aSeqNoChange   = json_decode($this->input->post('mediaSeqNoChange'));      // อัพเดททุกครั้งที่กดบันทึก [id] => 25 ,[seq] => 2
                $aSeqChangeOld  = json_decode($this->input->post('mediaSeqChangeOld'));     // ถ้ามีรายการ ลบรายการ [0] => 26

                // echo "<pre>";
                // print_r($aSeqChange);
                // print_r($aSeqNoChange);
                // print_r($aSeqChangeOld);
                // exit;
                
                // Change Old
                if(FCNnHSizeOf($aSeqChangeOld) > 0){
                    // Remove file and record
                    $aMediaOldForRemove = $this->mAdMessage->FSaMADVSearchMediaIn($aSeqChangeOld, $aDataMaster);

                    // $tFilePath = './application/modules/common/assets/system/systemimage/'; //application/assets/system
                    foreach($aMediaOldForRemove as $oMediaOldForRemove){
                        // unlink($oMediaOldForRemove->FTMedPath); // Remove file
                        // unlink($tFilePath . $oMediaOldForRemove->FTMedPath); // Remove file
                        $this->mAdMessage->FSnMADVDelMediaByID($oMediaOldForRemove->FNMedID, $aDataMaster); // Remove record
                    }
                }
                
                // No Change
                if(FCNnHSizeOf($aSeqNoChange) > 0){
                    $aNoChangeId = [];
                    // Update Seq
                    foreach($aSeqNoChange as $aIndex => $oNoChangeItem){
                        $aNoChangeId[] = $oNoChangeItem->id; // Keep id
                        $aDataMaster['FNMedID'] = $oNoChangeItem->id; // ID for update
                        $aDataMaster['FNMedSeq'] = $oNoChangeItem->seq; // Seq for update
                        $this->mAdMessage->FSaMADVUpdateMedia($aDataMaster);
                    }

                    // Remove file and record
                    $aMediaForRemove = $this->mAdMessage->FSaMADVSearchMediaNotIn($aNoChangeId, $aDataMaster);

                    // $tFilePath = './application/modules/common/assets/system/systemimage/'; ///application/assets/system/
                    foreach($aMediaForRemove as $oMediaForRemove){
                        // unlink($oMediaForRemove->FTMedPath); // Remove file
                        // unlink($tFilePath . $oMediaForRemove->FTMedPath); // Remove file
                        $this->mAdMessage->FSnMADVDelMediaByID($oMediaForRemove->FNMedID, $aDataMaster); // Remove record
                    }
                }
                
                // $aDataMaster['FTMedTable'] = 'TCNMAdMsg';
                // $aDataMaster['FTMedRefID'] = $aDataMaster['FTAdvCode'];

                // if($this->FCNbIsMediaType('video', $aDataMaster['FTAdvType'])){ // 3: video
                //     $aDataMaster['FNMedType'] = 2; // video type
                // }
                // if($this->FCNbIsMediaType('sound', $aDataMaster['FTAdvType'])){ // 5: sound
                //     $aDataMaster['FNMedType'] = 1; // sound type
                // }

                if($this->FCNbIsMediaType('video', $aDataMaster['FTAdvType'])){ // 3: video
                    $nMedType = 2;// video type
                }
                if($this->FCNbIsMediaType('sound', $aDataMaster['FTAdvType'])){ // 5: sound
                    $nMedType = 1;// sound type
                }

                // New
                if(!(FCNnHSizeOf($_FILES) <= 0)){
                    // $config['upload_path'] = './application/modules/pos/assets/systemimg/admessage/'.$aDataMaster['FTAdvCode'];
                    // $config['allowed_types'] = 'mp3|mp4|avi|wav|mpeg';

                    // $aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
				    // $tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/pos/assets/systemimg/admessage");
                    
                    /*$aFiles = glob($config['upload_path'] . '/*'); // get all file names
                    foreach($aFiles as $aFile){
                        if(is_file($aFile)){
                            unlink($aFile); // delete file
                        }
                    }
                    rmdir('./application/assets/system/admessage/' . $aDataMaster['FTAdvCode']); // remove folder
                    if(!is_dir($config['upload_path'])){
                        mkdir('./application/assets/system/admessage/' . $aDataMaster['FTAdvCode']);// make folder
                    }*/
                    
                    // $nIndex = 0;
                    // $tCaracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
                    // $tQuantidadeCaracteres = strlen($tCaracteres);
                    
                    // foreach ($_FILES as $tKey => $aFile){
                    //     $tHash=NULL;
                    //     for($x=1;$x<=10;$x++){
                    //         $tPosicao = rand(0,$tQuantidadeCaracteres);
                    //         $tHash   .= substr($tCaracteres,$tPosicao,1);
                    //     }
                    //     $tFilename = 'Media'.$tHash.date('Ymd');
                    //     $config['file_name']        = $tFilename;

                    //     $this->upload->initialize($config);
                    //     $this->upload->do_upload($tKey);
                        
                    //     $tFileType = strtoupper(explode('.', $aFile['name'])[1]);
                    //     $aDataMaster['FTMedKey']        = $this->input->post('oetAdvMediaKey'.$aSeqChange[$nIndex]);
                    //     $aDataMaster['FNMedSeq']        = $aSeqChange[$nIndex]; // Seq
                    //     $aDataMaster['FTMedFileType']   = $tFileType;
                    //     $aDataMaster['FTMedPath']       = $tPathFullComputer."/".$aDataMaster['FTAdvCode']."/".$tFilename.".".strtolower($tFileType);
                    //     $this->mAdMessage->FSaMADVAddMedia($aDataMaster);
                    //     $nIndex++;
                    // }

                    $nIndex = 0;
                    $aMedKey = array();
                    $aMedSeq = array();
                    foreach ($_FILES as $tKey => $aFile){
                        array_push($aMedKey,$this->input->post('oetAdvMediaKey'.$aSeqChange[$nIndex]));
                        array_push($aMedSeq,$aSeqChange[$nIndex]);
                        $nIndex++;
                    }

                    $aMediaUplode = array(
                        'tMediaFolder'          => 'admessage',
                        'tMediaRefID'           => $aDataMaster['FTAdvCode'],
                        'aMediaSeq'             => $aMedSeq,
                        'tMediaType'            => $nMedType,
                        'oMediaObj'             => $_FILES,
                        'tMediaTable'           => 'TCNMAdMsg',
                        'tTableInsert'          => 'TCNMMediaObj',
                        'aMediaKey'             => $aMedKey,
                        'dDateTimeOn'           => date('Y-m-d H:i:s'),
                        'tWhoBy'                => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit'     => 1
                    );
                    // print_r($aMediaUplode);exit;
                    $aUploadMedia = FCNaHUploadMedia($aMediaUplode);

                    if( $aUploadMedia['nStaEvent'] != 1 ){
                        $this->db->trans_rollback();
                        $aReturn = array(
                            'nStaEvent'    => $aUploadMedia['nStaEvent'],
                            'tStaMessg'    => $aUploadMedia['tStaMessg']
                        );
                        echo json_encode($aReturn);
                        return false;
                    }

                }
            }

            if($aDataMaster['FTAdvType'] == 6){
                $aPdtImg = $this->input->post('aPdtImg');
                // $aPdtImg = explode(",",$tPdtImg);
                // print_r($aPdtImg);exit;
                if(isset($aPdtImg) && !empty($aPdtImg)){
                    $aImageUplode = array(
                        'tModuleName'       => 'pos',
                        'tImgFolder'        => 'admessage',
                        'tImgRefID'         => $aDataMaster['FTAdvCode'],
                        'tImgObj'           => $aPdtImg,
                        'tImgTable'         => 'TCNMAdMsg',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'master',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1,
                        'nStaImageMulti'    => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                    if( $aImgReturn['nStaEvent'] != 1 ){
                        $this->db->trans_rollback();
                        $aReturn = array(
                            'nStaEvent'    => $aImgReturn['nStaEvent'],
                            'tStaMessg'    => $aImgReturn['tStaMessg']
                        );
                        echo json_encode($aReturn);
                        return false;
                    }
                }
            }

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAdvCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
            echo json_encode($aReturn);

    }
    
    /**
     * Functionality : Event Delete Slip Message
     * Parameters : Ajax and Function Parameter
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status Delete Event
     * Return Type : String
     */
    public function FSaADVDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAdvCode'     => $tIDCode,
            'FTMedTable'    => 'TCNMAdMsg'
        );

        $aResDel = $this->mAdMessage->FSnMADVDelMaster($aDataMaster);
        $this->mAdMessage->FSnMADVDelMedia($aDataMaster);
        
        $aReturn = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Vatrate unique check
     * Parameters : $tSelect "advcode"
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : String
     */
    public function FStADVUniqueValidate($tSelect = ''){
        
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'advcode'){
                
                $tAdvCode = $this->input->post('tAdvCode');
                $oAdMessage = $this->mAdMessage->FSoMADVCheckDuplicate($tAdvCode);
                
                $tStatus = 'false';
                if($oAdMessage[0]->counts > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                
                return;
            }
            echo 'Param not match.';
        }else{
            echo 'Method Not Allowed';
        }
    }
    
    /**
     * Functionality : Validate file name unique
     * Parameters : $tSelect "advFileName"
     * Creator : 13/09/2018 piya
     * Last Modified : -
     * Return : Check status true or false
     * Return Type : string
     */
    public function FStADVUniqueFileNameValidate($tSelect = ''){
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'advFileName'){
                
                $tFileName = $this->input->post('tFileName');
                $tAdvCode = $this->input->post('tAdvCode');
                
                $aData = [];
                $aData['tFileName'] = 'admessage/' . $tAdvCode . '/' . $tFileName;
                $aData['tAdvCode'] = $tAdvCode;
                $oMedia = $this->mAdMessage->FSoMADVCheckMediaFileNameDuplicate($aData);
                
                $tStatus = 'false';
                if($oMedia[0]->counts > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                
                return;
            }
            echo 'Param not match.';
        }else{
            echo 'Method Not Allowed';
        }
    }
    
    /**
     * Functionality : Function Event Multi Delete
     * Parameters : Ajax Function Delete Slip Message
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoADVDeleteMulti(){
        $tAdvCode = $this->input->post('tAdvCode');
        $aAdvCode = json_decode($tAdvCode);

        $aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
		$tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/common/assets/system/systemimage/admessage");
        foreach($aAdvCode as $oAdvCode){
            $aAdv = [
                'FTAdvCode'     => $oAdvCode,
                'FTMedTable'    => 'TCNMAdMsg'
            ];
            $this->mAdMessage->FSnMADVDelMaster($aAdv);
            $this->mAdMessage->FSnMADVDelMedia($aAdv);

            $tDir = $tPathFullComputer.'/'.$aAdv['FTAdvCode'];
            if(is_dir($tDir)){
                $folder_path = $tDir;
                $files = glob($folder_path.'/*');
                foreach($files as $file) { 
                    if(is_file($file)){
                        unlink($file);
                    }
                }
                rmdir($folder_path);
            }
        }
        echo json_encode($aAdvCode);
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 10/09/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoADVDelete(){
        // $tAdvCode = $this->input->post('tAdvCode');
        
        // $aAdv = ['FTAdvCode' => $tAdvCode];
        // $this->mAdMessage->FSnMADVDelMaster($aAdv);
        // $this->mAdMessage->FSnMADVDelMedia($aAdv);
        // echo json_encode($tAdvCode);
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTAdvCode'     => $tIDCode,
            'FTMedTable'    => 'TCNMAdMsg'
        );

        $aResDelMaster      = $this->mAdMessage->FSnMADVDelMaster($aDataMaster);
        $aResDelMedia       = $this->mAdMessage->FSnMADVDelMedia($aDataMaster);

        $aUrlPathServer 	= explode('/index.php',$_SERVER['SCRIPT_FILENAME']);
        $tPathFullComputer	= str_replace('\\', "/", $aUrlPathServer[0]. "/application/modules/common/assets/system/systemimage/admessage");
        if(is_array($aDataMaster['FTAdvCode'])){
            foreach($aDataMaster['FTAdvCode'] as $tAdvCode){
                $tDir = $tPathFullComputer.'/'.$tAdvCode;
                if(is_dir($tDir)){
                    $folder_path = $tDir;
                    $files = glob($folder_path.'/*');
                    foreach($files as $file) { 
                        if(is_file($file)){
                            unlink($file);
                        }
                    }
                    rmdir($folder_path);
                }
            }
        }else{
            $tDir = $tPathFullComputer.'/'.$aDataMaster['FTAdvCode'];
            if(is_dir($tDir)){
                $folder_path = $tDir;
                $files = glob($folder_path.'/*');
                foreach($files as $file) { 
                    if(is_file($file)){
                        unlink($file);
                    }
                }
                rmdir($folder_path);
            }
        }
        
        // $aResDelMedia        = $this->mAdMessage->FSnMADVDelMedia($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDelMaster['rtCode'],
            'tStaMessg' => $aResDelMaster['rtDesc']
        );
        echo json_encode($aReturn);
    }
    
    /**
    * Functionality : Text type check
    * Parameters : ptTextType is type for check ("welcome", "promotion", "thank", "all")
    * Creator : 10/09/2018 piya
    * Last Modified : -
    * Return : Type check
    * Return Type : boolean
    */
   public function FCNbIsTextType($ptTextType = 'all', $tAdTypeId){
        $bIsType = false;

        if($ptTextType == 'welcome'){
            if($tAdTypeId == 1){ // 1: welcome message
                $bIsType = true;
            }
            return $bIsType;
        }
        if($ptTextType == 'promotion'){
            if($tAdTypeId == 2){ // 2: promotion message
                $bIsType = true;
            }
            return $bIsType;
        }
        if($ptTextType == 'thank'){
            if($tAdTypeId == 4){ // 4: thank message
                $bIsType = true;
            }
            return $bIsType;
        }
        if($ptTextType == 'all'){
            if( ($tAdTypeId == 1) || ($tAdTypeId == 2) || ($tAdTypeId == 4)){ // 1: welcome message, 2: promotion message, 4: thank message
                $bIsType = true;
            }
            return $bIsType;
        }
        return $bIsType;
   }

   /**
    * Functionality : Media type check
    * Parameters : ptMediaType is type for check ("video", "sound", "all")
    * Creator : 10/09/2018 piya
    * Last Modified : -
    * Return : Type check
    * Return Type : boolean
    */
   public function FCNbIsMediaType($ptMediaType = 'all', $tAdTypeId){
        $bIsType = false;

        if($ptMediaType == 'video'){
            if($tAdTypeId == 3){ // 3: video
                $bIsType = true;
            }
            return $bIsType;
        }
        if($ptMediaType == 'sound'){
            if($tAdTypeId == 5){ // 5: sound
                $bIsType = true;
            }
            return $bIsType;
        }
        if($ptMediaType == 'all'){
            if( ($tAdTypeId == 3) || ($tAdTypeId == 5) ){ // 3: video, 5: sound
                $bIsType = true;
            }
            return $bIsType;
        }
        return $bIsType;
   }
    
}
