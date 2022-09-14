<div id="odvTabInfo2" class="tab-pane fade">
    <div class="panel-body">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="form-group">
                    <div class="wrap-input100 validate-input" data-validate="Please Insert Name">
                        <label class="xCNTextDetail1"><?= language('customer/customer/customer','tCSTName')?></label>
                        <input type="text" class="input100" maxlength="100" id="oetCstName" name="oetCstName" value="<?= $tCstName ?>">
                        <span class="focus-input100"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="wrap-input100 validate-input" data-validate="Please Insert Email">
                        <label class="xCNTextDetail1"><?= language('customer/customer/customer','tCSTEmail')?></label>
                        <input type="email" class="input100" maxlength="100" id="oetCstEmail" name="oetCstEmail" value="<?= $tCstEmail ?>">
                        <span class="focus-input100"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="wrap-input100 validate-input" data-validate="Please Insert Tel">
                        <label class="xCNTextDetail1"><?= language('customer/customer/customer','tCSTTel')?></label>
                        <input type="tel" class="input100 xCNInputWithoutSpc" maxlength="100" id="oetCstTel" name="oetCstTel" value="<?= $tCstTel ?>">
                        <span class="focus-input100"></span>
                    </div>
                </div>
                <?php
                $tSelected = '';
                if($tBchCode != "" && $tShpCode != ""){
                    $tSelected = 'selected="true"';
                }
                ?>
                <div class="form-group">
                    <div class="wrap-input100 validate-input" data-validate="Please Insert Level">
                        <label class="xCNTextDetail1"><?php echo language('customer/customer/customer', 'tCSTLelvel'); ?></label>
                        <select class="form-control" id="oetCstLevel" name="oetCstLevel" onchange="JSxVisibledRefMode(this, event)">
                            <option value="1"><?php echo language('customer/customer/customer', 'tCSTBranceLevel'); ?></option>
                            <option value="2" <?php echo $tSelected; ?>><?php echo language('customer/customer/customer', 'tCSTShopLevel'); ?></option>
                        </select>
                        <span class="focus-input100"></span>
                    </div>
                </div>
                <div class="form-group" id="xWBranchMode">
                    <div class="wrap-input100 validate-input" data-validate="Please Enter">
                        <label class="xCNTextDetail1"><?= language('customer/customer/customer','tCSTRef')?></label>
                        <input type="text" class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" value="<?= $tBchCode ?>">
                        <input class="input100 xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" placeholder="###" value="<?= $tBchName ?>" readonly>
                        <span class="focus-input100"></span>
                        <img id="oimCstBrowseBranch" class="xCNIconBrowse" src="<?= base_url().'application/assets/icons/find-24.png'?>">
                    </div>
                </div>
                <div class="form-group" id="xWShopMode">
                    <div class="wrap-input100 validate-input" data-validate="Please Enter">
                        <label class="xCNTextDetail1"><?= language('customer/customer/customer','tCSTRef')?></label>
                        <input type="text" class="form-control xCNHide" id="oetShpCode" name="oetShpCode" maxlength="5" value="<?= $tShpCode ?>">
                        <input class="input100 xWPointerEventNone" type="text" id="oetShpName" name="oetShpName" placeholder="###" value="<?= $tShpName ?>" readonly>
                        <span class="focus-input100"></span>
                        <img id="oimCstBrowseShop" class="xCNIconBrowse" src="<?= base_url().'application/assets/icons/find-24.png'?>">
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="wrap-input100 validate-input">
                                <label class="xCNTitleFrom">หมายเหตุ</label>
                                <textarea class="input100" maxlength="100" rows="4" id="otaCstRemark" name="otaCstRemark"><?= $tCstRmk ?></textarea>
                                <span class="focus-input100"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
