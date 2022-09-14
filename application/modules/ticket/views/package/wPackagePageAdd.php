<!-- แก้ไขแพ็คเกจ  -->
    <form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackage" >
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>/EticketPackage')"><?= language('ticket/package/package', 'tPkg_Package') ?></li>
                            <li><?= language('ticket/package/package', 'tPkg_AddPackage') ?></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>/EticketPackage')" id="btnPdtSelectClose" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                        <div class="btn-group">
                            <button class="btn btn-default xWBtnGrpSaveLeft" type="submit" onclick="JSxBtnAddPkgSave();"><?= language('ticket/user/user', 'tSave') ?></button>
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

        <div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
            &nbsp;
        </div>

        <div class="main-content">
            <div class="panel panel-headline">
                <div class="panel-heading">			
                    <div class="nav-tab-pills-image" style="margin-right: 15px; margin-left: 15px;">
                        <!--หัว Tab1 -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item  active">
                                <a class="nav-link flat-buttons active" data-toggle="tab" href="#oPackageTab1" role="tab" aria-expanded="false">
                                    <?= language('ticket/package/package', 'tPkg_Package') ?> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link flat-buttons" data-toggle="tab" href="#oPackageTab2" role="tab" aria-expanded="false">
                                    <?= language('ticket/package/package', 'tPkg_PackageDesc') ?>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <!--Body Tab 1 -->
                            <div class="tab-pane active" style="margin-top:10px;" id="oPackageTab1" role="tabpanel" aria-expanded="true" >
                                <div class="row" style="margin-right: -30px; margin-left: -30px;">
                                    <!-- รูป -->
                                    <div class="col-md-4 col-xs-12">
                                        <div class="row">
                                            <div class="upload-img" id="oImgUpload">
                                                <img src="<?php echo base_url('application/modules/common/assets/images/Noimage.png'); ?>" style="width: 100%;" id="oimImgMasterMain">
                                                <span class="btn-file">
                                                    <input type="hidden" name="ohdPkgImg" id="oetImgInputMain">
                                                </span>
                                            </div>
                                            <div class="xCNUplodeImage">
                                                <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '4/5')"><i class="fa fa-camera"></i> เลือกรูป</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- รูป -->
                                    <div class="col-md-8 col-xs-12">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่<?= language('ticket/package/package', 'tPkg_Name') ?>"><?= language('ticket/package/package', 'tPkg_Name') ?></label>
                                                    <input type="text" class="form-control" id="oetAddPkgName" name="oetAddPkgName">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 col-xs-5">	
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaLimitType') ?></label>
                                                    <select class="selectpicker form-control" name="oetAddPkgStaLimitType" id="oetAddPkgStaLimitType" aria-invalid="false">
                                                        <optgroup label="<?= language('ticket/package/package', 'tPkg_StaLimitType') ?>">
                                                            <option class="xWStalimit1" value="1" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeDay') ?></option>
                                                            <option class="xWStalimit2" value="2" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeMonth') ?></option>
                                                            <option class="xWStalimit3" value="3" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeYear') ?></option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-xs-3">	 
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaLimitBy') ?></label>
                                                    <select class="selectpicker form-control" name="oetAddPkgStaLimitBy" id="oetAddPkgStaLimitBy" aria-invalid="false">
                                                        <optgroup label="<?= language('ticket/package/package', 'tPkg_StaLimitBy') ?>">
                                                            <option class="xWStaLimitBy1" value="1" ><?= language('ticket/package/package', 'tPkg_StaLimitByZome') ?></option>
                                                            <option class="xWStaLimitBy2" value="2" ><?= language('ticket/package/package', 'tPkg_StaLimitByPkg') ?></option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-xs-4"> 
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่<?= language('ticket/package/package', 'tPkg_Name') ?>"><?= language('ticket/package/package', 'tPkg_LimitQty') ?></label>
                                                    <input type="text" class="form-control" id="oetAddPkgLimitQty" name="oetAddPkgLimitQty" value="0" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">     
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectEvent') ?></label>
                                                    <select class="selectpicker form-control" name="oetAddPkgEvn" id="oetAddPkgEvn" aria-invalid="false" data-toggle="tooltip" title="<?= language('ticket/package/package', 'tPkg_SelectEvent') ?>">
                                                        <option class="xWEvn1" value="" ><?= language('ticket/package/package', 'tPkg_SelectEvent') ?></option>	
                                                        <?php if ($oEvnList[0]->FNEvnID != ''): ?>
                                                            <?php foreach ($oEvnList AS $aValue): ?>
                                                                <option class="xWEvn1" value="<?= $aValue->FNEvnID ?>"><?= $aValue->FTEvnName ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif ?>	
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="form-group col-md-6 col-xs-6">
                                            <div class="form-group">
                                                <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaActive') ?></label>
                                                    <select class="selectpicker form-control" name="ocmAddPkgStaActive" id="ocmAddPkgStaActive" aria-invalid="false">
                                                        <option class="xWStaActive1" value="1"><?= language('ticket/package/package', 'tPkg_ActiveFromDateOfSale') ?></option>
                                                        <option class="xWStaActive2" value="2"><?= language('ticket/package/package', 'tPkg_ActiveFromDateSpecified') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">	
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StartSale') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetAddPkgStartSale" name="oetAddPkgStartSale" value="">
                                                            <span class="input-group-btn">
                                                                <button id="obtAddPkgStartSale" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StopSale') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetAddPkgStopSale" name="oetAddPkgStopSale" value="">
                                                        <span class="input-group-btn">
                                                            <button id="obtAddPkgStopSale" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StartChkIn') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetAddPkgStartChkIn" name="oetAddPkgStartChkIn">
                                                        <span class="input-group-btn">
                                                            <button id="obtAddPkgStartChkIn" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-xs-6 ">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StopChkIn') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetAddPkgStopChkIn" name="oetAddPkgStopChkIn">
                                                        <span class="input-group-btn">
                                                            <button id="obtAddPkgStopChkIn" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_TchGroup') ?></label>
                                                    <select class="selectpicker form-control" name="oetAddPkgTchGroup" id="oetAddPkgTchGroup"  title="<?= language('ticket/package/package', 'tPkg_SelectEvent') ?>">
                                                        <option value=""><?= language('ticket/package/package', 'tPkg_TchGroup') ?></option>
                                                        <?php if ($oTchGroupList[0]->FNTcgID != ''): ?>
                                                            <?php foreach ($oTchGroupList AS $aValue): ?>
                                                                <?php if ($aValue->FNTcgID == $oPckEdit[0]->FNTcgID): ?>
                                                                    <option value="<?= $aValue->FNTcgID ?>" selected="selected"><?= $aValue->FTTcgName ?> (<?= $aValue->FTPmoName ?>)</option>
                                                                <?php else: ?>
                                                                    <option value="<?= $aValue->FNTcgID ?>"><?= $aValue->FTTcgName ?> 
                                                                        (<?php
                                                                        if ($aValue->FTPmoName != '') {
                                                                            echo $aValue->FTPmoName;
                                                                        } else {
                                                                            echo language('ticket/package/package', 'tPkg_TchPublic');
                                                                        }
                                                                        ?>)</option>
                                                                <?php endif ?>
                                                            <?php endforeach; ?>
                                                        <?php endif ?>
                                                    </select>
                                                </div>
                                            </div>                                          
                                            <div class="col-md-6 col-xs-6">	 
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_PkgType') ?></label>
                                                    <select class="selectpicker form-control" name="ocmAddPkgType" id="ocmAddPkgType" aria-invalid="false">
                                                        <option class="xWPickTypePrice1" value="1"><?= language('ticket/package/package', 'tPkg_UsrPriceByPdt') ?></option>
                                                        <option class="xWPickTypePrice2" value="2"><?= language('ticket/package/package', 'tPkg_UsrPriceByPkg') ?></option>
                                                    </select>
                                                </div>
                                            </div>                                          
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่<?= language('ticket/package/package', 'tPkg_MaxPark') ?>"><?= language('ticket/package/package', 'tPkg_MaxPark') ?></label>
                                                    <input class="form-control" type="number" min="0" max="1" id="oetAddPkgMaxPark" name="oetAddPkgMaxPark">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxChkIn') ?></label>
                                                    <input class="form-control" type="number" min="0" max="1" id="oetAddPkgMaxChkIn" name="oetAddPkgMaxChkIn">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row xWMaxMinGrp">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MinGrpQty') ?></label>
                                                    <input class="form-control" type="number" min="0" id="oetAddPkgMinGrpQty" name="oetAddPkgMinGrpQty">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxGrpQty') ?></label>
                                                    <input class="form-control" type="number" min="0" name="oetAddPkgMaxGrpQty" id="oetAddPkgMaxGrpQty">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row xWMaxMinGrpQtyByBill">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MinQtyByBill') ?></label>
                                                    <input class="form-control" type="number" min="0" name="oetFNPkgMinQtyByBill" id="oetFNPkgMinQtyByBill" disabled="disabled">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxQtyByBill') ?></label>
                                                    <input class="form-control" type="number" min="0" name="oetFNPkgMaxQtyByBill" id="oetFNPkgMaxQtyByBill">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col-md-6 col-xs-6" style="margin-bottom: 3px;">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaActive') ?></label>
                                                    <select class="selectpicker form-control" name="ocmAddPkgStaActive" id="ocmAddPkgStaActive" aria-invalid="false">
                                                        <option class="xWStaActive1" value="1"><?= language('ticket/package/package', 'tPkg_ActiveFromDateOfSale') ?></option>
                                                        <option class="xWStaActive2" value="2"><?= language('ticket/package/package', 'tPkg_ActiveFromDateSpecified') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                           <div class="form-group col-md-6 col-xs-6" style="margin-bottom: 3px;">
                                                <input type="checkbox" name="oetAddPkgStaFreeGuide" id="oetAddPkgStaFreeGuide" style="height: 20px;width: 20px;float:left;margin-top: 2px;margin-right: 5px;" > <?= language('ticket/package/package', 'tPkg_StaFreeGuide') ?>
                                            </div> 
                                        </div> -->
                                    </div>  
                                </div> 
                            </div>

                            <!--Tab2 -->
                            <div class="tab-pane" id="oPackageTab2" role="tabpanel" aria-expanded="true" style="margin-top:10px;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc1') ?></label>
                                            <input class="form-control" type="text" min="0" name="oetAddPkgDesc1" id="oetAddPkgDesc1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc2') ?></label>
                                            <input class="form-control" type="text" name="oetAddPkgDesc2" id="oetAddPkgDesc2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc3') ?></label>
                                            <input class="form-control" type="text" name="oetAddPkgDesc3" id="oetAddPkgDesc3">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc4') ?></label>
                                            <input class="form-control" type="text" name="oetAddPkgDesc4" id="oetAddPkgDesc4">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc5') ?></label>
                                            <input class="form-control" type="text" name="oetAddPkgDesc5" id="oetAddPkgDesc5">
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
    
