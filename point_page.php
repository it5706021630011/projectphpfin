<!-- <?php
    session_start();
	include("connect.php");

	$sql = "SELECT * FROM contact";
	$query = mysqli_query($conn,$sql);

    if(isset($_POST['edit_row'])){
        $row = $_POST['row_id'];
        $pot_point = $_POST['pot_point'];
        $pot_sale = $_POST['pot_sale'];

        $sql_ck_id = "SELECT * FROM contact WHERE pot_type_id = '".$row."' AND pot_status = '1' ";
        $query_ck_id = mysqli_query($conn,$sql_ck_id);
        $num_0 = mysqli_num_rows($query_ck_id);

        if($num_0 > 0){
            $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกเปิดการใช้งานอยู่.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $sql_ck_update = "SELECT * FROM contact WHERE pot_type_point = '".$pot_point."' AND pot_type_sale = '".$pot_sale."' AND pot_type_id != '".$row."'";
            $query_ck_update = mysqli_query($conn,$sql_ck_update);
            $num = mysqli_num_rows($query_ck_update);

            if($num > 0){
                $mgs = "ไม่สามารถแก้ไขข้อมูลได้ !! เนื่องจากข้อมูลถูกซ้ำ.";
                $_SESSION['mgs'] = $mgs;
            }
            else{
                mysqli_query($conn,"UPDATE contact SET pot_type_point = '".$pot_point."', pot_type_sale = '".$pot_sale."' where pot_type_id ='".$row."'");
                $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
                $_SESSION['mgs'] = $mgs;
            }
        }          
        exit();
    }

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];

        $sql_delete = "DELETE FROM contact WHERE pot_type_id = '".$row."'";

        if(mysqli_query($conn,$sql_delete)){
            $mgs = "ทำการลบข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;
        }
        else{
            $mgs = "ไม่สามารถลบข้อมูลได้ !! เนื่องจากข้อมูลถูกใช้อยู่.";
            $_SESSION['mgs'] = $mgs;
        }
        exit();
    }

    if(isset($_POST['insert_row'])){
        $point = $_POST['point'];
        $sale = $_POST['sale'];

        $sql_ck_add = "SELECT * FROM contact WHERE pot_type_point = '".$point."' AND pot_type_sale = '".$sale."'";
        $query_ck_add = mysqli_query($conn,$sql_ck_add);
        $num = mysqli_num_rows($query_ck_add);

        if($num > 0){
            $mgs = "ไม่สามารถเพิ่มข้อมูลได้ !! เนื่องจากข้อมูลซ้ำ.";
            $_SESSION['mgs'] = $mgs;
        }
        else{
           $sql_add = "INSERT INTO contact VALUES('','".$point."','".$sale."','0')";
            mysqli_query($conn,$sql_add);
            $mgs = "ทำการเพิ่มข้อมูลแล้ว!";
            $_SESSION['mgs'] = $mgs;

        }
        exit();
    }

    if(isset($_POST['stu_vat'])){
        $id = $_POST['row_id'];

        $sql_update_0 = "UPDATE contact SET pot_type_status = '0' WHERE pot_type_id  != '".$id."' ";
        mysqli_query($conn,$sql_update_0);

        $sql_update = "UPDATE contact SET pot_type_status = '1' WHERE pot_type_id  = '".$id."' ";
        mysqli_query($conn,$sql_update);

        $mgs = "เปิดการใช้งานแล้ว!";
        $_SESSION['mgs'] = $mgs;

        exit();
    }
?>
<html>
<head>
<title>การจัดการข้อมูลแต้มสะสม</title>

  <meta http-equiv=Content-Type content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="plugins/select2/select2.min.css">

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel = "stylesheet" type = "text/css" href = "dist/css/styleFont.css" />

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

  <script>

  $(function () {

    $("#pro_table").DataTable({
                        "oLanguage": {
                        "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                        "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
                        "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                        "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                        "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                        "sSearch": "ค้นหา :",
                        "oPaginate": {
                            "sFirst":    "หน้าแรก",
                            "sPrevious": "ก่อนหน้า",
                            "sNext":     "ถัดไป",
                            "sLast":     "หน้าสุดท้าย"
                        }
                }
    });


  });

  function insert_row()
  {
      var point = document.getElementById("new_pro_unit_name").value;
      var sale = document.getElementById("new_pro_unit_sale").value;
      
      $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                      $.ajax({
                          type:'post',
                          url:'point_page.php',
                          data:{insert_row:'insert_row',
                            point:point,
                            sale:sale},
                          success: function(response){
                          location.reload(false);
                          }
                      });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                      document.getElementById("new_pro_unit_name").value = "";
                      document.getElementById("new_pro_unit_sale").value = "";
                      setTimeout("location.reload(false)",1500);
                  }
              }
      });  
  }

  function edit_row(id)
{
     var pot_id = document.getElementById("pro_unit_id_val"+id).innerHTML;
     var pot_point = document.getElementById("pro_unit_name_val"+id).innerHTML;
     var pot_sale = document.getElementById("pro_unit_sale_val"+id).innerHTML;

     document.getElementById("edit_pro_unit_id").value = pot_id;
     document.getElementById("edit_pro_unit_name").value = pot_point;
     document.getElementById("edit_pro_unit_sale").value = pot_sale;  
}

