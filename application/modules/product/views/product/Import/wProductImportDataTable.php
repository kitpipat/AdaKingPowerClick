<?php
    $tDangerMsg     = "<span class='text-danger' style='font-weight: bold;'>*</span>";
    $tPrimaryMsg    = "<span class='text-primary' style='font-weight: bold;'>*</span>";
?>

<div class="row">
    <div class="col-xs-4 col-md-4 col-lg-4">
        <div class="form-group">
            <label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHSearch')?></label>
            <div class="input-group">
                <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetPDTImpSearchAll" name="oetPDTImpSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSxPDTSearchImportDataTable()" value="<?=@$tSearch?>" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
                <span class="input-group-btn">
                    <button class="btn xCNBtnSearch" type="button" onclick="JSxPDTSearchImportDataTable()" >
                        <img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="col-xs-5 col-md-5 col-lg-5">
        <?php
            $aLangForImp = array(
                'tUpdItems'             => "ระบบจะทำการอัพเดทข้อมูลในคอลัมที่มี <span class='text-primary' style='font-weight: bold;'>*</span> เท่านั้น",
                'tUseNewItems'          => "ระบบจะทำการลบข้อมูลเดิม และเพิ่มข้อมูลใหม่",
                'tUseNewItems_PDT'      => "ระบบจะทำการลบข้อมูลเดิม และเพิ่มข้อมูลใหม่ (หน่วย และบาร์โค้ดจะไม่ถูกลบ)",
                'tCaseDataInSys'        => "กรณีxxxที่นำเข้ามีอยู่แล้วในระบบ"
            );
        ?>
        <div style="margin-bottom: 5px;">
            <label id="olbCaseAlreadyInSystem" class="xCNLabelFrm">กรณีมีข้อมูลนี้อยู่แล้วในระบบ</label>
        </div>  
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="xWEventClickRadio form-check-input" type="radio" name="orbPDTCaseInsAgain" id="orbPDTCaseNew" value="1">
            <label class="form-check-label" for="orbPDTCaseNew">ใช้รายการใหม่</label>
        </div>
        <div class="form-check form-check-inline" style="display: inline; margin-right: 20px;">
            <input class="xWEventClickRadio form-check-input" type="radio" name="orbPDTCaseInsAgain" id="orbPDTCaseUpdate" value="2" checked>
            <label class="form-check-label" for="orbPDTCaseUpdate">อัพเดทรายการเดิม</label>
        </div>
        <div>
            <label id="olbWarningImpPdt" class="xCNLabelFrm" style='color: #F9354C !important;'></label>
        </div>
    </div>
    <div class="col-xs-3 col-md-3 col-lg-3 text-right" style="margin-top:25px;">
        <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                <?= language('common/main/main','tCMNOption')?>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li id="oliBtnDeleteAll" class="disabled" onclick="JSxPDTDeleteImportList('NODATA')">
                    <a><?=language('common/main/main','tDelAll')?></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div>
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li class="nav-item active"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPDT" data-toggle="tab" href="#odvPDT" role="tab" aria-expanded="false">สินค้า</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtUnit" data-toggle="tab" href="#odvUNIT" role="tab" aria-expanded="false">หน่วยสินค้า</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtBrand" data-toggle="tab" href="#odvBrand" role="tab" aria-expanded="false">ยี่ห้อ</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtType" data-toggle="tab" href="#odvPdtType" role="tab" aria-expanded="false">ประเภท</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtModel" data-toggle="tab" href="#odvPdtModel" role="tab" aria-expanded="false">รุ่น</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtGrp" data-toggle="tab" href="#odvPdtGrp" role="tab" aria-expanded="false">กลุ่ม</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TCNMPdtTouchGrp" data-toggle="tab" href="#odvPDTTouch" role="tab" aria-expanded="false">กลุ่มสินค้าด่วน</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <!--Content PDT-->
                    <div class="tab-pane active" id="odvPDT" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePDT" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสสินค้า";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อสินค้า";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อย่อสินค้า";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสหน่วยสินค้า";?></th>
                                                <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อหน่วยสินค้า";?></th> -->
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "อัตราส่วน/หน่วย";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "บาร์โค้ด";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "รหัสยี่ห้อ";?></th>
                                                <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อยี่ห้อ";?></th> -->

                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ภาษี";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "รหัสประเภท";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "รหัสรุ่น";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "รหัสกลุ่ม";?></th>

                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "รหัสกลุ่มสินค้าด่วน";?></th>
                                                <!-- <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "ชื่อกลุ่มสินค้าด่วน";?></th> -->
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content UNIT-->
                    <div class="tab-pane" id="odvUNIT" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePDTUnit" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสหน่วย";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อหน่วย";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content Brand-->
                    <div class="tab-pane" id="odvBrand" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePDTBrand" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสยี่ห้อ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อยี่ห้อ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content Product Type-->
                    <div class="tab-pane" id="odvPdtType" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePdtType" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสประเภท";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อประเภท";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content Product Model-->
                    <div class="tab-pane" id="odvPdtModel" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePdtModel" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสรุ่น";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อรุ่น";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content Product Group-->
                    <div class="tab-pane" id="odvPdtGrp" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePdtGrp" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสกลุ่ม";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อกลุ่ม";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Content Touch-->
                    <div class="tab-pane" id="odvPDTTouch" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otdTablePDTTouchGroup" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tDangerMsg?><?php echo "รหัสกลุ่มสินค้าด่วน";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?=$tPrimaryMsg?><?php echo "ชื่อกลุ่มสินค้าด่วน";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohaTabActiveProduct" id="ohaTabActiveProduct" value="TCNMPDT">

