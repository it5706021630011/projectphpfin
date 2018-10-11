<?php
    session_start();
    include("connect.php");
    if(isset($_GET["id"])){
      $sql_sel_pro = "SELECT * FROM product WHERE pro_id = '".$_GET["id"]."'";
      $query_sel_pro = mysqli_query($conn,$sql_sel_pro);
      $sel_pro = mysqli_fetch_array($query_sel_pro,MYSQLI_ASSOC);
    }

    if(isset($_POST["submit"]))
    {
        $pro_type = $_POST['new_pro_type'];
        $pro_name = $_POST['new_pro_name'];
        $pro_detail = $_POST['new_pro_detail'];
        $pro_price = $_POST['new_pro_price'];
        $pro_amount = $_POST['new_pro_amount'];
        $pro_unit = $_POST['new_pro_unit'];
        $pro_discount = $_POST['new_pro_discount'];
        $pro_annotation = $_POST['new_pro_annotation'];

        if($_FILES["image"]["name"] != ''){
            $test = explode('.',$_FILES["image"]["name"]);
            $test2 = $_FILES["image"]["name"];
            $ext = end($test);
            $name = rand(100, 999).$test2.'.'. $ext;
            $location = 'image_product/' . $name;  
            move_uploaded_file($_FILES["image"]["tmp_name"], $location);

            $pro_picture = $location;

            $sql_add = "UPDATE product SET pro_type_id='".$pro_type."',pro_name='".$pro_name."',pro_detail='".$pro_detail."',pro_price='".$pro_price."',pro_amount='".$pro_amount."',pro_unit_id='".$pro_unit."',pro_discount='".$pro_discount."',pro_picture='".$pro_picture."',pro_annotation='".$pro_annotation."' WHERE pro_id = '".$_GET["id"]."'";
            mysqli_query($conn,$sql_add);

        }else{
            $sql_add = "UPDATE product SET pro_type_id='".$pro_type."',pro_name='".$pro_name."',pro_detail='".$pro_detail."',pro_price='".$pro_price."',pro_amount='".$pro_amount."',pro_unit_id='".$pro_unit."',pro_discount='".$pro_discount."',pro_annotation='".$pro_annotation."' WHERE pro_id = '".$_GET["id"]."'";
            mysqli_query($conn,$sql_add);
        }

        $mgs = "ทำการแก้ไขข้อมูลแล้ว!";
        $_SESSION['mgs'] = $mgs;

        echo '<META HTTP-EQUIV="refresh" CONTENT="1.5">';

        // echo '<img src="'.$location.'" height="270" width="360"  />';
    }
