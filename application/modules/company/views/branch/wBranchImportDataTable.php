
<div class="row">
    <div class="col-xs-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHSearch')?></label>
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetBCHImpSearchAll" name="oetBCHImpSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSxBCHSearchImportDataTable()" value="<?=@$tSearch?>" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSxBCHSearchImportDataTable()" >
                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-5 col-md-3 col-lg-3">
        <div style="margin-bottom: 5px;">
            <label class="xCNLabelFrm">กรณีมีข้อมูลนี้อยู่แล้วในระบบ</label>
        </div>  
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="form-check-input" type="radio" name="orbBCHCaseInsAgain" id="orbBCHCaseNew" value="1">
            <label class="form-check-label" for="orbBCHCaseNew">ใช้รายการใหม่</label>
        </div>
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="form-check-input" type="radio" name="orbBCHCaseInsAgain" id="orbBCHCaseUpdate" value="2" checked>
            <label class="form-check-label" for="orbBCHCaseUpdate">อัพเดทรายการเดิม</label>
        </div>
    </div>
    <div class="col-xs-3 col-md-5 col-lg-5 text-right" style="margin-top:25px;">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?= language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled" onclick="JSxBCHDeleteImportList('NODATA')">
                    <a><?=language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive" >
            <table class="table table-striped nowrap" id="otdTableBCH" style="width:100%;">
                <thead>
                    <tr>
						<th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสสาขา";?></th>
						<th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อสาขา";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสตัวแทนขาย";?></th>
						<!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อตัวแทนขาย";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสกลุ่มราคา";?></th>
						<!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อกลุ่มราคา";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                    </tr>
                </thead>
			</table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDeleteImportBranch">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">
                <input type='hidden' id='ohdConfirmCodeDelete'>
			</div>
			<div class="modal-footer">
				<button id="obtBCHImpConfirm" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm')?></button>
				<button id="obtBCHImpCancel"class="btn xCNBTNDefult" type="button"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function() {


    $oNewJqueryVersion($oNewJqueryVersion.fn.dataTable.tables(true)).DataTable().columns.adjust();

    //กดยกเลิก ใน modal ลบ
    $('#obtBCHImpCancel').on('click',function(){
        $("#odvModalDeleteImportBranch").modal('hide');
    });

    //กดยืนยันการนำเข้า
    $('#obtIMPConfirm').off();
    $('#obtIMPConfirm').on('click',function(){
        JSxBCHImportMoveMaster();
    });
    

    //Render HTML
    JSxRenderDataTable();

    //กดลบทั้งหมด
    $('#otdTableBCH tbody').on('click', '.ocbListItem', function (e) {
        var nSeq  = $(this).data('seq');     //seq
        var nCode = $(this).data('code');    //code
        var tName = $(this).data('name');    //name
        $(this).prop('checked', true);

        // var nCheckedItem = $("#otdTableBCH tbody .ocbListItem:checked").length;
        // if(nCheckedItem >= 1){
        //     $("li#oliBtnDeleteAll").removeClass("disabled");
        // }else{
        //     $("li#oliBtnDeleteAll").css("pointer-events",'none');
        // }

        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nSeq":nSeq, "nCode":nCode, "tName":tName});
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxBCHImportTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSeq',nSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nSeq":nSeq, "nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxBCHImportTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nSeq == nSeq){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxBCHImportTextinModal();
            }
        }
        JSxShowButtonChoose();
    });
});

