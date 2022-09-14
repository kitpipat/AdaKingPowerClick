<div class="panel-heading">
    <!--ข้อมูลส่วนบน-->
	<div class="row">
        <!--หัวข้อ ข้อมูลผู้ติดต่อ-->
		<div class="col-xs-12 col-md-12 col-lg-12">
			<div class="form-group">
				<label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleInformation')?></label>
			</div>
            <div><hr></div>
		</div>

        <!--ข้อมูลผู้ติดต่อ-->
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <?php $aCustomer = json_decode($aItemCustomer); ?>
            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYNameCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aCustomer->rtRegBusName?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYEmailCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aCustomer->rtCstMail?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTelCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aCustomer->rtCstTel?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYCountbch') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=$aCustomer->rnRegQtyBch?> <?=language('register/buylicense/buylicense', 'tBUYbch') ?></label></div>
            </div>
		</div>

        <!--ธุรกิจที่สนใจ-->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTypeRegister') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=($aCustomer->rtRegLicType == 2) ? language('register/buylicense/buylicense', 'tBUYTypeReal') : language('register/buylicense/buylicense', 'tBUYTypeDemo') ?></label></div>
                <input type="hidden" id="ohdCstLicType" name="ohdCstLicType" value="<?=$aCustomer->rtRegLicType?>">
                <input type="hidden" id="ohdCustomerID" name="ohdCustomerID" value="<?=$aCustomer->rtCstKey?>" >
            </div>

            <?php if($aCustomer->rtRegBusOth == '' || $aCustomer->rtRegBusOth == null){ ?> 
                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTypeBusiness') ?></label></div>
                    <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm">
                    <?=$aCustomer->rtRegBusOth;?>
                    </label></div>
                </div>  
            <?php } ?>
        </div>

        <!--เก็บข้อมูลลูกค้า-->
        <input type="hidden" id="ohdCustomerInfoPayment" name="ohdCustomerInfoPayment" value='<?=$aItemCustomer?>'>

        <div class="col-xs-12 col-md-12 col-lg-12">
            <div><hr></div>
        </div>
	</div>

    <!--ข้อมูลส่วนล่าง-->
    <div class="row">
    
        <?php if($aPackageList['rtCode'] != 1 && $aFeatuesList['rtCode'] != 1 && $aPosList['rtCode'] != 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                 <label class="xCNLabelFrm" style="text-align: center; display: block; margin-top: 10px; margin-bottom: 10px;">ไม่พบข้อมูลซื้อเพิ่ม</label>
            </div>
        <?php } ?>
                
        <!--ตารางแพ็คเกจ-->
        <?php if($aPackageList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <label class="xCNLabelFrm"> <?= language('register/buylicense/buylicense','tTitlePackage')?> </label>
                <div class="table-responsive">
                    <table id="otbRecheckPackage" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"><?= language('register/buylicense/buylicense','tTitlePackage')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($aPackageList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aPackageList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aPackageList['raItems'][$i]['FTBuyLicenseTextPackage']?></td>
                                            <td class="text-center"><?=$aPackageList['raItems'][$i]['FTBuyLicenseTextPackageMonth']?></td>
                                            <td class="text-right"><?=number_format($aPackageList['raItems'][$i]['FTBuyLicenseTextPackagePrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <!--ตารางฟิเจอร์-->
        <?php if($aFeatuesList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <label class="xCNLabelFrm"> <?= language('register/buylicense/buylicense','tTBFeatues')?> </label>
                <div class="table-responsive">
                    <table id="otbRecheckFeatues" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"                  ><?= language('register/buylicense/buylicense','tTBFeatues')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($aFeatuesList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aFeatuesList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatues']?></td>
                                            <td class="text-center"><?=$aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatuesQty']?></td>
                                            <td class="text-right"><?=number_format($aFeatuesList['raItems'][$i]['FTBuyLicenseTextFeatuesPrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <!--จุดขาย-->
        <?php if($aPosList['rtCode'] == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
                <label class="xCNLabelFrm"><?= language('register/buylicense/buylicense','tTBPos')?></label>
                <div class="table-responsive">
                    <table id="otbRecheckPos" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tModalAdvNo')?></th>
                                <th class="text-center xCNTextBold"                  ><?= language('register/buylicense/buylicense','tTBPos')?></th>
                                <th class="text-center xCNTextBold" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTime')?></th>
                                <th class="text-center xCNTextBold text-right" style="width:15%;"><?= language('register/buylicense/buylicense','tTBTotal')?></th>
                            </tr>
                        </thead>
                        <tbody> 
                            <?php if($aPosList['rtCode'] == 1){ ?>
                                <?php 
                                    $nNumber = 1;
                                    for($i=0; $i<FCNnHSizeOf($aPosList['raItems']); $i++){ ?>
                                        <tr>
                                            <td class="text-center"><?=$nNumber++?></td>
                                            <td class="text-left"><?=$aPosList['raItems'][$i]['FTBuyLicenseTextPos']?></td>
                                            <td class="text-center"><?=$aPosList['raItems'][$i]['FTBuyLicenseTextPosQty']?></td>
                                            <td class="text-right"><?=number_format($aPosList['raItems'][$i]['FTBuyLicenseTextPosPrice'],2)?></td>
                                        </tr>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <!--สรุปบิลรวมเงิน-->
        <div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:10px;">
            <div class="row">
                <div class="col-xs-4 col-md-8 col-lg-8"></div>
                <!--รวมเงิน-->
                <div class="col-xs-8 col-md-4 col-lg-4">
                    <div class="table-responsive">
                        <table id="otbTotalPrice" class="table">
                            <tbody>
                                <!--รวมเงิน-->
                                <tr>
                                    <?php $nPrice = $aSumFooter['raItems'][0]['SumPrice']; ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyTotal')?></td>
                                    <td class='text-right'><?=number_format($nPrice,2)?></td>
                                </tr>

                                <!--ส่วนลดจากการเปลี่ยนแพ็คเกจ-->
                                <?php
                                    if($tTypepage == 0){//ซื้อเพิ่ม
                                        if($aPackageList['rtCode'] == 1 && $this->session->userdata("tSessionCstPackageCode") != ''){ //มีการเปลี่ยน package ?>
                                           <tr>
                                                <td class='text-left'><?= language('register/buylicense/buylicense','tTBDiscountChangePackage')?></td>
                                                <td class='text-right xCNTextDiscount'>0.00</td>
                                            </tr>     
                                        <?php }
                                    }
                                ?>

                                <!--ภาษีมูลค่าเพิ่ม-->
                                <tr>
                                    <?php 
                                        $nVatCalculate  = $this->session->userdata("nVatCalculate");
                                        $nVatRate       = $this->session->userdata("nVatRate");
                                        if($nVatCalculate == 1){ //ภาษีรวมใน
                                            $nVat = $nPrice -($nPrice*100)/(100+$nVatRate);
                                        }else{
                                            $nVat = $nPrice*(100+$nVatRate)/100-$nPrice;
                                        }
                                    ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyVat')?> <?=$nVatRate?> %</td>
                                    <td class='text-right xCNVat'><?=number_format($nVat,2)?></td>
                                </tr>

                                <!--รวมทั้งสิ้น-->            
                                <tr>
                                    <?php 
                                        if($nVatCalculate == 1){ //ภาษีรวมใน
                                            $nPriceGrand = $nPrice;
                                        }else{
                                            $nPriceGrand = $nPrice + $nVat;
                                        }
                                    ?>
                                    <td class='text-left'><?= language('register/buylicense/buylicense','tTBMoneyGrand')?></td>
                                    <td class='text-right' id="otdGrandLicense"><b class="xCNTextAFDiscount"><?=number_format($nPriceGrand,2)?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>  
</div>

<script>
    if('<?=$tTypepage?>' == 0){ //ซื้อเพิ่ม
        if('<?=$aPackageList['rtCode']?>' == 1 && '<?=$this->session->userdata("tSessionCstPackageCode")?>' != ''){  //มีการเปลี่ยน package 
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "BuyLicenseCheckCreditRefund",
                cache   : false,
                data    : {
                    'tTypepage'     : '<?=$tTypepage?>'
                },
                timeout : 0,
                success : function(tResult){
                    JCNxCloseLoading();
                    var oResult = JSON.parse(tResult);
                    console.log(oResult);
                    $('.xCNTextDiscount').text(oResult.nDiscount);
                    $('.xCNVat').text(oResult.nVat);
                    $('.xCNTextAFDiscount').text(oResult.nAFDiscount);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

</script>