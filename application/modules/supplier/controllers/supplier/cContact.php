<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cContact extends CI_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('pos5/supplier/mContact');
    }

    public function index(){
        // $this->load->view('pos5/supplier/contact/wContact');
    }

    //Functionality : Function Call Page Contact List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCCTRListPage(){
        $this->load->view('pos5/supplier/contact/wContactList');
    }

    //Functionality : Function Call View Data Contact
    //Parameters : Ajax Call View DataTable
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCCTRDataList(){
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
            $aDataList   = $this->mContact->FSaMCTRList($aData);
            $aGenTable  = array(
                'aDataList'  => $aDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll
            );
            $this->load->view('pos5/supplier/contact/wContactDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Contact Add
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCCTRAddPage(){
        try{
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataContact = array(
                'nStaAddOrEdit'   => 99,
                'tSplCode'   => $this->input->post('tSplCode'),
				'aVatRate'		=> $aVatList
            );
            $this->load->view('pos5/supplier/contact/wContactAdd',$aDataContact);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Contact Edits
    //Parameters : Ajax Call View Add
    //Creator : 22/10/2018 Phisan
    //Return : String View
    //Return Type : View
    public function FSvCCTREditPage(){
        try{
            $tSplCode       = $this->input->post('tSplCode');
            $tLngID       = $this->input->post('tLngID');
            $tCtrSeq       = $this->input->post('tCtrSeq');
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
                'FNCtrSeq' => $tCtrSeq,
                'FNLngID'   => $tLngID
            );
            // echo '<pre>';
            // print_r($aData);
            // exit;
            $aDataByID = $this->mContact->FSaMCTRGetDataByID($aData);
            $aVatList = FCNoHCallVatlist(); //-->Call Vat Active
            $aDataContact  = array(
                'nStaAddOrEdit' => 1,
				'aVatRate'		=> $aVatList,
				'tSplCode'		=> $tSplCode,
                'aDataSplCt'      => $aDataByID
            );
            $this->load->view('pos5/supplier/contact/wContactAdd',$aDataContact);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Contact
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCTRAddEvent(){
        try{
            $aDataMaster = array(
                'FTSplCode' => $this->input->post('oetSplCodeCt'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
                'FTCtrName' => $this->input->post('oetCtrName'),
                'FTCtrFax' => $this->input->post('oetCtrFax'),
                'FTCtrTel' => $this->input->post('oetCtrTel'),
                'FTCtrEmail' => $this->input->post('oetCtrEmail'),
                'FTCtrRmk' => $this->input->post('oetCtrRmk'),
                
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            );
            $this->db->trans_begin();
            $this->mContact->FSaMCTRAddMaster($aDataMaster);
            $aLastSeq = $this->mContact->FSaMCTRGetLastSeq();
            // echo '<pre>';
            // print_r($this->mContact->FSaMCTRGetLastSeq());
            // exit;

            $aDataAd  = array(
                'FTSplCode' => $this->input->post('oetSplCodeCt'),//
                'FNLngID' => $this->session->userdata("tLangEdit"),//
                'FTAddGrpType' => '2',//
                'FTAddRefNo' => $aLastSeq['rnCtrSeq'],//
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
            // print_r($aDataAd);
            // exit;
            $this->mContact->FSaMCTRAddDT($aDataAd);
            
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Contact."
                );
            }else{
                $this->db->trans_commit();
                
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTSplCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Contact'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Contact
    //Parameters : Ajax Event
    //Creator : 22/10/2018 Phisan
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCTREditEvent(){
        try{
            $aDataMaster = array(
                'FTSplCode' => $this->input->post('oetSplCodeCt'),
                'FNLngID' => $this->session->userdata("tLangEdit"),
                'FTCtrName' => $this->input->post('oetCtrName'),
                'FTCtrFax' => $this->input->post('oetCtrFax'),
                'FTCtrTel' => $this->input->post('oetCtrTel'),
                'FTCtrEmail' => $this->input->post('oetCtrEmail'),
                'FTCtrRmk' => $this->input->post('oetCtrRmk'),
                
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername')
            );
            $tCtrSeq = $this->input->post('oetCtrSeq');

            $tSplCode = $this->input->post('oetSplCodeCt');
            $tLngID = $this->input->post('oetLngIDCt');
            $tAddGrpType = '2';
            $tAddSeqNo = $this->input->post('oetAddSeqNo');
            
            $aPK = array(
                'FTSplCode' => $tSplCode,
                'FNLngID' => $tLngID,
                'FTAddGrpType' => $tAddGrpType,
                'FNAddSeqNo' => $tAddSeqNo
            );
            $aDataAd  = array(
                
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
            
            $this->db->trans_begin();
            $this->mContact->FSaMCTRUpdateMaster($aDataMaster,$tCtrSeq);
            $this->mContact->FSaMCTRDT($aDataAd,$aPK);

            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Contact."
                );
            }else{
                $this->db->trans_commit();
                
                $aReturn = array(                    
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Contact.'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Contact
    //Parameters : Ajax jReason()
    //Creator : 22/10/2018 Phisan
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCTRDeleteEvent(){
        try{
            $tSplCode = $this->input->post('tSplCode');
            $tLngID = $this->input->post('tLngID');
            $tCtrSeq = $this->input->post('tCtrSeq');
            
            $aDataMaster = array(
                'FTSplCode' => $tSplCode,
                'FNLngID' => $tLngID,
                'FNCtrSeq' => $tCtrSeq
            );
            $aResDel        = $this->mContact->FSnMCTRDel($aDataMaster);
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