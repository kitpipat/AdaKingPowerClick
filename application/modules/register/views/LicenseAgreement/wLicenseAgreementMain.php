<style>
    .xCNHederMenuWithoutFav{
        font-family : THSarabunNew-Bold;
        font-size   : 21px !important;
        line-height : 32px;
        font-weight : 500;
        color       : #179bfd !important;
    }

    #odvLCGPageFrom{
        margin: 0px 10px 10px 10px;
        box-shadow: 0 2px 6px rgb(0 0 0 / 8%);
        background-color: #fff;
        margin-bottom: 30px;
        padding-top : 30px;
    }
</style>

<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li class="xCNLinkClick xCNHederMenuWithoutFav" onclick="FSvLCGGetPageForm()" style="cursor:pointer">
                        <?php $tLangName = language('register/register','tMenuLicenseAgreement'); ?>
                        <?= $tLangName ?>
                    </li>
                </ol>
			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceImport">
    <div id="odvLCGPageFrom"></div>
</form>

<script>

$(function(){
	JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
	FSvLCGGetPageForm();
})
    
function FSvLCGGetPageForm(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "LicenseAgreementPageForm",
        cache: false,
        timeout: 0,
        success: function(tResultHtml){
            $("#odvLCGPageFrom").html(tResultHtml);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
</script>