<?php
    // ตรวจสอบโหมดการทำงานว่าเป็น โหมดเพิ่มใหม่ หรือแก้ไข
    if($aDataList['rtCode'] == 1){
         $tRoute         	= "consetgenEventedit";
    }else{
    }
?>

<style>
    div.xCNTableScrollY {
        height: 180px;
        overflow: auto;
    }
</style>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditConnSetGenaral">
<?php if($tStaApiTxnType == '1'): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th nowrap class="xCNTextBold" style="width:3%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral' ,'tGenaralSeq')?></th>
                            <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralGroup')?></th>
                            <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralDetail')?></th>
                            <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralNormalvalue')?></th>
                            <th nowrap class="xCNTextBold" style="width:15%;text-align:center;min-width: 250px;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralCustom')?></th>
                        </tr>            
                    </thead>
                    <tbody>
                        <?php if($aDataList['rtCode'] == 1):?>
                            <?php foreach($aDataList['raItems'] AS $key => $aValue) {
                                

                                if($aValue['FTCfgStaDataType']==7){

                                        $tInputType = 'password';
                                }else{
                                    $tInputType = 'text';
                                }
                                ?>
                                <tr>
                                    <!-- ส่ง param ไป where update -->
                                    <input type="hidden" name="ohdcfgCode[]" value="<?php echo $aValue['FTCfgCode'];?>">
                                    <input type="hidden" maxlength="50" name="ohdcfgApp[]" value="<?php echo $aValue['FTCfgApp'];?>">
                                    <input type="hidden" maxlength="50" name="ohdcfgKey[]" value="<?php echo $aValue['FTCfgKey'];?>">
                                    <input type="hidden" maxlength="3" name="ohdcfgSeq[]" value="<?php echo $aValue['FTCfgSeq'];?>">

                                    <td style="text-align:center"><?php echo ($key+1);?></td>
                                    <td style="text-align:left"><?=$aValue['FTCfgKey'];?></td>
                                    <td style="text-align:left"><?=$aValue['FTCfgName'];?></td>
                                    <td style="text-align:center"><?=$aValue['FTCfgStaDefValue'];?></td>
                                    <td><input type="<?=$tInputType?>" name="oetStaUsrValue[]" data-oldpws="<?php echo $aValue['FTCfgStaUsrValue'];?>"  value="<?php echo $aValue['FTCfgStaUsrValue'];?>"></td>
                                </tr>
                            <?php } ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>    
        </div>
    </div>

    <!-- ขีดเส้นใต้คั่นตาราง -->
    <div><hr></div>