function save_row()
{
     var pot_id = document.getElementById("edit_pro_unit_id").value;
     var pot_point = document.getElementById("edit_pro_unit_name").value;
     var pot_sale = document.getElementById("edit_pro_unit_sale").value;  

     $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                          type:'post',
                          url:'point_page.php',
                          data:{
                           edit_row:'edit_row',
                           row_id:pot_id,
                           pot_point:pot_point,
                           pot_sale:pot_sale},
                           success:function(response) {
                               location.reload(false);
                          }
                    });
                },
                ยกเลิก: function () {
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
                        url:'point_page.php',
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
  
  function stu_vat(id){
    $.confirm({
        title: 'การยืนยัน!',
        content: 'คุณต้องการ <font color="red">เปิดการใช้งาน</font> ใช่หรือไม่!',
        buttons: {
            ตกลง: function () {
                $.ajax({
                      type:'post',
                      url:'point_page.php',
                      data:{
                       stu_vat:'stu_vat',
                       row_id:id},
                       success:function(response) {
                           location.reload(false);
                      }
                });
            },
            ยกเลิก: function () {
            }
        }
    });
  }
  </script>
   <script>
      var m = '<?=$_SESSION['mgs'];?>';
    if(m){
       $.alert(m);
       <?php unset($_SESSION['mgs']);?>
    }
   </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include("aside.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        การจัดการข้อมูลแต้มสะสม
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#">ข้อมูลพื้นฐาน</a></li>
        <li class="active">แต้มสะสม</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการแต้มสะสม</h3>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลแต้มสะสม</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสแต้มสะสม</th>
                        <th>แต้มสะสม (แต้ม)</th>
                        <th>แต้มสะสม (ขาย)</th>
                        <th>สถานะการทำงาน</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['pot_type_id'];?>">
                        <td id="pro_unit_id_val<?php echo $row['pot_type_id'];?>"><?php echo $row['pot_type_id'];?></td>
                        <td id="pro_unit_name_val<?php echo $row['pot_type_id'];?>"><?php echo $row['pot_type_point'];?></td>
                        <td id="pro_unit_sale_val<?php echo $row['pot_type_id'];?>"><?php echo $row['pot_type_sale'];?></td>
                        <td id="pro_unit_<?php echo $row['pot_type_id'];?>">
                         <?php 
                            if($row['pot_type_status'] == 1){
                                $text = "<font color='#34B71B'>กำลังใช้งาน...</font>";
                            }else{
                                $text = "<font color='red'>ปิด</font> <button class='btn btn-info' onclick='stu_vat(".$row['pot_type_id'].")'><i class='fa fa-power-off'></i> เปิดการใช้งาน</button>";
                            }
                            echo $text;
                        ?>
                        </td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['pot_type_id'];?>" onclick="edit_row('<?php echo $row['pot_type_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['pot_type_id'];?>" onclick="delete_row('<?php echo $row['pot_type_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                        </td>
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>

                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลแต้มสะสม</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>แต้มสะสม (แต้ม)</label>
                                            <input type="number" class="form-control" id="new_pro_unit_name" placeholder="แต้มสะสม (แต้ม)">
                                        </div>
                                        <div class="form-group">
                                            <label>ต่อ</label>
                                        </div>
                                        <div class="form-group">
                                            <label>แต้มสะสม (ขาย)</label>
                                            <input type="number" class="form-control" id="new_pro_unit_sale" placeholder="แต้มสะสม (ขาย)">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="insert_row()">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลแต้มสะสม</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสหน่วยของแต้มสะสม</label>
                                            <input type="text" class="form-control" id="edit_pro_unit_id" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>แต้มสะสม (แต้ม)</label>
                                            <input type="text" class="form-control" id="edit_pro_unit_name">
                                        </div>
                                        <div class="form-group">
                                            <label>ต่อ</label>
                                        </div>
                                        <div class="form-group">
                                            <label>แต้มสะสม (ขาย)</label>
                                            <input type="number" class="form-control" id="edit_pro_unit_sale">
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="save_row();">บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html> -->
