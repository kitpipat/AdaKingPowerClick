<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCheckProductPrice extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtcheckprice/mCheckProductPrice');
        // date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPIBrowseType, $tPIBrowseOption) {
        $aDataConfigView = array(
            'nPIBrowseType'     => $nPIBrowseType,
            'tPIBrowseOption'   => $tPIBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dasPDTCheckProductPrice/0/0'),
        );
        $this->load->view('product/pdtcheckprice/wPdtCheckPrice', $aDataConfigView);
    }

    //Functionality : Function Get ProductPrice List
	//Parameters : -
	//Creator : 03/09/2020 Sooksanti(Non)
	//Last Modified :-
	//Return :-
	//Return Type : -
    public function FSxCPPGetListPage(){
        try {
            $nPage = $this->input->post('nPageCurrent');
            // Page Current 
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }

            $aParams = array(
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'nRow'              => 100,
                'nPage'             => $nPage,
                'oAdvanceSearch'    => $this->input->post('oAdvanceSearch'),
                'nPagePDTAll'       => $this->input->post('nPagePDTAll'),
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
                'tDisplayType'      => $this->input->post('tDisplayType')
            );
            $aDataList = $this->mCheckProductPrice->FSaMCPPGetListData($aParams);
            $aData = [
                'aDataList'         => $aDataList,
                'nPage'             => $nPage,
                'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
                'tPdtForSys'        => $this->input->post('tPdtForSys'),
                'tDisplayType'      => $this->input->post('tDisplayType')
            ];
            $this->load->view('product/pdtcheckprice/wPdtCheckPriceTable',$aData);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        
    }

    function FSxCPPFormSearchList(){
        try {
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aParams = array(
                'FNLngID'    => $nLangEdit,
            );
            $aDataList = $this->mCheckProductPrice->FSaMCPPGetPriList($aParams);
            $aData = [
                'aDataList'  => $aDataList,
            ];
            $this->load->view('product/pdtcheckprice/wPdtCheckPriceSearchlist',$aData);
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
    }

}