
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('register/register','tSrvSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchServer" name="oetSearchServer" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
						<span class="input-group-btn">
							<button id="oimSearchServer" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventServer['tAutStaFull'] == 1 || $aAlwEventServer['tAutStaDelete'] == 1 ) : ?>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<button onclick="FSfAPLRegExportJson()" class="btn btn-success"  ><?php echo language('register/register', 'tSrvFrmServerSync'); ?></button>             
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelServer"><?= language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="panel-body">
		<div id="ostDataServer"></div>
	</div>


<div class="modal fade" id="odvModalDelServer">
 	<div class="modal-dialog">
  		<div class="modal-content">
        	<div class="modal-header xCNModalHead">
    		<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
   		</div>
        <div class="modal-body">
   			<span id="ospConfirmDelete"> - </span>
    		<input type='hidden' id="ohdConfirmIDDelete">
   		</div>
   		<div class="modal-footer">
    		<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoServerDelChoose()">
     			<?=language('common/main/main', 'tModalConfirm')?>
    		</button>
    		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
     			<?=language('common/main/main', 'tModalCancel')?>
    		</button>
   		</div>
  	</div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>


<script>
	$('#oimSearchServer').click(function(){
		JCNxOpenLoading();
		JSvServerDataTable();
	});
	$('#oetSearchServer').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvServerDataTable();
		}
	});

function FSfAPLRegExportJson(){

var aOjcChcked = [];
    $(".ocbListItem:checked").map(function(index){
        aOjcChcked[index] =  {
                        'ptUrlServer':$(this).val() , 
                        'ptSyncLast':$(this).data('synlst'), 
                       }
    }).get(); // <----
	console.log(aOjcChcked);
	
    $.ajax({
          type: "POST",
          url: "ServerEventSync",
          cache: false,
          timeout: 0,
          data:{ aOjcChcked:aOjcChcked },
          success: function(tResult) {
			var paDataReturn = JSON.parse(tResult);
            if(paDataReturn['rtCode']=='001'){
                FSvCMNSetMsgSucessDialog(paDataReturn['rtDesc']);
            }else{
                FSvCMNSetMsgErrorDialog(paDataReturn['rtDesc']);
            }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
          }
      });
}

</script>