<?php endif; ?>

    <div class="row">
        <div class="col-xs-12 col-md-4 col-lg-4">
            <label><?=language('interface/conSettingGenaral/consettinggenaral','tConSetingtitle')?></label>
			<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAPI" name="oetSearchAPI" placeholder="<?php echo language('authen/department/department','กรอกคำค้นหา')?>" value="<?= $tSearchApi;?>">
					<span class="input-group-btn">
						<button id="oimSearchAPI" class="btn xCNBtnSearch" type="button">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
        <?php if($tStaApiTxnType == '3'): ?>
        <div class="col-xs-12 col-md-8 col-lg-8 text-right">
            <button type="button" onclick="JSxConnsetGenCancel();" id="obtConnSetGenCancel" class="btn xCNBTNDefult xCNBTNDefult2Btn" style="margin-left: 5px;">
                <?php echo language('common/main/main', 'tCancel')?>
            </button>
            <button type="submit" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" style="margin-left: 5px;" id="obtConnSetGenSave" onclick="JSxConnSetGenSaveAddEdit('consetgenEventedit')"> 
                <?php echo  language('common/main/main', 'tSave')?>
            </button>
        </div>
        <?php endif; ?>
	</div>

    <!-- TABLE สำหรับ input ประเภทอื่นๆ -->
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped" style="width:100%;">
                    <thead>
                        <tr>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralGroup')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralSeq')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralType')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralDetail')?></th>
                            <th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralAPIURL')?></th>
                            <th nowrap class="xCNTextBold" style="min-width: 120px;width: 120px;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralApiFormat')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;min-width: 120px;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralName')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;min-width: 120px;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralPassword')?></th>
                            <th nowrap class="xCNTextBold" style="text-align:center;min-width: 120px;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tGenaralSecurity')?></th>
                            <th nowrap class="xCNTextBold" style="width:12%;text-align:center;"><?php echo language('interface/conSettingGenaral/consettinggenaral', 'tAuthorization')?></th>
                        </tr>            
                    </thead>
                    <tbody>
                        <?php if($aReslistApi['rtCode'] == 1):?>
                            <?php foreach($aReslistApi['raItems'] AS $key => $aValue) { ?>
                                <tr>
                                    <!-- ส่ง param ไป where update -->
                                    <input type="hidden" name="ohdApiCode[]" value="<?=$aValue['FTApiCode'];?>">
                                    <input type="hidden" name="oetSeqold[]" value="<?=$aValue['FNApiGrpSeq'];?>">

                                    <!-- ของเก่า 07-08-2020 -->
                                    <!-- <td><input maxlength="5" type="text"  name="oetGrpPrc[]" value="<?//=$aValue['FTApiGrpPrc'];?>"></td> -->
                                    
                                    <!-- ของใหม่ Show เป็น label -->
                                    <td nowrap class="text-left"><?=$aValue['FTApiGrpPrc'];?></td>
                                    <td nowrap class="text-left"><?=$aValue['FNApiGrpSeq'];?></td>
                                   
                                    <!-- ของเก่า ตอนแรก Show เป็น Textbox update ค่าได้ แล้วมาเปลี่ยนเป็น Label Show ไว้ ไม่มีผล -->
                                    <input type="hidden" id="oetSeqGrp<?=$key?>" name="oetSeqGrp[]" value="<?=$aValue['FNApiGrpSeq'];?>">
                                    <?php 
                                        switch ($aValue['FTApiTxnType']) {
                                            case 1:
                                                $tImExport = language('interface/conSettingGenaral/consettinggenaral', 'tGenImport');
                                            break;
                                            case 2:
                                                $tImExport = language('interface/conSettingGenaral/consettinggenaral', 'tGenExport');
                                            break;
                                            case 3:
                                                $tImExport = language('interface/conSettingGenaral/consettinggenaral', 'tAPI');
                                            break;
                                            case 4:
                                                $tImExport = language('interface/conSettingGenaral/consettinggenaral', 'tAPI');
                                            break;
                                            default:
                                                $tImExport = language('interface/conSettingGenaral/consettinggenaral', 'tGenImport');
                                        }
                                    ?>
                                    <td nowrap style="text-align:left"><?php echo $tImExport;?></td>
                                
                                    <td nowrap style="text-align:left"><?php echo $aValue['FTApiName'];?></td>
                                    <td nowrap style="text-align:left"><input type="text" name="oetApiURL[]" value="<?=$aValue['FTApiURL'];?>" style="min-width: 250px;"></td> <!--style="direction: rtl;"-->
                                 
                                    <td nowrap>
                                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetApiFmtCode<?=$aValue['FTApiCode'];?>" name="oetApiFmtCode[]" maxlength="5" value="<?=$aValue['FTApiFmtCode'];?>">
                                            <input  type="text" class="form-control xWPointerEventNone" id="oetApiFmtName<?=$aValue['FTApiCode'];?>" name="oetApiFmtName[]"
                                                maxlength="100" placeholder="<?php echo language('interface/conSettingGenaral/consettinggenaral','tGenaralApiFormat')?>" value="<?=$aValue['FTApiFmtName'];?>"
                                            readonly>
                                            <span class="input-group-btn">
                                                <button  apicode="<?=$aValue['FTApiCode'];?>" type="button" class="btn xCNBtnBrowseAddOn oimBrowseApiFormat">
                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </td>

                                    <td nowrap style="text-align:left"><input type="text" name="oetUsrName[]" value="<?=$aValue['FTApiLoginUsr'];?>"></td>

                                    <td nowrap style="text-align:left"><input type="password" name="oetPassword[]" data-oldpws="<?=$aValue['FTApiLoginPwd'];?>" value="<?=$aValue['FTApiLoginPwd'];?>"></td>

                                    <td nowrap style="text-align:left"><input type="text" name="oetToken[]" value="<?=$aValue['FTApiToken'];?>"> </td>

                                    <td nowrap style="text-align:left">
                                        <a href="#" onClick="JSvCallPageSetEdit('<?php echo $aValue['FNApiGrpSeq']?>','<?php echo $aValue['FTApiCode'];?>')">
                                            <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/setting_new.png'?>" id="oetApiGrpSeq"> 
                                            <?php echo language('interface/conSettingGenaral/consettinggenaral','tGenSetting');?>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php else:?>
                            <tr><td nowrap class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                        <?php endif;?>

                    </tbody>
                </table>
            </div>    
        </div>
    </div>
</form>
<?php include "script/jConnSetGenMain.php";?>
<script>

</script>
