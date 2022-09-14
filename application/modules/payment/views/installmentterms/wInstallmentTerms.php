<input id="oetStmStaBrowse" type="hidden" value="<?= $nStmBrowseType ?>">
<input id="oetStmCallBackOption" type="hidden" value="<?= $tStmBrowseOption ?>">

<?php if (isset($nStmBrowseType) && $nStmBrowseType == 0) : ?>
    <div id="odvStmMainMenu" class="main-menu">
        <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNStmVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <!-- เปลี่ยน -->
                            <?php FCNxHADDfavorite('masInstallmentTerms/0/0'); ?>
                            <li id="oliStmTitle" class="xCNLinkClick" onclick="JSvStmCallPageList()" style="cursor:pointer"><?= language('payment/installmentterms/installmentterms', 'tSTMTitle') ?></li> <!-- เปลี่ยน -->
                            <li id="oliStmTitleAdd" class="active"><a><?= language('payment/installmentterms/installmentterms', 'tSTMTitleAdd') ?></a></li>
                            <li id="oliStmTitleEdit" class="active"><a><?= language('payment/installmentterms/installmentterms', 'tSTMTitleEdit') ?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <!-- เปลี่ยน -->
                        <div id="odvBtnStmInfo">
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvStmCallPageAdd()">+</button>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvStmCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack') ?></button>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtStmSubmit').click()"> <?php echo language('common/main/main', 'tSave') ?></button>
                                    <?php echo $vBtnSave ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="xCNStmVBrowse">
                    <div class="col-xs-12 col-md-6">
                        <a onclick="JCNxBrowseData('<?php echo $tStmBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                            <i class="fa fa-arrow-left xCNBackBowse"></i>
                        </a>
                        <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                            <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tStmBrowseOption ?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('payment/installmentterms/installmentterms', 'tSTMTitle') ?></a></li>
                            <li class="active"><a><?php echo  language('payment/installmentterms/installmentterms', 'tSTMTitleAdd') ?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right">
                        <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                            <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtStmSubmit').click()"><?php echo  language('common/main/main', 'tSave') ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNStmBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvStmContentPage"></div>
    </div>
<?php else : ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tStmBrowseOption ?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tStmBrowseOption ?>')"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('payment/installmentterms/installmentterms', 'tSTMTitle') ?></a></li>
                    <li class="active"><a><?php echo  language('payment/installmentterms/installmentterms', 'tSTMTitleAdd') ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtStmSubmit').click()"><?php echo language('common/main/main', 'tSave') ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div id="odvStmContentPage"></div>
    </div>
<?php endif; ?>
<script src="<?php echo  base_url('application/modules/payment/assets/src/installmentterms/jInstallmentTerms.js'); ?>"></script>
