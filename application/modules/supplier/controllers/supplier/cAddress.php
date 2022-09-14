<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cAddress extends CI_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos5/supplier/mAddress');
    }

    public function index(){
        // $this->load->view('pos5/supplier/address/wAddress');
    }

    //Functionality : Function Call Page Address List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCADDListPage(){
        $this->load->view('pos5/supplier/address/wAddressList');
    }

    //Functionality : Function Call View Data Address
    //Parameters : Ajax Call View DataTable
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCADDDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $tSplCode     = $this->input->post('tSplCode');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSplCode'       => $tSplCode,
                'tSearchAll'    => $tSearchAll
            );
            $aDataList   = $this->mAddress->FSaMADDList($aData);
            $aGenTable  = array(
                'aDataList'  => $aDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('pos5/supplier/address/wAddressDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Address Add
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCADDAddPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataAddress = array(
                'nStaAddOrEdit'   => 99,
                'tSplCode'   => $this->input->post('tSplCode'),
				'aVatRate'		=> $aVatList
            );
            $this->load->view('pos5/supplier/address/wAddressAdd',$aDataAddress);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Address Edits
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCADDEditPage(){
        try{
            $tSplCode       = $this->input->post('tSplCode');
            $tLngID       = $this->input->post('tLngID');
            $tAddGrpType       = $this->input->post('tAddGrpType');
            $tAddSeqNo       = $this->input->post('tAddSeqNo');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMSpl_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }
            $aData  = array(
                'FTSplCode' => $tSplCode,
                'FTAddGrpType' => $tAddGrpType,
                'FNAddSeqNo' => $tAddSeqNo,
                'FNLngID'   => $tLngID
            );
            $aDataByID = $this->mAddress->FSaMADDGetDataByID($aData);
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataAddress  = array(
                'nStaAddOrEdit' => 1,
				'aVatRate'		=> $aVatList,
				'tSplCode'		=> $tSplCode,
                'aDataSplAd'      => $aDataByID
            );
            $this->load->view('pos5/supplier/address/wAddressAdd',$aDataAddress);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Address
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Add Event
    //Return Type : String
    public function FSoCADDAddEvent(){
        try{
            $aDataMaster  = array(
                'FTSplCode' => $this->input->post('oetSplCodeAd'),//
                'FNLngID' => $this->session->userdata("tLangEdit"),//
                'FTAddGrpType' => $this->input->post('ocmAddGrpType'),//
                'FTAddName' => $this->input->post('oetAddName'),//
                'FTAddTaxNo' => $this->input->post('oetAddTaxNo'),//
                'FTAddCountry' => $this->input->post('oetAddCountry'),//
                'FTAreCode' => $this->input->post('oetAreCode'),//
                'FTZneCode' => $this->input->post('oetZneCode'),//
                'FTAddVersion' => FCNaHAddressFormat('TCNMSpl'),//
                'FTAddV1No' => $this->input->post('oetAddV1No'),//
                'FTAddV1Soi' => $this->input->post('oetAddV1Soi'),//
                'FTAddV1Village' => $this->input->post('oetAddV1Village'),//
                'FTAddV1Road' => $this->input->post('oetAddV1Road'),//
                'FTAddV1SubDist' => $this->input->post('oetAddV1SubDist'),//
                'FTAddV1DstCode' => $this->input->post('oetAddV1DstCode'),//
                'FTAddV1PvnCode' => $this->input->post('oetAddV1PvnCode'),//
                'FTAddV1PostCode' => $this->input->post('oetAddV1PostCode'),//
                'FTAddV2Desc1' => $this->input->post('oetAddV2Desc1'),//
                'FTAddV2Desc2' => $this->input->post('oetAddV2Desc2'),
                'FTAddWebsite' => $this->input->post('oetAddWebsite'),//
                'FTAddLongitude' => $this->input->post('oetSplAdMapLong'),//
                'FTAddLatitude' => $this->input->post('oetSplAdMapLat'),//


                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            // echo '<pre>';
            // print_r($aDataMaster);
            // exit;
            $this->db->trans_begin();
            $this->mAddress->FSaMADDAddMaster($aDataMaster);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Address."
                );
            }else{
                $this->db->trans_commit();
                
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTSplCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Address'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Address
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCADDEditEvent(){
        try{
            $tSplCodeAd = $this->input->post('oetSplCodeAd');
            $tLngIDAd = $this->input->post('oetLngIDAd');
            $tAddGrpType = $this->input->post('oetAddGrpTypeOld');
            $tAddSeqNo = $this->input->post('oetAddSeqNo');
            
            $aPK = array(
                'FTSplCode' => $tSplCodeAd,
                'FNLngID' => $tLngIDAd,
                'FTAddGrpType' => $tAddGrpType,
                'FNAddSeqNo' => $tAddSeqNo
            );
            $aDataMaster  = array(
                'FTAddGrpType' => $this->input->post('ocmAddGrpType'),
                'FTAddName' => $this->input->post('oetAddName'),//
                'FTAddTaxNo' => $this->input->post('oetAddTaxNo'),//
                'FTAddCountry' => $this->input->post('oetAddCountry'),//
                'FTAreCode' => $this->input->post('oetAreCode'),//
                'FTZneCode' => $this->input->post('oetZneCode'),//
                'FTAddVersion' => FCNaHAddressFormat('TCNMSpl'),//
                'FTAddV1No' => $this->input->post('oetAddV1No'),//
                'FTAddV1Soi' => $this->input->post('oetAddV1Soi'),//
                'FTAddV1Village' => $this->input->post('oetAddV1Village'),//
                'FTAddV1Road' => $this->input->post('oetAddV1Road'),//
                'FTAddV1SubDist' => $this->input->post('oetAddV1SubDist'),//
                'FTAddV1DstCode' => $this->input->post('oetAddV1DstCode'),//
                'FTAddV1PvnCode' => $this->input->post('oetAddV1PvnCode'),//
                'FTAddV1PostCode' => $this->input->post('oetAddV1PostCode'),//
                'FTAddV2Desc1' => $this->input->post('oetAddV2Desc1'),//
                'FTAddV2Desc2' => $this->input->post('oetAddV2Desc2'),//
                'FTAddWebsite' => $this->input->post('oetAddWebsite'),//
                'FTAddLongitude' => $this->input->post('oetSplAdMapLong'),//
                'FTAddLatitude' => $this->input->post('oetSplAdMapLat'),//


                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername')
            );
            // echo print_r($aDataMaster);
            // exit;

            $this->db->trans_begin();
            $this->mAddress->FSaMADDUpdateMaster($aDataMaster,$aPK);
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Address."
                );
            }else{
                $this->db->trans_commit();
                
                $aReturn = array(                    
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Address.'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Address
    //Parameters : Ajax jReason()
    //Creator : 22/10/2018 Phisan
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCADDDeleteEvent(){
        try{
            $tSplCode = $this->input->post('tSplCode');
            $tLngID = $this->input->post('tLngID');
            $tAddGrpType = $this->input->post('tAddGrpType');
            $tAddSeqNo = $this->input->post('tAddSeqNo');
            
            $aDataMaster = array(
                'FTSplCode' => $tSplCode,
                'FNLngID' => $tLngID,
                'FTAddGrpType' => $tAddGrpType,
                'FNAddSeqNo' => $tAddSeqNo
            );
            $aResDel        = $this->mAddress->FSnMADDDel($aDataMaster);
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }



















}