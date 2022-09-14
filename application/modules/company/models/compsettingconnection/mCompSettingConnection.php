<?php
defined('BASEPATH') or exit('No direct script access allowed');

class mCompSettingConnection extends CI_Model
{

    //Functionality : List CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/10/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConnectDataList($paData)
    {
        try {
            $tCompCode       = $paData['FTUrlRefID'];

            $aRowLen        = FCNaHCallLenData($paData['nRow'], $paData['nPage']);
            $tFNLngID       = $paData['FNLngID'];
            $tSearchList    = $paData['tSearchAll'];

            $tSQL           = " SELECT c.* FROM(SELECT  ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC , FTUrlRefID DESC) AS rtRowID,*
                                FROM(
                                    SELECT
                                        URLObj.FNUrlID,
                                        URLObj.FTUrlRefID,
                                        URLObj.FNUrlType,
                                        URLObj.FTUrlTable,
                                        URLObj.FTUrlKey,
                                        URLObj.FTUrlAddress,
                                        URLObj.FTUrlPort,
                                        URLObj.FTUrlLogo,
                                        URLObj.FDCreateOn
                                    FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
                                    WHERE 1=1
                                    AND URLObj.FTUrlRefID = 'CENTER'
                                    AND URLObj.FNUrlType IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17')
                            ";
            if (isset($tSearchList) && !empty($tSearchList)) {
                $tSQL .= " AND (CASE URLObj.FNUrlType
                            WHEN '1' THEN 'URL'
                            WHEN '2' THEN 'URL + Authorized'
                            WHEN '3' THEN 'URL + MQ'
                            WHEN '4' THEN 'API2PSMaster'
                            WHEN '5' THEN 'API2PSSale'
                            WHEN '6' THEN 'API2RTMaster'
                            WHEN '7' THEN 'API2RTSale'
                            WHEN '8' THEN 'API2FNWallet'
                            WHEN '9' THEN 'API2CNMember'
                            WHEN '10' THEN 'API2RDFace'
                            WHEN '11' THEN 'API2RDFaceRegis'
                            WHEN '12' THEN 'API2ARDoc'
                            WHEN '13' THEN 'MQMember'
                            WHEN '14' THEN 'API2PSStock'
                            WHEN '15' THEN 'API2RTStock'
                            WHEN '16' THEN 'MQAI'
                            WHEN '17' THEN 'MQ'
                        END LIKE '%$tSearchList%' OR URLObj.FTUrlAddress LIKE '%$tSearchList%' OR URLObj.FTUrlPort LIKE '%$tSearchList%')";
            }

            // User BCH Level
            if ($this->session->userdata('tSesUsrLevel') == "BCH") { // ผู้ใช้ระดับ BCH ดูได้แค่สาขาที่มีสิทธิ์
                $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL .= " AND URLObj.FTUrlRefID IN($tBchCodeMulti)";
            }

            // User SHP Level
            if ($this->session->userdata('tSesUsrLevel') == "SHP") { // ผู้ใช้ระดับ SHP ดูได้แค่สาขาที่มีสิทธิ์
                $tBchCodeMulti = $this->session->userdata('tSesUsrBchCodeMulti');
                $tSQL .= " AND URLObj.FTUrlRefID IN($tBchCodeMulti)";
            }

            $tSQL .= ") Base) AS c WHERE c.rtRowID > $aRowLen[0] AND c.rtRowID <= $aRowLen[1]";
            $oQuery  = $this->db->query($tSQL);


            if ($oQuery->num_rows() > 0) {
                $aList      = $oQuery->result_array();
                $oFoundRow  = $this->FSoMCompSetConnectGetPageAll($tSearchList, $paData);
                $nFoundRow  = $oFoundRow[0]->counts;
                $nPageAll   = ceil($nFoundRow / $paData['nRow']); //หา Page All จำนวน Rec หาร จำนวนต่อหน้า
                $aResult    = array(
                    'raItems'       => $aList,
                    'rnAllRow'      => $nFoundRow,
                    'rnCurrentPage' => $paData['nPage'],
                    'rnAllPage'     => $nPageAll,
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                    'tSQL'          => $tSQL
                );
            } else {
                // if don't have data
                $aResult = array(
                    'rnAllRow'      => 0,
                    'rnCurrentPage' => $paData['nPage'],
                    "rnAllPage"     => 0,
                    'rtCode'        => '800',
                    'rtDesc'        => 'data not found'
                );
            }
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    //Functionality : Count CompSettingConnection
    //Parameters : function parameters
    //Creator :  19/08/2019 Witsarut
    //Return : data
    //Return Type : Array
    public function FSoMCompSetConnectGetPageAll($tSearchList, $paData)
    {
        try {
            $tCompCode       = $paData['FTUrlRefID'];
            $tSQL           =  " SELECT
                                    COUNT (URLObj.FNUrlID) AS counts
                                FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
                                WHERE 1=1
                                AND URLObj.FTUrlRefID = 'CENTER'
                                AND URLObj.FNUrlType IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17')
            ";
            if (isset($tSearchList) && !empty($tSearchList)) {
                if ($tSearchList == 'URL') {
                    $tSQL .= " AND (URLObj.FNUrlType = 1) ";
                } else if ($tSearchList == 'URL + Authorized') {
                    $tSQL .= " AND (URLObj.FNUrlType = 2) ";
                } else if ($tSearchList == 'URL + MQ') {
                    $tSQL .= " AND (URLObj.FNUrlType = 3) ";
                } else if ($tSearchList == 'API2PSMaster') {
                    $tSQL .= " AND (URLObj.FNUrlType = 4) ";
                } else if ($tSearchList == 'API2PSSale') {
                    $tSQL .= " AND (URLObj.FNUrlType = 5) ";
                } else if ($tSearchList == 'API2RTMaster') {
                    $tSQL .= " AND (URLObj.FNUrlType = 6) ";
                } else if ($tSearchList == 'API2RTSale') {
                    $tSQL .= " AND (URLObj.FNUrlType = 7) ";
                } else if ($tSearchList == 'API2FNWallet') {
                    $tSQL .= " AND (URLObj.FNUrlType = 8) ";
                } else if ($tSearchList == 'API2CNMember') {
                    $tSQL .= " AND (URLObj.FNUrlType = 9) ";
                } else if ($tSearchList == 'API2RDFace') {
                    $tSQL .= " AND (URLObj.FNUrlType = 10) ";
                } else if ($tSearchList == 'API2RDFaceRegis') {
                    $tSQL .= " AND (URLObj.FNUrlType = 11) ";
                } else if ($tSearchList == 'API2ARDoc') {
                    $tSQL .= " AND (URLObj.FNUrlType = 12) ";
                } else if ($tSearchList == 'MQMember') {
                    $tSQL .= " AND (URLObj.FNUrlType = 13) ";
                } else if ($tSearchList == 'API2PSStock') {
                    $tSQL .= " AND (URLObj.FNUrlType = 14) ";
                } else if ($tSearchList == 'API2RTStock') {
                    $tSQL .= " AND (URLObj.FNUrlType = 15) ";
                } else if ($tSearchList == 'MQAI') {
                    $tSQL .= " AND (URLObj.FNUrlType = 16) ";
                } else if ($tSearchList == 'MQ') {
                    $tSQL .= " AND (URLObj.FNUrlType = 17) ";
                } else {
                    $tSQL .= " AND (URLObj.FTUrlAddress   LIKE '%$tSearchList%')";
                }
            }

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->result();
            } else {
                return false;
            }
        } catch (Exception $Error) {
            echo $Error;
        }
    }


    //Functionality : Get Data CompSettingConnection
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompGetConCheckID($paData)
    {
        try {
            $tCompCode  = $paData['FTUrlRefID'];
            $tUrlID     = $paData['FNUrlID'];
            $tnLngID    = $paData['FNLngID'];

            $tSQL  = "SELECT
                        URLObj.FNUrlID,
                        URLObj.FTUrlRefID,
                        URLObj.FNUrlType,
                        URLObj.FTUrlTable,
                        URLObj.FTUrlKey,
                        URLObj.FTUrlAddress AS rtAddressUrlobj,
                        URLObj.FTUrlPort,
                        URLObj.FTUrlLogo,
                        URLObjlogin.FTUrlRefID,
                        URLObjlogin.FTUrlAddress AS rtAddressUrlobjlogin,
                        URLObjlogin.FTUolVhost,
                        URLObjlogin.FTUolUser,
                        URLObjlogin.FTUolPassword,
                        URLObjlogin.FTUolKey,
                        URLObjlogin.FTUolStaActive,
                        URLObjlogin.FTUolgRmk,
                        ImgObj.FTImgObj AS rtSetConImage
                     FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
                     LEFT JOIN TCNTUrlObjectLogin URLObjlogin ON URLObj.FTUrlAddress = URLObjlogin.FTUrlAddress AND URLObj.FTUrlRefID = URLObjlogin.FTUrlRefID
                     LEFT JOIN TCNMImgObj ImgObj ON ImgObj.FTImgRefID = URLObj.FTUrlRefID AND ImgObj.FTImgTable = 'TCNTUrlObject'
                     WHERE 1=1
                     AND URLObj.FNUrlID    = '$tUrlID'
                     AND URLObj.FNUrlType IN ('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17')";

            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $oDetail    = $oQuery->result();
                $aResult = array(
                    'raItems'   => $oDetail,
                    'rtCode'    => '1',
                    'rtDesc'    => 'success',
                );
            } else {
                //if data not found
                $aResult    = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }
            $jResult = json_encode($aResult);
            $aResult = json_decode($jResult, true);
            return $aResult;
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    //Functionality : Count Seq
    //Parameters : function parameters
    //Creator : 18/09/2018 Witsarut
    //Return : data
    //Return Type : Array
    public function FSnMCompCountSeq()
    {
        $tSQL = "SELECT COUNT(FNUrlSeq) AS counts
                FROM TCNTUrlObject";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array()["counts"];
        } else {
            return FALSE;
        }
    }

    //Functionality : check Data CheckUrlAddress
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConCheckUrlAddress($paData)
    {
        $tUrlAddress   = $paData['FTUrlAddress'];
        $tUrlRefID     = $paData['FTUrlRefID'];
        $tUrlType      = $paData['FNUrlType'];
        $tUrlKey      = $paData['FTUrlKey'];
        $tSQL  = "SELECT
                URLObj.FNUrlType
            FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
            WHERE 1=1
            AND URLObj.FTUrlRefID = '$tUrlRefID'
            AND URLObj.FNUrlType = '$tUrlType'
            AND URLObj.FTUrlKey = '$tUrlKey'
            AND URLObj.FTUrlAddress = '$tUrlAddress'
            ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }

    //Functionality : check Data CheckUrlAddressUpdate
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConCheckUrlAddressUpdate($paData)
    {
        $tUrlAddress   = $paData['FTUrlAddress'];
        $tUrlRefID     = $paData['FTUrlRefID'];
        $tUrlType      = $paData['FNUrlType'];
        $tUrlKey       = $paData['FTUrlKey'];
        $nUrlSeq        = $paData['FNUrlSeq'];

        $tSQL  = "  SELECT
                        URLObj.FNUrlType
                    FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
                    WHERE URLObj.FTUrlRefID = '$tUrlRefID'
                    AND URLObj.FNUrlType = '$tUrlType'
                    AND URLObj.FTUrlKey = '$tUrlKey'
                    AND URLObj.FNUrlSeq = '$nUrlSeq'
                    AND URLObj.FTUrlAddress = '$tUrlAddress'
            ";
        $oQuery = $this->db->query($tSQL);
        // echo $this->db->last_query();exit;
        if ($oQuery->num_rows() > 0) {
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail[0],
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //if data not found
            $aResult    = array(
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : check Data CheckUrlAddressUpdate
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConCheckUrlType($paData)
    {
        $tUrlRefID     = $paData['FTUrlRefID'];
        // $tUrlType      = $paData['FNUrlType'];

        $tSQL  = "SELECT
                        URLObj.FNUrlType
                    FROM [TCNTUrlObject] URLObj WITH(NOLOCK)
                    WHERE 1=1
                    AND URLObj.FTUrlRefID = '$tUrlRefID'
                    AND URLObj.FNUrlType = '9' OR URLObj.FNUrlType = '10' OR URLObj.FNUrlType = '11'
            ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $oDetail    = $oQuery->result();
            $aResult = array(
                'raItems'   => $oDetail,
                'rtCode'    => '1',
                'rtDesc'    => 'success',
            );
        } else {
            //if data not found
            $aResult    = array(
                'raItems'   => array(),
                'rtCode'    => '800',
                'rtDesc'    => 'data not found',
            );
        }
        $jResult = json_encode($aResult);
        $aResult = json_decode($jResult, true);
        return $aResult;
    }


    //Functionality : Function Add Update Master BchSettingConnection (TCNTUrlObjectLogin) type 2 MQMember
    //Parameters : function parameters
    //Creator : 13/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMCompSetConAddMasterUrlMQMember($paDataUrlObj, $aDataMQMain)
    {
        try {

            $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
            $this->db->set('FTUrlKey', $paDataUrlObj['FTUrlKey']);
            $this->db->set('FTUrlPort', $paDataUrlObj['FTUrlPort']);
            $this->db->where('FTUrlRefID', $paDataUrlObj['FTUrlRefID']);
            $this->db->where('FTUrlAddress', $paDataUrlObj['FTUrlAddressOld']);
            $this->db->where('FNUrlType', 13);
            $this->db->update('TCNTUrlObject');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResult = array(
                    'FTUrlRefID'    => $paDataUrlObj['FTUrlRefID'],
                    'FNUrlSeq'      => $paDataUrlObj['FNUrlSeq'],
                    'FNUrlType'     => $paDataUrlObj['FNUrlType'],
                    'FTUrlTable'    => $paDataUrlObj['FTUrlTable'],
                    'FTUrlKey'      => $paDataUrlObj['FTUrlKey'],
                    'FTUrlAddress'  => $paDataUrlObj['FTUrlAddress'],
                    'FTUrlPort'     => $paDataUrlObj['FTUrlPort'],
                    'FTUrlLogo'     => $paDataUrlObj['FTUrlLogo'],
                    'FDLastUpdOn'   => $paDataUrlObj['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataUrlObj['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataUrlObj['FDCreateOn'],
                    'FTCreateBy'    => $paDataUrlObj['FTCreateBy'],
                );
                //AddMaster
                $this->db->insert('TCNTUrlObject', $aResult);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            $this->db->set('FTUolPassword', $aDataMQMain['FTUolPassword']);
            $this->db->set('FTUrlAddress',  $aDataMQMain['FTUrlAddress']);
            $this->db->set('FTUolVhost', $aDataMQMain['FTUolVhost']);
            $this->db->set('FTUolUser', $aDataMQMain['FTUolUser']);
            $this->db->set('FTUolKey', $aDataMQMain['FTUolKey']);
            $this->db->set('FTUolStaActive', $aDataMQMain['FTUolStaActive']);
            $this->db->set('FTUolgRmk', $aDataMQMain['FTUolgRmk']);
            $this->db->where('FTUrlRefID', $aDataMQMain['FTUrlRefID']);
            $this->db->where('FTUrlAddress', $aDataMQMain['FTUrlAddressOld']);
            $this->db->where('FTUolVhost', $aDataMQMain['FTUolVhostOld']);
            $this->db->where('FTUolUser', $aDataMQMain['FTUolUserOld']);
            $this->db->update('TCNTUrlObjectLogin');

            // echo $this->db->last_query();
            // die();
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResulObjlogin = array(
                    'FTUrlRefID'        => $aDataMQMain['FTUrlRefID'],
                    'FTUrlAddress'      => $aDataMQMain['FTUrlAddress'],
                    'FTUolVhost'        => $aDataMQMain['FTUolVhost'],
                    'FTUolUser'         => $aDataMQMain['FTUolUser'],
                    'FTUolPassword'     => $aDataMQMain['FTUolPassword'],
                    'FTUolKey'          => $aDataMQMain['FTUolKey'],
                    'FTUolStaActive'    => $aDataMQMain['FTUolStaActive'],
                    'FTUolgRmk'         => $aDataMQMain['FTUolgRmk'],
                );

                $this->db->insert('TCNTUrlObjectLogin', $aResulObjlogin);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }



    //Functionality : Update SettingCon Type 1
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrl($paDataUrlObj)
    {

        //Update MasterUrlObj
        try {
            $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
            $this->db->set('FTUrlKey', $paDataUrlObj['FTUrlKey']);
            $this->db->set('FTUrlPort', $paDataUrlObj['FTUrlPort']);
            $this->db->where('FTUrlRefID', $paDataUrlObj['FTUrlRefID']);
            $this->db->where('FTUrlAddress', $paDataUrlObj['FTUrlAddressOld']);
            $this->db->update('TCNTUrlObject');

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResult = array(
                    'FTUrlRefID'    => $paDataUrlObj['FTUrlRefID'],
                    'FNUrlSeq'      => $paDataUrlObj['FNUrlSeq'],
                    'FNUrlType'     => $paDataUrlObj['FNUrlType'],
                    'FTUrlTable'    => $paDataUrlObj['FTUrlTable'],
                    'FTUrlKey'      => $paDataUrlObj['FTUrlKey'],
                    'FTUrlAddress'  => $paDataUrlObj['FTUrlAddress'],
                    'FTUrlPort'     => $paDataUrlObj['FTUrlPort'],
                    'FTUrlLogo'     => $paDataUrlObj['FTUrlLogo'],
                    'FDLastUpdOn'   => $paDataUrlObj['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataUrlObj['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataUrlObj['FDCreateOn'],
                    'FTCreateBy'    => $paDataUrlObj['FTCreateBy'],
                );
                //Add Master
                $this->db->insert('TCNTUrlObject', $aResult);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Function Add Update Master BchSettingConnection (TCNTUrlObjectLogin) type 2 Url+Author
    //Parameters : function parameters
    //Creator : 13/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrlAuthor($paDataUrlObj, $paDataUrlObjlogin)
    {
        try {
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResult = array(
                    'FTUrlRefID'    => $paDataUrlObj['FTUrlRefID'],
                    'FNUrlSeq'      => $paDataUrlObj['FNUrlSeq'],
                    'FNUrlType'     => $paDataUrlObj['FNUrlType'],
                    'FTUrlTable'    => $paDataUrlObj['FTUrlTable'],
                    'FTUrlKey'      => $paDataUrlObj['FTUrlKey'],
                    'FTUrlAddress'  => $paDataUrlObj['FTUrlAddress'],
                    'FTUrlPort'     => $paDataUrlObj['FTUrlPort'],
                    'FTUrlLogo'     => $paDataUrlObj['FTUrlLogo'],
                    'FDLastUpdOn'   => $paDataUrlObj['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataUrlObj['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataUrlObj['FDCreateOn'],
                    'FTCreateBy'    => $paDataUrlObj['FTCreateBy'],
                );
                //AddMaster
                $this->db->insert('TCNTUrlObject', $aResult);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            $this->db->set('FTUolPassword', $paDataUrlObjlogin['FTUolPassword']);
            $this->db->set('FTUolKey', $paDataUrlObjlogin['FTUolKey']);
            $this->db->set('FTUolStaActive', $paDataUrlObjlogin['FTUolStaActive']);
            $this->db->set('FTUolgRmk', $paDataUrlObjlogin['FTUolgRmk']);
            $this->db->where('FTUrlRefID', $paDataUrlObjlogin['FTUrlRefID']);
            $this->db->where('FTUrlAddress', $paDataUrlObjlogin['FTUrlAddress']);
            $this->db->where('FTUolVhost', $paDataUrlObjlogin['FTUolVhost']);
            $this->db->where('FTUolUser', $paDataUrlObjlogin['FTUolUser']);
            $this->db->update('TCNTUrlObjectLogin');
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResulObjlogin = array(
                    'FTUrlRefID'        => $paDataUrlObjlogin['FTUrlRefID'],
                    'FTUrlAddress'      => $paDataUrlObjlogin['FTUrlAddress'],
                    'FTUolVhost'        => $paDataUrlObjlogin['FTUolVhost'],
                    'FTUolUser'         => $paDataUrlObjlogin['FTUolUser'],
                    'FTUolPassword'     => $paDataUrlObjlogin['FTUolPassword'],
                    'FTUolKey'          => $paDataUrlObjlogin['FTUolKey'],
                    'FTUolStaActive'    => $paDataUrlObjlogin['FTUolStaActive'],
                    'FTUolgRmk'         => $paDataUrlObjlogin['FTUolgRmk'],
                );

                $this->db->insert('TCNTUrlObjectLogin', $aResulObjlogin);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }



    //Functionality : Function Add Update Master BchSettingConnection (TCNTUrlObjectLogin) type 2 Url+MQ
    //Parameters : function parameters
    //Creator : 13/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : Status Add Update Master
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrlMQ($paDataUrlObj, $paDataMQMain, $paDataMQDoc, $paDataMQSale, $paDataMQWallet)
    {
        try {
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                $aResult = array(
                    'FTUrlRefID'    => $paDataUrlObj['FTUrlRefID'],
                    'FNUrlSeq'      => $paDataUrlObj['FNUrlSeq'],
                    'FNUrlType'     => $paDataUrlObj['FNUrlType'],
                    'FTUrlTable'    => $paDataUrlObj['FTUrlTable'],
                    'FTUrlKey'      => $paDataUrlObj['FTUrlKey'],
                    'FTUrlAddress'  => $paDataUrlObj['FTUrlAddress'],
                    'FTUrlPort'     => $paDataUrlObj['FTUrlPort'],
                    'FTUrlLogo'     => $paDataUrlObj['FTUrlLogo'],
                    'FDLastUpdOn'   => $paDataUrlObj['FDLastUpdOn'],
                    'FTLastUpdBy'   => $paDataUrlObj['FTLastUpdBy'],
                    'FDCreateOn'    => $paDataUrlObj['FDCreateOn'],
                    'FTCreateBy'    => $paDataUrlObj['FTCreateBy'],
                );
                //AddMaster
                $this->db->insert('TCNTUrlObject', $aResult);
                if ($this->db->affected_rows() > 0) {
                    $aStatus = array(
                        'rtCode' => '1',
                        'rtDesc' => 'Add Success',
                    );
                } else {
                    // Error
                    $aStatus = array(
                        'rtCode' => '905',
                        'rtDesc' => 'Error Cannot Add/Edit Master.',
                    );
                }
            }

            // ----------- MQMain ---------- //
            $aResulMQMain = array(
                'FTUrlRefID'        => $paDataMQMain['FTUrlRefID'],
                'FTUrlAddress'      => $paDataMQMain['FTUrlAddress'],
                'FTUolVhost'        => $paDataMQMain['FTUolVhost'],
                'FTUolUser'         => $paDataMQMain['FTUolUser'],
                'FTUolPassword'     => $paDataMQMain['FTUolPassword'],
                'FTUolKey'          => $paDataMQMain['FTUolKey'],
                'FTUolStaActive'    => $paDataMQMain['FTUolStaActive'],
                'FTUolgRmk'         => $paDataMQMain['FTUolgRmk'],
            );

            $this->db->insert('TCNTUrlObjectLogin', $aResulMQMain);
            if ($this->db->affected_rows() > 0) {

                // ----------- MQDoc ---------- //
                $aResulMQDOc = array(
                    'FTUrlRefID'        => $paDataMQDoc['FTUrlRefID'],
                    'FTUrlAddress'      => $paDataMQDoc['FTUrlAddress'],
                    'FTUolVhost'        => $paDataMQDoc['FTUolVhost'],
                    'FTUolUser'         => $paDataMQDoc['FTUolUser'],
                    'FTUolPassword'     => $paDataMQDoc['FTUolPassword'],
                    'FTUolKey'          => $paDataMQDoc['FTUolKey'],
                    'FTUolStaActive'    => $paDataMQDoc['FTUolStaActive'],
                    'FTUolgRmk'         => $paDataMQDoc['FTUolgRmk'],
                );

                $this->db->insert('TCNTUrlObjectLogin', $aResulMQDOc);
                if ($this->db->affected_rows() > 0) {

                    // ----------- MQSale ---------- //
                    $aResulMQSale = array(
                        'FTUrlRefID'        => $paDataMQSale['FTUrlRefID'],
                        'FTUrlAddress'      => $paDataMQSale['FTUrlAddress'],
                        'FTUolVhost'        => $paDataMQSale['FTUolVhost'],
                        'FTUolUser'         => $paDataMQSale['FTUolUser'],
                        'FTUolPassword'     => $paDataMQSale['FTUolPassword'],
                        'FTUolKey'          => $paDataMQSale['FTUolKey'],
                        'FTUolStaActive'    => $paDataMQSale['FTUolStaActive'],
                        'FTUolgRmk'         => $paDataMQSale['FTUolgRmk'],
                    );

                    $this->db->insert('TCNTUrlObjectLogin', $aResulMQSale);
                    if ($this->db->affected_rows() > 0) {

                        // ----------- MQWallet ---------- //
                        $aResulMQWallet = array(
                            'FTUrlRefID'        => $paDataMQWallet['FTUrlRefID'],
                            'FTUrlAddress'      => $paDataMQWallet['FTUrlAddress'],
                            'FTUolVhost'        => $paDataMQWallet['FTUolVhost'],
                            'FTUolUser'         => $paDataMQWallet['FTUolUser'],
                            'FTUolPassword'     => $paDataMQWallet['FTUolPassword'],
                            'FTUolKey'          => $paDataMQWallet['FTUolKey'],
                            'FTUolStaActive'    => $paDataMQWallet['FTUolStaActive'],
                            'FTUolgRmk'         => $paDataMQWallet['FTUolgRmk'],
                        );

                        $this->db->insert('TCNTUrlObjectLogin', $aResulMQWallet);
                        $aStatus = array(
                            'rtCode' => '1',
                            'rtDesc' => 'Add Success',
                        );
                    }
                }
            }

            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }




    //Functionality : Update SettingCon Type 1
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrlUpdate($paDataUrlObj, $paOldKeyUrl)
    {
        try {
            $tUrlType  =  $paDataUrlObj['FNUrlType'];

            if ($tUrlType == '1' || $tUrlType == '4' || $tUrlType == '5' || $tUrlType == '6' || $tUrlType == '7' || $tUrlType == '8' || $tUrlType == '9' || $tUrlType == '10' || $tUrlType == '11') {
                // วิ่งไปลบ
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->delete('TCNTUrlObjectLogin');

                $this->db->set('FNUrlType', $paDataUrlObj['FNUrlType']);
                $this->db->set('FTUrlTable', $paDataUrlObj['FTUrlTable']);
                $this->db->set('FTUrlKey', $paDataUrlObj['FTUrlKey']);
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUrlPort', $paDataUrlObj['FTUrlPort']);
                $this->db->set('FTUrlLogo', $paDataUrlObj['FTUrlLogo']);
                $this->db->where('FNUrlID', $paDataUrlObj['FNUrlID']);
                // $this->db->where('FTUrlAddress' , $paOldKeyUrl);
                $this->db->update('TCNTUrlObject');
            }

            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                // Error
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }
            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            echo $Error;
        }
    }



    //Functionality : Update SettingCon Type 2
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrlAuthorUpdate($paDataUrlObj, $paDataUrlObjlogin, $paOldKeyUrl)
    {
        try {
            $tUrlType  =  $paDataUrlObj['FNUrlType'];
            $tWhereCondition = $paDataUrlObjlogin['tWhereCondition'];
            $aWhereCondition = explode(',', $tWhereCondition);
            if ($tUrlType == '2' || $tUrlType == '14' || $tUrlType == '15' || $tUrlType == '16'|| $tUrlType == '17') {
                $this->db->set('FNUrlType', $paDataUrlObj['FNUrlType']);
                $this->db->set('FTUrlTable', $paDataUrlObj['FTUrlTable']);
                $this->db->set('FTUrlKey', $paDataUrlObj['FTUrlKey']);
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUrlPort', $paDataUrlObj['FTUrlPort']);
                $this->db->set('FTUrlLogo', $paDataUrlObj['FTUrlLogo']);
                $this->db->where('FNUrlID', $paDataUrlObj['FNUrlID']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObject');
            }
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                // Error
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }


            if ($tUrlType == '2' || $tUrlType == '14' || $tUrlType == '15' || $tUrlType == '16' || $tUrlType == '17') {
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUolVhost', $paDataUrlObjlogin['FTUolVhost']);
                $this->db->set('FTUolUser', $paDataUrlObjlogin['FTUolUser']);
                $this->db->set('FTUolPassword', $paDataUrlObjlogin['FTUolPassword']);
                $this->db->set('FTUolKey', $paDataUrlObjlogin['FTUolKey']);
                $this->db->set('FTUolStaActive', $paDataUrlObjlogin['FTUolStaActive']);
                $this->db->set('FTUolgRmk', $paDataUrlObjlogin['FTUolgRmk']);
                $this->db->where('FTUrlRefID', $paDataUrlObjlogin['FTUrlRefID']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->where('FTUolVhost', $aWhereCondition[1]);
                $this->db->where('FTUolUser', $aWhereCondition[2]);
                $this->db->where('FTUolKey', $aWhereCondition[3]);
                $this->db->update('TCNTUrlObjectLogin');
            }
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                // Error
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }

            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }


    //Functionality : Update SettingCon Type 3
    //Parameters : function parameters
    //Creator : 17/09/2019 Witsarut (Bell)
    //Last Modified : -
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConAddUpdateMasterUrlMQUpdate($paDataUrlObj, $paDataMQMain, $paDataMQDoc, $paDataMQSale, $paDataMQWallet, $paOldKeyUrl)
    {
        try {

            $tUrlType  =  $paDataUrlObj['FNUrlType'];

            if ($tUrlType == '3') {

                $this->db->set('FNUrlType', $paDataUrlObj['FNUrlType']);
                $this->db->set('FTUrlTable', $paDataUrlObj['FTUrlTable']);
                $this->db->set('FTUrlKey', $paDataUrlObj['FTUrlKey']);
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUrlPort', $paDataUrlObj['FTUrlPort']);
                $this->db->set('FTUrlLogo', $paDataUrlObj['FTUrlLogo']);
                $this->db->where('FNUrlID',  $paDataUrlObj['FNUrlID']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObject');

                //MQ Main
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUolVhost', $paDataMQMain['FTUolVhost']);
                $this->db->set('FTUolUser', $paDataMQMain['FTUolUser']);
                $this->db->set('FTUolPassword', $paDataMQMain['FTUolPassword']);
                $this->db->set('FTUolKey', $paDataMQMain['FTUolKey']);
                $this->db->set('FTUolStaActive', $paDataMQMain['FTUolStaActive']);
                $this->db->set('FTUolgRmk', $paDataMQMain['FTUolgRmk']);
                $this->db->where('FTUrlRefID', $paDataMQMain['FTUrlRefID']);
                $this->db->where('FTUolKey', $paDataMQMain['FTUolKey']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObjectLogin');


                //MQ Doc
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUolVhost', $paDataMQDoc['FTUolVhost']);
                $this->db->set('FTUolUser', $paDataMQDoc['FTUolUser']);
                $this->db->set('FTUolPassword', $paDataMQDoc['FTUolPassword']);
                $this->db->set('FTUolKey', $paDataMQDoc['FTUolKey']);
                $this->db->set('FTUolStaActive', $paDataMQDoc['FTUolStaActive']);
                $this->db->set('FTUolgRmk', $paDataMQDoc['FTUolgRmk']);
                $this->db->where('FTUrlRefID', $paDataMQDoc['FTUrlRefID']);
                $this->db->where('FTUolKey', $paDataMQDoc['FTUolKey']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObjectLogin');

                //MQSale
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUolVhost', $paDataMQSale['FTUolVhost']);
                $this->db->set('FTUolUser', $paDataMQSale['FTUolUser']);
                $this->db->set('FTUolPassword', $paDataMQSale['FTUolPassword']);
                $this->db->set('FTUolKey', $paDataMQSale['FTUolKey']);
                $this->db->set('FTUolStaActive', $paDataMQSale['FTUolStaActive']);
                $this->db->set('FTUolgRmk', $paDataMQSale['FTUolgRmk']);
                $this->db->where('FTUrlRefID', $paDataMQSale['FTUrlRefID']);
                $this->db->where('FTUolKey', $paDataMQSale['FTUolKey']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObjectLogin');

                //MQ Report
                $this->db->set('FTUrlAddress', $paDataUrlObj['FTUrlAddress']);
                $this->db->set('FTUolVhost', $paDataMQWallet['FTUolVhost']);
                $this->db->set('FTUolUser', $paDataMQWallet['FTUolUser']);
                $this->db->set('FTUolPassword', $paDataMQWallet['FTUolPassword']);
                $this->db->set('FTUolKey', $paDataMQWallet['FTUolKey']);
                $this->db->set('FTUolStaActive', $paDataMQWallet['FTUolStaActive']);
                $this->db->set('FTUolgRmk', $paDataMQWallet['FTUolgRmk']);
                $this->db->where('FTUrlRefID', $paDataMQWallet['FTUrlRefID']);
                $this->db->where('FTUolKey', $paDataMQWallet['FTUolKey']);
                $this->db->where('FTUrlAddress', $paOldKeyUrl);
                $this->db->update('TCNTUrlObjectLogin');
            }
            if ($this->db->affected_rows() > 0) {
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Update Success',
                );
            } else {
                // Error
                $aStatus = array(
                    'rtCode' => '905',
                    'rtDesc' => 'Error Cannot Add/Edit Master.',
                );
            }

            $jStatus = json_encode($aStatus);
            $aStatus = json_decode($jStatus, true);
            return $aStatus;
        } catch (Exception $Error) {
            return $Error;
        }
    }




    //Functionality : Update Seq Number In Table TCNTUrlObject
    //Parameters : function parameters
    //Creator : 07/10/2019 Witsarut (Bell)
    //Return : data
    //Return Type : Array
    public function FSaMCompSetConUpdateSeqNumber()
    {
        $tSessionUserEdit = $this->session->userdata('tSesUsername');
        $tSQL = " UPDATE TBLUPD
                SET
                TBLUPD.FNUrlSeq         = TBLSEQ.nRowID,
                TBLUPD.FDLastUpdOn      = CONVERT(VARCHAR(19),GETDATE(),121),
                TBLUPD.FTLastUpdBy      = '$tSessionUserEdit'
            FROM TCNTUrlObject TBLUPD WITH(NOLOCK)
            INNER JOIN (
                SELECT
                ROW_NUMBER() OVER (PARTITION BY FTUrlRefID ORDER BY FTUrlRefID) nRowID , *
                FROM TCNTUrlObject WITH(NOLOCK)
            ) AS TBLSEQ
            ON 1=1
            AND TBLUPD.FNUrlID      = TBLSEQ.FNUrlID
            AND TBLUPD.FTUrlRefID   = TBLSEQ.FTUrlRefID
            AND TBLUPD.FNUrlSeq     = TBLSEQ.FNUrlSeq
        ";
        return $this->db->query($tSQL);
    }

    //Functionality : Get all row
    //Parameters : -
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSnMCompSettingConGetAllNumRow()
    {
        $tSQL = "SELECT COUNT(*) AS FNAllNumRow FROM TCNTUrlObject";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = $oQuery->row_array()["FNAllNumRow"];
        } else {
            $aResult = false;
        }
        return $aResult;
    }

    //ลบข้อมูลตารางหลักออก เพราะ ว่าเปลี่ยน type มันจะวิ่งไปเข้า insert อีกรอบ
    public function FSaMCompRemoveDataBecauseChangeType($ptOldType)
    {
        $this->db->where_in('FTUrlAddress', $ptOldType);
        $this->db->delete('TCNTUrlObject');

        $this->db->where_in('FTUrlAddress', $ptOldType);
        $this->db->delete('TCNTUrlObjectLogin');
    }

    //Functionality : Delete Setting Connection
    //Parameters : function parameters
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : response
    //Return Type : array
    public function FSnMCompSettingConDel($paData)
    {
        $tUrlType  =   $paData['FNUrlType'];

        switch ($tUrlType) {
            case '1':  // type 1 URL
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '2': // Type 2 URL+Author
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUolKey', ' ');
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '3': // Type 3 URL + MQ
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '4': // Type 4 API2PSMaster
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '5': // Type 5 API2PSSale
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '6': // Type 6 API2RTMaster
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '7': // Type 7 API2RTSale
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '8': // Type 8 API2FNWallet
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '9':  // type 1 URL
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '10': // Type 10 URL+Author
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '11': // Type 11
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '12': // Type 8 API2FNWallet
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');
                break;
            case '13': // Type 8 API2FNWallet
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where('FTUolKey', 'MQMember');
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '14': // Type 14 URL+Author
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUolKey', ' ');
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '15': // Type 15 URL+Author
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUolKey', ' ');
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '16': // Type 16 MQAI
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUolKey', 'MQAI');
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
            case '17': // Type 17 MQ
                $this->db->where_in('FNUrlID', $paData['FNUrlID']);
                $this->db->where_in('FNUrlType', $paData['FNUrlType']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObject');

                $this->db->where_in('FTUolKey', 'MQ');
                $this->db->where_in('FTUrlRefID', $paData['FTUrlRefID']);
                $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
                $this->db->delete('TCNTUrlObjectLogin');
                break;
        }
        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }
        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }


    //Functionality : Delete Mutiple Object
    //Parameters : function parameters
    //Creator : 19/09/2019 Witsarut
    //Return : data
    //Return Type : Arra
    function FSaMCompSetingConnDeleteMultiple($paData)
    {

        $this->db->where_in('FNUrlID', $paData['FNUrlID']);
        $this->db->delete('TCNTUrlObject');

        $this->db->where_in('FTUrlAddress', $paData['FTUrlAddress']);
        $this->db->delete('TCNTUrlObjectLogin');

        if ($this->db->affected_rows() > 0) {
            //Success
            $aStatus   = array(
                'rtCode' => '1',
                'rtDesc' => 'success',
            );
        } else {
            //Ploblem
            $aStatus = array(
                'rtCode' => '905',
                'rtDesc' => 'cannot Delete Item.',
            );
        }

        $jStatus = json_encode($aStatus);
        $aStatus = json_decode($jStatus, true);
        return $aStatus;
    }

    //Functionality : Get PathUrl
    //Parameters : -
    //Creator : 19/09/2019 Witsarut (Bell)
    //Return : array result from db
    //Return Type : array
    public function FSaMCompSetConAddUpdatePathUrl($paDataUrlObj)
    {
        $tUrlSeq = $paDataUrlObj['FNUrlSeq'];
        $tSQL = "UPDATE  TCNTUrlObject
                    SET TCNTUrlObject.FTUrlLogo = TCNMImgObj.FTImgObj
                FROM  TCNTUrlObject
                INNER JOIN  TCNMImgObj ON TCNTUrlObject.FNUrlSeq = TCNMImgObj.FTImgRefID
                WHERE TCNTUrlObject.FNUrlSeq = '$tUrlSeq' AND TCNMImgObj.FTImgTable = 'TCNTUrlObject'
                ";
        $oQuery = $this->db->query($tSQL);
    }


    //Functionality : UpdateOnBranch
    //Parameters : function parameters
    //Creator : 08/04/2020 Nale
    //Return : data
    //Return Type : Array
    public function FSxMCompSetConSetLastUpdateOnBranch($paData)
    {
        $this->db->set('FDLastUpdOn', $paData['FDLastUpdOn']);
        $this->db->set('FTLastUpdBy', $paData['FTLastUpdBy']);
        $this->db->where('FTCmpCode', $paData['FTCmpCode']);
        $this->db->update('TCNMComp');
    }
}
