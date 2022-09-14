<style>
    .xCNBlockBusiness{
        border          : 1px solid #cccccc;
        cursor          : pointer;
        border-radius   : 5px;
        margin-bottom   : 10px;
    }

    .xCNBlockBusinessActive{
        border          : 1px solid #000;
        cursor          : pointer;
        border-radius   : 5px;
        margin-bottom   : 10px;
    }

    .xCNTextBlockBusinessActive{
        text-align      : center;
        margin          : 0px auto;
        display         : block;
        font-family     : THSarabunNew-Bold;
        font-size       : 17px !important;
        font-weight     : bold;
        color           : #232C3D !important;
    }

    .xCNTextBlockBusiness{
        text-align      : center;
        margin          : 0px auto;
        display         : block;
        font-family     : THSarabunNew-Bold;
        font-size       : 17px !important;
        font-weight     : bold;
        color           : #cccccc;
    }

    .xCNImageBusiness{
        display         : block;
        opacity         : 0.2;
        margin          : 0px auto;
        padding         : 20px;
        width           : 90px;
    }

    .xCNImageBusinessActive{
        display         : block;
        opacity         : 1;
        margin          : 0px auto;
        padding         : 20px;
        width           : 90px;
    }

    .xCNImageFlagPackage{
        display         : block;
        margin          : 2px auto;
        width           : 20px;
    }

    .xCNBtnBlock{
        background      : #dbdbdb;
        color           : #FFF;
        cursor          : no-drop !important;
    }

    .xCNPackageHilight{
        background      : #f4f6f6;
    }
</style>

