$("document").ready(function () {
  // JSxTestPDTForSupawat();

  //เวลา เลือกสินค้าเสร็จเเล้ว หรือ เลือกหน้าจอเลือกสินค้าปิดตัวลง
  $("#odvModalDOCPDT").on("hidden.bs.modal", function () {
    $(".odvModalBackdropPDT").fadeOut("fast", function () {
      $(this).remove();
    });
  });
  aMulti = [];
});

//List
function JSxTestPDTForSupawat() {

  var dTime             = new Date();
  var dTimelocalStorage = dTime.getTime();
  aMulti                = [];
  $.ajax({
    type  : "POST",
    url   : "BrowseDataPDT",
    data  : {
        'Qualitysearch'   : [],
        'PriceType'       : ['Cost','tCN_Cost','Company','1'], 
        // 'PriceType'       : ['Pricesell'],                   //เลือกได้สองระดับ Cost ต้นทุน หรือ Pricesell ราคาขาย
        'ShowCountRecord' : 10,
        'NextFunc'        : 'JSxNextFunction',
        'ReturnType'	    : 'M',
        'SPL'             : ['',''], //CODE , NAME
        'BCH'             : ['',''], //CODE , NAME
        'MER'             : ['',''], //CODE , NAME
        'SHP'             : ['',''], //CODE , NAME
        //'NOTINITEM'       : [["00001","8854927003192"],["00001","ADA0000091"],["00001","ADA9999910"]],
        //'NOTINITEM'       : [['PDTCODE1','BARCODE1'],['PDTCODE2','BARCODE2'],['PDTCODE3','BARCODE3']]
        'TimeLocalstorage': dTimelocalStorage
    },
    cache   : false,
    timeout : 5000,
    success : function (tResult) {
      $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
      $("#odvModalDOCPDT").modal({ show: true });

      //remove localstorage
      localStorage.removeItem("LocalItemDataPDT");
      localStorage.removeItem("LocalItemDataPDT" + dTimelocalStorage);
      $("#odvModalsectionBodyPDT").html(tResult);
    },
    error: function (data) {
      console.log(data);
    }
  });
}

//Pagenation
function JSvPDTBrowseClickPage(ptPage) {
  try {
    var nPageCurrent = "";
    var nPageNew;
    switch (ptPage) {
      case 'Fisrt': //กดหน้าแรก
          nPageCurrent 	= 1;
      break;
      case "next": //กดปุ่ม Next
        $(".xWBtnNext").addClass("disabled");
        nPageOld = $(".xWPagePrinter .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
        nPageCurrent = nPageNew;
        break;
      case "previous": //กดปุ่ม Previous
        nPageOld = $(".xWPagePrinter .active").text(); // Get เลขก่อนหน้า
        nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
        nPageCurrent = nPageNew;
        break;
      case 'Last': //กดหน้าสุดท้าย
          nPageCurrent 	= $('#ohdPDTEndPage').val();
      break;
      default:
        nPageCurrent = ptPage;
    }
    JSxGetPDTTable(nPageCurrent);
  } catch (err) {
    console.log("JSvSetprinterClickPage Error: ", err);
  }
}

//click กดปิด
function JCNxRemoveSelectedPDT(){
  var tTimeStorage = $("#odhTimeStorage").val();
  localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);

  $('#odvPDTDataSelection').empty();
  aMulti = [];
}

//clikc ยืนยัน บนขวา
function JCNxConfirmSelectedPDT() {
  var tTimeStorage = $("#odhTimeStorage").val();
  $("#odvPDTDataSelection").empty();
  aMulti = [];
  var LocalItemDataPDT = localStorage.getItem("LocalItemDataPDT" + tTimeStorage);
  var tEleNameReturn  = $("#odhEleNamePDT").val();
  var tEleValueReturn = $("#odhEleValuePDT").val();
  var tNameNextFunc   = $("#odhEleNameNextFunc").val();

  $("div").remove("odvModalBackdropPDT");
  $("#odvModalDOCPDT").modal("hide");

  var aData       = JSON.parse(LocalItemDataPDT);
  var aNewData    = aData.sort(compare);
  var aNewReturn  = JSON.stringify(aNewData);

  localStorage.removeItem("LocalItemDataPDT" + tTimeStorage);

  $("#" + tEleNameReturn).val(aNewReturn);
  $("#" + tEleValueReturn).val(aNewReturn);

  if (tNameNextFunc != "" || tNameNextFunc != null) {
    return window[tNameNextFunc](aNewReturn);
  }
}

//sort array
function compare(a, b) {
  if (a.pnPdtCode < b.pnPdtCode) return -1;
  if (a.pnPdtCode > b.pnPdtCode) return 1;
  return 0;
}

