<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr class="xCNCenter">
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBNo')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBBefore')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBCalDis')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBCalChg')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBAfter')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBType')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBValue')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBDelete')?></th>
                <th><?= language('document/purchaseorder/purchaseorder','tPOTBEdit')?></th>
            </tr>
        </thead>
        <tbody id="odvTBodyPOHDDis">
            <?php 
            // ประกาศตัวแปร

            // From Coltroller 
            $cXphTotalB4Dis = $cXphTotal;
            $nXphVATInOrEx = $nXphVATInOrEx; //รวมใน / แยกนอก
            $cXphRefAEAmt   = $cXphRefAEAmt; //มัดจำ
            $nXphVATRate   = $nXphVATRate;  //Vat
            $nXphWpTax   = $nXphWpTax;      //XphWpTax
            // From Coltroller 

            $tXphDisChgTxt = '';
            $cXphDis        = 0;
            $cXpdChg        = 0;
            $cDisTotal      = 0;
            $cXphAfDisChgAE = 0;
            $cXphVat        = 0;
            $cXphVatable    = 0;
            $cXphGrandB4Wht = 0;
            $cXphGrand      = 0;

            $i = 0;
            ?>

            <!-- คำนวน HDDis -->
            <?php 
            // ตัวแปรที่เก็บค่าคำนวน
            $nHDXphTotal = 0;
            $nHDDis = 0;
            $nHDNet = 0;
            $nHDVat = 0;
            if(is_array(@$aDataFile['DTData'])){
                foreach($aDataFile['DTData'] as $key=>$val){
                    //จำนวนเงินรวมทั้งสิ้น
                    $nHDXphTotal  = $nHDXphTotal+$val['FCXpdNet'];
                    //ส่วนลด
                    $nHDDis       = $nHDDis+$val['FCXpdDis'];
                    //จำนวนเงินหลังลด
                    $nHDNet       = $nHDNet+$val['FCXpdNet'];
                    //ภาษีมูลค่าเพิ่ม
                    $nHDVat       = $nHDNet+$val['FCXpdVat'];
                }
            }
            //ยอดรวมภาษี
            $nHDSumVat = $nHDNet+$nHDVat;
            ?>

            <?php if(FCNnHSizeOf($aDataFile['HDData']) > 0 ) : ?>
                <?php foreach($aDataFile['HDData'] AS $key=>$aValue){ ?>
                    <tr class="text-center xCNTextDetail2" id="otrHDDis<?=$key?>" data-index="<?=$key?>" data-docno="<?=$aValue['FTXphDocNo']?>">
                        <td ><?=$i+1?></td>                      <!--  ลำดับ -->   				
                        <td class="text-right"><?= $cXphTotalB4Dis != '' ? number_format($cXphTotalB4Dis, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ',') ?></td> <!--  ก่อน -->
                        <?php  
                        // คำนวน
                        if($aValue['FTXphDisChgTxt'] != ''){
                            $nLen = strlen($aValue['FTXphDisChgTxt']);

                            $tStrlast = substr($aValue['FTXphDisChgTxt'],$nLen-1);
                            $tStr1 = $aValue['FTXphDisChgTxt'][0];

                            if($tStrlast != '%'){

                                if($tStr1 != '+'){
                                    //ลด
                                    $nCalucateDis = $aValue['FTXphDisChgTxt'];
                                    $nCalucateChg = 0;
                                    $cAFCalPrice  = $cXphTotalB4Dis - $aValue['FTXphDisChgTxt'];
                                    $tDisChgTxt   = '3';
                                    $tDisChgValue = $aValue['FTXphDisChgTxt'];

                                    $cDisTotal = $cDisTotal+$aValue['FTXphDisChgTxt'];
                                    $cXphDis = $cXphDis+$aValue['FTXphDisChgTxt'];
                                }else{
                                    //ชาร์จ
                                    $nDistext = explode("+",$aValue['FTXphDisChgTxt']);
                                    $nCalucateDis = 0;
                                    $nCalucateChg = $nDistext[1];
                                    $cAFCalPrice  = $cXphTotalB4Dis + $nDistext[1];
                                    $tDisChgTxt   = '1';
                                    $tDisChgValue = $nDistext[1];

                                    $cDisTotal = $cDisTotal-$nDistext[1];
                                    $cXpdChg = $cXpdChg+$nDistext[1];
                                }
                                $cXphTotalB4Dis = $cAFCalPrice; 

                            }else{

                                $nDistext = explode("%",$aValue['FTXphDisChgTxt']);
                                $nCalucatePercent = ($nDistext[0]*$cXphTotalB4Dis)/100;

                                if($tStr1 != '+'){
                                    //ลด
                                    $nCalucateDis = $nCalucatePercent;
                                    $nCalucateChg = 0;
                                    $cAFCalPrice  = $cXphTotalB4Dis - $nCalucatePercent;
                                    $tDisChgTxt   = '4';
                                    $tDisChgValue = $nDistext[0];

                                    $cDisTotal = $cDisTotal+$nCalucatePercent;
                                    $cXphDis = $cXphDis+$nCalucatePercent;
                                }else{
                                    //ชาร์จ
                                    $nCalucateDis = 0;
                                    $nCalucateChg = $nCalucatePercent;
                                    $cAFCalPrice = $cXphTotalB4Dis + $nCalucatePercent;
                                    $tDisChgTxt   = '2';
                                    $tDisChgValue = substr($nDistext[0],1) ;

                                    $cDisTotal = $cDisTotal-$nCalucatePercent;
                                    $cXpdChg = $cXpdChg+$nCalucatePercent;
                                }
                                $cXphTotalB4Dis = $cAFCalPrice; 
                            }
                            $tXphDisChgTxt .= $aValue['FTXphDisChgTxt'].",";
                        }
                        ?>
                        <td class="text-right"><?= $nCalucateDis != '0' ? "-".number_format($nCalucateDis, $nOptDecimalShow, '.', ',') : '-' ?></td>          <!--  คำนวน ลด-->
                        <td class="text-right"><?= $nCalucateChg != '0' ? "+".number_format($nCalucateChg, $nOptDecimalShow, '.', ',') : '-' ?></td>          <!--  คำนวน ชาร์จ-->
                        <td class="text-right"><?= $cXphTotalB4Dis != '' ? number_format($cXphTotalB4Dis, $nOptDecimalShow, '.', ',') : '-' ?></td>                     <!--  หลัง -->
                        <td class="text-left xWAlwEditXpdHDDisChgType" data-distype="<?=$tDisChgTxt?>"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt'.$tDisChgTxt)?></td>             <!--  ประเภท -->
                        <td class="text-right xWAlwEditXpdHDDisChgValue" data-distype="<?=$tDisChgTxt?>" data-disvalue="<?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', '') : '0' ?>"><?= $tDisChgValue != '0' ? number_format($tDisChgValue, $nOptDecimalShow, '.', ',') : '0' ?></td>    <!--  มูลค่า -->
                        <td class="text-center">
                            <lable class="xCNTextLink">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSnRemoveHDDisRow(this)">
                            </lable>
                        </td>
                        <td class="text-center">
                            <lable class="xCNTextLink">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSnEditHDDisRow(this)">
                            </lable>
                        </td>
                    </tr>

                    <?php $i++; ?>
                <?php  } ?>

                <?php else: ?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif; ?>

                <?php 

                    // ยอดรวมส่วนลดชาร์จ
                    $cDisTotal = $cXphDis-$cXpdChg;

                    // ยอดรวมหลัง ลด-ชาร์จ+มัดจำ
                    //(FCXphVatNoDisChg+FCXphNoVatNoDisChg)+(FCXphVatAfDisChg+FCXphNoVatAfDisChg)
                    $cXphAfDisChgAE = $cXphTotal-$cDisTotal-$cXphRefAEAmt;

                    if($nXphVATInOrEx == 1){
                        // หาสูตรรวมใน
                        $cXphVat = $cXphAfDisChgAE-(($cXphAfDisChgAE*100)/(100+$nXphVATRate));
                    }else{
                        $cXphVat = (($cXphAfDisChgAE*(100+$nXphVATRate))/100)-$cXphAfDisChgAE;
                    }

                    // ยอดแยกภาษี
                    $cXphVatable = $cXphAfDisChgAE-$cXphVat;

                    // ยอดรวมสุทธิ ก่อน ภาษี ณ ที่จ่าย  IN:FCXphVat+FCXphVatable , EX : FCXphAfDisChgAE+FCXphVat
                    if($nXphVATInOrEx == 1){
                        // หาสูตรรวมใน
                        $cXphGrandB4Wht = $cXphVat+$cXphVatable;
                    }else{
                        $cXphGrandB4Wht = $cXphAfDisChgAE+$cXphVat;
                    }

                    $cXphGrand = $cXphGrandB4Wht-$nXphWpTax;
                ?>
        </tbody>
    </table>
    
    <input type="text" class="xCNHide" id="ohdFCXphTotal" value="<?= $cXphTotal != '' ? number_format($cXphTotal, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', '') ?>">
    <input type="text" class="xCNHide" id="ohdFTXphDisChgTxt" value="<?= substr($tXphDisChgTxt, 0, -1); ?>">
    <input type="text" class="xCNHide" id="ohdFCXphDis" value="<?= $cDisTotal != '' ? number_format($cDisTotal, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', '') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphAfDisChgAE" value="<?= $cXphAfDisChgAE != '' ? number_format($cXphAfDisChgAE, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphRefAEAmt" value="<?= $cXphRefAEAmt != '' ? number_format($cXphRefAEAmt, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphVat" value="<?= $cXphVat != '' ? number_format($cXphVat, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphVatable" value="<?= $cXphVatable != '' ? number_format($cXphVatable, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphGrandB4Wht" value="<?= $cXphGrandB4Wht != '' ? number_format($cXphGrandB4Wht, $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
    <input type="text" class="xCNHide" id="ohdFCXphGrandText" value="<?= $cXphGrand != '' ? FCNtoBaht(number_format($cXphGrand, $nOptDecimalShow, '.', ',')) : '' ?>">  
</div>

<!-- Div Dropdown ใช้สำหรับ EditInLine เลือก ประเภท่วนลด -->
<div class="form-group xCNDivHDDisTypePanal" style="display:none">
    <select class="xWWidth100selectpicker form-control" id="" name="" style="width:100px;">
        <option value="1"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt1')?></option>
        <option value="2"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt2')?></option>
        <option value="3"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt3')?></option>
        <option value="4"><?= language('document/purchaseorder/purchaseorder','tDisChgTxt4')?></option>
    </select> 
</div>


