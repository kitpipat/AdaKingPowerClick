<?php
    if($aResult['rtCode'] == "1"){
        $tCstCode               = $aResult['raItems']['rtCstCode'];
        $tCstCardID             = $aResult['raItems']['rtCstCardID'];
        $tCstDob                = date("Y-m-d", strtotime($aResult['raItems']['rtCstDob']));
        $tCstSex                = $aResult['raItems']['rtCstSex'];
        $tCstBusiness           = $aResult['raItems']['rtCstBusiness'];
        $tCstTaxNo              = $aResult['raItems']['rtCstTaxNo'];
        $tCstStaActive          = $aResult['raItems']['rtCstStaActive'];
        $tCstName               = $aResult['raItems']['rtCstName'];
        $tCstRmk                = $aResult['raItems']['rtCstRmk'];
        $tCstTel                = $aResult['raItems']['rtCstTel'];
        $tCstEmail              = $aResult['raItems']['rtCstEmail'];
        $tCstCgpCode            = $aResult['raItems']['rtCstCgpCode'];
        $tCstCgpName            = $aResult['raItems']['rtCstCgpName'];
        $tCstCtyCode            = $aResult['raItems']['rtCstCtyCode'];
        $tCstCtyName            = $aResult['raItems']['rtCstCtyName'];
        $tCstClvCode            = $aResult['raItems']['rtCstClvCode'];
        $tCstClvName            = $aResult['raItems']['rtCstClvName'];
        $tCstOcpCode            = $aResult['raItems']['rtCstOcpCode'];
        $tCstOcpName            = $aResult['raItems']['rtCstOcpName'];
        $tCstPplCodeRet         = $aResult['raItems']['rtCstPplCodeRet'];
        $tCstPplNameRet         = $aResult['raItems']['rtCstPplNameRet'];
        $tCstCodeWhs            = $aResult['raItems']['rtCstPplCodeWhs'];
        $tCstWhsName            = $aResult['raItems']['rtCstPplNameWhs'];
        $tPplCodeNet            = $aResult['raItems']['rtPplCodeNet'];
        $tPplNameNet            = $aResult['raItems']['rtPplNameNet'];
        $tCstPmgCode            = $aResult['raItems']['rtCstPmgCode'];
        $tCstPmgName            = $aResult['raItems']['rtCstPmgName'];
        $tCstDiscRet            = $aResult['raItems']['rtCstDiscRet'];
        $tCstDiscWhs            = $aResult['raItems']['rtCstDiscWhs'];
        $tCstBchHQ              = $aResult['raItems']['rtCstBchHQ'];
        $tCstBchCode            = $aResult['raItems']['rtCstBchCode'];
        $tCstBchName            = $aResult['raItems']['rtCstBchName'];
        $tCstStaAlwPosCalSo     = $aResult['raItems']['rtCstStaAlwPosCalSo'];
        $tAgnCode               = $aResult['raItems']['FTAgnCode']; 
        $tAgnName               = $aResult['raItems']['FTAgnName'];
        $tRoute                 = "customerEventEdit";
    }else{
        $tCstCode               = "";
        $tCstCardID             = "";
        $tCstDob                = "";
        $tCstSex                = "1";
        $tCstBusiness           = "1";
        $tCstTaxNo              = "";
        $tCstStaActive          = "1";
        $tCstName               = "";
        $tCstRmk                = "";
        $tCstTel                = "";
        $tCstEmail              = "";
        $tCstCgpCode            = "";
        $tCstCgpName            = "";
        $tCstCtyCode            = "";
        $tCstCtyName            = "";
        $tCstClvCode            = "";
        $tCstClvName            = "";
        $tCstOcpCode            = "";
        $tCstOcpName            = "";
        $tCstPplCodeRet         = "";
        $tCstPplNameRet         = "";
        $tCstPmgCode            = "";
        $tCstPmgName            = "";
        $tCstDiscRet            = "";
        $tCstDiscWhs            = "";
        $tCstBchHQ              = "";
        $tCstBchCode            = $this->session->userdata("tSesUsrBchCodeDefault");
        $tCstBchName            = $this->session->userdata("tSesUsrBchNameDefault");
        $tCstPplCodeWhs         = "";
        $tCstWhsName            = "";
        $tPplCodeNet            = "";
        $tPplNameNet            = "";
        $tCstStaAlwPosCalSo     = "1";
        $tAgnCode               = $this->session->userdata("tSesUsrAgnCode");
        $tAgnName               = $this->session->userdata("tSesUsrAgnName");
        $tRoute                 = "customerEventAdd";
    }
    $tCardInfoRoute = "customerEventAddUpdateCardInfo";
    $tCreditRoute   = "customerEventAddUpdateCredit";
    $tRfidRoute     = "customerEventAddUpdateRfid";
