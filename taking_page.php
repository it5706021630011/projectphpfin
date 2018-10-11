<!-- <?php
    session_start();
	  include("connect.php");

	$sql = "SELECT * FROM taking JOIN purchase_order ON taking.po_id = purchase_order.po_id JOIN taking_status ON taking_status.tak_stu_id = taking.tak_stu_id order by taking.tak_id DESC";
	$query = mysqli_query($conn,$sql);

  $sql_id = "SELECT MAX(tak_id) AS id FROM taking";
  $query_id = mysqli_query($conn,$sql_id);
  $row = mysqli_fetch_array($query_id,MYSQLI_ASSOC);

  if($row['id'] != null){
      $new_tak_id = $row['id']+1;
  }
  else{
      $new_tak_id = 1;
  }

  if(isset($_POST['id']) && isset($_POST['date_save']) && isset($_POST['emp_save'])){
    $date = date("Y-m-d",strtotime($_POST['date_save']));
    $sql_tak_add = "INSERT INTO taking VALUES('".$_SESSION['tak_id']."','".$_SESSION['po_id']."','".$date."','".$_POST['emp_save']."','1')";
    mysqli_query($conn,$sql_tak_add);

    foreach($_POST['id'] AS $i => $amount_id) {
      $sql_tak_de_add = "INSERT INTO taking_detail VALUES('','".$_SESSION['tak_id']."','".$i."','".$amount_id."')";
      // echo $sql_tak_de_add;
      mysqli_query($conn,$sql_tak_de_add);

      $sql_sel_pro = "SELECT * FROM product WHERE pro_id = '".$i."'";
      $query_sql_sel_pro = mysqli_query($conn,$sql_sel_pro);
      $sel_pro = mysqli_fetch_array($query_sql_sel_pro,MYSQLI_ASSOC);

      $amount = $sel_pro['pro_amount'] + $amount_id;

      $sql_add_pro = "UPDATE product SET pro_amount = '".$amount."' WHERE pro_id = '".$i."' ";
      mysqli_query($conn,$sql_add_pro);
    }

    $sql_ck_po = "SELECT sum(pod_amount) pod FROM purchase_order_detail WHERE po_id = '".$_SESSION['po_id']."'";
    $sql_ck_td = "SELECT sum(tad_amount) tad FROM taking_detail JOIN taking ON taking.po_id = '".$_SESSION['po_id']."' AND taking.tak_id = taking_detail.tak_id";
    $query_pod = mysqli_query($conn,$sql_ck_po);
    $query_tad = mysqli_query($conn,$sql_ck_td);

    $pod = mysqli_fetch_array($query_pod,MYSQLI_ASSOC);
    $tad = mysqli_fetch_array($query_tad,MYSQLI_ASSOC);

    // echo $pod['pod'];
    // echo $tad['tad'];

    if($pod['pod'] == $tad['tad']){
      $sql_update_staus = "UPDATE taking SET tak_stu_id = '2' WHERE po_id = '".$_SESSION['po_id']."'";
      mysqli_query($conn,$sql_update_staus);
    }
    unset($_SESSION['tak_id']);
    unset($_SESSION['po_id']);
    // exit();
    header("Refresh:0");
  }
?>
<html>
<head>
<title>การจัดการรับสินค้า</title>
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

    $("#new_tak_date").datepicker({
      autoclose: true,
      language:'th',
      format: 'dd/mm/yyyy',
    }).datepicker("setDate", "0");

  });

  function delete_row(id)
{
    $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการลบรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'taking_page.php',
                        data:{delete_row:'delete_row',
                        row_id:id},
                        success: function(response){
                            $.alert('ทำการลบแล้ว!');
                            location.reload(false);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการลบแล้ว!');
                }
            }
    });
}

  function getPurchase(val) {

        $.ajax({
            type: "POST",
            url: "taking_page.php",
            data: {getPurchase:'getPurchase',com_id:val},
            success: function(data){
                $("#new_po_id").html(data);
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
        การจัดการข้อมูลการรับสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">การรับสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการรับสินค้า</h3>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลการรับสินค้า</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการรับสินค้า</th>
                        <th>รหัสการสั่งซื้อสินค้า</th>
                        <th>วันที่รับสินค้า</th>
                        <th>สถานะการรับ</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['tak_id'];?>">
                        <td id="tak_id_val<?php echo $row['tak_id'];?>"><?php echo "RE-".sprintf("%04d",$row['tak_id']);?></td>
                        <td id="po_id_val<?php echo $row['tak_id'];?>"><?php echo "PO-".sprintf("%04d",$row['po_id']);?></td>
                        <td id="tak_date_val<?php echo $row['tak_id'];?>"><?php echo $row['tak_date'];?></td>
                        <td id="status_name_val<?php echo $row['tak_id'];?>"><?php echo $row['tak_stu_name'];?></td>
                        <td>
                        <button class="btn btn-primary" onclick="javascript:location.href='taking_page3.php?tak_id=<?php echo $row['tak_id'];?>&po_id=<?php echo $row['po_id'];?>'"><i class="fa fa-fw fa-list-ul"></i></button>
                        <!--<button class="btn btn-danger" id="delete_button<?php echo $row['po_id'];?>" onclick="delete_row('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>-->
                        </td>
                    </tr>
                <?php
					}
				?>
                </tbody>
              </table>
            </div>
          </div>

                <form action="taking_page2.php" method="post">
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการรับสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสการรับสินค้า<font color="red"> *</font></label>
                                            <input type="text" class="form-control" value="<?php echo "RE-".sprintf("%04d",$new_tak_id);?>" readonly>
                                            <input type="hidden" name="new_tak_id" value="<?php echo $new_tak_id;?>">
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสการสั่งซื้อ<font color="red"> *</font></label>
                                            <select class="form-control select2" style="width: 100%;" id="new_po_id" name="new_po_id">
                                            <?php
                                                $sql_po ="SELECT * FROM purchase_order WHERE purchase_order.po_stu_id = '2' ORDER BY purchase_order.po_id DESC";
                                                $query_po = mysqli_query($conn,$sql_po);
                                            ?>
                                                <option value="">เลือกรหัสการสั่งซื้อสินค้า</option>
                                            <?php
                                                while($row = mysqli_fetch_array($query_po,MYSQLI_ASSOC)){
                                                  $sql_ck_tak_id = "SELECT * FROM taking WHERE po_id = '".$row['po_id']."' AND tak_stu_id = '2'";
                                                  $query_ck_tak_id = mysqli_query($conn,$sql_ck_tak_id);
                                                  $tak = mysqli_fetch_array($query_ck_tak_id,MYSQLI_ASSOC);

                                                  if(!$tak){
                                            ?>
                                                    <option value="<?php echo $row["po_id"];?>"><?php echo "PO-".sprintf("%04d",$row['po_id']);?></option>
                                            <?php
                                                  }
                                                }
                                            ?>
                                            </select>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" type="submit" name="submit">เพิ่ม</button>
                            </div>
                        </div>
                    </div>
            </div>
          </form>

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
</html> -->
