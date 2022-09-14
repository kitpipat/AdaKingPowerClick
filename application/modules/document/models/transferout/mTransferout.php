<?php 
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mTransferout extends CI_Model {
    
    // Functionality: Data List Transfer Out
    // Parameters: function parameters
    // Creator:  02/05/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSaMTXOGetDataTable($paDataCondition){
        $tTXODocType        = $paDataCondition['tTXODocType'];
        $aRowLen            = FCNaHCallLenData($paDataCondition['nRow'],$paDataCondition['nPage']);
        $nLngID             = $paDataCondition['FNLngID'];
        $tTblSelectData     = $paDataCondition['tTblSelectData'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];

        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   = " SELECT c.* FROM(
                        SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo DESC) AS FNRowID,* FROM
                            (   SELECT DISTINCT
                                    TXO.FTBchCode,
                                    BCHL.FTBchName,
                                    TXO.FTXthDocNo,
                                    CONVERT(CHAR(10),TXO.FDXthDocDate,103)   AS FDXthDocDate,
                                    CONVERT(CHAR(5), TXO.FDXthDocDate, 108)  AS FTXthDocTime,
                                    TXO.FTXthStaDoc,
                                    TXO.FTXthStaApv,
                                    TXO.FTXthStaPrcStk,
                                    TXO.FTCreateBy,
                                    USRL.FTUsrName AS FTCreateByName,
                                    TXO.FTXthApvCode,
                                    USRLAPV.FTUsrName AS FTXthApvName
                                    
                                FROM ".$tTblSelectData."    TXO     WITH (NOLOCK)
                                LEFT JOIN TCNMBranch_L      BCHL    WITH (NOLOCK) ON TXO.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID    = $nLngID 
                                LEFT JOIN TCNMUser_L        USRL    WITH (NOLOCK) ON TXO.FTCreateBy     = USRL.FTUsrCode    AND USRL.FNLngID    = $nLngID
                                LEFT JOIN TCNMUser_L        USRLAPV WITH (NOLOCK) ON TXO.FTXthApvCode   = USRLAPV.FTUsrCode AND USRLAPV.FNLngID = $nLngID
                                WHERE 1=1 ";

        // Where FNXthDocType
        switch($tTXODocType){
            case 'PTO':
                $tSQL   .= " AND TXO.FNXthDocType = 2 ";
            break;
            case 'WAH':
                $tSQL   .= " AND TXO.FNXthDocType = 4 ";
            break;
        }
        
        /** ค้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร */
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((TXO.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TXO.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        /* ค้นหาจากสาขา - ถึงสาขา */
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((TXO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TXO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /** ค้นหาจากวันที่ - ถึงวันที่ */
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TXO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TXO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /** ค้นหาสถานะเอกสาร */
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND TXO.FTXthStaDoc = '$tSearchStaDoc' OR TXO.FTXthStaDoc = ''";
            }else{
                $tSQL .= " AND TXO.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        /** ค้นหาสถานะอนุมัติ */
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TXO.FTXthStaApv = '$tSearchStaApprove' OR TXO.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TXO.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /* ค้นหาสถานะประมวลผล */
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TXO.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TXO.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TXO.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSnMTXOGetPageAll($paDataCondition);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataCondition['nRow']);
            $aResult = array(
                'raItems'       => $oDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataCondition['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aResult = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataCondition['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($oDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aResult;
    }

    // Functionality: Data Get Data Page All
    // Parameters: function parameters
    // Creator:  02/05/2019 Wasin(Yoshi)
    // Last Modified: -
    // Return: Data Array
    // Return Type: Array
    public function FSnMTXOGetPageAll($paDataCondition){
        $nLngID             = $paDataCondition['FNLngID'];
        $tTblSelectData     = $paDataCondition['tTblSelectData'];
        $aAdvanceSearch     = $paDataCondition['aAdvanceSearch'];
        // Advance Search
        $tSearchList        = $aAdvanceSearch['tSearchAll'];
        $tSearchBchCodeFrom = $aAdvanceSearch['tSearchBchCodeFrom'];
        $tSearchBchCodeTo   = $aAdvanceSearch['tSearchBchCodeTo'];
        $tSearchDocDateFrom = $aAdvanceSearch['tSearchDocDateFrom'];
        $tSearchDocDateTo   = $aAdvanceSearch['tSearchDocDateTo'];
        $tSearchStaDoc      = $aAdvanceSearch['tSearchStaDoc'];
        $tSearchStaApprove  = $aAdvanceSearch['tSearchStaApprove'];
        $tSearchStaPrcStk   = $aAdvanceSearch['tSearchStaPrcStk'];

        $tSQL   = " SELECT COUNT (TXO.FTXthDocNo) AS counts
                    FROM ".$tTblSelectData." TXO WITH (NOLOCK)
                    LEFT JOIN TCNMBranch_L BCHL WITH (NOLOCK) ON TXO.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                    WHERE 1=1 ";

        /** ค้นหารหัสเอกสาร,ชือสาขา,วันที่เอกสาร */
        if(isset($tSearchList) && !empty($tSearchList)){
            $tSQL .= " AND ((TXO.FTXthDocNo LIKE '%$tSearchList%') OR (BCHL.FTBchName LIKE '%$tSearchList%') OR (CONVERT(CHAR(10),TXO.FDXthDocDate,103) LIKE '%$tSearchList%'))";
        }

        /* ค้นหาจากสาขา - ถึงสาขา */
        if(!empty($tSearchBchCodeFrom) && !empty($tSearchBchCodeTo)){
            $tSQL .= " AND ((TXO.FTBchCode BETWEEN $tSearchBchCodeFrom AND $tSearchBchCodeTo) OR (TXO.FTBchCode BETWEEN $tSearchBchCodeTo AND $tSearchBchCodeFrom))";
        }

        /** ค้นหาจากวันที่ - ถึงวันที่ */
        if(!empty($tSearchDocDateFrom) && !empty($tSearchDocDateTo)){
            $tSQL .= " AND ((TXO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateFrom 00:00:00') AND CONVERT(datetime,'$tSearchDocDateTo 23:59:59')) OR (TXO.FDXthDocDate BETWEEN CONVERT(datetime,'$tSearchDocDateTo 23:00:00') AND CONVERT(datetime,'$tSearchDocDateFrom 00:00:00')))";
        }

        /** ค้นหาสถานะเอกสาร */
        if(!empty($tSearchStaDoc) && ($tSearchStaDoc != "0")){
            if($tSearchStaDoc == 2){
                $tSQL .= " AND TXO.FTXthStaDoc = '$tSearchStaDoc' OR TXO.FTXthStaDoc = ''";
            }else{
                $tSQL .= " AND TXO.FTXthStaDoc = '$tSearchStaDoc'";
            }
        }

        /** ค้นหาสถานะอนุมัติ */
        if(!empty($tSearchStaApprove) && ($tSearchStaApprove != "0")){
            if($tSearchStaApprove == 2){
                $tSQL .= " AND TXO.FTXthStaApv = '$tSearchStaApprove' OR TXO.FTXthStaApv = '' ";
            }else{
                $tSQL .= " AND TXO.FTXthStaApv = '$tSearchStaApprove'";
            }
        }

        /* ค้นหาสถานะประมวลผล */
        if(!empty($tSearchStaPrcStk) && ($tSearchStaPrcStk != "0")){
            if($tSearchStaPrcStk == 3){
                $tSQL .= " AND TXO.FTXthStaPrcStk = '$tSearchStaPrcStk' OR TXO.FTXthStaPrcStk = '' ";
            }else{
                $tSQL .= " AND TXO.FTXthStaPrcStk = '$tSearchStaPrcStk'";
            }
        }

        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'        => '800',
                'rtDesc'        => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality : Delete Transfer Out
    // Parameters : function parameters
    // Creator : 03/05/2018 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSnMTXODelDocument($paDataDoc){
        $tTXODocType    = $paDataDoc['tTXODocType'];
        $tTxoDocNo      = $paDataDoc['tTxoDocNo'];

        $this->db->trans_begin();
        switch($tTXODocType){
            case 'WAH':
                // Document HD 
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTwoHD');

                // Document HD Referrent
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTwoHDRef');

                // Document DT
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTwoDT');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->where_in('FTXthDocKey','TCNTPdtTwoHD');
                $this->db->delete('TCNTDocDTTmp');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTDocHDDisTmp');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTDocDTDisTmp');
            break;
            case 'BCH':
                // Document HD 
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTboHD');

                // Document HD Referrent
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTboHDRef');

                // Document DT
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTPdtTboDT');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->where_in('FTXthDocKey','TCNTPdtTboHD');
                $this->db->delete('TCNTDocDTTmp');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTDocHDDisTmp');

                //Del Temp
                $this->db->where_in('FTXthDocNo',$tTxoDocNo);
                $this->db->delete('TCNTDocDTDisTmp');
            break;
        };

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStaDelDoc = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStaDelDoc = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return $aStaDelDoc;
    }

    // Functionality: Get ShopCode From User Login
    // Parameters: function parameters
    // Creator: 03/05/2018 Wasin(Yoshi)
    // Last Modified: -
    // Return: Array Status Delete
    // ReturnType: array
    public function FSaTXOGetShpCodeForUsrLogin($paDataShp){
        $nLngID     = $paDataShp['FNLngID'];
        $tUsrLogin  = $paDataShp['tUsrLogin'];
        $tSQL       = " SELECT
                            UGP.FTBchCode,
                            BCHL.FTBchName,
                            MCHL.FTMerCode,
                            MCHL.FTMerName,
                            UGP.FTShpCode,
                            SHPL.FTShpName,
                            SHP.FTShpType,
                            SHP.FTWahCode   AS FTWahCode,
                            WAHL.FTWahName  AS FTWahName
                        FROM TCNTUsrGroup UGP           WITH (NOLOCK)
                        LEFT JOIN TCNMBranch BCH        WITH (NOLOCK) ON UGP.FTBchCode = BCH.FTBchCode 
                        LEFT JOIN TCNMBranch_L BCHL     WITH (NOLOCK) ON UGP.FTBchCode = BCHL.FTBchCode AND BCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMShop SHP          WITH (NOLOCK) ON UGP.FTShpCode = SHP.FTShpCode
                        LEFT JOIN TCNMShop_L  SHPL      WITH (NOLOCK) ON SHP.FTShpCode = SHPL.FTShpCode AND SHP.FTBchCode = SHPL.FTBchCode AND SHPL.FNLngID = $nLngID
                        LEFT JOIN TCNMMerchant_L MCHL   WITH (NOLOCK) ON SHP.FTMerCode = MCHL.FTMerCode AND MCHL.FNLngID = $nLngID
                        LEFT JOIN TCNMWaHouse_L WAHL    WITH (NOLOCK) ON SHP.FTWahCode = WAHL.FTWahCode 
                        WHERE FTUsrCode ='$tUsrLogin' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aResult    = $oQuery->row_array();
        }else{
            $aResult    = "";
        }
        unset($oQuery);
        return $aResult;
    }

    //Functionality : Function Get Pdt From Temp List Page
    //Parameters : function parameters
    //Creator : 13/05/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTXOGetDTTempListPage($paDataPdtWhere){
        $aRowLen    = FCNaHCallLenData($paDataPdtWhere['nRow'],$paDataPdtWhere['nPage']);
        $tSQL       = " SELECT c.* FROM(
                            SELECT  ROW_NUMBER() OVER(ORDER BY FNXtdSeqNo ASC) AS rtRowID,* FROM
                                ( SELECT
                                    DOCTMP.FTBchCode,
                                    DOCTMP.FTXthDocNo,
                                    ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                                    DOCTMP.FTXthDocKey,
                                    DOCTMP.FTPdtCode,
                                    DOCTMP.FTXtdPdtName,
                                    DOCTMP.FTXtdStkCode,
                                    DOCTMP.FTPunCode,
                                    DOCTMP.FTPunName,
                                    DOCTMP.FCXtdFactor,
                                    DOCTMP.FTXtdBarCode,
                                    DOCTMP.FTXtdVatType,
                                    DOCTMP.FTVatCode,
                                    DOCTMP.FCXtdVatRate,
                                    DOCTMP.FCXtdQty,
                                    DOCTMP.FCXtdQtyAll,
                                    DOCTMP.FCXtdSetPrice,
                                    DOCTMP.FCXtdAmt,
                                    DOCTMP.FCXtdVat,
                                    DOCTMP.FCXtdVatable,
                                    DOCTMP.FCXtdNet,
                                    DOCTMP.FCXtdCostIn,
                                    DOCTMP.FCXtdCostEx,
                                    DOCTMP.FTXtdStaPrcStk,
                                    DOCTMP.FNXtdPdtLevel,
                                    DOCTMP.FTXtdPdtParent,
                                    DOCTMP.FCXtdQtySet,
                                    DOCTMP.FTXtdPdtStaSet,
                                    DOCTMP.FTXtdRmk,
                                    DOCTMP.FTSessionID,
                                    DOCTMP.FDLastUpdOn,
                                    DOCTMP.FDCreateOn,
                                    DOCTMP.FTLastUpdBy,
                                    DOCTMP.FTCreateBy
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1 ";

        $tTXODocNo          = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey         = $paDataPdtWhere['FTXthDocKey'];
        $tTXOSesSessionID   = $this->session->userdata('tSesSessionID');

        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTXODocNo'";    
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTXODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTXOSesSessionID'";
        $tSQL   .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataList  = $oQuery->result_array();
            $aFoundRow  = $this->FSaMTXOGetDTTempListPageAll($paDataPdtWhere);
            $nFoundRow  = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            $nPageAll   = ceil($nFoundRow/$paDataPdtWhere['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aDataList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paDataPdtWhere['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
                'rnAllRow'      => 0,
                'rnCurrentPage' => $paDataPdtWhere['nPage'],
                "rnAllPage"     => 0,
                'rtCode'        => '800',
                'rtDesc'        => 'data not found',
            );
        }
        unset($oQuery);
        unset($aDataList);
        unset($aFoundRow);
        unset($nFoundRow);
        unset($nPageAll);
        return $aDataReturn;
    }

    //Functionality : Count All DT Temp
    //Parameters : function parameters
    //Creator : 13/05/2019 Wasin(Yoshi)
    //Last Modified : -
    //Return : array
    //Return Type : array
    public function FSaMTXOGetDTTempListPageAll($paDataPdtWhere){
        $tTXODocNo          = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey         = $paDataPdtWhere['FTXthDocKey'];
        $tTXOSesSessionID   = $this->session->userdata('tSesSessionID');


        $tSQL       = " SELECT COUNT (DOCTMP.FTXthDocNo) AS counts
                        FROM TCNTDocDTTmp DOCTMP
                        WHERE 1 = 1 ";

        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTXODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTXODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTXOSesSessionID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail        = $oQuery->row_array();
            $aDataReturn    =  array(
                'rtCountData'   => $aDetail['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    =  array(
                'rtCode'    => '800',
                'rtDesc'    => 'Data Not Found',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aDataReturn;
    }

    // Functionality: Function Get Pdt From Temp
    // Parameters: function parameters
    // Creator: 10/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return: array
    // ReturnType : array
    public function FSaMTXOGetDTTemp($paDataPdtWhere){

        $tTXODocNo      = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataPdtWhere['FTXthDocKey'];
        $tTXOSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT
                        DOCTMP.FTBchCode,
                        DOCTMP.FTXthDocNo,
                        ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                        DOCTMP.FTXthDocKey,
                        DOCTMP.FTPdtCode,
                        DOCTMP.FTXtdPdtName,
                        DOCTMP.FTXtdStkCode,
                        DOCTMP.FTPunCode,
                        DOCTMP.FTPunName,
                        DOCTMP.FCXtdFactor,
                        DOCTMP.FTXtdBarCode,
                        DOCTMP.FTXtdVatType,
                        DOCTMP.FTVatCode,
                        DOCTMP.FCXtdVatRate,
                        DOCTMP.FCXtdQty,
                        DOCTMP.FCXtdQtyAll,
                        DOCTMP.FCXtdSetPrice,
                        DOCTMP.FCXtdAmt,
                        DOCTMP.FCXtdVat,
                        DOCTMP.FCXtdVatable,
                        DOCTMP.FCXtdNet,
                        DOCTMP.FCXtdCostIn,
                        DOCTMP.FCXtdCostEx,
                        DOCTMP.FTXtdStaPrcStk,
                        DOCTMP.FNXtdPdtLevel,
                        DOCTMP.FTXtdPdtParent,
                        DOCTMP.FCXtdQtySet,
                        DOCTMP.FTXtdPdtStaSet,
                        DOCTMP.FTXtdRmk,
                        DOCTMP.FTSessionID,
                        DOCTMP.FDLastUpdOn,
                        DOCTMP.FDCreateOn,
                        DOCTMP.FTLastUpdBy,
                        DOCTMP.FTCreateBy
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1 ";

        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTXOSessionID'";
        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTXODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTXODocKey'";
        $tSQL   .= " ORDER BY DOCTMP.FNXtdSeqNo ASC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aResult;
    }

    // Functionality : Function Get Pdt From Temp
    // Parameters : function parameters
    // Creator : 13/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : array
    // Return Type : array
    public function FSaMTXOSumDTTemp($paDataPdtWhere){
        $tTXODocNo      = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataPdtWhere['FTXthDocKey'];
        $tSesSessionID  = $this->session->userdata('tSesSessionID');   

        $tSQL   = " SELECT SUM(FCXtdAmt) AS FCXtdAmt
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1 ";

        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTXODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTXODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tSesSessionID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oResult = $oQuery->result_array();
        }else{
            $oResult = '';
        }
        return $oResult;
    }

    // Functionality: Function Update DT Temp
    // Parameters: function parameters
    // Creator: 13/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return: array
    // ReturnType : array
    public function FSnMTXOUpdateDTTemp($paDataUpd,$paDataPdtWhere){
        if(is_array($paDataUpd) == 1){
            $tTXODocNo      = $paDataPdtWhere['FTXthDocNo'];
            $tTXODocKey     = $paDataPdtWhere['FTXthDocKey'];
            $tTXOSessionID  = $this->session->userdata('tSesSessionID');
            
            // ลบ Data ใน Temp
            $this->db->where_in('FTSessionID',$tTXOSessionID);
            $this->db->where_in('FTXthDocKey',$tTXODocKey);
            $this->db->where_in('FTXthDocNo',$tTXODocNo);
            $this->db->delete('TCNTDocDTTmp');
            
            // Insert DT Temp
            $this->db->insert_batch('TCNTDocDTTmp', $paDataUpd); 

            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add.',
                );
            }
            return $aStatus;
        }
    }

    // Functionality : Function Get Vat Pdt From Temp
    // Parameters : function parameters
    // Creator : 13/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return : array
    // Return Type : array
    public function FSaMTXOGetVatDTTemp($paDataPdtWhere){
        $tTXODocNo      = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataPdtWhere['FTXthDocKey'];
        $tTXOSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL       = " SELECT DISTINCT
                            FCXtdVatRate,
                            SUM(FCXtdVat)       AS FCXtdVat,
                            SUM(FCXtdVatable)   AS FCXtdVatable
                        FROM TCNTDocDTTmp WITH (NOLOCK)
                        WHERE 1 = 1 ";

        $tSQL   .= " AND FTSessionID    = '$tTXOSessionID'";
        $tSQL   .= " AND FTXthDocNo     = '$tTXODocNo'";
        $tSQL   .= " AND FTXthDocKey    = '$tTXODocKey'";
        $tSQL   .= " GROUP BY FCXtdVatRate ORDER BY FCXtdVatRate ASC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail        = $oQuery->result_array();
            $aReturnData    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aReturnData = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        unset($oQuery);
        unset($aDetail);
        return $aReturnData;
    }

    // Functionality : Count DATA DT Temp
    // Parameters : function parameters
    // Creator : 16/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return : array
    // Return Type : array
    public function FSnMTXOGetCountDTTemp($paDataPdtWhere){
        $tTXODocNo      = $paDataPdtWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataPdtWhere['FTXthDocKey'];
        $tTXOSessionID  = $this->session->userdata('tSesSessionID');

        $tSQL   = " SELECT
                        COUNT(DOCTMP.FTXthDocNo) AS counts
                    FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                    WHERE 1 = 1 ";

        $tSQL   .= " AND DOCTMP.FTXthDocNo  = '$tTXODocNo'";
        $tSQL   .= " AND DOCTMP.FTXthDocKey = '$tTXODocKey'";
        $tSQL   .= " AND DOCTMP.FTSessionID = '$tTXOSessionID'";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
            $aResult = $oDetail[0]['counts'];
        }else{
            $aResult = 0;
        }
        return $aResult;
    }

    // Functionality : Get Data Product DT Temp
    // Parameters : function parameters
    // Creator : 16/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return : array
    // Return Type : array
    public function FSaMTXOGetDataPdt($paDataPdtWhere){
        $tPdtCode   = $paDataPdtWhere['FTPdtCode'];
        $FTPunCode  = $paDataPdtWhere['FTPunCode'];
        $nLngID     = $paDataPdtWhere['FNLngID'];

        $tSQL       = " SELECT
                            PDT.FTPdtCode,
                            PDT.FTPdtStkCode,
                            PDT.FTPdtStkControl,
                            PDT.FTPdtGrpControl,
                            PDT.FTPdtForSystem,
                            PDT.FCPdtQtyOrdBuy,
                            PDT.FCPdtCostDef,
                            PDT.FCPdtCostOth,
                            PDT.FCPdtCostStd,
                            PDT.FCPdtMin,
                            PDT.FCPdtMax,
                            PDT.FTPdtPoint,
                            PDT.FCPdtPointTime,
                            PDT.FTPdtType,
                            PDT.FTPdtSaleType,
                            PDT.FTPdtSetOrSN,
                            PDT.FTPdtStaSetPri,
                            PDT.FTPdtStaSetShwDT,
                            PDT.FTPdtStaAlwDis,
                            PDT.FTPdtStaAlwReturn,
                            PDT.FTPdtStaVatBuy,
                            PDT.FTPdtStaVat,
                            PDT.FTPdtStaActive,
                            PDT.FTPdtStaAlwReCalOpt,
                            PDT.FTPdtStaCsm,
                            PDT.FTTcgCode,
                            PDT.FTPtyCode,
                            PDT.FTPbnCode,
                            PDT.FTPmoCode,
                            PDT.FTVatCode,
                            PDT.FTEvnCode,
                            PDT.FDPdtSaleStart,
                            PDT.FDPdtSaleStop,
                            PDTL.FTPdtName,
                            PDTL.FTPdtNameOth,
                            PDTL.FTPdtNameABB,
                            PDTL.FTPdtRmk,
                            PKS.FTPunCode,
                            PKS.FCPdtUnitFact,
                            VAT.FCVatRate,
                            UNTL.FTPunName,
                            BAR.FTBarCode,
                            PDTSRL.FTSrnCode,
                            PDT.FCPdtCostStd,
                            CAVG.FCPdtCostEx,
                            CAVG.FCPdtCostIn
                        FROM TCNMPdt PDT
                        LEFT JOIN TCNMPdt_L PDTL                ON PDT.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtPackSize  PKS          ON PDT.FTPdtCode    = PKS.FTPdtCode     AND PKS.FTPunCode   = $FTPunCode
                        LEFT JOIN TCNMPdtUnit_L UNTL            ON UNTL.FTPunCode   = $FTPunCode        AND UNTL.FNLngID    = $nLngID
                        LEFT JOIN TCNMPdtBar BAR                ON PKS.FTPdtCode    = BAR.FTPdtCode     AND BAR.FTPunCode   = $FTPunCode
                        LEFT JOIN (SELECT FTVatCode,FCVatRate,FDVatStart   
                                FROM TCNMVatRate WHERE GETdate()> FDVatStart) VAT
                                ON PDT.FTVatCode=VAT.FTVatCode 
                        LEFT JOIN TCNTPdtSerial PDTSRL          ON PDT.FTPdtCode = PDTSRL.FTPdtCode
                        LEFT JOIN TCNMPdtCostAvg CAVG           ON PDT.FTPdtCode = CAVG.FTPdtCode
                        WHERE 1 = 1 ";
                        
        if(isset($tPdtCode) && !empty($tPdtCode)){
            $tSQL   .= "AND PDT.FTPdtCode = '$tPdtCode'";
        }
        $tSQL   .= " ORDER BY FDVatStart DESC";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItem'    => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        return $aResult;
    }

    // Functionality : Get Data Product DT Temp
    // Parameters : function parameters
    // Creator : 16/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return : array
    // Return Type : array
    public function FSaMTXOInsertPDTToTmp($paData,$paDataWhere){
        $paData = $paData['raItem'];
        if($paDataWhere['tOptionAddPdt'] == 1){
            $tSQL = "SELECT
                        FNXtdSeqNo,
                        FCXtdQty 
                     FROM TCNTDocDTTmp 
                     WHERE FTBchCode    = '".$paDataWhere["FTBchCode"]."' 
                     AND FTPdtCode      = '".$paDataWhere["FTPdtCode"]."'
                     AND FTPunCode      = '".$paDataWhere["FTPunCode"]."'
                     AND FTXtdBarCode   = '".$paDataWhere["FTBarCode"]."'
                     AND FTXthDocNo     = '".$paDataWhere["FTXthDocNo"]."'
                     AND FTXthDocKey    = '".$paDataWhere["FTXthDocKey"]."'
                     AND FTSessionID    = '".$paDataWhere["FTSessionID"]."'
                     ORDER BY FNXtdSeqNo
            ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aResult = $oQuery->row_array();
                $this->db->set('FCXtdQty' , $aResult['FCXtdQty'] + 1 );
                $this->db->where('FNXtdSeqNo', $aResult['FNXtdSeqNo']);
                $this->db->where('FTPdtCode', $paDataWhere['FTPdtCode']);
                $this->db->where('FTPunCode', $paDataWhere['FTPunCode']);
                $this->db->where('FTXtdBarCode', $paDataWhere['FTBarCode']);
                $this->db->where('FTXthDocKey', $paDataWhere['FTXthDocKey']);
                $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
                $this->db->update('TCNTDocDTTmp');
                if($this->db->affected_rows() > 0){
                    $aStatus    = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Update Doc DTTemp Success',
                    );
                }else{
                    $aStatus    = array(
                        'rtCode'    => '903',
                        'rtDesc'    => 'Error Not Update Doc DTTemp',
                    );
                }
            }else{
                //เพิ่ม
                $this->db->insert('TCNTDocDTTmp',array(
                    'FTBchCode'         => $paDataWhere['FTBchCode'],
                    'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                    'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                    'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                    'FTPdtCode'         => $paData['FTPdtCode'],
                    'FTXtdPdtName'      => $paData['FTPdtName'],
                    'FTXtdStkCode'      => $paData['FTPdtStkCode'],
                    'FCXtdStkFac'       => 1,
                    'FTPunCode'         => $paData['FTPunCode'],
                    'FTPunName'         => $paData['FTPunName'],
                    'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                    'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                    'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                    'FTVatCode'         => $paData['FTVatCode'],
                    'FCXtdVatRate'      => $paData['FCVatRate'],
                    'FCXtdQty'          => 1,
                    'FCXtdQtyAll'       => $paData['FCPdtUnitFact'],
                    'FCXtdSetPrice'     => $paDataWhere['FCXtdSetPrice'],
                    'FTSessionID'       => $paDataWhere['FTSessionID'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => date('Y-m-d h:i:sa'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                ));
                $this->db->last_query();  
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode'    => '1',
                        'rtDesc'    => 'Add Doc DTTemp Success.',
                    );
                }else{
                    $aStatus = array(
                        'rtCode'    => '905',
                        'rtDesc'    => 'Error Cannot Add Doc DTTemp.',
                    );
                }
            }
        }else{
            //เพิ่ม
            $this->db->insert('TCNTDocDTTmp',array(
                'FTBchCode'         => $paDataWhere['FTBchCode'],
                'FTXthDocNo'        => $paDataWhere['FTXthDocNo'],
                'FNXtdSeqNo'        => $paDataWhere['nCounts'],
                'FTXthDocKey'       => $paDataWhere['FTXthDocKey'],
                'FTPdtCode'         => $paData['FTPdtCode'],
                'FTXtdPdtName'      => $paData['FTPdtName'],
                'FTXtdStkCode'      => $paData['FTPdtStkCode'],
                'FCXtdStkFac'       => 1,
                'FTPunCode'         => $paData['FTPunCode'],
                'FTPunName'         => $paData['FTPunName'],
                'FCXtdFactor'       => $paData['FCPdtUnitFact'],
                'FTXtdBarCode'      => $paDataWhere['FTBarCode'],
                'FTXtdVatType'      => $paData['FTPdtStaVatBuy'],
                'FTVatCode'         => $paData['FTVatCode'],
                'FCXtdVatRate'      => $paData['FCVatRate'],
                'FCXtdQty'          => 1,
                'FCXtdQtyAll'       => $paData['FCPdtUnitFact'],
                'FCXtdSetPrice'     => $paDataWhere['FCXtdSetPrice'],
                'FTSessionID'       => $paDataWhere['FTSessionID'],
                'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FDCreateOn'        => date('Y-m-d h:i:sa'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername')
            ));
            $this->db->last_query();  
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Doc DTTemp Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Doc DTTemp.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality : Clear Product In DT Temp
    // Parameters : function parameters
    // Creator : 17/05/2019 Wasin(Yoshi)
    // LastModified : -
    // Return : array
    // Return Type : array
    public function FSxMTXOClearPdtInTmp($ptTblSelectData){
        $tXthDocKey = $ptTblSelectData.'HD';
        $tSessionID = $this->session->userdata('tSesSessionID');
        
        $this->db->where_in('FTXthDocKey',$tXthDocKey);
        $this->db->where_in('FTSessionID',$tSessionID);
        $this->db->delete('TCNTDocDTTmp');
    }

    // Functionality : Edit Inline Product In Table DT Temp
    // Parameters : function parameters
    // Creator : 17/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSaMTXOUpdateInlineDTTmp($paDataUpdateDT,$paDataWhere){
        $this->db->where('FTXthDocKey',$paDataWhere['FTXthDocKey']);
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
        $this->db->where('FNXtdSeqNo', $paDataWhere['FNXtdSeqNo']);
        $this->db->update('TCNTDocDTTmp', $paDataUpdateDT);
        if ($this->db->affected_rows() > 0) {
            $aStatus    = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Inline Success.',
            );
        } else {
            $aStatus    = array(
                'rtCode'    => '903',
                'rtDesc'    => 'Error Not Update Inline.',
            );
        }
        return $aStatus;
    }

    // Functionality : Delete Product In Table DT Temp
    // Parameters : function parameters
    // Creator : 17/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSaMTXOPdtDeleteInDtTmp($paDataWhere){
        $this->db->trans_begin();
        $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
        $this->db->where('FNXtdSeqNo',$paDataWhere['FNXtdSeqNo']);
        // $this->db->where('FTPdtCode',$paDataWhere['FTPdtCode']);
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->delete('TCNTDocDTTmp');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Cannot Delete Product Item.',
            );
        }else{
            $this->db->trans_commit();
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Delete Complete.',
            );
        }
        return $aStatus;
    }

    // Functionality : Delete Product Multiple In Table DT Temp
    // Parameters : function parameters
    // Creator : 21/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Delete
    // Return Type : array
    public function FSxMTXODelMultiDTTmp($paDataWhere){
        $this->db->where_in('FTXthDocNo', $paDataWhere['FTXthDocNo']);
        $this->db->where_in('FTXthDocKey', $paDataWhere['FTXthDocKey']);
        $this->db->where_in('FTSessionID', $paDataWhere['FTSessionID']);
        $this->db->where_in('FNXtdSeqNo', $paDataWhere['FNXtdSeqNo']);
        $this->db->delete('TCNTDocDTTmp');
        return;
    }

    // Functionality : Count Check Data Product In DT Temp Before Save
    // Parameters : function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Count
    // Return Type : array
    public function FSnMTXOChkPdtDtTmpForTnf($paDataWhere){
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataWhere['FTXthDocKey'];
        $tTXOSessionID  = $paDataWhere['FTSessionID'];
        $tSQL           = " SELECT
                                COUNT(FNXtdSeqNo) AS nCountPdt
                            FROM TCNTDocDTTmp DocDT
                            WHERE 1=1
                            AND DocDT.FTXthDocNo    = '$tTXODocNo'
                            AND DocDT.FTXthDocKey   = '$tTXODocKey'
                            AND DocDT.FTSessionID   = '$tTXOSessionID' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->row_array()["nCountPdt"];
        }else{
            return 0;
        }
    }

    // Functionality : Count Check Data Product In DT Temp Before Save
    // Parameters : function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document HD
    // Return Type : array
    public function FSaMTXOAddUpdateHD($paDataMaster,$paDataWhere,$paTableAddUpdate){
        // Update Document HD
        $aDataUpdateHD      = array_merge($paDataMaster,array(
            'FDLastUpdOn'   => $paDataWhere['FDLastUpdOn'],
            'FTLastUpdBy'   => $paDataWhere['FTLastUpdBy']
        ));
        $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
        $this->db->update($paTableAddUpdate['tTableHD'],$aDataUpdateHD);
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Master Success',
            );
        }else{
            // Add Document HD
            $aDataInsertHD  = array_merge($paDataMaster,array(
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FDCreateOn'    => $paDataWhere['FDCreateOn'],
                'FTCreateBy'    => $paDataWhere['FTCreateBy'],
            ));
            $this->db->insert($paTableAddUpdate['tTableHD'],$aDataInsertHD);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Master Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality : เพิ่มข้อมูลรายการจัดส่ง
    // Parameters : Controller function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Add/Update Document Ref.
    // Return Type : array
    public function FSaMTXOAddUpdateHDRef($paDataHDRef,$paDataWhere,$paTableAddUpdate){
        // Update Document Ref
        $aDataUpdateHDRef   = array_merge(array('FTBchCode' => $paDataWhere['FTBchCode']),$paDataHDRef);
        $this->db->where('FTXthDocNo',$paDataWhere['FTXthDocNo']);
        $this->db->update($paTableAddUpdate['tTableHDRef'],$aDataUpdateHDRef);
        if($this->db->affected_rows() > 0){
            $aStatus    = array(
                'rtCode'    => '1',
                'rtDesc'    => 'Update Document Ref Success.',
            );
        }else{
            // Add Document Ref
            $aDataAddHDRef  = array_merge(array(
                'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
                'FTBchCode'     => $paDataWhere['FTBchCode'],
            ),$paDataHDRef);
            $this->db->insert($paTableAddUpdate['tTableHDRef'],$aDataAddHDRef);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Document Ref Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Document Ref.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality : Update DocNo In Doc Temp
    // Parameters : function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update DocNo In Doc Temp
    // Return Type : array
    public function FSaMTXOAddUpdateDocNoInDocTemp($paDataWhere,$paTableAddUpdate){
        $this->db->where('FTXthDocNo','');
        $this->db->where('FTSessionID',$paDataWhere['FTSessionID']);
        $this->db->where('FTXthDocKey',$paTableAddUpdate['tTableHD']);
        $this->db->update('TCNTDocDTTmp',array(
            'FTXthDocNo'    => $paDataWhere['FTXthDocNo'],
            'FTBchCode'     => $paDataWhere['FTBchCode']
        ));
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'OK',
            );
        }else{
            $aStatus = array(
                'rtCode' => '903',
                'rtDesc' => 'Not Update',
            );
        }
        return $aStatus;
    }

    // Functionality : Insert Tempt To DT
    // Parameters : function parameters
    // Creator : 22/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Tempt To DT
    // Return Type : array
    public function FSaMTXOInsertTmpToDT($paDataWhere,$paTableAddUpdate){
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $tTXODocKey     = $paTableAddUpdate['tTableHD'];
        $tTXOSessionID  = $this->session->userdata('tSesSessionID');    
                      
        if($paDataWhere['FTXthDocNo'] != ''){
            $this->db->where_in('FTXthDocNo', $paDataWhere['FTXthDocNo']);
            $this->db->delete($paTableAddUpdate['tTableDT']);
        }

        $tSQL   = " INSERT INTO ".$paTableAddUpdate['tTableDT']." (
                    FTBchCode,FTXthDocNo,FNXtdSeqNo,FTPdtCode,FTXtdPdtName,FTXtdStkCode,FTPunCode,FTPunName,FCXtdFactor,
                    FTXtdBarCode,FTXtdVatType,FTVatCode,FCXtdVatRate,FCXtdQty,FCXtdQtyAll,FCXtdSetPrice,FCXtdAmt,FCXtdVat,
                    FCXtdVatable,FCXtdNet,FCXtdCostIn,FCXtdCostEx,FTXtdStaPrcStk,FNXtdPdtLevel,FTXtdPdtParent,FCXtdQtySet,
                    FTXtdPdtStaSet,FTXtdRmk,FDLastUpdOn,FTLastUpdBy,FDCreateOn,FTCreateBy ) ";

        $tSQL   .=  "   SELECT
                            DOCTMP.FTBchCode,    
                            DOCTMP.FTXthDocNo,
                            ROW_NUMBER() OVER(ORDER BY DOCTMP.FNXtdSeqNo ASC) AS FNXtdSeqNo,
                            DOCTMP.FTPdtCode,
                            DOCTMP.FTXtdPdtName,
                            DOCTMP.FTXtdStkCode,
                            DOCTMP.FTPunCode,
                            DOCTMP.FTPunName,
                            DOCTMP.FCXtdFactor,
                            DOCTMP.FTXtdBarCode,
                            DOCTMP.FTXtdVatType,
                            DOCTMP.FTVatCode,
                            DOCTMP.FCXtdVatRate,
                            DOCTMP.FCXtdQty,
                            DOCTMP.FCXtdQtyAll,
                            DOCTMP.FCXtdSetPrice,
                            DOCTMP.FCXtdAmt,
                            DOCTMP.FCXtdVat,
                            DOCTMP.FCXtdVatable,
                            DOCTMP.FCXtdNet,
                            DOCTMP.FCXtdCostIn,
                            DOCTMP.FCXtdCostEx,
                            DOCTMP.FTXtdStaPrcStk,
                            DOCTMP.FNXtdPdtLevel,
                            DOCTMP.FTXtdPdtParent,
                            DOCTMP.FCXtdQtySet,
                            DOCTMP.FTXtdPdtStaSet,
                            DOCTMP.FTXtdRmk,
                            DOCTMP.FDLastUpdOn,
                            DOCTMP.FTLastUpdBy,
                            DOCTMP.FDCreateOn,
                            DOCTMP.FTCreateBy
                        FROM TCNTDocDTTmp DOCTMP WITH (NOLOCK)
                        WHERE 1 = 1
                        AND DOCTMP.FTSessionID  = '$tTXOSessionID'
                        AND DOCTMP.FTXthDocNo   = '$tTXODocNo'
                        AND DOCTMP.FTXthDocKey  = '$tTXODocKey'
                        ORDER BY DOCTMP.FNXtdSeqNo ASC ";

        $oQuery = $this->db->query($tSQL);
        if($oQuery > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Add DT Success.',
            );
        }else{
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'Error Cannot Add DT.',
            );
        }
        return $aStatus;
    }

    // Functionality : Get Data Document DT
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Document DT
    // Return Type : array
    public function FSaMTXOGetDTDocument($paData,$paTableAddUpdate){
        $tTXODocType    = $paData['tTXODocType'];
        $tTXODocNo      = $paData['FTXthDocNo'];
        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $tTXOSQL    = "";
        switch($tTXODocType){
            case 'WAH':
                $tTXOSQL    .= " SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY FTXthDocNo ASC) AS FNRowID,* FROM
                                    (   SELECT DISTINCT
                                            DTDOC.FTBchCode,
                                            DTDOC.FTXthDocNo,
                                            DTDOC.FNXtdSeqNo,
                                            DTDOC.FTPdtCode,
                                            DTDOC.FTXtdPdtName,
                                            DTDOC.FTXtdStkCode,
                                            DTDOC.FTPunCode,
                                            DTDOC.FTPunName,
                                            DTDOC.FCXtdFactor,
                                            DTDOC.FTXtdBarCode,
                                            DTDOC.FTXtdVatType,
                                            DTDOC.FTVatCode,
                                            DTDOC.FCXtdVatRate,
                                            DTDOC.FCXtdQty,
                                            DTDOC.FCXtdQtyAll,
                                            DTDOC.FCXtdSetPrice,
                                            DTDOC.FCXtdAmt,
                                            DTDOC.FCXtdVat,
                                            DTDOC.FCXtdVatable,
                                            DTDOC.FCXtdNet,
                                            DTDOC.FCXtdCostIn,
                                            DTDOC.FCXtdCostEx,
                                            DTDOC.FTXtdStaPrcStk,
                                            DTDOC.FNXtdPdtLevel,
                                            DTDOC.FTXtdPdtParent,
                                            DTDOC.FCXtdQtySet,
                                            DTDOC.FTXtdPdtStaSet,
                                            DTDOC.FTXtdRmk,
                                            DTDOC.FDLastUpdOn,
                                            DTDOC.FTLastUpdBy,
                                            DTDOC.FDCreateOn,
                                            DTDOC.FTCreateBy
                                        FROM ".$paTableAddUpdate['tTableDT']." DTDOC ";
                if(@$tTXODocNo != ''){
                    $tTXOSQL    .= " WHERE (DTDOC.FTXthDocNo = '$tTXODocNo')";
                }
                $tTXOSQL    .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
            break;
        }
        
        $oQuery = $this->db->query($tTXOSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->result_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'Success Get Data DT Document.'
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        unset($tSQL);
        unset($oQuery);
        unset($aDetail);
        return $aResult;
    }
    
    // Functionality : Update Total HD Document
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Sta Update Total HD Document
    // Return Type : array
    public function FSnMTXOUpdateHDFCXthTotal($paDataUpdTotalHD,$paDataWhere,$paTableAddUpdate){
        $this->db->where('FTXthDocNo', $paDataWhere['FTXthDocNo']);
        $this->db->update($paTableAddUpdate['tTableHD'],$paDataUpdTotalHD);
        if($this->db->affected_rows() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    // Functionality : Get Data Document HD
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Document HD
    // Return Type : array
    public function FSaMTXOGetDataDocHD($paDataWhere){
        $tTXODocType    = $paDataWhere['tTXODocType'];
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $nLngID         = $paDataWhere['FNLngID'];

        switch($tTXODocType){
            case 'WAH':
                $tTXOSQL    = " SELECT
                                    DOCHD.FTBchCode,
                                    DOCHD.FTXthMerCode,
                                    MCHL.FTMerName,
                                    DOCHD.FTXthDocNo,
                                    DOCHD.FTXthShopFrm,
                                    FSHP.FTShpType      AS FTShpTypeFrm,
                                    FSHPL.FTShpName     AS FTShpNameFrm,
                                    DOCHD.FTXthShopTo,
                                    TSHP.FTShpType      AS FTShpTypeTo,
                                    TSHPL.FTShpName     AS FTShpNameTo,
                                    DOCHD.FDXthDocDate,
                                    CONVERT(CHAR(5),DOCHD.FDXthDocDate,108) AS FTXthDocTime,
                                    DOCHD.FTXthVATInOrEx,
                                    DOCHD.FTDptCode,
                                    DOCHD.FTXthWhFrm,
                                    POSLF.FTPosCode     AS FTPosCodeF,
                                    POSLF.FTPosComName  AS FTPosComNameF,
                                    POSLT.FTPosCode     AS FTPosCodeT,
                                    POSLT.FTPosComName  AS FTPosComNameT,
                                    WAHLF.FTWahName     AS FTWahNameFrm,
                                    DOCHD.FTXthWhTo,
                                    WAHLT.FTWahName     AS FTWahNameTo,
                                    DOCHD.FTUsrCode,
                                    DOCHD.FTSpnCode,
                                    DOCHD.FTXthApvCode,
                                    DOCHD.FTXthRefExt,
                                    DOCHD.FDXthRefExtDate,
                                    DOCHD.FTXthRefInt,
                                    DOCHD.FDXthRefIntDate,
                                    DOCHD.FNXthDocPrint,
                                    DOCHD.FCXthTotal,
                                    DOCHD.FCXthVat,
                                    DOCHD.FCXthVatable,
                                    DOCHD.FTXthRmk,
                                    DOCHD.FTXthStaDoc,
                                    DOCHD.FTXthStaApv,
                                    DOCHD.FTXthStaPrcStk,
                                    DOCHD.FTXthStaDelMQ,
                                    DOCHD.FNXthStaDocAct,
                                    DOCHD.FNXthStaRef,
                                    DOCHD.FTRsnCode,
                                    DOCHD.FDLastUpdOn,
                                    DOCHD.FTLastUpdBy,
                                    DOCHD.FDCreateOn,
                                    DOCHD.FTCreateBy,
                                    BCHL.FTBchName,
                                    DPTL.FTDptName,
                                    DOCHDREF.FTXthCtrName,
                                    DOCHDREF.FDXthTnfDate,
                                    DOCHDREF.FTXthRefTnfID,
                                    DOCHDREF.FTXthRefVehID,
                                    DOCHDREF.FTXthQtyAndTypeUnit,
                                    DOCHDREF.FNXthShipAdd,
                                    DOCHDREF.FTViaCode,
                                    USRL.FTUsrName,
                                    USRAPV.FTUsrName    AS FTUsrNameApv
                                FROM TCNTPdtTwoHD DOCHD
                                LEFT JOIN TCNMMerchant_L    MCHL        ON DOCHD.FTXthMerCode   = MCHL.FTMerCode    AND MCHL.FNLngID        = $nLngID
                                LEFT JOIN TCNMBranch_L      BCHL        ON DOCHD.FTBchCode      = BCHL.FTBchCode    AND BCHL.FNLngID        = $nLngID
                                LEFT JOIN TCNMUser_L        USRL        ON DOCHD.FTCreateBy     = USRL.FTUsrCode    AND USRL.FNLngID        = $nLngID
                                LEFT JOIN TCNMUser_L        USRAPV      ON DOCHD.FTXthApvCode   = USRAPV.FTUsrCode  AND USRAPV.FNLngID      = $nLngID
                                LEFT JOIN TCNMUsrDepart_L   DPTL        ON DOCHD.FTDptCode      = DPTL.FTDptCode    AND DPTL.FNLngID        = $nLngID
                                LEFT JOIN TCNMShop          FSHP        ON DOCHD.FTXthShopFrm   = FSHP.FTShpCode
                                LEFT JOIN TCNMShop_L        FSHPL       ON DOCHD.FTXthShopFrm   = FSHPL.FTShpCode   AND FSHPL.FNLngID       = $nLngID
                                LEFT JOIN TCNMShop          TSHP        ON DOCHD.FTXthShopTo    = TSHP.FTShpCode
                                LEFT JOIN TCNMShop_L        TSHPL       ON DOCHD.FTXthShopTo    = TSHPL.FTShpCode   AND TSHPL.FNLngID       = $nLngID
                                LEFT JOIN TCNMWaHouse_L     WAHLF       ON DOCHD.FTXthWhFrm     = WAHLF.FTWahCode   AND WAHLF.FNLngID       = $nLngID
                                LEFT JOIN TCNMWaHouse_L     WAHLT       ON DOCHD.FTXthWhTo      = WAHLT.FTWahCode   AND WAHLT.FNLngID       = $nLngID
                                LEFT JOIN TCNMWaHouse       POSF        ON DOCHD.FTXthWhFrm     = POSF.FTWahCode    AND POSF.FTWahStaType   = '6'
                                LEFT JOIN TCNMPosLastNo     POSLF       ON POSF.FTWahRefCode    = POSLF.FTPosCode
                                LEFT JOIN TCNMWaHouse       POST        ON DOCHD.FTXthWhTo      = POST.FTWahCode    AND POST.FTWahStaType   = '6'
                                LEFT JOIN TCNMPosLastNo     POSLT       ON POST.FTWahRefCode    = POSLT.FTPosCode
                                LEFT JOIN TCNTPdtTwxHDRef   DOCHDREF    ON DOCHD.FTXthDocNo     = DOCHDREF.FTXthDocNo
                                WHERE 1=1 AND DOCHD.FTXthDocNo = '$tTXODocNo' ";
            break;
            case 'BCH':
                $tTXOSQL    = "";
            break;
        }

        $oQuery = $this->db->query($tTXOSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }
    
    // Functionality : Get Data Document HD Ref
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Document HD Ref
    // Return Type : array
    public function FSaMTXOGetDataDocHDRef($paDataWhere){
        $tTXODocType    = $paDataWhere['tTXODocType'];
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $nLngID         = $paDataWhere['FNLngID'];
        switch($tTXODocType){
            case 'WAH' :
                $tTXOSql    = " SELECT
                                    DOCHDREF.FTBchCode,
                                    DOCHDREF.FTXthDocNo,
                                    DOCHDREF.FTXthCtrName,
                                    DOCHDREF.FDXthTnfDate,
                                    DOCHDREF.FTXthRefTnfID,
                                    DOCHDREF.FTXthRefVehID,
                                    DOCHDREF.FTXthQtyAndTypeUnit,
                                    DOCHDREF.FNXthShipAdd,
                                    DOCHDREF.FTViaCode,
                                    TVIA.FTViaName,
                                    TADD.FNAddSeqNo,
                                    TADD.FTAddV1No,
                                    TADD.FTAddV1Soi,
                                    TADD.FTAddV1Village,
                                    TADD.FTAddV1Road,
                                    TSUD.FTSudName,
                                    TDST.FTDstName,
                                    TPVC.FTPvnName,
                                    TADD.FTAddV1PostCode,
                                    TADD.FTAddV2Desc1,
                                    TADD.FTAddV2Desc2
                                FROM [TCNTPdtTwoHDRef] DOCHDREF
                                LEFT JOIN TCNMAddress_L     TADD ON DOCHDREF.FNXthShipAdd   = TADD.FNAddSeqNo   AND TADD.FNLngID    = $nLngID
                                LEFT JOIN TCNMSubDistrict_L TSUD ON TADD.FTAddV1SubDist     = TSUD.FTSudCode    AND TSUD.FNLngID    = $nLngID
                                LEFT JOIN TCNMDistrict_L    TDST ON TADD.FTAddV1DstCode     = TDST.FTDstCode    AND TDST.FNLngID    = $nLngID
                                LEFT JOIN TCNMProvince_L    TPVC ON TADD.FTAddV1PvnCode     = TPVC.FTPvnCode    AND TPVC.FNLngID    = $nLngID
                                LEFT JOIN TCNMShipVia_L     TVIA ON DOCHDREF.FTViaCode      = TVIA.FTViaCode    AND TVIA.FNLngID    = $nLngID
                                WHERE 1 = 1 AND DOCHDREF.FTXthDocNo = '$tTXODocNo' ";
            break;
            case 'BCH' :
                $tTXOSql    = "";
            break;
        }

        $oQuery = $this->db->query($tTXOSql);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'OK.',
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // Functionality : Insert Data DocDT To DocTemp
    // Parameters : function parameters
    // Creator : 23/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Data DocDT To DocTemp
    // Return Type : array
    public function FSaMTXOInsertDTToTemp($paDataDocDT,$paTableAddUpdate){
        if($paDataDocDT['rtCode'] == 1){
            $paDataDocDTItems = $paDataDocDT['raItems'];
            if(!empty($paDataDocDTItems[0]['FTXthDocNo'])){
                $this->db->where_in('FTXthDocNo', $paDataDocDTItems[0]['FTXthDocNo']);
                $this->db->where_in('FTSessionID', $this->session->userdata('tSesSessionID'));
                $this->db->delete('TCNTDocDTTmp');
            }
            foreach($paDataDocDTItems as $nKey  =>  $aValue){
                $this->db->insert('TCNTDocDTTmp',array(
                    'FTBchCode'         => $aValue['FTBchCode'],
                    'FTXthDocNo'        => $aValue['FTXthDocNo'],
                    'FNXtdSeqNo'        => $aValue['FNXtdSeqNo'],
                    'FTXthDocKey'       => $paTableAddUpdate['tTableHD'],
                    'FTPdtCode'         => $aValue['FTPdtCode'],
                    'FTXtdPdtName'      => $aValue['FTXtdPdtName'],
                    'FTXtdStkCode'      => $aValue['FTXtdStkCode'],
                    'FTPunCode'         => $aValue['FTPunCode'],
                    'FTPunName'         => $aValue['FTPunName'],
                    'FCXtdFactor'       => $aValue['FCXtdFactor'],
                    'FTXtdBarCode'      => $aValue['FTXtdBarCode'],
                    'FTXtdVatType'      => $aValue['FTXtdVatType'],
                    'FTVatCode'         => $aValue['FTVatCode'],
                    'FCXtdVatRate'      => $aValue['FCXtdVatRate'],
                    'FCXtdQty'          => $aValue['FCXtdQty'],
                    'FCXtdQtyAll'       => $aValue['FCXtdQtyAll'],
                    'FCXtdSetPrice'     => $aValue['FCXtdSetPrice'],
                    'FCXtdAmt'          => $aValue['FCXtdAmt'],
                    'FCXtdVat'          => $aValue['FCXtdVat'],
                    'FCXtdVatable'      => $aValue['FCXtdVatable'],
                    'FCXtdNet'          => $aValue['FCXtdNet'],
                    'FCXtdCostIn'       => $aValue['FCXtdCostIn'],
                    'FCXtdCostEx'       => $aValue['FCXtdCostEx'],
                    'FTXtdStaPrcStk'    => $aValue['FTXtdStaPrcStk'],
                    'FNXtdPdtLevel'     => $aValue['FNXtdPdtLevel'],
                    'FTXtdPdtParent'    => $aValue['FTXtdPdtParent'],
                    'FCXtdQtySet'       => $aValue['FCXtdQtySet'],
                    'FTXtdPdtStaSet'    => $aValue['FTXtdPdtStaSet'],
                    'FTXtdRmk'          => $aValue['FTXtdRmk'],
                    'FTSessionID'       => $this->session->userdata('tSesSessionID'),
                    'FDLastUpdOn'       => date('Y-m-d h:i:sa'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FDCreateOn'        => $aValue['FDCreateOn'],
                    'FTCreateBy'        => $aValue['FTCreateBy']
                ));
            }
        }
        return;
    }
    
    // Functionality : Clear Data In DocDT Temp
    // Parameters : function parameters
    // Creator : 27/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Data DocDT To DocTemp
    // Return Type : array
    public function FSaMTXOClearDataDocTemp($paDataWhere){
        $tTXODocNo      = $paDataWhere['FTXthDocNo'];
        $tTXODocKey     = $paDataWhere['FTXthDocKey'];
        $tTXOSessionID  = $paDataWhere['FTSessionID'];
        $tSQL   = " DELETE FROM TCNTDocDTTmp
                    WHERE 1=1
                    AND TCNTDocDTTmp.FTXthDocNo     = '$tTXODocNo'
                    AND TCNTDocDTTmp.FTXthDocKey    = '$tTXODocKey'
                    AND TCNTDocDTTmp.FTSessionID    = '$tTXOSessionID'
        ";
        $this->db->query($tSQL);
    }

    // Functionality : Clear Data In DocDT Temp
    // Parameters : function parameters
    // Creator : 27/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Insert Data DocDT To DocTemp
    // Return Type : array
    public function FSaMTXOCheckViaCodeForApv($paDataWhere){
        $tTXOTblHDRef   = $paDataWhere['tTXOTblHDRef'];
        $tTXODocNo      = $paDataWhere['tTXODocNo'];
        $tSQL = "SELECT FTViaCode FROM ".$tTXOTblHDRef." WHERE FTXthDocNo = '".$tTXODocNo."'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult    = array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'OK.',
            );
        }else{
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found.',
            );
        }
        return $aResult;
    }

    // Functionality : Update Sta Appove Document
    // Parameters : function parameters
    // Creator : 29/05/2019 Wasin(Yoshi)
    // Last Modified : -
    // Return : Array Status Update Status Document Appove
    // Return Type : array
    public function FSaMTXOApproveDocument($paDataUpdate,$paDataTableAppove){
        // Update Status Document
        $this->db->where($paDataUpdate['aDataWhereDoc']);
        $this->db->update($paDataTableAppove['tTableHD'],$paDataUpdate['aDataUpdStaDoc']);
        return;
    }








}