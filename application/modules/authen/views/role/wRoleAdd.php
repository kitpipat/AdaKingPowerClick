<?php
    if(isset($nStaCallView) && $nStaCallView == 1){
        @$tBchCode           =  "";
        @$tBchName           =  "";
        
        // ถ้าเป็นระดับต่ำกว่า AD ให้ Default สาขา มาให้เลย
        if( $this->session->userdata("tSesUsrLoginLevel") != "HQ" && $this->session->userdata("tSesUsrLoginLevel") != "AGN" ){
            @$tBchCode           =  $this->session->userdata("tSesUsrBchCodeDefault");
            @$tBchName           =  $this->session->userdata("tSesUsrBchNameDefault");
        }

        @$tAgnCode           =  $tSesAgnCode;
        @$tAgnName           =  $tSesAgnName;
        $tRoute = "roleEventAdd";
    }else{
        //นับจำนวน ถ้า Count จากตาราง TCNMUsrRoleSpc 
        // ** ถ้า FTAgnCode มากกว่า 1 จะไม่โชว์ แต่ถ้า นับ FTAgnCode มีแค่ 1 ให้โชว
        $tCntRoleCode =   $aDataCountRoleCode['raItems']['counts'];

        // if($tCntRoleCode > 1){
        //     @$tBchCode  = "";    
        //     @$tBchName  = ""; 
        // }else{
        @$tBchCode      = $aDataUsrRoleSpc['raItems']['FTBchCode'];
        @$tBchName      = $aDataUsrRoleSpc['raItems']['FTBchName'];
        // }
   
        @$tAgnCode      = $aDataUsrRoleSpc['raItems']['FTAgnCode'];
        @$tAgnName      = $aDataUsrRoleSpc['raItems']['FTAgnName'];
        @$tRoleUsrSpc   = $aDataUsrRoleSpc['raItems']['FTRolCode'];   // Role มาจากตาราง TCNMUsrRoleSpc
        @$tUsrActRole   = $aDataUsrRoleSpc['raItems']['rtUsrActRole']; // Role มาจากตาราง TCNMUsrActRole
        
        if( @$tRoleUsrSpc == @$tUsrActRole ){
            $tDisabled    = 'disabled';  // Browse ตัวแทนขาย กับ ฺBrowse สาขา ปิด ก็ต่อเมื่อ สิทธิการใช้งานไปผูกกับผู้ใช้
        }else{
            $tDisabled    = '';
        }

        $tRoute = "roleEventEdit";
    }

    // Check Data Role Main Master
    if(isset($aDataUsrRole) && !empty($aDataUsrRole)){
        $tRoleCode   = $aDataUsrRole['FTRolCode'];
        $tRoleLevel  = $aDataUsrRole['FNRolLevel'];
        $tRoleName   = $aDataUsrRole['FTRolName'];
        $tRoleRmk    = $aDataUsrRole['FTRolRmk'];
        $tImgObjAll  = $aDataUsrRole['rtRoleImgObj'];
    }else{
        $tRoleCode    = "";
        $tRoleLevel   = $this->session->userdata('nSesUsrRoleLevel');
        $tRoleName    = "";
        $tRoleRmk     = "";
        $tImgObjAll   = "";
    }


    $tUserMonitorlogin =  $this->session->userdata('tSesUsrRoleCodeMulti');
    $tRoleCodeSession   = str_replace("'","",$tUserMonitorlogin);
    $aRoleCodeSession   = explode(",",$tRoleCodeSession);
    $nLoopCheckRole = 0;
    if($this->session->userdata('tSesUsrLevel')!='HQ'){
        if(!empty($aRoleCodeSession)){
            foreach($aRoleCodeSession as $tRoleCodeValue){
                if($tRoleCode == $tRoleCodeValue){
                    $nLoopCheckRole++;
                }
            }
        }
    }


