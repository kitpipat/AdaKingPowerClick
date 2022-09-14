<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mApproveCst extends CI_Model {

       /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMAPCList($paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $dCreateOn     = $paData['FDCreateOn'];
        $tRegBusName     = $paData['FTRegBusName'];
        $tRegLicGroup     = $paData['FTRegLicGroup'];

        $tWhereSql = '';

        if(!empty($dCreateOn)){//  - วันที่สมัคร
            $tWhereSql .= " AND  CONVERT(VARCHAR(10),CSTREG.FDCreateOn,121) = '$dCreateOn' ";
        }

        if(!empty($tRegBusName)){//  - ชื่อธุรกิจ
            $tWhereSql .= " AND  CSTREG.FTRegBusName COLLATE THAI_BIN LIKE '%$tRegBusName%' ";
        }

        if(!empty($tRegLicGroup)){//  - กลุ่มการลงทะเบียน
            $tWhereSql .= " AND  CSTREG.FTRegLicGroup = '$tRegLicGroup' ";
        }
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CSTREG.FNRegID,
                            CSTREG.FTRegBusName,
                            CSTREG.FNRegQtyBch,
                            CSTREG.FTRegLicGroup,
                            CSTREG.FTRegLicType,
                            CSTREG.FTRegBusOth,
                            CSTREG.FTRegRefCst,
                            CSTREG.FTRegStaConfirm,
                            CSTREG.FTRegStaActive,
                            CSTREG.FDLastUpdOn,
                            CSTREG.FTLastUpdBy,
                            CSTREG.FDCreateOn,
                            CSTREG.FTCreateBy
                            FROM
                                TRGMCstRegis CSTREG WITH (NOLOCK)
                            WHERE ISNULL(CSTREG.FTRegRefCst,'')=''
                            $tWhereSql
                        ";

    

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);


        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMAPCGetPageAll($tWhereSql, $nLngID);
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
    public function FSnMAPCGetPageAll($ptWhereSql, $ptLngID){
        $tSQL = "SELECT COUNT (CSTREG.FNRegID) AS counts
                FROM [TRGMCstRegis] CSTREG
                WHERE ISNULL(CSTREG.FTRegRefCst,'')='' $ptWhereSql ";
        

        
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
    public function FSaMAPCSearchByID($paData){

        $nRegID     = $paData['FNRegID'];
        $nLngID     = $paData['FNLngID'];

            $tSQL  = " SELECT DISTINCT
                            CSTREG.FNRegID,
                            CSTREG.FTRegBusName,
                            CSTREG.FNRegQtyBch,
                            CSTREG.FTRegLicGroup,
                            CSTREG.FTRegLicType,
                            CSTREG.FTRegBusOth,
                            CSTREG.FTRegRefCst,
                            CSTREG.FTRegEmail,
                            CSTREG.FTRegTel,
                            CSTREG.FTRegStaConfirm,
                            CSTREG.FTRegStaActive,
                            CSTREG.FDLastUpdOn,
                            CSTREG.FTLastUpdBy,
                            CSTREG.FDCreateOn,
                            CSTREG.FTCreateBy
                            FROM
                                TRGMCstRegis CSTREG WITH (NOLOCK)
                            WHERE ISNULL(CSTREG.FTRegRefCst,'')=''
                            AND  CSTREG.FNRegID = '$nRegID'
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
    public function FSaMAPCInsertUpdateApproveCst($paData){
        try{

               $nNumrowsCstBch =  $this->db->where('FNRegID',$paData['FNRegID'])->get('TRGMCstRegis')->num_rows();
         
               if($nNumrowsCstBch>0){
                $this->db->where('FNRegID',$paData['FNRegID'])->update('TRGMCstRegis',$paData);
               }else{
                $this->db->insert('TRGMCstRegis',$paData);
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




}
