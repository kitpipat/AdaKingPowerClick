
<?php 
    if($aDataListEJ['rtCode'] == '1'){
        $nCurrentPage = $aDataListEJ['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<?php if(isset($aDataListEJ['rtCode']) && $aDataListEJ['rtCode'] == '1'):?>
    <div class="row p-b-20">
        <?php foreach($aDataListEJ['raItems'] AS $nKey => $aValueEJ):?>
            <?php if($aDataListEJ['rnAllRow'] > 1):?>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="xWEJBoxFilter">
                        <label class="xCNLabelFrm xWEJLabelFilter"><?php echo @$aValueEJ['FTXshDocNo'];?></label>
                        <div class="form-group text-center">
                            <?php
                                $tEJPathEncode  = $aValueEJ['FTJnlPicPath'];
                                $tEJImgType     = 'png';
                                $aEJDecodeFile  = FCNaHFLEGetEJ($aValueEJ['FTJnlPicPath'],'png');
                                if($aEJDecodeFile['tStatus'] == 'Success' && $aEJDecodeFile['tEJFile'] != ''){
                                    $tEJPathFileImage   = $aEJDecodeFile['tEJFile'];
                                    $tStyleWidth        = "";
                                }else{
                                    $tEJPathFileImage   = base_url().'application/modules/common/assets/images/imageItemVending.png';
                                    $tStyleWidth        = "style='width:100%'";
                                }
                            ?>
                            <img src="<?php echo @$tEJPathFileImage;?>" <?php echo $tStyleWidth;?>>
                        </div>
                    </div>
                </div>
            <?php else:?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="xWEJBoxFilter">
                        <label class="xCNLabelFrm xWEJLabelFilter"><?php echo @$aValueEJ['FTXshDocNo'];?></label>
                        <div class="form-group text-center">
                            <?php
                                $tEJPathEncode  = $aValueEJ['FTJnlPicPath'];
                                $tEJImgType     = 'png';
                                $aEJDecodeFile  = FCNaHFLEGetEJ($aValueEJ['FTJnlPicPath'],'png');
                                if($aEJDecodeFile['tStatus'] == 'Success' && $aEJDecodeFile['tEJFile'] != ''){
                                    $tEJPathFileImage   = $aEJDecodeFile['tEJFile'];
                                }else{
                                    $tEJPathFileImage   = base_url().'application/modules/common/assets/images/imageItemVending.png';
                                }
                            ?>
                            <img src="<?php echo @$tEJPathFileImage;?>">
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
<?php else:?>
    <!-- Data Not Found Image -->
    <div class="row p-b-20">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="xWEJBoxFilter">
                <label class="xCNLabelFrm xWEJLabelFilter"><?php echo language('sale/reprintej/reprintej','tEJNotFoundData');?></label>
                <div class="form-group text-center">
                    <?php $tEJImgNotFound   = base_url().'application/modules/common/assets/images/imageItemVending.png';?>
                    <img src="<?php echo $tEJImgNotFound;?>">
                </div>
            </div>
        </div>
    </div>
<?php endif ?>
<div class="row">
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataListEJ['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataListEJ['rnCurrentPage']?> / <?php echo $aDataListEJ['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageReprintEJ btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvEJClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataListEJ['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                if($nPage == $i){ 
                        $tActive = 'disabled'; 
                        $tDisPageNumber = 'active'; 
                }else{
                        $tActive = '-'; 
                        $tDisPageNumber = ''; 
                }
                ?>
                <button onclick="JSvEJClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tDisPageNumber; ?>" <?php echo $tActive ?>><?php echo $i?></button>
            <?php } ?>
            
            <?php if($nPage >= $aDataListEJ['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>

            <button onclick="JSvEJClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>

        </div>
    </div>
</div>
