<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cRecive extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment/recive/mRecive');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        //Controle Event
        $aAlwEvent = FCNaHCheckAlwFunc('recive/0/0');
        //Controle Event
        $vBtnSave = FCNaHBtnSaveActiveHTML('recive/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view('payment/recive/wRecive', array(
            'vBtnSave'      => $vBtnSave,
            'aAlwEventRecive'     => $aAlwEvent,
            'nBrowseType'  =>  $nBrowseType,
            'tBrowseOption' =>  $tBrowseOption
        ));
    }

    //Functionality : Function Call Recive Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 08/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRCVListPage()
    {
        $this->load->view('payment/recive/wReciveList');
    }

    //Functionality : Function Call DataTables Reason List
    //Parameters : Ajax jReason()
    //Creator : 25/05/2018 wasin
    //Update : 28/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRCVDataList()
    {
        $aAlwEvent = FCNaHCheckAlwFunc('recive/0/0');

        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TFNMRcv_L');
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
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aResList       = $this->mRecive->FSaMRCVList($tAPIReq, $tMethodReq, $aData);

        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll
        );
        
        // echo "<pre>";
        // print_r ($aGenTable);
        // echo "</pre>";
        
        $this->load->view('payment/recive/wReciveDataTable', $aGenTable);
    }

    //Functionality : Function CallPage Recive Add
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRCVAddPage()
    {
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave = FCNaHGetAllLangByTable('TFNMRcv_L');
        // $nLangHave = FCNnHSizeOf($aLangHave);
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
        $aRcvFmtData    = $this->mRecive->FSaMRCVFormat($tAPIReq, $tMethodReq, $aData);
        $tSelected      = $this->FSaRCVDropdown('', 'ocmRcvFormat', $aRcvFmtData);
        $aDataAdd = array(
            'aResult'   => array('rtCode' => '99', 'rtSelected' => $tSelected)
        );
        $this->load->view('payment/recive/wReciveAdd', $aDataAdd);
    }

    //Functionality : Function CallPage Recive Edit
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvRCVEditPage()
    {
        $aAlwEventRecive    = FCNaHCheckAlwFunc('recive/0/0');
        $tRcvCode           = $this->input->post('tRcvCode');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aData              = [
            'FTRcvCode' => $tRcvCode,
            'FNLngID'   => $nLangEdit
        ];
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aRcvData       = $this->mRecive->FSaMRCVSearchByID($tAPIReq, $tMethodReq, $aData);

        //Create Selecte Box --
        $aRcvFmtData    = $this->mRecive->FSaMRCVFormat($tAPIReq, $tMethodReq, $aData);
        $nRcvFmtId      = ($aRcvData['rtCode'] == '1') ? $aRcvData['raItems']['rtFmtCode'] : "";
        $tSelected      = $this->FSaRCVDropdown($nRcvFmtId, 'ocmRcvFormat', $aRcvFmtData);
        if ($tSelected != '') {
            // ทำการยัด Array RtDropdown เข้าในตัวแปร $aResList
            $aRcvData = array_merge($aRcvData, array('rtSelected' => $tSelected));
        }
        $aDataEdit = array(
            'aResult'           => $aRcvData,
            'aAlwEventRecive'   => $aAlwEventRecive,
            'tImgObjAll'        => $aRcvData['raItems']['rtImgObj'],
        );
        
        // echo "<pre>";
        // print_r ($aDataEdit['aResult']);
        // echo "</pre>";
        // exit;
        
        $this->load->view('payment/recive/wReciveAdd', $aDataEdit);
    }

    //Functionality : Function Create Selected
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSaRCVDropdown($ptRntID, $ptIDname, $poData)
    {
        //Parameters : $ptRntID = ข้อมูลที่ใช้เช็คทำ Selected(EDIT),$ptIDname = ชื่อ ID กับ Name,$poData = ข้อมูลที่ใช้ทำ Dropdown

        $tDropdown  = "<select class='selectpicker form-control' id='" . $ptIDname . "' name='" . $ptIDname . "' maxlength='1'>";

        if ($poData['rtCode'] == '1') {
            foreach ($poData['raItems'] as $key => $aValue) {
                $selected = ($ptRntID != '' && $ptRntID == $aValue['rtFmtCode']) ? 'selected' : '';
                $tDropdown .= "<option value='" . $aValue['rtFmtCode'] . "' " . $selected . ">" . $aValue['rtFmtName'] . "</option>";
            }
        }
        $tDropdown  .= "</select>";

        // $tDropdown  = "<select class='selection-2' id='".$ptIDname."' name='".$ptIDname."' >
        //                     <option value=''>".language('common/main/main', 'tCMNBlank-NA')."</option>";
        // if($poData['rtCode']=='1'){
        //     foreach($poData['raItems'] AS $key=>$aValue){
        //         $selected = ($ptRntID!='' && $ptRntID == $aValue['rtFmtCode'])? 'selected':'';
        //         $tDropdown .= "<option value='".$aValue['rtFmtCode']."' ".$selected.">".$aValue['rtFmtName']." [".$aValue['rtFmtKey']."]"."</option>";
        //     }
        // }
        // $tDropdown  .= "</select>";
        return $tDropdown;
    }

    //Functionality : Event Add Recive
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : 12/08/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSaRCVAddEvent()
    {
        /** ============================= Image Inpu Data ============================= */
        $tImgInputRate      = $this->input->post('oetImgInputRate');
        $tImgInputRateOld   = $this->input->post('oetImgInputRateOld');
        /** ============================= Image Inpu Data ============================= */
        $tIsAutoGenCode =   $this->input->post('ocbReciveAutoGenCode');
        // Setup Reason Code
        $tRcvCode = "";
        if (isset($tIsAutoGenCode) && $tIsAutoGenCode == '1') {
            // Call Auto Gencode Helper
            // $aGenCode = FCNaHGenCodeV5('TFNMRcv','0');
            // if($aGenCode['rtCode'] == '1'){
            // $tRcvCode = $aGenCode['rtRcvCode'];
            // }
            // Update new gencode
            // 15/05/2020 Nattakit(Nale)
            $aStoreParam = array(
                "tTblName"    => 'TFNMRcv',
                "tDocType"    => 0,
                "tBchCode"    => "",
                "tShpCode"    => "",
                "tPosCode"    => "",
                "dDocDate"    => date("Y-m-d H:i:s")
            );
            $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
            $tRcvCode   = $aAutogen[0]["FTXxhDocNo"];
        } else {
            $tRcvCode = $this->input->post('oetRcvCode');
        }

        $tRcvStaUse   = $this->input->post('ocbRcvStatus');

        if (isset($tRcvStaUse) && !empty($tRcvStaUse)) {
            $tRcvStaUse  = $this->input->post('ocbRcvStatus');
        } else {
            $tRcvStaUse  = 2;
        }

        //เช็คประเภทชำระกับคูปอง
        $tRcvFormatCode = $this->input->post('oetRcvFormatCode');
        $tRcvReadCardCode = $this->input->post('oetRcvReadCardCode');
        $tRcvCouponCode = $this->input->post('oetRcvCouponCode');
        if ($tRcvFormatCode != 4) {
            $tRcvCouponCode = '';
        }else{
            $tRcvCouponCode = $this->input->post('oetRcvCouponCode');
        }

        $aDataMaster    = [
            'FTRcvCode'     => $tRcvCode,
            'FTFmtCode'     => $tRcvFormatCode,
            'FTRcvRefEdc'   => $tRcvReadCardCode,
            'FTRcvStaUse'   => $tRcvStaUse,
            'FTRcvName'     => $this->input->post('oetRcvName'),
            'FTRcvRmk'      => $this->input->post('otaRcvRemark'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FDCreateOn'    => date('Y-m-d H:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAgnCode'     => $this->input->post('oetRCVUsrAgnCode'),
            'FTRcvRefDoc'     => $tRcvCouponCode,
            'FNRcvQtySlip'     => $this->input->post('oetRCVNumCopyReceipt'),
            'FTRcvRefExt'     => $this->input->post('oetRcvExtRefCode'),
            'FTRcvStaCshOrCrd'     => $this->input->post('ocbRcvStaPayType'),

            'FTAppStaAlwRet'    => (!empty($this->input->post('ocbRcvSpcStaAlwRet'))) ? 1 : 2,
            'FTAppStaAlwCancel' => (!empty($this->input->post('ocbRcvSpcStaAlwCancel'))) ? 1 : 2,
            'FTAppStaPayLast'   => (!empty($this->input->post('ocbRcvSpcStaPayLast'))) ? 1 : 2,
            'FTRcvStaAlwAccPoint'    => (!empty($this->input->post('ocbRcvSpcStaAlwAccPoint'))) ? 1 : 2,
            'FTRcvStaAlwDrawer' => (!empty($this->input->post('ocbRcvSpcStaOpnDrawer'))) ? 1 : 2,
            'FTRcvStaReason'   => (!empty($this->input->post('ocbRcvSpcIdcReaPayment'))) ? 1 : 2,
            'FTRcvStaShwSum'    => $this->input->post('ocbRcvStaShwSum'),
        ];

        $oCountDup = $this->mRecive->FSoMRCVCheckDuplicate($tRcvCode);
        if (isset($oCountDup[0]->counts)) {
          $nStaDup    = $oCountDup[0]->counts;
        }else {
          $nStaDup    = 0;
        }
        
        if ($nStaDup == 0) {
            $this->db->trans_begin();

            $this->mRecive->FSaMRCVAddUpdateMaster($aDataMaster);
            $this->mRecive->FSaMRCVAddUpdateLang($aDataMaster);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                if ($tImgInputRate != $tImgInputRateOld) {
                    $aImageData = [
                        'tModuleName'       => 'payment',
                        'tImgFolder'        => 'recive',
                        'tImgRefID'         => $aDataMaster['FTRcvCode'],
                        'tImgObj'           => $tImgInputRate,
                        'tImgTable'         => 'TFNMRcv',
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
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTRcvCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add Event'
                );
            }
        } else {
            $aReturn = array(
                'nStaEvent'    => '801',
                'tStaMessg'    => "Data Code Duplicate"
            );
        }
        echo json_encode($aReturn);
    }

    //Functionality : Event Edit Recive
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : 12/08/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSaRCVEditEvent()
    {
        $this->db->trans_begin();
        /** ============================= Image Inpu Data ============================= */
        $tImgInputRate      = $this->input->post('oetImgInputRate');
        $tImgInputRateOld   = $this->input->post('oetImgInputRateOld');
        /** ============================= Image Inpu Data ============================= */
        $tRcvStaUse     = $this->input->post('ocbRcvStatus');
        if ($tRcvStaUse  = 'on' && empty($tRcvStaUse)) {
            $tRcvStaUse = '1';
        } else {
            $tRcvStaUse = $this->input->post('ocbRcvStatus');
        }

        //เช็คประเภทชำระกับคูปอง
        $tRcvFormatCode = $this->input->post('oetRcvFormatCode');
        $tRcvReadCardCode = $this->input->post('oetRcvReadCardCode');
        $tRcvCouponCode = $this->input->post('oetRcvCouponCode');
        if ($tRcvFormatCode != 4) {
            $tRcvCouponCode = '';
        }else{
            $tRcvCouponCode = $this->input->post('oetRcvCouponCode');
        }
        $aDataMaster    = [
            'FTRcvCode'     => $this->input->post('oetRcvCode'),
            'FTFmtCode'     => $tRcvFormatCode,
            'FTRcvRefEdc'   => $tRcvReadCardCode,
            'FTRcvStaUse'   => $tRcvStaUse,
            'FTRcvName'     => $this->input->post('oetRcvName'),
            'FTRcvRmk'      => $this->input->post('otaRcvRemark'),
            'FDLastUpdOn'   => date('Y-m-d H:i:s'),
            'FDCreateOn'    => date('Y-m-d H:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAgnCode'     => $this->input->post('oetRCVUsrAgnCode'),
            'FTRcvRefDoc'     => $tRcvCouponCode,
            'FNRcvQtySlip'     => $this->input->post('oetRCVNumCopyReceipt'),
            'FTRcvRefExt'     => $this->input->post('oetRcvExtRefCode'),
            'FTRcvStaCshOrCrd'     => $this->input->post('ocbRcvStaPayType'),

            'FTAppStaAlwRet'    => (!empty($this->input->post('ocbRcvSpcStaAlwRet'))) ? 1 : 2,
            'FTAppStaAlwCancel' => (!empty($this->input->post('ocbRcvSpcStaAlwCancel'))) ? 1 : 2,
            'FTAppStaPayLast'   => (!empty($this->input->post('ocbRcvSpcStaPayLast'))) ? 1 : 2,
            'FTRcvStaAlwAccPoint'    => (!empty($this->input->post('ocbRcvSpcStaAlwAccPoint'))) ? 1 : 2,
            'FTRcvStaAlwDrawer' => (!empty($this->input->post('ocbRcvSpcStaOpnDrawer'))) ? 1 : 2,
            'FTRcvStaReason'   => (!empty($this->input->post('ocbRcvSpcIdcReaPayment'))) ? 1 : 2,
            'FTRcvStaShwSum'    => $this->input->post('ocbRcvStaShwSum'),
        ];
        $this->mRecive->FSaMRCVAddUpdateMaster($aDataMaster);
        $this->mRecive->FSaMRCVAddUpdateLang($aDataMaster);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Edit Event"
            );
        } else {
            $this->db->trans_commit();
            if ($tImgInputRate != $tImgInputRateOld) {
                $aImageData = [
                    'tModuleName'       => 'payment',
                    'tImgFolder'        => 'recive',
                    'tImgRefID'         => $aDataMaster['FTRcvCode'],
                    'tImgObj'           => $tImgInputRate,
                    'tImgTable'         => 'TFNMRcv',
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
                'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'    => $aDataMaster['FTRcvCode'],
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Add Event'
            );
            $aReturn = array(
                'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'    => $aDataMaster['FTRcvCode'],
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success Add Event'
            );
        }
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Recive
    //Parameters : Ajax jReason()
    //Creator : 11/05/2018 wasin
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaRCVDeleteEvent()
    {
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTRcvCode' => $tIDCode
        );
        $tAPIReq        = 'API/Reason/Delete';
        $tMethodReq     = 'POST';
        $aResDel        = $this->mRecive->FSnMRCVDel($tAPIReq, $tMethodReq, $aDataMaster);
        $nNumRowRcvLoc  = $this->mRecive->FSnMLOCGetAllNumRow();
        if ($aResDel['rtCode'] == 1) {
            $aDeleteImage = array(
                'tModuleName'  => 'payment',
                'tImgFolder'   => 'recive',
                'tImgRefID'    =>  $aDataMaster['FTRcvCode'],
                'tTableDel'    => 'TCNMImgObj',
                'tImgTable'    => 'TFNMRcv'
            );
            $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
            if ($nStaDelImgInDB == 1) {
                FSnHDeleteImageFiles($aDeleteImage);
            }
        }
        if ($nNumRowRcvLoc) {
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRcvLoc' => $nNumRowRcvLoc
            );
        } else {
            $aReturn    = array(
                'nStaEvent'     => 500,
                'tStaMessg'     => 'Error Delete Error.!!!'
            );
        }
        echo json_encode($aReturn);
    }
}
