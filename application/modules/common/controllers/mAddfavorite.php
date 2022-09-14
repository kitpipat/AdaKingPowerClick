<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class mAddfavorite extends CI_Model {

    public function FSaMGetDataMenu($ptMnuRoute){

        $nLangEdit   = $this->session->userdata("tLangEdit");

        $tSQL = "SELECT
                    MNU.FTMnuCode,
                    MNU.FTMnuCtlName,
                    MNU.FTMnuImgPath
                FROM [TSysMenuList] MNU
                LEFT JOIN [TSysMenuList_L] MNUL ON MNU.FTMnuCode = MNUL.FTMnuCode AND MNUL.FNLngID = $nLangEdit
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
    public function  FSaMAddfavoriteData($paDataAdd){
        try{
            //Add favorite Data
            if($this->db->affected_rows() > 0){
                $aStatus = array(
                    'rtCode' => '1',
                    'rtDesc' => 'Add Success',
                );
            }else{
                $aResult = array(
                    'FTMnuCode'         => $paDataAdd['aDatalist'][0]['FTMnuCode'],
                    'FTMnuRoute'        => $paDataAdd['FTMnuRoute'],
                    'FTMnuImgPath'      => $paDataAdd['aDatalist'][0]['FTMnuImgPath'],
                    'FTMfvOwner'        => $paDataAdd['FTMfvOwner']
                );
           
               $aDataChk = $this->db->where('FTMnuCode',$paDataAdd['aDatalist'][0]['FTMnuCode'])
               ->where('FTMfvOwner',$paDataAdd['FTMfvOwner'])
               ->get('TCNTMenuFavorite')->num_rows();

                if($aDataChk > 0){
                    $this->db->where('FTMnuCode',$paDataAdd['aDatalist'][0]['FTMnuCode'])
                    ->where('FTMfvOwner',$paDataAdd['FTMfvOwner'])
                    ->delete('TCNTMenuFavorite');
                    $tDisable = 1;

                }else{
                    //Add Master
                    $this->db->insert('TCNTMenuFavorite', $aResult);
                    $tDisable = 2;
                }
                if($this->db->affected_rows() > 0){
              
                }else{
                    // Error
                  
                }
            }
            return $tDisable;
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


  
}