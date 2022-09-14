<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVendingmanage extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('vending/vendingshoplayout/mVendingmanage');
        date_default_timezone_set("Asia/Bangkok");
    }

    //Page Add
    public function FSaVSLManagePageADD(){
        $nShpID         = $this->input->post('nID');
        $nLangID        = $this->session->userdata("tLangID");
        $aHD            = $this->mVendingmanage->FSaMVslGetDataHD($nShpID,$nLangID);
        $aDT            = $this->mVendingmanage->FSaMVslGetDataDT($nShpID,$nLangID);

        if($aDT['rtCode'] == 800 || $aDT['rtCode'] == '800'){
            $tTypePage = 'Add';
        }else{
            $tTypePage = 'Edit';
        }

        $aData = array(
            'aHD'       => $aHD,
            'aDT'       => $aDT,
            'tTypePage' => $tTypePage
        );
        $this->load->view('vending/vendingshoplayout/vendingmanage/wVendingmanageAdd',$aData);
    }

    //Event Add
    public function FSaVSLManageEventADD(){
        $aData      = $this->input->post('aData');
        $nCountData = FCNnHSizeOf($aData);

        if($aData[0][0] == 0){
            $aDateDelete = array(
                'FTShpCode' => $aData[0][1]['FTShpCode']
            );
            $this->mVendingmanage->FSaMVslDeleteItem($aDateDelete);
            $aReturn = array(
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $aData[0][1]['FTShpCode'],
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add Event'
            );
            echo json_encode($aReturn);
        }else{
            if($nCountData >= 1){
                $aDateDelete = array(
                    'FTBchCode'         => $aData[0][1]['FTBchCode'],
                    'FTShpCode'         => $aData[0][1]['FTShpCode']
                );
                $this->mVendingmanage->FSaMVslDeleteItem($aDateDelete);
            }

            $aDataFindMercode = array(
                'FTBchCode'         => $aData[0][1]['FTBchCode'],
                'FTShpCode'         => $aData[0][1]['FTShpCode']
            );
            $aReturnMerCode = $this->mVendingmanage->FSaMVslFindMerCode($aDataFindMercode);
            
            for($i=0; $i<$nCountData; $i++){
                
                $aBranchCode = explode(",",$aData[$i][1]['FTBchCode']);
                for($j=0; $j<$aData[$i][1]['CountBch']; $j++){
                    $aDataInsert = array(
                        'FTBchCode'         => trim($aBranchCode[$j]),
                        'FTMerCode'         => $aReturnMerCode['raItems'][0]['FTMerCode'],
                        'FTShpCode'         => $aData[$i][1]['FTShpCode'],
                        'FNLayRow'          => $aData[$i][1]['FNLayRow'],
                        'FNLayCol'          => $aData[$i][1]['FNLayCol'],
                        'FTPdtCode'         => $aData[$i][1]['FTPdtCode'],    
                        'FCLayColQtyMax'    => $aData[$i][1]['FCLayDim'],
                        'FCLayDim'          => $aData[$i][1]['FCLayDim'],
                        'FCLayHigh'         => $aData[$i][1]['FCLayHigh'],
                        'FCLayWide'         => $aData[$i][1]['FCLayWide'],
                        'FTLayStaUse'       => 1,
                        'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                        'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                        'FDCreateOn'        => date('Y-m-d H:i:s'),
                        'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    );
                    
                    $this->mVendingmanage->FSaMVslInsertPDT($aDataInsert);
                }
            }
    
            if($nCountData >= 1){
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aData[0][1]['FTShpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }else{
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }
            echo json_encode($aReturn);    
        }
    }

}
