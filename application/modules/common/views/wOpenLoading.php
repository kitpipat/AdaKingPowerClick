

<input type="hidden" id="ohdPdtLoading" name="ohdPdtLoading" value="<?php echo $tPageLoading; ?>">

<!-- Overlay Projects -->
<div class="xCNOverOpenPage xCNHide">
    <img src="<?php echo base_url() ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
</div>

<script>
    $( document ).ready(function() {
        var tPdtLoading = $('#ohdPdtLoading').val();
        if(tPdtLoading == 'ptOpen'){
            $('.xCNOverOpenPage').removeClass('xCNHide');
            var tPdtLoading = $('#ohdPdtLoading').val('');
        }else{
            $('.xCNOverOpenPage').addClass('xCNHide');
            var tPdtLoading = $('#ohdPdtLoading').val('');
        }
    });
</script>