?>
<style>
    .xCNCenter {
        margin-left: auto;
        margin-right: auto;
    }
    .tab-content{
        margin-top: 20px;
    }
    .tab-pane {
        padding: 0px 0px;
    }
    .custom-tabs-line.tabs-line-bottom a {
        cursor: pointer;
    }
    .custom-tabs-line.tabs-line-bottom .active a {
        border-bottom: 4px solid #00a0f0;
        color: #00a0f0 !important;
    }
    .fancy-radio label{
        width: 150px;
    }
    .fancy-checkbox {
        display: inline-block;
        font-weight: normal;
        width: 120px;
    }
    .xWCstHidden {
        display: none;
    }
    .xWActionSubMenu{
        margin-top: 10px;
    }
    .xWActionSubMenu button:last-child{
        margin-right: 5px;
    }
    .xCNMapShow {
        /* height: 200px; */
        width: 100%;
        margin: 0;
        padding: 0px;
    }
    .xWCstBtn {
        box-shadow: none;
        font-size: 18px;
    }
    .xWRfid.active{
        border: 1px solid #cccccc;
    }
    .xWRfid.active:focus{
        border: 1px solid #00a0f0 !important;
        -webkit-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
    }
    .xWContact.active{
        border: 1px solid #cccccc;
    }
    .xWContact.active:focus{
        border: 1px solid #00a0f0 !important;
        -webkit-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
    }
    .record-invalid{
        color: #a94442 !important;
        border: 1px solid #a94442 !important;
        -webkit-box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
        box-shadow: 0px 1px 2px 0 rgba(0, 0, 0, 0.2);
    }
    .xWFullWidth{
        width: 100% !important;
    }
    .xWImgCustomerContact{
        max-width: 80px;
    }
    .xWCstContactRmk .input100{
        min-height: 50px;
        max-height: 50px;
    }
