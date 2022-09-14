<?php 
    if(isset($aCMDDataExport) && $aCMDDataExport['rtCode'] == 1){
        $aDataExport    = $aCMDDataExport['raItems'];
        $nAllRow        = $aCMDDataExport['rnAllRow'];
        $nCurrentPage   = $aCMDDataExport['rnCurrentPage'];
        $nAllPage       = $aCMDDataExport['rnAllPage'];
    }else{
        $aDataExport    = "";
        $nAllRow        = 0;
        $nCurrentPage   = 0;
        $nAllPage       = 0;
    }
?>
<style>
    .xWExpStaSuccess {
        color: #007b00 !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWExptaInProcess {
        color: #7b7f7b !important;
        font-size: 18px !important;
        font-weight: bold;
    }
    .xWExpStaUnsuccess {
        color: #f60a0a !important;
        font-size: 18px !important;
        font-weight: bold;
    }
</style>
<!-- <div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6">
        <div class="form-group">
            <label class="xCNLabelFrm"><?php echo language('document/cardmngdata/cardmngdata','tCMDSearchDetail')?></label>
            <div class="input-group">
                <input type="text" class="form-control" id="oetCMDSearchExport" name="oetCMDSearchExport" value="<?php echo $tSearchAll ?>">
                <span class="input-group-btn">
                    <button id="obtCMDSearchExport" class="btn xCNBtnSearch" type="button">
                        <img  src="<?php echo base_url('/application/modules/common/assets/images/icons/search-24.png'); ?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
</div> -->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbMngDataTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center xCNTextBold" style="width:5%;"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBNo')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBCode')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBName')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBStartDate')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBExpireDate')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBCardType')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBStaType')?></th>
                        <th class="text-center xCNTextBold"><?php echo  language('document/cardmngdata/cardmngdata','tCMDTBStatus')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($aDataExport)):?>
                        <?php foreach($aDataExport AS $nKey => $aValue):?>
                            <tr class="text-center xWDataExportList">
                                <td><?php echo $aValue['rtRowID']?></td>
                                <td><?php echo $aValue['rtCrdCode']?></td>
                                <td class="text-left"><?php echo $aValue['rtCrdName']?></td>
                                <td><?php echo (!empty($aValue['rtCrdStartDate']))? date("Y-m-d", strtotime($aValue['rtCrdStartDate'])) : '-';?></td>
                                <td><?php echo (!empty($aValue['rtCrdExpireDate']))? date("Y-m-d", strtotime($aValue['rtCrdExpireDate'])) : '-';?></td>
                                <td><?php echo $aValue['rtCrdCtyName']?></td>
                                <td><?php echo ($aValue['rtCrdStaType'] == 1)? language('payment/card/card','tCRDFrmCrdStaTypeDefault') : language('payment/card/card','tCRDFrmCrdStaTypeAuto') ?></td>
                                <?php
                                    if($nStaProcess == "1"){
                                        $tTextStaProcess    = language('document/cardmngdata/cardmngdata','tCMDStaSuccess');
                                        $tClassStaProcess   = "xWExpStaSuccess";
                                    }else{
                                        $tTextStaProcess    = language('document/cardmngdata/cardmngdata','tCMDStaInProcess');
                                        $tClassStaProcess   = "xWExptaInProcess";
                                    }
                                ?>
                                <td><label class="<?php echo $tClassStaProcess; ?>"><?php echo $tTextStaProcess;?></label></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                        <tr><td class='text-center' colspan='9'><?php echo language('payment/card/card','tCMDTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6  col-sm-6 col-md-6 col-lg-6">
        <p>พบข้อมูลทั้งหมด <?php echo $nAllRow;?> รายการ แสดงหน้า <?php echo $nCurrentPage;?> / <?php echo $nAllPage;?></p>
    </div>
    <div class="col-xs-6  col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageExportMngData btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvExportClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($nAllPage,$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvExportClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $nAllPage){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvExportClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script>
	$('#obtCMDSearchExport').click(function(){
        var aReturn = JSoChkConditionExport();
        if(aReturn['nStaCheck'] == 1){
            JSvExpSelectDataInTable(1,aReturn['aDataCondition']);
        }
	});
	$('#oetCMDSearchExport').keypress(function(event){
		if(event.keyCode == 13){
            var aReturn = JSoChkConditionExport();
            if(aReturn['nStaCheck'] == 1){
                JSvExpSelectDataInTable(1,aReturn['aDataCondition']);
            }     
		}
	});
</script>
