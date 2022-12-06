<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cLogout extends MX_Controller {

    public function __construct() {
		parent::__construct ();
		$this->load->library ( "session" );
    }
		
    public function index() {
			@$this->session->sess_destroy ();
			// delete_cookie("AdaStoreBackCookies",$_SERVER['SERVER_NAME'],explode("/",$_SERVER['SCRIPT_NAME'])[1]);
			FCNxDeleteCookie("AdaStoreBackCookies");
			// $nIP 			= $_SERVER['REMOTE_ADDR'];
			// $nResultIP 		= str_replace(".","",$nIP);
			// $tFormat 		= date('dmY').'-'.$nResultIP;

			// $tPathRead = 'application/config/configDB/'.$tFormat.'.txt';
			// unlink($tPathRead) or die("Couldn't delete file");

			// unset($_COOKIE['ModuleName']);
			// setcookie("ModuleNamexxxx", "", time() - 3600);
			setcookie('ModuleName', '', time() + (86400 * 30), "/"); // 86400 = 1 day
			redirect ( 'login', 'refresh' );
		}


}