</style>
<div class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="col-xl-12 col-lg-12 col-md-12" id="odvContentContainer">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                        <div class="row">
                            <div id="odvNavMenu" class="col-xl-12 col-lg-12">
                                <?php 
                                if(!empty($tCstCode)){
                                    $dataToggle = 'tab';   
                                    $tabDisabled = 'enabled';
                                }else{
                                    $dataToggle = 'false';
                                    $tabDisabled = 'disabled';
                                }
                                ?>
                                <input type="hidden" id="ohdNavActive" value="oliCstInfo1">
                                <ul class="nav" role="tablist" data-typetab="main" data-tabtitle="cstinfo">
                                    <li id="oliCstInfo1" class="xWMenu active">
                                        <a 
                                            role="tab" 
                                            data-toggle="tab" 
                                            data-target="#odvTabInfo1"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="true"><?php echo language('customer/customer/customer','tCSTTabInfo')?></a>
                                    </li>
                                    <li id="oliCstInfo2" class="xWMenu" data-typetab="main" data-tabtitle="cstinfo2">
                                        <a 
                                            role="tab" 
                                            data-toggle="tab" 
                                            data-target="#odvTabInfo2"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabInfo2')?></a>
                                    </li>
                                    <li id="oliCstAddress" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstaddress">
                                        <a 
                                            role="tab"
                                            class="xWOption xWDelSubMenu"
                                            data-toggle="<?php echo $dataToggle?>"
                                            data-target="#odvCSTTabAddress"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabAddress')?></a>
                                    </li>
                                    <li id="oliCstContact" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstcontact">
                                        <a 
                                            role="tab"
                                            class="xWOption"
                                            data-toggle="<?php echo $dataToggle?>" 
                                            data-target="#odvTabContact"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabContact')?></a>
                                    </li>
                                    <li id="oliCstCardInfo" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstcardinfo">
                                        <a 
                                            role="tab"
                                            class="xWOption"
                                            data-toggle="<?php echo $dataToggle?>" 
                                            data-target="#odvTabCardInfo"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabCardInfo')?></a>
                                    </li>
                                    <li id="oliCstCredit" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstcredit">
                                        <a 
                                            role="tab"
                                            class="xWOption"
                                            data-toggle="<?php echo $dataToggle?>" 
                                            data-target="#odvTabCredit"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabCredit')?></a>
                                    </li>
                                    <li id="oliCstRfid" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstidrfid">
                                        <a 
                                            role="tab"
                                            class="xWOption xWDelSubMenu"
                                            data-toggle="<?php echo $dataToggle?>" 
                                            data-target="#odvTabIdRfid"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabIdRfid')?></a>
                                    </li>

                                    <!-- Create By Witsarut 26/10/2019 -->
                                    <!-- Add Tab DebitCard --> 
                                    <li id="oliCstDebitCard" class="xWMenu <?php echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstdebitcard">
                                        <a 
                                            role="tab" 
                                            class="xWOption xWDelSubMenu"
                                            data-toggle="<?php echo $dataToggle?>" 
                                            data-target="#odvTabDebitCard"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php echo language('customer/customer/customer','tCSTTabDebitCard');?>
                                        </a>
                                    </li>

                                    <?php if($aResult['rtCode'] == '99'){ ?>
                                        <li id="oliCstlogin" class="xWMenu xWSubTab disabled" data-menutype="Log">
                                            <a role="tab"   aria-expanded="true"><?php echo language('customer/customer/customer','tCSTTabDetailCstlogin')?></a>
                                        </li>
                                    <?php }else{ ?>
                                        <li id="oliCstlogin" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxCstloginGetContent();">
                                            <a role="tab" data-toggle="tab" data-target="#odvTabCstlogin" aria-expanded="true"><?php echo language('customer/customer/customer','tCSTTabDetailCstlogin')?></a>
                                        </li>
                                    <?php } ?>


                                    <!-- <li id="oliCstRegisFace" class="xWMenu <?php //echo $tabDisabled?>" data-typetab="sub" data-tabtitle="cstregisface">
                                        <a 
                                            role="tab"
                                            class="xWOption xWDelSubMenu"
                                            data-toggle="<?php //echo $dataToggle?>" 
                                            data-target="#odvTabRegisFace"
                                            onclick="JSxCSTVisibledActionSubMenu(this, event)"
                                            aria-expanded="false"><?php //echo language('customer/customer/customer','tCSTTabRegisFace')?></a>
                                    </li> -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row xWActionSubMenu hidden">
                <div id="odvActionSubMenu" class="col-xl-12 col-lg-12">
                    <!-- -ของเก่า -->
                    <!-- <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubSave" type="button">บันทึก</button> -->
                    <!-- <button class="btn xCNBTNPrimery xCNBTNPrimery1Btn pull-right" id="obtSubCancel" type="button">ยกเลิก</button> -->
                    
                    <!-- ใหม่ -->                                                                                                
                    <button class="btn pull-right" style="background-color: rgb(23, 155, 253); color: white;" id="obtSubSave" type="button"><?php echo language('common/main/main','tSave')?></button>
                    <button class="btn pull-right" style="background-color: #D4D4D4; color: #000000;" id="obtSubCancel" type="button"><?php echo language('common/main/main','tCancel')?></button>
                </div>
            </div>
            <div class="tab-content">
                    <?php include "tab/wCstTabInfo1.php"; ?>
                    <?php include "tab/wCstTabInfo2.php"; ?>
                    <?php include "tab/wCstTabAddress.php"; ?>
                    <?php include 'tab/wCstTabContact.php' ?>
                    <?php include 'tab/wCstTabCardInfo.php' ?>
                    <?php include 'tab/wCstTabCredit.php' ?>
                    <div id="odvTabIdRfid" class="tab-pane fade">
                        <?php include 'tab/wCstTabIdRfid.php' ?>
                    </div>
                    <?php include 'tab/wCstTabDebitCard.php'?>

                    <!-- create By witsarut 15-09-2020 -->
                    <!-- Customer login -->
                    <div id="odvTabCstlogin" class="tab-pane fade">
                        <?php include 'tab/customerlogin/wCstloginMain.php' ?>
                    </div>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $(document).ready(() => {
        
        $('body').on('focus',".xCNDatePicker", function(){
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                // startDate: new Date(),
                orientation: "bottom"
            });
        });
        
        $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
        $('[data-toggle="tooltip"]').tooltip({'placement': 'top'});

        $('#oimCstBrowseProvince').click(function(){
            JCNxBrowseData('oPvnOption');
        });
        
        if(JCNbCSTIsUpdatePage()){
            $("#obtGenCodeCst").attr("disabled", true);
        }
    });

    //Functionality: Event Click Tab Main Or Sub Contril Button Add
    //Parameters: Data Attr
    //Creator: 07/11/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    $('#odvNavMenu .xWMenu').unbind().click(function(){
        let tRoutePageAddOrEdit = '<?php echo @$tRoute;?>';
        if(tRoutePageAddOrEdit == 'customerEventAdd'){
            return;
        }else{
            let tTypeTab        = $(this).data('typetab');
            if(typeof(tTypeTab) !== undefined && tTypeTab == 'main'){
                return;
            }else if(typeof(tTypeTab) !== undefined && tTypeTab == 'sub'){
                let tTabTitle   = $(this).data('tabtitle');
                switch(tTabTitle){
                    case 'cstaddress':
                        // Call Function New Address Design
                        JSvGetCSTContentAddress();
                    break;
                };
            }
        }
    });

    //Functionality: Call View New Design Address
    //Parameters: Data Attr
    //Creator: 07/11/2019 wasin (Yoshi)
    //Return: View New Address Design
    //ReturnType: View
    function JSvGetCSTContentAddress(){
        let tAdressCstCode  = '<?php echo @$tCstCode;?>';
        let nStaSession     = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "customerAddressData",
                data: {'ptAddrCstCode' : tAdressCstCode},
                success	: function(tResult){
                    $('#odvCSTTabAddress').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

</script>
<?php include 'tab/script/wCstScriptInfo1.php' ?>
<?php include 'tab/script/wCstScriptInfo2.php' ?>
<?php include 'tab/script/wCstScriptContact.php' ?>
<?php include 'tab/script/wCstScriptCardInfo.php' ?>
<?php include 'tab/script/wCstScriptCredit.php' ?>
<?php include 'tab/script/wCstScriptRfid.php' ?>

<!-- Create By Witsarut 26/10/2016 -->
<?php include 'tab/script/wCstDebitCardAdd.php' ?>

