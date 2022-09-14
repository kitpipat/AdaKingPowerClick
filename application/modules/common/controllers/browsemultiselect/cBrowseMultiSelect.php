<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cBrowseMultiSelect extends MX_Controller {
   
    public function __construct() {
        parent::__construct();
    }    

    public function index(){
        $tSQLMultiBrowse    = "";
        $aOptionMultiBrowse = $this->input->post('paOptions');
        $tOptionName        = $this->input->post('ptOptionsName');
        if($aOptionMultiBrowse != '' || $aOptionMultiBrowse != 'undefined'){            
            // ============================== Set Parame Defult ==============================
            // โฟลเดอร์ Patch ที่ดึงภาษา Title
            $tTitleLangPath     = $aOptionMultiBrowse['Title'][0];

            // Key Name ภาษา Title
            $tTitleLangKey      = $aOptionMultiBrowse['Title'][1];

            // ชื่อข้อมูลที่จะทำการ Browse
            $tTitleHeader       = language($tTitleLangPath,$tTitleLangKey);

            // Master Table ที่จะทำการ Browse
            $tMasterTable       = $aOptionMultiBrowse['Table']['Master'];

            // Master PK
            $tMasterPK          = $aOptionMultiBrowse['Table']['PK'];

            // Master Primery Key ที่ใช้ในการเป็น Center
            $tMasterPKCenter    = $tMasterTable.".".$tMasterPK;

            // Check เงื่อนไขการ Union
            if(isset($aOptionMultiBrowse['Union']) && !empty($aOptionMultiBrowse['Union'])){
                // Foreach Data Union
                $tTextMainSQL   = "";
                $tTextUnionSQL  = "";
                $aOptionUnion   = $aOptionMultiBrowse['Union'];
                foreach($aOptionUnion AS $nKey => $aDataUnion){
                    $tTypeUnion         = $aDataUnion['Type'];
                    $tMasterTblUnion    = $aDataUnion['Table']['Master'];
                    $tMasterPKUnion     = $aDataUnion['Table']['PK'];

                    // Set Union Column Select  Options
                    $tUnionSeleted      = "";
                    if(isset($aDataUnion['GrideView'])){
                        if(isset($aDataUnion['GrideView']['DataColumns'])){
                            $aSelectUnion   = $aDataUnion['GrideView']['DataColumns'];
                            if(is_array($aSelectUnion)){
                                $tUnionSeleted  = implode(',',$aSelectUnion);
                            }
                        }
                    }

                    // Set Union Column Join From Options
                    $tUnionJoinTable    = "";
                    if(isset($aDataUnion['Join']['Table'])){
                        for($nUnionJoin = 0; $nUnionJoin < FCNnHSizeOf($aDataUnion['Join']['Table']); $nUnionJoin++) {
                            if(isset($aDataUnion['Join']['SpecialJoin'])){
                                $tUnionJoinTable    .= " ".$aDataUnion['Join']['SpecialJoin'][$nUnionJoin]." ".$aDataUnion['Join']['Table'][$nUnionJoin]." WITH(NOLOCK) ON ".$aDataUnion['Join']['On'][$nUnionJoin]." ";
                            }else{
                                $tUnionJoinTable    .= " LEFT JOIN ".$aDataUnion['Join']['Table'][$nUnionJoin]." WITH(NOLOCK) ON ".$aDataUnion['Join']['On'][$nUnionJoin]." ";
                            }
                        }
                    }

                    // Set Union Data Where From Option
                    $tUnionWhereCondtion    = "";
                    if(isset($aDataUnion['Where'])){
                        if($aDataUnion['Where']['Condition']){
                            for ($nUnionWhere = 0; $nUnionWhere < FCNnHSizeOf($aDataUnion['Where']['Condition']); $nUnionWhere++) {
                                $tUnionWhereCondtion .= " " . $aDataUnion['Where']['Condition'][$nUnionWhere];
                            }
                        }
                    }

                    // ================================ Set Text SQL Union ================================
                    $tTextUnionSQL  .= " ".$tTypeUnion;
                    $tTextUnionSQL  .= " SELECT DISTINCT ";
                    $tTextUnionSQL  .= $tUnionSeleted;
                    if( !empty($tMasterTblUnion) ){
                        $tTextUnionSQL  .= " FROM ".$tMasterTblUnion;
                    }
                    $tTextUnionSQL  .= $tUnionJoinTable;
                    $tTextUnionSQL  .= " WHERE 1=1 ";
                    $tTextUnionSQL  .= $tUnionWhereCondtion;
                }

                // Set Column Select From Options
                $tColumnsSelect = "";
                if(isset($aOptionMultiBrowse['GrideView'])){
                    if(isset($aOptionMultiBrowse['GrideView']['DataColumns'])){
                        $aColumnsSelect = $aOptionMultiBrowse['GrideView']['DataColumns'];
                        if(is_array($aColumnsSelect)){
                            $tColumnsSelect = implode(',',$aColumnsSelect);
                        }
                    }
                }

                // Set Column JOIN From Options
                $tTextJoinBrowse    = "";
                if(isset($aOptionMultiBrowse['Join']['Table'])){
                    for($nJoin = 0; $nJoin < FCNnHSizeOf($aOptionMultiBrowse['Join']['Table']); $nJoin++) {
                        if(isset($aOptionMultiBrowse['Join']['SpecialJoin'])){
                            $tTextJoinBrowse    .= " ".$aOptionMultiBrowse['Join']['SpecialJoin'][$nJoin]." ".$aOptionMultiBrowse['Join']['Table'][$nJoin]." WITH(NOLOCK) ON ".$aOptionMultiBrowse['Join']['On'][$nJoin]." ";
                        }else{
                            $tTextJoinBrowse    .= " LEFT JOIN " . $aOptionMultiBrowse['Join']['Table'][$nJoin] . " WITH(NOLOCK) ON " . $aOptionMultiBrowse['Join']['On'][$nJoin] . " ";
                        }
                    }
                }

                // Set Data Where From Option
                $tWhereCondtion = "";
                if(isset($aOptionMultiBrowse['Where'])){
                    if($aOptionMultiBrowse['Where']['Condition']){
                        for ($nWhere = 0; $nWhere < FCNnHSizeOf($aOptionMultiBrowse['Where']['Condition']); $nWhere++) {
                            $tWhereCondtion .= " " . $aOptionMultiBrowse['Where']['Condition'][$nWhere];
                        }
                    }
                }

                // ========================== Set Text Main SQL  ==========================
                $tTextMainSQL   .= " SELECT DISTINCT ";
                $tTextMainSQL   .= $tColumnsSelect;
                if( !empty($tMasterTable) ){
                    $tTextMainSQL   .= " FROM ".$tMasterTable;
                }
                $tTextMainSQL   .= $tTextJoinBrowse;
                $tTextMainSQL   .= " WHERE 1=1 ";
                $tTextMainSQL   .= $tWhereCondtion;
                
                // Data Order By Option
                $tDataOrderBy   = "";
                if(isset($aOptionMultiBrowse['GrideView'])){
                    if(isset($aOptionMultiBrowse['GrideView']['OrderBy']) && !empty($aOptionMultiBrowse['GrideView']['OrderBy'])){
                        $tOrderBy           = implode(',',$aOptionMultiBrowse['GrideView']['OrderBy']);
                        $aExplodeOrderBy    = explode(',',$tOrderBy);
                        $aDataOrderBy       = [];
                        foreach($aExplodeOrderBy AS $nKeyOrderBy => $tValueOrderBy){
                            $aExplodeDosOrderBy = explode('.',$tValueOrderBy);
                            array_push($aDataOrderBy,"DATAALL.".$aExplodeDosOrderBy[1]);
                        }
                        $tDataOrderBy   = implode(',',$aDataOrderBy);
                    }else{
                        $tDataOrderBy   = "DATAALL.".$tMasterPK;
                    }
                }
                
                // Data Selet Final Text Select
                $tFinalColumnsSelect    = "";
                if(isset($aOptionMultiBrowse['GrideView'])){
                    if(isset($aOptionMultiBrowse['GrideView']['DataColumns']) && !empty($aOptionMultiBrowse['GrideView']['DataColumns'])){
                        $tColumnSlt         = implode(',',$aOptionMultiBrowse['GrideView']['DataColumns']);
                        $aExplodeColumnSlt  = explode(',',$tColumnSlt);
                        $aDataColumnslt     = [];
                        foreach($aExplodeColumnSlt AS $nKeyColumnSlt => $tValueColumnSlt){
                            $aExplodeDosColumnSlt   = explode('.',$tValueColumnSlt);
                            array_push($aDataColumnslt,"DATAALL.".$aExplodeDosColumnSlt[1]);
                        }
                        $tFinalColumnsSelect    = implode(',',$aDataColumnslt);
                    }else{
                        $tFinalColumnsSelect    = "DATAALL.*";
                    }
                }
                
                // Filter Gird Search Table
                $tFilterSearch      = $this->input->post('ptFilterSearch');
                $tWhereFilterSearch = "";
                if(isset($tFilterSearch) && !empty($tFilterSearch)){
                    if(isset($aOptionMultiBrowse['GrideView']['DataColumns']) && !empty($aOptionMultiBrowse['GrideView']['DataColumns'])){
                        $tColumn        = implode(',',$aOptionMultiBrowse['GrideView']['DataColumns']);
                        $aExplodeColumn = explode(',',$tColumn);
                        $aDataColumn    = [];
                        foreach($aExplodeColumn AS $nKeyColumn => $tValueColumn){
                            $aExplodeDosColumn  = explode('.',$tValueColumn);
                            if($nKeyColumn == 0){
                                $tWhereFilterSearch .= " AND ( DATAALL.".$aExplodeDosColumn['1']." COLLATE THAI_BIN LIKE '%$tFilterSearch%' ";
                            }else{
                                $tWhereFilterSearch .=  "  OR DATAALL.".$aExplodeDosColumn['1']." COLLATE THAI_BIN LIKE '%$tFilterSearch%' ";
                            }
                        }
                        $tWhereFilterSearch .= " ) ";
                    }
                }

                // ========================== Set Text SQL  ==========================
                $tSQLMultiBrowse    .= " SELECT DISTINCT";
                $tSQLMultiBrowse    .= " ROW_NUMBER() OVER(ORDER BY ".$tDataOrderBy.") AS FNRowID, ";
                $tSQLMultiBrowse    .= $tFinalColumnsSelect;
                $tSQLMultiBrowse    .= " FROM ( ";
                $tSQLMultiBrowse    .= $tTextMainSQL;
                $tSQLMultiBrowse    .= $tTextUnionSQL;
                $tSQLMultiBrowse    .= " ) DATAALL ";
                $tSQLMultiBrowse    .= $tWhereFilterSearch;
                
            }else{
                // Data Order By Option
                $aTextOrderBy   = $aOptionMultiBrowse['GrideView']['OrderBy'];
                $tTextOrderBy   = "";
                if(empty($aTextOrderBy) || !isset($aTextOrderBy)){
                    $tTextOrderBy   = "$tMasterPKCenter ASC";
                }else{
                    $tTextOrderBy   = implode(',',$aTextOrderBy);
                }

                // Set Column Select From Options
                $tColumnsSelect     = "";
                if (isset($aOptionMultiBrowse['GrideView'])){
                    if (isset($aOptionMultiBrowse['GrideView']['DataColumns'])){
                        $aColumnsSelect = $aOptionMultiBrowse['GrideView']['DataColumns'];
                        if(is_array($aColumnsSelect)){
                            $tColumnsSelect = implode(',',$aColumnsSelect);
                        }
                    }
                }

                // Set Column JOIN From Options
                $tTextJoinBrowse    = "";
                if(isset($aOptionMultiBrowse['Join']['Table'])){
                    for($j = 0; $j < FCNnHSizeOf($aOptionMultiBrowse['Join']['Table']); $j++) {
                        if(isset($aOptionMultiBrowse['Join']['SpecialJoin'])){
                            $tTextJoinBrowse .= " ".$aOptionMultiBrowse['Join']['SpecialJoin'][$j] ." ". $aOptionMultiBrowse['Join']['Table'][$j] . " ON " . $aOptionMultiBrowse['Join']['On'][$j] . " ";
                        }else{
                            $tTextJoinBrowse .= " LEFT JOIN " . $aOptionMultiBrowse['Join']['Table'][$j] . " ON " . $aOptionMultiBrowse['Join']['On'][$j] . " ";
                        }
                    }
                }

                // Set Data Where From Option
                $tWhereCondtion = "";
                if(isset($aOptionMultiBrowse['Where'])){
                    if($aOptionMultiBrowse['Where']['Condition']){
                        for ($w = 0; $w < FCNnHSizeOf($aOptionMultiBrowse['Where']['Condition']); $w++) {
                            $tWhereCondtion .= " " . $aOptionMultiBrowse['Where']['Condition'][$w];
                        }
                    }
                }

                // Filter Data From Selector Browse Input Browse
                $tWhereFilter   = "";
                if(isset($aOptionMultiBrowse['Filter'])){
                    $tDataFilter    = $this->input->post('ptFilter');
                    if($tDataFilter != ''){
                        $tTableFilter   = $aOptionMultiBrowse['Filter']['Table'] . "." . $aOptionMultiBrowse['Filter']['Key'];
                        $tWhereFilter   = " AND $tTableFilter = '" . $tDataFilter . "'";
                    }
                }

                // Filter Gird Search Table
                $tFilterSearch  = $this->input->post('ptFilterSearch');
                $tWhereFilterSearch = "";
                if(isset($tFilterSearch)){
                    if($tFilterSearch != ''){
                        $tCheckFieldPK  = explode(".", $tMasterPKCenter);
                        $tCheckFieldPK2 = substr($tCheckFieldPK[1], 0, 2);
                        if($tCheckFieldPK2 == 'FN'){
                            $tWhereFilterSearch .= " AND ( $tMasterPKCenter LIKE '%$tFilterSearch%' ";
                        }else if($tCheckFieldPK[1] == 'FTRptFltCode'){
                            $tWhereFilterSearch .= " AND ( $tMasterPKCenter LIKE '%$tFilterSearch%' ";
                        }else{
                            $tWhereFilterSearch .= " AND ( $tMasterPKCenter COLLATE THAI_BIN LIKE '%$tFilterSearch%' ";
                        }
                        for ($fc = 0; $fc < FCNnHSizeOf($aOptionMultiBrowse['GrideView']['DataColumns']); $fc++){
                            $tFilterCol = $aOptionMultiBrowse['GrideView']['DataColumns'][$fc];
                            $tCheckField1 = explode(".", $tFilterCol);
                            $tCheckField2 = substr($tCheckField1[1], 0, 2);

                            if ($tCheckField2 == 'FN') {
                                $tWhereFilterSearch .= "  OR $tFilterCol LIKE '%$tFilterSearch%' ";
                            } else if($tCheckField1[1] == 'FTRptFltCode') {
                                $tWhereFilterSearch .= "  OR $tFilterCol LIKE '%$tFilterSearch%' ";
                            }else{
                                $tWhereFilterSearch .= "  OR $tFilterCol COLLATE THAI_BIN LIKE '%$tFilterSearch%' ";
                            }

                        }
                        $tWhereFilterSearch .= " )";
                    }
                }

                // Filter Where Not In From Option
                $tWhereNotIn    = "";
                if(isset($aOptionMultiBrowse['NotIn'])){
                    $tDataNotIn = $this->input->post('ptNotIn');
                    if($tDataNotIn != ''){
                        if($aOptionMultiBrowse['NotIn']['Table'] != '' && $aOptionMultiBrowse['NotIn']['Key'] != ''){
                            $tDataNotIn      = "Result".".".$aOptionMultiBrowse['NotIn']['Key'];
                            $tWhereNotIn    .= " AND $tTableFilter NOT IN ('".$tDataNotIn."')";
                        }
                    }
                }

                if(isset($aOptionMultiBrowse['Special'])){
                    if($aOptionMultiBrowse['Special'] == 'SO'){
                        $tConcatSQL         = "SELECT DISTINCT DENSE_RANK() OVER(ORDER BY $tTextOrderBy) AS FNRowID," ;
                    }
                }else{
                    $tConcatSQL    = " SELECT ROW_NUMBER() OVER(ORDER BY $tTextOrderBy) AS FNRowID,";
                }


                // ================================ Set Text SQL ================================
                $tSQLMultiBrowse    .=  " SELECT TOP 15000 DATACN.* FROM (";
                $tSQLMultiBrowse    .=  $tConcatSQL;
                $tSQLMultiBrowse    .=  $tColumnsSelect;
                if( !empty($tMasterTable) ){
                    $tSQLMultiBrowse    .=  " FROM $tMasterTable";
                }
                $tSQLMultiBrowse    .=  $tTextJoinBrowse;
                $tSQLMultiBrowse    .=  " WHERE 1=1";
                $tSQLMultiBrowse    .=  $tWhereCondtion;
                $tSQLMultiBrowse    .=  $tWhereFilter;
                $tSQLMultiBrowse    .=  $tWhereFilterSearch;
                $tSQLMultiBrowse    .=  " ) AS DATACN ";
                $tSQLMultiBrowse    .=  $tWhereNotIn;
            }

            $oQuery = $this->db->query($tSQLMultiBrowse);
            
            // Check Callback Value
            $tOldCallBackVal    = $this->input->post('ptCallVal');
            if (isset($tOldCallBackVal) && !empty($tOldCallBackVal)){
                $tOldCallBackVal    = $tOldCallBackVal;
            }else{
                $tOldCallBackVal    = '';
            }

            // Check Callback Taxt
            $tOldCallBackText   = $this->input->post('ptCallText');
            if (isset($tOldCallBackText) && !empty($tOldCallBackText)){
                $tOldCallBackText   = $tOldCallBackText;
            }else{
                $tOldCallBackText   = '';
            }

            // Check Callback Status All
            $tOldCallBackStaAll = $this->input->post('ptCallStaAll');
            if (isset($tOldCallBackStaAll) && !empty($tOldCallBackStaAll)){
                $tOldCallBackStaAll   = $tOldCallBackStaAll;
            }else{
                $tOldCallBackStaAll   = '';
            }

            // Check Data Table Heard Gird In Option
            $tHtmlTableHeard    = "";
            for($c = 0; $c < FCNnHSizeOf($aOptionMultiBrowse['GrideView']['DataColumns']); $c++){
                if(isset($aOptionMultiBrowse['GrideView']['ColumnsSize'][$c])) {
                    $nColumnSizeHeard   = $aOptionMultiBrowse['GrideView']['ColumnsSize'][$c];
                } else {
                    $nColumnSizeHeard   = '';
                }

                // ที่อยู่ Lang Path หัวตาราง
                $tlangPathTableHeard    = $aOptionMultiBrowse['GrideView']['ColumnPathLang'];

                // Loop Check Key Table Lang Heard
                if(isset($aOptionMultiBrowse['GrideView']['ColumnKeyLang'][$c])){
                    $tlangKeyTableHeard = $aOptionMultiBrowse['GrideView']['ColumnKeyLang'][$c];
                }else{
                    $tlangKeyTableHeard = "N/A";
                }
                
                if(isset($aOptionMultiBrowse['GrideView']['DisabledColumns'])){
                    if($this->JCNbCheckColDisabled($c,$aOptionMultiBrowse['GrideView']['DisabledColumns']) == false){
                        $tHtmlTableHeard    .= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSizeHeard'>".language($tlangPathTableHeard,$tlangKeyTableHeard)."</th>";
                    }
                }else{
                    $tHtmlTableHeard        .= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSizeHeard'>".language($tlangPathTableHeard,$tlangKeyTableHeard)."</th>";
                }
            }

            // Check Data Table Body
            $tHtmlTableData         = "";
            if($oQuery->num_rows() > 0){
                $aDataTableMulti    = $oQuery->result();
                $tDataRowActive     = '';
                foreach($aDataTableMulti as $nKey => $aValue){
                    // Check Data Callback Option Value
                    $tDataReturnValue       = "";
                    if(isset($aOptionMultiBrowse['CallBack']['Value'])){
                        $aCallBackValueKey  = explode('.', $aOptionMultiBrowse['CallBack']['Value'][1]);
                        $tCallBackValueKey  = $aCallBackValueKey[1];
                        $tDataReturnValue   = $aValue->$tCallBackValueKey;
                    }else{
                        $tDataReturnValue   = "";
                    }

                    // Check Data Callback Option Name
                    $tDataReturnText        = "";
                    if(isset($aOptionMultiBrowse['CallBack']['Text'])){
                        $aCallBackTextKey   = explode('.', $aOptionMultiBrowse['CallBack']['Text'][1]);
                        $tCallBackTextKey   = $aCallBackTextKey[1];
                        $tDataReturnText    = $aValue->$tCallBackTextKey;
                    }else{
                        $tDataReturnText    = "";
                    }

                    $tHtmlTableData .=  "<tr class='xCNTextDetail2 xWMultiDataItems' data-code='".$tDataReturnValue."' data-name='".$tDataReturnText."'>";

                    // Check Data Next Function
                    if (isset($aOptionMultiBrowse['NextFunc']['ArgReturn'])){
                        $aArgRet = [];
                        for ($g = 0; $g < FCNnHSizeOf($aOptionMultiBrowse['NextFunc']['ArgReturn']); $g++) {
                            $tAgrCol        = $aOptionMultiBrowse['NextFunc']['ArgReturn'][$g];
                            $aArgRet[$g]    = $aValue->$tAgrCol;
                        }
                        $tHtmlTableData .= "<input type='text' style='display:none' id='ohdCallBackArg" . $aValue->$tMasterPK . "' value='" . json_encode($aArgRet) . "'" . ">";
                    }

                    $tHtmlTableData .=  "<td class='xCNTextBold' style='text-align:center' width='10%'>";
                    $tHtmlTableData .=  "<label class='fancy-checkbox'>";
                    $tHtmlTableData .=  "<input class='xWMultiSelectItems' type='checkbox'>";
                    $tHtmlTableData .=  "<span>&nbsp;</span>";
                    $tHtmlTableData .=  "</label>";
                    $tHtmlTableData .=  "</td>";
                    // For Loop Data Colums
                    for($f = 0; $f < FCNnHSizeOf($aOptionMultiBrowse['GrideView']['DataColumns']); $f++){
                        $aColumnVal = explode('.', $aOptionMultiBrowse['GrideView']['DataColumns'][$f]);
                        $tColumnVal = $aColumnVal[1];
                        // Check Data Colums Format Number,string And Set Alignment
                        if(isset($aOptionMultiBrowse['GrideView']['DataColumnsFormat'])){
                            if (isset($aOptionMultiBrowse['GrideView']['DataColumnsFormat'][$f])){
                                if ($aOptionMultiBrowse['GrideView']['DataColumnsFormat'][$f] != ''){
                                    $aColumnFormat  = explode(":", $aOptionMultiBrowse['GrideView']['DataColumnsFormat'][$f]);
                                    $tFomatType     = $aColumnFormat[0];
                                    $tFomatVal      = $aColumnFormat[1];
                                }else{
                                    $tFomatType     = '';
                                    $tFomatVal      = '';
                                }
                                // Switch Case Type
                                switch ($tFomatType){
                                    case '':
                                        $tDataDisplay   = $aValue->$tColumnVal;
                                        $tTextAlign     = "left!important";
                                        break;
                                    case 'Text':
                                        $tDataDisplay   = $this->JCNtFormatText($tFomatVal,$aValue->$tColumnVal);
                                        $tTextAlign     = "left!important";
                                        break;

                                    case 'Date':
                                        $tDataDisplay   = $this->JCNtFormatDate($tFomatVal, $aValue->$tColumnVal);
                                        $tTextAlign     = "left!important";
                                        break;

                                    case 'Currency':
                                        if (isset($aColumnFormat[2])):
                                            $tCurrencySign  = $aColumnFormat[2];
                                        else:
                                            $tCurrencySign  = '&#3647;';
                                        endif;
                                        $tDataDisplay       = $this->JCNtFormatCurrency($tFomatVal, $aValue->$tColumnVal, $tCurrencySign);
                                        $tTextAlign         = "right!important";
                                        break;

                                    case 'Number':
                                        $tDataDisplay       = number_format($aValue->$tColumnVal);
                                        $tTextAlign         = "right!important";
                                        break;

                                    default:
                                        $tDataDisplay       = $aValue->$tColumnVal;
                                        $tTextAlign         = "left!important";
                                        break;
                                }
                            }
                        }else{
                            $tDataDisplay   = $aValue->$tColumnVal;
                            $tTextAlign     = "left!important";
                        }
                        // Check Disable Data
                        if(isset($aOptionMultiBrowse['GrideView']['DisabledColumns'])){
                            if($this->JCNbCheckColDisabled($f,$aOptionMultiBrowse['GrideView']['DisabledColumns']) == false) {
                                $tHtmlTableData .= "<td style='text-align:$tTextAlign'>" . $this->JCNtColChkNull($tDataDisplay) . "</td>";
                            }
                        }else{
                            $tHtmlTableData .= "<td style='text-align:$tTextAlign'>" . $this->JCNtColChkNull($tDataDisplay) . "</td>";
                        }
                    }
                    $tHtmlTableData .=  "</tr>";
                }
            }else{
                $nCountColData   =  FCNnHSizeOf($aOptionMultiBrowse['GrideView']['DataColumns']);
                $nColspanData    =  $nCountColData + 1;
                $tHtmlTableData .=  "<tr><td colspan='".$nColspanData."' style='text-align:center';>";
                $tHtmlTableData .=  language('common/main/main', 'tCMNNotFoundData');
                $tHtmlTableData .=  "</td></tr>";
            }

            $aDataConfigView    = [
                'tTitleHeader'          => $tTitleHeader,
                'tOptionName'           => $tOptionName,
                'tFilterSearch'         => $tFilterSearch,
                'tHtmlTableHeard'       => $tHtmlTableHeard,
                'tHtmlTableData'        => $tHtmlTableData,
                'tOldCallBackVal'       => $tOldCallBackVal,
                'tOldCallBackText'      => $tOldCallBackText,
                'tOldCallBackStaAll'    => $tOldCallBackStaAll
            ];
            $this->load->view('common/browsemultiselect/wBrowseMultiSelect',$aDataConfigView);
        }
        if(isset($aOptionMultiBrowse['DebugSQL']) && $aOptionMultiBrowse['DebugSQL'] == true){
            echo $tSQLMultiBrowse;
        }
    }

    // Functionality : Function Fine Colums Disable In Array
    // Parameters : Function Parameter
    // Creator : 17/12/2019 Wasin (Yoshi)
    // Return : Status Find Data In Array
    // Return Type : Boolen
    private function JCNbCheckColDisabled($pnInx,$paDisable){
        if(in_array($pnInx,$paDisable)) {
            return true;
        } else {
            return false;
        }
    }

    // Functionality : Function Set Format Text
    // Parameters : Function Parameter
    // Creator : 17/12/2019 Wasin (Yoshi)
    // Return : String Data Formath Text
    // Return Type : String
    private function JCNtFormatText($paFomatSetVal, $ptOriData) {

        if ($paFomatSetVal != ''):
            return substr($ptOriData, 0, $paFomatSetVal);
        else:
            return $ptOriData;
        endif;
    }

    // Functionality : Function Set Format Date
    // Parameters : Function Parameter
    // Creator : 17/12/2019 Wasin (Yoshi)
    // Return : String Data Formath Date
    // Return Type : String
    private function JCNtFormatDate($paFomatSetVal, $ptOriData) {

        if ($paFomatSetVal != ''):
            switch ($paFomatSetVal) {
                case 'YYYY-MM-DD':
                    return substr($ptOriData, 0, 10);
                    break;
                case 'DD-MM-YYYY':

                    $tNewDataFormat = substr($ptOriData, 0, 10);

                    $aNewDataFormat = explode("-", $tNewDataFormat);

                    return $aNewDataFormat[2] . "-" . $aNewDataFormat[1] . "-" . $aNewDataFormat[0];
                    break;
                case 'MM-DD-YYYY':
                    $tNewDataFormat = substr($ptOriData, 0, 10);
                    $aNewDataFormat = explode("-", $tNewDataFormat);
                    return $aNewDataFormat[1] . "-" . $aNewDataFormat[2] . "-" . $aNewDataFormat[0];
                    break;
                case 'YYYY/MM/DD':
                    $tNewDataFormat = substr($ptOriData, 0, 10);
                    $aNewDataFormat = explode("-", $tNewDataFormat);
                    return $aNewDataFormat[0] . "/" . $aNewDataFormat[1] . "/" . $aNewDataFormat[2];
                    break;
                case 'DD/MM/YYYY':
                    $tNewDataFormat = substr($ptOriData, 0, 10);
                    $aNewDataFormat = explode("-", $tNewDataFormat);
                    return $aNewDataFormat[2] . "/" . $aNewDataFormat[1] . "/" . $aNewDataFormat[0];
                    break;
                case 'MM/DD/YYYY':
                    $tNewDataFormat = substr($ptOriData, 0, 10);
                    $aNewDataFormat = explode("-", $tNewDataFormat);
                    return $aNewDataFormat[1] . "/" . $aNewDataFormat[2] . "/" . $aNewDataFormat[0];
                    break;
                default:
                    return substr($ptOriData, 0, 10);
                    break;
            }
        else:
            return $ptOriData;
        endif;
    }

    // Functionality : Function Set Format Currency
    // Parameters : Function Parameter
    // Creator : 17/12/2019 Wasin (Yoshi)
    // Return : String Data Formath Date
    // Return Type : String
    private function JCNtFormatCurrency($paFomatSetVal, $ptOriData, $ptCurrencySign) {
        if ($paFomatSetVal != ''):
            $cCurrency = number_format($ptOriData, $paFomatSetVal);
            return $ptCurrencySign . ' ' . $cCurrency;
        else:
            $cCurrency = number_format($ptOriData);
            return $ptCurrencySign . ' ' . $cCurrency;
        endif;
    }

    // Functionality : Function Check Data Null
    // Parameters : Function Parameter
    // Creator : 17/12/2019 Wasin (Yoshi)
    // Return : String Data Formath Date
    // Return Type : String
    private function JCNtColChkNull($ptData) {
        if ($ptData != '' || $ptData != null) {
            return $ptData;
        } else {
            return 'N/A';
        }
    }






}