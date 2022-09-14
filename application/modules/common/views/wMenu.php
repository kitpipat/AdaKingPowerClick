<?php
$tCNTextPermission  = "<span style='color: #fcff24 !important;'>" . language('common/main/main', 'tMenuPermission') . "</span>";
$tCNTextExpire      = "<span style='color: #fcff24 !important;'>" . language('common/main/main', 'tMenuExpire') . "</span>";
$tCNStyleColor      = "color: #9e9e9e !important;";
$tCNStyleCursor     = "cursor: no-drop;";
$tCNStaExpire       = "1";
?>
<!-- LEFT SIDEBAR BUTTON-->

<input type="hidden" id="ohdSesAlwNoti" value="<?=$this->session->userdata("bSesAlwNoti")?>">
<input type="hidden" id="ohdSesAlwNews" value="<?=$this->session->userdata("bSesAlwNews")?>">

<!-- MENU BUTTON -->
<div style="width:60px;height: 100%;float: left;background-color: #1D2530;position: fixed;z-index: 6000;margin-top: -56px;">
    <div class="xWOdvBtnMenu">
        <button type="button" class="xCNBtnMenuIcoeHader btn-toggle-fullwidth" title="Menu">
            <img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/menu-50.png" alt="Klorofil Logo" class="img-responsive logo">
        </button>
    </div>

    <?php if (isset($oGrpModules) && !empty($oGrpModules) && is_array($oGrpModules)) : ?>
        <?php $nFirstMenu = 0;
        foreach ($oGrpModules as $nKey => $aValGrpModules) : ?>
            <?php if ($aValGrpModules['FTGmnModStaUse'] == 1) : ?>
                <div class="xWOdvBtnMenu  <?php echo ($nFirstMenu == 0) ? 'xCNBtnFirstMenu' : ''; ?>  ">
                    <button type="button" data-menu="<?php echo $aValGrpModules['FTGmnModCode']; ?>" class="xCNBtnMenu" title="<?php echo $aValGrpModules['FTGmnModName']; ?>">
                        <img src="<?php echo base_url() . $aValGrpModules['FTGmmModPathIcon']; ?>" alt="Klorofil Logo" class="xCNBtnMenuIcon">
                    </button>
                </div>
            <?php $nFirstMenu++;
            endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- ADA-Register 08/01/2021 -->
    <div class="xWOdvBtnMenu">
        <button type="button" data-menu="Adasoft" class="xCNBtnMenu" title="Adasoft">
            <img src="<?= base_url('application/modules/common/assets/images/iconsmenu/ada.png') ?>" class="xCNBtnMenuIcon">
        </button>
    </div>

    <!-- ADA-Register 08/01/2021 -->

</div>
<!-- END MENU BUTTON -->

