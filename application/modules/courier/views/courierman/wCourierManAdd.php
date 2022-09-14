<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "courierManEventEdit"; 
        $tCryCode   = $aCrmData['raItems']['rtCryCode'];
        $tCryID     = $aCrmData['raItems']['rtCryManID'];
        $tCryTel    = $aCrmData['raItems']['rtCryTel'];
        $tCryEmp    = $aCrmData['raItems']['rtCryManCard'];
        $tCrySex    = $aCrmData['raItems']['rtCrySex'];
        $tCryDob    = $aCrmData['raItems']['rtCryDob'];
        $tCryStaActive    = $aCrmData['raItems']['rtCryStaActive'];
        $tCryManName      = $aCrmData['raItems']['rtCryManName'];
        $tCryRmk     = $aCrmData['raItems']['rtCryRmk'];
        $tCryName    = $aCrmData['raItems']['rtCryName'];

        $dGetDataNow    = "";
    }else{
        $tRoute         = "courierManEventAdd";
        $tCryCode       = "";
        $tCryID         = "";
        $tCryTel        = "";
        $tCryEmp        = "";
        $tCrySex        = "";
        $tCryDob        = "";
        $tCryStaActive  = "1";
        $tCryManName    = "";
        $tCryRmk        = "";
        $tCryName       = "";
        $tImgObj        = "";

        $dGetDataNow    = date('Y-m-d');
    }
