<script>
    $(document).ready(function () {
        $('.selection-2').select2();
        $('.selectpicker').selectpicker();
        $("#ocmSelectFNPmoID option").filter(function () {
            return $(this).val() == $('#ohdGetParkId').val();
        }).attr('selected', true);
        $("#ocmSelectFNPmoID").multipleSelect({
            filter: true,
            width: '100%'
        });
        $("#oSelectGrpPdt").multipleSelect({
            isOpen: true,
            keepOpen: true,
            single: true,
            filter: true,
            width: '100%'
        });

        $(".xWAddLocation").validate({
            rules: {
                oetFTLocName: "required"
            },
            messages: {
                oetFTLocName: ""
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
                    url: "<?php echo base_url(); ?>EticketAddLocAjaxNew",
                    data: $(".xWAddLocation").serialize(),
                    cache: false,
                    success: function (msg) {
                        // alert(msg);
                        console.log(msg);
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?php echo base_url(); ?>EticketEditLocNew/' + msg + '/<?= $aLocModel[0]->FNPmoID ?>');
                        } else if (nDataId == '2') {
                            JSxCallPage('<?= base_url() ?>EticketAddLoc/<?= $aLocModel[0]->FNPmoID ?>');
                                                    } else if (nDataId == '3') {
                                        JSxCallPage('<?php echo base_url() ?>EticketLocation/<?= $aLocModel[0]->FNPmoID ?>');
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
                            $('#oetFTLocTimeOpening').datetimepicker({
                                format: 'HH:mm'
                            });
                            $('#oetFTLocTimeClosing').datetimepicker({
                                format: 'HH:mm'
                            });
                            $('#ocmFNAreID').on('change', function () {
                            //     $tID = this.value;
                            //     alert($tID);
                            //     JSxPRKProvince($tID);
                                setTimeout(function () {
                                    $('#ocmFNPvnID').selectpicker('refresh');
                                    $ocmFNPvnID = $('#ocmFNPvnID option:selected').val();
                                    JSxPRKDistrict($ocmFNPvnID);
                                }, 500);
                            });
                    $('#ocmFNPvnID').on('change', function () {
                        $tID = this.value;
                        JSxPRKDistrict($tID);
                        
                    });
                    $('[title]').tooltip();
                });

            // load Province
            var nFNAreID = $('#ocmFNAreID option:selected').val();
            JSxPRKProvince(nFNAreID);
            setTimeout(function () {
                $ocmFNPvnID = $('#ocmFNPvnID option:selected').val();
                JSxPRKDistrict($ocmFNPvnID);
            }, 500);
</script>

        <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWAddLocation">
            <div class="xCNMrgNavMenu">
                    <div class="row xCNavRow" style="width:inherit;">
                        <div class="xCNBchVMaster">
                            <div class="col-xs-8 col-md-8">
                                <ol id="oliMenuNav" class="breadcrumb">
                                    <li  id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketBranch') ?>')"><?= language('ticket/park/park', 'tBranchInformation') ?></li> 
                                    <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $aLocModel[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
                                    <li  id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/location/location', 'tAddLocation') ?></li>
                                    </ol>       
                                    </div>
                                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                                    <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= @$aLocModel[0]->FNPmoID ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
        <div class="main-content">
            <div class="panel panel-headline">
                    <div style="padding:20px;">
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">	
                                <div class="upload-img" id="oImgUpload" style="margin-bottom: 10px;">
                                    <img src="<?php echo base_url('application/modules/common/assets/images/200x200.png'); ?>" style="width: 100%;" id="oimImgMasterMain">				 
                                    <span class="btn-file">
                                        <input type="hidden" name="ohdLocImg" id="oetImgInputMain">
                                    </span>
                                </div>
                                <div class="xCNUplodeImage">
                                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '16/8')"><i class="fa fa-camera"></i> <?= language('ticket/park/park', 'tSelectPhoto') ?></button>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-4 col-xs-12">
                                <div class="form-group">
                                    <select id="ocmSelectFNPmoID" name="ocmSelectFNPmoID[]" multiple="multiple" title="<?= language('ticket/product/product', 'tSelectBranch') ?>" >
                                        <?php foreach ($aModel as $key => $value): ?>
                                            <option value="<?php echo $value->FNPmoID ?>"><?php echo $value->FTPmoName ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>	

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tNameLocation') ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTLocName" name="oetFTLocName">
                                </div>	

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tAmountLimit') ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFNLocLimit" name="oetFNLocLimit">
                                </div>

                                <div class="form-group" style="width: 49%; float: left;">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tOpeninghours') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetFTLocTimeOpening" name="oetFTLocTimeOpening" value="" maxlength="10">
                                        <span class="input-group-btn">
                                            <button id="obtBchFTLocTimeOpening" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 49%; float: right;">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tClosingTime') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetFTLocTimeClosing" name="oetFTLocTimeClosing" maxlength="10">
                                        <span class="input-group-btn">
                                            <button id="obtBchFTLocTimeClosing" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>	

                                <div class="row" style="margin-right: -15px; margin-left: -15px;">
                                    <div class="col-md-3 col-xs-6">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tSector') ?></label>
                                            <select class="selectpicker form-control" id="ocmFNAreID" name="ocmFNAreID">
                                                <?php foreach ($aArea AS $value): ?>
                                                <option value="<?= $value->FTAreCode ?>"<?php
                                                    if ($value->FTAreCode == '001') {
                                                        echo " selected";
                                                    }
                                                ?>><?= $value->FTAreName ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-6">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tProvince') ?></label>
                                            <div>
                                                <!-- <select class="selectpicker form-control" id="ocmFNPvnID" name="ocmFNPvnID" >
                                                </select> -->
                                                <select class="selectpicker form-control" id="ocmFNPvnID" name="ocmFNPvnID" >
                                                <?php foreach ($aProvince AS $value): ?>
                                                <option value="<?= $value->FTPvnCode ?>"<?php
                                                    if ($value->FTPvnCode == '10') {
                                                        echo " selected";
                                                    }?>><?= $value->FTPvnName ?></option>
                                                <?php endforeach ?>
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tDistrict') ?></label>
                                            <div>
                                                <select class="selectpicker form-control" id="ocmFNDstID" name="ocmFNDstID">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                        <button type="button"class="btn btn-default xCNBTNDefult" style="margin-top: 30px;" onclick="JSxPRKAddAre();" data-toggle="modal" data-target="#modal-area"><?= language('common/main/main', 'tAdd') ?></button>
                                    </div>
                                </div>
                                <table class="table table-hover" id="otbAre" style="margin-top: 15px;">
                                    <thead>
                                        <tr>
                                            <th class="xCNTextBold" style="text-align:center;"><?= language('ticket/location/location', 'tSector') ?></th>
                                            <th class="xCNTextBold" style="text-align:center;"><?= language('ticket/location/location', 'tProvince') ?></th>
                                            <th class="xCNTextBold" style="text-align:center;"><?= language('ticket/location/location', 'tDistrict') ?></th>
                                            <th class="xCNTextBold" style="text-align:center;"><?= language('ticket/location/location', 'tDelete') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="otr">
                                            <th colspan="4"><div style="text-align: center; padding: 20px;"><?= language('ticket/user/user', 'tDataNotFound') ?></div></th>
                                        </tr>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>			
                    </div>
            </div>	
        </div>			
        <input type="hidden" id="ohdGetParkId" value="<?= $tID ?>">
    </form>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    $('#obtBchFTLocTimeOpening').click(function(){
		event.preventDefault();
        $('#oetFTLocTimeOpening').datetimepicker('show');
    });

    $('#obtBchFTLocTimeClosing').click(function(){
		event.preventDefault();
        $('#oetFTLocTimeClosing').datetimepicker('show');
    });
    
</script>
