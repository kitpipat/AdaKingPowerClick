<?php
    $tDangerMsg     = "<span class='text-danger' style='font-weight: bold;'>*</span>";
    $tPrimaryMsg    = "<span class='text-primary' style='font-weight: bold;'>*</span>";
?>

<div class="row">
    <div class="col-xs-12 col-md-4 col-lg-4">
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
    <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
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
    <div class="col-md-12">
        <div>
            <div class="custom-tabs-line tabs-line-bottom left-aligned">
                <ul class="nav" role="tablist">
                    <li class="nav-item active"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponHD" data-toggle="tab" href="#odvCPHImportHD" role="tab" aria-expanded="false">เงื่อนไข</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponDT" data-toggle="tab" href="#odvCPHImportDT" role="tab" aria-expanded="false">กำหนดคูปอง</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponHDBch" data-toggle="tab" href="#odvCPHImportHDBch" role="tab" aria-expanded="false">กำหนดพิเศษ - สาขา</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponHDCstPri" data-toggle="tab" href="#odvCPHImportHDCstPri" role="tab" aria-expanded="false">กำหนดพิเศษ - กลุ่มราคา</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponHDPdt" data-toggle="tab" href="#odvCPHImportHDPdt" role="tab" aria-expanded="false">กำหนดพิเศษ - สินค้า</a></li>
                    <li class="nav-item"><a class="nav-link flat-buttons xCNEventTab" data-hiddenID="TFNTCouponHDBrand" data-toggle="tab" href="#odvCPHImportHDBrand" role="tab" aria-expanded="false">กำหนดพิเศษ - ยี่ห้อ</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="tab-content">
                    <!--Content HD-->
                    <div class="tab-pane active" id="odvCPHImportHD" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otbCPHTableImportHD" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "ประเภทคูปอง";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "ชื่อคูปอง";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "รหัสอ้างอิง<br>บัญชีของคูปอง";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "ข้อความแสดง<br>บนคูปอง บรรทัดที่ 1";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "ข้อความแสดง<br>บนคูปอง บรรทัดที่ 2";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "ประเภทส่วนลด";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "กลุ่มราคา";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "มูลค่าส่วนลด";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "วันที่เริ่ม";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "วันที่สิ้นสุด";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "เวลาเริ่ม<br>ใช้งาน";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "เวลาสิ้นสุด<br>ใช้งาน";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "ยอดต่ำสุด<br>ที่สามารถใช้ได้";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "จำนวนจำกัด<br>การใช้ต่อบิล";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "อนุญาตคำนวณ<br>รวมสินค้าโปรโมชั่น";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "ตรวจสอบลูกค้า";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Content HD-->
                    <!--Content DT-->
                    <div class="tab-pane" id="odvCPHImportDT" role="tabpanel" aria-expanded="true" style="padding: 10px 0px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped nowrap" id="otbCPHTableImportDT" style="width:100% !important;">
                                        <thead>
                                            <tr>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo  language('company/branch/branch','tBCHChoose');?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?=$tPrimaryMsg?><?php echo "รหัสคูปอง";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "จำนวนครั้งที่ใช้ได้";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo "หมายเหตุ";?></th>
                                                <th nowrap class="xCNTextBold" style="text-align:center;vertical-align: middle;"><?php echo  language('common/main/main','tCMNActionDelete');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Content DT-->
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohaTabActiveCoupon" id="ohaTabActiveCoupon" value="TFNTCouponHD">

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

    JSxRenderDataTable_HD();
    JSxRenderDataTable_DT();

    //Render HTML
    function JSxRenderDataTable_HD(){
        localStorage.removeItem("LocalItemData");
        $.ajax({
            type		: "POST",
            url			: "dcmCPHEventGetDataImport",
            async       : false,
            data: {
                'tType'                 : 'TFNTCouponHD',
                'nPageNumber'           : 1, /*data.draw - 1*/
                'tSearch'               : $('#oetPDTImpSearchAll').val()
            },
        }).success(function(response) {

            // console.log(response.data.aResult);

            $('#otbCPHTableImportHD tbody tr').remove();

            var nResult = response.data.aResult.length;
            for(var i=0; i<nResult; i++){

                var FNTmpSeq                = response.data.aResult[i].FNTmpSeq;
                var FTTmpStatus             = response.data.aResult[i].FTTmpStatus;
                var FTCphDocNo              = response.data.aResult[i].FTCphDocNo;
                var FTCptName               = response.data.aResult[i].FTCptName;
                var FTCpnName               = response.data.aResult[i].FTCpnName;
                var FTCphRefAccCode         = response.data.aResult[i].FTCphRefAccCode;
                var FTCpnMsg1               = response.data.aResult[i].FTCpnMsg1;
                var FTCpnMsg2               = response.data.aResult[i].FTCpnMsg2;
                var FTCphDisType            = response.data.aResult[i].FTCphDisType;
                var FTPplName               = response.data.aResult[i].FTPplName;
                var FCCphDisValue           = response.data.aResult[i].FCCphDisValue;
                var FDCphDateStart          = response.data.aResult[i].FDCphDateStart;
                var FDCphDateStop           = response.data.aResult[i].FDCphDateStop;
                var FTCphTimeStart          = response.data.aResult[i].FTCphTimeStart;
                var FTCphTimeStop           = response.data.aResult[i].FTCphTimeStop;
                var FCCphMinValue           = response.data.aResult[i].FCCphMinValue;
                var FNCphLimitUsePerBill    = response.data.aResult[i].FNCphLimitUsePerBill;
                var FTCphStaOnTopPmt        = response.data.aResult[i].FTCphStaOnTopPmt;
                var FTStaChkMember          = response.data.aResult[i].FTStaChkMember;

                var tCphDisType = "N/A";
                switch(FTCphDisType){
                    case '1':
                        tCphDisType = "ลดบาท";
                        break;
                    case '2':
                        tCphDisType = "ลดเปอร์เซ็นต์";
                        break;
                    default:
                        tCphDisType = "ใช้กลุ่มราคา";
                        break;
                }

                var tStaChkMember = "N/A";
                switch(FTStaChkMember){
                    case '1':
                        tStaChkMember = "ตรวจสอบ";
                        break;
                    default:
                        tStaChkMember = "ไม่ตรวจสอบ";
                        break;
                }

                var tCphStaOnTopPmt = "N/A";
                switch(FTCphStaOnTopPmt){
                    case '1':
                        tCphStaOnTopPmt = "อนุญาตคำนวณ";
                        break;
                    default:
                        tCphStaOnTopPmt = "ไม่อนุญาตคำนวณ";
                        break;
                }

                if(FTTmpStatus != 1){
                    var tStyleList  = "color:red !important; font-weight:bold;"; 
                }else{
                    var tStyleList  = '';
                }

                var FTTmpRemark     = response.data.aResult[i].FTTmpRemark;
                var aRemark         = FTTmpRemark.split("$&");
                if(typeof aRemark[0] !== 'undefined'){
                    if(aRemark[0] == '' || aRemark[0] == null){

                    }else{
                        if(aRemark[0].indexOf('[') !== -1){
                            aRemarkIndex = aRemark[0].split("[");
                            aRemarkIndex = aRemarkIndex[1].split("]");
                            FTTmpRemark  = aRemark[1];
                            switch(aRemarkIndex[0]){
                                case '0':
                                    FTCptName      = aRemark[2];
                                    break;
                                case '5':
                                    tCphDisType    = aRemark[2];
                                    break;
                                
                            }
                        }
                    }
                }

                // var FTTmpRemark     = "<label style='"+tStyleList+"'>"+FTTmpRemark+"<label>";
                var tNameShowDelete = FTCpnName.replace(/\s/g, '');
                var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTCphDocNo+"','"+tNameShowDelete+"','TFNTCouponHD')";
                var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                var tRender = "";
                tRender += "<tr>";
                tRender += "    <td nowrap>";
                tRender += "        <label class='fancy-checkbox' style='text-align: center;'>";
                tRender += "            <input id='ocbListItem"+FNTmpSeq+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-table='TFNTCouponHD' data-name='"+FTCpnName+"' data-seq='"+FNTmpSeq+"' >"; /*data-table='TFNTCouponHD' data-name='"+FTCpnName+"' data-seq='"+FNTmpSeq+"'*/
                tRender += "            <span></span>";
                tRender += "        </label>";
                tRender += "    </td>";
                tRender += "    <td nowrap>"+FTCptName+"</td>";
                tRender += "    <td nowrap>"+(FTCpnName == '' || FTCpnName == null ? 'N/A' : FTCpnName)+"</td>";
                tRender += "    <td nowrap>"+(FTCphRefAccCode == '' || FTCphRefAccCode == null ? 'N/A' : FTCphRefAccCode)+"</td>";
                tRender += "    <td nowrap>"+(FTCpnMsg1 == '' || FTCpnMsg1 == null ? 'N/A' : FTCpnMsg1)+"</td>";
                tRender += "    <td nowrap>"+(FTCpnMsg2 == '' || FTCpnMsg2 == null ? 'N/A' : FTCpnMsg2)+"</td>";
                tRender += "    <td nowrap>"+tCphDisType+"</td>";
                tRender += "    <td nowrap>"+(FTPplName == '' || FTPplName == null ? 'N/A' : FTPplName)+"</td>";
                tRender += "    <td nowrap class='text-right'>"+FCCphDisValue+"</td>";
                tRender += "    <td nowrap class='text-center'>"+FDCphDateStart+"</td>";
                tRender += "    <td nowrap class='text-center'>"+FDCphDateStop+"</td>";
                tRender += "    <td nowrap class='text-center'>"+FTCphTimeStart+"</td>";
                tRender += "    <td nowrap class='text-center'>"+FTCphTimeStop+"</td>";
                tRender += "    <td nowrap class='text-right'>"+FCCphMinValue+"</td>";
                tRender += "    <td nowrap class='text-right'>"+FNCphLimitUsePerBill+"</td>";
                tRender += "    <td nowrap>"+tCphStaOnTopPmt+"</td>";
                tRender += "    <td nowrap>"+tStaChkMember+"</td>";
                tRender += "    <td nowrap><label style='"+tStyleList+"'>"+FTTmpRemark+"<label></td>";
                tRender += "    <td nowrap>"+tImgDelete+"</td>";
                tRender += "</tr>";
                $('#otbCPHTableImportHD tbody').append(tRender);

            }

            setTimeout(function(){
                JCNxCloseLoading();
            }, 100);

        });
    }

    function JSxRenderDataTable_DT(){
        localStorage.removeItem("LocalItemData");
        $.ajax({
            type		: "POST",
            url			: "dcmCPHEventGetDataImport",
            async       : false,
            data: {
                'tType'                 : 'TFNTCouponDT',
                'nPageNumber'           : 1, /*data.draw - 1*/
                'tSearch'               : $('#oetPDTImpSearchAll').val()
            },
        }).success(function(response) {

            $('#otbCPHTableImportDT tbody tr').remove();

            var nResult = response.data.aResult.length;
            for(var i=0; i<nResult; i++){
                var FTCpdBarCpn             = response.data.aResult[i].FTCpdBarCpn;
                var FNCpdSeqNo              = response.data.aResult[i].FNCpdSeqNo;
                var FNCpdAlwMaxUse          = response.data.aResult[i].FNCpdAlwMaxUse;
                var FNTmpSeq                = response.data.aResult[i].FNTmpSeq;
                var FTTmpStatus             = response.data.aResult[i].FTTmpStatus;

                if(FTTmpStatus != 1){
                    var tStyleList  = "color:red !important; font-weight:bold;"; 
                }else{
                    var tStyleList  = '';
                }

                var FTTmpRemark     = response.data.aResult[i].FTTmpRemark;
                var aRemark         = FTTmpRemark.split("$&");
                if(typeof aRemark[0] !== 'undefined'){
                    if(aRemark[0] == '' || aRemark[0] == null){

                    }else{
                        if(aRemark[0].indexOf('[') !== -1){
                            aRemarkIndex = aRemark[0].split("[");
                            aRemarkIndex = aRemarkIndex[1].split("]");
                            FTTmpRemark  = aRemark[1];
                            switch(aRemarkIndex[0]){
                                case '0':
                                    FTCpdBarCpn      = aRemark[2];
                                    break;
                                
                            }
                        }
                    }
                }

                var tNameShowDelete = FTCpdBarCpn.replace(/\s/g, '');
                var oEventDelete    = "onClick=JSxPDTDeleteImportList('"+FNTmpSeq+"','"+FTCpdBarCpn+"','"+tNameShowDelete+"','TFNTCouponDT')";
                var tImgDelete      = "<img style='display: block; margin: 0px auto;' class='xCNIconTable xCNIconDel' "+oEventDelete+" src='<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>'>";

                var tRender = "";
                tRender += "<tr>";
                tRender += "    <td nowrap>";
                tRender += "        <label class='fancy-checkbox' style='text-align: center;'>";
                tRender += "            <input id='ocbListItem"+FNTmpSeq+"' type='checkbox' class='ocbListItem' name='ocbListItem[]' data-table='TFNTCouponDT' data-name='"+FTCpdBarCpn+"' data-seq='"+FNTmpSeq+"' >";
                tRender += "            <span></span>";
                tRender += "        </label>";
                tRender += "    </td>";
                tRender += "    <td nowrap>"+FTCpdBarCpn+"</td>";
                tRender += "    <td nowrap class='text-right'>"+FNCpdAlwMaxUse+"</td>";
                tRender += "    <td nowrap><label style='"+tStyleList+"'>"+FTTmpRemark+"<label></td>";
                tRender += "    <td nowrap>"+tImgDelete+"</td>";
                tRender += "</tr>";
                $('#otbCPHTableImportDT tbody').append(tRender);

            }

            setTimeout(function(){
                JCNxCloseLoading();
            }, 100);
        });

    }


    $('.xCNEventTab').click(function(e) {
        //ทุกครั้งที่กด Tab localstorage จะเคลียร์
        localStorage.removeItem("LocalItemData")
        $('.ocbListItem').prop('checked', false);
        // JSxShowButtonChoose();

        //เก็บค่าไว้
        var tHiddenID = $(this).attr('data-hiddenID');
        $('#ohaTabActiveCoupon').val(tHiddenID);
        JSxPDTImportGetItemAll();

        // $('#olbCaseAlreadyInSystem').html(aDataLang['tCaseDataInSys'].replace('xxx',$(this).html()));

        setTimeout(function(){
            JSxChkCaseAlreadyInSys();
        }, 100);
         
    });

    
    JSxPDTImportGetItemAll();
    function JSxPDTImportGetItemAll(){
        $.ajax({
            type    : "POST",
            url     : "dcmCPHEventGetItemAllImport",
            data    : {  'tTabName' : $('#ohaTabActiveCoupon').val() },
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

    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
            } else {
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            }
        }
    }

    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return 'Dupilcate';
            }
        }
        return 'None';
    }

    //กดเลือกลบทั้งหมด
    // $('#otbCPHTableImportHD , #otbCPHTableImportDT , tbody').on('click', '.ocbListItem', function (e) {
    $('.ocbListItem').off('click').on('click', function (e) {
        var nSeq  = $(this).data('seq');     //seq
        var nCode = $(this).data('table');    //code
        var tName = $(this).data('name');    //name

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

    
    //ฟังก์ชั่น Delete
    function JSxPDTDeleteImportList(ptSeq, ptCode , ptName, ptTableName) {
        var ptYesOnNo = '<?=language("common/main/main","tBCHYesOnNo");?>';
        var aData = $('#odvModalDeleteImportProduct #ohdConfirmIDDelete').val();

        if(aData == ''){
            if(ptSeq == 'NODATA'){
                return;
            }

            $('#odvModalDeleteImportProduct').modal('show');
            $('#odvModalDeleteImportProduct #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCode + ' (' + ptName + ')' + ptYesOnNo);
            aNewIdDelete                = ptSeq;
            aNewCodeDelete              = ptCode;
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
        
        // $('#obtPDTImpConfirm').off('click');
        $('#obtPDTImpConfirm').off('click').on('click', function(){
            var tTabActive = $('#ohaTabActiveCoupon').val();
            $.ajax({
                type    : "POST",
                url     : "dcmCPHEventImportDelete",
                data    : {
                    'tPkCode'       : aNewCodeDelete,
                    'FNTmpSeq'      : aNewIdDelete,
                    'tTableName'    : tTabActive
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
                            // JSxPDTSearchImportDataTable(ptTableName);
                            switch(tTabActive){
                                case 'TFNTCouponHD':
                                    JSxRenderDataTable_HD();
                                    break;
                                case 'TFNTCouponDT':
                                    JSxRenderDataTable_DT();
                                    break;
                            }
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

    //กดยืนยันการนำเข้า
    $('#obtIMPConfirm').off('click').on('click',function(){
        JSxCPHImportMoveMaster();
    });

    //ย้ายจากข้อมูล Tmp ลง Master
    function JSxCPHImportMoveMaster(){
        $.ajax({
            type    : "POST",
            url     : "dcmCPHEventImportMove2Master",
            data    : {},
            cache   : false,
            timeout : 0,
            success : function(oResult){
                // console.log(oResult);
                $('#odvModalImportFile').modal('hide');
                setTimeout(function() {
                    JSvCPHCallPageDataTable(1);
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>