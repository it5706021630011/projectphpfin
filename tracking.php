<?php
    session_start();
	  include("connect.php");

	$sql = "SELECT * FROM delivery JOIN delivery_type ON delivery.del_type_id = delivery_type.del_type_id JOIN delivery_status ON delivery_status.del_stu_id = delivery.del_stu_id JOIN sale_order ON sale_order.so_id = delivery.so_id JOIN payment ON payment.so_id = delivery.so_id AND sale_order.sal_stu_id = 2";
	$query = mysqli_query($conn,$sql);

  if(isset($_POST['update_date'])){
    $id = $_POST['row_id'];
    $date = $_POST['date'];
    $sql_update_date = "UPDATE delivery SET del_date = '".$date."' WHERE del_id = '".$id."'";
    mysqli_query($conn,$sql_update_date);

    exit();
  }

  if(isset($_POST['change_del_stu'])){
    $status = $_POST['stu_id'];
    $id = $_POST['del_id'];
    $so_id = $_POST['so_id'];

    $sql_update_status = "UPDATE delivery SET del_stu_id = '".$status."' WHERE del_id = '".$id."'";
    mysqli_query($conn,$sql_update_status);

    if($status == 3){
      //สำหรับตัดคลัง ต้องไปใส่ใน การส่งสินค้า
      $sql_sele_app = "SELECT * FROM sale_order JOIN sale_order_detail ON sale_order.so_id = sale_order_detail.so_id AND sale_order.so_id = '".$so_id."'";
      $query_sele_app = mysqli_query($conn,$sql_sele_app);

        while($app = mysqli_fetch_array($query_sele_app,MYSQLI_ASSOC)){
          $sql_cut_stock = "SELECT pro_amount FROM product WHERE pro_id = '".$app['pro_id']."'";
          $query = mysqli_query($conn,$sql_cut_stock);
          $run = mysqli_fetch_array($query,MYSQLI_ASSOC);
          $cut = $run['pro_amount'] - $app['sod_amount'];

          $sql_cut_ed = "UPDATE product SET pro_amount = '".$cut."' WHERE pro_id = '".$app['pro_id']."'";
          mysqli_query($conn,$sql_cut_ed);
        }
    }
    exit();
  }

?>
<html>
<head>
<title>การจัดการชำระเงิน</title>
  <meta charset="utf-8">
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
  <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/jQueryUI/jquery.ui.core.js"></script>
  <script src="plugins/jQueryUI/jquery.ui.datepicker.js"></script>
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>

  <script>

  $(function () {

    $("#pro_table").DataTable({
                    "order": [ 0, 'desc' ],
                    "oLanguage": {
                    "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                    "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
                    "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                    "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "sSearch": "ค้นหา :"
            }
    });

    $(".date").datepicker({
      autoclose: true,
      language:'th',
      format: 'yyyy-m-dd',
    }).datepicker("setDate", "0");

  });

  function update_date(id)
{
  var date = document.getElementById("new_del_date").value;

    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการอัพเดทรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'tracking.php',
                        data:{update_date:'update_date',
                        row_id:id,
                        date:date},
                        success: function(response){
                            $.alert('ทำการอัพเดทแล้ว!')
                            setTimeout("location.reload(false)",1500);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการอัพเดทแล้ว!');
                }
            }
    });
}

