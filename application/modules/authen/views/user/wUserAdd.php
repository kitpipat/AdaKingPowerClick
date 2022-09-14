<?php

    $tUsrLevel = $this->session->userdata("tSesUsrLevel");

    $tSesUsrLoginLevel = $this->session->userdata("tSesUsrLoginLevel");

    if(isset($aResult) && $aResult['rtCode'] == '1'){
        $tUsrCode       = $aResult['raItems']['rtUsrCode'];
        $tUsrTel        = $aResult['raItems']['rtUsrTel'];
        $tUsrEmail      = $aResult['raItems']['rtUsrEmail'];
        $tUsrName       = $aResult['raItems']['rtUsrName'];
        $tUsrRmk        = $aResult['raItems']['rtUsrRmk'];
        $tDptCode       = $aResult['raItems']['rtDptCode'];
        $tDptName       = $aResult['raItems']['rtDptName'];
        $tRoute         = "userEventEdit";
        $dGetDataNow    = "";
        $dGetDataFuture = "";

        // Create By Napat(Jame) 11/05/2020
        $tBchCode   = "";
        $tBchName   = "";
        $tShpCode   = "";
        $tShpName   = "";
        $tMerCode   = "";
        $tMerName   = "";

        if(isset($aResUsrGroup['raItems']) && !empty($aResUsrGroup['raItems'])){
            $tMerCode = $aResUsrGroup['raItems'][0]['FTMerCode'];
            $tMerName = $aResUsrGroup['raItems'][0]['FTMerName'];

            // Create By Napat(Jame) 19/05/2020
            $tUsrAgnCode = $aResUsrGroup['raItems'][0]['FTAgnCode'];
            $tUsrAgnName = $aResUsrGroup['raItems'][0]['FTAgnName'];

            foreach ($aResUsrGroup['raItems'] AS $key => $aValue){
                if($tBchCode == ""){
                    $tSymbol = "";
                }else{
                    $tSymbol = ",";
                }

                if($aValue['FTBchCode'] != ""){
                    if(strpos($tBchCode, $aValue['FTBchCode']) !== 0){ // เช็คค่าซ้ำ
                        $tBchCode .= $tSymbol.$aValue['FTBchCode'];
                        $tBchName .= $tSymbol.$aValue['FTBchName'];
                    }
                }

                if($aValue['FTShpCode'] != ""){
                    $tShpCode .= $tSymbol.$aValue['FTShpCode'];
                    $tShpName .= $tSymbol.$aValue['FTShpName'];
                }
            }
        }

    }else{
        $tUsrImage      = "";
        $tUsrCode       = "";
        $tUsrTel        = "";
        $tUsrEmail      = "";
        $tUsrName       = "";
        $tUsrRmk        = "";
        $tDptCode       = "";
        $tDptName       = "";
        $tRoute         = "userEventAdd";
        // $tPwd           = '';
        // $tPwdNew        = '';
        $dGetDataNow    = $aResult['dGetDataNow'];
        $dGetDataFuture = $aResult['dGetDataFuture'];

        // Add Page
        // Create By Napat(Jame) 12/05/2020
        $tTypeBch = ($this->session->userdata("nSesUsrBchCount") > 1 ? 'Multi' : 'Default');
        $tTypeShp = ($this->session->userdata("nSesUsrShpCount") > 1 ? 'Multi' : 'Default');

        $tMerCode   = $this->session->userdata("tSesUsrMerCode");
        $tMerName   = $this->session->userdata("tSesUsrMerName");
        if( $tUsrLevel != "HQ" && $tSesUsrLoginLevel != "AGN" ){
            $tBchCode   = str_replace("'","",$this->session->userdata("tSesUsrBchCode".$tTypeBch));
            $tBchName   = str_replace("'","",$this->session->userdata("tSesUsrBchName".$tTypeBch));
            $tShpCode   = str_replace("'","",$this->session->userdata("tSesUsrShpCode".$tTypeShp));
            $tShpName   = str_replace("'","",$this->session->userdata("tSesUsrShpName".$tTypeShp));
        }else{
            $tBchCode   = "";
            $tBchName   = "";
            $tShpCode   = "";
            $tShpName   = "";
        }

        // Create By Napat(Jame) 19/05/2020
        $tUsrAgnCode = $this->session->userdata("tSesUsrAgnCode");
        $tUsrAgnName = $this->session->userdata("tSesUsrAgnName");
    }