<!-- MENU BAR DATA -->
<div id="sidebar-nav" class="xWMenu sidebar xCNNavShadow">
    <div class="container-fluid xWContainer-fluid">
        <div class="xWHeadMenuList" style="padding: 7px;margin-top: 10px;">
            <a href="">
                <img src="<?php echo base_url(); ?>application/modules/common/assets/images/logo/AdaLogo.png" alt="Klorofil Logo" class="img-responsive logoAda">
            </a>
        </div>
        <div class="xWLineHeadMenuList"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label id="olbTitleMenuModules" class="xCNTitleMenuModules">-</label>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
                <input class="form-control xWinputSearchmenu" type="text" id="oetMenSearch" name="oetMenSearch" placeholder="Search Menu" style="margin:0px;">
            </div>
        </div>
    </div>
    <div class="sidebar-scroll">

        <!-- ADA-Register 08/01/2021 -->
        <nav id="oNavMenuAdasoft" class="xCNMargintop10 xCNMenuList">
            <ul class="nav get-menu xCNMenuListAdaregiter" style="display:block;">

                <?php
                $bSessionCstKey = $this->session->userdata('tSesCstKey');
                if ($bSessionCstKey == '' || $bSessionCstKey == null) {
                ?>
                    <li class="treeview-item xCNMenuItem">
                        <a data-mnrname="BuyLicense/1" data-toggle="collapse" class="collapsed xWLiSubmenu">
                            <span style="margin-left:-27px;"><?= language('register/register', 'tMenuRegister') ?></span>
                        </a>
                    </li>
                <?php
                }
                ?>

                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="ImformationRegister" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;"><?= language('register/register', 'tMenuInformation'); ?></span>
                    </a>
                </li>

                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="LicenseAgreement" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;"><?= language('register/register', 'tMenuLicenseAgreement'); ?></span>
                    </a>
                </li>

                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="AdaSoftContact" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;"><?= language('register/register', 'tMenuContact'); ?></span>
                    </a>
                </li>

                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="ServerPrinter/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ปริ้นเตอร์เซิร์ฟเวอร์</span>
                    </a>
                </li>

                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="LablePrinter/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">รูปแบบการพิมพ์</span>
                    </a>
                </li>
                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="PrintBarCode/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">พิมพ์ป้ายราคา</span>
                    </a>
                </li> -->
                
                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="docPAM/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ใบจัดสินค้า</span>
                    </a>
                </li> -->

                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="monSDT/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ตรวจสอบสถานะเอกสารโอน</span>
                    </a>
                </li> -->

                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="monDO/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ตรวจสอบสถานะใบส่งของ</span>
                    </a>
                </li> -->

                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="docManageCoupon/0/0" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ตรวจสอบคูปอง/บัตรกำนัล</span>
                    </a>
                </li> -->

                <!-- <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="toolConfigSlip" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;">ตั้งค่าใบเสร็จ</span>
                    </a>
                </li> -->
                
            </ul>
        </nav>
        <!-- ADA-Register 08/01/2021 -->

        <ul class="nav get-menu xCNMenuListFAV" style="display:none;">
            <?php foreach ($aMenuFav as $nKey => $aValueFav) { ?>
                <li class="treeview-item xCNMenuItem">
                    <a data-mnrname="<?php echo trim($aValueFav->FavMnuRoute); ?>" data-toggle="collapse" class="collapsed xWLiSubmenu">
                        <span style="margin-left:-27px;"><?php echo trim($aValueFav->FavMfvName); ?></span>
                    </a>
                </li>
            <?php } ?>
        </ul>

        <?php $tGmnModCode = ''; ?>
        <?php $nI = 0; ?>
        <?php if (is_array($oMenuList)) : ?>

            <?php foreach ($oMenuList as $nKey => $oValueModule) { ?>

                <?php if ($tGmnModCode != $oValueModule->FTGmnModCode) { ?>
                    <?php $tGmnModCode = $oValueModule->FTGmnModCode; ?>
                    <nav id="oNavMenu<?php echo $tGmnModCode ?>" class="xCNMargintop10 xCNMenuList <?php echo $nI != 0 ? 'xCNHide' : ''; ?>">
                        <ul class="nav">
                            <li class="treeview">
                                <?php if ($oValueModule->FTGmnCode != '') : ?>
                                    <!-- <a href="#FOLDER<?php echo $oValueModule->FTGmnCode ?>" data-toggle="collapse" class="collapsed">
                                            <i class="icon-submenu fa fa-plus"></i> <span><?php echo $oValueModule->FTGmnModName ?></span>
                                        </a> -->
                                <?php else : ?>
                                    <ul class="nav get-menu">
                                        <li>
                                            <a href="<?php echo $oValueModule->FTMnuCtlName ?>">
                                                <span><?php echo $oValueModule->FTGmnModName ?></span>
                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                                <ul>
                                    <?php $tGrpMen = ''; ?>
                                    <?php foreach ($oMenuList as $oValue) : ?>
                                        <?php if ($tGrpMen != $oValue->FTGmnCode && $tGmnModCode == $oValue->FTGmnModCode) : ?>
                                            <?php $tGrpMen = $oValue->FTGmnCode; ?>
                                            <li class="treeview">

                                                <?php if ($oValue->FTGmnName == '') : ?>

                                                    <?php foreach ($oMenuList as $oValue2) : ?>
                                                        <?php //echo $oValue2->FTGmnCode."-".$oValue->FTGmnCode;	
                                                        ?>
                                                        <?php if ($oValue2->FTGmnCode == $oValue->FTGmnCode) : ?>
                                                            <ul class="nav get-menu">
                                                                <li class="treeview-item xCNMenuItem">
                                                                    <?php
                                                                    $tTextAlert    = "";
                                                                    $tStyleColor   = "";
                                                                    $tStyleCursor  = "";
                                                                    $tStaExpire    = "2";

                                                                    // ตรวจสอบข้อมูลใน database ?
                                                                    if (!empty($oValue2->FTLicStartFinish)) {
                                                                        $tToday      = date("Y-m-d");
                                                                        $tFinish     = date_format(date_create($oValue2->FTLicStartFinish), "Y-m-d");

                                                                        // ตรวจสอบ เมนูหมดอายุ
                                                                        if ($tFinish < $tToday) {
                                                                            $tTextAlert    = $tCNTextExpire;
                                                                            $tStyleColor   = $tCNStyleColor;
                                                                            $tStyleCursor  = $tCNStyleCursor;
                                                                            $tStaExpire    = $tCNStaExpire;
                                                                        }
                                                                    } else if (empty($oValue2->FTLicStartFinish) && $this->session->userdata("tSesUsrLevel") != "HQ") {
                                                                        $tTextAlert    = $tCNTextPermission;
                                                                        $tStyleColor   = $tCNStyleColor;
                                                                        $tStyleCursor  = $tCNStyleCursor;
                                                                        $tStaExpire    = $tCNStaExpire;
                                                                    }
                                                                    ?>
                                                                    <a data-mnrname="<?php echo trim($oValue2->FTMnuCtlName); ?>" data-expire="<?= $tStaExpire ?>" style="<?= $tStyleCursor ?>" data-toggle="collapse" class="collapsed xWLiSubmenu">
                                                                        <span style="margin-left:-27px;<?= $tStyleColor ?>"><?= $oValue2->FTMnuName ?></span>
                                                                        <?= $tTextAlert ?>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                <?php else : ?>

                                                    <a href="#<?php echo $tGmnModCode . $oValue->FTGmnCode ?>" data-toggle="collapse" class="collapsed xWLiSubmenu">
                                                        <i class="icon-submenu fa fa-plus"></i> <span><?php echo $oValue->FTGmnName ?></span>
                                                    </a>
                                                    <!-- <a href="javascript:void(0)" class="xWSidebar-a"><label class="xCNMenuLabel"><?php echo $oValue->FTGmnName ?></label><span class="fa arrow"></span></a> -->
                                                    <div id="<?php echo $tGmnModCode . $oValue->FTGmnCode ?>" class="collapse ">
                                                        <ul class="nav get-menu">
                                                            <?php foreach ($oMenuList as $oValue2) : ?>
                                                                <?php if ($oValue2->FTGmnCode == $oValue->FTGmnCode && $tGmnModCode == $oValue2->FTGmnModCode) : ?>
                                                                    <?php //if ($oValue2->FTAutStaRead == '1'):
                                                                    ?>
                                                                    <li class="treeview-item xCNMenuItem">
                                                                        <?php

                                                                        $tTextAlert    = "";
                                                                        $tStyleColor   = "";
                                                                        $tStyleCursor  = "";
                                                                        $tStaExpire    = "2";

                                                                        // ตรวจสอบข้อมูลใน database ?
                                                                        if (!empty($oValue2->FTLicStartFinish)) {
                                                                            $tToday      = date("Y-m-d");
                                                                            $tFinish     = date_format(date_create($oValue2->FTLicStartFinish), "Y-m-d");

                                                                            // ตรวจสอบ เมนูหมดอายุ
                                                                            if ($tFinish < $tToday) {
                                                                                $tTextAlert    = $tCNTextExpire;
                                                                                $tStyleColor   = $tCNStyleColor;
                                                                                $tStyleCursor  = $tCNStyleCursor;
                                                                                $tStaExpire    = $tCNStaExpire;
                                                                            }
                                                                        } else if (empty($oValue2->FTLicStartFinish) && $this->session->userdata("tSesUsrLevel") != "HQ") {
                                                                            $tTextAlert    = $tCNTextPermission;
                                                                            $tStyleColor   = $tCNStyleColor;
                                                                            $tStyleCursor  = $tCNStyleCursor;
                                                                            $tStaExpire    = $tCNStaExpire;
                                                                        }
                                                                        ?>
                                                                        <a data-mnrname="<?php echo trim($oValue2->FTMnuCtlName); ?>" data-expire="<?= $tStaExpire ?>" style="<?= $tStyleCursor ?>">
                                                                            <span style="<?= $tStyleColor ?>"> <?= $oValue2->FTMnuName; ?></span>
                                                                            <?= $tTextAlert; ?>
                                                                        </a>
                                                                    </li>
                                                                    <?php //endif;
                                                                    ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                <?php endif; ?>

                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                <?php } ?>
                <?php $nI++ ?>

            <?php } ?>

        <?php else : ?>
            <li class="treeview">
                <a data-toggle="collapse" class="collapsed"></a>
            </li>
        <?php endif; ?>

    </div>
</div>


<input type="hidden" id="oetTextComfirmDeleteSingle" name='oetTextComfirmDeleteSingle' value="<?php echo language('common/main/main', 'tModalDeleteSingle'); ?>">
<input type="hidden" id="oetTextComfirmDeleteMulti" name='oetTextComfirmDeleteMulti' value="<?php echo language('common/main/main', 'tModalDeleteMulti'); ?>">
<input type="hidden" id="oetTextComfirmDeleteYesOrNot" name='oetTextComfirmDeleteYesOrNot' value="<?php echo language('common/main/main', 'tModalDeleteYesOrNot'); ?>">
<input type="hidden" id="oetNotFoundDataInDB" name='oetNotFoundDataInDB' value="<?php echo language('common/main/main', 'tMainRptNotFoundDataInDB'); ?>">
<input type="hidden" id="oetAllBusGroup" name='oetAllBusGroup' value="<?php echo language('common/main/main', 'tAllbusgroup'); ?>">
<input type="hidden" id="oetAllShopVending" name='oetAllShopVending' value="<?php echo language('common/main/main', 'tAllstores'); ?>">
<!-- END LEFT SIDEBAR -->