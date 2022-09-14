<style>
    .xCNIconContentAPI  {  width:15px; height:15px; background-color:#e84393; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentDOC  {  width:15px; height:15px; background-color:#ffca28; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentPOS  {  width:15px; height:15px; background-color:#42a5f5; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentSL   {  width:15px; height:15px; background-color:#ff9030; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentWEB  {  width:15px; height:15px; background-color:#99cc33; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentVD   {  width:15px; height:15px; background-color:#dbc559; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentALL  {  width:15px; height:15px; background-color:#ff5733; display: inline-block; margin-right: 10px; margin-top: 0px; }
    .xCNIconContentETC  {  width:15px; height:15px; background-color:#92918c; display: inline-block; margin-right: 10px; margin-top: 0px; }

    /* .xCNTableScrollY{
        overflow-y      : auto; 
    } */

    .xCNCheckboxBlockDefault:before{
        background      : #ededed !important;
    }

    .xCNInputBlock{
        background      : #ededed !important;
        pointer-events  : none;
    }

    #ospDetailFooter{
        font-weight     : bold;
    }

</style>

<!-- TABLE สำหรับ checkbox -->
<div class="row">
    <div class="col-md-12">
        <!-- <div class="table-responsive xCNTableScrollY xCNTableHeightCheckbox">  ของ เดิม -->
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%" id="otbTableForCheckbox">
                <thead>
					<tr class="xCNCenter">
						<th class="xCNTextBold" style="text-align:left; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableType')?></th>
						<th class="xCNTextBold" style="text-align:left;"><?= language('settingconfig/settingconfig/settingconfig','tTableDetail')?></th>
                        <th class="xCNTextBold" style="text-align:left;"><?= language('settingconfig/settingconfig/settingconfig','tTableDescrption')?></th>
                        <th class="xCNTextBold" style="color:#3a5cff !important; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueNormal')?></th>
                        <th class="xCNTextBold" style="color:#3a5cff !important; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueMake')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aResListCheckbox['rtCode'] == 1 ):?>
                        <?php foreach($aResListCheckbox['raItems'] AS $key=>$aValue){ ?>
                            <tr class="text-center xCNTextDetail2" style="cursor: pointer;" onclick="JSxAppendSpanDetail(this,'checkbox')">
                                <?php 
                                    // $tContentImage = "<div class='xCNIconContentAPI'></div><span>".$aValue['FTAppName']."</span>";
                                    $tContentImage = $aValue['FTAppName'];
                                    // switch ($aValue['FTSysApp']) {
                                    //     case "API":
                                    //         $tContentImage = "<div class='xCNIconContentAPI'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionAPI')."</span>";
                                    //         break;
                                    //     case "DOC":
                                    //         $tContentImage = "<div class='xCNIconContentDOC'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionDOC')."</span>";
                                    //         break;
                                    //     case "POS":
                                    //         $tContentImage = "<div class='xCNIconContentPOS'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionPOS')."</span>";
                                    //         break;
                                    //     case "SL":
                                    //         $tContentImage = "<div class='xCNIconContentSL'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionSL')."</span>";
                                    //         break;
                                    //     case "WEB":
                                    //         $tContentImage = "<div class='xCNIconContentWEB'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionWEB')."</span>";
                                    //         break;
                                    //     case "VD":
                                    //         $tContentImage = "<div class='xCNIconContentVD'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionVD')."</span>";
                                    //         break;
                                    //     case "ALL":
                                    //         $tContentImage = "<div class='xCNIconContentALL'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionALL')."</span>";
                                    //         break;
                                    //     default:
                                    //         $tContentImage = "<div class='xCNIconContentETC'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionETC')."</span>";
                                    // }
                                ?>
                                <td style="text-align:left;"><?=$tContentImage?></td>
                                <td style="text-align:left;"><?=$aValue['FTSysName']?></td>
                                <td style="text-align:left;"><?=($aValue['FTSysDesc'] == '') ? '-' : $aValue['FTSysDesc'];?></td>
                                    
                                <?php if($aValue['FTSysStaDefValue'] == 1){ $tCheckDef = 'checked'; $tClassBlock = ''; }else{ $tCheckDef = ''; $tClassBlock = 'xCNCheckboxBlockDefault'; } ?>
                                <td>
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" disabled <?=$tCheckDef?>><span class='<?=$tClassBlock?>' style="cursor: default;"></span>
                                    </label>
                                </td>
                                <?php if($aValue['FTSysStaUsrValue'] == 1){ $tCheckValue = 'checked'; }else{ $tCheckValue = '';} ?>
                                <td>
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" 
                                            <?=$aValue['FTSysStaAlwEdit'] == 0 ?'disabled' : ''; ?>
                                            data-SysCode='<?=$aValue['FTSysCode']?>' 
                                            data-SysApp='<?=$aValue['FTSysApp']?>' 
                                            data-SysKey='<?=$aValue['FTSysKey']?>'
                                            data-SysSeq='<?=$aValue['FTSysSeq']?>' 
                                            <?=$tCheckValue?> onclick="JSxEventClickCheckbox(this);"><span></span>
                                    </label>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='8'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ขีดเส้นใต้คั่นตาราง -->
<div><hr></div>

<!-- TABLE สำหรับ input ประเภทอื่นๆ -->
<div class="row">
    <div class="col-md-12">
        <!-- <div class="table-responsive xCNTableScrollY xCNTableHeightInput">   ของเดิม -->
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%" id="otbTableForInput">
                <thead>
					<tr class="xCNCenter">
						<th class="xCNTextBold" style="text-align:left; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableType')?></th>
						<th class="xCNTextBold" style="text-align:left;"><?= language('settingconfig/settingconfig/settingconfig','tTableDetail')?></th>
                        <th class="xCNTextBold" style="text-align:left;"><?= language('settingconfig/settingconfig/settingconfig','tTableDescrption')?></th>
                        <th class="xCNTextBold" style="text-align:left; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueNormal')?></th>
                        <th class="xCNTextBold" style="text-align:left; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableRef')?></th>
                        <th class="xCNTextBold" style="color:#3a5cff !important; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableValueMake')?></th>
                        <th class="xCNTextBold" style="color:#3a5cff !important; width:160px;"><?= language('settingconfig/settingconfig/settingconfig','tTableRef')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aResListInputText['rtCode'] == 1 ):?>
                        <?php foreach($aResListInputText['raItems'] AS $key=>$aValue){ ?>
                            <tr class="text-center xCNTextDetail2" style="cursor: pointer;" onclick="JSxAppendSpanDetail(this,'input')">
                                <?php 
                                    // $tContentImage = "<div class='xCNIconContentAPI'></div><span>".$aValue['FTAppName']."</span>";
                                    $tContentImage = $aValue['FTAppName'];
                                    // switch ($aValue['FTSysApp']) {
                                    //     case "API":
                                    //         $tContentImage = "<div class='xCNIconContentAPI'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionAPI')."</span>";
                                    //         break;
                                    //     case "DOC":
                                    //         $tContentImage = "<div class='xCNIconContentDOC'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionDOC')."</span>";
                                    //         break;
                                    //     case "POS":
                                    //         $tContentImage = "<div class='xCNIconContentPOS'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionPOS')."</span>";
                                    //         break;
                                    //     case "SL":
                                    //         $tContentImage = "<div class='xCNIconContentSL'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionSL')."</span>";
                                    //         break;
                                    //     case "WEB":
                                    //         $tContentImage = "<div class='xCNIconContentWEB'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionWEB')."</span>";
                                    //         break;
                                    //     case "VD":
                                    //         $tContentImage = "<div class='xCNIconContentVD'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionVD')."</span>";
                                    //         break;
                                    //     case "ALL":
                                    //         $tContentImage = "<div class='xCNIconContentALL'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionALL')."</span>";
                                    //         break;
                                    //     default:
                                    //         $tContentImage = "<div class='xCNIconContentETC'></div><span>".language('settingconfig/settingconfig/settingconfig','tOptionETC')."</span>";
                                    // }
                                ?>
                                <td style="text-align:left;"><?=$tContentImage?></td>
                                <td style="text-align:left;"><?=$aValue['FTSysName']?></td>
                                <td style="text-align:left;"><?=($aValue['FTSysDesc']  == '') ? '-' : $aValue['FTSysDesc']; ?></td>
                                <td style="text-align:left;"><?=$aValue['FTSysStaDefValue']?></td>
                                <td style="text-align:left;"><?=$aValue['FTSysStaDefRef']?></td>

                                <?php 
                                    if($aValue['FTSysStaAlwEdit'] == 0){
                                        $tClassInputBlock = 'xCNInputBlock';
                                    }else{
                                        $tClassInputBlock = '';
                                    }

                                    $tID = $aValue['FTSysCode'] . $aValue['FTSysApp'] . $aValue['FTSysKey'] . $aValue['FTSysSeq'];
                                    switch ($aValue['FTSysStaDataType']) {
                                        case "0": //TEXT
                                            $nMaxLength         = 255;
                                            $tContentMake       = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make',
                                                                    data-inputtype  = '0'
                                                                    class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrValue']."' maxlength='".$nMaxLength."'>";
                                            $tContentRef        = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '0'
                                                                    class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrRef']."' maxlength='".$nMaxLength."'>";
                                            break;
                                        case "1": //INT
                                            $nMaxLength         = 255;
                                            $tContentMake       = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make'
                                                                    data-inputtype  = '1'
                                                                    class='xCNInputNumericWithoutDecimal xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrValue']."' maxlength='".$nMaxLength."'>";
                                            $tContentRef        = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '1'
                                                                    class='xCNInputNumericWithoutDecimal xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrRef']."' maxlength='".$nMaxLength."'>";
                                            break;
                                        case "2": //DOUBLE
                                            $nMaxLength         = 255;
                                            $tContentMake       = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make'
                                                                    data-inputtype  = '2'
                                                                    class='xCNInputNumericWithDecimal xCNInputValue' value='".$aValue['FTSysStaUsrValue']."' maxlength='".$nMaxLength."'>";
                                            $tContentRef        = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '2'
                                                                    class='xCNInputNumericWithDecimal xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrRef']."' maxlength='".$nMaxLength."'>";
                                            break;
                                        case "3": //DATE
                                            $nMaxLength         = 255;
                                            if($aValue['FTSysStaUsrValue'] != ''){  $dDateMake  = $aValue['FTSysStaUsrValue']; }else{   $dDateMake  = date('Y-m-d'); }
                                            if($aValue['FTSysStaUsrRef'] != ''){    $dDateRef   = $aValue['FTSysStaUsrRef']; }else{     $dDateRef   = date('Y-m-d'); }
                                            $tContentMake  = "<div class='input-group'>
                                                                        <input type='text' 
                                                                        data-SysCode    = '".$aValue['FTSysCode']."'
                                                                        data-SysApp     = '".$aValue['FTSysApp']."'
                                                                        data-SysKey     = '".$aValue['FTSysKey']."'
                                                                        data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                        data-Kind       = 'Make'
                                                                        data-inputtype  = '3'
                                                                        class='form-control text-center xCNDatePicker xCNInputMaskDate xCNInputDateValue' id='oetDateMake".$tID."'
                                                                        value=".$dDateMake.">
                                                                        <span class='input-group-btn'>
                                                                            <button type='button' class='btn xCNBtnDateTime' onclick=JSxClickPopUpcalendar('Make','".$tID."')>
                                                                                <img src='".base_url()."application/modules/common/assets/images/icons/icons8-Calendar-100.png'>
                                                                            </button>
                                                                        </span>
                                                                    </div>";
                                            $tContentRef    = "<div class='input-group'>
                                                                    <input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '3'
                                                                    class='form-control text-center xCNDatePicker xCNInputMaskDate xCNInputDateValue' id='oetDateRef".$tID."'
                                                                    value=".$dDateRef.">
                                                                    <span class='input-group-btn'>
                                                                        <button type='button' class='btn xCNBtnDateTime' onclick=JSxClickPopUpcalendar('Ref','".$tID."')>
                                                                            <img src='".base_url()."application/modules/common/assets/images/icons/icons8-Calendar-100.png'>
                                                                        </button>
                                                                    </span>
                                                                </div>";
                                            break;
                                        case "5": //COMBO
                                            //รูปแบบการ ที่ใช้ตรวจสอบการเข้าใช้งานของผู้ใช้	
                                            if($aValue['FTSysCode'] == 'tCN_UsrSignInType' 
                                                && $aValue['FTSysApp'] == 'ALL' 
                                                && $aValue['FTSysKey'] == 'ADMIN' 
                                                && $aValue['FTSysSeq'] == '1'){
                                                    $tValueMake      = $aValue['FTSysStaUsrValue'];
                                                    if($tValueMake == 1){ $tSelectedMake1 = 'selected'; }else{ $tSelectedMake1 = ''; }
                                                    if($tValueMake == 2){ $tSelectedMake2 = 'selected'; }else{ $tSelectedMake2 = ''; }
                                                    if($tValueMake == 3){ $tSelectedMake3 = 'selected'; }else{ $tSelectedMake3 = ''; }
                                                    if($tValueMake == 4){ $tSelectedMake4 = 'selected'; }else{ $tSelectedMake4 = ''; }
                                                    $tContentMake    = "<div>";
                                                    $tContentMake   .= "<select 
                                                                        data-SysCode    = '".$aValue['FTSysCode']."'
                                                                        data-SysApp     = '".$aValue['FTSysApp']."'
                                                                        data-SysKey     = '".$aValue['FTSysKey']."'
                                                                        data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                        data-Kind       = 'Make'
                                                                        data-inputtype  = '5'
                                                                        class='form-control xCNOptionValue' id='osmMakeBrowseID".$tID."'>";
                                                    $tContentMake   .= '<option value="1" '.$tSelectedMake1.'>Password</option>';
                                                    $tContentMake   .= '<option value="2" '.$tSelectedMake2.'>Pin</option>';
                                                    $tContentMake   .= '<option value="3" '.$tSelectedMake3.'>RFID</option>';
                                                    $tContentMake   .= '<option value="4" '.$tSelectedMake4.'>QR</option>';
                                                    $tContentMake   .= "</select>";
                                                    $tContentMake   .= "</div>";

                                                    $tValueRef      = $aValue['FTSysStaUsrRef'];
                                                    if($tValueRef == 1){ $tSelectedRef1 = 'selected'; }else{ $tSelectedRef1 = ''; }
                                                    if($tValueRef == 2){ $tSelectedRef2 = 'selected'; }else{ $tSelectedRef2 = ''; }
                                                    if($tValueRef == 3){ $tSelectedRef3 = 'selected'; }else{ $tSelectedRef3 = ''; }
                                                    if($tValueRef == 4){ $tSelectedRef4 = 'selected'; }else{ $tSelectedRef4 = ''; }
                                                    $tContentRef    = "<div>";
                                                    $tContentRef   .= "<select 
                                                                        data-SysCode    = '".$aValue['FTSysCode']."'
                                                                        data-SysApp     = '".$aValue['FTSysApp']."'
                                                                        data-SysKey     = '".$aValue['FTSysKey']."'
                                                                        data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                        data-Kind       = 'Ref'
                                                                        data-inputtype  = '5'
                                                                        class='form-control xCNOptionValue id='osmRefBrowseID".$tID."'>";
                                                    $tContentRef   .= '<option value="1" '.$tSelectedRef1.'>Password</option>';
                                                    $tContentRef   .= '<option value="2" '.$tSelectedRef2.'>Pin</option>';
                                                    $tContentRef   .= '<option value="3" '.$tSelectedRef3.'>RFID</option>';
                                                    $tContentRef   .= '<option value="4" '.$tSelectedRef4.'>QR</option>';
                                                    $tContentRef   .= "</select>";
                                                    $tContentRef   .= "</div>";
                                            }else{
                                                //รูปแบบของที่อยู่
                                                $tValueMake      = $aValue['FTSysStaUsrValue'];
                                                if($tValueMake == 1){ $tSelectedMake1 = 'selected'; }else{ $tSelectedMake1 = ''; }
                                                if($tValueMake == 2){ $tSelectedMake2 = 'selected'; }else{ $tSelectedMake2 = ''; }
                                                $tContentMake    = "<div>";
                                                $tContentMake   .= "<select  
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make'
                                                                    data-inputtype  = '5'
                                                                    class='form-control xCNOptionValue' id='osmMakeBrowseID".$tID."'>";
                                                $tContentMake   .= '<option value="1" '.$tSelectedMake1.'>'.language('settingconfig/settingconfig/settingconfig','tAddressOut').'</option>';
                                                $tContentMake   .= '<option value="2" '.$tSelectedMake2.'>'.language('settingconfig/settingconfig/settingconfig','tAddressIn').'</option>';
                                                $tContentMake   .= "</select>";
                                                $tContentMake   .= "</div>";

                                                $tValueRef      = $aValue['FTSysStaUsrRef'];
                                                if($tValueRef == 1){ $tSelectedRef1 = 'selected'; }else{ $tSelectedRef1 = ''; }
                                                if($tValueRef == 2){ $tSelectedRef2 = 'selected'; }else{ $tSelectedRef2 = ''; }
                                                $tContentRef    = "<div>";
                                                $tContentRef   .= "<select 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '5'
                                                                    class='form-control xCNOptionValue' id='osmRefBrowseID".$tID."'>";
                                                $tContentRef   .= '<option value="1" '.$tSelectedRef1.'>'.language('settingconfig/settingconfig/settingconfig','tAddressOut').'</option>';
                                                $tContentRef   .= '<option value="2" '.$tSelectedRef2.'>'.language('settingconfig/settingconfig/settingconfig','tAddressIn').'</option>';
                                                $tContentRef   .= "</select>";
                                                $tContentRef   .= "</div>";
                                            }
                                            break;
                                        case "6": //BROWSE
                                            $tContentMake   =   "<div class='input-group'>
                                                                    <input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make'
                                                                    data-inputtype  = '6'
                                                                    class='form-control xCNHide xCNBrowseValue' id='oetMakeBrowseID".$tID."' name='oetMakeBrowseID".$tID."' value='".$aValue['FTSysStaUsrValue']."'>
                                                                    <input type='text' class='form-control xWPointerEventNone' id='oetMakeBrowseName".$tID."' name='oetMakeBrowseName".$tID."'
                                                                    value='".$aValue['FTSysStaUsrValue']."' readonly>
                                                                    <span class='input-group-btn'>
                                                                        <button type='button' class='btn xCNBtnBrowseAddOn' onclick=JSxClickMakeBrowse('".$tID."','oBrowseMakeWah')>
                                                                            <img src='".base_url()."/application/modules/common/assets/images/icons/find-24.png'>
                                                                        </button>
                                                                    </span>
                                                                </div>";
                                            $tContentRef    =   "<div class='input-group'>
                                                                    <input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = '6'
                                                                    class='form-control xCNHide xCNBrowseValue' id='oetRefBrowseID".$tID."' name='oetRefBrowseID".$tID."' value='".$aValue['FTSysStaUsrRef']."'>
                                                                    <input type='text' class='form-control xWPointerEventNone' id='oetRefBrowseName".$tID."' name='oetRefBrowseName".$tID."'
                                                                    value='".$aValue['FTSysStaUsrRef']."' readonly>
                                                                    <span class='input-group-btn'>
                                                                        <button type='button' class='btn xCNBtnBrowseAddOn' onclick=JSxClickRefBrowse('".$tID."','oBrowseRefWah')>
                                                                            <img src='".base_url()."/application/modules/common/assets/images/icons/find-24.png'>
                                                                        </button>
                                                                    </span>
                                                                </div>";
                                            break;
                                            case "7": //PASSWORD
                                                $nMaxLength         = 255;
                                                $tContentMake       = "<input type='password' 
                                                                        data-SysCode    = '".$aValue['FTSysCode']."'
                                                                        data-SysApp     = '".$aValue['FTSysApp']."'
                                                                        data-SysKey     = '".$aValue['FTSysKey']."'
                                                                        data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                        data-oldpws     = '".$aValue['FTSysStaUsrValue']."'
                                                                        data-Kind       = 'Make',
                                                                        data-inputtype  = '7'
                                                                        class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrValue']."' maxlength='".$nMaxLength."'>";
                                                $tContentRef        = "<input type='password' 
                                                                        data-SysCode    = '".$aValue['FTSysCode']."'
                                                                        data-SysApp     = '".$aValue['FTSysApp']."'
                                                                        data-SysKey     = '".$aValue['FTSysKey']."'
                                                                        data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                        data-oldpws     = '".$aValue['FTSysStaUsrRef']."'
                                                                        data-Kind       = 'Ref'
                                                                        data-inputtype  = '7'
                                                                        class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrRef']."' maxlength='".$nMaxLength."'>";
                                            break;
                                        default:
                                            $nMaxLength         = 255;
                                            $tContentMake       = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Make'
                                                                    data-inputtype  = ''
                                                                    class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrValue']."' maxlength='".$nMaxLength."'>";
                                            $tContentRef        = "<input type='text' 
                                                                    data-SysCode    = '".$aValue['FTSysCode']."'
                                                                    data-SysApp     = '".$aValue['FTSysApp']."'
                                                                    data-SysKey     = '".$aValue['FTSysKey']."'
                                                                    data-SysSeq     = '".$aValue['FTSysSeq']."'
                                                                    data-Kind       = 'Ref'
                                                                    data-inputtype  = ''
                                                                    class='xCNInputValue $tClassInputBlock' value='".$aValue['FTSysStaUsrRef']."' maxlength='".$nMaxLength."'>";
                                    }
                                ?>

                                <td style="text-align:left;"><?=$tContentMake?></td>
                                <td style="text-align:left;"><?=$tContentRef?></td>
                            </tr>
                        <?php } ?>
                    <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='8'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row" style="margin-top:10px;" id="odvContentFooterText">
    <div class="col-md-12">
        <span id="ospDetailFooter"><?= language('settingconfig/settingconfig/settingconfig','tDetail')?> : </span><span id="ospDetailFooterText"></span>
    </div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>

    $(function(){
        JSxConfigEachValueToArray();
    });
  
    $('#odvContentFooterText').hide();
    $('.xCNDatePicker').datepicker({
        format          : 'yyyy-mm-dd',
        autoclose       : true,
        todayHighlight  : true,
        startDate       : new Date()
    });

    //Browse ปฎิทิน
    function JSxClickPopUpcalendar(ptID,elemID){
        $('#oetDate'+ptID+elemID).datepicker('show');
    }

    //Browse คลัง(กำหนดเอง)
    var nLangEdits = <?=$this->session->userdata("tLangEdit")?>;
    var oBrowseMakeWah = {
        Title   : [ 'company/warehouse/warehouse','tWAHTitle'],
        Table   : { Master:'TCNMWaHouse' , PK:'FTWahCode'},
        Join    :   {
            Table   :	['TCNMWaHouse_L'],
            On      :   ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
        },
        GrideView   :   {
            ColumnPathLang	: 'company/warehouse/warehouse',
            ColumnKeyLang	: ['tWahCode','tWahName'],
            DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            ColumnsSize     : ['15%','75%'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMWaHouse.FTWahCode'],
            SourceOrder		: "ASC"
        },
        CallBack    :   {
            ReturnType	: 'S',
            Value		: ["oetMakeBrowseID","TCNMWaHouse.FTWahCode"],
            Text		: ["oetMakeBrowseName","TCNMWaHouse_L.FTWahCode"],
        }
    }
    function JSxClickMakeBrowse(elemID,ptBrowseName){
        oBrowseMakeWah.CallBack.Value[0]    = 'oetMakeBrowseID' + elemID;
        oBrowseMakeWah.CallBack.Text[0]     = 'oetMakeBrowseName' + elemID;
        JCNxBrowseData(ptBrowseName);
    }

    //Browse คลัง(ค่าอ้างอิง)
    var oBrowseRefWah = {
        Title   : [ 'company/warehouse/warehouse','tWAHTitle'],
        Table   : { Master:'TCNMWaHouse' , PK:'FTWahCode'},
        Join    :   {
            Table   :	['TCNMWaHouse_L'],
            On      :   ['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
        },
        GrideView   :   {
            ColumnPathLang	: 'company/warehouse/warehouse',
            ColumnKeyLang	: ['tWahCode','tWahName'],
            DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
            ColumnsSize     : ['15%','75%'],
            DataColumnsFormat : ['',''],
            WidthModal      : 50,
            Perpage			: 10,
            OrderBy			: ['TCNMWaHouse.FTWahCode'],
            SourceOrder		: "ASC"
        },
        CallBack    :   {
            ReturnType	: 'S',
            Value		: ["oetRefBrowseID","TCNMWaHouse.FTWahCode"],
            Text		: ["oetRefBrowseName","TCNMWaHouse_L.FTWahCode"],
        }
    }
    function JSxClickRefBrowse(elemID,ptBrowseName){
        oBrowseRefWah.CallBack.Value[0]    = 'oetRefBrowseID' + elemID;
        oBrowseRefWah.CallBack.Text[0]     = 'oetRefBrowseName' + elemID;
        JCNxBrowseData(ptBrowseName);
    }

    //-เก็บข้อมูลลง Array
    function JSxConfigEachValueToArray(){
    
        //Input Text , int , double ถูก change ต้องเก็บค่าไว้ใน array
        var aPackDataInput = [];
        // $('.xCNInputValue').keyup(function(elem) {
        $('.xCNInputValue').each(function(elem) {
            var tSyscode    = $(this).attr('data-syscode');
            var tSysapp     = $(this).attr('data-sysapp');
            var tSyskey     = $(this).attr('data-syskey');
            var tSysseq     = $(this).attr('data-sysseq');
            var tOldpws     = $(this).attr('data-oldpws');
            var tKind       = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
            var tInputType  = $(this).attr('data-inputtype');
            var tInputValue = $(this).val();
            var nLenArray   = aPackDataInput.length;
            if(nLenArray >= 1){
                for($i=0; $i<aPackDataInput.length; $i++){
                    if(tSyscode == aPackDataInput[$i]['tSyscode'] 
                        && tSysapp == aPackDataInput[$i]['tSysapp']
                        && tSyskey == aPackDataInput[$i]['tSyskey']
                        && tSysseq == aPackDataInput[$i]['tSysseq'] 
                        && tKind == aPackDataInput[$i]['tKind'] ){
                            aPackDataInput.splice($i, 1);
                    }
                }
            }

            //เก็บค่าไว้ใน array
            var aSubValue   = {
                'tSyscode'  : tSyscode , 
                'tSysapp'   : tSysapp ,
                'tSyskey'   : tSyskey ,
                'tSysseq'   : tSysseq ,
                'tOldpws'   : tOldpws,
                'nValue'    : tInputValue ,
                'tKind'     : tKind ,
                'tType'     : tInputType
            };
            aPackDataInput.push(aSubValue);
        });

        //Option ถูก change ต้องเก็บค่าไว้ใน array
        $('.xCNOptionValue').each(function(elem) {
            var tSyscode        = $(this).attr('data-syscode');
            var tSysapp         = $(this).attr('data-sysapp');
            var tSyskey         = $(this).attr('data-syskey');
            var tSysseq         = $(this).attr('data-sysseq');
            var tKind           = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
            var tInputType      = $(this).attr('data-inputtype');
            var nOptionValue    = $('option:selected',this).val();
            var nLenArray       = aPackDataInput.length;
            if(nLenArray >= 1){
                for($i=0; $i<aPackDataInput.length; $i++){
                    if(tSyscode == aPackDataInput[$i]['tSyscode'] 
                        && tSysapp == aPackDataInput[$i]['tSysapp']
                        && tSyskey == aPackDataInput[$i]['tSyskey']
                        && tSysseq == aPackDataInput[$i]['tSysseq'] 
                        && tKind == aPackDataInput[$i]['tKind'] ){
                            aPackDataInput.splice($i, 1);
                    }
                }
            }

            //เก็บค่าไว้ใน array
            var aSubValue   = {
                'tSyscode'  : tSyscode , 
                'tSysapp'   : tSysapp ,
                'tSyskey'   : tSyskey ,
                'tSysseq'   : tSysseq ,
                'nValue'    : nOptionValue ,
                'tKind'     : tKind ,
                'tType'     : tInputType
            };
            aPackDataInput.push(aSubValue);
        });

        //Input Date ถูก change ต้องเก็บค่าไว้ใน array
        $('.xCNInputDateValue').each(function(elem) {
            var tSyscode        = $(this).attr('data-syscode');
            var tSysapp         = $(this).attr('data-sysapp');
            var tSyskey         = $(this).attr('data-syskey');
            var tSysseq         = $(this).attr('data-sysseq');
            var tKind           = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
            var tInputType      = $(this).attr('data-inputtype');
            var dDate           = $(this).val();
            var nLenArray       = aPackDataInput.length;
            if(nLenArray >= 1){
                for($i=0; $i<aPackDataInput.length; $i++){
                    if(tSyscode == aPackDataInput[$i]['tSyscode'] 
                        && tSysapp == aPackDataInput[$i]['tSysapp']
                        && tSyskey == aPackDataInput[$i]['tSyskey']
                        && tSysseq == aPackDataInput[$i]['tSysseq'] 
                        && tKind == aPackDataInput[$i]['tKind'] ){
                            aPackDataInput.splice($i, 1);
                    }
                }
            }

            //เก็บค่าไว้ใน array
            var aSubValue   = {
                'tSyscode'  : tSyscode , 
                'tSysapp'   : tSysapp ,
                'tSyskey'   : tSyskey ,
                'tSysseq'   : tSysseq ,
                'nValue'    : dDate ,
                'tKind'     : tKind ,
                'tType'     : tInputType
            };
            aPackDataInput.push(aSubValue);
        });

        //Input Browse ถูก change ต้องเก็บค่าไว้ใน array
        $('.xCNBrowseValue').each(function(elem) {
            var tSyscode        = $(this).attr('data-syscode');
            var tSysapp         = $(this).attr('data-sysapp');
            var tSyskey         = $(this).attr('data-syskey');
            var tSysseq         = $(this).attr('data-sysseq');
            var tKind           = $(this).attr('data-kind'); // แก้ไขที่ค่ากำหนดเอง (MAKE) , แก้ไขที่ค่าอ้างอิง (REF)
            var tInputType      = $(this).attr('data-inputtype');
            var tValue          = $(this).val();
            var nLenArray       = aPackDataInput.length;
            if(nLenArray >= 1){
                for($i=0; $i<aPackDataInput.length; $i++){
                    if(tSyscode == aPackDataInput[$i]['tSyscode'] 
                        && tSysapp == aPackDataInput[$i]['tSysapp']
                        && tSyskey == aPackDataInput[$i]['tSyskey']
                        && tSysseq == aPackDataInput[$i]['tSysseq'] 
                        && tKind == aPackDataInput[$i]['tKind'] ){
                            aPackDataInput.splice($i, 1);
                    }
                }
            }

            //เก็บค่าไว้ใน array
            var aSubValue   = {
                'tSyscode'  : tSyscode , 
                'tSysapp'   : tSysapp ,
                'tSyskey'   : tSyskey ,
                'tSysseq'   : tSysseq ,
                'nValue'    : tValue ,
                'tKind'     : tKind ,
                'tType'     : tInputType
            };
            aPackDataInput.push(aSubValue);
        });

        return aPackDataInput;

    }

    //เอารายละเอียดมาโชว์
    function JSxAppendSpanDetail(elem,ptTypeTable){
        if(ptTypeTable == 'checkbox'){
            var tType           = $(elem).find("td:eq(0)").text();
            var tDetail         = $(elem).find("td:eq(1)").text();
            var tDescription    = $(elem).find("td:eq(2)").text();
            if(tDescription == '' || tDescription == null || tDescription == '-'){
                tDescriptionText = '';
            }else{
                tDescriptionText = ' (' + tDescription + ')';
            }
            var tResultText = tDetail + tDescriptionText;
        }else if(ptTypeTable == 'input'){
            var tType           = $(elem).find("td:eq(0)").text();
            var tDetail         = $(elem).find("td:eq(1)").text();
            var tDescription    = $(elem).find("td:eq(2)").text();
            var tValueMake      = $(elem).find("td:eq(5)").children().val();
            var tValueRef       = $(elem).find("td:eq(6)").children().val();
            if(tDescription == '' || tDescription == null || tDescription == '-'){
                tDescriptionText = '';
            }else{
                tDescriptionText = ' (' + tDescription + ')';
            }

            if(tValueMake == '' || tValueMake == null || tValueMake == '-'){
                tValueMakeText = '';
            }else{
                tValueMakeText = ' '+'<?=language('settingconfig/settingconfig/settingconfig','tDetailMake')?>'+' : ' + tValueMake;
            }

            if(tValueRef == '' || tValueRef == null || tValueRef == '-'){
                tValueRefText = '';
            }else{
                tValueRefText = ' '+'<?=language('settingconfig/settingconfig/settingconfig','tDetailRef')?>'+' : ' + tValueRef;
            }

            var tResultText = tDetail + tDescriptionText + tValueMakeText + tValueRefText;
        }

        $('#odvContentFooterText').show();
        $('#ospDetailFooterText').text(tResultText);
    }

</script>