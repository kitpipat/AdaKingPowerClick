<style>
    .xCNLabelSeeMore{
        color           : #19a4ea !important;
        text-decoration : underline;
        cursor          : pointer;
    }

    .xCNImageTranferBy{
        width       : 550px;
        max-width   : 100%;
        display     : block;
        margin      : 0px auto;
        margin-bottom: 30px;
        margin-top  : 30px;
    }

    .xCNCSSCountdown{
        text-align  : center;
        display     : block;
        color       : red;
        font-size   : 42px !important;
        font-weight : bold;
    }

    .xCNInformationPayment{
        display: inline;
        text-align: center;
        color: black;
        font-weight: bold;
        letter-spacing: 1px;
        padding: 20px;
        width: 100%;
        font-size: 23px !important;
    }

    .xCNBlockInformationPayment{
        border-top: 1px solid #eeeeee;
        text-align: center;
        margin-top: 20px;
        padding: 20px 0px;
    }

    .xCNBlockRcvImage{
        display: block;
        border: 2px solid #003d6a;
        padding: 9px 50px;
        margin: 39px 15px;
        color: #003d6a;
        font-weight: bold;
        font-size: 32px !important;
    }

    .xCNDisplayPayment{    
        display: block;
        margin: 0px auto;
        text-align: center;
    }

    @media (min-width:320px)  { .xCNImagePromptpay{ width: 100% !important; } }
    @media (min-width:481px)  { .xCNImagePromptpay{ width: 100% !important;} }
    @media (min-width:641px)  { .xCNImagePromptpay{ width: 80% !important;} }
    @media (min-width:961px)  { .xCNImagePromptpay{ width: 200px !important;} }
    @media (min-width:1025px) { .xCNImagePromptpay{ width: 200px !important;} }
    @media (min-width:1281px) { .xCNImagePromptpay{ width: 200px !important;} }
