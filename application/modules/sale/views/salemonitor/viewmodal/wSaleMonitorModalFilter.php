<div id="odvSMTSALModalFilter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:50%;margin:1.75rem auto;left:2%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight:bold;font-size:20px;"><?php echo @$aTextLang['tSMTSALModalTitleFilter'];?></label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="ofmSMTSALFormFilter" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="ohdSMTSALFilterKey" name="ohdSMTSALFilterKey" value="<?php echo @$tFilterDataKey;?>">
                    <div class="row">
                        <?php if(isset($aFilterDataGrp) && !empty($aFilterDataGrp)): ?> 
                            <?php foreach($aFilterDataGrp AS $nKey => $tKeyGrpFilter): ?>
                                <?php
                                    $tTextFilter    = "";
                                    switch($tKeyGrpFilter){
                                        case 'BCH' : {
                                            // ฟิวเตอร์ สาขา
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalBranch'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterBchCodeCount" name="oetSMTSALFilterBchCodeCount">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterBchStaAll" name="oetSMTSALFilterBchStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterBchCode" name="oetSMTSALFilterBchCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterBchName" name="oetSMTSALFilterBchName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALFilterBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';

                                            break;
                                        }
                                        case 'MER' : {
                                            // ฟิวเตอร์ กลุ่มธุรกิจ
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group">';
                                            // $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalMerchant'].'</label>';
                                            // $tTextFilter    .= '<div class="input-group">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterMerStaAll" name="oetSMTSALFilterMerStaAll">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterMerCode" name="oetSMTSALFilterMerCode">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterMerName" name="oetSMTSALFilterMerName" readonly>';
                                            // $tTextFilter    .= '<span class="input-group-btn">';
                                            // $tTextFilter    .= '<button id="obtSMTSALFilterMer" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            // $tTextFilter    .= '</span>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'SHP' : {
                                            // ฟิวเตอร์ ร้านค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalShop'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterShpStaAll" name="oetSMTSALFilterShpStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterShpCode" name="oetSMTSALFilterShpCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterShpName" name="oetSMTSALFilterShpName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALFilterShp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'POS' : {
                                            // ฟิวเตอร์ จุดขาย
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalPos'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPosStaAll" name="oetSMTSALFilterPosStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPosCode" name="oetSMTSALFilterPosCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterPosName" name="oetSMTSALFilterPosName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALFilterPos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'WAH' : {
                                            // ฟิวเตอร์ คลังสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalWah'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterWahStaAll" name="oetSMTSALFilterWahStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterWahCode" name="oetSMTSALFilterWahCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterWahName" name="oetSMTSALFilterWahName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALFilterWah" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'PDT' : {
                                            // ฟิวเตอร์ สินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalProduct'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPdtStaAll" name="oetSMTSALFilterPdtStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPdtCode" name="oetSMTSALFilterPdtCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterPdtName" name="oetSMTSALFilterPdtName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALBrowsePdt" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'RCV' : {
                                            // ฟิวเตอร์ ประเภทการชำระ
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalRecive'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterRcvStaAll" name="oetSMTSALFilterRcvStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterRcvCode" name="oetSMTSALFilterRcvCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterRcvName" name="oetSMTSALFilterRcvName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALBrowseRcv" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'PGP' : {
                                            // ฟิวเตอร์ กลุ่มสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalPdtGrp'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPgpStaAll" name="oetSMTSALFilterPgpStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPgpCode" name="oetSMTSALFilterPgpCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterPgpName" name="oetSMTSALFilterPgpName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALBrowsePgp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'PTY' : {
                                            // ฟิวเตอร์ ประเภทสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalPdtPty'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPtyStaAll" name="oetSMTSALFilterPtyStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterPtyCode" name="oetSMTSALFilterPtyCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterPtyName" name="oetSMTSALFilterPtyName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALBrowsePty" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'APT' : {
                                            // ประเภทระบบ
                                            // $tTextFilter    .= '<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">';
                                            // $tTextFilter    .= '<div class="form-group">';
                                            // $tTextFilter    .= '<div class="row">';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            // $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalAppType'].'</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbSMTSALAppType[]" value="1" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tSMTSALModalAppType1'].'</span';
                                            // $tTextFilter    .= '</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbSMTSALAppType[]" value="2" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tSMTSALModalAppType2'].'</span';
                                            // $tTextFilter    .= '</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbSMTSALAppType[]" value="3" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tSMTSALModalAppType3'].'</span';
                                            // $tTextFilter    .= '</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'SCT' : {
                                            // สถานะลูกค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalStatusCst'].'</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaCst" name="orbSMTSALStaCst" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusAll'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaCst" name="orbSMTSALStaCst" value="1">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusCst1'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaCst" name="orbSMTSALStaCst" value="2">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusCst2'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'SRC' : {
                                            // สถาณะการชำระ
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalStatusPayment'].'</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaPayment" name="orbSMTSALStaPayment" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusAll'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaPayment" name="orbSMTSALStaPayment" value="1">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusPayment1'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWSMTSALStaPayment" name="orbSMTSALStaPayment" value="2">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tSMTSALModalStatusPayment2'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'TLM' : {
                                            // Top Limit
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tSMTSALModalTopLimit'].'</label>';
                                            $tTextFilter    .= '<select class="form-control selectpicker" id="ocmSMTSALFilterTopLimit" name="ocmSMTSALFilterTopLimit">';
                                            $tTextFilter    .= '<option value="5">5</option>';
                                            $tTextFilter    .= '<option value="10">10</option>';
                                            $tTextFilter    .= '<option value="15">15</option>';
                                            $tTextFilter    .= '<option value="20">20</option>';
                                            $tTextFilter    .= '</select>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                        }
                                        case 'USR' : {
                                            // ฟิวเตอร์ แคชเชียร์
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">แคชเชียร์</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterUsrStaAll" name="oetSMTSALFilterUsrStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetSMTSALFilterUsrCode" name="oetSMTSALFilterUsrCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetSMTSALFilterUsrName" name="oetSMTSALFilterUsrName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtSMTSALBrowseUsr" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    }
                                    echo $tTextFilter;
                                ?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="obtSMTSALCloseFilter"   type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo @$aTextLang['tSMTSALModalBtnCancel'];?></button>
                        <button id="obtSMTSALConfirmFilter" type="button" class="btn btn-primary"><?php echo @$aTextLang['tSMTSALModalBtnSave'];?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $(document).ready(function () {


        // var tFilterBchCode = $('#ohdSMTSALSessionBchCode').val();
        // var tFilterBchName = $('#ohdSMTSALSessionBchName').val();
        // if(tFilterBchCode!=''){
        //         $('#oetSMTSALFilterBchCode').val(tFilterBchCode);
        //         $('#oetSMTSALFilterBchName').val(tFilterBchName);
        //         $('#obtSMTSALFilterShp').attr('disabled',false);
        //         $('#obtSMTSALFilterPos').attr('disabled',false);
        //         $('#obtSMTSALFilterBch').attr('disabled',true);
        //     }else{
        //         $('#obtSMTSALFilterShp').attr('disabled',true);
        //         $('#obtSMTSALFilterPos').attr('disabled',true);
        //         $('#obtSMTSALFilterBch').attr('disabled',false);      
            
        // }

        // Option Select Picker
        $('.selectpicker').selectpicker();

        // Event Click Confirm Filter
        $('#odvSMTSALModalFilter #obtSMTSALConfirmFilter').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
                const tFilterKey    = $('#odvSMTSALModalFilter #ohdSMTSALFilterKey').val();
                JCNxSMTSALConfirmFilter(tFilterKey);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Branch
        $('#odvSMTSALModalFilter #obtSMTSALFilterBch').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu

                                // ********** Check Data Branch **********
                let tTextWhereInBranch      = '';
                if($('#odhnSesUsrBchCount').val() >= 1){
                    var tDataBranch = "<?=$this->session->userdata('tSesUsrBchCodeMulti')?>";
                    tTextWhereInBranch      = ' AND (TCNMBranch.FTBchCode IN ('+tDataBranch+'))';
                }

                window.oSMTSALBrowseBchOption   = undefined;
                oSMTSALBrowseBchOption          = {
                    Title   : ['company/branch/branch','tBCHTitle'],
                    Table   : {Master:'TCNMBranch',PK:'FTBchCode'},
                    Join    : {
                        Table   : ['TCNMBranch_L'],
                        On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                    },
                    Where :{
                        Condition : [tTextWhereInBranch]
                    },
                    GrideView:{
                        ColumnPathLang  	: 'company/branch/branch',
                        ColumnKeyLang	    : ['tBCHCode','tBCHName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMBranch_L.FTBchCode ASC'],
                    },
                    NextFunc:{
                        FuncName:'JSxSMTSetBrowsShopPos',
                        ArgReturn:['FTBchCode']
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterBchStaAll'],
                        Value		: ['oetSMTSALFilterBchCode','TCNMBranch.FTBchCode'],
                        Text		: ['oetSMTSALFilterBchName','TCNMBranch_L.FTBchName']
                    },
           
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        


        // Event Click Browse Multi Merchant
        $('#odvSMTSALModalFilter #obtSMTSALFilterMer').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowseMerOption   = undefined;
                oSMTSALBrowseMerOption          = {
                    Title   : ['company/merchant/merchant','tMerchantTitle'],
                    Table   : {Master:'TCNMMerchant',PK:'FTMerCode'},
                    Join    : {
                        Table   : ['TCNMMerchant_L'],
                        On      : ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = '+nLangEdits]
                    },
                    GrideView: {
                        ColumnPathLang	    : 'company/merchant/merchant',
                        ColumnKeyLang	    : ['tMerCode','tMerName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TCNMMerchant.FTMerCode','TCNMMerchant_L.FTMerName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMMerchant.FTMerCode ASC'],
                    },
                    CallBack: {
                        StausAll    : ['oetSMTSALFilterMerStaAll'],
                        Value       : ['oetSMTSALFilterMerCode','TCNMMerchant.FTMerCode'],
                        Text        : ['oetSMTSALFilterMerName','TCNMMerchant_L.FTMerName'],
                    },
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseMerOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Shop
        $('#odvSMTSALModalFilter #obtSMTSALFilterShp').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                var tDataBranch     = $('#oetSMTSALFilterBchCode').val();
                let tDataMerchant   = $('#oetSMTSALFilterMerCode').val();

                // ********** Check Data Branch **********
                let tTextWhereInBranch      = '';
                if(tDataBranch != ''){
                    var tDataBranch = tDataBranch.replace(",","','");
                    tTextWhereInBranch      = ' AND (TCNMShop.FTBchCode IN ('+tDataBranch+'))';
                }

                // ********** Check Data Merchant **********s
                let tTextWhereInMerchant    = '';
                if(tDataMerchant != '' && tDataMerchant != undefined){
                    tTextWhereInMerchant    = ' AND (TCNMShop.FTMerCode IN ('+tDataMerchant+'))';
                }

                window.oSMTSALBrowseShpOption   = undefined;
                oSMTSALBrowseShpOption          = {
                    Title   : ['company/shop/shop','tSHPTitle'],
                    Table   : {Master:'TCNMShop', PK:'FTShpCode'},
                    Join    : {
                        Table   : ['TCNMShop_L', 'TCNMBranch_L'],
                        On      : [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where :{
                        Condition : ["AND (TCNMShop.FTShpStaActive = '1')"+tTextWhereInBranch+tTextWhereInMerchant]
                    },
                    GrideView:{
                        ColumnPathLang	    : 'company/shop/shop',
                        ColumnKeyLang	    : ['tSHPTBBranch','tSHPTBCode','tSHPTBName'],
                        ColumnsSize         : ['15%','15%','75%'],
                        WidthModal          : 50,
                        DataColumns		    : ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat   : ['','',''],
                        OrderBy			    : ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterShpStaAll'],
                        Value		: ['oetSMTSALFilterShpCode',"TCNMShop.FTShpCode"],
                        Text		: ['oetSMTSALFilterShpName',"TCNMShop_L.FTShpName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseShpOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Pos
        $('#odvSMTSALModalFilter #obtSMTSALFilterPos').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var tFilterBchCode = $('#oetSMTSALFilterBchCode').val();
                var tFilterBchCodeWhere = tFilterBchCode.replace(",","','");
                if(tFilterBchCodeWhere!=''){
                  var tConditionWhere = " AND TCNMPos.FTBchCode IN ('"+tFilterBchCodeWhere+"')";
                }else{
                    var tConditionWhere = "";
                }
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePosOption   = undefined;
                oSMTSALBrowsePosOption          = {
                    Title       : ["pos/salemachine/salemachine","tPOSTitle"],
                    Table       : { Master:'TCNMPos', PK:'FTPosCode'},
                    Join    : {
                        Table   : ['TCNMPos_L'],
                        On      : [
                            'TCNMPos.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos.FTBchCode = TCNMPos_L.FTbchCode AND TCNMPos_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where   : {
                        Condition : [tConditionWhere]
                    },
                    GrideView   : {
                        ColumnPathLang  : 'pos/salemachine/salemachine',
                        ColumnKeyLang   : ['tPOSCode','tPOSRegNo'],
                        ColumnsSize     : ['10%','80%'],
                        WidthModal      : 50,
                        DataColumns     : ["TCNMPos.FTPosCode","TCNMPos_L.FTPosName"],
                        DataColumnsFormat : ['',''],
                        OrderBy         : ['TCNMPos.FTPosCode ASC'],
                    },
                    CallBack    : {
                        StausAll    : ['oetSMTSALFilterPosStaAll'],
                        Value       : ['oetSMTSALFilterPosCode',"TCNMPos.FTPosCode"],
                        Text        : ['oetSMTSALFilterPosName',"TCNMPos_L.FTPosName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product
        $('#odvSMTSALModalFilter #obtSMTSALBrowsePdt').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePdtOption   = undefined;
                oSMTSALBrowsePdtOption          = {
                    Title   : ["product/product/product","tPDTTitle"],
                    Table   : { Master:'TCNMPdt', PK:'FTPdtCode'},
                    Join    : {
                        Table   : ['TCNMPdt_L'],
                        On      : [
                            'TCNMPdt.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = '+nLangEdits
                        ]
                    },
                    Where   : {
                        Condition : ["AND (TCNMPdt.FTPdtStaActive = '1')"]
                    },
                    GrideView   : {
                        ColumnPathLang      : 'product/product/product',
                        ColumnKeyLang       : ['tPDTCode','tPDTName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                        Perpage			    : 10,
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMPdt.FTPdtCode ASC'],
                    },
                    CallBack:{
                        StaSingItem : '1',
                        ReturnType	: 'M',
                        StausAll    : ['oetSMTSALFilterPdtStaAll'],
                        Value		: ['oetSMTSALFilterPdtCode',"TCNMPdt.FTPdtCode"],
                        Text		: ['oetSMTSALFilterPdtName',"TCNMPdt_L.FTPdtName"]
                    }
                };
                JCNxBrowseData('oSMTSALBrowsePdtOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Recive
        $('#odvSMTSALModalFilter #obtSMTSALBrowseRcv').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowseRcvOption   = undefined;
                oSMTSALBrowseRcvOption          = {
                    Title   : ["payment/recive/recive","tRCVTitle"],
                    Table   : { Master:'TFNMRcv', PK:'FTRcvCode'},
                    Join    : {
                        Table   : ['TFNMRcv_L'],
                        On      : ['TFNMRcv.FTRcvCode = TFNMRcv_L.FTRcvCode AND TFNMRcv_L.FNLngID = '+nLangEdits]
                    },
                    Where   : {
                        Condition : ["AND (TFNMRcv.FTRcvStaUse = '1')"]
                    },
                    GrideView   : {
                        ColumnPathLang      : 'payment/recive/recive',
                        ColumnKeyLang       : ['tRCVTBCode','tRCVTBName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TFNMRcv.FTRcvCode', 'TFNMRcv_L.FTRcvName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TFNMRcv.FTRcvCode ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterRcvStaAll'],
                        Value		: ['oetSMTSALFilterRcvCode',"TFNMRcv.FTRcvCode"],
                        Text		: ['oetSMTSALFilterRcvName',"TFNMRcv_L.FTRcvName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseRcvOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Recive
        $('#odvSMTSALModalFilter #obtSMTSALBrowseUsr').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowseUsrOption   = undefined;
                oSMTSALBrowseUsrOption          = {
                    Title   : ["payment/recive/recive","tRCVTitle"],
                    Table   : { Master:'TCNMUser', PK:'FTUsrCode'},
                    Join    : {
                        Table   : ['TCNMUser_L'],
                        On      : ['TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = '+nLangEdits]
                    },
                    // Where   : {
                    //     Condition : ["AND (TCNMUser.FTRcvStaUse = '1')"]
                    // },
                    GrideView   : {
                        ColumnPathLang      : 'payment/recive/recive',
                        ColumnKeyLang       : ['tRCVTBCode','tRCVTBName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TCNMUser.FTUsrCode', 'TCNMUser_L.FTUsrName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMUser.FTUsrCode ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterUsrStaAll'],
                        Value		: ['oetSMTSALFilterUsrCode',"TCNMUser.FTUsrCode"],
                        Text		: ['oetSMTSALFilterUsrName',"TCNMUser_L.FTUsrName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseUsrOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product Group
        $('#odvSMTSALModalFilter #obtSMTSALBrowsePgp').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePgpOption   = undefined;
                oSMTSALBrowsePgpOption          = {
                    Title   : ["product/pdtgroup/pdtgroup","tPGPTitle"],
                    Table   : { Master:'TCNMPdtGrp', PK:'FTPgpChain'},
                    Join    : {
                        Table   : ['TCNMPdtGrp_L'],
                        On      : ['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = '+nLangEdits]
                    },
                    GrideView   : {
                        ColumnPathLang      : 'product/pdtgroup/pdtgroup',
                        ColumnKeyLang       : ['tPGPCode','tPGPName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMPdtGrp.FTPgpChain ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterPgpStaAll'],
                        Value		: ['oetSMTSALFilterPgpCode',"TCNMPdtGrp.FTPgpChain"],
                        Text		: ['oetSMTSALFilterPgpName',"TCNMPdtGrp_L.FTPgpName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowsePgpOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product Type
        $('#odvSMTSALModalFilter #obtSMTSALBrowsePty').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowsePtyOption   = undefined;
                oSMTSALBrowsePtyOption          = {
                    Title   : ["product/pdttype/pdttype","tPTYTitle"],
                    Table   : { Master:'TCNMPdtType', PK:'FTPtyCode'},
                    Join    : {
                        Table   : ['TCNMPdtType_L'],
                        On      : ['TCNMPdtType.FTPtyCode = TCNMPdtType_L.FTPtyCode AND TCNMPdtType_L.FNLngID = '+nLangEdits]
                    },
                    GrideView   : {
                        ColumnPathLang      : 'product/pdttype/pdttype',
                        ColumnKeyLang       : ['tPTYCode','tPTYName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMPdtType.FTPtyCode ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterPtyStaAll'],
                        Value		: ['oetSMTSALFilterPtyCode',"TCNMPdtType.FTPtyCode"],
                        Text		: ['oetSMTSALFilterPtyName',"TCNMPdtType_L.FTPtyName"]
                    }
                }
                JCNxBrowseMultiSelect('oSMTSALBrowsePtyOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi WarHouse
        $('#odvSMTSALModalFilter #obtSMTSALFilterWah').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oSMTSALBrowseWahOption   = undefined;
                oSMTSALBrowseWahOption          = {
                    Title   : ["company/warehouse/warehouse","tWAHTitle"],
                    Table   : { Master:'TCNMWaHouse', PK:'FTWahCode'},
                    Join    : {
                        Table   : ['TCNMWaHouse_L'],
                        On      : ['TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits]
                    },
                    GrideView   : {
                        ColumnPathLang      : 'company/warehouse/warehouse',
                        ColumnKeyLang       : ['tWahCode','tWahName'],
                        ColumnsSize         : ['15%','75%'],
                        WidthModal          : 50,
                        DataColumns         : ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                        DataColumnsFormat   : ['',''],
                        OrderBy			    : ['TCNMWaHouse.FTWahCode ASC'],
                    },
                    CallBack:{
                        StausAll    : ['oetSMTSALFilterWahStaAll'],
                        Value		: ['oetSMTSALFilterWahCode',"TCNMWaHouse.FTWahCode"],
                        Text		: ['oetSMTSALFilterWahName',"TCNMWaHouse_L.FTWahName"]
                    }
                };
                JCNxBrowseMultiSelect('oSMTSALBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



    
    });

    function JSxSMTSetBrowsShopPos(ptParam){
        // console.log(ptParam);
        if( ptParam.length == 1 ){
            $('#obtSMTSALFilterShp').attr('disabled',false);
            $('#obtSMTSALFilterPos').attr('disabled',false);
        }else{
            $('#obtSMTSALFilterShp').attr('disabled',true);
            $('#obtSMTSALFilterPos').attr('disabled',true);      
        }

        // $('#oetSMTSALFilterBchCodeCount').val(ptParam.length);
    }



</script>
