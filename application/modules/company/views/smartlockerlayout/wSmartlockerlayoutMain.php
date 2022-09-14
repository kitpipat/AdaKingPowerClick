<style>
    .NumberDuplicate{
        font-size   : 15px !important;
        color       : red;
        font-style  : italic;
    }

    .xCNSearchpadding{
        padding     : 0px 3px;
    }

    .xCNDisabledDelete{
        cursor: no-drop;
        opacity: 0.3;
        pointer-events: none;
    }
</style>
<input type="hidden" id="oetSMLBranch" name="oetSMLBranch" value='<?=$tBchCode?>'>
<input type="hidden" id="oetSMLShop" name="oetSMLShop" value='<?=$tShpCode?>'>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p style="font-weight: bold;"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitle')?></p>
    </div>

    <!--ปุ่มเพิ่ม-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <button id="obtSMLLayout" name="obtSMLLayout" class="xCNBTNPrimeryPlus" type="button" style="margin-left: 20px; margin-top: 0px;" onclick="JSxShopmodalInsertSMLlayout()">+</button>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>

    <!--ฟิลเตอร์ค้นหา-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

        <div class="row" style="margin: 0px;">
            <!--กลุ่มช่อง-->
            <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3 xCNSearchpadding">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup')?></label>
                    <select class="form-control" id="osmSMLLayoutGroup">
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?></option>
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutSelectAll')?></option>
                        <?php 
                            $aLayoutGroup = explode(",",$tSearchLayoutGroup); 
                            if($tSearchLayoutGroup != ''){
                                for($i=0; $i<FCNnHSizeOf($aLayoutGroup); $i++){ 
                                    $aNewLayoutGroup = explode(":",$aLayoutGroup[$i]); 
                                ?>
                                    <option value="<?=$aNewLayoutGroup[0]?>"><?=$aNewLayoutGroup[1]?></option>
                            <?php }}else{ ?>
                                
                            <?php } ?>
                    </select>
                </div>
            </div>

            <!--ช่อง-->
            <div class="col-xs-2 col-sm-2 col-md-3 col-lg-3 xCNSearchpadding">
                <div class="form-group">
                    <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleBox')?></label>
                    <select class="form-control" id="osmSMLLayoutColumn">
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutPleaseSelect')?></option>
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutSelectAll')?></option>
                        <?php 
                            $aLayoutColumn = explode(",",$tSearchLayoutColumn); 
                            if($tSearchLayoutColumn != ''){
                                for($i=0; $i<FCNnHSizeOf($aLayoutColumn); $i++){ ?>
                                    <option value="<?=$aLayoutColumn[$i]?>"><?=$aLayoutColumn[$i]?></option>
                            <?php }}else{ ?>
                                
                            <?php } ?>
                    </select>
                </div>
            </div>

            <!--ชั้น-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleFloor')?></label>
                <input type="text" id="oetSearchSMLFloor" name="oetSearchSMLFloor" placeholder='<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleFloor')?>'>
            </div>

            <!--คอลัมน์-->
            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn')?></label>
                <input type="text" id="oetSearchSMLColumn" name="oetSearchSMLColumn" placeholder='<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn')?>'>
            </div>

            <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 xCNSearchpadding">
                <label class="xCNLabelFrm" style="width:100%; color:#FFF !important;">.</label>
                <button id="obtSearchSMLLayout" class="btn xCNBtnSearch" type="button" onclick="">
                    <img class="" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
                </button>
            </div>
        </div>
    </div>

    <!--ตัวเลือก-->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
        <label class="xCNLabelFrm" style="width:100%; color:#FFF !important;">.</label>
        <?php if($aAlwEventSML['tAutStaFull'] == 1 || $aAlwEventSML['tAutStaDelete'] == 1 ) : ?>
            <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                    <?=language('common/main/main','tCMNOption')?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li id="oliBtnDeleteAll" class="disabled">
                        <a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?=language('common/main/main','tDelAll')?></a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!--content-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvContentSMLLayoutDataTable"></div>
    </div>
</div>

