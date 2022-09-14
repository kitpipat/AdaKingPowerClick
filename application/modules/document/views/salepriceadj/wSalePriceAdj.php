<style>
    .xWTdDisable {
        cursor: not-allowed !important;
        opacity: 0.4 !important;
    }

    .xWImgDisable {
        cursor: not-allowed !important;
        pointer-events: none;
    }
</style>

<input id="oetSpaStaBrowse" type="hidden" value="<?=$nSpaBrowseType?>">
<input id="oetSpaCallBackOption" type="hidden" value="<?=$tSpaBrowseOption?>">

<?php if(isset($nSpaBrowseType) && $nSpaBrowseType == 0) { ?>
    <div id="odvSpaMainMenu" class="main-menu"> 
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNSpaVMaster">
                    <div class="col-xs-12 col-md-6">
                        <ol id="oliMenuNav" class="breadcrumb"> 
                            <?php FCNxHADDfavorite('dcmSPA/0/0');?> 
                            <li id="oliSpaTitle" class="xCNLinkClick" style="cursor:pointer"><?= language('document/salepriceadj/salepriceadj','tSpaTitle')?></li> 
                            <li id="oliSpaTitleAdd" class="active"><a><?= language('document/salepriceadj/salepriceadj','tSpaTitleAdd')?></a></li>
                            <li id="oliSpaTitleEdit" class="active"><a><?= language('document/salepriceadj/salepriceadj','tSpaTitleEdit')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right p-r-0"> 
                        <div id="odvBtnSpaInfo">
                            <?php if($aAlwEventSalePriceAdj['tAutStaFull'] == 1 || $aAlwEventSalePriceAdj['tAutStaAdd'] == 1) : ?>
                                <button id="obtSpaBtnAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif;?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtBtnBack" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tBack')?></button>
                                <button id="obtBtnPrint" onclick="JSvADJPricePrintDoc();" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint')?></button>
                                <button id="obtBtnSpaCancel" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('document/salepriceadj/salepriceadj','tBtnSpaCancel')?></button>
                                <button id="obtBtnSpaApv" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?= language('document/salepriceadj/salepriceadj','tBtnSpaUsrApv')?></button>
                                <?php if($aAlwEventSalePriceAdj['tAutStaFull'] == 1 || ($aAlwEventSalePriceAdj['tAutStaAdd'] == 1 || $aAlwEventSalePriceAdj['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button id="obtSubmit" type="button" name="obtSubmit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSpa').click()"> <?=language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="xCNMenuCump xCNSpaBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvContentPageSpa"></div>
    </div>
<?php }else{ ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tSpaBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliSpaNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tSpaBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('document/salepriceadj/salepriceadj','tSPATitle')?></a></li>
                    <li class="active"><a><?php echo language('document/salepriceadj/salepriceadj','tSPATitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvSpaBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCard').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php } ?>

<script src="<?= base_url('application/modules/document/assets/src/salepriceadj/jSalePriceAdj.js')?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/TableDnD/0.9.1/jquery.tablednd.js" integrity="sha256-d3rtug+Hg1GZPB7Y/yTcRixO/wlI78+2m08tosoRn7A=" crossorigin="anonymous"></script>
<script> var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>; </script>

<script>
    $('#obtBtnBack').click(function(){
        JSvCallPageSpaList();
    });
    $('#obtSpaBtnAdd').click(function(){
        JSvCallPageSpaAdd();
    });
    $('#oliSpaTitle').click(function(){
        JSvCallPageSpaList();
    });
</script>
