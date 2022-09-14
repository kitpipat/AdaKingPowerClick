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
    public function FSnMExecStoreUseCard1($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom'];
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo'];
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[udemo]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxUseCard1(?,?,?,?,?,?,?,?)}"; // udemo
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult' => 0
            // 'nCountInTemp'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCheckStatusCard($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // ประเภทบัตร
        $tCrdTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom']; 
        $tCrdTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo']; 
        // สถานะบัตร
        $tCrdStaActiveFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tCrdStaActiveTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo']; 
        // วันที่เริ่มใช้งาน
        $tStartDateFrom = empty($paDataReport['tDateStartFrom']) ? '' : $paDataReport['tDateStartFrom']; 
        $tStartDateTo = empty($paDataReport['tDateStartTo']) ? '' : $paDataReport['tDateStartTo']; 
        // วันหมดอายุ
        $tExpDateFrom = empty($paDataReport['tDateExpireFrom']) ? '' : $paDataReport['tDateExpireFrom']; 
        $tExpDateTo = empty($paDataReport['tDateExpireTo']) ? '' : $paDataReport['tDateExpireTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[udemo]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCheckStatusCard(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdTypeF' => $tCrdTypeFrom,
            'ptCrdTypeT' => $tCrdTypeTo,
            'ptCrdStaActiveF' => $tCrdStaActiveFrom,
            'ptCrdStaActiveT' => $tCrdStaActiveTo,
            'ptStartDateF' => $tStartDateFrom,
            'ptStartDateT' => $tStartDateTo,
            'ptExpDateF' => $tExpDateFrom,
            'ptExpDateT' => $tExpDateTo,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreTransferCardInfo($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // ประเภทบัตรเก่า
        $tCrdTypeOldFrom = empty($paDataReport['tCardTypeCodeOldFrom']) ? '' : $paDataReport['tCardTypeCodeOldFrom']; 
        $tCrdTypeOldTo = empty($paDataReport['tCardTypeCodeOldTo']) ? '' : $paDataReport['tCardTypeCodeOldTo']; 
        // ประเภทบัตรใหม่
        $tCrdTypeNewFrom = empty($paDataReport['tCardTypeCodeNewFrom']) ? '' : $paDataReport['tCardTypeCodeNewFrom']; 
        $tCrdTypeNewTo = empty($paDataReport['tCardTypeCodeNewTo']) ? '' : $paDataReport['tCardTypeCodeNewTo']; 
        // รหัสบัตรเก่า
        $tCardCodeOldFrom = empty($paDataReport['tCardCodeOldFrom']) ? '' : $paDataReport['tCardCodeOldFrom']; 
        $tCardCodeOldTo = empty($paDataReport['tCardCodeOldTo']) ? '' : $paDataReport['tCardCodeOldTo']; 
        // รหัสบัตรใหม่
        $tCardCodeNewFrom = empty($paDataReport['tCardCodeNewFrom']) ? '' : $paDataReport['tCardCodeNewFrom']; 
        $tCardCodeNewTo = empty($paDataReport['tCardCodeNewTo']) ? '' : $paDataReport['tCardCodeNewTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[udemo]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxTransferCardInfo(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdTypeOF' => $tCrdTypeOldFrom,
            'ptCrdTypeOT' => $tCrdTypeOldTo,
            'ptCrdTypeNF' => $tCrdTypeNewFrom,
            'ptCrdTypeNT' => $tCrdTypeNewTo,
            'ptCrdOF' => $tCardCodeOldFrom,
            'ptCrdOT' => $tCardCodeOldTo,
            'ptCrdNF' => $tCardCodeNewFrom,
            'ptCrdNT' => $tCardCodeNewTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreAdjustCashInCard($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[AdjustCashInCard]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxAdjustCashInCard(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreClearCardValueForReuse($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // ประเภทบัตร
        $tCardTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom'];
        $tCardTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom'];
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo'];
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxClearCardValueForReuse]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxClearCardValueForReuse(?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptCrdTypeF'        => $tCardTypeFrom,
            'ptCrdTypeT'        => $tCardTypeTo,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCardNoActive($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // ประเภทบัตร
        $tCardTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom'];
        $tCardTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo'];
        // วันที่เริ่มต้น
        $tDateStartFrom = empty($paDataReport['tDateStartFrom']) ? '' : $paDataReport['tDateStartFrom'];
        $tDateStartTo = empty($paDataReport['tDateStartTo']) ? '' : $paDataReport['tDateStartTo'];
        // วันที่สิ้นสุด
        $tDateExpireFrom = empty($paDataReport['tDateExpireFrom']) ? '' : $paDataReport['tDateExpireFrom'];
        $tDateExpireTo = empty($paDataReport['tDateExpireTo']) ? '' : $paDataReport['tDateExpireTo'];
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCardNoActive]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardNoActive(?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptCrdTypeF'        => $tCardTypeFrom,
            'ptCrdTypeT'        => $tCardTypeTo,
            'ptStartDateF'      => $tDateStartFrom,
            'ptStartDateT'      => $tDateStartTo,
            'ptExpDateF'        => $tDateExpireFrom,
            'ptExpDateT'        => $tDateExpireTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCardTimesUsed($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // ประเภทบัตร
        $tCardTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom'];
        $tCardTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo'];
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCardTimesUsed]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardTimesUsed(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptCrdTypeF'        => $tCardTypeFrom,
            'ptCrdTypeT'        => $tCardTypeTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCardBalance($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tStaCardFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tStaCardTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom'];
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo'];
        $tDbName = $this->db->database;
        
        $tSQL = " 
            USE [$tDbName]

            DECLARE	@return_value int,
                    @FNResult int

            SELECT	@FNResult = 0

            EXEC	@return_value = SP_RPTxCardBalance
                    @pnLngID = $nLangID,
                    @pnComName = N'$tComName',
                    @ptRptName = N'$tRptName',
                    @ptCrdStaActF = N'$tStaCardFrom',
                    @ptCrdStaActT = N'$tStaCardTo',
                    @ptDocDateF = N'$tDocDateFrom',
                    @ptDocDateT = N'$tDocDateTo',
                    @FNResult = @FNResult OUTPUT

            SELECT	@FNResult as N'@FNResult'

            SELECT	'Return Value' = @return_value
        ";
        $oQuery = $this->db->query($tSQL);
        
        /*$tCallStore = "{CALL SP_RPTxCardBalance(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdStaActF'      => $tStaCardFrom,
            'ptCrdStaActT'      => $tStaCardTo,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);*/
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCollectExpireCard($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom'];
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo'];
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCollectExpireCard]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCollectExpireCard(?,?,?,?,?)}";
        $aDataStore = array(
            // 'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCardPrinciple($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // ปี
        $tYearCodeFrom = empty($paDataReport['tYearCodeFrom']) ? '' : $paDataReport['tYearCodeFrom']; 
        $tYearCodeTo = empty($paDataReport['tYearCodeTo']) ? '' : $paDataReport['tYearCodeTo'];
        // ประเภทบัตร
        $tCardTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom'];
        $tCardTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo'];
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCardPrinciple]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardPrinciple(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptYearF'            => $tYearCodeFrom,
            'ptYearT'            => $tYearCodeTo,
            'ptCrdTypeF'        => $tCardTypeFrom,
            'ptCrdTypeT'        => $tCardTypeTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCardDetail($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // ประเภทบัตร
        $tCrdTypeFrom = empty($paDataReport['tCardTypeCodeFrom']) ? '' : $paDataReport['tCardTypeCodeFrom']; 
        $tCrdTypeTo = empty($paDataReport['tCardTypeCodeTo']) ? '' : $paDataReport['tCardTypeCodeTo']; 
        // สถานะบัตร
        $tCrdStaActiveFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tCrdStaActiveTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo']; 
        // วันที่เริ่มใช้งาน
        $tStartDateFrom = empty($paDataReport['tDateStartFrom']) ? '' : $paDataReport['tDateStartFrom']; 
        $tStartDateTo = empty($paDataReport['tDateStartTo']) ? '' : $paDataReport['tDateStartTo']; 
        // วันหมดอายุ
        $tExpDateFrom = empty($paDataReport['tDateExpireFrom']) ? '' : $paDataReport['tDateExpireFrom']; 
        $tExpDateTo = empty($paDataReport['tDateExpireTo']) ? '' : $paDataReport['tDateExpireTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];  
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[CardDetail]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCardDetail(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdTypeF' => $tCrdTypeFrom,
            'ptCrdTypeT' => $tCrdTypeTo,
            'ptCrdStaActiveF' => $tCrdStaActiveFrom,
            'ptCrdStaActiveT' => $tCrdStaActiveTo,
            'ptStartDateF' => $tStartDateFrom,
            'ptStartDateT' => $tStartDateTo,
            'ptExpDateF' => $tExpDateFrom,
            'ptExpDateT' => $tExpDateTo,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCheckPrepaid($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName'];
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo'];
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom'];
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo'];
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxCheckPrepaid]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCheckPrepaid(?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID'           => $nLangID,
            'pnComName'         => $tComName,
            'ptRptName'         => $tRptName,
            'ptCrdF'            => $tCardCodeFrom,
            'ptCrdT'            => $tCardCodeTo,
            'ptDocDateF'        => $tDocDateFrom,
            'ptDocDateT'        => $tDocDateTo,
            'FNResult'          => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreCheckCardUseInfo($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สถานะบัตร
        $tCrdStaActiveFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tCrdStaActiveTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo']; 
        // รหัสพนักงาน
        $tEmpCodeFrom = empty($paDataReport['tEmpCodeFrom']) ? '' : $paDataReport['tEmpCodeFrom']; 
        $tEmpCodeTo = empty($paDataReport['tEmpCodeTo']) ? '' : $paDataReport['tEmpCodeTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[CheckCardUseInfo]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxCheckCardUseInfo(?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'ptUserIdF' => $tEmpCodeFrom,
            'ptUserIdT' => $tEmpCodeTo,
            'ptCrdActF' => $tCrdStaActiveFrom,
            'ptCrdActT' => $tCrdStaActiveTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreTopUp($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สถานะบัตร
        $tCrdStaActiveFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tCrdStaActiveTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo']; 
        // รหัสพนักงาน
        $tEmpCodeFrom = empty($paDataReport['tEmpCodeFrom']) ? '' : $paDataReport['tEmpCodeFrom']; 
        $tEmpCodeTo = empty($paDataReport['tEmpCodeTo']) ? '' : $paDataReport['tEmpCodeTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxTopUp]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxTopUp(?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'ptUserIdF' => $tEmpCodeFrom,
            'ptUserIdT' => $tEmpCodeTo,
            'ptCrdStaActiveF' => $tCrdStaActiveFrom,
            'ptCrdStaActiveT' => $tCrdStaActiveTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
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
    public function FSnMExecStoreUseCard2($paDataReport){
        $nLangID = $paDataReport['FNLngID'];
        $tComName = $paDataReport['tCompName'];
        $tRptName = $paDataReport['tRptName']; 
        // สาขา
        $tBchCodeFrom = empty($paDataReport['tBchCodeFrom']) ? '' : $paDataReport['tBchCodeFrom']; 
        $tBchCodeTo = empty($paDataReport['tBchCodeTo']) ? '' : $paDataReport['tBchCodeTo']; 
        // สถานะบัตร
        $tCrdStaActiveFrom = empty($paDataReport['tStaCardFrom']) ? '' : $paDataReport['tStaCardFrom']; 
        $tCrdStaActiveTo = empty($paDataReport['tStaCardTo']) ? '' : $paDataReport['tStaCardTo']; 
        // รหัสพนักงานใหม่
        $tEmpCodeFrom = empty($paDataReport['tEmpCodeFrom']) ? '' : $paDataReport['tEmpCodeFrom']; 
        $tEmpCodeTo = empty($paDataReport['tEmpCodeTo']) ? '' : $paDataReport['tEmpCodeTo']; 
        // รหัสเลขหลังบัตร
        $tCardCodeFrom = empty($paDataReport['tCardCodeFrom']) ? '' : $paDataReport['tCardCodeFrom']; 
        $tCardCodeTo = empty($paDataReport['tCardCodeTo']) ? '' : $paDataReport['tCardCodeTo']; 
        // วันที่สร้างเอกสาร
        $tDocDateFrom = empty($paDataReport['tDocDateFrom']) ? '' : $paDataReport['tDocDateFrom']; 
        $tDocDateTo = empty($paDataReport['tDocDateTo']) ? '' : $paDataReport['tDocDateTo']; 
        
        /*$tSQL = " DECLARE	@return_value int,
                    @nCountInTemp int

                    SELECT	@nCountInTemp = 0

                    EXEC	@return_value = [dbo].[SP_RPTxUseCard2]
                            @pnLngID = 1,
                            @pnComName = N'COM-1',
                            @ptCrdF = NULL,
                            @ptCrdT = NULL,
                            @ptDocDateF = NULL,
                            @ptDocDateT = NULL,
                            @nCountInTemp = @nCountInTemp OUTPUT";
        $oQuery = $this->db->query($tSQL);
        var_dump($oQuery);*/
        
        $tCallStore = "{CALL SP_RPTxUseCard2(?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $aDataStore = array(
            'pnLngID' => $nLangID,
            'pnComName' => $tComName,
            'ptRptName' => $tRptName,
            'ptBchF' => $tBchCodeFrom,
            'ptBchT' => $tBchCodeTo,
            'ptCrdF' => $tCardCodeFrom,
            'ptCrdT' => $tCardCodeTo,
            'ptUserIdF' => $tEmpCodeFrom,
            'ptUserIdT' => $tEmpCodeTo,
            'ptCrdActF' => $tCrdStaActiveFrom,
            'ptCrdActT' => $tCrdStaActiveTo,
            'ptDocDateF' => $tDocDateFrom,
            'ptDocDateT' => $tDocDateTo,
            'FNResult' => 0
        );
        
        $oQuery = $this->db->query($tCallStore, $aDataStore);
        /*$oQuery->next_result();
        $oQuery->free_result(); 
        $result = $this->db->query("SELECT @nCountInTemp as result");
        var_dump($result);*/
        
        if($oQuery !== FALSE){
            unset($oQuery);
            return true;
        }else{
            unset($oQuery);
            return false;
        }
    }
}
