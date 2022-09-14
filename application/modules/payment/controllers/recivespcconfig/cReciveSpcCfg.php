<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cReciveSpcCfg extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('company/branch/mBranch');
        $this->load->model('payment/recive/mRecive');
        $this->load->model('payment/recivespcconfig/mReciveSpcCfg');
    }

    //Functionality : Function Call Page Main
    //Parameters : From Ajax File RevSpc
    //Creator : 27/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCReciveSpcCfgMainPage($nRcvSpcBrowseType, $tRcvSpcBrowseOption)
    {

        $vBtnSaveGpRcvSpc    = FCNaHBtnSaveActiveHTML('recive/0/0');
        $aAlwEventRcvSpc     = FCNaHCheckAlwFunc('recive/0/0');

        //get data RcvCode
        $tRcvCode   =   $this->input->Post('tRcvCode');
        $tRcvName   =   $this->input->Post('tRcvName');

        $aRcvCode   = array(
            'tRcvCode'   => $tRcvCode
        );

        $aRcvName   = array(
            'tRcvName'   => $tRcvName
        );

        $this->load->view('payment/recivespcconfig/wReciveSpcCfgMain', array(
            'vBtnSaveGpRcvSpc'      => $vBtnSaveGpRcvSpc,
            'aAlwEventRcvSpc'       => $aAlwEventRcvSpc,
            'aRcvCode'              => $aRcvCode,
            'aRcvName'              => $aRcvName,
            'nRcvSpcBrowseType'     => $nRcvSpcBrowseType,
            'tRcvSpcBrowseOption'   => $tRcvSpcBrowseOption
        ));
    }


    //Functionality : List Data 
    //Parameters : From Ajax File RevSpc
    //Creator : 27/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCReciveSpcCfgDataList()
    {

        $tRcvSpcCode    = $this->input->post('tRcvSpcCode');
        $tRcvSpcBchCode = $this->input->post('tRcvSpcBchCode');
        $tRcvSpcShpCode  = $this->input->post('tRcvSpcShpCode');
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage  = $this->input->post('nPageCurrent');
        }
        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        // //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //สิทธิ
        $aAlwEventRcvSpc   = FCNaHCheckAlwFunc('recive/0/0');

        $aData = array(
            'FTRcvCode'    => $tRcvSpcCode,
            'FTBchCode'    => $tRcvSpcBchCode,
            'FTShpCode'    => $tRcvSpcShpCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );

        $aResList    = $this->mReciveSpcCfg->FSaMRCVSpcDataList($aData);

        $aGenTable      = array(
            'aDataList'   => $aResList,
            'nPage'       => $nPage,
            'FTRcvCode'   =>  $tRcvSpcCode,
            'FTBchCode'    => $tRcvSpcBchCode,
            'FTShpCode'    => $tRcvSpcShpCode,
            'aAlwEventRcvSpc' =>  $aAlwEventRcvSpc,
        );

        //Return Data View
        $this->load->view('payment/recivespcconfig/wReciveSpcCfgDataTable', $aGenTable);
    }

    //Functionality :  Load Page Add CrdLogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : HTML View
    //Return Type : View
    public function FSvCReciveSpcCfgPageAdd()
    {
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $vBtnSaveGpRcvSpc  = FCNaHBtnSaveActiveHTML('recive/0/0');
        $aAlwEventRcvSpc   = FCNaHCheckAlwFunc('recive/0/0');
        $tRcvSpcCode =   $this->input->post('tRcvSpcCode');
        $tRcvSpcName =   $this->input->post('tRcvSpcName');



        $aResultConfig    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfig($tRcvSpcCode);
        // $aResultConfigValue    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfigValue($tRcvSpcCode);
        // $aResultConfigNum    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfigNumrow($tRcvSpcCode);



        $aRcvSpcCode   = array(
            'tRcvSpcCode'   => $tRcvSpcCode,

        );
        $aRcvSpcName   = array(
            'tRcvSpcName' =>  $tRcvSpcName

        );

        $aDataAdd  = array(
            'aResult'   => array('rtCode' => '99'),
            'vBtnSaveGpRcvSpc' => $vBtnSaveGpRcvSpc,
            'aAlwEventRcvSpc'  => $aAlwEventRcvSpc,
            'aRcvSpcCode'      => $aRcvSpcCode,
            'aRcvSpcName'      => $aRcvSpcName,
            'aResultConfig'      => $aResultConfig,
            'rtCode' => 0,
            // 'aResultConfigValue'      => $aResultConfigValue,
            // 'aResultConfigNum'      => $aResultConfigNum
        );
        $this->load->view('payment/recivespcconfig/wReciveSpcCfgAdd', $aDataAdd);
    }


    //Functionality :  Load Page Edit Courierlogin 
    //Parameters : 
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCReciveSpcCfgPageEdit()
    {
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $aAlwEventRcvSpc    = FCNaHCheckAlwFunc('recive/0/0');
        $aDataWhereEdit     = $this->input->post('paDataWhereEdit');
        $aData              = [
            'FTRcvCode'     => $aDataWhereEdit['ptRcvCode'],
            'FNRcvSeq'      => $aDataWhereEdit['pnRcvSeq'],
            'FNLngID'       =>  $nLangEdit
        ];
        // print_r($aData); die();
        // $aResult    = $this->mReciveSpcCfg->FSaMRCVSPCCheckID($aData);
        // $aResultConfig    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfig($aData['FTRcvCode']);
        $aResultConfig    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfigValue($aData['FTRcvCode'], $aData['FNRcvSeq']);
        // $aResultConfigNum    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfigNumrow($aData['FTRcvCode'], $aData['FNRcvSeq']);

        // $aResultConfigSelect    = $this->mReciveSpcCfg->FSaMRCVSPCCheckIDConfigSelect($aData['FTRcvCode']);



        $aRcvSpcCode   = array(
            'tRcvSpcCode'   => $aDataWhereEdit['ptRcvCode']
        );
        // $aRcvSpcName   = array(
        //     'tRcvSpcName' =>  $aDataWhereEdit['ptRcvName']

        // );
        $aDataEdit = array(
            // 'aResult'         => $aResult,
            'aResultConfig' => $aResultConfig,
            'rtCode' => 1,
            // 'aResultConfigValue' => $aResultConfigValue,
            // 'aResultConfigNum' => $aResultConfigNum,
            'aAlwEventRcvSpc' => $aAlwEventRcvSpc,
            'aRcvSpcCode'     => $aRcvSpcCode,
            //'aRcvSpcName'      => $aRcvSpcName
            // 'aResultConfigSelect' => $aResultConfigSelect
            'nFNRcvSeq' => $aData['FNRcvSeq']
        );
        $this->load->view('payment/recivespcconfig/wReciveSpcCfgAdd', $aDataEdit);
    }

    //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCReciveSpcCfgAddEvent()
    {
        $aDataMaster    = array(
            'FTRcvCode'         => $this->input->post('ohdRcvSpcCode'),
            'FTSysStaUsrValue'         => $this->input->post('oetFTSysStaUsrValue'),
            'FTSysStaUsrRef'         => $this->input->post('oetFTSysStaUsrRef'),
            // 'FTFmtCode'         => $this->input->post('ohdFmtCode'),
            'FNSysSeq'         => $this->input->post('ohdFNSysSeq'),
            'FTSysKey'         => $this->input->post('ohdFTSysKey'),
            'FNRcvSeq'          => -1,
        );

        // $aDataMasterCoonfig    = array(
        //     'FTSysStaUsrValue'         => $this->input->post('oetFTSysStaUsrValue'),
        //     'FTSysStaUsrRef'         => $this->input->post('oetFTSysStaUsrRef'),
        //     'FTFmtCode'         => $this->input->post('ohdFmtCode'),
        //     'FNSysSeq'         => $this->input->post('ohdFNSysSeq'),
        //     'FTSysKey'         => $this->input->post('ohdFTSysKey'),
        // );

        $this->mReciveSpcCfg->FSaMRCVSPCUpdateMasterConfig($aDataMaster);

        // $aChkAppCode    = $this->mReciveSpc->FSaMRcvSpcCheckCrdCode($aDataMaster);
        // if($aChkAppCode['rtCode'] == 1){
        //     // ถ้าข้อมูลซ้ำให้ออกลูป
        //     $aReturn = array(
        //         'nStaEvent' => '800',
        //         'tStaMessg' => "Data Code Is Duplicate."
        //     );
        // }else{
        // Insert Data
        $this->db->trans_begin();
        // $this->mReciveSpcCfg->FSaMRCVSPCAddMaster($aDataMaster);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess"
            );
        } else {
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success '
            );
        }
        // }
        unset($aDataMaster);
        unset($aChkAppCode);
        echo json_encode($aReturn);
    }


    //Functionality : Function Add Cardlogin
    //Parameters : From Ajax File Cardlogin
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function  FSaCReciveSpcCfgEditEvent()
    {
        $aDataMaster    = array(
            'FTRcvCode'         => $this->input->post('ohdRcvSpcCode'),
            'FNRcvSeq'          => $this->input->post('ohdRcvSpcRcvSeq'),
            'FTSysStaUsrValue'         => $this->input->post('oetFTSysStaUsrValue'),
            'FTSysStaUsrRef'         => $this->input->post('oetFTSysStaUsrRef'),
            'FTFmtCode'         => $this->input->post('ohdFmtCode'),
            'FNSysSeq'         => $this->input->post('ohdFNSysSeq'),
            'FTSysKey'         => $this->input->post('ohdFTSysKey'),
        );
        // print_r($aDataMaster); die();
        // print_r($aDataMasterCoonfig); die();
        $this->db->trans_begin();
        // $this->mReciveSpcCfg->FSaMRCVSPCUpdateMaster($aDataMaster);
        $this->mReciveSpcCfg->FSaMRCVSPCUpdateMasterConfig($aDataMaster);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $aReturn    = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess"
            );
        } else {
            $this->db->trans_commit();
            $aReturn    = array(
                'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                'nStaEvent'        => '1',
                'tStaMessg'        => 'Success '
            );
        }
        unset($aDataMaster);
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Cardlogin
    //Parameters : Ajax jReason()
    //Creator : 26/11/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCReciveSpcCfgDeleteEvent()
    {
        $aDataWhereDel  = $this->input->post('paDataWhere');
        $aDataMaster    = [
            'FTRcvCode' => $aDataWhereDel['ptRcvCode'],
            'FNRcvSeq'  => $aDataWhereDel['pnRcvSeq'],
        ];
        $aResDel        = $this->mReciveSpcCfg->FSnMRCVSpcDel($aDataMaster);
        $nNumRowRsnLoc  = $this->mReciveSpcCfg->FSnMLOCGetAllNumRow();
        if ($nNumRowRsnLoc) {
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        } else {
            echo "database error";
        }
    }


    //Functionality : Delete Cardlogin Ads Multiple
    //Parameters : Ajax jUserlogin()
    //Creator : 26/11/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCReciveSpcCfgDelMultipleEvent()
    {
        try {
            $this->db->trans_begin();
            $aDataWhereDel  = $this->input->post('paDataWhere');
            $aDataDelete    = [
                'FNRcvSeq'  => $aDataWhereDel['paRcvSeq'],
                'FTRcvCode'  => $this->input->post('nRcvCode'),                   
            ];
            $tResult    = $this->mReciveSpcCfg->FSaMRCVSPCDeleteMultiple($aDataDelete);
            if ($this->db->trans_status() == FALSE) {
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => 'Error Not Delete Data Multiple'
                );
            } else {
                $this->db->trans_commit();
                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete  Multiple'
                );
            }
        } catch (Exception $Error) {
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    }
}
