<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cTimeStamp extends MX_Controller {

    
    public function __construct(){
        parent::__construct();
        $this->load->model('time/timeStamp/mTimeStamp');
    }
    
    /**
     * Functionality : Main page for Time Stamp
     * Parameters : $nTimeStampBrowseType, $tTimeStampBrowseOption
     * Creator : 02/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function index($nTimeStampBrowseType, $tTimeStampBrowseOption){
        
        $nMsgResp   = array('title'=>"TimeStamp");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view( 'common/wHeader', $nMsgResp);
            $this->load->view( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view( 'common/wMenu'  , array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('timeStamp/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view( 'time/timeStamp/wTimeStamp', array (
            'nMsgResp'                  =>$nMsgResp,
            'vBtnSave'                  =>$vBtnSave,
            'nTimeStampBrowseType'      =>$nTimeStampBrowseType,
            'tTimeStampBrowseOption'    =>$tTimeStampBrowseOption
        ));
    }

    //Main Page
    public function FSvTimeStampMainpage(){
        $this->load->view('time/timeStamp/wTimeStampMain');
    }

    //Get Data : History Checkin and Checkout
    public function FSvTimeStampGetHistoryCheckinCheckout(){
        $pnUsercode   = $this->input->post('pnUsercode');
        $aDataReturn  = array(
			'aResultHistory' 	=> $this->mTimeStamp->FSaMTsmGetHistoryCheckinCheckOut($pnUsercode)
        );
        $this->load->view('time/timeStamp/wTimeStampHistoryTable' , $aDataReturn);
    }

    //Get Data : Last Checkin and Checkout
    public function FSvTimeStampGetLastCheckinCheckout(){
        $aDataReturn  = array(
			'aResultLast' 	    => $this->mTimeStamp->FSaMTsmGetLastCheckinCheckOut()
        );
        $this->load->view('time/timeStamp/wTimeStampLastTable' , $aDataReturn);
    }

    //Insert
    public function FSvTimeStampInsert(){
        $tUser                  = $this->input->post('oetTimeStampUser');
        $tPassword              = $this->input->post('oetTimeStampPassword');
        $tTypeInputorOutput     = $this->input->post('oetTypeInputOutput');
        
        $tCheckUserandPassword = $this->mTimeStamp->FSaMTsmCheckUsernameandPassword($tUser,$tPassword);

        //Step 1 : Check Username and password
        $tCheckUserandPassword = FCNnHSizeOf($tCheckUserandPassword);
        if($tCheckUserandPassword == 1){ // found

            //Step 2 : Check เวลาเข้างาน จะต้องมี แค่ 1 record
            $dCurrentDate    =  date('Y-m-d');
            $tCheckDataInput = $this->mTimeStamp->FSaMTsmCheckInputWithoutOutput($tUser,$dCurrentDate);   
            
            if(empty($tCheckDataInput)){
                //Step 3 : ไม่เคยเช็คอินหรือเช็คเอ้า ให้ Insert
                $tAllowCheckInorCheckout = true;
                $tAllowUpdateCheckout    = 'checkin';
            }else{

                if($tTypeInputorOutput == 1){ //เช็คชื่อขาเข้า
                    if($tCheckDataInput[0]['FTWrtClockOut'] == '' || $tCheckDataInput[0]['FTWrtClockOut'] == null){
                        //Step 3 : ถ้ากดเช็คอิน เเต่ ยังไม่ได้เช็คเอ้า ต้องเช็คเอ้าก่อน
                        echo 'PleseCheckOut';
                        exit;
                    }else{
                        //Step 4 : กดเช็คอินได้
                        $tAllowCheckInorCheckout = true;
                        $tAllowUpdateCheckout    = 'checkin';
                    }
                }else if($tTypeInputorOutput == 2){ //เช็คชื่อขาออก
                    if($tCheckDataInput[0]['FTWrtClockOut'] == '' || $tCheckDataInput[0]['FTWrtClockOut'] == null){
                        //Step 3 : ไม่เคยเช็คเอ้า Insert
                        $tAllowCheckInorCheckout = true;
                        $tAllowUpdateCheckout    = 'checkout';
                    }else{
                        echo 'CheckoutIsDuplicate';
                        exit;
                    }
                }

            }

        }else if($tCheckUserandPassword == 0){ //ไม่พบ username or password
            echo 'UsernameorpasswordFail';
            exit;
        }

        if($tAllowCheckInorCheckout == true){
            if($tTypeInputorOutput == 1){ //Input
                $dDateInput     = date('Y-m-d H:i:s');
                $dTimeInput     = date('H:i:s');
                $dDateOutput    = null;
                $dTimeOutput    = null;
            }else if($tTypeInputorOutput == 2){ //Output 
                $dDateInput     = null;
                $dTimeInput     = null;
                $dDateOutput    = date('Y-m-d H:i:s');
                $dTimeOutput    = date('H:i:s');
            }
            
            $tResultGetBch = $this->mTimeStamp->FSaMTsmGetBchforUserCode($tUser);
            if($tResultGetBch[0]['FTBchCode'] == '' || $tResultGetBch[0]['FTBchCode'] == null){
                $tFTBchCode = $this->session->userdata("tSesUsrBchCode");
            }else{
                $tFTBchCode = $tResultGetBch[0]['FTBchCode'];
            }

            $aDataInsert = array(
                'FTBchCode'     => substr($tFTBchCode,0,5),
                'FTUsrCode'     => $tUser,
                //CheckIN
                'FDWrtDate'     => $dDateInput,
                'FTWrtClockIn'  => $dTimeInput,
                //CheckOUT
                'FDWrtDateOut'  => $dDateOutput,
                'FTWrtClockOut' => $dTimeOutput,
                'FTWrtRemark'   => '-',
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),

                'FDLastUpdOn'   => date('Y-m-d H:i:s')
            );

            if($tAllowUpdateCheckout == 'checkin'){
                echo $this->mTimeStamp->FSaMTsmInsertCheckinCheckOut($aDataInsert);
            }else if($tAllowUpdateCheckout == 'checkout'){
                $nSeqLast = $this->mTimeStamp->FSaTsmGetIDLast($aDataInsert);
                $nSeqLast = $nSeqLast[0]['FNWrtID'];
                echo $this->mTimeStamp->FSaMTsmUpdateCheckOut($aDataInsert,$nSeqLast,$dCurrentDate);
            }
        }else{
            echo 'error';
        }

    }

    //Get Detail - Main
    public function FSvTimeStampGetDetail(){
        $this->load->view('time/timeStamp/wTimeStampDetail');
    }

    //Get Datatable
    public function FSvTimeStampGetDataTable(){
        $nPage                              = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent'); 
        $ptDateCheckin                      = $this->input->post('ptDateCheckin');
        $ptDateCheckout                     = $this->input->post('ptDateCheckout');
        $ptBranch                           = $this->input->post('ptBranch');
        $ptUsername                         = $this->input->post('ptUsername');
        $ptTypeSearchCheckinorCheckout      = $this->input->post('ptTypeSearchCheckinorCheckout');
        $nLangEdit                          = $this->session->userdata("tLangID");
        $aData  = array(
            'nPage'                         => $nPage,
            'nRow'                          => 10,
            'FNLngID'                       => $nLangEdit,
            'ptDateCheckin'                 => trim($ptDateCheckin),
            'ptDateCheckout'                => trim($ptDateCheckout),
            'ptBranch'                      => trim($ptBranch),
            'ptUsername'                    => trim($ptUsername),
            'ptTypeSearchCheckinorCheckout' => trim($ptTypeSearchCheckinorCheckout)
        );
        $aTimeStamp = $this->mTimeStamp->FSaMTsmGetDetailAll($aData);

        $aDataReturn  = array(
            'aResult' 	    => $aTimeStamp,
            'nPage'         => $nPage,
        );
        $this->load->view('time/timeStamp/wTimeStampDetailTable' , $aDataReturn);
    }

    //Updateinline
    public function FSvTimeStampUpdateinline(){
        $ptTimeIN      = $this->input->post('ptTimeIN');
        $ptTimeOut     = $this->input->post('ptTimeOut');
        $pnSeq         = $this->input->post('pnSeq');
        $ptDateIN      = $this->input->post('ptDateIN');
        $ptDateOut     = $this->input->post('ptDateOut');

        $aData  = array(
            'FDWrtDate'       => $ptDateIN  .' '. $ptTimeIN,
            'FDWrtDateOut'    => $ptDateOut .' '. $ptTimeOut,
            'FTWrtClockIn'    => $ptTimeIN,
            'FTWrtClockOut'   => $ptTimeOut,
            'FNWrtID'         => $pnSeq
        );
        $aTimeStamp = $this->mTimeStamp->FSaMTsmUpdateinline($aData);
    }
    
    
}


