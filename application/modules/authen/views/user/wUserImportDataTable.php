<div class="row">
    <div class="col-xs-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHSearch')?></label>
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetUSRImpSearchAll" name="oetUSRImpSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSxUSRSearchImportDataTable()" value="<?=@$tSearch?>" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSxUSRSearchImportDataTable()" >
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
            <input class="form-check-input" type="radio" name="orbUSRCaseInsAgain" id="orbUserCaseNew" value="1">
            <label class="form-check-label" for="orbUserCaseNew">ใช้รายการใหม่</label>
        </div>
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="form-check-input" type="radio" name="orbUSRCaseInsAgain" id="orbUserCaseUpdate" value="2" checked>
            <label class="form-check-label" for="orbUserCaseUpdate">อัพเดทรายการเดิม</label>
        </div>
    </div>
    <div class="col-xs-3 col-md-5 col-lg-5 text-right" style="margin-top:25px;">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?= language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled" onclick="JSxUSRDeleteImportList('NODATA')">
                    <a><?=language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped nowrap" id="otdTableUSR" style="width:100%;">
                <thead>
                    <tr>
						<th nowrap class="xCNTextBold" style="text-align:center;"><?php echo language('company/branch/branch','tBCHChoose');?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสผู้ใช้";?></th>
						<th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อผู้ใช้";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสสาขา";?></th>
						<!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อสาขา";?></th> -->
                        <th nowrap class="xCNTextBold" style=";text-align:center;"><?php echo "รหัสกลุ่มสิทธิ์";?></th>
						<!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อกลุ่มสิทธิ์";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสตัวแทนขาย";?></th>
                        <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อตัวแทนขาย";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสกลุ่มธุรกิจ";?></th>
                        <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อกลุ่มธุรกิจ";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสร้านค้า";?></th>
                        <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อร้านค้า";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "รหัสแผนก";?></th>
                        <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อแผนก";?></th> -->
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "เบอร์";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "อีเมล์";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                        <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                    </tr>
                </thead>
			</table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDeleteImportUser">
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
				<button id="obtUSRImpConfirm" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm')?></button>
				<button id="obtUSRImpCancel"class="btn xCNBTNDefult" type="button"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
    //กดยกเลิก ใน modal ลบ
    $('#obtUSRImpCancel').on('click',function(){
        $("#odvModalDeleteImportUser").modal('hide');
    });

    $('#obtIMPConfirm').off();
    $('#obtIMPConfirm').on('click',function(){
        JSxUSRImportMoveMaster();
    });

    //Render HTML
    JSxRenderDataTable();

    $('#otdTableUSR tbody').on('click', '.ocbListItem', function (e) {
        var nSeq  = $(this).data('seq');     //seq
        var nCode = $(this).data('code');    //code
        var tName = $(this).data('name');    //name
        $(this).prop('checked', true);

        // var nCheckedItem = $("#otdTableUSR tbody .ocbListItem:checked").length;
        // if(nCheckedItem >= 1){
        //     $("li#oliBtnDeleteAll").removeClass("disabled");
        // }else{
        //     $("li#oliBtnDeleteAll").addClass("disabled");
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
            JSxUSRImportTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSeq',nSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nSeq":nSeq, "nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxUSRImportTextinModal();
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
                JSxUSRImportTextinModal();
            }
        }
        JSxShowButtonChoose();
    });

});

