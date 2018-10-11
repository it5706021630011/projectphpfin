<?php
    session_start();
    include("connect.php");

	  $sql_pro_type = "SELECT * FROM product_type ORDER BY pro_type_name ASC";
    $query_pro_type = mysqli_query($conn,$sql_pro_type);

    if(isset($_POST['submit'])){
        $_SESSION['so_id'] = $_POST['new_so_id'];
        $strDate = explode('/',$_POST['new_so_date']);
        //echo $strDate[1];

        if($strDate[1] == 'ม.ค.'){
          $date =  "$strDate[2]-01-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ก.พ.'){
          $date =  "$strDate[2]-02-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'มี.ค'){
          $date =  "$strDate[2]-03-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'เม.ย.'){
          $date =  "$strDate[2]-04-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'พ.ค.'){
          $date =  "$strDate[2]-05-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'มิ.ย.'){
          $date =  "$strDate[2]-06-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ก.ค.'){
          $date =  "$strDate[2]-07-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ส.ค.'){
          $date =  "$strDate[2]-08-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ก.ย.'){
          $date =  "$strDate[2]-09-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ต.ค.'){
          $date =  "$strDate[2]-10-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'พ.ย.'){
          $date =  "$strDate[2]-11-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else if($strDate[1] == 'ธ.ค.'){
          $date =  "$strDate[2]-12-$strDate[0]";
          $dateCon = date("Y-m-d",strtotime($date));
        }
        else{
          echo 'Date Error';
        }

        $sql_vat = "SELECT * FROM vat WHERE vat_status = 1";
        $query_vat = mysqli_query($conn,$sql_vat);
        $row_vat = mysqli_fetch_array($query_vat,MYSQLI_ASSOC);

        $sql_point_set = "SELECT * FROM point_type WHERE pot_type_status = 1";
        $query_point_set = mysqli_query($conn,$sql_point_set);
        $row_point_set = mysqli_fetch_array($query_point_set,MYSQLI_ASSOC);

        $sql_add_so = "INSERT INTO sale_order VALUES ('".$_POST['new_so_id']."','1','".$_POST['new_so_type_id']."','".$_POST['new_cus_id']."','".$_SESSION['UserID']."','".$dateCon."','0','0','0','','".$row_vat['vat_id']."','".$row_point_set['pot_type_point']."')";
        mysqli_query($conn,$sql_add_so);

    }

    if(isset($_POST['add_items'])){
        $so_id =  $_POST['so_id'];
        $pro_id = $_POST['pro_id'];
        $so_amount = $_POST['pro_amount'];
        $pro_price = $_POST['pro_price'];

        $sql_add_item = "INSERT INTO sale_order_detail VALUES ('','".$so_id."','".$pro_id."','".$so_amount."','".$pro_price."')";
        mysqli_query($conn,$sql_add_item);
        exit();
    }

    if(isset($_POST['edit_so'])){
        unset($_SESSION['so_id']);
        $_SESSION['so_id'] = $_POST['row_id'];
        $_SESSION['edit_so'] = $_POST['edit_so'];
    }

    if(isset($_POST['pro_type_id'])) {
        $sql_pro_id = "SELECT * FROM product JOIN product_type ON product.pro_type_id = product_type.pro_type_id AND product_type.pro_type_id = '".$_POST['pro_type_id']."' WHERE product.pro_id NOT IN (SELECT pro_id FROM sale_order_detail WHERE so_id = '".$_SESSION['so_id']."')";
        $sql_pro_id = mysqli_query($conn,$sql_pro_id);
    ?>
	   <option value="">เลือกรหัสสินค้า</option>

    <?php
	   while($row2 = mysqli_fetch_array($sql_pro_id,MYSQLI_ASSOC)){
    ?>
	   <option value="<?php echo $row2["pro_id"]; ?>"><?php echo "MCS-".sprintf("%04d",$row2['pro_id'])?> : <?php echo $row2['pro_name'];?></option>
    <?php
    }
        exit();
    }

    if(isset($_POST['pro_id'])){
        $sql_pro_unit = "SELECT * FROM product JOIN product_unit ON product.pro_unit_id = product_unit.pro_unit_id AND pro_id = '".$_POST['pro_id']."'";
        $query_pro_unit = mysqli_query($conn,$sql_pro_unit);

	   while($row2 = mysqli_fetch_array($query_pro_unit,MYSQLI_ASSOC)){
    ?>
	   <option value="<?php echo $row2["pro_unit_id"]; ?>"><?php echo $row2['pro_unit_name'];?></option>
    <?php
	   }
        exit();
    }

    if(isset($_POST['pro_id_price'])){
      $sql_pro_price = "SELECT * FROM product WHERE pro_id = '".$_POST['pro_id_price']."'";
      $query_pro_price = mysqli_query($conn,$sql_pro_price);

      while($row3 = mysqli_fetch_array($query_pro_price,MYSQLI_ASSOC)){
        // $price = $row3['pro_price'];
      ?>
        <input type="number" class="form-control" id="new_pro_price" value="<?php echo $row3['pro_price'];?>">
      <?php
 	   }
     exit();
    }

    if(isset($_POST['edit_row'])){
        $sql_edit_item = "UPDATE sale_order_detail SET sod_amount = '".$_POST['pro_amount_val']."',sod_price = '".$_POST['pro_price_val']."' WHERE sod_id = '".$_POST['sod_id']."'";
        mysqli_query($conn,$sql_edit_item);
        exit();
    }

    if(isset($_POST['delete_row'])){
        $sql_del_item = "DELETE FROM sale_order_detail WHERE sod_id = '".$_POST['row_id']."' ";
        mysqli_query($conn,$sql_del_item);
        exit();
    }
