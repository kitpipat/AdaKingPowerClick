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

            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">      
                <ol id="oliMenuNav" class="breadcrumb">
                    <li class="xCNLinkClick xCNHederMenuWithoutFav" onclick="JSxIMRImformationRegister()" style="cursor:pointer">
                        <?php $tLangName = language('register/register','tIMRRenew'); ?>
                        <?= $tLangName ?>
                    </li>
                </ol>
            </div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"></div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceImport">
	<div id="odvLRNPageFrom"></div>
</form>


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
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/register/assets/src/LicenseRenew/jLicenseRenew.js')?>"></script>
<script>
//Functionality : Event Call API
    //Parameters : 
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSxIMRImformationRegister(){
        JCNxOpenLoading();
        $.ajax({
            url: 'ImformationRegister',
            type: "POST",
            error: function (jqXHR, textStatus, errorThrown) {
            JCNxCloseLoading();
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success: function (tView) {
            $(window).scrollTop(0);
            $('.odvMainContent').html(tView);
            }
         });
    
}


</script>