// Get Data PdtConfig
function JSxAdjustPage(){
    
  var nCheckMaxPage = $('#oetMaxPage').val(); 
  var nCheckPerPage = $('#oetPerPage').val();

  $.ajax({
    type: "POST",
    url: "CallModalAddPDTConfig",
    data: { 'nCheckMaxPage' : nCheckMaxPage , 'nCheckPerPage' : nCheckPerPage},
    timeout: 0,
    cache: false,
    success: function(tViewModal){
      $('#odvModalAddPdtConfig').hide();
      JSxGetPDTTable(1);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR,textStatus,errorThrown);
    }
  });
}

//next funct is ready : หลังจากกดยืนยันสินค้าปกติ
function JSxNextFunction(elem) {
  var aData = JSON.parse(elem);

  //จะวิ่งเข้าไปเช็คว่าสินค้าตัวไหนบ้างที่เป็น สินค้าซีเรียล หรือสินค้าแฟชั่น

  //[เอกสารใบรับของใบซื้อ  : bListItemAll : false , tSpcControl : 0]
  //[เอกสารตรวจนับ       : bListItemAll : true , tSpcControl : '']
  var oOptionForFashion = {
    'bListItemAll': false, //[true : เอาลิสต์สินค้าทั้งหมด , false : แสดงสินค้าที่ละตัว]
    'tSpcControl' : 0,
    'tNextFunc'   : 'JSxNextFunction'
  }
  JSxCheckProductSerialandFashion(aData,oOptionForFashion,'insert');
}

//ปิดหน้าต่างสินค้า
function JSxCloseModalBrowsePDT(){
  $("div").remove("odvModalBackdropPDT");
  $("#odvModalDOCPDT").modal("hide");
}


///////////////////////////////////////////// สินค้าแฟชั่น + สินค้าซีเรียล /////////////////////////////////////////////

