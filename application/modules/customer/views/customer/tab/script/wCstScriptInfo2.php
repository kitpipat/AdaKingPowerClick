<script type="text/javascript">
var nCheckIntercalLeave;
$(document).ready(() => {
    $('#oimCstBrowseCgp').click(function(){
		// Create By Witsarut 04/10/2019
		JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		oOptionReturnCgp = oCstBrowseCgp();
		JCNxBrowseData('oOptionReturnCgp');
	});

    $('#oimCstBrowseCty').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		oOptionReturnCty = oCstBrowseCty();
		JCNxBrowseData('oOptionReturnCty');
	});

    $('#oimCstBrowseClv').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		oOptionReturnClv = oCstBrowseClv();
		JCNxBrowseData('oOptionReturnClv');
	});

	$('#oimCstBrowseOcp').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		JCNxBrowseData('oCstBrowseOcp');
	});

    $('#oimCstBrowsePpl').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		oOptionReturnPpl = oCstBrowsePpl();
		JCNxBrowseData('oOptionReturnPpl');
	});

	$('#oimCstBrowsePmg').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		JCNxBrowseData('oCstBrowsePmg');
	});

    $('#oimCstBrowseBch').click(function(){
		// Create By Witsarut 04/10/2019
			JSxCheckPinMenuClose();
		// Create By Witsarut 04/10/2019
		oOptionReturnBch = oBchBrowseBch();
		JCNxBrowseData('oOptionReturnBch');
	});


	// Create BY Witsarut 26/11/2019
	// เพิ่มกลุ่มราคาขายส่ง
	$('#oimCstBrowseWhs').click(function(){
			JSxCheckPinMenuClose();
		JCNxBrowseData('oBchBrowseWhs');
	});

	// ขายออนไลน์
	$('#oimCstBrowseNet').click(function(){
			JSxCheckPinMenuClose();
		JCNxBrowseData('oBchBrowseNet');
	});





    JSxDisabledOrEnabledCstBch();
});
// Set Lang Edit
var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
// Option Reference
var oBchBrowseBch = function(){
	var tCondition = '';
	var tStaUsrLevel = "<?= $this->session->userdata("tSesUsrLevel"); ?>";
	var tAgnCode  = "<?= $this->session->userdata("tSesUsrAgnCode") ?>";
	var tBchCode  = "<?= $this->session->userdata("tSesUsrBchCodeMulti")?>";

	if(tStaUsrLevel != "HQ"){
		tCondition += " AND TCNMBranch.FTBchCode IN ("+tBchCode+") ";
    }
	var oBchBrowseBchReturn = {
		Title : ['company/branch/branch', 'tBCHTitle'],
		Table:{Master:'TCNMBranch', PK:'FTBchCode'},
		Join :{
			Table: ['TCNMBranch_L'],
			On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
		},
		Where :{
			Condition : [tCondition]
		},
		GrideView:{
			ColumnPathLang	: 'company/branch/branch',
			ColumnKeyLang	: ['tBCHCode', 'tBCHName'],
			ColumnsSize     : ['15%','75%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
			DataColumnsFormat : ['', ''],
			Perpage			: 10,
			OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstBchCode", "TCNMBranch.FTBchCode"],
			Text		: ["oetCstBchName", "TCNMBranch_L.FTBchName"]
		},
		RouteFrom : 'customer',
		RouteAddNew : 'branch',
		BrowseLev : nStaCstBrowseType
	}
	return oBchBrowseBchReturn;
}

var oCstBrowseCgp = function(){
	var tCondition = '';
	var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
	var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
	if(tStaUsrLevel != 'HQ'){
		if( tAgnCode != ''  && tAgnCode != undefined){
			tCondition += " AND TCNMCstGrp.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TCNMCstGrp.FTAgnCode,'') ='' ";
		}
	}

	var oCstBrowseCgpReturn = {
		Title : ['customer/customerGroup/customerGroup', 'tCstGrpTitle'],
		Table:{Master:'TCNMCstGrp', PK:'FTCgpCode'},
		Join :{
			Table: ['TCNMCstGrp_L'],
			On: ['TCNMCstGrp_L.FTCgpCode = TCNMCstGrp.FTCgpCode AND TCNMCstGrp_L.FNLngID = '+nLangEdits]
		},
		Where :{
			Condition : [tCondition]
		},
		GrideView:{
			ColumnPathLang	: 'customer/customerGroup/customerGroup',
			ColumnKeyLang	: ['tCstGrpCode', 'tCstGrpName'],
			ColumnsSize     : ['15%', '85%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMCstGrp.FTCgpCode', 'TCNMCstGrp_L.FTCgpName'],
			DataColumnsFormat : ['', ''],
			Perpage			: 10,
			OrderBy			: ['TCNMCstGrp.FDCreateOn DESC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstCgpCode", "TCNMCstGrp.FTCgpCode"],
			Text		: ["oetCstCgpName", "TCNMCstGrp_L.FTCgpName"]
		},
		RouteAddNew : 'customerGroup',
		BrowseLev : nStaCstBrowseType
	}
	return oCstBrowseCgpReturn;
}

var oCstBrowseCty = function(){
	var tCondition = '';
	var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
	var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
	if(tStaUsrLevel != 'HQ'){
		if( tAgnCode != ''  && tAgnCode != undefined){
			tCondition += " AND TCNMCstType.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TCNMCstType.FTAgnCode,'') ='' ";
		}
	}
	var oCstBrowseCtyReturn = {
		Title : ['customer/customerType/customerType', 'tCstTypeTitle'],
		Table:{Master:'TCNMCstType', PK:'FTCtyCode'},
		Join :{
			Table: ['TCNMCstType_L'],
			On: ['TCNMCstType_L.FTCtyCode = TCNMCstType.FTCtyCode AND TCNMCstType_L.FNLngID = '+nLangEdits]
		},
		Where :{
			Condition : [tCondition]
		},
		GrideView:{
			ColumnPathLang	: 'customer/customerType/customerType',
			ColumnKeyLang	: ['tCstTypeCode', 'tCstTypeName'],
			ColumnsSize     : ['15%', '85%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMCstType.FTCtyCode', 'TCNMCstType_L.FTCtyName'],
			DataColumnsFormat : ['', ''],
			Perpage			: 10,
			OrderBy			: ['TCNMCstType.FDCreateOn DESC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstCtyCode", "TCNMCstType.FTCtyCode"],
			Text		: ["oetCstCtyName", "TCNMCstType.FTCtyName"]
		},
		RouteAddNew : 'customerType',
		BrowseLev : nStaCstBrowseType
	}
	return oCstBrowseCtyReturn;
}

var oCstBrowseClv = function(){
	var tCondition = '';
	var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
	var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
	if(tStaUsrLevel != 'HQ'){
		if( tAgnCode != ''  && tAgnCode != undefined){
			tCondition += " AND TCNMCstLev.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TCNMCstLev.FTAgnCode,'') ='' ";
		}
	}
	var oCstBrowseClvReturn = {
		Title : ['customer/customerLevel/customerLevel', 'tCstLevTitle'],
		Table:{Master:'TCNMCstLev', PK:'FTClvCode'},
		Join :{
			Table: ['TCNMCstLev_L'],
			On: ['TCNMCstLev_L.FTClvCode = TCNMCstLev.FTClvCode AND TCNMCstLev_L.FNLngID = '+nLangEdits]
		},
		Where :{
			Condition : [tCondition]
		},
		GrideView:{
			ColumnPathLang	: 'customer/customerLevel/customerLevel',
			ColumnKeyLang	: ['tCstLevCode', 'tCstLevName'],
			ColumnsSize     : ['15%', '85%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMCstLev.FTClvCode', 'TCNMCstLev_L.FTClvName'],
			DataColumnsFormat : ['', ''],
			Perpage			: 10,
			OrderBy			: ['TCNMCstLev.FDCreateOn DESC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstClvCode", "TCNMCstLev.FTClvCode"],
			Text		: ["oetCstClvName", "TCNMCstLev.FTClvName"]
		},
		RouteAddNew : 'customerLevel',
		BrowseLev : nStaCstBrowseType
	}
	return oCstBrowseClvReturn;
}


var oCstBrowseOcp = {
	Title : ['customer/customerOcp/customerOcp', 'tCstOcpTitle'],
	Table:{Master:'TCNMCstOcp', PK:'FTOcpCode'},
	Join :{
		Table: ['TCNMCstOcp_L'],
		On: ['TCNMCstOcp_L.FTOcpCode = TCNMCstOcp.FTOcpCode AND TCNMCstOcp_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'customer/customerOcp/customerOcp',
		ColumnKeyLang	: ['tCstOcpCode', 'tCstOcpName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMCstOcp.FTOcpCode', 'TCNMCstOcp_L.FTOcpName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMCstOcp.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstCstOcpCode","TCNMCstOcp.FTOcpCode"],
		Text		: ["oetCstCstOcpName","TCNMCstOcp.FTOcpName"]
	},
	RouteAddNew : 'customerOcp',
	BrowseLev : nStaCstBrowseType
};

var oCstBrowsePpl = function(){
	var tCondition = '';
	var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
	var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
	if(tStaUsrLevel != 'HQ'){
		if( tAgnCode != ''  && tAgnCode != undefined){
			tCondition += " AND TCNMPdtPriList.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TCNMPdtPriList.FTAgnCode,'') ='' ";
		}
	}
	var oCstBrowsePplReturn = {
		Title : ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
		Table:{Master:'TCNMPdtPriList', PK:'FTPplCode'},
		Join :{
			Table: ['TCNMPdtPriList_L'],
			On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
		},
		Where :{
			Condition : [tCondition],
		},
		GrideView:{
			ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
			ColumnKeyLang	: ['tPPLTBCode', 'tPPLTBName'],
			ColumnsSize     : ['15%', '85%'],
			WidthModal      : 50,
			DataColumns		: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
			DataColumnsFormat : ['', ''],
			Perpage			: 10,
			OrderBy			: ['TCNMPdtPriList.FDCreateOn DESC'],
		},
		CallBack:{
			ReturnType	: 'S',
			Value		: ["oetCstPplRetCode", "TCNMPdtPriList.FTPplCode"],
			Text		: ["oetCstPplRetName", "TCNMPdtPriList.FTPplName"]
		},
		RouteAddNew : 'pdtpricegroup',
		BrowseLev : nStaCstBrowseType
	}
	return oCstBrowsePplReturn;
}
var tCondition = '';
var tStaUsrLevel = '<?= $this->session->userdata("tSesUsrLevel"); ?>';
var tAgnCode  = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
if(tStaUsrLevel != 'HQ'){
  if( tAgnCode != ''  && tAgnCode != undefined){
    tCondition += " AND TCNMPdtPmtGrp.FTAgnCode = '"+tAgnCode+"' ";
  }
}
var oCstBrowsePmg = {
	Title : ['product/pdtpromotion/pdtpromotion', 'tPMGTitle'],
	Table:{Master:'TCNMPdtPmtGrp', PK:'FTPmgCode'},
	Join :{
		Table: ['TCNMPdtPmtGrp_L'],
		On: ['TCNMPdtPmtGrp_L.FTPmgCode = TCNMPdtPmtGrp.FTPmgCode AND TCNMPdtPmtGrp_L.FNLngID = '+nLangEdits]
	},
	Where :{
         Condition : [tCondition]
	},
	GrideView:{
		ColumnPathLang	: 'product/pdtpromotion/pdtpromotion',
		ColumnKeyLang	: ['tPMGCode', 'tPMGName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMPdtPmtGrp.FTPmgCode', 'TCNMPdtPmtGrp_L.FTPmgName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMPdtPmtGrp.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstPmgCode", "TCNMPdtPmtGrp.FTPmgCode"],
		Text		: ["oetCstPmgName", "TCNMPdtPmtGrp.FTPmgName"]
	},
	RouteAddNew : 'pdtpmggroup',
	BrowseLev : nStaCstBrowseType
};



// Create By Witsarut   26/11/2019
// เพิ่มกลุ่มราคาขายส่ง
var oBchBrowseWhs = {
	Title : ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
	Table:{Master:'TCNMPdtPriList', PK:'FTPplCode'},
	Join :{
		Table: ['TCNMPdtPriList_L'],
		On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
		ColumnKeyLang	: ['tPPLTBCode', 'tPPLTBName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMPdtPriList.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstWhsCode", "TCNMPdtPriList.FTPplCode"],
		Text		: ["oetCstWhsName", "TCNMPdtPriList.FTPplName"]
	},
	RouteAddNew : 'pdtpricegroup',
	BrowseLev : nStaCstBrowseType
};

// เพิ่มกลุ่มราคาขายออนไลน์
var oBchBrowseNet = {
	Title : ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
	Table:{Master:'TCNMPdtPriList', PK:'FTPplCode'},
	Join :{
		Table: ['TCNMPdtPriList_L'],
		On: ['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
	},
	Where :{
        // Condition : ["AND TCNMBranch.FTWahStaType = '3' "]
	},
	GrideView:{
		ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
		ColumnKeyLang	: ['tPPLTBCode', 'tPPLTBName'],
		ColumnsSize     : ['15%', '85%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
		DataColumnsFormat : ['', ''],
		Perpage			: 10,
		OrderBy			: ['TCNMPdtPriList.FDCreateOn DESC'],
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetCstWhsnNetCode", "TCNMPdtPriList.FTPplCode"],
		Text		: ["oetCstWhsnNetName", "TCNMPdtPriList.FTPplName"]
	},
	RouteAddNew : 'pdtpricegroup',
	BrowseLev : nStaCstBrowseType
};



/**
* Functionality : Disabled or Enabled Customer of Branch Choose,
* When user shoose Head Office
* Parameters : -
* Creator : 20/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxDisabledOrEnabledCstBch(){
    console.log("Bch: ", $("input[name=ocbCstHeadQua]:checked").val() == 1);
    if($("input[name=ocbCstHeadQua]:checked").val() == 1){
        $("#odvCstBchFormGrp").addClass("xWCstHidden");
    }else{
        $("#odvCstBchFormGrp").removeClass("xWCstHidden");
    }
}
</script>
