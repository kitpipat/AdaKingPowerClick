<style>
    .xCNIconClose {
        cursor: pointer;
        width: 20px;
    }
</style>

<div class="modal fade" id="odvModalFavName">
 	<div class="modal-dialog modal-sm">
  		<div class="modal-content" style="width:400px;">
        	<div class="modal-header xCNModalHead">
    		<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalEditFav')?></label>
            <button type="button" class="close" data-dismiss="modal" aria-label="close">
                <!-- <img class="xCNIconClose" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/Close.png'?>" > -->
            </button>
   		</div>
        <div class="modal-body">
            <form id="ofmAddFovriteForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <!-- Get data Menuname -->
                <?php
                    if(isset($aDataMenuFavorite[0]['FTMfvName']) && !empty($aDataMenuFavorite[0]['FTMfvName'])){
                        $tMenuShowName  = $aDataMenuFavorite[0]['FTMfvName'];
                    }else{
                        $tMenuShowName  = $aDataMenuFavorite[0]['FTMnuName'];
                    }
                ?>
                <input type='text' id="oetGetDataMnuName" name="oetGetDataMnuName" value="<?php echo @$tMenuShowName;?>">
                <!-- GetDataMenuCode -->
                <input type='hidden' id="oetGetDataMenuCode" name="oetGetDataMenuCode" value="<?php echo @$aDataMenuFavorite[0]['FTMnuCode'];?>">
                <!-- GetDataMnuCtlName -->
                <input type="hidden" id="oetGetDataMnuCtlName" name="oetGetDataMnuCtlName" value="<?php echo @$aDataMenuFavorite[0]['FTMnuCtlName'];?>">
                <!-- GetDataMnuImgPath -->
                <input type="hidden" id="oetGetDataMnuImgPath" name="oetGetDataMnuImgPath" value="<?php echo @$aDataMenuFavorite[0]['FTMnuImgPath'];?>">
            </form>
   		</div>
   		<div class="modal-footer">
            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn"  id="osmDataFav" name="osmDataFav" onclick="JSoGetDataFavarite('confirm')"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
    		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal" onclick="JSoGetDataFavarite('cancel');"><?php echo language('common/main/main', 'tModalDel')?></button>
   		</div>
  	</div>
</div>