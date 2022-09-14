

<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class mFavorites extends CI_Model {



//   function FSaFavGetdataList($paData){
         
//     // print_r($paData);
//     // print_r($pnLangID);

//   $aOwner = $paData;
//    $tSQl = " SELECT  

//             Fav.FTMfvID  AS FavID, 
//             Fav.FTMnuCode AS FavMnuCode,
//             Fav.FTMnuRoute AS FavMnuRoute,
//             Fav.FTMnuImgPath AS FavMnuImgPath,
//             Fav.FTMfvOwner AS FavMMfvOwner,
//             Fav.FTMfvName AS FavMfvName
//              FROM TCNTMenuFavorite Fav
            
//               WHERE Fav.FTMfvOwner = '$aOwner' 
             
//              ORDER BY Fav.FTMfvID  ASC";
             
           
//     //   echo $tSQl ;
//     //   exit;    

//     $oQuery = $this->db->query($tSQl);
//     return $oQuery->result(); 

// }
    /*
    //Functionality : Get data 
    //Parameters : function parameters
    //Creator :  10/1/2020 petch
    //Return : data
    //Return Type : array
    */
     function FSaFavGetdataList($paData){
         
        // print_r($paData);
        // print_r($pnLangID);
      
      $aOwner = $paData;
       $tSQl = " SELECT  

                Fav.FTMfvID  AS FavID, 
                Fav.FTMnuCode AS FavMnuCode,
                Fav.FTMnuRoute AS FavMnuRoute,
                Fav.FTMnuImgPath AS FavMnuImgPath,
                Fav.FTMfvOwner AS FavMMfvOwner ,
                Fav.FTMfvName AS FavMfvName
                 FROM TCNTMenuFavorite Fav
               
                  WHERE Fav.FTMfvOwner = '$aOwner' 
                 
                 ORDER BY Fav.FTMfvID  ASC";
                 
               
        //   echo $tSQl ;
        //   exit;    
    
        $oQuery = $this->db->query($tSQl);
        return $oQuery->result(); 
    
    }

      /*
    * Functionality :  Del fav
    * Parameters :  function parameters 
    * Creator :10/1/2020 petch
    * Last Modified : -
    * Return : -
    * Return Type : -
    */
    public function FSxFavDel($pnCode) { 
        $this->db->where('FTMfvID', $pnCode);
        $this->db->delete("TCNTMenuFavorite");
       } 

}