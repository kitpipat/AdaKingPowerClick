<?php
    if(isset($aDataRptModule) && $aDataRptModule['rtCode'] == 1){
        $tRptModCode = $aDataRptModule['raItems']['FTRptModCode'];
        $tRptModName = $aDataRptModule['raItems']['FTRptModName'];
    }else{
        $tRptModCode = "";
        $tRptModName = "";
    }
?>
<script type="text/javascript">
    var tRptModCode = '<?php echo $tRptModCode ?>';
    var tRptModName = '<?php echo $tRptModName ?>';
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    $(document).ready(function(){
        // $('#oliRptTitle').text(tRptModName);
        $('.xCNFirstTbl tr:first-child').addClass('active');
        $('#ohdRptModCode').val($('.xCNFirstTbl tr:first-child td').data('rptmodcode'));
        $('#ohdRptGrpCode').val($('.xCNFirstTbl tr:first-child td').data('rptgrpcode'));
        $('#ohdRptCode').val($('.xCNFirstTbl tr:first-child td').data('rptcode'));
        $('#ohdRptName').val($('.xCNFirstTbl tr:first-child td').data('rptname'));
        $('#ohdRptRoute').val($('.xCNFirstTbl tr:first-child td').data('rptroute'));
        JSvCallPageReportCondition();

        // Call Function Check Data In Table History Export
        // JCNxRptChkDataInHisExport();
    });

    $('.xCNRPTSelect').click(function(){
        $('.xCNTableRpt tr').removeClass('active');    
        $(this).parent().addClass('active');
        $('#ohdRptModCode').val($(this).data('rptmodcode'));
        $('#ohdRptGrpCode').val($(this).data('rptgrpcode'));
        $('#ohdRptCode').val($(this).data('rptcode'));
        $('#ohdRptName').val($(this).data('rptname'));
        $('#ohdRptRoute').val($(this).data('rptroute'));
        JSvCallPageReportCondition();
        
        // Call Function Check Data In Table History Export
        // JCNxRptChkDataInHisExport();
    });
</script>

