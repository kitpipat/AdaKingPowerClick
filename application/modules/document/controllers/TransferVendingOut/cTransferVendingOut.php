<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTransferVendingOut extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/company/mCompany');
        $this->load->model('document/TransferVendingOut/mTransferVendingOut');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('authen/login/mLogin');
    }

    public function index($nBrowseType, $tBrowseOption)
    {
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('docTVO/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('docTVO/0/0');
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave();
        $this->load->view('document/TransferVendingOut/wTransferVendingOut', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSvCTVOPageList(){
        $this->load->view('document/TransferVendingOut/wTransferVendingOutList');
    }

    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSvCTVOPageDataTable(){
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');
        $aAlwEvent          = FCNaHCheckAlwFunc('docTVO/0/0');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $nLangEdit = $this->session->userdata("tLangEdit");
        $aData = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'aAdvanceSearch'    => json_decode($tAdvanceSearchData, true)
        );

        $aResList = $this->mTransferVendingOut->FSaMTVOHDList($aData);
        $aGenTable = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $this->load->view('document/TransferVendingOut/wTransferVendingOutDataTable', $aGenTable);
    }

    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSvCTVOPageAdd(){
        $aClearPdtLayoutInTmpParams = [
            'tUserSessionID'    => $this->session->userdata('tSesSessionID'),
            'tDocKey'           => 'TVDTPdtTwxHD'
        ];
        $this->mTransferVendingOut->FSxMTVOClearPdtLayoutInTmp($aClearPdtLayoutInTmpParams);

        $aDataAdd = array(
            'aResult'           =>  array('rtCode' => '99'),
            'aResultOrdDT'      =>  array('rtCode' => '99'),
            'nOptDecimalShow'   =>  FCNxHGetOptionDecimalShow(),
            'nOptScanSku'       =>  FCNnHGetOptionScanSku()
        );
        $this->load->view('document/TransferVendingOut/wTransferVendingOutPageAdd', $aDataAdd);
    }

    /**
     * Functionality : Move DT From Ref Int
     * Parameters : -
     * Creator : 08/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSaCTVOEventMoveDTFromRefInt(){
        
        $aPackData = array(
            'nLangEdit'         => $this->session->userdata("tLangEdit"),
            'tDocNo'            => $this->input->post('tDocNo'),
            'tDocNoRefInt'      => $this->input->post('tDocNoRefInt'),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tSessionID'        => $this->session->userdata('tSesSessionID'),
            'tDocKey'           => 'TVDTPdtTwxHD'
        );
        $aReturn = $this->mTransferVendingOut->FSaMTVOMoveDTFromRefInt($aPackData);
        echo json_encode($aReturn);
    }

    /**
     * Functionality : Add Event
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTVOEventAdd(){
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate    = $this->input->post('oetTVODocDate') . " " . $this->input->post('oetTVODocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTVOAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTVOBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTVODocNo'),
                'FTXthDocType'          => '2', // 1:ใบเติม , 2:ใบคืน
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTVODptCode'),
                'FTXthMerCode'          => $this->input->post('oetTVOMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTVOShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTVOShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTVOPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTVOPosCode'),
                'FTUsrCode'             => $this->input->post('oetTVOUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'          => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetTVOXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetTVOXthRefExtDate') != '' ? $this->input->post('oetTVOXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetTVOXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetTVOXthRefIntDate') != '' ? $this->input->post('oetTVOXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTVORmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTVOXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTVOXthStaRef'),   // Default 0
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTRsnCode'             => ''
            );
            // print_r($aDataMaster);exit;
            $this->db->trans_begin();
            if ($aDataMaster['tIsAutoGenCode'] == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TVDTPdtTwxHD',                           
                    "tDocType"    => '2',                                          
                    "tBchCode"    => $this->input->post('oetTVOBCHCode'),                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                // print_r($aAutogen);exit;
                $aDataMaster['FTXthDocNo']  = $aAutogen[0]["FTXxhDocNo"];
            }

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode'             => $aDataMaster['FTBchCode'],
                'FTXthDocNo'            => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName'          => $this->input->post('oetTVOXthCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetTVOXthTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetTVOXthRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetTVOXthRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetTVOXthQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdTVOXthShipAdd'),
                'FTViaCode'             => $this->input->post('oetTVOViaCode'),
            );

            $this->mTransferVendingOut->FSaMTVOAddUpdateHD($aDataMaster);
            $this->mTransferVendingOut->FSaMTVOAddUpdateHDRef($aAddUpdateHDRefParams);

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo'        => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey'       => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID
            ];
            $this->mTransferVendingOut->FSaMTVOUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $tStaShwPdtInStk = $this->input->post('ocbTUVStaShwPdtInStk');
            $aTempToDTParams = [
                'tDocNo'            => $aDataMaster['FTXthDocNo'],
                'tBchCode'          => $aDataMaster['FTBchCode'],
                'tDocKey'           => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID,
                'tPageControl'      => 'Add',
                'tStaShwPdtInStk'   => isset($tStaShwPdtInStk) ? 'true' : ''
            ];
            $this->mTransferVendingOut->FSaMTVOMoveTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'     => '1',
                    'tStaMessg'     => 'Success Add'
                );
            }

            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Edit Page
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Edit Page
     * Return Type : View
     */
    public function FSvCTVOPageEdit(){
        $tDocNo             = $this->input->post('tDocNo');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $nLangResort        = $this->session->userdata("tLangID");
        $tUsrLogin          = $this->session->userdata('tSesUsername');
        $tUserSessionID     = $this->session->userdata("tSesSessionID");
        $tUserSessionDate   = $this->session->userdata("tSesSessionDate");
        $tUserLevel         = $this->session->userdata('tSesUsrLevel');

        $aAlwEvent = FCNaHCheckAlwFunc('TVO/0/0'); //Control Event
        // Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        // Get Data
        $aGetHDParams = array(
            'tDocNo'    => $tDocNo,
            'nLngID'    => $nLangEdit,
            'tDocKey'   => 'TVDTPdtTwxHD',
        );
        $aResult = $this->mTransferVendingOut->FSaMTVOGetHD($aGetHDParams); // Data TVDTPdtTwxHD

        $aGetHDRefParams = [
            'tDocNo'    => $tDocNo
        ];
        $aDataHDRef = $this->mTransferVendingOut->FSaMGetHDRef($aGetHDRefParams); // Data TVDTPdtTwxHDRef

        $aDTToTempParams = [
            'tDocNo'            => $tDocNo,
            'tDocKey'           => 'TVDTPdtTwxHD',
            'tBchCode'          => isset($aResult['raItems']['FTBchCode']) ? $aResult['raItems']['FTBchCode'] : '',
            'tUserSessionID'    => $tUserSessionID,
            'tUserSessionDate'  => $tUserSessionDate,
            'nLngID'            => $nLangEdit
        ];
        $this->mTransferVendingOut->FSaMTVODTToTemp($aDTToTempParams);

        $aDataEdit = array(
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aResult'           => $aResult,
            'aDataHDRef'        => $aDataHDRef,
            'aAlwEvent'         => $aAlwEvent
        );
        $this->load->view('document/TransferVendingOut/wTransferVendingOutPageAdd', $aDataEdit);
    }

    /**
     * Functionality : Edit Event
     * Parameters : -
     * Creator : 10/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTVOEventEdit(){
        try {
            $tUserSessionID = $this->session->userdata('tSesSessionID');
            $dXthDocDate    = $this->input->post('oetTVODocDate') . " " . $this->input->post('oetTVODocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTVOAutoGenCode'),
                'FTBchCode'             => $this->input->post('oetTVOBCHCode'),
                'FTXthDocNo'            => $this->input->post('oetTVODocNo'),
                'FTXthDocType'          => '2', // 1:ใบเติม , 2:ใบคืน
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => '',
                'FTDptCode'             => $this->input->post('ohdTVODptCode'),
                'FTXthMerCode'          => $this->input->post('oetTVOMchCode'),
                'FTXthShopFrm'          => $this->input->post('oetTVOShpCode'),
                'FTXthShopTo'           => $this->input->post('oetTVOShpCode'),
                'FTXthPosFrm'           => $this->input->post('oetTVOPosCode'),
                'FTXthPosTo'            => $this->input->post('oetTVOPosCode'),
                'FTUsrCode'             => $this->input->post('oetTVOUsrCode'),
                'FTSpnCode'             => '',
                'FTXthApvCode'          => '',  // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXthRefExt'           => $this->input->post('oetTVOXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetTVOXthRefExtDate') != '' ? $this->input->post('oetTVOXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetTVOXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetTVOXthRefIntDate') != '' ? $this->input->post('oetTVOXthRefIntDate') : NULL,
                'FNXthDocPrint'         => 0,
                'FCXthTotal'            => 0, // ยอดรวมก่อนลด
                'FCXthVat'              => '',
                'FCXthVatable'          => '',
                'FTXthRmk'              => $this->input->post('otaTVORmk'),
                'FTXthStaDoc'           => 1,   // 1 after save
                'FTXthStaApv'           => '',
                'FTXthStaPrcStk'        => '',  // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXthStaDelMQ'         => '',
                'FNXthStaDocAct'        => $this->input->post('ocbTVOXthStaDocAct'), // สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => $this->input->post('ostTVOXthStaRef'),   // Default 0
                'FDLastUpdOn'           => date('Y-m-d H:i:s'),
                'FDCreateOn'            => date('Y-m-d H:i:s'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                'FTRsnCode'             => ''
            );

            $this->db->trans_begin();

            // ข้อมูลการขนส่ง
            $aAddUpdateHDRefParams = array(
                'FTBchCode'             => $aDataMaster['FTBchCode'],
                'FTXthDocNo'            => $aDataMaster['FTXthDocNo'],
                'FTXthCtrName'          => $this->input->post('oetTVOXthCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetTVOXthTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetTVOXthRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetTVOXthRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetTVOXthQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdTVOXthShipAdd'),
                'FTViaCode'             => $this->input->post('oetTVOViaCode'),
            );

            $this->mTransferVendingOut->FSaMTVOAddUpdateHD($aDataMaster);
            $this->mTransferVendingOut->FSaMTVOAddUpdateHDRef($aAddUpdateHDRefParams);

            $aUpdateDocNoInTmpParams = [
                'FTXthDocNo'        => $aDataMaster['FTXthDocNo'],
                'FTXthDocKey'       => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID
            ];
            $this->mTransferVendingOut->FSaMTVOUpdateDocNoInTmp($aUpdateDocNoInTmpParams); // Update DocNo ในตาราง Doctemp

            $aTempToDTParams = [
                'tDocNo'            => $aDataMaster['FTXthDocNo'],
                'tBchCode'          => $aDataMaster['FTBchCode'],
                'tDocKey'           => 'TVDTPdtTwxHD',
                'tUserSessionID'    => $tUserSessionID,
                'tPageControl'      => 'Edit',
                'tStaShwPdtInStk'   => ''
            ];
            $this->mTransferVendingOut->FSaMTVOMoveTempToDT($aTempToDTParams); // คัดลอกข้อมูลจาก Temp to DT

            if ( $this->db->trans_status() === FALSE ) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'     => '1',
                    'tStaMessg'     => 'Success Edit'
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTVOEventInsertPdtLayoutToTmp(){
        $aPdtlayoutToTempParams = [
            'tDocNo'            => 'TVODocTemp',
            'tDocKey'           => 'TVDTPdtTwxHD',
            'tBchCode'          => $this->input->post('tBchCode'),
            'tMerCode'          => $this->input->post('tMerCode'),
            'tShpCode'          => $this->input->post('tShpCode'),
            'tWahCodeFrom'      => $this->input->post('tWahCodeFrom'),
            'tPackDataPdt'      => $this->input->post('tPackDataPdt'),
            'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
            'tUserSessionDate'  => $this->session->userdata("tSesSessionDate"),
            'tUserLoginCode'    => $this->session->userdata("tSesUsername"),
            'nLngID'            => $this->session->userdata("tLangEdit")
        ];
        $aResult = $this->mTransferVendingOut->FSaMTVOInsertPdtLayoutToTemp($aPdtlayoutToTempParams);
        echo json_encode($aResult);
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 08/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : Array
     */
    public function FSaCTVOPageDataTablePdtLayout(){
        $aGetPdtLayoutInTmpParams  = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'tSearchAll'        => $this->input->post('tSearchAll'),
            'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
            'tTypePage'         => $this->input->post('tTypePage'),
            'tStaShwPdtInStk'   => $this->input->post('tStaShwPdtInStk')
        );

        $aGenTable = array(
            'aAlwEvent'         => FCNaHCheckAlwFunc('docTVO/0/0'),
            'aDataList'         => $this->mTransferVendingOut->FSaMTVOGetPdtLayoutInTmp($aGetPdtLayoutInTmpParams),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow()
        );
        $this->load->view('document/TransferVendingOut/advance_table/wTransferVendingOutPdtDataTable', $aGenTable);
    }

    /**
     * Functionality : Check Doc No. Duplicate
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStCTopUpVendingUniqueValidate()
    {
        $aStatus = ['bStatus' => false];

        if ($this->input->is_ajax_request()) { // Request check
            $tTopUpVendingDocCode = $this->input->post('tTopUpVendingCode');
            $bIsDocNoDup = $this->mTopupVending->FSbMCheckDuplicate($tTopUpVendingDocCode);

            if ($bIsDocNoDup) { // If have record
                $aStatus['bStatus'] = true;
            }
        } else {
            echo 'Method Not Allowed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($aStatus));
    }

    /**
     * Functionality : Approve Document
     * Parameters : -
     * Creator : 10/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FSaCTVOEventApprove(){
        try {

            $tDocNo         = $this->input->post('tDocNo');
            $tUsrBchCode    = $this->input->post('tBchCode');

            $this->db->trans_begin();
            $aDocApproveParams = array(
                'tDocNo'    => $tDocNo,
                'tApvCode'  => $this->session->userdata('tSesUsername')
            );
            $this->mTransferVendingOut->FSaMTVOEventApprove($aDocApproveParams);

            $aMQParams = [
                "queueName" => "TNFWAREHOSEVD",
                "params" => [
                    "ptBchCode"     => $tUsrBchCode,
                    "ptDocNo"       => $tDocNo,
                    "ptDocType"     => '2',
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);

            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
            echo json_encode($aReturn);
        } catch (\ErrorException $err) {

            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
        }
    }

    /**
     * Functionality : Delete Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteDoc()
    {

        $tDocNo = $this->input->post('tDocNo');

        $this->db->trans_begin();

        $aDelMasterParams = [
            'tDocNo' => trim($tDocNo)
        ];
        $this->mTopupVending->FSaMDelMaster($aDelMasterParams);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FStTopUpVendingDeleteMultiDoc()
    {
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();

        foreach ($aDocNo as $aItem) {
            $aDelMasterParams = [
                'tDocNo' => trim($aItem)
            ];
            $this->mTopupVending->FSaMDelMaster($aDelMasterParams);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return json_encode($aStatus);
    }

    /**
     * Functionality : Update PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTVOTopupVendingUpdatePdtLayoutInTmp()
    {
        $nQty = $this->input->post('nQty');
        $nSeqNo = $this->input->post('nSeqNo');
        $tPdtCode = $this->input->post('tPdtCode');
        $tPosCode = $this->input->post('tPosCode');
        $tBchCode = $this->input->post('tBchCode');
        $tWahCode = $this->input->post('tWahCode');
        $tUserSessionID = $this->session->userdata("tSesSessionID");
        $tUserLoginCode = $this->session->userdata("tSesUsername");

        $aGetWahByShopParams = [
            'tRefCode' => $tPosCode,
            'tBchCode' => $tBchCode
        ];
        $aWahByPos = $this->mTopupVending->FSaMGetWahByRefCode($aGetWahByShopParams);

        $aGetPdtStkBalWithCheckInTmp = [
            'tBchCode' => $tBchCode,
            'tWahCode' => FCNtAddSingleQuote($tWahCode), // คลังสินค้าต้นทาง เพื่อใช้ในการเติมให้กับ คลังตู้สินค้า
            'tPdtCode' => $tPdtCode,
            'tUserSessionID' => $tUserSessionID,
            'nNotInSelfSeqNo' => $nSeqNo
        ];
        $nStkBal = $this->mTopupVending->FSnGetPdtStkBalWithCheckInTmp($aGetPdtStkBalWithCheckInTmp);
        
        if ($nQty <= $nStkBal) {

            $aUpdateQtyInTmpBySeqParams = [
                'cQty' => $nQty,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID,
                'nSeqNo' => $nSeqNo,
            ];
            $this->mTopupVending->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        } else {
            $aUpdateQtyInTmpBySeqParams = [
                'cQty' => ($nStkBal<0)?0:$nStkBal,
                'tUserLoginCode' => $tUserLoginCode,
                'tUserSessionID' => $tUserSessionID,
                'nSeqNo' => $nSeqNo,
            ];
            $this->mTopupVending->FSbUpdateQtyInTmpBySeq($aUpdateQtyInTmpBySeqParams);
        }
    }

    /**
     * Functionality : Delete PDT Layout in Temp
     * Parameters : -
     * Creator : 09/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSxCTVOEventDeletePdtLayoutInTmp(){
        $aDeleteInTmpBySeqParams = [
            'tUserSessionID'    => $this->session->userdata("tSesSessionID"),
            'nSeqNo'            => $this->input->post('nSeqNo'),
        ];
        $this->mTransferVendingOut->FSbTVOEventDeleteInTmpBySeq($aDeleteInTmpBySeqParams);
    }

    /**
     * Functionality : Get Wah by Shp
     * Parameters : -
     * Creator : 04/02/2020 piya
     * Last Modified : -
     * Return : Wah Data
     * Return Type : String
     */
    public function FStGetWahByShop()
    {
        $tShpCode = $this->input->post('tShpCode');
        $tBchCode = $this->input->post('tBchCode');

        $aGetWahByShopParams = [
            'tRefCode' => $tShpCode,
            'tBchCode' => $tBchCode
        ];
        $aWahByShp = $this->mTopupVending->FSaMGetWahByRefCode($aGetWahByShopParams);
        
        // $aDataDT = $this->mTopupVending->FSaMTFWGetDT($aDataWhere); // Data TVDTPdtTwxDT
        // $aStaIns = $this->mTopupVending->FSaMTFWInsertDTToTemp($aDataDT,$aDataWhere); // Insert Data DocTemp

        $aWahCodeByShp = [];
        $aWahNameByShp = [];

        foreach ($aWahByShp as $aValue) {
            $aWahCodeByShp[] = $aValue['FTWahCode'];
            $aWahNameByShp[] = $aValue['FTWahName'];
        }

        $tWahCodeByShp = FCNtArrayToString($aWahCodeByShp);
        $tWahNameByShp = FCNtArrayToString($aWahNameByShp);

        $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode(['tWahCodeByShp' => $tWahCodeByShp, 'tWahNameByShp' => $tWahNameByShp]));
    }

    // Create By : 10/09/2020 Napat(Jame)
    public function FSvCTVOEventEditInline(){
        $aDataUpdateInLine  = array(
            'tField'        => $this->input->post('ptField'),
            'tValue'        => $this->input->post('pnVal')
        );

        $aDataWhereUpdInLine    = array(
            'FTXthDocNo'    => 'TVODocTemp', /*$this->input->post('ptDocNo')*/
            'FTXthDocKey'   => 'TVDTPdtTwxHD',
            'FNXtdSeqNo'    => $this->input->post('pnSeq'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID')
        );
        $aResUpd = $this->mTransferVendingOut->FSaMTVOEventEditInLine($aDataUpdateInLine,$aDataWhereUpdInLine);
        echo json_encode($aResUpd);
    }

    //ยกเลิกเอกสาร
    public function FStCTVOEventDocCancel(){
        $tDocNo = $this->input->post('tDocNo');
        $this->db->trans_begin();
        $aDocCancelParams = array(
            'tDocNo' => $tDocNo
        );
        $aStaCancel = $this->mTransferVendingOut->FSaMTVOEventDocCancel($aDocCancelParams);
        if ($aStaCancel['rtCode'] == 1) {
            $this->db->trans_commit();
            $aCancel = array(
                'nSta' => 1,
                'tMsg' => "Cancel Success",
            );
        } else {
            $this->db->trans_rollback();
            $aCancel = array(
                'nSta' => 2,
                'tMsg' => "Cancel Fail",
            );
        }
        echo json_encode($aCancel);
    }


    // Functionality : ลบข้อมูล Table DT Temp ALL
    // Creator : 17/02/2022 Wasin (Yoshi)
    public function FSaCTVOEventDelDTTempAll(){
        $tSessionID = $this->session->userdata("tSesSessionID");
        $aDataDelDT = array(
            'FTBchCode'     => $this->input->post('tBchCode'),
            'FTXthDocKey'   => 'TVDTPdtTwxHD',
            'FTXthDocNo'    => 'TVODocTemp',
            'FTSessionID'   => $tSessionID,
        );
        $aStaDelete = $this->mTransferVendingOut->FSxMTVDDelDTTempAll($aDataDelDT);
        echo json_encode($aStaDelete);
    }


}
