<style>
    .xCNLabelFrm {
        color   : #ffffff !important;
    }
</style>

<input id="oetTaxStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetTaxCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvCrdMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliTaxTitle" class="xCNLinkClick" onclick="xxxxx()" style="cursor:pointer"><?=language('sale/Taxinvoice/Taxinvoice','tARTAXSelectABBVD')?></li>
                    <li id="oliTaxTitleAdd" class="active"><a><?=language('sale/Taxinvoice/Taxinvoice','tTaxTitleAdd')?></a></li>
                    <li id="oliTaxTitleEdit" class="active"><a><?=language('sale/Taxinvoice/Taxinvoice','tTaxTitleEdit')?></a></li>
                </ol>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                <div id="odvBtnTaxInfo">
                    <?php if($aAlwEventTaxinvoiceABB['tAutStaFull'] == 1 || $aAlwEventTaxinvoiceABB['tAutStaAdd'] == 1) : ?>
                    <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardAdd()">+</button>
                    <?php endif; ?>
                </div>
                <div id="odvBtnAddEdit">
                    <button onclick="xxxxx()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?=language('common/main/main', 'tBack')?></button>
                    <?php if($aAlwEventTaxinvoiceABB['tAutStaFull'] == 1 || ($aAlwEventTaxinvoiceABB['tAutStaAdd'] == 1 || $aAlwEventTaxinvoiceABB['tAutStaEdit'] == 1)) : ?>
                    <div class="btn-group">
                        <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCard').click()"><?=language('common/main/main', 'tSave')?></button>
                        <?php echo $vBtnSave?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCrdBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>

    <div class="main-content">
        <div id="odvContentTaxinvoiceABB"></div>
    </div>
</div>

<!--เลือกประเภทใบกำกับภาษี-->
<div class="modal fade" id="odvModalTaxinvoiceABB">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><label class="xCNLabelFrm"><?=language('sale/Taxinvoice/Taxinvoice', 'tARTAXSelectABB'); ?></label></h5>
			</div>
			<div class="modal-body">
                <input type="hidden" id="ohdTypeABB" name="ohdTypeABB" value="ABBVD">
                <div class="radio">
                    <label><input type="radio" name="orbTypeABB" checked value="ABBVD"><?=language('sale/Taxinvoice/Taxinvoice', 'tARTAXSelectABBVD'); ?></label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="orbTypeABB" value="ABBPOS"><?=language('sale/Taxinvoice/Taxinvoice', 'tARTAXSelectABBPOS'); ?></label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="orbTypeABB" value="ABBSL"><?=language('sale/Taxinvoice/Taxinvoice', 'tARTAXSelectABBSL'); ?></label>
                </div>
			</div>
            <div class="modal-footer">
                <button id="obtTaxinvoiceABBConfirmSelectType" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm'); ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel'); ?></button>
            </div>
		</div>
	</div>
</div>
<!--จบเลือกประเภทใบกำกับภาษี-->


<script>

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxControlBTNBar();
    });

    function JSxControlBTNBar(){
        $('#oliTaxTitleAdd').hide();
        $('#oliTaxTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
    }

    //STEP 1 โชว์ให้เลือกประเภทของใบกำกับภาษี
    $('#odvModalTaxinvoiceABB').modal('show');

    //STEP 2 กดยืนยันเลือกประเภทใบกำกับภาษี
    $('#obtTaxinvoiceABBConfirmSelectType').click(function() {
        var tTypeABB = $('input[name=orbTypeABB]:checked').val();
        $('#odvModalTaxinvoiceABB').modal('hide');
        FSvTAXListdata(tTypeABB);
    });

    //STEP 3 เข้าหน้าแสดงข้อมูล
    function FSvTAXListdata(ptTypeABB){
        $.ajax({
            type    : "POST",
            url     : "TaxinvoiceABBList",
            data    : { 
                tTypeABB    :   ptTypeABB,
            },
            success: function(tResult){
                $("#odvContentTaxinvoiceABB").html(tResult);

                //เปลี่ยนชื่อเมนูข้างบน
                var tNameBar = 'tARTAXSelect' + ptTypeABB;
                switch (ptTypeABB) {
                    case 'ABBVD':
                        tNameBar = "<?=language('sale/Taxinvoice/Taxinvoice','tARTAXSelectABBVD')?>";
                        break;
                    case 'ABBPOS':
                        tNameBar = "<?=language('sale/Taxinvoice/Taxinvoice','tARTAXSelectABBPOS')?>";
                        break;
                    case 'ABBSL':
                        tNameBar = "<?=language('sale/Taxinvoice/Taxinvoice','tARTAXSelectABBSL')?>";
                        break;
                    }

                $('#oliTaxTitle').text(tNameBar);
                $('#ohdTypeABB').val(ptTypeABB);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


</script>