?>

<?php

    $tRolCode   = "";
    $tRolName   = "";

    if(isset($aResActRole['raItems']) && !empty($aResActRole['raItems'])){
        foreach ($aResActRole['raItems'] AS $key => $aValue) {
            $tRolName   .= $aValue['FTRolName'];
            $tRolName .= ',';
        }
    }

    if(isset($aResActRole['raItems']) && !empty($aResActRole['raItems'])){
        foreach ($aResActRole['raItems'] AS $key => $aValue) {
            $tRolCode   .= $aValue['FTRolCode'];
            $tRolCode .= ',';
        }
    }

?>
<input type="hidden" name="ohdURSRolMultiAccess" id="ohdURSRolMultiAccess" value="<?=$this->session->userdata('tSesUsrRoleCodeMulti');?>">
<div class="panel panel-headline">
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="custom-tabs-line tabs-line-bottom left-aligned">        
                    <ul class="nav" role="tablist"> 
                        <!-- ข้อมูลทั่วไป -->   
                        <li id="oliUsrloginDetail" class="xWMenu active" data-menutype="DT">
                            <a role="tab" data-toggle="tab" data-target="#odvUsrloginContentInfoDT" aria-expanded="true"><?php echo language('authen/user/user','tTabNormal')?></a>
                        </li>

                        <!---ข้อมูลล็อกอิน-->
                        <!-- Witsarut Add 10/08/2019 14: 00 -->
                                <!-- ตรวจสอบโหมดการเรียก Page
                                    ถ้าเป็นโหมดเพิ่ม ($aResult['rtCode'] == '99') ให้ปิด Tab ข้อมูลล็อกอิน 
                                    ถ้าเป็นโหมดแก้ไข ($aResult['rtCode'] = 1) ให้เปิด Tab ข้อมูลล็อกอิน 
                                -->
                        <?php
                            if($aResult['rtCode'] == '99'){
                        ?>
                            <li id="oliUsrlogin" class="xWMenu xWSubTab disabled" data-menutype="Log">
                                <a role="tab"   aria-expanded="true"><?php echo language('authen/user/user','tDetailLogin')?></a>
                            </li>
                        <?php }else{ ?>
                            <li id="oliUsrlogin" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxUsrloginGetContent();">
                                <a role="tab" data-toggle="tab" data-target="#odvUsrloginData" aria-expanded="true"><?php echo language('authen/user/user','tDetailLogin')?></a>
                            </li>
                        <?php } ?>
                    </ul>    
                </div>
            </div>
        </div>
    
        <div id="odvPdtRowContentMenu" class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <!-- Tab Content Detail -->
                    <div class="tab-content">
                        <div id="odvUsrloginContentInfoDT" class="tab-pane fade active in">
                            <form action="javascript:void(0)" method="post" enctype="multipart/form-data" autocomplete="off" id="ofmAddEditUser">
                                <button class="xCNHide" id="obtAddEditUser" type="button" onclick="JSxUSRCheckDrumpData()"></button>
                                <button class="xCNHide" id="obtUsrNewAddEdit" type="submit" onclick="JSnAddEditUser('<?=$tRoute?>')"></button>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
                                                <?php echo FCNtHGetContentUploadImage(@$tImgObj, 'user');?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                <div class="row">
                                                <!-- รหัสผู้ใช้ -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('authen/user/user','tUSRCode')?></label>
                                                    <div class="form-group" id="odvUserAutoGenCode">
                                                        <div class="validate-input">
                                                            <label class="fancy-checkbox">
                                                                <input type="checkbox" id="ocbUserAutoGenCode" name="ocbUserAutoGenCode" checked="true" value="1">
                                                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>                                    

                                                    <div class="form-group" id="odvUserCodeForm">
                                                    <input type="hidden" id="ohdCheckDuplicateUsrCode" name="ohdCheckDuplicateUsrCode" value="1">
                                                        <div class="validate-input">
                                                            <input 
                                                                type="text" 
                                                                class="form-control xCNGenarateCodeTextInputValidate" 
                                                                maxlength="20" 
                                                                id="oetUsrCode" 
                                                                name="oetUsrCode"
                                                                placeholder="<?= language('authen/user/user','tUSRCode')?>"
                                                                value="<?php echo $tUsrCode; ?>" 
                                                                data-is-created="<?php echo $tUsrCode; ?>"
                                                                data-validate-required = "<?= language('common/main/main','tValidCode')?><?= language('authen/user/user','tUSRCode')?>"
                                                                data-validate-dublicateCode = "<?= language('common/main/main','tValidCode')?><?= language('authen/user/user','tUSRCode')?>">
                                                        </div>
                                                    </div>
                                
                                                </div>
                                                <!-- end รหัสผู้ใช้ -->
                                                
                                                <!-- ชื่อผู้ใช้ -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('authen/user/user','tUSRName')?></label>
                                                            <input class="form-control" maxlength="50" type="text" id="oetUsrName" name="oetUsrName" 
                                                            placeholder="<?= language('authen/user/user','tUSRName')?>"
                                                            value="<?=$tUsrName?>"
                                                            data-validate-required = "<?= language('common/main/main','tUSRVldUser')?>"
                                                            data-validate-dublicateCode = "<?= language('authen/user/user','tUSRVldUser')?>
                                                            ">
                                                    </div>
                                                </div>
                                                <!-- End ชื่อผู้ใช้ -->
                                                        
                                                <!-- อีเมล์ -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('authen/user/user','tUSREmail')?></label>
                                                            <input class="form-control" maxlength="50" type="email" id="oetUsrEmail" name="oetUsrEmail" placeholder="<?= language('authen/user/user','tUSREmail')?>" 
                                                            value="<?=$tUsrEmail?>">
                                                    </div>
                                                </div>
                                                <!-- end อีเมล์ -->

                                                <!-- เบอร์โทร -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                            <label class="xCNLabelFrm"><?= language('authen/user/user','tUSRTel')?></label>
                                                            <input class="form-control" maxlength="50" type="text" id="oetUsrTel" name="oetUsrTel"
                                                            value="<?=$tUsrTel?>"
                                                            placeholder="<?= language('authen/user/user','tUSRTel')?>"
                                                            >
                                                    </div>
                                                </div>
                                                <!-- end เบอร์โทร -->

                                                <!-- Agency -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">           
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('authen/user/user','tUSRAgency')?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control xCNHide" id="oetUsrAgnCode" name="oetUsrAgnCode" value="<?=@$tUsrAgnCode?>">
                                                            <input type="text" class="form-control xWPointerEventNone" id="oetUsrAgnName" name="oetUsrAgnName" 
                                                                data-validate-required = "<?php echo  language('authen/user/user','tUsrValiAgency');?>"
                                                                placeholder="<?php echo language('authen/user/user','tUSRAgency')?>"
                                                                value="<?=@$tUsrAgnName?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="obtUsrBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end Agency -->

                                                <!-- สาขา -->
                                                <?php 
                                                    $tDisabledButton = "";
                                                    // echo "tSesUsrLevel: ".$this->session->userdata("tSesUsrLevel")."<br>";
                                                    // echo "tSesUsrLoginLevel: ".$this->session->userdata("tSesUsrLoginLevel")."<br>";
                                                    // echo "nSesUsrBchCount: ".$this->session->userdata("nSesUsrBchCount")."<br>";
                                                    if( $this->session->userdata("tSesUsrLoginLevel") != "AGN" && $this->session->userdata("tSesUsrLoginLevel") != "HQ" ){

                                                        if( $this->session->userdata("nSesUsrBchCount") < 2 ){
                                                            $tDisabledButton = "disabled";
                                                        }

                                                        if( $this->session->userdata("tSesUserCode") == $tUsrCode ){
                                                            $tDisabledButton = "disabled";
                                                        }
                                                        
                                                    }
                                                    // echo "tSesUserCode: ".$this->session->userdata("tSesUserCode")."<br>";
                                                    // echo "tUsrCode: ".$tUsrCode."<br>";
                                                    
                                                    // echo $tDisabledButton;
                                                ?>
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">           
                                                    <div class="form-group" style="margin-bottom: 0px;">
                                                            <label class="xCNLabelFrm"><?php echo language('authen/user/user','tUSRBranch')?></label>
                                                            <div class="input-group">
                                                                <input  type="text" class="form-control xCNHide" id="oetBranchCode" name="oetBranchCode" 
                                                                        value="<?php echo $tBchCode?>" 
                                                                        placeholder="<?php echo language('authen/user/user','tUSRBranch')?>" 
                                                                        data-validate-required = "<?php echo  language('authen/user/user','tUSRVldBchMore');?>"
                                                                        readonly
                                                                >
                                                                <input type="text" class="form-control" id="oetBranchName" name="oetBranchName" value="<?php echo $tBchName?>" readonly>
                                                                <span class="input-group-btn">
                                                                    <button id="oimBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn" <?=$tDisabledButton;?> >
                                                                        <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                    </button>
                                                                </span>
                                                        </div>
                                                    </div>

                                                    <div style="white-space:nowrap;width:100%;overflow-x:auto;margin-bottom: 10px;"> 
                                                        <div id="odvBranchShow" style="margin-bottom: 10px;margin-top: 10px;">
                                                            <?php if(isset($aResUsrGroup['raItems']) && !empty($aResUsrGroup['raItems'])){ ?>
                                                                <?php 
                                                                    $tBchName = "";
                                                                    foreach ($aResUsrGroup['raItems'] AS $key => $aValue) { 
                                                                        
                                                                        if( !empty($aValue['FTBchName']) && strpos($tBchName, $aValue['FTBchName']) !== 0 ){ // เช็คค่าซ้ำ 
                                                                            $tBchName .= $aValue['FTBchName'];
                                                                ?>
                                                                            <span class="label label-info m-r-5"><?=$aValue['FTBchName'];?></span>
                                                                <?php
                                                                        } 
                                                                    } 
                                                                ?>
                                                            <?php }else{ ?>
                                                                <?php if(!empty($tBchName)){ ?>
                                                                    <?php foreach(explode(",",$tBchName) AS $key => $aValue){ ?>
                                                                        <span class="label label-info m-r-5"><?=$aValue;?></span>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                </div><br>
                                                <!-- end สาขา -->

                                                <!-- กลุ่มสิทธิ์ -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group" style="margin-bottom: 0px;">
                                                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('authen/user/user','tUSRRole')?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control xCNHide" id="oetRoleCode" name="oetRoleCode" value="<?php echo $tRolCode?>">
                                                            <input type="text" class="form-control xWPointerEventNone" id="oetRoleName" name="oetRoleName"
                                                                placeholder="<?php echo language('authen/user/user','tUSRRoleGroup')?>"
                                                                value="<?php echo $tRolName?>" 
                                                                placeholder="<?= language('authen/user/user','tUSRRole')?>"
                                                                data-validate-required = "<?php echo  language('authen/user/user','tCRDValiUser');?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="oimBrowseRole" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div style="white-space:nowrap;width:100%;overflow-x:auto;margin-bottom: 10px;">
                                                        <div  id="odvUsrRoleShow" style="margin-bottom: 10px;margin-top: 10px;">
                                                            <?php if(isset($aResActRole['raItems']) && !empty($aResActRole['raItems'])){ ?>
                                                            <?php foreach ($aResActRole['raItems'] AS $key => $aValue) { ?>
                                                                <span class="label label-info m-r-5"><?=$aValue['FTRolName'];?></span>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End กลุ่มสิทธิ์ -->

                                                <!-- หน่วยงาน -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?php echo language('authen/user/user','tUSRDepart')?></label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control xCNHide" id="oetDepartCode" name="oetDepartCode" value="<?php echo $tDptCode?>">
                                                                <input type="text" class="form-control xWPointerEventNone" id="oetDepartName" name="oetDepartName" 
                                                                placeholder="<?php echo language('authen/user/user','tUSRDepart')?>"
                                                                value="<?php echo $tDptName?>" readonly>
                                                                <span class="input-group-btn">
                                                                <button id="oimBrowseDepart" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end หน่วยงาน -->

                                                <!-- Merchant -->  
                                                <!-- ซ่อนไว้ -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 "> 
                                                    <div class="form-group <?php if( !FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
                                                        <label class="xCNLabelFrm"><?php echo language('authen/user/user','tUSRMerchant')?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control xCNHide" id="oetUsrMerCode" name="oetUsrMerCode" value="<?=$tMerCode?>">
                                                            <input type="text" class="form-control xWPointerEventNone" id="oetUsrMerName" name="oetUsrMerName" 
                                                                data-validate-required = "<?php echo  language('authen/user/user','tCRDValiMerchant');?>"
                                                                placeholder="<?php echo language('authen/user/user','tUSRMerchant')?>"
                                                                value="<?php echo $tMerName?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="obtUsrBrowseMerchant" type="button" class="btn xCNBtnBrowseAddOn">
                                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end Merchant -->
                                                
                                                <!-- ร้านค้า -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12"> 
                                                    <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>" style="margin-bottom: 0px;">
                                                        <label class="xCNLabelFrm"><?php echo language('authen/user/user','tUSRShop')?></label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control xCNHide" id="oetShopCode" name="oetShopCode" value="<?php echo $tShpCode?>" placeholder="<?php echo language('authen/user/user','tUSRShop')?>" readonly>
                                                            <input type="text" class="form-control " id="oetShopName" name="oetShopName" 
                                                                placeholder="<?php echo language('authen/user/user','tUSRShop')?>"
                                                                value="<?php echo $tShpName?>" readonly>
                                                            <span class="input-group-btn">
                                                                <button id="oimBrowseShop" type="button" class="btn xCNBtnBrowseAddOn" <?php if($tBchCode==''){ echo 'disabled'; } ?>>
                                                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div style="white-space:nowrap;width:100%;overflow-x:auto;margin-bottom: 10px;">
                                                        <div id="odvShopShow" style="margin-bottom: 10px;margin-top: 10px;">
                                                            <?php if(isset($aResUsrGroup['raItems']) && !empty($aResUsrGroup['raItems'])){ ?>
                                                                <?php foreach ($aResUsrGroup['raItems'] AS $key => $aValue) { ?>
                                                                    <span class="label label-info m-r-5"><?=$aValue['FTShpName'];?></span>
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                                <?php if(!empty($tShpName)){ ?>
                                                                    <?php foreach(explode(",",$tShpName) AS $key => $aValue){ ?>
                                                                        <span class="label label-info m-r-5"><?=$aValue;?></span>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                             
                                                </div><br><br>
                                                <!-- end ร้านค้า -->

                                                <!-- เหตุผล -->
                                                <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="xCNLabelFrm"><?= language('authen/user/user','tUSRRemark')?></label>
                                                        <textarea class="form-control" maxlength="100" rows="4" id="otaUsrRemark" name="otaUsrRemark"><?=$tUsrRmk?></textarea>
                                                    </div>
                                                </div>
                                                <!-- end เหตุผล -->

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div> 
                <!--  End Tab Content Detail -->
                <!-- Tab LoinData  -->
                    <div id="odvUsrloginData" class="tab-pane fade"></div>
                <!-- End Tab LoinData  -->      
            </div>   
        </div>    
    </div>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="odvUSRModalAlert" tabindex="-1" role="dialog">
<!-- <div class="modal fade" id="odvUSRModalAlert"> -->
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard">-</label>
            </div>
            <div class="modal-body">-</div>
            <div class="modal-footer">
                <button id="obtUSRModalAlertConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button id="obtUSRModalAlertCancel" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include 'script/jUserAdd.php'; ?>


