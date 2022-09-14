
<div id="odvTabCouponHDCstPri" class="tab-pane fade">
<div class="row">
            <div class="table-responsive">

              <div  style="padding-bottom: 20px;">
                  <button id="obtTabCouponHDCstPriInclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriInclude')?></label>
               </div> 
        
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriCode')?></th>
                            <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriName')?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="otbCouponHDCstPriInclude">
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDCsrPri'][1])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDCsrPri'][1] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey.'1';
                                ?>
                           <tr class='otrInclude' id='otrCPHcouponIncludeCstPri<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponIncludeCstPriCode[<?=$nI?>]' class='ohdCPHCouponIncludeCstPriCode' value='<?=$aValue['FTPplCode']?>'>
                            <?=$aValue['FTPplCode']?>
                            </td>
                            <td><?=$aValue['FTPplName']?></td>
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeCstPri(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

                <div class="table-responsive">
                <div  style="padding-bottom: 20px;">
                  <button id="obtTabCouponHDCstPriExclude" class="xCNBTNPrimeryPlus xCNInputWhenStaCancelDoc" type="button">+</button>
                </div>
               <div>
                 <label  class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriExclude')?></label>
               </div> 
             <table  class="table xWPdtTableFont">
                    <thead>
                        <tr class="xCNCenter">
                            <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriCode')?></th>
                            <th nowrap class="xCNTextBold" style="width:60%;"><?php echo language('document/couponsetup/couponsetup','tCPHTabCouponHDCstPriName')?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="otbCouponHDCstPriExclude">
                    <?php if(!empty($aDataDocHD['raCouponDetailInOrEx']['aCouponHDCsrPri'][2])){
                                  foreach($aDataDocHD['raCouponDetailInOrEx']['aCouponHDCsrPri'][2] AS $nKey => $aValue){ 
                                     $nI=strtotime(date('Y-m-d H:i:s')).$nKey.'1';
                                ?>
                           <tr class='otrExclude' id='otrCPHcouponExcludeCstPri<?=$nI?>'>
                            <td>
                            <input type='hidden' name='ohdCPHCouponExcludeCstPriCode[<?=$nI?>]' class='ohdCPHCouponExcludeCstPriCode' value='<?=$aValue['FTPplCode']?>'>
                            <?=$aValue['FTPplCode']?>
                            </td>
                            <td><?=$aValue['FTPplName']?></td>
                            <td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeCstPri(<?=$nI?>)' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>
                            </tr>
                        <?php } 
                             } ?>
                    </tbody>
                </table>
                </div>

            </div>
</div>


<script>

   /*===== Begin Browse Option ======================================================= */
   var oRptCstPriOption = function(poReturnInputCstPri){
        let tNextFuncNameCstPri    = poReturnInputCstPri.tNextFuncName;
        let aArgReturnCstPri       = poReturnInputCstPri.aArgReturn;
        let tInputReturnCodeCstPri = poReturnInputCstPri.tReturnInputCode;
        let tInputReturnNameCstPri = poReturnInputCstPri.tReturnInputName;
        let oOptionReturnCstPri    = {
            Title: ['product/pdtpricelist/pdtpricelist','tPPLTitle'],
            Table:{Master:'TCNMPdtPriList',PK:'FTPplCode',PKName:'FTPplName'},
            Join :{
                Table:	['TCNMPdtPriList_L'],
                On:['TCNMPdtPriList_L.FTPplCode = TCNMPdtPriList.FTPplCode AND TCNMPdtPriList_L.FNLngID = '+nLangEdits]
            },
            GrideView:{
                ColumnPathLang	: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang	: ['tPPLTBCode','tPPLTBName'],
                ColumnsSize     : ['15%','75%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMPdtPriList.FTPplCode','TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMPdtPriList_L.FTPplCode ASC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCodeCstPri,"TCNMPdtPriList.FTPplCode"],
                Text		: [tInputReturnNameCstPri,"TCNMPdtPriList_L.FTPplName"]
            },
            NextFunc : {
                FuncName    : tNextFuncNameCstPri,
                ArgReturn   : aArgReturnCstPri
            },
            RouteAddNew: 'pdtpricelist',
            BrowseLev: 0
        };
        return oOptionReturnCstPri;
    };


  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDCstPriInclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptCstPriOptionFrom = undefined;
            oRptCstPriOptionFrom        = oRptCstPriOption({
                'tReturnInputCode'  : 'ohdCPHCouponIncludeCstPriCode',
                'tReturnInputName'  : 'ohdCPHCouponIncludeCstPriName',
                'tNextFuncName'     : 'JSxConsNextFuncBrowseCstPriInclude',
                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oRptCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });



    
  // =========================================== Event Browse Multi Branch ===========================================
  $('#obtTabCouponHDCstPriExclude').unbind().click(function(){
    var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oRptCstPriOptionFrom = undefined;
            oRptCstPriOptionFrom        = oRptCstPriOption({
                'tReturnInputCode'  : 'ohdCPHCouponExcludeCstPriCode',
                'tReturnInputName'  : 'ohdCPHCouponExcludeCstPriName',
                'tNextFuncName'     : 'JSxConsNextFuncBrowseCstPriExclude',
                'aArgReturn'        : ['FTPplCode','FTPplName']
            });
            JCNxBrowseData('oRptCstPriOptionFrom');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });





function JSnCHPCheckDuplicationRowHDCstPri(paData){

    let nLenIn = $('input[name^="ohdCPHCouponIncludeCstPriCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,1);
    //Include
    $('input[name^="ohdCPHCouponIncludeCstPriCode["]').each(function(index){
        let tCstPriCod = $(this).val();
        aEchDataIn[index]=tCstPriCod;
    });

    let nLenEx = $('input[name^="ohdCPHCouponExcludeBchCode["]').length
    let aEchDataEx = JSxCreateArray(nLenEx,1);
    //Exclude
    $('input[name^="ohdCPHCouponExcludeCstPriCode["]').each(function(index){
        let tCstPriCod = $(this).val();
        aEchDataEx[index]=tCstPriCod;
    });

    // console.log("aEchDataIn",aEchDataIn);
    // console.log("aEchDataEx",aEchDataEx);

    let nAproveAppend = 0;
    for(i=0;i<aEchDataIn.length;i++){
        if(aEchDataIn[i]==paData.tCstPriCode){
            nAproveAppend++;
        }
    }
    for(i=0;i<aEchDataEx.length;i++){
        if(aEchDataEx[i]==paData.tCstPriCode){
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
    function JSxConsNextFuncBrowseCstPriInclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
           let aData=JSON.parse(poDataNextFunc);
            // console.log(aData);
            let aDataApr = { 
                tCstPriCode:aData[0]
            }

          let nAproveSta = JSnCHPCheckDuplicationRowHDCstPri(aDataApr);

         if(nAproveSta==0){

          var i = Date.now();
          var tMarkUp ="";
                    tMarkUp +="<tr class='otrInclude' id='otrCPHcouponIncludeCstPri"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdCPHCouponIncludeCstPriCode[]' class='ohdCPHCouponIncludeCstPriCode' value='"+aData[0]+"'>"+aData[0]+"</td><td>"+aData[1]+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRIncludeCstPri("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
                $('#otbCouponHDCstPriInclude').append(tMarkUp);

            }else{

             alert('Data Select Duplicate.');

            }

        }
    }

    function JSxCPHcouponRemoveTRIncludeCstPri(ptCode){
        $('#otrCPHcouponIncludeCstPri'+ptCode).remove();
    }



        /*===== Begin Event Next Function Browse ========================================== */
    // Functionality : 
    // Parameter : Event Next Func Modal
    // Create : 11/02/2020 Nattakit(Nale)
    // Return : Set Element And value
    // Return Type : -
    function JSxConsNextFuncBrowseCstPriExclude(poDataNextFunc){
        if(typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL"){
            let aData=JSON.parse(poDataNextFunc);
            // console.log(aData);
            let aDataApr = { 
                tCstPriCode:aData[0]
            }

          let nAproveSta = JSnCHPCheckDuplicationRowHDCstPri(aDataApr);

         if(nAproveSta==0){

          var i = Date.now();
          var tMarkUp ="";
                    tMarkUp +="<tr class='otrExclude' id='otrCPHcouponExcludeCstPri"+i+"'>";
                    tMarkUp +="<td><input type='hidden' name='ohdCPHCouponExcludeCstPriCode[]' class='ohdCPHCouponExcludeCstPriCode' value='"+aData[0]+"'>"+aData[0]+"</td><td>"+aData[1]+"</td>";
                    tMarkUp +="<td align='center'><img onclick='JSxCPHcouponRemoveTRExcludeCstPri("+i+")' class='xCNIconTable xCNIconDel' src='<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>' ></td>";
                    tMarkUp +="</tr>";
            
 
                $('#otbCouponHDCstPriExclude').append(tMarkUp);

            }else{

            alert('Data Select Duplicate.');

            }
        }
    }

    function JSxCPHcouponRemoveTRExcludeCstPri(ptCode){
        $('#otrCPHcouponExcludeCstPri'+ptCode).remove();
    }
</script>