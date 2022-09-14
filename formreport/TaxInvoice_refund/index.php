<?php
require_once "stimulsoft/helper.php";
require_once "../decodeURLCenter.php";
require_once('../../config_deploy.php');
?>
<!DOCTYPE html>

<html>
<head>

	<?php
		if(isset($_GET["infor"])){
			$aParamiterMap = array(
				"Lang","ComCode","BranchCode","DocCode","DocBchCode"
			);
			$aDataMQ = FSaHDeCodeUrlParameter($_GET["infor"],$aParamiterMap);
			$tGrandText 	= $_GET["Grand"];
			$PrintByPage 	= $_GET["PrintByPage"];
		}else{
			$aDataMQ = false;
		}
		if($aDataMQ){
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Frm_PSInvoiceRefund.mrt - Viewer</title>
	<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/formreport/AdaCoreFrmReport/css/stimulsoft.viewer.office2013.whiteblue.css?v=1.0.0">
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.engine.js?v=1.0.0"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.export.js?v=1.0.0"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.viewer2022.js?v=1.0.0"></script>
	<!-- <link rel="stylesheet" type="text/css" href="css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="scripts/stimulsoft.reports.engine.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.reports.export.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.viewer.js"></script> -->

	<?php
		StiHelper::init("handler.php", 30);
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
				"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHkR9e1Pb0CzMUgEpKj21uxoNrDzV4c5K1WaIkF6" +
				"VKRBOcwa0BtcNU0kvqJwAeVsjMIO1daahCwxrrDL8pTSYZXf9JTFKVXLcmb9Y4RU2gnO/pL1BtVDXU6L" +
				"BeplsnI38Xc2S3SrrVzN8cs+uegIEB8M9silOfG/ynCEXWab27BpN4Tg2rUxKDmRV4eahoHmbf6rGLXb" +
				"Lp+AolSVw+bGB2xcwSO+PsIPDlhWlUmknwgNIokn/JMG6ss1+31B0e1wRrgz0RoWjvF719XRAA6DlOGA" +
				"FjnNBbGtQoo5RRp7rqqAnwvW4RayG9hzMnF2AI3yjmiQxhorAI1gMZ2sYsTzrBlfhPphH1wHYlW9I/vw" +
				"VP/0Jae1oR5eL/ZzG98LIk53dBFIp7fd50hjL4BwMjf1sr8pDaGYvfdPqfujzqa52rtbXUx5zAQXnzAE" +
				"NIiosQSqGdZXErzy082OtXwyBjraYhU71+4dKg0q0gyA57qG/pn6oglgW6jtNxkI3uR/o6OdrgFJNDaf" +
				"u6L/n3593ecGKm1HfPrjOBlrKX7oXl6jVIPTzK9C6ORlSlQ+I1n411Or0fC0zbGYCWk5TYYVFAzKsdH3" +
				"Px5+ClakLLPXfkV61HOhBj1KQKbQXaD1GbVonuUHhRdbT8FLeextL3RNe26NYlH8g+SsKWwFog/8BTbm" +
				"vIlULWwuIJc1p2xQXSoC6rztRJMAHLfUPhfVF8crfS2g9cI+JSul/cLC1FzsrKxn9Khv5ti1aT9sPt1a" +
				"RwP67GE5VJAcMPEKkdB8KPBMxAQPezJTNcmHNGQPaw/e1JPwYcrW3U6i4gwa3OqWL+ZR/yqeTfHyWzUb" +
				"B93xoecQVXbuqYT4M2qN4+rmAcJJUA1jYsbOECNmz4Up1eXoo0MTelzcWYfK6xwwA7pMPJFyLfbn1pgo" +
				"hvvLPEeaklJyFxK/4Hi6FwVU/+IhGLeSED7QotMCpTHN4uIc4WwJdv/TshOCBN/jGXgAf59OINCm2AMk" +
				"KI1qsGmGEXzg3c9Oy2BXoh3ZUR0=";

			// Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("localization/en.xml", true);
			Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("<?=BASE_URL?>/formreport/AdaCoreFrmReport/localization/en-GB.xml", true);


			var report = Stimulsoft.Report.StiReport.createNewReport();
			report.loadFile("reports/Frm_PSInvoiceRefund.mrt?v=1.0.1");

			// report.dictionary.variables.getByName("SP_nLang").valueObject = "1";
			// report.dictionary.variables.getByName("nLanguage").valueObject = 1;
			// report.dictionary.variables.getByName("SP_tCompCode").valueObject = "00001";
			// report.dictionary.variables.getByName("SP_tCmpBch").valueObject = "00000";
			// report.dictionary.variables.getByName("SP_nAddSeq").valueObject = 3;
			// report.dictionary.variables.getByName("SP_tDocNo").valueObject = "R22000110000009";
			// report.dictionary.variables.getByName("SP_tStaPrn").valueObject = "1";
			// report.dictionary.variables.getByName("SP_tGrdStr").valueObject = "หนึ่งหมึ่นบาทถ้วน";
			// report.dictionary.variables.getByName("SP_tDocBch").valueObject = "00011";
			// report.dictionary.variables.getByName("SP_tRsnName").valueObject = "";
			report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
			report.dictionary.variables.getByName("SP_tCmpBch").valueObject 	= "<?=$aDataMQ["BranchCode"];?>";
			report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 3;
			report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
			report.dictionary.variables.getByName("SP_tStaPrn").valueObject 	= i.toString();
			report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "<?=$tGrandText?>";
			report.dictionary.variables.getByName("SP_tDocBch").valueObject     = "<?=$aDataMQ['DocBchCode']?>";
			report.dictionary.variables.getByName("SP_tRsnName").valueObject 	= "";

			if(staprint == "Print") {
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
				var options = new Stimulsoft.Viewer.StiViewerOptions();
				var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

				viewer.onPrepareVariables = function (args, callback) {
					Stimulsoft.Helper.process(args, callback);
				}

				viewer.onBeginProcessData = function (args, callback) {
					Stimulsoft.Helper.process(args, callback);
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