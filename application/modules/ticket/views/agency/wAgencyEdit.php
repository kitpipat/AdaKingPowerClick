<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/zone/jZoneNew.js"></script>
<script>
    $('.selectpicker').selectpicker();
    $('[title]').tooltip();
    $('#ocmAgnPvnID').on('change', function () {
        $nPvnID = this.value;
        JSxUsrDistrict($nPvnID);
    });

    nAgnStaApv = $('#ohdAgnStaApv').val();
    $('.xWStaApv' + nAgnStaApv).attr('selected', true);

    nAgnStaActive = $('#ohdAgnStaActive').val();
    $('.xWStaActive' + nAgnStaActive).attr('selected', true);
    $(function () {
        $("#ofmEditAgn").validate({
            rules: {
                "oetAgnName": "required",
                "ocmFTRcvCode[]": "required",
                "opwAgnPwd": "required",
                oetAgnEmail: {
                    required: true,
                    email: true
                }
            },
            messages: {},
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
                    url: "<?php echo base_url(); ?>EticketAgency_EditSave",
                    data: $("#ofmEditAgn").serialize(),
                    cache: false,
                    success: function (tResult) {
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?= base_url() ?>EticketAgency_Edit/<?= $nAgnID ?>');
                                                    } else if (nDataId == '2') {
                                                        JSxCallPage('<?= base_url() ?>EticketAgency_AddPage');
                                                    } else if (nDataId == '3') {
                                                        JSxCallPage('<?php echo base_url('EticketAgency') ?>');
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
                                });
        </script>
<div class="main-menu">
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmEditAgn">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('EticketAgency')"><?= language('ticket/agency/agency', 'tSalesAgentInfo'); ?></li> 
                            <li  class="xCNLinkClick"> <?= language('ticket/agency/agency', 'tEditSalesAgent'); ?></li>
                            </ol>       
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <div class="demo-button xCNBtngroup">
                            <button type="button" onclick="JSxCallPage('<?php echo base_url('EticketAgency') ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
<div class="main-content">
    <div class="panel panel-headline">
        <div class="panel-heading"> 
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="upload-img" id="oImgUpload">	
                                    <?php
                                        if(isset($oAgnEdit[0]->FTImgObj) && !empty($oAgnEdit[0]->FTImgObj)){
                                            $tFullPatch = './application/modules/'.$oAgnEdit[0]->FTImgObj;
                                            if (file_exists($tFullPatch)){
                                                $tPatchImg = base_url().'/application/modules/'.$oAgnEdit[0]->FTImgObj;
                                            }else{
                                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>
                                    <?php if(isset($oAgnEdit[0]->FTImgObj) && !empty($oAgnEdit[0]->FTImgObj)): ?>
                                        <a href="javascript:void(0)" id="oDelImgAgn" onclick="JSxAGNDelImg('<?php echo $oAgnEdit[0]->FTImgRefID; ?>', '<?php echo $oAgnEdit[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                    <?php endif; ?>
                                    <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain">	
                                <span class="btn-file"> 
                            <input type="hidden" name="ohdAgcImg" id="oetImgInputMain">
                        </span>
                    <div class="xCNUplodeImage">
                        <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '4/4')"><i class="fa fa-camera"></i> เลือกรูป</button>
                            </div></div></div><div class="col-md-8"><input type="hidden" name="ohdAgnID" id="ohdAgnID" value="<?=$oAgnEdit[0]->FTAgnCode ?>"/>
                                <div class="form-group">
                                    <div class="input100 validate-input" data-validate="<?= language('ticket/agency/agency', 'tPleaseEnterName'); ?>">
                                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tName'); ?></label>
                                            <input class="form-control" type="text" value="<?= $oAgnEdit[0]->FTAgnName ?>" name="oetAgnName" id="oetAgnName">
                                        <span class="focus-input100"></span>
                                    </div>
                                </div>
                            <div class="form-group">
                        <div class="input100 validate-input" id="oChkAgnEmail" data-validate="<?= language('ticket/agency/agency', 'tPleaseEnterEmail'); ?>">
                    <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tEmail'); ?></label>
                        <input class="form-control" type="email" name="oetAgnEmail" id="oetAgnEmail" value="<?= $oAgnEdit[0]->FTAgnEmail ?>" disabled="disabled">
                            <span class="focus-input100"></span>
                                </div>
                                    </div>
                                        <div class="form-group">
                                            <div class="input100 validate-input" data-validate="<?= language('ticket/agency/agency', 'tPleaseEnterPassword'); ?>">
                                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tPassword'); ?></label>
                                    <input class="form-control" type="password" name="opwAgnPwd" id="opwAgnPwd" value="!@#$%&*">
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tPhoneNumber'); ?></label>
                            <input class="form-control" type="number" value="<?= $oAgnEdit[0]->FTAgnTel ?>" name="oetAgnTel" id="oetAgnTel" maxlength="13">
                                <span class="focus-input100"></span>
                                    </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tFaxNumber'); ?></label>
                                        <input class="form-control" type="number" value="<?= $oAgnEdit[0]->FTAgnFax ?>" name="oetAgnFax" id="oetAgnFax" maxlength="13">
                                    <span class="focus-input100"></span>
                                </div>
                            <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tPhoneNumber'); ?></label>
                    <input class="form-control" type="number" name="oetAgnMo" value="<?= $oAgnEdit[0]->FTAgnMo ?>" id="oetAgnMo" maxlength="13">
                        <span class="focus-input100"></span>
                            </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                        <div class="form-group">
                                    <div class="input100 input100-select">
                                    <input type="text" class="form-control hidden" value="<?= $oAgnEdit[0]->FTAgnStaApv ?>" name="ohdAgnStaApv" id="ohdAgnStaApv" />
                                <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tAgnStaApv'); ?></label>
                            <div>
                        <select name="ocmAgnStaApv" id="ocmAgnStaApv" class="selectpicker form-control">
                    <option value=""><?= language('ticket/agency/agency', 'tAgnStaApv'); ?></option>
                        <option class="xWStaApv0" value="0"><?= language('ticket/agency/agency', 'tApv'); ?></option>
                            <option class="xWStaApv1" value="1"><?= language('ticket/agency/agency', 'tNotApv'); ?></option>
                                </select>
                                    </div>
                                        <span class="focus-input100"></span>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-6">
                            <div class="form-group">
                        <div class="input100 input100-select">
                    <label class="xCNLabelFrm"> <?= language('ticket/agency/agency', 'tAgnStaActive'); ?></label>
                        <div>
                            <input type="text" class="form-control hidden" value="<?= $oAgnEdit[0]->FTAgnStaActive ?>" name="ohdAgnStaActive" id="ohdAgnStaActive" />
                                <select name="ocmAgnStaActive" id="ocmAgnStaActive" class="selectpicker form-control">
                                    <option value="">
                                        <?= language('ticket/agency/agency', 'tAgnStaActive'); ?></option>
                                            <option class="xWStaActive1" value="1"><?= language('ticket/agency/agency', 'tContact'); ?></option>
                                        <option class="xWStaActive2" value="2"><?= language('ticket/agency/agency', 'tUnContact'); ?></option>
                                    </select>
                                </div>
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                        <div class="row">
                                    <div class="col-md-6">
                                <div class="form-group">
                            <div class="input100 input100-select validate-input" data-validate="กรุณาเลือกประเภท">
                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tSelectAgencyType'); ?></label>
                    <div>
                        <select name="ocmFTAtyCode" id="ocmFTAtyCode" class="selectpicker form-control">
                            <option value=""><?= language('ticket/agency/agency', 'tSelectAgencyType'); ?></option>
                                <?php foreach (@$oAgnTy AS $key => $oValue) : ?>
                                    <option value="<?= $oValue->FTAtyCode ?>"<?php
                                    if ($oValue->FTAtyCode == $oAgnEdit[0]->FTAtyCode) {
                                        echo ' selected="selected"';
                                    }
                                        ?>><?= $oValue->FTAtyName ?></option>
                                        <?php endforeach; ?>
                                        </select>
                                        </div>
                                        <span class="focus-input100"></span>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-md-6">
                        <div class="form-group">
                    <div class="input100 input100-select">
                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tSelectAgency'); ?></label>
                            <div>
                                <select name="ocmAgnAggID" id="ocmAgnAggID" class="selectpicker form-control">
                                    <option value=""><?= language('ticket/agency/agency', 'tSelectAgency'); ?></option>
                                        <?php foreach (@$oAgnGroup AS $key => $oValue) : ?>
                                        <option value="<?= $oValue->FTAggCode ?>"<?php
                                        if ($oValue->FTAggCode == $oAgnEdit[0]->FTAggCode) {
                                        echo ' selected="selected"';
                                        }
                                        ?>><?= $oValue->FTAggName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <span class="focus-input100"></span>
                        </div>
                    </div>
                        </div>
                            </div>
                                </div>
                                    </div>
                                        <div class="form-group">
                                            <div class="input100 validate-input" data-validate="<?= language('ticket/agency/agency', 'tPleaseSelectPaymentMethod'); ?>">
                                        <label class="xCNLabelFrm"><?= language('ticket/agency/agency', 'tSelectPayment'); ?></label>
                                    <select name="ocmFTRcvCode[]" multiple="multiple"  class="selectpicker form-control">
                                <option value=""><?= language('ticket/agency/agency', 'tSelectPayment'); ?></option>
                            <?php
                                function CheckRcv($sKey, $value, $aAgencyRcv) {
                                foreach ($aAgencyRcv as $key => $val) {
                                if ($val->FTRcvCode == $value) {
                                    return TRUE;
                                    }
                                }
                                    return false;
                                    }
                                ?>		
                                <?php
                                foreach (@$oRCV AS $key => $oValue) {
                                $tRcvCode = $oValue->FTRcvCode;
                                ?>								
                                <?php
                                $bAgcSelect = CheckRcv('FTRcvCode', $tRcvCode, $oAgencyRcv);
                                if ($bAgcSelect == true) {
                                ?>
                                    <option value="<?= $oValue->FTRcvCode ?>" selected="selected"><?= $oValue->FTRcvName ?></option>
                                <?php } else { ?>	
                                    <option value="<?= $oValue->FTRcvCode ?>"><?= $oValue->FTRcvName ?></option>
                                <?php } ?>
                                    <?php } ?>
                                </select>
                         <span class="focus-input100"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div> 
        </div> 
            </div>  
                </form>    
                    </div> 
