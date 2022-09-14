<?php 
    $tCstContactV1No = "";
    $tCstContactV1Soi = "";
    $tCstContactV1Village = "";
    $tCstContactV1Road = "";
    $tCstContactWebsite = "";
    $tCstContactRmk = "";
    $tCstContactLongitude = "";
    $tCstContactLatitude = "";
    $tCstContactCountry = "";
    $tCstContactZoneCode = "";
    $tCstContactProvinceCode = "";
    $tCstContactDistrictCode = "";
    $tCstContactSubDistrictCode = "";
    $tCstContactZoneName = "";
    $tCstContactProvinceName = "";
    $tCstContactDistrictName = "";
    $tCstContactSubDistrictName = "";
    $tCstContactPostCode = "";
?>
<div id="odvTabContact" class="tab-pane fade">
    <div class="row" id="xWContactAdd">
        <div class="col-xl-12 col-lg-12">
            <button id="xWAdvAddHeadRow" class="xCNBTNPrimeryPlus" style="margin-bottom:10px;" type="button" onclick="JSxCSTCtrAddContactForm()">+</button>
            <!-- <a href="javascipt:;" class="btn pull-right xWCstBtn xWCstBtnAdd" id="xWAdvAddHeadRow" onclick="JSxCSTCtrAddContactForm()"><i class="fa fa-plus"></i> <?= language('customer/customer/customer','tCSTAdd')?></a> -->
        </div>
    </div>
    <div class="row hidden" id="xWContactFormContainer">
        <form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerContact">
            <button style="display:none" type="submit" id="obtSave_oliCstContact" onclick="JSnCSTAddEditCustomerContact()"></button>
            <a href="javascript:;" style="display:none" type="submit" id="obtCancel_oliCstContact" onclick="JSnCSTCancelCustomerContact()"></a>
            <input type="hidden" name="ohdCstCode" id="ohdCstCode" value="<?php echo $tCstCode; ?>">
            <input type="hidden" name="ohdCstContactSeq" id="ohdCstContactSeq">
            <?php if(false) : ?>
            <div class="col-xl-4 col-lg-4 col-md-4" id="odvCstContactImgContainer"> 
                <div class="form-group">
                    <div id="odvCstContactImg">
                        <img class="img-responsive xCNCenter" id="oimImgMasterContact" src="http://www.bagglove.com/images/400X200.gif">
                    </div>
                    <div class="form-group">
                        <div class="xCNUplodeImage">
                            <input type="hidden" id="oetImgInputContact" name="oetImgInputContact">
                            <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Contact')"><i class="fa fa-camera"></i> <?= language('common/main','tSelectPic')?></button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTContactName')?></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        maxlength="100" 
                        id="oetCstContactName"
                        name="oetCstContactName" 
                        value=""
                        data-validate="<?php echo language('customer/customer/customer','tCstValidateContact');?>">
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTContactEmail')?></label>
                    <input 
                        type="text" 
                        class="form-control"
                        maxlength="100" 
                        id="oetCstContactEmail" 
                        name="oetCstContactEmail" 
                        data-validate="<?php echo language('customer/customer/customer','tCstValidateEmail');?>"
                        autocomplete ="off";
                        value="">
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTContactTel')?></label>
                    <input 
                        type="text" 
                        class="form-control" 
                        maxlength="100" 
                        id="oetCstContactTel" 
                        name="oetCstContactTel" 
                        data-validate="<?php echo language('customer/customer/customer','tCstValidateTel');?>"
                        autocomplete ="off";
                        value="">
                </div>
                 <div class="form-group">
                    <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTContactFax')?></label>
                    <input 
                        type="text" 
                        class="form-control"
                        maxlength="100" 
                        id="oetCstContactFax" 
                        name="oetCstContactFax"
                        data-validate="<?php echo language('customer/customer/customer','tCstValidateFax');?>"
                        autocomplete ="off";
                        value="">
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="validate-input">
                                <label class="xCNLabelFrm"><?= language('customer/customer/customer','tCSTContactComment')?></label>
                                <textarea maxlength="100" rows="4" id="otaCstContactRmk" name="otaCstContactRmk"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            // $mode = 1;
            // if($mode == 1) : 
            //     include "wCstTabContact_AddressSplit.php";
            // endif;
            // if($mode == 2) : 
            //     include "wCstTabContact_AddressCombine.php";
            // endif;
            ?>
        </form>
    </div>
    <!--- Begin Customer Contact Info Data Table -->
    <section id="ostDataCustomerContactInfo"></section>
    <!-- End Customer Contact Info Data Table -->
</div>

