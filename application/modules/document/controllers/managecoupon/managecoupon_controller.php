<?php
defined('BASEPATH') or exit('No direct script access allowed');

class managecoupon_controller extends MX_Controller {

    public $tRouteMenu  = 'docManageCoupon/0/0';

    public function __construct() {
        date_default_timezone_set("Asia/Bangkok");
        $this->load->model('document/managecoupon/managecoupon_model');
        parent::__construct();
    }

    public function index($pnBrowseType,$ptBrowseOption){
        $aDataConfigView    = [
            'nMCPBrowseType'    => $pnBrowseType,
            'tMCPBrowseOption'  => $ptBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc($this->tRouteMenu),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML($this->tRouteMenu),
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('document/managecoupon/wManageCoupon',$aDataConfigView);
    }

    public function FSvCMCPFormSearchList(){
        $this->load->view('document/managecoupon/wManageCouponFormSearchList');
    }

    public function FSoCMCPPageDataTable() {
        try{
            $aAdvanceSearch     = $this->input->post('oAdvanceSearch');
            $nPage              = $this->input->post('nPageCurrent');
            $aAlwEvent          = FCNaHCheckAlwFunc($this->tRouteMenu);
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Page Current 
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }

            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // ค้นหา Config หมดอายุ
            $aParamGetConfig = array(
                'tSysCode'  => 'nCN_QRTimeout',
                'tSysApp'   => 'CN',
                'tSysKey'   => 'QR',
                'tSysSeq'   => '1',
                'tGmnCode'  => 'MPOS'
            );
            $aGetDataSysConfig = FCNaGetSysConfig($aParamGetConfig);
            if( $aGetDataSysConfig['rtCode'] == '1' ){
                // กำหนดเอง : 1:ชั่วโมง 2:วัน
                if( !empty($aGetDataSysConfig['raItems']['FTSysStaUsrValue']) ){
                    $tAddDateType = $aGetDataSysConfig['raItems']['FTSysStaUsrValue'];
                }else{
                    $tAddDateType = $aGetDataSysConfig['raItems']['FTSysStaDefValue'];
                }
                // ค่าอ้างอิง: จำนวนอายุของคิวอาร์โค้ด
                if( !empty($aGetDataSysConfig['raItems']['FTSysStaUsrRef']) ){
                    $nValueExpire = $aGetDataSysConfig['raItems']['FTSysStaUsrRef'];
                }else{
                    $nValueExpire = $aGetDataSysConfig['raItems']['FTSysStaDefRef'];
                }
                
                $aExpireConfig = array(
                    'tAddDateType'  => $tAddDateType,
                    'nValueExpire'  => $nValueExpire
                );
            }else{
                // ถ้าไม่เจอ Config ให้ Default เป็น วัน และ จำนวนหมดอายุเป็น 1
                $aExpireConfig = array(
                    'tAddDateType'  => '2',
                    'nValueExpire'  => 1
                );
            }

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'               => $nLangEdit,
                'nPage'                 => $nPage,
                'nRow'                  => 10,
                'aAdvanceSearch'        => $aAdvanceSearch,
                'aExpireConfig'         => $aExpireConfig
            );
            $aDataList = $this->managecoupon_model->FSaMMCPGetDataTableList($aDataCondition);

            $aConfigView    = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList,
                'aExpireConfig'     => $aExpireConfig
            );
            $tMCPViewDataTableList  = $this->load->view('document/managecoupon/wManageCouponDataTable',$aConfigView,true);
            $aReturnData = array(
                'tMCPViewDataTableList' => $tMCPViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    public function FSoCMCPPageViewDetails() {
        try{
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'       => $nLangEdit,
                'tBchCode'      => $this->input->post('ptBchCode'),
                'tDocNo'        => $this->input->post('ptDocNo'),
                'tType'         => $this->input->post('ptType')
            );
            $aDataList = $this->managecoupon_model->FSaMMCPGetDetailList($aDataCondition);

            $aConfigView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aDataList'         => $aDataList
            );
            $tMCPViewDetailsList  = $this->load->view('document/managecoupon/wManageCouponViewDetails',$aConfigView,true);
            $aReturnData = array(
                'tMCPViewDetailsList'   => $tMCPViewDetailsList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By : Napat(Jame) 03/02/2022
    public function FSoCMCPEventAdjustStatus(){
        try{
            // Data Conditon
            $aDataCondition = array(
                'tDocNoMulti'      => str_replace(",","','",$this->input->post('ptDocNoMulti')),
                'tEventAction'     => $this->input->post('ptEventAction')
            );
            $aAdjSta = $this->managecoupon_model->FSaMMCPAdjustStatus($aDataCondition);
            $aReturnData = array(
                'nStaEvent'             => $aAdjSta['tCode'],
                'tStaMessg'             => $aAdjSta['tDesc']
            );
        }catch (Exception $Error) {
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

}