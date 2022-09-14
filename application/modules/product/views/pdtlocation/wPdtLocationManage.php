<?php
    if(isset($nStaAddOrEdit) && $nStaAddOrEdit == 1){
        $tRoute         = "pdtlocationEventManageEdit"; 
        $tPlcCode       = $aLocData['raItems']['rtPlcCode'];
        $tPlcName       = $aLocData['raItems']['rtPlcName'];

        // $rtPldSeq       = $aLocSeqData['raItems']['rtPldSeq'];
        // $rtPdtCode      = $aLocSeqData['raItems']['rtPdtCode'];
        // $rtBarCode      = $aLocSeqData['raItems']['rtBarCode'];
        // $rtPdtName      = $aLocSeqData['raItems']['rtPdtName'];
        // $rtPunName      = $aLocSeqData['raItems']['rtPunName'];
        // $rtPlcName      = $aLocSeqData['raItems']['rtPlcName'];
    }else{
        $tRoute     = "pdtlocationEventManageEdit";
        $tPlcCode   = "";
        $tPlcName   = "";

        // $rtPldSeq   = "";
        // $rtPdtCode  = "";
        // $rtBarCode  = "";
        // $rtPdtName  = "";
        // $rtPunName  = "";
        // $rtPlcName  = "";
    }
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddLocSeq">
    <button style="display:none" type="button" id="obtSubmitPdtLoc" onclick="JSoAddEditLocSeq('<?= $tRoute?>')"></button>

        <div class="row">
            <div class="col-xs-4 col-md-4 col-lg-4">

                <div class="panel panel-default" style="margin-bottom: 25px;"> 
                    <div class="panel-heading xCNPanelHeadColor" id="odvHeadStatus" role="tab" style="padding-top: 10px; padding-bottom: 10px;">
                        <label class="xCNTextDetail1"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocList')?></label>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue">

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocCode')?></label>
                                <div class="input-group">
                                    <input id="oetPlcCode" name="oetPlcCode" class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" value="<?=$tPlcCode?>" placeholder="#####>" readonly>
                                    <!-- <input id="oetPlcCodeText" name="oetPlcCodeText" class="form-control xWPointerEventNone xWRptConsCrdInput" type="text" readonly value="<?=$tPlcCode?>" placeholder="#####>"> -->
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn" id="btnBrowseLococation" type="button">
                                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="xCNLabelFrm"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocName')?></label>
                                <input type="text" class="form-control" maxlength="50" id="oetPlcName" name="oetPlcName" value="<?=$tPlcName?>" readonly>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="panel panel-default" style="margin-bottom: 25px;"> 
                    <div class="panel-heading xCNPanelHeadColor" id="odvHeadStatus" role="tab" style="padding-top: 10px; padding-bottom: 10px;">
                        <label class="xCNTextDetail1"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocList')?></label>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue">
                        <fieldset>
                            <div class="form-group">
                                <label class="fancy-radio xCNRadioMain"><input name="ocbLocImport" class="xWCmdConsImport" type="radio" checked="checked" value="1" onclick="JSxLocChangeOptions(1)"><span><i></i><?= language('product/product/product','tPDTGroup')?></span></label>
                                <div class="input-group">
                                    <input name="oetPgpCode" class="form-control xCNHide" id="oetPgpCode" maxlength="5" value="">
                                    <input name="oetPgpName" class="form-control xWPointerEventNone xWRptConsCrdInput" id="oetPgpName" type="text" readonly="" value="" placeholder="<?= language('product/pdtlocation/pdtlocation','tPDTOtrPTypGeneral')?>">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn" id="btnBrowseProductGroup" type="button">
                                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="fancy-radio xCNRadioMain"><input name="ocbLocImport" class="xWCmdConsImport" type="radio" value="2" onclick="JSxLocChangeOptions(2)"><span><i></i><?= language('product/product/product','tPDTType')?></span></label>
                                <div class="input-group">
                                    <input name="oetPtyCode" class="form-control xCNHide" id="oetPtyCode" maxlength="5" value="">
                                    <input name="oetPtyName" class="form-control xWPointerEventNone xWRptConsCrdInput" id="oetPtyName" type="text" readonly="" value="" placeholder="<?= language('product/pdtlocation/pdtlocation','tPDTOtrPTypGeneral')?>">
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn" id="btnBrowseProductType" type="button">
                                            <img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                            <button class="btn btn-primary" id="obtImportTable" style="width: 100%; font-size: 17px;" onclick="JSxLocImportTable()" type="button"><?= language('product/pdtlocation/pdtlocation','tLOCBtnImport')?></button>
                
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-xs-8 col-md-8 col-lg-8">
                <div class="panel panel-default" style="margin-bottom: 25px;"> 
                    <div class="panel-heading xCNPanelHeadColor" id="odvHeadStatus" role="tab" style="padding-top: 10px; padding-bottom: 10px;">
                        <label class="xCNTextDetail1"><?= language('product/pdtlocation/pdtlocation','tLOCFrmLocDataPdt')?></label>
                    </div>
                    <div class="panel-collapse collapse in" role="tabpanel">
                        <div class="panel-body xCNPDModlue" style="margin-bottom:-15px;">

                            <div class="row">
                                <div class="col-xs-8 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?php echo language('product/pdtlocation/pdtlocation','tLOCSearch')?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="oetSearchPdtLocSeq" name="oetSearchPdtLocSeq" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
                                            <span class="input-group-btn">
                                                <button id="oimSearchPdtLocSeq" class="btn xCNBtnSearch" type="button">
                                                    <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
                                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                            <?php echo language('common/main/main','tCMNOption')?>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li id="oliBtnDeleteAll">
                                                <a data-toggle="modal" data-target="#odvModalDelPdtLocSeq"><?php echo language('common/main/main','tDelAll')?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div id="odvContentManageDataList" class="panel-body xCNPDModlue">
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
        
    
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
	$(document).ready(function() {
        $('#btnBrowseLococation').click(function(){ JCNxBrowseData('oCmpBrowseLocation'); });
        $('#btnBrowseProductGroup').click(function(){ JCNxBrowseData('oCmpBrowseProductGroup'); });
        $('#btnBrowseProductType').click(function(){ JCNxBrowseData('oCmpBrowseProductType'); });
    });

    $('#oimSearchPdtLocSeq').click(function(){
		JCNxOpenLoading();
		JSvPdtLocSeqDataTable();
	});
	$('#oetSearchPdtLocSeq').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvPdtLocSeqDataTable();
		}
	});

    //Browse Location
    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit");?>;
    var oCmpBrowseLocation = {
        Title : ['product/pdtlocation/pdtlocation','tLOCTitle'],
        Table:{Master:'TCNMPdtLoc',PK:'FTPlcCode'},
        Join :{
            Table:	['TCNMPdtLoc_L'],
            On:['TCNMPdtLoc_L.FTPlcCode = TCNMPdtLoc.FTPlcCode AND TCNMPdtLoc_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'product/pdtlocation/pdtlocation',
            ColumnKeyLang	: ['tLOCCode','tLOCName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMPdtLoc.FTPlcCode','TCNMPdtLoc_L.FTPlcName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPdtLoc.FTPlcCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetPlcCode","TCNMPdtLoc.FTPlcCode"],
            Text		: ["oetPlcName","TCNMPdtLoc_L.FTPlcName"],
        },
        NextFunc:{
            FuncName    :'JSvCallPageManage',
            ArgReturn   :['FTPlcCode']
        }
    }
    //Browse Product Group
    var oCmpBrowseProductGroup = {
        Title : ['product/pdtlocation/pdtlocation','tLOCTitle'],
        Table:{Master:'TCNMPdtGrp',PK:'FTPgpCode'},
        Join :{
            Table:	['TCNMPdtGrp_L'],
            On:['TCNMPdtGrp_L.FTPgpChain = TCNMPdtGrp.FTPgpCode AND TCNMPdtGrp_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'product/pdtlocation/pdtlocation',
            ColumnKeyLang	: ['tLOCCode','tLOCName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMPdtGrp.FTPgpCode','TCNMPdtGrp_L.FTPgpName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPdtGrp.FTPgpCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetPgpCode","TCNMPdtGrp.FTPgpCode"],
            Text		: ["oetPgpName","TCNMPdtGrp_L.FTPgpName"],
        }
    }
    //Browse Product Type
    var oCmpBrowseProductType = {
        Title : ['product/pdtlocation/pdtlocation','tLOCTitle'],
        Table:{Master:'TCNMPdtType',PK:'FTPtyCode'},
        Join :{
            Table:	['TCNMPdtType_L'],
            On:['TCNMPdtType_L.FTPtyCode = TCNMPdtType.FTPtyCode AND TCNMPdtType_L.FNLngID = '+nLangEdits,]
        },
        GrideView:{
            ColumnPathLang	: 'product/pdtlocation/pdtlocation',
            ColumnKeyLang	: ['tLOCCode','tLOCName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TCNMPdtType.FTPtyCode','TCNMPdtType_L.FTPtyName'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMPdtType.FTPtyCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value       : ["oetPtyCode","TCNMPdtType.FTPtyCode"],
            Text		: ["oetPtyName","TCNMPdtType_L.FTPtyName"],
        }
    }
    
    
    // ,NextFunc:{
    //     FuncName    :'JsxSetFieldFTPhwCustom',
    //     ArgReturn   :['FTPrnType']
    // }
</script>