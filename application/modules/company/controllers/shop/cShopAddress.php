<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cShopAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/shop/mShopAddress');
    }

    // Functionality : Call View Shop Address
	// Parameters : From Ajax File j
	// Creator : 10/09/2019 Wasin
	// Last Modified : -
	// Return : String View
    // Return Type : View
    public function FSvCSHPAddressData(){
        $aDataConfigView    = [
            'tShopAddrBchCode'  => $this->input->post('ptBchCode'),
            'tShopAddrShpCode'  => $this->input->post('ptShpCode'),
            'tShopAddrShpName'  => $this->input->post('ptShpName'),
            'aAlwShopAddress'   => FCNaHCheckAlwFunc('shop/0/0'),
        ];
        $this->load->view('company/shop/address/wShopAddressData',$aDataConfigView);
    }

    // Functionality : Call View Shop Address Data Table
	// Parameters : From Ajax File j
	// Creator : 10/09/2019 Wasin
	// Last Modified : -
	// Return : String View
    // Return Type : View
    public function FSvCSHPAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAddRefCode'  => $this->input->post('ptShopCode')
        ];
        $aShopDataAddress   = $this->mShopAddress->FSaMShopAddressDataList($aDataWhere);
        $this->load->view('company/shop/address/wShopAddressDataTable',array(
            'aShopDataAddress' => $aShopDataAddress
        ));
    }

    // Functionality : Call View Shop Address Page Add
    // Parameters : Ajax Call View Add
    // Creator : 10/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSvCSHPAddressCallPageAdd(){
        $tShpAddrShopCode   = $this->input->post('ptShpAddrShpCode');
        $aShopDataVersion   = $this->mShopAddress->FSaMShopAddressGetVersion();
        $aDataViewAdd       = [
            'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
            'tShpAddrShopCode'      => $tShpAddrShopCode,
            'aShopDataVersion'      => $aShopDataVersion
        ];
        $this->load->view('company/shop/address/wShopAddressViewForm',$aDataViewAdd);
    }

    // Functionality : Call View Shop Address Page Edit
    // Parameters : Ajax Call View Edit
    // Creator : 11/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSvCSHPAddressCallPageEdit(){
        $aDataWhereAddress  = [
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aShopDataVersion   = $this->mShopAddress->FSaMShopAddressGetVersion();
        $aDataAddress       = $this->mShopAddress->FSaMShopAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit      = [
            'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
            'tShpAddrShopCode'      => $aDataWhereAddress['FTAddRefCode'],
            'aShopDataVersion'      => $aShopDataVersion,
            'aDataAddress'          => $aDataAddress
        ];
        $this->load->view('company/shop/address/wShopAddressViewForm',$aDataViewEdit);
    }

    // Functionality : Event Shop Address Add
    // Parameters : Ajax Event Add
    // Creator : 10/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSoCSHPAddressAddEvent(){
        try{
            $this->db->trans_begin();
            $tShopAddrVersion   = $this->input->post('ohdShopAddressVersion');
            if(isset($tShopAddrVersion) && $tShopAddrVersion == 1){
                $aShopDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdShopAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdShopAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetShopAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetShopAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetShopAddressRmk"),
                    'FTAddVersion'      => $tShopAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetShopAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetShopAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetShopAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetShopAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetShopAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetShopAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetShopAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetShopAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetShopAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdShopAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdShopAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                ];
            }else{
                $aShopDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdShopAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdShopAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetShopAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetShopAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetShopAddressRmk"),
                    'FTAddVersion'      => $tShopAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetShopAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetShopAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetShopAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdShopAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdShopAddressMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }
        
            $this->mShopAddress->FSxMShopAddressAddData($aShopDataAddress);
            $this->mShopAddress->FSxMShopAddressUpdateSeq($aShopDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Add Shop Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Shop Address.',
                    'tDataCodeReturn'   => $aShopDataAddress['FTAddRefCode']
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Shop Address Edit
    // Parameters : Ajax Event Edit
    // Creator : 11/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSoCSHPAddressEditEvent(){
        try{
            $this->db->trans_begin();
            $tShopAddrVersion   = $this->input->post('ohdShopAddressVersion');
            if(isset($tShopAddrVersion) && $tShopAddrVersion == 1){
                $aShopDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdShopAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdShopAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdShopAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetShopAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetShopAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetShopAddressRmk"),
                    'FTAddVersion'      => $tShopAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetShopAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetShopAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetShopAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetShopAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetShopAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetShopAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetShopAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetShopAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetShopAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdShopAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdShopAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aShopDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdShopAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdShopAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdShopAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetShopAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetShopAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetShopAddressRmk"),
                    'FTAddVersion'      => $tShopAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetShopAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetShopAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetShopAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdShopAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdShopAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mShopAddress->FSxMShopAddressEditData($aShopDataAddress);
            $this->mShopAddress->FSxMShopAddressUpdateSeq($aShopDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Update Shop Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Update Shop Address.',
                    'tDataCodeReturn'   => $aShopDataAddress['FTAddRefCode']
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Shop Address Delete
    // Parameters : Ajax Event Delete
    // Creator : 11/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSoCSHPAddressDeleteEvent(){
        try{
            $this->db->trans_begin();

            $aDataWhereDelete   = [
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];

            $this->mShopAddress->FSaMShopAddressDelete($aDataWhereDelete);
            $this->mShopAddress->FSxMShopAddressUpdateSeq($aDataWhereDelete);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn'    => 500,
                    'tStaMessg'     => "Error Unsucess Delete Shop Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Shop Address.',
                    'tDataCodeReturn'   => $aDataWhereDelete['FTAddRefCode']
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaEvent' => $Error['tCodeReturn'],
                'tStaMessg' => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }


}