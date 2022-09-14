<div class="panel-heading">
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
                <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
                <div class="input-group">
                    <input
                        type="text"
                        class="form-control"
                        id="oetPosEdcSearchAll"
                        name="oetPosEdcSearchAll"
                        onkeypress="Javascript:if(event.keyCode==13) JSvCallPagePosEdcDataTable()"
                        autocomplete="off"
                        placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>"
                    >
                    <span class="input-group-btn">
                        <button id="obtPosEdcSearchTable" class="btn xCNBtnSearch" type="button">
							<img onclick="JSvCallPagePosEdcDataTable()" class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
                    </span>
                </div>
            </div>
        </div>
        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ):?>
            <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliPosEdcBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDeletePosEdcMulti"><?php echo language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>
<div class="panel-body">
	<section id="ostPanelDataPosEdc"></section>
</div>

<!-- Modal Single Delete Pos Edc -->
<div id="odvModalDeletePosEdcSingle" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospTextConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDelete" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Multiple Delete Pos Edc -->
<div id="odvModalDeletePosEdcMulti" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospTextConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDelete" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>