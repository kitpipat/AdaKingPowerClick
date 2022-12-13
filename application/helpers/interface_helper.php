<?php

    function FCNtHShwCondition($paPackData){
        $ci = &get_instance();
        $ci->load->library('session');

        $tReturn        = "";
        $tApiPK         = $paPackData['tApiPK'];

        if($ci->session->userdata("tSesUsrLevel") == "HQ"){
            $tDisabled = "";
        }else{
            $nCountBch = $ci->session->userdata("nSesUsrBchCount");
            if($nCountBch == 1){
                $tDisabled = "disabled";
            }else{
                $tDisabled = "";
            }
        }

        $tUserBchCode   = $ci->session->userdata("tSesUsrBchCodeDefault");
	    $tUserBchName   = $ci->session->userdata("tSesUsrBchNameDefault");

        switch($paPackData['tConditionType']){
            case 'Branch':
                $tReturn = '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.language('company/branch/branch', 'tBCHTitle').'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div id="odvCondition1" class="row">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <div class="input-group">';
                $tReturn .= '                        <input class="form-control xCNHide" id="oetIFXBchCode'.$tApiPK.'" name="oetIFXBchCode'.$tApiPK.'" maxlength="5" value="'.$tUserBchCode.'">';
                $tReturn .= '                        <input class="form-control xWPointerEventNone" type="text" id="oetIFXBchName'.$tApiPK.'" name="oetIFXBchName'.$tApiPK.'" value="'.$tUserBchName.'" readonly>';
                $tReturn .= '                        <span class="input-group-btn">';
                $tReturn .= '                            <button id="obtIFXBrowseBch'.$tApiPK.'" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" '.$tDisabled.'>';
                $tReturn .= '                                <img src="'.base_url('application/modules/common/assets/images/icons/find-24.png').'">';
                $tReturn .= '                            </button>';
                $tReturn .= '                        </span>';
                $tReturn .= '                    </div>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';
                $tReturn .= '        </div>';
                $tReturn .= '    </div>';
                $tReturn .= '</div>';
                $tReturn .= '';
                $tReturn .= '<script>';
                $tReturn .= '    $("#obtIFXBrowseBch'.$tApiPK.'").off("click").on("click",function(){';
                $tReturn .= '        window.oITFXBrowseBch = undefined;';
                $tReturn .= '        oITFXBrowseBch        = oITFXBrowseBchOption({';
                $tReturn .= '            "tReturnInputCode"  : "oetIFXBchCode'.$tApiPK.'",';
                $tReturn .= '            "tReturnInputName"  : "oetIFXBchName'.$tApiPK.'",';
                $tReturn .= '        });';
                $tReturn .= '        JCNxBrowseData("oITFXBrowseBch");';
                $tReturn .= '    });';
                $tReturn .= '</script>';
                break;
            case 'Warehouse':

                if( isset($paPackData['tWahType']) && !empty($paPackData['tWahType']) ){
                    $tWahType = $paPackData['tWahType'];
                }else{
                    $tWahType = "ALL";
                }

                $tReturn = '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.language('company/warehouse/warehouse', 'tWAHTitle').'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div id="odvCondition10" class="row">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <div class="input-group">';
                $tReturn .= '                        <input class="form-control xCNHide" id="oetIFXWahCode'.$tApiPK.'" name="oetIFXWahCode'.$tApiPK.'" maxlength="5" >';
                $tReturn .= '                        <input class="form-control xWPointerEventNone" type="text" id="oetIFXWahName'.$tApiPK.'" name="oetIFXWahName'.$tApiPK.'" readonly>';
                $tReturn .= '                        <span class="input-group-btn">';
                $tReturn .= '                            <button id="obtIFXBrowseWah'.$tApiPK.'" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess">';
                $tReturn .= '                                <img src="'.base_url('application/modules/common/assets/images/icons/find-24.png').'">';
                $tReturn .= '                            </button>';
                $tReturn .= '                        </span>';
                $tReturn .= '                    </div>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';
                $tReturn .= '        </div>';
                $tReturn .= '    </div>';
                $tReturn .= '</div>';
                $tReturn .= '';
                $tReturn .= '<script>';
                $tReturn .= '   $("#obtIFXBrowseWah'.$tApiPK.'").off("click").on("click",function(){';
                $tReturn .= '       window.oITFXBrowseWah'.$tApiPK.' = undefined;';
                $tReturn .= '       oITFXBrowseWah'.$tApiPK.'      = oITFXBrowseWahOption({';
                $tReturn .= '           "tIFXBchCode"		: $("#oetIFXBchCode'.$tApiPK.'").val(),';
                $tReturn .= '           "tIFXWahType"		: "'.$tWahType.'",';
                $tReturn .= '           "tReturnInputCode"  : "oetIFXWahCode'.$tApiPK.'",';
                $tReturn .= '           "tReturnInputName"  : "oetIFXWahName'.$tApiPK.'",';
                $tReturn .= '       });';
                $tReturn .= '       JCNxBrowseData("oITFXBrowseWah'.$tApiPK.'");';
                $tReturn .= '   });';
                $tReturn .= '</script>';
                break;
            case 'Pos':

                if( isset($paPackData['tPosType']) && !empty($paPackData['tPosType']) ){
                    $tPosType = $paPackData['tPosType'];
                    switch($tPosType){
                        case '4':
                            $tPosName = language('company/shop/shop', 'tShpType4');
                            break;
                        default:
                            $tPosName = language('company/shop/shop', 'tNameTabPosshop');
                    }
                }else{
                    $tPosType = "ALL";
                    $tPosName = language('company/shop/shop', 'tNameTabPosshop');
                }

                $tReturn = '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.$tPosName.'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div id="odvCondition2" class="row">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <div class="input-group">';
                $tReturn .= '                        <input class="form-control xCNHide" id="oetIFXPosCode'.$tApiPK.'" name="oetIFXPosCode'.$tApiPK.'" maxlength="5" >';
                $tReturn .= '                        <input class="form-control xWPointerEventNone" type="text" id="oetIFXPosName'.$tApiPK.'" name="oetIFXPosName'.$tApiPK.'" readonly>';
                $tReturn .= '                        <span class="input-group-btn">';
                $tReturn .= '                            <button id="obtIFXBrowsePos'.$tApiPK.'" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" >';
                $tReturn .= '                                <img src="'.base_url('application/modules/common/assets/images/icons/find-24.png').'">';
                $tReturn .= '                            </button>';
                $tReturn .= '                        </span>';
                $tReturn .= '                    </div>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';
                $tReturn .= '        </div>';
                $tReturn .= '    </div>';
                $tReturn .= '</div>';
                $tReturn .= '';
                $tReturn .= '<script>';
                $tReturn .= '    $("#obtIFXBrowsePos'.$tApiPK.'").off("click").on("click",function(){';
                $tReturn .= '        window.oITFXBrowsePos'.$tApiPK.' = undefined;';
                $tReturn .= '        oITFXBrowsePos'.$tApiPK.'      = oITFXBrowsePosOption({';
                $tReturn .= '            "tIFXBchCode"		 : $("#oetIFXBchCode'.$tApiPK.'").val(),';
                $tReturn .= '            "tIFXPosType"		 : "'.$tPosType.'",';
                $tReturn .= '            "tReturnInputCode"  : "oetIFXPosCode'.$tApiPK.'",';
                $tReturn .= '            "tReturnInputName"  : "oetIFXPosName'.$tApiPK.'",';
                $tReturn .= '        });';
                $tReturn .= '        JCNxBrowseData("oITFXBrowsePos'.$tApiPK.'");';
                $tReturn .= '    });';
                $tReturn .= '</script>';
                break;
            case 'Date':
                $dCurrentDate       = date('Y-m-d');
                $tConditionFromTo   = $paPackData['tConditionFromTo'];

                $tReturn = '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.language('interface/interfaceexport/interfaceexport','tITFXFilterDate').'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div id="odvCondition3" class="row">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <div class="input-group">';
                $tReturn .= '                        <input type="text" value="'.$dCurrentDate.'" class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateFrom'.$tApiPK.'" name="oetITFXDateFrom'.$tApiPK.'" maxlength="10">';
                $tReturn .= '                        <span class="input-group-btn">';
                $tReturn .= '                            <button id="obtITFXDateFrom'.$tApiPK.'" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>';
                $tReturn .= '                        </span>';
                $tReturn .= '                    </div>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';
                
                if( $tConditionFromTo ){
                    $tReturn .= '            <div class="col-lg-1">';
                    $tReturn .= '                <p class="xCNTextTo">'.language('interface/interfaceexport/interfaceexport','tITFXFilterTo').'</p>';
                    $tReturn .= '            </div>';
                    $tReturn .= '            <div class="col-lg-5">';
                    $tReturn .= '                <div class="form-group">';
                    $tReturn .= '                    <div class="input-group">';
                    $tReturn .= '                        <input type="text"value="'.$dCurrentDate.'" class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateTo'.$tApiPK.'" name="oetITFXDateTo'.$tApiPK.'" maxlength="10">';
                    $tReturn .= '                        <span class="input-group-btn">';
                    $tReturn .= '                            <button id="obtITFXDateTo'.$tApiPK.'" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>';
                    $tReturn .= '                        </span>';
                    $tReturn .= '                    </div>';
                    $tReturn .= '                </div>';
                    $tReturn .= '            </div>';
                }
                
                $tReturn .= '        </div>';
                $tReturn .= '    </div>';
                $tReturn .= '</div>';

                $tReturn .= '<script>';
                $tReturn .= '$("#obtITFXDateFrom'.$tApiPK.'").off("click").on("click",function(){';
                $tReturn .= '    $("#oetITFXDateFrom'.$tApiPK.'").datepicker("show");';
                $tReturn .= '});';
                
                if( $tConditionFromTo ){
                    $tReturn .= '$("#oetITFXDateFrom'.$tApiPK.'").on("change",function(){';
                    $tReturn .= '    if( $("#oetITFXDateTo'.$tApiPK.'").val() == "" ){';
                    $tReturn .= '        $("#oetITFXDateTo'.$tApiPK.'").val($("#oetITFXDateFrom'.$tApiPK.'").val());';
                    $tReturn .= '    }';
                    $tReturn .= '});';
                    $tReturn .= '$("#obtITFXDateTo'.$tApiPK.'").off("click").on("click",function(){';
                    $tReturn .= '    $("#oetITFXDateTo'.$tApiPK.'").datepicker("show");';
                    $tReturn .= '});';
                    $tReturn .= '$("#oetITFXDateTo'.$tApiPK.'").on("change",function(){';
                    $tReturn .= '    if( $("#oetITFXDateFrom'.$tApiPK.'").val() == "" ){';
                    $tReturn .= '        $("#oetITFXDateFrom'.$tApiPK.'").val($("#oetITFXDateTo'.$tApiPK.'").val());';
                    $tReturn .= '    }';
                    $tReturn .= '});';
                }

                $tReturn .= '</script>';
                break;
            case 'Browse':

                $tConditionFromTo   = $paPackData['tConditionFromTo'];
                $tBrowseTable       = $paPackData['tBrowseTable'];
                $tBrowseType        = $paPackData['tBrowseType'];
                $tBrowseCondition   = $paPackData['tBrowseCondition'];
                
                $tReturn .= '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.language('interface/interfaceexport/interfaceexport','tITFXFilterDocSal').'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <div class="input-group">';
                $tReturn .= '                        <input type="text" class="form-control xWRptAllInput" id="oetIFXCodeFrom'.$tApiPK.'" name="oetIFXCodeFrom'.$tApiPK.'" readonly>';
                $tReturn .= '                        <span class="input-group-btn">';
                $tReturn .= '                            <button id="obtIFXBrowseFrom'.$tApiPK.'" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                $tReturn .= '                        </span>';
                $tReturn .= '                    </div>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';

                if( $tConditionFromTo ){
                    $tReturn .= '            <div class="col-lg-1">';
                    $tReturn .= '                <p class="xCNTextTo">'.language('interface/interfaceexport/interfaceexport','tITFXFilterTo').'</p>';
                    $tReturn .= '            </div>';
                    $tReturn .= '            <div class="col-lg-5">';
                    $tReturn .= '                <div class="form-group">';
                    $tReturn .= '                    <div class="input-group">';
                    $tReturn .= '                        <input type="text" class="form-control xWRptAllInput" id="oetIFXCodeTo'.$tApiPK.'" name="oetIFXCodeTo'.$tApiPK.'" readonly>';
                    $tReturn .= '                        <span class="input-group-btn">';
                    $tReturn .= '                            <button id="obtIFXBrowseTo'.$tApiPK.'" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                    $tReturn .= '                        </span>';
                    $tReturn .= '                    </div>';
                    $tReturn .= '                </div>';
                    $tReturn .= '            </div>';
                    $tReturn .= '        </div>';
                    $tReturn .= '    </div>';
                    $tReturn .= '</div>';
                }

                if( $tBrowseTable == 'TPSTSalHD' ){
                    $tReturn .= '<script>';
                    $tReturn .= '$("#obtIFXBrowseFrom'.$tApiPK.'").off("click").on("click",function(){';
                    $tReturn .= '    window.oIFXBrowseFrom'.$tApiPK.' = undefined;';
                    $tReturn .= '    oIFXBrowseFrom'.$tApiPK.'  = oITFXBrowseSaleOption({';
                    $tReturn .= '        "tTFXSaleBchCode"   	: $("#oetIFXBchCode'.$tApiPK.'").val(),';
                    $tReturn .= '        "tTFXSaleWahCode"   	: $("#oetIFXWahCode'.$tApiPK.'").val(),';
                    $tReturn .= '        "tTFXSalePosCode"   	: $("#oetIFXPosCode'.$tApiPK.'").val(),';
                    $tReturn .= '        "tTFXDocType"			: $("#ocmITFXDocType'.$tApiPK.'").val(),';
                    $tReturn .= '        "tTFXSaleType"			: "'.$tBrowseType.'",';
                    $tReturn .= '        "tTFXSaleDocDateFrom"  : $("#oetITFXDateFrom'.$tApiPK.'").val(),';
                    $tReturn .= '        "tTFXSaleDocDateTo"   	: $("#oetITFXDateTo'.$tApiPK.'").val(),';
                    $tReturn .= '        "tReturnInputCode"  	: "oetIFXCodeFrom'.$tApiPK.'",';
                    $tReturn .= '        "tReturnInputName"  	: "oetIFXCodeFrom'.$tApiPK.'",';
                    $tReturn .= '    });';
                    $tReturn .= '    JCNxBrowseData("oIFXBrowseFrom'.$tApiPK.'");';
                    $tReturn .= '});';

                    if( $tConditionFromTo ){
                        $tReturn .= '$("#obtIFXBrowseTo'.$tApiPK.'").off("click").on("click",function(){';
                        $tReturn .= '    window.oIFXBrowseTo'.$tApiPK.' = undefined;';
                        $tReturn .= '    oIFXBrowseTo'.$tApiPK.'    = oITFXBrowseSaleOption({';
                        $tReturn .= '        "tTFXSaleBchCode"   	: $("#oetIFXBchCode'.$tApiPK.'").val(),';
                        $tReturn .= '        "tTFXSaleWahCode"   	: $("#oetIFXWahCode'.$tApiPK.'").val(),';
                        $tReturn .= '        "tTFXSalePosCode"   	: $("#oetIFXPosCode'.$tApiPK.'").val(),';
                        $tReturn .= '        "tTFXDocType"			: $("#ocmITFXDocType'.$tApiPK.'").val(),';
                        $tReturn .= '        "tTFXSaleType"			: "'.$tBrowseType.'",';
                        $tReturn .= '        "tTFXSaleDocDateFrom"  : $("#oetITFXDateFrom'.$tApiPK.'").val(),';
                        $tReturn .= '        "tTFXSaleDocDateTo"   	: $("#oetITFXDateTo'.$tApiPK.'").val(),';
                        $tReturn .= '        "tReturnInputCode"  	: "oetIFXCodeTo'.$tApiPK.'",';
                        $tReturn .= '        "tReturnInputName"  	: "oetIFXCodeTo'.$tApiPK.'",';
                        $tReturn .= '    });';
                        $tReturn .= '    JCNxBrowseData("oIFXBrowseTo'.$tApiPK.'");';
                        $tReturn .= '});';
                    }

                    $tReturn .= '</script>';
                }
                break;
            case 'DocType':
                $tReturn .= '<div class="row">';
                $tReturn .= '    <div class="col-md-2">'.language('interface/interfaceexport/interfaceexport','tITFXFilterType').'</div>';
                $tReturn .= '    <div class="col-md-10">';
                $tReturn .= '        <div id="odvCondition6" class="row">';
                $tReturn .= '            <div class="col-lg-5">';
                $tReturn .= '                <div class="form-group">';
                $tReturn .= '                    <select class="selectpicker form-control" id="ocmITFXDocType'.$tApiPK.'" name="ocmITFXDocType'.$tApiPK.'">';
                $tReturn .= '                        <option value="1">'.language('interface/interfacehistory','tITFXFilterTypeSal').'</option>';
                $tReturn .= '                        <option value="9">'.language('interface/interfacehistory','tITFXFilterTypeRe').'</option>';
                $tReturn .= '                    </select>';
                $tReturn .= '                </div>';
                $tReturn .= '            </div>';
                $tReturn .= '            <div class="col-lg-1"></div>';
                $tReturn .= '            <div class="col-lg-5"></div>';
                $tReturn .= '        </div>';
                $tReturn .= '    </div>';
                $tReturn .= '</div>';
                break;
        }
        return $tReturn;
    }

?>