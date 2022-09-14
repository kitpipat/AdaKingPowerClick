<div id="odvBchMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNBchVMaster">
                <div class="col-xs-8 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSvBCHCallPageBranchList()"><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxCallPage('<?= base_url() ?>EticketAddBranch')">+</button>
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
                <div class="col-xs-8 col-md-4 col-lg-4">
                    <div id="odvMenuSearch">
                        <div class="form-group"> 
                            <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                            <div class="input-group">
                                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTPmoName" name="oetFTPmoName" onkeyup="Javascript:if(event.keyCode==13) JSxPRKCountSearch()" value="<?=@$tSearch?>">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPRKCountSearch()" >
                                        <img class="xCNIconAddOn" src="<?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
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
        <div class="row">
            <div id="oResultPark"></div>
                <div id ="odvWGridFooter">		
                    <div class="col-md-4 text-left grid-resultpage"><?= language('ticket/zone/zone', 'tFound') ?> <span id="ospTotalRecord"><?= $aPark[0]->counts ?></span> <?= language('ticket/zone/zone', 'tList') ?> <a class="xWBoxLocPark" style="color: #333; text-decoration: none;"><?= language('ticket/zone/zone', 'tShowpage') ?> <span id="ospPageActive">1</span> / <span id="ospTotalPage"><?= ceil($aPark[0]->counts / 8) ?></span></a></div>                   
                    <div class="col-md-8 text-right xWGridFooter xWBoxLocPark"></div>
                </div>	
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
<!-- END Load Lang Eticket -->

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/branch/jParkNew.js"></script>
<script>
    window.onload = JSxPRKCountSearch();
</script>