function edit_row(id)
{
     var po_stu_id = document.getElementById("po_stu_id_val"+id).innerHTML;
     var po_stu_name = document.getElementById("po_stu_name_val"+id).innerHTML;

     document.getElementById("edit_po_stu_id").value = po_stu_id;
     document.getElementById("edit_po_stu_name").value = po_stu_name;  
}

function save_row()
{
     var po_stu_id = document.getElementById("edit_po_stu_id").value;
     var po_stu_name = document.getElementById("edit_po_stu_name").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'purchase_order_status_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:po_stu_id,
                           po_stu_name_val:po_stu_name},
                           success:function(response) {
                               //$.alert('ทำการแก้ไขแล้ว!');
                               location.reload(false);
                          }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการแก้ไขแล้ว!');
                }
            }
    });    
}

function delete_row(id)
{
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการลบรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_order_status_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
                            //$.alert('ทำการลบรายการข้อมูลแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการลบรายการข้อมูลแล้ว!');
                }
            }
    });
}

function insert_row()
{
    var po_stu_name = document.getElementById("new_po_stu_name").value;
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'purchase_order_status_page.php',
                        data:{insert_row:'insert_row',
                        po_stu_name:po_stu_name},
                        success: function(response){
                            //$.alert('ทำการเพิ่มรายการข้อมูลแล้ว!');
                            setTimeout("location.reload(false)",1500); 
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_po_stu_name").value = "";
                    setTimeout("location.reload(false)",1500);
                }
            }
    });  
}