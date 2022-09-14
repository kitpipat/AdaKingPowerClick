<?php $aFilterBrand = array(); ?>
<?php //echo '<pre>'; ?>
<?php //echo print_r($aPackage['roItem'] ); ?>
<?php //echo '</pre>'; ?>

<table id="otbPackage" class="table table-striped">
    <thead>
        <?php if($aPackage['rtCode'] == '001'){ ?>
        <tr>
            <th class="text-center xCNTextBold" rowspan="2" style="vertical-align: middle; width: 30%; min-width: 250px; white-space: nowrap;"><?= language('register/buylicense/buylicense','tTBFeatues')?></th>
            <?php for($i=0; $i<FCNnHSizeOf($aPackage['roItem']['raoDataPackage']); $i++){ ?>
            <?php $aItem = $aPackage['roItem']['raoDataPackage'][$i]; ?>
                <?php 
                    $tNamePackage = $aItem['rtPdtName'];
                    $tPackageCode = $aItem['rtPdtCode'];
                    //เก็บพวก แบรนด์สินค้าเอาไว้ สำหรับเอาไว้กรองฟิลเตอร์
                    $tTextFindValue = searchMultiArray($aItem['rtPbnCode'],$aFilterBrand);
                    if($tTextFindValue == '' || $tTextFindValue == null){
                        array_push($aFilterBrand, array('CODE' => $aItem['rtPbnCode'], 'NAME' => $aItem['rtPbnName']));
                    }
                ?>
                <th class="text-center xCNTextBold xPackage<?=$tPackageCode?> xBrand<?=$aItem['rtPbnCode']?> xPackageALL" data-packagecode='<?=$tPackageCode?>' style="width:10%;  white-space: nowrap;" data-detailproduct='<?=json_encode($aItem)?>'><?=$tNamePackage?></th>
            <?php } ?>
        </tr>
        <?php }else{ ?>
            <tr><th class="text-center xCNTextBold" ><?= language('register/buylicense/buylicense','tTBFeatues')?></th></tr>
        <?php } ?>
    </thead>

    <tbody> 
        <?php if($aPackage['rtCode'] == '001'){ ?>
        <?php 
            $tImg_fail = base_url() . '/application/modules/common/assets/images/icons/cancel.png';
            $tImg_pass = base_url() . '/application/modules/common/assets/images/icons/done.png' 
        ?>
        <?php for($i=0; $i<FCNnHSizeOf($aPackage['roItem']['raoDataFeabyPkg']); $i++){ ?>
                <?php $aItem    = $aPackage['roItem']['raoDataFeabyPkg'][$i]; ?>
                <?php $nPunCode = $aPackage['roItem']['raoDataFeabyPkg'][$i]['rtPunCode']; ?> 
                <tr>
                    <?php 
                        if(strpos($aItem['rtPdtCode'],"-0") >= 0 && strpos($aItem['rtPdtCode'],"-0") != ''){
                            $tCSSStyle = 'font-weight: bold;';
                        }else{
                            $tCSSStyle = 'margin-left: 20px;';
                        }
                    ?>
                    <td><label style='<?=$tCSSStyle?>' ><?=$aItem['rtPdtName']?> </label></td>
                    <?php 
                        for($k=0; $k<FCNnHSizeOf($aItem['raoAlwPackage']); $k++){ 

                            if($aItem['rtPtyCode'] == '00003'){ //จำนวนจุดขาย
                                $nPosCount      = $aItem['raoAlwPackage'][$k]['rtStaAlwUse'];
                                $tCodePackage   = $aItem['raoAlwPackage'][$k]['rtPkgCode']; ?>
                                <td class="xCNAllowPackage xCNAllowList<?=$tCodePackage?> text-center xCNAllowListALL" data-itemproduct='<?=$nPunCode?>' data-detailproduct='<?=json_encode($aItem['raoAlwPackage'][$k])?>' data-flag="<?=$bFlagData?>" style="font-size: 20px !important;">
                                    <?=$nPosCount?> <?= language('register/buylicense/buylicense','tTBPos')?>
                                </td>
                            <?php }else{ //ฟิจเจอร์ทั่วไป
                                $tAlwPackage    = $aItem['raoAlwPackage'][$k]['rtStaAlwUse'];
                                $tCodePackage   = $aItem['raoAlwPackage'][$k]['rtPkgCode'];
                                if($tAlwPackage == 1){ $tImgDemo = $tImg_pass; $bFlagData = true; }else{ $tImgDemo = $tImg_fail; $bFlagData = false; } ?>
                                <td class="xCNAllowPackage xCNAllowList<?=$tCodePackage?> xCNAllowListALL" data-itemproduct='<?=$nPunCode?>' data-detailproduct='<?=json_encode($aItem['raoAlwPackage'][$k])?>' data-flag="<?=$bFlagData?>"><img class="xCNImageFlagPackage"  src="<?=$tImgDemo?>"></td>
                        <?php }
                        } 
                    ?>
                </tr>
            <?php } ?>
        <?php }else{ ?>
            <tr><td class='text-center xCNTextDetail2' colspan='2'><?= language('common/main/main','tMainRptNotFoundDataInDB')?></td></tr>
        <?php } ?>
    </tbody>

    <tfoot>
        <?php if($aPackage['rtCode'] == '001'){ ?>
            <tr>
                <td></td>
                <?php for($i=0; $i<FCNnHSizeOf($aPackage['roItem']['raoDataPackage']); $i++){ ?>
                    <?php $aItemPrice   = $aPackage['roItem']['raoDataPackage'][$i]; ?>
                    <?php $tShowPrice   = ''; ?>
                    <?php $tPackageCode = $aItemPrice['rtPdtCode']; ?>
                    <?php if(empty($aItemPrice['raoPrice'])){ //ไม่มีราคา ?>
                        <td class="text-center xCNTextBold xPackagePrice<?=$tPackageCode?> xPackagePriceALL" data-alwSeleted="0" style="width:10%; vertical-align: middle; border: 1px solid #dddddd;">
                            0.00
                            <?php $aPriceData      = array('rtPdtCode' => $tPackageCode , 'rtPunCode' => '-' , 'rtPunName' => '-' , 'rcUnitFact' => '1'); ?>
                            <?php $oHiddenParam    = json_encode($aPriceData); ?>
                            <input type="hidden" id="xCNValue<?=$tPackageCode?>" data-detailpackage='<?=$oHiddenParam?>' >
                        </td>
                    <?php }else{ //มีราคา ?>
                        <?php for($j=0; $j<FCNnHSizeOf($aItemPrice['raoPrice']); $j++){ ?>
                            <?php $aPriceData = $aItemPrice['raoPrice'][$j]; ?>
                            <?php 
                                if(($aPriceData['rcPgdPriceRet'] == '' || $aPriceData['rcPgdPriceRet'] == 0) && (FCNnHSizeOf($aItemPrice['raoPrice']) == 1)){ 
                                    $bAlwSeleted    = 0;
                                    $oHiddenParam   = "'".json_encode($aPriceData)."'";
                                    $tShowPrice     .= '0.00';
                                    $tShowPrice     .= '<input type="hidden" id="xCNValue'.$tPackageCode.'" data-detailpackage='.$oHiddenParam.' >';
                                }else{
                                    $bAlwSeleted    = 1;
                                    $oHiddenParam   = "'".json_encode($aPriceData)."'";
                                    $tShowPrice     .= '<option value="1" data-detailpackage='.$oHiddenParam.'>'.number_format($aPriceData['rcPgdPriceRet'],2) . ' / ' . $aPriceData['rtPunName'].'</option>';
                                } 
                            ?>
                        <?php } ?>
                        <td class="text-center xCNTextBold xPackagePrice<?=$tPackageCode?> xPackagePriceALL" data-alwSeleted="<?=$bAlwSeleted?>" style="width:10%; vertical-align: middle; border: 1px solid #dddddd;">
                            <?php if($bAlwSeleted == 0){ ?>
                                <?=$tShowPrice?>
                            <?php }else if($bAlwSeleted == 1){ ?>
                                <select class="selectpicker form-control" name="ocmPriceByPackage" maxlength="1">
                                    <?=$tShowPrice?>
                                </select>
                            <?php } ?>
                        </td>
                    <?php } ?>
                <?php } ?>
            </tr>
        <?php } ?>

        <?php if($aPackage['rtCode'] == '001'){ ?>
            <tr>
                <td></td>
                <?php for($i=0; $i<FCNnHSizeOf($aPackage['roItem']['raoDataPackage']); $i++){ ?>
                    <?php $aItem = $aPackage['roItem']['raoDataPackage'][$i]; ?>
                    <?php 
                        $tNamePackage = $aItem['rtPdtName'];
                        $tCodePackage = $aItem['rtPdtCode'];
                    ?>
                    <?php 
                        if($aItem['rtPgpChain'] == '00001'){ //Chain : 00001 คือ แพ็คเกจทดลองใช้
                            $tClassPackageFordemo = 'xCNClassPackageFordemo';
                        }else{ //Chain : แพ็คเกจที่ใช้งานจริง
                            $tClassPackageFordemo = '';
                        }
                    ?>
                    <td class="text-center xCNBTNPackage<?=$tCodePackage?> xCNBTNPackageALL <?=$tClassPackageFordemo?>">
                        <?php 
                            if($tTypepage == 1){ //ลงทะเบียน
                                $tTextInBtn = language('common/main/main','tGallerySelect');
                            }else if($tTypepage == 0){ //ซิ้อเพิ่ม
                                $tTextInBtn = language('common/main/main','tTextBTNChange');
                            } 
                        ?>
                        <?= $tNamePackage ?><hr style="margin-bottom: 10px; margin-top: 0px;">
                        <button type="button" data-package="<?=$tNamePackage?>" data-codepackage="<?=$tCodePackage?>" class="xCNBTNSelectPackage btn xCNBTNCancel xCNBtnBlock" onclick="JSxSelectPackage('<?=$tNamePackage?>','<?=$tCodePackage?>')">
                            <?=$tTextInBtn?>
                        </button>
                    </td>
                <?php } ?>
                <input type="hidden" id="ohdValuePackage" name="ohdValuePackage" value="">
            </tr>
        <?php } ?>
    </tfoot>
