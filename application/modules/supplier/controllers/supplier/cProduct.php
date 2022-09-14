<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cProduct extends CI_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos5/supplier/mProduct');
    }

    public function index(){
        // $this->load->view('pos5/supplier/product/wProduct');
    }

    //Functionality : Function Call Page Product List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCPDTListPage(){
        $this->load->view('pos5/supplier/product/wProductList');
    }

    //Functionality : Function Call View Data Product
    //Parameters : Ajax Call View DataTable
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCPDTDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $tSplCode       = $this->input->post('tSplCode');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSplCode'       => $tSplCode,
                'tSearchAll'    => $tSearchAll
            );
            $aDataList   = $this->mProduct->FSaMPDTList($aData);
            $aGenTable  = array(
                'aDataList'  => $aDataList,
                'nPage'         => $nPage,
                'tSplCode'         => $tSplCode,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('pos5/supplier/product/wProductDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Add
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCPDTAddPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataProduct = array(
                'nStaAddOrEdit'   => 99,
                'tSplCode'   => $this->input->post('tSplCode'),
				'aVatRate'		=> $aVatList
            );
            $this->load->view('pos5/supplier/product/wProductAdd',$aDataProduct);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Edits
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCPDTEditPage(){
        try{
            $tSplCode       = $this->input->post('tSplCode');
            $tPdtCode       = $this->input->post('tPdtCode');
            $tBarCode       = $this->input->post('tBarCode');
            $tLngID       = $this->input->post('tLngID');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $aData  = array(
                'FTSplCode' => $tSplCode,
                'FTPdtCode' => $tPdtCode,
                'FTBarCode' => $tBarCode,
                'FNLngID'   => $tLngID
            );
            // echo '<pre>';
            // print_r($aData);
            // exit;
            $aDataByID = $this->mProduct->FSaMPDTGetDataByID($aData);
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataProduct  = array(
                'nStaAddOrEdit' => 1,
				'aVatRate'		=> $aVatList,
				'tSplCode'		=> $tSplCode,
                'aDataSplPdt'      => $aDataByID
            );
            $this->load->view('pos5/supplier/product/wProductAdd',$aDataProduct);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPDTAddEvent(){
        try{
            $tSplCode = $this->input->post('tSplCode');
            // $aPdtCode       = $this->input->post('aPdtCode');
            $aBarCode = $this->input->post('aBarCode');
            // echo '<pre>';
            // print_r($aBarCode);
            // exit;
            $this->db->trans_begin();
            $aPdtCode = $this->mProduct->FSaMPDTGetPdtCode($aBarCode);
            // echo '<pre>';
            // print_r($aPdtCode);
            if(FCNnHSizeOf($aPdtCode['raItem']) > 0){
                foreach($aPdtCode['raItem'] as $nKey => $aVal){
                    $aDataMaster = array(
                        'FTPdtCode' => $aVal['FTPdtCode'],
                        'FTBarCode' => $aVal['FTBarCode'],
                        'FTSplStaAlwPO' => '1',
                        'FTSplCode' => $tSplCode
                    );
                    $aChkDup = $this->mProduct->FSaMPDTChkDup($aDataMaster);
                    if($aChkDup['raItem'] < 1){
                        $this->mProduct->FSaMPDTAddMaster($aDataMaster);
                    }
                }
            }
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Product."
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $tSplCode,
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Product
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPDTEditEvent(){
        try{
            $aDataMaster = array(
                'FTPdtCode' => $this->input->post('oetPdtCode'),//
                'FTBarCode' => $this->input->post('oetBarCode'),//
                'FTSplCode' => $this->input->post('oetSplCodePdt'),//
                'FCSplLastPrice' => $this->input->post('oetSplLastPrice') == '' ? 0 : $this->input->post('oetSplLastPrice'),//
                'FDSplLastDate' => $this->input->post('oetSplLastDate') != '' ? $this->input->post('oetSplLastDate') : null,//
                'FTUsrCode' => $this->input->post('oetPdtUsrCode'),//
                'FTSplStaAlwPO' => $this->input->post('ocbSplStaAlwPO') == 'on' ? '1' : '',//
                'FDPdtAlwOrdStart' => $this->input->post('oetPdtAlwOrdStart') != '' ? $this->input->post('oetPdtAlwOrdStart') : null,//--
                'FDPdtAlwOrdStop' => $this->input->post('oetPdtAlwOrdStop') != '' ? $this->input->post('oetPdtAlwOrdStop') : null,//--
                'FTPdtOrdDay' => $this->input->post('oetPdtOrdDay'),//
                'FTPdtStaAlwOrdSun' => $this->input->post('ocbPdtStaAlwOrdSun') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdMon' => $this->input->post('ocbPdtStaAlwOrdMon') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdTue' => $this->input->post('ocbPdtStaAlwOrdTue') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdWed' => $this->input->post('ocbPdtStaAlwOrdWed') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdThu' => $this->input->post('ocbPdtStaAlwOrdThu') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdFri' => $this->input->post('ocbPdtStaAlwOrdFri') == 'on' ? '1' : '',
                'FTPdtStaAlwOrdSat' => $this->input->post('ocbPdtStaAlwOrdSat') == 'on' ? '1' : '',
                'FCPdtLeadTime' => $this->input->post('oenPdtLeadTime') == '' ? 0 : $this->input->post('oenPdtLeadTime')//
            );
            
            $this->db->trans_begin();
            $this->mProduct->FSaMPDTUpdateMaster($aDataMaster);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Product."
                );
            }else{
                $this->db->trans_commit();
                
                $aReturn = array(                    
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Product.'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product
    //Parameters : Ajax jReason()
    //Creator : 22/10/2018 Phisan
    //Return : Status Delete Event 
    //Return Type : String
    public function FSoCPDTDeleteEvent(){
        try{
            $tSplCode = $this->input->post('tSplCode');
            $tLngID = $this->input->post('tLngID');
            $tBar = $this->input->post('tBar');
            $tPdtCode = $this->input->post('tPdtCode');
            
            $aDataMaster = array(
                'FTSplCode' => $tSplCode,
                'FNLngID' => $tLngID,
                'FTBarCode' => $tBar,
                'FTPdtCode' => $tPdtCode
            );
            $aResDel        = $this->mProduct->FSnMPDTDel($aDataMaster);
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    

    //Function : Get รายการสินค้า
    //Parameters : Ajax jReason()
    //Creator : 14/01/2019 Phisan
    //Return : View 
    //Return Type : View
    public function FMvCPDTGetPdtList(){

        $nPage      = $this->input->post('nPageCurrent');
        // echo $this->input->post('tStaPage');
        // exit;

        if($nPage == ''){
            $nPage = 1;
        }

        $aDataSearch = array(
            'tPdtCode'      => $this->input->post('tPdtCode'),
            'tPdtBarCode'   => $this->input->post('tPdtBarCode'),
            'tPdtPdtName'   => $this->input->post('tPdtPdtName'),
            'tPdtPunCode'   => $this->input->post('tPdtPunCode'),
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tStaPage'      => $this->input->post('tStaPage'),
        );

        $aPdtList =  FSxMPDTGetBwsDataList($aDataSearch);
        // echo '<pre>';
        // print_r($aPdtList);
        // exit;
        $aData = array(
            'aPdtList'  => $aPdtList,
            'nPage'    =>$nPage,
        );

        $this->load->view('common/BrowseProduct/wBrowsePdtList',$aData);

    }



















}