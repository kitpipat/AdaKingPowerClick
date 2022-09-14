<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "masPdtCatEventEdit";
        $tCatCode   = $aCatData['raItems']['rtCatCode'];
        $tCatName   = $aCatData['raItems']['rtCatName'];

        $tCatAgnCode    = $aCatData['raItems']['rtAgnCode'];
        $tCatAgnName    = $aCatData['raItems']['rtAgnName'];
        $tCatRmk    = $aCatData['raItems']['rtCatRmk'];
        $tCatLevel    = $aCatData['raItems']['rtCatLevel'];
        $tCatParent    = $aCatData['raItems']['rtCatParent'];
        $tCatStaUse    = $aCatData['raItems']['rtCatStaUse'];
        if (isset($aCatDataPar['raItems']['rtCatCode'])) {
          $rtCatCode =  $aCatDataPar['raItems']['rtCatCode'];
          $rtCatName =  $aCatDataPar['raItems']['rtCatName'];
        }else {
          $rtCatCode =  "";
          $rtCatName =  "";
        }

        if ($tCatStaUse=='1') {
          $tStatusUse = "checked='true'";
        }else {
          $tStatusUse = "";
        }
        if ($tCatLevel=='1') {
          $tCatLevel = "0";
        }
    }else{
        $tRoute     = "masPdtCatEventAdd";
        $tCatCode   = "";
        $tCatName   = "";
        $rtCatCode = "";
        $rtCatName = "";
        $tCatRmk= "";
        $tStatusUse = "checked='true'";
        $tCatAgnCode       = $tSesAgnCode;
        $tCatAgnName       = $tSesAgnName;
        if ($tCatCat =='0') {
          $tCatLevel = "0";
        }else {
          $tCatLevel = $tCatCat;
        }
    }

