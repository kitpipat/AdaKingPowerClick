<link rel="stylesheet" href="<?php echo base_url();?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>">


<?php 

if($tTypemedia == 1 || $tTypemedia == 2 || $tTypemedia == 4){
    //ข้อความต้อนรับ[1] ของเจมส์ = ข้อความ[3] ของพี่เบลล์
    $tCheckType01 = '';
    $tCheckType02 = '';
    $tCheckType03 = 'selected';
    $tCheckType04 = '';
}else if($tTypemedia == 5){
    //เสียงประชาสัมพันธ์[2] ของเจมส์ = เสียง[1] ของพี่เบลล์
    $tCheckType01 = 'selected';
    $tCheckType02 = '';
    $tCheckType03 = '';
    $tCheckType04 = '';
}else if($tTypemedia == 3){
    //ภาพเคลื่อนไหว[3] ของเจมส์ = วิดีโอ[2] ของพี่เบลล์
    $tCheckType01 = '';
    $tCheckType02 = 'selected';
    $tCheckType03 = '';
    $tCheckType04 = '';
}else if($tTypemedia == 6){
    //รูปภาพ[6] ของเจมส์ = รูปภาพ[4] ของพี่เบลล์
    $tCheckType01 = '';
    $tCheckType02 = '';
    $tCheckType03 = '';
    $tCheckType04 = 'selected';
}

?>

