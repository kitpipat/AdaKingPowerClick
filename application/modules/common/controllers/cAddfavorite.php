<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAddfavorite extends MX_Controller {

    public function __construct() {
		parent::__construct ();
        $this->load->library ( "session" );
        $this->load->model('common/mAddfavorite');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function FSvCallViewModalFavorite(){
        $tRouteFavorite     = $this->input->post('ptRoutefavorit');
        $aDataMenuFavorite  = $this->mAddfavorite->FSaMGetDataMenu($tRouteFavorite);
        $aDataConfigView    = [
            'aDataMenuFavorite' => $aDataMenuFavorite
        ];
        $this->load->view('common/wModalOptionFavorite',$aDataConfigView);
    }

    //Function : ใช้ในการ Menu Addfavorite
    public function FSxAddfavorite(){

        try{
            $tMnuRoute      = $this->input->post('ptAddfavorit');
            $tFTMnuName     = $this->input->post('tFTMnuName');
            $tFTMnuCode     = $this->input->post('tFTMnuCode');
            $tFTMnuCtlName  = $this->input->post('tFTMnuCtlName');
            $tFTMnuImgPath  = $this->input->post('tFTMnuImgPath');
            $GetDataMenu    = $this->mAddfavorite->FSaMGetDataMenu($tMnuRoute);
            $aDataAdd   = array(
                'aDatalist'     => $GetDataMenu,
                'FTMnuRoute'    => $this->input->post('ptAddfavorit'),
                'FTMfvOwner'    => $this->session->userdata('tSesUsername'),
                'FTMfvName'     => $this->input->post('tFTMnuName')
            );
            $this->db->trans_begin();
            $aResult  = $this->mAddfavorite->FSaMAddfavoriteData($aDataAdd);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Add Data"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Data',
                    'rDisable'      => $aResult
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //function Check Status Disable Favorite 1 or 2
    public function FSxChkStaDisable(){
        try{
            $tMnuRoute      = $this->input->post('tStadissable');
            $GetDataMenu    = $this->mAddfavorite->FSaMGetDataMenu($tMnuRoute);
            $aDataAdd   = array(
                'aDatalist'     => $GetDataMenu,
                'FTMnuRoute'    => $tMnuRoute,
                'FTMfvOwner'    => $this->session->userdata('tSesUsername')
            );
            //For Check StaDisable
            $aChkStaDisable  = $this->mAddfavorite->FSaMCheckStaDisable($aDataAdd);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Add Data"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Data',
                    'rDisable'      => $aChkStaDisable
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }

    // Function GetData FavName
    // Create By Witsarut/ 04/02/2020
    public function FSxGetDatafavName(){
        try{
            //Get Data FavName
            $tDataRoute         = $this->input->post('oetGetDataMnuCtlName');
            $tTypeEvent         = $this->input->post('ptTypeEvent');
            $GetDataMenu        = $this->mAddfavorite->FSaMGetDataMenu($tDataRoute);

            $aDataAdd   = array(
                'FTMfvID'       => 1,
                'aDatalist'     => $GetDataMenu,
                'FTMnuRoute'    => $this->input->post('oetGetDataMnuCtlName'),
                'FTMfvOwner'    => $this->session->userdata('tSesUsername'),
                'FTMfvName'     => $this->input->post('oetGetDataMnuName')
            );

            $this->db->trans_begin();
            if($tTypeEvent == 'cancel'){
                $this->mAddfavorite->FSaMRemoveMenu($aDataAdd,$tTypeEvent);
            }else{
                $this->mAddfavorite->FSaMAddfavoriteData($aDataAdd,$tTypeEvent);
            }

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Success Add Data"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Data'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }

    }


}
