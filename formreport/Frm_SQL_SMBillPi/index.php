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
			$aDataMQ 		= FSaHDeCodeUrlParameter($_GET["infor"],$aParamiterMap);
			$tGrandText 	= $_GET["Grand"];
		}else{
			$aDataMQ = false;
		}
		if($aDataMQ){
	?>

	<title>Frm_SQL_SMBillPi.mrt - Viewer</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="scripts/stimulsoft.reports.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.viewer.js"></script> -->

	<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/formreport/AdaCoreFrmReport/css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.js"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.viewer.js"></script> 

	<?php
		$options = StiHelper::createOptions();
		$options->handler = "handler.php";
		$options->timeout = 30;
		StiHelper::initialize($options);
	?>
	<script type="text/javascript">
		function Start() {
			Stimulsoft.Base.StiLicense.key =
				"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHnqIlCkTsKw9fhGlg4zt07G4N+qF24MzHxlrend" +
				"NxpXPGdQTtKCB6ySxNdCcqjlSuRAlgMgZU/21S+eDym9qCbZiVDSAHERXvBagr0kWWXxo39Jwm8nPXZn" +
				"lyzUTJySwkZcQOBFCLfYBw1s0vonjvjn78k1JLC+L+PFhrKNlTZiNjqA1wawejfZD/GFZGUwbw+9MflM" +
				"uNz4Y55YXXMbdbtP2XH8897KpEkCMH26qOlbkLn13jiSueLJKmQA6V+XrEEGo5oM+H8Hsmc1T7/zQrmn" +
				"Re1tPYJZOfr+qlwBiYIM9ImjnZ7Fyhi9goIEb02OK/lzNWASyguH7/Xkzbo+LFm+/D64acIq9cJiahTX" +
				"oxOQVOES2wYg05l+z6UEC2aiywEn8dZ/0Aei24kqHlKXx5DROrCfEPwRSE+/Llen3o5LLXvIgQm9h/pi" +
				"DfSDFjWs+5n1bmw5Mf9H/zWM/w6+nmSJnWeAYo8nwLk444d5ESAhSzmBGzjUSzHaHSEtwwE23g8BJHe3" +
				"CLkD3LPHvFmM8GrFrVjBbbjXoktXblzGRRR8GQ==";

			Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("<?=BASE_URL?>/formreport/AdaCoreFrmReport/localization/en.xml", true);

			var report = new Stimulsoft.Report.StiReport();
			report.loadFile("reports/Frm_SQL_SMBillPi.mrt");
            
			
			report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
			report.dictionary.variables.getByName("SP_tCmpBch").valueObject 	= "<?=$aDataMQ["BranchCode"];?>";
			report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
			report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 10149;
			report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "<?=$tGrandText;?>";
			report.dictionary.variables.getByName("SP_tDocBch").valueObject 	= "<?=$aDataMQ["DocBchCode"];?>";

			/*
			report.dictionary.variables.getByName("SP_nLang").valueObject = "1";
			report.dictionary.variables.getByName("nLanguage").valueObject = 1;
			report.dictionary.variables.getByName("SP_tCompCode").valueObject = "C0001";
			report.dictionary.variables.getByName("SP_tCmpBch").valueObject = "00342";
			report.dictionary.variables.getByName("SP_tDocNo").valueObject = "PC0006819000007";
			report.dictionary.variables.getByName("SP_nAddSeq").valueObject = 10149;			
			*/
			
			var options = new Stimulsoft.Viewer.StiViewerOptions();
			options.appearance.fullScreenMode = true;
			options.toolbar.displayMode = Stimulsoft.Viewer.StiToolbarDisplayMode.Separated;
			
			var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);

			viewer.onBeginProcessData = function (args, callback) {
				<?php StiHelper::createHandler(); ?>
			}

			viewer.report = report;
			viewer.renderHtml("viewerContent");
		}
		</script>
	<?php
		}
	?>
</head>
<body onload="Start()">
	<?php
		if($aDataMQ){
	?>
	<div id="viewerContent"></div>
	<?php
		}else{
			echo "ไม่สามารถเข้าถึงข้อมูลนี้ได้";
		}
	?>
</body>
</html>