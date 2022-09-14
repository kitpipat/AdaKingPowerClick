<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtunitEventEdit";
        $tPunCode   = $aPunData['raItems']['rtPunCode'];
        $tPunName   = $aPunData['raItems']['rtPunName'];

        $tPunAgnCode    = $aPunData['raItems']['rtAgnCode'];
        $tPunAgnName    = $aPunData['raItems']['rtAgnName'];


    }else{
        $tRoute     = "pdtunitEventAdd";
        $tPunCode   = "";
        $tPunName   = "";

        $tPunAgnCode       = $tSesAgnCode;
        $tPunAgnName       = $tSesAgnName;
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtUnit">
    <button style="display:none" type="submit" id="obtSubmitPdtUnit" onclick="JSoAddEditPdtUnit('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtunitRoute" value="<?php echo $tRoute; ?>">
        <div class="panel-body" style="padding-top:20px !important;">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <input type="hidden" value="0" id="ohdCheckPunClearValidate" name="ohdCheckPunClearValidate"> 
                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?></label>
                    <?php
                    if($tRoute=="pdtunitEventAdd"){
                    ?>
                    <div class="form-group" id="odvPunAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbPunAutoGenCode" name="ocbPunAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="odvPunCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetPunCode" 
                            name="oetPunCode"
                            data-is-created="<?php echo $tPunCode; ?>"
                            placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?>"
                            value="<?php echo $tPunCode; ?>" 
                            data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPunVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtunit/pdtunit','tPunVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicatePunCode" name="ohdCheckDuplicatePunCode"> 
                    </div>
                    <?php
                    }else{
                    ?>
                    
                    <div class="form-group" id="odvPunCodeForm">
                        <input 
                            type="text" 
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                            maxlength="5" 
                            id="oetPunCode" 
                            name="oetPunCode"
                            data-is-created="<?php echo $tPunCode; ?>"
                            placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?>"
                            value="<?php echo $tPunCode; ?>" 
                            data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPunVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtunit/pdtunit','tPunVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicatePunCode" name="ohdCheckDuplicatePunCode"> 
                    </div>
                    <?php
                    }
                    ?>

                    <?php 
                        if($tRoute == "pdtunitEventAdd"){
                            $tPunAgnCode   = $tSesAgnCode;
                            $tPunAgnName   = $tSesAgnName;
                            $tDisabled     = '';
                            $tNameElmIDAgn = 'oimBrowseAgn';
                        }else{
                            $tPunAgnCode    = $tPunAgnCode;
                            $tPunAgnName    = $tPunAgnName;
                            $tDisabled      = '';
                            $tNameElmIDAgn  = 'oimBrowseAgn';
                        }
                    ?>

                    <!-- เพิ่ม AD Browser --> 
                    <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtunit/pdtunit','tPunAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPunAgnCode" name="oetPunAgnCode" maxlength="5" value="<?=$tPunAgnCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetPunAgnName" name="oetPunAgnName"
                            maxlength="100"  placeholder = "<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency');?>" value="<?=$tPunAgnName;?>"readonly>
                            <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtunit/pdtunit','tPUNFrmPunName')?></label>
                        <input type="text" class="form-control" maxlength="50" id="oetPunName" name="oetPunName" 
                        placeholder="<?php echo language('product/pdtunit/pdtunit','tPUNFrmPunName')?>"
                        autocomplete="off"
                        data-validate-required="<?php echo language('product/pdtunit/pdtunit','tPUNVldName')?>" value="<?php echo $tPunName ?>">
                    </div>
                </div>
            </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtUnit').click(function(){
        JStGeneratePdtUnitCode();
    });

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetPunAgnCode',
                'tReturnInputName'  : 'oetPunAgnName',
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