</style>

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
                <div class="col-xs-6 col-md-6 col-lg-6 text-left"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYNameCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=$aCustomer->rtRegBusName?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6 text-left"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYEmailCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=$aCustomer->rtCstMail?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6 text-left"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYTelCustomer') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=$aCustomer->rtCstTel?></label></div>
            </div>

            <div class="row">
                <div class="col-xs-6 col-md-6 col-lg-6 text-left"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYCountbch') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=$aCustomer->rnRegQtyBch?> <?=language('register/buylicense/buylicense', 'tBUYbch') ?></label></div>
            </div>
        </div>
        
        <!--เลขที่เอกสาร-->
        <input type="hidden" id="ohdDocumentDummyForPayment" name="ohdDocumentDummyForPayment" value="<?=$tDocument?>" >
        <input type="hidden" id="ohdCustomerID" name="ohdCustomerID" value="<?=$aCustomer->rtCstKey?>" >
        
        <!--สรุปยอดชำระ-->
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"></div>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="row" style="margin-top: 5px;">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleTotalGrand')?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm">
                    <label class="xCNLabelFrm xCNLabelSeeMore" onclick="JSxViewSeeMoreDetail();"><?=language('register/buylicense/buylicense','tTitleSeemore')?></label>
                </div>
            </div>
            
            <div class="row" style="margin-top: 5px;">
                <?php $nPrice = $aSumFooter['raItems'][0]['SumPrice']; ?>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tTBMoneyTotal') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm xCNPriceTotal"><?=number_format($nPrice,2)?></label></div>
            </div>

            <!--ค้นหาคูปอง รอ API -->
            <!-- <div class="row" style="margin-top: 5px;">
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tTitleCoupon') ?></label></div>
                <div class="col-xs-7 col-md-7 col-lg-7" style="margin-top:5px;">
                    <div class="">
                        <div class="input-group">
                            <input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchCoupons" name="oetSearchCoupons" placeholder="<?=language('common/main/main','tPlaceholder')?>">
                            <span class="input-group-btn">
                                <button class="btn xCNBtnSearch xCNBTNFindCoupons"  type="button">
                                    <img class="xCNIconAddOn" style="margin-top : 2px !important; margin-bottom : 2px !important;" src="<?=base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                </button>

                                <button class="btn xCNBtnSearch xCNBTNCancelCoupons" type="button">
                                    <img class="xCNIconAddOn" style="margin-top : 2px !important; margin-bottom : 2px !important;" src="<?=base_url().'/application/modules/common/assets/images/icons/icons8-Delete-100_2.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 col-md-5 col-lg-5 text-right" style="margin-top:15px;"><label class="xCNLabelFrm xCNValueCoupons"><?=number_format(0,2)?></label></div>
            </div> -->

            <?php 
                $nDiscount = 0;
                if($tTypepage == 0){//ซื้อเพิ่ม
                    if($aHDDis['rtCode'] == 1){ //มีส่วนลดท้ายบิล ?>
                        <div class="row" style="margin-top: 5px;">
                            <?php 
                                $nDiscount  = $aHDDis['raItems'][0]['FTXhdDisChgTxt'];
                            ?>
                            <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?= language('register/buylicense/buylicense','tTBDiscountChangePackage')?></label></div>
                            <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=number_format($nDiscount,2)?></label></div>
                        </div> 
                    <?php }
                } 
            ?>

            <div class="row" style="margin-top: 5px;">
                <?php 
                     $nVatCalculate  = $this->session->userdata("nVatCalculate");
                     $nVatRate       = $this->session->userdata("nVatRate");
                     $nPrice         = $nPrice - $nDiscount;
                    if($nVatCalculate == 1){ //ภาษีรวมใน
                        $nVat = $nPrice -($nPrice*100)/(100+$nVatRate);
                    }else{
                        $nVat = $nPrice*(100+$nVatRate)/100-$nPrice;
                    }
                ?>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tTBMoneyVat') ?> <?=$nVatRate?> %</label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm"><?=number_format($nVat,2)?></label></div>
            </div>

            <div class="row" style="margin-top: 5px;">
                <?php 
                    if($aHDDis['rtCode'] == 1){ //มีส่วนลดท้ายบิล 
                        if($nVatCalculate == 1){ //ภาษีรวมใน
                            $nPriceGrand = $aHDDis['raItems'][0]['FCXhdTotalAfDisChg'];
                        }else{
                            $nPriceGrand = $aHDDis['raItems'][0]['FCXhdTotalAfDisChg'] + $nVat;
                        }
                    }else{
                        if($nVatCalculate == 1){ //ภาษีรวมใน
                            $nPriceGrand = $nPrice;
                        }else{
                            $nPriceGrand = $nPrice + $nVat;
                        }
                    }
                ?>
                <div class="col-xs-6 col-md-6 col-lg-6"><label class="xCNLabelFrm" style="font-size: 22px !important;"><?=language('register/buylicense/buylicense', 'tTBMoneyGrand') ?></label></div>
                <div class="col-xs-6 col-md-6 col-lg-6 text-right"><label class="xCNLabelFrm xCNPriceGrand" style="font-size: 22px !important;"><?=number_format($nPriceGrand,2)?></label></div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12 col-lg-12">
            <div><hr></div>
        </div>
	</div>

    <!--ข้อมูลส่วนล่าง-->
    <div class="row">

        <!--เลือกประเภทการจ่ายเงิน-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleTypePayment')?></label>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="row">
                        <?php 
                            if(!empty($oResultRCV['raItems'])){
                                $nCount = FCNnHSizeOf($oResultRCV['raItems']);
                                for($rc=0; $rc<$nCount; $rc++){
                                    $aItem          = $oResultRCV['raItems'];
                                    $rtRcvCode      = $aItem[$rc]['rtRcvCode'];
                                    $rtFmtCode      = $aItem[$rc]['rtFmtCode'];
                                    $rtRcvName      = $aItem[$rc]['rtRcvName'];
                                    $rtFmtRef       = $aItem[$rc]['rtFmtRef'];
                                    $rtRcvImg       = $aItem[$rc]['rtRcvImg'];
                                    $raoRcvConfig   = $aItem[$rc]['raoRcvConfig']; 
                                    
                                    if($rtFmtCode != '007'){ ?>
                                        <?php 
                                            if($rtFmtCode  == '005'){ //โอนเงิน
                                                $tShowBGTypePayment =  "<div class='xCNBlockRcvImage'>$rtRcvName</div>";
                                            }else{ //อื่นๆ พร้อมเพย์ ลดหนี้
                                                $tImgBase64 = $rtRcvImg;
                                                if($tImgBase64 == '' || $tImgBase64 == null){
                                                    $tImg = base_url() . '/application/modules/common/assets/images/icons/warning-50.png';
                                                }else{
                                                    $tImg = 'data:image/png;base64,'.$tImgBase64;
                                                } 

                                                $tShowBGTypePayment = "<img class='xCNImagePromptpay' src='$tImg'><br>";
                                            } 
                                        ?>
                                        <div class="col-xs-12 col-sm-6 col-md-12 col-lg-5">       
                                            <div class="xCNDisplayPayment">
                                                <label>
                                                    <?=$tShowBGTypePayment;?>
                                                    <input class="xCNPaymentBy" type="radio" name="orbPaymentBy" id="orbPaymentBy" 
                                                        value="<?=$rtRcvCode?>" 
                                                        data-rtfmtcode="<?=$rtFmtCode?>"
                                                        data-textnamercv="<?=$rtRcvName?>" >
                                                    <label class="form-check-label"><?=language('register/buylicense/buylicense', 'tTBSelected') ?></label>
                                                </label>
                                            </div>
                                        </div>
                                <?php }
                                }
                            }
                        ?>
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <label class="xCNLabelDescriptionPaymentBy" style="color:red; font-weight: bold;"></label>
                    <input type="hidden" id="ohdValuePaymentRcv" name="ohdValuePaymentRcv" value=""></input>
                </div>
            </div>
        </div>
        
        <!--ภาพ QR Code-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="border-left: 1px solid #eeeeee;">
            <?php for($o=0; $o<$nCount; $o++){ ?>
                <?php $rtRcvCode = $aItem[$o]['rtRcvCode']; ?>
                <?php $rtFmtCode = $aItem[$o]['rtFmtCode']; ?>
                <?php if($rtFmtCode  == '005'){ //โอนเงิน 
                    $tImgBase64  = $aItem[$o]['rtRcvImg'];
                    if($tImgBase64 == '' || $tImgBase64 == null){
                        $tImg = base_url() . '/application/modules/common/assets/images/logo/payment.png';
                    }else{
                        $tImg = 'data:image/png;base64,'.$tImgBase64;
                    } 
                } ?>
                <div id="odvContent<?=$rtRcvCode?>" style="display:none;" class="xCNContentImageDetailPayment">
                    <?php if($rtFmtCode  == '005'){ ?>
                        <img class="xCNImageTranferBy" src="<?=$tImg?>">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

    </div>  

    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="row xCNBlockInformationPayment">
            
                <label class="xCNInformationPayment xCNSwitchCasePayment"><?=language('register/buylicense/buylicense','tTextDetailPaymentSuccess01')?></label>
                <img style="width: 30px;" src="<?=base_url().'/application/modules/common/assets/images/icons/buy_line.png'?>">
                <label class="xCNInformationPayment" style="padding-left: 0px;"><?=language('register/buylicense/buylicense','tTextDetailPaymentSuccess02')?></label>
                <img style="width: 30px;" src="<?=base_url().'/application/modules/common/assets/images/icons/buy_telephone.png'?>">
                <label class="xCNInformationPayment" style="padding-left: 0px;"><?=language('register/buylicense/buylicense','tTextDetailPaymentSuccess03')?></label>
                <img style="width: 35px;" src="<?=base_url().'/application/modules/common/assets/images/icons/buy_email.png'?>">
                <label class="xCNInformationPayment" style="padding-left: 0px;"><?=language('register/buylicense/buylicense','tTextDetailPaymentSuccess04')?></label>
            </div>
        </div>
    </div>
</div>

<!--Modal ข้อมูลเพิ่มเติม-->
<div class="modal fade" id="odvModalInformationOther">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense','tTitleSeemore')?></label>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal แจ้งจ่ายเงินสำเร็จ สำหรับ พรอมเพย์-->
<div class="modal fade" id="odvModalPaymentSuccess" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense','tTitlewarningPayment')?></label>
			</div>
			<div class="modal-body">
                <p><?=language('register/buylicense/buylicense','tDetailwarningPayment')?></p>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onclick="JSxGoToPageDetailLicense()"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script>

    //Run Timer
    tTimeoutInterval        = "";
    tCheckPromptpay         = "";
    var timeleft            = 120;
    function JSxRunTimer(){
        timeleft--;
        $('.xCNCountdown').text('เหลือเวลา : ' + timeleft + ' วินาที');
        if(timeleft <= 0){
            clearInterval(tTimeoutInterval);
            clearInterval(tCheckPromptpay);
            $('.xCNCountdown').text('หมดเวลาการชำระเงิน กรุณากดใหม่อีกครั้ง');
            $('.xCNImagePromptpay').fadeOut('slow');
        }
    };

    //Check Promptpay
    function JSxCheckPromptpay(){
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseCallCheckPromptPay",
            cache   : false,
            async   : false,
            data    : { 'tDocumentNumber' : $('#ohdDocumentDummyForPayment').val() , 'nPriceGrand' : $('.xCNPriceGrand').text() , 'tRCVCode' : $('#ohdValuePaymentRcv').val() },
            timeout : 0,
            success : function(tResult){
                var oResult = JSON.parse(tResult);
                console.log(oResult);
                if(oResult.oResultPromptPay.Resp_Code == 00){
                    $('#odvModalPaymentSuccess').modal('show');

                    clearInterval(tCheckPromptpay); //จบ
                    clearInterval(tTimeoutInterval); //จบ
                }else if(oResult.oResultPromptPay.Resp_Code == 05){
                    console.log('PAYMENT END');
                    clearInterval(tCheckPromptpay); //จบ
                    clearInterval(tTimeoutInterval); //จบ
                }else{
                    //รอไป
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    };

    //กลับไปหน้าจอลงทะเบียน
    function JSxGoToPageDetailLicense(){
        clearInterval(tCheckPromptpay);  //จบ
        clearInterval(tTimeoutInterval); //จบ

        //Insert HD DT RC
        JSxCallAPIInsertDocument();
    }        

    //กดเปลี่ยนประเภท
    $('.xCNPaymentBy').change(function() {

        //Clear Time + clear check Promptpay
        clearInterval(tCheckPromptpay);
        clearInterval(tTimeoutInterval);
        $('.xCNCountdown').text('เหลือเวลา : 120 วินาที');

        var nValue      = $(this).val();
        var rtFmtCode   = $(this).data('rtfmtcode'); 
        $('.xCNLabelDescriptionPaymentBy').text('');
        $('.xCNContentImageDetailPayment').hide();
        $('#ohdValuePaymentRcv').val('');
        $('#odvContent'+nValue).show();
        $('.xCNBTNControlStep4 .xCNBTNSave').attr('disabled',false);

        //ถ้าเป็นโอนเงินจะมีคำอธิบายเพิ่มเติม
        if(rtFmtCode == '005'){ //โอนเงิน
            $('.xCNLabelDescriptionPaymentBy').text('');
            $('.xCNSwitchCasePayment').text('<?=language('register/buylicense/buylicense','tTextDetailPaymentSuccess01')?>');
        }else if(rtFmtCode == '013'){ //พร้อมเพย์
            var tID = 'odvContent'+nValue;
            $('.xCNLabelDescriptionPaymentBy').text('<?=language('register/buylicense/buylicense', 'tWarningDontCloseWeb') ?>');
            $('.xCNSwitchCasePayment').text('<?=language('register/buylicense/buylicense','tTextDetailPaymentSuccessPrompay')?>');
            JSxSeletedPayment(tID,nValue);

            //ปิดปุ่มชำระเงิน
            $('.xCNBTNControlStep4 .xCNBTNSave').attr('disabled',true);
        }

        $('#ohdValuePaymentRcv').val(nValue);
    });

    //ดูข้อมูลเพิ่มเติม
    function JSxViewSeeMoreDetail(){
        $('#odvModalInformationOther').modal('show');

        $.ajax({
            type    : "POST",
            url     : "BuyLicenseRecheckDetailMore",
            cache   : false,
            data    : { },
            timeout : 0,
            success : function(tResult){
                $('#odvModalInformationOther .modal-body').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //รัน Payment
    function JSxSeletedPayment(tID,tRCVCode){
        $('#'+tID).html('');
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseCallPromptPay",
            cache   : false,
            data    : { 'tDocumentNumber' : $('#ohdDocumentDummyForPayment').val() , 'nPriceGrand' : $('.xCNPriceGrand').text() , 'tRCVCode' : tRCVCode },
            timeout : 0,
            success : function(tResult){
                JCNxCloseLoading();
                var oResult = JSON.parse(tResult);
                if(oResult.oResultPromptPay.Resp_Code == 00){
                    var oQR             = oResult.oResultPromptPay.QRStrImg;
                    var tPathImage      = "data:image/png;base64," + oQR;
                    var tHTML           = "<label class='xCNCSSCountdown xCNCountdown'>เหลือเวลา : 120 วินาที</label>";
                        tHTML          += "<img class='xCNImagePromptpay' style='margin: 0px auto; display: block;' src='"+tPathImage+"'>";
                    $('#'+tID).append(tHTML);
                    
                    //SetTime
                    timeleft            = 120;
                    tTimeoutInterval    = setInterval(JSxRunTimer, 1000); //1 วินาที
                    tCheckPromptpay     = setInterval(JSxCheckPromptpay, 5000); //5 วินาที
                }else{
                    FSvCMNSetMsgErrorDialog('เกิดข้อผิดพลาด');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //กดค้นหาคูปอง + ใช้คูปอง
    $('.xCNBTNFindCoupons').click(function() {
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseFindCoupon",
            cache   : false,
            data    : { 'tCustomerID' : $('#ohdCustomerID').val() , 'tCouponCode' : $('#oetSearchCoupons').val() , 'nPriceTotal' : $('.xCNPriceTotal').text() },
            timeout : 0,
            success : function(tResult){
                JCNxCloseLoading();
                var oResult = JSON.parse(tResult);

                if(oResult.tStatus == 100){ //ค้นหาคูปองสำเร็จ
                    // $('#oetSearchCoupons').attr('readonly',true);
                    // $('.xCNBTNFindCoupons').attr('disabled',true);
                    $('.xCNValueCoupons').text(oResult.nDiscount);
                }else{

                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    //กดยกเลิกการใช้คูปอง
    $('.xCNBTNCancelCoupons').click(function() {
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseClearCoupon",
            cache   : false,
            data    : { 'tCustomerID' : $('#ohdCustomerID').val() , 'tCouponCode' : $('#oetSearchCoupons').val() , 'nPriceTotal' : $('.xCNPriceTotal').text() },
            timeout : 0,
            success : function(tResult){
                $('#oetSearchCoupons').val('');
                $('.xCNValueCoupons').text('0.00');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
</script>