<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class cCustomerAddress extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('customer/customer/mCustomerAddress');
        $this->load->model('customer/customer/mCustomer');
    }
    
    // Functionality : Call View Customer Address
	// Parameters : From Ajax File
	// Creator : 07/11/2019 Wasin(Yoshi)
	// Last Modified : -
	// Return : String View
    // Return Type : View
    public function FSvCCSTAddressData(){
        $aDataConfigView    = [
            'tCSTAddressCode'   => $this->input->post('ptAddrCstCode'),
            'aCSTAlwAddress'    => FCNaHCheckAlwFunc('customer/0/0'),
        ];
        $this->load->view('customer/customer/address/wCustomerAddressData',$aDataConfigView);
    }

    // Functionality : Call View Customer Address Data Table
	// Parameters : From Ajax File
	// Creator : 07/11/2019 Wasin(Yoshi)
	// Return : String View
    // Return Type : View
    public function FSvCCSTAddressDataTable(){
        $aDataWhere     = [
            'FNLngID'   => $this->session->userdata("tLangEdit"),
            'FTCstCode' => $this->input->post('ptCutomerCode')
        ];
        $aCustomerDataAddress   = $this->mCustomerAddress->FSaMCSTAddressDataList($aDataWhere);
        $this->load->view('customer/customer/address/wCustomerAddressDataTable',array(
            'aCustomerDataAddress' => $aCustomerDataAddress
        ));
    }

    // Functionality : Call View Page Customer Add
	// Parameters : From Ajax File
	// Creator : 07/11/2019 Wasin(Yoshi)
	// Return : String View
    // Return Type : View
    public function FSvCCSTAddressCallPageAdd(){
        $tCSTAddrCstCode    = $this->input->post('ptCutomerCode');
        $aCSTDataVersion    = $this->mCustomerAddress->FSaMCSTAddressGetVersion();
        $aDataViewAdd       = [
            'nStaCallView'      => 1, // 1 = Call View Add , 2 = Call View Edits
            'tCSTAddrCstCode'   => $tCSTAddrCstCode,
            'aCSTDataVersion'   => $aCSTDataVersion
        ];
        $this->load->view('customer/customer/address/wCustomerAddressViewForm',$aDataViewAdd);
    }

    // Functionality : Call View Customer Address Page Edit
    // Parameters : Ajax Call View Edit
    // Creator : 11/11/2019 Wasin(Yoshi)
    // Return : String View
    // Return Type : View
    public function FSvCCSTAddressCallPageEdit(){
        $aDataWhereAddress  = [
            'FTCstCode'     => $this->input->post('FTCstCode'),
            'FNLngID'       => $this->input->post('FNLngID'),
            'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
            'FNAddSeqNo'    => $this->input->post('FNAddSeqNo'),
        ];
        $aCSTDataVersion    = $this->mCustomerAddress->FSaMCSTAddressGetVersion();
        $aCSTDataAddress    = $this->mCustomerAddress->FSaMCSTAddressGetDataID($aDataWhereAddress);
        $aDataViewEdit      = [
            'nStaCallView'  => 2, // 1 = Call View Add , 2 = Call View Edits
            'tCSTAddrCstCode'   => $aDataWhereAddress['FTCstCode'],
            'aCSTDataVersion'   => $aCSTDataVersion,
            'aCSTDataAddress'   => $aCSTDataAddress
        ];
        $this->load->view('customer/customer/address/wCustomerAddressViewForm',$aDataViewEdit);
    }

    // Functionality : Event Customer Address Add
    // Parameters : Ajax Event Add
    // Creator : 08/11/2019 Wasin(Yoshi)
    // Return : Objuct Status Insert Event
    // Return Type : Objuct
    public function FSoCCSTAddressAddEvent(){
        try{
            $this->db->trans_begin();
            $tCSTAddrVersion    = $this->input->post('ohdCSTAddressVersion');
            if(isset($tCSTAddrVersion) && $tCSTAddrVersion == 1){
                $aCSTDataAddress    = [
                    'FTCstCode'         => $this->input->post('ohdCSTAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    // 'FTAddGrpType'      => $this->input->post("ohdCSTAddressGrpType"),
                    'FNAddSeqNo'        => $this->input->post("ohdCSTAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetCSTAddressName"),
                    'FTAddRmk'          => $this->input->post("oetCSTAddressRmk"),
                    'FTAreCode'         => $this->input->post("oetCSTAddressAreCode"),
                    'FTZneCode'         => $this->input->post("oetCSTAddressZneChain"),
                    'FTAddGrpType'      => $this->input->post("ocmCstGrpType"),
                    'FTAddVersion'      => $tCSTAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetCSTAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCSTAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetCSTAddressWeb"),
                    'FTAddV1No'         => $this->input->post("oetCSTAddressNo"),
                    'FTAddV1Village'    => $this->input->post("oetCSTAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetCSTAddressRoad"),
                    'FTAddV1Soi'        => $this->input->post("oetCSTAddressSoi"),
                    'FTAreCode'         => $this->input->post("oetCSTAddressAreCode"),
                    'FTZneCode'         => $this->input->post("oetCSTAddressZneCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetCSTAddressPvnCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetCSTAddressDstCode"),
                    'FTAddV1SubDist'    => $this->input->post("oetCSTAddressSubDstCode"),
                    'FTAddV1PostCode'    => $this->input->post("oetCSTAddressPostCode"),
                    'FTAddLongitude'    => $this->input->post("ohdCSTAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCSTAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aCSTDataAddress    = [ 
                    'FTCstCode'         => $this->input->post('ohdCSTAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCSTAddressGrpType"),
                    'FNAddSeqNo'        => $this->input->post("ohdCSTAddressSeqNo"),
                    'FTAddVersion'      => $tCSTAddrVersion,
                    'FTAddName'         => $this->input->post("oetCstAddressName"),
                    'FTAddRefNo'        => $this->input->post("oetCstAddRefNo"),
                    'FTAddGrpType'      => $this->input->post("ocmCstGrpType"),
                    'FTAddV2Desc1'      => $this->input->post("oetCstAddAddress1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCstAddAddress2"),
                    'FTAddWebsite'      => $this->input->post("oetCstAddWeb"),
                    'FTAddRmk'          => $this->input->post("oetCstAddressRmk"),
                    'FTAreCode'         => '',
                    'FTZneCode'         => '',
                    'FTAddLongitude'    => $this->input->post("ohdCSTAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCSTAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')

                ];
            }
       
            $this->mCustomerAddress->FSxMCSTAddressAddData($aCSTDataAddress);
            $this->mCustomerAddress->FSxMCSTAddressUpdateSeq($aCSTDataAddress);

            // Check Transection Database Insert Address And Update Seq Address
            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aDataError = array(
                    'tCodeReturn'   => 500,
                    'tTextStaMessg' => "Error Unsucess Insert Customer Address."
                );
                throw new Exception($aDataError);
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Add Shop Address.',
                    'tDataCodeReturn'   => $aCSTDataAddress['FTCstCode']
                );
                ///---------------QMember-----------------------//
                $aQMemberParam = $this->FSaCCstFormatDataMemberV5($aCSTDataAddress['FTCstCode']);
                $aMQParams = [
                    "queueName" => "QMember",
                    "exchangname" => "",
                    "params" => $aQMemberParam
                ];
                $this->FSxCCSTSendDataMemberV5($aMQParams);
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaReturn'    => $Error['tCodeReturn'],
                'tStaMessg'     => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Customer Address Edit
    // Parameters : Ajax Event Edit
    // Creator : 11/11/2019 Wasin(Yoshi)
    // Return : Objuct Status Update Event
    // Return Type : Object
    public function FSoCCSTAddressEditEvent(){
        try{
            $this->db->trans_begin();

            $tCSTAddrVersion    = $this->input->post('ohdCSTAddressVersion');
            if(isset($tCSTAddrVersion) && $tCSTAddrVersion == 1){
                $aCSTDataAddress    = [
                    'FTCstCode'         => $this->input->post('ohdCSTAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    // 'FTAddGrpType'      => $this->input->post("ohdCSTAddressGrpType"),
                    'FNAddSeqNo'        => $this->input->post("ohdCSTAddressSeqNo"),
                    'FTAddName'         => $this->input->post("oetCSTAddressName"),
                    'FTAddRmk'          => $this->input->post("oetCSTAddressRmk"),
                    'FTAreCode'         => $this->input->post("oetCSTAddressAreCode"),
                    'FTZneCode'         => $this->input->post("oetCSTAddressZneChain"),
                    'FTAddGrpType'      => $this->input->post("ocmCstGrpType"),
                    'FTAddVersion'      => $tCSTAddrVersion,
                    'FTAddV2Desc1'      => $this->input->post("oetCSTAddressV2Desc1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCSTAddressV2Desc2"),
                    'FTAddWebsite'      => $this->input->post("oetCSTAddressWeb"),
                    'FTAddV1No'         => $this->input->post("oetCSTAddressNo"),
                    'FTAddV1Village'    => $this->input->post("oetCSTAddressVillage"),
                    'FTAddV1Road'       => $this->input->post("oetCSTAddressRoad"),
                    'FTAddV1Soi'        => $this->input->post("oetCSTAddressSoi"),
                    'FTAreCode'         => $this->input->post("oetCSTAddressAreCode"),
                    'FTZneCode'         => $this->input->post("oetCSTAddressZneCode"),
                    'FTAddV1PvnCode'    => $this->input->post("oetCSTAddressPvnCode"),
                    'FTAddV1DstCode'    => $this->input->post("oetCSTAddressDstCode"),
                    'FTAddV1SubDist'    => $this->input->post("oetCSTAddressSubDstCode"),
                    'FTAddV1PostCode'    => $this->input->post("oetCSTAddressPostCode"),
                    'FTAddLongitude'    => $this->input->post("ohdCSTAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCSTAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ];
            }else{
                $aCSTDataAddress    = [
                    'FTCstCode'         => $this->input->post('ohdCSTAddressCstCode'),
                    'FNLngID'           => $this->session->userdata("tLangEdit"),
                    'FTAddGrpType'      => $this->input->post("ohdCSTAddressGrpType"),
                    'FNAddSeqNo'        => $this->input->post("ohdCSTAddressSeqNo"),
                    'FTAddVersion'      => $tCSTAddrVersion,
                    'FTAddName'         => $this->input->post("oetCstAddressName"),
                    'FTAddRefNo'        => $this->input->post("oetCstAddRefNo"),
                    'FTAddGrpType'      => $this->input->post("ocmCstGrpType"),
                    'FTAddV2Desc1'      => $this->input->post("oetCstAddAddress1"),
                    'FTAddV2Desc2'      => $this->input->post("oetCstAddAddress2"),
                    'FTAddWebsite'      => $this->input->post("oetCstAddWeb"),
                    'FTAddRmk'          => $this->input->post("oetCstAddressRmk"),
                    'FTAreCode'         => '',
                    'FTZneCode'         => '',
                    'FTAddLongitude'    => $this->input->post("ohdCSTAddressMapLong"),
                    'FTAddLatitude'     => $this->input->post("ohdCSTAddressMapLat"),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')

                ];
            }

            $this->mCustomerAddress->FSxMCSTAddressEditData($aCSTDataAddress);
            $this->mCustomerAddress->FSxMCSTAddressUpdateSeq($aCSTDataAddress);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aDataError = array(
                    'tCodeReturn'   => 500,
                    'tTextStaMessg' => "Error Unsucess Update Customer Address."
                );
                throw new Exception($aDataError);
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Update Customer Address.',
                    'tDataCodeReturn'   => $aCSTDataAddress['FTCstCode']
                );
            ///---------------QMember-----------------------//
            $aQMemberParam = $this->FSaCCstFormatDataMemberV5($aCSTDataAddress['FTCstCode']);
            $aMQParams = [
                "queueName" => "QMember",
                "exchangname" => "",
                "params" => $aQMemberParam
            ];
            $this->FSxCCSTSendDataMemberV5($aMQParams);
            }
        }catch(Exception $Error){
            $aReturnData = array(
                'nStaReturn'    => $Error['tCodeReturn'],
                'tStaMessg'     => $Error['tTextStaMessg']
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality : Event Customer Address Delete
    // Parameters : Ajax Event Delete
    // Creator : 11/11/2019 Wasin(Yoshi)
    // Return : Objuct Status Delete Event
    // Return Type : Objuct
    public function FSoCCSTAddressDeleteEvent(){
        try{
            $this->db->trans_begin();
            $aDataWhereDelete   = [
                'FTCstCode'     => $this->input->post('FTCstCode'),
                'FNLngID'       => $this->input->post('FNLngID'),
                'FTAddGrpType'  => $this->input->post('FTAddGrpType'),
                'FNAddSeqNo'    => $this->input->post('FNAddSeqNo')
            ];
            $this->mCustomerAddress->FSaMCSTAddressDelete($aDataWhereDelete);
            $this->mCustomerAddress->FSxMCSTAddressUpdateSeq($aDataWhereDelete);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aDataError = array(
                    'tCodeReturn'   => 500,
                    'tTextStaMessg' => "Error Unsucess Delete Customer Address."
                );
                throw new Exception($aDataError);
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn'        => 1,
                    'tStaMessg'         => 'Success Delete Customer Address.',
                    'tDataCodeReturn'   => $aDataWhereDelete['FTCstCode']
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

    
   
    public function FSaCCstFormatDataMemberV5($ptCstCode){


        $aCstMaster =  $this->db->where('FTCstCode',$ptCstCode)->get('TCNMCst')->row_array();
        $aCstCard_L = $this->db->where('FTCstCode',$ptCstCode)->get('TCNMCstCard')->row_array();
   ///กรณีลูกค้าใช้ระบบ Member จะมี กลุ่มบัตรใน TsysConfig ใช้ส่งใน MQ
        if(!empty($aCstMaster['FTAgnCode'])){
            $aDataCgp = $this->mCustomer->FScMCSTGetInfoMemberConFigSpc($aCstMaster['FTAgnCode'],1);
                if($aDataCgp['rtCode']=='1'){
                        $tCgpCode = $aDataCgp['raItem']['FTCfgStaUsrValue'];
                }
            $aDataBch = $this->mCustomer->FScMCSTGetInfoMemberConFigSpc($aCstMaster['FTAgnCode'],2);
            if($aDataBch['rtCode']=='1'){
                         $tBchCenter = $aDataBch['raItem']['FTCfgStaUsrValue'];
             }
        }

        if(empty($tCgpCode)){
            $tCgpCode   = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',1)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        }
        if(empty($tBchCenter)){
            $tBchCenter = $this->db->where('FTSysCode','AMQMember')->where('FTSysSeq',2)->get('TSysConfig')->row_array()['FTSysStaUsrValue'];
        }

       $aoTCNMMember = array(
           'FTCgpCode' => $tCgpCode,
           'FTMemCode' => $aCstMaster['FTCstCode'],
           'FTMemCardID' => $aCstMaster['FTCstCardID'],
           'FTMemTaxNo' => $aCstMaster['FTCstTaxNo'],
           'FTMemTel' => $aCstMaster['FTCstTel'],
           'FTMemFax' => $aCstMaster['FTCstFax'],
           'FTMemEmail' => $aCstMaster['FTCstEmail'],
           'FTMemSex' => $aCstMaster['FTCstSex'],
           'FDMemDob' => $aCstMaster['FDCstDob'],
           'FTOcpCode' => $aCstMaster['FTOcpCode'],
           'FTMemBusiness' => $aCstMaster['FTCstBusiness'],
           'FTMemBchHQ' => $aCstMaster['FTCstBchHQ'],
           'FTMemBchCode' => $aCstMaster['FTCstBchCode'],
           'FTMemStaActive' => $aCstMaster['FTCstStaActive'],
           'FDLastUpdOn' => $aCstMaster['FDLastUpdOn'],
           'FTLastUpdBy' => $aCstMaster['FTLastUpdBy'],
           'FDCreateOn' => $aCstMaster['FDCreateOn'],
           'FTCreateBy' => $aCstMaster['FTCreateBy'],
       );

       $aoTCNMMember_L = $this->mCustomer->FSaMCSTGetMasterLang4MQ($tCgpCode,$ptCstCode);
       $aoTCNMMemberAddress_L = $this->mCustomer->FSaMCSTGetAddress4MQ($tCgpCode,$ptCstCode);

       $aoTCNMMemCard = array(
           'FTCgpCode'  => $tCgpCode,
           'FTMemCode'  => $aCstCard_L['FTCstCode'],
           'FTMemCrdNo'  => $aCstCard_L['FTCstCrdNo'],
           'FDMemApply'  => $aCstCard_L['FDCstApply'],
           'FDMemCrdIssue'  => $aCstCard_L['FDCstCrdIssue'],
           'FDMemCrdExpire'  => $aCstCard_L['FDCstCrdExpire'],
       );

       $ptUpdData = array(
        'aoTCNMMember' => ($aoTCNMMember) ? array($aoTCNMMember) : NULL,
        'aoTCNMMember_L' => ($aoTCNMMember_L) ? $aoTCNMMember_L : NULL ,
        'aoTCNMMemCard' => ($aoTCNMMemCard) ? array($aoTCNMMemCard) : NULL,
        'aoTCNMMemAddress_L' => ($aoTCNMMemberAddress_L) ? $aoTCNMMemberAddress_L : NULL,
       );
       $aMemberParam = array(
           'ptFunction' => 'UPDATE_MEMBER',
           'ptSource' => $tBchCenter,
           'ptDest' => 'CENTER',
           'ptDelObj' => '',
           'ptUpdData' => json_encode($ptUpdData)
       );

    //    print_r($aMemberParam);
    //    die();
       return $aMemberParam;
}

public function FSxCCSTSendDataMemberV5($paParams){
    $tQueueName             = $paParams['queueName'];
    $aParams                = $paParams['params'];
    $aParams['ptConnStr']   = DB_CONNECT;
    $tExchange              = EXCHANGE; // This use default exchange
    
    // $oConnection = new AMQPStreamConnection(MemberV5_HOST, MemberV5_PORT, MemberV5_USER, MemberV5_PASS, MemberV5_VHOST);
    // $oChannel = $oConnection->channel();
    // $oChannel->queue_declare($tQueueName, false, true, false, false);
    // $oMessage = new AMQPMessage(json_encode($aParams));
    // $oChannel->basic_publish($oMessage, "", $tQueueName);
    // $oChannel->close();
    // $oConnection->close();
    return 1; /** Success */
}
}