<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCustomerBranchAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('customerlicense/customerlicense/mCustomerBranchAddress');
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
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/tab/address/wBranchAddressData',$aDataConfigView);
    }

    // Functionality : Call View Branch Address Data Table
	// Parameters : Function Ajax Parameter
	// Creator : 11/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCBCHAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTCstCode'   => $this->input->post('tCstCode'),
            'FTAddRefNo'  => $this->input->post('tCbrRefBch')
        ];
        $aBranchDataAddress = $this->mCustomerBranchAddress->FSaMCustomerBranchAddressDataList($aDataWhere);
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/tab/address/wBranchAddressDataTable',array(
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
        $aBranchDataVersion     = $this->mCustomerBranchAddress->FSaMCustomerBranchAddressGetVersion();
        $aDataViewAdd           = [
            'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
            'tBchAddrBranchCode'    => $tBranchAddressBchCode,
            'aBranchDataVersion'    => $aBranchDataVersion,
            'tCstCode'   =>  $this->input->post('tCstCode'),
            'tCbrRefBch' =>  $this->input->post('tCbrRefBch'),
        ];
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/tab/address/wBranchAddressViewForm',$aDataViewAdd);
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
            'FTAddRefNo'  => $this->input->post('FTAddRefNo'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
            'FTCstCode'   =>  $this->input->post('FTCstCode'),
            'FTCbrRefBch' =>  $this->input->post('FTCbrRefBch'),
        ];
        $aBranchDataVersion = $this->mCustomerBranchAddress->FSaMCustomerBranchAddressGetVersion();
        $aDataAddress       = $this->mCustomerBranchAddress->FSaMCustomerBranchAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit      = [
            'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
            'tBchAddrBranchCode'    => $aDataWhereAddress['FTAddRefNo'],
            'aBranchDataVersion'    => $aBranchDataVersion,
            'aDataAddress'          => $aDataAddress,
            'tCstCode'   =>  $this->input->post('FTCstCode'),
            'tCbrRefBch' =>  $this->input->post('FTCbrRefBch'),
        ];
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/tab/address/wBranchAddressViewForm',$aDataViewEdit);
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
                    'FTCstCode'         => $this->input->post('ohdBranchAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefNo'        => $this->input->post("ohdBranchAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAreCode'         => '',
                    'FTZneCode'         => '',
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
                ];
            }else{
                $aBranchDataAddress = [
                    'FTCstCode'         => $this->input->post('ohdBranchAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefNo'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAreCode'         => '',
                    'FTZneCode'         => '',
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetBranchAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetBranchAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mCustomerBranchAddress->FSxMCustomerBranchAddressAddData($aBranchDataAddress);
            // $this->mCustomerBranchAddress->FSxMCustomerBranchAddressUpdateSeq($aBranchDataAddress);

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
                    'tDataCodeReturn'   => $aBranchDataAddress['FTAddRefNo']
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
                    'FTCstCode'         => $this->input->post('ohdBranchAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefNo'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdBranchAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
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
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aBranchDataAddress   = [
                    'FTCstCode'         => $this->input->post('ohdBranchAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdBranchAddressGrpType"),
                    'FTAddRefNo'      => $this->input->post("ohdBranchAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdBranchAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetBranchAddressName"),
                    'FTAddRmk'          => $this->input->post("oetBranchAddressRmk"),
                    'FTAddVersion'      => $tBranchAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetBranchAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetBranchAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetBranchAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdBranchAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdBranchAddressMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername')
                ];
            }
            $this->mCustomerBranchAddress->FSxMCustomerBranchAddressEditData($aBranchDataAddress);
            // $this->mCustomerBranchAddress->FSxMCustomerBranchAddressUpdateSeq($aBranchDataAddress);

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
                    'tDataCodeReturn'   => $aBranchDataAddress['FTAddRefNo']
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
                'FTAddRefNo'  => $this->input->post('FTAddRefNo'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
                'FTCstCode'    => $this->input->post('FTCstCode')
            ];

            $this->mCustomerBranchAddress->FSaMCustomerBranchAddressDelete($aDataWhereDelete);
            // $this->mCustomerBranchAddress->FSxMCustomerBranchAddressUpdateSeq($aDataWhereDelete);

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
                    'tDataCodeReturn'   => $aDataWhereDelete['FTAddRefNo']
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