//Render HTML
function JSxRenderDataTable(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTableUSR').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "userGetDataImport",
                async       : false,
                data: {
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetUSRImpSearchAll').val()
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
                            if( response.data.aResult[i].FTTmpRemark == 'AutoGen'){
                                var FTUsrCode       = "รอตรวจสอบรหัสผู้ใช้";
                            }else{
                                var FTUsrCode       = response.data.aResult[i].FTUsrCode;
                            }
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTUsrName       = response.data.aResult[i].FTUsrName;
                            var FTBchCode       = (response.data.aResult[i].FTBchCode == '') ? 'N/A'  : response.data.aResult[i].FTBchCode;
                            var FTBchName       = (response.data.aResult[i].FTBchName == '') ? 'N/A'  : response.data.aResult[i].FTBchName;
                            var FTRolCode       = (response.data.aResult[i].FTRolCode == '') ? 'N/A'  : response.data.aResult[i].FTRolCode;
                            var FTRolName       = (response.data.aResult[i].FTRolName == '') ? 'N/A'  : response.data.aResult[i].FTRolName;
                            var FTMerCode       = (response.data.aResult[i].FTMerCode == '') ? 'N/A'  : response.data.aResult[i].FTMerCode;
                            var FTMerName       = (response.data.aResult[i].FTMerName == '') ? 'N/A'  : response.data.aResult[i].FTMerName;
                            var FTAgnCode       = (response.data.aResult[i].FTAgnCode == '') ? 'N/A'  : response.data.aResult[i].FTAgnCode;
                            var FTAgnName       = (response.data.aResult[i].FTAgnName == '') ? 'N/A'  : response.data.aResult[i].FTAgnName;
                            var FTShpCode       = (response.data.aResult[i].FTShpCode == '') ? 'N/A'  : response.data.aResult[i].FTShpCode;
                            var FTShpName       = (response.data.aResult[i].FTShpName == '') ? 'N/A'  : response.data.aResult[i].FTShpName;
                            var FTDptCode       = (response.data.aResult[i].FTDptCode == '') ? 'N/A'  : response.data.aResult[i].FTDptCode;
                            var FTDptName       = (response.data.aResult[i].FTDptName == '') ? 'N/A'  : response.data.aResult[i].FTDptName;
                            var FTUsrTel        = (response.data.aResult[i].FTUsrTel == '') ? 'N/A'  : response.data.aResult[i].FTUsrTel;
                            var FTUsrEmail      = (response.data.aResult[i].FTUsrEmail == '') ? 'N/A'  : response.data.aResult[i].FTUsrEmail;
                            var FTTmpRemark     = response.data.aResult[i].FTTmpRemark;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;

                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }

                            var aRemark         = FTTmpRemark.split("$&");
                            if(typeof aRemark[0] !== 'undefined'){
                                if(aRemark[0] == '' || aRemark[0] == null){

                                }else{
                                    if(aRemark[0].indexOf('[') !== -1){
                                        aRemarkIndex = aRemark[0].split("[");
                                        aRemarkIndex = aRemarkIndex[1].split("]");
                                        switch(aRemarkIndex[0]){
                                            case '0':
                                                //ผู้ใช้
                                                FTUsrCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                //ชื่อ
                                                FTUsrName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '2':
                                                //สาขา
                                                FTBchCode       = aRemark[2];
                                                FTBchName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '3':
                                                //กลุ่มสิทธิ
                                                FTRolCode       = aRemark[2];
                                                FTRolName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '4':
                                                //ตัวแทนขาย
                                                FTAgnCode       = aRemark[2];
                                                FTAgnName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '5':
                                                //กลุ่มธุรกิจ
                                                FTMerCode       = aRemark[2];
                                                FTMerName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '6':
                                                //ร้านค้า
                                                FTShpCode       = aRemark[2];
                                                FTShpName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '7':
                                                //แผนก
                                                FTDptCode       = aRemark[2];
                                                FTDptName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '8':
                                                //เบอร์
                                                FTUsrTel        = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '9':
                                                //อีเมล
                                                FTUsrEmail      = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTUsrCode+"' data-name='"+FTUsrName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTUsrName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxUSRDeleteImportList('"+FNTmpSeq+"','"+FTUsrCode+"','"+tNameShowDelete+"')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTUsrCode , 
                                FTUsrName , 
                                FTBchCode , 
                                // FTBchName , 
                                FTRolCode , 
                                // FTRolName ,
                                FTAgnCode ,
                                // FTAgnName ,
                                FTMerCode ,
                                // FTMerName ,
                                FTShpCode ,
                                // FTShpName ,
                                FTDptCode ,
                                // FTDptName ,
                                FTUsrTel ,
                                FTUsrEmail ,
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
    var rowCount = $('#otdTableUSR tbody tr').length;
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if(aArrayConvert[0] != null){
        for (var j = 0; j < aArrayConvert[0].length; j++) {
            $('#ocbListItem' + aArrayConvert[0][j].nSeq).attr('checked','checked');
        }
    }
    JSxShowButtonChoose();
}

//ค้นหา
function JSxUSRSearchImportDataTable(){
    $oNewJqueryVersion('#otdTableUSR').DataTable().ajax.reload();
}

//ย้ายจากข้อมูล Tmp ลง Master
function JSxUSRImportMoveMaster(){
    var tTypeCaseDuplicate = $("input[name='orbUSRCaseInsAgain']:checked").val();
    $.ajax({
        type    : "POST",
        url     : "userEventImportMove2Master",
        data    : { 'tTypeCaseDuplicate' : tTypeCaseDuplicate },
        cache   : false,
        timeout : 0,
        success : function(oResult){
            $('#odvModalImportFile').modal('hide');
            FSvCMNSetMsgSucessDialog('<p class="text-left">นำเข้าข้อมูลผู้ใช้สำเร็จ</p>');
            setTimeout(function() {
                JSvUserDataTable();
            }, 500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//ฟังก์ชั่น Delete
function JSxUSRDeleteImportList(ptSeq, ptUserCode, ptUserName) {
    var ptYesOnNo = '<?=language("common/main/main","tBCHYesOnNo");?>';
    var aData = $('#odvModalDeleteImportUser #ohdConfirmIDDelete').val();
    if(aData == ''){
        if(ptSeq == 'NODATA'){
            return;
        }

        $('#odvModalDeleteImportUser').modal('show');
        $('#odvModalDeleteImportUser #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptUserCode + ' (' + ptUserName + ')' + ptYesOnNo);
        aNewIdDelete                = ptSeq;
        aNewCodeDelete              = ptUserCode;
    }else{
        
        var aTexts                  = aData.substring(0, aData.length - 2);
        var aDataSplit              = aTexts.split(" , ");
        var aDataSplitlength        = aDataSplit.length;

        var aDataCode               = $('#odvModalDeleteImportUser #ohdConfirmCodeDelete').val();
        var aTextsCode              = aDataCode.substring(0, aDataCode.length - 2);
        var aDataCodeSplit          = aTextsCode.split(" , ");
        var aDataCodeSplitLength    = aDataCodeSplit.length;

        $('#odvModalDeleteImportUser').modal('show');
        var aNewIdDelete    = [];
        var aNewCodeDelete  = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
            aNewCodeDelete.push(aDataCodeSplit[$i]);
        }
    }
    
    $('#obtUSRImpConfirm').off('click');
    $('#obtUSRImpConfirm').on('click', function(){
        $.ajax({
            type    : "POST",
            url     : "userEventImportDelete",
            data    : {
                'FTUsrCode'     : aNewCodeDelete,
                'FNTmpSeq'      : aNewIdDelete
            },
            cache   : false,
            timeout : 0,
            success : function(oResult){
                var aData = $.parseJSON(oResult);
                if(aData['tCode'] == '1'){
                    $('#odvModalDeleteImportUser').modal('hide');
                    $('#odvModalDeleteImportUser #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val());
                    $('#odvModalDeleteImportUser #ohdConfirmIDDelete').val('');
                    $('#odvModalDeleteImportUser #ohdConfirmCodeDelete').val('');
                    localStorage.removeItem('LocalItemData');

                    setTimeout(function() {
                        JSxUSRSearchImportDataTable();
                        JSxUSRImportTGetItemAll();
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
function JSxUSRImportTextinModal() {
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
        $('#odvModalDeleteImportUser #ospConfirmDelete').html(tConfirm);
        $('#odvModalDeleteImportUser #ohdConfirmIDDelete').val(tTextSeq);
        $('#odvModalDeleteImportUser #ohdConfirmCodeDelete').val(tTextCode);
    }
}

JSxUSRImportTGetItemAll();
function JSxUSRImportTGetItemAll(){
    $.ajax({
        type    : "POST",
        url     : "userGetItemAllImport",
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