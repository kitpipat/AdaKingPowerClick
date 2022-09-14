<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "pdtgroupEventEdit";
        $tPgpCode       = $aPgpData['raItems']['rtPgpCode'];
        $tPgpLevel      = $aPgpData['raItems']['rtPgpLevel'];
        $tPgpName       = $aPgpData['raItems']['rtPgpName'];
        $tPgpRmk        = $aPgpData['raItems']['rtPgpRmk'];
        $tPgpChain      = $aPgpData['raItems']['rtPgpChain'];
        $tPgpParentCode = $aPgpData['raItems']['rtPgpParentCode'];
        $tPgpParentName = $aPgpData['raItems']['rtPgpParentName'];


        $tPgpAgnCode   = $aPgpData['raItems']['rtAgnCode'];
        $tPgpAgnName   = $aPgpData['raItems']['rtAgnName'];


    }else{
        $tRoute         = "pdtgroupEventAdd";
        $tPgpCode       = "";
        $tPgpLevel      = "";
        $tPgpName       = "";
        $tPgpRmk        = "";
        $tPgpChain      = "";
        $tPgpParentCode = "";
        $tPgpParentName = "";

        $tPgpAgnCode   = $tSesAgnCode;
        $tPgpAgnName   = $tSesAgnName;

    }
