<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mCustomerBuyLic extends CI_Model {

       /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMCBLList($paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $tCstCode     = $paData['tCstCode'];

        $tWhereCode = '';
        if(!empty($tCstCode)){
            $tWhereCode .= " AND CBL.FTCstCode ='$tCstCode' ";
        }
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY rnLicUUIDSeq ASC) AS rtRowID,*
                        FROM
                        (SELECT DISTINCT
                            CBL.FTCstCode AS rtCstCode,
                            CBL.FTCbrRefBch AS rtCbrRefBch,
                            CBL.FTLicPdtCode AS rtLicPdtCode,
                            CBL.FTCbrRefPos AS rtCbrRefPos,
                            CBL.FNLicUUIDSeq AS rnLicUUIDSeq,
                            PDT_L.FTPdtName AS rtPdtName,
                            PDTYP_L.FTPtyName AS rtPtyName,
                            CBL.FTLicRefSaleDoc AS rtLicRefSaleDoc,
                            DATEDIFF(month, CBL.FDLicStart, CBL.FDLicFinish) AS rnMonth,
                            CBL.FDLicStart AS rdLicStart,
                            CBL.FDLicFinish AS rdLicFinish,
                            CBL.FTLicStaUse AS rtLicStaUse,
                            CBL.FTRegStaActive AS rtRegStaActive,
                            CBL.FTLicRefUUID AS rtLicRefUUID
                            FROM
                                TRGTCstBchLic CBL WITH (NOLOCK)
                            LEFT OUTER JOIN TCNMPdt PDT WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT.FTPdtCode
                            LEFT OUTER JOIN TCNMPdt_L PDT_L WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID
                            LEFT OUTER JOIN TCNMPdtType_L PDTYP_L WITH (NOLOCK) ON CBL.FTLicPtyCode = PDTYP_L.FTPtyCode AND PDTYP_L.FNLngID = $nLngID
                        WHERE 1=1 $tWhereCode";

        $tSearchList = $paData['tSearchAll'];
        if ($tSearchList != ''){
            $tSQL .= " AND (CBL.FTCstCode COLLATE THAI_BIN LIKE '%$tSearchList%'";  
            $tSQL .= " OR CBL.FTCbrRefBch COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CBL.FTLicPdtCode COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR PDT_L.FTPdtName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR PDTYP_L.FTPtyName COLLATE THAI_BIN LIKE '%$tSearchList%'";
            $tSQL .= " OR CBL.FTLicRefSaleDoc COLLATE THAI_BIN LIKE '%$tSearchList%')";
        }
        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);
        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMCBLGetPageAll($tWhereCode, $tSearchList, $nLngID);
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
    public function FSnMCBLGetPageAll($ptWhereCode, $ptSearchList, $ptLngID){
        $tSQL = "SELECT COUNT (CBL.FTCstCode) AS counts
                FROM [TRGTCstBchLic] CBL
                LEFT OUTER JOIN TCNMPdt PDT WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT.FTPdtCode
                LEFT OUTER JOIN TCNMPdt_L PDT_L WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $ptLngID
                LEFT OUTER JOIN TCNMPdtType_L PDTYP_L WITH (NOLOCK) ON CBL.FTLicPtyCode = PDTYP_L.FTPtyCode AND PDTYP_L.FNLngID = $ptLngID
                WHERE 1=1 $ptWhereCode ";
        
        if($ptSearchList != ''){
            $tSQL .= " AND (CBL.FTCstCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";  
            $tSQL .= " OR CBL.FTCbrRefBch COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CBL.FTLicPdtCode COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR PDT_L.FTPdtName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR PDTYP_L.FTPtyName COLLATE THAI_BIN LIKE '%$ptSearchList%'";
            $tSQL .= " OR CBL.FTLicRefSaleDoc COLLATE THAI_BIN LIKE '%$ptSearchList%')";
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
    public function FSaMCBLSearchByID($paData){

        $tCstCode   = $paData['FTCstCode'];
        $tCbrRefBch   = $paData['FTCbrRefBch'];
        $tLicPdtCode   = $paData['FTLicPdtCode'];
        $nLicUUIDSeq   = $paData['FNLicUUIDSeq'];
        $nLngID     = $paData['FNLngID'];

            $tSQL       = " SELECT 
                                CBL.FTCstCode AS rtCstCode,
                                CBL.FTCbrRefBch AS rtCbrRefBch,
                                CBL.FTCbrRefPos AS rtCbrRefPos,
                                CBL.FNLicUUIDSeq AS rnLicUUIDSeq,
                                CBL.FTLicPdtCode AS rtLicPdtCode,
                                PDT_L.FTPdtName AS rtPdtName,
                                PDT.FTPtyCode AS rtPtyCode,
                                PDTYP_L.FTPtyName AS rtPtyName,
                                CBL.FTLicRefSaleDoc AS rtLicRefSaleDoc,
                                DATEDIFF(month, CBL.FDLicStart, CBL.FDLicFinish) AS rnMonth,
                                CBL.FDLicStart AS rdLicStart,
                                CBL.FDLicFinish AS rdLicFinish,
                                CBL.FTLicStaUse AS rtLicStaUse,
                                CBL.FTRegStaActive AS rtRegStaActive,
                                CBL.FTLicRefUUID AS rtLicRefUUID
                                FROM
                                    TRGTCstBchLic CBL WITH (NOLOCK)
                                LEFT OUTER JOIN TCNMPdt PDT WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT.FTPdtCode
                                LEFT OUTER JOIN TCNMPdt_L PDT_L WITH (NOLOCK) ON CBL.FTLicPdtCode = PDT_L.FTPdtCode AND PDT_L.FNLngID = $nLngID
                                LEFT OUTER JOIN TCNMPdtType_L PDTYP_L WITH (NOLOCK) ON CBL.FTLicPtyCode = PDTYP_L.FTPtyCode AND PDTYP_L.FNLngID = $nLngID
                                WHERE  CBL.FTCstCode = '$tCstCode' AND CBL.FTCbrRefBch = '$tCbrRefBch'  AND CBL.FNLicUUIDSeq='$nLicUUIDSeq' AND CBL.FTLicPdtCode='$tLicPdtCode'
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
    public function FSaMCBLInsertUpdateCstBuyLic($paData,$paWhere){
        try{
            
               $nNumrowsCstBch =  $this->db->where('FTCstCode',$paWhere['FTCstCode'])->where('FTCbrRefBch',$paWhere['FTCbrRefBch'])->where('FNLicUUIDSeq',$paWhere['FNLicUUIDSeq'])->where('FTLicPdtCode',$paWhere['FTLicPdtCode'])->get('TRGTCstBchLic')->num_rows();
         
               if($nNumrowsCstBch>0){
                $this->db->where('FTCstCode',$paWhere['FTCstCode'])->where('FTCbrRefBch',$paWhere['FTCbrRefBch'])->where('FNLicUUIDSeq',$paWhere['FNLicUUIDSeq'])->where('FTLicPdtCode',$paWhere['FTLicPdtCode'])->update('TRGTCstBchLic',$paData);
               }else{
                $this->db->insert('TRGTCstBchLic',$paData);
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
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMCLNGetDataExport($ptCstCode){
        try{
            $tSQL = "SELECT
                        CSTREGIS.FTRegBusName,
                        CSTREGIS.FNRegQtyBch,
                        CST.FTCstEmail,
                        CST.FTCstTel,
                        CSTREGIS.FTRegRefCst,
                        SRVP.FTSrvStaCenter,
                        SRVP.FTSrvRefSBUrl
                        FROM TRGMCstRegis CSTREGIS
                        LEFT OUTER JOIN TCNMCst CST ON CSTREGIS.FTRegRefCst = CST.FTCstCode
                        LEFT OUTER JOIN (
                                SELECT 
                                    SRV.FTSrvStaCenter,SRV.FTSrvRefSBUrl,CSTB.FNCbrSeq,CSTB.FTCstCode
                                    FROM TRGMCstBch CSTB
                                    INNER JOIN TRGMPosSrv SRV ON CSTB.FTSrvCode = SRV.FTSrvCode
                        ) SRVP ON CSTREGIS.FTRegRefCst = SRVP.FTCstCode AND SRVP.FNCbrSeq = 1
                        WHERE CSTREGIS.FTRegRefCst ='$ptCstCode'
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
        }catch(Exception $Error){
            return $Error;
        }

      }



     /**
     * Functionality : FScMCSTGetPntExp
     * Parameters : $paData
     * Creator : 01/04/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
    public function FSaMCLNGetDataLicenseExport($paData,$ptType){
        try{

                $tCstCode = $paData['FTCstCode'];
                $tCbrRefBch = $paData['FTCbrRefBch'];
                $nLicUUIDSeq = $paData['FNLicUUIDSeq'];
                $tLicPdtCode = $paData['FTLicPdtCode'];


                $tSQL = "SELECT
                                CstBchLic.FNLicUUIDSeq AS pnLicUUIDSeq,
                                CstBchLic.FTLicPdtCode AS ptPdtCode,
                                PDT.FTPtyCode AS ptPtyCode,
                                CstBchLic.FTCbrRefBch AS ptBchRef,
                                CstBchLic.FTLicRefUUID AS ptKeyRefDevice, 
                                CONVERT(varchar(10), CstBchLic.FDLicStart, 120) AS ptStartDate,
                                CONVERT(varchar(10), CstBchLic.FDLicFinish, 120) AS ptFinishDate
                            FROM TRGTCstBchLic CstBchLic WITH (NOLOCK)
                            LEFT OUTER JOIN TCNMPdt PDT WITH (NOLOCK) ON  CstBchLic.FTLicPdtCode = PDT.FTPdtCode
                        WHERE CstBchLic.FTCstCode = '$tCstCode' 
                    ";
                    if(!empty($tCbrRefBch)){
                        $tSQL .= " AND CstBchLic.FTCbrRefBch = '$tCbrRefBch' ";
                    }

                    if(!empty($nLicUUIDSeq)){
                        $tSQL .= " AND CstBchLic.FNLicUUIDSeq = '$nLicUUIDSeq'";
                    }

                    if(!empty($tLicPdtCode)){
                        $tSQL .= " AND CstBchLic.FTLicPdtCode = '$tLicPdtCode'";
                    }

                $oQuery = $this->db->query($tSQL);
              
            if ($oQuery->num_rows() > 0){

             if($ptType==0){
              return  $oDetail = $oQuery->row_array();
             }else{
                return  $oDetail = $oQuery->result_array();
            }

                // $aResult = array(
                //     'raItems'       => @$oDetail,
                //     'rtCode'        => '1',
                //     'rtDesc'        => 'success',
                // );
            }else{


                return array();
                //Not Found
                // $aResult = array(
                //     'rtCode' => '800',
                //     'rtDesc' => 'data not found.',
                // );
            }
            return $aResult;
        }catch(Exception $Error){
            return $Error;
        }

      }

     /**
     * Functionality : FSaMCLNGetInfoServerByCstKey
     * Parameters : $paData
     * Creator : 19/03/2020 Nale
     * Last Modified : -
     * Return : status
     * Return Type : array
     */
      public function FSaMCLNGetInfoServerByCstKey($ptCstKey){
        try{
            $tSQL = "SELECT BCH.FTCstCode, SRV.*
            FROM TRGMCstBch BCH WITH(NOLOCK)
            INNER JOIN TRGMPosSrv SRV WITH(NOLOCK) ON
             BCH.FTSrvCode = SRV.FTSrvCode
            WHERE BCH.FTCstCode='$ptCstKey'";

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
        }catch(Exception $Error){
            return $Error;
        }

      }

}
