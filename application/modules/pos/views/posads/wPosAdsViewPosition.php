<link rel="stylesheet" href="<?php echo base_url();?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>">
<div class="panel-body" style="padding:10px">
    <div id="odvModalMenuPosAdsMedia" class="row">
        <!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <div class="form-group">
                <select id="ostPosAdsPicType" class="selectpicker xWPosAdsMediaSlt">
                    <option value="2"><?php echo language('pos/posads/posads','tPosAdsMediaTypeImage') ?></option>
                    <option value="1"><?php echo language('pos/posads/posads','tPosAdsMediaTypeVideo') ?></option>
                </select>
            </div>
        </div> -->
    </div>
    <div id="odvModalPosAdsImage" class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height:500px;overflow:auto;">  
                <?php
                    switch ($tPosAdsPosition){
                        case 'BM':
                            // application/modules/common/assets/images/pos/posads  Path เก็บรูป-v
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/BM.png';
                        break;
                        
                        case 'TR':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/TR.png';
                        break;

                        case 'AL':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/AL.png';
                        break;

                        case 'BL':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/BL.png';
                        break;

                        case 'BR':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/BR.png';
                        break;

                        case 'ML':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/ML.png';
                        break;

                        case 'MM':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/MM.png';
                        break;   

                        case 'MR':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/MR.png';
                        break;

                        case 'TL':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/TL.png';
                        break;  

                        case 'TM':
                            $tPatchImg  = base_url().'/application/modules/common/assets/images/pos/posads/TM.png';
                        break;  
   
                    default:
                        $tPatchImg = base_url().'application/modules/common/assets/images/200x322.png';
                    }    
                ?>
            <img src="<?php echo $tPatchImg; ?>" style="width:100%;height:100%">
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/vendor/bootstrap-select-1.13.2/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#ostPosAdsPicType').selectpicker();
        JSxPosAdsSeleteTypeMedia();
    });

    $('#ostPosAdsPicType').change(function(){ 
        JSxPosAdsSeleteTypeMedia();
    });

    function JSxPosAdsSeleteTypeMedia(){
        var nPosAdsMedia    =   $('#ostPosAdsPicType').val();
        if(nPosAdsMedia == '1'){
            $('#odvModalPosAdsImage').show();
        }else{}
    }

</script>