<div class="modal fade" id="odvModalDeleteImportProduct">
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
				<button id="obtPDTImpConfirm" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm')?></button>
				<button id="obtPDTImpCancel"class="btn xCNBTNDefult" type="button"><?php echo language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
    
    //กดยกเลิก ใน modal ลบ
    $('#obtPDTImpCancel').on('click',function(){
        $("#odvModalDeleteImportProduct").modal('hide');
    });

    //กดยืนยันการนำเข้า
    $('#obtIMPConfirm').off();
    $('#obtIMPConfirm').on('click',function(){
        JSxPDTImportMoveMaster();
    });
    
    //Render HTML
    JSxRenderDataTable_PDT();

    //Render Touch Group HTML
    JSxRenderDataTable_TouchGroup();

    //Render Product Group HTML
    JSxRenderDataTable_PdtGrp();

    //Render Product Model HTML
    JSxRenderDataTable_PdtModal();

    //Render Product Type HTML
    JSxRenderDataTable_PdtType();

    //Render Brand HTML 
    JSxRenderDataTable_Brand();

    //Render Unit HTML 
    JSxRenderDataTable_Unit();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $oNewJqueryVersion($oNewJqueryVersion.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    // $('.dataTables_scrollBody').css('height', '300px');

    var oDataLang = <?php echo json_encode($aLangForImp);?>;
    var aDataLang = JSON.parse(JSON.stringify(oDataLang));
    // console.log(aDataLang);

    // Default ตอนโหลดหน้าจอครั้งแรก
    $('#olbWarningImpPdt').html(aDataLang['tUpdItems']);
    $('#olbCaseAlreadyInSystem').html(aDataLang['tCaseDataInSys'].replace('xxx','สินค้า'));

    function JSxChkCaseAlreadyInSys(){
        var nChkVal = $('input[name=orbPDTCaseInsAgain]:checked').val();
        if( nChkVal == '2' ){
            $('#olbWarningImpPdt').html(aDataLang['tUpdItems']);
        }else{
            var tTabActive = $('.active').find('.xCNEventTab').attr('data-hiddenid');
            if( tTabActive == 'TCNMPDT' ){
                $('#olbWarningImpPdt').html(aDataLang['tUseNewItems_PDT']); 
            }else{
                $('#olbWarningImpPdt').html(aDataLang['tUseNewItems']);
            }
        }
    }

    $('.xWEventClickRadio').click(function(){
        JSxChkCaseAlreadyInSys();
    });

    $('.xCNEventTab').click(function(e) {
        //ทุกครั้งที่กด Tab localstorage จะเคลียร์
        localStorage.removeItem("LocalItemData")
        $('.ocbListItem').prop('checked', false);
        JSxShowButtonChoose();

        //เก็บค่าไว้
        var tHiddenID = $(this).attr('data-hiddenID');
        $('#ohaTabActiveProduct').val(tHiddenID);
        JSxPDTImportGetItemAll();

        $('#olbCaseAlreadyInSystem').html(aDataLang['tCaseDataInSys'].replace('xxx',$(this).html()));

        setTimeout(function(){ 
            JSxChkCaseAlreadyInSys();
        }, 100);
         
    });

    //กดเลือกลบทั้งหมด
    $('#otdTablePDT , #otdTablePDTUnit , #otdTablePDTBrand , #otdTablePDTTouchGroup , #otdTablePdtGrp , #otdTablePdtModel , #otdTablePdtType , tbody').on('click', '.ocbListItem', function (e) {
        var nSeq  = $(this).data('seq');     //seq
        var nCode = $(this).data('code');    //code
        var tName = $(this).data('name');    //name

        // var nCheckedItem = $("#otdTablePDT , #otdTablePDTUnit , #otdTablePDTBrand , #otdTablePDTTouchGroup tbody .ocbListItem:checked").length;
        // if(nCheckedItem >= 1){
        //     $("li#oliBtnDeleteAll").removeClass("disabled");
        // }else{
        //     $("li#oliBtnDeleteAll").addClass("disabled");
        // }


        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nSeq":nSeq, "nCode":nCode, "tName":tName});
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPDTImportTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSeq',nSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nSeq":nSeq, "nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPDTImportTextinModal();
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
                JSxPDTImportTextinModal();
            }
        }
        JSxShowButtonChoose();
    });
});

