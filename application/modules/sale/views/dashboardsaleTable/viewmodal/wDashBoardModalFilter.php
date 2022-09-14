<div id="odvDSHSALModalFilter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:50%;margin:1.75rem auto;left:2%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight:bold;font-size:20px;"><?php echo @$aTextLang['tDSHSALModalTitleFilter'];?></label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="ofmDSHSALFormFilter" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="ohdDSHSALFilterKey" name="ohdDSHSALFilterKey" value="<?php echo @$tFilterDataKey;?>">
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalBranch'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBchStaAll" name="oetDSHSALFilterBchStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBchCode" name="oetDSHSALFilterBchCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterBchName" name="oetDSHSALFilterBchName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            // $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalMerchant'].'</label>';
                                            // $tTextFilter    .= '<div class="input-group">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterMerStaAll" name="oetDSHSALFilterMerStaAll">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterMerCode" name="oetDSHSALFilterMerCode">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterMerName" name="oetDSHSALFilterMerName" readonly>';
                                            // $tTextFilter    .= '<span class="input-group-btn">';
                                            // $tTextFilter    .= '<button id="obtDSHSALFilterMer" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            // $tTextFilter    .= '</span>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'SHP' : {
                                            // ฟิวเตอร์ ร้านค้า
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group">';
                                            // $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalShop'].'</label>';
                                            // $tTextFilter    .= '<div class="input-group">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterShpStaAll" name="oetDSHSALFilterShpStaAll">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterShpCode" name="oetDSHSALFilterShpCode">';
                                            // $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterShpName" name="oetDSHSALFilterShpName" readonly>';
                                            // $tTextFilter    .= '<span class="input-group-btn">';
                                            // $tTextFilter    .= '<button id="obtDSHSALFilterShp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            // $tTextFilter    .= '</span>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            break;
                                        }
                                        case 'POS' : {
                                            // ฟิวเตอร์ จุดขาย
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalPos'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPosStaAll" name="oetDSHSALFilterPosStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPosCode" name="oetDSHSALFilterPosCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterPosName" name="oetDSHSALFilterPosName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterPos" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalWah'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterWahStaAll" name="oetDSHSALFilterWahStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterWahCode" name="oetDSHSALFilterWahCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterWahName" name="oetDSHSALFilterWahName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterWah" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalProduct'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPdtStaAll" name="oetDSHSALFilterPdtStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPdtCode" name="oetDSHSALFilterPdtCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterPdtName" name="oetDSHSALFilterPdtName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALBrowsePdt" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalRecive'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterRcvStaAll" name="oetDSHSALFilterRcvStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterRcvCode" name="oetDSHSALFilterRcvCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterRcvName" name="oetDSHSALFilterRcvName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALBrowseRcv" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalPdtGrp'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPgpStaAll" name="oetDSHSALFilterPgpStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPgpCode" name="oetDSHSALFilterPgpCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterPgpName" name="oetDSHSALFilterPgpName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALBrowsePgp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalPdtPty'].'</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPtyStaAll" name="oetDSHSALFilterPtyStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterPtyCode" name="oetDSHSALFilterPtyCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterPtyName" name="oetDSHSALFilterPtyName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALBrowsePty" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
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
                                            // $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalAppType'].'</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbDSHSALAppType[]" value="1" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tDSHSALModalAppType1'].'</span';
                                            // $tTextFilter    .= '</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbDSHSALAppType[]" value="2" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tDSHSALModalAppType2'].'</span';
                                            // $tTextFilter    .= '</label>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            // $tTextFilter    .= '<label class="fancy-checkbox">';
                                            // $tTextFilter    .= '<input type="checkbox" name="ocbDSHSALAppType[]" value="3" checked>';
                                            // $tTextFilter    .= '<span>'.@$aTextLang['tDSHSALModalAppType3'].'</span';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalStatusCst'].'</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusAll'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="1">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusCst1'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="2">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusCst2'].'</span>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalStatusPayment'].'</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusAll'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="1">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusPayment1'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="2">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusPayment2'].'</span>';
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
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALModalTopLimit'].'</label>';
                                            $tTextFilter    .= '<select class="form-control selectpicker" id="ocmDSHSALFilterTopLimit" name="ocmDSHSALFilterTopLimit">';
                                            $tTextFilter    .= '<option value="5">5</option>';
                                            $tTextFilter    .= '<option value="10">10</option>';
                                            $tTextFilter    .= '<option value="15">15</option>';
                                            $tTextFilter    .= '<option value="20">20</option>';
                                            $tTextFilter    .= '</select>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                        }
                                        case 'DIF' : {
                                            // Diif ที่ != 0
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">'.@$aTextLang['tDSHSALDataDiff'].'</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALDiff" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALModalStatusAll'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALDiff" value="1">';
                                            $tTextFilter    .= '<span><i></i>'.@$aTextLang['tDSHSALOverLapZero'].'</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
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
                        <button id="obtDSHSALCloseFilter"   type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo @$aTextLang['tDSHSALModalBtnCancel'];?></button>
                        <button id="obtDSHSALConfirmFilter" type="button" class="btn btn-primary"><?php echo @$aTextLang['tDSHSALModalBtnSave'];?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
    $(document).ready(function () {
        // Option Select Picker
        $('.selectpicker').selectpicker();

        // Event Click Confirm Filter
        $('#odvDSHSALModalFilter #obtDSHSALConfirmFilter').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
                const tFilterKey    = $('#odvDSHSALModalFilter #ohdDSHSALFilterKey').val();
                JCNxDSHSALConfirmFilter(tFilterKey);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Branch
        $('#odvDSHSALModalFilter #obtDSHSALFilterBch').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
            var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            var tWhere = "";

            if (tUsrLevel != "HQ") {
                tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
            } else {
                tWhere = "";
            }
            
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowseBchOption   = undefined;
                oDSHSALBrowseBchOption          = {
                    Title   : ['company/branch/branch','tBCHTitle'],
                    Table   : {Master:'TCNMBranch',PK:'FTBchCode'},
                    Join    : {
                        Table   : ['TCNMBranch_L'],
                        On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
                    },
                    Where: {
                        Condition: [tWhere]
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
                    CallBack:{
                        StausAll    : ['oetDSHSALFilterBchStaAll'],
                        Value		: ['oetDSHSALFilterBchCode','TCNMBranch.FTBchCode'],
                        Text		: ['oetDSHSALFilterBchName','TCNMBranch_L.FTBchName']
                    },
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseBchOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Click Browse Multi Merchant
        $('#odvDSHSALModalFilter #obtDSHSALFilterMer').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowseMerOption   = undefined;
                oDSHSALBrowseMerOption          = {
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
                        StausAll    : ['oetDSHSALFilterMerStaAll'],
                        Value       : ['oetDSHSALFilterMerCode','TCNMMerchant.FTMerCode'],
                        Text        : ['oetDSHSALFilterMerName','TCNMMerchant_L.FTMerName'],
                    },
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseMerOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Shop
        $('#odvDSHSALModalFilter #obtDSHSALFilterShp').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                let tDataBranch     = $('#oetDSHSALFilterBchCode').val();
                let tDataMerchant   = $('#oetDSHSALFilterMerCode').val();

                // ********** Check Data Branch **********
                let tTextWhereInBranch      = '';
                if(tDataBranch != ''){
                    tTextWhereInBranch      = ' AND (TCNMShop.FTBchCode IN ('+tDataBranch+'))';
                }

                // ********** Check Data Merchant **********s
                let tTextWhereInMerchant    = '';
                if(tDataMerchant != ''){
                    tTextWhereInMerchant    = ' AND (TCNMShop.FTMerCode IN ('+tDataMerchant+'))';
                }

                window.oDSHSALBrowseShpOption   = undefined;
                oDSHSALBrowseShpOption          = {
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
                        StausAll    : ['oetDSHSALFilterShpStaAll'],
                        Value		: ['oetDSHSALFilterShpCode',"TCNMShop.FTShpCode"],
                        Text		: ['oetDSHSALFilterShpName',"TCNMShop_L.FTShpName"]
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseShpOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Pos
        $('#odvDSHSALModalFilter #obtDSHSALFilterPos').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                let tDataBranch     = $('#oetDSHSALFilterBchCode').val();
                let tDataBranchReplace = tDataBranch.replace(",","','");

            var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
            var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            var tWhere = "";

            if (tUsrLevel != "HQ") {
                tWhere = " AND TCNMPos.FTBchCode IN (" + tBchCodeMulti + ") ";
            } else {
                tWhere = "";
            }
                // ********** Check Data Branch **********
                let tTextWhereInBranch      = '';
                if(tDataBranchReplace != ''){
                    tTextWhereInBranch = " AND (TCNMPos.FTBchCode IN ('" + tDataBranchReplace + "'))";
                }

                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePosOption   = undefined;
                oDSHSALBrowsePosOption          = {
                    Title       : ["pos/salemachine/salemachine","tPOSTitle"],
                    Table       : { Master:'TCNMPos', PK:'FTPosCode'},
                    Join    : {
                        Table   : ['TCNMPos_L'],
                        On      : ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FTBchCode = TCNMPos.FTBchCode ']
                    },
                    Where :{
                        Condition : [tWhere + tTextWhereInBranch]
                    },
                    GrideView   : {
                        ColumnPathLang  : 'pos/salemachine/salemachine',
                        ColumnKeyLang   : ['tPOSCode','tPOSName'],
                        
                        ColumnsSize     : ['10%','80%'],
                        WidthModal      : 50,
                        DataColumns     : ["TCNMPos.FTPosCode","TCNMPos_L.FTPosName"],
                        DistinctField   : ['TCNMPos.FTPosCode'],
                        DataColumnsFormat : ['',''],
                        OrderBy         : ['TCNMPos.FTPosCode ASC'],
                    },
                    CallBack    : {
                        StausAll    : ['oetDSHSALFilterPosStaAll'],
                        Value       : ['oetDSHSALFilterPosCode',"TCNMPos.FTPosCode"],
                        Text        : ['oetDSHSALFilterPosName',"TCNMPos.FTPosCode"]
                    },
                    // DebugSQL : true
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePosOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product
        $('#odvDSHSALModalFilter #obtDSHSALBrowsePdt').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePdtOption   = undefined;
                oDSHSALBrowsePdtOption          = {
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
                        StausAll    : ['oetDSHSALFilterPdtStaAll'],
                        Value		: ['oetDSHSALFilterPdtCode',"TCNMPdt.FTPdtCode"],
                        Text		: ['oetDSHSALFilterPdtName',"TCNMPdt_L.FTPdtName"]
                    }
                };
                JCNxBrowseData('oDSHSALBrowsePdtOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Recive
        $('#odvDSHSALModalFilter #obtDSHSALBrowseRcv').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowseRcvOption   = undefined;
                oDSHSALBrowseRcvOption          = {
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
                        StausAll    : ['oetDSHSALFilterRcvStaAll'],
                        Value		: ['oetDSHSALFilterRcvCode',"TFNMRcv.FTRcvCode"],
                        Text		: ['oetDSHSALFilterRcvName',"TFNMRcv_L.FTRcvName"]
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseRcvOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product Group
        $('#odvDSHSALModalFilter #obtDSHSALBrowsePgp').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePgpOption   = undefined;
                oDSHSALBrowsePgpOption          = {
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
                        StausAll    : ['oetDSHSALFilterPgpStaAll'],
                        Value		: ['oetDSHSALFilterPgpCode',"TCNMPdtGrp.FTPgpChain"],
                        Text		: ['oetDSHSALFilterPgpName',"TCNMPdtGrp_L.FTPgpName"]
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePgpOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi Product Type
        $('#odvDSHSALModalFilter #obtDSHSALBrowsePty').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePtyOption   = undefined;
                oDSHSALBrowsePtyOption          = {
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
                        StausAll    : ['oetDSHSALFilterPtyStaAll'],
                        Value		: ['oetDSHSALFilterPtyCode',"TCNMPdtType.FTPtyCode"],
                        Text		: ['oetDSHSALFilterPtyName',"TCNMPdtType_L.FTPtyName"]
                    }
                }
                JCNxBrowseMultiSelect('oDSHSALBrowsePtyOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Browse Multi WarHouse
        $('#odvDSHSALModalFilter #obtDSHSALFilterWah').unbind().click(function(){
            let nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowseWahOption   = undefined;
                oDSHSALBrowseWahOption          = {
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
                        StausAll    : ['oetDSHSALFilterWahStaAll'],
                        Value		: ['oetDSHSALFilterWahCode',"TCNMWaHouse.FTWahCode"],
                        Text		: ['oetDSHSALFilterWahName',"TCNMWaHouse_L.FTWahName"]
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseWahOption');
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    });
</script>
