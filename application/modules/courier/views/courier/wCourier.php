<input id="oetCryStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCryCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div id="odvCryMainMenu" class="main-menu"> 
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNCryVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <?php FCNxHADDfavorite('courier/0/0');?> 
                        <li id="oliCryTitle" class="xCNLinkClick" style="cursor:pointer"><?= language('courier/courier/courier','tCRYTitle')?></li> 
                        <li id="oliCryTitleAdd" class="active"><a><?= language('courier/courier/courier','tCRYTitleAdd')?></a></li>
                        <li id="oliCryTitleEdit" class="active"><a><?= language('courier/courier/courier','tCRYTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0"> 
                    <div id="odvBtnCryInfo">
                        <?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus xWBTNCRYAdd" type="button">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn xWCRYBTNBackPage" data-page="1" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventCourier['tAutStaFull'] == 1 || ($aAlwEventCourier['tAutStaAdd'] == 1 || $aAlwEventCourier['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtCrySubmit').click()"> <?php echo language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSaveCourier?>
							</div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNCryBrowseLine" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
    <div id="odvContentPageCourier" class="panel panel-headline"></div>
</div>
<script src="<?=base_url('application/modules/courier/assets/src/courier/jCourier.js')?>"></script>
<script>
    $('#oliCryTitle').click(function(){
        JSvCallPageCourierList();
    });
    $('.xWCRYBTNBackPage').click(function(){
        var tPage = $(this).data('page');
        JSvCallPageCourierList(tPage);
    });
    $('.xWBTNCRYAdd').click(function(){
        JSvCallPageCourierAdd();
    });
</script>