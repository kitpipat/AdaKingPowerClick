<input id="oetAreStaBrowse" type="hidden" value="<?php echo $nAreBrowseType?>">
<input id="oetAreCallBackOption" type="hidden" value="<?php echo $tAreBrowseOption?>">

<?php if(isset($nAreBrowseType) && $nAreBrowseType == 0) : ?>
    <div id="odvAreMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <li id="oliAreTitle" class="xCNLinkClick" onclick="JSvCallPageAreList()" style="cursor:pointer"><?php echo  language('address/area/area','tARETitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliAreTitleAdd" class="active"><a><?php echo  language('address/area/area','tAREAddArea')?></a></li>
                        <li id="oliAreTitleEdit" class="active"><a><?php echo  language('address/area/area','tARETitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnAreInfo">
                        <?php if($aAlwEventArea['tAutStaFull'] == 1 || $aAlwEventArea['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageAreAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageAreList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                        <?php if($aAlwEventArea['tAutStaFull'] == 1 || ($aAlwEventArea['tAutStaAdd'] == 1 || $aAlwEventArea['tAutStaEdit'] == 1)) : ?>
                        <div class="btn-group">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitAre').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNAreBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageAre" class="panel panel-headline"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tAreBrowseOption?>')" class="xWBtnPrevious xCNIconBack"  style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tAreBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('address/area/area','tARETitle')?></a></li>
                    <li class="active"><a><?php echo language('address/area/area','tAREAddArea')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitAre').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url(); ?>application/modules/address/assets/src/area/jArea.js"></script>