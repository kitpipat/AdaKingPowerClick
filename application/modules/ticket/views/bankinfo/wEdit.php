<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWEditBankInfo">
    <div class="main-menu">     
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick"onclick="JSxCallPage('<?= base_url() ?>EticketBankInfo')"><?= language('ticket/bank/bank', 'tTransferInformation') ?></li> 
                            <li  class="xCNLinkClick"><?= language('ticket/bank/bank', 'tEditTransferInformation') ?></li>
                            </ol>       
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <div class="demo-button xCNBtngroup">
                            <button type="button" onclick="JSxCallPage('<?= base_url() ?>EticketBankInfo')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                            <div class="btn-group">
                            <button class="btn btn-default xWBtnGrpSaveLeft" type="submit"><?= language('ticket/user/user', 'tSave') ?></button>
                            <button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu xWDrpDwnMenuMargLft">
                            <li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndView') ?></a></li>
                            <li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndNew') ?></a></li>
                            <li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndBack') ?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <input type="hidden" name="ohdFTBbkCode" id="ohdFTBbkCode" value="<?= $oBbk[0]->FTBbkCode ?>" />
        <div class="main-content">
            <div class="panel panel-headline">
                <div class="panel-heading"> 
                    <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="upload-img" id="oImgUpload">
                    <?php
                        if(isset($oBbk[0]->FTImgObj) && !empty($oBbk[0]->FTImgObj)){
                                $tFullPatch = './application/modules/'.$oBbk[0]->FTImgObj;
                        if (file_exists($tFullPatch))
                        {
                                $tPatchImg = base_url().'/application/modules/'.$oBbk[0]->FTImgObj;
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                    ?>
                    <?php if(isset($oBbk[0]->FTImgObj) && !empty($oBbk[0]->FTImgObj)): ?>
                        <a href="javascript:void(0)" id="oDelImgBif" onclick="JSxBifDelImg('<?php echo $oBbk[0]->FTBbkCode; ?>', '<?php echo $oBbk[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                        <?php endif; ?>
                        <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain">	
                        <span class="btn-file"> 
                        <input type="hidden" name="ohdBBKImg" id="oetImgInputMain">
                    </span>
                </div>
            <div class="xCNUplodeImage">
        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '4/4')"><i class="fa fa-camera"></i> <?= language('common/main/main', 'tSelectPic') ?></button>
            </div>
                </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="form-group">                    
                            <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tBank') ?></label>
                                <select class="selectpicker form-control" id="ocmFTBnkCode" name="ocmFTBnkCode" style="width: 100%">
                                    <option value=""><?= language('ticket/bank/bank', 'tSelectBank') ?></option>
                                        <?php foreach ($oBnkMs AS $oValue): ?>
                                    <option value="<?= $oValue->FTBnkCode ?>"<?php
                                    if ($oValue->FTBnkCode == $oBbk[0]->FTBnkCode) {
                                        echo " selected";
                                    }?>
                                ><?= $oValue->FTBnkName ?>
                                </option>										
                        <?php endforeach; ?>			       
                    </select>
                </div>   
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tAccountName') ?></label>
                        <input class="form-control" type="text" name="oetFTBbkName" id="oetFTBbkName" value="<?= $oBbk[0]->FTBbkName; ?>">
                        <span class="focus-input100"></span>   
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm" data-validate="<?= language('ticket/bank/bank', 'tPlease2') ?>"><?= language('ticket/bank/bank', 'tBankBranch') ?></label>
                        <input class="form-control" type="text" name="oetFTBbkBranch" id="oetFTBbkBranch" value="<?= $oBbk[0]->FTBbkBranch; ?>">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="form-group"> 
                        <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tAccountNumber') ?></label>
                        <input class="form-control testmask" type="text" maxlength="15" name="oetFTBbkAccNo" id="oetFTBbkAccNo" value="<?= $oBbk[0]->FTBbkAccNo; ?>">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tAccountOpeningDate') ?></label>
                        <div class="input-group">
                        <input class="form-control" type="text" name="oetFDBbkOpen" id="oetFDBbkOpen" value="<?= date("Y-m-d (H:i:s)", strtotime($oBbk[0]->FDBbkOpen)); ?>">
                        <span class="input-group-btn">
                        <button id="obtFDBbkOpen" type="button" class="btn xCNBtnDateTime">
                        <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                        </button>
                        </span>
                        </div>
                        </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tRecentBalance') ?></label>
                        <input class="form-control" type="text" value="<?= number_format( $oBbk[0]->FCBbkBalance, 2, '.', '' ); ?>" name="oetFCBbkBalance" id="oetFCBbkBalance">
                        <span class="focus-input100"></span>
                    </div>
                    <div class="form-group">
                        
                        <label class="xCNLabelFrm"><?= language('ticket/bank/bank', 'tCategory') ?></label>
                    <div>
                    <div class="form-group">
                        <select class="selectpicker form-control" name="ocmFTBbkType" id="ocmFTBbkType">
                            <option value="1"<?php
                            if ($oBbk[0]->FTBbkType == '1') {
                                echo ' selected="selected"';
                            }
                            ?>><?= language('ticket/bank/bank', 'tSavingAccount') ?></option>
                            <option value="2"<?php
                            if ($oBbk[0]->FTBbkType == '2') {
                                echo ' selected="selected"';
                            }
                            ?>><?= language('ticket/bank/bank', 'tCurrentAccount') ?></option>
                            <option value="3"<?php
                                    if ($oBbk[0]->FTBbkType == '3') {
                                        echo ' selected="selected"';
                                    }
                            ?>><?= language('ticket/bank/bank', 'tRegularAccount') ?></option>
                        </select>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" style="overflow: hidden;">
                        <label class="pull-left" style="font-weight: normal;">
                            <input type="checkbox" <?php
                                if ($oBbk[0]->FTBbkStaActive == "1") {
                                    echo 'checked';
                                }
                            ?> value="1" style="float: left; margin-right: 5px;" name="ocbFTBbkStaActive"> <?= language('ticket/product/product', 'tOpening') ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <div class="wrap-input100">
                            <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tRemarks') ?></label>
                            <textarea class="form-control" name="otaFTBbkRmk" maxlength="200"><?= $oBbk[0]->FTBbkRmk; ?></textarea>
                            <span class="focus-input100"></span>
                        </div>
                        </div>
                        </div>			
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script>
        FSxDecimal("#oetFCBbkBalance", 2);
        $('.selectpicker').selectpicker();
        $('#obtFDBbkOpen').click(function(){
            event.preventDefault();
            $('#oetFDBbkOpen').datetimepicker('show');
        });
        $(document).ready(function () {
        $('.testmask').mask('000-000000-0');
        $(".xWEditBankInfo").validate({
        rules: {
            oetFTBbkName: "required",
            oetFTBbkBranch: "required",
            oetFTBbkAccNo: "required",
            oetFDBbkOpen: "required"
        },
        messages: {
            oetFTBbkName: "",
            oetFTBbkBranch: "",
            oetFTBbkAccNo: "",
            oetFDBbkOpen: ""
        },
        errorClass: "alert-validate",
        validClass: "",
        highlight: function (element, errorClass, validClass) {
            $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
            $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
            $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {
        $('button[type=submit]').attr('disabled', true);
        $('.xCNOverlay').show();
            $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>EticketBankInfoEditAjax",
                data: $(".xWEditBankInfo").serialize(),
            cache: false,
        success: function (msg) {
        var nDataId = $('.xWBtnSaveActive').data('id');
        if (nDataId == '1') {
        JSxCallPage('<?= base_url() ?>EticketBankInfoEdit/<?= $oBbk[0]->FTBbkCode ?>');
                                } else if (nDataId == '2') {
                                    JSxCallPage('<?= base_url() ?>EticketBankInfoAdd');
                                } else if (nDataId == '3') {
                                    JSxCallPage('<?php echo base_url('EticketBankInfo') ?>');
                                }
                            $('.xCNOverlay').hide();
                        },
                        error: function (data) {
                            console.log(data);
                            $('.xCNOverlay').hide();
                        }
                    });
                    return false;
                }
            });
            $('[title]').tooltip();
            $('#oetFDBbkOpen').datetimepicker({
                
                format: 'YYYY-MM-DD HH:mm',
                locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
            });
        });
</script>