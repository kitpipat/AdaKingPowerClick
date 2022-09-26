<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cBrowserPDTCallView extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('common/mBrowserPDTCallView');
        $this->load->model('company/branch/mBranch');
    }

    //List PDT Serach
    public function index()
    {
        //hidden filter search
        $Qualitysearch  = $this->input->post('Qualitysearch');

        //price type
        $PriceType      = $this->input->post('PriceType');

        //Select Tier : เลือกระดับไหน [PDT,Barcode]
        $SelectTier     = $this->input->post('SelectTier');
        if (isset($SelectTier)) {
            $SelectTier = $SelectTier[0];
        } else {
            $SelectTier = 'Barcode';
        }

        $tStaPdtLay     = $this->input->post('tStaPdtLay'); //Y = แสดงสินค้าที่อยู่ในตู้ VD ด้วย, N = ไม่แสดงสินค้าที่ผูกในตู้ VD (TVDMPdtLayout)
        if (isset($tStaPdtLay)) {
            $tStaPdtLay = $tStaPdtLay;
        } else {
            $tStaPdtLay = 'Y';
        }

        //element return input
        $tElementreturn     = $this->input->post('Elementreturn');

        // ******************************************************************************************************
        // Create By Witsarut 02/07/2020  เก็บข้อมูลลง  Cookie
        $nCheckPage  =  $this->input->cookie("PDTCookie_" . $this->session->userdata("tSesUserCode"), true);
        $tCookieVal = json_decode($nCheckPage);

        if (!empty($nCheckPage)) {
            $nPerPage = $tCookieVal->nPerPage;
        } else {
            $nPerPage = '';
        }

        //ShowCountRecord
        if ($nPerPage == '' || null) {
            $nShowCountRecord  = $this->input->post('ShowCountRecord');
        } else {
            $nShowCountRecord   = $nPerPage;
        }

        // ******************************************************************************************************

        //name NextFunc
        $tNameNextFunc      = $this->input->post('NextFunc');

        //Return type S,M
        $tReturnType        = $this->input->post('ReturnType');

        //Parameter SPL
        $tParameterSPL      = $this->input->post('SPL');

        //Parameter BCH
        $tParameterBCH      = $this->input->post('BCH');

        //Parameter MCH
        $tParameterMER      = $this->input->post('MER');

        //Parameter SHP
        $tParameterSHP      = $this->input->post('SHP');

        //Parameter WAH
        $tParameterWAH      = $this->input->post('WAH');

        //Parameter DISTYPE
        $tParameterDISTYPE    = $this->input->post('DISTYPE');

        //Get Time for localstorage
        $tTimeLocalstorage  = $this->input->post('TimeLocalstorage');

        //Parameter Product Code
        $tParameterProductCode    = $this->input->post('ProductCode');

        //Parameter Agen Code
        $tParameterAgenCode    = $this->input->post('AgenCode');

        //Parameter NotInPdtType
        $tNotInPdtType    = $this->input->post('NotInPdtType');

        //Parameter Where
        $tWhere                 = $this->input->post('Where');

        // print_r($tWhere); die();

        $tPagename          = $this->input->post('PageName');
        if (isset($tPagename)) {
            $tPagename = $tPagename;
        } else {
            $tPagename = '';
        }

        //Not in Item
        $aNotinItem         = $this->input->post('NOTINITEM');

        $aData = array(
            'nShowCountRecord'  => $nShowCountRecord,
            'aQualitysearch'    => $Qualitysearch,
            'aPriceType'        => $PriceType,
            'tSelectTier'       => $SelectTier,
            'tElementreturn'    => $tElementreturn,
            'tNameNextFunc'     => $tNameNextFunc,
            'tReturnType'       => $tReturnType,
            'SesBch'            => $this->session->userdata("tSesUsrBchCode"),
            'SesShp'            => $this->session->userdata("tSesUsrShpCode"),
            'SesMer'            => $this->session->userdata("tSesUsrMerCode"),
            'tParameterSPL'     => $tParameterSPL,
            'tParameterMER'     => $tParameterMER,
            'tParameterBCH'     => $tParameterBCH,
            'tParameterSHP'     => $tParameterSHP,
            'tParameterWAH'     => $tParameterWAH,
            'tParameterDISTYPE' => $tParameterDISTYPE,
            'tTimeLocalstorage' => $tTimeLocalstorage,
            'tPagename'         => $tPagename,
            'aNotinItem'        => $aNotinItem,
            'tParameterProductCode' => $tParameterProductCode,
            'tParameterAgenCode' => $tParameterAgenCode,
            'tNotInPdtType'   => $tNotInPdtType,
            'tWhere'            => $tWhere,
            'tStaPdtLay'        => $tStaPdtLay
        );
        // echo "<pre>";print_r($aData);exit;

        $this->load->view('common/wBrowsePDTCallView', $aData);
    }

    //วิ่งเข้าฟังก์ชั่น get product โยนพวก parameter ไป
    public function FSxGetProductfotPDT()
    {
        $tBarcode           = $this->input->post('tTextScan');
        $tProductCode       = $this->input->post('ProductCode');
        $tAgenCode          = $this->input->post('AgenCode');
        $tNotInPdtType      = $this->input->post('tNotInPdtType');
        $tWhere             = $this->input->post('tWhere');
        if ($tBarcode == '' || $tBarcode == null) {
            $nPage                  =  $this->input->post("nPage");
            $tPagename              =  $this->input->post("tPagename");

            //เก็บข้อมูลลง  Cookie
            $nCheckPage  =  $this->input->cookie("PDTCookie_" . $this->session->userdata("tSesUserCode"), true);
            $tCookieVal = json_decode($nCheckPage);

            if (!empty($nCheckPage)) {
                $nPerPage = $tCookieVal->nPerPage;
            } else {
                $nPerPage = '';
            }

            if ($nPerPage == '' || null) {
                $nRow  = $this->input->post('nRow');
            } else {
                $nRow   = $nPerPage;
            }

            $aPriceType             =  json_decode($this->input->post("aPriceType"));
            $tBCH                   =  $this->input->post("BCH");
            $tSHP                   =  $this->input->post("SHP");
            $tMER                   =  $this->input->post("MER");
            $tSPL                   =  $this->input->post("SPL");
            $tWAH                   =  $this->input->post("WAH");
            $nDISTYPE               =  $this->input->post("DISTYPE");
            $tSelectTier            =  $this->input->post("SelectTier");
            $tReturnType            =  $this->input->post("ReturnType");
            $aNotinItem             =  $this->input->post("aNotinItem");
            $nPDTMoveon             =  $this->input->post("PDTMoveon");
            $nTotalResult           =  $this->input->post("nTotalResult");
            $tSearchText            =  $this->input->post("tSearchText");
            $tSearchSelect          =  $this->input->post("tSearchSelect");
            $tFindOnlyPDT           = 'normal';
            $tStaPdtLay             = $this->input->post("tStaPdtLay");
        } else {
            $tBCH                   =  $this->input->post("BCH");
            $tSHP                   =  $this->input->post("SHP");
            $tMER                   =  $this->input->post("MER");
            $tSPL                   =  $this->input->post("SPL");
            $tWAH                   =  $this->input->post("WAH");
            $aPriceType             =  $this->input->post("aPriceType");
            $tSearchText            =  trim($tBarcode);
            $tSearchSelect          =  'PDTANDBarcode';
            $nTotalResult           =  0;
            $nRow                   =  90000;
            $nPage                  =  1;
            $tReturnType            = 'S';
            $tFindOnlyPDT           = 'Barcode';
        }

        $aDataSearch = array(
            'FNLngID'               => $this->session->userdata("tLangEdit"),
            'nPage'                 => @$nPage,
            'nRow'                  => @$nRow,
            'aPriceType'            => @$aPriceType,
            'tBCH'                  => @$tBCH,
            'tMER'                  => @$tMER,
            'tSHP'                  => @$tSHP,
            'tSPL'                  => @$tSPL,
            'tWAH'                  => @$tWAH,
            'nDISTYPE'              => @$nDISTYPE,
            'tSelectTier'           => @$tSelectTier,
            'tStaPdtLay'            => @$tStaPdtLay,
            'tPagename'             => @$tPagename,
            'aNotinItem'            => @$aNotinItem,
            'nPDTMoveon'            => @$nPDTMoveon,
            'tSearchText'           => @$tSearchText,
            'tSearchSelect'         => @$tSearchSelect,
            'nTotalResult'          => ($nTotalResult == '') ? '0' : $nTotalResult,
            'tFindOnlyPDT'          => $tFindOnlyPDT,
            'tProductCode'          => $tProductCode,
            'tAgenCode'             => $tAgenCode,
            'tNotInPdtType'         => $tNotInPdtType,
            'tWhere'                => $tWhere
        );
        // echo "<pre>";print_r($aDataSearch);exit;

        //ค้นหาสินค้า
        $aProduct = $this->JSaCGetDataProduct($aDataSearch);

        // GetAllRow 
        if ($aProduct['nPDTAll'] == 0) {
            $tGetAllRow = $this->session->userdata("tSesGetAllRow");
        } else {
            $tGetAllRow = $aProduct['nPDTAll'];
        }

        $this->session->set_userdata("tSesGetAllRow", $tGetAllRow);

        //หาประเภทราคา ใช้ต้นทุนแบบไหน [1,2,3,4];
        if ($aPriceType[0] == 'Pricesell' || $aPriceType[0] == 'Price4Cst') {
            $aCheckPrice = '';
            $tVatInorEx  = '';
        } else if ($aPriceType[0] == 'Cost') {
            $aCheckPrice = $this->mBrowserPDTCallView->FSnMGetTypePrice($aPriceType[1], $aPriceType[2], $aPriceType[3]);
            if ($tSPL == '' || $tSPL == null) {
                //ไม่ส่ง spl มา
                $aGetInorEx    = $this->mBrowserPDTCallView->FSaMGetWhsInorExIncompany();
                $tVatInorEx    = $aGetInorEx[0]['FTCmpRetInOrEx'];
            } else {
                $aGetInorEx    = $this->mBrowserPDTCallView->FSaMGetWhsInorExInSupplier($tSPL);
                if (empty($aGetInorEx)) {
                    $tVatInorEx    = 1;
                } else {
                    $tVatInorEx    = $aGetInorEx[0]['FTSplStaVATInOrEx'];
                }
            }
        }

        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $aDataHTML          = array(
            'nPage'             => $this->input->post("nPage"),
            'aPriceType'        => $aPriceType,
            'tSelectTier'       => @$tSelectTier,
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aTSysconfig'       => $aCheckPrice,
            'tReturnType'       => $tReturnType,
            'tVatInorEx'        => $tVatInorEx,
            'aProduct'          => $aProduct
        );


        if ($tBarcode == '' || $tBarcode  == null) {
            $this->load->view('common/wBrowsePDTTableCallView', $aDataHTML);
        } else {
            if ($aProduct['rtCode'] == 800) {
                $aReturn = 800;
            } else {
                $tReturn    = $aProduct;

                $aData      = $tReturn['raItems'];
                $aReturn    = array();
                for ($i = 0; $i < FCNnHSizeOf($tReturn['raItems']); $i++) {
                    
                    if($aData[$i]['FTPdtForSystem']=='5'){
                        $PDTSpc ='FH';
                    }else{
                        $PDTSpc ='GN';
                    }
                    
                    $aPackData = array(
                        'SHP'       => $aData[$i]['FTShpCode'],
                        'BCH'       => $aData[$i]['FTPdtSpcBch'],
                        'PDTCode'   => $aData[$i]['FTPdtCode'],
                        'PDTName'   => $aData[$i]['FTPdtName'],
                        'PUNCode'   => $aData[$i]['FTPunCode'],
                        'UnitFact'  => $aData[$i]['FCPdtUnitFact'],
                        'Barcode'   => $aData[$i]['FTBarCode'],
                        'PUNName'   => $aData[$i]['FTPunName'],
                        'IMAGE'     => $aData[$i]['FTImgObj'],
                        'LOCSEQ'    => '',
                        'Remark'    => $aData[$i]['FTPdtName'],
                        'PDTSpc'    => $PDTSpc,
                        'CookTime'  => ($aData[$i]['FCPdtCookTime'] == '') ? 0 : $aData[$i]['FCPdtCookTime'],
                        'CookHeat'  => ($aData[$i]['FCPdtCookHeat'] == '') ? 0 : $aData[$i]['FCPdtCookHeat'],
                        'AlwDis'    => ($aData[$i]['FTPdtStaAlwDis'] == '' || $aData[$i]['FTPdtStaAlwDis'] == null) ? 2 : $aData[$i]['FTPdtStaAlwDis'],
                        'AlwVat'    => $aData[$i]['FTPdtStaVat'],
                        'nVat'      => $aData[$i]['FCVatRate'],
                    );

                    if ($aPriceType[0] == 'Pricesell' || $aPriceType[0] == 'Price4Cst') {
                        $aPackData['PriceRet'] = number_format($aData[$i]['FCPgdPriceRet'], $nOptDecimalShow, '.', ',');
                        $aPackData['PriceWhs'] = number_format($aData[$i]['FCPgdPriceWhs'], $nOptDecimalShow, '.', ',');
                        $aPackData['PriceNet'] = number_format($aData[$i]['FCPgdPriceNet'], $nOptDecimalShow, '.', ',');
                        $aPackData['NetAfHD']   = number_format($aData[$i]['FCPgdPriceRet'], $nOptDecimalShow, '.', ',');
                    }else if($aPriceType[0] == 'Cost'){
                    
                        //หาว่าใช้ต้นทุนแบบไหน
                        if($aCheckPrice == null || $aCheckPrice == ''){
                            $bCheckPrice    = false;
                            $nPriceon       = 0;
                        }else{
                            $bCheckPrice    = true;
                            $nPriceon       = $aCheckPrice;
                        }
                        $aDataFind = array(
                            'nINDEX'             => $nPriceon,
                            'nVATSPL'            => $tVatInorEx,
                            'nCostAvgIn'         => $aData[$i]['FCPdtCostAVGIN'],
                            'nCostAvgEX'         => $aData[$i]['FCPdtCostAVGEx'],
                            'nCostLast'          => $aData[$i]['FCPdtCostLast'],
                            'nCostFiFoIn'        => $aData[$i]['FCPdtCostFIFOIN'],
                            'nCostFiFoEx'        => $aData[$i]['FCPdtCostFIFOEx'],
                            'nCostSTD'           => $aData[$i]['FCPdtCostStd']
                        );
                        $nCost = $this->GetTotalByConfig($aDataFind); 
                        $nCost = $nCost * $aData[$i]['FCPdtUnitFact'];
                        $aPackData['Price'] = number_format($nCost, $nOptDecimalShow, '.', ',');
                        $aPackData['NetAfHD']   = number_format($nCost, $nOptDecimalShow, '.', ',');
                    }
                    array_push($aReturn, [
                        "pnPdtCode" => $aData[$i]['FTPdtCode'],
                        "ptBarCode" => $aData[$i]['FTBarCode'],
                        "ptPunCode" => $aData[$i]['FTPunCode'],
                        "packData"  => $aPackData
                    ]);
                }
            }
            echo json_encode($aReturn);
        }
    }

    //GET Product
    public function JSaCGetDataProduct($paData)
    {
        $tFilter            = '';
        $tBchSession        = $this->session->userdata("tSesUsrBchCodeDefault");
        $tShpSession        = $this->session->userdata("tSesUsrShpCode");
        $tMerSession        = $this->session->userdata("tSesUsrMerCode");
        $tSelectTier        = $paData['tSelectTier'];
        $tStaPdtLay         = $paData['tStaPdtLay'];

        $tWhere = $paData['tWhere'];
        if ( isset($tWhere) && !empty($tWhere) && is_array($tWhere) && FCNnHSizeOf($tWhere) > 0 ) {
            foreach($tWhere as $nKey => $tValue){
                $tFilter .= $tValue;
            }
        }

        //------------------- ไม่แสดงสินค้าตาม ประเภทสินค้า -------------------
        $tNotInPdtType = json_decode($paData['tNotInPdtType']);
        if ( isset($tNotInPdtType) && !empty($tNotInPdtType) && is_array($tNotInPdtType) && FCNnHSizeOf($tNotInPdtType) > 0 ) {
            $nMax               = FCNnHSizeOf($tNotInPdtType);
            $nCount             = 1;
            $tPdtTypeMulti      = "";
            foreach($tNotInPdtType as $nKey => $tValue){
                if( $nCount == $nMax ){
                    $tPdtTypeMulti .= "'$tValue'";
                }else{
                    $tPdtTypeMulti .= "'$tValue',";
                }
                $nCount++;
            }
            $tFilter .= " AND Products.FTPdtType NOT IN ($tPdtTypeMulti) ";
        }

        //-------------------สินค้าที่ไม่ใช่ตัวข้อมูลหลักในการจัดสินค้าชุด-------------------
        $tProductCode = $paData['tProductCode'];
        $tFilter .= " AND Products.FTPdtCode != '$tProductCode' ";

        //-------------------แสดงสินค้าตาม Agen-------------------
        $tAgenCode = $paData['tAgenCode'];
        if ($tAgenCode != '') {
            $tFilter .= " AND Products.FTAgnCode = '$tAgenCode' ";
        }

        //-------------------สินค้าเคลื่อนไหว-------------------
        $nPDTMoveon = $paData['nPDTMoveon'];
        if ($nPDTMoveon == 1) {
            $tFilter .= " AND Products.FTPdtStaActive = '1' ";
        } else if ($nPDTMoveon == 2) {
            $tFilter .= " AND Products.FTPdtStaActive = '2' ";
        }

        //-------------------ฟิลเตอร์การค้นหา-------------------
        $tSearchSelect  = $paData['tSearchSelect'];
        $tSearchText    = $paData['tSearchText'];
        if ($tSearchText != '' || $tSearchText != null) {

            if ($tSearchSelect == 'PDTANDBarcode') {
                $tFilter .= " AND (Products.FTPdtCode = '$tSearchText' OR Products.FTBarCode = '$tSearchText' )";
            }
            switch ($tSearchSelect) {
                case "FTPdtName":
                    //ชื่อสินค้า
                    $tFilter .= " AND (Products.FTPdtName LIKE '%$tSearchText%')";
                    break;
                case "FTPdtCode":
                    //รหัสสินค้า
                    $tFilter .= " AND (Products.FTPdtCode LIKE '%$tSearchText%') ";
                    break;
                case "FTBarCode":
                    //รหัสบาร์โค้ด
                    $tFilter .= " AND (Products.FTBarCode LIKE '%$tSearchText%')";
                    break;
                case "FTPgpCode":
                    //กลุ่มสินค้า
                    $tFilter .= " AND (Products.FTPgpChain = '$tSearchText')";
                    break;
                case "FTPtyCode":
                    //ประเภทสินค้า
                    $tFilter .= " AND (Products.FTPtyCode = '$tSearchText' )";
                    break;
                case "FTBuyer":
                    //ผู้จัดซื้อ
                    $tFilter .= " AND (Products.FTBuyer = '$tSearchText')";
                    break;
                case "FTPlcCode":
                    //ที่เก็บ
                    $tFoundPDT = $this->mBrowserPDTCallView->FSnMFindPDTByBarcode($tSearchText, 'FINDPLCCODE');
                    if ($tFoundPDT == false || empty($tFoundPDT)) {
                        //กรณีที่เข้าไปหา plc code เเล้วไม่เจอ PDT เลย ต้องให้มันค้นหา โดย KEYWORD : EMPTY
                        $tFilter    .= " AND (Products.FTPdtCode = 'EMPTY' AND Products.FTPunCode = 'EMPTY')";
                    } else {
                        $tPDT       = $tFoundPDT[0]['FTPdtCode'];
                        $tPunCode   = $tFoundPDT[0]['FTPunCode'];
                        $tBarCode   = $tFoundPDT[0]['FTBarCode'];
                        $tFilter    .= " AND (Products.FTBarCode = '$tBarCode')";
                    }
                    break;
                case "ALL":
                    $tFilter .= " AND (Products.FTPdtName LIKE '%$tSearchText%')";
                    $tFilter .= " OR (Products.FTPdtCode LIKE '%$tSearchText%')";
                    $tFilter .= " OR (Products.FTPgpChain = '$tSearchText')";
                    $tFilter .= " OR (Products.FTBuyer = '$tSearchText')";
                    break;
                default:
                    $tFilter .= "";
            }
        }

        //-------------------อนุญาตลด-------------------
        if (!empty($paData['nDISTYPE'])) {
            $nDISTYPE = $paData['nDISTYPE'];
            $tFilter .= " AND (Products.FTPdtStaAlwDis = $nDISTYPE )";
        }

        //-------------------เงื่อนไขพิเศษ ตามหน้า-------------------
        $tPagename = $paData['tPagename'];
        if ($tPagename == 'PI') {
            $tFilter .= " AND (Products.FTPdtSetOrSN != 4)";
        }

        //-------------------ไม่เอาสินค้าอะไรบ้าง NOT IN-------------------
        $aNotinItem = $paData['aNotinItem'];
        if (!empty($aNotinItem)) {
            if ($aNotinItem != '' || $aNotinItem != null) {
                $tNotinItem     = '';
                $tNotinBarcode  = '';
                $aNewNotinItem  = explode(',', $aNotinItem);

                for ($i = 0; $i < FCNnHSizeOf($aNewNotinItem); $i++) {
                    $aNewPDT  = explode(':::', $aNewNotinItem[$i]);
                    $tFilter .= " AND (Products.FTPdtCode != '$aNewPDT[0]' OR Products.FTBarCode != '$aNewPDT[1]' )";
                }
            }
        }

        //-------------------เลือกราคาแบบไหน-------------------
        if ($paData['aPriceType'][0] == 'Pricesell') {
            $tLeftJoinPrice  = "";

            //ถ้าเหมือนกันให้ใช้ Price4PDT ถ้าไม่เหมือนกันให้ใช้ Price4BCH
            // $tLeftJoinPrice  = " LEFT JOIN VCN_Price4PdtActive VPP ON ";
            // $tLeftJoinPrice .= " VPP.FTPdtCode = ProductM.FTPdtCode AND ";
            // $tLeftJoinPrice .= " VPP.FTPunCode = ProductM.FTPunCode ";
        } else if ($paData['aPriceType'][0] == 'Price4Cst') {

            $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
            $tCstPplCode  = $paData['aPriceType'][1];

            //--ราคาของ customer
            $tLeftJoin = "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND FTPplCode = '$tCstPplCode'
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PCUS ON ProductM.FTPdtCode = PCUS.FTPdtCode AND ProductM.FTPunCode = PCUS.FTPunCode ";

            // --ราคาของสาขา
            $tLeftJoin .= "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND FTPplCode = (SELECT FTPplCode FROM TCNMBranch WHERE FTPplCode != '' AND FTBchCode = '$tUserBchCode')
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PBCH ON ProductM.FTPdtCode = PBCH.FTPdtCode AND ProductM.FTPunCode = PBCH.FTPunCode ";

            // --ราคาที่ไม่กำหนด PPL
            $tLeftJoin .= "LEFT JOIN (
                            SELECT * FROM (
                            SELECT 
                                ROW_NUMBER () OVER ( PARTITION BY FTPdtCode , FTPunCode ORDER BY FDPghDStart DESC) AS FNRowPart,
                                FTPdtCode , 
                                FTPunCode , 
                                FCPgdPriceRet 
                                FROM TCNTPdtPrice4PDT WHERE  
                            FDPghDStart <= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FDPghDStop >= CONVERT (VARCHAR(10), GETDATE(), 121)
                            AND FTPghTStart <= CONVERT(time,GETDATE())
	                        AND FTPghTStop >= CONVERT(time,GETDATE())
                            AND ISNULL(FTPplCode,'') = ''
                            ) AS PCUS 
                            WHERE PCUS.FNRowPart = 1 
                        ) PEMPTY ON ProductM.FTPdtCode = PEMPTY.FTPdtCode AND ProductM.FTPunCode = PEMPTY.FTPunCode ";

            $tLeftJoinPrice  = " $tLeftJoin ";
        } else if ($paData['aPriceType'][0] == 'Cost') {
            // $tLeftJoinPrice  = "";

            //ถ้าอยากหาราคา
            $tLeftJoinPrice  = " LEFT JOIN VCN_ProductCost VPC ON ";
            $tLeftJoinPrice .= " VPC.FTPdtCode = ProductM.FTPdtCode ";
        }

        

        //-------------------ผู้จำหน่าย-------------------
        if ($paData['tSPL'] != '' || $paData['tSPL'] != null) {
            $tFilter .= " AND (Products.FTSplCode = '" . $paData['tSPL'] . "' OR ISNULL(Products.FTSplCode,'') = '')";
        }

        //-------------------สาขา-------------------
        if ($paData['tBCH'] != '' || $paData['tBCH'] != null) {
            $tBCH      = $paData['tBCH'];
        } else {
            $tBCH      = $tBchSession;
        }

        //-------------------กลุ่มธุรกิจ-------------------
        if ($paData['tMER'] != '' || $paData['tMER'] != null) {
            $tFilter .= " AND (Products.FTMerCode = '" . $paData['tMER'] . "')";
        }

        //-------------------ร้านค้า-------------------
        if ($paData['tSHP'] != '' || $paData['tSHP'] != null) {
            //$tFilter .= " AND (Products.FTShpCode = '".$paData['tSHP']."')";
        }

        //------------------- สินค้าใน VD พาโนแกรม -------------------
        if( $tStaPdtLay == "N" ){
            $tFilter .= " AND Products.FTPdtCode NOT IN (   SELECT FTPdtCode
                                                            FROM TVDMPdtLayout WITH(NOLOCK)
                                                            WHERE ISNULL(FTPdtCode, '') <> '' 
                                                            AND FTBchCode = '".$tBCH."' ";

            if ($paData['tWAH'] != '' || $paData['tWAH'] != null) {
                $tFilter .= "                               AND FTWahCode = '".$paData['tWAH']."' ";
            }

            $tFilter .= "                                   GROUP BY FTPdtCode ";
            $tFilter .= "                               ) ";
        }

        //เงือนไขว่าวิ่งเข้า VIEW SQL ชุดไหน
        //+-------------+-------------+-------------+-------------+
        //+     BCH     +     MER     +     SHP     +    V_SQL    +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     null    +     null    +     HQ      +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     null    +     null    +     BCH     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     /       +     null    +     BCH     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     /       +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+      /      +     null    +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     /       +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     null    +      /      +     SHP     +
        //+-------------+-------------+-------------+-------------+
        //+     null    +     /       +     null    +     SHP     +
        //+-------------+-------------+-------------+-------------+

        $nTotalResult       = $paData['nTotalResult'];
        if ($paData['tBCH'] == '' && $paData['tMER'] == '' && $paData['tSHP'] == '') {
            // HQ
            $tPermission    = 'HQ';
        } else if ($paData['tBCH'] != '' && $paData['tMER'] == '' && $paData['tSHP'] == '') {
            // BCH 
            $tPermission    = 'BCH';
        } else if ($paData['tBCH'] != '' && $paData['tMER'] != '' && $paData['tSHP'] == '') {
            // BCH 
            $tPermission    = 'BCH';
        } else if ($paData['tBCH'] != '' && $paData['tMER'] != '' && $paData['tSHP'] != '') {
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        } else if ($paData['tBCH'] == '' && $paData['tMER'] != '' && $paData['tSHP'] != '') {
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        } else if ($paData['tBCH'] == '' && $paData['tMER'] == '' && $paData['tSHP'] != '') {
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        } else if ($paData['tBCH'] == '' && $paData['tMER'] != '' && $paData['tSHP'] == '') {
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        } else if ($paData['tBCH'] != '' && $paData['tMER'] == '' && $paData['tSHP'] != '') {
            // SHP
            $paData['tBCH'] = $tBCH;
            $tPermission    = 'SHP';
        } else {
            $tPermission    = 'ETC';
        }

        switch ($tPermission) {
            case "HQ":

                if($this->session->userdata("tSesUsrLevel")=='HQ'){
                    $aResultPDT = $this->mBrowserPDTCallView->FSaMGetProductHQ($tFilter, $tLeftJoinPrice, $paData, $nTotalResult);
                }else{
                    // กรณีไม่ใช้ HQ แต่เป็น AGN
                    $aResultPDT = $this->mBrowserPDTCallView->FSaMGetProductBCH($tFilter, $tLeftJoinPrice, $paData, $nTotalResult);
                }
                // print_r(  $aResultPDT );
                break;
            case "BCH":
                $aResultPDT = $this->mBrowserPDTCallView->FSaMGetProductBCH($tFilter, $tLeftJoinPrice, $paData, $nTotalResult);
                //print_r(  $aResultPDT );
                break;
            case "SHP":
                // $aResultPDT = $this->mBrowserPDTCallView->FSaMGetProductSHP($tFilter, $tLeftJoinPrice, $paData, $nTotalResult);
                $aResultPDT = $this->mBrowserPDTCallView->FSaMGetProductBCH($tFilter, $tLeftJoinPrice, $paData, $nTotalResult);
                break;
            default:
                $aResultPDT = ' E R R O R';
        }

        return $aResultPDT;
    }


    //เก็บ config ไว้ว่าจะหากี่ตัว
    public function FSvCallViewModalPdtConfig(){
        $aData = array(
            'nMaxPage'   => $this->input->post('nCheckMaxPage'),
            'nPerPage'   => $this->input->post('nCheckPerPage')
        );

        $tPrefixCookie = "PDTCookie_";

        $nCookieName = $tPrefixCookie . $this->session->userdata("tSesUserCode");
        $tCookieValue   = json_encode($aData);

        $aCookie = array(
            'name'    => $nCookieName,
            'value'   => $tCookieValue,
            'expire'  => 31556926,
        );

        $this->input->set_cookie($aCookie);
    }

    //หาว่าใช้ราคาแบบไหน
    public function GetTotalByConfig($aData){

        $nINDEXConfig       = explode(',',$aData['nINDEX']); 
        $nVATSPL            = $aData['nVATSPL'];
        $nCostAvgIn         = $aData['nCostAvgIn'];
        $nCostAvgEX         = $aData['nCostAvgEX'];
        $nCostLast          = $aData['nCostLast'];
        $nCostFiFoIn        = $aData['nCostFiFoIn'];
        $nCostFiFoEx        = $aData['nCostFiFoEx'];
        $nCostSTD           = $aData['nCostSTD'];
        $nResultCost        = "";

        for($i=0; $i<FCNnHSizeOf($nINDEXConfig); $i++){
            switch ($nINDEXConfig[$i]) {
                case 1: //ต้นทุนเฉลี่ย
                    if($nVATSPL == 1){
                        $nResultCost = $nCostAvgIn;
                    }else if($nVATSPL == 2){
                        $nResultCost = $nCostAvgEX;
                    }
                    $t = 'ต้นทุนเฉลี่ย';
                    break;
                case 2: //ต้นทุนสุดท้าย
                    $nResultCost = $nCostLast;
                    $t = 'ต้นทุนสุดท้าย';
                    break;
                case 3: //ต้นทุนมาตราฐาน
                    $nResultCost = $nCostSTD;
                    $t = 'ต้นทุนมาตราฐาน';
                    break;
                case 4: //ต้นทุน FiFo
                    if($nVATSPL == 1){
                        $nResultCost = $nCostFiFoIn;
                    }else if($nVATSPL == 2){
                        $nResultCost = $nCostFiFoEx;
                    }
                    $t = 'ต้นทุน FiFo';
                    break;
                default:
                    $nResultCost = 'EMPTY';
            }

            if($nResultCost == '' || $nResultCost == null){

            }else{
                break;  
            }
        }
        return $nResultCost;
    }

    ///////////////////////////////////////////// สินค้าแฟชั่น + สินค้าซีเรียล /////////////////////////////////////////////

    //โหลดหน้าจอ สำหรับสินค้าซีเรียล และสินค้าแฟชั่น
    public function FSvCallViewProductSerialandFashion(){

        $tEventType  = $this->input->post('tEventType');
        $aData       = json_decode($this->input->post('aData'));
        $aOption     = $this->input->post('oOptionForFashion');
        $tDataRemove = '';

        //check ก่อนว่าสินค้าแฟช่ั่นที่ส่งมานั้นมีรายละเอียดจริงไหม (จะเช็คต่อเมื่อเป็นรูปแบบหน้าจอ insert และ เช็คสำหรับครั้งเเรกเท่านั้น)
        if($this->input->post('nNumber') == 0 && $tEventType == 'insert'){ //สำหรับรอบแรกเท่านั้น
            //จะส่งสินค้าทั้งหมดไปหา และจะส่ง json กลับมาเฉพาะตัวที่มี ตัวที่ไม่มีจะเก็บเป็นรูปแบบ string คั่นด้วย คอมม่า
            $aCheckDetailInPDTColorSize     = $this->mBrowserPDTCallView->FSaMCheckDetailInPDTColorSize($aData);
            $aResultCheck                   = json_decode($aCheckDetailInPDTColorSize);
            $aData                          = $aResultCheck->aItemCheck_have;   //array สินค้าที่เจอ
            $tDataRemove                    = $aResultCheck->aItemCheck_remove; //string สินค้าที่ไม่เจอ
        }

        $aPackdata  = array(
            'aDetailPDT'            => $aData,                              //ข้อมูลสินค้า
            'tPDTType'              => $this->input->post('tPDTType'),      //สินค้าเป็น แฟชั่น FN หรือ ซีเรียล SN
            'nNumberArray'          => $this->input->post('nNumber'),       //จำนวนสินค้าตัวแรก เริ่มต้นเป็น 0
            'nAll'                  => count($aData),                       //จำนวนสินค้าที่เลือกมาทั้งหมดมีกี่ตัว
            'tNameNextFunc'         => $this->input->post('tNameNextFunc'), //ชื่อฟังก์ชั่นที่ส่งค่ากลับไป
            'oObjectResult'         => array(),                             //ข้อมูลรายละเอียดสินค้าแฟชั่น
            'tEventType'            => $tEventType,                         //รูปแบบของการเลือกข้อมูล insert (pageadd) หรือ update (pageupdate)
            'oOptionForFashion'     => $aOption                             //การเพิ่มสินค้าแฟชั่นแบบ พิเศษ
        );

        //ถ้าสินค้าที่เลือกมา ไม่มีการกำหนดรายละเอียดเลย ก็ให้จบลูป exit ออก
        if(count($aData) == 0){
            //ส่งค่ากลับไปหา ajax
            $aReturn = array(
                'tHTML'         => '',
                'nAll'          => count($aData),
                'tPDTRemove'    => substr($tDataRemove,0,-1),
                'tNameNextFunc' => $this->input->post('tNameNextFunc'),
                'tMSG'          => 'เป็นสินค้าแฟชั่นที่ไม่มีการกำหนดรายละเอียด'
            );
            echo json_encode($aReturn);
            exit;
        }
        
        if($this->input->post('tPDTType') == 'FH'){ //สินค้าแฟชั่น
            $tPDTCode  = $aData[$this->input->post('nNumber')]->PDTCode;
            $tPUNCode  = $aData[$this->input->post('nNumber')]->PUNCode;
            $tBarcode  = $aData[$this->input->post('nNumber')]->Barcode;
            $aDataPackGetDetail = array(
                'tPdtCode'  => $tPDTCode,
                'tPUNCode'  => $tPUNCode,
                'tBarcode'  => $tBarcode,
            );
            if($tEventType == 'insert'){ //ถ้าเป็นขาเพิ่มข้อมูลต้องเอาข้อมูลทั้งหมด
                $aDetailPDTFashion      = $this->mBrowserPDTCallView->FSaMGetDetailPDTFashion($aDataPackGetDetail);
            }else if($tEventType == 'update'){ //ถ้าเป็นขาแก้ไขข้อมูลจะเอามาแค่ตัวเดียว
                if(!empty($aData[$this->input->post('nNumber')]->PlcCode)){
                    $tDocumentPLcCode = $aData[$this->input->post('nNumber')]->PlcCode;
                }else{
                    $tDocumentPLcCode = '';
                }


                $aDataInDocumentTemp    = array(
                    'tDocumentnumber'   => $aData[0]->tDocno,
                    'tDocumentbranch'   => $aData[0]->BCH,
                    'tDocumentDockey'   => $aData[0]->tDocKey,
                    'nDTSeq'             => $aData[0]->nDTSeq,
                    'tDocumentPLcCode'   => $tDocumentPLcCode,
                    'oOptionForFashion'  => $aPackdata['oOptionForFashion'],
                    'tDocumentsession'  => $this->session->userdata("tSesSessionID")
                );
                $aDetailPDTFashion      = $this->mBrowserPDTCallView->FSaMGetDetailPDTSingleFashion($aDataPackGetDetail,$aDataInDocumentTemp);
            }

            $aPackdata['oObjectResult'] = $aDetailPDTFashion;
            $tHTML = $this->load->view('common/browseserialandfashion/wBrowsefashion', $aPackdata , true);
        }else if($this->input->post('tPDTType') == 'SN'){ //สินค้าซีเรียล

            //รอทำต่อ...
            $tHTML = $this->load->view('common/browseserialandfashion/wBrowseserial', $aPackdata , true);
        }

    
        //option ว่าจะแสดง popup ที่ละตัว หรือ เอาเฉพาะค่ากลับไป
        if($aOption['bListItemAll'] === 'false'){ //false : แสดงป็อปอัพที่ละตัว
            $tHTMLReturn = $tHTML;
            $aItemReturn = '';
        }else{ //true : เอาลิสต์สินค้าทั้งหมด
            $tHTMLReturn        = '';
            $aItemFahsionAll    = [];
            for($i=0; $i<count($aData); $i++){
                $tPDTCode          = $aData[$i]->PDTCode;
                $tPUNCode          = $aData[$i]->PUNCode;
                $tBarcode          = $aData[$i]->Barcode;
                $aDataPackGetDetail = array(
                    'tPdtCode'  => $tPDTCode,
                    'tPUNCode'  => $tPUNCode,
                    'tBarcode'  => $tBarcode,
                );
                $aDetailPDTFashion = $this->mBrowserPDTCallView->FSaMGetDetailPDTFashion($aDataPackGetDetail);
                array_push($aItemFahsionAll,$aDetailPDTFashion);
            }
            $aItemReturn = $aItemFahsionAll;
        }

        //ส่งค่ากลับไปหา ajax
        $aReturn = array(
            'tHTML'         => $tHTMLReturn,
            'aItemReturn'   => $aItemReturn,
            'nAll'          => count($aData),
            'tPDTRemove'    => substr($tDataRemove,0,-1),
            'tNameNextFunc' => $this->input->post('tNameNextFunc')
        );
        echo json_encode($aReturn);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