function change_del_stu(id) {
  var x = document.getElementById("new_app_id"+id).value;
  var y = document.getElementById("so_id_"+id).value;

// alert(x+" "+y+" "+id);
    $.ajax({
        type:'post',
        url:'tracking.php',
        data:{change_del_stu:'change_del_stu',
        stu_id:x,
        del_id:id,
        so_id:y},
        success: function(response){
            $.alert('เปลี่ยนแปลงสถานะการจัดส่งแล้ว!');
            document.getElementById("new_app_id"+id).value = x;
            setTimeout("location.reload(false)",1500);
        }
    });
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
        การจัดการข้อมูลการจัดส่ง
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">การจัดส่ง</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการจัดส่ง</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการจัดส่ง</th>
                        <th>รหัสการขาย</th>
                        <th>ประเภทจัดส่ง</th>
                        <th>วันที่จัดส่ง</th>
                        <th>สถานะการจัดส่ง</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['del_id'];?>">
                        <td id="pay_id_val<?php echo $row['del_id'];?>"><?php echo $row['del_id'];?></td>
                        <td id="so_id_val<?php echo $row['del_id'];?>"><?php echo "SO-".sprintf("%04d",$row['so_id']);?></td>
                        <td id="pay_type_name_val<?php echo $row['del_id'];?>"><?php echo $row['del_type_name'];?></td>
                        <td id="pay_date_val<?php echo $row['del_id'];?>"><?php echo $row['del_date'];?></td>
                        <td id="pay_date_val<?php echo $row['del_id'];?>"><?php echo $row['del_stu_name'];?></td>
                        <input type="hidden" id="so_id_<?php echo $row['del_id'];?>" name="so_id" value="<?php echo $row['so_id'];?>">
                        <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal_2_<?php echo $row['del_id'];?>"><i class="fa fa fa-calendar"></i> วันที่จัดส่ง</button>
                        <button class="btn btn-info" data-toggle="modal" data-target="#myModal_3_<?php echo $row['del_id'];?>"><i class="fa fa-fw fa-pencil-square-o"></i> สถานะการจัดส่ง</button>
                        </td>
                    </tr>

                    <div class="modal fade" id="myModal_1_<?php echo $row['del_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">รายละเอียดการจัดส่ง</h4>
                                </div>
                                <div class="modal-body">
                                  <?php
                                    $sql_view_del = "SELECT * FROM delivery JOIN sale_order ON delivery.so_id = sale_order.so_id JOIN sale_order_detail ON sale_order_detail.so_id = sale_order.so_id AND delivery.so_id = '".$row['so_id']."'";
                                    $query_view_del = mysqli_query($conn,$sql_view_del);

                                  ?>
                                  <div class="form-group">
                                      <label>ชื่อจัดส่ง</label>
                                      <input type="text" class="form-control" value="<?php echo $row['del_name']?>">
                                  </div>
                                  <div class="form-group">
                                      <label>ที่อยู่จัดส่ง</label>
                                      <textarea class="form-control" row="3"><?php echo $row['del_address'];?></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label>รายการสินค้าจัดส่ง</label>
                                    <?php
                                    while($row_view_del = mysqli_fetch_array($query_view_del,MYSQLI_ASSOC)){
                                  ?>
                                    <p><?php echo $row_view_del['pro_id'];?></p><p><?php echo $row_view_del['pro_amount'];?></p>
                                  <?php
                                    }
                                  ?>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="myModal_2_<?php echo $row['del_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">อัพเดทวันที่จัดส่ง</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                      <label>วันที่จัดส่ง</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right date" name="new_del_date" id="new_del_date">
                                      </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-success pull-right" onclick="update_date(<?php echo $row['del_id'];?>)">บันทึก</button>
                                    <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                 </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="myModal_3_<?php echo $row['del_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">อัพเดทสถานะการจัดส่ง</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                      <label>สถานะการจัดส่ง</label>
                                      <select class="form-control select2" style="width: 100%;" id="new_app_id<?php echo $row['del_id'];?>" name="new_app_id" onchange="change_del_stu(<?php echo $row['del_id'];?>)" >
                                          <?php
                                              $sql_app = "SELECT * FROM delivery_status";
                                              $query_app = mysqli_query($conn,$sql_app);
                                          ?>
                                                <option value="0">เลือกสถานะการจัดส่ง
                                          <?php
                                              while($row1 = mysqli_fetch_array($query_app,MYSQLI_ASSOC))
                                              {
                                          ?>
                                          <option value="<?php echo $row1['del_stu_id'];?>"><?php echo $row1['del_stu_name'];?>
                                          <?php
                                              }
                                          ?>
                                      </select>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                 </div>
                            </div>
                        </div>
                    </div>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
</div>
</body>
</html>
