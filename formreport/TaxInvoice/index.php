<?php
require_once "stimulsoft/helper.php";
require_once "../decodeURLCenter.php";
require_once('../../config_deploy.php');
?>
<!DOCTYPE html>


<html>
<head>
	<title>Frm_PSInvoiceSale.mrt - Viewer</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="scripts/stimulsoft.reports.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.viewer.js"></script> -->

	<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/formreport/AdaCoreFrmReport/css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.viewer.js"></script> 

	<?php
		if(isset($_GET["infor"])){
			$aParamiterMap = array(
				"Lang","ComCode","BranchCode","DocCode","DocBchCode"
			);
			$aDataMQ 		= FSaHDeCodeUrlParameter($_GET["infor"],$aParamiterMap);
			$tGrandText 	= $_GET["Grand"];
			$PrintByPage 	= $_GET["PrintByPage"];
		}else{
			$aDataMQ = false;
		}
		if($aDataMQ){
	?>

	<?php
		$options = StiHelper::createOptions();
		$options->handler = "handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		var showAlert = true;
		
		function ProcessForm() {
			staPrint = '<?=$_GET["StaPrint"];?>';
			if(staPrint == 0){
				Start("Preview","")
			}else{

				nPrintOriginal 	= '<?=$_GET["PrintOriginal"];?>';
				nPrintCopy 		= '<?=$_GET["PrintCopy"];?>';
				aPackData 		= [];

				var nPrint = parseInt(nPrintOriginal) + parseInt(nPrintCopy);
				for(j=1; j<=nPrintOriginal; j++){
					aPackData.push(1);
				}

				for(k=1; k<=nPrintCopy; k++){
					aPackData.push(2);
				}

				//วนลูปปริ้้นเอกสาร
				for(i=0;i<nPrint;i++){
					Start("Print",aPackData[i])
				}
			}
		}

		function Start(staprint , i) {
			Stimulsoft.Base.StiLicense.key =
				"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHkxDG+leACqcJbQlrJsaUMElz5Nz1s+qGrEWbGH" +
				"/hph9erB9ABPLWZHptIyxtmuwTKyc7ALvWW+SG2vxRzJvI6h/u+f/YDW8AUpj/jDgjkzzcvKbFhU5T1D" +
				"SVvHgjkgjfgMV4lzSqMA9s2tUN4uGMUkMyoO1WEHlBOsV3XDGm7/yLOGRn8k4LUbuF08ezB+VcaSQbTi" +
				"mKjlo6NACsTEHrNCNDH0Jsjr2KTWcGrIWt14PGpJLlL/2OsI6+joR7N1NW3mHQIbTH7YixFYS2nVx1OM" +
				"9hSAQ/24iG0kjwVs13G7KN8A6UgBfmEhL8Y+F67uMBhmkKvvDnPv++WnekA1GED2fInVPJuAv7ELTPh5" +
				"1C+sZyIuOIs0yIIUKJd2aMDSkIXq5EP3lDJSkRyjHTMeO9vUKAAN7BzdWo5u5oZg8eVjp7urBoVjTwIx" +
				"wG/5kh+QERagvSrGt5TYOrYVr55Eir2ZYQH1yzOMzHRZr3BP2m+4nL1PVkhJCo1nK73KgDipCxNED0NJ" +
				"Rrv+t3HUBgAHVPPCh4OFtB4v/SeBvmNUWMxyC8fSA5KNfRcJ/whkj/EGL7fGzwBTmTmlY2bJauIioygR" +
				"zBaShmni7wvlNOBHW4kcUfMcUNinsvqTaxDH4drkzNLT+RIR1oT/Kr3grt+YpCUD";

			Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("<?=BASE_URL?>/formreport/AdaCoreFrmReport/localization/en.xml", true);

			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("reports/Frm_PSInvoiceSale.mrt?v=<?=date('YmdHis')?>");

			if(staprint == "Print") {
				report.onBeginProcessData = function (args, callback) {
					<?php StiHelper::createHandler(); ?>
				}
				report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
				report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
				report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
				report.dictionary.variables.getByName("SP_tCmpBch").valueObject 	= "<?=$aDataMQ["BranchCode"];?>";
				report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 3;
				report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
				report.dictionary.variables.getByName("SP_tStaPrn").valueObject 	= i.toString();
				report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "<?=$tGrandText?>";
				report.dictionary.variables.getByName("SP_tDocBch").valueObject     = "<?=$aDataMQ['DocBchCode']?>";
				report.renderAsync(function(){
					if('<?=$PrintByPage?>' == 'ALL'){
						report.print();
					}else{	
						var nCount = report.pages.report.renderedPages.count;
						if(parseInt('<?=$PrintByPage?>') > nCount){
							if (showAlert==true){
								alert ("ไม่พบเลขหน้าที่ระบุ");
								showAlert = false;
							}
						}else{
							var nPage 		= parseInt('<?=$PrintByPage?>') - parseInt(1);
							var pageRange 	= new Stimulsoft.Report.StiPagesRange(Stimulsoft.Report.StiRangeType.CurrentPage,nPage,nPage);
							report.print(pageRange);
						}
					}
				});
			}else{

				report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
				report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
				report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
				report.dictionary.variables.getByName("SP_tCmpBch").valueObject 	= "<?=$aDataMQ["BranchCode"];?>";
				report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 3;
				report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
				report.dictionary.variables.getByName("SP_tStaPrn").valueObject 	= "1";
				report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "<?=$tGrandText?>";
				report.dictionary.variables.getByName("SP_tDocBch").valueObject     = "<?=$aDataMQ['DocBchCode']?>";
				var options = new Stimulsoft.Viewer.StiViewerOptions();
				options.appearance.fullScreenMode = true;
				options.toolbar.showPrintButton = false;
				options.toolbar.showSaveButton = false;
				options.toolbar.showDesignButton = false;
				options.toolbar.showAboutButton = false;
				var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
				viewer.onBeginProcessData = function (args, callback) {
					<?php StiHelper::createHandler(); ?>
				}
				viewer.report = report;
				viewer.renderHtml("viewerContent");
			}
		}
	</script>
	<?php
		}
	?>
</head>
<body onload="ProcessForm()">
	<div id="viewerContent"></div>
</body>
</html>