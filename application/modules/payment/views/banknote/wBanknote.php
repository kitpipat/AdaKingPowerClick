<input id="oetBntStaBrowse" type="hidden" value="<?=$nBntBrowseType?>">
<input id="oetBntCallBackOption" type="hidden" value="<?=$tBntBrowseOption?>">

<?php if(isset($nBntBrowseType) && $nBntBrowseType == 0) : ?>
    <div id="odvBntMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                            <?php FCNxHADDfavorite('banknote/0/0');?> 
                            <li id="oliBntTitle" class="xCNLinkClick" onclick="JSvCallPageBntList()" style="cursor:pointer"><?php echo language('payment/banknote/banknote','tBNTTitle'); ?></li> <!-- เปลี่ยน -->
                            <li id="oliBntTitleAdd" class="active"><a><?php echo language('payment/banknote/banknote','tBNTTitleAdd'); ?></a></li>
                            <li id="oliBntTitleEdit" class="active"><a><?php echo language('payment/banknote/banknote','tBNTTitleEdit'); ?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> <!-- เปลี่ยน -->
                        <div id="odvBtnBntInfo">
                        <?php if($aAlwEventBankNote['tAutStaFull'] == 1 || ($aAlwEventBankNote['tAutStaAdd'] == 1 || $aAlwEventBankNote['tAutStaEdit'] == 1)) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBntAdd()">+</button>
                        <?php endif;?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <button onclick="JSvCallPageBntList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if($aAlwEventBankNote['tAutStaFull'] == 1 || ($aAlwEventBankNote['tAutStaAdd'] == 1 || $aAlwEventBankNote['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitBnt').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNBntBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageBnt" class="panel panel-headline"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tBntBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack"  style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBntBrowseOption; ?>')"><a><?php echo language('common/main/main','tShowData'); ?> : <?php echo language('payment/banknote/banknote','tBNTTitleAdd'); ?></a></li>
                    <li class="active"><a><?php echo language('payment/banknote/banknote','tBntAddBnta'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBnt').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/payment/assets/src/banknote/jBanknote.js')?>"></script>