?>

    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body"> <!-- เพิ่มมาใหม่ -->
            <div id="odvPdtRowNavMenu" class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="custom-tabs-line tabs-line-bottom left-aligned">
                        <ul class="nav" role="tablist">
                            <!-- ข้อมูลทั่วไป -->
                            <li id="oliCURDetail" class="xWMenu active" data-menutype="DT">
                                <a role="tab" data-toggle="tab" data-target="#odvCurContentInfoDT" aria-expanded="true"><?php echo language('courier/courier/courier','tNameTabNormal')?></a>
                            </li>

                            <!---ข้อมูลล็อกอิน-->
                            <!-- Kitpipat Add 10/08/2019 14: 00 -->
                                 <!-- ตรวจสอบโหมดการเรียก Page
                                      ถ้าเป็นโหมดเพิ่ม (nStaAddOrEdit = 99) ให้ปิด Tab ข้อมูลล็อกอิน 
                                      ถ้าเป็นโหมดแก้ไข (nStaAddOrEdit = 1) ให้เปิด Tab ข้อมูลล็อกอิน 
                                  -->
                            <?php
                                if($nStaAddOrEdit == '99'){
                            ?>
                                <li id="oliCourierLogin" class="xWMenu xWSubTab disabled" data-menutype="Log">
                                    <a role="tab"   aria-expanded="true"><?php echo language('courier/courier/courier','tDetailLogin')?></a>
                                </li>
                            <?php } else { ?>

                                <li id="oliCourierLogin" class="xWMenu xWSubTab" data-menutype="Log" onclick="JSxCMLGetContent();">
                                    <a role="tab" data-toggle="tab" data-target="#odvCourierLoginData" aria-expanded="true"><?php echo language('courier/courier/courier','tDetailLogin')?></a>
                                </li>

                            <?php } //end if ?>

                        </ul>
                    </div>
                </div>
            </div>
	        <!-- Content tab Add Product -->
	        <div id="odvPdtRowContentMenu" class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Tab Content Detail -->
                    <div class="tab-content">
                    <div id="odvCurContentInfoDT" class="tab-pane fade active in">
                            <form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddCurman">
                                <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>">
                                <button style="display:none" type="submit" id="obtSubmitCurMan" onclick="JSxShopSetValidEventBlur();"></button>       
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4 col-lg-4"> <!-- เปลี่ยน Col Class -->
                                                <?php echo FCNtHGetContentUploadImage(@$tImgObjAll, 'CourierMan');?>
                                            </div>
                                            
                                            <div class="col-xs-12 col-md-5 col-lg-5">
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo  language('courier/courierman/courierman','tCman')?></label>
                                                    
                                                    <div class="input-group">
                                                        <input class="form-control xCNHide" id="oetCourierCode" name="oetCourierCode" maxlength="5" value="<?php echo $tCryCode ; ?>"> <!--value="<?php if(@$nCnfAddVersion == '1'){ echo @$aCnfAddPanal[0]->FTAddV1PvnCode; } ?>" -->
                                                        <input class="form-control xWPointerEventNone" type="text" id="oetCourierName" 
                                                        placeholder="<?php echo language('courier/courierman/courierman','tCman')?>"
                                                        name="oetCourierName" value="<?php echo $tCryName ; ?>" readonly
                                                        data-validate-required="<?php echo language('courier/courierman/courierman','tCRMSlccourier')?>"
                                                        >
                                                        <span class="input-group-btn">
                                                            <button id="obtBrowseCourier" type="button" class="btn xCNBtnBrowseAddOn">
                                                                <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="0" id="ohdCheckCpgClearValidate" name="ohdCheckCpgClearValidate"> 
                                                <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('courier/courierman/courierman','tCRMmanCode')?></label> <!-- เปลี่ยนชื่อ Class -->

                                            
                                                <div class="form-group" id="odvPunCodeForm">
                                                    <input 
                                                        type="text" 
                                                        class="form-control" 
                                                        maxlength="20" 
                                                        id="oetManCode" 
                                                        name="oetManCode"
                                                        value="<?php echo $tCryEmp; ?>" 
                                                        placeholder="<?php echo language('courier/courierman/courierman','tCRMmanCode')?>"
                                                        data-validate-required="<?php echo language('courier/courierman/courierman','tCRMValidmanCode')?>">
                                                    <input type="hidden" value="2" id="ohdCheckDuplicateCpgCode" name="ohdCheckDuplicateCpgCode"> 
                                                </div>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('courier/courierman/courierman','tCRMManName')?></label> <!-- เปลี่ยนชื่อ Class -->
                                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetManName" 
                                                    placeholder="<?php echo language('courier/courierman/courierman','tCRMManName')?>"
                                                    name="oetManName"
                                                    data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpNameemp')?>"
                                                    value="<?php echo $tCryManName;?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                                                </div>
                                                <div class="form-group">
                                                    <div class="fancy-radio">
                                                        <label class="xCNLabelFrm"><?php echo language('courier/courierman/courierman','tCRMSex')?></label><br> 
                                                        <label>
                                                            <?php $tTspPaid1Select = $tCrySex == "1" ? "checked" : ""?>
                                                            <?php $tTspPaid2Select = $tCrySex == "2" ? "checked" : ""?>
                                                            <input type="radio" name="orbSex" value="1" <?php echo $tTspPaid1Select ; ?>>
                                                            <span><i></i><?php echo language('courier/courierman/courierman','tCRMSexMale')?></span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="orbSex" value="2" <?php echo $tTspPaid2Select ; ?>>
                                                            <span><i></i><?php echo language('courier/courierman/courierman', 'tCRMSexFemale')?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('courier/courierman/courierman','tCRMIDPass')?></label> <!-- เปลี่ยนชื่อ Class -->
                                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetID" name="oetID"
                                                    data-validate-required="<?php echo language('courier/courierman/courierman','tCRMValidIDPass')?>" 
                                                    placeholder="<?php echo language('courier/courierman/courierman','tCRMIDPass')?>"
                                                    value="<?php echo $tCryID; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('courier/courierman/courierman','tCRMTel')?></label> <!-- เปลี่ยนชื่อ Class -->
                                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" maxlength="50" id="oetManTel" 
                                                    name="oetManTel" 
                                                    placeholder="<?php echo language('courier/courierman/courierman','tCRMTel')?>"
                                                    value="<?php echo $tCryTel ; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo  language('courier/courierman/courierman','tCRMDob')?></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetManDob" name="oetManDob" value="<?php if($tCryDob != ""){ echo $tCryDob ;}else{echo $dGetDataNow;}?>">
                                                        <span class="input-group-btn">
                                                            <button id="obtManDob" type="button" class="btn xCNBtnDateTime">
                                                            <img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('courier/courierman/courierman','tCRMRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                                                    <textarea class="form-control" maxlength="100" rows="4" id="otaManRmk" name="otaManRmk"><?=$tCryRmk?></textarea>
                                                </div>
                                                
                                                <!-- ตรวจสอบสถานะ -->
                                                <div class="form-group">
                                                    <label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStaActive')?></label>
                                                        <select class="selectpicker form-control" id="ocbManSta" name="ocbManSta" maxlength="1">
														<option value="1"><?php echo language('company/branch/branch', 'tBCHStaActive1') ?></option>
														<option value="2"><?php echo language('company/branch/branch', 'tBCHStaActive2') ?></option>
													</select>
												</div>


                                                <div class="col-xs-12 col-md-3 col-lg-3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>

                            <!-- Tab LoinData  -->
                            <div id="odvCourierLoginData" class="tab-pane fade"></div>
                    </div>
                </div>
            </div>
        </div>
<input type="hidden" id="ohdCheckTelDup" value="1">
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jCourierManAdd.php"; ?>

<script>
    $('.selectpicker').selectpicker();
    $('#obtGenCodeCpg').click(function(){
        JStGenerateCpgCode();
    });
    $('#obtManDob').click(function(event){
        $('#oetManDob').datepicker('show');
        event.preventDefault();
    });

    //บริษัท
var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
var oBrowseCourier = {
	Title : ['courier/courierman/courierman','tCman'],
	Table:{Master:'TCNMCourier',PK:'FTCryCode'},
	Join :{
		Table:	['TCNMCourier_L'],
		On:['TCNMCourier_L.FTCryCode = TCNMCourier.FTCryCode AND TCNMCourier_L.FNLngID = '+nLangEdits,]
	},
	// Filter:{
	// 	Selector:'oetAddV1PvnCode',
	// 	Table:'TCNMProvince',
    //     Key:'FTPvnCode'
	// },
	GrideView:{
		ColumnPathLang	: 'address/province/province',
		ColumnKeyLang	: ['tPVNCode','tPVNName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMCourier.FTCryCode','TCNMCourier_L.FTCryName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMCourier.FTCryCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCourierCode","TCNMCourier.FTCryCode"],
		Text		: ["oetCourierName","TTCNMCourier_L.FTCryName"],
	}
	// NextFunc:{
	// 	FuncName:'JSxChekDisableAddress',
	// 	ArgReturn:['FTPvnCode',]
    // },
	// RouteAddNew : 'province',
	// BrowseLev : nStaBchBrowseType
}
$('#obtBrowseCourier').click(function(){
    // Create By Witsarut 04/10/2019
        JSxCheckPinMenuClose();
    // Create By Witsarut 04/10/2019
    JCNxBrowseData('oBrowseCourier');
});
$(document).ready(function () {
    // JSxShopSetValidEventBlur();
});

function JSxShopSetValidEventBlur(){
    $('#ofmAddCurman').validate().destroy();
    $('#ofmAddCurman').validate({
        rules: {
            oetManCode : {
                "required" :{}
            },
            oetCourierName:     {"required" :{}},
            oetManName:         {"required" :{}},
            oetID:              {"required" :{}},
        },
        messages: {
            oetManCode : {
                "required"      : $('#oetManCode').attr('data-validate-required')
            },
            oetCourierName : {
                "required"      : $('#oetCourierName').attr('data-validate-required'),
            },
            oetManName : {
                "required"      : $('#oetManName').attr('data-validate-required'),
            }
            ,
            oetID : {
                "required"      : $('#oetID').attr('data-validate-required'),
            }
        },
        errorElement: "em",
        errorPlacement: function (error, element ) {
            error.addClass( "help-block" );
            if ( element.prop( "type" ) === "checkbox" ) {
                error.appendTo( element.parent( "label" ) );
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0){
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form){
            JSxCheckDuplicateTel();
        }
    });
}
function JSxCheckDuplicateTel(){
    $.ajax({
        type: "POST",
        url: "courierManCheckTelDup",
        data: {
            "FTCryCode" : $("#oetCourierCode").val(),
            "FTManCardID" : $("#oetID").val(),
            "FTManTel" : $("#oetManTel").val()
        },
        cache: false,
        timeout: 0,
        success: function (tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdCheckTelDup").val(aResult["nStaEvent"]);
            $('#ofmAddCurman').validate().destroy();
            $.validator.addMethod('dublicateTel', function (value, element) {
                if($("#ohdCheckTelDup").val()!=1){
                    return false;
                }else{
                    return true;
                }
            });
            $('#ofmAddCurman').validate({
                rules: {
                    oetManTel : {
                        "dublicateTel" : {}
                    }
                },
                messages: {
                    oetManTel : {
                        "dublicateTel" : "ข้อมูลเบอร์โทรศัพท์ซ้ำ"
                    }
                },
                errorElement: "em",
                errorPlacement: function (error, element ) {
                    error.addClass( "help-block" );
                    if ( element.prop( "type" ) === "checkbox" ) {
                        error.appendTo( element.parent( "label" ) );
                    } else {
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if(tCheck == 0){
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function ( element, errorClass, validClass ) {
                    $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function (element, errorClass, validClass) {
                    $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                },
                submitHandler: function(form){
                    JSoAddEditCpg('<?php echo $tRoute;?>');
                }
            });
            $('#ofmAddCurman').submit();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


$('#oliCURDetail').off('click').on('click',function(){
    $('#odvBtnAddEdit').show(); // เปิดปุ่มบันทึกใหญ่ เมื่อคลิกแท็บหน้าจอหลัก 09/11/2020 Napat(Jame)
});

</script>