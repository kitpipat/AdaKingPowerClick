<div id="odvTabInfo2" class="tab-pane fade">
    <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddCustomerInfo2">
        <button style="display:none" type="submit" class="xWSubmitCustomerInfo" onclick="JSnCSTAddEditCustomer('<?php echo $tRoute;?>')"></button>
        <div class="panel-body">
            <div class="row">
                <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTCgp');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstCgpCode" name="oetCstCgpCode" value="<?php echo @$tCstCgpCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstCgpName" name="oetCstCgpName" value="<?php echo @$tCstCgpName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseCgp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTCty');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstCtyCode" name="oetCstCtyCode" value="<?php echo @$tCstCtyCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstCtyName" name="oetCstCtyName" value="<?php echo @$tCstCtyName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseCty" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTClv');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstClvCode" name="oetCstClvCode" value="<?php echo @$tCstClvCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstClvName" name="oetCstClvName" value="<?php echo @$tCstClvName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseClv" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTOcp');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstCstOcpCode" name="oetCstCstOcpCode" value="<?php echo @$tCstOcpCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstCstOcpName" name="oetCstCstOcpName" value="<?php echo @$tCstOcpName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseOcp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    <!-- 10/11/2022 ปิดใช้งาน ไปใช้งานที่หน้าจอระดับลูกค้าแทน -->
                    <div class="form-group xCNHide">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTPplRet');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstPplRetCode" name="oetCstPplRetCode" value="<?php echo @$tCstPplCodeRet;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstPplRetName" name="oetCstPplRetName" value="<?php echo @$tCstPplNameRet;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowsePpl" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTPmg');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstPmgCode" name="oetCstPmgCode" value="<?php echo @$tCstPmgCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstPmgName" name="oetCstPmgName" value="<?php echo @$tCstPmgName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowsePmg" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Create By Witsarut 26/11/2019 -->
                    <!-- เพิ่มกลุ่มราคาขายส่ง-->
                    <!-- <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTWholesale');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstWhsCode" name="oetCstWhsCode" value="<?php echo @$tCstCodeWhs;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstWhsName" name="oetCstWhsName" value="<?php echo @$tCstWhsName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseWhs" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div> -->

                    <!-- เพิ่มกลุ่มราคาออนไลน์-->
                    <!-- <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTWholeOnline');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstWhsnNetCode" name="oetCstWhsnNetCode" value="<?php echo @$tPplCodeNet;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstWhsnNetName" name="oetCstWhsnNetName" value="<?php echo @$tPplNameNet;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseNet" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div> -->

                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTDiscRet')?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetCstDiscRet" name="oetCstDiscRet" value="<?php echo @$tCstDiscRet;?>">
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTDiscWhs')?></label>
                        <input type="text" class="form-control" maxlength="100" id="oetCstDiscWhs" name="oetCstDiscWhs" value="<?php echo @$tCstDiscWhs;?>">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-xl-12 col-sm-12 col-md-12 col-lg-12">
                    <div id="odvBchSetHQ">
                        <label class="fancy-checkbox">
                            <?php 
                            $tCstBchHQCheck;
                            !empty($tCstBchHQ) ? $tCstBchHQCheck = "checked" : $tCstBchHQCheck = "";
                            ?>
                            <input type="checkbox" name="ocbCstHeadQua" value="1" <?php echo $tCstBchHQCheck; ?> onchange="JSxDisabledOrEnabledCstBch(this, event)">
                            <span> <?php echo language('customer/customer/customer','tCSTHeadQua'); ?></span>
                        </label>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6 col-md-6 col-lg-6">
                    <div id="odvCstBchFormGrp" class="form-group">

                        <?php
                            $tDisabledButton = "";
                            if( $this->session->userdata("tSesUsrLevel") != "HQ" && $this->session->userdata("nSesUsrBchCount") <= 1 ){
                                $tDisabledButton = "disabled";
                            }
                        ?>

                        <label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTBch');?></label>
                        <div class="input-group">
                            <input type="text" class="form-control xCNHide" id="oetCstBchCode" name="oetCstBchCode" value="<?php echo @$tCstBchCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetCstBchName" name="oetCstBchName" value="<?php echo @$tCstBchName;?>" readonly>
                            <span class="input-group-btn">
                                <button id="oimCstBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabledButton;?> ><img class="xCNIconFind"></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
