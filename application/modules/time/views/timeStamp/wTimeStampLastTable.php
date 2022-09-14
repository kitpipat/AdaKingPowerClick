<!-- L A S T -->
<style>
    .scrollmenu{
        overflow        : auto;
        white-space     : nowrap;
    }

    .xCNContentUser{
        display         : inline-block;
        padding         : 20px;
        margin-right    : 10px;
        animation       : fadein 2s;
    }

    .xCNImagePerson{
        border-radius   : 50%;
        border          : 1px solid #b9b9b9;
        width           : 120px;
        height          : 120px;
        object-fit      : cover;
    }

    #ospTextUsername{
        margin-top      : 10px;
        text-align      : center;
    }

    @keyframes fadein {
        from {
            opacity:0;
        }
        to {
            opacity:1;
        }
    }

</style>
<div class="row">
    <div class="col-md-12 scrollmenu">

        <?php if($aResultLast['rtCode'] == 800){ ?>
            <p style="text-align: center;"><?= language('time/timeStamp/timeStamp','tMsgTimeStampNofoundData')?></p>
        <?php }else{ ?>
            
            <!--loop image user -->
            <?php foreach($aResultLast['raItems'] AS $nKey => $aValue): ?>
                <?php
                    if(isset($aValue['FTImgObj']) && !empty($aValue['FTImgObj'])){
                        $tFullPatch = './application/assets/system/'.$aValue['FTImgObj'];
                        if (file_exists($tFullPatch)){
                            $tPatchImg = base_url().'/application/assets/system/'.$aValue['FTImgObj'];
                        }else{
                            $tPatchImg = base_url().'/application/modules/common/assets/images/Noimage.png';
                        }
                    }else{
                        $tPatchImg = base_url().'/application/modules/common/assets/images/Noimage.png';
                    }
                ?>
                                    
                <div class="xCNContentUser">
                    <div class="row">
                        <div><img class="xCNImagePerson" src="<?=$tPatchImg?>"></div>
                    </div>
                    <div class="row">
                        <p id="ospTextUsername"><?php echo $aValue['FTUsrName']; ?></p>
                    </div>
                </div>
            <?php endforeach;?>
            <!--end loop image user -->

        <?php } ?>
    </div>
</div>