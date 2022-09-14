<input id="oetTimeStampStaBrowse" type="hidden" value="<?=$nTimeStampBrowseType?>">
<input id="oetTimeStampCallBackOption" type="hidden" value="<?=$tTimeStampBrowseOption?>">

<div id="odvTimeStampMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">

			<div class="xCNTimeStampVMaster">
				<div class="col-xs-12 col-md-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliTimeStampTitle" class="xCNLinkClick" onclick="JSvCallPageTimeStampMainContent('')"><?= language('time/timeStamp/timeStamp','tTimeStampTitle')?></li>
						<li id="oliTimeStampDetail" class="active"><a><?= language('time/timeStamp/timeStamp','tMsgTimeStampDataInputandDataOutput')?></a></li>
					</ol>
				</div>

				<div class="col-xs-12 col-md-4 text-right">
					<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
						<button type="button" class="btn xCNBTNMngTable" id="obtCheckDetail" >
							<?= language('time/timeStamp/timeStamp','tMsgTimeStampCheckDetail')?>
						</button>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<div class="xCNMenuCump xCNTimeStampBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPageTimeStamp"></div>
</div>
	

<script src="<?= base_url('application/modules/time/assets/src/timeStamp/jTimeStamp.js')?>"></script>
