<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mProduct extends CI_Model {

    //Functionality : list Data Product
    //Parameters : function parameters
    //Creator :  21/11/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMPDTList($paData){
        try{
            $aRowLen        = FCNaHCallLenData($paData['nRow'],$paData['nPage']);
            $nLngID         = $paData['FNLngID'];
            $tSplCode         = $paData['tSplCode'];
            $tSearchList    = $paData['tSearchAll'];
            $tSQL           = "SELECT c.* FROM(
                                    SELECT  ROW_NUMBER() OVER(ORDER BY rtBarCode ASC) AS rtRowID,* FROM
                                        (SELECT 
                                            FTSplCode AS rtSplCode,
                                            PdtSpl.FTPdtCode AS rtPdtCode,
                                            Pdt_L.FNLngID AS rtLngID,
                                            PdtSpl.FTBarCode AS rtBarCode,
                                            FTPdtName AS rtPdtName,
                                            User_L.FTUsrName AS rtUsrName
                                            

                                        FROM TCNMPdtSpl PdtSpl
                                        LEFT JOIN TCNMPdt_L Pdt_L ON PdtSpl.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = $nLngID
                                        LEFT JOIN TCNMUser_L User_L ON PdtSpl.FTUsrCode = User_L.FTUsrCode AND User_L.FNLngID = $nLngID
                                        WHERE FTSplCode = '$tSplCode' ";
            if(isset($tSearchList) && !empty($tSearchList)){
                $tSQL .= " AND (PdtSpl.FTPdtCode LIKE '%$tSearchList%'";
                $tSQL .= " OR PdtSpl.FTBarCode LIKE '%$tSearchList%' ";
                $tSQL .= " OR FTPdtName LIKE '%$tSearchList%' ";
                $tSQL .= " OR FTUsrCode LIKE '%$tSearchList%' )";
            }
            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $aList = $oQuery->result_array();
                $oFoundRow = $this->FSoMPDTGetPageAll($tSearchList,$nLngID,$tSplCode);
                $nFoundRow = $oFoundRow[0]->counts;
                $nPageAll = ceil($nFoundRow/$paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult = array(
                    'raItems'       => $aList,
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
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : All Page Of Product
    //Parameters : function parameters
    //Creator :  21/11/2018 Phisan
    //Return : object Count All Product Type
    //Return Type : Object
    public function FSoMPDTGetPageAll($ptSearchList,$pnLngID,$ptSplCode){
        try{
            $tSQL = "SELECT COUNT (FTBarCode) AS counts
                        FROM TCNMPdtSpl PdtSpl
                        WHERE FTSplCode = '$ptSplCode'
                        ";
            if(isset($ptSearchList) && !empty($ptSearchList)){
                $tSQL .= " AND (PdtSpl.FTPdtCode LIKE '%$ptSearchList%'";
                $tSQL .= " OR PdtSpl.FTBarCode LIKE '%$ptSearchList%' ";
                $tSQL .= " OR FTPdtName LIKE '%$ptSearchList%' ";
                $tSQL .= " OR FTUsrCode LIKE '%$ptSearchList%' )";
            }
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            }else{
                return false;
            }
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get Data Product By ID
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : data
    //Return Type : Array
    public function FSaMPDTGetDataByID($paData){
        try{
            $tSplCode   = $paData['FTSplCode'];
            $nLngID     = $paData['FNLngID'];
            $tPdtCode   = $paData['FTPdtCode'];
            $tBarCode   = $paData['FTBarCode'];
            $tSQL       = " SELECT
                                PdtSpl.FTPdtCode  AS rtPdtCode,
                                FTBarCode  AS rtBarCode,
                                FTSplCode  AS rtSplCode,
                                FCSplLastPrice  AS rtSplLastPrice,
                                FDSplLastDate  AS rtSplLastDate,
                                PdtSpl.FTUsrCode  AS rtUsrCode,
                                FTSplStaAlwPO  AS rtSplStaAlwPO,
                                FDPdtAlwOrdStart  AS rtPdtAlwOrdStart,
                                FDPdtAlwOrdStop  AS rtPdtAlwOrdStop,
                                FTPdtOrdDay  AS rtPdtOrdDay,
                                FTPdtStaAlwOrdSun  AS rtPdtStaAlwOrdSun,
                                FTPdtStaAlwOrdMon  AS rtPdtStaAlwOrdMon,
                                FTPdtStaAlwOrdTue  AS rtPdtStaAlwOrdTue,
                                FTPdtStaAlwOrdWed  AS rtPdtStaAlwOrdWed,
                                FTPdtStaAlwOrdThu  AS rtPdtStaAlwOrdThu,
                                FTPdtStaAlwOrdFri  AS rtPdtStaAlwOrdFri,
                                FTPdtStaAlwOrdSat  AS rtPdtStaAlwOrdSat,
                                FCPdtLeadTime  AS rtPdtLeadTime,
                                FTPdtName AS rtPdtName,
                                Pdt_L.FNLngID AS rtLngID,
                                User_L.FTUsrName AS rtUsrName
                                

                            FROM TCNMPdtSpl PdtSpl
                            LEFT JOIN TCNMPdt_L Pdt_L ON PdtSpl.FTPdtCode = Pdt_L.FTPdtCode AND Pdt_L.FNLngID = $nLngID
                            LEFT JOIN TCNMUser_L User_L ON PdtSpl.FTUsrCode = User_L.FTUsrCode AND User_L.FNLngID = $nLngID
                            WHERE FTSplCode = '$tSplCode' AND PdtSpl.FTPdtCode = '$tPdtCode' AND FTBarCode = '$tBarCode' ";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0){
                $aDetail = $oQuery->row_array();
                $aResult = array(
                    'raItems'   => $aDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            }else{
                $aResult = array(
                    'rtCode' => '800',
                    'rtDesc' => 'Data not found.',
                );
            }
            return $aResult;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Add Table Product
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMPDTAddMaster($paData){
        try{
            //Add Product Main Table
            $this->db->insert('TCNMPdtSpl',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Product Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Product.',
                );
            }
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }
    //Functionality : Add Table Ad
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMPDTAddDT($paData){
        try{
            //Add Product Main Table
            $this->db->insert('TCNMSplAddress_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Address Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add Address.',
                );
            }
            
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Chk Dup
    //Parameters : function parameters
    //Creator : 11/12/2018 Phisan
    //Return : Array Stutus ChkDup
    //Return Type : Array
    public function FSaMPDTChkDup($paPK){
        try{

            $this->db->select('FTPdtCode,FTBarCode,FTSplCode');
            
            $this->db->where('FTPdtCode',$paPK['FTPdtCode']);
            $this->db->where('FTBarCode',$paPK['FTBarCode']);
            $this->db->where('FTSplCode',$paPK['FTSplCode']);
            $oQuery = $this->db->get('TCNMPdtSpl');
            $oQuery->result_array();
            
            // $x = $this->db->last_query();
            // echo '<pre>';
            // print_r($aItem);
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success.',
                'raItem' => $oQuery->num_rows()
            );
            return $aStatus;

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Get PdtCode
    //Parameters : function parameters
    //Creator : 23/11/2018 Phisan
    //Return : Array Stutus Add
    //Return Type : Array
    public function FSaMPDTGetPdtCode($paBarCode){
        try{

            $this->db->select('FTPdtCode,FTBarCode');
            if(FCNnHSizeOf($paBarCode) > 0){
                $this->db->where_in('FTBarCode',$paBarCode);
            }else{
                $this->db->where('FTBarCode','');
            }
            $oQuery = $this->db->get('TCNMPdtBar');
            $aItem = $oQuery->result_array();
            // $x = $this->db->last_query();
            // echo '<pre>';
            // print_r($aItem);
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success.',
                'raItem' => $aItem
            );
            return $aStatus;

        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Table Product
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMPDTUpdateMaster($paData){
        try{
            
            $this->db->where('FTPdtCode',$paData['FTPdtCode']);
            $this->db->where('FTBarCode',$paData['FTBarCode']);
            $this->db->where('FTSplCode',$paData['FTSplCode']);
            $this->db->update('TCNMPdtSpl',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Product Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Edit Product.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Update Table DT
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Array Stutus Add/Update
    //Return Type : Array
    public function FSaMPDTDT($paData,$aPK){
        try{
            $this->db->where('FTSplCode', $aPK['FTSplCode']);
            $this->db->where('FNLngID', $aPK['FNLngID']);
            $this->db->where('FTAddGrpType', $aPK['FTAddGrpType']);
            $this->db->where('FNAddSeqNo', $aPK['FNAddSeqNo']);
            $this->db->update('TCNMSplAddress_L',$paData);
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Address Success.',
                );
            }else{
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Edit Address.',
                );
            }
            return $aStatus;
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Delete Product
    //Parameters : function parameters
    //Creator : 21/11/2018 Phisan
    //Return : Status Delete
    //Return Type : array
    public function FSnMPDTDel($paData){
        try{
            
            $this->db->trans_begin();
            $this->db->where('FTSplCode', $paData['FTSplCode']);
            $this->db->where('FTBarCode', $paData['FTBarCode']);
            $this->db->where('FTPdtCode', $paData['FTPdtCode']);
            $this->db->delete('TCNMPdtSpl');

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



    //Functionality: Get Pdt List
    //Parameters:  Function Parameter
    //Creator: 11/10/2018 Krit(Copter)
    //Last Modified :
    //Return : 
    //Return Type: Array
    function FSxMPDTGetBwsDataList($aDataSearch){

        $ci = &get_instance();
        $ci->load->database();

        $tLangActive =$this->sessison->tLangEdit;
        
        $tPdtBarCode = $aDataSearch['tPdtBarCode'];
        $tPdtCode    = $aDataSearch['tPdtCode'];
        $tPdtPdtName = $aDataSearch['tPdtPdtName'];
        $tPdtPunCode = $aDataSearch['tPdtPunCode'];
        
        $nPage = $aDataSearch['nPage'];
        $nRow  = $aDataSearch['nRow'];

        $aRowLen = FCNaHCallLenData($nRow,$nPage);

        $tSQL = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FTPdtCode ASC) AS FNRowID,* FROM
                        (SELECT DISTINCT
                                PDT.FTPdtCode,
                                BAR.FTBarCode,
                                PDTL.FTPdtName
                                
                            FROM TCNMPdt PDT
                            LEFT JOIN TCNMPdt_L PDTL        ON PDT.FTPdtCode = PDTL.FTPdtCode AND PDTL.FNLngID = $tLangActive
                            LEFT JOIN TCNMPdtBar BAR        ON BAR.FTPdtCode = PDT.FTPdtCode 
                            LEFT JOIN TCNMPdtPackSize PPZ 	 ON PDT.FTPdtCode = PPZ.FTPdtCode
                            LEFT JOIN TCNMPdtUnit_L PUL 	 ON PPZ.FTPunCode = PUL.FTPunCode AND PUL.FNLngID = $tLangActive
                            
                            
                            WHERE PDT.FTPdtStaActive = '1'  ";

        if($tPdtCode != ''){
            $tSQL .= " AND PDT.FTPdtCode LIKE '%$tPdtCode%' ";
        }

        if($tPdtBarCode != ''){
            $tSQL .= " AND BAR.FTBarCode LIKE '%$tPdtBarCode%'";
        }

        if($tPdtPdtName != ''){
            $tSQL .= " AND PDTL.FTPdtName LIKE '%$tPdtPdtName%' ";
        }

        if($tPdtPunCode != ''){
            $tSQL .= " AND BAR.FTPunCode = '$tPdtPunCode' ";
        }

        $tSQL .= ") Base) AS c WHERE c.FNRowID > $aRowLen[0] AND c.FNRowID <= $aRowLen[1]";

        $oQuery = $ci->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oRes  = $oQuery->result();
            $aFoundRow = FCNnHPdtGetPageAll($aDataSearch);
            $nFoundRow = $aFoundRow[0]->counts;
            $nPageAll = ceil($nFoundRow/$nRow); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
            $aResult = array(
                'raItems'       => $oRes,
                'rnAllRow'      => $nFoundRow,
                'rnCurrentPage' => $nPage,
                'rnAllPage'     => $nPageAll,
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            );

        }else{
            $aResult = array(
                'rnAllRow' => 0,
                'rnCurrentPage' => $nPage,
                "rnAllPage"=> 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;

    }



































    
}