<div class="panel-heading">
    <!--ข้อมูลส่วนบน-->
	<div class="row">
        <!--หัวข้อ ข้อมูลผู้ติดต่อ-->
        <?php if($tTypepage == 1){ ?>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitleInformation')?></label>
                </div>
                <div><hr></div>
            </div>
        <?php } ?>

        <!--ข้อมูลผู้ติดต่อ-->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php if($tTypepage == 1){ //ลงทะเบียนใช้งาน ?>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?=language('register/buylicense/buylicense', 'tBUYNameCustomer') ?></label>
                    <input type="text" class="form-control" id="oetBuyName" name="oetBuyName" maxlength="30" placeholder="<?=language('register/buylicense/buylicense', 'tBUYNameCustomer') ?>" value="">
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?=language('register/buylicense/buylicense', 'tBUYTelCustomer') ?></label>
                    <input type="text" class="form-control xCNInputNumericWithoutDecimal" id="oetBuyTel" name="oetBuyTel" maxlength="20" placeholder="<?=language('register/buylicense/buylicense', 'tBUYTelCustomer') ?>" value="">
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span><?=language('register/buylicense/buylicense', 'tBUYEmailCustomer') ?></label>
                    <input type="email" class="form-control" id="oetBuyEmail" name="oetBuyEmail" maxlength="50" placeholder="<?=language('register/buylicense/buylicense', 'tBUYEmailCustomer') ?>" value="">
                    <em id="oetBuyEmail-error" class="error help-block" style="color: red; display: none;"><?=language('register/buylicense/buylicense', 'tBUYEmailValidate') ?></em>
                </div>

                <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
                    <input class="form-check-input xCNRadioTypeLicense" type="radio" name="orbBuyTypeLicense" id="orbBuyTypeLicense" value="1" checked>
                    <label class="form-check-label"><?=language('register/buylicense/buylicense', 'tBUYTypeDemo') ?></label>
                </div>
                <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
                    <input class="form-check-input xCNRadioTypeLicense" type="radio" name="orbBuyTypeLicense" id="orbBuyTypeLicense" value="2">
                    <label class="form-check-label"><?=language('register/buylicense/buylicense', 'tBUYTypeReal') ?></label>
                </div>

                <div class="form-group xCNFormCountBCH" style="display:none;">
                    <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYCountbch') ?></label>
                    <input type="text" style="text-align: right;" onkeyup="this.value = minmax(this.value, 1, 9999)" class="form-control xCNInputNumericWithoutDecimal" id="oetBuycountbch" name="oetBuycountbch" maxlength="4" placeholder="<?=language('register/buylicense/buylicense', 'tBUYCountbch') ?>" value="1">
                </div>

                <?php if(!empty($aCstPrivacy['roItem']['rtURLSLA']) && !empty($aCstPrivacy['roItem']['rtURLPADA'])){ ?>
                    <input type="hidden" name="ohdURLSLASta" id="ohdURLSLASta">
                    <input type="hidden" name="ohdURLPADASta" id="ohdURLPADASta">
                    <div class="form-group">
                        <label id="oblAccpetAgree" class="fancy-checkbox xCNDisabled" style="display: inline;">
                            <input id="ocbAccpetAgree" type="checkbox" class="ocbAccpetAgree" name="ocbAccpetAgree[]" disabled>
                            <span ></span>
                        </label>
                        <?=language('register/buylicense/buylicense', 'tTextAgreement') ?> <a target="_blank" onclick="JSxAcceptAgree('ohdURLSLASta')" href="<?=$aCstPrivacy['roItem']['rtURLSLA']?>"><u><?=language('register/buylicense/buylicense', 'tTextServiceCondition') ?></u></a> <?=language('register/buylicense/buylicense', 'tTextAnd') ?> <a target="_blank"  onclick="JSxAcceptAgree('ohdURLPADASta')"  href="<?=$aCstPrivacy['roItem']['rtURLPADA']?>"><u><?=language('register/buylicense/buylicense', 'tTextPrivacypolicy') ?></u></a> 
                    </div>
                <?php } ?>

            <?php } ?>
		</div>

        <!--ธุรกิจที่สนใจ-->
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <?php if($tTypepage == 1){ //ลงทะเบียนใหม่ ?>
                <label class="xCNLabelFrm xCNTitleBus"><?=language('register/buylicense/buylicense','tTitleTypeInterest')?></label>
            <?php } ?>
            <div class="row">
                <?php $tTextBusinessType = 0; ?>
                <?php if($tTypepage == 1){ //ลงทะเบียนใหม่ ?>
                    <?php
                        if($aBusiness['rtCode'] == 001){
                            $nCountBusiness = FCNnHSizeOf($aBusiness['raItems']);
                            $aItemBusiness  = $aBusiness['raItems'];
                            for($i=0; $i<$nCountBusiness; $i++){ ?>
                                <?php $tBusCode = $aItemBusiness[$i]['rtBusCode']; ?>
                                <?php $tBusType = $aItemBusiness[$i]['rtBusStaType']; ?>
                                <?php if($i==0){ $tTextBusinessType = $tBusCode; } ?>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3 xCNBusType<?=$tBusType?>" data-valuebuscode='<?=$tBusCode?>'>
                                    <div onclick="JSxClickBlockBusiness('<?=$tBusCode?>','<?=$tBusType?>')" class="Business<?=$tBusCode?> xCNClickBlockBusiness xCNBlockBusiness <?=($i==0) ? 'xCNBlockBusinessActive' : '' ?>">
                                        <?php 
                                            $tImgBase64 = $aItemBusiness[$i]['rtBusImg'];
                                            if($tImgBase64 == '' || $tImgBase64 == null){
                                                $tImg = base_url() . '/application/modules/common/assets/images/icons/warning-50.png';
                                            }else{
                                                $tImg = 'data:image/png;base64,'.$tImgBase64;
                                            }   
                                        ?>
                                        <img class="xCNImage xCNImageBusiness <?=($i==0) ? 'xCNImageBusinessActive' : '' ?>"  src="<?=$tImg?>">
                                    </div>
                                    <label class="xCNTextBlock TextBusiness<?=$tBusCode?> xCNTextBlockBusiness <?=($i==0) ? 'xCNTextBlockBusinessActive' : '' ?>">
                                        <?=$aItemBusiness[$i]['rtBusName']?>
                                    </label>
                                </div>
                            <?php }
                        }
                    ?>
                <?php } ?>
                <script> $('.xCNBusType2').hide(); </script>
                <input type="hidden" id="ohdValueBlockBusiness" name="ohdValueBlockBusiness" value="<?=$tTextBusinessType?>">

                <!-- <div class="col-xs-6 col-md-6 col-lg-6">
                    <div class="row"> -->
                        <!--อื่นๆ โปรดระบุ-->
                        <?php if($tTypepage == 1){ //ลงทะเบียน  ?> 
                            <!-- <div class="col-xs-12 col-md-12 col-lg-12">
                                <div class="form-group xCNFormBusinessOther" style="display:none">
                                    <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense', 'tBUYBusinessOther')?></label>
                                    <input type="text" class="form-control" id="oetBuyBusinessOther" name="oetBuyBusinessOther" maxlength="30" placeholder="<?=language('register/buylicense/buylicense', 'tBUYBusinessOtherkey') ?>" value="">
                                </div>
                            </div> -->
                        <?php } ?>
                    <!-- </div>
                </div> -->
            </div>
        </div>
	</div>

    <?php 
        if($tTypepage == 0){//ซื้อเพิ่ม
            
            if(empty($aItemLicKey)){
                $tPackageCurrent    = '';
            }else{
                $tPackageCurrent    = $aItemLicKey['raoDataPackage'][0]['rtPdtCode'];
            }

            if($tPackageCurrent == '' || $tPackageCurrent == null){ //เข้ามาแบบซื้อ แต่ยังไม่มีแพ๊คเเกจ
                $tTextPackageCurrent = 'false';
            }else{ //เข้ามาแบบซื้อ มีแพ๊คเกจเเล้ว
                $tTextPackageCurrent = 'have';
            }
        }else{ //เข้ามาแบบลงทะเบียน แต่ไม่มีแพ๊คเกจ
            $tTextPackageCurrent = 'false';
        }
    ?>
    <input type="hidden" id="ohdCurrentPackage" name="ohdCurrentPackage" value="<?=$tTextPackageCurrent?>" >

    <!--ข้อมูลส่วนล่างพวกแพ็คเกจ-->
    <div class="row" style="margin-top: 10px;">
        <!--หัวข้อ แพ็คเกจ-->
		<div class="col-xs-7 col-md-10 col-lg-10">
            <div class="form-group">
                <label class="xCNLabelFrm"><?=language('register/buylicense/buylicense','tTitlePackage')?></label>
            </div>
		</div>

        <!--ตัวกรองค้นหา-->
        <div class="col-xs-5 col-md-2 col-lg-2">
            <div class="form-group">
                <select class="selectpicker form-control" id="ocmFilterPackage" name="ocmFilterPackage" maxlength="1" onchange="JSxChangeFilterPackage(this,1)"></select>
			</div>
        </div>

        <!--ตาราง-->
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <div id="odvContentPackageAndPrice"></div>
            </div>
        </div>
    </div>          
