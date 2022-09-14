<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cEventhall extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('eventhall/eventhall/mEventhall');
    }

    //Functionality : Function Call Page  Event Hall index
    //Parameters : Ajax and Function Parameter
    //Creator : 05/06/2019 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function index($nEvnthBrowseType,$tEvnthBrowseOption) {
        $vBtnSave       = FCNaHBtnSaveActiveHTML('eventhall/0/0'); 
        $aAlwEventEvnth   = FCNaHCheckAlwFunc('eventhall/0/0');
        $this->load->view('eventhall/eventhall/wEvenHall', array (
            'vBtnSave'           => $vBtnSave,
            'nEvnthBrowseType'    => $nEvnthBrowseType,
            'tEvnthBrowseOption'  => $tEvnthBrowseOption,
            'aAlwEventEvnth'       => $aAlwEventEvnth
        ));
    }

    // //Functionality : Function Call Page Product Main
    // //Parameters : Ajax and Function Parameter
    // //Creator : 31/01/2019 wasin(Yoshi)
    // //Return : String View
    // //Return Type : View
    public function FSxCEVNTHFormSearchList(){
        $this->load->view('eventhall/eventhall/wEvenHallFormSearchList');
    }

    //Functionality : Function Call View even hall DataTable
    //Parameters : Ajax Call View DataTable
    //Creator : 05/06/2019 saharat(Golf)
    //Return : String View
    //Return Type : View
    public function FSvCEVNTHCallPageDataTable() {

        try{
            $nPage          = $this->input->post('nPageCurrent');
            $tSearchAll     = $this->input->post('tSearchAll');
            if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
            if(!$tSearchAll){$tSearchAll='';}
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TTKMLocation_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }

            $aData  = array(
                'nRow'          => 5,
                'nPage'         => $nPage,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aColumnShow        = FCNaDCLGetColumnShow('TTKMLocation');
            $aAlwEventEvnth       = FCNaHCheckAlwFunc('eventhall/0/0');
            $aEvnthDataList       = $this->mEventhall->FSaMEVNTHListDataTable($aData);
            $aGenTable  = array(
                'aEvnthColumnShw'   => $aColumnShow,
                'aAlwEventEvnth'    => $aAlwEventEvnth,
                'aEvnthDataList'  => $aEvnthDataList,
                'nPage'           => $nPage
            );
            // print_r($aGenTable);
            // exit;
            // Return Dat View
            $aReturnData = array(
                'vEventHallPageDataTable' => $this->load->view('eventhall/eventhall/wEvenHalDataTable',$aGenTable,true),
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

    //Functionality : Call Data Advance Table Col List Show
    //Parameters : Ajax Paramiter
    //Creator : 31/01/2019 wasin(Yoshi)
    //Last Modified : -
    //Return : Object Data List Advance Table
    //Return Type : Object
    public function FSoCPDTAdvTableShwColList() {
        try{
            $aAvailableColumn   =   FCNaDCLAvailableColumn('TCNMPdt');
            if(isset($aAvailableColumn) && !empty($aAvailableColumn)){
                $aDataReturn    = array(
                    'aAvailableColumn'  => $aAvailableColumn,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }else{
                $aDataReturn    = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => language('common/main/main','tModalAdvMngTableNotFoundData')
                );
            }
        }catch(Exception $Error){
            $aDataReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    //Functionality : Save Avance Table Set User 
    //Parameters : Ajax Paramiter
    //Creator : 31/01/2019 wasin(Yoshi)
    //Last Modified : -
    //Return : Status Update Avence Table
    //Return Type : numeric
    public function FSnCPDTAdvTableShwColSave() {
        try{
            $this->db->trans_begin();
            FCNaDCLSetShowCol('TCNMPdt','','');
            $aColShowSet        = $this->input->post('aColShowSet');
            $aColShowAllList    = $this->input->post('aColShowAllList');
            $aColumnLabelName   = $this->input->post('aColumnLabelName');
            $nStaSetDef         = $this->input->post('nStaSetDef');
            if($nStaSetDef == 1){
                FCNaDCLSetDefShowCol('TCNMPdt');
            }else{
                for($i = 0; $i < FCNnHSizeOf($aColShowSet); $i++){
                    FCNaDCLSetShowCol('TCNMPdt',1,$aColShowSet[$i]);
                }
            }
            //Reset Seq
            FCNaDCLUpdateSeq('TCNMPdt','','','');
		    $q = 1;
		    for($n = 0; $n<FCNnHSizeOf($aColShowAllList); $n++){
                FCNaDCLUpdateSeq('TCNMPdt',$aColShowAllList[$n],$q, $aColumnLabelName[$n]);
                $q++;
		    }

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aDataReturn    = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            }else{
                $this->db->trans_commit();
                $aDataReturn    = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            }
        }catch(Exception $Error){
            $aDataReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataReturn);
    }

    // Functionality : Function CallPage Product Add
    // Parameters : Ajax Call Page
    // Creator : 01/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : String View
    // Return Type : View
    public function FSoCPDTCallPageAdd(){
        try{
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aVatRate       = FCNoHCallVatlist();
            $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');
            $aDatProduct    = array(
                'nStaAddOrEdit'     => 99,
                'aVatRate'          => $aVatRate,
                'aAlwEventPdt'      => $aAlwEventPdt
            );
            $aReturnData    =   array(
                'vPdtPageAdd'   => $this->load->view('product/product/wProductAdd',$aDatProduct,true),
                'nStaEvent'     => '1',
                'tStaMessg'     => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Function CallPage Product Edit
    // Parameters : Ajax Call Page
    // Creator : 20/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : String View
    // Return Type : View
    public function FSoCPDTCallPageEdit(){
        try{
            $tPdtCode       = $this->input->post('tPdtCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            
            $aDataWhere     = array('FTPdtCode' => $tPdtCode,'FNLngID' => $nLangEdit);

            // Get Data Product Info
            $aPdtImgData            = $this->mProduct->FSaMPDTGetDataImgByID($aDataWhere);
            $aPdtInfoData           = $this->mProduct->FSaMPDTGetDataInfoByID($aDataWhere);
            $aPdtInfoPackSize       = $this->mProduct->FSaMPDTGetDataPackSizeByID($aDataWhere);
            $aPdtInfoBarCode        = $this->mProduct->FSaMPDTGetDataBarCodeByID($aDataWhere);
            $aPdtInfoSupplier       = $this->mProduct->FSaMPDTGetDataSupplierByID($aDataWhere);
            $aPdtInfoPdtSet         = $this->mProduct->FSaMPDTGetDataPdtSetByID($aDataWhere);
            $aPdtInfoGetEvnNoSale   = $this->mProduct->FSaMPDTGetDataEvnNoSaleByID($aDataWhere);
            $aVatRate       = FCNoHCallVatlist();
            $aAlwEventPdt   = FCNaHCheckAlwFunc('product/0/0');

            // View Product Add Main
            $tViewPagePdtAdd    = $this->load->view('product/product/wProductAdd',array(
                'nStaAddOrEdit'         => 1,
                'aVatRate'              => $aVatRate,
                'aAlwEventPdt'          => $aAlwEventPdt,
                'aPdtImgData'           => $aPdtImgData,
                'aPdtInfoData'          => $aPdtInfoData,
                'aPdtInfoPackSize'      => $aPdtInfoPackSize,
                'aPdtInfoBarCode'       => $aPdtInfoBarCode,
                'aPdtInfoSupplier'      => $aPdtInfoSupplier,
                'aPdtInfoPdtSet'        => $aPdtInfoPdtSet,
                'aPdtInfoGetEvnNoSale'  => $aPdtInfoGetEvnNoSale
            ),true);

            $aReturnData    = array(
                'vPdtPageAdd'   => $tViewPagePdtAdd,
                'nStaEvent'     => '1',
                'tStaMessg'     => 'Success'
            );
        }catch(Exception $Error){
            $aReturnData    = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Functionality : CallPage DataTable Product Event Not Sale
    // Parameters : Ajax Call Page DataTable Product Event Not Sale
    // Creator : 07/02/2018 wasin
    // Last Modified : -
    // Return : object View
    // Return Type : object
    public function FSoCPDTEvnNotSaleDataTable(){
        try{
            $tEvnCode       = $this->input->post('tEvnCode');
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtNoSleByEvn_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }
            $aData  = array(
                'FTEvnCode' => $tEvnCode,
                'FNLngID'   => $nLangEdit
            );
            
            $aDataNoEvnCode = $this->mProduct->FSaMPDTEvnNotSaleByID($aData);
            $aGenTable      = array('aDataList' => $aDataNoEvnCode);
            $aReturnData    = array(
                'vPdtEvnNotSale'    => $this->load->view('product/product/wProductNoSaleEvnDataTable',$aGenTable,true),
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

    // Functionality : CallPage DataTable Product Set 
    // Parameters : Ajax Call Page DataTable Product Set
    // Creator : 07/02/2018 wasin
    // Last Modified : -
    // Return : object View
    // Return Type : object
    public function FSoCPDTPdtSetDataTable(){
        try{
            $aPdtCode       = $this->input->post('aPdtCode');
            // Get Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }

            $aResult = [];
            foreach($aPdtCode AS $nKey => $tPdtCode){
                $aData = array(
                    'FTPdtCode' => $tPdtCode,
                    'FNLngID'   => $nLangEdit
                );
                $aDataPdtSet    = $this->mProduct->FSaMPDTGetDataPdtSet($aData);

                if($aDataPdtSet['rtCode'] == 1){
                    array_push($aResult,$aDataPdtSet['raItems']);
                }
            }

            $aGenTable      = array('aDataList' => $aResult);
            $aReturnData    = array(
                'vPdtDataSet'       => $this->load->view('product/product/wProductSetDataTable',$aGenTable,true),
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

    // Functionality : CallPage DataTable Product PackSize 
    // Parameters : Ajax Call Page DataTable Product PackSize
    // Creator : 08/02/2018 wasin
    // Last Modified : -
    // Return : object View
    // Return Type : object
    public function FSoCPDTPackSizeDataTable(){
        try{
            $aPdtUnitCode   = $this->input->post('aPdtUnitCode');
            // Get Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){
                    $nLangEdit = $nLangEdit;
                }else{
                    $nLangEdit = $nLangResort;
                }
            }else{
                if(@$aLangHave[0]->nLangList == ''){
                    $nLangEdit = '1';
                }else{
                    $nLangEdit = $aLangHave[0]->nLangList;
                }
            }
            
            
            $aPdtPackSizeRow   = [];
            foreach($aPdtUnitCode AS $nKey => $tUnitCode){
                $aData = array(
                    'FTPunCode' => $tUnitCode,
                    'FNLngID'   => $nLangEdit
                );
                $aDataPdtUnit           = $this->mProduct->FSaMPDTGetDataPdtUnit($aData);
                if(isset($aDataPdtUnit) && $aDataPdtUnit['rtCode'] == 1){
                    $aGenTable          = array('aDataPdtUnit' => $aDataPdtUnit['raItems']);
                    $tPdtPackSizeRow    = $this->load->view('product/product/wProductPackSizeDataTable',$aGenTable,true);
                    array_push($aPdtPackSizeRow,array(
                        'tPdtPackSizeRow'   => $tPdtPackSizeRow,
                        'tPdtUnitCode'      => $tUnitCode
                    ));
                }
            }
            $aReturnData    = array(
                'aPdtPackSizeRow'   => $aPdtPackSizeRow,
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

    // Functionality : Func.Chech BarCode Duplicate In DB
    // Parameters : Ajax Send Event Post
    // Creator : 12/02/2018 Wasin(Yoshi)
    // Last Modified : -
    // Return : object Array Data Chk BarCode Duplicate
    // Return Type : object
    public function FSoCPDTChkBarcodeDup(){
        try{
            $tPdtCode = $this->input->post('tPdtCode');
            $tBarcode = $this->input->post('tBarCode');
            if(isset($tBarcode) && !empty($tBarcode)){
                $aStaBarcode    = $this->mProduct->FSaMStaChkBarcode($tPdtCode,$tBarcode);
                if($aStaBarcode['rtCode'] == 1){
                    $aReturnData = array(
                        'nStaBarCodeDup' => $aStaBarcode['raItems']['Counts'],
                        'nStaEvent'      => '1',
                        'tStaMessg'      => 'Success Ajax'
                    );
                }
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: Function Add Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 15/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object Status Event Add
    //ReturnType: object
    public function FSoCPDTAddEvent(){
        try{
            //Get Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){$nLangEdit = $nLangEdit;}else{$nLangEdit = $nLangResort;}
            }else{
                if(@$aLangHave[0]->nLangList == ''){$nLangEdit = '1';}else{$nLangEdit = $aLangHave[0]->nLangList;}
            }

            $aPdtImg            = $this->input->post('aPdtImg');
            $aPdtDataInfo1      = $this->input->post('aPdtDataInfo1');
            $aPdtDataInfo2      = $this->input->post('aPdtDataInfo2');
            $aPdtDataPackSize   = $this->input->post('aPdtDataPackSize');
            $aPdtDataAllSet     = $this->input->post('aPdtDataAllSet');
            $tPdtEvnNotSale     = $this->input->post('tPdtEvnNotSale');

            $tIsAutoGenCode     = $aPdtDataInfo1['tIsAutoGenCode'];

            // Setup Product Code
            $tPdtCode   = "";
            if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){
                // Call Auto Gencode Helper
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdt',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $tPdtCode   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMPdt');
                // if($aGenCode['rtCode'] == '1'){
                //     $tPdtCode   =   $aGenCode['rtPdtCode'];
                // }
            }else{
                $tPdtCode       = $aPdtDataInfo1['tPdtCode'];
            }

            $aDataWherePdt      = array(
                'FTPdtCode'         => $tPdtCode
            );

            $aDataAddUpdatePdt  = array(
                'FTPdtStkCode'          => $aDataWherePdt['FTPdtCode'],
                'FTPdtStkControl'       => $aPdtDataInfo1['nPdtStkControl'],
                'FTPdtForSystem'        => 1,
                'FCPdtQtyOrdBuy'        => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtQtyOrdBuy'])),
                'FCPdtCostDef'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostDef'])),
                'FCPdtCostOth'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostOth'])),
                'FCPdtCostStd'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostStd'])),
                'FCPdtMin'              => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtMin'])),
                'FCPdtMax'              => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtMax'])),
                'FTPdtPoint'            => $aPdtDataInfo1['nPdtStaPoint'],
                'FCPdtPointTime'        => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtPointTime'])),
                'FTPdtType'             => 1,
                'FTPdtSaleType'         => 1,
                'FTPdtSetOrSN'          => 1,
                'FTPdtStaAlwDis'        => $aPdtDataInfo1['nPdtStaAlwDis'],
                'FTPdtStaAlwReturn'     => $aPdtDataInfo1['nPdtStaAlwReturn'],
                'FTPdtStaVatBuy'        => $aPdtDataInfo1['nPdtStaVatBuy'],
                'FTPdtStaVat'           => $aPdtDataInfo1['nPdtStaVat'],
                'FTPdtStaActive'        => $aPdtDataInfo1['nPdtStaActive'],
                'FTPdtStaAlwReCalOpt'   => 1,
                'FTPdtStaCsm'           => 1,
                // 'FTShpCode'             => 1,
                // 'FTPdtRefShop'          => $aPdtDataInfo2['tPdtMerCode'],
                'FTTcgCode'             => $aPdtDataInfo2['tPdtTcgCode'],
                'FTPgpChain'            => $aPdtDataInfo2['tPdtPgpChain'],
                'FTPtyCode'             => $aPdtDataInfo2['tPdtPtyCode'],
                'FTPbnCode'             => $aPdtDataInfo2['tPdtPbnCode'],
                'FTPmoCode'             => $aPdtDataInfo2['tPdtPmoCode'],
                'FTVatCode'             => $aPdtDataInfo1['tPdtVatCode'],
                'FDPdtSaleStart'        => $aPdtDataInfo2['tPdtSaleStart'],
                'FDPdtSaleStop'         => $aPdtDataInfo2['tPdtSaleStop'],
                // 'FTBchCode'             => $aPdtDataInfo2['tPdtBchCode'],
                // 'FTBchCode'             => $aPdtDataInfo2['tPdtBchCode'],
            );
            $aDataLangPdt       = array(
                'FNLngID'       => $nLangEdit,
                'FTPdtName'     => $aPdtDataInfo1['tPdtName'],
                'FTPdtNameOth'  => $aPdtDataInfo1['tPdtNameOth'],
                'FTPdtNameABB'  => $aPdtDataInfo1['tPdtNameABB'],
                'FTPdtRmk'      => $aPdtDataInfo2['tPdtRmk']
            );

            // Check Product Dup In DataBase
            $aStaPdtDup =   $this->mProduct->FSaMPDTCheckDuplicate($aDataWherePdt['FTPdtCode']);
            if($aStaPdtDup['rtCode'] == '1' && $aStaPdtDup['rnCountPdt'] == '0'){
                $this->db->trans_begin();
                    $this->mProduct->FSaMPDTAddUpdateMaster($aDataWherePdt,$aDataAddUpdatePdt);
                    $this->mProduct->FSaMPDTAddUpdateLang($aDataWherePdt,$aDataLangPdt);
                    $this->mProduct->FSxMPDTAddUpdatePackSize($aDataWherePdt,$aPdtDataPackSize);
                    $this->mProduct->FSxMPDTAddUpdateBarCode($aDataWherePdt,$aPdtDataPackSize);
                    $this->mProduct->FSxMPDTAddUpdateSupplier($aDataWherePdt,$aPdtDataPackSize);
                    $this->mProduct->FSxMPDTAddUpdatePdtSet($aDataWherePdt,$aPdtDataAllSet);
                    $this->mProduct->FSxMPDTAddUpdatePdtEvnNosale($aDataWherePdt,$tPdtEvnNotSale);
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent'    => '500',
                        'tStaMessg'    => "Unsucess Add Even"
                    );
                }else{
                    $this->db->trans_commit();
                    if(isset($aPdtImg) && !empty($aPdtImg)){
                        $aImageUplode = array(
                            'tModuleName'       => 'product',
                            'tImgFolder'        => 'product',
                            'tImgRefID'         => $aDataWherePdt['FTPdtCode'],
                            'tImgObj'           => $aPdtImg,
                            'tImgTable'         => 'TCNMPdt',
                            'tTableInsert'      => 'TCNMImgPdt',
                            'tImgKey'           => 'master',
                            'dDateTimeOn'       => date('Y-m-d H:i:s'),
                            'tWhoBy'            => $this->session->userdata('tSesUsername'),
                            'nStaDelBeforeEdit' => 1
                        );
                        FCNnHAddImgObj($aImageUplode);
                    }
                    $aReturnData = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataWherePdt['FTPdtCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Event'
                    );
                }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => 'Data Product Is Duplicate'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    //Functionality: Function Edit Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 21/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object Status Event Edit
    //ReturnType: object
    public function FSoCPDTEditEvent(){
        try{
            //Get Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdt_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                if($nLangEdit != ''){$nLangEdit = $nLangEdit;}else{$nLangEdit = $nLangResort;}
            }else{
                if(@$aLangHave[0]->nLangList == ''){$nLangEdit = '1';}else{$nLangEdit = $aLangHave[0]->nLangList;}
            }

            $aPdtImg            = $this->input->post('aPdtImg');
            $aPdtDataInfo1      = $this->input->post('aPdtDataInfo1');
            $aPdtDataInfo2      = $this->input->post('aPdtDataInfo2');
            $aPdtDataPackSize   = $this->input->post('aPdtDataPackSize');
            $aPdtDataAllSet     = $this->input->post('aPdtDataAllSet');
            $tPdtEvnNotSale     = $this->input->post('tPdtEvnNotSale');

            $aDataWherePdt      = array(
                'FTPdtCode' => $aPdtDataInfo1['tPdtCode']
            );

            $aDataAddUpdatePdt  = array(
                'FTPdtStkCode'          => $aPdtDataInfo1['tPdtStkCode'],
                'FTPdtStkControl'       => $aPdtDataInfo1['nPdtStkControl'],
                'FTPdtForSystem'        => 1,
                'FCPdtQtyOrdBuy'        => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtQtyOrdBuy'])),
                'FCPdtCostDef'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostDef'])),
                'FCPdtCostOth'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostOth'])),
                'FCPdtCostStd'          => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtCostStd'])),
                'FCPdtMin'              => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtMin'])),
                'FCPdtMax'              => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtMax'])),
                'FTPdtPoint'            => $aPdtDataInfo1['nPdtStaPoint'],
                'FCPdtPointTime'        => floatval(preg_replace("/[^-0-9\.]/","",$aPdtDataInfo2['tPdtPointTime'])),
                'FTPdtType'             => 1,
                'FTPdtSaleType'         => 1,
                'FTPdtSetOrSN'          => 1,
                'FTPdtStaAlwDis'        => $aPdtDataInfo1['nPdtStaAlwDis'],
                'FTPdtStaAlwReturn'     => $aPdtDataInfo1['nPdtStaAlwReturn'],
                'FTPdtStaVatBuy'        => $aPdtDataInfo1['nPdtStaVatBuy'],
                'FTPdtStaVat'           => $aPdtDataInfo1['nPdtStaVat'],
                'FTPdtStaActive'        => $aPdtDataInfo1['nPdtStaActive'],
                'FTPdtStaAlwReCalOpt'   => 1,
                'FTPdtStaCsm'           => 1,
                // 'FTShpCode'             => 1,
                // 'FTPdtRefShop'          => $aPdtDataInfo2['tPdtMerCode'],
                'FTTcgCode'             => $aPdtDataInfo2['tPdtTcgCode'],
                'FTPgpChain'            => $aPdtDataInfo2['tPdtPgpChain'],
                'FTPtyCode'             => $aPdtDataInfo2['tPdtPtyCode'],
                'FTPbnCode'             => $aPdtDataInfo2['tPdtPbnCode'],
                'FTPmoCode'             => $aPdtDataInfo2['tPdtPmoCode'],
                'FTVatCode'             => $aPdtDataInfo1['tPdtVatCode'],
                'FDPdtSaleStart'        => $aPdtDataInfo2['tPdtSaleStart'],
                'FDPdtSaleStop'         => $aPdtDataInfo2['tPdtSaleStop'],
                // 'FTBchCode'             => $aPdtDataInfo2['tPdtBchCode'],
                // 'FTBchCode'             => $aPdtDataInfo2['tPdtBchCode'],
            );

            $aDataLangPdt       = array(
                'FNLngID'       => $nLangEdit,
                'FTPdtName'     => $aPdtDataInfo1['tPdtName'],
                'FTPdtNameOth'  => $aPdtDataInfo1['tPdtNameOth'],
                'FTPdtNameABB'  => $aPdtDataInfo1['tPdtNameABB'],
                'FTPdtRmk'      => $aPdtDataInfo2['tPdtRmk']
            );

            $this->db->trans_begin();
                $this->mProduct->FSaMPDTAddUpdateMaster($aDataWherePdt,$aDataAddUpdatePdt);
                $this->mProduct->FSaMPDTAddUpdateLang($aDataWherePdt,$aDataLangPdt);
                $this->mProduct->FSxMPDTAddUpdatePackSize($aDataWherePdt,$aPdtDataPackSize);
                $this->mProduct->FSxMPDTAddUpdateBarCode($aDataWherePdt,$aPdtDataPackSize);
                $this->mProduct->FSxMPDTAddUpdateSupplier($aDataWherePdt,$aPdtDataPackSize);
                $this->mProduct->FSxMPDTAddUpdatePdtSet($aDataWherePdt,$aPdtDataAllSet);
                $this->mProduct->FSxMPDTAddUpdatePdtEvnNosale($aDataWherePdt,$tPdtEvnNotSale);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent'    => '500',
                    'tStaMessg'    => "Unsucess Add Even"
                );
            }else{
                $this->db->trans_commit();
                if(isset($aPdtImg) && !empty($aPdtImg)){
                    $aImageUplode = array(
                        'tModuleName'       => 'product',
                        'tImgFolder'        => 'product',
                        'tImgRefID'         => $aDataWherePdt['FTPdtCode'],
                        'tImgObj'           => $aPdtImg,
                        'tImgTable'         => 'TCNMPdt',
                        'tTableInsert'      => 'TCNMImgPdt',
                        'tImgKey'           => 'master',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    );
                    FCNnHAddImgObj($aImageUplode);
                }
                $aReturnData = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataWherePdt['FTPdtCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Event'
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Functionality: Function Delete All Product Event
    //Parameters:  Ajax Send Event Post
    //Creator: 25/02/2018 Wasin(Yoshi)
    //LastModified: -
    //Return: Return object Status Event Delete
    //ReturnType: object
    public function FSoCPDTDeleteEvent(){
        $tIDCode    = $this->input->post('tIDCode');
        $aDataDel   = array(
            'FTPdtCode' =>  $tIDCode
        );
        $aStaDel    = $this->mProduct->FSaMPdtDeleteAll($aDataDel);
        if($aStaDel['rtCode'] == 1){
            $aDeleteImage = array(
                'tModuleName'   => 'product',
                'tImgFolder'    => 'product',
                'tImgRefID'     => $tIDCode,
                'tTableDel'     => 'TCNMImgPdt',
                'tImgTable'     => 'TCNMPdt'
            );
            $nStaDelImgInDB = FSnHDelectImageInDB($aDeleteImage);
            if($nStaDelImgInDB == 1){
                FSnHDeleteImageFiles($aDeleteImage);
            }
            $aReturn    = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Delete Product Success.'
            );
        }else{
            $aReturn    = array(
                'nStaEvent' => $aStaDel['rtCode'],
                'tStaMessg' => $aStaDel['rtDesc'],
            );
        }
        echo json_encode($aReturn);
    }



    























    

}