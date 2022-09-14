<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cCustomerBranch extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('customerlicense/customerlicense/mCustomerBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
        date_default_timezone_set("Asia/Bangkok");
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLBListPage(){
        $tCstCode = $this->input->post('tCstCode');
        $tSrvStaCenter = $this->mCustomerBranch->FStMCLBGetServerTypeByCst($tCstCode);
        $aParam = array(
            'tSrvStaCenter' => $tSrvStaCenter,
        );
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/wCstTabBchList',$aParam);
    }

    /**
     * Functionality : Function Call DataTables Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLBDataList(){

        $tCstCode = $this->input->post('tCstCode');
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'tCstCode'      => $tCstCode,
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $aResList = $this->mCustomerBranch->FSaMCLBList($aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/wCstTabBchDataTable', $aGenTable);
    }
    
    /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLBAddPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $rtCstCode = $this->input->post('rtCstCode');

        $tRegLicType = $this->mCustomerBranch->FStMCLBGetBusinessTypeByCst($rtCstCode);
        $aDataAdd = array(
            'aResult'   => array('rtCode'=>'99'),
            'FNLngID'   => $nLangEdit,
            'tRegLicType' => $tRegLicType
        );
        
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/wCstTabBchPageForm',$aDataAdd);
    }




    /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCLBAddEvent(){
        try{

            $rtCstCode = $this->input->post('rtCstCode');
            $rnCbrSeq = $this->input->post('rnCbrSeq');
            $rtSrvCode = $this->input->post('rtSrvCode');
            $rtCbrRefBch = $this->input->post('rtCbrRefBch');
            $rtCbrRefBchName = $this->input->post('rtCbrRefBchName');
            $rnCbrQtyPos = $this->input->post('rnCbrQtyPos');
    
            $rnCbrLastSeq =  $this->mCustomerBranch->FSaCLBGetLastSeqCstBch($rtCstCode);

            $aDataCstBch = array(
                'FTCstCode' => $rtCstCode,
                'FNCbrSeq' => $rnCbrLastSeq+1,
                'FTCbrRefBch' => $rtCbrRefBch,
                'FTCbrRefBchName' => $rtCbrRefBchName,
                'FNCbrQtyPos' => $rnCbrQtyPos,
                'FTSrvCode' => $rtSrvCode,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
            );

            $this->db->trans_begin();
            $this->mCustomerBranch->FSaCLBInsertUpdateCstBch($aDataCstBch);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'    => '01',
                    'tStaMessg'    => "Sucess Add Event"
                );

            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     /**
     * Functionality : Function CallPage Customer Add
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLBEditPage(){
        $nLangEdit      = $this->session->userdata("tLangEdit");

        $aParam = array(
            'FNLngID' => $nLangEdit,
            'FTCstCode' => $this->input->post('rtCstCode'),
            'FNCbrSeq' => $this->input->post('rnCbrSeq'),
        );
        $aResult = $this->mCustomerBranch->FSaMCLBSearchByID($aParam);
        $rtCstCode = $this->input->post('rtCstCode');
        $tRegLicType = $this->mCustomerBranch->FStMCLBGetBusinessTypeByCst($rtCstCode);

        $aDataAdd = array(
            'aResult'   => $aResult,
            'FNLngID'   => $nLangEdit,
            'tRegLicType' => $tRegLicType
        );
      
        $this->load->view('customerlicense/customerlicense/tab/customerbranch/wCstTabBchPageForm',$aDataAdd);
    }



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCLBEditEvent(){
        try{

            $rtCstCode = $this->input->post('rtCstCode');
            $rnCbrSeq = $this->input->post('rnCbrSeq');
            $rtSrvCode = $this->input->post('rtSrvCode');
            $rtCbrRefBch = $this->input->post('rtCbrRefBch');
            $rtCbrRefBchName = $this->input->post('rtCbrRefBchName');
            $rnCbrQtyPos = $this->input->post('rnCbrQtyPos');


            $aDataCstBch = array(
                'FTCstCode' => $rtCstCode,
                'FNCbrSeq' => $rnCbrSeq,
                'FTCbrRefBch' => $rtCbrRefBch,
                'FTCbrRefBchName' => $rtCbrRefBchName,
                'FNCbrQtyPos' => $rnCbrQtyPos,
                'FTSrvCode' => $rtSrvCode,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername')
            );

            $this->db->trans_begin();
            $this->mCustomerBranch->FSaCLBInsertUpdateCstBch($aDataCstBch);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Event"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaEvent'    => '01',
                    'tStaMessg'    => "Sucess Add Event"
                );

            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    /**
     * Functionality : Delete Customer Branch
     * Parameters : -
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoCLBDelete(){
        try{
            $tCstCode = $this->input->post('rtCstCode');
            $rnCbrSeq = $this->input->post('rnCbrSeq');

            $tCbrRefBch =  $this->db->where('FTCstCode',$tCstCode)->where('FNCbrSeq',$rnCbrSeq)->get('TRGMCstBch')->row_array()['FTCbrRefBch'];

            if(!empty($tCbrRefBch)){
                $aParamData = array(
                        'FTCstCode'=> $tCstCode,
                        'FTAddRefNo' => $tCbrRefBch,
                        'FTAddGrpType' => 4
                );
                $this->mCustomerBranch->FSnMCLBDelBchAddr($aParamData);
            }
            $aCst = ['FTCstCode' => $tCstCode,'FNCbrSeq' => $rnCbrSeq ];
            $this->mCustomerBranch->FSnMCLBDel($aCst);
            $aReturn = array(
                'nStaEvent'    => '01',
                'tStaMessg'    => "Sucess Delete Event"
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }
    
    

}
