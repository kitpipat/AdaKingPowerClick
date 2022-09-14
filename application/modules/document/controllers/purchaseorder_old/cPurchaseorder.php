<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPurchaseorder extends MX_Controller {


	public function __construct() {
            parent::__construct ();
            $this->load->helper("file");
            $this->load->model('company/company/mCompany');
            $this->load->model('company/branch/mBranch');
            $this->load->model('company/shop/mShop');
            $this->load->model('payment/rate/mRate');
            
            $this->load->model('company/vatrate/mVatRate');
            $this->load->model('document/purchaseorder/mPurchaseorder');
    }

    public function index($nBrowseType,$tBrowseOption){

        $aData['nBrowseType']       = $nBrowseType;
        $aData['tBrowseOption']     = $tBrowseOption;
		$aData['aAlwEventPO']       = FCNaHCheckAlwFunc('po/0/0'); //Controle Event
        $aData['vBtnSave']          = FCNaHBtnSaveActiveHTML('po/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        //Get Option Show Decimal
        $aData['nOptDecimalShow']   = FCNxHGetOptionDecimalShow(); 
        $aData['nOptDecimalSave']   = FCNxHGetOptionDecimalSave(); 

        $this->load->view('document/purchaseorder/wPurchaseorder',$aData);

    }

    //////////////////////////////////////////////////////////////////////////   Zone Function Center
    //คำนวน ตัวเลขและค่า ในไฟล์ใหม่ หลังจากมีการแก้ไขตัวเลข เช่น แก้ไขจำนวน ราคาเปลี่ยน
    public function FCNoPOProcessCalculaterInFile($ptXphDocNo){

        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        //คำนวน Record ใหม่ถ้ามีการ Add และ Del Row
        if($this->FCNoPOCalculaterAFTAddHDDis($ptXphDocNo) === 1 ){

            if($this->FCNoPOAdjDTDisAFTAdjHDDis($ptXphDocNo) === 1){

                    ////คำนวน Record ใหม่ถ้ามีการ Add และ Del Row

                    //Get Data From File
                    $aDataFile = $this->FMaPOGetDataFormFile($ptXphDocNo);

                    $nNum = FCNnHSizeOf($aDataFile['DTData']);

                    $aArray['HDData'] = array();
                    $aArray['DTData'] = array();

                    $tDisChgTxt = '';
                    $nXddDis    = 0; 
                    $nXddChg    = 0;
                    $nSeq       = 0;

                    //รวมส่วนลด ท้ายบิล
                    $nXphDisSUM = 0;
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

                        $tXphDocNo = $aArray['DTData'][0]['FTXphDocNo'];

                        //รับค่าจาก input
                        $tXphVATInOrExFromInput = $this->session->userdata('tPOSesVATInOrEx'.$tXphDocNo);
                        if($tXphVATInOrExFromInput != ''){
                            $tXphVATInOrEx = $tXphVATInOrExFromInput;
                        }else{
                            //ถ้าไม่มี Get จาก Base
                            $tXphVATInOrEx = $this->mPurchaseorder->FCNxPOGetvatInOrEx($tXphDocNo);
                        }

                        //หา Sum HD Dis ท้ายบิล
                        foreach($aDataFile['HDData'] as $HDKey => $HDValue) {
                            $nXphDisSUM    = $nXphDisSUM+$HDValue['FCXphDis'];
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
                        
                            $tXphDocNo      = $value['FTXphDocNo'];
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
                            if($nXphDisSUM != 0 && $value['FTXpdStaAlwDis'] == 1){
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
                            if($tXphVATInOrEx == '1'){ 
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
                    if($ptXphDocNo != ''){
                        //PATHSupawat
                        $fp = fopen(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
                        file_put_contents(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
                        fclose($fp);
                    }

            }
        }
    }

    //Function : คำนวน Record ใหม่ถ้ามีการ Add และ Del Row ของ HDDis
    public function FCNoPOCalculaterAFTAddHDDis($ptXphDocNo){

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($ptXphDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        //Dis
        $cXphDisVat         = 0;
        $cXphDisNoVat       = 0;
        $cXphVatDisChgAvi   = 0;
        $cXphNoVatDisChgAvi = 0;
        //Chg
        $cXphChgVat     = 0;
        $cXphChgNoVat   = 0;
        
        //หา cXphVatDisChgAvi Sum ออกมาจาก DT
        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            foreach($aDataFile['DTData'] AS $key => $value){
                //สถานะอนุญาต ลด/ชาร์จ
                if($value['FTXpdStaAlwDis'] == 1){
                    //ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                    if($value['FTXpdVatType'] == 1){
                        //คำนวนยอดมีภาษีลดได้ FTXpdVatType=1 : SUM(DT.FCXpdDisChgAvi)
                        $cXphVatDisChgAvi   = $cXphVatDisChgAvi + $value['FCXpdNet'];
                    }else if($value['FTXpdVatType'] == 2){
                        $cXphNoVatDisChgAvi = $cXphNoVatDisChgAvi + $value['FCXpdNet'];
                    }
                }
            }
        }
        
        if(FCNnHSizeOf($aDataFile['HDData']) > 0){

            foreach($aDataFile['HDData'] AS $key=>$aValue){
                
                $aResCalDisChgTxt = $this->FMcCPOCalulateDisChgText($aValue['FTXphDisChgTxt'],$cXphVatDisChgAvi);

                //โปเลทส่วนลด
                if($aResCalDisChgTxt['CALFCXddDis'] > 0){
                    //check ตัวแปรว่าเป็น 0 หรือไม่ ถ้าเป็น 0 จะทำให้หารไม่ได้
                    $A = $aResCalDisChgTxt['CALFCXddDis']*$cXphVatDisChgAvi;
                    $B = $cXphVatDisChgAvi+$cXphNoVatDisChgAvi;
                    if($A == 0 && $B == 0){
                        $cXphDisVat = 0;
                    }else{
                        $cXphDisVat = ($aResCalDisChgTxt['CALFCXddDis']*$cXphVatDisChgAvi)/($cXphVatDisChgAvi+$cXphNoVatDisChgAvi);
                    }
                    
                    $cXphDisNoVat   = $aResCalDisChgTxt['CALFCXddDis']-$cXphDisVat;
                    
                    $aDataFile['HDData'][$key]['FCXphDis']     = number_format($aResCalDisChgTxt['CALFCXddDis'], $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphChg']     = number_format($aResCalDisChgTxt['CALFCXddChg'], $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphVatDisChgAvi']     = number_format($cXphVatDisChgAvi, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphNoVatDisChgAvi']   = number_format($cXphNoVatDisChgAvi, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphDisVat']           = number_format($cXphDisVat, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphDisNoVat']         = number_format($cXphDisNoVat, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphChgVat']           = number_format(0, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphChgNoVat']         = number_format(0, $nOptDecimalSave, '.', '');

                    //set ค่าทับตัวแปร
                    $cXphVatDisChgAvi = $cXphVatDisChgAvi-$cXphDisVat;
                    $cXphNoVatDisChgAvi = $cXphNoVatDisChgAvi-$cXphDisNoVat;
                }else{
                    //โปเลทชาร์จ

                    //check ตัวแปรว่าเป็น 0 หรือไม่ ถ้าเป็น 0 จะทำให้หารไม่ได้
                    $A = $aResCalDisChgTxt['CALFCXddChg']*$cXphVatDisChgAvi;
                    $B = $cXphVatDisChgAvi+$cXphNoVatDisChgAvi;
                    if($A == 0 && $B == 0){
                        $cXphChgVat = 0;
                    }else{
                        $cXphChgVat     = $aResCalDisChgTxt['CALFCXddChg']*$cXphVatDisChgAvi/($cXphVatDisChgAvi+$cXphNoVatDisChgAvi);
                    }
                    
                    $cXphChgNoVat   = $aResCalDisChgTxt['CALFCXddChg']-$cXphChgVat;
                    
                    $aDataFile['HDData'][$key]['FCXphDis']     = number_format($aResCalDisChgTxt['CALFCXddDis'], $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphChg']     = number_format($aResCalDisChgTxt['CALFCXddChg'], $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphVatDisChgAvi']     = number_format($cXphVatDisChgAvi, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphNoVatDisChgAvi']   = number_format($cXphNoVatDisChgAvi, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphChgVat']           = number_format($cXphChgVat, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphChgNoVat']         = number_format($cXphChgNoVat, $nOptDecimalSave, '.', '');

                    $aDataFile['HDData'][$key]['FCXphDisVat']           = number_format(0, $nOptDecimalSave, '.', '');
                    $aDataFile['HDData'][$key]['FCXphDisNoVat']         = number_format(0, $nOptDecimalSave, '.', '');

                    //set ค่าทับตัวแปร
                    $cXphVatDisChgAvi = $cXphVatDisChgAvi+$cXphChgVat;
                    $cXphNoVatDisChgAvi = $cXphNoVatDisChgAvi+$cXphChgNoVat;
                }

            }

        }

        $jDataArray = json_encode($aDataFile);
        if($ptXphDocNo != ''){
            //PATHSupawat
            $fp = fopen(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
            file_put_contents(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
            fclose($fp);
            return 1;
        }

    }

    //Function : คำนวนลดท้าบบิล HD ถ้ามีท้ายบอลจะ Add ลงตาราง DT FNXpdStaDis 2
    public function FCNoPOAdjDTDisAFTAdjHDDis($ptXphDocNo){

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($ptXphDocNo);

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
                                if($HDDisValue['FCXphDis'] > 0){
                                    //ถ้าเป็น Dis
                                    $A = $HDDisValue['FCXphDis']*$aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if($A == 0 && $B == 0){
                                        $cXddDis_Sta2 = 0;
                                    }else{
                                        $cXddDis_Sta2 = ($HDDisValue['FCXphDis']*$aDTValue['FCXpdNet'])/$cXpdNetSUM;
                                    }
                                    $cXddChg_Sta2 = 0;

                                    $cXddDis_Sta2SUM = number_format($cXddDis_Sta2SUM+$cXddDis_Sta2, $nOptDecimalSave, '.', '');
                                }else{
                                    //ถ้าเป็น Chg
                                    $A = $HDDisValue['FCXphChg']*$aDTValue['FCXpdNet'];
                                    $B = $cXpdNetSUM;
                                    if($A == 0 && $B == 0){
                                        $cXddChg_Sta2 = 0;
                                    }else{
                                        $cXddChg_Sta2 = ($HDDisValue['FCXphChg']*$aDTValue['FCXpdNet'])/$cXpdNetSUM;
                                    }
                                    $cXddDis_Sta2 = 0;

                                    $cXddChg_Sta2SUM = number_format($cXddChg_Sta2SUM+$cXddChg_Sta2, $nOptDecimalSave, '.', '');
                                }
                                
                            } else if ($i == $len-1) {
                                // last
                                if($HDDisValue['FCXphDis'] > 0){
                                    //ถ้าเป็น Dis
                                    $cXddDis_Sta2 = $HDDisValue['FCXphDis']-$cXddDis_Sta2SUM;
                                    $cXddChg_Sta2 = 0;
                                }else{
                                    //ถ้าเป็น Chg
                                    $cXddDis_Sta2 = 0;
                                    $cXddChg_Sta2 = $HDDisValue['FCXphChg']-$cXddChg_Sta2SUM;
                                }
                            }

                            $cXddDis_Sta2 = number_format($cXddDis_Sta2, $nOptDecimalSave, '.', '');
                            $cXddChg_Sta2 = number_format($cXddChg_Sta2, $nOptDecimalSave, '.', '');

                            $aDataSta2 = array(
                                'FTBchCode'         => $aDTValue['FTBchCode'],
                                'FTXphDocNo'        => $aDTValue['FTXphDocNo'],
                                'FNXpdSeqNo'        => $aDTValue['FNXpdSeqNo'],
                                'FDXddDateIns'      => $HDDisValue['FDXphDateIns'],
                                'FNXpdStaDis'       => 2,//ลดท้ายบิล จะเป็น 2 
                                'FCXddDisChgAvi'    => '0', //ยังไม่ปรับ -> ปรับ foreach ข้างล่าง
                                'FTXddDisChgTxt'    => $HDDisValue['FTXphDisChgTxt'],
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
                            $aResCalDisChgTxt = $this->FMcCPOCalulateDisChgText($DTDisValue['FTXddDisChgTxt'],$cXpdDisChgAvi);
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
        if($ptXphDocNo != ''){
            $fp = fopen(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
            file_put_contents(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
            fclose($fp);
            return 1;
        }

    }

    //Function : ปรับ DisChg Text 
    public function FMcCPOCalulateDisChgText($ptDisChgText,$ptDisChgAvi){

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
    public function FMaPOGetDataFormFile($ptXphDocNo){
        if($ptXphDocNo != ''){
            //Get Data From File
            $jData = file_get_contents(APPPATH."modules\document\document\\".$ptXphDocNo."-".$this->session->userdata('tSesUsername').".txt");
            // decode json to array
            $aDataFile = json_decode($jData, true);

            return $aDataFile;
        }
    }

    //Function : Get ที่อยู่
    public function FSvCPOGetShipAdd(){

        $tBchCode       = $this->input->post('tBchCode');
        $tXphShipAdd    = $this->input->post('tXphShipAdd');

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
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

        $aDataShipAdd = $this->mPurchaseorder->FSaMPOGetAddress($tBchCode,$tXphShipAdd,$nLangEdit); 

        echo json_encode($aDataShipAdd);

    }

    // Function : วาด Modal HDDis HTML ส่วนลดท้ายบิล
    public function FSvCPOGetHDDisTableData(){

        $tXphDocNo      = $this->input->post('tXphDocNo');
        $nXphVATInOrEx  = $this->input->post('nXphVATInOrEx');
        $nXphRefAEAmt   = $this->input->post('nXphRefAEAmt');
        $nXphVATRate    = $this->input->post('nXphVATRate');
        $nXphWpTax    = $this->input->post('nXphWpTax');

        //คำนวนใน File ใหม่ ก่อนดึงไฟล์
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 
        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        $cXphTotal = 0;
        // ยอดรวมก่อนลด SUM(DT.FCXpdNet)
        foreach($aDataFile['DTData'] AS $DTKey => $DTValue){
            $cXphTotal = $cXphTotal+$DTValue['FCXpdNet'];
        }

        
        $aData['nOptDecimalShow']= $nOptDecimalShow;
        $aData['aDataFile']     = $aDataFile;
        $aData['cXphTotal']     = $cXphTotal;
        $aData['nXphVATInOrEx'] = $nXphVATInOrEx;
        $aData['cXphRefAEAmt']  = $nXphRefAEAmt;
        $aData['nXphVATRate']   = $nXphVATRate;
        $aData['nXphWpTax']     = $nXphWpTax;

        $this->load->view('document/purchaseorder/advancetable/wPurchaseorderHDDisTableData',$aData);

    }

    // Function : วาด Modal DTDis HTML ส่วนลดรายการ
    public function FSvCPOGetDTDisTableData(){

        $nKey       = $this->input->post('nKey');
        $tXphDocNo  = $this->input->post('tDocNo');
        $nPdtCode   = $this->input->post('nPdtCode');
        $nPunCode   = $this->input->post('nPunCode');
        $nSeqNo     = $this->input->post('nSeqNo');
        
        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);
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

        $this->load->view('document/purchaseorder/advancetable/wPurchaseorderDTDisTableData',$aData);

    }

    //Function : get ร้านค้า ใน สาขา
    public function FSvCPOGetShpByBch(){

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
    public function FSvCPOGetPdtBarCode(){

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
    public function FSvCPOSetSessionVATInOrEx(){
        
        $ptXphDocNo = $this->input->post('ptXphDocNo');
        $tXphVATInOrEx = $this->input->post('tXphVATInOrEx');

        $this->session->set_userdata ("tPOSesVATInOrEx".$ptXphDocNo, $tXphVATInOrEx);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($ptXphDocNo); 
    }




    //////////////////////////////////////////////////////////////////////////   Zone แก้ไข
    //Functionality : Event Edit Master
    public function FSaCPOEditEvent(){

        //คำนวนใน File ใหม่
        $tXphDocNo = $this->input->post('oetXphDocNo');
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        // $tSpmStaRcvFree = $this->FSsCReturnCheckBox($this->input->post('ocbSpmStaRcvFree'));
        $nXphDocType    = FCNnDOCGetDocType('TAPTOrdHD');

        try{
            $aDataMaster = array(
                'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),    
                'FTXphDocNo'            => $this->input->post('oetXphDocNo'),
                'FTShpCode'             => $this->input->post('oetShpCode'),
                'FNXphDocType'          => $nXphDocType,
                'FDXphDocDate'          => $this->input->post('oetXphDocDate'),   
                'FTXphCshOrCrd'         => $this->input->post('ostXphCshOrCrd'),
                'FTXphVATInOrEx'        => $this->input->post('ostXphVATInOrEx'),
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTWahCode'             => $this->input->post('ohdWahCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTXphApvCode'          => $this->input->post('oetXphApvCode'),
                'FTSplCode'             => $this->input->post('oetSplCode'),
                'FTXphRefExt'           => $this->input->post('oetXphRefExt'),
                'FDXphRefExtDate'       => $this->FStCCheckDateNULL($this->input->post('oetXphRefExtDate')),
                'FTXphRefInt'           => $this->input->post('oetXphRefInt'),
                'FDXphRefIntDate'       => $this->FStCCheckDateNULL($this->input->post('oetXphRefIntDate')),
                'FTXphRefAE'            => '',  //อ้างถึงเอกสาร มัดจำ
                'FNXphDocPrint'         => 0,
                'FTRteCode'             => $this->input->post('oetRteCode'),
                'FCXphRteFac'           => number_format($this->input->post('ohdXphRteFac'), $nOptDecimalSave, '.', ''),
                'FTVatCode'             => $this->input->post('ohdVatCode'),
                'FCXphVATRate'          => number_format($this->input->post('oetXphVatRateInput'), $nOptDecimalSave, '.', ''), //DHDis VATRate สามารถปรับได้

                'FCXphTotal'            => 0,   //ยอดรวมก่อนลด
                'FCXphVatNoDisChg'      => 0,   
                'FCXphNoVatNoDisChg'    => 0,
                'FCXphVatDisChgAvi'     => 0,
                'FCXphNoVatDisChgAvi'   => 0, 
                'FCXphDis'              => 0, 
                'FCXphChg'              => 0, 
                'FCXphRefAEAmt'         => number_format($this->input->post('oetXphRefAEAmtInput'), $nOptDecimalSave, '.', ''), 
                'FCXphVatAfDisChg'      => 0, 
                'FCXphNoVatAfDisChg'    => 0, 
                'FCXphAfDisChgAE'       => 0, 
                'FTXphWpCode'           => '',
                'FCXphVat'              => 0,
                'FCXphVatable'          => 0,
                'FCXphGrandB4Wht'       => 0,
                'FCXphWpTax'            => number_format($this->input->post('oetFCXphWpTaxInput'), $nOptDecimalSave, '.', ''),
                'FCXphGrand'            => 0,
                'FCXphRnd'              => 0,   //PO Default 0
                'FTXphGndText'          => '',
                'FCXphPaid'             => 0,
                'FCXphLeft'             => 0,
                'FTXphStaRefund'        => 1,   //Default 1
                'FTXphRmk'              => $this->input->post('otaXphRmk'),
                'FTXphStaDoc'           => 1,   //1 after save
                'FTXphStaApv'           => '',  //สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXphStaPrcStk'        => '',  //สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXphStaPaid'          => 1,   //สถานะ รับ/จ่ายเงิน 1:ยังไม่จ่าย 2:บางส่วน, 3:ครบ Default 1
                'FNXphStaDocAct'        => $this->FSsCReturnCheckBox($this->input->post('ocbXphStaDocAct')),    //สถานะ เคลื่อนไหว 0:NonActive, 1:Active Default 1
                'FNXphStaRef'           => 0,   //Default 0
                'FDLastUpdOn'           => date('Y-m-d'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
            );

            $aDataHDSpl = array(
                'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),    
                'FTXphDocNo'            => $this->input->post('oetXphDocNo'),
                'FTXphDstPaid'          => $this->input->post('ostXphDstPaid'),
                'FNXphCrTerm'           => $this->input->post('oetXphCrTerm'),
                'FDXphDueDate'          => $this->input->post('oetXphDueDate'),   
                'FDXphBillDue'          => $this->input->post('oetXphBillDue'),
                'FTXphCtrName'          => $this->input->post('oetXphCtrName'),
                'FDXphTnfDate'          => $this->input->post('oetXphTnfDate'),
                'FTXphRefTnfID'         => '',
                'FTXphRefVehID'         => $this->input->post('oetXphRefVehID'),
                'FTXphRefInvNo'         => $this->input->post('oetXphRefInvNo'),
                'FTXphQtyAndTypeUnit'   => $this->input->post('oetXphQtyAndTypeUnit'),
                'FNXphShipAdd'          => $this->input->post('ohdXphShipAdd'),
                'FNXphTaxAdd'           => $this->input->post('ohdXphTaxAdd'),
            );

            $this->db->trans_begin();

                //อนุญาติให้บันทึกสินค้าที่มีจำนวนสั่งซื้อเป็น 0 => 1 อนุญาต 
                $nOptAlwSavQty0 = $this->input->post('ohdOptAlwSavQty0');

                //1 อนุญาต 
                if($nOptAlwSavQty0 == 1){
                    $nAlwSave = 1; //1 อนุญาตส่งไป Save
                }else{
                //2 ไม่อนุญาต 
                //ต้องวิ่ง Check Qty ใน ตัวแปร

                    //Get Data From File
                    $tXphDocNo = $this->input->post('oetXphDocNo');
                    $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);
                    $nCountQtyPdt = 0;
                    if(is_array($aDataFile['DTData']) == 1){
                        foreach ($aDataFile['DTData'] as $key => $value) {
                            $nCountQtyPdt = $nCountQtyPdt+$value['FCXpdQty'];
                        }
                    }

                    if($nCountQtyPdt == 0){
                        $nAlwSave = 0; //0 ไม่อนุญาตส่งไป Save
                    }else{
                        $nAlwSave = 1; //1 อนุญาตส่งไป Save
                    }

                }
                

                if($nAlwSave == 1 ){
                    $aStaSdtOrdHD       = $this->mPurchaseorder->FSaMPOAddUpdateOrdHD($aDataMaster); /*ลงตาราง TAPTOrdHD */
                    $aStaEventOrdHDSpl  = $this->mPurchaseorder->FSaMPOAddUpdateOrdHDSpl($aDataHDSpl); /*ลงตาราง TAPTOrdHD */
                    $aStaEventOrdDT     = $this->FSaMPOAddDT();
                    $aStaEventOrdDTDis  = $this->FSaMPOAddDTDis();
                    $aStaEventOrdHDDis  = $this->FSaMPOAddHDDis();

                    if($this->db->trans_status() === FALSE){
                        $this->db->trans_rollback();
                        $aReturn = array(
                            'nStaEvent'    => '900',
                            'tStaMessg'    => "Unsucess Add Event"
                        );
                    }else{
                        $this->db->trans_commit();
                        $aReturn = array(
                            'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                            'tCodeReturn'	=> $aDataMaster['FTXphDocNo'],
                            'nStaEvent'	    => '1',
                            'tStaMessg'		=> 'Success Add Event'
                        );
                    }
                }else{

                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataMaster['FTXphDocNo'],
                        'nStaEvent'	    => '900',
                        'tStaMessg'		=> 'จำนวน Qty เป็น 0 ไม่สามารถบันทึกเอกสารได้'
                    );

                }

                echo json_encode($aReturn);

        }catch(Exception $Error){
            echo $Error;
        }
   
    }

    //Function : แก้ไข Pdt DT
    public function FSvCPOEditPdtIntoTableDT(){

        $tXphDocNo  = $this->input->post('ptXphDocNo');
        $tEditSeqNo = $this->input->post('ptEditSeqNo');
        $aField 	= $this->input->post('paField');
        $aValue 	= $this->input->post('paValue');

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $Array = array();

        foreach ($aDataFile['DTData'] as $key => $value) {
            if($value['FNXpdSeqNo'] == $tEditSeqNo){
                foreach($aField AS $FKey => $FValue){
                    $aDataFile['DTData'][$key][$FValue] = ($aValue[$FKey] != '') ? $aValue[$FKey] : 0 ;
                }
            }
        }

        //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", json_encode($aDataFile));
        fclose($fp);
        
        // //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //Function : Edit Inline DTDis แก้ไข ส่วนลด ท้ายบิล
    public function FSvCPOEditHDDis(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXphDocNo      = $this->input->post('oetXphDocNo');
        $tIndex         = $this->input->post('tIndex');
        $tDisChgText    = $this->input->post('tHDDisChgType');
        $cXddDisValue   = $this->input->post('tHDDisChgValue');

        $cXddDisValue = number_format($cXddDisValue, $nOptDecimalSave, '.', '');

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

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
        $aDataFile['HDData'][$tIndex]['FTXphDisChgTxt'] = $tDisChgTxt;

        //Add ลงไฟล์
        $jDataArray = json_encode($aDataFile);
        //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //Function : Edit Inline DTDis แก้ไข ส่วนลด รายการสินค้า
    public function FSvCPOEditDTDis(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $nKey           = $this->input->post('nKey');
        $tXphDocNo      = $this->input->post('tDocNo');
        $tIndex         = $this->input->post('tIndex');
        $tDisChgText    = $this->input->post('tDTDisChgType');
        $cXddDisValue = $this->input->post('tDTDisChgValue');

        $cXddDisValue = number_format($cXddDisValue, $nOptDecimalSave, '.', '');

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

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
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //Function : คำนวน ยอดต่างๆ ของ HD ใหม่ เพราะ DT เปลี่ยน 
    public function FSnPOUpdateHD(){
        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 
        
        $tXphDocNo      = $this->input->post('oetXphDocNo');
        $oetXphWpTax    = $this->input->post('oetFCXphWpTaxInput');

        //Get ค่า VATRate
        $cVatRate = $this->mPurchaseorder->FScMPOGetVatRateFromDoc($tXphDocNo);

        //Get ค่า VAT InOrEx
        $tXphVATInOrEx = $this->mPurchaseorder->FCNxPOGetvatInOrEx($tXphDocNo);

        //get จาก DT
        //ยอดรวมก่อนลด
        $cXphTotal          = $this->mPurchaseorder->FSaMPOGetHDFCXphTotal($tXphDocNo); 
        //ยอดรวมมีภาษีห้ามลด
        $cXphVatNoDisChg    = $this->mPurchaseorder->FSaMPOGetHDFCXphVatNoDisChg($tXphDocNo); 
        // echo "ยอดรวมมีภาษีห้ามลด :".$cXphVatNoDisChg."<br>";
        //ยอดรวมไม่มีภาษีห้ามลด
        $cXphNoVatNoDisChg  = $this->mPurchaseorder->FSaMPOGetHDFCXphNoVatNoDisChg($tXphDocNo); 
        // echo "ยอดรวมไม่มีภาษีห้ามลด :".$cXphNoVatNoDisChg."<br>";
        //ยอดมีภาษีลดได้ 
        $cXphVatDisChgAvi   = $this->mPurchaseorder->FSaMPOGetHDFCXphVatDisChgAvi($tXphDocNo); 
        // echo "ยอดมีภาษีลดได้ :".$cXphVatDisChgAvi."<br>";
        //ยอดไม่มีภาษีลดได้ 
        $cXphNoVatDisChgAvi = $this->mPurchaseorder->FSaMPOGetHDFCXphNoVatDisChgAvi($tXphDocNo); 
        // echo "ยอดไม่มีภาษีลดได้ :".$cXphNoVatDisChgAvi."<br>";
    
        //ข้อมูลการ ลด ชาร์จ
        $aXphDisChgTxt = $this->mPurchaseorder->FSaMPOGetHDFTXphDisChgTxt($tXphDocNo); 
        $tDisChgTxt = '';
        if($aXphDisChgTxt != 0){
            foreach ($aXphDisChgTxt as $key => $value) {
                $tDisChgTxt .=  $value->FTXphDisChgTxt.',';
            }
            $tDisChgTxt = substr($tDisChgTxt, 0, -1);
        }

        //get จาก HDDis
        //มูลค่ารวมส่วนลด
        $cXphDis            = $this->mPurchaseorder->FSaMPOGetHDFCXphDis($tXphDocNo); 
        //มูลค่ารวมส่วนชาร์จ
        $cXphChg            = $this->mPurchaseorder->FSaMPOGetHDFCXphChg($tXphDocNo); 

        //ยอดรวมมีภาษีหลังลด FCXphVatDisChgAvi-SUM(HDis.FCXddDisVat-HDis.FCXddChgVat)
        //Get SUM(HDis.FCXddDisVat-HDis.FCXddChgVat)
        $cXphDisRes    = $this->mPurchaseorder->FSaMPOGetSUMFCXddDisVatMinusFCXddChgVat($tXphDocNo);
        $cXphVatAfDisChg    = $cXphVatDisChgAvi-$cXphDisRes;
        // echo "ยอดรวมมีภาษีหลังลด :".$cXphVatAfDisChg."<br>";

        //ยอดรวมไม่มีภาษีหลังลด
        $cXphNoVatAfDisChg  = $this->mPurchaseorder->FSaMPOGetHDFCXphNoVatAfDisChg($tXphDocNo);
        // echo $cXphNoVatAfDisChg."<br>";

        //ยอดมัดจำ 
        $cFCXphRefAEAmt  = $this->mPurchaseorder->FSaMPOGetFCXphRefAEAmt($tXphDocNo);
        // echo "ยอดมัดจำ :".$cFCXphRefAEAmt."<br>";

        //ยอดรวมหลัง ลด-ชาร์จ+มัดจำ (FCXphVatNoDisChg+FCXphNoVatNoDisChg)+(FCXphVatAfDisChg+FCXphNoVatAfDisChg)-FCXphRefAEAmt
        $cXphAfDisChgAE = ($cXphVatNoDisChg+$cXphNoVatNoDisChg)+($cXphVatAfDisChg+$cXphNoVatAfDisChg)-$cFCXphRefAEAmt;
        // echo "Result:".$cXphAfDisChgAE;

        //ยอดภาษี (FCXphVatNoDisChg+FCXphVatAfDisChg) In/Ex
        $cResSum = $cXphVatNoDisChg+$cXphVatAfDisChg-$cFCXphRefAEAmt;
        if($tXphVATInOrEx == 1){
            //In รวมใน 
            $cXphVat = $cResSum-(($cResSum*100)/(100+$cVatRate));
        }else{
            //Ex แยกนอก
            $cXphVat = (($cResSum*(100+$cVatRate))/100)-$cResSum;
        }

        //ยอดแยกภาษี (FCXphVatNoDisChg+FCXphVatAfDisChg)-FCXphVat
        $cXphVatable = ($cXphVatNoDisChg+$cXphVatAfDisChg-$cFCXphRefAEAmt)-$cXphVat;

        //ยอดรวมสุทธิ ก่อน ภาษี ณ ที่จ่าย IN:FCXphVat+FCXphVatable , EX : FCXphAfDisChgAE+FCXphVat
        if($tXphVATInOrEx == 1){
            //IN: FCXphVat+FCXphVatable
            $cXphGrandB4Wht = $cXphVat+$cXphVatable;
        }else{
            //EX : FCXphAfDisChgAE+FCXphVat
            $cXphGrandB4Wht = $cXphAfDisChgAE+$cXphVat;
        }
        
        if($oetXphWpTax != ''){
            // ภาษีหัก ณ ที่จ่าย SUM(FCXpdWhtAmt)  /Key In
            $cXphWpTax = $oetXphWpTax;
        }else{
            $cXphWpTax = $this->mPurchaseorder->FSaMPOGetHDFCXphWpTax($tXphDocNo);
        }

        // ยอดรวม FCXphGrandB4Wht-FCXphWpTax
        $cXphGrand = $cXphGrandB4Wht-$cXphWpTax;

        //ข้อความ ยอดรวมสุทธิ(FCXphGrand)
        $tXphGndText = number_format($cXphGrand, 2, '.', ' ');
        $tXphGndText = FCNtNumberToTextBaht($tXphGndText);

        //ยอดค้าง Default: FCXphGrand
        $cXphLeft = $cXphGrand;

        $Data = array(
            'FCXphTotal'            => number_format($cXphTotal, $nOptDecimalSave, '.', ''),
            'FCXphVatNoDisChg'      => number_format($cXphVatNoDisChg, $nOptDecimalSave, '.', ''),
            'FCXphNoVatNoDisChg'    => number_format($cXphNoVatNoDisChg, $nOptDecimalSave, '.', ''),
            'FCXphVatDisChgAvi'     => number_format($cXphVatDisChgAvi, $nOptDecimalSave, '.', ''),
            'FCXphNoVatDisChgAvi'   => number_format($cXphNoVatDisChgAvi, $nOptDecimalSave, '.', ''),
            'FTXphDisChgTxt'        => $tDisChgTxt,
            'FCXphDis'              => number_format($cXphDis, $nOptDecimalSave, '.', ''),
            'FCXphChg'              => number_format($cXphChg, $nOptDecimalSave, '.', ''),
            'FCXphRefAEAmt'         => number_format($this->input->post('oetXphRefAEAmtInput'), $nOptDecimalSave, '.', ''), //Default 0 
            'FCXphVatAfDisChg'      => number_format($cXphVatAfDisChg, $nOptDecimalSave, '.', ''),
            'FCXphNoVatAfDisChg'    => number_format($cXphNoVatAfDisChg, $nOptDecimalSave, '.', ''),
            'FCXphAfDisChgAE'       => number_format($cXphAfDisChgAE, $nOptDecimalSave, '.', ''),
            'FTXphWpCode'           => '',
            'FCXphVat'              => number_format($cXphVat, $nOptDecimalSave, '.', ''),
            'FCXphVatable'          => number_format($cXphVatable, $nOptDecimalSave, '.', ''),
            'FCXphGrandB4Wht'       => number_format($cXphGrandB4Wht, $nOptDecimalSave, '.', ''),
            // 'FCXphWpTax'            => $cXphWpTax,
            'FCXphGrand'            => number_format($cXphGrand, $nOptDecimalSave, '.', ''),
            'FTXphGndText'          => $tXphGndText,
            'FCXphLeft'             => number_format($cXphLeft, $nOptDecimalSave, '.', ''),
        );


        // echo "<pre>";
        // print_r($Data);
        // echo "<pre>";

        $DataWhere = array(
            'FTXphDocNo' => $tXphDocNo,
        );

        $aStaUpdOrdHD = $this->mPurchaseorder->FSaMPOUpdateOrdHD($Data,$DataWhere); /*ลงตาราง TAPTOrdHD */

    }

    //Function : Approve Doc
    public function FSvCPOApprove(){

        $tXphDocNo = $this->input->post('tXphDocNo');

        $aDataUpdate = array(
            'FTXphDocNo' => $tXphDocNo,
            'FTXphApvCode' => $this->session->userdata('tSesUsername')
        );

        $aStaApv = $this->mPurchaseorder->FSvMPOApprove($aDataUpdate); 

        if($aStaApv['rtCode'] == 1){
            $aApv = array(
                'nSta' => 1,
                'tMsg' => "Approve done.",
            );
        }else{
            $aApv = array(
                'nSta' => 2,
                'tMsg' => "Not Approve.",
            );
        }
        echo json_encode($aApv);

    }

    //Function : Approve Doc
    public function FSvCPOCancel(){

        $tXphDocNo = $this->input->post('tXphDocNo');

        $aDataUpdate = array(
            'FTXphDocNo' => $tXphDocNo,
        );

        $aStaApv = $this->mPurchaseorder->FSvMPOCancel($aDataUpdate); 

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
    //Functionality : Event Add Master
    public function FSaCPOAddEvent(){

        $nXphDocType = $oDocType  = FCNnDOCGetDocType('TAPTOrdHD');

        //คำนวนใน File ใหม่
        $tXphDocNo = $this->input->post('oetXphDocNo');
        // FCNxClearDataInFile($tXphDocNo);
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        //Get RateFact
        $tRteCode       = $this->input->post('oetRteCode');
        $cXphRteFac     = FCNcDOCGetRateFac($tRteCode); 

        //Get Vat Data
        $aVatCode       = FCNcDOCGetVatData();
        $tVatCode       = $aVatCode['tVatCode'];
        $cVatRate       = $aVatCode['cVatRate'];

        try{
            $aDataMaster = array(
                'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),
                'FTXphDocNo'            => $tXphDocNo,
                'FTShpCode'             => $this->input->post('oetShpCode'),
                'FNXphDocType'          => $nXphDocType,
                'FDXphDocDate'          => $this->input->post('oetXphDocDate'),   
                'FTXphCshOrCrd'         => $this->input->post('ostXphCshOrCrd'),
                'FTXphVATInOrEx'        => $this->input->post('ostXphVATInOrEx'),
                'FTDptCode'             => $this->input->post('ohdDptCode'),
                'FTWahCode'             => $this->input->post('ohdWahCode'),
                'FTUsrCode'             => $this->input->post('oetUsrCode'),
                'FTXphApvCode'          => $this->input->post('oetXphApvCode'),
                'FTSplCode'             => $this->input->post('oetSplCode'),
                'FTXphRefExt'           => $this->input->post('oetXphRefExt'),
                'FDXphRefExtDate'       => $this->FStCCheckDateNULL($this->input->post('oetXphRefExtDate')),
                'FTXphRefInt'           => $this->input->post('oetXphRefInt'),
                'FDXphRefIntDate'       => $this->FStCCheckDateNULL($this->input->post('oetXphRefIntDate')),
                'FTXphRefAE'            => '',  //อ้างถึงเอกสาร มัดจำ
                'FNXphDocPrint'         => 0, //Def 0
                'FTRteCode'             => $tRteCode,
                'FCXphRteFac'           => number_format($cXphRteFac, $nOptDecimalSave, '.', ''),
                'FTVatCode'             => $tVatCode,
                'FCXphVATRate'          => number_format($cVatRate, $nOptDecimalSave, '.', ''),
                
                'FCXphTotal'            => 0,   //ยอดรวมก่อนลด
                'FCXphVatNoDisChg'      => 0,
                'FCXphNoVatNoDisChg'    => 0,
                'FCXphVatDisChgAvi'     => 0,
                'FCXphNoVatDisChgAvi'   => 0, 
                'FCXphDis'              => 0, 
                'FCXphChg'              => 0, 
                'FCXphRefAEAmt'         => number_format($this->input->post('oetXphRefAEAmtInput'), $nOptDecimalSave, '.', ''), 
                'FCXphVatAfDisChg'      => 0, 
                'FCXphNoVatAfDisChg'    => 0, 
                'FCXphAfDisChgAE'       => 0, 
                'FTXphWpCode'           => '',
                'FCXphVat'              => 0,
                'FCXphVatable'          => 0,
                'FCXphGrandB4Wht'       => 0,
                'FCXphWpTax'            => number_format($this->input->post('oetFCXphWpTaxInput'), $nOptDecimalSave, '.', ''),
                'FCXphGrand'            => 0,
                'FCXphRnd'              => 0,   //PO Default 0
                'FTXphGndText'          => '',
                'FCXphPaid'             => 0,
                'FCXphLeft'             => 0,
                'FTXphStaRefund'        => 1,  //Default 1
                'FTXphRmk'              => $this->input->post('otaXphRmk'),
                'FTXphStaDoc'           => 1, //1 after save
                'FTXphStaApv'           => '',  //สถานะ อนุมัติ เอกสาร ว่าง:ยังไม่ทำ, 1:อนุมัติแล้ว 
                'FTXphStaPrcStk'        => '',  //สถานะ ประมวลผลสต๊อก ว่าง หรือ Null:ยังไม่ทำ, 1:ทำแล้ว
                'FTXphStaPaid'          => 1,   //สถานะ รับ/จ่ายเงิน 1:ยังไม่จ่าย 2:บางส่วน, 3:ครบ Default 1
                'FNXphStaDocAct'        => $this->FSsCReturnCheckBox($this->input->post('ocbXphStaDocAct')),    //สถานะ เคลื่อนไหว 0:NonActive, 1:Active Default 1
                'FNXphStaRef'           => 0,   //Default 0
                'FDLastUpdOn'           => date('Y-m-d'),
                'FDCreateOn'            => date('Y-m-d'),
                'FTCreateBy'            => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'),
            );

            

            $aDataHDSpl = array(
                'FTBchCode'             => $this->session->userdata('tSesUsrBchCode'),    
                'FTXphDocNo'            => $this->input->post('oetXphDocNo'),
                'FTXphDstPaid'          => $this->input->post('ostXphDstPaid'),
                'FNXphCrTerm'           => $this->input->post('oetXphCrTerm'),
                'FDXphDueDate'          => $this->input->post('oetXphDueDate'),   
                'FDXphBillDue'          => $this->input->post('oetXphBillDue'),
                'FTXphCtrName'          => $this->input->post('oetXphCtrName'),
                'FDXphTnfDate'          => $this->input->post('oetXphTnfDate'),
                'FTXphRefTnfID'         => '',
                'FTXphRefVehID'         => $this->input->post('oetXphRefVehID'),
                'FTXphRefInvNo'         => $this->input->post('oetXphRefInvNo'),
                'FTXphQtyAndTypeUnit'   => $this->input->post('oetXphQtyAndTypeUnit'),
                'FNXphShipAdd'          => $this->input->post('ohdXphShipAdd'),
                'FNXphTaxAdd'           => $this->input->post('ohdXphTaxAdd'),
            );


            $oCountDup  = $this->mPurchaseorder->FSnMPOCheckDuplicate($aDataMaster['FTXphDocNo']);
            $nStaDup    = $oCountDup[0]->counts;
            if($nStaDup == 0){
                $this->db->trans_begin();
                $aStaSdtOrdHD       = $this->mPurchaseorder->FSaMPOAddUpdateOrdHD($aDataMaster); /*ลงตาราง TAPTOrdHD */
                $aStaEventOrdHDSpl  = $this->mPurchaseorder->FSaMPOAddUpdateOrdHDSpl($aDataHDSpl); /*ลงตาราง TAPTOrdHD */
                $aStaEventOrdDT     = $this->FSaMPOAddDT();
                $aStaEventOrdDTDis  = $this->FSaMPOAddDTDis();
                $aStaEventOrdHDDis  = $this->FSaMPOAddHDDis();
                
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
                        'tCodeReturn'	=> $aDataMaster['FTXphDocNo'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => language('document/purchaseorder/purchaseorder', 'tPOMsgDuplicate')
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Function : Add DT
    public function FSaMPOAddDT(){

        $aStaEventDelDT =  $this->mPurchaseorder->FSnMPMTDelPcoDT($this->input->post('oetXphDocNo')); //*ลบ Data เก่าออก*/

        //Get Data From File
        $tXphDocNo = $this->input->post('oetXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        $nNum = FCNnHSizeOf($aDataFile['DTData']);
        
        if($nNum != 0){
            foreach ($aDataFile['DTData'] as $key => $value) {
            
                $this->db->trans_begin();

                $aStaEventOrdHDSpl  = $this->mPurchaseorder->FSaMPOAddUpdateOrdDT($value); /*ลงตาราง TAPTOrdDT */

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }

            }
        }

    }

    //Function : Add DT Dis
    public function FSaMPOAddDTDis(){

        //Get Data From File
        $tXphDocNo = $this->input->post('oetXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);
    
        $aStaEventDelDTDis =  $this->mPurchaseorder->FSnMPMTDelPcoDTDis($tXphDocNo); //*ลบ Data เก่าออก*/

        $nNum = FCNnHSizeOf($aDataFile['DTData']);
    
        if($nNum != 0){
    
            foreach ($aDataFile['DTData'] as $key => $valueDT) {
    
                $tXphDocNo      = $valueDT['FTXphDocNo'];
                $nSeqNo         = $valueDT['FNXpdSeqNo'];
                $cXpdAmt        = $valueDT['FCXpdAmt'];
                $cXpdVatRate    = $valueDT['FCXpdVatRate'];
                $cXpdWhtRate    = $valueDT['FCXpdWhtRate'];
                $cXpdQty        = $valueDT['FCXpdQty'];
                $cXpdQtyAll     = $valueDT['FCXpdQtyAll'];
                
                
                foreach($valueDT['DTDiscount'] as $keyDis => $valueDTDis) {
    
                    $this->db->trans_begin();
    
                    $aStaEventOrdDTDis  = $this->mPurchaseorder->FSaMPOAddUpdateOrdDTDis($valueDTDis); /*ลงตาราง TAPTOrdDTDis */
    
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
                    'FTXphDocNo' => $valueDT['FTXphDocNo'],
                    'FNXpdSeqNo' => $valueDT['FNXpdSeqNo']
                );
                
                $this->db->trans_begin();
    
                $aStaUpdDT  = $this->mPurchaseorder->FSaMPOUpdateOrdDT($aDTData,$aDTDataWhere); /*Update TAPTOrdDT ใหม่ */
    
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }
    
            }
    
        }
        
    }

    //Function : Add HD Dis
    public function FSaMPOAddHDDis(){

        //Get Data From File
        $tXphDocNo = $this->input->post('oetXphDocNo');
        $aDataFile  = $this->FMaPOGetDataFormFile($tXphDocNo);
        $nNum       = FCNnHSizeOf($aDataFile['HDData']);

        $aStaEventDelHDDis =  $this->mPurchaseorder->FSnMPMTDelPcoHDDis($tXphDocNo); //* ลบ Data เก่าออก */

     
        if($nNum > 0){
            
            foreach ($aDataFile['HDData'] as $key => $value) {
            
                $this->db->trans_begin();

                $aStaEventOrdHDDis  = $this->mPurchaseorder->FSaMPOAddUpdateOrdHDDis($value); /*ลงตาราง TAPTOrdDT*/

                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                }else{
                    $this->db->trans_commit();
                }

            }
            //ปรับ HD ใหม่ตาม DT
            $this->FSnPOUpdateHD();
        }else{
            //ปรับ HD ใหม่ตาม DT
            $this->FSnPOUpdateHD();
        }
           
    }

    //Function : Add Pdt ลง Dt (File)
    public function FSvCPOAddPdtIntoTableDT(){

        $tXphDocNo 	= $this->input->post('ptXphDocNo');
        $tBchCode 	= $this->input->post('ptBchCode');
        $tPdtCode 	= $this->input->post('ptPdtCode');
        $tPunCode 	= $this->input->post('ptPunCode');
        $tOptDocAdd = $this->input->post('ptOptDocAdd');
        $tXphVATInOrEx = $this->input->post('pnXphVATInOrEx'); /*ประเภท Vat ของ SPL (รวม,แยก)*/
        
        $aDataPdt = array(
            'FTPdtCode' => $tPdtCode,
            'FTPunCode' => $tPunCode,
            'FNLngID' => 1,
        );

        $aDataPdtDT     = $this->mPurchaseorder->FSaMPOGetPdtIntoTableDT($aDataPdt);   // Data Pdt
        $FCXphRteFac    = $this->mPurchaseorder->FSaMPOGetRteFacHD($tXphDocNo);        // Get RteFac From HD

        $aColumnAll = FCNaDCLGetAllColumn('TAPTOrdDT');
        $aData['aColumnAll'] = $aColumnAll;
        $aData['aDataPdtDT'] = @$aDataPdtDT['raItem'];

        $aArray['HDData'] = array();
        $aArray['DTData'] = array();

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        //Get Option Show Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $nNum = FCNnHSizeOf($aDataFile['DTData']);
        $nSeq = 0;
        $nStaAddOn = 0; //ตัวแปรเช็คสถานะการเพิ่ม Pdt , Puncode

        if($nNum != 0){
            
            foreach ($aDataFile['HDData'] as $key => $value) {
                array_push($aArray['HDData'],$value);
            }

            foreach ($aDataFile['DTData'] as $key => $value) {
                array_push($aArray['DTData'],$value);
                $nSeq = $nSeq+1;
            }
        
        }

        //เก็บ Array ที่มีค่า Return มาเข้าตัวแปล เพื่อเรียกใช้ได้ง่าย
        $aDataPdtPrg = @$aDataPdtDT['raItem'];

        // Start Cal Progress 
        $FCXpdQty       = $aDataPdtPrg['FCPdtUnitFact'];     //key in
        $FCXpdFactor    = $aDataPdtPrg['FCPdtUnitFact'];    //จำนวนชื้น ตาม หน่วย
        $FCXpdQtyAll    = round($FCXpdQty*$FCXpdFactor);    //จำนวนรวมหน่วยเล็กสุด (FCXpdQty*FCXpdFactor)

        //ต้นทุนสำหรับ การสั่งซื้อ ซื้อ เพิ่มหนี้ (ผู้จำหน่าย)
        //1 ต้นทุนเฉลี่ย ,2 ต้นทุนสุดท้าย ,3 ต้นทุนมาตรฐาน 
        $nCostPurPO = FCNnHDOCGetCostPurPO();

        //คำนวนต้นทุนเฉลีย
        //1 ต้นทุนเฉลี่ย
        if($nCostPurPO == 1){
            if($tXphVATInOrEx == 1){
                $cPdtCostPrice = $aDataPdtPrg['FCPdtCostIn'] != '' ? $aDataPdtPrg['FCPdtCostIn'] : 0;
            }else{
                $cPdtCostPrice = $aDataPdtPrg['FCPdtCostEx'] != '' ? $aDataPdtPrg['FCPdtCostEx'] : 0;
            }

        //2 ต้นทุนสุดท้าย
        }else if($nCostPurPO == 2){
            $cPdtCostPrice = $aDataPdtPrg['FCSplLastPrice'] != '' ? $aDataPdtPrg['FCSplLastPrice'] : 0;

        //3 ต้นทุนมาตรฐาน 
        }else if($nCostPurPO == 3){
            $cPdtCostPrice = $aDataPdtPrg['FCPdtCostStd'] != '' ? $aDataPdtPrg['FCPdtCostStd'] : 0;
        }
        //คำนวนต้นทุนเฉลีย

        $FCXpdSalePrice = $cPdtCostPrice*$FCXphRteFac;   //FCPgdPriceRET*HD.FCXphRteFac
        $FCXpdSetPrice  = $cPdtCostPrice*$FCXphRteFac;   //ราคาซื้อ ตาม หน่วย * อัตราแลกเปลี่ยน(HD.FCXphRteFac)
        $FCXpdAmt       = $FCXpdQty*$FCXpdSetPrice; //FCXpdQty*FCXpdSetPrice
        $FCXpdNet       = $FCXpdAmt; //มูลค่าสุทธิก่อนท้ายบิล (FCXpdAmt-FCXpdDis+FCXpdChg)



        $PdtStaAlwDis = $aDataPdtPrg['FTPdtStaAlwDis']; //อนุญาตลด
        if($PdtStaAlwDis == 1){
            $FCXpdDisChgAvi = $FCXpdQty*$FCXpdSetPrice;
        }else{
            $FCXpdDisChgAvi = 0;
        }


        // $FCXpdNet = $FCXpdAmt        //มูลค่าสุทธิก่อนท้ายบิล (FCXpdAmt-FCXpdDis+FCXpdChg
        // End Cal Progress

        $aDiscoute = array();
        $aNewData = array(

                'FTXphDocNo'        => $tXphDocNo,
                'FTBchCode'         => $tBchCode,
                'FNXpdSeqNo'        => $nSeq+1,
                'FTPdtCode'         => $aDataPdtPrg['FTPdtCode'],
                'FTXpdPdtName'      => $aDataPdtPrg['FTPdtName'],
                'FTXpdStkCode'      => '', //??????
                'FCXpdStkFac'       => $aDataPdtPrg['FCPdtStkFac'],
                'FTPunCode'         => $aDataPdtPrg['FTPunCode'],
                'FTPunName'         => $aDataPdtPrg['FTPunName'],
                'FCXpdFactor'       => number_format($FCXpdFactor, $nOptDecimalSave, '.', ''),
                'FTXpdBarCode'      => $aDataPdtPrg['FTBarCode'],      
                'FTSrnCode'         => $aDataPdtPrg['FTSrnCode'],      //รหัส ซีเรียล //ไม่ต้องรับค่าตอนสั่งซื้อ
                'FTXpdVatType'      => $aDataPdtPrg['FTPdtStaVat'],    //สถานะภาษี 1:มี 2:ไม่มี
                'FTVatCode'         => $aDataPdtPrg['FTVatCode'],      //FTVatCode
                'FCXpdVatRate'      => number_format($aDataPdtPrg['FCVatRate'], $nOptDecimalSave, '.', ''),      // อัตราภาษี ณ. ซื้อ
                'FTXpdSaleType'     => $aDataPdtPrg['FTPdtSaleType'],  //ใช้ราคาขาย 1:บังคับ, 2:แก้ไข, 3:เครื่องชั่ง,4: นน.
                'FCXpdSalePrice'    => number_format($FCXpdSalePrice, $nOptDecimalSave, '.', ''),                //จากราคาซื้อ ตาม หน่วย(FCPgdPriceRET) * อัตราแลกเปลี่ยน(HD.FCXphRteFac)
                'FCXpdQty'          => number_format($FCXpdQty, $nOptDecimalSave, '.', ''),  //จำนวนชื้น ตาม หน่วย
                'FCXpdQtyAll'       => number_format($FCXpdQtyAll, $nOptDecimalSave, '.', ''),  //จำนวนรวมหน่วยเล็กสุด (FCXpdQty*FCXpdFactor)
                'FCXpdSetPrice'     => number_format($FCXpdSetPrice, $nOptDecimalSave, '.', ''),  //ราคาซื้อ ตาม หน่วย * อัตราแลกเปลี่ยน(HD.FCXphRteFac)
                'FCXpdAmt'          => number_format($FCXpdAmt, $nOptDecimalSave, '.', ''),  //มูลค่ารวมก่อนลด (Qty*SetPrice) ทุกกรณี (ไม่เปลี่ยน)
                'FCXpdDisChgAvi'    => number_format($FCXpdDisChgAvi, $nOptDecimalSave, '.', ''), //มูลค่าลดได้  กรณีอนุญาตลด (Qty*SetPrice) ไม่อนุญาต เป็น 0 (ปรับเมื่อมีการลดชาร์จ DT/HD)
                'FTXpdDisChgTxt'    => '',  //ข้อความมูลค่าลดชาร์จ เช่น 5 หรือ 5%
                'FCXpdDis'          => '0', //มูลค่ารวมส่วนลดมูลค่ารวมส่วนลด
                'FCXpdChg'          => '0', //มูลค่ารวมส่วนชาร์จ
                'FCXpdNet'          => '0', //มูลค่าสุทธิก่อนท้ายบิล (FCXpdAmt-FCXpdDis+FCXpdChg)
                'FCXpdNetAfHD'      => '0', //มูลค่าสุทธิหลังท้ายบิล (Net-SUM(Disท้ายบิล))
                'FCXpdNetEx'        => '0', //มูลค่าสุทธิก่อนท้ายบิล แยกภาษี
                'FCXpdVat'          => '0', //มูลค่าภาษี IN: NetAfHD-((NetAfHD*100)/(100+VatRate)) ,EX: ((NetAfHD*(100+VatRate))/100)-NetAfHD
                'FCXpdVatable'      => '0', //มูลค่าแยกภาษี (NetAfHD-FCXpdVat)
                'FCXpdWhtAmt'       => '0', //FCXpdWhtAmt
                'FTXpdWhtCode'      => '0', //FTXpdWhtCode
                'FCXpdWhtRate'      => '0', //อัตราภาษี ณ. ที่จ่าย
                'FCXpdCostIn'       => '0', //ต้นทุนรวมใน (FCXpdVat+FCXpdVatable)
                'FCXpdCostEx'       => '0', //ต้นทุนแยกนอก (FCXpdVatable)
                'FTXpdStaPdt'       => $aDataPdtPrg['FTPdtType'],  //สถานะ สินค้า 1:ขาย, 2:คืน, 3:แถม, 4: ยกเลิก (Void)
                'FCXpdQtyLef'       => $FCXpdQty, //Default:FCXpdQty
                'FCXpdQtyRfn'       => '0', //จำนวนคืนตามหน่วย (Default:0)
                'FTXpdStaPrcStk'    => '',  //สถานะตัดสต๊อก ว่าง:ยังไม่ทำ, 1:ทำแล้ว
                'FTXpdStaAlwDis'    => $aDataPdtPrg['FTPdtStaAlwDis'], 
                'FNXpdPdtLevel'     => $aDataPdtPrg['FTPdtSetOrSN'], //ระดับสิน(ค้าชุด)
                'FTXpdPdtParent'    => '0', //รหัสสินค้าชุด
                'FCXpdQtySet'       => '0', //จำนวนต่อชุด
                'FTPdtStaSet'       => '0', //สถานะ สินค้าชุด 1:ทั่วไป, 2:สินค้าประกอบ, 3:สินค้าชุด
                'FTXpdRmk'          => '0', //หมายเหตุรายการ
                'FDLastUpdOn'       => date('Y-m-d'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d'), 
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'DTDiscount'        => $aDiscoute
        );
        
        if(FCNnHSizeOf($aArray['DTData']) > 0){
            //รูปแบบการเพิ่มข้อมูล = 1 เพิ่มจำนวน
            if($tOptDocAdd == 1){
                //รหัสสินค้าที่ เพิ่ม Qty จะเพิ่มแค่ตัวเดียว
                $tPdtCodeQtyAdd = '';
                foreach($aArray['DTData'] AS $key => $value){
                    //ถ้าเจอ PdtCode และ PunCode ที่มีอยู่แล้วจะทำการ บวกเพิ่ม Qty
                    if($tPdtCode == $value['FTPdtCode'] && $tPunCode == $value['FTPunCode'] && $tPdtCodeQtyAdd != $value['FTPdtCode']){
                        $tPdtCodeQtyAdd = $value['FTPdtCode'];
                        $nQtyAddOn = $value['FCXpdQty']+$FCXpdQty;
                        $aArray['DTData'][$key]['FCXpdQty'] = number_format($nQtyAddOn, $nOptDecimalSave, '.', '');
                        $nStaAddOn = 1;
                    }
                }

                if($nStaAddOn != 1){
                    $aArrayCurrent = array_push($aArray['DTData'],$aNewData);
                }
            }else{
            // 2 เพิ่มแถวใหม่
                $nStaAddOn = 1;
                $aArrayCurrent = array_push($aArray['DTData'],$aNewData);
            }
            
        }else{
            $aArrayCurrent = array_push($aArray['DTData'],$aNewData);
        }

        // Check Sta Add On ว่าถ้ามีการ บวกเพิ่มแล้วจะไม่ทำ Add แบบปกติ
        // if($nStaAddOn != 1){
        //     $aArrayCurrent = array_push($aArray['DTData'],$aNewData);
        // }

        
        $jDataArray = json_encode($aArray);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

    }

    //function : เพิ่มส่วนลด HDDis (ท้าบบิล ) (File)
    public function FSvCPOAddHDDisIntoTable(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXphDocNo      = $this->input->post('tHDXphDocNo');
        $tBchCode       = $this->input->post('tHDBchCode');
        $tDisChgText    = $this->input->post('tHDXphDisChgText');
        $cXphDisValue   = $this->input->post('cHDXphDis');

        //ปรับทศนิยม
        $cXphDisValue   = number_format($cXphDisValue, $nOptDecimalSave, '.', '');

        $cXphDis = 0;
        $cXphChg = 0;

        //Get Data From File
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        
        //ยอดมีภาษีลดได้
        $cXphVatDisChgAvi = 0;
        //ยอดไม่มีภาษีลดได้
        $cXphNoVatDisChgAvi = 0;

        if(FCNnHSizeOf($aDataFile['DTData']) > 0){
            foreach($aDataFile['DTData'] AS $key => $value){
                if($value['FTXpdVatType'] == 1){
                    //คำนวนยอดมีภาษีลดได้ FTXpdVatType=1 : SUM(DT.FCXpdDisChgAvi)
                    $cXphVatDisChgAvi   = $cXphVatDisChgAvi + $value['FCXpdDisChgAvi'];
                }else if($value['FTXpdVatType'] == 2){
                    $cXphNoVatDisChgAvi = $cXphNoVatDisChgAvi + $value['FCXpdDisChgAvi'];
                }
            }
        }

        switch ($tDisChgText) {
            case 1: //ชาร์จบาทชาร์จบาท
                $tXphDisChgTxt = "+".$cXphDisValue;
                $cXphDis       = '0';
                $cXphChg       = $cXphDisValue;
                break;
            case 2: //ชาร์จ %
                $tXphDisChgTxt = "+".$cXphDisValue."%";
                $cXphDis       = '0';
                $cXphChg       = $cXphDisValue*$cXphVatDisChgAvi/100;
                break;
            case 3: //ลดบาท
                $tXphDisChgTxt = $cXphDisValue;
                $cXphDis       = $cXphDisValue;
                $cXphChg       = '0';
                break;
            case 4: //ลด %
                $tXphDisChgTxt = $cXphDisValue."%";
                $cXphDis       = $cXphDisValue*$cXphVatDisChgAvi/100;
                $cXphChg       = '0';
                break;
            
            default:
                $tXphDisChgTxt = $cXphDisValue;
        }

        $cXphVatDisChgAvi   = number_format($cXphVatDisChgAvi, $nOptDecimalSave, '.', '');
        $cXphNoVatDisChgAvi = number_format($cXphNoVatDisChgAvi, $nOptDecimalSave, '.', '');
        $cXphDis            = number_format($cXphDis, $nOptDecimalSave, '.', '');
        $cXphChg            = number_format($cXphChg, $nOptDecimalSave, '.', '');

        $aNewData = array(
            'FTBchCode'             => $tBchCode,
            'FTXphDocNo'            => $tXphDocNo,
            'FDXphDateIns'          => date('Y-m-d H:i:s'),
            'FNXphStaDis'           => 2,
            'FCXphVatDisChgAvi'     => $cXphVatDisChgAvi,
            'FCXphNoVatDisChgAvi'   => $cXphNoVatDisChgAvi,
            'FTXphDisChgTxt'        => $tXphDisChgTxt,
            'FCXphDis'              => $cXphDis,
            'FCXphChg'              => $cXphChg,
            'FCXphDisVat'           => 0,
            'FCXphDisNoVat'         => 0,
            'FCXphChgVat'           => 0,
            'FCXphChgNoVat'         => 0,
            'FTXphUsrApv'           => $this->session->userdata('tSesUsername'),
        );

        array_push($aDataFile['HDData'],$aNewData);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        // คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //function : เพิ่มส่วนลด DTDis (รายการสินค้า) (File)
    public function FSvCPOAddDTDisIntoTable(){

        //Get Option Save Decimal  
        $nOptDecimalSave = FCNxHGetOptionDecimalSave(); 

        $tXphDocNo      = $this->input->post('ptXphDocNo');
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
            'FTXphDocNo'        => $tXphDocNo,
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
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        array_push($aDataFile['DTData'][$nKey]['DTDiscount'],$aNewData);
                
        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }



    //////////////////////////////////////////////////////////////////////////   Zone ลบ
    //Functionality : Event Delete Master
    public function FSaCPODeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTXphDocNo' => $tIDCode
        );

        $aResDel    = $this->mPurchaseorder->FSnMPODel($aDataMaster);
        $aReturn    = array(
            'nStaEvent' => $aResDel['rtCode'],
            'tStaMessg' => $aResDel['rtDesc']
        );
        echo json_encode($aReturn);
    }

    //Function : Remove Master Pdt Intable (File)
    public function FSvCPORemovePdtInFile(){
        
        $tIndex 	= $this->input->post('ptIndex');
        $tPdtCode 	= $this->input->post('ptPdtCode');

        //Get Data From File
        $tXphDocNo = $this->input->post('ptXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        unset($aDataFile['DTData'][$tIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //Function : Remove Master Pdt Intable (File)
    public function FSvCPORemoveAllPdtInFile(){
    
        //Get Data From File
        $tXphDocNo = $this->input->post('ptXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        unset($aDataFile['DTData']);

        $jDataArray = json_encode($aDataFile);
            //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo); 

    }

    //Function : Remove HDDis inFile (File)
    public function FSvCPORemoveHDDisInFile(){
    
        $nIndex = $this->input->post('nIndex');

        //Get Data From File
        $tXphDocNo = $this->input->post('ptXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        unset($aDataFile['HDData'][$nIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

    }

    //Function : Remove DTDis inFile (File)
    public function FSvCPORemoveDTDisInFile(){
        
        $nKey 	= $this->input->post('nKey');
        $nIndex = $this->input->post('nIndex');

        //Get Data From File
        $tXphDocNo = $this->input->post('ptXphDocNo');
        $aDataFile = $this->FMaPOGetDataFormFile($tXphDocNo);

        unset($aDataFile['DTData'][$nKey]['DTDiscount'][$nIndex]);

        $jDataArray = json_encode($aDataFile);
         //PATHSupawat
        $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
        file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
        fclose($fp);

        //คำนวนใน File ใหม่
        $this->FCNoPOProcessCalculaterInFile($tXphDocNo);

    }



    //////////////////////////////////////////////////////////////////////////   Zone Call Page
    //Function : เรียกหน้า  Add 
    public function FSxCPOAddPage(){

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
            $tCmpRteCode    = $aResList['raItems']['rtCmpRteCode'];
            $tVatCode       = $aResList['raItems']['rtVatCodeUse'];

            $aVatRate = FCNoHCallVatlist($tVatCode); 
            $cVatRate  = $aVatRate['FCVatRate'][0];
            
            $aDataRate  = array(
                'FTRteCode' => $tCmpRteCode,
                'FNLngID'   => $nLangEdit
            );
    
            $aResultRte     = $this->mRate->FSaMRTESearchByID($aDataRate);
            $cXphRteFac     = $aResultRte['raItems']['rcRteRate'];
            
        }else{
            $tBchCode       = "";
            $tCmpRteCode    = "";
            $tVatCode       = "";
            $cVatRate       = "";
            $cXphRteFac     = "";
        }

        $tUsrLogin = $this->session->userdata('tSesUsername');

        $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin); //Get Department Code

        $aDataShp  = array(
            'FNLngID'   => $nLangEdit,
            'tUsrLogin'=> $tUsrLogin
        );
        $aDataShp = $this->mPurchaseorder->FStPOGetShpCodeForUsrLogin($aDataShp); //Get ShopCode
        if(@$aDataShp->FTShpCode == ''){
            //ถ้าว่าง ให้ Get Option Def
            $tShpCode   = '';
            $tShpName   = '';
            $aDataWah   = $this->mPurchaseorder->FSaMPOGetDefOptionPO($aDataWhere);  // Option Def ของ PO
            $tWahCode   = $aDataWah->FTSysStaUsrValue;
            $tWahName   = $aDataWah->FTWahName;
        }else{
            $tWahCode   = $aDataShp->FTWahCode;
            $tWahName   = $aDataShp->FTWahName;
            $tShpCode   = $aDataShp->FTShpCode;
            $tShpName   = $aDataShp->FTShpName;
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
            'cXphRteFac'    =>  $cXphRteFac,
            'tDptCode'      =>  $tDptCode,
            'tShpCode'      =>  $tShpCode,
            'tShpName'      =>  $tShpName,
            'tWahCode'      =>  $tWahCode,
            'tWahName'      =>  $tWahName,
        );

        $this->load->view('document/purchaseorder/wPurchaseorderAdd',$aDataAdd);

    }

    //Function : เรียกหน้า  Edit  
    public function FSvCPOEditPage(){

        //Remove File Cache Data PO
        $tXphDocNo = $this->input->post('ptXphDocNo');
        FCNxClearDataInFile($tXphDocNo);

        $aAlwEventPO = FCNaHCheckAlwFunc('po/0/0'); //Controle Event
        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        //Get Option Scan SKU
        $nOptDocSave    = FCNnHGetOptionDocSave(); 

        //Get Option Scan SKU
        $nOptScanSku    = FCNnHGetOptionScanSku(); 

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
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
        $aData  = array(
            'FTXphDocNo'    => $tXphDocNo,
            'FNLngID'       => $nLangEdit,
            'nRow'          => 1000,
            'nPage'         => 1,
        );

        //Get Data
        $aResult            = $this->mPurchaseorder->FSaMPOGetOrdHD($aData);       // Data TAPTOrdHD
        $aDataOrdHDDis      = $this->mPurchaseorder->FSaMPOGetOrdHDDis($aData);    // Data TAPTOrdHDDis
        $aDataTablesOrdDT   = $this->mPurchaseorder->FSaMPOGetOrdDT($aData);       // Data TAPTOrdDT
        $aDataOrdDTDis      = $this->mPurchaseorder->FSaMPOGetOrdDTDis($aData);    // Data TAPTOrdDTDis

        //Get Default Option Wah
        if($aResult['rtCode'] == 1){

            $tShpCode  = $aResult['raItems']['FTShpCode'];
            $tWahCode  = $aResult['raItems']['FTWahCode'];

            if($tShpCode == '' && $tWahCode == ''){
                //ถ้าว่าง ให้ Get Option Def
                $aDataWah  = $this->mPurchaseorder->FSaMPOGetDefOptionPO($aData);  // Option Def ของ PO
                $tWahCode  = $aDataWah->FTSysStaUsrValue;
                $tWahName  = $aDataWah->FTWahName;
            }else{
                $tWahCode  = $aResult['raItems']['FTWahCode'];
                $tWahName  = $aResult['raItems']['FTWahName'];
            }

        }else{
            //ถ้าว่าง ให้ Get Option Def
            $aDataWah  = $this->mPurchaseorder->FSaMPOGetDefOptionPO($aData);  // Option Def ของ PO
            $tWahCode = $aDataWah->FTSysStaUsrValue;
            $tWahName = $aDataWah->FTWahName;
        }


        $aArray = array();
        $i =0;

        if($aDataOrdHDDis['rtCode'] != 800){
            $aArray['HDData'] = $aDataOrdHDDis['raItems'];
        }else{
            $aArray['HDData'] = array();
        }
        
        if($aDataTablesOrdDT['rtCode'] == 1){
            foreach($aDataTablesOrdDT['raItems'] as $key=>$val){
                
                $aArray['DTData'][$key] = $val;
                if(isset($aDataOrdDTDis['raItems']) == 1 ){
                        $aArray['DTData'][$i]['DTDiscount'] = array();
                        foreach($aDataOrdDTDis['raItems'] as $keyDis=>$valDis){
                            if($val['FNXpdSeqNo'] == $valDis['FNXpdSeqNo']){
                                $aArray['DTData'][$i]['DTDiscount'][$keyDis] = $valDis;
                            }
                        }
                }else{
                        $aArray['DTData'][$i]['DTDiscount'] = array();
                }
                ++$i;
            }
            
        }

        //LoadData ยัดไฟล์
        if(isset($aDataTablesOrdDT['raItems']) == 1){
            $jDataArray = json_encode($aArray);
            //PATHSupawat
            $fp = fopen(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", "r+");
            file_put_contents(APPPATH."modules\document\document\\".$tXphDocNo."-".$this->session->userdata('tSesUsername').".txt", $jDataArray);
            fclose($fp);
        }

        $aDataEdit = array(
            'nOptDecimalShow'   =>  $nOptDecimalShow,
            'nOptDocSave'       =>  $nOptDocSave,
            'nOptScanSku'       =>  $nOptScanSku,
            'aResult'           =>  $aResult,
            'aAlwEventPO'       =>  $aAlwEventPO,
            'tWahCode'          =>  $tWahCode,
            'tWahName'          =>  $tWahName,
        );

        $this->load->view('document/purchaseorder/wPurchaseorderAdd',$aDataEdit);

    }
    


    //////////////////////////////////////////////////////////////////////////   Zone Advacne Table
    //Functionality : Function Call DataTables List Master
    public function FSxCPODataTable(){

        //Controle Event
        $aAlwEvent      = FCNaHCheckAlwFunc('po/0/0'); 

        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
        
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');

        $tBchCode           = $this->input->post('tBchCode');
        $tShpCode           = $this->input->post('tShpCode');
        $tXphStaDoc         = $this->input->post('tXphStaDoc');
        $dXphDocDateFrom    = $this->input->post('dXphDocDateFrom');
        $dXphDocDateTo      = $this->input->post('dXphDocDateTo');

        if($dXphDocDateTo == ''){
            $dXphDocDateTo = $dXphDocDateFrom;
        }

        if($dXphDocDateFrom == ''){
            $dXphDocDateFrom = $dXphDocDateTo;
        }

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

            //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
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
            'FNLngID'           => $nLangEdit,
            'nPage'             => $nPage,
            'nRow'              => 10,
            'tSearchAll'        => $tSearchAll,
            'tBchCode'          =>$tBchCode,
            'tShpCode'          =>$tShpCode,
            'tXphStaDoc'        =>$tXphStaDoc,
            'dXphDocDateFrom'   =>$dXphDocDateFrom,
            'dXphDocDateTo'     =>$dXphDocDateTo,
        );


        $aResList   = $this->mPurchaseorder->FSaMPOList($aData);
        $aGenTable  = array(
            'aAlwEvent'     => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll,
            'nOptDecimalShow'=> $nOptDecimalShow
        );


        $this->load->view('document/purchaseorder/wPurchaseorderDataTable',$aGenTable);
    }

    //Function : Adv Table Load Data
    public function FSvCPOPdtAdvTblLoadData(){

        $tXphDocNo  = $this->input->post('tXphDocNo');
        $tXphStaApv = $this->input->post('tXphStaApv');
        $tXphStaDoc = $this->input->post('tXphStaDoc');
        
        //Edit in line
        $tPdtCode 	 = $this->input->post('ptPdtCode');
        $tPunCode 	 = $this->input->post('ptPunCode');

        //Get Option Show Decimal
        $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $aLangHave      = FCNaHGetAllLangByTable('TSysPmt_L');
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

        $aColumnShow    = FCNaDCLGetColumnShow('TAPTOrdDT');

        $aDataFile      = $this->FMaPOGetDataFormFile($tXphDocNo);

        $aData['nOptDecimalShow']   = $nOptDecimalShow;
        $aData['aColumnShow']       = $aColumnShow;
        $aData['aDataFile']         = $aDataFile;
        $aData['tPdtCode']          = $tPdtCode;
        $aData['tPunCode']          = $tPunCode;
        $aData['tXphStaApv']        = $tXphStaApv;
        $aData['tXphStaDoc']        = $tXphStaDoc;

        $this->load->view('document/purchaseorder/advancetable/wPurchaseorderPdtAdvTableData',$aData);
        
    }

    //Function : Adv Table Save
    public function FSvCPOShowColSave(){

        FCNaDCLSetShowCol('TAPTOrdDT','','');
        
        $aColShowSet = $this->input->post('aColShowSet');
        $aColShowAllList = $this->input->post('aColShowAllList');
        $aColumnLabelName = $this->input->post('aColumnLabelName');
        $nStaSetDef = $this->input->post('nStaSetDef');

        if($nStaSetDef == 1){
            FCNaDCLSetDefShowCol('TAPTOrdDT');
        }else{
                for($i = 0; $i<FCNnHSizeOf($aColShowSet);$i++){
                
                    FCNaDCLSetShowCol('TAPTOrdDT',1,$aColShowSet[$i]);
                }
        }

        //Reset Seq
        FCNaDCLUpdateSeq('TAPTOrdDT','','','');
        $q = 1;
        for($n = 0; $n<FCNnHSizeOf($aColShowAllList);$n++){
                
            FCNaDCLUpdateSeq('TAPTOrdDT',$aColShowAllList[$n],$q , $aColumnLabelName[$n]);
            $q++;
        }
        
    }

    //Function : Adv Table Show
    public function FSvCPOAdvTblShowColList(){

        $aAvailableColumn = FCNaDCLAvailableColumn('TAPTOrdDT');
        $aData['aAvailableColumn'] = $aAvailableColumn;
        $this->load->view('document/purchaseorder/advancetable/wPurchaseTableShowColList',$aData);
        
    }



    //////////////////////////////////////////////////////////////////////////   Zone ค้นหา
    //Function : ค้นหา รายการ
    public function FSxCPOFormSearchList(){

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

        $this->load->view('document/purchaseorder/wPurchaseorderFormSearchList',$aDataMaster);
    }












    












}

