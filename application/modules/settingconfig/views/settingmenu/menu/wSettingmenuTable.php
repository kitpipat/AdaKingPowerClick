<style>
#otbModuleMenu thead tr:first-child {
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

<div id="odvSMPSettingMenu" class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="form-group">
            <label class="xCNLabelFrm"> <?php echo language('settingconfig/settingmenu/settingmenu', 'tSettigMenuTitle'); ?></label>
        </div>
        <div id="odvMenuList" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="table-responsive">
                    <table id="otbModuleMenu" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th id="othSMPAddModule" nowrap style="width:3%;text-align:center;" class="xWTableth"
                                    value="">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuModule'); ?></label>
                                    <div class="xWwhite" style="float:right;">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                </th>
                                <th nowrap id="othSMPAddMenuGrp" style="width:3%;text-align:center;" class="xWTableth">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuGroup'); ?></label>
                                    <div class="xWwhite" style="float:right;">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                </th>
                                <th nowrap id="othSMPAddMenuList" style="width:3%;text-align:center;" class="xWTableth">
                                    <label
                                        class="xCNLabelFrm xWwhite"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenu_Menu'); ?></label>
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
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll"
                                        name="oetSearchAll" autocomplete="off"
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
                        <tbody id="otbSMPDataBody">
                            <?php if($aDataMenuList['rtCode'] != '1'){?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='6'>
                                    <?= language('common/main/main','tCMNNotFoundData')?></td>
                            </tr>
                            <?php }else{ ?>
                            <?php $aModuleCode = "";?>
                            <?php $aGmnCode = "";?>
                            <?php $aMnuCode = "";?>
                            <?php foreach($aDataMenuList['raItems'] AS $key => $aValue):?>
                            <?php if($aModuleCode != $aValue['FTGmnModCode']):?>
                            <tr class="xWHeardGmnMod">
                                <td nowrap="" colspan="3" class="xCNMenuGrpModule"
                                    data-mgm="<?php echo $aValue['FTGmnModCode'];?>">
                                    <?php if($aValue['FTGmnModCode'] != 'RPT'){?>
                                    <i class="fa fa-plus xCNPlusMenuGrpModule"
                                        data-mgm="<?php echo $aValue['FTGmnModCode'];?>"></i>
                                        <?php } ?>
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php echo $aValue['FTGmnModCode'];?> -
                                        <?php echo $aValue['FTGmnModName'];?></label>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll">
                                    <label class="fancy-checkbox xWCheckAll">
                                        <?php if($aValue['FTGmnModStaUse'] != 0){?>
                                        <input class="xWOcbCheckAll" type="checkbox"
                                            module="<?php echo $aValue['FTGmnModCode'];?>"
                                            id="<?php echo $aValue['FTGmnModCode'];?>" checked
                                            onclick="FSxSMUUpdateStaUse(1,'TSysMenuGrpModule','FTGmnModCode','FTGmnModStaUse','<?php echo $aValue['FTGmnModCode'];?>')">
                                        <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                        <?php }else{ ?>
                                        <input class="xWOcbCheckAll" type="checkbox"
                                            module="<?php echo $aValue['FTGmnModCode'];?>"
                                            id="<?php echo $aValue['FTGmnModCode'];?>"
                                            onclick="FSxSMUUpdateStaUse(1,'TSysMenuGrpModule','FTGmnModCode','FTGmnModStaUse','<?php echo $aValue['FTGmnModCode'];?>')">
                                        <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                        <?php }?>
                                    </label>
                                </td>
                                <?php if($aValue['FTGmnModStaUse'] != 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmod="<?php echo $aValue['FTGmnModCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmod="<?php echo $aValue['FTGmnModCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUModuleDel('<?php echo $aValue['FTGmnModCode'];?>','<?php echo $aValue['FTGmnModName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php }else{ ?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmod="<?php echo $aValue['FTGmnModCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmod="<?php echo $aValue['FTGmnModCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUModuleDel('<?php echo $aValue['FTGmnModCode'];?>','<?php echo $aValue['FTGmnModName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSMUCallModalModulEdit('<?php echo $aValue['FTGmnModCode'];?>')">
                                </td>
                            </tr>
                            <?php endif;?>

                            <?php if($aValue['FTGmnModCode'] != 'RPT'){?>
                            <?php if($aGmnCode != $aValue['FTGmnCode']):?>
                            <?php if($aValue['FTMnuStaUse'] != NULL || $aValue['FTGmnStaUse'] != NULL):?>
                            <tr class="hidden xCNDataMenuGrpModule" data-mgm="<?php echo $aValue['FTGmnModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap="" colspan="2" class="xCNMenuGrp"
                                    data-mgm="<?php echo $aValue['FTGmnCode'];?>">
                                    <i class="fa fa-plus xCNPlusMenuGrp" data-mgm="<?php echo $aValue['FTGmnCode'];?>"
                                        data-smc="<?php echo $aValue['FTGmnModCode'];?>"></i>
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php if($aValue['FTGmnStaUse'] != NULL):?>
                                        <?php if($aValue['FTGmnName'] != NULL):?>
                                        <?php echo $aValue['FTGmnCode'];?> - <?php echo $aValue['FTGmnName'];?>
                                        <?php else : ?>
                                        <?php echo $aValue['FTGmnCode'];?> - <?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuNotfoundName');?>
                                        <?php endif;?>
                                        <?php else : ?>
                                        <?php echo 'N/A' ?>
                                        <?php endif;?>
                                    </label>
                                </td>
                                <?php if($aValue['FTGmnStaUse'] != NULL):?>
                                <td nowrap="" class="xWHeardRoleAll">
                                    <?php if($aValue['FTGmnModStaUse'] == 0){?>
                                    <label class="fancy-checkbox xWCheckAll hidden"
                                        data-grp="<?php echo $aValue['FTGmnModCode'];?>">
                                        <?php } else{?>
                                        <label class="fancy-checkbox xWCheckAll"
                                            data-grp="<?php echo $aValue['FTGmnModCode'];?>">
                                            <?php } ?>

                                            <?php if($aValue['FTGmnStaUse'] != 0){?>
                                            <input class="xWOcbCheckAll" type="checkbox" checked
                                                test="<?php echo $aValue['FTGmnModCode'];?>"
                                                menugrp="<?php echo $aValue['FTGmnCode'];?>"
                                                id="<?php echo $aValue['FTGmnCode'];?>"
                                                onclick="FSxSMUUpdateStaUse(2,'TSysMenuGrp','FTGmnCode','FTGmnStaUse','<?php echo $aValue['FTGmnCode'];?>')">
                                            <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                            <?php }else{ ?>
                                            <input class="xWOcbCheckAll" type="checkbox"
                                                test="<?php echo $aValue['FTGmnModCode'];?>"
                                                menugrp="<?php echo $aValue['FTGmnCode'];?>"
                                                id="<?php echo $aValue['FTGmnCode'];?>"
                                                onclick="FSxSMUUpdateStaUse(2,'TSysMenuGrp','FTGmnCode','FTGmnStaUse','<?php echo $aValue['FTGmnCode'];?>')">
                                            <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                            <?php }?>
                                        </label>
                                </td>
                                <?php if($aValue['FTGmnStaUse'] == 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmenugrp="<?php echo $aValue['FTGmnCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmenugrp="<?php echo $aValue['FTGmnCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUMenuGrpDel('<?php echo $aValue['FTGmnCode'];?>','<?php echo $aValue['FTGmnName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } else{?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmenugrp="<?php echo $aValue['FTGmnCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmenugrp="<?php echo $aValue['FTGmnCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUMenuGrpDel('<?php echo $aValue['FTGmnCode'];?>','<?php echo $aValue['FTGmnName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>

                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSMUCallModalMenuGrpEdit('<?php echo $aValue['FTGmnCode'];?>','<?php echo $aValue['FTGmnModName'];?>')">
                                </td>
                                <?php else : ?>
                                <td nowrap="" colspan="3">
                                </td>
                                <?php endif;?>
                            </tr>
                            <?php else : ?>
                            <tr class="hidden xCNDataMenuGrpModule" data-mgm="<?php echo $aValue['FTGmnModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap="" class="xCNMenuGrp" colspan="2">
                                    <label class="xCNLabelFrm">&nbsp;
                                        <?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuNotfoundGrpMenu');?></label>
                                </td>
                                <td nowrap="" colspan="5"></td>
                            </tr>
                            <?php endif;?>
                            <?php endif;?>


                            <?php 
                            if($aModuleCode.$aGmnCode.$aMnuCode != $aValue['FTGmnModCode'].$aValue['FTGmnCode'].$aValue['FTMnuCode']){
                            // if($aMnuCode != $aValue['FTMnuCode']){
                            // if(1==1){
                                ?>
                            <?php if($aValue['FTMnuStaUse'] != NULL || $aValue['FTGmnStaUse'] != NULL){?>
                            <tr class="MenuList hidden xCNDataRole" data-mgm="<?php echo $aValue['FTGmnCode'];?>"
                                data-smc="<?php echo $aValue['FTGmnModCode'];?>">
                                <td nowrap=""></td>
                                <td nowrap=""></td>
                                <?php if($aValue['FTMnuStaUse'] != NULL):?>
                                <td nowrap="">
                                    <?php echo $aValue['FTMnuCode'];?> - <?php echo $aValue['FTMnuName'];?></label>
                                </td>
                                <td nowrap="" class="xWHeardRoleAll">


                                    <?php if($aValue['FTGmnModStaUse'] == 0){?>
                                    <label class="fancy-checkbox xWCheckAll hidden"
                                        data-id="<?php echo $aValue['FTGmnCode'];?>"
                                        data-mod="<?php echo $aValue['FTGmnModCode'];?>">
                                        <?php } ?>
                                        <?php if($aValue['FTGmnStaUse'] == 0 && $aValue['FTGmnStaUse'] != NULL){?>
                                        <label class="fancy-checkbox xWCheckAll hidden"
                                            data-id="<?php echo $aValue['FTGmnCode'];?>"
                                            data-mod="<?php echo $aValue['FTGmnModCode'];?>">
                                            <?php } else{?>
                                            <label class="fancy-checkbox xWCheckAll"
                                                data-id="<?php echo $aValue['FTGmnCode'];?>"
                                                data-mod="<?php echo $aValue['FTGmnModCode'];?>">
                                                <?php } ?>

                                                <?php if($aValue['FTMnuStaUse'] != 0){?>
                                                <input class="xWOcbCheckAll" type="checkbox" checked
                                                    menulist="<?php echo $aValue['FTMnuCode'];?>"
                                                    name="<?php echo $aValue['FTMnuCode'];?>"
                                                    onclick="FSxSMUUpdateStaUse(3,'TSysMenuList','FTMnuCode','FTMnuStaUse','<?php echo $aValue['FTMnuCode'];?>')">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>

                                                <?php }else{?>
                                                <input class="xWOcbCheckAll" type="checkbox"
                                                    menulist="<?php echo $aValue['FTMnuCode'];?>"
                                                    name="<?php echo $aValue['FTMnuCode'];?>"
                                                    onclick="FSxSMUUpdateStaUse(3,'TSysMenuList','FTMnuCode','FTMnuStaUse','<?php echo $aValue['FTMnuCode'];?>')">
                                                <span><?php echo language('settingconfig/settingmenu/settingmenu','tSettingMenuStaUse');?></span>
                                                <?php }?>
                                            </label>
                                </td>

                                <?php if($aValue['FTMnuStaUse'] == 0){?>
                                <td nowrap="" class="xWHeardRoleAll text-center"
                                    data-td-delmenulist="<?php echo $aValue['FTMnuCode'];?>">
                                    <img class="xCNIconTable xCNIconDel"
                                        data-img-delmenulist="<?php echo $aValue['FTMnuCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUMenuListDel('<?php echo $aValue['FTMnuCode'];?>','<?php echo $aValue['FTMnuName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } else{?>
                                <td nowrap="" class="xWHeardRoleAll text-center xWTdDisable"
                                    data-td-delmenulist="<?php echo $aValue['FTMnuCode'];?>">
                                    <img class="xCNIconTable xCNIconDel xWImgDisable"
                                        data-img-delmenulist="<?php echo $aValue['FTMnuCode'];?>"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                        onClick="JSxSMUMenuListDel('<?php echo $aValue['FTMnuCode'];?>','<?php echo $aValue['FTMnuName'];?>','<?php echo language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    <?php } ?>

                                </td>
                                <td nowrap="" class="xWHeardRoleAll text-center">
                                    <img class="xCNIconTable"
                                        src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>"
                                        onClick="JSxSMUCallModalMenuListEdit('<?php echo $aValue['FTMnuCode'];?>','<?php echo $aValue['FTMnuName'];?>')">
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
                            <?php } ?>
                            <?php $aModuleCode = $aValue['FTGmnModCode']; ?>
                            <?php $aGmnCode = $aValue['FTGmnCode']; ?>
                            <?php $aMnuCode = $aValue['FTMnuCode']; ?>
                            <?php endforeach;?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvSMPModalDelModule">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <div id="ospConfirmDelete" class="xCNTextModal"></div>
                <p><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteStatus'); ?></p>
                <ul>
                    <li><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteStatus1'); ?>
                    </li>
                    <li><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteStatus2'); ?>
                    </li>
                </ul>
                <p class="text-danger">
                    <strong><?php echo language('settingconfig/settingmenu/settingmenu', 'tModalConfirmDeleteStatus3'); ?></strong>
                </p>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include('wSettigmenuModule.php');?>
<?php include('wSettingmenuMenuGrp.php');?>
<?php include('wSettingmenuMenulist.php');?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jSettingMenuTable.php';?>