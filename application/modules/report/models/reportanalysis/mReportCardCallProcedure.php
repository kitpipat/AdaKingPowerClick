<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
set_time_limit(0);
ini_set('memory_limit', '-1');

class mReportcardCallProcedure extends CI_Model {
        
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 6/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreSaleShopByDate($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สาขา
        $tBchCodeFrom = empty($paDataReport['tBchCodeFrom']) ? '' : $paDataReport['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataReport['tBchCodeTo']) ? '' : $paDataReport['tBchCodeTo']; 
        // ร้านค้า
        $tShpCodeFrom = empty($paDataReport['tShpCodeFrom']) ? '' : $paDataReport['tShpCodeFrom']; 
        $tShpCodeTo = empty($paDataReport['tShpCodeTo']) ? '' : $paDataReport['tShpCodeTo']; 
        // วันที่
        $tDateFrom = empty($paDataReport['tDateFrom']) ? '' : $paDataReport['tDateFrom']; 
        $tDateTo = empty($paDataReport['tDateTo']) ? '' : $paDataReport['tDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxSaleShopByDate]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxSaleShopByDate(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptShpF' => $tShpCodeFrom,
            'ptShpT' => $tShpCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 6/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreSaleShopByShop($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สาขา
        $tBchCodeFrom = empty($paDataReport['tBchCodeFrom']) ? '' : $paDataReport['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataReport['tBchCodeTo']) ? '' : $paDataReport['tBchCodeTo']; 
        // ร้านค้า
        $tShpCodeFrom = empty($paDataReport['tShpCodeFrom']) ? '' : $paDataReport['tShpCodeFrom']; 
        $tShpCodeTo = empty($paDataReport['tShpCodeTo']) ? '' : $paDataReport['tShpCodeTo']; 
        // วันที่
        $tDateFrom = empty($paDataReport['tDateFrom']) ? '' : $paDataReport['tDateFrom']; 
        $tDateTo = empty($paDataReport['tDateTo']) ? '' : $paDataReport['tDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxSaleShopByShop]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxSaleShopByShop(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptShpF' => $tShpCodeFrom,
            'ptShpT' => $tShpCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 6/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreCardActiveSummary($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สาขา
        $tBchCodeFrom = empty($paDataReport['tBchCodeFrom']) ? '' : $paDataReport['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataReport['tBchCodeTo']) ? '' : $paDataReport['tBchCodeTo']; 
        // รหัสเลขหลังบัตร
        $tCrdCodeFrom = empty($paDataReport['tCrdCodeFrom']) ? '' : $paDataReport['tCrdCodeFrom']; 
        $tCrdCodeTo = empty($paDataReport['tCrdCodeTo']) ? '' : $paDataReport['tCrdCodeTo']; 
        // วันที่
        $tDateFrom = empty($paDataReport['tDateFrom']) ? '' : $paDataReport['tDateFrom']; 
        $tDateTo = empty($paDataReport['tDateTo']) ? '' : $paDataReport['tDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCardActiveSummary]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardActiveSummary(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptCrdF' => $tCrdCodeFrom,
            'ptCrdT' => $tCrdCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 6/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreCardActiveDetail($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สาขา
        $tBchCodeFrom = empty($paDataReport['tBchCodeFrom']) ? '' : $paDataReport['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataReport['tBchCodeTo']) ? '' : $paDataReport['tBchCodeTo']; 
        // รหัสเลขหลังบัตร
        $tCrdCodeFrom = empty($paDataReport['tCrdCodeFrom']) ? '' : $paDataReport['tCrdCodeFrom']; 
        $tCrdCodeTo = empty($paDataReport['tCrdCodeTo']) ? '' : $paDataReport['tCrdCodeTo']; 
        // วันที่
        $tDateFrom = empty($paDataReport['tDateFrom']) ? '' : $paDataReport['tDateFrom']; 
        $tDateTo = empty($paDataReport['tDateTo']) ? '' : $paDataReport['tDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCardActiveDetail]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardActiveDetail(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptCrdF' => $tCrdCodeFrom,
            'ptCrdT' => $tCrdCodeTo,
            'ptDocDateF' => $tDateFrom,
            'ptDocDateT' => $tDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 6/06/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSnMExecStoreUnExchangeBalance($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // วันที่สร้างเอกสาร
        $tDateExpiredFrom = empty($paDataReport['tDateExpiredFrom']) ? '' : $paDataReport['tDateExpiredFrom'];
        $tDateExpiredTo = empty($paDataReport['tDateExpiredTo']) ? '' : $paDataReport['tDateExpiredTo'];
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxUnExchangeBalance]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxUnExchangeBalance(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'ptComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptExpDateF'        => $tDateExpiredFrom,
            'ptExpDateT'        => $tDateExpiredTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
    
}
