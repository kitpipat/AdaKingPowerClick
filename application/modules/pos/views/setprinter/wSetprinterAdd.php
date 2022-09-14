<?php 
    if($aResult['rtCode'] == "1"){
        $tFTPrnCode         = $aResult['raItems']['FTPrnCode'];
        $tFTPrnSrcType      = $aResult['raItems']['FTPrnSrcType'];
        $tFTPrnName         = $aResult['raItems']['FTPrnName'];
        $tFTSppCode         = $aResult['raItems']['FTSppCode'];
        $tFTPrnDriver       = $aResult['raItems']['FTPrnDriver'];
        $tFTPrnType         = $aResult['raItems']['FTPrnType'];
        $tFTPrnRmk          = $aResult['raItems']['FTPrnRmk'];
        $tFTSppCode_Name    = $aResult['raItems']['FTSppName'];
        $tFTSppRef          = $aResult['raItems']['FTSppRef'];
        $tRoute             = "setprinterEventEdit";
    }else{
        $tFTPrnCode         = '';
        $tFTPrnSrcType      = '';
        $tFTPrnName         = '';
        $tFTSppCode         = '';
        $tFTPrnDriver       = '';
        $tFTPrnType         = '';
        $tFTPrnRmk          = '';
        $tFTSppCode_Name    = '';
        $tFTSppRef          = '';
        $tRoute             = "setprinterEventAdd";
    }
?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSetprinter">
    <button style="display:none" type="submit" id="obtSetprinter" onclick="JSnAddEditSetprinter('<?php echo $tRoute?>');"></button>
    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <div class="form-group">
                    <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('pos/setprinter/Setprinter','tSprCode')?></label>
                    <div id="odvSetprinterAutoGenCode" class="form-group">
                        <div class="validate-input">
                            <label class="fancy-checkbox">
                                <input type="checkbox" id="ocbSetprinerAutoGenCode" name="ocbSetprinerAutoGenCode" checked="true" value="1">
                                <span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                            </label>
                        </div>
                    </div>
                    <div id="odvSetprinterCodeForm" class="form-group">
                        <input type="hidden" id="ohdCheckDuplicateSptCode" name="ohdCheckDuplicateSptCode" value="1"> 
                        <div class="validate-input">
                            <input 
                                type="text" 
                                class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
                                maxlength="3" 
                                id="oetSprCode" 
                                name="oetSprCode"
                                data-is-created="<?php echo $tFTPrnCode;?>"
                                placeholder="<?php echo language('pos/setprinter/Setprinter','tSprCode');?>"
                                value="<?php echo $tFTPrnCode; ?>" 
                                data-validate-required = "<?php echo language('pos/setprinter/setprinter','tSprValidCode');?>"
                                data-validate-dublicateCode = "<?php echo language('pos/setprinter/setprinter','tSprValidCheckCode');?>"
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">
                <div class="form-group">
                    <div class="validate-input" data-validate="Please Insert Name">
                        <label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('pos/setprinter/Setprinter','tSprName')?></label>
                        <input type="text" class="form-control" maxlength="100"  id="oetSprName" name="oetSprName" value="<?php echo $tFTPrnName?>" 
                        data-validate-required ="<?php echo language('pos/setprinter/Setprinter','tSprValidName')?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('pos/setprinter/Setprinter','tSprSetprinterTypeSearch')?></label>
                    <select class="selectpicker form-control" id="ocmSelectSrcType" name="ocmSelectSrcType">
                        <option value="1" <?php echo ($tFTPrnSrcType == 1)? 'selected':''?> ><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterApplication')?></option>
                        <option value="2" <?php echo ($tFTPrnSrcType == 2)? 'selected':''?> ><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterPrinter')?></option>
                    </select>
                </div>
                <!--Application-->
                <div class="form-group" id="ocmFTPrnSrcTypeApplication">
                    <label class="xCNLabelFrm"><?php echo language('pos/setprinter/Setprinter','tSprSetprinterDriver')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetSetprinterRef" name="oetSetprinterRef" value="<?php echo $tFTSppCode?>" >
                        <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetSetprinterName" name="oetSetprinterName" value="<?php echo $tFTSppCode_Name?>" readonly data-validate="<?php echo language('pos/setprinter/Setprinter','tSprValidPrinterName')?>">
                        <span class="input-group-btn">
                            <button id="obtBrowseRefApplication" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
                <!--End Application-->
                <!--OS-->
                <div class="form-group" id="ocmFTPrnSrcTypeOS">
                    <label class="xCNLabelFrm"><?php echo language('pos/setprinter/Setprinter','tSprSetprinterDriver')?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetSetprinterRefOS" name="oetSetprinterRefOS" value="" >
                        <input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetSetprinterNameOS" name="oetSetprinterNameOS" value="" readonly>
                        <span class="input-group-btn">
                            <button id="obtBrowseRefOS" type="button" class="btn xCNBtnBrowseAddOn">
                                <img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                            </button>
                        </span>
                    </div>
                </div>
                <!--End OS-->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter')?></label>
                    <select class="form-control" id="ocmSelectTypePrinter" name="ocmSelectTypePrinter">
                        <option value="0" <?php echo ($tFTPrnType == 0)? 'selected':''?>><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterTypePrinter0')?></option>
                        <option value="1" <?php echo ($tFTPrnType == 1)? 'selected':''?>><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterTypePrinter1')?></option>
                        <option value="2" <?php echo ($tFTPrnType == 2)? 'selected':''?>><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterTypePrinter2')?></option>
                        <option value="3" <?php echo ($tFTPrnType == 3)? 'selected':''?>><?php echo language('pos/setprinter/Setprinter', 'tSprSetprinterTypePrinter3')?></option>
                    </select>
                </div>
                <div class="form-group">
                    <!-- <div class="validate-input">
                        <label class="xCNLabelFrm"><?php echo language('pos/setprinter/Setprinter','tSprNReason')?></label>
                        <input type="text" class="form-control xCNInputWithoutSpc" maxlength="100"  id="oetSprReason" name="oetSprReason" value="<?php echo $tFTPrnRmk?>">
                    </div> -->
                    <div class="form-group">
						<label class="xCNLabelFrm"><?= language('company/rack/rack','tRacRemark')?></label>
						<textarea class="form-control" rows="4"  maxlength="100" id="oetSprReason" name="oetSprReason"><?php echo $tFTPrnRmk?></textarea>
					</div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jSetprinterAdd.php";?>