//Render HTML
function JSxRenderDataTable_PDT(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePDT').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPDT',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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

                            var FTPdtCode       = response.data.aResult[i].FTPdtCode;
                            var FTPdtName       = response.data.aResult[i].FTPdtName;
                            var FTPdtNameABB    = (response.data.aResult[i].FTPdtNameABB == null)  ? 'N/A' : response.data.aResult[i].FTPdtNameABB;
                            var FCPdtUnitFact   = (response.data.aResult[i].FCPdtUnitFact == '')  ? '0.00' : response.data.aResult[i].FCPdtUnitFact;
                            var FTBarCode       = (response.data.aResult[i].FTBarCode == null)  ? 'N/A' : response.data.aResult[i].FTBarCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;

                            var FTPunCode       = (response.data.aResult[i].FTPunCode == null)  ? 'N/A' : response.data.aResult[i].FTPunCode ;
                            var FTPunName       = (response.data.aResult[i].FTPunName == null)  ? 'N/A' : response.data.aResult[i].FTPunName;
                            if(FTPunName == 'N/A'){FTPunName = response.data.aResult[i].Master_FTPunName;}

                            var FTPbnCode       = (response.data.aResult[i].FTPbnCode == '')  ? 'N/A' : response.data.aResult[i].FTPbnCode;
                            var FTPbnName       = (response.data.aResult[i].FTPbnName == null)  ? 'N/A' : response.data.aResult[i].FTPbnName;
                            if(FTPbnName == 'N/A'){FTPbnName = response.data.aResult[i].Master_FTPbnName;}

                            var FTPdtStaVat     = (response.data.aResult[i].FTPdtStaVat == '' || response.data.aResult[i].FTPdtStaVat == '1')  ? 'มีภาษี' : 'ไม่มีภาษี';

                            var FTPtyCode       = (response.data.aResult[i].FTPtyCode == '')  ? 'N/A' : response.data.aResult[i].FTPtyCode;
                            var FTPtyName       = (response.data.aResult[i].FTPtyName == null)  ? 'N/A' : response.data.aResult[i].FTPtyName;
                            if(FTPtyName == 'N/A'){FTPtyName = response.data.aResult[i].Master_FTPtyName;}

                            var FTPmoCode       = (response.data.aResult[i].FTPmoCode == '')  ? 'N/A' : response.data.aResult[i].FTPmoCode;
                            var FTPmoName       = (response.data.aResult[i].FTPmoName == null)  ? 'N/A' : response.data.aResult[i].FTPmoName;
                            if(FTPmoName == 'N/A'){FTPmoName = response.data.aResult[i].Master_FTPmoName;}

                            var FTPgpChain       = (response.data.aResult[i].FTPgpChain == '')  ? 'N/A' : response.data.aResult[i].FTPgpChain;
                            var FTPgpName       = (response.data.aResult[i].FTPgpName == null)  ? 'N/A' : response.data.aResult[i].FTPgpName;
                            if(FTPgpName == 'N/A'){FTPgpName = response.data.aResult[i].Master_FTPgpName;}

                            var FTTcgCode       = (response.data.aResult[i].FTTcgCode == '')  ? 'N/A' : response.data.aResult[i].FTTcgCode;
                            var FTTcgName       = (response.data.aResult[i].FTTcgName == null)  ? 'N/A' : response.data.aResult[i].FTTcgName;
                            if(FTTcgName == 'N/A'){FTTcgName = response.data.aResult[i].Master_FTTcgName;}

                            

                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPdtCode+"' data-name='"+FTPdtName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPdtCode      = aRemark[2];
                                                FTTmpRemark    = aRemark[1];
                                            break;
                                            case '1':
                                                FTPdtName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '2':
                                                FTPdtNameABB    = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '3':
                                                FTPunCode       = aRemark[2];
                                                FTPunName       = 'N/A';
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '4':
                                                FCPdtUnitFact   = "0.00";
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '5':
                                                FTBarCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '6':
                                                FTPbnCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '7':
                                                FTPdtStaVat     = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '8':
                                                FTPtyCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '9':
                                                FTPmoCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '10':
                                                FTPgpChain       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '11':
                                                FTTcgCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPdtName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPdtCode+"','"+tNameShowDelete+"','TCNMPDT')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPdtCode , 
                                FTPdtName , 
                                FTPdtNameABB , 
                                FTPunCode , 
                                // FTPunName , 
                                FCPdtUnitFact ,
                                FTBarCode ,
                                FTPbnCode ,
                                // FTPbnName ,
                                FTPdtStaVat ,
                                FTPtyCode ,
                                FTPmoCode ,
                                FTPgpChain ,
                                FTTcgCode ,
                                // FTTcgName ,
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
        scrollCollapse  : false,
        scroller: {
            loadingIndicator: true
        }
    });

}

