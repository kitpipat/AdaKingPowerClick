<input id="oetSplStaBrowse" type="hidden" value="<?php echo $nSplBrowseType?>">
<input id="oetSplCallBackOption" type="hidden" value="<?php echo $tSplBrowseOption?>">

<?php if(isset($nSplBrowseType) && $nSplBrowseType == 0) : ?>
    <div id="odvSplMenuTitle" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('supplier/0/0');?>
                        <li id="oliSplTitle" class="xCNLinkClick" onclick="JSvCallPageSupplierList()" style="cursor:pointer"><?= language('supplier/supplier/supplier','tSPLTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliSplTitleAdd" class="active"><a><?= language('supplier/supplier/supplier','tSPLTitleAdd')?></a></li>
                        <li id="oliSplTitleEdit" class="active"><a><?= language('supplier/supplier/supplier','tSPLTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnSplInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSupplierAdd()">+</button>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPageSupplierList()"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <div class="btn-group xWBtnHide">
                                <button id="odvBtnGroup" type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitsupplier').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                                <?php echo $vBtnSave?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNSplBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageSupplier" class="panel panel-headline"></div>
    </div>


<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tSplBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSplBrowseOption?>')"><a>แสดงข้อมูล : <?= language('supplier/supplier/supplier','tSPLTitle')?></a></li>
                    <li class="active"><a><?php echo  language('supplier/supplier/supplier','tSPLTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right xWBtnHide">
                <div id="odvBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitsupplier').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/supplier/assets/src/supplier/jSupplier.js')?>"></script>