//จะวิ่งเข้าไปเช็คว่าสินค้าตัวไหนบ้างที่เป็น สินค้าซีเรียล หรือสินค้าแฟชั่น
function JSxCheckProductSerialandFashion(elem,poOptionForFashion,ptEventType){

  var aData     = elem;
  var aPDTSpc   = [];

  if(ptEventType == 'insert'){ //ขาเพิ่มข้อมูล
    for (var i=0; i < aData.length; i++){
        if (aData[i].packData.PDTSpc == 'FH'){ //เอาสินค้าทุกตัวที่เลือกมา วนหา เฉพาะสินค้าที่เป็นแฟชั่น
          aPDTSpc.push(aData[i].packData);
        }
    }
  }else if(ptEventType == 'update'){ //แก้ไขข้อมูล
    aPDTSpc = elem; //ขาแก้ไขข้อมูลจะส่งข้อมูลมาให้เเล้ว
  }else{
    alert('Something is wrong !')
  }

  //ถ้ามีข้อมูลมากกว่าหนึ่ง
  if(aPDTSpc.length > 0){
      $.ajax({
          type    : "POST",
          url     : 'LoadViewProductSerialandFashion',
          data    : {
                      'aData'             : JSON.stringify(aPDTSpc) , 
                      'tPDTType'          : 'FH' , 
                      'tEventType'        : ptEventType ,
                      'nNumber'           : 0 , 
                      'tNameNextFunc'     : poOptionForFashion.tNextFunc + '_PDTSerialorFashion' ,
                      'oOptionForFashion' : poOptionForFashion
                  },
          cache   : false,
          timeout : 0,
          success: function(tResult) {
              var aDataReturn     = JSON.parse(tResult);

              //option ว่าจะแสดง popup ที่ละตัว หรือ เอาเฉพาะค่ากลับไป
              bListItemAll = poOptionForFashion['bListItemAll'];
              if(bListItemAll == false){ //[false : แสดงสินค้าที่ละตัว]
                if(aDataReturn['nAll'] == 0){ //ถ้าไม่มีสินค้า FN เลย ให้ปิดหน้าจอ
                  JSxCloseModalBrowsePDT();
                  var nStaLastSeq = "1"; //สินค้าแฟชั่นตัวสุดท้าย 1:ตัวสุดท้าย 0:ไม่ใช่ตัวสุดท้าย
                }else{
                  setTimeout(function(){ 
                    $("#odvModalDOCPDTFahison").modal({ backdrop: "static", keyboard: false });
                    $("#odvModalDOCPDTFahison").modal({ show: true });
                    $('#odvModalFahisonsectionBodyPDT').html(aDataReturn['tHTML']); 
                  }, 500);
                  var nStaLastSeq = "0"; //สินค้าแฟชั่นตัวสุดท้าย 1:ตัวสุดท้าย 0:ไม่ใช่ตัวสุดท้าย
                }
              }else{ //[true : เอาลิสต์สินค้าทั้งหมด]
                  var aNewResult  = JSON.stringify({
                    'tType'       : 'confirm' , 
                    'nStaLastSeq' : nStaLastSeq,
                    'aResult'     :  { 'tPDTCode' : aDataReturn['aItemReturn'] } ,
                    'tRemark'     : '[dev] สินค้าแฟชั่นทั้งหมด เอาไป insert TCNTDocDTTmp และใน Grid' 
                  });

                  var tNameNextFunc = aDataReturn['tNameNextFunc'];
                  return window[tNameNextFunc](aNewResult);
              }

              //ถ้ามีสินค้าที่ไม่มีรายละเอียด จะต้องส่งไปให้ฝั่งหน้าจอนั้นต้องลบออก
              if(aDataReturn['tPDTRemove']  != '' && aDataReturn['tPDTRemove'] != null && aDataReturn['tPDTRemove'] != false){
                //แพ็คข้อมูลส่งกับไป nextfunc
                var aNewResult  = JSON.stringify({
                  'tType'       : 'delete' , 
                  'nStaLastSeq' : nStaLastSeq,
                  'aResult'     :  { 'tPDTCode' : aDataReturn['tPDTRemove'] } , //คั่นด้วยเครื่องหมายคอมม่า
                  'tRemark'     : '[dev] สินค้าตัวดังกล่าวไม่ได้ระบุ รายละเอียดไว้ เอาไปลบใน TCNTDocDTTmp และใน Grid ให้ด้วยครับ' 
                });

                var tNameNextFunc = aDataReturn['tNameNextFunc'];
                return window[tNameNextFunc](aNewResult);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.log(errorThrown);
              JCNxResponseError(jqXHR, textStatus, errorThrown);
              JCNxCloseLoading();
          }
      });
  }else{
    JSxCloseModalBrowsePDT();
  }
}

//กดที่สินค้าเพื่อที่จะเเก้ไขสำหรับสินค้าแฟชั่น
function JSxUpdateProductSerialandFashion(ptOption){
  var oOption = JSON.stringify(ptOption);
  var aOption = JSON.parse(oOption);
  //aOption.tDocumentBranch       : สาขาของเอกสาร
  //aOption.tDocumentNumber       : เลขที่ของเอกสาร
  //aOption.tDocumentProduct      : รหัสสินค้า
  //aOption.tDocumentDocKey       : คีย์เอกสาร
  //aOption.nXsdSeq               : ลำดับสินค้าใน DT
  //aOtion.tXtdBarCode            : บาร์โค้ด
  //aOption.tNextFunc             : ชื่อฟังก์ชั่น next func
  //aOption.bListItemAll          : [true : เอาลิสต์สินค้าทั้งหมด , false : แสดงสินค้าที่ละตัว]
  //aOption.tSpcControl           : spc control
  //aOption.tDocumentPlcCode      : ที่เก็บสินค้า

  $("#odvModalDOCPDTFahison").modal({ backdrop: "static", keyboard: false });
  $("#odvModalDOCPDTFahison").modal({ show: true });

  if(aOption.tStaEdit!=undefined || aOption.tStaEdit!=''){
    var tStaEdit = aOption.tStaEdit;
  }else{
    var tStaEdit = 1;
  }

  var aPDTSpc   = [];
      aPDTSpc.push({
                    'BCH'     : aOption.tDocumentBranch , 
                    'tDocno'  : aOption.tDocumentNumber  , 
                    'tDocKey' : aOption.tDocumentDocKey  , 
                    'nDTSeq'  : aOption.nDTSeq , 
                    'PDTCode' : aOption.tDocumentProduct , 
                    'PUNCode' : aOption.tDTPunCode , 
                    'Barcode' : aOption.tDTBarCode , 
                    'PlcCode' : aOption.tDocumentPlcCode
                  });
  var oOptionForFashion = {
    'tSpcControl'  : aOption.tSpcControl,
    'bListItemAll' : false,
    'tNextFunc'    : aOption.tNextFunc,
    'tStaEdit'     : tStaEdit
  }
  JSxCheckProductSerialandFashion(aPDTSpc,oOptionForFashion,'update');
}

//Close
function JSxCloseModalBrowse_Fahsion(){
  $("div").remove("odvModalBackdropPDT");
  $("#odvModalDOCPDTFahison").modal("hide");
}

//next funct is ready : หลังจากกดยืนยันสินค้าแฟชั่น
function JSxNextFunction_PDTSerialorFashion(elem){
  var aData = JSON.parse(elem);
  console.log(aData);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////