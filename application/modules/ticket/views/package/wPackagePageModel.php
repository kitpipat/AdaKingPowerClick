<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc ?>">
<input type="hidden" id="ohdPkgEvnID" value="<?= $oPkgDetail[0]->FNEvnID ?>">
<div class="row xWPKGSearchPanal">
    <div class="col-lg-12 page-header xWpage-header" style="margin: 10px 0 10px;">
        <form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackageModel">
            <div class="row">			
                <input type="text" class="hidden" name="oetHidePkgID" id="oetHidePkgID" value="<?= $nPkgID ?>">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SearchPark') ?> </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectProvince') ?></label>
                        <select class="selectpicker form-control" name="ocmPkgProvince" id="ocmPkgProvince" aria-invalid="false">
                            <option value=""><?= language('ticket/package/package', 'tPkg_SelectProvince') ?></option>
                            <?php if (isset($oProvinceList[0]->FTPvnCode)): ?>
                                <?php foreach ($oProvinceList AS $aValue): ?>
                                    <option class="xWModelList" value="<?= $aValue->FTPvnCode ?>" data-name="<?= $aValue->FTPvnName ?>"><?= $aValue->FTPvnName ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div> 
           
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectPark') ?></label>
                        <input type="text" class="hidden" id="oetHidePmoName">
                        <select class="selectpicker form-control" name="ocmPkgPmoID" id="ocmPkgPmoID" aria-invalid="false">
                            <option value=""><?= language('ticket/package/package', 'tPkg_SelectPark') ?></option>
                            <?php if (isset($oModelList[0]->FTBchCode)): ?>
                                <?php foreach ($oModelList AS $aValue): ?>
                                    <option class="xWModelList" value="<?= $aValue->FTBchCode ?>" data-name="<?= $aValue->FTBchName ?>"><?= $aValue->FTBchName ?></option>
                                <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw xWLoading" style="position: absolute;font-size:20px;margin-left:40%;margin-top: -27px;display:none;"></i>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaLimitType') ?></label>
                        <input type="text" class="hidden" id="oetHidePmoName">
                        <select class="selectpicker form-control" name="ocmPkgPpkType" id="ocmPkgPpkType" aria-invalid="false">
                            <option  value=""><?= language('ticket/package/package', 'tPkg_StaLimitType') ?></option>
                            <option  value="2"><?= language('ticket/package/package', 'tPkg_AllowSale') ?></option>
                            <option  value="1"><?= language('ticket/package/package', 'tPkg_AllowTovisit') ?></option>
                        </select>
                        <i class="fa fa-spinner fa-spin fa-3x fa-fw xWLoading" style="position: absolute;font-size:20px;margin-left:40%;margin-top: -27px;display:none;"></i>
                    </div>
                </div>
                <div class="col-md-1 text-right">
                    <button class="xCNBTNPrimeryPlus xWBtnAddPkgModel" type="submit" onclick="JSxBtnAddPkgModelAdmin()" style="margin-top:25px;">+</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