<!--Modal Insert-->
<?php $tSesUserLevel = $this->session->userdata("tSesUsrLevel"); ?>
<div id="odvModalInsertSMLLayout" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeadInsert xCNTextModalHeard"><?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutModalTitle')?></label>
            </div>
            <div class="modal-body">
                <div class="row">
                    
                    <!--ซ่อนค่า-->
                    <input type='hidden' id="ohdSMLEventpage">
                    <input type='hidden' id="ohdSMLOldLayno">
                    <input type='hidden' id="ohdSMLOldBch">
                    <input type='hidden' id="ohdSMLOldShp">

                    <!--สาขาที่มีผล-->
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch');?></label>
                            <?php if($tNameBch == '' && $tSesUserLevel == 'HQ'){ ?>
                                <div class="input-group">
                                    <input name="oetInputSMLBchName" id="oetInputSMLBchName" class="form-control xCNRemoveValue"  type="text" readonly="" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSMLLayoutTableBch')?>">
                                    <input name="oetInputSMLBchCode" id="oetInputSMLBchCode" class="form-control xCNHide xCNRemoveValue"  type="text" >
                                    <span class="input-group-btn">
                                        <button class="btn xCNBtnBrowseAddOn" id="obtSMLBrowseBranch" type="button">
                                            <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                        </button>
                                    </span>
                                </div>
                            <?php }else{ ?>
                                <input type="text" class="form-control" disabled value="<?=$tNameBch['raItems']['FTBchName']?>">
                                <input name="oetInputSMLBchCode" id="oetInputSMLBchCode" class="form-control xCNHide" type="hidden" value="<?=$tNameBch['raItems']['FTBchCode']?>" >
                            <?php } ?>
                        </div>
                    </div>

                    <!--กลุ่มช่อง-->
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup');?></label>
                            <div class="input-group">
                                <input name="oetInputSMLGroupName" id="oetInputSMLGroupName" class="form-control xCNRemoveValue"  type="text" readonly="" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSMLLayoutTitleGroup')?>">
                                <input name="oetInputSMLGroupCode" id="oetInputSMLGroupCode" class="form-control xCNHide xCNRemoveValue"  type="text" >
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="obtSMLBrowseGroup" type="button">
                                        <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--ขนาด-->
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableSize');?></label>
                            <div class="input-group">
                                <input name="oetInputSMLSizeName" id="oetInputSMLSizeName" class="form-control xCNRemoveValue"  type="text" readonly="" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSMLLayoutTableSize')?>">
                                <input name="oetInputSMLSizeCode" id="oetInputSMLSizeCode" class="form-control xCNHide xCNRemoveValue"  type="text" >
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn" id="obtSMLBrowseSize" type="button">
                                        <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!--ชื่อช่อง-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableName');?></label>
                        <input type="text" class="form-control xCNRemoveValue" maxlength="225" id="oetSMLName" name="oetSMLName" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableName');?>">
                    </div>

                    <!--หมายเลขช่อง-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutModalBox');?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithDecimal xCNRemoveValue" maxlength="3" id="oetSMLLayno" name="oetSMLLayno" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutModalBox');?>">
                        <label class="NumberDuplicate" id="olaNumberDuplicate"><?=language('company/smartlockerlayout/smartlockerlayout','tNumberDuplicate');?></label>
                    </div>

                    <!--สัดส่วนแนวนอน-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleHorizontal');?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithoutDecimal xCNRemoveValue" maxlength="5" id="oetSMLScaleVertical" name="oetSMLScaleVertical" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleHorizontalplaceholder');?>">
                    </div>

                    <!--สัดส่วนแนวตั้ง-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleVertical');?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithoutDecimal xCNRemoveValue" maxlength="5" id="oetSMLScaleHorizontal" name="oetSMLScaleHorizontal" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableScaleVerticalplaceholder');?>">
                    </div>

                    <!--ชั้นที่-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableFloor');?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithDecimal xCNRemoveValue" maxlength="3" id="oetSMLFloor" name="oetSMLFloor" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableFloor');?>">
                    </div>

                    <!--คอลัมน์-->
                    <div class="col-lg-6 col-md-6 col-xs-6" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn');?></label>
                        <input type="text" style="text-align: right;" class="form-control xCNInputNumericWithDecimal xCNRemoveValue" maxlength="3" id="oetSMLColumn" name="oetSMLColumn" placeholder="<?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleColumn');?>">
                        <label class="NumberDuplicate" id="olaColumnDuplicate"><?=language('company/smartlockerlayout/smartlockerlayout','tColumnDuplicate');?></label>
                    </div>

                    <!--หมายเหตุ-->
                    <div class="col-lg-12 col-md-12 col-xs-12" style="margin-bottom: 15px;">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableReason');?></label>
                        <textarea class="form-control xCNRemoveValue" maxlength="225" rows="2" id="otaSMLRemark" name="otaSMLRemark"></textarea>
                    </div>

                    <!--สถานะ-->
                    <div class="col-lg-6 col-md-6 col-xs-6">
                        <div>
							<div class="validate-input">
								<label class="fancy-checkbox">
									<input type="checkbox" id="ocbSMLStatus" name="ocbSMLStatus" checked="true">
									<span> <?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutModalFlagStatus');?></span>
								</label>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" onclick="JSxSMLInsertLayout();"><?=language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal" onclick="JSxSMLCloseModal();"><?=language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<!--End Modal Insert-->

