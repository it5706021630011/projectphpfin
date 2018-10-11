<?php
    session_start();
    unset($_SESSION['item_store']);

	   include("connect.php");

    $sql_id = "SELECT MAX(so_id) AS id FROM sale_order";
    $query_id = mysqli_query($conn,$sql_id);
    $row = mysqli_fetch_array($query_id,MYSQLI_ASSOC);

    $sql_so_type = "SELECT * FROM sale_order_type";
    $query_so_type = mysqli_query($conn,$sql_so_type);

    $sql_cus = "SELECT * FROM customer";
    $query_cus = mysqli_query($conn,$sql_cus);

    $sql_pro = "SELECT * FROM product";
    $query_pro = mysqli_query($conn,$sql_pro);

    $new_so_id;

    if($row['id'] != null){
        $new_so_id = $row['id']+1;
    }
    else{
        $new_so_id = 1;
    }

    if(isset($_POST['delete_row'])){
        $row = $_POST['row_id'];

        $sql_delete = "DELETE FROM sale_order_detail WHERE so_id = '".$row."'";
        mysqli_query($conn,$sql_delete);

        $sql_delete_pod = "DELETE FROM sale_order WHERE so_id = '".$row."'";
        mysqli_query($conn,$sql_delete_pod);

        exit();
    }

    if(isset($_POST['insert_so'])){
        $sql_add_so = "UPDATE sale_order SET so_price_total = '".$_POST['total_price']."',so_annotation = '".$_POST['so_annotation']."' WHERE so_id = '".$_SESSION['so_id']."'";
        mysqli_query($conn,$sql_add_so);
        unset($_SESSION['so_id']);
        exit();
    }

    if(isset($_POST['change_so_stu'])){
      $sql_approve = "UPDATE sale_order SET sal_stu_id = '".$_POST['stu_id']."' WHERE so_id = '".$_POST['so_id']."'";
      mysqli_query($conn,$sql_approve);

      if($_POST['stu_id'] == "2"){
        //สำหรับตัดคลัง ต้องไปใส่ใน การส่งสินค้า
        // $sql_sele_app = "SELECT * FROM sale_order JOIN sale_order_detail ON sale_order.so_id = sale_order_detail.so_id AND sale_order.so_id = '".$_POST['so_id']."'";
        // $query_sele_app = mysqli_query($conn,$sql_sele_app);

          // while($app = mysqli_fetch_array($query_sele_app,MYSQLI_ASSOC)){
          //   $sql_cut_stock = "SELECT pro_amount FROM product WHERE pro_id = '".$app['pro_id']."'";
          //   $query = mysqli_query($conn,$sql_cut_stock);
          //   $run = mysqli_fetch_array($query,MYSQLI_ASSOC);
          //   $cut = $run['pro_amount'] - $app['sod_amount'];
          //
          //   $sql_cut_ed = "UPDATE product SET pro_amount = '".$cut."' WHERE pro_id = '".$app['pro_id']."'";
          //   mysqli_query($conn,$sql_cut_ed);
          // }

          $sql_sel_point = "SELECT * FROM sale_order WHERE point_have > 0 AND so_id = '".$_POST['so_id']."'";
          $query_sel_point = mysqli_query($conn,$sql_sel_point);
          $row_sel_point = mysqli_fetch_array($query_sel_point,MYSQLI_ASSOC);

          if($row_sel_point){
            $sql_sel_point_2 = "SELECT * FROM customer WHERE cus_id = '".$row_sel_point['cus_id']."'";
            $query_sel_point_2 = mysqli_query($conn,$sql_sel_point_2);
            $row_sel_point_2 = mysqli_fetch_array($query_sel_point_2,MYSQLI_ASSOC);

            $add_point = $row_sel_point_2['cus_point'] + $row_sel_point['point_have'];

            $sql_update_point = "UPDATE customer SET cus_point = '".$add_point."' WHERE cus_id = '".$row_sel_point_2['cus_id']."'";
            mysqli_query($conn,$sql_update_point);
          }
      }
      exit();
    }
