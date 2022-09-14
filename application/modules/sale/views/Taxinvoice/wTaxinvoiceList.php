<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
			<div class="col-xs-8 col-md-3 col-lg-3">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder')?>" onkeypress="Javascript:if(event.keyCode==13) JSvSalePersonDataTable()" autocomplete="off">
						<span class="input-group-btn">
							<button id="oimSearchTaxinvoiceABB" class="btn xCNBtnSearch" type="button" onclick="xxxxx()">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4 col-md-9 col-lg-9 text-right">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
	
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelTaxinvoiceABB"><?= language('common/main/main','tDelAll')?></a>
						</li>
					</ul>	
				</div>
			</div>
		</div>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataTaxinvoiceABB"></section>
        <!-- End DataTable-->
    </div>
</div>

<?php include "script/jTaxinvoiceABB.php"; ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>



