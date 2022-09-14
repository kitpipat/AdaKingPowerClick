<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-6 col-md-6 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuASTthoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?=language('document/adjuststock/adjuststock','tASTFillTextSearch')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSxLoadContentDatatable(1)"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSxLoadContentDatatable(1)">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
		<section id="ostContentDatatableABB"></section>
	</div>
</div>

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    //โหลดหน้าจอ Datatable
    JSxLoadContentDatatable(1);
    function JSxLoadContentDatatable(pnPage){
        $.ajax({
            type    : "POST",
            url     : "dcmTXFCLoadListDataTable",
            data    : { 'nPage' : pnPage , 'tSearchAll' : $('#oetSearchAll').val() },
            cache   : false,
            Timeout : 0,
            success : function (oResult) {
                $('#ostContentDatatableABB').html(oResult);
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>