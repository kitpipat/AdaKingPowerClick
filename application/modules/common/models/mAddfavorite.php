<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAddfavorite extends CI_Model {

    public function FSaMGetDataMenu($ptMnuRoute){

        $nLangEdit   = $this->session->userdata("tLangEdit");

        $tSQL = "SELECT
                    MNU.FTMnuCode,
                    MNU.FTMnuCtlName,
                    MNU.FTMnuImgPath,
                    MNUL.FTMnuName,
                    FAV.FTMfvName
                FROM [TSysMenuList] MNU WITH(NOLOCK)
                LEFT JOIN [TSysMenuList_L] MNUL WITH(NOLOCK) ON MNU.FTMnuCode = MNUL.FTMnuCode AND MNUL.FNLngID = $nLangEdit
                LEFT JOIN TCNTMenuFavorite FAV WITH(NOLOCK) ON MNU.FTMnuCode = FAV.FTMnuCode
                WHERE 1=1
                AND MNU.FTMnuCtlName  = '$ptMnuRoute'";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0){
            $oDetail = $oQuery->result_array();
        }else{
            $oDetail = '';
        }
        return $oDetail;
        }


    //Functionality : Add favoriteData
    //Parameters : function parameters
    //Creator : 13/10/2020 Witsarut(Bell)
    //Return : Array Stutus Add Update
    //Return Type : Array
    public function  FSaMAddfavoriteData($paDataAdd,$tTypeEvent){
        try{
            //Add favorite Data
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success',
                );
            }else{

                $nSeq = $this->db->get('TCNTMenuFavorite')->num_rows();

                $aResult = array(
                    'FTMnuCode'         => $paDataAdd['aDatalist'][0]['FTMnuCode'],
                    'FTMnuRoute'        => $paDataAdd['FTMnuRoute'],
                    'FTMnuImgPath'      => $paDataAdd['aDatalist'][0]['FTMnuImgPath'],
                    'FTMfvOwner'        => $paDataAdd['FTMfvOwner'],
                    'FTMfvName'         => $paDataAdd['FTMfvName']
                );

                $aDataChk = $this->db->where('FTMnuCode',$paDataAdd['aDatalist'][0]['FTMnuCode'])
                ->where('FTMfvOwner',$paDataAdd['FTMfvOwner'])
                ->get('TCNTMenuFavorite')->num_rows();

                if($aDataChk > 0){
                    //Update Favarite
                    $this->db->set('FTMfvName' , $paDataAdd['FTMfvName']);
                    $this->db->where('FTMnuCode',$paDataAdd['aDatalist'][0]['FTMnuCode']);
                    $this->db->where('FTMfvOwner',$paDataAdd['FTMfvOwner']);
                    $this->db->update('TCNTMenuFavorite');
                }else{
                    // Add Master
                    $this->db->insert('TCNTMenuFavorite', $aResult);
                }
            }
        }catch(Exception $Error){
            echo $Error;
        }

    }

    // function : ChkStaDisable 1 or 2
    // create by witsarut 13/01/2010
    public function FSaMCheckStaDisable($ptChkSta){

        try{
            $tChkMnuCode    = $ptChkSta['aDatalist'][0]['FTMnuCode'];
            $tChkRoute      = $ptChkSta['FTMnuRoute'];
            $tChkUsrlog     = $ptChkSta['FTMfvOwner'];

            $tSQL  = "SELECT
                        Mnu.FTMnuCode
                    FROM [TCNTMenuFavorite] Mnu WITH(NOLOCK)
                    WHERE 1=1
                    AND Mnu.FTMnuCode   = '$tChkMnuCode'
                    AND Mnu.FTMfvOwner = '$tChkUsrlog'
                    ";
            $oQuery = $this->db->query($tSQL);
            if($oQuery->num_rows() > 0){
                $rtDisable = 2;
            }else{
                $rtDisable = 1;
            }

            return $rtDisable;
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // function : TypeRemove
    // create by witsarut 13/01/2010
    public function FSaMRemoveMenu($paDataAdd,$ptTypeReMove){
        try{
            $aResult = array(
                'FTMnuCode'         => $paDataAdd['aDatalist'][0]['FTMnuCode'],
                'FTMnuRoute'        => $paDataAdd['FTMnuRoute'],
                'FTMnuImgPath'      => $paDataAdd['aDatalist'][0]['FTMnuImgPath'],
                'FTMfvOwner'        => $paDataAdd['FTMfvOwner'],
                'FTMfvName'         => $paDataAdd['FTMfvName'],
            );

            $this->db->where('FTMnuCode',$paDataAdd['aDatalist'][0]['FTMnuCode'])
            ->where('FTMfvOwner',$paDataAdd['FTMfvOwner'])
            ->delete('TCNTMenuFavorite');
        }catch(Exception $Error){
            echo $Error;
        }


    }

}
