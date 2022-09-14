<style>
#otbSRTModuleReport thead tr:first-child {
    background-color: #1D2530 !important;
}

.xWwhite {
    color: #FFFFFF !important;
}

.xWTdDisable {
    cursor: not-allowed !important;
    opacity: 0.4 !important;
}

.xWImgDisable {
    pointer-events: none;
}
</style>

<div id="odvSRTSettingReport" class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="form-group">
            <label class="xCNLabelFrm">
                <?php echo language('settingconfig/settingmenu/settingmenu', 'tSettigReportTitle'); ?></label>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="otbSRTModuleReport" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th id="othSRTAddModuleReport" nowrap style="width:3%;text-align:center;"
                                    class="xWTableth" value="">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReportModule'); ?></label>
                                    <div class="xWwhite" style="float:right;">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                </th>
                                <th nowrap id="othSRTAddReportGrp" style="width:3%;text-align:center;"
                                    class="xWTableth">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReportGroup'); ?></label>
                                    <div class="xWwhite" style="float:right;">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                </th>
                                <th nowrap id="othSRTAddReportList" style="width:3%;text-align:center;"
                                    class="xWTableth">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReport_Menu'); ?></label>
                                    <div class="xWwhite" style="float:right;">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                </th>
                                <th nowrap style="width:5%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuStatus'); ?></label>
                                </th>
                                <th nowrap style="width:2%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuDelete'); ?></label>
                                </th>
                                <th nowrap style="width:2%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuEdit'); ?></label>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3">
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote"
                                        id="oetRSTSearchAll" name="oetRSTSearchAll" autocomplete="off"
                                        onkeypress="if (event.keyCode == 13) {return false;}"
                                        placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                                </th>
                                <th nowrap style="width:5%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuStatus'); ?></label>
                                </th>
                                <th nowrap style="width:2%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuDelete'); ?></label>
                                </th>
                                <th nowrap style="width:2%;text-align:center;" class="xWTableth"><label
                                        class="xCNLabelFrm"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuEdit'); ?></label>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="otbSRTDataBody">
                            <?php if($aDataMenuList['rtCode'] != '1'){?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='6'>
                                    <?= language('common/main/main','tCMNNotFoundData')?></td>
                            </tr>
                            <?php }else{ ?>
                            <?php $aModuleRptCode = "";?>
                            <?php $aGmnRptCode = "";?>
                            <?php $aMnuRptCode = "";?>
                            <?php foreach($aDataMenuList['raItems'] AS $key => $aValue):?>
                            <?php if($aModuleRptCode != $aValue['FTGrpRptModCode']):?>
                            <tr class="xWHeardGmnMod">
                                <td nowrap="" colspan="3" class="xCNReportGrpModule"
                                    onClick="FSxSRTTableTree(1,'<?php echo $aValue['FTGrpRptModCode'];?>','xCNDataReportGrpModule','xCNPlusReportGrpModule')"
                                    data-mgm="<?php echo $aValue['FTGrpRptModCode'];?>">
                                    <i class="fa fa-plus xCNPlusReportGrpModule"
                                        data-mgm="<?php echo $aValue['FTGrpRptModCode'];?>"></i>
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php echo $aValue['FTGrpRptModCode'];?> -
                                        <?php echo $aValue['FNGrpRptModName'];?></label>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll">
                                    <label class="fancy-checkbox xWCheckAll">
                                        <?php if($aValue['FTGrpRptModStaUse'] != 0){?>
                                        <input class="xWOcbCheckAll" type="checkbox"
                                            module="<?php echo $aValue['FTGrpRptModCode'];?>"
                                            id="<?php echo $aValue['FTGrpRptModCode'];?>" checked
                                            onclick="FSxSRTUpdateStaUseModuleReport('<?php echo $aValue['FTGrpRptModCode'];?>')">
                                        <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                        <?php }else{ ?>
                                        <input class="xWOcbCheckAll" type="checkbox"
                                            module="<?php echo $aValue['FTGrpRptModCode'];?>"
                                            id="<?php echo $aValue['FTGrpRptModCode'];?>"
                                            onclick="FSxSRTUpdateStaUseModuleReport('<?php echo $aValue['FTGrpRptModCode'];?>')">
                                        <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                        <?php }?>
                                    </label>
                                </td>
                                <?php if($aValue['FTGrpRptModStaUse'] != 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmod="<?php echo $aValue['FTGrpRptModCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmod="<?php echo $aValue['FTGrpRptModCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSRTModuleDel('<?php echo $aValue['FTGrpRptModCode'];?>','<?php echo $aValue['FNGrpRptModName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php }else{ ?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmod="<?php echo $aValue['FTGrpRptModCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmod="<?php echo $aValue['FTGrpRptModCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSRTModuleDel('<?php echo $aValue['FTGrpRptModCode'];?>','<?php echo $aValue['FNGrpRptModName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSRTCallModalEditModulRpt('<?php echo $aValue['FTGrpRptModCode'];?>')">
                                </td>
                            </tr>
                            <?php endif;?>

                            <?php if($aGmnRptCode != $aValue['FTGrpRptCode']):?>
                            <?php if($aValue['FTRptStaUse'] != NULL || $aValue['FTGrpRptStaUse'] != NULL):?>
                            <tr class="hidden xCNDataReportGrpModule"
                                data-mgm="<?php echo $aValue['FTGrpRptModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap="" colspan="2" class="xCNReportGrp"
                                    onClick="FSxSRTTableTree(2,'<?php echo $aValue['FTGrpRptCode'];?>','MenuList','xCNPlusReportGrp')"
                                    data-mgm="<?php echo $aValue['FTGrpRptCode'];?>">
                                    <i class="fa fa-plus xCNPlusReportGrp"
                                        data-mgm="<?php echo $aValue['FTGrpRptCode'];?>"
                                        data-smc="<?php echo $aValue['FTGrpRptModCode'];?>"></i>
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php if($aValue['FTGrpRptStaUse'] != NULL):?>
                                        <?php if($aValue['FTGrpRptName'] != NULL):?>
                                        <?php echo $aValue['FTGrpRptCode'];?> - <?php echo $aValue['FTGrpRptName'];?>
                                        <?php else : ?>
                                        <?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuNotfoundName');?>
                                        <?php endif;?>
                                        <?php else : ?>
                                        <?php echo 'N/A' ?>
                                        <?php endif;?>
                                    </label>
                                </td>
                                <?php if($aValue['FTGrpRptStaUse'] != NULL):?>
                                <td nowrap="" class="xWHeardRoleAll">
                                    <?php if($aValue['FTGrpRptModStaUse'] == 0){?>
                                    <label class="fancy-checkbox xWCheckAll hidden"
                                        data-grp="<?php echo $aValue['FTGrpRptModCode'];?>">
                                        <?php } else{?>
                                        <label class="fancy-checkbox xWCheckAll"
                                            data-grp="<?php echo $aValue['FTGrpRptModCode'];?>">
                                            <?php } ?>

                                            <?php if($aValue['FTGrpRptStaUse'] != 0){?>
                                            <input class="xWOcbCheckAll" type="checkbox" checked
                                                test="<?php echo $aValue['FTGrpRptModCode'];?>"
                                                menugrp="<?php echo $aValue['FTGrpRptCode'];?>"
                                                id="<?php echo $aValue['FTGrpRptCode'];?>"
                                                onclick="FSxSMUUpdateStaUse(2,'TSysReportGrp','FTGrpRptCode','FTGrpRptStaUse','<?php echo $aValue['FTGrpRptCode'];?>')">
                                            <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                            <?php }else{ ?>
                                            <input class="xWOcbCheckAll" type="checkbox"
                                                test="<?php echo $aValue['FTGrpRptModCode'];?>"
                                                menugrp="<?php echo $aValue['FTGrpRptCode'];?>"
                                                id="<?php echo $aValue['FTGrpRptCode'];?>"
                                                onclick="FSxSMUUpdateStaUse(2,'TSysReportGrp','FTGrpRptCode','FTGrpRptStaUse','<?php echo $aValue['FTGrpRptCode'];?>')">
                                            <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                            <?php }?>
                                        </label>
                                </td>
                                <?php if($aValue['FTGrpRptStaUse'] == 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmenugrp="<?php echo $aValue['FTGrpRptCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmenugrp="<?php echo $aValue['FTGrpRptCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSRTMenuGrpDel('<?php echo $aValue['FTGrpRptCode'];?>','<?php echo $aValue['FTGrpRptName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } else{?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmenugrp="<?php echo $aValue['FTGrpRptCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmenugrp="<?php echo $aValue['FTGrpRptCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSRTMenuGrpDel('<?php echo $aValue['FTGrpRptCode'];?>','<?php echo $aValue['FTGrpRptName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>

                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSRTCallModalEditRptGrp('<?php echo $aValue['FTGrpRptCode'];?>','<?php echo $aValue['FNGrpRptModName'];?>')">
                                </td>
                                <?php else : ?>
                                <td nowrap="" colspan="3">
                                </td>
                                <?php endif;?>
                            </tr>
                            <?php else : ?>
                            <tr class="hidden xCNDataReportGrpModule"
                                data-mgm="<?php echo $aValue['FTGrpRptModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap="" class="xCNReportGrp" colspan="2">
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuNotfoundGrpMenu');?></label>
                                </td>
                                <td nowrap="" colspan="5"></td>
                            </tr>
                            <?php endif;?>
                            <?php endif;?>


                            <?php if($aMnuRptCode != $aValue['FTRptCode']){?>
                            <?php if($aValue['FTRptStaUse'] != NULL || $aValue['FTGrpRptStaUse'] != NULL){?>
                            <tr class="MenuList  xCNDataRole hidden" data-mgm="<?php echo $aValue['FTGrpRptCode'];?>"
                                data-smc="<?php echo $aValue['FTGrpRptModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap=""></td>
                                <?php if($aValue['FTRptStaUse'] != NULL):?>
                                <td nowrap="">
                                    <?php echo $aValue['FTRptCode'];?> - <?php echo $aValue['FTRptName'];?></label>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll">


                                    <?php if($aValue['FTGrpRptModStaUse'] == 0){?>
                                    <label class="fancy-checkbox xWCheckAll hidden"
                                        data-id="<?php echo $aValue['FTGrpRptCode'];?>"
                                        data-mod="<?php echo $aValue['FTGrpRptModCode'];?>">
                                        <?php } ?>
                                        <?php if($aValue['FTGrpRptStaUse'] == 0 && $aValue['FTGrpRptStaUse'] != NULL){?>
                                        <label class="fancy-checkbox xWCheckAll hidden"
                                            data-id="<?php echo $aValue['FTGrpRptCode'];?>"
                                            data-mod="<?php echo $aValue['FTGrpRptModCode'];?>">
                                            <?php } else{?>
                                            <label class="fancy-checkbox xWCheckAll"
                                                data-id="<?php echo $aValue['FTGrpRptCode'];?>"
                                                data-mod="<?php echo $aValue['FTGrpRptModCode'];?>">
                                                <?php } ?>

                                                <?php if($aValue['FTRptStaUse'] != 0){?>
                                                <input class="xWOcbCheckAll" type="checkbox" checked
                                                    menulist="<?php echo $aValue['FTRptCode'];?>"
                                                    name="<?php echo $aValue['FTRptCode'];?>"
                                                    onclick="FSxSMUUpdateStaUse(3,'TSysReport','FTRptCode','FTRptStaUse','<?php echo $aValue['FTRptCode'];?>')">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>

                                                <?php }else{?>
                                                <input class="xWOcbCheckAll" type="checkbox"
                                                    menulist="<?php echo $aValue['FTRptCode'];?>"
                                                    name="<?php echo $aValue['FTRptCode'];?>"
                                                    onclick="FSxSMUUpdateStaUse(3,'TSysReport','FTRptCode','FTRptStaUse','<?php echo $aValue['FTRptCode'];?>')">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                                <?php }?>
                                            </label>
                                </td>

                                <?php if($aValue['FTRptStaUse'] == 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmenulist="<?php echo $aValue['FTRptCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmenulist="<?php echo $aValue['FTRptCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSTRRptMenuDel('<?php echo $aValue['FTRptCode'];?>','<?php echo $aValue['FTRptName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } else{?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmenulist="<?php echo $aValue['FTRptCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmenulist="<?php echo $aValue['FTRptCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSTRRptMenuDel('<?php echo $aValue['FTRptCode'];?>','<?php echo $aValue['FTRptName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>

                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSRTCallModalEditRptMenu('<?php echo $aValue['FTRptCode'];?>','<?php echo $aValue['FTRptName'];?>')">
                                </td>
                            </tr>
                            <?php else : ?>
                            <td nowrap="">
                                <?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuNotfoundMenu');?>
                            </td>
                            <td nowrap="" colspan="3"></td>

                            <?php endif;?>


                            <?php } ?>
                            <?php } ?>
                            <?php $aModuleRptCode = $aValue['FTGrpRptModCode']; ?>
                            <?php $aGmnRptCode = $aValue['FTGrpRptCode']; ?>
                            <?php $aMnuRptCode = $aValue['FTRptCode']; ?>
                            <?php endforeach;?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
        </div>

    </div>
</div>

<div class="modal fade" id="odvSRTModalDelModuleReport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <div id="ospConfirmDelete" class="xCNTextModal"></div>
                <p><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteStatus'); ?></p>
                <ul>
                    <li><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteRptStatus1'); ?>
                    </li>
                    <li><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteRptStatus2'); ?>
                    </li>
                </ul>
                <p class="text-danger">
                    <strong><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteRptStatus3'); ?></strong>
                </p>
                <input type='hidden' id="ohdSRTConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmSRTConfirm" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include('wSettingreportModule.php');?>
<?php include('wSettingreportGrp.php');?>
<?php include('wSettingreportMenu.php');?>
<?php include 'script/jSettingreportTable.php';?>
<script>
function FSxSRTUpdateStaUseModuleReport(tFTGmnCode) {
    var tCode = 'RPT'+tFTGmnCode;
    if ($('input[module=' + tFTGmnCode + ']').is(':checked')) {
        nValueStaUse = 1;
    } else {
        nValueStaUse = 0;
    }
    $.ajax({
        type: "POST",
        url: "UpdateStaUse",
        data: {
            tTableName: 'TSysMenuList',
            tFieldWhere: 'FTMnuCode',
            tFieldName: 'FTMnuStaUse',
            tCode: tCode,
            nValue: nValueStaUse
        },
        async: false,
        cache: false,
        timeout: 0,
        success: function(tResult) {
            FSxSMUUpdateStaUse(1, 'TSysReportModule', 'FTGrpRptModCode', 'FTGrpRptModStaUse', tFTGmnCode);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
</script>