?>
<style>
    #otbModuleMenuRole thead tr:first-child {
        background-color: #1D2530 !important;
    }
    #otbModuleMenuRole thead tr:first-child th {
        border :1px solid #dee2e6 !important;
    }

    .xWwhite{
        color : #FFFFFF !important;
    }

    .xCNDisbledChkBox{
        cursor: not-allowed !important;
    }

    .xCNDisbledChkBox > span{
        cursor: not-allowed !important;
    }

    .xCNDisbledChkBox > span::before{
        background-color: #000000 !important;
        opacity: 0.1 !important;
    }

    .xCNBTNImportRole{
        width : 100%;
        margin-left: 0px;
    }

    .xCNBTNExportRole{
        width : 100%;
        margin-left: 0px;
    }

</style>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddEditRole">
    <button class="xCNHide" id="obtRoleAddEditEvent" type="submit" onclick="JSxAddEditRole('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdRoleRouteData" name="ohdRoleRouteData" value="<?php echo $tRoute;?>">
    <input type="hidden" name="ophdnLoopCheckRole" id="ophdnLoopCheckRole" value="<?=$nLoopCheckRole?>" >
    <input type="hidden" name="ohdSesUsrLoginLevel" id="ohdSesUsrLoginLevel" value="<?=$this->session->userdata("tSesUsrLoginLevel");?>" >

    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <!-- ******************************************************** -->
            	    <?php echo FCNtHGetContentUploadImage(@$tImgObjAll,'Role');?>
                <!-- ******************************************************** -->
                <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('authen/role/role', 'tROLTBCode'); ?></label>
                <?php if(isset($tRoleCode) && empty($tRoleCode)):?>
                    <div id="odvRolAutoGenCodeFrmGrp" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox xWAutoGenCode ">
                            <input type="checkbox" id="ocbRoleAutoGenCode" name="ocbRoleAutoGenCode" checked="true" value="1">
                            <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                        </div>
                    </div>
                <?php endif;?>
                <div id="odvRoleCodeFrmGrp" class="form-group">
                    <input type="hidden" id="ohdCheckDuplicateRoleCode" name="ohdCheckDuplicateRoleCode" value="1"> 
                    <div class="validate-input">
                        <input
                            type="text"
                            class="form-control xCNGenarateCodeTextInputValidate" 
                            maxlength="5"
                            id="oetRolCode" 
                            name="oetRolCode"
                            value="<?php echo @$tRoleCode;?>"
                            data-is-created=""
                            placeholder="<?php echo language('authen/role/role','tROLTBCode');?>"
                            data-validate-required= "<?php echo language('authen/role/role', 'tRoleValiCode');?>"
                            data-validate-dublicateCode="<?php echo language('authen/role/role','tRoleValidCodeDup');?>"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('authen/role/role','tROLTBName');?></label>
                    <input 
                        type="text"
                        class="form-control"
                        maxlength="200"
                        id="oetRolName"
                        name="oetRolName"
                        value="<?php echo @$tRoleName;?>"
                        placeholder="<?php echo language('authen/role/role','tROLTBName');?>" autocomplete="off"
                        data-validate-required="<?php echo language('authen/role/role','tRoleValiName')?>"
                    >
                    <p></p>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBLevel');?></label>
                    <select id="ocmRolLevel" class="selectpicker form-control" name="ocmRolLevel" value="<?php echo @$tRoleLevel;?>">
                        <?php
                             for($i=0;$i<=99;$i++){
                                    if($i>$this->session->userdata('nSesUsrRoleLevel')){
                                        continue;
                                    }
                        ?>
                        <option value="<?=$i?>" <?php echo (!empty($tRoleLevel) && $tRoleLevel == $i)? 'selected' : '';?>><?=$i?></option>
                         <?php } ?>
            
                    </select>
                </div>
                
                <!-- เพิ่ม กำหนดพิเศษ ฺBrowse Agncy, Branch -->
                <?php 
                    $tSpcBchCode       = "";
                    $tSpcBchName       = "";
                    $tSpcAgnCode       = "";
                    $tSpcAgnName       = ""; 

                    if($tRoute == "roleEventAdd"){
                       $tSpcBchCode           = $tBchCode;
                       $tSpcBchName           = $tBchName;
                       $tSpcAgnCode           = $tAgnCode; 
                       $tSpcAgnName           = $tAgnName;
                       
                    }else{
                        $tSpcBchCode          = $tBchCode;
                        $tSpcBchName          = $tBchName;
                        $tSpcAgnCode          = $tAgnCode;
                        $tSpcAgnName          = $tAgnName;

                    }
                ?>

               
                <div class="form-group <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role','tRolegency')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSpcAgncyCode" name="oetSpcAgncyCode" maxlength="5" value="<?=@$tSpcAgnCode;?>">
                    <input type="hidden" id="oetSpcAgncyCodeOld" name="oetSpcAgncyCodeOld" value="<?=@$tSpcAgnCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetSpcAgncyName" name="oetSpcAgncyName" maxlength ="100" 
                        placeholder ="<?php echo language('authen/role/role','tRolegency');?>" value="<?=@$tSpcAgnName;?>"
                        data-validate-required = "<?php echo language('authen/role/role','tValiSpcAgency')?>" 
                        readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowseSpcAgncy" type="button" class="btn xCNBtnBrowseAddOn" <?=@$tDisabled?>  
                            <?php
                                if($this->session->userdata("nSesUsrBchCount")!= 0){
                                    echo 'disabled';
                                }
                            ?>
                            >
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role','tRoleBranch')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetSpcBranchCode" name="oetSpcBranchCode" maxlength="5" value="<?=@$tSpcBchCode;?>">
                    <input type="hidden" id="oetSpcBranchCodeOld" name="oetSpcBranchCodeOld" value="<?=@$tSpcBchCode;?>">
                    <input type="text" class="form-control xWPointerEventNone" id="oetSpcBranchName" name="oetSpcBranchName" maxlength ="100" 
                        placeholder ="<?php echo language('authen/role/role','tRoleBranch');?>" value="<?=@$tSpcBchName;?>"
                        data-validate-required = "<?php echo language('authen/role/role','tValiSpcBranch')?>" 
                        readonly>
                        <span class="input-group-btn">
                            <button id="oimBrowseSpcBranch" type="button" class="btn xCNBtnBrowseAddOn" <?=@$tDisabled?>>
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLRemark');?></label>
                    <textarea class="form-control" rows="4" maxlength="100" id="otaRolRemark" name="otaRolRemark"><?php echo @$tRoleRmk;?></textarea>
                </div>

                <!-- Btn นำเข้า /ส่งออก -->
                <div class="form-group">
                    <div class="row" style="margin-top:15px; margin-bottom:15px;">
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <button id="oimBtnImport" type="button" class="btn btn-primary xCNBTNImportRole"  onclick="JSxImportRole()"> <?= language('common/main/main', 'tImport') ?></button>   
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
                            <button id="oimBtnDisable" type="button" class="btn btn-primary xCNBTNExportRole" onclick="JSxExportRole()"> <?= language('common/main/main', 'tExport') ?></button>
                            <a id="ohdDowloadFile" href="<?=base_url();?>application\modules\authen\views\role\wExportFile.php?ptFile="></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div id="odvRoleMenuList" class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('authen/role/role','tROLSystemMenu');?></label>
                        </div>
                        <div class="table-responsive">
                            <table id="otbModuleMenuRole" class="table xWTableHead">
                                <thead>
                                    <tr>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTModule'); ?></label></th>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTGroup'); ?></label></th>
                                        <th nowrap style="width:3%;text-align:center;" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLTMenu'); ?></label></th>
                                        <th nowrap style="width:15%;text-align:center;" colspan="7" class="xWTableth"><label class="xCNLabelFrm xWwhite"><?php echo language('authen/role/role', 'tROLGroupMenu'); ?></label></th>
                                    </tr>
                                    <tr style="background: #FFF !important;">
                                        <th colspan="3">
                                            <input 
                                            type="text" 
                                            class="form-control xCNInputWithoutSingleQuote" 
                                            id="oetSearchAll" 
                                            name="oetSearchAll" 
                                            autocomplete="off" 
                                            onkeypress="if (event.keyCode == 13) {return false;}"
                                            placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                                        </th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTRead'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTAdd'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBDelete'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLTBEdit'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuApprove'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuCancel'); ?></label></th>
                                        <th nowrap style="width:2%;text-align:center;"><label class="xCNLabelFrm"><?php echo language('authen/role/role', 'tROLMenuReprint'); ?></label></th>
                                    </tr>
                                </thead>
                                <tbody id="otbDataBody">
                                    <?php if($aDataMenuList['rtCode'] != '1' && $aDataMenuReport['raItems'] != 1){?>
                                        <tr><td class='text-center xCNTextDetail2' colspan='9'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>       
                                    <?php }else{ ?>
                                        <?php $aModuleCode = "";?>
                                        <?php foreach($aDataMenuList['raItems'] AS $key => $aValue):?>
                                            <?php if($aModuleCode != $aValue['FTGmnModCode']):?>
                                                <tr class="xWRoleHeardGmnMod">
                                                    <td nowrap colspan="3" class="xCNMenuGrpModule" data-gmc="<?php echo $aValue['FTGmnModCode'];?>">
                                                        <i class="fa fa-plus xCNPlus" data-gmc="<?php echo $aValue['FTGmnModCode'];?>" ></i>
                                                        <label class="xCNLabelFrm">&nbsp;
                                                            <?php echo $aValue['FTGmnModName'];?>
                                                        </label>
                                                    </td>
                                                    <td nowrap class="xWHeardRoleAll"  data-gmc="<?php echo $aValue['FTGmnModCode'];?>" colspan="7">               
                                                        <label class="fancy-checkbox xWCheckAll">
                                                            <input class="xWOcbCheckAll" type="checkbox">
                                                            <span><?php echo language('common/main/main','tCMNChooseAll');?></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                            <?php endif;?>
                                            <tr class="hidden xCNDataRole" data-gmc="<?php echo $aValue['FTGmnModCode'];?>" data-gmn="<?php echo $aValue['FTGmnCode'];?>" data-mnc="<?php echo $aValue['FTMnuCode'];?>">
                                                <td nowrap></td>
                                                <td nowrap><label class="xCNLabelFrm"><?php echo $aValue['FTGmnName']; ?></label></td>
                                                <td nowrap><?php echo $aValue['FTMnuName']; ?></td>
                                        
                                                <?php if($aValue['FTAutStaRead'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleRead"   onclick="return false;"><span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleRead" > <span> </span></label></td>                                                                                
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaAdd'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAdd"   onclick="return false;"><span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAdd" > <span> </span></label></td>                                                                                
                                                <?php } ?>
                                                
                                                <?php if($aValue['FTAutStaDelete'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleDel"  onclick="return false;"> <span> </span></label></td>                                                                                
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleDel" > <span> </span></label></td>     
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaEdit'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleEdit"  onclick="return false;"> <span> </span></label></td>                                        
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleEdit"> <span> </span></label></td>                                        
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaAppv'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAppv"  onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleAppv" > <span> </span></label></td>
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaCancel'] == '0'){ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleCancel"  onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRoleCancel"> <span> </span></label></td>                                        
                                                <?php } ?>

                                                <?php if($aValue['FTAutStaPrintMore'] == '0'){ ?> 
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNDisbledChkBox"><input type="checkbox" class="xCNInputRole xWDataRolePrintMore"   onclick="return false;"> <span> </span></label></td>
                                                <?php }else{ ?>
                                                    <td nowrap class="text-center"><label class="fancy-checkbox xCNIsUseChkBox"><input type="checkbox" class="xCNInputRole xWDataRolePrintMore" > <span> </span></label></td>   
                                                <?php } ?>

                                            <tr>
                                            <?php $aModuleCode = $aValue['FTGmnModCode']; ?>
                                        <?php endforeach;?>

                                        <?php $aModuleRtpCode = "";?>
                                        <?php 
                                            if(!empty($aDataMenuReport['raItems'])){
                                        foreach($aDataMenuReport['raItems'] AS $key => $aValue): ?>
                                            <?php if($aModuleRtpCode != $aValue['FTGrpRptModCode']):?>
                                                <tr class="xWRoleHeardRptModCode">
                                                    <td nowrap colspan="3" class="xCNMenuRptModule"  data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>">
                                                        <i class="fa fa-plus xCNPlus" data-rmc="
                                                            <?php echo $aValue['FTGrpRptModCode'];?>">
                                                        </i>
                                                        <label class="xCNLabelFrm">&nbsp;
                                                            <?php echo language('common/main/main', 'tMNUHeadReport'); ?> / <?=$aValue['FNGrpRptModName'];?>
                                                        </label>
                                                    </td>
                                                    <td nowrap class="xWHeardReportAll"  data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>" colspan="7">
                                                        <label class="fancy-checkbox xWCheckAll">
                                                        <input class="xWAllow" type="checkbox">
                                                            <span><?php echo language('common/main/main', 'tCMNAllowall'); ?></span>
                                                        </label>
                                                    </td>
                                                <?php $aModuleRtpCode = $aValue['FTGrpRptModCode']; ?>
                                            <?php endif;?>
                                            <tr class="hidden xCNDataReport" data-rmc="<?php echo $aValue['FTGrpRptModCode'];?>" data-grc="<?php echo $aValue['FTGrpRptCode'];?>" data-rtc="<?php echo $aValue['FTRptCode'];?>">
                                                <td nowrap></td>
                                                <td nowrap><label class="xCNLabelFrm"><?php echo $aValue['FTGrpRptName']; ?></label></td>
                                                <td nowrap><?php echo $aValue['FTRptName']; ?></td>
                                                <?php if(isset($aValue['FTUfrStaAlw']) && !empty($aValue['FTUfrStaAlw'])){
                                                    $tStaAlw = $aValue['FTUfrStaAlw'];
                                                }else{
                                                    $tStaAlw = "";
                                                } ?>
                                                <?php if($tStaAlw != '1'){ ?>
                                                    <td nowrap colspan="6"><label class="fancy-checkbox"><input type="checkbox"   class="xCNInputReport xWDataReportAllow"> <span><?= language('common/main/main', 'tCMNAllow'); ?></span></label></td>
                                                <?php }else{ ?>    
                                                    <td nowrap colspan="6"><label class="fancy-checkbox"><input type="checkbox" checked="true" class="xCNInputReport xWDataReportAllow"> <span><?= language('common/main/main', 'tCMNAllow'); ?></span></label></td>
                                                <?php } ?>   
                                            </tr>
                                        <?php endforeach;
                                        }  ?>
                                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                <?php include('func_setting/wFuncSetting.php'); ?>
                <?php include('noti_setting/wNotiSetting.php'); ?>
            </div>
        </div>
    </div>
</form>

<!--Modal นำเข้า (Import) Role-->
<div class="modal fade" id="odvModalRoleImport" data-toggle="modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document" style="width: 900px; margin: 1.75rem auto;top:5%;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">นำเข้าข้อมูล</label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div id="odvContentRoleFileImport">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetFileNameRoleImport" name="oetFileNameRoleImport" placeholder="เลือกไฟล์" readonly="">
                            <input type="file" class="form-control" style="visibility: hidden; position: absolute;" id="oefFileRoleImport" name="oefFileRoleImport" onchange="JSxCheckFileRoleImport(this, event)" 
                            accept=".json">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefFileRoleImport').click()">
                                    เลือกไฟล์  
                                </button>
                                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNConfrimFileRoleImport" style="border-radius: 0px !important; margin-left: 30px; width: 100px;" onclick="JSxConfrimFileRoleImport()"><?php echo language('common/main/main', 'ตกลง') ?></button>  
                            </span>
                        </div>
                    </div>
                </div>
                <div id="odvContentRoleRenderHTMLImport"></div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <span id="ospTextSummaryImport" style="text-align: left; display: block; font-weight: bold;"></span>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPRoleUpdateAgain" style="display:none;"><?= language('common/main/main', 'เลือกไฟล์ใหม่') ?></button>
                        <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" id="obtIMPRoleConfirm" onclick="JSxImportDiagramToDatabase();" data-dismiss="modal" style="display:none;"><?= language('common/main/main', 'ยืนยันการนำเข้า') ?></button>
                        <button class="btn xCNBTNDefult xCNBTNDefult2Btn" id="obtIMPRoleCancel" data-dismiss="modal"><?= language('common/main/main', 'ยกเลิก') ?></button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalCallConfirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('settingconfig/settingconperiod/settingconperiod', 'tModalConfirmEdit')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onclick="JSxConfirmRole();" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include 'script/jRoleAdd.php';?>
<script type="text/javascript">



    //กดเลือก Menu                                           
    $('.xCNInputRole').unbind().click(function(){
        var tGMCCode        = $(this).parent().parent().parent().attr('data-gmc');
        var nCheckboxAll    = $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGMCCode+']').find('.xCNIsUseChkBox').length;
        var nValueCheck     =  $('#otbModuleMenuRole tbody .xCNDataRole[data-gmc='+tGMCCode+'] input:checked').length;  

        if(nCheckboxAll == nValueCheck){
            $('.xWHeardRoleAll[data-gmc='+tGMCCode+']').find('.xWCheckAll').find('.xWOcbCheckAll').prop('checked',true);
        }else{
            $('.xWHeardRoleAll[data-gmc='+tGMCCode+']').find('.xWCheckAll').find('.xWOcbCheckAll').prop('checked',false);
        }
    });

    //กดเลือก Report
    $('.xCNInputReport').unbind().click(function(){
        var tRMCCode        = $(this).parent().parent().parent().attr('data-rmc');
        var nCheckboxAll    = $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+tRMCCode+']').find('.xWDataReportAllow').length
        var nValueCheck     = $('#otbModuleMenuRole tbody .xCNDataReport[data-rmc='+tRMCCode+'] input:checked').length; 

        if(nCheckboxAll == nValueCheck){
            $('.xWHeardReportAll[data-rmc='+tRMCCode+']').find('.xWCheckAll').find('.xWAllow').prop('checked',true);
        }else{
            $('.xWHeardReportAll[data-rmc='+tRMCCode+']').find('.xWCheckAll').find('.xWAllow').prop('checked',false);
        }
    });

    if($('#ophdnLoopCheckRole').val()!=0){
        $('.odvRoleBtnGrpSave').hide();
    }else{
        $('.odvRoleBtnGrpSave').show();
    }
    tRoute  =  $('#ohdRoleRouteData').val();

    // ถ้าเข้ามา ขา Add ไม่สามารถ ส่งออกได้
    if(tRoute == 'roleEventAdd'){
        $('#oimBtnDisable').attr("disabled",true);
    }else{
        $('#oimBtnDisable').attr("disabled",false);
    }      

    // ถ้าเข้ามา ขา Edit ไม่สามารถ Import 
    if(tRoute == 'roleEventEdit'){
        $('#oimBtnImport').attr("disabled",true);
    }

    //Import Role (นำเข้า)
    function JSxImportRole(){
        var tValidateRoleName = document.forms["ofmAddEditRole"]["oetRolName"].value;
        if (tValidateRoleName == "") {
                alert("กรุณากรอกชื่อสิทธิ์การใช้งานก่อนอัพโหลดไฟล์");
                $("#oetRolName").focus();
            return false;
        }
        // ถ้าเป็นระดับต่ำกว่า AD ต้องเลือก สาขา
        var tSesUsrLoginLevel = '<?=$this->session->userdata("tSesUsrLoginLevel")?>';
        if( tSesUsrLoginLevel != "HQ" && tSesUsrLoginLevel != "AGN" ){
            if( $('#oetSpcBranchName').val() == "" ){
                alert("กรุณาเลือกสาขา ก่อนอัพโหลดไฟล์");
                return false;
            }
        }
        $('#odvModalRoleImport').modal('show');
        //ล้างค่าใหม่ทุกครั้งที่กดนำเข้า
        $('#oefFileRoleImport').val('');
        $('#oetFileNameRoleImport').val('');
        $('#odvContentRoleRenderHTMLImport').html('');
        $('#obtIMPRoleConfirm').hide();
    }

    //Import File
    function JSxCheckFileRoleImport(poElement, poEvent){
        try{
            var oFile = $(poElement)[0].files[0];
            if(oFile == undefined){
                $("#oetFileNameRoleImport").val("");
            }else{
                $("#oetFileNameRoleImport").val(oFile.name);
            }
        } catch (err) {
            console.log("JSxCheckFileRoleImport Error: ", err);
        }
    }

    //Confirm File
    function JSxConfrimFileRoleImport(){
        var oFile = $('#oefFileRoleImport')[0].files[0];
        var reader      = new FileReader();
        reader.onload   = onReaderLoad;
        reader.readAsText(oFile);
    }

    //function Insert Data
    function onReaderLoad(event){
        if(event.target.result == '' || event.target.result == null){
            $('#odvContentRoleRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
            return;
        }
        var paData = JSON.parse(event.target.result);
        var tRoleAutoGenCode    = $('#ocbRoleAutoGenCode').is(':checked')? 1 : 0;
        if(paData[0]['tTable'] != "TCNTUsrMenu" || paData[1]['tTable'] != "TCNTUsrFuncRpt" || paData[2]['tTable'] != "TPSMFuncHD" || paData[3]['tTable'] != "TCNMUsrRoleSpc"){
            $('#odvContentRoleRenderHTMLImport').html('<span style="color:red"> รูปแบบไฟล์ไม่ถูกต้อง </span>');
        }else{
            //ปุ่มตกลงกด disabled 
            $('.xCNConfrimFileRoleImport').attr('disabled',true);
            $.ajax({
                type : "POST",
                url : "roleInsertData",
                catch : false,
                data : {
                    aData : paData,
                    tRoleAutoGenCode : tRoleAutoGenCode,
                    tRoleCode : $('#oetRolCode').val(),
                    tRolName : $('#oetRolName').val(),
                    tRolRev : $('#ocmRolLevel').val(),
                    tRemark :  $('#otaRolRemark').val(),
                    tRoleSpcAgnCode : $('#oetSpcAgncyCode').val(),
                    tRoleSpcBchCode : $('#oetSpcBranchCode').val()
                },
                timeout : 0,
                success : function(tResult){
                    $('#odvModalRoleImport').modal('hide');
                    $('#ospConfirmDelete').html('บันทึกข้อมูลกลุ่มสิทธิ์เรียบร้อยแล้ว');
                    $('#odvModalCallConfirm').modal('show');
                    $('.xCNConfrimFileRoleImport').attr('disabled',false);
                },
            });
        }
    }

    // หลัง กดตกลง ให้วิ่งไปยังหน้า list(รายการ)
    // create by Witsarut 3-12-2020
    function JSxConfirmRole(){
        JSvCallPageRoleList();
        $('.modal-backdrop').remove();
        JCNxCloseLoading();
    }

    // Export Role (ส่งออก)
    function JSxExportRole(){
        $.ajax({
            type : "POST",
            url  : "roleExportData",
            catch: false,
            data : {
                tRoleCode : $('#oetRolCode').val(),
                tRolName : $('#oetRolName').val(),
                tRoleLev  : $('#ocmRolLevel').val(),
                tAgnCode  : $('#oetSpcAgncyCode').val(),
                tSpcBchCode :  $('#oetSpcBranchCode').val()
            },
            timeout : 0,
            success : function(tResult){
                var aResult     = JSON.parse(tResult);
                var tStatus     = aResult.tStatusReturn;

                if(tStatus == '800' || tStatus == 800){
                    alert('ไม่พบข้อมูล');
                }else{
                    var tFileName   = aResult.tFilename;
                    $('#ohdDowloadFile').attr("href","<?=base_url();?>"+"application/modules/authen/views/role/wExportFile.php?ptFile="+tFileName+"");
                    $('#ohdDowloadFile')[0].click(); 
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

</script>