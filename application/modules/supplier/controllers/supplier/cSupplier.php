<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSupplier extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('supplier/supplier/mSupplier');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nSplBrowseType,$tSplBrowseOption){
        $nMsgResp   = array('title'=>"Supplier");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('supplier/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('supplier/supplier/wSupplier', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nSplBrowseType'    => $nSplBrowseType,
            'tSplBrowseOption'  => $tSplBrowseOption
        ));
    }

    //Functionality : Function Call Page Supplier List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCSPLListPage(){
        $this->load->view('supplier/supplier/wSupplierList');
    }

    //Functionality : Function Call View Data Supplier
    //Parameters : Ajax Call View DataTable
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCSPLDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
            $aSplDataList   = $this->mSupplier->FSaMSPLList($aData);
            $aGenTable  = array(
                'aSplDataList'  => $aSplDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('supplier/supplier/wSupplierDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Supplier Add
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCSPLAddPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            $aDataSupplier = array(
                'nStaAddOrEdit'   => 99,
                'aVatRate'		=> $aVatList,
                'nOptDecimalShow'   => $nOptDecimalShow
            );

            $this->load->view('supplier/supplier/wSupplierAdd',$aDataSupplier);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Supplier Add Address
    //Parameters : Ajax Call View Add
    //Creator : 21/06/2019 Sarun
    //Return : String View
    //Return Type : View
    public function FSvCSPLAddAddressPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aCnfAddPanal 		= $this->FSvCBCHGenViewAddress();
            $aSplData   = $this->mSupplier->FSaMSPLAddType();
            $aDataSupplier = array(
                'nStaAddOrEdit'   => 99,
                'aData'           => $aSplData,
                'aCnfAddPanal'    => $aCnfAddPanal
            );
            $this->load->view('supplier/supplier/wSupplierAddAddress',$aDataSupplier);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Supplier Add Contact
    //Parameters : Ajax Call View Add
    //Creator : 26/06/2019 Sarun
    //Return : String View
    //Return Type : View
    public function FSvCSPLAddContactPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataSupplier = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('supplier/supplier/wSupplierAddContact',$aDataSupplier);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    // Functionality : Function CallPage Supplier Edits
    // Parameters : Ajax Call View Add
    // Creator : 22/10/2018 Phisan
    // LastUpdate: 20/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCSPLEditPage(){
        $tSplCode       = $this->input->post('tSplCode');
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if($nLangHave > 1){
            $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
        }else{
            $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
        }
        $aData  = [
            'FTSplCode' => $tSplCode,
            'FNLngID'   => $nLangEdit
        ];
        $aSplData   = $this->mSupplier->FSaMSPLGetDataByID($aData);
        $aVatList   = FCNoHCallVatlist();
    
        $aDataSupplier  = [
            'nStaAddOrEdit' => 1,
            'tImgObjAll'    => $aSplData['raItems']['rtImgObj'],
            'aVatRate'		=> $aVatList,
            'aSplData'      => $aSplData,
            'nOptDecimalShow'   => $nOptDecimalShow
        ];
        $this->load->view('supplier/supplier/wSupplierAdd',$aDataSupplier);
    }

    public function FSvCSPLEAddressEditPage(){
        try{
            $tSplCode       = $this->input->post('tSplCode');
            $nSeqNo         = $this->input->post('nSeqNo');
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTSplCode' => $tSplCode,
                'FNSeqNo'   => $nSeqNo,
                'FNLangID'  => $nLangEdit
            );
            // $aSplDataAddress = $this->mSupplier->FSaMSPLGetDataAddress($aData);
            // $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aSplAddressData       = $this->mSupplier->FSaMSPLGetAddressDataByID($aData);
            $aSplAddressSeparate   = $this->mSupplier->FSnMSPLGetAddressData($aData);//จังหวัด อำเภอ ตำบล

            $aSplData   = $this->mSupplier->FSaMSPLAddType();
            $aDataSupplier  = array(
                'nStaAddOrEdit' => 1,
                'aSplAddressData'       => $aSplAddressData,
                'aData'                 => $aSplData,
                'aSplAddressSeparate'   => $aSplAddressSeparate[0]
				// 'aVatRate'		=> $aVatList,
                // 'aSplDataAddress'      => $aSplDataAddress
            );
            $this->load->view('supplier/supplier/wSupplierAddAddress',$aDataSupplier);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSvCSPLEContactEditPage(){
        try{
            $tSplCode       = $this->input->post('tSplCode');
            $nSeqNo         = $this->input->post('nSeqNo');
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTSplCode' => $tSplCode,
                'FNCtrSeq'   => $nSeqNo,
                'FNLangID'  => $nLangEdit
                // 'FNLngID'   => $nLangEdit
            );
            // $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aSplContactData       = $this->mSupplier->FSaMSPLGetContactDataByID($aData);
            $aDataSupplier  = array(
                'nStaAddOrEdit' => 1,
                'aSplContactData'       => $aSplContactData,
				// 'aVatRate'		=> $aVatList,
                // 'aSplDataAddress'      => $aSplDataAddress
            );
            $this->load->view('supplier/supplier/wSupplierAddContact',$aDataSupplier);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSoCSPLAddressDataTable(){
        try{
            $tSplcode = $this->input->post('tSplCode');
            $aSplDataAddress = $this->mSupplier->FSaMSPLGetDataAddress($tSplcode);
            $aSplAddress =array(
                    'aSplAddress' => $aSplDataAddress
                );
            $this->load->view('supplier/supplier/wSupplierAddressDataTable',$aSplAddress);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    public function FSoCSPLContactDataTable(){
        try{
            $tSplcode = $this->input->post('tSplCode');
            $aSplDataContact = $this->mSupplier->FSaMSPLGetDataContact($tSplcode);
            $aSplContact =array(
                    'aSplContact' => $aSplDataContact
                );
            $this->load->view('supplier/supplier/wSupplierContactDataTable',$aSplContact);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    // Functionality : Event Add Supplier
    // Parameters : Ajax Event
    // Creator : 22/10/2018 Phisan
    // LastUpdate: 20/09/2019 Wasin(Yoshi)
    // Return : Status Add Event
    // Return Type : String
    public function FSoCSPLAddEvent(){
        /** ====================  Image Input Data ==================== */
        $tImgInputSupplier      = $this->input->post('oetImgInputSupplier');
        $tImgInputSupplierOld   = $this->input->post('oetImgInputSupplierOld');
        /** ====================  Image Input Data ==================== */

        $tIsAutoGenCode	= $this->input->post('ocbSplAutoGenCode');
        if(isset($tIsAutoGenCode) && $tIsAutoGenCode == 1){
            // Call Auto Gencode Helper

            $aStoreParam = array(
                "tTblName"   => 'TCNMSpl',
                "tDocType"   => 0,
                "tBchCode"   => $this->session->userdata("tSesUsrBchCodeDefault"),
                "tShpCode"   => "",
                "tPosCode"   => "",
                "dDocDate"   => date("Y-m-d")
            );
            $aAutogen   				= FCNaHAUTGenDocNo($aStoreParam);
            $tCode                      = $aAutogen[0]["FTXxhDocNo"];

        }else{
            $tCode = $this->input->post('oetSplCode');
        }
        $tSplCode       = $tCode;
        $aDataMaster    = [
            'FTSplCode'         => $tSplCode,
            'FTSplTel'          => $this->input->post('oetSplTel'),
            'FTSplFax'          => $this->input->post('oetSplFax'),
            'FTSplEmail'        => $this->input->post('oemtSplEmail'),
            'FTSplSex'          => $this->input->post('ordSplSex') == '1' ? '1' : '2',
            'FDSplDob'          => (!empty($this->input->post('oetSplDob')))? $this->input->post('oetSplDob') : null,
            'FTSgpCode'         => $this->input->post('oetSgpCode'),
            'FTStyCode'         => $this->input->post('oetStyCode'),
            'FTSlvCode'         => $this->input->post('oetSlvCode'),
            'FTVatCode'         => $this->input->post('ocmVatRate'),
            'FTSplStaVATInOrEx' => $this->input->post('ordSplStaVATInOrEx') == '1' ? '1' : '2',
            'FTSplDiscBillRet'  => $this->input->post('oenSplDiscBillRet'),
            'FTSplDiscBillWhs'  => $this->input->post('oenSplDiscBillWhs'),
            'FTSplDiscBillNet'  => $this->input->post('oenSplDiscBillNet'),
            'FTSplBusiness'     => $this->input->post('ordSplBusiness') == '1' ? '1' : '2',
            'FTSplStaBchOrHQ'   => $this->input->post('ocbSplStaBchOrHQ') == '1' ? '1' : '2',
            'FTSplBchCode'      => $this->input->post('oetSplBchCode'),
            'FTSplStaActive'    => (!empty($this->input->post('ocbSplStaActive')))? 1 : 2,
            'FTUsrCode'         => $this->input->post('oetUsrCode'),
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername'),
            'FTAgnCode'         => $this->input->post('oetSplAgnCode')
        ];
        $aDataLang      = [
            'FTSplCode'         => $tSplCode,
            'FTSplName'         => $this->input->post('oetSplName'),
            'FTSplRmk'          => $this->input->post('oetSplRmk'),
            'FNLngID'           => $this->session->userdata("tLangEdit")
        ];
        $aDataCard      = [
            'FTSplCode'         => $tSplCode,
            'FDSplApply'        => date('Y-m-d'),
            'FTSplRefExCrdNo'   => NULL,
            'FDSplCrdIssue'     => NULL,
            'FDSplCrdExpire'    => NULL,
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername')
        ];
        $aDataCredit    = [
            'FTSplCode'         => $tSplCode,
            'FDCreateOn'        => date('Y-m-d H:i:s'),
            'FTCreateBy'        => $this->session->userdata('tSesUsername')
        ];
        $oCountDup              = $this->mSupplier->FSnMSPLCheckDuplicate($aDataMaster['FTSplCode']);
        $nStaDup                = $oCountDup['counts'];
        if($nStaDup == 0){
            $this->db->trans_begin();
            $this->mSupplier->FSaMSPLAddMaster($aDataMaster);
            $this->mSupplier->FSaMSPLAddLang($aDataLang);
            $this->mSupplier->FSaMSPLAddDT($aDataCard,'TCNMSplCard');
            $this->mSupplier->FSaMSPLAddDT($aDataCredit,'TCNMSplCredit');
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Supplier."
                );
            }else{
                $this->db->trans_commit();
                if($tImgInputSupplier != $tImgInputSupplierOld){
                    $aImageData = [
                        'tModuleName'       => 'supplier',
                        'tImgFolder'        => 'supplier',
                        'tImgRefID'         => $aDataMaster['FTSplCode'],
                        'tImgObj'           => $tImgInputSupplier,
                        'tImgTable'         => 'TCNMSpl',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    ];
                    $aImgReturn = FCNnHAddImgObj($aImageData);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTSplCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Supplier'
                );
            }
        }else{
            $aReturn = array(
                'nStaEvent'    => '801',
                'tStaMessg'    => "Data Code Duplicate"
            );
        }
        echo json_encode($aReturn);

    }

    // Functionality : Event Edit Supplier
    // Parameters : Ajax Event
    // Creator : 22/10/2018 Phisan
    // LastUpdate: 20/09/2019 Wasin(Yoshi)
    // Return : Status Edit Event
    // Return Type : String
    public function FSoCSPLEditEvent(){
        date_default_timezone_set("Asia/Bangkok");
        /** ====================  Image Input Data ==================== */
        $tImgInputSupplier      = $this->input->post('oetImgInputSupplier');
        $tImgInputSupplierOld   = $this->input->post('oetImgInputSupplierOld');
        /** ====================  Image Input Data ==================== */
        $aDataMaster    = [
            'FTSplCode'         => $this->input->post('oetSplCode'),
            'FTSplTel'          => $this->input->post('oetSplTel'),
            'FTSplFax'          => $this->input->post('oetSplFax'),
            'FTSplEmail'        => $this->input->post('oemtSplEmail'),
            'FTSplSex'          => $this->input->post('ordSplSex') == '1' ? '1' : '2',
            'FDSplDob'          => (!empty($this->input->post('oetSplDob')))? $this->input->post('oetSplDob') : null,
            'FTVatCode'         => $this->input->post('ocmVatRate'),
            'FTSplStaVATInOrEx' => $this->input->post('ordSplStaVATInOrEx') == '1' ? '1' : '2',
            'FTSplDiscBillRet'  => $this->input->post('oenSplDiscBillRet'),
            'FTSplDiscBillWhs'  => $this->input->post('oenSplDiscBillWhs'),
            'FTSplDiscBillNet'  => $this->input->post('oenSplDiscBillNet'),
            'FTSplBusiness'     => $this->input->post('ordSplBusiness') == '1' ? '1' : '2',
            'FTSplStaBchOrHQ'   => $this->input->post('ocbSplStaBchOrHQ') == '1' ? '1' : '2',
            'FTSplBchCode'      => $this->input->post('oetSplBchCode'),
            'FTSplStaActive'    => (!empty($this->input->post('ocbSplStaActive')))? 1 : 2,
            'FTUsrCode'         => $this->input->post('oetUsrCode'),
            'FTSgpCode'         => $this->input->post('oetSgpCode'),
            'FTStyCode'         => $this->input->post('oetStyCode'),
            'FTSlvCode'         => $this->input->post('oetSlvCode'),
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
            'FTAgnCode'         => $this->input->post('oetSplAgnCode')
        ];
        $aDataLang      = [
            'FTSplCode'     => $this->input->post('oetSplCode'),
            'FTSplName'     => $this->input->post('oetSplName'),
            'FTSplRmk'      => $this->input->post('oetSplRmk'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTSplPayRmk'   => $this->input->post('oetSplPayRmk'),
            'FTSplBillRmk'  => $this->input->post('oetSplBillRmk'),
            'FTSplViaRmk'   => $this->input->post('oetSplViaRmk')
        ];
        $aDataCard      = [
            'FTSplCode'         => $this->input->post('oetSplCode'),
            'FDSplApply'        => $this->input->post('oetSplApply'),
            'FTSplRefExCrdNo'   => $this->input->post('oetSplRefExCrdNo'),
            'FDSplCrdIssue'     => $this->input->post('oetSplCrdIssue'),
            'FDSplCrdExpire'    => $this->input->post('oetSplCrdExpire'),
            'FDLastUpdOn'       => date('Y-m-d H:i:s'),
            'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
        ];
        $tDayCtaMon = $this->input->post('ocbSplDayCtaMon') == 'on' ? '1,' : '';
        $tDayCtaTue = $this->input->post('ocbSplDayCtaTue') == 'on' ? '2,' : '';
        $tDayCtaWed = $this->input->post('ocbSplDayCtaWed') == 'on' ? '3,' : '';
        $tDayCtaThu = $this->input->post('ocbSplDayCtaThu') == 'on' ? '4,' : '';
        $tDayCtaFri = $this->input->post('ocbSplDayCtaFri') == 'on' ? '5,' : '';
        $tDayCtaSat = $this->input->post('ocbSplDayCtaSat') == 'on' ? '6,' : '';
        $tDayCtaSun = $this->input->post('ocbSplDayCtaSun') == 'on' ? '7,' : '';
        $tDayCtaAll = $this->input->post('ocbSplDayCtaAll') == 'on' ? '0' : '';
        if($tDayCtaAll == '0'){
            $tSplDayCta = '0';
        }else{
            $tSplDayCta = $tDayCtaMon.$tDayCtaTue.$tDayCtaWed.$tDayCtaThu.$tDayCtaFri.$tDayCtaSat.$tDayCtaSun;
            $tSplDayCta = substr($tSplDayCta,0,-1);
        }
        $aDataCredit  = [
            'FTSplCode'     => $this->input->post('oetSplCode'),
            'FNSplCrTerm'   => (!empty($this->input->post('oetDateCredit')))? $this->input->post('oetDateCredit') : NULL,//
            // 'FCSplCrLimit'  => (!empty($this->input->post('oetCredit')))? $this->input->post('oetCredit') : NULL,//
            'FCSplCrLimit'  => str_replace(',','',$this->input->post('oetCredit')),

            'FTSplDayCta'   => $tSplDayCta,//
            'FDSplLastCta'  => $this->input->post('oetSplLastCta'),//
            'FDSplLastPay'  => $this->input->post('oetSplLastPay'),//
            'FNSplLimitRow' => $this->input->post('oenSplLimitRow'),//
            'FCSplLeadTime' => (!empty($this->input->post('oenSplLeadTime')))? $this->input->post('oenSplLeadTime') : NULL,//
            'FTViaCode'     => $this->input->post('oetViaCode'),//
            'FTSplTspPaid'  => $this->input->post('ordSplTspPaid') == '1' ? '1' : '2',//
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
        ];

        $this->db->trans_begin();
        $this->mSupplier->FSaMSPLUpdateMaster($aDataMaster);
        $this->mSupplier->FSaMSPLUpdateDT($aDataLang,'TCNMSpl_L');
        $this->mSupplier->FSaMSPLUpdateDT($aDataCard,'TCNMSplCard');
        $this->mSupplier->FSaMSPLUpdateDT($aDataCredit,'TCNMSplCredit');
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Update Supplier."
            );
        }else{
            $this->db->trans_commit();
            if($tImgInputSupplier != $tImgInputSupplierOld){
                $aImageData = [
                    'tModuleName'       => 'supplier',
                    'tImgFolder'        => 'supplier',
                    'tImgRefID'         => $aDataMaster['FTSplCode'],
                    'tImgObj'           => $tImgInputSupplier,
                    'tImgTable'         => 'TCNMSpl',
                    'tTableInsert'      => 'TCNMImgObj',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 2
                ];
                $aImgReturn = FCNnHAddImgObj($aImageData);
            }
            $aReturn = array(
                'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aDataMaster['FTSplCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Update Supplier.'
            );
        }
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Supplier
    //Parameters : Ajax
    //Creator : 22/10/2018 Phisan
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCSPLDeleteEvent(){
        try{
            $aIDCode = $this->input->post('aIDCode');
            $aDataMaster = array(
                'FTSplCode' => $aIDCode
            );
            $aResDel        = $this->mSupplier->FSnMSPLDel($aDataMaster);
            if($aResDel['rtCode'] == 1){
                $aDeleteImage = array(
                    'tModuleName'   => 'supplier',
                    'tImgFolder'   => 'supplier',
                    'tImgRefID'    => $aIDCode,
                    'tTableDel'    => 'TCNMImgObj',
                    'tImgTable'    => 'TCNMSpl'
                );
                $aDeleteImg = FSnHDeleteImageFiles($aDeleteImage);
            }
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Supplier
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSPLAddressAddEvent(){
        $aData = array(
        'FTSplCode'             => $this->input->post('ohdSupcode'),
        'FTAddName'             => $this->input->post('oetSplAddName'),
        'FTAddRefNo'            => $this->input->post('oetSplAddRefNo'),
        'FTAddGrpType'          => $this->input->post('oetSplGrpType'),
        'FTAddTaxNo'            => $this->input->post('oetSplAddTaxNo'),
        'FTAddV2Desc1'          => $this->input->post('oetSplAddAddress1'),
        'FTAddV2Desc2'          => $this->input->post('oetSplAddAddress2'),
        'FTAddWebsite'          => $this->input->post('oetSplAddWeb'),
        'FTAddRmk'              => $this->input->post('oetSplAddNote'),
        'FNLngID'               => $this->session->userdata("tLangEdit"),
        'FTAddLongitude'        => $this->input->post("oetCmpMapLong"),
        'FTAddLatitude'         => $this->input->post("oetCmpMapLat"),//จบฟอร็มสั้น
        'FTAddCountry'          => $this->input->post("oetSplAddCountry"),//เริ่มฟอร์มยาว
        // 'FTAreCode'             => $this->input->post("oetSplZneCode"),
        'FTAddV1PvnCode'        => $this->input->post("oetAddPvnCode"),
        'FTAddV1DstCode'        => $this->input->post("oetAddDstCode"),
        'FTAddV1SubDist'        => $this->input->post("oetAddSubDistCode"),
        'FTAddV1No'             => $this->input->post("oetSplAddHomeNo"),
        'FTAddV1Village'        => $this->input->post("oetSplAddvillage"),
        'FTAddV1Road'           => $this->input->post("oetSplAddRoad"),
        'FTAddV1Soi'            => $this->input->post("oetSplAddAlley"),
        'FTAddV1PostCode'       => $this->input->post("oetSplAddZipCode"),
        'FDCreateOn'            => date('Y-m-d H:i:s'),
        'FTCreateBy'            => $this->session->userdata('tSesUsername'),
        'FTAddVersion'          => $this->input->post("ohdVersion")

        );
        $this->mSupplier->FSaMSPLAddAddress($aData);

    }

    //Functionality : Event Add Supplier Contact
    //Parameters : Ajax Event
    //Creator : 26/06/2019 Sarun
    //Return : Status Add Event
    //Return Type : String
    public function FSoCSPLContactAddEvent(){
        $aData = array(
        'FTSplCode'             => $this->input->post('ohdSupcode'),
        'FTCtrName'             => $this->input->post('oetCtrAddName'),
        'FTCtrEmail'            => $this->input->post('oetCtrAddEmail'),
        'FTCtrTel'              => $this->input->post('oetCtrAddTel'),
        'FTCtrFax'              => $this->input->post('oetCtrAddFax'),
        'FTCtrRmk'              => $this->input->post('oetCtrAddNote'),
        'FNLngID'               => $this->session->userdata("tLangEdit"),
        'FDCreateOn'            => date('Y-m-d H:i:s'),
        'FTCreateBy'            => $this->session->userdata('tSesUsername'),
        );
        $tTextConfirm = $this->mSupplier->FSaMSPLAddContact($aData);
    }

    public function FSoCSPLAddressEditEvent(){
        $aData = array(
        'FTSplCode'          => $this->input->post('ohdSupcode'),
        'ohdSeqNo'           => $this->input->post('ohdSeqNo'),
        'FNLngID'            => $this->session->userdata("tLangEdit"),
        'FTAddName'          => $this->input->post('oetSplAddName'),
        'FTAddRefNo'         => $this->input->post('oetSplAddRefNo'),
        'FTAddGrpType'       => $this->input->post('oetSplGrpType'),
        'FTAddTaxNo'         => $this->input->post('oetSplAddTaxNo'),
        'FTAddV2Desc1'       => $this->input->post('oetSplAddAddress1'),
        'FTAddV2Desc2'       => $this->input->post('oetSplAddAddress2'),
        'FTAddWebsite'       => $this->input->post('oetSplAddWeb'),
        'FTAddRmk'           => $this->input->post('oetSplAddNote'),
        'FTAddLongitude'     => $this->input->post("oetCmpMapLong"),
        'FTAddLatitude'      => $this->input->post("oetCmpMapLat"),
        //จบฟอร์มสั้น
        'FTAddV1No'          => $this->input->post("oetSplAddHomeNo"),
        'FTAddV1Soi'         => $this->input->post("oetSplAddAlley"),
        'FTAddV1Village'     => $this->input->post("oetSplAddvillage"),
        'FTAddV1Road'        => $this->input->post("oetSplAddRoad"),
        'FTAddV1SubDist'     => $this->input->post("oetAddSubDistCode"),
        'FTAddV1DstCode'     => $this->input->post("oetAddDstCode"),
        'FTAddV1PvnCode'     => $this->input->post("oetAddPvnCode"),
        'FTAddV1PostCode'    => $this->input->post("oetSplAddZipCode"),
        'FTAddCountry'       => $this->input->post("oetSplAddCountry"),


        'FDLastUpdOn' => date('Y-m-d H:i:s'),
        'FTLastUpdBy' => $this->session->userdata('tSesUsername')
        );
        $this->mSupplier->FSaMSPLUpdateAddress($aData);

    }

    public function FSoCSPLContactEditEvent(){
        $aData = array(
        'FTSplCode'          => $this->input->post('ohdSupcode'),
        'ohdSeqNo'           => $this->input->post('ohdSeqNo'),
        'FNLngID'            => $this->session->userdata("tLangEdit"),
        'FTCtrName'          => $this->input->post('oetCtrAddName'),
        'FTCtrEmail'         => $this->input->post('oetCtrAddEmail'),
        'FTCtrTel'           => $this->input->post('oetCtrAddTel'),
        'FTCtrFax'           => $this->input->post('oetCtrAddFax'),
        'FTCtrRmk'           => $this->input->post('oetCtrAddNote'),

        'FDLastUpdOn' => date('Y-m-d H:i:s'),
        'FTLastUpdBy' => $this->session->userdata('tSesUsername')
        );
        $this->mSupplier->FSaMSPLUpdateContact($aData);

    }

    public function FSoCSPLAddressDeleteEvent(){
        try{
            $nSqeNo = $this->input->post('nSqeNo');
            $aDataMaster = array(
                'FNAddSeqNo' => $nSqeNo
            );
            $aResDel        = $this->mSupplier->FSnMSPLAddressDel($aDataMaster);


            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    public function FSoCSPLContactDeleteEvent(){
        try{
            $nSqeNo = $this->input->post('nSqeNo');
            $aDataMaster = array(
                'FNCtrSeq' => $nSqeNo
            );
            $aResDel        = $this->mSupplier->FSnMSPLContactDel($aDataMaster);


            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }



    public function FSvCBCHGenViewAddress($paResList = '',$nCnfAddVersion = ''){

		$nLangResort = $this->session->userdata("tLangID");
		$nLangEdit	 = $this->session->userdata("tLangEdit");

		$aLangHave = FCNaHGetAllLangByTable('TCNMBranch_L');
		$nLangHave = FCNnHSizeOf($aLangHave);

		if($nLangHave > 1){
			if($nLangEdit != ''){
				$nLangEdit = $nLangEdit;
			}else{
				$nLangEdit = $nLangResort;
			}
		}else{
				if(@$aLangHave[0]->nLangList == ''){
					$nLangEdit = '1';
				}else{
					$nLangEdit = $aLangHave[0]->nLangList;
				}
		}

		if(isset($paResList['roItem']['rtBchCode'])){

			$tBchCode = $paResList['roItem']['rtBchCode'];

			$aData = array(
				'FNLngID' 			=> $nLangEdit,
				'FTAddGrpType' 		=> '1',
				'FTAddVersion' 		=> $nCnfAddVersion,
				'FTAddRefCode' 		=> $tBchCode,
			);

			$aCnfAddEdit    = $this->mBranch->FSvMBCHGetAddress($aData);

		}else{
			$tBchCode = '';
			$aCnfAddEdit = '';
		}

		return $aCnfAddEdit;

	}










}
