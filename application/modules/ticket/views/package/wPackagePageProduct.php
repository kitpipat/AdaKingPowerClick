<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc ?>">
<div class="row xWPKGSearchPanal">
    <div class="col-lg-12" style="margin: 10px 0 10px;">
        <form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackageProduct" >
                <input type="text" class="hidden" name="oetHidePkgID" id="oetHidePkgID" value="<?= $nPkgID ?>">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SearchTchGroup') ?></label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectPark') ?></label>
                        <select class="selectpicker form-control" name="ocmPkgPmo" id="ocmPkgPmo" aria-invalid="false">
                            <option value=""><?= language('ticket/package/package', 'tAllBranch') ?></option>
                            <?php if (isset($oPkgModelForCustomer[0]->FNPmoID)): ?>
                                <?php foreach ($oPkgModelForCustomer AS $aValue): ?>
                                    <option value="<?= $aValue->FNPmoID ?>" data-name="<?= $aValue->FTBchName ?>"><?= $aValue->FTBchName ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_TchGroup') ?></label>
                        <select class="selectpicker form-control" name="ocmPkgTchGroup" id="ocmPkgTchGroup" aria-invalid="false">
                            <option value=""><?= language('ticket/package/package', 'tPkg_TchGroup') ?></option>
                            <?php if (isset($oTchGroupList[0]->FNTcgID)): ?>
                                <?php foreach ($oTchGroupList AS $aValue): ?>
                                    <option value="<?= $aValue->FNTcgID ?>" data-name="<?= $aValue->FTTcgName ?>"><?= $aValue->FTTcgName ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'Select Product') ?></label>
                        <select class="selectpicker form-control" name="ocmPkgProduct" id="ocmPkgProduct" aria-invalid="false">
                            <option  value=""><?= language('ticket/package/package', 'tPkg_SelectPdt') ?></option>
                        </select>
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw xWLoading" style="position: absolute;font-size:20px;margin-left:40%;margin-top: -27px;display:none;"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Price') ?></label>
                        <input class="form-control" type="number" min="0" name="oetPkgPdtPrice" id="oetPkgPdtPrice">
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Amount') ?></label>
                        <?php if ($oPkgDetail[0]->FTPkgType == '1'): ?>
                            <input type="number" class="form-control" min="0" class="input100" name="oetPdtMaxPerson" id="oetPdtMaxPerson" value="1" disabled>
                        <?php else: ?>
                            <input type="number" class="form-control" min="0" class="input100" name="oetPdtMaxPerson" id="oetPdtMaxPerson">
                        <?php endif; ?>	
                    </div>
                </div>
                <div class="col-md-1 text-right"style="padding-left: 0;">
                    <button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxBtnAddPkgModelProduct()" style="margin-top:25px;">+</button>
                </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 xWpage-body">
        <div class="col-md-12 col-xs-12">
            <div style="margin-top:10px;">
                <div class="xCNPdtPanal" id="odvPkgProductPanal" style="overflow-x:hidden; overflow-y:auto; border-color: rgb(238, 238, 238); border-width: 2px;min-height:150px;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?= language('ticket/package/package', 'tPkg_TblNo') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_TblName') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_TblAmount') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_TblPrice') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_TblPdtType') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_TblPdtStatus') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_SpacialPrice') ?></th>
                                <th><?= language('ticket/package/package', 'tPkg_PriceByGroup') ?></th>
                                <?php if ($oPkgDetail[0]->FTPkgType == '1'): ?>
