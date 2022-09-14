<?php
echo '<per>';
	// print_r($aAlwEventEvnth);
echo '</per>'; 
?>
<input id="oetEvnthStaBrowse" type="hidden" value="<?=$nEvnthBrowseType?>">
<input id="oetVocCallBackOption" type="hidden" value="<?=$tEvnthBrowseOption?>">

<div id="odvVocMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<li id="oliEvnthTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageEventhallList()"><?= language('eventhall/eventhall/eventhall','tEvthTitle')?></li>
					<li id="oliEvnthTitleAdd" class="active"><a><?= language('eventhall/eventhall/eventhall','tEvthTitleAdd')?></a></li>
					<li id="oliEvnthTitleEdit" class="active"><a><?= language('eventhall/eventhall/eventhall','tEvthTitleEdit')?></a></li>
				</ol>
			</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div class="demo-button xCNBtngroup" style="width:100%;">
				<div id="odvBtnEventInfo">
					<?php if($aAlwEventEvnth['tAutStaFull'] == 1 || $aAlwEventEvnth['tAutStaAdd'] == 1) : ?>
					<button id="obtVocAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardCouponAdd()">+</button>
				<?php endif; ?>
			</div>
		<div id="odvBtnAddEdit">
			<button onclick="JSvCallPageEventhallList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
				<?php if($aAlwEventEvnth['tAutStaFull'] == 1 || ($aAlwEventEvnth['tAutStaAdd'] == 1 || $aAlwEventEvnth['tAutStaEdit'] == 1)) : ?>
					<div class="btn-group"  id="obtBarSubmitCpn">
						<div class="btn-group">
						<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCoupontype').click()"><?= language('common/main/main', 'tSave')?></button>
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
	<div id="odvContentPageEventhall" class="panel panel-headline">
	</div>
</div>

<script src="<?php echo base_url('application/modules/eventhall/assets/src/eventhall/jEventhall.js')?>"></script>
