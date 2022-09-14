<?php
    if(isset($aDataResult) && $aDataResult['rtCode'] == '1'){
        $tRoute     = "pdtTouchGroupEventEdit";
        $tTCGCode   = $aDataResult['raItems']['FTTcgCode'];
        $tTCGName   = $aDataResult['raItems']['FTTcgName'];
        $tTCGStaUse = $aDataResult['raItems']['FTTcgStaUse'];
        $tTCGRmk    = $aDataResult['raItems']['FTTcgRmk'];

        $tTCGAgnCode      = $aDataResult['raItems']['FTAgnCode'];
        $tTCGAgnName      = $aDataResult['raItems']['FTAgnName'];

    }else{
        $tRoute     = "pdtTouchGroupEventAdd";
        $tTCGCode   = "";
        $tTCGName   = "";
        $tTCGStaUse = 1;
        $tTCGRmk    = "";


        $tTCGAgnCode  = $tSesAgnCode;
        $tTCGAgnName  = $tSesAgnName;
    }
?>
<form id="ofmPdtTouchGroupAddEditForm" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
    <input type="hidden"   id="ohdTCGCheckedColor" name="ohdTCGCheckedColor" value="0">
    <input type="hidden" id="ohdTCGCheckClearValidate" name="ohdTCGCheckClearValidate" value="0">
    <input type="hidden" id="ohdTCGCheckSubmitByButton" name="ohdTCGCheckSubmitByButton" value="0">
    <input type="hidden" id="ohdTCGCheckDuplicateCode" name="ohdTCGCheckDuplicateCode" value="2">
    <input type="hidden" id="ohdTCGRouteEvent" value="<?php echo @$tRoute;?>">
    <button style="display:none" type="submit" id="obtTCGEventSubmitForm" onclick="JSxTCGCheckValidateForm()"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <?php 
                      echo FCNtHGetContentUploadImage(@$tImgObj,'TCG');
                      echo FCNtHGetContentChooseColor(@$tImgObj,'TCG');
                ?>
                
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <label class="xCNLabelFrm"><span style = "color:red">* </span><?php echo @$aTextLang['tTCGCode'];?></label>
                <?php if(isset($tTCGCode) && empty($tTCGCode)):?>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <input type="checkbox" id="ocbTCGStaAutoGenCode" name="ocbTCGStaAutoGenCode" maxlength="1" checked="checked">
                        <span>&nbsp;</span>
                        <span class="xCNLabelFrm"><?php echo @$aTextLang['tGenerateAuto'];?></span>
                    </label>
                </div>
                <?php endif;?>
                <div class="form-group" style="cursor:not-allowed">
                    <input
                        type="text"
                        class="form-control xCNGenarateCodeTextInputValidate"
                        id="oetTCGCode"
                        name="oetTCGCode"
                        maxlength="5"
                        value="<?php echo @$tTCGCode;?>"
                        data-validate-required="<?php echo @$aTextLang['tTCGPlsEnterOrRunCode'];?>"
                        data-validate-duplicate="<?php echo @$aTextLang['tTCGPlsCodeDuplicate'];?>"
                        placeholder="<?php echo @$aTextLang['tTCGCodePaceholder'];?>"
                        style="pointer-events:none"
                        readonly
                    >
                </div>

                <?php 
                    if($tRoute == "pdtTouchGroupEventAdd"){
                        $tTCGAgnCode   = $tSesAgnCode;
                        $tTCGAgnName   = $tSesAgnName;
                        $tDisabled     = '';
                        $tNameElmIDAgn = 'oimBrowseAgn';
                    }else{
                        $tTCGAgnCode    = $tTCGAgnCode;
                        $tTCGAgnName    = $tTCGAgnName;
                        $tDisabled      = '';
                        $tNameElmIDAgn  = 'oimBrowseAgn';
                    }
                ?>

                <!-- Add Browser AD -->
                <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdttouchgroup/pdttouchgroup','tTCGAgency')?></label>
                    <div class="input-group"><input type="text" class="form-control xCNHide" id="oetTCGAgnCode" name="oetTCGAgnCode" maxlength="5" value="<?php echo @$tTCGAgnCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetTCGAgnName" name="oetTCGAgnName" maxlength ="100" 
                        placeholder="<?php echo language('product/pdttouchgroup/pdttouchgroup','tTCGAgency');?>" value="<?php echo @$tTCGAgnName;?>" readonly>
                        <span class="input-group-btn">
                            <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">* </span><?php echo @$aTextLang['tTCGName'];?></label>
                    <input
                        type="text"
                        class="form-control"
                        id="oetTCGName"
                        name="oetTCGName"
                        maxlength="100"
                        data-validate-required="<?php echo @$aTextLang['tTCGPlsEnterOrRunName'];?>"
                        value="<?php echo @$tTCGName;?>"
                        placeholder="<?php echo @$aTextLang['tTCGNamePaceholder'];?>"
                    >
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo @$aTextLang['tTCGRemark'];?></label>
                    <textarea class="form-control" id="otaTCGRemark" name="otaTCGRemark" rows="2" maxlength="100"><?php echo @$tTCGRmk;?></textarea>
                </div>
                <div class="form-group">
                    <label class="fancy-checkbox">
                        <?php
                            if(isset($tTCGStaUse) && $tTCGStaUse == 1){
                                $tChecked   = 'checked';
                            }else{
                                $tChecked   = '';
                            }
                        ?>
                        <input type="checkbox" id="ocbTCGStatusUse" name="ocbTCGStatusUse" <?php echo $tChecked;?>>
                        <span> <?php echo @$aTextLang['tTCGStatusUse'];?></span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $('input[name=orbChecked]').click(function() {
        var tCheckedColor = ($('input[name=orbChecked]:checked').val()) ? $('input[name=orbChecked]:checked').val() : 0;
        $('#ohdTCGCheckedColor').val(tCheckedColor);
    });
    // Event Control Date Default
    $('#ocbTCGStaAutoGenCode').on('change', function (e) {
        if($('#ocbTCGStaAutoGenCode').is(':checked')){
            $("#oetTCGCode").val('');
            $("#oetTCGCode").attr("readonly", true);
            $('#oetTCGCode').parents(".form-group").css("cursor","not-allowed");
            $('#oetTCGCode').css("pointer-events","none");
            $("#oetTCGCode").attr("onfocus", "this.blur()");
            $('#ofmPdtTouchGroupAddEditForm').removeClass('has-error');
            $('#ofmPdtTouchGroupAddEditForm .form-group').closest('.form-group').removeClass("has-error");
            $('#ofmPdtTouchGroupAddEditForm em').remove();
        }else{
            $('#oetTCGCode').parents(".form-group").css("cursor","");
            $('#oetTCGCode').css("pointer-events","");
            $('#oetTCGCode').attr('readonly',false);
            $("#oetTCGCode").removeAttr("onfocus");
        }
    });

    
    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetTCGAgnCode',
                'tReturnInputName'  : 'oetTCGAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;

     //Option Agn
     var oBrowseAgn =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;

        var oOptionReturn       = {
            Title : ['ticket/agency/agency', 'tAggTitle'],
            Table:{Master:'TCNMAgency', PK:'FTAgnCode'},
            Join :{
            Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode', 'tAggName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew : 'agency',
            BrowseLev : 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';

    if(tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP'){
        $('#oimBrowseAgn').attr("disabled", true);

    }
    
</script>