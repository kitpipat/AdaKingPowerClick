<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtPrice extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtprice/mPdtPrice');
    }

    public function index() {

    }

    //Functionality: ฟังก์ชั่น Call Modal Price List
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 27/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtPriceList(){
        try{
            $tPriceDTPdtCode = $this->input->post('ptPriceDTPdtCode');
            $tPriceDTPdtName = $this->input->post('ptPriceDTPdtName');
            
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aDataWhere     = array('FNLngID'=>$nLangEdit);
            $aDataPriDTUnit = $this->mPdtPrice->FSaMPDTGetDataPdtPriModalUnit($aDataWhere);
            $tPdtModalPriceList = $this->load->view('product/pdtprice/wPdtPriceMain',array(
                'ntDecSave'         => FCNxHGetOptionDecimalSave(),
                'tPriceDTPdtCode'   => $tPriceDTPdtCode,
                'tPriceDTPdtName'   => $tPriceDTPdtName,
                'aDataPriDTUnit'    => $aDataPriDTUnit,
            ),true);
            $aReturnData    = array(
                'vPdtModalPriceList'    => $tPdtModalPriceList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: ฟังก์ชั่น Call Data Table Price 4 Pdt
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 11/03/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtTablePrice4PDT(){
        try{
            // Check Number Page
            $aDataPriListFilter = $this->input->post('aDataPriListFilter');
            $nPage              = ($aDataPriListFilter['nPageCurrent'] == '' || null)? 1 : $aDataPriListFilter['nPageCurrent'];
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aLangHave          = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave          = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            // Array Where Price 4 PDT
            $aWherePrice4Pdt    = array(
                'pnPage'        => $nPage,
                'pnRow'         => 5,
                'pnLngID'       => $nLangEdit,
                'ptPdtCode'     => $aDataPriListFilter['tPriceDTPdtCode'],
                'ptPghDocType'  => $aDataPriListFilter['tPriceDTPriType'],
                'ptPunCode'     => $aDataPriListFilter['tPriceDTPriUnit'],
                'ptBchCode'     => $this->session->userdata('tSesUsrBchCode'),
                'ptShpCode'     => $this->session->userdata('tSesUsrShpCode'),
                'pdPghDStart'   => $aDataPriListFilter['tPriceDTPriDateStart'],
            );
            $aPdtData4PDT       = FCNaHGetDataPrice4Pdt($aWherePrice4Pdt);
            $nDecimalNumberFM   = FCNxHGetOptionDecimalSave();
            $tPdtPriceTable4PDT = $this->load->view('product/pdtprice/wPdtPriceTable4PDT',array(
                'nDecimalNumberFM'  => $nDecimalNumberFM,
                'aPdtData4PDT'      => $aPdtData4PDT,
            ),true);
            $aReturnData = array(
                'tPriceDTTabSlt'    => $aDataPriListFilter['tPriceDTTabSlt'],
                'tViewTable4PDT'    => $tPdtPriceTable4PDT,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: ฟังก์ชั่น Call Data Table Price 4 CST
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 11/03/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtTablePrice4CST(){
        try{
            // Check Number Page
            $nPage              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');
            $aDataPriListFilter = $this->input->post('aDataPriListFilter');
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aLangHave          = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave          = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            // Array Where Price 4 CST
            $aWherePrice4CST    = array(
                'pnPage'        => $nPage,
                'pnRow'         => 10,
                'pnLngID'       => $nLangEdit,
                'ptPdtCode'     => $aDataPriListFilter['tPriceDTPdtCode'],
                'ptPghDocType'  => $aDataPriListFilter['tPriceDTPriType'],
                'ptPunCode'     => $aDataPriListFilter['tPriceDTPriUnit'],
                'ptBchCode'     => $this->session->userdata('tSesUsrBchCode'),
                'ptShpCode'     => $this->session->userdata('tSesUsrShpCode'),
                'pdPghDStart'   => $aDataPriListFilter['tPriceDTPriDateStart'],
                'pCstGrpCode'   => $aDataPriListFilter['tPriceDTPriCstGrpCode']
            );
            $aPdtData4CST       = FCNaHGetDataPrice4CST($aWherePrice4CST);
            $nDecimalNumberFM   = FCNxHGetOptionDecimalSave();
            $tPdtPriceTable4CST = $this->load->view('product/pdtprice/wPdtPriceTable4CST',array(
                'nDecimalNumberFM'  => $nDecimalNumberFM,
                'aPdtData4CST'      => $aPdtData4CST,
            ),true);
            $aReturnData = array(
                'tPriceDTTabSlt'    => $aDataPriListFilter['tPriceDTTabSlt'],
                'tViewTable4CST'    => $tPdtPriceTable4CST,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: ฟังก์ชั่น Call Data Table Price 4 ZNE
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 11/03/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtTablePrice4ZNE(){
        try{
            // Check Number Page
            $nPage              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');
            $aDataPriListFilter = $this->input->post('aDataPriListFilter');
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aLangHave          = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave          = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            // Array Where Price 4 ZNE
            $aWherePrice4ZNE    = array(
                'pnPage'        => $nPage,
                'pnRow'         => 10,
                'pnLngID'       => $nLangEdit,
                'ptPdtCode'     => $aDataPriListFilter['tPriceDTPdtCode'],
                'ptPghDocType'  => $aDataPriListFilter['tPriceDTPriType'],
                'ptPunCode'     => $aDataPriListFilter['tPriceDTPriUnit'],
                'ptBchCode'     => $this->session->userdata('tSesUsrBchCode'),
                'ptShpCode'     => $this->session->userdata('tSesUsrShpCode'),
                'pdPghDStart'   => $aDataPriListFilter['tPriceDTPriDateStart'],
                'ptZneChain'    => $aDataPriListFilter['tPriceDTPriZneCode'],
            );
            $aPdtData4ZNE       = FCNaHGetDataPrice4ZNE($aWherePrice4ZNE);
            $nDecimalNumberFM   = FCNxHGetOptionDecimalSave();
            $tPdtPriceTable4ZNE = $this->load->view('product/pdtprice/wPdtPriceTable4ZNE',array(
                'nDecimalNumberFM'  => $nDecimalNumberFM,
                'aPdtData4ZNE'      => $aPdtData4ZNE,
            ),true);
            $aReturnData = array(
                'tPriceDTTabSlt'    => $aDataPriListFilter['tPriceDTTabSlt'],
                'tViewTable4ZNE'    => $tPdtPriceTable4ZNE,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: ฟังก์ชั่น Call Data Table Price 4 BCH
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 11/03/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtTablePrice4BCH(){
        try{
            // Check Number Page
            $nPage              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');
            $aDataPriListFilter = $this->input->post('aDataPriListFilter');
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aLangHave          = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave          = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            // Array Where Price 4 BCH
            $aWherePrice4BCH    = array(
                'pnPage'        => $nPage,
                'pnRow'         => 10,
                'pnLngID'       => $nLangEdit,
                'ptPdtCode'     => $aDataPriListFilter['tPriceDTPdtCode'],
                'ptPghDocType'  => $aDataPriListFilter['tPriceDTPriType'],
                'ptPunCode'     => $aDataPriListFilter['tPriceDTPriUnit'],
                'ptBchCode'     => $this->session->userdata('tSesUsrBchCode'),
                'ptShpCode'     => $this->session->userdata('tSesUsrShpCode'),
                'pdPghDStart'   => $aDataPriListFilter['tPriceDTPriDateStart'],
                'ptPghBchTo'    => $aDataPriListFilter['tPriceDTPriBchCode'],
            );
            $aPdtData4BCH       = FCNaHGetDataPrice4BCH($aWherePrice4BCH);
            $nDecimalNumberFM   = FCNxHGetOptionDecimalSave();
            $tPdtPriceTable4BCH = $this->load->view('product/pdtprice/wPdtPriceTable4BCH',array(
                'nDecimalNumberFM'  => $nDecimalNumberFM,
                'aPdtData4BCH'      => $aPdtData4BCH,
            ),true);
            $aReturnData = array(
                'tPriceDTTabSlt'    => $aDataPriListFilter['tPriceDTTabSlt'],
                'tViewTable4BCH'    => $tPdtPriceTable4BCH,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: ฟังก์ชั่น Call Data Table Price 4 AGG
    //Parameters:  Ajax Send Event Post Call Product List
    //Creator: 11/03/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object View Modal Price List
    //ReturnType: object
    public function FSvCallPdtTablePrice4AGG(){
        try{
            // Check Number Page
            $nPage              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');
            $aDataPriListFilter = $this->input->post('aDataPriListFilter');
            $nLangResort        = $this->session->userdata("tLangID");
            $nLangEdit          = $this->session->userdata("tLangEdit");
            $aLangHave          = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave          = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            // Array Where Price 4 AGG
            $aWherePrice4AGG    = array(
                'pnPage'        => $nPage,
                'pnRow'         => 10,
                'pnLngID'       => $nLangEdit,
                'ptPdtCode'     => $aDataPriListFilter['tPriceDTPdtCode'],
                'ptPghDocType'  => $aDataPriListFilter['tPriceDTPriType'],
                'ptPunCode'     => $aDataPriListFilter['tPriceDTPriUnit'],
                'ptBchCode'     => $this->session->userdata('tSesUsrBchCode'),
                'ptShpCode'     => $this->session->userdata('tSesUsrShpCode'),
                'pdPghDStart'   => $aDataPriListFilter['tPriceDTPriDateStart'],
                'ptAggCode'     => $aDataPriListFilter['tPriceDTPriAggCode'],
            );
            $aPdtData4AGG       = FCNaHGetDataPrice4AGG($aWherePrice4AGG);
            $nDecimalNumberFM   = FCNxHGetOptionDecimalSave();
            $tPdtPriceTable4AGG = $this->load->view('product/pdtprice/wPdtPriceTable4AGG',array(
                'nDecimalNumberFM'  => $nDecimalNumberFM,
                'aPdtData4AGG'      => $aPdtData4AGG,
            ),true);
            $aReturnData = array(
                'tPriceDTTabSlt'    => $aDataPriListFilter['tPriceDTTabSlt'],
                'tViewTable4AGG'    => $tPdtPriceTable4AGG,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }










}