?>
<html>
<head>
<title>การจัดการสินค้า</title>
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
  </style>
  <script>

    $(function () {

        $("#pro_table").DataTable({
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
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });

        $("#form_send").submit(function (){
            e.preventDefault();
            
            var name = document.getElementById("image").files[0].name;
            var form_data = new FormData();
            var ext = name.split('.').pop().toLowerCase();

            if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
                $.alert("ไม่ใช่ไฟล์รูปภาพ!!");
            }
            else{
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("image").files[0]);
                var f = document.getElementById("image").files[0];
                var fsize = f.size||f.fileSize;
                if(fsize > 2000000)
                {
                    $.alert("รูปภาพมีขนาดใหญ่เกินไป!!");
                }else{
                    form_data.append("image", document.getElementById('image').files[0]);
                    form_data.append("new_pro_type", document.getElementById("new_pro_type").value);
                    form_data.append("new_pro_name", document.getElementById("new_pro_name").value);
                    form_data.append("new_pro_detail", document.getElementById("new_pro_detail").value);
                    form_data.append("new_pro_price", document.getElementById("new_pro_price").value);
                    form_data.append("new_pro_amount", document.getElementById("new_pro_amount").value);
                    form_data.append("new_pro_unit", document.getElementById("new_pro_unit").value);
                    form_data.append("new_pro_discount", document.getElementById("new_pro_discount").value);
                    form_data.append("new_pro_annotation", document.getElementById("new_pro_annotation").value);

                    $.ajax({
                        url:"EditProduct.php",
                        method:"POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                        // $('#uploaded_image').html("<label class='text-success'>Image Uploading...</label>");
                        },   
                        success:function(data)
                        {
                            
                        },
                        error:function(){
                            $.alert("Error");
                        }
                    });
                }
            }
        return false;
        });

  });
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
        การจัดการข้อมูลสินค้า
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="#"></a>การจัดการข้อมูล</li>
        <li class="active">แก้ไขข้อมูลสินค้า</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">แก้ไขข้อมูลสินค้า</h3>
            </div>
            <div class="box-body">
              <form id="form-send" action="" method="post" enctype="multipart/form-data">
              <div class="form-group col-xs-6">
                  <label>ประเภทสินค้า<font color="red"> *</font></label>
                  <select class="form-control select2" style="width: 100%;" id="new_pro_type" name="new_pro_type" required>
                      <option value="">เลือกประเภทสินค้า</option>
                      <?php
                          $sql_type = "SELECT * FROM product_type";
                          $query_type = mysqli_query($conn,$sql_type);

                          while($row = mysqli_fetch_array($query_type,MYSQLI_ASSOC))
                          {
                            if($sel_pro['pro_type_id'] == $row['pro_type_id']){
                      ?>
                            <option value="<?php echo $row['pro_type_id'];?>" selected><?php echo $row['pro_type_name'];?></option>
                      <?php
                            }
                      ?>
                              <option value="<?php echo $row['pro_type_id'];?>"><?php echo $row['pro_type_name'];?></option>
                      <?php
                          }
                      ?>
                  </select>
              </div>
              <div class="form-group col-xs-6">
                  <label for="new_pro_name">ชื่อสินค้า<font color="red"> *</font></label>
                  <input type="text" class="form-control" id="new_pro_name" name="new_pro_name" value="<?php echo $sel_pro['pro_name'];?>" required>
              </div>
              <div class="form-group col-md-12">
                  <label>รายละเอียดสินค้า</label>
                  <textarea class="form-control" row="3" id="new_pro_detail" name="new_pro_detail"><?php echo $sel_pro['pro_detail'];?></textarea>
              </div>
              <div class="form-group col-xs-4">
                  <label>ราคาสินค้า/หน่วย (บาท)<font color="red"> *</font></label>
                  <input type="number" class="form-control" id="new_pro_price" name="new_pro_price" value="<?php echo $sel_pro['pro_price'];?>" required>
              </div>
              <div class="form-group col-xs-4">
                  <label>จำนวน<font color="red"> *</font></label>
                  <input type="number" class="form-control" id="new_pro_amount" name="new_pro_amount" value="<?php echo $sel_pro['pro_amount'];?>" required>
              </div>
              <div class="form-group col-xs-4">
                  <label>หน่วยของสินค้า<font color="red"> *</font></label>
                  <select class="form-control select2" style="width: 100%;" id="new_pro_unit" name="new_pro_unit" required>
                      <option value="">เลือกหน่วยของสินค้า</option>
                      <?php
                          $sql_unit = "SELECt * FROM product_unit";
                          $query_unit = mysqli_query($conn,$sql_unit);

                          while($row = mysqli_fetch_array($query_unit,MYSQLI_ASSOC))
                          {
                            if( $sel_pro['pro_unit_id'] == $row['pro_unit_id']){
                      ?>
                              <option value="<?php echo $row['pro_unit_id'];?>" selected><?php echo $row['pro_unit_name'];?></option>
                      <?php
                            }
                      ?>
                              <option value="<?php echo $row['pro_unit_id'];?>"><?php echo $row['pro_unit_name'];?></option>
                      <?php
                          }
                      ?>
                  </select>
              </div>
              <div class="form-group col-xs-4">
                  <label>ส่วนลด (%)</label>
                  <input type="number" class="form-control" id="new_pro_discount" name="new_pro_discount" value="<?php echo $sel_pro['pro_discount'];?>">
              </div>
              <div class="form-group col-xs-4">
                  <label>รูปภาพ</label>
                  <input type="file" id="image" name="image">
                  <div id="image_show">
                    <img src="<?php echo $sel_pro['pro_picture'];?>" alt="<?php echo $sel_pro['pro_name'];?>" width="270" height="360">
                  </div>
              </div>
              <div class="form-group col-md-12">
                  <label>หมายเหตุ</label>
                  <textarea class="form-control" row="3" id="new_pro_annotation" name="new_pro_annotation"><?php echo $sel_pro['pro_annotation'];?></textarea>
              </div>
              <div class="form-group col-xs-12">
                <button type="submit" name="submit" class="btn btn-success pull-right" >แก้ไข <i class="fa fa-plus-circle"></i></button>
              </div>
            </form>
            </div>
          </div>
        </div>
        <div class="col-xs-12">
          <a href="javascript:location.href='product_page.php'" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> ก่อนหน้า</a>
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
