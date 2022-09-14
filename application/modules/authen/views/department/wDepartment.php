<input id="oetDptStaBrowse" type="hidden" value="<?=$nDptBrowseType?>">
<input id="oetDptCallBackOption" type="hidden" value="<?=$tDptBrowseOption?>">

<?php if(isset($nDptBrowseType) && $nDptBrowseType == 0) : ?>
    <div id="odvDptMainMenu" class="main-menu"> 
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <?php FCNxHADDfavorite('department/0/0');?> 
                        <li id="oliDptTitle" class="xCNLinkClick" onclick="JSvCallPageDptList()" style="cursor:pointer"><?php echo language('authen/department/department','tDPTTitle'); ?></li> <!-- เปลี่ยน -->
                        <li id="oliDptTitleAdd" class="active"><a><?php echo language('authen/department/department','tDPTTitleAdd'); ?></a></li>
                        <li id="oliDptTitleEdit" class="active"><a><?php echo language('authen/department/department','tDPTTitleEdit'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> 
                    <div id="odvBtnDptInfo">
                    <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageDptAdd()">+</button>
                    <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageDptList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                        <?php if($aAlwEventDepartment['tAutStaFull'] == 1 || ($aAlwEventDepartment['tAutStaAdd'] == 1 || $aAlwEventDepartment['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitDpt').click()"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                <?php echo $vBtnSave?>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNDptBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageDpt" class="panel panel-headline"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tDptBrowseOption; ?>')" class="xWBtnPrevious xCNIconBack"  style="float:left;font-size:19px;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                  
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tDptBrowseOption; ?>')"><a><?php echo language('common/main/main','tShowData'); ?> : <?php echo language('authen/department/department','tDPTTitle'); ?></a></li>
                    <li class="active"><a><?php echo language('authen/department/department','tDptAddDpta'); ?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitDpt').click()"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/authen/assets/src/department/jDepartment.js'); ?>"></script>