<script type="text/javascript">
    $(function(){
        //รูปแบบการพิมพ์ + อ้างอิง
        $('.selectpicker').selectpicker();
        $('#ocmSelectTypePrinter').selectpicker();

        //เลือก 'อ้างอิง' (แอปพลิเคชั่น + ระบบ)
        $('#ocmFTPrnSrcTypeOS').css('display','none');
        $('#ocmSelectSrcType').change(function() {
            var tValue = $(this).val();
            if(tValue == 2){ //os มาจากระบบ

                //##################################### switch รูปแบบการพิมพ์
                $("#ocmSelectTypePrinter option").each(function() {
                    $(this).remove();
                });
                $('#ocmSelectTypePrinter').append('<option value="0"><?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter0')?></option>');
                $('#ocmSelectTypePrinter').append('<option value="1"><?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter1')?></option>');
                $('#ocmSelectTypePrinter').append('<option value="2"><?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter2')?></option>');
                $('#ocmSelectTypePrinter').append('<option value="3"><?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter3')?></option>');
                $("#ocmSelectTypePrinter").selectpicker("refresh");
                
                $('#obtBrowseRefOS').attr('disabled',true);
                //##################################### switch ชื่อไดร์เวอร์เครื่องพิมพ์
                $('#ocmFTPrnSrcTypeOS').css('display','block');
                $('#ocmFTPrnSrcTypeApplication').css('display','none');
            }else if(tValue == 1){ //application

                //##################################### switch รูปแบบการพิมพ์
                $("#ocmSelectTypePrinter option").each(function() {
                    $(this).remove();
                });
                $('#ocmSelectTypePrinter').append('<option value="x">-</option>');
                $("#ocmSelectTypePrinter").selectpicker("refresh");
                $('#oetSetprinterName').val('');
                $('#oetSetprinterRef').val('');

                //##################################### switch ชื่อไดร์เวอร์เครื่องพิมพ์
                $('#ocmFTPrnSrcTypeOS').css('display','none');
                $('#ocmFTPrnSrcTypeApplication').css('display','block');
            }
        });

        //Case ที่เข้ามาแล้วมีค่า
        var tFTPrnSrcType = '<?=$tFTPrnSrcType?>';
        if(tFTPrnSrcType == 2){ //มาจากระบบ
            $('#ocmFTPrnSrcTypeOS').css('display','block');
            $('#ocmFTPrnSrcTypeApplication').css('display','none');
            $('#obtBrowseRefOS').attr('disabled',true);
        }else if(tFTPrnSrcType == 1){
            var tFTSppRef   = '<?=$tFTSppRef?>';
            var tFTValue    = '<?=$tFTPrnType?>';
            var aCalBackVal = [tFTSppRef];
            var oJsonData   = JSON.stringify(aCalBackVal);
            JsxSetPrinterValueRef(oJsonData,'Pageedit',tFTValue);
        }
    });

    //Browse PortPrint
    var nLangEdits      = <?php echo $this->session->userdata("tLangEdit");?>;
    var oCmpBrowsePortPrint = {
        Title : ['pos/setprinter/Setprinter','tBrowsePrnTitle'],
        Table:{Master:'TSysPortPrn',PK:'FTSppCode'},
        Join :{
            Table:	['TSysPortPrn_L'],
            On:['TSysPortPrn_L.FTSppCode = TSysPortPrn.FTSppCode AND TSysPortPrn_L.FNLngID = '+nLangEdits,]
        },
        Where :{
            Condition : ["AND TSysPortPrn.FTSppType  = 'PRN' "]
        },
        GrideView:{
            ColumnPathLang	: 'pos/setprinter/Setprinter',
            ColumnKeyLang	: ['tBrowsePrnCode','tBrowsePrnName'],
            ColumnsSize     : ['10%','75%'],
            DataColumns		: ['TSysPortPrn.FTSppCode','TSysPortPrn_L.FTSppName','TSysPortPrn.FTSppRef'],
            DataColumnsFormat : ['','',''],
            DisabledColumns : [2],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TSysPortPrn.FTSppCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetSetprinterRef","TSysPortPrn.FTSppCode"],
            Text		: ["oetSetprinterName","TSysPortPrn_L.FTSppName"],
        },
        NextFunc:{
            FuncName    :'JsxSetPrinterValueRef',
            ArgReturn   :['FTSppRef']
        },
        BrowseLev : 1
    }
    $('#obtBrowseRefApplication').click(function(){JCNxBrowseData('oCmpBrowsePortPrint');});

    //Value
    function JsxSetPrinterValueRef(oParameter,ptType,pnValue){
        var aData       = JSON.parse(oParameter);
        var aData       = String(aData);
        var aResult     = aData.split(";");
        var nLenResult  = aResult.length;
        
        $("#ocmSelectTypePrinter option").each(function() {
            $(this).remove();
        });

        for($i=0; $i<nLenResult; $i++){
            switch(aResult[$i]) {
                case '0':
                    var tLangResult = "<?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter0')?>";
                    break;
                case '1':
                    var tLangResult = "<?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter1')?>";
                    break;
                case '2':
                    var tLangResult = "<?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter2')?>";
                    break;
                case '3':
                    var tLangResult = "<?=language('pos/setprinter/Setprinter','tSprSetprinterTypePrinter3')?>";
                    break;
                default:
                    var tLangResult = "<?=language('pos/setprinter/Setprinter','-')?>";
            }
            $('#ocmSelectTypePrinter').append('<option value="'+aResult[$i]+'">'+tLangResult+'</option>');
        }
        
        if(ptType == 'Pageedit'){
            $('#ocmSelectTypePrinter').val(pnValue);
        }

        $("#ocmSelectTypePrinter").selectpicker("refresh");
       
    }
</script>