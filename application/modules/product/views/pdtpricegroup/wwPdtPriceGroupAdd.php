<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute     = "pdtpricegroupEventEdit";
        $tPplCode   = $aPplData['raItems']['rtPplCode'];
        $tPplName   = $aPplData['raItems']['rtPplName'];
        $tPplRmk    = $aPplData['raItems']['rtPplRmk'];

        $tPplAgnCode = $aPplData['raItems']['rtAgnCode'];
        $tPplAgnName = $aPplData['raItems']['rtAgnName'];

    }else{
        $tRoute     = "pdtpricegroupEventAdd";
        $tPplCode   = "";
        $tPplName   = "";
        $tPplRmk    = "";

        $tPplAgnCode   = $tSesAgnCode;
        $tPplAgnName   = $tSesAgnName;
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtPrice">
    <button style="display:none" type="submit" id="obtSubmitPdtPrice" onclick="JSoAddEditPdtPrice('<?= $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtPriceGroupRoute" value="<?php echo $tRoute; ?>">
        <div class="panel-body" style="padding-top:20px !important;"> <!-- เพิ่มมาใหม่ -->
            <div class="row">
                <div class="col-xs-12 col-md-5 col-lg-5"> <!-- เปลี่ยน Col Class -->
                    <div class="form-group">
                        <input type="hidden" value="0" id="ohdCheckPdtPriceGroupClearValidate" name="ohdCheckPdtPriceGroupClearValidate"> 
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <?php
                        if($tRoute=="pdtpricegroupEventAdd"){
                        ?>
                        <div class="form-group" id="odvPgpAutoGenCode">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" id="ocbPplAutoGenCode" name="ocbPplAutoGenCode" checked="true" value="1">
                                    <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="form-group" id="odvPunCodeForm">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai" 
                                maxlength="5" 
                                id="oetPplCode" 
                                name="oetPplCode"
                                data-is-created="<?php  ?>"
                                placeholder="<?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplCode')?>"
                                value="<?php  ?>" 
                                data-validate-required="<?= language('product/pdtpricelist/pdtpricelist','tPPLValidCode')?>"
                                data-validate-dublicateCode="<?= language('product/pdtpricelist/pdtpricelist','tPPLVldCodeDuplicate')?>"
                                readonly
                                onfocus="this.blur()">
                            <input type="hidden" value="2" id="ohdCheckDuplicatePplCode" name="ohdCheckDuplicatePplCode"> 
                        </div>
                        <?php
                        }else{
                        ?>
                        <div class="form-group" id="odvPunCodeForm">
                            <div class="validate-input">
                                <label class="fancy-checkbox">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai" 
                                    maxlength="5" 
                                    id="oetPplCode" 
                                    name="oetPplCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplCode')?>"
                                    value="<?php echo $tPplCode; ?>" 
                                    readonly
                                    onfocus="this.blur()">
                                </label>
                            </div>
                        <?php
                        }
                        ?>

                    </div>

                    <?php 
                        if($tRoute  == "pdtpricegroupEventAdd"){
                            $tPplAgnCode   = $tSesAgnCode;
                            $tPplAgnName   = $tSesAgnName;
                            $tDisabled     = '';
                            $tNameElmIDAgn = 'oimBrowseAgn';
                        }else{
                            $tPplAgnCode    = $tPplAgnCode;
                            $tPplAgnName    = $tPplAgnName;
                            $tDisabled      = '';
                            $tNameElmIDAgn  = 'oimBrowseAgn';
                        }
                    ?>

                    <!-- เพิ่ม AD Browser -->
                    <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                        <label class="xCNLabelFrm"><?php echo language('product/pdtpricelist/pdtpricelist','tPPLAgency')?></label>
                        <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPplAgnCode" name="oetPplAgnCode" maxlength="5" value="<?=@$tPplAgnCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetPplAgnName"  name="oetPplAgnName"
                                maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency');?>" value="<?=@$tPplAgnName;?>" readonly>
                            <span class="input-group-btn">
                            <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                            </span>
                            </span>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplName')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <input type="text" class="form-control" maxlength="50" id="oetPplName" name="oetPplName" value="<?=$tPplName?>" 
                        placeholder="<?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplName')?>"
                        autocomplete="off"
                        data-validate-required="<?= language('product/pdtpricelist/pdtpricelist','tPPLValidName')?>"> <!-- เปลี่ยนชื่อ Class เพิ่ม DataValidate -->
                    </div>
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?= language('product/pdtpricelist/pdtpricelist','tPPLFrmPplRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                        <textarea class="form-control" maxlength="100" rows="4" id="otaPplRmk" name="otaPplRmk"><?=$tPplRmk?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('#obtGenCodePdtPrice').click(function(){
        JStGeneratePdtPriceCode();
    });


    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode'  : 'oetPplAgnCode',
                'tReturnInputName'  : 'oetPplAgnName',
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