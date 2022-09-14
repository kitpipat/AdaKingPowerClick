<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShpWah extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranch');
        $this->load->model('authen/user/mUser');
        $this->load->model('company/shpwah/mShpWah');

        date_default_timezone_set("Asia/Bangkok");
   
    }

    /**
     * Functionality: Function Call Page Main
     * Parameters:  From Ajax File Userlogin
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSvCShpWahMainPage(){

       $tShpCode   =  $this->input->post('tShpCode');
       $tBchCode   =  $this->input->post('tBchCode');

       $aShpWahCode  = array(
            'tShpCode' => $tShpCode,
            'tBchCode' => $tBchCode
       );

       $this->load->view('company/shpwah/wShpWahMain', array(
            'aShpWahCode'   => $aShpWahCode
       ));
    }

      /**
     * Functionality: Function CallList Data 
     * Parameters:  From Ajax File ShpWah
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSvCShpWahDataList(){
        $tShopCode         = $this->input->post('tShopCode');
        $tBchCode         = $this->input->post('tBchCode');
        $nPage             = $this->input->post('nPageCurrent');
        $tSearchAll        = $this->input->post('tSearchAll');

        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage  = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}

        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aData  = array(
            'FTShpCode'     => $tShopCode,
            'FTBchCode'     => $tBchCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll,
        );

        $aResList   = $this->mShpWah->FSaMShpWahDataList($aData);

        $aGenTable  = array(
            'aDataList' 	    => $aResList,
            'nPage'     	    => $nPage,
            'FTShpCode'         => $tShopCode,
        );

         //Return Data View
         $this->load->view('company/shpwah/wShpWahDataTable',$aGenTable);

    } 
    
    /**
     * Functionality:  Load Page Add ShpWah 
     * Parameters:  From Ajax File ShpWah
     * Creator: 22/07/2019 Witsarut
     * LastUpdate: -
     * Return:  String View
     * ReturnType: View
    */
    public function FSvCShpWahPageAdd(){

        $tShopCode     = $this->input->post('tShopCode');
        $tBchCode      = $this->input->post('tBchCode');

        $nLangResort    = $this->session->userdata("tLangID");
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aDataShp   = array(
            'tShopCode'     => $tShopCode,
            'tBchCode'      => $tBchCode
        );

        $aDataAdd  = array(
            'aResult'     => array('rtCode'=>'99'),
            'aDataShp'    => $aDataShp
        );

        $this->load->view('company/shpwah/wShpWahAdd',$aDataAdd);
    }

    //Functionality : Function Add ShpWah
    //Parameters : From Ajax File ShpWah
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Event
    //Return Type : array
    public function FSaCShpWahAddEvent(){
        $aDataMaster  = array(
            'FTBchCode'     => $this->input->post('oetBchCode1'),
            'FTShpCode'     => $this->input->post('oetShopCode'),
            'FTWahCode'     => $this->input->post('oetShpWahCode1'),
            'FDLastUpdOn'   => date("Y-m-d H:i:s"),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
            'FDCreateOn'    => date("Y-m-d H:i:s"),
            'FTCreateBy'    => $this->session->userdata('tSesUsername'),
        );

        $aChkDupicate    = $this->mShpWah->FSaMShpWahCheckCode($aDataMaster);

        if($aChkDupicate['rtCode'] == 1){
                // ถ้าข้อมูลซ้ำให้ออกลูป
                $aReturn = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => language('common/main/main','tDataDuplicate'),
                );
        }else{
            //Insert Data
            $this->db->trans_begin();
            $this->mShpWah->FSaMRShpWahAddMaster($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success '
                );

                //เดียวจะวิ่งไปเช็คก่อนว่าในร้านค้า นั้น มี wah หรือยัง ถ้ายังไม่มีต้องเอาไป update
                $this->mShpWah->FSaMRShpWahCheckWahCodeINShop('ADD',$aDataMaster);
            }
        }
        unset($aDataMaster);
        unset($aChkDupicate);
        echo json_encode($aReturn);
    }

    //Functionality : Event Delete Userlogin
    //Parameters : Ajax jReason()
    //Creator : 04/07/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Delete Event
    //Return Type : String
    public function FSaCShpWahDeleteEvent(){
        $tShpCode   = $this->input->post('tShpCode');
        $tBchCode   = $this->input->post('tBchCode');
        $tWahCode   = $this->input->post('tWahCode');
        $aDataDeleteMaster  = array(
            'FTShpCode'     => $tShpCode,
            'FTBchCode'     => $tBchCode,
            'FTWahCode'     => $tWahCode
        );
        $aResDel    = $this->mShpWah->FSnMUShpWahDel($aDataDeleteMaster);
        $nNumRowRsnLoc  = $this->mShpWah->FSnMLOCGetAllNumRow();
        if($nNumRowRsnLoc){

            //เดียวจะวิ่งไปเช็คก่อนว่าในร้านค้า นั้น มี wah หรือยัง ถ้ายังไม่มีต้องเอาไป update
            $this->mShpWah->FSaMRShpWahCheckWahCodeINShop('DEL',$aDataDeleteMaster);

            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowRsnLoc' => $nNumRowRsnLoc
            );
            echo json_encode($aReturn);
        }else{
            echo "database error";
        }


    }

    //Functionality : Delete ShpWah Ads Multiple
    //Parameters : Ajax ShpWah()
    //Creator : 20/08/2019 Witsarut
    //Return : array Data Return Status Delete
    //Return Type : array
    public function FSoCShpWahDelMultipleEvent(){
        try{
            $this->db->trans_begin();

            $aDataDelMulti = array(
               'tBchCode' => $this->input->post('paDataBchCode'),
               'tShpCode' => $this->input->post('paDataShpCode'),
               'tWahCode' => $this->input->post('paDataWahCode'),
            );

           $tResult = $this->mShpWah->FSaMShpWahDeleteMultiple($aDataDelMulti);

           if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
            $aDataReturn    = array(
                'nStaEvent' => 500,
                'tStaMessg' => 'Error Not Delete Data Pos Ads Multiple'
            );
            }else{
                $this->db->trans_commit();

                //เดียวจะวิ่งไปเช็คก่อนว่าในร้านค้า นั้น มี wah หรือยัง ถ้ายังไม่มีต้องเอาไป update
                $this->mShpWah->FSaMRShpWahCheckWahCodeINShop('DELMULTI',$aDataDelMulti);

                $aDataReturn     = array(
                    'nStaEvent' => 1,
                    'tStaMessg' => 'Success Delete Pos Ads Multiple'
                );
            }
        }catch(Exception $Error){
            $aDataReturn     = array(
                'nStaEvent' => 500,
                'tStaMessg' => $Error
            );
        }
        echo json_encode($aDataReturn);
    } 

}