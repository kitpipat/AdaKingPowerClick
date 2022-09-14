<div class="panel-heading">
	<div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSearchNew')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSearchAllShop()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button">
                            <img class="xCNIconBrowse" onclick="JSvSearchAllShop()" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <?php if($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaDelete'] == 1 ) : ?>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?= language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDeleteShopMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="panel-body">
    <section id="ostDataShop"></section>
</div>
<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<!-- ===================================================== Modal Delete Shop Single ===================================================== -->
    <div id="odvModalDeleteShopSingle" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ====================================================== End Delete Bnk Single ====================================================== -->

<!-- ==================================================== Modal Delete Bnk Multiple ==================================================== -->
<div id="odvModalDeleteShopMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type='hidden' id="ohdConfirmIDDelMultiple">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ===================================================== End Delete Shop Multiple ===================================================== -->

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    // Click Confirm Delete Multiple
    $('#odvModalDeleteShopMultiple #osmConfirmDelMultiple').unbind().click(function(){
        JSoShopDeleteMultiple();
    });    
</script>