<?php //print_r($aPdtImgList); ?> 

          <!-- <?php if($Value['FNImgSeq'] == 1):?>
            <td>
                <img src="<?php echo base_url();?>application/assets/system/<?php echo $Value['FTImgObj']; ?>" class="img img-respornsive" style="z-index: 100;">
            </td>
            <?php endif; ?> -->
<?php if(is_array($aPdtImgList) == 1):?>
<?php
    if(isset($aPdtImgList[0]['FTImgObj']) && !empty($aPdtImgList[0]['FTImgObj'])){
        $tFullPatch = './application/modules/common/assets/system/systemimage/'.$aPdtImgList[0]['FTImgObj'];
        if (file_exists($tFullPatch)){
            $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$aPdtImgList[0]['FTImgObj'];
        }else{
            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
        }
    }else{
        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
    }
?>
<img class="img-responsive xCNPdtImgScan" id="oimPdtImgScan" src="<?= $tPatchImg; ?>" style="width:45%;">
<div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">
    <table>
            <td>
            <?php foreach($aPdtImgList AS $Key => $Value): ?>
                <?php
                    if(isset($Value['FTImgObj']) && !empty($Value['FTImgObj'])){
                        $tFullPatch = 'application/'.$Value['FTImgObj'];
                        if (file_exists($tFullPatch)){
                            $tPatchImg = base_url().'application/'.$Value['FTImgObj'];
                        }else{
                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                    }else{
                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                    }
                ?>
                <img src="<?= $tPatchImg; ?>" class="xCNPdtImgScanTumblr img img-respornsive" style="z-index: 100;width:30%;margin-top:10px">
                <?php endforeach;?>
            </td>
    </table>
</div>
<?php else:?>
<img class="img-responsive xCNPdtImgScanNo" id="oimPdtImgScan" src="<?php echo base_url();?>application/modules/common/assets/images/Noimage.png">
<?php endif;?>
<script>
    //Image Select
    $('.xCNPdtImgScanTumblr').click(function(ele){
        tSrc = $(this).attr('src');
        $('#oimPdtImgScan').attr('src',tSrc);
    });
</script>