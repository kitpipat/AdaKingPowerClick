<div class="panel-heading">
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADSearchForDocuments')?></label>
                <div class="input-group">
                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvCallPagePermissionApproveDocDataTable()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                    <span class="input-group-btn">
                        <button class="btn xCNBtnSearch" onclick="JSvCallPagePermissionApproveDocDataTable()" type="button">
                            <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
	<div id="odvContentPermissionApvDocData"></div>
</div>
