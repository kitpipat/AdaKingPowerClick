<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cCard extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment/card/mCard');
    }

    public function index($nCrdBrowseType, $tCrdBrowseOption)
    {
        $nMsgResp   = array('title' => "Card");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if (!$isXHR) {
            $this->load->view('common/wHeader', $nMsgResp);
            $this->load->view('common/wTopBar', array('nMsgResp' => $nMsgResp));
            $this->load->view('common/wMenu', array('nMsgResp' => $nMsgResp));
        }
        $vBtnSave           = FCNaHBtnSaveActiveHTML('card/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCard        = FCNaHCheckAlwFunc('card/0/0');

        $this->load->view('payment/card/wCard', array(
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nCrdBrowseType'    => $nCrdBrowseType,
            'tCrdBrowseOption'  => $tCrdBrowseOption,
            'aAlwEventCard'     => $aAlwEventCard
        ));
    }

    //Functionality : Function Call Page Card List
    //Parameters : Ajax and Function Parameter
    //Creator : 10/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCRDListPage()
    {
        $aAlwEventCard        = FCNaHCheckAlwFunc('card/0/0');
        $aNewData              = array('aAlwEventCard' => $aAlwEventCard);
        $this->load->view('payment/card/wCardList', $aNewData);
    }

    //Functionality : Function Call View Data Card
    //Parameters : Ajax Call View DataTable
    //Creator : 10/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCRDDataList()
    {
        try {
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCard_L');
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


            $aCrdDataList   = $this->mCard->FSaMCRDList($aData);
            $aAlwEvent = FCNaHCheckAlwFunc('card/0/0'); //Controle Event
            $aGenTable  = array(
                'aCrdDataList'  => $aCrdDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll,
                'aAlwEventCard' => $aAlwEvent
            );
            $this->load->view('payment/card/wCardDataTable', $aGenTable);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function CallPage Card Add
    //Parameters : Ajax Call View Add
    //Creator : 10/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCRDAddPage()
    {
        try {
            $aDataCard = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'     => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'     => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('payment/card/wCardAdd', $aDataCard);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Function CallPage Card Edits
    //Parameters : Ajax Call View Add
    //Creator : 10/10/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCRDEditPage()
    {
        try {
            $tCrdCode       = $this->input->post('tCrdCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMCard_L');
            $aData  = array(
                'FTCrdCode' => $tCrdCode,
                'FNLngID'   => $nLangEdit
            );

            $aCrdData        = $this->mCard->FSaMCRDGetDataByID($aData);
            $aSumTotalCard   = $this->mCard->FSnMCRDDataSumTotalCard($aData);

            if (isset($aCrdData['raItems']['rtCrdImgObj']) && !empty($aCrdData['raItems']['rtCrdImgObj'])) {
                $tImgObj         = $aCrdData['raItems']['rtCrdImgObj'];
                $aImgObjPath    = explode("application/modules/", $tImgObj);
                $aImgObjName    = explode("/", $tImgObj);

                $tImgObjPath    = end($aImgObjPath);
                $tImgObjName    = end($aImgObjName);
            } else {
                $tImgObjPath    = "";
                $tImgObjName    = "";
            }

            $aDataCard  = array(
                'nStaAddOrEdit'  => 1,
                'aCrdData'       => $aCrdData,
                'tImgObjPath'    => $aCrdData['raItems']['rtCrdImgObj'],
                'aSumTotalCard'  => $aSumTotalCard
            );
            $this->load->view('payment/card/wCardAdd', $aDataCard);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Add Card
    //Parameters : Ajax Event
    //Creator : 10/10/2018 wasin
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCRDAddEvent()
    {
        try {

            $tIsAutoGenCode = $this->input->post('ocbCardAutoGenCode');

            // Setup Reason Code
            $tCrdCode = "";
            if (isset($tIsAutoGenCode) && $tIsAutoGenCode == '1') {
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName"    => 'TFNMCard',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tCrdCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TFNMCard');
                // if($aGenCode['rtCode'] == '1'){
                // $tCrdCode = $aGenCode['rtCrdCode'];
                // }
            } else {
                $tCrdCode = $this->input->post('oetCrdCode');
            }

            $tImageUplode       = $this->input->post('oetImgInputCard');
            $tImageUplodeOld    = $this->input->post('oetImgInputCardOld');

            $aDataCard  = array(
                'FTCrdCode'         => $tCrdCode,
                'FDCrdStartDate'    => (!empty($this->input->post('oetCrdStartDate'))) ? $this->input->post('oetCrdStartDate') : null,
                'FDCrdExpireDate'   => (!empty($this->input->post('oetCrdExpireDate'))) ? $this->input->post('oetCrdExpireDate') : null,
                'FTCtyCode'         => $this->input->post('oetCrdCtyCode'),
                // 'FCCrdDeposit'      => str_replace(',','',$this->input->post('oetCrdDeposit')),
                'FTCrdHolderID'     => $this->input->post('oetCrdHolderID'),
                'FTCrdRefID'        => $this->input->post('oetCrdRefID'),
                // 'FTCrdStaType'      => $this->input->post('ocmCrdStaType'),
                'FTDptCode'         => $this->input->post('oetCrdDepartment'),
                //'FTCrdStaLocate'    => ($this->input->post('ocmCrdStaType') == 1)? '1' : '2',
                'FTCrdStaShift'     => 1,
                'FTCrdStaActive'    => $this->input->post('ocmCrdStaAct'),
                'FTCrdName'         => $this->input->post('oetCrdName'),
                'FTCrdRmk'          => $this->input->post('otaCrdRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'         => $this->input->post('oetCrdAgnCode'),


            );
            $oCountDup      = $this->mCard->FSnMCRDCheckDuplicate($aDataCard['FTCrdCode']);
            $nStaDup        = $oCountDup['counts'];
            if ($oCountDup !== FALSE && $nStaDup == 0) {
                $this->db->trans_begin();
                $aStaCrdMaster  = $this->mCard->FSaMCRDAddUpdateMaster($aDataCard);
                $aStaCrdLang    = $this->mCard->FSaMCRDAddUpdateLang($aDataCard);
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Card."
                    );
                } else {
                    $this->db->trans_commit();
                    if ( $tImageUplode != $tImageUplodeOld ) {
                        $aImageUplode = array(
                            'tModuleName'       => 'payment',
                            'tImgFolder'        => 'card',
                            'tImgRefID'         => $tCrdCode,
                            'tImgObj'           => $tImageUplode,
                            'tImgTable'         => 'TFNMCard',
                            'tTableInsert'      => 'TCNMImgObj',
                            'tImgKey'           => 'main',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        $aImgReturn = FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturn = array(
                        'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                        'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'    => $aDataCard['FTCrdCode'],
                        'nStaEvent'        => '1',
                        'tStaMessg'        => 'Success Add Card'
                    );
                }
            } else {
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('common/main/main', 'tDataDuplicate')
                );
            }
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Edit Card
    //Parameters : Ajax Event
    //Creator : 10/10/2018 wasin
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCRDEditEvent()
    {
        try {
            // echo "Save"; //Save ได้
            $tImageUplode = $this->input->post('oetImgInputCard');
            $tImageUplodeOld    = $this->input->post('oetImgInputCardOld');
            $aDataCard  = array(
                'FTCrdCode'         => $this->input->post('oetCrdCode'),
                'FDCrdStartDate'    => (!empty($this->input->post('oetCrdStartDate'))) ? $this->input->post('oetCrdStartDate') : null,
                'FDCrdExpireDate'   => (!empty($this->input->post('oetCrdExpireDate'))) ? $this->input->post('oetCrdExpireDate') : null,
                'FTCtyCode'         => $this->input->post('oetCrdCtyCode'),
                // 'FCCrdDeposit'      => str_replace(',','',$this->input->post('oetCrdDeposit')),
                'FTCrdHolderID'     => $this->input->post('oetCrdHolderID'),
                'FTCrdRefID'        => $this->input->post('oetCrdRefID'),
                // 'FTCrdStaType'      => $this->input->post('ocmCrdStaType'),
                'FTDptCode'         => $this->input->post('oetCrdDepartment'),
                //'FTCrdStaLocate'    => ($this->input->post('ocmCrdStaType') == 1)? '1' : '2',
                'FTCrdStaShift'     => 1,
                'FTCrdStaActive'    => $this->input->post('ocmCrdStaAct'),
                'FTCrdName'         => $this->input->post('oetCrdName'),
                'FTCrdRmk'          => $this->input->post('otaCrdRmk'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'         => $this->input->post('oetCrdAgnCode'),
            );
            $this->db->trans_begin();
            $aStaCrdMaster  = $this->mCard->FSaMCRDAddUpdateMaster($aDataCard);
            $aStaCrdLang    = $this->mCard->FSaMCRDAddUpdateLang($aDataCard);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Card."
                );
            } else {
                $this->db->trans_commit();
                if ( $tImageUplode != $tImageUplodeOld ) {
                    $aImageUplode = array(
                        'tModuleName'       => 'payment',
                        'tImgFolder'        => 'card',
                        'tImgRefID'         => $aDataCard['FTCrdCode'],
                        'tImgObj'           => $tImageUplode,
                        'tImgTable'         => 'TFNMCard',
                        'tTableInsert'      => 'TCNMImgObj',
                        'tImgKey'           => 'main',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    $aImgReturn = FCNnHAddImgObj($aImageUplode);
                }
                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataCard['FTCrdCode'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Update Card.'
                );
            }

            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Event Delete Card
    //Parameters : Ajax jReason()
    //Creator : 10/10/2018 wasin
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCRDDeleteEvent()
    {
        try {
            $tIDCode = $this->input->post('tIDCode');
            $aDataMaster = array(
                'FTCrdCode' => $tIDCode
            );
            $aResDel        = $this->mCard->FSnMCRDDel($aDataMaster);
            if ($aResDel['rtCode'] == 1) {
                $aDeleteImage = array(
                    'tModuleName'  => 'payment',
                    'tImgFolder'   => 'card',
                    'tImgRefID'    => $tIDCode,
                    'tTableDel'    => 'TCNMImgObj',
                    'tImgTable'    => 'TFNMCard'
                );
                $nStaDelImgInDB =   FSnHDelectImageInDB($aDeleteImage);
                if ($nStaDelImgInDB == 1) {
                    FSnHDeleteImageFiles($aDeleteImage);
                }
            }
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    public function FSvCCRDChkStaAct()
    {
        $tCrdHolderID = $this->input->post('tCrdHolderID');

        $aData  = $this->mCard->FSnMCRDChkStaCrd($tCrdHolderID);
        if ((int)$aData[0]['nCardActived'] > 0) {
            echo "NotSave"; //Save ไม่ได้ให้เปลี่ยน สถานะ
        } else {
            echo "Save"; //Save ได้
        }
    }

    /**
     * Functionality : Get Card History Table
     * Parameters : -
     * Creator : 15/12/2020 piya
     * Last Modified : -
     * Return : View
     * Return Type : View
     */
    public function FSvCCRDGetHisDataTable()
    {
        try {
            $tBchCode = $this->input->post('tBchCode');
            $tHisDate = $this->input->post('tHisDate');
            $tCrdCode = $this->input->post('tCrdCode');
            $nLangEdit = $this->session->userdata("tLangEdit");
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            $aAlwEvent = FCNaHCheckAlwFunc('card/0/0');

            $aGetHisDataTableParams = [
                'tBchCode' => $tBchCode,
                'tHisDate' => $tHisDate,
                'tCrdCode' => $tCrdCode,
                'nLngID' => $nLangEdit
            ];
            $aCrdHisData = $this->mCard->FSaMCRDGetHisDataTable($aGetHisDataTableParams);
            
            $aCrdHisTableParams = [
                'aDataList' => $aCrdHisData,
                'aAlwEvent' => $aAlwEvent,
                'nOptDecimalShow' => $nOptDecimalShow
            ];
            $this->load->view('payment/card/advance_table/wCardHisDataTable', $aCrdHisTableParams);
        } catch (Exception $Error) {
            echo $Error;
        }
    }
}
