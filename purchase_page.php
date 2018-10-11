<!-- <?php
session_start();
date_default_timezone_set("Asia/Bangkok"); 
	include("connect.php");

    $sql_id = "SELECT MAX(po_id) AS id FROM purchase_order";
    $query_id = mysqli_query($conn,$sql_id);
    $row = mysqli_fetch_array($query_id,MYSQLI_ASSOC);

    $sql_com = "SELECT * FROM company";
    $query_com = mysqli_query($conn,$sql_com);

    $sql_pro = "SELECT * FROM product";
    $query_pro = mysqli_query($conn,$sql_pro);

    $new_po_id;

    $month = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");

    if($row['id'] != null){
        $new_po_id = $row['id']+1;
    }
    else{
        $new_po_id = 1;
    }

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];

        $sql_delete = "DELETE FROM purchase_order WHERE po_id = '".$row."'";
        mysqli_query($conn,$sql_delete);
        $sql_delete_pod = "DELETE FROM purchase_order_detail WHERE po_id = '".$row."'";
        mysqli_query($conn,$sql_delete_pod);
        exit();
    }

    if(isset($_POST['change_po_stu'])){
      $sql_approve = "UPDATE purchase_order SET po_stu_id = '".$_POST['stu_id']."' WHERE po_id = '".$_POST['po_id']."'";
      mysqli_query($conn,$sql_approve);
      exit();
    }

    if(isset($_POST['insert_po'])){
      $sql_update_po = "UPDATE purchase_order SET po_price_total = '".$_POST['total_price']."',po_annotation = '".$_POST['po_annotation']."' WHERE po_id = '".$_SESSION['po_id']."'";
      mysqli_query($conn,$sql_update_po);
      unset($_SESSION['po_id']);
      exit();
    }

