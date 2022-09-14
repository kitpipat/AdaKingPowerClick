<style>
    .layout-fullwidth #wrapper .main{
        padding-left: 60px;
    }

    #odvContentWellcome {
        background-image: url('application/modules/common/assets/images/bg/Backoffice.jpg?v=1.0.0');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        opacity: 0.6 !important;
    }
</style>
<div class="odvMainContent main xWWidth100" style="padding-bottom: 0px;">
    <div class="container-fluid">
        <div class="" id="odvContentWellcome" style="margin:0px 0px; background-color:#FFF;">
        </div>
    </div>
</div>
<script>
    var tStaBuyPackage = '<?=$this->session->userdata("bSesRegStaBuyPackage")?>';
    if( tStaBuyPackage == '' ){
        
        $.ajax({
            type: "POST",
            url: "ImformationRegister",
            timeout: 0,
            success: function(tHtmlResult) {
                $('.odvMainContent').html(tHtmlResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }
</script>