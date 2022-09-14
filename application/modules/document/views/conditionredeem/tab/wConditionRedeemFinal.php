<style>
.xGroupPingFinal{
    padding-top: 20px;
    padding-bottom: 20px;
    border-bottom: solid 1px #cccc;
}
</style>
<div id="odvTabConditionRedeemHDFinal" >

    <div class="col-md-12 xGroupPingFinal" >
            <div class="col-md-12" >
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHTypeRedeem')?></label>
            </div>
            <div class="col-md-12">
                <span id="ospRdhFilbalDoctype">....</label>
            </div>
           
    </div>

    <div class="col-md-12 xGroupPingFinal odvHideGroupNameCol" >
            <div class="col-md-6" >
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHPdtGrpInclude')?></label>
            </div>
            <div class="col-md-6">
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHPdtGrpExclude')?></label>
            </div>

            <div class="col-md-6 odvRddPdtGrp1"  >
             
            </div>

            <div class="col-md-6 odvRddPdtGrp2"  >
               
            </div>
           
    </div>
   

    <div class="col-md-12 xGroupPingFinal"   >
            <div class="col-md-12" >
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHConditionRedeem')?></label>
            </div>
            <div class="col-md-12" style="padding-top: 10px;border-bottom: solid 1px #cccc;">
                    <div class="col-md-4 odvHideGroupNameCol" ><label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGroupConditionRedeemName')?></label></div>
                    <div class="col-md-2"><label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeem')?></label></div>
                    <div class="col-md-2"><label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemPointUse')?></label></div>
                    <div class="col-md-2"><label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemMoney')?></label></div>
                    <div class="col-md-2"><label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRdhGenCodeRedeemLimitBill')?></label></div>
            </div>
            <div id="odvRddConditionreedeemShowGroupCR"></div>

    </div>


    <div class="col-md-12 xGroupPingFinal" >
            <div class="col-md-6" >
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHPplInclude')?></label>
            </div>
            <div class="col-md-6">
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHPplExclude')?></label>
            </div>

            <div class="col-md-6" id="odvRddPplShow1" >
             
            </div>

            <div class="col-md-6" id="odvRddPplShow2" >
               
            </div>
           
    </div>

    <div class="col-md-12 xGroupPingFinal" >
            <div class="col-md-6" >
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHBchInclude')?></label>
            </div>
            <div class="col-md-6">
                <label class="xCNLabelFrm"><?php echo language('document/conditionredeem/conditionredeem','tRDHBchExclude')?></label>
            </div>

            <div class="col-md-6" id="odvRddBchShow1" >
              
            </div>

            <div class="col-md-6" id="odvRddBchShow2" >
                
            </div>
           
    </div>


</div>

<script>

function JSxRddPdtGroupPageFinal(){

    //--ประเภทแลกแต้ม
     let tRhdDocType = $('#ocmRDHDocType option:selected').html();
     $('#ospRdhFilbalDoctype').text(tRhdDocType);

   //--กลุ่มสินค้า
    JSxRddPdtGroupCreate();

    //--เงื่อนไขแลกแต้ม
    JSxRddPdtGroupConditionRedeem();

    //--กลุ่มราคาที่มีผล/ยกเว้น
    JSxRddPplGroupConditionRedeem();

    //--กลุ่มสาขาที่มีผล/ยกเว้น
    JSxRddBchGroupConditionRedeem();

}


function JSxRddPdtGroupCreate(){
    
    $(".odvRddPdtGrp1").html('');
    $(".odvRddPdtGrp2").html('');
 

    $('input[name^="ohdRddGroupNameInput["]').each(function(){
     
       let tPdtGrpName   = $(this).val();
       console.log(tPdtGrpName);
       let nType      = $(this).attr('ohdrddgroupstatype');

       let tMarkUp ='<div class="col-md-12" >'+tPdtGrpName+'</div>';

       $(".odvRddPdtGrp"+nType).append(tMarkUp);

    });

    if($('.odvRddPdtGrp1').html()==''){
        $('.odvRddPdtGrp1').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHAllInclude')?>');
    }

    if($('.odvRddPdtGrp2').html()==''){
        $('.odvRddPdtGrp2').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHALlExclude')?>');
    }
    
}


