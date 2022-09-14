<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cLockerInfor extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('monitordashboard/locker/mLockerInfor');
        if(!is_dir(APPPATH."modules\monitordashboard\assets\koolreport")) {
            mkdir(APPPATH."modules\monitordashboard\assets\koolreport");
        }
        if(!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp");
        }
        if(!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp");
        }
        if(!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\locker")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\locker");
        }
        if(!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\locker\lockerstatusdashbroad")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\locker\lockerstatusdashbroad");
        }
    }

    // เซ็ตไฟล์ เริ่มต้นเมื่อเข้าสู่ dash broad
    public function index(){
        $this->load->view("monitordashboard/locker/wLockerInfor");
    }

    // Functionality : Get Data View Moniter DashBoard Locker Status
	// Parameters : From Ajax File
	// Creator : 11/11/2019 Wasin(Yoshi)
	// Return : String View
    // Return Type : View
    public function FSoCDLKDataLockerStatus(){
        $aDataWhereFilter   = [
            'FTBchCode' => $this->input->post('oetDLKBchCode'),
            'FTMerCode' => $this->input->post('oetDLKMerCode'),
            'FTShpCode' => $this->input->post('oetDLKShopCode'),
            'FNLngID'   => $this->session->userdata("tLangEdit")
        ];
        $aDataLockerStautus = $this->mLockerInfor->FSaMDLKDataLockerStatus($aDataWhereFilter);
        $aDataConfigView    = [
            'aDataLockerStautus'    => $aDataLockerStautus,
        ];
        $this->load->view("monitordashboard/locker/wLockerInforListLockerHome",$aDataConfigView);
    }







    

}