//Render HTML
function JSxRenderDataTable(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTableBCH').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "branchGetDataImport",
                async       : false,
                data: {
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetBCHImpSearchAll').val()
                },
            }).success(function(response) {
                var oRender = [];   
                
                if(response.recordsTotal == 0){
                    oRender = [];
                    var draw            = 1;
                    var recordsTotal    = 0;
                    var recordsFiltered = 0;
                }else{
                    for (var i=data.start, ien=data.start+data.length; i<ien ; i++ ) {
                        if(response.data.aResult[i] != null){

                            var FTBchCode       = response.data.aResult[i].FTBchCode;
                            var FTBchName       = response.data.aResult[i].FTBchName;
                            var FTAgnCode       = response.data.aResult[i].FTAgnCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTBchCode+"' data-name='"+FTBchName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
                            var FTAgnName       = (response.data.aResult[i].FTAgnName == '' || response.data.aResult[i].FTAgnName == null) ? 'N/A' : response.data.aResult[i].FTAgnName;
                            var FTPplCode       = (response.data.aResult[i].FTPplCode == '' || null) ? 'N/A' : response.data.aResult[i].FTPplCode;
                            var FTPplName       = (response.data.aResult[i].FTPplName == '' || response.data.aResult[i].FTPplName == null) ? 'N/A' : response.data.aResult[i].FTPplName;
                            var FTTmpRemark     = response.data.aResult[i].FTTmpRemark;
                            var aRemark         = FTTmpRemark.split("$&");
                            if(typeof aRemark[0] !== 'undefined'){
                                if(aRemark[0] == '' || aRemark[0] == null){

                                }else{
                                    if(aRemark[0].indexOf('[') !== -1){
                                        aRemarkIndex = aRemark[0].split("[");
                                        aRemarkIndex = aRemarkIndex[1].split("]");
                                        switch(aRemarkIndex[0]){
                                            case '0':
                                                FTBchCode       = aRemark[2];
                                                FTTmpRemark    = aRemark[1];
                                            break;
                                            case '1':
                                                FTBchName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '2':
                                                FTAgnCode       = aRemark[2];
                                                FTAgnName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '3':
                                                FTPplCode       = aRemark[2];
                                                FTPplName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTBchName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxBCHDeleteImportList('"+FNTmpSeq+"','"+FTBchCode+"','"+tNameShowDelete+"')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTBchCode , 
                                FTBchName , 
                                FTAgnCode , 
                                // FTAgnName , 
                                FTPplCode , 
                                // FTPplName ,
                                FTTmpRemark ,
                                tImgDelete 
                            ]);

                            var draw            = data.draw;
                            var recordsTotal    = response.recordsTotal;
                            var recordsFiltered = response.recordsFiltered;
                        }
                    }
                }

                setTimeout( function () {
                    callback( {
                        draw            : data.draw,
                        data            : oRender,
                        recordsTotal    : recordsTotal,
                        recordsFiltered : recordsFiltered
                    });
                    JSxControlCheckBoxDeleteAll();
                }, 50);
                
                setTimeout(function(){
                    JCNxCloseLoading();
                }, 100)
            }).fail(function(err){
                console.error('error...', err)
            })
        },
        scrollY         : "38vh",
        scrollX         : true,
        scrollCollapse  : false,
        scroller: {
            loadingIndicator: true
        }
    });

    // $('.dataTables_scrollBody').css('min-height','400px');
}

//Control checkbox ลบทั้งหมดอีกครั้ง ให้มันติ๊ก ถ้ามันเคยติ้กเเล้ว
function JSxControlCheckBoxDeleteAll(){
    var rowCount = $('#otdTableBCH tbody tr').length;
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if(aArrayConvert[0] != null){
        for (var j = 0; j < aArrayConvert[0].length; j++) {
            $('#ocbListItem' + aArrayConvert[0][j].nSeq).attr('checked','checked');
        }
    }
    JSxShowButtonChoose();
}

//ค้นหา
function JSxBCHSearchImportDataTable(){
    $oNewJqueryVersion('#otdTableBCH').DataTable().ajax.reload();
}

