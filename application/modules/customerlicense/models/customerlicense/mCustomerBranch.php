<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerBranch extends CI_Model {

       /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCLBList($paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tCstCode     = $paData['tCstCode'];

        $tWhereCode = '';
        if(!empty($tCstCode)){
            $tWhereCode .= " AND CLB.FTCstCode ='$tCstCode' ";
        }
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY rnCbrSeq ASC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CLB.FTCstCode AS rtCstCode,
                            CLB.FNCbrSeq AS rnCbrSeq,
                            CLB.FTCbrRefBch AS rtCbrRefBch,
                            CLB.FTCbrRefBchName AS rtCbrRefBchName,
                            CLB.FNCbrQtyPos AS rnCbrQtyPos,
                            CLB.FTSrvCode,
                            SRVL.FTSrvName AS rtSrvName,
                            CLB.FDCreateOn  
                        FROM [TRGMCstBch] CLB WITH (NOLOCK)
                        LEFT JOIN  TRGMPosSrv_L SRVL WITH (NOLOCK) ON CLB.FTSrvCode = SRVL.FTSrvCode AND  SRVL.FNLngID = $nLngID 
                        WHERE 1=1 $tWhereCode";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CLB.FTCstCode COLLATE THAI_BIN LIKE '%$tSearchList%'";  
            $tSQL .= " OR CLB.FTCbrRefBch COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CLB.FTSrvCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR SRVL.FTSrvName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CLB.FTCbrRefBchName COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCLBGetPageAll($tWhereCode, $tSearchList, $nLngID);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$paData['nRow']); // หา Page All จำนวน Rec หาร จำนวนต่อหน้า
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
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCLBGetPageAll($ptWhereCode, $ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (CLB.FTCstCode) AS counts
                FROM [TRGMCstBch] CLB
                LEFT JOIN  TRGMPosSrv_L SRVL WITH (NOLOCK) ON CLB.FTSrvCode = SRVL.FTSrvCode AND  SRVL.FNLngID = $ptLngID 
                WHERE 1=1 $ptWhereCode ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CLB.FTCstCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";  
            $tSQL .= " OR CLB.FTCbrRefBch COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CLB.FTSrvCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR SRVL.FTSrvName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CLB.FTCbrRefBchName COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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
     * Functionality : Search CstBch By ID
     * Parameters :  $paData
     * Creator : 14/01/2021
     * Last Modified : -
     * Return : Data
     * Return Type : array
     */
    public function FSaMCLBSearchByID($paData){
        $tCstCode   = $paData['FTCstCode'];
        $nCbrSeq   = $paData['FNCbrSeq'];
        $nLngID     = $paData['FNLngID'];

            $tSQL       = "SELECT 
                                    CLB.FTCstCode AS rtCstCode,
                                    CLB.FNCbrSeq AS rnCbrSeq,
                                    CLB.FTCbrRefBch AS rtCbrRefBch,
                                    CLB.FTCbrRefBchName AS rtCbrRefBchName,
                                    CLB.FNCbrQtyPos AS rnCbrQtyPos,
                                    CLB.FTSrvCode AS rtSrvCode,
                                    SRVL.FTSrvName AS rtSrvName,
                                    CLB.FDCreateOn  
                                FROM [TRGMCstBch] CLB WITH (NOLOCK)
                                LEFT JOIN  TRGMPosSrv_L SRVL WITH (NOLOCK) ON CLB.FTSrvCode = SRVL.FTSrvCode AND  SRVL.FNLngID = $nLngID 
                                WHERE  CLB.FTCstCode = '$tCstCode' AND CLB.FNCbrSeq = '$nCbrSeq'
            ";
    
        $oQuery = $this->db->query($tSQL);
        
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->row_array();
            $aResult = array(
                'raItems'       => @$oDetail,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );
        }else{
            //Not Found
            $aResult = array(
                'rtCode' => '800',
                'rtDesc' => 'data not found.',
            );
        }

        return $aResult;
    }


    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaCLBGetLastSeqCstBch($ptCstCode){

        $rnCbrLastSeq =  $this->db->where('FTCstCode',$ptCstCode)->order_by('FNCbrSeq','DESC')->limit(1)->get('TRGMCstBch')->row_array()['FNCbrSeq'];

        if(!empty($rnCbrLastSeq)){
            return  $rnCbrLastSeq;
        }else{
            return  0;
        }
            
    }


    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaCLBInsertUpdateCstBch($paData){
        try{

               $nNumrowsCstBch =  $this->db->where('FTCstCode',$paData['FTCstCode'])->where('FNCbrSeq',$paData['FNCbrSeq'])->get('TRGMCstBch')->num_rows();

               if($nNumrowsCstBch>0){
                $this->db->where('FTCstCode',$paData['FTCstCode'])->where('FNCbrSeq',$paData['FNCbrSeq'])->update('TRGMCstBch',$paData);
               }else{
                $this->db->insert('TRGMCstBch',$paData);
               }

               if($this->db->affected_rows() > 0){
                    $aStatus = array(
                        'rtCode' => '01',
                        'rtDesc' => 'Add Master Success',
                    );
                }else{
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
                return $aStatus;
            }catch(Exception $Error){
                echo $Error;
            }

    }

    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCLBDel($paData){
        try{
            $rtCstCode =  $paData['FTCstCode'];
            $rnCbrSeq =  $paData['FNCbrSeq'];

            $this->db->where('FTCstCode',$rtCstCode)->where('FNCbrSeq',$rnCbrSeq)->delete('TRGMCstBch');
        
            
        }catch(Exception $Error){
            echo $Error;
        }
    }



    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSnMCLBDelBchAddr($paData){
        try{
            $FTCstCode =  $paData['FTCstCode'];
            $FTAddRefNo =  $paData['FTAddRefNo'];
            $FTAddGrpType =  $paData['FTAddGrpType'];

            $this->db->where('FTCstCode',$FTCstCode)->where('FTAddRefNo',$FTAddRefNo)->where('FTAddGrpType',$FTAddGrpType)->delete('TCNMCstAddress_L');
        
            
        }catch(Exception $Error){
            echo $Error;
        }
    }




    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FStMCLBGetServerTypeByCst($ptCstCode){

        $tSQL = "SELECT 
                        SRV.FTSrvStaCenter
                    FROM TRGMCstBch CSTB
                    INNER JOIN TRGMPosSrv SRV ON
                    CSTB.FTSrvCode = SRV.FTSrvCode
                    WHERE CSTB.FTCstCode='$ptCstCode'
                    ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()['FTSrvStaCenter'];
        }else{
            //No Data
            return false;
        }
    }


    /**
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FStMCLBGetBusinessTypeByCst($ptCstCode){

        $tSQL = "  SELECT 
                    FTRegLicType 
                    FROM TRGMCstRegis 
                    WHERE FTRegRefCst = '$ptCstCode'
                    ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()['FTRegLicType'];
        }else{
            //No Data
            return false;
        }
    }
    

}
