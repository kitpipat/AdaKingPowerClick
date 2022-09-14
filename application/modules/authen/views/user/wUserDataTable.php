<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<link rel="stylesheet" href="<?php echo base_url('application/modules/authen/views/user/css/Ada.WizardStep.css') ?>">
<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?= $nCurrentPage; ?>">
        <input type="hidden" id="ohdBaseurl" value="<?php echo base_url() ?>">
        <input type="hidden" id="ohdChkbrowse" value="1">
        <div class="table-responsive">
            <table id="otbUserDataList" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBPic') ?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSRTBName') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBDepart') ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBBranch') ?></th> -->
                        <!-- <?php if (FCNbGetIsShpEnabled()) : ?>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBShop') ?></th>
                        <?php endif; ?> -->
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBDelete') ?></th>
                        <?php endif; ?>
                        <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php
                        foreach ($aDataList['raItems'] as $key => $aValue) {
                        ?>
                            <tr class="text-center xCNTextDetail2 otrUser" id="otrUser<?= $key ?>" data-code="<?= $aValue['rtUsrCode'] ?>" data-name="<?= $aValue['rtUsrName'] ?>">
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php if ($aValue['rtUsrCode'] == $this->session->userdata("tSesUserCode")) {
                                                                                                                                            echo "disabled";
                                                                                                                                        } ?>>
                                            <span class="<?php if ($aValue['rtUsrCode'] == $this->session->userdata("tSesUserCode")) {
                                                                echo "xCNDocDisabled";
                                                            } ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td class="text-center">
                                    <?php echo FCNtHGetImagePageList($aValue['rtUsrImage'], '38px'); ?>
                                </td>
                                <td class="text-left"><?= $aValue['rtUsrName'] ?></td>
                                <td class="text-left"><?= $aValue['rtDptName'] ?></td>
                                <!-- <td class="text-left"><?= $aValue['rtBchName'] ?></td>
                                <?php if (FCNbGetIsShpEnabled()) : ?>
                                <td class="text-left"><?= $aValue['rtShpName'] ?></td>
                                <?php endif; ?> -->
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td>
                                        <img class="xCNIconTable xCNIconDel <?php if ($aValue['rtUsrCode'] == $this->session->userdata("tSesUserCode")) {
                                                                                echo "xCNDocDisabled";
                                                                            } ?> " src="<?php echo base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>"> <!-- onClick="JSnUserDel('<?= $nCurrentPage ?>','<?= $aValue['rtUsrName'] ?>','<?php echo $aValue['rtUsrCode'] ?>','<?php echo language('common/main/main', 'tBCHYesOnNo') ?>')" -->
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEventUser['tAutStaFull'] == 1 || ($aAlwEventUser['tAutStaAdd'] == 1 || $aAlwEventUser['tAutStaEdit'] == 1)) : ?>
                                    <td>
                                        <img class="xCNIconTable" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageUserEdit('<?php echo $aValue['rtUsrCode'] ?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php
                            // }
                        }
                        ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageUser btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'disabled';
                    $tDisPageNumber = 'active';
                } else {
                    $tActive = '-';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tDisPageNumber; ?>" <?php echo $tActive ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>

            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>

        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDelUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>

            <input type='hidden' id="ospConfirmIDDelete">

            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSaUserDelChoose('<?= $nCurrentPage ?>')" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="odvModalCondition" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('authen/user/user', 'tUsrTempCondit') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="xWcol-lg-3 col-md-3 col-xs-12 col-sm-8">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRAgency') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetAgencyID" name="oetAgencyID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetAgencyName" name="oetAgencyName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRAgency'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseAgs" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-3 col-md-3 col-xs-12 col-sm-8">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRBranch') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetBranchID" name="oetBranchID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetBranchName" name="oetBranchName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRBranch'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-3 col-md-3 col-xs-12 col-sm-8">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRMerchant') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetMerchantID" name="oetMerchantID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetMerchantName" name="oetMerchantName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRMerchant'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-3 col-md-3 col-xs-12 col-sm-8">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRShop') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetShopID" name="oetShopID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetShopName" name="oetShopName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRShop'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseShop" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 wizard">
                        <div id="odvPromotionLine" style="width: 100%;">
                            <ul class="nav nav-tabs xWPromotionLine" role="tablist" style="border-bottom:2px solid #d6d6d6;">

                                <li role="presentation" id="oliUsrModal_step1" class="active oliTab_step">
                                    <label id="olbTab_step1" class="olbTab_step" style="font-weight: bold"><?php echo language('authen/user/user', 'tUsrRoleStep1'); ?></label>
                                    <a title="<?php echo language('authen/user/user', 'tUsrRoleStep1'); ?>">
                                        <span class='round-tab' id="ospTab_step1" style="border: 2px solid #d6d6d6;left: -1px;top: -1px;"></span>
                                    </a>
                                </li>


                                <li role="presentation" id="oliUsrModal_step2" class="disabled oliTab_step">
                                    <label id="olbTab_step4" class="olbTab_step" style="font-weight: bold;margin-left: 78%;white-space: nowrap;"><?php echo language('authen/user/user', 'tUsrRoleConfirm'); ?></label>
                                    <a style="position: absolute;right: 0;width: 17px;height: 22px;" title="<?php echo language('authen/user/user', 'tUsrRoleConfirm'); ?>">
                                        <span class="round-tab" id="ospTab_step2" style="border: 2px solid #d6d6d6;"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="xWcol-lg-9 col-md-9 col-xs-8 col-sm-8" style="padding-top: 20px;">
                        <div class="form-group">
                            <label class="xCNLabelFrm hidden-xs" wfd-id="732"></label>
                            <button type="button" id="oimUsrBack" name="oimUsrBack" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style='width:15%;margin-right: 10px;' onclick="JStUserRoleBack()" disabled>
                                <?php echo language('authen/user/user', 'tUsrBack'); ?>
                            </button>
                            <button type="button" id="oimUsrNext" name="oimUsrNext" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style='width:15%' onclick="JStUserRoleNext()">
                                <?php echo language('authen/user/user', 'tUsrNext'); ?>
                            </button>
                            <button type="submit" id="oimUsrSend" name="oimUsrSend" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style='width:15%;display:none' onclick="JStUserRoleSend()">
                                <?php echo language('authen/user/user', 'tUsrImport'); ?>
                            </button>
                        </div>
                    </div>
                    <div class="xWcol-lg-3 col-md-3 col-xs-4 col-sm-4 text-right" style="padding-top: 20px;">
                        <div class="form-group">
                            <button class="xCNBTNPrimeryPlus" type="button" id="oimAddBrowse">+</button>
                            <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetAddID" name="oetAddID" maxlength="5">
                            <input type="text" class="form-control xCNHide" id="oetAddName" name="oetAddName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRShop'); ?>" readonly>

                        </div>
                    </div>
                    <div class="col-md-12" style="min-height: 300px; max-height: 300px; overflow-y: scroll;">
                        <table id="otbUrsRoldList" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUsrCount') ?></th>
                                    <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSRRole') ?></th>
                                    <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUsrNumberUrs') ?></th>
                                    <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('authen/user/user', 'tUSRTBDelete') ?></th>
                                </tr>
                            </thead>
                            <tbody id="odvUrsRoldList">
                                <tr class='xWNodata'>
                                    <td class='text-center xCNTextDetail2' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <form id='ofmExportExcel' name='ofmExportExcel' method="post" enctype="multipart/form-data" target="_blank" action="userEventExcel">
                            <table id="otbUrsRoldAll" class="table table-striped" style="width:100%" hidden>
                                <thead>
                                    <tr>
                                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUsrCount') ?></th>
                                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSRRole') ?></th>
                                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSRTBName') ?></th>
                                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUSREmail') ?></th>
                                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tBrowseDPTName') ?></th>
                                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('authen/user/user', 'tUsrTelNo') ?></th>
                                    </tr>
                                </thead>
                                <tbody id="odvUrsRoldAll">
                                </tbody>
                            </table>
                        </form>

                    </div>


                </div>
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>

            <input type='hidden' id="ospConfirmIDDelete">
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="odvModalExcelUrs" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('authen/user/user', 'tExport') ?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                <form id='ofmExportExcelUsr' name='ofmExportExcelUsr' method="post" enctype="multipart/form-data" target="_blank" action="userEventExportUserExcel">
                    <div class="xWcol-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRAgency') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetExcelAgencyID" name="oetExcelAgencyID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetExcelAgencyName" name="oetExcelAgencyName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRAgency'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimBrowseAgsExcel" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRBranch') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetExcelBranchID" name="oetExcelBranchID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetExcelBranchName" name="oetExcelBranchName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRBranch'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimExcelBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRMerchant') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetExcelMerchantID" name="oetExcelMerchantID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetExcelMerchantName" name="oetExcelMerchantName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRMerchant'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimExcelBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="xWcol-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('authen/user/user', 'tUSRShop') ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide xWAdvanceSeach" type="text" id="oetExcelShopID" name="oetExcelShopID" maxlength="5">
                                <input type="text" class="form-control xWPointerEventNone xWAdvanceSeach" id="oetExcelShopName" name="oetExcelShopName" maxlength="100" placeholder="<?php echo language('authen/user/user', 'tUSRShop'); ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="oimExcelBrowseShop" type="button" class="btn xCNBtnBrowseAddOn <?= @$tDisabled ?>" option="1">
                                        <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('ticket\user\user_lang','tCreationDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control input100 xCNDatePicker"
                                    type="text"
                                    id="oetUSRAdvSearcDocDateFrom"
                                    name="oetUSRAdvSearcDocDateFrom"
                                    placeholder="จาก<?php echo language('ticket\user\user_lang','tCreationDate'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtUSRAdvSearchDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <label class="xCNLabelFrm">ถึง<?php echo language('ticket\user\user_lang','tCreationDate'); ?></label>
                        <div class="input-group">
                            <input
                                class="form-control input100 xCNDatePicker"
                                type="text"
                                id="oetUSRAdvSearcDocDateTo"
                                name="oetUSRAdvSearcDocDateTo"
                                placeholder="ถึง<?php echo language('ticket\user\user_lang','tCreationDate'); ?>"
                            >
                            <span class="input-group-btn" >
                                <button id="obtUSRAdvSearchDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                    </form>
                </div>
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>

            <input type='hidden' id="ospConfirmIDDelete">
            <div class="modal-footer">
            <button type="submit" id="oimExportExcelURSSubmit" name="oimExportExcelURSSubmit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JStUserExportMulti()">
                    <?php echo language('authen/user/user', 'tUsrImport'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">


<script type="text/javascript">
    $('.ocbListItem').click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); //code
        var tName = $(this).parent().parent().parent().data('name'); //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if (LocalItemData) {
            obj = JSON.parse(LocalItemData);
        } else {}
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert == '' || aArrayConvert == null) {
            obj.push({
                "nCode": nCode,
                "tName": tName
            });
            localStorage.setItem("LocalItemData", JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i].nCode == nCode) {
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i] != undefined) {
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData", JSON.stringify(aNewarraydata));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    });

    $('.xCNIconDel').off('click');
    $('.xCNIconDel').on('click', function(e) {
        var nCurPage = $('#nCurrentPageTB').val();
        var tUsrName = $(this).parent().parent().attr('data-name');
        var tUsrCode = $(this).parent().parent().attr('data-code');
        var tLang = '<?php echo language('common/main/main', 'tBCHYesOnNo') ?>';

        if ($(this).hasClass('xCNDocDisabled')) {
            e.preventDefault();
        } else {
            JSnUserDel(nCurPage, tUsrName, tUsrCode, tLang);
        }

    });
</script>
<?php include 'script/jUserDataTable.php'; ?>