//Render Touch Group HTML
function JSxRenderDataTable_TouchGroup(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePDTTouchGroup').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtTouchGrp',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTTcgName       = response.data.aResult[i].FTTcgName;
                            var FTTcgCode       = response.data.aResult[i].FTTcgCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTTcgCode+"' data-name='"+FTTcgName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTTcgCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTTcgName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTTcgName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTTcgCode+"','"+tNameShowDelete+"','TCNMPdtTouchGrp')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTTcgCode , 
                                FTTcgName , 
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
}

//Render Product Group HTML
function JSxRenderDataTable_PdtGrp(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePdtGrp').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtGrp',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTPgpName       = response.data.aResult[i].FTPgpName;
                            var FTPgpChain       = response.data.aResult[i].FTPgpChain;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPgpChain+"' data-name='"+FTPgpName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPgpChain       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTPgpName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPgpName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPgpChain+"','"+tNameShowDelete+"','TCNMPdtGrp')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPgpChain , 
                                FTPgpName , 
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
}

//Render Product Modal HTML
function JSxRenderDataTable_PdtModal(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePdtModel').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtModel',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTPmoName       = response.data.aResult[i].FTPmoName;
                            var FTPmoCode       = response.data.aResult[i].FTPmoCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPmoCode+"' data-name='"+FTPmoName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPmoCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTPmoName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPmoName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPmoCode+"','"+tNameShowDelete+"','TCNMPdtModel')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPmoCode , 
                                FTPmoName , 
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
}

//Render Product Type HTML
function JSxRenderDataTable_PdtType(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePdtType').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtType',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTPtyName       = response.data.aResult[i].FTPtyName;
                            var FTPtyCode       = response.data.aResult[i].FTPtyCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPtyCode+"' data-name='"+FTPtyName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPtyCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTPtyName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPtyName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPtyCode+"','"+tNameShowDelete+"','TCNMPdtType')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPtyCode , 
                                FTPtyName , 
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
}

//Render Brand HTML 
function JSxRenderDataTable_Brand(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePDTBrand').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtBrand',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTPbnName       = response.data.aResult[i].FTPbnName;
                            var FTPbnCode       = response.data.aResult[i].FTPbnCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPbnCode+"' data-name='"+FTPbnName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPbnCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTPbnName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPbnName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPbnCode+"','"+tNameShowDelete+"','TCNMPdtBrand')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPbnCode , 
                                FTPbnName , 
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
}

