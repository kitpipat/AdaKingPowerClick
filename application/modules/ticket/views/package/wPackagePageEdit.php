<!-- แก้ไขแพ็คเกจ  -->
<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmEditPackage" >
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNBchVMaster">
                <div class="col-xs-8 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>/EticketPackage')"><?= language('ticket/package/package', 'tPkg_Package') ?></li>
                        <li><?= language('ticket/package/package', 'tPkg_EditPackage') ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <button type="button" onclick="JSxCallPage('<?php echo base_url(); ?>EticketPackage')" id="btnPdtSelectClose" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                    <button type="button" onclick="JSxCallPagePkgDetail('<?= $oPckEdit[0]->FNPkgID ?>');" id="btnPdtSelectClose" class="btn btn-default xCNBTNDefult">หน้าถัดไป</button>
                    <?php if ($oPckEdit[0]->FTPkgStaPrcDoc == ''): ?>
                        <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>
                            <button type="button" class="btn btn-default xCNBTNDefult" onclick="JSxApprovePkg('<?= $oPckEdit[0]->FNPkgID ?>')" style="text-align:right;"><?= language('ticket/package/package', 'tPkg_Approve') ?></button>
                        <?php endif; ?>
                    <?php else : ?>
                        <button type="button" class="btn btn-default xCNBTNDefult" onclick="JSxApprovePkg('<?= $oPckEdit[0]->FNPkgID ?>')" style="text-align:right;"><?= language('ticket/package/package', 'tPkg_Approved') ?></button>
                    <?php endif; ?>

                    <?php if ($oPckEdit[0]->FTPkgStaPrcDoc == ''): ?>								
                        <div class="btn-group">
                            <button class="btn btn-default xWBtnGrpSaveLeft" type="submit" onclick="JSxBtnEditPkgSave();"><?= language('ticket/user/user', 'tSave') ?></button>
                            <button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu xWDrpDwnMenuMargLft">
                                <li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndView') ?></a></li>
                                <li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndNew') ?></a></li>
                                <li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#">บันทึกและไปหน้าถัดไป</a></li>
                            </ul>
                        </div>
                    <?php else : ?>
                        <button type="button" class="btn btn-default xCNBTNPrimery" onclick="JSxCallPagePkgDetail('<?= $oPckEdit[0]->FNPkgID ?>')"><?= language('ticket/user/user', 'tPkg_Next') ?></button>
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
                <?php if (@$oPckEdit[0]->FNPkgID != ''): ?>
                    <div class="nav-tab-pills-image" style="margin-left: 15px; margin-right: 15px;">
                        <input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPckEdit[0]->FTPkgStaPrcDoc ?>">
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
                                <div class="row" style="margin-left: -30px; margin-right: -30px;">
                                    <!-- รูป -->
                                    <div class="col-md-4 col-xs-12">
                                        <div class="row">
                                            <div class="upload-img" id="oImgUpload">

                                                <?php if ($oPckEdit[0]->FTImgObj != ""): ?>
                                                    <?php if ($oPckEdit[0]->FTPkgStaPrcDoc != 1): ?>
                                                        <a href="javascript:void(0)" id="olaDelImgPkg" onclick="FSxDelImgPkg('<?php echo $oPckEdit[0]->FNPkgID; ?>', '<?php echo $oPckEdit[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>');" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                                    <?php endif; ?>		
                                                <?php endif; ?>	

                                                <?php
                                                    if(isset($oPckEdit[0]->FTImgObj) && !empty($oPckEdit[0]->FTImgObj)){
                                                        $tFullPatch = './application/modules/'.$oPckEdit[0]->FTImgObj;
                                                        if (file_exists($tFullPatch)){
                                                            $tPatchImg = base_url().'/application/modules/'.$oPckEdit[0]->FTImgObj;
                                                        }else{
                                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                        }
                                                    }else{
                                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                    }
                                                ?>

                                                <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain" class="xWimageLoc">
                                                <span class="btn-file" style="padding: 8px; position: absolute; bottom: -15px; right: -2px;"> 
                                                    <?php if ($oPckEdit[0]->FTPkgStaPrcDoc != 1): ?>
                                                        <input type="hidden" name="ohdPkgImg" id="oetImgInputMain">
                                                    <?php endif; ?>		
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
                                                    <input type="text" class="hidden" name="oetEditPkgID" id="oetEditPkgID"  value="<?= $oPckEdit[0]->FNPkgID ?>">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่<?= language('ticket/package/package', 'tPkg_Name') ?>"><?= language('ticket/package/package', 'tPkg_Name') ?></label>
                                                    <input type="text" class="form-control" id="oetEditPkgName" name="oetEditPkgName" value="<?= $oPckEdit[0]->FTPkgName ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 col-xs-5">
                                                <input type="text" class="hidden" id="oetHideEditPkgStaLimitType" value="<?= $oPckEdit[0]->FTPkgStaLimitType ?>">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaLimitType') ?></label>
                                                    <select class="selectpicker form-control"  name="oetEditPkgStaLimitType" id="oetEditPkgStaLimitType" value="<?= $oPckEdit[0]->FTPkgStaLimitType ?>">
                                                        <optgroup label="<?= language('ticket/package/package', 'tPkg_StaLimitType') ?>">
                                                            <option class="xWStalimoetEditPkgEvnit1" value="1" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeDay') ?></option>
                                                            <option class="xWStalimit2" value="2" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeMonth') ?></option>
                                                            <option class="xWStalimit3" value="3" ><?= language('ticket/package/package', 'tPkg_StaLimitTypeYear') ?></option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 col-xs-3">
                                                <input type="text" class="hidden" id="oetHideEditPkgStaLimitBy" value="<?= $oPckEdit[0]->FTPkgStaLimitBy ?>">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaLimitBy') ?></label>
                                                    <select class="selectpicker form-control" name="oetEditPkgStaLimitBy" id="oetEditPkgStaLimitBy" value="<?= $oPckEdit[0]->FTPkgStaLimitType ?>">
                                                        <optgroup label="<?= language('ticket/package/package', 'tPkg_LimitBy') ?>">
                                                            <option class="xWStaLimitBy1" value="1" ><?= language('ticket/package/package', 'tPkg_StaLimitByZome') ?></option>
                                                            <option class="xWStaLimitBy2" value="2" ><?= language('ticket/package/package', 'tPkg_StaLimitByPkg') ?></option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="oetEditPkgStaLimitByOld" id="oetEditPkgStaLimitBy" value="<?= $oPckEdit[0]->FTPkgStaLimitType ?>">
                                            </div>
                                            <div class="col-md-4 col-xs-4">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่<?= language('ticket/package/package', 'tPkg_LimitQty') ?>"><?= language('ticket/package/package', 'tPkg_LimitQty') ?></label>
                                                    <input class="form-control" type="number" min="0"  id="oetHideEditPkgLimitQty" name="oetHideEditPkgLimitQty" value="<?= $oPckEdit[0]->FNPkgLimitQty ?>" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6 col-xs-6">
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectEvent') ?></label>
                                                    <select class="form-control selectpicker"  name="oetEditPkgEvn" id="oetEditPkgEvn">
                                                        <option class="xWEvn1" value="" ><?= language('ticket/package/package', 'tPkg_SelectEvent') ?></option>																	<!-- ถ้า Approve แล้ว  -->
                                                        <?php if ($oPckEdit[0]->FTPkgStaPrcDoc == '1'): ?>
                                                            <?php if ($oPckEdit[0]->FNEvnID != ''): ?>
                                                                <option class="xWEvn1" value="<?= $oPckEdit[0]->FNEvnID ?>" selected="selected"><?= $oPckEdit[0]->FTEvnName ?></option>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if ($oEvnList[0]->FNEvnID != ''): ?>
                                                                <?php foreach ($oEvnList AS $aValue): ?>
                                                                    <?php if ($aValue->FNEvnID == $oPckEdit[0]->FNEvnID): ?>
                                                                        <option class="xWEvn1" value="<?= $aValue->FNEvnID ?>" selected="selected"><?= $aValue->FTEvnName ?></option>
                                                                    <?php else: ?>
                                                                        <option class="xWEvn1" value="<?= $aValue->FNEvnID ?>"><?= $aValue->FTEvnName ?></option>
                                                                    <?php endif ?>
                                                                <?php endforeach; ?>
                                                            <?php endif ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StartSale') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetEditPkgStartSale" name="oetEditPkgStartSale" value="<?= ($oPckEdit[0]->FDPkgStartSale == "" ? '' : date("d-m-Y H:i", strtotime($oPckEdit[0]->FDPkgStartSale))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtEditPkgStartSale" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StartChkIn') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetEditPkgStopSale" name="oetEditPkgStopSale" value="<?= ($oPckEdit[0]->FDPkgStopSale == "" ? '' : date("d-m-Y H:i", strtotime($oPckEdit[0]->FDPkgStopSale))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtEditPkgStopSale" type="button" class="btn xCNBtnDateTime">
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
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StartChkIn') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetEditPkgStartChkIn" name="oetEditPkgStartChkIn" value="<?= ($oPckEdit[0]->FDPkgStartChkIn == "" ? '' : date("d-m-Y H:i", strtotime($oPckEdit[0]->FDPkgStartChkIn))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtEditPkgStartChkIn" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StopChkIn') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatepicker xCNInputMaskDate" id="oetEditPkgStopChkIn" name="oetEditPkgStopChkIn" value="<?= ($oPckEdit[0]->FDPkgStopChkIn == "" ? '' : date("d-m-Y H:i", strtotime($oPckEdit[0]->FDPkgStopChkIn))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtEditPkgStopChkIn" type="button" class="btn xCNBtnDateTime">
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
                                                    <div data-validate="กรุณาลือก<?= language('ticket/package/package', 'tPkg_TchGroup') ?>">
                                                        <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_TchGroup') ?></label>
                                                        <select class="selectpicker form-control"  name="oetEditPkgTchGroup" id="oetEditPkgTchGroup" title="<?= language('ticket/package/package', 'tPkg_TchGroup') ?>" style="width:100%;">
                                                            <option value=""><?= language('ticket/package/package', 'tPkg_TchGroup') ?></option>
                                                            <?php if ($oTchGroupList[0]->FNTcgID != ''): ?>
                                                                <?php foreach ($oTchGroupList AS $aValue): ?>
                                                                    <?php if ($aValue->FNTcgID == $oPckEdit[0]->FNTcgID): ?>
                                                                        <option value="<?= $aValue->FNTcgID ?>" selected="selected"><?= $aValue->FTTcgName ?>
                                                                            (<?php
                                                                            if ($aValue->FTPmoName != '') {
                                                                                echo $aValue->FTPmoName;
                                                                            } else {
                                                                                echo language('ticket/package/package', 'tPkg_TchPublic');
                                                                            }
                                                                            ?>)</option>

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
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <input type="text" class="hidden" id="ocmHideEditPickTypePrice"  value="<?= $oPckEdit[0]->FTPkgType ?>">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_PkgType') ?></label>
                                                    <select class="selectpicker form-control" name="ocmEditPkgType" id="ocmEditPkgType">
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
                                                    <input class="form-control" type="number" min="0" max="1" id="oetEditPkgMaxPark" name="oetEditPkgMaxPark" value="<?= $oPckEdit[0]->FNPkgMaxPark ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxChkIn') ?></label>
                                                    <input class="form-control" type="number" min="0" max="1" id="oetEditPkgMaxChkIn" name="oetEditPkgMaxChkIn" value="<?= $oPckEdit[0]->FNPkgMaxChkIn ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row xWMaxMinGrp">
                                            <div class="form-group col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MinGrpQty') ?></label>
                                                    <input class="form-control" type="number" min="0" id="oetEditPkgMinGrpQty" name="oetEditPkgMinGrpQty" value="<?= $oPckEdit[0]->FNPkgMinGrpQty ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxGrpQty') ?></label>
                                                    <input class="form-control" type="number" min="0" name="oetEditPkgMaxGrpQty" id="oetEditPkgMaxGrpQty" value="<?= $oPckEdit[0]->FNPkgMaxGrpQty ?>">
                                                </div>
                                            </div>
                                        </div>			                    
                                        <div class="row xWMaxMinGrpQtyByBill">
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MinQtyByBill') ?></label>
                                                    <input class="form-control" type="number" min="0" id="oetFNPkgMinQtyByBill" name="oetFNPkgMinQtyByBill" value="<?= $oPckEdit[0]->FNPkgMinQtyByBill ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_MaxQtyByBill') ?></label>
                                                    <input class="form-control" type="number" min="0" name="oetFNPkgMaxQtyByBill" id="oetFNPkgMaxQtyByBill" value="<?= $oPckEdit[0]->FNPkgMaxQtyByBill ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-xs-6" style="margin-bottom: 3px;">
                                                <input type="text" class="hidden" id="oetHideEditStaActive" value="<?= $oPckEdit[0]->FTPkgStaActive ?>">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_StaActive') ?></label>
                                                    <select class="selectpicker form-control" name="ocmEditPkgStaActive" id="ocmEditPkgStaActive" aria-invalid="false">
                                                        <option class="xWStaActive1" value="1"><?= language('ticket/package/package', 'tPkg_ActiveFromDateOfSale') ?></option>
                                                        <option class="xWStaActive2" value="2"><?= language('ticket/package/package', 'tPkg_ActiveFromDateSpecified') ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6 col-xs-6" style="margin-bottom: 3px;">
                                                <?php if ($oPckEdit[0]->FTPkgStaFreeGuide == '1'): ?>
                                                    <input type="checkbox" name="oetEditPkgStaFreeGuide" id="oetEditPkgStaFreeGuide" style="height: 20px;width: 20px;float:left;margin-top: 2px;margin-right: 5px;" checked> <?= language('ticket/package/package', 'tPkg_StaFreeGuide') ?>
                                                <?php else : ?>
                                                    <input type="checkbox" name="oetEditPkgStaFreeGuide" id="oetEditPkgStaFreeGuide" style="height: 20px;width: 20px;float:left;margin-top: 2px;margin-right: 5px;"> <?= language('ticket/package/package', 'tPkg_StaFreeGuide') ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>

                            <!--Tab2 -->
                            <div class="tab-pane" id="oPackageTab2" role="tabpanel" aria-expanded="true" style="margin-top:10px;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc1') ?></label>
                                            <input class="form-control" type="text" name="oetEditPkgDesc1" id="oetEditPkgDesc1" value="<?= $oPckEdit[0]->FTPkgDesc1 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc2') ?></label>
                                            <input class="form-control" type="text" name="oetEditPkgDesc2" id="oetEditPkgDesc2" value="<?= $oPckEdit[0]->FTPkgDesc2 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc3') ?></label>
                                            <input class="form-control" type="text" name="oetEditPkgDesc3" id="oetEditPkgDesc3" value="<?= $oPckEdit[0]->FTPkgDesc3 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc4') ?></label>
                                            <input class="form-control" type="text" name="oetEditPkgDesc4" id="oetEditPkgDesc4" value="<?= $oPckEdit[0]->FTPkgDesc4 ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Desc5') ?></label>
                                            <input class="form-control" type="text" name="oetEditPkgDesc5" id="oetEditPkgDesc5" value="<?= $oPckEdit[0]->FTPkgDesc5 ?>">
                                        </div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>											
                <?php endif; ?>
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

        //Btn Datetime Click
        $('#obtEditPkgStartSale').click(function(){
            event.preventDefault();
            $('#oetEditPkgStartSale').datetimepicker('show');
        });

        $('#obtEditPkgStopSale').click(function(){
            event.preventDefault();
            $('#oetEditPkgStopSale').datetimepicker('show');
        });

        $('#obtEditPkgStartChkIn').click(function(){
            event.preventDefault();
            $('#oetEditPkgStartChkIn').datetimepicker('show');
        });

        $('#obtEditPkgStopChkIn').click(function(){
            event.preventDefault();
            $('#oetEditPkgStopChkIn').datetimepicker('show');
        });
        //Btn Datetime Click
    });

    nPkgStaPrcDoc = $('#ohdPkgStaPrcDoc').val();
    if (nPkgStaPrcDoc != '') {
        $('.form-control').attr('disabled', true);
    } else {

    }
    $('#ocmEditPkgType').on('change', function () {
        if (this.value == '2') {
            $('#oetEditPkgPdtPrice').attr('disabled', false);

        } else if (this.value == '1') {
            $('#oetEditPkgPdtPrice').attr('disabled', true);

        }
    });
    nHideEditStaLimitType = $('#oetHideEditPkgStaLimitType').val();
    $('.xWStalimit' + nHideEditStaLimitType).attr('selected', 'selected');
    if (nHideEditStaLimitType != '1') {
        $('.xWStaLimitBy1').attr('disabled', true);
        $('.xWPickTypePrice1').attr('disabled', true);

    } else {
        $('.xWStaLimitBy1').attr('disabled', false);
        $('.xWPickTypePrice1').attr('disabled', false);
        $('.xWPickTypePrice1').prop('disabled', false);

    }
    nHideEditPickTypePrice = $('#ocmHideEditPickTypePrice').val();
    $('.xWPickTypePrice' + nHideEditPickTypePrice).attr('selected', 'selected');

    nHideEditStaActive = $('#oetHideEditStaActive').val();
    $('.xWStaActive' + nHideEditStaActive).attr('selected', 'selected');

    nHideEditStaLimitBy = $('#oetHideEditPkgStaLimitBy').val();
    $('.xWStaLimitBy' + nHideEditStaLimitBy).attr('selected', 'selected');

    if (nHideEditStaLimitBy == '1') {
        $('#oetHideEditPkgLimitQty').attr('disabled', true);
    } else if (nHideEditStaLimitBy == '2') {
        if (nHideEditPickTypePrice == '2') {
            $('.xWPickTypePrice1').attr('disabled', true);
        } else {
//	 		$('.xWPickTypePrice2').attr('disabled',true);
        }
    }
    $('#oetEditPkgStaLimitType').on('change', function () {

        if (this.value == '1') {
            $('.xWStaLimitBy1').attr('disabled', false);
            $('.xWPickTypePrice1').attr('disabled', false);

            nStaLimitBy = $('#oetEditPkgStaLimitBy').val();
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
            $('#oetHideEditPkgLimitQty').attr('disabled', false);


            $('.xWPickTypePrice2').attr('selected', true);
            $('.xWPickTypePrice2').prop('selected', true);
            $('.xWPickTypePrice1').attr('disabled', true);

            nStaLimitBy = $('#oetEditPkgStaLimitBy').val();
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
    $('#oetEditPkgStaLimitBy').on('change', function () {
        if (this.value == '1') {
            $('#oetHideEditPkgLimitQty').val('0');
            $('#oetHideEditPkgLimitQty').attr('disabled', true);

            $('.xWPickTypePrice1').attr('disabled', false);
            $('.xWPickTypePrice1').attr('selected', true);
            $('.xWPickTypePrice1').prop('selected', true);
// 	        $('.xWPickTypePrice2').attr('selected', false);
// 	        $('.xWPickTypePrice2').attr('disabled', true);

            $('#oetFNPkgMinQtyByBill').attr('disabled', true);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
            $('#oetFNPkgMinQtyByBill').val('');
            $('#oetFNPkgMaxQtyByBill').val('');
            $('.xWMaxMinGrpQtyByBill').hide();

            // is not pkg zone will max Max Park 1 
            var oetEditPkgStaLimitBy = $('#oetEditPkgStaLimitBy').val();
            var ocmEditPkgType = $('#ocmEditPkgType').val();
            var oInputCheckMaxPark = $('#oInputCheckMaxPark').val();
            if (oetEditPkgStaLimitBy == '1' && ocmEditPkgType == '2') {
                if (oInputCheckMaxPark == 1) {
                    $('#oetEditPkgMaxPark').removeAttr('max');
                } else {
                    $('#oetEditPkgMaxPark').attr('max', '1');
                    $('#oetEditPkgMaxPark').val('1');
                }
            } else {
                $('#oetEditPkgMaxPark').attr('max', '1');
                $('#oetEditPkgMaxPark').val('1');
            }
        } else {
            $('#oetHideEditPkgLimitQty').attr('disabled', false);

            $('.xWPickTypePrice2').attr('selected', true);
            $('.xWPickTypePrice2').attr('disabled', false);
            $('.xWPickTypePrice2').prop('selected', true);

            $('.xWPickTypePrice1').attr('selected', false);
            $('.xWPickTypePrice1').attr('disabled', true);

            $('#oetFNPkgMinQtyByBill').attr('disabled', false);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
            $('.xWMaxMinGrpQtyByBill').show();

            // is not pkg zone will max Max Park 1
            $('#oetEditPkgMaxPark').val('1');
            $('#oetEditPkgMaxPark').attr('max', '1');
        }

    });
    $(function () {
        $('#ocmEditPkgType').on('change', function () {
            if (this.value == '2') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', false);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
                $('.xWMaxMinGrpQtyByBill').show();

                // is not pkg zone will max Max Park 1 
                var oetEditPkgStaLimitBy = $('#oetEditPkgStaLimitBy').val();
                var ocmEditPkgType = $('#ocmEditPkgType').val();
                var oInputCheckMaxPark = $('#oInputCheckMaxPark').val();
                if (oetEditPkgStaLimitBy == '1' && ocmEditPkgType == '2') {
                    if (oInputCheckMaxPark == 1) {
                        $('#oetEditPkgMaxPark').removeAttr('max');
                    } else {
                        $('#oetEditPkgMaxPark').attr('max', '1');
                        $('#oetEditPkgMaxPark').val('1');
                    }
                } else {
                    $('#oetEditPkgMaxPark').attr('max', '1');
                    $('#oetEditPkgMaxPark').val('1');
                }
            } else if (this.value == '1') {
                $('#oetFNPkgMinQtyByBill').attr('disabled', true);
                $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
                $('#oetFNPkgMinQtyByBill').val('');
                $('#oetFNPkgMaxQtyByBill').val('');
                $('.xWMaxMinGrpQtyByBill').hide();

                // is not pkg zone will max Max Park 1
                $('#oetEditPkgMaxPark').val('1');
                $('#oetEditPkgMaxPark').attr('max', '1');
            }
        });
        if ($('#ocmEditPkgType').val() == '2') {
            $('#oetFNPkgMinQtyByBill').attr('disabled', false);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', false);
            $('.xWMaxMinGrpQtyByBill').show();

        } else if ($('#ocmEditPkgType').val() == '1') {
            $('#oetFNPkgMinQtyByBill').attr('disabled', true);
            $('#oetFNPkgMaxQtyByBill').attr('disabled', true);
            $('#oetFNPkgMinQtyByBill').val('');
            $('#oetFNPkgMaxQtyByBill').val('');
            $('.xWMaxMinGrpQtyByBill').hide();
        }
        /// call Max Park page
        JSxPKGCheckMaxPark('<?= $oPckEdit[0]->FNPkgID ?>');
        $('[title]').tooltip();
    });
</script>