?>
<html>
<head>
<title>การขายสินค้า</title>
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
  <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
  <script src="plugins/datepicker/locales/bootstrap-datepicker.th.js" charset="UTF-8"></script>

  <script>

    $(function () {

  });

  function edit_row(id)
  {
       var pro_id = document.getElementById("pro_id_val"+id).innerHTML;
       var pro_type = document.getElementById("pro_type_id_val"+id).innerHTML;
       var pro_amount = document.getElementById("pro_amount_val"+id).innerHTML;
       var pro_price = document.getElementById("price_val"+id).value;
       var pro_unit = document.getElementById("pro_unit_val"+id).innerHTML;
       var pro_name = document.getElementById("pro_name_val"+id).value;

       document.getElementById("edit_pro_id").value = pro_id+" : "+pro_name;
       document.getElementById("edit_pro_type").value = pro_type;
       document.getElementById("edit_pro_amount").value = pro_amount;
       document.getElementById("edit_pro_price").value = pro_price;
       document.getElementById("edit_pro_unit").value = pro_unit;
       document.getElementById("edit_new_sod_id").value = id;
  }

  function save_row()
  {
       var pro_amount = document.getElementById("edit_pro_amount").value;
       var pro_price = document.getElementById("edit_pro_price").value;
       var sod_id = document.getElementById("edit_new_sod_id").value;

       $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการแก้ไขรายการข้อมูลใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                      $.ajax({
                            type:'post',
                            url:'sale_page2.php',
                            data:{
                             edit_row:'edit_row',
                             sod_id:sod_id,
                             pro_amount_val:pro_amount,
                             pro_price_val:pro_price},
                             success:function(response) {
                                 $.alert('ทำการแก้ไขแล้ว!');
                                 setTimeout("location.reload(false)",1500);
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
                          url:'sale_page2.php',
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

  function add_item()
  {
      var so_id = document.getElementById("new_so_id").value;
      var pro_id = document.getElementById("new_pro_id").value;
      var pro_amount = document.getElementById("new_pro_amount").value;
      var pro_price = document.getElementById("new_pro_price").value;

      $.confirm({
              title: 'การยืนยัน!',
              content: 'คุณต้องการเพิ่มรายการข้อมูลใช่หรือไม่!',
              buttons: {
                  ตกลง: function () {
                      $.ajax({
                          type:'post',
                          url:'sale_page2.php',
                          data:{
                                add_items:'add_items',
                                so_id:so_id,
                                pro_id:pro_id,
                                pro_amount:pro_amount,
                                pro_price:pro_price},
                          success: function(data){
                              //alert(so_id+" "+pro_id+" "+pro_amount+" "+pro_price);
                              $.alert('ทำการเพิ่มข้อมูลเรียบร้อยแล้ว!');
                              setTimeout("location.reload(false)",1500);
                          }
                      });
                  },
                  ยกเลิก: function () {
                      $.alert('ยกเลิกการเพิ่มรายการข้อมูลแล้ว!');
                      document.getElementById("new_pro_id").value = "";
                      document.getElementById("new_pro_amount").value = "";
                      document.getElementById("new_pro_price").value = "";
                      setTimeout("location.reload(false)",1500);
                  }
              }
      });

  }

  function getProduct(val) {

          $.ajax({
              type: "POST",
              url: "sale_page2.php",
              data: 'pro_type_id='+val,
              success: function(data){
                  $("#new_pro_id").html(data);
                    $("#new_pro_unit").html(data) = "";
                  //document.getElementById("new_pro_name").options[val].selected = true;
          }
  	});
  }

  function getProductID(val) {

          $.ajax({
              type: "POST",
              url: "sale_page2.php",
              data: 'pro_id='+val,
              success: function(data){
                  $("#new_pro_unit").html(data);
                  getProductPrice(val);
                  //document.getElementById("new_pro_name").options[val].selected = true;
          }
  	});
  }

  function getProductPrice(val) {

          $.ajax({
              type: "POST",
              url: "sale_page2.php",
              data: 'pro_id_price='+val,
              success: function(data){
                  $("#new_pro_price_box").html(data);
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
      <h1>เพิ่มรายละเอียดการขายสินค้า</h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">การจัดการข้อมูล</a></li>
        <li class="active">รายละเอียดการขายสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-3">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายละเอียดการขายสินค้า</h3>
                    </div>
                        <div class="box-body">
                            <?php
                                $sql_so1 = "SELECT * FROM sale_order JOIN customer ON sale_order.cus_id = customer.cus_id JOIN sale_order_type ON sale_order.so_type_id = sale_order_type.so_type_id AND sale_order.so_id = '".$_SESSION['so_id']."'";
                                $query_so1 = mysqli_query($conn,$sql_so1);

                                while($row = mysqli_fetch_array($query_so1,MYSQLI_ASSOC))
                                {
                            ?>
                            <div class="form-group">
                                <label>รหัสการขายสินค้า</label>
                                <input type="text" class="form-control" value="<?php echo "SO-".sprintf("%04d",$row['so_id']);?>" readonly>
                                <input type="hidden" class="form-control" name="new_so_id" id="new_so_id" value="<?php echo $row['so_id'];?>">
                            </div>
                            <div class="form-group">
                                <label>ลูกค้า</label>
                                <input type="text" class="form-control" id="new_cus_id" value="<?php echo $row['cus_name'];?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>วันที่การขาย</label>
                                <input type="date" class="form-control" id="new_so_date" value="<?php echo $row['so_date']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>ประเภทการขาย</label>
                                <input type="text" class="form-control" id="new_so_type_id" value="<?php echo $row['so_type_name']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>พนักงาน</label>
                                <input type="text" class="form-control" id="new_emp" value="<?php echo $_SESSION['UserName'];?>" readonly>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                </div>

                <div class="modal fade" id="myModal" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">เพิ่มข้อมูลการขายสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_type" onChange="getProduct(this.value);">
                                                <option value="">เลือกประเภทสินค้า</option>
                                            <?php
                                                while($row = mysqli_fetch_array($query_pro_type,MYSQLI_ASSOC))
                                                {
                                            ?>
                                                    <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                                            <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <select class="form-control select2" style="width: 100%;" id="new_pro_id" onChange="getProductID(this.value);">
                                                <!--<option value="">เลือก</option>-->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนสินค้า </label>
                                            <input type="number" class="form-control" id="new_pro_amount">
                                        </div>
                                        <label>หน่วยของสินค้า</label>
                                        <select class="form-control select2" style="width: 100%;" id="new_pro_unit" readonly>
                                        </select>
                                        <!--<input type="text" class="form-control" id="new_pro_unit" readonly>-->
                                        <div class="form-group">
                                            <label>ราคาสินค้า</label>
                                            <div class="form-inline">
                                              <div  id="new_pro_price_box"></div>
                                            <!-- <input type="number" class="form-control" id="new_pro_price"> -->
                                            <label>บาท</label>
                                            </div>
                                        </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <button class="btn btn-success" onclick="add_item()">เพิ่มสินค้า</button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">รายการสินค้าขาย</h3>
                        <button class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> เพิ่มสินค้าขาย</button>
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
                                    <th>ราคาสินค้า/หน่วย (บาท)</th>
                                    <th>ราคารวม (บาท)</th>
                                    <th>การจัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $sql_ck_empty_item = "SELECT * FROM sale_order_detail WHERE so_id = '".$_SESSION['so_id']."'";
                                $query_ck_empty_item = mysqli_query($conn,$sql_ck_empty_item);
                                $obj2 = mysqli_fetch_array($query_ck_empty_item,MYSQLI_ASSOC);

                                if(!empty($obj2)){

                                    $sql = "SELECT * FROM sale_order_detail JOIN sale_order ON sale_order.so_id = sale_order_detail.so_id JOIN product ON sale_order_detail.pro_id = product.pro_id JOIN product_type ON product_type.pro_type_id = product.pro_type_id JOIN product_unit ON product_unit.pro_unit_id = product.pro_unit_id AND sale_order_detail.so_id = '".$_SESSION['so_id']."'";
	                                $query = mysqli_query($conn,$sql);

                                    while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
                            ?>
                                <tr id="row<?php echo $row['sod_id'];?>">
                                    <td id="pro_id_val<?php echo $row['sod_id'];?>"><?php echo "MCS-".sprintf("%04d",$row['pro_id'])?></td>
                                    <td id="pro_type_id_val<?php echo $row['sod_id'];?>"><?php echo $row['pro_type_name'];?></td>
                                    <td id="name_val<?php echo $row['sod_id'];?>"><?php
                                    if (strlen($row['pro_name']) > 20)
                                    {
                                        echo substr($row['pro_name'], 0, 20)."<font color='blue'> ...</font>";
                                    }
                                    else
                                    {
                                        echo $row['pro_name'];
                                    }?>
                                    <input type="hidden" id="pro_name_val<?php echo $row['sod_id'];?>" value="<?php echo $row['pro_name']?>">
                                    </td>
                                    <td id="pro_amount_val<?php echo $row['sod_id'];?>" align="right"><?php echo $row['sod_amount'];?></td>
                                    <td id="pro_unit_val<?php echo $row['sod_id'];?>"><?php echo $row['pro_unit_name'];?></td>
                                    <td id="pro_price_val<?php echo $row['sod_id'];?>" align="right"><?php echo number_format($row['sod_price'],2);?></td>
                                    <td id="pro_price_total_val<?php echo $row['sod_id'];?>" align="right"><?php echo number_format($row['sod_amount']*$row['sod_price'],2);?></td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#myModal2" id="edit_button<?php echo $row['sod_id'];?>" onclick="edit_row('<?php echo $row['sod_id'];?>');"><i class="fa fa-fw fa-pencil-square-o"></i></button>
                                        <button class="btn btn-danger" id="delete_button<?php echo $row['pro_id'];?>" onclick="delete_row('<?php echo $row['sod_id'];?>');"><i class="fa fa-fw fa-trash-o"></i></button>
                                    </td>
                                    <input type="hidden" id="price_val<?php echo $row['sod_id'];?>" value="<?php echo $row['sod_price'];?>">
                                </tr>
                            <?php
                                    }
                                }
                            ?>
                            </tbody>
                          </table>
                    </div>
                </div>

                <div class="modal fade" id="myModal2" role="dialog">
                     <div class="modal-dialog">
                         <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">แก้ไขข้อมูลการขายสินค้า</h4>
                            </div>
                            <div class="modal-body">
                                        <div class="form-group">
                                            <label>ประเภทสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_type" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>รหัสสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_id" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>จำนวนสินค้า </label>
                                            <input type="number" class="form-control" id="edit_pro_amount">
                                        </div>
                                        <div class="form-group">
                                            <label>หน่วยของสินค้า</label>
                                            <input type="text" class="form-control" id="edit_pro_unit" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>ราคาสินค้า</label>
                                            <div class="form-inline">
                                            <input type="number" class="form-control" id="edit_pro_price">
                                            <label>บาท</label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="edit_new_sod_id">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-default pull-left" data-dismiss="modal">ปิด</button>
                                <input type="submit" class="btn btn-success" value="แก้ไขสินค้า" onclick="save_row();">
                             </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-success pull-right" onclick="javascript:location.href='sale_page3.php'">ดำเนินการต่อ <i class="fa fa-arrow-circle-right"></i></button>
            </div>
            <div class="col-xs-12">
              <a href="javascript:location.href='sale_page.php'" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> ก่อนหน้า</a>
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