<div class="col-lg-12 xWpage-body">
    <div class="row" style="margin-left: -15px; margin-right: -15px;">
        <div class="col-md-3 col-xs-12">
            <?= language('ticket/package/package', 'tPkg_AllowSaleAdmin') ?>
                <div style="margin-top:10px;">
                    <div class="xCNModPanal" id="odvPkgModAdminPanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;min-height:150px;">
                        <?php if (isset($oPkgModelForAdmin[0]->FNPkgID)): ?>
                            <?php foreach ($oPkgModelForAdmin AS $aValue): ?>  
                                <div class="row" style="padding:10px;">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="col-md-10 col-xs-8">
                                            <?= $aValue->FTBchName ?> 
                                        </div>
                                        <div class="col-md-2 col-xs-2 text-right">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                                <i class="fa fa-times" style="font-size: 20px;cursor:pointer;" onclick="JSxPkgDelModelAdmin('<?= $aValue->FNPkgID ?>', '<?= $aValue->FNPmoID ?>');"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <div class="col-md-9 col-xs-12">
        <div style="float: left;"><?= language('ticket/package/package', 'tPkg_AllowSaleCustomer') ?></div>
            <div style="right: 0;text-align:right;margin-right:5px;"><?= $oPkgModelForCustomerCount[0]->count; ?> of <?= $oPkgMaxPark[0]->FNPkgMaxPark; ?></div>
                <div style="margin-top:10px;">
                    <div class="xCNModPanal" id="odvPkgModCustomerPanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;min-height:150px;">
                        <?php if (isset($oPkgModelForCustomer[0]->FNPkgID)): ?>
                            <?php foreach ($oPkgModelForCustomer AS $aValue): ?>  
                                <div class="row" style="padding:10px;">
                                    <div class="col-md-12 col-xs-12">
                                        <?php if ($oPkgDetail[0]->FTPkgType == '2'): ?>
                                            <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                                <?= $aValue->FTBchName ?> 
                                            </div>
                                            <div class="col-md-4 col-xs-4 xCNRemovePadding">
                                                <?= $aValue->FTLocName ?> 
                                            </div>
                                            <div class="col-md-3 col-xs-3 xCNRemovePadding">
                                                <?= $aValue->FTZneName ?> 
                                            </div>
                                            <div class="col-md-1 col-xs-1 xCNRemovePadding">
                                                <?= number_format($aValue->FCPpkPrice, 2, '.', '') ?>
                                            </div>
                                            <div class="col-md-2 col-xs-2 ">
                                                <i class="fa fa-cog"></i> <label style="cursor:pointer;font-weight:normal;" onclick="JSxPkgCallPagePpkPriSpcPri('<?= $aValue->FNPpkID ?>', '<?= $aValue->FTZneName ?> ');"><?= language('ticket/package/package', 'tPkg_SpacialPrice') ?></label>
                                            </div>
                                            <div class="col-md-2 col-xs-2 ">
                                                <i class="fa fa-cog"></i> <label style="cursor:pointer;font-weight:normal;" onclick="JSxCallPagePkgSpcPriByGrp('<?= $nPkgID ?>', '<?= $aValue->FNPpkID ?>', '<?= $aValue->FTZneName ?>');"><?= language('ticket/package/package', 'tPkg_PriceByGroup') ?></label> 
                                            </div>
                                        <?php else : ?>
                                            <div class="col-md-3 col-xs-3">
                                                <?= $aValue->FTBchName ?> 
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <?= $aValue->FTLocName ?> 
                                            </div>
                                            <div class="col-md-3 col-xs-3">
                                                <?= $aValue->FTZneName ?> 
                                            </div>
                                        <?php endif; ?>
                                        <div class="col-md-2 col-xs-2 text-right">
                                            <?php if ($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
                                                <i class="fa fa-times" style="font-size: 20px;cursor:pointer;" onclick="JSxPkgDelModelCustomer('<?= $aValue->FNPpkID ?>', '<?= $aValue->FNPkgID ?>');"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<button type="button" class="btn btn-outline-primary pull-right hidden" id="obtHideModalModelCst"  data-toggle="modal" data-target="#modal-add-Loc-Zone-Time" style="margin-top: 15px;"><span></span></button>
<!-- เพิ่มแพ็คเกจ  ไป -->
<div class="modal fade" id="modal-add-Loc-Zone-Time" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackage">
					<div id="odvModalPkgCustomer">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
							<h5 class="modal-title" id="myModalLabel"><span class="xWNameTitleGate"></span></h5>
						</div>
						<div class="modal-body">

						</div>

					</div>
					<div id="odvModalPkgShowTime">
					</div>
				</form>
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
        nHeight = $(window).height() - 567;
        $('.xCNModPanal').css('height', nHeight)
        $('.xWPKGSearchPanal').css('display', 'none');
    } else {
        nHeight = $(window).height() - 681;
        $('.xCNModPanal').css('height', nHeight)
        $('.xWPKGSearchPanal').css('display', 'block');
    }

//เช็ค ว่า จะ Save แบบ Admin หรือ Customer
    $('#ocmPkgPpkType').change(function () {
        //ถ้าเป็น 1 จะเปลียน Onclick
        if (this.value == 1) {
            $('.xWBtnAddPkgModel').attr('onclick', 'JSxPkgAddModelCustomer()');
        } else {
            $('.xWBtnAddPkgModel').attr('onclick', 'JSxBtnAddPkgModelAdmin()');
        }
    });
//เมื่อเลือก Select box 
    $("#ocmPkgPmoID").change(function () {
        tPmoName = $('option:selected', this).attr('data-name');
        $('#oetHidePmoName').val(tPmoName);
    });
    $('#ocmPkgProvince').change(function () {
        nPvnID = this.value;
        
        JSxPkgCstGetSelectModelHTML(nPvnID);
    });
</script>