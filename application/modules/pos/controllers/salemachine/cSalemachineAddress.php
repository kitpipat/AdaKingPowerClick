<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cSalemachineAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('pos/salemachine/mSalemachineAddress');
    }

    // Functionality : Call View Salemachine Address
	// Parameters : From Ajax File JS
	// Creator : 16/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCPOSAddressData(){
        $aDataConfigView    = [
            'tSalemachineAddrPosCode'   => $this->input->post('ptPosCode'),
            'aAlwSalemachineAddress'    => FCNaHCheckAlwFunc('salemachine/0/0'),
        ];
        $this->load->view('pos/salemachine/address/wSalemachineAddressData',$aDataConfigView);
    }

    // Functionality : Call View Salemachine Address Data Table
	// Parameters : From Ajax File JS
	// Creator : 16/09/2019 Wasin
	// Return : String View
    // Return Type : View
    public function FSvCPOSAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'       => $this->session->userdata("tLangEdit"),
            'FTAddRefCode'  => $this->input->post('ptSalemachineCode')
        ];
        $aSalemachineDataAddress   = $this->mSalemachineAddress->FSaMSalemachineAddressDataList($aDataWhere);
        $this->load->view('pos/salemachine/address/wSalemachineAddressDataTable',array(
            'aSalemachineDataAddress' => $aSalemachineDataAddress
        ));
    }

    // Functionality : Call View Salemachine Address Page Add
    // Parameters : Ajax Call View Add
    // Creator : 16/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCPOSAddressCallPageAdd(){
        $tSalemachineAddrPosCode    = $this->input->post('ptSalemachineAddrPosCode');
        $aSalemachineDataVersion    = $this->mSalemachineAddress->FSaMSalemachineAddressGetVersion();
        $aDataViewAdd           = [
            'nStaCallView'              => 1, // 1 = Call View Add , 2 = Call View Edits
            'tSalemachineAddrPosCode'   => $tSalemachineAddrPosCode,
            'aSalemachineDataVersion'   => $aSalemachineDataVersion
        ];
        $this->load->view('pos/salemachine/address/wSalemachineAddressViewForm',$aDataViewAdd);
    }

    // Functionality : Call View Salemachine Address Page Edit
    // Parameters : Ajax Call View Edit
    // Creator : 16/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCPOSAddressCallPageEdit(){
        $aDataWhereAddress  = [
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aSalemachineDataVersion    = $this->mSalemachineAddress->FSaMSalemachineAddressGetVersion();
        $aDataAddress               = $this->mSalemachineAddress->FSaMSalemachineAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit              = [
            'nStaCallView'              => 2, // 1 = Call View Add , 2 = Call View Edits
            'tSalemachineAddrPosCode'   => $aDataWhereAddress['FTAddRefCode'],
            'aSalemachineDataVersion'   => $aSalemachineDataVersion,
            'aDataAddress'              => $aDataAddress
        ];
        $this->load->view('pos/salemachine/address/wSalemachineAddressViewForm',$aDataViewEdit);
    }

    // Functionality: Event Salemachine Address Add
    // Parameters: Ajax Event Add
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType : View
    public function  FSoCPOSAddressAddEvent(){
        try{
            $this->db->trans_begin();

            // Check Data Version Address
            $tSalemachineAddrVersion    = $this->input->post('ohdSalemachineAddressVersion');
            if(isset($tSalemachineAddrVersion) && $tSalemachineAddrVersion == 1){
                $aSalemachineDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdSalemachineAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdSalemachineAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetSalemachineAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetSalemachineAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetSalemachineAddressRmk"),
                    'FTAddVersion'      => $tSalemachineAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetSalemachineAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetSalemachineAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetSalemachineAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetSalemachineAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetSalemachineAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetSalemachineAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetSalemachineAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetSalemachineAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetSalemachineAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdSalemachineAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdSalemachineAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                ];
            }else{
                $aSalemachineDataAddress   = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdSalemachineAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdSalemachineAddressRefCode"),
                    'FTAddName'         => $this->input->post("oetSalemachineAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetSalemachineAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetSalemachineAddressRmk"),
                    'FTAddVersion'      => $tSalemachineAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetSalemachineAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetSalemachineAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetSalemachineAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdSalemachineAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdSalemachineAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mSalemachineAddress->FSxMSalemachineAddressAddData($aSalemachineDataAddress);
            $this->mSalemachineAddress->FSxMSalemachineAddressUpdateSeq($aSalemachineDataAddress);
          
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Add Salemachine Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Salemachine Address.',
                    'tDataCodeReturn'   => $aSalemachineDataAddress['FTAddRefCode']
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

    // Functionality: Event Salemachine Address Edit
    // Parameters: Ajax Event Edit
    // Creator: 16/09/2019 Wasin(Yoshi)
    // Return: String View
    // ReturnType: View
    public function FSoCPOSAddressEditEvent(){
        try{
            $this->db->trans_begin();
            $tSalemachineAddrVersion    = $this->input->post('ohdSalemachineAddressVersion');
            if(isset($tSalemachineAddrVersion) && $tSalemachineAddrVersion == 1){
                $aSalemachineDataAddress    = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdSalemachineAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdSalemachineAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdSalemachineAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetSalemachineAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetSalemachineAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetSalemachineAddressRmk"),
                    'FTAddVersion'      => $tSalemachineAddrVersion,
                    'FTAddV1No'         => $this->input->post("oetSalemachineAddressNo"),
                    'FTAddV1Soi'        => $this->input->post("oetSalemachineAddressSoi"),
                    'FTAddV1Village'    => $this->input->post("oetSalemachineAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetSalemachineAddressRoad"),
                    'FTAddV1SubDist'    => $this->input->post("oetSalemachineAddressSubDstCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetSalemachineAddressDstCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetSalemachineAddressPvnCode"),
                    'FTAddV1PostCode'   => $this->input->post("oetSalemachineAddressPostCode"),
                    'FTAddWebsite'      => $this->input->post("oetSalemachineAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdSalemachineAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdSalemachineAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aSalemachineDataAddress    = [
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdSalemachineAddressGrpType"),
                    'FTAddRefCode'      => $this->input->post("ohdSalemachineAddressRefCode"),
                    'FNAddSeqNo'        => $this->input->post("ohdSalemachineAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetSalemachineAddressName"),
                    'FTAddTaxNo'        => $this->input->post("oetSalemachineAddressTaxNo"),
                    'FTAddRmk'          => $this->input->post("oetSalemachineAddressRmk"),
                    'FTAddVersion'      => $tSalemachineAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetSalemachineAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetSalemachineAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetSalemachineAddressWeb"),
                    'FTAddLongitude'    => $this->input->post("ohdSalemachineAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdSalemachineAddressMapLat"),
                    'FTLastUpdBy'        => $this->session->userdata('tSesUsername')
                ];
            }

            $this->mSalemachineAddress->FSxMSalemachineAddressEditData($aSalemachineDataAddress);
            $this->mSalemachineAddress->FSxMSalemachineAddressUpdateSeq($aSalemachineDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 500,
                    'tStaMessg' => "Error Unsucess Update Salemachine Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Update Salemachine Address.',
                    'tDataCodeReturn'   => $aSalemachineDataAddress['FTAddRefCode']
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

    // Functionality : Event Salemachine Address Delete
    // Parameters : Ajax Event Delete
    // Creator : 16/09/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSoCPOSAddressDeleteEvent(){
        try{
            $this->db->trans_begin();

            $aDataWhereDelete   = [
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FTAddRefCode'  => $this->input->post('FTAddRefCode'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];

            $this->mSalemachineAddress->FSaMSalemachineAddressDelete($aDataWhereDelete);
            $this->mSalemachineAddress->FSxMSalemachineAddressUpdateSeq($aDataWhereDelete);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn'    => 500,
                    'tStaMessg'     => "Error Unsucess Delete Salemachine Address."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Salemachine Address.',
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