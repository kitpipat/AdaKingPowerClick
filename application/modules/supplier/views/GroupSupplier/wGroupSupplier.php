<input id="oetSgpStaBrowse" type="hidden" value="<?= $nSgpBrowseType ?>">
<input id="oetSgpCallBackOption" type="hidden" value="<?= $tSgpBrowseOption ?>">

<?php if (isset($nSgpBrowseType) && $nSgpBrowseType == 0) : ?>
    <div id="odvSgpMainMenu" class="main-menu">
        <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNSgpVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <!-- เปลี่ยน -->
                            <?php FCNxHADDfavorite('groupsupplier/0/0'); ?>
                            <li id="oliSgpTitle" class="xCNLinkClick" onclick="JSvCallPageGroupSupplierList()" style="cursor:pointer"><?= language('supplier/groupsupplier/groupsupplier', 'tSGPTitle') ?></li> <!-- เปลี่ยน -->
                            <li id="oliSgpTitleAdd" class="active"><a><?= language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                            <li id="oliSgpTitleEdit" class="active"><a><?= language('supplier/groupsupplier/groupsupplier', 'tSGPTitleEdit') ?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <!-- เปลี่ยน -->
                        <div id="odvBtnSgpInfo">
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageGroupSupplierAdd()">+</button>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageGroupSupplierList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitGroupSupplier').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                    <?php echo $vBtnSave ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xCNSgpVBrowse">
                    <div class="col-xs-12 col-md-6">
                        <a onclick="JCNxBrowseData('<?php echo $tSgpBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                            <i class="fa fa-arrow-left xCNBackBowse"></i>
                        </a>
                        <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                            <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSgpBrowseOption ?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('supplier/groupsupplier/groupsupplier', 'tSGPTitle') ?></a></li>
                            <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right">
                        <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                            <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitGroupSupplier').click()"><?php echo  language('common/main/main', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNSgpBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageGroupSupplier"></div>
    </div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tSgpBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSgpBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('supplier/groupsupplier/groupsupplier', 'tSGPTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('supplier/groupsupplier/groupsupplier', 'tSGPTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitGroupSupplier').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvContentPageGroupSupplier"></div>
    </div>
<?php endif; ?>
<script src="<?php echo  base_url('application/modules/supplier/assets/src/groupsupplier/jGroupSupplier.js'); ?>"></script>