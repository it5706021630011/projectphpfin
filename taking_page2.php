<!-- <?php
    session_start();
    include("connect.php");
    date_default_timezone_set('Asia/Bangkok');

    if(isset($_POST['submit'])){
      $_SESSION['po_id'] = $_POST['new_po_id'];
      $_SESSION['tak_id'] =$_POST['new_tak_id'];
    }

    if(isset($_POST['data_show'])){
      $_SESSION['mgs'] = $_POST['datas'];
      print_r($_SESSION['mgs']);
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
  <script src="js/bootstrap-number-input.js"></script>

  <style>
  .unselectable{
    background-color: #ddd;
    cursor: not-allowed;
    }
  </style>
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

        // document.getElementById("edit_tak_date").valueAsDate = new Date();

        $('#chkAll').click(function () {
          $('input:checkbox').prop('checked', this.checked);
        });

        $('.colorful').bootstrapNumber({
        	upClass: 'success',
        	downClass: 'danger'
        });
      });

  function sum_check(){
    var check = [];

    $('.icheck').each(function () {
      if($(this).is(':checked')){
        check.push($(this).val());
      }
    });
    console.log(check);

    var k = 0;
    var data = [];


    for(k; k < check.length ; k++){
      var amount = document.getElementById("tak_amount"+check[k]).value;
      var product_id = document.getElementById("pro_id_val"+check[k]).innerHTML;
      var product_name = document.getElementById("name_val"+check[k]).innerHTML;
      var product_unit = document.getElementById("pro_unit_val"+check[k]).innerHTML;

      if(amount < 1){
        return $.alert("สินค้ารหัส "+product_id+" ไม่กรอกจำนวนสินค้า!");
      }

      data.push([]);
      data[k][0] = check[k];
      data[k][1] = product_id;
      data[k][2] = product_name;
      data[k][3] = product_unit;
      data[k][4] = amount;
    }

    console.log(data);

    //var jsonString = JSON.stringify(data);

    $.ajax({
      type:'post',
      url:'taking_page2.php',
      data:{
      },
      success: function(response){
        var content = '';
        var r;
        // var h;

        for(r = 0; r < check.length ; r++){
          // if(data[r][0] == check[r]){
            content += '<tr><td>'+(r+1)+'</td><td id="id_take'+data[r][0]+'">'+data[r][1]+'</td><td>'+data[r][2]+'</td><td>'+data[r][3]+'</td><td id="amount_take'+data[r][0]+'">'+data[r][4]+'</td></tr>';
            content += '<input type="hidden" name="id['+data[r][0]+']" value="'+data[r][4]+'">';
          // }
        }

        $('#content').html(content);
        //alert(check);
        // alert("มาแล้ว");
      },
      error: function(response){
        alert("เกิดความผิดพลาด!");
      }
    });
  }

  function save_take_prodyct() {
    $.ajax({
      type:'post',
      url:'taking_page.php',
      data:{},
      success: function(response){

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
                            $sql = "SELECT * FROM purchase_order JOIN company ON purchase_order.com_id = company.com_id AND purchase_order.po_id = '".$_SESSION['po_id']."'";
                            $query = mysqli_query($conn,$sql);

                            while($row = mysqli_fetch_array($query,MYSQLI_ASSOC))
                            {
                          ?>
                            <div class="form-group">
                                <label>รหัสการรับสินค้า</label>
                                <input type="text" class="form-control" value="<?php echo "RE-".sprintf("%04d",$_SESSION['tak_id']);?>" readonly>
                                <input type="hidden" id="edit_tak_id" value="<?php echo $row['po_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>รหัสการสั่งซื้อสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo "PO-".sprintf("%04d",$row['po_id']);?>" readonly>
                                <input type="hidden" id="edit_po_id" value="<?php echo $row['po_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>วันที่รับสินค้า</label>
                                <input type="text" class="form-control" id="edit_tak_date" value="<?php echo date("Y-m-d");?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>บริษัทจัดจำหน่าย</label>
                                <input type="text" class="form-control" value="<?php echo $row['com_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>พนักงานรับสินค้า</label>
                                <input type="text" class="form-control" id="po_id" value="<?php echo $_SESSION['UserName'];?>" readonly>
                                <input type="hidden" id="edit_po_id" value="<?php echo $row['po_id'];?>">
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
                        <h3 class="box-title">รายการสินค้าสั่งซื้อ</h3>
                        <button class="btn btn-primary" onclick="sum_check()"><i class="fa fa fa-list"></i> สรุปการรับสินค้า</button>
                    </div>
                    <div class="box-body">
                      <form>
                        <table id="pro_table" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" name="chkAll" id="chkAll"></th>
                                    <th>รหัสสินค้า</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>หน่วย</th>
                                    <th>สินค้าทั้งหมด</th>
                                    <th>สินค้าที่เหลือ</th>
                                    <th>สินค้าที่จะรับ</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_tak_pro = "SELECT * FROM purchase_order_detail JOIN product ON product.pro_id = purchase_order_detail.pro_id JOIN purchase_order ON purchase_order_detail.po_id = purchase_order.po_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND purchase_order.po_id = '".$_SESSION['po_id']."'";
                                $query_tak_pro = mysqli_query($conn,$sql_tak_pro);

                                while($row = mysqli_fetch_array($query_tak_pro,MYSQLI_ASSOC))
                                {
                                  $sql_leftovers = "SELECT *,sum(tad_amount) amount FROM taking_detail JOIN taking ON taking.tak_id = taking_detail.tak_id AND taking.po_id = '".$_SESSION['po_id']."' AND taking_detail.pro_id = '".$row['pro_id']."' ";
                                  $query_leftovers = mysqli_query($conn,$sql_leftovers);
                                  $se = mysqli_fetch_array($query_leftovers,MYSQLI_ASSOC);

                                  if(($row['pod_amount']-$se['amount']) == 0){
                                    $color = "unselectable";
                                    $disable = true;
                                  }else{
                                    $color = "";
                                    $disable = false;
                                  }
                                  // echo $sql_leftovers." ";
                                  // echo $row['pod_amount']." ";
                                  // echo $se['amount']." ";
                            ?>
                                <tr id="row<?php echo $row['pro_id'];?>" class="<?php echo $color;?>">
                                    <td>
                                      <?php
                                        if($disable == false){
                                      ?>
                                        <input type="checkbox" name="chkItem[]" id="chkItem" class="icheck" value="<?php echo $row['pro_id'];?>">
                                      <?php
                                        }
                                      ?>
                                    </td>
                                    <td id="pro_id_val<?php echo $row['pro_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id']);?></td>
                                    <td id="name_val<?php echo $row['pro_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 25){
                                        echo substr($row['pro_name'], 0, 25)."<font color='blue'> ...</font>";
                                    }
                                    else{
                                        echo $row['pro_name'];
                                    }?></td>
                                    <td id="pro_unit_val<?php echo $row['pro_id'];?>" align="right" width="10%"><?php echo $row['pro_unit_name'];?></td>
                                    <td id="tak_total_amount_val<?php echo $row['pro_id'];?>" align="right" width="15%"><?php echo $row['pod_amount'];?></td>
                                    <?php
                                      $show_btn = 1;
                                      if($se){
                                    ?>
                                        <td id="tak_leftovers_amount_val<?php echo $row['pro_id'];?>" width="15%" align="right"><?php echo $row['pod_amount']-$se['amount'];?></td>
                                    <?php
                                        $x = $row['pod_amount']-$se['amount'];
                                        if($x == 0){
                                          $show_btn = 0;
                                        }
                                      }
                                      else{
                                    ?>
                                        <td id="tak_leftovers_amount_val<?php echo $row['pro_id'];?>" width="15%" align="right"><?php echo $row['pod_amount'];?></td>
                                    <?php
                                      }
                                    ?>
                                    <td id="tak_amount_val<?php echo $row['pro_id'];?>" align="center" width="15%">
                                      <?php
                                        if($show_btn == 1){
                                      ?>
                                        <input type="number" class="form-control colorful" style="width:50px" id="tak_amount<?php echo $row['pro_id'];?>" value="0" min="0" max="<?php echo $row['pod_amount']-$se['amount'];?>">
                                      <?php
                                        }
                                      ?>
                                    </td>
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

        <?php
          // if(isset($_POST['data'])){
          //   $data = json_decode(stripslashes($_POST['data']));
        ?>
        <form action="taking_page.php" method="post">
        <div class="col-xs-9 details">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">สรุปรายการรับสินค้า</h3>
                    <button class="btn btn-success" type="submit"><i class="fa fa fa-save"></i> บันทึกรายการ</button>
                </div>
                <div class="box-body">
                    <table id="pro_table2" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th>หน่วย</th>
                                <th>สินค้าที่จะรับ</th>
                            </tr>
                        </thead>
                        <tbody id="content">
                          <!-- <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr> -->
                        </tbody>
                        <input type="hidden" name="date_save" value="<?php echo date("Y-m-d");?>">
                        <input type="hidden" name="emp_save" value="<?php echo $_SESSION['UserID'];?>">
                      </table>
                  </div>
            </div>
        </div>
      </form>
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
</html> -->
