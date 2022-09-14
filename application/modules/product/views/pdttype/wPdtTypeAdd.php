<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdttypeEventEdit";
        $tPtyCode   = $aPtyData['raItems']['rtPtyCode'];
        $tPtyName   = $aPtyData['raItems']['rtPtyName'];
        $tPtyRmk    = $aPtyData['raItems']['rtPtyRmk'];

        $tPTYAgnCode  = $aPtyData['raItems']['rtAgnCode'];
        $tPTYAgnName  = $aPtyData['raItems']['rtAgnName'];

    }else{
        $tRoute     = "pdttypeEventAdd";
        $tPtyCode   = "";
        $tPtyName   = "";
        $tPtyRmk    = "";

        $tPTYAgnCode       = $tSesAgnCode;
        $tPTYAgnName       = $tSesAgnName;
    }
?>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtType">
    <button style="display:none" type="submit" id="obtSubmitPdtType" onclick="JSoAddEditPdtType('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtTypeRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline"><!-- เพิ่มมาใหม่ -->
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->

                    <input type="hidden" value="0" id="ohdCheckPtyClearValidate" name="ohdCheckPtyClearValidate">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdttype/pdttype','tPTYFrmPtyCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                    <?php
                    if($tRoute=="pdttypeEventAdd"){
                    ?>
                    <div class="form-group" id="odvPunAutoGenCode">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbPtyAutoGenCode" name="ocbPtyAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group" id="odvPtyCodeForm">
                        <input
                            type="text"
                            class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
                            maxlength="5"
                            id="oetPtyCode"
                            name="oetPtyCode"
                            data-is-created="<?php  ?>"
                            placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPdttypeCode')?>"
                            value="<?php  ?>"
                            data-validate-required="<?= language('product/pdttype/pdttype','tPTYValidCode')?>"
                            data-validate-dublicateCode="<?= language('product/pdttype/pdttype','tPTYValidDublicateCode')?>"
                            readonly
                            onfocus="this.blur()">
                        <input type="hidden" value="2" id="ohdCheckDuplicatePtyCode" name="ohdCheckDuplicatePtyCode">
                    </div>
                    <?php
                    }else{
                    ?>
                    <div class="form-group" id="odvPtyCodeForm">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                            <input
                                type="text"
                                class="form-control xCNInputWithoutSpcNotThai"
                                maxlength="5"
                                id="oetPtyCode"
                                name="oetPtyCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtunit/pdtunit','tPUNFrmPunCode')?>"
                                value="<?php echo $tPtyCode; ?>"
                                readonly
                                onfocus="this.blur()">
                            </label>
                        </div>
                    </div>
                    <?php
                    }
                    ?>

                    <?php
                        if($tRoute == "pdttypeEventAdd"){
                            $tPTYAgnCode   = $tSesAgnCode;
                            $tPTYAgnName   = $tSesAgnName;
                            $tDisabled     = '';
                            $tNameElmIDAgn = 'oimBrowseAgn';
                        }else{
                            $tPTYAgnCode    = $tPTYAgnCode;
                            $tPTYAgnName    = $tPTYAgnName;
                            $tDisabled      = '';
                            $tNameElmIDAgn  = 'oimBrowseAgn';
                        }

                    ?>

                    <!-- เพิ่ม AD Browser -->
                    <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <label class="xCNLabelFrm"><?php echo language('product/pdttype/pdttype','tPTYAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPTYAgnCode" name="oetPTYAgnCode" maxlength="5" value="<?=@$tPTYAgnCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetPTYAgnName" name="oetPTYAgnName"
                            maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=@$tPTYAgnName;?>"readonly>
                            <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdttype/pdttype','tPTYFrmPtyName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetPtyName" name="oetPtyName" value="<?=$tPtyName?>"
                        data-validate-required="<?= language('product/pdttype/pdttype','tPTYValidName')?>"
                        placeholder="<?php echo language('product/pdttype/pdttype','tPTYFrmPtyName')?>"
                        autocomplete="off"
                        > <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdttype/pdttype','tPTYFrmPtyRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPtyRmk" name="otaPtyRmk"><?=$tPtyRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtType').click(function(){
        JStGeneratePdtTypeCode();
    });

     //BrowseAgn
     $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetPTYAgnCode',
                'tReturnInputName'  : 'oetPTYAgnName',
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