?>
<html>
<head>
<title>การจัดการสั่งซื้อสินค้า</title>
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
  <script type="text/javascript" src="modify_purchase.js"></script>


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
  <!-- <script src="plugins/datepicker/bootstrap-datepicker-thai.js"></script> -->

  <script>

  $(function () {

    $("#pro_table,#pro_table2,#pro_table3").DataTable({
                    "order": [ 0, 'desc' ],
                    "oLanguage": {
                    "sLengthMenu": 'แสดง _MENU_ รายการ ต่อหน้า',
                    "sZeroRecords": 'ไม่เจอข้อมูลที่ค้นหา',
                    "sInfo": 'แสดง _START_ ถึง _END_ ของ _TOTAL_ รายการ',
                    "sInfoEmpty": "แสดง 0 ถึง 0 ของ 0 รายการ",
                    "sInfoFiltered": "(จากรายการทั้งหมด _MAX_ รายการ)",
                    "sSearch": "ค้นหา :",
            },
    });

    $("#new_po_date").datepicker({
      autoclose: true,
      language:'th',
      format: 'dd/M/yyyy',
    }).datepicker("setDate", "0");

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
      <h1>
        การจัดการข้อมูลการสั่งซื้อสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">การสั่งซื้อสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการสั่งซื้อสินค้า</h3>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลการสั่งซื้อสินค้า</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการสั่งซื้อสินค้า</th>
                        <th>วันที่การสั่งซื้อ</th>
                        <th>บริษัทจัดจำหน่าย</th>
                        <th>ราคารวม (บาท)</th>
                        <th>สถานะการสั่งซื้อ</th>
                        <th>พิมพ์รายงาน</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM purchase_order JOIN company ON purchase_order.com_id = company.com_id JOIN employee ON purchase_order.emp_id = employee.emp_id JOIN purchase_order_status ON purchase_order.po_stu_id = purchase_order_status.po_stu_id ORDER BY purchase_order.po_date DESC";
	               $query = mysqli_query($conn,$sql);

					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['po_id'];?>">
                        <td id="po_id_val<?php echo $row['po_id'];?>"><?php echo "PO-".sprintf("%04d",$row['po_id']);?></td>
                        <td id="po_date_val<?php echo $row['po_id'];?>"><?php $date = date_create($row['po_date']);echo date_format($date,"d-M-Y");?></td>
                        <td id="com_name_val<?php echo $row['po_id'];?>"><?php echo $row['com_name'];?></td>
                        <td id="po_price_total_val<?php echo $row['po_id'];?>" align="right"><?php echo number_format($row['po_price_total'],2);?></td>
                        <?php
                            if($row['po_stu_id'] == 1){
                                $color = "#FFC300";
                            }
                            else if($row['po_stu_id'] == 2){
                                $color = "#34B71B";
                            }
                            else if($row['po_stu_id'] == 3){
                                $color = "red";
                            }
                        ?>
                        <td id="po_stu_name_val<?php echo $row['po_id'];?>"><font color="<?php echo $color;?>"><?php echo $row['po_stu_name'];?></font></td>
                        <td><button class="btn btn-success" id="print_button<?php echo $row['po_id'];?>" onclick="javascript:window.open('print_po_page.php?id=<?php echo $row['po_id'];?>')"><i class="fa fa-print"></i></button></td>
                        <!--<td id="po_annotation_val<?php echo $row['po_id'];?>"><?php echo $row['po_annotation'];?></td>-->
                        <td>
                            <?php
                                $lock = "";
                                if($row['po_stu_id'] != 1){
                                    $lock = "disabled";
                                }
                            ?>
                            <button class="btn btn-warning" id="edit_button<?php echo $row['po_id'];?>" onclick="edit_po('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['po_id'];?>" onclick="delete_row('<?php echo $row['po_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal_md1_<?php echo $row['po_id'];?>" id="edit_button<?php echo $row['po_id'];?>"><i class="fa fa-fw fa-pencil-square-o"></i> การอนุมัติ</button>

                        </td>
                        <input type="hidden" id="com_id_val<?php echo $row['po_id'];?>" value="<?php echo $row['com_id'];?>">
                        <input type="hidden" id="emp_id_val<?php echo $row['po_id'];?>" value="<?php echo $row['emp_id'];?>">
                    </tr>

                    <div class="modal fade" id="myModal_md1_<?php echo $row['po_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">การจัดการรายการ</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>การอนุมัติ</label>
                                        <select class="form-control select2" style="width: 100%;" id="new_app_id<?php echo $row['po_id'];?>" name="new_app_id" onchange="change_po_stu(<?php echo $row['po_id'];?>)" >
                                            <?php
                                                $sql_app = "SELECT * FROM purchase_order_status";
                                                $query_app = mysqli_query($conn,$sql_app);
                                            ?>
                                                  <option value="0">เลือกการอนุมัติ
                                            <?php
                                                while($row1 = mysqli_fetch_array($query_app,MYSQLI_ASSOC))
                                                {
                                            ?>
                                            <option value="<?php echo $row1['po_stu_id'];?>"><?php echo $row1['po_stu_name'];?>
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

          <div class="col-xs-6">
             <form action="purchase_page2.php" method="post">
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการสั่งซื้อสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสการสั่งซื้อสินค้า</label>
                                            <input type="text" class="form-control" value="<?php echo "PO-".sprintf("%04d",$new_po_id);?>" readonly>
                                            <input type="hidden" class="form-control" name="new_po_id" id="new_po_id" value="<?php echo $new_po_id;?>">
                                        </div>
                                        <div class="form-group">
                                            <label>วันที่การสั่งซื้อ</label>
                                            <div class="input-group date">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              <input type="text" class="form-control pull-right" name="new_po_date" id="new_po_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>บริษัทจัดจำหน่าย</label>
                                            <select class="form-control select2" style="width: 100%;" name="new_com_id" id="new_com_id">
                                                <?php
                                                    while($row = mysqli_fetch_array($query_com,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                      <option value="<?php echo $row['com_id'];?>"><?php echo $row['com_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>พนักงาน</label>
                                            <input type="text" class="form-control" id="new_emp" value="<?php echo $_SESSION['UserName'];?>" readonly>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <input type="submit" name="submit" class="btn btn-success" value="ถัดไป">
                             </div>
                        </div>
                    </div>
                </div>
            </form>

          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</body>
</html> -->