//ย้ายจากข้อมูล Tmp ลง Master
function JSxBCHImportMoveMaster(){
    var tTypeCaseDuplicate = $("input[name='orbBCHCaseInsAgain']:checked").val();
    $.ajax({
        type    : "POST",
        url     : "branchEventImportMove2Master",
        data    : { 'tTypeCaseDuplicate' : tTypeCaseDuplicate },
        cache   : false,
        timeout : 0,
        success : function(oResult){
            $('#odvModalImportFile').modal('hide');
            setTimeout(function() {
                JSvBranchDataTable();
            }, 500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//ฟังก์ชั่น Delete
function JSxBCHDeleteImportList(ptSeq, ptBchCode, ptBchName) {
    var aData = $('#odvModalDeleteImportBranch #ohdConfirmIDDelete').val();
    $('#odvModalDeleteImportBranch .modal-dialog').css('width','35%')
    if(aData == ''){
        if(ptSeq == 'NODATA'){
            return;
        }

        console.log('Single Del List');
        $('#odvModalDeleteImportBranch').modal('show');
        $('#odvModalDeleteImportBranch #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptBchCode + ' (' + ptBchName + ')' + '<?=language("common/main/main","tBCHYesOnNo");?>');
        aNewIdDelete    = ptSeq;
        aNewCodeDelete  = ptBchCode;
    }else{
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;

        var aDataCode = $('#odvModalDeleteImportBranch #ohdConfirmCodeDelete').val();
        var aTextsCode = aDataCode.substring(0, aDataCode.length - 2);
        var aDataCodeSplit = aTextsCode.split(" , ");
        var aDataCodeSplitLength = aDataCodeSplit.length;

        console.log('Multi Del List');
        $('#odvModalDeleteImportBranch').modal('show');
        var aNewIdDelete    = [];
        var aNewCodeDelete  = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
            aNewCodeDelete.push(aDataCodeSplit[$i]);
        }
    }
    
    $('#obtBCHImpConfirm').off('click');
    $('#obtBCHImpConfirm').on('click', function(){
        $.ajax({
            type: "POST",
            url: "branchEventImportDelete",
            data: {
                'FTBchCode'     : aNewCodeDelete,
                'FNTmpSeq'      : aNewIdDelete
            },
            cache: false,
            timeout: 0,
            success: function(oResult){
                var aData = $.parseJSON(oResult);
                if(aData['tCode'] == '1'){
                    $('#odvModalDeleteImportBranch').modal('hide');
                    $('#odvModalDeleteImportBranch #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val());
                    $('#odvModalDeleteImportBranch #ohdConfirmIDDelete').val('');
                    $('#odvModalDeleteImportBranch #ohdConfirmCodeDelete').val('');
                    localStorage.removeItem('LocalItemData');

                    setTimeout(function() {
                        JSxBCHSearchImportDataTable();
                        JSxBCHImportTGetItemAll();
                    }, 500);
                }else{
                    alert(aData['tDesc']);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

//เวลากดลบ จะ มีการสลับ Text เอาไว้ว่าลบแบบ single หรือ muti
function JSxBCHImportTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
    }else{
        var tText       = '';
        var tTextCode   = '';
        var tTextSeq    = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextSeq += aArrayConvert[0][$i].nSeq;
            tTextSeq += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#odvModalDeleteImportBranch #ospConfirmDelete').html(tConfirm);
        $('#odvModalDeleteImportBranch #ohdConfirmIDDelete').val(tTextSeq);
        $('#odvModalDeleteImportBranch #ohdConfirmCodeDelete').val(tTextCode);
    }
}

JSxBCHImportTGetItemAll();
function JSxBCHImportTGetItemAll(){
    $.ajax({
        type    : "POST",
        url     : "branchGetItemAllImport",
        cache   : false,
        timeout : 0,
        success : function(oReturn){
            var oResult = JSON.parse(oReturn);
            var TYPESIX = oResult[0].TYPESIX;
            var TYPEONE = oResult[0].TYPEONE;
            var ITEMALL = oResult[0].ITEMALL;

            var tTextShow = "รอการนำเข้า " + TYPEONE + ' / ' + ITEMALL + ' รายการ - อัพเดทข้อมูล ' + TYPESIX + ' / ' + ITEMALL + ' รายการ';
            $('#ospTextSummaryImport').text(tTextShow);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

</script>