?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtCat">
    <button style="display:none" type="submit" id="obtSubmitPdtCat" onclick="JSoAddEditPdtCat('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtunitRoute" value="<?php echo $tRoute; ?>">
    <input type="hidden" id="oetCatCatHide" name="oetCatCatHide" >
        <div class="panel-body" style="padding-top:20px !important;">
                <div class="col-xs-12 col-md-5 col-lg-5">
                    <input type="hidden" value="0" id="ohdCheckCatClearValidate" name="ohdCheckCatClearValidate">
                    <label class="xCNLabelFrm"><span style = "color:red">*</span><?= language('product/pdtcat/pdtcat','tCATSFrmCatCode')?></label>
                    <?php
                    if($tRoute=="masPdtCatEventAdd"){
                    ?>
                    <div class="form-group" id="odvCatAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCatAutoGenCode" name="ocbCatAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="odvCatCodeForm">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                            maxlength="5"
                            id="oetCatCode"
                            name="oetCatCode"
                            data-is-created="<?php echo $tCatCode; ?>"
                            placeholder="<?= language('product/pdtcat/pdtcat','tCATSFrmCatCode')?>"
                            value="<?php echo $tCatCode; ?>"
                            data-validate-required="<?php echo language('product/pdtcat/pdtcat','tCatVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtcat/pdtcat','tCatVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicateCatCode" name="ohdCheckDuplicateCatCode">
                    </div>
                    <?php
                    }else{
                    ?>

                    <div class="form-group" id="odvCatCodeForm">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                            maxlength="5"
                            id="oetCatCode"
                            name="oetCatCode"
                            data-is-created="<?php echo $tCatCode; ?>"
                            placeholder="<?= language('product/pdtcat/pdtcat','tCATFrmCatCode')?>"
                            value="<?php echo $tCatCode; ?>"
                            data-validate-required="<?php echo language('product/pdtcat/pdtcat','tCatVldCode')?>"
                            data-validate-dublicateCode="<?php echo language('product/pdtcat/pdtcat','tCatVldCodeDuplicate')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicateCatCode" name="ohdCheckDuplicateCatCode">
                    </div>
                    <?php
                    }
                    if ($tCatLevel=='0') { ?>
                      <div class="form-group" hidden>
                          <label class="xCNLabelFrm"><?php echo language('product/pdtcat/pdtcat','tParentName')?></label>
                          <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCatParentCode" name="oetCatParentCode" maxlength="5" value="0">
                          <input type="text" class="form-control xWPointerEventNone" id="oetCatParentName" name="oetCatParentName"
                              data-validate-required="<?php echo language('product/pdtcat/pdtcat','tAltParentName')?>"
                              maxlength="100"  placeholder = "<?php echo language('product/pdtcat/pdtcat','tParentName')?>" value="0" readonly>
                              <span class="input-group-btn">
                                  <button id="oimBrowseParent" type="button" class="btn xCNBtnBrowseAddOn">
                                      <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                  </button>
                              </span>
                          </div>
                      </div>
                    <?php }else { ?>
                      <div class="form-group">
                          <label class="xCNLabelFrm"><?php echo language('product/pdtcat/pdtcat','tParentName')?></label>
                          <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCatParentCode" name="oetCatParentCode" maxlength="5" value="<?php echo $rtCatCode; ?>">
                          <input type="text" class="form-control xWPointerEventNone" id="oetCatParentName" name="oetCatParentName"
                              data-validate-required="<?php echo language('product/pdtcat/pdtcat','tAltParentName')?>"
                              maxlength="100"  placeholder = "<?php echo language('product/pdtcat/pdtcat','tParentName')?>" value="<?php echo $rtCatName; ?>"readonly>
                              <span class="input-group-btn">
                                  <button id="oimBrowseParent" type="button" class="btn xCNBtnBrowseAddOn">
                                      <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                  </button>
                              </span>
                          </div>
                      </div>
                    <?php } ?>

                    <?php
                        if($tRoute == "masPdtCatEventAdd"){
                            $tCatAgnCode   = $tSesAgnCode;
                            $tCatAgnName   = $tSesAgnName;
                            $tDisabled     = '';
                            $tNameElmIDAgn = 'oimBrowseAgn';
                        }else{
                            $tCatAgnCode    = $tCatAgnCode;
                            $tCatAgnName    = $tCatAgnName;
                            $tDisabled      = '';
                            $tNameElmIDAgn  = 'oimBrowseAgn';
                        }
                    ?>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtcat/pdtcat','tCATSFrmCatName')?></label>
                        <input type="text" class="form-control" maxlength="50" id="oetCatName" name="oetCatName"
                        placeholder="<?php echo language('product/pdtcat/pdtcat','tCATSFrmCatName')?>"
                        autocomplete="off"
                        data-validate-required="<?php echo language('product/pdtcat/pdtcat','tCATVldName')?>" value="<?php echo $tCatName ?>">
                    </div>
                    <!-- เพิ่ม AD Browser -->
                    <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtcat/pdtcat','tCatAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetCatAgnCode" name="oetCatAgnCode" maxlength="5" value="<?=$tCatAgnCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCatAgnName" name="oetCatAgnName"
                            maxlength="100"  placeholder = "<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency');?>" value="<?=$tCatAgnName;?>"readonly>
                            <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="xCNLabelFrm"><?php echo language('product/pdtcat/pdtcat','tCATSFrmCatRmk')?></label>
                      <textarea class="form-control" maxlength="100" rows="4" id="otaCatRmk" name="otaCatRmk"><?php echo $tCatRmk; ?></textarea>
                    </div>
                    <div class="form-group" id="odvCatStaUse">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbCatStaUse" name="ocbCatStaUse" <?php echo $tStatusUse; ?>  value="1">
                                <span> <?php echo language('product/pdtcat/pdtcat','tCATSStaUse')?></span>
                            </label>
                        </div>
                    </div>

                </div>
            </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtCat').click(function(){
        JStGeneratePdtCatCode();
    });
    var tCatStaBrowse  = $("#oetCatCat").val();
    $("#oetCatCatHide").val(tCatStaBrowse);
    $('#oimBrowseParent').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        var tCatStaBrowse  = $("#oetCatCat").val();
        $("#oetCatCatHide").val(tCatStaBrowse);
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseParentOption = oBrowseParent({
                'tReturnInputCode'  : 'oetCatParentCode',
                'tReturnInputName'  : 'oetCatParentName',
                'tCatStaBrowse'  : tCatStaBrowse,
            });
            JCNxBrowseData('oPdtBrowseParentOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    //BrowseAgn
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetCatAgnCode',
                'tReturnInputName'  : 'oetCatAgnName',
            });
            JCNxBrowseData('oPdtBrowseAgencyOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit")?>;
    var tAgnCode  = '<?php echo $tCatAgnCode?>';

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

    // FTAgnCode
    // FTCatCode
    // FNCatLevel
    // FTCatName
    var oBrowseParent =   function(poReturnInput){
        var tInputReturnCode    = poReturnInput.tReturnInputCode;
        var tInputReturnName    = poReturnInput.tReturnInputName;
        var tCatStaBrowse    = poReturnInput.tCatStaBrowse;
        if (tAgnCode=="") {
          var tCondition ="1=1";
        }else {
          var tCondition ="TCNMPdtCatInfo.FTAgnCode = '"+tAgnCode+"'";
        }
        var oOptionReturn       = {
            Title : ['product/pdtcat/pdtcat', 'tCATTitle'],
            Table:{Master:'TCNMPdtCatInfo', PK:'FTCatCode'},
            Join :{
            Table: ['TCNMPdtCatInfo_L'],
                On: ['TCNMPdtCatInfo_L.FTCatCode = TCNMPdtCatInfo.FTCatCode AND TCNMPdtCatInfo_L.FNCatLevel = '+tCatStaBrowse+' AND TCNMPdtCatInfo_L.FNLngID = '+nLangEdits]
            },
            Where   : {
                Condition : [" AND ("+tCondition+") AND TCNMPdtCatInfo.FNCatLevel = "+tCatStaBrowse+" "]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtcat/pdtcat',
                ColumnKeyLang	: ['tCatCode', 'tCatName'],
                ColumnsSize     : ['15%', '85%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtCatInfo.FTCatCode', 'TCNMPdtCatInfo_L.FTCatName'],
                DataColumnsFormat : ['', ''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtCatInfo.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMPdtCatInfo.FTCatCode"],
                Text		: [tInputReturnName,"TCNMPdtCatInfo_L.FTCatName"],
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
