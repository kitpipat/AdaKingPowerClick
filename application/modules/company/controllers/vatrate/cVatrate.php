<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cVatrate extends MX_Controller {
    public function __construct() {
        parent::__construct ();
        $this->load->model('company/vatrate/mVatrate');
        date_default_timezone_set("Asia/Bangkok");
    }

    /**
    * Functionality : Vat Rate List.
    * Parameters : $nVatBrowseType, $tVatBrowseOption
    * Creator : 23/08/2018 piya
    * Last Modified : -
    * Return : {return}
    * Return Type : {type}
    */
    public function index($nVatBrowseType, $tVatBrowseOption){
        $nMsgResp   = array('title'=>"Vatrate");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('vatrate/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventVatrate	= FCNaHCheckAlwFunc('vatrate/0/0');
        $this->load->view ('company/vatrate/wVatrate', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nVatBrowseType'    => $nVatBrowseType,
            'tVatBrowseOption'  => $tVatBrowseOption,
            'aAlwEventVatrate'  => $aAlwEventVatrate
        ));
    }

    /**
     * Functionality : Create or Update Vat Rate
     * Parameters : -
     * Creator : 23/08/2018 piya
     * Last Modified : 27/08/2018 piya
     * Return : {return}
     * Return Type : {type}
     */
    public function FSxVATCreateOrUpdate(){
        $tIsAutoGenCode = $this->input->post('ocbVatrateAutoGenCode');
        $tAddVatCode = $this->input->post('oetVatCode');
        $tData = $this->input->post('tData');
        
        // Setup Vat Rate Code
        if(isset($tIsAutoGenCode) && $tIsAutoGenCode == '1'){ // Check Auto Gen Vat Rate Code?
            // Auto Gen Vat Rate Code

            $aStoreParam = array(
                "tTblName"   => 'TCNMVatRate',                           
                "tDocType"   => 0,                                          
                "tBchCode"   => "",                                 
                "tShpCode"   => "",                               
                "tPosCode"   => "",                     
                "dDocDate"   => date("Y-m-d")       
            );
            $aAutogen   		= FCNaHAUTGenDocNo($aStoreParam);
            $tAddVatCode        = $aAutogen[0]["FTXxhDocNo"];
        }
        
        $this->db->trans_begin();
        $this->mVatrate->FSoMVATDelete($tAddVatCode);
        
        $aData = json_decode($tData);
        foreach ($aData as $oData){
            $this->mVatrate->FSoMVATCreateOrUpdate($tAddVatCode, $oData);
        }
        
        if($this->db->trans_status() === false){
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent'    => '900',
                'tStaMessg'    => "Unsucess Add Event"
            );
        }else{
            $this->db->trans_commit();
            $aReturn = array(
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'tCodeReturn'	=> $tAddVatCode,
                'nStaEvent'	    => '1',
                'tStaMessg'		=> 'Success Add Vatrate'
            );
        }
        echo json_encode($aReturn);
    }
    
    /**
    * Functionality : Vatrate unique check
    * Parameters : $tSelect "vatcode" or "vatrate-vatstart"
    * Creator : 22/08/2018 piya
    * Last Modified : 27/08/2018 piya
    * Return : Check status true or false
    * Return Type : String
    */
    public function FStVATUniqueValidate($tSelect = ''){
        
        if($this->input->is_ajax_request()){ // Request check
            if($tSelect == 'vatcode'){
                $tAddVatCode = $this->input->post('tAddVatCode');
                $oVatrate = $this->mVatrate->FSoMVATGetByVCode($tAddVatCode);

                $tStatus = 'false';
                if(FCNnHSizeOf($oVatrate->result_array()) > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                return;
            }
            if($tSelect == 'vatrate-vatstart'){
                $tAddVatCode = $this->input->post('tAddVatCode');
                $tAddVatRate = $this->input->post('tAddVatRate');
                $tAddVatStart = $this->input->post('tAddVatStart');
                $oVatrate = $this->mVatrate->FSoMVATGetByVCodeVRateVStart($tAddVatCode, $tAddVatRate, $tAddVatStart);

                $tStatus = 'false';
                if(FCNnHSizeOf($oVatrate->result_array()) > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                return;
            }
            if($tSelect == 'vatstart'){
                $tAddVatCode = $this->input->post('tAddVatCode');
                // $tAddVatRate = $this->input->post('tAddVatRate');
                $tAddVatStart = $this->input->post('tAddVatStart');
                $oVatrate = $this->mVatrate->FSoMVATGetByVCodeVRateVStart($tAddVatCode, $tAddVatRate = '', $tAddVatStart);

                $tStatus = 'false';
                if(FCNnHSizeOf($oVatrate->result_array()) > 0){ // If have record
                    $tStatus = 'true';
                }
                echo $tStatus;
                return;
            }
            echo 'Param not match.';
        }else{
            echo 'Method Not Allowed';
        }
    }

    /**
     * Functionality : Function Call Page Vatrate List
     * Parameters : Ajax Function Call View
     * Creator : 13/06/2018 wasin
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvVATListPage(){
        $aAlwEventVatrate	= FCNaHCheckAlwFunc('vatrate/0/0');
        $aNewData  			= array( 'aAlwEventVatrate' => $aAlwEventVatrate);
        $this->load->view('company/vatrate/wVatrateList',$aNewData);
    }

    /**
     * Functionality : Function Call DataTables Vatrate List
     * Parameters : Ajax Function Call View
     * Creator : 13/06/2018 wasin
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvVATDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        date_default_timezone_set("Asia/Bangkok");
        $dGetDataNow    = date('Y-m-d');
        
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'tSearchAll'    => $tSearchAll
        );
        $aResList   = $this->mVatrate->FSaMVATList($aData);
        
        if($aResList['rnAllRow'] == 0){
            $nPage = $nPage - 1;
            $aData['nPage'] = $nPage;
            $aResList   = $this->mVatrate->FSaMVATList($aData);
        }
        
        $aAlwEvent = FCNaHCheckAlwFunc('vatrate/0/0'); //Controle Event
        $aGenTable  = array(
            'aAlwEventVatrate' => $aAlwEvent,
            'aDataList'     => $aResList,
            'nPage'         => $nPage,
            'tSearchAll'    => $tSearchAll,
            'dGetDataNow'  => $dGetDataNow
        );

        $this->load->view('company/vatrate/wVatrateDataTable',$aGenTable);
    }

    /**
     * Functionality : Function CallPage Vatrate Add
     * Parameters : Ajax Call Function
     * Creator : 14/06/2018 wasin
     * Last Modified : -
     * Return : view
     * Return Type : view
     */
    public function FSvVATAddPage(){
		$dGetDataNow    = date('Y-m-d');
        $aDataAdd = array(
            'aResult'      => array('rtCode'=>'99'),
            'dGetDataNow'  => $dGetDataNow
        );
        $this->load->view('company/vatrate/wVatrateAdd',$aDataAdd);
    }

    /**
     * Functionality : Function CallPage Vatrate Edit
     * Parameters : Ajax Function Edit Vatrate
     * Creator : 14/06/2018 wasin
     * Last Modified : 30/08/2018 piya
     * Return : View
     * Return Type : View
     */
    public function FSvVATEditPage(){
		$dGetDataNow    = date('Y-m-d');
        $tVatCode = $this->input->post('tVatCode');
        $aData  = array(
            'FTVatCode' => $tVatCode,
            'dGetDataNow'  => $dGetDataNow
        );
        $aResList = $this->mVatrate->FSaMVATSearchByID($aData); // vat rate by vat code
        $aVatActive = FCNaHVATDateActive($aResList); // return vat rate is active
        $aDataEdit      = array(
            'aResult'       => $aResList,
            'aVatActive'    => $aVatActive,
            'dGetDataNow'   => $dGetDataNow
        );
        $this->load->view('company/vatrate/wVatrateAdd', $aDataEdit);
    }

    /**
     * Functionality : Function Event Delete Vatrate
     * Parameters : Ajax Function Delete Vatrate
     * Creator : 14/06/2018 wasin
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoVATDeleteMultiVat(){
        $tVatCode = $this->input->post('tVatCode');
      
        $aVatCode = json_decode($tVatCode);
        foreach($aVatCode as $oVatCode){
            $this->mVatrate->FSoMVATDelete($oVatCode);
        }
        echo json_encode($aVatCode);
    }
    
    /**
     * Functionality : Delete vat rate
     * Parameters : -
     * Creator : 27/08/2018 piya
     * Last Modified : -
     * Return : Vat code
     * Return Type : Object
     */
    public function FSoVATDelete(){
    
        $tVatCode = $this->input->post('tVatCode');
        $this->mVatrate->FSoMVATDelete($tVatCode);
        echo json_encode($tVatCode);
    }

    /**
     * Functionality : Function Event Delete Single Rate
     * Parameters : Ajax Function Delete Single Rate
     * Creator : 14/06/2018 wasin
     * Last Modified : -
     * Return : Status Event Delete And Status Call Back Event
     * Return Type : object
     */
    public function FSoVATDeleteRate(){
        $tVatCode       = $this->input->post('');
        $tVatDateStart  = $this->input->post(''); 
        $aDataMaster    = array(
            'FTVatCode'     => $tVatCode,
            'FDVatStart'    => $tVatDateStart
        );
    }

    /**
     * Functionality : Function Duplicate Date
     * Parameters : Ajax Function Delete Single Rate
     * Creator : 18/06/2018 wasin
     * Last Modified : -
     * Return : Status Date Duplicate
     * Return Type : object
     */
    public function FSoVatChackDup(){
        $dDateStart = $this->input->post('dDateStart');
        $oCountVat  = $this->mVatrate->FSoMVATChkDup($dDateStart);
        $nCounts   = $oCountVat[0]->counts;
        if($nCounts == 0){
            $aStaCount = array(
                'tStaEvent'    => '1',
                'tStaMessg'    => 'Date Not Duplicate'
            );
        }else{
            $aStaCount = array(
                'tStaEvent'    => '801',
                'tStaMessg'    => "Date is Duplicate"
            );
        }
        echo json_encode($aStaCount);
    }
}


















