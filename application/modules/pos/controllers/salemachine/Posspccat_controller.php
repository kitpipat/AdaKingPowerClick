<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Posspccat_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos/salemachine/Posspccat_modal');
        date_default_timezone_set("Asia/Bangkok");
    }

    // Create By : Napat(Jame) 05/05/2022
    public function FSvCPSCPageList(){
        $this->load->view('pos/salemachine/posspccat/wPosSpcCatList');
    }

    // Create By : Napat(Jame) 05/05/2022
    public function FSvCPSCPageDataTable(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'   	=> $this->session->userdata("tLangEdit"),
                'tSearchAll'    => trim($tSearchAll),
                'tBchCode'      => $this->input->post('tBchCode'),
                'tPosCode'      => $this->input->post('tPosCode'),
                'tShpCode'      => $this->input->post('tShpCode'),
            );
            $aPosDataList   = $this->Posspccat_modal->FSaMPSCEventGetDataList($aData);

            if( $aPosDataList['nCurrentPage'] > $aPosDataList['nAllPage'] ){
                $aData['nPage'] = 1;
                $aPosDataList = $this->Posspccat_modal->FSaMPSCEventGetDataList($aData);
            }
            $aGenTable  = array(
                'aPosSpcCatDataList'    => $aPosDataList,
                'nPage'                 => $aData['nPage'],
                'tSearchAll'            => $tSearchAll
            );
            $this->load->view('pos/salemachine/posspccat/wPosSpcCatDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 05/05/2022
    public function FSvCPSCPageAdd(){
        try{
            $aPackData = array(
                'aPosSpcCatData'    =>  array(
                                            'aItems'        => array(),
                                            'tCode'         => '200',
                                            'tDesc'         => 'Page Add',
                                        )
            );
            $this->load->view('pos/salemachine/posspccat/wPosSpcCatAdd',$aPackData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSvCPSCEventAdd(){
        try{
            $aDataWhere = array(
                'FTBchCode'         => $this->input->post("tBchCode"),
                'FTShpCode'         => $this->input->post("tShpCode"),
                'FTPosCode'         => $this->input->post("tPosCode"),
            );
            $aDataAddEdit = array(
                'FTBchCode'         => $this->input->post("tBchCode"),
                'FTShpCode'         => $this->input->post("tShpCode"),
                'FTPosCode'         => $this->input->post("tPosCode"),
                'FNCatSeq'          => 0,
                'FTPdtCat1'         => $this->input->post("oetPSCCatCode1"),
                'FTPdtCat2'         => $this->input->post("oetPSCCatCode2"),
                'FTPdtCat3'         => $this->input->post("oetPSCCatCode3"),
                'FTPdtCat4'         => $this->input->post("oetPSCCatCode4"),
                'FTPdtCat5'         => $this->input->post("oetPSCCatCode5"),
                'FTPgpChain'        => $this->input->post("oetPSCPgpCode"),
                'FTPtyCode'         => $this->input->post("oetPSCPtyCode"),
                'FTPbnCode'         => $this->input->post("oetPSCPbnCode"),
                'FTPmoCode'         => $this->input->post("oetPSCPmoCode"),
                'FTTcgCode'         => $this->input->post("oetPSCTcgCode"),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata("tSesUsername"),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata("tSesUsername"),
            );
            $aDataAddEdit['FNCatSeq'] = $this->Posspccat_modal->FSnMPSCEventGetNextSeq($aDataWhere);

            // $nChkDup = $this->Posspccat_modal->FSnMPSCEventCheckDuplicate($aDataAddEdit);
            // if( $nChkDup == 0 ){
                $this->db->trans_begin();
                $this->Posspccat_modal->FSxMPSCEventAdd($aDataAddEdit);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add PosSpcCat"
                    );
                }else{
                    $this->Posspccat_modal->FSxMPSCEventUpdMasPos($aDataWhere,$aDataAddEdit);
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add PosSpcCat'
                    );
                }
            // }else{
            //     $aReturn = array(
            //         'nStaEvent'    => '800',
            //         'tStaMessg'    => "มีข้อมูลนี้อยู่แล้วในระบบ"
            //     );
            // }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 06/05/2022
    public function FSvCPSCPageEdit(){
        try{
            $aDataWhere = array(
                'tBchCode'         => $this->input->post("tBchCode"),
                'tShpCode'         => $this->input->post("tShpCode"),
                'tPosCode'         => $this->input->post("tPosCode"),
                'nCatSeq'          => $this->input->post("nSeq"),
                'FNLngID'   	    => $this->session->userdata("tLangEdit"),
            );
            $aPosSpcCatData = $this->Posspccat_modal->FSnMPSCEventGetDataBySeq($aDataWhere);
            $aPackData = array(
                'aPosSpcCatData'    => $aPosSpcCatData
            );
            $this->load->view('pos/salemachine/posspccat/wPosSpcCatAdd',$aPackData);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 09/05/2022
    public function FSvCPSCEventEdit(){
        try{
            $aDataWhere = array(
                'FTBchCode'         => $this->input->post("tBchCode"),
                'FTShpCode'         => $this->input->post("tShpCode"),
                'FTPosCode'         => $this->input->post("tPosCode"),
                'FNCatSeq'          => $this->input->post("ohdPSCCatSeq"),
            );
            $aDataAddEdit = array(
                'FTPdtCat1'         => $this->input->post("oetPSCCatCode1"),
                'FTPdtCat2'         => $this->input->post("oetPSCCatCode2"),
                'FTPdtCat3'         => $this->input->post("oetPSCCatCode3"),
                'FTPdtCat4'         => $this->input->post("oetPSCCatCode4"),
                'FTPdtCat5'         => $this->input->post("oetPSCCatCode5"),
                'FTPgpChain'        => $this->input->post("oetPSCPgpCode"),
                'FTPtyCode'         => $this->input->post("oetPSCPtyCode"),
                'FTPbnCode'         => $this->input->post("oetPSCPbnCode"),
                'FTPmoCode'         => $this->input->post("oetPSCPmoCode"),
                'FTTcgCode'         => $this->input->post("oetPSCTcgCode"),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata("tSesUsername"),
            );
            // $nChkDup = $this->Posspccat_modal->FSnMPSCEventCheckDuplicate($aDataAddEdit);
            // if( $nChkDup == 0 ){
                $this->db->trans_begin();
                $this->Posspccat_modal->FSxMPSCEventEdit($aDataWhere,$aDataAddEdit);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Edit PosSpcCat"
                    );
                }else{
                    $this->Posspccat_modal->FSxMPSCEventUpdMasPos($aDataWhere,$aDataAddEdit);
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Edit PosSpcCat'
                    );
                }
            // }else{
            //     $aReturn = array(
            //         'nStaEvent'    => '800',
            //         'tStaMessg'    => "มีข้อมูลนี้อยู่แล้วในระบบ"
            //     );
            // }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Create By : Napat(Jame) 09/05/2022
    public function FSvCPSCEventDelete(){
        try{
            $aDataWhere = array(
                'FTBchCode'         => $this->input->post("tBchCode"),
                'FTShpCode'         => $this->input->post("tShpCode"),
                'FTPosCode'         => $this->input->post("tPosCode"),
                'FNCatSeq'          => $this->input->post("aCatSeq"),
            );
            $aDataAddEdit = array(
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTLastUpdBy'       => $this->session->userdata("tSesUsername"),
            );
            $this->db->trans_begin();
            $this->Posspccat_modal->FSxMPSCEventDelete($aDataWhere);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess to delete."
                );
            }else{
                $this->Posspccat_modal->FSxMPSCEventUpdMasPos($aDataWhere,$aDataAddEdit);
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Delete Success.'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
}