</div>

<!--Modal ถ้าเป็น Demo ไม่สามารถเลือก AddOn ได้ -->
<div class="modal fade" id="odvModalDemoCantSeletedAddOn">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitlewarning')?></label>
			</div>
			<div class="modal-body">
                <label><?=language('register/buylicense/buylicense', 'tWarningDemoCantAddon')?></label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal ข้อมูลไม่สมบูรณ์-->
<div class="modal fade" id="odvModalSelectedPackage">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitlewarning')?></label>
			</div>
			<div class="modal-body">
                <label><?=language('register/buylicense/buylicense', 'tWarningnopackage')?></label>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal ค้นหาแพ็คเพจพิเศษๆ จากฟิลเตอร์แบรนด์-->
<div class="modal fade" id="odvModalFilterSPC">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitleSearchPackage')?></label>
			</div>
			<div class="modal-body">
                <label style="font-weight: bold;"><?=language('common/main/main', 'tSearch')?></label>
                <input type="text" class="form-control" maxlength="20" value="" id="oetSearchPackageSPC" name="oetSearchPackageSPC" placeholder="<?=language('common/main/main','tPlaceholder')?>">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" onclick="JSxModalFilterSPC_Confirm()"><?=language('common/main/main', 'tModalConfirm')?></button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal" onclick="JSxModalFilterSPC_Close()"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal ลงทะเบียนสำเร็จ สำหรับ Demo -->
<div class="modal fade" id="odvModalRegisterSuccess"  data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitleSuccess')?></label>
			</div>
			<div class="modal-body">
                <label><?=language('register/buylicense/buylicense', 'tDetailSuccess')?></label>
			</div>
			<div class="modal-footer">
                <a href="logout" style="color:#FFF;">
                    <button class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
                </a>
			</div>
		</div>
	</div>
</div>

<!--Modal ลงทะเบียนสำเร็จ + กรณีมีสาขามากกว่า 1 สาขา ต้องรอ approve licesnse -->
<div class="modal fade" id="odvModalRegisAndBuyMoreOneBch"  data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitleSuccessMoreOneBch')?></label>
			</div>
			<div class="modal-body">
                <label><?=language('register/buylicense/buylicense', 'tDetailSuccessMoreOneBch')?></label>
			</div>
			<div class="modal-footer">
                <a href="logout" style="color:#FFF;">
                    <button class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
                </a>
			</div>
		</div>
	</div>
