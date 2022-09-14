<div class="panel-heading">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tSearch') ?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvLabPriDataTable()" placeholder="<?php echo language('customer/customerGroup/customerGroup', 'tCstGroupSearchData') ?>">
					<span class="input-group-btn">
						<button id="oimSearchLabPri" class="btn xCNBtnSearch" type="button" onclick="JSvLabPriDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('product/settingprinter/settingprinter', 'tSPTitle') ?></label>
			<div class="input-group">
				<input type='text' class='form-control xCNHide xWRptAllInput' id='oetPlbPrnSrvCode' name='oetPlbPrnSrvCode'>
				<input type="text" class="form-control  xCNInputMaskDate" readonly id="oetPlbPrnSrvName" name="oetPlbPrnSrvName" value="" placeholder="<?php echo language('product/settingprinter/settingprinter', 'tSPTitle') ?>">
				<span class="input-group-btn">
					<button id="obtPlbPrnSrvBrowse" type="button" class="btn xCNBtnDateTime" style="margin-top: -2px;">
						<img class="xCNIconFind"> </button>
				</span>
				<span class="input-group-btn">
					<button class="btn btn-info xWExportPrintSet" id="obtExportPrintSet" onclick="JSnLabPriExportChoose()" style="height: 35.7px;margin-left: 10px;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBExport') ?></button>
				</span>
				<span class="input-group-btn">
					<div id="odvMngTableList" class="btn-group xCNDropDrownGroup" style="margin-left: 10px;">
						<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown" style="padding-bottom: 1px !important;">
							<?php echo language('common/main/main', 'tCMNOption') ?>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li id="oliBtnDeleteAll" class="disabled">
								<a href="javascript:;" data-toggle="modal" data-target="#odvModalDelLabPri" onclick="JSxLabPriSetDataBeforeDelMulti()"><?php echo language('common/main/main', 'tCMNDeleteAll') ?></a>
							</li>
						</ul>
					</div>
				</span>
			</div>
			
		</div>
		
		
	</div>
</div>
<div class="panel-body">
	<section id="ostDataLabPri"></section>
</div>

<div class="modal fade" id="odvModalDelLabPri">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('common/main/main', 'tModalDelete') ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"></span>
				<span id="ospCode"></span>
				<span id="ospAgnCode"></span>
				<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
				<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
				<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnLabPriDelChoose()">
					<?= language('common/main/main', 'tModalConfirm') ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?= language('common/main/main', 'tModalCancel') ?>
				</button>
			</div>
		</div>
	</div>
</div>



<script>

	$('document').ready(function() {
		$('#obtExportPrintSet').prop('disabled', true);
	});

	var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

	// Click
    $('#obtPlbPrnSrvBrowse').click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oPrnBarPrnSrvBrowsOption = oPrnBarPrnSrvBrowse({
                'tReturnInputCode': 'oetPlbPrnSrvCode',
                'tReturnInputName': 'oetPlbPrnSrvName',
            });
            JCNxBrowseData('oPrnBarPrnSrvBrowsOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

	var oPrnBarPrnSrvBrowse = function(poReturnInputModel) {
        let tPrnSrvInputReturnCode = poReturnInputModel.tReturnInputCode;
        let tPrnSrvInputReturnName = poReturnInputModel.tReturnInputName;
        let tWhereCondition         = " AND FTSrvStaUse = '1' ";
        let tSesUsrAgnCode          = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

        if( tSesUsrAgnCode != "" ){
            tWhereCondition += " AND (TCNMPrnServer.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPrnServer.FTAgnCode,'') = '') ";
        }
        
        let oPrnBarPrnSrvOption = {
            Title: ['product/pdtmodel/pdtmodel', 'ปริ้นเตอร์เซิฟเวอร์'],
            Table: {
                Master: 'TCNMPrnServer',
                PK: 'FTSrvCode'
            },
            Join: {
                Table: ['TCNMPrnServer_L'],
                On: [
                    'TCNMPrnServer.FTSrvCode = TCNMPrnServer_L.FTSrvCode AND TCNMPrnServer.FTAgnCode = TCNMPrnServer_L.FTAgnCode AND TCNMPrnServer_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tWhereCondition]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtmodel/pdtmodel',
                ColumnKeyLang: ['รหัสปริ้นเตอร์เซิฟเวอร์', 'ชื่อปริ้นเตอร์เซิฟเวอร์'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMPrnServer.FTSrvCode', 'TCNMPrnServer_L.FTSrvName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPrnServer.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPrnSrvInputReturnCode, "TCNMPrnServer.FTSrvCode"],
                Text: [tPrnSrvInputReturnName, "TCNMPrnServer_L.FTSrvName"]
            },
        };
        return oPrnBarPrnSrvOption;
    }
</script>