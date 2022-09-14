<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cTransferreceipt extends MX_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper("file");
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/transferreceipt/mTransferreceipt');
    }

    public function index($nBrowseType, $tBrowseOption, $tDocType)
    {

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
        $aData['tDocType']          = $tDocType;
        $aData['aAlwEvent']         = FCNaHCheckAlwFunc('dcmTXI/0/0/' . $tDocType); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('dcmTXI/0/0/' . $tDocType); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        //Get Option Show Decimal
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow();
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave();

        //รายงานว่ามาจากรายงานอะไร?  1.WAH 2.BCH


        $this->load->view('document/transferreceipt/wTransferreceipt', $aData);
    }

    /* Browse PDT TXI */

    public function FSvCTXIBrowseDataTXIPDTTable(){

        $nPage      = $this->input->post('nPage');
        $nRow       = $this->input->post('nRow');
        $tNamePDT   = $this->input->post('tNamePDT');
        $tCodePDT   = $this->input->post('tCodePDT');
        $tBarcode   = $this->input->post('tBarcode');
        $tBCH       = $this->input->post('tBCH');
        $tMerchant  = $this->input->post('tMerchant');
        $aSHP       = $this->input->post('tSHP');
        $tRefInt    = $this->input->post('tRefInt');
        $tViaCode   = $this->input->post('tViaCode');


        $aDataSearch = array(
            'nPage'                 => $nPage,
            'nRow'                  => $nRow,
            'tNamePDT'              => $tNamePDT,
            'tCodePDT'              => $tCodePDT,
            'tBarcode'              => $tBarcode,
            'tBCH'                  => $tBCH,
            'tMerchant'             => $tMerchant,
            'aSHP'                  => $aSHP,
            'tRefInt'               => $tRefInt,
            'tViaCode'              => $tViaCode,
            'FNLngID'               => $this->session->userdata("tLangEdit"),
            'FTXthDocKey'           => 'TCNTPdtTwiHD',
            'tSesSessionID'         => $this->session->userdata('tSesSessionID'),
            'tSesUsername'          => $this->session->userdata('tSesUsername')
        );

        // echo "<pre>";
        // print_r($aDataSearch);

        $aProduct  = $this->mTransferreceipt->FSnMTXIModalGetProduct($aDataSearch);
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        // echo "<pre>";
        // print_r($aProduct);

        $aDataHTML  = array(
            'nPage'             => $this->input->post("nPage"),
            'nOptDecimalShow'   => $nOptDecimalShow,
            'aProduct'          => $aProduct
        );

        $this->load->view('document/transferreceipt/browseproduct/wBrowsePDTTable', $aDataHTML);

    }


    function FSvCTXIBrowseDataPDT(){

        
        $tRefInt        = $this->input->post('tRefInt');
        $nFromToBCH     = $this->input->post('FromToBCH');
        $nFromToBCHName = $this->input->post('FromToBCHName');
        $nFromToSHP     = $this->input->post('FromToSHP');
        $nFromToSHPName = $this->input->post('FromToSHPName');
        $tViaCode       = $this->input->post('tViaCode');
        
        $nShowCountRecord   = $this->input->post('nShowCountRecord');
        $tNextFunc          = $this->input->post('NextFunc');
        
        $aFromControl = array(
            'tRefInt'           => $tRefInt,
            'nFromToBCH'        => $nFromToBCH,
            'nFromToBCHName'    => $nFromToBCHName,
            'nFromToSHP'        => $nFromToSHP,
            'nFromToSHPName'    => $nFromToSHPName,
            'tViaCode'          => $tViaCode,
            'nShowCountRecord'  => $nShowCountRecord,
            'tNextFunc'         => $tNextFunc
        );

        $this->load->view('document/transferreceipt/browseproduct/wBrwProduct', $aFromControl);

    }

    /* Browse PDT TXI */


    public function FSvCTXIGetDataRefInt()
    {

        $tTXIDocType    = $this->input->post("tTXIDocType");
        $tXthDocNo      = $this->input->post("tXthDocNo");
        $tTXODocNo      = $this->input->post("tTXODocNo");

        if ($tTXIDocType == "WAH") {
            $tTblSelectData = "TCNTPdtTwoHD";
        } else {
            $tTblSelectData = "TCNTPdtTboHD";
        }

        $aDataWhere = array(
            'tTblSelectData'    => $tTblSelectData,
            'tXthDocNo'         => $tXthDocNo,
            'tTXODocNo'         => $tTXODocNo,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
            'FNLngID'           => $this->session->userdata("tLangEdit")
        );

        //Get Data TWO
        $aDataRefInt =   $this->mTransferreceipt->FSaMTWIGetDataRefInt($aDataWhere);

        //Get Data Table IntDT
        $aDataInTDT =   $this->mTransferreceipt->FSaMTWIGetTWODataIntDTInDTTmp($aDataWhere);

        echo json_encode($aDataRefInt);
    }


    public function FSvCTXICalculateLastBill()
    {

        // $aDTValue['FTBchCode']
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthVATInOrEx  = $this->input->post('tXthVATInOrEx');

        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthDocKey'   => 'TCNTPdtTwiHD',
        );

        //Get Option Save Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $aDataDTTmp =   $this->mTransferreceipt->FSaMTXIGetDTTemp($aDataWhere);

        $FCXthTotal = 0;

        if ($aDataDTTmp['rtCode'] == 1) {

            $aDataDTTmp = $aDataDTTmp['raItems'];
            foreach ($aDataDTTmp as $key => $value) {
                //รวมใน 
                if ($tXthVATInOrEx == 1) {
                    $FCXthTotal += $value['FCXtdVat'] + $value['FCXtdVatable'];
                } else {
                    //แยกนอก
                    $FCXthTotal += $value['FCXtdVat'];
                }
            }

            $tXphGndText  = number_format($FCXthTotal, $nOptDecimalShow, '.', ',');
            $tXphGndText = FCNtNumberToTextBaht($tXphGndText);

            $aData = array(
                'tXphGndText'   => $tXphGndText,
                'FCXthTotal'     => number_format($FCXthTotal, $nOptDecimalShow, '.', ',')
            );
        } else {

            $aData = array(
                'tXphGndText'   => '-',
                'FCXthTotal'     => number_format($FCXthTotal, $nOptDecimalShow, '.', ',')
            );
        }

        echo json_encode($aData);
    }

    //Function : คำนวนลดท้าบบิล HD ถ้ามีท้ายบอลจะ Add ลงตาราง DT FNXpdStaDis 2
    public function FCNoTWIAdjDTDisAFTAdjHDDis($ptXthDocNo)
    {

        //Get Data From File
        $aDataFile = $this->FMaTWIGetDataFormFile($ptXthDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave();

        $cXpdNetSUM = 0;
        $cXpdDisChgAvi = 0;

        if (FCNnHSizeOf($aDataFile['DTData']) > 0) {
            //Get  หา Sum FCXpdNet
            foreach ($aDataFile['DTData'] as $DTkey => $aDTValue) {
                //สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                if ($aDTValue['FTXpdStaAlwDis'] == 1) {
                    $cXpdNetSUM = $cXpdNetSUM + $aDTValue['FCXpdNet'];
                    //Remove FNXpdStaDis 2 ออก
                    foreach ($aDTValue['DTDiscount'] as $DTDisKey => $DTDisValue) {
                        //สั่งลบ FNXpdStaDis == 2 เพราะ จะ get ใหม่ ไม่งั้นจะ ทับกัน
                        if ($DTDisValue['FNXpdStaDis'] == 2) {
                            //สั่งลบ
                            unset($aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDisKey]);
                        }
                    }
                }
            }
        }

        if (FCNnHSizeOf($aDataFile['HDData']) > 0) {
            foreach ($aDataFile['HDData'] as $HDDiskey => $HDDisValue) {
                //Set Variable
                $i = 0;
                $len = FCNnHSizeOf($aDataFile['DTData']);
                $cXddDis_Sta2 = 0;
                $cXddChg_Sta2 = 0;
                $cXddDis_Sta2SUM = 0;
                $cXddChg_Sta2SUM = 0;

                //คำนวน ท้ายบิล โปรเลท ให้ DTDis
                if (FCNnHSizeOf($aDataFile['DTData']) > 0) {
                    foreach ($aDataFile['DTData'] as $DTkey => $aDTValue) {
                        //Check สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                        if ($aDTValue['FTXpdStaAlwDis'] == 1) {

                            if ($i != $len - 1) {
                                // first
                                if ($HDDisValue['FCXthDis'] > 0) {
                                    //ถ้าเป็น Dis
                                    $A = $HDDisValue['FCXthDis'] * $aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if ($A == 0 && $B == 0) {
                                        $cXddDis_Sta2 = 0;
                                    } else {
                                        $cXddDis_Sta2 = ($HDDisValue['FCXthDis'] * $aDTValue['FCXpdNet']) / $cXpdNetSUM;
                                    }
                                    $cXddChg_Sta2 = 0;

                                    $cXddDis_Sta2SUM = number_format($cXddDis_Sta2SUM + $cXddDis_Sta2, $nOptDecimalSave, '.', '');
                                } else {
                                    //ถ้าเป็น Chg
                                    $A = $HDDisValue['FCXthChg'] * $aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if ($A == 0 && $B == 0) {
                                        $cXddChg_Sta2 = 0;
                                    } else {
                                        $cXddChg_Sta2 = ($HDDisValue['FCXthChg'] * $aDTValue['FCXpdNet']) / $cXpdNetSUM;
                                    }
                                    $cXddDis_Sta2 = 0;

                                    $cXddChg_Sta2SUM = number_format($cXddChg_Sta2SUM + $cXddChg_Sta2, $nOptDecimalSave, '.', '');
                                }
                            } else if ($i == $len - 1) {
                                // last
                                if ($HDDisValue['FCXthDis'] > 0) {
                                    //ถ้าเป็น Dis
                                    $cXddDis_Sta2 = $HDDisValue['FCXthDis'] - $cXddDis_Sta2SUM;
                                    $cXddChg_Sta2 = 0;
                                } else {
                                    //ถ้าเป็น Chg
                                    $cXddDis_Sta2 = 0;
                                    $cXddChg_Sta2 = $HDDisValue['FCXthChg'] - $cXddChg_Sta2SUM;
                                }
                            }

                            $cXddDis_Sta2 = number_format($cXddDis_Sta2, $nOptDecimalSave, '.', '');
                            $cXddChg_Sta2 = number_format($cXddChg_Sta2, $nOptDecimalSave, '.', '');

                            $aDataSta2 = array(
                                'FTBchCode'         => $aDTValue['FTBchCode'],
                                'FTXthDocNo'        => $aDTValue['FTXthDocNo'],
                                'FNXpdSeqNo'        => $aDTValue['FNXpdSeqNo'],
                                'FDXddDateIns'      => $HDDisValue['FDXthDateIns'],
                                'FNXpdStaDis'       => 2, //ลดท้ายบิล จะเป็น 2 
                                'FCXddDisChgAvi'    => '0', //ยังไม่ปรับ -> ปรับ foreach ข้างล่าง
                                'FTXddDisChgTxt'    => $HDDisValue['FTXthDisChgTxt'],
                                'FCXddDis'          => $cXddDis_Sta2,
                                'FCXddChg'          => $cXddChg_Sta2,
                                'FTXddUsrApv'       => $this->session->userdata('tSesUsername'),
                            );
                            // ADD Sta 2 ลดท้ายบิล
                            array_push($aDataFile['DTData'][$DTkey]['DTDiscount'], $aDataSta2);

                            $i++;
                        }
                    }
                }
            }
        }


        //ปรับ FCXddDisChgAvi โดยการคำนวนใหม่
        if (FCNnHSizeOf($aDataFile['DTData']) > 0) {
            foreach ($aDataFile['DTData'] as $DTkey => $aDTValue) {
                //Check สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                if ($aDTValue['FTXpdStaAlwDis'] == 1) {
                    //มูลค่าลดได้  กรณีอนุญาตลด (Qty*SetPrice) ไม่อนุญาต เป็น 0 (ปรับเมื่อมีการลดชาร์จ DT/HD)
                    $cXpdDisChgAvi = $aDTValue['FCXpdQty'] * $aDTValue['FCXpdSetPrice'];

                    foreach ($aDTValue['DTDiscount'] as $DTDiskey => $DTDisValue) {

                        $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddDisChgAvi'] = $cXpdDisChgAvi;

                        //เปลี่ยนค่าใหม่ หลัวจากคำนวน 
                        // ลด DTDis
                        if ($DTDisValue['FNXpdStaDis'] == 1) {
                            //ส่งไปคำนวน Dis , Chg ใหม่
                            $aResCalDisChgTxt = $this->FMcCTXICalulateDisChgText($DTDisValue['FTXddDisChgTxt'], $cXpdDisChgAvi);
                            $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddDis'] = $aResCalDisChgTxt['CALFCXddDis'];
                            $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddChg'] = $aResCalDisChgTxt['CALFCXddChg'];

                            // //set ค่าทับ ยอดลดได้ ก่อนลด (DT.FCXpdDisChgAvi)
                            if ($aResCalDisChgTxt['CALFCXddDis'] > 0) {
                                $cXpdDisChgAvi = $cXpdDisChgAvi - $aResCalDisChgTxt['CALFCXddDis'];
                            } else {
                                $cXpdDisChgAvi = $cXpdDisChgAvi + $aResCalDisChgTxt['CALFCXddChg'];
                            }
                        } else {
                            // ลด HDDis 
                            if ($DTDisValue['FCXddDis'] > 0) {
                                $cXpdDisChgAvi = $cXpdDisChgAvi - $DTDisValue['FCXddDis'];
                            } else {
                                $cXpdDisChgAvi = $cXpdDisChgAvi + $DTDisValue['FCXddChg'];
                            }
                        }
                    }
                }
            }
        }


        $jDataArray = json_encode($aDataFile);
        if ($ptXthDocNo != '') {
            $fp = fopen(APPPATH . "modules\document\document\\" . $ptXthDocNo . "-" . $this->session->userdata('tSesUsername') . ".txt", "r+");
            file_put_contents(APPPATH . "modules\document\document\\" . $ptXthDocNo . "-" . $this->session->userdata('tSesUsername') . ".txt", $jDataArray);
            fclose($fp);
            return 1;
        }
    }

    //Function : ปรับ DisChg Text 
    public function FMcCTXICalulateDisChgText($ptDisChgText, $ptDisChgAvi)
    {

        if ($ptDisChgText != '') {
            $nLen  = strlen($ptDisChgText);

            $tStrlast = substr($ptDisChgText, $nLen - 1);
            $tStr1    = $ptDisChgText[0];

            if ($tStrlast != '%') {

                if ($tStr1 != '+') {
                    //ลด
                    $nCalucateDis = $ptDisChgText;
                    $nCalucateChg = 0;
                    $cAFCalPrice  = $ptDisChgAvi - $ptDisChgText;
                    $tDisChgValue = $ptDisChgText;
                } else {
                    //ชาร์จ
                    $nDistext = explode("+", $ptDisChgText);
                    $nCalucateDis = 0;
                    $nCalucateChg = $nDistext[1];
                    $cAFCalPrice  = $ptDisChgAvi + $nDistext[1];
                    $tDisChgValue = $nDistext[1];
                }
                $ptDisChgAvi = $cAFCalPrice;
            } else {

                $nDistext = explode("%", $ptDisChgText);
                $nCalucatePercent = ($nDistext[0] * $ptDisChgAvi) / 100;

                if ($tStr1 != '+') {
                    //ลด
                    $nCalucateDis = $nCalucatePercent;
                    $nCalucateChg = 0;
                    $cAFCalPrice  = $ptDisChgAvi - $nCalucatePercent;
                    $tDisChgValue = $nDistext[0];
                } else {
                    //ชาร์จ
                    $nCalucateDis = 0;
                    $nCalucateChg = $nCalucatePercent;
                    $cAFCalPrice = $ptDisChgAvi + $nCalucatePercent;
                    $tDisChgValue = substr($nDistext[0], 1);
                }
                $ptDisChgAvi = $cAFCalPrice;
            }

            $aArray = array(
                'CALFCXddDis' => floatval($nCalucateDis),
                'CALFCXddChg' => floatval($nCalucateChg),
            );

            return $aArray;
        }
    }

    //Function : Check Checkbox return num
    public function FSsCReturnCheckBox($ptStaus)
    {

        if ($ptStaus == 'on') {
            return 1;
        } else {
            return 0;
        }
    }

    //Function : Check Date Is Null
    public function FStCCheckDateNULL($pdDate)
    {

        if ($pdDate == '') {
            return NULL;
        } else {
            return $pdDate;
        }
    }


    //Function : Get ที่อยู่
    public function FSvCTXIGetShipAdd()
    {

        $FTAddRefCode   = $this->input->post('FTAddRefCode');
        $FNAddSeqNo     = $this->input->post('FNAddSeqNo');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangResort;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        $aDataShipAdd = $this->mTransferreceipt->FSaMTWIGetAddress($FTAddRefCode, $FNAddSeqNo, $nLangEdit);

        echo json_encode($aDataShipAdd);
    }


    //Function : get ร้านค้า ใน สาขา
    public function FSvCTXIGetShpByBch()
    {

        $tBchCode = $this->input->post('ptBchCode');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMShop_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);
        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangResort;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        $aData  = array(
            'FTBchCode'     => $tBchCode,
            'FTShpCode'     => '',
            'nPage'         => 1,
            'nRow'          => '9999',
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );

        $aShpData = $this->mShop->FSaMSHPList($aData);

        echo json_encode($aShpData);
    }


    //Function : Get สินค้า ตาม Pdt BarCode
    public function FSvCTXIGetPdtBarCode()
    {

        $tBarCode = $this->input->post('tBarCode');
        $tSplCode = $this->input->post('tSplCode');

        $aPdtBarCode =  FCNxHGetPdtBarCode($tBarCode, $tSplCode);

        if ($aPdtBarCode != 0) {
            $jPdtBarCode = json_encode($aPdtBarCode);
            $aData  = array(
                'aData' => $jPdtBarCode,
                'tMsg'     => 'OK',
            );
        } else {
            $aData  = array(
                'aData' => 0,
                'tMsg'     => language('document/browsepdt/browsepdt', 'tPdtNotFound'),
            );
        }

        $jData = json_encode($aData);
        echo $jData;
    }




    //////////////////////////////////////////////////////////////////////////   Zone Set ค่า
    //Function : Set Session ให้กับ Vat ว่าเป็น รวมในหรือ แยกนอก เพื่อใช้ในการคำนวนใหม่ตอนเลือก Vat 
    public function FSvCTXISetSessionVATInOrEx()
    {

        $ptXthDocNo = $this->input->post('ptXthDocNo');
        $tXthVATInOrEx = $this->input->post('tXthVATInOrEx');

        $this->session->set_userdata("tTWISesVATInOrEx" . $ptXthDocNo, $tXthVATInOrEx);
    }




    //////////////////////////////////////////////////////////////////////////   Zone แก้ไข
    //Functionality : Event Edit Master
    public function FSaCTXIEditEvent()
    {

        $tTXIDocType    = $this->input->post('ohdTXIDocType');
        $tXthDocNo      = $this->input->post('oetXthDocNo');
        $tBchCode       = $this->input->post('oetBchCode');

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave();

        try {

            $dXthDocDate = $this->input->post('oetXthDocDate') . " " . $this->input->post('oetXthDocTime');

            $aDataMaster = array(

                'FTBchCode'             => $tBchCode,
                'FTXthDocNo'            => $tXthDocNo,
                'FDXthDocDate'          => $dXthDocDate,
                'FTXthVATInOrEx'        => $this->input->post('ostXthVATInOrEx'),
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTSpnCode'             => "",
                'FTXthApvCode'          => $this->input->post('oetXthApvCode'),
                'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                // 'FNXthDocPrint'         => $this->input->post('oetXthDocPrint'), 
                'FCXthTotal'            => 0,
                'FCXthVat'              => 0,
                'FCXthVatable'          => 0,
                'FTXthRmk'              => $this->input->post('otaXthRmk'),
                'FTXthStaDoc'           => $this->input->post('ohdXthStaDoc'),
                'FTXthStaApv'           => $this->input->post('ohdXthStaApv'),
                'FTXthStaPrcStk'        => 0,
                'FNXthStaDocAct'        => $this->FSsCReturnCheckBox($this->input->post('ocbXthStaDocAct')), //สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FNXthStaRef'           => "",
                'FTRsnCode'             => $this->input->post('oetRsnCode'),
                'FDCreateOn'            => date('Y-m-d h:i:sa'),
                'FDLastUpdOn'           => date('Y-m-d h:i:sa'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
            );

            //Control Field Add ตาม Type เพราะ Field สองตารางมีไม่เหมือนกัน
            if ($tTXIDocType == 'WAH') {

                //Merchant
                $aDataMaster['FTXthMerCode']   = $this->input->post('oetMchCode');
                //Shop
                $aDataMaster['FTXthShopFrm']   = $this->input->post('oetShpCodeStart');
                $aDataMaster['FTXthShopTo']   = $this->input->post('oetShpCodeEnd');
                //Warehouse
                $aDataMaster['FTXthWhFrm']  = $this->input->post('ohdWahCodeStart');
                $aDataMaster['FTXthWhTo']   = $this->input->post('ohdWahCodeEnd');
            } else { }

            $aDataHDRef = array(
                'FTBchCode'             => $tBchCode,
                'FTXthDocNo'            => $tXthDocNo,
                'FTXthCtrName'          => $this->input->post('oetXthCtrName'),
                'FDXthTnfDate'          => $this->input->post('oetXthTnfDate'),
                'FTXthRefTnfID'         => $this->input->post('oetXthRefTnfID'),
                'FTXthRefVehID'         => $this->input->post('oetXthRefVehID'),
                'FTXthQtyAndTypeUnit'   => $this->input->post('oetXthQtyAndTypeUnit'),
                'FNXthShipAdd'          => $this->input->post('ohdXthShipAdd'),
                'FTViaCode'             => $this->input->post('ohdViaCode'),
            );

            $aDataWhere = array(
                'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
                'FTXthDocNo'        => $tXthDocNo,
                'FTBchCode'         => $tBchCode,
                'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
            );

            $this->db->trans_begin();

            $aStaSdtHD              = $this->mTransferreceipt->FSaMTWIAddUpdateHD($aDataMaster, $aDataWhere); /*ลงตาราง TAPTOrdHD */
            $aStaEventHDRef         = $this->mTransferreceipt->FSaMTWIAddUpdateHDRef($aDataHDRef, $aDataWhere); /*ลงตาราง TAPTOrdHD */
            $aStaEventTmpToDT       = $this->FSaMTWIAddTmpToDT($tXthDocNo);
            $aStaEventSumDTIntoHD   = $this->FSaMTWISumDTIntoHD($tXthDocNo);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            } else {
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'    => $aDataMaster['FTXthDocNo'],
                    'nStaEvent'        => '1',
                    'tStaMessg'        => 'Success Add Event'
                );
            }

            echo json_encode($aReturn);
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    //Function : Add Pdt ลง Dt (File)
    public function FSvCTXIAddPdtIntoTableDT()
    {

        $tTXIDocType     = $this->input->post('tTXIDocType');
        $tXthDocNo       = $this->input->post('ptXthDocNo');
        $tBchCode        = $this->input->post('ptBchCode');
        $tXphVATInOrEx  = $this->input->post('pnXphVATInOrEx'); /*ประเภท Vat ของ SPL (รวม,แยก)*/
        $tOptionAddPdt  = $this->input->post('pnOptionAddPdt');
        $pjPdtData      = $this->input->post('pjPdtData');
        $aPdtData       = json_decode($pjPdtData);

        $aDataWhere = array(
            'FTXthDocNo'        => $tXthDocNo,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
        );

        $nCounts    = $this->mTransferreceipt->FSaMTWIGetCountDTTemp($aDataWhere);

        foreach ($aPdtData as $nKey => $tValue) {

            $pnPdtCode      = $tValue->pnPdtCode;
            $ptBarCode      = $tValue->ptBarCode;
            $ptPunCode      = $tValue->ptPunCode;
            $pcPrice        = $tValue->packData->Price;
            $FCXtdSetPrice  = $pcPrice * 1; //1 คือ Rate
            $nCounts        = $nCounts + 1;

            $aDataPdtWhere = array(
                'FTXthDocNo'    => $tXthDocNo,
                'FTBchCode'     => $tBchCode,   // จากสาขาที่ทำรายการ
                'FTPdtCode'     => $pnPdtCode,  // จาก Browse Pdt
                'FTPunCode'     => $ptPunCode,  // จาก Browse Pdt
                'FTBarCode'     => $ptBarCode,  // จาก Browse Pdt
                'FCXtdSetPrice' => $FCXtdSetPrice,    // ราคาสินค้าจาก Browse Pdt
                'nCounts'       => $nCounts,    // จำนวนล่าสุด Seq
                'tOptionAddPdt' => $tOptionAddPdt,  // Option Add Pdt
                'FNLngID'       => $this->session->userdata("tLangID"), //รหัสภาษาที่ login
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'FTXthDocKey'   => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
                'tSesUsername'   => $this->session->userdata('tSesUsername'),
                'FTBrowDocNo'   => $tValue->packData->DocNo, //DocNo ของ IntPdt ที่ Browse มา
            );

            $aDataPdtMaster     =   $this->mTransferreceipt->FSaMTWIGetDataPdt($aDataPdtWhere); // Data Master Pdt

            $nStaInsPdtToTmp    =   $this->mTransferreceipt->FSaMTWIInsertPDTToTemp($aDataPdtMaster, $aDataPdtWhere);

            //เช็ค ถ้า Add ลง Temp ได้ จะ ปรับ FTXtdRvtRef
            if($nStaInsPdtToTmp['rtCode'] == 1){
                //Update Field RvtRef ว่ามีเอกสารที่เรียกใช้อยู่
                $nStaUpdRvtRef  =   $this->mTransferreceipt->FSaMTWIUpdRvtRefTableIns($aDataPdtWhere);
                
            }

        }

        //คำนวน DT ใหม่
        $aResCalDTTmp       = $this->FSnCTXICalulateDTTemp($tXthDocNo, $tXphVATInOrEx, $tTXIDocType);
    }

    //Function : Edit Inline 
    public function FSvCTXIEditPdtIntoTableDT()
    {

        $tTXIDocType     = $this->input->post('tTXIDocType');
        $tXthDocNo      = $this->input->post('ptXthDocNo');
        $tEditSeqNo     = $this->input->post('ptEditSeqNo');
        $aField         = $this->input->post('paField');
        $aValue         = $this->input->post('paValue');

        $aDataWhere = array(
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
            'FTXthDocNo'        => $tXthDocNo,
            'FNXtdSeqNo'        => $tEditSeqNo,
        );

        $aDataUpdateDT = array();

        foreach ($aField as $key => $FieldName) {
            $aDataUpdateDT[$FieldName] = $aValue[$key];
        }

        //Edit Inline
        $aResUpdDTTmpInline     = $this->mTransferreceipt->FSnMWTOUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);
    }

    // Function : Process Calulate 
    //
    public function FSnCTXICalulateDTTemp($ptXthDocNo, $ptXthVATInOrEx, $ptTXIDocType)
    {

        $tTXIDocType = $ptTXIDocType;
        $aDataWhere = array(
            'FTXthDocNo'        => $ptXthDocNo,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
        );

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave();

        //Get DT Tmp
        $aDataDTTmp = $this->mTransferreceipt->FSaMTXIGetDTTemp($aDataWhere);

        if ($aDataDTTmp['rtCode'] == 1) {

            $aDataDTTmp = $aDataDTTmp['raItems'];

            foreach ($aDataDTTmp as $Key => $value) {

                //FCXtdQtyAll จำนวนรวมหน่วยเล็กสุด(จ่ายโอน)  (Qty*Factor*StkFac)
                $FCXtdQtyAll = $value['FCXtdQty'] * $value['FCXtdFactor'];
                $aDataDTTmp[$Key]['FCXtdQtyAll'] = $FCXtdQtyAll;

                //คำนวน FCXtdAmt  (Qty*SetPrice) 
                $FCXtdAmt = $value['FCXtdQty'] * $value['FCXtdSetPrice'];
                $aDataDTTmp[$Key]['FCXtdAmt'] = number_format($FCXtdAmt, $nOptDecimalSave, '.', '');

                //มูลค่าภาษี IN: ((Net*VatRate)/(100+VatRate)) ,EX: ((Net*(100+VatRate))/100)
                if ($ptXthVATInOrEx == 1) {
                    // $FCXtdVat = $FCXtdAmt*$value['FCXtdVatRate'];
                    $FCXtdVat = (($FCXtdAmt * $value['FCXtdVatRate']) / (100 + $value['FCXtdVatRate']));
                } else {
                    $FCXtdVat = (($FCXtdAmt * (100 + $value['FCXtdVatRate'])) / 100);
                }
                $aDataDTTmp[$Key]['FCXtdVat'] = number_format($FCXtdVat, $nOptDecimalSave, '.', '');

                //มูลค่าแยกภาษี (Amt-FCXpdVat)
                $FCXtdVatable = $FCXtdAmt - $FCXtdVat;
                $aDataDTTmp[$Key]['FCXtdVatable'] = number_format($FCXtdVatable, $nOptDecimalSave, '.', '');

                //มูลค่าสุทธิก่อนท้ายบิล (FCXpdVat+FCXpdVatable)
                if ($ptXthVATInOrEx == 1) {
                    $FCXtdNet = $FCXtdVat + $FCXtdVatable;
                } else {
                    $FCXtdNet = $FCXtdVat;
                }
                $aDataDTTmp[$Key]['FCXtdNet'] = number_format($FCXtdNet, $nOptDecimalSave, '.', '');

                //ต้นทุนรวมใน (FCXpdVat+FCXpdVatable)
                $FCXtdCostIn = $FCXtdVat + $FCXtdVatable;
                $aDataDTTmp[$Key]['FCXtdCostIn'] = number_format($FCXtdCostIn, $nOptDecimalSave, '.', '');

                //ต้นทุนแยกนอก (FCXpdVatable)
                $aDataDTTmp[$Key]['FCXtdCostEx'] = number_format($FCXtdVatable, $nOptDecimalSave, '.', '');
            }

            $aResUpd = $this->mTransferreceipt->FSnMWTOUpdateDTTemp($aDataDTTmp, $aDataWhere);
        }
    }


    /**
     * Functionality : Event Approve Doc
     * Parameters : Ajax and Function Parameter
     * Creator : 1/02/2019 Krit(Copter)
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSvCTXIApprove()
    {

        $tXthDocNo  = $this->input->post('tXthDocNo');
        $tXthStaApv = $this->input->post('tXthStaApv');

        $aDataUpdate = array(
            'FTXthDocNo' => $tXthDocNo,
            'FTXthApvCode' => $this->session->userdata('tSesUsername')
        );

        $aStaApv = $this->mTransferreceipt->FSvMTWIApprove($aDataUpdate);

        $tUsrBchCode = FCNtGetBchInComp();

        $this->db->trans_begin();

        try {
            $aMQParams = [
                "queueName" => "TNFWAREHOSEIN",
                "params" => [
                    "ptBchCode"     => $tUsrBchCode,
                    "ptDocNo"       => $tXthDocNo,
                    "ptDocType"     => '5',
                    "ptUser"        => $this->session->userdata('tSesUsername'),
                    "ptConnStr"     => DB_CONNECT,
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);
        } catch (\ErrorException $err) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }


    //Function : Approve Doc
    public function FSvCTXICancel()
    {

        $tXthDocNo = $this->input->post('tXthDocNo');

        $aDataUpdate = array(
            'FTXthDocNo' => $tXthDocNo,
        );

        $aStaApv = $this->mTransferreceipt->FSvMTWICancel($aDataUpdate);

        if ($aStaApv['rtCode'] == 1) {
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        } else {
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);
    }

    //Functionality : Event Add Master
    public function FSaCTXIAddEvent()
    {

        $tTXIDocType = $this->input->post('ohdTXIDocType');

        //Check Auto gen Code
        $nStaAutoGenCode = $this->input->post('ocbStaAutoGenCode');
        if ($nStaAutoGenCode == 'on') {
            if ($tTXIDocType == 'WAH') {
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtTwiHD',                           
                    "tDocType"    => 5,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aXthDocNo   = $aAutogen[0]["FTXxhDocNo"];

                // $aXthDocNo   = FCNaHGenCodeV5('TCNTPdtTwiHD', '5');
            } else {
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtTbiHD',                           
                    "tDocType"    => 7,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aXthDocNo   = $aAutogen[0]["FTXxhDocNo"];

                // $aXthDocNo   = FCNaHGenCodeV5('TCNTPdtTbiHD', '7');
            }

            if ($aXthDocNo['rtCode'] == 1) {
                $tXthDocNo = $aXthDocNo['rtXthDocNo'];
            } else {
                $tXthDocNo = '';
            }
        } else {
            $tXthDocNo  = $this->input->post('oetXthDocNo');
        }

        if ($tXthDocNo != '') {

            if ($this->input->post('oetBchCode') == '') {
                $tBchCode = FCNtGetBchInComp();
            } else {
                $tBchCode = $this->input->post('oetBchCode');
            }

            //Get Option Save Decimal  
            $nOptDecimalSave = FCNxHGetOptionDecimalSave();

            $dXthDocDate = $this->input->post('oetXthDocDate') . " " . $this->input->post('oetXthDocTime');

            try {

                $aDataMaster = array(
                    'FTXthDocNo'            => $tXthDocNo,
                    'FDXthDocDate'          => $dXthDocDate,
                    'FTBchCode'             => $tBchCode,
                    'FTXthVATInOrEx'        => $this->input->post('ostXthVATInOrEx'),
                    'FTDptCode'             => $this->input->post('ohdDptCode'),
                    'FTUsrCode'             => $this->input->post('oetUsrCode'),
                    'FTXthRefExt'           => $this->input->post('oetXthRefExt'),
                    'FDXthRefExtDate'       => $this->input->post('oetXthRefExtDate') != '' ? $this->input->post('oetXthRefExtDate') : NULL,
                    'FTXthRefInt'           => $this->input->post('oetXthRefInt'),
                    'FDXthRefIntDate'       => $this->input->post('oetXthRefIntDate') != '' ? $this->input->post('oetXthRefIntDate') : NULL,
                    'FNXthDocPrint'         => 0,
                    'FCXthTotal'            => 0, //ยอดรวมก่อนลด
                    'FCXthVat'              => 0,
                    'FCXthVatable'          => 0,
                    'FTXthRmk'              => $this->input->post('otaXthRmk'),
                    'FTXthStaDoc'           => 1, //1 after save
                    'FTXthStaApv'           => '',  //สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                    'FTXthStaPrcStk'        => '',  //สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                    'FNXthStaDocAct'        => $this->FSsCReturnCheckBox($this->input->post('ocbXthStaDocAct')), //สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                    'FNXthStaRef'           => "",   //Default 0
                    'FTRsnCode'             => $this->input->post('oetRsnCode'),
                    'FDLastUpdOn'           => date('Y-m-d h:i:sa'),
                    'FDCreateOn'            => date('Y-m-d h:i:sa'),
                    'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                    'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
                );

                //Control Field Add ตาม Type เพราะ Field สองตารางมีไม่เหมือนกัน
                if ($tTXIDocType == 'WAH') {

                    //Merchant
                    $aDataMaster['FTXthMerCode']   = $this->input->post('oetMchCode');
                    //Shop
                    $aDataMaster['FTXthShopFrm']   = $this->input->post('oetShpCodeStart');
                    $aDataMaster['FTXthShopTo']   = $this->input->post('oetShpCodeEnd');
                    //Warehouse
                    $aDataMaster['FTXthWhFrm']  = $this->input->post('ohdWahCodeStart');
                    $aDataMaster['FTXthWhTo']   = $this->input->post('ohdWahCodeEnd');
                } else { }


                $aDataHDSpl = array(
                    'FTBchCode'             => $this->input->post('oetBchCode'),
                    'FTXthDocNo'            => $tXthDocNo,
                    'FTXthCtrName'          => $this->input->post('oetXthCtrName'),
                    'FDXthTnfDate'          => $this->input->post('oetXthTnfDate'),
                    'FTXthRefTnfID'         => $this->input->post('oetXthRefTnfID'),
                    'FTXthRefVehID'         => $this->input->post('oetXthRefVehID'),
                    'FTXthQtyAndTypeUnit'   => $this->input->post('oetXthQtyAndTypeUnit'),
                    'FNXthShipAdd'          => $this->input->post('ohdXthShipAdd'),
                    'FTViaCode'             => $this->input->post('ohdViaCode'),
                );

                $aDataWhere = array(
                    'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
                    'FTXthDocNo'        => $tXthDocNo,
                    'FTBchCode'         => $tBchCode,
                    'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
                );

                $oCountDup  = $this->mTransferreceipt->FSnMTWICheckDuplicate($aDataMaster['FTXthDocNo'], $aDataWhere);
                $nStaDup    = $oCountDup[0]->counts;

                if ($nStaDup == 0) {
                    $this->db->trans_begin();
                    $aStaSdtOrdHD               = $this->mTransferreceipt->FSaMTWIAddUpdateHD($aDataMaster, $aDataWhere);               //Add ลง HD
                    $aStaEventHDRef             = $this->mTransferreceipt->FSaMTWIAddUpdateHDRef($aDataHDSpl, $aDataWhere);             //Add ลง HDRef
                    $aStaEventDocNoInDocTemp    = $this->mTransferreceipt->FSaMTWIAddUpdateDocNoInDocTemp($aDataWhere);    //Update DocNo ในตาราง Doctemp
                    $aStaEventTmpToDT           = $this->FSaMTWIAddTmpToDT($tXthDocNo); //Add Temp To DT
                    $aStaEventSumDTIntoHD       = $this->FSaMTWISumDTIntoHD($tXthDocNo);    //Sum DT To HD

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $aReturn = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsucess Add"
                        );
                    } else {
                        $this->db->trans_commit();
                        $aReturn = array(
                            'nStaCallBack'    => $this->session->userdata('tBtnSaveStaActive'),
                            'tCodeReturn'    => $aDataMaster['FTXthDocNo'],
                            'nStaEvent'        => '1',
                            'tStaMessg'        => 'Success Add'
                        );
                    }
                } else {
                    $aReturn = array(
                        'nStaEvent'    => '801',
                        'tStaMessg'    => language('document/transferwarehouseout/transferwarehouseout', 'tTWIMsgDuplicate')
                    );
                }
            } catch (Exception $Error) {
                echo $Error;
            }
        } else {
            $aReturn = array(
                'nStaEvent'    => '801',
                'tStaMessg'    => language('common/main/main', 'tCanNotAutoGenCode')
            );
        }

        echo json_encode($aReturn);
    }


    //Function : Add DT
    public function FSaMTWIAddTmpToDT($ptXthDocNo = '')
    {

        $tXthDocNo      = $ptXthDocNo;
        $tXthVATInOrEx  = $this->input->post('ostXthVATInOrEx');
        $tTXIDocType    = $this->input->post('ohdTXIDocType');

        $aDataWhere = array(
            'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
            'FTXthDocNo'        => $tXthDocNo,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
        );

        $aResCalDTTmp   = $this->FSnCTXICalulateDTTemp($tXthDocNo, $tXthVATInOrEx, $tTXIDocType);

        $aResInsDT      =  $this->mTransferreceipt->FSaMTWIInsertTmpToDT($aDataWhere);
    }


    //Function : Get DT Sum In to Tmp
    public function FSaMTWISumDTIntoHD($ptXthDocNo)
    {

        $tTXIDocType    = $this->input->post('ohdTXIDocType');
        $tXthDocNo      = $ptXthDocNo;
        $tXthVATInOrEx  = $this->input->post('ostXthVATInOrEx');

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave();

        $aDataWhere  = array(
            'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
            'FTXthDocNo'        => $tXthDocNo,
            'nRow'              => 10000,
            'nPage'             => 1,
        );

        $aDataDT    =   $this->mTransferreceipt->FSaMTWIGetDT($aDataWhere); //*ลบ Data เก่าออก*/

        $FCXthTotal = 0;

        if ($aDataDT['rtCode'] == 1) {

            $aDataDT = $aDataDT['raItems'];
            foreach ($aDataDT as $key => $value) {
                //รวมใน 
                if ($tXthVATInOrEx == 1) {
                    $FCXthTotal += $value['FCXtdVat'] + $value['FCXtdVatable'];
                } else {
                    //แยกนอก
                    $FCXthTotal += $value['FCXtdVat'];
                }
            }
        }

        $aDataUpdHD = array(
            'FCXthTotal' => number_format($FCXthTotal, $nOptDecimalSave, '.', '')
        );

        $aDataDT    =   $this->mTransferreceipt->FSaMTWIUpdateHDFCXthTotal($aDataUpdHD, $aDataWhere); //*ลบ Data เก่าออก*/

    }


    //Function : Add DT
    public function FSaMTWIAddDT()
    {

        $aStaEventDelDT =  $this->mTransferreceipt->FSnMPMTDelDT($this->input->post('oetSearchAll')); //*ลบ Data เก่าออก*/

        //Get Data From File
        $tXthDocNo = $this->input->post('oetSearchAll');
        $aDataFile = $this->FMaTWIGetDataFormFile($tXthDocNo);

        $nNum = FCNnHSizeOf($aDataFile['DTData']);

        if ($nNum != 0) {
            foreach ($aDataFile['DTData'] as $key => $value) {

                $this->db->trans_begin();

                $aStaEventOrdHDSpl  = $this->mTransferreceipt->FSaMTWIAddUpdateOrdDT($value); /*ลงตาราง TAPTOrdDT */

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        }
    }


    //Function : Add DT Dis
    public function FSaMTWIAddDTDis()
    {

        //Get Data From File
        $tXthDocNo = $this->input->post('oetSearchAll');
        $aDataFile = $this->FMaTWIGetDataFormFile($tXthDocNo);

        $aStaEventDelDTDis =  $this->mTransferreceipt->FSnMPMTDelPcoDTDis($tXthDocNo); //*ลบ Data เก่าออก*/

        $nNum = FCNnHSizeOf($aDataFile['DTData']);

        if ($nNum != 0) {

            foreach ($aDataFile['DTData'] as $key => $valueDT) {

                $tXthDocNo      = $valueDT['FTXthDocNo'];
                $nSeqNo         = $valueDT['FNXpdSeqNo'];
                $cXpdAmt        = $valueDT['FCXpdAmt'];
                $cXpdVatRate    = $valueDT['FCXpdVatRate'];
                $cXpdWhtRate    = $valueDT['FCXpdWhtRate'];
                $cXpdQty        = $valueDT['FCXpdQty'];
                $cXpdQtyAll     = $valueDT['FCXpdQtyAll'];


                foreach ($valueDT['DTDiscount'] as $keyDis => $valueDTDis) {

                    $this->db->trans_begin();

                    $aStaEventOrdDTDis  = $this->mTransferreceipt->FSaMTWIAddUpdateOrdDTDis($valueDTDis); /*ลงตาราง TAPTOrdDTDis */

                    if ($this->db->trans_status() === false) {
                        $this->db->trans_rollback();
                    } else {
                        $this->db->trans_commit();
                    }
                }


                $aDTData = array(
                    'FTXpdDisChgTxt' => $valueDT['FTXpdDisChgTxt'],
                    'FCXpdDis'      => $valueDT['FCXpdDis'],
                    'FCXpdChg'      => $valueDT['FCXpdChg'],
                    'FCXpdNet'      => $valueDT['FCXpdNet'],        //คำนวน FCXpdNet มูลค่าสุทธิก่อนท้ายบิล (FCXpdAmt-FCXpdDis+FCXpdChg)
                    'FCXpdNetAfHD'  => $valueDT['FCXpdNetAfHD'],    //Default = FCXpdNet  ปรับเมื่อมีท้ายบิล
                    'FCXpdNetEx'    => $valueDT['FCXpdNetEx'],      //แยกนอก THEN FCXpdNet 
                    'FCXpdVat'      => $valueDT['FCXpdVat'],
                    'FCXpdVatable'  => $valueDT['FCXpdVatable'],      //มูลค่าแยกภาษี (NetAfHD-FCXpdVat)
                    'FCXpdWhtAmt'   => $valueDT['FCXpdWhtAmt'],      //Default 0 IF FCXpdWhtRate>0 THEN  FCXpdVatable* FCXpdWhtRate%
                    'FCXpdWhtRate'  => $valueDT['FCXpdWhtRate'],
                    'FCXpdCostIn'   => $valueDT['FCXpdCostIn'],      //ต้นทุนรวมใน (FCXpdVatable/FCXpdQtyAll ) * VatRate
                    'FCXpdCostEx'   => $valueDT['FCXpdCostEx'],      //ต้นทุนแยกนอก FCXpdVatable/FCXpdQtyAll
                    'FCXpdQtyLef'   => $valueDT['FCXpdQtyLef'],      //จำนวนคงเหลือ ตามหน่วย (Default:FCXpdQty)
                );

                $aDTDataWhere = array(
                    'FTXthDocNo' => $valueDT['FTXthDocNo'],
                    'FNXpdSeqNo' => $valueDT['FNXpdSeqNo']
                );

                $this->db->trans_begin();

                $aStaUpdDT  = $this->mTransferreceipt->FSaMTWIUpdateOrdDT($aDTData, $aDTDataWhere); /*Update TAPTOrdDT ใหม่ */

                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                }
            }
        }
    }


    //////////////////////////////////////////////////////////////////////////   Zone ลบ
    //Functionality : Event Delete Master
    public function FSaCTXIDeleteEvent()
    {

        $tTXIDocType    = $this->input->post('tTXIDocType');
        $tIDCode        = $this->input->post('tIDCode');
        $aDataWhere = array(
            'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
            'FTXthDocNo'        => $tIDCode,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD'
        );
        $aResDel    = $this->mTransferreceipt->FSnMTWIDel($aDataWhere);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    //Functionality : Event Delete Product
    //Parameters : Ajax jReason()
    //Creator : 25/03/2019 Krit(Copter)
    //Return : Status Delete Event
    //Return Type : String
    public function FSvCTXIPdtMultiDeleteEvent()
    {

        $tTXIDocType    = $this->input->post('tTXIDocType');
        $FTXthDocNo     = $this->input->post('tDocNo');
        $aSeqData       = $this->input->post('aSeqData');
        $aPdtData       = $this->input->post('aPdtData');
        $aPunData       = $this->input->post('aPunData');
        $aBarData       = $this->input->post('aBarData');

        $tSession   = $this->session->userdata('tSesSessionID');

        $nCount     = FCNnHSizeOf($aSeqData);

        //ลบมากกว่า 1 แถว
        if ($nCount > 1) {

            for ($i = 0; $i < $nCount; $i++) {

                $aDataWhere = array(
                    'FTXthDocNo'        => $FTXthDocNo,
                    'FNXtdSeqNo'        => $aSeqData[$i],
                    'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
                    'FTSessionID'       => $tSession,

                    //Where ของ Intransit
                    'FTPdtCode'         => $aPdtData[$i],
                    'FTPunCode'         => $aPunData[$i],
                    'FTBarCode'         => $aBarData[$i],
                    'tSesUsername'      => NULL, // Set Null เพราะว่า เกิดจากการ ลบ Pdt จะ Set ค่า RvtRef เป็นว่าง
                    'FTBrowDocNo'       => "" // ที่ว่างเพราะ เอาไป Where ในตารารง TCNTPdtIntDT 
                    //Where ของ Intransit
                );

                $aResDel = $this->mTransferreceipt->FSaMTXIPdtTmpMultiDel($aDataWhere);

                if($aResDel['rtCode'] == 1){
                    $aStaUpdRvtRefNULL = $this->mTransferreceipt->FSaMTWIUpdRvtRefTableInsToNULL($aDataWhere);
                }

            }
        } else {

            $aDataWhere = array(
                'FTXthDocNo'        => $FTXthDocNo,
                'FNXtdSeqNo'        => $aSeqData[0],
                'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
                'FTSessionID'       => $tSession
            );
            $aResDel = $this->mTransferreceipt->FSaMTXIPdtTmpMultiDel($aDataWhere);
        }

        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }


    //Function : Remove Master Pdt Intable (File)
    public function FSvCTXIRemovePdtInTemp()
    {

        $tTXIDocType = $this->input->post('tTXIDocType');

        $aDataWhere = array(
            'FTXthDocKey'   => $this->FStCTXISwitchDatabase($tTXIDocType) . "HD",
            'FTXthDocNo'    => $this->input->post('ptXthDocNo'),
            'FTPdtCode'     => $this->input->post('ptPdtCode'),
            'FTPunCode'     => $this->input->post('ptPunCode'),
            'FNXtdSeqNo'    => $this->input->post('ptSeqno'),
            'FTBarCode'     => $this->input->post('ptBarCode'),
            'FCXtdQty'      => $this->input->post('ptQty'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
            'tSesUsername'  => NULL, // Set Null เพราะว่า เกิดจากการ ลบ Pdt จะ Set ค่า RvtRef เป็นว่าง
            'FTBrowDocNo'   => ""
        );

        $aResDel = $this->mTransferreceipt->FSnMTWIDelDTTmp($aDataWhere);

        if($aResDel['rtCode'] == 1){
            $aStaUpdRvtRefNULL = $this->mTransferreceipt->FSaMTWIUpdRvtRefTableInsToNULL($aDataWhere);
        }
    }


    //Function : Remove Master Pdt Intable (File)
    public function FSvCTXIRemoveAllPdtInFile()
    {

        //Get Data From File
        $tXthDocNo = $this->input->post('ptXthDocNo');
        $aDataFile = $this->FMaTWIGetDataFormFile($tXthDocNo);

        unset($aDataFile['DTData']);

        $jDataArray = json_encode($aDataFile);
        //PATHSupawat
        $fp = fopen(APPPATH . "modules\document\document\\" . $tXthDocNo . "-" . $this->session->userdata('tSesUsername') . ".txt", "r+");
        file_put_contents(APPPATH . "modules\document\document\\" . $tXthDocNo . "-" . $this->session->userdata('tSesUsername') . ".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTWIProcessCalculaterInFile($tXthDocNo);
    }


    //////////////////////////////////////////////////////////////////////////   Zone Call Page

    public function FSvCTXIClearDTTemp()
    {
        //มาเป็น WAH , BCH
        $tTXIDocType = $this->input->post('tTXIDocType');
        $tXthDocNo = $this->input->post('tXthDocNo');

        //Clear DT Temp
        $tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType);
        $nStaDelDTTmp = $this->mTransferreceipt->FSxMTXIClearPdtInTmp($tTblSelectData, $tXthDocNo);
    }

    //Function : เรียกหน้า  Add 
    public function FSxCTXIAddPage()
    {

        //มาเป็น WAH , BCH
        $tTXIDocType = $this->input->post('tTXIDocType');

        //Clear DT Temp
        $tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType);
        $this->mTransferreceipt->FSxMTXIClearPdtInTmp($tTblSelectData, '');

        //Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave();

        //Get Option Scan SKU
        $nOptScanSku    = FCNnHGetOptionScanSku();

        //Lang ภาษา
        $nLangEdit  = $this->session->userdata("tLangEdit");
        $aDataWhere  = array(
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList    = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhere);

        if ($aResList['rtCode'] == '1') {
            $tBchCode       = $aResList['raItems']['rtCmpBchCode'];
            $tCmpRteCode    = $aResList['raItems']['rtCmpRteCode'];
            $tVatCode       = $aResList['raItems']['rtVatCodeUse'];

            $aVatRate = FCNoHCallVatlist($tVatCode);
            $cVatRate  = $aVatRate['FCVatRate'][0];

            $aDataRate  = array(
                'FTRteCode' => $tCmpRteCode,
                'FNLngID'   => $nLangEdit
            );

            $aResultRte     = $this->mRate->FSaMRTESearchByID($aDataRate);
            $cXthRteFac     = $aResultRte['raItems']['rcRteRate'];
        } else {
            $tBchCode       = FCNtGetBchInComp();
            $tCmpRteCode    = "";
            $tVatCode       = "";
            $cVatRate       = "";
            $cXthRteFac     = "";
        }

        $tUsrLogin = $this->session->userdata('tSesUsername');

        $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin); //Get Department Code

        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin' => $tUsrLogin
        );

        $aDataUserGroup = $this->mTransferreceipt->FStTWIGetShpCodeForUsrLogin($aDataShp); // Get ข้อมูลสาขา และร้านค้าของ User ที่ login

        //เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
        if (@$aDataUserGroup->FTBchCode == '') {
            //ถ้าว่าง ให้ Get Option Def
            $tBchCode   = FCNtGetBchInComp();
            $tBchName   = FCNtGetBchNameInComp();
        } else {
            $tBchCode   = $aDataUserGroup->FTBchCode;
            $tBchName   = $aDataUserGroup->FTBchName;
        }

        //เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
        if (@$aDataUserGroup->FTShpCode == '') {
            //ถ้าว่าง ให้ Get Option Def
            $tMerCode   = "";
            $tMerName   = "";

            $tShpCode   = "";
            $tShpName   = "";
            $tShpType   = "";

            $tWahCode   = "";
            $tWahName   = "";
        } else {
            $tMerCode   = $aDataUserGroup->FTMerCode;
            $tMerName   = $aDataUserGroup->FTMerName;

            $tShpCode   = $aDataUserGroup->FTShpCode;
            $tShpName   = $aDataUserGroup->FTShpName;
            $tShpType   = $aDataUserGroup->FTShpType;

            $tWahCode   = $aDataUserGroup->FTWahCode;
            $tWahName   = $aDataUserGroup->FTWahName;
        }

        $aDataAdd = array(
            'aResult'       =>  array('rtCode' => '99'),
            'aResultOrdDT'  =>  array('rtCode' => '99'),
            'nOptDecimalShow' =>  $nOptDecimalShow,
            'nOptScanSku'   =>  $nOptScanSku,
            'nOptDocSave'   =>  $nOptDocSave,
            'tCmpRteCode'   =>  $tCmpRteCode,
            'tVatCode'      =>  $tVatCode,
            'cVatRate'      =>  $cVatRate,
            'cXthRteFac'    =>  $cXthRteFac,
            'tDptCode'      =>  $tDptCode,
            'tShpCode'      =>  $tShpCode,
            'tShpName'      =>  $tShpName,
            'tWahCode'      =>  $tWahCode,
            'tWahName'      =>  $tWahName,
            'tBchCode'      =>  $tBchCode,
            'tBchName'      =>  $tBchName,
            'tTXIDocType'   =>  $tTXIDocType,

            'tUserLoginBchCode' => $tBchCode,
            'tUserLoginBchName' => $tBchName,

            'tUserLoginMerCode' => $tMerCode,
            'tUserLoginMerName' => $tMerName,

            'tUserLoginShpCode' => $tShpCode,
            'tUserLoginShpName' => $tShpName,
            'tUserLoginShpType' => $tShpType,

            'tUserLoginWahCode' => $tWahCode,
            'tUserLoginWahName' => $tWahName,
        );

        $this->load->view('document/transferreceipt/wTransferreceiptAdd', $aDataAdd);
    }


    //Function : เรียกหน้า  Edit  
    public function FSvCTXIEditPage()
    {

        //Remove File Cache Data TWI
        $tTXIDocType    = $this->input->post('tTXIDocType');

        //Remove File Cache Data TWI
        $tXthDocNo = $this->input->post('ptXthDocNo');

        $aAlwEvent = FCNaHCheckAlwFunc('dcmTXI/0/0/'); //Control Event
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave();

        //Get Option Scan SKU
        $nOptScanSku    = FCNnHGetOptionScanSku();

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //Data Master
        $aDataWhere  = array(
            'tTblSelectData'    => $this->FStCTXISwitchDatabase($tTXIDocType),
            'FTXthDocNo'        => $tXthDocNo,
            'FNLngID'           => $nLangEdit,
            'nRow'              => 10000,
            'nPage'             => 1,
            'FTXthDocKey'       => $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
        );

        $tUsrLogin = $this->session->userdata('tSesUsername');

        $aDataUsrLogin  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin' => $tUsrLogin
        );

        $aDataUserGroup = $this->mTransferreceipt->FStTWIGetShpCodeForUsrLogin($aDataUsrLogin); // Get ข้อมูลสาขา และร้านค้าของ User ที่ login

        //เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
        if (@$aDataUserGroup->FTBchCode == '') {
            //ถ้าว่าง ให้ Get Option Def
            $tBchCode   = "";
            $tBchName   = "";
        } else {
            $tBchCode   = $aDataUserGroup->FTBchCode;
            $tBchName   = $aDataUserGroup->FTBchName;
        }

        //เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
        if (@$aDataUserGroup->FTShpCode == '') {
            //ถ้าว่าง ให้ Get Option Def
            $tMerCode   = "";
            $tMerName   = "";

            $tShpCode   = "";
            $tShpName   = "";
            $tShpType   = "";

            $tWahCode   = "";
            $tWahName   = "";
        } else {
            $tMerCode   = $aDataUserGroup->FTMerCode;
            $tMerName   = $aDataUserGroup->FTMerName;

            $tShpCode   = $aDataUserGroup->FTShpCode;
            $tShpName   = $aDataUserGroup->FTShpName;
            $tShpType   = $aDataUserGroup->FTShpType;

            $tWahCode   = $aDataUserGroup->FTWahCode;
            $tWahName   = $aDataUserGroup->FTWahName;
        }

        //Get Data
        $aResult        = $this->mTransferreceipt->FSaMTXIGetHD($aDataWhere);       // Data TCNTPdtTwiHD
        $aDataHDRef     = $this->mTransferreceipt->FSaMTXIGetHDRef($aDataWhere);    // Data TCNTPdtTwiHDRef
        $aDataDT        = $this->mTransferreceipt->FSaMTWIGetDT($aDataWhere);       // Data TCNTPdtTwiHD
        $aStaIns        = $this->mTransferreceipt->FSaMTWIInsertDTToTemp($aDataDT, $aDataWhere);    // Insert Data DocTemp

        $aDataEdit = array(
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptDocSave'       =>  $nOptDocSave,
            'nOptScanSku'       =>  $nOptScanSku,
            'aResult'           =>  $aResult,
            'aAlwEvent'         =>  $aAlwEvent,
            'tTXIDocType'       => $tTXIDocType,

            'tUserLoginBchCode' => $tBchCode,
            'tUserLoginBchName' => $tBchName,

            'tUserLoginMerCode' => $tMerCode,
            'tUserLoginMerName' => $tMerName,

            'tUserLoginShpCode' => $tShpCode,
            'tUserLoginShpName' => $tShpName,
            'tUserLoginShpType' => $tShpType,

            'tUserLoginWahCode' => $tWahCode,
            'tUserLoginWahName' => $tWahName,
        );

        $this->load->view('document/transferreceipt/wTransferreceiptAdd', $aDataEdit);
    }


    //////////////////////////////////////////////////////////////////////////   Zone Advacne Table
    //Functionality : Function Call DataTables List Master
    public function FSxCTXIDataTable()
    {

        $tTXIDocType        = $this->input->post('tTXIDocType');
        $oAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');

        //Controle Event
        $aAlwEvent          = FCNaHCheckAlwFunc('dcmTXI/0/0/' . $tTXIDocType);

        //Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPageCurrent');
        }

        //Lang ภาษา
        $nLangEdit      = $this->session->userdata("tLangEdit");

        //User Login
        $tSesUsrBchCode      = $this->session->userdata("tSesUsrBchCode");
        $tSesUsrShpCode      = $this->session->userdata("tSesUsrShpCode");
        $tSesUsrMerCode      = $this->session->userdata("tSesUsrMerCode");

        $aDataWhere  = array(
            'tTblSelectData'    =>  $this->FStCTXISwitchDatabase($tTXIDocType),
            'FNLngID'           =>  $nLangEdit,
            'nPage'             =>  $nPage,
            'nRow'              =>  10,
            'oAdvanceSearch'    =>  $oAdvanceSearch,
            'tSesUsrBchCode'   =>   $tSesUsrBchCode,
            'tSesUsrShpCode'   =>   $tSesUsrShpCode,
            'tSesUsrMerCode'   =>   $tSesUsrMerCode,
        );

        $aResList   = $this->mTransferreceipt->FSaMTWIList($aDataWhere);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'nOptDecimalShow' => $nOptDecimalShow
        );

        $this->load->view('document/transferreceipt/wTransferreceiptDataTable', $aGenTable);
    }


    //Function : Adv Table Load Data
    public function FSvCTXIPdtAdvTblLoadData()
    {


        $tTXIDocType    = $this->input->post('tTXIDocType');
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthStaApv     = $this->input->post('tXthStaApv');
        $tXthStaDoc     = $this->input->post('tXthStaDoc');
        $tXthVATInOrEx  = $this->input->post('ptXthVATInOrEx');

        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthDocKey'   => $tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType) . 'HD',
        );

        // //คำนวน DT ใหม่
        $aResCalDTTmp   = $this->FSnCTXICalulateDTTemp($tXthDocNo, $tXthVATInOrEx, $tTXIDocType);

        //Edit in line
        $tPdtCode      = $this->input->post('ptPdtCode');
        $tPunCode      = $this->input->post('ptPunCode');
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $aColumnShow    = FCNaDCLGetColumnShow($tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType) . 'DT');

        $aDataDT        = $this->mTransferreceipt->FSaMTXIGetDTTemp($aDataWhere);
        $aDataDTSum     = $this->mTransferreceipt->FSaMTWISumDTTemp($aDataWhere);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['aDataDT']           = $aDataDT;
        $aData['aDataDTSum']        = $aDataDTSum;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['tXthStaApv']        = $tXthStaApv;
        $aData['tXthStaDoc']        = $tXthStaDoc;

        $this->load->view('document/transferreceipt/advancetable/wTransferreceiptPdtAdvTableData', $aData);
    }


    //Function : Adv Table Load Data
    public function FSvCTXIVatLoadData()
    {

        $tTXIDocType    = $this->input->post('tTXIDocType');
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthVATInOrEx  = $this->input->post('tXthVATInOrEx');

        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        // //คำนวน DT ใหม่
        $aResCalDTTmp   = $this->FSnCTXICalulateDTTemp($tXthDocNo, $tXthVATInOrEx, $tTXIDocType);

        $aDataVatDT     = $this->mTransferreceipt->FSaMTWIGetVatDTTemp($tXthDocNo);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aDataVatDT']        = $aDataVatDT;
        $aData['tXthVATInOrEx']     = $tXthVATInOrEx;

        $this->load->view('document/transferreceipt/advancetable/wTransferreceiptVatTableData', $aData);
    }

    //Function : Adv Table Save
    public function FSvCTXIShowColSave()
    {

        $tTXIDocType    = $this->input->post('tTXIDocType');
        $tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType);

        FCNaDCLSetShowCol($tTblSelectData . 'DT', '', '');

        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        if ($nStaSetDef == 1) {
            FCNaDCLSetDefShowCol($tTblSelectData . 'DT');
        } else {
            for ($i = 0; $i < FCNnHSizeOf($aColShowSet); $i++) {
                FCNaDCLSetShowCol($tTblSelectData . 'DT', 1, $aColShowSet[$i]);
            }
        }
        //Reset Seq
        FCNaDCLUpdateSeq($tTblSelectData . 'DT', '', '', '');
        $q = 1;
        for ($n = 0; $n < FCNnHSizeOf($aColShowAllList); $n++) {

            FCNaDCLUpdateSeq($tTblSelectData . 'DT', $aColShowAllList[$n], $q, $aColumnLabelName[$n]);
            $q++;
        }
    }

    //Function : Adv Table Show
    public function FSvCTXIAdvTblShowColList()
    {

        $tTXIDocType    = $this->input->post('tTXIDocType');
        $tTblSelectData = $this->FStCTXISwitchDatabase($tTXIDocType);

        $aAvailableColumn = FCNaDCLAvailableColumn($tTblSelectData . 'DT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/transferreceipt/advancetable/wTransferreceiptTableShowColList', $aData);
    }



    //////////////////////////////////////////////////////////////////////////   Zone ค้นหา
    //Function : ค้นหา รายการ
    public function FSxCTXIFormSearchList()
    {

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMBranch_L');
        $nLangHave      = FCNnHSizeOf($aLangHave);

        if ($nLangHave > 1) {
            if ($nLangEdit != '') {
                $nLangEdit = $nLangEdit;
            } else {
                $nLangEdit = $nLangResort;
            }
        } else {
            if (@$aLangHave[0]->nLangList == '') {
                $nLangEdit = '1';
            } else {
                $nLangEdit = $aLangHave[0]->nLangList;
            }
        }

        $aData  = array(
            'FTBchCode'        => $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'        => '',
            'nPage'         => 1,
            'nRow'          => 9999,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aShpData = $this->mShop->FSaMSHPList($aData);

        $aDataMaster = array(
            'aBchData'   => $aBchData,
            'aShpData'   => $aShpData,
            'tUserLoginBchCode'        => $this->session->userdata("tSesUsrBchCode"),
            'tUserLoginBchName'        => $this->session->userdata("tSesUsrBchName")
        );

        $this->load->view('document/transferreceipt/wTransferreceiptFormSearchList', $aDataMaster);
    }



    function FStCTXISwitchDatabase($tTXIDocType)
    {
        switch ($tTXIDocType) {
            case 'WAH':
                $tTblSelectData = "TCNTPdtTwi";
                break;
            case 'BCH':
                $tTblSelectData = "TCNTPdtTbi";
                break;
        }
        return $tTblSelectData;
    }
}
