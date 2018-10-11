<?php
    session_start();
	  include("connect.php");

	$sql = "SELECT * FROM payment JOIN payment_type ON payment.pay_type_id = payment_type.pay_type_id JOIN sale_order ON sale_order.so_id = payment.so_id";
	$query = mysqli_query($conn,$sql);

  if(isset($_POST['update_date'])){
    $id = $_POST['row_id'];
    $date = $_POST['date'];
    $sql_update_date = "UPDATE payment SET pay_date = '".$date."' WHERE pay_id = '".$id."'";
    mysqli_query($conn,$sql_update_date);

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
  var date = document.getElementById("new_pay_date").value;

    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการอัพเดทรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'payment_page.php',
                        data:{update_date:'update_date',
                        row_id:id,
                        date:date},
                        success: function(response){
                            $.alert('ทำการอัพเดทแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการอัพเดทแล้ว!');
                }
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
        การจัดการข้อมูลการชำระเงิน
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">การชำระเงิน</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการชำระเงิน</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการชำระเงิน</th>
                        <th>รหัสการขาย</th>
                        <th>ประเภทการชำระเงิน</th>
                        <th>วันที่การชำระเงิน</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['del_id'];?>">
                        <td id="pay_id_val<?php echo $row['pay_id'];?>"><?php echo $row['pay_id'];?></td>
                        <td id="so_id_val<?php echo $row['pay_id'];?>"><?php echo "SO-".sprintf("%04d",$row['so_id']);?></td>
                        <td id="pay_type_name_val<?php echo $row['pay_id'];?>"><?php echo $row['pay_type_name'];?></td>
                        <td id="pay_date_val<?php echo $row['pay_id'];?>"><?php echo $row['pay_date'];?></td>
                        <td>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#myModal_<?php echo $row['pay_id'];?>"><i class="fa fa fa-calendar"></i> วันที่ชำระเงิน</button>
                        </td>
                    </tr>

                    <div class="modal fade" id="myModal_<?php echo $row['pay_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">อัพเดทวันที่การชำระเงิน</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="form-group">
                                      <label>วันที่การชำระเงิน</label>
                                      <div class="input-group date">
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right date" name="new_pay_date" id="new_pay_date">
                                      </div>
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button class="btn btn-success pull-right" onclick="update_date(<?php echo $row['pay_id'];?>)">บันทึก</button>
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
