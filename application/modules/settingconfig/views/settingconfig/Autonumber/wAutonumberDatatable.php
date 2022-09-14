<!--TABLE-->
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%" id="otbTableAutonumberDataTable">
                <thead>
					<tr class="xCNCenter">
						<th class="xCNTextBold" rowspan="2" style="text-align:justify; vertical-align: middle; width:80px;"><?= language('settingconfig/settingconfig/settingconfig','tTableNumber')?></th>
						<th class="xCNTextBold" rowspan="2" style="text-align:left; vertical-align: middle;"><?= language('settingconfig/settingconfig/settingconfig','tTableDescrption')?></th>
                        <th class="xCNTextBold" rowspan="2" style="text-align:left; vertical-align: middle; width:110px;"><?= language('settingconfig/settingconfig/settingconfig','tTableWidth')?></th>
                        <th class="xCNTextBold" colspan="2" style="width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueNormal')?></th>
                        <th class="xCNTextBold" colspan="2" style="width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueMake')?></th>
                        <th class="xCNTextBold" rowspan="2" style="vertical-align: middle;  width:80px;"><?= language('common/main/main','tCMNActionEdit')?></th>
                    </tr>
                    <tr>
                        <th style="text-align:center;  width:140px;"><?= language('settingconfig/settingconfig/settingconfig','tTableFormat')?></th>
                        <th style="text-align:center;  width:140px;"><?= language('settingconfig/settingconfig/settingconfig','tTableResetPassword')?></th>
                        <th style="text-align:center;  width:140px;"><?= language('settingconfig/settingconfig/settingconfig','tTableFormat')?></th>
                        <th style="text-align:center;  width:140px;"><?= language('settingconfig/settingconfig/settingconfig','tTableResetPassword')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aItemRecord['rtCode'] == 1 ):?>
                        <?php foreach($aItemRecord['raItems'] AS $key=>$aValue){ ?>
                            <tr>
                                <?php 
                                    //ค่าปกติ : รีเซ็ตรหัสตาม
                                    switch ($aValue['DefResetFmt']) {
                                        case 1:
                                            $tDetResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByYYYY');
                                            break;
                                        case 2:
                                            $tDetResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByMM');
                                            break;
                                        case 3:
                                            $tDetResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByD');
                                            break;
                                        case 4:
                                            $tDetResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByBCH');
                                            break;
                                        case null:
                                            $tDetResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByContinue');
                                            break;
                                        default:
                                            $tDetResetFmt = '-';
                                    }

                                    //ค่าปกติ : รีเซ็ตรหัสตาม
                                    switch ($aValue['UsrResetFmt']) {
                                        case null:
                                            $tUsrResetFmt = language('settingconfig/settingconfig/settingconfig','tResetByContinue');
                                            break;
                                        default:
                                            $tUsrResetFmt = $aValue['UsrResetFmt'];
                                    }
                                ?>
                                <td><?=$key + 1?></td>
                                <td><?=($aValue['FTSatTblDesc'] == '' || $aValue['FTSatTblDesc'] == NULL ) ? '-' : $aValue['FTSatTblDesc'];?></td>
                                <td style="text-align: right;"><?=$aValue['FNSatMaxFedSize']?></td>
                                <td><?=($aValue['DefFmt'] == '' || $aValue['DefFmt'] == NULL ) ? '-' : $aValue['DefFmt'];?></td>
                                <td><?=$tDetResetFmt?></td>
                                <td><?=($aValue['UsrFmt'] == '' || $aValue['UsrFmt'] == NULL ) ? '-' : $aValue['UsrFmt'];?></td>
                                <td><?=$tUsrResetFmt?></td>
                                <td nowarp class="text-center">
                                    <?php 
                                        $tPKTable       = $aValue['FTSatTblName'];
                                        $tPKTableType   = $aValue['FTSatStaDocType']; ?>
                                    <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageUpdateAutonumber('<?=$tPKTable?>','<?=$tPKTableType?>')">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='10'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    var nWindowHeight   = $(window).height() - 400;
    $('.xCNTableHeightAutonumber').css('height',nWindowHeight);
</script>