<script>

    $('.selectpicker').selectpicker();

    $('.xCNDatepicker').datetimepicker({
        format: 'DD-MM-YYYY HH:mm',
        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
    });

    $(document).ready(function () {
        $('.js-example-basic-single').select2();

        $('#ocbAddPkgEvn').change(function () {
            if ($(this).is(":checked")) {
                aler('Check');
            } else {
                aler('Not Check');
            }

        });

        //Btn Datetime Click
        $('#obtAddPkgStartSale').click(function(){
            event.preventDefault();
            $('#oetAddPkgStartSale').datetimepicker('show');
        });

        $('#obtAddPkgStopSale').click(function(){
            event.preventDefault();
            $('#oetAddPkgStopSale').datetimepicker('show');
        });

        $('#obtAddPkgStartChkIn').click(function(){
            event.preventDefault();
            $('#oetAddPkgStartChkIn').datetimepicker('show');
        });

        $('#obtAddPkgStopChkIn').click(function(){
            event.preventDefault();
            $('#oetAddPkgStopChkIn').datetimepicker('show');
        });
        //Btn Datetime Click
        
    });

    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });


    function FSxEncodeBase64PkgAdd() {

        var filesSelected = document.getElementById("oflAddPkgImg").files;
        if (filesSelected.length > 0) {
            var fileToLoad = filesSelected[0];
            var fileReader = new FileReader();
            fileReader.onload = function (fileLoadedEvent) {
                var tContents = document.getElementById("ohdAddPkgImg");
                tContents.value = fileLoadedEvent.target.result;
                var tImages = document.getElementById("oimPkgImgShow");
                tImages.setAttribute('src', fileLoadedEvent.target.result);
            };
            fileReader.readAsDataURL(fileToLoad);
        }
    }



    $('#oetAddPkgStaLimitType').on('change', function () {

        if (this.value == '1') {
            $('.xWStaLimitBy1').attr('disabled', false);
            $('.xWPickTypePrice1').attr('disabled', false);

            nStaLimitBy = $('#oetAddPkgStaLimitBy').val();
            if (nStaLimitBy == '1') {
                $('.xWPickTypePrice1').attr('disabled', false);
                $('.xWPickTypePrice1').attr('selected', true);
                $('.xWPickTypePrice1').prop('selected', true);

                $('.xWPickTypePrice2').attr('selected', false);
                $('.xWPickTypePrice2').attr('disabled', true);
            } else if (nStaLimitBy == '2') {
                $('.xWPickTypePrice2').attr('selected', true);
                $('.xWPickTypePrice2').attr('disabled', false);

                $('.xWPickTypePrice1').attr('selected', false);
                $('.xWPickTypePrice1').attr('disabled', true);
            }
            $('.xWPickTypePrice1').attr('disabled', false);
        } else {
            $('.xWStaLimitBy2').attr('selected', true);
            $('.xWStaLimitBy2').prop('selected', true);
            $('.xWStaLimitBy1').attr('disabled', true);
            $('#oetAddPkgLimitQty').attr('disabled', false);


            $('.xWPickTypePrice2').attr('selected', true);
            $('.xWPickTypePrice2').prop('selected', true);
            $('.xWPickTypePrice1').attr('disabled', true);


            nStaLimitBy = $('#oetAddPkgStaLimitBy').val();
            if (nStaLimitBy == '1') {
                $('.xWPickTypePrice1').attr('disabled', false);
                $('.xWPickTypePrice1').attr('selected', true);
                $('.xWPickTypePrice1').prop('selected', true);

                $('.xWPickTypePrice2').attr('selected', false);
                $('.xWPickTypePrice2').attr('disabled', true);
            } else if (nStaLimitBy == '2') {
                $('.xWPickTypePrice2').attr('selected', true);
                $('.xWPickTypePrice2').attr('disabled', false);

                $('.xWPickTypePrice1').attr('selected', false);
                $('.xWPickTypePrice1').attr('disabled', true);
            }

            $('#oetFNPkgMinQtyByBill').attr('disabled', false);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
            $('.xWMaxMinGrpQtyByBill').show();
        }
    });

    $('#oetAddPkgStaLimitBy').on('change', function () {

        if (this.value == '1') {
            $('#oetAddPkgLimitQty').val('0');
            $('#oetAddPkgLimitQty').attr('disabled', true);

            $('.xWPickTypePrice1').attr('disabled', false);
            $('.xWPickTypePrice1').attr('selected', true);
            $('.xWPickTypePrice1').prop('selected', true);
// 	        $('.xWPickTypePrice2').attr('selected', false);
// 	        $('.xWPickTypePrice2').attr('disabled', true);

            $('#oetFNPkgMinQtyByBill').attr('disabled', true);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
            $('.xWMaxMinGrpQtyByBill').hide();
            $('#oetFNPkgMinQtyByBill').val('');
            $('#oetFNPkgMaxQtyByBill').val('');
        } else {
            $('#oetAddPkgLimitQty').attr('disabled', false);

            $('.xWPickTypePrice2').attr('selected', true);
            $('.xWPickTypePrice2').attr('disabled', false);
            $('.xWPickTypePrice2').prop('selected', true);

            $('.xWPickTypePrice1').attr('selected', false);
            $('.xWPickTypePrice1').attr('disabled', true);

            $('#oetFNPkgMinQtyByBill').attr('disabled', false);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
            $('.xWMaxMinGrpQtyByBill').show();
        }

    });


    $(function () {
        $('#ocmAddPkgType').on('change', function () {
            if (this.value == '2') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', false);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
                $('.xWMaxMinGrpQtyByBill').show();

            } else if (this.value == '1') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', true);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
                $('#oetFNPkgMinQtyByBill').val('');
                $('#oetFNPkgMaxQtyByBill').val('');
                $('.xWMaxMinGrpQtyByBill').hide();
            }
            if ($('#ocmEditPkgType').value == '2') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', false);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
                $('.xWMaxMinGrpQtyByBill').show();

            } else if ($('#ocmAddPkgType').value == '1') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', true);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
                $('#oetFNPkgMinQtyByBill').val('');
                $('#oetFNPkgMaxQtyByBill').val('');
                $('.xWMaxMinGrpQtyByBill').hide();
            }
        });
        $('[title]').tooltip();
    });
</script>

