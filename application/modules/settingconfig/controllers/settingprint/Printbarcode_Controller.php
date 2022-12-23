<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// Last Update : Napat(Jame) 25/11/2022 เปลี่ยนการดึง session เป็น cookies

class Printbarcode_Controller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('settingconfig/settingprint/Printbarcode_Model');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
     * Functionality : Main page for Print BarCode
     * Parameters : $nLabPriBrowseType, $tLabPriBrowseOption
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nLabPriBrowseType, $tLabPriBrowseOption)
    {
        // เคลียร์ tmp
        $this->Printbarcode_Model->FSaMPriBarClearDataMQ();
        $aDataConfigView    = [
            'nLabPriBrowseType'     => $nLabPriBrowseType,
            'tLabPriBrowseOption'   => $tLabPriBrowseOption,
            // 'aAlwEvent'             => FCNaHCheckAlwFunc('settingprint/0/0'),
            'aAlwEvent'             => ['tAutStaFull' => 1, 'tAutStaAdd' => 1, 'tAutStaEdit' => 1],
            'vBtnSave'              => FCNaHBtnSaveActiveHTML('settingprint/0/0'),
            'nOptDecimalShow'       => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'       => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('settingconfig/settingprint/wPrintBarCodePage', $aDataConfigView);
    }

    /**
     * Functionality : Function Call DataTables Printer BarCode
     * Parameters : Ajax and Function Parameter
     * Creator : 20/12/2021 Worakorn
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSxPriBarMoveDataIntoTable()
    {
        // $nPage          = $this->input->post('nPageCurrent');
        // $tSearchAll     = $this->input->post('tSearchAll');
        $tPlbCode       = $this->input->post('tPlbCode');
        // $bSeleteImport  = $this->input->post('bSeleteImport');

        // if ($nPage == '' || $nPage == null) {
        //     $nPage = 1;
        // } else {
        //     $nPage = $this->input->post('nPageCurrent');
        // }


        // if ($tPlbCode == '' || $tPlbCode == null) {
        //     $tPlbCode = 1;
        // } else {
        //     $tPlbCode = $this->input->post('tPlbCode');
        // }

        // if (!$tSearchAll) {
        //     $tSearchAll = '';
        // }
        //Lang ภาษา
        // $nLangResort    = FCNoGetCookieVal("tLangID");
        $nLangEdit      = FCNoGetCookieVal("tLangEdit");
        

        $aDataWhere = array(
            'tPrnBarSheet'       => $this->input->post('tPrnBarSheet'),
            'tPrnBarXthDocDateFrom' => $this->input->post('tPrnBarXthDocDateFrom'),
            'tPrnBarXthDocDateTo'   => $this->input->post('tPrnBarXthDocDateTo'),
            'tPrnBarBrowseRptNoFromCode' => $this->input->post('tPrnBarBrowseRptNoFromCode'),
            'tPrnBarBrowseRptNoToCode'   => $this->input->post('tPrnBarBrowseRptNoToCode'),
            'tPrnBarBrowsePdtFromCode'  => $this->input->post('tPrnBarBrowsePdtFromCode'),
            'tPrnBarBrowsePdtToCode'   => $this->input->post('tPrnBarBrowsePdtToCode'),
            'tPrnBarBrowsePdtGrpFromCode' => $this->input->post('tPrnBarBrowsePdtGrpFromCode'),
            'tPrnBarBrowsePdtGrpToCode'  => $this->input->post('tPrnBarBrowsePdtGrpToCode'),
            'tPrnBarBrowsePdtTypeFromCode'  => $this->input->post('tPrnBarBrowsePdtTypeFromCode'),
            'tPrnBarBrowsePdtTypeToCode' => $this->input->post('tPrnBarBrowsePdtTypeToCode'),
            'tPrnBarBrowsePdtBrandFromCode' => $this->input->post('tPrnBarBrowsePdtBrandFromCode'),
            'tPrnBarBrowsePdtBrandToCode' => $this->input->post('tPrnBarBrowsePdtBrandToCode'),
            'tPrnBarBrowsePdtModelFromCode' => $this->input->post('tPrnBarBrowsePdtModelFromCode'),
            'tPrnBarBrowsePdtModelToCode' => $this->input->post('tPrnBarBrowsePdtModelToCode'),
            'tPrnBarPdtDepartCode'  => $this->input->post('tPrnBarPdtDepartCode'),
            'tPrnBarPdtClassCode' => $this->input->post('tPrnBarPdtClassCode'),
            'tPrnBarPdtSubClassCode' => $this->input->post('tPrnBarPdtSubClassCode'),
            'tPrnBarPdtGroupCode' => $this->input->post('tPrnBarPdtGroupCode'),
            'tPrnBarPdtComLinesCode' => $this->input->post('tPrnBarPdtComLinesCode'),
            'tPrnBarTotalPrint'  => $this->input->post('tPrnBarTotalPrint'),
            'tPrnBarPlbCode' => $tPlbCode,
            'nPrnBarStaStartDate'  => $this->input->post('nPrnBarStaStartDate'),
            'tPrnBarEffectiveDate'  => $this->input->post('tPrnBarEffectiveDate'),
            'tPRNLblVerGroup' => $this->input->post('tPRNLblVerGroup'),
            'tPRNLblCode' => $this->input->post('tPRNLblCode'),
        );

        $aData  = array(
            // 'nPage'         => $nPage,
            // 'nRow'          => 20,
            'FNLngID'       => $nLangEdit,
            // 'tSearchAll'    => $tSearchAll,
            'tSesAgnCode'   => FCNoGetCookieVal("tSesUsrAgnCode"),
            'aDataWhere'    => $aDataWhere,
            // 'bSeleteImport' => $bSeleteImport
        );

        $this->Printbarcode_Model->FSxMPriBarMoveDataIntoTable($aData);

        $aGenTable = array(
            // 'aDataList'     => $aResList,
            // 'nPage'         => $nPage,
            // 'tSearchAll'    => $tSearchAll,
            'tPlbCode'      => $tPlbCode,
            // 'bSeleteImport' => $bSeleteImport
        );
        echo json_encode($aGenTable);
        // $this->load->view('settingconfig/settingprint/wPrintBarCodeDataTable', $aGenTable);
    }


    public function FSvPriDataTableSearch()
    {
        $nPage          = $this->input->post('nPageCurrent');
        $tSearchAll     = $this->input->post('tSearchAll');
        $tPlbCode       = $this->input->post('tPlbCode');
        $bSeleteImport  = $this->input->post('bSeleteImport');
        $tLblVerGroup   = $this->input->post('tPRNLblVerGroup');

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        if (!$tSearchAll) {
            $tSearchAll = '';
        }

        //Lang ภาษา
        $nLangEdit      = FCNoGetCookieVal("tLangEdit");
        $oSortBy        = get_cookie('AdaBarPrintSort');
        if( $oSortBy === NULL ){
            $tSortBy = "FTPdtCode ASC";
        }else{
            $aSortBy = json_decode($oSortBy, TRUE);
            $tSortBy = $aSortBy['tSortCode'];
        }
        
        if( $tLblVerGroup == 'KPC' ){
            // KPC
            $aShwColums = array(
                'FTPdtCode'         => array( 'tLang' => 'tLPRTPdtCode', 'tStyle' => 'width:7%;', 'tdClass' => 'text-left' ),
                'FTPdtName'         => array( 'tLang' => 'tLPRTPdtName', 'tStyle' => 'width:25%;', 'tdClass' => 'text-left' ),
                'FTPdtContentUnit'  => array( 'tLang' => 'tLPRTPdtUnit', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
                'FTPbnDesc'         => array( 'tLang' => 'แบรนด์', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
                'FTBarCode'         => array( 'tLang' => 'tLPRTPdtBarCode', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
                'FTPdtRefNo'        => array( 'tLang' => 'tLPRTPdtBarPdgRegNo', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
                'FCPdtPrice'        => array( 'tLang' => 'tLPRTPdtPrice', 'tStyle' => 'width:6%;', 'tdClass' => 'text-right' ),
                'FTPlbPriType'      => array( 'tLang' => 'tLPRTPdtPriceType', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
                'FNPlbQty'          => array( 'tLang' => 'tLPRTTotalPrint', 'tStyle' => 'width:7%;', 'tdClass' => 'text-right' ),
                'FTPlbStaImport'    => array( 'tLang' => 'หมายเหตุ', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left' ),
            );
        }else{
            // STD
            $aShwColums = array(
                'FTBarCode'         => array( 'tLang' => 'tLPRTPdtBarCode', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left'  ),
                'FTPdtName'         => array( 'tLang' => 'tLPRTPdtName', 'tStyle' => 'width:25%;', 'tdClass' => 'text-left'  ),
                'FCPdtPrice'        => array( 'tLang' => 'tLPRTPdtPrice', 'tStyle' => 'width:6%;', 'tdClass' => 'text-right'  ),
                'FTPlbPriType'      => array( 'tLang' => 'tLPRTPdtPriceType', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left'  ),
                'FNPlbQty'          => array( 'tLang' => 'tLPRTTotalPrint', 'tStyle' => 'width:7%;', 'tdClass' => 'text-right'  ),
                'FTPlbStaImport'    => array( 'tLang' => 'หมายเหตุ', 'tStyle' => 'width:10%;', 'tdClass' => 'text-left'  ),
            );
        }

        $aData  = array(
            'nPage'             => $nPage,
            'nRow'              => 20,
            'FNLngID'           => $nLangEdit,
            'tSearchAll'        => $tSearchAll,
            'tSesAgnCode'       => FCNoGetCookieVal("tSesUsrAgnCode"),
            'bSeleteImport'     => $bSeleteImport,
            'tSortBy'           => $tSortBy,
        );
        $aResList = $this->Printbarcode_Model->FSaMPriBarListSearch($aData, $aShwColums);

        $aGenTable = array(
            'aDataList'         => $aResList,
            'nPage'             => $nPage,
            'tSearchAll'        => $tSearchAll,
            'tPlbCode'          => $tPlbCode,
            'bSeleteImport'     => $bSeleteImport,
            'aShwColums'        => $aShwColums
        );
        $this->load->view('settingconfig/settingprint/wPrintBarCodeDataTable', $aGenTable);
    }



    /**
     * Functionality : Function Edit In Line Printer BarCode
     * Parameters : Ajax 
     * Creator : 10/01/2022 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function FSvPriBarUpdateEditInLine()
    {
        $nValue = $this->input->post('nValue');
        $tPdtCode = $this->input->post('tPdtCode');
        $tPdtBarCode = $this->input->post('tPdtBarCode');
        $tPriType = $this->input->post('tPriType');

        $this->Printbarcode_Model->FSaMPriBarUpdateEditInLine($nValue, $tPdtCode, $tPdtBarCode,$tPriType);
    }


    /**
     * Functionality : Function Update Checked All Printer BarCode
     * Parameters : Ajax 
     * Creator : 10/01/2022 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function FSvPriBarUpdateCheckedAll()
    {
        $bCheckedAll = $this->input->post('bCheckedAll');

        $this->Printbarcode_Model->FSaMPriBarUpdateCheckedAll($bCheckedAll);
    }



    /**
     * Functionality : Function Update Checked Printer BarCode
     * Parameters : Ajax 
     * Creator : 10/01/2022 Worakorn
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function FSvPriBarUpdateChecked()
    {
        $tValueChecked = $this->input->post('tValueChecked');
        $tPdtCode = $this->input->post('tPdtCode');
        $tBarCode = $this->input->post('tBarCode');
        $tPriType = $this->input->post('tPriType');

        $this->Printbarcode_Model->FSaMPriBarUpdateChecked($tValueChecked, $tPdtCode, $tBarCode, $tPriType);
    }


    /**
     * Functionality : Function MQ Process BarCode
     * Parameters : Ajax 
     * Creator : 10/01/2022 Worakorn
     * Last Modified : 29/07/2022 Napat(Jame) เพิ่มการส่ง HD Tmp
     * Return : -
     * Return Type : -
     */
    function FSvPriBarMQProcess()
    {
        $tPrnBarPrnLableCode    = $this->input->post('tPrnBarPrnLableCode');
        $tPrnBarPrnSrvCode      = $this->input->post('tPrnBarPrnSrvCode');

        $this->Printbarcode_Model->FSaMPriBarUpdateLableCode($tPrnBarPrnLableCode);
        $aGetPage = $this->Printbarcode_Model->FSaMPRNGetPageInPriType();
        if( $aGetPage['tCode'] == '1' ){

            $oConnection = new AMQPStreamConnection(MQ_PRINT_HOST, MQ_PRINT_PORT, MQ_PRINT_USER, MQ_PRINT_PASS, MQ_PRINT_VHOST);
            $oChannel = $oConnection->channel();
            $oChannel->queue_declare($tQueueName, false, true, false, false);
            // echo "<pre>";
            foreach($aGetPage['aItems'] as $nKey => $aValue){ // loop ประเภทราคา loop จำนวนหน้า ตามประเภทราคา
                $tPriType   = $aValue['FTPlbPriType'];
                $nPage      = $aValue['FNPage'];
                $nMaxPage   = $aValue['FNMaxPage'];
                $nSeqSend   = $aValue['FNSeqSend'];

                // get data
                $aData =  $this->Printbarcode_Model->FSaMPriBarListDataMQ($tPriType,$nPage);

                // settings unique key
                $tDateNow = date('Y-m-d H:i:s');
                $tUniqueKey = FCNoGetCookieVal("tSesUserCode").date('YmdHis', strtotime($tDateNow));

                $aMQParams = [
                    "queueName" => $tPrnBarPrnSrvCode,
                    "tVhostType" => "MQ",
                    "params" => [
                        'ptFunction'    => 'PrintLabel',
                        'ptSource'      => 'AdaStoreBack',
                        'ptDest'        => 'AdaBarPrintSrv',
                        'ptFilter'      => $tUniqueKey,
                        'ptData'        => json_encode($aData['raItems']),
                        'pnPage'        => $nSeqSend,
                        'pnTotalPage'   => $nMaxPage

                    ]
                ];
                // print_r($aMQParams);exit;

                $tQueueName = (isset($aMQParams['queueName'])) ? $aMQParams['queueName'] : '';
                $aParams = (isset($aMQParams['params'])) ? $aMQParams['params'] : [];

                $oMessage = new AMQPMessage(json_encode($aParams));
                $oChannel->basic_publish($oMessage, "", $tQueueName);
            }

            $oChannel->close();
            $oConnection->close();
        }
        
        return 1;
    }


    public function FSaCPRIImportDataTable()
    {
        $this->load->view('settingconfig/settingprint/wPrintBarCodeImportDataTable');
    }

    public function FSaCPRIGetDataImport()
    {
        $aDataSearch = array(
            'nPageNumber'    => ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber'),
            'nLangEdit'        => FCNoGetCookieVal("tLangEdit"),
            'tTableKey'        => 'TCNMBranch',
            'tSessionID'    => FCNoGetCookieVal("tSesSessionID"),
            'tTextSearch'    => $this->input->post('tSearch')
        );
        $aGetData                     = $this->Printbarcode_Model->FSaMPRIGetTempData($aDataSearch);
        $data['draw']                 = ($this->input->post('nPageNumber') == 0) ? 1 : $this->input->post('nPageNumber');
        $data['recordsTotal']         = $aGetData['numrow'];
        $data['recordsFiltered']     = $aGetData['numrow'];
        $data['data']                 = $aGetData;
        $data['error']                 = array();
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    public function FSaCPRIImportDelete()
    {
        $aDataMaster = array(
            'FNTmpSeq'         => $this->input->post('FNTmpSeq'),
            'tTableKey'        => 'TCNMBranch',
            'tSessionID'    => FCNoGetCookieVal("tSesSessionID")
        );
        $aResDel   = $this->Printbarcode_Model->FSaMPRIImportDelete($aDataMaster);

        //validate ข้อมูลซ้ำในตาราง Tmp
        $tBchCode = $this->input->post('FTBchCode');
        if (is_array($tBchCode)) {
            foreach ($tBchCode as $tValue) {
                $aValidateData = array(
                    'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                    'tFieldName'        => 'FTBchCode',
                    'tFieldValue'        => $tValue
                );
                FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
            }
        } else {
            $aValidateData = array(
                'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
                'tFieldName'        => 'FTBchCode',
                'tFieldValue'        => $tBchCode
            );
            FCNnMasTmpChkInlineCodeDupInTemp($aValidateData);
        }

        //ให้มันวิ่งเข้าไปหาในตารางจริงอีกรอบ
        $aValidateData = array(
            'tUserSessionID'    => FCNoGetCookieVal("tSesSessionID"),
            'tFieldName'        => 'FTBchCode',
            'tTableName'        => 'TCNMBranch'
        );
        FCNnMasTmpChkCodeDupInDB($aValidateData);

        echo json_encode($aResDel);
    }

    // ย้ายรายการจาก Temp ไปยัง Master
    public function FSaCPRIImportMove2Master()
    {

        $tTypeCaseDuplicate = $this->input->post('tTypeCaseDuplicate');

        $aDataMaster = array(
            'nLangEdit'                => FCNoGetCookieVal("tLangEdit"),
            'tTableKey'                => 'TCNMBranch',
            'tSessionID'            => FCNoGetCookieVal("tSesSessionID"),
            'dDateOn'                => date('Y-m-d H:i:s'),
            'dBchDateStart'            => date('Y-m-d'),
            'dBchDateStop'            => date('Y-m-d', strtotime('+1 year')),
            'tUserBy'                => FCNoGetCookieVal("tSesUsername"),
            'tTypeCaseDuplicate'     => $this->input->post('tTypeCaseDuplicate')
        );

        $this->db->trans_begin();

        $aResult =     $this->Printbarcode_Model->FSaMPRIImportMove2Master($aDataMaster);
        $this->Printbarcode_Model->FSaMPRIImportMove2MasterAndInsWah($aDataMaster);
        $this->Printbarcode_Model->FSaMPRIImportMove2MasterAndReplaceOrInsert($aDataMaster);
        $this->Printbarcode_Model->FSaMPRIImportMove2MasterDeleteTemp($aDataMaster);

        // Update Session Branch
        if (FCNoGetCookieVal('tSesUsrLevel') != "HQ") {
            $tSesUserCode  =  FCNoGetCookieVal('tSesUserCode');
            $aDataUsrGroup         = $this->mLogin->FSaMLOGGetDataUserLoginGroup($tSesUserCode);
            $tUsrBchCodeMulti     = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup, 'FTBchCode', 'value');
            $tUsrBchNameMulti     = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup, 'FTBchName', 'value');
            $nUsrBchCount        = $this->mLogin->FStMLOGMakeArrayToString($aDataUsrGroup, 'FTBchCode', 'counts');
            $this->session->set_userdata("tSesUsrBchCodeMulti", $tUsrBchCodeMulti);
            $this->session->set_userdata("tSesUsrBchNameMulti", $tUsrBchNameMulti);
            $this->session->set_userdata("nSesUsrBchCount", $nUsrBchCount);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $aReturnToHTML = array(
                'tCode'     => '99',
                'tDesc'     => 'Error'
            );
        } else {
            $this->db->trans_commit();
            $aReturnToHTML = $aResult;
        }

        echo json_encode($aReturnToHTML);
    }

    //หาจำนวนทั้งหมดออกมาโชว์
    public function FSaCPRIImportGetItemAll()
    {
        $aResult  = $this->Printbarcode_Model->FSaMPRIGetTempDataAtAll();
        echo json_encode($aResult);
    }

    
    // Create By: Napat(Jame) 26/07/2022
    public function FSoPRNEventGenHD(){
        $aPackData          = $this->input->post('paPackData');        
        $nPrnType           = $aPackData['nPrnType'];

        switch($nPrnType){
            case '1':
                $nPerPage = intval($aPackData['tRptNormalQtyPerPage']);
                break;
            case '2':
                $nPerPage = intval($aPackData['tRptPromotionQtyPerPage']);
                break;
        }

        $aResult = $this->Printbarcode_Model->FSaMPRNGetAllData($nPrnType);
        // echo "<pre>";
        if( FCNnHSizeOf($aResult) > 0 ){
            $nCurrentPage = 1;
            $nCurrentQty  = 0;
            $nCurrentSeq  = 1;
            $aNewData = array();
            foreach($aResult as $nKey => $aValue){
                // echo "1. ".$nCurrentQty." < ".$nPerPage."<br>";
                if( $nCurrentQty < $nPerPage ){  

                    $nReqQty  = $nPerPage - $nCurrentQty;           // จำนวนที่ต้องการ
                    $nDiffQty = ($nReqQty - $aValue['FNPlbQty']);   // จำนวนพิมพ์(ที่เหลือ)

                    // echo " 1.1 ReqQty ".$nPerPage." - ".$nCurrentQty." = ".$nReqQty."<br>";
                    // echo " 1.2 DiffQty (".$nReqQty." - ".$aValue['FNPlbQty'].") = ".$nDiffQty."<br>";

                    // กรณี 1.สินค้านี้ต้อง insert มากกว่า 1 page
                    if( $nDiffQty < 0 ){    
                        // insert จำนวนพิมพ์(ที่เหลือ) ใน page ก่อนหน้า 1 ครั้ง
                        $aResult[$nKey]['FNPage']   = $nCurrentPage;
                        $aResult[$nKey]['FNSeq']    = $nCurrentSeq;
                        $aResult[$nKey]['FNPlbQty'] = abs($nReqQty);
                        array_push($aNewData,$aResult[$nKey]);
                        // echo " 1.3 Insert Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".abs($nReqQty)."<br>";
                        $nCurrentPage += 1;
                        $nCurrentQty   = 0;
                        $nCurrentSeq  += 1;
                        // echo " 1.4 Next Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nCurrentQty."<br>";
                        
                        // จากนั้นเอา จำนวนพิมพ์(ที่เหลือ) หาร จำนวนดวง/หน้า
                        // จะรู้ว่าต้อง loop ให้มันเต็ม page อีกกี่ครั้ง
                        $nLen = abs($nDiffQty) / $nPerPage;
                        // echo " 1.5 nLen ".abs($nDiffQty)." / ".$nPerPage." = ".$nLen."<br>";
                        for($i=0;$i<intval($nLen);$i++){
                            // echo $nCurrentPage." : loop for <br>";
                            $aResult[$nKey]['FNPage']   = $nCurrentPage;
                            $aResult[$nKey]['FNSeq']    = $nCurrentSeq;
                            $aResult[$nKey]['FNPlbQty'] = $nPerPage;
                            array_push($aNewData,$aResult[$nKey]);
                            // echo " 1.6 Insert Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nPerPage."<br>";
                            $nDiffQty      = abs($nDiffQty) - $nPerPage;
                            // echo " 1.7 DiffQty ".abs($nDiffQty)." - ".$nPerPage." = ".$nDiffQty."<br>";
                            $nCurrentPage += 1;
                            $nCurrentQty   = 0;
                            $nCurrentSeq  += 1;
                            // echo " 1.8 Next Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nCurrentQty."<br>";
                        }

                        // จากนั้นเช็คว่ามี จำนวนพิมพ์(ที่เหลือ) ที่หารแล้วไม่เต็ม page อีกไหม
                        // ถ้ามีก็ให้ insert จำนวนพิมพ์(ที่เหลือ) ใน page ถัดไป
                        if( abs($nDiffQty) > 0 ){
                            $aResult[$nKey]['FNPage']   = $nCurrentPage;
                            $aResult[$nKey]['FNSeq']    = $nCurrentSeq;
                            $aResult[$nKey]['FNPlbQty'] = abs($nDiffQty);
                            array_push($aNewData,$aResult[$nKey]);
                            // echo " 1.9 Insert Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".abs($nDiffQty)."<br>";
                            $nCurrentQty   = abs($nDiffQty);
                            $nCurrentSeq  += 1;
                            // echo " 1.10 Next Seq Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nCurrentQty."<br>";
                        }
                    }else{
                        // กรณี 2.สินค้านี้ insert ได้ภายใน 1 page
                        if( $nDiffQty > 0 ){
                            $aResult[$nKey]['FNPage']   = $nCurrentPage;
                            $aResult[$nKey]['FNSeq']    = $nCurrentSeq;
                            array_push($aNewData,$aResult[$nKey]);
                            // echo " 2. Insert Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$aValue['FNPlbQty']."<br>";
                            $nCurrentSeq  += 1;
                            $nCurrentQty  += $aValue['FNPlbQty'];
                            // echo " 2.1 Next Seq Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nCurrentQty."<br>";
                        }
                    }

                    // กรณี 3.สินค้านี้มี จำนวนพิมพ์ = จำนวนดวง/หน้า สั่งไปหน้าถัดไปได้เลย
                    if( $nDiffQty == 0 ){ 
                        $aResult[$nKey]['FNPage']   = $nCurrentPage;
                        $aResult[$nKey]['FNSeq']    = $nCurrentSeq;
                        array_push($aNewData,$aResult[$nKey]);
                        // echo " 3. Insert Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$aResult[$nKey]['FNPlbQty']."<br>";
                        $nCurrentSeq  += 1;
                        $nCurrentPage += 1;
                        $nCurrentQty   = 0;
                        // echo " 3.1 Next Page: ".$nCurrentPage." Seq: ".$nCurrentSeq." Qty: ".$nCurrentQty."<br>";
                    }

                }
            }
            // echo "<pre>"; print_r($aNewData); exit;
            
            $aPackData = array(
                'nPrnType'  => $nPrnType,
                'aNewData'  => $aNewData
            );

            $this->db->trans_begin();
            $this->Printbarcode_Model->FSxMPRNEventGenHD($aPackData);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'tCode'     => '99',
                    'tDesc'     => $this->db->error()['message']
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'tCode'     => '1',
                    'tDesc'     => 'Gen HD Tmp Success'
                );
            }
        }else{
            $aReturn = array(
                'tCode'     => '1',
                'tDesc'     => 'ไม่พบข้อมูลสินค้า'
            );
        }
        echo json_encode($aReturn);

    }

    // Create By: Napat(Jame) 26/07/2022
    public function FSvPriPagePreviewList(){
        $nPrnType = $this->input->post('pnPrnType');
        
        $aDataList      = $this->Printbarcode_Model->FSaMPRNGetDataHDTmp($nPrnType);
        $aDataSummary   = $this->Printbarcode_Model->FSaMPRNGetSummaryHDTmp($nPrnType);
        $aGenTable      = array(
            'aDataList'     => $aDataList,
            'aDataSummary'  => $aDataSummary,
            'nPrnType'      => $nPrnType
        );
        $this->load->view('settingconfig/settingprint/preview/wPrintBarCodePrevew', $aGenTable);
    }

    // Create By: Napat(Jame) 26/07/2022
    function FSoPRNUpdStaSelHDTmp(){
        $aData = array(
            'tValueChecked' => $this->input->post('ptValueChecked'),
            'nPage'         => $this->input->post('pnPage'),
            'tPriType'      => $this->input->post('ptPriType'),
            'tSelType'      => $this->input->post('ptSelType'),
        );
        $this->Printbarcode_Model->FSxMPRNUpdStaSelHDTmp($aData);
        $aDataSummary = $this->Printbarcode_Model->FSaMPRNGetSummaryHDTmp($aData['tPriType']);
        echo json_encode($aDataSummary);
    }

    // Create By: Napat(Jame) 01/12/2022
    // กรณี KPC รหัส L015 ให้ส่ง Url ไปสร้าง QR Code
    function FSoPRNUpdPlbUrl(){
        $this->Printbarcode_Model->FSxMPRNUpdPlbUrl();
    }
}
