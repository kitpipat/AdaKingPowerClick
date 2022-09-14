<input id="oetPadDapTable"   type="hidden" value="<?=$FTDapTable?>">
<input id="oetPadDapRefType" type="hidden" value="<?=$FTDapRefType?>">
<input id="ohdSdtDocName"    type="hidden" value="<?=$FTSdtDocName?>">
<input id="ohdDapRoleGrp"    type="hidden" >

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <label class="breadcrumb" style="font-weight: bold; margin-top: 10px; margin-bottom: 10px;">
        <?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableDocument')?><?php echo $FTSdtDocName?>
    </label>
</div>
<div class="panel-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive">
                <table class="table table-striped" style="width:100%">
                    <thead>
                        <tr class="xCNCenter">
                            <th style="width:10%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableDegree')?></th>
                            <th style="width:20%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableDocument')?></th>
                            <th style="width:30%;"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableColor');?></th>
                            <th><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableApprover')?></th>
                        </tr>
                    </thead>
                    <tbody id="odvRGPList">
                    <?php if($aResult['rtCode'] == 1 ):?>
                    <?php foreach($aResult['raItems'] AS $key=>$aValue){ ?>
                        <tr class="odvListData xWUsrRole<?=$aValue['FTDapUsrRoleGrp'];?>" data-code='<?=$aValue['FNDapID'];?>' data-seq="<?=$aValue['FNDapSeq'];?>" data-userrole="<?=$aValue['FTDarUsrRole'];?>" data-table="<?=$aValue['FTDapTable']?>"  data-type="<?=$aValue['FTDapRefType']?>">
                            <td class="text-center"><?php echo $aValue['FNDapSeq']; ?></td>
                            
                            <td class="text-left">   
                                <?php 
                                    $tText = str_replace("\\n","",trim($aValue['FTDapName']));
                                    echo nl2br($tText);
                                ?>
                            </td>

                            <td class="text-left">
                                <div class="input-group colorpicker-component xCNSltColor">
                                    <input class="form-control" type="text" id="oetSltColor<?=$aValue['FNDapSeq'];?>" name="oetSltColor<?=$key?>" value="#<?php echo $aValue['FTDarStaColor'];?>">
                                    <span class="input-group-addon"></span>
                                </div>
                            </td>

                            <td class="text-center">
                                <?php if($aValue['FTDarUsrRole'] != ""):?>
                                    <span class="xCNNotdetermined<?=$aValue['FTDapUsrRoleGrp'];?>"><?php echo $aValue['FTRolName']; ?></span>&nbsp;&nbsp;
                                    <img  class="xCNLinkClick" onclick="FSxPADPermissionApvDocAddUsrRole(<?= $aValue['FTDapUsrRoleGrp']; ?>)" src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>" width="18" height="18">
                                <?php else: ?>
                                    <span class="xCNNotdetermined<?=$aValue['FTDapUsrRoleGrp'];?>"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTableNotdetermined')?></span>&nbsp;&nbsp;
                                    <img  class="xCNLinkClick" onclick="FSxPADPermissionApvDocAddUsrRole(<?= $aValue['FTDapUsrRoleGrp']; ?>)" src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>" width="18" height="18">
                                <?php endif; ?>
                            </td>
                        </tr> 
                    <?php  }  ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='3'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aResult['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aResult['rnCurrentPage']?> / <?=$aResult['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvPADClickPageEdit('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aResult['rnAllPage'],$nPage+2)); $i++){?>
				<?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvPADClickPageEdit('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aResult['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvPADClickPageEdit('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div> 
</div>

<?php include "script/jPermissionApvDocAdd.php"; ?>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/js/bootstrap-colorpicker.min.js')?>"></script>

<script type="text/javascript">
    $(function () {
        $('.xCNSltColor').colorpicker();
        $('.colorpicker-alpha').remove();
    });
</script>
