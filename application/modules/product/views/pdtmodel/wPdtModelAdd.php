<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtmodelEventEdit"; 
        $tPmoCode   = $aPmoData['raItems']['rtPmoCode'];
        $tPmoName   = $aPmoData['raItems']['rtPmoName'];
        $tPmoRmk    = $aPmoData['raItems']['rtPmoRmk'];

        $tPmoAgnCode  =  $aPmoData['raItems']['rtAgnCode'];
        $tPmoAgnName  = $aPmoData['raItems']['rtAgnName'];

    }else{
        $tRoute     = "pdtmodelEventAdd";
        $tPmoCode   = "";
        $tPmoName   = "";
        $tPmoRmk    = "";


        $tPmoAgnCode       = $tSesAgnCode;
        $tPmoAgnName       = $tSesAgnName;

    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPmo">
    <button style="display:none" type="submit" id="obtSubmitPdtPmo" onclick="JSoAddEditPdtPmo('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdPmoRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ --> 
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPmoClearValidate" name="ohdCheckPmoClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtmodelEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPmoAutoGenCode" name="ocbPmoAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="5" 
                                id="oetPmoCode" 
                                name="oetPmoCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?php echo language('product/pdtmodel/pdtmodel','tPMOValidCode')?>"
                                data-validate-dublicateCode="<?php echo language('product/pdtmodel/pdtmodel','tPMOValidDuplicateCode')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePmoCode" name="ohdCheckDuplicatePmoCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPunCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                    maxlength="5" 
                                    id="oetPmoCode" 
                                    name="oetPmoCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoCode')?>"
                                    value="<?php echo $tPmoCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                    <?php 
                        if($tRoute == "pdtmodelEventAdd"){
                            $tPmoAgnCode   = $tSesAgnCode;
                            $tPmoAgnName   = $tSesAgnName;
                            $tDisabled     = '';
                            $tNameElmIDAgn = 'oimBrowseAgn';
                        }else{
                            $tPmoAgnCode    = $tPmoAgnCode;
                            $tPmoAgnName    = $tPmoAgnName;
                            $tDisabled      = '';
                            $tNameElmIDAgn  = 'oimBrowseAgn';
                        }
                    ?>

                    
                    <!-- เพิ่ม AD Browser -->
                    <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtmodel/pdtmodel','tPmoAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPmoAgnCode" name="oetPmoAgnCode" maxlength="5" value="<?=@$tPmoAgnCode;?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetPmoAgnName" name="oetPmoAgnName"  
                            maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=@$tPmoAgnName;?>"
                            readonly>
                            <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled;?>">  
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" 
                        placeholder="<?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoName')?>"
                        autocomplete="off"
                        maxlength="50" id="oetPmoName" name="oetPmoName" value="<?=$tPmoName?>" 
                        data-validate-required="<?= language('product/pdtmodel/pdtmodel','tPMOValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtmodel/pdtmodel','tPMOFrmPmoRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPmoRmk" name="otaPmoRmk"><?=$tPmoRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPmo').click(function(){
        JStGeneratePdtPmoCode();
    });

    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetPmoAgnCode',
                'tReturnInputName'  : 'oetPmoAgnName',
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