</div>

<!--Modal ต้องอ่านเงื่อนไขให้ครบ 2 เอกสารก่อนการลงทะเบียน-->
<div class="modal fade" id="odvModalUMustReadTwoCondition"  data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitlewarning')?></label>
			</div>
			<div class="modal-body">
                <label id="olbTextMustReadTwoCondition"></label>
			</div>
			<div class="modal-footer">
                <button class="btn xCNBTNPrimery" data-dismiss="modal"><?=language('common/main/main', 'tModalConfirm')?></button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<!--เก็บค่าไว้ว่าหน้าจอเคยค้นหาไหม 0:โชว์ทั้งหมด 1:เคยค้นหาไปเเล้ว-->
<input type="hidden" id="ohdKeepSearchOrAll" name="ohdKeepSearchOrAll" value="0">

<script>

    //โหลดข้อมูลตารางแพ็คเกจ และ ราคา
    JSxLoadContentPackageAndPrice('');

    //control ปุ่ม package
    JSxControlPackage(1);

    $('document').ready(function(){
        //เวลากรอกอีเมล์ตัว แจ้งเตือนต้องหาย
        $('#oetBuyEmail').keypress(function(){
            $("#oetBuyEmail-error").css("display", "none");
        });
    });

    //โหลดข้อมูลตารางแพ็คเกจ และ ราคา
    function JSxLoadContentPackageAndPrice(ptFilterPackageSPC){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "BuyLicenseLoadTablePackage",
            cache   : false,
            data    : {'tTypepage' : '<?=$tTypepage?>' , 'tFilterPackageSPC' : ptFilterPackageSPC },
            timeout : 0,
            success : function(tResult){
                $('#odvContentPackageAndPrice').html(tResult);
                JCNxCloseLoading();
                JSxControlPackage(1);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //ตัวกรองฟิลเตอร์แบรนด์
    function JSxChangeFilterPackage(elem,ptType){
        if(ptType == 1){
            var nCodeBrand      = $(elem).val();
        }else{
            var nCodeBrand      = elem;
        }

        var nLangTable      = $('#otbPackage thead th').length;
        var tBrand          = 'xBrand' + nCodeBrand;

        //ถ้าเคยค้นหาไปเเล้ว แล้วกด PC Moblie อีก จะต้องกรองข้อมูลอีกรอบ
        if(nCodeBrand != 'SPC' && $('#ohdKeepSearchOrAll').val() == '1'){
            JSxLoadContentPackageAndPrice('');
            $('#ohdKeepSearchOrAll').val(0);
            $('.selectpicker').selectpicker('refresh');
        }

        if(nCodeBrand == 'ALL'){ //ถ้าดูทั้งหมด
            $('.xPackageALL , .xCNAllowListALL , .xPackagePriceALL , .xCNBTNPackageALL').show();
        }else if(nCodeBrand == 'SPC'){ //ถ้ากรองแบบพิเศษ
            $('#oetSearchPackageSPC').val('');
            $('#odvModalFilterSPC').modal('show');
        }else{ //ถ้าดูตามประเภท
            $('.xPackageALL , .xCNAllowListALL , .xPackagePriceALL , .xCNBTNPackageALL').hide();
            for(var i=0; i<nLangTable; i++){
                var bCheckClassBrand = $('#otbPackage thead tr th:eq('+i+')').hasClass(tBrand);
                if(bCheckClassBrand == true){
                    var tCodePackage = $('#otbPackage thead tr th:eq('+i+')' + '.'+tBrand).data('packagecode');
                    $('.xPackage' + tCodePackage).show();
                    $('.xCNAllowList' + tCodePackage).show();
                    $('.xPackagePrice' + tCodePackage).show();
                    $('.xCNBTNPackage' + tCodePackage).show();
                }
            }
        }

        $('#ocmFilterPackage').val(nCodeBrand);
        $('.selectpicker').selectpicker('refresh');

        if ($("input[name='orbBuyTypeLicense']:checked").val() == '2') {  //เปิดร้านค้าจริง
            JSxClickBlockBusiness('','2');
        }else{
            JSxClickBlockBusiness('','1');
        }

        // control ปุ่ม package
        JSxControlPackage(1);
    }

    //ถ้าเลือกประเภททดลองใช้ ช่องกรอกจำนวนสาขาต้องหายไปเลย
    $('.xCNRadioTypeLicense').change(function () {
        if ($("input[name='orbBuyTypeLicense']:checked").val() == '2') {  //เปิดร้านค้าจริง
            $('.xCNFormCountBCH').show();

            //เลือกธุรกิจ
            JSxClickBlockBusiness('','2');
        }else{ //ทดลองใช้
            $('.xCNFormCountBCH').hide();

            //ล้างค่าแพ็จเกจที่เคยเลือก
            $('#ohdValuePackage').val('');

            //control ปุ่ม package
            JSxControlPackage(1);

            JSxSelectPackage('','');

            //เลือกธุรกิจ
            JSxClickBlockBusiness('','1');
        }

        //control ปุ่ม package
        JSxControlPackage(1);
    });
    
    //กดที่ประเภทธุรกิจที่สนใจ
    function JSxClickBlockBusiness(nValue,ptType){

        //โชว์ title
        $('.xCNTitleBus').show();

        if(ptType == 2){ //เปิดร้านค้าจริง
            $('.xCNBusType1').hide();
            $('.xCNBusType2').hide();
            $('.xCNTitleBus').hide();
            if(nValue == ''){ var nValueBusCode = $('.xCNBusType2:eq(0)').data('valuebuscode'); var nValue = nValueBusCode; }
        }else if(ptType == 1){ //ทดลองใช้งาน
            $('.xCNBusType1').show();
            $('.xCNBusType2').hide();
            if(nValue == ''){ var nValueBusCode = $('.xCNBusType1:eq(0)').data('valuebuscode'); var nValue = nValueBusCode; }
        }

        //ตัวอื่นต้องไม่เด่น
        $('.xCNImage').removeClass('xCNImageBusinessActive').addClass('xCNImageBusiness')
        $('.xCNTextBlock').removeClass('xCNTextBlockBusinessActive').addClass('xCNTextBlockBusiness');
        $('.xCNClickBlockBusiness').removeClass('xCNBlockBusinessActive').addClass('xCNBlockBusiness');

        //Hi-light
        $('.Business'+nValue).find('.xCNImage').removeClass('xCNImageBusiness').addClass('xCNImageBusinessActive');
        $('.Business'+nValue).parent().find('.xCNTextBlock').removeClass('xCNTextBlockBusiness').addClass('xCNTextBlockBusinessActive');
        $('.Business'+nValue).removeClass('xCNBlockBusiness').addClass('xCNBlockBusinessActive');

        //กำหนดค่า
        $('#ohdValueBlockBusiness').val(nValue);
    }

    //control ปุ่ม package
    function JSxControlPackage(pnBchCount){
        if('<?=$tTypepage?>' == 1){ //ลงทะเบียน
            var nBuyTypeLicense = $("input[name='orbBuyTypeLicense']:checked").val();
            $(".xCNBTNSelectPackage").addClass('xCNBtnBlock').attr('disabled',true);

            if(nBuyTypeLicense == '1'){ //ทดลองใช้
                $('#otbPackage tfoot tr td.xCNClassPackageFordemo').find('.xCNBTNSelectPackage').removeClass('xCNBtnBlock').attr('disabled',false); //ปิด package -> Demo
            }else{ //เปิดร้านค้าจริง
                $(".xCNBTNSelectPackage").removeClass('xCNBtnBlock').attr('disabled',false);
                $('#otbPackage tfoot tr td.xCNClassPackageFordemo').find('.xCNBTNSelectPackage').addClass('xCNBtnBlock').attr('disabled',true); //ปิด package -> Demo
            }
        }else if('<?=$tTypepage?>' == 0){ //ซื้อเพิ่ม
            $(".xCNBTNSelectPackage").addClass('xCNBtnBlock').attr('disabled',true);
            $(".xCNBTNSelectPackage").removeClass('xCNBtnBlock').attr('disabled',false);
        }
    }

    //เวลาเปลี่ยนจำนวน
    $('#oetBuycountbch').on("keyup blur change", function(event) {
        var nValue = $(this).val();
        JSxControlPackage(1);
    });

    //เลือก package
    function JSxSelectPackage(ptType,ptCode){
        if('<?=$tTypepage?>' == 1){ //ลงทะเบียน - เลือกเเล้วเลือกเลย
            var tFindClass = false;
        }else if('<?=$tTypepage?>' == 0){ //ซื้อเพิ่ม - สามารถกดเข้าและกดออกได้
            var tFindClass = $(".xCNBTNSelectPackage[data-package='"+ptType+"']").hasClass('btn-primary');
        }

        if(tFindClass == false){
            //UnHi-light ตาราง + ปุ่ม
            $('tbody tr').find('.xCNPackageHilight').removeClass('xCNPackageHilight');
            $(".xCNBTNSelectPackage").removeClass('btn-primary');
            $('#ohdValuePackage').val('');

            //Hi-light ตาราง
            var nLangTable = $('#otbPackage tbody tr').length;
            for(var i=0; i<nLangTable; i++){
                $('tbody tr:eq('+i+') .xCNAllowList'+ptCode).addClass('xCNPackageHilight');
            }

            //Hi-light ปุ่ม
            $(".xCNBTNSelectPackage[data-package='"+ptType+"']").removeClass('xCNBTNCancel').addClass('btn-primary');
            $('#ohdValuePackage').val(ptCode);
        }else{
            //UnHi-light ตาราง + ปุ่ม
            $('tbody tr').find('.xCNPackageHilight').removeClass('xCNPackageHilight');
            $(".xCNBTNSelectPackage").removeClass('btn-primary');
            $('#ohdValuePackage').val('');
        }
    }

    //ห้ามกรอกจำนวนสาขาน้อยกว่า 1
    function minmax(value, min, max) {
        if(parseInt(value) < min || isNaN(parseInt(value))) 
            return min; 
        else if(parseInt(value) > max) 
            return max; 
        else return value;
    }

    //กดปุ่ม URL เงื่อนไขบริการและ ความเป็นส่วนตัว
    function JSxAcceptAgree(ptData){
        $('#'+ptData).val(1);
        if($('#ohdURLSLASta').val()==1 && $('#ohdURLPADASta').val()==1){
            $('#ocbAccpetAgree').prop('disabled',false);
            $('#oblAccpetAgree').removeClass('xCNDisabled');
        }else{
            $('#ocbAccpetAgree').prop('disabled',true);
            $('#oblAccpetAgree').addClass('xCNDisabled');
        }
    }
    
    //ต้องอ่านเงื่อนไขเอกสารให้ครบ 2 เอกสารก่อน กดลงทะเบียน
    $('#oblAccpetAgree').on('click',function(){
        var tAccpetAgree = $('#oblAccpetAgree').hasClass('xCNDisabled');
        if(tAccpetAgree == true){

            $('#odvModalUMustReadTwoCondition').modal('show');
            if($('#ohdURLSLASta').val() != 1 && $('#ohdURLPADASta').val() != 1){
                $('#olbTextMustReadTwoCondition').text('<?=language('register/buylicense/buylicense', 'tDetailMustReadTwoConditionAll')?>')
            }else if($('#ohdURLSLASta').val() != 1){  //เงื่อนไขการให้บริการ
                $('#olbTextMustReadTwoCondition').text('<?=language('register/buylicense/buylicense', 'tDetailMustReadTwoConditionSLA')?>')
            }else if($('#ohdURLPADASta').val() != 1){  //นโยบายความเป็นส่วนตัว
                $('#olbTextMustReadTwoCondition').text('<?=language('register/buylicense/buylicense', 'tDetailMustReadTwoConditionPADA')?>')
            }
        }
    });

    //กดปุ่ม ยอมรับก่อนถึงจะกดลงทะเบียนได้
    $('#ocbAccpetAgree').on('click',function(){
        if($(this).prop('checked')==true){
            $('.xCNNextRegister').prop('disabled',false);
        }else{
            $('.xCNNextRegister').prop('disabled',true);
        }
    });

    //กดค้นหาจาก แพ็คเกจเพิ่มเติม
    function JSxModalFilterSPC_Confirm(){
        var tFilterPackageSPC = $('#oetSearchPackageSPC').val();
        if(tFilterPackageSPC == '' || tFilterPackageSPC == null){
            $('#oetSearchPackageSPC').focus();
        }else{
            $('#odvModalFilterSPC').modal('hide');
            JSxLoadContentPackageAndPrice(tFilterPackageSPC);
            $('#ohdKeepSearchOrAll').val(1);
        }
    }

    //ปิดปุ่ม การค้นหา แพ็คเกจเพิ่มเติม จาก option แบรนด์
    function JSxModalFilterSPC_Close(){
        $('#ocmFilterPackage').val('ALL');
        $('.selectpicker').selectpicker('refresh');
        JSxChangeFilterPackage($('#ocmFilterPackage'),1);
    }

</script>