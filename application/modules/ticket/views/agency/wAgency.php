<input id="oetANGStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetANGCallBackOption" type="hidden" value="<?=$tBrowseOption?>">


<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
	<div id="odvBchMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('agency/0/0');?> 
							<li id="oliAngTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageAgencyList()"><?= language('ticket/agency/agency', 'tSalesAgentInfo'); ?></li>
							<li id="oliAngTitleAdd" class="active"><a><?= language('ticket/agency/agency','tAddSalesAgent')?></a></li>
							<li id="oliAgnTitleEdit" class="active"><a><?= language('ticket/agency/agency','tEditSalesAgent')?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
						<div id="odvBtnAddEdit">
							<button onclick="JSvCallPageAgencyList()" id="obtBarBackBch" class="btn btn-default xCNBTNDefult" type="submit"> <?= language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEventAgency['tAutStaFull'] == 1 || ($aAlwEventAgency['tAutStaAdd'] == 1 || $aAlwEventAgency['tAutStaEdit'] == 1)) : ?>
									<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitAgency').click()"><?= language('common/main/main', 'tSave')?></button>
									<?=$vBtnSave?>
								</div>
							<?php endif; ?>
						</div>
					<div id="odvBtnAgnInfo">
							<?php 
							$tUserLevel  = $this->session->userdata('tSesUsrLevel');
							if($aAlwEventAgency['tAutStaFull'] == 1 || $aAlwEventAgency['tAutStaAdd'] == 1) : ?>
								<button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageAgencyAdd();">+</button>							
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageAgency" class="panel panel-headline"></div>
	</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliAgnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('company/branch/branch','tBchAgnTitle')?></a></li>
                    <li class="active"><a><?php echo language('company/branch/branch','tAddSalesAgent')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvAgnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitAgency').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>	

<script src="<?php echo base_url('application/modules/ticket/assets/src/agency/jAgency.js')?>"></script>



