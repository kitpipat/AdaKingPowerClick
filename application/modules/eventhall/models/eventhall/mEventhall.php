<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mEventhall extends CI_Model {

    // Functionality: ดึงข้อมูลสถานที่
    // Parameters: array
    // Creator: 05/06/2019 saharat(Golf)
    // Return: ข้อมูลสถานที่แบบ Array
	// ReturnType: Object Array
    public function FSaMEVNTHListDataTable($paData){

        $aRowLen    = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSearch    = $paData['tSearchAll'];
        $tSQL       = " SELECT c.* FROM   ( 
                                    SELECT  ROW_NUMBER() OVER(ORDER BY FTLocCode ASC) AS FNRowID,* FROM
                            ( SELECT DISTINCT 

                                LCTL.FTHalName,
                                LCT.FTLocCode,
                                LCT.FTBchCode,
                                LCT.FNLocLimit,
                                LCT.FTLocTimeOpening,
                                LCT.FTLocTimeClosing,
                                LCT.FTLocStaActive

                            FROM TTKMLocation LCT
                            LEFT JOIN TTKMLocation_L LCTL ON LCTL.FTLocCode = LCT.FTLocCode AND FNLngID = $nLngID 
                            WHERE 1=1 ";

        $tSQL   .= " )  Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aList          = $oQuery->result_array();
            $aFoundRow      = $this->FSaMEVNTHPageAll($tSearch,$nLngID);
            $nFoundRow      = ($aFoundRow['rtCode'] == '1')? $aFoundRow['rtCountData'] : 0;
            // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $nPageAll       = ceil($nFoundRow/$paData['nRow']);
            $aDataReturn    = array(
                'raItems'       => $aList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            $aDataReturn    = array(
				'rnAllRow'      => 0,
				'rnCurrentPage' => $paData['nPage'],
				"rnAllPage"     => 0,
				'rtCode'        => '800',
				'rtDesc'        => 'data not found',
			);
        }
        
        return $aDataReturn;

    }

    // Functionality : All Page Of Product
    // Parameters : function parameters
    // Creator :  31/01/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : data
    // Return Type : Array
    public function FSaMEVNTHPageAll($ptSearch,$ptLngID){
        $tSQL   = "	SELECT TOP 1
                        ROW_NUMBER() OVER(ORDER BY LCTL.FTLocCode ASC)   AS counts
                    FROM TTKMLocation_L LCTL WITH (NOLOCK)
                    WHERE 1=1   ";

        // SEARCH PRODUCT
        if(isset($ptSearch) && !empty($ptSearch)){
            $tSQL   .= "  AND ( LCT.FTBchCode LIKE '$ptSearch' OR LCTL.FTHalName LIKE '%$ptSearch%' )";
        }
        
        $tSQL   .= " GROUP BY LCTL.FTLocCode ORDER BY LCTL.FTLocCode DESC "; 
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            $aDetail = $oQuery->row_array();
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
        return $aDataReturn;
    }

    // Functionality : Select Data Event Not Sale
    // Parameters : function parameters
    // Creator : 07/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Query For Database
	// Return Type : Array
    public function FSaMPDTEvnNotSaleByID($paData){
        $tEvnCode   = $paData['FTEvnCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT
                            PNSE.FTEvnCode,
                            PNSE.FNEvnSeqNo,
                            PNSE.FTEvnType,
                            PNSE.FTEvnStaAllDay,
                            PNSE.FDEvnDStart,
                            PNSE.FTEvnTStart,
                            PNSE.FDEvnDFinish,
                            PNSE.FTEvnTFinish,
                            PNSE_L.FTEvnName
                        FROM [TCNMPdtNoSleByEvn]  PNSE WITH (NOLOCK)
                        LEFT JOIN TCNMPdtNoSleByEvn_L PNSE_L WITH (NOLOCK) ON PNSE.FTEvnCode = PNSE_L.FTEvnCode AND PNSE_L.FNLngID = $nLngID
                        WHERE PNSE.FTEvnCode = '$tEvnCode'
                        ORDER BY PNSE.FNEvnSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail = $oQuery->result_array();
            $aResult = array(
                'raItems'	=> $aDetail,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality : Select Data Product Set
    // Parameters : function parameters
    // Creator : 07/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Query For Database
	// Return Type : Array
    public function FSaMPDTGetDataPdtSet($paData){
        $tPdtCode   = $paData['FTPdtCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT TOP 1
                            PDT.FTPdtCode   AS rtPdtCode,
	                        PDT_L.FTPdtName AS rtPdtName,
                            PUN_L.FTPunCode AS rtPunCode,
	                        PUN_L.FTPunName AS rtPunName,
	                        ISNULL(PRI4PDT.FCPgdPriceRet,0) AS rcPgdPriceRet,
	                        ISNULL(PRI4PDT.FCPgdPriceWhs,0)	AS rcPgdPriceWhs,
	                        ISNULL(PRI4PDT.FCPgdPriceNet,0)	AS rcPgdPriceNet
                        FROM TCNMPdt PDT WITH (NOLOCK)
                        LEFT JOIN TCNMPdt_L PDT_L           WITH (NOLOCK) ON PDT.FTPdtCode    = PDT_L.FTPdtCode   AND PDT_L.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtPackSize PPSZ      WITH (NOLOCK) ON PDT.FTPdtCode    = PPSZ.FTPdtCode
                        LEFT JOIN TCNMPdtUnit_L PUN_L       WITH (NOLOCK) ON PPSZ.FTPunCode   = PUN_L.FTPunCode   AND PUN_L.FNLngID = $nLngID
                        LEFT JOIN TCNTPdtPrice4PDT PRI4PDT  WITH (NOLOCK) ON PDT.FTPdtCode	= PRI4PDT.FTPdtCode	AND PPSZ.FTPunCode = PRI4PDT.FTPunCode
                        AND ((CONVERT(VARCHAR(19),GETDATE(),103) >= CONVERT(VARCHAR(19),PRI4PDT.FDPghDStart,103)) AND (CONVERT(VARCHAR(19),GETDATE(),103) <= CONVERT(VARCHAR(19),PRI4PDT.FDPghDStop,103)))
                        AND PRI4PDT.FTPghDocType = 1 
                        WHERE 1=1 AND PDT.FTPdtCode = '$tPdtCode'
                        ORDER BY 
                            CONVERT(VARCHAR(19),PRI4PDT.FDPghDStart,103) DESC ,
                            PPSZ.FCPdtUnitFact ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail = $oQuery->row_array();
            $aResult = array(
                'raItems'	=> $aDetail,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality : Select Data Product Unit
    // Parameters : function parameters
    // Creator : 08/02/2019 wasin(Yoshi)
    // Last Modified : -
    // Return : Array Data Query For Database
	// Return Type : Array
    public function FSaMPDTGetDataPdtUnit($paData){
        $FTPunCode  = $paData['FTPunCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = " SELECT
                            PUN.FTPunCode,
                            PUN_L.FTPunName
                        FROM TCNMPdtUnit PUN WITH (NOLOCK)
                        LEFT JOIN TCNMPdtUnit_L PUN_L WITH (NOLOCK) ON  PUN.FTPunCode = PUN_L.FTPunCode AND PUN_L.FNLngID = $nLngID
                        WHERE 1=1 AND PUN.FTPunCode = '$FTPunCode' ";
        $oQuery     = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDetail    = $oQuery->row_array();
            $aResult = array(
                'raItems'	=> $aDetail,
                'rtCode'	=> '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult = array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }


    // Functionality: Chack Barcode Duplicate in DB
    // Parameters: Data BarCode
    // Creator: 12/02/2018 wasin
    // Return: 
	// ReturnType:  Array
    public function FSaMStaChkBarcode($ptPdtCode,$ptBarCode){
        $tSQL   = " SELECT 
                        COUNT(PBAR.FTBarCode) AS Counts
                    FROM TCNMPdtBar PBAR WITH (NOLOCK)
                    WHERE 1=1 AND PBAR.FTPdtCode = '$ptPdtCode' AND PBAR.FTBarCode = '$ptBarCode' ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aDetail    = $oQuery->row_array();
            $aResult    =  array(
                'raItems'   => $aDetail,
                'rtCode'    => '1',
                'rtDesc'	=> 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality : Check Product Duplicate In DB
    // Parameters : function parameters
    // Creator : 18/02/2019 Wasin(Yoshi)
    // Return : Data Check Product Duplicate
    // Return Type : Array
    public function FSaMPDTCheckDuplicate($ptPdtCode){
        $tSQL   =   "SELECT COUNT(PDT.FTPdtCode) AS counts
					 FROM TCNMPdt PDT WITH (NOLOCK)
                     WHERE PDT.FTPdtCode = '$ptPdtCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            $aResult    =  array(
                'rnCountPdt'    => $aDataQuery['counts'],
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality : Function Add Product 
    // Parameters : function parameters
    // Creator : 18/02/2019 Wasin(Yoshi)
    // Return : Array Status Add Product (TCNMPdt)
	// Return Type : array
    public function FSaMPDTAddUpdateMaster($paPdtWhere,$paPdtData){
        // Update TCNMPdt
        $aDataUpdate    = array_merge($paPdtData,array(
            'FDLastUpdOn'   => date('Y-m-d h:i:s'),
            'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
        ));
        $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
        $this->db->update('TCNMPdt',$aDataUpdate);
        if($this->db->affected_rows() > 0){
            $aStatus    = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Product Success',
            );
        }else{
            // Add TCNMPdt
            $aDataInsert = array_merge($paPdtWhere,$paPdtData,array(
                'FDCreateOn'    => date('Y-m-d h:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername')
            ));
            $this->db->insert('TCNMPdt',$aDataInsert);
            if($this->db->affected_rows() > 0){
                $aStatus    = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product Success',
                );
            }else{
                $aStatus    = array(
                    'rtCode' => '801',
                    'rtDesc' => 'Error Cannot Add/Update Product.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality : Function Add Product Lang
    // Parameters : function parameters
    // Creator : 18/02/2019 Wasin(Yoshi)
    // Return : Array Status Add Product (TCNMPdt_L)
	// Return Type : array
    public function FSaMPDTAddUpdateLang($paPdtWhere,$paPdtDataLang){
        // Update TCNMPdt_L
        $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
        $this->db->update('TCNMPdt_L',$paPdtDataLang);
        if($this->db->affected_rows() > 0){
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'Update Product Lang Success.',
            );
        }else{
            // Add TCNMPdt_L
            $aDataInsertLang    = array_merge($paPdtWhere,$paPdtDataLang);
            $this->db->insert('TCNMPdt_L',$aDataInsertLang);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product Lang Success',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '801',
                    'rtDesc' => 'Error Cannot Add/Update Product Lang.',
                );
            }
        }
        return $aStatus;
    }

    // Functionality: Functio Add/Update PackSize
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Status Add Update PackSize
    // ReturnType: Array
    public function FSxMPDTAddUpdatePackSize($paPdtWhere,$paDataPackSize){
        // Delete Pack Size
        $this->db->where_in('FTPdtCode', $paPdtWhere['FTPdtCode']);
        $this->db->delete('TCNMPdtPackSize');
        if(is_array($paDataPackSize) && !empty($paDataPackSize)){
            foreach($paDataPackSize AS $nKey => $aValue){
                $aDataPsz   = array(
                    'FTPdtCode'         => $paPdtWhere['FTPdtCode'],
                    'FTPunCode'         => $aValue['tPdtPunCode'],
                    'FCPdtUnitFact'     => (isset($aValue['tPdtUnitFact']) && !empty($aValue['tPdtUnitFact']))? $aValue['tPdtUnitFact'] : 1,
                    'FTPdtGrade'        => $aValue['tPdtGrade'],
                    'FCPdtWeight'       => (isset($aValue['tPdtWeight']) && !empty($aValue['tPdtWeight']))? $aValue['tPdtWeight'] : 0,
                    'FTClrCode'         => $aValue['tPdtClrCode'],
                    'FTPszCode'         => $aValue['tPdtSizeCode'],
                    'FTPdtUnitDim'      => $aValue['tPdtUnitDim'],
                    'FTPdtPkgDim'       => $aValue['tPdtPkgDim'],
                    'FTPdtStaAlwPick'   => $aValue['tPdtStaAlwPick'],
                    'FTPdtStaAlwPoHQ'   => $aValue['tPdtStaAlwPoHQ'],
                    'FTPdtStaAlwBuy'    => $aValue['tPdtStaAlwBuy'],
                    'FTPdtStaAlwSale'   => $aValue['tPdtStaAlwSale'],
                    'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                    'FDCreateOn'        => date('Y-m-d h:i:s'),
                    'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'        => $this->session->userdata('tSesUsername')
                );
                $this->db->insert('TCNMPdtPackSize',$aDataPsz);
            }
        }
        return;
    }

    // Functionality: Get Last Seq PlcCode In BarCode
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Array Last Seq
	// ReturnType: Array
    public function FSaMPDTGetPlcSeq($ptPdtCode,$ptPlcCode){
        $tSQL   = " SELECT TOP 1 PBAR.FNPldSeq 
                    FROM TCNMPdtBar PBAR
                    WHERE PBAR.FTPdtCode = '$ptPdtCode' AND PBAR.FTPlcCode = '$ptPlcCode'
                    ORDER BY PBAR.FNPldSeq DESC ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->row_array();
    }

    // Functionality: Functio Add/Update BarCode
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Status Add Update BarCode
	// ReturnType: Array
    public function FSxMPDTAddUpdateBarCode($paPdtWhere,$paDataPackSize){
        // Delete BarCode All
        $this->db->where_in('FTPdtCode', $paPdtWhere['FTPdtCode']);
        $this->db->delete('TCNMPdtBar');
        if(is_array($paDataPackSize) && !empty($paDataPackSize)){
            // Loop Data Pack Size
            foreach($paDataPackSize AS $nKey => $aPackSize){
                $tPdtPunCode   = $aPackSize['tPdtPunCode'];
                // Loop Data BarCode Where In PackSize
                if(isset($aPackSize['oDataBarCode']) && !empty($aPackSize['oDataBarCode'])){
                    foreach($aPackSize['oDataBarCode'] AS $nKey => $aBarCode){
                        if(isset($aBarCode['tPdtPlcCode']) && !empty($aBarCode['tPdtPlcCode'])){
                            $tPlcCode       = $aBarCode['tPdtPlcCode'];
                            $aPlcLastSeq    = $this->FSaMPDTGetPlcSeq($paPdtWhere['FTPdtCode'],$tPlcCode);
                            $nPlcLastSeq    = (!empty($aPlcLastSeq['FNPldSeq']))? $aPlcLastSeq['FNPldSeq'] : 0 ;
                        }else{
                            $tPlcCode      = null;
                            $nPlcLastSeq	= null;
                        }

                        $aDataBarCode   = array(
                            'FTPdtCode'         => $paPdtWhere['FTPdtCode'],
                            'FTBarCode'         => $aBarCode['tPdtBarCode'],
                            'FTPunCode'         => $tPdtPunCode,
                            'FTBarStaUse'       => $aBarCode['tPdtBarStaUse'],
                            'FTBarStaAlwSale'   => $aBarCode['tPdtBarStaAlwSale'],
                            'FTPlcCode'         => $tPlcCode,
                            'FNPldSeq'          => $nPlcLastSeq + 1,
                            'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                            'FDCreateOn'        => date('Y-m-d h:i:s'),
                            'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                            'FTCreateBy'        => $this->session->userdata('tSesUsername')
                        );
                        $this->db->insert('TCNMPdtBar',$aDataBarCode);
                    }
                }
            }
        }
        return;
    }

    // Functionality: Functio Add/Update Supplier
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Status Add Update Supplier
	// ReturnType: Array
    public function FSxMPDTAddUpdateSupplier($paPdtWhere,$paDataPackSize){
        // Delete Supplier All
        $this->db->where_in('FTPdtCode',$paPdtWhere['FTPdtCode']);
        $this->db->delete('TCNMPdtSpl');
        if(is_array($paDataPackSize) && !empty($paDataPackSize)){
            // Loop Data Pack Size
            foreach($paDataPackSize AS $nKey => $aPackSize){
               if(isset($aPackSize['oDataSupplier']) && !empty($aPackSize['oDataSupplier'])){
                    foreach($aPackSize['oDataSupplier'] AS $nKey => $aSupplier){
                        $aDataSupllier  = array(
                            'FTPdtCode'     => $paPdtWhere['FTPdtCode'],
                            'FTBarCode'     => $aSupplier['tPdtBarCode'],
                            'FTSplCode'     => $aSupplier['tPdtSplCode'],
                            'FTSplStaAlwPO' => $aSupplier['tPdtStaAlwPO'],
                        );
                        $this->db->insert('TCNMPdtSpl',$aDataSupllier);
                    }
               }
            }
        }
        return;
    }

    // Functionality: Functio Add/Update Product Set
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Status Add Update Supplier
	// ReturnType: Array
    public function FSxMPDTAddUpdatePdtSet($paPdtWhere,$paPdtDataAllSet){
        // Delete Product Set All
        $this->db->where_in('FTPdtCode',$paPdtWhere['FTPdtCode']);
        $this->db->delete('TCNTPdtSet');

        if(is_array($paPdtDataAllSet) && !empty($paPdtDataAllSet)){
            // Loop Data Pack Size
            foreach($paPdtDataAllSet['oPdtCodeSetData'] AS $nKey => $aDataPdtSet){
                $aDataPdtSet    = array(
                    'FTPdtCode'     => $paPdtWhere['FTPdtCode'],
                    'FTPdtCodeSet'  => $aDataPdtSet['tPdtCodeSetCode'],
                    'FCPstQty'      => $aDataPdtSet['tPdtCodeSetQty'],
                    'FDLastUpdOn'   => date('Y-m-d h:i:s'),
                    'FDCreateOn'    => date('Y-m-d h:i:s'),
                    'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                    'FTCreateBy'    => $this->session->userdata('tSesUsername')
                );
                $this->db->insert('TCNTPdtSet',$aDataPdtSet); 
            }
            $aDataStaUpdPdtSet = array(
                'FTPdtSetOrSN'      => 2,
                'FTPdtStaSetPri'    => $paPdtDataAllSet['tPdtStaSetPri'],
                'FTPdtStaSetShwDT'  => $paPdtDataAllSet['tPdtStaSetShwDT'],
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
            );
            $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
            $this->db->update('TCNMPdt',$aDataStaUpdPdtSet);
        }else{
            $aDataStaUpdPdtSet = array(
                'FTPdtSetOrSN'      => 1,
                'FTPdtStaSetPri'    => NULL,
                'FTPdtStaSetShwDT'  => NULL,
                'FDLastUpdOn'       => date('Y-m-d h:i:s'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername')
            );
            $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
            $this->db->update('TCNMPdt',$aDataStaUpdPdtSet);
        }
        return;
    }

    // Functionality: Functio Add/Update Product Event Not Sale
    // Parameters: function parameters
    // Creator:  18/02/2019 Wasin(Yoshi)
    // Return: Status Add Update Supplier
	// ReturnType: Array
    public function FSxMPDTAddUpdatePdtEvnNosale($paPdtWhere,$ptPdtEvnNotSale){
        if(isset($ptPdtEvnNotSale) && !empty($ptPdtEvnNotSale)){
            $aPdtEvnNoSale  =   array(
                'FTEvnCode'     => $ptPdtEvnNotSale,
                'FDLastUpdOn'   => date('Y-m-d h:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );
            $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
			$this->db->update('TCNMPdt',$aPdtEvnNoSale);
        }else{
            $aPdtEvnNoSale  =   array(
                'FTEvnCode'     => NULL,
                'FDLastUpdOn'   => date('Y-m-d h:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );
            $this->db->where('FTPdtCode',$paPdtWhere['FTPdtCode']);
			$this->db->update('TCNMPdt',$aPdtEvnNoSale);
        }
        return;
    }


    //  ============================ Edit Modal ============================================================

    // Functionality: Func. Get Data Image By ID Product
    // Parameters: function parameters
    // Creator:  20/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataImgByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $tSQL       = " SELECT 
                            IMGPDT.FNImgID,
                            IMGPDT.FTImgRefID,
                            IMGPDT.FNImgSeq,
                            IMGPDT.FTImgObj
                        FROM TCNMImgPdt IMGPDT
                        WHERE 1=1 
                        AND IMGPDT.FTImgRefID   = '$tPdtCode'
                        AND IMGPDT.FTImgTable   = 'TCNMPdt'
                        AND IMGPDT.FTImgKey     = 'master'
                        ORDER BY IMGPDT.FNImgSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data Info By ID Product
    // Parameters: function parameters
    // Creator:  20/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataInfoByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        // PDT.FTBchCode,BCHL.FTBchName,
        // ,PDT.FTShpCode
        // PDT.FTPdtRefShop,MERL.FTMerName, 
        // LEFT JOIN TCNMBranch_L BCHL         ON PDT.FTBchCode    = BCHL.FTBchCode    AND BCHL.FNLngID = $nLngID //
        // LEFT JOIN TCNMMerchant_L MERL       ON PDT.FTPdtRefShop = MERL.FTMerCode    AND MERL.FNLngID = $nLngID //
        $tSQL       = " SELECT
                            PDT.FTPdtCode,PDTL.FTPdtName,PDTL.FTPdtNameOth,PDTL.FTPdtNameABB,PDT.FTPdtStkCode,PDT.FTPdtStkControl,PDT.FTPdtGrpControl,PDT.FTPdtForSystem,
                            PDT.FCPdtQtyOrdBuy,PDT.FCPdtCostDef,PDT.FCPdtCostOth,PDT.FCPdtCostStd,PDT.FCPdtMin,PDT.FCPdtMax,PDT.FTPdtPoint,PDT.FCPdtPointTime,PDT.FTPdtType,
                            PDT.FTPdtSaleType,PDT.FTPdtSetOrSN,PDT.FTPdtStaAlwDis,PDT.FTPdtStaAlwReturn,PDT.FTPdtStaVatBuy,PDT.FTPdtStaVat,PDT.FTPdtStaActive,PDT.FTPdtStaAlwReCalOpt,
                            PDT.FTPdtStaCsm,PDT.FTTcgCode,TCGL.FTTcgName,PDT.FTPgpChain,PGPL.FTPgpChainName,
                            PDT.FTPtyCode,PTYL.FTPtyName,PDT.FTPbnCode,PBNL.FTPbnName,PDT.FTPmoCode,PMOL.FTPmoName,PDT.FTVatCode,
                            CONVERT(CHAR(10),PDT.FDPdtSaleStart,126)    AS FDPdtSaleStart,
                            CONVERT(CHAR(10),PDT.FDPdtSaleStop,126)     AS FDPdtSaleStop,
                            PDTL.FTPdtRmk 
                        FROM TCNMPdt PDT
                        LEFT JOIN TCNMPdt_L PDTL            ON PDT.FTPdtCode    = PDTL.FTPdtCode    AND PDTL.FNLngID = $nLngID

                        LEFT JOIN TCNMPdtTouchGrp_L TCGL    ON PDT.FTTcgCode    = TCGL.FTTcgCode    AND TCGL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtGrp_L PGPL         ON PDT.FTPgpChain   = PGPL.FTPgpChain   AND PGPL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtType_L PTYL        ON PDT.FTPtyCode    = PTYL.FTPtyCode    AND PTYL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtBrand_L PBNL       ON PDT.FTPbnCode    = PBNL.FTPbnCode    AND PBNL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtModel_L PMOL       ON PDT.FTPmoCode    = PMOL.FTPmoCode    AND PMOL.FNLngID = $nLngID
                        WHERE 1=1 AND PDT.FTPdtCode = '$tPdtCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->row_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data PackSize By ID Product
    // Parameters: function parameters
    // Creator:  21/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataPackSizeByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT DISTINCT
                            PPSZ.FTPdtCode,PPSZ.FTPunCode,PUNL.FTPunName,PPSZ.FCPdtUnitFact,PPSZ.FTPdtGrade,PPSZ.FCPdtWeight,PPSZ.FTClrCode,
                            PCLL.FTClrName,PPSZ.FTPszCode,PSZL.FTPszName,PPSZ.FTPdtUnitDim,PPSZ.FTPdtPkgDim,PPSZ.FTPdtStaAlwPick,
                            PPSZ.FTPdtStaAlwPoHQ,PPSZ.FTPdtStaAlwBuy,PPSZ.FTPdtStaAlwSale,
                            ISNULL(P4PDT.FCPgdPriceRet,0) AS FCPgdPriceRet,
                            ISNULL(P4PDT.FCPgdPriceWhs,0) AS FCPgdPriceWhs,
                            ISNULL(P4PDT.FCPgdPriceNet,0) AS FCPgdPriceNet
                        FROM TCNMPdtPackSize PPSZ
                        LEFT JOIN TCNMPdtUnit_L	PUNL        ON PPSZ.FTPunCode = PUNL.FTPunCode  AND PUNL.FNLngID	= $nLngID
                        LEFT JOIN TCNMPdtColor_L PCLL       ON PPSZ.FTClrCode = PCLL.FTClrCode  AND PCLL.FNLngID = $nLngID
                        LEFT JOIN TCNMPdtSize_L PSZL        ON PPSZ.FTPszCode = PSZL.FTPszCode  AND PSZL.FNLngID = $nLngID
                        LEFT JOIN TCNTPdtPrice4PDT P4PDT	ON PPSZ.FTPdtCode = P4PDT.FTPdtCode AND PPSZ.FTPunCode = P4PDT.FTPunCode 
                        AND ((CONVERT(VARCHAR(19),GETDATE(),103) >= CONVERT(VARCHAR(19),P4PDT.FDPghDStart,103)) AND (CONVERT(VARCHAR(19),GETDATE(),103) <= CONVERT(VARCHAR(19),P4PDT.FDPghDStop,103)))
                        AND P4PDT.FTPghDocType = 1
                        WHERE 1=1 
                        AND PPSZ.FTPdtCode = '$tPdtCode'
                        ORDER BY PPSZ.FTPunCode ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data BarCode By ID Product
    // Parameters: function parameters
    // Creator:  21/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataBarCodeByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT DISTINCT
                            PBAR.FTPdtCode,
                            PBAR.FTBarCode,
                            PBAR.FTPunCode,
                            PBAR.FNPldSeq,
                            PBAR.FTPlcCode,
                            PLCL.FTPlcName,
                            PBAR.FTBarStaUse,
                            PBAR.FTBarStaAlwSale
                        FROM TCNMPdtPackSize PPSZ
                        LEFT JOIN TCNMPdtBar PBAR 	ON PPSZ.FTPdtCode = PBAR.FTPdtCode AND PPSZ.FTPunCode = PBAR.FTPunCode
                        LEFT JOIN TCNMPdtLoc_L PLCL	ON PBAR.FTPlcCode = PLCL.FTPlcCode AND PLCL.FNLngID = $nLngID
                        WHERE 1=1 AND PPSZ.FTPdtCode = '$tPdtCode'
                        ORDER BY PBAR.FTPunCode ASC,PBAR.FNPldSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data Supplier By ID Product
    // Parameters: function parameters
    // Creator:  21/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataSupplierByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT
                            PPSZ.FTPdtCode,
                            PPSZ.FTPunCode,
                            PBAR.FTBarCode,
                            PSPL.FTSplCode,
                            SPLL.FTSplName,
                            PSPL.FTSplStaAlwPO
                        FROM TCNMPdtPackSize PPSZ
                        LEFT JOIN TCNMPdtBar PBAR ON PPSZ.FTPdtCode = PBAR.FTPdtCode AND PPSZ.FTPunCode = PBAR.FTPunCode
                        LEFT JOIN TCNMPdtSpl PSPL	ON PPSZ.FTPdtCode = PSPL.FTPdtCode AND PBAR.FTBarCode = PSPL.FTBarCode
                        LEFT JOIN TCNMSpl_L  SPLL	ON PSPL.FTSplCode	= SPLL.FTSplCode AND SPLL.FNLngID = $nLngID
                        WHERE 1=1 AND PPSZ.FTPdtCode = '$tPdtCode'
                        ORDER BY PPSZ.FTPunCode ASC , PBAR.FNPldSeq ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data Product Set By ID Product
    // Parameters: Array ข้อมูลสินค้าเซ็ท
    // Creator:  22/02/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataPdtSetByID($paDataWhere){
        $tPdtCode       = $paDataWhere['FTPdtCode'];
        $nLngID         = $paDataWhere['FNLngID'];
        $tSQLPdtSetHD   = " SELECT PDT.FTPdtStaSetPri,PDT.FTPdtStaSetShwDT FROM TCNMPdt PDT WHERE PDT.FTPdtCode = '$tPdtCode' ";
        $tSQLPdtSetDT   = "	SELECT
                                PSHD.*,ISNULL(PRI4PDT.FCPgdPriceRet,0) AS FCPgdPriceRet,
                                ISNULL(PRI4PDT.FCPgdPriceWhs,0) AS FCPgdPriceWhs,
                                ISNULL(PRI4PDT.FCPgdPriceNet,0) AS FCPgdPriceNet
                            FROM (
                                SELECT PSET.FTPdtCode,PSDT.FTPdtCodeSet,PDTL.FTPdtName AS FTPdtNameSet,PSET.FCPstQty,PSDT.FTPunCode,PUNL.FTPunName,PSDT.FCPdtUnitFact,PSDT.FNPszRank
                                FROM(
                                    SELECT PPS.*
                                    FROM (
                                        SELECT
                                            FTPdtCode AS FTPdtCodeSet,
                                            FTPunCode,
                                            FCPdtUnitFact,
                                            DENSE_RANK() OVER (PARTITION BY FTPdtCode ORDER BY FCPdtUnitFact ASC) AS FNPszRank
                                        FROM TCNMPdtPackSize ) PPS
                                    WHERE PPS.FTPdtCodeSet IN( SELECT FTPdtCodeSet FROM TCNTPdtSet WHERE FTPdtcode = '$tPdtCode') AND  PPS.FNPszRank = 1
                                ) PSDT
                                LEFT JOIN TCNTPdtSet    PSET ON PSDT.FTPdtCodeSet   = PSET.FTPdtCodeSet
                                LEFT JOIN TCNMPdt_L     PDTL ON PSDT.FTPdtCodeSet   = PDTL.FTPdtCode AND PDTL.FNLngID   = $nLngID
                                LEFT JOIN TCNMPdtUnit_L	PUNL ON PSDT.FTPunCode      = PUNL.FTPunCode AND PUNL.FNLngID   = $nLngID
                            ) PSHD
                            LEFT JOIN (
                                SELECT PRIPACK.*
                                FROM (
                                    SELECT
                                        DENSE_RANK() OVER (PARTITION BY P4PDT.FTPdtcode,P4PDT.FTPunCode ORDER BY P4PDT.FDPghDStart DESC) AS FNPszRank,
                                        P4PDT.FTPdtCode,
                                        P4PDT.FTPunCode,
                                        P4PDT.FCPgdPriceNet,
                                        P4PDT.FCPgdPriceRet,
                                        P4PDT.FCPgdPriceWhs
                                    FROM TCNTPdtPrice4PDT P4PDT
                                    WHERE P4PDT.FTPdtCode IN (SELECT FTPdtCodeSet FROM TCNTPdtSet WHERE FTPdtcode = '$tPdtCode')
                                    AND ((CONVERT(VARCHAR(10),GETDATE(),121) >= CONVERT(VARCHAR(10),P4PDT.FDPghDStart,121)) AND (CONVERT(VARCHAR(10),GETDATE(),121) <= CONVERT(VARCHAR(10),P4PDT.FDPghDStop,121)))
                                    AND P4PDT.FTPghDocType = 1
                                ) PRIPACK
                                WHERE PRIPACK.FNPszRank = 1
                            ) PRI4PDT ON PSHD.FTPdtCodeSet = PRI4PDT.FTPdtCode AND PSHD.FTPunCode = PRI4PDT.FTPunCode ";

        $oQueryPdtHD = $this->db->query($tSQLPdtSetHD);
        $oQueryPdtDT = $this->db->query($tSQLPdtSetDT);

        if($oQueryPdtHD->num_rows() > 0 && $oQueryPdtDT->num_rows() > 0){
            $aDataPdtHD     = $oQueryPdtHD->result_array();
            $aDataPdtDT     = $oQueryPdtDT->result_array();
            $aResult    =  array(
                'raDataPdtHD'   => $aDataPdtHD,
                'raDataPdtDT'   => $aDataPdtDT,
                'rtCode'        => '1',
                'rtDesc'        => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality: Func. Get Data Product Set By ID Product
    // Parameters: function parameters
    // Creator:  22/02/2019 Wasin(Yoshi)
    // Return: Array Data Image
    // ReturnType: Array
    public function FSaMPDTGetDataEvnNoSaleByID($paDataWhere){
        $tPdtCode   = $paDataWhere['FTPdtCode'];
        $nLngID     = $paDataWhere['FNLngID'];
        $tSQL       = " SELECT
                            PNSE.FTEvnCode,
                            PNSE.FNEvnSeqNo,
                            PNSE.FTEvnType,
                            PNSE.FTEvnStaAllDay,
                            PNSE.FDEvnDStart,
                            PNSE.FTEvnTStart,
                            PNSE.FDEvnDFinish,
                            PNSE.FTEvnTFinish,
                            PNSE_L.FTEvnName
                        FROM TCNMPdt PDT
                        INNER JOIN TCNMPdtNoSleByEvn     PNSE    ON PDT.FTEvnCode    = PNSE.FTEvnCode
                        INNER JOIN TCNMPdtNoSleByEvn_L   PNSE_L	ON PNSE.FTEvnCode   = PNSE_L.FTEvnCode  AND PNSE_L.FNLngID = $nLngID
                        WHERE PDT.FTPdtCode = '$tPdtCode'
                        ORDER BY PNSE.FNEvnSeqNo ASC ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $aDataQuery = $oQuery->result_array();
            $aResult    =  array(
                'raItems'   => $aDataQuery,
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            );
        }else{
            $aResult =  array(
                'rtCode'	=> '800',
                'rtDesc'	=> 'data not found'
            );
        }
        return $aResult;
    }

    // Functionality : Delete Product
    // Parameters : function parameters
    // Creator :  30/08/2018 wasin
    // Return : Status Delete Product
	// Return Type : Array
    public function FSaMPdtDeleteAll($paDataDel){
        try{
            $this->db->trans_begin();

            // Delete Table PDT
			$this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
			$this->db->delete('TCNMPdt');

            // Delete Table PDT_L
			$this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
			$this->db->delete('TCNMPdt_L');

            // Delete Table PackSize
			$this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
			$this->db->delete('TCNMPdtPackSize');

            // Delete Table BarCode
			$this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
			$this->db->delete('TCNMPdtBar');

            // Delete Table Set
			$this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
            $this->db->delete('TCNTPdtSet');
            
            // Delete Table Product Supplier
            $this->db->where_in('FTPdtCode',$paDataDel['FTPdtCode']);
            $this->db->delete('TCNMPdtSpl');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
					'rtCode' => '500',
					'rtDesc' => 'Error Cannot Delete Product.',
				);
            }else{
                $this->db->trans_commit();
				$aStatus = array(
					'rtCode' => '1',
					'rtDesc' => 'Delete Product Success.',
				);
            }
        }catch(Exception $Error){
            $aStatus = array(
                'rtCode' => '500',
                'rtDesc' => $Error->getMessage()
            );
        }
        return $aStatus;
    }

  




    


}