?>
<!-- Product Group Input Hide -->
    <input type="text" class="xCNHide" id="ohdPdtGrpParent" value="">
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddPdtGroup">
    <button style="display:none" type="submit" id="obtSubmitPdtGroup" onclick="JSoAddEditPdtGroup('<?php echo $tRoute?>')"></button>
    <input type="hidden" id="ohdPdtGroupRoute" value="<?php echo $tRoute; ?>">
    <div class="panel panel-headline">
        <div class="panel-body" style="padding-top:20px !important;"> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"> 
                    <?php echo FCNtHGetContentUploadImage(@$tImgObjAll,'PdtGrpParent');?>
                </div>   
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8"> 
                    <div class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                    <input id="ocbPdtGrpSelectRoot" class="ocbSelectRoot xWSelectRoot"  name="ocbPdtGrpSelectRoot" type="checkbox">
                                    <span class="xCNLabelFrm"><?= language('product/pdtgroup/pdtgroup','tPGPFrmSelectRoot')?></span>
                                </label>
                            </div>
                        </div>
                        <div id="odvObjPgpChain" class="form-group">
                            <div class="form-group" data-validate="<?= language('product/pdtgroup/pdtgroup','tPGPValidPgpParent')?>">
                                <label class="xCNLabelFrm"><span style="color:red">*</span><?= language('product/pdtgroup/pdtgroup','tPGPFrmParentGrp')?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide" id="oetPgpLevelOld" name="oetPgpLevelOld" value="<?=$tPgpLevel?>">
                                    <input type="text" class="form-control xCNHide" id="oetPgpChain" name="oetPgpChain" value="<?=$tPgpParentCode?>">
                                    <input type="text" class="form-control xCNHide" id="oetPgpChainOld" name="oetPgpChainOld" value="<?=$tPgpChain?>">
                                    <input type="text" class="form-control input100 xWPointerEventNone" id="oetPgpChainName" name="oetPgpChainName" maxlength="100" value="<?=$tPgpParentName?>" readonly>
                                    <span class="focus-input100"></span>
                                    <span class="input-group-btn">
                                        <button id="oimBrowsePgpParent" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="0" id="ohdCheckPdtGroupClearValidate" name="ohdCheckPdtGroupClearValidate"> 
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?></label> <!-- เปลี่ยนชื่อ Class -->
                            <?php
                            if($tRoute=="pdtgroupEventAdd"){
                            ?>
                            <div class="form-group" id="odvPgpAutoGenCode">
                                <div class="validate-input">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" id="ocbPgpAutoGenCode" name="ocbPgpAutoGenCode" checked="true" value="1">
                                        <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group" id="odvPunCodeForm">
                                <input 
                                    type="text" 
                                    class="form-control xCNInputWithoutSpcNotThai xCNInputNumericWithoutDecimal" 
                                    maxlength="5" 
                                    id="oetPgpCode" 
                                    name="oetPgpCode"
                                    data-is-created="<?php  ?>"
                                    placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?>"
                                    value="<?php  ?>" 
                                    data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPGPValidPgpCode')?>"
                                    data-validate-dublicateCode="<?php echo language('product/pdtgroup/pdtgroup','tPGPVldCodeDuplicate')?>"
                                    readonly
                                    onfocus="this.blur()">
                                <input type="hidden" value="2" id="ohdCheckDuplicatePgpCode" name="ohdCheckDuplicatePgpCode"> 
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
                                        id="oetPgpCode" 
                                        name="oetPgpCode"
                                        data-is-created="<?php  ?>"
                                        placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpCode')?>"
                                        value="<?php echo $tPgpCode; ?>" 
                                        readonly
                                        onfocus="this.blur()">
                                    </label>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php   
                            if($tRoute ==  "pdtgroupEventAdd"){
                                $tPgpAgnCode   = $tSesAgnCode;
                                $tPgpAgnName   = $tSesAgnName;
                                $tDisabled     = '';
                                $tNameElmIDAgn = 'oimBrowseAgn';
                            }else{
                                $tPgpAgnCode    = $tPgpAgnCode;
                                $tPgpAgnName    = $tPgpAgnName;
                                $tDisabled      = '';
                                $tNameElmIDAgn  = 'oimBrowseAgn';
                            }
                        ?>


                        <!-- เพิ่ม AD Browser -->
                        <div class="form-group  <?php if( !FCNbGetIsAgnEnabled()) : echo 'xCNHide';  endif;?>">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup','tPGPAgency')?></label>
                            <div class="input-group"><input type="text" class="form-control xCNHide" id="oetPgpAgnCode" name="oetPgpAgnCode" maxlength="5" value="<?=@$tPgpAgnCode;?>">
                            <input type="text" class="form-control xWPointerEventNone" id="oetPgpAgnName" name="oetPgpAgnName"
                                maxlength="100" placeholder="<?php echo language('interface/connectionsetting/connectionsetting','tTBAgency')?>" value="<?=@$tPgpAgnName;?>" readonly>
                                <span class="input-group-btn">
                                <button id="<?=@$tNameElmIDAgn;?>" type="button" class="btn xCNBtnBrowseAddOn <?=@$tDisabled?>">
                                    <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                </button>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpName')?></label>
                            <input type="text" class="form-control" maxlength="50" id="oetPgpName" name="oetPgpName" 
                            placeholder="<?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpName')?>"
                            data-validate-required="<?php echo language('product/pdtgroup/pdtgroup','tPGPValidPgpName')?>" value="<?php echo $tPgpName ?>">
                        </div>

                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('product/pdtgroup/pdtgroup','tPGPFrmPgpRmk')?></label> <!-- เปลี่ยนชื่อ Class -->
                            <textarea class="form-control" maxlength="100" rows="4" id="otaPgpRmk" name="otaPgpRmk"
                            ><?=$tPgpRmk?></textarea>
                        </div>
                    </div>
                
                </div>   
        </div>
    </div>
</form>


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        <?php
        if($tRoute=="pdtgroupEventAdd"){
        ?>
            $('#ocbPdtGrpSelectRoot').prop("checked",true);
            $('#odvObjPgpChain').hide();
        <?php
        }else{
            if($tPgpParentName==""){
        ?>
            $('#ocbPdtGrpSelectRoot').prop("checked",true);
            $('#odvObjPgpChain').hide();
        <?php
            }
        }
        ?>
    });

    //Set Lang Edit 
    var nLangEdits  = "<?=$this->session->userdata("tLangEdit")?>";
    var tUsrLevel   = "<?=$this->session->userdata("tSesUsrLevel");?>";
    var tWhereModal = "";
    if(tUsrLevel != "HQ"){
        tAgnCode        =  "<?=$this->session->userdata("tSesUsrAgnCode")?>";
        tWhereModal 	+= " AND TCNMPdtGrp.FTAgnCode IN ("+tAgnCode+") ";
    }

    
    //Option Browse PgpChain
    var oBrowsePgpParent    = {
        Title: ['product/pdtgroup/pdtgroup','tPGPTitle'],
        Table: {Master:'TCNMPdtGrp',PK:'FTPgpCode'},
        Join :{
            Table: ['TCNMPdtGrp_L'],
            On:['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits,]
        },
        Where : {
            Condition : [tWhereModal]
        },
        GrideView: {
            ColumnPathLang	    : 'product/pdtgroup/pdtgroup',
            ColumnKeyLang	    : ['tPGPCode','tPGPChainCode','tPGPName','tPGPChain'],
            ColumnsSize         : ['10%','15%','30%','35%'],
            WidthModal          : 50,
            DataColumns		    : ['TCNMPdtGrp.FTPgpCode','TCNMPdtGrp.FTPgpChain','TCNMPdtGrp_L.FTPgpName','TCNMPdtGrp_L.FTPgpChainName'],
            DataColumnsFormat   : ['','','',''],
            Perpage			    : 5,
            OrderBy             : ['TCNMPdtGrp.FTPgpCode'],
            SourceOrder         : "DESC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetPgpChain","TCNMPdtGrp.FTPgpCode"],
            Text		: ["oetPgpChainName","TCNMPdtGrp_L.FTPgpChainName"],
        },
        NextFunc:{
            FuncName    : 'JSxCheckMaxLenPgpParent',
            ArgReturn   : ['FTPgpChain']
        },
        BrowseLev : '1'
    };

    //Set Event Browse
    $('#oimBrowsePgpParent').click(function(){JCNxBrowseData('oBrowsePgpParent');});

    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    function JSxCheckMaxLenPgpParent(ptDataNextFunc){
        if(typeof(ptDataNextFunc) != undefined && ptDataNextFunc != "NULL"){
            var aDataNextFunc   = JSON.parse(ptDataNextFunc);
            var nPgpCode        = aDataNextFunc[0].length;
            if(nPgpCode >= 30){
                alert('<?php echo language('product/pdtgroup/pdtgroup','tPgpCodeMaxLen')?>');
                $('#oetPgpChain').val('');
                $('#oetPgpChainName').val('');
            }
        }
    }

    $('#ocbPdtGrpSelectRoot').click(function(){
        if($(this).is(':checked')){
            $('#oetPgpChain').val('');
            // $('#oetPgpChainName').val('');
            $('#odvObjPgpChain').fadeOut(500,function(){$(this).hide()});
        }else{
            $('#odvObjPgpChain').fadeIn(800,function(){$(this).show()});
        }
    });

    $('#oetPgpParent').on('change', function() {
        $('#ocbPdtGrpSelectRoot').prop('checked',false);
    });


    //BrowseAgn 
    $('#oimBrowseAgn').click(function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose();
            window.oPdtBrowseAgencyOption = oBrowseAgn({
                'tReturnInputCode' : 'oetPgpAgnCode',
                'tReturnInputName' : 'oetPgpAgnName',
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