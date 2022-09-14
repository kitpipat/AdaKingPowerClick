<input id="oetCrdStaBrowse" type="hidden" value="<?php echo $nCrdBrowseType?>">
<input id="oetCrdCallBackOption" type="hidden" value="<?php echo $tCrdBrowseOption?>">

<?php if(isset($nCrdBrowseType) && $nCrdBrowseType == 0) : ?>
    <div id="odvCrdMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('card/0/0');?> 
                        <li id="oliCrdTitle" class="xCNLinkClick" onclick="JSvCallPageCardList()" style="cursor:pointer"><?php echo language('payment/card/card','tCRDTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliCrdTitleAdd" class="active"><a><?php echo language('payment/card/card','tCRDTitleAdd')?></a></li>
                        <li id="oliCrdTitleEdit" class="active"><a><?php echo language('payment/card/card','tCRDTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnCrdInfo">
                        <?php if($aAlwEventCard['tAutStaFull'] == 1 || $aAlwEventCard['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageCardList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                        <?php if($aAlwEventCard['tAutStaFull'] == 1 || ($aAlwEventCard['tAutStaAdd'] == 1 || $aAlwEventCard['tAutStaEdit'] == 1)) : ?>
                        <div class="btn-group">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCard').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCrdBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageCard" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCrdBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCrdBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('payment/card/card','tCRDTitle')?></a></li>
                    <li class="active"><a><?php echo language('payment/card/card','tCRDTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCard').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url(); ?>application/modules/payment/assets/src/card/jCard.js"></script>