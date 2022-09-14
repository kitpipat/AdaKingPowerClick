<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSession extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->helper('url');
        $this->load->library ( "session" );
    }

    public function index() {
    }

    //Functionality: ตรวจสอบ Session ID
	//Parameters:  รับค่าจาก Ajax Session
	//Creator: 11/01/2019 Wasin(Yoshi)
	//Last Modified : 
	//Return : Error Code 
	//Return Type: Redirect
    public function FCNnCheckSession(){
        $bStaSession    =   $this->session->userdata('bSesLogIn');
        if(isset($bStaSession) && $bStaSession === TRUE){
            echo 1;
        }else{
            echo 0;
        }
    }

}