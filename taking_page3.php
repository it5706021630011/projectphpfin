<?php
    session_start();
    include("connect.php");
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_GET['tak_id']) && isset($_GET['po_id'])){
      $_SESSION['tak_id'] = $_GET['tak_id'];
      $_SESSION['po_id'] = $_GET['po_id'];
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

  <link href="https://fonts.googleapis.com/css?family=Kanit" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css"/>

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
  <script src="js/bootstrap-number-input.js" ></script>

  <script>
    $(document).ready(function() {
        $(".table").DataTable({
            "oLanguage": {
                "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                "sZeroRecords": 'ไม่ข้อมูลสินค้า',
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
            },
            "paging": false,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false
        });
  });
  </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("aside.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>แสดงรายละเอียดการรับสินค้า</h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">รายละเอียดการรับสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายละเอียดการรับสินค้า</h3>
                    </div>
                        <div class="box-body">
                          <?php
                            $sql = "SELECT * FROM taking JOIN purchase_order ON taking.po_id = purchase_order.po_id JOIN company ON purchase_order.com_id = company.com_id JOIN employee ON employee.emp_id = taking.emp_id AND taking.tak_id = '".$_SESSION['tak_id']."'";
                            $query = mysqli_query($conn,$sql);

                            while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
                            {
                          ?>
                            <div class="form-group">
                                <label>รหัสการรับสินค้า</label>
                                <input type="text" class="form-control" value="<?php echo "RE-".sprintf("%04d",$row['tak_id']);?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>รหัสการสั่งซื้อสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo "PO-".sprintf("%04d",$row['po_id']);?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>วันที่รับสินค้า</label>
                                <input type="text" class="form-control" id="edit_tak_date" value="<?php echo $row['tak_date'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>บริษัทจัดจำหน่าย</label>
                                <input type="text" class="form-control" value="<?php echo $row['com_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>พนักงานรับสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo $row['emp_name'];?>" readonly>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">สรุปรายการรับสินค้า</h3>
                    </div>
                    <div class="box-body">
                      <form>
                        <table id="pro_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>หน่วย</th>
                                    <th>สินค้าทั้งหมด</th>
                                    <th>สินค้าที่เหลือ</th>
                                    <th>สินค้ารับแล้ว</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_tak_pro = "SELECT * FROM taking JOIN taking_detail ON taking.tak_id = taking_detail.tak_id JOIN product ON product.pro_id = taking_detail.pro_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND taking.tak_id = '".$_SESSION['tak_id']."'";
                                $query_tak_pro = mysqli_query($conn,$sql_tak_pro);

                                while($row = mysqli_fetch_array($query_tak_pro,MYSQLI_ASSOC))
                                {
                            ?>
                                <tr id="row<?php echo $row['pro_id'];?>">
                                    <td id="pro_id_val<?php echo $row['pro_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                                    <td id="name_val<?php echo $row['pro_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 25){
                                        echo substr($row['pro_name'], 0, 25)."<font color='blue'> ...</font>";
                                    }
                                    else{
                                        echo $row['pro_name'];
                                    }?></td>
                                    <td id="pro_unit_val<?php echo $row['pro_id'];?>" align="right" width="10%"><?php echo $row['pro_unit_name'];?></td>
                                    <?php
                                      $sql_leftovers = "SELECT * FROM taking JOIN taking_detail ON taking.tak_id = taking_detail.tak_id AND taking_detail.tak_id = '".$row['tak_id']."' AND taking_detail.pro_id = '".$row['pro_id']."' JOIN purchase_order_detail ON purchase_order_detail.po_id = '".$_SESSION['po_id']."' AND purchase_order_detail.pro_id = '".$row['pro_id']."'";
                                      $query_leftovers = mysqli_query($conn,$sql_leftovers);
                                      $se = mysqli_fetch_array($query_leftovers,MYSQLI_ASSOC);

                                      $sql_leftovers_2 = "SELECT *,sum(taking_detail.tad_amount) amount FROM taking JOIN taking_detail ON taking.po_id = '".$_SESSION['po_id']."' AND taking_detail.pro_id = '".$row['pro_id']."' AND taking_detail.tak_id = taking.tak_id";
                                      $query_leftovers_2 = mysqli_query($conn,$sql_leftovers_2);
                                      $se_2 = mysqli_fetch_array($query_leftovers_2,MYSQLI_ASSOC);
                                      // echo $sql_leftovers;
                                    ?>
                                    <td id="tak_total_amount_val<?php echo $row['pro_id'];?>" align="right" width="15%"><?php echo $se['pod_amount'];?></td>
                                    <td id="tak_leftovers_amount_val<?php echo $row['pro_id'];?>" width="15%" align="right"><?php echo $se['pod_amount']-$se_2['amount'];?></td>
                                    <td id="tak_amount_val<?php echo $row['pro_id'];?>" align="right" width="15%"><font color="#34B71B"><?php echo $se['tad_amount'];?></font></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                          </table>
                        </form>
                      </div>
                </div>
        </div>
        <div class="col-xs-12">
          <a href="javascript:history.go(-1)" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> ก่อนหน้า</a>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    </div>
</body>
</html>
