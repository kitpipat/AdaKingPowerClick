<input id="oetBcqStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetBcqCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-md-8">
				<ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
				<?php FCNxHADDfavorite('BookCheque/0/0');?> 
					<li id="oliฺBcqTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvBCQCallPageList()"><?= language('bookcheque/bookcheque/bookcheque','tBcqTitle')?></li>
					<li id="oliBcqAdd" class="active"><a><?= language('bookcheque/bookcheque/bookcheque','tBcqTitleAdd')?></a></li>
					<li id="oliBcqEdit" class="active"><a><?= language('bookcheque/bookcheque/bookcheque','tBcqTitleEdit')?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnChqInfo">
						<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaAdd'] == 1) : ?>
							<button id="obtฺBcqAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBCQAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnCHqAddEdit">
						<button onclick="JSvBCQCallPageList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || ($aAlwEventBookCheque['tAutStaAdd'] == 1 || $aAlwEventBookCheque['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group" >
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtBarSubmitBcq').click()"><?= language('common/main/main', 'tSave')?></button>
									<?=$vBtnSave?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="xCNMenuCump" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">

	<div id="odvContentPageBookCheque" class="panel panel-headline">
	
	</div>
</div>

<script src="<?php echo base_url('application/modules/bookcheque/assets/src/bookcheque/jBookCheque.js')?>"></script>
