<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php foreach($aDataListEJ AS $nKey => $aValueEJ):?>
            <?php
                $tEJPathEncode  = $aValueEJ['FTJnlPicPath'];
                $tEJImgType     = 'png';
                $aEJDecodeFile  = FCNaHFLEGetEJ($tEJPathEncode,'png');
                if($aEJDecodeFile['tStatus'] == 'Success' && $aEJDecodeFile['tEJFile'] != ''){
                    $tEJPathFileImage   = $aEJDecodeFile['tEJFile'];
                }else{
                    $tEJPathFileImage   = base_url().'application/modules/common/assets/images/imageItemVending.png';
                }
            ?>
            <div class="form-group text-left xWDivImgABB">
                <img src="<?php echo @$tEJPathFileImage;?>">
            </div>
        <?php endforeach;?>
    </div>
</div>