//Render Unit
function JSxRenderDataTable_Unit(){
    localStorage.removeItem("LocalItemData");
    $oNewJqueryVersion('#otdTablePDTUnit').DataTable({
        serverSide      : true,
        ordering        : false,
        searching       : false,
        lengthChange    : false,
        bInfo           : false,
        ajax            : function ( data, callback, settings ) {
            $.ajax({
                type		: "POST",
                url			: "productGetDataImport",
                async       : false,
                data: {
                    'tType'                 : 'TCNMPdtUnit',
                    'nPageNumber'           : data.draw - 1,
                    'tSearch'               : $('#oetPDTImpSearchAll').val()
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
                            var FTPunName       = response.data.aResult[i].FTPunName;
                            var FTPunCode       = response.data.aResult[i].FTPunCode;
                            var FNTmpSeq        = response.data.aResult[i].FNTmpSeq;
                            var FTTmpStatus     = response.data.aResult[i].FTTmpStatus;
                            if(FTTmpStatus != 1){
                                var tStyleList  = "color:red !important; font-weight:bold;"; 
                            }else{
                                var tStyleList  = '';
                            }
                    
                            var tIDCheckbox     = "ocbListItem" + FNTmpSeq;
                            var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                                tCheckBoxDelete += "<input id='"+tIDCheckbox+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-code='"+FTPunCode+"' data-name='"+FTPunName+"' data-seq='"+FNTmpSeq+"'>";
                                tCheckBoxDelete += "<span>&nbsp;</span>";
                                tCheckBoxDelete += "</label>";
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
                                                FTPunCode       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                            case '1':
                                                FTPunName       = aRemark[2];
                                                FTTmpRemark     = aRemark[1];
                                            break;
                                        }
                                    }
                                }
                            }

                            var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                            var tNameShowDelete = FTPunName.replace(/\s/g, '');
                            var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTPunCode+"','"+tNameShowDelete+"','TCNMPdtUnit')";
                            var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                            oRender.push([ 
                                tCheckBoxDelete , 
                                FTPunCode , 
                                FTPunName , 
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
}

//Control checkbox ลบทั้งหมดอีกครั้ง ให้มันติ๊ก ถ้ามันเคยติ้กเเล้ว
function JSxControlCheckBoxDeleteAll(){
    // var rowCount = $('#otdTableUSR tbody tr').length;
    // var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    // if(aArrayConvert[0] != null){
    //     for (var j = 0; j < aArrayConvert[0].length; j++) {
    //         $('#ocbListItem' + aArrayConvert[0][j].nSeq).attr('checked','checked');
    //     }
    // }
    // JSxShowButtonChoose();
}

//ฟังก์ชั่น Delete
function JSxPDTDeleteImportList(ptSeq, pkCode , pkName, ptTableName) {
    var ptYesOnNo = '<?=language("common/main/main","tBCHYesOnNo");?>';
    var aData = $('#odvModalDeleteImportProduct #ohdConfirmIDDelete').val();

    if(aData == ''){
        if(ptSeq == 'NODATA'){
            return;
        }

        $('#odvModalDeleteImportProduct').modal('show');
        $('#odvModalDeleteImportProduct #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + pkCode + ' (' + pkName + ')' + ptYesOnNo);
        aNewIdDelete                = ptSeq;
        aNewCodeDelete              = pkCode;
    }else{
        var aTexts                  = aData.substring(0, aData.length - 2);
        var aDataSplit              = aTexts.split(" , ");
        var aDataSplitlength        = aDataSplit.length;

        var aDataCode               = $('#odvModalDeleteImportProduct #ohdConfirmCodeDelete').val();
        var aTextsCode              = aDataCode.substring(0, aDataCode.length - 2);
        var aDataCodeSplit          = aTextsCode.split(" , ");
        var aDataCodeSplitLength    = aDataCodeSplit.length;

        $('#odvModalDeleteImportProduct').modal('show');
        var aNewIdDelete    = [];
        var aNewCodeDelete  = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
            aNewCodeDelete.push(aDataCodeSplit[$i]);
        }
    }
    
    $('#obtPDTImpConfirm').off('click');
    $('#obtPDTImpConfirm').on('click', function(){
        $.ajax({
            type    : "POST",
            url     : "productEventImportDelete",
            data    : {
                'tPkCode'       : aNewCodeDelete,
                'FNTmpSeq'      : aNewIdDelete ,
                'tTableName'    : $('#ohaTabActiveProduct').val()
            },
            cache   : false,
            timeout : 0,
            success : function(oResult){
                var aData = $.parseJSON(oResult);
                if(aData['tCode'] == '1'){
                    $('#odvModalDeleteImportProduct').modal('hide');
                    $('#odvModalDeleteImportProduct #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val());
                    $('#odvModalDeleteImportProduct #ohdConfirmIDDelete').val('');
                    $('#odvModalDeleteImportProduct #ohdConfirmCodeDelete').val('');
                    localStorage.removeItem('LocalItemData');

                    setTimeout(function() {
                        JSxPDTSearchImportDataTable(ptTableName);
                        JSxPDTImportGetItemAll();
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

//ค้นหา
function JSxPDTSearchImportDataTable(ptTableName){
    if(ptTableName == '' || ptTableName == null){
        var ptTableName = $('#ohaTabActiveProduct').val();
    }
        
    switch(ptTableName){
        case 'TCNMPDT':
            var tTablerefresh = '#otdTablePDT';
        break;
        case 'TCNMPdtUnit':
            var tTablerefresh = '#otdTablePDTUnit';
        break;
        case 'TCNMPdtBrand':
            var tTablerefresh = '#otdTablePDTBrand';
        break;
        case 'TCNMPdtType':
            var tTablerefresh = '#otdTablePdtType';
        break;
        case 'TCNMPdtModel':
            var tTablerefresh = '#otdTablePdtModel';
        break;
        case 'TCNMPdtGrp':
            var tTablerefresh = '#otdTablePdtGrp';
        break;
        case 'TCNMPdtTouchGrp':
            var tTablerefresh = '#otdTablePDTTouchGroup';
        break;
    }
    
    $oNewJqueryVersion(tTablerefresh).DataTable().ajax.reload();
    $oNewJqueryVersion('#otdTablePDT').DataTable().ajax.reload();
}

//เวลากดลบ จะ มีการสลับ Text เอาไว้ว่าลบแบบ single หรือ muti
function JSxPDTImportTextinModal() {
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
        $('#odvModalDeleteImportProduct #ospConfirmDelete').html(tConfirm);
        $('#odvModalDeleteImportProduct #ohdConfirmIDDelete').val(tTextSeq);
        $('#odvModalDeleteImportProduct #ohdConfirmCodeDelete').val(tTextCode);
    }
}

//ย้ายจากข้อมูล Tmp ลง Master
function JSxPDTImportMoveMaster(){
    var tTypeCaseDuplicate = $("input[name='orbPDTCaseInsAgain']:checked").val();
    $.ajax({
        type    : "POST",
        url     : "productEventImportMove2Master",
        data    : { 'tTypeCaseDuplicate' : tTypeCaseDuplicate },
        cache   : false,
        timeout : 0,
        success : function(oResult){
            console.log(oResult);
            $('#odvModalImportFile').modal('hide');
            setTimeout(function() {
                JSvCallPageProductDataTable();
            }, 500);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

JSxPDTImportGetItemAll();
function JSxPDTImportGetItemAll(){
    $.ajax({
        type    : "POST",
        url     : "productGetItemAllImport",
        data    : {  'tTabName' : $('#ohaTabActiveProduct').val() },
        cache   : false,
        timeout : 0,
        success : function(oReturn){
            var oResult = JSON.parse(oReturn);
            var TYPESIX = oResult[0].TYPESIX;
            var TYPEONE = oResult[0].TYPEONE;
            var ITEMALL = oResult[0].ITEMALL;

            var tTextShow = "รอการนำเข้า " + TYPEONE + ' / ' + ITEMALL + ' รายการ - อัพเดทข้อมูล ' + TYPESIX + ' / ' + ITEMALL + ' รายการ';
            $('#ospTextSummaryImport').text(tTextShow);

            if(TYPEONE == 0 && TYPESIX == 0){
                $('#obtIMPConfirm').attr('disabled',true);
            }else{
                $('#obtIMPConfirm').attr('disabled',false);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

</script>