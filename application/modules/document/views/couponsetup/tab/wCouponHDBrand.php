
<div id="odvTabCouponHDBrand" class="tab-pane fade">
    <div class="row">
        <div class="table-responsive">
            <div style="padding-bottom: 20px;">
                <button id="obtTabCouponHDBrandInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
            </div>
            <div>
                <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandInclude')?></label>
            </div> 
            <table class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandName')?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="otbCouponHDBrandInclude">
                    <?php   
                        if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBrand'][1])){
                            foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBrand'][1] AS $nKey => $aValue){ 
                                $nI=strtotime(date('Y-m-d H:i:s')).$nKey.'1';
                    ?>
                        <tr class='otrInclude' id='otrCPHcouponIncludeBrand<?=$nI?>'>
                            <td>
                                <input type='hidden' name='ohdCPHCouponIncludeBrandCode[<?=$nI?>]' class='ohdCPHCouponIncludeBrandCode' value='<?=$aValue['FTPbnCode']?>'>
                                <?=$aValue['FTPbnCode']?>
                            </td>
                            <td><?=$aValue['FTPbnName']?></td>
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeBrand(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                        </tr>
                    <?php 
                            } 
                        } 
                    ?>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <div  style="padding-bottom: 20px;">
                <button id="obtTabCouponHDBrandExclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
            </div>
            <div>
                <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandExclude')?></label>
            </div> 
            <table  class="table xWPdtTableFont">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDBrandName')?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="otbCouponHDBrandExclude">
                <?php 
                    if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBrand'][2])){
                        foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDBrand'][2] AS $nKey => $aValue){ 
                            $nI=strtotime(date('Y-m-d H:i:s')).$nKey.'1';
                ?>
                        <tr class='otrExclude' id='otrCPHcouponExcludeBrand<?=$nI?>'>
                            <td>
                                <input type='hidden' name='ohdCPHCouponExcludeBrandCode[<?=$nI?>]' class='ohdCPHCouponExcludeBrandCode' value='<?=$aValue['FTPbnCode']?>'>
                                <?=$aValue['FTPbnCode']?>
                            </td>
                            <td><?=$aValue['FTPbnName']?></td>
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBrand(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                        </tr>
                <?php
                        } 
                    } 
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>

   /*===== Begin Browse Option ======================================================= */
   var oRptBrandOption = function(poReturnInputBrand){
        let tNextFuncNameBrand    = poReturnInputBrand.tNextFuncName;
        let aArgReturnBrand       = poReturnInputBrand.aArgReturn;
        let tInputReturnCodeBrand = poReturnInputBrand.tReturnInputCode;
        let tInputReturnNameBrand = poReturnInputBrand.tReturnInputName;
        let oOptionReturnBrand    = {
            Title: ['product/pdtbrand/pdtbrand','tPBNTitle'],
            Table:{Master:'TCNMPdtBrand',PK:'FTPbnCode',PKName:'FTPbnName'},
            Join :{
                Table:	['TCNMPdtBrand_L'],
                On:['TCNMPdtBrand_L.FTPbnCode = TCNMPdtBrand.FTPbnCode AND TCNMPdtBrand_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtbrand/pdtbrand',
                ColumnKeyLang	: ['tPBNCode','tPBNName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtBrand.FTPbnCode','TCNMPdtBrand_L.FTPbnName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtBrand.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCodeBrand,"TCNMPdtBrand.FTPbnCode"],
                Text		: [tInputReturnNameBrand,"TCNMPdtBrand_L.FTPbnName"]
            },
            NextFunc : {
                FuncName    : tNextFuncNameBrand,
                ArgReturn   : aArgReturnBrand
            },
            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnBrand;
    };


  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDBrandInclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptBrandOptionFrom = undefined;
            oRptBrandOptionFrom        = oRptBrandOption({
                'tReturnInputCode'  : 'ohdCPHCouponIncludeBrandCode',
                'tReturnInputName'  : 'ohdCPHCouponIncludeBrandName',
                'tNextFuncName'     : 'JSxConsNextFuncBrowseBrandInclude',
                'aArgReturn'        : ['FTPbnCode','FTPbnName']
            });
            JCNxBrowseData('oRptBrandOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    
  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDBrandExclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptBrandOptionFrom = undefined;
            oRptBrandOptionFrom        = oRptBrandOption({
                'tReturnInputCode'  : 'ohdCPHCouponExcludeBrandCode',
                'tReturnInputName'  : 'ohdCPHCouponExcludeBrandName',
                'tNextFuncName'     : 'JSxConsNextFuncBrowseBrandExclude',
                'aArgReturn'        : ['FTPbnCode','FTPbnName']
            });
            JCNxBrowseData('oRptBrandOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });





function JSnCHPCheckDuplicationRowHDBrand(paData){

    let nLenIn = $('input[name^="ohdCPHCouponIncludeBrandCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,1);
    //Include
    $('input[name^="ohdCPHCouponIncludeBrandCode["]').each(function(index){
        let tBrandCod = $(this).val();
        aEchDataIn[index]=tBrandCod;
    });

    let nLenEx = $('input[name^="ohdCPHCouponExcludeBchCode["]').length
    let aEchDataEx = JSxCreateArray(nLenEx,1);
    //Exclude
    $('input[name^="ohdCPHCouponExcludeBrandCode["]').each(function(index){
        let tBrandCod = $(this).val();
        aEchDataEx[index]=tBrandCod;
    });

    // console.log("aEchDataIn",aEchDataIn);
    // console.log("aEchDataEx",aEchDataEx);

    let nAproveAppend = 0;
    for(i=0;i<aEchDataIn.length;i++){
        if(aEchDataIn[i]==paData.tBrandCode){
            nAproveAppend++;
        }
    }
    for(i=0;i<aEchDataEx.length;i++){
        if(aEchDataEx[i]==paData.tBrandCode){
            nAproveAppend++;
        }
    }
    // console.log(nAproveAppend);
    return nAproveAppend;
}


        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBrandInclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
           let aData=JSON.parse(poDataNextFunc);
            // console.log(aData);
            let aDataApr = { 
                tBrandCode:aData[0]
            }

          let nAproveSta = JSnCHPCheckDuplicationRowHDBrand(aDataApr);

         if(nAproveSta==0){

          var i = Date.now();
          var tMarkUp ="";
                    tMarkUp +="<tr class='otrInclude' id='otrCPHcouponIncludeBrand"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdCPHCouponIncludeBrandCode[]' class='ohdCPHCouponIncludeBrandCode' value='"+aData[0]+"'>"+aData[0]+"</td><td>"+aData[1]+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeBrand("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                $('#otbCouponHDBrandInclude').append(tMarkUp);

            }else{

             alert('Data Select Duplicate.');

            }

        }
    }

    function JSxCPHcouponRemoveTRIncludeBrand(ptCode){
        $('#otrCPHcouponIncludeBrand'+ptCode).remove();
    }



        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseBrandExclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            let aData=JSON.parse(poDataNextFunc);
            // console.log(aData);
            let aDataApr = { 
                tBrandCode:aData[0]
            }

          let nAproveSta = JSnCHPCheckDuplicationRowHDBrand(aDataApr);

         if(nAproveSta==0){

          var i = Date.now();
          var tMarkUp ="";
                    tMarkUp +="<tr class='otrExclude' id='otrCPHcouponExcludeBrand"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdCPHCouponExcludeBrandCode[]' class='ohdCPHCouponExcludeBrandCode' value='"+aData[0]+"'>"+aData[0]+"</td><td>"+aData[1]+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeBrand("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
            
 
                $('#otbCouponHDBrandExclude').append(tMarkUp);

            }else{

            alert('Data Select Duplicate.');

            }
        }
    }

    function JSxCPHcouponRemoveTRExcludeBrand(ptCode){
        $('#otrCPHcouponExcludeBrand'+ptCode).remove();
    }
</script>