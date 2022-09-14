<style>
    .bootstrap-select>button {
        height: 35px;
        padding-top: 3px !important;
    }
</style>
<input type="hidden" id="oetDOBrowseType" value="<?=$nDOBrowseType?>">
<input type="hidden" id="oetDOBrowseOption" value="<?=$tDOBrowseOption?>">

<div class="odvContentPage" id="odvContentPage">

    <div id="odvDOMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('monDO/0/0');?>
                        <li id="oliDOTitle" class="xCNLinkClick" onclick="JSvDOCallPageList()"><?= language('monitor/monitor/monitor','tDOTitle')?></li>
                        <li id="oliDOTitleAdd" class="active" style="display:none;"><a><?php echo language('common/main/main', 'tAdd'); ?></a></li>
                        <li id="oliDOTitleEdit" class="active" style="display:none;"><a><?php echo language('common/main/main', 'tEdit'); ?></a></li>
                        <li id="oliDOTitleDetail" class="active" style="display:none;"><a><?php echo language('document/productarrangement/productarrangement', 'tDOTitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0" id="odvBtngroup">
                    <div id="odvDOBtnGrpAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button id="obtDOCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" style="display:none;"> <?php echo language('common/main/main', 'tBack'); ?></button>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaPrint'] == 1)): ?>
                                <button id="obtDOPrintDoc" onclick="JSxDOPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" style="display:none;"> <?php echo language('common/main/main', 'tCMNPrint'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaCancel'] == 1)): ?>
                                <button id="obtDOCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" style="display:none;"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAppv'] == 1)): ?>                           
                                <button id="obtDOMultiApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" style="display:none;" onclick="JSvDOApvDocMulti()"> <?php echo language('monitor/monitor/monitor', 'tDOApprove'); ?></button>
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAppv'] == 1)): ?>
                                <button id="obtDOApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" style="display:none;"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button>                                  
                            <?php endif; ?>
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                <div  id="odvDOBtnGrpSave" class="btn-group" style="display:none;">
                                    <button id="obtDOSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
                                    <?php echo $vBtnSave ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div id="odvDOContentPageDocument" class="main-content"></div>
        
</div>
<script src="<?php echo base_url('application/modules/monitor/assets/src/deliveryorder/jDeliveryOrder.js'); ?>"></script>
<script type="text/javascript">
    $('document').ready(function(){
        localStorage.removeItem("oDOAdvSearch");
        localStorage.removeItem("DO_LocalItemDataApv");
        // var nStaBrowseType = $('#oetDOBrowseType').val()

        // if (nStaBrowseType == 0) {
        //     //เคลียค่า
        //     localStorage.removeItem("aValues");
        //     localStorage.tCheckBackStageData = '';
        // }

        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSvDOCallPageList();
    });
</script>
