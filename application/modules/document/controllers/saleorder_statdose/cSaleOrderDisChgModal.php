<?php
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSaleOrderDisChgModal extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/company/mCompany');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/saleorder/mSaleOrderDisChgModal');
    }

    // Functionality : Function Call Data From PI HD
    // Parameters : Ajax and Function Parameter
    // Creator : 02/07/19 Wasin(Yoshi)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCSODisChgHDList(){
        try{
            $tUserLevel         = $this->session->userdata('tSesUsrLevel'); 
            $tDocNo             = $this->input->post('tDocNo');
            $nSeqNo             = $this->input->post('tSeqNo');
            $tBchCode           = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmSO/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch,
                'tDocNo'            => $tDocNo,  
                'nSeqNo'            => $nSeqNo,
                'tBchCode'          => $tBchCode,
                'tSessionID'        => $this->session->userdata('tSesSessionID')
            );
            $aDataList  = $this->mSaleOrderDisChgModal->FSaMSOGetDisChgHDList($aDataCondition);
            // echo '<pre>';
            // print_r($aDataList);
            // echo '</pre>';
            // die();
 
            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tSOViewDataTableList   = $this->load->view('document/saleorder/dis_chg/wSaleOrderDisChgHDList', $aConfigView, true);
            $aReturnData = array(
                'tSOViewDataTableList'  => $tSOViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function Call Data From PI DT
    // Parameters : Ajax and Function Parameter
    // Creator : 02/07/19 Wasin(Yoshi)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCSODisChgDTList(){
        try{
            $tUserLevel         = $this->session->userdata('tSesUsrLevel');
            $tDocNo             = $this->input->post('tDocNo');
            $nSeqNo             = $this->input->post('tSeqNo');
            $tBchCode           = $tUserLevel == 'HQ' ? FCNtGetBchInComp() : $this->session->userdata("tSesUsrBchCode");
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmSO/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Page Current 
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition  = array(
                'tDocNo'            => $tDocNo,  
                'nSeqNo'            => $nSeqNo,
                'tBchCode'          => $tBchCode,
                'FNLngID'           => $nLangEdit,
                'nPage'             => $nPage,
                'nRow'              => 10,
                'aAdvanceSearch'    => $aAdvanceSearch,
                'tSessionID'        => $this->session->userdata('tSesSessionID')
            );

            $aDataList      = $this->mSaleOrderDisChgModal->FSaMSOGetDisChgDTList($aDataCondition);

            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
            );
            $tSOViewDataTableList   = $this->load->view('document/saleorder/dis_chg/wSaleOrderDisChgDTList', $aConfigView, true);
            $aReturnData = array(
                'tSOViewDataTableList'  => $tSOViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : เพิ่มและแก้ไข ส่วนลดรายการ
    // Parameters : Ajax and Function Parameter
    // Creator : 03/07/19 Wasin(Yoshi)
    // LastUpdate: -
    // Return : Object Statue Event Add/Edit ส่วนลดรายการ
    // Return Type : object
    public function FSoCSOAddEditDTDis(){
        try{
            $tBchCode       = $this->input->post('tBchCode');
            $tDocNo         = $this->input->post('tDocNo');
            $nSeqNo         = $this->input->post('tSeqNo');
            $tVatInOrEx     = $this->input->post('tVatInOrEx');
            $tSessionID     = $this->session->userdata('tSesSessionID');
            $tDisChgItems   = $this->input->post('tDisChgItems');
            $tDisChgSummary = $this->input->post('tDisChgSummary');

            $aDisChgItems   = json_decode($tDisChgItems, true);
            $aDisChgSummary = json_decode($tDisChgSummary, true);

            $this->db->trans_begin();
            // ================================ Begin DB Process ================================
                $aParams    = array(
                    'nSOStaDis'         => 1,
                    'tSODocNo'          => $tDocNo,
                    'nSOSeqNo'          => $nSeqNo,
                    'tSOBchCode'        => $tBchCode,
                    'nSOLngID'          => $this->session->userdata("tLangID"),
                    'tSOSessionID'      => $tSessionID,
                    'tSOVatInOrEx'      => $tVatInOrEx,
                    'aSODisChgSummary'  => $aDisChgSummary
                );

                $this->mSaleOrderDisChgModal->FSaMSOClearDisChgTxtDTTemp($aParams);
                $this->mSaleOrderDisChgModal->FSaMSODeleteDTDisTemp($aParams);

                if(isset($aDisChgItems) && !empty($aDisChgItems)){
                    $aInsertDTDisTmp    =   array();
                    foreach ($aDisChgItems as $key => $item){
                        array_push($aInsertDTDisTmp,array(
                            'FTBchCode'         => $tBchCode,
                            'FTXthDocNo'        => $tDocNo,
                            'FNXtdSeqNo'        => $item['nSeqNo'],
                            'FDXtdDateIns'      => date('Y-m-d H:i:s',strtotime($item['tCreatedAt'])),
                            'FTXtdDisChgTxt'    => $item['tDisChgTxt'],
                            'FNXtdStaDis'       => $item['tStaDis'],
                            'FTXtdDisChgType'   => $item['nDisChgType'],
                            'FCXtdNet'          => $item['cAfterDisChg'],
                            'FCXtdValue'        => $item['cDisChgValue'],
                            'FTSessionID'       => $tSessionID,
                            'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                            'FDCreateOn'        => date('Y-m-d h:i:s'),
                            'FTCreateBy'        => $this->session->userdata('tSesUsername')
                        ));
                    }
                    $aResAddEditDTDisTemp   = $this->mSaleOrderDisChgModal->FSaMSOAddEditDTDisTemp($aInsertDTDisTmp);
                }
            // ==================================================================================
                
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Not Insert Document DT Dis Temp.'
                );
            }else{
                $this->db->trans_commit();

                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '',
                    'tDataVatInOrEx'    => $tVatInOrEx,
                    'tDataDocNo'        => $tDocNo,
                    'tDataDocKey'       => 'TARTSoHD',
                    'tDataSeqNo'        => $nSeqNo
                ];
                $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if($aStaCalcDTTemp === TRUE){
                    // Prorate HD
                    FCNaHCalculateProrate('TARTSoHD',$tDocNo);
                    FCNbHCallCalcDocDTTemp($aCalcDTParams);
                    $aCalEndOfBillHDDisParams = [
                        'tDocNo'        => $tDocNo,
                        'tBchCode'      => $tBchCode,
                        'tSessionID'    => $tSessionID,
                        'tSplVatType'   => $tVatInOrEx,
                        'nLngID'        => '',
                        'tDocKey'       => 'TARTSoHD',
                        'nSeqNo'        => $nSeqNo
                    ];
                    FSvCCreditNoteCalEndOfBillHDDis($aCalEndOfBillHDDisParams);
                    $aReturnData    = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Insert Document Dis Temp.'
                    );
                }else{
                    $aReturnData    = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Not Calcurate DT Temp.'
                    );
                }
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function : เพิ่มและแก้ไข ส่วนลดท้ายบิล
    // Parameters : Ajax and Function Parameter
    // Creator : 03/07/19 Wasin(Yoshi)
    // LastUpdate: -
    // Return : Object Statue Event Add/Edit ส่วนลดท้ายบิล
    // Return Type : object
    public function FSoCSOAddEditHDDis(){
        try{
            $tBchCode       = $this->input->post('tBchCode');
            $tDocNo         = $this->input->post('tDocNo');
            $nSeqNo         = $this->input->post('tSeqNo');
            $tVatInOrEx     = $this->input->post('tVatInOrEx');
            $tSessionID     = $this->session->userdata('tSesSessionID');
            $tDisChgItems   = $this->input->post('tDisChgItems');
            $tDisChgSummary = $this->input->post('tDisChgSummary');
            $aDisChgItems   = json_decode($tDisChgItems, true);
            $aDisChgSummary = json_decode($tDisChgSummary, true);

            // ================================ Begin DB Process ================================
            $aParams = array(
                'tSODocNo'          => $tDocNo,  
                'tSOBchCode'        => $tBchCode,
                'nSOLngID'          => $this->session->userdata("tLangID"),
                'tSOSessionID'      => $this->session->userdata('tSesSessionID'),
                'aSODisChgSummary'  => $aDisChgSummary
            );
            
            // Delete Dis/Chg Tabel HD DIS Temp
            $this->mSaleOrderDisChgModal->FSaMSODeleteHDDisTemp($aParams);

            $this->db->trans_begin();
                // Check Data HD Dis/Chg
                if(isset($aDisChgItems) && !empty($aDisChgItems)){
                    $aInsertHDDisTmp    =   array();
                    foreach ($aDisChgItems as $nKey =>  $aItem) {
                        array_push($aInsertHDDisTmp,array(
                            'FTBchCode'             => $tBchCode,
                            'FTXthDocNo'            => $tDocNo,
                            'FDXtdDateIns'          => date('Y-m-d H:i:s',strtotime($aItem['tCreatedAt'])),
                            'FTXtdDisChgTxt'        => $aItem['tDisChgTxt'],
                            'FTXtdDisChgType'       => $aItem['nDisChgType'],
                            'FCXtdTotalAfDisChg'    => $aItem['cAfterDisChg'],
                            'FCXtdTotalB4DisChg'    => $aItem['cBeforeDisChg'],
                            'FCXtdDisChg'           => $aItem['cDisChgNum'],
                            'FCXtdAmt'              => $aItem['cDisChgValue'],
                            'FTSessionID'           => $tSessionID,
                            'FDLastUpdOn'           => date('Y-m-d h:i:s'),
                            'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                            'FDCreateOn'            => date('Y-m-d h:i:s'),
                            'FTCreateBy'            => $this->session->userdata('tSesUsername')
                        ));
                    }
                    $this->mSaleOrderDisChgModal->FSaMSOAddEditHDDisTemp($aInsertHDDisTmp);
                }
            // ==================================================================================
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Not Insert Document HD Dis Temp.'
                );
            }else{
                $this->db->trans_commit();
                // Prorate HD
                $aResProrat = FCNaHCalculateProrate('TARTSoHD',$tDocNo);
                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '',
                    'tDataVatInOrEx'    => $tVatInOrEx,
                    'tDataDocNo'        => $tDocNo,
                    'tDataDocKey'       => 'TARTSoHD',
                    'tDataSeqNo'        => ''
                ];
                $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if($aStaCalcDTTemp === TRUE){
                    $aReturnData    = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success process'
                    );
                }else{
                    $aReturnData    = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Calcurate DT Document Temp.'
                    );
                }
            }
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
}
