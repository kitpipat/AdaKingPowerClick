<?php

defined('BASEPATH') or exit('No direct script access allowed');
//27-03-2563 เนลแก้ เรื่อง Brows M ให้ เปิดใช้ ค้นหา และ แบ่งหน้า
class cBrowserChain extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        $this->load->helper('url');
        //$this->load->model ('common/mBrowser','mBrowser');
    }

    public function index()
    {
        $tIDCurrent = '';
        $oPtions = $this->input->post('paOptions');
        $this->session->set_userdata("paOptions", $oPtions);

        if ($oPtions != '' || $oPtions != 'undefined') :

            $tLangPath = (isset($oPtions['Title'][0]) && !empty($oPtions['Title'][0])) ? $oPtions['Title'][0] : ''; // โฟลเดอร์ภาษา
            $bIssetTitlePath = (isset($oPtions['Title'][0]) && !empty($oPtions['Title'][0]));
            $tLangKey = $oPtions['Title'][1]; // Key ภาษา

            if ($bIssetTitlePath) {
                $tPopupTitle = language($tLangPath, $tLangKey); // Popup Title Bar
            } else {
                $tPopupTitle = $tLangKey; // Popup Title Bar
            }

            $tMasterTable   = $oPtions['Table']['Master']; // Master Table
            $tMasterPK      = $oPtions['Table']['PK']; // Master PK
            $tMasterChain      = $oPtions['Table']['Chain']; // MasterChain
            $tMasterLevel      = $oPtions['Table']['Level']; // MasterLevel
            $tMasterParent     = $oPtions['Table']['Parent']; // MasterParent
            @$tMasterPKName = $oPtions['Table']['PKName']; // Master PK
            $tMasterFK      = (isset($oPtions['Table']['FK'])) ? $oPtions['Table']['FK'] : ''; // Master PK
            $CallBackType   = $oPtions['CallBack']['ReturnType'];
            $tSearchFilter  = (isset($oPtions['SearchFilter'])) ? $oPtions['SearchFilter'] : '';

            $tColPk = $tMasterTable . "." . $tMasterPK;

            // Set Current Page
            if ($this->input->post('nCurentPage') != '') :
                $nCurentPage = $this->input->post('nCurentPage');
            else :
                $nCurentPage = 1;
            endif;

            // Set Option by post
            if ($this->input->post('tOptions') != '') :
                $tOptions = $this->input->post('tOptions');
                $this->session->set_userdata("tOptions", $tOptions);
            else :
                echo 'Error: Do not set options';
                exit();
            endif;

            // Callback Value
            $tOldCallBackVal = $this->input->post('tCallVal');
            $this->session->set_userdata("tOldCallBackVal", $tOldCallBackVal);
            if (isset($tOldCallBackVal)) :
                $tOldCallBackVal = $tOldCallBackVal;
            else :
                $tOldCallBackVal = '';
            endif;

            // Callbac Text
            $tOldCallBackText = $this->input->post('tCallText');
            $this->session->set_userdata("tOldCallBackText", $tOldCallBackText);
            if (isset($tOldCallBackText)) :
                $tOldCallBackText = $tOldCallBackText;
            else :
                $tOldCallBackText = '';
            endif;

            // Callback Option
            if (isset($oPtions['CallBack']['Text'])) :
                $tCallBackTextColumn = explode('.', $oPtions['CallBack']['Text'][1]);
            else :
                $tCallBackTextColumn = '';
            endif;
            $tCallBackColumn = $tCallBackTextColumn[1];

            // Page Option
            if ($oPtions['GrideView']['Perpage']) :
                $nPerPage = $oPtions['GrideView']['Perpage'];
            else :
                $nPerPage = 5;
            endif;

            $aRowLen = FCNaHCallLenData($nPerPage, $nCurentPage); //Parameter [1] = Limit/Page [2] = PageNo

            // Order By Option
            $aOrderBy = $oPtions['GrideView']['OrderBy'];
            $tOrderBy = "";
            if (empty($aOrderBy) || !isset($aOrderBy)) {
                $tOrderBy = "$tColPk ASC";
            } else {
                $tOrderBy = implode(',', $aOrderBy);
            }

            // Init SQL
            $tSQL = "";
            $tSQL .= "SELECT Result.* FROM (";
            //Distinct
            if (isset($oPtions['GrideView']['DistinctField'])) {
                $aDistinct = $oPtions['GrideView']['DistinctField'];
            } else {
                $aDistinct = '';
            }

            if (isset($oPtions['GrideView']['StartRow'])) {
                $nStartRow = intval($oPtions['GrideView']['StartRow']);
            } else {
                $nStartRow = 0;
            }

            if ($aDistinct != '') {
                $aColumns = $oPtions['GrideView']['DataColumns'];
                $tTextResultShow = '';
                for ($i = 0; $i < FCNnHSizeOf($aColumns); $i++) {
                    $tTextShow = Explode('.', $aColumns[$i]);
                    $tTextResultShow .=  'ResultSubquery.' . $tTextShow[1] . ',';

                    //remove ,
                    if ($i == FCNnHSizeOf($aColumns) - 1) {
                        $tResultShow = substr($tTextResultShow, 0, -1);
                    }

                    //orderby
                    if ($i == $aDistinct[0]) {
                        $tOrderByDistinct = $tTextShow[1];
                    }
                }
                $tSQL .= "SELECT $nStartRow + ROW_NUMBER() OVER(ORDER BY ResultSubquery.$tOrderByDistinct) AS rtRowID , $tResultShow FROM ( SELECT ";
            } else {
                $tSQL .= "SELECT $nStartRow + ROW_NUMBER() OVER(ORDER BY $tOrderBy) AS rtRowID , ";
            }
            $tSQL .= "  (SELECT COUNT(*) FROM $tMasterTable TSUB WITH (NOLOCK) WHERE TSUB.$tMasterParent = $tMasterTable.$tMasterPK AND TSUB.$tMasterPK !=$tMasterTable.$tMasterPK ) AS rnStaChrl, ";
            // Select Column From Options
            if (isset($oPtions['GrideView'])) :
                if (isset($oPtions['GrideView']['DataColumns'])) :
                    $aColumns = $oPtions['GrideView']['DataColumns']; // Return Column

                    if (empty($aDistinct)) {
                        if (is_array($aColumns)) {
                            $tColumns = implode(',', $aColumns);
                            $tSQL .= " $tColumns ";
                        } else {
                            echo "Error:No column select.";
                            exit();
                        }
                    } else {
                        if (is_array($aColumns)) {
                            $tText = '';
                            for ($i = 0; $i < FCNnHSizeOf($aColumns); $i++) {
                                if (isset($aDistinct[$i])) {
                                    $tText .= 'DISTINCT(' . $aColumns[$i] . ')' . ',';
                                } else {
                                    $tText .= $aColumns[$i] . ',';
                                }
                                if ($i == FCNnHSizeOf($aColumns) - 1) {
                                    $tTextResult = substr($tText, 0, -1);
                                }
                            }
                            $tSQL .= " $tTextResult ";
                        } else {
                            echo "Error:No column select.";
                            exit();
                        }

                        //echo print_r($aDistinct[0]);
                    }
                else :
                    echo "Error:No column select.";
                    exit();
                endif;

            else :
                echo "Error: No column select.";
                exit();
            endif;
            // end select column

            $tSQL .= " FROM $tMasterTable "; // select from master table
            // Join Table if Has Join Options
            if (isset($oPtions['Join']['Table'])) :
                for ($j = 0; $j < FCNnHSizeOf($oPtions['Join']['Table']); $j++) {
                    if (isset($oPtions['Join']['SpecialJoin'])) {
                        // $tSQL .= " RIGHT JOIN " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                        $tSQL .= $oPtions['Join']['SpecialJoin'][0] . " " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                    } else {
                        $tSQL .= " LEFT JOIN " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                    }
                }
            endif;

            /*if(isset($oPtions['GrideView']['WhereSearch'])):
                 $tWhereSearch = $oPtions['GrideView']['WhereSearch'];
             else:
                 $tWhereSearch = '';
             endif;*/
      
            $tSQL .= " WHERE 1=1  AND $tMasterTable.$tMasterLevel = 1";

            // Filter Data From Selector Browse
            if (isset($oPtions['Filter'])) :
                $tFilter = $this->input->post('tFileter');
                if ($tFilter != '') :
                    if ($oPtions['Filter']['Table'] != '' and $oPtions['Filter']['Key'] != '') :
                        $tTableFilter = $oPtions['Filter']['Table'] . "." . $oPtions['Filter']['Key'];
                        $tSQL .= " AND $tTableFilter = '" . $tFilter . "'";
                    endif;
                endif;
            endif;

            $tFilerGride = $this->input->post('tFilerGride'); // Filter Value
            // Filter Data From Filter Element
            if (isset($tFilerGride)) {
                if ($tFilerGride != '') {
                    //mos 21/01/2020 กรณีถ้าฟิวส์เป็นตัวเลข มันไม่ต้องใส่ collate thai_bin
                    if (isset($tColPk) && !empty($tColPk) && (strpos($tColPk, 'FN') == 0 || strpos($tColPk, 'FD') == 0)) {
                        $tSQL .= " AND ( $tColPk LIKE '%$tFilerGride%' ";
                    } else {
                        $tSQL .= " AND ( $tColPk COLLATE THAI_BIN LIKE '%$tFilerGride%' ";
                    }

                    for ($fc = 0; $fc < FCNnHSizeOf($oPtions['GrideView']['DataColumns']); $fc++) {
                        $tFilterCol = $oPtions['GrideView']['DataColumns'][$fc];

                        //mos 21/01/2020 กรณีถ้าฟิวส์เป็นตัวเลข มันไม่ต้องใส่ collate thai_bin
                        if (isset($tFilterCol) && !empty($tFilterCol) && (strpos($tFilterCol, 'FN') == 0 || strpos($tFilterCol, 'FD') == 0)) {
                            $tSQL .= "  OR $tFilterCol LIKE '%$tFilerGride%' ";
                        } else {
                            $tSQL .= "  OR $tFilterCol COLLATE THAI_BIN LIKE '%$tFilerGride%' ";
                        }
                    }
                    $tSQL .= " ) ";
                };
            };

            if (!empty($aDistinct)) {
                //WHERE
                if (isset($oPtions['Where'])) :
                    if ($oPtions['Where']['Condition']) :
                        for ($w = 0; $w < FCNnHSizeOf($oPtions['Where']['Condition']); $w++) {
                            $tSQL .= " " . $oPtions['Where']['Condition'][$w];
                        }
                    endif;
                endif;
                $tSQL .= ' ) as ResultSubquery ';
            } else {
                //WHERE
                if (isset($oPtions['Where'])) :
                    if ($oPtions['Where']['Condition']) :
                        for ($w = 0; $w < FCNnHSizeOf($oPtions['Where']['Condition']); $w++) {
                            $tSQL .= " " . $oPtions['Where']['Condition'][$w];
                        }
                    endif;
                endif;
            }

            $tSQL .= " ) AS Result ";

            $tFinalQuery = $tSQL;
            $tFinalQuery .= " WHERE  Result.rtRowID > " . $aRowLen[0] . " AND Result.rtRowID <=" . $aRowLen[1];

            if (isset($oPtions['NotIn'])) :
                $tNotIn = $this->input->post('tNotIn');
                if ($tNotIn != '') :
                    if ($oPtions['NotIn']['Table'] != '' and $oPtions['NotIn']['Key'] != '') :
                        $tTableFilter = "Result" . "." . $oPtions['NotIn']['Key'];
                        $tFinalQuery .= " AND $tTableFilter NOT IN ('" . $tNotIn . "')";
                    endif;
                endif;
            endif;

            // echo $tSQL."<hr>";
            // echo $tFinalQuery."<hr>";

            $oQuery = $this->db->query($tFinalQuery);

            // Get Total Record From Query
            $nTotalRecord = ceil($this->FMnCBWSGetRecord($tSQL)); //Total Record From Qurey


            $aDataTable = $oQuery->result();

            // Display Grid Table
            // $tDataTable = "<div class='container'>";

            /* Fix By Krit 28/06/2018 */
            /* เพื่อเก็บ Route ก่อนหน้าที่มา จะได้เอาไปเช็คว่ามาจากหน้าอ่ะไร? */
            if (isset($oPtions['RouteFrom'])) {
                $tRouteFromName = $oPtions['RouteFrom'];
            } else {
                $tRouteFromName = 'EmptyRouteFrom';
            }

            if (isset($oPtions['RouteAddNew'])) {
                $tFormAddRouteName = $oPtions['RouteAddNew'];
            } else {
                $tFormAddRouteName = 'EmptyRoute';
            }

            $tInformation = language('common/main/main', 'tShowData');
            $tChoose = language('common/main/main', 'tModalAdvChoose');
            $tClose = language('common/main/main', 'tCMNClose');
            $tSearch = language('common/main/main', 'tPlaceholder');
            // Modal Header
            $tDataTable = '
                <div class="modal-header xCNModalHead">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">' . $tInformation . ' : ' . $tPopupTitle . '</label>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                            <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmSelected(' . "'" . $tOptions . "'" . ')">' . $tChoose . '</button>
                            <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal" onclick="JCNxClearValueInModal()">' . $tClose . '</button>
                        </div>
                    </div>
                </div>
            ';

            // Start Modal Body
            $tDataTable .= '<div class="modal-body">';

            $tDataTable .= '<div class="row">';

            // Search bar
            $tDataTable .= "<div class='col-xs-6 col-sm-6 col-md-5 col-lg-5'>";

            // if ($CallBackType == 'S') { // Display on Select Single Mode

            $tOnKeyPress = "";
            $tOnClick    = "";
            if ($tSearchFilter != "HTML") {
                $tOnKeyPress = 'onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowse(' . "'1'," . "'" . $tOptions . "'" . ')"';
                $tOnClick    = 'onclick="JCNxSearchBrowse(' . "'1'," . "'" . $tOptions . "'" . ')"';
            } else {
                $tOnKeyPress = 'onkeypress="Javascript:if(event.keyCode==13 ) JCNxSearchBrowseHtml()"';
                $tOnClick    = 'onclick="JCNxSearchBrowseHtml()"';
            }

            $tDataTable .= "<div class='form-group'>";
            $tDataTable .= "<div class='input-group'>";
            $tDataTable .= '<input class="form-control oetTextFilter oetSearchTable" type="text" value="' . htmlspecialchars($tFilerGride, ENT_QUOTES, "UTF-8") . '" ' . $tOnKeyPress . ' autocomplete="off" placeholder="' . $tSearch . '">';
            $tDataTable .= "<span class='input-group-btn'>";
            $tDataTable .= '<button id="obtBrowseModalSearch" class="btn xCNBtnSearch" type="button" ' . $tOnClick . ' >';
            $tDataTable .= '<i class="fa fa-search"></i>';
            $tDataTable .= "</button>";
            $tDataTable .= "</span>";
            $tDataTable .= "</div>";
            $tDataTable .= "</div>";
            // }

            $tDataTable .= "</div>";

            if (isset($oPtions['BrowseLev'])) {
                if ($oPtions['BrowseLev'] != 1) {
                    $tDataTable .= "
                        <div class='col-xs-6 col-sm-6 col-md-7 col-lg-7 text-right'>
                            <button class='xCNBtnPushModalBrowse' onclick=JCNxAddNewData('" . $tFormAddRouteName . "',1,'" . $tOptions . "','" . $tRouteFromName . "')>+</button>
                        </div>
                    ";
                }
            } else {
            }


            $tDataTable .= "</div>";

            // Grid Table
            $tDataTable .= "<div class='row'>";
            $tDataTable .= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            $tDataTable .= "<div class='table-responsive'>";
            $tDataTable .= "<table id='otbBrowserList' class='table table-striped' style='width:100%'>";
            $tDataTable .= "<thead>";
            $tDataTable .= "<tr>";
            for ($c = 0; $c < FCNnHSizeOf($oPtions['GrideView']['DataColumns']); $c++) :

                if (isset($oPtions['GrideView']['ColumnsSize'][$c])) {
                    $nColumnSize = $oPtions['GrideView']['ColumnsSize'][$c];
                } else {
                    $nColumnSize = '';
                }

                $tCollangPath = (isset($oPtions['GrideView']['ColumnPathLang']) && !empty($oPtions['GrideView']['ColumnPathLang'])) ? $oPtions['GrideView']['ColumnPathLang'] : '';
                $bIssetLangPath = (isset($oPtions['GrideView']['ColumnPathLang']) && !empty($oPtions['GrideView']['ColumnPathLang']));

                if (isset($oPtions['GrideView']['ColumnKeyLang'][$c])) :
                    if ($bIssetLangPath) {
                        $tCollangKey = language($tCollangPath, $oPtions['GrideView']['ColumnKeyLang'][$c]);
                    } else {
                        $tCollangKey = $oPtions['GrideView']['ColumnKeyLang'][$c];
                    }
                else :
                    $tCollangKey = "N/A";
                endif;

                if (isset($oPtions['GrideView']['DisabledColumns'])) :
                    if ($this->JCNtColDisabled($c, $oPtions['GrideView']['DisabledColumns']) == false) :
                        $tDataTable .= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSize'>" . $tCollangKey . "</th>";
                    endif;
                else :
                    $tDataTable .= "<th class='xCNTextBold' style='text-align:center' width='$nColumnSize'>" . $tCollangKey . "</th>";
                endif;

            endfor;
            $tDataTable .= "</tr>";
            $tDataTable .= "</thead>"; // End Thead

            if ($oQuery->num_rows() > 0) :
                $nIdx = 0;
                $tRowActive = '';

                if ($tMasterFK != '') {
                    $tMasterPK = $tMasterFK;
                }

                foreach ($aDataTable as $key => $val) :

                    if (isset($oPtions['NextFunc']['ArgReturn'])) :
                        //echo $oPtions['NextFunc']['ArgReturn'][0];
                        $aArgRet = array();
                        for ($g = 0; $g < FCNnHSizeOf($oPtions['NextFunc']['ArgReturn']); $g++) {
                            $tAgrCol = $oPtions['NextFunc']['ArgReturn'][$g];
                            $aArgRet[$g] = $val->$tAgrCol;
                        }

                        $tDataTable .= "<input type='text' class='xCNKeepValue" . $val->$tMasterPK . "' style='display:none' id='ohdCallBackArg" . $val->$tMasterPK . $tMasterTable . "' value='" . json_encode($aArgRet) . "'" . ">";
                    endif;

                    $tDataTable .= "<input type='text' style='display:none' id='ohdCallBackText" . $val->$tMasterPK . $tMasterTable . "' value='" . $val->$tCallBackColumn . "'" . ">";
                   
                    // if ($val->$tMasterLevel!=1) {
                    //     continue;
                    // }



                    if ($tIDCurrent != $val->$tMasterPK) :

                        if (isset($oPtions['CallBack']['StaSingItem'])) {

                            if ($oPtions['CallBack']['StaSingItem'] == '1') {
                                $tIDCurrent = $val->$tMasterPK;
                            }
                        }

                        $tCallBackTextData = $val->$tCallBackColumn;
                        if ($CallBackType == 'S') :
                            if ($val->$tMasterPK === $tOldCallBackVal) {
                                if (isset($oPtions['CallBack']['StaDoc'])) {
                                    $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                    if ($CallBackStaDoc == 1) {
                                        $tRowActive = "xCNHide";
                                    } else {
                                        $tRowActive = "active  1 ";
                                    }
                                } else {
                                    $tRowActive = "active   2 ";
                                }
                            } else {
                                $tRowActive = "";
                            }

                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' ' . $tRowActive . '  xCNChain'.$val->$tMasterChain.' " data-code="'.$val->$tMasterPK.'" data-chain="'.$val->$tMasterChain.'"  data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushSelection(' . "'" . $val->$tMasterPK . "',this , '" . $tMasterTable . "' " . ')" ondblclick="JCNxDoubleClickSelection(' . "'" . $val->$tMasterPK . "',this," . "'" . $tOptions . "'," . "'" . $tMasterTable . "' " . ')">';
                        elseif ($CallBackType == 'M') :
                            if (is_array($tOldCallBackVal)) {
                                if (in_array($val->$tMasterPK, $tOldCallBackVal)) {

                                    //Option Sta Doc
                                    if (isset($oPtions['CallBack']['StaDoc'])) {
                                        $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                        if (($CallBackStaDoc == 1) || ($CallBackStaDoc == 2)) {
                                            if ($CallBackStaDoc == 1) { // Hide for select
                                                $tRowActive = "xCNHide";
                                            }
                                            if ($CallBackStaDoc == 2) { // Show with unactive
                                                $tRowActive = "";
                                            }
                                        } else {
                                            $tRowActive = "active  3 ";
                                        }
                                    } else {
                                        $tRowActive = "active  4 ";
                                    }
                                } else {
                                    $tRowActive = "";
                                }
                            } else {
                                $tRowActive = "";
                            }

                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' ' . $tRowActive . ' xCNChain'.$val->$tMasterChain.' " data-code="'.$val->$tMasterPK.'" data-chain="'.$val->$tMasterChain.'" data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushMultiSelection(' . "'" . $val->$tMasterPK . "'," . htmlspecialchars(json_encode($tCallBackTextData), ENT_QUOTES, "UTF-8") . ",this" . ')">';
                        else :
                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' xCNChain'.$val->$tMasterChain.' "  data-code="'.$val->$tMasterPK.'" data-chain="'.$val->$tMasterChain.'" data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushSelection(' . "'" . $val->$tMasterPK . "',this , '" . $tMasterTable . "' " . ')" ondblclick="JCNxDoubleClickSelection(' . "'" . $val->$tMasterPK . "',this," . "'" . $tOptions . "'" . "'," . "'" . $tMasterTable . "' " . ')">';
                        endif;


                        $tDataTable .= "</td>";
                        for ($f = 0; $f < FCNnHSizeOf($oPtions['GrideView']['DataColumns']); $f++) :

                            $aColumnVal = explode('.', $oPtions['GrideView']['DataColumns'][$f]);
                            $tColumnVal = $aColumnVal[1];

                            if (isset($oPtions['GrideView']['DataColumnsFormat'])) :
                                if (isset($oPtions['GrideView']['DataColumnsFormat'][$f])) :
                                    if ($oPtions['GrideView']['DataColumnsFormat'][$f] != '') :
                                        $aColumnFormat = explode(":", $oPtions['GrideView']['DataColumnsFormat'][$f]);
                                        $tFomatType = $aColumnFormat[0];
                                        $tFomatVal = $aColumnFormat[1];
                                    else :
                                        $tFomatType = '';
                                        $tFomatVal = '';
                                    endif;

                                    switch ($tFomatType) {
                                        case '':
                                            $tDataDisPlay = $val->$tColumnVal;
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Text':
                                            $tDataDisPlay = $this->JCNtFormatText($tFomatVal, $val->$tColumnVal);
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Date':
                                            $tDataDisPlay = $this->JCNtFormatDate($tFomatVal, $val->$tColumnVal);
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Currency':
                                            if (isset($aColumnFormat[2])) :
                                                $tCurrencySign = $aColumnFormat[2];
                                            else :
                                                $tCurrencySign = '&#3647;';
                                            endif;

                                            $tDataDisPlay = $this->JCNtFormatCurrency($tFomatVal, $val->$tColumnVal, $tCurrencySign);
                                            $tTextAlign = "right!important";
                                            break;

                                        case 'Number':
                                            $nDecumalShow = FCNxHGetOptionDecimalShow();
                                            $tDataDisPlay = number_format($val->$tColumnVal, $nDecumalShow);
                                            $tTextAlign = "right!important";
                                            break;

                                        default:
                                            $tDataDisPlay = $val->$tColumnVal;
                                            $tTextAlign = "left!important";
                                            break;
                                    }
                                else :

                                endif;
                            else :

                                $tDataDisPlay = $val->$tColumnVal;
                                $tTextAlign = "left!important";
                            endif;

                            if (isset($oPtions['GrideView']['DisabledColumns'])) {
                                $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                if ($this->JCNtColDisabled($f, $oPtions['GrideView']['DisabledColumns']) == false) {
                                    if ($oPtions['GrideView']['DataColumns'][$f] == 'TFHMPdtSeason_L.FTSeaName') {
                                        if($val->rnStaChrl==0){
                                            $tDisplayNone = 'style="display:none"';
                                        }else{
                                            $tDisplayNone = '';
                                        }
                                        $tDataTable .= "<td style='text-align:$tTextAlign'><button  type='button' $tDisplayNone onclick='JSvCallListChainModal(this)' data-table='$tMasterTable' data-active='2'  data-parent='".$val->$tMasterPK."' data-level='".($val->$tMasterLevel+1)."' ><i class='fa fa-angle-right' aria-hidden='true' id='oeiIconParent".$val->$tMasterPK."'></i></button> " . $tColumnValue . "</td>";
                                    }else{
                                         $tDataTable .= "<td style='text-align:$tTextAlign'>" . $this->JCNtColChkNull($tDataDisPlay) . "</td>";
                                    }
                                }
                            } else {
                                //สำหรับข้อมูลตาราง TVDMShopType (Vending)
                                if ($oPtions['Table']['Master'] == 'TVDMShopType' && $oPtions['Table']['PK'] == 'FTShtCode') {
                                    if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 1) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending01');
                                    } else if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 2) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending02');
                                    } else if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 3) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending03');
                                    } else {
                                        $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                    }
                                } else {
                                    //สำหรับข้อมูลทั่วไป
                                    $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                }
                                if ($oPtions['GrideView']['DataColumns'][$f] == 'TFHMPdtSeason_L.FTSeaName') {
                                    if($val->rnStaChrl==0){
                                        $tDisplayNone = 'style="display:none"';
                                    }else{
                                        $tDisplayNone = '';
                                    }
                                    $tDataTable .= "<td style='text-align:$tTextAlign'><button  type='button' $tDisplayNone onclick='JSvCallListChainModal(this)' data-table='$tMasterTable' data-active='2' data-parent='".$val->$tMasterPK."' data-level='".($val->$tMasterLevel+1)."'  ><i class='fa fa-angle-right' aria-hidden='true' id='oeiIconParent".$val->$tMasterPK."'></i></button> " . $tColumnValue . "</td>";
                                } else {
                                    $tDataTable .= "<td style='text-align:$tTextAlign'>" . $tColumnValue ."</td>";
                                }
                            }

                        endfor;
                        $tDataTable .= "</tr>";
                        $nIdx++;
                    endif;
                endforeach;
            else :
                $nCountColData = FCNnHSizeOf($oPtions['GrideView']['DataColumns']);
                $nColspan = $nCountColData + 1;
                $tDataTable .= "<tr><td colspan='" . $nColspan . "' style='text-align:center';>";
                $tDataTable .= language('common/main/main', 'tCMNNotFoundData');
                $tDataTable .= "</td></tr>";
            endif;

            $tDataTable .= "</table>";
            $tDataTable .= "</div>";
            $tDataTable .= "</div>";
            $tDataTable .= "</div>";

            $tPageBoxStyle = 'margin-top: 10px;';
            if ($CallBackType == 'M') {
                $tPageBoxStyle .= '';
            }

            // Row Pagination
            $tDataTable .= "<div class='row' style='$tPageBoxStyle'>";

            // PageNation show info
            $nTotalPage = ceil($nTotalRecord / $nPerPage);

            if ($nCurentPage == 1) :
                $nPrvPage = 1;
            else :
                $nPrvPage = $nCurentPage - 1;
            endif;

            if ($nCurentPage == $nTotalPage) :
                $nNextPage = $nTotalPage;
            else :
                $nNextPage = $nCurentPage + 1;
            endif;

            $tDataTable .= "<div class='col-xs-12 col-md-6'>";
            $tDataTable .= language('common/main/main', 'tResultTotalRecord');
            $tDataTable .= " " . number_format($nTotalRecord) . " ";
            $tDataTable .= language('common/main/main', 'tRecord');
            $tDataTable .= " ";
            $tDataTable .= language('common/main/main', 'tCurrentPage');
            $tDataTable .= " " . ($nCurentPage == "" ? "1" : $nCurentPage) . " / " . $nTotalPage;
            $tDataTable .= "</div>";
            // end page info

            if ($nTotalPage > 0) :

                // PageNation page number
                if ($nCurentPage == 1) {
                    $tDisabledLeft = 'disabled';
                } else {
                    $tDisabledLeft = '';
                }
                $tDataTable .= "<div class='col-xs-12 col-md-6 text-right'>";
                $tDataTable .= '<div class="btn-toolbar pull-right">';
                $tDataTable .= '<button onclick="JCNxSearchBrowse(' . "'" . $nPrvPage . "'," . "'" . $tOptions . "'" . ')" class="btn btn-white btn-sm" ' . $tDisabledLeft . '>';
                $tDataTable .= '<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>';
                $tDataTable .= '</button>';

                for ($p = 1; $p <= $nTotalPage; $p++) :
                    if ($p == $nCurentPage) :
                        $tActived = "active";
                    else :
                        $tActived = "";
                    endif;
                    if ($nCurentPage == 1) :
                        $nStartPage = 1;
                        $nEndPage = 3;
                    else :
                        if ($nCurentPage == $nTotalRecord) :
                            $nStartPage = $nTotalRecord - 2;
                            $nEndPage = $nTotalRecord;
                        else :
                            $nStartPage = $nCurentPage - 1;
                            $nEndPage = $nCurentPage + 1;
                        endif;
                    endif;
                    if ($p >= $nStartPage and $p <= $nEndPage) :
                        $tDataTable .= '<button onclick="JCNxSearchBrowse(' . $p . ",'" . $tOptions . "'" . ')" type="button" class="page-item btn xCNBTNNumPagenation" ' . $tActived . '">' . $p . '</button>';
                    endif;
                endfor;
                // End Page Number

                if ($nCurentPage >= $nTotalPage) {
                    $tDisabledRight = 'disabled';
                } else {
                    $tDisabledRight = '';
                }
                $tDataTable .= '<button onclick="JCNxSearchBrowse(' . "'" . $nNextPage . "'," . "'" . $tOptions . "'" . ')" class="btn btn-white btn-sm" ' . $tDisabledRight . '>';
                $tDataTable .= '<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>';
                $tDataTable .= '</button>';
                $tDataTable .= "</div>";
                $tDataTable .= "</div>";
            // End PageNation page number
            endif; // End Check Total Page

            $tDataTable .= "</div>"; // end row pagenation
            $tDataTable .= "</div>";

            if ($CallBackType == 'S') {
                $tDataTable .= '<input type="text" id="oetCallBackVal" style="display:none" value="' . $tOldCallBackVal . '">';
                $tDataTable .= '<input type="text" id="oetCallBackText" style="display:none" value="' . $tOldCallBackText . '">';
            } else if ($CallBackType == 'M') {
                // $tDataTable .= "<div id='odvDataMultiSelection'>";
                // foreach ($aDataTable as $key => $val) {
                //     if (is_array($tOldCallBackVal)) {
                //         if (in_array($val->$tMasterPK, $tOldCallBackVal)) {
                //             $tCallBackTextColumn = explode('.', $oPtions['CallBack']['Text'][1]);
                //             $tNameFiledReturn    = $tCallBackTextColumn[1];
                //             $tDataTable         .= '<span class="olbVal' . $val->$tMasterPK . '" data-val="' . $val->$tMasterPK . '" data-text="' . $val->$tNameFiledReturn  . '"></span>';
                //         }
                //     }
                // }
                // $tDataTable .= "</div>";
            }
            echo $tDataTable;
        else :
            echo 'Error: Invarid Options';
        endif;

        if (isset($oPtions['DebugSQL'])) :
            if ($oPtions['DebugSQL'] == true) :
                /*echo $tSQL;*/
                echo $tFinalQuery;
            endif;
        endif;
    }




    public function FSvCallChrildren()
    {

        $tIDCurrent = '';
        $oPtions = $this->session->userdata('paOptions');
        $tValParent = $this->input->post('tValParent');
        $tValLevel = $this->input->post('tValLevel');


        if ($oPtions != '' || $oPtions != 'undefined') :

            $tLangPath = (isset($oPtions['Title'][0]) && !empty($oPtions['Title'][0])) ? $oPtions['Title'][0] : ''; // โฟลเดอร์ภาษา
            $bIssetTitlePath = (isset($oPtions['Title'][0]) && !empty($oPtions['Title'][0]));
            $tLangKey = $oPtions['Title'][1]; // Key ภาษา

            if ($bIssetTitlePath) {
                $tPopupTitle = language($tLangPath, $tLangKey); // Popup Title Bar
            } else {
                $tPopupTitle = $tLangKey; // Popup Title Bar
            }

            $tMasterTable   = $oPtions['Table']['Master']; // Master Table
            $tMasterPK      = $oPtions['Table']['PK']; // Master PK
            $tMasterChain      = $oPtions['Table']['Chain']; // MasterChain
            $tMasterLevel      = $oPtions['Table']['Level']; // MasterLevel
            $tMasterParent     = $oPtions['Table']['Parent']; // MasterParent
            @$tMasterPKName = $oPtions['Table']['PKName']; // Master PK
            $tMasterFK      = (isset($oPtions['Table']['FK'])) ? $oPtions['Table']['FK'] : ''; // Master PK
            $CallBackType   = $oPtions['CallBack']['ReturnType'];
            $tSearchFilter  = (isset($oPtions['SearchFilter'])) ? $oPtions['SearchFilter'] : '';

            $tColPk = $tMasterTable . "." . $tMasterPK;


            $tOptions = '';
            // Set Option by post
            if ($this->session->userdata('tOptions') != '') :
                $tOptions = $this->session->userdata('tOptions');
            else :
                echo 'Error: Do not set options';
                exit();
            endif;

            // Callback Value
            $tOldCallBackVal = $this->session->userdata('tCallVal');
            if (isset($tOldCallBackVal)) :
                $tOldCallBackVal = $tOldCallBackVal;
            else :
                $tOldCallBackVal = '';
            endif;

            // Callbac Text
            $tOldCallBackText = $this->session->userdata('tCallText');
            if (isset($tOldCallBackText)) :
                $tOldCallBackText = $tOldCallBackText;
            else :
                $tOldCallBackText = '';
            endif;

            // Callback Option
            if (isset($oPtions['CallBack']['Text'])) :
                $tCallBackTextColumn = explode('.', $oPtions['CallBack']['Text'][1]);
            else :
                $tCallBackTextColumn = '';
            endif;

            $tCallBackColumn = $tCallBackTextColumn[1];

            // Page Option
            // if ($oPtions['GrideView']['Perpage']) :
            //     $nPerPage = $oPtions['GrideView']['Perpage'];
            // else :
            //     $nPerPage = 5;
            // endif;

            // $aRowLen = FCNaHCallLenData($nPerPage, $nCurentPage); //Parameter [1] = Limit/Page [2] = PageNo

            // Order By Option
            $aOrderBy = $oPtions['GrideView']['OrderBy'];
            $tOrderBy = "";
            if (empty($aOrderBy) || !isset($aOrderBy)) {
                $tOrderBy = "$tColPk ASC";
            } else {
                $tOrderBy = implode(',', $aOrderBy);
            }

            // Init SQL
            $tSQL = "";
            $tSQL .= "SELECT Result.* FROM (";
            //Distinct
            if (isset($oPtions['GrideView']['DistinctField'])) {
                $aDistinct = $oPtions['GrideView']['DistinctField'];
            } else {
                $aDistinct = '';
            }

            if (isset($oPtions['GrideView']['StartRow'])) {
                $nStartRow = intval($oPtions['GrideView']['StartRow']);
            } else {
                $nStartRow = 0;
            }

            if ($aDistinct != '') {
                $aColumns = $oPtions['GrideView']['DataColumns'];
                $tTextResultShow = '';
                for ($i = 0; $i < FCNnHSizeOf($aColumns); $i++) {
                    $tTextShow = Explode('.', $aColumns[$i]);
                    $tTextResultShow .=  'ResultSubquery.' . $tTextShow[1] . ',';

                    //remove ,
                    if ($i == FCNnHSizeOf($aColumns) - 1) {
                        $tResultShow = substr($tTextResultShow, 0, -1);
                    }

                    //orderby
                    if ($i == $aDistinct[0]) {
                        $tOrderByDistinct = $tTextShow[1];
                    }
                }
                $tSQL .= "SELECT $nStartRow + ROW_NUMBER() OVER(ORDER BY ResultSubquery.$tOrderByDistinct) AS rtRowID , $tResultShow FROM ( SELECT ";
            } else {
                $tSQL .= "SELECT $nStartRow + ROW_NUMBER() OVER(ORDER BY $tOrderBy) AS rtRowID , ";
            }
            $tSQL .= "  (SELECT COUNT(*) FROM $tMasterTable TSUB WITH (NOLOCK) WHERE TSUB.$tMasterParent = $tMasterTable.$tMasterPK AND TSUB.$tMasterPK !=$tMasterTable.$tMasterPK ) AS rnStaChrl, ";
            // Select Column From Options
            if (isset($oPtions['GrideView'])) :
                if (isset($oPtions['GrideView']['DataColumns'])) :
                    $aColumns = $oPtions['GrideView']['DataColumns']; // Return Column

                    if (empty($aDistinct)) {
                        if (is_array($aColumns)) {
                            $tColumns = implode(',', $aColumns);
                            $tSQL .= " $tColumns ";
                        } else {
                            echo "Error:No column select.";
                            exit();
                        }
                    } else {
                        if (is_array($aColumns)) {
                            $tText = '';
                            for ($i = 0; $i < FCNnHSizeOf($aColumns); $i++) {
                                if (isset($aDistinct[$i])) {
                                    $tText .= 'DISTINCT(' . $aColumns[$i] . ')' . ',';
                                } else {
                                    $tText .= $aColumns[$i] . ',';
                                }
                                if ($i == FCNnHSizeOf($aColumns) - 1) {
                                    $tTextResult = substr($tText, 0, -1);
                                }
                            }
                            $tSQL .= " $tTextResult ";
                        } else {
                            echo "Error:No column select.";
                            exit();
                        }

                        //echo print_r($aDistinct[0]);
                    }
                else :
                    echo "Error:No column select.";
                    exit();
                endif;

            else :
                echo "Error: No column select.";
                exit();
            endif;
            // end select column

            $tSQL .= " FROM $tMasterTable "; // select from master table
            // Join Table if Has Join Options
            if (isset($oPtions['Join']['Table'])) :
                for ($j = 0; $j < FCNnHSizeOf($oPtions['Join']['Table']); $j++) {
                    if (isset($oPtions['Join']['SpecialJoin'])) {
                        // $tSQL .= " RIGHT JOIN " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                        $tSQL .= $oPtions['Join']['SpecialJoin'][0] . " " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                    } else {
                        $tSQL .= " LEFT JOIN " . $oPtions['Join']['Table'][$j] . " On " . $oPtions['Join']['On'][$j] . " ";
                    }
                }
            endif;

            /*if(isset($oPtions['GrideView']['WhereSearch'])):
                 $tWhereSearch = $oPtions['GrideView']['WhereSearch'];
             else:
                 $tWhereSearch = '';
             endif;*/

            $tSQL .= " WHERE 1=1 ";

            // Filter Data From Selector Browse
            // if (isset($oPtions['Filter'])) :
            //     $tFilter = $this->input->post('tFileter');
            //     if ($tFilter != '') :
            //         if ($oPtions['Filter']['Table'] != '' and $oPtions['Filter']['Key'] != '') :
            //             $tTableFilter = $oPtions['Filter']['Table'] . "." . $oPtions['Filter']['Key'];
            //             $tSQL .= " AND $tTableFilter = '" . $tFilter . "'";
            //         endif;
            //     endif;
            // endif;
     
            $tSQL .= " AND $tMasterTable.$tMasterParent = '" . $tValParent . "'";
            $tSQL .= " AND $tMasterTable.$tMasterLevel = '" . $tValLevel . "'";

            $tFilerGride = $this->input->post('tFilerGride'); // Filter Value
            // Filter Data From Filter Element
            if (isset($tFilerGride)) {
                if ($tFilerGride != '') {
                    //mos 21/01/2020 กรณีถ้าฟิวส์เป็นตัวเลข มันไม่ต้องใส่ collate thai_bin
                    if (isset($tColPk) && !empty($tColPk) && (strpos($tColPk, 'FN') == 0 || strpos($tColPk, 'FD') == 0)) {
                        $tSQL .= " AND ( $tColPk LIKE '%$tFilerGride%' ";
                    } else {
                        $tSQL .= " AND ( $tColPk COLLATE THAI_BIN LIKE '%$tFilerGride%' ";
                    }

                    for ($fc = 0; $fc < FCNnHSizeOf($oPtions['GrideView']['DataColumns']); $fc++) {
                        $tFilterCol = $oPtions['GrideView']['DataColumns'][$fc];

                        //mos 21/01/2020 กรณีถ้าฟิวส์เป็นตัวเลข มันไม่ต้องใส่ collate thai_bin
                        if (isset($tFilterCol) && !empty($tFilterCol) && (strpos($tFilterCol, 'FN') == 0 || strpos($tFilterCol, 'FD') == 0)) {
                            $tSQL .= "  OR $tFilterCol LIKE '%$tFilerGride%' ";
                        } else {
                            $tSQL .= "  OR $tFilterCol COLLATE THAI_BIN LIKE '%$tFilerGride%' ";
                        }
                    }
                    $tSQL .= " ) ";
                };
            };

            if (!empty($aDistinct)) {
                //WHERE
                // if (isset($oPtions['Where'])) :
                //     if ($oPtions['Where']['Condition']) :
                //         for ($w = 0; $w < FCNnHSizeOf($oPtions['Where']['Condition']); $w++) {
                //             $tSQL .= " " . $oPtions['Where']['Condition'][$w];
                //         }
                //     endif;
                // endif;
                $tSQL .= ' ) as ResultSubquery ';
            } else {
                //WHERE
                // if (isset($oPtions['Where'])) :
                //     if ($oPtions['Where']['Condition']) :
                //         for ($w = 0; $w < FCNnHSizeOf($oPtions['Where']['Condition']); $w++) {
                //             $tSQL .= " " . $oPtions['Where']['Condition'][$w];
                //         }
                //     endif;
                // endif;
            }

            $tSQL .= " ) AS Result ";

            $tFinalQuery = $tSQL;
      

            if (isset($oPtions['NotIn'])) :
                $tNotIn = $this->input->post('tNotIn');
                if ($tNotIn != '') :
                    if ($oPtions['NotIn']['Table'] != '' and $oPtions['NotIn']['Key'] != '') :
                        $tTableFilter = "Result" . "." . $oPtions['NotIn']['Key'];
                        $tFinalQuery .= " AND $tTableFilter NOT IN ('" . $tNotIn . "')";
                    endif;
                endif;
            endif;

            // echo $tSQL."<hr>";
            // echo $tFinalQuery."<hr>";

            $oQuery = $this->db->query($tFinalQuery);

            // Get Total Record From Query
            $nTotalRecord = ceil($this->FMnCBWSGetRecord($tSQL)); //Total Record From Qurey


            $aDataTable = $oQuery->result();

            // Display Grid Table
            // $tDataTable = "<div class='container'>";

            /* Fix By Krit 28/06/2018 */
            /* เพื่อเก็บ Route ก่อนหน้าที่มา จะได้เอาไปเช็คว่ามาจากหน้าอ่ะไร? */
            if (isset($oPtions['RouteFrom'])) {
                $tRouteFromName = $oPtions['RouteFrom'];
            } else {
                $tRouteFromName = 'EmptyRouteFrom';
            }

            if (isset($oPtions['RouteAddNew'])) {
                $tFormAddRouteName = $oPtions['RouteAddNew'];
            } else {
                $tFormAddRouteName = 'EmptyRoute';
            }

            $tInformation = language('common/main/main', 'tShowData');
            $tChoose = language('common/main/main', 'tModalAdvChoose');
            $tClose = language('common/main/main', 'tCMNClose');
            $tSearch = language('common/main/main', 'tPlaceholder');
            // Modal Header
            // $tDataTable = '
            //     <div class="modal-header xCNModalHead">
            //         <div class="row">
            //             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            //                 <label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;">' . $tInformation . ' : ' . $tPopupTitle . '</label>
            //             </div>
            //             <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
            //                 <button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmSelected(' . "'" . $tOptions . "'" . ')">' . $tChoose . '</button>
            //                 <button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal" onclick="JCNxClearValueInModal()">' . $tClose . '</button>
            //             </div>
            //         </div>
            //     </div>
            // ';

            // // Start Modal Body
            // $tDataTable .= '<div class="modal-body">';

            // $tDataTable .= '<div class="row">';

            // // Search bar
            // $tDataTable .= "<div class='col-xs-6 col-sm-6 col-md-5 col-lg-5'>";

            // if ($CallBackType == 'S') { // Display on Select Single Mode

     

            // $tDataTable .= "<div class='form-group'>";
            // $tDataTable .= "<div class='input-group'>";
            // $tDataTable .= '<input class="form-control oetTextFilter oetSearchTable" type="text" value="' . $tFilerGride . '" ' . $tOnKeyPress . ' autocomplete="off" placeholder="' . $tSearch . '">';
            // $tDataTable .= "<span class='input-group-btn'>";
            // $tDataTable .= '<button id="obtBrowseModalSearch" class="btn xCNBtnSearch" type="button" ' . $tOnClick . ' >';
            // $tDataTable .= '<i class="fa fa-search"></i>';
            // $tDataTable .= "</button>";
            // $tDataTable .= "</span>";
            // $tDataTable .= "</div>";
            // $tDataTable .= "</div>";
            // }

            // $tDataTable .= "</div>";

      


            // $tDataTable .= "</div>";

            // Grid Table
            // $tDataTable .= "<div class='row'>";
            // $tDataTable .= "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
            // $tDataTable .= "<div class='table-responsive'>";
            // $tDataTable .= "<table id='otbBrowserList' class='table table-striped' style='width:100%'>";
            // $tDataTable .= "<thead>";
     
            $tDataTable ='';
            $tDataInputHide = '';
            if ($oQuery->num_rows() > 0) :
                $nIdx = 0;
                $tRowActive = '';

                if ($tMasterFK != '') {
                    $tMasterPK = $tMasterFK;
                }

                foreach ($aDataTable as $key => $val) :

                    if ($tIDCurrent != $val->$tMasterPK) :

                        if (isset($oPtions['CallBack']['StaSingItem'])) {

                            if ($oPtions['CallBack']['StaSingItem'] == '1') {
                                $tIDCurrent = $val->$tMasterPK;
                            }
                        }

                        $tCallBackTextData = $val->$tCallBackColumn;
                        if ($CallBackType == 'S') :
                            if ($val->$tMasterPK === $tOldCallBackVal) {
                                if (isset($oPtions['CallBack']['StaDoc'])) {
                                    $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                    if ($CallBackStaDoc == 1) {
                                        $tRowActive = "xCNHide";
                                    } else {
                                        $tRowActive = "active  1 ";
                                    }
                                } else {
                                    $tRowActive = "active   2 ";
                                }
                            } else {
                                $tRowActive = "";
                            }

                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' ' . $tRowActive . ' xCNChain'.$val->$tMasterChain.' " data-code="'.$val->$tMasterPK.'"  data-chain="'.$val->$tMasterChain.'" data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushSelection(\'' . $val->$tMasterPK .'\',this , \'' . $tMasterTable . '\')" ondblclick="JCNxDoubleClickSelection(' . "'" . $val->$tMasterPK . "',this," . "'" . $tOptions . "'," . "'" . $tMasterTable . "' " . ')">';
                        elseif ($CallBackType == 'M') :
                            if (is_array($tOldCallBackVal)) {
                                if (in_array($val->$tMasterPK, $tOldCallBackVal)) {

                                    //Option Sta Doc
                                    if (isset($oPtions['CallBack']['StaDoc'])) {
                                        $CallBackStaDoc = $oPtions['CallBack']['StaDoc'];
                                        if (($CallBackStaDoc == 1) || ($CallBackStaDoc == 2)) {
                                            if ($CallBackStaDoc == 1) { // Hide for select
                                                $tRowActive = "xCNHide";
                                            }
                                            if ($CallBackStaDoc == 2) { // Show with unactive
                                                $tRowActive = "";
                                            }
                                        } else {
                                            $tRowActive = "active  3 ";
                                        }
                                    } else {
                                        $tRowActive = "active  4 ";
                                    }
                                } else {
                                    $tRowActive = "";
                                }
                            } else {
                                $tRowActive = "";
                            }

                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' ' . $tRowActive . ' xCNChain'.$val->$tMasterChain.' " data-code="'.$val->$tMasterPK.'" data-chain="'.$val->$tMasterChain.'" data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushMultiSelection(' . "'" . $val->$tMasterPK . "'," . htmlspecialchars(json_encode($tCallBackTextData), ENT_QUOTES, "UTF-8") . ",this" . ')">';
                        else :
                            $tDataTable .= '<tr class="xCNTextDetail2 xCNParent'.$val->$tMasterPK .' xCNChain'.$val->$tMasterChain.' " data-code="'.$val->$tMasterPK.'" data-chain="'.$val->$tMasterChain.'" data-level="'.$val->$tMasterLevel.'" onclick="JCNxPushSelection(' . "'" . $val->$tMasterPK . "',this , '" . $tMasterTable . "' " . ')" ondblclick="JCNxDoubleClickSelection(' . "'" . $val->$tMasterPK . "',this," . "'" . $tOptions . "'" . "'," . "'" . $tMasterTable . "' " . ')">';
                        endif;

                        if (isset($oPtions['NextFunc']['ArgReturn'])) :
                            //echo $oPtions['NextFunc']['ArgReturn'][0];
                            $aArgRet = array();
                            for ($g = 0; $g < FCNnHSizeOf($oPtions['NextFunc']['ArgReturn']); $g++) {
                                $tAgrCol = $oPtions['NextFunc']['ArgReturn'][$g];
                                $aArgRet[$g] = $val->$tAgrCol;
                            }

                            $tDataInputHide .=  "<input type='text' class='xCNKeepValue" . $val->$tMasterPK . "' style='display:none' id='ohdCallBackArg" . $val->$tMasterPK . $tMasterTable . "' value='" . json_encode($aArgRet) . "'" . ">";
                        endif;

                         $tDataInputHide .= "<input type='text' style='display:none' id='ohdCallBackText" . $val->$tMasterPK . $tMasterTable . "' value='" . $val->$tCallBackColumn . "'" . ">";

                        $tDataTable .= "</td>";
                        for ($f = 0; $f < FCNnHSizeOf($oPtions['GrideView']['DataColumns']); $f++) :

                            $aColumnVal = explode('.', $oPtions['GrideView']['DataColumns'][$f]);
                            $tColumnVal = $aColumnVal[1];

                            if (isset($oPtions['GrideView']['DataColumnsFormat'])) :
                                if (isset($oPtions['GrideView']['DataColumnsFormat'][$f])) :
                                    if ($oPtions['GrideView']['DataColumnsFormat'][$f] != '') :
                                        $aColumnFormat = explode(":", $oPtions['GrideView']['DataColumnsFormat'][$f]);
                                        $tFomatType = $aColumnFormat[0];
                                        $tFomatVal = $aColumnFormat[1];
                                    else :
                                        $tFomatType = '';
                                        $tFomatVal = '';
                                    endif;

                                    switch ($tFomatType) {
                                        case '':
                                            $tDataDisPlay = $val->$tColumnVal;
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Text':
                                            $tDataDisPlay = $this->JCNtFormatText($tFomatVal, $val->$tColumnVal);
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Date':
                                            $tDataDisPlay = $this->JCNtFormatDate($tFomatVal, $val->$tColumnVal);
                                            $tTextAlign = "left!important";
                                            break;

                                        case 'Currency':
                                            if (isset($aColumnFormat[2])) :
                                                $tCurrencySign = $aColumnFormat[2];
                                            else :
                                                $tCurrencySign = '&#3647;';
                                            endif;

                                            $tDataDisPlay = $this->JCNtFormatCurrency($tFomatVal, $val->$tColumnVal, $tCurrencySign);
                                            $tTextAlign = "right!important";
                                            break;

                                        case 'Number':
                                            $nDecumalShow = FCNxHGetOptionDecimalShow();
                                            $tDataDisPlay = number_format($val->$tColumnVal, $nDecumalShow);
                                            $tTextAlign = "right!important";
                                            break;

                                        default:
                                            $tDataDisPlay = $val->$tColumnVal;
                                            $tTextAlign = "left!important";
                                            break;
                                    }
                                else :

                                endif;
                            else :

                                $tDataDisPlay = $val->$tColumnVal;
                                $tTextAlign = "left!important";
                            endif;

                            $tSpcBar = '';

                            for($i=0;$i<=$tValLevel;$i++){
                         
                                    $tSpcBar .='&nbsp;&nbsp;&nbsp;&nbsp;';
                           
                            }

                            if (isset($oPtions['GrideView']['DisabledColumns'])) {
                                $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                if ($this->JCNtColDisabled($f, $oPtions['GrideView']['DisabledColumns']) == false) {
                                    if ($oPtions['GrideView']['DataColumns'][$f] == 'TFHMPdtSeason_L.FTSeaName') {
                                        if($val->rnStaChrl==0){
                                            $tDisplayNone = 'style="display:none"';
                                        }else{
                                            $tDisplayNone = '';
                                        }
                                        $tDataTable .= "<td style='text-align:$tTextAlign'><button  type='button' onclick='JSvCallListChainModal(this)' data-table='$tMasterTable' data-active='2'  data-parent='".$val->$tMasterPK."' data-level='".($val->$tMasterLevel+1)."' >".$tSpcBar."<i class='fa fa-angle-right' aria-hidden='true' $tDisplayNone  id='oeiIconParent".$val->$tMasterPK."'></i></button> " .$tColumnValue . "</td>";
                                    }else{
                                         $tDataTable .= "<td style='text-align:$tTextAlign'>" . $this->JCNtColChkNull($tDataDisPlay) . "</td>";
                                    }
                                }
                            } else {
                                //สำหรับข้อมูลตาราง TVDMShopType (Vending)
                                if ($oPtions['Table']['Master'] == 'TVDMShopType' && $oPtions['Table']['PK'] == 'FTShtCode') {
                                    if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 1) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending01');
                                    } else if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 2) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending02');
                                    } else if ($tColumnVal == 'FTShtType' && $tDataDisPlay == 3) {
                                        $tColumnValue = language('vending/vendingshoptype/vendingshoptype', 'tVstTypeVending03');
                                    } else {
                                        $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                    }
                                } else {
                                    //สำหรับข้อมูลทั่วไป
                                    $tColumnValue = $this->JCNtColChkNull($tDataDisPlay);
                                }
                                if($val->rnStaChrl==0){
                                    $tDisplayNone = 'style="display:none"';
                                }else{
                                    $tDisplayNone = '';
                                }
                                if ($oPtions['GrideView']['DataColumns'][$f] == 'TFHMPdtSeason_L.FTSeaName') {
                                    $tDataTable .= "<td style='text-align:$tTextAlign'><button  type='button' onclick='JSvCallListChainModal(this)'  data-table='$tMasterTable' data-active='2' data-parent='".$val->$tMasterPK."' data-level='".($val->$tMasterLevel+1)."'  ><i class='fa fa-angle-right' aria-hidden='true' $tDisplayNone  id='oeiIconParent".$val->$tMasterPK."'></i></button> " . $tColumnValue . "</td>";
                                } else {
                                    $tDataTable .= "<td style='text-align:$tTextAlign'>" . $tColumnValue ."</td>";
                                }
                            }

                        endfor;
                        $tDataTable .= "</tr>";
                        $nIdx++;
                    endif;
                endforeach;
            else :
                $nCountColData = FCNnHSizeOf($oPtions['GrideView']['DataColumns']);
                $nColspan = $nCountColData + 1;
                // $tDataTable .= "<tr><td colspan='" . $nColspan . "' style='text-align:center';>";
                // $tDataTable .= language('common/main/main', 'tCMNNotFoundData');
                // $tDataTable .= "</td></tr>";
            endif;

            // $tDataTable .= "</table>";
            // $tDataTable .= "</div>";
            // $tDataTable .= "</div>";
            // $tDataTable .= "</div>";

            // $tPageBoxStyle = 'margin-top: 10px;';
            // if ($CallBackType == 'M') {
            //     $tPageBoxStyle .= '';
            // }

            // Row Pagination
            // $tDataTable .= "<div class='row' style='$tPageBoxStyle'>";

            // PageNation show info
            // $nTotalPage = ceil($nTotalRecord / $nPerPage);

            // if ($nCurentPage == 1) :
            //     $nPrvPage = 1;
            // else :
            //     $nPrvPage = $nCurentPage - 1;
            // endif;

            // if ($nCurentPage == $nTotalPage) :
            //     $nNextPage = $nTotalPage;
            // else :
            //     $nNextPage = $nCurentPage + 1;
            // endif;

            // $tDataTable .= "<div class='col-xs-12 col-md-6'>";
            // $tDataTable .= language('common/main/main', 'tResultTotalRecord');
            // $tDataTable .= " " . number_format($nTotalRecord) . " ";
            // $tDataTable .= language('common/main/main', 'tRecord');
            // $tDataTable .= " ";
            // $tDataTable .= language('common/main/main', 'tCurrentPage');
            // $tDataTable .= " " . ($nCurentPage == "" ? "1" : $nCurentPage) . " / " . $nTotalPage;
            // $tDataTable .= "</div>";
            // // end page info

            // if ($nTotalPage > 0) :

            //     // PageNation page number
            //     if ($nCurentPage == 1) {
            //         $tDisabledLeft = 'disabled';
            //     } else {
            //         $tDisabledLeft = '';
            //     }
            //     $tDataTable .= "<div class='col-xs-12 col-md-6 text-right'>";
            //     $tDataTable .= '<div class="btn-toolbar pull-right">';
            //     $tDataTable .= '<button onclick="JCNxSearchBrowse(' . "'" . $nPrvPage . "'," . "'" . $tOptions . "'" . ')" class="btn btn-white btn-sm" ' . $tDisabledLeft . '>';
            //     $tDataTable .= '<i class="fa fa-chevron-left f-s-14 t-plus-1"></i>';
            //     $tDataTable .= '</button>';

            //     for ($p = 1; $p <= $nTotalPage; $p++) :
            //         if ($p == $nCurentPage) :
            //             $tActived = "active";
            //         else :
            //             $tActived = "";
            //         endif;
            //         if ($nCurentPage == 1) :
            //             $nStartPage = 1;
            //             $nEndPage = 3;
            //         else :
            //             if ($nCurentPage == $nTotalRecord) :
            //                 $nStartPage = $nTotalRecord - 2;
            //                 $nEndPage = $nTotalRecord;
            //             else :
            //                 $nStartPage = $nCurentPage - 1;
            //                 $nEndPage = $nCurentPage + 1;
            //             endif;
            //         endif;
            //         if ($p >= $nStartPage and $p <= $nEndPage) :
            //             $tDataTable .= '<button onclick="JCNxSearchBrowse(' . $p . ",'" . $tOptions . "'" . ')" type="button" class="page-item btn xCNBTNNumPagenation" ' . $tActived . '">' . $p . '</button>';
            //         endif;
            //     endfor;
            //     // End Page Number

            //     if ($nCurentPage >= $nTotalPage) {
            //         $tDisabledRight = 'disabled';
            //     } else {
            //         $tDisabledRight = '';
            //     }
            //     $tDataTable .= '<button onclick="JCNxSearchBrowse(' . "'" . $nNextPage . "'," . "'" . $tOptions . "'" . ')" class="btn btn-white btn-sm" ' . $tDisabledRight . '>';
            //     $tDataTable .= '<i class="fa fa-chevron-right f-s-14 t-plus-1"></i>';
            //     $tDataTable .= '</button>';
            //     $tDataTable .= "</div>";
            //     $tDataTable .= "</div>";
            // // End PageNation page number
            // endif; // End Check Total Page

            // $tDataTable .= "</div>"; // end row pagenation
            // $tDataTable .= "</div>";

            if ($CallBackType == 'S') {
                // $tDataTable .= '<input type="text" id="oetCallBackVal" style="display:none" value="' . $tOldCallBackVal . '">';
                // $tDataTable .= '<input type="text" id="oetCallBackText" style="display:none" value="' . $tOldCallBackText . '">';
            } else if ($CallBackType == 'M') {
                // $tDataTable .= "<div id='odvDataMultiSelection'>";
                // foreach ($aDataTable as $key => $val) {
                //     if (is_array($tOldCallBackVal)) {
                //         if (in_array($val->$tMasterPK, $tOldCallBackVal)) {
                //             $tCallBackTextColumn = explode('.', $oPtions['CallBack']['Text'][1]);
                //             $tNameFiledReturn    = $tCallBackTextColumn[1];
                //             $tDataTable         .= '<span class="olbVal' . $val->$tMasterPK . '" data-val="' . $val->$tMasterPK . '" data-text="' . $val->$tNameFiledReturn  . '"></span>';
                //         }
                //     }
                // }
                // $tDataTable .= "</div>";
            }
                $aResult = array(
                    'tDataInputHide' => $tDataInputHide,
                    'tDataTable' => $tDataTable,
                );
            echo json_encode($aResult);
        else :
            echo 'Error: Invarid Options';
        endif;

        if (isset($oPtions['DebugSQL'])) :
            if ($oPtions['DebugSQL'] == true) :
                /*echo $tSQL;*/
                echo $tFinalQuery;
            endif;
        endif;
    }


    private function FMnCBWSGetRecord($ptQuery)
    {
        $oQuery = $this->db->query($ptQuery);
        return $oQuery->num_rows();
    }

    private function JCNtFormatText($paFomatSetVal, $ptOriData)
    {
        if ($paFomatSetVal != '') :
            return substr($ptOriData, 0, $paFomatSetVal);
        else :
            return $ptOriData;
        endif;
    }

    private function JCNtFormatDate($paFomatSetVal, $ptOriData)
    {
        if ($paFomatSetVal != '') :
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

        else :
            return $ptOriData;
        endif;
    }

    private function JCNtFormatCurrency($paFomatSetVal, $ptOriData, $ptCurrencySign)
    {
        if ($paFomatSetVal != '') :
            $cCurrency = number_format($ptOriData, $paFomatSetVal);
            return $ptCurrencySign . ' ' . $cCurrency;
        else :
            $cCurrency = number_format($ptOriData);
            return $ptCurrencySign . ' ' . $cCurrency;
        endif;
    }

    private function JCNtColDisabled($pnInx, $paDisable)
    {
        if (in_array($pnInx, $paDisable)) {
            return true;
        } else {
            return false;
        }
    }

    private function JCNtColChkNull($ptData)
    {
        if ($ptData != '' || $ptData != null) {
            return $ptData;
        } else {
            return '-';
        }
    }




}
