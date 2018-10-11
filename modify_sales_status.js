function edit_row(id)
{
     var sal_stu_id = document.getElementById("sal_stu_id_val"+id).innerHTML;
     var sal_stu_name = document.getElementById("sal_stu_name_val"+id).innerHTML;

     document.getElementById("edit_sal_stu_id").value = sal_stu_id;
     document.getElementById("edit_sal_stu_name").value = sal_stu_name;  
}

function save_row()
{
     var sal_stu_id = document.getElementById("edit_sal_stu_id").value;
     var sal_stu_name = document.getElementById("edit_sal_stu_name").value;

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'sales_status_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:sal_stu_id,
                           sal_stu_name_val:sal_stu_name},
                           success:function(response) {
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
                        url:'sales_status_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
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
    var sal_stu_name = document.getElementById("new_sal_stu_name").value;
    
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'sales_status_page.php',
                        data:{insert_row:'insert_row',
                        sal_stu_name:sal_stu_name},
                        success: function(response){
                            location.reload(false); 
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    document.getElementById("new_sal_stu_name").value = "";
                    setTimeout("location.reload(false)",1500); 
                }
            }
    });  
}