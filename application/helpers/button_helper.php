<?php

//Gen Btn Save Master
// 17/05/2018 Krit(Copter)
function FCNaHBtnSaveActiveHTML($tMnuCtlName){

 $ci = &get_instance();
 $ci->load->library('session');

 //Controle Event
 $aAlwEvent = FCNaHCheckAlwFunc($tMnuCtlName);
 //Controle Event

 /* Btn Save */
 $tBtnSaveStaActive = $ci->session->userdata("tBtnSaveStaActive");
 $tStyleActive = '';
 switch ($tBtnSaveStaActive) {
  case 1 :
   $tStyleActive1 = "xWBtnSaveActive";
   $tStyleActive2 = "";
   $tStyleActive3 = "";
   break;
  case 2:
   $tStyleActive1 = "";
   $tStyleActive2 = "xWBtnSaveActive";
   $tStyleActive3 = "";
   break;
  case 3:
   $tStyleActive1 = "";
   $tStyleActive2 = "";
   $tStyleActive3 = "xWBtnSaveActive";
   break;
  default:
   $tStyleActive1 = "xWBtnSaveActive";
   $tStyleActive2 = "";
   $tStyleActive3 = "";
 }

 $vBtnSave = '<button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <span class="caret"></span>
         <span class="sr-only">Toggle Dropdown</span>
     </button>
     <ul class="dropdown-menu xWDrpDwnMenuMargLft">';
     if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1 && $aAlwEvent['tAutStaEdit'] != 0){
      $vBtnSave .= '<li  class="xWolibtnsave1 '.$tStyleActive1.'" onclick="JSvChangeBtnSaveAction(1)"><a href="#">'.language('common/main/main', 'tCMNSaveAndView').'</a></li>';
     }else{
      //ถ้าไม่มีสิทธิ Add จะเลือก 2 
      $ci->session->set_userdata ( "tBtnSaveStaActive", 2 );
      $tStyleActive2 = "xWBtnSaveActive";
     }
     if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1){
      $vBtnSave .= '<li  class="xWolibtnsave2 '.$tStyleActive2.'" onclick="JSvChangeBtnSaveAction(2)"><a href="#">'.language('common/main/main', 'tCMNSaveAndNew').'</a></li>';
     }
        $vBtnSave .='<li  class="xWolibtnsave3 '.$tStyleActive3.'" onclick="JSvChangeBtnSaveAction(3)"><a href="#">'.language('common/main/main', 'tCMNSaveAndBack').'</a></li>
           </ul>';
 return $vBtnSave;
}




function FCNaHCheckAlwFunc($tMnuCtlName){
  
   $ci = &get_instance();
   $ci->load->database();
   $ci->load->library('session');

   $tUsrRoleCode = $ci->session->userdata("tSesUsrRoleCode");
   $tUsrCode     = $ci->session->userdata("tSesUserCode");
//  $tSQLAuto = "SELECT USRMENU.FTRolCode,
//       USRMENU.FTGmnCode,
//       USRMENU.FTMnuParent,
//       USRMENU.FTMnuCode,
//       USRMENU.FTAutStaFull,
//       USRMENU.FTAutStaRead,
//       USRMENU.FTAutStaAdd,
//       USRMENU.FTAutStaEdit,
//       USRMENU.FTAutStaDelete,
//       USRMENU.FTAutStaCancel,
//       USRMENU.FTAutStaAppv,
//       USRMENU.FTAutStaPrint,
//       USRMENU.FTAutStaPrintMore,
//       USRMENU.FTAutStaFavorite
      
//      FROM TCNTUsrMenu USRMENU
//      LEFT JOIN TSysMenuList MENULIST ON USRMENU.FTGmnCode = MENULIST.FTGmnCode 
//             AND USRMENU.FTMnuParent = MENULIST.FTMnuParent 
//             AND USRMENU.FTMnuCode = MENULIST.FTMnuCode
      
//     WHERE MENULIST.FTMnuCtlName = '".trim($tMnuCtlName)."' AND USRMENU.FTRolCode = '".trim($tUsrRoleCode)."' ";

   $tSQLAuto = "SELECT
               A.FTMnuCode
               ,MAX(CAST(A.FTAutStaFull AS int)) AS FTAutStaFull
               ,MAX(CAST(A.FTAutStaRead AS int)) AS FTAutStaRead
               ,MAX(CAST(A.FTAutStaAdd AS int)) AS FTAutStaAdd
               ,MAX(CAST(A.FTAutStaEdit AS int)) AS FTAutStaEdit
               ,MAX(CAST(A.FTAutStaDelete AS int)) AS FTAutStaDelete
               ,MAX(CAST(A.FTAutStaCancel AS int)) AS FTAutStaCancel
               ,MAX(CAST(A.FTAutStaAppv AS int)) AS FTAutStaAppv
               ,MAX(CAST(A.FTAutStaPrint AS int)) AS FTAutStaPrint
               ,MAX(CAST(A.FTAutStaPrintMore AS int)) AS FTAutStaPrintMore
               ,MAX(CAST(A.FTAutStaFavorite AS int)) AS FTAutStaFavorite
               FROM (
               SELECT 
               USRMENU.*
               FROM TCNTUsrMenu USRMENU
               LEFT JOIN TSysMenuList MENULIST ON USRMENU.FTGmnCode = MENULIST.FTGmnCode 
               AND USRMENU.FTMnuParent = MENULIST.FTMnuParent 
               AND USRMENU.FTMnuCode = MENULIST.FTMnuCode
               LEFT JOIN TCNMUsrActRole ACTRole ON ACTRole.FTRolCode =  USRMENU.FTRolCode
               WHERE ACTRole.FTUsrCode = '".trim($tUsrCode)."'
               AND MENULIST.FTMnuCtlName = '".trim($tMnuCtlName)."'
               ) A GROUP BY A.FTMnuCode";
   $oQueryAuto = $ci->db->query($tSQLAuto);
   $aCheckAlwEvent = $oQueryAuto->result_array();
   $aAlwEvent = '';

   if(!empty($aCheckAlwEvent) && is_array($aCheckAlwEvent)){
      $aAlwEvent = array (
         'tAutStaFull'        => $aCheckAlwEvent[0]['FTAutStaFull'],
         'tAutStaRead'        => $aCheckAlwEvent[0]['FTAutStaRead'],
         'tAutStaAdd'         => $aCheckAlwEvent[0]['FTAutStaAdd'],
         'tAutStaEdit'        => $aCheckAlwEvent[0]['FTAutStaEdit'],
         'tAutStaDelete'      => $aCheckAlwEvent[0]['FTAutStaDelete'],
         'tAutStaCancel'      => $aCheckAlwEvent[0]['FTAutStaCancel'],
         'tAutStaAppv'        => $aCheckAlwEvent[0]['FTAutStaAppv'],
         'tAutStaPrint'       => $aCheckAlwEvent[0]['FTAutStaPrint'],
         'tAutStaPrintMore'   => $aCheckAlwEvent[0]['FTAutStaPrintMore'],
         'tAutStaFavorite'    => $aCheckAlwEvent[0]['FTAutStaFavorite'],
      );
   }else{
      $aAlwEvent = array (
         'tAutStaFull'        => 0,
         'tAutStaRead'        => 0,
         'tAutStaAdd'         => 0,
         'tAutStaEdit'        => 0,
         'tAutStaDelete'      => 0,
         'tAutStaCancel'      => 0,
         'tAutStaAppv'        => 0,
         'tAutStaPrint'       => 0,
         'tAutStaPrintMore'   => 0,
         'tAutStaFavorite'    => 0,
      );
   }
   return $aAlwEvent;
}