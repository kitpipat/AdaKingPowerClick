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
				"Lang","ComCode","BranchCode","DocCode"
			);
			$aDataMQ 		= FSaHDeCodeUrlParameter($_GET["infor"],$aParamiterMap);
		}else{
			$aDataMQ = false;
		}
		if($aDataMQ){
	?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Frm_SQL_SMBillRefill.mrt - Viewer</title>
	<!-- <link rel="stylesheet" type="text/css" href="css/stimulsoft.viewer.office2013.whiteblue.css">
	<script type="text/javascript" src="scripts/stimulsoft.reports.engine.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.reports.export.js"></script>
	<script type="text/javascript" src="scripts/stimulsoft.viewer.js"></script> -->

	<link rel="stylesheet" type="text/css" href="<?=BASE_URL?>/formreport/AdaCoreFrmReport/css/stimulsoft.viewer.office2013.whiteblue.css?v=1.0.0">
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.engine.js?v=1.0.0"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.reports.export.js?v=1.0.0"></script>
	<script type="text/javascript" src="<?=BASE_URL?>/formreport/AdaCoreFrmReport/scripts/stimulsoft.viewer2022.js?v=1.0.0"></script>

	<?php
		StiHelper::init("handler.php", 30);
	?>
	<script type="text/javascript">
		function Start() {
			Stimulsoft.Base.StiLicense.key =
				"6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHlxd6bn81jYQswEUbfVJhgRQVXQSIb753lgwE8N" +
				"1L3elUTO52gcD5ywKTUb1A/1wKL8wEsIzmIcMbLqb/NYe09kbTuOxJksbAqRDsMKUrzeELdOpt097xfN" +
				"gFJfBiQuwFKB+fk3u76bRQ1cX6PBw9bEkR5nUOrxQG/GKZ64sIzKx1k1ouIrqdvoE3qmDDgWSHILXaZD" +
				"D0JD4pXXF2zX/7+zq49gh3Wwr0U5VCYPA/rjmEqLE8jUz0TnviU9NIldlY/W7NN7O0aVab/zsarkCN2q" +
				"oMCr/hM/HpCtE4S8+FeQkiIbcDVE43683QWwD7OuSVQ2tESN0yY5Ljf2YSnsCbs/PKQF/0Y1OawNFAQV" +
				"H7azuUrg67LYCFtn9+ltAMlCFwe351zlbEG99qo/a5U+W32nj8X9D5S1E0ksmCBlcKDHocMNbcLqz71m" +
				"jJu8yPhq92AI0ufmKvzxcpmBGycxe6fuuQz62X81XG6iWGZ6psdCMKO4D9+eebHerJrLoAwG8/8r7Eb8" +
				"IOx4yVxt5ZsbU3fJqDjZVDC/OmdUCe5LdgxooshUkLPXzYr+TXWc4SBmIqb2SqOfw6vR4hbD6M6Zgfbt" +
				"4PJhXTdtE+BNPL3hpxS9vLtRGLvH6xOaE7l3IC5OcwLFKlFZKVfkWnkyqiHzIOYvfNFzDnq92DoW8xkj" +
				"4f3lRlhERPGQ7/aexwTzbDmDd3v2bKirjNH2OArGRJMeJSgVV3tPlVRMrYzm3nbPSuiv08cQRGyXGI+3" +
				"Vt4qiRdYIZMoe65OC8c3yts7UcqIc/2BIKZwXtCUd1hnb4JB5apKa3tbTKD28ilpWJy9qB+X7iMVW6Zt" +
				"hFv894r92a58PsTNBvgyrH6FSCcvyqbX6Pu7lR4BTxhfmN4WoOEvwqN7RPF98YWk1kW4CdqtqJ56RBvn" +
				"cz5NbvBC+HhicBgk68W/N0178xEZQ/0KJJIn+Hhspom6MY56hQxGNhFDGvlrNF4tQ12fp0f+OT9rZRnx" +
				"+EqQWyKtau3QC4/K5VxWlPiFxGw=";

			// Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("localization/en-GB.xml", true);
			Stimulsoft.Base.Localization.StiLocalization.setLocalizationFile("<?=BASE_URL?>/formreport/AdaCoreFrmReport/localization/en-GB.xml", true);


			var report = Stimulsoft.Report.StiReport.createNewReport();
			report.loadFile("reports/Frm_SQL_SMBillRefill.mrt?v=1.0.6");

			// report.dictionary.variables.getByName("SP_nLang").valueObject = "1";
			// report.dictionary.variables.getByName("nLanguage").valueObject = 1;
			// report.dictionary.variables.getByName("SP_tCompCode").valueObject = "00000";
			// report.dictionary.variables.getByName("SP_tCmpBch").valueObject = "00000";
			// report.dictionary.variables.getByName("SP_tDocNo").valueObject = "VW0001522000015";
			// report.dictionary.variables.getByName("SP_nAddSeq").valueObject = 10149;
			// report.dictionary.variables.getByName("SP_tGrdStr").valueObject = "";

			report.dictionary.variables.getByName("SP_nLang").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("nLanguage").valueObject 		= "<?=$aDataMQ["Lang"];?>";
			report.dictionary.variables.getByName("SP_tCompCode").valueObject 	= "<?=$aDataMQ["ComCode"];?>";
			report.dictionary.variables.getByName("SP_tCmpBch").valueObject 	= "<?=$aDataMQ["BranchCode"];?>";
			report.dictionary.variables.getByName("SP_tDocNo").valueObject 		= "<?=$aDataMQ["DocCode"];?>";
			report.dictionary.variables.getByName("SP_nAddSeq").valueObject 	= 10149;
			report.dictionary.variables.getByName("SP_tGrdStr").valueObject 	= "";

			var options = new Stimulsoft.Viewer.StiViewerOptions();
			options.appearance.fullScreenMode = true;
			options.toolbar.displayMode = Stimulsoft.Viewer.StiToolbarDisplayMode.Separated;
			
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