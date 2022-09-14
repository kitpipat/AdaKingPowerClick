<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class cInv extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('Movement/Movement/mMovement');//
        $this->load->model('Movement/Inventory/mInv');
        date_default_timezone_set("Asia/Bangkok");
    }


    public function index($nMovementType,$tMovementOption){
        $vBtnSave           = FCNaHBtnSaveActiveHTML('mmtINV/0/0');
        $aAlwEventMovement	= FCNaHCheckAlwFunc('mmtINV/0/0');
        $this->load->view ( 'Movement/Inventory/wInventory', array (
            'vBtnSave'          =>$vBtnSave,
            'nMovementType'     =>$nMovementType,
            'tMovementOption'   =>$tMovementOption,
            'aAlwEventMovement' =>$aAlwEventMovement
        ));
    }

    /**
     * Functionality : แสดงหน้า list รายการสินค้าคงคลัง
     * Parameters : -
     * Creator : 15/04/2020 surawat
     * Last Modified : -
     * Return : html ฟอร์มค้นหารายการ
     * Return Type : html
     */
    public function FSxCInvPageList(){
        $aAlwEventMovement	       = FCNaHCheckAlwFunc('mmtINV/0/0');
        $tUsrBchCode     = $this->session->userdata("tSesUsrBchCode");
        $tUsrShpCode     = $this->session->userdata("tSesUsrShpCode");
        $this->load->view('Movement/Inventory/wInvList', array(
            'aAlwEventMovement'    => $aAlwEventMovement,
            'tUsrBchCode'          => $tUsrBchCode,
            'tUsrShpCode'          => $tUsrShpCode
        ));
    }

    /**
     * Functionality : แสดงหน้า list รายการสินค้าคงคลัง
     * Parameters : -
     * Creator : 15/04/2020 surawat
     * Last Modified : -
     * Return : html ฟอร์มค้นหารายการ
     * Return Type : html
     */
    public function FSxCInvDataTableList(){
        try{
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nRow           = 10;
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tDataSearch    = $this->input->post('tDataFilter');
            $tSearchAll     = json_decode($tDataSearch, true);
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => $nRow,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );
            // $aMovementDataList               = $this->mMovement->FSaMMovementList($aData);
            $aInvDataList               = $this->mInv->FSaMInvList($aData);
            $aAlwEventMovement	             = FCNaHCheckAlwFunc('mmtINV/0/0');
            $aGenTable  = array(
                'aDataList'                 => $aInvDataList,
                'nPage'                     => $nPage,
                'nRow'                      => $nRow,
                'tSearchAll'                => $tSearchAll,
                'aAlwEventMovement'         => $aAlwEventMovement,
                'tSearchAll'                => $tSearchAll,
                'nOptDecimalShow'           => FCNxHGetOptionDecimalShow()
            );


            $this->load->view('Movement/Inventory/wInvDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality : แสดงหน้า list รายการสินค้าคงคลัง
     * Parameters : -
     * Creator : 15/04/2020 surawat
     * Last Modified : -
     * Return : html ฟอร์มค้นหารายการ
     * Return Type : html
     */
    public function FSxCInvPdtFhnDataTableList(){
        try{
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nRow           = 10;
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tSearchAll    = $this->input->post('oDataFileter');
            $tPdtCode      = $this->session->userdata("tPdtCode");
            
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => $nRow,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aPdtColorSizeActive        = $this->mInv->FSaMInvPdtFhnColorSizeActive($tSearchAll);
            $aDataPdtFhnByRefCode = array();
            if(!empty($aPdtColorSizeActive)){
                foreach($aPdtColorSizeActive as $nKey => $aPdtClrSze){
                    $aDataPdtFhnByRefCode[$aPdtClrSze['FTFhnRefCode']][] = $aPdtClrSze;
                }
            }
            // echo '<pre>';
            //     print_r($aDataPdtFhnByRefCode);
            // echo '</pre>';
            

            $aInvDataList               = $this->mInv->FSaMInvPdtFhnList($aData);

            $aGenTable  = array(
                'aDataList'                 => $aInvDataList,
                'aDataPdtFhnByRefCode'      => $aDataPdtFhnByRefCode,
                'nPage'                     => $nPage,
                'nRow'                      => $nRow,
                'tSearchAll'                => $tSearchAll,
                'nOptDecimalShow'           => FCNxHGetOptionDecimalShow()
            );


          $this->load->view('Movement/Inventory/wInvPdtFhnDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }




}

