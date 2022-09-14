<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mSetprinter extends CI_Model {


    /**
     * Functionality : Search Printer By ID
     * Parameters : $ptAPIReq, $ptMethodReq, $paData
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMSPRSearchByID($ptAPIReq, $ptMethodReq, $paData){
        $tDstCode   = $paData['FTPrnCode'];
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT
                            SPR.FTPrnCode,
                            SPR.FTPrnSrcType,
                            SPR.FTSppCode,
                            SPR.FTPrnDriver,
                            SPR.FTPrnType,
                            SPRL.FTPrnName,
                            SPRL.FTPrnRmk,
                            PRL.FTSppName,
                            PR.FTSppRef
                       FROM [TCNMPrinter] SPR
                       LEFT JOIN [TCNMPrinter_L] SPRL ON SPR.FTPrnCode = SPRL.FTPrnCode AND SPRL.FNLngID = $nLngID
                       LEFT JOIN [TSysPortPrn_L] PRL  ON SPR.FTSppCode = PRL.FTSppCode AND PRL.FNLngID = $nLngID
                       LEFT JOIN [TSysPortPrn]   PR   ON SPR.FTSppCode = PR.FTSppCode
                       WHERE 1=1 ";
        if($tDstCode!= ""){
            $tSQL .= "AND SPR.FTPrnCode = '$tDstCode'";
        }
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : List Print
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMSPRList($ptAPIReq, $ptMethodReq, $paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tSQL       = "SELECT c.* FROM(
                       SELECT  ROW_NUMBER() OVER(ORDER BY FTPrnCode ASC) AS rtRowID,*
                       FROM
                       (SELECT DISTINCT
                                SPR.FTPrnCode,
                                SPR.FTPrnSrcType,
                                SPR.FTSppCode,
                                SPR.FTPrnDriver,
                                SPR.FTPrnType,
                                SPRL.FTPrnName,
                                SPRL.FTPrnRmk
                            FROM [TCNMPrinter] SPR
                            LEFT JOIN [TCNMPrinter_L] SPRL ON SPR.FTPrnCode = SPRL.FTPrnCode AND SPRL.FNLngID = $nLngID
                            WHERE 1=1";
        
        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (SPRL.FTPrnName LIKE '%$tSearchList%' )";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMSPRGetPageAll($tSearchList, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oList,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $paData['nPage'],
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //No Data
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $paData['nPage'],
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }
    
    /**
     * Functionality : All Page Of Printer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMSPRGetPageAll($ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (SPR.FTPrnCode) AS counts
                 FROM [TCNMPrinter] SPR
                 LEFT JOIN [TCNMPrinter_L]  SPNL ON SPR.FTPrnCode = SPNL.FTPrnCode AND SPNL.FNLngID = $ptLngID
                 WHERE 1=1 ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (SPNL.FTPrnName LIKE '%$ptSearchList%' )";
        }
        
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->result();
        }else{
            //No Data
            return false;
        }
    }

    /**
     * Functionality : Checkduplicate
     * Parameters : $ptDstCode
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : data
     * Return Type : object is has result, boolean is no result
     */
    public function FSoMSPNCheckDuplicate($ptDstCode){
        $tSQL = "SELECT COUNT(FTPrnCode) AS counts
                 FROM TCNMPrinter
                 WHERE FTPrnCode = '$ptDstCode' ";
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            return $oQuery->result();
        }else{
            return false;
        }
    }

    /**
     * Functionality : Insert Update Printer
     * Parameters : $paData is data
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : response
     * Return Type : array
     */
    public function FSaMSPRAddUpdateMaster($paData){
      
        try{
            // Update Master
            $this->db->set('FTPrnSrcType', $paData['FTPrnSrcType']);
            $this->db->set('FTSppCode'   , $paData['FTSppCode']);
            $this->db->set('FTPrnDriver' , $paData['FTPrnDriver']);
            $this->db->set('FTPrnType'   , $paData['FTPrnType']);
            $this->db->set('FTLastUpdBy' , $paData['FTLastUpdBy']);
            $this->db->set('FDLastUpdOn' , $paData['FDLastUpdOn']);
            $this->db->where('FTPrnCode' , $paData['FTPrnCode']);
            $this->db->update('TCNMPrinter');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Master Success',
                );
            }else{
                // Add Master
                $this->db->insert('TCNMPrinter',array(
                    'FTPrnCode'     => $paData['FTPrnCode'],
                    'FTPrnSrcType'  => $paData['FTPrnSrcType'],
                    'FTSppCode'     => $paData['FTSppCode'],
                    'FTPrnDriver'   => $paData['FTPrnDriver'],
                    'FTPrnType'     => $paData['FTPrnType'],
                    'FTCreateBy'    => $paData['FTCreateBy'],
                    'FDCreateOn'    => $paData['FDCreateOn']
                ));
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
        }catch(Exception $Error){
            return $Error;
        }
    }
 
    /**
     * Functionality : Update Lang Printer
     * Parameters : $paData is data for update
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : Status response
     * Return Type : array
     */
    public function FSaMSPRAddUpdateLang($paData){
        try{
            // Update Lang
            $this->db->set('FTPrnName', $paData['FTPrnName']);
            $this->db->set('FTPrnRmk' , $paData['FTPrnRmk']);
            $this->db->where('FNLngID', $paData['FNLngID']);
            $this->db->where('FTPrnCode', $paData['FTPrnCode']);
            $this->db->update('TCNMPrinter_L');
            if($this->db->affected_rows() > 0 ){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Lang Success.',
                );
            }else{ // Add Lang
                $this->db->insert('TCNMPrinter_L',array(
                    'FTPrnCode' => $paData['FTPrnCode'],
                    'FNLngID'   => $paData['FNLngID'],
                    'FTPrnName' => $paData['FTPrnName'],
                    'FTPrnRmk'  => $paData['FTPrnRmk']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Lang Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Lang.',
                    );
                }
            }
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }

    /**
     * Functionality : Function Add Update Group
     * Parameters : $paData is data for update or add
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : Status Add Update Group
     * Return Type : array
     */
    public function FSaMSPNAddUpdateGroup($paData){
        try{
            // Update Group
            $this->db->set('FTBchCode',$paData['FTBchCode']);
            $this->db->set('FTSpnStaShop',$paData['FTSpnStaShop']);
            $this->db->set('FTShpCode',$paData['FTShpCode']);
            $this->db->set('FDSpnStart',$paData['FDSpnStart']);
            $this->db->set('FDSpnStop',$paData['FDSpnStop']);
            $this->db->where('FTSpnCode',$paData['FTSpnCode']);
            $this->db->update('TCNTSpnGroup');
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            }else{
                // Add Group
                $this->db->insert('TCNTSpnGroup',array(
                    'FTSpnCode'     => $paData['FTSpnCode'],
                    'FTBchCode'     => $paData['FTBchCode'],
                    'FTSpnStaShop'  => $paData['FTSpnStaShop'],
                    'FTShpCode'     => $paData['FTShpCode'],
                    'FDSpnStart'    => $paData['FDSpnStart'],
                    'FDSpnStop'     => $paData['FDSpnStop']
                ));
                if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                }else{
                    // Error 
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Group.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        }catch(Exception $Error){
            return $Error;
        }
    }
    
    /**
     * Functionality : Delete Printer
     * Parameters : $paData
     * Creator : 28/01/2018 supawat
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSnMSPRDel($paData){
        try{
            $this->db->trans_begin();
            $this->db->where_in('FTPrnCode', $paData['FTPrnCode']);
            $this->db->delete('TCNMPrinter');

            $this->db->where_in('FTPrnCode', $paData['FTPrnCode']);
            $this->db->delete('TCNMPrinter_L');

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aStatus = array(
                     'rtCode' => '905',
                     'rtDesc' => 'Delete Unsuccess.',
                );
            }else{
                $this->db->trans_commit();
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Delete Success.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

}
