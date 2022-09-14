<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cCustomerLicense extends MX_Controller {
    
    public function __construct(){
        parent::__construct ();
        $this->load->model('customerlicense/customerlicense/mCustomerLicense');
        $this->load->model('company/shop/mShop');
        $this->load->model('company/branch/mBranch');
        date_default_timezone_set("Asia/Bangkok");
    }
    
    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    public function index($nCstBrowseType, $tCstBrowseOption){
        $nMsgResp = array('title'=>"Province");
        $isXHR = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/common/wHeader', $nMsgResp);
            $this->load->view ( 'common/common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('customer/0/0'); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $this->load->view ( 'customerlicense/customerlicense/wCustomerLicense', array (
            'nMsgResp'=>$nMsgResp,
            'vBtnSave' => $vBtnSave,
            'nCstBrowseType'=>$nCstBrowseType,
            'tCstBrowseOption'=>$tCstBrowseOption
        ));
    }
    
    /**
     * Functionality : Function Call District Page List
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLNListPage(){
        $this->load->view('customerlicense/customerlicense/wCustomerLicenseList');
    }

    /**
     * Functionality : Function Call DataTables Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLNDataList(){
        $nPage      = $this->input->post('nPageCurrent');
        $tSearchAll = $this->input->post('tSearchAll');
        if($nPage == '' || $nPage == null){$nPage = 1;}else{$nPage = $this->input->post('nPageCurrent');}
        if(!$tSearchAll){$tSearchAll='';}
        //Lang ภาษา
        $nLangResort    = $this->session->userdata("tLangID");
	    $nLangEdit      = $this->session->userdata("tLangEdit");
        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
            'FNLngID'       => $nLangEdit,
            'tSearchAll'    => $tSearchAll
        );

        $tAPIReq = "";
        $tMethodReq = "GET";
        $aResList = $this->mCustomerLicense->FSaMCSTList($tAPIReq, $tMethodReq, $aData);
        $aGenTable = array(
            'aDataList' => $aResList,
            'nPage' => $nPage,
            'tSearchAll' => $tSearchAll
        );
        $this->load->view('customerlicense/customerlicense/wCustomerLicenseDataTable', $aGenTable);
    }
    

    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSvCLNEditPage(){
        $tCstCode   = $this->input->post('tCstCode');
        $nLangEdit  = $this->session->userdata("tLangEdit");
        $aData      = [
            'FTCstCode' => $tCstCode,
            'FNLngID'   => $nLangEdit
        ];
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aCstData       = $this->mCustomerLicense->FSaMCSTSearchByID($tAPIReq, $tMethodReq, $aData);

        $nMemAmtActive = $this->mCustomerLicense->FScMCSTGetAmtActive($tCstCode); //ยอดซื้อสะสม
        $nMemPntActive = $this->mCustomerLicense->FScMCSTGetPntActive($tCstCode); //แต้มสะสม
        $nMemPntExp = $this->mCustomerLicense->FScMCSTGetPntExp($tCstCode); //แต้มสะสมที่จะหมดอายุ
        
        // Check Data Image Customer
        // if(isset($aCstData['raItems']['rtImgObj']) && !empty($aCstData['raItems']['rtImgObj'])){
        //     $tImgObj        = $aCstData['raItems']['rtImgObj'];
        //     $aImgObj        = explode("application/modules/",$tImgObj);
        //     $aImgObjName    = explode("/",$tImgObj);
        //     $tImgObjAll     = $aImgObj[1];
        //     $tImgName		= end($aImgObjName);
        // }else{
        //     $tImgObjAll     = "";
        //     $tImgName       = "";
        // }
        $aDataEdit  = [
            // 'tImgObjAll'    => $tImgObjAll,
            // 'tImgName'      => $tImgName,
            'aResult'       => $aCstData,
            'nMemAmtActive' => $nMemAmtActive,
            'nMemPntActive' => $nMemPntActive,
            'nMemPntExp'    => $nMemPntExp 
        ];
        $this->load->view('customerlicense/customerlicense/wCustomerLicenseAdd',$aDataEdit);
    }
    
 

    /**
     * Functionality : Event Edit Customer
     * Parameters : Ajax and Function Parameter
     * Creator : 18/09/2018 piya
     * Last Modified : -
     * Return : Status Add Event
     * Return Type : String
     */
    public function FSaCLNEditEvent(){
        try{
            // ***** Image Data Customer *****
            $tImgInputCustomer      = $this->input->post('oetImgInputCustomer');
            $tImgInputCustomerOld   = $this->input->post('oetImgInputCustomerOld');
            // ***** Image Data Customer *****

            if($this->input->post('ocbCstHeadQua')==1){
                $tBchCode = FCNtGetBchInComp();
            }else{
                $tBchCode = $this->input->post('oetCstBchCode');
            }

            $aDataMaster = array(
                // Master
                'FTImgObj'          => $this->input->post('oetImgInputCustomer'),
                'FTCstCode'         => $this->input->post('oetCstCode'),
                'FTCstName'         => $this->input->post('oetCstName'),
                'FTCstRmk'          => $this->input->post('otaCstRemark'),
                'FTCstTel'          => $this->input->post('oetCstTel'),
                'FTCstEmail'        => $this->input->post('oetCstEmail'),
                'FTCstCardID'       => $this->input->post('oetCstIdenNum'),
                'FDCstDob'          => $this->input->post('oetCstBirthday'),
                'FTCstSex'          => $this->input->post('orbCstSex'),
                'FTCstBusiness'     => $this->input->post('orbCstBusiness'),
                'FTCstTaxNo'        => $this->input->post('oetCstTaxIdenNum'),
                'FTCstStaActive'    => empty($this->input->post('ocbCstStaActive')) ? 2 : $this->input->post('ocbCstStaActive'),
                'FTCstStaAlwPosCalSo' => empty($this->input->post('ocbCstStaAlwPosCalSo')) ? 2 : $this->input->post('ocbCstStaAlwPosCalSo'),
                'FTCgpCode'         => $this->input->post('oetCstCgpCode'),
                'FTCtyCode'         => $this->input->post('oetCstCtyCode'),
                'FTClvCode'         => $this->input->post('oetCstClvCode'),
                'FTOcpCode'         => $this->input->post('oetCstCstOcpCode'),
                'FTPplCodeRet'      => $this->input->post('oetCstPplRetCode'),
                'FTPplCodeWhs'      => $this->input->post('oetCstWhsCode'),   // รหัสกลุ่มราคา สำหรับ ขายส่ง
                'FTPplCodenNet'     => $this->input->post('oetCstWhsnNetCode'), // รหัสกลุ่มราคา สำหรับ ขายผ่าน Web
                'FTPmgCode'         => $this->input->post('oetCstPmgCode'),
                'FTCstDiscRet'      => $this->input->post('oetCstDiscRet'),
                'FTCstDiscWhs'      => $this->input->post('oetCstDiscWhs'),
                'FTCstBchHQ'        => $this->input->post('ocbCstHeadQua'),
                'FTCstBchCode'      => $tBchCode,
                'FDCstStart'        => $this->input->post('oetUsrDateStart'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FNLngID'           => $this->session->userdata('tLangEdit'),
                'FTAgnCode'         => $this->input->post('oetCstAgnCode'),
            );
            
            $this->db->trans_begin();
            $this->mCustomerLicense->FSaMCSTAddUpdateMaster($aDataMaster);
            $this->mCustomerLicense->FSaMCSTAddUpdateLang($aDataMaster);
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Update Event"
                );
            }else{
                $this->db->trans_commit();

                // Check Data Image New Compare Image Old
                if($tImgInputCustomer != $tImgInputCustomerOld){
                    $aImageData = [
                        'tModuleName'       => 'customer',
                        'tImgFolder'        => 'customer',
                        'tImgRefID'         => $aDataMaster['FTCstCode'],
                        'tImgObj'           => $tImgInputCustomer,
                        'tImgTable'         => 'TCNMCst',
                        'tTableInsert'      => 'TCNMImgPerson',
                        'tImgKey'           => '',
                        'dDateTimeOn'       => date('Y-m-d H:i:s'),
                        'tWhoBy'            => $this->session->userdata('tSesUsername'),
                        'nStaDelBeforeEdit' => 1
                    ];
                    $aImgReturn = FCNnHAddImgObj($aImageData);
                }
                    ///---------------QMember-----------------------//
                // $aQMemberParam = $this->FSaCCstFormatDataMemberV5($aDataMaster['FTCstCode']);
                // $aMQParams = [
                //     "queueName" => "QMember",
                //     "exchangname" => "",
                //     "params" => $aQMemberParam
                // ];
                // $this->FSxCCSTSendDataMemberV5($aMQParams);

                $aReturn = array(
                    'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataMaster['FTCstCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Update Event'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
      
    }
    



    /**
     * Functionality : Function CallPage Customer Edit
     * Parameters : Ajax and Function Parameter
     * Creator : 14/01/2021 Nale
     * Last Modified : -
     * Return : String View
     * Return Type : View
     */
    public function FSaCLNEditEventExportJson(){
        $nLangEdit      = $this->session->userdata("tLangEdit");
        $tCstCode = $this->input->get('tCstCode');
  
         $aRegCstData = $this->mCustomerLicense->FSaMCLNGetDataExport($tCstCode);

         if(!empty($aRegCstData)){
                if(!empty($aRegCstData['raItems'])){
                    $aPdtData = array(
                        'ptRegBusName' => $aRegCstData['raItems']['FTRegBusName'],
                        'pnRegQtyBch' => $aRegCstData['raItems']['FNRegQtyBch'],
                        'ptCstEmail' => $aRegCstData['raItems']['FTCstEmail'],
                        'ptCstTel' => $aRegCstData['raItems']['FTCstTel'],
                        'ptCstKey' => $tCstCode,
                        'ptSrvStaCenter' => $aRegCstData['raItems']['FTSrvStaCenter'],
                        'ptSrvRefSBUrl' => $aRegCstData['raItems']['FTSrvRefSBUrl'],
                    );  
                }else{
                    $aPdtData = array();
                }

                    $aParamExport = array(
                            'ptFunction' => 'RG_UpdateAccount',
                            'ptSource' => 'MQRegisterPrc',
                            'ptDest' => 'API2PSMaster',
                            'ptFilter' => NULL,
                            'ptConnStr' => NULL,
                            'ptData' => json_encode($aPdtData)
                    );
                }else{
                    $aParamExport = array();
         }
         if(!empty($aParamExport)){
            header('Content-type: application/json');
            header('Content-disposition: attachment; filename='.$tCstCode.'.json');
            echo json_encode($aParamExport);
         }
        exit();

    }


}
