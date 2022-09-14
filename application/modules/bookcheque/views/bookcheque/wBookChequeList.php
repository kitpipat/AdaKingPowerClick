<div class="panel-heading">
	<div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('ticket/agency/agency','tSearchAgency')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSearchAllChq()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" type="button" onclick="JSvSearchAllChq()">
                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?= language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                    <a data-toggle="modal" data-target="#odvModalDelChq"><?= language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="panel-body">
	<div id="odvContentBookChequeDatatable"></div>
</div>
<!-- ==================================================== Modal Delete Shop Multiple ==================================================== -->
<div id="odvModalDeleteChqMultiple" class="modal fade" tabindex="-1" role="dialog">
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
<script type="text/javascript">
    // Click Confirm Delete Multiple
    $('#odvModalDeleteChqMultiple #osmConfirmDelMultiple').unbind().click(function(){
        JSoChqDeleteMultiple();
    });    
</script>