?>
<html>
<head>
<title>การจัดการขายสินค้า</title>
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

    $("#new_so_date").datepicker({
      autoclose: true,
      language:'th',
      format: 'dd/M/yyyy',
    }).datepicker("setDate", "0");

  });

  function edit_so(id)
  {
      $.ajax({
          type:'post',
          url:'sale_page2.php',
          data:{edit_so:'edit_so',
                row_id:id},
          success:function(response){
              window.location.href = "sale_page2.php";
          }
      });
  }

  function save_row()
  {
       var emp_id = document.getElementById("edit_emp_id").value;
       var emp_name = document.getElementById("edit_emp_name").value;
       var emp_user = document.getElementById("edit_emp_user").value;
       var emp_pass = document.getElementById("edit_emp_pass").value;
       var emp_status = document.getElementById("edit_emp_status").value;

       $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                      $.ajax({
                            type:'post',
                            url:'purchase_page.php',
                            data:{
                             edit_row:'edit_row',
                             row_id:emp_id,
                             emp_name_val:emp_name,
                             emp_user_val:emp_user,
                             emp_pass_val:emp_pass,
                             emp_status_val:emp_status},
                             success:function(response) {
                                 $.alert('ทำการแก้ไขแล้ว!');
                                 location.reload(false);
                            }
                      });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการแก้ไขแล้ว!');
                      location.reload(false);
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
                          url:'sale_page.php',
                          data:{delete_row:'delete_row',
                          row_id:id},
                          success: function(response){
                              $.alert('ทำการลบแล้ว!');
                              setTimeout("location.reload(false)",1500);
                          }
                      });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการลบแล้ว!');
                  }
              }
      });
  }

  function change_so_stu(id) {
    var x = document.getElementById("new_app_id"+id).value;

      $.ajax({
          type:'post',
          url:'sale_page.php',
          data:{change_so_stu:'change_so_stu',
          stu_id:x,
          so_id:id},
          success: function(response){
              $.alert('เปลี่ยนแปลงการอนุมัติแล้ว!');
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
        การจัดการข้อมูลการขายซื้อสินค้า
        <!--<small>advanced tables</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">ข้อมูลการขายสินค้า </li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">รายการการขาย</h3>
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มข้อมูลการขายสินค้า</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="pro_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>รหัสการขายสินค้า</th>
                        <th>วันที่ขาย</th>
                        <th>ประเภทการขาย</th>
                        <th>ยอดรวม</th>
                        <th>สถานะการขาย</th>
                        <th>พิมพ์รายงาน</th>
                        <th>การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM sale_order JOIN sale_order_type ON sale_order.so_type_id = sale_order_type.so_type_id JOIN employee ON employee.emp_id = sale_order.emp_id JOIN sales_status ON sales_status.sal_stu_id = sale_order.sal_stu_id";
	               $query = mysqli_query($conn,$sql);

					while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
					{
                ?>
                    <tr id="row<?php echo $row['so_id'];?>">
                        <td id="so_id_val<?php echo $row['so_id'];?>"><a href="sale_page3.php?row_id=<?php echo $row['so_id'];?>"><?php echo "SO-".sprintf("%04d",$row['so_id']);?></a></td>
                        <td id="so_date_val<?php echo $row['so_id'];?>"><?php echo $row['so_date'];?></td>
                        <td id="so_type_name_val<?php echo $row['so_id'];?>"><?php echo $row['so_type_name'];?></td>
                        <td id="so_price_total_val<?php echo $row['so_id'];?>" align="right"><?php echo number_format($row['so_price_total'],2);?></td>
                        <?php
                            if($row['sal_stu_id'] == 1){
                                $color = "#FFC300";
                            }
                            else if($row['sal_stu_id'] == 2){
                                $color = "#34B71B";
                            }
                            else if($row['sal_stu_id'] == 3){
                                $color = "red";
                            }
                        ?>
                        <td id="so_stu_name_val<?php echo $row['so_id'];?>"><font color="<?php echo $color;?>"><?php echo $row['sal_stu_name'];?></font></td>
                        <td><button class="btn btn-success" id="edit_button<?php echo $row['po_id'];?>" onclick="javascript:window.open('print_so_page.php?id=<?php echo $row['so_id'];?>')"><i class="fa fa-print"></i></button></td>
                        <td>
                            <?php
                                $lock = "";
                                if($row['sal_stu_id'] != 1){
                                    $lock = "disabled";
                                }
                            ?>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['so_id'];?>" onclick="edit_so('<?php echo $row['so_id'];?>');" <?php echo $lock;?>><i class="fa fa-fw fa-pencil-square-o"></i></button>
                            <button class="btn btn-danger" id="delete_button<?php echo $row['so_id'];?>" onclick="delete_row('<?php echo $row['so_id'];?>');" <?php echo $lock;?>><i class="fa fa-fw fa-trash-o"></i></button>
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal_md1_<?php echo $row['so_id'];?>" id="edit_button<?php echo $row['so_id'];?>"><i class="fa fa-fw fa-pencil-square-o"></i> การอนุมัติ</button>

                        </td>
                        <input type="hidden" id="emp_id_val<?php echo $row['so_id'];?>" value="<?php echo $row['emp_id'];?>">
                    </tr>
                    <div class="modal fade" id="myModal_md1_<?php echo $row['so_id'];?>" role="dialog">
                         <div class="modal-dialog">
                             <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">การจัดการรายการ</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>การอนุมัติ</label>
                                        <select class="form-control select2" style="width: 100%;" id="new_app_id<?php echo $row['so_id'];?>" name="new_app_id" onchange="change_so_stu(<?php echo $row['so_id'];?>)" >
                                            <?php
                                                $sql_app = "SELECT * FROM sales_status";
                                                $query_app = mysqli_query($conn,$sql_app);
                                            ?>
                                                <option value="0">เลือกการอนุมัติ
                                            <?php
                                                while($row1 = mysqli_fetch_array($query_app,MYSQLI_ASSOC))
                                                {
                                            ?>
                                            <option value="<?php echo $row1['sal_stu_id'];?>"><?php echo $row1['sal_stu_name'];?>
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

             <form action="sale_page2.php" method="post">
                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการขายสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>รหัสการขายสินค้า</label>
                                            <input type="text" class="form-control" value="<?php echo "SO-".sprintf("%04d",$new_so_id);?>" readonly>
                                            <input type="hidden" class="form-control" name="new_so_id" id="new_so_id" value="<?php echo $new_so_id;?>">
                                        </div>
                                        <div class="form-group">
                                            <label>ลูกค้า</label>
                                            <select class="form-control select2" style="width: 100%;" name="new_cus_id" id="new_cus_id">
                                                <?php
                                                    while($row = mysqli_fetch_array($query_cus,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                      <option value="<?php echo $row['cus_id'];?>"><?php echo $row['cus_name'];?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>วันที่การสั่งซื้อ</label>
                                            <div class="input-group date">
                                              <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                              </div>
                                              <input type="text" class="form-control pull-right" name="new_so_date" id="new_so_date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>ประเภทการขาย</label>
                                            <select class="form-control select2" style="width: 100%;" name="new_so_type_id" id="new_so_type_id">
                                                <?php
                                                    while($row = mysqli_fetch_array($query_so_type,MYSQLI_ASSOC))
                                                    {
                                                ?>
                                                      <option value="<?php echo $row['so_type_id'];?>"><?php echo $row['so_type_name'];?></option>
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
                                <input type="submit" name="submit" class="btn btn-success" value="เพิ่มข้อมูลการสั่งซื้อ">
                             </div>
                        </div>
                    </div>
                </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
</body>
</html>