<div class="panel-body" style="padding:10px">
    <div id="odvModalMenuPosAdsMedia" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <div class="form-group">
                <select id="ostPosAdsMediaType" class="selectpicker xWPosAdsMediaSlt">
                    <option value="1" <?=$tCheckType01;?>><?php echo language('pos/posads/posads','tPosAdsMediaTypeSound') ?></option>
                    <option value="2" <?=$tCheckType02;?>><?php echo language('pos/posads/posads','tPosAdsMediaTypeVideo') ?></option>
                    <option value="3" <?=$tCheckType03;?>><?php echo language('pos/posads/posads','tPosAdsTypeMessage');?></option>  
                    <option value="4" <?=$tCheckType04;?>><?php echo language('pos/posads/posads','tPosAdsTypeImage');?></option>
                </select>
            </div>
        </div>
    </div>
    <!--  Sound  -->
    <div id="odvModalPosAdsSound" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height:500px;overflow:auto;">
            <div id="odvPosAdsMediaImage" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php  $nRowStartVdo = 0; if(isset($aDataPosAdsVD) && $aDataPosAdsVD['rtCode'] == '1'):?>
                        <?php  foreach($aDataPosAdsVD['raItems'] AS $nKey => $aValue):?>
                            <?php if($aValue['FNMedType'] == '1'):?>  <!-- Type 1 = Sound  -->
                                <script>
                                    $('#odvPosAdsMediaImage').css('height','400px');
                                    $('.item').css({'left':'25%' ,'margin-top':'25%'});
                                </script>
                                <div id="odvPosAdsVedio<?php echo $aValue['FTMedRefID'].$aValue['FNMedSeq']?>" class="<?php echo ($nRowStartVdo == 0)? 'item active':'item';?>">
                                    <?php if(isset($aValue['FTMedPath']) && !empty($aValue['FTMedPath'])): ?>
                                        <?php 
                                            $aValueImgExplode = explode('/',$aValue['FTMedPath']);
                                            $tFullPatch = './application/modules/pos/assets/systemimg/admessage/'.$aValue['FTMedRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                            $tFullPatchUse = '/application/modules/pos/assets/systemimg/admessage/'.$aValue['FTMedRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                        ?>
                                        <?php if (file_exists($tFullPatch)): ?>
                                            <audio controls style="width:50%;">
                                                <source  src="<?php echo  base_url().$tFullPatchUse;?>" type="audio/mp3">
                                            </audio>
                                            <div class="carousel-caption">
                                            </div>
                                        <?php else: ?>
                                            <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                            <div class="carousel-caption">
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                        <div class="carousel-caption">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php $nRowStartVdo = 1;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php else: ?>
                        <div id="odvPosAdsNoImageData" class="item active">
                            <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                            <div class="carousel-caption">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#odvPosAdsMediaImage" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#odvPosAdsMediaImage" role="button" data-slide="next" style="right:0;top:0">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Vedio -->
    <div id="odvModalPosAdsVideo" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height:500px;overflow:auto;">
            <div id="odvPosAdsMediaVdo" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php  $nRowStartVdo = 0; if(isset($aDataPosAdsVD) && $aDataPosAdsVD['rtCode'] == '1'):?>
                        <?php  foreach($aDataPosAdsVD['raItems'] AS $nKey => $aValue):?>
                            <?php if($aValue['FNMedType'] == '2'):?>  <!-- Type 2 = VDO  -->
                                <div id="odvPosAdsVedio<?php echo $aValue['FTMedRefID'].$aValue['FNMedSeq']?>" class="<?php echo ($nRowStartVdo == 0)? 'item active':'item';?>">
                                    <?php if(isset($aValue['FTMedPath']) && !empty($aValue['FTMedPath'])): ?>
                                        <?php 
                                            $aValueImgExplode = explode('/',$aValue['FTMedPath']);
                                            $tFullPatch = './application/modules/pos/assets/systemimg/admessage/'.$aValue['FTMedRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                            $tFullPatchUse = '/application/modules/pos/assets/systemimg/admessage/'.$aValue['FTMedRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                        ?>
                                        <?php if (file_exists($tFullPatch)): ?>
                                            <video style="width:100%;"  controls>
                                                <source src="<?php echo  base_url().$tFullPatchUse;?>" type="video/mp4">
                                            </video>
                                            <div class="carousel-caption">
                                            </div>
                                        <?php else: ?>
                                            <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                            <div class="carousel-caption">
                                            </div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                        <div class="carousel-caption">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php $nRowStartVdo = 1;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php else: ?>
                        <div id="odvPosAdsNoImageData" class="item active">
                            <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                            <div class="carousel-caption">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Controls -->
                <a class="left carousel-control" href="#odvPosAdsMediaVdo" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo language('common/main/main','tPreviousText')?></span>
                </a>
                <a class="right carousel-control" href="#odvPosAdsMediaVdo" role="button" data-slide="next" style="right:0;top:0">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only"><?php echo language('common/main/main','tNextText')?></span>
                </a>
            </div>
        </div>                  
    </div>

    <!-- Message -->
    <!-- Create by Witsarut 03/09/2019 -->
    <div id="odvModalPosAdsMessage" class="row" style="height: 400px;">
        <div id="odvPosAdsMessage" class="carousel slide" data-ride="carousel" style="height: 400px;">
            <div class="carousel-inner" role="listbox" style="height: 400px;">
                <!-- Message for slides -->
                <div class="carousel-inner" role="listbox" style="height: 100%;">
                    <?php  $nRowStartVdo = 0; if(isset($aDataPosMsg) && $aDataPosMsg['rtCode'] == '1'):?>
                        <?php  foreach($aDataPosMsg['raItems'] AS $nKey => $aValue):?>   
                            <!-- (INDEX)ประเภท 1:ข้อความต้อนรับ  2:ข้อความประชาสัมพันธ์  4.ข้อความขอบคุณ -->
                            <?php if($aValue['rtAdvType'] == '1' || $aValue['rtAdvType'] == '2' || $aValue['rtAdvType'] == '4') :?> 
                                    <div style=" text-align: center; position: relative; top: 30%; font-size: 40px !important; ">
                                        <?php echo ($aValue['rtAdvMsg']); ?>
                                    </div>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Type Image -->
    <div id="odvModalPosAdsImage" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height:500px;overflow:auto;">
        <div id="odvPosAdsImage" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox" style="height: 400px;">
                <!-- Image for slides -->
                <div class="carousel-inner" role="listbox" style="height: 100%;">
                    <?php  $nRowStartVdo = 0; if(isset($aDataImgObj) && $aDataImgObj['rtCode'] == '1'):?>
                        <?php  foreach($aDataImgObj['raItems'] AS $nKey => $aValue):?> 
                            <script>
                                $('#odvPosAdsImage').css('height','400px');
                                $('.item').css({'left':'25%'});
                            </script>

                            <div id="odvPosAdsVedio<?php echo $aValue['FTImgRefID'].$aValue['FNImgSeq']?>" class="<?php echo ($nRowStartVdo == 0)? 'item active':'item';?>">
                                <?php if(isset($aValue['FTImgObj']) && !empty($aValue['FTImgObj'])): ?>
                             
                                    <?php 
                                        $aValueImgExplode = explode('/',$aValue['FTImgObj']);
                                        $tFullPatch = './application/modules/pos/assets/systemimg/admessage/'.$aValue['FTImgRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                        $tFullPatchUse = '/application/modules/pos/assets/systemimg/admessage/'.$aValue['FTImgRefID'].'/'.$aValueImgExplode[FCNnHSizeOf($aValueImgExplode)-1];
                                    ?>
                                    <?php if (file_exists($tFullPatch)): ?>
                                        <img src="<?php echo  base_url().$tFullPatchUse;?>" style="width:50%">
                                        <div class="carousel-caption">
                                        </div>
                                    <?php else: ?>
                                        <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                        <div class="carousel-caption">
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <img src="<?php echo base_url().'application/modules/common/assets/images/200x322.png'?>" style="width:100%">
                                    <div class="carousel-caption">
                                    </div>
                                <?php endif; ?>
                         
                            </div>
                            <?php $nRowStartVdo = 1;?>
                        <?php endforeach;?>
                    <?php endif; ?>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#odvPosAdsImage" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only"><?php echo language('common/main/main','tPreviousText')?></span>
                    </a>
                    <a class="right carousel-control" href="#odvPosAdsImage" role="button" data-slide="next" style="right:0;top:0">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only"><?php echo language('common/main/main','tNextText')?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#ostPosAdsMediaType').selectpicker();
        JSxPosAdsSeleteTypeMedia();
    });

    $('#ostPosAdsMediaType').change(function(){ 
        JSxPosAdsSeleteTypeMedia();
    });

    function JSxPosAdsSeleteTypeMedia(){
        var nPosAdsMedia    =   $('#ostPosAdsMediaType').val();
        if(nPosAdsMedia == '1'){
            $('#odvModalPosAdsMessage').hide();
            $('#odvModalPosAdsVideo').hide();
            $('#odvModalPosAdsImage').hide();
            $('#odvModalPosAdsSound').show();
        }else if(nPosAdsMedia == '2'){
            $('#odvModalPosAdsVideo').show();
            $('#odvModalPosAdsSound').hide();
            $('#odvModalPosAdsImage').hide();
            $('#odvModalPosAdsMessage').hide();
        }else if(nPosAdsMedia == '3'){
            $('#odvModalPosAdsVideo').hide();
            $('#odvModalPosAdsSound').hide();
            $('#odvModalPosAdsImage').hide();
            $('#odvModalPosAdsMessage').show();
        }else if(nPosAdsMedia == '4'){
            $('#odvModalPosAdsVideo').hide();
            $('#odvModalPosAdsSound').hide();
            $('#odvModalPosAdsMessage').hide();
            $('#odvModalPosAdsImage').show();
        }else{}
    }

</script>