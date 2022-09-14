<div class="">
    <div class="">
        <div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetCstBchSearchAll" name="oetCstBchSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvCBLCstBuyLicGetDataTable()" placeholder="<?= language('common/main/main','tSearch')?>">
						<span class="input-group-btn">
							<button id="oimSearchCustomer" class="btn xCNBtnSearch" type="button" onclick="JSvCBLCstBuyLicGetDataTable()">
								<img class="xCNIconAddOn" src="<?php echo base_url()?>/application/modules/common/assets/images/icons/search-24.png">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:20px;">
				<div class="col-xs-12 col-md-12 text-right p-r-0">
				    <button onclick="JSaSyncLicenseAll()" class="btn btn-success"  ><?php echo language('customerlicense/customerlicense/customerlicense', 'tAPCRegUpdateLicense'); ?></button>             
					<button onclick="JSfAPLRegExportJson()" class="btn btn-info"  ><?php echo language('customerlicense/customerlicense/customerlicense', 'tAPCRegExportJson'); ?></button>             
				</div>
			</div>
		</div>
    </div>
    <div class="">
        <!--- Data Table -->
        <section id="ostDataCustomerBuyLic"></section>
        <!-- End DataTable-->
    </div>
</div>



