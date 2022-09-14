<div id="odvBchMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNBchVMaster">
                <div class="col-xs-8 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/promotion/promotion', 'tPmt_PmtHeaderText') ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn obtChoose" style="display: none;" type="button" onclick="FSxDelAllOnCheck();"> <?= language('common/main/main', 'tCMNDeleteAll') ?></button>
                        <input type="hidden" id="ohdIDCheckDel">
                    <?php endif; ?>	
                    <?php if ($oAuthen['tAutStaAdd'] == '1'): ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxCallPage('<?= base_url() ?>EticketPromotionAdd')">+</button>
                    <?php endif; ?>
                    </div>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-4" style="padding-left: 0;">
                        <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                            <label class="xCNLabelFrm"><?= language('common/main/main', 'tSearch') ?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTPmhName" name="oetFTPmhName" onkeyup="Javascript:if(event.keyCode==13) JSxPmtCount()">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPmtCount()" >
                                        <img class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
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
            <div id="oResultPmt"></div>			
            <div class="row" style="margin-right: -15px; margin-left: -15px;"> 	
                <div class="col-md-4 text-left grid-resultpage">
                    <?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalPmtRecord"> 0</span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: rgb(51, 51, 51); text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActivePmt">0</span> / <span id="ospTotalPagePmt">0</span></a>
                </div>                     
                <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
            </div>
        </div>
    </div>
</div>

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/promotion/jPromotion.js"></script>
<script type="text/javascript">
    $(function () {
        JSxPmtCount();
    });
</script>