
    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oEditPmt">
            <div id="odvBchMainMenu" class="main-menu">
                <div class="xCNMrgNavMenu">
                    <div class="row xCNavRow" style="width:inherit;">
                        <div class="xCNBchVMaster">
                            <div class="col-xs-8 col-md-8">
                                <ol id="oliMenuNav" class="breadcrumb">
                                    <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?= base_url() ?>EticketPromotion')"><?= language('ticket/promotion/promotion', 'tPmt_PmtHeaderText') ?></li>
                                    <li class="xCNLinkClick"><?= language('ticket/promotion/promotion', 'tEditPromotion') ?></li>
                                </ol>
                            </div>
                            <div class="col-xs-12 col-md-4 text-right p-r-0">
                                <button type="button" onclick="JSxCallPage('<?= base_url() ?>EticketPromotion')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                                <div class="btn-group">
                                    <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>
                                        <?php if ($oPmt[0]->FTPmhStaPrcDoc == '1'): ?>
                                            <button type="button" class="btn btn-default xCNBTNPrimery"><?= language('ticket/event/event', 'tAccepted') ?></button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-default xCNBTNDefult" id="oBtnApv" onclick="JSxPmtApv('<?= $oPmt[0]->FNPmhID; ?>')"><?= language('ticket/event/event', 'tAccept') ?></button>
                                        <?php endif; ?>							
                                    <?php endif; ?>
                                    <?php if ($oPmt[0]->FTPmhStaPrcDoc == '1'): ?>
                                    <?php else: ?>
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
                                    <?php endif; ?>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">					
                            <div class="panel panel-default" style="margin-bottom: 25px;"> 
                                <div id="odvHeadPromotion" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                                    <label class="xCNTextDetail1"><?= language('ticket/promotion/promotion', 'tGeneralInformation') ?></label>
                                    <a class="xCNMenuplus" role="button" data-toggle="collapse" data-parent="#odvSubGroupApp" href="#odvDataPromotion" aria-expanded="true" aria-controls="odvDataPromotion">
                                        <i class="fa fa-plus xCNPlus"></i>
                                    </a>
                                </div>
                                <div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body xCNPDModlue">
                                        <div class="upload-img" id="oImgUpload">
                                            <?php
                                                if(isset($oPmt[0]->FTImgObj) && !empty($oPmt[0]->FTImgObj)){

                                                    $tFullPatch = './application/modules/'.$oPmt[0]->FTImgObj;
                                                    if (file_exists($tFullPatch)){
                                                        $tPatchImg = base_url().'/application/modules/'.$oPmt[0]->FTImgObj;
                                                    }else{
                                                        $tPatchImg = base_url().'application/modules/common/assets/images/640x160.jpg';
                                                    }
                                                }else{
                                                    $tPatchImg = base_url().'application/modules/common/assets/images/640x160.jpg';
                                                }
                                            ?>
                                            <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain">
                                            <span class="btn-file">
                                                <input type="hidden" name="ohdPmtImg" id="oetImgInputMain">
                                            </span>
                                            <input type="hidden" name="ohdFNPmhID" value="<?= $oPmt[0]->FNPmhID; ?>">
                                        </div>
                                        <div class="xCNUplodeImage">
                                            <?php if ($oAuthen['tAutStaAppv'] == '1'): ?>
                                                <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '7/2')"><i class="fa fa-camera"></i> <?= language('common/main/main', 'tSelectPic') ?></button>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/promotion/promotion', 'tPromotionCode') ?></label>
                                            <input class="form-control" type="text" name="oetFTPmhCode" disabled="" value="<?= $oPmt[0]->FTPmhCode ?>">
                                            <input type="hidden" id="oetFTPmhCode" name="oetFTPmhCode" value="<?= $oPmt[0]->FTPmhCode ?>">
                                            <input type="hidden" name="ohdFTPmhCalType" id="ohdFTPmhCalType" value="2">
                                            <input type="hidden" name="ohdFTPmhType" id="ohdFTPmhType" value="2">
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><?= language('ticket/promotion/promotion', 'tPromotionName') ?></label>
                                            <input type="text" class="form-control" id="oetFTPmhName" name="oetFTPmhName" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterAPromotionName') ?>" value="<?= $oPmt[0]->FTPmhName ?>">
                                        </div>
                                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterAMinimumOrder') ?>"><?= language('ticket/promotion/promotion', 'tMinimumOrder') ?></label>
                                                    <input type="text" class="form-control" id="oetFCPmhBuyAmt" name="oetFCPmhBuyAmt" value="<?= number_format($oPmt[0]->FCPmhBuyAmt, 2, '.', ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterADiscount') ?>"><?= language('ticket/promotion/promotion', 'tDiscount') ?></label>
                                                    <input type="text" class="form-control" id="oetFCPmhGetValue" name="oetFCPmhGetValue" value="<?= number_format($oPmt[0]->FCPmhGetValue, 2, '.', '') ?>">
                                                    <input type="hidden" name="ohdFCPmhGetCond" value="2">
                                                    <span class="prefix xCNiConGen xCNIconBrowse">%</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?= language('ticket/promotion/promotion', 'tUsageStatus') ?></label>
                                                    <select class="selectpicker form-control" name="ocmFTPmhClosed" id="ocmFTPmhClosed" aria-invalid="false">
                                                            <option value="0"<?php
                                                            if ($oPmt[0]->FTPmhClosed == '0') {
                                                                echo ' selected';
                                                            }
                                                            ?>><?= language('ticket/promotion/promotion', 'tEnable') ?></option>
                                                            <option value="1"<?php
                                                            if ($oPmt[0]->FTPmhClosed == '1') {
                                                                echo ' selected';
                                                            }
                                                            ?>><?= language('ticket/promotion/promotion', 'tDisabled') ?>
                                                            </option>
                                                    </select>
                                                </div>	
                                            </div>
                                            <div class="col-md-4"></div>
                                        </div>
                                    </div>
                                </div>    
                            </div>

                            <div class="panel panel-default" style="margin-bottom: 25px;"> 
                                <div id="odvHeadPromotion" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                                    <label class="xCNTextDetail1"><?= language('ticket/promotion/promotion', 'tDateAndTime') ?></label>
                                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion2" aria-expanded="true" aria-controls="odvDataPromotion2">
                                        <i class="fa fa-plus xCNPlus"></i>
                                    </a>
                                </div>
                                <div id="odvDataPromotion2" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body xCNPDModlue">                               
                                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterAStartDate') ?>"><?= language('ticket/promotion/promotion', 'tStartDate') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="oetFDPmhActivate" name="oetFDPmhActivate" value="<?= ($oPmt[0]->FDPmhActivate == "" ? "" : date("d-m-Y", strtotime($oPmt[0]->FDPmhActivate))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtFDPmhActivate" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>									
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterTime') ?>"><?= language('ticket/promotion/promotion', 'tTime') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="oetFDPmhTActivate" name="oetFDPmhTActivate" value="<?= ($oPmt[0]->FDPmhTActivate == "" ? "" : date("H:i", strtotime($oPmt[0]->FDPmhTActivate))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtFDPmhTActivate" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>										
                                            </div>
                                        </div>
                                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่วันที่เริ่มต้น"><?= language('ticket/promotion/promotion', 'tEndDate') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="oetFDPmhExpired" name="oetFDPmhExpired" value="<?= ($oPmt[0]->FDPmhExpired == "" ? "" : date("d-m-Y", strtotime($oPmt[0]->FDPmhExpired))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtFDPmhExpired" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>										
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm" data-validate="กรุณาใส่วันที่สิ้นสุด"><?= language('ticket/promotion/promotion', 'tTime') ?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="oetFDPmhTExpired" name="oetFDPmhTExpired" value="<?= ($oPmt[0]->FDPmhTExpired == "" ? "" : date("H:i", strtotime($oPmt[0]->FDPmhTExpired))) ?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtFDPmhTExpired" type="button" class="btn xCNBtnDateTime">
                                                                <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>										
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="panel panel-default" style="margin-bottom: 25px;"> 
                                <div id="odvHeadCondition" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion3">
                                        <i class="fa fa-plus xCNPlus"></i>
                                    </a>
                                    <div id="odvHeadBarShowPanalGrpCondition">
                                        <label class="xCNTextDetail1"><?= language('ticket/promotion/promotion', 'tPmt_PspRefType2') ?></label>
                                    </div>	
                                </div>
                                <div id="odvDataPromotion3" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body" style="padding-bottom: 0px;"> 
                                        <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>					
                                            <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oPkgModal" onclick="JSxPkgCount()" type="button">+</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (@$oPdt[0]->FNPkgID != ''): ?>
                                        <input type="hidden" name="ohdFTPmhStaSpcPdt" id="ohdFTPmhStaSpcPdt" value="1">
                                    <?php else: ?>
                                        <input type="hidden" name="ohdFTPmhStaSpcPdt" id="ohdFTPmhStaSpcPdt" value="2">
                                    <?php endif; ?>
                                    <input type="hidden" name="ohdFTPspStaExcludePkg" id="ohdFTPspStaExcludePkg" value="2">
                                    <div class="panel-body xCNPDModlue">
                                        <table class="table table-hover" id="oTablePkg">
                                            <thead>
                                                <tr>
                                                    <th><?= language('ticket/promotion/promotion', 'tNo') ?></th>
                                                    <th><?= language('ticket/promotion/promotion', 'tPackageName') ?></th>
                                                    <th><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                                                    <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                        <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>	
                                                <?php if (@$oPdt[0]->FNPkgID != ''): ?>
                                                    <?php foreach ($oPdt as $key => $oValue): ?>
                                                        <?php $n = $key + 1; ?>
                                                        <tr id="otrPkg<?= $oValue->FNPspID ?>">
                                                            <td><?= $n ?></td>
                                                            <td><?= $oValue->FTPkgName ?>
                                                                <input type="hidden" id="ohdChkExcludePkg" value="<?= $oValue->FTPspStaExclude ?>">													
                                                            </td>
                                                            <td>
                                                                <?php if ($oValue->FTPspStaExclude == '1'): ?>
                                                                    <?= language('ticket/promotion/promotion', 'tExceptPackage') ?>
                                                                <?php else: ?>
                                                                    <?= language('ticket/promotion/promotion', 'tPackageOnly') ?>
                                                                <?php endif; ?>
                                                                <input type="hidden" id="ohdPkgId" name="ohdPkgId[]" value="<?= $oValue->FNPspCodeRef ?>">
                                                            </td>
                                                            <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                                <td>
                                                                    <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="JSxDelPkg('<?= $oValue->FNPspID ?>', '<?= $oPmt[0]->FNPmhID ?>', '<?= $oValue->FTPkgName ?>');">
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr id="otrPkg">
                                                        <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>							
                                    </div>
                                </div>    
                            </div>
                            <div class="panel panel-default" style="margin-bottom: 25px;"> 
                                <div id="odvHeadCondition" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion4">
                                        <i class="fa fa-plus xCNPlus"></i>
                                    </a>
                                    <div id="odvHeadBarShowPanalGrpCondition">
                                        <label class="xCNTextDetail1"><?= language('ticket/promotion/promotion', 'tPmt_ModelText') ?></label>
                                    </div>	
                                </div>
                                <div id="odvDataPromotion4" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body" style="padding-bottom: 0px;"> 
                                        <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>					
                                            <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oBchModal" onclick="JSxBchCount()" type="button">+</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (@$oBranch[0]->FNPmoID != ''): ?>                                    
                                        <input type="hidden" name="ohdFTPmhStaSpcPark" id="ohdFTPmhStaSpcPark" value="1">
                                    <?php else: ?>
                                        <input type="hidden" name="ohdFTPmhStaSpcPark" id="ohdFTPmhStaSpcPark" value="2">
                                    <?php endif; ?>
                                    <input type="hidden" name="ohdFTPspStaExcludeBch" id="ohdFTPspStaExcludeBch" value="2">
                                    <div class="panel-body xCNPDModlue">
                                        <table class="table table-hover" id="oTableBranch">
                                            <thead>
                                                <tr>
                                                    <th><?= language('ticket/promotion/promotion', 'tNo') ?></th>
                                                    <th><?= language('ticket/promotion/promotion', 'tPmt_ModelText') ?></th>
                                                    <th><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                                                    <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                        <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (@$oBranch[0]->FNPmoID != ''): ?>
                                                    <?php foreach ($oBranch as $key => $oValue): ?>
                                                        <?php $n = $key + 1; ?>
                                                        <tr id="otrBch<?= $oValue->FNPspID ?>">
                                                            <td><?= $n ?></td>
                                                            <td>
                                                                <?= $oValue->FTPmoName ?>
                                                                <input type="hidden" id="ohdChkExcludeBch" value="<?= $oValue->FTPspStaExclude ?>">
                                                            </td>
                                                            <td>
                                                                <?php if ($oValue->FTPspStaExclude == '1'): ?>
                                                                    ยกเว้นสาขา
                                                                <?php else: ?>
                                                                    เฉพาะสาขา
                                                                <?php endif; ?>
                                                                <input type="hidden" id="ohdBranchId" name="ohdBranchId[]" value="<?= $oValue->FNPmoID ?>">
                                                            </td>
                                                            <?php if ($oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                                <td>
                                                                    <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="JSxDelBch('<?= $oValue->FNPspID ?>', '<?= $oPmt[0]->FNPmhID ?>', '<?= $oValue->FTPmoName ?>');">
                                                                </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr id="otrBch">
                                                        <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>							
                                    </div>
                                </div>    
                            </div>
                            <div class="panel panel-default" style="margin-bottom: 25px;"> 
                                <div id="odvHeadCondition" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion6">
                                        <i class="fa fa-plus xCNPlus"></i>
                                    </a>
                                    <div id="odvHeadBarShowPanalGrpCondition">
                                        <label class="xCNTextDetail1">กลุ่ม</label>
                                    </div>		
                                    
                                </div>
                                <div id="odvDataPromotion6" class="panel-collapse collapse in" role="tabpanel">
                                    <div class="panel-body" style="padding-bottom: 0px;"> 
                                        <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>					
                                            <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oGrpModal" onclick="JSxAgnCount()" type="button">+</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="panel-body xCNPDModlue"> 
                                        <?php if (@$oAgn[0]->FNPsgGrpID != '' || @$oCst[0]->FNPsgGrpID != ''): ?>
                                            <input type="hidden" name="ohdFTPmhStaSpcGrp" id="ohdFTPmhStaSpcGrp" value="1">
                                        <?php else: ?>
                                            <input type="hidden" name="ohdFTPmhStaSpcGrp" id="ohdFTPmhStaSpcGrp" value="2">
                                        <?php endif; ?>
                                        <input type="hidden" name="ohdFTPsgStaExcludeGrp" id="ohdFTPsgStaExcludeGrp" value="2">                                        
                                        <table class="table table-hover" id="oTableGrp">
                                            <thead>
                                                <tr>
                                                    <th><?= language('ticket/promotion/promotion', 'tNo') ?></th>
                                                    <th>ชื่อกลุ่ม</th>
                                                    <th><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                                                    <?php if (@$oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                        <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>	
                                                <?php $this->n = 0; ?>
                                                <?php if (@$oAgn[0]->FNPsgGrpID != '' || @$oCst[0]->FNPsgGrpID != ''): ?>
                                                    <?php if (@$oAgn[0]->FTPsgRefID != ''): ?>
                                                        <?php foreach (@$oAgn as $key => $oValue): ?>
                                                            <?php $this->n = $key + 1; ?>
                                                            <tr id="otrGrp<?= $oValue->FNPsgGrpID ?>">
                                                                <td><?= $this->n ?></td>
                                                                <td><?= $oValue->FTAggName ?>
                                                                    <input type="hidden" id="ohdChkExcludeGrp" value="<?= $oValue->FTPsgStaExclude ?>">
                                                                    <input type="hidden" id="ohdAgnId" name="ohdAgnId[]" value="<?= $oValue->FTPsgRefID ?>">
                                                                </td>
                                                                <td>
                                                                    <?php if ($oValue->FTPsgStaExclude == '1'): ?>
                                                                        ยกเว้นกลุ่ม
                                                                    <?php else: ?>
                                                                        เฉพาะกลุ่ม
                                                                    <?php endif; ?>	

                                                                </td>
                                                                <?php if ($oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                                    <td>
                                                                        <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" onclick="JSxDelGrp('<?= $oValue->FNPsgGrpID ?>', '<?= $oPmt[0]->FNPmhID ?>', '<?= $oValue->FTAggName ?>');">
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <?php if (@$oCst[0]->FTPsgRefID != ''): ?>
                                                        <?php foreach (@$oCst as $key => $oValue): ?>
                                                            <?php
                                                            if ($this->n == 0) {
                                                                $n = $key + 1;
                                                            } else {
                                                                $n = $key + $this->n;
                                                            }
                                                            ?>
                                                            <tr id="otrGrp<?= $oValue->FNPsgGrpID ?>">
                                                                <td><?= $n ?></td>
                                                                <td><?= $oValue->FTCgpName ?>
                                                                    <input type="hidden" id="ohdChkExcludeGrp" value="<?= $oValue->FTPsgStaExclude ?>">
                                                                </td>
                                                                <td>
                                                                    <?php if ($oValue->FTPsgStaExclude == '1'): ?>
                                                                        ยกเว้นกลุ่ม
                                                                    <?php else: ?>
                                                                        เฉพาะกลุ่ม
                                                                    <?php endif; ?>
                                                                    <input type="hidden" id="ohdCgpId" name="ohdCgpId[]" value="<?= $oValue->FTPsgRefID ?>">
                                                                </td>
                                                                <?php if ($oPmt[0]->FTPmhStaPrcDoc != '1'): ?>
                                                                    <td>
                                                                        <a onclick="JSxDelGrp('<?= $oValue->FNPsgGrpID ?>', '<?= $oPmt[0]->FNPmhID ?>', '<?= $oValue->FTCgpName ?>');"><i style="margin-left: 10px;" class="fa fa-trash-o fa-lg"></i></a>
                                                                    </td>
                                                                <?php endif; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <tr id="otrGrp">
                                                        <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>							
                                    </div>
                                </div>    
                            </div>
                        </div>			
                    </div>
                </div>
            </div>
    </form>

<div id="oPkgModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="border: 0;">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tShowInformationPackage') ?></label>
                <div class="pull-right">
                    <button type="button" class="btn btn-default xCNBTNPrimery" onclick="FSxAddPkg();"><span><?= language('common/main/main', 'tConfirm') ?></span></button>                    
                    <button type="button" class="btn btn-danger xCNBTNDefult" data-dismiss="modal"><span><?= language('common/main/main', 'tCancel') ?></span></button>                     
                </div>
            </div>
            <div class="modal-body">      
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTPkgName" name="oetFTPkgName" onkeyup="Javascript:if(event.keyCode==13) JSxPkgCount()">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPkgCount()">
                                        <img class="xCNIconAddOn" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">		
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row" style="margin-left: -15px; margin-right: -15px; margin-top: 30px;">
                            <div class="col-md-4">
                                <input type="radio" checked="checked" name="orbExcludePkg" id="orbFTPspStaExcludePkg" class="xWFTPspStaExcludePkg2" value="2"> <?= language('ticket/promotion/promotion', 'tPackageOnly') ?>
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="orbExcludePkg" id="orbFTPspStaExcludePkg" class="xWFTPspStaExcludePkg1" value="1"> <?= language('ticket/promotion/promotion', 'tExceptPackage') ?>
                            </div>
                        </div>		
                    </div>
                </div>
                <table class="table table-hover xWTablePkgList" id="otbBrowserList">
                    <thead>
                        <tr>
                            <th><?= language('ticket/promotion/promotion', 'tPackageID') ?></th>
                            <th><?= language('common/main/main', 'tPackageName') ?></th>
                        </tr>
                    </thead>
                    <tbody>	
                        <tr id="otrPkg">
                            <td align="center" colspan="2"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row" style="margin-right: -15px; margin-left: -15px;"> 	
                    <div class="col-md-4 text-left grid-resultpage">
                        <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalPkgRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActivePkg">0</span> / <span id="ospTotalPagePkg">0</span></a>
                    </div>                     
                    <div class="col-md-8 text-right xWGridFooter xWBoxPkg"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="oBchModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="border: 0;">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tShowInformationBranch') ?></label>
                <div class="pull-right">
                    <button type="button" class="btn btn-default xCNBTNPrimery" onclick="FSxAddBch();"><span><?= language('common/main/main', 'tConfirm') ?></span></button>                    
                    <button type="button" class="btn btn-danger xCNBTNDefult" data-dismiss="modal"><span><?= language('common/main/main', 'tCancel') ?></span></button>                     
                </div>
            </div>
            <div class="modal-body">      
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTPmoName" name="oetFTPmoName" onkeyup="Javascript:if(event.keyCode==13) JSxPkgCount()">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPkgCount()">
                                        <img class="xCNIconAddOn" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">		
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row" style="margin-left: -15px; margin-right: -15px; margin-top: 30px;">
                            <div class="col-md-4">
                                <input type="radio" checked="checked" name="orbExcludeBch" id="orbFTPspStaExcludeBch" class="xWFTPspStaExcludeBch2" value="2"> เฉพาะสาขา
                            </div>
                            <div class="col-md-4">
                                <input type="radio" name="orbExcludeBch" id="orbFTPspStaExcludeBch" class="xWFTPspStaExcludeBch1" value="1"> ยกเว้นสาขา
                            </div>
                        </div>		
                    </div>
                </div>
                <table class="table table-hover xWTableBchList" id="otbBrowserList">
                    <thead>
                        <tr>
                            <th><?= language('ticket/promotion/promotion', 'tBranchCode') ?></th>
                            <th><?= language('ticket/promotion/promotion', 'tBranchName') ?></th>
                        </tr>
                    </thead>
                    <tbody>	
                        <tr>
                            <td align="center" colspan="2"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="row" style="margin-right: -15px; margin-left: -15px;"> 	
                    <div class="col-md-4 text-left grid-resultpage">
                        <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalBchRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveBch">0</span> / <span id="ospTotalPageBch">0</span></a>
                    </div>                     
                    <div class="col-md-8 text-right xWGridFooter xWBoxBch"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="oGrpModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="border: 0;">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tShowinformationGroups') ?></label>
                <div class="pull-right">
                    <button type="button" class="btn btn-default xCNBTNPrimery btn-add-grp" onclick="FSxAddCst(); FSxAddAgg();"><span><?= language('common/main/main', 'tConfirm') ?></span></button>                    
                    <button type="button" class="btn btn-danger xCNBTNDefult" data-dismiss="modal"><span><?= language('common/main/main', 'tCancel') ?></span></button>                     
                </div>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#oAgn" onclick="JSxAgnCount()">Agency</a></li>
                    <li><a data-toggle="tab" href="#oCst" onclick="JSxCstCount()"><?= language('common/main/main', 'tPmt_PgpType2') ?></a></li>
                </ul>
                <div class="tab-content">
                    <div id="oAgn" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTAggName" name="oetFTAggName" onkeyup="Javascript:if(event.keyCode==13) JSxAgnCount()">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxAgnCount()">
                                                <img class="xCNIconAddOn" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">		
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row" style="margin-left: -15px; margin-right: -15px; margin-top: 30px;">
                                    <div class="col-md-4">
                                        <input type="radio" checked="checked" name="orbFTPsgStaExcludeAgn" id="orbFTPsgStaExcludeAgn" class="xWFTPsgStaExcludeAgn2" value="2"> เฉพาะกลุ่ม
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" name="orbFTPsgStaExcludeAgn" id="orbFTPsgStaExcludeAgn" class="xWFTPsgStaExcludeAgn1" value="1"> ยกเว้นกลุ่ม
                                    </div>
                                </div>		
                            </div>
                        </div>
                        <table class="table table-hover xWTableAgnList" id="otbBrowserList">
                            <thead>
                                <tr>
                                    <th><?= language('ticket/promotion/promotion', 'tAgencyGroupCode') ?></th>
                                    <th><?= language('ticket/promotion/promotion', 'tGroupNameAgency') ?></th>
                                </tr>
                            </thead>
                            <tbody>	
                                <tr>
                                    <td align="center" colspan="2"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row" style="margin-right: -15px; margin-left: -15px;"> 	
                            <div class="col-md-4 text-left grid-resultpage">
                                <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalAgnRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveAgn">0</span> / <span id="ospTotalPageAgn">0</span></a>
                            </div>                     
                            <div class="col-md-8 text-right xWGridFooter xWBoxAgn"></div>
                        </div>
                    </div>
                    <div id="oCst" class="tab-pane fade">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                                    <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTCgpName" name="oetFTCgpName" onkeyup="Javascript:if(event.keyCode==13) JSxCstCount()">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnSearch" type="button" onclick="JSxCstCount()">
                                                <img class="xCNIconAddOn" src="<?= base_url(); ?>application/modules/common/assets/images/icons/search-24.png">		
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row" style="margin-left: -15px; margin-right: -15px; margin-top: 30px;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="radio" name="orbFTPsgStaExcludeCst" id="orbFTPsgStaExcludeCst" class="xwFTPsgStaExcludeCst2" value="2"> เฉพาะกลุ่ม
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="radio" name="orbFTPsgStaExcludeCst" id="orbFTPsgStaExcludeCst" class="xwFTPsgStaExcludeCst1" value="1"> ยกเว้นกลุ่ม
                                        </div>
                                    </div>
                                </div>		
                            </div>
                        </div>
                        <table class="table table-hover xWTableCstList" id="otbBrowserList">
                            <thead>
                                <tr>
                                    <th><?= language('ticket/promotion/promotion', 'tCustomerID') ?></th>
                                    <th><?= language('ticket/promotion/promotion', 'tCustomerGroupName') ?></th>
                                </tr>
                            </thead>
                            <tbody>	
                                <tr>
                                    <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row" style="margin-right: -15px; margin-left: -15px;"> 	
                            <div class="col-md-4 text-left grid-resultpage">
                                <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalCstRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActiveCst">0</span> / <span id="ospTotalPageCst">0</span></a>
                            </div>                     
                            <div class="col-md-8 text-right xWGridFooter xWBoxCst"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        $('.selectpicker').selectpicker();

        $('#oetFDPmhActivate').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        $('#oetFDPmhExpired').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        $('#oetFDPmhTActivate').datetimepicker({
            format: 'HH:mm',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
        $('#oetFDPmhTExpired').datetimepicker({
            format: 'HH:mm',
            locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
        });
    });
    
    //Btn Datetime Click
    $('#obtFDPmhActivate').click(function(){
		event.preventDefault();
        $('#oetFDPmhActivate').datetimepicker('show');
    });

    $('#obtFDPmhExpired').click(function(){
		event.preventDefault();
        $('#oetFDPmhExpired').datetimepicker('show');
    });
    //Btn Datetime Click

    //Btn Time Click
    $('#obtFDPmhTActivate').click(function(){
		event.preventDefault();
        $('#oetFDPmhTActivate').datetimepicker('show');
    });
    
    $('#obtFDPmhTExpired').click(function(){
		event.preventDefault();
        $('#oetFDPmhTExpired').datetimepicker('show');
    });
    //Btn Time Click

    $("#oEditPmt").validate({
        rules: {
            oetFTPmhCode: "required",
            oetFTPmhName: "required",
            oetFCPmhBuyAmt: "required",
            oetFCPmhGetValue: "required",
            oetFDPmhActivate: "required",
            oetFDPmhTActivate: "required",
            oetFDPmhTExpired: "required",
            oetFDPmhExpired: "required"
        },
        messages: {
            oetFTPmhCode: "",
            oetFTPmhName: "",
            oetFCPmhBuyAmt: "",
            oetFCPmhGetValue: "",
            oetFDPmhActivate: "",
            oetFDPmhTActivate: ""
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
                url: "<?php echo base_url(); ?>EticketPromotionEditAjax",
                data: $("#oEditPmt").serialize(),
                cache: false,
                success: function (msg) {
                    console.log(msg);
                    var nDataId = $('.xWBtnSaveActive').data('id');
                    if (nDataId == '1') {
                        JSxCallPage('<?php echo base_url() ?>EticketPromotionEdit/<?= $oPmt[0]->FNPmhID; ?>');
                                            } else if (nDataId == '2') {
                                                JSxCallPage('<?= base_url() ?>EticketPromotionAdd');
                                            } else if (nDataId == '3') {
                                                JSxCallPage('<?php echo base_url('EticketPromotion') ?>');
                                            }
                                            var ptNameImg = $('#oetImgInputMain').val();
                                            var ptFTPmhCode = $('#oetFTPmhCode').val();
                                            //Mark
                                            //JSxDelGrp(ptNameImg, ptFTPmhCode, '<?= $oPmt[0]->FNPmhID; ?>', '<?= $this->session->tSesUsername ?>');											

                                            //JSxGenImg(ptNameImg, ptFTPmhCode, '<?= $oPmt[0]->FNPmhID; ?>', '<?= $this->session->tSesUsername ?>');
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
                            FSxDecimal("#oetFCPmhBuyAmt", 2);
                            FSxDecimal("#oetFCPmhGetValue", 2);
</script>