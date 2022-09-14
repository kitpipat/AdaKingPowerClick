<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCourierAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('courier/courier/mCourierAddress');
    }

    // Functionality : Call View Courier Address
	// Parameters : From Ajax File JS
	// Creator : 12/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCCRYAddressData(){
        $aDataConfigView    = [
            'tCourierAddrCryCode'  => $this->input->post('ptCryCode'),
            'tCourierAddrCryName'  => $this->input->post('ptCryName'),
            'aAlwCourierAddress'   => FCNaHCheckAlwFunc('courier/0/0'),
        ];
        $this->load->view('courier/courier/address/wCourierAddressData',$aDataConfigView);
    }

    // Functionality : Call View Courier Address Data Table
	// Parameters : From Ajax File j
	// Creator : 12/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCCRYAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAddRefCode'  => $this->input->post('ptCourierCode')
        ];
        $aCourierDataAddress   = $this->mCourierAddress->FSaMCourierAddressDataList($aDataWhere);
        $this->load->view('courier/courier/address/wCourierAddressDataTable',array(
            'aCourierDataAddress' => $aCourierDataAddress
        ));
    }

    // Functionality : Call View Courier Address Page Add
    // Parameters : Ajax Call View Add
    // Creator : 12/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCCRYAddressCallPageAdd(){
        $tCourierAddrCryCode    = $this->input->post('ptCourierAddrCryCode');
        $aCourierDataVersion    = $this->mCourierAddress->FSaMCourierAddressGetVersion();
        $aDataViewAdd           = [
            'nStaCallView'          => 1, // 1 = Call View Add , 2 = Call View Edits
            'tCourierAddrCryCode'   => $tCourierAddrCryCode,
            'aCourierDataVersion'   => $aCourierDataVersion
        ];
        $this->load->view('courier/courier/address/wCourierAddressViewForm',$aDataViewAdd);
    }

    // Functionality : Call View Courier Address Page Edit
    // Parameters : Ajax Call View Edit
    // Creator : 12/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCCRYAddressCallPageEdit(){
        $aDataWhereAddress  = [
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aCourierDataVersion    = $this->mCourierAddress->FSaMCourierAddressGetVersion();
        $aDataAddress           = $this->mCourierAddress->FSaMCourierAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit          = [
            'nStaCallView'          => 2, // 1 = Call View Add , 2 = Call View Edits
            'tCourierAddrCryCode'   => $aDataWhereAddress['FTAddRefCode'],
            'aCourierDataVersion'   => $aCourierDataVersion,
            'aDataAddress'          => $aDataAddress
        ];
        $this->load->view('courier/courier/address/wCourierAddressViewForm',$aDataViewEdit);
    }

    // Functionality: Event Courier Address Add
    // Parameters: Ajax Event Add
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType : View
    public function  FSoCCRYAddressAddEvent(){
        try{
            $this->db->trans_begin();

            // Check Data Version Address
            $tCourierAddrVersion    = $this->input->post('ohdCourierAddressVersion');
            if(isset($tCourierAddrVersion) && $tCourierAddrVersion == 1){
                $aCourierDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCourierAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdCourierAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetCourierAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetCourierAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetCourierAddressRmk"),
                    'FTAddVersion'      => $tCourierAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetCourierAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetCourierAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetCourierAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetCourierAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetCourierAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetCourierAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetCourierAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetCourierAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetCourierAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdCourierAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCourierAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                ];
            }else{
                $aCourierDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCourierAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdCourierAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetCourierAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetCourierAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetCourierAddressRmk"),
                    'FTAddVersion'      => $tCourierAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetCourierAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCourierAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetCourierAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdCourierAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCourierAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mCourierAddress->FSxMCourierAddressAddData($aCourierDataAddress);
            $this->mCourierAddress->FSxMCourierAddressUpdateSeq($aCourierDataAddress);
          
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Add Courier Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Courier Address.',
                    'tDataCodeReturn'   => $aCourierDataAddress['FTAddRefCode']
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

    // Functionality: Event Courier Address Edit
    // Parameters: Ajax Event Edit
    // Creator: 12/09/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSoCCRYAddressEditEvent(){
        try{
            $this->db->trans_begin();
            $tCourierAddrVersion    = $this->input->post('ohdCourierAddressVersion');
            if(isset($tCourierAddrVersion) && $tCourierAddrVersion == 1){
                $aCourierDataAddress    = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCourierAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdCourierAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdCourierAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetCourierAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetCourierAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetCourierAddressRmk"),
                    'FTAddVersion'      => $tCourierAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetCourierAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetCourierAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetCourierAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetCourierAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetCourierAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetCourierAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetCourierAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetCourierAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetCourierAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdCourierAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCourierAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aCourierDataAddress    = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCourierAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdCourierAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdCourierAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetCourierAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetCourierAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetCourierAddressRmk"),
                    'FTAddVersion'      => $tCourierAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetCourierAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCourierAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetCourierAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdCourierAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCourierAddressMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mCourierAddress->FSxMCourierAddressEditData($aCourierDataAddress);
            $this->mCourierAddress->FSxMCourierAddressUpdateSeq($aCourierDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Update Courier Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Update Courier Address.',
                    'tDataCodeReturn'   => $aCourierDataAddress['FTAddRefCode']
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

    // Functionality : Event Courier Address Delete
    // Parameters : Ajax Event Delete
    // Creator : 12/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSoCCRYAddressDeleteEvent(){
        try{
            $this->db->trans_begin();

            $aDataWhereDelete   = [
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];

            $this->mCourierAddress->FSaMCourierAddressDelete($aDataWhereDelete);
            $this->mCourierAddress->FSxMCourierAddressUpdateSeq($aDataWhereDelete);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn'    => 500,
                    'tStaMessg'     => "Error Unsucess Delete Courier Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Courier Address.',
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