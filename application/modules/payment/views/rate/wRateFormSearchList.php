<div class="panel-heading">
	<div class="row">
        <div class="col-xs-8 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('payment/rate/rate','tRTESearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSearchAllRate()" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
							<span class="input-group-btn">
								<button class="btn xCNBtnSearch" type="button" onclick="JSvSearchAllRate()">
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
                    <a data-toggle="modal" data-target="#odvModalDelRate"><?= language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
	<div id="odvContentRateData"></div>
</div>


<!-- <div class="panel-heading"> 
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvCallPageRateDataTable()" autocomplete="off">
					<span class="input-group-btn">
						<button class="btn xCNBtnSearch" type="button" onclick="JSvCallPageRateDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/assets/icons/search-24.png'?>">
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
						<a data-toggle="modal" data-target="#odvModalDelRate"><?= language('common/main/main','tDelAll')?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="panel-body">
	<section id="odvContentRateData"></section>
</div> -->



<!-- 
<div class="modal fade" id="odvModalDelRate">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><?=language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" onClick="JSnRateDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div> -->