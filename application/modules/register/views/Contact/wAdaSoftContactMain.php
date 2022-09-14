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
                    <li class="xCNLinkClick xCNHederMenuWithoutFav" onclick="JSxADCGetPageForm()" style="cursor:pointer">
                        <?php $tLangName = language('register/register','tMenuContact'); ?>
                        <?= $tLangName ?>
                    </li>
                </ol>
			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <div id="odvADCPageFrom"></div>
</form>

<script>

    $(function(){
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxADCGetPageForm();
    })
    
    function JSxADCGetPageForm(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "AdaSoftContactPageForm",
            cache: false,
            timeout: 0,
            success: function(tResultHtml){
                $("#odvADCPageFrom").html(tResultHtml);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
}
</script>