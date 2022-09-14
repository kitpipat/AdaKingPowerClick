<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBrowseProduct extends MX_Controller {

    public function __construct() {

        parent::__construct ();
        $this->load->helper('url');
    }

    //Function : Get รายการสินค้า
    public function FMvCBWSPDTGetPdtList(){

        $nPage      = $this->input->post('nPageCurrent');
        // echo $this->input->post('tStaPage');
        // exit;

        if($nPage == ''){
            $nPage = 1;
        }

        $aDataSearch = array(
            'tSplCode'      => $this->input->post('tSplCode'),
            'tPdtCode'      => $this->input->post('tPdtCode'),
            'tPdtBarCode'   => $this->input->post('tPdtBarCode'),
            'tPdtPdtName'   => $this->input->post('tPdtPdtName'),
            'tPdtPunCode'   => $this->input->post('tPdtPunCode'),
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tStaPage'      => $this->input->post('tStaPage'),
        );

        $aPdtList =  FCNxHGetPdtList($aDataSearch);
        // echo '<pre>';
        // print_r($aPdtList);
        // exit;
        $aData = array(
            'aPdtList'  => $aPdtList,
            'nPage'    =>$nPage,
        );

        $this->load->view('document/browseproduct/wBrowsePdtList',$aData);

    }

    //Function : Get รายการสินค้า
    public function FMvCBWSPDTGetPdtDetailList(){

        $aDataSearch = array(
            'tPdtCode'      => $this->input->post('tPdtCode'),
            'tSplCode'      => $this->input->post('tSplCode'),
            'tPdtBarCode'   => $this->input->post('tPdtBarCode'),
            'tPdtPdtName'   => $this->input->post('tPdtPdtName'),
            'tPdtPunCode'   => $this->input->post('tPdtPunCode'),
            'tStaPage'      => $this->input->post('tStaPage')
        );

        //ต้นทุนสำหรับ การสั่งซื้อ ซื้อ เพิ่มหนี้ (ผู้จำหน่าย)
        //1 ต้นทุนเฉลี่ย ,2 ต้นทุนสุดท้าย ,3 ต้นทุนมาตรฐาน 
        $nCostPurPO = FCNnHDOCGetCostPurPO();

        $aPdtDetailList =  FCNxHGetPdtDetailList($aDataSearch);
        //Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
        // echo '<pre>';
        // print_r($aPdtDetailList);
        $aData = array(
            'aPdtDetailList'    =>  $aPdtDetailList,
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nCostPurPO'        =>  $nCostPurPO,
            'tXphVATInOrEx'     =>  $this->input->post('tXphVATInOrEx'), // ภาษี ของ Suplier 
        );

        $this->load->view('document/browseproduct/wBrowsePdtDetailList',$aData);

    }

}