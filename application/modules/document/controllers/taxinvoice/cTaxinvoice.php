<?php
defined('BASEPATH') or exit('No direct script access allowed');
use PhpAmqpLib\Connection\AMQPStreamConnection;

class cTaxInvoice extends MX_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('document/taxInvoice/mTaxinvoice');
    }

    public function index($nBrowseType, $tBrowseOption){
        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('dcmTXIN/0/0');
        $aData['aAlwConfigForm']    = $this->mTaxinvoice->FSaMTAXGetConfig();

        $aData['aParams']['tDocNo']      = $this->input->post('tDocNo');
        $aData['aParams']['tBchCode']    = $this->input->post('tBchCode');

        $this->load->view('document/taxInvoice/wTaxInvoice', $aData);
    }

    //Load List
    public function FSvCTAXLoadList(){
        $this->load->view('document/taxInvoice/wTaxInvoiceSearchList');
    }

    //Load Datatable
    public function FSvCTAXLoadListDatatable(){
        $nPage           = $this->input->post('nPage');
        $aDataSearch     = $this->input->post('aDataSearch');

        $aDataWhere = array(
            'nPage'                 => $nPage,
            'nRow'                  => 10,
            'aDataSearch'           => $aDataSearch,
            'FNLngID'               => $this->session->userdata("tLangEdit")
        );

        $aABB       = $this->mTaxinvoice->FSaMTAXGetListABB($aDataWhere);
        $aDataHTML  = array(
            'nPage' => $this->input->post("nPage"),
            'aABB'  => $aABB
        );

        $this->load->view('document/taxInvoice/wTaxInvoiceListDatatable', $aDataHTML);
    }

    //Load Page Add
    public function FSvCTAXLoadPageAdd(){
        $tDocument          = $this->input->post('tDocument');
        $tDocumentBchCode   = $this->input->post('tDocumentBchCode');
        if($tDocument == '' || $tDocument == null){
            $tTypePage       = 'Insert';
            $tDocumentNumber = '';
            $tDocumentBchCode        = '';
        }else{
            $tTypePage       = 'Preview';
            $tDocumentNumber = $tDocument;
            $tDocumentBchCode  = $tDocumentBchCode;
        }

        $aReturnData = array(
            'tTypePage'         => $tTypePage,
            'tDocumentNumber'   => $tDocumentNumber,
            'tDocumentBchCode'  => $tDocumentBchCode
        );

        $tViewPageAdd       = $this->load->view('document/taxInvoice/wTaxInvoicePageAdd',$aReturnData);
        return $tViewPageAdd;
    }

    //Load Datatable
    public function FSvCTAXLoadDatatable(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tBrowseBchCode     = $this->input->post('tBrowseBchCode');
        $tSearchPDT         = $this->input->post('tSearchPDT');
        $nPage              = $this->input->post('nPage');

        $aWhere = array(
            'tDocumentNumber' => $tDocumentNumber,
            'tBrowseBchCode'  => $tBrowseBchCode,
            'tSearchPDT'      => $tSearchPDT,
            'nRow'            => 10,
            'nPage'           => $nPage,
            'FNLngID'         => $this->session->userdata("tLangEdit")
        );
        // print_r($aWhere);exit;
        // ตรงนี้ด้วย

        if($tDocumentNumber == '' || $tDocumentNumber == null){
            $aGetDT     = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => 1,
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
            $aGetHD     = array(
                'rtCode'        => '800',
                'rtDesc'        => 'data not found'
            );
            $aDataDocRC = array(
                'aItems'            => array(),
                'tCode'             => '800',
                'tDesc'             => 'data not found'
            );
        }else{
            $aGetDT         = $this->mTaxinvoice->FSaMTAXGetDT($aWhere);
            $aGetHD         = $this->mTaxinvoice->FSaMTAXGetHD($aWhere);
            $aDataDocRC     = $this->mTaxinvoice->FSaMTAXGetRCTax($aWhere,'ABB');
        }

        // $aGetDT     = $this->mTaxinvoice->FSaMTAXGetDT($aWhere);
        // $aGetHD     = $this->mTaxinvoice->FSaMTAXGetHD($aWhere);

        $aPackData  = array(
            'nPage'         => $nPage,
            'aGetDT'        => $aGetDT,
            'aGetHD'        => $aGetHD,
            'tTypePage'     => 'Insert'
        );
        $aReturnData = array(
            'tContentPDT'         => $this->load->view('document/taxInvoice/wTaxInvoiceDatatable',$aPackData, true),
            'tContentSumFooter'   => $this->load->view('document/taxInvoice/wTaxInvoiceSumFooter',$aPackData, true),
            'aDetailHD'           => $aGetHD,
            'aDataDocRC'          => $aDataDocRC,
            'aDataDisPro'         => $this->mTaxinvoice->FSaMTAXEventGetDataDisPromotions($aWhere,'ABB'), // Get Data Discount Promotions
            'aDataEndBillVat'     => $this->mTaxinvoice->FSaMTAXEventGetDataEndBillVat($aWhere,'ABB') // Get Data End Bill Vat
        );
        echo json_encode($aReturnData);
    }

    //Load Datatable ABB ให้เลือก
    public function FSvCTAXLoadDatatableABB(){
        $tFilter        = $this->input->post('tFilter');
        $tSearchABB     = $this->input->post('tSearchABB');
        $tTextDateABB   = $this->input->post('tTextDateABB');
        $nPage          = $this->input->post('nPage');
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tBCH           = $this->input->post('tBCH');

        $aPackData = array(
            'tFilter'       => $tFilter,
            'tSearchABB'    => $tSearchABB,
            'tTextDateABB'  => $tTextDateABB,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tBCH'          => $tBCH
        );

        $aGetABB    = $this->mTaxinvoice->FSaMTAXListABB($aPackData);
        $aDataView  = array(
            'nPage'         => $nPage,
            'aDataList'     => $aGetABB
        );

        $tTableABBHtml  = $this->load->view('document/taxInvoice/SelectABB/wSelectABB', $aDataView, true);
        $aReturnData    = array(
            'tTableABBHtml'   => $tTableABBHtml
        );
        echo json_encode($aReturnData);
    }

    //เอาเลขที่ใบกำกับภาษีอย่างย่อวิ่งเข้าไปค้นหา
    public function FSaCTAXCheckABBNumber(){
        $tDocumentNumber    = trim($this->input->post('DocumentNumber'));
        $tBCH               = $this->input->post('tBCH');
        $aGetABB            = $this->mTaxinvoice->FSaMTAXCheckABBNumber($tDocumentNumber,$tBCH);
        // print_r($aGetABB);
        if( $aGetABB['tCode'] != '1' ){
            $aReturn = array(
                'tStatus'   => $aGetABB['tCode']
            );
        }else{
            $aReturn = array(
                'tStatus'   => $aGetABB['tCode'],
                'tCuscode'  => ($aGetABB['aItems']['FTCstCode'] == '') ? '' : $aGetABB['aItems']['FTCstCode'],
                'tCusname'  => ($aGetABB['aItems']['FTCstName'] == '') ? '' : $aGetABB['aItems']['FTCstName']
            );
        }
        // print_r($aReturn);exit;
        echo json_encode($aReturn);
    }

    //โหลดที่อยุ่
    public function FSaCTAXLoadAddress(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tCustomer          = $this->input->post('tCustomer');

        //จะวิ่งไปหาที่อยู่ TCNMTaxAddress_L ก่อนว่าเคยออกไหม
        if($tCustomer != '' ||  $tCustomer != null){
            $aAddress  = $this->mTaxinvoice->FSaMTAXFindAddress($tCustomer);
            if(empty($aAddress)){
                //ไม่เจอข้อมูลในวิ่งไปหา TCNMCstAddress_L
                $aAddressHDCst   = $this->mTaxinvoice->FSaMTAXFindAddressCst($tCustomer,null);
                if(empty($aAddressHDCst)){
                    //ไม่เจอ
                    $aReturn    = array(
                        'tStatus' => 'null'
                    );
                }else{
                    //เจอที่อยู่ TCNMCstAddress_L
                    $aReturn    = array(
                        'tStatus'   => 'passCst',
                        'aList'     => $aAddressHDCst
                    );
                }
            }else{
                //เจอที่อยู่ TCNMTaxAddress_L
                $aReturn = array(
                    'tStatus'   => 'passABB',
                    'aList'     => $aAddress
                );
            }
        }else{
            //ไม่เจอ
            $aReturn    = array(
                'tStatus' => 'null'
            );
        }

        echo json_encode($aReturn);
    }

    //โหลดที่อยู่จากปุมเลือกที่อยู่ของลูกค้า
    public function FSaCTAXLoadCustomerAddress(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tCustomer          = $this->input->post('tCustomer');
        $tSeqno             = $this->input->post('tSeqno');
        $aAddressHDCst      = $this->mTaxinvoice->FSaMTAXFindAddressCst($tCustomer,$tSeqno);
        if(empty($aAddressHDCst)){
            //ไม่เจอ
            $aReturn    = array(
                'tStatus' => 'null'
            );
        }else{
            //เจอที่อยู่ TCNMCstAddress_L
            $aReturn    = array(
                'tStatus'   => 'passCst',
                'aList'     => $aAddressHDCst
            );
        }
        echo json_encode($aReturn);
    }

    //เอาเลขที่ประจำตัวผู้เสียภาษีวิ่งเข้าไปค้นหา
    public function FSaCTAXCheckTaxno(){
        $tTaxno     = $this->input->post('tTaxno');
        $nSeq       = $this->input->post('nSeq');
        $aGetTaxno  = $this->mTaxinvoice->FSaMTAXCheckTaxno($tTaxno,$nSeq);
        if(empty($aGetTaxno)){
            $aReturn = array(
                'tStatus'   => 'not found'
            );
        }else{
            $aReturn = array(
                'tStatus'   => 'found',
                'aAddress'  => $aGetTaxno
            );
        }
        echo json_encode($aReturn);
    }

    //โหลดเลขที่ประจำตัวผู้เสียภาษี
    public function FSvCTAXLoadDatatableTaxno(){
        $tSearchTaxno   = $this->input->post('tSearchTaxno');
        $nPage          = $this->input->post('nPage');
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aPackData = array(
            'tSearchTaxno'  => $tSearchTaxno,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit
        );

        $aGetTaxno    = $this->mTaxinvoice->FSaMTAXListTaxno($aPackData);
        $aDataView  = array(
            'nPage'         => $nPage,
            'aDataList'     => $aGetTaxno
        );

        $tTableTaxnoHtml  = $this->load->view('document/taxInvoice/SelectTaxno/wSelectTaxno', $aDataView, true);
        $aReturnData    = array(
            'tTableTaxnoHtml'   => $tTableTaxnoHtml
        );
        echo json_encode($aReturnData);
    }

    //โหลดที่อยู่ของลูกค้าที่เคยมีแล้วในระบบ
    public function FSvCTAXLoadDatatableCustomerAddress(){
        $tSearchAddress     = $this->input->post('tSearchAddress');
        $tCustomerCode      = $this->input->post('tCustomerCode');
        $nPage              = $this->input->post('nPage');
        $nLangEdit          = $this->session->userdata("tLangEdit");

        $aPackData = array(
            'tSearchAddress'    => $tSearchAddress,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'FNLngID'           => $nLangEdit,
            'tCustomerCode'     => $tCustomerCode
        );

        $aGetCustomer    = $this->mTaxinvoice->FSaMTAXListCustomerAddress($aPackData);
        $aDataView  = array(
            'nPage'         => $nPage,
            'aDataList'     => $aGetCustomer
        );

        $tTableCustomerAddressHtml  = $this->load->view('document/taxInvoice/SelectCustomerAddress/wSelectCustomerAddress', $aDataView, true);
        $aReturnData    = array(
            'tTableCustomerAddressHtml'   => $tTableCustomerAddressHtml
        );
        echo json_encode($aReturnData);
    }

    //อนุมัติ
    public function FSaCTAXApprove(){
        $aPackData          = $this->input->post('aPackData');
        $tType              = $this->input->post('tType');
        $tABB               = $aPackData['tDocABB'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];
        $tStaETax           = $aPackData['tStaETax'];
        $tTAXApvType        = $aPackData['tTAXApvType'];

        $aWhere = array(
            'tDocumentNumber' => $tABB,
            'tBrowseBchCode'  => $tBrowseBchCode
        );
        $aGetBCHABB = $this->mTaxinvoice->FSaMTAXGetHD($aWhere);

        //เช็ค FTXshDocVatFull ก่อนว่ามีการออกใบกำกับไปแล้วหรือยัง
        if( (isset($aGetBCHABB['raItems'][0]['FTXshDocVatFull']) && $aGetBCHABB['raItems'][0]['FTXshDocVatFull'] == '') || $tTAXApvType == '2' ){
            //วิ่งเข้าไปหาเลขที่เอกสาร ที่MQ ก่อน
            if( $tType == 'MQ' ){
                $tDocType               = ($aGetBCHABB['raItems'][0]['FNXshDocType']==9 ? 'R' : 'S');
                $tUserCode              = $this->session->userdata("tSesUserCode");
                $tCheckMQ['tQname']     = 'CN_QRetGenTaxNo_'.$aGetBCHABB['raItems'][0]['FTBchCode'].'_'.$tDocType;
                $tCheckQueue            =  FCNxRabbitMQCheckQueueMassage($tCheckMQ);
                // echo $tCheckQueue; die();
                if($tCheckQueue=='false'){
                    $aMQParams  = [
                        "queueName" => "CN_QReqGenTaxNo",
                        "params" => [
                            "ptBchCode"         => $aGetBCHABB['raItems'][0]['FTBchCode'],
                            "pnSaleType"        => $aGetBCHABB['raItems'][0]['FNXshDocType'],
                            "ptDocNo"           => $tABB,
                            "ptUser"            => ''
                        ]
                    ];

                    FCNxCallRabbitMQ($aMQParams);
                }

                $aReturnData    = array(
                    'nStaEvent'     => 1,
                    'tStaMessg'     => 'Send MQ Success.',
                    'tBCHDoc'       => $aGetBCHABB['raItems'][0]['FTBchCode']
                );
                echo json_encode($aReturnData);
            }
            //else{
            //Move จากตารางจริง ไปตาราง Tax + update ข้อมูลที่จำเป็น
            // $aPackData      = array(
            //     'tTaxNumberFull' => $aPackData['tTaxNumberFull'],
            //     'dDocDate'       => $aPackData['dDocDate'],
            //     'dDocTime'       => $aPackData['dDocTime'],
            //     'tDocABB'        => $aPackData['tDocABB'],
            //     'tCstNameABB'    => $aPackData['tCstNameABB'],
            //     'tCstCode'       => $aPackData['tCstCode'],
            //     'tCstName'       => $aPackData['tCstName'],
            //     'tTaxnumber'     => $aPackData['tTaxnumber'],
            //     'tTypeBusiness'  => $aPackData['tTypeBusiness'],
            //     'tBusiness'      => $aPackData['tBusiness'],
            //     'tBranch'        => $aPackData['tBranch'],
            //     'tTel'           => $aPackData['tTel'],
            //     'tFax'           => $aPackData['tFax'],
            //     'tAddress1'      => $aPackData['tAddress1'],
            //     'tAddress2'      => $aPackData['tAddress2'],
            //     'tReason'        => $aPackData['tReason'],
            //     'tSeqAddress'    => $aPackData['tSeqAddress'],
            //     'tStaETax'       => $tStaETax
            // );

            /////////////////////////////////// -- MOVE -- ///////////////////////////////////

        //     $this->db->trans_begin();

        //     // TPSTSalHD -> TPSTTaxHD
        //     $this->mTaxinvoice->FSaMTAXMoveSalHD_TaxHD($aPackData);

        //     // TPSTSalHDDis -> TPSTTaxHDDis
        //     $this->mTaxinvoice->FSaMTAXMoveSalHDDis_TaxHDDis($aPackData);

        //     // TPSTSalDT -> TPSTTaxDT
        //     $this->mTaxinvoice->FSaMTAXMoveSalDT_TaxDT($aPackData);

        //     // TPSTSalDTSN -> TPSTTaxDTSN
        //     $this->mTaxinvoice->FSaMTAXMoveSalDTSN_TaxDTSN($aPackData);

        //     // TPSTSalDTDis -> TPSTTaxDTDis
        //     $this->mTaxinvoice->FSaMTAXMoveSalDTDis_TaxDTDis($aPackData);

        //     // TPSTSalHDCst -> TPSTTaxHDCst
        //     $this->mTaxinvoice->FSaMTAXMoveSalHDCst_TaxHDCst($aPackData);

        //     // TPSTSalPD -> TPSTTaxPD
        //     $this->mTaxinvoice->FSaMTAXMoveSalPD_TaxPD($aPackData);

        //     // TPSTSalRC -> TPSTTaxRC
        //     $this->mTaxinvoice->FSaMTAXMoveSalRC_TaxRC($aPackData);

        //     // TPSTSalRD -> TPSTTaxRD
        //     $this->mTaxinvoice->FSaMTAXMoveSalRD_TaxRD($aPackData);

        //     ///////////////////////////// -- INSERT UPDATE -- /////////////////////////////

        //     //Update FTXshDocVatFull  + ว่าเอกสารนี้ถูกใช้งานเเล้ว
        //     $this->mTaxinvoice->FSaMTAXUpdateDocVatFull($aPackData);

        //     //Insert ลงตารางที่อยู่
        //     $this->mTaxinvoice->FSaMTAXInsertTaxAddress($aPackData);

        //     // TPSTTaxHDCst อัพเดทข้อมูลที่อยู่จากหน้าจอ
        //     // $this->mTaxinvoice->FSaMTAXUpdAddrTaxHDCst($aPackData);

        //     if($this->db->trans_status() === FALSE){
        //         $this->db->trans_rollback();
        //         $tStatus    = 500;
        //         $tStaMessg  = 'Not Success';
        //     }else{
        //         $this->db->trans_commit();
        //         $tStatus    = 1;
        //         $tStaMessg  = 'Success';

        //         if( $tStaETax == '1' ){
        //             $tABBDocType = $aGetBCHABB['raItems'][0]['FNXshDocType'];

        //             if( $tABBDocType == '1' ){  // ABB
        //                 $tFullTaxDocType = '2';
        //             }else{                      // CN-ABB
        //                 $tFullTaxDocType = '4';
        //             }

        //             // Send MQ FULL TAX
        //             $aMQParamsFullTax = [
        //                 "queueName" => "EX_TxnSaleETax",
        //                 "params" => [
        //                     "ptFunction"    => "SaleRef",
        //                     "ptSource"      => "AdaStoreBack",
        //                     "ptDest"        => "MQAdaLink",
        //                     "ptData"        => json_encode([
        //                         "ptProvider"    => "1",
        //                         "ptUserCode"    => $this->session->userdata("tSesUserCode"), // User Login
        //                         "ptBchCode"     => $aPackData['tBranch'],
        //                         "ptPosCode"     => $aPackData['tPosCode'],
        //                         "ptDocType"     => $tFullTaxDocType,
        //                         "ptDocNo"       => $aPackData['tTaxNumberFull'],
        //                         "ptRefDocType"  => "",
        //                         "ptDocRef"      => ""
        //                     ])
        //                 ]
        //             ];
        //             $aRabbitMQ = FCNaRabbitMQInterface($aMQParamsFullTax);
        //             if( $aRabbitMQ['nStaEvent'] != '1' ){
        //                 echo json_encode($aRabbitMQ);
        //                 return;
        //             }
        //         }

        //     }
        //     //Delete คิวทุกครั้งที่ใช้เสร็จ
        //     // $tUserCode      = $this->session->userdata("tSesUserCode");
        //     $tDocType = ($aGetBCHABB['raItems'][0]['FNXshDocType']==9 ? 'R' : 'S');
        //     $tQueueName     = 'CN_QRetGenTaxNo_'.$aGetBCHABB['raItems'][0]['FTBchCode'].'_'.$tDocType;
        //     // $oConnection    = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
        //     // $oChannel       = $oConnection->channel();
        //     // $oChannel->queue_delete($tQueueName);
        //     // $oChannel->close();
        //     // $oConnection->close();
        //     // echo $tQueueName;

        //     $aDataReturn    = array(
        //         'nStaEvent'     => $tStatus,
        //         'tStaMessg'     => $tStaMessg,
        //         'tQueueName'    => $tQueueName
        //     );

        //     echo json_encode($aDataReturn);
        //   }

        }else{
            $tStaMessg  = 'Not Success';
            $aDataReturn    = array(
                'nStaEvent'     => 550,
                'tStaMessg'     => $tStaMessg
            );
            echo json_encode($aDataReturn);
        }
    }

    //โหลดข้อมูล HD + Address
    public function FSvCTAXLoadDatatableTax(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tBrowseBchCode    = $this->input->post('tBrowseBchCode');
        $aWhere = array(
            'tDocumentNumber' => $tDocumentNumber,
            'tBrowseBchCode'  => $tBrowseBchCode,
            'FNLngID'         => $this->session->userdata("tLangEdit")
        );

        $aGetHD         = $this->mTaxinvoice->FSaMTAXGetHDTax($aWhere);
        $aDataDocRC     = $this->mTaxinvoice->FSaMTAXGetRCTax($aWhere,'FULLTAX');
        $aAddress       = $this->mTaxinvoice->FSaMTAXGetAddressTax($aWhere);
        $aPackData  = array(
            'aGetHD'        => $aGetHD,
            'aAddress'      => $aAddress
        );
        $aReturnData = array(
            'tContentSumFooter'   => $this->load->view('document/taxInvoice/wTaxInvoiceSumFooter',$aPackData, true),
            'aDetailHD'           => $aGetHD,
            'aDataDocRC'          => $aDataDocRC,
            'aDetailAddress'      => $aAddress,
            'aDataDisPro'         => $this->mTaxinvoice->FSaMTAXEventGetDataDisPromotions($aWhere,'FULLTAX'), // Get Data Discount Promotions
            'aDataEndBillVat'     => $this->mTaxinvoice->FSaMTAXEventGetDataEndBillVat($aWhere,'FULLTAX') // Get Data End Bill Vat
        );
        echo json_encode($aReturnData);
    }

    //โหลดข้อมูล DT
    public function FSvCTAXLoadDatatableDTTax(){
        $tDocumentNumber    = $this->input->post('tDocumentNumber');
        $tBrowseBchCode     = $this->input->post('tBrowseBchCode');
        $tSearchPDT         = $this->input->post('tSearchPDT');
        $nPage              = $this->input->post('nPage');

        $aWhere = array(
            'tDocumentNumber' => $tDocumentNumber,
            'tBrowseBchCode' => $tBrowseBchCode,
            'tSearchPDT'      => $tSearchPDT,
            'nRow'            => 10,
            'nPage'           => $nPage
        );

        $aGetDT     = $this->mTaxinvoice->FSaMTAXGetDTInTax($aWhere);
        $aPackData  = array(
            'nPage'         => $nPage,
            'aGetDT'        => $aGetDT,
            'tTypePage'     => 'Preview'
        );
        $aReturnData = array(
            'tContentPDT'         => $this->load->view('document/taxInvoice/wTaxInvoiceDatatable',$aPackData, true),
        );
        echo json_encode($aReturnData);
    }

    //Update หลังจากอนุมัติไปแล้ว แล้วอัพเดทที่อยู่อีกครั้ง
    public function FSxCTAXUpdateWhenApprove(){
        $tDocumentNo    = $this->input->post('tDocumentNo');
        $tBrowseBchCode = $this->input->post('tBrowseBchCode');
        $tCusNameABB    = $this->input->post('tCusNameABB');
        $tTel           = $this->input->post('tTel');
        $tFax           = $this->input->post('tFax');
        $tAddress1      = $this->input->post('tAddress1');
        $tAddress2      = $this->input->post('tAddress2');
        $tSeq           = $this->input->post('tSeq');
        $tSeqNew        = $this->input->post('tSeqNew');
        $tNumberTax     = $this->input->post('tNumberTax');
        $tNumberTaxNew  = $this->input->post('tNumberTaxNew');
        $tBchCode       = $this->input->post('tBchCode');
        $tCstCode       = $this->input->post('tCstCode');
        $tCstName       = $this->input->post('tCstName');

        $aWhere  = array(
            'FNAddSeqNo' => $tSeq
        );

        $aSet  = array(
            'FTAddName'     => $tCusNameABB,
            'FTAddTel'      => $tTel,
            'FTAddFax'      => $tFax,
            'FTAddV2Desc1'  => $tAddress1,
            'FTAddV2Desc2'  => $tAddress2,
            'tNumberTax'    => $tNumberTax,
            'tNumberTaxNew' => $tNumberTaxNew,
            'tDocumentNo'   => $tDocumentNo,
            'tBrowseBchCode' => $tBrowseBchCode,
            'tTypeBusiness' => $this->input->post('tTypeBusiness'),
            'tBusiness'     => $this->input->post('tBusiness'),
            'tBchCode'      => $tBchCode,
            'tCstCode'      => $tCstCode,
            'tCstName'      => $tCstName
        );

        //อัพเดทที่อยู่แบบปกติ
        // $this->mTaxinvoice->FSaMTAXUpdateWhenApprove($aWhere,$aSet,'UPDATEADDRESS');

        //มีการเปลี่ยนเลขที่ประจำตัวผู้เสียภาษี
        // echo $tSeqNew . '-' . $tSeq . '///' . $tNumberTaxNew . '-' . $tNumberTax;

        // if($tSeqNew != $tSeq || $tNumberTaxNew != $tNumberTax ){
            $this->mTaxinvoice->FSaMTAXUpdateWhenApprove($aWhere,$aSet,'UPDATEHDCST');
        // }

    }


    //กรณีไม่สารถ GetMassage ได้จาก Stomp ให้ไปหาเองจาก TPSTTaxNo ล่าสุด
    public function FSxCTAXCallTaxNoLastDoc(){

        $aPackData          = $this->input->post('aPackData');
        $tABB               = $aPackData['tDocABB'];
        $tBrowseBchCode     = $aPackData['tBrowseBchCode'];

        // print_r($aPackData);exit;

        $aWhere = array(
            'tDocumentNumber' => $tABB,
            'tBrowseBchCode'  => $tBrowseBchCode
        );
        $aGetBCHABB = $this->mTaxinvoice->FSaMTAXGetHD($aWhere);
        // $tBchCode         = $aGetBCHABB['raItems'][0]['FTBchCode'];
        // $nSaleType        = $aGetBCHABB['raItems'][0]['FNXshDocType'];

        // if($nSaleType == 9){
        //     $nDocType = 5;
        // }else{
        //     $nDocType = 4;
        // }

        // $aParamData  = array(
        //     'tBchCode' => $tBchCode ,
        //     'nDocType' => $nDocType,
        //     'tDocABB'  => $aPackData['tDocABB']
        // );
        $tUserCode          = $this->session->userdata("tSesUserCode");
        $tDocType           = ($aGetBCHABB['raItems'][0]['FNXshDocType']==9 ? 'R' : 'S');
        $aParamQ['tQname']  = 'CN_QRetGenTaxNo_'.$aGetBCHABB['raItems'][0]['FTBchCode'].'_'.$tDocType;
        $tTaxJsonString     = FCNxRabbitMQGetMassage($aParamQ);

        // echo "<pre>";
        // print_r($aGetBCHABB['raItems']); 
        // print_r($tTaxJsonString); 
        
        

        // $tTaxNumberFull = $this->mTaxinvoice->FSaMTAXCallTaxNoLastDoc($aParamData);
        // $nResult    = $this->mTaxinvoice->FSnMTAXCheckDuplicationOnTaxHD($tTaxNumberFull);
        //หากไม่มีเลข Tax นี้ทำการ บันทึกออกใบกำกับตามปกติ
        if( $tTaxJsonString != 'false' ){
            $aTaxJsonString =  json_decode($tTaxJsonString);
            // echo "<pre>";
            // print_r($aTaxJsonString);
            $tTaxNumberFull = $aTaxJsonString->rtDocNo;
            $tBCHCode       = $aGetBCHABB['raItems'][0]['FTBchCode'];
            $nResult        = $this->mTaxinvoice->FSnMTAXCheckDuplicationOnTaxHD($tTaxNumberFull,$tBCHCode);
            // echo $nResult;
            // exit;
            if( $nResult == 0 ){
                //Move จากตารางจริง ไปตาราง Tax + update ข้อมูลที่จำเป็น
                $aPackData['tTaxNumberFull'] = $tTaxNumberFull;
                // $aPackData      = array(
                //     'tTaxNumberFull' => $tTaxNumberFull,
                //     'dDocDate'       => $aPackData['dDocDate'],
                //     'dDocTime'       => $aPackData['dDocTime'],
                //     'tDocABB'        => $aPackData['tDocABB'],
                //     'tCstNameABB'    => $aPackData['tCstNameABB'],
                //     'tCstCode'       => $aPackData['tCstCode'],
                //     'tCstName'       => $aPackData['tCstName'],
                //     'tTaxnumber'     => $aPackData['tTaxnumber'],
                //     'tTypeBusiness'  => $aPackData['tTypeBusiness'],
                //     'tBusiness'      => $aPackData['tBusiness'],
                //     'tBranch'        => $aPackData['tBranch'],
                //     'tTel'           => $aPackData['tTel'],
                //     'tFax'           => $aPackData['tFax'],
                //     'tAddress1'      => $aPackData['tAddress1'],
                //     'tAddress2'      => $aPackData['tAddress2'],
                //     'tReason'        => $aPackData['tReason'],
                //     'tSeqAddress'    => $aPackData['tSeqAddress'],
                //     'tStaETax'       => $aPackData['tStaETax'],
                //     'tPosCode'       => $aPackData['tPosCode']
                // );

                /////////////////////////////////// -- MOVE -- ///////////////////////////////////

                $this->db->trans_begin();

                // TPSTSalHD -> TPSTTaxHD
                $this->mTaxinvoice->FSaMTAXMoveSalHD_TaxHD($aPackData);

                // TPSTSalHDDis -> TPSTTaxHDDis
                $this->mTaxinvoice->FSaMTAXMoveSalHDDis_TaxHDDis($aPackData);

                // TPSTSalDT -> TPSTTaxDT
                $this->mTaxinvoice->FSaMTAXMoveSalDT_TaxDT($aPackData);

                // TPSTSalDTSN -> TPSTTaxDTSN
                $this->mTaxinvoice->FSaMTAXMoveSalDTSN_TaxDTSN($aPackData);

                // TPSTSalDTDis -> TPSTTaxDTDis
                $this->mTaxinvoice->FSaMTAXMoveSalDTDis_TaxDTDis($aPackData);

                // TPSTSalHDCst -> TPSTTaxHDCst
                $this->mTaxinvoice->FSaMTAXMoveSalHDCst_TaxHDCst($aPackData);

                // TPSTSalPD -> TPSTTaxPD
                $this->mTaxinvoice->FSaMTAXMoveSalPD_TaxPD($aPackData);

                // TPSTSalRC -> TPSTTaxRC
                $this->mTaxinvoice->FSaMTAXMoveSalRC_TaxRC($aPackData);

                // TPSTSalRD -> TPSTTaxRD
                $this->mTaxinvoice->FSaMTAXMoveSalRD_TaxRD($aPackData);

                ///////////////////////////// -- INSERT UPDATE -- /////////////////////////////

                
                //Update FTXshDocVatFull  + ว่าเอกสารนี้ถูกใช้งานเเล้ว
                $this->mTaxinvoice->FSaMTAXUpdateDocVatFull($aPackData);

                //Insert ลงตารางที่อยู่
                $this->mTaxinvoice->FSaMTAXInsertTaxAddress($aPackData);

                if( $aPackData['tTAXApvType'] == '2' ){ // ทำใบยกเลิกเอกสาร
                    
                    switch($tDocType){
                        case 'R': // CN-FullTax
                            $this->mTaxinvoice->FSxMTAXUpdAddrCNFullTax($aPackData);
                            break;
                        case 'S':
                            $this->mTaxinvoice->FSxMTAXUpdAddrABBFullTax($aPackData);
                            break;
                    }

                    //Update RefInt + RefAE
                    $this->mTaxinvoice->FSxMTAXUpdateReference($aPackData);

                }

                // TPSTTaxHDCst อัพเดทข้อมูลที่อยู่จากหน้าจอ
                // $this->mTaxinvoice->FSaMTAXUpdAddrTaxHDCst($aPackData);

                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $tStatus    = 500;
                    $tStaMessg  = 'Not Success';
                }else{
                    $this->db->trans_commit();
                    $tStatus    = 1;
                    $tStaMessg  = 'Success';
                }

                //Delete คิวทุกครั้งที่ใช้เสร็จ
                // $tUserCode      = $this->session->userdata("tSesUserCode");
                $tQueueName     = 'CN_QRetGenTaxNo_'.$aGetBCHABB['raItems'][0]['FTBchCode'].'_'.$tDocType;
                // $oConnection    = new AMQPStreamConnection(HOST, PORT, USER, PASS, VHOST);
                // $oChannel       = $oConnection->channel();
                // $oChannel->queue_delete($tQueueName);
                // $oChannel->close();
                // $oConnection->close();
                // echo $tQueueName;

                $tStaETax = $aPackData['tStaETax'];
                if( $tStaETax == '1' ){
                    $aPackDataMQ = array(
                        'tAbbDocNo' => $aPackData['tDocABB'],
                        'tTaxDocNo' => $aPackData['tTaxNumberFull'],
                        'tBchCode'  => $aPackData['tBrowseBchCode'],
                        'tPosCode'  => $aPackData['tPosCode'],
                        'tDocType'  => $aGetBCHABB['raItems'][0]['FNXshDocType']
                    );
                    $aRabbitMQ = $this->FSaCTAXEventSendMQETax($aPackDataMQ);

                    if( $aRabbitMQ['nStaEvent'] != '1' ){
                        echo json_encode($aRabbitMQ);
                        return;
                    }
                }

                $aDataReturn    = array(
                    'nStaEvent'     => $tStatus,
                    'tStaMessg'     => $tStaMessg,
                    'tQueueName'    => $tQueueName,
                    'tTaxNumberFull' => $tTaxNumberFull
                );

                echo json_encode($aDataReturn);
            }else{

                $tUserCode      = $this->session->userdata("tSesUserCode");
                $tDocType = ($aGetBCHABB['raItems'][0]['FNXshDocType']==9 ? 'R' : 'S');
                $tCheckMQ['tQname']     = 'CN_QRetGenTaxNo_'.$aGetBCHABB['raItems'][0]['FTBchCode'].'_'.$tDocType;
                $tCheckQueue =  FCNxRabbitMQCheckQueueMassage($tCheckMQ);

                if($tCheckQueue=='false'){
                    $aMQParams  = [
                        "queueName" => "CN_QReqGenTaxNo",
                        "params" => [
                            "ptBchCode"         => $aGetBCHABB['raItems'][0]['FTBchCode'],
                            "pnSaleType"        => $aGetBCHABB['raItems'][0]['FNXshDocType'],
                            "ptDocNo"           => $tABB,
                            "ptUser"            => ''
                        ]
                    ];
                }

                $aDataReturn    = array(
                    'nStaEvent'     => '800',
                    'tStaMessg'     => 'กำลังหาเลขที่เอกสารใหม่อีกครั้ง',
                    'tBCHDoc'      => $aGetBCHABB['raItems'][0]['FTBchCode']
                );
                echo json_encode($aDataReturn);
            }
        }else{
            $aDataReturn    = array(
                'nStaEvent'     => '800',
                'tStaMessg'     => 'กำลังหาเลขที่เอกสารใหม่อีกครั้ง',
                'tBCHDoc'       => $aGetBCHABB['raItems'][0]['FTBchCode']
            );
            echo json_encode($aDataReturn);
        }
    }

    //หาที่อยู่ของใบกำกับภาษีในสาขา
    public function FSxCTAXCheckBranchInComp(){
 
        $tBCHCode = $this->input->post('tBCH');

        $aReturnData = array(
            'tBCH'   => FCNtGetAddressBranch($tBCHCode)
        );
        echo json_encode($aReturnData);
    }

    // Call API Get Link Download Tax ABB
    // public function FSaCTAXEventDownloadETax(){

    //     $tTaxDocNo = $this->input->post('ptTaxDocNo');
    //     $tTypeTax  = $this->input->post('ptTypeTax');

    //     echo FCNaCallApiETAX($tTaxDocNo,$tTypeTax);
    // }

    // Create By: Napat(Jame) 04/08/2021
    // Last Update : Napat(Jame) 16/09/2021
    public function FSaCTAXEventApvETax(){
        $tABBDocNo          = $this->input->post('ptABBDocNo');
        $tTaxDocNo          = $this->input->post('ptTaxDocNo');
        $tPosCode           = $this->input->post('ptPosCode');
        $tBchCode           = $this->input->post('ptBchCode');
        $tDocType           = $this->input->post('ptDocType');
        $aDataHDAddress     = $this->input->post('paDataHDAddress');
        $aDataHDCst         = $this->input->post('paDataHDCst');

        // Where Condition
        $aWhereCondition = array(
            'FTBchCode'     => $tBchCode,
            'FTXshDocNo'    => $tTaxDocNo
        );

        // Update Address
        $this->mTaxinvoice->FSxMTAXUpdAddrAndCst($aDataHDAddress,$aDataHDCst,$aWhereCondition);

        $aPackDataMQ = array(
            'tAbbDocNo' => $tABBDocNo,
            'tTaxDocNo' => $tTaxDocNo,
            'tBchCode'  => $tBchCode,
            'tPosCode'  => $tPosCode,
            'tDocType'  => $tDocType
        );
        $aRabbitMQ = $this->FSaCTAXEventSendMQETax($aPackDataMQ);
        echo json_encode($aRabbitMQ);

    }

    // Create By: Napat(Jame) 16/09/2021
    // ส่ง MQ ETax
    public function FSaCTAXEventSendMQETax($paPackDataMQ){

        $tABBDocNo          = $paPackDataMQ['tAbbDocNo'];
        $tTaxDocNo          = $paPackDataMQ['tTaxDocNo'];
        $tPosCode           = $paPackDataMQ['tPosCode'];
        $tBchCode           = $paPackDataMQ['tBchCode'];
        $tDocType           = $paPackDataMQ['tDocType'];

        // Convert Document Type
        if( $tDocType == '1' || $tDocType == '4' ){        // เอกสารขาย 1,4
            $tABBDocType        = "1"; // ABB
            $tFullTaxDocType    = "2"; // FullTax
        }else{                                              // เอกสารคืน 5,9
            $tABBDocType        = "3"; // CN
            $tFullTaxDocType    = "4"; // CN-FullTax
        }

        // Where Condition ABB
        $aWhereABB = array(
            'FTBchCode'     => $tBchCode,
            'FTXshDocNo'    => $tABBDocNo
        );
        $bChkStaABB = $this->mTaxinvoice->FSbMTAXChkStaABBETaxApv($aWhereABB);

        // ถ้า ABB ส่ง iNet ไม่สำเร็จ ให้ส่งอีกรอบ
        if( $bChkStaABB ){
            // Send MQ ABB
            $aMQParams = [
                "queueName" => "EX_TxnSaleETax",
                "params" => [
                    "ptFunction"    => "SaleRef",
                    "ptSource"      => "AdaStoreBack",
                    "ptDest"        => "MQAdaLink",
                    "ptData"        => json_encode([
                        "ptProvider"    => "1",
                        "ptUserCode"    => $this->session->userdata("tSesUserCode"), // User Login
                        "ptBchCode"     => $tBchCode,
                        "ptPosCode"     => $tPosCode,
                        "ptDocType"     => $tABBDocType,
                        "ptDocNo"       => $tABBDocNo,
                        "ptRefDocType"  => "",
                        "ptDocRef"      => ""
                    ])
                ]
            ];
            FCNaRabbitMQInterface($aMQParams);
        }

        // Send MQ FULL TAX
        $aMQParamsFullTax = [
            "queueName" => "EX_TxnSaleETax",
            "params" => [
                "ptFunction"    => "SaleRef",
                "ptSource"      => "AdaStoreBack",
                "ptDest"        => "MQAdaLink",
                "ptData"        => json_encode([
                    "ptProvider"    => "1",
                    "ptUserCode"    => $this->session->userdata("tSesUserCode"), // User Login
                    "ptBchCode"     => $tBchCode,
                    "ptPosCode"     => $tPosCode,
                    "ptDocType"     => $tFullTaxDocType,
                    "ptDocNo"       => $tTaxDocNo,
                    "ptRefDocType"  => "",
                    "ptDocRef"      => ""
                ])
            ]
        ];
        return FCNaRabbitMQInterface($aMQParamsFullTax);
    }
    

}
