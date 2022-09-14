<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mApproveLic extends CI_Model {

       /**
     * Functionality : List department
     * Parameters : $ptAPIReq, $ptMethodReq is request type, $paData is data for select filter
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMAPLList($paData){
    	// return null;
        $aRowLen    = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
        $nLngID     = $paData['FNLngID'];
        $dXshDocDate     = $paData['FDXshDocDate'];
        $tAPCKeyword     = $paData['tAPCKeyword'];

        $tWhereSql = '';

        if(!empty($dXshDocDate)){//  - วันที่ขาย
            $tWhereSql .= " AND  CONVERT(VARCHAR(10),HD.FDXshDocDate,121) = '$dXshDocDate' ";
        }

        if(!empty($tAPCKeyword)){//  - กลุ่มการลงทะเบียน
            $tWhereSql .= " AND ( HD.FTXshDocNo COLLATE THAI_BIN LIKE '%$tAPCKeyword%' OR HD.FTCstCode COLLATE THAI_BIN LIKE '%$tAPCKeyword%' OR CST.FTCstName COLLATE THAI_BIN LIKE '%$tAPCKeyword%' OR HDCST.FTXshCstName COLLATE THAI_BIN LIKE '%$tAPCKeyword%' ) ";
        }
        $tSQL     = "SELECT c.* FROM(
                    SELECT  ROW_NUMBER() OVER(ORDER BY FDXshDocDate DESC) AS rtRowID,*
                        FROM
                        (   SELECT DISTINCT
                                BCH_L.FTBchName,
                                CASE  WHEN ISNULL(CST.FTCstName,'') != '' THEN 
                                           ISNULL(CST.FTCstName,'') 
                                      ELSE 
                                           ISNULL(HDCST.FTXshCstName,'')  
                                END  AS FTCstName,
                                HD.FTBchCode,
                                HD.FTXshDocNo,
                                HD.FDXshDocDate,
                                HD.FTXshStaPaid,
                                HD.FTCstCode,
                                HD.FCXshTotal,
                                HD.FCXshVat,
                                DTDis.FCXddValue,
                                HD.FCXshGrand
                            FROM
                                TPSTSalHD HD WITH (NOLOCK)
                            LEFT OUTER JOIN TCNMCst_L CST WITH(NOLOCK) ON HD.FTCstCode = CST.FTCstCode AND CST.FNLngID = $nLngID
                            LEFT OUTER JOIN TCNMBranch_L BCH_L WITH (NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                            LEFT OUTER JOIN TPSTSalHDCst HDCST WITH(NOLOCK) ON HD.FTBchCode = HDCST.FTBchCode AND HD.FTXshDocNo = HDCST.FTXshDocNo
                            LEFT OUTER JOIN ( 
                                                 SELECT
                                                        Dis.FTBchCode,
                                                        Dis.FTXshDocNo,
                                                        SUM(
                                                            CASE
                                                            WHEN FTXddDisChgType = 3 OR  FTXddDisChgType = 4 THEN
                                                                Dis.FCXddValue * (- 1)
                                                            ELSE
                                                                Dis.FCXddValue
                                                            END
                                                        ) AS FCXddValue
                                                    FROM
                                                        TPSTSalDTDis Dis WITH (NOLOCK)
                                                    GROUP BY
                                                        Dis.FTBchCode,
                                                        Dis.FTXshDocNo
                            ) DTDis ON HD.FTBchCode = DTDis.FTBchCode AND HD.FTXshDocNo = DTDis.FTXshDocNo
                            WHERE HD.FTXshStaDoc = 1 
                            AND HD.FTXshStaPaid = 1
                            $tWhereSql
                        ";

    

        $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
        
        $oQuery = $this->db->query($tSQL);


        if($oQuery->num_rows() > 0){
            $oList = $oQuery->result();
            $aFoundRow = $this->FSnMAPLGetPageAll($tWhereSql, $nLngID);
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
    public function FSnMAPLGetPageAll($ptWhereSql, $ptLngID){
        $tSQL = "   SELECT COUNT (HD.FTXshDocNo) AS counts
                     FROM [TPSTSalHD] HD
                    LEFT OUTER JOIN TCNMCst_L CST WITH(NOLOCK) ON HD.FTCstCode = CST.FTCstCode AND CST.FNLngID = $ptLngID
                    LEFT OUTER JOIN TCNMBranch_L BCH_L WITH (NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $ptLngID
                    LEFT OUTER JOIN TPSTSalHDCst HDCST WITH(NOLOCK) ON HD.FTBchCode = HDCST.FTBchCode AND HD.FTXshDocNo = HDCST.FTXshDocNo
                    WHERE  HD.FTXshStaDoc = 1 
                    AND HD.FTXshStaPaid = 1 
                      $ptWhereSql ";
        
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
    public function FSaMAPLDataHD($paData){

        $tDocumentNumber     = $paData['tDocumentNumber'];
        $nLngID     = $paData['FNLngID'];

            $tSQL  = "SELECT DISTINCT
                            BCH_L.FTBchName,
                            CASE  WHEN ISNULL(CST.FTCstName,'') != '' THEN 
                                    ISNULL(CST.FTCstName,'') 
                                ELSE 
                                    ISNULL(HDCST.FTXshCstName,'')  
                            END  AS FTCstName,
                            HD.FTBchCode,
                            HD.FTXshDocNo,
                            HD.FDXshDocDate,
                            HD.FTXshStaPaid,
                            HD.FTCstCode,
                            HD.FCXshTotal,
                            HD.FCXshVat,
                            DTDis.FCXddValue,
                            HD.FCXshGrand,
                            CSTREG.FTRegBusName,
                            CSTREG.FTRegBusOth,
                            CSTREG.FTRegEmail,
                            CSTREG.FTRegTel
                        FROM
                            TPSTSalHD HD WITH (NOLOCK)
                         LEFT OUTER JOIN TRGMCstRegis CSTREG WITH (NOLOCK) ON HD.FTCstCode = CSTREG.FTRegRefCst
                        LEFT OUTER JOIN TCNMCst_L CST WITH(NOLOCK) ON HD.FTCstCode = CST.FTCstCode AND CST.FNLngID = $nLngID
                        LEFT OUTER JOIN TCNMBranch_L BCH_L WITH (NOLOCK) ON HD.FTBchCode = BCH_L.FTBchCode AND BCH_L.FNLngID = $nLngID
                        LEFT OUTER JOIN TPSTSalHDCst HDCST WITH(NOLOCK) ON HD.FTBchCode = HDCST.FTBchCode AND HD.FTXshDocNo = HDCST.FTXshDocNo
                        LEFT OUTER JOIN ( 
                                            SELECT
                                                    Dis.FTBchCode,
                                                    Dis.FTXshDocNo,
                                                    SUM(
                                                        CASE
                                                        WHEN FTXddDisChgType = 3 OR  FTXddDisChgType = 4 THEN
                                                            Dis.FCXddValue * (- 1)
                                                        ELSE
                                                            Dis.FCXddValue
                                                        END
                                                    ) AS FCXddValue
                                                FROM
                                                    TPSTSalDTDis Dis WITH (NOLOCK)
                                                GROUP BY
                                                    Dis.FTBchCode,
                                                    Dis.FTXshDocNo
                        ) DTDis ON HD.FTBchCode = DTDis.FTBchCode AND HD.FTXshDocNo = DTDis.FTXshDocNo
                        WHERE HD.FTXshStaDoc = 1 
                        AND HD.FTXshDocNo = '$tDocumentNumber'
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
    public function FSaMAPLDataDT($paData){
        $tDocumentNumber   = $paData['tDocumentNumber'];
        $nLngID            = $paData['FNLngID'];
        $tSQL              = "SELECT
                                ROW_NUMBER () OVER (
                                    PARTITION BY ISNULL(PdtTp.FTPtyCode, '')
                                    ORDER BY
                                        ISNULL(PdtTp.FTPtyCode, '')
                                ) row_num,
                                ISNULL(
                                    Footer_pdtType.LastPdtPty,
                                    1
                                ) AS LastPdtPty,
                                HD.FTXshDocNo AS FTXshDocNo,
                                HD.FCXshTotal AS FCXshTotal,
                                HD.FCXshDis AS FCXshDis,
                                HD.FCXshVat AS FCXshVat,
                                HD.FCXshGrand AS FCXshGrand,
                                DT.FTXsdPdtName AS FTBuyLicenseTextPackage,
                                DT.FCXsdNetAfHD AS LicenseTextPackagePrice,
                                DT.FTPunCode AS FTPunCode,
                                DT.FTPunName AS FTBuyLicenseTextPackageMonth,
                                ISNULL(PdtTp.FTPtyCode, '') AS FTPtyCode,
                                CASE
                            WHEN ISNULL(PdtTp.FTPtyCode, '') = '' THEN
                                'General Product'
                            ELSE
                                PdtTp.FTPtyName
                            END AS FTPtyName
                            FROM
                                [TPSTSalHD] HD WITH (NOLOCK)
                            LEFT JOIN [TPSTSalDT] DT WITH (NOLOCK) ON HD.FTXshDocNo = DT.FTXshDocNo
                            LEFT JOIN [TCNMPdt] Pdt WITH (NOLOCK) ON DT.FTPdtCode = Pdt.FTPdtCode
                            LEFT JOIN [TCNMPdtType_L] PdtTp WITH (NOLOCK) ON Pdt.FTPtyCode = PdtTp.FTPtyCode
                            AND PdtTp.FNLngID = 1
                            LEFT JOIN (
                                SELECT
                                    COUNT (*) AS LastPdtPty,
                                    TPSTSalDT.FTBchCode,
                                    TPSTSalDT.FTXshDocNo,
                                    ISNULL(TCNMPdt.FTPtyCode,'') AS FTPtyCode
                                FROM
                                    TPSTSalDT
                                LEFT JOIN TCNMPdt ON TPSTSalDT.FTPdtCode = TCNMPdt.FTPdtCode
                                GROUP BY
                                    TPSTSalDT.FTBchCode,
                                    TPSTSalDT.FTXshDocNo,
                                    ISNULL(TCNMPdt.FTPtyCode,'')
                            ) Footer_pdtType ON HD.FTBchCode = Footer_pdtType.FTBchCode
                            AND HD.FTXshDocNo = Footer_pdtType.FTXshDocNo
                            AND ISNULL(PdtTp.FTPtyCode,'') = Footer_pdtType.FTPtyCode
                            WHERE 1=1 ";
        if($tDocumentNumber != ""){
            $tSQL .= "AND HD.FTXshDocNo = '$tDocumentNumber'";
        }
            $tSQL .= " ORDER BY PdtTp.FTPtyCode ASC ";

        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
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
     * Functionality : All Page Of Customer
     * Parameters : $ptSearchList, $ptLngID
     * Creator : 13/01/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMAPLUpdateApproveLic($paData){
        try{
         
                $this->db->where('FTXshDocNo',$paData['FTXshDocNo'])->update('TPSTSalHD',$paData);
            

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
     * Functionality : LUpdateDateApproveSalRC
     * Parameters : $paData
     * Creator : 24/03/2021 Nale
     * Last Modified : -
     * Return : data
     * Return Type : array
     */
    public function FSaMAPLUpdateDateApproveSalRC($paData){
        try{
         
            $this->db->where('FTXshDocNo',$paData['FTXshDocNo'])->where('FNXrcSeqNo',$paData['FNXrcSeqNo'])->update('TPSTSalRC',$paData);
        

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
