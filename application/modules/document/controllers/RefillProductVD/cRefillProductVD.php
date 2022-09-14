<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cRefillProductVD extends MX_Controller {

    public function __construct() {
        $this->load->model('document/RefillProductVD/mRefillProductVD');
        parent::__construct();
    }

    public function index($nBrowseType, $tBrowseOption) {
        $aDataConfigView = array(
            'nBrowseType'       => $nBrowseType,
            'tBrowseOption'     => $tBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0'), 
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docRVDRefillPDTVD/0/0'), 
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/RefillProductVD/wRefillProductVD', $aDataConfigView);
    }

    //Page List
    public function FSvCRVDPageList(){
        $this->load->view('document/RefillProductVD/wRefillProductVDList');
    }

    //Datatable
    public function FSvCRVDDatatable(){
        $tAdvanceSearchData = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aAlwEvent          = FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        //ล้างข้อมูล
        $this->mRefillProductVD->FSxMRVDClearPdtInTmp();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        $aData = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'aAdvanceSearch'    => $tAdvanceSearchData
        );

        $aResList = $this->mRefillProductVD->FSaMRVDHDList($aData);
        $aGenTable = array(
            'aAlwEvent'         => $aAlwEvent,
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'nOptDecimalShow'   => $nOptDecimalShow
        );

        $this->load->view('document/RefillProductVD/wRefillProductVDDataTable', $aGenTable);
    }

    //Page ADD
    public function FSvCRVDPageAdd(){
        try{
            $tTblSelectData = "TCNTPdtTwsHD";
            $this->mRefillProductVD->FSxMRVDClearPdtInTmp($tTblSelectData);

            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            $nOptDocSave        = FCNnHGetOptionDocSave();

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'aDataDocHD'        => array('rtCode'=>'99')
            );

            $tViewPageAdd       = $this->load->view('document/RefillProductVD/wRefillProductVDPageAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tViewPageAdd'      => $tViewPageAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Page Edit 
    public function FSvCRVDPageEdit(){
        try{
            $tDocumentNumber    = $this->input->post('tDocumentNumber');

            //ล้างข้อมูล
            $this->mRefillProductVD->FSxMRVDClearPdtInTmp();

            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            $nOptDocSave        = FCNnHGetOptionDocSave();
            $aAlwEvent          = FCNaHCheckAlwFunc('TVO/0/0'); 
            $aHD                = $this->mRefillProductVD->FSaMRVDDocumentByID($tDocumentNumber);

            //Move DT To Temp
            $this->mRefillProductVD->FSaMRVDMoveDTToTemp($tDocumentNumber);

            $aDataConfigViewAdd = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'nOptDocSave'       => $nOptDocSave,
                'aDataDocHD'        => $aHD
            );

            $tViewPageAdd       = $this->load->view('document/RefillProductVD/wRefillProductVDPageAdd',$aDataConfigViewAdd,true);
            $aReturnData        = array(
                'tViewPageAdd'      => $tViewPageAdd,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //-------------------------------------------------------------------------------------------------------//

    //Load Table Step1
    public function FSvCRVDLoadTableStep1(){
        try{
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            $aData              = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'tDocumentNumber'   => $tDocumentNumber
            );
            $aAlwEvent          = FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0');
            $aInformation       = array(
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $this->mRefillProductVD->FSaMRVDDTListStep1($aData)
            );
            $tViewStep1         = $this->load->view('document/RefillProductVD/step/step1/wRefillVDStep1Table',$aInformation,true);
            $aReturnData        = array(
                'tViewer'           => $tViewStep1,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Insert Step1
    public function FSvCRVDInsStep1(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tBCHCode           = $this->input->post('tBCHCode');
        $tMERCode           = $this->input->post('tMERCode');
        $tSHPCode           = $this->input->post('tSHPCode');
        $tPOSCode           = $this->input->post('tPOSCode');

        $aPackData  = array(
            'tDocumentNumber'   => $tDocumentNumber,
            'tBCHCode'          => $tBCHCode,
            'tMERCode'          => $tMERCode,
            'tSHPCode'          => $tSHPCode,
            'tPOSCode'          => $tPOSCode
        );

        $aResultFindData = $this->mRefillProductVD->FSaMRVDFindStep1($aPackData);
        if($aResultFindData['rtCode'] == 1){

            //พบข้อมูล - POS
            $nKey = 1;
            for($i=0; $i<FCNnHSizeOf($aResultFindData['raItems']); $i++){
                $this->mRefillProductVD->FSaMRVDInsertStep1($aResultFindData['raItems'][$i],$nKey,$tDocumentNumber);
                $nKey++;
            }

            //พบข้อมูล - Wahouse
            $aResultFindWahouse = $this->mRefillProductVD->FSaMRVDFindStep1_Wahouse($aPackData);
            $nKeyWah = 1;
            for($i=0; $i<FCNnHSizeOf($aResultFindWahouse['raItems']); $i++){
                $this->mRefillProductVD->FSaMRVDInsertStep1_Wahouse($aResultFindWahouse['raItems'][$i],$nKeyWah,$tDocumentNumber);
                $nKeyWah++;
            }

            $aReturnData = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'success'
            );
        }else{
            //ไม่พบข้อมูล
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => 'fail'
            );
        }
        echo json_encode($aReturnData);
    }

    //Delete Record Step1
    public function FSxCRVDDeleteStep1(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $nSeq               = $this->input->post('nSeq');
        $tBCHCode           = $this->input->post('tBCHCode');

        $aPackData  = array(
            'tDocumentNumber'       => $tDocumentNumber,
            'nSeq'                  => $nSeq,
            'tBCHCode'              => $tBCHCode
        );
        $this->mRefillProductVD->FSaMRVDDeleteRecordStep1($aPackData);
    }

    //-------------------------------------------------------------------------------------------------------//

    //Load Table Step2
    public function FSvCRVDLoadTableStep2(){
        try{
            $tDocumentNumber        = $this->input->post('tDocumentNumber');
            $tTypepage              = $this->input->post('tTypepage');
            $tTypeClickPDT          = $this->input->post('tTypeClickPDT');
            $tTypeFlagCheckSTKBal   = ($this->input->post('tTypeClickPDT') == 'on') ? 1 : 0;

            $aData              = array(
                'FNLngID'               => $this->session->userdata("tLangEdit"),
                'tDocumentNumber'       => $tDocumentNumber,
                'tTypepage'             => $tTypepage,
                'tTypeClickPDT'         => $tTypeClickPDT,
                'tTypeFlagCheckSTKBal'  => $tTypeFlagCheckSTKBal
            );
            $aAlwEvent          = FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0');
            $aInformation       = array(
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $this->mRefillProductVD->FSaMRVDDTListStep2($aData)
            );

            $tViewStep2         = $this->load->view('document/RefillProductVD/step/step2/wRefillVDStep2Table',$aInformation,true);
            $aReturnData        = array(
                'tViewer'           => $tViewStep2,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Update Step2
    public function FSxCRVDUpdateStep2(){
        try{
            $tDocumentNumber = $this->input->post('tDocumentNumber');
            $nQty            = $this->input->post('nQty');          
            $nSeqNo          = $this->input->post('nSeqNo');        
            $tPdtCode        = $this->input->post('tPdtCode');      

            $aData           = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'tDocumentNumber'   => $tDocumentNumber,
                'nQty'              => $nQty,
                'nSeqNo'            => $nSeqNo,
                'tPdtCode'          => $tPdtCode
            );

            //Update
            $this->mRefillProductVD->FSaMRVDDTUpdateStep2($aData);
            $aReturnData        = array(
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Delete Step2
    public function FSxCRVDDeleteStep2(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tPDTCode           = $this->input->post('tPDTCode');
        $nSeq               = $this->input->post('nSeq');

        $aPackData  = array(
            'tDocumentNumber'       => $tDocumentNumber,
            'nSeq'                  => $nSeq,
            'tPDTCode'              => $tPDTCode
        );
        $this->mRefillProductVD->FSaMRVDDeleteRecordStep2($aPackData);
    }

    //Delete Multi Step2
    public function FSxCRVDDeleteMultiStep2(){
        try{
            $nSeq               = $this->input->post('nSeq');
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            $this->db->trans_begin();
            $aDataDelete = array(
                'tDocumentNumber'   => $tDocumentNumber,
                'nSeq'              => $nSeq
            );
            $this->mRefillProductVD->FSaMRVDDeleteRecordMultiStep2($aDataDelete);

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
            echo json_encode($aStatus);
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Prorate Step2
    public function FSxCRVDProrateStep2(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tPDTCode           = $this->input->post('tPDTCode');
        $tPDTName           = $this->input->post('tPDTName');
        $nQTY               = $this->input->post('nQTY');
        $nFullRefill        = $this->input->post('nFullRefill');

        $aData              = array(
            'tDocumentNumber'   => $tDocumentNumber,
            'tPdtCode'          => $tPDTCode,
            'nQTY'              => $nQTY,
            'nFullRefill'       => $nFullRefill,
            'FNLngID'           => $this->session->userdata("tLangEdit"),
        );

        $aInformation       = array(
            'tPDTCode'          => $tPDTCode,
            'tPDTName'          => $tPDTName,
            'nQTY'              => number_format($nQTY,0),
            'nFullRefill'       => $nFullRefill,
            'aDataList'         => $this->mRefillProductVD->FSaMRVDProrateStep2($aData)
        );

        $tViewStep2         = $this->load->view('document/RefillProductVD/step/step2/wRefillVDStep2Prorate',$aInformation,true);
        $aReturnData        = array(
            'tViewer'           => $tViewStep2,
            'nStaEvent'         => '1',
            'tStaMessg'         => 'Success'
        );
        echo json_encode($aReturnData);
    }

    //เอาข้อมูลจำนวนที่ edit ไปลง temp Step2
    public function FSxCRVDProrateSaveStep2InTemp(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $aPackDataIns       = $this->input->post('aPackDataIns');

        for($i=0; $i<FCNnHSizeOf($aPackDataIns); $i++){
            $aInsert        = array(
                'SEQ'           => $i,
                'BCH'           => $this->input->post('BCH'),
                'DOC'           => $tDocumentNumber,
                'PDT'           => $aPackDataIns[$i]['PDT'],
                'ROW'           => $aPackDataIns[$i]['ROW'],
                'COL'           => $aPackDataIns[$i]['COL'], 
                'POS'           => $aPackDataIns[$i]['POS'],
                'QTY'           => $aPackDataIns[$i]['QTY']
            );
            $this->mRefillProductVD->FSaMRVDInsertProrateToStep2($i,$aInsert);
        }
    }

    //-------------------------------------------------------------------------------------------------------//

    //Load Table Step3
    public function FSvCRVDLoadTableStep3(){
        try{
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            $aData              = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'tDocumentNumber'   => $tDocumentNumber
            );
            $aAlwEvent          = FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0');
            $aInformation       = array(
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $this->mRefillProductVD->FSaMRVDDTListStep3($aData)
            );
            $tViewStep3         = $this->load->view('document/RefillProductVD/step/step3/wRefillVDStep3Table',$aInformation,true);
            $aReturnData        = array(
                'tViewer'           => $tViewStep3,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //-------------------------------------------------------------------------------------------------------//

    //Load Table Step4
    public function FSvCRVDLoadTableStep4(){
        try{
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            $aData              = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'tDocumentNumber'   => $tDocumentNumber
            );
            $aAlwEvent          = FCNaHCheckAlwFunc('docRVDRefillPDTVD/0/0');
            $aInformation       = array(
                'aAlwEvent'         => $aAlwEvent,
                'aDataListHD'       => $this->mRefillProductVD->FSaMRVDDTListStep4($aData)
            );
            $tViewStep4         = $this->load->view('document/RefillProductVD/step/step4/wRefillVDStep4Table',$aInformation,true);
            $aReturnData        = array(
                'tViewer'           => $tViewStep4,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent'         => '500',
                'tStaMessg'         => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //-------------------------------------------------------------------------------------------------------//

    //Event บันทึกใหม่ 
    public function FSxCRVDEventSave(){
        //Check Auto gen Code
        $nStaAutoGenCode = $this->input->post('ocbRVDStaAutoGenCode');
        if($nStaAutoGenCode == 'on' || $nStaAutoGenCode == 1){
            $aStoreParam = array(
                "tTblName"   => 'TCNTPdtTwsHD',                  
                "tDocType"   => 1,                                  
                "tBchCode"   => $this->input->post('oetRVDBchCode'),   
                "tShpCode"   => "",                                 
                "tPosCode"   => "",            
                "dDocDate"   => date("Y-m-d H:i:s")  
            );

            $aXthDocNo  = FCNaHAUTGenDocNo($aStoreParam);
            $tXthDocNo  = $aXthDocNo[0]['FTXxhDocNo'];
        }else{
            $tXthDocNo  = $this->input->post('oetRVDDocNo');
        }

        if($tXthDocNo != ''){
            try{
                $aInsertRefillProductVD = array(
                    'FTBchCode'         => $this->input->post('oetRVDBchCode'),   
                    'FTXthDocNo'        => $tXthDocNo,
                    'FDXthDocDate'      => $this->input->post('oetRVDDocDate') . " " . $this->input->post('oetRVDDocTime'),
                    'FTXthDocType'      => 1,
                    'FTDptCode'         => '',
                    'FTUsrCode'         => $this->input->post('oetRVDCusTransferCode'),
                    'FTXthApvCode'      => '',
                    'FTXthShipWhTo'     => $this->input->post('oetRVDWahTransferCode'),
                    'FTXthRefExt'       => $this->input->post('oetRVDWahTransferRefCode'),
                    'FDXthRefExtDate'   => '',
                    'FTXthRefInt'       => $this->input->post('oetRVDWahTransferRefIDCode'),
                    'FDXthRefIntDate'   => '',
                    'FNXthDocPrint'     => '',
                    'FTXthRmk'          => $this->input->post('otaRVDFrmInfoOthRmk'),
                    'FTXthStaDoc'       => 1,
                    'FTXthStaApv'       => '',
                    'FTXthStaPrcStk'    => '',
                    'FTXthStaDelMQ'     => '',
                    'FNXthStaDocAct'    => '',
                    'FNXthStaRef'       => '',
                    'FNXthStaClsSft'    => '',
                    'FTRsnCode'         => $this->input->post('oetRVDReasonCode'),
                    'FTXthCtrName'      => '',
                    'FDXthTnfDate'      => $this->input->post('oetRVDDocDate'),
                    'FNXthShipAdd'      => '',
                    'FTViaCode'         => $this->input->post('oetRVDWahTransferByCode'),
                    'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d H:i:s'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    'FTXthStaChkBal'    => ($this->input->post('ocbRVDStaFullRefillPos') == 'on' ) ? 1 : 0
                );
                $oCountDup = $this->mRefillProductVD->FSnMRVDCheckDuplicate($tXthDocNo);

                //check แล้ว ไม่ซ้ำจะ insert ได้
                if($oCountDup !== FALSE && $oCountDup['counts'] == 0){

                    $this->db->trans_begin();
                    
                    //Insert HD
                    $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateHD($aInsertRefillProductVD);

                    //Insert DT
                    $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateDT($aInsertRefillProductVD);

                    //Insert HDBch จัดส่งไปไหนบ้าง
                    $this->mRefillProductVD->FSaMRVDDeleteHDBch($aInsertRefillProductVD);
                    $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateHDBch($aInsertRefillProductVD);

                    //Insert PDT BY Pos
                    $this->mRefillProductVD->FSaMRVDInsertPDTProrateByPos($aInsertRefillProductVD);

                    //Delete ลบข้อมูลใน Temp
                    $this->mRefillProductVD->FSaMRVDDeleteTemp($aInsertRefillProductVD);

                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $aReturn = array(
                            'nStaEvent' => '900',
                            'tStaMessg' => "Unsucess"
                        );
                    }else{
                        $this->db->trans_commit();
                        $aReturn = array(
                            'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                            'tCodeReturn'   => $aInsertRefillProductVD['FTXthDocNo'],
                            'nStaEvent'	    => '1',
                            'tStaMessg'     => 'Success'
                        );
                    }

                }else{
                    $aReturn = array(
                        'nStaEvent' => '801',
                        'tStaMessg' => "เลขที่เอกสารมีอยู่แล้วในระบบ"
                    );
                }
            }catch(Exception $Error){
                echo $Error;
            }
        }else{
            $aReturn = array(
                'nStaEvent' => '801',
                'tStaMessg' => language('common/main/main', 'tCanNotAutoGenCode')
            );
        }
        echo json_encode($aReturn);
    }

    //Event แก้ไข
    public function FSxCRVDEventEdit(){
        $tXthDocNo  = $this->input->post('oetRVDDocNo');

        try{
            $aInsertRefillProductVD = array(
                'FTBchCode'         => $this->input->post('oetRVDBchCode'),   
                'FTXthDocNo'        => $tXthDocNo,
                'FDXthDocDate'      => $this->input->post('oetRVDDocDate') . " " . $this->input->post('oetRVDDocTime'),
                'FTXthDocType'      => 1,
                'FTDptCode'         => '',
                'FTUsrCode'         => $this->input->post('oetRVDCusTransferCode'),
                'FTXthApvCode'      => '',
                'FTXthShipWhTo'     => $this->input->post('oetRVDWahTransferCode'),
                'FTXthRefExt'       => $this->input->post('oetRVDWahTransferRefCode'),
                'FDXthRefExtDate'   => '',
                'FTXthRefInt'       => $this->input->post('oetRVDWahTransferRefIDCode'),
                'FDXthRefIntDate'   => '',
                'FNXthDocPrint'     => '',
                'FTXthRmk'          => $this->input->post('otaRVDFrmInfoOthRmk'),
                'FTXthStaDoc'       => 1,
                'FTXthStaApv'       => '',
                'FTXthStaPrcStk'    => '',
                'FTXthStaDelMQ'     => '',
                'FNXthStaDocAct'    => '',
                'FNXthStaRef'       => '',
                'FNXthStaClsSft'    => '',
                'FTRsnCode'         => $this->input->post('oetRVDReasonCode'),
                'FTXthCtrName'      => '',
                'FDXthTnfDate'      => $this->input->post('oetRVDDocDate'),
                'FNXthShipAdd'      => '',
                'FTViaCode'         => $this->input->post('oetRVDWahTransferByCode'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTXthStaChkBal'    => ($this->input->post('ocbRVDStaFullRefillPos') == 'on' ) ? 1 : 0
            );
            $this->db->trans_begin();
            
            //Update HD
            $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateHD($aInsertRefillProductVD);

            //Update DT
            $this->mRefillProductVD->FSaMRVDDeleteDT($aInsertRefillProductVD);
            $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateDT($aInsertRefillProductVD);

            //Update HDBch จัดส่งไปไหนบ้าง
            $this->mRefillProductVD->FSaMRVDDeleteHDBch($aInsertRefillProductVD);
            $this->mRefillProductVD->FSaMRVDAddInsertAndUpdateHDBch($aInsertRefillProductVD);

            //Insert PDT BY Pos
            $this->mRefillProductVD->FSaMRVDDeleteDTPos($aInsertRefillProductVD);
            $this->mRefillProductVD->FSaMRVDInsertPDTProrateByPos($aInsertRefillProductVD);

            //Delete ลบข้อมูลใน Temp
            $this->mRefillProductVD->FSaMRVDDeleteTemp($aInsertRefillProductVD);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Unsucess"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aInsertRefillProductVD['FTXthDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'     => 'Success'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Event ยกเลิกเอกสาร
    public function FSxCRVDCancelDocument(){
        try{
            $tDocumentNumber    = $this->input->post('tDocumentNumber');
            $aDataUpdate = array(
                'FTXthDocNo' => $tDocumentNumber
            );
            $this->mRefillProductVD->FSvMRVDCancel($aDataUpdate);
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Event ลบเอกสาร
    public function FSaCRVDDeleteDocument(){
        try{
            $tDocumentNumber = $this->input->post('tDocumentNumber');
            $this->db->trans_begin();
            $aDataDelete = array(
                'FTXthDocNo' => $tDocumentNumber
            );
            $this->mRefillProductVD->FSaMRVDDeleteDocument($aDataDelete);

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
            echo json_encode($aStatus);
        }catch(Exception $Error){
            return $Error;
        }
    }

    //Event เช็คสต๊อกก่อน
    public function FSxCRVDCheckStockWhenApv(){
        $tDocumentNumber        = $this->input->post('tDocumentNumber');
        $nCountPOS              = $this->input->post('nCountPOS');
        $aCheckSTKWhenAPV       = $this->mRefillProductVD->FSaMRVDCheckSTKWhenAPV($tDocumentNumber);
        $tFlagSTKAVG            = false;
        for($i=0; $i<FCNnHSizeOf($aCheckSTKWhenAPV); $i++){
            // if($aCheckSTKWhenAPV[$i]['FCXtdQty'] * $nCountPOS != $aCheckSTKWhenAPV[$i]['FCLayColQtyMaxForTWXVD'] * $nCountPOS){
            //     $tFlagSTKAVG = true;
            //     break;
            // }

            if($aCheckSTKWhenAPV[$i]['FCXtdQty'] == 'PRORATE'){
                $tFlagSTKAVG = true;
                break;
            }
        }
        echo $tFlagSTKAVG;
    }

    //Event อนุมัติเอกสาร
    public function FSxCRVDApprovedDocument(){
        try {

            //เลขที่เอกสารใบเติมสินค้าชุด
            $tDocumentNumber = $this->input->post('tDocumentNumber');
            $tFlagSTKAVG     = $this->input->post('tFlagSTKAVG');
            $this->db->trans_begin();

            //ใบเดิมสินค้าชุด + อนุมัติเลย
            $this->mRefillProductVD->FSaMRVDApproveHD($tDocumentNumber);

            //ต้องสร้างใบโอน + อนุมัติเลย
            $tDocTranferFull      = "";
            $aItemTranfer         = $this->mRefillProductVD->FSaMRVDFind_document_tranferwahouseHD($tDocumentNumber);
            $aInsertTranferHD     = $this->mRefillProductVD->FSaMRVDInsert_wahouseHD($tDocumentNumber);
            $aInsertTranferDT     = $this->mRefillProductVD->FSaMRVDInsert_wahouseDT($tDocumentNumber);
            $aInsertTranferHDRef  = $this->mRefillProductVD->FSaMRVDInsert_wahouseHDRef($tDocumentNumber);
            if($aItemTranfer['rtCode'] == 1){
                $nCountItem                 = FCNnHSizeOf($aItemTranfer['raItems']);
                $tDocTranferFullUpdateSTK   = '';
                //อัพเดทเลขที่เอกสารลงใน HD
                for($i=0; $i<$nCountItem; $i++){
                    $tDocumentOldHD   = 'WAIT-' . $aItemTranfer['raItems'][$i]['FTXthWahFrm'];
                    $tDocumentOldDT   = 'WAIT-' . $aItemTranfer['raItems'][$i]['FTXthWahFrm'];
                    $aGenCode = array(
                        "tTblName"    => 'TCNTPdtTwxHD',                           
                        "tDocType"    => '3',                                          
                        "tBchCode"    => $aItemTranfer['raItems'][$i]['FTBchCode'],                                 
                        "tShpCode"    => "",                               
                        "tPosCode"    => "",                     
                        "dDocDate"    => date("Y-m-d")       
                    );
                    $aAutogen           = FCNaHAUTGenDocNo($aGenCode);
                    $tDocumentTranfer   = $aAutogen[0]["FTXxhDocNo"];
                    $this->mRefillProductVD->FSaMRVDUpdateDocument_wahouseHD($tDocumentOldHD,$tDocumentOldDT,$tDocumentTranfer,$aItemTranfer['raItems'][$i]['FTXthWahFrm']);

                    //อนุมัติเอกสารใบโอน
                    $aMQParams = [
                        "queueName"     => "TNFWAREHOSE",
                        "exchangname"   => "",
                        "params"        => [
                            "ptBchCode"     => $aItemTranfer['raItems'][$i]['FTBchCode'],
                            "ptDocNo"       => $tDocumentTranfer,
                            "ptDocType"     => 3,
                            "ptUser"        => $this->session->userdata('tSesUsername')
                        ]
                    ];
                    FCNxCallRabbitMQ($aMQParams);

                    //ส่งเลขที่เอกสารกลับไปหน้า View ให้ PHP subscribe
                    $tDocTranferFull .= $tDocumentTranfer.",";
                    if($i == FCNnHSizeOf($aItemTranfer['raItems'])-1){
                        $tDocTranferFull = substr($tDocTranferFull,0,-1);
                    }

                    //เอาจำนวน QTY หารจากจำนวนจริงของ STK ไม่ใช่ โอนเต็มอัตรา
                    $tDocTranferFullUpdateSTK .= "'".$tDocumentTranfer."',";
                    if($i == FCNnHSizeOf($aItemTranfer['raItems'])-1){
                        //อัพเดท QTY แบบเฉลี่ย
                        if($nCountItem > 1){
                            $tDocTranferFullUpdateSTK = substr($tDocTranferFullUpdateSTK,0,-1);
                            $this->mRefillProductVD->FSaMRVDUpdateQTYIn_tranferwahouseDT($tDocTranferFullUpdateSTK);
                        }
                    }
                }
            }

            //ต้องสร้างใบเติม + ยังไม่ต้องอนุมัติ
            $aItemTopUp         = $this->mRefillProductVD->FSaMRVDFind_document_topupvendingHD($tDocumentNumber);
            $aInsertTopUpHD     = $this->mRefillProductVD->FSaMRVDInsert_topupvendingHD($tDocumentNumber);
            $aInsertTopUpDT     = $this->mRefillProductVD->FSaMRVDInsert_topupvendingDT($tDocumentNumber);
            $aInsertTopUpHDRef  = $this->mRefillProductVD->FSaMRVDInsert_topupvendingHDRef($tDocumentNumber);
            
            if($aItemTopUp['rtCode'] == 1){
                $nCountItem     = FCNnHSizeOf($aItemTopUp['raItems']);
                //อัพเดทเลขที่เอกสารลงใน HD
                $tDocTopUpFull  = '';
                $nNumberDate    = 1;
                for($i=0; $i<$nCountItem; $i++){
                    $tDocumentOldHD   = 'WAIT-' . $aItemTopUp['raItems'][$i]['FTXthShopTo'] . $aItemTopUp['raItems'][$i]['FTXthWahTo'];
                    $tDocumentOldDT   = 'WAIT-' . $aItemTopUp['raItems'][$i]['FTXthShopTo'] . $aItemTopUp['raItems'][$i]['FTXthWahTo'];
                    $aGenCode = array(
                        "tTblName"    => 'TVDTPdtTwxHD',                           
                        "tDocType"    => '1',                                          
                        "tBchCode"    => $aItemTopUp['raItems'][$i]['FTXthBchTo'],                                 
                        "tShpCode"    => "",                               
                        "tPosCode"    => "",                     
                        "dDocDate"    => date("Y-m-d")       
                    );
                    $aAutogen           = FCNaHAUTGenDocNo($aGenCode);
                    $tDocumentTopUp     = $aAutogen[0]["FTXxhDocNo"];
                    $dDateRealTime      = date('Y-m-d H:i:s' , strtotime('+ '.$nNumberDate.' minute'));
                    $this->mRefillProductVD->FSaMRVDUpdateDocument_topupvendingHD($tDocumentOldHD,$tDocumentOldDT,$tDocumentTopUp,$aItemTopUp['raItems'][$i]['FTXthWahTo'],$dDateRealTime);
                    
                    $tDocTopUpFull .= "'".$tDocumentTopUp."',";
                    if($i == FCNnHSizeOf($aItemTopUp['raItems'])-1){
                        //อัพเดท QTY แบบเฉลี่ย + ต้องเช็คสต๊อก เติมสินค้าแบบ เฉลี่ยตาม pos ให้ทุกตู้เท่ากันหมด
                        $tDocTopUpFull = substr($tDocTopUpFull,0,-1);
                        // echo "tDocTopUpFull: ".$tDocTopUpFull."<br>";
                        // echo "tFlagSTKAVG: ".$tFlagSTKAVG."<br>";
                        $this->mRefillProductVD->FSaMRVDUpdateQTYIn_topupvendingDT($tDocTopUpFull,$tFlagSTKAVG,$tDocumentNumber);
                        
                        // เช็คว่าถ้าเอกสารไหน มีการเติมเป็น 0 ทั้งเอกสาร จะต้องลบ TVDTPdtTwxDT TVDTPdtTwxHD TVDTPdtTwxHDRef และ TCNTPdtTwsHDBch
                        $tDocTopUpFull = substr($tDocTopUpFull,0,-1);
                        // echo "tDocTopUpFull: ".$tDocTopUpFull."<br>";
                        $this->mRefillProductVD->FSaMRVDCheckQtyIn_topupvendingDT($tDocTopUpFull);
                    }
                    $nNumberDate++;
                }
                
            }
            // exit;

            $this->db->trans_commit();
            $aReturn = array(
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success',
                'tDocumentWahouse'  => $tDocTranferFull
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

}



