<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cProducttransferwahousevd extends MX_Controller {
    
	public function __construct() {
            parent::__construct ();
            $this->load->helper("file");
            $this->load->model('company/company/mCompany');
            $this->load->model('company/branch/mBranch');
            $this->load->model('company/shop/mShop');
            $this->load->model('payment/rate/mRate');
            $this->load->model('company/vatrate/mVatRate');
            $this->load->model('document/adjuststockvd/mProducttransferwahousevd');
            date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEvent']       = FCNaHCheckAlwFunc('ADJSTKVD/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('ADJSTKVD/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        //Get Option Show Decimal
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave(); 
        
        $this->load->view('document/adjuststockvd/wProducttransferwahousevd',$aData);

    }


    //Function : คำนวน Record ใหม่ถ้ามีการ Add และ Del Row ของ HDDis
    public function FCNoTFWCalculaterAFTAddHDDis($ptXthDocNo){

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($ptXthDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        //Dis
        $cXthDisVat         = 0;
        $cXthDisNoVat       = 0;
        $cXthVatDisChgAvi   = 0;
        $cXthNoVatDisChgAvi = 0;
        //Chg
        $cXthChgVat     = 0;
        $cXthChgNoVat   = 0;
        
        //หา cXthVatDisChgAvi Sum ออกมาจาก DT
        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            foreach($aDataFile['DTData'] AS $key => $value){
                //สถานะอนุญาต ลด/ชาร์จ
                if($value['FTXpdStaAlwDis'] == 1){
                    //ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                    if($value['FTXpdVatType'] == 1){
                        //คำนวนยอดมีภาษีลดได้ FTXpdVatType=1 : SUM(DT.FCXpdDisChgAvi)
                        $cXthVatDisChgAvi   = $cXthVatDisChgAvi + $value['FCXpdNet'];
                    }else if($value['FTXpdVatType'] == 2){
                        $cXthNoVatDisChgAvi = $cXthNoVatDisChgAvi + $value['FCXpdNet'];
                    }
                }
            }
        }
        
        if(FCNnHSizeOf($aDataFile['HDData']) > 0){

            foreach($aDataFile['HDData'] AS $key=>$aValue){
                
                $aResCalDisChgTxt = $this->FMcCTFWCalulateDisChgText($aValue['FTXthDisChgTxt'],$cXthVatDisChgAvi);

                //โปเลทส่วนลด
                if($aResCalDisChgTxt['CALFCXddDis'] > 0){
                    //check ตัวแปรว่าเป็น 0 หรือไม่ ถ้าเป็น 0 จะทำให้หารไม่ได้
                    $A = $aResCalDisChgTxt['CALFCXddDis']*$cXthVatDisChgAvi;
                    $B = $cXthVatDisChgAvi+$cXthNoVatDisChgAvi;
                    if($A == 0 && $B == 0){
                        $cXthDisVat = 0;
                    }else{
                        $cXthDisVat = ($aResCalDisChgTxt['CALFCXddDis']*$cXthVatDisChgAvi)/($cXthVatDisChgAvi+$cXthNoVatDisChgAvi);
                    }
                    
                    $cXthDisNoVat   = $aResCalDisChgTxt['CALFCXddDis']-$cXthDisVat;
                    
                    $aDataFile['HDData'][$key]['FCXthDis']     = number_format($aResCalDisChgTxt['CALFCXddDis'], $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthChg']     = number_format($aResCalDisChgTxt['CALFCXddChg'], $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthVatDisChgAvi']     = number_format($cXthVatDisChgAvi, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthNoVatDisChgAvi']   = number_format($cXthNoVatDisChgAvi, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthDisVat']           = number_format($cXthDisVat, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthDisNoVat']         = number_format($cXthDisNoVat, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthChgVat']           = number_format(0, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthChgNoVat']         = number_format(0, $nOptDecimalSave, '.', '');

                    //set ค่าทับตัวแปร
                    $cXthVatDisChgAvi = $cXthVatDisChgAvi-$cXthDisVat;
                    $cXthNoVatDisChgAvi = $cXthNoVatDisChgAvi-$cXthDisNoVat;
                }else{
                    //โปเลทชาร์จ

                    //check ตัวแปรว่าเป็น 0 หรือไม่ ถ้าเป็น 0 จะทำให้หารไม่ได้
                    $A = $aResCalDisChgTxt['CALFCXddChg']*$cXthVatDisChgAvi;
                    $B = $cXthVatDisChgAvi+$cXthNoVatDisChgAvi;
                    if($A == 0 && $B == 0){
                        $cXthChgVat = 0;
                    }else{
                        $cXthChgVat     = $aResCalDisChgTxt['CALFCXddChg']*$cXthVatDisChgAvi/($cXthVatDisChgAvi+$cXthNoVatDisChgAvi);
                    }
                    
                    $cXthChgNoVat   = $aResCalDisChgTxt['CALFCXddChg']-$cXthChgVat;
                    
                    $aDataFile['HDData'][$key]['FCXthDis']     = number_format($aResCalDisChgTxt['CALFCXddDis'], $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthChg']     = number_format($aResCalDisChgTxt['CALFCXddChg'], $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthVatDisChgAvi']     = number_format($cXthVatDisChgAvi, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthNoVatDisChgAvi']   = number_format($cXthNoVatDisChgAvi, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthChgVat']           = number_format($cXthChgVat, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthChgNoVat']         = number_format($cXthChgNoVat, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXthDisVat']           = number_format(0, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXthDisNoVat']         = number_format(0, $nOptDecimalSave, '.', '');

                    //set ค่าทับตัวแปร
                    $cXthVatDisChgAvi = $cXthVatDisChgAvi+$cXthChgVat;
                    $cXthNoVatDisChgAvi = $cXthNoVatDisChgAvi+$cXthChgNoVat;
                }

            }

        }

        $jDataArray = json_encode($aDataFile);
        if($ptXthDocNo != ''){
            //PATHSupawat
            $fp = fopen(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
            file_put_contents(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
            fclose($fp);
            return 1;
        }

    }

    //Function : คำนวนลดท้าบบิล HD ถ้ามีท้ายบอลจะ Add ลงตาราง DT FNXpdStaDis 2
    public function FCNoTFWAdjDTDisAFTAdjHDDis($ptXthDocNo){

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($ptXthDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $cXpdNetSUM = 0;
        $cXpdDisChgAvi = 0;
        
        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            //Get  หา Sum FCXpdNet
            foreach($aDataFile['DTData'] AS $DTkey=>$aDTValue){
                //สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                if($aDTValue['FTXpdStaAlwDis'] == 1){
                    $cXpdNetSUM = $cXpdNetSUM + $aDTValue['FCXpdNet'];
                    //Remove FNXpdStaDis 2 ออก
                    foreach($aDTValue['DTDiscount'] AS $DTDisKey => $DTDisValue){
                        //สั่งลบ FNXpdStaDis == 2 เพราะ จะ get ใหม่ ไม่งั้นจะ ทับกัน
                        if($DTDisValue['FNXpdStaDis'] == 2){
                            //สั่งลบ
                            unset($aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDisKey]);
                        }
                    }
                }
            }
        }

        if(FCNnHSizeOf($aDataFile['HDData']) > 0){
            foreach($aDataFile['HDData'] AS $HDDiskey => $HDDisValue){
                //Set Variable
                $i = 0;
                $len = FCNnHSizeOf($aDataFile['DTData']);
                $cXddDis_Sta2 = 0;
                $cXddChg_Sta2 = 0;
                $cXddDis_Sta2SUM = 0;
                $cXddChg_Sta2SUM = 0;

                //คำนวน ท้ายบิล โปรเลท ให้ DTDis
                if(FCNnHSizeOf($aDataFile['DTData']) > 0){
                    foreach($aDataFile['DTData'] AS $DTkey=>$aDTValue){
                        //Check สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                        if($aDTValue['FTXpdStaAlwDis'] == 1){

                            if ($i != $len-1) {
                                // first
                                if($HDDisValue['FCXthDis'] > 0){
                                    //ถ้าเป็น Dis
                                    $A = $HDDisValue['FCXthDis']*$aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if($A == 0 && $B == 0){
                                        $cXddDis_Sta2 = 0;
                                    }else{
                                        $cXddDis_Sta2 = ($HDDisValue['FCXthDis']*$aDTValue['FCXpdNet'])/$cXpdNetSUM;
                                    }
                                    $cXddChg_Sta2 = 0;

                                    $cXddDis_Sta2SUM = number_format($cXddDis_Sta2SUM+$cXddDis_Sta2, $nOptDecimalSave, '.', '');
                                }else{
                                    //ถ้าเป็น Chg
                                    $A = $HDDisValue['FCXthChg']*$aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if($A == 0 && $B == 0){
                                        $cXddChg_Sta2 = 0;
                                    }else{
                                        $cXddChg_Sta2 = ($HDDisValue['FCXthChg']*$aDTValue['FCXpdNet'])/$cXpdNetSUM;
                                    }
                                    $cXddDis_Sta2 = 0;

                                    $cXddChg_Sta2SUM = number_format($cXddChg_Sta2SUM+$cXddChg_Sta2, $nOptDecimalSave, '.', '');
                                }
                                
                            } else if ($i == $len-1) {
                                // last
                                if($HDDisValue['FCXthDis'] > 0){
                                    //ถ้าเป็น Dis
                                    $cXddDis_Sta2 = $HDDisValue['FCXthDis']-$cXddDis_Sta2SUM;
                                    $cXddChg_Sta2 = 0;
                                }else{
                                    //ถ้าเป็น Chg
                                    $cXddDis_Sta2 = 0;
                                    $cXddChg_Sta2 = $HDDisValue['FCXthChg']-$cXddChg_Sta2SUM;
                                }
                            }

                            $cXddDis_Sta2 = number_format($cXddDis_Sta2, $nOptDecimalSave, '.', '');
                            $cXddChg_Sta2 = number_format($cXddChg_Sta2, $nOptDecimalSave, '.', '');

                            $aDataSta2 = array(
                                'FTBchCode'         => $aDTValue['FTBchCode'],
                                'FTXthDocNo'        => $aDTValue['FTXthDocNo'],
                                'FNXpdSeqNo'        => $aDTValue['FNXpdSeqNo'],
                                'FDXddDateIns'      => $HDDisValue['FDXthDateIns'],
                                'FNXpdStaDis'       => 2,//ลดท้ายบิล จะเป็น 2 
                                'FCXddDisChgAvi'    => '0', //ยังไม่ปรับ -> ปรับ foreach ข้างล่าง
                                'FTXddDisChgTxt'    => $HDDisValue['FTXthDisChgTxt'],
                                'FCXddDis'          => $cXddDis_Sta2,
                                'FCXddChg'          => $cXddChg_Sta2,
                                'FTXddUsrApv'       => $this->session->userdata('tSesUsername'),
                            );
                            // ADD Sta 2 ลดท้ายบิล
                            array_push($aDataFile['DTData'][$DTkey]['DTDiscount'],$aDataSta2);

                            $i++;
                        }

                    }
                }
            }
          
        }

        
        //ปรับ FCXddDisChgAvi โดยการคำนวนใหม่
        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            foreach($aDataFile['DTData'] AS $DTkey=>$aDTValue){
                //Check สถานะอนุญาต ลด/ชาร์จ  1:อนุญาต , 2:ไม่อนุญาต
                if($aDTValue['FTXpdStaAlwDis'] == 1){
                    //มูลค่าลดได้  กรณีอนุญาตลด (Qty*SetPrice) ไม่อนุญาต เป็น 0 (ปรับเมื่อมีการลดชาร์จ DT/HD)
                    $cXpdDisChgAvi = $aDTValue['FCXpdQty']*$aDTValue['FCXpdSetPrice'];

                    foreach($aDTValue['DTDiscount'] AS $DTDiskey => $DTDisValue){

                        $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddDisChgAvi'] = $cXpdDisChgAvi;

                        //เปลี่ยนค่าใหม่ หลัวจากคำนวน 
                        // ลด DTDis
                        if($DTDisValue['FNXpdStaDis'] == 1){
                            //ส่งไปคำนวน Dis , Chg ใหม่
                            $aResCalDisChgTxt = $this->FMcCTFWCalulateDisChgText($DTDisValue['FTXddDisChgTxt'],$cXpdDisChgAvi);
                            $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddDis'] = $aResCalDisChgTxt['CALFCXddDis'];
                            $aDataFile['DTData'][$DTkey]['DTDiscount'][$DTDiskey]['FCXddChg'] = $aResCalDisChgTxt['CALFCXddChg'];

                            // //set ค่าทับ ยอดลดได้ ก่อนลด (DT.FCXpdDisChgAvi)
                            if($aResCalDisChgTxt['CALFCXddDis'] > 0){
                                $cXpdDisChgAvi = $cXpdDisChgAvi-$aResCalDisChgTxt['CALFCXddDis'];
                            }else{
                                $cXpdDisChgAvi = $cXpdDisChgAvi+$aResCalDisChgTxt['CALFCXddChg'];
                            }
                        }else{
                        // ลด HDDis 
                            if($DTDisValue['FCXddDis'] > 0){
                                $cXpdDisChgAvi = $cXpdDisChgAvi-$DTDisValue['FCXddDis'];
                            }else{
                                $cXpdDisChgAvi = $cXpdDisChgAvi+$DTDisValue['FCXddChg'];
                            }
                        }

                    }
                    
                }

            }
        }


        $jDataArray = json_encode($aDataFile);
        if($ptXthDocNo != ''){
            $fp = fopen(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
            file_put_contents(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
            fclose($fp);
            return 1;
        }

    }

    //Function : ปรับ DisChg Text 
    public function FMcCTFWCalulateDisChgText($ptDisChgText,$ptDisChgAvi){

        if($ptDisChgText != ''){
            $nLen  = strlen($ptDisChgText);

            $tStrlast = substr($ptDisChgText,$nLen-1);
            $tStr1    = $ptDisChgText[0];

            if($tStrlast != '%'){

                if($tStr1 != '+'){
                //ลด
                $nCalucateDis = $ptDisChgText;
                $nCalucateChg = 0;
                $cAFCalPrice  = $ptDisChgAvi - $ptDisChgText;
                $tDisChgValue = $ptDisChgText;
                }else{
                //ชาร์จ
                $nDistext = explode("+",$ptDisChgText);
                $nCalucateDis = 0;
                $nCalucateChg = $nDistext[1];
                $cAFCalPrice  = $ptDisChgAvi + $nDistext[1];
                $tDisChgValue = $nDistext[1];
                }
                $ptDisChgAvi = $cAFCalPrice; 

            }else{

                $nDistext = explode("%",$ptDisChgText);
                $nCalucatePercent = ($nDistext[0]*$ptDisChgAvi)/100;

                if($tStr1 != '+'){
                //ลด
                $nCalucateDis = $nCalucatePercent;
                $nCalucateChg = 0;
                $cAFCalPrice  = $ptDisChgAvi - $nCalucatePercent;
                $tDisChgValue = $nDistext[0];
                }else{
                //ชาร์จ
                $nCalucateDis = 0;
                $nCalucateChg = $nCalucatePercent;
                $cAFCalPrice = $ptDisChgAvi + $nCalucatePercent;
                $tDisChgValue = substr($nDistext[0],1) ;
                }
                $ptDisChgAvi = $cAFCalPrice; 

            }

            $aArray= array(
                'CALFCXddDis' => floatval($nCalucateDis),
                'CALFCXddChg' => floatval($nCalucateChg),
            );

        return $aArray;
            
        }
        
    }

    //Function : Check Checkbox return num
    public function FSsCReturnCheckBox($ptStaus){

        if($ptStaus == 'on'){
            return 1;
        }else{
            return 0;
        }
    }

    //Function : Check Date Is Null
    public function FStCCheckDateNULL($pdDate){

        if($pdDate == ''){
            return NULL;
        }else{
            return $pdDate;
        }
    }



    //////////////////////////////////////////////////////////////////////////   Zone Get ค่า
    //Function : Get Data From File เป็น Center
    public function FMaTFWGetDataFormFile($ptXthDocNo){
        if($ptXthDocNo != ''){
            //Get Data From File
            $jData = file_get_contents(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt");
            // decode json to array
            $aDataFile = json_decode($jData, true);

            return $aDataFile;
        }
    }

    //Function : Get ที่อยู่
    public function FSvCTFWGetShipAdd(){

        $tBchCode       = $this->input->post('tBchCode');
        $tXthShipAdd    = $this->input->post('tXthShipAdd');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
        //     if($nLangEdit != ''){
        //         $nLangEdit = $nLangEdit;
        //     }else{
        //         $nLangEdit = $nLangResort;
        //     }
        // }else{
        //     if(@$aLangHave[0]->nLangList == ''){
        //         $nLangEdit = '1';
        //     }else{
        //         $nLangEdit = $aLangHave[0]->nLangList;
        //     }
        // }

        $aDataShipAdd = $this->mProducttransferwahousevd->FSaMTFWGetAddress($tBchCode,$tXthShipAdd,$nLangEdit); 

        echo json_encode($aDataShipAdd);

    }

    // Function : วาด Modal HDDis HTML ส่วนลดท้ายบิล
    public function FSvCTFWGetHDDisTableData(){

        $tXthDocNo      = $this->input->post('tXthDocNo');
        $nXthVATInOrEx  = $this->input->post('nXthVATInOrEx');
        $nXthRefAEAmt   = $this->input->post('nXthRefAEAmt');
        $nXthVATRate    = $this->input->post('nXthVATRate');
        $nXthWpTax    = $this->input->post('nXthWpTax');

        //คำนวนใน File ใหม่ ก่อนดึงไฟล์
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 
        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        $cXthTotal = 0;
        // ยอดรวมก่อนลด SUM(DT.FCXpdNet)
        foreach($aDataFile['DTData'] AS $DTKey => $DTValue){
            $cXthTotal = $cXthTotal+$DTValue['FCXpdNet'];
        }

        
        $aData['nOptDecimalShow']= $nOptDecimalShow;
        $aData['aDataFile']     = $aDataFile;
        $aData['cXthTotal']     = $cXthTotal;
        $aData['nXthVATInOrEx'] = $nXthVATInOrEx;
        $aData['cXthRefAEAmt']  = $nXthRefAEAmt;
        $aData['nXthVATRate']   = $nXthVATRate;
        $aData['nXthWpTax']     = $nXthWpTax;

        $this->load->view('document/adjuststockvd/advancetable/wProducttransferwahouseHDDisTableDatavd',$aData);

    }

    // Function : วาด Modal DTDis HTML ส่วนลดรายการ
    public function FSvCTFWGetDTDisTableData(){

        $nKey       = $this->input->post('nKey');
        $tXthDocNo  = $this->input->post('tDocNo');
        $nPdtCode   = $this->input->post('nPdtCode');
        $nPunCode   = $this->input->post('nPunCode');
        $nSeqNo     = $this->input->post('nSeqNo');
        
        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo);

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
    
        $aData['nOptDecimalShow'] = $nOptDecimalShow;
        $aData['nKey'] = $nKey;
        $aData['aDataFile'] =  $aDataFile['DTData'];
        $aData['nXpdSeqNo'] = $aDataFile['DTData'][$nKey]['FNXpdSeqNo'];
        $aData['cXpdSetPrice'] = $aDataFile['DTData'][$nKey]['FCXpdSetPrice'];
        $aData['cXpdDisChgAvi'] = $aDataFile['DTData'][$nKey]['FCXpdDisChgAvi'];
        $aData['aDTDiscount']  = $aDataFile['DTData'][$nKey]['DTDiscount'];
        $aData['nPdtCode']  = $nPdtCode;
        $aData['nPunCode']  = $nPunCode;
        $aData['nSeqNo']  = $nSeqNo;

        $this->load->view('document/adjuststockvd/advancetable/wProducttransferwahouseDTDisTableDatavd',$aData);

    }

    //Function : get ร้านค้า ใน สาขา
    public function FSvCTFWGetShpByBch(){

        $tBchCode = $this->input->post('ptBchCode');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMShop_L');
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
            'FTBchCode' 	=> $tBchCode,
            'FTShpCode' 	=> '',
            'nPage'         => 1,
            'nRow'          => '9999',
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );
        
        $aShpData = $this->mShop->FSaMSHPList($aData);
        
        echo json_encode($aShpData);

    }


    //Function : Get สินค้า ตาม Pdt BarCode
    public function FSvCTFWGetPdtBarCode(){

        $tBarCode = $this->input->post('tBarCode');
        $tSplCode = $this->input->post('tSplCode');

        $aPdtBarCode =  FCNxHGetPdtBarCode($tBarCode,$tSplCode);

        if($aPdtBarCode != 0){
            $jPdtBarCode = json_encode($aPdtBarCode);
            $aData  = array(
                'aData' => $jPdtBarCode,
                'tMsg' 	=> 'OK',
            );
        }else{
            $aData  = array(
                'aData' => 0,
                'tMsg' 	=> language('document/browsepdt/browsepdt', 'tPdtNotFound'),
            );
        }

        $jData = json_encode($aData);

        echo $jData;
    }




    //////////////////////////////////////////////////////////////////////////   Zone Set ค่า
    //Function : Set Session ให้กับ Vat ว่าเป็น รวมในหรือ แยกนอก เพื่อใช้ในการคำนวนใหม่ตอนเลือก Vat 
    public function FSvCTFWSetSessionVATInOrEx(){
        
        $ptXthDocNo = $this->input->post('ptXthDocNo');
        $tXthVATInOrEx = $this->input->post('tXthVATInOrEx');

        $this->session->set_userdata ("tTFWSesVATInOrEx".$ptXthDocNo, $tXthVATInOrEx);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($ptXthDocNo); 
    }




    //////////////////////////////////////////////////////////////////////////   Zone แก้ไข
    //Functionality : Event Edit Master
    public function FSaCTFWEditEvent(){
        try{
            $dXthDocDate = $this->input->post('oetXthDocDate')." ".$this->input->post('oetXthDocTime');
            $aDataMaster = array(
                //'tIsAutoGenCode'        => $this->input->post('ocbTFWAutoGenCode'),
                'FTBchCode'             => $this->input->post('ohdBchCode'),  
                'FTAjhDocNo'            => $this->input->post('oetXthDocNo'),
                'FDAjhDocDate'          => $dXthDocDate,
                'FTAjhBchTo'            => $this->input->post('oetBchCode'),
                'FTAjhMerchantTo'       => $this->input->post('oetMchCode'),
                'FTAjhShopTo'           => $this->input->post('oetShpCodeStart'),
                'FTAjhPosTo'            => $this->input->post('oetPosCodeStart'),
                'FTAjhWhTo'             => $this->input->post('ohdWahCodeStart'),
                'FTAjhPlcCode'          => "",
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTRsnCode'             => $this->input->post('oetASTRsnCode'),
                'FTAjhRmk'              => $this->input->post('otaTfwRmk'),
                'FNAjhDocPrint'         => 0,
                'FTAjhApvSeqChk'        => '3',
                'FTAjhApvCode'          => '',
                'FTAjhStaApv'           => '',  
                'FTAjhStaPrcStk'        => '',  
                'FTAjhStaDoc'           => 1,   
                'FNAjhStaDocAct'        => $this->input->post('ocbXthStaDocAct'),
                'FTAjhDocRef'           => '', 
                'FTAjhStaDelMQ'         => '', 
                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
            $aDataWhere = array(
                'FTXthDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     =>  $this->input->post('ohdBchCode'),
                'FTXthDocKey'   =>'TCNTPdtAdjStkHD',
                'nLangID'   => $nLangEdit
            );

            $this->db->trans_begin();
            $aStaSdtOrdHD               = $this->mProducttransferwahousevd->FSaMTFWAddUpdateHD($aDataMaster);
            $aStaEventDocNoInDocTemp    = $this->mProducttransferwahousevd->FSaMTFWAddUpdateDocNoInDocTemp($aDataWhere);    //Update DocNo ในตาราง Doctemp
            $aResInsDT      =  $this->mProducttransferwahousevd->FSaMTFWInsertTmpToDT($aDataWhere);
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
   
    }


  

    //Function : Get DT Sum In to Tmp
    public function FSaMTFWSumDTIntoHD($ptXthDocNo){

        $tXthDocNo      =   $ptXthDocNo;
        $tXthVATInOrEx  =   $this->input->post('ostXthVATInOrEx');

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 
    
        $aData  = array(
            'FTXthDocNo'    => $tXthDocNo,
            'nRow'          => 10000,
            'nPage'         => 1,
        );

        $aDataDT    =   $this->mProducttransferwahousevd->FSaMTFWGetDT($aData); //*ลบ Data เก่าออก*/

        $FCXthTotal = 0;

        if($aDataDT['rtCode'] == 1){
            
            $aDataDT = $aDataDT['raItems'];
            foreach ($aDataDT as $key => $value){
                //รวมใน 
                if($tXthVATInOrEx == 1){
                    $FCXthTotal += $value['FCXtdVat']+$value['FCXtdVatable'];
                }else{
                //แยกนอก
                    $FCXthTotal +=$value['FCXtdVat'];
                }
            }
        }

        $aDataUpdHD = array(
            'FCXthTotal' => number_format($FCXthTotal,$nOptDecimalSave,'.','')
        );

        $aDataDT    =   $this->mProducttransferwahousevd->FSaMTFWUpdateHDFCXthTotal($aDataUpdHD,$tXthDocNo); //*ลบ Data เก่าออก*/
        
    }

    //Function : แก้ไข Pdt DT
    public function FSvCTFWEditPdtIntoTableDT(){

        // $tXthDocNo  = $this->input->post('ptXthDocNo');
        // $tEditSeqNo = $this->input->post('ptEditSeqNo');
        // $aField 	= $this->input->post('paField');
        // $aValue 	= $this->input->post('paValue');

        // //Get Data From File
        // $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        // //Get Option Show Decimal  
        // $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        // $Array = array();

        // foreach ($aDataFile['DTData'] as $key => $value) {
        //     if($value['FNXpdSeqNo'] == $tEditSeqNo){
        //         foreach($aField AS $FKey => $FValue){
        //             $aDataFile['DTData'][$key][$FValue] = ($aValue[$FKey] != '') ? $aValue[$FKey] : 0 ;
        //         }
        //     }
        // }

        // //PATHSupawat
        // $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        // file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", json_encode($aDataFile));
        // fclose($fp);
        
        // // //คำนวนใน File ใหม่
        // $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 


        $tXthDocNo      = $this->input->post('ptXthDocNo');
        $tEditSeqNo     = $this->input->post('ptEditSeqNo');
        $aField 	    = $this->input->post('paField');
        $aValue 	    = $this->input->post('paValue');

        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FNXtdSeqNo'    => $tEditSeqNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );

        $aDataUpdateDT = array();

        foreach($aField as $key => $FieldName){
            $aDataUpdateDT[$FieldName] = $aValue[$key];
        }

        //Edit Inline
        $aResUpdDTTmpInline     = $this->mProducttransferwahousevd->FSnMTFWUpdateInlineDTTemp($aDataUpdateDT,$aDataWhere);

    }

    //Function : Edit Inline DTDis แก้ไข ส่วนลด ท้ายบิล
    public function FSvCTFWEditHDDis(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXthDocNo      = $this->input->post('oetSearchAll');
        $tIndex         = $this->input->post('tIndex');
        $tDisChgText    = $this->input->post('tHDDisChgType');
        $cXddDisValue   = $this->input->post('tHDDisChgValue');

        $cXddDisValue = number_format($cXddDisValue, $nOptDecimalSave, '.', '');

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        switch ($tDisChgText) {
            case 1: //ชาร์จบาท 
                $tDisChgTxt = "+".$cXddDisValue;
                break;
            case 2: //ชาร์จ %
                $tDisChgTxt = "+".$cXddDisValue."%";
                break;
            case 3: //ลดบาท
                $tDisChgTxt = $cXddDisValue;
                break;
            case 4: //ลด %
                $tDisChgTxt = $cXddDisValue."%";
                break;
            
            default:
                $tDisChgTxt = $cXddDisValue;
        }

        //put ค่าใหม่ใส่ Array ตัวเดิม
        $aDataFile['HDData'][$tIndex]['FTXthDisChgTxt'] = $tDisChgTxt;

        //Add ลงไฟล์
        $jDataArray = json_encode($aDataFile);
        //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }

    //Function : Edit Inline DTDis แก้ไข ส่วนลด รายการสินค้า
    public function FSvCTFWEditDTDis(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $nKey           = $this->input->post('nKey');
        $tXthDocNo      = $this->input->post('tDocNo');
        $tIndex         = $this->input->post('tIndex');
        $tDisChgText    = $this->input->post('tDTDisChgType');
        $cXddDisValue = $this->input->post('tDTDisChgValue');

        $cXddDisValue = number_format($cXddDisValue, $nOptDecimalSave, '.', '');

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        switch ($tDisChgText) {
            case 1: //ชาร์จบาท 
                $tDisChgTxt = "+".$cXddDisValue;
                break;
            case 2: //ชาร์จ %
                $tDisChgTxt = "+".$cXddDisValue."%";
                break;
            case 3: //ลดบาท
                $tDisChgTxt = $cXddDisValue;
                break;
            case 4: //ลด %
                $tDisChgTxt = $cXddDisValue."%";
                break;
            
            default:
                $tDisChgTxt = $cXddDisValue;
        }

        //put ค่าใหม่ใส่ Array ตัวเดิม
        $aDataFile['DTData'][$nKey]['DTDiscount'][$tIndex]['FTXddDisChgTxt'] = $tDisChgTxt;

        //Add ลงไฟล์
        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }

    //Function : คำนวน ยอดต่างๆ ของ HD ใหม่ เพราะ DT เปลี่ยน 
    public function FSnTFWUpdateHD(){
        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 
        
        $tXthDocNo      = $this->input->post('oetSearchAll');
        $oetXthWpTax    = $this->input->post('oetFCXthWpTaxInput');

        //Get ค่า VATRate
        $cVatRate = $this->mProducttransferwahousevd->FScMTFWGetVatRateFromDoc($tXthDocNo);

        //Get ค่า VAT InOrEx
        $tXthVATInOrEx = $this->mProducttransferwahousevd->FCNxTFWGetvatInOrEx($tXthDocNo);

        //get จาก DT
        //ยอดรวมก่อนลด
        $cXthTotal          = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthTotal($tXthDocNo); 
        //ยอดรวมมีภาษีห้ามลด
        $cXthVatNoDisChg    = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthVatNoDisChg($tXthDocNo); 
        // echo "ยอดรวมมีภาษีห้ามลด :".$cXthVatNoDisChg."<br>";
        //ยอดรวมไม่มีภาษีห้ามลด
        $cXthNoVatNoDisChg  = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthNoVatNoDisChg($tXthDocNo); 
        // echo "ยอดรวมไม่มีภาษีห้ามลด :".$cXthNoVatNoDisChg."<br>";
        //ยอดมีภาษีลดได้ 
        $cXthVatDisChgAvi   = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthVatDisChgAvi($tXthDocNo); 
        // echo "ยอดมีภาษีลดได้ :".$cXthVatDisChgAvi."<br>";
        //ยอดไม่มีภาษีลดได้ 
        $cXthNoVatDisChgAvi = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthNoVatDisChgAvi($tXthDocNo); 
        // echo "ยอดไม่มีภาษีลดได้ :".$cXthNoVatDisChgAvi."<br>";
    
        //ข้อมูลการ ลด ชาร์จ
        $aXthDisChgTxt = $this->mProducttransferwahousevd->FSaMTFWGetHDFTXthDisChgTxt($tXthDocNo); 
        $tDisChgTxt = '';
        if($aXthDisChgTxt != 0){
            foreach ($aXthDisChgTxt as $key => $value) {
                $tDisChgTxt .=  $value->FTXthDisChgTxt.',';
            }
            $tDisChgTxt = substr($tDisChgTxt, 0, -1);
        }

        //get จาก HDDis
        //มูลค่ารวมส่วนลด
        $cXthDis            = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthDis($tXthDocNo); 
        //มูลค่ารวมส่วนชาร์จ
        $cXthChg            = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthChg($tXthDocNo); 

        //ยอดรวมมีภาษีหลังลด FCXthVatDisChgAvi-SUM(HDis.FCXddDisVat-HDis.FCXddChgVat)
        //Get SUM(HDis.FCXddDisVat-HDis.FCXddChgVat)
        $cXthDisRes    = $this->mProducttransferwahousevd->FSaMTFWGetSUMFCXddDisVatMinusFCXddChgVat($tXthDocNo);
        $cXthVatAfDisChg    = $cXthVatDisChgAvi-$cXthDisRes;
        // echo "ยอดรวมมีภาษีหลังลด :".$cXthVatAfDisChg."<br>";

        //ยอดรวมไม่มีภาษีหลังลด
        $cXthNoVatAfDisChg  = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthNoVatAfDisChg($tXthDocNo);
        // echo $cXthNoVatAfDisChg."<br>";

        //ยอดมัดจำ 
        $cFCXthRefAEAmt  = $this->mProducttransferwahousevd->FSaMTFWGetFCXthRefAEAmt($tXthDocNo);
        // echo "ยอดมัดจำ :".$cFCXthRefAEAmt."<br>";

        //ยอดรวมหลัง ลด-ชาร์จ+มัดจำ (FCXthVatNoDisChg+FCXthNoVatNoDisChg)+(FCXthVatAfDisChg+FCXthNoVatAfDisChg)-FCXthRefAEAmt
        $cXthAfDisChgAE = ($cXthVatNoDisChg+$cXthNoVatNoDisChg)+($cXthVatAfDisChg+$cXthNoVatAfDisChg)-$cFCXthRefAEAmt;
        // echo "Result:".$cXthAfDisChgAE;

        //ยอดภาษี (FCXthVatNoDisChg+FCXthVatAfDisChg) In/Ex
        $cResSum = $cXthVatNoDisChg+$cXthVatAfDisChg-$cFCXthRefAEAmt;
        if($tXthVATInOrEx == 1){
            //In รวมใน 
            $cXthVat = $cResSum-(($cResSum*100)/(100+$cVatRate));
        }else{
            //Ex แยกนอก
            $cXthVat = (($cResSum*(100+$cVatRate))/100)-$cResSum;
        }

        //ยอดแยกภาษี (FCXthVatNoDisChg+FCXthVatAfDisChg)-FCXthVat
        $cXthVatable = ($cXthVatNoDisChg+$cXthVatAfDisChg-$cFCXthRefAEAmt)-$cXthVat;

        //ยอดรวมสุทธิ ก่อน ภาษี ณ ที่จ่าย IN:FCXthVat+FCXthVatable , EX : FCXthAfDisChgAE+FCXthVat
        if($tXthVATInOrEx == 1){
            //IN: FCXthVat+FCXthVatable
            $cXthGrandB4Wht = $cXthVat+$cXthVatable;
        }else{
            //EX : FCXthAfDisChgAE+FCXthVat
            $cXthGrandB4Wht = $cXthAfDisChgAE+$cXthVat;
        }
        
        if($oetXthWpTax != ''){
            // ภาษีหัก ณ ที่จ่าย SUM(FCXpdWhtAmt)  /Key In
            $cXthWpTax = $oetXthWpTax;
        }else{
            $cXthWpTax = $this->mProducttransferwahousevd->FSaMTFWGetHDFCXthWpTax($tXthDocNo);
        }

        // ยอดรวม FCXthGrandB4Wht-FCXthWpTax
        $cXthGrand = $cXthGrandB4Wht-$cXthWpTax;

        //ข้อความ ยอดรวมสุทธิ(FCXthGrand)
        $tXthGndText = number_format($cXthGrand, 2, '.', ' ');
        $tXthGndText = FCNtNumberToTextBaht($tXthGndText);

        //ยอดค้าง Default: FCXthGrand
        $cXthLeft = $cXthGrand;

        $Data = array(
            'FCXthTotal'            => number_format($cXthTotal, $nOptDecimalSave, '.', ''),
            'FCXthVatNoDisChg'      => number_format($cXthVatNoDisChg, $nOptDecimalSave, '.', ''),
            'FCXthNoVatNoDisChg'    => number_format($cXthNoVatNoDisChg, $nOptDecimalSave, '.', ''),
            'FCXthVatDisChgAvi'     => number_format($cXthVatDisChgAvi, $nOptDecimalSave, '.', ''),
            'FCXthNoVatDisChgAvi'   => number_format($cXthNoVatDisChgAvi, $nOptDecimalSave, '.', ''),
            'FTXthDisChgTxt'        => $tDisChgTxt,
            'FCXthDis'              => number_format($cXthDis, $nOptDecimalSave, '.', ''),
            'FCXthChg'              => number_format($cXthChg, $nOptDecimalSave, '.', ''),
            'FCXthRefAEAmt'         => number_format($this->input->post('oetXthRefAEAmtInput'), $nOptDecimalSave, '.', ''), //Default 0 
            'FCXthVatAfDisChg'      => number_format($cXthVatAfDisChg, $nOptDecimalSave, '.', ''),
            'FCXthNoVatAfDisChg'    => number_format($cXthNoVatAfDisChg, $nOptDecimalSave, '.', ''),
            'FCXthAfDisChgAE'       => number_format($cXthAfDisChgAE, $nOptDecimalSave, '.', ''),
            'FTXthWpCode'           => '',
            'FCXthVat'              => number_format($cXthVat, $nOptDecimalSave, '.', ''),
            'FCXthVatable'          => number_format($cXthVatable, $nOptDecimalSave, '.', ''),
            'FCXthGrandB4Wht'       => number_format($cXthGrandB4Wht, $nOptDecimalSave, '.', ''),
            // 'FCXthWpTax'            => $cXthWpTax,
            'FCXthGrand'            => number_format($cXthGrand, $nOptDecimalSave, '.', ''),
            'FTXthGndText'          => $tXthGndText,
            'FCXthLeft'             => number_format($cXthLeft, $nOptDecimalSave, '.', ''),
        );


        // echo "<pre>";
        // print_r($Data);
        // echo "<pre>";

        $DataWhere = array(
            'FTXthDocNo' => $tXthDocNo,
        );

        $aStaUpdOrdHD = $this->mProducttransferwahousevd->FSaMTFWUpdateOrdHD($Data,$DataWhere); /*ลงตาราง TAPTOrdHD */

    }

    //Function : Approve Doc
    public function FSvCTFWApprove(){

        $tXthDocNo  = $this->input->post('tXthDocNo');
        $tXthStaApv = $this->input->post('tXthStaApv');

        $aDataUpdate = array(
            'FTXthDocNo' => $tXthDocNo,
            'FTXthApvCode' => $this->session->userdata('tSesUsername')
        );

        $aStaApv = $this->mProducttransferwahousevd->FSvMTFWApprove($aDataUpdate); 

        $tUsrBchCode = FCNtGetBchInComp();


        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
        //Data Master
        $aDataWhere  = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FNLngID'       => $nLangEdit,
            'nRow'          => 10000,
            'nPage'         => 1,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );
        //Get Data
        $aResult        = $this->mProducttransferwahousevd->FSaMTFWGetHD($aDataWhere);       // Data TCNTPdtAdjStkHD
        $aInfoWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            "tBchCode"=>$aResult["raItems"]["FTBchCode"],
            "tShpCode"=>$aResult["raItems"]["FTXthShopFrm"],
            "tPosCode"=>$aResult["raItems"]["FTXthPosFrm"],
            "tWahCode"=>$aResult["raItems"]["FTXthWhFrm"],
            "nLangID"=>$nLangEdit
        );
        $aDataInfor = $this->mProducttransferwahousevd->FSaMTWXVDGetPdtLayoutToTem($aInfoWhere);
        $this->mProducttransferwahousevd->FSxMUpdateBalToDT($aDataInfor,$aInfoWhere); 
        try{
            $aMQParams = [
                "queueName" => "ADJUSTSTOCK",
                "params" => [
                    "ptBchCode"     => $tUsrBchCode,
                    "ptDocNo"       => $tXthDocNo,
                    "ptDocType"     => '11',
                    "ptUser"        => $this->session->userdata('tSesUsername')
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);
            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);
        }catch(\ErrorException $err){
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
    public function FSvCTFWCancel(){

        $tXthDocNo = $this->input->post('tXthDocNo');

        $aDataUpdate = array(
            'FTXthDocNo' => $tXthDocNo,
        );

        $aStaApv = $this->mProducttransferwahousevd->FSvMTFWCancel($aDataUpdate); 

        if($aStaApv['rtCode'] == 1){
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Cancel done.",
            );
        }else{
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Cancel.",
            );
        }
        echo json_encode($aApv);

    }
    

    //////////////////////////////////////////////////////////////////////////   Zone เพิ่ม

    //Function : Add DT
    public function FSaMTFWAddDT(){

        $aStaEventDelDT =  $this->mProducttransferwahousevd->FSnMPMTDelPcoDT($this->input->post('oetSearchAll')); //*ลบ Data เก่าออก*/

        //Get Data From File
        $tXthDocNo = $this->input->post('oetSearchAll');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        $nNum = FCNnHSizeOf($aDataFile['DTData']);
        
        if($nNum != 0){
            foreach ($aDataFile['DTData'] as $key => $value) {
            
                $this->db->trans_begin();

                $aStaEventOrdHDSpl  = $this->mProducttransferwahousevd->FSaMTFWAddUpdateOrdDT($value); /*ลงตาราง TAPTOrdDT */

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    
                }else{
                    $this->db->trans_commit();
                }

            }
        }

    }

    //Function : Add DT Dis
    public function FSaMTFWAddDTDis(){

        //Get Data From File
        $tXthDocNo = $this->input->post('oetSearchAll');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);
    
        $aStaEventDelDTDis =  $this->mProducttransferwahousevd->FSnMPMTDelPcoDTDis($tXthDocNo); //*ลบ Data เก่าออก*/

        $nNum = FCNnHSizeOf($aDataFile['DTData']);
    
        if($nNum != 0){
    
            foreach ($aDataFile['DTData'] as $key => $valueDT) {
    
                $tXthDocNo      = $valueDT['FTXthDocNo'];
                $nSeqNo         = $valueDT['FNXpdSeqNo'];
                $cXpdAmt        = $valueDT['FCXpdAmt'];
                $cXpdVatRate    = $valueDT['FCXpdVatRate'];
                $cXpdWhtRate    = $valueDT['FCXpdWhtRate'];
                $cXpdQty        = $valueDT['FCXpdQty'];
                $cXpdQtyAll     = $valueDT['FCXpdQtyAll'];
                
                
                foreach($valueDT['DTDiscount'] as $keyDis => $valueDTDis) {
    
                    $this->db->trans_begin();
    
                    $aStaEventOrdDTDis  = $this->mProducttransferwahousevd->FSaMTFWAddUpdateOrdDTDis($valueDTDis); /*ลงตาราง TAPTOrdDTDis */
    
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                    }else{
                        $this->db->trans_commit();
                    }
                    
                }
    
                
                $aDTData = array(
                    'FTXpdDisChgTxt'=> $valueDT['FTXpdDisChgTxt'],
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
    
                $aStaUpdDT  = $this->mProducttransferwahousevd->FSaMTFWUpdateOrdDT($aDTData,$aDTDataWhere); /*Update TAPTOrdDT ใหม่ */
    
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }
    
            }
    
        }
        
    }

    //Function : Add HD Dis
    public function FSaMTFWAddHDDis(){

        //Get Data From File
        $tXthDocNo = $this->input->post('oetSearchAll');
        $aDataFile  = $this->FMaTFWGetDataFormFile($tXthDocNo);
        $nNum       = FCNnHSizeOf($aDataFile['HDData']);

        $aStaEventDelHDDis =  $this->mProducttransferwahousevd->FSnMPMTDelPcoHDDis($tXthDocNo); //* ลบ Data เก่าออก */

     
        if($nNum > 0){
            
            foreach ($aDataFile['HDData'] as $key => $value) {
            
                $this->db->trans_begin();

                $aStaEventOrdHDDis  = $this->mProducttransferwahousevd->FSaMTFWAddUpdateHDDis($value); /*ลงตาราง TAPTOrdDT*/

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }

            }
            //ปรับ HD ใหม่ตาม DT
            $this->FSnTFWUpdateHD();
        }else{
            //ปรับ HD ใหม่ตาม DT
            $this->FSnTFWUpdateHD();
        }
           
    }

    //Function : Add Pdt ลง Dt (File)
    public function FSvCTFWAddPdtIntoTableDT(){

        $tXthDocNo 	    = $this->input->post('ptXthDocNo');
        //$this->session->userdata("tSesUsrBchCode")
        $tBchCode 	    = $this->input->post('ptXthBchCode');
        $tXthVATInOrEx  = $this->input->post('pnXthVATInOrEx'); /*ประเภท Vat ของ SPL (รวม,แยก)*/
        $nTFWOptionAddPdt = $this->input->post('pnTFWOptionAddPdt');
        $pjPdtData      = $this->input->post('pjPdtData');
        $aPdtData       = json_decode($pjPdtData);
        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            'FTXthBchCode'  => $tBchCode
        );
        
        $nCounts    = $this->mProducttransferwahousevd->FSaMTFWGetCountDTTemp($aDataWhere);
        // วนตามรายการสินค้าที่เพิ่มเข้ามา
        for($nI=0;$nI<FCNnHSizeOf($aPdtData);$nI++){
            $pnPdtCode  = $aPdtData[$nI]->pnPdtCode;
            $ptBarCode  = $aPdtData[$nI]->ptBarCode; 
            $ptPunCode  = $aPdtData[$nI]->ptPunCode;
            $pcPrice    = $aPdtData[$nI]->packData->Price;
            $nCounts = $nCounts+1;
            $aDataPdtWhere = array(
                'FTXthDocNo'    => $tXthDocNo,  
                'FTBchCode'     => $tBchCode,   // จากสาขาที่ทำรายการ
                'FTPdtCode'     => $pnPdtCode,  // จาก Browse Pdt
                'FTPunCode'     => $ptPunCode,  // จาก Browse Pdt
                'FTBarCode'     => $ptBarCode,  // จาก Browse Pdt
                'pcPrice'       => $pcPrice,    // ราคาสินค้าจาก Browse Pdt
                'nCounts'       => $nCounts,    //จำนวนล่าสุด Seq
                'FNLngID'       => $this->session->userdata("tLangID"), //รหัสภาษาที่ login
                'FTSessionID'   => $this->session->userdata('tSesSessionID'),
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'nTFWOptionAddPdt' => $nTFWOptionAddPdt
            );
            $aDataPdtMaster     =   $this->mProducttransferwahousevd->FSaMTFWGetDataPdt($aDataPdtWhere); // Data Master Pdt
            
            


            
            $nStaInsPdtToTmp    =   $this->mProducttransferwahousevd->FSaMTFWInsertPDTToTemp($aDataPdtMaster,$aDataPdtWhere);
           
        }
        
        //คำนวน DT ใหม่
        $aResCalDTTmp       = $this->FSnCTFWCalulateDTTemp($tXthDocNo,$tXthVATInOrEx);
        echo $this->session->userdata("tSesUsrBchCode");

    }


    /*
    Function : Process Calulate 
    */
    public function FSnCTFWCalulateDTTemp($ptXthDocNo,$ptXthVATInOrEx){

            $aDataWhere = array(
                'FTXthDocNo'    => $ptXthDocNo,
                'FTXthDocKey'   =>'TCNTPdtAdjStkHD',
                'FTSesssionID'  => $this->session->userdata('tSesSessionID')
            );

            //Get Option Save Decimal  
            $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

            //Get DT Tmp
            $aDataDTTmp = $this->mProducttransferwahousevd->FSaMTFWGetDTTemp($aDataWhere);

            if($aDataDTTmp['rtCode'] == 1){

                $aDataDTTmp = $aDataDTTmp['raItems'];

                foreach($aDataDTTmp as $Key => $value){

                    $aDataDTTmp[$Key]['FCXtdFactor'] = number_format($value['FCXtdFactor'], $nOptDecimalSave, '.', '');


                    //FCXtdQtyAll จำนวนรวมหน่วยเล็กสุด(จ่ายโอน)  (Qty*Factor*StkFac)
                    $FCXtdQtyAll = $value['FCXtdQty']*$value['FCXtdFactor'];
                    $aDataDTTmp[$Key]['FCXtdQtyAll'] = $FCXtdQtyAll;

                    //คำนวน FCXtdAmt  (Qty*SetPrice) 
                    $FCXtdAmt = $value['FCXtdQty']*$value['FCXtdSetPrice'];
                    $aDataDTTmp[$Key]['FCXtdAmt'] = number_format($FCXtdAmt, $nOptDecimalSave, '.', '');

                    //มูลค่าภาษี IN: amt-((amt*100)/(100+VatRate)) ,EX: ((amt*(100+VatRate))/100)-Neamtt
                    if($ptXthVATInOrEx == 1){
                        $FCXtdVat = $FCXtdAmt-(($FCXtdAmt*100)/(100+$value['FCXtdVatRate']));
                    }else{
                        $FCXtdVat = ($FCXtdAmt*(100+$value['FCXtdVatRate']))/100;
                        
                    }
                    $aDataDTTmp[$Key]['FCXtdVat'] = number_format($FCXtdVat, $nOptDecimalSave, '.', '');

                    //มูลค่าแยกภาษี (Amt-FCXpdVat)
                    $FCXtdVatable = $FCXtdAmt-$FCXtdVat;
                    $aDataDTTmp[$Key]['FCXtdVatable'] = number_format($FCXtdVatable, $nOptDecimalSave, '.', '');
                    
                    //มูลค่าสุทธิก่อนท้ายบิล (FCXpdVat+FCXpdVatable)
                    $FCXtdNet = $FCXtdVat+$FCXtdVatable;
                    $aDataDTTmp[$Key]['FCXtdNet'] = number_format($FCXtdNet, $nOptDecimalSave, '.', '');

                    //ต้นทุนรวมใน (FCXpdVat+FCXpdVatable)
                    $FCXtdCostIn = $FCXtdVat+$FCXtdVatable;
                    $aDataDTTmp[$Key]['FCXtdCostIn'] = number_format($FCXtdCostIn, $nOptDecimalSave, '.', '');

                    //ต้นทุนแยกนอก (FCXpdVatable)
                    $aDataDTTmp[$Key]['FCXtdCostEx'] = number_format($FCXtdVatable, $nOptDecimalSave, '.', '');
                    
                }

                $aResUpd = $this->mProducttransferwahousevd->FSnMWTOUpdateDTTemp($aDataDTTmp,$aDataWhere);

            }

    }


    //////////////////////////////////////////////////////////////////////////   Zone Function Center
    //คำนวน ตัวเลขและค่า ในไฟล์ใหม่ หลังจากมีการแก้ไขตัวเลข เช่น แก้ไขจำนวน ราคาเปลี่ยน
    public function FCNoTFWProcessCalculaterInFile($ptXthDocNo){

        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        //คำนวน Record ใหม่ถ้ามีการ Add และ Del Row
        if($this->FCNoTFWCalculaterAFTAddHDDis($ptXthDocNo) === 1 ){

            if($this->FCNoTFWAdjDTDisAFTAdjHDDis($ptXthDocNo) === 1){

                    ////คำนวน Record ใหม่ถ้ามีการ Add และ Del Row

                    //Get Data From File
                    $aDataFile = $this->FMaTFWGetDataFormFile($ptXthDocNo);

                    $nNum = FCNnHSizeOf($aDataFile['DTData']);

                    $aArray['HDData'] = array();
                    $aArray['DTData'] = array();

                    $tDisChgTxt = '';
                    $nXddDis    = 0; 
                    $nXddChg    = 0;
                    $nSeq       = 0;

                    //รวมส่วนลด ท้ายบิล
                    $nXthDisSUM = 0;
                    //รวม Net DT
                    $nXpdNetSUM = 0;

                    $cXddDis    = 0;
                    $cXddChg    = 0;
                    $cXddDisCur = 0;

                    if($nNum != 0){

                        //เอา HD Array ก้อนเดิมมาใส่ตัวแปล HD Array ตัวใหม่
                        foreach ($aDataFile['HDData'] as $key => $value) {
                            array_push($aArray['HDData'],$value);
                        }

                        //เอา DT Array ก้อนเดิมมาใส่ตัวแปล DT Array ตัวใหม่
                        foreach ($aDataFile['DTData'] as $key => $value) {
                            $value['FNXpdSeqNo'] = $nSeq+1;
                            array_push($aArray['DTData'],$value);
                            $nSeq = $nSeq+1;
                        }

                        $tXthDocNo = $aArray['DTData'][0]['FTXthDocNo'];

                        //รับค่าจาก input
                        $tXthVATInOrExFromInput = $this->session->userdata('tTFWSesVATInOrEx'.$tXthDocNo);
                        if($tXthVATInOrExFromInput != ''){
                            $tXthVATInOrEx = $tXthVATInOrExFromInput;
                        }else{
                            //ถ้าไม่มี Get จาก Base
                            $tXthVATInOrEx = $this->mProducttransferwahousevd->FCNxTFWGetvatInOrEx($tXthDocNo);
                        }

                        //หา Sum HD Dis ท้ายบิล
                        foreach($aDataFile['HDData'] as $HDKey => $HDValue) {
                            $nXthDisSUM    = $nXthDisSUM+$HDValue['FCXthDis'];
                        }

                        //หา Sum Net DT ที่ อนุญาติลด
                        foreach($aArray['DTData'] as $DTKey => $DTValue) {
                            //Check ว่าเป็นสินค้าที่ อนุญาตลดหรือไม่ 0 ลดไม่ได้ != 0 ลดได้ 0 ลดได้

                            //Sum Net ที่อนุญาตลด
                            if($DTValue['FTXpdStaAlwDis'] == 1){
                                $nXpdNetSUM    = $nXpdNetSUM+$DTValue['FCXpdNet'];
                            }

                            foreach($DTValue['DTDiscount'] as $DTDisKey => $DTDisValue) {
                                // Sum Dis AND Chg
                                if($DTDisValue['FNXpdStaDis'] == 2){
                                    $cXddDis = $cXddDis+$DTDisValue['FCXddDis'];
                                    $cXddChg = $cXddChg+$DTDisValue['FCXddChg'];
                                }
                            }

                        }
                        //ผลรวม Dis DT ที่อนุญาตลด
                        $cXddDisCur = $cXddDis-$cXddChg;
                        
                        foreach ($aArray['DTData'] as $key => $value) {
                            
                            //------------------- Start Process ------------------//
                        
                            $tXthDocNo      = $value['FTXthDocNo'];
                            $nSeqNo         = $value['FNXpdSeqNo'];
                            $cXpdFactor     = $value['FCXpdFactor'];
                            $cXpdSalePrice  = $value['FCXpdSalePrice'];
                            $cXpdQty        = $value['FCXpdQty'];
                            $cXpdQtyAll     = $value['FCXpdQtyAll'];
                            $cXpdSetPrice   = $value['FCXpdSetPrice'];
                            
                            $cXpdAmt        = $value['FCXpdAmt'];
                            $cXpdVatRate    = $value['FCXpdVatRate'];
                            $cXpdWhtRate    = $value['FCXpdWhtRate'];

                            foreach($value['DTDiscount'] as $keyDis => $valueDis) {

                                $aArray['DTData'][$key]['DTDiscount'][$keyDis]['FNXpdSeqNo'] = $value['FNXpdSeqNo'];

                                if($valueDis['FNXpdStaDis'] == 1){
                                    $tDisChgTxt .= $valueDis['FTXddDisChgTxt'].",";
                                    $nXddDis     = $nXddDis+$valueDis['FCXddDis'];
                                    $nXddChg     = $nXddChg+$valueDis['FCXddChg'];
                                }
                            }

                            //คำนวน จำนวนรวมหน่วยเล็กสุด (FCXpdQty*FCXpdFactor)
                            $cXpdQtyAll = $cXpdQty*$cXpdFactor;

                            //คำนวน FCXpdAmt
                            $cXpdAmt = $cXpdQty*$cXpdSetPrice;

                            //คำนวนหาค่า มูลค่าลดได้  กรณีอนุญาตลด (Qty*SetPrice) ไม่อนุญาต เป็น 0 (ปรับเมื่อมีการลดชาร์จ DT/HD)
                            $XpdDisChgAvi = 0;

                            //Check ว่าเป็นสินค้าที่ อนุญาตลดหรือไม่ 0 ลดไม่ได้ != 0 ลดได้ 0 ลดได้
                            if($value['FTXpdStaAlwDis'] == 1){
                                //คำนวน กรณีอนุญาตลด  กรณีอนุญาตลด (Qty*SetPrice) 
                                $XpdDisChgAvi = $cXpdQty*$cXpdSetPrice;

                                //ถ้ามีลดท้ายบิล จะคำนวนใหม่
                                foreach($value['DTDiscount'] AS $DTDisKey => $DTDisValue){
                                    $XpdDisChgAvi = $DTDisValue['FCXddDisChgAvi']-($DTDisValue['FCXddDis']-$DTDisValue['FCXddChg']);
                                }
                            }

                            if($tDisChgTxt != ''){
                                $tDisChgTxt = substr($tDisChgTxt, 0, -1); /* ตัด , ตัวหลังสุดออก */
                            }else{
                                $tDisChgTxt = '';
                            }

                            //คำนวน FCXpdNet มูลค่าสุทธิก่อนท้ายบิล (FCXpdAmt-FCXpdDis+FCXpdChg)
                            $cXpdNet  = $cXpdAmt-$nXddDis+$nXddChg;

                            //มูลค่าสุทธิหลังท้ายบิล (Net-SUM(Disท้ายบิล))
                            if($nXthDisSUM != 0 && $value['FTXpdStaAlwDis'] == 1){
                                //มีท้ายบืล ปรับเมื่อมีท้ายบิล และ ต้องลดได้ AlwDis
                                $A = $cXddDisCur*$value['FCXpdNet'];
                                $B = $nXpdNetSUM;
                                if($A == 0 && $B == 0){
                                    $ResSum = 0;
                                }else{
                                    $ResSum = ($cXddDisCur*$value['FCXpdNet'])/$nXpdNetSUM;
                                }
                                // $cXpdNetAfHD = $cXpdNet-(($cXddDisCur*$value['FCXpdNet'])/$nXpdNetSUM);
                                $cXpdNetAfHD = $cXpdNet-($ResSum);
                            }else{
                                // ไม่มีท้ายบิล Default = FCXpdNet
                                $cXpdNetAfHD = $cXpdNet;
                            }

                            

                            // is: 1 รวมใน //คำนวน มูลค่าภาษี IN : NetAfHD-((NetAfHD*100)/(100+VatRate)) 
                            if($tXthVATInOrEx == '1'){ 
                                $cXpdVat = $cXpdNetAfHD-(($cXpdNetAfHD*100)/(100+$cXpdVatRate));

                                //รวมใน ถอด Vat(FCXpdNet)
                                $cXpdNetEx = $cXpdNet-(($cXpdNet*100)/(100+$cXpdVatRate));
                            }else{ 
                            // is: 2 แยกนอก //คำนวน มูลค่าภาษี EX: ((NetAfHD*(100+VatRate))/100)-NetAfHD
                                $cXpdVat = (($cXpdNetAfHD*(100+$cXpdVatRate))/100)-$cXpdNetAfHD;

                                //แยกนอก THEN FCXpdNet 
                                $cXpdNetEx = $cXpdNet;
                            }

                            //มูลค่าแยกภาษี (NetAfHD-FCXpdVat)
                            $cXpdVatable = $cXpdNetAfHD-$cXpdVat;

                            //Default 0 IF FCXpdWhtRate>0 THEN  FCXpdVatable* FCXpdWhtRate%
                            if($cXpdWhtRate > 0){
                                $cXpdWhtAmt = ($cXpdVatable*$cXpdWhtRate)/100;
                            }else{
                                $cXpdWhtAmt = 0;
                            }

                            //ต้นทุนรวมใน (FCXpdVatable/FCXpdQtyAll ) * VatRate
                            if($cXpdQtyAll == 0){
                                $A = 0;
                            }else{
                                $A = $cXpdVatable/$cXpdQtyAll;
                            }
                            $cXpdCostIn = $A*$cXpdVatRate;

                            //ต้นทุนแยกนอก FCXpdVatable/FCXpdQtyAll
                            if($cXpdQtyAll == 0){
                                $cXpdCostEx = 0;
                            }else{
                                $cXpdCostEx = $cXpdVatable/$cXpdQtyAll;
                            }
                            
                            //จำนวนคงเหลือ ตามหน่วย (Default:FCXpdQty)
                            $cXpdQtyLef = $cXpdQty;

                            //------------------- End Process ------------------//

                            //Put New Data
                            $aArray['DTData'][$key]['FTXpdDisChgTxt']   = $tDisChgTxt;
                            $aArray['DTData'][$key]['FCXpdFactor']      = $cXpdFactor >= 0 ? number_format($cXpdFactor, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdVatRate']     = $cXpdVatRate >= 0 ? number_format($cXpdVatRate, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdSalePrice']   = $cXpdSalePrice >= 0 ? number_format($cXpdSalePrice, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdQty']         = $cXpdQty >= 0 ? number_format($cXpdQty, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdQtyAll']      = $cXpdQtyAll >= 0 ? number_format($cXpdQtyAll, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdSetPrice']    = $cXpdSetPrice >= 0 ? number_format($cXpdSetPrice, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdAmt']         = $cXpdAmt >= 0 ? number_format($cXpdAmt, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');  //มูลค่ารวมก่อนลด (Qty*SetPrice) ทุกกรณี (ไม่เปลี่ยน)
                            $aArray['DTData'][$key]['FCXpdDisChgAvi']   = $XpdDisChgAvi >= 0 ? number_format($XpdDisChgAvi, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');    // มูลค่าลดได้  กรณีอนุญาตลด (Qty*SetPrice) ไม่อนุญาต เป็น 0 (ปรับเมื่อมีการลดชาร์จ DT/HD) 
                            $aArray['DTData'][$key]['FCXpdDis']         = $nXddDis >= 0 ? number_format($nXddDis, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdChg']         = $nXddChg >= 0 ? number_format($nXddChg, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdNet']         = $cXpdNet >= 0 ? number_format($cXpdNet, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdNetAfHD']     = $cXpdNetAfHD >= 0 ? number_format($cXpdNetAfHD, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdNetEx']       = $cXpdNetEx >= 0 ? number_format($cXpdNetEx, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdVat']         = $cXpdVat >= 0 ? number_format($cXpdVat, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdVatable']     = $cXpdVatable >= 0 ? number_format($cXpdVatable, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdWhtAmt']      = $cXpdWhtAmt >= 0 ? number_format($cXpdWhtAmt, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdWhtRate']     = $cXpdWhtRate >= 0 ? number_format($cXpdWhtRate, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdCostIn']      = $cXpdCostIn >= 0 ? number_format($cXpdCostIn, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdCostEx']      = $cXpdCostEx >= 0 ? number_format($cXpdCostEx, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');
                            $aArray['DTData'][$key]['FCXpdQtyLef']      = $cXpdQtyLef >= 0 ? number_format($cXpdQtyLef, $nOptDecimalSave, '.', '') : number_format(0, $nOptDecimalSave,'.',',');

                            //Remove ค่าในตัวแปร ใน loop ก่อนหน้า
                            $tDisChgTxt = '';
                            $nXddDis    = 0; 
                            $nXddChg    = 0;

                        }
                    }

                    $jDataArray = json_encode($aArray);
                    if($ptXthDocNo != ''){
                        //PATHSupawat
                        $fp = fopen(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
                        file_put_contents(APPPATH."modules\document\document\\".$ptXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
                        fclose($fp);
                    }

            }
        }
    }


    //function : เพิ่มส่วนลด HDDis (ท้าบบิล ) (File)
    public function FSvCTFWAddHDDisIntoTable(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXthDocNo      = $this->input->post('tHDXthDocNo');
        $tBchCode       = $this->input->post('tHDBchCode');
        $tDisChgText    = $this->input->post('tHDXthDisChgText');
        $cXthDisValue   = $this->input->post('cHDXthDis');

        //ปรับทศนิยม
        $cXthDisValue   = number_format($cXthDisValue, $nOptDecimalSave, '.', '');

        $cXthDis = 0;
        $cXthChg = 0;

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        
        //ยอดมีภาษีลดได้
        $cXthVatDisChgAvi = 0;
        //ยอดไม่มีภาษีลดได้
        $cXthNoVatDisChgAvi = 0;

        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            foreach($aDataFile['DTData'] AS $key => $value){
                if($value['FTXpdVatType'] == 1){
                    //คำนวนยอดมีภาษีลดได้ FTXpdVatType=1 : SUM(DT.FCXpdDisChgAvi)
                    $cXthVatDisChgAvi   = $cXthVatDisChgAvi + $value['FCXpdDisChgAvi'];
                }else if($value['FTXpdVatType'] == 2){
                    $cXthNoVatDisChgAvi = $cXthNoVatDisChgAvi + $value['FCXpdDisChgAvi'];
                }
            }
        }

        switch ($tDisChgText) {
            case 1: //ชาร์จบาทชาร์จบาท
                $tXthDisChgTxt = "+".$cXthDisValue;
                $cXthDis       = '0';
                $cXthChg       = $cXthDisValue;
                break;
            case 2: //ชาร์จ %
                $tXthDisChgTxt = "+".$cXthDisValue."%";
                $cXthDis       = '0';
                $cXthChg       = $cXthDisValue*$cXthVatDisChgAvi/100;
                break;
            case 3: //ลดบาท
                $tXthDisChgTxt = $cXthDisValue;
                $cXthDis       = $cXthDisValue;
                $cXthChg       = '0';
                break;
            case 4: //ลด %
                $tXthDisChgTxt = $cXthDisValue."%";
                $cXthDis       = $cXthDisValue*$cXthVatDisChgAvi/100;
                $cXthChg       = '0';
                break;
            
            default:
                $tXthDisChgTxt = $cXthDisValue;
        }

        $cXthVatDisChgAvi   = number_format($cXthVatDisChgAvi, $nOptDecimalSave, '.', '');
        $cXthNoVatDisChgAvi = number_format($cXthNoVatDisChgAvi, $nOptDecimalSave, '.', '');
        $cXthDis            = number_format($cXthDis, $nOptDecimalSave, '.', '');
        $cXthChg            = number_format($cXthChg, $nOptDecimalSave, '.', '');

        $aNewData = array(
            'FTBchCode'             => $tBchCode,
            'FTXthDocNo'            => $tXthDocNo,
            'FDXthDateIns'          => date('Y-m-d H:i:s'),
            'FNXthStaDis'           => 2,
            'FCXthVatDisChgAvi'     => $cXthVatDisChgAvi,
            'FCXthNoVatDisChgAvi'   => $cXthNoVatDisChgAvi,
            'FTXthDisChgTxt'        => $tXthDisChgTxt,
            'FCXthDis'              => $cXthDis,
            'FCXthChg'              => $cXthChg,
            'FCXthDisVat'           => 0,
            'FCXthDisNoVat'         => 0,
            'FCXthChgVat'           => 0,
            'FCXthChgNoVat'         => 0,
            'FTXthUsrApv'           => $this->session->userdata('tSesUsername'),
        );

        array_push($aDataFile['HDData'],$aNewData);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        // คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }

    //function : เพิ่มส่วนลด DTDis (รายการสินค้า) (File)
    public function FSvCTFWAddDTDisIntoTable(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXthDocNo      = $this->input->post('ptXthDocNo');
        $tBchCode       = $this->input->post('ptBchCode');
        $nKey           = $this->input->post('pnKey');
        $tXpdSeqNo      = $this->input->post('ptXpdSeqNo');
        $tXpdDisChgAvi  = $this->input->post('ptXpdDisChgAvi');
        $tDisChgText    = $this->input->post('tDisChgText');
        $cXddDisValue   = $this->input->post('cXddDis');

        //ปรับทศนิยม
        $cXddDisValue   = number_format($cXddDisValue, $nOptDecimalSave, '.', '');

        switch ($tDisChgText) {
            case 1: //ชาร์จบาท 
                $tXddDisChgTxt = "+".$cXddDisValue;
                $cXddDis       = '0';
                $cXddChg       = $cXddDisValue;
                break;
            case 2: //ชาร์จ %
                $tXddDisChgTxt = "+".$cXddDisValue."%";
                $cXddDis       = '0';
                $cXddChg       = (intval($tXpdDisChgAvi)*$cXddDisValue)/100;
                break;
            case 3: //ลดบาท
                $tXddDisChgTxt = $cXddDisValue;
                $cXddDis       = $cXddDisValue;
                $cXddChg       = '0';
                break;
            case 4: //ลด %
                $tXddDisChgTxt = $cXddDisValue."%";
                $cXddDis       = (intval($tXpdDisChgAvi)*$cXddDisValue)/100;
                $cXddChg       = '0';
                break;
            
            default:
                $tXddDisChgTxt = $cXddDisValue;
        }
        
        $aNewData = array(
            'FTBchCode'         => $tBchCode,
            'FTXthDocNo'        => $tXthDocNo,
            'FNXpdSeqNo'        => $tXpdSeqNo,
            'FDXddDateIns'      => date('Y-m-d H:i:s'),
            'FNXpdStaDis'       => 1,
            'FCXddDisChgAvi'    => intval($tXpdDisChgAvi),
            'FTXddDisChgTxt'    => $tXddDisChgTxt,
            'FCXddDis'          => number_format($cXddDis, $nOptDecimalSave, '.', ''),
            'FCXddChg'          => number_format($cXddChg, $nOptDecimalSave, '.', ''),
            'FTXddUsrApv'       => $this->session->userdata('tSesUsername'),
        );

        //Get Data From File
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        array_push($aDataFile['DTData'][$nKey]['DTDiscount'],$aNewData);
                
        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }



    //////////////////////////////////////////////////////////////////////////   Zone ลบ
    //Functionality : Event Delete Master
    public function FSaCTFWDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTXthDocNo' => $tIDCode
        );

        $aResDel    = $this->mProducttransferwahousevd->FSnMTFWDel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //Function : Remove Master Pdt Intable (File)
    public function FSvCTFWRemovePdtInDTTmp(){

        $aDataWhere = array(
            'FTXthDocNo'    => $this->input->post('ptXthDocNo'),
            'FTPdtCode'     => $this->input->post('ptPdtCode'),
            'FNXtdSeqNo'    => $this->input->post('ptSeqno'),
            'FTSessionID'   => $this->session->userdata('tSesSessionID'),
        );

        $aResDel = $this->mProducttransferwahousevd->FSnMTFWDelDTTmp($aDataWhere);

    }

    //Function : Remove Master Pdt Intable (File)
    public function FSvCTFWRemovePdtInFile(){
        
        $tIndex 	= $this->input->post('ptIndex');
        $tPdtCode 	= $this->input->post('ptPdtCode');

        //Get Data From File
        $tXthDocNo = $this->input->post('ptXthDocNo');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        unset($aDataFile['DTData'][$tIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }

    //Function : Remove Master Pdt Intable (File)
    public function FSvCTFWRemoveAllPdtInFile(){
    
        //Get Data From File
        $tXthDocNo = $this->input->post('ptXthDocNo');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        unset($aDataFile['DTData']);

        $jDataArray = json_encode($aDataFile);
            //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo); 

    }

    //Function : Remove HDDis inFile (File)
    public function FSvCTFWRemoveHDDisInFile(){
    
        $nIndex = $this->input->post('nIndex');

        //Get Data From File
        $tXthDocNo = $this->input->post('ptXthDocNo');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        unset($aDataFile['HDData'][$nIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo);

    }

    //Function : Remove DTDis inFile (File)
    public function FSvCTFWRemoveDTDisInFile(){
        
        $nKey 	= $this->input->post('nKey');
        $nIndex = $this->input->post('nIndex');

        //Get Data From File
        $tXthDocNo = $this->input->post('ptXthDocNo');
        $aDataFile = $this->FMaTFWGetDataFormFile($tXthDocNo);

        unset($aDataFile['DTData'][$nKey]['DTDiscount'][$nIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXthDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoTFWProcessCalculaterInFile($tXthDocNo);

    }



    //////////////////////////////////////////////////////////////////////////   Zone Call Page
    //Functionality : โหลดหน้าเพจ add
    //Parameters : -
    //Creator : -
    //Update : 05/06/2019 Pap
    //Return : view
    //Return Type : View
    public function FSxCTFWAddPage(){
        $aInfoWhere = array(
            "tBchCode"=>$this->input->post("tBchCode"),
            
            "FTXthDocKey"=>"TCNTPdtAdjStkHD"
        );
        $this->mProducttransferwahousevd->FSxMDeleteDoctemForNewEvent($aInfoWhere);

        $this->mProducttransferwahousevd->FSxMClearPdtInTmp();
        //Get Option Show Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        $nLangResort    = $this->session->userdata("tLangID");

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave(); 

        //Get Option Scan SKU
        $nOptScanSku    = FCNnHGetOptionScanSku(); 

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
        
        $aDataWhere  = array(
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
        
        if($aResList['rtCode'] == '1'){
            $tBchCode       = $aResList['raItems']['rtCmpBchCode'];
            $tCompCode       = $aResList['raItems']['rtCmpCode'];
            $tCmpRteCode    = $aResList['raItems']['rtCmpRteCode'];
            $tVatCode       = $aResList['raItems']['rtVatCodeUse'];
            $aVatRate = FCNoHCallVatlist($tVatCode); 
            if(FCNnHSizeOf($aVatRate)!=0){
                $cVatRate  = $aVatRate['FCVatRate'][0];
            }else{
                $cVatRate       = "";
            }
            
            $aDataRate  = array(
                'FTRteCode' => $tCmpRteCode,
                'FNLngID'   => $nLangEdit
            );
    
            $aResultRte     = $this->mRate->FSaMRTESearchByID($aDataRate);
            $cXthRteFac     = $aResultRte['raItems']['rcRteRate'];
            
        }else{
            $tBchCode       = "";
            $tCompCode      = "";
            $tCmpRteCode    = "";
            $tVatCode       = "";
            $cVatRate       = "";
            $cXthRteFac     = "";
        }

        $tUsrLogin = $this->session->userdata('tSesUsername');

        $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin); //Get Department Code

        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin'=> $tUsrLogin
        );

        $aDataUserGroup = $this->mProducttransferwahousevd->FStTFWGetShpCodeForUsrLogin($aDataShp); // Get ข้อมูลสาขา และร้านค้าของ User ที่ login
        if($aDataUserGroup==''){
            $tBchCode   = '';
            $tBchName   = '';
            $tMchCode   = '';
            $tMchName   = '';
            $tShpCodeStart   = "";
            $tShpNameStart   = "";
            $tShpCodeEnd   = "";
            $tShpNameEnd   = "";
            $tWahCodeStart   = "";
            $tWahNameStart   = "";
            $tWahCodeEnd   = "";
            $tWahNameEnd   = "";
            $tShpTypeStart = "";
        }else{
            $tShpTypeStart = $aDataUserGroup["FTShpType"];
            //เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            if($aDataUserGroup["FTBchCode"] == ''){
                //ถ้าว่าง ให้ Get Option Def
                $tBchCode   = '';
                $tBchName   = '';
            }else{
                $tBchCode   = $aDataUserGroup["FTBchCode"];
                $tBchName   = $aDataUserGroup["FTBchName"];
            }
            //เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            $tMchCode   = $aDataUserGroup["FTMerCode"];
            $tMchName   = $aDataUserGroup["FTMerName"];
            //$tWahCodeStart_Bch   = $aDataUserGroup["FTWahCode_Bch"];
            //$tWahNameStart_Bch   = $aDataUserGroup["FTWahName_Bch"];
            //เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
            if($aDataUserGroup["FTShpCode"] == ''){
                //ถ้าว่าง ให้ Get Option Def
                $tShpCodeStart   = "";
                $tShpNameStart   = "";
                $tShpCodeEnd   = "";
                $tShpNameEnd   = "";
                $tWahCodeStart   = "";
                $tWahNameStart   = "";
                $tWahCodeEnd   = "";
                $tWahNameEnd   = "";
            }else{
                $tShpCodeStart   = $aDataUserGroup["FTShpCode"];
                $tShpNameStart   = $aDataUserGroup["FTShpName"];
                $tShpCodeEnd   = "";
                $tShpNameEnd   = "";
                $tWahCodeStart   = $aDataUserGroup["FTWahCode"];
                $tWahNameStart   = $aDataUserGroup["FTWahName"];
                $tWahCodeEnd   = "";
                $tWahNameEnd   = "";
            }
            //เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
        }
        



        
          
        
        
        $aDataAdd = array(
            'aResult'       =>  array('rtCode'=>'99'),
            'aResultOrdDT'  =>  array('rtCode'=>'99'),
            'nOptDecimalShow' =>  $nOptDecimalShow,
            'nOptScanSku'   =>  $nOptScanSku,
            'nOptDocSave'   =>  $nOptDocSave,
            'tCmpRteCode'   =>  $tCmpRteCode,
            'tVatCode'      =>  $tVatCode,
            'cVatRate'      =>  $cVatRate,
            'cXthRteFac'    =>  $cXthRteFac,
            'tDptCode'      =>  $tDptCode,
            'tMchCode'      =>  $tMchCode,
            'tMchName'      =>  $tMchName,
            'tShpCodeStart'      =>  $tShpCodeStart,
            'tShpNameStart'      =>  $tShpNameStart,
            'tShpTypeStart' => $tShpTypeStart,
            'tShpCodeEnd'      =>  $tShpCodeEnd,
            'tShpNameEnd'      =>  $tShpNameEnd,
            'tWahCodeStart'      =>  $tWahCodeStart,
            'tWahNameStart'      =>  $tWahNameStart,
            //'tWahCodeStart_Bch'      =>  $tWahCodeStart_Bch,
            //'tWahNameStart_Bch'      =>  $tWahNameStart_Bch,
            'tWahCodeEnd'      =>  $tWahCodeEnd,
            'tWahNameEnd'      =>  $tWahNameEnd,
            'tCompCode'     => $tCompCode,
            'tBchCode'      =>  $tBchCode,
            'tBchName'      =>  $tBchName,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()  
                
          
        );

        $this->load->view('document/adjuststockvd/wProducttransferwahouseAddvd',$aDataAdd);

    }

    public function FSbCheckHaveProductForTransfer(){
        $tDocNo = $this->input->post("tDocNo");
        $nNumPdt = $this->mProducttransferwahousevd->FSnMTFWCheckPdtTempForTransfer($tDocNo);
        if($nNumPdt>0){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    public function FSbCheckHaveProductInDT(){
        $tDocNo = $this->input->post("tDocNo");
        $tBchCode = $this->input->post("tBchCode");
        $nNumPdt = $this->mProducttransferwahousevd->FSnMTFWCheckHaveProductInDT($tDocNo,$tBchCode);
        if($nNumPdt>0){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }

    //Functionality : การบันทึกข้อมูลลงฐานข้อมูล (สร้างใบโอนระหว่างคลังใหม่)
    //Parameters : -
    //Creator : -
    //Update : 05/06/2019 Pap
    //Return : view
    //Return Type : View
    public function FSaCTFWAddEvent(){
        try{
            $dXthDocDate = $this->input->post('oetXthDocDate')." ".$this->input->post('oetXthDocTime');
            $aDataMaster = array(
                'tIsAutoGenCode'        => $this->input->post('ocbTFWAutoGenCode'),
                'FTBchCode'             => $this->input->post('ohdBchCode'),  
                'FTAjhDocNo'            => $this->input->post('oetXthDocNo'),
                'FDAjhDocDate'          => $dXthDocDate,
                'FTAjhBchTo'            => $this->input->post('oetBchCode'),
                'FTAjhMerchantTo'       => $this->input->post('oetMchCode'),
                'FTAjhShopTo'           => $this->input->post('oetShpCodeStart'),
                'FTAjhPosTo'            => $this->input->post('oetPosCodeStart'),
                'FTAjhWhTo'             => $this->input->post('ohdWahCodeStart'),
                'FTAjhPlcCode'          => "",
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTRsnCode'             => "",
                'FTAjhRmk'              => $this->input->post('otaTfwRmk'),
                'FNAjhDocPrint'         => 0,
                'FTAjhApvSeqChk'        => '3',
                'FTAjhApvCode'          => '',
                'FTAjhStaApv'           => '',  
                'FTAjhStaPrcStk'        => '',  
                'FTAjhStaDoc'           => 1,   
                'FNAjhStaDocAct'        => $this->input->post('ocbXthStaDocAct'),
                'FTAjhDocRef'           => '', 
                'FTAjhStaDelMQ'         => '', 
                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername')
            );
            // Setup Reason Code
            if($aDataMaster['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtAdjStkHD',                           
                    "tDocType"    => 1,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataMaster['FTAjhDocNo']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNTPdtAdjStkHD','1');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataMaster['FTAjhDocNo'] = $aGenCode['rtAjhDocNo'];
                // }
            }
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
            $aDataWhere = array(
                'FTXthDocNo'    => $aDataMaster['FTAjhDocNo'],
                'FTBchCode'     =>  $this->input->post('ohdBchCode'),
                'FTXthDocKey'   =>'TCNTPdtAdjStkHD',
                'nLangID'   => $nLangEdit
            );

            $this->db->trans_begin();
            $aStaSdtOrdHD               = $this->mProducttransferwahousevd->FSaMTFWAddUpdateHD($aDataMaster);
            $aStaEventDocNoInDocTemp    = $this->mProducttransferwahousevd->FSaMTFWAddUpdateDocNoInDocTemp($aDataWhere);    //Update DocNo ในตาราง Doctemp
            $aResInsDT      =  $this->mProducttransferwahousevd->FSaMTFWInsertTmpToDT($aDataWhere);
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTAjhDocNo'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add'
                );
            }
            echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Function : เรียกหน้า  Edit  
    public function FSvCTFWEditPage(){
        if($this->session->userdata("tSesUsrLevel")=="HQ"){
            $tBchUser = FCNtGetBchInComp();
        }else{
            $tBchUser = $this->session->userdata("tSesUsrBchCode");
        }
        $aInfoWhere = array(
            "tBchCode"=>$tBchUser,
            "FTXthDocKey"=>"TCNTPdtAdjStkHD"
        );
        $this->mProducttransferwahousevd->FSxMDeleteDoctemForNewEvent($aInfoWhere);

       //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TFNMRate_L');
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
        $tUsrLogin = $this->session->userdata('tSesUsername');
        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin'=> $tUsrLogin
        );
        $aDataWhere  = array(
            'FNLngID'   => $nLangEdit
        );

        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aResList	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);  
        $aDataUserGroup = $this->mProducttransferwahousevd->FStTFWGetShpCodeForUsrLogin($aDataShp); // Get ข้อมูลสาขา และร้านค้าของ User ที่ login

        $tCompCode  = $aResList['raItems']['rtCmpCode'];
        if($aDataUserGroup==''){
            
            $tBchCode   = '';
            $tMchCode   = '';
            $tShpCode   = "";
        }else{
            
            $tShpTypeStart = $aDataUserGroup["FTShpType"];
            //เช็ค user ว่ามีการผูกสาขาไว้หรือไม่
            if($aDataUserGroup["FTBchCode"] == ''){
                //ถ้าว่าง ให้ Get Option Def
                $tBchCode   = '';
                
            }else{
                $tBchCode   = $aDataUserGroup["FTBchCode"];
            
            }
            
            
            
            
            //เช็ค user ว่ามีการผูกร้านค้าไว้หรือไม่
            if($aDataUserGroup["FTShpCode"] == ''){
                //ถ้าว่าง ให้ Get Option Def
                $tShpCode   = "";
                $tMchCode = "";
            }else{
                $tMchCode   = $aDataUserGroup["FTMerCode"];
                $tShpCode   = $aDataUserGroup["FTShpCode"];
                
            }
            
        }


        //Remove File Cache Data TFW
        $tXthDocNo = $this->input->post('ptXthDocNo');

        $aAlwEvent = FCNaHCheckAlwFunc('TWXVD/0/0'); //Control Event
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave(); 

        //Get Option Scan SKU
        $nOptScanSku    = FCNnHGetOptionScanSku(); 

        //Data Master
        $aDataWhere  = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FNLngID'       => $nLangEdit,
            'nRow'          => 10000,
            'nPage'         => 1,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );

        //Get Data
        $aResult        = $this->mProducttransferwahousevd->FSaMTFWGetHD($aDataWhere);       // Data TCNTPdtAdjStkHD
        $aInfoWhere = array(
            "tBchCode"=>$aResult["raItems"]["FTBchCode"],
            "tShpCode"=>$aResult["raItems"]["FTXthShopFrm"],
            "tPosCode"=>$aResult["raItems"]["FTXthPosFrm"],
            "tWahCode"=>$aResult["raItems"]["FTXthWhFrm"],
            "nLangID"=>$nLangEdit
        );
        $aDataInfor = $this->mProducttransferwahousevd->FSaMTWXVDGetPdtLayoutToTem($aInfoWhere);
        $aDataDT        = $this->mProducttransferwahousevd->FSaMTFWGetDT($aDataWhere,$aDataInfor);       // Data TVDTPdtTwxDT
        $aStaIns        = $this->mProducttransferwahousevd->FSaMTFWInsertDTToTemp($aDataDT["raItems"]);    // Insert Data DocTemp

        $aDataEdit = array(
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptDocSave'       =>  $nOptDocSave,
            'nOptScanSku'       =>  $nOptScanSku,
            'aResult'           =>  $aResult,
            'aAlwEvent'         =>  $aAlwEvent,
            'tUserBchCode'          =>  $tBchCode,
            'tUserMchCode'          =>  $tMchCode,
            'tUserShpCode'          =>  $tShpCode,
            'tCompCode'     =>   $tCompCode,
            'tBchCompCode'      =>  FCNtGetBchInComp(),
            'tBchCompName'      =>  FCNtGetBchNameInComp()  
        );
 
        $this->load->view('document/adjuststockvd/wProducttransferwahouseAddvd',$aDataEdit);
        
    }
    


    //////////////////////////////////////////////////////////////////////////   Zone Advacne Table
    //Functionality : Function Call DataTables List Master
    public function FSxCTFWDataTable(){

        $oAdvanceSearch     = $this->input->post('oAdvanceSearch');
        $nPage              = $this->input->post('nPageCurrent');

        //Controle Event
        $aAlwEvent          = FCNaHCheckAlwFunc('TWXVD/0/0'); 

        //Get Option Show Decimal
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow(); 
        
        if($nPage == '' || $nPage == null){
            $nPage = 1;
        }else{
            $nPage = $this->input->post('nPageCurrent');
        }

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        // $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
        // $nLangHave      = FCNnHSizeOf($aLangHave);
        // if($nLangHave > 1){
        //     if($nLangEdit != ''){
        //         $nLangEdit = $nLangEdit;
        //     }else{
        //         $nLangEdit = $nLangResort;
        //     }
        // }else{
        //     if(@$aLangHave[0]->nLangList == ''){
        //         $nLangEdit = '1';
        //     }else{
        //         $nLangEdit = $aLangHave[0]->nLangList;
        //     }
        // }

        $aData  = array(
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'oAdvanceSearch'    => $oAdvanceSearch
        );


        $aResList   = $this->mProducttransferwahousevd->FSaMTFWList($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'nOptDecimalShow'=> $nOptDecimalShow
        );

        $this->load->view('document/adjuststockvd/wProducttransferwahouseDataTablevd',$aGenTable);
    }

    
    

    public function FSxCTWXVDPdtDtLoadToTem(){
        $tRoute = $this->input->post("tRoute");
        $tDocno = "";
        if($tRoute!="ADJSTKVDEventAdd"){
            $tDocno = $this->input->post("tXthDocNo");
        }
        $aInfoWhere = array(
            "tBchCode"=>$this->input->post("tBchCode"),
            "tXthDocNo"=>$tDocno,
            "FTXthDocKey"=>"TCNTPdtAdjStkHD"
        );
        $this->mProducttransferwahousevd->FSxMDeleteDoctemForNewEvent($aInfoWhere);
        
            
            //Lang ภาษา
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     if($nLangEdit != ''){
            //         $nLangEdit = $nLangEdit;
            //     }else{
            //         $nLangEdit = $nLangResort;
            //     }
            // }else{
            //     if(@$aLangHave[0]->nLangList == ''){
            //         $nLangEdit = '1';
            //     }else{
            //         $nLangEdit = $aLangHave[0]->nLangList;
            //     }
            // }
            $aInfoWhere = array(
                "tBchCode"=>$this->input->post("tBchCode"),
                "tShpCode"=>$this->input->post("tShpCodeStart"),
                "tPosCode"=>$this->input->post("tPosCodeStart"),
                "tWahCode"=>$this->input->post("tWahCodeStart"),
                "nLangID"=>$nLangEdit
            );
            $aDataInfor = $this->mProducttransferwahousevd->FSaMTWXVDGetPdtLayoutToTem($aInfoWhere);
            $aData = $aDataInfor;
            $tPanelPdtStaShow=$this->input->post("tPanelPdtStaShow");
            if($aData){
                for($nI=0;$nI<FCNnHSizeOf($aData);$nI++){
                    $aInforInsert = array(
                        "FTBchCode"=>$this->input->post("tBchCode"),
                        "FTXthDocNo"=>$tDocno,
                        "FNXtdSeqNo"=>($nI+1),
                        "FNLayRowForADJSTKVD"=>$aData[$nI]["FNLayRow"],
                        "FNLayColForADJSTKVD"=>$aData[$nI]["FNLayCol"],
                        "FCLayColQtyMaxForADJSTKVD"=>$aData[$nI]["FCLayColQtyMax"],
                        "FTPdtCode"=>$aData[$nI]["FTPdtCode"],
                        "FCStkQty"=>$aData[$nI]["FCStkQty"],
                        "FTXthDocKey"=>"TCNTPdtAdjStkHD",
                        "FTXtdPdtName"=>$aData[$nI]["FTPdtName"],
                        "FCUserInPutForADJSTKVD"=>0,
                        "FNCabSeq" => $aData[$nI]["FNCabSeq"]
                    );
                    $this->mProducttransferwahousevd->FSxMUpdateDocTmpPdtFromDT($aInforInsert);
                }
            }
        
    }

    //Function : Adv Table Load Data
    public function FSvCTFWPdtAdvTblLoadData(){
        $nPage          = $this->input->post('nPageCurrent');
        $aInfoWhere     = array(
            "tBchCode"      =>  $this->input->post("tBchCode"),
            "tXthDocNo"     =>  $this->input->post("tXthDocNo"),
            "FTXthDocKey"   =>  "TCNTPdtAdjStkHD",
            "nPage"         =>  $nPage
        );

        $aDataInfor       = $this->mProducttransferwahousevd->FSaMTWXVDGetPdtLayoutFRomTem($aInfoWhere);
        // $aData            = $aDataInfor["aDetail"];
        $tPanelPdtStaShow = $this->input->post("tPanelPdtStaShow");
        $aInfor = array(
            "aData"             => $aDataInfor["aDetail"],
            "nAllPage"          => $aDataInfor["aDetailRow"],
            "tPanelPdtStaShow"  => $tPanelPdtStaShow,
            "nPage"             => $nPage
        );
        $this->load->view('document/adjuststockvd/advancetable/wNewProducttransferwahousePdtAdvTableDatavd',$aInfor);
    }

    /*
    Function : Adv Table Load Data
    Creater : 04/04/2019 Krit(Copter)
    */
    public function FSvCTFWVatLoadData(){

        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthVATInOrEx  = $this->input->post('tXthVATInOrEx');

        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
            'FTSesssionID'  => $this->session->userdata('tSesSessionID')
        );
        
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();

        // //คำนวน DT ใหม่
        $aResCalDTTmp   = $this->FSnCTFWCalulateDTTemp($tXthDocNo,$tXthVATInOrEx);

        $aDataVatDT     = $this->mProducttransferwahousevd->FSaMTFWGetVatDTTemp($aDataWhere);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aDataVatDT']        = $aDataVatDT;
        $aData['tXthVATInOrEx']     = $tXthVATInOrEx;

        $this->load->view('document/adjuststockvd/advancetable/wProducttransferwahouseVatTableDatavd',$aData);
        
    }

    /*
    Function : โหลดข้อมูลลง tmp
    Creater : 29/06/2019 pap
    */
    public function FSxCTWXVDPdtUpdateTem(){
        $aDataWhere = array(
            "FTBchCode"                     => $this->input->post("FTBchCode"),
            "FTXthDocNo"                    => $this->input->post("FTXthDocNo"),
            "FNLayRowForADJSTKVD"           => $this->input->post("FNLayRow"),
            "FNLayColForADJSTKVD"           => $this->input->post("FNLayCol"),
            "FCUserInPutForADJSTKVD"        => $this->input->post("FCUserInPutTransfer"),
            "FTXthDocKey"                   => "TCNTPdtAdjStkHD",
            "FTSessionID"                   => $this->session->userdata('tSesSessionID'),
            "FCDateTimeInputForADJSTKVD"    => date("Y-m-d H:i:s"),
            "FNCabSeqForTWXVD"              => $this->input->post("FNCabSeq"),
        );
        $this->mProducttransferwahousevd->FSxMUpdateTmpMaxTransfer($aDataWhere);

    }

    /*
    Function : คำนวนท้ายบิล และ ประกาศค่าคำนวน
    Creater : 04/04/2019 Krit(Copter)
    */
    public function FSvCTFWCalculateLastBill(){

        // $aDTValue['FTBchCode']
        $tXthDocNo      = $this->input->post('tXthDocNo');
        $tXthVATInOrEx  = $this->input->post('tXthVATInOrEx');

        $aDataWhere = array(
            'FTXthDocNo'    => $tXthDocNo,
            'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
        );

        //Get Option Save Decimal  
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        $aDataDTTmp =   $this->mProducttransferwahousevd->FSaMTFWGetDTTemp($aDataWhere);

        $FCXthTotal = 0;

        if($aDataDTTmp['rtCode'] == 1){

            $aDataDTTmp = $aDataDTTmp['raItems'];
            foreach ($aDataDTTmp as $key => $value){
                //รวมใน 
                if($tXthVATInOrEx == 1){
                    $FCXthTotal += $value['FCXtdVat']+$value['FCXtdVatable'];
                }else{
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

        }else{

            $aData = array(
                'tXphGndText'   => '-',
                'FCXthTotal'     => number_format($FCXthTotal, $nOptDecimalShow, '.', ',')
            );

        }

        echo json_encode($aData);
        
    }


    //Function : Adv Table Save
    public function FSvCTFWShowColSave(){

        FCNaDCLSetShowCol('TVDTPdtTwxDT','','');
        
        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        if($nStaSetDef == 1){
            FCNaDCLSetDefShowCol('TVDTPdtTwxDT');
        }else{
            for($i = 0; $i<FCNnHSizeOf($aColShowSet);$i++){
            
                FCNaDCLSetShowCol('TVDTPdtTwxDT',1,$aColShowSet[$i]);
            }
        }

        //Reset Seq
        FCNaDCLUpdateSeq('TVDTPdtTwxDT','','','');
        $q = 1;
        for($n = 0; $n<FCNnHSizeOf($aColShowAllList);$n++){
                
            FCNaDCLUpdateSeq('TVDTPdtTwxDT',$aColShowAllList[$n],$q , $aColumnLabelName[$n]);
            $q++;
        }
        
    }

    //Function : Adv Table Show
    public function FSvCTFWAdvTblShowColList(){

        $aAvailableColumn = FCNaDCLAvailableColumn('TVDTPdtTwxDT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/adjuststockvd/advancetable/wPurchaseTableShowColListvd',$aData);
        
    }



    //////////////////////////////////////////////////////////////////////////   Zone ค้นหา
    //Function : ค้นหา รายการ
    public function FSxCTFWFormSearchList(){

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TCNMBranch_L');
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
            'FTBchCode'		=> $this->session->userdata("tSesUsrBchCode"),
            'FTShpCode'		=> '',
            'nPage'         => 1,
            'nRow'          => 9999,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => ''
        );

        $aBchData = $this->mBranch->FSnMBCHList($aData);
        $aShpData = $this->mShop->FSaMSHPList($aData);

        $aDataMaster = array(
            'aBchData'   => $aBchData,
            'aShpData'   => $aShpData
        );

        $this->load->view('document/adjuststockvd/wProducttransferwahouseFormSearchListvd',$aDataMaster);
    }


    //Functionality : Event Delete Product
    //Parameters : Ajax jReason()
    //Creator : 10/04/2019 Krit(Copter)
    //Return : Status Delete Event
    //Return Type : String
    public function FSvCTFWPdtMultiDeleteEvent(){
        $FTXthDocNo = $this->input->post('tDocNo');
        $FTPdtCode  = $this->input->post('tPdtCode');
        $FTPunCode  = $this->input->post('tPunCode');
        $aSeqCode   = $this->input->post('tSeqCode');
        $tSession   = $this->session->userdata('tSesSessionID');
        $nCount     = FCNnHSizeOf($aSeqCode);

        if($nCount > 1){

            for($i=0;$i<$nCount;$i++){

                $aDataMaster = array(
                    'FTXthDocNo'    => $FTXthDocNo,
                    'FNXtdSeqNo'    => $aSeqCode[$i],
                    'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                    'FTSessionID'   => $tSession
                );
                $aResDel = $this->mProducttransferwahousevd->FSaMTFWPdtTmpMultiDel($aDataMaster);
            }

        }else{

            $aDataMaster = array(
                'FTXthDocNo'    => $FTXthDocNo,
                'FNXtdSeqNo'    => $aSeqCode[0],
                'FTXthDocKey'   => 'TCNTPdtAdjStkHD',
                'FTSessionID'   => $tSession
            );
            $aResDel = $this->mProducttransferwahousevd->FSaMTFWPdtTmpMultiDel($aDataMaster);
        }
        
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    public function FSxCTFXClearDocTemForChngCdt(){
        $tFTXthDocNo = $this->input->post('tDocNo');
        $tSession   = $this->session->userdata('tSesSessionID');
        $tbrachCode = $this->input->post('tBrachCode');
        $tDockey = "TCNTPdtAdjStkHD";
        $this->mProducttransferwahousevd->FSxMTFXClearDocTemForChngCdt(array(
            "tFTXthDocNo"=>$tFTXthDocNo,
            "tSession"=>$tSession,
            "tbrachCode"=>$tbrachCode,
            "tDockey"=>$tDockey
        ));
    }


    public function FSxCTWXCheckViaCodeForApv(){
        $tDocNo = $this->input->post('tXthDocNo');
        $aResult = $this->mProducttransferwahousevd->FSxMTWXCheckViaCodeForApv($tDocNo);
        if($aResult){
            if($aResult["FTViaCode"]!=""){
                $aSendData = array("staPrc"=>true,
                                   "staHasVia"=>true,
                                   "FTViaCode"=>$aResult["FTViaCode"]);
            }else{
                $aSendData = array("staPrc"=>true,
                                   "staHasVia"=>false,
                                   "FTViaCode"=>"");
            }
        }else{
            $aSendData = array("staPrc"=>false,
                                "staHasVia"=>false,
                                "FTViaCode"=>"");
        }
        echo json_encode($aSendData);
    }

}