function JSxRddPdtGroupConditionRedeem(){

    let nLenIn = $('input[name^="oetRdcRefCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,5);
//textGroupName
    $('.textGroupName').each(function(index){
    let tGrpNameColum = $(this).text();
    aEchDataIn[index][0]=tGrpNameColum;
    });
//oetRdcRefCode
    $('input[name^="oetRdcRefCode["]').each(function(index){
        let tRdcRefCode = $(this).val();
        aEchDataIn[index][1]=tRdcRefCode;
    });
//oetRdcUsePoint
    $('input[name^="oetRdcUsePoint["]').each(function(index){
        let tRdcUsePoint = $(this).val();
        aEchDataIn[index][2]=tRdcUsePoint;
    });
//oetRdcUseMny
    $('input[name^="oetRdcUseMny["]').each(function(index){
        let tRdcUseMny = $(this).val();
        aEchDataIn[index][3]=tRdcUseMny;
    });
//oetRdcMinTotBill
    $('input[name^="oetRdcMinTotBill["]').each(function(index){
        let tRdcMinTotBill = $(this).val();
        aEchDataIn[index][4]=tRdcMinTotBill;
    });

    console.log(aEchDataIn);
    let tMarkUp = '';

    for(i=0;i<aEchDataIn.length;i++){

            let tGroupName  = aEchDataIn[i][0];
            let tRefCode    = 'Code Auto';
            if(aEchDataIn[i][1]!=''){
                tRefCode    = aEchDataIn[i][1];
            }
            let tUsePoint   = aEchDataIn[i][2];
            let tUseMny     = aEchDataIn[i][3];
            let tMinTotBill = aEchDataIn[i][4];

            tMarkUp +='<div class="col-md-12" >';
            tMarkUp +='<div class="col-md-4 odvHideGroupNameCol" >'+tGroupName+'</div>';
            tMarkUp +='<div class="col-md-2">'+tRefCode+'</div>';
            tMarkUp +='<div class="col-md-2" align="right">'+tUsePoint+'</div>';
            tMarkUp +='<div class="col-md-2" align="right">'+tUseMny+'</div>';
            tMarkUp +='<div class="col-md-2" align="right">'+tMinTotBill+'</div>';
            tMarkUp +='</div>';

    }

    $("#odvRddConditionreedeemShowGroupCR").html(tMarkUp);



    if($('#ocmRDHDocType').val()!=1){
            $('.odvHideGroupNameCol').hide();
        }else{
            $('.odvHideGroupNameCol').show();
        }


}



function JSxRddPplGroupConditionRedeem(){

    let nLenIn = $('input[name^="ohdRddPplCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,2);
//tRddPplname
    $('input[name^="ohdRddPplCode["]').each(function(index){
    let tRddPplname = $(this).attr('tRddPplname');
    aEchDataIn[index][0]=tRddPplname;
    });
//tRdhPplStaType
    $('input[name^="ohdRdhPplStaType["]').each(function(index){
        let tRdhPplStaType = $(this).val();
        aEchDataIn[index][1]=tRdhPplStaType;
    });
    console.log(aEchDataIn);

    
   
    $("#odvRddPplShow1").html('');
    $("#odvRddPplShow2").html('');
 

    for(i=0;i<aEchDataIn.length;i++){

            let tPplName   = aEchDataIn[i][0];
            let nType      = aEchDataIn[i][1];

            let tMarkUp ='<div class="col-md-12" >'+tPplName+'</div>';

            $("#odvRddPplShow"+nType).append(tMarkUp);
    }

    if($('#odvRddPplShow1').html()==''){
        $('#odvRddPplShow1').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHAllInclude')?>');
    }

    if($('#odvRddPplShow2').html()==''){
        $('#odvRddPplShow2').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHALlExclude')?>');
    }
    
}

function JSxRddBchGroupConditionRedeem(){

    let nLenIn = $('input[name^="ohdRddConditionRedeemBchCode["]').length
    let aEchDataIn = JSxCreateArray(nLenIn,5);
    //tRddAgnName
    $('input[name^="ohdRddConditionRedeemAgnCode["]').each(function(index){
       let tRddAgnName = $(this).attr('trddAgnname');
       aEchDataIn[index][4]=tRddAgnName;
    });
    //tRddBchName
    $('input[name^="ohdRddConditionRedeemBchCode["]').each(function(index){
        let tRddBchName = $(this).attr('trddbchname');
        aEchDataIn[index][0]=tRddBchName;
    });
    //tRddMerName
    $('input[name^="ohdRddConditionRedeemMerCode["]').each(function(index){
        let tRddMerName = $(this).attr('trddmername');
        aEchDataIn[index][1]=tRddMerName;
    });
    //tRddShpName
    $('input[name^="ohdRddConditionRedeemShpCode["]').each(function(index){
        let tRddShpName = $(this).attr('trddshpname');
        aEchDataIn[index][2]=tRddShpName;
    });
    //tRdhBchStaType
    $('input[name^="ohdRddBchModalType["]').each(function(index){
        let tRdhBchStaType = $(this).val();
        aEchDataIn[index][3]=tRdhBchStaType;
    });
console.log(aEchDataIn);

    $("#odvRddBchShow1").html('');
    $("#odvRddBchShow2").html('');
  

    for(i=0;i<aEchDataIn.length;i++){
            let tAgnName   = aEchDataIn[i][4];
            let tBchName   = aEchDataIn[i][0];
            let tMerName   = aEchDataIn[i][1];
            let tShpName   = aEchDataIn[i][2];
            let nType      = aEchDataIn[i][3];

           let tMarkUp ='<div class="col-md-12" >'+tAgnName+' '+tBchName+' '+tMerName+' '+tShpName+'</div>';

            $("#odvRddBchShow"+nType).append(tMarkUp);
    }

    if($('#odvRddBchShow1').html()==''){
        $('#odvRddBchShow1').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHAllInclude')?>');
    }

    if($('#odvRddBchShow2').html()==''){
        $('#odvRddBchShow2').html('<?php echo language('document/conditionredeem/conditionredeem','tRDHALlExclude')?>');
    }
    

}


</script>