<style>
    .xCNHederMenuWithoutFav{
        font-family : THSarabunNew-Bold;
        font-size   : 21px !important;
        line-height : 32px;
        font-weight : 500;
        color       : #179bfd !important;
    }
</style>

<div class="main-menu xCNPostionFixedBar">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-5 col-sm-8 col-md-8 col-lg-8">      
                <ol id="oliMenuNav" class="breadcrumb">
                    <li class="xCNLinkClick xCNHederMenuWithoutFav" onclick="JSvCallPageBuyLicenseList()" style="cursor:pointer">
                        <?php $tLangName = language('register/buylicense/buylicense','tMenuBuylicense'.$tTypepage); ?>
                        <?= $tLangName ?>
                    </li>
                </ol>
            </div>
            <div class="col-xs-7 col-md-4 col-sm-4 text-right p-r-0">
                <div>
                    <?php 
                    if($tTypepage == 1){ //ลงทะเบียนใช้งาน
                        $tLangNameEvent = language('register/buylicense/buylicense','tBtnRegister');
                        $tBtnDisabled = "disabled";
                    }else{ //ซื้อ License 
                        if($tTypepage == 0){ //มาจากหน้าจอทะเบียนใช้งาน
                            $tLangNameEvent = language('register/buylicense/buylicense','tBTNNext');
                            $tBtnDisabled = "";
                        }else{
                            $tLangNameEvent = language('register/buylicense/buylicense','tBtnBuy');
                            $tBtnDisabled = "";
                        }
                    } ?>

                    <!--ปุ่มของ [step1]-->
                    <div class="xCNBTNControlStep1">
                        <?php 
                            if($tTypepage == 0){ //มาจากหน้าจอทะเบียนใช้งาน
                                $tOnClick = 'JSxVCallPageInformation()';
                            }else{
                                $tOnClick = 'JSvCallPageBuyLicenseList()';
                            } 
                        ?>
                        <button type="button" class="btn xCNBTNCancel" onclick="<?=$tOnClick?>" style="margin-right: 10px;"><?=language('common/main/main','tCancel')?></button>
                        <button type="button" <?=$tBtnDisabled?> class="btn btn-primary xCNBTNSave xCNNextRegister" onclick="JSxNextStepToPageAddOn('Next')"><?=$tLangNameEvent?></button>
                    </div>

                    <!--ปุ่มของ [step2]-->
                    <div class="xCNBTNControlStep2" style="display:none;">
                        <?php 
                            if($tTypepage == 3){ //มาจากหน้าจอทะเบียนใช้งาน
                                $tOnClick = 'JSxVCallPageInformation()';
                            }else{
                                $tOnClick = 'JSvCallPageBuyLicenseList()';
                            } 
                        ?>
                        <button type="button" class="btn xCNBTNCancel" onclick="<?=$tOnClick?>" style="margin-right: 10px;"><?=language('register/buylicense/buylicense','tBTNPrevious')?></button>
                        <button type="button" class="btn btn-primary xCNBTNSave" onclick="JSxNextStepToPageDatatableList()"><?=language('register/buylicense/buylicense','tBTNNext')?></button>
                    </div>
                    
                    <!--ปุ่มของ [step3]-->
                    <div class="xCNBTNControlStep3" style="display:none;">
                        <button type="button" class="btn xCNBTNCancel" onclick="JSxNextStepToPageAddOn('Previous')" style="margin-right: 10px;"><?=language('register/buylicense/buylicense','tBTNPrevious')?></button>
                        <button type="button" class="btn btn-primary xCNBTNSave" onclick="JSvNextStepToPagePayment()"><?=language('register/buylicense/buylicense','tBTNConfirmAndPayment')?></button>
                    </div>

                    <!--ปุ่มของ [step4]-->
                    <div class="xCNBTNControlStep4" style="display:none;">
                        <?php if($tTypepage == 2){ //ต่ออายุ ?>
                            <button type="button" class="btn xCNBTNCancel" onclick="JSxVCallPageInformation()" style="margin-right: 10px;"><?=language('common/main/main','tCancel')?></button>
                        <?php }else{ ?>
                            <button type="button" class="btn xCNBTNCancel" onclick="JSvCallPageBuyLicenseList()" style="margin-right: 10px;"><?=language('common/main/main','tCancel')?></button>
                        <?php } ?>
                        <button type="button" class="btn btn-primary xCNBTNSave" onclick="JSxCallAPIInsertDocument()"><?=language('register/buylicense/buylicense','tTitlePay')?></button>
                    </div>

               </div>
            </div>
        </div>    
    </div>
</div>
<div class="xCNMenuCump xCNClrBrowseLine" id="odvMenuCump">
    &nbsp;
</div>

<div class="main-content xCNPostionDisplay">
    <div id="odvContentPageBuylicense" class="panel panel-headline"></div>
</div>

<!--Modal จ่ายเงินสำเร็จ-->
<div class="modal fade" id="odvModalPaymentSuccessAndLogout"  data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('register/buylicense/buylicense', 'tTitleSuccessFreePriceZero')?></label>
			</div>
			<div class="modal-body">
                <label><?=language('register/buylicense/buylicense', 'tDetailSuccessFreePriceZero')?></label>
			</div>
			<div class="modal-footer">
                <a href="logout" style="color:#FFF;">
                    <button class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
                </a>
			</div>
		</div>
	</div>
</div>

<?php include "script/jBuyLicense.php"; ?>