<script>
    // $(function () {
        $(document).ready(function () {
       $('.selectpicker').selectpicker();
        $(".xWEditLocation").validate({
            rules: {
                oetFTLocNameEdit: "required"
            },
            messages: {
                oetFTLocNameEdit: ""
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
                    url: "<?php echo base_url(); ?>EticketEditLocAjax",
                    data: $(".xWEditLocation").serialize(),
                    cache: false,
                    success: function (msg) {
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?php echo base_url(); ?>EticketEditLocNew/<?= $oEdit[0]->FNLocID ?>/<?= $aLocModel[0]->FNPmoID ?>');
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
                                        $('#ocmFNDstID').on('change', function () {
                                            $('#ocmFNDstID').selectpicker('refresh');
                                            $tID = this.value;
                                            JSxPRKProvince($tID);
                                            setTimeout(function () {
                                                $ocmFNPvnID = $('#ocmFNPvnID option:selected').val();
                                                JSxPRKDistrict($ocmFNPvnID);
                                            }, 500);
                                        });
                                        $('#ocmFNPvnID').on('change', function () {
                                            $('#ocmFNPvnID').selectpicker('refresh');
                                            $tID = this.value;
                                            JSxPRKDistrict($tID);
                                        });
                                        $('#oetFTLocTimeEditOpening').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('#oetFTLocTimeEditClosing').datetimepicker({
                                            format: 'HH:mm'
                                        });
                                        $('[title]').tooltip();
                                        // $('.selection-2').select2();
                                        // load Province
                                        var nFNAreID = $('#ocmFNAreID option:selected').val();
                                        JSxPRKProvince(nFNAreID);
                                        setTimeout(function () {
                                            $ocmFNPvnID = $('#ocmFNPvnID option:selected').val();
                                            JSxPRKDistrict($ocmFNPvnID);
                                        }, 500);
                                    });
</script>
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" class="xWEditLocation">
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow" style="width:inherit;">
                    <div class="xCNBchVMaster">
                        <div class="col-xs-8 col-md-8">
                            <ol id="oliMenuNav" class="breadcrumb">
                                <li  id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url('EticketBranch') ?>')"><?= language('ticket/park/park', 'tBranchInformation') ?></li> 
                                <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= @$nPrk ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
                                <li  id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/location/location', 'tEditLocation') ?></li>
                                </ol>       
                                </div>
                                <div class="col-xs-12 col-md-4 text-right p-r-0">
                                <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= @$nPrk ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
                                    <?php
                                        if(isset($oEdit[0]->FTImgObj) && !empty($oEdit[0]->FTImgObj)){
                                            $tFullPatch = './application/modules/'.$oEdit[0]->FTImgObj;
                                            if (file_exists($tFullPatch)){
                                                $tPatchImg = base_url().'/application/modules/'.$oEdit[0]->FTImgObj;
                                            }else{
                                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>

                                    <?php if(isset($oEdit[0]->FTImgObj) && !empty($oEdit[0]->FTImgObj)): ?>
                                        <a href="javascript:void(0)" id="oDelImgLoc" onclick="JSxLOCDelImg('<?php echo $oEdit[0]->FNLocID; ?>', '<?php echo $oEdit[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                    <?php endif; ?>

                                    <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain">	
                                    <span class="btn-file"> 
                                        <input type="hidden" name="ohdLocImg" id="oetImgInputMain">
                                    </span>
                                </div>
                                <div class="xCNUplodeImage">
                                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '16/8')"><i class="fa fa-camera"></i> <?= language('ticket/park/park', 'tSelectPhoto') ?></button>
                                </div>				
                            </div>
                            <div class="col-md-8 col-sm-4 col-xs-12">
                                <input type="hidden" name="ohdEditLocID" id="ohdEditLocID" value="<?= $oEdit[0]->FNLocID ?>">				
                                <input type="hidden" name="ohdFNPmoID" id="ohdFNPmoID" value="<?= @$aLocModel[0]->FNPmoID ?>">	

                                <div class="form-group" data-validate="<?= language('ticket/location/location', 'tPleaseEnterALocation') ?>">
                                    <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tNameLocation') ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTLocNameEdit" name="oetFTLocNameEdit" value="<?= $oEdit[0]->FTLocName ?>">
                                </div>

                                <div class="form-group" data-validate="<?= language('ticket/location/location', 'tPleaseEnterALocation') ?>">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tAmountLimit') ?></label>
                                    <input type="number" class="form-control xCNInputWithoutSingleQuote" min="0" id="oetFNLocEditLimit" name="oetFNLocEditLimit" value="<?= $oEdit[0]->FNLocLimit ?>">
                                </div>

                                <div class="form-group" style="width: 49%; float: left;">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tOpeninghours') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker" id="oetFTLocTimeEditOpening" name="oetFTLocTimeEditOpening" maxlength="10" value="<?= $oEdit[0]->FTLocTimeOpening ?>">
                                        <span class="input-group-btn"> 
                                            <button id="obtBchFTLocTimeEditOpening" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group" style="width: 49%; float: right;">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tClosingTime') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNDatePicker" id="oetFTLocTimeEditClosing" name="oetFTLocTimeEditClosing" maxlength="10" value="<?= $oEdit[0]->FTLocTimeClosing ?>">
                                        <span class="input-group-btn">
                                            <button id="obtBchFTLocTimeEditClosing" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <div style="clear: both;"></div>    
                                <div class="row" style="margin-left: -15px; margin-right: -15px;">
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
                                                </select>
                                                 -->
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
                                                <select class="selectpicker form-control" id="ocmFNDstID" name="ocmFNDstID" >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                        <button type="button"class="btn btn-default xCNBTNDefult" style="margin-top: 15px;" onclick="JSxPRKAddAre();" data-toggle="modal" data-target="#modal-area"><?= language('common/main/main', 'tAdd') ?></button>
                                    </div>
                                </div>
                                <table class="table table-hover" id="otbAre" style="margin-top: 15px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?= language('ticket/location/location', 'tSector') ?></th>
                                            <th class="text-center"><?= language('ticket/location/location', 'tProvince') ?></th>
                                            <th class="text-center"><?= language('ticket/location/location', 'tDistrict') ?></th>
                                            <th class="text-center"><?= language('ticket/zone/zone', 'tDelete') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($oAreas[0]->FNLpvID) && !empty($oAreas[0]->FNLpvID)){ ?>
                                            <?php foreach (@$oAreas as $aValue){ ?>
                                                <tr id="otr<?= $aValue->FNLpvID ?>">
                                                    <td><?= $aValue->FTAreName ?></td>
                                                    <td><?= $aValue->FTPvnName ?></td>
                                                    <td><?= $aValue->FTDstName ?></td>
                                                    <td style="text-align: center;">
                                                        <img class="xCNIconTable" src="<?= base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxLOCDelAre('<?= $aValue->FNLpvID ?>', '<?= language('ticket/center/center', 'Confirm') ?>');">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php } else { ?>
                                                <tr id="otr">
                                                    <th colspan="4"><div style="text-align: center; padding: 20px;"><?= language('ticket/user/user', 'tDataNotFound') ?></div></th>
                                                </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>					
                    </div>					
                </div>
            </div>
        <input type="hidden" id="ohdGetParkId" value="<?= $nPrk ?>">
    </form>

    <script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
    <script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">
    $('#obtBchFTLocTimeEditOpening').click(function(){
		event.preventDefault();
        $('#oetFTLocTimeEditOpening').datetimepicker('show');
    });

    $('#obtBchFTLocTimeEditClosing').click(function(){
		event.preventDefault();
        $('#oetFTLocTimeEditClosing').datetimepicker('show');
    });
    
</script>