
<?php if ($aDataList['rtCode'] == 1) { ?>
    <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
        <?php // echo $aValue['FTPmdGrpName']; ?>
        <?php // echo $aValue['FTPmdStaType']; ?>
        <?php // echo $aValue['FTPmdStaListType']; ?>

        <?php if($tGroupType == "1") { ?>
            <div
            data-grpname="<?php echo $aValue['FTPmdGrpName']; ?>" 
            class="xCNPromotionStep2GroupNameType1Item alert alert-success" 
            role="alert" 
            style="min-width: 60%; width: fit-content; z-index: 100;">
                <?php echo $aValue['FTPmdGrpName']; ?> 
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
        <?php } ?>

        <?php if($tGroupType == "2") { ?>
            <div 
            data-grpname="<?php echo $aValue['FTPmdGrpName']; ?>"
            class="xCNPromotionStep2GroupNameType2Item alert alert-warning" 
            role="alert" 
            style="min-width: 60%; width: fit-content; z-index: 100;">
                <?php echo $aValue['FTPmdGrpName']; ?> 
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <label><?= language('common/main/main', 'tCMNNotFoundData') ?></label>
<?php }; ?>

<?php if(false) { ?>
    <div class="row xCNPromotionPmtPdtDtPage" style="margin-top: 20px;">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    if(!bIsApvOrCancel) {
        var oPromotionStep2GroupNameType1 = $(".xCNPromotionStep2GroupNameType1");
        var oPromotionStep2GroupNameType2 = $(".xCNPromotionStep2GroupNameType2");
        var oPromotionStep2GroupBuy = $(".xCNPromotionStep2GroupBuy");
        var oPromotionStep2GroupGet = $(".xCNPromotionStep2GroupGet");

        $(document).ready(function(){

            // Let the items be draggable
            $( "div.xCNPromotionStep2GroupNameType1Item", oPromotionStep2GroupNameType1 ).draggable({
                // cancel: "button.ui-icon-b", // clicking an icon won't initiate dragging
                revert: "invalid", // when not dropped, the item will revert back to its initial position
                containment: "document",
                helper: "clone",
                cursor: "move"
            });

            // Let the items be draggable
            /* $( "div.xCNPromotionStep2GroupNameType2Item", oPromotionStep2GroupNameType2 ).draggable({
                // cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                revert: "invalid", // when not dropped, the item will revert back to its initial position
                containment: "document",
                helper: "clone",
                cursor: "move"
            }); */

            // Let the trash be droppable, accepting the gallery items
            oPromotionStep2GroupBuy.droppable({
                // accept: ".xCNPromotionStep2GroupNameType1 > div.xCNPromotionStep2GroupNameType1Item",
                classes: {
                    "ui-droppable-active": "xCNPromotionStep2ActiveBackground"
                },
                drop: function(event, ui) {
                    if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อเป็นช่่วงบังคับให้มี กลุ่ม Get
                        JSxPromotionStep2GroupNameType1ToGroupBuy(ui.draggable.clone());
                        JSxPromotionStep2GroupNameType1ToGroupGet(ui.draggable.clone());
                    }
                    if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep2GroupNameType1ToGroupBuy(ui.draggable.clone());
                    }
                }
            });
        
            // Let the trash be droppable, accepting the gallery items
            oPromotionStep2GroupGet.droppable({
                // accept: ".xCNPromotionStep2GroupNameType1 > div.xCNPromotionStep2GroupNameType1Item",
                classes: {
                    "ui-droppable-active": "xCNPromotionStep2ActiveBackground"
                },
                drop: function(event, ui) {
                    if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อเป็นช่่วงบังคับให้มี กลุ่ม Get
                        JSxPromotionStep2GroupNameType1ToGroupBuy(ui.draggable.clone());
                        JSxPromotionStep2GroupNameType1ToGroupGet(ui.draggable.clone());
                    }
                    if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                        JSxPromotionStep2GroupNameType1ToGroupGet(ui.draggable.clone());
                    }
                }
            });

            /* // Let the gallery be droppable as well, accepting items from the trash
            oPromotionStep2GroupNameType1.droppable({
                accept: ".xCNPromotionStep2GroupNameType1 div.xCNPromotionStep2GroupNameType1Item",
                classes: {
                    "ui-droppable-active": "custom-state-active"
                },
                drop: function( event, ui ) {
                    recycleImage( ui.draggable );
                }
            });

            // Let the gallery be droppable as well, accepting items from the trash
            oPromotionStep2GroupNameType2.droppable({
                accept: ".xCNPromotionStep2GroupNameType2 div.xCNPromotionStep2GroupNameType2Item",
                classes: {
                    "ui-droppable-active": "custom-state-active"
                },
                drop: function( event, ui ) {
                    recycleImage( ui.draggable );
                }
            }); */
        });

        function JSxPromotionStep2GroupNameType1ToGroupBuy(item) {
            // console.log('JSxPromotionStep2GroupNameType1ToGroupBuy: ', item);
            var tGroupName =  item.data('grpname');
            if(!JSbPromotionStep2IsDupInBuy(tGroupName)){
                $('.xCNPromotionStep2GroupBuy').append(item);

                if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                    JSvPromotionStep3InsertPmtCBAndPmtCGToTemp(tGroupName, false);
                }
                if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                    JSvPromotionStep3InsertPmtCBToTemp(tGroupName);
                }

            }

            if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCBInTemp(tGroupName);
                    JSvPromotionStep3DeletePmtCGInTemp(tGroupName);
                    $(".xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                    $(".xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();  
                });
            }
            if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCBInTemp(tGroupName);
                    $(this).parents(".xCNPromotionStep2GroupNameType1Item").remove();
                });
            }

            /* if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCBInTemp(tGroupName);
                    $(".xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                    $(".xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();  
                });
            }
            if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCBInTemp(tGroupName);
                    $(this).parents(".xCNPromotionStep2GroupNameType1Item").remove();
                });
            } */
        }

        function JSxPromotionStep2GroupNameType1ToGroupGet(item) {
            // console.log('JSxPromotionStep2GroupNameType1ToGroupGet: ', item);
            var tGroupName =  item.data('grpname');
            if(!JSbPromotionStep2IsDupInGet(tGroupName)){
                $('.xCNPromotionStep2GroupGet').append(item);

                if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                    JSvPromotionStep3InsertPmtCGToTemp(tGroupName);
                }

            }

            if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCBInTemp(tGroupName);
                    JSvPromotionStep3DeletePmtCGInTemp(tGroupName);
                    $(".xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                    $(".xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                });
            }
            if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCGInTemp(tGroupName);
                    $(this).parents(".xCNPromotionStep2GroupNameType1Item").remove();
                });    
            }

            /* if(JSbPromotionConditionBuyIsRange()){ // เงื่อนไขการซื้อแบบช่วง
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCGInTemp(tGroupName);
                    $(".xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                    $(".xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item[data-grpname='" + tGroupName + "']").remove();
                });
            }
            if(JSbPromotionConditionBuyIsNormal()){ // เงื่อนไขการซื้อแบบปกติ
                $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item .close, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item .close').unbind().bind('click', function(){
                    var tGroupName = $(this).parents(".xCNPromotionStep2GroupNameType1Item").data('grpname');
                    JSvPromotionStep3DeletePmtCGInTemp(tGroupName);
                    $(this).parents(".xCNPromotionStep2GroupNameType1Item").remove();
                });    
            } */
        }

        /* function recycleImage( item ) {
            // console.log('oPromotionStep2GroupNameType1: ', item);
        } */

        function JSbPromotionStep2IsDupInBuy(ptGrpName){
            var bStatus = false;
            var oPromotionStep2GroupNameInBuy = $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item, .xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType2Item');
            $.each(oPromotionStep2GroupNameInBuy, function(nIndex, oItem){
                let tGrpNameInBuy = $(oItem).data('grpname');
                if(tGrpNameInBuy == ptGrpName){
                    bStatus = true;
                }    
            });
            return bStatus;
        }

        function JSbPromotionStep2IsDupInGet(ptGrpName){
            var bStatus = false;
            var oPromotionStep2GroupNameInGet = $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item, .xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType2Item');
            $.each(oPromotionStep2GroupNameInGet, function(nIndex, oItem){
                let tGrpNameInGet = $(oItem).data('grpname');
                if(tGrpNameInGet == ptGrpName){
                    bStatus = true;
                }    
            });
            return bStatus;
        }
    }else{
        $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item a').remove();
        $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item a').remove();
    }

    /*===== Begin After Step1 Remove Group Name Control ================================*/
    var oItemInBuy = $('.xCNPromotionStep2GroupBuy .xCNPromotionStep2GroupNameType1Item');
    var oItemInGet = $('.xCNPromotionStep2GroupGet .xCNPromotionStep2GroupNameType1Item');
    var aGroupNameType1 = FSaPromotionStep2GetPmtDtGroupNameItem(); // กลุ่มร่วมรายการ
    
    $.each(oItemInBuy, function(nIndex, oElem){
        let tGroupName = $(this).data('grpname');    
        if(!aGroupNameType1.includes(tGroupName)){
            $(this).find('a.close').click();    
        }
    });

    $.each(oItemInGet, function(nIndex, oElem){
        let tGroupName = $(this).data('grpname');    
        if(!aGroupNameType1.includes(tGroupName)){
            $(this).find('a.close').click();   
        }
    });
    /*===== End After Step1 Remove Group Name Control ==================================*/

    /**
     * Functionality : Get Group Name Item (กลุ่มร่วมรายการ)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Group Name Item
     * Return Type : array
     */
    function FSaPromotionStep2GetPmtDtGroupNameItem(){
        var oItemInType1 = $('.xCNPromotionStep2GroupNameType1 .xCNPromotionStep2GroupNameType1Item');
        var aGroupName = [];
        $.each(oItemInType1, function(nIndex, oElem){
            let tGroupName = $(this).data('grpname');
            aGroupName.push(tGroupName);   
        });   
        return aGroupName; 
    }
</script>