
<div class="divShop">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-3 text-center">
					<img src="<?php if(@$aDataBranch['roItem']['rtImgObj']!= ''){ echo base_url()."/application/modules/common/assets/system/systemimage/".$aDataBranch['roItem']['rtImgObj']; }else{ echo "http://www.bagglove.com/images/400X200.gif"; } ?>" class="xWLogoHeaderBchPageShp">
				</div>
				<div class="col-md-9">
					<div class="row">
						<div class="col-md-12">
							<label class="xCNTextDetail1" style="float:left;">สาขา  &nbsp;</label>
	                        <p class="xCNTextDetail2" ><?= @$aDataBranch['roItem']['rtBchCode']." # ".@$aDataBranch['roItem']['rtBchName'] ?></p>	
	                    </div>
                    </div>
                    <?= $vBranchAddressView; ?>
				</div>
				<div>
				<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
					<button onclick="JSvSHPAddPageFromBch('<?= @$tBchCode ?>');" id="obtAddShp" class="xCNHide" type="submit"> add </button>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="panel-body">
		
			<div class="row">
				<div class="col-md-4" style="margin-bottom:20px">
					<div class="wrap-input100">
						<span class="label-input100">ค้นหา</span>
						<input class="input100" type="text" id="oetShopSearch" name="oetShopSearch" onkeyup="Javascript:if(event.keyCode==13) JSvBranchToShopDataTable()" value="<?=@$tSearch?>">
						<span class="focus-input100"></span>
						<img onclick="JSvBranchToShopDataTable()" class="xCNIconBrowse" src=" <?php echo base_url().'application/modules/common/assets/images/icons/search-24.png'; ?>">
						<input type="text" class="xCNHide" id="ohdBchCode" value="<?= $tBchCode ?>">
					</div>
				</div>
			</div>
			
			<!--- Data Table -->
			<section id="ostDataBranchShop">
			</section>
			<!-- End DataTable-->
			
		</div>
</div>
</div>

<div class="modal fade" id="odlmodaldeleteBranch">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnShopDelChooseFromBch()">
        		<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?> </button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
        		<i class="fa fa-times-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalCancel')?> </button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

    $(function(){

    	localStorage.removeItem('LocalItemData');
    	
    	$('#odvRGPList tr td').click(function(){
        	
			if($(this).is(":last-child")){
			  	//alert('into Function delete');
			}else if( $(this).is(":nth-last-child(2)")){
				//alert('into Function delete');
			}else{
				$('#odvRGPList > tr').css('background-color','#FFF');
				$(this).parent('tr').css('background-color','#eaeaea');
				var nCode = $(this).parent('tr').data('code');  //code
				var tName = $(this).parent('tr').data('name');  //name
				$(this).parent('tr').find('.ocbListItem').prop('checked', true);

				var LocalItemData = localStorage.getItem("LocalItemData");
				var obj = [];
				if(LocalItemData){
					obj = JSON.parse(LocalItemData);
				}else{ }
				var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
				if(aArrayConvert == '' || aArrayConvert == null){
					obj.push({"nCode": nCode, "tName": tName });
					localStorage.setItem("LocalItemData",JSON.stringify(obj));
					JSxTextinModal();
				}else{
					var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
					if(aReturnRepeat == 'None' ){					//ยังไม่ถูกเลือก
						obj.push({"nCode": nCode, "tName": tName });
						localStorage.setItem("LocalItemData",JSON.stringify(obj));
						JSxTextinModal();
					}else if(aReturnRepeat == 'Dupilcate'){			//เคยเลือกไว้แล้ว
						$('#odvRGPList > tr').css('background-color','');
						$(this).parent('tr').css('background-color','');
						localStorage.removeItem("LocalItemData");
						$(this).parent('tr').find('.ocbListItem').prop('checked', false);

						var nLength = aArrayConvert[0].length;
						for($i=0; $i<nLength; $i++){
							if(aArrayConvert[0][$i].nCode == nCode){
								delete aArrayConvert[0][$i];
							}
						}

						var aNewarraydata = [];
						for($i=0; $i<nLength; $i++){
							if(aArrayConvert[0][$i] != undefined){
								aNewarraydata.push(aArrayConvert[0][$i]);
							}
						}
						localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
						JSxTextinModal();
					}
				}
				JSxShowButtonChoose();
			}
		});
    });