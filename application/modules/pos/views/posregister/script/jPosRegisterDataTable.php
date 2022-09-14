<script type="text/javascript">
    $(function(){
        $("#oetAllCheck").click(function(){ // เมื่อคลิกที่ checkbox ตัวควบคุม
          if($(this).prop("checked")){ // ตรวจสอบค่า ว่ามีการคลิกเลือก
              $(".ocbListItem").prop("checked",true); // กำหนดให้ เลือก checkbox ที่ต้องการ ที่มี class ตามกำหนด 
          }else{ // ถ้าไม่มีการ ยกเลิกการเลือก
              $(".ocbListItem").prop("checked",false); // กำหนดให้ ยกเลิกการเลือก checkbox ที่ต้องการ ที่มี class ตามกำหนด 
          }
      }); 
    });

</script>