<!--Modal Delete Single-->
<div id="odvModalDeleteSingleSmartLockerLayout" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDeleteSmartLockerLayout"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDeleteSmartLockerLayout" type="button" class="btn xCNBTNPrimery osmConfirmDeleteSmartLockerLayout"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult osmCancleDeleteSmartLockerLayout" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Single-->

<!--Modal Delete Mutirecord-->
<div id="odvModalDeleteMutirecord" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDeleteMutirecord"> - </span>
				<input type='hidden' id="ohdConfirmIDDeleteMutirecordLayno">
                <input type='hidden' id="ohdConfirmIDDeleteMutirecordBCH">
                <input type='hidden' id="ohdConfirmIDDeleteMutirecordSHP">
			</div>
			<div class="modal-footer">
				<button id="osmConfirmDeleteMutirecord" type="button" class="btn xCNBTNPrimery" onclick="JSxSMLDeleteMutirecord();"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Mutirecord-->

<?php include "script/jSmartlockerlayoutMain.php"; ?>

<script>
    //Modal Insert
    function JSxShopmodalInsertSMLlayout(){
        $('#odvModalInsertSMLLayout').modal('show');
        $('.xCNRemoveValue').val('');
        $('.NumberDuplicate').hide();
        $('.xCNTextModalHeadInsert').text('<?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutModalTitle')?>');
        $('#ohdSMLEventpage').val('Insert');
    }

    //Browse สาขา
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    var tBchCode    = "<?=$tWhereBranch?>";
    var oSMLBrowseBranch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        Where   : {
            Condition : ["AND TCNMBranch.FTBchCode IN ("+tBchCode+") "]
        },
        GrideView   : {
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetInputSMLBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetInputSMLBchName","TCNMBranch_L.FTBchName"],
        },
        NextFunc:{
            FuncName    :'JSvCallPageModalInserRack',
            ArgReturn   :['FTBchCode']
        },
        // DebugSQL : true
    }
    $('#obtSMLBrowseBranch').click(function(){ 
        JCNxBrowseData('oSMLBrowseBranch'); 
        $('#odvModalInsertSMLLayout').modal('hide');
        JCNxCloseLoading();
    });

    //Browse กลุ่มช่อง
    var oSMLBrowseRack = {
        Title   : ['company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup'],
        Table   : {Master:'TRTMShopRack',PK:'FTRakCode',PKName:'FTRakCode'},
        Join    : {
            Table   : ['TRTMShopRack_L'],
            On      : ['TRTMShopRack_L.FTRakCode = TRTMShopRack.FTRakCode AND TRTMShopRack_L.FNLngID = '+nLangEdits,]
        },
        GrideView   : {
            ColumnPathLang	: 'company/smartlockerlayout/smartlockerlayout',
            ColumnKeyLang	: ['tBrowseRackCode','tBrowseRackName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TRTMShopRack.FTRakCode','TRTMShopRack_L.FTRakName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TRTMShopRack.FTRakCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetInputSMLGroupCode","TRTMShopRack.FTRakCode"],
            Text		: ["oetInputSMLGroupName","TRTMShopRack_L.FTRakName"],
        },
        NextFunc:{
            FuncName    :'JSvCallPageModalInserRack',
            ArgReturn   :['FTRakCode']
        },
        RouteAddNew : 'rack',
        BrowseLev   : 2
        // DebugSQL : true
    }
    $('#obtSMLBrowseGroup').click(function(){ 
        JCNxBrowseData('oSMLBrowseRack'); 
        $('#odvModalInsertSMLLayout').modal('hide');
        JCNxCloseLoading();
    });

    //Browse ขนาด
    var oSMLBrowseSize = {
        Title   : ['company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableSize'],
        Table   : {Master:'TRTMShopSize',PK:'FTPzeCode',PKName:'FTPzeCode'},
        Join    : {
            Table   : ['TRTMShopSize_L'],
            On      : ['TRTMShopSize_L.FTSizCode = TRTMShopSize.FTPzeCode AND TRTMShopSize_L.FNLngID = '+nLangEdits,]
        },
        GrideView   : {
            ColumnPathLang	: 'company/smartlockerlayout/smartlockerlayout',
            ColumnKeyLang	: ['tBrowseRackCode','tBrowseRackName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TRTMShopSize.FTPzeCode','TRTMShopSize_L.FTSizName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TRTMShopSize.FTPzeCode'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetInputSMLSizeCode","TRTMShopSize.FTPzeCode"],
            Text		: ["oetInputSMLSizeName","TRTMShopSize_L.FTSizName"],
        },
        NextFunc:{
            FuncName    :'JSvCallPageModalInserRack',
            ArgReturn   :['FTPzeCode']
        },
        // DebugSQL : true
    }
    $('#obtSMLBrowseSize').click(function(){ 
        JCNxBrowseData('oSMLBrowseSize'); 
        $('#odvModalInsertSMLLayout').modal('hide');
        JCNxCloseLoading();
    });

    //Modal Open
    function JSvCallPageModalInserRack(elem){
        //setTimeout(function(){
            $('#odvModalInsertSMLLayout').modal('show');
        //}, 1000);
    }

    //Insert
    function JSxSMLInsertLayout(){
        var tBch                = $('#oetInputSMLBchCode').val();
        var tRack               = $('#oetInputSMLGroupCode').val();
        var tSize               = $('#oetInputSMLSizeCode').val();
        var tLayno              = $('#oetSMLLayno').val();
        var nScaleVertical      = $('#oetSMLScaleVertical').val();
        var nScaleHorizontal    = $('#oetSMLScaleHorizontal').val();
        var nFloor              = $('#oetSMLFloor').val();
        var nColumn             = $('#oetSMLColumn').val();
        var tSMLRemark          = $('#otaSMLRemark').val();
        var tLayoutName         = $('#oetSMLName').val();
        var tEventPage          = $('#ohdSMLEventpage').val();
        if ($('#ocbSMLStatus').is(":checked")){
            var tStatus = 1;
        }else{
            var tStatus = 2;
        }

        if(nColumn == ''){$('#oetSMLColumn').focus();}
        if(nFloor == ''){$('#oetSMLFloor').focus();}
        if(nScaleHorizontal == ''){$('#oetSMLScaleHorizontal').focus();}
        if(nScaleVertical == ''){ $('#oetSMLScaleVertical').focus();}
        if(tLayno == ''){$('#oetSMLLayno').focus();}
        if(tLayoutName == ''){ $('#oetSMLName').focus(); }
        if(tSize == ''){$('#oetInputSMLSizeName').focus();}
        if(tRack == ''){$('#oetInputSMLGroupName').focus();}
        if(tBch == ''){$('#oetInputSMLBchName').focus();}

        if(tBch != '' && tRack != '' && tSize != '' && tLayno != '' && nScaleVertical != '' && nScaleHorizontal != '' && nFloor != '' && nColumn != '' && tLayoutName != ''){
            JCNxOpenLoading();
            if(tEventPage == 'Insert'){
                tRoute          = "SHPSmartLockerLayoutInsert";
                tSMLOldLayno    = null;
                tSMLOldBch      = null;
                tSMLOldShp      = null;
            }else if(tEventPage == 'Edit'){
                tRoute          = "SHPSmartLockerLayoutEdit";
                tSMLOldLayno    = $('#ohdSMLOldLayno').val();
                tSMLOldBch      = $('#ohdSMLOldBch').val();
                tSMLOldShp      = $('#ohdSMLOldShp').val();
            }
            $.ajax({
                type    : "POST",
                url     : tRoute,
                data    : {
                    tShp                : $('#oetSMLShop').val(),
                    tLayoutName         : tLayoutName,
                    tSMLRemark          : tSMLRemark,
                    tBch                : tBch,
                    tRack               : tRack,
                    tSize               : tSize,
                    tLayno              : tLayno,
                    nScaleVertical      : nScaleVertical,
                    nScaleHorizontal    : nScaleHorizontal,
                    nFloor              : nFloor,
                    nColumn             : nColumn,
                    tStatus             : tStatus,
                    tSMLOldLayno        : tSMLOldLayno,
                    tSMLOldBch          : tSMLOldBch,
                    tSMLOldShp          : tSMLOldShp
                },
                cache   : false,
                Timeout : 0,
                async   : false,
                success : function(tResult){
                    //1 ช่องซ้ำ
                    //2 คอลั่ม และ ชั่น ซ้ำ
                    if(tResult == 1){
                        $('#olaNumberDuplicate').show();
                        $('#olaColumnDuplicate').hide();
                        $('#oetSMLLayno').focus();
                    }else if(tResult == 2){
                        $('#olaNumberDuplicate').hide();
                        $('#olaColumnDuplicate').show();
                        $('#oetSMLColumn').focus();
                    }else{
                        JSvSMLList(1);
                        $('#odvModalInsertSMLLayout').modal('hide');
                        JCNxCloseLoading();
                        JCNvReturnSearch();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }



</script>