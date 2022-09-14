<div class="xCNMrgNavMenu">
    <div class="row xCNavRow" style="width:inherit;">
        <div class="xCNBchVMaster">
            <div class="col-xs-8 col-md-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSvBCHCallPageBranchList()"><?= language('ticket/package/package', 'tPkg_PackageInfo') ?></li>
                </ol>
            </div>
            <div class="col-xs-12 col-md-4 text-right p-r-0">
                <?php if (@$oAuthen['tAutStaDelete'] == '1'): ?>                    
                    <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" style="display: none;" type="button" onclick="FSxDelAllOnCheck();"> <?= language('common/main/main','tCMNDeleteAll')?></button>&nbsp;
                    <input type="hidden" id="ohdIDCheckDel">                    
                <?php endif; ?>
                <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                    <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxCallPageAddPkg()">+</button>
                <?php endif; ?>
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
            <div class="row">
                <div class="col-md-12">
                    <!-- <div class="col-md-4 padding-right5">
                        <div class="form-group">
                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">เลือกสาขา</span>
                                <div>
                                    <select class="selection-2 form-control input-valid js-example-basic-single"  name="ocmPkgPmoID" id="ocmPkgPmoID" style="width: 100%">
                                        <option value=""><?= language('ticket/package/package', 'tPkg_SearchFromModelName') ?></option>
                                        <?php if (isset($oModelList[0]->FNPmoID)): ?>
                                            <?php foreach ($oModelList AS $aValue): ?>
                                                <option class="xWModelList" value="<?= $aValue->FNPmoID ?>" data-name="<?= $aValue->FTPmoName ?>"><?= $aValue->FTPmoName ?></option>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>-->
                    <!--<div class="col-md-3 padding-left5 padding-right5">
                        <div class="form-group">
                            <div class="wrap-input100 input100-select">
                                <span class="label-input100">เลือกสถานะ</span>
                                <div>
                                    <select class="form-control"  name="ocmPkgStaPrcDoc" id="ocmPkgStaPrcDoc">
                                        <option value=""><?= language('ticket/package/package', 'tPkg_SelectStatus') ?></option>
                                        <option value="1"><?= language('ticket/package/package', 'tPkg_Approved') ?></option>
                                        <option value="0"><?= language('ticket/package/package', 'tPkg_NotApproved') ?></option>
                                        <option value=""><?= language('ticket/package/package', 'tPkg_All') ?></option>
                                    </select>
                                </div>
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>-->
                    <div class="col-md-4" style="padding-left: 0;">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_FindFormPkgName') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTPkgName" name="oetFTPkgName" onkeyup="Javascript:if(event.keyCode==13) JSxPKGCountSearch()">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPKGCountSearch()">
                                        <img class="xCNIconAddOn" src="<?=base_url();?>application/modules/common/assets/images/icons/search-24.png">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:28px;">
                        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                <?= language('common/main/main','tCMNOption')?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li id="oliBtnDeleteAll" class="disabled">
                                    <a data-toggle="modal" data-target="#odvmodaldelete"><?= language('common/main/main','tDelAll')?></a>
                                </li>
                            </ul>
                        </div>
                    </div>    					
                </div>
            </div>			
            <div id="oResultPackage"></div>			
            <!-- <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?><span id="ospPkgTotalRecord"></span> <?= language('ticket/zone/zone', 'tList') ?> <?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">1</span> / <span id="ospTotalPage"></span></div>
            <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div> -->


            <div class="row" style="margin-right: -15px; margin-left: -15px;">
                <div class="col-md-4 text-left grid-resultpage">
                    <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospPkgTotalRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">1</span> / <span id="ospTotalPage"></span></a>
                </div>                     
                <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
            </div>


        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.js-example-basic-single').select2();
    });
</script>

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/showtime/jShowTime.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/package/jPackage.js"></script>
