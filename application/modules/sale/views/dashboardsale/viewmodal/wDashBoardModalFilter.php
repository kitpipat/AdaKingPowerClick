<div id="odvDSHSALModalFilter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:50%;margin:1.75rem auto;left:2%;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label class="xCNTextModalHeard" style="font-weight:bold;font-size:20px;"><?php echo @$aTextLang['tDSHSALModalTitleFilter']; ?></label>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form id="ofmDSHSALFormFilter" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="ohdDSHSALFilterKey" name="ohdDSHSALFilterKey" value="<?php echo @$tFilterDataKey; ?>">
                    <div class="row">
                        <?php //echo $tFilterDataKey; 
                        ?>
                        <?php if (isset($aFilterDataGrp) && !empty($aFilterDataGrp)) : ?>
                            <?php foreach ($aFilterDataGrp as $nKey => $tKeyGrpFilter) : ?>
                                <?php
                                $tTextFilter    = "";
                                switch ($tKeyGrpFilter) {

                                    case 'AGN': {
                                            // ฟิวเตอร์ AD
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalAgn'] . '</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterAgnStaAll" name="oetDSHSALFilterAgnStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterAgnCode" name="oetDSHSALFilterAgnCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterAgnName" name="oetDSHSALFilterAgnName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterAgn" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';

                                            break;
                                        }
                                    case 'BCH': {
                                            // ฟิวเตอร์ สาขา
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalBranch'] . '</label>';
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
                                    case 'MER': {
                                            // ฟิวเตอร์ กลุ่มธุรกิจ
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalMerchant'] . '</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterMerStaAll" name="oetDSHSALFilterMerStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterMerCode" name="oetDSHSALFilterMerCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterMerName" name="oetDSHSALFilterMerName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterMer" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'SHP': {
                                            // ฟิวเตอร์ ร้านค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalShop'] . '</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterShpStaAll" name="oetDSHSALFilterShpStaAll">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterShpCode" name="oetDSHSALFilterShpCode">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterShpName" name="oetDSHSALFilterShpName" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterShp" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'POS': {
                                            // ฟิวเตอร์ จุดขาย
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalPos'] . '</label>';
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
                                    case 'WAH': {
                                            // ฟิวเตอร์ คลังสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalWah'] . '</label>';
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
                                    case 'PDT': {
                                            // ฟิวเตอร์ สินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalProduct'] . '</label>';
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
                                    case 'RCV': {
                                            // ฟิวเตอร์ ประเภทการชำระ
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalRecive'] . '</label>';
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
                                    case 'PGP': {
                                            // ฟิวเตอร์ กลุ่มสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalPdtGrp'] . '</label>';
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
                                    case 'PTY': {
                                            // ฟิวเตอร์ ประเภทสินค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalPdtPty'] . '</label>';
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
                                    case 'APT': {
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
                                    case 'SCT': {
                                            // สถานะลูกค้า
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalStatusCst'] . '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusAll'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="1">';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusCst1'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaCst" name="orbDSHSALStaCst" value="2">';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusCst2'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'SRC': {
                                            // สถาณะการชำระ
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalStatusPayment'] . '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusAll'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="1">';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusPayment1'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALStaPayment" value="2">';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusPayment2'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'TLM': {
                                            // Top Limit
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALModalTopLimit'] . '</label>';
                                            $tTextFilter    .= '<select class="form-control selectpicker" id="ocmDSHSALFilterTopLimit" name="ocmDSHSALFilterTopLimit">';
                                            $tTextFilter    .= '<option value="5">5</option>';
                                            $tTextFilter    .= '<option value="10">10</option>';
                                            $tTextFilter    .= '<option value="15">15</option>';
                                            $tTextFilter    .= '<option value="20">20</option>';
                                            $tTextFilter    .= '</select>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                        }
                                    case 'DIF': {
                                            // Diif ที่ != 0
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-r-0">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">' . @$aTextLang['tDSHSALDataDiff'] . '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALDiff" value="" checked>';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALModalStatusAll'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<label class="fancy-radio">';
                                            $tTextFilter    .= '<input type="radio" class="xWDSHSALStaPayment" name="orbDSHSALDiff" value="1">';
                                            $tTextFilter    .= '<span><i></i>' . @$aTextLang['tDSHSALOverLapZero'] . '</span>';
                                            $tTextFilter    .= '</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'GRP': {
                                            // กลุ่่มรายงาน
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">กลุ่มรายงาน</label>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="clearfix"></div>';
                                            $tTextFilter    .= '<div class="form-group">';
                                            // $tTextFilter    .= '<div class="row">';
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 p-l-0 p-r-0">';
                                            $tTextFilter    .= '<select class="selectpicker xCNNewUISelectoption" id="ocmGroupReport" name="ocmGroupReport" onchange="JSxHideShowGup();">';
                                            $tTextFilter    .= '<option value="01">' . language('report/report/report', 'tRptGrpBranch') . '</option>';
                                            $tTextFilter    .= '<option value="02">' . language('report/report/report', 'tRptGrpAgency') . '</option>';
                                            $tTextFilter    .= '<option value="03">' . language('report/report/report', 'tRptGrpShop') . '</option>';
                                            // $tTextFilter    .= '<option value="04">' . language('report/report/report', 'tRptProduct') . '</option>';
                                            $tTextFilter    .= '<option value="05">' . language('report/report/report', 'tRptGrpPdtType') . '</option>';
                                            $tTextFilter    .= '<option value="06">' . language('report/report/report', 'tRptGrpPdtGroup') . '</option>';
                                            $tTextFilter    .= '<option value="07">' . language('report/report/report', 'tRptGrpPdtBrand') . '</option>';
                                            $tTextFilter    .= '<option value="08">' . language('report/report/report', 'tRptGrpPdtModel') . '</option>';
                                            $tTextFilter    .= '</select> ';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            break;
                                        }
                                    case 'BRD': {
                                            // ฟิวเตอร์ ยี่ห้อ
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group xHideBRD">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class=" xHideBRD">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">จาก ยี่ห้อ</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBrandStaAllFrom" name="oetDSHSALFilterBrandStaAllFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBrandCodeFrom" name="oetDSHSALFilterBrandCodeFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterBrandNameFrom" name="oetDSHSALFilterBrandNameFrom" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterBrandFrom" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">ถึง ยี่ห้อ</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBrandStaAllTo" name="oetDSHSALFilterBrandStaAllTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterBrandCodeTo" name="oetDSHSALFilterBrandCodeTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterBrandNameTo" name="oetDSHSALFilterBrandNameTo" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterBrandTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';

                                            break;
                                        }
                                    case 'MOD': {
                                            // ฟิวเตอร์ รุ่น
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group xHideMOD">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="xHideMOD">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">จาก รุ่น</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterModelStaAllFrom" name="oetDSHSALFilterModelStaAllFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterModelCodeFrom" name="oetDSHSALFilterModelCodeFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterModelNameFrom" name="oetDSHSALFilterModelNameFrom" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterModelFrom" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">ถึง รุ่น</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterModelStaAllTo" name="oetDSHSALFilterModelStaAllTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterModelCodeTo" name="oetDSHSALFilterModelCodeTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterModelNameTo" name="oetDSHSALFilterModelNameTo" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterModelTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';

                                            break;
                                        }


                                    case 'PRDFT': {
                                            // ฟิวเตอร์ สินค้า จาก ถึง
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group xHidePRDFT">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="xHidePRDFT">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">จาก สินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterProductFTStaAllFrom" name="oetDSHSALFilterProductFTStaAllFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterProductFTCodeFrom" name="oetDSHSALFilterProductFTCodeFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterProductFTNameFrom" name="oetDSHSALFilterProductFTNameFrom" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterProductFTFrom" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">ถึง สินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterProductFTStaAllTo" name="oetDSHSALFilterProductFTStaAllTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterProductFTCodeTo" name="oetDSHSALFilterProductFTCodeTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterProductFTNameTo" name="oetDSHSALFilterProductFTNameTo" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterProductFTTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';

                                            break;
                                        }

                                    case 'TPRDFT': {
                                            // ฟิวเตอร์ ประเภทสินค้า จาก ถึง
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group xHideTPRDFT">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="xHideTPRDFT">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">จาก ประเภทสินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterTypeProductFTStaAllFrom" name="oetDSHSALFilterTypeProductFTStaAllFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterTypeProductFTCodeFrom" name="oetDSHSALFilterTypeProductFTCodeFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterTypeProductFTNameFrom" name="oetDSHSALFilterTypeProductFTNameFrom" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterTypeProductFTFrom" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">ถึง ประเภทสินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterTypeProductFTStaAllTo" name="oetDSHSALFilterTypeProductFTStaAllTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterTypeProductFTCodeTo" name="oetDSHSALFilterTypeProductFTCodeTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterTypeProductFTNameTo" name="oetDSHSALFilterTypeProductFTNameTo" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterTypeProductFTTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';

                                            break;
                                        }

                                    case 'GPRDFT': {
                                            // ฟิวเตอร์ กลุ่มนค้า จาก ถึง
                                            // $tTextFilter    .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            // $tTextFilter    .= '<div class="form-group xHideGPRDFT">';
                                            // $tTextFilter    .= '<div class="row">';
                                            $tTextFilter    .= '<div class="xHideGPRDFT">';
                                            $tTextFilter    .= '<div class="form-group">';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">จาก กลุ่มสินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterGroupProductFTStaAllFrom" name="oetDSHSALFilterGroupProductFTStaAllFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterGroupProductFTCodeFrom" name="oetDSHSALFilterGroupProductFTCodeFrom">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterGroupProductFTNameFrom" name="oetDSHSALFilterGroupProductFTNameFrom" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterGroupProductFTFrom" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
                                            $tTextFilter    .= '<label class="xCNLabelFrm">ถึง กลุ่มสินค้า</label>';
                                            $tTextFilter    .= '<div class="input-group">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterGroupProductFTStaAllTo" name="oetDSHSALFilterGroupProductFTStaAllTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xCNHide" id="oetDSHSALFilterGroupProductFTCodeTo" name="oetDSHSALFilterGroupProductFTCodeTo">';
                                            $tTextFilter    .= '<input type="text" class="form-control xWPointerEventNone" id="oetDSHSALFilterGroupProductFTNameTo" name="oetDSHSALFilterGroupProductFTNameTo" readonly>';
                                            $tTextFilter    .= '<span class="input-group-btn">';
                                            $tTextFilter    .= '<button id="obtDSHSALFilterGroupProductFTTo" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>';
                                            $tTextFilter    .= '</span>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';
                                            // $tTextFilter    .= '</div>';

                                            break;
                                        }
                                }
                                echo $tTextFilter;
                                ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <button id="obtDSHSALCloseFilter" type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo @$aTextLang['tDSHSALModalBtnCancel']; ?></button>
                        <button id="obtDSHSALConfirmFilter" type="button" class="btn btn-primary"><?php echo @$aTextLang['tDSHSALModalBtnSave']; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    $(document).ready(function() {
        // Option Select Picker
        $('.selectpicker').selectpicker();

        // Event Click Confirm Filter
        $('#odvDSHSALModalFilter #obtDSHSALConfirmFilter').unbind().click(function() {
            let nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                const tFilterKey = $('#odvDSHSALModalFilter #ohdDSHSALFilterKey').val();
                JCNxDSHSALConfirmFilter(tFilterKey);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $(".xHideBRD").hide();
        $(".xHideMOD").hide();
        $(".xHidePRDFT").hide();
        $(".xHideTPRDFT").hide();
        $(".xHideGPRDFT").hide();

    });

    function JSxHideShowGup() {
        var selectBox = document.getElementById("ocmGroupReport");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        // alert(selectedValue);
        // $(".xHideBRD").hide();
        // $(".xHideMOD").hide();
        // $(".xHidePRDFT").hide();
        // $(".xHideTPRDFT").hide();
        // $(".xHideGPRDFT").hide();

        if (selectedValue == '04') {
            $(".xHideBRD").hide();
            $(".xHideMOD").hide();
            $(".xHidePRDFT").show();
            $(".xHideTPRDFT").hide();
            $(".xHideGPRDFT").hide();
        } else if (selectedValue == '05') {
            $(".xHideBRD").hide();
            $(".xHideMOD").hide();
            $(".xHidePRDFT").hide();
            $(".xHideTPRDFT").show();
            $(".xHideGPRDFT").hide();
        } else if (selectedValue == '06') {
            $(".xHideBRD").hide();
            $(".xHideMOD").hide();
            $(".xHidePRDFT").hide();
            $(".xHideTPRDFT").hide();
            $(".xHideGPRDFT").show();
        } else if (selectedValue == '07') {
            $(".xHideBRD").show();
            $(".xHideMOD").hide();
            $(".xHidePRDFT").hide();
            $(".xHideTPRDFT").hide();
            $(".xHideGPRDFT").hide();
        } else if (selectedValue == '08') {
            $(".xHideMOD").show();
            $(".xHideBRD").hide();
            $(".xHidePRDFT").hide();
            $(".xHideTPRDFT").hide();
            $(".xHideGPRDFT").hide();
        }
    }


    function JSxRptConsNextFuncBrowsePdt(poDataNextFunc) {


        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var aDataNextFunc = JSON.parse(poDataNextFunc);
            tPdtCode = aDataNextFunc[0];
            tPdtName = aDataNextFunc[1];
        }

        // ประกาศตัวแปร สินค้า
        var tRptPdtCodeFrom, tRptPdtNameFrom, tRptPdtCodeTo, tRptPdtNameTo
        tRptPdtCodeFrom = $('#oetDSHSALFilterProductFTCodeFrom').val();
        tRptPdtNameFrom = $('#oetDSHSALFilterProductFTNameFrom').val();
        tRptPdtCodeTo = $('#oetDSHSALFilterProductFTCodeTo').val();
        tRptPdtNameTo = $('#oetDSHSALFilterProductFTNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากสินค้า ให้ default ถึงร้านค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtCodeFrom) !== 'undefined' && tRptPdtCodeFrom != "") && (typeof(tRptPdtCodeTo) !== 'undefined' && tRptPdtCodeTo == "")) {
            $('#oetDSHSALFilterProductFTCodeTo').val(tPdtCode);
            $('#oetDSHSALFilterProductFTNameTo').val(tPdtName);
        }

        // เช็คข้อมูลถ้ามีการ Browse ถึงร้านค้า default จากสินค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtCodeTo) !== 'undefined' && tRptPdtCodeTo != "") && (typeof(tRptPdtCodeFrom) !== 'undefined' && tRptPdtCodeFrom == "")) {
            $('#oetDSHSALFilterProductFTCodeFrom').val(tPdtCode);
            $('#oetDSHSALFilterProductFTNameFrom').val(tPdtName);
        }


    }



    function JSxRptConsNextFuncBrowsePdtGrp(poDataNextFunc) {

        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var aDataNextFunc = JSON.parse(poDataNextFunc);
            tPdtGrpCode = aDataNextFunc[0];
            tPdtGrpName = aDataNextFunc[1];
        }

        // ประกาศตัวแปร กลุ่มสินค้า
        var tRptPdtGrpCodeFrom, tRptPdtGrpNameFrom, tRptPdtGrpCodeTo, tRptPdtGrpNameTo
        tRptPdtGrpCodeFrom = $('#oetDSHSALFilterGroupProductFTCodeFrom').val();
        tRptPdtGrpNameFrom = $('#oetDSHSALFilterGroupProductFTNameFrom').val();
        tRptPdtGrpCodeTo = $('#oetDSHSALFilterGroupProductFTCodeTo').val();
        tRptPdtGrpNameTo = $('#oetDSHSALFilterGroupProductFTNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากกลุ่มสินค้า ให้ default ถึงกลุ่มสินค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtGrpCodeFrom) !== 'undefined' && tRptPdtGrpCodeFrom != "") && (typeof(tRptPdtGrpCodeTo) !== 'undefined' && tRptPdtGrpCodeTo == "")) {
            $('#oetDSHSALFilterGroupProductFTCodeTo').val(tPdtGrpCode);
            $('#oetDSHSALFilterGroupProductFTNameTo').val(tPdtGrpName);
        }

        // เช็คข้อมูลถ้ามีการ Browse ถึงกลุ่มสินค้า default จากกลุ่มสินค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtGrpCodeTo) !== 'undefined' && tRptPdtGrpCodeTo != "") && (typeof(tRptPdtGrpCodeFrom) !== 'undefined' && tRptPdtGrpCodeFrom == "")) {
            $('#oetDSHSALFilterGroupProductFTCodeFrom').val(tPdtGrpCode);
            $('#oetDSHSALFilterGroupProductFTNameFrom').val(tPdtGrpName);
        }
    }

    function JSxRptConsNextFuncBrowsePdtType(poDataNextFunc) {

        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            let aDataNextFunc = JSON.parse(poDataNextFunc);
            tPdtTypeCode = aDataNextFunc[0];
            tPdtTypeName = aDataNextFunc[1];
        }

        // ประกาศตัวแปร ประเภทสินค้า
        var tRptPdtTypeCodeFrom, tRptPdtTypeNameFrom, tRptPdtTypeCodeTo, tRptPdtTypeNameTo
        tRptPdtTypeCodeFrom = $('#oetDSHSALFilterTypeProductFTCodeFrom').val();
        tRptPdtTypeNameFrom = $('#oetDSHSALFilterTypeProductFTNameFrom').val();
        tRptPdtTypeCodeTo = $('#oetDSHSALFilterTypeProductFTCodeTo').val();
        tRptPdtTypeNameTo = $('#oetDSHSALFilterTypeProductFTNameTo').val();

        // เช็คข้อมูลถ้ามีการ Browse จากประเภทสินค้า ให้ default ถึงประเภทสินค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtTypeCodeFrom) !== 'undefined' && tRptPdtTypeCodeFrom != "") && (typeof(tRptPdtTypeCodeTo) !== 'undefined' && tRptPdtTypeCodeTo == "")) {
            $('#oetDSHSALFilterTypeProductFTCodeTo').val(tPdtTypeCode);
            $('#oetDSHSALFilterTypeProductFTNameTo').val(tPdtTypeName);
        }

        // เช็คข้อมูลถ้ามีการ Browse ถึงประเภทสินค้า default จากประเภทสินค้า เป็นข้อมูลเดียวกัน 
        if ((typeof(tRptPdtTypeCodeTo) !== 'undefined' && tRptPdtTypeCodeTo != "") && (typeof(tRptPdtTypeCodeFrom) !== 'undefined' && tRptPdtTypeCodeFrom == "")) {
            $('#oetDSHSALFilterTypeProductFTCodeFrom').val(tPdtTypeCode);
            $('#oetDSHSALFilterTypeProductFTNameFrom').val(tPdtTypeName);
        }



    }


    function JSxRptConsNextFuncBrowseBrand(poDataNextFunc) {
        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var aDataNextFunc = JSON.parse(poDataNextFunc);
            var tPbnCode = aDataNextFunc[0];
            var tPbnName = aDataNextFunc[1];

            var tPbnCodeFrom = $('#oetDSHSALFilterBrandCodeFrom').val();
            var tPbnCodeTo = $('#oetDSHSALFilterBrandCodeTo').val();

            //ถ้า input from ว่างให้เอาค่าที่เลือกมาใส่
            if (tPbnCodeFrom == "" || tPbnCodeFrom === undefined) {
                $('#oetDSHSALFilterBrandCodeFrom').val(tPbnCode);
                $('#oetDSHSALFilterBrandNameFrom').val(tPbnName);
            }

            //ถ้า input to ว่างให้เอาค่าที่เลือกมาใส่
            if (tPbnCodeTo == "" || tPbnCodeTo === undefined) {
                $('#oetDSHSALFilterBrandCodeTo').val(tPbnCode);
                $('#oetDSHSALFilterBrandNameTo').val(tPbnName);
            }

            // JSxUncheckinCheckbox('oetRptBrandCodeTo');

        }
    }


    function JSxRptConsNextFuncBrowseModel(poDataNextFunc) {

        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var aDataNextFunc = JSON.parse(poDataNextFunc);
            var tPmoCode = aDataNextFunc[0];
            var tPmoName = aDataNextFunc[1];

            var tPmoCodeFrom = $('#oetDSHSALFilterModelCodeFrom').val();
            var tPmoCodeTo = $('#oetDSHSALFilterModelCodeTo').val();

            //ถ้า input from ว่างให้เอาค่าที่เลือกมาใส่
            if (tPmoCodeFrom == "" || tPmoCodeFrom == undefined) {

                $('#oetDSHSALFilterModelCodeFrom').val(tPmoCode);
                $('#oetDSHSALFilterModelNameFrom').val(tPmoName);
            }

            //ถ้า input to ว่างให้เอาค่าที่เลือกมาใส่
            if (tPmoCodeTo == "" || tPmoCodeTo == undefined) {

                $('#oetDSHSALFilterModelCodeTo').val(tPmoCode);
                $('#oetDSHSALFilterModelNameTo').val(tPmoName);
            }

            // JSxUncheckinCheckbox('oetRptModelCodeTo');

        }
    }

    // function JSxCheckCountCheckboxInModal() {
    //     var nCount = $("#otbMultiBrowseDataTable input[type='checkbox']:checked").length;
    //     alert(nCount);
    // }










    // Event Click Browse Multi Branch
    $('#odvDSHSALModalFilter #obtDSHSALFilterAgn').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        // var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tAgnCode = "<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>";
        // $this->session->set_userdata("tSesUsrAgnCode", $tUsrAgnCodeDefult);
        // 		$this->session->set_userdata("tSesUsrAgnName", $tUsrAgnNameDefult);
        var tWhere = "";

        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMAgency.FTAgnCode  IN (" + tAgnCode + ") ";
        } else {
            tWhere = "";
        }

        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowseAgnOption = undefined;
            oDSHSALBrowseAgnOption = {
                Title: ['ticket/agency/agency', 'tAggTitle'],
                Table: {
                    Master: 'TCNMAgency',
                    PK: 'FTAgnCode'
                },
                Join: {
                    Table: ['TCNMAgency_L'],
                    On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [tWhere]
                },
                GrideView: {
                    ColumnPathLang: 'ticket/agency/agency',
                    ColumnKeyLang: ['tAggCode', 'tAggName'],
                    ColumnsSize: ['15%', '85%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 10,
                    OrderBy: ['TCNMAgency.FTAgnCode DESC'],
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ['oetDSHSALFilterAgnCode', 'TCNMAgency.FTAgnCode'],
                    Text: ['oetDSHSALFilterAgnName', 'TCNMAgency_L.FTAgnName']
                },
                RouteAddNew: 'agency',
                BrowseLev: 1,
                // NextFunc: {
                //     FuncName: 'JSxClearBrowseConditionSpcAgn',
                //     ArgReturn: ['FTAgnCode']
                // }
            };

            if ($('#ohdDSHSALFilterKey').val() == 'RCSPBT' || $('#ohdDSHSALFilterKey').val() == 'RCSPBT2' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt2' ) {
                JCNxBrowseMultiSelect('oDSHSALBrowseAgnOption');
            } else {
                JCNxBrowseData('oDSHSALBrowseAgnOption');
            }



        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Event Click Browse Multi Branch
    $('#odvDSHSALModalFilter #obtDSHSALFilterBch').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tWhere = "";
        var tWhereAgn = "";

        var tAgnCode = $('#oetDSHSALFilterAgnCode').val();

        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
        } else {
            tWhere = "";
        }


        if (tAgnCode != '' && tAgnCode != undefined) {
            tWhereAgn = " AND TCNMBranch.FTAgnCode IN (" + tAgnCode + ") ";
        } else {
            tWhereAgn = "";
        }

        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowseBchOption = undefined;
            oDSHSALBrowseBchOption = {
                Title: ['company/branch/branch', 'tBCHTitle'],
                Table: {
                    Master: 'TCNMBranch',
                    PK: 'FTBchCode'
                },
                Join: {
                    Table: ['TCNMBranch_L'],
                    On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [tWhere + tWhereAgn]
                },
                GrideView: {
                    ColumnPathLang: 'company/branch/branch',
                    ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMBranch_L.FTBchCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterBchStaAll'],
                    Value: ['oetDSHSALFilterBchCode', 'TCNMBranch.FTBchCode'],
                    Text: ['oetDSHSALFilterBchName', 'TCNMBranch_L.FTBchName']
                },
            };
            JCNxBrowseMultiSelect('oDSHSALBrowseBchOption');
            // setTimeout(function() {
            //     $('.fancy-checkbox').on('click', function() {
            //         // JSxCheckCountCheckboxInModal();
                    
            //         var nCount = $("#otbMultiBrowseDataTable input[type='checkbox']:checked").length;
            //         alert(nCount);
            //     });
            // }, 1000);
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // Event Click Browse Multi Merchant
    $('#odvDSHSALModalFilter #obtDSHSALFilterMer').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowseMerOption = undefined;
            oDSHSALBrowseMerOption = {
                Title: ['company/merchant/merchant', 'tMerchantTitle'],
                Table: {
                    Master: 'TCNMMerchant',
                    PK: 'FTMerCode'
                },
                Join: {
                    Table: ['TCNMMerchant_L'],
                    On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
                },
                GrideView: {
                    ColumnPathLang: 'company/merchant/merchant',
                    ColumnKeyLang: ['tMerCode', 'tMerName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMMerchant.FTMerCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterMerStaAll'],
                    Value: ['oetDSHSALFilterMerCode', 'TCNMMerchant.FTMerCode'],
                    Text: ['oetDSHSALFilterMerName', 'TCNMMerchant_L.FTMerName'],
                },
            };
            JCNxBrowseMultiSelect('oDSHSALBrowseMerOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Shop
    $('#odvDSHSALModalFilter #obtDSHSALFilterShp').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tWhere = "";

        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMShop.FTBchCode IN (" + tBchCodeMulti + ") ";
        } else {
            tWhere = "";
        }
        if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            let tDataBranch = $('#oetDSHSALFilterBchCode').val();
            let tDataMerchant = $('#oetDSHSALFilterMerCode').val();

            // ********** Check Data Branch **********
            let tTextWhereInBranch = '';
            if (tDataBranch != '') {
                tTextWhereInBranch = ' AND (TCNMShop.FTBchCode IN (' + tDataBranch + '))';
            }

            // ********** Check Data Merchant **********s
            let tTextWhereInMerchant = '';
            if (tDataMerchant != '') {
                tTextWhereInMerchant = ' AND (TCNMShop.FTMerCode IN (' + tDataMerchant + '))';
            }

            window.oDSHSALBrowseShpOption = undefined;
            oDSHSALBrowseShpOption = {
                Title: ['company/shop/shop', 'tSHPTitle'],
                Table: {
                    Master: 'TCNMShop',
                    PK: 'FTShpCode'
                },
                Join: {
                    Table: ['TCNMShop_L', 'TCNMBranch_L'],
                    On: [
                        'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                        'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where: {
                    Condition: ["AND (TCNMShop.FTShpStaActive = '1')" + tTextWhereInBranch + tTextWhereInMerchant + tWhere]
                },
                GrideView: {
                    ColumnPathLang: 'company/shop/shop',
                    ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
                    ColumnsSize: ['15%', '15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                    DataColumnsFormat: ['', '', ''],
                    OrderBy: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterShpStaAll'],
                    Value: ['oetDSHSALFilterShpCode', "TCNMShop.FTShpCode"],
                    Text: ['oetDSHSALFilterShpName', "TCNMShop_L.FTShpName"]
                }
            };
            JCNxBrowseMultiSelect('oDSHSALBrowseShpOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Pos
    $('#odvDSHSALModalFilter #obtDSHSALFilterPos').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tWhere = "";

        if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMPos.FTBchCode IN (" + tBchCodeMulti + ") ";
        } else {
            tWhere = "";
        }
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            let tDataBranch = $('#oetDSHSALFilterBchCode').val();
            let tDataBranchReplace = tDataBranch.replace(",", "','");


            // ********** Check Data Branch **********
            let tTextWhereInBranch = '';
            if (tDataBranchReplace != '') {
                tTextWhereInBranch = " AND (TCNMPos.FTBchCode IN ('" + tDataBranchReplace + "'))";
            }

            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowsePosOption = undefined;
            oDSHSALBrowsePosOption = {
                Title: ["pos/salemachine/salemachine", "tPOSTitle"],
                Table: {
                    Master: 'TCNMPos',
                    PK: 'FTPosCode'
                },
                Join: {
                    Table: ['TCNMPos_L'],
                    On: ['TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FTBchCode = TCNMPos.FTBchCode']
                },
                Where: {
                    Condition: [tTextWhereInBranch + tWhere]
                },
                GrideView: {
                    ColumnPathLang: 'pos/salemachine/salemachine',
                    ColumnKeyLang: ['tPOSCode', 'tPOSName'],

                    ColumnsSize: ['10%', '80%'],
                    WidthModal: 50,
                    DataColumns: ["TCNMPos.FTPosCode", "TCNMPos_L.FTPosName"],
                    DistinctField: ['TCNMPos.FTPosCode'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMPos.FTPosCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterPosStaAll'],
                    Value: ['oetDSHSALFilterPosCode', "TCNMPos.FTPosCode"],
                    Text: ['oetDSHSALFilterPosName', "TCNMPos.FTPosCode"]
                },
                // DebugSQL : true
            };
            JCNxBrowseMultiSelect('oDSHSALBrowsePosOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Product
    $('#odvDSHSALModalFilter #obtDSHSALBrowsePdt').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowsePdtOption = undefined;
            oDSHSALBrowsePdtOption = {
                Title: ["product/product/product", "tPDTTitle"],
                Table: {
                    Master: 'TCNMPdt',
                    PK: 'FTPdtCode'
                },
                Join: {
                    Table: ['TCNMPdt_L'],
                    On: [
                        'TCNMPdt.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where: {
                    Condition: ["AND (TCNMPdt.FTPdtStaActive = '1')"]
                },
                GrideView: {
                    ColumnPathLang: 'product/product/product',
                    ColumnKeyLang: ['tPDTCode', 'tPDTName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                    Perpage: 10,
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMPdt.FTPdtCode ASC'],
                },
                CallBack: {
                    StaSingItem: '1',
                    ReturnType: 'M',
                    StausAll: ['oetDSHSALFilterPdtStaAll'],
                    Value: ['oetDSHSALFilterPdtCode', "TCNMPdt.FTPdtCode"],
                    Text: ['oetDSHSALFilterPdtName', "TCNMPdt_L.FTPdtName"]
                }
            };
            JCNxBrowseData('oDSHSALBrowsePdtOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Recive
    $('#odvDSHSALModalFilter #obtDSHSALBrowseRcv').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowseRcvOption = undefined;
            oDSHSALBrowseRcvOption = {
                Title: ["payment/recive/recive", "tRCVTitle"],
                Table: {
                    Master: 'TFNMRcv',
                    PK: 'FTRcvCode'
                },
                Join: {
                    Table: ['TFNMRcv_L'],
                    On: ['TFNMRcv.FTRcvCode = TFNMRcv_L.FTRcvCode AND TFNMRcv_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: ["AND (TFNMRcv.FTRcvStaUse = '1')"]
                },
                GrideView: {
                    ColumnPathLang: 'payment/recive/recive',
                    ColumnKeyLang: ['tRCVTBCode', 'tRCVTBName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TFNMRcv.FTRcvCode', 'TFNMRcv_L.FTRcvName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TFNMRcv.FTRcvCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterRcvStaAll'],
                    Value: ['oetDSHSALFilterRcvCode', "TFNMRcv.FTRcvCode"],
                    Text: ['oetDSHSALFilterRcvName', "TFNMRcv_L.FTRcvName"]
                }
            };
            JCNxBrowseMultiSelect('oDSHSALBrowseRcvOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Product Group
    $('#odvDSHSALModalFilter #obtDSHSALBrowsePgp').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowsePgpOption = undefined;
            oDSHSALBrowsePgpOption = {
                Title: ["product/pdtgroup/pdtgroup", "tPGPTitle"],
                Table: {
                    Master: 'TCNMPdtGrp',
                    PK: 'FTPgpChain'
                },
                Join: {
                    Table: ['TCNMPdtGrp_L'],
                    On: ['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = ' + nLangEdits]
                },
                GrideView: {
                    ColumnPathLang: 'product/pdtgroup/pdtgroup',
                    ColumnKeyLang: ['tPGPCode', 'tPGPName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMPdtGrp.FTPgpChain ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterPgpStaAll'],
                    Value: ['oetDSHSALFilterPgpCode', "TCNMPdtGrp.FTPgpChain"],
                    Text: ['oetDSHSALFilterPgpName', "TCNMPdtGrp_L.FTPgpName"]
                }
            };
            JCNxBrowseMultiSelect('oDSHSALBrowsePgpOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi Product Type
    $('#odvDSHSALModalFilter #obtDSHSALBrowsePty').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowsePtyOption = undefined;
            oDSHSALBrowsePtyOption = {
                Title: ["product/pdttype/pdttype", "tPTYTitle"],
                Table: {
                    Master: 'TCNMPdtType',
                    PK: 'FTPtyCode'
                },
                Join: {
                    Table: ['TCNMPdtType_L'],
                    On: ['TCNMPdtType.FTPtyCode = TCNMPdtType_L.FTPtyCode AND TCNMPdtType_L.FNLngID = ' + nLangEdits]
                },
                GrideView: {
                    ColumnPathLang: 'product/pdttype/pdttype',
                    ColumnKeyLang: ['tPTYCode', 'tPTYName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMPdtType.FTPtyCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterPtyStaAll'],
                    Value: ['oetDSHSALFilterPtyCode', "TCNMPdtType.FTPtyCode"],
                    Text: ['oetDSHSALFilterPtyName', "TCNMPdtType_L.FTPtyName"]
                }
            }
            JCNxBrowseMultiSelect('oDSHSALBrowsePtyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Browse Multi WarHouse
    $('#odvDSHSALModalFilter #obtDSHSALFilterWah').unbind().click(function() {
        let nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oDSHSALBrowseWahOption = undefined;
            oDSHSALBrowseWahOption = {
                Title: ["company/warehouse/warehouse", "tWAHTitle"],
                Table: {
                    Master: 'TCNMWaHouse',
                    PK: 'FTWahCode'
                },
                Join: {
                    Table: ['TCNMWaHouse_L'],
                    On: ['TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits]
                },
                GrideView: {
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWahCode', 'tWahName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMWaHouse.FTWahCode ASC'],
                },
                CallBack: {
                    StausAll: ['oetDSHSALFilterWahStaAll'],
                    Value: ['oetDSHSALFilterWahCode', "TCNMWaHouse.FTWahCode"],
                    Text: ['oetDSHSALFilterWahName', "TCNMWaHouse_L.FTWahName"]
                }
            };
            JCNxBrowseMultiSelect('oDSHSALBrowseWahOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



    // จากยี่ห้อ
    $('#obtDSHSALFilterBrandFrom').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptBrandOptionFrom = undefined;
            oRptBrandOptionFrom = oRptBrandOption({
                'tReturnInputCode': 'oetDSHSALFilterBrandCodeFrom',
                'tReturnInputName': 'oetDSHSALFilterBrandNameFrom',
                'tNextFuncName': 'JSxRptConsNextFuncBrowseBrand',
                'aArgReturn': ['FTPbnCode', 'FTPbnName']
            });
            JCNxBrowseData('oRptBrandOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // ถึงยี่ห้อ
    $('#obtDSHSALFilterBrandTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptBrandOptionTo = undefined;
            oRptBrandOptionTo = oRptBrandOption({
                'tReturnInputCode': 'oetDSHSALFilterBrandCodeTo',
                'tReturnInputName': 'oetDSHSALFilterBrandNameTo',
                'tNextFuncName': 'JSxRptConsNextFuncBrowseBrand',
                'aArgReturn': ['FTPbnCode', 'FTPbnName']
            });
            JCNxBrowseData('oRptBrandOptionTo');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    var oRptBrandOption = function(poReturnInputBrand) {
        var tSesAgnCode = '<?php echo $this->session->userdata("tSesUsrAgnCode") ?>';
        if (tSesAgnCode != '') {
            tWhereAngCode = 'AND TCNMPdtBrand.FTAgnCode = ' + tSesAgnCode;
        } else {
            tWhereAngCode = '';
        }

        let tPbnNextFuncName = poReturnInputBrand.tNextFuncName;
        let aPbnArgReturn = poReturnInputBrand.aArgReturn;
        let tPbnInputReturnCode = poReturnInputBrand.tReturnInputCode;
        let tPbnInputReturnName = poReturnInputBrand.tReturnInputName;
        let oPbnOptionReturn = {
            Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
            Table: {
                Master: 'TCNMPdtBrand',
                PK: 'FTPbnCode'
            },
            Join: {
                Table: ['TCNMPdtBrand_L'],
                On: [
                    'TCNMPdtBrand.FTPbnCode = TCNMPdtBrand_L.FTPbnCode AND TCNMPdtBrand_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tWhereAngCode]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtbrand/pdtbrand',
                ColumnKeyLang: ['tPBNFrmPbnCode', 'tPBNFrmPbnName'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtBrand.FTPbnCode', 'TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtBrand.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPbnInputReturnCode, "TCNMPdtBrand.FTPbnCode"],
                Text: [tPbnInputReturnName, "TCNMPdtBrand_L.FTPbnName"]
            },
            NextFunc: {
                FuncName: tPbnNextFuncName,
                ArgReturn: aPbnArgReturn
            },
        };
        return oPbnOptionReturn;
    }







    // จากรุ่น
    $('#obtDSHSALFilterModelFrom').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptModelOptionFrom = undefined;
            oRptModelOptionFrom = oRptModelOption({
                'tReturnInputCode': 'oetDSHSALFilterModelCodeFrom',
                'tReturnInputName': 'oetDSHSALFilterModelNameFrom',
                'tNextFuncName': 'JSxRptConsNextFuncBrowseModel',
                'aArgReturn': ['FTPmoCode', 'FTPmoName']
            });
            JCNxBrowseData('oRptModelOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // ถึงรุ่น
    $('#obtDSHSALFilterModelTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptModelOptionTo = undefined;
            oRptModelOptionTo = oRptModelOption({
                'tReturnInputCode': 'oetDSHSALFilterModelCodeTo',
                'tReturnInputName': 'oetDSHSALFilterModelNameTo',
                'tNextFuncName': 'JSxRptConsNextFuncBrowseModel',
                'aArgReturn': ['FTPmoCode', 'FTPmoName']
            });
            JCNxBrowseData('oRptModelOptionTo');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });




    var oRptModelOption = function(poReturnInputModel) {
        var tSesAgnCode = '<?php echo $this->session->userdata("tSesUsrAgnCode") ?>';
        if (tSesAgnCode != '') {
            tWhereAngCode = 'AND TCNMPdtModel.FTAgnCode = ' + tSesAgnCode;
        } else {
            tWhereAngCode = '';
        }

        let tPmoNextFuncName = poReturnInputModel.tNextFuncName;
        let aPmoArgReturn = poReturnInputModel.aArgReturn;
        let tPmoInputReturnCode = poReturnInputModel.tReturnInputCode;
        let tPmoInputReturnName = poReturnInputModel.tReturnInputName;
        let oRptModelOption = {
            Title: ['product/pdtmodel/pdtmodel', 'tPMOTitle'],
            Table: {
                Master: 'TCNMPdtModel',
                PK: 'FTPmoCode'
            },
            Join: {
                Table: ['TCNMPdtModel_L'],
                On: [
                    'TCNMPdtModel.FTPmoCode = TCNMPdtModel_L.FTPmoCode AND TCNMPdtModel_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tWhereAngCode]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtmodel/pdtmodel',
                ColumnKeyLang: ['tPMOFrmPmoCode', 'tPMOFrmPmoName'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtModel.FTPmoCode', 'TCNMPdtModel_L.FTPmoName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtModel.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPmoInputReturnCode, "TCNMPdtModel.FTPmoCode"],
                Text: [tPmoInputReturnName, "TCNMPdtModel_L.FTPmoName"]
            },
            NextFunc: {
                FuncName: tPmoNextFuncName,
                ArgReturn: aPmoArgReturn
            },
        };
        return oRptModelOption;
    }







    // Browse Event Product
    $('#obtDSHSALFilterProductFTFrom').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptProductFromOption = undefined;
            oRptProductFromOption = oRptProductOption({
                'tReturnInputCode': 'oetDSHSALFilterProductFTCodeFrom',
                'tReturnInputName': 'oetDSHSALFilterProductFTNameFrom',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdt',
                'aArgReturn': ['FTPdtCode', 'FTPdtName']
            });
            JCNxBrowseData('oRptProductFromOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#obtDSHSALFilterProductFTTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptProductToOption = undefined;
            oRptProductToOption = oRptProductOption({
                'tReturnInputCode': 'oetDSHSALFilterProductFTCodeTo',
                'tReturnInputName': 'oetDSHSALFilterProductFTNameTo',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdt',
                'aArgReturn': ['FTPdtCode', 'FTPdtName']

            });
            JCNxBrowseData('oRptProductToOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    // Browse Event ProductType
    $('#obtDSHSALFilterTypeProductFTFrom').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptPdtTypeOptionFrom = undefined;
            oRptPdtTypeOptionFrom = oRptPdtTypeOption({
                'tReturnInputCode': 'oetDSHSALFilterTypeProductFTCodeFrom',
                'tReturnInputName': 'oetDSHSALFilterTypeProductFTNameFrom',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdtType',
                'aArgReturn': ['FTPtyCode', 'FTPtyName']

            });
            JCNxBrowseData('oRptPdtTypeOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#obtDSHSALFilterTypeProductFTTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptPdtTypeOptionTo = undefined;
            oRptPdtTypeOptionTo = oRptPdtTypeOption({
                'tReturnInputCode': 'oetDSHSALFilterTypeProductFTCodeTo',
                'tReturnInputName': 'oetDSHSALFilterTypeProductFTNameTo',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdtType',
                'aArgReturn': ['FTPtyCode', 'FTPtyName']
            });
            JCNxBrowseData('oRptPdtTypeOptionTo');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Browse Event ProductGroup
    $('#obtDSHSALFilterGroupProductFTFrom').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptPdtGrpOptionFrom = undefined;
            oRptPdtGrpOptionFrom = oRptPdtGrpOption({
                'tReturnInputCode': 'oetDSHSALFilterGroupProductFTCodeFrom',
                'tReturnInputName': 'oetDSHSALFilterGroupProductFTNameFrom',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdtGrp',
                'aArgReturn': ['FTPgpChain', 'FTPgpName']
            });
            JCNxBrowseData('oRptPdtGrpOptionFrom');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    $('#obtDSHSALFilterGroupProductFTTo').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptPdtGrpOptionTo = undefined;
            oRptPdtGrpOptionTo = oRptPdtGrpOption({
                'tReturnInputCode': 'oetDSHSALFilterGroupProductFTCodeTo',
                'tReturnInputName': 'oetDSHSALFilterGroupProductFTNameTo',
                'tNextFuncName': 'JSxRptConsNextFuncBrowsePdtGrp',
                'aArgReturn': ['FTPgpChain', 'FTPgpName']
            });
            JCNxBrowseData('oRptPdtGrpOptionTo');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });








    // Browse Product Option
    var oRptProductOption = function(poReturnInputPdt) {
        let tPdtInputReturnCode = poReturnInputPdt.tReturnInputCode;
        let tPdtInputReturnName = poReturnInputPdt.tReturnInputName;
        let tPdtNextFuncName = poReturnInputPdt.tNextFuncName;
        let aPdtArgReturn = poReturnInputPdt.aArgReturn;
        let tCondition = '';

        tCondition = " AND TCNMPdt.FTPdtForSystem = 1 AND TCNMPdt.FTPdtStaActive = 1 ";

        // let tBchCodeSess = $('#oetRptBchCodeSelect').val();
        // if (tBchCodeSess != '' && tBchCodeSess != undefined) {
        //     tBchcode = tBchCodeSess.replace(/,/g, "','");
        //     tCondition += " AND ( TCNMPdtSpcBch.FTBchCode IN ('" + tBchcode + "') OR ( TCNMPdtSpcBch.FTBchCode IS NULL OR TCNMPdtSpcBch.FTBchCode ='' )  )";
        // }

        let tAgnCode = $('#oetDSHSALFilterAgnCode').val();
        if (tAgnCode != '' && tAgnCode != undefined) {
            tCondition += " AND TCNMPdtSpcBch.FTAgnCode = '" + tAgnCode + "' ";
        }

        let oPdtOptionReturn = {
            Title: ["product/product/product", "tPDTTitle"],
            Table: {
                Master: "TCNMPdt",
                PK: "FTPdtCode"
            },
            Join: {
                Table: ["TCNMPdt_L", 'TCNMPdtSpcBch'],
                On: [
                    'TCNMPdt.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits,
                    'TCNMPdtSpcBch.FTPdtCode = TCNMPdt.FTPdtCode'
                ]
            },
            Where: {
                Condition: [tCondition]
            },
            GrideView: {
                ColumnPathLang: 'product/product/product',
                ColumnKeyLang: ['tPDTCode', 'tPDTName'],
                DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: ['15%', '75%'],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMPdt.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPdtInputReturnCode, "TCNMPdt.FTPdtCode"],
                Text: [tPdtInputReturnName, "TCNMPdt_L.FTPdtName"]
            },
            NextFunc: {
                FuncName: tPdtNextFuncName,
                ArgReturn: aPdtArgReturn
            },
            RouteAddNew: 'product',
            BrowseLev: 1
        };
        return oPdtOptionReturn;
    }

    // Browse Product Type Option
    var oRptPdtTypeOption = function(poReturnInputPty) {
        let tPtyInputReturnCode = poReturnInputPty.tReturnInputCode;
        let tPtyInputReturnName = poReturnInputPty.tReturnInputName;
        let tPtyNextFuncName = poReturnInputPty.tNextFuncName;
        let aPtyArgReturn = poReturnInputPty.aArgReturn;
        let tCondition = '';
        let tAgnCode = $('#oetDSHSALFilterAgnCode').val();
        if (tAgnCode != '' && tAgnCode != undefined) {
            tCondition += " AND TCNMPdtType.FTAgnCode = '" + tAgnCode + "' ";
        }

        let oPtyOptionReturn = {
            Title: ['product/pdttype/pdttype', 'tPTYTitle'],
            Table: {
                Master: 'TCNMPdtType',
                PK: 'FTPtyCode'
            },
            Join: {
                Table: ['TCNMPdtType_L'],
                On: ['TCNMPdtType_L.FTPtyCode = TCNMPdtType.FTPtyCode AND TCNMPdtType_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tCondition]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtType.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPtyInputReturnCode, "TCNMPdtType.FTPtyCode"],
                Text: [tPtyInputReturnName, "TCNMPdtType_L.FTPtyName"]
            },
            NextFunc: {
                FuncName: tPtyNextFuncName,
                ArgReturn: aPtyArgReturn
            },
            RouteAddNew: 'pdttype',
            BrowseLev: 1
        };
        return oPtyOptionReturn;
    }

    // Option Product Group Option
    var oRptPdtGrpOption = function(poReturnInputPgp) {
        let tPgpNextFuncName = poReturnInputPgp.tNextFuncName;
        let aPgpArgReturn = poReturnInputPgp.aArgReturn;
        let tPgpInputReturnCode = poReturnInputPgp.tReturnInputCode;
        let tPgpInputReturnName = poReturnInputPgp.tReturnInputName;
        let tCondition = '';
        let tAgnCode = $('#oetDSHSALFilterAgnCode').val();
        if (tAgnCode != '' && tAgnCode != undefined) {
            tCondition += " AND TCNMPdtGrp.FTAgnCode = '" + tAgnCode + "' ";
        }

        let oPgpOptionReturn = {
            Title: ['product/pdtgroup/pdtgroup', 'tPGPTitle'],
            Table: {
                Master: 'TCNMPdtGrp',
                PK: 'FTPgpChain'
            },
            Join: {
                Table: ['TCNMPdtGrp_L'],
                On: ['TCNMPdtGrp_L.FTPgpChain = TCNMPdtGrp.FTPgpChain AND TCNMPdtGrp_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tCondition]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPdtGrp.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tPgpInputReturnCode, "TCNMPdtGrp.FTPgpChain"],
                Text: [tPgpInputReturnName, "TCNMPdtGrp_L.FTPgpName"]
            },
            NextFunc: {
                FuncName: tPgpNextFuncName,
                ArgReturn: aPgpArgReturn
            },
        };
        return oPgpOptionReturn;
    }
</script>