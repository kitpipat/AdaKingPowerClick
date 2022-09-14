
<style>
.dropbtn {
  cursor: pointer;
}

.dropdownsub {
  position: relative;
  display: inline-block;
}

.dropdownsub-content {
  display: none;
  position: absolute;
  right: 0;
  min-width: 200px;
  z-index: 1;
  background:#ffff;
  border-radius:4px;
  border-color:#cccc
}

.dropdownsub-content h4 {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
.dropdownsub:hover .dropdownsub-content {display: block;}
.xTextOverFolw{
    white-space: nowrap; 
    width: 260px; 
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
<?php
    if(!empty($aDataNotification)){
         foreach($aDataNotification as $nKey => $aData){

            if($nKey>=10){
              break;
            }

            if($aData['FTStaRead']=='1'){
                    $tStaRead = 'background:#fdfdfd';
            }else{
                    $tStaRead = '';
            }
            if($nNotiType==1){
              $tIcons = 'fa fa-commenting';
            }else{
              $tIcons = 'fa fa-newspaper-o';
            }
?>
<?php if($aData['FNNotUrlType']==1){ ?>
<a class="content" href="#" onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>','<?=$nNotiType?>');JCNxNTFJumpDocPageEdit('<?=$aData['FTNotDocRef']?>','<?=$aData['FTNotUrlRef']?>','<?=$aData['FTAgnCode']?>','<?=$aData['FTNotBchRef']?>')">                         
<?php }else if($aData['FNNotUrlType']==2){ ?>
<a class="content" href="#" onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>','<?=$nNotiType?>');JCNxNTFOpenUrl('<?=$aData['FTNotUrlRef']?>')">                         
<?php }else if($aData['FNNotUrlType']==3){ ?>
<a class="content" href="#" onclick="JCNxNFTReadNotID('<?=$aData['FTNotID']?>','<?=$nNotiType?>');JCNxNTFPopUpNew(this)"
  data-desc1="<?=$aData['FTNotDesc1']?>"
  data-desc2="<?=$aData['FTNotDesc2']?>"
  data-date="<?=date('d/m/Y H:i',strtotime($aData['FDNotDate']))?>"
>                         
<?php } ?>
<div class="notification-item" style="<?=$tStaRead?>">

  <div class="row">
      <div class="col-md-2" align="center"   style="padding-top: 5px;"  >
      <h4 class="item-info"><i class="<?=$tIcons?>"  style="font-size: 30px;color:#7795d6"></i></h4>
      </div>
      <div class="col-md-10"  style="margin-left: -12px;">
            <h5 class="item-info"><?=date('d/m/Y H:i',strtotime($aData['FDNotDate']))?></h5>
            <h4 class="item-title"><?=$aData['FTNotDesc1']?></h4>

            <div class="row">
                <div class="col-md-10">
                <h5 class="item-info xTextOverFolw"><?=$aData['FTNotDesc2']?></h5> 
                </div>
                <div class="col-md-2">
                    <?php if(FCNnHSizeOf($aData['oNotiAction'])>1){ ?>
                        <div class="dropdownsub" style="float:right;">
                        <h5 class="item-info"><i class="glyphicon glyphicon-circle-arrow-right text-right "></i></h5> 
                            <div class="dropdownsub-content">
                                    <?php foreach($aData['oNotiAction'] as $aNotiAct){ ?>
                                    <div class="notification-item">
                                        <h5><?=$aNotiAct['FDNoaDateInsert']?></h5>
                                        <h5 class="xTextOverFolw"><?=$aNotiAct['FTNoaDesc']?></h5>
                                    </div>
                                    <?php } ?>
                            </div>
                        </div>
                    <?php  } ?>
                </div>
            </div>
      </div>
  </div>

</div>
</a>
<?php 
         }
}else{ ?>
    <div class="notification-item">
    <h4 class="item-title text-center"><?php echo language('common/main/main','tMainRptNotFoundDataInDB')?></h4>
    </div>
<?php } ?>



<script>
    
</script>