<!--                                        <th><?= language('ticket/user/user', 'tDelete') ?></th>
                                        <th><?= language('ticket/user/user', 'tEdit') ?></th>-->
                                <?php endif; ?>
                                <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                    <th class="text-center"><?= language('ticket/user/user', 'tDelete') ?></th>
                                    <th class="text-center"><?= language('ticket/user/user', 'tEdit') ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>	
                        <input type="text" id="ohdPkgType" class="hide" value="<?= $oPkgDetail[0]->FTPkgType ?>">
                        <?php if (isset($oPkgProductList[0]->FNPkgID)): ?>
                            <?php foreach ($oPkgProductList AS $aValue): ?>	
                            					
                                <tr onclick="JSxPkgEditClickTR('<?= $aValue->RowID ?>');">
                                    <td class="xWRmLine"><?= $aValue->RowID ?></td>
                                    <td class="xWRmLine"><?= $aValue->FTPdtName ?><input type="hidden" class="xWInputFNPdtOthSystem" value="<?= $aValue->FNPdtOthSystem; ?>"></td>
                                    <td class="xWRmLine">
                                        <span class="xWPdtMaxPerson" id="ospPdtMaxPerson<?= $aValue->RowID ?>"><?= $aValue->FNPdtMaxPerson ?></span>
                                        <input type="text" class="form-control xWoet" id="oetEditPdtMaxPerson<?= $aValue->RowID ?>" style="display:none;width: 50px;text-align:right" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?= $aValue->FNPdtMaxPerson ?>" disabled>
                                    </td>														  
                                    <td class="xWRmLine">										
                                        <span class="xWPdtPdtPrice" id="ospPdtPdtPrice<?= $aValue->RowID ?>"><?= $aValue->FCPdtPrice ?></span>										
                                        <input type="text" class="form-control xWoet" id="oetEditPdtPdtPrice<?= $aValue->RowID ?>" style="display:none;width: 100px;text-align:right" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?= $aValue->FCPdtPrice ?>" disabled>									
                                    </td>
                                    <td class="xWRmLine"><?= language('ticket/package/package', 'tPkg_PackagePdtSpecific' . $aValue->FNPmoID) ?></td>
                                    <td class="xWRmLine"><?= language('ticket/package/package', 'tPkg_PackagePdtOthSystem' . $aValue->FNPdtOthSystem) ?></td>									
                                    <?php if ($oPkgDetail[0]->FTPkgType == '1'): ?>
                                        <td class="xWRmLine">
                                            <div>
                                                <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgCallPagePdtPriSpcPri('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->FTPdtName ?>');"> 
                                                <label style="cursor:pointer;font-weight:normal;" onclick="JSxPkgCallPagePdtPriSpcPri('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->FTPdtName ?>');"><?= language('ticket/package/package', 'tPkg_SpacialPrice') ?></label>
                                            </div>
                                        </td>
                                        <td class="xWRmLine">
                                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgCallPagePdtGrpPri('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->FTPdtName ?>');"> 
                                            <label style="cursor:pointer;font-weight:normal;" onclick="JSxPkgCallPagePdtGrpPri('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->FTPdtName ?>');"><?= language('ticket/package/package', 'tPkg_PriceByGroup') ?></label>
                                        </td>
                                    <?php endif; ?>									
                                    <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?> 
                                        <td class="xWRmLine text-center">
                                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPkgDelPkgProduct('<?= $aValue->FNPkgPdtID ?>')">
                                        </td>										
                                        <td class="xWRmLine xWEditBtn text-center" id="othEditPdtBtn<?= $aValue->FNPkgPdtID ?>">
                                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgEditPdtBtn('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->RowID ?>')">
                                        </td>
                                        <td class="xWRmLine xWSaveBtn text-center" id="othSavePdtBtn<?= $aValue->FNPkgPdtID ?>" style="display:none;">
                                            <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/save.png" onclick="JSxPkgEditPkgProduct('<?= $aValue->FNPkgPdtID ?>', '<?= $aValue->RowID ?>')">
                                        </td>
                                    <?php endif; ?>									
                                </tr>

                            <?php endforeach; ?>
                        <?php else : ?>
                                <tr>
                                    <td colspan="10" style="text-align:center;"><?= language('ticket/package/package', 'tPkg_DontHavePdt') ?></td>
                                </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.selectpicker').selectpicker();

    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });

    nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();
    if (nStaPrcDoc != '') {
        nHeight = $(window).height() - 547;
        $('#odvPkgProductPanal').css('height', nHeight)
        $('.xWPKGSearchPanal').css('display', 'none');
    } else {
        nHeight = $(window).height() - 690;
        $('#odvPkgProductPanal').css('height', nHeight);
        $('.xWPKGSearchPanal').css('display', 'block');
    }
    $('#ocmPkgTchGroup').change(function () {
        nPkgID = $('#oetHidePkgID').val();
        nTchID = this.value;
        JSxPkgCstGetSelectPdtHTML(nTchID, nPkgID);
    });
    $('#ocmPkgPmo').change(function () {
        nPkgID = $('#oetHidePkgID').val();
        nPmoID = this.value;
        JSxPkgCstGetTchGrpByPmoHTML(nPmoID, nPkgID);
    });
    $('#ocmPkgProduct').change(function () {
        nOthId = $(this).find(':selected').attr('data-id');
        if (nOthId == '4') {
            $('#oetPdtMaxPerson').val('');
            $('#oetPdtMaxPerson').attr('disabled', false);
        } else {
            $('#oetPdtMaxPerson').val('');
            $('#oetPdtMaxPerson').attr('disabled', false);
        }
    });
    $(function () {
        $('#ocmPkgProduct').on('change', function () {
            var tBookingType = $('#oInputFTZneBookingType').val();
            var tPdtType = $(this).children('option:selected').data('id');

            // เช็คตั๋ว
            if (tPdtType == 2 && tBookingType == 3) {
                var n = $(".xWInputFNPdtOthSystem:input[value='2']").length;
                if (n >= 1) {
                    $('.xWBtnAddPkgModel').attr('disabled', true);
                    alert('<?= language('ticket/package/package', 'You can added product type ticket 1 item') ?>');
                } else {
                    $('.xWBtnAddPkgModel').attr('disabled', false);
                }
            }
            // เช็คห้องพัก
            if (tPdtType == 4 && tBookingType == 2) {
                var n = $(".xWInputFNPdtOthSystem:input[value='4']").length;
                if (n >= 1) {
                    $('.xWBtnAddPkgModel').attr('disabled', true);
                    alert('<?= language('ticket/package/package', 'You can added product type room 1 item') ?>');
                } else {
                    $('.xWBtnAddPkgModel').attr('disabled', false);
                }
            }
            // เช็คที่นั่ง 
            if (tPdtType == 5 && tBookingType == 1) {
                var n = $(".xWInputFNPdtOthSystem:input[value='5']").length;
                if (n >= 1) {
                    $('.xWBtnAddPkgModel').attr('disabled', true);
                    alert('<?= language('ticket/package/package', 'You can added product type seat 1 item') ?>');
                } else {
                    $('.xWBtnAddPkgModel').attr('disabled', false);
                }
            }
            if (tPdtType == 0 || tPdtType == 1 || tPdtType == 3 || tPdtType == 6) {
                $('.xWBtnAddPkgModel').attr('disabled', false);
            }
            if (tBookingType == 0) {
                $('.xWBtnAddPkgModel').attr('disabled', false);
            }
        });
        $('[title]').tooltip();
    });
</script>