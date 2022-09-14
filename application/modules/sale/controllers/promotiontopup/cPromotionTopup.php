<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cPromotionTopup extends MX_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('sale/promotiontopup/mPromotionTopup');
    }

    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('docPTU/0/0');
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('docPTU/0/0');
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave();
        $this->load->view('sale/promotiontopup/wPromotionTopup', $aData);
    }

    /**
     * Functionality : Main Page List
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : List Page
     * Return Type : View
     */
    public function FSxCPTUPageList(){
        $this->load->view('sale/promotiontopup/wPromotionTopupList');
    }

    
    /**
     * Functionality : Get HD Table List
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : HD Table List
     * Return Type : View
     */
    public function FSvCPTUPageDataTable(){
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');
        $aData = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'nPage'             => $nPage,
            'nRow'              => 10,
            'aAdvanceSearch'    => json_decode($tAdvanceSearchData, true),
            'tShowStatus'       => $this->input->post('tShowStatus')
        );
        $aGenTable = array(
            'aAlwEvent'         => FCNaHCheckAlwFunc('docPTU/0/0'),
            'aDataList'         => $this->mPromotionTopup->FSaMPTUHDList($aData),
            'nPage'             => $nPage,
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow()
        );
        $this->load->view('sale/promotiontopup/wPromotionTopupDatatable', $aGenTable);
    }

    /**
     * Functionality : Delete Multiple Document
     * Parameters : -
     * Creator : 18/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Status
     * Return Type : String
     */
    public function FSaCPTUEventDeleteDoc(){
        $aDocNo = $this->input->post('aDocNo');

        $this->db->trans_begin();
        $this->mPromotionTopup->FSxMPTUDeleteDoc($aDocNo);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aStatus = array(
                'tCode' => '905',
                'tDesc' => $this->db->error()['message'],
            );
        } else {
            $this->db->trans_commit();
            $aStatus = array(
                'tCode' => '1',
                'tDesc' => 'Delete Complete.',
            );
        }
        echo json_encode($aStatus);
    }

    
    /**
     * Functionality : Add Page
     * Parameters : -
     * Creator : 18/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : Add Page
     * Return Type : View
     */
    public function FSvCPTUPageAdd(){
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserLevel     = $this->session->userdata("tSesUsrLevel");
        $tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
        $bIsMultiBch = $this->session->userdata("nSesUsrBchCount");
        // Clear Temp
        $this->mPromotionTopup->FSxMPTUClearInTmp($tUserSessionID);
        $tHDBchCode = '';
                /*===== Begin Control สาขาที่สร้าง ================================================*/
        if ($bIsMultiBch ==  1) {
            $tHDBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
        }


        // ถ้าเข้ามาระดับต่ำกว่า HQ ให้เพิ่ม HDBch ไว้ auto 1 รายการ
        $tSesUsrLevel = $this->session->userdata("tSesUsrLevel");
        if( $tSesUsrLevel != "HQ" ){
            $tSesUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
            if( $tSesUsrAgnCode != "" ){
                $aDataUpd = array(
                    'tDocNo'            => 'PTUTEMP',
                    'tBchCode'          => $this->session->userdata("tSesUsrBchCodeDefault"),
                    'tHDAgnCode'        => $tSesUsrAgnCode,
                    'tHDBchCode'        => $tHDBchCode,
                    'tHDMerCode'        => '',
                    'tHDShpCode'        => '',
                    'tStaType'          => '1',
                    'nSeq'              => 1,
                    'tDocKey'           => 'TFNTCrdPmtHDBch',
                    'tUserSessionID'    => $this->session->userdata('tSesSessionID')
                );
                $this->mPromotionTopup->FSaMPTUStep3AddEditHDBch($aDataUpd);
            }
        }

        $aDataAdd = array(
            'aResult' =>  array('tCode' => '99')
        );
        $this->load->view('sale/promotiontopup/wPromotionTopupAdd', $aDataAdd);
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSvCPTUPageEdit(){
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserLevel     = $this->session->userdata("tSesUsrLevel");
        $tDocNo         = $this->input->post("tDocNo");

        // Clear Temp
        $this->mPromotionTopup->FSxMPTUClearInTmp($tUserSessionID);

        // Move Master To Temp
        $aDataTmp = array(
            'tDocNo'            => $tDocNo,
            'tUserSessionID'    => $tUserSessionID,
        );
        $this->mPromotionTopup->FSxMPTUEventMoveMasterToTmp($aDataTmp);

        // Get HD
        $aDataGetHD = array(
            'FNLngID'   => $this->session->userdata("tLangEdit"),
            'tDocNo'    => $tDocNo,
        );
        
        $aDataAdd = array(
            'aResult' =>  $this->mPromotionTopup->FSaMPTUEventGetHD($aDataGetHD)
        );
        $this->load->view('sale/promotiontopup/wPromotionTopupAdd', $aDataAdd);
    }

    /**
     * Functionality : DataTable Step 1
     * Parameters : -
     * Creator : 22/09/2020 Napat(Jame)
     * Last Modified : -
     * Return : DataTable
     * Return Type : View
     */
    public function FSvCPTUPageStep1DataTable(){
        $aDataSearch = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'tDocKey'           => 'TFNTCrdPmtDT',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aDataReturn = array(
            'aDataList' => $this->mPromotionTopup->FSxMPTUDTList($aDataSearch)
        );
        $this->load->view('sale/promotiontopup/advancetable/wPromotionTopupStep1DataTable', $aDataReturn);
    }

    //Creator : 22/09/2020 Napat(Jame)
    public function FSaCPTUEventStep1AddEditCardType(){
        $aDataUpd = array(
            'tDocNo'            => ( empty($this->input->post('tDocNo')) ? 'PTUTEMP' : $this->input->post('tDocNo') ),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tCtyCode'          => $this->input->post('tCtyCode'),
            'tStaType'          => $this->input->post('tStaType'),
            'tDocKey'           => 'TFNTCrdPmtDT',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aStatus = $this->mPromotionTopup->FSaMPTUStep1AddEditCardType($aDataUpd);
        echo json_encode($aStatus);
    }

    //Creator : 23/09/2020 Napat(Jame)
    public function FSaCPTUEventStepDelete(){
        $aData = array(
            'tDocNo'            => ( empty($this->input->post('tDocNo')) ? 'PTUTEMP' : $this->input->post('tDocNo') ),
            'tBchCode'          => $this->input->post('tBchCode'),
            'nSeq'              => $this->input->post('nSeq'),
            'tDocKey'           => $this->input->post('tDocKey'),
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aStatus = $this->mPromotionTopup->FSaMPTUEventStepDelete($aData);
        echo json_encode($aStatus);
    }

    //Creator : 23/09/2020 Napat(Jame)
    public function FSvCPTUPageStep2DataTable(){
        $aDataSearch = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'tDocKey'           => 'TFNTCrdPmtCD',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aDataReturn = array(
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'aDataList'         => $this->mPromotionTopup->FSxMPTUCDList($aDataSearch)
        );
        $this->load->view('sale/promotiontopup/advancetable/wPromotionTopupStep2DataTable', $aDataReturn);
    }

    //Creator : 24/09/2020 Napat(Jame)
    public function FSaCPTUEventStep2AddRow(){
        $aData = array(
            'tDocNo'            => ( empty($this->input->post('tDocNo')) ? 'PTUTEMP' : $this->input->post('tDocNo') ),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tDocKey'           => 'TFNTCrdPmtCD',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aStatus = $this->mPromotionTopup->FSaMPTUEventStep2AddRow($aData);
        echo json_encode($aStatus);
    }

    //Creator : 24/09/2020 Napat(Jame)
    public function FSaCPTUEventStep2EditInline(){
        $aData = array(
            'tDocNo'            => ( empty($this->input->post('tDocNo')) ? 'PTUTEMP' : $this->input->post('tDocNo') ),
            'tBchCode'          => $this->input->post('tBchCode'),
            'nSeq'              => $this->input->post('nSeq'),
            'nVal'              => $this->input->post('nVal'),
            'tField'            => $this->input->post('tField'),
            'tPrefix'           => $this->input->post('tPrefix'),
            'tDocKey'           => 'TFNTCrdPmtCD',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aStatus = $this->mPromotionTopup->FSaMPTUEventStep2EditInline($aData);
        echo json_encode($aStatus);
    }

    //Creator : 25/09/2020 Napat(Jame)
    public function FSvCPTUPageStep3DataTable(){
        $aDataSearch = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'tDocKey'           => 'TFNTCrdPmtHDBch',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aDataReturn = array(
            'aDataList'         => $this->mPromotionTopup->FSaMPTUHDBchList($aDataSearch)
        );
        $this->load->view('sale/promotiontopup/advancetable/wPromotionTopupStep3DataTable', $aDataReturn);
    }

    //Creator : 25/09/2020 Napat(Jame)
    //Last Update : 21/12/2020 Napat(Jame)
    public function FSaCPTUEventStep3AddEditHDBch(){
        $aDataUpd = array(
            'tDocNo'            => ( empty($this->input->post('tDocNo')) ? 'PTUTEMP' : $this->input->post('tDocNo') ),
            'tBchCode'          => $this->input->post('tBchCode'),
            'tHDAgnCode'        => $this->input->post('tHDAgnCode'),
            'tHDBchCode'        => $this->input->post('tHDBchCode'),
            'tHDMerCode'        => $this->input->post('tHDMerCode'),
            'tHDShpCode'        => $this->input->post('tHDShpCode'),
            'tStaType'          => $this->input->post('tStaType'),
            'nSeq'              => $this->input->post('nSeq'),
            'tDocKey'           => 'TFNTCrdPmtHDBch',
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aStatus = $this->mPromotionTopup->FSaMPTUStep3AddEditHDBch($aDataUpd);
        echo json_encode($aStatus);
    }

    //Creator : 25/09/2020 Napat(Jame)
    public function FSvCPTUPageStep4CheckAndConfirm(){
        $aDataSearch = array(
            'FNLngID'           => $this->session->userdata("tLangEdit"),
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );
        $aDataReturn = array(
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'aDataList'         => $this->mPromotionTopup->FSaMPTUStep4CheckAndConfirm($aDataSearch)
        );
        $this->load->view('sale/promotiontopup/advancetable/wPromotionTopupStep4', $aDataReturn);
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSaCPTUEventAdd(){
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $tDocDate       = $this->input->post('oetPTUDocDate') . " " . $this->input->post('oetPTUDocTime');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tUserLevel     = $this->session->userdata('tSesUsrLevel');

        $aMainData = array(
            'FTBchCode'                 => $this->input->post('oetPTUBchCode'),
            'FTPmhDocNo'                => $this->input->post('oetPTUDocNo'),
        );

        $aDataMasterHD = array(
            // HD
            'FDPmhDocDate'              => $tDocDate,
            'FTPmhCalType'              => $this->input->post('ocmPTUPmhCalType'),
            'FDPmhDStart'               => $this->input->post('oetPTUPmhDStart'), // วันที่เริ่ม
            'FDPmhDStop'                => $this->input->post('oetPTUPmhDStop'), // วันที่สิ้นสุด
            'FTPmhTStart'               => empty($this->input->post('oetPTUPmhTStart')) ? '00:00:00' : $this->input->post('oetPTUPmhTStart'), // เวลาเริ่ม
            'FTPmhTStop'                => empty($this->input->post('oetPTUPmhTStop')) ? '23:59:59' : $this->input->post('oetPTUPmhTStop'), // เวลาสิ้นสุด
            'FTPmhStaClosed'            => ($this->input->post('ocbPTUPmhStaClosed') == "1") ? '1' : '0',  //($this->input->post('ocbPTUPmhStaClosed') == "0") ? '0' : '1', // หยุดรายการ 0: เปิดใช้  1: หยุด
            'FTPmhStaDoc'               => '1', // สถานะเอกสาร ว่าง:ยังไม่สมบูรณ์, 1:สมบูรณ์
            'FTPmhStaApv'               => '', // สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว
            'FTPmhStaPrcDoc'            => '', // สถานะ prc เอกสาร ว่าง:ยังไม่ทำ, 1:ทำแล้ว
            'FTPmhRefAccCode'           => $this->input->post('oetPTUPmhRefAccCode'),
            'FNPmhStaDocAct'            => ($this->input->post('ocbPTUPmhStaDocAct') == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
            'FTPmhStaAlwRetMnyPay'      => ($this->input->post('ocbPTUPmhStaAlwRetMnyPay') == "1") ? '1' : '2',
            'FTPmhStaAlwRetMnyGet'      => ($this->input->post('ocbPTUPmhStaAlwRetMnyGet') == "1") ? '1' : '2',
            'FTUsrCode'                 => $tUserLoginCode, // รหัสผู้บันทึก
            'FTPmhUsrApv'               => '', // รหัสผู้อนุมัติ
            'FDLastUpdOn'               => date('Y-m-d H:i:s'),
            'FTLastUpdBy'               => $tUserLoginCode,
            'FDCreateOn'                => date('Y-m-d H:i:s'),
            'FTCreateBy'                => $tUserLoginCode,
        );

        $aDataMasterHD_L = array(
            // HD_L
            'FTBchCode'                 => $this->input->post('oetPTUBchCode'),
            'FTPmhName'                 => $this->input->post('oetPTUPmhName'),
            'FTPmhNameSlip'             => $this->input->post('oetPTUPmhNameSlip'),
            'FNLngID'                   => $nLangEdit
        );

        $this->db->trans_begin();
        // Check Auto Gen Code
        if ( $this->input->post('ocbPTUAutoGenCode') == '1' ) { 
            $aStoreParam = array(
                "tTblName" => 'TFNTCrdPmtHD',
                "tDocType" => '9',
                "tBchCode" => $aMainData["FTBchCode"],
                "tShpCode" => "",
                "tPosCode" => "",
                "dDocDate" => date("Y-m-d")
            );
            $aAutogen = FCNaHAUTGenDocNo($aStoreParam); // Call Auto Gencode Helper
            $aMainData['FTPmhDocNo'] = $aAutogen[0]["FTXxhDocNo"];
        }

        $this->mPromotionTopup->FSaMEventAddUpdateHD($aMainData,$aDataMasterHD);
        $this->mPromotionTopup->FSaMEventAddUpdateHD_L($aMainData,$aDataMasterHD_L);

        $aDataTemp = array(
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );

        if( $this->input->post('ocbPTURefExAutoGen') == '1' ){
            $this->mPromotionTopup->FSxMEventUpdateRefEx($aMainData,$aDataTemp);
        }

        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtDT');
        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtCD');
        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtHDBch');

        // Update DocType HD
        $this->mPromotionTopup->FSxMEventUpdateDocTypeHD($aMainData);

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'     => '900',
                'tStaMessg'     => "Unsucess Add"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'   => $aMainData['FTPmhDocNo'],
                'nStaEvent'     => '1',
                'tStaMessg'     => 'Success Add'
            );
        }

        echo json_encode($aReturn);
    }

    //Creator : 28/09/2020 Napat(Jame)
    public function FSaCPTUEventEdit(){
        $tUserSessionID = $this->session->userdata('tSesSessionID');
        $tUserLoginCode = $this->session->userdata('tSesUsername');
        $tDocDate       = $this->input->post('oetPTUDocDate') . " " . $this->input->post('oetPTUDocTime');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tUserLevel     = $this->session->userdata('tSesUsrLevel');
        $nStaApprove    = $this->input->post('ohdPTUStaApv');

        $aMainData = array(
            'FTBchCode'     => $this->input->post('oetPTUBchCode'),
            'FTPmhDocNo'    => $this->input->post('oetPTUDocNo')
        );

        if($nStaApprove == '1'){
            $aDataMasterHD = array(
                // HD
                'FTPmhStaClosed'       => ($this->input->post('ocbPTUPmhStaClosed') == "1") ? '1' : '0',
            );
        }else{
            $aDataMasterHD = array(
                // HD
                'FDPmhDocDate'         => $tDocDate,
                'FTPmhCalType'         => $this->input->post('ocmPTUPmhCalType'),
                'FDPmhDStart'          => $this->input->post('oetPTUPmhDStart'), // วันที่เริ่ม
                'FDPmhDStop'           => $this->input->post('oetPTUPmhDStop'), // วันที่สิ้นสุด
                'FTPmhTStart'          => empty($this->input->post('oetPTUPmhTStart')) ? '00:00:00' : $this->input->post('oetPTUPmhTStart'), // เวลาเริ่ม
                'FTPmhTStop'           => empty($this->input->post('oetPTUPmhTStop')) ? '23:59:59' : $this->input->post('oetPTUPmhTStop'), // เวลาสิ้นสุด
                'FTPmhStaClosed'       => ($this->input->post('ocbPTUPmhStaClosed') == "1") ? '1' : '0', //($this->input->post('ocbPTUPmhStaClosed') == "0") ? '0' : '1', // หยุดรายการ 0: เปิดใช้  1: หยุด
                'FTPmhRefAccCode'      => $this->input->post('oetPTUPmhRefAccCode'),
                'FNPmhStaDocAct'       => ($this->input->post('ocbPTUPmhStaDocAct') == "1") ? 1 : 0, // สถานะ เคลื่อนไหว 0:NonActive, 1:Active
                'FTPmhStaAlwRetMnyPay' => ($this->input->post('ocbPTUPmhStaAlwRetMnyPay') == "1") ? '1' : '2',
                'FTPmhStaAlwRetMnyGet' => ($this->input->post('ocbPTUPmhStaAlwRetMnyGet') == "1") ? '1' : '2',
                'FDLastUpdOn'          => date('Y-m-d H:i:s'),
                'FTLastUpdBy'          => $tUserLoginCode,
            );
        }

        
        $aDataMasterHD_L = array(
            // HD_L
            // 'FTPmhName'      => $this->input->post('oetPTUPmhName'),
            // 'FTPmhNameSlip'  => $this->input->post('oetPTUPmhNameSlip'),
            'FTPmhName'         => $this->input->post('ohdPTUPmhName'),
            'FTPmhNameSlip'     => $this->input->post('ohdPTUPmhNameSlip'),
        );

        $this->db->trans_begin();

        $this->mPromotionTopup->FSaMEventAddUpdateHD($aMainData,$aDataMasterHD);
        $this->mPromotionTopup->FSaMEventAddUpdateHD_L($aMainData,$aDataMasterHD_L);

        // เคลียร์มาสเตอร์ก่อน Move Temp To Master
        $this->mPromotionTopup->FSxMPTUEventClearInMaster($aMainData['FTPmhDocNo']);

        $aDataTemp = array(
            'tUserSessionID'    => $this->session->userdata('tSesSessionID')
        );

        if( $this->input->post('ocbPTURefExAutoGen') == '1' ){
            $this->mPromotionTopup->FSxMEventUpdateRefEx($aMainData,$aDataTemp);
        }

        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtDT');
        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtCD');
        $this->mPromotionTopup->FSxMEventMoveTempToMaster($aMainData,$aDataTemp,'TFNTCrdPmtHDBch');

        // Update DocType HD
        $this->mPromotionTopup->FSxMEventUpdateDocTypeHD($aMainData);

        if ( $this->db->trans_status() === FALSE ) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'     => '900',
                'tStaMessg'     => "Unsucess Edit"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'   => $aMainData['FTPmhDocNo'],
                'nStaEvent'     => '1',
                'tStaMessg'     => 'Success Edit'
            );
        }

        echo json_encode($aReturn);
    }

    //Creator : 29/09/2020 Napat(Jame)
    public function FSaCPTUEventCancelDoc(){
        $aDocCancelParams = array(
            'tStaDoc'   => '3',
            'tDocNo'    => $this->input->post('tDocNo'),
        );
        $aStaCancel = $this->mPromotionTopup->FSaMPTUEventCancelDoc($aDocCancelParams);
        echo json_encode($aStaCancel);
    }

    //Creator : 01/10/2020 Napat(Jame)
    public function FSaCPTUEventApproveDoc(){
        $aDocApproveParams = array(
            'tDocNo'    => $this->input->post('tDocNo'),
            'tApvCode'  => $this->session->userdata('tSesUserCode')
        );
        $aStaApv = $this->mPromotionTopup->FSaMPTUEventDocApprove($aDocApproveParams);
        echo json_encode($aStaApv);
    }

    //Creator : 30/12/2020 Napat(Jame)
    public function FSxCPTUEventChangeBchInTemp(){
        $aChangeBchParams = array(
            'tDocNo'        => 'PTUTEMP',
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
            'tBchCode'      => $this->input->post('tBchCode')
        );
        $this->mPromotionTopup->FSxMPTUEventChangeBchInTemp($aChangeBchParams);
    }

}