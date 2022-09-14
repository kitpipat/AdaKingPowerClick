<style>
    .xCNHederMenuWithoutFav{
        font-family : THSarabunNew-Bold;
        font-size   : 21px !important;
        line-height : 32px;
        font-weight : 500;
        color       : #179bfd !important;
    }
</style>

<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">

            <div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">      
                <ol id="oliMenuNav" class="breadcrumb">
                    <li class="xCNLinkClick xCNHederMenuWithoutFav" onclick="JSxIMRGetPageFormAndCallAPI()" style="cursor:pointer">
                        <?php $tLangName = language('register/register','tMenuInformation'); ?>
                        <?= $tLangName ?>
                    </li>
                </ol>
            </div>
			
			<div class="col-xs-6 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown" aria-expanded="false">
					<?php echo language('register/register','tIMRImport') ?> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li  >
						  <a data-toggle="modal" data-target="#odvModalImportAccountJson"><?php echo language('register/register','tIMRImportAccount') ?></a>
						</li>
						<li  >
						  <a data-toggle="modal" data-target="#odvModalImportLicenseJson"><?php echo language('register/register','tIMRImportLicense') ?></a>
						</li>
					</ul>
				</div>
	
			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceImport">
<div id="odvIMRPageFrom"></div>
</form>

<!--Modal Success-->
<div class="modal fade" id="odvModalImportAccountJson">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('register/register','tIMRImportAccount'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="form-group">
                 <label class="xCNLabelFrm"><?=language('register/register', 'tMassageImportFile')?></label>
                <div class="input-group input-file-account" name="Fichier1">
                    <input type="text" class="form-control" placeholder='<?=language('register/register', 'tMassageImportFile')?>' />			
                    <span class="input-group-btn">
                     <button class="btn btn-info btn-choose" type="button"><i class="fa fa-folder-open" aria-hidden="true"></i> &nbsp;<?=language('register/register', 'tIMPISelectBrows')?></button>
                    </span>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button  type="button"  id="obtIFIModalMsgConfirm" class="btn xCNBTNPrimery" onclick="JSxIMRImportAccount()">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
				<button type="button" id="obtIFIModalMsgCancel" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="odvModalImportLicenseJson">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('register/register','tIMRImportLicense'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<div class="form-group">
                 <label class="xCNLabelFrm"><?=language('register/register', 'tMassageImportFile')?></label>
                <div class="input-group input-file-license" name="Fichier1">
                    <input type="text" class="form-control" placeholder='<?=language('register/register', 'tMassageImportFile')?>' />			
                    <span class="input-group-btn">
                     <button class="btn btn-info btn-choose" type="button"><i class="fa fa-folder-open" aria-hidden="true"></i> &nbsp;<?=language('register/register', 'tIMPISelectBrows')?></button>
                    </span>
                </div>
            </div>
            </div>
            <div class="modal-footer">
                <button  type="button"  id="obtIFIModalMsgConfirm" class="btn xCNBTNPrimery" onclick="JSxIMRImportLicense()">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
				<button type="button" id="obtIFIModalMsgCancel" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/register/assets/src/information/jInformationRegister.js')?>"></script>
