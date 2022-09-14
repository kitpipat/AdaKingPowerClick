<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cBranchAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('company/branch/mBranchAddress');
    }

    // Functionality : Call View Branch Address
	// Parameters : Ajax Call Function
	// Creator : 11/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCBCHAddressData(){
        $aDataConfigView    = [
            'tBranchAddressCode'    => $this->input->post('ptBchCode'),
            'tBranchAddressName'    => $this->input->post('ptBchName'),
            'aAlwBranchAddress'     => FCNaHCheckAlwFunc('branch/0/0'),
        ];
        $this->load->view('company/branch/address/wBranchAddressData',$aDataConfigView);
    }

    // Functionality : Call View Branch Address Data Table
	// Parameters : Function Ajax Parameter
	// Creator : 11/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCBCHAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAddRefCode'  => $this->input->post('ptBchCode')
        ];
        $aBranchDataAddress = $this->mBranchAddress->FSaMBranchAddressDataList($aDataWhere);
        $this->load->view('company/branch/address/wBranchAddressDataTable',array(
            'aBranchDataAddress' => $aBranchDataAddress
        ));
    }

    // Functionality : Call View Branch Address Page Add
    // Parameters : Ajax Call View Add
    // Creator : 11/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCBCHAddressCallPageAdd(){
        $tBranchAddressBchCode  = $this->input->post('ptBranchAddressBchCode');
        $aBranchDataVersion     = $this->mBranchAddress->FSaMBranchAddressGetVersion();
        $aDataViewAdd           = [
            'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
            'tBchAddrBranchCode'    => $tBranchAddressBchCode,
            'aBranchDataVersion'    => $aBranchDataVersion
        ];
        $this->load->view('company/branch/address/wBranchAddressViewForm',$aDataViewAdd);
    }

    // Functionality : Call View Branch Address Page Edit
    // Parameters : Ajax Call View Edit
    // Creator : 11/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCBCHAddressCallPageEdit(){   
        $aDataWhereAddress  = [
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aBranchDataVersion = $this->mBranchAddress->FSaMBranchAddressGetVersion();
        $aDataAddress       = $this->mBranchAddress->FSaMBranchAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit      = [
            'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
            'tBchAddrBranchCode'    => $aDataWhereAddress['FTAddRefCode'],
            'aBranchDataVersion'    => $aBranchDataVersion,
            'aDataAddress'          => $aDataAddress
        ];
        $this->load->view('company/branch/address/wBranchAddressViewForm',$aDataViewEdit);
    }

    // Functionality : Event Branch Address Add
    // Parameters : Ajax Event Add
    // Creator : 11/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSoCBCHAddressAddEvent(){
        try{
            $this->db->trans_begin();
            $tBranchAddrVersion = $this->input->post('ohdBranchAddressVersion');
            if(isset($tBranchAddrVersion) && $tBranchAddrVersion == 1){
                $aBranchDataAddress = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetBranchAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetBranchAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetBranchAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetBranchAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetBranchAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetBranchAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetBranchAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetBranchAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetBranchAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    'FTAddTel'          => $this->input->post("oetAddressTel"),
                    'FTAddFax'          => $this->input->post("oetAddressFax"),
                ];
            }else{
                $aBranchDataAddress = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetBranchAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetBranchAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetBranchAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                    'FTAddTel'          => $this->input->post("oetAddressTel"),
                    'FTAddFax'          => $this->input->post("oetAddressFax"),
                ];
            }

            $this->mBranchAddress->FSxMBranchAddressAddData($aBranchDataAddress);
            $this->mBranchAddress->FSxMBranchAddressUpdateSeq($aBranchDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => 500,
                    'tStaMessg' => "Error Unsucess Add Branch Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Branch Address.',
                    'tDataCodeReturn'   => $aBranchDataAddress['FTAddRefCode']
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

    // Functionality : Event Branch Address Edit
    // Parameters : Ajax Event Edit
    // Creator : 11/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSoCBCHAddressEditEvent(){
        try{
            $this->db->trans_begin();
            $tBranchAddrVersion = $this->input->post('ohdBranchAddressVersion');
            if(isset($tBranchAddrVersion) && $tBranchAddrVersion == 1){
                $aBranchDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdBranchAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetBranchAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetBranchAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetBranchAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetBranchAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetBranchAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetBranchAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetBranchAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetBranchAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetBranchAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTAddTel'          => $this->input->post("oetAddressTel"),
                    'FTAddFax'          => $this->input->post("oetAddressFax"),
                ];
            }else{
                $aBranchDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdBranchAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetBranchAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetBranchAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetBranchAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTAddTel'          => $this->input->post("oetAddressTel"),
                    'FTAddFax'          => $this->input->post("oetAddressFax"),
                ];
            }
            $this->mBranchAddress->FSxMBranchAddressEditData($aBranchDataAddress);
            $this->mBranchAddress->FSxMBranchAddressUpdateSeq($aBranchDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Update Branch Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Update Branch Address.',
                    'tDataCodeReturn'   => $aBranchDataAddress['FTAddRefCode']
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

    // Functionality : Event Branch Address Delete
    // Parameters : Ajax Event Delete
    // Creator : 11/09/2019 Wasin(Yoshi)
    // LastUpdate : -
    // Return : String View
    // Return Type : View
    public function FSoCBCHAddressDeleteEvent(){
        try{
            $this->db->trans_begin();

            $aDataWhereDelete   = [
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];

            $this->mBranchAddress->FSaMBranchAddressDelete($aDataWhereDelete);
            $this->mBranchAddress->FSxMBranchAddressUpdateSeq($aDataWhereDelete);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Delete Branch Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Branch Address.',
                    'tDataCodeReturn'   => $aDataWhereDelete['FTAddRefCode']
                );
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaReturn'    => $Error['tCodeReturn'],
                'tStaMessg'     => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }



}
