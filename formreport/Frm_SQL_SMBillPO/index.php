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
			$aDataMQ['Grand'] = $_GET["Grand"];
		}else{
			$aDataMQ = false;
		}
		if($aDataMQ){
	?>

	<title>Frm_SQL_SMBillPO.mrt - Viewer</title>
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
			report.loadFile("reports/Frm_SQL_SMBillPO.mrt");

			report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
			report.dictionary.variables.getByName("SP_tCmpBch").valueObject		= "<?=$aDataMQ["BranchCode"];?>";
			report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
			report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 1;
			report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "<?=$aDataMQ["Grand"];?>";
			report.dictionary.variables.getByName("SP_tDocBch").valueObject 	= "<?=$aDataMQ["DocBchCode"];?>";


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