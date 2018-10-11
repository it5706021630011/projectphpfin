<?php
    session_start();
    include("connect.php");

    // $view = false;
    $_SESSION['view'] = false;
    if(isset($_GET['row_id'])){
      // $view = true;
      $_SESSION['view'] = true;
      $_SESSION['so_id'] = $_GET['row_id'];
    }
?>
<html>
<head>
<title>Home</title>
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
  <link rel="stylesheet" type="text/css" href="dist/css/styleFont.css" />

  <script src="dist/js/app.min.js"></script>
  <script src="dist/js/demo.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
  <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script src="plugins/fastclick/fastclick.js"></script>
  <script src="plugins/select2/select2.full.min.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

  <script>

$(function () {

  // var view = '<=$view>';
  var view = '<=$_SESSION["view"];>';
  if(view == 'true'){
    $('.btn-success').hide();
  }
});

  function insert_so(){

      var so_annotation = document.getElementById("new_so_annotation").value;
      var total_price = document.getElementById("total_price_val").value;

      //alert(so_annotation+" "+total_price);
      $.confirm({
            title: 'การยืนยัน!',
            content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
            buttons: {
                ตกลง: function () {
                    $.ajax({
                        type:'post',
                        url:'sale_page.php',
                        data:{insert_so:'insert_so',
                             so_annotation:so_annotation,
                             total_price:total_price},
                        success: function(data){
                            $.alert('ทำการพิมพ์รายการข้อมูลแล้ว!');
                            $.confirm({
                                  title: 'การยืนยัน!',
                                  content: 'คุณต้องการพิมพ์รายการข้อมูลหรือไม่!',
                                  buttons: {
                                      ตกลง: function () {
                                          $.ajax({
                                              type:'post',
                                              url:'sale_page.php',
                                              data:{},
                                              success: function(data){
                                                  $.alert('ทำการเพิ่มรายการข้อมูลแล้ว!');
                                                  //setTimeout("window.location.href = 'sale_page.php'",1500);
                                              }
                                          });
                                      },
                                      ยกเลิก: function () {
                                          $.alert('ยกเลิกการพิมพ์รายการข้อมูลแล้ว!');
                                          //location.reload(false);
                                      }
                                  }
                          });
                            //setTimeout("window.location.href = 'sale_page.php'",1500);
                        }
                    });
                },
                ยกเลิก: function () {
                    $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                    //location.reload(false);
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
      <h1>สรุปรายละเอียดการขายสินค้า</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">สรุปรายละเอียดการขายสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12">
                <div class="box">
                        <div class="box-body">
                            <?php
                                $sql_so1 = "SELECT * FROM sale_order JOIN customer ON sale_order.cus_id = customer.cus_id JOIN sale_order_type ON sale_order.so_type_id = sale_order_type.so_type_id JOIN employee ON employee.emp_id = sale_order.emp_id AND sale_order.so_id = '".$_SESSION['so_id']."'";
                                $query_so1 = mysqli_query($conn,$sql_so1);

                                while($row = mysqli_fetch_array($query_so1,MYSQLI_ASSOC))
                                {
                            ?>
                            <div class="form-group col-xs-6">
                                <label>รหัสการขายสินค้า</label>
                                <input type="text" class="form-control" value="<?php echo "SO-".sprintf("%04d",$_SESSION['so_id']);?>" readonly>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>ลูกค้า</label>
                                <input type="text" class="form-control" id="new_cus_id" value="<?php echo $row['cus_name'];?>" readonly>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>วันที่การขาย</label>
                                <input type="date" class="form-control" value="<?php echo $row['so_date'];?>" readonly>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>ประเภทการขาย</label>
                                <input type="text" class="form-control" id="new_so_type_id" value="<?php echo $row['so_type_name'];?>" readonly>
                            </div>
                            <div class="form-group col-xs-6">
                                <label>พนักงาน</label>
                                <input type="text" class="form-control" id="new_emp" value="<?php echo $row['emp_name'];?>" readonly>
                            </div>
                        </div>
                            <?php
                              $annotation = $row['so_annotation'];
                                }
                            ?>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายการสินค้าขาย</h3>
                    </div>
                    <div class="box-body">
                        <table id="pro_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>รหัสสินค้า</th>
                                    <th>ประเภทสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>จำนวนสินค้า</th>
                                    <th>หน่วยของสินค้า</th>
                                    <th>ราคารวม (บาท)</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php
                                $total = 0;

                                 $sql = "SELECT * FROM sale_order_detail JOIN sale_order ON sale_order.so_id = sale_order_detail.so_id JOIN product ON sale_order_detail.pro_id = product.pro_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND sale_order_detail.so_id = '".$_SESSION['so_id']."'";
	                               $query = mysqli_query($conn,$sql);

                                    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                            ?>
                                <tr id="row<?php echo $row['sod_id'];?>">
                                    <td id="pro_id_val<?php echo $row['sod_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                                    <td id="pro_type_name_val<?php echo $row['sod_id'];?>"><?php echo $row['pro_type_name'];?></td>
                                    <td id="pro_name_val<?php echo $row['sod_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 35)
                                    {
                                        echo substr($row['pro_name'], 0, 35)."<font color='blue'> ...</font>";
                                    }
                                    else
                                    {
                                        echo $row['pro_name'];
                                    }?></td>
                                    <td id="sod_amount_val<?php echo $row['sod_id'];?>" align="right"><?php echo $row['sod_amount'];?></td>
                                    <td id="pro_unit_name_val<?php echo $row['sod_id'];?>"><?php echo $row['pro_unit_name'];?></td>
                                    <td id="pro_total_price_val<?php echo $row['sod_id'];?>" align="right">
                                        <?php echo number_format($row['sod_price']*$row['sod_amount'],2);
                                        $total += $row['sod_price']*$row['sod_amount'];?></td>
                                </tr>
                                <?php
                                 }
                                ?>
                                <tr>
                                    <td colspan="2">รวม (บาท)</td>
                                    <td colspan="3"></td>
                                    <td align="right"><b><?php echo number_format($total,2);?></b></td>
                                </tr>
                                <tr>
                                  <?php
                                    $sql_vat = "SELECT * FROM vat JOIN sale_order ON vat.vat_id = sale_order.vat_id AND sale_order.so_id = '".$_SESSION['so_id']."' ";
                                    $query_vat = mysqli_query($conn,$sql_vat);
                                    $row_vat = mysqli_fetch_array($query_vat,MYSQLI_ASSOC);

                                  ?>
                                    <td colspan="2">ค่าส่งสินค้า <?php echo $row_vat['vat_persent'];?></td>
                                    <td colspan="3"></td>
                                    <td align="right"><b>
                                      <?php
                                        $vat = $row_vat['vat_persent'];
                                        echo number_format($vat,2);
                                      ?>
                                    </b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">รวมราคาทั้งหมด (บาท)</td>
                                    <td colspan="3"></td>
                                    <td align="right"><b><?php $total += $vat;
                                    echo number_format($total,2);?></b></td>
                                </tr>
                                <tr>
                                    <td colspan="2">หมายเหตุ</td>
                                    <td colspan="3" class="anno_value"><input type="text" id="new_so_annotation" style="width:100%;" value="<?php echo $annotation;?>" <?php if($_SESSION['view'])echo "readonly";?>></td>
                                    <td></td>
                                </tr>
                            <input type="hidden" id="total_price_val" value="<?php echo $total;?>">
                        </tbody>
                      </table>
                    </div>
                </div>
                <button class="btn btn-success pull-right" onclick="insert_so()">ยืนยันการสั่งซื้อสินค้า</button>
            </div>
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
