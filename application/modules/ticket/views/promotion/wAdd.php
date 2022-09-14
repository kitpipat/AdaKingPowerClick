<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oAddPmt">
        <div id="odvBchMainMenu" class="main-menu">
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow" style="width:inherit;">
                    <div class="xCNBchVMaster">
                        <div class="col-xs-8 col-md-8">
                            <ol id="oliMenuNav" class="breadcrumb">
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?= base_url() ?>EticketPromotion')"><?= language('ticket/promotion/promotion', 'tPmt_PmtHeaderText') ?></li>
                                <li class="xCNLinkClick"><?= language('ticket/promotion/promotion', 'tAddPromotion') ?></li>
                            </ol>
                        </div>
                        <div class="col-xs-12 col-md-4 text-right p-r-0">
                            <button type="button" onclick="JSxCallPage('<?= base_url() ?>EticketPromotion')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">	
                    <div class="panel panel-default" style="margin-bottom: 25px;"> 
                        <div id="odvHeadPromotion" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                            <label class="xCNTextDetail1"><?= language('ticket/promotion/promotion', 'tGeneralInformation') ?></label>
                            <a class="xCNMenuplus" role="button" data-toggle="collapse" data-parent="#odvSubGroupApp" href="#odvDataPromotion" aria-expanded="true">
                                <i class="fa fa-plus xCNPlus"></i>
                            </a>
                        </div>
                        <div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
                            <div class="panel-body xCNPDModlue">
                                <div class="upload-img" id="oImgUpload">
                                    <img src="<?php echo base_url('application/modules/common/assets/images/640x160.jpg'); ?>" style="width: 100%;" id="oimImgMasterMain">				 
                                    <span class="btn-file">
                                        <input type="hidden" name="ohdPmtImg" id="oetImgInputMain">
                                    </span>
                                </div>
                                <div class="xCNUplodeImage">
                                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main', '7/2')"><i class="fa fa-camera"></i> <?= language('common/main/main', 'tSelectPic') ?></button>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/promotion/promotion', 'tPromotionCode') ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control xWTooltipsBT xCNDisable" id="oetFTPmhCode" name="oetFTPmhCode" maxlength="10" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterPromotionCode') ?>" value="" readonly="readonly">
                                        <input type="hidden" name="ohdFTPmhCalType" id="ohdFTPmhCalType" value="2">
                                        <input type="hidden" name="ohdFTPmhType" id="ohdFTPmhType" value="2">
                                        <span class="input-group-btn">
                                            <button class="btn xCNBtnGenCode" type="button" id="oBtnGenCode" onclick="JSxBtnGen()">
                                                <i class="fa fa-magic"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/promotion/promotion', 'tPromotionName') ?></label>
                                    <input type="text" class="form-control" id="oetFTPmhName" name="oetFTPmhName">
                                </div>
                                <div class="row" style="margin-left: -15px; margin-right: -15px;">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterAMinimumOrder') ?>"><?= language('ticket/promotion/promotion', 'tMinimumOrder') ?></label>
                                            <input type="text" class="form-control" id="oetFCPmhBuyAmt" name="oetFCPmhBuyAmt">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm" data-validate="<?= language('ticket/promotion/promotion', 'tPleaseEnterADiscount') ?>"><?= language('ticket/promotion/promotion', 'tDiscount') ?></label>
                                            <input type="text" class="form-control" id="oetFCPmhGetValue" name="oetFCPmhGetValue">
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
                                                <option value="0"><?= language('ticket/promotion/promotion', 'tEnable') ?></option>
                                                <option value="1"><?= language('ticket/promotion/promotion', 'tDisabled') ?></option>
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
                                                <input type="text" class="form-control" id="oetFDPmhActivate" name="oetFDPmhActivate">
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
                                                <input type="text" class="form-control" id="oetFDPmhTActivate" name="oetFDPmhTActivate">
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
                                                <input type="text" class="form-control" id="oetFDPmhExpired" name="oetFDPmhExpired">
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
                                                <input type="text" class="form-control" id="oetFDPmhTExpired" name="oetFDPmhTExpired">
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
                                <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oPkgModal" type="button" onclick="JSxPkgCount()">+</span>
                            </div>
                            <input type="hidden" name="ohdFTPmhStaSpcPdt" id="ohdFTPmhStaSpcPdt" value="2">
                            <input type="hidden" name="ohdFTPspStaExcludePkg" id="ohdFTPspStaExcludePkg" value="2">
                            <div class="panel-body xCNPDModlue">
                                <table class="table table-hover" id="oTablePkg">
                                    <thead>
                                        <tr>
                                            <th><?= language('ticket/promotion/promotion', 'tNo') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tPackageName') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>	
                                        <tr id="otrPkg">
                                            <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                        </tr>
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
                                <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oBchModal" onclick="JSxBchCount()" type="button">+</span>
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
                                            <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (@$oBranch[0]->FNPmoID != ''): ?>
                                            <tr id="otrBch<?= @$oBranch[0]->FNPmoID ?>">
                                                <td>1</td>
                                                <td>
                                                    <?= @$oBranch[0]->FTPmoName ?>
                                                    <input type="hidden" id="ohdChkExcludeBch" value="2">
                                                    <input type="hidden" name="ohdFNPmoID[]" id="ohdFNPmoID" value="<?= @$oBranch[0]->FNPmoID ?>">
                                                    <input type="hidden" id="ohdBranchId" name="ohdBranchId[]" value="<?= @$oBranch[0]->FNPmoID ?>">
                                                </td>
                                                <td>เฉพาะสาขา</td>
                                                <td>
                                                    <img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="FSxDelBch('#otrBch<?= @$oBranch[0]->FNPmoID ?>');">
                                                </td>
                                            </tr>
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
                                <span class="xCNPmhBtnPlus" data-toggle="modal" data-target="#oGrpModal" onclick="JSxAgnCount(); JSxCstCount();" type="button">+</span>
                            </div>
                            <div class="panel-body xCNPDModlue">          
                                <input type="hidden" name="ohdFTPmhStaSpcGrp" id="ohdFTPmhStaSpcGrp" value="2">                     
                                <input type="hidden" name="ohdFTPsgStaExcludeGrp" id="ohdFTPsgStaExcludeGrp" value="2">
                                <table class="table table-hover" id="oTableGrp">
                                    <thead>
                                        <tr>
                                            <th><?= language('ticket/promotion/promotion', 'tNo') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tGroupName') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                                            <th><?= language('ticket/promotion/promotion', 'tPmt_DeleteText') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>	
                                        <tr id="otrGrp">
                                            <td align="center" colspan="4"><?= language('ticket/promotion/promotion', 'tNoInformationAvailable') ?></td>
                                        </tr>
                                    </tbody>
                                </table>							
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
                    <li class="active"><a data-toggle="tab" href="#oAgn">Agency</a></li>
                    <li><a data-toggle="tab" href="#oCst"><?= language('common/main/main', 'tPmt_PgpType2') ?></a></li>
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

        FSxDecimal("#oetFCPmhBuyAmt", 2);
        FSxDecimal("#oetFCPmhGetValue", 2);
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


    $("#oAddPmt").validate({
        rules: {
            oetFTPmhName: "required",
            oetFCPmhBuyAmt: "required",
            oetFCPmhGetValue: "required",
            oetFDPmhActivate: "required",
            oetFDPmhTActivate: "required",
            oetFDPmhTExpired: "required",
            oetFDPmhExpired: "required",
            oetFTPmhCode: {
                required: true,
                remote: {
                    url: "<?php echo base_url(); ?>EticketPromotionChkCode",
                    type: "post",
                    data: {
                        oetFTPmhCode: function () {
                            return $("#oetFTPmhCode").val();
                        }
                    },
                    complete: function (data) {
                        if (data.responseText == 'false') {
                            $('#oChkPmhCode').attr('data-validate', 'ไม่สามารถใช้รหัสโปรโมชั่นนี้ได้');;
                        }
                    }
                },
                complete: function (data) {
                }
            }
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
                url: "<?php echo base_url(); ?>EticketPromotionAddAjax",
                data: $("#oAddPmt").serialize(),
                cache: false,
                success: function (msg) {
                    var nDataId = $('.xWBtnSaveActive').data('id');
                    if (nDataId == '1') {
                        JSxCallPage('<?php echo base_url() ?>EticketPromotionEdit/' + msg);
                    } else if (nDataId == '2') {
                        JSxCallPage('<?= base_url() ?>EticketPromotionAdd');
                    } else if (nDataId == '3') {
                        JSxCallPage('<?php echo base_url('EticketPromotion') ?>');
                    }
                    var ptNameImg = $('#oetImgInputMain').val();
                    var ptFTPmhCode = $('#oetFTPmhCode').val();
                    // JSxGenImg(ptNameImg, ptFTPmhCode, msg, '<?= $this->session->tSesUsername ?>');

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