</table>
 
<?php 
    //ฟังก์ชั่นสำหรับค้นหา array แบบ 2 มิติ
    function searchMultiArray($val, $array) {
        foreach ($array as $element) {
          if($element['CODE'] == $val) {
            return $element['CODE'];
          }
        }
        return null;
    }
?>

<script>
    $('document').ready(function(){

        $('.selectpicker').selectpicker();	

        //ฟิลเตอร์บนขวา สำหรับแบรน์
        if('<?=$aPackage['rtCode']?>' == '001'){
            //ถ้าไม่เคยมีการค้นหา
            if('<?=$tFilterPackageSPC?>' == '' || '<?=$tFilterPackageSPC?>' == null){

                var tKeepValueB4 = $('#ocmFilterPackage').val();
                $('#ocmFilterPackage').html('');

                var nItemBrand          = '<?=count($aFilterBrand)?>';
                var aItemBrand          = '<?=json_encode($aFilterBrand)?>';
                var aItemConvertBrand   = JSON.parse(aItemBrand);
                var tFilterBrand        = "<option value='empty' disabled >" + '<?=language('register/buylicense/buylicense','tFilterSeleted')?>' + "</option>";
                    tFilterBrand        += "<option value='ALL' >" + '<?=language('common/main/main','tAll')?>' + "</option>";

                for(var i=0; i<nItemBrand; i++){
                    var nCodeBrand = aItemConvertBrand[i].CODE;
                    var tNameBrand = aItemConvertBrand[i].NAME;
                    if(i == nItemBrand-1){
                        var bSelected       = 'selected';
                        var tTextNameDefult = tNameBrand;
                        var tTextCodeDefult = nCodeBrand;
                    }else{
                        var bSelected       = '';
                        var tTextNameDefult = '';
                        var tTextCodeDefult = '';
                    }
                    tFilterBrand  += '<option value='+nCodeBrand+' '+bSelected+' >' + tNameBrand + '</option>';
                }
                tFilterBrand  += "<option value='SPC' >" + '<?= language('register/buylicense/buylicense','tFilterSPC')?>' + '</option>';

                if(nItemBrand > 0){
                    $('#ocmFilterPackage').append(tFilterBrand);
                    $('.selectpicker').selectpicker('refresh');

                    if(tKeepValueB4 == '' || tKeepValueB4 == null){
                        var tParam = $('#ocmFilterPackage');
                        var tType  = 1;
                    }else{
                        var tParam = tKeepValueB4;
                        var tType  = 2;
                    }

                    JSxChangeFilterPackage(tParam,tType);
                }
            }
        }else{ //ไม่พบข้อมูล)
            $('#ocmFilterPackage').val('empty');
            $('.selectpicker').selectpicker('refresh');
        }
        
        if('<?=$tTypepage?>' == 0){ //ซื้อเพิ่ม จะไม่โชว์แพ็คเกจของตัวเอง
            var tCodePackage = '<?=$this->session->userdata("tSessionCstPackageCode")?>';
            $('.xPackage' + tCodePackage).remove();
            $('.xCNAllowList' + tCodePackage).remove();
            $('.xPackagePrice' + tCodePackage).remove();
            $('.xCNBTNPackage' + tCodePackage).remove();
        }
    });

</script>